<?php
// เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect('localhost', 'root', '', 'trainer');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// รับค่า payment_id ที่ส่งมาจากหน้าหลัก
$payment_id = $_POST['payment_id'];

// เขียนคำสั่ง SQL สำหรับปฏิเสธการชำระเงิน
$sql_delete_payment = "DELETE FROM payment WHERE id='$payment_id'";

if (mysqli_query($conn, $sql_update_payment)) {
    // อัพเดทสถานะในตาราง hired_trainers
    $sql_update_hired_trainers = "UPDATE hired_trainers SET status='rejected' WHERE id='$id'";
    mysqli_query($conn, $sql_update_hired_trainers);

    // อัพเดทสถานะในตาราง course_history_trainer
    $sql_update_course_history_trainer = "UPDATE course_history_trainer SET status='rejected' WHERE id='$id'";
    mysqli_query($conn, $sql_update_course_history_trainer);

    // อัพเดทสถานะในตาราง accepted_course
    $sql_update_accepted_course = "UPDATE accepted_course SET status='rejected' WHERE payment_id='$payment_id'";
    mysqli_query($conn, $sql_update_accepted_course);

    echo "การชำระเงินถูกปฏิเสธเรียบร้อยแล้ว โปรดชำระเงินใหม่";
} else {
    echo "Error: " . $sql_update_payment . "<br>" . mysqli_error($conn);
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>
