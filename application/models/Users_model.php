<?php
class Users_model extends CI_Model{

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function get_internal_users($id = ""){
        $this->db->select("*");
        $this->db->from(INTERNAL_USERS);
        if($id != ""){
            $this->db->where("id", $id);
        }
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->result_array();
        }else{
            return false;
        }
    }

    function insert_user_details(){
        $this->db->trans_start();
        //echo "<pre>";print_r($_POST);exit;
        $user_details = array(
            "name" => trim($this->input->post("name")),
            "username" => trim($this->input->post("username")),
            "email_id" => trim($this->input->post("email_id")),
            "password" => md5(trim($this->input->post("password"))),
            "contact_number" => trim($this->input->post("contact_number"))
        );
        $this->db->insert(INTERNAL_USERS, $user_details);
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            return false;
        }else{
            return true;
        }
    }

    function update_user_details(){
        if(trim($this->input->post("password")) != ""){
            $this->db->trans_start();
            //echo "<pre>";print_r($_POST);exit;
            $user_details = array(
                "name" => trim($this->input->post("name")),
                "username" => trim($this->input->post("username")),
                "email_id" => trim($this->input->post("email_id")),
                "password" => md5(trim($this->input->post("password"))),
                "contact_number" => trim($this->input->post("contact_number"))
            );
            $this->db->where("id", $this->input->post("id"));
            $this->db->update(INTERNAL_USERS, $user_details);
            
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }

    function delete_user_details(){
        $this->db->trans_start();
        //echo "<pre>";print_r($_POST);exit;
        
        $this->db->where("id", $this->input->post("id"));
        $this->db->delete(INTERNAL_USERS);
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            return false;
        }else{
            return true;
        }
    }
}