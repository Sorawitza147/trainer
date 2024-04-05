<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trainer";

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// เรียกข้อมูลเฉพาะผู้ใช้ที่เข้าสู่ระบบ
session_name("user_session");
session_start();
$username = $_SESSION['username'];

// ลบข้อมูลจากตาราง payment_refund_admin โดยใช้ username เป็นเงื่อนไข
$sql = "DELETE FROM payment_refund_admin WHERE username='$username'";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
