document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.login-container form');
    const passwordInput = document.querySelector('#password');
    const usernameInput = document.querySelector('#username');
    const errorMessage = document.createElement('div');
    errorMessage.style.color = 'red';
    errorMessage.style.marginBottom = '20px';
    form.insertBefore(errorMessage, passwordInput);

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const password = passwordInput.value;
        const username = usernameInput.value;

        if (!validatePassword(password)) {
            errorMessage.textContent = 'Password must be at least 8 characters long, contain at least one number, and at least one uppercase letter.';
        } else {
            errorMessage.textContent = '';
            // If password is valid, proceed with the AJAX request to authenticate
            authenticateUser(username, password);
        }
    });

    function validatePassword(password) {
        const lengthCheck = password.length >= 8;
        const numberCheck = /[0-9]/.test(password);
        const uppercaseCheck = /[A-Z]/.test(password);
        return lengthCheck && numberCheck && uppercaseCheck;
    }

    function authenticateUser(username, password) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'authenticate.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    if (xhr.responseText === 'success') {
                        window.location.href = 'PersonalDetails.php';
                    } else {
                        errorMessage.textContent = 'Invalid username or password.';
                    }
                } else {
                    errorMessage.textContent = 'An error occurred during the authentication process.';
                }
            }
        };

        xhr.send(`username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`);
    }
});
