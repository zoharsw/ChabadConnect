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
    <link rel="stylesheet" href="./css/PersonalDetails.css">
</head>
<body>
    <?php include 'menu.php'; ?>
    <h2>Personal Details</h2>
    <table>
        <?php
            // Database connection
            $servername = "localhost";
            $username = "iszoharsw_Admin";
            $password = "5xz3tBwAKi2x";
            $dbname = "iszoharsw_Volunteersystem";

            // Create connection
            $connection = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }

            // Retrieve personal details from Volunteers table
            $username = $_SESSION['username'];
            $query = "SELECT * FROM Volunteers WHERE username = '$username'";
            $result = $connection->query($query);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>Full name:</td><td>" . $row["username"] . "</td></tr>";
                    echo "<tr><td>IDVolunteer:</td><td>" . $row["IDVolunteer"] . "</td></tr>";
                    echo "<tr><td>Cell phone number:</td><td>" . $row["PhoneNumberVolunteer"] . "</td></tr>";
                    echo "<tr><td>Age:</td><td>" . $row["YearBirth"] . "</td></tr>";
                    echo "<tr><td>Email:</td><td>" . $row["EmailAddress"] . "</td></tr>";
                    echo "<tr><td>Residential Address:</td><td>" . $row["CitiesOfVolunteer"] . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No volunteer found</td></tr>";
            }
            $connection->close();
        ?>
    </table>
    <div class="button-container">
        <a href="MyVolunteeries.php" class="btn btn-primary">My volunteeries</a>
       <form action="delete_user.php" method="POST">
        <button class="btn btn-primary" >Delete Account</button>
        </form>
        <p></p>
    </div>
    <div>  </div>
  <?php include 'footer.html'; ?>
</body>
</html>
