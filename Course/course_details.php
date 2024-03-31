<?php

$courseId = $_GET['id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trainer";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT c.id AS course_id, c.name AS course_name, c.email AS course_email, 
        c.age AS course_age, c.gender AS course_gender, c.phone_number AS course_phone_number,
        c.title AS course_title, c.price AS course_price, c.duration AS course_duration,
        c.difficulty AS course_difficulty, c.description AS course_description,
        c.cover_image AS course_cover_image, c.created_at AS course_created_at, c.updated_at AS course_updated_at
        FROM courses c
        WHERE c.id = $courseId";

$result = mysqli_query($conn, $sql);

if (!$result) {
  die("Error retrieving course details: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

if (!$row) {
  echo "<p>Course not found.</p>";
  exit;
}

$course_id = $row["course_id"];
$course_name = $row["course_name"];
$course_email = $row["course_email"];
$course_age = $row["course_age"];
$course_gender = $row["course_gender"];
$course_phone_number = $row["course_phone_number"]; 
$course_title = $row["course_title"];
$course_price = $row["course_price"];
$course_duration = $row["course_duration"];
$course_difficulty = $row["course_difficulty"];
$course_description = $row["course_description"];
$course_cover_image = $row["course_cover_image"];
$course_created_at = $row["course_created_at"];
$course_updated_at = $row["course_updated_at"];

echo "<h1>$course_title</h1>";
echo "<img src='$course_cover_image' alt='$course_title image'>";
echo "<p><b>Price:</b> &dollar;$course_price</p>";
echo "<p><b>Duration:</b> $course_duration weeks</p>";
echo "<p><b>Difficulty:</b> $course_difficulty</p>";
echo "<p><b>Description:</b> $course_description</p>";

mysqli_close($conn);

?>