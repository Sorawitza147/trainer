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
if (isset($_POST['submit'])) {

  // อัปโหลดรูปภาพ
  $filename = $_FILES['image']['name'];
  $tmp_name = $_FILES['image']['tmp_name'];
  $upload_dir = 'uploads/';
  move_uploaded_file($tmp_name, $upload_dir . $filename);

  // บันทึกข้อมูลการคืนเงิน
  $sql = "INSERT INTO payment_refund_admin ( title, price, course_id, timestamp, image_path) VALUES ('$course_title', '$course_price', '$course_id', '$timestamp', '$filename')";
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
</head>
<body>
  <h1>Refund - <?php echo $course_title; ?></h1>

  <form method="post" enctype="multipart/form-data">
    <label for="image">รูปภาพใบเสร็จ:</label>
    <input type="file" name="image" id="image">

    <br>

    <input type="submit" name="submit" value="ยืนยันการคืนเงิน">
  </form>
</body>
</html>