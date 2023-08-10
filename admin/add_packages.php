<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

if (isset($_POST['submit'])) {
    $packageName = $_POST['package_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['training_duration'];
    $dateCreated = date("Y-m-d");

    $insertSql = "INSERT INTO Packages (package_name, description, price, training_duration, date_created)
                  VALUES ('$packageName', '$description', '$price', '$duration', '$dateCreated')";

    if ($conn->query($insertSql) === TRUE) {
        $message = "Package created successfully!";
    } else {
        $error_message = "Error creating package: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Package</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('admin_navbar.php'); ?>

    <div class="container mt-5">
        <h2>Create Package</h2>
        <?php
        if (isset($message)) {
            echo "<p style='color: green;'>$message</p>";
        }
        if (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
        ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="package_name">Package Name:</label>
                <input type="text" class="form-control" name="package_name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" class="form-control" name="price" required>
            </div>
            <div class="form-group">
                <label for="training_duration">Training Duration:</label>
                <input type="text" class="form-control" name="training_duration" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Create Package</button>
            <a href="view_package.php" class="btn btn-secondary">View Packages</a>
        </form>
    </div>

    <!-- Add Bootstrap JS scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
