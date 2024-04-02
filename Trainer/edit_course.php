<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขคอร์ส</title>
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
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .back-button {
    position: absolute;
    top: 20px;
    right: 20px;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
    text-transform: uppercase;
    font-weight: bold;
    background-color: #00CCFF;
    color: #fff;
}

.back-button:hover {
    background-color: #999;
}
    </style>
</head>
<body>
<div class="container">
    <h2>แก้ไขคอร์ส</h2>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "trainer";
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
    }

    if (isset($_GET['id'])) {
        $course_id = $_GET['id'];

        $sql_course = "SELECT * FROM courses WHERE course_id = $course_id";
        $result_course = $conn->query($sql_course);

        if ($result_course->num_rows > 0) {
            $row_course = $result_course->fetch_assoc();
    ?>
            <form action="update_course.php" method="POST">
                <a href='viewcourse.php' class='back-button'>ย้อนกลับ</a>
                <input type="hidden" name="course_id" value="<?php echo $row_course['course_id']; ?>">
                <label for="title">ชื่อคอร์ส:</label>
                <input type="text" id="title" name="title" value="<?php echo $row_course['title']; ?>"><br>
                <label for="duration">ระยะเวลา (สัปดาห์):</label>
                <input type="number" id="duration" name="duration" min="1" required value="<?php echo $row_course['duration']; ?>"><br>
                <label for="price">ราคา:</label>
                <input type="text" id="price" name="price" value="<?php echo $row_course['price']; ?>"><br>
                <label for="difficulty">ความยาก:</label>
                <select id="difficulty" name="difficulty" required>
                    <option value="very_easy" <?php if ($row_course['difficulty'] == 'very_easy') echo 'selected'; ?>>ง่ายสุด</option>
                    <option value="easy" <?php if ($row_course['difficulty'] == 'easy') echo 'selected'; ?>>ง่าย</option>
                    <option value="medium" <?php if ($row_course['difficulty'] == 'medium') echo 'selected'; ?>>ปานกลาง</option>
                    <option value="hard" <?php if ($row_course['difficulty'] == 'hard') echo 'selected'; ?>>ยาก</option>
                    <option value="very_hard" <?php if ($row_course['difficulty'] == 'very_hard') echo 'selected'; ?>>ยากที่สุด</option>
                </select><br>
                <label for="description">คำอธิบาย:</label>
                <textarea id="description" name="description"><?php echo $row_course['description']; ?></textarea><br>
                <input type="submit" value="บันทึก">
            </form>
    <?php
        } else {
            echo "ไม่พบข้อมูลคอร์ส";
        }
    } else {
        echo "ไม่ได้ระบุ ID ของคอร์ส";
    }
    $conn->close();
    ?>
</div>
</body>
</html>
