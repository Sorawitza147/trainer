<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ข้อมูลเทรนเนอร์</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      padding: 20px;
    }

    .container {
      max-width: 600px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .profile-picture img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      margin-bottom: 20px;
    }

    p {
      margin-bottom: 10px;
    }

    p strong {
      margin-right: 10px;
    }

    .back-button {
      margin-top: 20px;
    }
  </style>
</head>
<body>
<div class="container">
<?php
// เช็คการเชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$database = "trainer";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่ง trainer_id ผ่าน URL หรือไม่
if(isset($_GET['trainer_id']) && !empty($_GET['trainer_id'])) {
    // ดึงค่า trainer_id จาก URL
    $trainer_id = $_GET['trainer_id'];
    
    // สร้างคำสั่ง SQL และดึงข้อมูลเทรนเนอร์โดยใช้ trainer_id
    $sql = "SELECT * FROM accepted_trainers WHERE trainer_id = $trainer_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // หากพบข้อมูลเทรนเนอร์
        $row = $result->fetch_assoc();
        echo "<div class='profile-picture'>";
        if (!empty($row['image_profile'])) {
            echo "<img src='../Trainer/" . $row['image_profile'] . "' alt='โปรไฟล์ของ " . $row["first_name"] . " " . $row["last_name"] . "'>";
        }
        echo "</div>";
        echo "<p><strong>ชื่อ:</strong> " . $row["first_name"] . " " . $row["last_name"] . "</p>";
        echo "<p><strong>อีเมล:</strong> " . $row["emailtrainer"] . "</p>";
        echo "<p><strong>เพศ:</strong> " . $row["gender"] . "</p>";
        echo "<p><strong>อายุ:</strong> " . $row["age"] . "</p>";
        echo "<p><strong>เบอร์โทรศัพท์:</strong> " . $row["phone_number"] . "</p>";
         for ($i = 1; $i <= 6; $i++) {
            $level_key = "level_" . $i;
            $start_key = "start_year_" . $i;
            $end_key = "end_year_" . $i;

            if (!empty($row[$level_key])) {
                echo "<p><strong>ระดับการศึกษาที่ " . $i . ":</strong> " . $row[$level_key] . "</p>";
                echo "<p><strong>ปีที่เริ่มเรียน:</strong> " . $row[$start_key] . "</p>";
                echo "<p><strong>ปีที่สำเร็จการศึกษา:</strong> " . $row[$end_key] . "</p>";
            }
        }
        // เพิ่มรายละเอียดเพิ่มเติมตามต้องการ
    } else {
        // หากไม่พบข้อมูลเทรนเนอร์
        echo "<p>ไม่พบข้อมูลเทรนเนอร์</p>";
    }
} else {
    // หากไม่มีการส่ง trainer_id ผ่าน URL
    echo "<p>ไม่พบข้อมูลเทรนเนอร์</p>";
}

$conn->close();
?>
<div class="back-button">
    <a href="javascript:history.go(-1)">ย้อนกลับ</a>
</div>
</div>
</body>
</html>
