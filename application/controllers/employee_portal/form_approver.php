<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Form_approver extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("app/transaction_employees_model");
		$this->load->model("employee_portal/form_approver_model");
		$this->load->model("employee_portal/employee_transactions_model");
		$this->load->model("employee_portal/employee_dashboard_model");
		$this->load->model("employee_portal/section_management_model");
		$this->load->model("employee_portal/employee_email_model");
		General::variable();
	}

	public function index()
	{
		$this->data["approvals"] = $this->form_approver_model->get_pending_transactions();
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/form_approver/index', $this->data);
		$this->load->view('employee_portal/footer');		
	}	

	public function get_form_details($document_no, $table_name)
	{ 
		$data = $this->form_approver_model->get_form_details($document_no, $table_name);
		echo json_encode($data);
	}

	public function mass_approval($table, $user_defined=0)
	{
		$this->data["forms"] = $this->form_approver_model->get_forms_by_table($table);
		$this->data["form_name"] = $this->form_approver_model->get_form_name($table);
		$this->load->view('employee_portal/header');	

		if($user_defined == 1)
		{
			$this->load->view('employee_portal/form_approver/mass_approval/user_defined', $this->data);
		}
		else
		{
			$this->load->view('employee_portal/form_approver/mass_approval/' . $table, $this->data);
		}
		
		
		$this->load->view('employee_portal/footer');	
	}


	public function respond()
	{
		$this->form_approver_model->respond();
		$doc_no = $this->input->post('doc_no');
		$status = $this->input->post('status');
		$this->session->set_flashdata('feedback', 'Document ' .  $doc_no . ' is succesfully ' . $status . '.');
	 	$employee_id = $this->session->userdata('employee_id');
	 	$check_notification_transaction = $this->general_model->check_approvers_transaction($employee_id);

	 	if($check_notification_transaction=='true'){ $this->index(); } 
	 	else{ redirect('/employee_portal/employee_dashboard/');  }

	}

	public function mass_respond()
	{
		$table_name = $this->input->post('table_name');
		$identification = $this->input->post('identification');
		$forms = $this->form_approver_model->get_forms($table_name);

		$msg = "";
		foreach ($forms as $form) {
			if (!empty($this->input->post($form->doc_no . "_status")))
			{

				$status = $this->input->post($form->doc_no . "_status");
				$doc_no = $this->input->post($form->doc_no . "_doc_no");
				$comment = $this->input->post($form->doc_no . "_comment");
				$filer_id = $this->input->post($form->doc_no . "_filer_id");
				$company_id = $this->input->post($form->doc_no . "_company_id");

				$this->form_approver_model->mass_response($company_id,$status, $table_name, $doc_no, $comment, $filer_id, $identification);
				$msg = $msg . "" . $doc_no . " is succesfully " . $status . " <br>"; 
			}
		}

		$this->session->set_flashdata('feedback', $msg);
		
		$employee_id = $this->session->userdata('employee_id');
	 	$check_notification_transaction = $this->general_model->check_approvers_transaction($employee_id);
	 	if($check_notification_transaction=='true'){ $this->index(); } 
	 	else{ redirect('/employee_portal/employee_dashboard/');  }
	 	
		
	}

	public function apply_transaction_settings($transactionlist)
	{
		$this->form_approver_model->apply_transaction_settings();
	}

	public function view($doc_no, $table_name,$identification)
	{
		$doc=$doc_no;
		$t_table_name=$table_name;
		$this->data["companyInfo"] = $this->form_approver_model->get_company_info();
		if($t_table_name=="employee_leave"){

		$this->data['file'] = $this->transaction_employees_model->form_view_emp_leave($doc);			
		$this->load->view('app/transaction/form_view_employee_leave',$this->data);
		}
		else if($t_table_name=="emp_change_sched"){
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_change_sched($doc);			
		$this->load->view('app/transaction/form_view_emp_change_sched',$this->data);
		}
		else if($t_table_name=="emp_time_complaint"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_time_comp($doc);			
		$this->load->view('app/transaction/form_view_emp_time_comp',$this->data);	
		}
		else if($t_table_name=="emp_change_rest_day"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_change_rest_day($doc);			
		$this->load->view('app/transaction/form_view_emp_change_rest_day',$this->data);	
		}
		else if($t_table_name=="employee_leave_cancel"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_cancel_leave($doc);			
		$this->load->view('app/transaction/form_view_emp_cancel_leave',$this->data);	
		}
		else if($t_table_name=="emp_under_time"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_under_time($doc);			
		$this->load->view('app/transaction/form_view_emp_under_time',$this->data);	
		}
		else if($t_table_name=="emp_atro"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_atro($doc);			
		$this->load->view('app/transaction/form_view_emp_atro',$this->data);	
		}
		else if($t_table_name=="emp_official_business"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_off_business($doc);			
		$this->load->view('app/transaction/form_view_off_business',$this->data);	
		}
		else if($t_table_name=="emp_loans"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_loans($doc);			
		$this->load->view('app/transaction/form_view_emp_loans',$this->data);	
		}
		else if($t_table_name=="emp_trip_ticket"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_trip_ticket($doc);			
		$this->load->view('app/transaction/form_view_emp_trip_ticket',$this->data);	
		}
		else if($t_table_name=="emp_gate_pass"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_gate_pass($doc);			
		$this->load->view('app/transaction/form_view_emp_gate_pass',$this->data);	
		}
		else if($t_table_name=="emp_sworn_declaration"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_sworn_dec($doc);			
		$this->load->view('app/transaction/form_view_emp_sworn_dec',$this->data);	
		}
		else if($t_table_name=="emp_authority_to_deduct"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_authority_to_deduct($doc);			
		$this->load->view('app/transaction/form_view_emp_authority_to_deduct',$this->data);	
		}
		else if($t_table_name=="emp_grievance_request"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_grievance_req($doc);			
		$this->load->view('app/transaction/form_view_emp_grievance_req',$this->data);	
		}
		else if($t_table_name=="emp_grocery_items_loan"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_grocery_loan($doc);			
		$this->load->view('app/transaction/form_view_emp_grocery_loan',$this->data);	
		}
		else if($t_table_name=="emp_bap_claim"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_bap_claim($doc);			
		$this->load->view('app/transaction/form_view_emp_bap_claim',$this->data);	
		}
		else if($t_table_name=="emp_call_out"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_call_out($doc);			
		$this->load->view('app/transaction/form_view_emp_call_out',$this->data);	
		}
		else if($t_table_name=="emp_request_form"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_request_form($doc);			
		$this->load->view('app/transaction/form_view_emp_request_form',$this->data);	
		}
		else if($t_table_name=="emp_paternity_notif"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_paternity_notif($doc);			
		$this->load->view('app/transaction/form_view_emp_paternity_notif',$this->data);	
		}
		else if($t_table_name=="emp_payroll_complaint"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_payroll_comp($doc);			
		$this->load->view('app/transaction/form_view_emp_payroll_comp',$this->data);	
		}
		else if($t_table_name=="emp_medicine_reimburse"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_medicine_reimburse($doc);			
		$this->load->view('app/transaction/form_view_emp_medicine_reimburse',$this->data);	
		}
		else if($t_table_name=="emp_hdmf_cancellation"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_hdmf_cancel($doc);			
		$this->load->view('app/transaction/form_view_emp_hdmf_cancel',$this->data);	
		}
		else if($t_table_name=="emp_sss_cancellation"){	
		$this->data['file'] = $this->transaction_employees_model->form_view_emp_sss_cancel($doc);			
		$this->load->view('app/transaction/form_view_emp_sss_cancel',$this->data);	
		}
	}

	public function test()
	{
		echo var_dump($this->form_approver_model->getInfo('521'));
	}

	public function get_request_list($id)
	{
		echo $id;
	}

	public function mass_approval_atro($table, $user_defined=0,$type)
	{
		$this->data["forms"] = $this->form_approver_model->get_forms_by_table_atro($table,$type);
		$this->data["form_name"] = $this->form_approver_model->get_form_name($table);
		$this->load->view('employee_portal/header');	

		if ($user_defined == 1)
		{
			$this->load->view('employee_portal/form_approver/mass_approval/user_defined', $this->data);
		}
		else
		{
			$this->load->view('employee_portal/form_approver/mass_approval/' . $table, $this->data);
		}
		
		$this->load->view('employee_portal/footer');
	}
	
}