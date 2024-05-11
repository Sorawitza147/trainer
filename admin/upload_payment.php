<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Web Page</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Mitr", sans-serif;
        }
    </style>
</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "trainer";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if ($_FILES["payment_image"]["error"] == 0) {
        $title = $_POST['title'];
        $price = $_POST['price'];
        $trainerusername = $_POST['trainerusername'];
        $target_dir = "uploadspaymenttrainer/";
        $target_file = $target_dir . basename($_FILES["payment_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
        if (in_array($imageFileType, array("jpg", "png", "jpeg", "gif"))) {
            if (move_uploaded_file($_FILES["payment_image"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO payment_info (title, price, trainerusername, image_path) VALUES ('$title', '$price', '$trainerusername', '$target_file')";
                if ($conn->query($sql) === TRUE) {
                    if (isset($_POST['id_payment'])) {
                        $id_payment = $_POST['id_payment'];
                        $update_payment_status_sql = "UPDATE payment_trainer SET status_payment = 'โอนเงินสำเร็จ' WHERE id_payment = '$id_payment'";
                        if ($conn->query($update_payment_status_sql) === TRUE) {
                            $delete_finish_course_sql = "DELETE FROM finish_course  WHERE id_payment = '$id_payment'";
                            if ($conn->query($delete_finish_course_sql) === TRUE) {
                                echo "<script>
                                    function showRegisterSuccess() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'โอนเงินสำเร็จ',
                                        confirmButtonText: 'ตกลง'
                                    }).then(() => {
                                        window.location.href = 'admin_dashboard.php';
                                    });
                                    }
                                    showRegisterSuccess(); // เรียกใช้ฟังก์ชันเพื่อแสดงหน้าต่างแจ้งเตือน
                                </script>";
                            } else {
                                echo "Error deleting record: " . $conn->error;
                            }
                        } else {
                            echo "Error updating payment status: " . $conn->error;
                        }
                    } else {
                        echo "ไม่พบ ID การชำระเงิน";
                    }
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "ขอโทษ, เกิดข้อผิดพลาดในการอัพโหลดไฟล์.";
            }
        } else {
            echo "ขอโทษ, ไฟล์ที่อัพโหลดต้องเป็นรูปภาพเท่านั้น.";
        }
    } else {
        echo "ขอโทษ, เกิดข้อผิดพลาดในการอัพโหลดไฟล์: " . $_FILES["payment_image"]["error"];
    }    
}
$conn->close();
?>
</body>
</html>