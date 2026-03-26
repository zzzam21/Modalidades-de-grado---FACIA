<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>

<div id="app" data-view="configuration">

    <div class="text-center mx-auto justify-content-center align-items-center pt-5" style="width:fit-content">
        <h4>Usuario</h4>
        <img class="pb-3" src="<?= base_url("img/header/icono-usuario.webp") ?>" alt="Usuario" width="30%;">
        <div class="row g-3">
            <div class="col-auto">
                <p style="font-size: 17px;"><b>Nombre:</b></p>
            </div>
            <div class="col-auto">
                <p><?= session()->get('user_name');?></p>
            </div>
            <div class="col-auto ms-auto">

                <button type="button" class="btn btn-sm btn-success" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
                data-bs-toggle="modal" data-bs-target="#userNameModal">
                    <span class="icon">
                        <i class="bi bi-pencil"></i>
                    </span>
                </button>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-auto">
                <p style="font-size: 17px;"><b>Correo:</b></p>
            </div>
            <div class="col-auto">
                <p><?= session('user_email')?></p>
            </div>
            <div class="col-auto ms-auto">
                <button type="button"  class="btn btn-sm btn-success" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
                data-bs-toggle="modal" data-bs-target="#userEmailModal">
                    <i class="bi bi-pencil"></i>
                </button>
            </div>
        </div>
        <a href="" data-bs-toggle="modal" data-bs-target="#passwordModal">Cambiar contraseña</a>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button"  class="btn btn-success">Guardar</button>
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
                    <label for="passwordActualEmail" class="form-label">Contraseña actual</label>
                    <input type="password" class="form-control" id="passwordActualEmail" placeholder="*********" autocomplete="current-password">
                </div>
                <div class="mb-3">
                    <label for="passwordNewEmail" class="form-label">Nueva Contraseña</label>
                    <input type="password" class="form-control" id="passwordNewEmail" placeholder="********" autocomplete="new-password">
                </div>
                <div class="mb-3">
                    <label for="passwordConfirmEmail" class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="passwordConfirmEmail" placeholder="********" autocomplete="new-password">    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success">Guardar</button>
            </div>            
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>