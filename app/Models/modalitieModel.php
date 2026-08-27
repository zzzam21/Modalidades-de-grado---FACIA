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
                    ->whereNotIn('modalities.status', ['Finalizado', 'Cancelado'])
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

    private function baseAlertQuery() {
        $db = \Config\Database::connect();
        $builder = $db->table('modalities m');
        $builder->select('m.modality_ID, m.name_modalitie, m.status, m.date_end, m.date_sustentacion, p.program_name');
        $builder->join('type_modalities tm', 'm.id_type_mod = tm.id_type_mod', 'left');
        $builder->join('programs p', 'm.program_ID = p.program_ID', 'left');
        $builder->join('users_program up', 'm.program_ID = up.program_ID');
        $builder->where('up.user_ID', session('user_id'));
        $builder->whereNotIn('m.status', ['Finalizado', 'Cancelado']);
        return $builder;
    }

    public function getAlertasVencidas() {
        $builder = $this->baseAlertQuery();
        $builder->groupStart();
            $builder->groupStart();
                $builder->where('m.date_sustentacion IS NOT NULL');
                $builder->where('m.date_sustentacion <', date('Y-m-d H:i:s'));
            $builder->groupEnd();
            $builder->orGroupStart();
                $builder->where('m.date_sustentacion IS NULL');
                $builder->where('m.date_end IS NOT NULL');
                $builder->where('m.date_end <', date('Y-m-d'));
            $builder->groupEnd();
        $builder->groupEnd();
        $builder->orderBy('m.date_sustentacion', 'ASC');
        $builder->orderBy('m.date_end', 'ASC');
        $results = $builder->get()->getResult();

        foreach ($results as $row) {
            $fechaRef = $row->date_sustentacion ?? $row->date_end;
            $row->dias_retraso = (new \DateTime($fechaRef))->diff(new \DateTime())->days;
        }

        return $results;
    }

    public function getAlertasProximas() {
        $builder = $this->baseAlertQuery();
        $now = date('Y-m-d H:i:s');
        $sevenDays = date('Y-m-d H:i:s', strtotime('+7 days'));
        $today = date('Y-m-d');
        $sevenDaysDate = date('Y-m-d', strtotime('+7 days'));

        $builder->groupStart();
            $builder->groupStart();
                $builder->where('m.date_sustentacion IS NOT NULL');
                $builder->where('m.date_sustentacion >=', $now);
                $builder->where('m.date_sustentacion <=', $sevenDays);
            $builder->groupEnd();
            $builder->orGroupStart();
                $builder->where('m.date_sustentacion IS NULL');
                $builder->where('m.date_end IS NOT NULL');
                $builder->where('m.date_end >=', $today);
                $builder->where('m.date_end <=', $sevenDaysDate);
            $builder->groupEnd();
        $builder->groupEnd();
        $builder->orderBy('m.date_sustentacion', 'ASC');
        $builder->orderBy('m.date_end', 'ASC');
        $results = $builder->get()->getResult();

        foreach ($results as $row) {
            $fechaRef = $row->date_sustentacion ?? $row->date_end;
            $row->dias_restantes = (new \DateTime())->diff(new \DateTime($fechaRef))->days;
        }

        return $results;
    }
}