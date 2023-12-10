<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customers extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model("Customers_model","cm");
    }
    
    function create_customers($id=""){
        $session_data = $this->check_session_data();
        
        if(!empty($session_data)){
            $this->set_layout("default");

            $this->template->add_css("assets/css/materialize.min.css");
            $this->template->add_css("assets/css/cgs.css");
            $this->template->add_js("assets/js/jquery-3.2.1.min.js");
            $this->template->add_js("assets/js/materialize.min.js");
            $this->template->add_js("assets/js/mindmup-editabletable.js");
                
            $customer_details = $this->cm->get_customers();    
            //echo "<pre>";print_r($customer_details);exit;
            if($id != ""){
                $edit_customer_details = $this->cm->get_customers($id);  
                //echo "<pre>";print_r($edit_customer_details);exit;  
                $this->pass_main_data["edit_customer_details"] = $edit_customer_details;
            }

            $this->pass_header_data["page"] = "create-customers";
            $this->pass_main_data["customer_details"] = $customer_details;
            $this->display_view("customers/create_customers","header/admin_header","footer/admin_footer");
        }else{
            redirect(base_url("login"));
        }
    }

    function search_customers($response="json"){
        $customers = $this->cm->get_customers();
        //echo "<pre>";print_r($customers);exit;
        if($response != "json"){
            return $customers;
        }else{
            echo json_encode($customers);
        }
    }

    function insert_customer_details(){
        $response = $this->cm->insert_customer_details();
        if($response){
            echo json_encode("success");
        }else{
            echo json_encode("error");
        }
    }

    function update_customer_details(){
        $response = $this->cm->update_customer_details();
        if($response){
            echo json_encode("success");
        }else{
            echo json_encode("error");
        }
    }

    function delete_customer_details(){
        $response = $this->cm->delete_customer_details();
        if($response){
            echo json_encode("success");
        }else{
            echo json_encode("error");
        }
    }
}
