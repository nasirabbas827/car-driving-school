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
        <h2>Hello, <?php echo $username; ?>! See Our Available Packages Below</h2>
    
        <h3 class="mt-4">Available Packages</h3>
        <?php
        $selectPackagesSql = "SELECT * FROM Packages";
        $packagesResult = $conn->query($selectPackagesSql);
        
        if ($packagesResult->num_rows > 0) {
            echo "<div class='list-group'>";
            while ($packageRow = $packagesResult->fetch_assoc()) {
                echo "<div class='list-group-item'>";
                echo "<h5 class='mb-1'>" . $packageRow['package_name'] . "</h5>";
                echo "<p class='mb-1'>Description: " . $packageRow['description'] . "</p>";
                echo "<p class='mb-1'>Price: " . $packageRow['price'] . "</p>";
                echo "<p class='mb-1'>Training Duration: " . $packageRow['training_duration'] . "</p>";
                echo "<a href='enroll.php?package_id=" . $packageRow['package_id'] . "' class='btn btn-primary'>Enroll</a>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>No packages available.</p>";
        }
        ?>
    </div>

    <!-- Include Bootstrap JS (at the end of the body for better performance) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
