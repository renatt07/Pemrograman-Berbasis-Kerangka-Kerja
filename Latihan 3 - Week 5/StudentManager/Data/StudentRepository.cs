using Microsoft.Data.SqlClient;
using StudentManager.Models;
using System;
using System.Collections.Generic;

namespace StudentManager.Data;

public class StudentRepository
{
    private readonly string connectionString = 
    @"Server=(localdb)\MSSQLLocalDB;
    Database=StudentDB;
    Trusted_Connection=True;
    TrustServerCertificate=True;";
    
    // 1. READ (Membaca semua data)
    public List<Student> GetAll()
    {
        var students = new List<Student>();
        using SqlConnection connection = new SqlConnection(connectionString);
        string sql = "SELECT Id, NIM, Nama, Jurusan, Gender, Email FROM Students ORDER BY Id DESC";
        using SqlCommand command = new SqlCommand(sql, connection);
        
        connection.Open();
        using SqlDataReader reader = command.ExecuteReader();
        while (reader.Read())
        {
            students.Add(new Student
            {
                Id = Convert.ToInt32(reader["Id"]),
                NIM = reader["NIM"].ToString()!,
                Nama = reader["Nama"].ToString()!,
                Jurusan = reader["Jurusan"].ToString()!,
                Gender = reader["Gender"].ToString()!,
                Email = reader["Email"].ToString()!
            });
        }
        return students;
    }

    // 2. INSERT (Menambah data baru)
    public void Insert(Student student)
    {
        using SqlConnection connection = new SqlConnection(connectionString);
        string sql = "INSERT INTO Students (NIM, Nama, Jurusan, Gender, Email) VALUES (@NIM, @Nama, @Jurusan, @Gender, @Email)";
        using SqlCommand command = new SqlCommand(sql, connection);
        
        command.Parameters.AddWithValue("@NIM", student.NIM);
        command.Parameters.AddWithValue("@Nama", student.Nama);
        command.Parameters.AddWithValue("@Jurusan", student.Jurusan);
        command.Parameters.AddWithValue("@Gender", student.Gender);
        command.Parameters.AddWithValue("@Email", student.Email);
        
        connection.Open();
        command.ExecuteNonQuery();
    }

    // 3. UPDATE (Mengubah data)
    public void Update(Student student)
    {
        using SqlConnection connection = new SqlConnection(connectionString);
        string sql = "UPDATE Students SET NIM=@NIM, Nama=@Nama, Jurusan=@Jurusan, Gender=@Gender, Email=@Email WHERE Id=@Id";
        using SqlCommand command = new SqlCommand(sql, connection);
        
        command.Parameters.AddWithValue("@Id", student.Id);
        command.Parameters.AddWithValue("@NIM", student.NIM);
        command.Parameters.AddWithValue("@Nama", student.Nama);
        command.Parameters.AddWithValue("@Jurusan", student.Jurusan);
        command.Parameters.AddWithValue("@Gender", student.Gender);
        command.Parameters.AddWithValue("@Email", student.Email);
        
        connection.Open();
        command.ExecuteNonQuery();
    }

    // 4. DELETE (Menghapus data)
    public void Delete(int id)
    {
        using SqlConnection connection = new SqlConnection(connectionString);
        using SqlCommand command = new SqlCommand("DELETE FROM Students WHERE Id=@Id", connection);
        
        command.Parameters.AddWithValue("@Id", id);
        
        connection.Open();
        command.ExecuteNonQuery();
    }

    // 5. SEARCH (Mencari data)
    public List<Student> Search(string keyword)
    {
        var students = new List<Student>();
        using SqlConnection connection = new SqlConnection(connectionString);
        string sql = "SELECT Id, NIM, Nama, Jurusan, Gender, Email FROM Students WHERE NIM LIKE @Keyword OR Nama LIKE @Keyword OR Jurusan LIKE @Keyword ORDER BY Id DESC";
        using SqlCommand command = new SqlCommand(sql, connection);
        
        command.Parameters.AddWithValue("@Keyword", "%" + keyword + "%");
        
        connection.Open();
        using SqlDataReader reader = command.ExecuteReader();
        while (reader.Read())
        {
            students.Add(new Student
            {
                Id = Convert.ToInt32(reader["Id"]),
                NIM = reader["NIM"].ToString()!,
                Nama = reader["Nama"].ToString()!,
                Jurusan = reader["Jurusan"].ToString()!,
                Gender = reader["Gender"].ToString()!,
                Email = reader["Email"].ToString()!
            });
        }
        return students;
    }
    // 6. Cek apakah NRP sudah digunakan oleh mahasiswa lain
    public bool IsNrpExists(string nrp, int excludeId = 0)
    {
        using SqlConnection connection = new SqlConnection(connectionString);
        string sql = "SELECT COUNT(1) FROM Students WHERE NIM = @NIM AND Id <> @ExcludeId";
        using SqlCommand command = new SqlCommand(sql, connection);
        command.Parameters.AddWithValue("@NIM", nrp);
        command.Parameters.AddWithValue("@ExcludeId", excludeId);
        
        connection.Open();
        int count = Convert.ToInt32(command.ExecuteScalar());
        return count > 0;
    }

    // 7. Cek apakah ada data yang sama persis seluruh kolomnya
    public bool IsExactDuplicate(Student student)
    {
        using SqlConnection connection = new SqlConnection(connectionString);
        string sql = @"SELECT COUNT(1) FROM Students 
                    WHERE NIM = @NIM AND Nama = @Nama AND Jurusan = @Jurusan AND Gender = @Gender AND Email = @Email 
                    AND Id <> @ExcludeId";
        using SqlCommand command = new SqlCommand(sql, connection);
        command.Parameters.AddWithValue("@NIM", student.NIM ?? "");
        command.Parameters.AddWithValue("@Nama", student.Nama ?? "");
        command.Parameters.AddWithValue("@Jurusan", student.Jurusan ?? "");
        command.Parameters.AddWithValue("@Gender", student.Gender ?? "");
        command.Parameters.AddWithValue("@Email", student.Email ?? "");
        command.Parameters.AddWithValue("@ExcludeId", student.Id);
        
        connection.Open();
        int count = Convert.ToInt32(command.ExecuteScalar());
        return count > 0;
    }
}