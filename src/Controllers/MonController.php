<?php

namespace App\Controller;

use App\Controller\BaseController;
use App\Support\Auth;
use App\Support\Route;
use App\Support\User;
use Psr\Http\Message\ServerRequestInterface as Request;

class MonController extends BaseController{
  public function index(){
    
    if(Auth::isLoggedIn()){
      echo "Je suis connecté ";
    }else{
      echo "Je suis pas connecté zebi";
    }

    $this->data = [
      'connected' => Auth::isLoggedIn()
    ];
    $this->template = "index";
  }

  public function register()
  {
    $this->template = "register";
  }

  public function createUser(Request $request)
  {
    $data = $request->getParsedBody();
    $sql = "Insert into user (username, email, password) values (:username, :email, :password)";
    $params = ['username' => $data["username"], "email" => $data["email"], "password" => User::hashPassword($data["password"])];
    $result = $this->dbQuery->execute($sql, $params);
    
    $this->redirect = true;
    $this->data = [
      "url" => "/"
    ];
  }

  public function loginPage()
  {
    $this->template = "login";
  }

  public function login(Request $request)
  {
    $data = $request->getParsedBody();
    Auth::login($data['username'], $data['password'], isset($data["remember_me"]) ? boolval($data["remember_me"]) : false );
    $this->redirect = true;
    $this->data = [
      "url" => "/"
    ];
  }

  public function logout()
  {
    Auth::logout();
    $this->redirect = true;
    $this->data = [
      "url" => "/"
    ];
  }
}