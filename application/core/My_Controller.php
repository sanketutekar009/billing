<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_Controller extends CI_Controller {

    public $pass_header_data = array(); // This array is used to pass data from controller to html i.e. in header section
    public $pass_main_data = array(); // This array is used to pass data from controller to html i.e. in content section
    public $pass_footer_data = array(); // This array is used to pass data from controller to html i.e. in footer section
    public $pass_meta_data = array(); // This array is used to pass data from controller to html i.e. in meta section
    
    function __construct(){
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->library('Template'); //Loads William's concept template library 
		$this->load->library('session'); //Loads Codeigniter's Session library
		
		date_default_timezone_set('Asia/Calcutta');

		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }
    
    /**
    * @author Sanket Utekar
    * @abstract This function is used to set layout i.e. 1) If we want to add a new layout then we have to add it in view folder
    * 2) Then create a dynamic layout 
    * 3) Load its Header Content and footer views accordingly	
    * @since 21-12-2016
    * @$param1 The paramater which we want to load..
    */
    
    function set_layout($param1){
		switch($param1){
			case 'default':
				$default['template'] = 'layouts/default_layout.php'; // This line creates a dynamic template called default_layout.php i.e. we dont need to add it in config/template.php file
				$default['public'] = array(
					'title',
					'meta',
					'header',
					'content',
					'footer',
				);
					
				$this->template->add_template('default_layout', $default, TRUE); // This line creates a dynamic template called default_layout.php i.e. we dont need to add it in config/template.php file
				
				// Loading css files..
				//$this->template->add_css('assets/css/bootstrap.min.css');
				//$this->template->add_css('assets/css/font-awesome.min.css');
				
				// Loading js files..
				//$this->template->add_js('assets/js/jquery-1.9.1.min.js');
				//$this->template->add_js('assets/js/bootstrap.min.js');
			
				$this->template->add_js('base_url = "'.base_url().'"','embed'); // This line make base_url available in all js..
			break;
		}
    }

   /**
    * @author Sanket Utekar
    * @abstract This function accepts one parameter i.e. the content name 	
    * @since 20-10-2013
    * @$content The content which we want to load..
    * @header The header which we want to load..
    * @footer The footer which we want to load..
    */
    
    function display_view($content,$header = 'header/header',$footer = 'footer/footer'){
	    /*$meta = '<meta name="description" content="'.$this->pass_meta_data['description'].'">';
	    $meta .= '<meta name="keywords" content="'.$this->pass_meta_data['keywords'].'">';
	    $meta .= '<meta name="author" content="Moneyfrog">';
	    
	    $this->template->write('title', $this->pass_meta_data['title']);
	    $this->template->write('meta', $meta);*/
	    
	    $this->template->write_view('header', $header, $this->pass_header_data); // This line loads views/header/header.php file which will be displayed in default_layout.php header section 
	    $this->template->write_view('content', $content, $this->pass_main_data); // This line loads views/frontend/home.php file which will be displayed in default_layout.php content section 
	    $this->template->write_view('footer', $footer, $this->pass_footer_data); // This line loads views/footer/footer.php file which will be displayed in default_layout.php footer section 
	    $this->template->render(); // This line will display the html on browser
    }

	function check_session_data(){
		$session_data = $this->session->userdata("internal_users_details");
		//echo "<pre>";print_r($session_data);exit;
		return $session_data;
	}
}
