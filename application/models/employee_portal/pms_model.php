<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Pms_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}
	public function add_criteria_form(){



		$data1 = array(
			'area' => $this->input->post('area_name',true),
			'fid' => $this->input->post('idcriteria',true),
			'measurement' => $this->input->post('measurement',true),
			'level' => $this->input->post('level',true),
			'target' => $this->input->post('target',true),
			'position' => $this->input->post('cover',true),
			'company_id' =>$this->session->userdata('company_id'),
			'doc_no'=>$this->input->post('doc_no')

			
		);


		$this->db->insert('pms_criteria_form_employeeportal', $data1);
		$pjesma_id = $this->db->insert_id();



		$weight=$this->input->post('des_weight[]');
		$description=$this->input->post('description[]');
		$insertArray = array();
		$array_combine =  array_combine($description, $weight);
		foreach($array_combine as $description => $weight) {
			$new_add = array(
				'weight'=>$weight,
				'description'=>$description,
				'criteria_id'=>$pjesma_id,
				'fid' => $this->input->post('idcriteria',true)
			);
			array_push($insertArray,$new_add);
		}

		
		$this->db->insert_batch('pms_area_weight_employeeportal', $insertArray);

	}

	public function get_current_appraisal_schedule($doc_no,$company){

			$this->db->select('*');
			$this->db->from('pms_scorecard_format_employeeportal');
				$this->db->where('company_id', $company);
			$this->db->where('appraisal_period_type_dates >=', date('y-m-d')); 
			$this->db->where('doc_no', $doc_no);

			$query1 = $this->db->get();
			return $query1->row();

}	
public function get_current_appraisal_schedule_of_employee($doc_no){

			$this->db->select('*');
			$this->db->from('pms_scorecard_format_employeeportal');
			$this->db->where('company_id', $this->session->userdata('company_id'));
		
			$this->db->where('doc_no', $doc_no);

			$query1 = $this->db->get();
			return $query1->row();

}	


	public function employee_under_creator($company){
			$this->db->select('*');
			$this->db->from('pms_manage_appraisal_schedule');
			$this->db->where('company_id',$company);


			
			
			$query1 = $this->db->get();
			$q =  $query1->row();
			$stack = array();
			if((!empty($q->appraisal_group_id )) or (!empty($q->appraisal_company_id))){
			$this->db->select('*');
			$this->db->from('pms_creators_option2');
			$this->db->where('creator', $this->session->userdata('employee_id'));
			$query = $this->db->get();
			$f = $query->result();
			foreach($f as $qwe){ 
				array_push($stack,$qwe->employee_id);
			}
			if($q->appraisal_group_id){
			$this->db->select('*,c.employee_id as employee_id');
			$this->db->from('pms_manage_appraisal_schedule a');
			$this->db->join('pms_appraisal_schedule_member b', 'a.ref = b.ref','left');
			$this->db->join('employee_info c', 'b.employee_id = c.employee_id');
			$this->db->join('position k', 'c.position = k.position_id','left');
			$this->db->join('pms_creators_option2 d', 'b.employee_id = d.employee_id');
			$this->db->join('location f', 'c.location = f.location_id','left');
			$this->db->join('department g', 'c.department = g.department_id','left');
			$this->db->join('classification h', 'c.classification = h.classification_id','left');
			$this->db->join('section i', 'c.section = i.section_id','left');
			$this->db->join('pms_scorecard_format_employeeportal j', 'c.employee_id = j.employee_id','left');
			$this->db->group_by('c.fullname');

			}elseif($q->appraisal_company_id){
					$this->db->select('*,c.employee_id as employee_id,c.location as location,c.department as department,c.classification as classification_id,c.section as section,c.position as position');
					$this->db->from('pms_manage_appraisal_schedule a');
					$this->db->join('employee_info c', 'a.appraisal_company_id = c.company_id');
					$this->db->join('location f', 'c.location = f.location_id','left');
					$this->db->join('department g', 'c.department = g.department_id','left');
					$this->db->join('classification h', 'c.classification = h.classification_id','left');
					$this->db->join('section i', 'c.section = i.section_id','left');
					$this->db->join('position k', 'c.position = k.position_id','left');
					$this->db->join('pms_scorecard_format_employeeportal j', 'c.employee_id = j.employee_id','left');
					$this->db->group_by('c.fullname');
				

			}
		
				$this->db->where('a.company_id', $company);
				 // $this->db->where('d.approver',$this->session->userdata('employee_id'));



		// $this->db->where_in('c.employee_id',$stack);

			$query1 = $this->db->get();


		$data['query']   = $query1->result();
		$data['q']   = $q->appraisal_period_type_dates;
		return $data;
		


			
				
			}

	}

	// public function employee_under_creator($session_id){
	// 		$this->db->select('*');
	// 		$this->db->from('pms_manage_form_score_type');
	// 		$this->db->where('company_id', $this->session->userdata('company_id'));
	// 		$query1 = $this->db->get();
	// 		$f = $query1->row();
	// 	if($f->creators_type ==2){
	// 	$this->db->select('*');
	// 	$this->db->from('pms_creators_option2');

	// 	$this->db->where('creator',$session_id);
	// 	$query = $this->db->get();
	// 	 $q = $query->result();
	// 	foreach($q as $q){
	// 		$location =  $q->location_name;	
	// 		$d = $q->department_id;	
	// 		$c = $q->classification_name;
	// 		$s = $q->section_id;
	// 	}

	
	// 	$this->db->select('*,a.employee_id as employee_id');
	// 	$this->db->from('employee_info a');
	// 	$this->db->join('location b', 'a.location = b.location_id','left');
	// 	$this->db->join('department c', 'a.department = c.department_id','left');
	// 	$this->db->join('classification d', 'a.classification = d.classification_id','left');
	// 	$this->db->join('section e', 'a.section = e.section_id','left');
	// 	$this->db->join('pms_scorecard_format_employeeportal f', 'a.employee_id = f.employee_id','left');
	// 	if($location != 'all'){
	// 	$this->db->where('b.location_id',$location);
	// 	}
	// 	if($c !='all'){
	// 	$this->db->where('c.department_id',$d);
	// 	}
	// 	if($c !='all'){
	// 	$this->db->where('d.classification_id',$c);
	// 	}
	// 	if($s !='all'){
	// 	$this->db->where('e.section_id',$s);
	// 	}
	// 	$this->db->group_by('a.fullname');
	// 	$query1 = $this->db->get();
	// 	return $query1->result();
	// }elseif($f->creators_type == 1){
	// 	$this->db->select('*');
	// 	$this->db->from('transaction_approvers');

	// 	$this->db->where('approver',$session_id);
	// 	$query = $this->db->get();
	// 	 $q = $query->result();
	// 	foreach($q as $q){
	// 		$location =  $q->location;	
	// 		$d = $q->department;	
	// 		$c = $q->classification;
	// 		$s = $q->section;
		

	
	// 	$this->db->select('*,a.employee_id as employee_id');
	// 	$this->db->from('employee_info a');
	// 	$this->db->join('location b', 'a.location = b.location_id','left');
	// 	$this->db->join('department c', 'a.department = c.department_id','left');
	// 	$this->db->join('classification d', 'a.classification = d.classification_id','left');
	// 	$this->db->join('section e', 'a.section = e.section_id','left');
	// 	$this->db->join('pms_scorecard_format_employeeportal f', 'a.employee_id = f.employee_id','left');
	// 	if($location != 'all'){
	// 	$this->db->where('b.location_id',$q->location);
	// 	}
	// 	if($c !='all'){
	// 	$this->db->where('c.department_id',$q->department);
	// 	}
	// 	if($c !='all'){
	// 	$this->db->where('d.classification_id',$q->classification);
	// 	}
	// 	if($s !='all'){
	// 	$this->db->where('e.section_id',$q->section);
	// 	}
	// 	$this->db->group_by('a.fullname');
	// 	$query1 = $this->db->get();
	// 	return $query1->result();
	// }
	// }
	// }

	public function get_creator_($id){

					$this->db->select('*');
					$this->db->from('pms_manage_form_score_type');
					$this->db->where('company_id', $id);
					
					// $this->db->join('pms_grading_default', 'pms_grading_table.grading_type = pms_grading_default.grading_type');


					$query = $this->db->get();
					return $query->row();
				}
	public function get_employee_creator($company, $department,$classfication,$section,$location){
		$res =$this->get_creator_($company);

		if(!empty($res->creators_type) == 4){
		$this->db->select('*');
		$this->db->from('transaction_approvers a');
	    $this->db->where('a.department', $department);
		$this->db->where('a.classification',$classfication);
					$this->db->where('a.section', $section);
					$this->db->where('a.location', $location);
					
					$this->db->where('a.approver',$this->session->userdata('employee_id'));
						// $this->db->where('a.approval_level','1');

		}elseif(!empty($res->creators_type) == 1){
					$this->db->select('*');
					$this->db->from('pms_creators_option2 a');
	  			  $this->db->where('a.department_id', $department);
					$this->db->where('a.classification_name',$classfication);
					$this->db->where('a.section_id', $section);
					$this->db->where('a.location_name', $location);
					
					$this->db->where('a.creator',$this->session->userdata('employee_id'));
		}			
					

				$query = $this->db->get();

		return $query->row();


	}

	public function get_form(){

		$query = $this->db->get('pms_appraisal_form');

		return $query->result();
	}

	public function get_weight_and_description_admin($id,$no){
		$this->db->select('*');
		$this->db->from('pms_area_weight_from_admin_employeeportal a');

		$this->db->where('a.doc_no',$no);
		$this->db->where('a.cid',$id);

		$query = $this->db->get();
		return $query->result();
	}
		public function get_weight_job($id){
		$this->db->select('*');
		$this->db->where('area_weight_id',$id);
		
		$query = $this->db->get('pms_criteria_job_from_admin_employeeportal');
		return $query->result();
	}

	public function get_weight_and_description_portal($id){
		$this->db->select('*');
		$this->db->from('pms_area_weight_employeeportal');
		$this->db->where('criteria_id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	public function get_emp_info($employee_id){
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('employee_info');

		return $query->row();
	}


	public function get_company_all(){
	 	//$this->db->select('company_name, wDivision');


	 	$query = $this->db->get('company_info');
	 	return $query->result();
	}
	
	public function get_company_info(){
	 	//$this->db->select('company_name, wDivision');
	 	$this->db->where('company_id', $this->session->userdata('company_id'));

	 	$query = $this->db->get('company_info', 1);
	 	return $query->row();
	}
		public function delete_criteria($id,$comp){
				
			$this->db->where('cid',$id);

		$this->db->delete('pms_area_weight_from_admin_employeeportal');
		
		$this->db->where('cid',$id);



	
		$this->db->delete('pms_criteria_form_from_admin_employeeportal');
	}

		public function add_grading_table($employeeuid){
						$score_equivalent = $this->input->post('equivalent');
			

					$data = array(
			'scoring_guide' => $this->input->post('scoring_guide'),
			// 'grading_type' => $this->input->post('grading_type',true),
			'score_equivalent' => $this->input->post('equivalent',true),
			'score' => $this->input->post('score_name',true),
			'ranking' => $this->input->post('ranking',true),
			'company_id' => 	$c = $this->session->userdata('company_id'),
			'fid' => $this->input->post('fid'),
			'employee_id' => $employeeuid,
			'creator' =>$this->session->userdata('employee_id'),



		);


		$this->db->insert('pms_grading_table_employeeportal', $data);


	}
	public function self_weight_and_description_admin($id){
		$this->db->select('*');
		$this->db->from('pms_area_weight_from_admin_employeeportal');


		$query = $this->db->get();
		return $query->result();
	}

		public function deleting_grade($id,$comp){
		$this->db->where('gid', $id);

		$this->db->delete('pms_grading_table_from_admin_employeeportal');
	}
			public function add_grading_table_admin(){
						$score_equivalent = $this->input->post('equivalent');
			

					$data = array(
			'fid'=>$this->input->post('fid'),
			'scoring_guide' => $this->input->post('scoring_guide'),
			// 'grading_type' => $this->input->post('grading_type',true),
			'score_equivalent' => $this->input->post('equivalent',true),
			'score' => $this->input->post('score_name',true),
			'ranking' => $this->input->post('ranking',true),
			'doc_no'=>$this->input->post('doc_no',true),
			'color'=>$this->input->post('color',true)





		);


		$this->db->insert('pms_grading_table_from_admin_employeeportal', $data);


	}
		public function add_criteria_form_admin(){


		$ref = rand(10,100);
		$data1 = array(
			'fid'=>$this->input->post('fid'),
			'area' => $this->input->post('area_name',true),
			'doc_no'=> $this->input->post('doc_no'),
			'measurement' => $this->input->post('measurement',true),
			'level' => $this->input->post('level',true),
			'target' => $this->input->post('target',true),
			'cid' =>$ref.'_'.date('Y-m-d H:i:s'),
			
	
			
		);


		$this->db->insert('pms_criteria_form_from_admin_employeeportal', $data1);
		$pjesma_id = $this->db->insert_id();



		$weight=$this->input->post('des_weight[]');
		$description=$this->input->post('description[]');
		$insertArray = array();
		$array_combine =  array_combine($description, $weight);
		foreach($array_combine as $description => $weight) {
			$new_add = array(
				'weight'=>$weight,
				'description'=>$description,
				'doc_no'=> $this->input->post('doc_no'),
				'cid'=>$ref.'_'.date('Y-m-d H:i:s'),
				'fid' => $this->input->post('idcriteria',true)

			);
			array_push($insertArray,$new_add);
		}

		
		$this->db->insert_batch('pms_area_weight_from_admin_employeeportal', $insertArray);

	}
		public function get_grading_table_admin($fid){

					$this->db->select('*');
					$this->db->from('pms_grading_table');
					// $this->db->join('pms_grading_default', 'pms_grading_table.grading_type = pms_grading_default.grading_type');
					$this->db->where('pms_grading_table.fid',$fid);

					$query = $this->db->get();
					return $query->result();
				}

	public function get_criteria($id){
		$this->db->select('*');
		$this->db->where('fid',$id);



		$query = $this->db->get('pms_criteria_form');//admin_emp_masterlist_view
		return $query->result();
	}
	public function qweqwewqe($id,$des,$admin){
		$this->db->select('*');
		$this->db->from('pms_evaluation_employeeportal a');
			$this->db->join('pms_eval_score_employeeportal b', 'a.evaluators = b.evaluated_by','left');
			$this->db->join('employee_info c', 'b.evaluated_by = c.employee_id','left');
			$this->db->where('doc_no',$id);
			$this->db->where('desc_weight',$des);
			$this->db->where('created_by',$admin);
			$query = $this->db->get();//admin_emp_masterlist_view
		return $query->result();
	}
		public function get_date($doc_no){
		$this->db->select('*');
		$this->db->from('pms_scorecard_format_employeeportal a');
		$this->db->where('a.appraisal_period_type_dates >=', date('y-m-d'));
		$this->db->where('doc_no',$doc_no);
		$query = $this->db->get();//admin_emp_masterlist_view
		return $query->row();
		}
	public function self_eval_score($id,$des,$admin){
		$this->db->select('*');
		$this->db->from('pms_evaluationself_employeeportal a');
			$this->db->join('pms_eval_score_employeeportal b', 'a.eid = b.evaluated_by','left');
			$this->db->join('employee_info c', 'b.evaluated_by = c.employee_id','left');
			$this->db->where('doc_no',$id);
			$this->db->where('desc_weight',$des);
			$this->db->where('created_by',$admin);
			$query = $this->db->get();//admin_emp_masterlist_view
		return $query->result();
	}
		public function get_weight_and_description($id){
		$this->db->select('*');
		$this->db->from('pms_area_weight');
		$this->db->where('pms_area_weight.criteria_id',$id);
		$query = $this->db->get();
		return $query->result();
	}
		public function get_criteria_admin($id,$fid){
		$this->db->select('*');
		$this->db->from('pms_criteria_form_from_admin_employeeportal');
		$this->db->where('fid',$fid);
		$this->db->where('doc_no',$id);
		$this->db->group_by('criteria_id');
		$query = $this->db->get();//admin_emp_masterlist_view
		return $query;
	}
		public function self_criteria_admin($fid){
		$this->db->select('*');
		$this->db->from('pms_criteria_form_from_admin_employeeportal');
	
		$this->db->group_by('criteria_id');
		$query = $this->db->get();//admin_emp_masterlist_view
		return $query->result();
	}

		public function self_general_forms_admin($id){
		$this->db->select('*');
		$this->db->from('pms_scorecard_format_employeeportal');
		$this->db->where('employee_id',$id);
		$this->db->where('appraisal_period_type_dates >=', date('y-m-d'));

		$query1 = $this->db->get();
		$q =  $query1->row();
		if(!empty($q)){
		$c = $this->session->userdata('company_id');

		$this->db->select('*');
		$this->db->from('pms_employee_forms_employeeportal a');
		$this->db->where('a.doc_no',$q->doc_no);
		$this->db->order_by('a.form_part','asc');
		$query = $this->db->get();
		return $query->result();
	}
	}

		public function get_criteria_admin_for_approver($id,$doc_no){
		$this->db->select('*');
		$this->db->from('pms_criteria_form_from_admin_employeeportal');
		$this->db->where('doc_no',$doc_no);
		$this->db->where('fid',$id);
		$query = $this->db->get();//admin_emp_masterlist_view
		return $query->result();
	}
		public function get_criteria_admin_for_approver1($id,$doc_no){
		$this->db->select('*');
		$this->db->from('pms_criteria_form_employeeportal');
		$this->db->where('doc_no',$doc_no);
		$this->db->where('fid',$id);
		$query = $this->db->get();//admin_emp_masterlist_view
		return $query->result();
	}
	public function get_final_rating($doc_no){

			$this->db->select("a.form_title,a.weight,b.fid");
	    $this->db->distinct();
	    $this->db->from("pms_employee_forms_employeeportal a");
	    $this->db->join('pms_eval_score_employeeportal b', 'a.fid = b.fid');
    $this->db->where('created_by','admin');
	    $this->db->where("a.doc_no",$doc_no);

	
	    $query1 = $this->db->get_compiled_select(); // It resets the query just like a get()

	    $this->db->select("a.form_title,a.weight,b.fid");
	    $this->db->distinct();
	    $this->db->from("pms_general_form_employeeportal a");
	    $this->db->join('pms_eval_score_employeeportal b', 'a.fid = b.fid');
	        $this->db->where('created_by','creator');
	       $this->db->where("a.doc_no",$doc_no);
	  


	    $query2 = $this->db->get_compiled_select(); 

	    $c = $this->db->query($query1." UNION ".$query2);

				
				

				return $c->result();

		
	}
	public function get_schedqwe($id){
		$this->db->select('*');
		$this->db->from('pms_manage_appraisal_schedule b');
		$this->db->join('company_info a', 'b.appraisal_company_id = a.company_id','left');
		$this->db->join('pay_type c', 'b.payroll_period_group_id = c.pay_type_id','left');
		$this->db->join('pms_appraisal_group d', 'b.appraisal_group_id = d.appraisal_group_id','left');
		$this->db->join('pms_appraisal_period_type e', 'b.appraisal_period_type_id = e.id','left');
		$this->db->where('b.company_id', $id);
		$this->db->where('b.cover_year',date('Y'));
		

				
		$query = $this->db->get();

		return $query->row();
	}

	public function get_sched($id){
		$this->db->select('*');
		$this->db->from('pms_manage_appraisal_schedule b');
		$this->db->join('company_info a', 'b.appraisal_company_id = a.company_id','left');
		$this->db->join('pay_type c', 'b.payroll_period_group_id = c.pay_type_id','left');
		$this->db->join('pms_appraisal_group d', 'b.appraisal_group_id = d.appraisal_group_id','left');
		$this->db->join('pms_appraisal_period_type e', 'b.appraisal_period_type_id = e.id','left');
		$this->db->where('b.company_id', $id);
		$this->db->where('b.cover_year',date('Y'));
		$this->db->where('b.appraisal_period_type_dates >=', date('m-d'));  
			
		$query = $this->db->get();

		return $query->row();
	}
	public function get_criteria_portal($id){
		$this->db->select('*');
			$this->db->from('pms_criteria_form_employeeportal');
		
		$this->db->where('fid',$id);





		$query = $this->db->get();//admin_emp_masterlist_view
		return $query->result();
	}
	
public function agreed($data){
		   $this->db->where('doc_no',$this->input->post('doc_no'));
	return $this->db->update('pms_agree_employeeportal', $data);

}
public function add_general_form($data){

	
return $this->db->insert('pms_general_form_employeeportal', $data);


	}

		public function get_doc_no($id){


		$this->db->select('*');
		$this->db->from('pms_scorecard_format_employeeportal');
		$this->db->where('employee_id',$id);
			$this->db->where('appraisal_period_type_dates >=', date('y-m-d'));  
	
                                                             


					$query = $this->db->get();
					return $query->row();
				}
		public function get_ref_no_of_evaluators($id){


		// $this->db->select('*');
		// $this->db->from('pms_form_evaluators a');
		// $this->db->where('a.company_id',$this->session->userdata('company_id'));
		// $q = $this->db->get();

		// 		$location = array();
		// 		$department = array();
		// 		$section = array();
		// 		$classification = array();
		// 		foreach($q->result() as $s){
		// 			$department[] = $s->department_id;
		// 			$location[] = $s->location_id;
		// 			$section[] = $s->section_id;
		// 			$classification[] = $s->classification_id;
		// 		}	
					
		// $this->db->select('*');
		// $this->db->from('employee_info a');	
		// $this->db->join('department b', 'a.department = b.department_id');
		// $this->db->join('section c', 'a.section = c.section_id');
		// $this->db->join('location d', 'a.location = d.location_id');
		// $this->db->join('classification e', 'a.classification = e.classification_id');
		// $this->db->where_in('b.department_id', $department);
		// $this->db->where_in('c.section_id', $section);
		// $this->db->where_in('d.location_id', $location);
		// $this->db->where_in('e.classification_id', $classification);

		// $s = $this->db->get();
		// $w ='';
		// foreach($s->result() as $s){
		// 	if($s->employee_id == $id){
		// 		$w = 'true';
		// 		break;
		// 	}else{
		// 		$w =  'false';
				
				
		// 	}
		// }
		return true;

	
                                                             


				}
	
	public function has_division($company_id){
		$this->db->select('company_id');
		$this->db->where(array(

			'company_id'			=>			$company_id,
			'wDivision'				=>			1
			));

		$query = $this->db->get('company_info', 1);

		if ($query->num_rows() > 0){
			return true;
		} else {
			return false;
		}
	}

	public function has_subsection($section_id){
		$this->db->select('section_id');
		$this->db->where(array(

			'section_id'			=>			$section_id,
			'wSubsection'			=>			1
			));

		$query = $this->db->get('section', 1);

		if ($query->num_rows() > 0){
			return true;
		} else {
			return false;
		}
	}
	public function get_grading_table($fid,$doc_no){


						$this->db->select('*');
		$this->db->from('pms_grading_table_from_admin_employeeportal');


		$this->db->where('fid',$this->input->post('fid'));
		$this->db->where('doc_no',$doc_no);



					$query = $this->db->get();
					return $query->result();
				}
					public function get_instruction($fid,$doc_no){


									$this->db->select('*');
					$this->db->from('pms_employee_forms_employeeportal');


								$this->db->where('fid',$this->input->post('fid'));
		$this->db->where('doc_no',$doc_no);


					$query = $this->db->get();
					return $query->row();
				}
					public function get_grading_table_order($fid,$doc_no){


						$this->db->select('*');
		$this->db->from('pms_grading_table_from_admin_employeeportal');


		$this->db->where('fid',$this->input->post('fid'));
		$this->db->where('doc_no',$doc_no);
		$this->db->order_by("ranking", "asc");



					$query = $this->db->get();
					return $query->result();
				}
	public function get_grading_table_employeeportal($fid){

					$this->db->select('*');
					$this->db->from('pms_grading_table_employeeportal');
					// $this->db->join('pms_grading_default', 'pms_grading_table.grading_type = pms_grading_default.grading_type');
					$this->db->where('pms_grading_table_employeeportal.fid',$fid);

					$query = $this->db->get();
					return $query->result();
				}


	// SCORECARD CREATOR
	public function position()
	{
		
		$query = $this->db->get('position');
		return $query->result();
	}
	public function checkDuplicatedocno($doc_no,$form_part,$fid) {
	$this->db->select('*');
	$this->db->from('pms_employee_forms_employeeportal');
    $this->db->where('doc_no', $doc_no);
    $this->db->where('form_part', $form_part);
    $this->db->where('fid', $fid);

    $query = $this->db->get();

    return $query->num_rows();

}
	public function checkDuplicategrading($doc_no,$fid,$score_equivalent) {
	$this->db->select('*');
	$this->db->from('pms_grading_table_from_admin_employeeportal');
    $this->db->where('doc_no', $doc_no);

    $this->db->where('fid', $fid);
       $this->db->where('scoring_guide', $score_equivalent);

    $query = $this->db->get();

    return $query->num_rows();

}

public function checkDuplicatecriteria($doc_no,$fid,$area,$level,$measurement,$target,$position) {
	$this->db->select('*');
	$this->db->from('pms_criteria_form_from_admin_employeeportal');
		$this->db->join('pms_area_weight_from_admin_employeeportal b', 'a.cid = b.cid');
    $this->db->where('a.doc_no', $doc_no);

    $this->db->where('a.fid', $fid);
    $this->db->where('a.area',$area);
     $this->db->where('a.level',$level);

    $this->db->where('a.measurement',$measurement);
     $this->db->where('a.target',$target);

    $this->db->where('a.position',$position);
    $this->db->where('b.description',$c);	

    $query = $this->db->get();

    return $query->num_rows();
    }
	public function save_general_form($id,$id4,$position,$rand){
		

		$session_id = $this->session->userdata('employee_id');
		$c = $this->input->post('company_id');
		$appraisal_period_type_dates = date('y').'-'.date('m').'-'.$this->input->post('appraisal_period_type_dates');
		$ref  = $id.$appraisal_period_type_dates.$this->input->post('cover_year');


	

		$this->db->select('*');
		$this->db->from("pms_appraisal_form a");
		$this->db->where('a.form_part',$id4);
		$this->db->where('a.company_id',$c);
		$query = $this->db->get();
		$f= $query->row();
		if($this->checkDuplicatedocno($ref,$id4,$f->fid) <= 0 ){
		$data4 = array(
				
				'doc_no'=>$ref,
				'form_part'=>$id4,
				'form_title'=>$f->form_title,
				'grading_type'=>$f->grading_type,
				'form_instruction'=>$f->form_instruction,
				'form_description'=>$f->form_description,
				'weight'=>$f->weight,
				'date_added'=> date('Y-m-d H:i:s'),
				'fid'=>$f->fid,
				'status'=>' '

			
				
				);
				$this->db->insert('pms_employee_forms_employeeportal', $data4);
			}

		$this->db->select('*');
		$this->db->from("pms_appraisal_form a");
		$this->db->join('pms_grading_table b', 'a.fid = b.fid');
		$this->db->where('a.form_part',$id4);
		$query = $this->db->get();
		$q= $query->result();

			foreach($q as $qe){
		
					if($this->checkDuplicategrading($ref,$qe->fid,$qe->scoring_guide) <= 0){
				$datas = array(
				'fid'=>$qe->fid,
				'score'=>$qe->score,
				'scoring_guide'=>$qe->scoring_guide,
				'score_equivalent'=>$qe->score_equivalent,	
				'ranking'=>$qe->ranking,
				'doc_no'=>$ref,
				'color'=>$qe->color,
				'company_id'=>$qe->company_id

		
				);
				$this->db->insert('pms_grading_table_from_admin_employeeportal',$datas);
					
		}
	}


  
		$this->db->select('*');
		$this->db->from("pms_appraisal_form a");
		$this->db->join('pms_criteria_form b', 'a.fid = b.fid');
		$this->db->join('pms_area_weight c', 'b.criteria_id = c.criteria_id');

		
		$this->db->where("a.form_part",$id4)->where("(b.position='".$position."' OR b.position='all')");
		
		$this->db->group_by(array("b.criteria_id"));
		$query1 = $this->db->get();
		$q1= $query1->result();



		

			foreach($q1 as $qe1){
		// if($this->checkDuplicatecriteria($ref,$qe1->fid,$qe1->area,$qe1->level,$qe1->measurement,$qe1->target,$qe1->position,$qe->description) <= 0){
				$criteria = array(
				'fid'=>$qe1->fid,
				'area'=>$qe1->area,
				'level'=>$qe1->level,
				'measurement'=>$qe1->measurement,
				'target'=>$qe1->target,
				'position'=>$qe1->position,
				
				'cid'=>$id.$qe1->criteria_id,
				'doc_no'=>$ref

				);
				$suc = $this->db->insert('pms_criteria_form_from_admin_employeeportal',$criteria);
		}
	// }
	if($suc){

		$this->db->select('*');
		$this->db->from("pms_area_weight a");
		$this->db->where('a.fid',$this->input->post('fid'));	
		$qw = $this->db->get();
		$w= $qw->result();
		foreach($w as $w){
					if($this->checkDuplicateareaweight($description,$this->input->post('company_id')) <= 0){
			$dw = array(
				
				'cid'=>$id.$w->criteria_id,
				'fid'=>$w->fid,
				'description'=>$w->description,
				'doc_no'=>$ref,
				'ref_id'=>$id.$w->id

		
				);
		$this->db->insert('pms_area_weight_from_admin_employeeportal',$dw);
		}
		$inser = $this->db->insert_id();
  				$this->db->select('*');
		$this->db->from("pms_criteria_job a");
		$this->db->where('a.fid',$this->input->post('fid'));
		$this->db->where('a.area_weight_id',$w->id);
		$qw = $this->db->get();
		$criteria_job= $qw->result();
		$a = array();
		foreach($criteria_job as $criteria_job){
		
			
			$dw = array(
				
				'cid'=>$id.$criteria_job->cid,
				'weight'=>$criteria_job->weight,
				'job_level'=>$criteria_job->job_level,
				'area_weight_id'=>$inser,
				'fid'=>$criteria_job->fid,
				

		
				);
		$this->db->insert('pms_criteria_job_from_admin_employeeportal',$dw);
	
	
		
  				array_push($a,$criteria_job->id);

		}	

		}

	
	}

			$this->db->select('*');
			$this->db->from('pms_scorecard_format_employeeportal');
			$this->db->where("doc_no",$ref );
			$this->db->where('appraisal_period_type_dates',date('y').'-'.$this->input->post('appraisal_period_type_dates'));
			$meron = $this->db->get();
			$dup =  $meron->num_rows();


			if($dup==0){
					$this->db->select('*');
			$this->db->from('pms_manage_appraisal_schedule');
			$this->db->where("company_id",$this->session->userdata('company_id'));
			$this->db->where('ref',$this->input->post('ref'));

			$pmw =  $this->db->get();
			$pms = $pmw->result();

			if($this->input->post('appraisal_period_type') == 'monthly'){
				$appraisal_period_type = date('y').'-'.date('m').'-'.$this->input->post('appraisal_period_type_dates');
			}else{
				$appraisal_period_type = date('y').'-'.$this->input->post('appraisal_period_type_dates');
			}



			if(true){

			$data2 = array(
				'employee_id'=>$id,
				'doc_no'=>$ref,
				'cover_year' => $this->input->post('cover_year'),
				'appraisal_period_type' => $this->input->post('appraisal_period_type'),
				'appraisal_type' => $this->input->post('appraisal_type'),
				'appraisal_period_type_dates' => $appraisal_period_type ,
				'company_id'=>$c,
				'date_created'=>date("Y-m-d h:i:sa"),
				'coverage'=>$this->input->post('appraisal_coverage'),
				'number_days'=>$this->input->post('number_days'),

			

				);
		
		$this->db->insert('pms_scorecard_format_employeeportal',$data2);
	
			}
	}

	}
		public function checkDuplicateareaweight($doc_no,$fid) {
			$this->db->select('*');
			$this->db->from('pms_scorecard_format_employeeportal');
		    $this->db->where('doc_no', $doc_no);

		    $this->db->like('appraisal_period_type_dates', $fid);


		    $query = $this->db->get();

		    return $query->num_rows();

}

		public function checkDuplicatecriteriajob($job_level,$fid) {
			$this->db->select('*');
			$this->db->from('pms_criteria_job_from_admin_employeeportal');
		    $this->db->where('job_level', $job_level);
		    $this->db->where('area_weight_id', $fid);

		    


		    $query = $this->db->get();

		    return $query->num_rows();

}

	public function get_approver_($company){
					$this->db->select('*');

					$this->db->from('pms_manage_form_approver_type');
					$this->db->where('company_id',$company);
					$query = $this->db->get();
					return $query->row();

	}

public function get_scorecard_($company){
					$this->db->select('*');

					$this->db->from('pms_manage_form_score_type');
					$this->db->where('company_id',$company);
					$query = $this->db->get();
					return $query->row();

}

		public function checkDuplicateforms($doc_no,$fid) {
	$this->db->select('*');
	$this->db->from('pms_scorecard_format_employeeportal');
    $this->db->where('doc_no', $doc_no);

    $this->db->like('appraisal_period_type_dates', $fid);


    $query = $this->db->get();

    return $query->num_rows();

}	public function get_evaluator_without(){
					$this->db->select('*');

					$this->db->from('pms_manage_form_evaluators_type');
			
					$query = $this->db->get();
					return $query->row();

	}
	public function getgradingtype_admin($fid){
		$this->db->where('fid',$fid); 
		$query = $this->db->get('pms_employee_forms_employeeportal');
		return $query->row();
	}
		public function getgradingtype($fid){
		$this->db->where('fid',$fid); 
		$query = $this->db->get('pms_general_form_employeeportal');
		return $query->row();
	}
	public function get_evaluator_($company){
					$this->db->select('*');

					$this->db->from('pms_manage_form_evaluators_type');
					$this->db->where('company_id',$company);
					$query = $this->db->get();
					return $query->row();

	}
		public function approver_for($company){
			
	
			
			$q =array('form_tagging' => 'for evaluation');
			$this->input->post('eval');
			$this->db->where("doc_no", $this->input->post('refe'));
			$this->db->update('pms_scorecard_format_employeeportal', $q);

			$res =$this->get_approver_($company);

			if($res->creators_type == 4){
			   $this->db->select('*');
	       $this->db->from('pms_scorecard_format_employeeportal a');
	       $this->db->join('employee_info b', 'a.employee_id = b.employee_id');
	       $this->db->join('department c', 'b.department = c.department_id');
	       $this->db->join('section d', 'b.section = d.section_id');
	       $this->db->join('location e', 'b.location = e.location_id');
	       $this->db->join('classification f', 'b.classification = f.classification_id');
	       $this->db->where('a.doc_no',$this->input->post('refe'));
		    $res = $this->db->get();
     	    $employee_id = $res->row();

     	  $this->db->select('*');
	      $this->db->from('transaction_approvers ');
	      $this->db->where('department',$employee_id->department_id);
	      $this->db->where('classification',$employee_id->classification_id);
	      $this->db->where('location',$employee_id->location_id);
	      $this->db->where('section',$employee_id->section_id);
	      $this->db->group_by(array("approver",'approval_level'));
	      $this->db->order_by('approval_level','asc');

	      $query = $this->db->get();

 	      $q=  $query->result();

			$bFirstTime = '1';


			$qwe = array();

			$store = '';

			foreach($q as $e){
				

			 	if(!in_array($e->approver,$qwe)){



			    
			
			    if($bFirstTime == '1') {
			    			 		
	       					$datas = array(
										
										   'approvers'=>$e->approver,
								           'doc_no'=>$this->input->post('refe'), 
							               'appro_level'=>$e->approval_level,
								           'status'=>'pending'
							);
							$store = $e->approval_level;

 			   } elseif($bFirstTime == '0') {

 			   					 	if($store == $e->approval_level){
      						   					$datas = array(
													'approvers'=>$e->approver,
								 					'doc_no'=>$this->input->post('refe'), 
								 					'appro_level'=>$e->approval_level,
											   		'status'=>'pending'
										       );
      				
									}else{
											$datas = array(
													'approvers'=>$e->approver,
								 					'doc_no'=>$this->input->post('refe'), 
								 					'appro_level'=>$e->approval_level,
											   		'status'=>''
										       );

										}
				

       						
   				      }

   				
   				$bFirstTime = '0';
			    $this->db->insert('pms_approval_employeeportal', $datas);
			   
			}
			array_push($qwe,$e->approver);	  
			}
				
			// foreach($q as $e){
			// 				 if ($bFirstTime) {
	  //      					$datas = array(
			// 					'approvers'=>$e->approver,
			// 					'doc_no'=>$this->input->post('refe'), 
			// 					'appro_level'=>$e->approval_level,
			// 					'status'=>'pending' 
			// 				);
   //    						  $bFirstTime = false;
 		// 	   } else {
   //     						$datas = array(
			// 					'approvers'=>$e->approver,
			// 					'doc_no'=>$this->input->post('refe'), 
			// 					'appro_level'=>$e->approval_level,
			// 					'status'=>''
			// 		       );
   // 				      }

   	

   			
   		
			// $this->db->insert('pms_approval_employeeportal', $datas);
				      
  	

   // 			}	      
			}else{
			$this->db->select('*');
			$this->db->from('pms_form_approvers');
			$this->db->where('company_id',$session_id = $this->session->userdata('company_id'));
			$this->db->group_by('approval_level');
			$this->db->order_by('approval_level','asc');
			$query = $this->db->get();

			$q=  $query->result();
			$bFirstTime = true;
			foreach($q as $e){
				if ($bFirstTime) {
	       					$datas = array(
								'approvers'=>$e->approver_id,
								'doc_no'=>$this->input->post('refe'), 
								'appro_level'=>$e->approval_level,
								'status'=>'pending'
							);
       						 $bFirstTime = false;
  				  } else {
       					$datas = array(
								'approvers'=>$e->approver_id,
								'doc_no'=>$this->input->post('refe'), 
								'appro_level'=>$e->approval_level,
								'status'=>''
								);
    					 }
    			$this->db->insert('pms_approval_employeeportal', $datas);					 
	         }
			
								
							}

				
			
			$data4 = array(
					'employee_id'=>$this->input->post('employid'),
					'evaluator'=>$this->session->userdata('employee_id'),
					'date'=>date("Y-m-d h:i:sa"),
					'status'=>'completed',
					'doc_no'=>$this->input->post('refe')
				);
			$this->db->insert('pms_history_eval_employeeportal', $data4);

			$q =array('status' => 'done');
			$this->input->post('eval');
			$this->db->where("doc_no", $this->input->post('refe'));
			$this->db->where("eval_level", $this->input->post('l'));
			$this->db->update('pms_evaluation_employeeportal', $q);
	

	
	}

	public function evaluation_for($comp){

			$q =array('form_tagging' => 'for evaluation');
			$this->input->post('eval');
			$this->db->where("doc_no", $this->input->post('doc_no'));
			$this->db->update('pms_scorecard_format_employeeportal', $q);
			$session_id = $this->session->userdata('employee_id');
	     	$c = $this->input->post('company');	

			$res =$this->get_evaluator_($comp);

	
			if($res->creators_type == 4){
			 $this->db->select('*');
			 $this->db->from('pms_scorecard_format_employeeportal a');
			 $this->db->join('employee_info b', 'a.employee_id = b.employee_id');
			 $this->db->join('department c', 'b.department = c.department_id');
			 $this->db->join('section d', 'b.section = d.section_id');
			 $this->db->join('location e', 'b.location = e.location_id');
			 $this->db->join('classification f', 'b.classification = f.classification_id');
			 $this->db->where('a.doc_no',$this->input->post('doc_no'));

			$res = $this->db->get();
			$employee_id = $res->row();
		
			$this->db->select('*');
			$this->db->from('transaction_approvers');
			$this->db->where('department',$employee_id->department_id);
			$this->db->where('classification',$employee_id->classification_id);
			$this->db->where('location',$employee_id->location_id);
			$this->db->where('section',$employee_id->section_id);

			$this->db->group_by(array("approver",'approval_level'));
			$this->db->order_by('approval_level','asc');
			// $this->db->where('approver !=','1753');
		
			$query = $this->db->get();
			$q=  $query->result();

			$bFirstTime = '1';
			 $qwe = array();

     		 $store = '';

			foreach($q as $e){
     if(!in_array($e->approver,$qwe)){
				  if ($bFirstTime == '1') {
	       					$datas = array(
								'evaluators'=>$e->approver,
								'doc_no'=>$this->input->post('doc_no'), 
								'eval_level'=>$e->approval_level,
								'status'=>'pending'
							);
							$store = $e->approval_level;
	      	
	 		   	  }elseif($bFirstTime == '0'){

     if($store == $e->approval_level){
	       					$datas = array(
								'evaluators'=>$e->approver,
								'doc_no'=>$this->input->post('doc_no'), 
								'eval_level'=>$e->approval_level,
								'status'=>'pending'
							 );
	       					     }else{

	       					      $datas = array(
		                         'evaluators'=>$e->approver,
		                         'doc_no'=>$this->input->post('doc_no'), 
		                         'eval_level'=>$e->approval_level,
		                         'status'=>''
                           );    	
	       					     }
   				 }
   		

   			$bFirstTime = '0';
			$this->db->insert('pms_evaluation_employeeportal', $datas);
			}
			    array_push($qwe,$e->approver); 
	 	    }
		
			}else{
			$this->db->select('*');
			$this->db->from('pms_form_evaluators');
			$this->db->where('company_id',$c);
			$this->db->group_by('evaluator');
			$this->db->order_by('evaluator','asc');
			$query = $this->db->get();
			$q=  $query->result();

			$bFirstTime = true;
			foreach($q as $e){

				  if ($bFirstTime) {
	       					$datas = array(
								'evaluators'=>$e->employee_id,
								'doc_no'=>$this->input->post('doc_no'), 
								'eval_level'=>$e->evaluator,
								'status'=>'pending'
							);
	      			  $bFirstTime = false;
	 		     }else{
	       					$datas = array(
								'evaluators'=>$e->employee_id,
								'doc_no'=>$this->input->post('doc_no'), 
								'eval_level'=>$e->evaluator,
								'status'=>''
					 );
   				 }
			$this->db->insert('pms_evaluation_employeeportal', $datas);
	 	    }
			}

						
			$this->db->select('*');
			$this->db->from('pms_settings_evalself a');
			$this->db->where('company_id',$c);
			$query = $this->db->get();
			$qs = $query->row();

					if($qs->self_eval=='1'){		

									$data = array(
			
				'doc_no'=>$this->input->post('doc_no'), 
			
				'status'=>'pending',
				'eid'=>$this->input->post('id'), 
						); 

								$this->db->insert('pms_evaluationself_employeeportal', $data);
									}



				
			
		
		

	
	}

	public function employee_evaluation4($company){
		$res =$this->get_evaluator_($company);

		if(!empty($res->creators_type) == 4){
			$this->db->select('*');
			$this->db->from('transaction_approvers');
			$this->db->where('approver', $this->session->userdata('employee_id'));
				$q = $this->db->get();
				$location = array();
				$department = array();	
				$section = array();
				$classification = array();

				foreach($q->result() as $s){
					$department[] = $s->department;
					$location[] = $s->location;
					$section[] = $s->section;
					$classification[] = $s->classification;
				}

			 $this->db->select('*');
			 $this->db->from('employee_info a');
			 $this->db->join('department b', 'a.department = b.department_id');
			 $this->db->join('section c', 'a.section = c.section_id');
			 $this->db->join('location d', 'a.location = d.location_id');
			 $this->db->join('classification e', 'a.classification = e.classification_id');
			 				$this->db->where('a.company_id',$company);
			if(!in_array('all',$department)){
				$this->db->where_in('b.department_id', $department);
			}
			if(!in_array('all',$section)){											
				$this->db->where_in('c.section_id', $section);
			}
			if(!in_array('all', $location)){
				$this->db->where_in('d.location_id', $location);
			}
			if(!in_array('all', $classification)){
				$this->db->where_in('e.classification_id', $classification);
			}

				$query = $this->db->get();

				return $query->result();


		}elseif(!empty($res->creators_type) == 2){
			$this->db->select('*');
			$this->db->from('pms_form_evaluators');
			$this->db->where('evaluator_id', $this->session->userdata('employee_id'));
			$this->db->where('a.company_id',$company);
				$q = $this->db->get();
				$location = array();
				$department = array();
				
				$section = array();
				$classification = array();
				foreach($q->result() as $s){
					$department[] = $s->department_id;
					$location[] = $s->location_id;
					$section[] = $s->section_id;
					$classification[] = $s->classification_id;
				}

			$this->db->select('*');
			$this->db->from('employee_info a');
			 $this->db->join('department b', 'a.department = b.department_id');
			 $this->db->join('section c', 'a.section = c.section_id');
			 $this->db->join('location d', 'a.location = d.location_id');
			 $this->db->join('classification e', 'a.classification = e.classification_id');
			 	// $this->db->join('pms_evaluation_employeeportal f', 'a.evaluator_id = f.evaluators');
if(!in_array('all',$department)){
			$this->db->where_in('b.department_id', $department);
			

			}
			if(!in_array('all',$section)){
			$this->db->where_in('c.section_id', $section);
			}
			
			if(!in_array('all', $location)){
$this->db->where_in('d.location_id', $location);
			}
			
if(!in_array('all', $classification)){
			$this->db->where_in('e.classification_id', $classification);
		}

				$query = $this->db->get();

		return $query->result();
	}

			 	// $this->db->join('pms_scorecard_format_employeeportal g', 'f.doc_no = g.doc_no');
			 	// $this->db->join('employee_info h', 'a.evaluator_id = h.employee_id',);
			 	// $this->db->group_by('h.fullname');

			// $this->db->where('a.evaluator_id', $this->session->userdata('employee_id'));

	}




	public function employee_evaluation($employee_id){
	
			$this->db->select('*,a.status as status');
			$this->db->from('pms_evaluation_employeeportal a');
			$this->db->join('pms_scorecard_format_employeeportal b', 'a.doc_no = b.doc_no');
			$this->db->join('employee_info c', 'b.employee_id = c.employee_id');
			$this->db->where('a.evaluators', $this->session->userdata('employee_id'));
			$this->db->where('b.employee_id', $employee_id);
			$this->db->where('b.appraisal_period_type_dates >=', date('y-m-d'));  
			//$this->db->where('eval_level',$q->eval_level);
			$this->db->where('a.status!=','done');
			$this->db->where('a.status!=','');

			$this->db->group_by('c.fullname');
	

		
		$query = $this->db->get();

		return $query->result();

	}	
	
	public function get_general_forms_creator($id){


		$this->db->select('*');
		$this->db->from('pms_scorecard_format_employeeportal');
		$this->db->where('employee_id',$id);
		$query1 = $this->db->get();
		$q =  $query1->row();
		if(!empty($q)){
	

		$this->db->select('*');
		$this->db->from('pms_general_form_employeeportal');
		$this->db->where('doc_no',$q->doc_no);

		$query = $this->db->get();

		return $query->result();
	}

	}


	public function get_general_forms($c){
		$this->db->where('company_id', $c);
		$query = $this->db->get('pms_appraisal_form');

		return $query->result();
	}
			public function get_weight($id,$job_level){
		$this->db->select('*');
		$this->db->where('fid',$id);
		$this->db->where('job_level',$job_level);
		$query = $this->db->get('pms_job');
		return $query->row();
	}


	public function get_emp_ratee($employee_id){
		$this->db->where("B.employee_id", $employee_id);
		$this->db->join('basic_info_view A', 'A.employee_id = B.employee_id');
		$this->db->order_by('B.employee_id');
		$query = $this->db->get('pms_scorecard_creator_ratee B');
		
		return $query->row();
	}
	public function form_saved($doc_no,$fid){

		$this->db->select('*');
		$this->db->from('pms_eval_score_employeeportal');	
		$this->db->where('fid',$fid);
		$queryq = $this->db->get();
		$s = $queryq->num_rows();

		if($s > 0){


		$this->db->select('*');
		$this->db->from('pms_eval_score_employeeportal');
		$this->db->where('ref',$doc_no);
		$this->db->where('fid',$fid);
		$this->db->where('score','0');

		$query = $this->db->get();
		$qs = $query->num_rows();
		if($qs <= 0){
		return 'true';
		}else{
			return 'false';
		}
	
	}else{
		return 'false';
	}

	}

	public function get_general_forms_admin($id){
		$this->db->select('*');
		$this->db->from('pms_scorecard_format_employeeportal a');
		$this->db->join('pms_employee_forms_employeeportal b ', 'a.doc_no = b.doc_no');
		$this->db->where('a.employee_id',$id);
		$this->db->where('a.appraisal_period_type_dates >=', date('y-m-d'));

		$query1 = $this->db->get();
		$q =  $query1->row();
		if(!empty($q)){
	

		$this->db->select('*');
		$this->db->from('pms_employee_forms_employeeportal a');
		$this->db->where('a.doc_no',$q->doc_no);
		$this->db->order_by('a.form_part','asc');
		$query = $this->db->get();
		return $query->result();
	}
	}

	public function get_ratee(){
		$this->db->where('sc_creator_employee_id', $this->session->userdata('employee_id'));
		$this->db->join('employee_info A', 'A.employee_id = B.employee_id');
		$this->db->join('position C', 'A.position = C.position_id');
		$query = $this->db->get('pms_scorecard_creator_ratee B');

		return $query->result();
	}

	public function get_emp_form($employee_id){
		$this->db->where('A.employee_id', $employee_id);
		$this->db->join('pms_employee_forms_employeeportal B', 'A.doc_no = B.doc_no');
		$this->db->order_by('B.form_part','ASC');
		$query = $this->db->get('pms_scorecard_format_employeeportal A');

		return $query->result();
	}	

	public function get_general_form_info($id){
		$this->db->where('id', $id);
		$query = $this->db->get('pms_form_parts');

		return $query->row();
	}

	public function get_general_score_criteria($part_number){
		$this->db->where('form_part_id', $part_number);
		$this->db->where('InActive', 0);
		$query = $this->db->get('pms_form_parts_score_criteria');

		return $query->result();
	}

	public function get_position_areas($employee_id, $part_number, $position){
		$this->db->where('form_part_id', $part_number);
		$this->db->where("(position_id='general' OR position_id='".$position."' OR position_id='".$employee_id."')", NULL, false);
		$query = $this->db->get('pms_position_areas');

		return $query->result();
	}

	public function get_total_weight($employee_id, $id, $position){
		$this->db->select('SUM(area_weight) as total');
		$this->db->where('form_part_id', $id);
		$this->db->where("(position_id='general' OR position_id='".$position."' OR position_id='".$employee_id."')");
		$query = $this->db->get('pms_position_areas');

		return $query->row();
	}

	public function get_total_weight_form($employee_id){
		$this->db->select('SUM(B.form_weight) as total_weight');
		$this->db->where('A.employee_id', $employee_id);
		$this->db->join('pms_form_details B', 'A.form_part_id = B.id');
		$query = $this->db->get('pms_form_scorecard A');

		return $query->row();
	}

	// public function add_general_form($employee_id, $form_id, $pos_area, $score_criteria){
	// 	$doc_no = date('YmdH:i:s')."_$employee_id";//'PMS_'. $this->session->userdata('employee_id') . '_' . date('Y-m-d');
	// 	$form_data = $this->get_general_form_info($form_id);

 //     	$this->db->insert('pms_form_details',
 //  			array( 	"employee_id" => $employee_id,
	//   				'part_name' => $form_data->part_name,
	//   				"part_number" => $form_data->part_number,
	//   				"part_desc" =>$form_data->part_desc,
	//          		"form_weight" => $form_data->form_weight,
	//          		"instructions" => $form_data->instructions,
	//          		"date_added" => date('Y-m-d H:i:s')
 //            )
 //      	);
         
 //    	$form_part_id = $this->db->insert_id();

 //    	for($i = 0; $i < count($score_criteria); $i++)
 //    	$this->db->insert('pms_form_details_score_criteria',
 //      		array( 	"form_part_id" => $form_part_id,
 //      				'score' => $score_criteria[$i]['score'],
 //      				"score_equivalent" => $score_criteria[$i]['score_equivalent'],
 //             		"score_guide" => $score_criteria[$i]['score_guide'],
 //             		"date_added" => date('Y-m-d H:i:s')
 //            )
 //      	);

 //    	for($i = 0;$i < count($pos_area); $i++)
 //    	$this->db->insert('pms_form_score',
 //      		array( 	'form_part_id' => $form_part_id,
 //      				"pos_area" => $pos_area[$i]['pos_area'],
 //      				"area_desc" => $pos_area[$i]['area_desc'],
 //      				"area_weight" => $pos_area[$i]['area_weight'],
 //             		"score" => 0,
 //             		"rating" => 0
 //            )
	// 	);

	// 	$data = array(
	// 		'employee_id' => $employee_id,
	// 		'creator_id' => $this->session->userdata('employee_id'),
	// 		'company_id' => $this->session->userdata('company_id'),
	// 		'doc_no' => $doc_no,
	// 		'form_part_id' => $form_part_id,
	// 		'total_rating' => 0,
	// 		'status' =>	'pending',
	// 		// 'date_from' => date('Y-m-d H:i:s'),
	// 		// 'date_to' => date('Y-m-d H:i:s'),
	// 		'date_created' => date('Y-m-d H:i:s'),
	// 	);

	// 	$this->db->insert('pms_form_scorecard', $data);
	// 	//$this->insert_approvers($doc_no, $employee_id, $form_part_id);
	// }

	public function get_first_approvers($employee_id){
		$me = $this->get_emp_info($this->session->userdata('employee_id'));
		$has_subsection = $this->has_subsection($me->section);
		$has_division = $this->has_division($this->session->userdata('company_id'));
		
		$this->db->where('company_id', $me->company_id);
		$this->db->where('department', $me->department);
		$this->db->where('section', $me->section);
		$this->db->where('classification', $me->classification);
		$this->db->where('location', $me->location);
		$this->db->where('evaluee_id', $employee_id);
		$this->db->where('InActive', 0);

		if ($has_subsection){
			$this->db->where('subsection', $me->subsection);
		}

		if ($has_division){
			$this->db->where('division', $me->division_id);
		}

		$query = $this->db->get('pms_form_parts_approver');
		return $query->result();
	}

	public function setting_nxt_approvers($doc_no){
		$this->db->select_min('approval_level');
		$this->db->from("pms_form_request_approval");
		$this->db->where('doc_no', $doc_no);

		$query = $this->db->get();
		$id = $query->row('approval_level');

		$data = array('status_view' => 'ON','submitted_on'=>date('Y-m-d'));

		$this->db->where(array('approval_level'=> $id,'doc_no' => $doc_no));
		$update = $this->db->update("pms_form_request_approval", $data);
	}

	public function insert_approvers($doc_no, $employee_id, $form_part_id){
		$first_approvers = $this->get_first_approvers($employee_id, $form_part_id);

		foreach ($first_approvers as $approver) {
			$this->data = array(
				'doc_no'				=>			$doc_no,
				'form_part_id'			=>			$form_part_id,
				'approver_id'			=>			$approver->employee_id,
				'approval_level'		=>			$approver->approval_level,
				'status'				=>			'pending',
				'status_view'			=>			'OFF',
				'original_approver'     => 			$approver->employee_id
				);
			
			$this->db->insert('pms_form_request_approval', $this->data);
		}

		$setting_nxt_approvers = $this->setting_nxt_approvers($doc_no);
	}

	public function get_form_details($id){
		$this->db->select('*');
		$this->db->where('A.doc_no', $id);
		$this->db->join('pms_scorecard_format_employeeportal B', 'A.doc_no = B.doc_no');

		$query = $this->db->get('pms_employee_forms_employeeportal A');

		return $query->row();
	}

	public function get_form_score_criteria($id){
		$this->db->where('form_part_id', $id);
		$query = $this->db->get('pms_form_details_score_criteria');

		return $query->result();
	}

	public function get_form_score($form_part_id,$fid,$doc_no){
	
		$this->db->select('*');
		$this->db->from('pms_scorecard_format_employeeportal a');
		$this->db->join('pms_employee_forms_employeeportal b', 'a.doc_no = b.doc_no');
		$this->db->join('pms_criteria_form_from_admin_employeeportal c', 'a.doc_no = c.doc_no');

			// $this->db->join('pms_area_weight_from_admin_employeeportal d', 'd.cid = c.cid');
				// $this->db->join('pms_score_employeeportal e', 'e.cid = d.cid');


		$this->db->where('a.employee_id',$form_part_id);
		$this->db->where('c.fid',$fid);
				$this->db->where('b.doc_no',$doc_no);
		$this->db->group_by('c.criteria_id');


		  $qwe = $this->db->get();
		

		return $qwe->result();
	}
	public function criteira_s($q,$doc_no,$grading_type){
		$this->db->select('*');
		$this->db->from('pms_area_weight_from_admin_employeeportal a');
		$this->db->join('pms_score_employeeportal b', 'b.cid = a.id','left');
		if($grading_type ==2){
		$this->db->join('pms_grading_table_from_admin_employeeportal f', 'b.score = f.ranking');
		}elseif($grading_type==  1){
		$this->db->join('pms_grading_table_from_admin_employeeportal f', 'b.score = f.score');	
		}
		$this->db->where('a.cid',$q);
		$this->db->where('a.doc_no',$doc_no);
		$this->db->group_by('b.id');


	    $qwe = $this->db->get();
		return  $qwe->result();;
	}

	public function get_total_weight_score($id){
		$this->db->select('SUM(area_weight) as total');
		$this->db->where('form_part_id', $id);
		$query = $this->db->get('pms_form_score');

		return $query->row();
	}

	public function check_part_number($x, $employee_id){
		$this->db->select('part_number');
		$this->db->where('part_number', $x);
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('pms_form_details');

		return $query->row();
	}

	public function add_pos_area($id, $pos_area, $area_desc, $weight){
		$data = array(
			'form_part_id' => $id,
			'pos_area' => $pos_area,
			'area_desc' => $area_desc,
			'area_weight' => $weight,
			'score' => 0,
			'rating' => 0
		);

		$this->db->insert('pms_form_score', $data);
	}

	public function get_pos_area($id){
		$this->db->where('id', $id);
		$query = $this->db->get('pms_form_score');

		return $query->row();
	}

	public function update_pos_area($id, $pos_area, $area_desc, $weight){
		$data = array(
			'pos_area' => $pos_area,
			'area_desc' => $area_desc,
			'area_weight' => $weight
		);

		$this->db->update('pms_form_score', $data, "id ='".$id."'");
	}

	public function delete_pos_area($id){
		$this->db->where('id', $id);
		$this->db->delete('pms_form_score');
	}
	
	public function update_form($id){
		$data = array(
			'evaluation_status' => 1,
			'status' => 'pending',
		);

		$this->db->update('pms_form_scorecard', $data, "form_part_id ='".$id."'");
	}

	public function create_form($employee_id, $part_num, $part_name, $weight, $instructions, $part_desc){
		$doc_no = date('YmdH:i:s')."_$employee_id";//'PMS_'. $this->session->userdata('employee_id') . '_' . date('Y-m-d');

		$data = array(			
			'employee_id' => $employee_id,
			'part_number' => $part_num,
			'part_name' => $part_name,
			'part_desc' => $part_desc,
			'form_weight' => $weight."%",
			'instructions' => $instructions,
			'date_added' => date("Y-m-d h:i:sa")
		);

		$this->db->insert('pms_form_details', $data);

		$form_part_id = $this->db->insert_id();

		$data = array(
			'employee_id' => $employee_id,
			'creator_id' => $this->session->userdata('employee_id'),
			'company_id' => $this->session->userdata('company_id'),
			'doc_no' => $doc_no,
			'form_part_id' => $form_part_id,
			'total_rating' => 0,
			'remark' => 'Not Ready for Evaluation',
			'remark_eval' => 'Not Ready for Approval',
			'status' =>	'pending',
			// 'date_from' => date('Y-m-d H:i:s'),
			// 'date_to' => date('Y-m-d H:i:s'),
			'date_created' => date('Y-m-d H:i:s'),
		);

		$this->db->insert('pms_form_scorecard', $data);
		$this->insert_approvers($doc_no, $employee_id, $form_part_id);
	}

	public function save_edit_form_details(){
		$form_weight = $this->input->post("form_weight")."%";
		$part_name = $this->input->post("part_name");
		$instructions = $this->input->post("instructions");
		$part_number = $this->input->post("part_number");
		$part_desc = $this->input->post("part_desc");
		$id = $this->input->post("id");

		$data = array(
			'instructions' => $instructions,
			'form_weight' => $form_weight,
			'part_name' => $part_name,
			'part_number' => $part_number,
			'part_desc' => $part_desc,
			'date_updated' => date("Y-m-d h:i:sa")
		);

		$this->db->update('pms_form_details', $data, "id ='".$id."'");
	}

	public function get_form_criteria($id,$doc_no){

		$this->db->where('fid', $id);
		$this->db->where('doc_no', $doc_no);
		$query = $this->db->get('pms_grading_table_from_admin_employeeportal');

		return $query->result();
	}

	public function get_form_criteria_details($id){
		$this->db->where('A.id', $id);
		$this->db->join('pms_form_details B', 'A.form_part_id = B.id');
		$query = $this->db->get('pms_form_details_score_criteria A');

		return $query->row();
	}

	public function check_form_criteria($id){
		$this->db->where('form_part_id', $id);
		$query = $this->db->get('pms_form_details_score_criteria');

        if($query->num_rows() > 0){
         	return true;
        } else {
        	return false;
        }
	}

	public function check_form_score($id){
		$this->db->where('form_part_id', $id);
		$query = $this->db->get('pms_form_score');

        if($query->num_rows() > 0){
         	return true;
        } else {
        	return false;
        }
	}

	public function check_score_number($x,$form_part_id){
		$this->db->where('score', $x);
		$this->db->where('form_part_id', $form_part_id);
		$query = $this->db->get('pms_form_details_score_criteria');

		return $query->row();
	}

	public function save_form_score(){
		$data = array(
			'score'					=> $this->input->post('score'),
			'score_equivalent'		=> $this->input->post('score_equivalent'),
			'form_part_id'			=> $this->input->post('form_part_id'),
			'score_guide'			=> $this->input->post('score_guide'),
			'date_added'			=> date("Y-m-d h:i:sa")
		);

		$this->db->insert('pms_form_details_score_criteria', $data);
	}

	public function save_edit_form_score(){
		$score=$this->input->post("score");
		$score_equivalent=$this->input->post("score_equivalent");
		$score_guide=$this->input->post("score_guide");
		$id=$this->input->post("id");

		$data = array(
			'score' => $score,
			'score_equivalent' => $score_equivalent,
			'score_guide' => $score_guide
		);

		$this->db->update('pms_form_details_score_criteria', $data, "id ='".$id."'");
	}

	public function delete_form_score($id){
		$this->db->where('id',$id);
		$this->db->delete('pms_employee_portal_general_form');
	}

	public function delete_form($id){
		$this->db->where('id',$id);
		$this->db->delete('pms_form_details');

		$this->db->where('form_part_id',$id);
		$this->db->delete('pms_form_details_score_criteria');

		$this->db->where('form_part_id',$id);
		$this->db->delete('pms_form_score');

		$this->db->where('form_part_id',$id);
		$this->db->delete('pms_form_scorecard');

		$this->db->where('form_part_id',$id);
		$this->db->delete('pms_form_request_approval');
	}

	public function getAppPeriod($employee_id){
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('pms_form_scorecard');

		return $query->row();
	}

	public function updateAppPeriod($emp_id, $from, $to){
		$data = array(
			'date_from' => $from,
			'date_to' => $to
		);

		$this->db->update('pms_form_scorecard', $data, 'employee_id="'.$emp_id.'"');
	}


	// EVALUATION
	public function is_form_employee($employee_id){


	if((!$this->is_scorecard_creator($employee_id)) AND (!$this->is_form_evaluator($employee_id)) AND (!$this->is_form_approver($employee_id))){
		return true;
		
	}else{
		return false;
	}
	
		
	}





				
				


	public function is_form_evaluator($employee_id){
	
			$this->db->where('evaluator_id', $employee_id);
		// $this->db->where('company_id', $this->session->userdata('company_id'));
		// $this->db->where('InActive', 0);
						$query = $this->db->get('pms_form_evaluators');
						$qwe = $query->num_rows();


								$this->db->where('approver', $employee_id);
		// $this->db->where('company_id', $this->session->userdata('company_id'));
		// $this->db->where('InActive', 0);
						$querys = $this->db->get('transaction_approvers');
						$s = $querys->num_rows();

							if($qwe > 0){
								return true;
							}elseif($s > 0){
								return true;
							}else{
								return false;
							}
	
			
	}

	public function get_emp_eval($employee_id){

		$this->db->where('A.evaluator_id', $employee_id);
		$this->db->join('pms_form_scorecard B', 'A.form_part_id = B.form_part_id');
		$this->db->join('pms_form_details C', 'C.id = B.form_part_id');
		$this->db->join('pms_form_parts_evaluator D', 'D.employee_id = A.evaluator_id');
		$this->db->join('employee_info E', 'E.employee_id = D.evaluee_id');
		$query = $this->db->get('pms_form_score_evaluator A');

		return $query->result();
	}

	public function get_min_emp_eval($employee_id){
		$this->db->where('A.employee_id', $employee_id);
		$this->db->join('employee_info B', 'B.employee_id = A.evaluee_id');
		$this->db->join('pms_form_scorecard C', 'C.employee_id = A.evaluee_id');
		$this->db->order_by('C.form_part_id, C.employee_id');
		$query = $this->db->get('pms_form_parts_evaluator A', 1);

		return $query->result();
	}
	public function get_ref($q){
				$this->db->where('evaluators', $this->session->userdata('employee_id'));
		$this->db->where('doc_no',$q);
		$query = $this->db->get('pms_evaluation_employeeportal' );
		return $query->row();
	}

	// public function appro($doc_no){
	// 				$this->db->select('*');
	// 				$this->db->from('pms_approval_employeeportal');
	// 				$this->db->where('doc_no',$doc_no);
	// 				$this->db->where('status!=','pending');
	// 				$this->db->where('status!=','done');
	// 				$query = $this->db->get();

	// 				return $query->row();


	// }
	public function max_id($doc_no,$e){
					$this->db->select_max('eval_level');
					$this->db->from('pms_evaluation_employeeportal');
					$this->db->where('doc_no',$doc_no);
					$this->db->where('evaluators',$e);
			
					$query = $this->db->get();

		return $query->row();


	}
	public function evals($doc_no){
					$this->db->select('*');
					$this->db->from('pms_evaluation_employeeportal');
					$this->db->where('doc_no',$doc_no);
					$this->db->where('status!=','pending');
					$this->db->where('status!=','done');
					$query = $this->db->get();

		return $query->row();


	}

	public function next_eval(){
			// $s =array('created_by' => '');
			// 	$this->db->where("doc_no", $this->input->post('refe'));

			// $this->db->update('pms_finalscore_employeeportal', $s);
			
			if($this->input->post('l') == $this->input->post('eval')){
			$data1 =array('status' => 'done');
			$this->input->post('eval');
			$this->db->where("doc_no", $this->input->post('refe'));
			$this->db->where("eval_level", $this->input->post('l'));
			$this->db->update('pms_evaluation_employeeportal', $data1);


			}else{
			$data1 =array('status' => 'done');
			$this->input->post('eval');
			$this->db->where("doc_no", $this->input->post('refe'));
			$this->db->where("eval_level", $this->input->post('l'));
			$this->db->update('pms_evaluation_employeeportal', $data1);


			$data2 =array('status' => 'pending');

			$this->db->where("doc_no", $this->input->post('refe'));
			$this->db->where("eval_level",  $this->input->post('eval'));
			$this->db->update('pms_evaluation_employeeportal', $data2);
			}

				

				$data = array(
				'employee_id'=>$this->input->post('employid'),
				'evaluator'=>$this->session->userdata('employee_id'),
				'date'=>date("Y-m-d h:i:sa"),
				'status'=>'completed',
				'doc_no'=>$this->input->post('refe')

			

		
				);
		
		$this->db->insert('pms_history_eval_employeeportal', $data);
				
			
	}
		public function qwe(){
			// $s =array('created_by' => '');
			// 	$this->db->where("doc_no", $this->input->post('refe'));

			// $this->db->update('pms_finalscore_employeeportal', $s);
			

					$this->db->select('*,a.id as id');
					$this->db->from('pms_evaluation_employeeportal a');
	
					
					$this->db->join('pms_scorecard_format_employeeportal b', 'b.doc_no = a.doc_no');
					$this->db->where('appraisal_period_type_dates <', date('y-m-d'));
					$this->db->where('a.status !=','completed');

					$q = $this->db->get();
					$qw = $q->result();
					foreach($qw as $q){
								$data = array(
						'employee_id'=>$q->employee_id,
						'evaluator'=>$q->evaluators,
						'date'=>$q->appraisal_period_type_dates,
						'status'=>'missed',
						'doc_no'=>$q->doc_no

		

		
				);
								$this->db->insert('pms_history_eval_employeeportal', $data);
								$this->db->where(array(
								'id' => $q->id
						
								));

								$this->db->delete('pms_evaluation_employeeportal');
					}


				
			
	}
	public function history_eval(){
			$this->db->select('*');
			$this->db->from('pms_history_eval_employeeportal a ');
			$this->db->join('employee_info b', 'a.employee_id = b.employee_id');
			$this->db->where('evaluator',$this->session->userdata('employee_id'));

			$query = $this->db->get();
 
			return $query->result();

	}

	public function get_emp_evaluee($employee_id){
		$this->dbp->where("B.evaluee_id", $employee_id);
		$this->db->join('basic_info_view A', 'A.employee_id = B.evaluee_id');
		$query = $this->db->get('pms_evaluee_mngt B');
		
		return $query->row();
	}
	public function reject_eval(){



			$data =array('form_tagging' => 'cancelled');

			$this->db->where("doc_no", $this->input->post('refe'));
			$this->db->update('pms_scorecard_format_employeeportal', $data);
	}

	public function get_emp_forms($form_id){
		$this->db->where('A.form_part_id', $form_id);
		$this->db->join('pms_form_details B', 'B.id = A.form_part_id');
		$this->db->order_by('B.part_number','ASC');
		$query = $this->db->get('pms_form_scorecard A');

		return $query->row();
	}

	// public function get_remark_eval($doc_no){
	// 	$this->db->where('doc_no', $doc_no);
	// 	$query = $this->db->get('pms_form_scorecard');

	// 	return $query->row('remark_eval');
	// }

	public function update_scores(){
		$id = $this->input->post('id');
		$score = $this->input->post('score');
		$rating = $this->input->post('rating');
		$total_rating = $this->input->post('total_rating');
		$form_part_id = $this->input->post('form_part_id');

		$data = array(
			'score' => $score,
			'rating' => $rating
		);
		
		$this->db->where('id', $id);
		$this->db->update('pms_form_score', $data);

		$total_rating = array(
			'total_rating' => $total_rating,
		);

		$this->db->where('form_part_id', $form_part_id);
		$this->db->update('pms_form_scorecard', $total_rating);
	}

	public function update_eval_form(){
		$doc_no = $this->input->post('doc_no');
		$form_id = $this->input->post('form_id');

		$this->db->where(array(
			'doc_no' => $doc_no,
			'form_part_id' => $form_id
		));

		$data = array(
			'approval_status' => 1,
		);

		$this->db->update('pms_form_scorecard', $data);
	}

	public function add_recommendation($doc_no, $recommendation, $from, $to){
		$data = array(
			'doc_no' => $doc_no,
			'recommendations' => $recommendation,
			'date_from' => $from,
			'date_to' => $to,
			'date_created' => date("Y-m-d h:i:sa")
		);

		$this->db->insert('pms_form_recommendation', $data);
	}

	public function delete_recommendation($id){
		$this->db->where('id', $id);
		$this->db->delete('pms_form_recommendation');
	}



	// FORM APPROVAL
	public function is_scorecard_creator($employee_id){



			
					$this->db->where('creator', $employee_id);
		// $this->db->where('company_id', $this->session->userdata('company_id'));
		// $this->db->where('InActive', 0);
						$query = $this->db->get('pms_creators_option2');
						$qwe = $query->num_rows();


								$this->db->where('approver', $employee_id);
		// $this->db->where('company_id', $this->session->userdata('company_id'));
		// $this->db->where('InActive', 0);
						$querys = $this->db->get('transaction_approvers');
						$s = $querys->num_rows();

							if($qwe > 0){
								return true;
							}elseif($s > 0){
								return true;
							}else{
								return false;
							}
		
	
	}
	public function is_form_approver($employee_id){
					$this->db->where('approver_id', $employee_id);
		// $this->db->where('company_id', $this->session->userdata('company_id'));
		// $this->db->where('InActive', 0);
						$query = $this->db->get('pms_form_approvers');
						$qwe = $query->num_rows();


								$this->db->where('approver', $employee_id);
		// $this->db->where('company_id', $this->session->userdata('company_id'));
		// $this->db->where('InActive', 0);
						$querys = $this->db->get('transaction_approvers');
						$s = $querys->num_rows();

							if($qwe > 0){
								return true;
							}elseif($s > 0){
								return true;
							}else{
								return false;
							}
	}

	public function get_forms_pending(){
		$this->db->where(array(
			'A.approver_id'				=>			$this->session->userdata('employee_id'),
			'A.status'					=>			'pending',
			'A.status_view'				=>			'ON',
			'B.evaluation_status' 		=> 			1
			));

		$this->db->join('pms_form_scorecard B', 'A.doc_no = B.doc_no');
		$this->db->join('employee_info C', 'B.creator_id = C.employee_id');
		$this->db->join('pms_form_details D', 'D.id = B.form_part_id');
		//$this->db->join('employee_info D', 'A.approver_id = D.employee_id');
		$query = $this->db->get('pms_form_request_approval A', 1);

		return $query->result();
	}
		public function get_overall_details($doc_no, $form_part_id){
		$this->db->select('A.*,B.*, ROUND((form_weight * total_rating * .01),2) as part_rating');
		$this->db->where('A.doc_no', $doc_no);
		$this->db->join('pms_form_details B', 'B.id = A.form_part_id');
		$query = $this->db->get('pms_form_scorecard A');

		return $query->result();
	}
	// public function get_overall_details($doc_no, $form_part_id){
	// 	$form = $this->get_form_details($form_part_id);
	// 	$form_details = $this->get_form_det($doc_no);
	// 	$form_weight = $this->get_form_weight($doc_no);
	// 	$recommendation = $this->get_recommendation($doc_no);
	// 	$filer = $this->get_employee_details($form->employee_id);

	// 	$info = new \stdClass;

	// 	$info->filer = $filer;		
	// 	$info->form = $form;
	// 	$info->form_det = $form_details;
	// 	$info->weight = $form_weight;
	// 	$info->recommendation = $recommendation;

	// 	return $info;
	// }

	public function grading_type(){
		$this->db->select('*');
		$this->db->from('pms_employee_forms_employeeportal a');
		$this->db->join('pms_scorecard_format_employeeportal c', 'a.doc_no = c.doc_no');

		$this->db->where('c.company_id',$this->session->userdata('company_id'));
	
		$query = $this->db->get();
		return $query->row();
	
	}
	public function get_form_det($doc_no){
		$this->db->select('*');
		$this->db->where('A.doc_no', $doc_no);
	

		$query = $this->db->get('pms_finalscore_employeeportal A');

		return $query->result();
	}


	public function get_form_weight($doc_no){
		$this->db->select('SUM(form_weight) as total_weight, ROUND(SUM(form_weight * A.total_rating * .01), 2) as total_ratings, A.*');
		$this->db->where('A.doc_no', $doc_no);
		$this->db->join('pms_form_details B', 'B.id = A.form_part_id');
		$query = $this->db->get('pms_form_scorecard A');

		return $query->row();
	}
	public function mass_res($status,$doc_no){
		if($status =='approve'){


		$data1 =array('status' => 'done');
		$this->db->where('doc_no',$doc_no);
		$this->db->where('status', 'pending'); 
		$this->db->where('approvers', $this->session->userdata('employee_id'));
		$this->db->update('pms_approval_employeeportal', $data1);
	}
	}
	

public function next_appro($appro){

			$this->db->select_max('appro_level');
			$this->db->from('pms_approval_employeeportal');
			$this->db->where('doc_no', $this->input->post('doc_no'));
			$query = $this->db->get();

		    $s = $query->row();
	     	if($s->appro_level==$this->input->post('appro_level'))
	     	{
				foreach($this->input->post('form_title_array') as $val => $q){
						$data = array(
								'form_title'=>$q,
								'weight'=>$this->input->post('weight_array')[$val],
								'part_rating'=>$this->input->post('score_array')[$val],
								'total_rating'=>$this->input->post('total_array')[$val],
								'doc_no'=>$this->input->post('doc_no'),
								'form_part'=>$this->input->post('c_form_part')[$val]
						);
							
			   $this->db->insert('pms_finalscore_employeeportal', $data);
	       }

		   $portal =array('status' => 'approved');
		   $this->db->where("doc_no", $this->input->post('doc_no'));
           $this->db->update('pms_scorecard_format_employeeportal', $portal);
	   	   $data4 = array(

			'doc_no'=>$this->input->post('doc_no'),
			'score'=>$this->input->post('score_total'),
			'score_equivalent'=>$this->input->post('score_equivalent')

		   );
		   $lanaya = array(

			'doc_no'=>$this->input->post('doc_no'),
			'agreement'=>'no agreement',
	   	   );

			$this->db->insert('pms_agree_employeeportal', $lanaya);
			$this->db->insert('pms_totalfinalscore_employeeportal', $data4);


			foreach($this->input->post('c_score_array') as $vals => $qs){
							$data4 = array(
									'score'=>$qs,
									'rating'=>$this->input->post('rate_array')[$vals],
									'cid'=>$this->input->post('c_cid_array')[$vals],
									'doc_no'=>$this->input->post('doc_no')

				            );
			$this->db->insert('pms_score_employeeportal', $data4);	
		   }


		   $data4 = array(
				'employee_id'=>$this->input->post('c_employee_id'),
				'approver'=>$this->session->userdata('employee_id'),
				'date'=>date("Y-m-d h:i:sa"),
				'status'=>'approved',
				'doc_no'=>$this->input->post('doc_no')
				);
			$this->db->insert('pms_history_approved_employeeportal', $data4);
			
			$data1 =array('status' => 'done');
			$this->db->where("doc_no", $this->input->post('doc_no'));
			// $this->db->where("appro_level", $this->input->post('appro_level'));
			$this->db->update('pms_approval_employeeportal', $data1);					
		
		}else{

			$data1 =array('status' => 'done');
		
			$this->db->where("doc_no", $this->input->post('doc_no'));
			$this->db->where("appro_level", $this->input->post('appro_level'));
			$this->db->update('pms_approval_employeeportal', $data1);


			$data2 =array('status' => 'pending');

			$this->db->where("doc_no", $this->input->post('doc_no'));
			$this->db->where("appro_level", $appro);
			$this->db->update('pms_approval_employeeportal', $data2);
		}


			
	}

public function s($doc_no,$employee_id){
		$this->db->select('*');
		$this->db->from('pms_approval_employeeportal');
		$this->db->join('employee_info c', 'pms_approval_employeeportal.approvers = c.employee_id');
		$this->db->where('pms_approval_employeeportal.doc_no', $doc_no);


		$query = $this->db->get();

		return $query->result();
	}
public function get_employee_details($employee_id){
		$this->db->select('employee_id, first_name, last_name, middle_name, isApplicant, picture, classification_name, subsection_name, dept_name, section_name, location_name, position_name, division_name, employment_name');
		$this->db->where('employee_id', $employee_id);
		$query = $this->db->get('basic_info_view', 1);

		return $query->row();
	}
public function sup($doc_no,$employee_id){
		$this->db->select('*');
		$this->db->from('pms_evaluation_employeeportal');
		$this->db->join('employee_info c', 'pms_evaluation_employeeportal.evaluators = c.employee_id');
		$this->db->where('pms_evaluation_employeeportal.doc_no', $doc_no);


		$query = $this->db->get();

		return $query->result();
	}


	public function respond(){
		$status = $this->input->post('status');
		$table_name = $this->input->post('table');
		$doc_no = $this->input->post('doc_no');
		$comment = $this->input->post('comment');
		$filer_id = $this->input->post('filer_id');
		$identification = $this->input->post('identification');

		$current_level = $this->get_approval_level($table_name, $doc_no, $filer_id);
		$filer = $this->get_emp_info($filer_id);
		$has_subsection = $this->has_subsection($filer->section);
		$has_division = $this->has_division($filer->company_id);
		
		$type = 'Manual Approval';
		$this->update_approval_table($status, $comment, $table_name, $current_level, $doc_no, $type); //update table

		if (($status == 'cancelled') || ($status == 'rejected'))
		{
			$this->update_main($table_name, $status, $doc_no, $comment);
		}
		else
		{
			$next_level = $this->get_next_level($filer, $current_level, $identification, $has_subsection, $has_division);
			if (empty($next_level)) //LAST APPROVER
			{
				$this->update_main($table_name, $status, $doc_no, $comment);
			}
			else
			{
				$this->db->select_min('approval_level');
				$this->db->from($table_name);
				$this->db->where(array('doc_no' => $doc_no,'status'=>'pending','status_view'=>'OFF'));
				$query = $this->db->get();
				$id=$query->row('approval_level');
				$data =array('status_view' => 'ON','submitted_on'=>date('Y-m-d'));

				$this->db->where(array('approval_level'=> $id,'doc_no' => $doc_no));
				$update = $this->db->update($table_name, $data);
			}
		}
	}
	public function employee_approver($company){
			$res =$this->get_approver_($company);
			$this->db->select('*');
			$this->db->from('pms_approval_employeeportal a');
			$this->db->join('pms_scorecard_format_employeeportal h', 'a.doc_no = h.doc_no');
			

			if($res->creators_type == 4){
			$this->db->join('transaction_approvers b', 'a.appro_level = b.approval_level');
			}else{
			$this->db->join('pms_form_approvers b', 'a.appro_level = b.approval_level');	
			}
			$this->db->join('employee_info c', 'h.employee_id = c.employee_id');
			$this->db->join('classification d', 'c.classification = d.classification_id');
			$this->db->join('position e', 'c.position = e.position_id');
			$this->db->join('department f', 'c.department = f.department_id');
			$this->db->join('location g', 'c.location = g.location_id');
			
				$this->db->where('a.approvers', $this->session->userdata('employee_id'));
			//$this->db->where('eval_level',$q->eval_level);
			$this->db->where('a.status!=','done');
			$this->db->where('a.status!=','');
				$this->db->group_by('c.fullname');
		$query = $this->db->get();

		return $query->result();

	}
	public function update_main($table, $status, $doc_no, $comment){
		if($status == 'cancelled' || $status == 'rejected' ){
			$this->data = array(
			'status'			=>			$status,
			'comment'			=>			$comment,
			'evaluation_status'	=>			0,
			'approval_status'	=>			0,
			'status_update_date'=>			date("Y-m-d h:i:sa")
			);
		} else {
			$this->data = array(
			'status'			=>			$status,
			'comment'			=>			$comment,
			'status_update_date'=>			date("Y-m-d h:i:sa")
			);
		}

		$this->db->where('doc_no', $doc_no);
		$this->db->update('pms_form_scorecard', $this->data);
	}

	public function update_approval_table($status, $comment, $table_name, $approval_level, $doc_no, $type){

		$this->data =array(
			'status'   				=>			$status,
			'comment'				=>			$comment,
			'responder_id'			=>			$this->session->userdata('employee_id'),
			'approval_type'			=>			$type
			);

		$this->db->where(array(
			'doc_no'				=>			$doc_no,
			'approval_level'		=>			$approval_level
			));

		$this->db->set('date_time', 'now()', false);
		$this->db->update($table_name, $this->data);
	}

	public function get_next_level($me, $approval_level, $form_identification, $has_subsection, $has_division){ 
		$this->db->select('approval_level');
		$this->db->where('approval_level >', $approval_level); //where approval_level is greater than given approval
		// $this->db->where('company_id', $me->company_id);
		// $this->db->where('department', $me->department);
		// $this->db->where('section', $me->section);
		// $this->db->where('classification', $me->classification);
		$this->db->where('evaluee_id', $me->employee_id);
		$this->db->where('InActive', 0);
		// if ($has_subsection)
		// {
		// 	$this->db->where('subsection', $me->subsection);
		// }

		// if ($has_division)
		// {
		// 	$this->db->where('division', $me->division_id);
		// }

		$this->db->order_by('approval_level', 'asc'); //Arranged Ascending
		$query = $this->db->get('pms_form_parts_approver', 1); //Limit to 1. Get the next approver
		return $query->row(); //return 1 result only.
	}

	public function get_approval_level($table_name, $doc_no, $employee_id){
		$this->db->select('approval_level');
		$this->db->where('doc_no', $doc_no);
		//$this->db->where('evaluee_id', $employee_id);
		$this->db->where('approver_id', $this->session->userdata('employee_id'));
		$query = $this->db->get($table_name, 1);

		return $query->row()->approval_level;
	}

	public function get_doc_info($doc_no){
		$this->db->distinct('A.employee_id');
		$this->db->select('B.*, D.*, A.*');
		$this->db->where('A.doc_no',$doc_no);
		$this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
		$this->db->join("pms_employee_forms_employeeportal D","D.doc_no = A.doc_no","left outer");
		$query = $this->db->get("pms_scorecard_format_employeeportal A");

		return $query->result();		
	}

	public function get_emp_company($company_id){
		$this->db->where("company_id", $company_id);
		$query = $this->db->get('company_info');

		return $query->result();	
	}

	public function get_emp_dept($dept){
		$this->db->where("department_id", $dept);
		$query = $this->db->get('department');

		return $query->result();	
	}

	public function get_all_dept(){

		$query = $this->db->get('department');

		return $query->result();	
	}

	public function get_emp_sect($sect){
		$this->db->where("section_id", $sect);
		$query = $this->db->get('section');

		return $query->result();	
	}

	public function get_emp_clas($clas){
		$this->db->where("classification_id", $clas);
		$query = $this->db->get('classification');

		return $query->result();	
	}

	public function get_approvers($dept,$sect,$clas,$cur_form, $evaluee_id){
		$this->db->where(array(
			'evaluee_id'			=>		$evaluee_id,
			'department'			=>		$dept,
			'section'				=>		$sect,
			'classification'		=>		$clas
		));	
		$query = $this->db->get('pms_form_parts_approver');

		return $query->result();	
	}

	public function get_form_stat($approver,$doc_no){
		$this->db->where(array(
			'approver_id'				=>			$approver,
			'doc_no'					=>			$doc_no,
			));

		$query = $this->db->get('pms_form_request_approval', 1);
	}

	public function get_all_app($doc,$dept,$sect,$clas,$loc,$sub){
		$u = $this->db->get('pms_form_scorecard');
		$f_id = $u->row('employee_id');

		$table = "pms_form_request_approval";
		$this->db->select('a.*,b.*,c.*,d.*,a.approver_id as approver');
		$this->db->join('pms_form_parts_approver b','b.employee_id=a.original_approver');
		$this->db->join('employee_info c','c.employee_id=a.approver_id');
		$this->db->join('position d','c.position=d.position_id','left');
		// $this->db->where('b.department',$dept);
		// $this->db->where('b.section',$sect);
		// $this->db->where('b.classification',$clas);
		// $this->db->where('b.location',$loc);	
		// if($sub==0 || $sub=='' || $sub==null || $sub=='not_included')
		// {} else{ $this->db->where('b.subsection',$sub); }
		$this->db->where(array('doc_no'=>$doc,'b.evaluee_id'=>$f_id));
		$this->db->group_by('a.approver_id');
		$this->db->order_by('b.approval_level','ASC');
		$query = $this->db->get($table." a");
		return $query->result();	
	}

	public function get_form_status($approver,$doc_no){
		$table = "pms_form_request_approval";
		$this->db->where(array(
			'approver_id'				=>			$approver,
			'doc_no'					=>			$doc_no,
			));

		$query = $this->db->get($table, 1);
		return $query->result();	
	}



	// FORM EVALUATOR

	public function is_eval_mngr($employee_id){
		$this->db->where('employee_id', $employee_id);
		$this->db->where('type', 'evaluator');
		$query = $this->db->get('pms_evaluee_mngt');

		return $query->num_rows();
	}
	public function get_total($fid){	
						$this->db->select('*');
						$this->db->from('pms_eval_score_employeeportal a ');
						$this->db->join('pms_eval_score_total_employeeportal b', 'a.fid = b.fid');
						$this->db->where('a.ref',$this->input->post('doc_no'));
						$this->db->where('b.fid',$fid);

						$query = $this->db->get();
						return $query->row();

	}

	public function get_score_equival($id,$grading_type,$c){

			if($grading_type ==1){
		$qwe = 	round($id,0);
					if($qwe != 0){
						$this->db->select('*,a.score as score');
						$this->db->from('pms_grading_table a ');
						$this->db->where('a.score',round($id,0));
							$this->db->join('pms_grading_table_from_admin_employeeportal f', 'a.score = f.score');
							$this->db->where('f.company_id',$c);
								$this->db->group_by('a.score');


						$query = $this->db->get();
						return $query->row();

	}else{
					$this->db->select('*,a.score as score');
						$this->db->from('pms_grading_table a ');
						$this->db->where('a.score',1);
						$this->db->join('pms_grading_table_from_admin_employeeportal f', 'a.score = f.score');
						$this->db->where('f.company_id',$c);
						$this->db->group_by('a.score');
						$query = $this->db->get();
						return $query->row();
			}
			}elseif($grading_type ==2){
					$qwe = 	round($id,0);
					if($qwe != 0){
						$this->db->select('*,a.score as score');
						$this->db->from('pms_grading_table a ');
						$this->db->where('a.ranking',round($id,0));
							$this->db->join('pms_grading_table_from_admin_employeeportal f', 'a.score = f.score');
							$this->db->where('f.company_id',$c);

								$this->db->group_by('a.score');


						$query = $this->db->get();
						return $query->row();

	}else{
					$this->db->select('*,a.score as score');
						$this->db->from('pms_grading_table a ');
						$this->db->where('a.ranking',1);
						$this->db->where('f.company_id',$c);
						$this->db->join('pms_grading_table_from_admin_employeeportal f', 'a.score = f.score');
						$this->db->group_by('a.score');

						$query = $this->db->get();
						return $query->row();
	}
}
}

	public function appro($doc_no,$company){
					$this->db->select('*');
					$this->db->from('pms_approval_employeeportal');
					$this->db->where('doc_no',$doc_no);
					$this->db->where('status!=','pending');
					$this->db->where('status!=','done');
					$query = $this->db->get();

					return $query->row();


	}
	public function save_evaluation(){



						$idd = $this->input->post('score'); //array of id
						$this->db->select('*');
						$this->db->from('pms_eval_score_employeeportal');
						$this->db->where('ref',$this->input->post('refe'));
						$this->db->where('fid',$this->input->post('f'));
						$this->db->where('evaluated_by',$this->session->userdata('employee_id'));
						$query = $this->db->get();

		     $s =  $query->num_rows();
		     if(empty($s)){
		     		$sum = 0;
					foreach($idd as $qwe => $q){
										$this->get_total();
										$w = $this->input->post('weight')[$qwe];
										$data2[] = array(
											'score'=> $q,
											'ref'=> $this->input->post('refe'),
											'desc_weight'=> $this->input->post('criteria_id')[$qwe],
											'fid'=>$this->input->post('f'),
											'weight'=>$this->input->post('weight')[$qwe],
											'rate'=>$w/100*$q,
											'created_by'=>$this->input->post('c'),
											'evaluated_by'=>$this->session->userdata('employee_id'),
											'evaluator_id'=>$this->input->post('max_id'),
											'appraisal_date'=>$this->input->post('appraisal_date'),
											'comment' => $this->input->post('com')[$qwe]

										);
											$weight += $this->input->post('weight')[$qwe];
											$sum += $w/100*$q;
											   }  


						$data4= array(
							'doc_no'=>$this->input->post('refe'),
							'fid'=>$this->input->post('f'),
							'total'=>$sum,
							'weight'=>$weight,
							'appraisal_date'=>$this->input->post('appraisal_date')


						);
					$this->db->insert('pms_eval_score_total_employeeportal', $data4);
					if(count(array_filter($idd))==count($idd)){
							$data = array('status' => 'completed');

							$this->db->where(array('doc_no'=> $this->input->post('refe'),'fid' => $this->input->post('f')));
							$update = $this->db->update("pms_employee_forms_employeeportal", $data);
			
					}
		
					$this->db->insert_batch('pms_eval_score_employeeportal', $data2);
		      }else{
					if(count(array_filter($idd))==count($idd)){
								$data = array('status' => 'completed');
								$this->db->where(array('doc_no'=> $this->input->post('refe'),'fid' => $this->input->post('f')));
								$update = $this->db->update("pms_employee_forms_employeeportal", $data);
								
															  }
						$sum = 0;
						foreach($idd as $qwe => $q){

									$w = $this->input->post('weight')[$qwe];
											$data2 = array(
												'score'=> $q,
												'ref'=> $this->input->post('refe'),
												'desc_weight'=> $this->input->post('criteria_id')[$qwe],
												'fid'=>$this->input->post('f'),
												'rate'=>$w/100*$q,
												
										
											);
										
												$sum += $w/100*$q;

									$this->db->where(array('ref'=> $this->input->post('refe'),'fid' => $this->input->post('f'),'desc_weight' => $this->input->post('criteria_id')[$qwe]));
									$this->db->update('pms_eval_score_employeeportal', $data2);
													}  
		

					}	
					
	}
	public function recommendation_s($doc_no){
			$this->db->select('*');
			$this->db->from('pms_recommendation_employeeportal');
			$this->db->where('doc_no',$doc_no);
			$f = $this->db->get();
			return  $f->row();
	
	}
	public function update_recommend(){

					
						if($this->input->post('regularization_ref')){
								$regularization = $this->input->post('regularization_ref');
							}else{
								$regularization = uniqid();
									$this->save_regularization($this->input->post('eid'),$regularization);
							}
						if($this->input->post('demotion_ref')){
								$demotion = $this->input->post('demotion_ref');
							}elseif($this->input->post('demotion')){
								$demotion = uniqid();
								$this->save_demotion($this->input->post('eid'),$demotion);
							}
						if($this->input->post('promotion_ref')){
								$promotion = $this->input->post('promotion_ref');
							}elseif($this->input->post('promotion')){
								$promotion = uniqid();
								$this->save_promotion($this->input->post('eid'),$promotion);
							}
						if($this->input->post('retain_in_existing_position_ref')){
								$retain_in_existing_position = $this->input->post('retain_in_existing_position_ref');
							}elseif($this->input->post('retain_in_existing_position')){
								$retain_in_existing_position = uniqid();
								$this->save_retain_in_existing_position($this->input->post('eid'),$retain_in_existing_position);
							}
								if($this->input->post('extend_probationary_period_ref')){
								$extend_probationary_period_ref = $this->input->post('extend_probationary_period_ref');
							}elseif($this->input->post('extend_probationary_period')){
								$extend_probationary_period = uniqid();
								$this->save_extend_probationary_period($this->input->post('eid'),$extend_probationary_period);
							}
						if($this->input->post('contract_renewal_ref')){
								$contract_renewal_ref = $this->input->post('contract_renewal_ref');
							}elseif($this->input->post('contract_renewal')){
								$contract_renewal = uniqid();
								$this->save_contract_renewal($this->input->post('eid'),$contract_renewal);
							}
								if($this->input->post('end_of_contract_ref')){
								$end_of_contract_ref = $this->input->post('end_of_contract_ref');
							}elseif($this->input->post('end_of_contract')){
								$end_of_contract = uniqid();
								$this->save_end_of_contract($this->input->post('eid'),$end_of_contract);
							}
								if($this->input->post('for_lateral_transfer_ref')){
								$for_lateral_transfer_ref = $this->input->post('for_lateral_transfer_ref');
							}elseif($this->input->post('for_lateral_transfer')){
								$for_lateral_transfer = uniqid();
								$this->save_end_of_contract($this->input->post('eid'),$for_lateral_transfer);
							}
								if($this->input->post('salary_increase_ref')){
								$salary_increase = $this->input->post('salary_increase_ref');
							}elseif($this->input->post('salary_increase')){
								$salary_increase = uniqid();
								$this->save_salary_increase($this->input->post('eid'),$salary_increase);
							}													
			

					
			



			$data4= array(
						
							
							'regularization'=>$regularization,
							'promotion'=>$promotion,
								'demotion'=>$demotion,
									'retain_in_existing_position'=>$retain_in_existing_position,
										'extend_probationary_period'=>$extend_probationary_period,
											'contract_renewal'=>$contract_renewal,
												'end_of_contract'=>$end_of_contract,
												'for_lateral_transfer'=>$for_lateral_transfer,
												'salary_increase'=>$salary_increase,
												'comments'=>$this->input->post('comment'),
												'doc_no'=>$this->input->post('doc_no'),
												'recommended_by'=>$this->session->userdata('employee_id'),
												'employee_id'=>$this->input->post('eid')

					
	
			

						);


					$this->db->update('pms_recommendation_employeeportal', $data4);	
		}
	public function save_recommendatin(){

					if($this->input->post('regularization')){
						$regularization = uniqid();
							$this->save_regularization($this->input->post('eid'),$regularization);


					}
					if($this->input->post('promotion')){
							$promotion = uniqid();
							$this->save_promotion($this->input->post('eid'),$promotion);
					}	
					if($this->input->post('demotion')){
						$demotion = uniqid();
							$this->save_demotion($this->input->post('eid'),$demotion);
					}
					if($this->input->post('retain_in_existing_position')){
						$retain_in_existing_position = uniqid();
							$this->save_retain_in_existing_position($this->input->post('eid'),$retain_in_existing_position);
					}
					if($this->input->post('extend_probationary_period')){
						$extend_probationary_period = uniqid();
							$this->save_extend_probationary_period($this->input->post('eid'),$extend_probationary_period);
					}
					if($this->input->post('contract_renewal')){
							$contract_renewal = uniqid();
							$this->save_contract_renewal($this->input->post('eid'),$contract_renewal);
					}
					if($this->input->post('end_of_contract')){
							$end_of_contract = uniqid();
							$this->save_end_of_contract($this->input->post('eid'),$end_of_contract);
					}
					if($this->input->post('for_lateral_transfer')){
							$for_lateral_transfer = uniqid();

							$this->save_for_lateral_transfer($this->input->post('eid'),$for_lateral_transfer);
					}
					if($this->input->post('salary_increase')){
							$salary_increase = uniqid();
							$this->save_salary_increase($this->input->post('eid'),$salary_increase );
					}


			

			$data4= array(
						
							
							'regularization'=>$regularization,
							'promotion'=>$promotion,
								'demotion'=>$demotion,
									'retain_in_existing_position'=>$retain_in_existing_position,
										'extend_probationary_period'=>$extend_probationary_period,
											'contract_renewal'=>$contract_renewal,
												'end_of_contract'=>$end_of_contract,
												'for_lateral_transfer'=>$for_lateral_transfer,
												'salary_increase'=>$salary_increase,
												'comments'=>$this->input->post('comment'),
												'doc_no'=>$this->input->post('doc_no'),
													'recommended_by'=>$this->session->userdata('employee_id'),
													'employee_id'=>$this->input->post('eid')

					
							
			

						);


					$this->db->insert('pms_recommendation_employeeportal', $data4);	
		}


	public function save_contract_renewal($eid,$ref){
			if($ref){
			$data4= array(
							
							'from'=>$this->input->post('from'),
							'to'=>$this->input->post('to'),
							'ref'=>$ref,


							
			

						);
					$this->db->insert('pms_contract_renewal_employeeportal', $data4);	
				}
		}

	public function exist($doc_no){
		$this->db->select('*,a.regularization as regularization_ref,
			a.demotion as demotion_ref,
			a.promotion as promotion_ref,
			a.retain_in_existing_position as retain_in_existing_position_ref,a.extend_probationary_period as extend_probationary_period_ref ,a.extend_probationary_period as extend_probationary_period_ref ,a.contract_renewal as contract_renewal_ref,a.for_lateral_transfer as for_lateral_transfer_ref,a.salary_increase as salary_increase_ref, c.position as promo_position,d.position as demo_position,e.ref as s,h.ref as ref_ex','i.position as for_lateral_transfer_position');
		$this->db->from('pms_recommendation_employeeportal a');
		$this->db->join('pms_regularization_employeeportal b', 'a.regularization = b.ref','left');
		$this->db->join('pms_promotion_employeeportal c', 'a.promotion = c.ref','left');
		$this->db->join('pms_demotion_employeeportal d', 'a.demotion = d.ref','left');
		$this->db->join('pms_retain_in_existing_position_employeeportal e', 'a.retain_in_existing_position = e.ref','left');
							$this->db->join('pms_extend_probationary_period_employeeportal f', 'a.extend_probationary_period = f.ref','left');
											$this->db->join('pms_contract_renewal_employeeportal g', 'a.contract_renewal = g.ref','left');
															$this->db->join('pms_end_of_contract_employeeportal h', 'a.end_of_contract = h.ref','left');
															$this->db->join('pms_for_lateral_transfer_employeeportal i', 'a.for_lateral_transfer = i.ref','left');
																	$this->db->join('pms_salary_increase_employeeportal j', 'a.salary_increase = j.ref','left');
																	$this->db->where('a.doc_no',$doc_no);
	
		
		$query = $this->db->get();

		return $query->row();
	}
	public function save_retain_in_existing_position($eid,$ref){
		if($ref){
			$data4= array(
						
	
'ref'=>$ref,

	

						);
					$this->db->insert('pms_retain_in_existing_position_employeeportal', $data4);
					}	
		}
		public function save_extend_probationary_period($eid,$ref){
			if($ref){
			$data4= array(
							
							'no_months'=>$this->input->post('extend_probationary_period_value'),
'ref'=>$ref,

	
					

						);
					$this->db->insert('pms_extend_probationary_period_employeeportal', $data4);	
		}
	}
			public function save_end_of_contract($eid,$ref){
					if($ref){
			$data4= array(
							
		'ref'=>$ref,

	

						);
					$this->db->insert('pms_end_of_contract_employeeportal', $data4);	
				}
		}
	
		public function save_promotion($eid,$ref){
			if($ref){
			$data4= array(
						
							'position'=>$this->input->post('position_promo'),
							'ref'=>$ref,

	

						);
					$this->db->insert('pms_promotion_employeeportal', $data4);	
				}
		}
			public function save_for_lateral_transfer($eid,$ref){
				if($ref){
			$data4= array(
							

					'ref'=>$ref,
					'department'=>$this->input->post('department'),
					'position'=>$this->input->post('position'),



						);
					$this->db->insert('pms_for_lateral_transfer_employeeportal', $data4);	
		}
	}

		public function save_regularization($eid,$ref){

			if($ref){
			$data4= array(
							'ref'=>$ref,
							
							'date'=>$this->input->post('regu_date'),
							

						);
					$this->db->insert('pms_regularization_employeeportal', $data4);	
				}
		}
			public function save_salary_increase($eid,$ref){
					if($ref){
			$data4= array(
							
							'salary'=>$this->input->post('salar'),
							'ref'=>$ref,


			

						);
					$this->db->insert('pms_salary_increase_employeeportal', $data4);	
				}
		}
		public function save_demotion($eid,$ref){
			if($ref){
			$data4= array(
							
							'position'=>$this->input->post('position_demo'),
							'ref'=>$ref,

	

						);
					$this->db->insert('pms_demotion_employeeportal', $data4);	
		}
	}
		public function get_max_eval($doc_no){
		$this->db->select('*');
		$this->db->where('doc_no',$doc_no);
		$this->db->where('status!=', 'done');
		$this->db->where('status!=', 'pending');
		$query = $this->db->get('pms_evaluation_employeeportal');

		return $query->num_rows();
	}
			public function get_max_evaluator_employeeportal(){
		$this->db->select_max('evaluator');
		$this->db->where('company_id', $this->session->userdata('company_id'));


		$res =$this->get_evaluator_($this->session->userdata('company_id'));

		if($res->creators_type == 4){
		$query = $this->db->get('transaction_approvers');
		}else{
		$query = $this->db->get('pms_form_evaluators');	
		}

		return $query->row();
	}

	public function get_evaluee_evaluator($employee_id){
		$this->db->where('A.employee_id', $employee_id);
		$this->db->where('A.type', 'evaluator');
		$this->db->join('employee_info B', 'A.evaluee_id = B.employee_id');
		$query = $this->db->get('pms_evaluee_mngt A');

		return $query->result();
	}

	public function get_evaluators($employee_id){
		$this->db->select('A.*, B.*, D.part_name, C.form_part_id');
		$this->db->where('A.evaluee_id', $employee_id);
		$this->db->join('employee_info B', 'B.employee_id = A.employee_id');
		$this->db->join('pms_form_scorecard C', 'A.setting = C.form_part_id');
		$this->db->join('pms_form_details D', 'C.form_part_id = D.id');
		$query = $this->db->get('pms_form_parts_evaluator A');

		return $query->result();
	}
		public function get_score_total($e,$c,$a){
		$this->db->select_sum('score');
		$this->db->from('pms_eval_score_employeeportal a');


		
		$this->db->where('a.created_by',$a);
		$this->db->where('a.ref', $e);
		$this->db->where('a.desc_weight', $c);



		$q = $this->db->get();
		$qquery = $q->result();
		    		$ws = 0;
		    		$qe = 1;
		foreach($qquery as $query){
		
			$ws += $query->score;
			$w = $query->weight;
			$qe++;

		}	
			$s = $w/100;
			$f = $ws/2;
			echo $s*$f;
		

	}

	public function get_score($doc_no,$fid,$admin,$cid){

			$this->db->select('score');
		
		$this->db->from('pms_eval_score_employeeportal a');


		
		$this->db->where('a.ref', $doc_no);
		$this->db->where('a.fid', $fid);
		$this->db->where('desc_weight',$cid);

		

	


		$q = $this->db->get();

		$this->db->select_sum('score');
		$this->db->from('pms_eval_score_employeeportal a');


		
		$this->db->where('a.ref', $doc_no);
		$this->db->where('a.fid', $fid);
		$this->db->where('desc_weight',$cid);
		

		$this->db->group_by('desc_weight');



		$s = $this->db->get();

		$data['result'] =  $s->row();
		$data['rows']   = $q->num_rows();
		return $data;
		

	}

	public function lastevalaution($e,$c,$a,$cid){
			$this->db->select_max('eval_level');
			$this->db->from('pms_evaluation_employeeportal a');



		$this->db->where('a.doc_no', $e);


		$query = $this->db->get();
		$s = $query->row();


		$this->db->select('score');
		$this->db->from('pms_eval_score_employeeportal b');
		$this->db->where('b.ref', $e);
		$this->db->where('b.fid', $c);
		$this->db->where('desc_weight',$cid);
		$this->db->where('b.evaluator_id', $s->eval_level);
		$qs = $this->db->get();



		return $qs->row();

	}
	public function get_score_rate($e,$c,$a){
			$w = $e/100*round($c);
			return $w;
	}
	public function get_computation(){
		$this->db->select("*");	
		$this->db->where('company_id',$this->session->userdata('company_id'));
	
		$query = $this->db->get("pms_settings_computation");

		return $query->row();
	}
		public function get_score_admin_evaluation($e,$c,$a,$g){
		if($g == 1){
		$this->db->select('*,a.comment as comment');
		$this->db->from('pms_eval_score_employeeportal a');
		$this->db->join('pms_grading_table_from_admin_employeeportal b', 'a.score = b.score','left');
		$this->db->join('pms_eval_score_total_employeeportal c', 'a.fid = c.fid','left');
	
		$this->db->where('a.created_by',$a);
		$this->db->where('a.ref', $e);
		$this->db->where('a.desc_weight', $c);
		$this->db->where('a.evaluated_by',$this->session->userdata('employee_id'));

		}elseif($g == 2){
			$this->db->select('*,a.comment as comment');
		$this->db->from('pms_eval_score_employeeportal a');
		$this->db->join('pms_grading_table_from_admin_employeeportal b', 'a.score = b.ranking','left');
		$this->db->join('pms_eval_score_total_employeeportal c', 'a.fid = c.fid','left');
	
		$this->db->where('a.created_by',$a);
		$this->db->where('a.ref', $e);
		$this->db->where('a.desc_weight', $c);
		$this->db->where('b.doc_no', $e);
		$this->db->where('a.evaluated_by',$this->session->userdata('employee_id'));	
		}
		$query = $this->db->get();

		return $query->result();
	}
		public function get_score_creator($e,$c,$a){
		$this->db->select('*');
		$this->db->from('pms_eval_score_employeeportal a');
		$this->db->join('pms_grading_table_employeeportal b', 'a.score = b.score');
		
	
		$this->db->where('a.created_by',$a);
		$this->db->where('ref', $e);
		$this->db->where('desc_weight', $c);


		$query = $this->db->get();

		return $query->row();
	}
			public function get_score_creator_evaluation($e,$c,$a){
		$this->db->select('*');
		$this->db->from('pms_eval_score_employeeportal a');
		$this->db->join('pms_grading_table_employeeportal b', 'a.score = b.score');
		
	
		$this->db->where('a.created_by',$a);
		$this->db->where('ref', $e);
		$this->db->where('desc_weight', $c);


		$query = $this->db->get();

		return $query->result();
	}


	public function get_available_evaluator($company){
		if($company != 0){
			$this->db->where('A.company_id',$company);
		}

		$this->db->select("A.employee_id, A.fullname, C.classification");	
		$this->db->where('A.InActive',0);
		$this->db->where('A.company_id', $company);
		//$this->db->where('B.evaluator_level', $level);
		$this->db->where('B.employee_id IS NULL', null, false);
		$this->db->join("pms_form_parts_evaluator B", "B.employee_id = A.employee_id","left outer");
		$this->db->join("classification C","C.classification_id = A.classification","left outer");
		$query = $this->db->get("employee_info A");

		return $query->result();
	}

	public function insert_evaluator($data){
		$this->db->insert('pms_form_parts_evaluator', $data);
	}
public function get_last_eval($doc_no){

			$this->db->select_max('eval_level');
			$this->db->from('pms_evaluation_employeeportal');
			$this->db->where('doc_no',$doc_no);
			$f = $this->db->get();
			$q=  $f->row();
			$this->db->select('*');
			$this->db->from('pms_evaluation_employeeportal');
			$this->db->where('doc_no',$doc_no);
			$this->db->where('eval_level',$q->eval_level);
					$query = $this->db->get();

			return $query->result();

}
public function ceveal($doc_no){

	
			$this->db->select('*');
			$this->db->from('employee_info');
			$this->db->where('employee_id',$doc_no);

			$query = $this->db->get();

			return $query->row();

}
	public function insert_score_evaluator($emp_id, $level, $form_id){

		if($level == 1){
			$data = array(
				'evaluator_id' => $emp_id,
				'evaluator_level' => $level,
				'form_part_id' => $form_id,
				'form_part_id' => 0,
				'status_view' => "ON"
			);
		} else {
			$data = array(
				'evaluator_id' => $emp_id,
				'evaluator_level' => $level,
				'form_part_id' => $form_id,
				'form_part_id' => 0,
				'status_view' => "OFF"
			);
		}
		
		$this->db->insert('pms_form_score_evaluator', $data);
	}

	public function delete_eval($evaluee_id, $emp_id, $form_id){
		$this->db->where(array(
			'evaluee_id' => $evaluee_id,
			'employee_id' => $emp_id,
		));

		$this->db->delete('pms_form_parts_evaluator');
    	$this->pms_model->delete_eval_score($form_id, $emp_id);
	}

	public function delete_eval_score($form_id, $emp_id){
		$this->db->where(array(
			'form_part_id' => $form_id,
			'evaluator_id' => $emp_id,
		));

		$this->db->delete('pms_form_score_evaluator');
	}

	public function count_evaluators($employee_id, $level){
		$this->db->where('evaluee_id', $employee_id);
		$this->db->where('evaluator_level', $level);
		$query = $this->db->get('pms_form_parts_evaluator');

		return $query->num_rows();
	}

	public function getNumEval($company_id){
		$this->db->where('company_id', $company_id);
		$query = $this->db->get('pms_no_evaluator');

		return $query->row();
	}

	public function get_created_form($employee_id){
		$this->db->where('A.employee_id', $employee_id);
		$this->db->where('A.evaluation_status', 1);
		$this->db->join('pms_form_details B', 'A.form_part_id = B.id');
		$query = $this->db->get('pms_form_scorecard A');

		return $query->result();
	}




	// FORM APPROVER

	public function is_approver_mngr($employee_id){
		$this->db->where('employee_id', $employee_id);
		$this->db->where('type', 'approver');
		$query = $this->db->get('pms_evaluee_mngt');

		return $query->num_rows();
	}

	public function get_evaluee_approver($employee_id){
		$this->db->where('A.employee_id', $employee_id);
		$this->db->where('A.type', 'approver');
		$this->db->join('employee_info B', 'A.evaluee_id = B.employee_id');
		$query = $this->db->get('pms_evaluee_mngt A');

		return $query->result();
	}

	public function get_form_approver($employee_id){
		$this->db->where('A.evaluee_id', $employee_id);
		$this->db->join('employee_info B', 'B.employee_id = A.employee_id');
		$query = $this->db->get('pms_form_parts_approver A');

		return $query->result();
	}

	public function get_available_approver($company){
		if($company != 0){
			$this->db->where('A.company_id',$company);
		}
		
		$this->db->select("A.employee_id, A.fullname, C.classification");	
		$this->db->where('A.InActive',0);
		$this->db->where('A.company_id', $company);
		//$this->db->where('B.evaluator_level', $level);
		$this->db->where('B.employee_id IS NULL', null, false);
		$this->db->join("pms_form_parts_approver B", "B.employee_id = A.employee_id","left outer");
		$this->db->join("classification C","C.classification_id = A.classification","left outer");
		$query = $this->db->get("employee_info A");

		return $query->result();
	}

	public function insert_approver($data){
		$this->db->insert('pms_form_parts_approver', $data);
	}

	public function delete_app(){
		$emp_id = $this->input->post('employee_id');
		$evaluee_id = $this->input->post('evaluee_id');

		$this->db->where(array(
			'evaluee_id' => $evaluee_id,
			'employee_id' => $emp_id,
		));	

		$this->db->delete('pms_form_parts_approver');
	}

	public function count_approver($employee_id, $level){
		$this->db->where('evaluee_id', $employee_id);
		$this->db->where('approval_level', $level);
		$query = $this->db->get('pms_form_parts_approver');

		return $query->num_rows();
	}

	public function getNumApp($company_id){	

		$this->db->where('company_id', $company_id);
		$query = $this->db->get('pms_no_approver');

		return $query->row();
	}



	// MY PMS FORMS

	public function my_forms(){
		$this->db->select('*,a.status as status');
		$this->db->from('pms_scorecard_format_employeeportal a');
				$this->db->join('pms_employee_forms_employeeportal b', 'a.doc_no = b.doc_no','left');
		$this->db->where('a.employee_id', $this->session->userdata('employee_id'));
		$this->db->group_by('a.doc_no');
		$query = $this->db->get();

		return $query->result();
	}

	public function get_recommendation($doc_no){

		$this->db->select('*,c.position as pro_pos,d.position as demo_pos,b.date as reg_date,h.from as c_from,h.to as c_to,j.department as f_department,j.position as f_position');
		$this->db->from('pms_recommendation_employeeportal a');
		$this->db->join('pms_regularization_employeeportal b', 'a.regularization = b.ref','left');
		$this->db->join('pms_promotion_employeeportal c', 'a.promotion = c.ref','left');
		$this->db->join('pms_demotion_employeeportal d', 'a.demotion = d.ref','left');
		$this->db->join('pms_retain_in_existing_position_employeeportal f', 'a.retain_in_existing_position = f.ref','left');
		$this->db->join('pms_extend_probationary_period_employeeportal g', 'a.extend_probationary_period = g.ref','left');
	    $this->db->join('pms_contract_renewal_employeeportal h', 'a.contract_renewal = h.ref','left');
	    $this->db->join('pms_end_of_contract_employeeportal i', 'a.end_of_contract = i.ref','left');
	    $this->db->join('pms_for_lateral_transfer_employeeportal j', 'a.for_lateral_transfer = j.ref','left');
	    $this->db->join('pms_salary_increase_employeeportal k', 'a.salary_increase = k.ref','left');

		$this->db->where('a.doc_no', $doc_no);
		$query = $this->db->get();


		return $query->row();
	}

	public function get_general_instruction(){
		$query = $this->db->get('pms_general_instruction');


		return $query->row();
	}


	// ====================================================================start gel

	public function checkForm($employee_id){
		$query=$this->db->query("SELECT * from pms_form_details WHERE employee_id='".$employee_id."' ");
		//return $query->result();	
		return $query->row();
	}

	public function validateFormPartNumber($employee_id){
		$query=$this->db->query("SELECT part_number FROM pms_form_details WHERE employee_id='".$employee_id."' GROUP BY part_number HAVING count(*) > 1; ");
		return $query->row();
	}


}