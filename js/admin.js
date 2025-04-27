/* 
Script file for admin.php

- Contains the event listeners used to send AJAX requests to authenticate.php when buttons are pressed

Team: Brick Plug
Members: Aleina Elizabeth Biju, Abigail	Fong, Logan Lau-McLennan, Brian Nguyen

Authors: Logan Lau-McLennan (400589565)
Created: 31/03/2025
*/

window.addEventListener("load", function (event) {
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
})

document.getElementById('image-input')?.addEventListener('change', function() {
    const preview = document.getElementById('preview');
    preview.innerHTML = ''; // Clear old preview

    const file = this.files[0];
    if (file) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.style.maxWidth = '200px';
        img.style.marginTop = '10px';
        preview.appendChild(img);
    }
});

document.getElementById('upload-form')?.addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('util/uploadImage.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('upload-message').innerHTML = data;
        // Optionally refresh images list after upload
        loadImages();
    })
    .catch(error => {
        console.error('Upload error:', error);
    });
});

document.getElementById('product-form')?.addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('util/uploadProduct.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('product-message').innerText = data;
        document.getElementById('product-form').reset(); // Clear form after success
    })
    .catch(error => {
        console.error('Error adding product:', error);
    });
});