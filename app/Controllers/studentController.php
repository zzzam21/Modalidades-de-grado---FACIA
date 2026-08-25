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

    public function updateStudent($id): ResponseInterface{
        $userId = session()->get('user_id');

        if (!$userId) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => 'error',
                'message' => 'No autenticado'
            ]);
        }

        $data = $this->request->getJSON();

        if (!$data || empty($data->name_student) || empty($data->code)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'Nombre y código son requeridos'
            ]);
        }

        $studentModel = new \App\Models\studentModel();
        $student = $studentModel->getStudentById($id);

        if (!$student) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Estudiante no encontrado'
            ]);
        }

        $existing = $studentModel->findByCode($data->code);
        if ($existing && $existing['student_ID'] != $id) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'Ya existe otro estudiante con ese código'
            ]);
        }

        $studentModel->update($id, [
            'name_student' => $data->name_student,
            'code' => $data->code
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Estudiante actualizado correctamente'
        ]);
    }
}