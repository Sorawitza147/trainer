<?php
$conn = mysqli_connect('localhost', 'root', '', 'trainer');

if (!$conn) {
    die("การเชื่อมต่อกับฐานข้อมูลล้มเหลว: " . mysqli_connect_error());
}


if(isset($_GET['delete_course_id'])) {

    $course_id = $_GET['delete_course_id'];
    $sql = "DELETE FROM courses WHERE id = $course_id";

    if (mysqli_query($conn, $sql)) {
        echo "ลบคอร์สเรียบร้อยแล้ว";
    } else {
        echo "เกิดข้อผิดพลาดในการลบคอร์ส: " . mysqli_error($conn);
    }
} else {
    echo "ไม่ได้รับค่า ID ของคอร์สที่ต้องการลบ";
}

mysqli_close($conn);
?>