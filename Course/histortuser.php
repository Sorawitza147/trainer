<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "trainer";

$conn = new mysqli($servername, $username, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// คำสั่ง SQL เพื่อดึงข้อมูลจากตาราง course_history_trainer
$sql_trainer = "SELECT * FROM course_history_trainer";
$result_trainer = $conn->query($sql_trainer);

// คำสั่ง SQL เพื่อดึงข้อมูลจากตาราง course_history_user
$sql_user = "SELECT * FROM course_history_user";
$result_user = $conn->query($sql_user);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการใช้บริการของผู้ใช้</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>ประวัติการใช้บริการของผู้ใช้</h2>
        <h3>Course History Trainer</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Course ID</th>
                    <th>Username</th>
                    <th>Trainer Username</th>
                    <th>Trainer ID</th>
                    <th>Hired At</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_trainer->num_rows > 0) {
                    while($row = $result_trainer->fetch_assoc()) {
                        echo "<tr>
                            <td>".$row["id"]."</td>
                            <td>".$row["course_id"]."</td>
                            <td>".$row["username"]."</td>
                            <td>".$row["trainerusername"]."</td>
                            <td>".$row["trainer_id"]."</td>
                            <td>".$row["hired_at"]."</td>
                            <td>".$row["status"]."</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>ไม่พบข้อมูล</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Course History User</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Course ID</th>
                    <th>Username</th>
                    <th>Trainer ID</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_user->num_rows > 0) {
                    while($row = $result_user->fetch_assoc()) {
                        echo "<tr>
                            <td>".$row["id"]."</td>
                            <td>".$row["course_id"]."</td>
                            <td>".$row["username"]."</td>
                            <td>".$row["trainer_id"]."</td>
                            <td>".$row["start_date"]."</td>
                            <td>".$row["end_date"]."</td>
                            <td>".$row["status"]."</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>ไม่พบข้อมูล</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
