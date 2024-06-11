<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "campus_event_management_system";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['email'], $_POST['password'], $_POST['role'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    switch ($role) {
        case 'Admin':
            $table = 'admin';
            break;
        case 'Organizer':
            $table = 'organizer';
            break;
        case 'Faculty':
            $table = 'faculty';
            break;
        case 'Student':
            $table = 'students';
            break;
        default:
            echo "Invalid role";
            exit;
    }

    $sql = "INSERT INTO $table (email, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
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
        .form-group .role {
            margin-bottom: 10px;
        }
        .form-group .role label {
            display: inline-block;
            margin-right: 10px;
        }
        .form-group input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #218838;
        }
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <script>
        function validateForm() {
            var email = document.getElementById("email");
            var password = document.getElementById("password");
            var emailError = document.getElementById("email-error");
            var passwordError = document.getElementById("password-error");

            emailError.textContent = "";
            passwordError.textContent = "";

            // Email validation with regular expression
            var emailRegex = /^[^\s@]+@northsouth\.edu$/;
            if (!emailRegex.test(email.value)) {
                emailError.textContent = "Email must be in format username@northsouth.edu";
                console.log("invalid email");
                return false; // Prevent form submission if email is invalid
            }

            // Password length check
            if (password.value.length < 5 || password.value.length > 11) {
                passwordError.textContent = "Password must be 5-11 characters long";
                console.log("invalid password");
                return false; // Prevent form submission if password length is invalid
            }

            return true; // Allow form submission if all validations pass
        }
    </script>
    <div class="container">
        <h2>Signup Form</h2>
        <form action="signin.php" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="email">North South Mail Address:</label>
                <input type="email" id="email" name="email" required>
                <div id="email-error" class="error"></div>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <div id="password-error" class="error"></div>
            </div>
            <div class="form-group">
                <label>Role:</label>
                <div class="role">
                    <label>
                        <input type="radio" name="role" value="Admin" required> Admin
                    </label>
                    <label>
                        <input type="radio" name="role" value="Organizer"> Organizer
                    </label>
                    <label>
                        <input type="radio" name="role" value="Faculty"> Faculty
                    </label>
                    <label>
                        <input type="radio" name="role" value="Student"> Student
                    </label>
                </div>
            </div>
            <div class="form-group">
                <input type="submit" value="Signup">
            </div>
        </form>
    </div>
</body>
</html>


