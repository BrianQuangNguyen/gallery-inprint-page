<?php
/* 
Gallery Inprint Shop Page

- Contains the relevant HTML elements needed for the page
- Includes a PHP script to get the info for the first 5 items to be displayed on page load
  OR if the user is returning to the page, load the products that were displayed previously

Team: Brick Plug
Members: Aleina Elizabeth Biju, Abigail	Fong, Logan Lau-McLennan, Brian Nguyen

Author: Abigail Fong (400567541)
Created: 31/03/2025
*/

include "util/connect.php";
session_start();

// if session variables aren't set then the user is visiting the page for the first time
// get 5 products in the default order (by productID)
if (!isset($_SESSION["currentlyDisplayed"])) {

    // initialize the session variables
    $_SESSION["currentlyDisplayed"] = [];
    $_SESSION["numDisplayed"] = 0;
    $_SESSION["order"] = "None (Default)";

    // get the first 5 products from the database and add them to the session variables
    $command = "SELECT * FROM `products` ORDER BY `productID` LIMIT 5";
    $stmt = $dbh->prepare($command);
    $success = $stmt->execute();

    while ($row = $stmt->fetch()) {
        $product = [
            "productID" => $row["productID"],
            "name" => $row["name"],
            "fileName" => $row["fileName"],
            "quantity" => $row["quantity"],
            "price" => $row["price"],
            "dimensions" => $row["dimensions"],
            "description" => $row["description"],
            "date" => $row["date"],
        ];
        array_push($_SESSION["currentlyDisplayed"], $product);
        $_SESSION["numDisplayed"]++;
    }
}

// create a string holding all the HTML elements to display the products
$products = "";

foreach ($_SESSION["currentlyDisplayed"] as $row) {
    $products .= '<div class="product">
                    <div class="leftTile">
                        <img class="pic" src="images/' . $row["fileName"] . '">
                    </div>
                    <div class="rightTile">
                        <h2>' . $row["name"] . '</h2>
                        <p>Quantity: ' . $row["quantity"] . '</p>
                        <p>Price: $' . $row["price"] . '</p>
                        <p>Dimensions: ' . $row["dimensions"] . '</p>
                        <p>Description: ' . $row["description"] . '</p>
                        <p>Date taken: ' . $row["date"] . '</p>
                        <button onclick="addToCart(' . $row["productID"] . ', 1)">Add to Cart</button>
                    </div>
                </div>';
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
    <title>Shop</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/shop.js"></script>
</head>

<body>
    <div id="container">
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
        <h1>Shop</h1>
        <p class="rightAlign">
            Sort By:
            <select id="order">
                <!-- check the session variable to change the dropdown value to reflect the current sort order -->
                <option <?php if ($_SESSION["order"] === "None (Default)") echo "selected" ?>>
                    None (Default)
                </option>
                <option <?php if ($_SESSION["order"] === "Price: Low to High") echo "selected" ?>>
                    Price: Low to High
                </option>
                <option <?php if ($_SESSION["order"] === "Price: High to Low") echo "selected" ?>>
                    Price: High to Low
                </option>
                <option <?php if ($_SESSION["order"] === "Date Taken: Newest First") echo "selected" ?>>
                    Date Taken: Newest First
                </option>
                <option <?php if ($_SESSION["order"] === "Date Taken: Oldest First") echo "selected" ?>>
                    Date Taken: Oldest First
                </option>
            </select>
        </p>
        <div id="products"><?= $products ?></div>
        <div>
            <p>
                Displaying <span id="numDisplayed"><?= $_SESSION["numDisplayed"] ?></span>
                out of <span id="productCount"><?= $productCount ?></span>
            </p>
        </div>
        <form id="form">
            <input id="button" type="submit" value="Show More">
        </form>
    </div>
</body>

</html>