<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class studentController extends BaseController {
    public function students(): string{
        $data = ['tittle' => 'Estudiantes',
                 'icon' => '<i class="bi bi-backpack"></i> Estudiantes'];
        
        return view('dashboard/students',$data);
    }

    public function getStudents(): ResponseInterface{
        $studentModel = new \App\Models\studentModel();
        $data = $studentModel->getStudentsByProgram();
        return $this->response->setJSON($data);
    }
}