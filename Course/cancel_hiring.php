<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ข้อมูลการจ้างเทรนเนอร์</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Mitr", sans-serif;
    }
    </style>
    <body>
<?php
session_name("user_session");
session_start();

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "trainer";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["course_id"])) {
            $course_id = $_POST["course_id"];
            $username = $_SESSION["username"];

            $sql_delete = "DELETE FROM hired_trainers WHERE username = '$username' AND course_id = '$course_id'";

            if ($conn->query($sql_delete) === TRUE) {
                echo "<script>
                window.onload = function() {
                    var welcomeMessage = 'ยกเลิกการจ้างแล้ว " . "';
                    var popup = document.createElement('div');
                    popup.innerHTML = welcomeMessage;
                    popup.style.backgroundColor = '#ffffff';
                    popup.style.border = '1px solid #cccccc';
                    popup.style.padding = '40px'; /* เพิ่ม padding เพื่อขยายขนาดของ pop-up */
                    popup.style.width = '600px'; /* เพิ่มความกว้างของ pop-up */
                    popup.style.height = '500px'; /* เพิ่มความสูงของ pop-up */
                    popup.style.textAlign = 'center'; /* จัดข้อความให้อยู่กึ่งกลาง */
                    popup.style.lineHeight = '1.5'; /* เพิ่มระยะห่างระหว่างบรรทัด */
                    popup.style.borderRadius = '20px'; /* เพิ่มมุมของ pop-up */
                    popup.style.boxShadow = '0px 0px 20px rgba(0, 0, 0, 0.3)'; /* เพิ่มเงาใน pop-up */
                    popup.style.position = 'fixed';
                    popup.style.top = '50%';
                    popup.style.left = '50%';
                    popup.style.transform = 'translate(-50%, -50%)';
                    popup.style.zIndex = '9999';
                    popup.style.fontSize = '54px'; /* เพิ่มขนาดตัวอักษร */
                    document.body.appendChild(popup);

                    setTimeout(function() {
                        popup.remove();
                        window.location.href = 'userhire.php';
                    }, 3000);
                };
            </script>";
            } else {
                echo "เกิดข้อผิดพลาดในการยกเลิกการจ้างเทรนเนอร์: " . $conn->error;
            }
        } else {
            echo "ไม่พบข้อมูล course_id";
        }
    } else {
        echo "ไม่มีการส่งข้อมูลแบบ POST";
    }

    $conn->close();
} else {
    echo "คุณต้องเข้าสู่ระบบเพื่อยกเลิกการจ้างเทรนเนอร์";
}
?>
</body>
</html>