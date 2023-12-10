<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Products extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model("Product_model","pm");
    }
    
    function read_products(){
        set_time_limit(0);
    	ini_set('memory_limit', '-1');

        $filename = APPPATH."/third_party/Product.csv";
        $delimiter = ',';
		if (($handle = fopen($filename, 'r')) !== FALSE){
            $counter = 0;
			while (($row = fgetcsv($handle, 100000, $delimiter)) !== FALSE){
				if(!$header){
					$header = $row;
				}else{
                    // Product data..
                    $data[$counter]["product_name"] = $row["1"];
                    $data[$counter]["hsn_code"] = $row["2"];
                    $data[$counter]["gst"] = $row["3"];
                    $data[$counter]["product_rate"] = $row["4"];
                    //$data[] = array_combine($header, $row);
                }
                $counter++;
			}
			fclose($handle);
		}else{
            echo "File doesn't exist";
        }
        //echo "<pre>";print_r($data);exit;
        $response = $this->pm->insert_products($data);
        if($response){
            echo "Products successfully inserted";
        }else{
            echo "Error while inserting products";
        }
    }

    function search_products($response="json"){
        $products = $this->pm->search_products();
        //echo "<pre>";print_r($products);exit;
        if($response != "json"){
            return $products["product_array"];
        }else{
            echo json_encode($products);
        }
    }

    function product_list(){
        $session_data = $this->check_session_data();
        
        if(!empty($session_data)){
            $this->set_layout("default");

            $this->template->add_css("assets/css/materialize.min.css");
            $this->template->add_css("assets/css/cgs.css");
            $this->template->add_js("assets/js/jquery-3.2.1.min.js");
            $this->template->add_js("assets/js/materialize.min.js");
            
            $products = $this->search_products("return");
            $this->pass_header_data["page"] = "product-list";
            $this->pass_main_data["internal_users"] = $session_data; 
            $this->pass_main_data["products"] = $products; 

            $this->display_view("products/products","header/admin_header","footer/admin_footer");
        }else{
            redirect(base_url("login"));
        }
    }

    function insert_products(){
        //echo "<pre>";print_r($_POST);exit;
        $insert_array = array(
            "0" => array(
                "product_name" => trim($this->input->post("product_name")),
                "hsn_code" => trim($this->input->post("hsn_code")),
                "gst" => trim($this->input->post("gst")),
                "product_rate" => trim($this->input->post("rate")),
                "product_barcode" => trim($this->input->post("product_barcode")),
            )
        );

        if($this->input->post("id") != ""){
            $insert_array["0"]["id"] = $this->input->post("id");
        }
        $response = $this->pm->insert_products($insert_array);
        if($response){
            echo json_encode("success");
        }else{
            echo json_encode("error");
        }
    }

    function delete_products(){
        $response = $this->pm->delete_products();
        if($response){
            echo json_encode("success");
        }else{
            echo json_encode("error");
        }
    }
    //SELECT * from  where id in (9,10,17,18,21,23)
	//SELECT * from  where invoice_id in (3,4,5,6,7)
	

}
