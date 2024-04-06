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

    // ดึงข้อมูลของคอร์สที่จะถูก reject และ username จากฐานข้อมูล courses และ hired_trainers
    $sql = "SELECT courses.*, hired_trainers.username, hired_trainers.payment_status
        FROM courses
        INNER JOIN hired_trainers ON courses.course_id = hired_trainers.course_id
        WHERE courses.course_id = '$course_id'";

    $result_course = $conn->query($sql);

    if ($result_course->num_rows > 0) {
        $row_course = $result_course->fetch_assoc();

        // ตรวจสอบ payment_status ว่าเป็น "ชำระเงินสำเร็จ" หรือไม่
        if ($row_course["payment_status"] === "ชำระเงินสำเร็จ") {
            // ดึงข้อมูลที่ต้องการจากคอร์สที่ถูก reject
            $title = $row_course['title'];
            $username = $row_course['username']; // ดึงข้อมูล username จาก hired_trainers
            $price = $row_course['price'];

            // เพิ่มข้อมูลลงในตาราง payment_refund_trainer
            $insert_sql = "INSERT INTO payment_refund_trainer (course_id, username, title, price) VALUES ('$course_id', '$username', '$title', '$price')";
            
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
            // ไม่ต้องแจ้งเตือนอะไร ทำการลบข้อมูลเลย
            $delete_sql = "DELETE FROM hired_trainers WHERE course_id='$course_id'";
            if ($conn->query($delete_sql) === TRUE) {
                echo "ลบข้อมูลเรียบร้อยแล้ว";
            } else {
                echo "มีข้อผิดพลาดในการลบข้อมูล: " . $conn->error;
            }
        }
    } else {
        echo "ไม่พบข้อมูลคอร์สที่ต้องการ reject";
    }
} else {
    echo "ไม่พบข้อมูลที่ต้องการ";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
