<?php

namespace App\Controllers;
use Exception;

class modalitieController extends BaseController {

    public function modalities(): string {
        $data = ['tittle' => 'Modalidades',
                 'icon' => '<i class="bi bi-mortarboard"></i> Modalidades'];
        $modalityModel = new \App\Models\modalitieModel();
        $data['modalities'] = $modalityModel->getModalities();
        return view('dashboard/modalities',$data);
    }

    public function getmodalities(){
        $modalityModel = new \App\Models\modalitieModel();
        $data = $modalityModel->findAll();
        return $this->response->setJSON($data);
    }

    public function processModalitie(){
        // Recuperar datos de la sesión (enviados por importPdfController)
        $data = session()->get('modalityData');
        
        if (!$data) {
            return redirect()->to('/modalities')->with('error', 'No hay datos para procesar. Intente nuevamente.');
        }
        
        // Validar campos críticos de modalidad
        if (empty($data["modalidad"]["No_acuerdo"])) {
            return redirect()->to('/modalities')->with('error', 'Error: Número de acuerdo no encontrado en el PDF.');
        }
        
        $studentModel = new \App\Models\studentModel();
        $studentModalityModel = new \App\Models\modalitie_studentModel();
        $modality_model = new \App\Models\modalitieModel();
        $teacherModel = new \App\Models\teachersModel();
        $modality_teacherModel = new \App\Models\modalitie_teacherModel();

        try {
            $db = \Config\Database::connect();
            
            // Iniciar transacción
            $db->transStart();

            // Guardar Modalidad
            $modality_name = mb_strtolower($data["modalidad"]["nombre_trabajo"]); 
            $modality_name = ucfirst($modality_name);
            $modality_type = $data["modalidad"]["tipo_modalidad"];
            $modality_type_id = $data["modalidad"]["id_modalidad"];
            $no_acuerdo = $data["modalidad"]["No_acuerdo"];
            $modality_status = $data["modalidad"]["estado_modalidad"];
            $modality_start_date = $data["modalidad"]["fecha_inicio_modalidad"];
            $modality_objectives = $data["modalidad"]["objetivos_modalidad"];
            $modality_duration = $data["modalidad"]["duracion_modalidad"];
            $modality_end = $data["modalidad"]["fin_estimado_modalidad"];
            $sede = $data["estudiantes"][0]["sede_codigo"]; 
            
            // Validar datos de modalidad
            if (!$modality_name || !$modality_type_id) {
                throw new Exception('Modalidad incompleta: nombre o tipo de modalidad no encontrados.');
            }
            
            $modality_data = [
                'modality_ID' => $no_acuerdo,
                'name_modalitie' => $modality_name, 
                'program_ID' => $sede, 
                'id_type_mod' => $modality_type_id, 
                'status' => $modality_status,
                'goal' => json_encode($modality_objectives),
                'date_approved' => $modality_start_date, 
                'date_end' => $modality_end,
                'duration' => $modality_duration,
                'type_modality' => $modality_type
            ];

            $modality_model->addModality($modality_data);

            // Agregar Estudiantes
            foreach ($data["estudiantes"] as $student) {

                $code = str_replace('.', '', $student["codigo_estudiantil"]);
                $name = ucwords(strtolower($student["nombre"]));
                $document = str_replace('.','',$student["documento_identidad"]);
                $sede = $student["sede_codigo"];

                if (!$document) {
                    $document = $code;
                }

                if (!$code || !$name) {
                    throw new Exception('Datos incompletos del estudiante: código o nombre faltantes.');
                }

                $studentData = [
                    'student_ID' => $document,
                    'code' => $code,
                    'program_ID' => $sede,
                    'name_student' => $name
                ];

                $studentModalityData = [
                    'modality_ID' => $no_acuerdo,
                    'student_ID' => $document
                ];
                
                // Asociar estudiante con modalidad
                $studentModel->addStudent($studentData);
                $studentModalityModel->addModalitieStudent($studentModalityData);
            }


            // ASESORES
            if ($data["asesores"] && !empty($data["asesores"])){
                foreach ($data["asesores"] as $advisor) {
                    $advisor_name = $advisor["nombre"];
                    
                    if ($advisor_name) {
                        // Obtener o crear docente
                        $teacher_ID = $teacherModel->getOrCreateTeacher($advisor_name);
                            
                        // Asociar a la modalidad con rol de Asesor
                        $modality_teacherModel->associateTeacher(
                            $teacher_ID,
                            $no_acuerdo,
                            'Asesor'
                        );
                    }
                }    
            }
            
            // COASESORES
            if ($data["coasesores"] && !empty($data["coasesores"])){
                foreach ($data["coasesores"] as $coadvisor) {
                    $coadvisor_name = $coadvisor["nombre"];
                    
                    if ($coadvisor_name) {
                        // Obtener o crear docente
                        $teacher_ID = $teacherModel->getOrCreateTeacher($coadvisor_name);
                        
                        // Asociar a la modalidad con rol de Coasesor
                        $modality_teacherModel->associateTeacher(
                            $teacher_ID, 
                            $no_acuerdo, 
                            'Coasesor'
                        );
                    }
                }
            }

            // JURADOS
            if ($data["jurados"] && !empty($data["jurados"])){
                foreach ($data["jurados"] as $juror) {
                    $juror_name = $juror["nombre"];
                    
                    if ($juror_name) {
                        // Obtener o crear docente
                        $teacher_ID = $teacherModel->getOrCreateTeacher($juror_name);
                        
                        // Asociar a la modalidad con rol de Jurado
                        $modality_teacherModel->associateTeacher(
                            $teacher_ID, 
                            $no_acuerdo, 
                            'Jurado'
                        );
                    }
                }
            }

            // Confirmar transacción
            $db->transCommit();
            session()->remove('modalityData');
            return redirect()->to('/modalities')->with('success', 'Modalidad agregada exitosamente.');

        } catch (Exception $e) {
            $db->transRollback();
            log_message('error', 'Error procesando modalidad: ' . $e->getMessage());
            return redirect()->to('/modalities')->with('error', 'Error al guardar la modalidad. Por favor, intente nuevamente.');
        }

    }

}