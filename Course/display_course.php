<?php
$conn = mysqli_connect('localhost', 'root', '', 'trainer');

if(isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    
    $sql = "SELECT * FROM courses WHERE course_id = $course_id";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $row["title"]; ?></title>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Mitr", sans-serif;
}
.container {
    max-width: 800px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
}

h2 {
    color: #333;
    margin-top: 0;
}

img {
    max-width: 100%;
    height: auto;
    margin-bottom: 20px;
    border-radius: 10px;
}

p {
    margin-bottom: 10px;
}

.back-button {
    align-self: flex-end;
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    margin-bottom: 20px;
}

.back-button:hover {
    background-color: #0056b3;
}
</style>
</head>
<body>

<div class="container">
    <a href='../Course/Hire.php' class='back-button'>ย้อนกลับ</a>
    <h2><?php echo $row["title"]; ?></h2>
    <img src="uploadscourse/<?php echo $row["cover_image"]; ?>">
    <p>ชื่อเทรนเนอร์: <?php echo $row["name"]; ?></p>
    <p>อีเมล์: <?php echo $row["email"]; ?></p>
    <p>เพศของเทรนเนอร์: <?php echo $row["gender"]; ?></p>
    <p>อายุของเทรนเนอร์: <?php echo $row["age"]; ?></p>
    <p>เบอร์โทร: <?php echo $row["phone_number"]; ?></p>
    <p>รายละเอียด: <?php echo $row["description"]; ?></p>
    <p>฿: <?php echo $row["price"]; ?></p>
    <?php
    $start_date_thai = date("j F Y", strtotime($row["start_date"]));
    $end_date_thai = date("j F Y", strtotime($row["end_date"]));
    echo "<p>วันเริ่ม: $start_date_thai</p>";
    echo "<p>ถึง: $end_date_thai</p>";
    echo "<p>เวลา: " . $row["start_time"] . "</p>";
    echo "<p>ถึง: " . $row["end_time"] . "</p>";
    ?>
</div>

</body>
</html>

<?php
    } else {
        echo "ไม่พบข้อมูลคอร์ส";
    }
    
    mysqli_close($conn);
} else {
    echo "ไม่ได้รับค่า course_id ผ่านทาง URL";
}
?>