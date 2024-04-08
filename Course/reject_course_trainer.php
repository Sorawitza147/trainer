<?php
$conn = new mysqli("localhost", "root", "", "trainer");

if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

if (isset($_GET['reject_course_id'])) {
    $trainer_id = $_GET['reject_course_id']; 
    $course_id = $_GET['course_id']; 


    if (isset($_GET['bank']) && isset($_GET['account_number'])) {
        $bank = $_GET['bank'];
        $account_number = $_GET['account_number'];
        $sql = "SELECT courses.*, hired_trainers.username, hired_trainers.payment_status
            FROM courses
            INNER JOIN hired_trainers ON courses.course_id = hired_trainers.course_id
            WHERE hired_trainers.id = '$trainer_id'"; 

        $result_course = $conn->query($sql);

        if ($result_course->num_rows > 0) {
            $row_course = $result_course->fetch_assoc();

            if ($row_course['payment_status'] == 'ชำระเงินสำเร็จ') {
                
                $insert_sql = "INSERT INTO payment_refund_trainer (course_id, username, title, price, bank, account_number) 
                            VALUES ('$course_id', '{$row_course['username']}', '{$row_course['title']}', '{$row_course['price']}', '$bank', '$account_number')";
                
                if ($conn->query($insert_sql) === TRUE) {
                    echo "บันทึกการคืนเงินเรียบร้อยแล้ว";
                    $delete_sql = "DELETE FROM hired_trainers WHERE id='$trainer_id'";
                    if ($conn->query($delete_sql) === TRUE) {
                        echo " และลบข้อมูลผู้สอนที่ถูก reject เรียบร้อยแล้ว";
                    } else {
                        echo " แต่มีข้อผิดพลาดในการลบข้อมูลผู้สอนที่ถูก reject: " . $conn->error;
                    }
                } else {
                    echo "มีข้อผิดพลาดในการบันทึกข้อมูลการคืนเงิน: " . $conn->error;
                }
            } else {
                $delete_sql = "DELETE FROM hired_trainers WHERE id='$trainer_id'";
                if ($conn->query($delete_sql) === TRUE) {
                    echo "ลบข้อมูลเรียบร้อยแล้ว เนื่องจากไม่มีการชำระเงิน";
                } else {
                    echo "มีข้อผิดพลาดในการลบข้อมูล: " . $conn->error;
                }
            }
        } else {
            echo "ไม่พบข้อมูลคอร์สที่ต้องการ reject";
        }
    } else {
        echo "ข้อมูล 'bank' หรือ 'account_number' ไม่ถูกส่งมา";
    }
} else {
    echo "ไม่พบข้อมูลที่ต้องการ";
}
$conn->close();
?> 
