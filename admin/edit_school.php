<?php
include('config.php');

if (isset($_GET['id'])) {
    $schoolId = $_GET['id'];
    
    // Fetch school details
    $selectSql = "SELECT * FROM DrivingSchools WHERE school_id = $schoolId";
    $result = $conn->query($selectSql);
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // Update school details
        if (isset($_POST['update'])) {
            $schoolName = $_POST['school_name'];
            $contactInfo = $_POST['contact_info'];
            $aboutUs = $_POST['about_us'];
            $services = $_POST['services'];
            
            $updateSql = "UPDATE DrivingSchools SET 
                          school_name = '$schoolName', 
                          contact_info = '$contactInfo', 
                          about_us = '$aboutUs', 
                          services = '$services' 
                          WHERE school_id = $schoolId";
            
            if ($conn->query($updateSql) === TRUE) {
                $message = "School details updated successfully!";
            } else {
                $error_message = "Error updating record: " . $conn->error;
            }
        }
    } else {
        $error_message = "School not found.";
    }
} else {
    header("Location: manage_schools.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit School</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include('admin_navbar.php'); ?>

    <div class="container mt-5">
        <h2>Edit School</h2>
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
                <label for="school_name">School Name:</label>
                <input type="text" class="form-control" name="school_name" value="<?php echo $row['school_name']; ?>">
            </div>
            <div class="form-group">
                <label for="contact_info">Contact Info:</label>
                <input type="number" class="form-control" name="contact_info" value="<?php echo $row['contact_info']; ?>">
            </div>
            <div class="form-group">
                <label for="about_us">About Us:</label>
                <textarea class="form-control" name="about_us"><?php echo $row['about_us']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="services">Services:</label>
                <textarea class="form-control" name="services"><?php echo $row['services']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="update">Update School</button>
        </form>
    </div>

    <!-- Add Bootstrap JS scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
