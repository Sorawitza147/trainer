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
  $id = $_GET['accept_course_id']; // เปลี่ยนตัวแปรจาก course_id เป็น id

  $conn = mysqli_connect('localhost', 'root', '', 'trainer');
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // ดึงข้อมูลคอร์สที่มี id เดียวกันจากตาราง hired_trainers
  $select_hired_course_sql = "SELECT * FROM hired_trainers WHERE id = $id"; // เปลี่ยนจาก course_id เป็น id

  $result = mysqli_query($conn, $select_hired_course_sql);
  if ($result && mysqli_num_rows($result) > 0) {
    // ดึงข้อมูลคอร์ส
    $row = mysqli_fetch_assoc($result);

    // ลบข้อมูลในตาราง accepted_course ที่มีคอร์ส ID เดิม
    $delete_accepted_course_sql = "DELETE FROM accepted_course WHERE id = $id"; // เปลี่ยนจาก course_id เป็น id

    if (mysqli_query($conn, $delete_accepted_course_sql)) {
      // เพิ่มข้อมูลใหม่ในตาราง accepted_course
      $insert_accepted_course_sql = "INSERT INTO accepted_course (
          course_id, 
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
          h.id = $id"; // เปลี่ยนจาก course_id เป็น id

      if (mysqli_query($conn, $insert_accepted_course_sql)) {
        // เมื่อเพิ่มข้อมูลใหม่ใน accepted_course เรียบร้อยแล้ว ให้ลบข้อมูลใน hired_trainers
        $delete_hired_trainers_sql = "DELETE FROM hired_trainers WHERE id = $id"; // เปลี่ยนจาก course_id เป็น id

        if (mysqli_query($conn, $delete_hired_trainers_sql)) {
          $update_course_history_sql = "UPDATE course_history_trainer SET status = 'ยอมรับ' WHERE id = $id"; // เปลี่ยนจาก course_id เป็น id

          if (mysqli_query($conn, $update_course_history_sql)) {
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
            echo "เกิดข้อผิดพลาดในการอัปเดตสถานะในตาราง course_history_trainer: " . mysqli_error($conn);
          }
        } else {
          echo "เกิดข้อผิดพลาดในการลบข้อมูลจากตาราง hired_trainers: " . mysqli_error($conn);
        }
      } else {
        echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูลใหม่ในตาราง accepted_course: " . mysqli_error($conn);
      }
    } else {
      echo "เกิดข้อผิดพลาดในการลบข้อมูลในตาราง accepted_course: " . mysqli_error($conn);
    }
  } else {
    echo "ไม่พบข้อมูลคอร์สที่มี ID เดียวกันในตาราง hired_trainers";
  }

  mysqli_close($conn);
}
?>
</body>
</html>
