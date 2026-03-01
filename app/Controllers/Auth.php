<?php
namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function index(): string
    {
        $data = ['tittle' => 'Login'];
        return view('auth/login', $data);
    }

    public function loginPost(){
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user){
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }
            
        if (!password_verify($password,$user['passwordu'])){
            return redirect()->back()->with('error', 'Contraseña incorrecta');
        }
        
        session()->set([
            'user_id' => $user['id'],
            'user_name' => $user['name'],
            'user_email'=> $email,
            'logged_in' => true
        ]);
        return redirect()->to('/dashboard');
    }

    public function logout(){
        session()->destroy();
        return redirect()->to('/auth/login');
    }

}
