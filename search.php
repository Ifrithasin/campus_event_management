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
        .search input[type=text] {
            float: right;
  padding: 6px;
  border: none;
  margin-top: 8px;
  margin-right: 16px;
  font-size: 17px;
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
<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "campus_event_management_system");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['search'])) {
    $filtervalues = mysqli_real_escape_string($con, $_GET['search']);
    $query = "SELECT * FROM events WHERE title LIKE '%$filtervalues%'";

    $query_run = mysqli_query($con, $query);
}
?>
    <div class="navbar">
        <a href="landingpage.php">Home</a>
        <a href="upcoming.php">Upcoming Events</a>
        <a href="past.php">Past Events</a>
    </div>
<div class="header">
        <h1>Search results</h1>
    
        <div class="search"> 
      
        <form method="get" action="search.php">
        <input type="text" name="search" placeholder="Search" value="">
      
    </form>
        </div>
    </div>
  

    <?php
    if (isset($query_run)) {
        if (mysqli_num_rows($query_run) > 0) {
            foreach ($query_run as $item) {
                ?>
                <div class="section events" id="past">
                    <div class="event">
                        <h2><?php echo htmlspecialchars($item['title']); ?></h2>
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($item['Date']); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($item['Location']); ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($item['Description']); ?></p>

                    </div>
                </div>
                <?php
            }
        } else {
            echo "No events found.";
        }
    }
    ?>

    <!-- Close the database connection -->
    <?php mysqli_close($con); ?>
</body>
</html>
