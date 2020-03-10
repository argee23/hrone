<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Salary_approver extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/salary_approver_model");
		$this->load->model("app/transaction_employees_model");
		$this->load->model("app/issue_notifications_model");
		$this->load->model("employee_portal/notification_approver_model");
		$this->load->model("app/payroll_compensation_model");
		General::variable();
	}

	public function index()
	{
		$this->data['message'] = $this->session->flashdata('message');
		$employee_id = $this->session->userdata('employee_id');
		$this->data["approvals"] = $this->salary_approver_model->get_pending_approvers($employee_id);
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/salary_approver/index', $this->data);
		$this->load->view('employee_portal/footer');
	}
	public function salary_approver_view($salary_id,$employee_id)
	{

		$this->data['salary_details']=$this->salary_approver_model->get_salary_details($salary_id,$employee_id);
		$this->data['employee_details']=$this->salary_approver_model->get_employee_details($employee_id);
		$this->data['employee_id']=$employee_id;
		$this->load->view('employee_portal/salary_approver/salary_approver_view', $this->data);
	}
	public function approve_salary($id,$employee_id,$salary_id,$approver_id)
	{
		$this->data['approver_details']=array($id,$employee_id,$salary_id,$approver_id);
		$this->data['salary_details']=$this->salary_approver_model->get_salary_details($salary_id,$employee_id);
		$this->data['file']=$this->issue_notifications_model->get_employee_details($employee_id);
		$this->load->view('employee_portal/salary_approver/approve_salary_modal', $this->data);
	}
	public function respond_salary_approver($id,$salary_id,$approver_id)
	{
		$approver_status = $this->input->post('approver_status');
		$comment = $this->input->post('comment');
		$update_status = $this->salary_approver_model->respond_salary_approver($id,$salary_id,$approver_id,$approver_status,$comment);
		$this->session->set_flashdata('feedback',"Salary Information status is successfully ".$approver_status." !");

		$check_salary = $this->general_model->check_approvers_salary($approver_id);
		if($check_salary=='true'){ redirect(base_url().'employee_portal/salary_approver/index',$this->data);  } 
	 	else{ redirect('/employee_portal/employee_dashboard/');  }

		
	}
	public function mass_approval()
	{
		$employee_id =$this->session->userdata('employee_id');
		$this->data["approvals"] = $this->salary_approver_model->get_pending_approvers($employee_id);
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/salary_approver/mass_approval', $this->data);
		$this->load->view('employee_portal/footer');
	}
	public function mass_respond_salary()
	{
		$employee_id =$this->session->userdata('employee_id');
		$approvals= $this->salary_approver_model->get_pending_approvers($employee_id);
		$i=1;
		foreach($approvals as $ap)
		{
			$approver_status 	=  $this->input->post($i.'_final_status');
			$id 				=  $ap->id;
			$salary_id 			=  $ap->salary_info_id;
			$comment 			=  $this->input->post('comment'.$i);
			
			$update = $this->salary_approver_model->respond_salary_approver($id,$salary_id,$employee_id,$approver_status,$comment);
			$i++;
		}
		$this->session->set_flashdata('feedback',"Salary Information status is successfully updated!");
		
		$check_salary = $this->general_model->check_approvers_salary($employee_id);
		if($check_salary=='true'){ redirect(base_url().'employee_portal/salary_approver/index',$this->data);  } 
	 	else{ redirect('/employee_portal/employee_dashboard/');  }

	}

}