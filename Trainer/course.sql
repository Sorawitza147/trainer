    CREATE TABLE courses (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        trainerusername VARCHAR(100) NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        description TEXT,
        cover_image VARCHAR(255),
        duration TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );