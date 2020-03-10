<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Report_analytics_model_pms extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	
	public function companyList(){


		$this->db->select('*');
		$this->db->from('company_info');


		// $this->db->where("A.InActive",0);
		// $this->db->where("A.isDisable",0);
		// $this->db->group_by("A.company_id");
		// $this->db->order_by("B.company_name");
		// $this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get();
		return $query->result();
	}

	public function forms(){


		$this->db->select('*');
		$this->db->from('pms_employee_forms_employeeportal');
		$qw = $this->db->get();


		// $this->db->where("A.InActive",0);
		// $this->db->where("A.isDisable",0);
		// $this->db->group_by("A.company_id");
		// $this->db->order_by("B.company_name");
		// $this->db->join("company_info B","B.company_id = A.company_id","left outer");
		// $query = $this->db->get("division A");
		return $qw->result();
	}


	public function company_division($company){

		$this->db->where("InActive",0);
		$this->db->where("isDisable",0);
		$this->db->where("company_id",$company);
		$this->db->order_by("division_name");
		$query = $this->db->get("division");
		return $query->result();
	}
	//employee


public function count4_employee($score,$employee){

		$this->db->select('*,c.score as score');
		$this->db->from('pms_history_approved_employeeportal a');
		$this->db->join("pms_scorecard_format_employeeportal b","a.doc_no = b.doc_no");
		$this->db->join('pms_totalfinalscore_employeeportal c', 'a.doc_no = c.doc_no');
			 	$this->db->join('employee_info d', 'b.employee_id = d.employee_id');

		$this->db->where('d.employee_id',$employee);

		$this->db->where('b.appraisal_period_type_dates',$this->input->post('chart_type'));
		$this->db->where('c.score',$score);
		$this->db->group_by('c.id');
	
	
		$query = $this->db->get();
		return $query->result();
	}

		public function grading_type_employee($employee){
		$this->db->select('*');
		$this->db->from('pms_employee_forms_employeeportal a');
		$this->db->join('pms_scorecard_format_employeeportal c', 'a.doc_no = c.doc_no');
			$this->db->join('employee_info f', 'c.employee_id = f.employee_id');
		$this->db->where('f.employee_id',$employee);

	
	
		$query = $this->db->get();
		return $query->row();
	
	}

	
		public function employee(){


		$this->db->select('*');
		$this->db->from('employee_info');


		// $this->db->where("A.InActive",0);
		// $this->db->where("A.isDisable",0);
		// $this->db->group_by("A.company_id");
		// $this->db->order_by("B.company_name");
		// $this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get();
		return $query->result();
	}


	public function count_employee($score,$employee){

		$this->db->select('*,c.score as score,e.score as scor');
		$this->db->from('pms_history_approved_employeeportal a');
		$this->db->join("pms_scorecard_format_employeeportal b","a.doc_no = b.doc_no");
		$this->db->join('pms_totalfinalscore_employeeportal c', 'a.doc_no = c.doc_no');




		 $this->db->join('employee_info d', 'b.employee_id = d.employee_id');
	
		$this->db->join('pms_grading_table_from_admin_employeeportal e', 'c.score = e.ranking');
		$this->db->where('d.employee_id',$employee);


		$this->db->where('b.appraisal_period_type_dates',$score);
		
		$this->db->group_by('c.id');

	
	
		$query = $this->db->get();
		return $query->row();
	}

		public function employee_id($id){


		$this->db->select('*');
		$this->db->from('employee_info');

		$this->db->where('company_id',$id);


		// $this->db->where("A.InActive",0);
		// $this->db->where("A.isDisable",0);
		// $this->db->group_by("A.company_id");
		// $this->db->order_by("B.company_name");
		// $this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get();
		return $query->result();
	}
		public function filter_employee($from,$to,$empl){

		$this->db->select('*');
		$this->db->from('pms_scorecard_format_employeeportal a');
		$this->db->where('a.employee_id',$empl);


			$this->db->where('a.appraisal_period_type_dates >=', $from);
			$this->db->where('a.appraisal_period_type_dates <=', $to);
	
		
		

	
	
		$query = $this->db->get();
		return $query->result();
	}






 
		public function display_employee($employee,$company){
				$queryu= $this->grading_type_employee('1589');
				$this->db->select('*,e.ranking as ranking');
		$this->db->from('pms_scorecard_format_employeeportal a');
	
		$this->db->join('pms_employee_forms_employeeportal c', 'a.doc_no = c.doc_no');
		$this->db->join('pms_grading_table_from_admin_employeeportal e', 'a.doc_no = e.doc_no');
		$this->db->join('employee_info d', 'a.employee_id = d.employee_id');
		$this->db->where('d.employee_id',$employee);
		$this->db->where('e.company_id',$company);
			

		$this->db->group_by('e.score');
		
		
		$res = $this->db->get();
		return $res->result();
		}

	// end of employee	
	public function grading_type($company_id){
		$this->db->select('*');
		$this->db->from('pms_employee_forms_employeeportal a');
		$this->db->join('pms_scorecard_format_employeeportal c', 'a.doc_no = c.doc_no');
		$this->db->join('company_info f', 'c.company_id = c.company_id');

		$this->db->where('f.company_id',$company_id);
	
		$query = $this->db->get();
		return $query->row();
	
	}









	public function display_rate($company){
		$queryu= $this->grading_type($company);
		$this->db->select('*');
		$this->db->from('pms_scorecard_format_employeeportal a');
	
		$this->db->join('pms_employee_forms_employeeportal c', 'a.doc_no = c.doc_no');
		$this->db->join('pms_grading_table_from_admin_employeeportal e', 'a.doc_no = e.doc_no');
		$this->db->join('company_info i', 'a.company_id = i.company_id');
		$this->db->where('e.company_id',$company);



 	
	
		if($queryu->grading_type == 1){
		$this->db->group_by('e.score');
		}elseif($queryu->grading_type ==2){
			$this->db->group_by('e.ranking');
		}
		
		
		$res = $this->db->get();
		return $res->result();
		}







		public function display_recommendation($c){
	
		$this->db->select('*,a.employee_id as employee_id,d.position as pos,b.position as pos4,j.position as c_position,j.department as c_department');
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
			if(!empty($this->input->post('chart_type')) AND $this->input->post('chart_type') != 'all'){
			$this->db->where('k.appraisal_period_type_dates',$this->input->post('chart_type'));
		}
			if(!empty($c) AND $c != 'all'){
			$this->db->where('k.company_id',$c);
;		}


		$query = $this->db->get();
		return $query->num_rows();
	}
//classification
public function count4_classification($score,$classification){

		$this->db->select('*,c.score as score');
		$this->db->from('pms_history_approved_employeeportal a');
		$this->db->join("pms_scorecard_format_employeeportal b","a.doc_no = b.doc_no");
		$this->db->join('pms_totalfinalscore_employeeportal c', 'a.doc_no = c.doc_no');
			 	$this->db->join('employee_info d', 'b.employee_id = d.employee_id');
		$this->db->join('classification f', 'd.classification = f.classification_id');
		$this->db->where('f.classification_id',$classification);

		$this->db->where('b.appraisal_period_type_dates',$this->input->post('chart_type'));
		$this->db->where('c.score',$score);
		$this->db->where('b.status','approved');
		$this->db->group_by('c.id');

	
	
		$query = $this->db->get();
		return $query->result();
	}

		public function grading_type_classification($classification){
		$this->db->select('*');
		$this->db->from('pms_employee_forms_employeeportal a');
		$this->db->join('pms_scorecard_format_employeeportal c', 'a.doc_no = c.doc_no');
			$this->db->join('classification f', 'c.employee_id = c.employee_id');
		$this->db->where('f.classification_id',$classification);

	
	
		$query = $this->db->get();
		return $query->row();
	
	}

	
		public function classification(){


		$this->db->select('*');
		$this->db->from('classification');


		// $this->db->where("A.InActive",0);
		// $this->db->where("A.isDisable",0);
		// $this->db->group_by("A.company_id");
		// $this->db->order_by("B.company_name");
		// $this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get();
		return $query->result();
	}


	public function count_classification($score,$classification){

		$this->db->select('*,c.score as score');
		$this->db->from('pms_history_approved_employeeportal a');
		$this->db->join("pms_scorecard_format_employeeportal b","a.doc_no = b.doc_no");
		$this->db->join('pms_totalfinalscore_employeeportal c', 'a.doc_no = c.doc_no');

		 $this->db->join('employee_info d', 'b.employee_id = d.employee_id');
		$this->db->join('classification f', 'd.classification = f.classification_id');
		$this->db->where('f.classification_id',$classification);
		$this->db->where('b.status','approved');


		$this->db->where('b.appraisal_period_type_dates',$this->input->post('chart_type'));
		$this->db->where('c.score',$score);
		$this->db->group_by('c.id');

	
	
		$query = $this->db->get();
		return $query->num_rows();
	}
		public function classification_id($id){


		$this->db->select('*');
		$this->db->from('classification');

		$this->db->where('company_id',$id);


		// $this->db->where("A.InActive",0);
		// $this->db->where("A.isDisable",0);
		// $this->db->group_by("A.company_id");
		// $this->db->order_by("B.company_name");
		// $this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get();
		return $query->result();
	}


 
		public function display_classification($classification,$company){
				$queryu= $this->grading_type_classification($classification);
				$this->db->select('*,e.ranking as ranking');
		$this->db->from('pms_scorecard_format_employeeportal a');
	
		$this->db->join('pms_employee_forms_employeeportal c', 'a.doc_no = c.doc_no');
		$this->db->join('pms_grading_table_from_admin_employeeportal e', 'a.doc_no = e.doc_no');
		$this->db->join('employee_info d', 'a.employee_id = d.employee_id');
		$this->db->join('classification f', 'd.classification = f.classification_id');
	
		$this->db->where('f.classification_id',$classification);


	$this->db->where('e.company_id',$company);

	
 	
		if(!empty($queryu->grading_type) == 1){
		$this->db->group_by('e.score');
		}elseif(!empty($queryu->grading_type) ==2){
			$this->db->group_by('e.ranking');
		
		}
		
		$res = $this->db->get();
		return $res->result();
		}

	// end of classification	
	// location 


	public function count4_location($score,$location){

		$this->db->select('*,c.score as score');
		$this->db->from('pms_history_approved_employeeportal a');
		$this->db->join("pms_scorecard_format_employeeportal b","a.doc_no = b.doc_no");
		$this->db->join('pms_totalfinalscore_employeeportal c', 'a.doc_no = c.doc_no');
			 	$this->db->join('employee_info d', 'b.employee_id = d.employee_id');
		$this->db->join('location f', 'd.location = f.location_id');
		$this->db->where('f.location_id',$location);

		$this->db->where('b.appraisal_period_type_dates',$this->input->post('chart_type'));
		$this->db->where('c.score',$score);

		$this->db->where('b.status','approved');
		$this->db->group_by('c.id');
		
	
	
	
		$query = $this->db->get();
		return $query->result();
	}

		public function grading_type_location($location){
		$this->db->select('*');
		$this->db->from('pms_employee_forms_employeeportal a');
		$this->db->join('pms_scorecard_format_employeeportal c', 'a.doc_no = c.doc_no');
			$this->db->join('location f', 'c.employee_id = c.employee_id');
		$this->db->where('f.location_id',$location);

	
	
		$query = $this->db->get();
		return $query->row();
	
	}


			public function section_id($id){


		$this->db->select('*');
		$this->db->from('section a');
		$this->db->join('department b', 'a.department_id = b.department_id');
		$this->db->where('b.company_id',$id);


		// $this->db->where("A.InActive",0);
		// $this->db->where("A.isDisable",0);
		// $this->db->group_by("A.company_id");
		// $this->db->order_by("B.company_name");
		// $this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get();
		return $query->result();
	}
		public function location(){


		$this->db->select('*');
		$this->db->from('location');


		// $this->db->where("A.InActive",0);
		// $this->db->where("A.isDisable",0);
		// $this->db->group_by("A.company_id");
		// $this->db->order_by("B.company_name");
		// $this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get();
		return $query->result();
	}
	public function count_location($score,$location){

		$this->db->select('*,c.score as score');
		$this->db->from('pms_history_approved_employeeportal a');
		$this->db->join("pms_scorecard_format_employeeportal b","a.doc_no = b.doc_no");
		$this->db->join('pms_totalfinalscore_employeeportal c', 'a.doc_no = c.doc_no');

		 $this->db->join('employee_info d', 'b.employee_id = d.employee_id');
		$this->db->join('location f', 'd.location = f.location_id');
		$this->db->where('f.location_id',$location);
		$this->db->where('b.status','approved');


		$this->db->where('b.appraisal_period_type_dates',$this->input->post('chart_type'));
		$this->db->where('c.score',$score);
		$this->db->group_by('c.id');

	
	
		$query = $this->db->get();
		return $query->num_rows();
	}
		public function location_id($id){


		$this->db->select('*');
		$this->db->from('location a');
		$this->db->join('company_location b', 'a.location_id = b.location_id');
		$this->db->where('b.company_id',$id);


		// $this->db->where("A.InActive",0);
		// $this->db->where("A.isDisable",0);
		// $this->db->group_by("A.company_id");
		// $this->db->order_by("B.company_name");
		// $this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get();
		return $query->result();
	}

		public function display_location($location,$company){
				$queryu= $this->grading_type_location($location);
				$this->db->select('*');
		$this->db->from('pms_scorecard_format_employeeportal a');
	
		$this->db->join('pms_employee_forms_employeeportal c', 'a.doc_no = c.doc_no');
		$this->db->join('pms_grading_table_from_admin_employeeportal e', 'a.doc_no = e.doc_no');
		$this->db->join('employee_info d', 'a.employee_id = d.employee_id');
		$this->db->join('location f', 'd.location = f.location_id');
	
		$this->db->where('f.location_id',$location);
		$this->db->where('e.company_id',$company);
		$this->db->where('a.status','approved');



	
 	
		if(!empty($queryu->grading_type) == 1){
		$this->db->group_by('e.score');
		}elseif(!empty($queryu->grading_type) ==2){
			$this->db->group_by('e.ranking');
		}
		
		$res = $this->db->get();
		return $res->result();
		}

	// end of location	
	//department

		public function count4_department($score,$department){

		$this->db->select('*,c.score as score');
		$this->db->from('pms_history_approved_employeeportal a');
		$this->db->join("pms_scorecard_format_employeeportal b","a.doc_no = b.doc_no");
		$this->db->join('pms_totalfinalscore_employeeportal c', 'a.doc_no = c.doc_no');
		$this->db->join('employee_info d', 'b.employee_id = d.employee_id');
		$this->db->join('department f', 'd.department = f.department_id');
		$this->db->where('f.department_id',$department);
		$this->db->where('b.status','approved');

		$this->db->where('b.appraisal_period_type_dates',$this->input->post('chart_type'));
		$this->db->where('c.score',$score);
		$this->db->group_by('c.id');
	
	
		$query = $this->db->get();
		return $query->result();
	}

		public function grading_type_department($department){
		$this->db->select('*');
		$this->db->from('pms_employee_forms_employeeportal a');
		$this->db->join('pms_scorecard_format_employeeportal c', 'a.doc_no = c.doc_no');
			$this->db->join('department f', 'c.employee_id = c.employee_id');
		$this->db->where('f.department_id',$department);

	
	
		$query = $this->db->get();
		return $query->row();
	
	}
		public function department(){


		$this->db->select('*');
		$this->db->from('department');


		// $this->db->where("A.InActive",0);
		// $this->db->where("A.isDisable",0);
		// $this->db->group_by("A.company_id");
		// $this->db->order_by("B.company_name");
		// $this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get();
		return $query->result();
	}
	public function department_id($id){


		$this->db->select('*');	
		$this->db->from('department');
		$this->db->where('company_id',$id);


		// $this->db->where("A.InActive",0);
		// $this->db->where("A.isDisable",0);
		// $this->db->group_by("A.company_id");
		// $this->db->order_by("B.company_name");
		// $this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get();
		return $query->result();
	}
	public function count_department($score,$department){

		$this->db->select('*,c.score as score');
		$this->db->from('pms_history_approved_employeeportal a');
		$this->db->join("pms_scorecard_format_employeeportal b","a.doc_no = b.doc_no");
		$this->db->join('pms_totalfinalscore_employeeportal c', 'a.doc_no = c.doc_no');

		 	$this->db->join('employee_info d', 'b.employee_id = d.employee_id');
		$this->db->join('department f', 'd.department = f.department_id');
		$this->db->where('f.department_id',$department);

		$this->db->where('b.status','approved');
		$this->db->where('b.appraisal_period_type_dates',$this->input->post('chart_type'));
		$this->db->where('c.score',$score);
		$this->db->group_by('c.id');

	
		
		$query = $this->db->get();
		return $query->num_rows();
	}




		public function display_department($department,$company){
				$queryu= $this->grading_type_department($department);
				$this->db->select('*');
		$this->db->from('pms_scorecard_format_employeeportal a');
	
		$this->db->join('pms_employee_forms_employeeportal c', 'a.doc_no = c.doc_no');
		$this->db->join('pms_grading_table_from_admin_employeeportal e', 'a.doc_no = e.doc_no');
		$this->db->join('employee_info d', 'a.employee_id = d.employee_id');
		$this->db->join('department f', 'd.department = f.department_id');
		$this->db->where('f.department_id',$department);
		$this->db->where('e.company_id',$company);


	
 	
		if($queryu->grading_type == 1){
		$this->db->group_by('e.score');
		}elseif($queryu->grading_type ==2){
			$this->db->group_by('e.ranking');
		}
		
		$res = $this->db->get();
		return $res->result();
		}

	// end of depart

	public function company_department($company){

		$this->db->where("InActive",0);
		$this->db->where("isDisable",0);
		$this->db->where("company_id",$company);
		$this->db->order_by("dept_name");
		$query = $this->db->get("department");
		return $query->result();
	}

	public function company_count($company){

		$this->db->where("isEmployee",1);
		$this->db->where("InActive",0);
		$this->db->where("company_id",$company);
		$query = $this->db->get('employee_info');
		return $query->num_rows();
	}
	


	public function get_appraisal_schedule(){
		$this->db->select('*');
		$this->db->from('pms_scorecard_format_employeeportal');
		$this->db->group_by('appraisal_period_type_dates');
		$query = $this->db->get();
		return $query->result();
	}
	public function count_value(){
		$this->db->select('*');
		$this->db->from('pms_approval_employeeportal a');
		$this->db->join('pms_scorecard_format_employeeportal b', 'a.doc_no = b.doc_no');

		$this->db->join('pms_totalfinalscore_employeeportal d', 'a.doc_no = d.doc_no');

		// $this->db->where('d.doc_no',$doc_no);


		$this->db->group_by('a.doc_no');
		$res = $this->db->get();
		return $res->result();
	}
	public function count4($score){

		$this->db->select('*,c.score as score');
		$this->db->from('pms_history_approved_employeeportal a');
		$this->db->join("pms_scorecard_format_employeeportal b","a.doc_no = b.doc_no");
		$this->db->join('pms_totalfinalscore_employeeportal c', 'a.doc_no = c.doc_no');
		$this->db->join('pms_grading_table_from_admin_employeeportal d', 'c.score = d.ranking');
		

		$this->db->where('b.appraisal_period_type_dates',$this->input->post('chart_type'));
		$this->db->where('c.score',$score);
		$this->db->where('b.status','approved');
		
		$this->db->group_by('c.id');
	
	
		$query = $this->db->get();
		return $query->result();
	}



		public function count_recommendation($score){

		$this->db->select('*');
		$this->db->from('pms_recommendation_employeeportal a');
		$this->db->join("pms_scorecard_format_employeeportal b","a.doc_no = b.doc_no");
	
		$this->db->where('b.appraisal_period_type_dates',$this->input->post('chart_type'));
		$this->db->where($score.'!=', '');

	
	
		$query = $this->db->get();
		return $query->num_rows();
	}



	
	public function count($score){

		$this->db->select('*,c.score as score');
		$this->db->from('pms_history_approved_employeeportal a');
		$this->db->join("pms_scorecard_format_employeeportal b","a.doc_no = b.doc_no");
		$this->db->join('pms_totalfinalscore_employeeportal c', 'a.doc_no = c.doc_no');
				$this->db->join('pms_grading_table_from_admin_employeeportal d', 'c.score = d.ranking');

		

		$this->db->where('b.appraisal_period_type_dates',$this->input->post('chart_type'));
		$this->db->where('c.score',$score);
		$this->db->where('b.status','approved');

		$this->db->group_by('c.id');

	
	
		$query = $this->db->get();
		return $query->num_rows();
	}


	public function company_count_filtered(){

		$company = $this->input->post("company");
		$this->db->where_in("A.company_id",$company);
		$this->db->group_by("A.company_id");
		$this->db->join("department C","C.department_id = A.department","left_outer");
		$this->db->join("company_info B","B.company_id = A.company_id","left_outer");
		$query = $this->db->get("employee_info A");
		return $query->result();
	}

	public function department_count_filtered(){

		$department = $this->input->post("department");
		$this->db->where_in("A.department",$department);
		$this->db->group_by("A.department");
		$this->db->join("department C","C.department_id = A.department","left_outer");
		$this->db->join("company_info B","B.company_id = A.company_id","left_outer");
		$query = $this->db->get("employee_info A");
		return $query->result();
	}

	public function count_filtered($view,$id){

		$this->db->where($view,$id);
		
		$this->db->join("department C","C.department_id = A.department","left_outer");
		$this->db->join("company_info B","B.company_id = A.company_id","left_outer");
		$query = $this->db->get("employee_info A");
		return $query->num_rows();
	}

	public function get_dept_count($dept){

		$this->db->where("department",$dept);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_dept_filtered($dept){

		$this->db->where("InActive",0);
		$this->db->where("department",$dept);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}
//section

		public function count4_section($score,$section){

		$this->db->select('*,c.score as score');
		$this->db->from('pms_history_approved_employeeportal a');
		$this->db->join("pms_scorecard_format_employeeportal b","a.doc_no = b.doc_no");
		$this->db->join('pms_totalfinalscore_employeeportal c', 'a.doc_no = c.doc_no');
			 	$this->db->join('employee_info d', 'b.employee_id = d.employee_id');
		$this->db->join('section f', 'd.section = f.section_id');
		$this->db->where('f.section_id',$section);
		$this->db->where('b.status','approved');
		$this->db->where('b.appraisal_period_type_dates',$this->input->post('chart_type'));
		$this->db->where('c.score',$score);

				$this->db->group_by('c.id');
	
	
		$query = $this->db->get();
		return $query->result();
	}

		public function grading_type_section($section){
		$this->db->select('*');
		$this->db->from('pms_employee_forms_employeeportal a');
		$this->db->join('pms_scorecard_format_employeeportal c', 'a.doc_no = c.doc_no');
		$this->db->join('section f', 'c.employee_id = c.employee_id');
		$this->db->where('f.section_id',$section);

	
	
		$query = $this->db->get();
		return $query->row();
	
	}
		public function section(){


		$this->db->select('*');
		$this->db->from('section');


		// $this->db->where("A.InActive",0);
		// $this->db->where("A.isDisable",0);
		// $this->db->group_by("A.company_id");
		// $this->db->order_by("B.company_name");
		// $this->db->join("company_info B","B.company_id = A.company_id","left outer");
		$query = $this->db->get();
		return $query->result();
	}
	public function count_section($score,$section){

		$this->db->select('*,c.score as score');
		$this->db->from('pms_history_approved_employeeportal a');
		$this->db->join("pms_scorecard_format_employeeportal b","a.doc_no = b.doc_no");
		$this->db->join('pms_totalfinalscore_employeeportal c', 'a.doc_no = c.doc_no');

		 	$this->db->join('employee_info d', 'b.employee_id = d.employee_id');
		$this->db->join('section f', 'd.section = f.section_id');
		$this->db->where('f.section_id',$section);
		$this->db->where('b.status','approved');

		$this->db->where('b.appraisal_period_type_dates',$this->input->post('chart_type'));
		$this->db->where('c.score',$score);
		$this->db->group_by('c.id');

	
	
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function display_section($section,$c){
		$queryu= $this->grading_type_section($section);
		$this->db->select('*');
		$this->db->from('pms_scorecard_format_employeeportal a');
	
		$this->db->join('pms_employee_forms_employeeportal c', 'a.doc_no = c.doc_no');
		$this->db->join('pms_grading_table_from_admin_employeeportal e', 'a.doc_no = e.doc_no');
		$this->db->join('employee_info d', 'a.employee_id = d.employee_id');
		$this->db->join('section f', 'd.section = f.section_id');
		$this->db->where('f.section_id',$section);
		$this->db->where('e.company_id',$c);


	

			$this->db->group_by('e.ranking');
			$this->db->order_by('e.ranking','ASC');
	
		
		$res = $this->db->get();
		return $res->result();
		}

	// end of section	
	public function get_dept_details($dept){

		$this->db->where("A.department_id",$dept);
		$this->db->join("company_info B","B.company_id = A.company_id","left_outer");
		$query = $this->db->get("department A");
		return $query->row();
	}

	public function get_region_filtered($region){

		$this->db->where("InActive",0);
		$this->db->where("region",$region);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_region_details($region){

		$this->db->where("A.region_id",$region);
		// $this->db->join("company_info B","B.company_id = A.company_id","left_outer");
		$query = $this->db->get("region A");
		return $query->row();
	}

	public function get_region_count($location){

		$this->db->where("location",$location);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_location_filtered($location){

		$this->db->where("InActive",0);
		$this->db->where("location",$location);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_location_details($location){

		$this->db->where("A.location_id",$location);
		// $this->db->join("company_info B","B.company_id = A.company_id","left_outer");
		$query = $this->db->get("location A");
		return $query->row();
	}

	public function get_location_count($location){

		$this->db->where("location",$location);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_division_filtered($division){

		$this->db->where("InActive",0);
		$this->db->where("division_id",$division);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_division_details($division){

		$this->db->where("A.division_id",$division);
		$this->db->join("company_info B","B.company_id = A.company_id","left_outer");
		$query = $this->db->get("division A");
		return $query->row();
	}

	public function get_division_count($division){

		$this->db->where("division_id",$division);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_section_filtered($section){

		$this->db->where("InActive",0);
		$this->db->where("section",$section);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_section_details($section){

		$this->db->where("A.section_id",$section);
		$this->db->join("department B","B.department_id = A.department_id","left_outer");
		$query = $this->db->get("section A");
		return $query->row();
	}

	public function get_section_count($section){

		$this->db->where("section",$section);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_subsection_filtered($subsection){

		$this->db->where("InActive",0);
		$this->db->where("section",$subsection);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}

	public function get_subsection_details($subsection){

		$this->db->where("A.subsection_id",$subsection);
		$this->db->join("section B","B.section_id = A.section_id","left_outer");
		$query = $this->db->get("subsection A");
		return $query->row();
	}

	public function get_subsection_count($subsection){

		$this->db->where("section",$subsection);
		$query = $this->db->get("employee_info");
		return $query->num_rows();
	}


// ==============================================================================START TIMEKEEPING ANALAYTICS

public function generate_filter($val){
	
		$query = $this->db->query("select * from masterlist order by company_id");// where company_id= '".$company_id ."'
		return $query->result();

}

public function check_graph_table($t_height,$graph_coverage_interval,$no_decimal){

		$query = $this->db->query("select * from graph_reference where ('".$t_height."' BETWEEN from_c and to_c OR to_c>'".$t_height."') AND by_coverage='".$graph_coverage_interval."' order by from_c asc limit 1");
		return $query->row();

}
public function check_payroll_period($company_id,$val,$illustration_type,$coverage_categ,$s_year,$s_month,$spec_coverage_categ,$year_from,$year_to,$month_from,$month_to,$specific_group_type,$chosen_company){


		if($illustration_type=="total"){
			if($coverage_categ=="total_by_year"){
				//$s_year
				$where_clause="where year_cover='".$s_year."' and company_id='".$company_id."' ";
			}elseif($coverage_categ=="total_by_month"){
				//$s_year $s_month
				$where_clause="where year_cover='".$s_year."' and month_cover='".$s_month."' and company_id='".$company_id."' ";
			}else{

			}
		}else{
			if($spec_coverage_categ=="year_to_year"){
				$where_clause=" where year_cover='".$s_year."' ";

			}elseif($spec_coverage_categ=="month_year_to_month_year"){

				$where_clause=" where year_cover='".$s_year."' AND month_cover='".$s_month."' ";
			}else{
				$where_clause="";
			}
			



		}
		//echo $where_clause."<br>";
		$query = $this->db->query("select * from payroll_period $where_clause ");//
		return $query->result();

}

public function check_analytics($company_id,$val,$illustration_type,$coverage_categ,$s_year,$s_month,$spec_coverage_categ,$year_from,$year_to,$month_from,$month_to,$specific_group_type,$chosen_company,$ml){
		if($ml=="timekeeping"){
			$special_table_name="union_time_summary_mm_tables";
		}elseif($ml=="payroll"){
			$special_table_name="union_payslip_mm_tables";
		}else{

		}
		$cp=$this->check_payroll_period($company_id,$val,$illustration_type,$coverage_categ,$s_year,$s_month,$spec_coverage_categ,$year_from,$year_to,$month_from,$month_to,$specific_group_type,$chosen_company);

			
			$the_payroll_period="";
		if(!empty($cp)){			
			foreach($cp as $p){
				$the_payroll_period.="b.payroll_period_id='".$p->id."' OR ";

			}
			$the_payroll_period=substr($the_payroll_period, 0,-3);
		}else{
			$the_payroll_period="b.payroll_period_id='force_no_result'";
		}

		if($specific_group_type=="b_loc"){
			$check_special_data="AND a.location='".$coverage_categ."' ";
		}elseif($specific_group_type=="by_div"){
			$check_special_data="AND a.division_id='".$coverage_categ."' ";
		}elseif($specific_group_type=="by_dep"){
			$check_special_data="AND a.department='".$coverage_categ."' ";
		}elseif($specific_group_type=="by_class"){
			$check_special_data="AND a.classification='".$coverage_categ."' ";
		}elseif($specific_group_type=="by_employment"){
			$check_special_data="AND a.employment='".$coverage_categ."' ";
		}elseif($specific_group_type=="by_individual"){
			$check_special_data="AND a.employee_id='".$coverage_categ."' ";
		}else{
			$check_special_data="";
		}
				// }

		//echo "select sum(b.$val) as $val from masterlist a inner join $special_table_name b on(a.employee_id=b.employee_id) where a.company_id='".$company_id."' and $val>'0' AND ($the_payroll_period) $check_special_data; <br>";
		$query = $this->db->query("select sum(b.$val) as $val from masterlist a inner join $special_table_name b on(a.employee_id=b.employee_id) where a.company_id='".$company_id."' and $val>'0' AND ($the_payroll_period) $check_special_data");//
		return $query->row();

}

public function check_analytic_highest_num($val,$illustration_type,$coverage_categ,$s_year,$s_month,$spec_coverage_categ,$year_from,$year_to,$month_from,$month_to,$specific_group_type,$chosen_company,$ml,$selected_individual_emp){
		if($ml=="timekeeping"){
			$special_table_name="union_time_summary_mm_tables";
		}elseif($ml=="payroll"){
			$special_table_name="union_payslip_mm_tables";
		}else{

		}

		if($illustration_type=="total"){
			//echo "select sum(b.$val) as $val,a.company_id from masterlist a inner join $special_table_name b on(a.employee_id=b.employee_id) where $val>0 group by company_id order by $val desc limit 1";
			$query = $this->db->query("select sum(b.$val) as $val,a.company_id from masterlist a inner join $special_table_name b on(a.employee_id=b.employee_id) where $val>0 group by company_id order by $val desc limit 1");//

		}else{
			$company_id=$chosen_company;
// =======
		$cp=$this->check_highest_num_pp($company_id,$val,$illustration_type,$coverage_categ,$s_year,$s_month,$spec_coverage_categ,$year_from,$year_to,$month_from,$month_to,$specific_group_type,$chosen_company);

			
			$the_payroll_period="";
		if(!empty($cp)){			
			foreach($cp as $p){
				$the_payroll_period.="b.payroll_period_id='".$p->id."' OR ";

			}
			$the_payroll_period=substr($the_payroll_period, 0,-3);
		}else{
			$the_payroll_period="b.payroll_period_id='force_no_result'";
		}
// ======= 
		if($selected_individual_emp>0){
			$check_employee=" AND a.employee_id='".$selected_individual_emp."' ";
		}else{
			$check_employee="";
		}
		//echo "$check_employee $selected_individual_emp";

			$query = $this->db->query("select sum(b.$val) as $val,min(a.company_id) as company_id from masterlist a inner join $special_table_name b on(a.employee_id=b.employee_id) where $val>0 AND ($the_payroll_period) $check_employee");//			
		}



		return $query->row();

}


public function get_analytics_topic($ml){
		$query = $this->db->query("select * from analytics_fields where module='".$ml."' ");//
		return $query->result();
}
public function check_analytics_topic_name($val){
		$query = $this->db->query("select * from analytics_fields where field_name='".$val."' ");//
		return $query->row();
}


public function check_highest_num_pp($company_id,$val,$illustration_type,$coverage_categ,$s_year,$s_month,$spec_coverage_categ,$year_from,$year_to,$month_from,$month_to,$specific_group_type,$chosen_company){


		if($illustration_type=="total"){
			if($coverage_categ=="total_by_year"){
				//$s_year
				$where_clause="where year_cover='".$s_year."' and company_id='".$company_id."' ";
			}elseif($coverage_categ=="total_by_month"){
				//$s_year $s_month
				$where_clause="where year_cover='".$s_year."' and month_cover='".$s_month."' and company_id='".$company_id."' ";
			}else{

			}
		}else{
			if($spec_coverage_categ=="year_to_year"){
				//year_from $year_to
				$where_clause="year_cover between '".$year_from."' and '".$year_to."' and company_id='".$chosen_company."' ";

			}elseif($spec_coverage_categ=="month_year_to_month_year"){

				$mf = sprintf("%02d", $month_from);
				$mt = sprintf("%02d", $month_to);
				$start_ym = $year_from.'-'.$mf;
				$end_ym = $year_to.'-'.$mt;

				$final_check="";
				
				while (strtotime($start_ym) <= strtotime($end_ym)) {
						$the_yy=substr($start_ym, 0,-3);
						$the_mm=substr($start_ym, 5,2);
						$the_mm = ltrim($the_mm, '0');
						
						$final_check.="(year_cover='".$the_yy."' AND month_cover='".$the_mm."') OR ";

				
			                $start_ym = date ("Y-m", strtotime("+1 month", strtotime($start_ym)));
				}
				$final_check=substr($final_check, 0,-3);				

				$where_clause="$final_check";
				
			}else{
				$where_clause="";
			}
			
		}
		//echo "$final_check<br>";
		$query = $this->db->query("select * from payroll_period where $where_clause ");//
		return $query->result();

}



	public function company_count_official(){ 

		if($this->session->userdata('is_logged_in')){ // with user access restriction // admin portal

			$role_id=$this->session->userdata('user_role');	

			$query=$this->db->query("select a.* from company_info a inner join user_role_company_access b on(a.company_id=b.company_id) where a.InActive=0 AND a.is_this_recruitment_employer='0' AND b.role_id='".$role_id."' group by b.company_id order by a.company_name asc" );

		}else{

			if($this->session->userdata('recruitment_employer_is_logged_in')){
				$employer_user_name=$this->session->userdata('employer_username');
				$this->db->where(array(
					'InActive'	=>	0,	
					'employer_username'	=>	$employer_user_name,	
					'is_this_recruitment_employer'	=>	1	
				));

			}elseif($this->session->userdata('bio_logged_in')){
			
				$this->db->where(array(
					'InActive'	=>	0,	
					'is_this_recruitment_employer'	=>	0	
				));
			}else{
				$this->db->where(array(
					'InActive'	=>	0
				));			
			}

			$this->db->order_by('company_name','asc');
			$query = $this->db->get("company_info");

		}


		return $query->num_rows();
	}	

	
// ==============================================================================END TIMEKEEPING ANALAYTICS	

}