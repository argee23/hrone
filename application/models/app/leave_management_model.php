<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Leave_management_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function insert_leave_credits($manual_leave_credits){
		$this->db->insert("leave_allocation",$manual_leave_credits);	
	}

	//== for listing
	public function getAll(){

		$this->db->select("*",false);

		$this->db->order_by('id','asc');
		$query = $this->db->get("leave_type");
		return $query->result();
	}	
	//== for listing
	public function leave_per_company($company_id){

		$this->db->select("*",false);
		$this->db->where('company_id',$company_id);
		$this->db->order_by('id','asc');
		$query = $this->db->get("leave_type");
		return $query->result();
	}	
	//== view usage
	public function get_employee_leave_usage($current_emp,$current_leave_id,$date_employed,$cutoff){

			require(APPPATH.'views/app/leave_management/coverage_of_leave_usage.php');

		$query = $this->db->query("select * from employee_leave where leave_type_id='".$current_leave_id."' AND employee_id='".$current_emp."' $check_date_filed ");
		
		return $query->result();


					// $this->db->select("
					// 	A.employee_id,
					// 	A.doc_no,
					// 	A.leave_type_id,
					// 	A.address,
					// 	A.from_date,
					// 	A.to_date,
					// 	A.no_of_days,
					// 	A.status,
					// 	A.reason,
					// 	A.date_created,
					// 	A.remarks,
					// 	A.InActive,
					// 	A.with_pay,
					// 	A.entry_type,
					// 	A.days,
					// 	A.is_per_hour,
					// 	concat(B.last_name,', ',B.first_name,' ',B.middle_name) as name
					// 	",false);
					// //$this->db->where('A.employee_id',$current_emp);

					// $this->db->where(array(
					// 	'A.leave_type_id'			=>		$current_leave_id,
					// 	'A.employee_id'				=>		$current_emp
					// ));	


					// $this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
					// $query = $this->db->get('employee_leave A');
					// return $query->result();
	}
	public function getLeaveType($id){ 
		$this->db->select("
			A.*,
			B.company_name,
			B.company_id",false);

		$this->db->where('A.id',$id);
		$this->db->join("company_info B","A.company_id = B.company_id","left outer");
		$query = $this->db->get('leave_type A');
		return $query->row();		
	}	
	public function check_classification($classification){
		$this->db->where('',$classification);
		$query = $this->db->get('leave_type');
		return $query->row();

	}
	//== for saving update
	public function modify_leave_type($id,$cut_off_date){
		// $selectDate=$this->input->post('start_month').$this->input->post('start_day').$this->input->post('end_month').$this->input->post('end_day');
		// $yearly=$this->input->post('yearly');
		// if($yearly="checked"){
		// 	$cut_off_date="yearly";
		// }
		// if($selectDate !=""){			
		// 	$cut_off_date=$this->input->post('start_month')."/".$this->input->post('start_day')."-".$this->input->post('end_month')."/".$this->input->post('end_day');
		// }else{
		// 	$cut_off_date="yearly";
		// }
		$imc=$this->input->post('is_manual_Credit');

		$this->data = array(
			'cutoff'		=> $cut_off_date,
			'is_manual_credit'		=> $imc,
			'IsDisabled'					=> 0
		);	
		$this->db->where('id',$id);
		$this->db->update('leave_type',$this->data);
	}
	public function modify_leave_type_year($id){
		$dc = date("m/d/Y H:i:s");
		$this->data = array(
			'increment'			=> $this->input->post('increment'),
			'add_leave_bal'		=> $this->input->post('leave_balance'),
			'max'				=> $this->input->post('max'),
			'isyearly_setup'	=> $this->input->post('isyearly_setup'),
			'current_date'		=> $dc,
			'replenish'			=>	$this->input->post('replenish')
		);	
		$this->db->where('id',$id);
		$this->db->update('leave_type_year',$this->data);
	}
	//== for managing
	public function save(){ 

		$carry_over_credit=$this->input->post('carry_over');
		$carry_over_when=$this->input->post('carry_over_when'); // kelan sya magce-carry over 
		$carry_over_expired_month=$this->input->post('carry_over_expired_month'); // if may expiry yung kinery over na value : anong month
		$carry_over_expired_day=$this->input->post('carry_over_expired_day'); //  if may expiry yung kinery over na value : anong day
		
// succeeding years
		$isyearly_credit_fixed=$this->input->post('isyearly_credit_fixed');
		
if($isyearly_credit_fixed=="yes"){
	$yearly_fixed_credit_on_anniv_eff=$this->input->post('yearly_fixed_credit_on_anniv_eff'); // para sa wlang increment policy , fixed credit value lang yearly at yung effectivity is on employee anniv day. (1 means yes)

		if($yearly_fixed_credit_on_anniv_eff=="1"){
			$yearly_fixed_credit_month="";
			$yearly_fixed_credit_day="";
		}else{
			$yfcm=$this->input->post('yearly_fixed_credit_month');
			$yfcd=$this->input->post('yearly_fixed_credit_day');
			if($yfcm==""){
					$final_yfcm="01"; // if user did not select a month default to january
			}else{
					$final_yfcm=$this->input->post('yearly_fixed_credit_month'); 
			}
			if($yfcd==""){
					$final_yfcd="01";// if user did not select a day default to 01
			}else{
					$final_yfcd=$this->input->post('yearly_fixed_credit_day');
			}

			$yearly_fixed_credit_month=$final_yfcm; // para sa wlang increment policy , fixed credit value lang yearly , what month sya mag eeffect
			$yearly_fixed_credit_day=$final_yfcd;// para sa wlang increment policy , fixed credit value lang yearly , what day sya mag eeffect
		}
	$yearly_inc_what_day=""; // wala syang increment setup kasi na yes yung fixed credit yearly
}else{
	$yearly_fixed_credit_on_anniv_eff="";
	$yearly_fixed_credit_month="";
	$yearly_fixed_credit_day="";
	$yearly_fixed_credit_on_anniv_eff="";
	$yiwd=$this->input->post('yearly_inc_what_day');
	if($yiwd==""){
			$yearly_inc_what_day="01"; // yung increment : what day of the month mag eeffect
	}else{
			$yearly_inc_what_day=$this->input->post('yearly_inc_what_day'); // yung increment : what day of the month mag eeffect
	}
	
}

if($carry_over_credit=="0"){ // kapag no carry over policy matic all carry over setup to no_carry_over
			$carry_over_when="no_carry_over";
			$carry_over_expired_month="no_carry_over";
			$carry_over_expired_day="no_carry_over";

}else if(($carry_over_credit<>"0")AND($carry_over_expired_month=="no_carry_over")){ // kapag may carry over pero hindi nagsetup ng expiry date matic no expiry
		$carry_over_when="1";
		$carry_over_expired_month="0";
		$carry_over_expired_day="0";
}else{ // susunod kung ano ang sinelect na setup see post values

}

			if($carry_over_expired_month=="0"){
							$carry_over_expired_day="0"; // kahit magselect ng what day if di nagselect ng what month : no effect.
					}

$fc=$this->input->post('fixed_credit_value');
	if($fc==""){
		$fc_value="0"; // if di naglagay ng fixed credit value put 0
	}else{
		$fc_value=$this->input->post('fixed_credit_value');
	}


		$this->db->where('id',$this->input->post('leave_id'));
		$this->data = array(
			'start_value'					=>		$this->input->post('start_value'),
			'effectivity'					=>		$this->input->post('effectivity'),
			'carry_over'					=>		$carry_over_credit,			
			'carry_over_when'				=>  	$carry_over_when,
			'carry_over_expired_month'		=> 		$carry_over_expired_month,
			'carry_over_expired_day'		=> 		$carry_over_expired_day,
			'yearly_inc_what_day'			=> 		$yearly_inc_what_day,
			'yearly_fixed_credit_month'		=> 		$yearly_fixed_credit_month,
			'yearly_fixed_credit_day'		=> 		$yearly_fixed_credit_day,
			'yearly_fixed_credit_on_anniv_eff'		=> $yearly_fixed_credit_on_anniv_eff,
			'isyearly_credit_fixed'		=> $this->input->post('isyearly_credit_fixed'),
			'fixed_credit_value'			=>					$fc_value,
			);
		$this->db->update("leave_type",$this->data);	

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			$this->general_model->system_audit_trail('Leave','Credit Management','logfile_admin_leave_management','start setup |start_value|effectivity|carry_over|carry_over_when|carry_over_expired_month|carry_over_expired_day|yearly_fixed_credit_month|yearly_fixed_credit_day|yearly_fixed_credit_on_anniv_eff|isyearly_credit_fixed|fixed_credit_value:'.$this->input->post('start_value').'|'.$this->input->post('effectivity').'|'.$carry_over_credit.'|'.$carry_over_when.'|'.$carry_over_expired_month.'|'.$carry_over_expired_day.'|'.$yearly_inc_what_day.'|'.$yearly_fixed_credit_month.'|'.$yearly_fixed_credit_day.'|'.$yearly_fixed_credit_on_anniv_eff.'|'.$this->input->post('isyearly_credit_fixed').'|'.$fc_value,'UPDATE',$this->input->post('leave_id'));

	}	
	// ***
	public function check_starting_leave_credit_reference($current_leave_id,$employee_id){
		$year=date('Y');
		$query = $this->db->query("select * from leave_starting_allocation where leave_type_id = '".$current_leave_id."' and employee_id='".$employee_id."' and year='".$year."' ");
		return $query->row();
	}
	public function save_starting_leave_credit_reference($current_leave_id,$employee_id,$final_as_of_inc,$tref_action){
		$year=date('Y');
		$cd=date('Y-m-d H:i:s');

		if($tref_action=="insert"){

			$this->data = array(
				'leave_type_id'					=>		$current_leave_id,			
				'employee_id'					=>  	$employee_id,
				'available'						=> 		$final_as_of_inc,
				'year'							=> 		$year,
				'insert_date'							=> 		$cd
			
				);
			$this->db->insert("leave_starting_allocation",$this->data);	
		}else{//update


			$this->data = array(
				'available'						=> 		$final_as_of_inc,
				'last_update'					=> 		$cd
				);


			$this->db->where(array(
				'employee_id'			=>		$employee_id,
				'leave_type_id'			=>		$current_leave_id,

			));	

			$this->db->update("leave_starting_allocation",$this->data);	
		}

	}

	public function verifyCarriedOverCredit($current_leave_id,$employee_id,$emp_lyc,$fiscal_year,$last_year){
		$query=$this->db->query("select * from leave_carried_over where leave_type_id='".$current_leave_id."' and employee_id='".$employee_id."' and year='".$fiscal_year."' and from_what_year='".$last_year."' ");
		return $query->row();
	}

	public function UpdateCarriedOverExpiredCredit($current_leave_id,$employee_id,$emp_lyc,$fiscal_year,$last_year,$credit_that_expire){
		$query=$this->db->query("UPDATE leave_carried_over SET expired='".$credit_that_expire."' WHERE leave_type_id='".$current_leave_id."' and employee_id='".$employee_id."' and year='".$fiscal_year."' and from_what_year='".$last_year."'");
	}
	public function DeleteCarriedOverExpiredCredit($current_leave_id,$employee_id,$emp_lyc,$fiscal_year,$last_year,$credit_that_expire){
		$query=$this->db->query("DELETE FROM leave_carried_over WHERE leave_type_id='".$current_leave_id."' and employee_id='".$employee_id."' and year='".$fiscal_year."' and from_what_year='".$last_year."'");
	}

	public function SavedCarriedOverCredit($current_leave_id,$employee_id,$emp_lyc,$fiscal_year,$last_year){
			$cd=date('Y-m-d H:i:s');
			$this->data = array(
				'leave_type_id'					=>		$current_leave_id,			
				'employee_id'					=>  	$employee_id,
				'credit'						=> 		$emp_lyc,
				'year'							=> 		$fiscal_year,
				'from_what_year'				=> 		$last_year,
				'insert_date'					=> 		$cd
				);
			$this->db->insert("leave_carried_over",$this->data);	
	}





	public function save_carried_over_credit($current_leave_id,$employee_id,$emp_lyc,$fiscal_year,$co_action,$last_year){
		
		$cd=date('Y-m-d H:i:s');

		if($co_action=="insert"){

			$this->data = array(
				'leave_type_id'					=>		$current_leave_id,			
				'employee_id'					=>  	$employee_id,
				'credit'						=> 		$emp_lyc,
				'year'							=> 		$fiscal_year,
				'from_what_year'				=> 		$last_year,
				'insert_date'					=> 		$cd
				);
			$this->db->insert("leave_carried_over",$this->data);	

		}else{//update

			$this->data = array(
				'credit'						=> 		$emp_lyc,
				'last_update'					=> 		$cd
				);

			$this->db->where(array(
				'employee_id'			=>		$employee_id,
				'leave_type_id'			=>		$current_leave_id,
				'year'					=>		$fiscal_year,
				'from_what_year'				=>		$last_year

			));	

			$this->db->update("leave_carried_over",$this->data);	
		}

	}



	// ***
	public function check_leave_credit($current_leave_id,$employee_id,$fiscal_year){
		
		$query = $this->db->query("select * from leave_allocation where leave_type_id = '".$current_leave_id."' and employee_id='".$employee_id."' and year='".$fiscal_year."' ");
		return $query->row();
	}

	public function save_manual_credit($data_save){
		
		$this->db->insert("leave_allocation",$data_save);	
	}
	public function save_autocomputed_credit($current_leave_id,$employee_id,$final_as_of_inc,$t_action,$fiscal_year){
		//$year=date('Y');
		$cd=date('Y-m-d H:i:s');

		if($fiscal_year=='-' || $fiscal_year==0)
		{
			$this->db->where('employee_id',$employee_id);
			$q = $this->db->get('employee_info',1);
			$date_employed = $q->row('date_employed');
			$yrnow = date('Y');
			$datenow = date('Y-m-d');

			$date_employed_month  = date("m", strtotime($date_employed));
			$datenow_month  = date("m", strtotime($datenow));

			$date_employed_day = date("d", strtotime($date_employed));
			$datenow_day  = date("d", strtotime($datenow));

			if($datenow_month == $date_employed_month)	
			{
				if($datenow_day >=$date_employed_day)
				{
					$fiscalyr = $yrnow;
				}
				else
				{
					$fiscalyr = $yrnow-1;
				}
			}
			else if($datenow_month > $date_employed_month)
			{
				$fiscalyr = $yrnow;
			}
			else
			{
				$fiscalyr = $yrnow-1;
			}
			
		}
		else
		{
			$fiscalyr = $fiscal_year;
		}

		if($t_action=="insert"){


				if($fiscal_year=='-' || $fiscal_year==0)
				{	
					$this->db->where(array('employee_id'=>$employee_id,'leave_type_id'=>$current_leave_id,'year'=>$fiscalyr));
					$checker = $this->db->get('leave_allocation');
					if($checker->num_rows() > 0)
					{
							$this->data = array(
							'leave_type_id'					=>		$current_leave_id,			
							'employee_id'					=>  	$employee_id,
							'available'						=> 		$final_as_of_inc,
							'year'							=> 		$fiscalyr,
							'insert_date'					=> 		$cd
							);
							$this->db->where(array('employee_id'=>$employee_id,'leave_type_id'=>$current_leave_id,'year'=>$fiscalyr));
							$this->db->update("leave_allocation",$this->data);
					}
					else
					{
							$this->data = array(
							'leave_type_id'					=>		$current_leave_id,			
							'employee_id'					=>  	$employee_id,
							'available'						=> 		$final_as_of_inc,
							'year'							=> 		$fiscalyr,
							'insert_date'					=> 		$cd
							);
							$this->db->insert("leave_allocation",$this->data);	
					}
				}
				else
				{
					$this->data = array(
					'leave_type_id'					=>		$current_leave_id,			
					'employee_id'					=>  	$employee_id,
					'available'						=> 		$final_as_of_inc,
					'year'							=> 		$fiscalyr,
					'insert_date'					=> 		$cd
					);
					$this->db->insert("leave_allocation",$this->data);
				}
							
		}else{//update


			$this->data = array(
				'available'						=> 		$final_as_of_inc,
				'last_update'					=> 		$cd
				);



			$this->db->where(array(
				'employee_id'		=>		$employee_id,
				'leave_type_id'		=>		$current_leave_id,
				'year'				=>		$fiscalyr

			));	

			$this->db->update("leave_allocation",$this->data);	
		}


			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			$this->general_model->system_audit_trail('Leave','Credit Management','logfile_admin_leave_management','auto update credits base on setup:(employee_id|credit|fiscal year)'.$employee_id.'|'.$final_as_of_inc.'|'.$fiscal_year,'UPDATE',$current_leave_id);




	}


	//===
	public function check_if_leave_type_has_assigned_class_settings($id){
		//$company_id=$this->session->userdata('company_id');
		$query = $this->db->query("select * from leave_type_classification where leave_type_id = '".$id."' ");

		return $query->result();
	}
	public function check_if_leave_type_has_assigned_emp_settings($id){
		//$company_id=$this->session->userdata('company_id');
		$query = $this->db->query("select * from leave_type_employment where leave_type_id = '".$id."' ");

		return $query->result();
	}
	public function check_if_leave_type_has_assigned_loc_settings($id){
		//$company_id=$this->session->userdata('company_id');
		$query = $this->db->query("select * from leave_type_location where leave_type_id = '".$id."' ");

		return $query->result();
	}
	//===
	public function check_if_classification_is_applicable($cl,$id){
		//$company_id=$this->session->userdata('company_id');
		$query = $this->db->query("select * from leave_type_classification where classification= '".$cl ."' and leave_type_id = '".$id."' ");

		return $query->result();
	}
	public function check_if_employment_is_applicable($cl,$id){
		//$company_id=$this->session->userdata('company_id');
		$query = $this->db->query("select * from leave_type_employment where employment= '".$cl ."' and leave_type_id = '".$id."' ");

		return $query->result();
	}
	public function check_if_location_is_applicable($cl,$id){
		//$company_id=$this->session->userdata('company_id');
		$query = $this->db->query("select * from leave_type_location where location= '".$cl ."' and leave_type_id = '".$id."' ");

		return $query->result();
	}

	public function check_leave_years($id){
		//$company_id=$this->session->userdata('company_id');
		$query = $this->db->query("select * from leave_type_year where leave_type_id = '".$id."' ORDER by year DESC limit 1");

		return $query->result();
	}
	public function get_leave_years($id){
		//$company_id=$this->session->userdata('company_id');
		$query = $this->db->query("select * from leave_type_year where leave_type_id = '".$id."' ORDER by year ASC");

		return $query->result();
	}
	public function remove_leave_condition($id){
		$this->db->where('id',$id);
		$this->data = array(
			'start_value'	=>	"",
			'effectivity'	=>	"",
			'carry_over_expired_month'	=>	"",
			'carry_over'	=>	"",
			'carry_over_expired_month'	=>	"",
			'carry_over_expired_day'	=>	"",
			'carry_over_when'	=>	"",
			'yearly_inc_what_day'	=>	"",
			'isyearly_credit_fixed'	=>	"",
			'fixed_credit_value'	=>	"",
			'yearly_fixed_credit_month'	=>	"",
			'yearly_fixed_credit_day'	=>	"",
			'yearly_fixed_credit_on_anniv_eff'	=>	""

			);
		$this->db->update("leave_type",$this->data);	
	}
	public function getLeaveTypeYear($id){ 

		$this->db->where('A.id',$id);
		$this->db->join("leave_type B","B.id = A.leave_type_id","left outer");
		$query = $this->db->get('leave_type_year A');
		return $query->row();		
	}
	public function getEmployees($classifications,$employments,$locations){

		$current_leave_id = $this->uri->segment("4");
		$company_id = $this->uri->segment("6");
		if($classifications!="" || $employments!="" || $locations!="" ){
			$query = $this->db->query("select *,c.classification as classification_name from employee_info a 
				inner join employment b on a.employment=b.employment_id 
				inner join classification c on a.classification=c.classification_id
				inner join location d on a.location=d.location_id
				where (".$classifications.")  AND  (".$employments.") AND  (".$locations.") AND a.InActive=0 AND a.isEmployee=1 AND a.company_id='".$company_id."'");
			return $query->result();
		}else{
			$query = $this->db->query("select * from employee_info where InActive=0 ");
			return $query->result();
		}
	}		
	public function get_leave_details($current_leave_id){

		$this->db->select("*",false);
		$this->db->where(array(
			'A.id'		=>		$current_leave_id
		));				
		$this->db->join("leave_type_classification B","B.leave_type_id = A.id","left outer");
		$this->db->join("leave_type_employment C","C.leave_type_id = A.id","left outer");
		$this->db->join("leave_type_location D","C.leave_type_id = A.id","left outer");
		$query = $this->db->get("leave_type A");
		return $query->row();
	}
	public function check_leave_classification($current_leave_id){
		//$company_id=$this->session->userdata('company_id');

		$this->db->select("*",false);
		$this->db->where(array(
			'leave_type_id'			=>		$current_leave_id
		));	
		$this->db->order_by('id','ASC');			
		$query = $this->db->get("leave_type_classification");
		return $query->result();
	}
	public function check_leave_employment($current_leave_id){
		//$company_id=$this->session->userdata('company_id');

		$this->db->select("*",false);
		$this->db->where(array(
			'leave_type_id'			=>		$current_leave_id
		));	
		$this->db->order_by('id','ASC');			
		$query = $this->db->get("leave_type_employment");
		return $query->result();
	}
	public function check_leave_location($current_leave_id){
		//$company_id=$this->session->userdata('company_id');

		$this->db->select("*",false);
		$this->db->where(array(
			'leave_type_id'			=>		$current_leave_id
		));	
		//$this->db->order_by('id','ASC');			
		$query = $this->db->get("leave_type_location");
		return $query->result();
	}
	// public function get_class($class_){ 

	// 	$this->db->where('classification_id',$class_);
	// 	$query = $this->db->get('classification');
	// 	return $query->result();		
	// }
	// public function get_emp($emp_){ 

	// 	$this->db->where('employment_id',$emp_);
	// 	$query = $this->db->get('employment');
	// 	return $query->result();		
	// }
	// public function get_loc($loc_){ 

	// 	$this->db->where('location_id',$loc_);
	// 	$query = $this->db->get('location');
	// 	return $query->result();		
	// }
	//filtering
	public function get_leave_classifications($current_leave_id){
		//$company_id=$this->session->userdata('company_id');

		$this->db->select("B.classification_id,B.classification as classification_applied_to",false);
		$this->db->where(array(
			'A.leave_type_id'			=>		$current_leave_id
		));	
		$this->db->order_by('A.id','ASC');			
		$this->db->join("classification B","B.classification_id = A.classification","left outer");
		$query = $this->db->get("leave_type_classification A");
		return $query->result();
	}
	public function get_leave_employments($current_leave_id){
		//$company_id=$this->session->userdata('company_id');

		$this->db->select("B.employment_id,B.employment_name as employment_applied_to",false);
		$this->db->where(array(
			'A.leave_type_id'			=>		$current_leave_id
		));	
		$this->db->order_by('A.id','ASC');			
		$this->db->join("employment B","B.employment_id = A.employment","left outer");
		$query = $this->db->get("leave_type_employment A");
		return $query->result();
	}
	public function search_employee($final_classifications,$final_employments,$final_locations){ 
			
		$dep = $this->uri->segment("4");
		$sec = $this->uri->segment("5");
		$clas = $this->uri->segment("6");
		$emp = $this->uri->segment("7");
		$stat = $this->uri->segment("8");
		$years_employed_from = $this->uri->segment("9");
		$years_employed_to = $this->uri->segment("10");
		$gender = $this->uri->segment("11");
		$civil_status = $this->uri->segment("12");

		$current_leave_id = $this->uri->segment("13"); 

		$years_bracket = $this->uri->segment("14");

		if($dep !=0){
			$where_clause_dep="AND department='".$dep."'";
		}else{
			$where_clause_dep="";
		}
		if($sec !=0){
			$where_clause_sec="AND section='".$sec."'";
		}else{
			$where_clause_sec="";
		}
		if($clas !=0){
			$where_clause_clas="AND classification='".$clas."'";
		}else{
			$where_clause_clas="";
		}
		if($emp !=0){
			$where_clause_emp="AND employment='".$emp."'";
		}else{
			$where_clause_emp="";
		}
		if($stat !=2){
			$where_clause_stat="AND InActive='".$stat."'";
		}else{
			$where_clause_stat="";
		}
		if($gender !=0){
			$where_clause_gender="AND gender='".$gender."'";
		}else{
			$where_clause_gender="";
		}
		if($civil_status !=0){
			$where_clause_civil_status="AND civil_status='".$civil_status."'";
		}else{
			$where_clause_civil_status="";
		}
		if($years_bracket !=0){
			$where_clause_years_bracket="AND date_employed BETWEEN '".$years_bracket."-01-01' AND '".$years_bracket."-12-31' ";	//BETWEEN 2016-01-01 
		}else{
			$where_clause_years_bracket="";
		}
		if($years_employed_from !=0){
			$todays_date=date('Y-m-d');
			$daydiff=floor((abs(strtotime(date("Y-m-d")) - strtotime('date_employed'))/(365*60*60*24)));
			//$where_clause_employed_from="AND ABS(DATEDIFF(DATE('" . $todays_date. "'), DATE(date_employed))) >= 2016-01-31 ";	//BETWEEN 2016-01-01 
		$where_clause_employed_from="AND".floor((abs(strtotime(date("Y-m-d")) - strtotime("2016-01-31"))/(365*60*60*24))) =="0  ";	
		}else{
			$where_clause_employed_from="";
		}
		//=============================================================default query
		if(($final_classifications!="") AND ($final_employments!="") AND ($final_locations!="")){
			$operand="WHERE";
		}else{
			$operand="";
		}
		if($final_classifications!=""){
			$where_clause_clas_default="(".$final_classifications.")";
		}else{
			$where_clause_clas_default="";
		}
		if($final_employments!=""){
			$where_clause_emp_default="AND (".$final_employments.")";
		}else{
			$where_clause_emp_default="";
		}	
		if($final_locations!=""){
			$where_clause_loc_default="AND (".$final_locations.")";
		}else{
			$where_clause_loc_default="";
		}

		$query = $this->db->query("select * from employee_info where InActive=0 ".$where_clause_years_bracket. "".$where_clause_dep. "".$where_clause_emp. "".$where_clause_clas. "".$where_clause_sec. "".$where_clause_gender. "".$where_clause_civil_status. "".$where_clause_stat. " AND employee_id in (select employee_id from employee_info ".$operand." ".$where_clause_clas_default. "".$where_clause_emp_default. "".$where_clause_loc_default. "  )");
		return $query->result();		
	}
	public function get_section($dept_id){

		$this->db->where('department_id',$dept_id);
		$query = $this->db->get('section');
		return $query->result();
	}
	public function get_leave_allocation($current_leave_id,$employee_id){
		// include year coverage here.
		$this->db->where(array(
			'leave_type_id'			=>		$current_leave_id,
			'employee_id'			=>		$employee_id
		));	
		$query = $this->db->get('leave_allocation');
		return $query->result();
	}

	public function get_leave_allocation_last_year($current_leave_id,$employee_id,$last_year){
		$query=$this->db->query("select * from leave_allocation where leave_type_id='".$current_leave_id."' and employee_id='".$employee_id."' and year='".$last_year."' ");


		return $query->row();
	}

	public function get_expired_carried_over_credit($current_leave_id,$employee_id,$fiscal_year){
		$query=$this->db->query("select * from leave_carried_over where leave_type_id='".$current_leave_id."' and employee_id='".$employee_id."' and year='".$fiscal_year."' ");
		return $query->row();
	}
	//======================================leave computation
	public function check_use_leave($current_leave_id,$employee_id,$cutoff,$date_employed){

		require(APPPATH.'views/app/leave_management/coverage_of_leave_usage.php');

		$query = $this->db->query("select * from employee_leave where leave_type_id='".$current_leave_id."' AND employee_id='".$employee_id."' AND with_pay='1' AND (is_per_hour is null or is_per_hour='' OR is_per_hour<='0') AND (status='approved' OR status='pending') $check_date_filed ");
		return $query->result();
	}
	public function check_per_hour_use_leave($current_leave_id,$employee_id,$cutoff){
		$current_year=date('Y');
		$next_year=date('Y')+1;
		$last_year=date('Y')-1;
		$current_month=date('m');

		if($cutoff=="yearly"){
			$f=$current_year."-01"."-01";
			$t=$current_year."-12"."-31";

			$check_date_filed="AND (date_created BETWEEN '".$f."' AND '".$t."') ";
		}else{

	                              $start_month = substr($cutoff, 0, -9); 
	                              $start_day = substr($cutoff, 3, -6);     

	                              $end_month = substr($cutoff, 6, -3); 
	                              $end_day = substr($cutoff,  -2);
		if($current_month>=$start_month){

				$f=$current_year."-".$start_month."-".$start_day;
				$t=$next_year."-".$end_month."-".$end_day;

				$check_date_filed="AND (date_created BETWEEN '".$f."' AND '".$t."') ";
		}else{
				$f=$last_year."-".$start_month."-".$start_day;
				$t=$current_year."-".$end_month."-".$end_day;

				$check_date_filed="AND (date_created BETWEEN '".$f."' AND '".$t."') ";
		}

		}

		$query = $this->db->query("select * from employee_leave where leave_type_id='".$current_leave_id."' AND employee_id='".$employee_id."' AND with_pay='1' AND is_per_hour='1'  AND (status='approved' OR status='pending') $check_date_filed ");
		return $query->result();
	}
	public function ph_leave_check_per_day($doc_no){

		$query = $this->db->query("select sum(total_hours) as total_hours,sum(total_minutes) as total_minutes,sum(leave_credits_deducted) as leave_credits_deducted FROM employee_leave_days WHERE doc_no='".$doc_no."' ");
		return $query->row();		

	}
	//======================================leave computation : check used leave before carry over credits expired
	public function check_leave_used_re_carry_over_exp($current_leave_id,$employee_id,$cutoff,$carry_over_expired_month,$carry_over_expired_day,$fiscal_year){
		// $current_year=date('Y');
		// $next_year=date('Y')+1;
		$last_fiscal_year=date($fiscal_year)-1;
		

		if($carry_over_expired_day=="0"){// no expiry
			$carry_over_expired_day="31";
		}else{
			$carry_over_expired_day=$carry_over_expired_day;
		}

		$day=$carry_over_expired_day-1; // - 1 day purpose para di na nya isama yung applications dated on the date of expiry

		$f=$last_fiscal_year."-01"."-01";
		if($carry_over_expired_month=="0"){// no expiry
			$carry_over_expired_month="12";
		}else{
			$carry_over_expired_month=$carry_over_expired_month;
		}
		$t=$last_fiscal_year."-".$carry_over_expired_month."-".$day;
		$check_date_filed="AND (date_created BETWEEN '".$f."' AND '".$t."') ";

		//echo $check_date_filed;
		$query = $this->db->query("select no_of_days from employee_leave where leave_type_id='".$current_leave_id."' AND employee_id='".$employee_id."' AND with_pay='1' AND (status='approved' OR status='pending') $check_date_filed ");
		return $query->result();
	}


	public function getmindate(){
		$query = $this->db->query("select date_employed from employee_info GROUP by date_employed ORDER BY date_employed ASC limit 1 ");// where company_id= '".$company_id ."'
		return $query->result();
	}

	public function get_leave_increment($current_leave_id,$get_year){

		$this->db->where(array(
			'leave_type_id'			=>		$current_leave_id,
			'year'					=>		$get_year
		));	
		$query = $this->db->get('leave_type_year');

		return $query->row();//result
	}
	public function get_leave_increment_recurring_setup($current_leave_id){

		$this->db->where(array(
			'leave_type_id'			=>		$current_leave_id,
			'isyearly_setup'					=>		1
		));	
		$query = $this->db->get('leave_type_year');
		return $query->row();//result
	}


	public function get_employees($company_id){

		$query = $this->db->query("select b.employee_id,b.name_lname_first,b.date_employed,b.classification_name,b.employment_name,b.last_name,b.first_name,b.middle_name from masterlist b where b.company_id='".$company_id."' ");
		return $query->result();

	}
	public function getILemployees($company_id){

		$query = $this->db->query("select b.employee_id,b.name_lname_first,b.date_employed,b.classification_name,b.employment_name,b.last_name,b.first_name,b.middle_name from employee_incentive_leave_enrollment a inner join masterlist b on(a.employee_id=b.employee_id)
			where b.company_id='".$company_id."' ");
		return $query->result();

	}


	public function checkifDef($id){
		$query = $this->db->query("select is_system_default from leave_type where is_system_default='".$id."' ");
		return $query->row();		
	}

	//earned from ot

	public function earned_from_ot($current_leave_id,$employee_id)
	{
		$this->db->join('emp_atro b','b.doc_no=a.doc_no');
		$this->db->where(array('a.employee_id'=>$employee_id,'a.year!='=>'2018','b.status'=>'approved','b.IsDeleted'=>0));
		$query = $this->db->get('incentive_leave_credits a');
		return $query->result();
	}

	///earned from approved OT
	public function incentive_leave_subject_approval($employee_id,$leave_id)
	{
		$year = date('Y');
		$this->db->select('SUM(equivalent_incentive_credit) as total');
		$this->db->where(array('employee_id'=>$employee_id,'year'=>$year));
		$query = $this->db->get('incentive_leave_credits');
		if(empty($query->row('total')))
		{
			return 0;
		}
		else
		{
			return $query->row('total');
		}
	}
}