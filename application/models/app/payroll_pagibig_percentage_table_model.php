<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Payroll_pagibig_percentage_table_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}
	

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

public function get_list_result(){
		$company = $this->uri->segment('4');
	
		$this->db->where('company_id',$company);

		$query = $this->db->get("payroll_pagibig_percentage_table");
		return $query->result();
	}

public function get_pagibig_date($company_id){
		$this->db->distinct();
		$this->db->order_by('covered_year','desc');
		$this->db->select('covered_year');
		$this->db->where('company_id',$company_id);
		$query = $this->db->get("payroll_pagibig_percentage_table");
		return $query->result();
	}

public function load_pagibig_result($date,$company_id){
		$this->db->where(array(
			'company_id'			=>		$company_id,
			'covered_year'			=>		$date

			
		));
		$this->db->order_by('pi_percentage_id','asc');
		$query = $this->db->get("payroll_pagibig_percentage_table");
		return $query->result();
	}

//======================================ADD/VALIDATE PAGIBIG PERCENTAGE LIST===========================================
public function validate_amount_from(){
		 $company_id =$this->input->post('company_id');		
		   $c_year =$this->input->post('covered_year');	
		$this->db->select("amount_from");
		$this->db->where(array(
			'amount_from'		=>		$this->input->post('amount_from'),
			'covered_year'		=>		$c_year,
			'company_id'		=>		$company_id 
			
		));
		$query = $this->db->get("payroll_pagibig_percentage_table");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
public function validate_amount_to(){
		 $company_id =$this->input->post('company_id');		
		   $c_year =$this->input->post('covered_year');	
		$this->db->select("amount_to");
		$this->db->where(array(
			'amount_to'		=>		$this->input->post('amount_to'),
			'covered_year'	=>		$c_year,
			'company_id'	=>		$company_id 
			
		));
		$query = $this->db->get("payroll_pagibig_percentage_table");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
   public function AddNewPagibigPercentage($post)
        {

        		$this->data = array(
        			'company_id' 			=> $this->input->post('company_id'),
                	'amount_from' 			=> $this->input->post('amount_from'),
                	'amount_to' 			=> $this->input->post('amount_to'),
                	'employee_share' 		=> $this->input->post('employee_share'),
                	'employer_share' 		=> $this->input->post('employer_share'),
                	'covered_year' 			=> $this->input->post('covered_year'),
                	'InActive'				=> 0,
                	'date_added'			=> date('Y-m-d H:i:s')
                	

			
		);	
		$this->db->insert('payroll_pagibig_percentage_table',$this->data);
		}	

//================================= PAGIBIG PERCENTAGE EDIT LIST============================================
	public function validate_edit_amount_from($id){
		$company_id =$this->input->post('company_id');
		$c_year =$this->input->post('covered_year');
		$amt_to =$this->input->post('amount_to');
		$empe_share =$this->input->post('employee_share');
		$empr_share =$this->input->post('employer_share');	
		$this->db->select("amount_from");

		$this->db->where(array(
			'pi_percentage_id !=' 	=>		$id,
			'amount_to'				=>		$amt_to,
			'employee_share'		=>		$empe_share,
			'employer_share'		=>		$empr_share,
			'covered_year'			=>		$c_year,
			'company_id'			=>		$company_id 
			
		));
		$query = $this->db->get("payroll_pagibig_percentage_table");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function validate_edit_amount_to($id){
		$company_id = $this->input->post('company_id');	
		$c_year =$this->input->post('covered_year');
	    $amt_fr =$this->input->post('amount_from');
		$empe_share =$this->input->post('employee_share');
		$empr_share =$this->input->post('employer_share');
		$this->db->select("amount_to");
		$this->db->where(array(
			'pi_percentage_id !='   =>		$id,
			'amount_from'			=>		$amt_fr,
			'employee_share'		=>		$empe_share,
			'employer_share'		=>		$empr_share,
			'covered_year'			=>		$c_year,
			'company_id'		    =>		$company_id 
			
		));
		$query = $this->db->get("payroll_pagibig_percentage_table");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function list_table_edit(){ 
		$id	 = $this->input->post('pi_percentage_id');
		$this->data = array(
					'company_id' 			=> $this->input->post('company_id'),
                	'amount_from' 			=> $this->input->post('amount_from'),
                	'amount_to' 			=> $this->input->post('amount_to'),
                	'employee_share' 		=> $this->input->post('employee_share'),
                	'employer_share' 		=> $this->input->post('employer_share'),
                	'covered_year' 			=> $this->input->post('covered_year'),
                	'InActive'				=> 0,
                	'date_updated'			=> date('Y-m-d H:i:s')

			
					);	
		$this->db->where('pi_percentage_id',$id);
		$this->db->update("payroll_pagibig_percentage_table",$this->data);
	}

//== FOR DISABLING PAGIBIG LIST=======================================================================
	public function delete_lists($id){
		$this->db->where(array(
			'pi_percentage_id'		=>	$id
		));		
		$query = $this->db->get("payroll_pagibig_percentage_table");
		return $query->row();
	}
	public function deactivate_list($id){
		$this->db->where('pi_percentage_id',$id);
		$this->data = array('InActive'=>1);
		$this->db->update("payroll_pagibig_percentage_table",$this->data);	
	}
	public function activate_list($id){
		$this->db->where('pi_percentage_id',$id);
		$this->data = array('InActive'=>0);
		$this->db->update("payroll_pagibig_percentage_table",$this->data);	
	}

}