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
session_name("trainer_session");
session_start();
// เชื่อมต่อฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "trainer");

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่งค่า id มาหรือไม่
if (isset($_GET['id'])) {
    // ใช้ prepared statements เพื่อป้องกัน SQL injection
    $stmt = $conn->prepare("INSERT INTO finish_course (course_id, name, username, trainerusername, title, description, price, end_date, start_date, start_time, end_time, bank, account_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // ตรวจสอบว่า prepared statement สามารถเตรียมได้หรือไม่
    if ($stmt) {
        // ผูกค่า parameter
        $stmt->bind_param("issssssssssss", $course_id, $name, $username, $trainerusername, $title, $description, $price, $end_date, $start_date, $start_time, $end_time, $bank, $account_number);

        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : '';
        $name = isset($_GET['name']) ? $_GET['name'] : '';
        $username = isset($_GET['username']) ? $_GET['username'] : '';
        $trainerusername = isset($_GET['trainerusername']) ? $_GET['trainerusername'] : '';
        $title = isset($_GET['title']) ? $_GET['title'] : '';
        $description = isset($_GET['description']) ? $_GET['description'] : '';
        $price = isset($_GET['price']) ? $_GET['price'] : '';
        $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
        $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
        $start_time = isset($_GET['start_time']) ? $_GET['start_time'] : '';
        $end_time = isset($_GET['end_time']) ? $_GET['end_time'] : '';
        $bank = isset($_GET['bank']) ? $_GET['bank'] : ''; // เพิ่มการรับค่า "bank" จาก URL parameters
        $account_number = isset($_GET['account_number']) ? $_GET['account_number'] : ''; // เพิ่มการรับค่า "account_number" จาก URL parameters
        // ประมวลผล prepared statement
        if ($stmt->execute()) {
            // ลบข้อมูลจากตาราง accepted_course โดยใช้คำสั่ง SQL
            $delete_sql = "DELETE FROM accepted_course WHERE id='$id'";
            
            if ($conn->query($delete_sql) === TRUE) {
                // อัพเดต status ในตาราง course_history_trainer เป็น "เสร็จสิ้นแล้ว"
                $update_sql = "UPDATE course_history_trainer SET status='เสร็จสิ้นแล้ว' WHERE course_id='$course_id'";
                
                // อัพเดต status ในตาราง course_history_trainer
                if ($conn->query($update_sql) === TRUE) {
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
                    echo "มีข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error;
                }
            } else {
                echo "มีข้อผิดพลาดในการลบข้อมูล: " . $conn->error;
            }
        } else {
            echo "มีข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error;
        }

        // ปิด prepared statement
        $stmt->close();
    } else {
        echo "มีข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $conn->error;
    }
} else {
    echo "ไม่พบข้อมูลที่ต้องการ";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
</body>
</html>
