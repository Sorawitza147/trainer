 CREATE TABLE payment_refund_trainer (
  id INT AUTO_INCREMENT PRIMARY KEY, 
  course_id VARCHAR(255) NOT NULL,
  username VARCHAR(255) NOT NULL,
  title VARCHAR(255) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  bank VARCHAR(100) NOT NULL,
  account_number INT NOT NULL
  );
