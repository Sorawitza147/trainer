<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Course</title>
<style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

.container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: bold;
}

input[type="text"],
input[type="number"],
textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

textarea {
    resize: vertical;
}

button[type="submit"] {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

</style>
</head>
<body>
<div class="container">
    <h1>Create Your Course</h1>
    <form action="process_course.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Course Name:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" min="0" step="any" required>
        </div>
        <div class="form-group">
            <label for="duration">Duration (in weeks):</label>
            <input type="number" id="duration" name="duration" min="1" required>
        </div>
        <div class="form-group">
            <label for="cover_image">Cover Image:</label>
            <input type="file" id="cover_image" name="cover_image" accept="image/*" required>
        </div>
        <input type="hidden" id="course_status_hidden" name="course_status" value="<?php echo isset($_POST['course_status']) ? $_POST['course_status'] : 'ไม่มีคนจ้าง'; ?>">
        <button type="submit">Create Course</button>
    </form>
</div>
</body>
</html>
