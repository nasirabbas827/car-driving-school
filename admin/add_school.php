<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

if (isset($_POST['submit'])) {
    $schoolName = $_POST['school_name'];
    $contactInfo = $_POST['contact_info'];
    $aboutUs = $_POST['about_us'];
    $services = $_POST['services'];
    $pictureName = $_FILES['picture']['name'];
    $pictureTmp = $_FILES['picture']['tmp_name'];

    $picturePath = 'uploads/' . $pictureName;

    if (move_uploaded_file($pictureTmp, $picturePath)) {
        $sql = "INSERT INTO DrivingSchools (school_name, contact_info, about_us, services, picture_path)
                VALUES ('$schoolName', '$contactInfo', '$aboutUs', '$services', '$picturePath')";

        if ($conn->query($sql) === TRUE) {
            $message = "Driving school added successfully!";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $error_message = "Error uploading picture.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Driving School</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('admin_navbar.php'); ?>

    <div class="container mt-5 mb-5">
        <h2>Add Driving School</h2>
        <?php
        if (isset($message)) {
            echo "<p style='color: green;'>$message</p>";
        }
        if (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
        ?>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="school_name">School Name:</label>
                <input type="text" class="form-control" name="school_name" required>
            </div>
            <div class="form-group">
                <label for="contact_info">Contact Info:</label>
                <input type="number" class="form-control" name="contact_info" required>
            </div>
            <div class="form-group">
                <label for="about_us">About Us:</label>
                <textarea class="form-control" name="about_us" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="services">Services:</label>
                <textarea class="form-control" name="services" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="picture">Picture:</label>
                <input type="file" class="form-control-file" name="picture" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Add School</button>
            <a href="view_schools.php" class="btn btn-secondary">View Schools</a>
        </form>
    </div>

    <!-- Add Bootstrap JS scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
