<?php
session_name("trainer_session");
session_start();

if (!isset($_SESSION['trainerusername'])) {
  header('Location: login.php');
  exit();
}

$trainerusername = $_SESSION['trainerusername'];

if (isset($_GET['accept_course_id'])) {
  $course_id = $_GET['accept_course_id'];

  $conn = mysqli_connect('localhost', 'root', '', 'trainer');
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // สร้าง SQL เพื่ออัปเดตสถานะของคอร์สในตาราง hired_trainers เป็น "ยอมรับ"
  $update_hired_trainers_sql = "UPDATE hired_trainers SET status = 'ยอมรับ' WHERE course_id = $course_id";

  if (mysqli_query($conn, $update_hired_trainers_sql)) {
    // เมื่ออัปเดตสถานะสำเร็จใน hired_trainers ให้ดึงข้อมูลคอร์สจากตาราง hired_trainers
    $select_hired_course_sql = "SELECT * FROM hired_trainers WHERE course_id = $course_id";

    $result = mysqli_query($conn, $select_hired_course_sql);
    if ($result && mysqli_num_rows($result) > 0) {
      // ดึงข้อมูลคอร์ส
      $row = mysqli_fetch_assoc($result);
      
      // ลบข้อมูลในตาราง accepted_course ที่มีคอร์ส ID เดิม
      $delete_accepted_course_sql = "DELETE FROM accepted_course WHERE course_id = $course_id";

      if (mysqli_query($conn, $delete_accepted_course_sql)) {
        // เพิ่มข้อมูลใหม่ในตาราง accepted_course
        $insert_accepted_course_sql = "INSERT INTO accepted_course (
          course_id, 
          name,
          username, 
          email, 
          age, 
          gender, 
          phone_number, 
          trainer_id, 
          title, 
          price, 
          duration, 
          difficulty, 
          description, 
          start_date, 
          end_date, 
          start_time, 
          end_time, 
          cover_image, 
          created_at, 
          updated_at, 
          status
        ) 
        SELECT 
          h.course_id, 
          c.name,
          h.username, 
          c.email, 
          c.age, 
          c.gender, 
          c.phone_number, 
          h.trainer_id, 
          c.title, 
          c.price, 
          c.duration, 
          c.difficulty, 
          c.description, 
          c.start_date, 
          c.end_date, 
          c.start_time, 
          c.end_time, 
          c.cover_image, 
          c.created_at, 
          c.updated_at, 
          'ยอมรับ' 
        FROM 
          hired_trainers h 
          INNER JOIN courses c ON h.course_id = c.course_id 
        WHERE 
          h.course_id = $course_id";                

        if (mysqli_query($conn, $insert_accepted_course_sql)) {
          // เมื่อเพิ่มข้อมูลใหม่ใน accepted_course เรียบร้อยแล้ว ให้ลบข้อมูลใน hired_trainers
          $delete_hired_trainers_sql = "DELETE FROM hired_trainers WHERE course_id = $course_id";

          if (mysqli_query($conn, $delete_hired_trainers_sql)) {
              // ทำสิ่งที่คุณต้องการให้เป็นไปตามกระบวนการ
          } else {
              echo "เกิดข้อผิดพลาดในการลบข้อมูลจากตาราง hired_trainers: " . mysqli_error($conn);
          }
        } else {
          echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูลใหม่ในตาราง accepted_course: " . mysqli_error($conn);
        }

        mysqli_close($conn);
      }
    }
  } else {
    echo "เกิดข้อผิดพลาดในการอัปเดตสถานะในตาราง hired_trainers: " . mysqli_error($conn);
  }
}
?>
