<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>คอร์สที่สร้าง</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f2f2f2; /* สีพื้นหลังของหน้าเว็บ */
    }
    .container {
      width: 80%;
      margin: 20px auto; /* ช่องว่างด้านบนและด้านล่าง 20px, ศูนย์กลางตามแนวนอน */
      padding: 20px;
      background-color: #fff; /* สีพื้นหลังของคอนเทนเนอร์ */
      border-radius: 8px; /* เพิ่มเส้นรอบขอบสำหรับมุมคอนเทนเนอร์ */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* เพิ่มเงาให้คอนเทนเนอร์ */
    }
    h1 {
      text-align: center;
      margin-bottom: 20px; /* ช่องว่างด้านล่างของส่วนหัว */
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    table, th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: center;
    }
    th {
      background-color: #f2f2f2;
    }
    .back-button {
      display: block;
      width: 120px;
      margin: 20px auto;
      text-align: center;
      padding: 10px;
      background-color: #4CAF50;
      color: white;
      text-decoration: none;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s; /* เพิ่มเอฟเฟคการเปลี่ยนสีเมื่อโฮเวอร์ */
    }
    .back-button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>

<div class="container">
  <h1>ประวัติ</h1>
  <a href="../indextrainer.php" class="back-button">ย้อนกลับ</a>
  <table>
    <tr>
      <th>ID</th>
      <th>ชื่อเทรนเนอร์</th>
      <th>อีเมล์เทรนเนอร์</th>
      <th>อายุเทรนเนอร์</th>
      <th>ชื่อคอร์ส</th>
      <th>รายละเอียด</th>
      <th>ราคา</th>
      <th>วันที่เริ่ม</th>
      <th>วันที่สิ้นสุด</th>
      <th>เวลาที่เริ่ม</th>
      <th>เวลาที่สิ้นสุด</th>
      <th>การจัดการ</th>
    </tr>

    <?php
session_name("trainer_session");
session_start();

// Retrieve username from session
$trainerusername = $_SESSION['trainerusername'];

// Establish database connection
$conn = new mysqli("localhost", "root", "", "trainer");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch course data
$sql = "SELECT
  c.course_id,
  c.name,
  c.email,
  c.age,
  c.gender,
  c.phone_number,
  c.trainer_id,
  c.title,
  c.price,
  c.duration,
  c.difficulty,
  c.description,
  c.start_date,
  c.end_date,
  c.start_time,
  c.end_time,
  c.cover_image,
  c.created_at,
  c.updated_at,
  c.status
FROM course_history_user AS c
INNER JOIN accepted_trainers AS at ON c.trainer_id = at.trainer_id
WHERE at.trainerusername = '$trainerusername'";

$result = $conn->query($sql);

// Check if the query executed successfully
if ($result === false) {
  echo "Error executing SQL query: " . $conn->error;
} else {
  // Check if there are rows returned
  if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
      // Output course information
        echo "<tr>";
        echo "<td>" . $row['course_id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['age'] . "</td>";
        if ($row['gender'] == 'Male') {
          echo "<td>ชาย</td>";
        } elseif ($row['gender'] == 'Female') {
            echo "<td>หญิง</td>";
        } else {
            echo "<td>ไม่ระบุเพศ</td>";
        }
        echo "<td>" . $row['phone_number'] . "</td>";
        echo "<td>" . $row['trainer_id'] . "</td>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['price'] . "</td>";
        echo "<td>" . $row['duration'] . "</td>";
        echo "<td>" . $row['difficulty'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "<td>" . $row['start_date'] . "</td>";
        echo "<td>" . $row['end_date'] . "</td>";
        echo "<td>" . $row['start_time'] . "</td>";
        echo "<td>" . $row['end_time'] . "</td>";
        echo "<td>" . $row['cover_image'] . "</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "<td>" . $row['updated_at'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
      echo "</tr>";
    }
  } else {
    echo "<tr><td colspan='8'>ไม่พบข้อมูลคอร์ส</td></tr>";
  }
}

// Close database connection
$conn->close();
?>


  </table>
</div>
</body>
</html>