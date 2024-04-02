<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Web Page</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Mitr", sans-serif;
        }
</style>
</head>
<body>
<?php
include 'config.php';

if (isset($_POST['signup'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $phone = $_POST['phone']; 
    $bank = $_POST['bank'];
    $account_number = $_POST['account_number']; 
    
    
    // File upload handling
    $targetDir = "uppic/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowedExtensions)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Check if username already exists
    $sql_check_username = "SELECT * FROM user WHERE username='$username'";
    $result_check_username = $conn->query($sql_check_username);
    if ($result_check_username->num_rows > 0) {
        echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: 'ยูสเซอร์นี้มีอยู่ในระบบเเล้ว',
                      });
            </script>";
        } else {

    $sql_check_phone_number = "SELECT * FROM user WHERE phone='$phone'";
    $result_check_phone_number = $conn->query($sql_check_phone_number); // เปลี่ยน $phone_number เป็น $phone
    if ($result_check_phone_number->num_rows > 0) {
        echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: 'เบอร์โทรมีการใช้งานแล้ว',
                      });
            </script>";
        } else {
    // Check if email already exists
    $sql_check_email = "SELECT * FROM user WHERE email='$email'";
    $result_check_email = $conn->query($sql_check_email);
    if ($result_check_email->num_rows > 0) {
        echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: 'อีเมล์มีการใช้งานแล้ว',
                      });
            </script>";
        } else {

    // Check if username and lastname combination already exists
    $sql_check_combination = "SELECT * FROM user WHERE Firstname='$firstname' AND Lastname='$lastname'";
    $result_check_combination = $conn->query($sql_check_combination);
    if ($result_check_combination->num_rows > 0) {
        echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: 'ชื่อนามสกุลนี้มีการสมัครมาเเล้ว',
                      });
            </script>";
        } else {
    // Insert into database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // เตรียมคำสั่ง SQL สำหรับการเพิ่มข้อมูล
    $sql = "INSERT INTO user (Firstname, Lastname, username, Password, Email, Gender, Age, Height, Weight, Phone, bank, account_number, image) 
            VALUES ('$firstname', '$lastname', '$username','$hashedPassword', '$email', '$gender', '$age', '$height', '$weight', '$phone', '$bank', '$account_number', '$targetFile')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>function showRegisterSuccess() {
            Swal.fire({
                icon: 'success',
                title: 'สมัครสำเร็จ',
                confirmButtonText: 'ตกลง'
            }).then(() => {
                toggleForm(); // เมื่อคลิก OK ให้ทำการสลับฟอร์มกลับไปที่ Login
            });
        }
        showRegisterSuccess(); // เรียกใช้ฟังก์ชันเพื่อแสดงหน้าต่างแจ้งเตือน
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
                 }
             }
        }
    }
}
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <style>  @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Mitr", sans-serif;
        }
        .wrapper {
            max-width: 550px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex; 
            align-items: center;
            justify-content: center;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .input-box {
            position: relative;
            margin-top: 30px;
        }

        .input-box input {
            padding: 10px;
            width: 100%;
            max-width: 300px;
            box-sizing: border-box;
            border-radius: 8px;
            outline: none;
            border: 1px solid #333;
        }

        .input-box input:focus + .placeholder,
        .input-box input:not(:placeholder-shown) + .placeholder {
            top: -10px;
            color: #007bff;
            font-weight: bold;
            background-color: #fff;
        }

        .placeholder {
            position: absolute;
            top: 50%;
            left: 8px;
            font-size: 14px;
            padding: 0px 5px;
            color: #666;
            transform: translateY(-50%);
            transition: top 0.3s ease, color 0.3s ease, background-color 0.3s ease;
            pointer-events: none;
        }

        .input:focus + .placeholder
        {
            top: -10px;
            color: #ffffff;
            background-color: #fff;
        }

        .input-radio {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        .radio-options {
            display: flex;
        }

        .input-radio div {
            font-weight:400;
            margin-right: 10px;
        }

        .input-radio input[type="radio"] {
            margin-right: 10px;
            margin-left: 10px;
        }

        .image_proflie {
            margin-top: 20px;
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .image_proflie input[type="file"]{
            display: none;
        }

        .image_proflie label{
            display: inline-block;
            text-transform: uppercase;
            color: #fff;
            background: #007bff;
            text-align: center;
            padding: 8px 20px;
            font-size: 18px;
            letter-spacing: 1.5px;
            user-select: none;
            cursor: pointer;
            box-shadow: 0px 5px 25px rgba(0,0,0,0.15);
            border-radius: 8px;
        }

        .image_proflie label:hover {
            background: #0056b3;
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #4caf50;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .login-link {
            text-align: center;
            margin-top: 10px;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .wrapper .btn {
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            margin: 10px;
            height: 55px;
            text-align: center;
            border: none;
            background-size: 300% 100%;
            border-radius: 50px;
            -moz-transition: all .4s ease-in-out;
            -o-transition: all .4s ease-in-out;
            -webkit-transition: all .4s ease-in-out;
            transition: all .4s ease-in-out;
            background-image: linear-gradient(
                    to right,
                    #25aae1,
                    #4481eb,
                    #04befe,
                    #3f86ed
            );
            box-shadow: 0 4px 15px 0 rgba(65, 132, 234, 0.75);
        }

        .wrapper .btn:hover {
            background-position: 100% 0;
            -moz-transition: all .4s ease-in-out;
            -o-transition: all .4s ease-in-out;
            -webkit-transition: all .4s ease-in-out;
            transition: all .4s ease-in-out;
        }

        .wrapper .btn:focus {
            outline: none;
        }
</style>
</head>
<body>
<div class="wrapper">
    <form action="signup.php" method="post" enctype="multipart/form-data">
        <h1>สมัครสมาชิก</h1>
        <div>
            <div class="image_proflie">รูปประจำตัว <span style="color: red;">*</span></div>
            <input type="file" name="image" accept="image/*" id="uploadBtn">
        </div>

        <div class="input-box">
            <input type="text" id="firstname" placeholder=" " name="firstname" required>
            <label class="placeholder">ชื่อ <span style="color: red;">*</span></label>
        </div>
        
        <div class="input-box">
            <input type="text" name="lastname" placeholder=" " required>
            <label class="placeholder">นามสกุล <span style="color: red;">*</span></label>
        </div>

        <div class="input-box">
            <input type="text" name="username" placeholder=" " required>
            <label class="placeholder">ชื่อผู้ใช้ <span style="color: red;">*</span></label>
        </div>

        <div class="input-box">
            <input type="email" name="email" placeholder=" " required>
            <label class="placeholder">อีเมล <span style="color: red;">*</span></label>
        </div>

        <div class="input-box">
            <input type="password" name="password" placeholder=" " required>
            <label class="placeholder">รหัสผ่าน <span style="color: red;">*</span></label>
        </div>
        <div class="input-radio">
            <div>เพศ <span style="color: red;">*</span></div><br>
            <div class="radio-options">
                <label for="male">
                    <input type="radio" id="ชาย" name="gender" value="ชาย">
                    ชาย
                </label><br>
                <label for="female">
                    <input type="radio" id="หญิง" name="gender" value="หญิง">
                    หญิง
                </label><br>
                <label for="other">
                    <input type="radio" id="อื่นๆ" name="gender" value="อื่นๆ">
                    อื่นๆ
                </label>
            </div>
        </div>
        <div class="input-box">
            <label for="bank">ธนาคาร <span style="color: red;">*</span></label>
            <select id="bank" name="bank" required>
                    <option value="" disabled selected>กรุณาเลือกธนาคาร</option>
                    <option value="ธนาคารกรุงเทพ">ธนาคารกรุงเทพ</option>
                    <option value="ธนาคารกสิกรไทย">ธนาคารกสิกรไทย</option>
                    <option value="ธนาคารกรุงไทย">ธนาคารกรุงไทย</option>
                    <option value="ธนาคารทหารไทย">ธนาคารทหารไทย</option>
                    <option value="ธนาคารไทยพาณิชย์">ธนาคารไทยพาณิชย์</option>
                    <option value="ธนาคารกรุงศรีอยุธยา">ธนาคารกรุงศรีอยุธยา</option>
                    <option value="ธนาคารเกียรตินาคิน">ธนาคารเกียรตินาคิน</option>
                    <option value="ธนาคารซีไอเอ็มบีไทย">ธนาคารซีไอเอ็มบีไทย</option>
                    <option value="ธนาคารทิสโก้">ธนาคารทิสโก้</option>
                    <option value="ธนาคารธนชาต">ธนาคารธนชาต</option>
                    <option value="ธนาคารยูโอบี">ธนาคารยูโอบี</option>
                    <option value="ธนาคารสแตนดาร์ดชาร์เตอร์ด (ไทย)">ธนาคารสแตนดาร์ดชาร์เตอร์ด (ไทย)</option>
                    <option value="ธนาคารไทยเครดิตเพื่อรายย่อย">ธนาคารไทยเครดิตเพื่อรายย่อย</option>
                    <option value="ธนาคารแลนด์ แอนด์ เฮาส์">ธนาคารแลนด์ แอนด์ เฮาส์</option>
                    <option value="ธนาคารไอซีบีซี (ไทย)">ธนาคารไอซีบีซี (ไทย)</option>
                    <option value="ธนาคารพัฒนาวิสาหกิจขนาดกลางและขนาดย่อมแห่งประเทศไทย">ธนาคารพัฒนาวิสาหกิจขนาดกลางและขนาดย่อมแห่งประเทศไทย</option>
                    <option value="ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร">ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร</option>
                    <option value="ธนาคารเพื่อการส่งออกและนำเข้าแห่งประเทศไทย">ธนาคารเพื่อการส่งออกและนำเข้าแห่งประเทศไทย</option>
                    <option value="ธนาคารออมสิน">ธนาคารออมสิน</option>
                    <option value="ธนาคารอาคารสงเคราะห์">ธนาคารอาคารสงเคราะห์</option>
                    <option value="ธนาคารอิสลามแห่งประเทศไทย">ธนาคารอิสลามแห่งประเทศไทย</option>
                    <option value="ธนาคารแห่งประเทศจีน">ธนาคารแห่งประเทศจีน</option>
                    <option value="ธนาคารซูมิโตโม มิตซุย ทรัสต์ (ไทย)">ธนาคารซูมิโตโม มิตซุย ทรัสต์ (ไทย)</option>
                    <option value="ธนาคารฮ่องกงและเซี้ยงไฮ้แบงกิ้งคอร์ปอเรชั่น จำกัด">ธนาคารฮ่องกงและเซี้ยงไฮ้แบงกิ้งคอร์ปอเรชั่น จำกัด</option>
                </select>
           </div> 
            <div class="input-box">
            <input type="number" name="account_number" placeholder=" " required>
            <label class="placeholder">เลขที่บัญชี <span style="color: red;">*</span></label>
        </div>
        <div class="input-box">
            <input type="number" name="age" placeholder=" " min="15" max="90" required>
            <label class="placeholder">อายุ <span style="color: red;">*</span></label>
        </div>

        <div class="input-box">
            <input type="number" name="height" placeholder=" " min="140" max="230" required>
            <label class="placeholder">ส่วนสูง <span style="color: red;">*</span></label>
        </div>

        <div class="input-box">
            <input type="number" name="weight" placeholder=" " min="30" max="200" required>
            <label class="placeholder">น้ำหนัก <span style="color: red;">*</span></label>
        </div>

        <div class="input-box">
            <input type="tel" name="phone" placeholder=" " maxlength="10" required>
            <label class="placeholder">เบอร์โทร <span style="color: red;">*</span></label>
        </div>
        <button type="submit" class="btn" name="signup">สมัครสมาชิก</button>
        <div class="login-link">
            <p>มีบัญชีอยู่แล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
        </div>
    </form>
</div>
</body>
</html>