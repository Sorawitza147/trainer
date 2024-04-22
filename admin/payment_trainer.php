<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment for Course</title>
    <style>
        .container {
            max-width: 65%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .upload-form {
            margin-bottom: 20px;
        }
        .upload-form label {
            display: block;
            margin-bottom: 10px;
        }
        .upload-form input[type="file"] {
            margin-top: 5px;
        }
        .course-info {
            margin-bottom: 20px;
        }
        .course-info label {
            font-weight: bold;
        }
        .transfer-btn {
            display: block;
            width: 120px;
            padding: 10px;
            margin: 10px auto;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
        }
        .transfer-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>จ่ายเงินเทรนเนอร์</h2>
    <div class="upload-form">
        <form action="upload_payment.php" method="post" enctype="multipart/form-data">
            <!-- ฟิลด์อัพโหลดรูปภาพ -->
            <label for="payment_image">อัพโหลดรูปสลีป:</label>
            <input type="file" id="payment_image" name="payment_image" accept="image/*" required>

            <?php
            // เชื่อมต่อกับฐานข้อมูล
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "trainer";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // รับค่า id จาก URL
            $id = $_GET['id'];

            // สร้างคำสั่ง SQL เพื่อดึงข้อมูล
            $sql = "SELECT name, price, title, bank, account_number,trainerusername, id_payment FROM finish_course WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // แสดงข้อมูลของคอร์ส
                    echo "<table>";
                    echo "<tr><td>ชื่อเทรนเนอร์:</td><td>". $row["name"]. "</td></tr>";
                    echo "<tr><td>ราคา:</td><td>". $row["price"]. "</td></tr>";
                    echo "<tr><td>ชื่อคอร์ส:</td><td>". $row["title"]. "</td></tr>";
                    echo "<tr><td>ธนาคาร:</td><td>". $row["bank"]. "</td></tr>";
                    echo "<tr><td>เลขบัญชี:</td><td>". $row["account_number"]. "</td></tr>";

                    // Hidden input field for id_payment
                    echo "<input type='hidden' name='id_payment' value='". $row["id_payment"]. "'>";

                    // ฟิลด์ title และ price
                    echo "<input type='hidden' name='title' value='". $row["title"]. "'>";
                    echo "<input type='hidden' name='price' value='". $row["price"]. "'>";

                    // ส่ง trainerusername ไปยังหน้า upload_payment.php ผ่าน URL parameters
                    echo "<input type='hidden' name='trainerusername' value='". $row["trainerusername"]. "'>";
                    echo "<input type='hidden' name='status_payment' value='โอนเงินสำเร็จ'>";                    
                    echo "</table>";
                }
            } else {
                echo "0 results";
            }
            $conn->close(); // ปิดการเชื่อมต่อกับฐานข้อมูล
            ?>

            <input type="submit" value="Upload" name="submit">
        </form>
    </div>
    <div class="course-info">
        <a href="../indextrainer.php" class="transfer-btn">ย้อนกลับ</a>
    </div>
</div>

</body>
</html>
