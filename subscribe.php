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
    $schoolId = $_GET['school_id'];

    // Check if the user is already subscribed to the driving school
    $checkSubscriptionSql = "SELECT * FROM Subscriptions WHERE user_id = ? AND school_id = ?";
    $stmt = mysqli_prepare($conn, $checkSubscriptionSql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $schoolId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 0) {
        // Subscribe the user to the driving school
        $subscribeSql = "INSERT INTO Subscriptions (user_id, school_id) VALUES (?, ?)";
        $subscribeStmt = mysqli_prepare($conn, $subscribeSql);
        mysqli_stmt_bind_param($subscribeStmt, "ii", $user_id, $schoolId);

        if (mysqli_stmt_execute($subscribeStmt)) {
            $message = "Subscribed successfully!";
        } else {
            $error_message = "Error subscribing: " . mysqli_error($conn);
        }

        mysqli_stmt_close($subscribeStmt);
    } else {
        $error_message = "You are already subscribed to this driving school.";
    }

    mysqli_stmt_close($stmt);
} else {
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Subscribe to Driving School</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

    <div class="container mt-4">
        <h2>Subscribe to Driving School</h2>
        <?php
        if (isset($message)) {
            echo "<p class='text-success'>$message</p>";
        }
        if (isset($error_message)) {
            echo "<p class='text-danger'>$error_message</p>";
        }
        ?>
        <a href="home.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <!-- Include Bootstrap JS (at the end of the body for better performance) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
