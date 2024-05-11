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
    $trainer_id = $_POST["trainer_id"];
    $sql_accepted_trainers = "DELETE FROM accepted_trainers WHERE trainer_id = '$trainer_id'";
    if ($conn->query($sql_accepted_trainers) === TRUE) {
        $sql_usertrainer = "DELETE FROM usertrainer WHERE trainer_id = '$trainer_id'";
        if ($conn->query($sql_usertrainer) === TRUE) {
            echo "<script>
                    function showRegisterSuccess() {
                        Swal.fire({
                            icon: 'success',
                            title: 'ลบข้อมูลเรียบร้อย',
                            confirmButtonText: 'ตกลง'
                        }).then(() => {
                            window.location.href = 'admin_dashboard.php';
                        });
                    }
                    showRegisterSuccess();
                </script>";
        } else {
            echo "เกิดข้อผิดพลาดในการลบข้อมูลในตาราง usertrainer: " . $conn->error;
        }
    } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูลในตาราง accepted_trainers: " . $conn->error;
    }
}

$conn->close();
?>

</body>
</html>