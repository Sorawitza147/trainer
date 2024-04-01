<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการใช้บริการของผู้ใช้</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Mitr", sans-serif;
        }
        .table {
            width: 100%;
            margin-bottom: 40px;
            background-color: #00CCFF;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody + tbody {
            border-top: 2px solid #dee2e6;
        }

        .table-responsive {
            overflow-x: auto;
        }

        /* ปรับสไตล์ของ container เพื่อให้มีกรอบ */
        .container {
            border: 1px solid #ddd; /* เปลี่ยนสีเส้นขอบตามต้องการ */
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            background-color: #00CCFF;
        }

        /* เพิ่มสไตล์สำหรับตารางที่มีกรอบ */
        .table-bordered {
            border: 1px solid #dee2e6;
            border-collapse: collapse;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
            padding: 0.75rem;
            vertical-align: top;
        }
    </style>
</head>
<body>
    <?php
    session_name("user_session");
    session_start();

    // เชื่อมต่อฐานข้อมูล
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbName = "trainer";

    $conn = new mysqli($servername, $username, $password, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   
    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    
        $username = $_SESSION["username"];

        
        $sql_trainer = "SELECT * FROM course_history_trainer WHERE username = '$username'";
        $result_trainer = $conn->query($sql_trainer);

        if ($result_trainer === false) {
            echo "<div class='error-message'>Error: " . $conn->error . "</div>";
        }
    } else {
   
        echo "<div class='error-message'>คุณต้องเข้าสู่ระบบก่อนที่จะดูประวัติการใช้บริการ</div>";
    }
    $conn->close();
    ?>

    <div class="container">
        <h2>ประวัติการใช้บริการของผู้ใช้</h2>
        <a href="../indexuser.php" class="btn btn-primary mb-3">ย้อนกลับ</a>
        <?php
        if (isset($result_trainer) && $result_trainer->num_rows > 0) {


            while($row = $result_trainer->fetch_assoc()) {
                echo "<table class='table table-bordered'>"; 
                echo "<tr>";
                echo "<th>รูปปก</th>";
                echo "<td><img src='uploadscourse/" . $row["cover_image"] . "'></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>รหัสบันทึก</th>";
                echo "<td>".$row["id"]."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>รหัสคอร์ส</th>";
                echo "<td>".$row["course_id"]."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>ชื่อผู้ใช้</th>";
                echo "<td>".$row["username"]."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>รหัสผู้ฝึก</th>";
                echo "<td>".$row["trainer_id"]."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>ชื่อคอร์ส</th>";
                echo "<td>".$row["title"]."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>ชื่อ-สกุล</th>";
                echo "<td>".$row["name"]."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>อีเมล</th>";
                echo "<td>".$row["email"]."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>เพศเทรนเนอร์</th>";
                echo "<td>".$row["gender"]."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>อายุ</th>";
                echo "<td>".$row["age"]."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>เบอร์โทร</th>";
                echo "<td>".$row["phone_number"]."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>รายละเอียด</th>";
                echo "<td>".$row["description"]."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>ราคา</th>";
                echo "<td>".$row["price"]."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>ความยาก</th>";
                echo "<td>".$row["difficulty"]."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>วันที่เริ่ม</th>";
                echo "<td>".$row["start_date"]."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>วันที่สิ้นสุด</th>";
                echo "<td>".$row["end_date"]."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>เวลาเริ่ม</th>";
                echo "<td>".$row["start_time"]."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>เวลาสิ้นสุด</th>";
                echo "<td>".$row["end_time"]."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>สถานะ</th>";
                echo "<td>".$row["status"]."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>สถานะการชำระเงิน</th>";
                echo "<td>".$row["payment_status"]."</td>";
                echo "</tr>";
            }
            
            echo "</table>";
            echo "</div>"; 
        } else {
            echo "<div class='error-message'>ไม่พบข้อมูล</div>";
        }
        ?>
    </div>
    </div>
</body>
</html>
