<?php

namespace App\Models;

use CodeIgniter\Model;

class modalitie_teacherModel extends Model{

    protected $table = 'modalitie_teacher';

    protected $primaryKey = ['teacher_ID', 'modality_ID'];
    
    protected $allowedFields = ['teacher_ID', 'modality_ID','role'];

    // Verificar si ya existe la asociación
    public function associationExists($teacher_ID, $modality_ID) {
        return $this->where('teacher_ID', $teacher_ID)
                    ->where('modality_ID', $modality_ID)
                    ->first();
    }

    // Asociar docente a modalidad con rol
    public function associateTeacher($teacher_ID, $modality_ID, $role) {
        // Verificar si ya existe
        if (!$this->associationExists($teacher_ID, $modality_ID)) {
            return $this->insert([
                'teacher_ID' => $teacher_ID,
                'modality_ID' => $modality_ID,
                'role' => $role
            ]);
        }
        return true;
    }
}