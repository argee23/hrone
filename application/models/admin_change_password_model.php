<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Admin_change_password_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
		
	}	
	
	public function get_admin_details()
	{
		$employee_id = $this->session->userdata('employee_id');
		$username = $this->session->userdata('username');

		$this->db->where(array('employee_id'=>$employee_id,'username'=>$username));
		$query = $this->db->get('users',1);
		return $query->row();

	}

	public function save_new_password()
	{
		$password = md5($this->input->post('new_password'));
		$old_password = $this->session->userdata('password');
		$username = $this->session->userdata('username');
		$employee_id = $this->session->userdata('employee_id');

		$this->db->where(array('employee_id'=>$employee_id,'username'=>$username));
		$this->db->update('users',array('password'=>$password));

		$data =array('employee_id'=>$employee_id,'username'=>$username,'old_password'=>$old_password,'new_password'=>$this->input->post('new_password'),'date_updated'=>date('Y-m-d H:i:s'));
		$this->db->insert('logfile_admin_change_password',$data);

		$this->session->unset_userdata('password'); 
        $this->data = $this->session->set_userdata(array(
             'password'      =>     $this->input->post('new_password')));
        

	}
}