CREATE TABLE reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    history_id INT,
    reporter_username VARCHAR(255),
    report_text TEXT,
    report_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
