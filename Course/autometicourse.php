<?php
// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trainer";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงข้อมูลคอร์สทั้งหมดจากฐานข้อมูล
$sql = "SELECT * FROM courses";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // วนลูปผลลัพธ์และตรวจสอบวันที่
    while($row = $result->fetch_assoc()) {
        $course_date = strtotime($row["course_date"]); // แปลงวันที่เป็น timestamp
        $current_date = strtotime(date("Y-m-d")); // วันที่ปัจจุบันในรูปแบบ timestamp

        // ถ้าวันที่คอร์สมากกว่าหรือเท่ากับวันปัจจุบัน
        if ($course_date <= $current_date) {
            // ลบคอร์สนั้นออกจากฐานข้อมูล
            $delete_sql = "DELETE FROM courses WHERE course_id=" . $row["course_id"];
            if ($conn->query($delete_sql) === TRUE) {
                echo "Record deleted successfully";
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        }
    }
} else {
    echo "0 results";
}
$conn->close();
?>
