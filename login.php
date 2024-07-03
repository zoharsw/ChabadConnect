<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="login-container">
        <h1>Hello Again!</h1>
        <form id="login-form">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
    </div>

    <script src="./scripts/login.js"></script>
    <?php include 'footer.html'; ?>
</body>
</html>
