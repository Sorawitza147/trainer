<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลผู้สอน</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Mitr", sans-serif;
        }
        .trainer-info {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
            width: 35%;
            margin: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-top: 45px;
        }
        .trainer-info h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .trainer-info p {
            color: #666;
            font-size: 16px;
            margin-bottom: 5px;
        }
        .profile-picture {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 10px;
        }
        .profile-picture img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
        .edit-profile-btn {
        background-color: #00CCFF; 
        color: #000000; 
        padding: 10px 20px; 
        border: none; 
        border-radius: 4px; 
        cursor: pointer; 
        transition: background-color 0.3s; 
        }

    .edit-profile-btn:hover {
        background-color: #ff9933;
    }
    .back-button {
        background-color: #00CCFF; 
        color: #000000; 
        padding: 10px 20px; 
        border: none; 
        border-radius: 4px; 
        cursor: pointer; 
        transition: background-color 0.3s; 
        margin-top: 20px;
        }

        .back-button:hover {
            background-color: #ff9933;
        }
    </style>
</head>
<body>
<?php
session_name("trainer_session");
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trainer";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];
$sql = "SELECT * FROM accepted_trainers WHERE username = '$username'";

$result = $conn->query($sql);

if ($result === false || $result->num_rows === 0) {
    echo "0 results or Error: " . mysqli_error($conn);
} else {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='trainer-info'>";
        echo "<div class='profile-picture'>";
        if (!empty($row['image_profile'])) {
            echo "<img src='" . $row['image_profile'] . "' alt='โปรไฟล์ของ " . $row["first_name"] . " " . $row["last_name"] . "'>";
        }
        echo "</div>";   
        echo "<h2>ข้อมูลผู้สอน</h2>";
        echo "<p><strong>ชื่อ:</strong> " . $row["first_name"] . " " . $row["last_name"] . "</p>";
        echo "<p><strong>อีเมล:</strong> " . $row["emailtrainer"] . "</p>";
        echo "<p><strong>เบอร์ติดต่อ:</strong> " . $row["phone_number"] . "</p>";
        echo "<p><strong>เพศ:</strong> " . $row["gender"] . "</p>";
        for ($i = 1; $i <= 6; $i++) {
            $level_key = "level_" . $i;
            $start_key = "start_year_" . $i;
            $end_key = "end_year_" . $i;
            if (!empty($row[$level_key])) {
                echo "<p><strong>ระดับการศึกษาที่ " . $i . ":</strong> " . $row[$level_key] . "</p>";
                echo "<p><strong>ปีที่เริ่มเรียน:</strong> " . $row[$start_key] . "</p>";
                echo "<p><strong>ปีที่สำเร็จการศึกษา:</strong> " . $row[$end_key] . "</p>";
            }
        }

        echo "<p><strong>เขต:</strong> " . $row["district"] . "</p>";
        echo "<p><strong>แขวง:</strong> " . $row["subdistrict"] . "</p>";

        echo "<button class='edit-profile-btn' onclick=\"window.location.href='edit_profiletrainer.php'\">แก้ไขโปรไฟล์</button>";
        echo "<a href='../indextrainer.php' class='back-button'>ย้อนกลับ</a>";
        echo "</div>";
    }
}

$conn->close();
?>
</body>
</html>