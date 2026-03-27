<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- BootStrap Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- AdminLte Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- DataTable Styles -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.min.css">
    <!-- Own styles -->
    <link rel="stylesheet" href="<?= base_url("css/sidebar.css") ?>">
    <link rel="stylesheet" href="<?= base_url("css/main.css") ?>">
    <title><?php echo $tittle;?></title>
</head>

<body>
    <?= $this->include('layout/sidebar') ?>
    
    <div class="page-wrapper d-flex">

        <div class="main-content">
            <header>
                <?= $this->include('layout/header') ?>
            </header>
            
            <!-- Renderizar contenido Principal -->
            <main class="content">
                <div class="container">
                    <?= $this->renderSection('content') ?>
                </div>
            </main>

            <footer>
                <?= $this->include('layout/footer') ?>
            </footer>
        </div>
        
    </div>

    <!-- BootStrap -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.bootstrap5.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- AdminLte -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    
    <!-- Own Scripts -->
    <!-- Sidebar -->
    <script src="<?= base_url("js/sidebar.js") ?>"></script>
    <!-- popovers -->
    <script src="<?= base_url("js/popovers.js") ?>"></script>
    <!-- tooltip -->
    <script src="<?= base_url("js/tooltip.js") ?>"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.min.js"></script>

        <!-- common -->
    <script src="<?= base_url('js/tables/common.js') ?>"></script>
        <!-- modalitiesDataTables -->
    <script src="<?= base_url("js/tables/modalitiesDataTable.js") ?>"></script>
        <!-- studentDataTables -->
    <script src="<?= base_url("js/tables/studentDataTable.js") ?>"></script>
        <!-- teachersDataTables -->
    <script src="<?= base_url("js/tables/teachersDataTables.js") ?>"></script>

    <!-- API -->
        <!-- ModalitiesAPI -->
    <script src="<?= base_url("js/api/modalitiesAPI.js") ?>"></script>
        <!-- UserAPI -->
    <script src="<?= base_url("js/api/configCRUD.js") ?>"></script>
    
</body>
</html>