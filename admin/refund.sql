CREATE TABLE payment_refund_admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  course_id VARCHAR(255) NOT NULL,
  username VARCHAR(255) NOT NULL,
  title VARCHAR(255) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  timestamp DATETIME NOT NULL,
  image_path VARCHAR(255) NOT NULL
);