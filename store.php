<?php
/* 
Gallery Inprint Store Page

Team: Brick Plug
Members: Aleina Elizabeth Biju, Abigail	Fong, Logan Lau-McLennan, Brian Nguyen

Author: Abigail Fong (400567541)
Created: 31/03/2025

- The store page for the website
- Contains the relevant HTML elements needed for the page
- Includes a PHP script to get the info for the first 5 items to be displayed on page load
*/

include "connect.php";

// get the first 5 products from the database
$command = "SELECT `name`,`fileName`,`quantity`,`price`,`dimensions`,`description`,`date` FROM `products` ORDER BY `productID` LIMIT 5";
$stmt = $dbh->prepare($command);
$success = $stmt->execute();

// create a string holding all the html elements to display the products
$products = "";
while ($row = $stmt->fetch()) {
    $products .= "<div class=\"product\">
                    <div class=\"leftTile\">
                        <img class=\"pic\" src=\"images/{$row["fileName"]}\">
                    </div>
            
                    <div class=\"rightTile\">
                        <h2>{$row["name"]}</h2>
                        <p>Quantity: {$row["quantity"]}</p>
                        <p>Price: {$row["price"]}</p>
                        <p>Dimensions: {$row["dimensions"]}</p>
                        <p>Description: {$row["description"]}</p>
                        <p>Date taken: {$row["date"]}</p>
                    </div>
                </div>";
}

// productIDs are incremental so the last/highest value is the number of products there are
$command = "SELECT `productID` FROM `products` ORDER BY `productID` DESC LIMIT 1";
$stmt = $dbh->prepare($command);
$success = $stmt->execute();

// store this value to be displayed on screen
$productCount = $stmt->fetch()["productID"];
?>

<!DOCTYPE html>

<html>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Store</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/storescript.js"></script>
</head>

<body>
    <div id="container">
        <div id="nav">
            <ul>
                <li><a href="index.html"><img src="images/home.png" title="Home" alt="Home"></a></li>
                <li><a href="store.php"><img src="images/shop.png" title="Shop" alt="Shop"></a></li>
                <li><a href="cart.html"><img src="images/shopping-cart.png" title="Shopping Cart" alt="Shopping Cart"></a></li>
                <li><a href="account.html"><img src="images/profile-picture.png" title="Account" alt="Account"></a></li>
            </ul>
        </div>
        <h1>Shop</h1>
        <?= $products ?>
        <p id="products"></p>
        <div>
            <p>Displaying <span id="numDisplayed">5</span> out of <span id="productCount"><?= $productCount ?></span></p>
        </div>
        <form id="form">
            <input id="button" type="submit" value="Show More">
        </form>
    </div>


</body>

</html>