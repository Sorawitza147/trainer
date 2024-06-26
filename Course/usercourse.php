<?php
session_name("user_session");
session_start();
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ชื่อคอร์ส</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Mitr", sans-serif;
}


    .course-wrapper {
      display: flex;
      justify-content: center;
      margin: 30px auto; 
      border: 1px solid #ddd;
      border-radius: 5px; 
      padding: 20px; 
      height: auto;
    }

    .container {
      display: flex;
      justify-content: space-between;
      width: auto;
      overflow: hidden;
    }

    .course-card {
      margin: 10px;
      width: 300px;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .course-card h2 {
      margin-top: 0;
      margin-left: 12px;
    }

    .course-card p {
      margin-bottom: 10px;
      margin-left: 12px;
    }

    .course-card img {
      width: 300px;
      height: 200px;
      margin-bottom: 10px;
      border-radius: 5px;
    }

    .button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    .button:hover {
      background-color: #0056b3;
    }

    #prevBtn,
    #nextBtn {
      margin: 10px 0; 
    }

    .button:hover {
      background-color: #0056b3;
    }

    #prevBtn,
    #nextBtn {
      position: absolute;
      top: auto;
      transform: translateY(-50%);
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    #prevBtn {
      left: 20px;
    }

    #nextBtn {
      right: 20px;
    }
    .Backbtn {
      position: absolute;
      top: 20px;
      right: 20px;
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .Backbtn:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
<center><h1>คอร์สที่มี</h1></center>
<a href='../indexuser.php' class='Backbtn'>ย้อนกลับ</a>
<form method="GET" action="" style="margin-top: 20px; margin-left: 20px;">
    <details style="margin-bottom: 10px;">
        <summary>แสดงตัวเลือก</summary>
        <label for="gender" style="font-weight: bold;">เลือกเพศของเทรนเนอร์:</label>
        <select name="gender" id="gender" style="padding: 5px; border-radius: 5px; margin-right: 10px;">
            <option value="">ทั้งหมด</option>
            <option value="ชาย">ชาย</option>
            <option value="หญิง">หญิง</option>
        </select><br>
        <label for="activities" style="font-weight: bold;">เลือกกิจกรรม:</label><br>
        <div style="padding-left: 20px;">
            <input type="checkbox" name="activities[]" value="เต้นแอโรบิก" id="aerobic">
            <label for="aerobic">เต้นแอโรบิก</label><br>
            <input type="checkbox" name="activities[]" value="การฝึกป้องกันตัว" id="self-defense">
            <label for="self-defense">การฝึกป้องกันตัว</label><br>
            <input type="checkbox" name="activities[]" value="บอดี้เวท" id="body-weight">
            <label for="body-weight">บอดี้เวท</label><br>
            <input type="checkbox" name="activities[]" value="เวทเทรนนิ่ง" id="strength-training">
            <label for="strength-training">เวทเทรนนิ่ง</label><br>
            <input type="checkbox" name="activities[]" value="การโยคะ" id="yoga">
            <label for="yoga">การโยคะ</label><br>
            <input type="checkbox" name="activities[]" value="คาดิโอ" id="cardio">
            <label for="cardio">คาดิโอ</label><br>
            <input type="checkbox" name="activities[]" value="ลดน้ำหนัก" id="weight-loss">
            <label for="weight-loss">ลดน้ำหนัก</label><br>
            <input type="checkbox" name="activities[]" value="การสร้างกล้ามเนื้อ" id="muscle-building">
            <label for="muscle-building">การสร้างกล้ามเนื้อ</label><br>
            <input type="checkbox" name="activities[]" value="การฝึกกลุ่ม" id="group-training">
            <label for="group-training">การฝึกกลุ่ม</label><br>
            <input type="checkbox" name="activities[]" value="การฝึกออนไลน์" id="online-training">
            <label for="online-training">การฝึกออนไลน์</label><br>
            <input type="checkbox" name="activities[]" value="เพิ่มน้ำหนัก" id="weight-gain">
            <label for="weight-gain">เพิ่มน้ำหนัก</label><br>
            <input type="checkbox" name="activities[]" value="การฝึกออนไซต์" id="site-training">
            <label for="site-training">การฝึกออนไซต์</label><br>
        </div>
    </details>
    <button type="submit" style="padding: 8px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;">ค้นหา</button>
</form>
  <div class="course-wrapper">
    <div class="container">


<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "trainer";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_GET['gender']) && $_GET['gender'] !== '' && isset($_GET['activities']) && !empty($_GET['activities'])) {
  $gender = $_GET['gender'];
  $selected_activities = $_GET['activities'];
  $activities_str = "'" . implode("','", $selected_activities) . "'";
  $sql = "SELECT courses.*, GROUP_CONCAT(activities.name) AS activities 
          FROM courses 
          LEFT JOIN course_activities ON courses.course_id = course_activities.course_id
          LEFT JOIN activities ON course_activities.activity_id = activities.id
          WHERE courses.gender = '$gender' AND activities.name IN ($activities_str)
          GROUP BY courses.course_id";
} else if (isset($_GET['gender']) && $_GET['gender'] !== '') {
  $gender = $_GET['gender'];
  $sql = "SELECT courses.*, GROUP_CONCAT(activities.name) AS activities 
          FROM courses 
          LEFT JOIN course_activities ON courses.course_id = course_activities.course_id
          LEFT JOIN activities ON course_activities.activity_id = activities.id
          WHERE courses.gender = '$gender'
          GROUP BY courses.course_id";
} else if (isset($_GET['activities']) && !empty($_GET['activities'])) {
  $selected_activities = $_GET['activities'];
  $activities_str = "'" . implode("','", $selected_activities) . "'";
  $sql = "SELECT courses.*, GROUP_CONCAT(activities.name) AS activities 
          FROM courses 
          LEFT JOIN course_activities ON courses.course_id = course_activities.course_id
          LEFT JOIN activities ON course_activities.activity_id = activities.id
          WHERE activities.name IN ($activities_str)
          GROUP BY courses.course_id";
} else {
  $sql = "SELECT courses.*, GROUP_CONCAT(activities.name) AS activities 
          FROM courses 
          LEFT JOIN course_activities ON courses.course_id = course_activities.course_id
          LEFT JOIN activities ON course_activities.activity_id = activities.id
          GROUP BY courses.course_id";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='course-card'>";
        echo "<h2>" . $row["title"] . "</h2>";
        echo "<img src='uploadscourse/" . $row["cover_image"] . "'>";
        echo "<p>ชื่อเทรนเนอร์: " . $row["name"] . "</p>";
        echo "<p>อีเมล์: " . $row["email"] . "</p>";
        echo "<p>เพศของเทรนเนอร์: " . $row["gender"] . "</p>";
        echo "<p>อายุของเทรนเนอร์: " . $row["age"] . "</p>";
        echo "<p>เบอร์โทร: " . $row["phone_number"] . "</p>";
        echo "<p><a href='trainer_details.php?trainer_id=" . $row["trainer_id"] . "'>ดูข้อมูลเทรนเนอร์</a></p>";
        echo "<p>รายละเอียด: " . $row["description"] . "</p>";
        echo "<p>ระยะเวลา: " . $row["duration"] . " ชั่วโมง</p>";
        echo "<p>฿: " . $row["price"] . " บาท</p>";
        echo "<p>ระดับ: " . $row["difficulty"] . "</p>";
        $start_date_thai = date("j F Y", strtotime($row["start_date"]));
        $end_date_thai = date("j F Y", strtotime($row["end_date"]));
        echo "<p>วันเริ่ม: $start_date_thai</p>";
        echo "<p>ถึง: $end_date_thai</p>";
        echo "<p>เวลา: " . $row["start_time"] . "</p>";
        echo "<p>ถึง: " . $row["end_time"] . "</p>";
        echo "<p>แท๊ก: " . $row["activities"] . "</p>";

        if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
            echo "<form method='post' action='process_hire.php'>";
            echo "<input type='hidden' name='username' value='" . $_SESSION["username"] . "'>";
            echo "<input type='hidden' name='trainerusername' value='" . $row["trainerusername"] . "'>";
            echo "<input type='hidden' name='course_id' value='" . $row["course_id"] . "'>";
            $course = uniqid('PAY'); 
            echo "<input type='hidden' name='course' value='" . $course . "'>";
            $payment_id = uniqid('PAY');
            echo "<input type='hidden' name='payment_id' value='" . $payment_id . "'>";
            echo "<input type='hidden' name='trainer_id' value='" . $row["trainer_id"] . "'>";
            echo "<input type='hidden' name='title' value='" . $row["title"] . "'>";
            echo "<input type='hidden' name='name' value='" . $row["name"] . "'>";
            echo "<input type='hidden' name='cover_image' value='" . $row["cover_image"] . "'>";
            echo "<input type='hidden' name='email' value='" . $row["email"] . "'>";
            echo "<input type='hidden' name='duration' value='" . $row["duration"] . "'>";
            echo "<input type='hidden' name='age' value='" . $row["age"] . "'>";
            echo "<input type='hidden' name='phone_number' value='" . $row["phone_number"] . "'>";
            echo "<input type='hidden' name='description' value='" . $row["description"] . "'>";
            echo "<input type='hidden' name='price' value='" . $row["price"] . "'>";
            echo "<input type='hidden' name='difficulty' value='" . $row["difficulty"] . "'>";
            echo "<input type='hidden' name='start_date' value='" . $row["start_date"] . "'>";
            echo "<input type='hidden' name='end_date' value='" . $row["end_date"] . "'>";
            echo "<input type='hidden' name='start_time' value='" . $row["start_time"] . "'>";
            echo "<input type='hidden' name='end_time' value='" . $row["end_time"] . "'>";
            echo "<input type='hidden' name='status' value='รอเทรนเนอร์ตอบรับ'>";
            echo "<input type='hidden' name='course_status' value='ติดจ้าง'>";
            echo "<input type='hidden' name='payment_status' value='ยังไม่ชำระเงิน'>";
            $course_status_query = "SELECT course_status FROM courses WHERE course_id = ?";
          $stmt = $conn->prepare($course_status_query);
          $stmt->bind_param("i", $row["course_id"]); 
          $stmt->execute();
          $stmt->store_result();

          if ($stmt->num_rows > 0) {
              $stmt->bind_result($course_status);
              $stmt->fetch();
              
              // เช็คสถานะของคอร์ส
              if ($course_status == "ว่าง") {
                // แสดงปุ่ม "จ้างเทรนเนอร์"
                echo "<button type='submit' class='button' onclick=\"confirmHire() && setCancelTime()\">จ้างเทรนเนอร์</button>";
              } else {
                // แสดงสถานะตามข้อมูลใน course_status
                echo "<button type='submit' class='button' disabled>$course_status</button>";
            }
          } else {
              // หากไม่พบข้อมูลในตาราง courses
              echo "<button type='submit' class='button' disabled>ไม่สามารถจ้างได้</button>";
          }
          $stmt->close();
            echo "</form>";
        } else {
            echo "<a href='../Login/login.php' class='button'>เข้าสู่ระบบเพื่อจ้างเทรนเนอร์</a>";
        }

        echo "</div>";
    }
} else {
    echo "ไม่พบข้อมูลคอร์ส";
}
$conn->close();
?>
  </div>
</div>
<center>
  <button id="prevBtn">ย้อนกลับ</button>
  <button id="nextBtn">ถัดไป</button>
</center>
<script>
  function setCancelTime() {
    const cancelTime = document.getElementById("cancelTime").value;
    if (cancelTime) {
        sendCancelTime(cancelTime);
    } else {
        alert("โปรดเลือกเวลาที่ต้องการยกเลิก");
    }
}

function sendCancelTime(cancelTime) {
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                alert(xhr.responseText); // แสดงข้อความที่ได้จากเซิร์ฟเวอร์
            } else {
                console.error('มีข้อผิดพลาด: ' + xhr.status);
            }
        }
    };
    xhr.open('POST', 'process_cancel_time.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('cancelTime=' + cancelTime);
}
    window.onload = function() {
        const container = document.querySelector('.container');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        prevBtn.addEventListener('click', function() {
            container.scrollBy({
                left: -200,
                behavior: 'smooth' 
            });
        });

        nextBtn.addEventListener('click', function() {
            container.scrollBy({
                left: 200, 
                behavior: 'smooth' 
            });
        });
    };
   
  function confirmHire() {
    return confirm("คุณต้องการจ้างเทรนเนอร์นี้ใช่หรือไม่?\nโปรดชำระเงิน ถ้าไม่ชำระเงินจะไม่สามารถจ้างเทรนเนอร์ได้\nสามารถชำระได้หน้าจ้างเทรนเนอร์");
  }
</script>
</body>
</html>
