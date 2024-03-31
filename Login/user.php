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
        body {
            background-color: #f5f5f5;
        }
        .user-info {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            width: 80%;
            max-width: 600px;
            text-align: center;
        }
        .user-info h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .user-info p {
            color: #666;
            font-size: 16px;
            margin-bottom: 10px;
            
        }
        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
        }
        .profile-picture img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
        .edit-profile-btn {
            background-color: #00CCFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-transform: uppercase;
            font-weight: bold;
        }
        .edit-profile-btn:hover {
            background-color: #ff9933;
        }
        .user-info {
            position: relative;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            width: 80%;
            max-width: 600px;
            text-align: center;
        }

        .back-button {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-transform: uppercase;
            font-weight: bold;
            background-color: #00CCFF;
            color: #fff;
        }

        .back-button:hover {
            background-color: #999;
        }
        </style>
</head>
<body>
<?php
session_name("user_session");
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
$sql = "SELECT * FROM user WHERE username = '$username'";

$result = $conn->query($sql);


if ($result === false || $result->num_rows === 0) {
    echo "0 results or Error: " . mysqli_error($conn);
} else {
    while ($row = $result->fetch_assoc()) {
      
        echo "<div class='user-info'>";
        echo "<a href='../indexuser.php' class='back-button'>ย้อนกลับ</a>";
        echo "<div class='profile-picture'>";
        if (!empty($row['image'])) {
            echo "<img src='" . $row['image'] . "'>";
        } else {
        
            echo "<img src='default_profile_picture.jpg' alt='Profile Picture'>";
        }
        echo "</div>";
        echo "<h2>ข้อมูลผู้ใช้</h2>";
        echo "<p>ชื่อ: " . $row["firstname"] . " " . $row["lastname"] . "</p>";
        echo "<p>อีเมล: " . $row["email"] . "</p>";
        echo "<p>เพศ: " . $row["gender"] . "</p>";
        echo "<p>อายุ: " . $row["age"] . "</p>";
        echo "<p>ส่วนสูง: " . $row["height"] . "</p>";
        echo "<p>น้ำหนัก: " . $row["weight"] . "</p>";
        echo "<p>เบอร์โทรศัพท์: " . $row["phone"] . "</p>";
        

        echo "<button class='edit-profile-btn' onclick=\"window.location.href='edit_profileuser.php'\">แก้ไขโปรไฟล์</button>";

        echo "</div>";
    }
}

$conn->close();
?>
</body>
</html>