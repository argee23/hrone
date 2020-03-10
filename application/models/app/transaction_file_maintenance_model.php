<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Transaction_file_maintenance_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	//== for listing
	public function getAll( ){ 

		$this->db->where(array(
			'form_type'			=>		'T',
			'IsUserDefine'			=>		'0'
		));	
		$this->db->order_by('form_name','asc');
		$query = $this->db->get("transaction_file_maintenance");
		return $query->result();
	}

	public function get_transaction($id){

		$this->db->where(array(
			'identification'			=>		$id
		));	
		$query = $this->db->get('transaction_file_maintenance');
		return $query->result();
	}

	public function activate_transaction($id){ 
		$this->db->where('identification',$id);
		$this->data = array('IsActive'=>1);
		$this->db->update("transaction_file_maintenance",$this->data);	
	}

	public function deactivate_transaction($id){ 
		$this->db->where('identification',$id);
		$this->data = array('IsActive'=>0);
		$this->db->update("transaction_file_maintenance",$this->data);	
	}
	public function count_transaction($t_table_name){ 
	
		$query = $this->db->get($t_table_name);
		return $query->result();		
	}

}