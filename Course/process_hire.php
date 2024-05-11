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
<body><?php
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
            $payment_status = $_POST["payment_status"];
            $payment_id = $_POST["payment_id"];
            $course = $_POST["course"];
            $course_status = "ติดจ้าง"; // ตั้งค่าสถานะใหม่เป็น "ติดจ้าง"

            $hired_trainers_sql = "INSERT INTO hired_trainers (username, trainerusername, course_id, trainer_id, status, payment_status, payment_id, course) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt1 = $conn->prepare($hired_trainers_sql);
            $stmt1->bind_param("ssssssss", $username, $trainerusername, $course_id, $trainer_id, $status, $payment_status, $payment_id, $course);
        

            if ($stmt1->execute()) {
                $course_history_sql = "INSERT INTO course_history_trainer (username, course, trainerusername, course_id, trainer_id, status, course_status, payment_status, payment_id, title, cover_image, name, email, age, phone_number, description, price, difficulty, start_date, end_date, start_time, end_time) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt2 = $conn->prepare($course_history_sql);
            $stmt2->bind_param("ssssssssssssssssssssss", $username, $course, $trainerusername, $course_id, $trainer_id, $status, $course_status, $payment_status, $payment_id, $_POST["title"], $_POST["cover_image"], $_POST["name"], $_POST["email"], $_POST["age"], $_POST["phone_number"], $_POST["description"], $_POST["price"], $_POST["difficulty"], $_POST["start_date"], $_POST["end_date"], $_POST["start_time"], $_POST["end_time"]);



                if ($stmt2->execute()) {
                    // อัพเดทสถานะของคอร์สเป็น "ติดจ้าง" ในตาราง courses
                    $update_course_status_sql = "UPDATE courses SET course_status = 'ติดจ้าง' WHERE course_id = ?";
                    $stmt3 = $conn->prepare($update_course_status_sql);
                    $stmt3->bind_param("i", $course_id);
                    $stmt3->execute();

                    echo "<script>
                        function showRegisterSuccess() {
                        Swal.fire({
                            icon: 'success',
                            title: 'จ้างสำเร็จรอเทรนเนอร์ตอบรับและโปรดชำระเงิน',
                            confirmButtonText: 'ตกลง'
                        }).then(() => {
                            window.location.href = 'usercourse.php';
                        });
                        }
                        showRegisterSuccess(); 
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

</body>
</html>