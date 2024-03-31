<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment User</title>
</head>
<body>
    <h2>Upload Payment Details</h2>
    <form action="paymentuser.php" method="post" enctype="multipart/form-data">
        <label for="image">Upload Image:</label><br>
        <input type="file" id="image" name="image" accept="image/*"><br><br>
        <label for="amount">Amount:</label><br>
        <input type="number" id="amount" name="amount" required><br><br>
        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" required><br><br>
        <label for="time">Time:</label><br>
        <input type="time" id="time" name="time" required><br><br>
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trainer";

if(isset($_POST["submit"])) {
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $target_dir = "uploadspayment/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        echo "File uploaded successfully.";

        $result = checkPaymentSlip($_FILES['image']);
        echo $result;

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO payments (amount, date, time, image) VALUES ('$amount', '$date', '$time', '$target_file')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "File is not an image.";
    }
}

function checkPaymentSlip($slipImage)
{
    // ตรวจสอบว่าไฟล์รูปภาพถูกอัพโหลดหรือไม่
    if (!isset($slipImage['tmp_name']) || !is_uploaded_file($slipImage['tmp_name'])) {
        return "กรุณาเลือกไฟล์รูปภาพของสลิปการโอนเงิน";
    }

    // ตรวจสอบประเภทของไฟล์รูปภาพ
    $allowedTypes = array('image/jpeg', 'image/png', 'image/gif');
    if (!in_array($slipImage['type'], $allowedTypes)) {
        return "รูปแบบไฟล์ไม่ถูกต้อง โปรดอัพโหลดเฉพาะไฟล์รูปภาพ JPEG, PNG, หรือ GIF";
    }

    // ตรวจสอบขนาดของไฟล์รูปภาพ
    if ($slipImage['size'] > 5000000) { // 5 MB
        return "ขนาดไฟล์รูปภาพมากเกินไป โปรดอัพโหลดรูปภาพขนาดไม่เกิน 5 MB";
    }

    // อ่านเนื้อหาของไฟล์รูปภาพ
    $imageContents = file_get_contents($slipImage['tmp_name']);
    
    // ตรวจสอบว่าเนื้อหาของภาพมีลักษณะเฉพาะของสลิปการโอนเงินหรือไม่
    if (strpos($imageContents, 'โอนเงินสำเร็จ') !== false) {
        return "สลิปการโอนเงินถูกต้อง";
    } else {
        return "ไฟล์รูปภาพไม่ใช่สลิปการโอนเงิน โปรดอัพโหลดรูปภาพที่ถูกต้อง";
    }
}
?>
