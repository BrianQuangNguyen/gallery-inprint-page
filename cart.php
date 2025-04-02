<?php
session_start(); // Start the session to store cart data

include("connect.php");

// Initialize the cart if it doesn't exist in the session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add item to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Handle "add to cart"
    if ($action === 'add') {
        $productID = $_POST['productID'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        // Check if the productID and quantity are valid
        if ($productID) {
            // Add product to cart or update quantity if already in the cart
            if (isset($_SESSION['cart'][$productID])) {
                $_SESSION['cart'][$productID] += $quantity;
            } else {
                $_SESSION['cart'][$productID] = $quantity;
            }
            echo json_encode(["message" => "Item added to cart!"]);
        } else {
            echo json_encode(["message" => "Invalid product!"]);
        }
    }

    // HAVE TO FIX! "remove from cart"
    if ($action === 'remove') {
        $productID = $_POST['productID'] ?? null;
        if ($productID && isset($_SESSION['cart'][$productID])) {
            unset($_SESSION['cart'][$productID]);
            echo json_encode(["message" => "Item removed from cart."]);
        } else {
            echo json_encode(["message" => "Item not found in cart."]);
        }
    }
    exit;
}

// FetchING the cart contents and display them
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user_id = $_SESSION['user_id'] ?? null; // Ensure the user is logged in (optional)

    // Query to get cart items along with product details
    if ($user_id) {
        $sql = "SELECT cart.cartID, products.productID, products.name, products.price, cart.quantity
                FROM cart
                JOIN products ON cart.productID = products.productID
                WHERE cart.userID = '$user_id'";
        $result = $dbh->query($sql);
    } else {

        $productIDs = array_keys($_SESSION['cart']);
        if ($productIDs) {
            $productIDsString = implode(",", $productIDs);
            $sql = "SELECT productID, name, price FROM products WHERE productID IN ($productIDsString)";
            $result = $dbh->query($sql);
        } else {
            $result = false;
        }
    }

    // Display cart items
    echo '<h2>Your Cart</h2>';
    echo '<table>';
    echo '<thead><tr><th>Product Name</th><th>Quantity</th><th>Price</th><th>Action</th></tr></thead>';
    echo '<tbody>';
    
    if ($result && $result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $totalPrice = floatval($row['price']); 
            echo '<tr>';
            echo '<td>' . $row['name'] . '</td>';
            echo '<td>' . $_SESSION['cart'][$row['productID']] . '</td>';
            echo '<td>$' . number_format($totalPrice, 2) . '</td>';
            echo '<td><a href="cart.php?action=remove&productID=' . $row['productID'] . '">Remove</a></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="4">Your cart is empty.</td></tr>';
    }

    echo '</tbody>';
    echo '</table>';

    // Calculating the total cost
    $totalCost = 0;
    if ($result && $result->rowCount() > 0) {
        foreach ($result as $row) {
            $totalCost += $row['price'] * $_SESSION['cart'][$row['productID']];
        }
    }

    echo '<h3>Total: $' . number_format($totalCost, 2) . '</h3>';

    // Checkout button (if we ever have a page)
    echo '<a href="checkout.php">Proceed to Checkout</a>';
}
?>

