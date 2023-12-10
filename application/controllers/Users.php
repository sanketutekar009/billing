<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model("Users_model","users");
    }
    
    function change_password(){
        $session_data = $this->check_session_data();

        if(!empty($session_data)){
            $this->set_layout("default");

            $this->template->add_css("assets/css/materialize.min.css");
            $this->template->add_css("assets/css/cgs.css");
            $this->template->add_js("assets/js/jquery-3.2.1.min.js");
            $this->template->add_js("assets/js/materialize.min.js");
                
            $this->pass_header_data["page"] = "settings";
            $this->pass_main_data["internal_users"] = $session_data; 

            $this->display_view("users/change_password","header/admin_header","footer/admin_footer");
        }else{
            redirect(base_url("login"));
        }
    }

    function create_users(){
        $session_data = $this->check_session_data();
        
        if(!empty($session_data)){
            $this->set_layout("default");

            $this->template->add_css("assets/css/materialize.min.css");
            $this->template->add_css("assets/css/cgs.css");
            $this->template->add_js("assets/js/jquery-3.2.1.min.js");
            $this->template->add_js("assets/js/materialize.min.js");

            $internal_users = $this->users->get_internal_users();
            //echo "<pre>";print_r($internal_users);exit;
            $this->pass_header_data["page"] = "settings";
            $this->pass_main_data["internal_users"] = $internal_users; 
            $this->display_view("users/create_users","header/admin_header","footer/admin_footer");
        }else{
            redirect(base_url("login"));
        }
    }

    function insert_user_details(){
        $response = $this->users->insert_user_details();
        if($response){
            echo json_encode("success");
        }else{
            echo json_encode("error");
        }
    }

    function update_user_details(){
        $response = $this->users->update_user_details();
        if($response){
            echo json_encode("success");
        }else{
            echo json_encode("error");
        }
    }

    function delete_user_details(){
        $response = $this->users->delete_user_details();
        if($response){
            echo json_encode("success");
        }else{
            echo json_encode("error");
        }
    }

    function verify_password(){
        $session_data = $this->check_session_data();
        if(md5($this->input->post("enter_password")) == $session_data["password"]){
            echo json_encode("password_matched");
        }else{
            echo json_encode("error");
        }
    }
}
