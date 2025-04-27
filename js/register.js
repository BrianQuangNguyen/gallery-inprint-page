window.onload = function () {
    // Add event listener to the login form
    document.getElementById("login-form").addEventListener("submit", function (event) {
        event.preventDefault(); // Stop the form from submitting normally

        // Get the email and password values
        const formData = new FormData(this);

        fetch('util/addUser.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log('Response from PHP:', data);
            if(data.trim() === 'success') {
                window.location.href = 'dashboard.php'; // Redirect to dashboard on success
            } else {
                document.getElementById('message').innerHTML = data; // Display error message
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
};