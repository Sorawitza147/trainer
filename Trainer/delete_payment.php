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
$dbname = "trainer";

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// เรียกข้อมูลเฉพาะผู้ใช้ที่เข้าสู่ระบบ
session_name("trainer_session");
session_start();
$trainerusername = $_SESSION['trainerusername'];

// ลบข้อมูลจากตาราง payment_refund_admin โดยใช้ trainerusername เป็นเงื่อนไข
$sql = "DELETE FROM payment_info WHERE trainerusername='$trainerusername'";

if ($conn->query($sql) === TRUE) {
    echo "<script>
              function showRegisterSuccess() {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    confirmButtonText: 'ตกลง'
                }).then(() => {
                    window.location.href = 'course_status.php';
                });
              }
              showRegisterSuccess(); // เรียกใช้ฟังก์ชันเพื่อแสดงหน้าต่างแจ้งเตือน
            </script>";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
</body>
</html>
