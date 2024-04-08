<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รีวิวคอร์ส</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
    .rating {
        unicode-bidi: normal;
        direction: rtl;
        text-align: left;
    }
    .rating input {
        display: none;
    }
    .rating label {
        cursor: pointer;
        display: inline-block;
        padding: 0 1px;
        font-size: 50px; /* ปรับขนาดของดาว */
        color: #DCDCDC; /* สีของดาวเริ่มต้น (สีขาว) */
    }
    .rating label:before {
        content: '\2605'; /* รหัส Unicode ของรูปทรงดาว */
    }
    .rating input:checked ~ label:before {
        color: #00CCFF; /* สีของดาวเมื่อถูกเลือก (สีฟ้า) */
    }
    .rating label:hover:before,
    .rating label:hover ~ label:before {
        color: #00CCFF; /* สีของดาวเมื่อเมาส์ชี้ไปที่ดาว */
    }
    .btn{
        margin-top: 10px;
    }
</style>
</head>
<body>
    <div class="container">
        <h2>รีวิวคอร์ส</h2>
        <?php
        session_name("user_session");
        session_start();

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbName = "trainer";

        $conn = new mysqli($servername, $username, $password, $dbName);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                $sql_course = "SELECT * FROM course_history_trainer WHERE id = '$id'";
                $result_course = $conn->query($sql_course);

                if ($result_course->num_rows > 0) {
                    $row = $result_course->fetch_assoc();
                    // แสดงรายละเอียดคอร์ส
                    echo "<p><strong>ชื่อคอร์ส:</strong> " . $row["title"] . "</p>";
                    echo "<p><strong>รายละเอียด:</strong> " . $row["description"] . "</p>";
                    // แบบฟอร์มรีวิว
                    echo "<form action='submit_review.php' method='POST'>";
                    echo "<input type='hidden' name='course_id' value='" . $row["course_id"] . "'>";
                    echo "<input type='hidden' name='username' value='" . $_SESSION["username"] . "'>";
                    echo "<input type='hidden' name='trainer_id' value='" . $row["trainer_id"] . "'>";
                    echo "<input type='hidden' name='history_id' value='" . $id . "'>";
                    echo "<div class='form-group'>";
                    echo "<label for='rating'>คะแนน:</label>";
                    echo "<div class='rating'>";
                    echo "<input type='radio' id='star5' name='rating' value='5' required><label for='star5' title='5 stars'></label>";
                    echo "<input type='radio' id='star4' name='rating' value='4'><label for='star4' title='4 stars'></label>";
                    echo "<input type='radio' id='star3' name='rating' value='3'><label for='star3' title='3 stars'></label>";
                    echo "<input type='radio' id='star2' name='rating' value='2'><label for='star2' title='2 stars'></label>";
                    echo "<input type='radio' id='star1' name='rating' value='1'><label for='star1' title='1 star'></label>";
                    echo "</div>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label for='review'>รีวิว:</label>";
                    echo "<textarea class='form-control' name='review' id='review' rows='3' required></textarea>";
                    echo "</div>";
                    echo "<button type='submit' class='btn btn-primary btn-lg' style='margin-top: 20px;'>ส่งรีวิว</button";
                    echo "</form>";
                } else {
                    echo "<div class='error-message'>ไม่พบข้อมูลคอร์ส</div>";
                }
            } else {
                echo "<div class='error-message'>ไม่พบรหัสบันทึก</div>";
            }
        } else {
            echo "<div class='error-message'>คุณต้องเข้าสู่ระบบก่อนที่จะสามารถรีวิวคอร์สได้</div>";
        }
        ?>
    </div>
</body>
</html>
