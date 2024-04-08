<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trainer";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่าไฟล์ถูกส่งมาหรือไม่
if ($_FILES["payment_image"]["error"] == 0) {
    // กำหนดตัวแปรสำหรับเก็บข้อมูลจากฟอร์ม
    $title = $_POST['title'];
    $price = $_POST['price'];
    $trainerusername = $_POST['trainerusername'];

    // ตรวจสอบว่ามีการเลือกไฟล์ที่เป็นรูปภาพหรือไม่
    $target_dir = "uploadspaymenttrainer/";
    $target_file = $target_dir . basename($_FILES["payment_image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
        // เช็คว่าไฟล์มีอยู่หรือไม่
        if (file_exists($target_file)) {
            echo "ขอโทษ, ไฟล์ที่อัพโหลดนี้มีอยู่แล้ว.";
        } else {
            // เลือกที่เก็บไฟล์ใหม่
            if (move_uploaded_file($_FILES["payment_image"]["tmp_name"], $target_file)) {
                // เพิ่มข้อมูลลงในฐานข้อมูล
                $sql = "INSERT INTO payment_info (title, price, trainerusername, image_path) VALUES ('$title', '$price', '$trainerusername', '$target_file')";
                if ($conn->query($sql) === TRUE) {
                    echo "อัพโหลดรูปภาพเรียบร้อยแล้ว";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "ขอโทษ, เกิดข้อผิดพลาดในการอัพโหลดไฟล์.";
            }
        }
    } else {
        echo "ขอโทษ, ไฟล์ที่อัพโหลดต้องเป็นรูปภาพเท่านั้น.";
    }
} else {
    echo "ขอโทษ, เกิดข้อผิดพลาดในการอัพโหลดไฟล์: " . $_FILES["payment_image"]["error"];
}

$conn->close();
?>
