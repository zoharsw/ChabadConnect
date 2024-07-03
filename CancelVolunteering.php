<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];

if (isset($_POST['cancel']) && isset($_POST['NumberOfVolunteering'])) {
    $numberOfVolunteering = $_POST['NumberOfVolunteering'];
    
    // Database connection
    $servername = "localhost"; 
    $usernameDb = "iszoharsw_Admin"; 
    $passwordDb = "5xz3tBwAKi2x"; 
    $dbname = "iszoharsw_Volunteersystem"; 
    
    $conn = new mysqli($servername, $usernameDb, $passwordDb, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the volunteering record to remove the volunteer's name
    $query = "UPDATE Volunteering SET Volunteer_Name = NULL, IDVolunteer = NULL, PhoneNumberVolunteer = NULL WHERE NumberOfVolunteering = '$numberOfVolunteering' AND Volunteer_Name = '$username'";

    if ($conn->query($query) === TRUE) {
        // Redirect back to volunteer table page
        header("Location: VolunteerOptions.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
