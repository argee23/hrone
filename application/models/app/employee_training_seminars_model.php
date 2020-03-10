<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_training_seminars_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
		$this->load->model("app/employee_201_profile_model");
	}

	public function get_settings()
	{
		$this->db->select('a.*,b.company_name');
		$this->db->join('company_info b','b.company_id=a.company');
		$query = $this->db->get('201_trainings_seminar_settings a');
		return $query->result();
	}

	public function save_settings($company,$settings)
	{
		$data = array('company'=>$company,'setting'=>$settings,'InActive'=>0,'date_added'=>date('Y-m-d'));
		$this->db->insert('201_trainings_seminar_settings',$data);
		if($this->db->affected_rows() > 0)
		{
			return 'inserted';
		}
		else
		{
			return 'exist';
		}
	}

	public function settings_action($id,$action)
	{
		$this->db->where('id',$id);
		if($action=='delete')
		{
			$this->db->delete('201_trainings_seminar_settings');
		}
		else if($action=='enable')
		{
			$this->db->update('201_trainings_seminar_settings',array('InActive'=>0));
		}
		else if($action=='disable')
		{
			$this->db->update('201_trainings_seminar_settings',array('InActive'=>1));
		}
		else if($action=='edit')
		{

			$query = $this->db->get('201_trainings_seminar_settings');
			return $query->row();
		}
	}

	public function saveupdate_settings($company,$setting) 
	{
		$this->db->where('company',$company);
		$this->db->update('201_trainings_seminar_settings',array('setting'=>$setting));

		if($this->db->affected_rows() > 0)
		{
			return 'updated';
		}
		else
		{
			return 'nochanges';
		}
	}

	public function employeelist_model($val,$company_id,$location)
	{
		$search = str_replace("-","",$val);
		
		$this->db->select('company_info.company_id as company_id,company_name,first_name,middle_name,last_name,employee_info.employee_id');
		$this->db->from('company_info');
		$this->db->join("employee_info","employee_info.company_id = company_info.company_id");
		if($company_id=='all'){}else{ $this->db->where('company_info.company_id',$company_id); }
		if($location=='all'){} else{ $this->db->where('employee_info.location',$location); }
		$this->db->where("(`last_name` LIKE '%$search%' ||  `first_name` LIKE '%$search%' ||  `employee_id` LIKE '%$search%')");
		$this->db->order_by('last_name','asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function save_individual_adding($employee_id,$picture)
	{
	
		$fee_type = $this->input->post('fee_type');
		if($fee_type=='free')
		{
			$fee_amount = '';	
			$p_status   = '';
		}
		else
		{
			$fee_amount = $this->input->post('fee_amount'); 
			$p_status = $this->input->post('payment_status');
		}

		$data = array(
						'employee_info_id' 	=> $employee_id,
						'training_type' 	=> $this->input->post('training_type'),
						'sub_type' 			=> $this->input->post('sub_type'),
						'training_title'	=> $this->input->post('title'),
						'purpose' 	=> $this->input->post('purpose'),
						'conducted_by_type' => $this->input->post('conducted_by_type'),
						'conducted_by'		=>  $this->input->post('conducted_by'),
						'training_address'	=> $this->input->post('address'),
						'date_from' 			=> $this->input->post('date_from'),
						'date_to' 			=> $this->input->post('date_to'),
						'fee_type'	=> $this->input->post('fee_type'),
						'fee_amount'  => $fee_amount,
						'payment_status' 	=> $p_status,
						'date_added'		=> date('Y-m-d'),
						'file_name'			=> $picture,
						'monthsRequired'	=> $this->input->post('requiredmonths')
				);

		$this->db->insert('emp_trainings_seminars',$data);

		$insertid = $this->db->insert_id();

		$selected = $this->input->post('selected_dates');
		$res = substr_replace($selected, "", -1);
		$array =  explode('=', $res);

		foreach($array as $a)
		{
			$date = $this->input->post('date_'.$a);
			$time_from = $this->input->post('time_from'.$a);
			$time_to = $this->input->post('time_to'.$a);
			$hours = $this->input->post('hour'.$a);

			$dataa = array('seminar_training_id'=>$insertid,
							'date'				=>$date,
							'time_from'			=>$time_from,
							'time_to'			=>$time_to,
							'hours'				=>$hours);
			$this->db->insert('emp_trainings_seminars_dates',$dataa);
		}
		$total = $this->employee_201_profile_model->get_total_hours($insertid);
		$this->db->where('seminar_training_id',$insertid);
		$this->db->order_by('date','ASC');
		$q = $this->db->get('emp_trainings_seminars_dates',1);
		
		$this->db->where('training_seminar_id',$insertid);
		$this->db->update('emp_trainings_seminars',array('datefrom'=>$q->row('date'),'total_hours'=>$total->hours));

		$this->db->where('seminar_training_id',$insertid);
		$this->db->order_by('date','DESC');
		$qq = $this->db->get('emp_trainings_seminars_dates',1);

		$this->db->where('training_seminar_id',$insertid);
		$this->db->update('emp_trainings_seminars',array('dateto'=>$qq->row('date')));


	}	




	//filtering employees

	public function departmentList($company)
	{
		$this->db->where(array('company_id'=>$company,'InActive'=>0));
		$query = $this->db->get('department');
		return $query->result();
	}

	public function sectionList($department,$company)
	{
		if($department=='all')
		{
			$this->db->join('department b','b.department_id=a.department_id');
			$this->db->where('b.company_id',$company);
			$this->db->where('a.InActive',0);
			$query = $this->db->get('section a');
		}
		else
		{
			$this->db->where('department_id',$department);
			$this->db->where('InActive',0);
			$query = $this->db->get('section');
		}

		return $query->result();
	}

	public function subsectionList($section,$department,$company)
	{
		if($section=='all')
		{
			$this->db->join('section b','b.section_id=a.section_id');
			$this->db->join('department c','c.department_id=b.department_id');
			if($department=='all'){ $this->db->where('c.company_id',$company); }
			else { $this->db->where('c.department_id',$department); }
			$this->db->where('a.InActive',0);
			$query = $this->db->get('subsection a');
		}
		else
		{
			$this->db->where('section_id',$section);
			$this->db->where('InActive',0);
			$query = $this->db->get('subsection');
		}

		return $query->result();
	}

	public function get_filtered_employees($company,$location,$classification,$department,$section,$subsection)
	{
		
		$this->db->join('location c','c.location_id=a.location');
		$this->db->join('classification d','d.classification_id=a.classification');
		$this->db->where('a.company_id',$company);

		if($location=='all' || $location=='not_included')
		{} else { $this->db->where('a.location',$location); }
		

		if($classification=='all' || $classification=='not_included')
		{} else{ $this->db->where('a.classification',$classification); }

		if($department=='all' || $department=='not_included')
		{} else{ $this->db->where('a.department',$department); }
	
		if($section=='all' || $section=='not_included')
		{} else{ $this->db->where('a.section',$section); }

		if($subsection=='all' || $subsection=='not_included')
		{} else{ $this->db->where('a.subsection',$subsection); }
	
		
		$query = $this->db->get('employee_info a');
		return $query->result();
	}

	public function get_name_emp($emp)
	{
		$this->db->where('employee_id',$emp);
		$q= $this->db->get('employee_info');
		return $q->row('first_name')." ".$q->row('last_name');
	}
	public function save_mass_adding($finalemployee,$picture)
	{
		$var = explode("-",$finalemployee);

		foreach($var as $em)
		{
			$fee_type = $this->input->post('fee_type');
			if($fee_type=='free')
			{
				$fee_amount = '';	
				$p_status   = '';
			}
			else
			{
				
				$fee_amount = $this->input->post('fee_amount');
				$p_status   = $this->input->post('payment_status');
			}

			$data = array(
							'employee_info_id' 	=> $em,
							'training_type' 	=> $this->input->post('training_type'),
							'sub_type' 			=> $this->input->post('sub_type'),
							'training_title'	=> $this->input->post('title'),
							'purpose' 	=> $this->input->post('purpose'),

							'conducted_by_type' 	=> $this->input->post('conducted_by_type'),
							'conducted_by'		=> $this->input->post('conducted_by'),
							'training_address'	=> $this->input->post('address'),
							'date_from' 			=> $this->input->post('date_from'),
							'date_to' 			=> $this->input->post('date_to'),
							'fee_type'	=> $this->input->post('fee_type'),
							'fee_amount'  => $fee_amount,
							'payment_status' 	=> $p_status,
							'date_added'		=> date('Y-m-d'),
							'file_name'			=>	$picture,
							'monthsRequired'	=>	$this->input->post('requiredmonths')
					);

			$this->db->insert('emp_trainings_seminars',$data);	


			$insertid = $this->db->insert_id();

			$selected = $this->input->post('selected_dates');
			$res = substr_replace($selected, "", -1);
			$array =  explode('=', $res);

			foreach($array as $a)
			{
				$date = $this->input->post('date_'.$a);
				$time_from = $this->input->post('time_from'.$a);
				$time_to = $this->input->post('time_to'.$a);
				$hours = $this->input->post('hour'.$a);
				$dataa = array('seminar_training_id'=>$insertid,
								'date'				=>$date,
								'time_from'			=>$time_from,
								'time_to'			=>$time_to,
								'hours'				=>$hours);
				$this->db->insert('emp_trainings_seminars_dates',$dataa);
			}

			$total = $this->employee_201_profile_model->get_total_hours($insertid);
			$this->db->where('seminar_training_id',$insertid);
			$this->db->order_by('date','ASC');
			$q = $this->db->get('emp_trainings_seminars_dates',1);
			
			$this->db->where('training_seminar_id',$insertid);
			$this->db->update('emp_trainings_seminars',array('datefrom'=>$q->row('date'),'total_hours'=>$total->hours));

			$this->db->where('seminar_training_id',$insertid);
			$this->db->order_by('date','DESC');
			$qq = $this->db->get('emp_trainings_seminars_dates',1);

			$this->db->where('training_seminar_id',$insertid);
			$this->db->update('emp_trainings_seminars',array('dateto'=>$qq->row('date')));


		}
		
	}

	public function get_date_details($datee,$seminarid)
	{

		$this->db->where(array('date'=>$datee,'seminar_training_id'=>$seminarid));
		$query = $this->db->get('emp_trainings_seminars_dates',1);
		return $query->row();



	}
	public function get_date_details_incoming($datee,$seminarid)
	{

		$this->db->where(array('date'=>$datee,'seminar_training_id'=>$seminarid));
		$query = $this->db->get('emp_trainings_seminars_dates_incoming',1);
		return $query->row();



	}

	public function get_date_details_upd($datee,$seminarid)
	{	
		$this->db->where('seminar_training_id',$seminarid);
		$q = $this->db->get('emp_trainings_seminars_dates_update');
		if(!empty($q->result()) > 0)
		{
			$this->db->where(array('date'=>$datee,'seminar_training_id'=>$seminarid));
			$query = $this->db->get('emp_trainings_seminars_dates_update',1);
			return $query->row();
		}
		else
		{
			$this->db->where(array('date'=>$datee,'seminar_training_id'=>$seminarid));
			$query = $this->db->get('emp_trainings_seminars_dates',1);
			return $query->row();

		 }
		
		
	}


	public function save_incoming_trainings($finalemployee,$picture)
	{
			$var = explode("-",$finalemployee);
		
			$fee_type = $this->input->post('fee_type');

			if($fee_type=='free')
			{
				$fee_amount = '';	
			}
			else
			{
				
				$fee_amount = $this->input->post('fee_amount');
			}

			$data = array(
							'training_type' 	=> $this->input->post('training_type'),
							'sub_type' 			=> $this->input->post('sub_type'),
							'training_title'	=> $this->input->post('title'),
							'purpose' 	=> $this->input->post('purpose'),
							'conducted_by_type' 	=> $this->input->post('conducted_by_type'),
							'conducted_by'		=> $this->input->post('conducted_by'),
							'training_address'	=> $this->input->post('address'),
							'date_from' 			=> $this->input->post('date_from'),
							'date_to' 			=> $this->input->post('date_to'),
							'fee_type'	=> $this->input->post('fee_type'),
							'fee_amount'  => $fee_amount,
							'date_added'		=> date('Y-m-d'),
							'file_name'			=>	$picture,
							'monthsRequired'	=>	$this->input->post('requiredmonths'),
							'company_id' => $this->input->post('fcompany'),
							'ifAdded'	=>	0
					);

			$this->db->insert('emp_trainings_seminars_incoming',$data);	
			$insertid = $this->db->insert_id();

			if(!empty($insertid))
			{
				$logtrails_incoming = $this->add_logtrails_incoming('INSERT',$this->session->userdata('employee_id'),$finalemployee,date('Y-m-d H:i:s'),$insertid);
			}


			foreach($var as $em)
			{
				$dataaa =  array('training_id'=>$insertid,'employee_id'=>$em,'status'=>0);
				$this->db->insert('emp_trainings_seminar_incoming_employees',$dataaa);
			}


			$selected = $this->input->post('selected_dates');
			$res = substr_replace($selected, "", -1);
			$array =  explode('=', $res);

			foreach($array as $a)
			{
				$date = $this->input->post('date_'.$a);
				$time_from = $this->input->post('time_from'.$a);
				$time_to = $this->input->post('time_to'.$a);
				$hours = $this->input->post('hour'.$a);
				$dataa = array('seminar_training_id'=>$insertid,
								'date'				=>$date,
								'time_from'			=>$time_from,
								'time_to'			=>$time_to,
								'hours'				=>$hours);
				$this->db->insert('emp_trainings_seminars_dates_incoming',$dataa);
			}

			$total = $this->employee_201_profile_model->get_total_hours($insertid);

			$this->db->select('SUM(hours) AS hours');
			$this->db->where('seminar_training_id',$insertid);
			$query = $this->db->get('emp_trainings_seminars_dates_incoming');
			$total = $query->row();

			$this->db->where('seminar_training_id',$insertid);
			$this->db->order_by('date','ASC');
			$q = $this->db->get('emp_trainings_seminars_dates_incoming',1);
			
			$this->db->where('training_seminar_id',$insertid);
			$this->db->update('emp_trainings_seminars_incoming',array('datefrom'=>$q->row('date'),'total_hours'=>$total->hours));

			$this->db->where('seminar_training_id',$insertid);
			$this->db->order_by('date','DESC');
			$qq = $this->db->get('emp_trainings_seminars_dates_incoming',1);

			$this->db->where('training_seminar_id',$insertid);
			$this->db->update('emp_trainings_seminars_incoming',array('dateto'=>$qq->row('date')));

	}

	public function incoming_trainings_seminar()
	{
		$this->db->select('a.*,b.company_name');
		$this->db->join('company_info b','b.company_id=a.company_id');
		$query = $this->db->get('emp_trainings_seminars_incoming a');
		return $query->result();
	}

	
	public function get_filter_bycompany($company)
	{
		if($company=='all'){}else{ $this->db->where('company_id',$company); } 
		$query = $this->db->get('emp_trainings_seminars_incoming');
		return $query->result();
	}
	public function delete_incoming_trainings($id)
	{

		$this->db->where('seminar_training_id',$id);
		$this->db->delete('emp_trainings_seminars_dates_incoming');

		$this->db->where('training_seminar_id',$id);
		$this->db->delete('emp_trainings_seminars_incoming');

		$this->db->where('training_id',$id);
		$this->db->delete('emp_trainings_seminar_incoming_employees');

		$insert_log = $this->add_logtrails_incoming('DELETE',$this->session->userdata('employee_id'),'-',date('Y-m-d H:i:s'),$id);
	}

	

	public function get_incoming_trainingseminars($id)
	{
		$this->db->where('training_seminar_id',$id);
		$query = $this->db->get('emp_trainings_seminars_incoming',1);
		return $query->result();
	}

	public function get_incoming_trainingseminars_date($id)
	{
		$this->db->where('seminar_training_id',$id);
		$query = $this->db->get('emp_trainings_seminars_dates_incoming');
		return $query->result();
	}

	public function get_incoming_trainingseminars_employees($id)
	{
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->where('a.training_id',$id);
		$query = $this->db->get('emp_trainings_seminar_incoming_employees a');
		return $query->result();
	}

	public function incoming_trainingseminar_save_modify($training_seminar_id,$picture)
	{
		$employees = $this->input->post('finalemployee');
		$ress = substr_replace($employees, "", -1);
		$var =  explode('-', $ress);


		$fee_type = $this->input->post('fee_type');
		if($fee_type=='free')
			{
				$fee_amount = '';
			}
		else
			{
				$fee_amount = $this->input->post('fee_amount');
			}

		$data = array(
						'training_type' 	=> $this->input->post('training_type'),
						'sub_type' 			=> $this->input->post('sub_type'),
						'training_title'	=> $this->input->post('title'),
						'purpose' 			=> $this->input->post('purpose'),

						'conducted_by_type' => $this->input->post('conducted_by_type'),
						'conducted_by'		=> $this->input->post('conducted_by'),
						'training_address'	=> $this->input->post('address'),

						'date_from' 		=> $this->input->post('date_from'),
						'date_to' 			=> $this->input->post('date_to'),

						'fee_type'			=> $this->input->post('fee_type'),
						'fee_amount'  		=> $fee_amount,
						'date_added'		=> date('Y-m-d'),
						'monthsRequired'	=> $this->input->post('requiredmonths')
				);

		$this->db->where('training_seminar_id', $training_seminar_id);
		$this->db->update("emp_trainings_seminars_incoming",$data);

		$this->db->where('training_id',$training_seminar_id);
		$this->db->delete('emp_trainings_seminar_incoming_employees');


		foreach($var as $em)
			{
				$dataaa =  array('training_id'=>$training_seminar_id,'employee_id'=>$em,'status'=>0);
				$this->db->insert('emp_trainings_seminar_incoming_employees',$dataaa);
				echo $em;
			}


		$selected = $this->input->post('selected_dates');
		$res = substr_replace($selected, "", -1);
		$array =  explode('=', $res);

		
		$this->db->where('seminar_training_id',$training_seminar_id);
		$this->db->delete('emp_trainings_seminars_dates_incoming');
		
		foreach($array as $a)
		{
			$date = $this->input->post('date_'.$a);
			$time_from = $this->input->post('time_from'.$a);
			$time_to = $this->input->post('time_to'.$a);
			$hours = $this->input->post('hour'.$a);

			$dataa = array('seminar_training_id'=>$training_seminar_id,
							'date'				=>$date,
							'time_from'			=>$time_from,
							'time_to'			=>$time_to,
							'hours'				=>$hours);
			$this->db->insert('emp_trainings_seminars_dates_incoming',$dataa);
		}

		$total = $this->employee_201_profile_model->get_total_hours($training_seminar_id);

		$this->db->select('SUM(hours) AS hours');
		$this->db->where('seminar_training_id',$training_seminar_id);
		$query = $this->db->get('emp_trainings_seminars_dates_incoming');
		$total = $query->row();

		$this->db->where('seminar_training_id',$training_seminar_id);
		$this->db->order_by('date','ASC');
		$q = $this->db->get('emp_trainings_seminars_dates_incoming',1);
			
		$this->db->where('training_seminar_id',$training_seminar_id);
		$this->db->update('emp_trainings_seminars_incoming',array('datefrom'=>$q->row('date'),'total_hours'=>$total->hours));

		$this->db->where('seminar_training_id',$training_seminar_id);
		$this->db->order_by('date','DESC');
		$qq = $this->db->get('emp_trainings_seminars_dates_incoming',1);

		$this->db->where('training_seminar_id',$training_seminar_id);
		$this->db->update('emp_trainings_seminars_incoming',array('dateto'=>$qq->row('date')));

		$insert_log = $this->add_logtrails_incoming('UPDATE',$this->session->userdata('employee_id'),$res,date('Y-m-d H:i:s'),'id - '.$training_seminar_id);
	}

	public function add_logtrails_incoming($action,$addedby,$finalemployee,$date,$id)
	{
		$this->db->insert('logfile_incoming_trainings_seminars',array('action'=>$action,'added_by'=>$addedby,'details'=>'id - '.$id,'employees'=>$finalemployee,'date'=>$date));
	}
}
