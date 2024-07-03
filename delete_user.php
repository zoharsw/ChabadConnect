<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "iszoharsw_Admin";
$password = "5xz3tBwAKi2x";
$dbname = "iszoharsw_Volunteersystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the username from the session
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // SQL to delete the user
    $sql = "DELETE FROM Volunteers WHERE username = '$username'";

    // Prepare and bind
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        // Optionally, you can destroy the session after deletion
        session_destroy();
        // Redirect to login page or another page
        header("Location: login.php");
        exit();
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "No user found in session.";
}

$conn->close();
?>
