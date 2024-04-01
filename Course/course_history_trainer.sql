CREATE TABLE hired_trainers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    username VARCHAR(50),
    trainerusername VARCHAR(100) NOT NULL,
    trainer_id INT,
    hired_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) DEFAULT NULL
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
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    age INT NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    difficulty ENUM('Beginner', 'Intermediate', 'Advanced') NOT NULL,
    start_date VARCHAR(20) NOT NULL,  
    end_date VARCHAR(20) NOT NULL, 
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    activities TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);