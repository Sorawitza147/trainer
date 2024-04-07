<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ข้อมูลการจ้างเทรนเนอร์</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Mitr", sans-serif;
    }
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
      color: #333;
      text-align: center;
      margin-bottom: 20px;
    }
    .course-card {
      background-color: #f9f9f9;
      margin-bottom: 20px;
      padding: 20px;
      border-radius: 4px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .course-card img {
      max-width: 100%;
      height: auto;
      border-radius: 4px;
      margin-bottom: 10px;
    }
    .course-card p {
      margin-bottom: 5px;
    }
    .course-card button {
      background-color: #dc3545;
      color: #fff;
      border: none;
      padding: 8px 16px;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .course-card button:hover {
      background-color: #c82333;
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
    .course-card {
  margin-bottom: 20px;
  border-bottom: 1px solid #ccc; /* เพิ่มเส้นแบ่งด้านล่างของ .course-card */
  padding-bottom: 20px; /* เพิ่มระยะห่างด้านล่างของ .course-card */
}
  </style>
</head>
<body>
<a href='../indexuser.php' class='Backbtn'>ย้อนกลับ</a>
  <div class="container">
    <h1>ข้อมูลการจ้างเทรนเนอร์ของคุณ</h1>
    <ul>
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

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    $username = $_SESSION["username"];

    $sql = "SELECT hired_trainers.username, hired_trainers.status, hired_trainers.course_id, courses.title, courses.cover_image, courses.description, courses.price, courses.difficulty, courses.name, courses.email, courses.age, courses.gender, courses.phone_number, courses.start_date, courses.end_date, courses.start_time, courses.end_time, hired_trainers.payment_status
            FROM hired_trainers 
            INNER JOIN courses ON hired_trainers.course_id = courses.course_id
            WHERE hired_trainers.username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          echo "<div class='course-card booked-course'>";
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
          
          $start_date_thai = date("j F Y", strtotime($row["start_date"]));
          $end_date_thai = date("j F Y", strtotime($row["end_date"]));
          
          echo "<p>วันเริ่ม: $start_date_thai</p>";
          echo "<p>ถึง: $end_date_thai</p>";
          echo "<p>เวลา: " . $row["start_time"] . "</p>";
          echo "<p>ถึง: " . $row["end_time"] . "</p>";
          echo "<p>สถานะการชำระเงิน: " . $row["payment_status"] . "</p>";
          echo "<p><a href='payment.php?course_id=" . $row["course_id"] . "'>ชำระเงิน</a></p>";
          
          $start_date = strtotime($row["start_date"]);
          $today = strtotime(date("Y-m-d"));
          $days_difference = ($start_date - $today) / (60 * 60 * 24);
          $cancellation_period = 1; 
  
          if ($days_difference <= $cancellation_period) {
              echo "<button type='button' disabled>ยกเลิกการจ้าง</button>";
              echo "<p>ไม่สามารถยกเลิกการจ้างได้เนื่องจากภายใน {$cancellation_period} วันก่อนวันเริ่ม</p>";
          } else {
              echo "<form action='cancel_hiring.php' method='post'>";
              if (isset($row["course_id"])) {
                  echo "<input type='hidden' name='course_id' value='" . $row["course_id"] . "'>";
              }
              echo "<input type='hidden' name='title' value='" . $row["title"] . "'>";
              echo "<input type='hidden' name='price' value='" . $row["price"] . "'>";
              echo "<button type='submit'>ยกเลิกการจ้าง</button>";
              echo "</form>";
          }
  
          echo "<p>สถานะ: " . $row["status"] . "</p>";
          echo "</div>";
      }
  } else {
      echo "<li>คุณยังไม่มีข้อมูลรอตอบรับจากเทรนเนอร์</li>";
  }
  
  echo "----------------------------------------------------------------------------------------------------";
  echo "----------------------------------------------------------------------------------------------------";
    $sql = "SELECT username, status, course_id, title, cover_image, description, price, difficulty, name, email, age, gender, phone_number, start_date, end_date, start_time, end_time, payment_status
            FROM accepted_course
            WHERE username = '$username'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
            echo "<div class='course-card accepted-course'>";
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
            echo "<p>วันเริ่ม: " . date("j F Y", strtotime($row["start_date"])) . "</p>";
            echo "<p>ถึง: " . date("j F Y", strtotime($row["end_date"])) . "</p>";
            echo "<p>เวลา: " . $row["start_time"] . "</p>";
            echo "<p>ถึง: " . $row["end_time"] . "</p>";
            echo "<p>สถานะการชำระเงิน: " . $row["payment_status"] . "</p>";
            echo "<a href='payment_accepted.php?course_id=" . $row["course_id"] . "'>ชำระเงิน</a>";
            echo "<p>สถานะ: ได้รับการยืนยัน</p>";
            echo "</div>";
            }
            } else {
            echo "<li>คุณยังไม่มีข้อมูลคอร์สที่ได้รับการยืนยัน</li>";
            }
            } else {
                echo "<li>คุณต้องเข้าสู่ระบบเพื่อดูข้อมูลการจ้างเทรนเนอร์ของคุณ</li>";
        }
        $conn->close();
      ?>
    </ul>
  </div>
</body>
</html>
