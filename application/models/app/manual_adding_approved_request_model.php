<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Manual_adding_approved_request_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	//SETTINGS

	public function request_list_for_approval($company_id)
	{
		$this->db->select('a.*,b.*,a.status as stat,a.id as idd');
		$this->db->join('recruitment_request_details b','b.request_id=a.id');
		$this->db->where(array('a.company_id'=>$company_id,'a.status'=>'approved','a.approved_admin_jobid'=>'pending'));
		$query = $this->db->get('recruitment_requests a');
		return $query->result();
	}

	public function get_plantilla($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('plantilla');
		return $query->result();
	}

	public function position()
	{
		$this->db->where('isEmployer',0);
		$query = $this->db->get('position');
		return $query->result();
	}

	public function insert_admin_manual_adding($doc_no)
	{
		$this->db->select('a.*,a.id as id,b.*');
		$this->db->join('recruitment_request_details b','b.request_id=a.id');
		$this->db->where('a.doc_no',$doc_no);
		$query = $this->db->get('recruitment_requests a');
		$result = $query->result();
		foreach($result as $r)
		{
			if($r->type=='new')
			{

				$plantilla = $r->plantilla_id;
				$department = $r->department_id;
				$location = $r->location_id;
				$company_id = $r->company_id;
				$request_id = $r->id;

				$newdata = array('plantilla_id'=>$plantilla,
								'department_id'=>$department,
								'location'=>$location,
								'company_id'=>$company_id,
								'job_specialization'	=>		$this->input->post('industry'),
								'job_title'				=>		$r->job_title,
								'position_id'			=>		$this->input->post('position'),
								'job_description'		=>		$this->input->post('job_description'),
								'job_qualification'		=>		$this->input->post('job_qualification'),
								'salary'				=>		$this->input->post('salary'),
								'status'				=>		1,
								'hiring_start'			=> 		$this->input->post('hiring_start'),
								'hiring_end'			=> 		$this->input->post('hiring_end'),			
								'job_vacancy'			=>		$this->input->post('job_vacancy'),
								'loc_province'			=>		$this->input->post('province'),
								'loc_city'				=>		$this->input->post('city'),
								'with_target_applicant'	=>		$this->input->post('target_applicant'),
								'with_target_date'		=>		$this->input->post('target_date'),
								'request_id'=>$request_id);

				$this->db->insert('jobs',$newdata);

				if($this->db->affected_rows() > 0)
					{
						$this->db->where('doc_no',$doc_no);
						$this->db->update('recruitment_requests',array('approved_admin_jobid'=>'approved'));
					}

			}	
			else
			{


				$job_id =  $r->job_id;
				$vacancy = $this->input->post('additionaljob_vacancy');

				$this->db->where('job_id',$job_id);
				$qq = $this->db->get('jobs',1);
				$qq_result = $qq->result();

					foreach($qq_result as $q)
					{
						$total  = $vacancy + $q->job_vacancy;
						$this->db->where('job_id',$job_id);
						$this->db->update('jobs',array('job_vacancy'=>$total));

						if($this->db->affected_rows() > 0)
							{
								$upds =  $this->job_vacancy_request_approval_model->insert_plantilla_job_updates($r->plantilla_id,$job_id,'ADDITIONAL JOB VACANCY REQUEST',$vacancy,$total,date('Y-m-d H:i:s'),$r->id,date('Y-m-d H:i:s'));

								$this->db->where('doc_no',$doc_no);
								$this->db->update('recruitment_requests',array('approved_admin_jobid'=>'approved'));
							}
					}

			}
		}	
	}


	public function filter_result($company_id,$plantilla,$department,$location,$type,$status,$approvertype)
	{
		
		$this->db->select('a.*,b.*,a.status as stat,a.id as idd');
		$this->db->join('recruitment_request_details b','b.request_id=a.id');
		$this->db->where(array('a.company_id'=>$company_id,'a.status'=>'approved'));
		if($status!='All'){ $this->db->where('a.approved_admin_jobid',$status); }
		if($approvertype!='All') { $this->db->where('a.approver_type',$approvertype); }
		if($type!='All') { $this->db->where('a.type',$type); }

		if($plantilla!='All') { $this->db->where('a.plantilla_id',$plantilla); }
		if($department!='All') { $this->db->where('a.department_id',$department); }
		if($location!='All') { $this->db->where('a.location_id',$location); }

		$query = $this->db->get('recruitment_requests a');
		return $query->result();
	}
}		