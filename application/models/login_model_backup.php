<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Login_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}


	public function validate_nbd(){
		$this->db->select("nbd");
		 $this->db->where(array(
                'nbd'      =>      md5($this->input->post('nbd'))
        ));
        $query = $this->db->get('nbd');
        if($query->num_rows() == 1)
        {

			$this->db->select("username,password");
		 	$this->db->where(array(
               	'username'      =>      $this->input->post('username'),
                'password'      =>      md5($this->input->post('password')),
				'InActive'		=>		0
        		));

        	$query = $this->db->get('users');

        	if($query->num_rows() == 1)
        	{
            	return true;
        	}
        	else
        	{
		        if ($this->check_applicant($this->input->post('username'), $this->input->post('password'))) //Check if applicant
		        {
		        	return true;
		        }
		        else if ($this->check_employee($this->input->post('username'), $this->input->post('password'))) //check if employee
		        {
		        	return true;
		        }
		        else {
		        	return false;
		        }
        	}

            return true;
        }
        else{ //If NBD is invalid

	        if ($this->check_applicant($this->input->post('username'), $this->input->post('password')))
	        {
	        	return true;
	        }
	        else {
	        	return false;
	        }
        }

	}
	
	public function check_applicant($username, $password)
	{
		$this->db->select("aa.applicant_id, aa.applicant_password");
		$this->db->where(array(
                'aa.applicant_id'      		=>     $username,
                'aa.applicant_password'  	=>     md5($password),
				'ei.isApplicant'	  	 	=>	   1,
				'ei.isEmployee'		   		=>	   0
        ));
        $this->db->join("employee_info_applicant ei", "aa.employee_info_id = ei.id", "inner");
        $query = $this->db->get("applicant_account aa");

         if ($query->num_rows() == 1) {
         	return true;
         }
         else {
         	return false;
         }
	}

	public function check_employee($username, $password)
	{
		$this->db->select("username, password");
		$this->db->where( array(

			'username'			=> 	$username,
			'password'			=>  $password,
			'isEmployee'		=> 	1,
			'InActive'			=>	0
			));

		$query = $this->db->get("employee_info");

		if ($query->num_rows() == 1) {
         	return true;
         }
         else {
         	return false;
         }
	}
	
	public function getMyModule($user_id){
		$this->db->select("B.module");
		$this->db->where("employee_id",$user_id);
		$this->db->join("user_roles B","B.role_id = A.user_role","left outer");
		$query = $this->db->get("users A");
		return $query->row();	
	}
	
	public function loadJobVacancies()
	{
		$this->db->select("job_title, job_description, salary, date_posted, company_name, id, company_id, logo");
		$this->db->order_by("hiring_start", "desc");
		$query = $this->db->get("job_vacancy_view");

		return $query->result();
	}

	function getRows($params = array()){
		$this->db->select("job_title, job_description, salary, date_posted, company_name, id, company_id, logo");
		$this->db->order_by("hiring_start", "desc");
        $this->db->from('job_vacancy_view');

        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }


	public function employee_log_history($employee_id,$event){
		$this->data = array(
			'employee_id'				=>		$employee_id,
			'date'						=>		date("Y-m-d h:i:s a"),
			'event'						=>		$event,
			'time'						=>		date("H:i:s"),
			'ip_address'				=>		$this->input->ip_address(),
			'computer_name'				=>		gethostname()
		);	
		$this->db->insert("emp_log_history",$this->data);
	}
}