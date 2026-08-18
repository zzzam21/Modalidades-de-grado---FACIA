<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class modalitieController extends BaseController {

    public function modalities(): string {
        $data = ['tittle' => 'Modalidades',
                 'icon' => '<i class="bi bi-mortarboard"></i> Modalidades'];
        return view('dashboard/modalities',$data);
    }

    public function modality($id): string{
        $data = ['tittle' => 'Modalidad',
                'icon' => '<i class="bi bi-mortarboard"></i> Modalidad',
                'id' => $id];
        return view('dashboard/Modules/modality', $data);
    }

    public function getModality($id): ResponseInterface{ 
        
        $studentModel = new \App\Models\studentModel();
        $asesorModel = new \App\Models\teachersModel();
        
        $db = \Config\Database::connect();
        $builder = $db->table('modalities m');
        $builder->select('m.*, tm.type_name as type_modality');
        $builder->join('type_modalities tm', 'm.id_type_mod = tm.id_type_mod', 'left');
        $builder->join('users_program up', 'm.program_ID = up.program_ID');
        $builder->where('m.modality_ID', $id);
        $builder->where('up.user_ID', session('user_id'));
        $data = $builder->get()->getRow();
        $student = $studentModel->getStudentByModality($id);
        $asesor = $asesorModel->getAsesor($id);
        $coasesor = $asesorModel->getCoAsesor($id);
        $jurado = $asesorModel->getJurado($id);

        if ($data) {
            return $this->response->setJSON([
                'success' => true,
                'data'    => $data,
                'student' => $student,
                'asesor' => $asesor,
                'coasesor' => $coasesor,
                'jurado' => $jurado
            ]);
        }

        return $this->response->setStatusCode(404)->setJSON([
            'success' => false,
            'message' => 'Modalidad no encontrada.'
        ]);
    }

    public function getmodalities(){
        $db = \Config\Database::connect();
        $builder = $db->table('modalities m');
        $builder->select('m.*, tm.type_name as type_modality');
        $builder->join('type_modalities tm', 'm.id_type_mod = tm.id_type_mod', 'left');
        $builder->join('users_program up', 'm.program_ID = up.program_ID');
        $builder->where('up.user_ID', session('user_id'));
        $data = $builder->get()->getResult();
        return $this->response->setJSON($data);
    }

    public function processModalitie(){
        
        $data = $this->request->getJSON(true);
        
        if (!$data) {
            return $this->response->setJSON([
                "success" => false,
                "message" => "No se recibieron datos!"
            ]);
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

            if (!$no_acuerdo) {
                throw new Exception('El n\u00famero de Acuerdo es obligatorio.');
            }

            if (!$modality_status) {
                throw new Exception('El estado de la modalidad es obligatorio.');
            }

            if (empty($data["estudiantes"])) {
                throw new Exception('Debe haber al menos un estudiante.');
            }

            foreach ($data["estudiantes"] as $i => $student) {
                $code = str_replace('.', '', $student["codigo_estudiantil"] ?? '');
                $name = trim($student["nombre"] ?? '');
                $sede = $student["sede_codigo"] ?? '';

                if (!$code || !$name || !$sede) {
                    throw new Exception('Datos incompletos del estudiante #' . ($i + 1) . ': c\u00f3digo, nombre y programa/sede son obligatorios.');
                }
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
                'duration' => $modality_duration
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
            if ($data["asesores"] && !empty($data["asesores"])) {
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
            $db->transComplete();
            
            return $this->response->setJSON([
                "success"=>true,
                "message"=>"Modalidad creada correctamente"
            ]);

        } catch (Exception) {
            $db->transRollback();
            return $this->response->setJSON([
                "success"=> false,
                "message"=>"Error al guardar la modalidad. Por favor, intente nuevamente."
            ]);
        }
    }

    public function getFormData()
    {
        $typeModel = new \App\Models\typeModalitieModel();
        $programModel = new \App\Models\programModel();
        return $this->response->setJSON([
            'type_modalities' => $typeModel->findAll(),
            'programs' => $programModel->findAll()
        ]);
    }

    public function updateStatus($id)
    {
        $status = $this->request->getJSON(true)['status'] ?? null;

        if (!in_array($status, ['aprobada', 'En curso', 'Cancelado', 'Finalizado'], true)) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Estado inválido.'
            ]);
        }

        $db = \Config\Database::connect();

        if ($status === 'Finalizado') {
            $modality = $db->table('modalities')
                           ->select('date_sustentacion')
                           ->where('modality_ID', $id)
                           ->get()
                           ->getRow();

            if (empty($modality->date_sustentacion)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'message' => 'Debe registrar una fecha de sustentación antes de finalizar.'
                ]);
            }

            $fechaSustentacion = new \DateTime($modality->date_sustentacion);
            $hoy = new \DateTime();
            $hoy->setTime(0, 0, 0);

            if ($fechaSustentacion > $hoy) {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'message' => 'La fecha de sustentación aún no ha pasado. No es posible finalizar.'
                ]);
            }
        }
        $authorized = $db->table('modalities m')
                    ->join('users_program up', 'm.program_ID = up.program_ID')
                    ->where('m.modality_ID', $id)
                    ->where('up.user_ID', session('user_id'))
                    ->countAllResults();

        if ($authorized === 0) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'No tiene permiso para actualizar esta modalidad.'
            ]);
        }

        $modalityModel = new \App\Models\modalitieModel();
        $updated = $modalityModel->update($id, ['status' => $status]);

        if (!$updated) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Modalidad no encontrada.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Estado actualizado correctamente'
        ]);
    }

    public function updateSustentacion($id)
    {
        $date = $this->request->getJSON(true)['date_sustentacion'] ?? null;

        if ($date !== null && $date !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}(T\d{2}:\d{2}(:\d{2})?)?$/', $date)) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Fecha de sustentación inválida.'
            ]);
        }

        $db = \Config\Database::connect();
        $modality = $db->table('modalities m')
                    ->select('m.status')
                    ->join('users_program up', 'm.program_ID = up.program_ID')
                    ->where('m.modality_ID', $id)
                    ->where('up.user_ID', session('user_id'))
                    ->get()
                    ->getRow();

        if (!$modality) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'No tiene permiso para actualizar esta modalidad.'
            ]);
        }

        if (!in_array($modality->status, ['aprobada', 'En curso'], true)) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'La fecha de sustentación solo puede definirse cuando la modalidad está en proceso.'
            ]);
        }

        $datetime = ($date === null || $date === '') ? null : str_replace('T', ' ', $date);
        if ($datetime !== null && !str_contains($datetime, ':')) {
            $datetime .= ' 00:00:00';
        }

        $modalityModel = new \App\Models\modalitieModel();
        $updated = $modalityModel->update($id, ['date_sustentacion' => $datetime]);

        if (!$updated) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Modalidad no encontrada.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Fecha de sustentación actualizada correctamente'
        ]);
    }

    public function updateModality($id)
    {
        $data = $this->request->getJSON(true);

        if (!$data) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'No se recibieron datos!'
            ]);
        }

        $db = \Config\Database::connect();

        $authorized = $db->table('modalities m')
                    ->join('users_program up', 'm.program_ID = up.program_ID')
                    ->where('m.modality_ID', $id)
                    ->where('up.user_ID', session('user_id'))
                    ->countAllResults();

        if ($authorized === 0) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'No tiene permiso para editar esta modalidad.'
            ]);
        }

        $currentStatus = $db->table('modalities')
                        ->where('modality_ID', $id)
                        ->get()->getRow()->status;

        if ($currentStatus === 'Cancelado') {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'No se pueden modificar modalidades canceladas.'
            ]);
        }

        $studentModel = new \App\Models\studentModel();
        $studentModalityModel = new \App\Models\modalitie_studentModel();
        $modalityModel = new \App\Models\modalitieModel();
        $teacherModel = new \App\Models\teachersModel();
        $modality_teacherModel = new \App\Models\modalitie_teacherModel();

        try {
            $modality_name = mb_strtolower($data["modalidad"]["nombre_trabajo"]);
            $modality_name = ucfirst($modality_name);
            $modality_type_id = $data["modalidad"]["id_modalidad"];
            $modality_status = $data["modalidad"]["estado_modalidad"];
            $modality_start_date = $data["modalidad"]["fecha_inicio_modalidad"];
            $modality_objectives = $data["modalidad"]["objetivos_modalidad"];
            $modality_duration = $data["modalidad"]["duracion_modalidad"];
            $modality_end = $data["modalidad"]["fin_estimado_modalidad"];
            $sede = $data["estudiantes"][0]["sede_codigo"];

            if (!$modality_name || !$modality_type_id) {
                throw new Exception('Modalidad incompleta: nombre o tipo de modalidad no encontrados.');
            }

            if (!$modality_status) {
                throw new Exception('El estado de la modalidad es obligatorio.');
            }

            if (empty($data["estudiantes"])) {
                throw new Exception('Debe haber al menos un estudiante.');
            }

            foreach ($data["estudiantes"] as $i => $student) {
                $code = str_replace('.', '', $student["codigo_estudiantil"] ?? '');
                $name = trim($student["nombre"] ?? '');
                $document = str_replace('.', '', $student["documento_identidad"] ?? '');
                $sede = $student["sede_codigo"] ?? '';

                if (!$code || !$name || !$document || !$sede) {
                    throw new Exception('Datos incompletos del estudiante #' . ($i + 1) . ': código, documento, nombre y programa/sede son obligatorios.');
                }
            }

            $allowedPrograms = $db->table('users_program')
                            ->where('user_ID', session('user_id'))
                            ->get()->getResultArray();
            $allowedProgramIds = array_column($allowedPrograms, 'program_ID');

            if (!in_array($sede, $allowedProgramIds, true)) {
                throw new Exception('El programa/sede seleccionado no corresponde a su programa asignado.');
            }

            $db->transStart();

            $modality_data = [
                'name_modalitie' => $modality_name,
                'program_ID' => $sede,
                'id_type_mod' => $modality_type_id,
                'status' => $modality_status,
                'goal' => json_encode($modality_objectives),
                'date_approved' => $modality_start_date,
                'date_end' => $modality_end,
                'duration' => $modality_duration
            ];

            $modalityModel->update($id, $modality_data);

            // Sincronizar estudiantes
            $previousStudents = $studentModalityModel->deleteModalityStudent($id);
            $previousStudentIds = array_column($previousStudents, 'student_ID');

            $newStudentIds = [];
            foreach ($data["estudiantes"] as $student) {
                $code = str_replace('.', '', $student["codigo_estudiantil"]);
                $name = ucwords(strtolower($student["nombre"]));
                $document = str_replace('.', '', $student["documento_identidad"]);
                $sede = $student["sede_codigo"];

                if (!$document) {
                    $document = $code;
                }

                $studentData = [
                    'student_ID' => $document,
                    'code' => $code,
                    'program_ID' => $sede,
                    'name_student' => $name
                ];

                if ($studentModel->getStudentById($document)) {
                    $studentModel->update($document, $studentData);
                } else {
                    $studentModel->addStudent($studentData);
                }

                $studentModalityModel->addModalitieStudent([
                    'modality_ID' => $id,
                    'student_ID' => $document
                ]);

                $newStudentIds[] = $document;
            }

            // Eliminar registros de estudiantes removidos (solo si no están en otra modalidad)
            $removedStudentIds = array_diff($previousStudentIds, $newStudentIds);
            foreach ($removedStudentIds as $removedId) {
                $inOtherModality = $db->table('modalitie_student')
                                ->where('student_ID', $removedId)
                                ->where('modality_ID !=', $id)
                                ->countAllResults();

                if ($inOtherModality === 0) {
                    $studentModel->delete($removedId);
                }
            }

            // Sincronizar docentes
            $modality_teacherModel->deleteModalityTeacher($id);

            $roles = [
                'asesores' => 'Asesor',
                'coasesores' => 'Coasesor',
                'jurados' => 'Jurado'
            ];

            foreach ($roles as $key => $role) {
                if (isset($data[$key]) && !empty($data[$key])) {
                    foreach ($data[$key] as $person) {
                        $person_name = $person['nombre'] ?? null;
                        if ($person_name) {
                            $teacher_ID = $teacherModel->getOrCreateTeacher($person_name);
                            $modality_teacherModel->insert([
                                'teacher_ID' => $teacher_ID,
                                'modality_ID' => $id,
                                'role' => $role
                            ]);
                        }
                    }
                }
            }

            $db->transCommit();
            $db->transComplete();

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Modalidad actualizada correctamente'
            ]);

        } catch (Exception) {
            $db->transRollback();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al actualizar la modalidad. Por favor, intente nuevamente.'
            ]);
        }
    }

    public function deleteModality($id)
    {
        $db = \Config\Database::connect();
        $authorized = $db->table('modalities m')
                    ->join('users_program up', 'm.program_ID = up.program_ID')
                    ->where('m.modality_ID', $id)
                    ->where('up.user_ID', session('user_id'))
                    ->countAllResults();

        if ($authorized === 0) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'No tiene permiso para eliminar esta modalidad.'
            ]);
        }

        $modalityModel = new \App\Models\modalitieModel();
        $teacherModalityModel = new \App\Models\modalitie_teacherModel();
        $studentModalityModel = new \App\Models\modalitie_studentModel();
        $studentModel = new \App\Models\studentModel();

        $teacherModalityModel->deleteModalityTeacher($id);
        $studentsID = $studentModalityModel->deleteModalityStudent($id);

        foreach ($studentsID as $student) {
            $studentModel->delete($student['student_ID']);
        }

        $modalityModel->delete($id);

        return $this->response->setJSON([
            'success' => true,
            'message' => "Modalidad eliminada correctamente"
        ]);
    }
}