<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/booking.css">
    <title>Booking Form</title>
</head>
<body>
    <h2>Booking Form</h2>
    <form action="process_booking.php" method="post">
        <?php
        if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
            echo '<label for="user_name">Your Name:</label><br>';
            echo '<input type="text" id="user_name" name="user_name" value="' . (isset($_SESSION['name']) ? $_SESSION['name'] : '') . '" required><br>';
        }
        ?>
        
        <label for="cafe_name">Select Cafe:</label><br>
        <select id="cafe_name" name="cafe_name" required>
            <option value="">Select Cafe</option>
            <?php
            include('config.php');
            $sql = "SELECT cafe_name FROM cafes";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $selected = ($_POST['cafe_name'] == $row['cafe_name']) ? 'selected' : '';
                    echo "<option value='".$row['cafe_name']."' $selected>".$row['cafe_name']."</option>";
                }
            }
            ?>
        </select><br>

        <label for="booking_date">Booking Date:</label><br>
        <input type="date" id="booking_date" name="booking_date" min="<?php echo date('Y-m-d'); ?>" required><br>

        <label for="booking_time">Booking Time:</label><br>
        <select id="booking_time" name="booking_time">
            <option value="รอบ 8:30 - 10:00">รอบ 8:30 - 10:00</option>
            <option value="รอบ 12:00 - 13:30">รอบ 12:00 - 13:30</option>
            <option value="รอบ 15:30 - 17:00">รอบ 15:30 - 17:00</option>
        </select><br><br>

        <input type="submit" value="Book">
    </form>

    <script>
        window.onload = function() {
            var urlParams = new URLSearchParams(window.location.search);
            var cafe_name = urlParams.get('cafe_name');
            var user_name = "<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>";
            if (cafe_name) {
                var selectCafe = document.getElementById("cafe_name");
                for (var i = 0; i < selectCafe.options.length; i++) {
                    if (selectCafe.options[i].value === cafe_name) {
                        selectCafe.selectedIndex = i;
                        break;
                    }
                }
            }
            document.getElementById("user_name").value = user_name;
        }
    </script>
</body>
</html>
