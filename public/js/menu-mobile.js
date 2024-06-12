document.addEventListener("DOMContentLoaded", function() {
    var menu = document.getElementById("mobile-menu");

    function openMenu() {
        menu.classList.remove("hidden", "opacity-0");
        menu.classList.add(  "opacity-100");
    }

    function closeMenu() {
        menu.classList.remove(  "opacity-100");
        menu.classList.add("hidden", "opacity-0");
    }

    window.openMenu = openMenu;
    window.closeMenu = closeMenu;
});