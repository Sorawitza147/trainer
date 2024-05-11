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
$conn = new mysqli("localhost", "root", "", "trainer");

if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

if (isset($_GET['reject_course_id'])) {
    $trainer_id = $_GET['reject_course_id']; 
    $course_id = $_GET['course_id']; 

    if (isset($_GET['bank']) && isset($_GET['account_number']) && isset($_GET['course_status'])) {
        $bank = $_GET['bank'];
        $account_number = $_GET['account_number'];
        $course_status = $_GET['course_status'];

        // อัปเดตค่า course_status ในตาราง courses
        $update_sql = "UPDATE courses SET course_status = 'ว่าง' WHERE course_id = '$course_id'";
        if ($conn->query($update_sql) === TRUE) {
            // เพิ่มข้อมูลการคืนเงินลงในตาราง payment_refund_trainer
            $insert_sql = "INSERT INTO payment_refund_trainer (course_id, username, title, price, bank, account_number) 
                            SELECT courses.course_id, hired_trainers.username, courses.title, courses.price, '$bank', '$account_number'
                            FROM courses
                            INNER JOIN hired_trainers ON courses.course_id = hired_trainers.course_id
                            WHERE hired_trainers.id = '$trainer_id'";
            
            if ($conn->query($insert_sql) === TRUE) {
                // ลบข้อมูลของผู้สอนที่ถูก reject ออกจากตาราง hired_trainers
                $delete_sql = "DELETE FROM hired_trainers WHERE id='$trainer_id'";
                if ($conn->query($delete_sql) === TRUE) {
                    echo "<script>
                        function showRegisterSuccess() {
                            Swal.fire({
                                icon: 'success',
                                title: 'ปฏิเสธสำเร็จ',
                                confirmButtonText: 'ตกลง'
                            }).then(() => {
                                window.location.href = 'Hire.php';
                            });
                        }
                        showRegisterSuccess();
                    </script>";
                } else {
                    echo "แต่มีข้อผิดพลาดในการลบข้อมูลผู้สอนที่ถูก reject: " . $conn->error;
                }
            } else {
                echo "มีข้อผิดพลาดในการบันทึกข้อมูลการคืนเงิน: " . $conn->error;
            }
        } else {
            echo "มีข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error;
        }
    } else {
        echo "ข้อมูล 'bank', 'account_number', หรือ 'course_status' ไม่ถูกส่งมา";
    }
} else {
    echo "ไม่พบข้อมูลที่ต้องการ";
}
$conn->close();
?> 

</body>
</html>