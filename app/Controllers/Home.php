<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {   
        $modalityModel = new \App\Models\modalitieModel();
        $studentModel = new \App\Models\studentModel();
        $teachersModel = new \App\Models\teachersModel();
        $data = ['tittle' => 'Inicio',
                 'icon' => '<i class="bi bi-house-door"></i> Inicio',
                 'countModalities' => $modalityModel->countModalitie(),
                 'countStudents' => $studentModel->countStudents(),
                 'countTeachers' => $teachersModel->teachersCount()
                 ];
        
        $modalityModel = new \App\Models\modalitieModel();
        $data['modalities'] = $modalityModel->getModalities();
        return view('dashboard/dashboard',data: $data);
    }
}