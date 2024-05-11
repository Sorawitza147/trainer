<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "trainer";
$conn = new mysqli($servername, $username, $password, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$trainerId = $_GET['trainer_id'];
if (!isset($trainerId) || empty(trim($trainerId))) {
    $sqlReviews = "SELECT reviews.*, accepted_trainers.first_name, accepted_trainers.last_name 
                   FROM reviews 
                   LEFT JOIN accepted_trainers ON reviews.trainer_id = accepted_trainers.trainer_id";
} else {
    $sqlReviews = "SELECT reviews.*, accepted_trainers.first_name, accepted_trainers.last_name 
                   FROM reviews 
                   LEFT JOIN accepted_trainers ON reviews.trainer_id = accepted_trainers.trainer_id 
                   WHERE reviews.trainer_id = '$trainerId'";
}

$resultReviews = $conn->query($sqlReviews);
if ($resultReviews->num_rows > 0) {
    while ($rowReview = $resultReviews->fetch_assoc()) {
        echo "<div class='col-md-4'>";
        echo "<div class='card'>";
        echo "<div class='card-body'>";
        echo "<p class='card-text'>รีวิว: " . $rowReview["review"] . "</p>";
        echo "<p class='card-text'>เรทติ้ง: " . $rowReview["rating"] . "</p>";
        echo "<p class='card-text'>ไอดีของเทรนเนอร์: " . $rowReview["trainer_id"] . "</p>";
        echo "<p class='card-text'>ชื่อเทรนเนอร์: " . $rowReview["first_name"] . " " . $rowReview["last_name"] . "</p>";
        echo "<p class='card-text'>ชื่อผู้ออกกำลังการที่รีวิว: " . $rowReview["username"] . "</p>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "No reviews available.";
}
$conn->close();
?>
