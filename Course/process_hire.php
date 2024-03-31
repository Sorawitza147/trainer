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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
        if (isset($_POST["username"]) && isset($_POST["course_id"]) && isset($_POST["trainerusername"]) && isset($_POST["trainer_id"]) && isset($_POST["status"])) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "trainer";

            $conn = new mysqli($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $username = $_POST["username"];
            $course_id = $_POST["course_id"];
            $trainerusername = $_POST["trainerusername"];
            $trainer_id = $_POST["trainer_id"];
            $status = $_POST["status"];
            
            // เพิ่มข้อมูลลงในตาราง hired_trainers
            $hired_trainers_sql = "INSERT INTO hired_trainers (username, trainerusername, course_id, trainer_id, status) 
                    VALUES ('$username', '$trainerusername', '$course_id', '$trainer_id', '$status')";

            if ($conn->query($hired_trainers_sql) === TRUE) {
                // เพิ่มข้อมูลลงในตาราง course_history_trainer
                $course_history_sql = "INSERT INTO course_history_trainer (username, trainerusername, course_id, trainer_id, status) 
                VALUES ('$username', '$trainerusername', '$course_id', '$trainer_id', '$status')";

                if ($conn->query($course_history_sql) === TRUE) {
                    // แสดงข้อความแจ้งเตือน
                    echo "<script>
                        window.onload = function() {
                            var welcomeMessage = 'บันทึกการจ้างสำเร็จ';
                            var popup = document.createElement('div');
                            popup.innerHTML = welcomeMessage;
                            popup.style.backgroundColor = '#ffffff';
                            popup.style.border = '1px solid #cccccc';
                            popup.style.padding = '40px';
                            popup.style.width = '600px';
                            popup.style.height = '500px';
                            popup.style.textAlign = 'center';
                            popup.style.lineHeight = '1.5';
                            popup.style.borderRadius = '20px';
                            popup.style.boxShadow = '0px 0px 20px rgba(0, 0, 0, 0.3)';
                            popup.style.position = 'fixed';
                            popup.style.top = '50%';
                            popup.style.left = '50%';
                            popup.style.transform = 'translate(-50%, -50%)';
                            popup.style.zIndex = '9999';
                            popup.style.fontSize = '54px';
                            document.body.appendChild(popup);

                            setTimeout(function() {
                                popup.remove();
                                window.location.href = 'usercourse.php';
                            }, 3000);
                        };
                    </script>";
                } else {
                    echo "Error: " . $course_history_sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error: " . $hired_trainers_sql . "<br>" . $conn->error;
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