<?php echo $this->extend('layout/auth'); ?>
<?php echo $this->section('content'); ?>

<link rel="stylesheet" href="<?= base_url('css/authentication.css') ?>">

<div class="login-card">
    <img class="login-logo" src="<?php echo base_url("img/login/logoUser.webp") ?>" alt="Logo">

    <h1 class="login-title">Bienvenido</h1>
    <p class="login-subtitle">Modalidades de grado<br>Inicie sesión para continuar</p>

    <form method="POST" action="<?= base_url("auth/login") ?>">

        <div class="form-floating mb-3">
            <input class="form-control login-input" id="email" name="email" placeholder="user@gmail.com" type="text" required>
            <label for="email">Email</label>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control login-input" id="password" name="password" placeholder="*********" type="password" required>
            <label for="password">Contraseña</label>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger login-alert" role="alert">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <button class="btn btn-success w-100 login-btn" type="submit">Iniciar sesión</button>
    </form>
</div>

<p class="login-footnote">Facultad de Ciencias Agricolas</p>

<?php echo $this->endSection(); ?>
