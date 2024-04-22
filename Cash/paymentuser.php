<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment User Page</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Mitr", sans-serif;
        }
        body {
            font-family: Arial, sans-serif;
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
            position: relative;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        img {
            display: block;
            margin-left: auto;
            margin-right: auto;
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .info {
            padding: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-bottom: 20px;
        }
        .info p {
            margin: 10px 0;
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

        /* CSS สำหรับ Modal ...*/
        .modal {
            display: none; /* ซ่อน Modal เริ่มต้น */
            position: fixed; /* จัดตำแหน่งเป็น fixed */
            z-index: 1; /* ตั้งค่าความสูงที่สูงที่สุด */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* เพิ่ม scroll ถ้า content ยาวกว่าหน้าจอ */
            background-color: rgba(0,0,0,0.4); /* สีพื้นหลัง (โปร่งแสง) */
            padding-top: 60px; /* ระยะห่างด้านบน */
        }
        
        /* สไตล์ Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; /* ส่วนที่ต้องการจะให้กล่องอยู่ตรงกลางหน้าจอ */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* กว้างของ Modal */
            border-radius: 10px; /* ขอบมน */
        }

        /* ปุ่มปิด Modal */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>หลักฐานเงินคืน</h1>

    <?php
    // เชื่อมต่อกับฐานข้อมูล
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "trainer";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // เรียกข้อมูลเฉพาะผู้ใช้ที่เข้าสู่ระบบ
    session_name("user_session");
    session_start();
    if (!isset($_SESSION['username'])) {
        // If not logged in, redirect to the login page or display a message
        echo "ไม่ได้ล๊อคอิน"; // Display message indicating not logged in
        exit; // Stop further execution
    }
    $sql = "SELECT * FROM payment_refund_admin WHERE username='{$_SESSION['username']}'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // แสดงข้อมูลแต่ละแถว
        while($row = $result->fetch_assoc()) {
            echo "<div class='info'>";
            echo "<img src='../admin/picrefund/".$row["image_path"]."' alt='Image'>";
            echo "<p>ไอดี: ".$row["id"]."</p>";
            echo "<p>ไอดีคอร์ส: ".$row["course_id"]."</p>";
            echo "<p>ชื่อคอร์ส: ".$row["title"]."</p>";
            echo "<p>จำนวน: ".$row["price"]."</p>";
            echo "<p>โอนเมื่อ: ".$row["timestamp"]."</p>";
            echo "<button class='btn-confirm' onclick='openConfirmationPage()'>ยืนยัน</button>";
            echo "</div>";
        }
    } else {
        echo "ไม่พบหลักฐานเงินคืน";
    }
    $conn->close();
    ?>
    <a href="../indexuser.php" class="btn">ย้อนกลับ</a>

</div>
<div id="confirmationModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <p>คุณต้องการยืนยันการดำเนินการหรือไม่?</p>
        <p>โปรดตรวจสอบยอดเงินคืน โดยทางเราจะหัก5% เป็นค่าทำรายการ</p>
        <button class='btn-confirm' onclick='confirmAndClose()'>ยืนยัน</button>
        <button onclick="closeModal()">ยกเลิก</button>
    </div>
</div>
<script>
    function openConfirmationPage() {
        var modal = document.getElementById('confirmationModal');
        modal.style.display = 'block';
    }
    function closeModal() {
        var modal = document.getElementById('confirmationModal');
        modal.style.display = 'none';
    }
    function confirmAndClose() {
    closeModal();
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            window.close();
            window.location.reload();
        }
    };
    xhr.open("GET", "delete_payment.php", true);
    xhr.send();
}
</script>
</body>
</html>
