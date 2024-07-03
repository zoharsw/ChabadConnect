<!DOCTYPE html>
<html>
<head>
    <title>Volunteer Route Optimization</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=PeDBlZa9wIPIW00rmL8d~R3plHg-NspxTV77UkJMqFw~AqADMV2ORnfyPBXVhwQNWp4YGL-tszl6Lieau2OucGBFqAiaPupyva9P61h1nGlV&culture=he-IL' async defer></script>

    <style>
        .directionsContainer {
            width: 35%;
            height: 100%;
            overflow-y: auto;
            float: right;
            margin-right: 5px;
        }
        .directionsPanel {
            margin-right: 5px;
        }
        #myMap {
            position: relative;
            width: 60%;
            height: 40%;
            float: left;
        }
        @media screen and (max-width: 540px) {
            .directionsContainer {
                clear: both;
                width: 100%;
                height: 30%;
            }
            #myMap {
                width: 100%;
                height: 60%;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="col-sm-6 container-fluid directionsContainer" dir="rtl" lang="he">
            <div id="directionsPanel"></div>
            <div id="directionsItinerary"></div>
        </div>
        <div class="col-sm-6" id="myMap"></div>
    </div>

    <script type='text/javascript'>
        var map, directionsManager, searchManager;

        function GetMap() {
            map = new Microsoft.Maps.Map('#myMap', {});

            // Load the directions module.
            Microsoft.Maps.loadModule('Microsoft.Maps.Directions', function () {
                // Create an instance of the directions manager.
                directionsManager = new Microsoft.Maps.Directions.DirectionsManager(map);

                // Specify where to display the route instructions.
                directionsManager.setRenderOptions({ itineraryContainer: '#directionsItinerary' });

                // Specify where to display the input panel.
                directionsManager.showInputPanel('directionsPanel');
                
                directionsManager.setRequestOptions({
                    culture: 'he-IL'
                });


                // Load the search module.
                Microsoft.Maps.loadModule('Microsoft.Maps.Search', function () {
                    searchManager = new Microsoft.Maps.Search.SearchManager(map);
                    directionsManager.setSearchManager(searchManager);
                });
            });

            var pins = [];

            // Single click event handler to show coordinates.
            Microsoft.Maps.Events.addHandler(map, 'click', function (e) {
                var point = new Microsoft.Maps.Point(e.getX(), e.getY());
                var loc = e.target.tryPixelToLocation(point);

                // Display coordinates in the console (or you can display them on the map or an element).
                console.log("Coordinates: ", loc.latitude, loc.longitude);

                // Optionally display the coordinates on the map.
                // var infobox = new Microsoft.Maps.Infobox(loc, { title: 'Coordinates', description: 'Lat: ' + loc.latitude + ', Lon: ' + loc.longitude });
                // infobox.setMap(map);
            });

            // Double-click event handler to add a pin.
            Microsoft.Maps.Events.addHandler(map, 'click', function (e) {
                var point = new Microsoft.Maps.Point(e.getX(), e.getY());
                var loc = e.target.tryPixelToLocation(point);

                var pin = new Microsoft.Maps.Pushpin(loc, {
                    icon: './Image/Loc.png',
                    anchor: new Microsoft.Maps.Point(12, 36)
                });

                // Add the pin to the map and the pins array.
                map.entities.push(pin);
                pins.push(pin);
                


                // Attach a right-click event handler to remove the pin.
                Microsoft.Maps.Events.addHandler(pin, 'click', function () {
                    var index = pins.indexOf(pin);
                    if (index > -1) {
                        map.entities.remove(pin);
                        pins.splice(index, 1);
                    }
                });
            });
        }
    </script>
</body>
</html>
