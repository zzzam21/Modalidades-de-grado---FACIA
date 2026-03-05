<?php

namespace App\Controllers;
use CodeIgniter\HTTP\ResponseInterface;


class teachersController extends BaseController {
    
    public function teachers(): string{
        $data = ['tittle' => 'Docentes',
                 'icon' => '<i class="bi bi-clipboard-check"></i> Docentes'];
        return view('dashboard/teachers',$data);
    }

    public function getTeachers(): ResponseInterface {
        $teachersModel = new \App\Models\teachersModel();
        $data = $teachersModel->getTeachers();
        return $this->response->setJSON($data);
    }
}