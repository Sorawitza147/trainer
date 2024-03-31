CREATE TABLE courses (
  course_id INT AUTO_INCREMENT PRIMARY KEY,
  trainerusername VARCHAR(100) NOT NULL,
  name VARCHAR(255) NOT NULL,
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
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- สร้างตาราง activities
CREATE TABLE activities (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL
);

-- สร้างตาราง course_activities
CREATE TABLE course_activities (
  course_id INT,
  activity_id INT,
  PRIMARY KEY (course_id, activity_id),
  FOREIGN KEY (course_id) REFERENCES courses(course_id),
  FOREIGN KEY (activity_id) REFERENCES activities(id)
);

-- ตัวอย่างข้อมูล activities
INSERT INTO activities (name) VALUES
  ('เต้นแอโรบิก'),
  ('การฝึกป้องกันตัว'),
  ('บอดี้เวท'),
  ('เวทเทรนนิ่ง'),
  ('การโยคะ'),
  ('คาดิโอ'),
  ('ลดน้ำหนัก'),
  ('การสร้างกล้ามเนื้อ'),
  ('การฝึกกลุ่ม'),
  ('การฝึกออนไลน์'),
  ('เพิ่มน้ำหนัก'),
  ('การฝึกออนไซต์');