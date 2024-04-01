<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการใช้บริการของผู้ใช้</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        h2, h3 {
            color: #333333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .error-message {
            color: red;
            margin-top: 20px;
        }

        .table-container {
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <?php
    session_name("user_session");
    session_start();

    // เชื่อมต่อฐานข้อมูล
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbName = "trainer";

    $conn = new mysqli($servername, $username, $password, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ตรวจสอบว่ามีการเข้าสู่ระบบหรือไม่
    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
        // ดึงชื่อผู้ใช้ของเจ้าของ (owner) จาก session
        $username = $_SESSION["username"];

        // คำสั่ง SQL เพื่อดึงข้อมูลจากตาราง course_history_trainer โดยแสดงเฉพาะข้อมูลของเจ้าของ (owner)
        $sql_trainer = "SELECT * FROM course_history_trainer WHERE username = '$username'";
        $result_trainer = $conn->query($sql_trainer);

        if ($result_trainer === false) {
            echo "<div class='error-message'>Error: " . $conn->error . "</div>";
        }
    } else {
        // ถ้าไม่มีการเข้าสู่ระบบให้แสดงข้อความ
        echo "<div class='error-message'>คุณต้องเข้าสู่ระบบก่อนที่จะดูประวัติการใช้บริการ</div>";
    }
    $conn->close();
    ?>

    <div class="container">
        <h2>ประวัติการใช้บริการของผู้ใช้</h2>
        <h3>Course History Trainer</h3>
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Course ID</th>
                        <th>Username</th>
                        <th>Trainer Username</th>
                        <th>Trainer ID</th>
                        <th>Status</th>
                        <th>Title</th>
                        <th>Cover Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Phone Number</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Difficulty</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($result_trainer) && $result_trainer->num_rows > 0) {
                        while($row = $result_trainer->fetch_assoc()) {
                            echo "<tr>
                                <td>".$row["id"]."</td>
                                <td>".$row["course_id"]."</td>
                                <td>".$row["username"]."</td>
                                <td>".$row["trainerusername"]."</td>
                                <td>".$row["trainer_id"]."</td>
                                <td>".$row["status"]."</td>
                                <td>".$row["title"]."</td>
                                <td>".$row["cover_image"]."</td>
                                <td>".$row["name"]."</td>
                                <td>".$row["email"]."</td>
                                <td>".$row["gender"]."</td>
                                <td>".$row["age"]."</td>
                                <td>".$row["phone_number"]."</td>
                                <td>".$row["description"]."</td>
                                <td>".$row["price"]."</td>
                                <td>".$row["difficulty"]."</td>
                                <td>".$row["start_date"]."</td>
                                <td>".$row["end_date"]."</td>
                                <td>".$row["start_time"]."</td>
                                <td>".$row["end_time"]."</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='21'>ไม่พบข้อมูล</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
