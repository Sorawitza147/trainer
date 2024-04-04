<?php
session_name("user_session");
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit; 
}


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trainer";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$username = $_SESSION['username'];
$sql = "SELECT * FROM user WHERE username = '$username'";

$result = $conn->query($sql);


if ($result === false || $result->num_rows === 0) {
    echo "0 results or Error: " . mysqli_error($conn);
} else {
    $row = $result->fetch_assoc(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $phone = $_POST['phone'];
    $bank = $_POST['bank'];
    $account_number = $_POST['account_number'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image = $_FILES['image'];

        if ($image['error'] === 0) {
            if (!empty($row['image'])) {
                unlink($row['image']);
            }

            $new_filename = uniqid() . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);

            move_uploaded_file($image['tmp_name'], 'uppic/' . $new_filename);
            $update_sql = "UPDATE user SET image='uppic/" . $new_filename . "' WHERE username='$username'";
            $conn->query($update_sql);
        }
    }

    $update_sql = "UPDATE user SET firstname='$firstname', lastname='$lastname', email='$email', gender='$gender', age=$age, height=$height, weight=$weight, phone='$phone', bank='$bank', account_number='$account_number' WHERE username='$username'";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>
        window.onload = function() {
            var welcomeMessage = 'อัพเดทสถานะเรียบร้อยเเล้ว';
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
                window.location.href = 'edit_profileuser.php';
            }, 3000);
        };
    </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขโปรไฟล์ผู้ใช้</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Mitr", sans-serif;
        }

        .edit-profile-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            width: 80%;
            max-width: 600px;
            text-align: center;
            position: relative; 
        }

        .edit-profile-container h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .edit-profile-container input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .edit-profile-container button {
            background-color: #00CCFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-transform: uppercase;
            font-weight: bold;
            margin-top: 20px; 
        }
        .profile-picture {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 10px; 
        }
        .profile-picture img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
  
        .edit-profile-container button:hover {
            background-color: #ff9933;
        }

        .back-button {
            position: absolute;
            top: 20px;
            right: 20px; 
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-transform: uppercase;
            font-weight: bold;
            background-color: #00CCFF;
            color: #fff;
        }

        .back-button:hover {
            background-color: #999;
        }
    </style>
</head>
<body>
    <div class="edit-profile-container">
        <h2>แก้ไขโปรไฟล์</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class='profile-picture'>
                <?php
                if (!empty($row['image'])) {
                    echo "<img src='" . $row['image'] ."'>";
                } else {
                    echo "<img src='uppic/default.jpg' alt='โปรไฟล์'>";
                }
                ?>
            </div>
            <input type="file" name="image" accept="image/*">
            <input type="text" name="firstname" placeholder="ชื่อ" value="<?php echo $row['firstname']; ?>" required>
            <input type="text" name="lastname" placeholder="นามสกุล" value="<?php echo $row['lastname']; ?>" required>
            <input type="email" name="email" placeholder="อีเมล" value="<?php echo $row['email']; ?>" required>
            <select name="gender" required>
                <option value="ชาย" <?php if ($row['gender'] === 'ชาย') echo 'selected'; ?>>ชาย</option>
                <option value="หญิง" <?php if ($row['gender'] === 'หญิง') echo 'selected'; ?>>หญิง</option>
                <option value="อื่นๆ" <?php if ($row['gender'] === 'อื่นๆ') echo 'selected'; ?>>อื่นๆ</option>
            </select>
            <input type="number" name="age" placeholder="อายุ" value="<?php echo $row['age']; ?>" required>
            <input type="number" name="height" placeholder="ส่วนสูง" value="<?php echo $row['height']; ?>" required>
            <input type="number" name="weight" placeholder="น้ำหนัก" value="<?php echo $row['weight']; ?>" required>
            <input type="text" name="phone" placeholder="เบอร์โทรศัพท์" value="<?php echo $row['phone']; ?>" required>
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
           <input type="number" name="account_number" placeholder="เลขบัญชีธนาคาร" value="<?php echo $row['account_number']; ?>" required>
            <button class="btn-submit" type="submit">บันทึกการเปลี่ยนแปลง</button>
        </form>
        <a href="user.php" class="back-button">ย้อนกลับ</a>
    </div>
</body>
</html>