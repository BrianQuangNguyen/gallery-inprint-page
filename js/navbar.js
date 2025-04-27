/* 
Script file for making the navbar responsive

- To be included on all pages

Team: Brick Plug
Members: Aleina Elizabeth Biju, Abigail	Fong, Logan Lau-McLennan, Brian Nguyen

Author: Abigail Fong (400567541)
Created: 19/04/2025
*/

window.addEventListener("load", function (event) {
    // responsive navbar
    let menu = document.getElementById("menu");
    let navlinks = document.getElementById("navlinks");

    let open = false; // track whether the menu is open or not

    menu.addEventListener("click", function (event) {
        // toggle between showing the menu button with no links, or a close button and links
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
})