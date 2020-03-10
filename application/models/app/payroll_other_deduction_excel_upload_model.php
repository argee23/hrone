<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Payroll_other_deduction_excel_upload_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}
	
//GET COMPANY=============================================================	

	public function get_company_name($company){
		$this->db->select('company_name');
		$this->db->where('company_id',$company);
		$query = $this->db->get("company_info");
		return $query->result();
	}
	public function get_company($company_id){
		$this->db->where(array(
			'company_id'	=>		$company_id,
			'InActive'		=>		0
		));	
		$query = $this->db->get("company_info");
		return $query->row();
	}
	

//GET EMPLOYEE FROUP==============================================================
	public function get_lock_period_group_result(){
		$pay_type_id = $this->uri->segment("4");
			$company_id=$this->uri->segment('4');
		$array = array(
			'pay_type' => $pay_type_id,
			'company_id' => $company_id
 
			);

		$this->db->where($array); 

		$query = $this->db->get("payroll_period_group");
		return $query->result();
	}
	public function get_addition_enrollment_table_result($employee_id){
			

		$this->db->where('employee_id',$employee_id);

		$query = $this->db->get("employee_info");
		return $query->result();
	}
	public function paytypeList_addition(){
		// do not include "Daily" , do not create payroll period for daily
		// $this->db->where('pay_type_id !=', '1');
		// $this->db->where('pay_type_id !=', '4');
		$this->db->order_by('pay_type_id','asc');
		$query = $this->db->get("pay_type");
		return $query->result();
	}
	public function get_active_excel_payroll_period_groups($company_id,$pay_type_id){ //active only
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

	public function payroll_per_per_company_pay_type($company_id,$pay_type,$pay_type_group){
			//echo "pay_type_group".$pay_type_group;
		$this->db->select("B.company_name,A.*");
		$this->db->where(array(
			'A.InActive'			=>		0,
			'A.pay_type'			=>		$pay_type,
			'A.payroll_period_group_id'			=>		$pay_type_group,
			'A.company_id'			=>		$company_id
		));	
		$this->db->order_by('A.pay_date','desc');
		$this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get("payroll_period A");
		return $query->result();
	}
	public function get_employeee_license($data){//get_num_license

		$query = $this -> db
       -> select('myhris')
       -> where('id', $data)
       -> limit(1)
       -> get('employee_license');
		return $query->result();

	}//end of get_num_license

	public function get_employee_isEmployee($data){//get number of isEmployee

		return $this -> db
		->where('isEmployee', $data)
		->count_all_results('employee_info');

	}//end of get number of isEmployee	



public function getDeductionTypes($company_id){
		

		  $this->db->select("id,other_deduction_type,other_deduction_code");
		  $this->db->from('other_deduction_type');
		  $this->db->where(array('company_id' => $company_id));
		  $query = $this->db->get();
		  return $query->result();
		 }

public function get_table_emp_enrollment($employee_id){
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("employee_info");
		return $query->result();
	}

	public function get_emp_enrollment_company($employee_id){
		$this->db->select('company_id');
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get("employee_info");
		return $query->result();
	}

public function check_exist($employee_id,$pay_period,$od_id,$company_id){ 

		 $emp_id = $employee_id;
		 $p_period = $pay_period;
		 $o_d_id = $od_id;
		 $comp_id = $company_id;

		
		$this->db->where('company_id', $comp_id);
		$this->db->where('payroll_period_id', $p_period);
		$this->db->where('other_deduction_id', $o_d_id);
		$this->db->where('employee_id', $emp_id);
		$query = $this->db->get('other_deduction_enrollment');

		$count = $query->num_rows();
        if ($count > 0) {
         	return true;
        }
        else{
        	return false;
        }
	}

	public function employee_company_checker_model($employee_companylist,$company,$pt_id)
	{
		$this->db->select('employee_id,company_id');
		$this->db->from('employee_info');
		$this->db->where('employee_id',$employee_companylist);
		$this->db->where('pay_type',$pt_id);
		$this->db->where('company_id',$company);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			{
	    		return true; 
			}
			else{ return false; }
	}



public function insertImport($data)//model for insertImport
    {
        $query = $this->db->insert('other_deduction_enrollment', $data); 
		if(!$query)
		{
		   return False;
		}
		else
		{
			return TRUE;
		}

    }//end of insertImport

public function get_all_employeeName_DB(){//get the all employee_name

		$query = $this -> db
       ->select('first_name,middle_name,last_name,birthday')
       ->where('isEmployee', 1)
       ->get('employee_info');
		return $query->result();

	}//end of get all employee_id

public function get_all_employeeID_DB(){//get the all employee_id 

		$query = $this -> db
       ->select('employee_id')
       ->where('isEmployee', 1)
       ->get('employee_info');
		return $query->result();

	}//end of get all employee_id

/*function postDiamond($result)
{
    $this->db->insert('other_addition_enrollment',$result);
    return true;
}
*/

public function empidnotexist($emp_id_checker)
    {    
        $this->db->where('employee_id', $emp_id_checker);
        $this->db->where('InActive',0);
		$query = $this->db->get('employee_info');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}

public function odidnotexist($od_id_checker)
    {    
        $this->db->where('id', $od_id_checker);
        $this->db->where('InActive_type',0);
		$query = $this->db->get('other_deduction_type');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}	

}

	