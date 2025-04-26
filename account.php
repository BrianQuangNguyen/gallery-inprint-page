<!-- 
Gallery Inprint Error Page

- An HTML page which the user is directed to if any error occurs when receiving HTTP paramters
- Provides the user with a link to return to the site's homepage

Team: Brick Plug
Members: Aleina Elizabeth Biju, Abigail	Fong, Logan Lau-McLennan, Brian Nguyen

Author: Abigail Fong (400567541)
Created: 19/04/2025
-->

<?php
include 'util/connect.php';

$message = "";
$toastClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if email already exists
    $checkUserStmt = $conn->prepare("SELECT username FROM userdata WHERE username = ?");
    $checkUserStmt->bind_param("s", $email);
    $checkUserStmt->execute();
    $checkUserStmt->store_result();

    if ($checkUserStmt->num_rows > 0) {
        $message = "Username already exists";
        $toastClass = "#007bff"; // Primary color
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO userdata (username, password) VALUES (?, ?)");
        $stmt->bind_param("sss", $username, $password);

        if ($stmt->execute()) {
            $message = "Account created successfully";
            $toastClass = "#28a745"; // Success color
        } else {
            $message = "Error: " . $stmt->error;
            $toastClass = "#dc3545"; // Danger color
        }

        $stmt->close();
    }

    $checkUserStmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Your Account</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/navbar.js"></script>
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
    </div>

    <h1>Login</h1>
    <div class="container p-5 d-flex flex-column align-items-center">
        <?php if ($message): ?>
            <div class="toast align-items-center text-white border-0" 
          role="alert" aria-live="assertive" aria-atomic="true"
                style="background-color: <?php echo $toastClass; ?>;">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $message; ?>
                    </div>
                    <button type="button" class="btn-close
                    btn-close-white me-2 m-auto" 
                          data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
        <form method="post" class="form-control mt-5 p-4"
            style="height:auto; width:380px;
            box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px,
            rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;">
            <div class="row text-center">
                <i class="fa fa-user-circle-o fa-3x mt-1 mb-2" style="color: green;"></i>
                <h5 class="p-4" style="font-weight: 700;">Create Your Account</h5>
            </div>
            <div class="mb-2">
                <label for="username"><i 
                  class="fa fa-user"></i> User Name</label>
                <input type="text" name="username" id="username"
                  class="form-control" required>
            </div>
            <div class="mb-2 mt-2">
                <label for="password"><i 
                  class="fa fa-lock"></i> Password</label>
                <input type="text" name="password" id="password"
                  class="form-control" required>
            </div>
            <div class="mb-2 mt-3">
                <button type="submit" 
                  class="btn btn-success
                bg-success" style="font-weight: 600;">Create
                    Account</button>
            </div>
            <div class="mb-2 mt-4">
                <p class="text-center" style="font-weight: 600; 
                color: navy;">I have an Account <a href="util/login.php"
                        style="text-decoration: none;">Login</a></p>
            </div>
        </form>
    </div>
    <script>
        let toastElList = [].slice.call(document.querySelectorAll('.toast'))
        let toastList = toastElList.map(function (toastEl) {
            return new bootstrap.Toast(toastEl, { delay: 3000 });
        });
        toastList.forEach(toast => toast.show());
    </script>
</body>

</html>