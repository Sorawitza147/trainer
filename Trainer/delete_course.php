<?php
$conn = mysqli_connect('localhost', 'root', '', 'trainer');

if (!$conn) {
  die("การเชื่อมต่อกับฐานข้อมูลล้มเหลว: " . mysqli_connect_error());
}

if (isset($_GET['delete_course_id'])) {
  $delete_course_id = $_GET['delete_course_id'];
  $sql_check_activities = "SELECT * FROM course_activities WHERE course_id = ?";
  if ($stmt_check_activities = $conn->prepare($sql_check_activities)) {
    $stmt_check_activities->bind_param("i", $delete_course_id);
    $stmt_check_activities->execute();
    $result_check_activities = $stmt_check_activities->get_result();
    $stmt_check_activities->close();
    if ($result_check_activities->num_rows > 0) {
      $sql_delete_activities = "DELETE FROM course_activities WHERE course_id = ?";
      if ($stmt_delete_activities = $conn->prepare($sql_delete_activities)) {
        $stmt_delete_activities->bind_param("i", $delete_course_id);
        if ($stmt_delete_activities->execute()) {
          $stmt_delete_activities->close();
        } else {
          echo "เกิดข้อผิดพลาดในการลบกิจกรรมที่เกี่ยวข้องกับคอร์ส: " . $stmt_delete_activities->error;
          exit; 
        }
      } else {
        echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL สำหรับการลบกิจกรรมที่เกี่ยวข้องกับคอร์ส: " . $conn->error;
        exit; 
      }
    }

    // ลบคอร์ส
    $sql_delete_course = "DELETE FROM courses WHERE course_id = ?";
    if ($stmt_delete_course = $conn->prepare($sql_delete_course)) {
      $stmt_delete_course->bind_param("i", $delete_course_id);
      if ($stmt_delete_course->execute()) {
        echo "ลบคอร์สเรียบร้อยแล้ว";
        mysqli_close($conn);
        echo "<script>window.location.href = 'viewcourse.php';</script>"; 
        exit; 
      } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูลคอร์ส: " . $stmt_delete_course->error;
      }
      $stmt_delete_course->close();
    } else {
      echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL สำหรับการลบคอร์ส: " . $conn->error;
    }
  } else {
    echo "เกิดข้อผิดพลาดในการตรวจสอบกิจกรรมที่เกี่ยวข้องกับคอร์ส: " . $conn->error;
  }
} else {
  echo "ไม่ได้รับค่า ID ของคอร์สที่ต้องการลบ";
}

mysqli_close($conn);
?>