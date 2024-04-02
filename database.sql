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
    image VARCHAR(255),
    bank VARCHAR(100) NOT NULL,
    account_number INT NOT NULL
);

CREATE TABLE trainer_signup(
    trainer_id INT AUTO_INCREMENT PRIMARY KEY,
    trainerusername VARCHAR(100) NOT NULL,
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
    image VARCHAR(255),
    bank VARCHAR(100) NOT NULL,
    account_number INT NOT NULL
);

CREATE TABLE accepted_trainers(
    trainer_id INT AUTO_INCREMENT PRIMARY KEY,
    trainerusername VARCHAR(100) NOT NULL,
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
    image VARCHAR(255),
    bank VARCHAR(100) NOT NULL,
    account_number INT NOT NULL
);

CREATE TABLE usertrainer(
    trainer_id INT AUTO_INCREMENT PRIMARY KEY,
    trainerusername VARCHAR(100) NOT NULL,
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

CREATE TABLE courses (
  course_id INT AUTO_INCREMENT PRIMARY KEY,
  trainerusername VARCHAR(100) NOT NULL,
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
  FOREIGN KEY (course_id) REFERENCES courses(course_id),
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

CREATE TABLE hired_trainers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    username VARCHAR(50),
    trainerusername VARCHAR(100) NOT NULL,
    trainer_id INT,
    hired_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) DEFAULT NULL,
    image_payment VARCHAR(255) NOT NULL,
    payment_status VARCHAR(50) DEFAULT NULL
);

CREATE TABLE course_history_trainer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    trainerusername VARCHAR(255) NOT NULL,
    course_id INT NOT NULL,
    trainer_id INT NOT NULL,
    status VARCHAR(50) NOT NULL,
    title VARCHAR(255) NOT NULL,
    cover_image VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    gender ENUM('ชาย', 'หญิง', 'อื่นๆ') NOT NULL,
    age INT NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    difficulty VARCHAR(20) NOT NULL,
    start_date VARCHAR(20) NOT NULL,  
    end_date VARCHAR(20) NOT NULL, 
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    activities TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    image_payment VARCHAR(255) NOT NULL,
    payment_status VARCHAR(50) DEFAULT NULL
);
CREATE TABLE IF NOT EXISTS payment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    course_title VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
    CREATE TABLE accepted_course (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
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
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) DEFAULT NULL,
    payment_status VARCHAR(50) DEFAULT NULL
    );
