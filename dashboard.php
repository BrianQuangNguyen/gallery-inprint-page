<!-- 
Gallery Inprint Dashboard Page

This is the user dashboard. It doesn't have any functionality for normal users.
Admins can add images to the file system and add products to the database from here.

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
    <script src="js/navbar.js"></script>
    <script src="js/admin.js"></script>
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
        if (!empty($_SESSION["account_admin"])) {
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
</body>

</html>