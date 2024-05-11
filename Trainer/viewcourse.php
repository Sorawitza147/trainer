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
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    .container {
      width: 80%;
      margin: 0 auto;
      padding: 20px;
    }
    h1 {
      text-align: center;
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
    }
    .back-button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>

<div class="container">
  <h1>คอร์สที่สร้าง</h1>
  <a href="../indextrainer.php" class="back-button">ย้อนกลับ</a>
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
      <th>การจัดการ</th>
    </tr>

    <?php
session_name("trainer_session");
session_start();

$trainerusername = $_SESSION['trainerusername'];
$conn = new mysqli("localhost", "root", "", "trainer");
$sql = "SELECT
  c.course_id,
  c.title,
  c.description,
  c.price,
  c.start_date,
  c.end_date,
  c.start_time,
  c.end_time
FROM courses AS c
INNER JOIN accepted_trainers AS at ON c.trainer_id = at.trainer_id
WHERE at.trainerusername = '$trainerusername'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['course_id'] . "</td>";
    echo "<td>" . $row['title'] . "</td>";
    echo "<td>" . $row['description'] . "</td>";
    echo "<td>" . $row['price'] . "</td>";
    $start_date_thai = date("j F Y", strtotime($row["start_date"]));
    $end_date_thai = date("j F Y", strtotime($row["end_date"]));
    echo "<td> $start_date_thai</td>";
    echo "<td> $end_date_thai</td>";
    echo "<td> " . $row["start_time"] . "</td>";
    echo "<td> " . $row["end_time"] . "</td>";
    echo "<td>";
    echo "<a href='edit_course.php?id=" . $row['course_id'] . "' class='edit-button'>แก้ไข</a> | ";
    echo "<a href='javascript:confirmDelete(" . $row['course_id'] . ")' class='delete-button'>ลบ</a>";
    echo "</td>";
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='8'>ไม่พบข้อมูลคอร์ส</td></tr>";
}
$conn->close();
?>

  </table>
</div>
<script>
function confirmDelete(courseId) {
  var result = confirm("ยืนยันการลบคอร์ส " + courseId + " ?");
  if (result) {
    window.location.href = "delete_course.php?delete_course_id=" + courseId;
  }
}
</script>
</body>
</html>