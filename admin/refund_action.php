<?php
// ดึงข้อมูลจาก URL
$id = $_GET['id'];

// เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect('localhost', 'root', '', 'trainer');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ดึงข้อมูลคอร์สเรียน
$sql_course = "SELECT * FROM courses WHERE course_id = $course_id";
$result_course = mysqli_query($conn, $sql_course);
$row_course = mysqli_fetch_assoc($result_course);

// ดึงข้อมูล username จากตาราง payment_refund โดยใช้ course_id
$sql_refund = "SELECT username FROM payment_refund WHERE course_id = $course_id";
$result_refund = mysqli_query($conn, $sql_refund);
$row_refund = mysqli_fetch_assoc($result_refund);

// ตั้งค่าตัวแปร
$course_title = $row_course['title'];
$course_price = $row_course['price'];
$timestamp = date('Y-m-d H:i:s');
$username = $row_refund['username'];

if (isset($_POST['submit']) && isset($_FILES['image']['name'])) {
  // อัปโหลดรูปภาพ
  $filename = $_FILES['image']['name'];
  $tmp_name = $_FILES['image']['tmp_name'];
  $upload_dir = 'picrefund/';
  move_uploaded_file($tmp_name, $upload_dir . $filename);

  // บันทึกข้อมูลการคืนเงิน
  $sql = "INSERT INTO payment_refund_admin (title, price, course_id, timestamp, image_path, username) VALUES ('$course_title', '$course_price', '$course_id', '$timestamp', '$filename', '$username')";
  mysqli_query($conn, $sql);

  $sql_delete = "DELETE FROM payment_refund WHERE course_id = $course_id";
  mysqli_query($conn, $sql_delete);

  // แสดงข้อความแจ้งเตือน
  echo "<script>alert('บันทึกข้อมูลการคืนเงินเรียบร้อยแล้ว');</script>";
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>Refund - <?php echo $course_title; ?></title>
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
  </style>
</head>
<body>
<div class="container">
    <h1>Refund - <?php echo $course_title; ?></h1>

    <form method="post" enctype="multipart/form-data">

        
        <!-- แสดงข้อมูล title และ price -->
        <label for="title">ชื่อคอร์ส:</label>
        <input type="text" id="title" name="title" value="<?php echo $course_title; ?>" readonly>
        <br>
        <label for="price">ราคา:</label>
        <input type="text" id="price" name="price" value="<?php echo $course_price; ?>" readonly>
        <br>

        <input type="submit" name="submit" value="ยืนยันการคืนเงิน">
    </form>
</div>
</body>
</html>
