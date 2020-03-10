<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Notification_approval_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function setting_no_approver()
	{
		$this->db->select('*,company_name,company_info.company_id');
		$this->db->from('notification_approval_setting_no_approver');
		$this->db->join('company_info','company_info.company_id=notification_approval_setting_no_approver.company_id');
		$query = $this->db->get();
		return $query->result();
	}
	public function recheck_if_exist_no_approver($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('notification_approval_setting_no_approver');
		return $query->num_rows();
	}

	public function save_add_no_approver($setting_company,$setting_approver)
	{
		$data = array('company_id' => $setting_company,
						'setting_value' => $setting_approver,
						'date_created' => date('Y-m-d H:i:s'));

		$insert = $this->db->insert('notification_approval_setting_no_approver',$data);
		if($this->db->affected_rows() > 0)
		{
			$a_company = $this->session->userdata('company_id');
			$a_employee = $this->session->userdata('employee_id');
			$datenow =date('Y-m-d H:is');
			$details = 'Company id -'.$setting_company." / with setting value - ".$setting_approver;
			$save_log = $this->logfile_salary_approvers('notification_approval',$details,'add',$a_company,$a_employee,$datenow,'logfile_approval_max_no_of_approvers');
	    	

	    	return 'inserted'; 
		}
		else
		{ return 'error'; }
	}

	public function delete_setting_no_approver($id)
	{
		$this->db->where('no_approver_id',$id);
		$q = $this->db->get('notification_approval_setting_no_approver');


		$this->db->where('no_approver_id',$id);
		$delete = $this->db->delete('notification_approval_setting_no_approver');
		if($this->db->affected_rows() > 0)
		{
			$a_company = $this->session->userdata('company_id');
			$a_employee = $this->session->userdata('employee_id');
			$datenow =date('Y-m-d H:is');

			$details = 'Company id -'.$q->row('company_id')." / with setting value - ".$q->row('setting_value');
			$save_log = $this->logfile_salary_approvers('notification_approval',$details,'delete',$a_company,$a_employee,$datenow,'logfile_approval_max_no_of_approvers');


	    	return 'deleted'; 
		}
		else
			{ return 'error'; }
	}

	public function no_approver($id)
	{
		$this->db->where('no_approver_id',$id);
		$query = $this->db->get('notification_approval_setting_no_approver');
		return $query->row('setting_value');

	}

	public function saveupdate_no_approver_setting($company_id,$setting_approver)
	{
		$this->db->where('company_id',$company_id);
		$q = $this->db->get('notification_approval_setting_no_approver');


		$data = array('setting_value' => $setting_approver);

		$this->db->where('company_id',$company_id);
		$insert = $this->db->update('notification_approval_setting_no_approver',$data);
		if($this->db->affected_rows() > 0)
		{
			$a_company = $this->session->userdata('company_id');
			$a_employee = $this->session->userdata('employee_id');
			$datenow =date('Y-m-d H:is');
			$details = 'Company id -'.$q->row('company_id')." / (with old setting value - ".$q->row('setting_value')." and updated setting value - ".$setting_approver.")";
			$save_log = $this->logfile_salary_approvers('notification_approval',$details,'update',$a_company,$a_employee,$datenow,'logfile_approval_max_no_of_approvers');


	    	return 'updated'; 
		}
		else
			{ return 'error'; }
	}

	public function logfile_salary_approvers($type,$details,$action,$company,$employee,$datenow,$table)
	{		
			$data = array('type'=>$type,'details'=>$details,'action'=>$action,'company_id'=>$company,'employee_id'=>$employee,'datetime'=>date('Y-m-d H:i:s'));
			$insert = $this->db->insert($table,$data);
	}

	public function approver_list()
	{
		$this->db->select('fullname,employee_id,company_name');
		$this->db->from('employee_info');
		$this->db->where('isNotificationApproverChoices','1');
		$this->db->join('company_info','company_info.company_id=employee_info.company_id');
		$query = $this->db->get();
		return $query->result();
	}

	public function getSearch_EmployeeList($val){//para sa active employees
		$this->db->select("
			A.employee_id,
			A.department,
			B.dept_name,
			A.id,
			concat(A.first_name,' ',A.middle_name,' ',A.last_name) as name
			",false);
		$where = "A.InActive = 0 and A.isEmployee = 1 and A.isApproverChoice ='0' and 
			(
				A.employee_id like '%".$val."%' or 
				A.first_name like '%".$val."%' or 
				A.middle_name like '%".$val."%' or 
				A.last_name like '%".$val."%'
			)
			";
		$this->db->where($where);
		$this->db->order_by("A.id","ASC");
		$this->db->join("department B","B.department_id = A.department","left outer");
		$query = $this->db->get("employee_info A");
		return $query->result();
	}

	public function add_new_approver_choices($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$this->data = array('isNotificationApproverChoices'=>1);
		$this->db->update("employee_info",$this->data);
		if($this->db->affected_rows() > 0)
		{
			$a_company = $this->session->userdata('company_id');
			$a_employee = $this->session->userdata('employee_id');
			$datenow =date('Y-m-d H:is');
			$details = 'approver choices employee id - '.$employee_id;
			$save_log = $this->logfile_salary_approvers('notification_approver_choices',$details,'add',$a_company,$a_employee,$datenow,'logfile_approval_approver_choices');


	    	return 'inserted'; 
		}
		else
			{ return 'error'; }
	}

	public function delete_approver($id)
	{
		$this->db->where('employee_id',$id);
		$this->data = array('isNotificationApproverChoices'=>0);
		$this->db->update("employee_info",$this->data);
		if($this->db->affected_rows() > 0)
		{
			$a_company = $this->session->userdata('company_id');
			$a_employee = $this->session->userdata('employee_id');
			$datenow =date('Y-m-d H:is');
			$details = 'approver choices employee id - '.$id;
			$save_log = $this->logfile_salary_approvers('notification_approver_choices',$details,'delete',$a_company,$a_employee,$datenow,'logfile_approval_approver_choices');


	    	return 'deleted'; 
		}
		else
				{ return 'error'; }
	}

	public function automatic_update_status()
	{
		$this->db->select('a.*,b.company_name');
		$this->db->join('company_info b','b.company_id=a.company_id');
		$q = $this->db->get('notification_approval_automatic_approved_setting a');
		return $q->result();
	}

	public function save_automatic_update_status($company,$action,$days)
	{
		$data = array('company_id'  =>  $company,
					  'days'		=>	$days,
					  'status'		=>  $action,
					  'added_by'	=>  $this->session->userdata('employee_id'),
					  'date_created'=>	date('Y-m-d H:i:s'),
					  'InActive'	=>0);
		$this->db->insert('notification_approval_automatic_approved_setting',$data);
		if($this->db->affected_rows() > 0)
		{
			$a_company = $this->session->userdata('company_id');
			$a_employee = $this->session->userdata('employee_id');
			$datenow =date('Y-m-d H:is');
			$details = 'Company ID - '.$company." (".$days." day/s and ".$action.")";
			$save_log = $this->logfile_salary_approvers('notification_automatic_status_update',$details,'add',$a_company,$a_employee,$datenow,'logfile_approver_automatic_update_status');

	    	return 'success_inserted'; 
		}
		else
		{ return 'success_error'; }

	}

	public function settings_automatic_update_status($action,$company)
	{
		if($action=='delete')
		{
			$this->db->where('company_id',$company);
			$this->db->delete('notification_approval_automatic_approved_setting');
			$a='deleted';
		}
		else if($action=='enable')
		{
			$this->db->where('company_id',$company);
			$this->db->update('notification_approval_automatic_approved_setting',array('InActive'=>0));
			$a='enabled';
		}
		else if($action=='disable')
		{
			$this->db->where('company_id',$company);
			$this->db->update('notification_approval_automatic_approved_setting',array('InActive'=>1));
			$a='disabled';
		}

		$a_company = $this->session->userdata('company_id');
		$a_employee = $this->session->userdata('employee_id');
		$datenow =date('Y-m-d H:is');
		$details = $action.' Settings of company - '.$company;
		$save_log = $this->logfile_salary_approvers('notification_automatic_status_update',$details,$action,$a_company,$a_employee,$datenow,'logfile_approver_automatic_update_status');
		return 'success_'.$a;
	}

	public function get_automatic_details_one($company)
	{
		$this->db->where('company_id',$company);
		$q = $this->db->get('notification_approval_automatic_approved_setting');
		return $q->result();
	}
	public function saveupdate_automatic_update_status($company,$action,$days)
	{

		$data = array('days'		=>	$days,
					  'status'		=>  $action);
		$this->db->where('company_id',$company);
		$this->db->update('notification_approval_automatic_approved_setting',$data);
		if($this->db->affected_rows() > 0)
		{
			$a_company = $this->session->userdata('company_id');
			$a_employee = $this->session->userdata('employee_id');
			$datenow =date('Y-m-d H:is');
			$details = 'Company ID - '.$company." (".$days." day/s and ".$action.")";
			$save_log = $this->logfile_salary_approvers('notification_automatic_status_update',$details,'update',$a_company,$a_employee,$datenow,'logfile_approver_automatic_update_status');

	    	return 'success_updated'; 
		}
		else
		{ return 'success_error'; }
	}

	public function get_company_name($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('company_info',1);
		return $query->row('company_name');
	}

	public function load_number_approver($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('notification_approval_setting_no_approver',1);
		return $query->row('setting_value');
	}

	public function addnew_showSearchResult($val,$company)
	{ 
		$this->db->where('company_id',$company);
		$this->db->where('isNotificationApproverChoices','1');
		$query1 = $this->db->get('employee_info');
		$num_roww = $query1->num_rows();

		if($num_roww == 0){
			$this->db->select('fullname as name,company_info.company_id as company_id,company_name,first_name,middle_name,last_name,employee_info.employee_id,position');
				$this->db->from('company_info');
				$this->db->join("employee_info","employee_info.company_id = company_info.company_id");
				$this->db->where('company_info.company_id',$company);
				$this->db->where("(`last_name` LIKE '%$val%' OR  `first_name` OR  `employee_id` LIKE '%$val%')");
				$this->db->order_by('last_name','asc');
				$query = $this->db->get();
				return $query->result();

		}
		else{
				$this->db->select('fullname as name,company_info.company_id as company_id,company_name,first_name,middle_name,last_name,employee_info.employee_id,position');
				$this->db->from('company_info');
				$this->db->join("employee_info","employee_info.company_id = company_info.company_id");
				$this->db->where('company_info.company_id',$company);
				$this->db->where('isApproverChoice',1);
				$this->db->where("(`last_name` LIKE '%$val%' OR  `first_name` OR  `employee_id` LIKE '%$val%')");
				$this->db->order_by('last_name','asc');
				$query = $this->db->get();
				return $query->result();
		}
	}


	public function get_all_notification_approver_list($company,$division,$department,$section,$subsection,$classification,$location,$notification)
	{
		$this->db->select('a.*,b.location_name,c.classification as classification_name,d.*,e.form_name');
		$this->db->join('location b','b.location_id=a.location');
		$this->db->join('classification c','c.classification_id=a.classification');
		$this->db->join('employee_info d','d.employee_id=a.approver');
		$this->db->join('notification_file_maintenance e','e.id=a.notification');
		$this->db->where(array('a.company'=>$company,'a.department'=>$department,'a.division_id'=>$division,'a.section'=>$section,'a.sub_section'=>$subsection));
		if($classification=='All'){ } else{ $this->db->where('a.classification',$classification); }
		if($location=='All'){ } else { $this->db->where('a.location',$location); }
		if($notification=='All'){} else { $this->db->where('a.notification',$notification); }
		$this->db->where('a.admin_deleted',Null);
		$this->db->where('a.date_deleted',Null);
		$this->db->order_by('a.date_created','ASC');
		$query = $this->db->get('notifications_approvers a');
		return $query->result();
	}


	public function get_approver_filtering($notification,$company)
	{
		//$where = '(a.admin_deleted="0" or a.admin_deleted="")';
		$this->db->select('a.*,b.location_name,c.classification as classification_name,d.*,e.form_name,ee.company_name,dd.section_name,ff.subsection_name,a.id as idd');
		$this->db->join('company_info ee','ee.company_id=a.company');
		$this->db->join('location b','b.location_id=a.location');
		$this->db->join('classification c','c.classification_id=a.classification');
		$this->db->join('employee_info d','d.employee_id=a.approver');
		$this->db->join('notification_file_maintenance e','e.id=a.notification');
		$this->db->join('section dd','dd.section_id=a.section');
		$this->db->join('subsection ff','ff.subsection_id=a.sub_section');
		$this->db->where('a.company',$company);

		if($notification=='all'){} else{ $this->db->where('a.notification',$notification); }


		$this->db->where('a.admin_deleted',Null);
		$this->db->where('a.date_deleted',Null);
		$query = $this->db->get('notifications_approvers a');
		return $query->result();
	}
	
	public function get_approver_filtering_result($notif,$company,$division,$department,$section,$subsection,$location,$classification)
	{
		$this->db->select('a.*,b.location_name,c.classification as classification_name,d.*,e.form_name,ee.company_name,dd.section_name,ff.subsection_name,a.id as idd');
		$this->db->join('company_info ee','ee.company_id=a.company');
		$this->db->join('location b','b.location_id=a.location');
		$this->db->join('classification c','c.classification_id=a.classification');
		$this->db->join('employee_info d','d.employee_id=a.approver');
		$this->db->join('notification_file_maintenance e','e.id=a.notification');
		$this->db->join('section dd','dd.section_id=a.section');
		$this->db->join('subsection ff','ff.subsection_id=a.sub_section');
		$this->db->where('a.company',$company);

		if($notif=='all'){} else{ $this->db->where('a.notification',$notif); }
		if($division=='all' || $division=='not_included'){} else{ $this->db->where('a.division_id',$division); }
		if($department=='all' || $department=='not_included'){} else{ $this->db->where('a.department',$department); }
		if($section=='all' || $section=='not_included'){} else{ $this->db->where('a.section',$section); }
		if($subsection=='all' || $subsection=='not_included'){} else{ $this->db->where('a.sub_section',$subsection); }
		if($location=='all' || $location=='not_included'){} else{ $this->db->where('a.location',$location); }
		if($classification=='all' || $classification=='not_included'){} else{ $this->db->where('a.classification',$classification); }
		$this->db->where('a.admin_deleted',Null);
		$this->db->where('a.date_deleted',Null);
		$query = $this->db->get('notifications_approvers a');
		return $query->result();
	}

	public function delete_notification_approver($id)
	{
		$admin = $this->session->userdata('employee_id');
		$date = date('Y-m-d H:i:s');

		$this->db->where('id',$id);
		$this->db->update('notifications_approvers',array('admin_deleted'=>$admin,'date_deleted'=>$date));
	}

	public function delete_all_approvers_by_company($company)
	{
		$admin = $this->session->userdata('employee_id');
		$date = date('Y-m-d H:i:s');

		$this->db->where('company',$company);
		$this->db->update('notifications_approvers',array('admin_deleted'=>$admin,'date_deleted'=>$date));
	}
}