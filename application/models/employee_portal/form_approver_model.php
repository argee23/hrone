<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Form_approver_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
		$this->load->model("employee_portal/employee_email_model");
	}


	public function get_pending_transactions()
	{
		$transactions = $this->get_transaction_list();

		foreach ($transactions as $tran) {

			$forms = $this->get_transactions_by_table($tran->t_table_name);

			foreach ($forms as $form) {
				
				$form_info 	= $this->get_form_info($tran->t_table_name, $form->doc_no);
				$filer_info = $this->get_filer_info($form_info->employee_id);

				$form->form_info = $form_info;
				$form->filer_info = $filer_info;
			} //End for each form

			$tran->forms = $forms;
			
		} //End for each transaction

		return $transactions;
	}

	public function get_form_info($table_name, $doc_no)
	{
		$this->db->select('employee_id, doc_no, date_created');
		$this->db->where('doc_no', $doc_no);
		$query = $this->db->get($table_name, 1);
		return $query->row();
	}

	public function get_filer_info($employee_id)
	{
		$this->db->select('employee_id, first_name, middle_name,  last_name');
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('basic_info_view', 1);
		return $query->row();
	}

	public function get_transactions_by_table($table_name)
	{
		$table = $table_name . "_approval";
		
			$this->db->select('doc_no');
		$this->db->where(array(
			'approver_id'				=>				$this->session->userdata('employee_id'),
			'status'					=>				'pending',
			'status_view'					=>			'ON'
			));
		

		$query = $this->db->get($table);
		return $query->result();
	}

	public function get_company_info()
	{
	 	$this->db->select('company_name');
	 	$this->db->where('company_id', $this->session->userdata('company_id'));

	 	$query = $this->db->get('company_info', 1);
	 	return $query->row();
	}

	public function has_division($company_id) //check if company has divisions
	{
		$this->db->select('company_id');
		$this->db->where(array(

			'company_id'			=>			$company_id,
			'wDivision'				=>			1
			));

		$query = $this->db->get('company_info', 1);

		if ($query->num_rows() > 0)
		{
			return true;
		}

		else {
			return false;
		}
	}

	public function has_subsection($section_id)
	{
		$this->db->select('section_id');
		$this->db->where(array(

			'section_id'			=>			$section_id,
			'wSubsection'			=>			1
			));

		$query = $this->db->get('section', 1);

		if ($query->num_rows() > 0)
		{
			return true;
		}

		else{
			return false;
		}
	}

	public function get_form_details($document_no, $table_name)
	{

		$form = $this->get_form_detail($table_name, $document_no);
		$filer = $this->get_employee_details($form->employee_id);
		$info = new \stdClass;

		$info->filer = $filer;

		
		if ($table_name == 'emp_official_business')
		{
			$dates = $this->get_days($table_name, 'ob', $document_no);
			$info->days = $dates;
		}
		else if($table_name=='employee_leave')
		{
			$dates = $this->get_employeeleavedays($table_name, 'employee_leave_days', $document_no);
			$info->days = $dates;
		}
		
		$info->form = $form;
		return $info;
	}

	public function get_employeeleavedays($table_name, $type, $document_no)
	{
		
			$this->db->select('*');
			$this->db->where('doc_no', $document_no);
			$query = $this->db->get($type);
			return $query->result();
		

	}
	public function get_days($table_name, $type, $document_no)
	{
		$table_name = $table_name . "_days";
		if ($type=='ob')
		{
			$this->db->select('the_date');
			$this->db->where('doc_no', $document_no);

			$query = $this->db->get($table_name);
			return $query->result();
		}


	}

	public function get_employee_details($employee_id)
	{
		$this->db->select('employee_id,company_id, first_name, last_name, middle_name, isApplicant, picture, classification_name, subsection_name, dept_name, section_name, location_name, position_name, division_name');
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('basic_info_view', 1);
		return $query->row();
	}

	public function get_form_detail($table_name, $doc_no)
	{
		
		if ($table_name =='emp_authority_to_deduct')
		{
			$this->db->select('a.*,b.advance_type');
			$this->db->join('advance_type b', "a.type_of_advance = b.id", "inner");
		}

		else if ($table_name=='emp_loans')
		{
			$this->db->select('a.*,b.loan_type_desc,c.cValue as cutoff');
			$this->db->join('loan_type b', "a.loan_type = b.loan_type_id", "inner");
			$this->db->join('system_parameters c', "c.param_id = a.deduction", "inner");
		}

		else if ($table_name =='emp_grocery_items_loan')
		{
			$this->db->select("a.*, b.month_from, b.day_from, b.year_from, b.month_to, b.day_to, b.year_to");
			$this->db->join('payroll_period b', "a.last_payroll_period=b.id", "left outer");
		}
		else if ($table_name =='emp_bap_claim')
		{
			$this->db->select("a.*, b.cValue as religion_name, c.cValue as relationship_name");
			$this->db->join('system_parameters b', 'a.deceased_religion=b.param_id', "inner");
			$this->db->join('system_parameters c', 'a.relation_to_claimant=c.param_id', "inner");
		}

		else if ($table_name == 'emp_hdmf_cancellation')
		{
			$this->db->select("a.*, b.month_from, b.day_from, b.year_from, b.month_to, b.day_to, b.year_to");
			$this->db->join('payroll_period b', "a.payroll_period=b.id", "inner");
		}
		else if($table_name == 'employee_leave_cancel')
		{
			$this->db->select("a.*,b.*,c.*,a.status as stat,d.*,a.reason as cancel_reason,c.reason as apply_reason,a.doc_no as doc,a.status as cancel_status,c.status as leave_status,a.date_created as cancel_date, c.date_created as leave_date,c.doc_no as doc_nos",false);
			$this->db->join("employee_leave c","c.doc_no = a.cancelled_doc_no");
			$this->db->join("leave_type d","d.id = c.leave_type_id");
			$this->db->join("employee_info b","b.employee_id = a.employee_id");
			
		}
		else if($table_name == 'employee_leave')
		{
			$this->db->select("a.*,b.*",false);
			$this->db->join("leave_type b","b.id = a.leave_type_id","left outer");
		}
		else if($table_name=='emp_change_rest_day')
		{
			$this->db->select("a.*,b.*",false);
			$this->db->join("payroll_period b","b.id = a.payroll_period","left");
		}
		else if($table_name=='emp_payroll_complaint')
		{
			$this->db->select("a.*,b.*,c.*",false);
			$this->db->join("setting_type_complaints b","b.id = a.complaint_type");
			$this->db->join("payroll_period c","c.id = a.payroll_period");
		}
		else if($table_name=='emp_trip_ticket')
		{
			$this->db->select("a.*,c.car_model as car",false);
			$this->db->join("setting_car_tripticket b","b.car_platenumber = a.plate_no","left");
			$this->db->join("setting_car_model c","c.id = b.car_model","left");
		}
		else if ($table_name == 'emp_sss_cancellation')
		{
			$this->db->select("a.*, b.month_from, b.day_from, b.year_from, b.month_to, b.day_to, b.year_to");
			$this->db->join('payroll_period b', "a.payroll_period=b.id", "inner");
		}
		

		$table_name = $table_name . " a";
		$this->db->where('a.doc_no', $doc_no);
		$query = $this->db->get($table_name, 1);
		return $query->row();
	}

	public function respond()
	{
		
		$company_id = $this->input->post('company_id');
		$status = $this->input->post('status');
		$table_name = $this->input->post('table');
		$doc_no = $this->input->post('doc_no');
		$comment = $this->input->post('comment');
		$filer_id = $this->input->post('filer_id');
		$identification = $this->input->post('identification');

		$current_level = $this->get_approval_level($table_name, $doc_no);
		$filer = $this->getInfo($filer_id);
		$has_subsection = $this->has_subsection($filer->section);
		$has_division = $this->has_division($filer->company_id);
		
		$type = 'Manual Approval';
		$this->update_approval_table($status, $comment, $table_name, $current_level, $doc_no, $type); //update table

		if (($status == 'rejected') || ($status == 'cancelled'))
		{
			$this->update_main($table_name, $status, $doc_no, $comment);
		}
		else
		{
			$this->db->select_min('approval_level');
			$this->db->from($table_name."_approval");
			$this->db->where(array('doc_no' => $doc_no,'status'=>'pending','status_view'=>'OFF'));
			$query = $this->db->get();
			$next_level=$query->row('approval_level');

			if (empty($next_level)) //LAST APPROVER
			{
				$this->update_main($table_name, $status, $doc_no, $comment);

				if ($identification == 'HR008') //IF ATRO
				{
					$this->update_incentive_leave($doc_no,$company_id);
				}
				if ($identification == 'HR024') //IF APPROVED CANCELL
				{
					$this->update_emp_leave($doc_no); 
				}
			}
			else
			{
				
					$this->db->select_min('approval_level');
					$this->db->from($table_name."_approval");
					$this->db->where(array('doc_no' => $doc_no,'status'=>'pending','status_view'=>'OFF'));
					$query = $this->db->get();
					$id=$query->row('approval_level');
					$data =array('status_view' => 'ON','submitted_on'=>date('Y-m-d'));

					$this->db->where(array('approval_level'=> $id,'doc_no' => $doc_no));
					$update = $this->db->update($table_name."_approval",$data);

					$this->db->where(array('approval_level'=> $id,'doc_no' => $doc_no));
					$app = $this->db->get($table_name."_approval");
					$approver_id = $app->row('approver_id');
					$send_email = $this->employee_email_model->approver_send_email('request_approval',$doc_no,$table_name,$id);

	
			}
		}

	}

	function update_apply_leave($doc)
	{
		$data = array('status'=>'cancelled');
		$this->db->where('doc_no',$doc);
		$update = $this->db->update('employee_leave',$data);

		$this->db->where('doc_no',$doc);
		$update = $this->db->update('employee_leave_approval',$data);
	}

	public function mass_response($company_id,$status, $table_name, $doc_no, $comment, $filer_id, $identification)
	{
		$current_level = $this->get_approval_level($table_name, $doc_no);
		$filer = $this->getInfo($filer_id);
		$has_subsection = $this->has_subsection($filer->section);
		$has_division = $this->has_division($filer->company_id);
		
		$type = 'Mass Approval';
		$this->update_approval_table($status, $comment, $table_name, $current_level, $doc_no, $type); //update table

		if (($status == 'rejected') || ($status == 'cancelled'))
		{
			$this->update_main($table_name, $status, $doc_no, $comment);
		}
		else
		{
			$this->db->select_min('approval_level');
			$this->db->from($table_name."_approval");
			$this->db->where(array('doc_no' => $doc_no,'status'=>'pending','status_view'=>'OFF'));
			$query = $this->db->get();
			$next_level=$query->row('approval_level');

			if (empty($next_level)) //LAST APPROVER
			{
				$this->update_main($table_name, $status, $doc_no, $comment);

				if ($identification == 'HR008') //IF ATRO
				{
					$this->update_incentive_leave($doc_no,$company_id);
				}
			}
			else
			{
	 				$this->db->select_min('approval_level');
					$this->db->from($table_name."_approval");
					$this->db->where(array('doc_no' => $doc_no,'status'=>'pending','status_view'=>'OFF'));
					$query = $this->db->get();
					$id=$query->row('approval_level');
					$data =array('status_view' => 'ON','submitted_on'=>date('Y-m-d'));

					$this->db->where(array('approval_level'=> $id,'doc_no' => $doc_no));
					$update = $this->db->update($table_name."_approval",$data);

					$this->db->where(array('approval_level'=> $id,'doc_no' => $doc_no));
					$app = $this->db->get($table_name."_approval");
					$approver_id = $app->row('approver_id');
					$send_email = $this->employee_email_model->approver_send_email('request_approval',$doc_no,$table_name,$id);
			}
		}
	}

	public function update_incentive_leave($doc_no,$company_id)
	{
		$form = $this->get_form_detail('emp_atro', $doc_no);
		if($form->atro_conversion=="IL"){

				$inc_table=$this->check_incentive_leave_table($company_id,$form->no_of_hours);
				$year = date("Y", strtotime($form->atro_date));
				if(!empty($inc_table)){
					$equivalent_incentive_credit=$inc_table->equivalent_incentive_credit;

							$this->data = array(
								'employee_id'							=>		$form->employee_id,
								'doc_no'								=>		$doc_no,
								'equivalent_incentive_credit'			=>		$equivalent_incentive_credit,
								'date_converted'						=>		date("Y-m-d h:i:s a"),
								'year'									=>		$year
							);	
							$this->db->insert("incentive_leave_credits",$this->data);

				}else{
						$this->data = array(
								'employee_id'							=>		$form->employee_id,
								'doc_no'								=>		$doc_no,
								'equivalent_incentive_credit'			=>		0,
								'no_match'			=>		1,
								'date_converted'						=>		date("Y-m-d h:i:s a"),
								'year'									=>		$year
							);	
							$this->db->insert("incentive_leave_credits",$this->data);
				}
		}else{

		}


		

	}

	public function check_incentive_leave_table($company_id,$no_of_hours){

		$query = $this->db->query("SELECT equivalent_incentive_credit FROM incentive_leave_table where company_id='".$company_id."' AND InActive='0' AND $no_of_hours BETWEEN start_ot_hour and end_ot_hour");
		return $query->row();
	}

	public function update_emp_leave($doc_nos)
	{ 
		$this->db->where('doc_no',$doc_nos);
		$query = $this->db->get('employee_leave_cancel');
		$cancel = $query->row('cancelled_doc_no');

		$data=array('status' => 'cancelled');
		$this->db->where('doc_no',$cancel);
		$this->db->update('employee_leave',$data);

		$data=array('status' => 'cancelled');
		$this->db->where('doc_no',$cancel);
		$this->db->update('employee_leave_approval',$data);
	}

	public function update_approval_table($status, $comment, $table_name, $approval_level, $doc_no, $type)
	{

		$this->data =array(
			'status'   				=>			$status,
			'comment'				=>			$comment,
			'responder_id'			=>			$this->session->userdata('employee_id'),
			'approval_type'			=>			$type
			);

		$this->db->where(array(
			'doc_no'				=>			$doc_no,
			'approval_level'		=>			$approval_level
			));

		$table_name = $table_name . "_approval";
		$this->db->set('date_time', 'now()', false);
		$this->db->update($table_name, $this->data);

	}

	public function update_main($table, $status, $doc_no, $comment)
	{
		$this->data = array(
			'status'			=>			$status,
			'remarks'			=>			$comment
			);

		$this->db->where('doc_no', $doc_no);
		$this->db->set('status_update_date', 'now()', false);
		$this->db->update($table, $this->data);

		$send_email = $this->employee_email_model->approver_send_email('transaction_status',$doc_no,$table,"none");
	}

	public function get_next_level($me, $approval_level, $form_identification,  $has_subsection, $has_division)
	{ 
		$this->db->select('approval_level');
		$this->db->where('approval_level >', $approval_level); //where approval_level is greater than given approval
		$this->db->where('company', $me->company_id);
		$this->db->where('department', $me->department);
		$this->db->where('section', $me->section);
		$this->db->where('classification', $me->classification);
		$this->db->where('form_identification', $form_identification);
		$this->db->where('InActive', 0);
		if ($has_subsection)
		{
			$this->db->where('sub_section', $me->subsection);
		}

		if ($has_division)
		{
			$this->db->where('division_id', $me->division_id);
		}


		$this->db->order_by('approval_level', 'asc'); //Arranged Ascending
		$query = $this->db->get('transaction_approvers', 1); //Limit to 1. Get the next approver
		return $query->row(); //return 1 result only.
	}

	//updated
	public function next_approvers($approval_level, $form_identification, $me, $has_subsection, $has_division)
	{

		$this->db->select('approver, approval_level');
		$this->db->where('company', $me->company_id);
		$this->db->where('department', $me->department);
		$this->db->where('section', $me->section);
		$this->db->where('classification', $me->classification);
		$this->db->where('form_identification', $form_identification);
		$this->db->where('approval_level', $approval_level->approval_level);

		if ($has_subsection)
		{
			$this->db->where('sub_section', $me->subsection);
		}

		if ($has_division)
		{
			$this->db->where('division_id', $me->division_id);
		}


		$query = $this->db->get('transaction_approvers');

		return $query->result();
	}


	public function get_approval_level($table_name, $doc_no)
	{
		// $doc_no= 'HR006_521_2017-08-02-11-46-49';
		// $table_name = 'emp_authority_to_deduct';
		$table_name = $table_name . '_approval';

		$this->db->select('MIN(approval_level) as approval_level');
		$this->db->where('doc_no', $doc_no);
		$this->db->where(array('approver_id'=>$this->session->userdata('employee_id'),'status'=>'pending'));
		$query = $this->db->get($table_name, 1);

		return $query->row()->approval_level;
	}

	public function get_approvers($form_identification)
	{	
		$me = $this->getInfo($this->session->userdata('id'));
		$has_subsection = $this->has_subsection($me->section);
		$has_division = $this->has_division($this->session->userdata('company_id'));


		$this->db->select('approver, approval_level, approval_category');
		$this->db->where('company', $me->company_id);
		$this->db->where('department', $me->department);
		$this->db->where('section', $me->section);
		$this->db->where('classification', $me->classification);
		$this->db->where('form_identification', $form_identification);

		//status_update_date	
		if ($has_subsection)
		{
			$this->db->where('sub_section', $me->subsection);
		}

		if ($has_division)
		{
			$this->db->where('division_id', $me->division_id);
		}


		$query = $this->db->get('transaction_approvers');

		return $query->result();
	}


	public function getInfo($id)
	{
		$this->db->select('company_id, location, classification, section, department, subsection, division_id');
		$this->db->where('employee_id', $id);

		$query = $this->db->get('basic_info_view', 1);
		return $query->row();
	}


	public function get_forms_by_table($tbl)
	{
		$forms = $this->get_forms($tbl);

		foreach ($forms as $form)
		{
			$info = $this->get_form_details($form->doc_no, $tbl);
			$form->info = $info;
		}

		return $forms;
	}

	public function get_forms($tbl)
	{
		$table_name = $tbl . "_approval";

		$this->db->select('doc_no');
		$this->db->where(array(
			'approver_id'			=>			$this->session->userdata('employee_id'),
			'status'				=>			'pending',
			'status_view'			=>			'ON'
			));
		$query = $this->db->get($table_name);
		return $query->result();
	}

	public function get_form_name($table)
	{
		$this->db->select('t_table_name, form_name, identification');
		$this->db->where('t_table_name', $table);
		$query = $this->db->get('transaction_file_maintenance', 1);
		return $query->row();
	}


	public function get_transaction_list()
	{
		$where = "t_table_name is not NULL";
		$this->db->select("id, identification, form_name, t_table_name, approval_limit, approval_action, IsUserDefine");
		$this->db->where('form_type', 'T');
		$this->db->where($where);
		$this->db->where("IsActive", 1);
		$query = $this->db->get("transaction_file_maintenance");
		return $query->result();
	}

	public function get_pending_transactions_without_action($table_name)
	{
		$approval_table = $table_name . '_approval';
		$table = $table_name . ' b';
		$where = 'a.approval_type is null';
		$this->db->select('a.*, b.employee_id');
		$this->db->join($table, 'a.doc_no = b.doc_no', 'inner');
		$this->db->where('a.status', 'pending');
		$this->db->where('b.employee_id', $this->session->userdata('employee_id'));
		$this->db->where($where);
		$query = $this->db->get($approval_table);
		return $query->result();
	}

	//added code for approver level checker
	public function approval_level_checker($doc_no,$employee_id,$table_name)
	{
		$table = $table_name."_approval";
		$this->db->where('doc_no',$doc_no);
		$this->db->where('approver_id',$employee_id);
		$query = $this->db->get($table);
		$approval_level = $query->row('approval_level');
		if($approval_level==1)
		{
			return 'true';
		}
		else{
			$approval = $approval_level - 1;
			$this->db->where('doc_no',$doc_no);
			$this->db->where('approval_level',$approval);
			$this->db->where('status!=','Pending');
			$query1 = $this->db->get($table);
			$row_query = $query1->num_rows();
			if($row_query > 0){ return 'true'; } else{ return 'false'; }
		}
	}

	function leave($leave_id)
	{
		$this->db->where('id',$leave_id);
		$query = $this->db->get('leave_type');
		return $query->row('leave_type');
	}

	//added by mimi
	public function get_request_form_list()
	{
		$this->db->where('InActive',0);
		$query = $this->db->get('emp_request_form_list');
		return $query->result();
	}

	public function check_days_waiting($doc_no,$employee_id,$company_id,$t_table_name)
	{
		$date = date('Y-m-d');
		$this->db->where('t_table_name',$t_table_name);
		$query = $this->db->get('transaction_file_maintenance');
		$transaction_id = $query->row('id');
		$identification = $query->row('identification');

		$this->db->where('transaction_id',$transaction_id);
		$this->db->where('company_id',$company_id);
		$this->db->where('InActive',0);
		$setting_query = $this->db->get('form_approval_automatic_approved_setting');
		$setting_num = $setting_query->num_rows();
		$setting_days = $setting_query->row('days');
		$setting_action = $setting_query->row('action');
		if($setting_num==0){  }
		else{
		$this->db->where('doc_no',$doc_no);
		$this->db->where('status','pending');
		$query = $this->db->get($t_table_name.'_approval');
		$date_submitted = $query->row('submitted_on');
		$comment ='automatic';
		$last_date_of_view = date('Y-m-d', strtotime($date_submitted. ' + '.$setting_days.' days'));

		 if($last_date_of_view <= date('Y-m-d'))	
		 {   
		 	$respond_setting = $this->respond_setting($company_id,$setting_action, $t_table_name,$doc_no,$comment,$employee_id,$identification);
		 }
		 else
		 {}
		}
	}
	
	public function respond_setting($company_id,$status, $table_name,$doc_no,$comment,$filer_id,$identification)
	{
		
		$current_level = $this->get_approval_level($table_name, $doc_no);
		$filer = $this->getInfo($filer_id);
		$has_subsection = $this->has_subsection($filer->section);
		$has_division = $this->has_division($filer->company_id);
		
		$type = 'Manual Approval';
		$this->update_approval_table($status, $comment, $table_name, $current_level, $doc_no, $type); //update table

		if (($status == 'rejected') || ($status == 'cancelled'))
		{
			$this->update_main($table_name, $status, $doc_no, $comment);
		}
		else
		{
			$this->db->select_min('approval_level');
			$this->db->from($table_name."_approval");
			$this->db->where(array('doc_no' => $doc_no,'status'=>'pending','status_view'=>'OFF'));
			$query = $this->db->get();
			$next_level=$query->row('approval_level');
			
			if (empty($next_level)) //LAST APPROVER
			{
				$this->update_main($table_name, $status, $doc_no, $comment);

				if ($identification == 'HR008') //IF ATRO
				{
					$this->update_incentive_leave($doc_no,$company_id);
				}
				if ($identification == 'HR024') //IF APPROVED CANCELL
				{
					$this->update_emp_leave($doc_no); //echo "mila";
				}
			}
			else
			{
 				$next_approvers = $this->next_approvers($next_level, $identification, $filer, $has_subsection, $has_division);
 				if (!(empty($next_approvers)))
 				{
 					$approval_table = $table_name . "_approval";
	 				foreach ($next_approvers as $approver) {
	 					$this->data = array(
	 						'doc_no'				=>				$doc_no,
	 						'approver_id'			=>				$approver->approver,
	 						'approval_level'		=>				$approver->approval_level,
	 						'status'				=>				'pending'
	 						);
	 					$this->db->set('submitted_on', 'now()', false);
	 					$this->db->insert($approval_table, $this->data);
	 				}
 				}

			}
		}

	}

	public function get_request_list()
	{
		$query = $this->db->get('emp_request_form_list');
		return $query->result();
	}

	public function get_request_list_data($id)
	{ 
		$this->db->where('doc_no',$id);
		$query = $this->db->get('emp_request_form');
		return $query->row('request_list');
	}

	public function get_atro_withpay_incentive($type)
	{
		$table = "emp_atro_approval";
		
		$this->db->distinct();	
		$this->db->select('a.doc_no');
		$this->db->join('emp_atro b','b.doc_no=a.doc_no');
		$this->db->where('b.atro_conversion',$type);
		$this->db->where(array(
			'a.approver_id'				=>				$this->session->userdata('employee_id'),
			'a.status'					=>				'pending',
			'a.status_view'					=>			'ON'
			));
		
		$query = $this->db->get($table." a");
		$queryresult = $query->result();


		foreach ($queryresult as $form) {
				
				$form_info 	= $this->get_form_info('emp_atro', $form->doc_no);
				$filer_info = $this->get_filer_info($form_info->employee_id);

				$form->form_info = $form_info;
				$form->filer_info = $filer_info;
		} 

		return $queryresult;

	}

	public function get_forms_by_table_atro($tbl,$type)
	{
		$forms = $this->get_forms_atro($tbl,$type);

		foreach ($forms as $form)
		{
			$info = $this->get_form_details($form->doc_no, $tbl);
			$form->info = $info;
		}

		return $forms;
	}

	public function get_forms_atro($tbl,$type)
	{
		$table_name = $tbl . "_approval";
		$this->db->distinct();
		$this->db->select('a.doc_no');
		$this->db->join('emp_atro b','b.doc_no=a.doc_no');
		$this->db->where(array(
			'a.approver_id'			=>			$this->session->userdata('employee_id'),
			'a.status'				=>			'pending',
			'atro_conversion'		=>			$type,
			'status_view'			=>			'ON'
			));
		$query = $this->db->get($table_name." a");
		return $query->result();
	}

}
