<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe Ejecutivo - <?= esc($teacher['name'] ?? '') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        .report-container { max-width: 1100px; margin: 0 auto; padding: 30px; }

        .report-header {
            background: linear-gradient(135deg, #1a73e8, #0d47a1);
            color: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }
        .report-header::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        .report-header h1 { font-size: 1.6rem; font-weight: 700; margin-bottom: 5px; }
        .report-header .subtitle { font-size: 1.1rem; opacity: 0.9; }
        .report-header .meta { font-size: 0.85rem; opacity: 0.75; margin-top: 10px; }

        .kpi-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; margin-bottom: 30px; }
        .kpi-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border-top: 3px solid #dee2e6;
        }
        .kpi-card.asesor    { border-top-color: #28a745; }
        .kpi-card.coasesor  { border-top-color: #ffc107; }
        .kpi-card.jurado    { border-top-color: #0d6efd; }
        .kpi-card.proceso   { border-top-color: #fd7e14; }
        .kpi-card.finalizadas { border-top-color: #20c997; }
        .kpi-card.total     { border-top-color: #6f42c1; }
        .kpi-card .kpi-value { font-size: 2rem; font-weight: 700; color: #333; }
        .kpi-card .kpi-label { font-size: 0.8rem; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; }

        .section-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e9ecef;
        }

        .table-report { background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .table-report thead { background: #1a73e8; color: #fff; }
        .table-report thead th { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 14px; font-weight: 600; border: none; }
        .table-report tbody td { padding: 11px 14px; font-size: 0.85rem; vertical-align: middle; border-color: #f0f0f0; }
        .table-report tbody tr:hover { background: #f8f9ff; }

        .badge-status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-aprobada      { background: #d4edda; color: #155724; }
        .badge-en-curso      { background: #fff3cd; color: #856404; }
        .badge-finalizada    { background: #d1ecf1; color: #0c5460; }
        .badge-cancelado     { background: #f8d7da; color: #721c24; }
        .badge-default       { background: #e9ecef; color: #495057; }

        .badge-role {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .role-asesor    { background: #d4edda; color: #155724; }
        .role-coasesor  { background: #fff3cd; color: #856404; }
        .role-jurado    { background: #cce5ff; color: #004085; }

        .no-data { color: #adb5bd; font-style: italic; }

        .report-footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            font-size: 0.8rem;
            color: #6c757d;
        }

        .btn-print {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            border-radius: 50px;
            padding: 12px 28px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        @media print {
            body { background: #fff; }
            .btn-print { display: none !important; }
            .report-container { padding: 0; }
            .report-header {
                background: #1a73e8 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .table-report thead {
                background: #1a73e8 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .kpi-card { break-inside: avoid; }
            .table-report { break-inside: auto; }
            .table-report tr { break-inside: avoid; }
        }
    </style>
</head>
<body>

<div class="report-container">

    <!-- ENCABEZADO -->
    <div class="report-header">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h1>Informe Ejecutivo de Trabajos de Grado</h1>
                <div class="subtitle">Docente: <?= esc($teacher['name'] ?? 'Sin nombre') ?></div>
                <div class="meta">
                    <i class="bi bi-calendar3"></i> Fecha de generacion: <?= esc($fecha) ?>
                </div>
            </div>
            <div class="text-end">
                <div style="font-size: 0.85rem; opacity: 0.8;">ID Docente</div>
                <div style="font-size: 1.4rem; font-weight: 700;"><?= esc($teacher['teacher_ID'] ?? '') ?></div>
            </div>
        </div>
    </div>

    <!-- KPIs -->
    <h2 class="section-title"><i class="bi bi-bar-chart-line"></i> Resumen Ejecutivo</h2>
    <div class="kpi-row">
        <div class="kpi-card total">
            <div class="kpi-value"><?= $total ?></div>
            <div class="kpi-label">Total Trabajos</div>
        </div>
        <div class="kpi-card asesor">
            <div class="kpi-value"><?= $asesor ?></div>
            <div class="kpi-label">Como Asesor</div>
        </div>
        <div class="kpi-card coasesor">
            <div class="kpi-value"><?= $coasesor ?></div>
            <div class="kpi-label">Como Coasesor</div>
        </div>
        <div class="kpi-card jurado">
            <div class="kpi-value"><?= $jurado ?></div>
            <div class="kpi-label">Como Jurado</div>
        </div>
        <div class="kpi-card proceso">
            <div class="kpi-value"><?= $enProceso ?></div>
            <div class="kpi-label">En Proceso</div>
        </div>
        <div class="kpi-card finalizadas">
            <div class="kpi-value"><?= $finalizadas ?></div>
            <div class="kpi-label">Finalizadas</div>
        </div>
    </div>

    <!-- TABLA DETALLADA -->
    <h2 class="section-title"><i class="bi bi-list-task"></i> Detalle de Trabajos de Grado</h2>
    <?php if (empty($modalities)): ?>
        <div class="table-report p-4 text-center">
            <p class="no-data mb-0">Este docente no tiene trabajos de grado registrados.</p>
        </div>
    <?php else: ?>
        <div class="table-report">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titulo</th>
                        <th>Tipo</th>
                        <th>Estudiante(s)</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>F. Aprobacion</th>
                        <th>F. Sustentacion</th>
                        <th>Duracion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($modalities as $m): ?>
                        <tr>
                            <td><strong><?= esc($m['modality_ID']) ?></strong></td>
                            <td><?= esc($m['name_modalitie']) ?></td>
                            <td><?= esc($m['type_modalitie'] ?? '-') ?></td>
                            <td>
                                <?php if (!empty($m['students'])): ?>
                                    <?= esc($m['students']) ?>
                                <?php else: ?>
                                    <span class="no-data">Sin asignar</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                    $roleClass = '';
                                    switch ($m['role']) {
                                        case 'Asesor':   $roleClass = 'role-asesor';   break;
                                        case 'Coasesor': $roleClass = 'role-coasesor'; break;
                                        case 'Jurado':   $roleClass = 'role-jurado';   break;
                                    }
                                ?>
                                <span class="badge-role <?= $roleClass ?>"><?= esc($m['role']) ?></span>
                            </td>
                            <td>
                                <?php
                                    $statusClass = 'badge-default';
                                    switch ($m['status']) {
                                        case 'aprobada':     $statusClass = 'badge-aprobada';   break;
                                        case 'En curso':     $statusClass = 'badge-en-curso';   break;
                                        case 'Finalizada':   $statusClass = 'badge-finalizada'; break;
                                        case 'Cancelado':    $statusClass = 'badge-cancelado';  break;
                                    }
                                ?>
                                <span class="badge-status <?= $statusClass ?>"><?= esc($m['status']) ?></span>
                            </td>
                            <td><?= !empty($m['date_approved']) ? esc($m['date_approved']) : '-' ?></td>
                            <td><?= !empty($m['date_sustentacion']) ? esc($m['date_sustentacion']) : '-' ?></td>
                            <td><?= !empty($m['duration']) ? esc($m['duration']) : '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <!-- PIE -->
    <div class="report-footer">
        <p class="mb-1">Sistema de Gestion de Modalidades Academicas</p>
        <p class="mb-0">Generado el <?= esc($fecha) ?></p>
    </div>

</div>

<!-- BOTON IMPRIMIR -->
<button class="btn btn-primary btn-print" onclick="window.print()">
    <i class="bi bi-printer me-2"></i> Imprimir / Exportar PDF
</button>

</body>
</html>
