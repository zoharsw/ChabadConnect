<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];

require_once "FetchMyVolunteeries.php"; // Include the script to fetch volunteering data

// Initialize variables
$errorMessage = '';

// Check if the necessary parameters are provided in the request
if (isset($_GET['day'], $_GET['type'], $_GET['cities'])) {
    $day = $_GET['day'];
    $type = $_GET['type'];
    $cities = explode(',', $_GET['cities']); // Convert cities to array
    
    // Fetch volunteerings for the specified filters
    $filteredVolunteerings = Fetch_volunteerings($day, $type, $cities);
    
    // Check if there are volunteerings available for the specified filters
    if (empty($filteredVolunteerings)) {
        // Set the error message for JavaScript handling
        $errorMessage = 'No volunteering data available for the specified criteria.';
    }
} else {
    $errorMessage = 'Your request has been changed';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteering Options</title>
    <link rel="stylesheet" href="./css/VolunteerOptions.css">
    <link rel="stylesheet" href="./css/styles.css">


   
    
    <script>
        function confirmCancel(form) {
            var confirmation = confirm("Are you sure you want to cancel?");
            if (confirmation) {
                form.submit();
            } else {
                return false;
            }
        }

        function confirmSubmit(form) {
            var confirmation = confirm("Are you sure you want to submit?");
            if (confirmation) {
                form.submit();
            } else {
                return false;
            }
        }

        // JavaScript function to show error message as a popup
        function showErrorPopup(message) {
            alert(message);
        }

        // JavaScript function to check if there's an error message to display
        window.onload = function() {
            var errorMessage = "<?php echo addslashes($errorMessage); ?>";
            if (errorMessage !== "") {
                showErrorPopup(errorMessage);
            }
        };
    </script>
    
</head>
<body>

    <div class="volunteering-container">
        <?php
        if (empty($filteredVolunteerings)) {
            echo '<div class="no-data-message">';
            echo 'No volunteering data available for the specified criteria.<br /> Please return to explore additional volunteer opportunities.';
            echo '</div>';
        } 
        else {
            // Loop through the filtered volunteerings and display them
            foreach ($filteredVolunteerings as $volunteering) {
                echo '<div class="volunteering-item">';
                echo '<h3>Number of Volunteering: ' . htmlspecialchars($volunteering['NumberOfVolunteering']) . '</h3>';
                echo '<p>Full Name: ' . htmlspecialchars($volunteering['FullName']) . '</p>';
                echo '<p>City: ' . htmlspecialchars($volunteering['NeedyCity']) . '</p>';
                echo '<p>Address: ' . htmlspecialchars($volunteering['NeedyAddress']) . '</p>';
                echo '<p>Phone Number: ' . htmlspecialchars($volunteering['PhoneNumber']) . '</p>';
                echo '<p>Day in Week: ' . htmlspecialchars($volunteering['DayInWeek']) . '</p>';
                echo '<p>Notes: ' . htmlspecialchars($volunteering['Notes']) . '</p>';
                echo '<p>Status: ' . htmlspecialchars($volunteering['Status']) . '</p>';
                echo '<p>Volunteering Type: ' . htmlspecialchars($volunteering['VolunteeringType']) . '</p>';

                // Check if the volunteering is already taken
                if ($volunteering['VolunteerName'] == $username) {
                    echo '<form method="post" action="CancelVolunteering.php" onsubmit="return confirmCancel(this);">';
                    echo '<input type="hidden" name="NumberOfVolunteering" value="' . htmlspecialchars($volunteering['NumberOfVolunteering']) . '">';
                    echo '<button type="submit" name="cancel">Unregister</button>';
                    echo '</form>';
                } elseif (!is_null($volunteering['VolunteerName']) && $volunteering['VolunteerName'] != $username) {
                    echo '<p class="occupied">Occupied</p>'; 
                } else {
                    echo '<form method="post" action="SubmitVolunteering.php" onsubmit="return confirmSubmit(this);">';
                    echo '<input type="hidden" name="NumberOfVolunteering" value="' . htmlspecialchars($volunteering['NumberOfVolunteering']) . '">';
                    echo '<button type="submit" name="submit">Register</button>';
                    echo '</form>';
                }
                echo '</div>';
            }
        }
        ?>
    </div>
    <div class="back-button">
        <a href="ChooseVolunteering.php" class="btn btn-secondary">Back</a>
    </div>
    
    <?php include 'footer.html'; ?>
</body>
</html>
