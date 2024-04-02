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
    // Collect form data
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $duration = $_POST['duration'];
    $price = $_POST['price'];
    $difficulty = $_POST['difficulty'];
    $description = $_POST['description'];

    // Update course in the database
    $sql_update = "UPDATE courses SET title='$title', duration='$duration', price='$price', difficulty='$difficulty', description='$description' WHERE course_id='$course_id'";

    if ($conn->query($sql_update) === TRUE) {
        echo "บันทึกข้อมูลคอร์สเรียบร้อยแล้ว";
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error;
    }
}

$conn->close();
?>
