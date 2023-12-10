<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->library('Template'); //Loads William's concept template library 
		$this->load->library('session'); //Loads Codeigniter's Session library
		
		date_default_timezone_set('Asia/Calcutta');
    }
	
	public function index(){
		//$this->load->view('welcome_message');
		redirect(base_url("login"));
	}
}
