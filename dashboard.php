<!-- 
Gallery Inprint Error Page

- An HTML page which the user is directed to if any error occurs when receiving HTTP paramters
- Provides the user with a link to return to the site's homepage

Team: Brick Plug
Members: Aleina Elizabeth Biju, Abigail	Fong, Logan Lau-McLennan, Brian Nguyen

Author: Logan Lau-McLennan (400589565)
Created: 19/04/2025
-->

<?php
session_start();
if (!isset($_SESSION['account_loggedin'])) {
    header("Location: account.php");
    exit();
}
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link href="css/style.css" rel="stylesheet">
    <title>Account Dashboard</title>
</head>

<body>
    <div id="container" style="box-sizing: none;">
        <div id="mobileNav">
            <img id="menu" src="images/menu.png" title="Menu" alt="Menu">
            <ul id="navlinks">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="cart.html">Your Cart</a></li>
                <li><a href="account.php">Account Login</a></li>
            </ul>
        </div>
        <div id="nav">
            <ul>
                <li><a href="index.php"><img src="images/home.png" title="Home" alt="Home"></a></li>
                <li><a href="about.html"><img src="images/about.png" title="About Us" alt="About Us"></a></li>
                <li><a href="shop.php"><img src="images/shop.png" title="Shop" alt="Shop"></a></li>
                <li><a href="cart.html"><img src="images/shopping-cart.png" title="Shopping Cart" alt="Shopping Cart"></a></li>
                <li><a href="account.php"><img src="images/profile-picture.png" title="Account" alt="Account"></a></li>
            </ul>
        </div>
    </div>

    <h2>Welcome to Your Dashboard</h2>
    <a href="util/logout.php">Logout</a>

    <div id="admin-controls">
        <?php
        // Fetch admin status for this user
        if (isset($_SESSION['account_admin'])) {
            // If admin is true (1), show admin controls
            // The reason I do this is to prevent the admin controls from being for non-admin users
            echo 
            '
            <h2>Admin Panel</h2>
            <div class="flex row">
                <div class="admin-upload">
                    <h3>Upload New Image</h3>
                    <form id="upload-form" enctype="multipart/form-data">
                        <input type="file" name="image" id="image-input" accept="image/*" required>
                        <div id="preview"></div>
                        <button type="submit">Upload Image</button>
                    </form>
                    <div id="upload-message"></div>
                </div>
                <div class="admin-add-product">
                    <h3>Add New Product</h3>
                    <form id="product-form">
                        <input type="text" name="name" placeholder="Product Name" required><br><br>
                        <input type="text" name="fileName" placeholder="Image File Name (e.g. mypic.jpg)" required><br><br>
                        <input type="number" name="quantity" placeholder="Quantity" required><br><br>
                        <input type="number" step="0.01" name="price" placeholder="Price" required><br><br>
                        <input type="text" name="dimensions" placeholder="Dimensions (e.g. 10x20)" required><br><br>
                        <textarea name="description" placeholder="Product Description" maxlength="250" required></textarea><br><br>
                        <button type="submit">Add Product</button>
                    </form>
                    <div id="product-message"></div>
                </div>
            </div>
            ';
        }
        ?>
    </div>

    <script>
        document.getElementById('image-input').addEventListener('change', function() {
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

        document.getElementById('upload-form').addEventListener('submit', function(event) {
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

        document.getElementById('product-form').addEventListener('submit', function(event) {
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


    </script>
</body>

</html>