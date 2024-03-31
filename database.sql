CREATE DATABASE IF NOT EXISTS trainer;
USE trainer;

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    gender ENUM('ชาย', 'หญิง', 'อื่นๆ') NOT NULL,
    age INT NOT NULL,
    height INT NOT NULL,
    weight INT NOT NULL,
    phone VARCHAR(20) NOT NULL UNIQUE,
    image VARCHAR(255)
);

CREATE TABLE trainer_signup(
    trainer_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    emailtrainer VARCHAR(100) NOT NULL,
    age VARCHAR(10) NOT NULL,
    phone_number VARCHAR(10) NOT NULL,
    gender ENUM('ชาย', 'หญิง', 'อื่นๆ') NOT NULL,
    level_2 VARCHAR(100),
    level_3 VARCHAR(100),
    level_4 VARCHAR(100),
    level_5 VARCHAR(100),
    level_6 VARCHAR(100),
    start_year_2 INT,
    start_year_3 INT,
    start_year_4 INT,
    start_year_5 INT,
    start_year_6 INT,
    end_year_2 INT,
    end_year_3 INT,
    end_year_4 INT,
    end_year_5 INT,
    end_year_6 INT,
    district VARCHAR(100) NOT NULL,
    subdistrict VARCHAR(100) NOT NULL,
    image_profile VARCHAR(255),  
    image VARCHAR(255)
);

CREATE TABLE accepted_trainers(
    trainer_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    emailtrainer VARCHAR(100) NOT NULL,
    age VARCHAR(10) NOT NULL,
    phone_number VARCHAR(10) NOT NULL,
    gender ENUM('ชาย', 'หญิง', 'อื่นๆ') NOT NULL,
    level_2 VARCHAR(100),
    level_3 VARCHAR(100),
    level_4 VARCHAR(100),
    level_5 VARCHAR(100),
    level_6 VARCHAR(100),
    start_year_2 INT,
    start_year_3 INT,
    start_year_4 INT,
    start_year_5 INT,
    start_year_6 INT,
    end_year_2 INT,
    end_year_3 INT,
    end_year_4 INT,
    end_year_5 INT,
    end_year_6 INT,
    district VARCHAR(100) NOT NULL,
    subdistrict VARCHAR(100) NOT NULL,
    image_profile VARCHAR(255),  
    image VARCHAR(255)
);

CREATE TABLE usertrainer(
    trainer_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admins (username, password) VALUES
('nice', '0956233803'),
('ken', '0915695877');

CREATE TABLE hired_trainers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    course_id INT,
    trainer_id INT,
    hired_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(100) NOT NULL,
  age DECIMAL(10) NOT NULL,
  gender VARCHAR(20) NOT NULL,
  phone_number VARCHAR(255) NOT NULL,
  trainer_id VARCHAR(10) NOT NULL,
  title VARCHAR(255) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  duration INT NOT NULL,
  difficulty VARCHAR(20) NOT NULL,
  description TEXT NOT NULL,
  start_date VARCHAR(20) NOT NULL,  
  end_date VARCHAR(20) NOT NULL, 
  start_time VARCHAR(11) NOT NULL,
  end_time VARCHAR(11) NOT NULL,
  cover_image VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- สร้างตาราง activities
CREATE TABLE activities (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL
);

-- สร้างตาราง course_activities
CREATE TABLE course_activities (
  course_id INT,
  activity_id INT,
  PRIMARY KEY (course_id, activity_id),
  FOREIGN KEY (course_id) REFERENCES courses(id),
  FOREIGN KEY (activity_id) REFERENCES activities(id)
);

-- ตัวอย่างข้อมูล activities
INSERT INTO activities (name) VALUES
  ('เต้นแอโรบิก'),
  ('การฝึกป้องกันตัว'),
  ('บอดี้เวท'),
  ('เวทเทรนนิ่ง'),
  ('การโยคะ'),
  ('คาดิโอ'),
  ('ลดน้ำหนัก'),
  ('การสร้างกล้ามเนื้อ'),
  ('การฝึกกลุ่ม'),
  ('การฝึกออนไลน์'),
  ('เพิ่มน้ำหนัก'),
  ('การฝึกออนไซต์');
