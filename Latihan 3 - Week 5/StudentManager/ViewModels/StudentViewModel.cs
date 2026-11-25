using StudentManager.Models;
using StudentManager.Data;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Runtime.CompilerServices;
using System.Windows.Input;
using System.Linq;
using System.Windows;

namespace StudentManager.ViewModels;

public class StudentViewModel : INotifyPropertyChanged
{
    private readonly StudentRepository _repository;
    
    public ObservableCollection<Student> Students { get; } = new();
    
    private Student? _selectedStudent;
    public Student? SelectedStudent
    {
        get => _selectedStudent;
        set
        {
            _selectedStudent = value;
            OnPropertyChanged();
        }
    }
    
    private string _searchText = "";
    public string SearchText
    {
        get => _searchText;
        set
        {
            _searchText = value;
            OnPropertyChanged();
        }
    }
    
    // Logik Pengiraan Statistik
    public int TotalStudents => Students.Count;
    public int TotalTeknikInformatika => Students.Count(x => x.Jurusan == "Teknik Informatika");
    public int TotalSistemInformasi => Students.Count(x => x.Jurusan == "Sistem Informasi");
    public int TotalTeknologiInformasi => Students.Count(x => x.Jurusan == "Teknologi Informasi");
    public int TotalTeknikKomputer => Students.Count(x => x.Jurusan == "Teknik Komputer");
    public int TotalTeknikElektro => Students.Count(x => x.Jurusan == "Teknik Elektro");
    public int TotalLakiLaki => Students.Count(x => x.Gender == "Laki-laki");
    public int TotalPerempuan => Students.Count(x => x.Gender == "Perempuan");
    
    // Arahan/Commands
    public ICommand SaveCommand { get; }
    public ICommand DeleteCommand { get; }
    public ICommand ResetCommand { get; }
    public ICommand SearchCommand { get; }
    
    public StudentViewModel()
    {
        _repository = new StudentRepository();
        LoadData();
        SelectedStudent = new Student(); // Sediakan data kosong di awal
        
        SaveCommand = new RelayCommand(Save);
        DeleteCommand = new RelayCommand(Delete);
        ResetCommand = new RelayCommand(Reset);
        SearchCommand = new RelayCommand(Search);
    }
    
    private void LoadData()
    {
        Students.Clear();
        foreach (var student in _repository.GetAll())
        {
            Students.Add(student);
        }
        RefreshStatistics();
    }
    
    private void Save()
    {
        if (SelectedStudent == null) return;

        // 1. Validasi Input Tidak Lengkap
        if (string.IsNullOrWhiteSpace(SelectedStudent.NIM) ||
            string.IsNullOrWhiteSpace(SelectedStudent.Nama) ||
            string.IsNullOrWhiteSpace(SelectedStudent.Jurusan) ||
            string.IsNullOrWhiteSpace(SelectedStudent.Gender) ||
            string.IsNullOrWhiteSpace(SelectedStudent.Email))
        {
            MessageBox.Show("Gagal menyimpan data!\nSemua kolom input (NRP, Nama, Jurusan, Gender, Email) wajib diisi.", 
                            "Input Tidak Lengkap", MessageBoxButton.OK, MessageBoxImage.Warning);
            return;
        }

        // 2. Validasi NRP Duplikat
        if (_repository.IsNrpExists(SelectedStudent.NIM, SelectedStudent.Id))
        {
            MessageBox.Show($"Gagal menyimpan!\nNRP '{SelectedStudent.NIM}' sudah terdaftar pada sistem.", 
                            "NRP Duplikat", MessageBoxButton.OK, MessageBoxImage.Error);
            return;
        }

        // 3. Validasi Data Sama Persis (Exact Duplicate)
        if (_repository.IsExactDuplicate(SelectedStudent))
        {
            MessageBox.Show("Gagal menyimpan!\nData mahasiswa dengan rincian yang sama persis sudah ada di sistem.", 
                            "Data Duplikat", MessageBoxButton.OK, MessageBoxImage.Warning);
            return;
        }

        // Eksekusi Simpan / Update dengan Feedback Success Box
        try
        {
            if (SelectedStudent.Id == 0)
            {
                _repository.Insert(SelectedStudent);
                MessageBox.Show("Berhasil!\nData mahasiswa baru berhasil ditambahkan.", 
                                "Tambah Data Sukses", MessageBoxButton.OK, MessageBoxImage.Information);
            }
            else
            {
                _repository.Update(SelectedStudent);
                MessageBox.Show("Berhasil!\nData mahasiswa berhasil diperbarui.", 
                                "Update Sukses", MessageBoxButton.OK, MessageBoxImage.Information);
            }

            LoadData();
            Reset();
        }
        catch (System.Exception ex)
        {
            MessageBox.Show($"Terjadi kesalahan sistem:\n{ex.Message}", 
                            "Error", MessageBoxButton.OK, MessageBoxImage.Error);
        }
    }

    private void Delete()
    {
        if (SelectedStudent == null || SelectedStudent.Id == 0)
        {
            MessageBox.Show("Pilih data mahasiswa dari tabel terlebih dahulu yang ingin dihapus!", 
                            "Peringatan Hapus", MessageBoxButton.OK, MessageBoxImage.Warning);
            return;
        }

        // Dialog Konfirmasi Hapus
        var confirm = MessageBox.Show($"Apakah Anda yakin ingin menghapus data '{SelectedStudent.Nama}' ({SelectedStudent.NIM})?", 
                                    "Konfirmasi Hapus", MessageBoxButton.YesNo, MessageBoxImage.Question);

        if (confirm == MessageBoxResult.Yes)
        {
            try
            {
                _repository.Delete(SelectedStudent.Id);
                MessageBox.Show("Berhasil!\nData mahasiswa telah dihapus dari sistem.", 
                                "Hapus Sukses", MessageBoxButton.OK, MessageBoxImage.Information);
                LoadData();
                Reset();
            }
            catch (System.Exception ex)
            {
                MessageBox.Show($"Terjadi kesalahan sistem saat menghapus:\n{ex.Message}", 
                                "Error", MessageBoxButton.OK, MessageBoxImage.Error);
            }
        }
    }
    
    private void Search()
    {
        var result = string.IsNullOrWhiteSpace(SearchText) 
            ? _repository.GetAll() 
            : _repository.Search(SearchText);
            
        Students.Clear();
        foreach (var student in result)
        {
            Students.Add(student);
        }
        RefreshStatistics();
    }
    
    private void Reset()
    {
        SelectedStudent = new Student();
    }
    
    private void RefreshStatistics()
    {
        OnPropertyChanged(nameof(TotalStudents));
        OnPropertyChanged(nameof(TotalTeknikInformatika));
        OnPropertyChanged(nameof(TotalSistemInformasi));
        OnPropertyChanged(nameof(TotalTeknologiInformasi));
        OnPropertyChanged(nameof(TotalTeknikKomputer));
        OnPropertyChanged(nameof(TotalTeknikElektro));
        OnPropertyChanged(nameof(TotalLakiLaki));
        OnPropertyChanged(nameof(TotalPerempuan));
    }
    
    public event PropertyChangedEventHandler? PropertyChanged;
    protected void OnPropertyChanged([CallerMemberName] string? propertyName = null)
    {
        PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(propertyName));
    }
}