<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
@import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');
*{
margin: 0;
padding: 0;
box-sizing: border-box;
font-family: "Mitr", sans-serif;
}
@keyframes flash {
    0% { color: #2a2a2a; } 
    50% { color: #1d1d1d; } 
    100% { color: #000000; } 
}
body {
    font-family: Arial, sans-serif;
    background-color: #f0f8ff; 
    margin: 0;
    padding: 0;
}

.wrapper {
    width: 100%; 
    margin: 0 auto; 
    padding: 20px;
    background-color: #f0fff0;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}
.wrapper a {
    display: block;
    padding: 10px;
    margin: 10px 0;
    text-align: center;
    background-color: #4682b4; 
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.wrapper a:hover {
    background-color: #20b2aa; 
}

h1 {
    text-align: center;
    animation: flash 1s infinite; /
}

.sidebar {
    width: 250px;
    height: auto;
    background-color: #ffffff;
    float: left;
    border-right: 2px solid #2d2c2c;
    padding-right: 10px; 
    box-sizing: border-box; 
}

.sidebar ul {
    list-style-type: none;
    padding: 0;
}

.sidebar ul li a {
    padding: 10px;
    text-decoration: none;
    color: #000;
    transition: background-color 0.3s;
}

.sidebar ul li a:hover {
    background-color: #ddd;
}
</style>
</head>
<body>
<?php
session_name("admin_session");
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

?>
    <div class="wrapper">
            <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <div class="sidebar">
            <ul>
                 <li><a href="#" onclick="displayData('view_trainer.php')">ดูข้อมูลเทรนเนอร์</a></li>
                <li><a href="#" onclick="displayData('manage_users.php')">จัดการผู้ออกกำลังกาย</a></li>
                <li><a href="#" onclick="displayData('manage_trainer.php')">จัดการเทรนเนอร์</a></li>
                <li><a href="#" onclick="displayData('manage_products.php')">จัดการคอร์ส</a></li>
                <li><a href="#" onclick="displayData('accept_payment.php')">ตรวจสอบการโอนเงิน</a></li>
                <li><a href="#" onclick="displayData('refundtrainer.php')">คืนเงินเทรนเนอร์กดยกเลิก</a></li>
                <li><a href="#" onclick="displayData('refund.php')">คืนเงินผู้ออกกำลังกายกดยกเลิก</a></li>
                <li><a href="#" onclick="displayData('Finish_course.php')">โอนเงินให้เทรนเนอร์</a></li>
                <li><a href="#" onclick="displayData('reports.php')">รีพอรต์</a></li>
                <li><a href="admin_logout.php">ออกจากระบบ</a></li>
            </ul>
        </div>
        <div class="main-content" id="mainContent">

        </div>
    </div>
    
    <script>
        function displayData(page) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("mainContent").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", page, true);
            xhttp.send();
        }
    </script>
</body>
</html>
