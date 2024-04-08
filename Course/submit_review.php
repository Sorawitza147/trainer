<?php
session_name("user_session");
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbName = "trainer";

$conn = new mysqli($servername, $username, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากแบบฟอร์มรีวิว
    $course_id = $_POST['course_id'];
    $username = $_POST['username'];
    $trainer_id = $_POST['trainer_id'];
    $history_id = $_POST['history_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    // บันทึกข้อมูลรีวิวลงในฐานข้อมูล
    $sql_insert_review = "INSERT INTO reviews (course_id, username, trainer_id, history_id, rating, review) 
                          VALUES ('$course_id', '$username', '$trainer_id', '$history_id', '$rating', '$review')";

    if ($conn->query($sql_insert_review) === TRUE) {
        echo "<div class='success-message'>บันทึกรีวิวเรียบร้อย</div>";
    } else {
        echo "<div class='error-message'>เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error . "</div>";
    }
}

$conn->close();
?>
