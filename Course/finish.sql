CREATE TABLE finish_course (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    course_id INT,
    name VARCHAR(255),
    username VARCHAR(255),
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