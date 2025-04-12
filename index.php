<?php
include "connect.php";
$command = "SELECT `fileName`FROM `products`";
$stmt = $dbh->prepare($command);
$success = $stmt->execute();


?>
<!DOCTYPE html>
<!--
Home/Gallery Page
-->
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=devices-width">
    <link href="css/style.css" rel="stylesheet">
    <title>Gallery</title>
    <script src="js/gallery.js"></script>
</head>

<body>
    <div id="container" style="box-sizing: none;">
        <div id="nav">
            <ul>
                <li><a href="index.php"><img src="images/home.png" title="Home" alt="Home"></a></li>
                <li><a href="store.php"><img src="images/shop.png" title="Shop" alt="Shop"></a></li>
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

    <div id="modal-gallery" style = "display:none">
        <span id="modal-close">&times;</span>
        <span id="modal-prev" class="modal-nav">&#10094;</span>
        <img id="modal-image">
        <span id="modal-next" class="modal-nav">&#10095;</span>
        <div id="modal-counter"></div>
    </div>
</body>

</html>