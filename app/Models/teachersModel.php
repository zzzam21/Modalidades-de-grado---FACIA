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

    public function teachersCount(){
        return $this->countAllResults();
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
}