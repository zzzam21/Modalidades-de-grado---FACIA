// Toggle sidebar collapse/expand + estado activo según URL
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

    // Resaltar el enlace de navegación correspondiente a la página actual
    const normalize = (path) => path.replace(/\/+$/, "") || "/";
    const currentPath = normalize(window.location.pathname);

    sidebar.querySelectorAll("a.nav-link[href]").forEach((link) => {
        const href = link.getAttribute("href");
        if (!href || href === "#") return;

        try {
            const linkPath = normalize(new URL(href, window.location.origin).pathname);
            if (
                currentPath === linkPath ||
                currentPath.startsWith(linkPath + "/")
            ) {
                link.classList.add("active");
            }
        } catch (err) {
            /* href inválido, ignorar */
        }
    });
});
