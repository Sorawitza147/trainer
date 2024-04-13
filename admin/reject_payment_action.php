<?php
// เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect('localhost', 'root', '', 'trainer');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// รับค่า payment_id และ payment_status ที่ส่งมาจากหน้าหลัก
$payment_id = $_POST['payment_id'];
$payment_status = $_POST['payment_status']; // รับค่าจาก form

// เขียนคำสั่ง SQL สำหรับปฏิเสธการชำระเงิน
$sql_delete_payment = "DELETE FROM payment WHERE payment_id='$payment_id'";

if (mysqli_query($conn, $sql_delete_payment)) {
    // อัพเดทสถานะในตาราง hired_trainers
    $sql_update_hired_trainers = "UPDATE hired_trainers SET payment_status='$payment_status' WHERE payment_id='$payment_id'";
    mysqli_query($conn, $sql_update_hired_trainers);

    // อัพเดทสถานะในตาราง course_history_trainer
    $sql_update_course_history_trainer = "UPDATE course_history_trainer SET payment_status='$payment_status' WHERE payment_id='$payment_id'";
    mysqli_query($conn, $sql_update_course_history_trainer);

    // อัพเดทสถานะในตาราง accepted_course
    $sql_update_accepted_course = "UPDATE accepted_course SET payment_status='$payment_status' WHERE payment_id='$payment_id'";
    mysqli_query($conn, $sql_update_accepted_course);

    echo "การชำระเงินถูกปฏิเสธเรียบร้อยแล้ว โปรดชำระเงินใหม่";
} else {
    echo "Error: " . $sql_delete_payment . "<br>" . mysqli_error($conn);
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>
