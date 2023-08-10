<?php
include('config.php');
session_start();

// Check if user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Fetch pending enrollments with all details
$selectEnrollmentsSql = "SELECT e.*, p.package_name FROM Enrollments e
                        INNER JOIN Packages p ON e.package_id = p.package_id
                        WHERE e.status = 'Pending'";
$result = mysqli_query($conn, $selectEnrollmentsSql);

// Update enrollment status
if (isset($_POST['update_status']) && isset($_POST['enrollment_id']) && isset($_POST['new_status'])) {
    $enrollment_id = $_POST['enrollment_id'];
    $new_status = $_POST['new_status'];

    $updateStatusSql = "UPDATE Enrollments SET status = ? WHERE enrollment_id = ?";
    $stmt = mysqli_prepare($conn, $updateStatusSql);
    mysqli_stmt_bind_param($stmt, "si", $new_status, $enrollment_id);

    if (mysqli_stmt_execute($stmt)) {
        $success_message = "Enrollment status updated successfully!";
    } else {
        $error_message = "Error updating enrollment status: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Update Enrollment Status</title>
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include('admin_navbar.php'); ?>

    <div class="container mt-5">
        <h2>Update Enrollment Status</h2>

        <?php
        if (isset($success_message)) {
            echo "<p class='text-success'>$success_message</p>";
        }
        if (isset($error_message)) {
            echo "<p class='text-danger'>$error_message</p>";
        }
        ?>

        <form method="post">
            <div class="form-group">
                <label for="enrollment_id">Select Enrollment:</label>
                <select class="form-control" name="enrollment_id" required>
                    <?php
                    while ($enrollmentRow = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $enrollmentRow['enrollment_id'] . "'>Enrollment ID: " . $enrollmentRow['enrollment_id'] . " - Package: " . $enrollmentRow['package_name'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="new_status">New Status:</label>
                <select class="form-control" name="new_status" required>
                    <option value="Approved">Approved</option>
                    <option value="Rejected">Rejected</option>
                </select>
            </div>

            <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
        </form>

        <h3 class="mt-4">Pending Enrollments Details</h3>
        <?php
            $selectPendingEnrollmentsSql = "SELECT e.*, p.package_name FROM Enrollments e
                                            INNER JOIN Packages p ON e.package_id = p.package_id
                                            WHERE e.status = 'Pending'";
            $pendingEnrollmentsResult = mysqli_query($conn, $selectPendingEnrollmentsSql);

        if (mysqli_num_rows($pendingEnrollmentsResult) > 0) {
            echo "<table class='table table-bordered'>";
            echo "<thead class='thead-dark'>";
            echo "<tr><th>Enrollment ID</th><th>Package</th><th>User ID</th><th>Username</th><th>Email</th><th>Phone</th><th>Age</th><th>Address</th><th>Start Date</th><th>Registration Number</th><th>Payment Mode</th><th>Date Created</th></tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($enrollmentDetails = mysqli_fetch_assoc($pendingEnrollmentsResult)) {
                echo "<tr>";
                echo "<td>" . $enrollmentDetails['enrollment_id'] . "</td>";
                echo "<td>" . $enrollmentDetails['package_name'] . "</td>";
                echo "<td>" . $enrollmentDetails['user_id'] . "</td>";
                echo "<td>" . $enrollmentDetails['username'] . "</td>";
                echo "<td>" . $enrollmentDetails['email'] . "</td>";
                echo "<td>" . $enrollmentDetails['phone'] . "</td>";
                echo "<td>" . $enrollmentDetails['age'] . "</td>";
                echo "<td>" . $enrollmentDetails['address'] . "</td>";
                echo "<td>" . $enrollmentDetails['start_date'] . "</td>";
                echo "<td>" . $enrollmentDetails['registration_number'] . "</td>";
                echo "<td>" . $enrollmentDetails['payment_mode'] . "</td>";
                echo "<td>" . $enrollmentDetails['date_created'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No pending enrollments found.</p>";
        }
        ?>
    </div>

    <!-- Include Bootstrap JS scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
