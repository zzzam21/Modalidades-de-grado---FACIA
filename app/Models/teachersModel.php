<?php

namespace App\Models;

use CodeIgniter\Model;

class teachersModel extends Model{

    protected $table = 'teachers';

    protected $primaryKey = 'teacher_ID';
    
    protected $allowedFields = ['teacher_ID','name'];

    public function getTeachers(){
        return $this->findAll();
    }

    public function getTeacher($id){
        return $this->where('teacher_ID',$id)->first();
    }

    public function teachersCount(){
        if (!session()->has('user_id')) {
            return null; // O redirigir a la página de inicio de sesión
        }
        $userId = session()->get('user_id');
        return $this->join('modalitie_teacher as mt', 'teachers.teacher_ID = mt.teacher_ID')
                    ->join('modalities m', 'm.modality_ID = mt.modality_ID')
                    ->join('users_program up', 'm.program_ID = up.program_ID')
                    ->where('up.user_ID', $userId)
                    ->countAllResults();
    }

    // Buscar docente por nombre con búsqueda inteligente bidireccional
    // Maneja nombres completos, parciales y en cualquier orden
    public function findByName($name) {
        $normalized = mb_strtolower(trim($name));
        $search_words = array_filter(explode(' ', $normalized));

        // Buscar coincidencia exacta
        $teacher = $this->select('teacher_ID')
                        ->where('LOWER(name)', $normalized)
                        ->first();

        if ($teacher) {
            return $teacher;
        }

        // Búsqueda flexible
        $all_teachers = $this->select('*')->findAll();

        foreach ($all_teachers as $teacher) {

            $teacher_words = array_filter(
                explode(' ', mb_strtolower($teacher['name']))
            );

            $search_matches = 0;

            foreach ($search_words as $search_word) {
                if (in_array($search_word, $teacher_words)) {
                    $search_matches++;
                }
            }

            if ($search_matches === count($search_words)) {
                return $teacher['teacher_ID'];
            }

            if (count(array_intersect($teacher_words, $search_words)) === count($teacher_words)) {
                return $teacher['teacher_ID'];
            }
        }
        return null;
    }

    public function getOrCreateTeacher($name) {
        $normalized_name = ucwords(mb_strtolower(trim($name)));
        
        
        $teacher = $this->findByName($normalized_name);
        
        if ($teacher) {    
            return $teacher['teacher_ID'] ?? $teacher;
        } else {
            $this->insert(['name' => $normalized_name]);
            return $this->insertID();
        }
    }
    
    public function addTeacher($data){
        return $this->insert($data);
    }

    public function getAsesor($id) {
        return $this->select('teachers.*, mt.role')
                    ->join('modalitie_teacher as mt', 'mt.teacher_ID = teachers.teacher_ID')
                    ->where('mt.modality_ID',$id)
                    ->where('mt.role','Asesor')
                    ->first();
    }

    public function getCoAsesor($id) {
        return $this->select('teachers.*, mt.role')
                    ->join('modalitie_teacher as mt', 'mt.teacher_ID = teachers.teacher_ID')
                    ->where('mt.modality_ID',$id)
                    ->where('mt.role','Coasesor')
                    ->first();
    }
    public function getJurado($id) {
        return $this->select('teachers.*, mt.role')
                    ->join('modalitie_teacher as mt', 'mt.teacher_ID = teachers.teacher_ID')
                    ->where('mt.modality_ID',$id)
                    ->where('mt.role','Jurado')
                    ->findAll();
    }

    public function countByRole($id, $role) {
        if (!session()->has('user_id')) {
            return null; // O redirigir a la página de inicio de sesión
        }
        $user_id = session()->get('user_id');
        return $this
                    ->join('modalitie_teacher as mt', 'mt.teacher_ID = teachers.teacher_ID')
                    ->join('modalities m', 'm.modality_ID = mt.modality_ID')
                    ->join('users_program up', 'up.program_ID = m.program_ID')
                    ->where('mt.teacher_ID', $id)
                    ->where('mt.role', $role)
                    ->where('up.user_ID', $user_id)
                    ->countAllResults() ?? 0;
    }

    public function countModalitiesByStatus($id, $status) {
        if (!session()->has('user_id')) {
            return null; // O redirigir a la página de inicio de sesión
        }
        $user_id = session()->get('user_id');
        return $this->select('COUNT(*) as count')
                    ->join('modalitie_teacher as mt', 'mt.teacher_ID = teachers.teacher_ID')
                    ->join('modalities m', 'm.modality_ID = mt.modality_ID')
                    ->join('users_program up', 'up.program_ID = m.program_ID')
                    ->where('mt.teacher_ID', $id)
                    ->whereIn('m.status', $status)
                    ->where('up.user_ID', $user_id)
                    ->first()['count'] ?? 0;
    }

    public function getModalityInfoByTeacher($id) {
        $userId = session()->get('user_id');
    
        return $this->select('m.modality_ID, m.name_modalitie, mt.role, m.status')
                    ->join('modalitie_teacher mt', 'teachers.teacher_ID = mt.teacher_ID')
                    ->join('modalities m', 'm.modality_ID = mt.modality_ID')
                    ->join('users_program up', 'm.program_ID = up.program_ID')
                    ->where('teachers.teacher_ID', $id)
                    ->where('up.user_ID', $userId)
                    ->findAll();
    }
}