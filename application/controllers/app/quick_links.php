<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Quick_links extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/quick_links_model");
		$this->load->model("app/system_help_model");
		$this->load->model("app/system_help_link_settings_model");
		$this->load->model("recruitment_employer/recruitment_employer_model");
		$this->load->model("app/application_form_model");
		$this->load->model("general_model");
		
		General::variable();
	}
	
	public function file_maintenance()
	{
		$this->data['active'] = $this->session->flashdata('active');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['user_category'] = $this->system_help_link_settings_model->get_details('portal');
		$this->load->view('app/quick_links/file_maintenance/index',$this->data);
	}

	public function quick_links_file_maintenance_action($portal,$module)
	{
		$this->data['portal'] = $portal;
		$this->data['module'] = $module;
		$this->data['topic'] = $this->system_help_model->get_topic_details($module,$portal);
		$this->data['details'] = $this->system_help_model->portal_module_details($portal,$module);
		$this->data['file_maintenance'] = $this->quick_links_model->quick_links_file_maintenance($portal,$module);
		$this->load->view('app/quick_links/file_maintenance/quick_links_file_maintenance',$this->data);
	}

	public function save_quick_links_file_maintenance($portal,$module)
	{
		$insert = $this->quick_links_model->save_quick_links_file_maintenance($portal,$module);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Quick Link is Successfully Added!</div>");	
		$this->session->set_flashdata('active',$portal);
		$this->session->set_flashdata('onload',"quick_links_file_maintenance_action('".$portal."','".$module."')");
		redirect(base_url().'app/Quick_links/file_maintenance',$this->data);

	}

	public function file_maintenance_action($portal,$module,$id,$action)
	{

		$actionn = $this->quick_links_model->file_maintenance_action($portal,$module,$id,$action);
		$this->session->set_flashdata('onload',"quick_links_file_maintenance_action('".$portal."','".$module."')");
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Quick Link File Maintenance iD - ".$id." is Successfully ".$action."d!</div>");
	}

	public function file_maintenance_action_update_form($id,$portal,$module)
	{

		$this->data['portal'] = $portal;
		$this->data['module'] = $module;
		$this->data['id'] = $id;
		$this->data['topic'] = $this->system_help_model->get_topic_details($module,$portal);
		$this->data['details'] = $this->quick_links_model->get_topic_details_id($id);
		$this->load->view('app/quick_links/file_maintenance/quick_links_file_maintenance_update',$this->data);
	}	


	public function save_quick_links_file_maintenance_update($portal,$module)
	{
		$id = $this->input->post('quick_link_id');
		$update = $this->quick_links_model->save_file_maintenance_update($portal,$module);
		$this->session->set_flashdata('onload',"quick_links_file_maintenance_action('".$portal."','".$module."')");
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Quick Links File Maintenance iD - ".$id." is Successfully Updated!</div>");
		$this->session->set_flashdata('active',$portal);
		redirect(base_url().'app/Quick_links/file_maintenance',$this->data);
	}


	//quick links 

	public function quick_links()
	{
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['user_category'] = $this->quick_links_model->portal();
		$this->load->view('app/quick_links/quick_links/index',$this->data);
	}

	public function quick_links_action($portal,$module)
	{
		$this->data['portal'] = $portal;
		$this->data['module'] = $module;
		$this->data['topic'] = $this->system_help_model->get_topic_details($module,$portal);
		$this->data['details'] = $this->system_help_model->portal_module_details($portal,$module);
		$this->data['quick_links'] = $this->quick_links_model->quick_links_details($portal,$module);
		$this->load->view('app/quick_links/quick_links/quick_links_action',$this->data);
	}
	
}//end controller
 	


