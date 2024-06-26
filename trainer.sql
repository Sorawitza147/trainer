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
    account_number VARCHAR(100) NOT NULL
);