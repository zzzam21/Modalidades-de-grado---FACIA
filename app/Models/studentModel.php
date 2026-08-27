<?php

namespace App\Models;

use CodeIgniter\Model;

class studentModel extends Model{

    protected $table = 'students';

    protected $primaryKey = 'student_ID';
    
    protected $allowedFields = ['student_ID','code', 'program_ID', 'name_student'];

    public function getStudentById($id){
        return $this->where('student_ID', $id)->first();
    }
    
    public function findByCode($code) {
        return $this->where('code', $code)->first();
    }

    public function addStudent($data){
        return $this->insert($data);
    }
    
    public function countStudents () {
        if (!session()->has('user_id')) {
            return null; // O redirigir a la página de inicio de sesión
        }
        $userId = session()->get('user_id');
        
        return $this->join('users_program', 'users_program.program_ID = students.program_ID')
                    ->join('modalitie_student', 'modalitie_student.student_ID = students.student_ID')
                    ->join('modalities', 'modalities.modality_ID = modalitie_student.modality_ID')
                    ->join('programs', 'programs.program_ID = users_program.program_ID')
                    ->join('users', 'users.id = users_program.user_ID')
                    ->where('users.id', $userId)
                    ->whereNotIn('modalities.status', ['Cancelado', 'Finalizado'])
                    ->countAllResults();
    }

    public function getStudentsByProgram(){
        if (!session()->has('user_id')) {
            return null; // O redirigir a la página de inicio de sesión
        }
        $userId = session()->get('user_id');

        $user_programModel = new user_programModel();
        $program = $user_programModel->userProgram($userId);
        
        $data = $this->select('students.*, tm.type_name as type_modalitie, p.program_name, p.sede, m.status')
                     ->join('modalitie_student mo', 'mo.student_ID = students.student_ID')
                     ->join('modalities m', 'm.modality_ID = mo.modality_ID')
                     ->join('type_modalities tm', 'm.id_type_mod = tm.id_type_mod', 'left')
                     ->join('programs p', 'students.program_ID = p.program_ID')
                     ->where('students.program_ID', $program['program_ID'])->findAll();
        return $data;
    }

    public function getStudentByModality($id){
        if ($id){
            return $this->select('students.*')
                        ->join('modalitie_student ms', 'ms.student_ID = students.student_ID')
                        ->where('ms.modality_ID',$id)->findAll();
        }
    }
    public function getModalityByStudent($id){
        if ($id){
            return $this->select('m.*, t.name, mt.role, tm.type_name as type_modality')
                        ->join('modalitie_student ms', 'ms.student_ID = students.student_ID')
                        ->join('modalitie_teacher mt', 'ms.modality_ID = mt.modality_ID')
                        ->join('modalities m', 'm.modality_ID = ms.modality_ID')
                        ->join('type_modalities tm', 'm.id_type_mod = tm.id_type_mod', 'left')
                        ->join('teachers t', 'mt.teacher_ID = t.teacher_ID')
                        ->where('students.student_ID', $id)->findAll();
        }
    }

    public function updateStudent($id, $data){
        return $this->update($id, $data);
    }

    public function deleteStudent($id){
        $this->delete($id);
    }
}