<?php

namespace App\Controllers;
use Core\User;
use Core\Auth;
use Core\BaseController;
use Core\DB;

class HomeController extends BaseController
{
    public function index(){
    
        if(Auth::isLoggedIn()){
          echo "Je suis connecté ";
        }else{
          echo "Je suis pas connecté zebi";
        }

        $this->view('home', [
            'connected' => Auth::isLoggedIn()
        ]);
      }
    
      public function register()
      {
        $this->view('register');
      }
    
      public function createUser()
      {
        $data = $_POST;
        $sql = "Insert into user (username, email, password) values (:username, :email, :password)";
        $params = ['username' => $data["username"], "email" => $data["email"], "password" => User::hashPassword($data["password"])];
        $result = DB::execute($sql, $params);
        
        $this->redirect('/');
      }
    
      public function loginPage()
      {
        $this->view('login');
      }
    
      public function login()
      {
        $data = $_POST;
        Auth::login($data['username'], $data['password'], isset($data["remember_me"]) ? boolval($data["remember_me"]) : false );
        $this->redirect('/');
      }
    
      public function logout()
      {
        Auth::logout();
        $this->redirect('/');
      }
}
