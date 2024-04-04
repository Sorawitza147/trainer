<?php
// ดึงข้อมูลจาก URL
$course_id = $_GET['course_id'];

// เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect('localhost', 'root', '', 'trainer');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// ดึงข้อมูลคอร์สเรียน
$sql = "SELECT * FROM courses WHERE course_id = $course_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// ตั้งค่าตัวแปร
$course_title = $row['title'];
$course_price = $row['price'];
$timestamp = date('Y-m-d H:i:s');

// ตรวจสอบว่ามีการ submit form หรือไม่
if (isset($_POST['submit']) && isset($_FILES['image']['name'])) {
  // อัปโหลดรูปภาพ
  $filename = $_FILES['image']['name'];
  $tmp_name = $_FILES['image']['tmp_name'];
  $upload_dir = 'picrefund/';
  move_uploaded_file($tmp_name, $upload_dir . $filename);

  // บันทึกข้อมูลการคืนเงิน
  $sql = "INSERT INTO payment_refund_admin (title, price, course_id, timestamp, image_path) VALUES ('$course_title', '$course_price', '$course_id', '$timestamp', '$filename')";
  mysqli_query($conn, $sql);


  $sql = "DELETE FROM payment_refund WHERE course_id = $course_id";
  mysqli_query($conn, $sql);

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
      <label for="image">รูปภาพใบเสร็จ:</label>
      <input type="file" name="image" id="image">

      <br>

      <input type="submit" name="submit" value="ยืนยันการคืนเงิน">
    </form>
  </div>
</body>
</html>
