<?php
session_name("trainer_session");
session_start();

// เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect('localhost', 'root', '', 'trainer');

// ดึงข้อมูล hired_trainers ที่มี course_id ตรงกับ course_id ที่ส่งมา
$course_id = $_POST['course_id'];

$sql = "SELECT * FROM hired_trainers WHERE course_id = $course_id";

$result = mysqli_query($conn, $sql);

if ($result) {
  $row = mysqli_fetch_assoc($result);
  
  $sql = "DELETE FROM hired_trainers WHERE course_id = $course_id";
  
  if (mysqli_query($conn, $sql)) {
    echo json_encode(array("success" => true));
  } else {
    echo json_encode(array("success" => false, "error" => "เกิดข้อผิดพลาดในการลบข้อมูล"));
  }
} else {
  echo json_encode(array("success" => false, "error" => "ไม่พบข้อมูล hired_trainers"));
}

mysqli_close($conn);
?>