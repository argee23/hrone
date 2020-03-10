<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Inventory_storage_settings extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/inventory_storage_settings_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index()
	{
		$this->data['message'] = $this->session->flashdata('message');	
		$this->data['company_name']="All Company Settings";

		$this->data['del_invent_storage_setting']=$this->session->userdata('del_invent_storage_setting');
		$this->data['edit_invent_storage_setting']=$this->session->userdata('edit_invent_storage_setting');
		$this->data['add_invent_storage_setting']=$this->session->userdata('add_invent_storage_setting');
		$this->data['ena_dis_invent_storage_setting']=$this->session->userdata('ena_dis_invent_storage_setting');

		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$this->data['company_id']='all';
		$this->data['settings'] = $this->inventory_storage_settings_model->get_settings('all');
		$this->load->view('app/inventory_storage_settings/index',$this->data);
	}
	public function get_inventory_settings($company)
	{
		$this->data['del_invent_storage_setting']=$this->session->userdata('del_invent_storage_setting');
		$this->data['edit_invent_storage_setting']=$this->session->userdata('edit_invent_storage_setting');
		$this->data['add_invent_storage_setting']=$this->session->userdata('add_invent_storage_setting');
		$this->data['ena_dis_invent_storage_setting']=$this->session->userdata('ena_dis_invent_storage_setting');

		$this->data['message'] = $this->session->flashdata('message');	
		$this->data['company_id']=$company;
		if($company=='all'){ $this->data['company_name']="All Company Settings"; } else{ $this->data['company_name']= $this->inventory_storage_settings_model->get_company_details($company); }
		$this->data['settings'] = $this->inventory_storage_settings_model->get_settings($company);
		$this->load->view('app/inventory_storage_settings/index',$this->data);
	}
	public function add_settings($company)
	{
		$this->data['company']=$company;
		$this->load->view('app/inventory_storage_settings/add_settings',$this->data);
	}
	public function save_settings($company)
	{
		$settings=$this->input->post('settings');
		$description=$this->input->post('description');
		$datefrom=$this->input->post('datefrom');
		$dateto=$this->input->post('dateto');
		$hard_drive=$this->input->post('hard_drive');
							/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/
	General::system_audit_trail('Administrator','Inventory Storage Settings','logfile_admin_inventory_storage','settings|description|datefrom|dateto|hard_drive','Add '.$settings.'|'.$description.'|'.$datefrom.'|'.$dateto.'|'.$hard_drive,'INSERT',$settings);

		$insert = $this->inventory_storage_settings_model->save_settings($company);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Setting is successfully added!</div>");
		redirect('app/inventory_storage_settings/get_inventory_settings/'.$company,$this->data);
	}
	public function action_settings($action,$company,$id)
	{


							/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/

		General::system_audit_trail('Administrator','Inventory Storage Settings','logfile_admin_inventory_storage',' settings|description|datefrom|dateto|hard_drive',$action.' '.$company.'|'.$id,$action,$id);

		$action = $this->inventory_storage_settings_model->action_settings($action,$company,$id);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$action."</div>");
	}
	public function update_settings($company,$id)
	{
		$this->data['details']=$this->inventory_storage_settings_model->get_details_settings($id);
		$this->data['company']=$company;
		$this->data['id']=$id;
		$this->load->view('app/inventory_storage_settings/update_settings',$this->data);
	}
	public function saveupdate_settings($company,$id)
	{
		$settings=$this->input->post('settings');
		$description=$this->input->post('description');
		$datefrom=$this->input->post('datefrom');
		$dateto=$this->input->post('dateto');
		$hard_drive=$this->input->post('hard_drive');

							/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/

	General::system_audit_trail('Administrator','Inventory Storage Settings','logfile_admin_inventory_storage','settings|description|datefrom|dateto|hard_drive','Update '.$settings.'|'.$description.'|'.$datefrom.'|'.$dateto.'|'.$hard_drive,'UPDATE',$settings);


		$insert = $this->inventory_storage_settings_model->saveupdate_settings($company,$id);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Setting id - ".$id." is successfully updated!</div>");
		redirect('app/inventory_storage_settings/get_inventory_settings/'.$company,$this->data);
	}
}//end controller



