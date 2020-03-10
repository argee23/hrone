<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Report_pms_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}
	public function get_approver($eid){
		$this->db->select('*');
		$this->db->from('employee_info');
		$this->db->where('employee_id',$eid);
		
		$res = $this->db->get();
		return $res->row();

	}
	public function get_appraisal_schedule(){
		$this->db->select('*');
		$this->db->from('pms_scorecard_format_employeeportal');
		$this->db->group_by('appraisal_period_type_dates');
		$query = $this->db->get();
		return $query->result();
	}
		public function recommendation(){
	
		$this->db->select('*,a.employee_id as employee_id,d.position as pos,b.position as pos4,j.position as c_position,j.department as c_department','h.from as contract_renewal_from','h.to as contract_renewal_to');
		$this->db->from('pms_recommendation_employeeportal a');
			$this->db->join('pms_demotion_employeeportal b', 'a.demotion = b.ref','left');
			$this->db->join('pms_regularization_employeeportal c', 'a.regularization = c.ref','left');
				$this->db->join('pms_promotion_employeeportal d', 'a.promotion = d.ref','left');
			$this->db->join('pms_salary_increase_employeeportal e', 'a.salary_increase = e.ref','left');
			$this->db->join('pms_retain_in_existing_position_employeeportal f', 'a.retain_in_existing_position = f.ref','left');
			$this->db->join('pms_end_of_contract_employeeportal g', 'a.end_of_contract = g.ref','left');
			$this->db->join('pms_contract_renewal_employeeportal h', 'a.contract_renewal = h.ref','left');
			$this->db->join('pms_extend_probationary_period_employeeportal i', 'a.extend_probationary_period = i.ref','left');
			$this->db->join('pms_for_lateral_transfer_employeeportal j', 'a.for_lateral_transfer = j.ref','left');
			$this->db->join('pms_scorecard_format_employeeportal k', 'a.doc_no = k.doc_no','left');
			if(!empty($this->input->post('DataTable')) AND $this->input->post('DataTable') != 'all'){
			$this->db->where('k.appraisal_period_type_dates',$this->input->post('DataTable'));
		}
			if(!empty($this->input->post('c')) AND $this->input->post('c') != 'all'){
			$this->db->where('k.company_id',$this->input->post('c'))
;		}


		$query = $this->db->get();
		return $query->result();
	}
function getsearch($name)
{   
    $select = $this->db->query("SELECT * FROM employee_info WHERE fullname LIKE '%".$name."%' ");
    return $select->result_array();
}
	public function get_all(){
		$this->db->select('*,a.status as status,f.score as score');
		$this->db->from('pms_approval_employeeportal a');
		$this->db->join('pms_scorecard_format_employeeportal b', 'a.doc_no = b.doc_no');
		$this->db->join('employee_info c', 'b.employee_id = c.employee_id');
		$this->db->join('pms_totalfinalscore_employeeportal d', 'a.doc_no = d.doc_no');
		$this->db->join('pms_agree_employeeportal e', 'a.doc_no = e.doc_no');
		$this->db->join('pms_grading_table_from_admin_employeeportal f', 'd.score = f.ranking');
		$this->db->join('department g', 'c.department = g.department_id');
		$this->db->join('classification h', 'c.classification = h.classification_id');
		$this->db->join('section i', 'c.section = i.section_id');
		$this->db->join('location j', 'c.location = j.location_id');
				$this->db->join('position k', 'c.position = k.position_id');
		if(!empty($this->input->post('DataTable')) AND $this->input->post('DataTable') != 'all'){
			$this->db->where('b.appraisal_period_type_dates',$this->input->post('DataTable'));
		}
		if(!empty($this->input->post('DataTable')) AND $this->input->post('DataTable') != 'all'){
			$this->db->where('b.appraisal_period_type_dates',$this->input->post('DataTable'));
		}
		if(!empty($this->input->post('from'))){
			$this->db->where('b.appraisal_period_type_dates >=',$this->input->post('from'));
			$this->db->where('b.appraisal_period_type_dates <=',$this->input->post('to'));
		}


		
		if(!empty($this->input->post('qwe'))){
			if($this->input->post('department')){
			      $this->db->where('g.department_id',$this->input->post('department'));
			}elseif($this->input->post('qwe') == 'classification'){
				  $this->db->where('h.classification_id',$this->input->post('qwe'));
			}elseif($this->input->post('qwe')  == 'position'){
				  $this->db->where('k.position_id',$this->input->post('qwe'));
			}elseif($this->input->post('qwe') == 'location'){
				  $this->db->where('j.location',$this->input->post('qwe'));
			}elseif($this->input->post('qwe') == 'section'){
				  $this->db->where('i.section',$this->input->post('qwe'));
			}

		}
		if($this->input->post('checked')){
			$this->db->group_by('b.employee_id');
		}else{
		$this->db->group_by('a.doc_no');
	}
		
		$res = $this->db->get();
		return $res->result();
	}
	public function get_all_approval(){
		$this->db->select('*');
		$this->db->from('pms_approval_employeeportal a');
		$this->db->join('pms_scorecard_format_employeeportal b', 'a.doc_no = b.doc_no');
		$this->db->join('employee_info c', 'b.employee_id = c.employee_id');
		$this->db->group_by('a.doc_no');
		$res = $this->db->get();
		return $res->result();
	}
	public function get_approval_pending(){
		
		$this->db->select('*');
		$this->db->from('pms_approval_employeeportal a');
		$this->db->join('pms_scorecard_format_employeeportal b', 'a.doc_no = b.doc_no');
		$this->db->join('employee_info c', 'b.employee_id = c.employee_id');
		$this->db->where('a.status','pending');
		$this->db->group_by('a.doc_no');
		$res = $this->db->get();
		return $res->result();

		
	}
		public function get_classification($id){


		$this->db->select('*');	
		$this->db->from('classification');
		$this->db->where('company_id',$id);
		$query = $this->db->get();
		return $query->result();
	}
public function get_section($id){


		$this->db->select('*');	
		$this->db->from('section a');
		$this->db->join('department b', 'a.department_id = b.department_id');
		$this->db->where('b.company_id',$id);
		$query = $this->db->get();
		return $query->result();
	}
public function get_position($id){


		$this->db->select('*');	
		$this->db->from('position');
		$this->db->where('company_id',$id);
		$query = $this->db->get();
		return $query->result();
	}
		public function get_location($id){


		
		$this->db->select('*');
		$this->db->from('location a');
		$this->db->join('company_location b', 'a.location_id = b.location_id');
		$this->db->where('b.company_id',$id);
		$query = $this->db->get();
		return $query->result();
	}
		public function get_department($id){


		$this->db->select('*');	
		$this->db->from('department');
		$this->db->where('company_id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	public function get_approval_approved($id){
		$this->db->select_max('appro_level');
		$this->db->from('pms_approval_employeeportal');
		$this->db->where('doc_no',$id);
		$q = $this->db->get();
		$eval = $q->row();
		
		
		
		$this->db->select('*');
		$this->db->from('pms_approval_employeeportal a');
		$this->db->join('pms_scorecard_format_employeeportal b', 'a.doc_no = b.doc_no');
		$this->db->join('employee_info c', 'b.employee_id = c.employee_id');
		$this->db->where('a.status','done');
		$this->db->where('appro_level',$eval->appro_level);
		$this->db->group_by('a.doc_no');
		$res = $this->db->get();
		return $res->result();

		
	}
	public function get_evaluator($eid){
		$this->db->select('*');
		$this->db->from('employee_info');
		$this->db->where('employee_id',$eid);
		
		$res = $this->db->get();
		return $res->row();

	}
	public function get_all_evaluation(){
		$this->db->select('*');
		$this->db->from('pms_evaluation_employeeportal a');
		$this->db->join('pms_scorecard_format_employeeportal b', 'a.doc_no = b.doc_no');
		$this->db->join('employee_info c', 'b.employee_id = c.employee_id');
		$this->db->group_by('a.doc_no');
		$res = $this->db->get();
		return $res->result();
	}
	public function get_evaluation_pending(){
		
		$this->db->select('*');
		$this->db->from('pms_evaluation_employeeportal a');
		$this->db->join('pms_scorecard_format_employeeportal b', 'a.doc_no = b.doc_no');
		$this->db->join('employee_info c', 'b.employee_id = c.employee_id');
		$this->db->where('a.status','pending');
		$this->db->group_by('a.doc_no');
		$res = $this->db->get();
		return $res->result();

		
	}
	public function get_evaluation_evaluated($id){
		$this->db->select_max('eval_level');
		$this->db->from('pms_evaluation_employeeportal');
		$this->db->where('doc_no',$id);
		$q = $this->db->get();
		$eval = $q->row();
		
		
		
		$this->db->select('*');
		$this->db->from('pms_evaluation_employeeportal a');
		$this->db->join('pms_scorecard_format_employeeportal b', 'a.doc_no = b.doc_no');
		$this->db->join('employee_info c', 'b.employee_id = c.employee_id');
		$this->db->where('a.status','done');
		$this->db->where('eval_level',$eval->eval_level);
		$this->db->group_by('a.doc_no');
		$res = $this->db->get();
		return $res->result();

		
	}
	public function GetGeneralForms(){
		$query=$this->db->query("SELECT * FROM pms_appraisal_form group by form_title  ORDER by form_part ASC ");	//DESC	
		return $query->result();
	}

	public function GetScoreRate($form_part_id){
		$query=$this->db->query("SELECT * FROM pms_grading_table WHERE  fid='".$form_part_id."' ORDER by score ASC");		
		return $query->result();
	}
	public function GetScoreCriteriaGeneral($form_part_id){

		$query=$this->db->query("SELECT * FROM pms_criteria_form a inner join pms_area_weight b on(a.criteria_id=b.criteria_id) WHERE a.fid='".$form_part_id."' ORDER by area ASC");		
		return $query->result();
	}
		public function general_form($employee_id){
		$query=$this->db->query("SELECT * FROM pms_scorecard_format_employeeportal a inner join pms_employee_forms_employeeportal b on(a.doc_no=b.doc_no) Where employee_id='".$employee_id."' ");	//DESC	
		return $query->result();
	}
	public function GetScoreCriteriaPosBased($form_part_id){

		$query=$this->db->query("SELECT * FROM pms_criteria_form a inner join pms_area_weight b on(a.criteria_id=b.criteria_id) WHERE  a.fid='".$form_part_id."' ORDER by a.position ASC");		

		return $query->result();
	}


	public function get_score($form_part_id){

		$query=$this->db->query("SELECT * FROM pms_scorecard_format_employeeportal a inner join pms_employee_forms_employeeportal b on(a.doc_no=b.doc_no)  inner join pms_grading_table_from_admin_employeeportal c on(a.doc_no=c.doc_no) WHERE  a.employee_id='".$form_part_id."'");		

		return $query->result();
	}




	public function criteira_s($q){
		$this->db->select('*');
		$this->db->from('pms_area_weight_from_admin_employeeportal a');
		$this->db->join('pms_score_employeeportal b', 'b.cid = a.id','left');
		$this->db->where('a.cid',$q);
		$this->db->group_by('b.id');


	    $qwe = $this->db->get();
		return  $qwe->result();
	}


	public function get_c(){
		$this->db->select('*');
		$this->db->from('company_info');


	    $qwe = $this->db->get();
		return  $qwe->result();
	}
	public function get_criteria($form_part_id,$fid){


		$this->db->select('*');
		$this->db->from('pms_scorecard_format_employeeportal a');
		$this->db->join('pms_employee_forms_employeeportal b', 'a.doc_no = b.doc_no');
		$this->db->join('pms_criteria_form_from_admin_employeeportal c', 'a.doc_no = c.doc_no');	
			// $this->db->join('pms_area_weight_from_admin_employeeportal d', 'd.cid = c.cid');
				// $this->db->join('pms_score_employeeportal e', 'e.cid = d.cid');


		$this->db->where('a.employee_id',$form_part_id);
		$this->db->where('c.fid',$fid);
		$this->db->group_by('c.criteria_id');


		  $qwe = $this->db->get();
		$data['result'] = $qwe->result();
		$data['row'] = $qwe->row();
		return $data;
	}
		public function fscore($no){

				$this->db->select('*');
						$this->db->from('pms_finalscore_employeeportal');
		$this->db->where('doc_no',$no);
		$qwe  = $this->db->get();		

		return $qwe->result();
	}



	public function CountGeneralForms(){

		$query=$this->db->query("SELECT count(id) as countId FROM pms_form_parts WHERE InActive='0' AND (employee_id='' OR employee_id IS NULL) ");		
		return $query->row();
	}
		public function recommendation_portal($no){



		$this->db->select('*,d.position as pos,b.position as pos4,j.position as c_position,j.department as c_department');
		$this->db->from('pms_recommendation_employeeportal a');
			$this->db->join('pms_demotion_employeeportal b', 'a.demotion = b.ref','left');
			$this->db->join('pms_regularization_employeeportal c', 'a.regularization = c.ref','left');
				$this->db->join('pms_promotion_employeeportal d', 'a.promotion = d.ref','left');
			$this->db->join('pms_salary_increase_employeeportal e', 'a.salary_increase = e.ref','left');
			$this->db->join('pms_retain_in_existing_position_employeeportal f', 'a.retain_in_existing_position = f.ref','left');
			$this->db->join('pms_end_of_contract_employeeportal g', 'a.end_of_contract = g.ref','left');
			$this->db->join('pms_contract_renewal_employeeportal h', 'a.contract_renewal = h.ref','left');
			$this->db->join('pms_extend_probationary_period_employeeportal i', 'a.extend_probationary_period = i.ref','left');
			$this->db->join('pms_for_lateral_transfer_employeeportal j', 'a.for_lateral_transfer = j.ref','left');








		$this->db->where('a.doc_no',$no);
		
		  $qwe = $this->db->get();

	
		return  $qwe->row();
	}
	public function pmsSingleSettings(){

		$query=$this->db->query("SELECT * FROM pms_single_settings WHERE 1");		
		return $query->row();
	}
	// public function GetAscGeneralForms(){
	// 	$query=$this->db->query("SELECT * FROM pms_form_parts WHERE InActive='0' AND (employee_id='' OR employee_id IS NULL) ORDER by part_number ASC");		
	// 	return $query->result();
	// }

}