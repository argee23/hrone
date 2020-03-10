<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Training_request_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}


	public function training_request_list()
	{
		$employee_id = $this->session->userdata('employee_id');
		$date =  date('Y-m-d');
		$this->db->join('emp_trainings_seminar_incoming_employees b','b.training_id=a.training_seminar_id');
		$this->db->where(array('b.employee_id'=>$employee_id,'a.ifAdded'=>0,'b.date_respond'=>Null));
		$query = $this->db->get('emp_trainings_seminars_incoming a');
		return $query->result();
	}

	public function get_incoming_dates($id)
	{
		$this->db->where('seminar_training_id',$id);
		$query = $this->db->get('emp_trainings_seminars_dates_incoming');
		return $query->result();
	}

	public function get_training_request($id)
	{
		$this->db->where('training_seminar_id',$id);
		$query = $this->db->get('emp_trainings_seminars_incoming',1);
		return $query->row();
	}
	public function respond_employee_training_request()
	{
		$employee_id = $this->session->userdata('employee_id');
		$training_seminar_id = $this->input->post('training_seminar_id');
		$respond = $this->input->post('finalans');

		$this->db->where(array('training_id'=>$training_seminar_id,'employee_id'=>$employee_id));
		$this->db->update('emp_trainings_seminar_incoming_employees',array('status'=>$respond,'date_respond'=>date('Y-m-d H:i:s')));
	}

	public function training_request_list_incoming($val)
	{
		$employee_id = $this->session->userdata('employee_id');
		$date =  date('Y-m-d');

		$this->db->join('emp_trainings_seminar_incoming_employees b','b.training_id=a.training_seminar_id');
		$this->db->where(array('b.employee_id'=>$employee_id,'a.ifAdded'=>0));

		if($val==1)
		{
			$this->db->where(array('b.date_respond!='=>Null,'b.status'=>1));
		}
		else
		{
			$this->db->where(array('b.date_respond!='=>Null,'b.status'=>0));
		}
		$query = $this->db->get('emp_trainings_seminars_incoming a');
		return $query->result();
	}

	public function update_reponse($val,$id)
	{
		
		if($id==1){ $d=0; } else{ $d=1; }
		$this->db->where(array('employee_id'=>$this->session->userdata('employee_id'),'training_id'=>$val));
		$this->db->update('emp_trainings_seminar_incoming_employees',array('status'=>$d,'date_respond'=>date('Y-m-d H:i:s')));
	}

	public function filter_history_result($response_status,$training_status,$date_from,$date_to,$option,$training_type)
	{
		$date = date('Y-m-d');
		$where = "date(a.date_added) between '" .$date_from. "' and '" .$date_to. "'";
		

		$employee_id = $this->session->userdata('employee_id');
		if($response_status=='all'){} else if($response_status=='no_reponse'){ $this->db->where(array('status'=>0,'date_respond'=>Null)); } 
		else { $this->db->where(array('status'=>$response_status,'date_respond!='=>Null)); }

		if($option=='all'){} else{ $this->db->where('a.ifAdded',$option); }

		if($training_type=='all'){} else{ $this->db->where('a.fee_type',$training_type); }

		if($training_status=='all'){} 
		elseif($training_status=='finished') { $this->db->where('a.dateto <',$date); }
		elseif($training_status=='unfinished') { $this->db->where(array('a.dateto > '=>$date,'a.datefrom > '=>$date)); }
		else{ $this->db->where(array('a.datefrom <= '=>$date,'a.dateto > '=>$date)); }

		if($date_from!='not_included' AND $date_to!='not_included')
		{
			$this->db->where($where);
		}
		else if($date_from!='not_included')
		{
			$this->db->where('a.datefrom',$date_from);
		}	
		else if($date_to!='not_included')
		{
			$this->db->where('a.dateto',$date_to);
		}

		$this->db->join('emp_trainings_seminar_incoming_employees b','b.training_id=a.training_seminar_id');
		$this->db->where('b.employee_id',$employee_id);
		$query = $this->db->get('emp_trainings_seminars_incoming a');
		return $query->result();
	}

	public function get_training_details($id)
	{
		$this->db->where('training_seminar_id',$id);
		$query = $this->db->get('emp_trainings_seminars_incoming');
		return $query->result();
	}
	public function get_training_dates($id)
	{
		$this->db->where('seminar_training_id',$id);
		$query = $this->db->get('emp_trainings_seminars_dates_incoming');
		return $query->result();
	}
}
