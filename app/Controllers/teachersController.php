<?php

namespace App\Controllers;

class teachersController extends BaseController {
    public function teachers(): string{
        $data = ['tittle' => 'Docentes',
                 'icon' => '<i class="bi bi-clipboard-check"></i> Docentes'];
        $teachersModel = new \App\Models\teachersModel();
        $data['teachers'] = $teachersModel->getTeachers();
        return view('dashboard/teachers',$data);
    }
}