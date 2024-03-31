<?php
session_name("admin_session");
session_start();


if (isset($_POST['login'])) {

    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $database = "trainer"; 
    $conn = new mysqli($servername, $username, $password, $database);

   
    if ($conn->connect_error) {
        die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
    }

   
    $username = $_POST['username'];
    $password = $_POST['password'];

   
    $sql = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);


    if ($result->num_rows == 1) {
    
        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $username;

        echo "<script>
                window.onload = function() {
                    var welcomeMessage = 'ยินดีต้อนรับคุณ " . $_SESSION["username"] . "';
                    var popup = document.createElement('div');
                    popup.innerHTML = welcomeMessage;
                    popup.style.backgroundColor = '#ffffff';
                    popup.style.border = '1px solid #cccccc';
                    popup.style.padding = '40px'; /* เพิ่ม padding เพื่อขยายขนาดของ pop-up */
                    popup.style.width = '600px'; /* เพิ่มความกว้างของ pop-up */
                    popup.style.height = '500px'; /* เพิ่มความสูงของ pop-up */
                    popup.style.textAlign = 'center'; /* จัดข้อความให้อยู่กึ่งกลาง */
                    popup.style.lineHeight = '1.5'; /* เพิ่มระยะห่างระหว่างบรรทัด */
                    popup.style.borderRadius = '20px'; /* เพิ่มมุมของ pop-up */
                    popup.style.boxShadow = '0px 0px 20px rgba(0, 0, 0, 0.3)'; /* เพิ่มเงาใน pop-up */
                    popup.style.position = 'fixed';
                    popup.style.top = '50%';
                    popup.style.left = '50%';
                    popup.style.transform = 'translate(-50%, -50%)';
                    popup.style.zIndex = '9999';
                    popup.style.fontSize = '54px'; /* เพิ่มขนาดตัวอักษร */
                    document.body.appendChild(popup);

                    setTimeout(function() {
                        popup.remove();
                        window.location.href = 'admin_dashboard.php';
                    }, 3000);
                };
            </script>";
    } else {

        $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="login_admin.css"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: "Mitr", sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 90vh;
            background-image: url("Background4.png");
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <form action="admin_login.php" method="post">
            <h1>Admin Login</h1>
            <?php if(isset($error)) { ?>
                <div class="error"><?php echo $error; ?></div>
            <?php } ?>
            <div class="input-box">
                <input type="text" name="username" placeholder="ชื่อผู้ใช้" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="รหัสผ่าน" required>
            </div>
            <button type="submit" class="btn" name="login">เข้าสู่ระบบ</button>
        </form>
    </div>
</body>
</html>
