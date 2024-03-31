<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Mitr", sans-serif;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"] {
        width: 70%;
        padding: 10px;
        margin: 0 auto 15px 15px; 
        border: 1px solid #ccc;
        border-radius: 5px;
    }
        input[type="submit"] {
            width: 50%;
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Edit User</h1>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "trainer";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if(isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
        $sql = "SELECT * FROM user WHERE id = $user_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            <form action="update_user.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                <label for="firstname">Firstname:</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo $row['firstname']; ?>"><br>
                <label for="lastname">Lastname:</label>
                <input type="text" id="lastname" name="lastname" value="<?php echo $row['lastname']; ?>"><br>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $row['username']; ?>"><br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>"><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password"><br>
                <label for="gender">Gender:</label>
                <input type="text" id="gender" name="gender" value="<?php echo $row['gender']; ?>"><br>
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" value="<?php echo $row['age']; ?>"><br>
                <label for="height">Height:</label>
                <input type="number" id="height" name="height" value="<?php echo $row['height']; ?>"><br>
                <label for="weight">Weight:</label>
                <input type="number" id="weight" name="weight" value="<?php echo $row['weight']; ?>"><br>
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo $row['phone']; ?>"><br>
                <input type="submit" value="Update">
            </form>
            <?php
        } else {
            echo "User not found.";
        }
    } else {
        echo "No user ID specified.";
    }
    $conn->close();
    ?>
</body>
</html>
