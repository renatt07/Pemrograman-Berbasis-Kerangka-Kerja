using StudentRegistration.Models;
using StudentRegistration.Repositories;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Linq;
using System.Runtime.CompilerServices;
using System.Windows;
using System.Windows.Input;

namespace StudentRegistration.ViewModels;

public class StudentViewModel : INotifyPropertyChanged
{
    private readonly StudentRepository _repository;

    public ObservableCollection<Student> Students { get; } = new();
    public List<Program> ProgramsList { get; private set; } = new();

    private Student? _selectedStudent;
    public Student? SelectedStudent
    {
        get => _selectedStudent;
        set { _selectedStudent = value; OnPropertyChanged(); }
    }

    private string _searchText = string.Empty;
    public string SearchText
    {
        get => _searchText;
        set { _searchText = value; OnPropertyChanged(); }
    }

    // Statistik Ringkasan Data
    public int TotalTI => Students.Count(x => x.ProgramName == "Teknik Informatika");
    public int TotalSI => Students.Count(x => x.ProgramName == "Sistem Informasi");
    public int TotalMNJ => Students.Count(x => x.ProgramName == "Manajemen");
    public int TotalTE => Students.Count(x => x.ProgramName == "Teknik Elektro");
    public int TotalDKV => Students.Count(x => x.ProgramName == "Desain Komunikasi Visual");

    private int _totalStudentsCount;
    public int TotalStudentsCount
    {
        get => _totalStudentsCount;
        set 
        { 
            _totalStudentsCount = value; 
            OnPropertyChanged(); 
        }
    }

    // Commands
    public ICommand RefreshCommand { get; }
    public ICommand SearchCommand { get; }

    public StudentViewModel()
    {
        _repository = new StudentRepository();
        RefreshCommand = new RelayCommand(LoadData);
        SearchCommand = new RelayCommand(Search);

        LoadData();
    }

    private void LoadData()
    {
        try
        {
            ProgramsList = _repository.GetPrograms();
            OnPropertyChanged(nameof(ProgramsList));

            TotalStudentsCount = _repository.GetTotalStudentsCount();

            var data = _repository.GetAll();
            UpdateDataGrid(data);
        }
        catch (Exception ex)
        {
            MessageBox.Show($"Gagal terhubung ke SQL Server:\n{ex.Message}", "Database Error", MessageBoxButton.OK, MessageBoxImage.Error);
        }
    }

    private void Search()
    {
        try
        {
            var data = string.IsNullOrWhiteSpace(SearchText) 
                ? _repository.GetAll() 
                : _repository.Search(SearchText);

            UpdateDataGrid(data);
        }
        catch (Exception ex)
        {
            MessageBox.Show($"Pencarian gagal:\n{ex.Message}", "Error", MessageBoxButton.OK, MessageBoxImage.Error);
        }
    }

    private void UpdateDataGrid(List<Student> list)
    {
        Students.Clear();
        foreach (var item in list)
        {
            Students.Add(item);
        }
        RefreshStatistics();
    }

    private void RefreshStatistics()
    {
        OnPropertyChanged(nameof(TotalStudentsCount));
        OnPropertyChanged(nameof(TotalTI));
        OnPropertyChanged(nameof(TotalSI));
        OnPropertyChanged(nameof(TotalMNJ));
        OnPropertyChanged(nameof(TotalTE));
        OnPropertyChanged(nameof(TotalDKV));
    }

    public event PropertyChangedEventHandler? PropertyChanged;
    protected void OnPropertyChanged([CallerMemberName] string? propertyName = null)
    {
        PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(propertyName));
    }
}