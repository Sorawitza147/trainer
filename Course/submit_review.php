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
session_name("user_session");
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbName = "trainer";

$conn = new mysqli($servername, $username, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากแบบฟอร์มรีวิว..
    $course_id = $_POST['course_id'];
    $username = $_POST['username'];
    $trainer_id = $_POST['trainer_id'];
    $history_id = $_POST['history_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    // บันทึกข้อมูลรีวิวลงในฐานข้อมูล
    $sql_insert_review = "INSERT INTO reviews (course_id, username, trainer_id, history_id, rating, review) 
                          VALUES ('$course_id', '$username', '$trainer_id', '$history_id', '$rating', '$review')";

    if ($conn->query($sql_insert_review) === TRUE) {
        echo "<script>
        function showRegisterSuccess() {
          Swal.fire({
              icon: 'success',
              title: 'รีวิวสำเร็จ',
              confirmButtonText: 'ตกลง'
          }).then(() => {
              window.location.href = 'histortuser.php';
          });
        }
        showRegisterSuccess(); // เรียกใช้ฟังก์ชันเพื่อแสดงหน้าต่างแจ้งเตือน
      </script>";
    } else {
        echo "<div class='error-message'>เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error . "</div>";
    }
}

$conn->close();
?>
</body>
</html>
