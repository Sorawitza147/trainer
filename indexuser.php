<?php
session_name("user_session");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Web Page</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Mitr", sans-serif;
        }

        body {
            background: #070F2B;
            min-height: 100vh;
            overflow-x: hidden;
        }

       /* #up {
            position: fixed;
            height: 800px;
            width: 800px;
            border-radius: 50%;
            background-color: #6C22A6;
            filter: blur(280px);
            animation: down 30s infinite;
        }

        #down {
            position: fixed;
            right: 0;
            height: 500px;
            width: 500px;
            border-radius: 50%;
            background-color: #1D24CA;
            filter: blur(280px);
            animation: up 30s infinite;
        }

        #left {
            position: fixed;
            right: 0;
            height: 500px;
            width: 500px;
            border-radius: 50%;
            background-color: #1D24CA;
            filter: blur(280px);
            animation: left 30s 1s infinite;
        }

        #right {
            position: fixed;
            right: 0;
            height: 500px;
            width: 500px;
            border-radius: 50%;
            background-color: #6C22A6;
            filter: blur(280px);
            animation: right 40s .5s infinite;
        }

        @keyframes down {
            0%, 100%{
                top: -100px;
            }
            70%{
                top: 700px;
            }
        }

        @keyframes up {
            0%, 100%{
                bottom: -100px;
            }
            70%{
                bottom: 700px;
            }
        }
        @keyframes left {
            0%, 100%{
                left: -100px;
            }
            70%{
                left: 1300px;
            }
        }
        @keyframes right {
            0%, 100%{
                right: -100px;
            }
            70%{
                right: 1300px;
            }
        } */

        header {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 30px 100px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
            backdrop-filter: blur(250px);
            box-shadow: 0px 0px 10px #7e7e7e;
        }

        .logo {
            font-size: 2em;
            color: #ffff;
            pointer-events:none;
        }

        .navigation a {
            text-decoration: none;
            color: #ffff;
            padding: 6px 15px;
            border-radius: 20px;
            margin: 0 10px;
            font-weight: 600;
        }
        
        .navigation a:hover,
        .navigation a.active {
            background: #222e9e;
            color: #ffffff;
        }

        .title   {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #ffffff;
        }

        #text {
            font-size: 2em;
            text-align: center;
            color: #ffff;
            text-shadow: 2px 2px 4px (0, 0, 0, .2);
        }

        .detailbox {
            width: 100%;
            border-radius: 5px;
            border: 2px solid #ffffff;
            padding-bottom: 10px ;
            margin-top: 30px;
        }

        .detailbox i {
            font-size: 16px;
            font-weight: 300;
            color: #ffffff;
        }
        .text-white{
            color: #ffffff;
        }
        .profile-image {
            width: 30px; 
            height: 30px;
            border-radius: 50%; 
            margin-right: 10px; 
        }
        .glitch-wrapper {
            width: 100%;
            height: 100%;
            margin-top: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background-color: #070F2B;
            }
        .glitch-wrapper1 {
            width: 100%;
            height: 100%;
            margin-top: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background-color: #070F2B;
            }   
            
        .glitch {
            position: relative;
            font-size: 67px;
            font-weight: 700;
            line-height: 1.2;
            color: #fff;
            letter-spacing: 4px;
            z-index: 1;
            }
        .glitch1 {
            position: relative;
            font-size: 30px;
            font-weight: 700;
            line-height: 1.2;
            color: #fff;
            letter-spacing: 4px;
            z-index: 1;
            }

            .glitch:before,
            .glitch:after {
            display: block;
            content: attr(data-glitch);
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0.8;
            }

            .glitch:before {
            animation: glitch-color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) both infinite;
            color: #0ff;
            z-index: -1;
            }

            .glitch:after {
            animation: glitch-color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) reverse both infinite;
            color: #ff00ff;
            z-index: -2;
            }

            @keyframes glitch-color {
            0% {
                transform: translate(0);
            }

            20% {
                transform: translate(-3px, 3px);
            }

            40% {
                transform: translate(-3px, -3px);
            }

            60% {
                transform: translate(3px, 3px);
            }

            80% {
                transform: translate(3px, -3px);
            }

            to {
                transform: translate(0);
            }
            }
            .glitch1:before,
            .glitch1:after {
            display: block;
            content: attr(data-glitch);
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0.8;
            }

            .glitch1:before {
            animation: glitch-color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) both infinite;
            color: #0ff;
            z-index: -1;
            }

            .glitch1:after {
            animation: glitch-color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) reverse both infinite;
            color: #ff00ff;
            z-index: -2;
            }

            @keyframes glitch1-color {
            0% {
                transform: translate(0);
            }

            20% {
                transform: translate(-3px, 3px);
            }

            40% {
                transform: translate(-3px, -3px);
            }

            60% {
                transform: translate(3px, 3px);
            }

            80% {
                transform: translate(3px, -3px);
            }

            to {
                transform: translate(0);
            }
            }
  </style>
</head>
<body>
  <section id="up"></section>
  <section id="down"></section>
  <section id="left"></section>
  <section id="right"></section>
  <header>
    <h2 class="logo">Logo</h2>
    <nav class="navigation">
      <a href="indexuser.php" class="active">หน้าหลัก</a>
      <a href="Cash/paymentuser.php">เติมเงิน</a>
      <a href="Course/userhire.php">Hiretrainer</a>
      <a href="Course/usercourse.php">Course</a>
      <a href="Login/user.php">ประวัติส่วนตัว</a>
      <?php
      if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
        $profile_image = isset($_SESSION["profile_image"]) ? $_SESSION["profile_image"] : "user.png";
        echo "<a href='#'><img src='$profile_image' class='profile-logo'></a>";
        echo "<span class='text-white'>ยินดีต้อนรับคุณ: " . $_SESSION["username"] . "</span>";
        echo "<a button type='button' href='Login/logout.php' class='btn btn-outline-light me-2'>Logout</a></button>";
      } else {
        echo "<a button type='button' href='Login/login.php' class='btn btn-outline-light me-2'>Login</a></button>";
        echo "<a button type='button' href='Login/signup.php' class='btn btn-warning'>Sign up</a></button>";
      }
      ?>
    </nav>
  </header>
  <div class="glitch-wrapper">
    <div class="glitch" data-glitch="พัฒนาเว็บไซต์เพื่อค้นหาสถานที่ออกกำลังกายและจ้างผู้ฝึกสอน">พัฒนาเว็บไซต์เพื่อค้นหาสถานที่ออกกำลังกายและจ้างผู้ฝึกสอน</div>
    </div>
    <div class="glitch-wrapper1">
    <div class="glitch1" data-glitch="เว็บไซต์ทีของเราจะเป็นแหล่งค้นหาฟิตเนสทั้งหมดในกรุงเทพ ฯ ซึ่งทำให้ผู้ใช้สามารถเลือกฟิตเนสและจ้างเทรนเนอร์ได้ตามต้องการ">เว็บไซต์ทีของเราจะเป็นแหล่งค้นหาฟิตเนสทั้งหมดในกรุงเทพ ฯ ซึ่งทำให้ผู้ใช้สามารถเลือกฟิตเนสและจ้างเทรนเนอร์ได้ตามต้องการ</div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelector('.logo').addEventListener('click', function() {
        var navigation = document.querySelector('.navigation');
        navigation.classList.toggle('show');
      });
    });
    fetch('start_session.php', {
        method: 'GET',
        credentials: 'include' 
    })
    .then(response => {
        if (response.ok) {
            console.log('Session started successfully');
        } else {
            console.error('Failed to start session');
        }
    })
    .catch(error => console.error('Error:', error));
  </script>
</body>
</html>
