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
$conn = new mysqli("localhost", "root", "", "trainer");
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}
if (isset($_GET['id'])) {
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : '';
    $stmt_payment = $conn->prepare("INSERT INTO payment_trainer (id_payment, trainerusername, title, name, created_at, status_payment) VALUES (?, ?, ?, ?, ?, ?)");

    if ($stmt_payment) {
        $stmt_payment->bind_param("ssssss", $payment_id, $trainerusername, $title_payment, $name_payment, $created_at_payment, $status_payment);
        $trainerusername = isset($_GET['trainerusername']) ? $_GET['trainerusername'] : '';
        $title_payment = isset($_GET['title']) ? $_GET['title'] : '';
        $name_payment = isset($_GET['name']) ? $_GET['name'] : '';
        $created_at_payment = date('Y-m-d H:i:s');
        $payment_id = uniqid('PAY'); 
    
        $status_payment = "กำลังทำรายการ"; 
        if ($stmt_payment->execute()) {
            $stmt_finish_course = $conn->prepare("INSERT INTO finish_course (id_payment, course_id, name, username, trainerusername, title, description, price, end_date, start_date, start_time, end_time, bank, account_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt_finish_course) {
                $stmt_finish_course->bind_param("sissssssssssss", $payment_id, $course_id, $name, $username, $trainerusername, $title, $description, $price, $end_date, $start_date, $start_time, $end_time, $bank, $account_number);
                $name = isset($_GET['name']) ? $_GET['name'] : '';
                $username = isset($_GET['username']) ? $_GET['username'] : '';
                $title = isset($_GET['title']) ? $_GET['title'] : '';
                $description = isset($_GET['description']) ? $_GET['description'] : '';
                $price = isset($_GET['price']) ? $_GET['price'] : '';
                $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
                $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
                $start_time = isset($_GET['start_time']) ? $_GET['start_time'] : '';
                $end_time = isset($_GET['end_time']) ? $_GET['end_time'] : '';
                $bank = isset($_GET['bank']) ? $_GET['bank'] : ''; 
                $account_number = isset($_GET['account_number']) ? $_GET['account_number'] : '';
                if ($stmt_finish_course->execute()) {
                    $update_sql = "UPDATE course_history_trainer SET status='เสร็จสิ้นแล้ว' WHERE course_id = ?";
                if ($stmt_update = $conn->prepare($update_sql)) {
                    $stmt_update->bind_param("s", $course_id);
                        if ($stmt_update->execute()) {
                            $delete_sql = "DELETE FROM accepted_course WHERE id=?";
                            if ($stmt_delete = $conn->prepare($delete_sql)) {
                                $stmt_delete->bind_param("s", $id);
                                if ($stmt_delete->execute()) {
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
                                            showRegisterSuccess();
                                        </script>";
                                } else {
                                    echo "มีข้อผิดพลาดในการลบข้อมูล: " . $conn->error;
                                }
                                $stmt_delete->close();
                            } else {
                                echo "มีข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $conn->error;
                            }
                        } else {
                            echo "มีข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error;
                        }
                        $stmt_update->close();
                    } else {
                        echo "มีข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $conn->error;
                    }
                } else {
                    echo "มีข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error;
                }
                $stmt_finish_course->close();
            } else {
                echo "มีข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $conn->error;
            }
        } else {
            echo "มีข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error;
        }
        $stmt_payment->close();
    } else {
        echo "มีข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $conn->error;
    }
}
$conn->close();
?>
</body>
</html>