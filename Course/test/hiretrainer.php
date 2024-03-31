<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hire Trainer</title>

    <style>
       
    </style>
</head>
<body>
    <h1>จ้างเทรนเนอร์</h1>
    <form method="post" action="process_hire.php">
        <input type="hidden" name="course_id" value="<?php echo $row['id']; ?>">
        <label for="date">เลือกวันที่:</label>
        <input type="date" id="date" name="date" required>
        <button type="submit">ส่งข้อมูลการจ้างเทรนเนอร์</button>
    </form>
</body>
</html>