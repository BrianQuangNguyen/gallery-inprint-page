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