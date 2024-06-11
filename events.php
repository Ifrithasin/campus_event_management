<?php
$servername = "localhost";
$username = "root";
$password = "";  // Change this if you have a password
$dbname = "campus_event_management_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Current date
$current_date = date('Y-m-d');

// Fetch upcoming events (events with date in the future)
$upcoming_sql = "SELECT * FROM events WHERE Date > '$current_date' ORDER BY Date ASC";

$upcoming = $conn->query($upcoming_sql);

// Fetch past events (events with date in the past)
$past_sql = "SELECT * FROM events WHERE Date < '$current_date' ORDER BY Date DESC";
$past = $conn->query($past_sql);

function formatEventDate($date) {
    $dateTime = new DateTime($date);
    return $dateTime->format('F j, Y');
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management - Events</title>
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
        .section {
            padding: 20px;
        }
        .events .event {
            border: 1px solid #ccc;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .events .event .register-btn,
        .events .event .feedback-btn,
        .events .event .read-feedback-btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px 4px;
        }
        .events .event .feedback-btn:hover,
        .events .event .read-feedback-btn:hover,
        .events .event .register-btn:hover {
            background-color: #218838;
        }
        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="landingpage.php">Home</a>
        <a href="#upcoming">Upcoming Events</a>
        <a href="#past">Past Events</a>
    </div>

    <div class="header">
        <h1>Events</h1>
        <p>Stay updated with our latest and past events</p>
    </div>

    <div class="section events" id="upcoming">
    <h2>Upcoming Events</h2>
        <?php
        if ($upcoming_result->num_rows > 0) {
            while($row = $upcoming_result->fetch_assoc()) {
                echo "<div class='event'>";
                echo "<h3>" . htmlspecialchars($row["title"]) . "</h3>";
                echo "<p>Date: " . formatEventDate($row["Date"]) . "</p>";
                echo "<p>Location: " . htmlspecialchars($row["location"]) . "</p>";
                echo "<p>Description: " . htmlspecialchars($row["Description"]) . "</p>";
                echo "<button class='register-btn'>Register</button>";
                echo "</div>";
            }
        } else {
            echo "<p>No upcoming events.</p>";
        }
        ?>
    </div>
    <div class="section events" id="past">
        <h2>Past Events</h2>
        <?php
        if ($past_result->num_rows > 0) {
            while($row = $past_result->fetch_assoc()) {
                echo "<div class='event'>";
                echo "<h3>" . htmlspecialchars($row["title"]) . "</h3>";
                echo "<p>Date: " . formatEventDate($row["Date"]) . "</p>";
                echo "<p>Location: " . htmlspecialchars($row["Location"]) . "</p>";
                echo "<p>Description: " . htmlspecialchars($row["Description"]) . "</p>";
                echo "<button class='feedback-btn' onclick=\"location.href='givefeedback.html?event=" . urlencode($row["title"]) . "'\">Give Feedback</button>";
                echo "<button class='read-feedback-btn' onclick=\"location.href='readfeedback.html?event=" . urlencode($row["title"]) . "'\">Read Feedback</button>";
                echo "</div>";
            }
        } else {
            echo "<p>No past events.</p>";
        }
        $conn->close();
        ?>
    
    </div>

    <div class="footer">
        <p>&copy; 2024 University Event Management. All rights reserved.</p>
    </div>
</body>
</html>