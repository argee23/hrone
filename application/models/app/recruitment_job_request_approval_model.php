<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Recruitment_job_request_approval_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function get_department($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('department');
		return $query->result();
	}

	public function get_location($company_id)
	{
		$this->db->join('company_location b','b.location_id=a.location_id');
		$this->db->where('b.company_id',$company_id);
		$query = $this->db->get('location a');
		return $query->result();
	}

	public function request_list_for_approval($company_id)
	{
		$this->db->select('a.*,b.fullname,c.dept_name,d.location_name');
		$this->db->join('employee_info b','b.employee_id=a.section_manager');
		$this->db->join('department c','c.department_id=a.department_id');
		$this->db->join('location d','d.location_id=a.location_id');
		$this->db->where(array('a.company_id'=>$company_id,'a.approver_type'=>'admin','a.status'=>'pending'));
		$query = $this->db->get('recruitment_requests a');
		return $query->result();
	}

	public function request_list_mass_approval($company_id)
	{
		$this->db->select('a.*,b.*,c.*,a.id as idd,a.status as stat');
		$this->db->join('recruitment_requests_approval b','b.doc_no=a.doc_no');
		$this->db->join('employee_info c','c.employee_id=a.section_manager');
		$this->db->where(array('a.company_id'=>$company_id,'a.approver_type'=>'admin','a.status'=>'pending'));
		$query = $this->db->get('recruitment_requests a');
		return $query->result();
	}

	public function filter_approvals($company_id,$department,$location)
	{
		$this->db->select('a.*,b.fullname,c.dept_name,d.location_name');
		$this->db->join('employee_info b','b.employee_id=a.section_manager');
		$this->db->join('department c','c.department_id=a.department_id');
		$this->db->join('location d','d.location_id=a.location_id');
		$this->db->where(array('a.company_id'=>$company_id,'a.approver_type'=>'admin','a.status'=>'pending'));
		if($department!='All'){ $this->db->where('a.department_id',$department); }
		if($location!='All'){ $this->db->where('a.location_id',$location); }
		$query = $this->db->get('recruitment_requests a');
		return $query->result();
	}

	public function get_doc_details($doc_no)
	{
		$this->db->join('recruitment_request_details bb','bb.request_id=a.id');
		$this->db->where('a.doc_no',$doc_no);
		$query = $this->db->get('recruitment_requests a');
		return $query->result();
	}

	public function get_emp_details($employee_id)
	{
		
		$this->db->join('division b','b.division_id=a.division_id','left');
		$this->db->join('department c','c.department_id=a.department');
		$this->db->join('section d','d.section_id=a.section');
		$this->db->join('subsection e','e.subsection_id=a.subsection','left');

		$this->db->join('location f','f.location_id=a.location');
		$this->db->join('classification g','g.classification_id=a.classification');
		$this->db->join('position h','h.position_id=a.position');

		$this->db->where('a.employee_id',$employee_id);
		$query = $this->db->get('employee_info a');
		return $query->result();
	}

	public function get_job_request_details($doc_no)
	{
		$this->db->join('recruitment_request_details b','b.request_id=a.id');
		$this->db->where('a.doc_no',$doc_no);
		$query = $this->db->get('recruitment_requests a');
		return $query->result();
	}

	public function respond_recruitment($doc_no,$comment,$approver_status)
	{

		$this->db->where('doc_no',$doc_no);
		$this->db->update('recruitment_requests_approval',array('status'=>$approver_status,'comment'=>$comment,'date_respond'=>date('Y-m-d H:i:s'),'approval_type'=>'Manual Approval'));	
		
		if($this->db->affected_rows() > 0)
		{
			$this->update_main($doc_no,$approver_status,$comment);
		}
	}

	public function update_main($doc_no,$status,$comment)
	{
		$this->data = array(
			'status'			=>			$status,
			'remarks'			=>			$comment,
			'status_update_date' =>			date('Y-m-d H:i:s')
			);

		$this->db->where('doc_no', $doc_no);
		$this->db->update("recruitment_requests", $this->data);

		if($status=='approved')
		{
			$ins = $this->job_vacancy_request_approval_model->insert_request_in_jobs($doc_no);
		}


		// $send_email 
		$send_email = $this->job_vacancy_request_approval_model->send_email_notification_filer($doc_no);
	}

	public function mass_approval($company_id)
	{
		$request= $this->request_list_mass_approval($company_id);

		foreach($request as $r)
		{
			$doc_no = $r->doc_no;
			$approver_level = $this->input->post($r->doc_no.'_level');
			$comment = $this->input->post($r->doc_no.'comment');
			$approver_status = $this->input->post($r->doc_no.'_final_status');
			if(!empty($approver_status))
			{
				
				$approved = $this->respond_recruitment($doc_no,$comment,$approver_status);
				
			}
		}
	}

}
