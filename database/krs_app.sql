-- SIMAK - Sistem Informasi Akademik
-- Database: krs_app
-- Created: 2025-07-30

-- Drop database if exists
DROP DATABASE IF EXISTS krs_app;

-- Create database
CREATE DATABASE krs_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use database
USE krs_app;

-- Create migrations table
CREATE TABLE migrations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    batch INT NOT NULL
);

-- Create students table
CREATE TABLE students (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    major VARCHAR(255) NOT NULL,
    semester VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Create admins table
CREATE TABLE admins (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL DEFAULT 'admin',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Create courses table
CREATE TABLE courses (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    credits INT NOT NULL,
    semester VARCHAR(255) NOT NULL,
    day VARCHAR(255) NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    room VARCHAR(255) NOT NULL,
    lecturer VARCHAR(255) NOT NULL,
    quota INT NOT NULL,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Create student_courses table
CREATE TABLE student_courses (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id BIGINT UNSIGNED NOT NULL,
    course_id BIGINT UNSIGNED NOT NULL,
    academic_year VARCHAR(255) NOT NULL,
    semester VARCHAR(255) NOT NULL,
    status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
    notes TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    UNIQUE KEY unique_student_course (student_id, course_id, academic_year, semester),
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Insert sample data

-- Insert students
INSERT INTO students (nim, name, email, password, major, semester, created_at, updated_at) VALUES
('2021001', 'Ahmad Fauzi', 'ahmad.fauzi@student.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sistem Informasi', '5', NOW(), NOW()),
('2021002', 'Siti Nurhaliza', 'siti.nurhaliza@student.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sistem Informasi', '5', NOW(), NOW()),
('2021003', 'Budi Santoso', 'budi.santoso@student.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Teknik Informatika', '3', NOW(), NOW()),
('2021004', 'Dewi Sartika', 'dewi.sartika@student.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Teknik Informatika', '3', NOW(), NOW()),
('2021005', 'Rizki Pratama', 'rizki.pratama@student.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sistem Informasi', '7', NOW(), NOW());

-- Insert admins
INSERT INTO admins (username, name, email, password, role, created_at, updated_at) VALUES
('admin', 'Administrator', 'admin@simak.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW(), NOW()),
('koordinator', 'Koordinator SIM', 'koordinator@simak.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW(), NOW());

-- Insert courses
INSERT INTO courses (code, name, description, credits, semester, day, start_time, end_time, room, lecturer, quota, is_active, created_at, updated_at) VALUES
('IF101', 'Pemrograman Dasar', 'Mata kuliah dasar pemrograman menggunakan bahasa C++', 3, '1', 'Senin', '08:00:00', '10:30:00', 'Lab 1', 'Dr. Bambang Sutrisno', 30, 1, NOW(), NOW()),
('IF102', 'Algoritma dan Struktur Data', 'Mata kuliah tentang algoritma dan struktur data dasar', 3, '2', 'Selasa', '08:00:00', '10:30:00', 'Lab 2', 'Dr. Siti Aminah', 25, 1, NOW(), NOW()),
('IF201', 'Pemrograman Web', 'Mata kuliah pemrograman web menggunakan HTML, CSS, dan JavaScript', 3, '3', 'Rabu', '13:00:00', '15:30:00', 'Lab 3', 'Ir. Ahmad Hidayat', 30, 1, NOW(), NOW()),
('IF202', 'Basis Data', 'Mata kuliah tentang konsep dan implementasi basis data', 3, '3', 'Kamis', '08:00:00', '10:30:00', 'Lab 4', 'Dr. Rina Mardiana', 28, 1, NOW(), NOW()),
('IF301', 'Pemrograman Berorientasi Objek', 'Mata kuliah pemrograman berorientasi objek menggunakan Java', 3, '5', 'Senin', '13:00:00', '15:30:00', 'Lab 1', 'Ir. Budi Santoso', 25, 1, NOW(), NOW()),
('IF302', 'Jaringan Komputer', 'Mata kuliah tentang konsep dan implementasi jaringan komputer', 3, '5', 'Selasa', '13:00:00', '15:30:00', 'Lab 2', 'Dr. Hendra Wijaya', 20, 1, NOW(), NOW()),
('IF401', 'Pemrograman Mobile', 'Mata kuliah pengembangan aplikasi mobile', 3, '7', 'Rabu', '08:00:00', '10:30:00', 'Lab 3', 'Ir. Dian Kusuma', 22, 1, NOW(), NOW()),
('IF402', 'Kecerdasan Buatan', 'Mata kuliah tentang konsep dan implementasi kecerdasan buatan', 3, '7', 'Kamis', '13:00:00', '15:30:00', 'Lab 4', 'Dr. Eko Prasetyo', 18, 1, NOW(), NOW()),
('SI101', 'Pengantar Sistem Informasi', 'Mata kuliah pengantar sistem informasi', 3, '1', 'Jumat', '08:00:00', '10:30:00', 'Ruang 101', 'Dr. Sri Wahyuni', 35, 1, NOW(), NOW()),
('SI201', 'Analisis dan Perancangan Sistem', 'Mata kuliah analisis dan perancangan sistem informasi', 3, '3', 'Jumat', '13:00:00', '15:30:00', 'Ruang 102', 'Ir. Joko Widodo', 30, 1, NOW(), NOW());

-- Insert sample KRS data
INSERT INTO student_courses (student_id, course_id, academic_year, semester, status, created_at, updated_at) VALUES
(1, 5, '2024/2025', 'Ganjil', 'pending', NOW(), NOW()),
(1, 6, '2024/2025', 'Ganjil', 'pending', NOW(), NOW()),
(2, 5, '2024/2025', 'Ganjil', 'approved', NOW(), NOW()),
(3, 3, '2024/2025', 'Ganjil', 'pending', NOW(), NOW()),
(3, 4, '2024/2025', 'Ganjil', 'pending', NOW(), NOW());

-- Create indexes for better performance
CREATE INDEX idx_students_nim ON students(nim);
CREATE INDEX idx_students_email ON students(email);
CREATE INDEX idx_admins_username ON admins(username);
CREATE INDEX idx_admins_email ON admins(email);
CREATE INDEX idx_courses_code ON courses(code);
CREATE INDEX idx_courses_active ON courses(is_active);
CREATE INDEX idx_student_courses_student ON student_courses(student_id);
CREATE INDEX idx_student_courses_course ON student_courses(course_id);
CREATE INDEX idx_student_courses_status ON student_courses(status);

-- Show table structure
SHOW TABLES;

-- Show sample data
SELECT 'Students' as table_name, COUNT(*) as count FROM students
UNION ALL
SELECT 'Admins', COUNT(*) FROM admins
UNION ALL
SELECT 'Courses', COUNT(*) FROM courses
UNION ALL
SELECT 'Student Courses', COUNT(*) FROM student_courses; 