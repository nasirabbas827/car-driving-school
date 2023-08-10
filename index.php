<!DOCTYPE html>
<html>
<head>
    <title>Online Car Driving School</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <style>
.jumbotron {
    background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.pexels.com/photos/58724/pexels-photo-58724.jpeg?auto=compress&cs=tinysrgb&w=600');
    background-size: cover;
    background-position: center;
    color: white;
    padding: 100px 0; /* Adjust the padding as needed */
    text-align: center;
}

    </style>
</head>
<body>

<?php include('navbar.php'); ?>

<div class="jumbotron jumbotron-fluid">
    <div class="container text-center">
        <h1 class="display-4">Welcome to Our Car Driving School</h1>
        <p class="lead">Get started on your journey to safe and confident driving.</p>
        <a href="login.php" class="btn btn-light btn-lg">Enroll Now</a>
    </div>
</div>

<div class="container mt-5">
    <h2>Our Training Teachers</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <img src="https://images.pexels.com/photos/804128/pexels-photo-804128.jpeg?auto=compress&cs=tinysrgb&w=600" class="card-img-top" alt="Driving Teacher 1">
                <div class="card-body">
                    <h5 class="card-title">John Smith</h5>
                    <p class="card-text">Experienced driving instructor with a focus on safe and confident driving.</p>
                    <a href="login.php" class="btn btn-primary">Learn More</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="https://images.pexels.com/photos/787476/pexels-photo-787476.jpeg?auto=compress&cs=tinysrgb&w=600" class="card-img-top" alt="Driving Teacher 2">
                <div class="card-body">
                    <h5 class="card-title">Emily Johnson</h5>
                    <p class="card-text">Passionate about teaching new drivers the skills they need for the road.</p>
                    <a href="login.php" class="btn btn-primary">Learn More</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="https://images.pexels.com/photos/2608372/pexels-photo-2608372.jpeg?auto=compress&cs=tinysrgb&w=600" class="card-img-top" alt="Driving Teacher 3">
                <div class="card-body">
                    <h5 class="card-title">Michael Brown</h5>
                    <p class="card-text">Dedicated to helping students become confident and responsible drivers.</p>
                    <a href="login.php" class="btn btn-primary">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</div>


<footer class="mt-5 py-3 bg-light">
    <div class="container text-center">
        <p>&copy; 2023 Online Car Driving School. All rights reserved.</p>
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
