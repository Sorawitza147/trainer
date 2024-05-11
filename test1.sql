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
    duration VARCHAR(50) DEFAULT NULL,
    image_payment VARCHAR(255) NOT NULL,
    countdown_start TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    payment_status VARCHAR(50) DEFAULT NULL
);