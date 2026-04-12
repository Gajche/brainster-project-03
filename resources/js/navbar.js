document.addEventListener("DOMContentLoaded", function () {
    const openBtn = document.getElementById("mobile-menu-btn");
    const closeBtn = document.getElementById("close-menu-btn");
    const menu = document.getElementById("mobile-menu");

    // Guard: Only run if all elements exist
    if (openBtn && closeBtn && menu) {
        openBtn.addEventListener("click", function () {
            menu.classList.remove("translate-x-full");
            document.body.classList.add("overflow-hidden");
        });

        closeBtn.addEventListener("click", function () {
            menu.classList.add("translate-x-full");
            document.body.classList.remove("overflow-hidden");
        });
    }
});
