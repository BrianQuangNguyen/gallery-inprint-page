<?php
/* 
PHP file for the Shop page

- Contains the necessary processing to create the responses to AJAX requests sent from shop.js

Team: Brick Plug
Members: Aleina Elizabeth Biju, Abigail	Fong, Logan Lau-McLennan, Brian Nguyen

Author: Abigail Fong (400567541)
Created: 31/03/2025
*/

include "connect.php";

header('Content-Type: application/json');
session_start();

// receive inputs
$order = filter_input(INPUT_GET, "order", FILTER_SANITIZE_SPECIAL_CHARS);
$num = filter_input(INPUT_GET, "numDisplayed", FILTER_VALIDATE_INT);

// error checking on GET parameters
if ($order === NULL || $num === NULL || $num === false) {
    // redirect to error page if parameters are not received/invalid
    header('Location: error.html');
} else {
    // create the command based on the indicated sorting order
    if ($order === "None (Default)") {
        $command = "SELECT * FROM `products` ORDER BY `productID` LIMIT 5 OFFSET :offset";
    } elseif ($order === "Price: Low to High") {
        $command = "SELECT * FROM `products` ORDER BY `price` LIMIT 5 OFFSET :offset";
    } elseif ($order === "Price: High to Low") {
        $command = "SELECT * FROM `products` ORDER BY `price` DESC LIMIT 5 OFFSET :offset";
    } elseif ($order === "Date Taken: Newest First") {
        $command = "SELECT * FROM `products` ORDER BY `date` DESC LIMIT 5 OFFSET :offset";
    } elseif ($order === "Date Taken: Oldest First") {
        $command = "SELECT * FROM `products` ORDER BY `date` LIMIT 5 OFFSET :offset";
    } else {
        // redirect to error page if the order isn't one of the options from the dropdown menu
        header('Location: error.html');
    }

    // prepare the command and input the offset value (which is the number of products currently displayed)
    $stmt = $dbh->prepare($command);
    $stmt->bindValue(":offset", $num, PDO::PARAM_INT);
    $success = $stmt->execute();

    // the products that are on screen will be saved to the session
    // this way, if the user goes between pages of the site, the store page will look the same when they return

    // if they don't exist yet, initialize the list of products, number of products displayed, and sort order
    // if $num is 0, that indicates a change in sort order so clear the session variables (get new products rather than adding to list)
    if (!isset($_SESSION["currentlyDisplayed"]) || ($num === 0)) {
        $_SESSION["currentlyDisplayed"] = [];
        $_SESSION["numDisplayed"] = $num;
        $_SESSION["order"] = $order;
    }

    // iterate through all the rows returned from the database, adding the info to the session list, and a list to be sent to the js
    $productList = [];
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
        array_push($productList, $product);
        array_push($_SESSION["currentlyDisplayed"], $product);
        $_SESSION["numDisplayed"]++;
    }

    echo json_encode($productList);
}
