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

if (isset($_POST["history_id"]) && isset($_POST["report_text"])) {
    $historyId = $_POST["history_id"];
    $reporterUsername = $_SESSION["username"];
    $reportText = $_POST["report_text"];
    $sql = "INSERT INTO reports (history_id, reporter_username, report_text) VALUES ('$historyId', '$reporterUsername', '$reportText')";

    if ($conn->query($sql) === TRUE) {
        echo 'บันทึกข้อมูลรายงานเรียบร้อยแล้ว';
    } else {
        echo 'เกิดข้อผิดพลาดในการบันทึกข้อมูลรายงาน: ' . $conn->error;
    }
}
?>
