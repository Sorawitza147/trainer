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
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trainer";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM payment_info WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                  function showDeleteSuccess() {
                    alert('ลบข้อมูลสำเร็จ');
                    window.location.href = 'indextrainer.php';
                  }
                  showDeleteSuccess(); // เรียกใช้ฟังก์ชันเพื่อแสดงการลบข้อมูลสำเร็จ
                </script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "ไม่ได้รับค่า 'id' ที่ต้องการลบ";
}

$conn->close();
?>
</body>
</html>
