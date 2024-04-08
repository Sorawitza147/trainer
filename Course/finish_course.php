<?php
session_name("trainer_session");
session_start();
// เชื่อมต่อฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "trainer");

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่งค่า id มาหรือไม่
if (isset($_GET['id'])) {
    // รับค่าจาก URL parameters
    $course_id = $_GET['id'];
    $name = isset($_GET['name']) ? $_GET['name'] : '';
    $username = isset($_GET['username']) ? $_GET['username'] : '';
    $title = isset($_GET['title']) ? $_GET['title'] : '';
    $description = isset($_GET['description']) ? $_GET['description'] : '';
    $price = isset($_GET['price']) ? $_GET['price'] : '';
    $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
    $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
    $start_time = isset($_GET['start_time']) ? $_GET['start_time'] : '';
    $end_time = isset($_GET['end_time']) ? $_GET['end_time'] : '';
    $bank = isset($_GET['bank']) ? $_GET['bank'] : ''; // เพิ่มการรับค่า "bank" จาก URL parameters
    $account_number = isset($_GET['account_number']) ? $_GET['account_number'] : ''; // เพิ่มการรับค่า "account_number" จาก URL parameters
    $trainerusername = isset($_GET['trainerusername']) ? $_GET['trainerusername'] : ''; // เพิ่มการรับค่า "trainerusername" จาก URL parameters
    
    // จัดเตรียมคำสั่ง SQL เพื่อเพิ่มข้อมูลลงในตาราง finish_course
    $insert_sql = "INSERT INTO finish_course (course_id, name, username, title, description, price, end_date, start_date, start_time, end_time, bank, account_number, trainerusername) VALUES ('$course_id', '$name', '$username', '$title', '$description', '$price', '$end_date', '$start_date', '$start_time', '$end_time', '$bank', '$account_number', '$trainerusername')";

    // เพิ่มข้อมูลลงในตาราง finish_course
    if ($conn->query($insert_sql) === TRUE) {
        // ลบข้อมูลจากตาราง accepted_course โดยใช้คำสั่ง SQL
        $delete_sql = "DELETE FROM accepted_course WHERE course_id='$course_id'";
        
        // ลบข้อมูลจากตาราง accepted_course
        if ($conn->query($delete_sql) === TRUE) {
            // อัพเดต status ในตาราง course_history_trainer เป็น "เสร็จสิ้นแล้ว"
            $update_sql = "UPDATE course_history_trainer SET status='เสร็จสิ้นแล้ว' WHERE course_id='$course_id'";
            
            // อัพเดต status ในตาราง course_history_trainer
            if ($conn->query($update_sql) === TRUE) {
                echo "<script>
                window.onload = function() {
                    var welcomeMessage = 'สำเร็จ " . "';
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
                        window.location.href = '../indextrainer.php';
                    }, 3000);
                };
            </script>";
            } else {
                echo "มีข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error;
            }
        } else {
            echo "มีข้อผิดพลาดในการลบข้อมูล: " . $conn->error;
        }
    } else {
        echo "มีข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error;
    }
} else {
    echo "ไม่พบข้อมูลที่ต้องการ";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
