<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Time_payroll_period_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	//== for listing
	public function get_payroll_period_groups($company_id){ //management
		$this->db->select("C.pay_type_name,A.*");
		$this->db->where(array(
			'A.company_id'			=>		$company_id,
		));	
		$this->db->join("pay_type C","C.pay_type_id = A.pay_type","left outer");
		$this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get("payroll_period_group A");

		return $query->result();	
	}
	public function get_active_payroll_period_groups($company_id,$pay_type_id){ //active only
		$this->db->select("C.pay_type_name,A.*");
		$this->db->where(array(
			'A.company_id'			=>		$company_id,
			'A.pay_type'			=>		$pay_type_id,
			'A.InActive'			=>		0
		));	
		$this->db->join("pay_type C","C.pay_type_id = A.pay_type","left outer");
		$this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get("payroll_period_group A");

		return $query->result();	
	}
	public function spec_payroll_period_group($id){
		$this->db->select("A.*,B.company_name,C.pay_type_name");
		$this->db->where(array(
			'A.payroll_period_group_id'				=>		$id
		));	
		$this->db->join("pay_type C","C.pay_type_id = A.pay_type","left outer");		
		$this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get("payroll_period_group A");
		return $query->row();
	}
	public function validate_period_group($company_id){
		$this->db->where(array(
			'company_id'		=>		$company_id,
			'pay_type'		=>		$this->input->post('pay_type'),
			'group_name'		=>		$this->input->post('group_name')
		));
		$query = $this->db->get("payroll_period_group");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function save_add_payroll_period_group(){


			$this->data = array(
			'pay_type'		=> $this->input->post('pay_type'),
			'company_id'		=> $this->input->post('company_id'),
			'group_name'		=> $this->input->post('group_name'),
			'group_description'		=> $this->input->post('group_description'),
			'date_added'		=> date("Y-m-d h:i:sa"),
			'InActive'			=> 0
		);	
		$this->db->insert('payroll_period_group',$this->data);
	}
	public function validate_edit_payroll_period_group($payroll_period_group_id){
		$this->db->where(array(
			'payroll_period_group_id !=' 		=>		$payroll_period_group_id,
			'pay_type'			=>		$this->input->post('pay_type'),
			'group_name'			=>		$this->input->post('group_name')
		));
		$query = $this->db->get("payroll_period_group");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function check_group_before_delete($id){
		$this->db->where(array(
			'payroll_period_group_id'				=>		$id
		));	
		$query = $this->db->get("payroll_period");
		return $query->row();
	}
	public function deactivate_group($id){
		$this->data = array(
			'InActive'		=> 1,
			'last_status_movement'		=> date("Y-m-d h:i:sa")
		);	
		$this->db->where('payroll_period_group_id',$id);
		$this->db->update('payroll_period_group',$this->data);
	}
	public function activate_group($id){
		$this->data = array(
			'InActive'		=> 0,
			'last_status_movement'		=> date("Y-m-d h:i:sa")
		);	
		$this->db->where('payroll_period_group_id',$id);
		$this->db->update('payroll_period_group',$this->data);
	}
	public function modify_payroll_period_group($payroll_period_group_id){
		$this->data = array(
			'pay_type'		=> $this->input->post('pay_type'),
			'company_id'		=> $this->input->post('company_id'),
			'group_name'		=> $this->input->post('group_name'),
			'group_description'		=> $this->input->post('group_description'),
			'last_modify'		=> date("Y-m-d h:i:sa")
		);	
		$this->db->where('payroll_period_group_id',$payroll_period_group_id);
		$this->db->update('payroll_period_group',$this->data);
	}		
	public function getAll(){
		$this->db->select("B.company_name,A.*");
		$this->db->where(array(
			'A.InActive'			=>		0
		));	
		$this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get("payroll_period A");

		return $query->result();	
	}
	public function payroll_per_per_company_pay_type($company_id,$pay_type_id,$x,$year_cover,$month_cover,$pay_type_group){

		$this->db->select("B.company_name,A.*");
		$this->db->where(array(
			'A.InActive'			=>		0,
			'A.pay_type'			=>		$pay_type_id,
			'A.payroll_period_group_id'			=>		$pay_type_group,
			'A.company_id'			=>		$company_id,
			'A.cut_off'				=>		$x,
			'A.year_cover'				=>		$year_cover,
			'A.month_cover'				=>		$month_cover
		));	
		$this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get("payroll_period A");
		return $query->row();
	}	



	public function oldestPayPeriod($company_id){
		$query=$this->db->query("select year_cover from payroll_period where company_id='".$company_id."' order by year_cover asc limit 1" );
		return $query->row();
	}

	public function payrollperiod_per_company($company_id,$check_year,$check_group){

		if($check_year==""){
				$current_year=date("Y");
			$and_year="AND a.year_cover='".$current_year."' ";
		}else{
			$and_year="AND a.year_cover='".$check_year."' ";
		}

		if($check_group==""){
			$and_group="AND a.payroll_period_group_id!='' ";
		}else{
			$and_group="AND a.payroll_period_group_id='".$check_group."' ";
		}

		$query=$this->db->query("select a.*,b.company_name,c.group_name from payroll_period a inner join company_info b on(a.company_id=b.company_id) inner join payroll_period_group c on(c.payroll_period_group_id=a.payroll_period_group_id) where A.InActive=0 AND A.company_id='".$company_id."' $and_year $and_group" );


		return $query->result();
	}	
	public function save_add_payroll_period(){
		$date_from=$this->input->post('date_from');
		$date_to=$this->input->post('date_to');

		$year_from=substr($date_from, 0,4);
		$month_from=substr($date_from, 5,2);
		$day_from=substr($date_from, 8,2);

		$year_to=substr($date_to, 0,4);
		$month_to=substr($date_to, 5,2);
		$day_to=substr($date_to, 8,2);

		   $from=$year_from."-".$month_from."-".$day_from;        
           $to=$year_to."-".$month_to."-".$day_to;        
                        
                        $date1=date_create($from);
                        $date2=date_create($to);
                        $diff=date_diff($date1,$date2);
                        // echo $diff->format("%R%a");
                        $raw_no_of_days= $diff->format("%a");
                        $no_of_days=$raw_no_of_days+1;

		$pay_code=$year_from.$month_from.$day_from."_".$year_to.$month_to.$day_to;

		$this->data = array(
			'pay_code'			=> $pay_code,
			'month_from'		=> $month_from,
			'day_from'			=> $day_from,
			'year_from'			=> $year_from,
			'month_to'			=> $month_to,
			'day_to'			=> $day_to,
			'year_to'			=> $year_to,
			'no_of_days'		=> $no_of_days,
			'cut_off'			=> $this->input->post('cut_off'),
			'cut_off_day'		=> $this->input->post('cut_off_day'),
			'pay_date'			=> $this->input->post('pay_date'),
			'year_cover'		=> $this->input->post('year_cover'),
			'month_cover'		=> $this->input->post('month_cover'),
			'description'		=> $this->input->post('description'),
			'InActive'			=> 0
		);	
		$this->db->insert('payroll_period',$this->data);
	}

	public function validate_add_payroll_period($value,$company_id,$payroll_period_group_id){

		$this->db->select("*");
		$this->db->where(array(
			'pay_code'			=>		$value,
			'payroll_period_group_id'			=>		$payroll_period_group_id,
			'company_id'		=>		$company_id,
			'InActive'			=>		0
		));	
		$query = $this->db->get("payroll_period");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}
	public function get_payroll_period($id){
		$this->db->select("A.*,B.company_name,C.group_name");
		$this->db->where(array(
			'A.id'				=>		$id,
			'A.InActive'			=>		0
		));	
		$this->db->join("payroll_period_group C","C.payroll_period_group_id = A.payroll_period_group_id","left outer");
		$this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get("payroll_period A");
		return $query->row();
	}
	public function save_edit_payroll_period($id){
		$auto_early_cutoff=$this->input->post('auto_early_cutoff');
		$auto_early_cutoff_start_date=$this->input->post('auto_early_cutoff_start_date');
		if($auto_early_cutoff){
			$auto_early_cutoff=1;
			$date_to=$this->get_payroll_period($id);
			$the_date_to=$date_to->complete_to;
		}else{

		}

		$this->data = array(
			'cut_off'			=> $this->input->post('cut_off'),
			'cut_off_day'		=> $this->input->post('cut_off_day'),
			'pay_date'				=> $this->input->post('pay_date'),
			'year_cover'				=> $this->input->post('year_cover'),
			'month_cover'					=> $this->input->post('month_cover'),
			'description'					=> $this->input->post('description'),
			'will_early_cutoff'				=> $auto_early_cutoff,
			'early_cutoff_start_date'		=> $auto_early_cutoff_start_date,
			'InActive'			=> 0
		);	
		$this->db->where('id',$id);
		$this->db->update('payroll_period',$this->data);

		if($auto_early_cutoff){

			$begin = new DateTime( "$auto_early_cutoff_start_date" );
			$end   = new DateTime( "$the_date_to" );



			for($i = $begin; $i <= $end; $i->modify('+1 day')){
			    echo $early_dc=$i->format("Y-m-d")."<br>";

					//=== delete if already exist.
					$query=$this->db->query("delete from `payroll_period_auto_early_cutoff` where date_covered='".$early_dc."' and payroll_period_id='".$id."' " );
					//=== insert .
					$this->data = array(
					'payroll_period_id'		=> $id,
					'date_covered'			=> $early_dc,
					'log_date'			=> date("Y-m-d h:i:sa")
					);	

					$this->db->insert('payroll_period_auto_early_cutoff',$this->data);

			}

		}else{

		}


	}

	public function get_location($location){//get current location 
		$this->db->where(array(
			'location_id'			=>		$location,
			'InActive'				=>		0
		));	
		$query = $this->db->get("location");
		return $query->row();
	}
	public function get_company($company_id){//get current location 
		$this->db->where(array(
			'company_id'			=>		$company_id,
			'InActive'				=>		0
		));	
		$query = $this->db->get("company_info");
		return $query->row();
	}

	//=======================================manage_payroll_period_employee_group================================
	public function get_employee_group($id){
		$this->db->where(array(
			'payroll_period_group_id'		=>	$id
		));
		$query = $this->db->get("admin_time_payroll_period_employee_group_view"); //admin_time_payroll_period_employee_group_view //testing_
		return $query->result();
	}	
	
	public function check_employee($id){ 
		$id = $this->uri->segment("4");

		$this->db->select("employee_id");	
		$this->db->where('payroll_period_group_id',$id);
		$query = $this->db->get('payroll_period_employees');
		$count = $query->num_rows();
		if($count === 0){
			return false;
		}
		else{
			return true;
		}
	}

	public function get_group_details($id){
		$this->db->where('payroll_period_group_id',$id);
		$query = $this->db->get("payroll_period_group");
		return $query->row();	
	}	

	public function master_save_group_mem($groupmem){
		$this->db->insert('payroll_period_employees',$groupmem);
	}
	public function getLocEmployees($location,$company_id,$pay_type_id){
		// echo "select employee_id from masterlist where location='".$location."' and company_id='".$company_id."' AND pay_type='".$pay_type_id."' AND employee_id NOT IN (SELECT employee_id from payroll_period_employees) ";

		$query = $this->db->query("select employee_id from masterlist where location='".$location."' and company_id='".$company_id."' AND pay_type='".$pay_type_id."' AND employee_id NOT IN (SELECT employee_id from payroll_period_employees) ");
		return $query->result();

	}

	public function get_available_employee($company_id,$pay_type_id){
		// $this->db->select("A.employee_id, A.first_name, A.middle_name, A.last_name, A.name_extension");	
		// $this->db->where('A.InActive',0);
		// $this->db->where('A.pay_type',$pay_type_id);
		// $this->db->where('A.company_id',$company_id);
		// $this->db->where('B.employee_id IS NULL', null, false);
		// $this->db->join("payroll_period_employees B","B.employee_id = A.employee_id","left outer");
		// $query = $this->db->get("employee_info A");


		$query = $this->db->query("SELECT employee_id,first_name,middle_name,last_name,name_extension,location_name FROM masterlist where company_id='".$company_id."' 
			AND pay_type='".$pay_type_id."' AND employee_id NOT IN (SELECT employee_id FROM payroll_period_employees WHERE InActive=0)");
		return $query->result();
	}

	public function insert_employee_group($data){
		 $query = $this->db->insert('payroll_period_employees', $data); 
	}

	public function delete_employee_group($employee_id){
		$this->db->where('employee_id', $employee_id);
		$this->db->delete('payroll_period_employees');
	}

	public function get_employee_availabale_company($company_id){
		$this->db->select("A.employee_id, A.first_name, A.middle_name, A.last_name, A.name_extension, A.pay_type, C.pay_type_name,A.classification,A.location,A.company_id");	
		$this->db->where('A.InActive',0);
		$this->db->where('A.company_id',$company_id);
		$this->db->where('B.employee_id IS NULL', null, false);
		$this->db->join("payroll_period_employees B","B.employee_id = A.employee_id","left outer");
		$this->db->join("pay_type C","C.pay_type_id = A.pay_type","left outer");
		$query = $this->db->get("employee_info A");
		return $query->result();
	}

	public function get_employee_unavailabale_company($company_id){
		$this->db->select("A.employee_id, B.first_name, B.middle_name, B.last_name, B.name_extension, D.pay_type, C.pay_type_name, A.payroll_period_group_id, D.group_name, A.InActive,B.classification,B.location,B.company_id");	
		$this->db->where('B.company_id',$company_id);
		$this->db->join(" employee_info B","B.employee_id = A.employee_id","left outer");
		$this->db->join("payroll_period_group D","D.payroll_period_group_id = A.payroll_period_group_id","left outer");
		$this->db->join("pay_type C","C.pay_type_id = D.pay_type","left outer");
		$query = $this->db->get("payroll_period_employees A");
		return $query->result();
	}

	public function inactive_employee($employee_id){
		$this->data = array(
			'InActive'				=>		1
		);	
		$this->db->where('employee_id',$employee_id);
		$this->db->update("payroll_period_employees",$this->data);
	}

	public function active_employee($employee_id){
		$this->data = array(
			'InActive'				=>		0
		);	
		$this->db->where('employee_id',$employee_id);
		$this->db->update("payroll_period_employees",$this->data);
	}

	public function get_employee_group_count($id){ 
		$this->db->where('payroll_period_group_id',$id);
		$query = $this->db->get('payroll_period_employees');
		return $query->result();
	}

	public function deactivate_group_employee($id){
		$this->data = array(
			'InActive'				=>		1
		);	
		$this->db->where('payroll_period_group_id',$id);
		$this->db->update("payroll_period_employees",$this->data);
	}
	public function activate_group_employee($id){
		$this->data = array(
			'InActive'				=>		0
		);	
		$this->db->where('payroll_period_group_id',$id);
		$this->db->update("payroll_period_employees",$this->data);
	}

	public function delete_group_employee($id){
		$this->db->where('payroll_period_group_id', $id);
		$this->db->delete('payroll_period_employees');
	}


	public function checkPayrollPeriod(){
		
		$payroll_period_group_id=$this->input->post('pay_type_group');
		$date_from=$this->input->post('date_from');
		$date_to=$this->input->post('date_to');
		$year_cover=$this->input->post('year_cover');

		$query=$this->db->query("select id,complete_from,complete_to from payroll_period where payroll_period_group_id='".$payroll_period_group_id."' AND '".$date_from."' BETWEEN `complete_from` AND `complete_to` AND year_cover='".$year_cover."' AND InActive='0' "  );
		return $query->row();
	
	}

	//====================================END OF manage_payroll_period_employee_group============================
}