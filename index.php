<?php
/* 
Gallery Inprint Index Page

- Using php load image names from a database table
- Uses loaded image names to display a gallery of images
- Using a modal box to allow the user to cycle through a gallery of images

Team: Brick Plug
Members: Aleina Elizabeth Biju, Abigail	Fong, Logan Lau-McLennan, Brian Nguyen

Author: Brian Nguyen (nguyeb57)
Created: 31/03/2025
*/
include "connect.php";
$command = "SELECT `fileName`FROM `products`";
$stmt = $dbh->prepare($command);
$success = $stmt->execute();


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link href="css/style.css" rel="stylesheet">
    <title>Gallery</title>
    <script src="js/gallery.js"></script>
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
        <div class="image-container">
            <img class="header-img" src="images/cropped_mono_sunset.jpg">
            <div class="overlay-text">Gallery Inprint</div>
        </div>
    </div>

    <div class="gallery">
        <?php
        while ($row = $stmt->fetch()) {
            echo "<img src='images/" . ($row['fileName']) . "' class = 'gallery-img'>";
        }
        ?>
    </div>

    <div id="modal-gallery" style="display:none">
        <span id="modal-close">&times;</span>
        <span id="modal-prev" class="modal-nav">&#10094;</span>
        <img id="modal-image">
        <span id="modal-next" class="modal-nav">&#10095;</span>
        <div id="modal-counter"></div>
    </div>
</body>

</html>