<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Transaction_employees_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	//==================================assigned employeee transaction filing

	//apply leave cpntrols
	public function getLeaveType(){ 
		$this->db->order_by('leave_type','asc');
		$this->db->where(array(
			'IsDisabled'			=>		0
		));	
		$query = $this->db->get("leave_type");
		return $query->result();
	}
	public function getStringLeave($s_leave){ 
		$this->db->order_by('leave_type','asc');
		$this->db->where(array(
			'IsDisabled'			=>		0,
			'id'					=>		$s_leave
		));	
		$query = $this->db->get("leave_type");
		return $query->result();
	}

	public function getSec($dept_id){ 
		$this->db->where(array(
			'department_id'			=>		$dept_id,
			'InActive'				=>		0
		));	
		$query = $this->db->get("section");
		return $query->result();
	}

	public function getSearch_Employee($val){
		$this->db->select("
			A.employee_id,
			A.department,
			B.dept_name,
			A.id,
			concat(A.first_name,' ',A.middle_name,' ',A.last_name) as name
			",false);
		$where = "A.InActive = 0 and 
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

	public function get_selected_emp($selected_emp){ 
		$this->db->where(array(
			'InActive'			=>		0,
			'employee_id'		=>		$selected_emp
		));
		$query = $this->db->get("employee_info");
		return $query->result();
	}
	public function save_edit_sending_email($tse_id){ 
		$cd=date('Y-m-d');
		$this->db->where('id',$tse_id);
		$this->data = array(
			'email'				=>		$this->input->post('email'),
			'applied'			=>		$this->input->post('during_applied'),
			'approved'			=>		$this->input->post('during_approved'),
			'cancelled'			=>		$this->input->post('during_cancelled'),
			'rejected'			=>		$this->input->post('during_rejected'),
			'date_created'		=>	$cd,
			);
		$this->db->update("transaction_sending_email",$this->data);	
	}
	public function save_sending_email(){
		$cd=date('Y-m-d');
		$this->data = array(
			'employee_id'		=>		$this->input->post('assigned_employee'),
			'email'				=>		$this->input->post('email'),
			'form_identification'	=>		$this->input->post('form'),
			'applied'			=>		$this->input->post('during_applied'),
			'approved'			=>		$this->input->post('during_approved'),
			'cancelled'			=>		$this->input->post('during_cancelled'),
			'rejected'			=>		$this->input->post('during_rejected'),
			'date_created'		=>	$cd,
			'InActive'			=>		0
		);	
		$this->db->insert("transaction_sending_email",$this->data);
	}
	public function save_filer(){
		
		$this->data = array(
			'company'			=>		1,
			'location'			=>		$this->input->post('location'),
			'form_identification'		=>		$this->input->post('form'),
			'department'		=>		$this->input->post('department'),
			'section'			=>		$this->input->post('section'),
			'classification'	=>		$this->input->post('classification'),
			'employee_id'		=>		$this->input->post('assigned_employee'),
			'position'			=>		$this->input->post('position'),
			//'setting'			=>		$this->input->post('option'),
			'InActive'			=>		0
		);	
		$this->db->insert("transaction_assigned_filing",$this->data);
	}
	//== assigned transaction filers/filling
	public function getFilers($dep,$sec,$current_class,$location,$current_doc){	
		$query=$this->db->query("SELECT concat(employee_info.last_name,', ',employee_info.first_name,' ',employee_info.middle_name) as name ,transaction_assigned_filing.*,position.* FROM transaction_assigned_filing INNER JOIN employee_info ON (employee_info.employee_id=transaction_assigned_filing.employee_id) INNER JOIN position ON (transaction_assigned_filing.position=position.position_id) WHERE transaction_assigned_filing.InActive='0' AND (transaction_assigned_filing.location='".$location."' OR transaction_assigned_filing.location='all') AND (transaction_assigned_filing.department='".$dep."' OR transaction_assigned_filing.department='all') AND (transaction_assigned_filing.section='".$sec."' OR transaction_assigned_filing.section='all') AND (transaction_assigned_filing.classification='".$current_class."' OR transaction_assigned_filing.classification='all') AND (transaction_assigned_filing.form_identification='".$current_doc."' OR transaction_assigned_filing.form_identification='all') order by transaction_assigned_filing.id ASC");
			return $query->result();
	}
	public function curLoc($place){//get current location 
		$this->db->where(array(
			'location_id'			=>		$place,
			'InActive'				=>		0
		));	
		$query = $this->db->get("location");
		return $query->result();
	}
	public function getLoc( ){ 
		$this->db->where('InActive',0);
		$this->db->order_by('location_name','asc');
		$query = $this->db->get("location");
		return $query->result();
	}
	//==================================assigned employeee transaction filing
	//== for listing
	public function getAll( ){ 
		$this->db->order_by('form_name','asc');
		//$this->db->where('IsActive','1');
		$this->db->where(array(
			'IsActive'			=>		1,
			'form_type'			=>		'T'
		));
		$query = $this->db->get("transaction_file_maintenance");
		return $query->result();
	}
	// transaction sending email
	public function tran_send_email_getAll( ){ 
		// $this->db->select("
		// 	A.*,B.*,C.*,
		// 	concat(C.last_name,', ',C.first_name,' ',C.middle_name) as name
		// 	",false);
		// $this->db->order_by('A.id','asc');
		// $this->db->where('A.InActive','0');
		// $this->db->join("employee_info C","C.employee_id = A.employee_id","left outer");
		// $this->db->join("transaction_sending_email_location B","B.tran_send_email_id = A.id","left outer");
		// $query = $this->db->get("transaction_sending_email A");
		$this->db->select("
			A.*,B.*,A.id as trans_id,
			concat(B.last_name,', ',B.first_name,' ',B.middle_name) as name
			",false);
		$this->db->order_by('A.id','asc');
		$this->db->where('A.InActive','0');
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("transaction_sending_email A");

		// $this->db->where('B.InActive','0');
		// //$this->db->join("employee_info C","C.employee_id = B.employee_id","left outer");
		// $this->db->join("transaction_sending_email B","B.form_identification = A.tran_send_email_id","left outer");
		// $query = $this->db->get("transaction_sending_email_location A");
		return $query->result();
	}

	// transaction sending email
	public function tran_send_email_location($cur_form,$location_id){ 
		$this->db->where('A.transaction',$cur_form);

		$this->db->where(array(
			'A.transaction'			=>		$cur_form,
			'A.tran_send_email_location'	=>		$location_id
		));	
		$this->db->join("location B","B.location_id = A.tran_send_email_location","left outer");
		$query = $this->db->get("transaction_sending_email_location A");
		return $query->result();
	}

	//== for late filing
	public function get_late_filing_trans( ){ 
		$this->db->order_by('form_name','asc');
//		$this->db->where('IsActive','1');		
		$this->db->where(array(
			'IsActive'			=>		'1',
			'page_unique_feature'	=>		'late_filing'
		));	
		$query = $this->db->get("transaction_file_maintenance");
		return $query->result();
	}

	public function save_late_fil_tran_opt($late_filing_option,$identification){ 
		$this->db->where(array(
			'identification'	=>		$this->input->post('identification')
		));	
		$this->data = array(
			'late_filing'	=>	$this->input->post('late_filing_option')
			);
		$this->db->update("transaction_file_maintenance",$this->data);	
	}

	public function delete_sending_email($id){
		$this->db->where('id',$id);
		$this->data = array('InActive'=>1);
		$this->db->update("transaction_sending_email",$this->data);	
	}
	//== for editing
	public function get_sending_email($id){ 
		//se_id : sending email id
		$this->db->select("
			A.*,B.*,A.id as se_id,A.email as se_email, 
			concat(B.last_name,', ',B.first_name,' ',B.middle_name) as name
			",false);
		$this->db->where(array(
			'A.id'	=>		$id
		));
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get('transaction_sending_email A');
		return $query->result();		
	}	
	public function save_app_leave_pay_opt($leave_pay_option,$identification){ 
		$this->db->where(array(
			'identification'	=>		$identification
		));	
		$this->data = array(
			'leave_pay_option'	=>	$leave_pay_option
			);
		$this->db->update("transaction_file_maintenance",$this->data);	
	}
	public function get_transaction_last_id($t_table_name){ 
		$this->db->order_by('id','DESC');
		$this->db->limit(1);
		$query = $this->db->get($t_table_name,'LIMIT 1');
		return $query->row();		
	}
	public function get_form_db(){ 
		$this->db->where(array(
			'IsActive'			=>		'1',
			'page_unique_feature'	=>		'leave_pay_option'
		));	
		$query = $this->db->get("transaction_file_maintenance");
		return $query->row();
	}
	public function get_form_with_mass_encoding(){ 
		$this->db->where(array(
			'IsActive'			=>		'1',
			'form_type'			=>		'T',
			'mass_encoding'	=>		'1'
		));	
		$query = $this->db->get("transaction_file_maintenance");
		return $query->result();	
	}
	public function mass_tran_enc_rec($location,$clas,$dept,$sect){ 
		// $form = $this->input->post('form');
		// $location = $this->input->post('location');
		// $clas = $this->input->post('classification');
		// $dept = $this->input->post('department');
		// $sect = $this->input->post('section');
		// $date_from = $this->input->post('date_from');
		// $date_to = $this->input->post('date_to');
		//$mass_encode_option = $this->input->post('mass_encode_option');

		if(($location=="all")||($location=="All")||($location=="ALL")||($location=="aLl")||($location=="alL")){
			$final_loc="";
		}else{
			$final_loc=" AND employee_info.location='".$location."' ";
		}

		if(($clas=="all")||($clas=="All")||($clas=="ALL")||($clas=="aLl")||($clas=="alL")){
			$final_clas="";
		}else{
			$final_clas=" AND employee_info.classification='".$clas."' ";
		}
		if(($dept=="all")||($dept=="All")||($dept=="ALL")||($dept=="aLl")||($dept=="alL")){
			$final_dept="";
			$final_sect="";
		}else{
			$final_dept=" AND employee_info.department='".$dept."' ";
			$final_sect=" AND employee_info.section='".$sect."' ";
		}

		$query=$this->db->query("SELECT employee_info.*,position.*,
			concat(employee_info.last_name,', ',employee_info.first_name,' ',employee_info.middle_name) as name FROM employee_info INNER JOIN position ON (employee_info.position=position.position_id) WHERE employee_info.InActive='0' ".$final_loc."".$final_clas."".$final_dept."".$final_sect." ");

		return $query->result();	
	}
	public function get_working_sched_complete($classification){
		// $this->db->where(array(
		// 	'classification'	=>		$classification,
		// 	'InActive'			=>		0
		// ));	
		// $this->db->order_by('time_in','ASC');
		// $query = $this->db->get("working_schedule_ref_complete");
		$query=$this->db->query("SELECT  classification,time_in,time_out,InActive FROM working_schedule_ref_complete where classification='".$classification."' AND InActive='0' UNION SELECT classification,time_in,time_out,InActive FROM working_schedule_ref_half where classification='".$classification."' AND InActive='0'");

		return $query->result();	
	}
	public function get_working_sched_half($classification){
		$this->db->where(array(
			'classification'	=>		$classification,
			'InActive'			=>		0
		));	
		$this->db->order_by('time_in','ASC');
		$query = $this->db->get("working_schedule_ref_half");

		return $query->result();	
	}
	public function get_holiday_type($ht){
		$this->db->where(array(
			'code'	=>		$ht,
			'cCode'	=>		'holiday_type'
		));	
		$query = $this->db->get("system_parameters");
		return $query->row();
	}
	public function validate_date($month,$day){

		$company_name=$this->session->userdata('company_id');
		$date=$month.$day;
		$query = $this->db->query("SELECT * FROM holiday_list  INNER JOIN system_parameters ON (holiday_list.type=system_parameters.code) WHERE CONCAT(TRIM(holiday_list.month),TRIM(holiday_list.day))='".$date."' and holiday_list.company_id ='".$company_name."' and holiday_list.InActive= 0 AND system_parameters.cCode='holiday_type'");
		return $query->result();	
	}
	public function get_form_form_name($value){ //used in send_email_rec && transaction_employees
		$this->db->where(array(
			'identification'	=>		$value
		));	
		$query = $this->db->get("transaction_file_maintenance");
		return $query->row();
	}

	public function get_emp($current_form){ 
		//kukunin nya lang yung mga employees na hindi pa approvers of the current form
		$query = $this->db->query("SELECT *,concat(p.last_name,', ',p.first_name,' ',p.middle_name) as name FROM employee_info p WHERE p.InActive=0 AND p.employee_id NOT IN (SELECT approver
                   FROM transaction_approvers od
                   WHERE  p.employee_id = od.approver AND od.InActive=0 AND od.form_identification='".$current_form."')  ");
		return $query->result();
	}
	public function save_transfer_approval($position){ 
		$this->db->where(array(
			'form_identification'	=>		$this->input->post('cur_form'),
			'approver'				=>		$this->input->post('from_approver')
		));	
		$this->data = array(
			'approver'	=>	$this->input->post('to_approver'),
			'position'	=>	$position
			);
		$this->db->update("transaction_approvers",$this->data);	
	}
	public function get_old_app_info($from_approver){ 
		$this->db->select("
			A.*,B.*,
			concat(A.last_name,', ',A.first_name,' ',A.middle_name) as name
			",false);
		$this->db->where(array(
			'A.employee_id'	=>		$from_approver
		));	
		$this->db->join("position B","B.position_id = A.position","left outer");
		$query = $this->db->get("employee_info A");
		return $query->row();
	}
	public function get_new_app_info($new_approver){ 
		$this->db->select("
			A.*,B.*,
			concat(A.last_name,', ',A.first_name,' ',A.middle_name) as name
			",false);
		$this->db->where(array(
			'A.employee_id'	=>		$new_approver
		));	
		$this->db->join("position B","B.position_id = A.position","left outer");
		$query = $this->db->get("employee_info A");
		return $query->row();
	}
	//get all transactions 
	public function get_transaction_on_history($t_table_name){
		$this->db->order_by('date_created','DESC');
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get($t_table_name." A");
		return $query->result();
	}
	public function count_transaction_on_history($t_table_name){ 
		$this->db->order_by('A.date_created','DESC');
		$query = $this->db->get($t_table_name." A");
		return $query->result();		
	}
	//get all transactions regardless of status except moved to history
	public function count_transaction($t_table_name){ 
		$this->db->where(array(
			'A.IsDeleted'			=>		0
		));	
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get($t_table_name." A");
		return $query->result();		
	}
	//get all transactions regardless of status NOT filed via mass_encoding (automatic approve)
	public function count_transaction_none_mass_encoding($t_table_name){ 
		$query = $this->db->query("SELECT * FROM ".$t_table_name." A INNER JOIN employee_info B ON (B.employee_id=A.employee_id) WHERE A.IsDeleted = '0' AND A.entry_type NOT LIKE 'mass encoding%' ");
		return $query->result();		
	}
	//get all transactions regardless of status filed via mass_encoding (automatic approve)
	public function get_transaction_with_mass_encoding($t_table_name){ 
		$query = $this->db->query("SELECT * FROM ".$t_table_name." INNER JOIN employee_info ON (".$t_table_name.".employee_id=employee_info.employee_id) WHERE IsDeleted = '0' AND entry_type LIKE 'mass encoding%' ");
		return $query->result();		
	}
	//get all cancelled / pending transactions for approving
	public function to_approve_trans($identification,$t_table_name){ 
		$this->db->where(array(
			'status!='			=>		'approve',
			'status!='			=>		'Approve',
			'IsDeleted'			=>		0,
			'InActive'			=>		0
		));	
		$query = $this->db->get($t_table_name);
		return $query->result();		
	}

	public function get_transaction($id){

		$this->db->where(array(
			'identification'			=>		$id
		));	
		$query = $this->db->get('transaction_file_maintenance');
		return $query->result();
	}
	public function get_temp(){

		$this->db->where(array(
			'with_template'			=>		1,
			'IsActive'				=>		1
		));	
		$query = $this->db->get('transaction_file_maintenance');
		return $query->result();
	}
	public function activate_transaction($id){ 
		$this->db->where('identification',$id);
		$this->data = array('IsActive'=>1);
		$this->db->update("transaction_file_maintenance",$this->data);	
	}

	public function deactivate_transaction($id){ 
		$this->db->where('identification',$id);
		$this->data = array('IsActive'=>0);
		$this->db->update("transaction_file_maintenance",$this->data);	
	}
	//employee leave transactions
	public function get_employee_leave_transaction(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("employee_leave A");
		return $query->result();		
	}
	//view approve employee leave transactions
	public function get_to_cancel_transaction(){  //get_approve_employee_leave_transaction

		$t_table_name=$this->uri->segment('4');
		$this->db->select("*,A.id as id,B.id as eid",false);
		//$this->db->select("*",false);
		$this->db->where(array(
			'A.status!='	=>		'cancel',
			'A.status!='	=>		'Cancel'
		));	
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get($t_table_name. " A");
		return $query->result();		
	}
	public function get_emp_company($cID){
		$this->db->where("company_id", $cID);
		$query = $this->db->get('company_info');
		return $query->result();	
	}
	public function get_emp_dept($dept){
		$this->db->where("department_id", $dept);
		$query = $this->db->get('department');
		return $query->result();	
	}
	public function get_emp_sect($sect){
		$this->db->where("section_id", $sect);
		$query = $this->db->get('section');
		return $query->result();	
	}
	public function get_emp_clas($clas){
		$this->db->where("classification_id", $clas);
		$query = $this->db->get('classification');
		return $query->result();	
	}
	public function form_view_emp_leave($doc){
		$this->db->select("*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("leave_type C","C.ID = A.leave_type_id","left outer");
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("employee_leave A");
		return $query->result();		
	}
	/*start
	used in employee leave transaction form
	used in employee change sched req form
	*/
	public function get_emp_pos($pos){
		$this->db->where("position_id", $pos);
		$query = $this->db->get('position');
		return $query->result();	
	}	
	//view not approve transactions
	public function get_not_approve_transactions($t_table_name){ 
		$this->db->select("*,".$t_table_name.".id as id,employee_info.id as eid",false);
		$this->db->where(array(
			'status!='	=>		'approve',
			'status!='	=>		'Approve'
		));	
		$this->db->join("employee_info","employee_info.employee_id = ".$t_table_name.".employee_id","left outer");
		$query = $this->db->get($t_table_name);
		return $query->result();		
	}
	public function get_approvers($dept,$sect,$clas,$cur_form){
		$this->db->where(array(
			'form_identification'	=>		$cur_form,
			'department'			=>		$dept,
			'section'				=>		$sect,
			'classification'		=>		$clas
		));	
		$query = $this->db->get('transaction_approvers');
		return $query->result();	
	}
	//used in view pending and all transaction forms
	public function get_all_app($doc,$table_name){
		 $table = $table_name."_approval";
		
		$query=$this->db->query("SELECT *,".$table.".doc_no FROM transaction_approvers 
									INNER JOIN ".$table." ON (".$table.".original_approver=transaction_approvers.approver)
									INNER JOIN employee_info ON (employee_info.employee_id=".$table.".approver_id) 
									LEFT JOIN position ON (employee_info.position=position.position_id) WHERE doc_no='".$doc."' order by transaction_approvers.approval_level ASC");

		return $query->result();	
	}
	//transactions status //used in view pending and all transaction forms
	public function get_trans_stat($approver,$doc_no,$table_name){
		// $query=$this->db->query("SELECT * FROM transaction_status WHERE approver_id='".$approver."' AND doc_no='".$doc_no."' ");
		$table_name = $table_name . "_approval";
		$this->db->where(array(
			'approver_id'				=>			$approver,
			'doc_no'					=>			$doc_no,
			));

		$query = $this->db->get($table_name, 1);
		return $query->result();	
	}
	//approve all  transactions	
	public function save_approve_all_transactions($t_table_name){ 
		$cd=date("Y-m-d h:i:sa");
		$this->db->where(array(
			'status!='	=>		'approve',
			'status!='	=>		'Approve'
		));	
		$this->data = array('status'=>'approve',
			'status_update_date'	=>	$cd
			);
		$this->db->update($t_table_name,$this->data);	
	}
	//delete all leave transactions	
	public function delete_all_leave_transactions($t_table_name){ 
		$cd=date("Y-m-d h:i:sa");
		$this->db->where(array(
			'IsDeleted'	=>		'0'		
		));	
		$this->data = array('IsDeleted'=>'1',
			'status_update_date'	=>	$cd
			);
		$this->db->update($t_table_name,$this->data);	
	}
	//cancel all leave transactions	
	public function cancel_all_transactions($t_table_name){ 
		$cd=date("Y-m-d h:i:sa");
		$this->db->where(array(
			'status!='	=>		'cancel',
			'status!='	=>		'Cancel'		
		));	
		$this->data = array('status'=>'cancel',
			'status_update_date'	=>	$cd
			);
		$this->db->update($t_table_name,$this->data);	
	}
	//get all approved / pending transactions for cancellation
	public function to_cancel_trans($identification,$t_table_name){
		$this->db->select("*",false);
		$this->db->where(array(
			'A.status!='	=>		'cancel',
			'A.status!='	=>		'Cancel',
			'A.IsDeleted'			=>		0,
			'A.InActive'			=>		0

		));	
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get($t_table_name. " A");
		return $query->result();		
	}
	//get all deleted transactions 
	public function deleted_transactions($t_table_name){ //
		//$this->db->select("*",false);
		$this->db->select("*,A.id as id,B.id as eid",false);
		$this->db->where(array(
			'A.IsDeleted'			=>		'1'
		));	
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get($t_table_name." A");
		return $query->result();		
	}
	//get all NOT deleted transactions for deletions/deleting
	public function to_delete_trans($identification,$t_table_name){ //
		//$this->db->select("*",false);
		$this->db->select("*,A.id as id,B.id as eid",false);
		$this->db->where(array(
			'A.IsDeleted'			=>		'0' //,'A.InActive'			=>		0
		));	
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get($t_table_name." A");
		return $query->result();		
	}
	public function form_approvers($current_form){ 
		$this->db->select("
			A.*,
			concat(B.last_name,', ',B.first_name,' ',B.middle_name) as name
			",false);
		$this->db->order_by('A.approver','asc');
		$this->db->where(array(
			'A.form_identification'				=>		$current_form,
			'A.InActive'						=>		0
		));	
		$this->db->join("employee_info B","B.employee_id = A.approver","left outer");
		$query = $this->db->get("transaction_approvers A");
		return $query->result();
	}

	//get all pending
	public function pending_list($identification,$t_table_name){ 
		$this->db->select("*",false);
		$this->db->where(array(
			'A.status'	=>		'pending'
		));	
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get($t_table_name." A");
		return $query->result();		
	}
	//get all with error
	public function if_error_occur($t_table_name,$identification){
		// $query=$this->db->query("SELECT * FROM ".$t_table_name." INNER JOIN employee_info ON (employee_info.employee_id=".$t_table_name.".employee_id) INNER JOIN transaction_approvers ON (employee_info.department=transaction_approvers.department AND employee_info.section=transaction_approvers.section AND employee_info.classification=transaction_approvers.classification ) WHERE transaction_approvers.form_identification=
		// '".$identification."'");
		$query=$this->db->query("SELECT * FROM transaction_approvers WHERE  transaction_approvers.form_identification='".$identification."' ");

		return $query->result();	
	
	}
	public function error_list($identification,$t_table_name){ 

		$this->db->select("*",false);
		$this->db->where(array(
			'A.status'	=>		'pending'
		));	
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get($t_table_name." A");
		return $query->result();		
	}	
	/*end
	used in employee leave transaction form
	used in employee change sched req form
	*/

	//==================================================request of change of schedule	
	public function change_sched_req_getAll(){ 
		$query = $this->db->query("SELECT * FROM emp_change_sched A INNER JOIN employee_info B ON (A.employee_id=B.employee_id) WHERE A.IsDeleted = '0' AND A.entry_type NOT LIKE 'mass encoding%' ");
		return $query->result();		
	}
	public function form_view_emp_change_sched($doc){
		$this->db->select("*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_change_sched A");
		return $query->result();		
	}
	//==================================================employee time keeping complaint
	public function time_comp_req_getAll(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_time_complaint A");
		return $query->result();		
	}
	public function form_view_emp_time_comp($doc){
		$this->db->select("*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_time_complaint A");
		return $query->result();		
	}
	//==================================================request of change of rest day
	public function change_rest_day_req_getAll(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_change_rest_day A");
		return $query->result();		
	}
	public function form_view_emp_change_rest_day($doc){
		$this->db->select("*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_change_rest_day A");
		return $query->result();		
	}
	//==================================================request of cancellation of leave
	public function cancel_leave_req_getAll(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("employee_leave_cancel A");
		return $query->result();		
	}
	public function form_view_emp_cancel_leave($doc){
		$this->db->select("A.*,B.*,C.*,A.status as stat,D.*,A.reason as cancel_reason,C.reason as apply_reason",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("employee_leave C","C.doc_no = A.cancelled_doc_no","left outer");
		$this->db->join("leave_type D","D.id = C.leave_type_id","left outer");
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("employee_leave_cancel A");
		return $query->result();	

		

	}
	//==================================================request of undertime
	public function under_time_req_getAll(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_under_time A");
		return $query->result();		
	}
	public function form_view_emp_under_time($doc){
		$this->db->select("A.*,B.*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_under_time A");
		return $query->result();		
	}
	//==================================================request of overtime
	public function atro_req_getAll(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_atro A");
		return $query->result();		
	}
	public function form_view_emp_atro($doc){
		$this->db->select("A.*,B.*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_atro A");
		return $query->result();		
	}
	//==================================================official business form
	public function off_business_getAll(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_official_business A");
		return $query->result();		
	}
	public function form_view_off_business($doc){
		$this->db->select("A.*,B.*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_official_business A");
		return $query->result();		
	}
	//==================================================loans
	public function emp_loans_getAll(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_loans A");
		return $query->result();		
	}
	public function form_view_emp_loans($doc){
		$this->db->select("A.*,B.*,C.*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("loan_type C","C.loan_type_id = A.loan_type","left outer");
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_loans A");
		return $query->result();		
	}
	//==================================================employee trip ticket
	public function emp_trip_ticket_getAll(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_trip_ticket A");
		return $query->result();		
	}
	public function form_view_emp_trip_ticket($doc){
		$this->db->select("A.*,B.*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_trip_ticket A");
		return $query->result();		
	}
	//==================================================employee gate pass
	public function emp_gate_pass_getAll(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_gate_pass A");
		return $query->result();		
	}
	public function form_view_emp_gate_pass($doc){
		$this->db->select("A.*,B.*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_gate_pass A");
		return $query->result();		
	}
	//==================================================employee sworn declaration
	public function emp_sworn_dec_getAll(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_sworn_declaration A");
		return $query->result();		
	}
	public function form_view_emp_sworn_dec($doc){
		$this->db->select("A.*,B.*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_sworn_declaration A");
		return $query->result();		
	}
	//==================================================employee authority to deduct
	public function emp_authority_to_deduct_getAll(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_authority_to_deduct A");
		return $query->result();		
	}
	public function form_view_emp_authority_to_deduct($doc){
		$this->db->select("A.*,B.*,C.*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("advance_type C","C.id = A.type_of_advance","left outer");
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_authority_to_deduct A");
		return $query->result();		
	}
	//==================================================employee grievance request
	public function emp_grievance_req_getAll(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_grievance_request A");
		return $query->result();		
	}
	public function form_view_emp_grievance_req($doc){
		$this->db->select("A.*,B.*,
			concat(C.last_name,', ',C.first_name,' ',C.middle_name) as section_manager_name",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("employee_info C","C.employee_id = A.section_manager","left outer");
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_grievance_request A");
		return $query->result();		
	}
	//==================================================employee grocery items loan
	public function emp_grocery_loan_getAll(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_grocery_items_loan A");
		return $query->result();		
	}
	public function form_view_emp_grocery_loan($doc){
		$this->db->select("A.*,B.*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_grocery_items_loan A");
		return $query->result();		
	}
	//==================================================employee bap claim
	public function emp_bap_claim_getAll(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_bap_claim A");
		return $query->result();		
	}
	public function form_view_emp_bap_claim($doc){
		$this->db->select("A.*,B.*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_bap_claim A");
		return $query->result();		
	}
	//==================================================employee call out
	public function emp_call_out_getAll(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_call_out A");
		return $query->result();		
	}
	public function form_view_emp_call_out($doc){
		$this->db->select("A.*,B.*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_call_out A");
		return $query->result();		
	}
	//==================================================employee request form
	public function emp_request_form_getAll(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_request_form A");
		return $query->result();		
	}
	public function form_view_emp_request_form($doc){
		$this->db->select("A.*,B.*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_request_form A");
		return $query->result();		
	}
	//==================================================employee paternity notification
	public function emp_paternity_notif_getAll(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_paternity_notif A");
		return $query->result();		
	}
	public function form_view_emp_paternity_notif($doc){
		$this->db->select("A.*,B.*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_paternity_notif A");
		return $query->result();		
	}
	//==================================================employee payroll complaint
	public function emp_payroll_comp_getAll(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_payroll_complaint A");
		return $query->result();		
	}
	public function form_view_emp_payroll_comp($doc){
		$this->db->select("A.*,B.*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_payroll_complaint A");
		return $query->result();		
	}
	//==================================================employee payroll complaint
	public function emp_medicine_reimburse_getAll(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_medicine_reimburse A");
		return $query->result();		
	}
	public function form_view_emp_medicine_reimburse($doc){
		$this->db->select("A.*,B.*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_medicine_reimburse A");
		return $query->result();		
	}
	//==================================================employee hdmf cancellation
	public function emp_hdmf_cancel_getAll(){ 
		$this->db->select("*",false);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_hdmf_cancellation A");
		return $query->result();		
	}
	public function form_view_emp_hdmf_cancel($doc){
		$this->db->select("A.*,B.*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("emp_hdmf_cancellation A");
		return $query->result();		
	}
	public function insertCSV($data){
		$this->db->insert('gender', $data);
        return $this->db->insertId();
	}

	//leave type checker if exist
	public function checker_employee_exist($employee_id){
		$this->db->select('company_id');
		$this->db->from('employee_info');
		$this->db->where('employee_id',$employee_id);
	 	$query = $this->db->get();
	return $query->row('company_id');	
	}

	public function checker_leavetype_exist($leave_type,$check_employee)
	{
		$this->db->select('*');
		$this->db->from('leave_type');
		$this->db->where(array(
			'id'	=>		$leave_type,
			'company_id' => $check_employee
			));	
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			return 'true';
		}
		else{
			return 'false';
		}
	}


	public function employee_max_leavetype($employee_leavetype,$from,$to)
	{
		$this->db->select('*');
		$this->db->from('employee_leave');
		$this->db->where(array('employee_id' => $employee_leavetype,
								'from_date'  => $from,
								'to_date'    => $to)
					);
	 	$query = $this->db->get();
	 	return $query->num_rows();
	}

	public function update_leavetype_manualupload($data,$employee_id,$from,$to)
	{


		$this->db->where(array('employee_id' => $employee_id,
								'from_date'  => $from,
								'to_date'    => $to)
					);
		$this->db->update("employee_leave",$data);

		if($this->db->affected_rows() > 0)
				{
	    			return 'updated'; 
				}
				else
					{ return 'error'; }
	}
	public function insert_leavetype_manualupload($data)
	{
		$query = $this->db->insert('employee_leave',$data);
				if($this->db->affected_rows() > 0)
				{
	    			return 'inserted'; 
				}
				else
					{ return 'error'; }
	}

	public function employee_last_leavedate($employee)
	{
		$this->db->select_max('to_date');
		$this->db->from('employee_leave');
		$this->db->where('employee_id',$employee);
	 	$query = $this->db->get();
	 	if($query->num_rows()>0)
		{
			return $query->row('to_date');
		}
		else{
			return 'no_data';
		}
		
	}

	public function employee_second_leavedate($employee)
	{
		$this->db->select('to_date');
		$this->db->from('employee_leave');
		$this->db->where('employee_id',$employee);
		$this->db->order_by('id','DESC');
		$this->db->limit(1, 1);
	 	$query = $this->db->get();
	 	if($query->num_rows()>0)
		{
			return $query->row('to_date');
		}
		else{
			return 'no_data';
		}
	}


	//for viewing the userdefine
	public function form_view_emp_user_define($doc,$table_name)
	{
		$this->db->select("A.*,B.*",false);
		$this->db->where('A.doc_no',$doc);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$query = $this->db->get("".$table_name." A");
		return $query->result();
	}

	//fields details for userdefine
	public function fields_details($form_name)
	{
		$this->db->where('form_name',$form_name);
		$this->db->order_by('tran_udf_col_id','ASC');
		$query = $this->db->get('transaction_udf_column');
		return $query->result();
	}

	public function get_request_form_list()
	{
		$this->db->where('InActive',0);
		$query = $this->db->get('emp_request_form_list');
		return $query->result();
	}
}