<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "campus_event_management_system";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists in any of the role tables
    $roles = ['admin', 'organizer', 'students','faculty'];
    $loggedIn = false;

    foreach ($roles as $role) {
        $sql = "SELECT * FROM $role WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                echo "Login successful as $role!";
                $loggedIn = true;
                // Redirect to different pages based on role
                switch ($role) {
                    case 'admin':
                        header("Location: admin_dashboard.php");
                        break;
                    case 'organizer':
                        header("Location: organizer_dashboard.php");
                        break;
                    case 'students':
                        header("Location: event.php");
                        break;
                        case 'faculty':
                            header("Location: event.php");
                            break;
                    default:
                        // Default redirection if no matching role is found
                        header("Location: default_dashboard.php");
                        break;
                }
                exit; // Make sure to exit after redirection
            }
        }
    }


    $stmt->close();
}

$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signin Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: #fff;    
            font-size: 16px;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Signin Form</h2>
        <form action="signin.php" method="post">
            <div class="form-group">
                <label for="email">North South Mail Address:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Signin">
            </div>
        </form>
    </div>
</body>
</html>