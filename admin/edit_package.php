<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

if (isset($_GET['id'])) {
    $packageId = $_GET['id'];
    
    // Fetch package details
    $selectSql = "SELECT * FROM Packages WHERE package_id = $packageId";
    $result = $conn->query($selectSql);
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // Update package details
        if (isset($_POST['update'])) {
            $packageName = $_POST['package_name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $duration = $_POST['training_duration'];
            
            $updateSql = "UPDATE Packages SET 
                          package_name = '$packageName', 
                          description = '$description', 
                          price = '$price', 
                          training_duration = '$duration' 
                          WHERE package_id = $packageId";
            
            if ($conn->query($updateSql) === TRUE) {
                $message = "Package details updated successfully!";
            } else {
                $error_message = "Error updating package: " . $conn->error;
            }
        }
    } else {
        $error_message = "Package not found.";
    }
} else {
    header("Location: view_packages.php");
    exit();
}
?>

<?php include('admin_navbar.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Package</title>
</head>
<body>
    <h2>Edit Package</h2>
    <?php
    if (isset($message)) {
        echo "<p style='color: green;'>$message</p>";
    }
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>
    <form method="post" action="">
        Package Name: <input type="text" name="package_name" value="<?php echo $row['package_name']; ?>"><br>
        Description: <textarea name="description"><?php echo $row['description']; ?></textarea><br>
        Price: <input type="number" name="price" value="<?php echo $row['price']; ?>"><br>
        Training Duration: <input type="text" name="training_duration" value="<?php echo $row['training_duration']; ?>"><br>
        <input type="submit" name="update" value="Update Package">
    </form>
</body>
</html>
