<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost"; 
    $usernameDb = "iszoharsw_Admin"; 
    $passwordDb = "5xz3tBwAKi2x"; 
    $dbname = "iszoharsw_Volunteersystem"; 

    // Create connection
    $conn = new mysqli($servername, $usernameDb, $passwordDb, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get volunteer details from session
    $username = $_SESSION['username'];

    // Sanitize the input from POST data
    $num_of_volunteering = $conn->real_escape_string($_POST['NumberOfVolunteering']);

    // Get volunteer details from Volunteers table
    $sql = "SELECT * FROM Volunteers WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result === FALSE) {
        echo "Error: " . $conn->error;
    }     

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_volunteer = $row['IDVolunteer'];
        $phone_number = $row['PhoneNumberVolunteer'];

        // Update Volunteering table
        $sql_update = "UPDATE Volunteering SET Volunteer_Name = '$username', IDVolunteer = '$id_volunteer', PhoneNumberVolunteer = '$phone_number' WHERE NumberOfVolunteering = '$num_of_volunteering' AND (Volunteer_Name IS NULL OR Volunteer_Name = '')";
        
        if ($conn->query($sql_update) === TRUE) {
            // Redirect back to volunteer table page
            header("Location: VolunteerOptions.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Volunteer details not found.";
    }
    
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
