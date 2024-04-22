<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Trainers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        
        h2 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }
        
        .trainer-info {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
        }
        
        .trainer-info p {
            margin: 10px 0;
        }
        
        img {
            width: 100%;
            border-radius: 5px;
            margin-top: 10px;
        }
        .profile-picture {
        margin: 0 auto; 
        width: 150px; 
        height: 150px; 
    }

    .profile-picture img {
        border-radius: 50%;
        width: 100%; 
        height: 100%; 
    }
    </style>
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "trainer";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

$sql = "SELECT * FROM accepted_trainers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>ข้อมูลเทรนเนอร์</h2>";
    while($row = $result->fetch_assoc()) {
        echo "<div class='trainer-info'>";
        echo "<div class='profile-picture'>";
        if (!empty($row['image_profile'])) {
            echo "<img src='../Trainer/" . $row['image_profile'] . "' alt='โปรไฟล์ของ " . $row["first_name"] . " " . $row["last_name"] . "'>";
        }
        echo "</div>";
        echo "<p><strong>ชื่อ:</strong> " . $row["first_name"] . " " . $row["last_name"] . "</p>";
        echo "<p><strong>อีเมล:</strong> " . $row["emailtrainer"] . "</p>";
        echo "<p><strong>เพศ:</strong> " . $row["gender"] . "</p>";
        echo "<p><strong>อายุ:</strong> " . $row["age"] . "</p>";
        echo "<p><strong>เบอร์โทรศัพท์:</strong> " . $row["phone_number"] . "</p>";
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
        
        echo "<h3>รูปใบสมัคร</h3>";
        $target_dir = "../Trainer/";
        
        if (!empty($row["image"])) {
            echo '<img src="' . $target_dir . $row["image"] . '" alt="Trainer Image">';
        } else {
            echo "Trainer Image";
        }
        
        // เพิ่มปุ่มลบข้อมูล
        echo "<form action='delete_trainerview.php' method='post'>";
        echo "<input type='hidden' name='trainer_id' value='" . $row["trainer_id"] . "'>";
        echo "<input type='submit' value='ลบข้อมูล' onclick='return confirmHire()'>";
        echo "</form>";
        
        echo "</div>"; 
    }
} else {
    echo "<p>ไม่พบข้อมูลเทรนเนอร์</p>";
}
    
$conn->close();
?>

<script>
function confirmHire() {
    return confirm("ลบเทรนเนอร์นี้ใช่หรือไม่?");
}
</script>

</body>
</html>
