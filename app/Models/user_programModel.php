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
}