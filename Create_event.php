

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration</title>
   
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <script>
        $(function() {
            var today = new Date()
            var maxDate = new Date();
            maxDate.setMonth(maxDate.getMonth() + 3);

            $("#date").datepicker({
                dateFormat: "yy-mm-dd",
                minDate: today,
                maxDate: maxDate
            });
        
        });
        function validateForm(event) {
            var title = document.getElementById('title').value;
            var date = document.getElementById('date').value;
            var time = document.getElementById('time').value;
            var location = document.getElementById('location').value;
            var description = document.getElementById('description').value;

            if (!title || !date || !time || !location || !description) {
                alert('All fields are required.');
                event.preventDefault();
                return false;
            }

            if (description.length > 600) {
                alert('Description cannot exceed 600 characters.');
                event.preventDefault();
                return false;
            }

            return true;
        }
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.querySelector('form');
            form.addEventListener('submit', validateForm);
        });

    </script>
</head>
<body>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .navbar {
            background-color: #333;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .header {
            text-align: center;
            padding: 50px;
            background: #1abc9c;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 50px;
        }
        .container {
            width: 500px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input[type="text"],
        .form-group input[type="email"],
       
        .form-group select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }
      
        .form-group input[type="description"],
        .form-group select {
            width: 100%;
            padding: 25px;
            box-sizing: border-box;
            text-align: left; 
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
        .Date{
            padding:10px;
            height:15px;
        }

</style>

    <div class="navbar">
        <a href="landingpage.php">Home</a>
        <a href="event.html">Events</a>
    </div>

    <div class="header">
        <h1>Create events</h1>
        <p>Create events for ur choice.</p>
    </div>

    <div class="container">
        <form action="Create_event.php" method="post">
          
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="text" id="date" name="date" required>
            </div>
            
        <div class="form-group">
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="description" id="description" name="description" maxlength="600" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Add event">
            </div>
        </form>
    </div>

    <div class="footer">
        <p>&copy; 2024 University Event Management. All rights reserved.</p>
    </div>
 
</body>
</html>
<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "campus_event_management_system";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title'], $_POST['date'],$_POST['time'], $_POST['location'], $_POST['description'])) {
    // Retrieve form data and sanitize input
    $title = htmlspecialchars($_POST['title']);
    $Date = htmlspecialchars($_POST['date']);
    $time=htmlspecialchars($_POST['time']);
    $location = htmlspecialchars($_POST['location']);
    $description = htmlspecialchars($_POST['description']);

    // Prepare SQL statement for insertion
    $sql = "INSERT INTO events (title, Date,Time, Location, Description) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssss", $title, $Date,$time, $location, $description);

        // Execute SQL statement
        if ($stmt->execute()) {
            echo "<script>
            alert('Registration successful!');
            window.location.href = 'events.php';
          </script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close prepared statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

// Close database connection
$conn->close();
?>
