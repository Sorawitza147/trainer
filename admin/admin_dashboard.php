<?php
session_name("admin_session");
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admindashboard.css"/>
</head>
<body>
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
