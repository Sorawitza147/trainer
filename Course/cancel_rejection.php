<?php
$conn = mysqli_connect('localhost', 'root', '', 'trainer');
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if(isset($_GET['course_id'])) {
  $course_id = $_GET['course_id'];

  // ดึงวันที่ปฏิเสธคอร์ส
  $sql = "SELECT hired_at FROM hired_trainers WHERE course_id = $course_id";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $hired_at = strtotime($row['hired_at']);

      // คำนวณระยะเวลาตั้งแต่วันที่ปฏิเสธคอร์สจนถึงปัจจุบัน
      $current_date = time();
      $difference = ($current_date - $hired_at) / (60 * 60 * 24); // หาระยะเวลาในหน่วยวัน

      // ถ้ายังไม่เกิน 5 วัน ให้ทำการยกเลิกการปฏิเสธคอร์ส
      if ($difference <= 5) {
        // อัปเดตสถานะของคอร์สเป็น 'ยอมรับ'
        $sql_update = "UPDATE hired_trainers SET status = 'ยอมรับ' WHERE course_id = $course_id";
        if (mysqli_query($conn, $sql_update)) {
          echo "<p>ยกเลิกการปฏิเสธคอร์สเรียบร้อยแล้ว</p>";
        } else {
          echo "Error updating record: " . mysqli_error($conn);
        }
      } else {
        echo "<p>ไม่สามารถยกเลิกการปฏิเสธคอร์สได้ เนื่องจากเกินระยะเวลาที่กำหนด</p>";
      }
    } else {
      echo "<p>ไม่พบข้อมูลคอร์สที่ต้องการยกเลิกการปฏิเสธ</p>";
    }
  } else {
    echo "Error: " . mysqli_error($conn);
  }

  mysqli_close($conn);
} else {
  echo "<p>ไม่พบรหัสคอร์สที่ต้องการยกเลิกการปฏิเสธ</p>";
}
?>
