<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Delete school
if (isset($_GET['delete'])) {
    $schoolId = $_GET['delete'];
    $deleteSql = "DELETE FROM DrivingSchools WHERE school_id = $schoolId";

    if ($conn->query($deleteSql) === TRUE) {
        $message = "Driving school deleted successfully!";
    } else {
        $error_message = "Error deleting record: " . $conn->error;
    }
}

// Fetch schools
$selectSql = "SELECT * FROM DrivingSchools";
$result = $conn->query($selectSql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Driving Schools</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include('admin_navbar.php'); ?>

    <div class="container mt-5">
        <h2>Manage Driving Schools</h2>
        <?php
        if (isset($message)) {
            echo "<p style='color: green;'>$message</p>";
        }
        if (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th>School Name</th>
                    <th>Contact Info</th>
                    <th>About Us</th>
                    <th>Services</th>
                    <th>Picture</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['school_name'] . "</td>";
                    echo "<td>" . $row['contact_info'] . "</td>";
                    echo "<td>" . $row['about_us'] . "</td>";
                    echo "<td>" . $row['services'] . "</td>";
                    echo "<td><img src='" . $row['picture_path'] . "' width='100'></td>";
                    echo "<td><a href='edit_school.php?id=" . $row['school_id'] . "' class='btn btn-primary'>Edit</a> ";
                    echo "<a href='?delete=" . $row['school_id'] . "' class='btn btn-danger'>Delete</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Add Bootstrap JS scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
