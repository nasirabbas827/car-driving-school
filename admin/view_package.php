<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Delete package
if (isset($_GET['delete'])) {
    $packageId = $_GET['delete'];
    $deleteSql = "DELETE FROM Packages WHERE package_id = $packageId";

    if ($conn->query($deleteSql) === TRUE) {
        $message = "Package deleted successfully!";
    } else {
        $error_message = "Error deleting package: " . $conn->error;
    }
}

// Fetch packages
$selectSql = "SELECT * FROM Packages";
$result = $conn->query($selectSql);
?>


<!DOCTYPE html>
<html>
<head>
    <title>View Packages</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include('admin_navbar.php'); ?>

    <div class="container mt-5">
        <h2>View Packages</h2>
        <?php
        if (isset($message)) {
            echo "<p style='color: green;'>$message</p>";
        }
        if (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
        ?>
        <table class="table table-bordered">
            <tr>
                <th>Package Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Training Duration</th>
                <th>Date Created</th>
                <th>Actions</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['package_name'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['training_duration'] . "</td>";
                echo "<td>" . $row['date_created'] . "</td>";
                echo "<td><a href='edit_package.php?id=" . $row['package_id'] . "' class='btn btn-primary btn-sm'>Edit</a> ";
                echo "<a href='?delete=" . $row['package_id'] . "' class='mt-2 btn btn-danger btn-sm'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <!-- Add Bootstrap JS scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
