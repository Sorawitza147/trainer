<?php
include 'config.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows == 1) {
 
            $row = $result->fetch_assoc();
            $_SESSION["logged_in"] = true;
            $_SESSION["username"] = $row['username'];

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
                        window.location.href = '../indexuser.php';
                    }, 3000);
                };
            </script>";

                } else {
                    // Login failed
                    echo "<script>
                    window.onload = function() {
                        var popup = document.createElement('div');
                        popup.innerHTML = 'ชื่อผู้ใช้หรือรหัสผ่านผิด';
                        popup.style.backgroundColor = '#ffffff';
                        popup.style.border = '1px solid #cccccc';
                        popup.style.padding = '20px';
                        popup.style.borderRadius = '10px';
                        popup.style.boxShadow = '0px 0px 10px rgba(0, 0, 0, 0.1)';
                        popup.style.position = 'fixed';
                        popup.style.top = '50%';
                        popup.style.left = '50%';
                        popup.style.transform = 'translate(-50%, -50%)';
                        popup.style.zIndex = '9999';
                        document.body.appendChild(popup);

                        setTimeout(function() {
                            popup.remove();
                        }, 5000);
                    };
                </script>";
                }
            } else {
        // Query error
        echo "Query error: " . $conn->error;
    }
} else {
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <title>LoginTrainer</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: "Mitr", sans-serif;
        }

        body {
            background:url(BGTN.jpg);
            background-size: cover;
        }
        .wrapper{
            position: fixed;
            top: 50%;
            left: 50%;
            max-width: 720px;
            width: 100%;
            background: #fff;
            border-radius: 20px;
            transform:  translate(-50%,-50%);
        }

        .wrapper .form-box {
            display: flex;
        }

        .form-box .form-details {
            color: #ddd;
            width: 100%;
            background: url(assist/details.jpg);
            background-size: cover;
        }

        .form-box h2 {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .form-content {
            width: 70%;
            padding: 35px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }
        
        i.bxs-x-square {
            position: absolute;
            font-size: 32px;
            cursor: pointer;
            top: -4px;
            right: -5px;
        }

        form .input-box {
            position: relative;
            height: 50px;
            width: 100%;
            margin-top: 20px;
        }

        form .input-box input {
            width: 100%;
            height: 100%;
            padding: 10px;
            border: none;
            border-bottom: 2px solid #ddd;
            outline: none;
            font-size: 16px;
            background: transparent;
        }

        form .input-box label {
            position: absolute;
            top: 50%;
            left: 10px;
            color: #999;
            transform: translateY(-50%);
            font-size: 16px;
            pointer-events: none;
            transition: 0.5s;
        }

        form .input-box input:focus ~ label,
        form .input-box input:valid ~ label {
            transform: translateY(-150%);
            font-size: 14px;
            color: #15F5BA;
        }

        form .input-box i {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .btn {
            display: inline-block;
            transition: all 0.2s ease-in;
            position: relative;
            overflow: hidden;
            z-index: 1;
            color: #090909;
            padding: 0.7em 1.7em;
            cursor: pointer;
            font-size: 18px;
            border-radius: 0.5em;
            background: #15F5BA;
            border: 1px solid #15F5BA;
            box-shadow: 6px 6px 12px #c5c5c5, -6px -6px 12px #ffffff;
            margin: 20px;
        }
          .btn:active {
            color: #666;
            box-shadow: inset 4px 4px 12px #c5c5c5, inset -4px -4px 12px #ffffff;
          }
          
          .btn:before {
            content: "";
            position: absolute;
            left: 50%;
            transform: translateX(-50%) scaleY(1) scaleX(1.25);
            top: 100%;
            width: 140%;
            height: 180%;
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: 50%;
            display: block;
            transition: all 0.5s 0.1s cubic-bezier(0.55, 0, 0.1, 1);
            z-index: -1;
          }
          
          .btn:after {
            content: "";
            position: absolute;
            left: 55%;
            transform: translateX(-50%) scaleY(1) scaleX(1.45);
            top: 180%;
            width: 160%;
            height: 190%;
            background-color: #009087;
            border-radius: 50%;
            display: block;
            transition: all 0.5s 0.1s cubic-bezier(0.55, 0, 0.1, 1);
            z-index: -1;
          }
          
          .btn:hover {
            color: #ffffff;
            border: 1px solid #009087;
          }
          
          .btn:hover:before {
            top: -35%;
            background-color: #009087;
            transform: translateX(-50%) scaleY(1.3) scaleX(0.8);
          }
          
          .btn:hover:after {
            top: -45%;
            background-color: #009087;
            transform: translateX(-50%) scaleY(1.3) scaleX(0.8);
          }
    </style>
</head>
<body>
    <div class="wrapper">
        <form action="login.php" method="post">
        <div class="form-box">
            <div class="form-details">
                <h2>Welcome</h2>
            </div>
            <div class="form-content">
                <i class='bx bxs-x-square' style='color:rgba(216,13,49,0.93)' ></i>
                <h2>เข้าสู่ระบบคนทั่วไป</h2>
                <form action="#">
                    <div class="input-box">
                    <input type="text" name="username" required>
                        <label>Username</label>
                        <i class='bx bxs-user'></i>
                    </div>
                    <div class="input-box">
                    <input type="password" name="password" required>
                        <label>Password</label>
                        <i id="passwordToggleIcon" class='bx bxs-show'></i>
                    </div>
                    <button type="submit" class="btn" name="login">เข้าสู่ระบบ</button>
                    <button type="button" class="btn" id="trainer-login-btn">เข้าสู่ระบบ เทรนเนอร์</button>
                    <div class="register-link">
                        <p>ไม่มีรหัสสมาชิก <a href="signup.php">สมัครสมาชิก</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const passwordToggleIcon = document.getElementById('passwordToggleIcon');

        passwordToggleIcon.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            passwordToggleIcon.className = type === 'password' ? 'bx bxs-show' : 'bx bxs-hide';
        });
        document.getElementById('trainer-login-btn').addEventListener('click', function() {
        window.location.href = '../Trainer/logintrainer.php'; 
    });
    </script>
</body>
</html>