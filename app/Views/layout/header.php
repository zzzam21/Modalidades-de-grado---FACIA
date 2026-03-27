<nav class="navbar navbar-expand-lg bg-body-tertiary px-2 px-md-3">
    <div class="container-fluid">

        <span class="navbar-text fw-bold fs-6 fs-md-5 text-truncate">
            <?php echo $icon; ?>
        </span>

        
        <div class="d-flex align-items-center gap-2 gap-md-3 flex-shrink-0">

            
            <span class="navbar-text d-flex align-items-center gap-2 text-truncate">
                
                <span id="currentUser" class="fw-semibold d-none d-sm-inline">
                    <?= esc(session()->get('user_name')); ?>
                </span>

                <img 
                    src="<?= base_url("img/header/icono-usuario.webp") ?>" 
                    class="img-fluid rounded-circle"
                    style="width: 28px; height: 28px; object-fit: cover; cursor: pointer;"
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
                class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center"
                onclick="window.location.href='<?= base_url('auth/logout') ?>'"
            >
                <i class="bi bi-box-arrow-right"></i>
            </button>

        </div>
    </div>
</nav>