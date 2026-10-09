<?php
namespace App\Controllers;
use App\Models\UserModel;
class AuthController extends BaseController
{
    public function index(){ return session()->get('user_id') ? redirect()->to('/dashboard') : redirect()->to('/login'); }
    public function login()
    {
        if (session()->get('user_id')) return redirect()->to('/dashboard');
        if ($this->request->getMethod()==='POST') {
            $rules=['username'=>'required','password'=>'required'];
            if (!$this->validate($rules)) return view('auth/login',['validation'=>$this->validator]);
            $user=(new UserModel())->where('username',$this->request->getPost('username'))->first();
            if ($user && password_verify((string)$this->request->getPost('password'),$user['password'])) {
                session()->regenerate(); session()->set(['user_id'=>$user['id'],'full_name'=>$user['full_name'],'username'=>$user['username'],'logged_in'=>true]);
                return redirect()->to('/dashboard')->with('success','Welcome back, '.$user['full_name'].'!');
            }
            return redirect()->back()->withInput()->with('error','Invalid username or password.');
        }
        return view('auth/login');
    }
    public function logout(){ session()->destroy(); return redirect()->to('/login')->with('success','You have been logged out.'); }
}
