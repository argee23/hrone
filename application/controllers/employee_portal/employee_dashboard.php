<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Employee_dashboard extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/employee_dashboard_model");
		$this->load->model("employee_portal/section_management_model");
	}

	public function index()
	{
		$this->data['checker_company_policy']=$this->employee_dashboard_model->check_tracking_company_policy();
		$this->data['celebrants'] = $this->employee_dashboard_model->getCelebrantsOfTheWeek();
		$this->data['events'] = $this->employee_dashboard_model->getEventsForTheMonth();
		$this->data['announcement'] = $this->employee_dashboard_model->getAnnouncement(); // check if not exist
		$this->data['upcoming_seminars_trainings'] = $this->employee_dashboard_model->upcoming_seminars_trainings();
		$company_id = $this->session->userdata('company_id');
		$this->data['settings_st'] = $this->employee_dashboard_model->get_seminar_training_settings($company_id);
		$this->data['request_training'] = $this->employee_dashboard_model->check_if_with_requested_training();
		$this->data['for_interview'] = $this->employee_dashboard_model->check_applicants_for_interview();
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/dashboard', $this->data);
		$this->load->view('employee_portal/footer');		
	}	

	public function is_section_manager()
	{
		return $this->employee_dashboard_model->is_section_manager();
	}

	public function change_password_view()
	{
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/change_pass');
		$this->load->view('employee_portal/footer');	
	}

	public function change_pass()
	{
		$this->form_validation->set_rules('current_password', 'Current Password', 'required');
		$this->form_validation->set_rules('new_password', 'New Password', 'required');
		$this->form_validation->set_rules('retype_password', 'Retype Password', 'required');

		if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('employee_portal/employee_dashboard/change_password_view');
        }
        else
        {

			if ($this->employee_dashboard_model->check_old_password())
			{
				if ($this->input->post('new_password') == $this->input->post('retype_password'))
				{
		        	$this->employee_dashboard_model->change_password();
					$this->session->set_flashdata('feedback', 'You have successfully changed your password');
					redirect('employee_portal/employee_dashboard/');
				}
				else
				{				 

					 $this->session->set_flashdata('error', "The passwords you entered did not match. Please try again.");
					 redirect('employee_portal/employee_dashboard/change_password_view');

				}
			}
			else
			{
				 $this->session->set_flashdata('error', "The old password you entered did not match our records. Try again.");
				 redirect('employee_portal/employee_dashboard/change_password_view');
			}
        }
	}

	public function is_employee_exist(){
	
        	$q = $this->employee_dashboard_model->is_employee_exist();
        	if($q == 1){
        	 echo 'false';
        	}else{
        	 echo 'true';
        	}
        
	}

	public function save_feelings(){
	
        	$q = $this->employee_dashboard_model->save_feelings();
        	if($q){
        	 echo 'true';
        	}else{
        	 echo 'false';
        	}
        
	}
	public function send_greeting()
	{
		$this->form_validation->set_rules('message_content', 'Message', 'trim|required');

		if($this->form_validation->run() == FALSE)
        {
           	$this->session->set_flashdata('error', validation_errors());
        }
        else
        {
        	$this->employee_dashboard_model->send_greeting();
            $this->session->set_flashdata('feedback', 'You have successfully sent a birthday message!');
            redirect('employee_portal/employee_dashboard/#');
        }

	}

	public function send_reply()
	{
		$this->employee_dashboard_model->send_reply();
        $this->session->set_flashdata('feedback', 'You have successfully replied to a birthday message!');
        redirect('employee_portal/employee_dashboard/');
	}

	public function getMessage($message_id)
	{
		echo json_encode($this->employee_dashboard_model->get_message($message_id));
	}

	public function get_birthday_messages($employee_id)
	{
		echo json_encode($this->employee_dashboard_model->get_birthday_messages($employee_id));
	}

	public function getEvents()
	{
		echo json_encode($this->employee_dashboard_model->getEvents());
	}

	public function test()
	{
		echo var_dump($this->employee_dashboard_model->getEvents());
	}

}