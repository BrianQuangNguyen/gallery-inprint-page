/* 
Script file for login.php

- Contains the event listeners used to send AJAX requests to authenticate.php when buttons are pressed

Team: Brick Plug
Members: Aleina Elizabeth Biju, Abigail	Fong, Logan Lau-McLennan, Brian Nguyen

Authors: Logan Lau-McLennan (400589565)
Created: 31/03/2025
*/

window.onload = function () {
    // responsive navbar
    let menu = document.getElementById("menu");
    let navlinks = document.getElementById("navlinks");

    let open = false; // track whether the menu is open or not

    menu.addEventListener("click", function (event) {
        // toggle between showing the menu button with no links, or a close button and links
        if (open) {
            open = false;
            menu.src = "images/menu.png"
            navlinks.style.display = "none";
        } else {
            open = true;
            menu.src = "images/x.png"
            navlinks.style.display = "block";
        }
    })

    // Add event listener to the login form
    document.getElementById("login-form").addEventListener("submit", function (event) {
        event.preventDefault(); // Stop the form from submitting normally

        // Get the email and password values
        const formData = new FormData(this);

        fetch('util/authenticate.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                console.log('Response from PHP:', data);
                if (data.trim() === 'success') {
                    console.log('Login successful!');
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