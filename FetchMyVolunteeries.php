<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php include 'menu.php'; ?>
</html>

<?php
// Database connection
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

$volunteerings = array();

$sql = "SELECT NumberOfVolunteering, Status, FullName, PhoneNumber, NeedyCity, NeedyAddress, DayInWeek, Notes, KindOfHelp, Volunteer_Name, IDVolunteer, PhoneNumberVolunteer FROM Volunteering";

$result = $conn->query($sql);

// Check if there are rows returned
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $volunteering = array(
            'NumberOfVolunteering' => $row['NumberOfVolunteering'],
            'FullName' => $row['FullName'],
            'NeedyCity' => $row['NeedyCity'],
            'NeedyAddress' => $row['NeedyAddress'],
            'PhoneNumber' => $row['PhoneNumber'],
            'DayInWeek' => $row['DayInWeek'],
            'Notes' => $row['Notes'],
            'Status' => $row['Status'],
            'VolunteerName' => $row['Volunteer_Name'],
            'IDVolunteer' => $row['IDVolunteer'],
            'PhoneNumberVolunteer' => $row['PhoneNumberVolunteer'],
            'VolunteeringType' => $row['KindOfHelp']
        );

        $volunteerings[] = $volunteering;
    }
} else {
    echo json_encode(array('error' => 'No Volunteerings exist'));
}

// Close the database connection
$conn->close(); 

// Define the function to fetch volunteerings based on filters
function fetch_volunteerings($day, $type, $cities) {
    global $volunteerings;

    // Filter volunteerings by the specified criteria
    $filteredVolunteerings = array_filter($volunteerings, function($vol) use ($day, $type, $cities) {
        return $vol['DayInWeek'] == $day && $vol['VolunteeringType'] == $type && in_array($vol['NeedyCity'], $cities);
    });

    return $filteredVolunteerings;
}
?>


