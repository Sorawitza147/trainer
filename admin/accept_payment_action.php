<?php
// เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect('localhost', 'root', '', 'trainer');
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['payment_id'])) {
  $payment_id = $_POST['payment_id'];

  // เรียกดูข้อมูลการชำระเงินจากฐานข้อมูล
  $sql = "SELECT * FROM payment WHERE id = $payment_id";
  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
    $payment_data = mysqli_fetch_assoc($result); // เพิ่ม ; ที่นี่

    // อัปเดตสถานะในตาราง course_history_trainer
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

    // เริ่มลบข้อมูลจากตาราง payment หลังจากยอมรับการชำระเงินเรียบร้อย
    $delete_payment_sql = "DELETE FROM payment WHERE id = $payment_id";
    if (!mysqli_query($conn, $delete_payment_sql)) {
        echo "Error deleting record in payment: " . mysqli_error($conn);
    }

    echo "<script>window.location.href = 'admin_dashboard.php';</script>";
  } else {
    echo "Payment not found.";
  }
} else {
  echo "Invalid request.";
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>
