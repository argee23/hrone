<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


	
class checking_tools_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}



	public function show_db_tables(){
			$query=$this->db->query("SHOW TABLES WHERE Tables_in_serttech='201_check_for_updates' OR Tables_in_serttech='account'");
			return $query->result();

	}

	public function select_showed_tables(){
			$query=$this->db->query("SHOW TABLES WHERE Tables_in_serttech='201_check_for_updates' OR Tables_in_serttech='account'");
			return $query->row();
	}
	public function test($table){
			$query=$this->db->query("SELECT * FROM $table");
			return $query->num_fields();
	}



}