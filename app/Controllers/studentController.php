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

    public function student($id): string{
        $data = ['tittle' => 'Estudiante',
                 'icon' => '<i class="bi bi-backpack"></i> Estudiante',
                'id' => $id];
        
        return view('dashboard/Modules/student',$data);
    }

    public function getStudent($id): ResponseInterface{
        $studentModel = new \App\Models\studentModel();
        return $this->response->setJSON([
            'student' => $studentModel->getStudentById($id),
            'modality' => $studentModel->getModalityByStudent($id)
        ]);
    }
}