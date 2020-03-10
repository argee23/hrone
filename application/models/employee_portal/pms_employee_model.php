<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Pms_employee_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}



	public function getMyRatees(){

		$this->db->select('B.*,A.name as fullname,A.position_name,A.date_employed');
		$this->db->where('B.sc_creator_employee_id', $this->session->userdata('employee_id'));
		$this->db->join('masterlist A', 'A.employee_id = B.employee_id');
		$query = $this->db->get('pms_scorecard_creator_ratee B');

		return $query->result();
	}

	public function get_emp_ratee($employee_id){

		$this->db->select('A.employee_id,A.name as fullname,A.position as position_id,A.position_name,A.date_employed,A.division_name,A.dept_name,A.section_name,A.classification_name,A.location_name,A.subsection_name');
		$this->db->where("A.employee_id", $employee_id);
		$query = $this->db->get('masterlist A');
		
		return $query->row();
	}

	public function get_general_forms(){
		$this->db->where('InActive', 0);
		$this->db->order_by('part_number','ASC');
		$query = $this->db->get('pms_form_parts');

		return $query->result();
	}


	public function GenFormFormat($form_id){
		$this->db->where('id', $form_id);
		$query = $this->db->get('pms_form_parts');

		return $query->row();		
	}
	public function GenFormCriteria($form_id,$position_id){
	
		$query = $this->db->query("SELECT * FROM pms_position_areas where (position_id='general' OR position_id='".$position_id."' ) AND form_part_id='".$form_id."' ");

		return $query->result();		
	}
	public function FormFormatScoring($form_id){
		$this->db->where('form_part_id', $form_id);
		$query = $this->db->get('pms_form_parts_score_criteria');

		return $query->result();		
	}

	public function val_appraisal_period($employee_id){
	$query = $this->db->query("SELECT * FROM pms_gel_employee_main_appraisal where employee_id='".$employee_id."' AND status!='approved'");

		return $query->row();		
	}
	public function GetAppraisalPeriod($employee_id){
		$query = $this->db->query("SELECT * FROM pms_gel_employee_main_appraisal where employee_id='".$employee_id."'");
		return $query->result();		
	}

	public function saveAppraisalPeriod($app_data){
		$this->db->insert('pms_gel_employee_main_appraisal',$app_data);
	}




}


?>
