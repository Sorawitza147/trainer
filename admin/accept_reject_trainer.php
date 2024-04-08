<script>
    function redirectToPreviousPage() {
        var result = confirm("คุณต้องการที่จะกลับไปยังหน้าที่แล้วใช่หรือไม่?");
        if (result) {
            window.history.back(); 
        } else {
        }
    }
</script>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "trainer";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

if(isset($_POST['accept'])) {
    $trainer_id = $_POST['trainer_id'];

   
    if (!empty($trainer_id)) {
        $sql_select = "SELECT * FROM trainer_signup WHERE trainer_id = ?";
        $stmt = $conn->prepare($sql_select);
        $stmt->bind_param("i", $trainer_id);
        $stmt->execute();
        $result_select = $stmt->get_result();

        if ($result_select->num_rows > 0) {
            $row = $result_select->fetch_assoc();

            $stmt_insert = $conn->prepare("INSERT INTO accepted_trainers (trainerusername, password, first_name, last_name, emailtrainer, age, gender, phone_number, level_2, start_year_2, end_year_2, level_3, start_year_3, end_year_3, level_4, start_year_4, end_year_4, level_5, start_year_5, end_year_5, level_6, start_year_6, end_year_6, district, subdistrict, image_profile, image, bank, account_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            if ($stmt_insert === false) {
                die("Error preparing statement: " . $conn->error);
            }

            if (!$stmt_insert->bind_param("sssssssssiisiisiisiisiissssss", $row['trainerusername'], $row['password'], $row['first_name'], $row['last_name'], $row['emailtrainer'], $row['age'], $row['gender'], $row['phone_number'], $row['level_2'], $row['start_year_2'], $row['end_year_2'], $row['level_3'], $row['start_year_3'], $row['end_year_3'], $row['level_4'], $row['start_year_4'], $row['end_year_4'], $row['level_5'], $row['start_year_5'], $row['end_year_5'], $row['level_6'], $row['start_year_6'], $row['end_year_6'], $row['district'], $row['subdistrict'], $row['image_profile'], $row['image'], $row['bank'], $row['account_number'])) {
                die("Error binding parameters: " . $stmt_insert->error);
            }
            
            if (!$stmt_insert->execute()) {
                die("Error executing statement: " . $stmt_insert->error);
            }

            $sql_delete = "DELETE FROM trainer_signup WHERE trainer_id = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("i", $trainer_id);
            if ($stmt_delete->execute()) {
                echo "<script>
                        if(confirm('เทรนเนอร์ได้ถูกยอมรับและเพิ่มเข้าสู่รายชื่อเรียบร้อยแล้ว')){
                            window.location.href = 'admin_dashboard.php';
                        }
                      </script>";
            } else {
                echo "การลบเทรนเนอร์ที่เลือกผิดพลาด: " . $conn->error;
            }
        } else {
            echo "ไม่พบข้อมูลเทรนเนอร์ที่เลือก";
        }
    } else {
        echo "ไม่มีค่า trainer_id ที่ถูกส่งมา";
    }
} elseif(isset($_POST['reject'])) {
    $trainer_id = $_POST['trainer_id'];

    if (!empty($trainer_id)) {
        $sql_delete = "DELETE FROM trainer_signup WHERE trainer_id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $trainer_id);
        if ($stmt_delete->execute()) {
            echo "<script>
                    if(confirm('เทรนเนอร์ได้ถูกปฏิเสธและลบออกจากรายชื่อเรียบร้อยแล้ว')){
                        window.location.href = 'admin_dashboard.php';
                    }
                  </script>";
        } else {
            echo "การลบเทรนเนอร์ที่เลือกผิดพลาด: " . $conn->error;
        }
    } else {
        echo "ไม่มีค่า trainer_id ที่ถูกส่งมา";
    }
}

$conn->close();
?>