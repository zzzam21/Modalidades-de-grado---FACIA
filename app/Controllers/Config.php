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
        
        session() -> set('user_name', $data->name);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Nombre actualizado correctamente'
        ]);
    }

    public function updateEmail(){

        $id = session() -> get('user_id');
        
        if (!$id) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => 'error',
                'message' => 'No autenticado'
            ]);
        }

        $data = $this->request->getJSON();

        if (!$data || empty($data->email)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'Correo requerido'
            ]);
        }

        $userModel = new UserModel();

        $userModel->update($id, [
            'email' => $data->email
        ]);

        session() -> set('email', $data->email);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Correo actualizado correctamente'
        ]);
    }

    public function changePassword(){
        $id = session() -> get('user_id');

        $userModel = new UserModel();

        $user = $userModel->getUserById($id);

        if(!$user) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Usuario no existe'
            ]);
        }

        $data = $this->request->getJSON();
        
        
    }
}