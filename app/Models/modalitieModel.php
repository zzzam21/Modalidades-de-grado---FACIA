<?php

namespace App\Models;

use CodeIgniter\Model; 

class modalitieModel extends Model{

    protected $table = 'modalities';

    protected $primaryKey = 'modality_ID';
    
    protected $allowedFields = ['modality_ID',
                                'name_modalitie',
                                'program_ID',
                                'id_type_mod',
                                'status',
                                'goal',
                                'date_approved', 
                                'date_end',
                                'duration',
                                'type_modality'];


    public function addModality($data){
        return $this->insert($data);
    }

    public function findByCode($modalityID, $program) {
        return $this->where('modality_ID', $modalityID)
                    ->where('program_ID', $program)->first();
    }

    public function countModalitie () {
        return $this->countAllResults();
    }

    public function getModalities() {
        return $this->findAll();
    }

    // Método para obtener los objetivos como array
    public function getGoalsAsArray($modality) {
        if (is_string($modality->goal)) {
            return json_decode($modality->goal, true) ?? [];
        }
        return (array) $modality->goal;
    }
}