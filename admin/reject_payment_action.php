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
if (isset($_POST['payment_id']) && isset($_POST['payment_status']) && !empty($_POST['payment_id']) && !empty($_POST['payment_status'])) {
    $payment_id = $_POST['payment_id'];
    $payment_status = $_POST['payment_status']; 
    $sql_delete_payment = "DELETE FROM payment WHERE payment_id='$payment_id'";

    if (mysqli_query($conn, $sql_delete_payment)) {
        $sql_update_hired_trainers = "UPDATE hired_trainers SET payment_status='$payment_status' WHERE payment_id='$payment_id'";
        mysqli_query($conn, $sql_update_hired_trainers);
        $sql_update_course_history_trainer = "UPDATE course_history_trainer SET payment_status='$payment_status' WHERE payment_id='$payment_id'";
        mysqli_query($conn, $sql_update_course_history_trainer);
        $sql_update_accepted_course = "UPDATE accepted_course SET payment_status='$payment_status' WHERE payment_id='$payment_id'";
        mysqli_query($conn, $sql_update_accepted_course);

        echo "<script>
        function showRegisterSuccess() {
          Swal.fire({
              icon: 'success',
              title: 'ปฏิเสธสำเร็จ',
              confirmButtonText: 'ตกลง'
          }).then(() => {
              window.location.href = 'admin_dashboard.php';
          });
        }
        showRegisterSuccess(); // เรียกใช้ฟังก์ชันเพื่อแสดงหน้าต่างแจ้งเตือน
      </script>";

    } else {
        echo "Error: " . $sql_delete_payment . "<br>" . mysqli_error($conn);
    }
} else {
    echo "ข้อมูลไม่ครบถ้วน";
}
mysqli_close($conn);
?>
</body>
</html>
