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

$records_per_page = 5; // Number of records per page
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
$offset = ($current_page - 1) * $records_per_page; // Calculate the offset for SQL query

$needys = array();

// SQL query to fetch data with LIMIT and OFFSET for pagination
$sql = "SELECT ID, FullName, PhoneNumber, NeedyCity, NeedyAddress, DayInWeek, Age, FamilyMembers, KindOfHelp, NeedyCountry, DateOfDelivery 
        FROM PeopleInNeed ORDER BY FullName ASC
        LIMIT $records_per_page OFFSET $offset";

$result = $conn->query($sql);

// Check if there are rows returned
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $needy = array(
            'ID' => $row['ID'],
            'FullName' => $row['FullName'],
            'PhoneNumber' => $row['PhoneNumber'],
            'NeedyCity' => $row['NeedyCity'],
            'NeedyAddress' => $row['NeedyAddress'],
            'DayInWeek' => $row['DayInWeek'],
            'Age' => $row['Age'],
            'FamilyMembers' => $row['FamilyMembers'],
            'KindOfHelp' => $row['KindOfHelp'],
            'NeedyCountry' => $row['NeedyCountry'],
            'DateOfDelivery' => $row['DateOfDelivery']
        );

        $needys[] = $needy;
    }
} else {
    echo json_encode(array('error' => 'No People in Need exist'));
}

// Fetch the total number of records for pagination
$sql_count = "SELECT COUNT(*) AS total FROM PeopleInNeed";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_records = $row_count['total'];

$conn->close(); 

// Function to fetch all needys
function fetch_all_needys() {
    global $needys;
    return $needys;
}

// Function to get total records
function get_total_records() {
    global $total_records;
    return $total_records;
}
?>
