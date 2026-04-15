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
        
        $data = $this->select('students.*, m.type_modality as type_modalitie, p.program_name, p.sede')
                     ->join('modalitie_student mo', 'mo.student_ID = students.student_ID')
                     ->join('modalities m', 'm.modality_ID = mo.modality_ID')
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
            return $this->select('m.* , t.name, mt.role')
                        ->join('modalitie_student ms', 'ms.student_ID = students.student_ID')
                        ->join('modalitie_teacher mt', 'ms.modality_ID = mt.modality_ID')
                        ->join('modalities m', 'm.modality_ID = ms.modality_ID')
                        ->join('teachers t', 'mt.teacher_ID = t.teacher_ID')
                        ->where('students.student_ID', $id)->findAll();
        }
    }    
}