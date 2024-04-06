<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ตาราง hired_trainers</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Mitr", sans-serif;
}
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
}
th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    vertical-align: middle; /* จัดเนื้อหาในแนวตั้งตรงกลาง */
}
th {
    background-color: #f2f2f2;
    font-weight: bold;
}
tr:hover {
    background-color: #e2e6ea;
}
a {
    text-decoration: none;
    color: #007bff;
}
a:hover {
    color: #0056b3;
}
.back-button {
    margin-top: 20px;
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    display: block;
    float: right; /* จัดปุ่มไปด้านขวา */
}
.action-links {
    display: flex; /* จัดเรียงลิงก์ในแนวนอน */
}
.action-link {
    padding: 5px 10px;
    border-radius: 3px;
    text-decoration: none;
    margin-right: 5px; /* ระยะห่างระหว่างลิงก์ */
}
.accept-link {
    background-color: #28a745;
    color: #fff;
}
.cancel-link {
    background-color: #dc3545;
    color: #fff;
}
.topic {
    font-size: 30px;
    font-weight: bold;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 50px;
    margin-bottom: 20px;
}
</style>
</head>
<body>

<?php
session_name("trainer_session");
session_start();

if (!isset($_SESSION['trainerusername'])) {
    header('Location: login.php');
    exit();
}

$trainerusername = $_SESSION['trainerusername'];

$conn = mysqli_connect('localhost', 'root', '', 'trainer');
if(isset($_GET['delete_course_id'])) {
    $course_id = $_GET['delete_course_id'];
    
    $sql = "DELETE FROM hired_trainers WHERE course_id = $course_id";
    
    if(mysqli_query($conn, $sql)) {
        echo "<script>
        window.onload = function() {
            var welcomeMessage = 'ลบคอร์สสำเร็จ ". "';
            var popup = document.createElement('div');
            popup.innerHTML = welcomeMessage;
            popup.style.backgroundColor = '#ffffff';
            popup.style.border = '1px solid #cccccc';
            popup.style.padding = '40px'; /* เพิ่ม padding เพื่อขยายขนาดของ pop-up */
            popup.style.width = '800px'; /* เพิ่มความกว้างของ pop-up */
            popup.style.height = '900px'; /* เพิ่มความสูงของ pop-up */
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
            
            var backButton = document.createElement('button'); // สร้างปุ่มย้อนกลับ
            backButton.textContent = 'ย้อนกลับ';
            backButton.style.padding = '10px 20px';
            backButton.style.backgroundColor = '#007bff';
            backButton.style.color = '#fff';
            backButton.style.border = 'none';
            backButton.style.borderRadius = '5px';
            backButton.style.cursor = 'pointer';
            backButton.style.marginTop = '20px'; // เพิ่มระยะห่างด้านบนของปุ่ม
            backButton.style.position = 'absolute'; // ตั้งค่าให้ปุ่มมีตำแหน่ง absolute
            backButton.style.bottom = '20px'; // ตั้งค่าให้ปุ่มอยู่ด้านล่าง
            backButton.style.left = '50%'; // ตั้งค่าให้ปุ่มอยู่กึ่งกลาง
            backButton.style.transform = 'translateX(-50%)'; // ย้ายปุ่มไปที่ตำแหน่งกึ่งกลาง
            backButton.addEventListener('click', function() {
                window.history.back(); // ให้ปุ่มย้อนกลับทำงานเมื่อคลิก
            });
            
            popup.appendChild(backButton); // เพิ่มปุ่มย้อนกลับลงใน pop-up
    
            document.body.appendChild(popup);
    
        };
    </script>";
    } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูล: " . mysqli_error($conn);
    }
}

$sql = "SELECT h.course_id, h.username, h.hired_at, c.title AS course_name, c.price, 
        c.start_date, c.end_date, c.start_time, c.end_time, h.course_id, c.title, h.status, h.payment_status
        FROM hired_trainers AS h
        INNER JOIN courses AS c ON h.course_id = c.course_id
        WHERE h.trainerusername = '$trainerusername'";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<div class='topic'>รายละเอียดคนจ้าง</div>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>ชื่อผู้ออกกำลังกาย</th><th>ชื่อคอร์ส</th><th>วันที่จอง</th><th>วันที่เริ่มคอร์ส</th><th>วันที่สิ้นสุดคอร์ส</th><th>เวลาเริ่มคอร์ส</th><th>เวลาสิ้นสุดคอร์ส</th><th>รายละเอียด</th><th>สถานะ</th><th>สถานะการชำระเงิน</th><th>ปุ่ม</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['course_id'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['course_name'] . "</td>"; 
        echo "<td>" . $row['hired_at'] . "</td>"; 
        echo "<td>" . $row['start_date'] . "</td>"; 
        echo "<td>" . $row['end_date'] . "</td>"; 
        echo "<td>" . $row['start_time'] . "</td>"; 
        echo "<td>" . $row['end_time'] . "</td>";
        echo "<td><a href='display_course.php?course_id=" . $row['course_id'] . "' onclick=\"showPopup('" . $row['course_id'] . "', '" . $row['title'] . "', '" . $row['course_name'] . "', '" . $row['price'] . "')\">ดูรายละเอียด</a></td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td>" . $row['payment_status'] . "</td>";
        echo "<td>
        <div class='action-links'>
            <a href='reject_course_trainer.php?reject_course_id=" . $row['course_id'] . "' class='action-link cancel-link'>ลบ</a>
            <a href='accept_course.php?accept_course_id=" . $row['course_id'] . "' class='action-link accept-link'>ยอมรับ</a>
        </div>
          </td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<a href='../indextrainer.php' class='back-button'>ย้อนกลับ</a>";
} else {
    echo "Error retrieving data: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
</body>
</html> 