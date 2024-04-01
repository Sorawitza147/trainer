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
      height: 810px;
    }

    .container {
      display: flex;
      justify-content: space-between;
      width: auto;
      overflow: hidden;
    }

    .course-card {
      margin: 10px;
      min-width: 250px;
      height: 800px;
      overflow: hidden;
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
  <div class="course-wrapper">
    <div class="container">

    <?php
    session_name("user_session");
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "trainer";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT courses.*, GROUP_CONCAT(activities.name) AS activities 
    FROM courses 
    LEFT JOIN course_activities ON courses.course_id = course_activities.course_id
    LEFT JOIN activities ON course_activities.activity_id = activities.id
    GROUP BY courses.course_id";

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
     echo "<p>รายละเอียด: " . $row["description"] . "</p>";
     echo "<p>฿: " . $row["price"] . "</p>";
     echo "<p>ระดับ: " . $row["difficulty"] . "</p>";

     // แปลงรูปแบบวันที่
     $start_date_thai = date("j F Y", strtotime($row["start_date"]));
     $end_date_thai = date("j F Y", strtotime($row["end_date"]));

     // แสดงข้อความ
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
       echo "<input type='hidden' name='trainer_id' value='" . $row["trainer_id"] . "'>";
       echo "<input type='hidden' name='title' value='" . $row["title"] . "'>";
       echo "<input type='hidden' name='name' value='" . $row["name"] . "'>";
       echo "<input type='hidden' name='cover_image' value='" . $row["cover_image"] . "'>";
       echo "<input type='hidden' name='email' value='" . $row["email"] . "'>";
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
       echo "<button type='submit' class='button'>จ้างเทรนเนอร์</button>";
       echo "</form>";
     } else {
       echo "<a href='login.php' class='button'>เข้าสู่ระบบเพื่อจ้างเทรนเนอร์</a>";
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
</script>
</body>
</html>
