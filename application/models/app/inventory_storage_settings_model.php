<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Inventory_storage_settings_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function get_settings($company)
	{
		$this->db->select('a.*,b.company_name');
		$this->db->join('company_info b','b.company_id=a.company_id');
		if($company=='all'){}
		else{ $this->db->where('a.company_id',$company); }
		$q = $this->db->get('inventory_storage_settings a');
		return $q->result();
	}
	public function get_company_details($company)
	{
		$this->db->where('company_id',$company);
		$q =  $this->db->get('company_info');
		return $q->row('company_name');
	}
	public function save_settings($company)
	{
		$settings = $this->input->post('settings');
		$description = $this->input->post('description');
		$datefrom = $this->input->post('datefrom');
		$dateto = $this->input->post('datefrom');
		$employee_id =$this->session->userdata('employee_id');
		$details = $this->input->post('hard_drive');

		$data = array('company_id'=>$company,
							'setting'=>$settings,
							'description'=>$description,
							'date_from'=>$datefrom,
							'date_to'=>$dateto,
							'if_hard_drives'=>$details,
							'added_by'=>$employee_id,
							'InActive'=>0,
							'date_created'=>date('Y-m-d'));
		
		$insert = $this->db->insert('inventory_storage_settings',$data);
		if($this->db->affected_rows() > 0)
			{
				$date = date('Y-m-d H:i:s');
				$employee = $this->session->userdata('employee_id');
				$details = " ( SETTINGS / ".$setting." - ( DATE EFFECTIVE /".$datefrom." to ".$dateto." )";

				$save_log = $this->save_logtral($employee,'add',$date,$details);
				return 'Setting id - '.$id.' is successfully deleted!.';
			}
	}	
	public function action_settings($action,$company,$id)
	{
		$date = date('Y-m-d H:i:s');
		$employee = $this->session->userdata('employee_id');

		$this->db->where('id',$id);
		$e =  $this->db->get('inventory_storage_settings');
		$details = "(ID / ".$id.") - ( SETTINGS / ".$e->row('setting').") - ( DATE EFFECTIVE /".$e->row('date_from')." to ".$e->row('date_to')." )";

		if($action=='delete')
		{
			$this->db->where('id',$id);
			$this->db->delete('inventory_storage_settings');
			if($this->db->affected_rows() > 0)
			{
				
				$save_log = $this->save_logtral($employee,$action,$date,$details);
				return 'Setting id - '.$id.' is successfully deleted!.';
			}
			
		}
		else if($action=='disable')
		{
			$this->db->where('id',$id);
			$this->db->update('inventory_storage_settings',array('InActive'=>1));
			if($this->db->affected_rows() > 0)
			{
				$save_log = $this->save_logtral($employee,$action,$date,$details);
				return 'Setting id - '.$id.' is successfully disabled!.';
			}
		}
		else
		{
			$this->db->where('id',$id);
			$this->db->update('inventory_storage_settings',array('InActive'=>0));
			
			if($this->db->affected_rows() > 0)
			{
				$save_log = $this->save_logtral($employee,$action,$date,$details);
				return 'Setting id - '.$id.' is successfully enabled!.';
			}
		}
	}
	public function save_logtral($employee,$action,$date,$details)
	{
		$data = array('action'=>$action,
						'employee'=>$employee,
						'details'=>$details,
						'date'=>$date);
		$this->db->insert('logfile_inventory_storage_settings',$data);
	}
	public function get_details_settings($id)
	{
		$this->db->where('id',$id);
		$q= $this->db->get('inventory_storage_settings');
		return $q->result();
	}

	public function saveupdate_settings($company,$id)
	{
		$settings = $this->input->post('settings');
		$details = $this->input->post('hard_drive');
		if($settings=='hard_drive')
		{	
			$dd=$details;
		} else{ $dd=''; }
		$description = $this->input->post('description');
		$datefrom = $this->input->post('datefrom');
		$dateto = $this->input->post('dateto');
		$employee_id =$this->session->userdata('employee_id');
		

		$data = array(
							'setting'=>$settings,
							'description'=>$description,
							'date_from'=>$datefrom,
							'date_to'=>$dateto,
							'if_hard_drives'=>$dd);
		$this->db->where('id',$id);
		$insert = $this->db->update('inventory_storage_settings',$data);
		if($this->db->affected_rows() > 0)
			{
				$date = date('Y-m-d H:i:s');
				$employee = $this->session->userdata('employee_id');
				$details = " ( SETTINGS / ".$settings." - ( DATE EFFECTIVE /".$datefrom." to ".$dateto." )";

				$save_log = $this->save_logtral($employee,'update',$date,$details);
				return 'Setting id - '.$id.' is successfully updated!.';
			}
	}	

	public function check_if_id_exist($id)
	{
		$this->db->where('setting_id',$id);
		$query = $this->db->get('emp_inventory');
		$q1 = $query->result();
		
		$this->db->where('setting_id',$id);
		$query2 = $this->db->get('emp_inventory_for_update');
		$q2 = $query2->result();
		
		$result = array_merge($q1,$q2);
		return $result;
	}
}