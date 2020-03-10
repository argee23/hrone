<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Payroll_lock_period_model extends CI_Model{

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

	public function get_lock_period_group_result(){
		$company 	= $this->uri->segment("4");
	
		$this->db->where('company_id',$company);

		$query = $this->db->get("payroll_period_group");
		return $query->result();
	}

	public function get_lock_period_table_result($company_id,$pay_type,$payroll_period_group_id){
		$this->db->select("B.company_name,A.*");
		$this->db->where(array(
			'A.InActive'			=>		0,
			'A.pay_type'			=>		$pay_type,
			'A.payroll_period_group_id'			=>		$payroll_period_group_id,
			'A.company_id'			=>		$company_id
		));	
		$this->db->order_by('A.pay_date','desc');
		$this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get("payroll_period A");
	
		return $query->result();
	}


public function getLockPeriod($id){
			//$this->db->where('id',$id);


		  $this->db->select("payroll_period.id,payroll_period.payroll_period_group_id,payroll_period.pay_code,payroll_period.company_id,payroll_period.month_from,payroll_period.day_from,payroll_period.year_from,payroll_period.month_to,payroll_period.day_to,payroll_period.year_to,payroll_period.no_of_days,lock_payroll_period.payroll_period_id,lock_payroll_period.create_transaction,lock_payroll_period.d_t_r,lock_payroll_period.deduct_add_adjustment,lock_payroll_period.generate_payslip,lock_payroll_period.date_added,lock_payroll_period.date_updated");
		  $this->db->from('lock_payroll_period');
		  $this->db->join('payroll_period', 'payroll_period.id = lock_payroll_period.payroll_period_id');
		  $query = $this->db->get();
		  return $query->result();
		
		 }


public function get_lock_period_result($year_from){
		$year_from 	= $this->uri->segment("4");
		$payroll_period_group_id 	= $this->uri->segment("4");

		if($year_from != 0){
			$this->db->where('year_from',$year_from);
		}
		$this->db->where('year_from',$year_from);

		$query = $this->db->get("payroll_period");
		return $query->result();
	}


public function get_table_lock_period($id){
		$this->db->where('id',$id);
		$query = $this->db->get("payroll_period");
		return $query->result();
	}

	public function get_lock_period_company($id){
		$this->db->select('company_id');
		$this->db->where('id',$id);
		$query = $this->db->get("payroll_period");
		return $query->result();
	}

//CHECK IF ALREADY EXIST=====================================================================================
 public function get_paycode($id,$comp_id){ 

		 $company_id = $comp_id;
		 $l_id = $id;
		/* $pay_code = $paycode;
		 $pay_type = $paytype;
		 $group_id = $groupid;*/

		
		$this->db->where('company_id', $company_id);
		$this->db->where('id', $l_id);
		/*$this->db->where('pay_code', $pay_code);
		$this->db->where('id', $group_id);*/
		$query = $this->db->get('lock_payroll_period');

		$count = $query->num_rows();
        if ($count > 0) {
         	return true;
        }
        else{
        	return false;
        }
	}

//ADDING AND VALIDATING LOCK PERIOD=================================================
	public function validate_lock_period(){
		$company_id =$this->input->post('company_id');		
		$this->db->select("pay_code");
		$this->db->where(array(
			'id'			=> 		$this->input->post('id'),
			'pay_code'		=>		$this->input->post('pay_code'),
			'company_id'	=>		$company_id
		));
		$query = $this->db->get("lock_payroll_period");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
   public function AddNewLockPeriod($post)
        {

        		$this->data = array(
        		'company_id'			=> $this->input->post('company_id'),
        		'id' 					=> $this->input->post('id'),
        		'payroll_period_id' 	=> $this->input->post('id'),
        		'pay_code' 				=> $this->input->post('pay_code'),
                'create_transaction' 	=> $this->input->post('create_transaction'),
                'd_t_r' 				=> $this->input->post('d_t_r'),
                'deduct_add_adjustment' => $this->input->post('deduct_add_adjustment'),
                'generate_payslip' 		=> $this->input->post('generate_payslip'),
                'date_added' 			=> date('Y-m-d H:i:s')
                			
		);	
		$this->db->insert('lock_payroll_period',$this->data);
		}	

//GET TABLE PAYROLL PERIOD==========================================================================
	public function get_table_payroll_period($id){
		$this->db->where('id',$id);
		$query = $this->db->get("lock_payroll_period");
		return $query->result();
	}

	public function get_payroll_period_company($id){
		$this->db->select('company_id');
		$this->db->where('id',$id);
		$query = $this->db->get("payroll_period");
		return $query->result();
	}


	//PAYROLL PERIOD EDIT MODEL==========================================================================
	public function validate_edit_payroll_period($pay_code_id){
		
		$id = $this->input->post('id');
		$this->db->select("pay_code");
		$this->db->where(array(
			'pay_code_id' 	=>		$pay_code_id,
			'id'				=>      $id,
			'pay_code'			=>		$this->input->post('pay_code'),
			'company_id'		=>		$company_id 
		
		));
		$query = $this->db->get("lock_payroll_period");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function lock_period_table_edit(){ 
		$pay_code_id		= $this->input->post('pay_code_id');
		$id		= $this->uri->segment('4');
		$this->data = array(
			'company_id'			=>	$this->input->post('company_id'),
			'pay_code'				=>	$this->input->post('pay_code'),
			'id'					=>	$this->input->post('id'),
			'payroll_period_id' 	=> $this->input->post('id'),
			'create_transaction'	=>	$this->input->post('create_transaction'),
			'd_t_r'					=>	$this->input->post('d_t_r'),
			'deduct_add_adjustment'	=>	$this->input->post('deduct_add_adjustment'),
			'generate_payslip'		=>	$this->input->post('generate_payslip'),
			'date_updated' 			=> date('Y-m-d H:i:s')
					);	
		$this->db->where('pay_code_id',$pay_code_id);
		$this->db->update("lock_payroll_period",$this->data);
	}

//== FOR DISABLING=======================================================================
	public function delete($id){
		$this->db->where(array(
			'id'		=>	$id
		));		
		$query = $this->db->get("payroll_period");
		return $query->row();
	}
	public function deactivate($id){
		$this->db->where('id',$id);
		$this->data = array('IsDisabled'=>1);
		$this->db->update("payroll_period",$this->data);	
	}
	public function activate($id){
		$this->db->where('id',$id);
		$this->data = array('IsDisabled'=>0);
		$this->db->update("payroll_period",$this->data);	
	}

	public function paytypeList_addition(){
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
}