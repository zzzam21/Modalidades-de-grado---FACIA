<?php

namespace App\Models;

use CodeIgniter\Model;

class user_programModel extends Model{

    protected $table = 'users_program';

    protected $primaryKey = ['program_ID', 'user_ID'];
    
    protected $allowedFields = ['program_ID', 'user_ID'];

    public function userProgram($userId) {
        return $this->select('programs.program_ID, programs.program_name, programs.sede')
                    ->join('programs', 'users_program.program_ID = programs.program_ID')
                    ->where('users_program.user_ID', $userId)
                    ->first();
    }

    public function getProgramsByUser($userId) {
        return $this->select('programs.program_ID, programs.program_name, programs.sede')
                    ->join('programs', 'users_program.program_ID = programs.program_ID')
                    ->where('users_program.user_ID', $userId)
                    ->findAll();
    }

    public function getModalities(){
        if (!session()->has('user_id')) {
            return [];
        }
        $userId = session()->get('user_id');
        
        return $this->select('m.*')
                    ->join('programs p', 'users_program.program_ID = p.program_ID')
                    ->join('modalities m', 'm.program_ID = p.program_ID')
                    ->where('users_program.user_ID', $userId)
                    ->get()
                    ->getResultArray();
    }

    public function countModalitie () {
        if (!session()->has('user_id')) {
            return 0;
        }
        $userId = session()->get('user_id');

        return $this->table('users_program up')
                    ->join('programs p', 'p.program_ID = up.program_ID')
                    ->join('users u', 'u.id = up.user_ID')
                    ->join('modalities m', 'm.program_ID = up.program_ID')
                    ->where('u.id', $userId)
                    ->countAllResults();
    }
}