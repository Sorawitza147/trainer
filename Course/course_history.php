<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>คอร์สที่สร้าง</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Mitr", sans-serif;
}
    body {
      margin: 0;
      padding: 0;
      background-color: #f2f2f2; 
    }
    .container {
      width: 100%;
      margin: 20px auto; 
      padding: 20px;
      background-color: #fff; 
      border-radius: 8px; 
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
    }
    h1 {
      text-align: center;
      margin-bottom: 20px; 
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 10px; 
    }

    th {
      background-color: #f2f2f2;
      font-weight: bold;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2; 
    }

    tr:hover {
      background-color: #f0f0f0; 
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
      transition: background-color 0.3s;
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
      <th>เพศ</th>
      <th>เบอร์</th>
      <th>ชื่อคอร์ส</th>
      <th>ราคา</th>
      <th>ระดับ</th>
      <th>รายละเอียด</th>
      <th>วันที่เริ่ม</th>
      <th>วันที่สิ้นสุด</th>
      <th>เวลาที่เริ่ม</th>
      <th>เวลาที่สิ้นสุด</th>
      <th>ภาพปก</th>
      <th>วันที่สร้าง</th>
      <th>สถานะ</th>
    </tr>

    <?php
session_name("trainer_session");
session_start();
$trainerusername = $_SESSION['trainerusername'];

$conn = new mysqli("localhost", "root", "", "trainer");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT
  c.course_id,
  c.name,
  c.email,
  c.age,
  c.gender,
  c.phone_number,
  c.title,
  c.price,
  c.difficulty,
  c.description,
  c.start_date,
  c.end_date,
  c.start_time,
  c.end_time,
  c.cover_image,
  c.created_at,
  c.status
FROM course_history_trainer AS c
INNER JOIN accepted_trainers AS at ON c.trainer_id = at.trainer_id
WHERE at.trainerusername = '$trainerusername'";

$result = $conn->query($sql);
if ($result === false) {
  echo "Error executing SQL query: " . $conn->error;
} else {
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['course_id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['age'] . "</td>";
        echo "<td>" . $row['gender'] . "</td>";
        echo "<td>" . $row['phone_number'] . "</td>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['price'] . "</td>";
        echo "<td>" . $row['difficulty'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "<td>" . $row['start_date'] . "</td>";
        echo "<td>" . $row['end_date'] . "</td>";
        echo "<td>" . $row['start_time'] . "</td>";
        echo "<td>" . $row['end_time'] . "</td>";
        echo "<td>" . $row['cover_image'] . "</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
      echo "</tr>";
    }
  } else {
    echo "<tr><td colspan='13'>ไม่พบข้อมูลคอร์ส</td></tr>";
  }
}
$conn->close();
?>

</div>
</table>
</body>
</html>