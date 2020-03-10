<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Login_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}

	public function validate_login(){
		$this->db->select('user_id,password');
		$this->db->where(array(
                'user_id'      	=>      $this->input->post('user_id'),
                'password'      =>      $this->input->post('password')
        ));
        $query = $this->db->get('employee_information');
        if($query->num_rows() == 1){
            return true;
        }else{
            return false;
        }
	}


}