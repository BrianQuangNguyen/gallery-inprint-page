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

window.addEventListener("load", function (event) {

    let form = document.getElementById("form");
    let products = document.getElementById("products");
    let numDisplayed = document.getElementById("numDisplayed");
    let productCount = document.getElementById("productCount");

    /**
     * success function called by the fetch function when the button is pressed
     * @param {Array} list - the associative array returned by the PHP response
     */
    function success(list) {
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
                                    <p>Price: ${row["price"]}</p>
                                    <p>Dimensions: ${row["dimensions"]}</p>
                                    <p>Description: ${row["description"]}</p>
                                    <p>Date taken: ${row["date"]}</p>
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

    // send the HTTP request when the button is pressed
    form.addEventListener("submit", function (event) {
        event.preventDefault();

        // send the number of products currently being displayed
        // so that the SQL command can use it to determine which items aren't displayed yet
        let url = `storeprocessing.php?numDisplayed=${numDisplayed.innerHTML}`;

        fetch(url)
            .then(response => response.json())
            .then(success)
    })
})