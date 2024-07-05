<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'menu.php'; ?>
    <title>Volunteer Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/Assistance.css">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center">Volunteer Management System</h1>
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card option-card">
                    <div class="card-body">
                        <h2 class="card-title">Add New Assistance</h2>
                        <p class="card-text">Register a new individual in need of assistance.</p>
                        <a href="NeedyDetails.php" class="btn btn-primary">Add Assistance</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card option-card">
                    <div class="card-body">
                        <h2 class="card-title">View Full List</h2>
                        <p class="card-text">See the complete list of registered individuals</p>
                        <a href="Show_NeedyDetails.php" class="btn btn-primary">View List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <?php include 'footer.html'; ?>
</body>
</html>
