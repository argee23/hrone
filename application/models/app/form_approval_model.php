
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Form_approval_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function companyList()
	{
		$this->db->where('InActive',0);
		$query = $this->db->get('company_info');
		return $query->result();
	}

	public function company_with_approvers($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('form_approval_setting_no_approver');
		return $query->num_rows();
	}

	public function setting_no_approver()
	{
		$this->db->select('*,company_name,company_info.company_id');
		$this->db->from('form_approval_setting_no_approver');
		$this->db->join('company_info','company_info.company_id=form_approval_setting_no_approver.company_id');
		$query = $this->db->get();
		return $query->result();
	}

	public function save_add_no_approver($setting_company,$setting_approver)
	{
		$data = array('company_id' => $setting_company,
						'setting_value' => $setting_approver,
						'date_created' => date('Y-m-d H:i:s'));

		$insert = $this->db->insert('form_approval_setting_no_approver',$data);
		if($this->db->affected_rows() > 0)
		{
			$a_company = $this->session->userdata('company_id');
			$a_employee = $this->session->userdata('employee_id');
			$datenow =date('Y-m-d H:is');
			$details = 'Company id -'.$setting_company." / with setting value - ".$setting_approver;
			$save_log = $this->logfile_salary_approvers('form_approval',$details,'add',$a_company,$a_employee,$datenow,'logfile_approval_max_no_of_approvers');
	    	

	    	return 'inserted'; 
		}
		else
		{ return 'error'; }
	}

	public function delete_setting_no_approver($id)
	{
		$this->db->where('no_approver_id',$id);
		$q = $this->db->get('form_approval_setting_no_approver');


		$this->db->where('no_approver_id',$id);
		$delete = $this->db->delete('form_approval_setting_no_approver');
		if($this->db->affected_rows() > 0)
		{
			$a_company = $this->session->userdata('company_id');
			$a_employee = $this->session->userdata('employee_id');
			$datenow =date('Y-m-d H:is');

			$details = 'Company id -'.$q->row('company_id')." / with setting value - ".$q->row('setting_value');
			$save_log = $this->logfile_salary_approvers('form_approval',$details,'delete',$a_company,$a_employee,$datenow,'logfile_approval_max_no_of_approvers');


	    	return 'deleted'; 
		}
		else
			{ return 'error'; }
	}

	public function no_approver($id)
	{
		$this->db->where('no_approver_id',$id);
		$query = $this->db->get('form_approval_setting_no_approver');
		return $query->row('setting_value');

	}

	public function saveupdate_no_approver_setting($company_id,$setting_approver)
	{
		$this->db->where('company_id',$company_id);
		$q = $this->db->get('form_approval_setting_no_approver');


		$data = array('setting_value' => $setting_approver);

		$this->db->where('company_id',$company_id);
		$insert = $this->db->update('form_approval_setting_no_approver',$data);
		if($this->db->affected_rows() > 0)
		{
			$a_company = $this->session->userdata('company_id');
			$a_employee = $this->session->userdata('employee_id');
			$datenow =date('Y-m-d H:is');
			$details = 'Company id -'.$q->row('company_id')." / (with old setting value - ".$q->row('setting_value')." and updated setting value - ".$setting_approver.")";
			$save_log = $this->logfile_salary_approvers('form_approval',$details,'update',$a_company,$a_employee,$datenow,'logfile_approval_max_no_of_approvers');


	    	return 'updated'; 
		}
		else
			{ return 'error'; }
	}

	public function approver_list()
	{
		$this->db->select('fullname,employee_id,company_name');
		$this->db->from('employee_info');
		$this->db->where('IsApproverChoice','1');
		$this->db->join('company_info','company_info.company_id=employee_info.company_id');
		$query = $this->db->get();
		return $query->result();
	}

	public function delete_approver($id)
	{
		$this->db->where('employee_id',$id);
		$this->data = array('isApproverChoice'=>0);
		$this->db->update("employee_info",$this->data);
		if($this->db->affected_rows() > 0)
		{
			$a_company = $this->session->userdata('company_id');
			$a_employee = $this->session->userdata('employee_id');
			$datenow =date('Y-m-d H:is');
			$details = 'approver choices employee id - '.$id;
			$save_log = $this->logfile_salary_approvers('form_approver_choices',$details,'delete',$a_company,$a_employee,$datenow,'logfile_approval_approver_choices');


	    	return 'deleted'; 
		}
		else
				{ return 'error'; }
	}
	public function add_new_approver_choices($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$this->data = array('isApproverChoice'=>1);
		$this->db->update("employee_info",$this->data);
		if($this->db->affected_rows() > 0)
		{
			$a_company = $this->session->userdata('company_id');
			$a_employee = $this->session->userdata('employee_id');
			$datenow =date('Y-m-d H:is');
			$details = 'approver choices employee id - '.$employee_id;
			$save_log = $this->logfile_salary_approvers('form_approver_choices',$details,'add',$a_company,$a_employee,$datenow,'logfile_approval_approver_choices');


	    	return 'inserted'; 
		}
		else
			{ return 'error'; }
	}
	public function getSearch_EmployeeList($val){//para sa active employees
		$this->db->select("
			A.employee_id,
			A.department,
			B.dept_name,
			A.id,
			concat(A.first_name,' ',A.middle_name,' ',A.last_name) as name
			",false);
		$where = "A.InActive = 0 and A.isEmployee = 1  and 
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

	public function addnew_showSearchResult($val,$company)
	{ 
		//$this->db->where('company_id',$company);
		$this->db->where('isApproverChoice','1');
		$query1 = $this->db->get('employee_info');
		$num_roww = $query1->num_rows();

		if($num_roww == 0){
			$this->db->select('fullname as name,company_info.company_id as company_id,company_name,first_name,middle_name,last_name,employee_info.employee_id,position');
				$this->db->from('company_info');
				$this->db->join("employee_info","employee_info.company_id = company_info.company_id");
				//$this->db->where('company_info.company_id',$company);
				$this->db->where("(`last_name` LIKE '%$val%' OR  `first_name` OR  `employee_id` LIKE '%$val%')");
				$this->db->order_by('last_name','asc');
				$query = $this->db->get();
				return $query->result();

		}
		else{
				$this->db->select('fullname as name,company_info.company_id as company_id,company_name,first_name,middle_name,last_name,employee_info.employee_id,position');
				$this->db->from('company_info');
				$this->db->join("employee_info","employee_info.company_id = company_info.company_id");
				//$this->db->where('company_info.company_id',$company);
				$this->db->where('isApproverChoice',1);
				$this->db->where("(`last_name` LIKE '%$val%' OR  `first_name` OR  `employee_id` LIKE '%$val%')");
				$this->db->order_by('last_name','asc');
				$query = $this->db->get();
				return $query->result();
		}
	}

	public function get_t_forms(){ 
		$this->db->order_by('form_name','asc');
		$this->db->where(array(
			'IsActive'			=>		1,
			'form_type'			=>		'T'
		));
		$query = $this->db->get("transaction_file_maintenance");
		return $query->result();
	}
	public function transaction_details($transaction){ 
		$this->db->order_by('form_name','asc');
		$this->db->where(array(
			'id'			=>		$transaction
		));
		$query = $this->db->get("transaction_file_maintenance");
		return $query->result();
	}
	public function load_division($id){
		$this->db->where(array(
			'company_id'			=>		$id,
			'InActive'				=>		0
		));
		$this->db->order_by('division_name');	
		$query = $this->db->get("division");
		return $query->result();
	}
	public function with_division($id)
	{
		$this->db->where(array(
			'company_id'			=>		$id,
			'wDivision'				=> 		1
		));	
		$query = $this->db->get("company_info");
		return $query->num_rows();
	}
	public function load_dept($id,$company){
		$this->db->where(array(
			'company_id'			=>		$company,
			'division_id'			=>		$id,
			'InActive'				=>		0
		));
		$this->db->order_by('dept_name');	
		$query = $this->db->get("department");
		return $query->result();
	}
	public function load_dept_filter($id,$company){
		
		$this->db->where('company_id',$company);
		$this->db->where('InActive',0);
		if($id=='All'){} else{ $this->db->where('division_id',$id); }
		$this->db->order_by('dept_name');	
		$query = $this->db->get("department");
		return $query->result();
	}

	public function load_section($id,$div,$dept){
		
		$this->db->where(array(
			'department_id'			=>		$dept,
			'InActive'				=>		0
		));	
		$query = $this->db->get("section");
		return $query->result();
	}

	public function load_section_filter($id,$div,$dept){
		
		
		$this->db->where('InActive',0);
		if($dept=='All'){} else{ $this->db->where('department_id',$dept); }
		$query = $this->db->get("section");
		return $query->result();
	}


	public function load_subsections($val)
	{
		$this->db->where(array(
			'section_id'			=>		$val,
			'InActive'				=>		0
		));	
		$query = $this->db->get("subsection");
		return $query->result();
	}

	public function with_subsection($val)
	{
		$this->db->where(array(
			'section_id'			=>		$val,
			'wSubsection'				=> 		1
		));	
		$query = $this->db->get("section");
		return $query->num_rows();
	}

	public function load_locations($company){
			$this->db->where('A.company_id',$company);
			$this->db->order_by('B.location_name','asc');
			$this->db->join("location B","B.location_id = A.location_id","left outer");
			$query = $this->db->get("company_location A");
			return $query->result();
		}
	public function classificationList($val)
	{
		$this->db->where('company_id',$val);
		$query = $this->db->get('classification');
		return $query->result();
	}

	public function approver_setting($val)
	{
		$this->db->where('company_id',$val);
		$query = $this->db->get('form_approval_setting_no_approver');
		return $query->row('setting_value');
	}
	
	public function savenew_approver_trans($company,$division,$department,$section,$subsection,$employee_id,$position,$approval_number,$applyOption,$approvallevel,$identification,$classification,$location,$leavetype)
	{ 
		$with_division = $this->form_approval_model->with_division($company);	
		$f = $this->db->get('transaction_file_maintenance');
		$queryf = $f->result();
		
		if($division=='All' || $department=='All' || $section=='All' || $subsection=='All')
		{

					$this->db->select('wSubsection,company_info.company_id,division.division_id,department.department_id,section.section_id,subsection.subsection_id,division.InActive,department.InActive,section.InActive,subsection.InActive as sec'); 
					$this->db->from('section');
					$this->db->join('subsection','subsection.section_id=section.section_id','left');
					$this->db->join('department','department.department_id=section.department_id');
					$this->db->join('division','division.division_id=department.division_id','left');
					$this->db->join('company_info','company_info.company_id=department.company_id');
					if($with_division==1) { $this->db->where('division.InActive','0'); } else{}
					$this->db->where('department.InActive','0');
					$this->db->where('section.InActive','0');
					$this->db->where('company_info.company_id',$company);
					
					if($division=='All'){}
					else if($department=='All')
					{
						if($division=='not_included') {} else{ $this->db->where('division.division_id',$division); }
						
					}
					//end department all

					//start section all
					elseif($section=='All')
					{
						if($division=='not_included') {} else{ $this->db->where('division.division_id',$division); }
						$this->db->where('department.department_id',$department);
					}
					//end section all

					//start subsection all
					elseif($subsection=='All')
					{
						if($division=='not_included') {} else{ $this->db->where('division.division_id',$division); }
						$this->db->where('department.department_id',$department);
						$this->db->where('section.section_id',$section);
						
					}
					$query = $this->db->get();
					$res = $query->result();


					foreach ($res as $r) {
							if($r->wSubsection==1 AND !empty($r->subsection_id AND $r->sec==0)) { $subsec = $r->subsection_id; } 
					 		elseif ($r->wSubsection==0) { $subsec = 'not_included'; } 
					 		else { $subsec=""; }
					 		
					 		if($with_division==1){ $div =$r->division_id; } else{ $div='not_included'; }

							if($r->wSubsection==1 AND !empty($subsec))
					 				{ 
					 					$iftrue=true;
					 				} 
					 		elseif ($r->wSubsection==0) 
					 				{
					 					$iftrue=true;
					 				}	
							else{ $iftrue=false; }	

							if($iftrue==true)
							{ 
								$insert_approvers = $this->insert_formapprovers($company,$identification,$div,$r->department_id,$r->section_id,$subsec,$employee_id,$approvallevel,$approval_number,$position,$applyOption,$classification,$location,$leavetype);
							}
					} 
		}
		else
		{	
					$data = array('company' => $company,
							  'form_identification' => $identification,
							  'division_id' => $division,
							  'department' => $department,
							  'section' => $section,
							  'sub_section' => $subsection,
							  'approver' => $employee_id,
							  'approval_category' => $approvallevel,
							  'approval_level' => $approval_number,
							  'position' => $position,
							  'setting' => $applyOption,
							  'InActive' => 0,
							  'date_created'=>date('Y-m-d H:i:s'));
					
					$insert_approvers = $this->insert_formapprovers($company,$identification,$division,$department,$section,$subsection,$employee_id,$approvallevel,$approval_number,$position,$applyOption,$classification,$location,$leavetype);
				
		}

		
		//last option
		
	}

	public function locationList($val)
	{
			$this->db->where('A.company_id',$val);
			$this->db->order_by('B.location_name','asc');
			$this->db->join("location B","B.location_id = A.location_id","left outer");
			$query = $this->db->get("company_location A");
			return $query->result();
	}

	public function leavetypeList($val)
	{
		$this->db->where(array('company_id'=>$val,'IsDisabled'=>0));
		$query = $this->db->get("leave_type");
		$query_res =  $query->result();

		$this->db->where('is_system_default',1);
		$query_ = $this->db->get("leave_type");
		$query_res_ =  $query_->result();

		return array_merge($query_res,$query_res_);

	}
	public function approver_list_all()
	{
		$this->db->select('fullname,approver,transaction_approvers.company,
							company_name,approval_level,form_identification,
							employee_info.employee_id,company_info.company_id');
		$this->db->from('transaction_approvers');
		$this->db->join('employee_info','employee_info.employee_id=transaction_approvers.approver');
		$this->db->join('company_info','company_info.company_id=transaction_approvers.company');
		$this->db->where('transaction_approvers.InActive',0);
		$query = $this->db->get();
		return $query->result();
	}
	public function approver_list_all_per_company($company)
	{
		$this->db->select('fullname,approver,transaction_approvers.company,
							company_name,approval_level,form_identification,
							employee_info.employee_id,company_info.company_id,transaction_approvers.company');
		$this->db->from('transaction_approvers');
		$this->db->join('employee_info','employee_info.employee_id=transaction_approvers.approver');
		$this->db->join('company_info','company_info.company_id=transaction_approvers.company');
		$this->db->where('transaction_approvers.InActive',0);
		$this->db->where('transaction_approvers.company',$company);
		$query = $this->db->get();
		return $query->result();
	}


	public function Delete_allapprovers($company)
	{
		
		$employee_id = $this->session->userdata('employee_id');
		$date_deleted = date('Y-m-d H:i:s');
		if($company=='All'){}else{
			$this->db->where('company',$company);
		}
		$data = array('admin_deleted' => $employee_id,
					  'date_deleted' => $date_deleted,
					  'InActive'=>1);
		$this->db->update("transaction_approvers",$data);

	}

	public function approver_details($identification)
	{
		$this->db->select('id');
		$this->db->from('transaction_approvers');
		$this->db->where('transaction_approvers.InActive',0);
		$this->db->where('transaction_approvers.form_identification',$identification);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	public function approver_details_one($id)
	{
		$this->db->select('fullname,approver,transaction_approvers.company,
							company_name,approval_level,form_identification,
							employee_info.employee_id,company_info.company_id,leave_type.leave_type,transaction_approvers.department,transaction_approvers.section,transaction_approvers.id,section_name,subsection_name,dept_name,classification.classification,location_name');
		$this->db->from('transaction_approvers');
		$this->db->join('employee_info','employee_info.employee_id=transaction_approvers.approver');
		$this->db->join('company_info','company_info.company_id=transaction_approvers.company','left');
		$this->db->join('department','department.department_id=transaction_approvers.department');
		$this->db->join('section','section.section_id=transaction_approvers.section');
		$this->db->join('subsection','subsection.subsection_id=transaction_approvers.sub_section','left');
		$this->db->join('leave_type','leave_type.id=transaction_approvers.leave_type','left');
		$this->db->join('classification','classification.classification_id=transaction_approvers.classification');
		$this->db->join('location','location.location_id=transaction_approvers.location');
		$this->db->where('transaction_approvers.InActive',0);
		$this->db->where('transaction_approvers.id',$id);
		$query = $this->db->get();
		return  $query->result();
		
	}
	public function save_transfer_approver($company,$approver,$identification,$transfer_id)
	{ 
		$this->db->where('identification',$identification);
		$query = $this->db->get('transaction_file_maintenance');
		$table_name = $query->row('t_table_name');
		$table_name_approval = $table_name."_approval";

		$this->db->select("*");
		$this->db->from($table_name);
		$this->db->join($table_name_approval,$table_name_approval.".doc_no=".$table_name.".doc_no");
		$this->db->where("company_id",$company);
		$this->db->where($table_name_approval.".status",'pending');
		$this->db->where($table_name.".status",'pending');
		if($transfer_id=='All'){} else{ $this->db->where("approver_id",$transfer_id); }
		$queryq = $this->db->get();
		$update_id = $queryq->result();
	
		foreach($update_id as $row)
		{ 
			$data = array('approver_id'=>$approver , 'date_transferred' => date('Y-m-d H:i:s'));
			$this->db->where('id',$row->id);
			$update = $this->db->update($table_name_approval,$data);
		}
	}

	public function pending_approval($company,$identification)
	{
		$this->db->where('identification',$identification);
		$query = $this->db->get('transaction_file_maintenance');
		$table_name = $query->row('t_table_name');
		$table_name_approval = $table_name."_approval";

		$this->db->select("doc_no");
		$this->db->from($table_name);
		$this->db->where($table_name.".status",'pending');
		$this->db->group_by($table_name.".doc_no");
		$queryq = $this->db->get();
		return $queryq->result();

	}

	

	public function pending_approval_emp($company,$identification)
	{
		$this->db->where('identification',$identification);
		$query = $this->db->get('transaction_file_maintenance');
		$table_name = $query->row('t_table_name');
		$table_name_approval = $table_name."_approval";


		$this->db->select("approver_id");
		$this->db->from($table_name_approval);
		$this->db->where($table_name_approval.".status",'pending');
		$this->db->group_by('approver_id');
		$queryq = $this->db->get();
		return $queryq->result();

	}
	public function pending_approval_emp_comp($company_id,$employee_id)
	{
		$this->db->where('company_id',$company_id);
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info');
		return $query->num_rows();
	}
	public function approver_list_id($doc_no,$identification)
	{
		$this->db->where('identification',$identification);
		$query = $this->db->get('transaction_file_maintenance');
		$table_name = $query->row('t_table_name');
		$table_name_approval = $table_name."_approval";

		$this->db->select("*");
		$this->db->from($table_name_approval);
		$this->db->where($table_name_approval.".doc_no",$doc_no);
		$queryq = $this->db->get();
		return $queryq->result();
	}

	public function doc_no_checker($doc_no,$company,$identification)
	{
		$this->db->where('identification',$identification);
		$query = $this->db->get('transaction_file_maintenance');
		$table_name = $query->row('t_table_name');
		$this->db->where('doc_no',$doc_no);
		$this->db->where('company_id',$company);
		$query1 = $this->db->get($table_name);
		return $query1->row();
	}

	public function name($emp)
	{
		$this->db->where('employee_id',$emp);
		$query = $this->db->get('employee_info');
		return $query->row('fullname');
	}
	public function dept($dept,$option,$id,$ret)
	{
		$this->db->where($id,$dept);
		$query = $this->db->get($option);
		return $query->row($ret);

	}

	//for filtering
	public function filtering($id,$id_name,$table_name)
	{
		$this->db->where($id_name,$id);
		$this->db->where('InActive',0);
		$query = $this->db->get($table_name);
		return $query->result();
	}

	public function filtering_sections($id,$id_name,$table_name,$section_id)
	{
		$this->db->where($id_name,$id);
		$this->db->where('InActive',0);
		if($section_id=='All'){} else{ $this->db->where('section_id',$section_id); }
		$query = $this->db->get($table_name);
		return $query->result();
	}
	public function filtering_div($div,$company)
	{
		
		if($div=='not_included'){} else{ if($div=='All'){} else{ $this->db->where('division_id',$div); }}
		$this->db->where('company_id',$company);
		$this->db->where('InActive',0);
		$query = $this->db->get('department');
		return $query->result();
	}
	public function filtering_dept($company,$div,$dept)
	{
		if($dept=='All'){
			if($div=='All'){ }
			else{ $this->db->where('division_id',$div); }
		}
		else{ $this->db->where('department_id',$dept); }
		$this->db->where('company_id',$company);
		$this->db->where('InActive',0);
		$query = $this->db->get('department');
		return $query->result();
	}

	public function filtering_sec($company,$division,$department,$section)
	{
		
		$this->db->select('A.*,B.*');
		$this->db->from('section A');
		$this->db->join('department B','B.department_id=A.department_id');
		$this->db->where('section_id',$section);
		$query = $this->db->get();
		return $query->result();

	}

	public function approver_data_filter($identification,$company,$division,$department,$section,$subsection)
	{ //echo $company."=".$division."=".$department."=".$section."=".$subsection;
		$this->db->distinct();
		$this->db->select('id');
		$this->db->from('transaction_approvers');
		$this->db->where('company',$company);
		if(empty($division) || $division==0){}
		else{ $this->db->where('division_id',$division); }
		$this->db->where('department',$department);
		$this->db->where('section',$section);
		if(empty($subsection) || $subsection==0){}
		else{ $this->db->where('sub_section',$subsection); }
		$this->db->where('InActive',0);
		$this->db->where('form_identification',$identification);
		$this->db->order_by('sub_section','ASC');
		$query = $this->db->get();
		return $query->result();
	}
	public function sub_namee($sub)
	{
		$this->db->where('subsection_id',$sub);
		$q = $this->db->get('subsection');
		return $q->row('subsection_name');
	}
	public function approver_data_filter_location($identification,$company,$division,$department,$section,$subsection,$location)
	{

		$this->db->select('id');
		$this->db->from('transaction_approvers');
		$this->db->where('company',$company);

		if(empty($division) || $division==0){}
		else{ $this->db->where('division_id',$division); }
		$this->db->where('department',$department);
		$this->db->where('section',$section);
		if($location=='All'){} else { $this->db->where('location',$location); }
		$this->db->where('InActive',0);
		$this->db->where('form_identification',$identification);
		$query = $this->db->get();
		return $query->result();
	}
	public function approver_data_filter_classification($identification,$company,$division,$department,$section,$subsection,$location,$classification)
	{

		$this->db->select('id');
		$this->db->from('transaction_approvers');
		$this->db->where('company',$company);
		if(empty($division) || $division==0){}
		else{ $this->db->where('division_id',$division); }
		$this->db->where('department',$department);
		$this->db->where('section',$section);
		if($location=='All'){} else { $this->db->where('location',$location); }
		if($classification=='All'){} else { $this->db->where('classification',$classification); }
		$this->db->where('InActive',0);
		$this->db->where('form_identification',$identification);
		$query = $this->db->get();
		return $query->result();
	}
	public  function approver_details_filter($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('transaction_approvers');
		$employee_id = $query->row('approver');

		$this->db->select('fullname,employee_id,classification.classification,approval_level,transaction_approvers.location,transaction_approvers.id,location_name,sub_section');
		$this->db->from('transaction_approvers');
		$this->db->join('employee_info','employee_info.employee_id=transaction_approvers.approver');
		$this->db->join('classification','classification.classification_id=transaction_approvers.classification');
		$this->db->join('location','location.location_id=transaction_approvers.location');
		$this->db->where('approver',$employee_id);
		$this->db->where('transaction_approvers.id',$id);
		$res = $this->db->get();
		return $res->result();
	}


	public function section_checker($identification,$company_id,$section_id,$department_id)
	{  
		$this->db->or_where('form_identification',$identification);
		$this->db->or_where('setting','all');
		$this->db->where('company',$company_id);
		$this->db->where('department',$department_id);
		$this->db->where('section','All');
		$query = $this->db->get('transaction_approvers');
		$section = $query->num_rows();
		if($section > 0){ return 'true'; }
		else{

			$this->db->or_where('form_identification',$identification);
			$this->db->or_where('setting','all');
			$this->db->where('company',$company_id);
			$this->db->where('department',$department_id);
			$this->db->where('section','All');
			$query = $this->db->get('transaction_approvers');
			$section = $query->num_rows();
			if($section > 0){ return 'true'; }
			else{

				$this->db->or_where('form_identification',$identification);
				$this->db->or_where('setting','all');
				$this->db->where('company',$company_id);
				$this->db->where('section',$section_id);
				$query1 = $this->db->get('transaction_approvers');
				$section1 = $query1->num_rows();
				if($section1 > 0){ return 'true'; } else{ 

					$this->db->or_where('form_identification',$identification);
					$this->db->or_where('setting','all');
					$this->db->where('company',$company_id);
					$this->db->where('department','All');
					$query2 = $this->db->get('transaction_approvers');
					$section2 = $query2->num_rows();
					if($section2 > 0){ return 'true'; } else{ return 'false'; }
			}
		  }
		}
	}

	//delete
	public function approver_delete_by_department($company,$id,$identification,$name)
	{
		$data = array('InActive' => 1,
						'date_deleted' => date('Y-m-d H:i:s'),
						'admin_deleted' => $this->session->userdata('employee_id'));
		$this->db->where($name,$id);
		$this->db->where('form_identification',$identification);
		$this->db->where('company',$company);
		$update = $this->db->update('transaction_approvers',$data);
	}

	public function approver_delete_by_location($company,$id,$identification,$name,$location)
	{
		$data = array('InActive' => 1,
						'date_deleted' => date('Y-m-d H:i:s'),
						'admin_deleted' => $this->session->userdata('employee_id'));
		$this->db->where($name,$id);
		$this->db->where('form_identification',$identification);
		$this->db->where('company',$company);
		if($location=='All'){} else{ $this->db->where('location',$location); }
		$update = $this->db->update('transaction_approvers',$data);
	}

	public function approver_delete_by_classification($company,$id,$identification,$name,$location,$classification)
	{
		$data = array('InActive' => 1,
						'date_deleted' => date('Y-m-d H:i:s'),
						'admin_deleted' => $this->session->userdata('employee_id'));
		$this->db->where($name,$id);
		$this->db->where('form_identification',$identification);
		$this->db->where('company',$company);
		if($location=='All'){} else{ $this->db->where('location',$location); }
		if($classification=='All'){} else{ $this->db->where('classification',$classification); }
		$update = $this->db->update('transaction_approvers',$data);
	}

	public function approver_delete_by_division($company,$id,$identification,$name,$location,$classification,$division)
	{ 
		$data = array('InActive' => 1,
						'date_deleted' => date('Y-m-d H:i:s'),
						'admin_deleted' => $this->session->userdata('employee_id'));
		$this->db->where($name,$id);
		$this->db->where('form_identification',$identification);
		$this->db->where('company',$company);
		// if($location=='All'){} else{ $this->db->where('location',$location); }
		// if($classification=='All'){} else{ $this->db->where('classification',$classification); }
		// if($division=='All'){} else{ $this->db->where('division_id',$division); }
		$update = $this->db->update('transaction_approvers',$data);
	}

	//check if default/userdefine
	public function UserDefine($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('transaction_file_maintenance');
		return $query->row('company_id');
	}

	public function status_setting_automatic($transaction_id)
	{
		$this->db->where('transaction_id',$transaction_id);
		$this->db->join('company_info B','B.company_id=A.company_id');
		$query = $this->db->get('form_approval_automatic_approved_setting A');
		return $query->result();
	}
	
	public function insert_status_setting_add($transaction_id,$company,$days,$status)
	{
		 $data = array('company_id' => $company,
		 				'transaction_id' => $transaction_id,
		 				'days' => $days,
		 				'action' => $status,
		 				'InActive' => 0,
		 				'date_created' =>  date('Y-m-d'));
		$insert = $this->db->insert('form_approval_automatic_approved_setting',$data);

		if($this->db->affected_rows() > 0)
				{
	    			return 'inserted'; 
				}
				else
					{ return 'error'; }
	}

	public function delete_status_setting($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('form_approval_automatic_approved_setting');
		if($this->db->affected_rows() > 0)
				{
	    			return 'deleted'; 
				}
				else
					{ return 'error'; }
	}

	public function update_status_setting_form_data($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('form_approval_automatic_approved_setting');
		return $query->row(); 
	}

	public function save_status_setting_update($transaction_id,$company,$days,$status,$id)
	{
		$data = array('days' => $days,
						'action' => $status);
		$this->db->where('id',$id);
		$this->db->update('form_approval_automatic_approved_setting',$data);
		if($this->db->affected_rows() > 0)
				{
	    			return 'updated'; 
				}
				else
					{ return 'error'; }
	}

	public function recheck_if_exist_no_approver($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('form_approval_setting_no_approver');
		return $query->num_rows();
	}

	public function request_form_list()
	{
		
		$query = $this->db->get('emp_request_form_list');
		return $query->result();
	}
	public function delete_request_form($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('emp_request_form_list');
	}
	public function status_request_form($id,$option)
	{
		if($option==0){ $s=1; } else{ $s=0; }
		$data = array('InActive'=>$s);
		$this->db->where('id',$id);
		$this->db->update('emp_request_form_list',$data);
	}
	public function add_request_form($form)
	{
		$title = $this->convert_char($form);
		$data = array('title'=>$title,'InActive'=>0);
		$this->db->insert('emp_request_form_list',$data);
	}

	public function request_form_list_one($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('emp_request_form_list');
		return $query->result();
	}
	public function saveupdate_request_form($id,$form)
	{
		$title = $this->convert_char($form);
		$data = array('title'=>$title);
		$this->db->where('id',$id);
		$this->db->update('emp_request_form_list',$data);
	}
		public function convert_char($title)
	{
		$a = str_replace("-a-","?",$title);
		$b = str_replace("-b-","!",$a);
		$c = str_replace("-c-","/",$b);
		$d = str_replace("-d-","|",$c);
		$e = str_replace("-e-","[",$d);
		$f = str_replace("-f-","]",$e);
		$g = str_replace("-g-","(",$f);
		$h = str_replace("-h-",")",$g);
		$i = str_replace("-i-","{",$h);
		$j = str_replace("-j-","}",$i);

		$k = str_replace("-k-","'",$j);
		$l = str_replace("-l-",",",$k);
		$m = str_replace("-m-","'",$l);
		$n = str_replace("-n-","_",$m);

		$o = str_replace("-o-","@",$n);
		$p = str_replace("-p-","#",$o);
		$q = str_replace("-q-","%",$p);
		$r = str_replace("-r-","$",$q);

		$s = str_replace("-s-","^",$r);
		$t = str_replace("-t-","&",$s);
		$u = str_replace("-u-","*",$t);
		$v = str_replace("-v-","+",$u);

		$w = str_replace("-w-","=",$v);
		$x = str_replace("-x-",":",$w);
		$y = str_replace("-y-",";",$x);
		$z = str_replace("-z-"," ",$y);
		
		$aa = str_replace("-zz-",".",$z);
		$bb = str_replace("-aa-","<",$aa);
		$cc = str_replace("-bb-",">",$bb);
		$dd = str_replace("%20"," ",$cc);
		return $dd;

	}



	
	//for notifications

	public function get_notifications_forms()
	{
		$this->db->where(array('IsActive'=>1,'issuance_type'=>1));
		$query = $this->db->get('notification_file_maintenance');
		return $query->result();
	}

	public function loadNotification($company)
	{
		$this->db->where(array('company_id'=>$company,'issuance_type'=>1));
		$query = $this->db->get('notification_file_maintenance');
		return $query->result();


	}

	public function savenew_approver_notification($type,$company,$division,$department,$section,$subsection,$employee_id,$classification,$approval_number,$approvallevel,$location,$notification)
	{ 
		$with_division = $this->form_approval_model->with_division($company);	
		
		//start division all
		if($division=='All')
		{	
			$res = $this->get_all_details('division',$with_division,$company,$division,$department,$section);
		}
		//end of all division

		//start of department;

		else if($department=='All')
		{
			$res = $this->get_all_details('department',$with_division,$company,$division,$department,$section);

				
		}

		//end of department

		//start of section
		else if($section=='All')
		{
			$res = $this->get_all_details('section',$with_division,$company,$division,$department,$section);

		}
		//end of section

		//start of subsection all
		else if($subsection=='All')
		{
				$res = $this->get_all_details('subsection',$with_division,$company,$division,$department,$section);

			
		} //end of subsection all
		else{ }


		//saving for all options
		if($division=='All' || $department=='All' || $section=='All' || $subsection=='All')
		{
			foreach ($res as $r) 
					{

	
							if($r->wSubsection==1 AND !empty($r->subsection_id AND $r->sec==0))
			 				{
			 					$subsec = $r->subsection_id;
			 				} elseif ($r->wSubsection==0) {
			 					$subsec = 'not_included';
			 				} else{$subsec="";}
			 				if($with_division==1){ $div =$r->division_id; } else{ $div='not_included'; }

			 				$check_if_exist = $this->check_if_notif_Approver_exist($company,$location,$div,$r->department_id,$r->section_id,$subsec,$classification,$employee_id,$approvallevel,$approval_number,'0',$notification);
			 				if($check_if_exist > 0){}
			 				else
			 				{ 
			 					if($r->wSubsection==1 AND !empty($subsec))
					 				{
					 					$insert = $this->save_new_approver($company,$location,$div,$r->department_id,$r->section_id,$subsec,$classification,$employee_id,$approvallevel,$approval_number,'0',$notification);
					 				} 
					 				elseif ($r->wSubsection==0) {
					 					$insert = $this->save_new_approver($company,$location,$div,$r->department_id,$r->section_id,$subsec,$classification,$employee_id,$approvallevel,$approval_number,'0',$notification);
					 				}

									else{ }
			 					
			 				}

					}
		}
		else
		{
			$check_if_exist = $this->check_if_notif_Approver_exist($company,$location,$division,$department,$section,$subsection,$classification,$employee_id,$approvallevel,$approval_number,'0',$notification);
			if($check_if_exist > 0){}
			else
			 	{ 
			 		$insert = $this->save_new_approver($company,$location,$division,$department,$section,$subsection,$classification,$employee_id,$approvallevel,$approval_number,'0',$notification);		
			 	}		
		}
		
			
	}


	public function check_if_notif_Approver_exist($company,$location,$div,$department_id,$section_id,$subsec,$classification,$employee_id,$approvallevel,$approval_number,$stat,$notification)
	{
			$data = array(
								  'company' => $company,
						 		  'location' => $location,
								  'notification' => $notification,
								  'division_id' => $div,
								  'department' => $department_id,
								  'section' => $section_id,
								  'sub_section' => $subsec,
								  'classification' => $classification,
								  'approver' => $employee_id,
								  'approval_category' => $approvallevel,
								  'approval_level' => $approval_number,
								  'InActive' => $stat);
							$this->db->where($data);

				$exist = $this->db->get('notifications_approvers');
				$num_exist = $exist->num_rows();
				return $num_exist;
			
		
			
	}
	public function save_new_approver($company,$location,$div,$department_id,$section_id,$subsec,$classification,$employee_id,$approvallevel,$approval_number,$stat,$notification)
	{
				$data = array(
								  'company' => $company,
						 		  'location' => $location,
								  'notification' => $notification,
								  'division_id' => $div,
								  'department' => $department_id,
								  'section' => $section_id,
								  'sub_section' => $subsec,
								  'classification' => $classification,
								  'approver' => $employee_id,
								  'approval_category' => $approvallevel,
								  'approval_level' => $approval_number,
								  'InActive' => $stat,
								  'date_created'=>date('Y-m-d H:i:s'));
				$this->db->insert('notifications_approvers',$data);
				
	}
	public function get_all_details($option,$with_division,$company,$division,$department,$section)
	{
			$this->db->select('wSubsection,company_info.company_id,division.division_id,department.department_id,section.section_id,subsection.subsection_id,division.InActive,department.InActive,section.InActive,subsection.InActive as sec'); 
			$this->db->from('section');
			$this->db->join('subsection','subsection.section_id=section.section_id','left');
			$this->db->join('department','department.department_id=section.department_id');
			$this->db->join('division','division.division_id=department.division_id','left');
			$this->db->join('company_info','company_info.company_id=department.company_id');

			if($option=='division')
			{
				if($with_division==1) { $this->db->where('division.InActive','0'); } else{}
			}
			elseif($option=='department'){
				if($with_division==1) { $this->db->where('division.InActive','0'); } else{}
				if($division=='not_included') {} else{ $this->db->where('division.division_id',$division); }
			}
			else if($option=='section')
			{
				if($with_division==1) { $this->db->where('division.InActive','0'); } else{}
				if($division=='not_included') {} else{ $this->db->where('division.division_id',$division); }
				$this->db->where('department.department_id',$department);
			}
			else if($option=='subsection')
			{
				if($with_division==1) { $this->db->where('division.InActive','0'); } else{}
				if($division=='not_included') {} else{ $this->db->where('division.division_id',$division); }
				$this->db->where('department.department_id',$department);
				$this->db->where('section.section_id',$section);
			}
			
			$this->db->where('department.InActive','0');
			$this->db->where('section.InActive','0');
			$this->db->where('company_info.company_id',$company);
			$query = $this->db->get();
			return $query->result();
	}

	public function get_with_approver_notifications($company,$notif)
	{
		if($notif=='all'){}
		else
		{ 
			$this->db->where('id',$notif); 
		}
		$this->db->where(array('company_id'=>$company,'issuance_type'=>1));
		$query = $this->db->get('notification_file_maintenance');
		return $query->result();
	}

	public function get_approver_by_notifications($notif,$company)
	{
		$this->db->select('a.*,b.*,c.classification as cname,d.location_name,e.section_name,f.subsection_name,a.id as iddd,a.InActive as ia');
		$this->db->join('employee_info b','b.employee_id=a.approver');
		$this->db->join('classification c','c.classification_id=b.classification');
		$this->db->join('location d','d.location_id=b.location');
		$this->db->join('section e','e.section_id=b.section');
		$this->db->join('subsection f','f.subsection_id=b.subsection','left');
		$this->db->where(array('a.notification'=>$notif,'a.company'=>$company));
		$this->db->order_by('a.	date_created','ASC');
		$query = $this->db->get('notifications_approvers a');
		return $query->result();
	}

	public function approver_action($action,$id,$notif,$company)
	{
		if($action=='delete')
		{
			$this->db->where('id',$id);
			$this->db->update('notifications_approvers',array('date_deleted'=>date('Y-m-d')));
		}
		else if($action=='enable')
		{
			$this->db->where('id',$id);
			$this->db->update('notifications_approvers',array('InActive'=>0));
		}
		elseif($action=='disable')
		{
			$this->db->where('id',$id);
			$this->db->update('notifications_approvers',array('InActive'=>1));
		}
	}

	public function logfile_salary_approvers($type,$details,$action,$company,$employee,$datenow,$table)
	{		
			$data = array('type'=>$type,'details'=>$details,'action'=>$action,'company_id'=>$company,'employee_id'=>$employee,'datetime'=>date('Y-m-d H:i:s'));
			$insert = $this->db->insert($table,$data);
	}

	//end of notifications




	//for viewing of approvers by division to subsection

	public function with_department_viewing($company_id,$department)
	{
		$this->db->where(array('company_id'=>$company_id,'InActive'=>0));
		if($department=='All'){} else{ $this->db->where('department_id',$department); }
		$query = $this->db->get('department');
		return $query->result();
	}

	public function get_all_transactions_list($company,$division,$department,$section,$subsection,$trans_id,$classification,$location,$leavetype)
	{
		$this->db->select('a.*,b.location_name,c.classification as classification_name,d.*,e.leave_type as leave_type,a.id as transaction_id');
		$this->db->join('location b','b.location_id=a.location');
		$this->db->join('classification c','c.classification_id=a.classification');
		$this->db->join('employee_info d','d.employee_id=a.approver');
		$this->db->join('leave_type e','e.id=a.leave_type','left');

		$this->db->where(array('a.company'=>$company,'a.department'=>$department,'a.division_id'=>$division,'a.section'=>$section,'a.sub_section'=>$subsection,'form_identification'=>$trans_id));

		$this->db->where(array('date_deleted'=>Null,'admin_deleted'=>Null));
		if($classification=='All'){ } else{ $this->db->where('a.classification',$classification); }
		if($location=='All'){ } else { $this->db->where('a.location',$location); }
		if($leavetype=='All' || $leavetype=='not_included'){} else{ $this->db->where('a.leave_type',$leavetype); }

		$query = $this->db->get('transaction_approvers a');
		return $query->result();
	}

	public function get_identification($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('transaction_file_maintenance',1);
		return $query->row('identification');
	}













	//updated adding of approvers

	public function insert_formapprovers($company,$identification,$div,$department_id,$section_id,$subsec,$employee_id,$approvallevel,$approval_number,$position,$applyOption,$classification,$location,$leavetype)
	{

		$loc = $this->get_location_for_adding($location,$company);
		$clas = $this->get_classification_for_adding($classification,$company);
		$trans = $this->get_transaction_for_adding($applyOption,$company,$identification);
		$leave = $this->get_leave_for_adding($leavetype,$company);

		foreach($loc as $l) 
		{
			foreach($clas as $c)
			{
				foreach($trans as $t)
				{
					if($t->identification=='HR002')
					{
						
						foreach($leave as $ll)
						{
							$data = array(  'company' 			=> $company,
									'form_identification' 		=> $t->identification,
									'division_id'				=> $div,
									'department'			 	=> $department_id,
									'section' 					=> $section_id,
									'sub_section'				=> $subsec,
									'approver' 					=> $employee_id,
									'approval_category' 		=> $approvallevel,
									'approval_level'	 		=> $approval_number,
									'position' 					=> $position,
									'location'					=> $l->location_id,
									'classification' 			=> $c->classification_id, 
									'setting' 					=> $applyOption,
									'leave_type'				=>	$ll->id,
									'InActive' 					=> 0,
									'date_created'				=>date('Y-m-d H:i:s'));
							$data_checker = array(  'company' => $company,'form_identification' => $t->identification,'division_id' => $div,'department' => $department_id,'section' => $section_id,'sub_section' => $subsec,'approver' => $employee_id,'position' => $position,'InActive' => 0,'location'=>$l->location_id,'classification'=>$c->classification_id,'leave_type'=>$ll->id,'approval_level'=>$approval_number);
							
							$this->db->where($data_checker);
							$query = $this->db->get('transaction_approvers');

							if($query->num_rows() > 0){}
							else { $this->db->insert('transaction_approvers',$data);  }
						}
					}
					else
					{
						$data = array(  'company' 				=> $company,
									'form_identification' 		=> $t->identification,
									'division_id'				=> $div,
									'department'			 	=> $department_id,
									'section' 					=> $section_id,
									'sub_section'				=> $subsec,
									'approver' 					=> $employee_id,
									'approval_category' 		=> $approvallevel,
									'approval_level'	 		=> $approval_number,
									'position' 					=> $position,
									'location'					=> $l->location_id,
									'classification' 			=> $c->classification_id, 
									'setting' 					=> $applyOption,
									'leave_type'				=>	'not_included',
									'InActive' 					=> 0,
									'date_created'				=>date('Y-m-d H:i:s'));
						$data_checker = array(  'company' => $company,'form_identification' => $t->identification,'division_id' => $div,'department' => $department_id,'section' => $section_id,'sub_section' => $subsec,'approver' => $employee_id,'position' => $position,'InActive' => 0,'location'=>$l->location_id,'classification'=>$c->classification_id,'leave_type'=>'not_included','approval_level'=>$approval_number);
						
						$this->db->where($data_checker);
						$query = $this->db->get('transaction_approvers');

						if($query->num_rows() > 0){}
						else { $this->db->insert('transaction_approvers',$data);  }
					}
					
				}
			}
		}	
	}

	public function get_location_for_adding($location,$company)
	{
			if($location=='All'){} else{ $this->db->where('A.location_id',$location); }
			$this->db->where('A.company_id',$company);
			$this->db->order_by('B.location_name','asc');
			$this->db->join("location B","B.location_id = A.location_id","left outer");
			$query = $this->db->get("company_location A");
			return $query->result();
	}

	public function get_classification_for_adding($classification,$company)
	{
			if($classification=='All'){} else{ $this->db->where('classification_id',$classification); }
			$this->db->where('company_id',$company);
			$query = $this->db->get('classification');
			return $query->result();
	}

	public function get_transaction_for_adding($applyOption,$company,$identification){ 
		
		$this->db->order_by('form_name','asc');
		if($applyOption=='all'){} else{ $this->db->Where('identification',$identification); }
		$this->db->where(array(
			'IsActive'			=>		1,
			'form_type'			=>		'T'
		));
		$query = $this->db->get("transaction_file_maintenance");
		return $query->result();
	}
	public function get_leave_for_adding($leavetype,$company)
	{
		if($leavetype=='All' || $leavetype=='not_included'){}
		else{ $this->db->where('id',$leavetype); }
		$this->db->where('company_id',$company);
		$query = $this->db->get("leave_type");
		$query_res =  $query->result();

		if($leavetype=='All' || $leavetype=='not_included'){}
		else{ $this->db->where('id',$leavetype); }
		$this->db->where('is_system_default',1);
		$query_ = $this->db->get("leave_type");
		$query_res_ =  $query_->result();

		return array_merge($query_res,$query_res_);
	}

	// new june 19 
	public function get_transfer_table_name($identification)
	{
		$this->db->where('identification',$identification);
		$query = $this->db->get('transaction_file_maintenance');
		$table_name = $query->row('t_table_name');
		return $table_name;
	}

	public function get_departmentlist($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('department');
		return $query->result();
	}

	public function delete_selected_approver($selected)
	{
		$id = $final_req = substr_replace($selected, "", -1);
		$ids= explode('-',$id);
		$employee_id = $this->session->userdata('employee_id');
		foreach($ids as $d)
		{
			$data = array('admin_deleted' => $employee_id,
					  'date_deleted' => date('Y-m-d H:i:s'),
					  'InActive'=>1);
			$this->db->where('id',$d);
			$this->db->update("transaction_approvers",$data);

		}
		
	}



	//new form filtering


	public function get_approver_viewing($company,$transaction)
	{
		if($transaction!='All')
		{
			$form_identification=$this->transaction_form_identification($transaction);
			
		}
		$this->db->distinct();
		$this->db->select('approver');
		$this->db->where(array('date_deleted'=>Null,'admin_deleted'=>Null));
		if($company!='All'){ $this->db->where('company',$company); }
		if($transaction!='All')
		{
			$this->db->where('form_identification',$form_identification); 
		}
		$query = $this->db->get('transaction_approvers');
		$res = $query->result();
		foreach($res as $n)
		{
			$n->fullname = $this->get_employee_name($n->approver);
		}
		echo $form_identificationl;
		return $res;
	}

	public function transaction_form_identification($transaction)
	{
		$this->db->where('id',$transaction);
		$query = $this->db->get('transaction_file_maintenance',1);
		return $query->row('identification');
	}
	public function get_employee_name($approver)
	{
		$this->db->select("concat(first_name,' ',last_name) as fullname");	
		$this->db->where('employee_id',$approver);
		$query = $this->db->get('employee_info');
		return $query->row('fullname');
	}

	public function get_all_form_transactions_list($company,$division,$department,$section,$subsection,$trans_id,$classification,$location,$leavetype,$approver)
	{
		$this->db->select('a.*,b.location_name,c.classification as classification_name,d.*,e.leave_type as leave_type,a.id as transaction_id,f.form_name');
		$this->db->join('location b','b.location_id=a.location');
		$this->db->join('classification c','c.classification_id=a.classification');
		$this->db->join('employee_info d','d.employee_id=a.approver');
		$this->db->join('leave_type e','e.id=a.leave_type','left');
		$this->db->join('transaction_file_maintenance f','f.identification=a.form_identification');
		$this->db->where(array('a.company'=>$company,'a.department'=>$department,'a.division_id'=>$division,'a.section'=>$section,'a.sub_section'=>$subsection));
		$this->db->where(array('date_deleted'=>Null,'admin_deleted'=>Null));
		if($classification=='All'){ } else{ $this->db->where('a.classification',$classification); }
		if($location=='All'){ } else { $this->db->where('a.location',$location); }
		if($leavetype=='All' || $leavetype=='not_included'){} else{ $this->db->where('a.leave_type',$leavetype); }
		if(empty($trans_id)){} else{ $this->db->where('form_identification',$trans_id); }
		if($approver=='All' || $approver=='not_included'){} else{ $this->db->where('a.approver',$approver); }
		$query = $this->db->get('transaction_approvers a');
		return $query->result();
	}
	//dep div company 

	public function with_department_division_viewing($company_id,$department,$division_id)
	{
		$this->db->where(array('company_id'=>$company_id,'InActive'=>0));
		if($department=='All'){} else{ $this->db->where('department_id',$department); }
		$this->db->where('division_id',$division_id);
		$query = $this->db->get('department');
		return $query->result();
	}

	public function load_division_department($company_id,$department)
	{
		if($department != 'All')
		{	
			$this->db->where('department_id',$department);
			$query = $this->db->get('department');
			$division_id = $query->row('division_id');
			if(!empty($division_id))
			{
				$this->db->where('division_id',$division_id);
			}
		}
		
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('division');
		  return $query->result();
			
	}

}