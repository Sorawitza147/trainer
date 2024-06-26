<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accepted Payments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }

        .trainer-info {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px;
            width: 300px;
            text-align: center;
        }
        
        .trainer-info p {
            margin: 10px 0;
        }
        .profile-picture img {
            width: 100%; 
            height: 100%; 
            object-fit: cover;
        }

        .button-container {
            display: flex;
            justify-content: center;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            margin-right: 10px;
        }

        button.reject {
            background-color: #f44336;
        }

        button:hover {
            background-color: #45a049;
        }

        button.reject:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <h2>Accepted Payments</h2>
    <div class="container">
        <?php
        $conn = mysqli_connect('localhost', 'root', '', 'trainer');
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT * FROM payment";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='trainer-info'>";
                echo "<div class='profile-picture'>";
                echo "<img src='../Course/" . $row["image_path"] . "' alt='Profile Picture'>";
                echo "</div>";
                echo "<p>รหัส: " . $row["id"] . "</p>";
                echo "<p>รหัสคอร์ส: " . $row["course_id"] . "</p>";
                echo "<p>ชื่อคอร์ส: " . $row["course_title"] . "</p>";
                echo "<p>ชื่อผู้ใช้: " . $row["username"] . "</p>";
                echo "<p>ราคา: " . $row["price"] . "</p>";
                echo "<p>สร้างเมื่อ: " . $row["created_at"] . "</p>";
                echo "<div class='button-container'>";
                echo "<form id='acceptForm' action='accept_payment_action.php' method='post' onsubmit='return confirmAccept()'>";
                echo "<input type='hidden' name='payment_id' value='" . $row["id"] . "'>";
                echo "<input type='hidden' name='course_id' value='" . $row["course_id"] . "'>"; 
                echo "<input type='hidden' name='course_status' value='ชำระเงินสำเร็จรอเทรนเนอร์ตอบรับ'>";
                echo "<input type='hidden' name='payment_status' value='ชำระเงินสำเร็จ'>";
                echo "<button type='submit'>ยอมรับ</button>"; 
                echo "</form>";
                echo "<form id='rejectForm' action='reject_payment_action.php' method='post' onsubmit='return confirmReject()'>";
                echo "<input type='hidden' name='payment_id' value='" . $row["id"] . "'>";
                echo "<input type='hidden' name='payment_id' value='" . $row["payment_id"] . "'>"; // เพิ่มฟิลด์ course_id ซ่อนไว้ในฟอร์ม
                echo "<input type='hidden' name='course_status' value='ชำระเงินไม่สำเร็จโปรดชำระเงินใหม่'>";
                echo "<input type='hidden' name='payment_status' value='ชำระเงินไม่สำเร็จโปรดชำระเงินใหม่'>";
                echo "<button type='submit' class='reject'>ปฏิเสธ</button>"; 
                echo "</form>";
                echo "</div>";
                echo "</div>";
            }
        }        
            else {
            echo "<p>No accepted payments</p>";
        }
        mysqli_close($conn);
        ?>

        <script>
            function confirmAccept() {
                return confirm("คุณแน่ใจหรือไม่ว่าต้องการยอมรับการชำระเงินนี้?");
            }

            function confirmReject() {
                return confirm("คุณแน่ใจหรือไม่ว่าต้องการปฏิเสธการชำระเงินนี้?");
            }
        </script>
    </div>
</body
