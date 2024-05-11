<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Web Page</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Mitr", sans-serif;
        }
  </style>
</head>
<body>
<?php
session_name("trainer_session");
session_start();

if (!isset($_SESSION['trainerusername'])) {
  header('Location: login.php');
  exit();
}

$trainerusername = $_SESSION['trainerusername'];

if (isset($_GET['accept_course_id'])) {
  $id = $_GET['accept_course_id']; 

  $conn = mysqli_connect('localhost', 'root', '', 'trainer');
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $select_hired_course_sql = "SELECT * FROM hired_trainers WHERE id = $id"; 

  $result = mysqli_query($conn, $select_hired_course_sql);
  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    
    // เพิ่มข้อมูลลงในตาราง accepted_course
    $insert_accepted_course_sql = "INSERT INTO accepted_course (
          course_id, 
          payment_id,
          course,
          name,
          username, 
          trainerusername, 
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
          status,
          payment_status
        ) 
        SELECT 
          h.course_id, 
          h.payment_id,
          h.course, 
          c.name,
          h.username, 
          h.trainerusername,
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
          'ยอมรับ',
          h.payment_status
        FROM 
          hired_trainers h 
          INNER JOIN courses c ON h.course_id = c.course_id 
        WHERE 
          h.id = $id"; 

    if (mysqli_query($conn, $insert_accepted_course_sql)) {
      // ลบข้อมูลจากตาราง course_activities
      $delete_course_activities_sql = "DELETE FROM course_activities WHERE course_id=?";
      $stmt_delete_course_activities = $conn->prepare($delete_course_activities_sql);
      $stmt_delete_course_activities->bind_param("s", $row['course_id']);
      $stmt_delete_course_activities->execute();
      $stmt_delete_course_activities->close();

      // ลบข้อมูลจากตาราง courses
      $delete_courses_sql = "DELETE FROM courses WHERE course_id=?";
      $stmt_delete_courses = $conn->prepare($delete_courses_sql);
      $stmt_delete_courses->bind_param("s", $row['course_id']);
      $stmt_delete_courses->execute();
      $stmt_delete_courses->close();

      // ลบข้อมูลจากตาราง hired_trainers
      $delete_hired_trainers_sql = "DELETE FROM hired_trainers WHERE id = $id"; 
      mysqli_query($conn, $delete_hired_trainers_sql);

      // อัปเดตสถานะในตาราง course_history_trainer
      $update_course_history_sql = "UPDATE course_history_trainer SET status = 'ยอมรับ' WHERE id = $id"; 
      mysqli_query($conn, $update_course_history_sql);

      // เรียกใช้ฟังก์ชัน JavaScript แสดงการยอมรับสำเร็จ
      echo "<script>
        function showRegisterSuccess() {
          Swal.fire({
              icon: 'success',
              title: 'ยอมรับสำเร็จ',
              confirmButtonText: 'ตกลง'
          }).then(() => {
              window.location.href = 'Hire.php';
          });
        }
        showRegisterSuccess(); // เรียกใช้ฟังก์ชันเพื่อแสดงหน้าต่างแจ้งเตือน
      </script>";
    } else {
      echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูลลงในตาราง accepted_course: " . mysqli_error($conn);
    }
  } else {
    echo "ไม่พบข้อมูลคอร์สที่มี ID เดียวกันในตาราง hired_trainers";
  }
  mysqli_close($conn);
}
?>
</body>
</html>
