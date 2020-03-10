<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Pms_employee extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/pms_model");
		$this->load->model("employee_portal/pms_employee_model");
		$this->load->model("general_model");
	}

	public function index(){	
		$this->data['ratee'] = $this->pms_employee_model->getMyRatees();
		$this->data['message'] = $this->session->flashdata('message');	
		$this->data['onload'] = $this->session->flashdata('onload');

		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/pms/_scorecard/myratees', $this->data);	
		$this->load->view('employee_portal/footer');		
	}

	public function view_scorecards($employee_id){

		$this->data['ratee'] = $this->pms_employee_model->get_emp_ratee($employee_id);
		$this->data['general_forms'] = $this->pms_employee_model->get_general_forms();
		$this->data['checkAppraisalPer'] = $this->pms_employee_model->val_appraisal_period($employee_id);

		$this->data['AppraisalPer'] = $this->pms_employee_model->GetAppraisalPeriod($employee_id);

		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();
		$this->data['employee_id']=$employee_id;
		// $this->data['checkFormPartNo']= $this->pms_model->validateFormPartNumber($employee_id);
		//$this->load->view('employee_portal/pms/_scorecard/test_height', $this->data);	
		$this->load->view('employee_portal/pms/_scorecard/manage_form_format', $this->data);	
	}


	public function viewGeneralForms(){
		$form_id= $this->uri->segment('4');
		$employee_id= $this->uri->segment('5');
		$position_id= $this->uri->segment('6');
		//echo "$form_id | $employee_id ";

		$this->data['form_id']=$form_id;
		$this->data['employee_id']=$employee_id;
		$this->data['position_id']=$position_id;

		$this->data['GenFormFormat']=$this->pms_employee_model->GenFormFormat($form_id);
		$this->data['GenFormCriteria']=$this->pms_employee_model->GenFormCriteria($form_id,$position_id);
		$this->data['FormFormatScoring']=$this->pms_employee_model->FormFormatScoring($form_id);
		$this->load->view('employee_portal/pms/_scorecard/form_format', $this->data);
	}

	public function saveAppraisalPeriod($employee_id){
		$duration_from=$this->input->post('date_from');
		$duration_to=$this->input->post('date_to');
		$creator=$this->session->userdata('employee_id');
		$date_created=date('Y-m-d H:i:s');
		$status="format_pending";
		$doc_no="$employee_id"."_".date('YmdHis');

		$app_data =array(
			'employee_id'	=> $employee_id,
			'creator'	=> $creator,
			'doc_no'	=> $doc_no,
			'duration_from'	=> $duration_from,
			'duration_to'	=> $duration_to,
			'date_created'	=> $date_created,
			'status'	=> $status,

			);
		$this->security->xss_clean($app_data);
		$this->pms_employee_model->saveAppraisalPeriod($app_data);
		$this->session->set_flashdata('onload',"scorecard('".$employee_id."')");
		$this->index();


	}

	public function saveEmployeeForm($form_id,$employee_id,$position_id){
		$this->data['message'] = $this->session->flashdata('message');	
		$this->data['onload'] = $this->session->flashdata('onload');

		//echo "$employee_id | $form_id | $position_id";
		$this->data['GenFormFormat']=$this->pms_employee_model->GenFormFormat($form_id);
		$this->data['GenFormCriteria']=$this->pms_employee_model->GenFormCriteria($form_id,$position_id);
		$this->data['FormFormatScoring']=$this->pms_employee_model->FormFormatScoring($form_id);


		// $FormFormat=(
		// 	'doc_no'	=>	,

		// 	);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  PMS Form Successfully Filed for <strong> name </strong></div>");

		//redirect('employee_portal/pms_employee');
		$this->session->set_flashdata('onload',"scorecard('".$employee_id."')");
		$this->index();
	}

}



?>