<?php
// เชื่อมต่อกับฐานข้อมูล
$conn = mysqli_connect('localhost', 'root', '', 'trainer');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// สร้างคำสั่ง SQL เพื่อดึงข้อมูลจากตาราง payment_refund
$sql = "SELECT * FROM payment_refund_trainer";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 65%;
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
        .upload-form {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h2>Refund Information</h2>

<table>
    <thead>
        <tr>
            <th>ไอดีคอร์ส</th>
            <th>Username</th>
            <th>Title</th>
            <th>Price</th>
            <th>Action</th>         </tr>
    </thead>
    <tbody>
        <?php
        // ตรวจสอบว่ามีข้อมูลในผลลัพธ์หรือไม่
        if (mysqli_num_rows($result) > 0) {
            // วนลูปเพื่อแสดงข้อมูลที่ได้จากการคืนเงิน
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["course_id"] . "</td>";
                echo "<td>" . $row["username"] . "</td>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . number_format($row["price"], 2) . "</td>"; // แสดงราคาในรูปแบบทศนิยม 2 ตำแหน่ง
                echo "<td><a href='refund_action.php?id=" . $row["id"] . "'>Refund</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No refund information available</td></tr>";
        }
        ?>
    </tbody>
    </table>
</body>
</html>

<?php
// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>
