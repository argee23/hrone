<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Payroll_loan_category_model extends CI_Model{

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
	
//GET ALL LOAN CATEGORY================================================================	
		public function get_category_result(){
		$company 	= $this->uri->segment("4");
	
		$this->db->where('company_id',$company);

		$query = $this->db->get("loan_category");
		return $query->result();
	}

//== FOR DISABLING=======================================================================
	public function delete($id){
		$this->db->where(array(
			'id'		=>	$id
		));		
		$query = $this->db->get("loan_category");
		return $query->row();
	}
	public function deactivate($id){
		$this->db->where('id',$id);
		$this->data = array('InActive'=>1);
		$this->db->update("loan_category",$this->data);	
	}
	public function activate($id){
		$this->db->where('id',$id);
		$this->data = array('InActive'=>0);
		$this->db->update("loan_category",$this->data);	
	}

//ADDING AND VALIDATING LOAN CATEGORY===================================================
	public function validate_category(){
		 $company_id =$this->input->post('company_id');		

		$this->db->select("category");
		$this->db->where(array(
			'category'		=>		$this->input->post('category'),
			'company_id'	=>		$company_id 
			
		));
		$query = $this->db->get("loan_category");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
   public function AddNewCategory($post)
        {

        		$this->data = array(
        		'company_id' 	=> $this->input->post('company_id'),
                'category' 		=> $this->input->post('category'),
                'date_added' 	=> date('Y-m-d H:i:s'),
                'InActive'  	=> 0
			
		);	
		$this->db->insert('loan_category',$this->data);
		}


//GET TABLE LOAN CATEGORY==========================================================================
	public function get_table_category($id){
		$this->db->where('id',$id);
		$query = $this->db->get("loan_category");
		return $query->result();
	}

	public function get_category_company($id){
		$this->db->select('company_id');
		$this->db->where('id',$id);
		$query = $this->db->get("loan_category");
		return $query->result();
	}


//LOAN CATEGORY EDIT MODEL==========================================================================
	public function validate_edit_category($id){
		 $company_id =$this->input->post('company_id');		
		$this->db->select("category");
		$this->db->where(array(
			'id !=' 	=>		$id,
			'category'			=>		$this->input->post('category'),
			'company_id'	=>		$company_id, 
			'InActive'			=>		0
		));
		$query = $this->db->get("loan_category");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function category_table_edit(){ 
		$id				= $this->uri->segment("4");
		$this->data = array(
			'company_id'			=>	$this->input->post('company_id'),
			'category'				=>	$this->input->post('category'),
			 'date_updated' 				=> date('Y-m-d H:i:s'),
			 'InActive'  			=> 0
					);	
		$this->db->where('id',$id);
		$this->db->update("loan_category",$this->data);
	}


	}