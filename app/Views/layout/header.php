<nav class="navbar bg-body-tertiary">
  <div class="container-fluid" >
      
    <span class="navbar-text" style="font-size:large;"><b><?php echo $icon;?></b></span>
      
    <div class="d-flex">
        <span class="navbar-text me-3">
            <b> <?php echo session()->get('user_name');?> 
            <img src="<?= base_url("img/header/icono-usuario.webp") ?>" width="25" height="25" alt="UserIcon" 
                data-bs-toggle="popover" 
                data-bs-title="Perfil"
                data-bs-content="Haz clic para ver tu perfil"
                data-bs-placement="bottom"
                role="button"
                style="cursor: pointer;">
            </b>
        </span>
        <button type="button" class="btn btn-outline-danger ms-1" width="5px" onclick="window.location.href='<?= base_url('auth/logout') ?>'">
                <i class="bi bi-box-arrow-right"></i>
        </button>
    </div>
  </div>
</nav>