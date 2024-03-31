<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$database = "trainer";
$conn = new mysqli($servername, $username, $password, $database);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

if(isset($_POST['trainer_id'])) {

    $trainer_id = $_POST['trainer_id'];

    $sql = "DELETE FROM trainer_signup WHERE trainer_id = $trainer_id";

    if ($conn->query($sql) === TRUE) {

        $conn->close();

        header('Location: admin_dashboard.php');
        exit;
    } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูลเทรนเนอร์: " . $conn->error;
    }
} else {
    echo "ไม่พบรหัสเทรนเนอร์ที่ต้องการลบ";
}
?>
