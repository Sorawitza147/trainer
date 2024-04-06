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
</head>
<body>
<?php
session_name("user_session");
session_start();

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    // ตรวจสอบว่ามีการส่ง course_id ผ่าน URL หรือไม่
    if ($_SERVER["REQUEST_METHOD"] == "GET" && !isset($_GET['course_id'])) {
        echo "กรุณาระบุ course_id";
        exit;
    }

    // ตรวจสอบว่ามีการส่ง course_id ผ่านแบบฟอร์ม POST หรือไม่
    if ($_SERVER["REQUEST_METHOD"] == "POST" && (!isset($_POST['course_id']) || empty($_POST['course_id']))) {
        echo "กรุณาระบุ course_id";
        exit;
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "trainer";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // รับค่า course_id จาก URL
    if(isset($_GET['course_id'])) {
        $course_id = $_GET['course_id'];
    }

    // รับค่า course_id จากแบบฟอร์ม POST
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["course_id"])) {
        $course_id = $_POST["course_id"];
    }

    // ตรวจสอบว่ามีข้อมูลของคอร์สที่ต้องการบันทึก
    $sql_course = "SELECT courses.title, courses.price, courses.course_id, hired_trainers.payment_status, user.bank, user.account_number 
    FROM hired_trainers 
    INNER JOIN courses ON hired_trainers.course_id = courses.course_id 
    INNER JOIN user ON hired_trainers.username = user.username
    WHERE hired_trainers.course_id = '$course_id'";
    $result_course = $conn->query($sql_course);
    if ($result_course->num_rows > 0) {
        $row_course = $result_course->fetch_assoc();
        if ($row_course["payment_status"] === "ชำระเงินสำเร็จ") {
            // ตรวจสอบว่าคีย์ 'title' และ 'price' มีอยู่ใน $row_course หรือไม่
            if (isset($row_course["title"]) && isset($row_course["price"])) {
                // บันทึกข้อมูลลงในตาราง payment_refund
                $username = $_SESSION["username"];
                $course_id = $row_course["course_id"];
                $course_title = $row_course["title"];
                $course_price = $row_course["price"];
                $bank = $row_course["bank"];
                $account_number = $row_course["account_number"];

                // สร้างคำสั่ง SQL สำหรับการเพิ่มข้อมูล
                $sql_insert_refund = "INSERT INTO payment_refund (course_id, username, title, price, bank, account_number) 
                VALUES ('$course_id', '$username', '$course_title', '$course_price', '$bank', '$account_number')";

                // Execute คำสั่ง SQL เพื่อบันทึกข้อมูล
                if (mysqli_query($conn, $sql_insert_refund)) {
                    echo "";
                } else {
                    echo "Error: " . $sql_insert_refund . "<br>" . mysqli_error($conn);
                }
            }
        }
    }

    // รับข้อมูลจากแบบฟอร์มโดยใช้ HTTP POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["course_id"])) {
            $course_id = $_POST["course_id"];
            $username = $_SESSION["username"];

            // กำหนดคำสั่ง SQL ใน $sql_update_status ก่อนที่จะใช้
            $sql_update_status = "UPDATE course_history_trainer SET status = 'ยกเลิกจ้าง' WHERE course_id = '$course_id'";

            $sql_delete = "DELETE FROM hired_trainers WHERE username = '$username' AND course_id = '$course_id'";

            if ($conn->query($sql_delete) === TRUE) {
                // อัพเดตสถานะในตาราง hired_trainers เป็น 'ยกเลิก'
                // เพิ่มเข้าตาราง course_history_trainer
                if ($conn->query($sql_update_status) === TRUE) {
                    echo "<script>
                        window.onload = function() {
                            var welcomeMessage = 'ยกเลิกการจ้างแล้ว';
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
                echo "เกิดข้อผิดพลาดในการยกเลิกการจ้างเทรนเนอร์: " . $conn->error;
            }
        } else {
            echo "ไม่พบข้อมูล course_id";
        }
    }
    $conn->close();
} else {
    echo "คุณต้องเข้าสู่ระบบเพื่อยกเลิกการจ้างเทรนเนอร์";
}
?>

</body>
</html>
