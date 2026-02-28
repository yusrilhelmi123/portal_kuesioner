-- Database Schema for Kuisioner PM

CREATE DATABASE IF NOT EXISTS kuisioner_pm;
USE kuisioner_pm;

-- Students table
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    npm VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255) NOT NULL,
    vark_type VARCHAR(10) DEFAULT NULL,
    mslq_score FLOAT DEFAULT NULL,
    ams_type VARCHAR(20) DEFAULT NULL,
    is_approved TINYINT(1) DEFAULT 0, -- 0: Pending, 1: Approved
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admin table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- System Settings (Open/Close Questionnaire)
CREATE TABLE IF NOT EXISTS system_settings (
    setting_key VARCHAR(50) PRIMARY KEY,
    setting_value TINYINT(1) DEFAULT 1 -- 1: Open, 0: Closed
);

-- Insert initial settings
INSERT IGNORE INTO system_settings (setting_key, setting_value) VALUES 
('vark_open', 1),
('mslq_open', 1),
('ams_open', 1);

-- VARK Questions
CREATE TABLE IF NOT EXISTS vark_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teks_pertanyaan TEXT NOT NULL,
    opt_v TEXT NOT NULL,
    opt_a TEXT NOT NULL,
    opt_r TEXT NOT NULL,
    opt_k TEXT NOT NULL
);

-- MSLQ Questions
CREATE TABLE IF NOT EXISTS mslq_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teks_pertanyaan TEXT NOT NULL,
    dimensi VARCHAR(50) NOT NULL
);

-- AMS Questions
CREATE TABLE IF NOT EXISTS ams_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teks_pertanyaan TEXT NOT NULL,
    kategori VARCHAR(50) NOT NULL
);

-- Student Responses
CREATE TABLE IF NOT EXISTS responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    tipe_pertanyaan ENUM('VARK', 'MSLQ', 'AMS') NOT NULL,
    question_id INT NOT NULL,
    nilai_jawaban VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);
