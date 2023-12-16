<?php
class Bills_model extends CI_Model{

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function get_bills_setting_details(){
        $this->db->select("*");
        $this->db->from(INVOICE_SETTINGS);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }else{
            return false;
        }
    }

    function update_bill_setting(){
        $this->db->trans_start();
        //echo "<pre>";print_r($_POST);exit;

        $bill_setting = array(
            "invoice_title" => trim($this->input->post("invoice_title")),
            "invoice_address" => trim($this->input->post("invoice_address")),
            "invoice_contact_number" => trim($this->input->post("invoice_contact_number")),
            "invoice_email_id" => trim($this->input->post("invoice_email_id")),
            "pancard_number" => trim($this->input->post("pancard_number")),
            "gst_number" => trim($this->input->post("gst_number")),
            "invoice_prefix" => trim($this->input->post("invoice_prefix")),
            "challan_print" => trim($this->input->post("challan_print"))
        );

        $this->db->where("id", $this->input->post("id"));
        $this->db->update(INVOICE_SETTINGS, $bill_setting); 
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            return false;
        }else{
            return true;
        }
    }

    function get_bills_details($id="", $case="default"){
        switch($case){
            case "search_page":
                $this->db->select("i.*, c.company_name, c.code");
                $this->db->from(INVOICE." i");
                $this->db->join(COMPANIES." c","i.coporate_id=c.id", "LEFT");
                $this->db->where("i.is_active", "1");
                
                // Filter by date 
                if($_GET["filter_by"] == "" || $_GET["filter_by"] == "all" || $_GET["filter_by"] == "date"){
                    $this->db->where("invoice_date between '".$_GET['from_date']."' and '".$_GET['to_date']."'");
                }

                // Filter by company name or company id
                if($_GET["filter_by"] == "all" || $_GET["filter_by"] == "company-name"){
                    if($_GET["company_id"] != ""){
                        $this->db->where("coporate_id", $_GET['company_id']);
                    }else{
                        $this->db->like("company_name", $_GET['query']);
                    }
                }

                // Filter by company name or company id
                if($_GET["filter_by"] == "bill-number"){
                    $this->db->where("invoice_number", $_GET['query']);
                }
                
                $this->db->order_by("i.id","desc");
            break;

            case "invoice_number":
                $this->db->select("invoice_number");
                $this->db->from(INVOICE." i");
                $this->db->where("i.id", $id);
                $this->db->where("i.is_active", "1");
            break;

            case "default":
                $this->db->select("i.*, c.company_name, c.code, id.*, i.id as main_id, id.id as item_id, company_address, company_email, company_number, gst_number");
                $this->db->from(INVOICE." i");
                $this->db->join(COMPANIES." c","i.coporate_id=c.id", "LEFT");
                $this->db->join(INVOICE_DETAILS." id","i.id=id.invoice_id");
                $this->db->where("i.id", $id);
                $this->db->where("i.is_active", "1");
                $this->db->order_by("i.id","desc");
            break;
            
            case "statement":
                $this->db->select("i.*, c.company_name, c.code, id.*, i.id as main_id, id.id as item_id, company_address, company_email, company_number, gst_number");
                $this->db->from(INVOICE." i");
                $this->db->join(COMPANIES." c","i.coporate_id=c.id");
                $this->db->join(INVOICE_DETAILS." id","i.id=id.invoice_id");
                //$this->db->where_in("i.id", array("185","184"));
                $this->db->where("i.is_active", "1");
                $this->db->order_by("i.id","asc");
            break;
        }
        $result = $this->db->get();
        // echo $this->db->last_query();exit;
        if($result->num_rows() > 0){
            return $result->result_array();
        }else{
            return false;
        }
    }

    function insert_bill($created_by){
        //echo "<pre>";print_r($_POST);exit;
        $this->db->trans_start();
        //echo "<pre>";print_r($_POST);exit;

        $invoices = array(
            "coporate_id" => ($this->input->post("company_id") == 0 ? 1 : trim($this->input->post("company_id"))),
            "customer_name" => trim($this->input->post("customer_name")),
            "invoice_number" => trim($this->input->post("bill_number")),
            "invoice_date" => date("Y-m-d", strtotime($this->input->post("bill_date"))),
            "bill_discount" => $this->input->post("bill_discount"),
            "bill_contact_person" => $this->input->post("bill_contact_person"),
            "print_details" => $this->input->post("print_details"),
            "created_by" => $created_by
        );

        $this->db->insert(INVOICE, $invoices); 
        $insert_id = $this->db->insert_id();

        if(!empty($_POST["products"])){
            foreach($_POST["products"] as $keys=>$values){
                $invoice_details[$keys] = array(
                    "invoice_id" => $insert_id,
                    "hsn" => trim($_POST["hsn"][$keys]),
                    "qty" => trim($_POST["qty"][$keys]),
                    "item_name" => trim($_POST["products"][$keys]),
                    "mrp" => trim($_POST["mrp"][$keys]),
                    "special_rate" => trim($_POST["special_rate"][$keys]),
                    "cgst" => trim($_POST["gst"][$keys]/2),
                    "sgst" => trim($_POST["gst"][$keys]/2),
                    "cess" => trim($_POST["cess"][$keys]),
                );
            }
        }
        //echo "<pre>";print_r($invoice_details);exit;
        $this->db->insert_batch(INVOICE_DETAILS, $invoice_details);
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            return "error";
        }else{
            return $insert_id;
        }
    }

    function update_bill(){
        //echo "<pre>";print_r($_POST);exit;
        $this->db->trans_start();
        //echo "<pre>";print_r($_POST);exit;
        $invoices = array(
            "coporate_id" => ($this->input->post("company_id") == 0 ? 1 : trim($this->input->post("company_id"))),
            "customer_name" => trim($this->input->post("customer_name")),
            "invoice_number" => trim($this->input->post("bill_number")),
            "invoice_date" => date("Y-m-d", strtotime($this->input->post("bill_date"))),
            "bill_discount" => trim($this->input->post("bill_discount")),
            "bill_contact_person" => trim($this->input->post("bill_contact_person")),
            "print_details" => $this->input->post("print_details"),
        );

        $this->db->where("id", $this->input->post("main_id"));
        $this->db->update(INVOICE, $invoices); 
       
        if(!empty($_POST["products"])){
            foreach($_POST["products"] as $keys=>$values){
                if(strlen(trim($_POST["is_deleted"][$keys])) > 0){
                    $delete_invoice_details[] = $_POST["id"][$keys];
                }else if(strlen(trim($_POST["id"][$keys])) > 0){
                    $update_invoice_details[$keys] = array(
                        "id" => trim($_POST["id"][$keys]),
                        "invoice_id" => trim($_POST["main_id"]),
                        "hsn" => trim($_POST["hsn"][$keys]),
                        "qty" => trim($_POST["qty"][$keys]),
                        "item_name" => trim($_POST["products"][$keys]),
                        "mrp" => trim($_POST["mrp"][$keys]),
                        "special_rate" => trim($_POST["special_rate"][$keys]),
                        "cgst" => trim($_POST["gst"][$keys]/2),
                        "sgst" => trim($_POST["gst"][$keys]/2),
                        "cess" => trim($_POST["cess"][$keys]),
                    );
                }else{
                    $invoice_details[$keys] = array(
                        "invoice_id" => trim($_POST["main_id"]),
                        "hsn" => trim($_POST["hsn"][$keys]),
                        "qty" => trim($_POST["qty"][$keys]),
                        "item_name" => trim($_POST["products"][$keys]),
                        "mrp" => trim($_POST["mrp"][$keys]),
                        "special_rate" => trim($_POST["special_rate"][$keys]),
                        "cgst" => trim($_POST["gst"][$keys]/2),
                        "sgst" => trim($_POST["gst"][$keys]/2),
                        "cess" => trim($_POST["cess"][$keys]),
                    );
                }
                
            }
        }
        //echo "<pre>";print_r($delete_invoice_details);exit;
        if(!empty($update_invoice_details)){
            $this->db->update_batch(INVOICE_DETAILS, $update_invoice_details, "id");
        }
        
        if(!empty($invoice_details)){
            $this->db->insert_batch(INVOICE_DETAILS, $invoice_details);
        }

        if(!empty($delete_invoice_details)){
            $this->db->where_in("id", $delete_invoice_details);
            $this->db->delete(INVOICE_DETAILS);
        }
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            return false;
        }else{
            return true;
        }
    }

    function delete_bill(){
        $this->db->trans_start();
        //echo "<pre>";print_r($_POST);exit;

        $update_array = array(
            "is_active" => "0"
        );
        $this->db->where("id", $this->input->post("id")); 
        $this->db->update(INVOICE, $update_array); 

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            return false;
        }else{
            return true;
        }
    }

    function get_bill_details_comments(){
        $this->db->select("i.*, DATE_FORMAT(invoice_date, '%M-%Y') as invoice_date, u.name");
        $this->db->from(INVOICE." i");
        $this->db->join(INTERNAL_USERS." u","i.created_by=u.id");
        $this->db->where("i.id", $this->input->post("id"));
        $this->db->where("i.is_active", "1");
        $this->db->order_by("i.id","desc");
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }else{
            return "error";
        }
    }

    function save_bill_comments(){
        //echo "<pre>";print_r($_POST);exit;
        $this->db->trans_start();
    
        $update_array = array(
            "bill_status" => trim($this->input->post("bill_status")),
            "invoice_comment" => trim($this->input->post("invoice_comment")),
        );

        $this->db->where("id", $this->input->post("id"));
        $this->db->update(INVOICE, $update_array); 
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            return false;
        }else{
            return true;
        }
    }

    function update_bill_amount($id, $bill_amount){
        $this->db->trans_start();
        //echo "<pre>";print_r($_POST);exit;

        $invoices = array(
            "invoice_amount" => $bill_amount
        );
        $this->db->where("id", $id);
        $this->db->update(INVOICE, $invoices); 
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            return false;
        }else{
            return true;
        }
    }

    function get_last_bill_number(){
        $this->db->select('invoice_number as invoice_number');
        $this->db->from(INVOICE);
        $this->db->where("is_active","1");
        $this->db->where("coporate_id <> 0");
        $this->db->order_by("id","desc");
        $this->db->limit("1");
        $result = $this->db->get();
        if($result->num_rows() > 0){
            $arr = $result->row_array();
            return $arr["invoice_number"]+1;
        }else{
            return 1;
        }
    }
}