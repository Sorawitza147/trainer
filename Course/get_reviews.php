<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "trainer";
$conn = new mysqli($servername, $username, $password, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the trainer_id from the AJAX request
$trainerId = $_GET['trainer_id'];

// Check if trainer_id is provided, if not, query all reviews
if (!isset($trainerId) || empty(trim($trainerId))) {
    // Query to fetch all reviews
    $sqlReviews = "SELECT reviews.*, accepted_trainers.first_name, accepted_trainers.last_name 
                   FROM reviews 
                   LEFT JOIN accepted_trainers ON reviews.trainer_id = accepted_trainers.trainer_id";
} else {
    // Query to fetch reviews for the selected trainer
    $sqlReviews = "SELECT reviews.*, accepted_trainers.first_name, accepted_trainers.last_name 
                   FROM reviews 
                   LEFT JOIN accepted_trainers ON reviews.trainer_id = accepted_trainers.trainer_id 
                   WHERE reviews.trainer_id = '$trainerId'";
}

$resultReviews = $conn->query($sqlReviews);

// Check if there are any reviews
if ($resultReviews->num_rows > 0) {
    // Output reviews
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
    // If no reviews are found
    echo "No reviews available.";
}

// Close the database connection
$conn->close();
?>
