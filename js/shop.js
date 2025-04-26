/* 
Script file for shop.php

- Contains the event listeners used to send AJAX requests to shopProcessing.php when buttons are pressed
- Also makes navbar responsive and contains functions used for the shopping cart features

Team: Brick Plug
Members: Aleina Elizabeth Biju, Abigail	Fong, Logan Lau-McLennan, Brian Nguyen

Authors: main function - Abigail Fong (400567541), shopping cart functions: Aleina Biju
Created: 31/03/2025
*/

window.addEventListener("load", function (event) {
    // responsive navbar
    let menu = document.getElementById("menu");
    let navlinks = document.getElementById("navlinks");

    let open = false; // track whether the menu is open or not

    menu.addEventListener("click", function (event) {
        // toggle between showing the menu button with no links, or a close button with links
        if (open) {
            open = false;
            menu.src = "images/menu.png"
            navlinks.style.display = "none";
        } else {
            open = true;
            menu.src = "images/x.png"
            navlinks.style.display = "block";
        }
    })

    // AJAX request for shop page
    let order = document.getElementById("order");
    let form = document.getElementById("form");
    let products = document.getElementById("products");
    let numDisplayed = document.getElementById("numDisplayed");
    let productCount = document.getElementById("productCount");

    let action; // track whether the product info is being loaded from the Show More button, or changing the sort order

    /**
     * success function called by the fetch function when the Show More button is pressed or sort order is changed
     * @param {Array} list - the associative array returned by the PHP response
     */
    function success(list) {

        // if the user changed the sort order, clear all the products displayed previously
        if (action === "sort") {
            products.innerHTML = "";
            numDisplayed.innerHTML = 0;
        }

        // keep track of the new products being displayed
        let newProducts = "";
        let count = 0;

        // create the necessary HTML elements to display each product
        for (let row of list) {
            count++;
            newProducts += `<div class=\"product\">
                                <div class=\"leftTile\">
                                    <img class=\"pic\" src=\"images/${row["fileName"]}\">
                                </div>
        
                                <div class=\"rightTile\">
                                    <h2>${row["name"]}</h2>
                                    <p>Quantity: ${row["quantity"]}</p>
                                    <p>Price: $${row["price"]}</p>
                                    <p>Dimensions: ${row["dimensions"]}</p>
                                    <p>Description: ${row["description"]}</p>
                                    <p>Date taken: ${row["date"]}</p>
                                    <button onclick="addToCart(${row["productID"]}, 1)">Add to Cart</button>
                                </div>
                            </div>`;
        }
        // add the string of new products to the existing products
        products.innerHTML += newProducts;

        // update the screen to reflect how many products are now visible
        numDisplayed.innerHTML = parseInt(numDisplayed.innerHTML) + count;

        // if all the products in the database are visible, hide the button since there's no more to request
        if (numDisplayed.innerHTML == productCount.innerHTML) {
            form.style.display = "none";
        }
    }

    // send the HTTP request when the Show More button is pressed
    form.addEventListener("submit", function (event) {
        event.preventDefault();

        action = "showMore";

        // send the sort order and number of products currently being displayed
        // so that the SQL command can use it to determine which items are to be shown next
        console.log(order.value)
        let url = `shopProcessing.php?order=${order.value}&numDisplayed=${numDisplayed.innerHTML}`;

        fetch(url)
            .then(response => response.json())
            .then(success)
    })

    // send the HTTP request when the sort order is changed
    order.addEventListener("input", function (event) {
        event.preventDefault();

        action = "sort";

        // send the sort order and send the number of products displayed as 0
        // since it's going to clear all the current products and replace them based on the new order
        console.log(order.value)
        let url = `shopProcessing.php?order=${order.value}&numDisplayed=0`;

        fetch(url)
            .then(response => response.json())
            .then(success)
    })
})

function addToCart(productID, quantity) {
    // Send the productID and quantity to cart.php using a POST request
    fetch('util/cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `action=add&productID=${productID}&quantity=${quantity}`
    })
        .then(response => response.json())
        .then(data => {
            alert(data.message);  // Show confirmation message (e.g. Item added to cart)
            fetchCart();  // Refresh cart contents after adding the item
        })
        .catch(error => console.log('Error adding item to cart:', error));
}

function fetchCart() {
    fetch('util/cart.php', {
        method: 'GET', // Change from POST to GET
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
        .then(response => response.text()) // Expect text since cart.php directly outputs HTML
        .then(html => {
            document.getElementById('cart-container').innerHTML = html; // Update cart display
        })
        .catch(error => console.log('Error fetching cart:', error));
}

function removeFromCart(productID) {
    fetch('removefromcart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `productID=${productID}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Item removed from cart!");
                location.reload(); // Refresh the cart page
            } else {
                alert("Error removing item from cart.");
            }
        })
        .catch(error => console.error('Error:', error));
}
