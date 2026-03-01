<?php

namespace App\Controllers;

class studentController extends BaseController {
    public function students(): string{
        $data = ['tittle' => 'Estudiantes',
                 'icon' => '<i class="bi bi-backpack"></i> Estudiantes'];
        $studentModel = new \App\Models\studentModel();
        $data['students'] = $studentModel->getStudentsByProgram();
        
        return view('dashboard/students',$data);
    }
}