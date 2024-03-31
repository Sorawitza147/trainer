<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trainer";

if(isset($_GET['user_id'])) {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM user WHERE id=" . $_GET['user_id'];

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        
        header('Location: admin_dashboard.php');
        exit;
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $conn->close();
} else {
    echo "No user ID specified.";
}
?>
