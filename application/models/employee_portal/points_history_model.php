<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Points_history_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}

	public function get_setting_details($code)
	{
		$this->db->where('code',$code);
		$query   = $this->db->get('point_rewards_settings',1);
		return $query->row();
	}

	public function get_reward_points_details($code)
	{
		$employee_id = $this->session->userdata('employee_id');

		if($code=='CODE1')
		{
			$this->db->join('jobs c','c.job_id=a.job_id');
			$this->db->join('employee_info_applicant d','d.id=a.applicant_id');
			$this->db->where('a.employee_id',$employee_id);
			$query = $this->db->get('employee_applicant_referral_points_list a');
			return $query->result();
		}
	}
}
