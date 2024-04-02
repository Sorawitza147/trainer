<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Status</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Mitr", sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .edit-button {
            background-color: #33CCFF	;
            color: white;
            padding: 6px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;  
            border-radius: 4px;
        }
        .edit-button:hover {
            background-color: #45a049;
        }
        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Course Status</h1>
        <a href="../indextrainer.php" class="edit-button">ย้อนกลับ</a>
    </div>
    <table>
    <tr>
      <th>ID</th>
      <th>ชื่อคอร์ส</th>
      <th>รายละเอียด</th>
      <th>ราคา</th>
      <th>วันที่เริ่ม</th>
      <th>วันที่สิ้นสุด</th>
      <th>เวลาที่เริ่ม</th>
      <th>เวลาที่สิ้นสุด</th>
      <th>สถานะ</th>
      <th>การจัดการ</th>
    </tr>

    <?php
session_name("trainer_session");
session_start();

// ดึง username จาก session
$trainerusername = $_SESSION['trainerusername'];

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "trainer");

// ดึงข้อมูลคอร์ส
$sql = "SELECT
  c.course_id,
  c.title,
  c.description,
  c.price,
  c.start_date,
  c.end_date,
  c.status,
  c.start_time,
  c.end_time
FROM accepted_course AS c
INNER JOIN accepted_trainers AS at ON c.trainer_id = at.trainer_id
WHERE at.trainerusername = '$trainerusername'";
$result = $conn->query($sql);

// แสดงข้อมูลคอร์ส
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['course_id'] . "</td>";
    echo "<td>" . $row['title'] . "</td>";
    echo "<td>" . $row['description'] . "</td>";
    echo "<td>" . $row['price'] . "</td>";
    $start_date_thai = date("j F Y", strtotime($row["start_date"]));
    $end_date_thai = date("j F Y", strtotime($row["end_date"]));
    
    // แสดงข้อความในภาษาไทย
    echo "<td> $start_date_thai</td>";
    echo "<td> $end_date_thai</td>";
    echo "<td> " . $row["start_time"] . "</td>";
    echo "<td> " . $row["end_time"] . "</td>";
    echo "<td>" . $row['status'] . "</td>";
    echo "<td>";
    echo "<a href='edit_course.php?id=" . $row['course_id'] . "' class='edit-button'>เสร็จสิ้น </a>";
    echo "</td>";
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='8'>ไม่พบข้อมูลคอร์ส</td></tr>";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
</table>
</body>
</html>
