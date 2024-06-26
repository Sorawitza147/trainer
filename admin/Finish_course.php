<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finish Course</title>
    <style>
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
        .container {
            max-width: 65%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .transfer-btn {
            display: block;
            width: 120px;
            padding: 10px;
            margin: 10px auto;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
        }
        .transfer-btn:hover {
            background-color: #45a049;
        }
        .reject-btn {
        display: block;
        width: 120px;
        padding: 10px;
        margin: 10px auto;
        background-color: #CC0000; 
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 4px;
    }
    .reject-btn:hover {
        background-color: #a70000;
    }
    </style>
</head>
<body>
<div class="container">
    <?php
    $conn = new mysqli("localhost", "root", "", "trainer");
    if ($conn->connect_error) {
        die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM finish_course";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Course ID</th><th>Name</th><th>Username</th><th>Title</th><th>Price</th><th>End Date</th><th>Start Date</th><th>Start Time</th><th>End Time</th><th>Action</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["course_id"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["username"] . "</td>";
            echo "<td>" . $row["title"] . "</td>";
            echo "<td>" . $row["price"] . "</td>";
            echo "<td>" . $row["end_date"] . "</td>";
            echo "<td>" . $row["start_date"] . "</td>";
            echo "<td>" . $row["start_time"] . "</td>";
            echo "<td>" . $row["end_time"] . "</td>";
            echo "<td>";
            echo "<a href='payment_trainer.php?id=" . $row['id'] . "' class='transfer-btn'>โอนเงิน</a>";
            echo "<a href='reject_payment.php?id=" . $row['id'] . "' class='reject-btn' style='background-color: #CC0000;'>ปฏิเสธ</a>";
            echo "</td>"; 
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "ไม่พบข้อมูลในตาราง";
    }
    $conn->close();
    ?>
</div>
</body>
</html>
