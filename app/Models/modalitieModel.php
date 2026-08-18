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
                                'date_sustentacion',
                                'duration'];

    public function addModality($data){
        return $this->insert($data);
    }

    public function findByCode($modalityID, $program) {
        return $this->where('modality_ID', $modalityID)
                    ->where('program_ID', $program)->first();
    }

    public function countModalitie () {
        if (!session()->has('user_id')) {
            return 0;
        }
        $userId = session()->get('user_id');

        return $this->join('users_program', 'users_program.program_ID = modalities.program_ID')
                    ->join('programs ', 'programs.program_ID = users_program.program_ID')
                    ->join('users', 'users.id = users_program.user_ID')
                    ->where('users.id', $userId)
                    ->countAllResults();
    }

    // Método para obtener los objetivos como array
    public function getGoalsAsArray($modality) {
        if (is_string($modality->goal)) {
            return json_decode($modality->goal, true) ?? [];
        }
        return (array) $modality->goal;
    }

    public function deleteModality($id){
        $this->delete($id);
    }
}