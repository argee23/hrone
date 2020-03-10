<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Payroll_file_maintenance_additions_model extends CI_Model{

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


//++++++++++++++++++++++++++++++++++++++++START OTHER ADDITION CATEGORY++++++++++++++++++++++++++++++++++++++++++++

//=======================================OTHER ADDITIONS CATEGORY RESULT===========================================

public function get_category_result(){
		$company 	= $this->uri->segment("4");
		$this->db->where('company_id',$company);
		$query = $this->db->get("other_additions_category");
		return $query->result();
	}

public function get_edit_category_result($company_id){
		
		$this->db->where('company_id',$company_id);

		$query = $this->db->get("other_additions_category");
		return $query->result();
	}


//=========================================ADDING AND VALIDATING CATEGORY==================================
	public function validate_addition_category(){
		 $company_id =$this->input->post('company_id');		

		$this->db->select("category");
		$this->db->where(array(
			'category'		=>		$this->input->post('category'),
			'company_id'	=>		$company_id 
			
		));
		$query = $this->db->get("other_additions_category");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
   public function AddNewAdditionCategory($post)
        {

        		$this->data = array(
        			'company_id'			=> $this->input->post('company_id'),
                	'category' 				=> $this->input->post('category'),
                	'date_added'			=> date('Y-m-d H:i:s')

			
		);	
		$this->db->insert('other_additions_category',$this->data);
		}

//================================= OTHER ADDITIONS EDIT CATEGORY============================================
	public function validate_edit_addition_category($id){
		$company_id =$this->input->post('company_id');	
		$this->db->select("category");
		$this->db->where(array(
			'id !=' 	=>		$id,
			'category'			=>		$this->input->post('category'),
			'company_id'	=>		$company_id 
			
		));
		$query = $this->db->get("other_additions_category");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function category_table_addition_edit(){ 
		$id				= $this->uri->segment("4");
		$this->data = array(
			'company_id'			=>	$this->input->post('company_id'),
			'category'				=>	$this->input->post('category'),
			'date_updated'			=> date('Y-m-d H:i:s')

					);	
		$this->db->where('id',$id);
		$this->db->update("other_additions_category",$this->data);
	}

//=========================================GET TABLE CATEGORY===============================================
	public function get_table_category($id){
		$this->db->where('id',$id);
		$query = $this->db->get("other_additions_category");
		return $query->result();
	}
	public function get_category_company($id){
		$this->db->select('company_id');
		$this->db->where('id',$id);
		$query = $this->db->get("other_additions_category");
		return $query->result();
	}

//== FOR DISABLING CATEGORY=======================================================================
	public function delete($id){
		$this->db->where(array(
			'id'		=>	$id
		));		
		$query = $this->db->get("other_additions_category");
		return $query->row();
	}
	public function deactivate($id){
		$this->db->where('id',$id);
		$this->data = array('IsDisabled'=>1);
		$this->db->update("other_additions_category",$this->data);	
	}
	public function activate($id){
		$this->db->where('id',$id);
		$this->data = array('IsDisabled'=>0);
		$this->db->update("other_additions_category",$this->data);	
	}
//== FOR DISABLING LIST=======================================================================
	public function delete_lists($id){
		$this->db->where(array(
			'id'		=>	$id
		));		
		$query = $this->db->get("other_addition_type");
		return $query->row();
	}
	public function deactivate_list($id){
		$this->db->where('id',$id);
		$this->data = array('InActive_type'=>1);
		$this->db->update("other_addition_type",$this->data);	
	}
	public function activate_list($id){
		$this->db->where('id',$id);
		$this->data = array('InActive_type'=>0);
		$this->db->update("other_addition_type",$this->data);	
	}
//+++++++++++++++++++++++++++++++++++END OF OTHER ADDITION CATEGORY+++++++++++++++++++++++++++++++++++++++++++	


//++++++++++++++++++++++++++++++++++++START OF OTHER ADDITION LIST++++++++++++++++++++++++++++++++++++++++++++
//=====================================OTHER ADDITIONS LIST RESULT============================================

public function get_list_result(){
		$company = $this->uri->segment('4');	
		// $this->db->where('company_id',$company);
		// $query = $this->db->get("other_addition_type");
		$query=$this->db->query("SELECT * FROM other_addition_type where company_id='".$company."' OR system_default='1' ");
		return $query->result();
	}

//=======================================OTHER ADDITIONS CATEGORY RESULT===========================================

public function get_addition_list_result(){
		$company 	= $this->uri->segment('4');
	
		$this->db->where('company_id',$company);

		$query = $this->db->get("other_addition_type");
		return $query->result();
	}
//======================================ADD/VALIDATE OTHER ADDITION LIST===========================================
public function validate_list(){
		 $company_id =$this->input->post('company_id');		

		$this->db->select("other_addition_code");
		$this->db->where(array(
			'other_addition_code'		=>		$this->input->post('other_addition_code'),
			'company_id'	=>		$company_id 
			
		));
		$query = $this->db->get("other_addition_type");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
public function validate_list_type(){
		 $company_id =$this->input->post('company_id');		

		$this->db->select("other_addition_type");
		$this->db->where(array(
			'other_addition_type'		=>		$this->input->post('other_addition_type'),
			'company_id'	=>		$company_id 
			
		));
		$query = $this->db->get("other_addition_type");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
   public function AddNewList($post)
        {

        		$this->data = array(
        			'company_id' 			=> $this->input->post('company_id'),
                	'other_addition_code' 	=> $this->input->post('other_addition_code'),
                	'other_addition_type' 	=> $this->input->post('other_addition_type'),
                	'rate' 					=> $this->input->post('rate'),
                	'amount' 				=> $this->input->post('amount'),
                	'taxable' 				=> $this->input->post('taxable'),
                	'non_tax' 				=> $this->input->post('non_tax'),
                	'bonus'					=> $this->input->post('bonus'),
                	'th_month_pay' 			=> $this->input->post('th_month_pay'),
                	'basic' 				=> $this->input->post('basic'),
                	'ot' 					=> $this->input->post('ot'),
                	'other_addition_leave' 	=> $this->input->post('other_addition_leave'),
                	'exclude' 				=> $this->input->post('exclude'),
                	'category' 				=> $this->input->post('category'),
                	'InActive_type'			=> 0,
                	'date_added_type'		=> date('Y-m-d H:i:s')
                	

			
		);	
		$this->db->insert('other_addition_type',$this->data);
		}	

//=========================================GET TABLE LIST===============================================
	public function get_table_list($id){
		$this->db->where('id',$id);
		$query = $this->db->get("other_addition_type");
		return $query->result();
	}
	public function get_list_company($id){
		$this->db->select('company_id');
		$this->db->where('id',$id);
		$query = $this->db->get("other_addition_type");
		return $query->result();
	}

//================================= OTHER ADDITIONS EDIT LIST============================================
	public function validate_edit_list($id){
		$company_id =$this->input->post('company_id');	
		$this->db->select("other_addition_code");
		$this->db->where(array(
			'id !=' 						=>		$id,
			'other_addition_code'			=>		$this->input->post('other_addition_code'),
			'company_id'					=>		$company_id 
			
		));
		$query = $this->db->get("other_addition_type");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function validate_edit_list_type($id){
		$company_id =$this->input->post('company_id');	
		$this->db->select("other_addition_type");
		$this->db->where(array(
			'id !=' 						=>		$id,
			'other_addition_type'			=>		$this->input->post('other_addition_type'),
			'company_id'					=>		$company_id 
			
		));
		$query = $this->db->get("other_addition_type");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function list_table_edit(){ 
		$id	 = $this->uri->segment("4");
		$this->data = array(
					'company_id' 			=> $this->input->post('company_id'),
                	'other_addition_code' 	=> $this->input->post('other_addition_code'),
                	'other_addition_type' 	=> $this->input->post('other_addition_type'),
                	'rate' 					=> $this->input->post('rate'),
                	'amount' 				=> $this->input->post('amount'),
                	'taxable' 				=> $this->input->post('taxable'),
                	'non_tax' 				=> $this->input->post('non_tax'),
                	'bonus'					=> $this->input->post('bonus'),
                	'th_month_pay' 			=> $this->input->post('th_month_pay'),
                	'basic' 				=> $this->input->post('basic'),
                	'ot' 					=> $this->input->post('ot'),
                	'other_addition_leave' 	=> $this->input->post('other_addition_leave'),
                	'exclude' 				=> $this->input->post('exclude'),
                	'category' 				=> $this->input->post('category'),
                	'InActive_type'			=> 0,
                	'date_updated_type'		=> date('Y-m-d H:i:s')

			
					);	
		$this->db->where('id',$id);
		$this->db->update("other_addition_type",$this->data);
	}

//+++++++++++++++++++++++++++++++++++++++++++END OF OTHER ADDITION LIST++++++++++++++++++++++++++++++++++++++++++++++
	public function get_oa_category($category){
		$this->db->where('id',$category);
		$query = $this->db->get("other_additions_category");
		return $query->row();
	}
}