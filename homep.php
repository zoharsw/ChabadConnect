<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chabad Connect</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'menu.php'; ?>
    <section id="welcome">
        <div class="container">
            <div id="hero" class="text-center py-5">
                <h1>Welcome to Chabad Connect</h1>
                <p>Your platform for community, connection, and service.</p>
                <a href="ChooseVolunteering.php" class="btn btn-primary">Get Involved</a>
            </div>
            <div id="events" class="card my-5">
                <div class="card-body">
                    <h2 class="card-title">Upcoming Events</h2>
                    <div id="event-slider" class="row">
                        <div class="col-md-6 col-lg-4 event">
                            <img src="./Image/event1.jpg" class="d-block w-100" alt="Event 1">
                            <h3>Food donations</h3>
                            <p>Join us for a food donation event where we will collect food items for families in need within our community. Together, we can ensure that everyone has access to a nutritious meal. Donations will be gathered and distributed with the support of our wonderful volunteers.</p>
                        </div>
                        <div class="col-md-6 col-lg-4 event">
                            <img src="./Image/event2.jpg" class="d-block w-100" alt="Event 2">
                            <h3>Packaging</h3>
                            <p>Come be a part of our packaging event where we will pack food and essential items for families in need. This is a great opportunity to contribute your time and help those in our community. Every small effort makes a big difference.</p>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button id="prev-btn" class="btn btn-secondary">Previous</button>
                        <button id="next-btn" class="btn btn-secondary">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="./scripts/homepageJS.js"></script>
    <?php include 'footer.html'; ?>
</body>
</html>
