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
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$database = "trainer";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่งไฟล์มาหรือไม่
if(isset($_FILES["fileToUpload"])) {
    $target_dir = "uploadspayment/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "";

        // ตรวจสอบว่ามีการส่งค่า course_id มาหรือไม่
        if(isset($_POST["course_id"])) {
            $course_id = $_POST["course_id"];

            // รับค่าชื่อคอร์ส ชื่อผู้ใช้ที่โอน และราคาจากฐานข้อมูล
            $sql_course = "SELECT title, price FROM courses WHERE course_id = '$course_id'";
            $result_course = $conn->query($sql_course);

            if ($result_course->num_rows > 0) {
                $row_course = $result_course->fetch_assoc();
                $course_title = $row_course["title"];
                $course_price = $row_course["price"];
                $username = $_POST["username"];
                $payment_id =  $_POST["payment_id"]; // Generate payment ID

                // บันทึกรูปภาพลงในฐานข้อมูล
                $sql = "INSERT INTO payment (course_id, course_title, username, payment_id, price, image_path) VALUES ('$course_id', '$course_title', '$username', '$payment_id', '$course_price', '$target_file')";
                if ($conn->query($sql) === TRUE) {
                    echo "";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error: No course found for the provided course_id.";
            }
        } else {
            echo "Error: No course_id provided.";
        }
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
} else {
    echo "No file uploaded.";
}

// ตรวจสอบว่ามีการส่งค่า course_id มาใน URL หรือไม่
if(isset($_GET["course_id"])) {
    $course_id = $_GET["course_id"];

    // อัปเดตค่า payment_status ใน hired_trainers เป็น "รอตรวจสอบ"
    $sql_update_hired_trainers = "UPDATE hired_trainers SET payment_status = 'รอตรวจสอบการชำระเงิน' WHERE course_id = '$course_id'";
    if ($conn->query($sql_update_hired_trainers) === TRUE) {
        echo "";
    } else {
        echo "" . $conn->error;
    }

    // อัปเดตค่า payment_status ใน course_history_trainer เป็น "รอตรวจสอบ"
    $sql_update_course_history = "UPDATE course_history_trainer SET payment_status = 'รอตรวจสอบการชำระเงิน' WHERE course_id = '$course_id'";
    if ($conn->query($sql_update_course_history) === TRUE) {
        echo "<script>
        function showRegisterSuccess() {
          Swal.fire({
              icon: 'success',
              title: 'โอนเงินแล้วรอตัวสอบ',
              confirmButtonText: 'ตกลง'
          }).then(() => {
              window.location.href = 'userhire.php';
          });
        }
        showRegisterSuccess(); // เรียกใช้ฟังก์ชันเพื่อแสดงหน้าต่างแจ้งเตือน
      </script>";
    } else {
        echo "" . $conn->error;
    }

    // เพิ่มรายการในตาราง accepted_course
    $sql_insert_accepted_course = "INSERT INTO accepted_course (course_id, payment_status) VALUES ('$course_id', 'รอตรวจสอบการชำระเงิน')";
    if ($conn->query($sql_insert_accepted_course) === TRUE) {
        echo ".";
    } else {
        echo "" . $conn->error;
    }
} else {
    echo "No course_id provided in the URL.";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
</body>
</html>
