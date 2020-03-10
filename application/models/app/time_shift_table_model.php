<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Time_shift_table_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function validate_edit_shift_regular($shift,$company_id,$classification_id,$id){
		$query = $this->db->query("SELECT * FROM working_schedule_ref_complete WHERE CONCAT(TRIM(time_in),TRIM(time_out))='".$shift."' and company_id ='".$company_id."' and classification = '".$classification_id."' and id!='".$id."' and InActive= 0 ");
		if($query->num_rows() ==1){
			return true;
		}else{
			return false;
		}	

	}
	public function validate_edit_shift_rd_hol($shift,$company_id,$classification_id,$id){
		$query = $this->db->query("SELECT * FROM working_schedule_ref_restday_holiday WHERE CONCAT(TRIM(time_in),TRIM(time_out))='".$shift."' and company_id ='".$company_id."' and classification = '".$classification_id."' and id!='".$id."' and InActive= 0 ");
		if($query->num_rows() ==1){
			return true;
		}else{
			return false;
		}	

	}
	public function validate_edit_shift_hd($shift,$company_id,$classification_id,$id){
		$query = $this->db->query("SELECT * FROM working_schedule_ref_half WHERE CONCAT(TRIM(time_in),TRIM(time_out))='".$shift."' and company_id ='".$company_id."' and classification = '".$classification_id."' and id!='".$id."' and InActive= 0 ");
		if($query->num_rows() ==1){
			return true;
		}else{
			return false;
		}	

	}

	public function validate_add_shift_regular($shift,$company_id,$classification_id){
		$query = $this->db->query("SELECT * FROM working_schedule_ref_complete WHERE CONCAT(TRIM(time_in),TRIM(time_out))='".$shift."' and company_id ='".$company_id."' and classification = '".$classification_id."' and InActive= 0 ");
		if($query->num_rows() ==1){
			return true;
		}else{
			return false;
		}	

	}
	public function validate_add_shift_rd_hol($shift,$company_id,$classification_id){
		$query = $this->db->query("SELECT * FROM working_schedule_ref_restday_holiday WHERE CONCAT(TRIM(time_in),TRIM(time_out))='".$shift."' and company_id ='".$company_id."' and classification = '".$classification_id."' and InActive= 0 ");
		if($query->num_rows() ==1){
			return true;
		}else{
			return false;
		}	

	}
	public function validate_add_shift_wshd($shift,$company_id,$classification_id){
		
		$query = $this->db->query("SELECT * FROM working_schedule_ref_half WHERE CONCAT(TRIM(time_in),TRIM(time_out))='".$shift."' and company_id ='".$company_id."' and classification = '".$classification_id."' and InActive= 0 ");
		if($query->num_rows() ==1){
			return true;
		}else{
			return false;
		}	
	}

	public function view_working_sched_complete($company_id,$cl_id){
		$this->db->where(array(
			'company_id'			=>		$company_id,
			'classification'	=>		$cl_id,
			'InActive'			=>		0
		));	
		$this->db->order_by('time_in','ASC');
		$query = $this->db->get("working_schedule_ref_complete");

		return $query->result();	
	}
	public function view_working_sched_restday_holiday($company_id,$cl_id){
		$this->db->where(array(
			'company_id'	=>		$company_id,
			'classification'	=>		$cl_id,
			'InActive'			=>		0
		));	
		$this->db->order_by('time_in','ASC');
		$query = $this->db->get("working_schedule_ref_restday_holiday");

		return $query->result();	
	}
	public function view_working_sched_half($company_id,$cl_id){
		$this->db->where(array(
			'company_id'			=>		$company_id,
			'classification'	=>		$cl_id,
			'InActive'			=>		0
		));	
		$this->db->order_by('time_in','ASC');
		$query = $this->db->get("working_schedule_ref_half");

		return $query->result();	
	}
	public function get_company($company_id){
		$this->db->where(array(
			'company_id'	=>		$company_id,
			'InActive'			=>		0
		));	
		$query = $this->db->get("company_info");
		return $query->row();
	}
	public function get_comp_locations($company_id,$loc_id){
		$this->db->where(array(
			'location_id'	=>		$loc_id,
			'company_id'	=>		$company_id
		));	
		$query = $this->db->get("company_location");
		return $query->row();
	}
	public function get_location($key_location){
		$this->db->where(array(
			'location_id'	=>		$key_location,
			'InActive'			=>		0
		));	
		$query = $this->db->get("location");
		return $query->row();
	}
	//
	public function get_working_sched_complete($classification){
		$this->db->where(array(
			'classification'	=>		$classification,
			'InActive'			=>		0
		));	
		$this->db->order_by('time_in','ASC');
		$query = $this->db->get("working_schedule_ref_complete");

		return $query->result();	
	}
	public function get_working_sched_restday_holiday($classification){
		$this->db->where(array(
			'classification'	=>		$classification,
			'InActive'			=>		0
		));	
		$this->db->order_by('time_in','ASC');
		$query = $this->db->get("working_schedule_ref_restday_holiday");

		return $query->result();	
	}
	public function get_working_sched_half($classification){
		$this->db->where(array(
			'classification'	=>		$classification,
			'InActive'			=>		0
		));	
		$this->db->order_by('time_in','ASC');
		$query = $this->db->get("working_schedule_ref_half");

		return $query->result();	
	}
	public function get_classification($classification){
		$this->db->where(array(
			'classification_id'	=>		$classification,
			'InActive'			=>		0
		));	
		$query = $this->db->get("classification");
		return $query->row();
	}
	//get_work_sched_rd_hol: get picked working schedule restday holiday
	public function get_work_sched_rd_hol($id){
		$this->db->where(array(
			'id'				=>		$id,
			'InActive'			=>		0
		));	
		$query = $this->db->get("working_schedule_ref_restday_holiday");
		return $query->row();
	}

	//get_work_sched_comp: get picked working schedule complete/regular
	public function get_work_sched_comp($id){
		$this->db->where(array(
			'id'				=>		$id,
			'InActive'			=>		0
		));	
		$query = $this->db->get("working_schedule_ref_complete");
		return $query->row();
	}
	//get_work_sched_half: get picked working schedule half day
	public function get_work_sched_half($id){
		$this->db->where(array(
			'id'				=>		$id,
			'InActive'			=>		0
		));	
		$query = $this->db->get("working_schedule_ref_half");
		return $query->row();
	}

	// save_add_wsc: save add working schedule complete (wholeday)
	public function save_add_wsc(){
		$now=date("Y-m-d h:i:sa");
		foreach ($this->input->post('classification_id') as $key => $value)
		{			
			//save access level
			$t_in=$this->input->post('time_in_hr').":".$this->input->post('time_in_minute');
			$t_out=$this->input->post('time_out_hr').":".$this->input->post('time_out_minute');

		$this->data = array(
			'classification'		=> $value,
			'time_in'				=> $t_in,
			'time_out'				=> $t_out,
			'lunch_break'			=> $this->input->post('lunch_break'),
			'break_1'				=> $this->input->post('break_1'),
			'break_2'				=> $this->input->post('break_2'),
			'no_of_hours'			=> $this->input->post('no_of_hours'),
			'description'			=> $this->input->post('description'),
			'InActive'				=> 0,
			'date_created'			=> $now,
			'company_id'				=> $this->input->post('company_id')
		);	
		$this->db->insert('working_schedule_ref_complete',$this->data);

			$fullshift=$t_in." to ".$t_out;

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			$this->system_audit_trail('Time','Shift Table','logfile_time_shift_table','add regular shift: '.$fullshift.' to company id/classification: '.$this->input->post('company_id').'/'.$value.'','INSERT',$fullshift);

		}	
	}

	public function system_audit_trail($module,$module_dropdown,$audit_table,$details,$event,$value){
			$employee_id=$this->session->userdata('employee_id');
		
		$this->data = array(
				'employee_id'			=>		$employee_id,
				'module'				=>		$module,
				'module_dropdown'		=>		$module_dropdown,
				'event'					=>		$event,
				'event_details'			=>		$details,
				'value'			=>		$value,
				'ipaddress'		=>		$this->input->ip_address(),
				'date_time'		=>		date("Y-m-d h:i:s a")
		);
		$this->db->insert($audit_table,$this->data);
	}



	// save_add_wsc: save add working schedule rest day /holiday
	public function save_add_ws_rd_hol(){
		$now=date("Y-m-d h:i:sa");		
		foreach ($this->input->post('classification_id') as $key => $value)
		{		
			$t_in=$this->input->post('time_in_hr').":".$this->input->post('time_in_minute');
			$t_out=$this->input->post('time_out_hr').":".$this->input->post('time_out_minute');

			$this->data = array(
				'classification'		=> $value,
				'time_in'				=> $t_in,
				'time_out'				=> $t_out,
				'lunch_break'			=> $this->input->post('lunch_break'),
				'break_1'				=> $this->input->post('break_1'),
				'break_2'				=> $this->input->post('break_2'),
				'no_of_hours'			=> $this->input->post('no_of_hours'),
				'description'			=> $this->input->post('description'),
				'InActive'				=> 0,
				'date_created'			=> $now,				
				'company_id'				=> $this->input->post('company_id')
			);	
			$this->db->insert('working_schedule_ref_restday_holiday',$this->data);

			$fullshift=$t_in." to ".$t_out;

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			$this->system_audit_trail('Time','Shift Table','logfile_time_shift_table','add rd/holiday shift: '.$fullshift.' to company id/classification: '.$this->input->post('company_id').'/'.$value.'','INSERT',$fullshift);


		}
	}
	// save_add_wshd: save add working schedule half day (half day)
	public function save_add_wshd(){
		$now=date("Y-m-d h:i:sa");		
		foreach ($this->input->post('classification_id') as $key => $value)
		{			

			$t_in=$this->input->post('time_in_hr').":".$this->input->post('time_in_minute');
			$t_out=$this->input->post('time_out_hr').":".$this->input->post('time_out_minute');

			$this->data = array(
				'classification'		=> $value,
				'time_in'				=> $t_in,
				'time_out'				=> $t_out,
				'break_1'				=> $this->input->post('break_1'),
				'no_of_hours'			=> $this->input->post('no_of_hours'),
				'description'			=> $this->input->post('description'),
				'InActive'				=> 0,
				'date_created'			=> $now,					
				'company_id'				=> $this->input->post('company_id')
			);	
			$this->db->insert('working_schedule_ref_half',$this->data);


			$fullshift=$t_in." to ".$t_out;

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			$this->system_audit_trail('Time','Shift Table','logfile_time_shift_table','add halfday shift: '.$fullshift.' to company id/classification: '.$this->input->post('company_id').'/'.$value.'','INSERT',$fullshift);



		}
	}

	public function save_edit_wsc($id){

			$t_in=$this->input->post('time_in_hr').":".$this->input->post('time_in_minute');
			$t_out=$this->input->post('time_out_hr').":".$this->input->post('time_out_minute');

		$this->data = array(
			'time_in'				=> $t_in,
			'time_out'				=> $t_out,
			'lunch_break'			=> $this->input->post('lunch_break'),
			'break_1'				=> $this->input->post('break_1'),
			'break_2'				=> $this->input->post('break_2'),
			'no_of_hours'			=> $this->input->post('no_of_hours'),
			'description'			=> $this->input->post('description')
		);	
		$this->db->where('id',$id);
		$this->db->update('working_schedule_ref_complete',$this->data);
	}
	public function save_edit_ws_rd_hol($id){
			$t_in=$this->input->post('time_in_hr').":".$this->input->post('time_in_minute');
			$t_out=$this->input->post('time_out_hr').":".$this->input->post('time_out_minute');

		$this->data = array(
			'time_in'				=> $t_in,
			'time_out'				=> $t_out,
			'lunch_break'			=> $this->input->post('lunch_break'),
			'break_1'				=> $this->input->post('break_1'),
			'break_2'				=> $this->input->post('break_2'),
			'no_of_hours'			=> $this->input->post('no_of_hours'),
			'description'			=> $this->input->post('description')
		);	
		$this->db->where('id',$id);
		$this->db->update('working_schedule_ref_restday_holiday',$this->data);
	}
	public function save_edit_wshd($id){
			$t_in=$this->input->post('time_in_hr').":".$this->input->post('time_in_minute');
			$t_out=$this->input->post('time_out_hr').":".$this->input->post('time_out_minute');


		$this->data = array(

			'time_in'				=> $t_in,
			'time_out'				=> $t_out,
			'break_1'				=> $this->input->post('break_1'),
			'no_of_hours'			=> $this->input->post('no_of_hours'),
			'description'			=> $this->input->post('description')
		);	
		$this->db->where('id',$id);
		$this->db->update('working_schedule_ref_half',$this->data);
	}



	public function validate_cf_shift($shift,$company_id,$classification_id){
		$query = $this->db->query("SELECT * FROM working_schedule_ref_controlled_flexi WHERE CONCAT(TRIM(time_in),TRIM(time_out))='".$shift."' and company_id ='".$company_id."' and classification = '".$classification_id."' and InActive= 0 ");
		if($query->num_rows() ==1){
			return true;
		}else{
			return false;
		}	

	}
	public function save_add_cf(){
		$now=date("Y-m-d h:i:sa");
		foreach ($this->input->post('classification_id') as $key => $value)
		{			
			//save access level
			$t_in=$this->input->post('time_in_hr').":".$this->input->post('time_in_minute');
			$t_out=$this->input->post('time_out_hr').":".$this->input->post('time_out_minute');

		$this->data = array(
			'classification'		=> $value,
			'time_in'				=> $t_in,
			'time_out'				=> $t_out,
			'lunch_break'			=> $this->input->post('lunch_break'),
			'break_1'				=> $this->input->post('break_1'),
			'break_2'				=> $this->input->post('break_2'),
			'no_of_hours'			=> $this->input->post('no_of_hours'),
			'description'			=> $this->input->post('description'),
			'InActive'				=> 0,
			'date_created'			=> $now,
			'company_id'				=> $this->input->post('company_id')
		);	
		$this->db->insert('working_schedule_ref_controlled_flexi',$this->data);

			$fullshift=$t_in." to ".$t_out;

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			$this->system_audit_trail('Time','Shift Table','logfile_time_shift_table','add controlled flexi shift: '.$fullshift.' to company id/classification: '.$this->input->post('company_id').'/'.$value.'','INSERT',$fullshift);

		}	
	}

	public function view_working_sched_controlled_flexi($company_id,$cl_id){
		$this->db->where(array(
			'company_id'	=>		$company_id,
			'classification'	=>		$cl_id,
			'InActive'			=>		0
		));	
		$this->db->order_by('time_in','ASC');
		$query = $this->db->get("working_schedule_ref_controlled_flexi");

		return $query->result();	
	}
	public function get_work_sched_controlled_flexi($id){
		$this->db->where(array(
			'id'				=>		$id,
			'InActive'			=>		0
		));	
		$query = $this->db->get("working_schedule_ref_controlled_flexi");
		return $query->row();
	}



	public function validate_edit_controlled($shift,$company_id,$classification_id,$id){
		$query = $this->db->query("SELECT * FROM working_schedule_ref_controlled_flexi WHERE CONCAT(TRIM(time_in),TRIM(time_out))='".$shift."' and company_id ='".$company_id."' and classification = '".$classification_id."' and id!='".$id."' and InActive= 0 ");
		if($query->num_rows() ==1){
			return true;
		}else{
			return false;
		}	

	}
	public function save_edit_contFlexi($id){
			$t_in=$this->input->post('time_in_hr').":".$this->input->post('time_in_minute');
			$t_out=$this->input->post('time_out_hr').":".$this->input->post('time_out_minute');

		$this->data = array(
			'time_in'				=> $t_in,
			'time_out'				=> $t_out,
			'lunch_break'			=> $this->input->post('lunch_break'),
			'break_1'				=> $this->input->post('break_1'),
			'break_2'				=> $this->input->post('break_2'),
			'no_of_hours'			=> $this->input->post('no_of_hours'),
			'description'			=> $this->input->post('description')
		);	
		$this->db->where('id',$id);
		$this->db->update('working_schedule_ref_controlled_flexi',$this->data);
	}



	
}