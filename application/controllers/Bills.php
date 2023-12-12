<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bills extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model("Bills_model","bills");
    }

    function bill_setting(){
        $session_data = $this->check_session_data();
        
        if(!empty($session_data)){
            $this->set_layout("default");

            $this->template->add_css("assets/css/materialize.min.css");
            $this->template->add_css("assets/css/cgs.css");
            $this->template->add_js("assets/js/jquery-3.2.1.min.js");
            $this->template->add_js("assets/js/materialize.min.js");
            $this->template->add_js("assets/js/mindmup-editabletable.js");

            $billDetails_array = $this->bills->get_bills_setting_details();
            //echo "<pre>";print_r($billDetails_array);exit;
            $this->pass_header_data["page"] = "settings";
            $this->pass_main_data["billDetails_array"] = $billDetails_array;  
            $this->display_view("bills/bill_setting","header/admin_header","footer/admin_footer");
        }else{
            redirect(base_url("login"));
        }
    }

    function update_bill_setting(){
        $response = $this->bills->update_bill_setting();
        if($response){
            echo json_encode("success");
        }else{
            echo json_encode("error");
        }
        //echo "<pre>";print_r($_POST);
    }
    
    function generate_bills($id=""){
        $session_data = $this->check_session_data();
        //echo "<pre>";print_r($session_data["id"]);exit;        
        if(!empty($session_data)){
            $this->set_layout("default");

            $this->template->add_css("assets/css/materialize.min.css");
            $this->template->add_css("assets/css/cgs.css");
            $this->template->add_js("assets/js/jquery-3.2.1.min.js");
            $this->template->add_js("assets/js/materialize.min.js");
            $this->template->add_js("assets/js/mindmup-editabletable.js");

            if($id != ""){
                $bill_details = $this->bills->get_bills_details($id);
                //echo "<pre>";print_r($bill_details);exit;
                $this->pass_main_data["bill_details"] = $bill_details;    
            }else{
                $bill_number = $this->bills->get_last_bill_number();
                $this->pass_main_data["bill_number"] = $bill_number; 
            }
            $this->pass_header_data["page"] = "generate-bills";  
            $this->display_view("bills/generate_bills","header/admin_header","footer/admin_footer");
        }else{
            redirect(base_url("login"));
        }
    }

    function search_bills(){
        $session_data = $this->check_session_data();
        
        if(!empty($session_data)){
            $this->set_layout("default");

            $this->load->helper("indian_currency_helper");

            $this->template->add_css("assets/css/materialize.min.css");
            $this->template->add_css("assets/css/cgs.css");
            $this->template->add_js("assets/js/jquery-3.2.1.min.js");
            $this->template->add_js("assets/js/materialize.min.js");
            $this->template->add_js("assets/js/mindmup-editabletable.js");
                
            $current_month = date("m");
            $current_year = date("Y");
            $days_in_month = cal_days_in_month(CAL_GREGORIAN,$current_month,$current_year);
            if(strlen($_GET["from_date"]) == 0 && strlen($_GET["to_date"]) == 0){
                $_GET["from_date"] = $current_year.'-'.$current_month.'-01';
                $_GET["to_date"] = $current_year.'-'.$current_month.'-'.$days_in_month;
            }

            $bill_details = $this->bills->get_bills_details("","search_page");
            //echo "<pre>";print_r($bill_details);exit;
            
            $this->pass_header_data["page"] = "search-bills";
            $this->pass_main_data["bill_details"] = $bill_details;
            $this->pass_main_data["from_date"] = date("d-m-Y", strtotime($_GET["from_date"]));
            $this->pass_main_data["to_date"] = date("d-m-Y", strtotime($_GET["to_date"]));
            $this->display_view("bills/search_bills","header/admin_header","footer/admin_footer");
        }else{
            redirect(base_url("login"));
        }
    }

    function print_bill($id){
        $this->load->helper("indian_currency_helper");

        $bill_details = $this->bills->get_bills_details($id);
        $billDetails_array = $this->bills->get_bills_setting_details();  
        $bill_details = $this->GST_calculator($bill_details, "Maharashtra");
        // echo "<pre>";print_r($bill_details);exit;
        //echo "<pre>";print_r($billDetails_array);exit;
        $data["has_cess"] = $bill_details["has_cess"];
        $data["has_special_rate"] = $bill_details["has_special_rate"];
        $data["discount_amount"] = $bill_details["discount_total_amount"];
        // unset has_cess column if present
        unset($bill_details["has_cess"]);
        // unset total_amount column if present
        unset($bill_details["total_amount"]);
        unset($bill_details["discount_total_amount"]);
        unset($bill_details["breakup"]);
        unset($bill_details["has_special_rate"]);
        $data["bill_details"] = $bill_details;
        $data["billDetails_array"] = $billDetails_array; 
        
        $this->load->view("bills/print_bill", $data);
    }

    function print_simple_bill($id){
        $this->load->helper("indian_currency_helper");

        $bill_details = $this->bills->get_bills_details($id);
        $billDetails_array = $this->bills->get_bills_setting_details();  
        $bill_details = $this->GST_calculator($bill_details, "Maharashtra");
        //echo "<pre>";print_r($bill_details);exit;
        //echo "<pre>";print_r($billDetails_array);exit;
        $data["has_cess"] = $bill_details["has_cess"];
        $data["discount_amount"] = $bill_details["discount_total_amount"];
        // unset has_cess column if present
        unset($bill_details["has_cess"]);
        // unset total_amount column if present
        unset($bill_details["total_amount"]);
        unset($bill_details["discount_total_amount"]);
        unset($bill_details["breakup"]);
        $data["bill_details"] = $bill_details;
        $data["billDetails_array"] = $billDetails_array; 
        
        $this->load->view("bills/print_simple_bill", $data);
    }

    function insert_bill(){
        //echo "<pre>";print_r($_POST);exit;
        $session_data = $this->check_session_data();
        //echo "<pre>";print_r($session_data["id"]);exit;
        $response = $this->bills->insert_bill($session_data["id"]);
        if($response != "error"){
            echo json_encode("success");
            $this->update_bill_amount($response, "no");
        }else{
            echo json_encode("error");
        }
    }

    function update_bill(){
        //echo "<pre>";print_r($_POST);exit;
        $response = $this->bills->update_bill();
        if($response){
            echo json_encode("success");
            $id = $this->input->post("main_id");
            $this->update_bill_amount($id, "no");
        }else{
            echo json_encode("error");
        }
    }

    function delete_bill(){
        $response = $this->bills->delete_bill();
        if($response){
            echo json_encode("success");
        }else{
            echo json_encode("error");
        }
    }

    function get_bill_details_comments(){
        $response = $this->bills->get_bill_details_comments();
        //echo "<pre>";print_r($response);exit;
        if($response != "error"){
            echo json_encode($response);
        }else{
            echo json_encode("error");
        }
    }

    function save_bill_comments(){
        $response = $this->bills->save_bill_comments();
        //echo "<pre>";print_r($response);exit;
        if($response){
            echo json_encode("success");
        }else{
            echo json_encode("error");
        }
    }

    function update_bill_amount($id, $status="yes"){
        $bill_details = $this->bills->get_bills_details($id);
        //echo "<pre>";print_r($bill_details);exit;
        $bill_details = $this->GST_calculator($bill_details, "Maharashtra");
        //echo "<pre>";print_r($bill_details);exit;
        //echo $bill_details["total_amount"];exit;
        $response = $this->bills->update_bill_amount($id, $bill_details["total_amount"]);
        if($status == "yes"){
            if($response){
                echo json_encode("success");
            }else{
                echo json_encode("error");
            }
        }
    }
    
    function reports(){

        $action = "bill_number";
        $download_array = array();
        switch($action){
            case "company":
                $bill_details = $this->bills->get_bills_details($id, "statement");
                //echo "<pre>";print_r($bill_details);
                if(!empty($bill_details)){
                    $bill_groups = array();
                    foreach($bill_details as $keys=>$values){
                        $download_array[$values["coporate_id"]]["company_name"] = $values["company_name"];
                        $download_array[$values["coporate_id"]]["company_address"] = $values["company_address"];
                        $download_array[$values["coporate_id"]]["gst_number"] = $values["gst_number"];
                        $bill_groups[$values["coporate_id"]][] = $values;
                    }
                }
                //echo "<pre>";print_r($bill_groups);exit;
                if(!empty($bill_details)){
                    $bill_details = array();
                    foreach($bill_groups as $keys=>$values){
                        $return_array = $this->GST_calculator($values, "Maharashtra");
                        //echo "<pre>";print_r($return_array);exit;
                        if(!empty($return_array)){
                            $download_array[$keys]["cgst_0"] = $return_array["breakup"]["cgst_0"];
                            $download_array[$keys]["sgst_0"] = $return_array["breakup"]["sgst_0"];
                            $download_array[$keys]["cgst_5"] = $return_array["breakup"]["cgst_5"];
                            $download_array[$keys]["sgst_5"] = $return_array["breakup"]["sgst_5"];
                            $download_array[$keys]["cgst_12"] = $return_array["breakup"]["cgst_12"];
                            $download_array[$keys]["sgst_12"] = $return_array["breakup"]["sgst_12"];
                            $download_array[$keys]["cgst_18"] = $return_array["breakup"]["cgst_18"];
                            $download_array[$keys]["sgst_18"] = $return_array["breakup"]["sgst_18"];
                            $download_array[$keys]["cgst_24"] = $return_array["breakup"]["cgst_28"];
                            $download_array[$keys]["sgst_24"] = $return_array["breakup"]["sgst_28"];
                            $download_array[$keys]["total_amount"] = $return_array["total_amount"];
                        }
                    }
                    //echo "<pre>";print_r($download_array);exit;
                    $file_name = APPPATH.'third_party/company_data.csv';
                    //echo $file_name;exit;
                    $fp = fopen($file_name, 'w');
                    $counter = 0;
                    foreach($download_array as $keys=>$values){
                        if($counter == 0){
                            //echo "<pre>";print_r($download_array[$keys]);exit;
                            fputcsv($fp, array_keys($download_array[$keys]), ",");
                            fputcsv($fp, $download_array[$keys], ",");
                        }else{
                            fputcsv($fp, $download_array[$keys], ",");
                        }
                        $counter++;
                    }
                }
                echo "<pre>";print_r($download_array);
            break;

            case "bill_number":
                $bill_details = $this->bills->get_bills_details($id, "statement");
                //echo "<pre>";print_r($bill_details);
                if(!empty($bill_details)){
                    $bill_groups = array();
                    foreach($bill_details as $keys=>$values){
                        $download_array[$values["invoice_number"]]["invoice_date"] = date("d-m-Y", strtotime($values["invoice_date"]));
                        $download_array[$values["invoice_number"]]["invoice_number"] = $values["invoice_number"];
                        $download_array[$values["invoice_number"]]["company_name"] = $values["company_name"];
                        $download_array[$values["invoice_number"]]["gst_number"] = $values["gst_number"];
                        $bill_groups[$values["invoice_number"]][] = $values;
                    }
                }
                //echo "<pre>";print_r($bill_groups);exit;
                if(!empty($bill_details)){
                    $bill_details = array();
                    foreach($bill_groups as $keys=>$values){
                        $return_array = $this->GST_calculator($values, "Maharashtra");
                        //echo "<pre>";print_r($return_array);exit;
                        if(!empty($return_array)){
                            $download_array[$keys]["taxable_amount"] = number_format($return_array["breakup"]["taxable_amount"],"2",".",""); 
                            $download_array[$keys]["cgst"] = number_format($return_array["breakup"]["cgst"],"2",".","");
                            $download_array[$keys]["sgst"] = number_format($return_array["breakup"]["sgst"],"2",".","");
                            $download_array[$keys]["gst_amount"] = number_format($return_array["breakup"]["gst_amount"],"2",".","");
                            $download_array[$keys]["cess"] = number_format($return_array["breakup"]["cess"],"2",".","");
                            $download_array[$keys]["total_amount"] = $return_array["total_amount"];
                        }
                    }
                    //echo "<pre>";print_r($download_array);exit;
                    $file_name = APPPATH.'third_party/bill_data.csv';
                    //echo $file_name;exit;
                    $fp = fopen($file_name, 'w');
                    $counter = 0;
                    foreach($download_array as $keys=>$values){
                        if($counter == 0){
                            //echo "<pre>";print_r($download_array[$keys]);exit;
                            fputcsv($fp, array_keys($download_array[$keys]), ",");
                            fputcsv($fp, $download_array[$keys], ",");
                        }else{
                            fputcsv($fp, $download_array[$keys], ",");
                        }
                        $counter++;
                    }
                }
                echo "<pre>";print_r($download_array);
        break;
        }
    }

    function GST_calculator($products, $state){
		//echo "<pre>";print_r($products);exit;
		switch($state){
            case "Maharashtra":
                $total_taxable_amount = 0;
                $total_amount = 0;
                foreach($products as $keys=>$values){
                    // Check if the bill has any items which includes cess
                    // If it includes then add cess column in the bill 
                    // Else dont' show
                    if($values["cess"] > 0){
                        $products["has_cess"] = "yes";
                    }

					// Sum both CGST & SGST
                    $values["gst"] = $values["cgst"]+$values["sgst"];
                    // Calculate the rate from MRP
                    $mrp = ($values["special_rate"] != 0 ? $values["special_rate"]: $values["mrp"]);
                    $values["rate"] = (($mrp*100)/(100*(1+(($values["gst"]+$values["cess"])/100))));
                    
                    // Calculate Taxes for individual items
                    $cgst = ($values["rate"]*($values["cgst"]/100));
					$sgst = ($values["rate"]*($values["sgst"]/100));
					$cess = ($values["rate"]*($values["cess"]/100));

                    // Calculate Taxes for individual*quantity items
                    $cgst_amount = ($values["rate"]*($values["cgst"]/100)*$values["qty"]);
					$sgst_amount = ($values["rate"]*($values["sgst"]/100)*$values["qty"]);
                    $cess_amount = ($values["rate"]*($values["cess"]/100)*$values["qty"]);

					$products[$keys]["rate"] = number_format($values["rate"],4,".","");
					$products[$keys]["taxable_amount"] = number_format(($values["rate"]*$values["qty"]),4,".","");
                    $total_taxable_amount += $products[$keys]["taxable_amount"];
                    $products[$keys]["gst_amount"] = number_format((($cgst+$sgst+$cess)*$values["qty"]),4,".","");
					$products[$keys]["cgst_amount"] = number_format($cgst_amount,2,".","");
					$products[$keys]["sgst_amount"] = number_format($sgst_amount,2,".","");
                    $products[$keys]["cess_amount"] = number_format($cess_amount,2,".","");
                    $products[$keys]["final_amount"] = $products[$keys]["taxable_amount"]+$products[$keys]["gst_amount"];

                    // Create blank GST array
                    $products["breakup"]["gst_amount"] += $products[$keys]["gst_amount"];
                    $products["breakup"]["net_amount"] += $products[$keys]["rate"];
                    $products["breakup"]["taxable_amount"] += number_format($products[$keys]["taxable_amount"],4,".","");
                    $products["breakup"]["cgst"] += $cgst_amount;
                    $products["breakup"]["sgst"] += $sgst_amount;
                    $products["breakup"]["cess"] += $cess_amount;
                    if ($values["special_rate"]) {
                        $products["has_special_rate"] = "yes";
                    }

                    if(strpos( $products[$keys]["final_amount"], '.') !== false){
                        $products[$keys]["final_amount"] = number_format($products[$keys]["final_amount"],2,".","");
                        if(strpos($products[$keys]["final_amount"], ".00")){
                            $products[$keys]["final_amount"] = round($products[$keys]["final_amount"]);
                        }
                    }
                    $total_amount += $products[$keys]["final_amount"];
                }
                $products["total_amount"] = $total_amount;
                if($values["bill_discount"] > 0){
                    $products["discount_total_amount"] = number_format(($total_taxable_amount*($values["bill_discount"]/100)),4,".","");
                }
			break;

			default:
		}
		return $products;
    }

	function calculate_gst(){
        $products = array(
			"0" => array(
				"item" => "Dhokla",
				"quantity" => "15",
				"mrp" => "240",
				"gst" => "12",
			),
			"1" => array(
				"item" => "Khandvi",
				"quantity" => "12",
				"mrp" => "240",
				"gst" => "12",
			),
			"2" => array(
				"item" => "Patra",
				"quantity" => "12",
				"mrp" => "240",
				"gst" => "12",
			),
			"3" => array(
				"item" => "Silver Plates",
				"quantity" => "200",
				"mrp" => "1",
				"gst" => "18",
			),
			"4" => array(
				"item" => "Spoons",
				"quantity" => "200",
				"mrp" => "1",
				"gst" => "18",
			)
		);
		$products = $this->GST_calculator($products, "Maharashtra");
		//echo "<pre>";print_r($products);
	}
}
