<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "trainer";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO courses (title, description, price, duration, cover_image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssids", $title, $description, $price, $duration, $cover_image);

    // Get form data
    $title = $_POST["title"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $duration = $_POST["duration"];

    // File upload handling
    $target_dir = "uploadscourse/";
    $target_file = $target_dir . basename($_FILES["cover_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["cover_image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["cover_image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["cover_image"]["name"]). " has been uploaded.";
            $cover_image = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Execute the SQL statement
    if ($stmt->execute() === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;  
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>