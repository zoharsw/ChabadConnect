<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="./css/MyVolunteeries.css">
</head>
<body>
    <?php include 'menu.php'; ?>
    <header>
        <script src="./scripts/Myvolunteerings_status.js"></script>
    </header>
    <main>
        <h1>My Volunteering</h1>
        <h2>Your current volunteering assignments and their statuses</h2>
        <div class="volunteering-container">
            <div class="map-container">
                <p>Click here for creating a route:</p>
                <a href="Maps.php">
                    <img src="./Image/MAP4.png" alt="Map Pin" class="map-pin">
                </a>
            </div>
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

            // Get the logged-in user's username from session
            $loggedInUser = $_SESSION['username'];

            // Fetch volunteerings for the logged-in user
            $sql = "SELECT * FROM Volunteering WHERE Volunteer_Name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $loggedInUser);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($volunteering = $result->fetch_assoc()) {
                    echo '<div class="volunteering-item">';
                    echo '<input type="hidden" class="volunteering-id" value="' . htmlspecialchars($volunteering['NumberOfVolunteering']) . '">';
                    echo '<div>Number Of Volunteering: ' . htmlspecialchars($volunteering['NumberOfVolunteering']) . '</div>';
                    echo '<div><p>Full Name: ' . htmlspecialchars($volunteering['FullName']) . '</p></div>';
                    echo '<div><p>City: ' . htmlspecialchars($volunteering['NeedyCity']) . '</p></div>';
                    echo '<div><p>Address: ' . htmlspecialchars($volunteering['NeedyAddress']) . '</p></div>';
                    echo '<div><p>Phone: ' . htmlspecialchars($volunteering['PhoneNumber']) . '</p></div>';
                    echo '<div><p>Day: ' . htmlspecialchars($volunteering['DayInWeek']) . '</p></div>';
                    echo '<div><p>Complete: ' . htmlspecialchars($volunteering['Status']) . '</p></div>';
                    echo '<div><p>Type: ' . htmlspecialchars($volunteering['KindOfHelp']) . '</p></div>';
                    echo '<div class="button-group">';
                    echo '<button class="complete-button" data-volunteering-id="' . htmlspecialchars($volunteering['NumberOfVolunteering']) . '" onclick="updateStatus(this, \'Complete\')">Complete</button>';
                    echo '<button class="incomplete-button" data-volunteering-id="' . htmlspecialchars($volunteering['NumberOfVolunteering']) . '" onclick="updateStatus(this, \'Incomplete\')">Incomplete</button>';
                    
                         if ($volunteering['Volunteer_Name'] == $_SESSION['username']) 
                         {
                            echo '<form method="post" action="CancelVolunteering.php">';
                            echo '<input type="hidden" name="NumberOfVolunteering" value="' . $volunteering['NumberOfVolunteering'] . '">';
                            echo '<button type="submit" name="cancel">Unregister</button>';
                            echo '</form>';
                        } elseif (!is_null($volunteering['Volunteer_Name']) && $volunteering['Volunteer_Name'] != $_SESSION['username']) {
                            echo 'Occupied'; 
                        } else {
                            // Add a form for the user to enter the NumberOfVolunteering and submit
                            echo '<form method="post" action="SubmitVolunteering.php">';
                            echo '<input type="hidden" name="NumberOfVolunteering" value="' . $volunteering['NumberOfVolunteering'] . '">';
                            echo '<button type="submit" name="submit">Register</button>';
                            echo '</form>';
                        }
                    
                    echo '</div>';
                    echo '</div>';
                }
                          
            } else {
                echo '<p>No volunteerings found for the logged-in user.</p>';
            }
            
            $stmt->close();
            $conn->close();
            ?>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include 'footer.html'; ?>
</body>
</html>
