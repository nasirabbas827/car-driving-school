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

if (isset($_GET['package_id'])) {
    $packageId = $_GET['package_id'];

    // Fetch package details
    $selectPackageSql = "SELECT * FROM Packages WHERE package_id = ?";
    $stmt = mysqli_prepare($conn, $selectPackageSql);
    mysqli_stmt_bind_param($stmt, "i", $packageId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $package_id, $package_name, $description, $price, $training_duration, $date_created);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Fetch user details from the database
    $selectUserSql = "SELECT id, username, email, age, phone FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $selectUserSql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $user_id, $username, $email, $age, $phone);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (isset($_POST['enroll'])) {
        $address = $_POST['address'];
        $start_date = $_POST['start_date'];
        $registration_number = uniqid(); // Auto-generated registration number
        $date_created = date("Y-m-d");
        $status = "pending";
        $payment_mode = "Physical"; // Auto-filled payment mode

        // Insert enrollment details into the database
        $insertEnrollmentSql = "INSERT INTO Enrollments (package_id, user_id, username, email, phone, age, address, start_date, registration_number, date_created, status, payment_mode) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertEnrollmentSql);
        mysqli_stmt_bind_param($stmt, "iisssissssss", $packageId, $user_id, $username, $email, $phone, $age, $address, $start_date, $registration_number, $date_created, $status, $payment_mode);

        if (mysqli_stmt_execute($stmt)) {
            $message = "Enrolled successfully! Your enrollment is pending approval. Registration Number: $registration_number";
        } else {
            $error_message = "Error enrolling: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }
} else {
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enroll in Package</title>
</head>
<body>
<?php include('navbar.php'); ?>

<h2>Enroll in Package</h2>
<?php
if (isset($message)) {
    echo "<p style='color: green;'>$message</p>";
}
if (isset($error_message)) {
    echo "<p style='color: red;'>$error_message</p>";
}
?>
<form method="post" action="">
    Package: <?php echo $package_name; ?><br>
    Price: <?php echo $price; ?><br>
    Username: <?php echo $username; ?><br>
    Email: <?php echo $email; ?><br>
    Phone: <?php echo $phone; ?><br>
    Age: <?php echo $age; ?><br>
    Address: <input type="text" name="address"><br>
    Start Date: <input type="date" name="start_date"><br>
    Payment Mode: <input type="text" name="payment_mode" value="Physical" readonly><br>
    <input type="submit" name="enroll" value="Enroll">
</form>
</body>
</html>
