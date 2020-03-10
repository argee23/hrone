<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Serttech_recruitment_reports extends General{

	function __construct(){
		parent::__construct();	
		//$this->load->model('login_model');
		$this->load->model('serttech/serttech_login_model');
		$this->load->model('serttech/serttech_recruitment_setting_model');
		$this->load->model('serttech/serttech_recruitment_reports_model');
		$this->load->model('general_model');
		$this->load->model('recruitment_employer/recruitment_employer_model');
		$this->load->model('app/recruitment_model');
		$this->load->model('app/recruitments_model');
		//$this->load->model('app/roles_model');
		General::variable();
	} 



//START OF SETTINGS

	public function index(){
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['serttech_account'] = $this->serttech_login_model->getUserLoggedIn($this->input->post('username'));
		$this->load->view('serttech/serttech_report/index',$this->data);
	}
	
	public function crystal_report_settings($code)
	{
		$this->data['code_type'] = $code;
		$this->data['crystal_report'] = $this->serttech_recruitment_reports_model->get_crystal_report($code);
		if($code=='CRRS1')
		{
			$this->data['setting'] = $this->serttech_recruitment_reports_model->get_serttech_settings();
		}
		$this->load->view('serttech/serttech_report/crystal_report',$this->data);
	}

	public function add_crystal_report($code_type,$code)
	{
		$this->data['code'] = $code;
		$this->data['code_type'] = $code_type;
		$this->data['fields_default'] = $this->serttech_recruitment_reports_model->add_crystal_report($code_type,$code);
		$this->load->view('serttech/serttech_report/add_crystal_report',$this->data);

	}	

	public function save_crystal_report($code,$code_type,$name_final,$description_final,$data)
	{
		$insert = $this->serttech_recruitment_reports_model->save_crystal_report($code,$code_type,$name_final,$description_final,$data);
		$this->session->set_flashdata('onload',"crystal_report_settings('".$code_type."')");
	}


	public function stat_crystal_report($action,$id,$type,$code)
	{
		$this->data['code'] = $type;
		$this->data['code_type'] = $code;


		if($action=='view')
		{
			$this->data['details'] = $this->serttech_recruitment_reports_model->crystal_report_details($id);
			$this->data['fields_default'] =  $this->serttech_recruitment_reports_model->crystal_report_fields($type,$code);
			$this->load->view('serttech/serttech_report/crystal_report_view',$this->data);
		}
		else
		{
			$update = $this->serttech_recruitment_reports_model->stat_crystal_report($action,$id);
			$this->session->set_flashdata('onload',"crystal_report_settings('".$type."')");
		}
	}


	public function edit_crystal_report($action,$id,$type,$code)
	{
		$this->data['code'] = $type;
		$this->data['code_type'] = $code;

		$this->data['details'] = $this->serttech_recruitment_reports_model->crystal_report_details($id);
		$this->data['fields_default'] =  $this->serttech_recruitment_reports_model->crystal_report_fields($type,$code);
		$this->load->view('serttech/serttech_report/crystal_report_edit',$this->data);
			
	}

	public function update_crystal_report($code,$code_type,$name_final,$description_final,$data,$crystal_id)
	{

		$update = $this->serttech_recruitment_reports_model->update_crystal_report($code,$code_type,$name_final,$description_final,$data,$crystal_id);
		$this->session->set_flashdata('onload',"crystal_report_settings('".$code."')");
		
	}


//start of generate setting report

	public function generate_report_filtering($code)
	{
		if($code=='CRRS2') { $codee = 'RE1'; } 
		else if($code=='CRRS3'){ $codee = 'JM1'; } 
		else if($code=='CRRS4'){ $codee = 'RS1'; } 
		else if($code=='CRRS5'){ $codee = 'PS1'; } 
		else{ $codee=''; }
		if($code=='CRRS1')
		{
			$this->data['setting'] = $this->serttech_recruitment_reports_model->get_serttech_settings_all();
		}
		else 
		{
			$this->data['crystal_report'] = $this->serttech_recruitment_reports_model->get_crystalreport($code,$codee);
		}
		
		$this->data['code'] = $code;
		$this->load->view('serttech/serttech_report/generate_report',$this->data);
	}

	public function get_crystal_report($code_type,$code)
	{
		$crystal_report = $this->serttech_recruitment_reports_model->get_code_crystal_report($code_type,$code);
		echo "<option value='default'>Default</option>";
		foreach($crystal_report as $c)
		{
			echo "<option value='".$c->id."'>".$c->title."</option>";
		}
	}

	public function generate_report_settings_results($code_type,$code,$crystal_report)
	{
		$this->data['code'] = $code;
		$this->data['code_type'] = $code_type;
		$this->data['crystalreport'] = $crystal_report;
		$this->data['crystal_report'] =  $this->serttech_recruitment_reports_model->get_crystal_report_fields($crystal_report);
		$this->data['details'] =  $this->serttech_recruitment_reports_model->generate_report_settings_results($code_type,$code);
		$this->load->view('serttech/serttech_report/generate_report_setting_results',$this->data);

	}

	public function get_employers_registered_results($code,$employer,$accounttype,$status,$r_from,$r_to,$e_to,$e_from,$crystal_report)
	{ 
		$this->data['crystalreport'] = $crystal_report;
		$this->data['crystal_report'] =  $this->serttech_recruitment_reports_model->get_crystal_report_fields($crystal_report);
		$this->data['code']=$code;
		$this->data['details']=$this->serttech_recruitment_reports_model->get_employers_registered_results($code,$employer,$accounttype,$status,$r_from,$r_to,$e_to,$e_from);
		$this->load->view('serttech/serttech_report/report_registered_employees_results',$this->data);
	}

	public function get_job_management_results($code,$employer,$status,$r_from,$r_to,$u_to,$u_from,$crystal_report)
	{
		$this->data['crystalreport'] = $crystal_report;
		$this->data['crystal_report'] =  $this->serttech_recruitment_reports_model->get_crystal_report_fields($crystal_report);
		$this->data['code']=$code;
		$this->data['details']=$this->serttech_recruitment_reports_model->get_job_management_results($code,$employer,$status,$r_from,$r_to,$u_to,$u_from);
		$this->load->view('serttech/serttech_report/report_job_management_results',$this->data);
	}
	public function get_requirement_status_results($code,$employer,$datefinal,$datefrom,$dateto,$account,$status,$crystal_report)
	{
		$this->data['crystalreport'] = $crystal_report;
		$this->data['crystal_report'] =  $this->serttech_recruitment_reports_model->get_crystal_report_fields($crystal_report);
		$this->data['code']=$code;
		$this->data['details']=$this->serttech_recruitment_reports_model->get_requirement_status_results($code,$employer,$datefinal,$datefrom,$dateto,$account,$status);
		$this->load->view('serttech/serttech_report/report_requirement_status_results',$this->data);
	}

	public function get_payment_status_results($employer,$employer,$payment,$license,$account_type,$datefinal,$crystal_report,$datefrom,$dateto)
	{
		
		$this->data['crystalreport'] = $crystal_report;
		$this->data['crystal_report'] =  $this->serttech_recruitment_reports_model->get_crystal_report_fields($crystal_report);
		$this->data['details']=$this->serttech_recruitment_reports_model->get_payment_status_results($employer,$employer,$payment,$license,$account_type,$datefinal,$crystal_report,$datefrom,$dateto);
		$this->load->view('serttech/serttech_report/report_payment_status_results',$this->data);
	}
}