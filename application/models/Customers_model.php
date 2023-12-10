<?php
class Customers_model extends CI_Model{

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function get_customers($id=""){
        $this->db->select("*");
        $this->db->from(COMPANIES);

        if(strlen(trim($this->input->post("customer_name"))) > 0){
            $this->db->like("company_name", trim($this->input->post("customer_name")));
        }

        if($id != ""){
            $this->db->where("id", $id);
        }
        $this->db->where("is_active", "1");
        // $this->db->order_by("id","desc");
        $this->db->order_by("company_name");
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->result_array();
        }else{
            return false;
        }
    }

    function insert_customer_details(){
        $this->db->trans_start();
        //echo "<pre>";print_r($_POST);exit;
        $company_details = array(
            "company_name" => trim($this->input->post("company_name")),
            "company_address" => trim($this->input->post("company_address")),
            "company_alternate_address" => trim($this->input->post("company_alternate_address")),
            "company_email" => trim($this->input->post("company_email")),
            "company_number" => trim($this->input->post("company_number")),
            "gst_number" => trim($this->input->post("gst_number")),
            "code" => trim($this->input->post("code"))
        );
        $this->db->insert(COMPANIES, $company_details);
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            return false;
        }else{
            return true;
        }
    }

    function update_customer_details(){
        $this->db->trans_start();
        //echo "<pre>";print_r($_POST);exit;
        $company_details = array(
            "company_name" => trim($this->input->post("company_name")),
            "company_address" => trim($this->input->post("company_address")),
            "company_alternate_address" => trim($this->input->post("company_alternate_address")),
            "company_email" => trim($this->input->post("company_email")),
            "company_number" => trim($this->input->post("company_number")),
            "gst_number" => trim($this->input->post("gst_number")),
            "code" => trim($this->input->post("code"))
        );
        $this->db->where("id", trim($this->input->post("id")));
        $this->db->update(COMPANIES, $company_details);
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            return false;
        }else{
            return true;
        }
    }

    function delete_customer_details(){
        $this->db->trans_start();
        //echo "<pre>";print_r($_POST);exit;
        
        //$this->db->where("id", $this->input->post("id"));
        //$this->db->delete(COMPANIES);
        $company_details = array(
            "is_active" => "0"
        );
        $this->db->where("id", $this->input->post("id"));
        $this->db->update(COMPANIES, $company_details);
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            return false;
        }else{
            return true;
        }
    }
}