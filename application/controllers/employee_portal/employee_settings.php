<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Employee_settings extends General {

	function __construct(){
		parent::__construct();	
		$this->load->model("employee_portal/employee_settings_model");
		$this->load->model("general_model");
		General::variable();
	}

	public function index()
	{
		$employee_id = $this->session->userdata('employee_id');
		$this->data['emp_details']=$this->employee_settings_model->employee_details($employee_id);
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/employee_settings/index', $this->data);
		$this->load->view('employee_portal/footer');		
	}

	public function account_settings()
	{
		$employee_id = $this->session->userdata('employee_id');
		$this->data['emp_settings']=$this->employee_settings_model->emp_settings($employee_id);
		$this->data['emp_details']=$this->employee_settings_model->employee_details($employee_id);
		$this->data['if_approver']=$this->employee_settings_model->if_approver($employee_id);
		$this->load->view('employee_portal/employee_settings/account_settings', $this->data);
	}

	public function save_account_settings($email,$account_display,$transaction_status,$notification_status,$request_approval,$request_update)
	{
		$employee_id = $this->session->userdata('employee_id');
		$save_account_settings=$this->employee_settings_model->save_account_settings($employee_id,$email,$account_display,$transaction_status,$notification_status,$request_approval,$request_update);
		$this->session->set_flashdata('updated',"Updated");
		$this->data['if_approver']=$this->employee_settings_model->if_approver($employee_id);
		$this->data['emp_settings']=$this->employee_settings_model->emp_settings($employee_id);
		$this->data['emp_details']=$this->employee_settings_model->employee_details($employee_id);
		$this->load->view('employee_portal/employee_settings/account_settings', $this->data);
	}

	//change password
	public function change_password()
	{
		$employee_id = $this->session->userdata('employee_id');
		$old_password = $this->employee_settings_model->get_password($employee_id);
		$this->data['password']=$old_password;
		$this->load->view('employee_portal/employee_settings/change_password', $this->data);
	}
	public function change_pass()
	{
		$this->form_validation->set_rules('current_password', 'Current Password', 'required');
		$this->form_validation->set_rules('new_password', 'New Password', 'required');
		$this->form_validation->set_rules('retype_password', 'Retype Password', 'required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_settings/index');
          	
        }
        else
        {

			if ($this->employee_settings_model->check_old_password())
			{
				if ($this->input->post('new_password') == $this->input->post('retype_password'))
				{
		        	$this->employee_settings_model->change_password();
					$this->session->set_flashdata('feedback', 'You have successfully changed your password');
					redirect('employee_portal/employee_settings/index');
					
				}
				else
				{				 
					$this->session->set_flashdata('error', "The passwords you entered did not match. Please try again.");
					redirect('employee_portal/employee_settings/index');
					
				}
			}
			else
			{
				 $this->session->set_flashdata('error', "The old password you entered did not match our records. Try again.");
				 redirect('employee_portal/employee_settings/index');
				 
			}
        }
	}

}