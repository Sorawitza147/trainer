<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Information</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Mitr", sans-serif;
        }
        body {
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
            color: #007bff;
        }
        img {
            display: block;
            margin: 0 auto;
            max-width: 50%;
            height: auto;
            border-radius: 5px;
        }
        .info {
            padding: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-bottom: 20px;
        }
        .info h2 {
            margin-bottom: 10px;
            color: #333;
            font-weight: bold;
        }
        .info p {
            color: #666;
            margin-bottom: 5px;
        }
        .accept-btn:hover {
            background-color: #0056b3;
        }
        .no-data {
            text-align: center;
            color: #999;
        }
        .btn {
            background-color: #00CCFF;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4); 
            padding-top: 60px; 
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
            border-radius: 10px; 
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>หลักฐานการโอนเงิน</h2>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "trainer";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        session_name("trainer_session");
        session_start();
        $trainerusername = $_SESSION['trainerusername'];
        $sql = "SELECT title, price, image_path,id FROM payment_info WHERE trainerusername = '$trainerusername'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='info'>";
                echo "<img src='../admin/" . $row["image_path"] . "' alt='" . $row["title"] . "'>";
                echo "<p><h2>" . $row["title"] . "</h2></p>";
                echo "<p><strong>Price:</strong> $" . $row["price"] . "</p>";
                echo "<button class='accept-btn' onclick='openConfirmationPage(" . $row["id"] . ")'>ยืนยัน</button>";
                echo "</div>";
            }
        } else {
            echo "ไม่พบหลักฐานการโอนเงิน";
        }
        $conn->close();
        ?>
        <a href="../indextrainer.php" class="btn">ย้อนกลับ</a>
    
    </div>
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p>คุณต้องการยืนยันการดำเนินการหรือไม่?</p>
            <p>โปรดตรวจสอบยอดเงินคืน โดยทางเราจะหัก5% เป็นค่าทำรายการ</p>
            <button class='btn-confirm' id='confirmBtn' onclick='confirmAndClose()'>ยืนยัน</button>
            <button onclick="closeModal()">ยกเลิก</button>
        </div>
    </div>
    <script>
        function openConfirmationPage(id) {
            var modal = document.getElementById('confirmationModal');
            modal.style.display = 'block';
            document.getElementById('confirmBtn').onclick = function() {
                confirmAndClose(id);
            };
        }

        function closeModal() {
            var modal = document.getElementById('confirmationModal');
            modal.style.display = 'none';
        }

        function confirmAndClose(id) {
            closeModal();
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    window.location.reload();
                }
            };
            xhr.open("GET", "delete_payment.php?id=" + id, true); 
            xhr.send();
        }
    </script>
</body>
</html>
