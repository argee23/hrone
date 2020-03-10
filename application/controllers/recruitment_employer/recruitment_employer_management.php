<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'controllers/general.php'; 

class Recruitment_employer_management extends General {

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("general_model");
		$this->load->model("recruitment_employer/recruitment_employer_model");
		$this->load->model("recruitment_employer/recruitment_employer_management_model");
		$this->load->model("app/recruitments_model");
		$this->load->model("serttech/serttech_recruitment_setting_model");
		$this->load->library("excel");
		$this->load->dbforge();	

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		General::variable();

	}	

	public function employer_settings($employer_type){	

		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['employer_type']=$employer_type;
		$this->data['settings']=$this->recruitment_employer_management_model->get_employer_default_settings($employer_type);
		$this->load->view('recruitment_employer/employer_settings',$this->data);
	}
	

	//employer settings
	public function employer_get_setting($type,$company_id,$account)
	{
		$this->data['account']=$account;
		if($account=='public')
		{
			$this->data['company_id']=$company_id;
		}
		else
		{
			$this->data['company_id']='by_company';
		}
		
		if($type=='ED1')
		{	

			$this->data['details']=$this->recruitment_employer_management_model->get_employer_email_host($type,$company_id,$account);
		}
		elseif($type=='ED2')
		{
			$this->data['details']=$this->recruitment_employer_management_model->get_applicant_status_option($type,$company_id,$account);
		}
		elseif($type=='ED5')
		{
			$this->data['details']=$this->recruitment_employer_management_model->get_employer_settings_questions($type,$company_id,$account,'qualifying');
		}
		elseif($type=='ED6')
		{
			$this->data['details']=$this->recruitment_employer_management_model->get_employer_job_requirements($type,$company_id,$account);
		}
		else if ($type=='ED7')
		{
			$this->data['req']=$this->recruitment_employer_management_model->get_employer_job_requirements_active($type,$company_id,$account);
 			$this->data['details']=$this->recruitment_employer_management_model->get_employer_job_position($type,$company_id,$account);
		}
		$this->data['type']=$type;
		$this->data['settings']=$this->recruitment_employer_management_model->get_setting_details($type);
		$this->load->view('recruitment_employer/employer_settings_by_type',$this->data);
	}

	
	//email settings

	public function save_email_setting($type,$action,$id,$host,$port,$username,$password,$send_mail_from,$typp,$security_type,$account,$company_id)
	{
		$this->data['account']=$account;
		$this->data['company_id']=$company_id;
		$this->data['type']=$type;
		$action = $this->recruitment_employer_management_model->save_email_setting($type,$action,$id,$host,$port,$username,$password,$send_mail_from,$typp,$security_type,$account,$company_id);
		$this->data['details']=$this->recruitment_employer_management_model->get_employer_email_host($type,$company_id,$account);
		$this->data['settings']=$this->recruitment_employer_management_model->get_setting_details($type);
		if($account=='public')
		{
			$this->load->view('recruitment_employer/employer_settings_by_type',$this->data);
		}
		else
		{
			$this->load->view('recruitment_employer/employer_settings_by_type_company',$this->data);
		}
		
	}

	//end email settings

	//single field data saving

	public function save_single_field_data($type,$format,$account,$company,$data,$action,$id)
	{
		$this->data['type']=$type;
		$this->data['account']=$account;
		$this->data['company_id']=$company;
		$action = $this->recruitment_employer_management_model->save_single_field_data($type,$format,$account,$company,$data,$action,$id);
		$this->data['settings']=$this->recruitment_employer_management_model->get_setting_details($type);
		if($account=='public')
		{
			$this->load->view('recruitment_employer/employer_settings_by_type',$this->data);
		}
		else
		{
			$this->load->view('recruitment_employer/employer_settings_by_type_company',$this->data);
		}
		
	}

	//end of single data saving


	//start of job requirements

	public function  save_job_requirements($type,$account,$company,$action,$id,$uploadable,$title)
	{
		$this->data['type']=$type;
		$this->data['account']=$account;
		$this->data['company_id']=$company;
		$action = $this->recruitment_employer_management_model->save_job_requirements($type,$account,$company,$action,$id,$uploadable,$title);
		$this->data['details']=$this->recruitment_employer_management_model->get_employer_job_requirements($type,$company,$account);
		$this->data['settings']=$this->recruitment_employer_management_model->get_setting_details($type);
		if($account=='public')
		{
			$this->load->view('recruitment_employer/employer_settings_by_type',$this->data);
		}
		else
		{
			$this->load->view('recruitment_employer/employer_settings_by_type_company',$this->data);
		}
	
	}

	//end of job requirements


	//start of adding qualifying jobs

	public function save_qualifying_questions($type,$account,$company,$action,$id,$question,$answer,$question_type)
	{
		$this->data['questions']=$question_type;
		$this->data['type']=$type;
		$this->data['account']=$account;
		$this->data['company_id']=$company;
		$action = $this->recruitment_employer_management_model->save_qualifying_questions($type,$account,$company,$action,$id,$question,$answer,$question_type);
		$this->data['details']=$this->recruitment_employer_management_model->get_employer_settings_questions($type,$company,$account,$question_type);
		if($account=='public')
		{ 
			$this->load->view('recruitment_employer/employer_settings_questions',$this->data);
		}
		else
		{

			$this->load->view('recruitment_employer/employer_settings_questions_company',$this->data);
		}
		
	}

	//end of qualifying jobs


	//start of hypothetical

	public function save_hypothetical_questions($type,$account,$company,$action,$id,$question,$question_type)
	{ 

		$this->data['questions']=$question_type;
		$this->data['type']=$type;
		$this->data['account']=$account;
		$this->data['company_id']=$company;
		$action = $this->recruitment_employer_management_model->save_hypothetical_questions($type,$account,$company,$action,$id,$question,$question_type);
		$this->data['details']=$this->recruitment_employer_management_model->get_employer_settings_questions($type,$company,$account,$question_type);
		$this->load->view('recruitment_employer/employer_settings_questions',$this->data);

		
		
	}

	//end of hypothetical

	//multiple choices question


	public function manage_questions_choices($type,$account,$company,$action,$id)
	{
		$this->data['questions']='multiple_choice';
		$this->data['type']=$type;
		$this->data['account']=$account;
		$this->data['company_id']=$company;
		$this->data['id']=$id;
		$this->data['questions_details']=$this->recruitment_employer_management_model->questions_details_mutiplechoices($id);
		$this->load->view('recruitment_employer/employer_manage_questions_choices',$this->data);
	}

	public function save_manage_questions_choices($type,$account,$company,$action,$question_id,$id,$choices,$question_type)
	{

		$this->data['questions']='multiple_choice';
		$this->data['type']=$type;
		$this->data['account']=$account;
		$this->data['company_id']=$company;
		$this->data['id']=$question_id;
		$action = $this->recruitment_employer_management_model->save_manage_questions_choices($type,$account,$company,$action,$question_id,$id,$choices,$question_type);
		$this->data['questions_details']=$this->recruitment_employer_management_model->questions_details_mutiplechoices($question_id);
		$this->load->view('recruitment_employer/employer_manage_questions_choices',$this->data);

	}
	//end of multiple choices

	//for manage job position


	public function save_company_position($type,$account,$company,$action,$id,$position,$req_id,$preq_id)
	{
		$this->data['questions']='multiple_choice';
		$this->data['type']=$type;
		$this->data['account']=$account;
		$this->data['company_id']=$company;
		$action = $this->recruitment_employer_management_model->save_company_position($type,$account,$company,$action,$id,$position,$req_id,$preq_id);
		$this->data['details'] = $this->recruitment_employer_management_model->get_employer_job_position($type,$company,$account);
		$this->data['req']=$this->recruitment_employer_management_model->get_employer_job_requirements_active($type,$company,$account);
		$this->data['settings']=$this->recruitment_employer_management_model->get_setting_details($type);
		if($account=='public'){
			$this->load->view('recruitment_employer/employer_settings_by_type',$this->data);
		}
		else{
			$this->load->view('recruitment_employer/employer_settings_by_type_company',$this->data);
		}
		
	}
	//end manage of position

	public function get_free_trial($company_id,$account)
	{
		$insert_details = $this->recruitment_employer_management_model->insert_license('free_trial',$company_id);
		
		$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Request Sent, kindly complete all required requirements for the activation of your free triallicense.</div>");

			

			// $check_free_trial_requirements = $this->recruitment_employer_management_model->check_free_trial_requirements();
			// if(empty($check_free_trial_requirements))
			// {
				
			// 	$insert_details = $this->recruitment_employer_management_model->insert_license('without','free_trial',$company_id);
			// }
			// else
			// {
				
			// 	$data = $check_free_trial_requirements;
			// 	if($data == 'Avail Upon Register')
			// 	{  
			// 		$insert_details = $this->recruitment_employer_management_model->insert_license('without','free_trial',$company_id); 
			// 	}
			//     else
			//     {
			    	
			//     	$insert_details = $this->recruitment_employer_management_model->insert_license('with','free_trial',$company_id);
			//     }
			// }

	}

	public function get_requirement_status($company_id,$employer_id,$req_id,$type)
	{ 
		$this->data['type']=$type;
		$this->data['employer_id']=$employer_id;
		$this->data['company_id']=$company_id;
		$this->data['details'] = $this->recruitment_employer_management_model->get_requirement_status($company_id,$employer_id,$req_id,$type);
		$this->load->view('recruitment_employer/employer_requirement_status',$this->data);
	}

	public function get_package_details($company_id,$employer_id)
	{
		$this->data['employer_id']=$employer_id;
		$this->data['company_id']=$company_id;
		$this->data['details'] = $this->recruitment_employer_management_model->get_package_details();
		$this->load->view('recruitment_employer/employer_package_list',$this->data);
	}

	public function download_requirement($file)
	{

        $this->load->helper('download'); 
		$path    =   file_get_contents(base_url()."public/recruitment_requirements/".$file."");
		$name    =   $filename;
		force_download($name, $path); 

		$value = $name;
	}

	public function upload_requirements()
	{
			
        
	}

	public function get_package_subscription($company_id,$employer_id,$id,$account)
	{
		$action = $this->recruitment_employer_management_model->get_package_subscription($company_id,$employer_id,$id,$account);
		$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Thank you for subscribing!. . Sert technology will receive your request and will notify you for the license activation.</div>");
	}



	//job vacancy access

	public function job_vacancy_index()
	{
		$this->data['employer_type']='public';
		$company = $this->recruitment_employer_management_model->get_companyinfo($this->session->userdata('employer_username'));
		$this->data['company'] = $company;
		$this->data['company_name'] = $this->recruitment_employer_management_model->get_companydetails($this->session->userdata('employer_username'));
		$this->data['job_vacancy_list']=$this->recruitments_model->job_vacancy_list($company,$this->session->userdata('employer_id'));
		$this->load->view('app/recruitments/job_vacancy/jobs_index',$this->data);	
	}

//start of employer history

public function get_employer_history($action,$company)
{
	$this->data['action']=$action;
	$this->data['company']=$company;
	$this->data['history'] = $this->recruitment_employer_management_model->get_employer_history($action,$company);
 	$this->load->view('recruitment_employer/employer_history',$this->data);
}
//end of employer history
	

//active license details

public function get_active_license($type,$company,$id)
{
	$this->data['type']=$type;
	$this->data['company']=$company;
	$this->data['details'] = $this->recruitment_employer_management_model->get_active_details($company,$id);
	$this->data['license'] = $this->recruitment_employer_management_model->get_active_license($type,$company,$id);
 	$this->load->view('recruitment_employer/employer_active_license',$this->data);
}

//end of active license

//for pending requirements
	
public function get_package_pending_requirements($company_id,$employer_id,$req_id,$type)
{
	$this->data['message'] = $this->session->flashdata('message');	
	$this->data['type']=$type;
	$this->data['employer_id']=$employer_id;
	$this->data['company_id']=$company_id;
	$this->data['req_id']=$req_id;
	$this->data['details'] = $this->recruitment_employer_management_model->get_requirement_status($company_id,$employer_id,$req_id,$type);
	$this->load->view('recruitment_employer/employer_requirement_status',$this->data);
}

public function employer_upload_requirements($company_id,$employer_id,$req_id,$id,$type,$requirement_id)
{
	$this->data['type']=$type;
	$this->data['employer_id']=$employer_id;
	$this->data['company_id']=$company_id;
	$this->data['req_id']=$req_id;
	$this->data['requirement_id']=$requirement_id;
	$this->data['id']=$id;
	$this->data['details'] = $this->recruitment_employer_management_model->get_requirement_details($requirement_id);
	$this->load->view('recruitment_employer/employer_requirement_modal',$this->data);
}
public function employer_requirement_save()
{
	$id = $this->input->post('id');
	$req_id = $this->input->post('req_id');
	$company_id = $this->input->post('company_id');
	$employer_id = $this->session->userdata('employer_id');
	$type = $this->input->post('type');
	$requirement_id = $this->input->post('requirement_id');

	$picture 			= '';
	$error 				= false;
		if(!empty($_FILES['file']['name'])){
				
                $config['upload_path'] 		= './public/recruitment_requirements/';
                $config['allowed_types'] 	= 'jpg|jpeg|png|gif|pdf|xls|xlsx|docx|txt|doc|ppt|pptx';
			    $currentDateTime 			= date('Ymd_His');
			    $config['file_name'] 		= $id.'_'.$currentDateTime;//$_FILES['file']['name'];
                $fileName 					= $config['file_name'];//$_FILES['file']['name'];
                
                $this->load->library('upload',$config);
                $this->upload->initialize($config);

                $file_size = $_FILES['file']['size'];
                echo 'sdds'.$file_size;


			    if ($file_size > 2500000000){      
			    	$error = true;
			    }
			    else{
	                if($this->upload->do_upload('file')){
	                    $uploadData = $this->upload->data();
	                    $picture = $uploadData['file_name'];
	                }
	            }
        }
        


    	if($error == false){
    		$this->db->where('req_id',$req_id);
    		$this->db->update('recruitment_employers_req_list',array('file'=>$picture));
    		
			$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Requirement successfully uploaded.</div>");

    	}
    	else{
    		
    		$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> ERROR: Something is wrong with uploaded FILE.</div>");

    	}	
    	redirect(base_url().'recruitment_employer/recruitment_employer/goto_employer_profile');

}
//end


//start of by company settings

public function by_company_status($company,$type,$account)
{

	$this->data['type']=$type;
	$this->data['account']=$account;
	$this->data['company_id']=$company;
	if($type=='ED2')
	{
		$this->data['details']=$this->recruitment_employer_management_model->get_applicant_status_option($type,$company,$account);
	}
	else if($type=='ED6')
	{
		$this->data['details']=$this->recruitment_employer_management_model->get_employer_job_requirements($type,$company,$account);
	}
	else if($type=='ED7')
	{
		$this->data['req']=$this->recruitment_employer_management_model->get_employer_job_requirements_active($type,$company,$account);
 		$this->data['details']=$this->recruitment_employer_management_model->get_employer_job_position($type,$company,$account);
	}
	else if($type=='ED1')
	{
		$this->data['details']=$this->recruitment_employer_management_model->get_employer_email_host($type,$company,$account);
	}
	$this->data['settings']=$this->recruitment_employer_management_model->get_setting_details($type);
	$this->load->view('recruitment_employer/employer_settings_by_type_company',$this->data);
}

public function by_company_questions($company,$type,$account,$question_type)
{
	$this->data['questions']=$question_type;
	$this->data['type']=$type;
	$this->data['account']=$account;
	$this->data['company_id']=$company;
	$this->data['details']=$this->recruitment_employer_management_model->get_employer_settings_questions($type,$company,$account,$question_type);
	$this->load->view('recruitment_employer/employer_settings_questions_company',$this->data);


}

public function save_hypothetical_questions_company($type,$account,$company,$action,$id,$question,$question_type)
	{ 

		$this->data['questions']=$question_type;
		$this->data['type']=$type;
		$this->data['account']=$account;
		$this->data['company_id']=$company;
		$action = $this->recruitment_employer_management_model->save_hypothetical_questions($type,$account,$company,$action,$id,$question,$question_type);
		$this->data['details']=$this->recruitment_employer_management_model->get_employer_settings_questions($type,$company,$account,$question_type);
		$this->load->view('recruitment_employer/employer_settings_questions_company',$this->data);

		
		
	}





public function by_company_status_ED8($company,$type,$account)
{

	$this->data['type']=$type;
	$this->data['account']=$account;
	$this->data['company_id']=$company;
	$this->data['details'] = $this->recruitment_employer_management_model->get_company_status_ED8_result($company,$type);
	$this->data['settings']=$this->recruitment_employer_management_model->get_setting_details($type);
	$this->load->view('recruitment_employer/employer_settings_by_type_company_ED8',$this->data);
}
public function save_ed8_settings($company_id,$type)
{
	$content = $this->input->post('content');
	$insert = $this->recruitment_employer_management_model->save_ed8_settings($company_id,$content,$type);
}
//end of by company settings





























	//new status option actions
	public function add_new_status_modal($type,$account,$company_id)
	{
		$this->data['type']=$type;
		$this->data['account']=$account;
		$this->data['company_id']=$company_id;
		$this->load->view('recruitment_employer/add_new_status_modal',$this->data);
	}

	public function save_new_status_position($company_id,$type,$account)
	{
		$title = $this->input->post('title');
		$description = $this->input->post('description');
		$color = $this->input->post('color');
		$save_new_status_position = $this->recruitment_employer_management_model->save_new_status_position($company_id,$type,$account,$title,$description,$color);
		if($save_new_status_position=='inserted')
		{
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Application Status for company id - ".$company_id." is successfully added!.</div>");
        
		}
		else
		{
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error!</div>");
        	
		}
			
       	if($account=='hris')
       	{
       		$this->session->set_flashdata('onload',"get_setting('".$type."','by_company','".$account."')");
       	}
       	else
       	{
       		$this->session->set_flashdata('onload',"get_setting('".$type."','".$company_id."','".$account."');");
			
       	}
		
			
		redirect('recruitment_employer/recruitment_employer_management/employer_settings/'.$account,$this->data);
		
	}

	public function employer_status_action($type,$account,$action,$id,$title,$description,$color,$company_id)
	{
		$this->data['type']=$type;
		$this->data['account']=$account;
		$this->data['company_id']=$company_id;
		$actionn = $this->recruitment_employer_management_model->employer_status_action($type,$account,$action,$id,$title,$description,$color,$company_id);
		$this->data['details']=$this->recruitment_employer_management_model->get_applicant_status_option($type,$company_id,$account);
		$this->data['settings']=$this->recruitment_employer_management_model->get_setting_details($type);
		
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Application Status for company id - ".$company_id." is successfully ".$action."d!.</div>");
        
       	if($account=='hris')
       	{
       		$this->session->set_flashdata('onload',"get_setting('".$type."','by_company','".$account."')");
       	}
       	else
       	{
       		$this->session->set_flashdata('onload',"get_setting('".$type."','".$company_id."','".$account."');");
			
       	}
		
		
	}

	//status numbering

	public function employer_status_numbering($type,$account,$company_id,$value_numbering,$value_id,$count,$checking_type)
	{

		$this->data['type']=$type;
		$this->data['account']=$account;
		$this->data['company_id']=$company_id;
		$action = $this->recruitment_employer_management_model->save_updated_numbering($type,$account,$company_id,$value_numbering,$value_id,$count,$checking_type);
		$this->data['details']=$this->recruitment_employer_management_model->get_applicant_status_option($type,$company_id,$account);
		$this->data['settings']=$this->recruitment_employer_management_model->get_setting_details($type);
		
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Application Status Numbering for company id - ".$company_id." is successfully updated!.</div>");
        
       	if($account=='hris')
       	{
       		$this->session->set_flashdata('onload',"get_setting('".$type."','by_company','".$account."')");
       	}
       	else
       	{
       		$this->session->set_flashdata('onload',"get_setting('".$type."','".$company_id."','".$account."');");
			
       	}

	}

	//adding interview process

	public function manage_interviewprocess_modal($type,$account,$company_id,$id)
	{
		$this->data['type']=$type;
		$this->data['account']=$account;
		$this->data['company_id']=$company_id;
		$this->data['company_name'] = $this->recruitment_employer_management_model->get_company_name($company_id);
		$this->data['details'] = $this->recruitment_employer_management_model->get_interview_process($company_id);
		$this->load->view('recruitment_employer/manage_interviewprocess_modal',$this->data);
	}

	public function save_interview_process($title,$description,$color,$company_id,$type,$account)
	{
		$this->data['company_id']=$company_id;
		$this->data['account'] =$account;
		$this->data['type'] = $type;
		$insert = $this->recruitment_employer_management_model->save_interview_process($title,$description,$color,$company_id,$type,$account);
		$this->data['details'] = $this->recruitment_employer_management_model->get_interview_process($company_id);
		$this->data['msg'] = "Interview Process for Company ID - ".$company_id." is Successfully Added!";
	
		$this->load->view('recruitment_employer/interview_process_view',$this->data);
	}

	public function interview_process_action($company_id,$id,$action,$account)
	{
		$this->data['company_id']=$company_id;
		$this->data['account'] =$account;
		$interview_process_action = $this->recruitment_employer_management_model->interview_process_action($company_id,$id,$action,$account);
		$this->data['details'] = $this->recruitment_employer_management_model->get_interview_process($company_id);
		$this->data['msg'] = "Interview Process for Company ID - ".$company_id." is Successfully ".$action."d!";
		$this->load->view('recruitment_employer/interview_process_view',$this->data);
	}	

	function interview_process_updatesave($company_id,$id,$ft,$fd,$fc,$account)
	{
		$this->data['company_id']=$company_id;
		$this->data['account'] =$account;
		$interview_process_updatesave = $this->recruitment_employer_management_model->interview_process_updatesave($company_id,$id,$ft,$fd,$fc,$account);
		$this->data['details']  = $this->recruitment_employer_management_model->get_interview_process($company_id);
		if($interview_process_updatesave=='updated'){ $msg = "Interview Process  ID - ".$id." is Successfully Updated!"; }
		else { $msg = "No changes made in  Interview Process ID - ".$company_id." !"; }
		$this->data['msg'] = $msg;
		$this->load->view('recruitment_employer/interview_process_view',$this->data);
	}

	function save_update_interview_process($count,$company_id,$value_numbering,$value_id,$account)
	{
		$this->data['company_id']=$company_id;
		$this->data['account'] =$account;
		$update = $this->recruitment_employer_management_model->save_update_interview_process($count,$company_id,$value_numbering,$value_id,$account);
		$this->data['details']  = $this->recruitment_employer_management_model->get_interview_process($company_id);
		$this->data['msg'] = "Interview Process  Numbering for company id - ".$company_id." is Successfully Updated!"; 
		$this->load->view('recruitment_employer/interview_process_view',$this->data);
	}



}


?>