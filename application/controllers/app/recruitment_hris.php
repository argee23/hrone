<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Recruitment_hris extends General{

	function __construct(){
		parent::__construct();	
		//$this->load->model("app/employee_model");
		$this->load->model("app/recruitment_hris_model");
		$this->load->model("general_model");
		if($this->session->userdata('recruitment_employer_is_logged_in')){

		}
		else if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		
		General::variable();
	}
	
	public function index()
	{
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['code'] = $this->session->flashdata('code');
		$this->data['question_type'] = $this->session->flashdata('question_type');
		$this->load->view('app/recruitment_maintenance/setting/index',$this->data);	
	} 
	
	public function setting_company($company_id,$code)
	{ 
		
		$this->data['code'] = $code;
		if($code=='ED9')
		{
			$this->data['plantilla'] = $this->recruitment_hris_model->plantilla($company_id);
		}
		else if($code=='ED2')
		{
			$this->data['details']=$this->recruitment_hris_model->get_applicant_status_option($company_id);
		}
		else if($code=='ED3' || $code=='ED12' || $code=='ED11' || $code=='ED14' || $code=='ED15')
		{
			$this->data['details']=$this->recruitment_hris_model->ED3_get_data($company_id,$code);
		}
		else if($code=='ED4')
		{

		}
		else if($code=='ED5')
		{
			$this->data['question_type'] = $this->session->flashdata('question_type');
			$this->data['details']=$this->recruitment_hris_model->ED5_get_employer_settings_questions($company_id,$this->session->flashdata('question_type'));
		}
		else if($code=='ED6')
		{
			$this->data['details']=$this->recruitment_hris_model->ED6_get_employer_job_requirements($company_id);
		}
		else if($code=='ED1')
		{
			$this->data['details']=$this->recruitment_hris_model->ED1_get_employer_email_host($company_id);
		}
		else if($code=='ED10')
		{
			$this->data['max_approver']=$this->recruitment_hris_model->ED10_get_setting_data($company_id,$code);
			$this->data['approver_choices']=$this->recruitment_hris_model->ED10_get_approver_choices($company_id);
			$this->data['department']=$this->recruitment_hris_model->ED10_get_department($company_id);
			$this->data['location']=$this->recruitment_hris_model->ED10_get_location($company_id);
			$this->data['details']=$this->recruitment_hris_model->ED10_details($company_id);
		}
		else if($code=='ED13')
		{	
			$this->data['employee_list'] = $this->recruitment_hris_model->get_employee_list($company_id);
			$this->data['employees']=$this->recruitment_hris_model->ED13_employees($company_id);
			$this->data['details']=$this->recruitment_hris_model->ED1_get_employer_email_host($company_id);
		}
		else if($code=='ED16')
		{
			$this->data['location']=$this->recruitment_hris_model->location($company_id);
			$this->data['admin'] = $this->recruitment_hris_model->admin_list($company_id);
		}
		else{}
		$this->data['company_id']=$company_id;
		$this->data['settings'] = $this->recruitment_hris_model->settings();
		$this->load->view('app/recruitment_maintenance/setting/settings',$this->data);
	}

	public function setting_plantilla_add($company_id)
	{
		$this->data['company_id']=$company_id;
		$this->data['company_name'] = $this->recruitment_hris_model->get_company_name($company_id);
		$this->data['lastplantilla'] = $this->recruitment_hris_model->lastplantilla($company_id);
		$this->load->view('app/recruitment_maintenance/setting/setting_plantilla_add',$this->data);	
	}

	public function save_plantilla($company_id)
	{
		$this->data['plantilla'] = $this->recruitment_hris_model->save_plantilla($company_id);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Plantilla for Company ID - ".$company_id." is Successfully Added!</div>");
		$this->session->set_flashdata('onload',"set_setting('".$company_id."','ED9')");
		$this->session->set_flashdata('code','ED9');
		redirect(base_url().'app/recruitment_hris/index',$this->data);
	}

	public function delete_plantilla($company_id,$id,$code)
	{
		$delete = $this->recruitment_hris_model->delete_plantilla($id,$company_id);
		$this->session->set_flashdata('onload',"set_setting('".$company_id."','".$code."')");
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Plantilla ID - ".$company_id." is Successfully Deleted!</div>");
		$this->session->set_flashdata('code',$code);
	}

	public function saveupdate_plantilla($company_id,$id,$no,$details_final,$from,$to,$code)
	{
		$udpate = $this->recruitment_hris_model->saveupdate_plantilla($company_id,$employer,$id,$no,$details_final,$from,$to);
		$this->session->set_flashdata('onload',"set_setting('".$company_id."','".$code."')");
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Plantilla ID - ".$company_id." is Successfully Updated!</div>");
		$this->session->set_flashdata('code',$code);

	}	

	public function get_company_settings($company_id,$code)
	{

		$this->data['code'] = $code;
		$this->data['company_id'] =$company_id;

		if($code=='ED9')
		{
			$this->data['plantilla'] = $this->recruitment_hris_model->plantilla($company_id);
		}
		else if($code=='ED2')
		{
			$this->data['details']=$this->recruitment_hris_model->get_applicant_status_option($company_id);
		}
		else if($code=='ED3' || $code=='ED12' || $code=='ED11' || $code=='ED14' || $code=='ED15')
		{
			$this->data['details']=$this->recruitment_hris_model->ED3_get_data($company_id,$code);
		}
		else if($code=='ED4')
		{

		}
		else if($code=='ED5')
		{
			$this->data['question_type'] = $this->session->flashdata('question_type');
			$this->data['details']=$this->recruitment_hris_model->ED5_get_employer_settings_questions($company_id,$this->session->flashdata('question_type'));
		}
		else if($code=='ED6')
		{
			$this->data['details']=$this->recruitment_hris_model->ED6_get_employer_job_requirements($company_id);
		}
		else if($code=='ED1')
		{
			$this->data['details']=$this->recruitment_hris_model->ED1_get_employer_email_host($company_id);
		}
		else if($code=='ED10')
		{
			$this->data['max_approver']=$this->recruitment_hris_model->ED10_get_setting_data($company_id,$code);
			$this->data['approver_choices']=$this->recruitment_hris_model->ED10_get_approver_choices($company_id);
			$this->data['department']=$this->recruitment_hris_model->ED10_get_department($company_id);
			$this->data['location']=$this->recruitment_hris_model->ED10_get_location($company_id);
			$this->data['details']=$this->recruitment_hris_model->ED10_details($company_id);
		}
		else if($code=='ED13')
		{	
			$this->data['employee_list'] = $this->recruitment_hris_model->get_employee_list($company_id);
			$this->data['employees']=$this->recruitment_hris_model->ED13_employees($company_id);
			$this->data['details']=$this->recruitment_hris_model->ED1_get_employer_email_host($company_id);
		}
		else if($code=='ED16')
		{
			$this->data['location']=$this->recruitment_hris_model->location($company_id);
			$this->data['admin'] = $this->recruitment_hris_model->admin_list($company_id);
		}
		else{}

		$this->load->view('app/recruitment_maintenance/setting/setting_'.$code.'_main',$this->data);	
	}

	public function get_company_settings_questions($company_id,$val,$code)
	{

		$this->data['company_id'] = $company_id;
		$this->data['question_type'] = $val;
		$this->data['details']=$this->recruitment_hris_model->ED5_get_employer_settings_questions($company_id,$val);
		$this->load->view('app/recruitment_maintenance/setting/setting_'.$code.'_main',$this->data);	
	}

	//new status option actions
	public function ED2_add_new_status_modal($company_id,$code)
	{
		$this->data['code'] = $code;
		$this->data['company_id']=$company_id;
		$this->load->view('app/recruitment_maintenance/setting/setting_'.$code.'_add',$this->data);	
	}

	public function ED2_save_new_status_position($company_id,$code)
	{
		$title = $this->input->post('title');
		$description = $this->input->post('description');
		$color = $this->input->post('color');
		$save_new_status_position = $this->recruitment_hris_model->ED2_save_new_status_position($company_id,$title,$description,$color);
		if($save_new_status_position=='inserted')
		{
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Application Status for company id - ".$company_id." is successfully added!.</div>");
		}
		else
		{
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error!</div>");
		}
			
       	$this->session->set_flashdata('onload',"set_setting('".$company_id."','".$code."')");
       	$this->session->set_flashdata('code',$code);
		
		redirect(base_url().'app/recruitment_hris/index',$this->data);
	}

	public function ED2_employer_status_action($action,$id,$title,$description,$color,$company_id)
	{
		$this->data['company_id']=$company_id;
		$actionn = $this->recruitment_hris_model->employer_status_action($action,$id,$title,$description,$color,$company_id);
		
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Application Status for company id - ".$company_id." is successfully ".$action."d!.</div>");
        
        $this->session->set_flashdata('onload',"set_setting('".$company_id."','ED2')");
       	$this->session->set_flashdata('code','ED2');
		
		
	}

	public function ED2_employer_status_numbering($company_id,$value_numbering,$value_id,$count,$checking_type)
	{
		$action = $this->recruitment_hris_model->ED2_save_updated_numbering($company_id,$value_numbering,$value_id,$count,$checking_type);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Application Status Numbering for company id - ".$company_id." is successfully updated!.</div>");
		$this->session->set_flashdata('onload',"set_setting('".$company_id."','ED2')");
       	$this->session->set_flashdata('code','ED2');
	}

	public function ED2_manage_interviewprocess_modal($company_id,$id,$code)
	{
		$this->data['company_id'] =$company_id;
		$this->data['company_name'] = $this->recruitment_hris_model->get_company_name($company_id);
		$this->data['details'] = $this->recruitment_hris_model->ED2_get_interview_process($company_id);
		$this->load->view('app/recruitment_maintenance/setting/setting_ED2_interviewprocess_modal',$this->data);	
	}

	public function ED2_save_interview_process($title,$description,$color,$company_id)
	{
		$this->data['company_id']=$company_id;
		$insert = $this->recruitment_hris_model->ED2_save_interview_process($title,$description,$color,$company_id);
		$this->data['details'] = $this->recruitment_hris_model->ED2_get_interview_process($company_id);
		$this->data['msg'] = "Interview Process for Company ID - ".$company_id." is Successfully Added!";
	
		$this->load->view('app/recruitment_maintenance/setting/setting_ED2_interview_process_view',$this->data);	
	}

	public function ED2_interview_process_action($company_id,$id,$action)
	{
		$this->data['company_id']=$company_id;
		$interview_process_action = $this->recruitment_hris_model->ED2_interview_process_action($company_id,$id,$action);
		$this->data['details'] = $this->recruitment_hris_model->ED2_get_interview_process($company_id);
		$this->data['msg'] = "Interview Process for Company ID - ".$company_id." is Successfully ".$action."d!";
		$this->load->view('app/recruitment_maintenance/setting/setting_ED2_interview_process_view',$this->data);
	}	

	public function ED2_save_update_interview_process($count,$company_id,$value_numbering,$value_id)
	{
		$this->data['company_id']=$company_id;
		$update = $this->recruitment_hris_model->ED2_save_update_interview_process($count,$company_id,$value_numbering,$value_id);
		$this->data['details'] = $this->recruitment_hris_model->ED2_get_interview_process($company_id);
		$this->data['msg'] = "Interview Process  Numbering for company id - ".$company_id." is Successfully Updated!"; 
		$this->load->view('app/recruitment_maintenance/setting/setting_ED2_interview_process_view',$this->data);
	}

	public function ED1_email_settings($company_id,$code)
	{
		$action = $this->recruitment_hris_model->ED1_save_email_setting($company_id,$code);
		$this->session->set_flashdata('onload',"set_setting('".$company_id."','".$code."')");
		$this->session->set_flashdata('code',$code);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Email Settings for company id - ".$company_id." is successfully updated!.</div>");
      	redirect(base_url().'app/recruitment_hris/index',$this->data);
	}

	public function ED3_singlefield_save($company_id,$code)
	{
		$action = $this->recruitment_hris_model->ED3_emailnotif_settings($company_id,$code);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Send Interview for Email Notification Setting for company id - ".$company_id." is successfully updated!.</div>");
      	$this->session->set_flashdata('onload',"set_setting('".$company_id."','".$code."')");
		$this->session->set_flashdata('code',$code);
      	redirect(base_url().'app/recruitment_hris/index',$this->data);
	}

	public function  ED6_save_job_requirements($company,$action,$id,$uploadable,$title)
	{
		$action = $this->recruitment_hris_model->ED6_save_job_requirements($company,$action,$id,$uploadable,$title);
		$this->session->set_flashdata('onload',"set_setting('".$company."','ED6')");
		$this->session->set_flashdata('code',$code);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Job Requirements for company id - ".$company." is successfully updated!.</div>");
  	
	}

	public function ED13_save_approver($company_id,$employee_id)
	{
		$employee_id =$this->input->post('employee_id');
		$action = $this->recruitment_hris_model->ED13_save_approver($company_id,$code,$employee_id);
		$this->session->set_flashdata('onload',"set_setting('".$company_id."','ED13')");
		$this->session->set_flashdata('code',$code);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Employee ID - ".$employee_id." for company id - ".$company_id." is successfully added in Approver Choices Setting!.</div>");
      	redirect(base_url().'app/recruitment_hris/index',$this->data);
	}

	public function ED13_action_appprover_choices($company_id,$code,$id,$action)
	{
		$actionn = $this->recruitment_hris_model->ED13_action_appprover_choices($company_id,$code,$id,$action);
		$this->session->set_flashdata('onload',"set_setting('".$company_id."','".$code."')");
		$this->session->set_flashdata('code',$code);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Approver choices ID - ".$id." for company id - ".$company_id." is successfully ".$action."d!.</div>");
      	
	}

	public function ED12_setting_no_approver($company_id,$code)
	{
		$action = $this->recruitment_hris_model->ED12_setting_no_approver($company_id,$code);
		$this->session->set_flashdata('onload',"set_setting('".$company_id."')");
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Maximum Number of Approver for company id - ".$company_id." is successfully updated!.</div>");
      	redirect(base_url().'app/recruitment_hris/index',$this->data);
	}

	public function S10_save_approvers($company_id,$code)
	{
		$insert = $this->recruitment_hris_model->S10_save_approvers($company_id,$code);
		$this->session->set_flashdata('onload',"set_setting('".$company_id."','".$code."')");
		$this->session->set_flashdata('code',$code);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Recruitment Approver Setting for company id - ".$company_id." is successfully Added!.</div>");
      	redirect(base_url().'app/recruitment_hris/index',$this->data);
	}

	public function action_setting10_action($action,$id,$company_id)
	{
		$actionn = $this->recruitment_hris_model->action_setting10_action($action,$id);
		$this->session->set_flashdata('onload',"set_setting('".$company_id."','ED10')");
		$this->session->set_flashdata('code','ED10');
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Recruitment Approver Setting for company id - ".$company_id." is successfully Added!.</div>");
      
	}

	function interview_process_updatesave($company_id,$id,$ft,$fd,$fc)
	{
		$this->data['company_id']=$company_id;		
		$interview_process_updatesave = $this->recruitment_hris_model->interview_process_updatesave($company_id,$id,$ft,$fd,$fc);
		if($interview_process_updatesave=='updated'){ $msg = "Interview Process  ID - ".$id." is Successfully Updated!"; }
		else { $msg = "No changes made in  Interview Process ID - ".$company_id." !"; }
		$this->data['details'] = $this->recruitment_hris_model->ED2_get_interview_process($company_id);
		$this->data['msg'] = $msg;
		$this->load->view('app/recruitment_maintenance/setting/setting_ED2_interview_process_view',$this->data);
	}

	public function ED16_email_save($company_id,$code)
	{
		$actionn = $this->recruitment_hris_model->action_setting16_action($company_id);
		$this->session->set_flashdata('onload',"set_setting('".$company_id."','".$code."')");
		$this->session->set_flashdata('code',$code);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Assign Employee and Email for Email Notification Setting for company id - ".$company_id." is successfully Updated!.</div>");
		redirect(base_url().'app/recruitment_hris/index',$this->data);
	}


	//questions
	public function setting_add_qualifying($company_id)
	{
		$this->data['company_id']=$company_id;
		$this->load->view('app/recruitment_maintenance/setting/setting_ED5_qualifying_add',$this->data);	
	}

	public function ED5_save_qualifying($company_id)
	{
		$insert = $this->recruitment_hris_model->save_qualifying($company_id);
		$this->session->set_flashdata('onload',"set_setting('".$company_id."','ED5')");
		$this->session->set_flashdata('code','ED5');
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Qualifying Question for company id - ".$company_id." is successfully Added!.</div>");
		redirect(base_url().'app/recruitment_hris/index',$this->data);
	}

	public function save_qualifying_questions($company,$action,$id,$question,$answer,$question_type)
	{
		$actions = $this->recruitment_hris_model->save_qualifying_questions($company,$action,$id,$question,$answer,$question_type);
		$this->session->set_flashdata('onload',"set_setting('".$company."','ED5')");
		$this->session->set_flashdata('question_type','qualifying');
		$this->session->set_flashdata('code','ED5');
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Qualifying Question for company id - ".$company_id." is successfully ".$action."d!.</div>");
	}

	public function setting_add_hypothetical($company_id,$type)
	{
		$this->data['company_id']=$company_id;
		$this->data['type']=$type;
		$this->load->view('app/recruitment_maintenance/setting/setting_ED5_hypothetical_add',$this->data);
	}

	public function ED5_save_hypothetical($company_id)
	{
		$insert = $this->recruitment_hris_model->save_hypothetical($company_id);
		$this->session->set_flashdata('onload',"set_setting('".$company_id."','ED5')");
		$this->session->set_flashdata('code','ED5');
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Hypothetical Question for company id - ".$company_id." is successfully Added!.</div>");
		redirect(base_url().'app/recruitment_hris/index',$this->data);
	}

	public function save_hypothetical_questions_company($company,$action,$id,$question,$question_type)
	{
		$action = $this->recruitment_hris_model->save_hypothetical_questions($company,$action,$id,$question,$question_type);
		$this->session->set_flashdata('onload',"set_setting('".$company."','ED5')");
		$this->session->set_flashdata('code','ED5');
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$question_type." Question for company id - ".$company." is successfully Added!.</div>");
	}

	public function setting_add_multiplechoices($company_id,$type,$id)
	{
		$this->data['id'] = $id;
		$this->data['company_id'] = $company_id;
		$this->data['question_type'] = $type;
		$this->data['code'] = 'ED5';
		$this->data['question'] = $this->recruitment_hris_model->ED5_get_multiple_choices_question($id);
		$this->data['choices'] = $this->recruitment_hris_model->ED5_get_multiple_choices($id);
		$this->load->view('app/recruitment_maintenance/setting/setting_ED5_multiplechoice_add',$this->data);
	}
	
	public function save_manage_questions_choices($company,$action,$question_id,$id,$choices,$question_type)
	{
		$this->data['id'] = $question_id;
		$this->data['company_id'] = $company;
		$this->data['question_type'] = $question_type;
		$this->data['code'] = 'ED5';
		$actions = $this->recruitment_hris_model->save_manage_questions_choices($company,$action,$question_id,$id,$choices,$question_type);
		$this->data['choices'] = $this->recruitment_hris_model->ED5_get_multiple_choices($question_id);
		$this->load->view('app/recruitment_maintenance/setting/setting_ED5_multiplechoice',$this->data);

	}
}	