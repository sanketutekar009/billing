<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends My_Controller {
  function __construct(){
    parent::__construct();
    $this->load->model("Login_model","lm");
  }
  
  function login(){
    $this->load->view("login/login");
  }
  
  function validate_login(){
    //echo "<pre>";print_r($_POST);
    $response = $this->lm->validate_login();
    echo json_encode($response);
  }

  function logout(){
    redirect(base_url("login"));
  }
}
