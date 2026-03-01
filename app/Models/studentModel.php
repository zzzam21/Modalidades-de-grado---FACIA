<?php

namespace App\Models;

use CodeIgniter\Model;

class studentModel extends Model{

    protected $table = 'students';

    protected $primaryKey = 'student_ID';
    
    protected $allowedFields = ['student_ID','code', 'program_ID', 'name_student'];

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
        
        $user_programModel = new user_programModel();
        $program = $user_programModel->userProgram($userId);
        return $this->where('program_ID', $program['program_ID'])->countAllResults();
    }

    public function getStudentsByProgram(){
        if (!session()->has('user_id')) {
            return null; // O redirigir a la página de inicio de sesión
        }
        $userId = session()->get('user_id');

        $user_programModel = new user_programModel();
        $program = $user_programModel->userProgram($userId);
        $data["Program"] = $program;
        $data["Students"] = $this->select('students.*, m.type_modality as type_modalitie')
                                ->join('modalitie_student mo', 'mo.student_ID = students.student_ID')
                                ->join('modalities m', 'm.modality_ID = mo.modality_ID')
                                ->where('students.program_ID', $program['program_ID'])->findAll();
        return $data;
    }
}