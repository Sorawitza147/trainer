<?php
// เชื่อมต่อฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "trainer");

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่งค่า course_id มาหรือไม่
if (isset($_GET['reject_course_id'])) {
    // รับค่าจาก URL parameters
    $course_id = $_GET['reject_course_id'];

    // ตรวจสอบว่ามีค่า 'bank' และ 'account_number' ที่ส่งมาหรือไม่
    if (isset($_GET['bank']) && isset($_GET['account_number'])) {
        // รับค่า 'bank' และ 'account_number'
        $bank = $_GET['bank'];
        $account_number = $_GET['account_number'];

        // ดึงข้อมูลของคอร์สที่จะถูก reject และ username จากฐานข้อมูล courses และ hired_trainers
        $sql = "SELECT courses.*, hired_trainers.username, hired_trainers.payment_status
            FROM courses
            INNER JOIN hired_trainers ON courses.course_id = hired_trainers.course_id
            WHERE courses.course_id = '$course_id'";

        $result_course = $conn->query($sql);

        if ($result_course->num_rows > 0) {
            $row_course = $result_course->fetch_assoc();

            // เพิ่มข้อมูลลงในตาราง payment_refund_trainer
            $insert_sql = "INSERT INTO payment_refund_trainer (course_id, username, title, price, bank, account_number) 
                           VALUES ('$course_id', '{$row_course['username']}', '{$row_course['title']}', '{$row_course['price']}', '$bank', '$account_number')";
            
            if ($conn->query($insert_sql) === TRUE) {
                // ลบข้อมูลจากตาราง hired_trainers
                $delete_sql = "DELETE FROM hired_trainers WHERE course_id='$course_id'";
                if ($conn->query($delete_sql) === TRUE) {
                    echo "ลบข้อมูลและบันทึกการคืนเงินเรียบร้อยแล้ว";
                } else {
                    echo "มีข้อผิดพลาดในการลบข้อมูล: " . $conn->error;
                }
            } else {
                echo "มีข้อผิดพลาดในการบันทึกข้อมูลการคืนเงิน: " . $conn->error;
            }
        } else {
            echo "ไม่พบข้อมูลคอร์สที่ต้องการ reject";
        }
    } else {
        echo "ข้อมูล 'bank' หรือ 'account_number' ไม่ถูกส่งมา";
    }
} else {
    echo "ไม่พบข้อมูลที่ต้องการ";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
