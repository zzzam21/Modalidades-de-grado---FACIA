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
        
        $id = session() -> get('user_id');
        $data = $this->request->getJSON();

        if (!$id) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => 'error',
                'message' => 'No autenticado'
            ]);
        }

        $data = $this->request->getJSON();

        if (!$data || empty($data->name)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'Nombre requerido'
            ]);
        }

        $userModel = new UserModel();

        $userModel->update($id, [
            'name' => $data->name
        ]);
        

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Nombre actualizado correctamente'
        ]);
    }
}