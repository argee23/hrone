<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Payroll_other_deduction_emp_enrollment_model extends CI_Model{

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
	public function paytypeList_deduction(){
		// do not include "Daily" , do not create payroll period for daily
		// $this->db->where('pay_type_id !=', '1');
		// $this->db->where('pay_type_id !=', '4');
		$this->db->order_by('pay_type_id','asc');
		$query = $this->db->get("pay_type");
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
		
//GET ALL EMPLOYEE================================================================	
	public function get_deduction_employeeList($company_id,$comp_division_setting,$sub_sec_setting,$pay_type_group){


		/*check company division setup \with division or none\*/
		if($comp_division_setting=="1"){ // division applicable
			$division=$this->input->post('division');
			if($division=="All"){
				$check_employee_division="";
			}else{
				$check_employee_division="AND ei.division_id='$division' ";
			}

		}else{
				$check_employee_division="";
			 // division not applicable
			//echo "division not applicable";
		}
		/*check selected department*/
		$department=$this->input->post('department');
		if($department=="All"){
			$check_employee_dept="";
		}else{
			$check_employee_dept="AND ei.department='$department'";
		}
		/*check selected section*/
		$section=$this->input->post('section');
		if($section=="All"){
			$check_employee_sect="";
			$sub_section="";
			$check_employee_sub_section="";
		}else{
			$check_employee_sect="AND ei.section='$section'";
			if($sub_sec_setting=="1"){ // sub section applicable
				$sub_section=$this->input->post('sub_section');
					if($sub_section=="All"){
						$check_employee_sub_section="";
					}else{
						$check_employee_sub_section="AND ei.subsection='$sub_section'";
					}
			}else{
				//echo "sub section not applicable";
				$check_employee_sub_section="";
			}
			

		}

		/*selected employee pay type*/
		$employee_pay_type=$this->input->post('pay_type');
		$check_employee_pay_type="AND (ei.pay_type='".$employee_pay_type."')"; 


		
		/*selected location/s*/
		$raw_location="";
		foreach ($this->input->post('location') as $key => $location_id)
		{
		$raw_location.= "ei.location=".$location_id." OR ";
		}
		$locations = substr($raw_location, 0, -4);  // remove OR sa dulo
		$selected_locations= "AND (".$locations.")";

		/*selected classification/s*/
		$raw_classification="";
		foreach ($this->input->post('classification') as $key => $classification_id)
		{
		$raw_classification.= "ei.classification=".$classification_id." OR ";
		}
		$classifications = substr($raw_classification, 0, -4);  // remove OR sa dulo
		$selected_classifications= "AND (".$classifications.")";

		/*selected employment/s*/
		$raw_employment="";
		foreach ($this->input->post('employment') as $key => $employment_id)
		{
		$raw_employment.= "ei.employment=".$employment_id." OR ";
		}
		$employments = substr($raw_employment, 0, -4);  // remove OR sa dulo
		$selected_employments= "AND (".$employments.")";

		/*
		tables

		ei : employee_info
		dep : department
		sect : section
		pos : position
		empl : employment
		clas : classification
		pt : pay_type
		loc : location
		si : salary_information
		period_group : payroll_period_employees
		*/

$query=$this->db->query("SELECT ei.*,dep.dept_name,sect.section_name,sect.wSubsection,pos.position_name,empl.employment_name,clas.classification,pt.pay_type_name,loc.location_name,period_group.payroll_period_group_id,
			concat(ei.last_name,', ',ei.first_name,' ',ei.middle_name) as name FROM employee_info ei
			INNER JOIN position pos ON (ei.position=pos.position_id) 
			INNER JOIN department dep ON (ei.department=dep.department_id) 
			INNER JOIN section sect ON (ei.section=sect.section_id) 
			INNER JOIN employment empl ON (ei.employment=empl.employment_id) 
			INNER JOIN classification clas ON (ei.classification=clas.classification_id) 
			INNER JOIN pay_type pt ON (ei.pay_type=pt.pay_type_id) 
			INNER JOIN location loc ON (ei.location=loc.location_id) 
			INNER JOIN payroll_period_employees period_group ON (ei.employee_id=period_group.employee_id) 
			WHERE ei.isEmployee='1' $check_employee_pay_type $check_employee_division $check_employee_dept $check_employee_sect $check_employee_sub_section $selected_locations $selected_classifications $selected_employments AND period_group.InActive='0' AND period_group.payroll_period_group_id='".$pay_type_group."' AND ei.company_id='".$company_id."'  ");

		return $query->result();	
	}



public function getDeductionEnrollments(){
		
		$pay_period=$this->input->post('pay_period');
		 $this->db->order_by('id','asc');
		 $this->db->where('payroll_period_id',$pay_period);
		$query = $this->db->get("other_deduction_enrollment");
		 if ($query->num_rows() > 0)
		  {
		  return $query->result();
		 }
		 else{
		 	return FALSE;
		 }

		 }




public function getDeductionTypes($company_id){
		

		 $this->db->select("id,other_deduction_type,other_deduction_code");
		  	$this->db->where(array(
			'company_id'		=>		$company_id
			));
		  $this->db->from('other_deduction_type');
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

//ADDING AND VALIDATING ADDITION EMPLOYEE ENROLLMENT=================================================
	public function validate_addition_enrollment(){
		 $company_id =$this->input->post('company_id');		
		$this->db->select("employee_id");
		$this->db->where(array(
			
			'employee_id'		=>		$this->input->post('employee_id'),
			'company_id'		=>		$company_id
		));
		$query = $this->db->get("other_deduction_enrollment");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}





function save_deduction_enrollment(){  

		$arr_od = array(); 

		$this->db->select("id"); 
		$other_deduction_type = $this->db->get("other_deduction_type");
		if($other_deduction_type->num_rows()>0){
			foreach($other_deduction_type->result() as $data){
				
				$arr_od[$data->id] = $data->id;
				
			}
		}

		$this->db->select("id"); 
		$payroll_period = $this->db->get("payroll_period");
		if($payroll_period->num_rows()>0){
			foreach($payroll_period->result() as $datas){
				
				$arr_pp[$data->id] = $datas->id;
				
			}
		}




		$this->db->select("employee_id,other_deduction_id,payroll_period_id,amount"); 
		$other_deduction_enrollment = $this->db->get("other_deduction_enrollment");
		if($other_deduction_enrollment->num_rows()>0){
			foreach($other_deduction_enrollment->result() as $datas){
				
				$arr_exist[$datas->employee_id] = $datas->employee_id;
				$arr_exist[$datas->payroll_period_id] = $datas->payroll_period_id;
				
			}
		}

		//$this->db->where(array('id'=>null, 'id'=>null));  
		$this->db->select("employee_id,id"); 
		$employee_info = $this->db->get("employee_info");
		if($employee_info->num_rows()>0){
			foreach($employee_info->result() as $data){
				
			 if($this->input->post('cod'.$data->employee_id)==1){
				  foreach($arr_od as $rs_od){
					
					if(isset($rs_od) && $this->input->post('od'.$rs_od.'-'.$data->employee_id)>0){
							
							// ang condition mo dito emp_id nya, od_id at cutoff_id(kun meron) payroll_period po ang meron sir
						//para kada upadte tanggalin un naka save tapos add new
						//parang if exist tama diba sir

if(!empty($arr_exist)){
							if($arr_exist >0){
							$this->db->delete("other_deduction_enrollment", array('other_deduction_id' => $rs_od, 'employee_id'=>$data->employee_id,'payroll_period_id' => $this->input->post('pay_period')));
							}
}else{

}

								$amount = $this->input->post('od'.$rs_od.'-'.$data->employee_id);
								$this->data = array();
								$this->data = array(
								'company_id'			=> $this->input->post('company_id'),
								'employee_id' 			=> $data->employee_id,
								'payroll_period_id'		=> $this->input->post('pay_period'),
								'other_deduction_id' 	=> $rs_od,
								'amount'				=> $amount,
								'entry_type'			=> $this->input->post('entry_type'),
								'date_added' 			=> date('Y-m-d H:i:s')
								);	
								$this->db->insert('other_deduction_enrollment',$this->data);

							//dinagdag ko lang po yun sir		
						}else{ 
							//bakit may delete?
						//pag 0 po yung iniiput madedelete po magiging 0 po yung record ulit
								$this->db->delete("other_deduction_enrollment", array('other_deduction_id' => $rs_od, 'employee_id'=>$data->employee_id));
								//$this->db->select('oa'.$rs_oa.);
								//$this->db->query('Delete FROM other_addition_enrollment where `other_addition_id` = ')//==gawa kadelete query

						}
					
					}
				}  
			}
		}
		//redirect(base_url().'app/payroll_other_addition_emp_enrollment/index',$this->data);

	}


}

	