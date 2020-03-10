<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Holiday_list_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	public function string_val_of_type($type){
		$this->db->select("*",false);
		$this->db->where(array(
			'code'	=>		$type,
			'cCode'	=>		'holiday_type'
		));
		$query = $this->db->get("system_parameters");
		return $query->result();
	}
	public function check_last_id_of_holiday(){
		//$query = $this->db->query("SELECT * FROM holiday_list ORDER BY hol_id DESC LIMIT 1");	
		$query = $this->db->query("SELECT AUTO_INCREMENT
FROM information_schema.tables
WHERE table_name = 'holiday_list'
AND table_schema = DATABASE();");	
		return $query->row();//result
	}
	//== for listing
	public function getAll(){
		$this->db->select("
			A.year,
			A.hol_id,
			B.location_id,
			B.location_name,
			B.InActive as location_InActive, 
			A.InActive as holiday_InActive, 
			A.holiday,
			A.month,
			A.day,
			A.type


			",false);
		$this->db->order_by('A.hol_id','asc');
		$this->db->join("location B","B.location_id = A.hol_id","left outer");
		$query = $this->db->get("holiday_list A");
		return $query->result();
	}

	public function getThisYearAll(){
		$this->db->select("
			A.year,
			A.hol_id,
			B.location_id,
			B.location_name,
			B.InActive as location_InActive, 
			A.InActive as holiday_InActive, 
			A.holiday,
			A.month,
			A.day,
			A.type


			",false);
		$this->db->order_by('A.month asc, A.day asc');
		$this->db->where(array(
			'A.year'	=> 	date('Y'),
			'A.InActive'	=>	0
		));
		$this->db->join("location B","B.location_id = A.hol_id","left outer");
		$query = $this->db->get("holiday_list A");
		return $query->result();
	}

	public function getHolidayChoice($info){
		$this->db->select("
			A.year,
			A.hol_id,
			B.location_id,
			B.location_name,
			B.InActive as location_InActive, 
			A.InActive as holiday_InActive, 
			A.holiday,
			A.month,
			A.day,
			A.type
			",false);

		$this->db->order_by('A.month asc, A.day asc');

		if ($info['status'] == 0){

			if ($info['year'] == 0 && $info['month'] == 0){
				$this->db->where(array(
					'A.year'		=> date('Y'),
					'A.Inactive'	=> 0
				));
			}

			else if ($info['year'] != 0 && $info['month'] == 0){
				$this->db->where(array(
					'A.year'		=> 	$info['year'],
					'A.InActive'	=>	0
				));
			}

			else if ($info['year'] == 0 && $info['month'] != 0){
				$this->db->where(array(
					'A.month'		=> $info['month'],
					'A.InActive'	=> 0
				));
			}

			else if ($info['year'] != 0 && $info['month'] != 0){
				$this->db->where(array(
					'A.year'		=> 	$info['year'],
					'A.month'		=>	$info['month'],
					'A.InActive'	=>	0
				));
			}
		}
		else if($info['status'] == 1){

			if ($info['year'] == 0 && $info['month'] == 0){
				$this->db->where(array(
					'A.year'		=> date('Y'),
					'A.Inactive'	=> 1
				));
			}

			else if ($info['year'] != 0 && $info['month'] == 0){
				$this->db->where(array(
					'A.year'		=> 	$info['year'],
					'A.InActive'	=>	1
				));
			}

			else if ($info['year'] == 0 && $info['month'] != 0){
				$this->db->where(array(
					'A.month'		=> $info['month'],
					'A.InActive'	=> 1
				));
			}

			else if ($info['year'] != 0 && $info['month'] != 0){
				$this->db->where(array(
					'A.year'		=> 	$info['year'],
					'A.month'		=>	$info['month'],
					'A.InActive'	=>	1
				));
			}

		}

		$this->db->join("location B","B.location_id = A.hol_id","left outer");
		$query = $this->db->get("holiday_list A");
		return $query->result();
	}

	public function getYears(){
		$this->db->distinct('year');
		$this->db->select('year');
		$query = $this->db->get('holiday_list');
		return $query->result();
	}
	
	// public function getBranches(){

	// 	$company_name=$this->session->userdata('company_id');

	// 	$this->db->select("*",false);
	// 	$this->db->where(array(
	// 		'A.InActive'	=>		0,
	// 		'A.main_company_id'	=>	$company_name		
	// 	));
	// 	$this->db->join("location B","B.location_id = A.branch","left outer");
	// 	$query = $this->db->get("company_info A");
	// 	return $query->result();
	// }
	public function get_holiday_type_string($type){

		$this->db->select("*",false);
		$this->db->where(array(
			'cCode'	=>		'holiday_type',
			'code'	=>	$type		
		));
		$query = $this->db->get("system_parameters");
		return $query->result();
	}
	public function get_holiday_string($value){

		$this->db->select("*",false);
		$this->db->where(array(
			'cCode'		=>	'holiday',
			'param_id'	=>		$value
		));
		$query = $this->db->get("system_parameters");
		return $query->result();
	}
	//==
	public function check_if_holiday_is_applicable($location_id,$hol_id){
		//$company_id=$this->session->userdata('company_id');
		$query = $this->db->query("select * from holiday_list_location where location= '".$location_id ."' and hol_id ='".$hol_id."' ");

		return $query->result();
	}
	public function check_if_holiday_iscomp_applicable($company_id,$hol_id){
		//$company_id=$this->session->userdata('company_id');
		$query = $this->db->query("select * from holiday_list_company where company_id= '".$company_id ."' and hol_id ='".$hol_id."' ");
		return $query->row();
	}
	// public function getRole_AccessLevel($comp_id){
	// 	$this->db->where(array(
	// 		'location'	=>		$comp_id

	// 	));
	// 	$query = $this->db->get("holiday_list_location");
	// 	return $query->row();
	// }
	//==get month day and type code
	public function get_date($holiday_id){

		$this->db->where('param_id',$holiday_id);
		$query = $this->db->get('system_parameters');
		return $query->result();
	}

	//== for disabling
	public function delete($id){
		$this->db->where(array(
			'hol_id'		=>	$id
		));		
		$query = $this->db->get("holiday_list");
		return $query->row();
	}
	public function deactivate($id){
		$this->db->where('hol_id',$id);
		$this->data = array('InActive'=>1);
		$this->db->update("holiday_list",$this->data);	
	}
	public function activate($id){
		$this->db->where('hol_id',$id);
		$this->data = array('InActive'=>0);
		$this->db->update("holiday_list",$this->data);	
	}
	//== for editing
	public function getHoliday($id){ 

		$this->db->where('hol_id',$id);
		$query = $this->db->get('holiday_list');
		return $query->row();		
	}	
	public function validate_edit_holiday(){
		$this->db->select("holiday,InActive,hol_id");
		$this->db->where(array(
			'hol_id !='	=>		$this->input->post('holiday_id'),
			'holiday'		=>		$this->input->post('holiday'),
			'InActive'		=>		0
		));	
		$query = $this->db->get("holiday_list");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}
	public function validate_edit_date(){
		$post_hol_id=$this->input->post('holiday_id');
		$date=$this->input->post('month').$this->input->post('day');
		$query = $this->db->query("SELECT * FROM holiday_list WHERE CONCAT(TRIM(month),TRIM(day))='".$date."' and hol_id != '".$post_hol_id."' and InActive= 0 ");
		if($query->num_rows() ==1){
			return true;
		}else{
			return false;
		}	
	}
	//== for saving update
	public function modify_holiday($id){
		
		$date = date('Y-m-d H:i:s');

		$this->data = array(
			'holiday'		=> ucwords($this->input->post('holiday')),
			'year'	=>		$this->input->post('true_year'),
			'log_date'		=>		$date,
			'month'		=> $this->input->post('month'),
			'day'		=> $this->input->post('day'),
			'type'		=> $this->input->post('type'),
			'InActive'		=> 0
		);	
		$this->db->where('hol_id',$id);
		$this->db->update('holiday_list',$this->data);
	}
	//== for adding

	public function CheckedAllLocations($resave_location){
		$query = $this->db->insert("holiday_list_location",$resave_location);
	}

	public function save(){ 
	$date = date('Y-m-d H:i:s');
		$this->data = array(
			'holiday'		=>		ucwords($this->input->post('holiday')),
			'year'		=>		$this->input->post('true_year'),
			'month'		=>		$this->input->post('true_month'),
			'day'		=>		$this->input->post('day'),
			'type'		=>		$this->input->post('true_type'),
			'log_date'		=>		$date,
			'InActive'		=>		0
		);			
		$query = $this->db->insert("holiday_list",$this->data);
		if($this->db->affected_rows() == 1){
			return true;
		}else{
			return false;
		}
	}	

	public function validate_date(){
		$year_value=$this->input->post('true_year');
		$date=$this->input->post('true_month').$this->input->post('day').$year_value;
		$query = $this->db->query("SELECT * FROM holiday_list WHERE CONCAT(TRIM(month),TRIM(day),TRIM(year))='".$date."' and InActive= 0 ");
		if($query->num_rows() ==1){
			return true;
		}else{
			return false;
		}	
	}
	public function validate_add_holiday(){
		$year_value=$this->input->post('true_year');
		$this->db->select("*");
		$this->db->where(array(
			'holiday'		=>		$this->input->post('holiday'),
			'year'		=>		$this->input->post('year_value'),
			'InActive'		=>		0
		));	
		$query = $this->db->get("holiday_list");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}
	

}