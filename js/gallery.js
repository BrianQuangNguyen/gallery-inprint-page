window.addEventListener("load", function(){
    const images = Array.from(document.querySelectorAll(".gallery-img"));
    const modalGallery = document.getElementById("modal-gallery");
    const modalImage = document.getElementById("modal-image");
    const modalClose = document.getElementById("modal-close");
    const modalPrev = document.getElementById("modal-prev");
    const modalNext = document.getElementById("modal-next");
    const modalCounter = document.getElementById("modal-counter");

    let currentIndex = 0;

    /**
     * Display the gallery modal box and update the image 
     * @param {Number} index 
     */
    function showGallery(index) {
        currentIndex = index;
        modalGallery.style.display = "block";
        modalImage.src = images[currentIndex].src;
        modalCounter.textContent =(currentIndex + 1) + "/" + images.length;
    }

    // Add event listener for to each image that opens the modal box
    images.forEach((img, index) =>{
        img.addEventListener("click", function() {
            showGallery(index);
        });
    });

    // Add event listener to X button that closes modal box
    modalClose.addEventListener("click", function () {
        modalGallery.style.display = "none";
    });

    // Add event listener to previous button that updates index and changes image
    modalPrev.addEventListener("click", function() {
        if (currentIndex > 0) {
            currentIndex = (currentIndex-1);
        } else {
            currentIndex = images.length-1;
        }
        modalImage.src = images[currentIndex].src;
        modalCounter.textContent =(currentIndex+1) + "/" + images.length;
    });

    // Add event listener to next button that updates index and changes image
    modalNext.addEventListener("click", function() {
        if (currentIndex + 1 < images.length) {
            currentIndex = (currentIndex+1);
        } else {
            currentIndex = 0;
        }
        modalImage.src = images[currentIndex].src;
        modalCounter.textContent =(currentIndex+1) + "/" + images.length;

    });

    // Add event listener that allows user to close modal box by clicking on blank space
    window.addEventListener("click", function(event) {
        if (event.target  === modalGallery) {
            modalGallery.style.display = "none";
        }
    });

});