<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Company_policy_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}

	
	public function get_company_code_of_discipline()
	{
		$company = $this->session->userdata('company_id');
		$this->db->where(array('company_id'=>$company,'InActive'=>0));
		$this->db->order_by('numbering','ASC');
		$q = $this->db->get('company_code_of_discipline');
		return $q->result();
	}
	public function get_disobedience_details($id)
	{
		$this->db->where('cod_id',$id);
		$q = $this->db->get('cod_disobedience');
		return $q->result();
	}
	public function get_punishments($dis,$pol)
	{
		$this->db->where(array('cod_id'=>$pol,'cod_disob_id'=>$dis));
		$q = $this->db->get('cod_disob_punish');
		return $q->result();
	}
	public function get_downloadable($company)
	{
		$this->db->where(array('company_id'=>$company,'InActive'=>0));
		$q = $this->db->get('downloadable_company_policy');
		return $q->result();
	}

	public function check_company_tracking($type)
	{

		$employee_id = $this->session->userdata('employee_id');
		$company_id = $this->session->userdata('company_id');

		$this->db->select_max('date_created');
		$this->db->where('company_id',$company_id);
		$query_max = $this->db->get('log_trails_company_policy');

		$this->db->where(array('employee_id'=>$employee_id,'company_id'=>$company_id));
		$query = $this->db->get('tracking_employee_company_policy');

		if(empty($query_max->result()))
		{
			if(empty($query->result()))
			{
				$data = array('employee_id'=>$employee_id,
							'company_id'	=> $company_id,
							'date_viewed' => date('Y-m-d H:i:s')
						);

				$insert = $this->db->insert('tracking_employee_company_policy',$data);
			}
		}
		else
		{
			if(empty($query->result()))
			{
				$data = array('employee_id'	=>	$employee_id,
							'company_id'	=>  $company_id,
							'date_viewed' 	=>  date('Y-m-d H:i:s'),
							'date_of_update'=>	$query_max->row('date_created'),
							'viewed_updated'=>	date('Y-m-d H:i:s')
						);

				$insert = $this->db->insert('tracking_employee_company_policy',$data);
			}
			else
			{
				$update = $this->db->update('tracking_employee_company_policy',array('date_of_update'=>$query_max->row('date_created'),'viewed_updated'=>date('Y-m-d H:i:s')));
			}
		}

		

	}

	public function check_company_tracking_acknowlegde()
	{
		$employee_id = $this->session->userdata('employee_id');
		$company_id = $this->session->userdata('company_id');

		$this->db->where(array('company_id'=>$company_id,'employee_id'=>$employee_id));
		$this->db->update('tracking_employee_company_policy',array('date_acknowledge'=>date('Y-m-d H:i:s'),'acknowledge_updated'=>date('Y-m-d H:i:s')));
	}

}
