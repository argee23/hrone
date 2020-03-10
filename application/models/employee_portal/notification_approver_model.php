<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Notification_approver_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}

	public function get_pending_transactions()
	{
			$transactions = $this->get_notification_list();

			foreach ($transactions as $tran) {

				$forms = $this->get_notifications_by_table($tran->t_table_name);
				foreach ($forms as $form) {

					$form_info 	= $this->get_notif_info($tran->t_table_name, $form->doc_no);
					$filer_info = $this->get_emp_info($form_info->employee_id);

					$form->form_info = $form_info;
					$form->filer_info = $filer_info;
				} //End for each form

				$tran->forms = $forms;
				
			} //End for each transaction

			return $transactions;	
	}

	public function get_notification_list()
	{
		$company_id = $this->session->userdata('company_id');
		$where = "t_table_name is not NULL";
		$this->db->select("id, identification, form_name, t_table_name");
		$this->db->where('company_id', $company_id);
		$this->db->where($where);
		$this->db->where("IsActive", 1);
		$this->db->where("issuance_type", 1);
		$query = $this->db->get("notification_file_maintenance");
		return $query->result();
	}
	public function get_notifications_by_table($table_name)
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
	public function get_notif_info($table_name, $doc_no)
	{
		$this->db->select('*');
		$this->db->where('doc_no', $doc_no);
		$query = $this->db->get($table_name, 1);
		return $query->row();

		

	}
	public function get_emp_info($employee_id)
	{
		$this->db->select('employee_id as emp_id, first_name, middle_name,  last_name');
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('basic_info_view', 1);
		return $query->row();
	}
	public function get_emp_data_emp($table,$id,$ret,$val)
	{
		$this->db->where($id,$val);
		$query = $this->db->get($table);
		return $query->row($ret);
	}

	public function get_assign_to_fillup($doc_no,$approver,$table)
	{
		$this->db->where(array('doc_no'=>$doc_no,'approver_id'=>$approver));
		$query = $this->db->get($table,1);
		return $query->row('approval_level');
	}
	public function respond_notification($doc_no,$table,$employee_id,$identification,$approval_level,$approver_status,$comment,$form_details,$field_list,$assign,$type)
	{
		if(empty($approver_status)){  }
		else
		{
				$this->update_approval_table($doc_no,$table,$approval_level,$approver_status,$comment,$type); 
				$i=1; foreach($field_list as $fl)
		                {
		                  $title = $fl->TextFieldName;
		                   $assign_employee_id = $assign->$title;

		                  if(empty($assign_employee_id)){}
		                  else
		                  { 
		                  	if($assign_employee_id=='approver')
		                  	{
		                  		
		                  		 $field_name = $this->input->post('field'.$fl->TextFieldName.$doc_no);
		                  		 $this->update_main_fields($doc_no,$fl->TextFieldName,$field_name,$table);	
		                  		
		                  	}
		                  }
		        $i++;    }

				if($approver_status=='rejected' || $approver_status=='cancelled')
				{
					$this->update_main($doc_no,$approver_status,$table,$comment);
				}
				else
				{

					$next_level = $this->get_next_level($doc_no,$approval_level,$table);
					
					if(empty($next_level))
					{
						$this->update_main($doc_no,$approver_status,$table,$comment);

						$this->db->where('doc_no',$doc_no);
						$qq = $this->db->get($table);
						$employee_id = $qq->row('employee_id');
						$employee_details=$this->issue_notifications_model->get_employee_details($employee_id);

						$send_email = $this->issue_notifications_model->send_email_notification('employee',$form_details->id,$employee_details,$doc_no,$form_details,$employee_id);
					}
					else
					{
						$this->update_status_view_next_approver($doc_no,$next_level,$table,$form_details);
					}
				}

		}
	}
	public function update_main($doc_no,$status,$table,$comment)
	{
		$this->data = array(
			'status'			=>			$status,
			'remarks'			=>			$comment,
			'status_update_date' =>			date('Y-m-d H:i:s')
			);

		$this->db->where('doc_no', $doc_no);
		$this->db->set('status_update_date', 'now()', false);
		$this->db->update($table, $this->data);

		// $send_email = $this->employee_email_model->approver_send_email('transaction_status',$doc_no,$table,"none");
	}
	public function for_approved()
	{
		$this->db->where(array('doc_no'=>$doc_no,'approval_level'=>$approval_level));
		$this->db->update($table."_approval",array('status'=>$approver_status,'comment'=>$comment));
	}

	public function update_approval_table($doc_no,$table,$approval_level,$status,$comment,$type)
	{
		

		$this->data =array(
			'status'   				=>			$status,
			'comment'				=>			$comment,
			'responder_id'			=>			$this->session->userdata('employee_id')
			);

		$this->db->where(array(
			'doc_no'				=>			$doc_no,
			'approval_level'		=>			$approval_level
			));

		$table_name = $table . "_approval";
		$this->db->set('date_time', 'now()', false);
		$this->db->update($table_name, $this->data);

	
	}
	public function get_next_level($doc_no,$approval_level,$table)
	{ 
		$this->db->select('approval_level');
		$this->db->where('approval_level >', $approval_level); 
		$this->db->where(array('status'=>'pending','doc_no'=>$doc_no));
		$query = $this->db->get($table."_approval", 1); 
		return $query->row('approval_level'); 
	}

	public function update_status_view_next_approver($doc_no,$next_level,$table,$form_details)
	{

		
		$data =array('status_view' => 'ON','submitted_on'=>date('Y-m-d'));

		$this->db->where(array('approval_level'=> $next_level,'doc_no' => $doc_no));
		$update = $this->db->update($table."_approval",$data);

		$this->db->select('approver_id');
		$this->db->where(array('doc_no'=>$doc_no,'approval_level'=>$next_level));
		$query = $this->db->get($table."_approval");
		$approver_id = $query->row('approver_id');

		$this->db->where('doc_no',$doc_no);
		$qq = $this->db->get($table);
		$employee_id = $qq->row('employee_id');
		$employee_details=$this->issue_notifications_model->get_employee_details($employee_id);

		$send_email = $this->issue_notifications_model->send_email_notification('approver',$form_details->id,$employee_details,$doc_no,$form_details,$approver_id);
	}
	public function update_main_fields($doc_no,$udf_label,$field_name,$table)
	{
		$data =array($udf_label => $field_name);

		$this->db->where(array('doc_no' => $doc_no));
		$update = $this->db->update($table,$data);
	}
	public function get_notification_name($table)
	{
		$this->db->select('t_table_name, form_name, identification,id');
		$this->db->where('t_table_name', $table);
		$query = $this->db->get('notification_file_maintenance', 1);
		return $query->row();
	}

	public function get_notif_by_table($tbl)
	{
		$forms = $this->get_forms($tbl);

		foreach ($forms as $form)
		{
			$info = $this->get_notif_details($form->doc_no, $tbl);
			$form->info = $info;
		}

		return $forms;
	}
	public function get_forms($tbl)
	{
		$table_name = $tbl . "_approval";

		$this->db->select('doc_no,approval_level');
		$this->db->where(array(
			'approver_id'			=>			$this->session->userdata('employee_id'),
			'status'				=>			'pending'
			));
		$query = $this->db->get($table_name);
		return $query->result();
	}
	public function get_notif_details($document_no, $table_name)
	{

		$form = $this->get_notif_detail($table_name, $document_no);
		$filer = $this->get_employee_details($form->employee_id);
		$info = new \stdClass;

		$info->filer = $filer;
		$info->form = $form;
		return $info;
	}
	public function get_notif_detail($table_name,$doc_no)
	{
		$table_name = $table_name . " a";
		$this->db->where('a.doc_no', $doc_no);
		$query = $this->db->get($table_name, 1);
		return $query->row();
	}
	public function get_employee_details($employee_id)
	{
		$this->db->select('employee_id, first_name, last_name, middle_name, isApplicant, picture, classification_name, subsection_name, dept_name, section_name, location_name, position_name, division_name');
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('basic_info_view', 1);
		return $query->row();
	}
	public function get_selectbox_value($tran_id)
	{
		$this->db->where('udf_tran_col_id',$tran_id);
		$this->db->order_by('tran_udf_opt_id','ASC');
		$query = $this->db->get('notification_udf_option');
		return $query->result();

	}
}
