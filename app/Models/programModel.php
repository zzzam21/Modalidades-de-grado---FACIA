<?php

namespace App\Models;

use CodeIgniter\Model;

class programModel extends Model{

    protected $table = 'programs';

    protected $primaryKey = 'program_ID';

    protected $allowedFields = ['program_name', 'sede'];

}