<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'controllers/general.php'; 

class Forgot_password extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model('general_model');
		General::variable();
	}
	
	public function index(){
		$this->load->view("forgot_password");	
	}
	
	public function validate_email()
	{		
		$this->form_validation->set_rules('email_add', 'Email Address', 'required|valid_email');
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata("error","Please provide a valid email address.");
			$this->load->view('forgot_password');
		}
		else
		{
			
			$to_email = $this->input->post('email_add');
			$id = $this->general_model->validate_email($to_email); //check if the email address is owned by an applicant

			if (empty($id))
			{
				$this->session->set_flashdata("error","The email address you entered does not belong to any of the registered applicants.");
				$this->load->view('forgot_password');
			}
			else {
				
				$from_email = "sittie@serttech.com"; 
				$applicant_info = $this->general_model->get_applicant_credentials($id->id);

				$username = $applicant_info->applicant_id;
				$password = $applicant_info->myhris;

				$config = array(
				  'smtp_host' => '//smtp.readyhosting.com',
				  'smtp_port' => 587,
				  'smtp_user' => 'emailsender@hrweb.ph',
				  'smtp_pass' => 'Hrweb@2017',
				  'mailtype' => 'html',
				  'charset' => 'iso-8859-1',
				  'wordwrap' => TRUE
				);

				ini_set('SMTP', 'tls://smtp.readyhosting.com'); 
				ini_set('smtp_port', 587);
				ini_set('sendmail_from', 'emailsender@hrweb.ph');

        		$message = 'Your account is: Username: ' . $username . ' Password: '. $password;
        		$this->load->library('email', $config);
     	 		$this->email->set_newline("\r\n");
      			$this->email->from('emailsender@hrweb.ph');
      			$this->email->to($to_email);
      			$this->email->subject('Applicant Password Reset - ' . $applicant_info->company_name);
      			$this->email->message($message);
      				
      			if($this->email->send())
     			{
					$this->session->set_flashdata("error","The email address you entered does not belong to any of the registered applicants.");
					redirect(base_url().'login/index');
     			}
			    
			    else
			    {
			     show_error($this->email->print_debugger());
			    }
			}
		}
	}
}
