<?php

namespace App\Controllers;

use App\Models\UserModel;

class Config extends BaseController{
    public function config(): string {
        $data = ['tittle'=> 'Perfil',
                 'icon'=>'<i class="bi bi-gear"></i> Perfil'];
        return view('dashboard/configuration',$data);
    }

    public function updateUser() {
        $name = $this->request->getPost('userNameInputEmail');
        $id = session() -> id;
        
        $usermodel = new UserModel;

        $data = array( "name" => $name );
        $usermodel->where("id", $id )->update("users",$data);
        return redirect()->back()->with('success', 'Usuario actualizado');
    }
}