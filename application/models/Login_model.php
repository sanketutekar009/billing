<?php
class Login_model extends CI_Model{

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function validate_login(){
        //echo "<pre>";print_r($_POST);
        $user_name = trim($this->input->post("user_name"));
        $password = md5(trim($this->input->post("pwd")));

        if(strlen($user_name) > 0 && strlen($password) > 0){
            $this->db->select("id, name, username, email_id, password, contact_number");
            $this->db->from(INTERNAL_USERS);
            $this->db->where("is_active","1");
            $this->db->where("username", $user_name);
            $this->db->where("password", $password);
            $result = $this->db->get();
            //echo $this->db->last_query();exit;
            if($result->num_rows() > 0){
                $user_details = $result->row_array();
                //echo "<pre>";print_r($user_details);exit;
                $this->session->set_userdata("internal_users_details", $user_details);
                return "success";
            }else{
                return "Invalid username and password";
            }
        }else{
            return "Enter valid username and password";
        }
    }
}