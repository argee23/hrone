<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Payroll_loan_model extends CI_Model{

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
	
//GET ALL LOAN=============================================================	
	 public function getAllLoan()
        {
 		 return $this->db->get('loan_type')->result_array();
 
        }
    
//DELETE LOAN=============================================================
  	  public function deleteLoan($id)
        {
            $this->db->delete('loan_type', array('loan_type_id' => $id)); 
        }

     

     public function view_loan_type($company_id,$cl_id){
		$this->db->where(array(
			'company_id'   		=>	 $company_id,
			'classification'	=>	$cl_id,
			'InActive'			=>		0
		));	
		$this->db->order_by('loan_type','ASC');
		$query = $this->db->get("loan_type");

		return $query->result();	

	}



//ADDING AND VALIDATING LOAN=================================================
	public function validate_loan(){
		$company_id =$this->input->post('company_id');	
		$this->db->select("loan_type");
		$this->db->where(array(
			'loan_type'		=>		$this->input->post('loan_type'),
			'company_id'		=>		$company_id
		));
		$query = $this->db->get("loan_type");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function validate_loan_code(){
	 	$company_id =$this->input->post('company_id');	
		$this->db->select("loan_type_code");
		$this->db->where(array(
			'loan_type_code'		=>		$this->input->post('loan_type_code'),
			'company_id'		=>		$company_id
		));
		$query = $this->db->get("loan_type");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
   public function AddNewLoan($post)
        {

        		$this->data = array(
        		'company_id' 		=> $this->input->post('company_id'),
                'loan_type' 		=> $this->input->post('loan_type'),
                'loan_category' 	=> $this->input->post('loan_category'),
                'loan_type_code'    => $this->input->post('loan_type_code'),
                'loan_type_desc'  	=> $this->input->post('loan_type_desc'),
                'date_added' 		=> date('Y-m-d H:i:s'),
                'InActive' => 0,
                'allow_to_file'		=> $this->input->post('allow_to_file')
			
		);	
		$this->db->insert('loan_type',$this->data);
		}

//GET LOAN===========================================================================
    public function get_loans($id){
		$this->db->where(array(
			'loan_type_id'		=>		$id,
			'InActive'			=>		0
		));	
		$query = $this->db->get("loan_type");
		return $query->row();
	}

  public function get_loan($loan_type_id){
		$this->db->where(array(
			'loan_type_id'		=>	$loan_type_id
		));		
		$query = $this->db->get("loan");
		return $query->row();
	}
//GET TABLE LOAN==========================================================================
	public function get_table_loan($loan_type_id){
		$this->db->where('loan_type_id',$loan_type_id);
		$query = $this->db->get("loan_type");
		return $query->result();
	}

	public function get_loan_company($loan_type_id){
		$this->db->select('company_id');
		$this->db->where('loan_type_id',$loan_type_id);
		$query = $this->db->get("loan_type");
		return $query->result();
	}


//LOAN EDIT MODEL==========================================================================
	public function validate_edit_loan($id){
		 $company_id =$this->input->post('company_id');	
		 $this->db->select("loan_type");
		 $this->db->where(array(
			'loan_type_id !=' 	=>		$id,
			'loan_type'			=>		$this->input->post('loan_type'),
			'company_id' 		=>		$company_id,
			'InActive'			=>		0
		));
		$query = $this->db->get("loan_type");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function validate_edit_loan_code($id){
		 $company_id =$this->input->post('company_id');		
		 $this->db->select("loan_type_code");
		 $this->db->where(array(
			'loan_type_id !=' 	=>		$id,
			'loan_type_code'	=>		$this->input->post('loan_type_code'),
			'company_id' 		=>		$company_id,
			'InActive'			=>		0
		));
		$query = $this->db->get("loan_type");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function loan_table_edit(){ 
		$loan_type_id				= $this->uri->segment("4");
		$this->data = array(
			'company_id'			=>	$this->input->post('company_id'),
			'loan_type'				=>	$this->input->post('loan_type'),
			'loan_category'			=>	$this->input->post('loan_category'),
			'loan_type_code'		=>	$this->input->post('loan_type_code'),
			'loan_type_desc'		=>	$this->input->post('loan_type_desc'),
			 'date_updated' 		=> date('Y-m-d H:i:s'),
			'allow_to_file'			=>	$this->input->post('allow_to_file')
					);	
		$this->db->where('loan_type_id',$loan_type_id);
		$this->db->update("loan_type",$this->data);
	}

//GETTING LOAN RESULT====================================================================
	public function get_loan_result(){
		$company 	= $this->uri->segment("4");
	
		$this->db->where('company_id',$company);

		$query = $this->db->get("loan_type");
		return $query->result();
	}

	public function get_category_result(){
		$company 	= $this->uri->segment("4");
	
		$this->db->where('company_id',$company);

		$query = $this->db->get("loan_category");
		return $query->result();
	}
public function get_category_edit($company_id){
		
		$this->db->where('company_id',$company_id);

		$query = $this->db->get("loan_category");
		return $query->result();
	}

//== FOR DISABLING=======================================================================
	public function delete($loan_type_id){
		$this->db->where(array(
			'loan_type_id'		=>	$loan_type_id
		));		
		$query = $this->db->get("loan_type");
		return $query->row();
	}
	public function deactivate($loan_type_id){
		$this->db->where('loan_type_id',$loan_type_id);
		$this->data = array('InActive'=>1);
		$this->db->update("loan_type",$this->data);	
	}
	public function activate($loan_type_id){
		$this->db->where('loan_type_id',$loan_type_id);
		$this->data = array('InActive'=>0);
		$this->db->update("loan_type",$this->data);	
	}

	}