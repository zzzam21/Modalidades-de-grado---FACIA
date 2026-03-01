<?php

namespace App\Models;

use CodeIgniter\Model;

class typeModalitieModel extends Model{

    protected $table = 'type_modalities';

    protected $primaryKey = 'id_type_mod';
    
    protected $allowedFields = ['type_name'];
}