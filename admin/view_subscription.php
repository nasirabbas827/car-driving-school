<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Fetch all subscriptions with user and school details
$selectSubscriptionsSql = "SELECT su.*, u.username, u.email, s.school_name
                          FROM Subscriptions su
                          INNER JOIN users u ON su.user_id = u.id
                          INNER JOIN DrivingSchools s ON su.school_id = s.school_id";
$result = mysqli_query($conn, $selectSubscriptionsSql);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Subscriptions List</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include('admin_navbar.php'); ?>

    <div class="container mt-5">
        <h2>Subscriptions List</h2>
        
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table table-bordered'>";
            echo "<tr><th>Subscription ID</th><th>User</th><th>Email</th><th>School</th></tr>";
            while ($subscriptionRow = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $subscriptionRow['subscription_id'] . "</td>";
                echo "<td>" . $subscriptionRow['username'] . "</td>";
                echo "<td>" . $subscriptionRow['email'] . "</td>";
                echo "<td>" . $subscriptionRow['school_name'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No subscriptions found.";
        }
        ?>
    </div>

    <!-- Add Bootstrap JS scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
