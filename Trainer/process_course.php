<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // เชื่อมต่อฐานข้อมูล
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "trainer";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // เตรียมและทำการผูกพารามิเตอร์
    $stmt = $conn->prepare("INSERT INTO courses (title, description, price, duration, cover_image, course_status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssids", $title, $description, $price, $duration, $cover_image, $course_status);

    // รับค่าจากฟอร์ม
    $title = $_POST["title"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $duration = $_POST["duration"];
    $course_status = isset($_POST["course_status"]) ? $_POST["course_status"] : 'ไม่มีคนจ้าง'; // เพิ่มบรรทัดนี้

    // ตรวจสอบและอัปโหลดไฟล์ภาพ
    $target_dir = "uploadscourse/";
    $target_file = $target_dir . basename($_FILES["cover_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["cover_image"]["tmp_name"]);

    // ตรวจสอบไฟล์ภาพ
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    if ($_FILES["cover_image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // อัปโหลดไฟล์ภาพ
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["cover_image"]["name"]). " has been uploaded.";
            $cover_image = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // ทำการ execute คำสั่ง SQL
    if ($stmt->execute() === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;  // เปลี่ยน $conn เป็น $stmt
    }

    // ปิดคำสั่ง prepare
    $stmt->close();

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
}
?>
