<?php

namespace App\Models;

use CodeIgniter\Model;

class modalitie_studentModel extends Model{

    protected $table = 'modalitie_student';

    protected $primaryKey = ['student_ID', 'modality_ID'];
    
    protected $allowedFields = ['student_ID', 'modality_ID'];

    public function addModalitieStudent($data) {
        $this->insert($data);
    }
    
}