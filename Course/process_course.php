<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "trainer";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$phone_number = $_POST['phone_number'];
$trainer_id = $_POST['trainer_id'];
$trainerusername = $_POST['trainerusername'];
$title = $_POST['title'];
$price = $_POST['price'];
$duration = $_POST['duration'];
$difficulty = $_POST['difficulty'];
$description = $_POST['description'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$cover_image = $_FILES['cover_image']['name'];
$tmp_name = $_FILES['cover_image']['tmp_name'];
$upload_dir = 'uploadscourse/';

if ($cover_image) {
    move_uploaded_file($tmp_name, $upload_dir . $cover_image);
} else {
    $cover_image = 'default.jpg';
}

// Insert data into 'courses' table
$sql = "INSERT INTO courses (name, email, gender, age, phone_number, trainer_id, trainerusername, title, price, duration, difficulty, description, start_date, end_date, start_time, end_time, cover_image)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Error: " . $conn->error;
    exit();
}

$stmt->bind_param('sssissssissssssss', $name, $email, $gender, $age, $phone_number, $trainer_id, $trainerusername, $title, $price, $duration, $difficulty, $description, $start_date, $end_date, $start_time, $end_time, $cover_image);
$stmt->execute();

$course_id = $stmt->insert_id;

// Check if any activities are selected
if (isset($_POST['activity']) && is_array($_POST['activity'])) {
    foreach ($_POST['activity'] as $activity_id) {
        // Insert selected activities into 'course_activities' table
        $sql3 = "INSERT INTO course_activities (course_id, activity_id) VALUES (?, ?)";
        $stmt3 = $conn->prepare($sql3);

        if (!$stmt3) {
            echo "Error: " . $conn->error;
            exit();
        }

        $stmt3->bind_param('ii', $course_id, $activity_id); 
        $stmt3->execute();
    }
} else {
    echo "<script>alert('กรุณาเลือกกิจกรรมที่เกี่ยวข้องกับคอร์ส');</script>";
}

// Display success message and redirect after 3 seconds
echo "<script>
    window.onload = function() {
        var welcomeMessage = 'สร้างคอร์สสำเร็จ';
        var popup = document.createElement('div');
        popup.innerHTML = welcomeMessage;
        popup.style.backgroundColor = '#ffffff';
        popup.style.border = '1px solid #cccccc';
        popup.style.padding = '40px'; 
        popup.style.width = '600px'; 
        popup.style.height = '500px'; 
        popup.style.textAlign = 'center'; 
        popup.style.lineHeight = '1.5'; 
        popup.style.borderRadius = '20px'; 
        popup.style.boxShadow = '0px 0px 20px rgba(0, 0, 0, 0.3)'; 
        popup.style.position = 'fixed';
        popup.style.top = '50%';
        popup.style.left = '50%';
        popup.style.transform = 'translate(-50%, -50%)';
        popup.style.zIndex = '9999';
        popup.style.fontSize = '54px'; 
        document.body.appendChild(popup);

        setTimeout(function() {
            popup.remove();
            window.location.href = 'course.php';
        }, 3000);
    };
</script>";
?>
