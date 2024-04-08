<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ดู Reviews</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Mitr", sans-serif;
        }
        .container{
            margin-top: 16px;
        }
        .card {
            margin-bottom: 20px;
        }
        .card-title {
            font-size: 1.25rem;
            color: #333;
            margin-bottom: 10px;
        }
        .card-text {
            color: #666;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>รีวิวทั้งหมด</h2>
        <div class="row">
            <?php
            // เชื่อมต่อกับฐานข้อมูล
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbName = "trainer";

            $conn = new mysqli($servername, $username, $password, $dbName);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // สร้างคำสั่ง SQL เพื่อดึงข้อมูล reviews
            $sql = "SELECT r.*, t.first_name, t.last_name 
            FROM reviews r
            INNER JOIN accepted_trainers t ON r.trainer_id = t.trainer_id";
    
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='col-md-4'>";
                    echo "<div class='card'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>ไอดีคอร์ส: " . $row["course_id"] . "</h5>";
                    echo "<p class='card-text'>คำรีวิว: " . $row["review"] . "</p>";
                    echo "<p class='card-text'>คะแนน: " . $row["rating"] . "</p>";
                    echo "<p class='card-text'>ชื่อเทรนเนอร์: " . $row["first_name"] . " " . $row["last_name"] . "</p>";
                    echo "<p class='card-text'>ชื่อผู้ใช้ที่รีวิว: " . $row["username"] . "</p>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            }
             else {
                echo "No reviews available.";
            }

            // ปิดการเชื่อมต่อกับฐานข้อมูล
            $conn->close();
            ?>
        </div>
        <a href="../indexuser.php" class="btn btn-primary mt-3">ย้อนกลับ</a>
    </div>
</body>
</html>
