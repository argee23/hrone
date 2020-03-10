<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Overtime_management_section_mngr_approved_ot_model extends CI_Model{
	public function __construct(){
		parent::__construct();	
	}

	
	
	public function plotted_details()
	{
			$this->db->select('a.*,c.*,a.id as id');
			$this->db->join('employee_info c','c.employee_id=a.plotted_by');
			$this->db->where(array('a.plotted_by'=>$this->session->userdata('employee_id')));
			$query = $this->db->get('atro_approved_main a');
			return $query->result();
	}

	public function delete_approved_ot($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('atro_approved_main');

		if($this->db->affected_rows() > 0)
		{
			$this->db->where('id',$id);
			$this->db->delete('atro_approved_members');
		}

	}


	public function view_approved_ot($id,$date)
	{
		$this->db->where('a.id',$id);
		$this->db->join('employee_info c','c.employee_id=a.employee_id');
		$query = $this->db->get('atro_approved_members a');
		return $query->result();
	}

	public function group_members()
	{
		$this->db->select('a.*,b.*,c.*');
		$this->db->join('department b','b.department_id=a.department');
		$this->db->join('section c','c.section_id=a.section');
		$query = $this->db->get('employee_info a');
		return $query->result();
	}

	public function group_members_checker()
	{
		$this->db->select('a.*,b.*,c.*');
		$this->db->join('department b','b.department_id=a.department');
		$this->db->join('section c','c.section_id=a.section');
		$query = $this->db->get('employee_info a');
		$res = $query->result();

		foreach($res as $r)
		{
			$checker =  $this->checker_member($r->section,$r->subsection,$r->location,$this->session->userdata('employee_id'));
			 if($checker > 0) { $r->checker = 'true'; } else{ $r->checker= 'false'; }
		}

		return $res;
	}


	
        

	public function general_exist_checker($date)
	{	
		$this->db->where(array('date'=> $date,'plotted_by'=>$this->session->userdata('employee_id')));
		$query = $this->db->get("atro_approved_main");
		return $query->row();
	}

	public function checker_member($section,$subsection,$location,$manager)
	{
		$this->db->where(array('section'=>$section,'location'=>$location,'manager'=> $manager,'InActive'=>0));
		if($subsection=='' || $subsection==null || $subsection==0){}
		else{ $this->db->where('subsection',$subsection); }
		$query = $this->db->get('section_manager');
		return $query->num_rows();
	}

	public function check_selected($employee_id,$date)
	{ 
		$this->db->join('atro_approved_main b','b.id=a.id');
		$this->db->where(array('a.employee_id'=>$employee_id,'a.date'=>$date));
		$query = $this->db->get("atro_approved_members a",1);
		return $query->row();
	}

	public function get_sched_grp_date($date,$employee_id)
	{

		$month = date("m", strtotime($date));
		$table = 'working_schedule_'.$month;
		$this->db->where(array('date'=>$date,'employee_id'=>$employee_id));
		$query = $this->db->get($table);
		return $query->row();
	}
	
	// public function save_approved_ot($emp,$hrs,$reason,$count,$date)
	// {	
		

	// 	$reas = $this->overtime_management_model->convert_char($reason);
	// 	$employees = explode("-",$emp);
	// 	$hours = explode("-",$hrs);
	// 	$data_main = array('plotted_by' => $this->session->userdata('employee_id'),'date' => $date, 'reason' => $reas , 'date_created'=> date('Y-m-d H:i:s'),'company_id'=>$this->session->userdata('company_id'));

	// 	$this->db->where(array('date'=>$date,'company_id'=>$this->session->userdata('company_id'),'plotted_by'=>$this->session->userdata('employee_id')));
	// 	$checker = $this->db->get("atro_approved_main");
	// 	$checker_id = $checker->row('id');

	// 	if(empty($checker_id))
	// 	{
	// 		$insert = $this->db->insert("atro_approved_main",$data_main);
	// 		$this->db->select_max('id');
	// 		$this->db->from("atro_approved_main");
	// 		$this->db->where($data_main);
	// 		$q = $this->db->get();
	// 		$id = $q->row('id');
	// 	}
	// 	else
	// 	{
	// 		$upd_reason = array('reason'=>$reas);
	// 		$this->db->where('id',$checker_id);
	// 		$update_main = $this->db->update("atro_approved_main",$upd_reason);

	// 		$id = $checker_id;
	// 	}
		
		
	// 	for($i=0;$i< $count; $i++)
	// 	{
			
	// 		$empp = $employees[$i];
	// 		$hrss = $hours[$i];
	// 		$data_members = array('id'=> $id,'employee_id'=> $empp,'hours' => $hrss, 'plotted_by' => $this->session->userdata('employee_id'),'date'=>$date,'date_inserted' => date('Y-m-d H:i:s') , 'company_id'=>$this->session->userdata('company_id'));	
	// 		$this->db->where(array('employee_id'=>$empp,'date'=>$date,'company_id'=>$this->session->userdata('company_id')));
	// 		$ee = $this->db->get("atro_approved_members");
			
	// 		if($ee->num_rows() > 0){
	// 			$rr = $ee->row('plotted_by');
	// 			if($rr==$this->session->userdata('employee_id'))
	// 			{  
	// 				$this->db->where(array('employee_id'=>$empp,'date'=>$date,'company_id'=>$this->session->userdata('company_id')));
	// 			  	$update = $this->db->update("atro_approved_members",$data_members);
	// 			}
	// 			else
	// 			{
	// 			}
	// 		}
	// 		else{ $insert = $this->db->insert("atro_approved_members",$data_members); }
			
	// 	}
	// }

	public function save_approved_ot($emp,$hrs,$reason,$count,$date)
	{	
		

		$reas = $this->overtime_management_model->convert_char($reason);
		$employees = explode("-",$emp);
		$hours = explode("-",$hrs);
		$data_main = array('plotted_by' => $this->session->userdata('employee_id'),'date' => $date, 'reason' => $reas , 'date_created'=> date('Y-m-d H:i:s'),'company_id'=>$this->session->userdata('company_id'));

		$this->db->insert("atro_approved_main",$data_main);
		if($this->db->affected_rows() > 0)
		{
				$this->db->select_max('id');
				$this->db->from("atro_approved_main");
				$this->db->where($data_main);
				$q = $this->db->get();
				$id = $q->row('id');

				for($i=0;$i< $count; $i++)
				{
					
					$empp = $employees[$i];
					$hrss = $hours[$i];
					$data_members = array('id'=> $id,'employee_id'=> $empp,'hours' => $hrss, 'plotted_by' => $this->session->userdata('employee_id'),'date'=>$date,'date_inserted' => date('Y-m-d H:i:s') , 'company_id'=>$this->session->userdata('company_id'));	
					$insert = $this->db->insert("atro_approved_members",$data_members);
					
				}
		}
		
	}


	public function add_member_save_pre_approved($id,$date,$hours,$employee,$count,$reason)
	{
			$reas = $this->overtime_management_model->convert_char($reason);
			
			$upd_reason = array('reason'=>$reas);
			$this->db->where('id',$id);
			$update_main = $this->db->update("atro_approved_main",$upd_reason);

			$this->db->where('id',$id);
			$delete = $this->db->delete('atro_approved_members');

			$employee_exp = explode("-", $employee);
			$i=0;
			foreach($employee_exp as $c)
			{
				$hrs_exp = explode("-", $hours);
				$data_members = array('id'=> $id,'employee_id'=> $c,'hours' => $hrs_exp[$i], 'plotted_by' => $this->session->userdata('employee_id'),'date'=>$date,'date_inserted' => date('Y-m-d H:i:s') , 'company_id'=>$this->session->userdata('company_id'));	
				$insert = $this->db->insert("atro_approved_members",$data_members);
				
				$i++;
			}

			
	}

	public function selected_group_member($id)
	{
		$this->db->where('id',$id);
		$q = $this->db->get('atro_approved_members');
		$result = $q->result();	

		$member = "";
		$hr = "";
		$i=1;
		foreach($result as $m)
		{
			 
			 $dd = $m->employee_id."-";
			 $member .= $dd;

			 $hh = $m->hours."-";
			 $hr .= $hh;

			 $i++; 
		}
		return array($member,$hr);
	}

	public function get_ot_reason($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('atro_approved_main',1);
		if(empty($query->row('reason'))) { $reason  =""; } else { $reason = $query->row('reason');  }

		return $reason;
	}

	public function delete_approved_ot_member($id)
	{
		$this->db->where('a_i',$id);
		$this->db->delete('atro_approved_members');
	}



	//add new group

	public function save_approved_ot_group()
	{
		$date       	=  $this->input->post('date');
		$reason     	=  $this->input->post('reason');
		$group_name 	=  $this->input->post('group_name');
		$plotted_by 	=  $this->session->userdata('employee_id');
		$date_plotted   =  date('Y-m-d H:i:s');
		$data =array('company_id'=>$this->session->userdata('company_id'),'plotted_by'=>$plotted_by,'date'=>$date,'reason'=>$reason,'date_created'=>$date_plotted,'group_name'=>$group_name);
		$this->db->insert('atro_approved_main',$data);


	}

	public function edit_group_approved_ot($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('atro_approved_main',1);
		return $query->result();
	}

	public function save_update_approved_ot_group()
	{

		$reason     	=  $this->input->post('reason');
		$group_name 	=  $this->input->post('group_name');
		$date_plotted   =  date('Y-m-d H:i:s');
		$id =$this->input->post('id');

		$this->db->where('id',$id);
		$this->db->update('atro_approved_main',array('reason'=>$reason,'group_name'=>$group_name));
	}


	//upload validations

	public function check_employee_under_sm($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info',1);
		$result = $query->result();
		if(empty($result))
		{
			return false;
		}
		else
		{
			foreach($result as $m)
			{
				$stat = $this->checker_member($m->section,$m->subsection,$m->location,$this->session->userdata('employee_id'));
				if($stat > 0) { return true; } else{ return false; }
			}
		}
		
	}

	public function employee_name($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$q = $this->db->get('employee_info',1);
		$result = $q->result();
		if(empty($result))
		{
			return "Employee not exist";
		}
		else
		{
			foreach ($result as $k) {
				return $k->first_name.' '.$k->last_name;
			}
		}
		
	}

	public function check_employee_with_existing_ot_hr($employee_id,$date,$id)
	{
		$this->db->join('atro_approved_main b','b.id=a.id');
		$this->db->where(array('a.employee_id'=>$employee_id,'a.date'=>$date,'a.id!='=>$id));
		$res = $this->db->get('atro_approved_members a');

		return $res->result();
	}

	public function check_employee_with_existing($employee_id,$date,$id)
	{
		$this->db->where(array('employee_id'=>$employee_id,'date'=>$date,'id'=>$id));
		$res = $this->db->get('atro_approved_members');
		return $res->result();
	}

	public function insert_approved_ot($id,$date,$employee_id,$ot_hour)
	{
		$this->db->where(array('employee_id'=>$employee_id,'id'=>$id,'date'=>$date));
		$query = $this->db->get('atro_approved_members');
		if(!empty($query->result()))
		{
			$this->db->where(array('employee_id'=>$employee_id,'id'=>$id,'date'=>$date));
			$this->db->update('atro_approved_members',array('hours'=>$ot_hour));
			return 'inserted'; 

			
		}
		else
		{
				$data = array('id'=>$id,'company_id'=>$this->session->userdata('company_id'),'employee_id'=>$employee_id,'hours'=>$ot_hour,'plotted_by'=>$this->session->userdata('employee_id'),'date'=>$date,'date_inserted'=>date('Y-m-d H:i:s'));
				$this->db->insert('atro_approved_members',$data);
				if($this->db->affected_rows() > 0)
				{
	    			return 'inserted'; 
				}
				else
				{ return 'error'; }


		}
		
	}

	public function get_employee_attendance($employee_id,$date)
	{
		  $tmonth= substr($date, 5,2);

		  $this->db->where(array('employee_id'=>$employee_id,'covered_date'=>$date));
		  $query = $this->db->get('attendance_'.$tmonth);
		  return $query->result();
	}

	public function saveapproved_ot($idd,$date)
	{
		$insertArray = array();
		$count = $this->input->post('count');
		
		$this->db->where(array('id'=>$idd,'date'=>$date));
		$this->db->delete('atro_approved_members');

		for($i=1; $i <= $count; $i++)
		{
			$id  = $this->input->post('employee_id'.$i);
			$employee_id  = $this->input->post('employee_value'.$i);

			if($id == true)
			{
				$ot_hour  = $this->input->post('total_hour'.$i);

				
				if($ot_hour=='0' || empty($ot_hour) || $ot_hour < 0){}
				else
				{
					$data = array('id'=>$idd,'company_id'=>$this->session->userdata('company_id'),'employee_id'=>$employee_id,'hours'=>$ot_hour,'plotted_by'=>$this->session->userdata('employee_id'),'date'=>$date,'date_inserted'=>date('Y-m-d H:i:s'));
					array_push($insertArray,$data);
				}
			}
		}
		if(empty($insertArray))
		{

		}
		else
		{
			$this->db->insert_batch('atro_approved_members', $insertArray);
		}
		
	}
	
	public function get_filtered_approved_ot($from,$to)
	{
		$where = "date(date) between '" .$from. "' and '" .$to. "'";
		$this->db->where($where);	
		$this->db->where('plotted_by',$this->session->userdata('employee_id'));
		$get = $this->db->get('atro_approved_main');
		return $get->result();
	}

	public function employee_approved_ot($employee_id,$date)
	{
		$this->db->join('atro_approved_members b','b.id=a.id');	
		if($date!='all'){ $this->db->where('a.date',$date); }
		$this->db->where('b.employee_id',$employee_id);
		$get = $this->db->get('atro_approved_main a');
		return $get->result();
	}

	//check for individual schedule
	public function get_individual_schedules($employee,$date,$tmonth,$year)
	{
		    $this->db->join('employee_info b','b.employee_id=a.employee_id');
			$this->db->where(array('a.date'=>$date,'b.employee_id'=>$employee));
			$res = $this->db->get('working_schedule_'.$tmonth.' a',1);
			$result = $res->result();
			return $result;	
			
	}
	//check for fixed schedule
	public function checker_if_fixed_sched($employee,$date)
	{
		$this->db->join('fixed_working_schedule_members b','b.group_id=a.id');
		$this->db->where(array('b.InActive'=>0,'a.InActive'=>0,'b.employee_id'=>$employee));
		$query = $this->db->get('fixed_working_schedule_group a',1);
		$result = $query->result();
		return $result;

	}

	//check for group schedule
	public function checker_if_group_sched($employee,$date)
	{
		$this->db->select('a.id as id');
		$this->db->join('working_schedule_group_by_sec_manager_members b','b.group_id=a.id');
		$this->db->where(array('b.InActive'=>0,'a.InActive'=>0,'b.employee_id'=>$employee));
		$query = $this->db->get('working_schedule_group_by_sec_manager a',1);

		if(!empty($query->result()))
		{
			$this->db->where(array('group_id'=>$query->row('id'),'date'=>$date));
			$q = $this->db->get('working_schedules_by_group');
			return $q->result();
		}
		else
		{
			return null;
		}
		

	}
}
