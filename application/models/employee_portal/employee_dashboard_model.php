<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_dashboard_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}

	public function getCelebrantsOfTheWeek()
	{
		$this->db->order_by('birthday', 'asc');
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$query = $this->db->get('birthday_celebrants_view');
		return $this->evaluateCelebrants($query->result());
	}

	public function getEventsForTheMonth()
	{
		$this->db->order_by('event_start', 'asc');
		$this->db->where('company_id', $this->session->userdata('company_id'));
		$query = $this->db->get('news_and_events_view');
		return $query->result();
	}

	public function is_section_manager()
	{
		$this->db->select('id');
		$this->db->where('manager', $this->session->userdata('employee_id'));

		$query = $this->db->get('section_manager', 1); //Limit 1


		if ($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function send_greeting()
	{
		$sender = $this->session->userdata('employee_id');
		$this->data = array(
			'sender_employee_id'		=> 		$sender,
			'message_content'			=>		$this->input->post('message_content'),
			'receiver_employee_id'		=>		$this->input->post('receiver')
			);

		$this->db->set('time_sent', 'NOW()', FALSE);
		$this->db->set('message_year', 'year(now())', FALSE);

		$this->db->insert('birthday_message', $this->data);
	}
	
	public function check_old_password()
	{
		$id = $this->session->userdata('employee_id');

		$this->db->select("password");
		$this->db->where(array(
			'employee_id'			=> $id,
			'password'				=> $this->input->post('current_password')
			));

		$query = $this->db->get("employee_info");

		if ($query->num_rows() > 0)
		{
			return true;
		}

		else {

		return false;
		}
	}

	public function change_password()
	{
		$id = $this->session->userdata('employee_id');

		$this->data 	=array(
			'password'		=>		$this->input->post('new_password'),
			);

		$this->db->set('passChangeDate', 'now()', FALSE);
		$this->db->where("employee_id", $id);
		$this->db->update('employee_info', $this->data);
	}

	public function send_reply()
	{
		$this->data = array(
			'receiver_reply'		=> $this->input->post('message')
			);

		$this->db->set('reply_sent', 'now()', FALSE);
		$this->db->where("message_id", $this->input->post('message_id'));


		$this->db->update("birthday_message", $this->data);
	}

	public function evaluateCelebrants($celebrants)
	{
		foreach ($celebrants as $rel)
		{
			$cel_id = $rel->employee_id;

			$message_id = $this->checkMessage($cel_id);
			if (!($message_id))
			{
				$rel->message_id = '';
			}
			else {
				$rel->message_id = $message_id->message_id;
			}
		}

		return $celebrants;
	}

	public function checkMessage($celebrant_id)
	{
		$this->db->select("message_id");
		$this->db->where(array(
			'sender_employee_id'			=>			$this->session->userdata('employee_id'),
			'receiver_employee_id'			=>			$celebrant_id,
			'message_year'					=>			date('Y')
			));

		$query = $this->db->get('birthday_message');

		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
		else{
			return false;
		}
	}

	public function get_message($message_id)
	{
		$this->db->select("a.message_content, a.receiver_reply, a.time_sent, a.reply_sent, b.picture, b.isApplicant, b.first_name, b.last_name");
		$this->db->join("employee_info b", "b.employee_id = a.receiver_employee_id", "left outer");
		$this->db->where('a.message_id', $message_id);
		$query = $this->db->get('birthday_message a');
		return $query->row();
	}

	public function get_birthday_messages($employee_id)
	{
		$this->db->select("a.message_id, a.message_content, a.receiver_reply, a.time_sent, a.reply_sent, b.picture, b.isApplicant, b.first_name, b.last_name");
		$this->db->join("employee_info b", "b.employee_id = a.sender_employee_id", "left outer");
		$this->db->where('a.receiver_employee_id', $employee_id);
		$this->db->where('message_year', date('Y'));
		$this->db->order_by("a.time_sent", "asc");
		$query = $this->db->get('birthday_message a');
		return $query->result();
	}

	public function getEvents()
	{
		$this->db->select("a.id, a.company_id, a.event_title, a.event_description, a.event_start, a.event_end, a.status, b.company_name");
		$this->db->join("company_info b", "a.company_id = b.company_id", "left outer join");
		$this->db->where("a.company_id", $this->session->userdata('company_id'));
		$this->db->order_by("a.event_start", "asc");
		$query = $this->db->get("news_and_events a");

		return $query->result();

	}


	public function check_can_view_comp($company_id)
	{ 
		$this->db->select('company');
		$this->db->from('emp_hired_notif_designation');
		$this->db->join('emp_hired_notification','emp_hired_notification.emp_hired_notif_id = emp_hired_notif_designation.emp_hired_notif_id');
		$this->db->where('company_id',$company_id);
		$query = $this->db->get();
		return $query->row("company");
	}
	//check_hired_notif
	public function check_hired_notif()
	{
		$this->db->select('*');
		$this->db->from('emp_hired_notification');
		$query = $this->db->get();
		return $query->result();
	}

	//list of employees
	public function emp_list()
	{
		$this->db->select('*,position_name,company_name,company_info.company_id,dept_name,department.department_id');
		$this->db->from('employee_info');
		$this->db->join('company_info','company_info.company_id=employee_info.company_id');
		$this->db->join('department','department.department_id=employee_info.department');
		$this->db->join('position','position.position_id=employee_info.position');
		$this->db->where('IsEnable','1');
		$query = $this->db->get();
		return $query->result();
	}

	//get the filter designation data
	public function check_designation_data($company_id)
	{
		
		$this->db->select('*');
		$this->db->from('emp_hired_notification');
		$this->db->where('company_id',$company_id);
		$query = $this->db->get();
		return $query->row("emp_hired_notif_id");

	}

	//get the filter designation data
	public function check_designation_company($emp_hired_notif_id)
	{
		
		$this->db->select('*');
		$this->db->from('emp_hired_notif_designation');
		$this->db->where('emp_hired_notif_id',$emp_hired_notif_id);
		$query = $this->db->get();
		return $query->result();

	}

	public function save_feelings(){
		
		$this->data = array(
			'mood'		=> 		$this->input->post('mood'),
			'date'			=>		date('y-m-d'),
			'employee_id'		=>  $this->session->userdata('employee_id'),
			'add_note' => $this->input->post('note')
			);



		$this->db->insert('mood', $this->data);
	}
	//for account management  qll option
	public function check_company_set_up($company_id)
	{
		$this->db->select('*');
		$this->db->from('emp_hired_notification');
		$this->db->where('company_id',$company_id);
		$query = $this->db->get();
		return $query->result();
	}

	//for multi company
	public function emp_list_multi($multi)
	{	
		$this->db->select('*,position_name,company_name,company_info.company_id,dept_name,department.department_id');
		$this->db->from('employee_info');
		$this->db->join('company_info','company_info.company_id=employee_info.company_id');
		$this->db->join('department','department.department_id=employee_info.department');
		$this->db->join('position','position.position_id=employee_info.position');
		$this->db->where('employee_info.company_id',$multi);
		$query = $this->db->get();
		return $query->result();
	}

	//employee details for one specs
	public function emp_details($emp_id)
	{
		$this->db->select('*');
		$this->db->from('employee_info');
		$this->db->where('employee_id',$emp_id);
		$query = $this->db->get();
		return $query->result();
	}

		public function is_employee_exist()
	{
		
		$this->db->select('*');
		$this->db->from('mood');
		$this->db->where('employee_id',$this->session->userdata('employee_id'));
		$this->db->where('date',date('y-m-d'));
		$query = $this->db->get();
		return $query->num_rows();

	}
	//lst off all employees based employment details of the employee loggin
	public function emp_list_all($company_id,$division,$department,$section,$subsection,$classification,$employment,$location,$status)
	{
		//echo $company_id."<br>".$division."<br>".$department."<br>".$section."<br>".$subsection."<br>".$classification."<br>".$employment."<br>".$location."<br>".$status;
		
		$this->db->select('*,position_name,company_name,company_info.company_id,dept_name,department.department_id');
		$this->db->from('employee_info');
		$this->db->join('company_info','company_info.company_id=employee_info.company_id');
		$this->db->join('department','department.department_id=employee_info.department');
		$this->db->join('position','position.position_id=employee_info.position');
		$this->db->where('employee_info.company_id',$multi);
		$this->db->where('company_id',$company_id);
		$this->db->where('employee_info.division_id',$division);
		$this->db->where('employee_info.department',$department);
		$this->db->where('employee_info.section',$section);
		$this->db->where('subsection',$subsection);
		$this->db->where('employee_info.classification',$classification);
		$this->db->where('employee_info.employment',$employment);
		$this->db->where('employee_info.location',$location);
		$this->db->where('employee_info.InActive',$status);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_emp_company($company)
	{
		
		$this->db->select('*,position_name,company_name,company_info.company_id,dept_name,department.department_id');
		$this->db->from('employee_info');
		$this->db->join('company_info','company_info.company_id=employee_info.company_id');
		$this->db->join('department','department.department_id=employee_info.department');
		$this->db->join('position','position.position_id=employee_info.position');
		$this->db->where('employee_info.company_id',$company);
		$query = $this->db->get();
		return $query->result();
	}
	public function get_emp_true($getemp,$division,$company)
		{ 
			$var = explode("-",$division);
			$this->db->select('*');
			$this->db->from('employee_info');
			$this->db->where('employee_id',$getemp);
			$this->db->where('company_id',$company);
			$query = $this->db->get();
			$div = $query->row("division_id");
			if($div=='' || $div==null)
				{ return 'true'; }
			else{
			$i=0;
			foreach ($var as $row1) {
				if($row1==$div) { $ii = $i + 1;  }
				else { $ii= 0; } 
				if($ii > 0) { return 'true'; } else  { }
			}
			}
		}
	public function get_emp_department($getemp,$department,$company)
	{ 
			$var = explode("-",$department);
			$this->db->select('*');
			$this->db->from('employee_info');
			$this->db->where('employee_id',$getemp);
			$this->db->where('company_id',$company);
			$query = $this->db->get();
			$div = $query->row("department");
			$i=0;
			foreach ($var as $row1) { 
				if($row1==$div) { $ii = $i + 1; }
				else { $ii= 0; } 
				if($ii > 0) { return 'true'; } else  {  }
			}
	}
	public function get_emp_section($getemp,$section,$company)
	{ 
			$var = explode("-",$section);
			$this->db->select('*');
			$this->db->from('employee_info');
			$this->db->where('employee_id',$getemp);
			$this->db->where('company_id',$company);
			$query = $this->db->get();
			$div = $query->row("section");
			$i=0;
			foreach ($var as $row1) { 
				if($row1==$div) { $ii = $i + 1; }
				else { $ii= 0; } 
				if($ii > 0) { return 'true'; } else  {  }
			}
	}
	public function get_emp_subsection($getemp,$subsection,$company)
	{ 
			$var = explode("-",$subsection);
			$this->db->select('*');
			$this->db->from('employee_info');
			$this->db->where('employee_id',$getemp);
			$this->db->where('company_id',$company);
			$query = $this->db->get();
			$div = $query->row("subsection");
			if($div=='' || $div==null)
				{ return 'true'; }
			else{
			$i=0;
			foreach ($var as $row1) { 
				if($row1==$div) { $ii = $i + 1; }
				else { $ii= 0; } 
				if($ii > 0) { return 'true'; } else  {  }
				}
			}
	}
	public function get_emp_classification($getemp,$classification,$company)
	{ 
			$var = explode("-",$classification);
			$this->db->select('*');
			$this->db->from('employee_info');
			$this->db->where('employee_id',$getemp);
			$this->db->where('company_id',$company);
			$query = $this->db->get();
			$div = $query->row("classification");
			$i=0;
			foreach ($var as $row1) { 
				if($row1==$div) { $ii = $i + 1; }
				else { $ii= 0; } 
				if($ii > 0) { return 'true'; } else  {  }
			}
	}
	public function get_emp_employment($getemp,$employment,$company)
	{ 
			$var = explode("-",$employment);
			$this->db->select('*');
			$this->db->from('employee_info');
			$this->db->where('employee_id',$getemp);
			$this->db->where('company_id',$company);
			$query = $this->db->get();
			$div = $query->row("employment");
			$i=0;
			foreach ($var as $row1) { 
				if($row1==$div) { $ii = $i + 1; }
				else { $ii= 0; } 
				if($ii > 0) { return 'true'; } else  {  }
			}
	}
	public function get_emp_location($getemp,$location,$company)
	{ 
			$var = explode("-",$location);
			$this->db->select('*');
			$this->db->from('employee_info');
			$this->db->where('employee_id',$getemp);
			$this->db->where('company_id',$company);
			$query = $this->db->get();
			$div = $query->row("location");
			$i=0;
			foreach ($var as $row1) { 
				if($row1==$div) { $ii = $i + 1; }
				else { $ii= 0; } 
				if($ii > 0) { return 'true'; } else  {  }
			}
	}
	public function get_emp_status($getemp,$status,$company)
	{ 
			$var = explode("-",$status);
			$this->db->select('*');
			$this->db->from('employee_info');
			$this->db->where('employee_id',$getemp);
			$this->db->where('company_id',$company);
			$query = $this->db->get();
			$div = $query->row("InActive");
			$i=0;
			foreach ($var as $row1) { 
				if($row1==$div) { $ii = $i + 1; }
				else { $ii= 0; } 
				if($ii > 0) { return 'true'; } else  {  }
			}
	}



	// ANNOUNCEMENT
	public function getUserInfo()
	{
		$id = $this->session->userdata('employee_id');
		$this->db->where('employee_id', $id);
		$query = $this->db->get('employee_info');

		return $query->row();
	}

	
	public function getAnnouncement()
	{	
		$info = $this->getUserInfo();

		if($info->subsection != 0 || $info->subsection != null){
			$this->db->where(array('table_name' => 'subsection', 'id' => $info->subsection));
		} else if($info->section != 0 || $info->section !=   null) {
			$this->db->where(array('table_name' => 'section', 'id' => $info->section));
		} else if ($info->division_id != 0 || $info->division_id != null){
			$this->db->where(array('table_name' => 'division', 'id' => $info->division_id));
		} else {
			$this->db->where(array('table_name' => 'department', 'id' => $info->department));
		}
		$this->db->where('date_from <= CURDATE()');
		$this->db->where('date_to >= CURDATE()');
		$this->db->join('announcement B', 'B.announcement_id = A.announcement_id', 'left');
		$query = $this->db->get('announcement_fields A');

		return $query->result();
	}
	// END


	//upcoming trainings and seminars

	public function upcoming_seminars_trainings()
	{
		$employee_id = $this->session->userdata('employee_id');
		$date = date('Y-m-d');
		$company_id = $this->session->userdata('company_id');
		$settings = $this->get_seminar_training_settings($company_id);
		if(empty($settings) || $settings==0)
		{
        	$this->db->where('datefrom <=',$date);
        	$this->db->where('dateto >=',$date);
		}
		$this->db->where('employee_info_id',$employee_id);
		$query = $this->db->get('emp_trainings_seminars');
		return $query->result();
	}

	public function get_seminar_training_settings($company_id)
	{
		$this->db->where('company',$company_id);
		$query = $this->db->get('201_trainings_seminar_settings');
		return $query->row('setting');
	}


	public function check_tracking_company_policy(){

		$employee_id = $this->session->userdata('employee_id');
		$company_id = $this->session->userdata('company_id');
				
		$this->db->where('company_id',$company_id);
		$q =  $this->db->get('company_code_of_discipline');
		$q_res = $q->result();

		$this->db->where('company_id',$company_id);
		$q1 =  $this->db->get('downloadable_company_policy');
		$q1_res = $q1->result();

		$company_policy = array_merge($q_res,$q1_res);

		if(empty($company_policy))
		{
			$res = 'false';
		}
		else
		{



				$this->db->select_max('date_created');
				$this->db->where('company_id',$company_id);
				$query = $this->db->get('log_trails_company_policy');

				if(empty($query->row('date_created')))
				{
					$this->db->where(array('employee_id'=>$employee_id,'company_id'=>$company_id));
					$q = $this->db->get('tracking_employee_company_policy');
					if(empty($q->result()))
					{
						$res =  'true';
					}
					else
					{
						$this->db->where(array('employee_id'=>$employee_id,'company_id'=>$company_id,'date_viewed!='=>"",'date_acknowledge!='=>""));
						$qq = $this->db->get('tracking_employee_company_policy');

						if(empty($qq->result()))
						{
							$res =  'true';
						}
						else
						{
							$res =  'false';
						}
					}
				}
				else
				{
					$date = $query->row('date_created');
					$this->db->where(array('employee_id'=>$employee_id,'company_id'=>$company_id));
					$qres = $this->db->get('tracking_employee_company_policy');

					if(empty($qres->row('acknowledge_updated')))
					{
						$date_base = $qres->row('date_acknowledge');
					}
					else
					{
						$date_base = $qres->row('acknowledge_updated');
					}
					if($date_base > $date)
					{
						$res='false';
					}
					else
					{
						$res='true_updated';
					}
				}
		}
		return $res;
	}

	public function check_if_with_requested_training()
	{
		$employee_id = $this->session->userdata('employee_id');

		$this->db->join('emp_trainings_seminar_incoming_employees b','b.training_id=a.training_seminar_id');
		$this->db->where(array('b.employee_id'=>$employee_id,'a.ifAdded'=>0,'b.status'=>0,'b.date_respond'=>Null));
		$query = $this->db->get('emp_trainings_seminars_incoming a');
		return $query->result();
	}

	public function check_applicants_for_interview()
	{
		$employee_id  = $this->session->userdata('employee_id');
		$date = date('Y-m-d');
		
		$this->db->where(array('applicant_official_response'=>'Accept','applicant_official_date >='=>$date,'interviewer'=>$employee_id));
		$query = $this->db->get('applicant_interview_response');
		return $query->result();
	}
	
}