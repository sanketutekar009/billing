<?php
class Product_model extends CI_Model{

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function insert_products($products){
        //echo "<pre>";print_r($products);exit;
        $this->db->trans_start();

        if($products["0"]["id"] != ""){
            $this->db->where("id", $products["0"]["id"]);
            $this->db->update(PRODUCTS, $products["0"]);
        }else{
            $this->db->insert_batch(PRODUCTS, $products);
        } 
        

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            return false;
        }else{
            return true;
        }
    }

    function delete_products(){
        $this->db->trans_start();
        
        $this->db->where("id", $this->input->post("id"));
        $this->db->delete(PRODUCTS);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            return false;
        }else{
            return true;
        }
    }

    function search_products(){
        $product_name = trim($this->input->post("product_name"));
        $action_type = "";
        $this->db->select("*");
        $this->db->from(PRODUCTS);
        if(strlen($product_name) > 0){
            if(preg_match('/\\d/', $product_name) > 0 && strlen($product_name) > 5){
                $action_type = "barcode";
                $this->db->where("product_barcode", $this->input->post("product_name"));
            }else{
                $action_type = "product_name";
                $this->db->like("product_name", $this->input->post("product_name"));
            }
        }

        if(strlen($this->input->post("id")) > 0){
            $this->db->where("id", $this->input->post("id"));
        }

        $this->db->order_by("id","desc");
        $result = $this->db->get();
        //echo $this->db->last_query();exit;
        if($result->num_rows() > 0){
            return array(
                    "product_array" => $result->result_array(),
                    "action_type" => $action_type,
            );
        }else{
            return array(
                "product_array" =>  array(
                                "0" => array(
                                    "product_name" => "No Result Found"
                                )
                            ),
                "action_type" => "No Result Found",
            );
        }
    }
}