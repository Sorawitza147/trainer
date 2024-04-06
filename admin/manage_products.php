<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการคอร์ส</title>
    <style>
        table {
            width: 65%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .container {
            width: 80%;
            margin: auto;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>จัดการคอร์ส</h2>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "trainer";
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
    }

   
    if (isset($_GET['delete_course_id'])) {
        $delete_course_id = $_GET['delete_course_id'];
        
        
        $sql_delete_course_activities = "DELETE FROM course_activities WHERE course_id = ?";
        if ($stmt_delete_course_activities = $conn->prepare($sql_delete_course_activities)) {
            $stmt_delete_course_activities->bind_param("i", $delete_course_id);
            if ($stmt_delete_course_activities->execute()) {
                $stmt_delete_course_activities->close();
                
             
                $sql_delete_course = "DELETE FROM courses WHERE course_id = ?";
                if ($stmt_delete_course = $conn->prepare($sql_delete_course)) {
                    $stmt_delete_course->bind_param("i", $delete_course_id);
                    if ($stmt_delete_course->execute()) {
                        echo "ข้อมูลผู้ใช้ถูกอัปเดตเรียบร้อยแล้ว";
                         echo "<script>window.location.href = 'admin_dashboard.php';</script>";
                    } else {
                        echo "เกิดข้อผิดพลาดในการลบข้อมูล course: " . $conn->error;
                    }
                    $stmt_delete_course->close();
                } else {
                    echo "เกิดข้อผิดพลาดในการลบข้อมูล course: " . $conn->error;
                }
            } else {
                echo "เกิดข้อผิดพลาดในการลบข้อมูล course_activities: " . $conn->error;
            }
        } else {
            echo "เกิดข้อผิดพลาดในการลบข้อมูล course_activities: " . $conn->error;
        }
    }
 
    $sql_course = "SELECT * FROM courses";
    $result_course = $conn->query($sql_course);


    if ($result_course->num_rows > 0) {
   
        echo "<table>";
        echo "<tr>";
        echo "<th>Course Id</th>";
        echo "<th>ชื่อคอร์ส</th>";
        echo "<th>รายละเอียด</th>";
        echo "<th>ราคา</th>";
        echo "<th>การจัดการ</th>";
        echo "</tr>";

        while ($row_course = $result_course->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row_course["course_id"] . "</td>";
            echo "<td>" . $row_course["title"] . "</td>";
            echo "<td>" . $row_course["description"] . "</td>";
            echo "<td>" . $row_course["price"] . "</td>";
            echo "<td><a href='edit_course.php?id=" . $row_course["course_id"] . "'>แก้ไข</a> | <a href='manage_products.php?delete_course_id=" . $row_course["course_id"] . "'>ลบ</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>ไม่พบข้อมูล courses</p>";
    }

    $conn->close();
    ?>
</div>
<script>
    function deleteCourse(courseId) {
        if (confirm("คุณต้องการลบคอร์สนี้หรือไม่?")) {
            window.location.href = 'manage_products.php?delete_course_id=' + courseId;
        }
    }
</script>
</body>
</html>
