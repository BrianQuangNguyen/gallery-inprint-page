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

header('Content-Type: application/json');

include "connect.php";

$num = filter_input(INPUT_GET, "numDisplayed", FILTER_VALIDATE_INT);

$command = "SELECT `name`,`fileName`,`quantity`,`price`,`dimensions`,`description`,`date` FROM `products` WHERE `productID`>? ORDER BY `productID` LIMIT 5";
$stmt = $dbh->prepare($command);
$success = $stmt->execute([$num]);

$productList = [];
while ($row = $stmt->fetch()){
    $product = ["name" => $row["name"], "fileName" => $row["fileName"], "quantity" => $row["quantity"],"price" => $row["price"],"dimensions" => $row["dimensions"],"description" => $row["description"],"date" => $row["date"],];
    array_push($productList, $product);
}

echo json_encode($productList);