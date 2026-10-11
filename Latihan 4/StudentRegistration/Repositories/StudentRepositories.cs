using Microsoft.Data.SqlClient;
using StudentRegistration.Models;
using System;
using System.Collections.Generic;

namespace StudentRegistration.Repositories;

public class StudentRepository
{
    private readonly string _connectionString = 
        @"Server=localhost;Database=StudentRegistrationDB;Trusted_Connection=True;TrustServerCertificate=True;";

    public List<Student> GetAll()
    {
        var students = new List<Student>();
        const string sql = @"
            SELECT s.StudentId, s.NIM, s.Name, s.ProgramId, p.ProgramName, 
                   s.BirthDate, s.Address, s.PhoneNumber, s.CreatedAt, s.UpdatedAt
            FROM Students s
            INNER JOIN Programs p ON s.ProgramId = p.ProgramId
            ORDER BY s.StudentId ASC";

        using var connection = new SqlConnection(_connectionString);
        using var command = new SqlCommand(sql, connection);
        
        connection.Open();
        using var reader = command.ExecuteReader();
        while (reader.Read())
        {
            students.Add(MapStudent(reader));
        }
        return students;
    }

    public List<Student> Search(string keyword)
    {
        var students = new List<Student>();
        const string sql = @"
            SELECT s.StudentId, s.NIM, s.Name, s.ProgramId, p.ProgramName, 
                   s.BirthDate, s.Address, s.PhoneNumber, s.CreatedAt, s.UpdatedAt
            FROM Students s
            INNER JOIN Programs p ON s.ProgramId = p.ProgramId
            WHERE s.NIM LIKE @Keyword OR s.Name LIKE @Keyword OR p.ProgramName LIKE @Keyword
            ORDER BY s.StudentId ASC";

        using var connection = new SqlConnection(_connectionString);
        using var command = new SqlCommand(sql, connection);
        command.Parameters.AddWithValue("@Keyword", $"%{keyword}%");

        connection.Open();
        using var reader = command.ExecuteReader();
        while (reader.Read())
        {
            students.Add(MapStudent(reader));
        }
        return students;
    }

    public int GetTotalStudentsCount()
    {
        const string sql = "SELECT COUNT(*) FROM Students;";
        
        using var connection = new SqlConnection(_connectionString);
        using var command = new SqlCommand(sql, connection);
        
        connection.Open();
        return Convert.ToInt32(command.ExecuteScalar());
    }

    public List<Program> GetPrograms()
    {
        var programs = new List<Program>();
        const string sql = "SELECT ProgramId, ProgramCode, ProgramName, IsActive FROM Programs WHERE IsActive = 1";

        using var connection = new SqlConnection(_connectionString);
        using var command = new SqlCommand(sql, connection);

        connection.Open();
        using var reader = command.ExecuteReader();
        while (reader.Read())
        {
            programs.Add(new Program
            {
                ProgramId = reader.GetInt32(reader.GetOrdinal("ProgramId")),
                ProgramCode = reader.GetString(reader.GetOrdinal("ProgramCode")),
                ProgramName = reader.GetString(reader.GetOrdinal("ProgramName")),
                IsActive = reader.GetBoolean(reader.GetOrdinal("IsActive"))
            });
        }
        return programs;
    }

    private static Student MapStudent(SqlDataReader reader)
    {
        return new Student
        {
            StudentId = reader.GetInt32(reader.GetOrdinal("StudentId")),
            NIM = reader.GetString(reader.GetOrdinal("NIM")),
            Name = reader.GetString(reader.GetOrdinal("Name")),
            ProgramId = reader.GetInt32(reader.GetOrdinal("ProgramId")),
            ProgramName = reader.GetString(reader.GetOrdinal("ProgramName")),
            BirthDate = reader.IsDBNull(reader.GetOrdinal("BirthDate")) ? null : reader.GetDateTime(reader.GetOrdinal("BirthDate")),
            Address = reader.IsDBNull(reader.GetOrdinal("Address")) ? string.Empty : reader.GetString(reader.GetOrdinal("Address")),
            PhoneNumber = reader.IsDBNull(reader.GetOrdinal("PhoneNumber")) ? string.Empty : reader.GetString(reader.GetOrdinal("PhoneNumber")),
            CreatedAt = reader.GetDateTime(reader.GetOrdinal("CreatedAt")),
            UpdatedAt = reader.IsDBNull(reader.GetOrdinal("UpdatedAt")) ? null : reader.GetDateTime(reader.GetOrdinal("UpdatedAt"))
        };
    }
}