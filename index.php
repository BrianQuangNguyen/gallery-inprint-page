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

</head>

<body>
    <div id="container" style = "box-sizing: none;">
        <div id="nav">
            <ul>
                <li><a href="index.php"><img src="images/home.png" title="Home" alt="Home"></a></li>
                <li><a href="store.php"><img src="images/shop.png" title="Shop" alt="Shop"></a></li>
                <li><a href="cart.html"><img src="images/shopping-cart.png" title="Shopping Cart" alt="Shopping Cart"></a></li>
                <li><a href="account.html"><img src="images/profile-picture.png" title="Account" alt="Account"></a></li>    
            </ul>
        </div>
        <div class = "image-container"> 
            <img class = "header-img" src = "images/cropped_mono_sunset.jpg"> 
            <div class = "overlay-text">Gallery Inprint</div>
        </div>
    </div>

    <div class = "gallery">
        <?php
        while ($row = $stmt->fetch()) {
            echo "<img src='images/" . ($row['fileName']) . "'>";
        }
        ?>
    </div>



    


</body>

</html>