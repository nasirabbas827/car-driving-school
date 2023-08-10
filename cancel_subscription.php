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

if (isset($_GET['school_id'])) {
    $school_id = $_GET['school_id'];

    // Check if the user is subscribed to the specified school
    $checkSubscriptionSql = "SELECT * FROM Subscriptions WHERE user_id = ? AND school_id = ?";
    $stmt = mysqli_prepare($conn, $checkSubscriptionSql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $school_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // Delete the subscription
        $deleteSubscriptionSql = "DELETE FROM Subscriptions WHERE user_id = ? AND school_id = ?";
        $stmt = mysqli_prepare($conn, $deleteSubscriptionSql);
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $school_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $message = "Subscription cancelled successfully!";
        } else {
            $error_message = "Error cancelling subscription: " . mysqli_error($conn);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        $error_message = "You are not subscribed to this school.";
    }
} else {
    header("Location: user_dashboard.php");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Cancel Subscription</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

<div class="container mt-4">
    <h2>Cancel Subscription</h2>
    <?php
    if (isset($message)) {
        echo "<p class='text-success'>$message</p>";
    }
    if (isset($error_message)) {
        echo "<p class='text-danger'>$error_message</p>";
    }
    ?>
</div>

<!-- Include Bootstrap JS (at the end of the body for better performance) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

