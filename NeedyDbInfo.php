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

// Calculate DateOfDelivery
function getNextDateOfWeek($dayInWeek) {
    $dayOfWeekMap = [
        'Sunday' => 0,
        'Monday' => 1,
        'Tuesday' => 2,
        'Wednesday' => 3,
        'Thursday' => 4,
        'Friday' => 5,
        'Saturday' => 6
    ];

    $currentDate = new DateTime();
    $currentDayOfWeek = $currentDate->format('w'); // Numeric representation of the day of the week (0 for Sunday, 6 for Saturday)
    $dayOfWeek = $dayOfWeekMap[$dayInWeek];

    $daysUntilNext = ($dayOfWeek - $currentDayOfWeek + 7) % 7;
    if ($daysUntilNext == 0) {
        $daysUntilNext = 7;
    }

    $currentDate->modify("+$daysUntilNext days");
    return $currentDate->format('Y-m-d');
}

// Update DateOfDelivery for all records in PeopleInNeed
$sql_get_all = "SELECT ID, DayInWeek FROM PeopleInNeed";
$result_all = $conn->query($sql_get_all);

if ($result_all->num_rows > 0) {
    while($row = $result_all->fetch_assoc()) {
        $ID = $row['ID'];
        $DayInWeek = $row['DayInWeek'];
        $DateOfDelivery = getNextDateOfWeek($DayInWeek);

        $sql_update = "UPDATE PeopleInNeed SET DateOfDelivery = '$DateOfDelivery' WHERE ID = '$ID'";
        $conn->query($sql_update);
    }
}

// Retrieve form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $FullName = $_POST['FullName'];
    $ID = $_POST['ID'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $Age = $_POST['Age'];
    $NeedyCountry = $_POST['NeedyCountry'];
    $NeedyAddress = $_POST['NeedyAddress'];
    $NeedyCity = $_POST['NeedyCity'];
    $KindOfHelp = $_POST['KindOfHelp'];
    $DayInWeek = $_POST['DayInWeek'];
    $FamilyMembers = $_POST['FamilyMembers'];

    $DateOfDelivery = getNextDateOfWeek($DayInWeek);

    // Check if there are any existing rows in the Volunteering table
    $sql_check = "SELECT COUNT(*) AS count FROM Volunteering";
    $result_check = $conn->query($sql_check);
    $row = $result_check->fetch_assoc();
    $count = $row['count'];

    // Set the value of $NumberOfVolunteering accordingly
    if ($count == 0) {
        $NumberOfVolunteering = 1;
    } else {
        $NumberOfVolunteering = $count + 1;
    }

    // Prepare SQL statement for inserting data into PeopleInNeed table
    $sql_people_in_need = "INSERT INTO PeopleInNeed (FullName, ID, PhoneNumber, Age, NeedyCountry, NeedyAddress, NeedyCity, KindOfHelp, DayInWeek, FamilyMembers, DateOfDelivery)
        VALUES ('$FullName', '$ID', '$PhoneNumber', '$Age', '$NeedyCountry', '$NeedyAddress', '$NeedyCity', '$KindOfHelp', '$DayInWeek', '$FamilyMembers', '$DateOfDelivery')";

    if ($conn->query($sql_people_in_need) === FALSE) {
        echo "Cannot add new Needy details. Error is: " . $conn->error;
        exit();
    } else {
        echo "New User was added";
    }

    // Prepare SQL statement for inserting data into Volunteering table
    $sql_volunteering = "INSERT INTO Volunteering (NumberOfVolunteering, FullName, PhoneNumber, NeedyCountry, NeedyCity, NeedyAddress, DayInWeek, KindOfHelp)
        VALUES ('$NumberOfVolunteering', '$FullName', '$PhoneNumber', '$NeedyCountry', '$NeedyCity', '$NeedyAddress', '$DayInWeek', '$KindOfHelp')";

    if ($conn->query($sql_volunteering) === FALSE) {
        echo "Cannot add new volunteering details. Error is: " . $conn->error;
        exit();
    }
}

$conn->close();
?>
