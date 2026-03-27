<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'email', 'passwordu'];

    protected $returnType = 'array';

    function getUserById($id){
        return $this->where('id', $id);
    }
}