<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.html");
    exit();
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'menu.php'; ?>
    <link rel="stylesheet" href="./css/Show_NeedyDetails.css">
    <link rel="stylesheet" href="./css/styles.css">
    <title>Assistance List</title>
</head>
<body>
    <h1>Assistance List</h1> 
    <div class="needy-container">
        <?php
            require_once "Fetch_Needy.php"; // Include the script to fetch needy data
            
            // Fetch all needys
            $allNeedys = fetch_all_needys();
            $totalRecords = get_total_records();
            $recordsPerPage = 5;
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $totalPages = ceil($totalRecords / $recordsPerPage);

            // Check if there are needys available
            if (empty($allNeedys)) {
                echo '<p>No people in need data available.</p>';
            } else {
                // Calculate the starting and ending record indices for the current page
                $startIndex = ($currentPage - 1) * $recordsPerPage;
                $endIndex = min($startIndex + $recordsPerPage, $totalRecords);

                // Loop through the needys for the current page and display them
                for ($i = $startIndex; $i < $endIndex; $i++) {
                    $needy = $allNeedys[$i];
                    echo '<div class="needy-item">';
                    echo '<h3>Full Name: ' . $needy['FullName'] . '</h3>';
                    echo '<p>City: ' . $needy['NeedyCity'] . '</p>';
                    echo '<p>Address: ' . $needy['NeedyAddress'] . '</p>';
                    echo '<p>Phone Number: ' . $needy['PhoneNumber'] . '</p>';
                    echo '<p>Day in Week: ' . $needy['DayInWeek'] . '</p>';
                    echo '<p>Age: ' . $needy['Age'] . '</p>';
                    echo '<p>Family Members: ' . $needy['FamilyMembers'] . '</p>';
                    echo '<p>Kind of Help: ' . $needy['KindOfHelp'] . '</p>';
                    echo '<p>Country: ' . $needy['NeedyCountry'] . '</p>';
                    echo '<p>Date of Delivery: ' . $needy['DateOfDelivery'] . '</p>';
                    echo '</div>';
                }
            }
        ?>
    </div>
    <div class="pagination">
        <?php
        if ($currentPage > 1) {
            echo '<a href="?page=' . ($currentPage - 1) . '">Previous</a>';
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $currentPage) {
                echo '<a class="active" href="?page=' . $i . '">' . $i . '</a>';
            } else {
                echo '<a href="?page=' . $i . '">' . $i . '</a>';
            }
        }

        if ($currentPage < $totalPages) {
            echo '<a href="?page=' . ($currentPage + 1) . '">Next</a>';
        }
        ?>
    </div>
    <?php include 'footer.html'; ?>
</body>
</html>
