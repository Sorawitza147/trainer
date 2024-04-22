<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "trainer";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trainer_id = $_POST["trainer_id"];
    
    // เขียนโค้ด SQL สำหรับลบข้อมูลเทรนเนอร์
   // $sql = "DELETE FROM accepted_trainers WHERE trainer_id = '$trainer_id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "ลบข้อมูลเรียบร้อยแล้ว";
    } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูล: " . $conn->error;
    }
}

$conn->close();
?>
