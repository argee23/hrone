<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Notification_approver extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("app/transaction_employees_model");
		$this->load->model("employee_portal/notification_approver_model");
		$this->load->model("app/issue_notifications_model");
		General::variable();
	}

	public function index()
	{
		$this->data["approvals"] = $this->notification_approver_model->get_pending_transactions();
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/notification_approver/index', $this->data);
		$this->load->view('employee_portal/footer');
	}
	public function approve_notification($doc_no,$company,$employee_id)
	{
		$array =  explode('_', $doc_no);
		$this->data['identification']=$array[0];
		$this->data['doc_no']=$doc_no;
		$this->data['employee_id']=$employee_id;
		$this->data['file']=$this->issue_notifications_model->get_employee_details($employee_id);
		$this->data['form_details']=$this->issue_notifications_model->get_notification_details($array[0]);
		$this->data['field_list']=$this->issue_notifications_model->get_notif_fields($this->data['form_details']->id);
		$this->data['doc_details']=$this->issue_notifications_model->get_doc_details($doc_no,$this->data['form_details']->t_table_name);
		$this->data['assign']=$this->issue_notifications_model->get_assign_to_fillup($doc_no,$this->data['form_details']->t_table_name."_assign");
		$this->data['approval_level']=$this->notification_approver_model->get_assign_to_fillup($doc_no,$this->session->userdata('employee_id'),$this->data['form_details']->t_table_name."_approval");
		$this->load->view('employee_portal/notification_approver/approve_notification_modal',$this->data);
	}
	public function respond_notification()
	{
		$doc_no			 	= 	$this->input->post('doc_no');
		$table 				= 	$this->input->post('table');
		$employee_id 		= 	$this->input->post('filer_id');
		$identification		=	$this->input->post('identification');
		$approval_level 	=	$this->input->post('approval_level');
		$approver_status 	= 	$this->input->post('approver_status');
		$comment 			= 	$this->input->post('comment');
		$form_details=$this->issue_notifications_model->get_notification_details($identification);
		$field_list=$this->issue_notifications_model->get_notif_fields($form_details->id);
		$assign=$this->issue_notifications_model->get_assign_to_fillup($doc_no,$form_details->t_table_name."_assign");
		
		$insert = $this->notification_approver_model->respond_notification($doc_no,$table,$employee_id,$identification,$approval_level,$approver_status,$comment,$form_details,$field_list,$assign,'one');

		$this->session->set_flashdata('feedback',"Notification status is successfully updated!");
		$check_notification = $this->general_model->check_approvers_notification($employee_id);
		if($check_notification=='true')
		{
			redirect(base_url().'employee_portal/notification_approver/index',$this->data);
		}
		else
		{
			redirect('/employee_portal/employee_dashboard/'); 
		}


	}

	public function mass_approval($table)
	{
		$this->data['table']=$table;
		$this->data["forms"] = $this->notification_approver_model->get_notif_by_table($table);
		$this->data["form_name"] = $this->notification_approver_model->get_notification_name($table);
		$this->data["field_list"]=$this->issue_notifications_model->get_notif_fields($this->data["form_name"]->id);
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/notification_approver/mass_approval',$this->data);
		$this->load->view('employee_portal/footer');
	}

	public function mass_respond_notification()
	{
		$table 				= 	$this->input->post('table_name');
		$identification		=	$this->input->post('identification');
		$employee_id = $this->session->userdata('employee_id');
		$forms 				= $this->notification_approver_model->get_forms($table);
		foreach($forms as $f)
		{
			$doc_details=$this->issue_notifications_model->get_doc_details($f->doc_no,$table);
			$form_details=$this->issue_notifications_model->get_notification_details($identification);
			$field_list=$this->issue_notifications_model->get_notif_fields($form_details->id);
			$assign=$this->issue_notifications_model->get_assign_to_fillup($f->doc_no,$table."_assign");

				$doc_no			 	= 	$f->doc_no;
				$employee_id 		= 	$doc_details->employee_id;
				$approval_level 	=	$f->approval_level;
				$approver_status 	= 	$this->input->post($f->doc_no.'_final_status');
				$comment 			= 	$this->input->post($f->doc_no.'_comment');	

			$insert = $this->notification_approver_model->respond_notification($f->doc_no,$table,$employee_id,$identification,$approval_level,$approver_status,$comment,$form_details,$field_list,$assign,'mass_approve');

		}
		$this->session->set_flashdata('feedback',"Notification status is successfully updated!");
		$check_notification = $this->general_model->check_approvers_notification($employee_id);
		if($check_notification=='true')
		{
			redirect(base_url().'employee_portal/notification_approver/index',$this->data);
		}
		else
		{
			redirect('/employee_portal/employee_dashboard/'); 
		}
		
	}

}