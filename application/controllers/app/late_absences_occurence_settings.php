<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Late_absences_occurence_settings extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/late_absences_occurence_settings_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	

	public function index()
	{
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		$this->load->view('app/time/late_absences_occurence_settings/index',$this->data);
	}

	public function late_absence_setting($val)
	{
		$this->data['val'] = $val;
		$this->load->view('app/time/late_absences_occurence_settings/late_absence_setting',$this->data);
	}

	public function setting_action($company,$val,$option)
	{
		
   	 $this->data['time_late_abs_mng_settings']=$this->session->userdata('time_late_abs_mng_settings');

		$this->data['option'] = $option;
		$this->data['company'] = $company;
		$this->data['val'] = $val;
		$this->data['classification'] = $this->late_absences_occurence_settings_model->get_classification($company);
		$this->load->view('app/time/late_absences_occurence_settings/setting_action',$this->data);
	}
	
	public function save_settings($company,$val)
	{
		$save = $this->late_absences_occurence_settings_model->save_settings($company,$val);



		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> ".$val." Settings for company id ".$company." is successfully updated!</div>");
		redirect('app/late_absences_occurence_settings/index',$this->data);
	}

	public function setting()
	{	
		$this->data['setting'] = $this->late_absences_occurence_settings_model->settings();
		$this->load->view('app/time/late_absences_occurence_settings/setting',$this->data);
	}

	public function save_setting($setting)
	{
		$this->late_absences_occurence_settings_model->save_setting($setting);
		$this->session->set_flashdata('onload',"setting()");
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>New Setting is successfully added!</div>");
	}

	public function action_setting($action,$id)
	{
		$this->late_absences_occurence_settings_model->action_setting($action,$id);
		$this->session->set_flashdata('onload',"setting()");
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Setting id ".$id." is successfully ".$action."d!</div>");
	}

	public function save_update_setting($setting_name,$id)
	{
		$this->late_absences_occurence_settings_model->save_update_setting($setting_name,$id);
		$this->session->set_flashdata('onload',"setting()");
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Setting id ".$id." is successfully updated!</div>");
	}

	public function late_absence_basis()
	{
		$this->load->view('app/time/late_absences_occurence_settings/late_absence_basis',$this->data);
	}

	public function setting_action_basis($company)
	{

		 $this->data['time_late_abs_mng_settings']=$this->session->userdata('time_late_abs_mng_settings');
		$this->data['company']=$company;
		$this->data['setting_value'] = $this->late_absences_occurence_settings_model->get_basis_settings_value($company);
		$this->data['setting'] = $this->late_absences_occurence_settings_model->get_basis_settings();
		$this->load->view('app/time/late_absences_occurence_settings/setting_action_basis',$this->data);
	}

	public function save_basis($company)
	{
		$this->late_absences_occurence_settings_model->save_basis_company($company);

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */

		$occurence_late = $this->input->post('occurance_late');
		$occurence_absence = $this->input->post('occurance_absence');
		$total_late = $this->input->post('total_late');
		$total_absence = $this->input->post('total_absence');
		$what="occurence_late|occurence_absence|total_late|total_absence";
		$what_data="$occurence_late|$occurence_absence|$total_late|$total_absence";

            $this->general_model->system_audit_trail('Time','Time Late and Absences Monitoring','logfile_time_late_abs_monitor',''.$what.'|'.$what_data.'','UPDATE',$company);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Late and Absences basis for company id ".$company." is successfully updated!</div>");
		redirect('app/late_absences_occurence_settings/index',$this->data);
	}
}//end controller



