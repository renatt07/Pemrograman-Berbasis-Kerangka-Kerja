using System.Windows;
using StudentRegistration.ViewModels;

namespace StudentRegistration;

public partial class MainWindow : Window
{
    public MainWindow()
    {
        InitializeComponent();
        DataContext = new StudentViewModel();
    }
}