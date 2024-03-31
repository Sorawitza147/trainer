    CREATE TABLE payments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        amount DECIMAL(10, 2) NOT NULL,
        date DATE NOT NULL,
        time TIME NOT NULL,
        image VARCHAR(255) NOT NULL
    );