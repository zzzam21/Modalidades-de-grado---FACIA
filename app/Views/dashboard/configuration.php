<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>

<div class="row justify-content-center pt-4" id="app" data-view="configuration">
    <div class="col-12 col-sm-10 col-md-7 col-lg-5">

        <div class="card">
            <div class="card-body p-4 text-center">
                <img src="<?= base_url("img/header/icono-usuario.webp") ?>" alt="Usuario" class="profile-avatar">
                <h4 id="currentUserName" class="fw-bold mt-3 mb-1"><?= esc(session()->get('user_name')); ?></h4>
                <p id="currentUserEmail" class="text-muted mb-0"><?= session('user_email')?></p>
            </div>

            <div class="profile-actions">
                <button type="button" class="profile-action" data-bs-toggle="modal" data-bs-target="#userNameModal">
                    <span><i class="bi bi-person me-2"></i>Actualizar nombre</span>
                    <i class="bi bi-chevron-right"></i>
                </button>
                <button type="button" class="profile-action" data-bs-toggle="modal" data-bs-target="#userEmailModal">
                    <span><i class="bi bi-envelope me-2"></i>Actualizar correo</span>
                    <i class="bi bi-chevron-right"></i>
                </button>
                <button type="button" class="profile-action" data-bs-toggle="modal" data-bs-target="#passwordModal">
                    <span><i class="bi bi-shield-lock me-2"></i>Cambiar contraseña</span>
                    <i class="bi bi-chevron-right"></i>
                </button>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="saveUser" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i>Guardar
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="saveEmail" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i>Guardar
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="savePassword" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i>Guardar
                </button>
            </div>

        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>
