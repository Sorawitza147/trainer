<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trainer";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

if (isset($_POST['user_id']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['gender']) && isset($_POST['age']) && isset($_POST['height']) && isset($_POST['weight']) && isset($_POST['phone'])) {
    $user_id = $_POST['user_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $phone = $_POST['phone'];

    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET firstname='$firstname', lastname='$lastname', username='$username', email='$email', password='$hashed_password', gender='$gender', age=$age, height=$height, weight=$weight, phone='$phone' WHERE id=$user_id";
    } else {
        $sql = "UPDATE user SET firstname='$firstname', lastname='$lastname', username='$username', email='$email', gender='$gender', age=$age, height=$height, weight=$weight, phone='$phone' WHERE id=$user_id";
    }
    if ($conn->query($sql) === TRUE) {
        echo "ข้อมูลผู้ใช้ถูกอัปเดตเรียบร้อยแล้ว";
        echo "<script>window.location.href = 'admin_login.php';</script>"; 
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error;
    }
} else {
    echo "ข้อมูลไม่สมบูรณ์หรือไม่ถูกต้อง";
}
$conn->close();
?>
