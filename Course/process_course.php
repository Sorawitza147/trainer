<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Web Page</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Mitr", sans-serif;
    }
  </style>
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "trainer";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$phone_number = $_POST['phone_number'];
$trainer_id = $_POST['trainer_id'];
$trainerusername = $_POST['trainerusername'];
$title = $_POST['title'];
$price = $_POST['price'];
$duration = $_POST['duration'];
$difficulty = $_POST['difficulty'];
$description = $_POST['description'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$cover_image = $_FILES['cover_image']['name'];
$tmp_name = $_FILES['cover_image']['tmp_name'];
$upload_dir = 'uploadscourse/';

if ($cover_image) {
    move_uploaded_file($tmp_name, $upload_dir . $cover_image);
} else {
    $cover_image = 'default.jpg';
}

// เพิ่มการรับค่า course_status จากฟอร์ม
$course_status = isset($_POST['course_status']) ? $_POST['course_status'] : 'ว่าง';

$sql = "INSERT INTO courses (name, email, gender, age, phone_number, trainer_id, trainerusername, title, price, duration, difficulty, description, start_date, end_date, start_time, end_time, cover_image, course_status)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Error: " . $conn->error;
    exit();
}

$stmt->bind_param('sssissssisssssssss', $name, $email, $gender, $age, $phone_number, $trainer_id, $trainerusername, $title, $price, $duration, $difficulty, $description, $start_date, $end_date, $start_time, $end_time, $cover_image, $course_status);
$stmt->execute();

$course_id = $stmt->insert_id;
if (isset($_POST['activity']) && is_array($_POST['activity'])) {
    foreach ($_POST['activity'] as $activity_id) {
        $sql3 = "INSERT INTO course_activities (course_id, activity_id) VALUES (?, ?)";
        $stmt3 = $conn->prepare($sql3);

        if (!$stmt3) {
            echo "Error: " . $conn->error;
            exit();
        }

        $stmt3->bind_param('ii', $course_id, $activity_id); 
        $stmt3->execute();
    }
} else {
    echo "<script>alert('กรุณาเลือกกิจกรรมที่เกี่ยวข้องกับคอร์ส');</script>";
}

// แสดงหน้าต่างแจ้งเตือนหลังจากทำการสร้างคอร์สเสร็จสมบูรณ์
echo "<script>
        function showRegisterSuccess() {
          Swal.fire({
              icon: 'success',
              title: 'สร้างคอร์สสำเร็จ',
              confirmButtonText: 'ตกลง'
          }).then(() => {
              window.location.href = 'course.php';
          });
        }
        showRegisterSuccess(); // เรียกใช้ฟังก์ชันเพื่อแสดงหน้าต่างแจ้งเตือน
      </script>";
?>
</body>
</html>
