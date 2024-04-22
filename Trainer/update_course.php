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
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $duration = $_POST['duration'];
    $price = $_POST['price'];
    $difficulty = $_POST['difficulty'];
    $description = $_POST['description'];

    // Update course in the database
    $sql_update = "UPDATE courses SET title='$title', duration='$duration', price='$price', difficulty='$difficulty', description='$description' WHERE course_id='$course_id'";

    if ($conn->query($sql_update) === TRUE) {
        echo "<script>
        function showRegisterSuccess() {
          Swal.fire({
              icon: 'success',
              title: 'แก้ไขสำเร็จ',
              confirmButtonText: 'ตกลง'
          }).then(() => {
              window.location.href = 'viewcourse.php';
          });
        }
        showRegisterSuccess(); // เรียกใช้ฟังก์ชันเพื่อแสดงหน้าต่างแจ้งเตือน
      </script>";

    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error;
    }
}

$conn->close();
?>
</body>
</html>
