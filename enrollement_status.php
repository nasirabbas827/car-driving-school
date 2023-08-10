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

// Handle deletion of enrollment
if (isset($_GET['delete_enrollment'])) {
    $enrollmentId = $_GET['delete_enrollment'];
    
    // Delete enrollment
    $deleteEnrollmentSql = "DELETE FROM Enrollments WHERE enrollment_id = ?";
    $stmt = mysqli_prepare($conn, $deleteEnrollmentSql);
    mysqli_stmt_bind_param($stmt, "i", $enrollmentId);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: enrollement_status.php");
        exit();
    } else {
        $error_message = "Error deleting enrollment: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}

// Fetch user's enrollment status and package details
$selectEnrollmentsSql = "SELECT e.*, p.package_name, p.price FROM Enrollments e
                        INNER JOIN Packages p ON e.package_id = p.package_id
                        WHERE e.user_id = ?";
$stmt = mysqli_prepare($conn, $selectEnrollmentsSql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Enrollment Status</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
<?php include('navbar.php'); ?>

<div class="container mt-4">
    <h2>Enrollment Status</h2>

    <h3 class="mt-4">My Enrollments</h3>
    <?php
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    if (mysqli_num_rows($result) > 0) {
        echo "<div class='list-group'>";
        while ($enrollmentRow = mysqli_fetch_assoc($result)) {
            echo "<div class='list-group-item'>";
            echo "<h5 class='mb-1'>Package: " . $enrollmentRow['package_name'] . "</h5>";
            echo "<p class='mb-1'>Price: $" . $enrollmentRow['price'] . "</p>";
            echo "<p class='mb-1'>Registration Number: " . $enrollmentRow['registration_number'] . "</p>";
            echo "<p class='mb-1'>Payment Mode: " . $enrollmentRow['payment_mode'] . "</p>";
            echo "<p class='mb-1'>Start Date: " . $enrollmentRow['start_date'] . "</p>";
            echo "<p class='mb-1'>Status: " . $enrollmentRow['status'] . "</p>";

            // Add delete button
            echo "<a href='enrollement_status.php?delete_enrollment=" . $enrollmentRow['enrollment_id'] . "' class='mt-3 btn btn-danger'>Delete</a><br>";

            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p>You have no enrollments.</p>";
    }
    ?>
</div>

<!-- Include Bootstrap JS (at the end of the body for better performance) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
