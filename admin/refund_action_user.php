<?php
// ตรวจสอบว่ามีการส่งค่า id มาหรือไม่
if(isset($_GET['id'])) {
    // ดึงข้อมูลจาก URL
    $id = $_GET['id'];

    // เชื่อมต่อฐานข้อมูล
    $conn = mysqli_connect('localhost', 'root', '', 'trainer');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // ดึงข้อมูล username, bank, และ account_number จากตาราง payment_refund โดยใช้ id
    $sql_refund = "SELECT username, title, price, bank, account_number FROM payment_refund WHERE id = ?";
    $stmt_refund = mysqli_prepare($conn, $sql_refund);
    mysqli_stmt_bind_param($stmt_refund, "i", $id); // แก้ "s" เป็น "i"
    mysqli_stmt_execute($stmt_refund);
    $result_refund = mysqli_stmt_get_result($stmt_refund);
    $row_refund = mysqli_fetch_assoc($result_refund);

    // ตรวจสอบว่ามีข้อมูลที่คาดหวังอยู่หรือไม่ก่อนที่จะใช้งาน
    if ($row_refund !== null) {   
        // ดึงข้อมูลจากตาราง payment_refund
        $username = $row_refund['username'];
        $title = $row_refund['title'];
        $price = $row_refund['price'];
        $bank = $row_refund['bank'];
        $account_number = $row_refund['account_number'];
    }

    if (isset($_POST['submit']) && isset($_FILES['image']['name'])) {
        // อัปโหลดรูปภาพ
        $filename = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $upload_dir = 'picrefund/';
        move_uploaded_file($tmp_name, $upload_dir . $filename);

        // บันทึกข้อมูลการคืนเงิน
        $sql = "INSERT INTO payment_refund_admin (title, price, course_id, timestamp, image_path, username, bank, account_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssisssss", $title, $price, $id, $timestamp, $filename, $username, $bank, $account_number);
        mysqli_stmt_execute($stmt);

        // ลบข้อมูล payment_refund โดยใช้ id
        $sql_delete = "DELETE FROM payment_refund WHERE id = ?";
        $stmt_delete = mysqli_prepare($conn, $sql_delete);
        mysqli_stmt_bind_param($stmt_delete, "i", $id);
        mysqli_stmt_execute($stmt_delete);

        // แสดงข้อความแจ้งเตือน
        echo "<script>alert('บันทึกข้อมูลการคืนเงินเรียบร้อยแล้ว');</script>";
    }
} else {
    // ถ้าไม่มีการส่งค่า id มา
    echo "ไม่พบค่า ID ที่ถูกส่งมา";
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>Refund - <?php echo isset($title) ? $title : 'ไม่พบข้อมูล'; ?></title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Mitr", sans-serif;
}
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      background-color: #f4f4f4;
    }
    .container {
      max-width: 600px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    form {
      margin-top: 20px;
    }
    label {
      display: block;
      margin-bottom: 10px;
    }
    input[type="file"] {
      margin-bottom: 20px;
    }
    input[type="submit"] {
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 4px;
    }
    input[type="submit"]:hover {
      background-color: #45a049;
    }
    input[type="text"],
    input[type="file"] {
      border: none;
      border-bottom: 1px solid #ddd;
      outline: none;
    }
  </style>
</head>
<body>
<div class="container">
<h1>Refund - <?php echo isset($title) ? $title : 'ไม่พบข้อมูล'; ?></h1>


    <form method="post" enctype="multipart/form-data">

        
        <!-- แสดงข้อมูล title และ price -->
        <label for="title">ชื่อคอร์ส:</label>
        <input type="text" id="title" name="title" value="<?php echo isset($title) ? $title : ''; ?>" readonly>
        <br>
        <label for="price">ราคา:</label>
        <input type="text" id="price" name="price" value="<?php echo isset($price) ? $price * 0.95 : ''; ?>" readonly>
        <br>

        <!-- แสดงข้อมูล username, bank, และ account_number -->
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>" readonly>
        <br>
        <label for="bank">Bank:</label>
        <input type="text" id="bank" name="bank" value="<?php echo $bank; ?>" readonly>
        <br>
        <label for="account_number">Account Number:</label>
        <input type="text" id="account_number" name="account_number" value="<?php echo $account_number; ?>" readonly>
        <br>

        <input type="file" name="image" id="image">
        <br>
        <input type="submit" name="submit" value="ยืนยันการคืนเงิน">
    </form>
</div>
</body>
</html>
