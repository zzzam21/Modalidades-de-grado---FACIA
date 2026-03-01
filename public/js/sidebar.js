// Toggle sidebar collapse/expand
document.addEventListener("DOMContentLoaded", () => {

    const sidebar = document.getElementById("sidebar");
    const pageWrapper = document.querySelector(".page-wrapper");
    const toggle = document.getElementById("toggleSidebar");

    if (localStorage.getItem("sidebar-collapsed") === "true") {
        sidebar.classList.add("collapsed");
    }

    // Toggle manual
    toggle.addEventListener("click", (e) => {
        e.preventDefault();
        sidebar.classList.add("with-transition");
        pageWrapper.classList.add("with-transition");

        sidebar.classList.toggle("collapsed");
        localStorage.setItem(
            "sidebar-collapsed",
            sidebar.classList.contains("collapsed")
        );
    });

    sidebar.addEventListener("transitionend", () => {
        sidebar.classList.remove("with-transition");
        pageWrapper.classList.remove("with-transition");
    });

});