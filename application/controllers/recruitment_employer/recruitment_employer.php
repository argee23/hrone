<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'controllers/general.php'; 

class Recruitment_employer extends General {

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("general_model");
		$this->load->model("recruitment_employer/recruitment_employer_model");
		$this->load->model("recruitment_employer/recruitment_employer_management_model");
		$this->load->library("excel");
		General::variable();
	}	

	public function index(){	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->load->view('employer_index',$this->data);
	}

	public function get_cities(){
		$this->load->view('recruitment_employer/cities_list',$this->data);
	}
	public function validate_password(){

		$password = $this->input->post('password');
		$confirm_password = $this->input->post('confirm_password');

		if($password!=$confirm_password){
			$this->form_validation->set_message("validate_password","Password, Do not Match!");
			return false;
		}else{
			return true;
		}
	}

	public function validate_username(){

		$value = $this->input->post('email_address');

		if($this->recruitment_employer_model->validate_username()){
			$this->form_validation->set_message("validate_username","Username, <strong>".$value."</strong> already exist!");
			return false;
		}else{
			return true;
		}
	}

	public function register_employer(){

		$this->form_validation->set_rules("company_name","Company Name","trim|required");
		$this->form_validation->set_rules("confirm_password","Password","trim|callback_validate_password");
		$this->form_validation->set_rules("email_address","Username","trim|callback_validate_username");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){


						$config = array(
							'upload_path' => realpath('public/company_logo'),
							'allowed_types' => 'gif|jpg|png|PNG|GIF|JPG|JPEG|jpeg',
							'encrypt_name' => TRUE,
							'max_width' => 1920,
							'max_height' => 1080,
							'width' => 215,
							'height' => 215
							);

						$this->load->library('upload', $config);
						if($this->upload->do_upload('userfile'))
						{
							$data = $this->upload->data();
							$filename = $data['file_name'];
							// FOR IMAGE RESIZE
							$config['source_image'] = './public/company_logo/' .$filename;
							$this->load->library('image_lib', $config);
			 				$this->image_lib->resize(); 

						$this->data = array(
							'logo'						=> 	$filename,
							'company_name'				=> 	ucwords($this->input->post('company_name')),
							'company_contact_no'		=> 	ucwords($this->input->post('company_contact_no')),
							'company_address'			=> 	ucwords($this->input->post('brgy_street')).", ".$this->input->post('province')." ,".$this->input->post('city'),
							'TIN'						=> 	$this->input->post('company_tin'),
							'wDivision'					=> 	0,
							'is_this_recruitment_employer'					=> 	1,
							'employer_username'				=> 	$this->input->post('email_address'),
							'InActive'					=> 	0
						);	
						$this->db->insert('company_info',$this->data);

						
						$rec_employer_setting=$this->general_model->rec_employer_setting();
						$free_trial_months_can_post=$rec_employer_setting->free_trial_months_can_post;
						$free_trial_jobs_can_post=$rec_employer_setting->free_trial_jobs_can_post;

				
							$employer_id = $this->recruitment_employer_model->save_employer();
			
							// logfile			
							$value = $this->input->post('company_name');

							$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Company, <strong>".$value."</strong>, is Successfully Registered</div>");

							$this->data = $this->session->set_userdata(array(
								'employer_username'         	 				=>         $this->input->post('email_address'),
								'company_name'         	 						=>         $this->input->post('company_name'),
								'name_of_user'         	 						=>         $this->input->post('company_name'),
								'recruitment_employer_is_logged_in'      		=>          true,
								'employer_id'									=>			$employer_id
							)); 
							$this->data['companyInfo'] = $this->general_model->companyInfo();	
							//$this->data['rec_employer_setting']=$this->recruitment_employer_model->rec_employer_current_setting(); (remove depende dapt to sa setting)
							$this->data['myprofile'] = $this->recruitment_employer_model->myprofile();
							redirect(base_url().'recruitment_employer/recruitment_employer/goto_employer_profile',$this->data);
							
							}

						else{ 
							$value = $this->input->post('company_name');
						 $this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Company, <strong>".$value." company logo is invalid.</strong></div>");
						 	redirect(base_url().'recruitment_employer/recruitment_employer/index',$this->data);
							
						  }

		}
		else
		{
			
			 $this->index();
		}

	}


	public function validate_login(){
		$this->form_validation->set_rules("username","Username","trim|required|callback_validate_credentials");	
		$this->form_validation->set_rules("password","Password","trim|required");	
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		
		if($this->form_validation->run()){
			$current_logged=$this->recruitment_employer_model->get_current_logged();
			$cname=$current_logged->company_name;
				$this->data = $this->session->set_userdata(array(
					'employer_username'         	 				=>         $this->input->post('username'),
					'company_name'         	 						=>         $cname,
					'name_of_user'         	 						=>         $cname,
					'recruitment_employer_is_logged_in'      		=>          true,
					'employer_id'									=>			$current_logged->employer_id
				)); 
				$this->data['companyInfo'] = $this->general_model->companyInfo();	
				redirect(base_url().'recruitment_employer/recruitment_employer/goto_employer_profile',$this->data);
		}else{
			$this->index();
		}
	}
	public function validate_credentials(){
		if($this->recruitment_employer_model->validate_employer_credential()){
			return true;	
		}else{
			$this->form_validation->set_message("validate_credentials","Invalid Login Credentials");
			return false;
		}
	}
	


	public function goto_employer_profile(){

		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['rec_employer_bill_setting'] = $this->general_model->rec_employer_bill_setting();
		$this->data['rec_employer_setting'] = $this->recruitment_employer_model->rec_employer_current_setting();
		$this->data['myprofile'] = $this->recruitment_employer_model->myprofile();

		if($this->session->userdata('recruitment_employer_is_logged_in')){
				$company_id = $this->recruitment_employer_management_model->get_companyinfo($this->session->userdata('employer_username'));

				$this->data['view_modal']= $this->recruitment_employer_model->check_view_modal();
				$this->data['job_checker'] = $this->recruitment_employer_model->check_job_updates($company_id);
				$this->data['job_licensee'] = $this->recruitment_employer_model->check_active_license($company_id);
				$this->data['check_license_request'] = $this->recruitment_employer_model->check_pending_license_request($company_id);
				$this->data['applicant_interview_response'] = $this->recruitment_employer_model->check_applicant_interview_response($company_id);
				$this->data['unread_applications'] = $this->recruitment_employer_model->check_unread_applications($company_id);
				$this->data['applicant_reschedule_request'] = $this->recruitment_employer_model->check_applicant_reschedule_request($company_id);
				$this->data['recruitment_status_options'] = $this->recruitment_employer_model->recruitment_status_options($company_id);
				$this->data['unread_applicants'] = $this->recruitment_employer_model->recruitment_unread_applicants($company_id);
				$this->data['applicant_interview_response_today'] = $this->recruitment_employer_model->applicant_interview_response_today($company_id);
				$this->data['applicant_finalinterview_response_today'] = $this->recruitment_employer_model->applicant_finalinterview_response_today($company_id);
				$this->data['applicant_job_position_today'] = $this->recruitment_employer_model->applicant_job_position_today($company_id);
				$this->data['todays_applicants'] = $this->recruitment_employer_model->todays_applicants($company_id);

				$this->data['for_interview_applicants'] = $this->recruitment_employer_model->for_interview_applicants($company_id);


				$this->load->view('recruitment_employer/dashboard',$this->data);
		}else{
				$this->index();
		}

			
	}
	public function change_password(){
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		$this->load->view('recruitment_employer/change_pass',$this->data);
	}

	public function go_change_password(){
		$this->form_validation->set_rules("old_password","Old Password","trim|required");
		$this->form_validation->set_rules("new_password","New Password","trim|required");
		$this->form_validation->set_rules("retype_password","Retype Password","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$old_password=$this->input->post('old_password');
			$new_password=$this->input->post('new_password');
			$retype_password=$this->input->post('retype_password');
			
			if($new_password==$retype_password){
					$check_old_pass=$this->recruitment_employer_model->myprofile();
					$myoldpass=$check_old_pass->password;

					if($myoldpass==$old_password){

							$this->recruitment_employer_model->go_change_password($new_password);

							// logfile
							$value = $this->input->post('old_password')." to ".$this->input->post('new_password');
							General::logfile('Change Password','UPDATE',$value);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Password successfully changed</div>");

					}else{

			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Old Password Incorrect</div>");

					}

			}else{

			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> New Passwords do not match</div>");

			}

				$this->data['companyInfo'] = $this->general_model->companyInfo();	
			$this->data['onload'] = $this->session->flashdata('onload');
			$this->data['message'] = $this->session->flashdata('message');	
			$this->load->view('recruitment_employer/change_pass',$this->data);
		}else{
			$this->change_password();
		}	



	}

	//addded by mi

	public function check_email_exist()
	{	
		$emaill = $this->input->post('email');
		$checker = 	$this->recruitment_employer_model->check_email_exist($emaill);
		echo json_encode($checker);
	}

	//added by mi


	public function get_free_trial($company_id,$account)
	{
		$insert_details = $this->recruitment_employer_management_model->insert_license('free_trial',$company_id);
		
		$check_license = $this->recruitment_employer_management_model->check_free_trial_requirements();
		if($check_license=="Avail Upon Register")
		{
			
			$license_freetrial = "Thank you!. You can now use your recruitment free trial license";
		}
		else
		{
			$license_freetrial = "Request Sent, kindly complete all required requirements for the activation of your free trial license.";
		}
		$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$license_freetrial."</div>");

	}






	//updates in dashboard
	public function cancel_pending_request($company_id)
	{
		$cancelled = $this->recruitment_employer_model->cancel_pending_request($company_id);
		
		$this->data['message'] = $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Pending Request Successfully Cancelled.</div>");

	}








}


?>