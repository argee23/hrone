<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Working_schedule_color_code extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/working_schedule_color_code_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index()
	{
		$this->data['edit_ws_color_code']=$this->session->userdata('edit_ws_color_code');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$this->data['message'] = $this->session->flashdata('message');	
		$this->data['details'] = $this->working_schedule_color_code_model->get_color_code();
		$this->load->view('app/working_schedule_color_code/index',$this->data);
	}

	public function update_color_code($id)
	{
		$this->data['id']=$id;
		$this->data['details']=$this->working_schedule_color_code_model->get_color_details($id);
		$this->load->view('app/working_schedule_color_code/update_modal',$this->data);
	}
	public function save_colorcode_update($id)
	{
		$color=$this->input->post('color');

							/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/
	General::system_audit_trail('Administrator','Working Schedule Color Code','logfile_admin_ws_color_code','Update '.$color.'|'.$id,'UPDATE',$id);


		$update = $this->working_schedule_color_code_model->save_colorcode_update($id);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Working Schedule Color Code Details is successfully Updated!</div>");
		redirect('app/working_schedule_color_code/index/',$this->data);
	}
}//end controller



