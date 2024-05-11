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
$conn = mysqli_connect('localhost', 'root', '', 'trainer');
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
if (isset($_POST['payment_id'])) {
  $payment_id = $_POST['payment_id'];
  $sql = "SELECT * FROM payment WHERE id = $payment_id";
  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
    $payment_data = mysqli_fetch_assoc($result); 
    $update_course_history_sql = "UPDATE course_history_trainer SET payment_status = 'ชำระเงินสำเร็จ' WHERE course_id = {$payment_data['course_id']}";
    if (!mysqli_query($conn, $update_course_history_sql)) {
        echo "Error updating record in course_history_trainer: " . mysqli_error($conn);
    }

    $update_hired_trainers_sql = "UPDATE hired_trainers SET payment_status = 'ชำระเงินสำเร็จ' WHERE course_id = {$payment_data['course_id']}";
    if (!mysqli_query($conn, $update_hired_trainers_sql)) {
        echo "Error updating record in hired_trainers: " . mysqli_error($conn);
    }

    $update_accepted_course_sql = "UPDATE accepted_course SET payment_status = 'ชำระเงินสำเร็จ' WHERE course_id = {$payment_data['course_id']}";
    if (!mysqli_query($conn, $update_accepted_course_sql)) {
        echo "Error updating record in accepted_course: " . mysqli_error($conn);
    }
    $course_id = $payment_data['course_id'];
        $update_course_sql = "UPDATE courses SET course_status = 'ชำระเงินสำเร็จรอเทรนเนอร์ตอบรับ' WHERE course_id = '$course_id'";
        if (!mysqli_query($conn, $update_course_sql)) {
            echo "Error updating record in courses: " . mysqli_error($conn);
        }
    $delete_payment_sql = "DELETE FROM payment WHERE id = $payment_id";
    if (!mysqli_query($conn, $delete_payment_sql)) {
        echo "Error deleting record in payment: " . mysqli_error($conn);
    }

    echo "<script>
        function showRegisterSuccess() {
          Swal.fire({
              icon: 'success',
              title: 'ยอมรับการชำระเงินเรียบร้อยแล้ว',
              confirmButtonText: 'ตกลง'
          }).then(() => {
              window.location.href = 'admin_dashboard.php';
          });
        }
        showRegisterSuccess(); // เรียกใช้ฟังก์ชันเพื่อแสดงหน้าต่างแจ้งเตือน
      </script>";

  } else {
    echo "Payment not found.";
  }
} else {
  echo "Invalid request.";
}
mysqli_close($conn);
?>
</body>
</html>
