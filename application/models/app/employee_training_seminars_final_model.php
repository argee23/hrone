<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_training_seminars_final_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
		$this->load->model("app/employee_201_profile_model");
	}

	
	//setings

	public function get_settings()
	{
		$this->db->select('a.*,b.company_name');
		$this->db->join('company_info b','b.company_id=a.company');
		$query = $this->db->get('201_trainings_seminar_settings a');
		return $query->result();
	}

	public function save_settings($company,$settings)
	{

		$this->db->where('company',$company);
		$q = $this->db->get('201_trainings_seminar_settings');

		if($q->num_rows() > 0)
		{
			return 'exist';
		}
		else
		{
			$data = array('company'=>$company,'setting'=>$settings,'InActive'=>0,'date_added'=>date('Y-m-d'));
			$this->db->insert('201_trainings_seminar_settings',$data);
			return 'inserted';
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


	//file maintenance

	public function file_maintenance_list()
	{
		$this->db->join('company_info b','b.company_id=a.company_id');
		$query = $this->db->get('emp_trainings_seminars_file_maintenance a');
		return $query->result();
	}

	public function get_employees($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('employee_info');
		return $query->result();
	}

	public function save_file_maintenance()
	{
		$company = $this->input->post('company');
		$title =  $this->input->post('title');
		$training_type = $this->input->post('training_type');
		$purpose = $this->input->post('purpose');
		$sub_type = $this->input->post('sub_type');

		$address = $this->input->post('address');
		$conducted_by_type = $this->input->post('conducted_by_type');
		$fee_type = $this->input->post('fee_type');
		$conducted_by = $this->input->post('conducted_by');
		$fee_amount = $this->input->post('fee_amount');
		$length  = $this->input->post('requiredmonths');
		$payment_status  = $this->input->post('payment_status');
		$type  = $this->input->post('type_option');


		$data = array(	'company_id'			=>	$company,
						'training_title'		=>	$title,
						'training_type'			=>	$training_type,
						'purpose'				=>	$purpose,
						'sub_type'				=>	$sub_type,
						'training_address'		=>	$address,
						'conducted_by_type'		=> 	$conducted_by_type,	
						'fee_type'				=> 	$fee_type,
						'conducted_by' 			=> 	$conducted_by,
						'fee_amount'			=> 	$fee_amount,
						'payment_status'		=> 	$payment_status,	
						'monthsRequired'		=>  $length,
						'date_created'			=>	date('Y-m-d H:i:s'),
						'added_by'				=>	$this->session->userdata('employee_id'),
						'type'					=> 	$type
					 );

		$insert_trainings_seminar =  $this->db->insert('emp_trainings_seminars_file_maintenance',$data);
		$maintenance_id = $this->db->insert_id();

		$selected = $this->input->post('selected_dates');
		$res = substr_replace($selected, "", -1);
		$array =  explode('=', $res);

		$i=1;
		$total_hours=0;
		foreach($array as $a)
		{	
			$date = $this->input->post('date_'.$a);
			$time_from = $this->input->post('time_from'.$a);
			$time_to = $this->input->post('time_to'.$a);
			$hours = $this->input->post('hour'.$a);

			$total_hours = $hours+$total_hours;
			if($i==1)
			{
				$this->db->where('id',$maintenance_id);
				$this->db->update('emp_trainings_seminars_file_maintenance',array('datefrom'=>$date));
			}

			if($i==count($array))
			{
				$this->db->where('id',$maintenance_id);
				$this->db->update('emp_trainings_seminars_file_maintenance',array('dateto'=>$date,'total_hours'=>$total_hours));
			}

			$data_dates = array('seminar_training_id'=>$maintenance_id,'date'=>$date,'time_from'=>$time_from,'time_to'=>$time_to,'hours'=>$hours);
			$this->db->insert('emp_trainings_seminars_dates_file_maintenance',$data_dates);

			$i++;
		}

	}

	public function filtering_file_maintenance($company)
	{
		$this->db->join('company_info b','b.company_id=a.company_id');
		$this->db->where('a.company_id',$company);
		$query = $this->db->get('emp_trainings_seminars_file_maintenance a');
		return $query->result();
	}

	public function delete_fincoming_trainings($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->delete('emp_trainings_seminars_file_maintenance');

		$this->db->where('seminar_training_id',$id);
		$query = $this->db->delete('emp_trainings_seminars_dates_file_maintenance');
	}

	public function get_fincoming_trainingseminars($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('emp_trainings_seminars_file_maintenance');
		return $query->result();

	}

	public function get_fincoming_trainingseminars_date($id)
	{
		$this->db->where('seminar_training_id',$id);
		$query = $this->db->get('emp_trainings_seminars_dates_file_maintenance');
		return $query->result();
	}

	public function fincoming_trainingseminar_save_modify($training_seminar_id)
	{
		
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
						'fee_type'			=> $this->input->post('fee_type'),
						'fee_amount'  		=> $fee_amount,
						'date_created'		=> date('Y-m-d H:i:s'),
						'monthsRequired'	=> $this->input->post('requiredmonths'),
						'type'	=> $this->input->post('type_option')
				);

		$this->db->where('id', $training_seminar_id);
		$this->db->update("emp_trainings_seminars_file_maintenance",$data);

		$this->db->where('seminar_training_id',$training_seminar_id);
		$this->db->delete('emp_trainings_seminars_dates_file_maintenance');
		

		$selected = $this->input->post('selected_dates');
		$res = substr_replace($selected, "", -1);
		$array =  explode('=', $res);

		
		$i=1;
		$total_hours =0;
		foreach($array as $a)
		{
			$date = $this->input->post('date_'.$a);
			$time_from = $this->input->post('time_from'.$a);
			$time_to = $this->input->post('time_to'.$a);
			$hours = $this->input->post('hour'.$a);
			
			$total_hours = $hours+$total_hours;
			if($i==1)
			{
				$this->db->where('id',$training_seminar_id);
				$this->db->update('emp_trainings_seminars_file_maintenance',array('datefrom'=>$date));
			}

			if($i==count($array))
			{
				$this->db->where('id',$training_seminar_id);
				$this->db->update('emp_trainings_seminars_file_maintenance',array('dateto'=>$date,'total_hours'=>$total_hours));
			}

			$dataa = array('seminar_training_id'=>$training_seminar_id,
							'date'				=>$date,
							'time_from'			=>$time_from,
							'time_to'			=>$time_to,
							'hours'				=>$hours);
			$this->db->insert('emp_trainings_seminars_dates_file_maintenance',$dataa);

			$i++;
		}
		
	}

	public function get_date_details_file_maintenance($datee,$seminarid)
	{
		$this->db->where(array('date'=>$datee,'seminar_training_id'=>$seminarid));
		$query = $this->db->get('emp_trainings_seminars_dates_file_maintenance',1);
		return $query->row();
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


	public function locationList($val)
	{
			$this->db->where('A.company_id',$val);
			$this->db->order_by('B.location_name','asc');
			$this->db->join("location B","B.location_id = A.location_id","left outer");
			$query = $this->db->get("company_location A");
			return $query->result();
	}

	public function get_all_trainingslist_filemaintenance($val,$company_id,$sub_type,$type)
	{
		$this->db->where(array('training_type'=>$val,'company_id'=>$company_id,'sub_type'=>$sub_type,'type'=>$type));
		$query = $this->db->get('emp_trainings_seminars_file_maintenance');
		return $query->result();
	}


	public function get_all_trainings_details($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('emp_trainings_seminars_file_maintenance');
		return $query->result();
	}

	public function get_all_trainings_details_dates($id)
	{
		$this->db->where('seminar_training_id',$id);
		$query = $this->db->get('emp_trainings_seminars_dates_file_maintenance');
		return $query->result();
	}

	public function get_fullname($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info');
		return $query->row('fullname');
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
						'purpose' 			=> $this->input->post('purpose'),
						'company_id'		=> $this->input->post('company'),
						'conducted_by_type' => $this->input->post('conducted_by_type'),
						'conducted_by'		=> $this->input->post('conducted_by'),
						'training_address'	=> $this->input->post('address'),
						'fee_type'			=> $this->input->post('fee_type'),
						'fee_amount'  		=> $fee_amount,
						'payment_status' 	=> $p_status,
						'date_created'		=> date('Y-m-d'),
						'file_name'			=> $picture,
						'monthsRequired'	=> $this->input->post('requiredmonths'),
						'adding_type'		=>	'admin',
						'added_by'			=> $this->session->userdata('employee_id')
				);

		$this->db->insert('emp_trainings_seminars',$data);

		$insertid = $this->db->insert_id();

		$selected = $this->input->post('selected_dates');
		$res = substr_replace($selected, "", -1);
		$array =  explode('=', $res);

		$i=1;
		$total_hours=0;
		foreach($array as $a)
		{
			$date = $this->input->post('date_'.$a);
			$time_from = $this->input->post('time_from'.$a);
			$time_to = $this->input->post('time_to'.$a);
			$hours = $this->input->post('hour'.$a);

			$total_hours = $hours+$total_hours;
			if($i==1)
			{
				$this->db->where('training_seminar_id',$insertid);
				$this->db->update('emp_trainings_seminars',array('datefrom'=>$date));
			}

			if($i==count($array))
			{
				$this->db->where('training_seminar_id',$insertid);
				$this->db->update('emp_trainings_seminars',array('dateto'=>$date,'total_hours'=>$total_hours));
			}

			$dataa = array('seminar_training_id'=>$insertid,
							'date'				=>$date,
							'time_from'			=>$time_from,
							'time_to'			=>$time_to,
							'hours'				=>$hours);
			$this->db->insert('emp_trainings_seminars_dates',$dataa);

			$i++;

		}
	
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
				$p_status = $this->input->post('payment_status');
			}

			$data = array(
							'employee_info_id' 	=> $em,
							'training_type' 	=> $this->input->post('training_type'),
							'sub_type' 			=> $this->input->post('sub_type'),
							'training_title'	=> $this->input->post('title'),
							'purpose' 			=> $this->input->post('purpose'),
							'company_id'		=> $this->input->post('company'),
							'conducted_by_type' => $this->input->post('conducted_by_type'),
							'conducted_by'		=>  $this->input->post('conducted_by'),
							'training_address'	=> $this->input->post('address'),
							'fee_type'			=> $this->input->post('fee_type'),
							'fee_amount'  		=> $fee_amount,
							'payment_status' 	=> $p_status,
							'date_created'		=> date('Y-m-d'),
							'file_name'			=> $picture,
							'monthsRequired'	=> $this->input->post('requiredmonths'),
							'adding_type'		=>	'admin',
							'added_by'			=> $this->session->userdata('employee_id')
					);

			$this->db->insert('emp_trainings_seminars',$data);

			$insertid = $this->db->insert_id();

			$selected = $this->input->post('selected_dates');
			$res = substr_replace($selected, "", -1);
			$array =  explode('=', $res);

			$i=1;
			$total_hours=0;
			foreach($array as $a)
			{
				$date = $this->input->post('date_'.$a);
				$time_from = $this->input->post('time_from'.$a);
				$time_to = $this->input->post('time_to'.$a);
				$hours = $this->input->post('hour'.$a);

				$total_hours = $hours+$total_hours;
				if($i==1)
				{
					$this->db->where('training_seminar_id',$insertid);
					$this->db->update('emp_trainings_seminars',array('datefrom'=>$date));
				}

				if($i==count($array))
				{
					$this->db->where('training_seminar_id',$insertid);
					$this->db->update('emp_trainings_seminars',array('dateto'=>$date,'total_hours'=>$total_hours));
				}

				$dataa = array('seminar_training_id'=>$insertid,
								'date'				=>$date,
								'time_from'			=>$time_from,
								'time_to'			=>$time_to,
								'hours'				=>$hours);
				$this->db->insert('emp_trainings_seminars_dates',$dataa);

				$i++;

			}
		}
		
	}


	//incoming trainings and seminars
	public function incoming_trainings_seminar()
	{
		$this->db->select('a.*,b.company_name');
		$this->db->join('company_info b','b.company_id=a.company_id');
		$query = $this->db->get('emp_trainings_seminars_incoming a');
		return $query->result();
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

			$total_hours=0;
			$i=1;
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

				
				$total_hours = $hours+$total_hours;
				if($i==1)
				{
					$this->db->where('training_seminar_id',$insertid);
					$this->db->update('emp_trainings_seminars_incoming',array('datefrom'=>$date));
				}

				if($i==count($array))
				{
					$this->db->where('training_seminar_id',$insertid);
					$this->db->update('emp_trainings_seminars_incoming',array('dateto'=>$date,'total_hours'=>$total_hours));
				}

				$i++;
			}
	}


	public function add_logtrails_incoming($action,$addedby,$finalemployee,$date,$id)
	{
		$this->db->insert('logfile_incoming_trainings_seminars',array('action'=>$action,'added_by'=>$addedby,'details'=>'id - '.$id,'employees'=>$finalemployee,'date'=>$date));
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

	public function get_incoming_trainingseminars_employees($id)
	{
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->where('a.training_id',$id);
		$query = $this->db->get('emp_trainings_seminar_incoming_employees a');
		return $query->result();
	}

	public function get_incoming_trainingseminars_date($id)
	{
		$this->db->where('seminar_training_id',$id);
		$query = $this->db->get('emp_trainings_seminars_dates_incoming');
		return $query->result();
	}

	public function get_date_details_incoming($datee,$seminarid)
	{

		$this->db->where(array('date'=>$datee,'seminar_training_id'=>$seminarid));
		$query = $this->db->get('emp_trainings_seminars_dates_incoming',1);
		return $query->row();
	}

	public function incomingtrainingseminar_save_modify($training_seminar_id)
	{
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
						'fee_type'			=> $this->input->post('fee_type'),
						'fee_amount'  		=> $fee_amount,
						'date_added'		=> date('Y-m-d H:i:s'),
						'monthsRequired'	=> $this->input->post('requiredmonths')
				);

		$this->db->where('training_seminar_id', $training_seminar_id);
		$this->db->update("emp_trainings_seminars_incoming",$data);

		$this->db->where('seminar_training_id',$training_seminar_id);
		$this->db->delete('emp_trainings_seminars_dates_incoming');
		

		$selected = $this->input->post('selected_dates');
		$res = substr_replace($selected, "", -1);
		$array =  explode('=', $res);

		
		$i=1;
		$total_hours =0;
		foreach($array as $a)
		{
			$date = $this->input->post('date_'.$a);
			$time_from = $this->input->post('time_from'.$a);
			$time_to = $this->input->post('time_to'.$a);
			$hours = $this->input->post('hour'.$a);
			
			$total_hours = $hours+$total_hours;
			if($i==1)
			{
				$this->db->where('training_seminar_id',$training_seminar_id);
				$this->db->update('emp_trainings_seminars_incoming',array('datefrom'=>$date));
			}

			if($i==count($array))
			{
				$this->db->where('training_seminar_id',$training_seminar_id);
				$this->db->update('emp_trainings_seminars_incoming',array('dateto'=>$date,'total_hours'=>$total_hours));
			}

			
			$i++;
		}

	}

}
