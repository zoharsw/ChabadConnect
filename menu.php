<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <title>Chabad Connect</title>
</head>
<body>
    <header>
        <div class="container">
            <div id="logo">
                <a href="homep.php">
                   <img src="./Image/logo.png" alt="Chabad Connect Logo">
                </a>
                <span>Chabad Connect</span>
            </div>
            <div class="hamburger" id="hamburger">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <nav>
                <ul>
                    <li><a href="homep.php" class="active">Home</a></li>
                    <?php if ($_SESSION['username']=== 'admin'): ?>
                        <li><a href="Assistance.php">Community Assistance</a></li>
                    <?php endif; ?>
                    <li><a href="ChooseVolunteering.php">Volunteering</a></li>
                    <li><a href="about.php">About</a></li>
                    <li id="login-section">
                        <?php if (isset($_SESSION['username'])): ?>
                            <form action="logout.php" method="post" style="display: inline;">
                                <button type="submit" class="nav-btn">Logout</button>
                            </form>
                            <div></div>
                            <span style="float:right;" id="user-greeting">
                                Welcome, <a href="PersonalDetails.php"><?php echo $_SESSION['username']; ?></a>
                            </span>
                        <?php else: ?>
                            <a href="login.php" id="login-btn">Login</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <script>
        document.getElementById('hamburger').addEventListener('click', function() {
            document.querySelector('nav ul').classList.toggle('open');
        });
    </script>
</body>
</html>
