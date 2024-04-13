<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ดู Reviews</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Mitr", sans-serif;
        }
        .container{
            margin-top: 16px;
        }
        .card {
            margin-bottom: 20px;
        }
        .card-title {
            font-size: 1.25rem;
            color: #333;
            margin-bottom: 10px;
        }
        .card-text {
            color: #666;
            margin-bottom: 5px;
        }
    </style>
</head>
<body onload="getReviews()">
    <div class="container">
        <h2>รีวิวทั้งหมด</h2>
        <div>
            <label for="trainerSelect">เลือกเทรนเนอร์:</label>
            <select id="trainerSelect">
                <option value="">ทั้งหมด</option>
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

                // Populate dropdown with trainer names from the database
                $sqlTrainers = "SELECT * FROM accepted_trainers";
                $resultTrainers = $conn->query($sqlTrainers);
                while($rowTrainer = $resultTrainers->fetch_assoc()) {
                    echo "<option value='" . $rowTrainer['trainer_id'] . "'>" . $rowTrainer['first_name'] . " " . $rowTrainer['last_name'] . "</option>";
                }
                ?>
            </select>
            <button onclick="getReviews()">ค้นหา</button>
        </div>
        <div class="row" id="reviewContainer">
            <!-- Reviews will be loaded here -->
        </div>
        <a href="../indexuser.php" class="btn btn-primary mt-3">ย้อนกลับ</a>
    </div>

    <script>
        function getReviews() {
            var trainerId = document.getElementById("trainerSelect").value;
            // Send AJAX request to fetch reviews for the selected trainer
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("reviewContainer").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "get_reviews.php?trainer_id=" + trainerId, true);
            xhttp.send();
        }
    </script>

</body>
</html>
