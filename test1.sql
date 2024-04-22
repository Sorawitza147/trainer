CREATE TABLE finish_course (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    course_id INT,
    id_payment VARCHAR(255) NOT NULL,
    name VARCHAR(255),
    username VARCHAR(255),
    trainerusername VARCHAR(255) NOT NULL,
    title VARCHAR(255),
    description TEXT,
    price DECIMAL(10, 2),
    end_date  VARCHAR(20) NOT NULL,
    start_date  VARCHAR(20) NOT NULL,
    start_time TIME,
    end_time TIME,
    bank VARCHAR(100) NOT NULL,
    account_number INT NOT NULL
);

CREATE TABLE IF NOT EXISTS payment_trainer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trainerusername VARCHAR(255) NOT NULL,
    id_payment VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status_payment VARCHAR(50) NOT NULL,
    reason TEXT
);

CREATE TABLE course_history_trainer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    trainerusername VARCHAR(255) NOT NULL,
    course_id INT NOT NULL,
    course VARCHAR(255),
    payment_id VARCHAR(255),
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

CREATE TABLE hired_trainers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    course VARCHAR(255),
    payment_id VARCHAR(255),
    username VARCHAR(50),
    trainerusername VARCHAR(100) NOT NULL,
    trainer_id INT,
    hired_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) DEFAULT NULL,
    image_payment VARCHAR(255) NOT NULL,
    payment_status VARCHAR(50) DEFAULT NULL
);

CREATE TABLE accepted_course (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT ,
    payment_id VARCHAR(255),
    course VARCHAR(255),
    name VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    trainerusername VARCHAR(255) NOT NULL,
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
