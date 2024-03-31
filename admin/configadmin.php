<?php
session_start();

if(isset($_POST['username']) && isset($_POST['password'])) {

    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $database = "trainer"; 
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
    }


    $username = $_POST['username'];
    $password = $_POST['password'];

   
    $sql = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $username;
        
        echo "<h2>ข้อมูลจากตาราง Admins</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Username</th><th>Password</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["username"] . "</td>";
            echo "<td>" . $row["password"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {

        echo "ไม่พบข้อมูลในตาราง admins หรือ username และ password ไม่ถูกต้อง";
    }

    $conn->close();
} else {
    
    echo "กรุณากรอก username และ password";
}
?>
