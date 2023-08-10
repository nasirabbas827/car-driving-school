<?php
include('config.php');
session_start();

// Check if user is logged in, if not, redirect to login page
if (!isset($_SESSION["id"]) || empty($_SESSION["id"])) {
    header("location: index.php");
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION["id"];

// Fetch user details from the database
$sql = "SELECT id, username, email, age FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $fetched_id, $username, $email, $age);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
?>


<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<?php include('navbar.php'); ?>

    <div class="container mt-4">
        <h2>Welcome, <?php echo $username; ?>!</h2>

        
        <h3 class="mt-4">Available Driving Schools</h3>
        <?php
        $selectSchoolsSql = "SELECT * FROM DrivingSchools";
        $schoolsResult = $conn->query($selectSchoolsSql);
        
        if ($schoolsResult->num_rows > 0) {
            echo "<div class='row'>";
            while ($schoolRow = $schoolsResult->fetch_assoc()) {
                echo "<div class='col-md-4 mb-4'>";
                echo "<div class='card'>";
                echo "<img src='./admin/" . $schoolRow['picture_path'] . "' class='card-img-top' alt='School Picture'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . $schoolRow['school_name'] . "</h5>";
                echo "<p class='card-text'>Contact Info: " . $schoolRow['contact_info'] . "</p>";
                echo "<p class='card-text'>About Us: " . $schoolRow['about_us'] . "</p>";
                echo "<p class='card-text'>Services: " . $schoolRow['services'] . "</p>";
                echo "<a href='subscribe.php?school_id=" . $schoolRow['school_id'] . "' class='btn btn-primary'>Subscribe</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>No driving schools available.</p>";
        }
        ?>
    </div>

    <!-- Include Bootstrap JS (at the end of the body for better performance) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
