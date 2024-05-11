<?php
session_name("user_session");
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}

$username = $_SESSION['username'];

if (isset($_GET['reject_course_id'])) {
  $course_id = $_GET['reject_course_id'];

  $conn = mysqli_connect('localhost', 'root', '', 'trainer');
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  $sql = "SELECT reject_date FROM reject_info WHERE course_id = $course_id";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    $row = mysqli_fetch_assoc($result);
    $reject_date = $row['reject_date'];
    $today = date('Y-m-d');
    $days_diff = floor((strtotime($today) - strtotime($reject_date)) / (60 * 60 * 24));
    if ($days_diff <= 5) {
      $cancel_sql = "DELETE FROM reject_info WHERE course_id = $course_id";
      if (mysqli_query($conn, $cancel_sql)) {
        echo "ยกเลิกการปฏิเสธคอร์สสำเร็จ";
      } else {
        echo "เกิดข้อผิดพลาดในการยกเลิกการปฏิเสธ: " . mysqli_error($conn);
      }
    } else {
      echo "ไม่สามารถยกเลิกการปฏิเสธได้เนื่องจากผ่านไปมากกว่า 5 วันแล้ว";
    }
  } else {
    echo "ไม่พบข้อมูลการปฏิเสธคอร์ส";
  }

  mysqli_close($conn);
}
?>
