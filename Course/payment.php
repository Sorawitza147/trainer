<?php
// เชื่อมต่อฐานข้อมูล
session_name("user_session");
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "trainer";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามีค่า course_id ที่ถูกส่งมาหรือไม่
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // หากไม่ได้เข้าสู่ระบบ ให้กำหนดค่า username เป็นค่าว่างหรือค่าอื่นที่เหมาะสม
    $username = "";
}

// ตรวจสอบว่ามีค่า course_id ที่ถูกส่งมาหรือไม่
if(isset($_GET["course_id"])) {
    $course_id = $_GET["course_id"];

    // ทำการคิวรี่ข้อมูลคอร์สโดยใช้ course_id
    $sql = "SELECT hired_trainers.username, hired_trainers.status, hired_trainers.course_id, courses.title, courses.cover_image, courses.description, courses.price, courses.difficulty, courses.name, courses.email, courses.age, courses.gender, courses.phone_number, courses.start_date, courses.end_date, courses.start_time, courses.end_time, hired_trainers.payment_status
            FROM hired_trainers 
            INNER JOIN courses ON hired_trainers.course_id = courses.course_id
            WHERE courses.course_id = '$course_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // ดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
        $row = $result->fetch_assoc();
        
        // แสดงรายละเอียดของคอร์ส
        echo "<h1>รายละเอียดคอร์ส</h1>";
        echo "<p>ชื่อคอร์ส: " . $row["title"] . "</p>";
        echo "<p>ชื่อคอร์ส: " . $row["course_id"] . "</p>";
        echo "<p>ชื่อบัญชีโอนเงิน: นายสมมุติ ลองเล่น</p>";
        echo "<p>ธนาคาร: ธนาคารไทยพาณิชย์</p>";
        echo "<p>หมายเลขบัญชี: 123-4-56789-0</p>";
        echo "<p>จำนวนเงินที่ต้องชำระ: " . $row["price"] . " บาท</p>";

        // เริ่มฟอร์มในการอัปโหลดรูปภาพ
        echo "<form action='upload.php?course_id=" . $course_id . "' method='post' enctype='multipart/form-data'>";
        echo "<p>เลือกรูปภาพเพื่ออัปโหลด:</p>";
        echo "<input type='file' name='fileToUpload' id='fileToUpload'>";
        echo "<input type='submit' value='Upload Image' name='submit'>";
        echo "<input type='hidden' name='payment_status' value='รอตรวจสอบการชำระเงิน'>";
        echo "<input type='hidden' name='username' value='" . $username. "'>";
        echo "<input type='hidden' name='course_id' value='" . $course_id . "'>";
        echo "</form>";
    } else {
        echo "ไม่พบข้อมูลสำหรับคอร์สนี้";
    }
} else {
    echo "";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
