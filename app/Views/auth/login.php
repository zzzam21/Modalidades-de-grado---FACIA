<?php echo $this->extend('layout/auth'); ?>
<?php echo $this->section('content'); ?>

<link rel="stylesheet" href="<?= base_url('css/authentication.css') ?>">


<div class="card text-center mx-auto d-flex justify-content-center align-items-center" style="width: 20rem;">
    <div class="" style="width: 18rem;">
        <div class="text-center">
            <h4 class="card-title mt-3">LOGIN</h4>
            <img style="width: 27%;" src="<?php echo base_url("img/login/logoUser.webp")?>" alt="Logo Usuario">
        </div>  
        <div class="card-body">
            <form method="POST" action="<?= base_url("auth/login") ?>">
            
                <div class="input-group mb-3">
                    <span class="input-group-text"> <img style="width: 70%;" src=<?php echo base_url("img/login/usuario_input.webp") ?>></span>
                    <div class="form-floating">
                        <input class="form-control" id="email" name="email" placeholder="user@gmail.com" type="text" required></input>
                        <label for="email" >Email</label>
                    </div>
                </div>
                
                <div class="input-group mb-3">
                    <span class="input-group-text"><img style="width: 70%;" src=<?php echo base_url("img/login/contraseña_input.webp") ?>></span>
                    <div class="form-floating">
                        <input class="form-control" id="password" name="password" placeholder="*********" type="password" required></input>
                        <label for="password" >Contraseña</label>
                    </div>
                </div>
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
                <div>
                    <button class="btn btn-success rounded-pill" style="width: 100%;" type="submit">Login</button>
                </div>
            </form>
        </div>      
        
    </div>
</div>



<?php echo $this->endSection(); ?>