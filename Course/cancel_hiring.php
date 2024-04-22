<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลการจ้างเทรนเนอร์</title>
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

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    // ตรวจสอบว่ามีการส่ง course_id ผ่าน URL หรือไม่
    if ($_SERVER["REQUEST_METHOD"] == "GET" && !isset($_GET['course_id'])) {
        echo "กรุณาระบุ course_id";
        exit;
    }

    // ตรวจสอบว่ามีการส่ง course_id ผ่านแบบฟอร์ม POST หรือไม่
    if ($_SERVER["REQUEST_METHOD"] == "POST" && (!isset($_POST['course_id']) || empty($_POST['course_id']))) {
        echo "กรุณาระบุ course_id";
        exit;
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "trainer";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // รับค่า course_id จาก URL
    if(isset($_GET['course_id'])) {
        $course_id = $_GET['course_id'];
    }

    // รับค่า course_id จากแบบฟอร์ม POST
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["course_id"])) {
        $course_id = $_POST["course_id"];
    }

    // ตรวจสอบว่ามีข้อมูลของคอร์สที่ต้องการบันทึก
    $sql_course = "SELECT courses.title, courses.price, courses.course_id, hired_trainers.payment_status, user.bank, user.account_number 
    FROM hired_trainers 
    INNER JOIN courses ON hired_trainers.course_id = courses.course_id 
    INNER JOIN user ON hired_trainers.username = user.username
    WHERE hired_trainers.course_id = '$course_id'";
    $result_course = $conn->query($sql_course);
    if ($result_course->num_rows > 0) {
        $row_course = $result_course->fetch_assoc();
        if ($row_course["payment_status"] === "ชำระเงินสำเร็จ") {
            // ตรวจสอบว่าคีย์ 'title' และ 'price' มีอยู่ใน $row_course หรือไม่
            if (isset($row_course["title"]) && isset($row_course["price"])) {
                // บันทึกข้อมูลลงในตาราง payment_refund
                $username = $_SESSION["username"];
                $course_id = $row_course["course_id"];
                $course_title = $row_course["title"];
                $course_price = $row_course["price"];
                $bank = $row_course["bank"];
                $account_number = $row_course["account_number"];

                // สร้างคำสั่ง SQL สำหรับการเพิ่มข้อมูล
                $sql_insert_refund = "INSERT INTO payment_refund (course_id, username, title, price, bank, account_number) 
                VALUES ('$course_id', '$username', '$course_title', '$course_price', '$bank', '$account_number')";

                // Execute คำสั่ง SQL เพื่อบันทึกข้อมูล
                if (mysqli_query($conn, $sql_insert_refund)) {
                    echo "";
                } else {
                    echo "Error: " . $sql_insert_refund . "<br>" . mysqli_error($conn);
                }
            }
        }
    }

    // รับข้อมูลจากแบบฟอร์มโดยใช้ HTTP POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["course_id"])) {
            $course_id = $_POST["course_id"];
            $username = $_SESSION["username"];

            // กำหนดคำสั่ง SQL ใน $sql_update_status ก่อนที่จะใช้
            $sql_update_status = "UPDATE course_history_trainer SET status = 'ยกเลิกจ้าง' WHERE course_id = '$course_id'";

            $sql_delete = "DELETE FROM hired_trainers WHERE username = '$username' AND course_id = '$course_id'";

            if ($conn->query($sql_delete) === TRUE) {
                // อัพเดตสถานะในตาราง hired_trainers เป็น 'ยกเลิก'
                // เพิ่มเข้าตาราง course_history_trainer
                if ($conn->query($sql_update_status) === TRUE) {
                    echo "<script>
        function showRegisterSuccess() {
          Swal.fire({
              icon: 'success',
              title: 'ยกเลิกจ้างสำเร็จ',
              confirmButtonText: 'ตกลง'
          }).then(() => {
              window.location.href = 'userhire.php';
          });
        }
        showRegisterSuccess(); // เรียกใช้ฟังก์ชันเพื่อแสดงหน้าต่างแจ้งเตือน
      </script>";
                } else {
                    echo "เกิดข้อผิดพลาดในการยกเลิกการจ้างเทรนเนอร์: " . $conn->error;
                }
            } else {
                echo "เกิดข้อผิดพลาดในการยกเลิกการจ้างเทรนเนอร์: " . $conn->error;
            }
        } else {
            echo "ไม่พบข้อมูล course_id";
        }
    }
    $conn->close();
} else {
    echo "คุณต้องเข้าสู่ระบบเพื่อยกเลิกการจ้างเทรนเนอร์";
}
?>

</body>
</html>
