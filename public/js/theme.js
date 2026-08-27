// Tema SweetAlert2: botones de confirmación alineados a la paleta
// (verde esmeralda por defecto, rojo en diálogos de error/advertencia)
(function () {
    if (typeof Swal === "undefined") return;

    const originalFire = Swal.fire.bind(Swal);

    Swal.fire = function (...args) {
        const opts =
            typeof args[0] === "object" && args[0] !== null ? args[0] : {};

        if (
            !opts.confirmButtonColor &&
            !(opts.customClass && opts.customClass.confirmButton)
        ) {
            opts.confirmButtonColor =
                opts.icon === "error" || opts.icon === "warning"
                    ? "#dc2626"
                    : "#16a34a";
        }

        return originalFire(opts);
    };
})();
