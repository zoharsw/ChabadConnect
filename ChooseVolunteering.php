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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Volunteering</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/chooseVolunteering.css">
    <?php include 'VolunteerDb.php';?>
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4">
            <h2 class="mb-4 text-center">Volunteering Registration</h2>
            <div id="predictionResults" class="alert alert-info" style="display: none;">
                <div id="predictedData"></div>
            </div>
            <form id="volunteeringForm" method="post" action="FetchUserVolunteering.php">
                <div class="mb-3">
                    <label for="VolunteeringType" class="form-label">Please select a volunteer type:</label>
                    <select id="VolunteeringType" name="VolunteeringType" class="form-select">
                        <option value="" disabled selected hidden>Choose</option>
                        <option value="Packing food baskets">Packing food baskets</option>
                        <option value="Transporting food packages">Transporting food packages</option>

                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Choose your favorite cities:</label><br>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="favoriteCities[]" id="Holon" value="Holon">
                        <label class="form-check-label" for="Holon">Holon</label><br>
                        <input class="form-check-input" type="checkbox" name="favoriteCities[]" id="TelAviv" value="Tel Aviv">
                        <label class="form-check-label" for="TelAviv">Tel Aviv</label><br>
                        <input class="form-check-input" type="checkbox" name="favoriteCities[]" id="RishonLezion" value="Rishon Lezion">
                        <label class="form-check-label" for="RishonLezion">Rishon Lezion</label><br>
                        <input class="form-check-input" type="checkbox" name="favoriteCities[]" id="BatYam" value="Bat Yam">
                        <label class="form-check-label" for="BatYam">Bat Yam</label><br>
                        <input class="form-check-input" type="checkbox" name="favoriteCities[]" id="NessZiona" value="Ness Ziona">
                        <label class="form-check-label" for="NessZiona">Ness Ziona</label><br>

                    </div>
                </div>
                <div class="mb-3">
                    <label for="Day" class="form-label">Choose a favorite day:</label>
                    <select id="Day" name="Day" class="form-select">
                        <option value="" disabled selected hidden>Choose</option>
                        <option value="Sunday">Sunday</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>

                    </select>
                </div>
                <div class='text-center'>
                    <button type="button" id="finish" class="btn btn-primary">Search</button>
                    <button type="button" id="cancel" class="btn btn-secondary" onclick="clearSelections()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      document.getElementById('finish').addEventListener('click', function() {
            var selectedDay = document.getElementById('Day').value;
            var selectedType = document.getElementById('VolunteeringType').value;
            var selectedCities = [];
            document.querySelectorAll('input[name="favoriteCities[]"]:checked').forEach(function(checkbox) {
                selectedCities.push(checkbox.value);
            });
            window.location.href = 'VolunteerOptions.php?day=' + selectedDay + '&type=' + selectedType + '&cities=' + selectedCities.join(',');
        });

        document.addEventListener('DOMContentLoaded', function() {
            var confirmation = confirm("Do you want to apply options based on your recent volunteeries?");
            if (confirmation) {
                fetch('Predict.csv')
                    .then(response => response.text())
                    .then(csvData => {
                        var lines = csvData.split('\n');
                        if (lines.length > 1) {
                            var headers = lines[0].split(',');
                            var values = lines[1].split(',');

                            var predictedData = {
                                KindOfHelp: values[headers.indexOf('PredictedKindOfHelp')].replace(/"/g, ''),
                                NeedyCity: values[headers.indexOf('PredictedNeedyCity')].replace(/"/g, ''),
                                DayInWeek: values[headers.indexOf('PredictedDayInWeek')].replace(/"/g, '')
                            };

                    
                            fillForm(predictedData);
                        } else {
                            console.error('No data found or invalid format in Predict.csv.');
                        }
                    })
                    .catch(error => console.error('Error fetching or parsing Predict.csv:', error));
            }
        });


        function fillForm(data) {
            document.getElementById('VolunteeringType').value = data.KindOfHelp;
            var favoriteCities = data.NeedyCity.split(',').map(city => city.trim());
            favoriteCities.forEach(city => {
                document.getElementById(city.replace(/\s+/g, '')).checked = true;
            });
            document.getElementById('Day').value = data.DayInWeek;
        }
        
            function clearSelections() {
            document.getElementById('VolunteeringType').selectedIndex = 0; // Reset select to first option
            document.querySelectorAll('input[name="favoriteCities[]"]:checked').forEach(function(checkbox) {
                checkbox.checked = false; // Uncheck all checkboxes
            });
            document.getElementById('Day').selectedIndex = 0; // Reset select to first option
        }
    </script>
    <?php include 'footer.html'; ?>
</body>
</html>
