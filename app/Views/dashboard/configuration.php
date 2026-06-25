<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>

<div id="app" data-view="configuration">

    <div class="d-flex justify-content-center pt-5">
        <div class="card shadow-sm border-0" style="max-width:480px;width:100%;">
            <div class="card-body text-center">
                <h4>Usuario</h4>
                <img class="pb-3" src="<?= base_url("img/header/icono-usuario.webp") ?>" alt="Usuario" style="width:120px;max-width:30%;">
                
                <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap mb-2">
                    <span class="fw-semibold fs-6">Nombre:</span>
                    <span id="currentUserName" class="fs-6">
                        <?= esc(session()->get('user_name')); ?>
                    </span>
                    <button type="button" class="btn btn-sm btn-success flex-shrink-0"
                    data-bs-toggle="modal" data-bs-target="#userNameModal">
                        <i class="bi bi-pencil"></i>
                    </button>
                </div>

                <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap mb-3">
                    <span class="fw-semibold fs-6">Correo:</span>
                    <span id="currentUserEmail" class="fs-6">
                        <?= session('user_email')?>
                    </span>
                    <button type="button" class="btn btn-sm btn-success flex-shrink-0"
                    data-bs-toggle="modal" data-bs-target="#userEmailModal">
                        <i class="bi bi-pencil"></i>
                    </button>
                </div>

                <a href="" data-bs-toggle="modal" data-bs-target="#passwordModal">Cambiar contraseña</a>
            </div>
        </div>
    </div>
</div>

<!-- Modals para el cambio de información del usuario -->
<!-- Modal userName-->
<div class="modal fade" id="userNameModal" tabindex="-1" aria-labelledby="userNameModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="userNameModalLabel">Actualizar Nombre</h1>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="userNameInputEmail" class="form-label">Nombre de usuario</label>
                    <input type="text" class="form-control" id="userNameInputEmail" name="userNameInputEmail" value="<?php echo session()->get("user_name") ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button id="saveUser" class="btn btn-success">
                    <i class="bi bi-floppy"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal userEmail-->
<div class="modal fade" id="userEmailModal" tabindex="-1" aria-labelledby="userEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="userEmailModalLabel">Actualizar Correo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="userEmailInputEmail" class="form-label">Correo</label>
                    <input type="text" class="form-control" id="userEmailInputEmail" value="<?php echo session()->get("user_email") ?>">
                </div>
            </div>

            <div class="modal-footer">
                <button id="saveEmail" class="btn btn-success">
                    <i class="bi bi-floppy"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Password -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="passwordModalLabel">Cambiar contraseña</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="currentPassword" class="form-label">Contraseña actual</label>
                    <input type="password" class="form-control" id="currentPassword" placeholder="*********" autocomplete="current-password">
                </div>
                <div class="mb-3">
                    <label for="NewPassword" class="form-label">Nueva Contraseña</label>
                    <input type="password" class="form-control" id="NewPassword" placeholder="********" autocomplete="new-password">
                </div>
                <div class="mb-3">
                    <label for="passwordConfirmEmail" class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="passwordConfirmEmail" placeholder="********" autocomplete="new-password">    
                </div>
            </div>
            
            <div class="modal-footer">
                <button id="savePassword" class="btn btn-success">
                    <i class="bi bi-floppy"></i>
                </button>
            </div>

        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>