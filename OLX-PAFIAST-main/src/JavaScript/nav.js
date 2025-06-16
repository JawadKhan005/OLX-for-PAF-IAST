document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.querySelector(".menu-toggle");
    const navLinks = document.querySelector(".nav-links");

    // console.log("Toggle button:", toggleButton); // Check if button is found
    // console.log("Nav links:", navLinks); // Check if nav is found

    if (toggleButton && navLinks) {
        toggleButton.addEventListener("click", () => {
            // console.log("Button clicked! Toggling nav...");
            navLinks.classList.toggle("active");
        });
    } else {
        console.log("Elements not found!");
    }
});