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
$selectUserSql = "SELECT id, username, email, age, phone FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $selectUserSql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $user_id, $username, $email, $age, $phone);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Fetch user's subscribed schools with additional details
$selectSubscriptionsSql = "SELECT s.school_id, s.school_name, s.contact_info, s.about_us, s.services, s.picture_path FROM Subscriptions su
                          INNER JOIN DrivingSchools s ON su.school_id = s.school_id
                          WHERE su.user_id = ?";
$stmt = mysqli_prepare($conn, $selectSubscriptionsSql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Subscribed Schools</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

<div class="container mt-4">

    <h3 class="mt-4">My Subscribed Schools</h3>
    <?php
    if (mysqli_num_rows($result) > 0) {
        echo "<div class='list-group'>";
        while ($subscriptionRow = mysqli_fetch_assoc($result)) {
            echo "<div class='list-group-item'>";
            echo "<img src='./admin/" . $subscriptionRow['picture_path'] . "' alt='School Picture' class='mb-2' width='200px' height='200px'><br>";

            echo "<h5 class='mb-1'>" . $subscriptionRow['school_name'] . "</h5>";
            echo "<p class='mb-1'>Contact Info: " . $subscriptionRow['contact_info'] . "</p>";
            echo "<p class='mb-1'>About Us: " . $subscriptionRow['about_us'] . "</p>";
            echo "<p class='mb-1'>Services: " . $subscriptionRow['services'] . "</p>";
            echo "<a href='cancel_subscription.php?school_id=" . $subscriptionRow['school_id'] . "' class='btn btn-danger'>Cancel Subscription</a>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p>You have no subscribed schools.</p>";
    }
    ?>
</div>

<!-- Include Bootstrap JS (at the end of the body for better performance) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
