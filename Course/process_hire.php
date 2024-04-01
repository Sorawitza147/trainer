<?php
session_name("user_session");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
        if (isset($_POST["username"]) && isset($_POST["course_id"]) && isset($_POST["trainerusername"]) && isset($_POST["trainer_id"]) && isset($_POST["status"]) && isset($_POST["start_date"]) && isset($_POST["end_date"])) {

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
                    VALUES (?, ?, ?, ?, ?)";
            $stmt1 = $conn->prepare($hired_trainers_sql);
            $stmt1->bind_param("sssss", $username, $trainerusername, $course_id, $trainer_id, $status);

            if ($stmt1->execute()) {
                // เพิ่มข้อมูลลงในตาราง course_history_trainer
                $course_history_sql = "INSERT INTO course_history_trainer (username, trainerusername, course_id, trainer_id, status, title, cover_image, name, email, age, phone_number, description, price, difficulty, start_date, end_date, start_time, end_time) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt2 = $conn->prepare($course_history_sql);
                $stmt2->bind_param("ssssssssssssssssss", $username, $trainerusername, $course_id, $trainer_id, $status, $_POST["title"], $_POST["cover_image"], $_POST["name"], $_POST["email"], $_POST["age"], $_POST["phone_number"], $_POST["description"], $_POST["price"], $_POST["difficulty"], $_POST["start_date"], $_POST["end_date"], $_POST["start_time"], $_POST["end_time"]);

                if ($stmt2->execute()) {
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
                    echo "Error: " . $stmt2->error;
                }
                $stmt2->close();
            } else {
                echo "Error: " . $stmt1->error;
            }
            $stmt1->close();

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
