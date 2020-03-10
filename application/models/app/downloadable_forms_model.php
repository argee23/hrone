<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Downloadable_forms_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function get_downloadable_forms()
	{
		$this->db->join('company_info b','b.company_id=a.company_id');
		$query = $this->db->get('downloadable_forms a');
		return $query->result();
	}

	public function get_downloadable_company($company)
	{
		$this->db->select('a.*,b.company_name');
		$this->db->join('company_info b','b.company_id=a.company_id');
		if($company=='All'){}
		else{ $this->db->where('a.company_id',$company); }
		$query = $this->db->get('downloadable_forms a');
		return $query->result();
	}
	public function get_company_name($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('company_info',1);
		return $query->row('company_name');
	}
	public function save_downloadable_forms($company,$title,$description,$filename)
	{
		$data = array(	'company_id'=>$company,
						'file_name'=>$title,
						'file_description'=>$description,
						'filename'=>$filename,
						'date_created'=>date('Y-m-d'),
						'added_by'=>$this->session->userdata('employee_id'),
						'InActive'=>0);
		$this->db->insert('downloadable_forms',$data);
		if($this->db->affected_rows() > 0)
		{
			$employee = $this->session->userdata('employee_id');
			$action = 'Add';
			$date = date('Y-m-d H:i:s');
			$details = "(TITLE / ".$title.") - ( DESCRIPTION / ".$description.") - (FILENAME / ".$filename.")";
			$save_log = $this->save_logtrai($employee,$action,$date,$details);
		}
	}
	public function action_downloadable($action,$company,$id)
	{
		$date = date('Y-m-d H:i:s');
		$employee = $this->session->userdata('employee_id');
		$this->db->where('id',$id);
		$e =  $this->db->get('downloadable_forms');
		$details = "(ID / ".$id.") - ( TITLE / ".$e->row('file_name').")";

		if($action=='delete')
		{
			$this->db->where('id',$id);
			$this->db->delete('downloadable_forms');
			if($this->db->affected_rows() > 0)
			{
				
				$save_log = $this->save_logtrai($employee,$action,$date,$details);
				return 'Downloadable form id - '.$id.' is successfully deleted!.';
			}
			
		}
		else if($action=='disable')
		{
			$this->db->where('id',$id);
			$this->db->update('downloadable_forms',array('InActive'=>1));
			if($this->db->affected_rows() > 0)
			{
				$save_log = $this->save_logtrai($employee,$action,$date,$details);
				return 'Downloadable form id - '.$id.' is successfully disabled!.';
			}
		}
		else
		{
			$this->db->where('id',$id);
			$this->db->update('downloadable_forms',array('InActive'=>0));
			
			if($this->db->affected_rows() > 0)
			{
				$save_log = $this->save_logtrai($employee,$action,$date,$details);
				return 'Downloadable form id - '.$id.' is successfully enabled!.';
			}
		}
	}
	public function update_downloadable_forms($company,$id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('downloadable_forms');
		return $query->result();
	}
	public function saveupdate_downloadable_forms($company,$title,$description,$picture,$id)
	{
		$data = array(	'file_name'=>$title,
						'file_description'=>$description,
						'filename'=>$picture);
		$this->db->where('id',$id);
		$this->db->update('downloadable_forms',$data);
		if($this->db->affected_rows() > 0)
			{
				$employee = $this->session->userdata('employee_id');
				$action = 'update';
				$date = date('Y-m-d H:i:s');
				$details = "(ID - ".$id.") - (TITLE / ".$title.") - ( DESCRIPTION / ".$description.") - (FILENAME / ".$picture.")";
				$save_log = $this->save_logtrai($employee,$action,$date,$details);
				return 'Downloadable form - '.$title.' is successfully updated!.';
			}

		
	}
	public function save_logtrai($employee,$action,$date,$details)
	{
		$data = array('action'=>$action,
						'employee'=>$employee,
						'details'=>$details,
						'date'=>$date);
		$this->db->insert('logfile_downloadable_forms',$data);
	}

	public function get_downloadable_company_employee($company)
	{
		$this->db->where(array('a.company_id'=>$company,'a.InActive'=>0));
		$this->db->join('company_info b','b.company_id=a.company_id');
		$query = $this->db->get('downloadable_forms a');
		return $query->result();
	}

}