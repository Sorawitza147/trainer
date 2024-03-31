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
    $course_id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $price = $_POST['price'];
    $difficulty = $_POST['difficulty'];

    $sql_update_course = "UPDATE courses SET title='$title', description='$description', duration='$duration', price='$price', difficulty='$difficulty' WHERE id=$course_id";

    if ($conn->query($sql_update_course) === TRUE) {
        echo "ข้อมูลคอร์สได้รับการอัปเดตเรียบร้อยแล้ว";
        echo "<script>window.location.href = 'admin_dashboard.php';</script>";
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error;
    }
}

$conn->close();
?>
