<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "trainer";

$conn = new mysqli($servername, $username, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// เรียกดูข้อมูลจากตาราง reports โดยรวม id ทั้งหมด
$sql = "SELECT * FROM reports";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานการใช้บริการ</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>รายงานการใช้บริการ</h2>
        <a href="../indexuser.php" class="btn btn-primary mb-3">ย้อนกลับ</a>
        <?php
        if ($result->num_rows > 0) {
            // มีข้อมูลในตาราง reports
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>รหัสการใช้บริการ</th>";
            echo "<th>ผู้รายงาน</th>";
            echo "<th>ข้อความรายงาน</th>";
            echo "<th>ชื่อเทรนเนอร์</th>";
            echo "<th>เบอร์โทร</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            // Loop เพื่อแสดงข้อมูลที่ได้จากการ query
            while($row = $result->fetch_assoc()) {
                // กำหนด history_id ที่ต้องการค้นหา
                $historyId = $row["history_id"];

                // คำสั่ง SQL สำหรับค้นหาข้อมูล name และ phone_number จากตาราง course_history_trainer โดยใช้ history_id
                $sql_trainer_info = "SELECT name, phone_number FROM course_history_trainer WHERE id = '$historyId'";
                $result_trainer_info = $conn->query($sql_trainer_info);

                // ตรวจสอบว่ามีข้อมูลหรือไม่
                if ($result_trainer_info->num_rows > 0) {
                    // ดึงข้อมูล name และ phone_number จากผลลัพธ์ที่ได้
                    $trainer_data = $result_trainer_info->fetch_assoc();
                    $trainer_name = $trainer_data["name"];
                    $trainer_phone = $trainer_data["phone_number"];
                } else {
                    // หากไม่พบข้อมูล
                    $trainer_name = "ไม่พบข้อมูล";
                    $trainer_phone = "ไม่พบข้อมูล";
                }

                // แสดงข้อมูลในแต่ละแถวของตาราง
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["history_id"] . "</td>";
                echo "<td>" . $row["reporter_username"] . "</td>";
                echo "<td>" . $row["report_text"] . "</td>";
                echo "<td>" . $trainer_name . "</td>";
                echo "<td>" . $trainer_phone . "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<div class='error-message'>ไม่พบข้อมูลรายงาน</div>";
        }
        ?>
    </div>
</body>
</html>
