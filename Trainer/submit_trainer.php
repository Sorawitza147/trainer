<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครเทรนเนอร์</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
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
<body>
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = new mysqli('localhost', 'root', '', 'trainer');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $password = isset($_POST['password']) ? $_POST['password'] : "";
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $trainerusername = isset($_POST['trainerusername']) ? $_POST['trainerusername'] : "";

    $stmt_check_trainerusername = $conn->prepare("SELECT * FROM usertrainer WHERE trainerusername = ?");
    $stmt_check_trainerusername->bind_param("s", $trainerusername);
    $stmt_check_trainerusername->execute();
    $result_check_trainerusername = $stmt_check_trainerusername->get_result();
    
    if ($result_check_trainerusername->num_rows > 0) {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'ผิดพลาด',
            text: 'ยูสเซอร์นี้มีอยู่ในระบบเเล้ว',
          }).then(() => {
            window.history.back();
          });
        </script>";
        exit();
    }

    $stmt_check_trainerusername->close();

    $stmt2 = $conn->prepare("INSERT INTO usertrainer (trainerusername, password) VALUES (?, ?)");
    $stmt2->bind_param("ss", $trainerusername, $hashedPassword);

    if ($stmt2->execute()) {
        $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : "";
        $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : "";
        $emailtrainer = isset($_POST['emailtrainer']) ? $_POST['emailtrainer'] : "";
        $age = isset($_POST['age']) ? $_POST['age'] : "";
        $password = isset($_POST['password']) ? $_POST['password'] : "";
        $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : "";
        $gender = isset($_POST['gender']) ? $_POST['gender'] : "";
        $level_2 = isset($_POST['level_2']) ? $_POST['level_2'] : "";
        $start_year_2 = isset($_POST['start_year_2']) ? $_POST['start_year_2'] : "";
        $end_year_2 = isset($_POST['end_year_2']) ? $_POST['end_year_2'] : "";
        $level_3 = isset($_POST['level_3']) ? $_POST['level_3'] : "";
        $start_year_3 = isset($_POST['start_year_3']) ? $_POST['start_year_3'] : "";
        $end_year_3 = isset($_POST['end_year_3']) ? $_POST['end_year_3'] : "";
        $level_4 = isset($_POST['level_4']) ? $_POST['level_4'] : "";
        $start_year_4 = isset($_POST['start_year_4']) ? $_POST['start_year_4'] : "";
        $end_year_4 = isset($_POST['end_year_4']) ? $_POST['end_year_4'] : "";
        $level_5 = isset($_POST['level_5']) ? $_POST['level_5'] : "";
        $start_year_5 = isset($_POST['start_year_5']) ? $_POST['start_year_5'] : "";
        $end_year_5 = isset($_POST['end_year_5']) ? $_POST['end_year_5'] : "";
        $level_6 = isset($_POST['level_6']) ? $_POST['level_6'] : "";
        $start_year_6 = isset($_POST['start_year_6']) ? $_POST['start_year_6'] : "";
        $end_year_6 = isset($_POST['end_year_6']) ? $_POST['end_year_6'] : "";
        $district = isset($_POST['district']) ? $_POST['district'] : "";
        $subdistrict = isset($_POST['subdistrict']) ? $_POST['subdistrict'] : "";
        $bank = isset($_POST['bank']) ? $_POST['bank'] : "";
        $account_number = isset($_POST['account_number']) ? $_POST['account_number'] : "";

        $target_dir_profile = "uploadspic/";

        if ($_FILES["image_profile"]["error"] == 0) {
            $target_file_profile = $target_dir_profile . basename($_FILES["image_profile"]["name"]);

            if (!move_uploaded_file($_FILES["image_profile"]["tmp_name"], $target_file_profile)) {
                echo "Sorry, there was an error uploading your profile picture.";
                exit();
            }
        } else {
            echo "Profile picture field is not set.";
            exit();
        }

        $target_dir = "uploads/";

        if (!empty($_FILES["image"]["name"])) {
            $target_file = $target_dir . basename($_FILES["image"]["name"]);

            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "Sorry, there was an error uploading your file.";
                exit();
            }
        } else {
            echo "Image field is not set.";
            exit();
        }

        $stmt1 = $conn->prepare("INSERT INTO trainer_signup (trainerusername, password, first_name, last_name, emailtrainer, age, gender, phone_number, level_2, start_year_2, end_year_2, level_3, start_year_3, end_year_3, level_4, start_year_4, end_year_4, level_5, start_year_5, end_year_5, level_6, start_year_6, end_year_6, district, subdistrict, image_profile, image, bank, account_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt1 === false) {
        die("Error preparing statement: " . $conn->error);
    }

    if (!$stmt1->bind_param("sssssssssiisiisiisiisiisssssi", $trainerusername, $hashedPassword, $first_name, $last_name, $emailtrainer, $age, $gender, $phone_number, $level_2, $start_year_2, $end_year_2, $level_3, $start_year_3, $end_year_3, $level_4, $start_year_4, $end_year_4, $level_5, $start_year_5, $end_year_5, $level_6, $start_year_6, $end_year_6, $district, $subdistrict, $target_file_profile, $target_file, $bank, $account_number)) {
        die("Error binding parameters: " . $stmt1->error);
    }

    if (!$stmt1->execute()) {
        die("Error executing statement: " . $stmt1->error);
    } else {
        echo "<script>
    function showRegisterSuccess() {
        Swal.fire({
            icon: 'success',
            title: 'สมัครสำเร็จ',
            confirmButtonText: 'ตกลง'
        }).then(() => {
            window.location.href = '../index.php'; // หรือ URL ของหน้า Login
        });
    }
        showRegisterSuccess(); // เรียกใช้ฟังก์ชันเพื่อแสดงหน้าต่างแจ้งเตือน
    </script>";
        exit();
        }
        } else {
            header("Location: error.php");
            exit();
        }

        $stmt1->close();
    } else {
        header("Location: error.php");
        exit();
    }

    $stmt2->close();
    $conn->close();
?>
</body>
</html>