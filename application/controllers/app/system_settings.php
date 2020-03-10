<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class System_settings extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/system_settings_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	

	public function index(){
		$this->data['topics']=$this->system_settings_model->get_topics();
		$this->load->view('app/system_setting/index',$this->data);	
	}


	public function manage_setting($val){

		$this->data['topics']=$this->system_settings_model->get_topics();
		$this->data['topic_details']=$this->system_settings_model->get_spec_topics($val);
		$this->data['mainPageui']=$this->system_settings_model->main_page_user_interface();


		$this->load->view('app/system_setting/manage_settings',$this->data);	
	}

	public function save_setting(){

		$setting_type=$this->input->post('setting_type');
		$id=$this->input->post('topic_id');
		$single_value=$this->input->post('single_value');
		if($id=="8"){
			$f=$this->input->post('single_value_from');
			$t=$this->input->post('single_value_to');
			$single_value=$f." to ".$t;
		}else{

		}

		$this->system_settings_model->update_single_value($id,$single_value);

		redirect('app/system_settings/index');

	}

}