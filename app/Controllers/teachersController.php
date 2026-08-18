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

    public function report($id): string {
        $teachersModel = new \App\Models\teachersModel();

        $teacher = $teachersModel->getTeacher($id);
        $modalities = $teachersModel->getReportDataByTeacher($id);

        $asesor = 0;
        $coasesor = 0;
        $jurado = 0;
        $enProceso = 0;
        $finalizadas = 0;

        foreach ($modalities as $m) {
            switch ($m['role']) {
                case 'Asesor':   $asesor++;   break;
                case 'Coasesor': $coasesor++; break;
                case 'Jurado':   $jurado++;   break;
            }
            if ($m['status'] === 'Finalizada') {
                $finalizadas++;
            } else {
                $enProceso++;
            }
        }

        $data = [
            'tittle'      => 'Informe Ejecutivo - ' . ($teacher['name'] ?? ''),
            'icon'        => '<i class="bi bi-file-earmark-text"></i> Informe Ejecutivo',
            'teacher'     => $teacher,
            'modalities'  => $modalities,
            'asesor'      => $asesor,
            'coasesor'    => $coasesor,
            'jurado'      => $jurado,
            'enProceso'   => $enProceso,
            'finalizadas' => $finalizadas,
            'total'       => count($modalities),
            'fecha'       => date('d/m/Y H:i'),
        ];

        return view('dashboard/Modules/teacherReport', $data);
    }
}