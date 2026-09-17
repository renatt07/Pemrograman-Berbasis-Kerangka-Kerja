namespace CalculatorApp
{
    partial class Form1
    {
        private System.ComponentModel.IContainer components = null;

        private System.Windows.Forms.Label lblTitle;
        private System.Windows.Forms.Label lblOperation;
        private System.Windows.Forms.TextBox txtDisplay;
        private System.Windows.Forms.Button btn7;
        private System.Windows.Forms.Button btn8;
        private System.Windows.Forms.Button btn9;
        private System.Windows.Forms.Button btnDivide;
        private System.Windows.Forms.Button btn4;
        private System.Windows.Forms.Button btn5;
        private System.Windows.Forms.Button btn6;
        private System.Windows.Forms.Button btnMultiply;
        private System.Windows.Forms.Button btn1;
        private System.Windows.Forms.Button btn2;
        private System.Windows.Forms.Button btn3;
        private System.Windows.Forms.Button btnMinus;
        private System.Windows.Forms.Button btn0;
        private System.Windows.Forms.Button btnDecimal;
        private System.Windows.Forms.Button btnClear;
        private System.Windows.Forms.Button btnPlus;
        private System.Windows.Forms.Button btnEquals;

        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        private void InitializeComponent()
        {
            this.lblTitle = new System.Windows.Forms.Label();
            this.lblOperation = new System.Windows.Forms.Label();
            this.txtDisplay = new System.Windows.Forms.TextBox();
            this.btn7 = new System.Windows.Forms.Button();
            this.btn8 = new System.Windows.Forms.Button();
            this.btn9 = new System.Windows.Forms.Button();
            this.btnDivide = new System.Windows.Forms.Button();
            this.btn4 = new System.Windows.Forms.Button();
            this.btn5 = new System.Windows.Forms.Button();
            this.btn6 = new System.Windows.Forms.Button();
            this.btnMultiply = new System.Windows.Forms.Button();
            this.btn1 = new System.Windows.Forms.Button();
            this.btn2 = new System.Windows.Forms.Button();
            this.btn3 = new System.Windows.Forms.Button();
            this.btnMinus = new System.Windows.Forms.Button();
            this.btn0 = new System.Windows.Forms.Button();
            this.btnDecimal = new System.Windows.Forms.Button();
            this.btnClear = new System.Windows.Forms.Button();
            this.btnPlus = new System.Windows.Forms.Button();
            this.btnEquals = new System.Windows.Forms.Button();
            this.SuspendLayout();

            // Palet Warna & Font
            System.Drawing.Color darkBg = System.Drawing.Color.FromArgb(28, 30, 36);
            System.Drawing.Color displayBg = System.Drawing.Color.FromArgb(36, 39, 48);
            System.Drawing.Color numBtnBg = System.Drawing.Color.FromArgb(47, 52, 63);
            System.Drawing.Color opBtnBg = System.Drawing.Color.FromArgb(245, 130, 32);
            System.Drawing.Color clearBtnBg = System.Drawing.Color.FromArgb(220, 53, 69);
            System.Drawing.Color textLight = System.Drawing.Color.White;

            // lblTitle
            this.lblTitle.AutoSize = true;
            this.lblTitle.Font = new System.Drawing.Font("Segoe UI", 11F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point);
            this.lblTitle.ForeColor = System.Drawing.Color.FromArgb(170, 175, 190);
            this.lblTitle.Location = new System.Drawing.Point(18, 14);
            this.lblTitle.Name = "lblTitle";
            this.lblTitle.Size = new System.Drawing.Size(126, 25);
            this.lblTitle.TabIndex = 0;
            this.lblTitle.Text = "CALCULATOR";

            // lblOperation (Display secondary untuk riwayat/operasi aktif)
            this.lblOperation.Font = new System.Drawing.Font("Segoe UI", 10.5F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point);
            this.lblOperation.ForeColor = System.Drawing.Color.FromArgb(140, 145, 160);
            this.lblOperation.Location = new System.Drawing.Point(18, 48);
            this.lblOperation.Name = "lblOperation";
            this.lblOperation.Size = new System.Drawing.Size(288, 24);
            this.lblOperation.TabIndex = 1;
            this.lblOperation.Text = "";
            this.lblOperation.TextAlign = System.Drawing.ContentAlignment.MiddleRight;

            // txtDisplay
            this.txtDisplay.BackColor = displayBg;
            this.txtDisplay.BorderStyle = System.Windows.Forms.BorderStyle.None;
            this.txtDisplay.Font = new System.Drawing.Font("Segoe UI", 24F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point);
            this.txtDisplay.ForeColor = textLight;
            this.txtDisplay.Location = new System.Drawing.Point(18, 76);
            this.txtDisplay.Name = "txtDisplay";
            this.txtDisplay.ReadOnly = true;
            this.txtDisplay.Size = new System.Drawing.Size(288, 54);
            this.txtDisplay.TabIndex = 2;
            this.txtDisplay.Text = "0";
            this.txtDisplay.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;

            // Method helper setup tombol
            void FormatButton(System.Windows.Forms.Button btn, string text, int x, int y, int w, int h, System.Drawing.Color bg, System.Drawing.Color fg, float fontSize)
            {
                btn.Text = text;
                btn.Location = new System.Drawing.Point(x, y);
                btn.Size = new System.Drawing.Size(w, h);
                btn.BackColor = bg;
                btn.ForeColor = fg;
                btn.Font = new System.Drawing.Font("Segoe UI", fontSize, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point);
                btn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
                btn.FlatAppearance.BorderSize = 0;
                btn.Cursor = System.Windows.Forms.Cursors.Hand;
                btn.UseVisualStyleBackColor = false;
            }

            // Baris 1: 7, 8, 9, ÷
            FormatButton(this.btn7, "7", 18, 145, 66, 52, numBtnBg, textLight, 13F);
            this.btn7.Click += new System.EventHandler(this.NumberButton_Click);

            FormatButton(this.btn8, "8", 92, 145, 66, 52, numBtnBg, textLight, 13F);
            this.btn8.Click += new System.EventHandler(this.NumberButton_Click);

            FormatButton(this.btn9, "9", 166, 145, 66, 52, numBtnBg, textLight, 13F);
            this.btn9.Click += new System.EventHandler(this.NumberButton_Click);

            FormatButton(this.btnDivide, "÷", 240, 145, 66, 52, opBtnBg, textLight, 15F);
            this.btnDivide.Click += new System.EventHandler(this.OperatorButton_Click);

            // Baris 2: 4, 5, 6, ×
            FormatButton(this.btn4, "4", 18, 205, 66, 52, numBtnBg, textLight, 13F);
            this.btn4.Click += new System.EventHandler(this.NumberButton_Click);

            FormatButton(this.btn5, "5", 92, 205, 66, 52, numBtnBg, textLight, 13F);
            this.btn5.Click += new System.EventHandler(this.NumberButton_Click);

            FormatButton(this.btn6, "6", 166, 205, 66, 52, numBtnBg, textLight, 13F);
            this.btn6.Click += new System.EventHandler(this.NumberButton_Click);

            FormatButton(this.btnMultiply, "×", 240, 205, 66, 52, opBtnBg, textLight, 15F);
            this.btnMultiply.Click += new System.EventHandler(this.OperatorButton_Click);

            // Baris 3: 1, 2, 3, −
            FormatButton(this.btn1, "1", 18, 265, 66, 52, numBtnBg, textLight, 13F);
            this.btn1.Click += new System.EventHandler(this.NumberButton_Click);

            FormatButton(this.btn2, "2", 92, 265, 66, 52, numBtnBg, textLight, 13F);
            this.btn2.Click += new System.EventHandler(this.NumberButton_Click);

            FormatButton(this.btn3, "3", 166, 265, 66, 52, numBtnBg, textLight, 13F);
            this.btn3.Click += new System.EventHandler(this.NumberButton_Click);

            FormatButton(this.btnMinus, "−", 240, 265, 66, 52, opBtnBg, textLight, 15F);
            this.btnMinus.Click += new System.EventHandler(this.OperatorButton_Click);

            // Baris 4: 0, ., C, +
            FormatButton(this.btn0, "0", 18, 325, 66, 52, numBtnBg, textLight, 13F);
            this.btn0.Click += new System.EventHandler(this.NumberButton_Click);

            FormatButton(this.btnDecimal, ".", 92, 325, 66, 52, numBtnBg, textLight, 15F);
            this.btnDecimal.Click += new System.EventHandler(this.btnDecimal_Click);

            FormatButton(this.btnClear, "C", 166, 325, 66, 52, clearBtnBg, textLight, 13F);
            this.btnClear.Click += new System.EventHandler(this.btnClear_Click);

            FormatButton(this.btnPlus, "+", 240, 325, 66, 52, opBtnBg, textLight, 15F);
            this.btnPlus.Click += new System.EventHandler(this.OperatorButton_Click);

            // Baris 5: =
            FormatButton(this.btnEquals, "=", 18, 385, 288, 52, System.Drawing.Color.FromArgb(40, 167, 69), textLight, 16F);
            this.btnEquals.Click += new System.EventHandler(this.btnEquals_Click);

            // Form1 Settings
            this.AutoScaleDimensions = new System.Drawing.SizeF(8F, 20F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.BackColor = darkBg;
            this.ClientSize = new System.Drawing.Size(324, 455);
            this.Controls.Add(this.btnEquals);
            this.Controls.Add(this.btnPlus);
            this.Controls.Add(this.btnClear);
            this.Controls.Add(this.btnDecimal);
            this.Controls.Add(this.btn0);
            this.Controls.Add(this.btnMinus);
            this.Controls.Add(this.btn3);
            this.Controls.Add(this.btn2);
            this.Controls.Add(this.btn1);
            this.Controls.Add(this.btnMultiply);
            this.Controls.Add(this.btn6);
            this.Controls.Add(this.btn5);
            this.Controls.Add(this.btn4);
            this.Controls.Add(this.btnDivide);
            this.Controls.Add(this.btn9);
            this.Controls.Add(this.btn8);
            this.Controls.Add(this.btn7);
            this.Controls.Add(this.txtDisplay);
            this.Controls.Add(this.lblOperation);
            this.Controls.Add(this.lblTitle);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedDialog;
            this.MaximizeBox = false;
            this.Name = "Form1";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "Calculator Desktop";
            this.ResumeLayout(false);
            this.PerformLayout();
        }
    }
}