<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Leave_type_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	//== for listing
	public function getAll(){

		$this->db->select("A.*,B.company_name",false);

		//$this->db->order_by('A.id','asc');
		$this->db->join("company_info B","A.company_id = B.company_id","left outer");
		$query = $this->db->get("leave_type A");

		return $query->result();
	}


	public function get_default_leave_type(){ 
		$this->db->select("A.*,B.company_name",false);

		$this->db->order_by('A.IsDisabled','asc');
		$this->db->join("company_info B","A.company_id = B.company_id","left outer");
		$this->db->where('A.is_system_default','1');
		$query = $this->db->get('leave_type A');
		return $query->result();		
	}	


	public function get_company_leave_type($company_id){ 
		$this->db->select("A.*,B.company_name",false);

		$this->db->order_by('A.IsDisabled','asc');
		$this->db->join("company_info B","A.company_id = B.company_id","left outer");
		$this->db->where('A.company_id',$company_id);
		$query = $this->db->get('leave_type A');
		return $query->result();		
	}	

	//== for disabling
	public function delete($id){
		$this->db->where(array(
			'id'		=>	$id
		));		
		$query = $this->db->get("leave_type");
		return $query->row();
	}
	public function deactivate($id){
		$this->db->where('id',$id);
		$this->data = array('IsDisabled'=>1);
		$this->db->update("leave_type",$this->data);	
	}
	public function activate($id){
		$this->db->where('id',$id);
		$this->data = array('IsDisabled'=>0);
		$this->db->update("leave_type",$this->data);	
	}
	//== for editing
	public function getLeaveType($id){ 
		$this->db->select("A.*,B.company_name",false);


		$this->db->join("company_info B","A.company_id = B.company_id","left outer");
		$this->db->where('A.id',$id);
		$query = $this->db->get('leave_type A');
		return $query->row();		
	}	
	public function validate_edit_leave_type($id,$company_id){
		$this->db->select("leave_type,leave_code,id");
		$this->db->where(array(
			//'id !='				=>		$this->input->post('leave_id'),
			'company_id'		=>		$company_id,
			'leave_type'		=>		$this->input->post('leave_type'),
			'IsDisabled'		=>		0
		));	
		$query = $this->db->get("leave_type");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}
	public function validate_edit_leave_code(){
		$this->db->select("leave_type,leave_code,id");
		$this->db->where(array(
			'id !='	=>		$this->input->post('leave_id'),			
			//'company_id'	=>		$this->input->post('company_id'),
			'leave_code'		=>		$this->input->post('company_id').'_'.$this->input->post('leave_code'),
			'IsDisabled'		=>		0
		));	
		$query = $this->db->get("leave_type");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}
	public function validate_edit_color_code(){
		$this->db->select("leave_type,color_code,leave_code,id");
		$this->db->where(array(
			'id !='	=>		$this->input->post('leave_id'),
			'color_code'		=>		$this->input->post('color_code'),
			'IsDisabled'		=>		0
		));	
		$query = $this->db->get("leave_type");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}
	//== for saving update
	public function modify_leave_type($id){
		$male=$this->input->post('gender_male');
		$female=$this->input->post('gender_female');
$taxable_leave_beyond = $this->input->post('taxable_leave_beyond');
$leave_type_classifiy = $this->input->post('leave_type_classifiy');
	if($leave_type_classifiy=="is_vl"){
		$is_vl=1;
		$is_sl=0;
	}elseif($leave_type_classifiy=="is_sl"){
		$is_vl=0;
		$is_sl=1;
	}else{
		$is_vl=0;
		$is_sl=0;	
	}
		if(($male)AND ($female)){
			$gender='';
		}else if ($male){
			$gender='1';
		}else if ($female){
			$gender='2';
		}else{
			$gender='';	
		}

		$this->data = array(
			'leave_type'		=> ucwords($this->input->post('leave_type')),
			'leave_code'		=> $this->input->post('leave_code'),//$this->input->post('company_id').(rand(10000,1000000)).'_'.
			'color_code'		=> $this->input->post('color_code'),
			'cutoff'			=> 'yearly',
			'gender'			=> $gender,
			'taxable_leave_beyond'			=> $taxable_leave_beyond,
			'is_vl'			=> $is_vl,
			'is_sl'			=> $is_sl,
			'IsDisabled'		=> 0
		);	
		$this->db->where('id',$id);
		$this->db->update('leave_type',$this->data);
	}


	public function validate_add_leave_type($val){
		$this->db->select("leave_type,id");
		$this->db->where(array(
			'company_id'		=>		$val,
			'leave_type'		=>		$this->input->post('leave_type'),
			'IsDisabled'		=>		0
		));	
		$query = $this->db->get("leave_type");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}

	public function validate_add_leave_code($val){
		$this->db->select("leave_code,id");
		$this->db->where(array(
			//'company_id'		=>		$val,			
			'leave_code'		=>		$val.'_'.$this->input->post('leave_code'),
			'IsDisabled'		=>		0
		));	
		$query = $this->db->get("leave_type");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}
	public function validate_add_leave_color_code(){
		$this->db->select("color_code,id");
		$this->db->where(array(
			'color_code'		=>		$this->input->post('leave_color_code'),
			'IsDisabled'		=>		0
		));	
		$query = $this->db->get("leave_type");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}

	public function validate_delete_leave_type($id){
		//$this->db->select("leave_type,color_code,leave_code,id");
		$this->db->where(array(
			'leave_type_id'		=>		$id
		));	
		$query = $this->db->get("leave_allocation");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}

}