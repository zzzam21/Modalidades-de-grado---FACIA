<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class AlertController extends BaseController
{
    public function alert(): string {
        $data = ['tittle' => 'Alertas',
                 'icon' => '<i class="bi bi-exclamation-triangle"></i> Alertas'];
        return view('dashboard/alerts', $data);
    }

    public function getAlertas(): ResponseInterface {
        $modalityModel = new \App\Models\modalitieModel();
        $vencidas = $modalityModel->getAlertasVencidas();
        $proximas = $modalityModel->getAlertasProximas();

        return $this->response->setJSON([
            'vencidas' => $vencidas,
            'proximas' => $proximas
        ]);
    }
}
