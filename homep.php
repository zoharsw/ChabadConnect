
<!DOCTYPE html>
<html lang="en">

<body>
    <?php include 'menu.php'; ?>
    <section id="welcome">
        <div class="container">
            <div id="hero">
                <h1>Welcome to Chabad Connect</h1>
                <p>Your platform for community, connection, and service.</p>
                <a href="ChooseVolunteering.php" class="btn">Get Involved</a>
            </div>
            <div id="events" class="card">
                <h2>Upcoming Events</h2>
                <div id="event-slider">
                    <div class="event">
                        <img src="./Image/event1.jpg" alt="Event 1">
                        <h3>Food donations</h3>
                        <p>Join us for a food donation event where we will collect food items for families in need within our community. Together, we can ensure that everyone has access to a nutritious meal. Donations will be gathered and distributed with the support of our wonderful volunteers.</p>
                    </div>
                    <div class="event">
                        <img src="./Image/event2.jpg" alt="Event 2">
                        <h3>Packaging</h3>
                        <p>Come be a part of our packaging event where we will pack food  and essential items for families in need. This is a great opportunity to contribute your time and help those in our community. Every small effort makes a big difference.</p>
                    </div>
                </div>
                <button id="prev-btn">Previous</button>
                <button id="next-btn">Next</button>
            </div>
        </div>
    </section>


    <script src="./scripts/homepageJS.js"></script>
    <?php include 'footer.html'; ?>
</body>
</html>
