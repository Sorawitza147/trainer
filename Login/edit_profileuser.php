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
        function showRegisterSuccess() {
          Swal.fire({
              icon: 'success',
              title: 'อัพเดทข้อมูลเรียบร้อยเเล้ว',
              confirmButtonText: 'ตกลง'
          }).then(() => {
              window.location.href = 'user.php';
          });
        }
        showRegisterSuccess(); 
      </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขโปรไฟล์ผู้ใช้</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <select id="bank" name="bank" required>
            <option value="" disabled selected>กรุณาเลือกธนาคาร</option>
            <?php
            $banks = array(
                "ธนาคารกรุงเทพ",
                "ธนาคารกสิกรไทย",
                "ธนาคารกรุงไทย",
                "ธนาคารทหารไทย",
                "ธนาคารไทยพาณิชย์",
                "ธนาคารกรุงศรีอยุธยา",
                "ธนาคารเกียรตินาคิน",
                "ธนาคารซีไอเอ็มบีไทย",
                "ธนาคารทิสโก้",
                "ธนาคารธนชาต",
                "ธนาคารยูโอบี",
                "ธนาคารสแตนดาร์ดชาร์เตอร์ด (ไทย)",
                "ธนาคารไทยเครดิตเพื่อรายย่อย",
                "ธนาคารแลนด์ แอนด์ เฮาส์",
                "ธนาคารไอซีบีซี (ไทย)",
                "ธนาคารพัฒนาวิสาหกิจขนาดกลางและขนาดย่อมแห่งประเทศไทย",
                "ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร",
                "ธนาคารเพื่อการส่งออกและนำเข้าแห่งประเทศไทย",
                "ธนาคารออมสิน",
                "ธนาคารอาคารสงเคราะห์",
                "ธนาคารอิสลามแห่งประเทศไทย",
                "ธนาคารแห่งประเทศจีน",
                "ธนาคารซูมิโตโม มิตซุย ทรัสต์ (ไทย)",
                "ธนาคารฮ่องกงและเซี้ยงไฮ้แบงกิ้งคอร์ปอเรชั่น จำกัด"
            );

            foreach ($banks as $bank) {
                if ($bank === $row['bank']) {
                    echo "<option value=\"$bank\" selected>$bank</option>";
                } else {
                    echo "<option value=\"$bank\">$bank</option>";
                }
            }
            ?>
        </select>
           </div> 
           <input type="number" name="account_number" placeholder="เลขบัญชีธนาคาร" value="<?php echo $row['account_number']; ?>" required>
            <button class="btn-submit" type="submit">บันทึกการเปลี่ยนแปลง</button>
        </form>
        <a href="user.php" class="back-button">ย้อนกลับ</a>
    </div>
</body>
</html>