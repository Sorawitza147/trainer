<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บันทึกเหตุผลและลบข้อมูล</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>บันทึกเหตุผลและลบข้อมูล</h2>
        <?php
        // เชื่อมต่อกับฐานข้อมูล
        $conn = new mysqli("localhost", "root", "", "trainer");

        // ตรวจสอบการเชื่อมต่อ
        if ($conn->connect_error) {
            die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
        }

        // ตรวจสอบว่ามีการส่งค่าไอดีมาหรือไม่ และตรวจสอบว่าไม่ใช่ค่าว่าง
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = $_GET['id'];

            // ตรวจสอบว่ามีการส่งค่า reason มาหรือไม่ และตรวจสอบว่าไม่ใช่ค่าว่าง
            if (isset($_POST['reason']) && !empty($_POST['reason'])) {
                $reason = $_POST['reason'];

                // ใช้ prepared statements เพื่อป้องกัน SQL injection
                $stmt = $conn->prepare("UPDATE payment_trainer SET status_payment = 'ปฏิเสธ', reason = ? WHERE id = ?");
                
                // ตรวจสอบว่า prepared statement สามารถเตรียมได้หรือไม่
                if ($stmt) {
                    // ผูกค่า parameter
                    $stmt->bind_param("si", $reason, $id);

                    // ประมวลผล prepared statement
                    if ($stmt->execute()) {
                        echo "<script>
                            Swal.fire({
                                icon: 'success',
                                title: 'บันทึกเหตุผลและยกเลิกสำเร็จ',
                                confirmButtonText: 'ตกลง'
                            }).then(() => {
                                window.location.href = 'admin_dashboard.php';
                            });
                        </script>";
                        // ลบข้อมูลจากตาราง finish_course
                        $delete_stmt = $conn->prepare("DELETE FROM finish_course WHERE id = ?");
                        if ($delete_stmt) {
                            // ผูกค่า parameter
                            $delete_stmt->bind_param("i", $id);
                            
                            // ประมวลผล prepared statement
                            if ($delete_stmt->execute()) {
                                // ลบข้อมูลเรียบร้อย
                            } else {
                                // มีข้อผิดพลาดในการลบข้อมูล
                                echo "<p>มีข้อผิดพลาดในการลบข้อมูลจากตาราง finish_course: " . $delete_stmt->error . "</p>";
                            }

                            // ปิด prepared statement
                            $delete_stmt->close();
                        } else {
                            // มีข้อผิดพลาดในการเตรียมคำสั่ง SQL
                            echo "<p>มีข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $conn->error . "</p>";
                        }
                    } else {
                        echo "<p>มีข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error . "</p>";
                    }

                    // ปิด prepared statement
                    $stmt->close();
                } else {
                    echo "<p>มีข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $conn->error . "</p>";
                }
            }

            // ใช้ prepared statements เพื่อป้องกัน SQL injection
            $stmt = $conn->prepare("SELECT * FROM finish_course WHERE id = ?");
            
            // ตรวจสอบว่า prepared statement สามารถเตรียมได้หรือไม่
            if ($stmt) {
                // ผูกค่า parameter
                $stmt->bind_param("i", $id);

                // ประมวลผล prepared statement
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        // แสดงข้อมูลเกี่ยวกับเทรนเนอร์และคอร์สที่เกี่ยวข้องกับไอดีที่ได้รับมา
                        echo "<table>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr><td>ชื่อเทรนเนอร์:</td><td>". $row["name"]. "</td></tr>";
                            echo "<tr><td>ชื่อคอร์ส:</td><td>". $row["title"]. "</td></tr>";
                        }
                        echo "</table>";
                        // แสดงฟอร์มสำหรับกรอกเหตุผล
                        echo "<form method='post'>";
                        echo "<input type='text' name='reason' placeholder='กรุณากรอกเหตุผล'>";
                        echo "<input type='submit' value='บันทึก'>";
                        echo "</form>";
                    } else {
                        echo "<p>ไม่พบข้อมูลสำหรับไอดีที่ระบุ</p>";
                    }
                } else {
                    echo "<p>มีข้อผิดพลาดในการดึงข้อมูล: " . $conn->error . "</p>";
                }

                // ปิด prepared statement
                $stmt->close();
            } else {
                echo "<p>มีข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>ข้อมูลไม่ครบถ้วน</p>";
        }

        // ปิดการเชื่อมต่อฐานข้อมูล
        $conn->close();
        ?>
    </div>
</body>
</html>
