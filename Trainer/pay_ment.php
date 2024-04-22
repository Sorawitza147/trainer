<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>สถานะการโอนเงิน</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1>สถานะการโอนเงิน</h1>
    <table class="table mt-3">
      <thead>
        <tr>
          <th>id</th>
          <th>ชื่อคอร์ส</th>
          <th>ชื่อเทรนเนอร์</th>
          <th>ทำรายการเมื่อ</th>
          <th>สภานะ</th>
          <th>เหตุผล</th>
        </tr>
      </thead>
      <tbody>
        <?php
        session_name("trainer_session");
        session_start();
        // เชื่อมต่อฐานข้อมูล
        $conn = new mysqli("localhost", "root", "", "trainer");

        // ตรวจสอบการเชื่อมต่อ
        if ($conn->connect_error) {
            die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
        }

        // ดึงชื่อผู้ใช้ปัจจุบันจาก session
        $trainerusername = $_SESSION['trainerusername'];

        // เตรียมคำสั่ง SQL สำหรับการดึงข้อมูลการชำระเงินของผู้ใช้
        $sql = "SELECT * FROM payment_trainer WHERE trainerusername = '$trainerusername'";

        // ประมวลผลคำสั่ง SQL
        $result = $conn->query($sql);

        // ตรวจสอบว่ามีข้อมูลที่ได้รับหรือไม่
        if ($result->num_rows > 0) {
            // แสดงข้อมูลในตาราง
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["created_at"] . "</td>";
                echo "<td>" . $row["status_payment"] . "</td>";
                echo "<td>" . $row["reason"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>ไม่พบข้อมูลการชำระเงิน</td></tr>";
        }
        // ปิดการเชื่อมต่อฐานข้อมูล
        $conn->close();
        ?>
      </tbody>
    </table>
    <!-- ปุ่มย้อนกลับ -->
    <a href="../indextrainer.php" class="btn btn-primary">ย้อนกลับ</a>
  </div>
</body>
</html>
