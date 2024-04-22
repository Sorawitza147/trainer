<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลผู้สอน</title>
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
session_name("trainer_session");
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trainer";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_SESSION['trainerusername'])) {
    $trainerusername = $_SESSION['trainerusername'];

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $emailtrainer = $_POST['emailtrainer'];
    $gender = $_POST['gender'];
    $phone_number = $_POST['phone_number'];
    $district = $_POST['district'];
    $subdistrict = $_POST['subdistrict'];
    $level_2 = $_POST['level_2'];
    $start_year_2 = $_POST['start_year_2'];
    $end_year_2 = $_POST['end_year_2'];
    $level_3 = $_POST['level_3'];
    $start_year_3 = $_POST['start_year_3'];
    $end_year_3 = $_POST['end_year_3'];
    $level_4 = $_POST['level_4'];
    $start_year_4 = $_POST['start_year_4'];
    $end_year_4 = $_POST['end_year_4'];
    $level_5 = $_POST['level_5'];
    $start_year_5 = $_POST['start_year_5'];
    $end_year_5 = $_POST['end_year_5'];
    $level_6 = $_POST['level_6'];
    $start_year_6 = $_POST['start_year_6'];
    $end_year_6 = $_POST['end_year_6'];
    
    $stmt = $conn->prepare("UPDATE accepted_trainers SET first_name=?, last_name=?, emailtrainer=?, gender=?, phone_number=?, district=?, subdistrict=?, 
                            level_2=?, start_year_2=?, end_year_2=?,
                            level_3=?, start_year_3=?, end_year_3=?,
                            level_4=?, start_year_4=?, end_year_4=?,
                            level_5=?, start_year_5=?, end_year_5=?,
                            level_6=?, start_year_6=?, end_year_6=?
                            WHERE trainerusername=?");
    $stmt->bind_param("ssssssssiisiisiisiisiis", $first_name, $last_name, $emailtrainer, $gender, $phone_number, $district, $subdistrict,
                        $level_2, $start_year_2, $end_year_2,
                        $level_3, $start_year_3, $end_year_3,
                        $level_4, $start_year_4, $end_year_4,
                        $level_5, $start_year_5, $end_year_5,
                        $level_6, $start_year_6, $end_year_6, $trainerusername);


    if ($stmt->execute()) {
        echo "<script>
        function showRegisterSuccess() {
          Swal.fire({
              icon: 'success',
              title: 'อัพเดทสำเร็จ',
              confirmButtonText: 'ตกลง'
          }).then(() => {
              window.location.href = 'edit_profiletrainer.php';
          });
        }
        showRegisterSuccess(); // เรียกใช้ฟังก์ชันเพื่อแสดงหน้าต่างแจ้งเตือน
      </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "คุณไม่ได้เข้าสู่ระบบ";
}

$conn->close();
?>
</body>
</html>