<?php
session_start(); // Start the session to store cart data

include("connect.php");

// Initialize the cart if it doesn't exist in the session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Add to cart
    if ($action === 'add') {
        $productID = $_POST['productID'] ?? null;
        
        if ($productID) {
            $_SESSION['cart'][$productID] = 1; // Always set quantity to 1
            echo json_encode(["message" => "Item added to cart!"]);
        } else {
            echo json_encode(["message" => "Invalid product!"]);
        }
        exit;
    }

    // Remove from cart
    if ($action === 'remove') {
        $productID = $_POST['productID'] ?? null;
        if ($productID && isset($_SESSION['cart'][$productID])) {
            unset($_SESSION['cart'][$productID]);
            header("Location: cart.php"); // Refresh cart page
            exit;
        }
    }
}

// Display cart contents
$productIDs = array_keys($_SESSION['cart']);
if ($productIDs) {
    $productIDsString = implode(",", array_map('intval', $productIDs));
    $sql = "SELECT productID, name, price FROM products WHERE productID IN ($productIDsString)";
    $result = $dbh->query($sql);
} else {
    $result = false;
}

// Display cart
echo '<table>';
echo '<thead><tr><th>Product Name</th><th>Price</th><th>Action</th></tr></thead>';
echo '<tbody>';

if ($result && $result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
        echo '<td>$' . number_format(floatval($row['price']), 2) . '</td>';
        echo '<td>
                <form method="POST" action="cart.php">
                    <input type="hidden" name="action" value="remove">
                    <input type="hidden" name="productID" value="' . htmlspecialchars($row['productID']) . '">
                    <button type="submit">Remove</button>
                </form>
              </td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="3">Your cart is empty.</td></tr>';
}

echo '</tbody>';
echo '</table>';

