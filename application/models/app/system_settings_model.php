<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class System_settings_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}

	public function get_topics(){
		$this->db->where('InActive',0);
		$query = $this->db->get("system_settings");
		return $query->result();		
	}
	public function get_spec_topics($id){
		$this->db->where('id',$id);
		$query = $this->db->get("system_settings");
		return $query->row();		
	}
	
	public function update_single_value($id,$single_value){

		$this->data = array(
			'last_update_logged'				=>		date("Y-m-d h:i:s a"),
			'single_value'						=>		$single_value
		);	

		$this->db->where('id',$id);	
		$this->db->update('system_settings', $this->data);
	}
	
	public function main_page_user_interface(){
		$this->db->where('cCode','main_page_user_interface');
		$query = $this->db->get("system_parameters");
		return $query->result();			
	}
}//end controller

