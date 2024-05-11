<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trainer";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_name("user_session");
session_start();
$username = $_SESSION['username'];
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM payment_refund_admin WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
