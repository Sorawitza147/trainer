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
