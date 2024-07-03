<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(array("error" => "Unauthorized"));
    exit();
}

$username = $_SESSION['username'];

// Database connection
$servername = "localhost";
$usernameDb = "iszoharsw_Admin";
$passwordDb = "5xz3tBwAKi2x";
$dbname = "iszoharsw_Volunteersystem";

$conn = new mysqli($servername, $usernameDb, $passwordDb, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array("error" => "Connection failed: " . $conn->connect_error));
    exit();
}

// Fetch the user's volunteering data
$query = "SELECT KindOfHelp, NeedyCity, DayInWeek FROM Volunteering WHERE Volunteer_Name = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array("error" => "Prepare statement failed: " . $conn->error));
    exit();
}
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$volunteerData = [];
while ($row = $result->fetch_assoc()) {
    $volunteerData[] = $row;
}

$stmt->close();
$conn->close();

// Write data to CSV file
$csvFileName = './DataVolunteer.csv';
$file = fopen($csvFileName, 'w'); // Open file for writing, clears existing content
if ($file === false) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array("error" => "Failed to open file: $csvFileName"));
    exit();
}

// Write headers
fputcsv($file, array('KindOfHelp', 'NeedyCity', 'DayInWeek'));

// Write each row to CSV
foreach ($volunteerData as $row) {
    fputcsv($file, $row);
}
fclose($file);
?>