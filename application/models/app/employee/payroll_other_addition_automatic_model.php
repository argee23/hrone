<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Payroll_other_addition_automatic_model extends CI_Model{

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
	

//GETTING ADDITION TYPE LIST==============================================================
	
	public function addition_type_list($company_id){
		// do not include "Daily" , do not create payroll period for daily
		// $this->db->where('pay_type_id !=', '1');
		// $this->db->where('pay_type_id !=', '4');
		$this->db->order_by('id','asc');
		$this->db->where(array(
			'company_id'   => $company_id,
			'is_automatic' => 1
			));
		$query = $this->db->get("other_addition_type_automatic");
		return $query->result();
	}
	
	public function addition_type_list_modal($pay_type,$company_id){
		// do not include "Daily" , do not create payroll period for daily
		// $this->db->where('pay_type_id !=', '1');
		// $this->db->where('pay_type_id !=', '4');
		
		$this->db->where(array(
			'id' 			=> $pay_type,
			'company_id'	=> $company_id
			));
		$query = $this->db->get("other_addition_type");
		return $query->result();
	}
	
	public function get_addition_result_add($company_id){
		

		 $this->db->select("id,other_addition_type,other_addition_code");
		  	$this->db->where(array(
			'company_id'		=>		$company_id
			));
		  $this->db->from('other_addition_type');
		  $query = $this->db->get();
		  return $query->result();
		 }

	public function get_addition_name($id,$company_id){
		
		 $this->db->select("id,other_addition_type,other_addition_code");
		  	$this->db->where(array(
			'company_id'		=>		$company_id,
			'id'				=>		$id
			));
		  $this->db->from('other_addition_type');
		  $query = $this->db->get();
		  return $query->result();
		 }


	public function get_addition_result_edit($oa_id,$company_id){
		

		 $this->db->select("id,other_addition_type,other_addition_code");
		  	$this->db->where(array(
			'company_id'		=>		$company_id,
			'id'				=>		$oa_id
			));
		  $this->db->from('other_addition_type');
		  $query = $this->db->get();
		  return $query->result();
		 }

	public function paytypeList_addition(){
		// do not include "Daily" , do not create payroll period for daily
		// $this->db->where('pay_type_id !=', '1');
		// $this->db->where('pay_type_id !=', '4');
		$this->db->order_by('pay_type_id','asc');
		//$this->db->where(array('is_automatic'=>0));
		$query = $this->db->get("pay_type");
		return $query->result();
	}


	 public function pay_type_option()
	 {
	 	$this->db->select('*');
		$this->db->from('system_parameters');
		$this->db->where('cCode','cut_off');
	 	$pay_type_option = $this->db->get();
		return $pay_type_option->result();
	 }


	 public function viewDetails_model($cutoff,$pay_type,$date_effective,$oa_id,$company_id,$id)
	{
		$this->db->select('*');
		$this->db->from('other_addition_type_automatic');
		
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->result();
	}

//GETTING THE LIST OF EMPLOYEE ENROLL TO THIS PAYTYPE================================================

	public function list_enroll_emp_paytype($oa_id,$cut_off_id,$pay_type,$company_id){

		$this->db->select('*');
		$this->db->where(array(
			
			'company_id' 		=> $company_id,
			'cutoff' 			=> $cut_off_id,
			'other_addition_id' => $oa_id,
			'pay_type'   		=> $pay_type

			));
		$query = $this->db->get("other_addition_automatic");
			
		$count = $query->num_rows();
        if ($count > 0) {
         	return true;
        }
        else{
        	return false;
        }
		
		


//		return $query->result();
	}

public function paytypeList_addition_selected($pay_type){
		// do not include "Daily" , do not create payroll period for daily
		// $this->db->where('pay_type_id !=', '1');
		// $this->db->where('pay_type_id !=', '4');
		$this->db->order_by('pay_type_id','asc');
		$this->db->where(array('pay_type_id' => $pay_type));
		$query = $this->db->get("pay_type");
		return $query->result();
	}

public function getting_addition($oa_id){
		$this->db->select('other_addition_type,other_addition_code');
		$this->db->where(array(
			'id'		=>	$oa_id
		));		
		$query = $this->db->get("other_addition_type");
		return $query->row();
	}


//== FOR DISABLING AUTOMATIC=======================================================================
	public function delete_lists($id){
		$this->db->where(array(
			'id'		=>	$id
		));		
		$query = $this->db->get("other_addition_type");
		return $query->row();
	}
	public function deactivate_list($id){
		$this->db->where('id',$id);
		$this->data = array('InActive'=>1);
		$this->db->update("other_addition_type_automatic",$this->data);	
	}
	public function activate_list($id){
		$this->db->where('id',$id);
		$this->data = array('InActive'=>0);
		$this->db->update("other_addition_type_automatic",$this->data);	
	}

//CHECK IF ALREADY EXIST=====================================================================================
 public function check_exist_auto($cutoff,$company_id,$id,$effectivity_date,$pay_type,$is_automatic){ 

		 $company = $company_id;
		 $other_addition_id = $id;
		 $pay_type_id = $pay_type;
		 $automatic = $is_automatic;

		
		$this->db->where('company_id', $company);
		$this->db->where('pay_type', $pay_type_id);
		$this->db->where('other_addition_id', $other_addition_id);
		$this->db->where('is_automatic', $automatic);
		$query = $this->db->get('other_addition_type_automatic');

		$count = $query->num_rows();
        if ($count > 0) {
         	return true;
        }
        else{
        	return false;
        }
	}


//SAVING NEW SET AUTOMATIC==================================================================================
public function automatic_addition_saves($cutoff,$company_id,$id,$effectivity_date,$pay_type,$is_automatic){ 
		
		 $cut_off = $cutoff;
		 $company = $company_id;
		 $other_addition_id = $id;
		 $auto_effective_date = $effectivity_date;
		 $pay_type_id = $pay_type;
		 $automatic = $is_automatic;

		 $option_result = substr_replace($cut_off, "", -1);
		if($option_result=='1-2-3-4-5' AND $pay_type=='1')
		{
			$option1 = '6';
		}
		else if($option_result=='1-2' AND $pay_type=='2' || $pay_type=='3')
		{
			$option1 = '6';
		}
		else{
			$option1=$option_result;
		}

		$this->data = array(
					'cutoff'					=>	$option1,
        			'company_id'				=> 	$company,
        			'other_addition_id'			=> 	$other_addition_id,
        			'auto_effectivity_date'		=>	$auto_effective_date,
        			'pay_type'					=>	$pay_type_id,
                	'is_automatic'				=>	$automatic,
					'InActive'					=>  0,
					'date_added' 	    		=> date('Y-m-d H:i:s')

			
		);	
		$this->db->insert('other_addition_type_automatic',$this->data);

	}

//UPDATE SET AUTOMATIC WITH EMPLOYEE==================================================================================
public function automatic_addition_saves_e($cutoff,$company_id,$id,$oa_id,$effectivity_date,$pay_type,$is_automatic){ 
		//$id	= $this->input->post('addition_id');
			

		$this->data = array(
			
			'is_automatic'				=>	$is_automatic,
			'auto_effectivity_date'		=>	$effectivity_date,
			'pay_type'					=>	$pay_type,
			'other_addition_id'			=>	$oa_id,
			'cutoff'					=>	$cutoff,
			'date_updated'    			=> date('Y-m-d H:i:s')

								);	
		$this->db->where('id',$id);
		$this->db->update("other_addition_type_automatic",$this->data);

		$this->data = array(
			
			'date_effective'			=>	$effectivity_date

								);	
		$this->db->where(array(

			'company_id' 		=> $company_id,
			'other_addition_id' => $oa_id,
			'cutoff' 			=> $cutoff,
			'pay_type'			=> $pay_type
			));
		$this->db->update("other_addition_automatic",$this->data);
	}

//UPDATE SET AUTOMATIC WITHOUT EMPLOYEE==================================================================================
public function automatic_addition_saves_ne($cutoff,$company_id,$id,$oa_id,$effectivity_date,$pay_type,$is_automatic){ 
		//$id	= $this->input->post('addition_id');
		$pay_type_id = $pay_type;

		 $option_result = substr_replace($cutoff, "", -1);
		if($option_result=='1-2-3-4-5' AND $pay_type_id=='1')
		{
			$option1 = '6';
		}
		else if($option_result=='1-2' AND $pay_type_id=='2' || $pay_type_id=='3')
		{
			$option1 = '6';
		}
		else{
			$option1=$option_result;
		}

		
		$this->data = array(
			
			'is_automatic'				=>	$is_automatic,
			'auto_effectivity_date'		=>	$effectivity_date,
			'pay_type'					=>	$pay_type_id,
			'other_addition_id'			=>	$oa_id,
			'cutoff'					=>	$option1,
			'date_updated'   		    => date('Y-m-d H:i:s')
								);	
		$this->db->where('id',$id);
		$this->db->update("other_addition_type_automatic",$this->data);
	}

//GETTING FLASHING VALUE FOR ADD==========================================================================
public function flash_add_update($id){
		$this->db->where(array(
			'id'		=>	$id
		));		
		$query = $this->db->get("other_addition_type");
		return $query->row();
	}
public function flash_add_updates($oa_id){
		$this->db->where(array(
			'id'		=>	$oa_id
		));		
		$query = $this->db->get("other_addition_type");
		return $query->row();
	}	
//IS AUTOMATIC TO ZERO==============================================================================
	public function delete_auto($oa_id){
		$this->db->where(array(
			'id'		=>	$oa_id
		));		
		$query = $this->db->get("other_addition_type");
		return $query->row();
	}
	public function is_automatic_to_zero($company_id,$id){
		$this->db->where(array(
					'id' 			=> $id,
					'company_id'	=> $company_id
			));
		$this->data = array('is_automatic' => 0);
		$this->db->update("other_addition_type_automatic",$this->data);	
	}




//START OF ENROLLING EMPLOYEE SET AUTOMATIC======================================================================

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

//GETTING EMPLOYEE BY FILTERING============================================================================================
public function get_addition_employeeList($company_id,$comp_division_setting,$sub_sec_setting,$pay_type_group){
		//eto po yung function ng pagget nila ng employee

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
		$selected_locations ="";
		
	foreach ($this->input->post('location') as $key => $location_id)
		{
			
		$raw_location.= "ei.location=".$location_id." OR ";
		}
		$locations = substr($raw_location, 0, -4);
		  // remove OR sa dulo
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
		

public function getAdditionEnrollments(){
		
		$cutoff=$this->input->post('cutoff');
		 $this->db->order_by('id','asc');
		 $this->db->where('cutoff',$cutoff);
		$query = $this->db->get("other_addition_automatic");
		 if ($query->num_rows() > 0)
		  {
		  return $query->result();
		 }
		 else{
		 	return FALSE;
		 }

		 }

public function getAdditionTypes($company_id){
		

		 $this->db->select("id,other_addition_type,other_addition_code");
		  	$this->db->where(array(
			'company_id'		=>		$company_id
			));
		  $this->db->from('other_addition_type');
		  $query = $this->db->get();
		  return $query->result();
		 }

public function getoaid($o_a_id,$company_id){
		

		 $this->db->select("id,other_addition_type,other_addition_code");
		  	$this->db->where(array(
			'company_id'		=>		$company_id,
			'id'				=>		$o_a_id
			));
		  $this->db->from('other_addition_type');
		  $query = $this->db->get();
		  return $query->result();
		 }		 

public function all_formula_by_tier(){
		

		 $this->db->select("*");
		  	$this->db->where(array(
			'formula_tier'		=> 15
			
			));
		  $this->db->from('payroll_formulas');
		  $query = $this->db->get();
		  return $query->result();
		 }	

public function formula_by_tier(){
		

		 $this->db->select("formula_id,formula_description");
		  	$this->db->where(array(
			'formula_tier'		=> 15
			
			));
		  $this->db->from('payroll_formulas');
		  $query = $this->db->get();
		  return $query->result();
		 }	

function save_addition_enroll_automatic(){  

		$arr_oa = array(); 

		$this->db->select("id"); 
		$other_addition_type = $this->db->get("other_addition_type");
		if($other_addition_type->num_rows()>0){
			foreach($other_addition_type->result() as $data){
				
				$arr_oa[$data->id] = $data->id;
				
			}
		}

		$this->db->select("employee_id,other_addition_id,pay_type,cutoff,open_entry"); 
		$other_addition_automatic = $this->db->get("other_addition_automatic");
		if($other_addition_automatic->num_rows()>0){
			foreach($other_addition_automatic->result() as $data){
				
				$arr_exist[$data->employee_id] = $data->employee_id;
				
			}
		}

		//$this->db->where(array('id'=>null, 'id'=>null));  
		$this->db->select("employee_id,id"); 
		$employee_info = $this->db->get("employee_info");
		if($employee_info->num_rows()>0){
			foreach($employee_info->result() as $data){
				

				foreach($arr_oa as $rs_oa){
						if($this->input->post('coa'.$rs_oa.'-'.$data->employee_id)==1){
				
					
						
						if(isset($rs_oa) && $this->input->post('oa'.$rs_oa.'-'.$data->employee_id)>0 || isset($rs_oa) && $this->input->post('pf'.$rs_oa.'-'.$data->employee_id)>0){

							if(!empty($arr_exist)){
								if($arr_exist >0){
								$this->db->delete("other_addition_automatic", array('other_addition_id' => $rs_oa, 'employee_id'=>$data->employee_id,'pay_type' => $this->input->post('pay_type'),'cutoff' => $this->input->post('cutoff')));
								}
							}else{

							}


								$optional_open_entry = $this->input->post('optional'.$rs_oa.'-'.$data->employee_id);
								$amount = $this->input->post('oa'.$rs_oa.'-'.$data->employee_id);
								$payroll_formulas = $this->input->post('pf'.$rs_oa.'-'.$data->employee_id);
		 						$this->data = array();
								$this->data = array(
					        		'company_id'			=> $this->input->post('company_id'),
					        		'employee_id' 			=> $data->employee_id,
					        		'cutoff'				=> $this->input->post('cutoff'),
					                'other_addition_id' 	=> $rs_oa,
					            	'open_entry'			=> $amount,
					            	'optional_open_entry'	=> $optional_open_entry,
					            	'payroll_formulas_id'	=> $payroll_formulas,
					            	'date_effective'		=> $this->input->post('effective_date'),
					            	'pay_type'				=> $this->input->post('pay_type'),
					                'entry_type'			=> $this->input->post('entry_type'),
					                'date_added' 			=> date('Y-m-d H:i:s')
		                				);	
									$this->db->insert('other_addition_automatic',$this->data);


						}else{ 
								$this->db->delete("other_addition_automatic", array('other_addition_id' => $rs_oa, 'employee_id'=> $data->employee_id));
								//$this->db->select('oa'.$rs_oa.);
								//$this->db->query('Delete FROM other_addition_enrollment where `other_addition_id` = ')//==gawa kadelete query

						}
						
					} 

				}


			}
		}
		//redirect(base_url().'app/payroll_other_addition_emp_enrollment/index',$this->data);

	}


//MANUAL EXCEL UPLOAD SET AUTOMATIC==================================================================================
public function empidnotexist($emp_id_checker,$company,$pt_id)
    {    
        $this->db->where('employee_id', $emp_id_checker);
        $this->db->where('company_id',$company);
         $this->db->where('pay_type',$pt_id);
        $this->db->where('InActive',0);
		$query = $this->db->get('employee_info');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}

public function pfidnotexist($pf_id_checker)
    {   
    	$this->db->select('formula_id,formula_tier'); 
        $this->db->where('formula_id', $pf_id_checker);
      	$this->db->where('formula_tier', 15);
		$query = $this->db->get('payroll_formulas');
		$count = $query->num_rows();
        //echo $count;
        if ($count === 0) {
         	return false;
    	}
	}

public function check_exist($employee_id,$pay_type,$oa_id,$company_id,$cut_off){ 

		 $emp_id = $employee_id;
		 $paytype = $pay_type;
		 $o_a_id = $oa_id;
		 $comp_id = $company_id;
		 $cutoff = $cut_off;
		
		$this->db->where('company_id', $comp_id);
		$this->db->where('pay_type', $paytype);
		$this->db->where('other_addition_id', $o_a_id);
		$this->db->where('employee_id', $emp_id);
		$this->db->where('cutoff', $cutoff);
		$query = $this->db->get('other_addition_automatic');

		$count = $query->num_rows();
        if ($count > 0) {
         	return true;
        }
        else{
        	return false;
        }
	}

public function insertImport($data)//model for insertImport
    {
        $query = $this->db->insert('other_addition_automatic', $data); 
		if(!$query)
		{
		   return False;
		}
		else
		{
			return TRUE;
		}

    }//end of insertImport

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


public function pf_id_checker_model($getpf)
	{
		$this->db->select('formula_id,formula_tier');
		$this->db->from('payroll_formulas');
		$this->db->where('formula_id',$getpf);
		$this->db->where('formula_tier',15);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			{
	    		return true; 
			}
			else{ return false; }
	}

 } //MODEL  





































//SAVING AND VALIDATING ADDITION AUTOMATIC======================================================

/*public function validate_save_addition_automatic($id){
		 $company_id =$this->input->post('company_id');		
		$this->db->select("is_automatic");
		$this->db->where(array(
			
			'is_automatic'	=>		$this->input->post('is_automatic')
			
		));
		$query = $this->db->get("other_addition_type");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function automatic_additon_save(){ 
		$id	= $this->input->post('addition_id');
		$this->data = array(
			
			'is_automatic'				=>	$this->input->post('is_automatic'),
			'auto_effectivity_date'		=>	$this->input->post('effectivity_date'),
			'auto_will_deduct_on'		=>	$this->input->post('auto_will_deduct_on'),
			'date_created' 				=> date('Y-m-d H:i:s'),
			'InActive'  				=> 0
					);	
		$this->db->where('id',$id);
		$this->db->update("other_addition_type",$this->data);

	}
*/