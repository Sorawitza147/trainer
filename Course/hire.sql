CREATE TABLE hired_trainers (
    id AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    username VARCHAR(50),
    trainerusername VARCHAR(100) NOT NULL,
    trainer_id INT,
    hired_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) DEFAULT NULL 
);
