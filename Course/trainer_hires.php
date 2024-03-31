<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>รายการการจ้างเทรนเนอร์</title>
  <style>
  </style>
</head>
<body>
  <h1>รายการการจ้างเทรนเนอร์</h1>
  <?php
session_name("user_session");
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {

        if (isset($_POST["username"]) && isset($_POST["date"]) && isset($_POST["course_id"])) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "trainer";

            $conn = new mysqli($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $username = $_POST["username"];
            $date = $_POST["date"];
            $course_id = $_POST["course_id"];

            $sql = "INSERT INTO hired_trainers (username, date, course_id) VALUES ('$username', '$date', '$course_id')";

            if ($conn->query($sql) === TRUE) {
                echo "บันทึกข้อมูลการจ้างเทรนเนอร์เรียบร้อยแล้ว";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        } else {
            echo "ไม่พบข้อมูลที่ส่งมา";
        }
    } else {
        echo "คุณต้องเข้าสู่ระบบก่อนที่จะจ้างเทรนเนอร์";
    }
} else {
    echo "ไม่มีการส่งข้อมูลแบบ POST";
}
?>
</body>
</html>