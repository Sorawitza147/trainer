<?php
session_start();
if (isset($_POST['cancelTime'])) {
    $cancelTime = $_POST['cancelTime'];
    // ทำสิ่งที่ต้องการกับเวลาที่ได้รับ เช่น บันทึกลงในฐานข้อมูลหรือนำไปตั้งค่าในระบบ 2c2p
    $_SESSION['cancelTime'] = $cancelTime; // เก็บข้อมูลเวลาใน session เพื่อนำไปใช้ในส่วนอื่นๆ ของเว็บไซต์
    echo 'ตั้งค่าเวลายกเลิกเรียบร้อยแล้ว';
} else {
    echo 'ไม่สามารถรับข้อมูลเวลาได้';
}
?>
