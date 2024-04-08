CREATE TABLE accepted_course (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT ,
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

CREATE TABLE finish_course (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    course_id INT,
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

CREATE TABLE IF NOT EXISTS payment_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trainerusername VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
