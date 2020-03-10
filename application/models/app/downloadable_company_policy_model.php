<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Downloadable_company_policy_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function downloadable_company_policy()
	{
		$this->db->select('a.*,b.company_name');
		$this->db->join('company_info b','b.company_id=a.company_id');
		$query = $this->db->get('downloadable_company_policy a');
		return $query->result();
	}
	
	public function get_downloadable_company($company)
	{	
		$this->db->select('a.*,b.company_name');
		if($company=='All'){}
		else{ $this->db->where(array('a.company_id'=>$company)); }
		$this->db->join('company_info b','b.company_id=a.company_id');
		$query = $this->db->get('downloadable_company_policy a');
		return $query->result();
	}	

	public function save_downloadable_policy($company,$title,$description,$filename,$numbering)
	{
			$data = array(	'company_id'=>$company,
							'file_name'=>$title,
							'file_description'=>$description,
							'filename'=>$filename,
							'date_created'=>date('Y-m-d'),
							'added_by'=>$this->session->userdata('employee_id'),
							'InActive'=>0,
							'numbering'=>$numbering);
			$this->db->insert('downloadable_company_policy',$data);
			if($this->db->affected_rows() > 0)
			{
				$employee = $this->session->userdata('employee_id');
				$action = 'Add';
				$date = date('Y-m-d H:i:s');
				$details = "(TITLE / ".$title.") - ( DESCRIPTION / ".$description.") - (FILENAME / ".$filename.") - (NUMBERING / ".$numbering.")";
				$save_log = $this->save_logtrai($employee,$action,$date,$details);

				$save_logtrail = $this->add_company_policy_logtrail($company,$action,'Downloadable Company Policy',$date);
			}
	
	}


	
	public function action_downloadable($action,$company,$id)
	{
		$date = date('Y-m-d H:i:s');
		$employee = $this->session->userdata('employee_id');
		$this->db->where('id',$id);
		$e =  $this->db->get('downloadable_company_policy');

		$details = "(ID / ".$id.") - ( TITLE / ".$e->row('file_name').") - (NUMBERING / ".$e->row('numbering').")";

		if($action=='delete')
		{
			$this->db->where('id',$id);
			$this->db->delete('downloadable_company_policy');
			if($this->db->affected_rows() > 0)
			{
				
				$save_log = $this->save_logtrai($employee,$action,$date,$details);
				$save_logtrail = $this->add_company_policy_logtrail($e->row('company_id'),$action,'Downloadable Company Policy',$date);
				return 'Downloadable form id - '.$id.' is successfully deleted!.';
			}
			
		}
		else if($action=='disable')
		{
			$this->db->where('id',$id);
			$this->db->update('downloadable_company_policy',array('InActive'=>1));
			if($this->db->affected_rows() > 0)
			{
				$save_log = $this->save_logtrai($employee,$action,$date,$details);
				$save_logtrail = $this->add_company_policy_logtrail($e->row('company_id'),$action,'Downloadable Company Policy',$date);
				return 'Downloadable form id - '.$id.' is successfully disabled!.';
			}
		}
		else
		{
			$this->db->where('id',$id);
			$this->db->update('downloadable_company_policy',array('InActive'=>0));
			
			if($this->db->affected_rows() > 0)
			{
				$save_log = $this->save_logtrai($employee,$action,$date,$details);
				$save_logtrail = $this->add_company_policy_logtrail($e->row('company_id'),$action,'Downloadable Company Policy',$date);
				return 'Downloadable form id - '.$id.' is successfully enabled!.';
			}
		}
	}	

	public function update_downloadable_policy($company,$id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('downloadable_company_policy');
		return $query->result();
	}
	public function saveupdate_downloadable_policy($company,$title,$description,$picture,$id,$numbering)
	{
		$data = array(	'file_name'=>$title,
						'file_description'=>$description,
						'filename'=>$picture,
						'numbering'=>$numbering);
		$this->db->where('id',$id);
		$this->db->update('downloadable_company_policy',$data);
		if($this->db->affected_rows() > 0)
			{
				$employee = $this->session->userdata('employee_id');
				$action = 'update';
				$date = date('Y-m-d H:i:s');
				$details = "(ID - ".$id.") - (TITLE / ".$title.") - ( DESCRIPTION / ".$description.") - (FILENAME / ".$picture.") - (NUMBERING / ".$numbering.")";
				$save_log = $this->save_logtrai($employee,$action,$date,$details);
				$save_logtrail = $this->add_company_policy_logtrail($company,$action,'Downloadable Company Policy',$date);

				return 'Downloadable form - '.$title.' is successfully updated!.';
			}
	}

	public function save_logtrai($employee,$action,$date,$details)
	{
		$data = array('action'=>$action,
						'employee'=>$employee,
						'details'=>$details,
						'date'=>$date);
		$this->db->insert('logfile_downloadable_company_policy',$data);
	}

	public function add_company_policy_logtrail($company_id,$action,$content,$date)
	{
		$this->db->insert('log_trails_company_policy',array('company_id'=>$company_id,'action'=>$action,'content'=>$content,'date_created'=>$date,'added_by'=>$this->session->userdata('employee_id')));
	}


}