<!DOCTYPE html>
<html>
<head>
    <title>รายละเอียดคอร์ส</title>
    <style
    >@import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Mitr", sans-serif;
}
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f2f2f2;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }
        h1 {
            color: #333;
        }
        p {
            color: #666;
        }
        form {
            margin-top: 20px;
        }
        input[type="file"] {
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .back-btn {
        text-align: center;
        margin-top: 20px;
        }
        .back-btn__button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .back-btn__button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">

<?php
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

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    $username = "";
}

if(isset($_GET["course_id"])) {
    $course_id = $_GET["course_id"];

    $sql = "SELECT accepted_course.username, accepted_course.status, accepted_course.course_id, courses.title, courses.cover_image, courses.description, courses.price, courses.difficulty, courses.name, courses.email, courses.age, courses.gender, courses.phone_number, courses.start_date, courses.end_date, courses.start_time, courses.end_time, accepted_course.payment_status
            FROM accepted_course 
            INNER JOIN courses ON accepted_course.course_id = courses.course_id
            WHERE courses.course_id = '$course_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        echo "<h1>รายละเอียดคอร์ส</h1>";
        echo "<p>ชื่อคอร์ส: " . $row["title"] . "</p>";
        echo "<p>ชื่อคอร์ส: " . $row["course_id"] . "</p>";
        echo "<p>ชื่อบัญชีโอนเงิน: นายสมมุติ ลองเล่น</p>";
        echo "<p>ธนาคาร: ธนาคารไทยพาณิชย์</p>";
        echo "<p>หมายเลขบัญชี: 123-4-56789-0</p>";
        echo "<p>จำนวนเงินที่ต้องชำระ: " . $row["price"] . " บาท</p>";

        echo "<form action='upload.php?course_id=" . $course_id . "' method='post' enctype='multipart/form-data'>";
        echo "<p>เลือกรูปภาพเพื่ออัปโหลด:</p>";
        echo "<input type='file' name='fileToUpload' id='fileToUpload'>";
        echo "<br>";
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

$conn->close();
?>
<div class="back-btn">
    <button onclick="window.history.back()" class="back-btn__button">ย้อนกลับ</button>
</div>
</body>
</html>
