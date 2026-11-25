using System;
using System.Globalization;
using System.Windows.Forms;

namespace CalculatorApp
{
    public partial class Form1 : Form
    {
        private double firstNumber = 0;
        private double secondNumber = 0;
        private double result = 0;
        private string operation = "";
        private bool isOperationPerformed = false;

        public Form1()
        {
            InitializeComponent();
        }

        private void NumberButton_Click(object sender, EventArgs e)
        {
            Button button = (Button)sender;

            // Jika sebelumnya baru menekan sama dengan (=), bersihkan label operasi saat angka baru ditekan
            if (operation == "" && isOperationPerformed)
            {
                lblOperation.Text = "";
            }

            if (txtDisplay.Text == "0" || isOperationPerformed)
            {
                txtDisplay.Text = button.Text;
                isOperationPerformed = false;
            }
            else
            {
                txtDisplay.Text += button.Text;
            }
        }

        private void OperatorButton_Click(object sender, EventArgs e)
        {
            try
            {
                Button button = (Button)sender;

                if (!string.IsNullOrEmpty(txtDisplay.Text))
                {
                    firstNumber = double.Parse(txtDisplay.Text, CultureInfo.InvariantCulture);
                    operation = button.Text;
                    
                    // Update label operasi dengan angka pertama dan simbol operator
                    lblOperation.Text = $"{firstNumber} {operation}";
                    
                    isOperationPerformed = true;
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Input tidak valid: " + ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Warning);
            }
        }

        private void btnEquals_Click(object sender, EventArgs e)
        {
            if (string.IsNullOrEmpty(operation))
                return;

            try
            {
                secondNumber = double.Parse(txtDisplay.Text, CultureInfo.InvariantCulture);

                switch (operation)
                {
                    case "+":
                        result = firstNumber + secondNumber;
                        break;
                    case "-":
                    case "−":
                        result = firstNumber - secondNumber;
                        break;
                    case "*":
                    case "×":
                        result = firstNumber * secondNumber;
                        break;
                    case "/":
                    case "÷":
                        if (secondNumber == 0)
                        {
                            throw new DivideByZeroException("Tidak dapat membagi dengan angka nol.");
                        }
                        result = firstNumber / secondNumber;
                        break;
                    default:
                        result = secondNumber;
                        break;
                }

                // Tampilkan kalkulasi lengkap di display riwayat (contoh: 12 + 5 =)
                lblOperation.Text = $"{firstNumber} {operation} {secondNumber} =";
                txtDisplay.Text = result.ToString(CultureInfo.InvariantCulture);
                
                firstNumber = result;
                operation = "";
                isOperationPerformed = true;
            }
            catch (DivideByZeroException ex)
            {
                MessageBox.Show(ex.Message, "Aritmatika Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
                ResetCalculator();
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "Terjadi Kesalahan", MessageBoxButtons.OK, MessageBoxIcon.Error);
                ResetCalculator();
            }
        }

        private void btnClear_Click(object sender, EventArgs e)
        {
            ResetCalculator();
        }

        private void btnDecimal_Click(object sender, EventArgs e)
        {
            if (isOperationPerformed)
            {
                txtDisplay.Text = "0.";
                isOperationPerformed = false;
                return;
            }

            if (!txtDisplay.Text.Contains("."))
            {
                txtDisplay.Text += ".";
            }
        }

        private void ResetCalculator()
        {
            firstNumber = 0;
            secondNumber = 0;
            result = 0;
            operation = "";
            txtDisplay.Text = "0";
            lblOperation.Text = "";
            isOperationPerformed = false;
        }
    }
}