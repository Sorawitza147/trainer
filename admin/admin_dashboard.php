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
                 <li><a href="#" onclick="displayData('view_trainer.php')">View Trainer</a></li>
                <li><a href="#" onclick="displayData('manage_users.php')">manage users</a></li>
                <li><a href="#" onclick="displayData('manage_trainer.php')">manage trainer</a></li>
                <li><a href="#" onclick="displayData('manage_products.php')">Manage Products</a></li>
                <li><a href="#" onclick="displayData('generate_reports.php')">Generate Reports</a></li>
                <li><a href="admin_logout.php">Logout</a></li>
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
