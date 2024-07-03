<?php
session_start();

// Database connection
$servername = "localhost";
$username = "iszoharsw_Admin";
$password = "5xz3tBwAKi2x";
$dbname = "iszoharsw_Volunteersystem";

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Retrieve username and password from POST request
$username = $_POST['username'];
$password = $_POST['password'];

// Perform database query to check if username and password are valid
$query = "SELECT * FROM Volunteers WHERE username = '$username' AND password = '$password'";
$result = $connection->query($query);

if ($result->num_rows == 1) {
    // Authentication successful
    $row = $result->fetch_assoc();
    $_SESSION['username'] = $username;
    $_SESSION['permission'] = $row['Permmision']; // Store permission in session
    echo "success";
} else {
    // Authentication failed
    echo "error";
}

$connection->close();
?>
