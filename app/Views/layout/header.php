<nav class="navbar app-header navbar-expand-lg px-2 px-md-4">
    <div class="container-fluid">

        <span class="navbar-text fs-6 fs-md-5 text-truncate" id="header-title">
            <span class="fw-semibold"><?php echo $icon; ?></span>
            <span id="nombre-docente"></span>
        </span>

        <div class="d-flex align-items-center gap-2 gap-md-3 flex-shrink-0">

            <span class="navbar-text d-flex align-items-center gap-2 text-truncate">

                <span id="currentUser" class="fw-medium d-none d-sm-inline">
                    <?= esc(session()->get('user_name')); ?>
                </span>

                <img
                    src="<?= base_url("img/header/icono-usuario.webp") ?>"
                    class="user-avatar"
                    alt="Usuario"
                    data-bs-toggle="popover"
                    data-bs-title="Perfil"
                    data-bs-content="Haz clic para ver tu perfil"
                    data-bs-placement="bottom"
                    role="button"
                >
            </span>

            <button
                type="button"
                class="btn btn-logout"
                title="Cerrar sesión"
                onclick="window.location.href='<?= base_url('auth/logout') ?>'"
            >
                <i class="bi bi-box-arrow-right"></i>
            </button>

        </div>
    </div>
</nav>
