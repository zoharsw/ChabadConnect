<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "iszoharsw_Admin";
$password = "5xz3tBwAKi2x";
$dbname = "iszoharsw_Volunteersystem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['NumberOfVolunteering']) && isset($_POST['Status'])) {
    $volunteeringId = $_POST['NumberOfVolunteering'];
    $status = $_POST['Status'];

    $sql = "UPDATE Volunteering SET Status = '$status' WHERE NumberOfVolunteering = '$volunteeringId' ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $volunteeringId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Status changed.";
    } else {
        echo "Status didn't change.";
    }

    $stmt->close();
}

$conn->close();
?>
