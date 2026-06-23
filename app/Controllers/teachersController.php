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
    public function teacher($id): string {
        $data = ['tittle' => 'Docente',
                 'icon' => '<i class="bi bi-clipboard-check"></i> Docente / ',
                 'id' => $id];
        return view('dashboard/Modules/teacher',$data);
    }
    public function getTeacher($id): ResponseInterface {
        $teachersModel = new \App\Models\teachersModel();
        
        return $this->response->setJSON([
            'teacher' => $teachersModel->getTeacher($id),
            'asesor' => $teachersModel->countByRole($id, 'Asesor'),
            'coasesor' => $teachersModel->countByRole($id, 'Coasesor'),
            'jurado' => $teachersModel->countByRole($id, 'Jurado'),
            'proceso' => $teachersModel->countModalitiesByStatus($id, ['aprobada', 'En curso']),
            'finalizadas' => $teachersModel->countModalitiesByStatus($id, ['Finalizada'])
        ]);
    }
    public function getInfoModalityByTeacher($id): ResponseInterface {
        $teachersModel = new \App\Models\teachersModel();
        $data = $teachersModel->getModalityInfoByTeacher($id);
        return $this->response->setJSON($data);
    }
}