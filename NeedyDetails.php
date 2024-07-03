<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'menu.php'; ?>
    <title>Assistance Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0rT60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <link rel="stylesheet" href="./css/NeedyDetails.css">
    <link rel="stylesheet" href="./css/styles.css">
    <script src="../scripts/needy.js"></script>
</head>
<body>
    <main>
        <h2>Registration of new assistance</h2>
        <form id="registrationForm" method="post">
            <section>
                <label for="FullName">Full Name:</label><br>
                <input type="text" id="FullName" name="FullName" required><br><br>
            </section>
            <section>
                <label for="ID">ID:</label><br>
                <input type="number" id="ID" name="ID" required><br><br>
            </section>
            <section>
                <label for="PhoneNumber">Phone Number:</label><br>
                <input type="tel" id="PhoneNumber" name="PhoneNumber" required><br><br>
            </section>
            <section>
                <label for="Age">Age:</label><br>
                <input type="number" id="Age" name="Age" required><br><br>
            </section>
            <section>
                <label for="NeedyCountry">Country:</label><br>
                <input type="text" id="NeedyCountry" name="NeedyCountry" required><br><br>
            </section>
            <section>
                <label for="NeedyCity">City:</label><br>
                <select id="NeedyCity" name="NeedyCity" required>
                    <option value="" disabled selected hidden>Choose</option>
                    <option value="Holon">Holon</option>
                    <option value="Tel Aviv">Tel Aviv</option>
                    <option value="Rishon Lezion">Rishon Lezion</option>
                    <option value="Bat Yam">Bat Yam</option>
                    <option value="Ness Ziona">Ness Ziona</option>
                </select><br><br>
            </section>
            <section>
                <label for="NeedyAddress">Street Address:</label><br>
                <input type="text" id="NeedyAddress" name="NeedyAddress" required><br><br>
            </section>
            <section>
                <label for="KindOfHelp">Kind of Help:</label><br>
                <select id="KindOfHelp" name="KindOfHelp" required>
                    <option value="" disabled selected hidden>Choose</option>
                    <option value="Packing food baskets">Packing food baskets</option>
                    <option value="Transporting food packages">Transporting food packages</option>
                </select><br><br>
            </section>
            <section>
                <label for="DayInWeek">Day In Week:</label><br>
                <select id="DayInWeek" name="DayInWeek" required>
                    <option value="" disabled selected hidden>Choose</option>
                    <option value="Sunday">Sunday</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                </select><br><br>
            </section>
            <section>
                <label for="FamilyMembers">Number of Family Members:</label><br>
                <input type="number" id="FamilyMembers" name="FamilyMembers" required><br><br>
            </section>
            <div class='button'>
                <button type="submit">Register</button>
                <button type="reset">Cancel</button>
            </div>
        </form>
    </main>
    <div id="clear"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#registrationForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'NeedyDbInfo.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
     <?php include 'footer.html'; ?>
</body>
</html>
