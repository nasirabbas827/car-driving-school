<?php
include('config.php');
session_start();

// Check if user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Fetch approved enrollments with package names
$selectEnrollmentsSql = "SELECT e.*, p.package_name FROM Enrollments e
                        INNER JOIN Packages p ON e.package_id = p.package_id
                        WHERE e.status = 'Approved'";
$result = mysqli_query($conn, $selectEnrollmentsSql);

// Search users by registration number
if (isset($_POST['search_user'])) {
    $search_reg_number = $_POST['search_reg_number'];

    $searchUserSql = "SELECT e.*, p.package_name FROM Enrollments e
                      INNER JOIN Packages p ON e.package_id = p.package_id
                      WHERE e.registration_number = ?";
    $stmt = mysqli_prepare($conn, $searchUserSql);
    mysqli_stmt_bind_param($stmt, "s", $search_reg_number);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
}

// Filter enrollments by date created
if (isset($_POST['filter_by_date'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $filterEnrollmentsSql = "SELECT e.*, p.package_name FROM Enrollments e
                            INNER JOIN Packages p ON e.package_id = p.package_id
                            WHERE e.status = 'Approved' AND e.date_created BETWEEN ? AND ?";
    $stmt = mysqli_prepare($conn, $filterEnrollmentsSql);
    mysqli_stmt_bind_param($stmt, "ss", $start_date, $end_date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Approved Enrollments</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include('admin_navbar.php'); ?>

    <div class="container mt-4">
        <h2>Approved Enrollments</h2>

        <h3>Search User by Registration Number</h3>
        <form method="post">
            <div class="form-group">
                <input type="text" name="search_reg_number" class="form-control" placeholder="Enter Registration Number">
            </div>
            <button type="submit" name="search_user" class="btn btn-primary">Search</button>
        </form>

        <h3 class="mt-4">Filter Enrollments by Date Created</h3>
        <form method="post">
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
            <button type="submit" name="filter_by_date" class="btn btn-primary">Filter</button>
        </form>

        <br>
        <form method="post" action="download_enrollments.php">
            <input type="hidden" name="data" id="data" value="">
            <button type="button" onclick="exportToExcel()" class="float-right btn btn-success">Download Excel</button>
        </form>

        <h3 class="mt-4">Approved Enrollments List</h3>
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table table-bordered'>";
            echo "<thead><tr><th>Enrollment ID</th><th>Package Name</th><th>Username</th><th>Email</th><th>Phone</th><th>Age</th><th>Address</th><th>Payment</th><th>Start Date</th><th>Registration Number</th><th>Date Created</th></tr></thead><tbody>";
            while ($enrollmentDetails = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $enrollmentDetails['enrollment_id'] . "</td>";
                echo "<td>" . $enrollmentDetails['package_name'] . "</td>";
                echo "<td>" . $enrollmentDetails['username'] . "</td>";
                echo "<td>" . $enrollmentDetails['email'] . "</td>";
                echo "<td>" . $enrollmentDetails['phone'] . "</td>";
                echo "<td>" . $enrollmentDetails['age'] . "</td>";
                echo "<td>" . $enrollmentDetails['address'] . "</td>";
                echo "<td>" . $enrollmentDetails['payment_mode'] . "</td>";
                echo "<td>" . $enrollmentDetails['start_date'] . "</td>";
                echo "<td>" . $enrollmentDetails['registration_number'] . "</td>";
                echo "<td>" . $enrollmentDetails['date_created'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "No approved enrollments found.";
        }
        ?>
    </div>

  <!-- Include Bootstrap JS (at the end of the body for better performance) -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
  <script>
    function exportToExcel() {
      // Create a new workbook
      var wb = XLSX.utils.table_to_book(document.getElementsByTagName('table')[0], { sheet: 'Enrollement Records' });

      // Save the workbook as an Excel file
      XLSX.writeFile(wb, 'Enrollement_Records.xlsx');
    }
  </script>
</body>
</html>
