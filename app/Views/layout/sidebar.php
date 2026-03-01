<div class="sidebar" id="sidebar">
    <nav class="nav flex-column">
        <a href="#" class="nav-link" id="toggleSidebar">
            <span class="icon">
                <i class="bi bi-list"></i>
            </span>
            <span class="description">Menu</span>
        </a>
        <a href="<?= base_url("dashboard") ?>" class="nav-link" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Inicio" data-bs-placement="auto">
            <span class="icon">
                <i class="bi bi-house-door"></i>
            </span>
            <span class="description">Inicio</span>
        </a>
        
        <a href="<?= base_url("students") ?>" class="nav-link" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Estudiantes" data-bs-placement="auto">
            <span class="icon">
                <i class="bi bi-backpack"></i>
            </span>
            <span class="description">Estudiantes</span>
        </a>
        
        <a href="<?= base_url("teachers") ?>" class="nav-link" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Docentes" data-bs-placement="auto">
            <span class="icon">
                <i class="bi bi-clipboard-check"></i>
            </span>
            <span class="description">Docentes</span>
        </a>
        
        <a href="<?= base_url("modalities") ?>" class="nav-link" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Modalidades" data-bs-placement="auto">
            <span class="icon">
                <i class="bi bi-mortarboard"></i>
            </span>
            <span class="description">Modalidades</span>
        </a>
        
        <a href="<?= base_url("configuration") ?>" class="nav-link" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Configuración" data-bs-placement="auto">
            <span class="icon">
                <i class="bi bi-gear"></i>
            </span>
            <span class="description">Perfil</span>
        </a>
    </nav>
</div>