<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Pms_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

public function opts_xist($employeed,$co){
					$res = $this->get_scorecard_($co);
					if($res->creators_type ==2){
					$this->db->select('*');
					$this->db->from('pms_creators_option2');
					$this->db->where('creator',$employeed);	
					$this->db->where('company_id',$co);
					}elseif($res->creators_type ==4){
					$this->db->select('*');
					$this->db->from('pms_creators_approvers_setup');
					$this->db->where('creator',$employeed);	
					$this->db->where('company_id',$co);	
					}
					$result = $this->db->get();
					if($result->num_rows()){
						return false;
					}else{
						return true;
					}
					
}
public function opts_xist_eval($employeed,$e){
					$this->db->select('*');
					$this->db->from('pms_form_evaluators');
					$this->db->where('evaluator_id',$employeed);
					$this->db->where('company_id',$e);
					// $this->db->group_by('evaluator_id');
					$result = $this->db->get();
					return $result->num_rows();
			
			
			
}


public function opt2($company){

					$this->db->select('*');
					$this->db->from('employee_info a');
					$this->db->join('classification b', 'a.classification = b.classification_id');
					$this->db->join('location c', 'a.location = c.location_id');
					$this->db->join('department d', 'a.department = d.department_id');
					$this->db->join('pms_form_evaluators e', 'a.employee_id = e.evaluator_id','left');
					$this->db->where('a.company_id',$company);
		
					$this->db->group_by('a.fullname');
						
					$result = $this->db->get();
					return $result->result();

}
public function get_scorecard_($company){
					$this->db->select('*');

					$this->db->from('pms_manage_form_score_type');
					$this->db->where('company_id',$company);
					$query = $this->db->get();
					return $query->row();

}

public function get_count_dept_creator($id,$creator){
					$res = $this->get_scorecard_($id);
					if($res->creators_type ==2){
					$this->db->distinct();	
					$this->db->select('a.department_id');

					$this->db->from('pms_creators_option2 a');
	
					$this->db->join('employee_info e', 'a.creator = e.employee_id','left');
					$this->db->join('department c', 'a.department_id = c.department_id','left');
		
			
					$this->db->where('creator',$creator);
					$this->db->where('a.company_id',$id);
					}elseif($res->creators_type ==4){
					$this->db->distinct();	
					$this->db->select('a.department_id');

					$this->db->from('pms_creators_approvers_setup a');
	
					$this->db->join('employee_info e', 'a.creator = e.employee_id','left');
					$this->db->join('department c', 'a.department_id = c.department_id','left');
		
			
					$this->db->where('creator',$creator);
					$this->db->where('a.company_id',$id);

					}
				


					$query = $this->db->get();
					return $query->num_rows();

}
public function get_dept_creator($id,$creator){
					$res = $this->get_scorecard_($id);
					if($res->creators_type ==2){
					$this->db->select('*');

					$this->db->from('pms_creators_option2 a');
	
					$this->db->join('employee_info e', 'a.creator = e.employee_id','left');
					$this->db->join('department c', 'a.department_id = c.department_id','left');
		
			
					$this->db->where('creator',$creator);
					$this->db->where('a.company_id',$id);
					$this->db->group_by('c.dept_name');
						}elseif($res->creators_type ==4){
									$this->db->select('*');

					$this->db->from('pms_creators_approvers_setup a');
	
					$this->db->join('employee_info e', 'a.creator = e.employee_id','left');
					$this->db->join('department c', 'a.department_id = c.department_id','left');
		
			
					$this->db->where('creator',$creator);
					$this->db->where('a.company_id',$id);
					$this->db->group_by('c.dept_name');}


					$query = $this->db->get();
					return $query->result();

}
public function get_classification_creator($id,$creator){
						
					$res = $this->get_scorecard_($id);
					if($res->creators_type ==2){
					$this->db->select('*');
					$this->db->from('pms_creators_option2 a');
	
					$this->db->join('classification b', 'a.classification_name = b.classification_id','left');
			
			
					$this->db->where('creator',$creator);
					$this->db->where('a.company_id',$id);
					$this->db->group_by('b.classification');
					}elseif($res->creators_type ==4){
					$this->db->select('*');
					$this->db->from('pms_creators_approvers_setup a');
	
					$this->db->join('classification b', 'a.classification_name = b.classification_id','left');
			
			
					$this->db->where('creator',$creator);
					$this->db->where('a.company_id',$id);
					$this->db->group_by('b.classification');	
					}



					$query = $this->db->get();
					return $query->result();

}

public function get_location_creator($id,$creator){
					$res = $this->get_scorecard_($id);
					if($res->creators_type ==2){
					$this->db->select('*');
					$this->db->from('pms_creators_option2 a');
	
					$this->db->join('location b', 'a.location_name = b.location_id','left');
			
			
					$this->db->where('creator',$creator);
					$this->db->where('a.company_id',$id);
					$this->db->group_by('b.location_name');
					}elseif($res->creators_type ==4){
					$this->db->select('*');
					$this->db->from('pms_creators_approvers_setup a');
	
					$this->db->join('location b', 'a.location_name = b.location_id','left');
			
			
					$this->db->where('creator',$creator);
					$this->db->where('a.company_id',$id);
					$this->db->group_by('b.location_name');
					}



					$query = $this->db->get();
					return $query->result();

}
public function get_count_location_creator($id,$creator){
					$res = $this->get_scorecard_($id);
					if($res->creators_type ==2){
					$this->db->distinct();
					$this->db->select('a.location_name');
					$this->db->from('pms_creators_option2 a');
	
					$this->db->join('employee_info e', 'a.creator = e.employee_id','left');
					$this->db->join('location b', 'a.location_name = b.location_id','left');
			
			
					$this->db->where('creator',$creator);
					$this->db->where('a.company_id',$id);
					}elseif($res->creators_type ==4){
							$this->db->distinct();
					$this->db->select('a.location_name');
					$this->db->from('pms_creators_approvers_setup a');
	
					$this->db->join('employee_info e', 'a.creator = e.employee_id','left');
					$this->db->join('location b', 'a.location_name = b.location_id','left');
			
			
					$this->db->where('creator',$creator);
					$this->db->where('a.company_id',$id);
				}



					$query = $this->db->get();
					return $query->num_rows();

}
public function get_count_classification_creator($id,$creator){
					$res = $this->get_scorecard_($id);
					if($res->creators_type ==2){
					$this->db->distinct();
					$this->db->select('a.classification_name');
					$this->db->from('pms_creators_option2 a');
	
					$this->db->join('employee_info e', 'a.creator = e.employee_id','left');
					$this->db->join('classification d', 'a.classification_name = d.classification_id','left');
			
					
					$this->db->where('a.creator',$creator);
					$this->db->where('a.company_id',$id);
					}elseif($res->creators_type ==4){
					$this->db->distinct();
					$this->db->select('a.classification_name');
					$this->db->from('pms_creators_approvers_setup a');
	
					$this->db->join('employee_info e', 'a.creator = e.employee_id','left');
					$this->db->join('classification d', 'a.classification_name = d.classification_id','left');
			
					
					$this->db->where('a.creator',$creator);
					$this->db->where('a.company_id',$id);

					}



					$query = $this->db->get();
					return $query->num_rows();

}

public function get_creator($id,$creator){
	$res = $this->get_scorecard_($id);
					if($res->creators_type ==2){

					$this->db->select('*');
					$this->db->from('pms_creators_option2 a');
	
					$this->db->join('employee_info e', 'a.creator = e.employee_id','left');
					$this->db->join('classification d', 'a.classification_name = d.classification_id','left');
					$this->db->where('a.company_id',$id);
					}elseif($res->creators_type ==4){
							$this->db->select('*');
					$this->db->from('pms_creators_approvers_setup a');
	
					$this->db->join('employee_info e', 'a.creator = e.employee_id','left');
					$this->db->join('classification d', 'a.classification_name = d.classification_id','left');
					$this->db->where('a.company_id',$id);}



					$query = $this->db->get();
					return $query->row();

}
	public function approver_list_all()
	{
		$this->db->select('fullname,approver,transaction_approvers.company,
							company_name,approval_level,form_identification,
							employee_info.employee_id,company_info.company_id');
		$this->db->from('transaction_approvers');
		$this->db->join('employee_info','employee_info.employee_id=transaction_approvers.approver');
		$this->db->join('company_info','company_info.company_id=transaction_approvers.company');
		$this->db->where('transaction_approvers.InActive',0);
		$query = $this->db->get();
		return $query->result();
	}
public function get_section_creator($id,$creator){
	$res = $this->get_scorecard_($id);
					if($res->creators_type ==2){
				
					$this->db->select('*');
					$this->db->from('pms_creators_option2 a');
					$this->db->join('employee_info e', 'a.creator = e.employee_id','left');
					$this->db->join('section b', 'a.section_id = b.section_id');
					$this->db->where('a.company_id',$id);
					$this->db->where('a.creator',$creator);
					$this->db->group_by('b.section_name');	
					}elseif($res->creators_type ==4){
					$this->db->select('*');
					$this->db->from('pms_creators_approvers_setup a');
					$this->db->join('employee_info e', 'a.creator = e.employee_id','left');
					$this->db->join('section b', 'a.section_id = b.section_id');
					$this->db->where('a.company_id',$id);
					$this->db->where('a.creator',$creator);
					$this->db->group_by('b.section_name');

					}
					$result = $this->db->get();
					return $result->result();

}
public function get_count_section_creator($id,$creator){
				$res = $this->get_scorecard_($id);
					if($res->creators_type ==2){
					$this->db->distinct();
					$this->db->select('a.section_id');
					$this->db->from('pms_creators_option2 a');
					$this->db->join('employee_info e', 'a.creator = e.employee_id','left');
					$this->db->join('section b', 'a.section_id = b.section_id');
					$this->db->where('a.company_id',$id);
					$this->db->where('a.creator',$creator);
				}elseif($res->creators_type ==4){
					$this->db->distinct();
					$this->db->select('a.section_id');
					$this->db->from('pms_creators_approvers_setup a');
					$this->db->join('employee_info e', 'a.creator = e.employee_id','left');
					$this->db->join('section b', 'a.section_id = b.section_id');
					$this->db->where('a.company_id',$id);
					$this->db->where('a.creator',$creator);

				}
						
					$result = $this->db->get();
					return $result->num_rows();

}


public function opts_xist_approver($employeed,$co){
					$this->db->select('*');
					$this->db->from('pms_form_approvers');
					$this->db->where('approver_id',$employeed);
					$this->db->where('company_id',$co);
				
						$result = $this->db->get();
					return $result->num_rows();
			

}
public function save_approvers($id){
			
			$employee = $this->input->post('id',true);
		$de = $this->input->post('department1',true);
		$ca = $this->input->post('classification1',true);
		$l = $this->input->post('location1',true);
		$s= $this->input->post('section',true);


	$insertArray = array();

				$mem = $this->input->post('mem');
				$lvl = $this->input->post('alevel');
			foreach($mem as $mem){
				$new_add = array(
						'approver_id'=>$mem,
				
						'location_id' =>   $l,
						'company_id' => $this->input->post('company_'),
						'classification_id' =>$ca,
						'department_id' =>$de,
						'section_id' =>$s,
						'approval_level'=>$this->input->post('alevel'.$mem),
					'ref'=>$de.$ca.$s.$l.$this->input->post('company_')

					);
				
						array_push($insertArray,$new_add);
				
			
			}
					

$this->db->insert_batch('pms_form_approvers', $insertArray);
		
				
		

			
		}
	public function yearly($c , $id){
			$this->db->select('*');
			$this->db->from('pms_appraisal_type_period_default');
			$this->db->where('appraisal_type_period',$id);
			$query = $this->db->get();//admin_emp_masterlist_view
			return $query->result();
		}

	public function employee(){
		$this->db->select('*');
		$this->db->from('employee_info');

			$query = $this->db->get();//admin_emp_masterlist_view
			return $query->result();

		}
		public function company_($qwe){
			$this->db->select('*');
			$this->db->from('company_info');
			$this->db->where('company_id',$qwe);

			$query = $this->db->get();//admin_emp_masterlist_view
			return $query->result();
		}
	
	public function group($co){
			$this->db->select('*');
			$this->db->from('pms_appraisal_group');
			$this->db->where('pms_appraisal_group.company_id',$co);
			$query = $this->db->get();//admin_emp_masterlist_view
			return $query->result();
		}


	public function period($co){
			$this->db->select('*');
			$this->db->from('pms_appraisal_period_type');

			$query = $this->db->get();//admin_emp_masterlist_view
			return $query->result();
		}
	public function save_score_option3(){
			$name_array = $this->input->post('mem',true);
			$id = $this->input->post('id',true);

			
			for ($i = 0; $i < count($name_array); $i++) {
				$res = $this->pms_model->filename_exists('employee_id','pms_creators_approvers_setup',$name_array[$i]);
				$count = count($res);
				if(empty($count)){	
					$data = array(
						'employee_id' =>  $name_array[$i],
						'inactive'=>'1',
						'position_id' =>$this->input->post('position_name') ,
						'company_id' => $this->input->post('company_')

					);
					$this->db->insert('pms_creators_approvers_setup', $data);
				}
			
		

			
		}
	}
	public function save_evaluators(){
			$name_array = $this->input->post('mem',true);
			$id = $this->input->post('id',true);
			$de = $this->input->post('departments',true);
			$ca = $this->input->post('classification_all',true);
			$l = $this->input->post('location_all',true);





			for ($i = 0; $i < count($name_array); $i++) {
				$res = $this->pms_model->filename_exists('employee_id','pms_form_evaluators',$name_array[$i]);
				$count = count($res);
				if(empty($count)){	
					$data = array(
						'employee_id' =>  $name_array[$i],
						'location_id' =>   $l[$i],
						'company_id' => $this->input->post('company_'),
						'classification_id' =>   $ca[$i],
						'department_id' => $de[$i],
						'section_id' => $this->input->post('section')

					);
					$this->db->insert('pms_form_evaluators', $data);
				}
			}


			
		}
		public function get_count_dept_approver($id,$evaluator){
					$this->db->distinct();
					$this->db->select('a.department_id');
					$this->db->from('pms_form_approvers a');
					$this->db->join('employee_info e', 'a.approver_id = e.employee_id','left');
					$this->db->join('department b', 'a.department_id = b.department_id');
					$this->db->where('a.company_id',$id);
					$this->db->where('a.approver_id',$evaluator);
						
					$result = $this->db->get();
					return $result->num_rows();

}

public function get_count_classification_evaluator($id,$evaluator){
					$this->db->distinct();
					$this->db->select('a.classification_id');
					$this->db->from('pms_form_evaluators a');
					$this->db->join('employee_info e', 'a.evaluator_id = e.employee_id','left');
					$this->db->join('classification b', 'a.classification_id = b.classification_id');
					$this->db->where('a.company_id',$id);
					$this->db->where('a.evaluator_id',$evaluator);
						
					$result = $this->db->get();
					return $result->num_rows();

}
public function get_count_location_approver($id,$evaluator){
					$this->db->distinct();
					$this->db->select('a.location_id');
					$this->db->from('pms_form_approvers a');
					$this->db->join('employee_info e', 'a.approver_id = e.employee_id','left');
					$this->db->join('location b', 'a.location_id = b.location_id');
					$this->db->where('a.company_id',$id);
					$this->db->where('a.approver_id',$evaluator);
			
						
					$result = $this->db->get();
					return $result->num_rows();

}
		public function get_count_section_evaluator($id,$evaluator,$ref){
					$this->db->distinct();
					$this->db->select('a.section_id');
					$this->db->from('pms_form_evaluators a');
					$this->db->join('employee_info e', 'a.evaluator_id = e.employee_id','left');
					$this->db->join('section b', 'a.section_id = b.section_id');
					$this->db->where('a.company_id',$id);
					$this->db->where('a.evaluator_id',$evaluator);
					// $this->db->where('ref',$ref);
						
					$result = $this->db->get();
					return $result->num_rows();

}


public function get_count_location_evaluator($id,$evaluator,$re){
					$this->db->distinct();
					$this->db->select('a.location_id');
					$this->db->from('pms_form_evaluators a');
					$this->db->join('employee_info e', 'a.evaluator_id = e.employee_id','left');
					$this->db->join('location b', 'a.location_id = b.location_id');
					$this->db->where('a.company_id',$id);
					$this->db->where('a.evaluator_id',$evaluator);
			
						
					$result = $this->db->get();
					return $result->num_rows();

}


public function get_count_dept_evaluator($id,$evaluator){
					$this->db->distinct();
					$this->db->select('a.department_id');
					$this->db->from('pms_form_evaluators a');
					$this->db->join('employee_info e', 'a.evaluator_id = e.employee_id','left');
					$this->db->join('department b', 'a.department_id = b.department_id');
					$this->db->where('a.company_id',$id);
					$this->db->where('a.evaluator_id',$evaluator);
						
					$result = $this->db->get();
					return $result->num_rows();

}

	public function save_approver_transaction($co){
				$this->db->select('*');
				$this->db->from('transaction_approvers');
	
				$this->db->where('company',$co);
				$query = $this->db->get();//admin_emp_masterlist_view
				$c =  $query->result();

	
				$insertArray = array();		
				foreach($c as $c){
				
				
			
				$new_add = array(
						'employee_id'=>'test',
						'creator' =>$c->approver,
						'location_name'=>$c->location, 
						'department_id' => $c->department,
						'classification_name'=>$c->classification,
						'company_id'=> $c->company,
						'approval_level' => $c->approval_level,
						'section_id'=>$c->section,
						'ref'=>'test',
				

					);
				array_push($insertArray,$new_add);
				
				}
		
		
				
		$this->db->insert_batch('pms_creators_option2', $insertArray);
}
	public function save_score_option2($id,$co){

		
		$de = $this->input->post('department',true);
		$l = $this->input->post('location',true);
		$ca = $this->input->post('classification',true);
		$s = $this->input->post('section',true);
		$idd = $this->input->post('idd'); //array of id
		$this->db->select('*,a.employee_id as employee_id');
		$this->db->from('employee_info a');
		$this->db->join('location b', 'a.location = b.location_id','left');
		$this->db->join('department c', 'a.department = c.department_id','left');
		$this->db->join('classification d', 'a.classification = d.classification_id','left');
		$this->db->join('section e', 'c.department_id = e.department_id','left');
	
		if($l !='all'){
		$this->db->where('b.location_id',$l);
		}
		if($de !='all'){
		$this->db->where('c.department_id',$de);
		}
		if($ca !='all'){
		$this->db->where('d.classification_id',$ca);
		}
		if($s !='all'){
		$this->db->where('e.section_id',$s);
		}
		$this->db->group_by('a.employee_id');

		$query1 = $this->db->get();
		$q =  $query1->result();
		$insertArray = array();
		$w = date("Y-m-d H:i:s");
		foreach($q as $q){
				$new_add = array(
						'employee_id'=>$q->employee_id,
						'creator' =>$id,
						'location_name'=>$q->location_id,
						'department_id' => $q->department_id,
						'classification_name'=>$q->classification_id,
						'company_id'=> $this->input->post('company_'),
						'approval_level' => $this->input->post('level'),
						'section_id'=>$q->section_id,
						'ref'=>$w,
				

					);
				array_push($insertArray,$new_add);

		}
		
				
		$this->db->insert_batch('pms_creators_option2', $insertArray);
			

				
			


			
		}
	public function save_appraisal_member(){
			$name_array = $this->input->post('mem',true);
			$id = $this->input->post('id',true);
			$g = $this->input->post('group_id');
			$ca = $this->input->post('classification_all',true);
			$l = $this->input->post('location_all',true);
			$de = $this->input->post('departments',true);
	

			for ($i = 0; $i < count($name_array); $i++) {
				$res = $this->pms_model->mem_exists('name','pms_appraisal_members',$name_array[$i] , 'group_id',$g);//dapat merong where na kung anong group sya
				$count = count($res);
				if(empty($count)){	

					$data = array(
						'name' =>  $name_array[$i],
						'location_name' =>  $l[$i],
						'classification_name' => $ca[$i] ,
						'department_name' => $de[$i],
						'group_id' => $id,
						'company_id' => $this->input->post('company_'),
						'section_name' => $this->input->post('section')

					);
					$this->db->insert('pms_appraisal_members', $data);
				}



			}
		}
			public function save_evaluator_option2($id){
					$this->db->insert_batch('pms_form_evaluators', $id);

			
		}



	public function save_g(){
			$data = array(
				'appraisal_group_name' => $this->input->post('group_name'),

				'appraisal_group_details' => $this->input->post('group_details'),

				'company_id' => $this->input->post('company_')



			);
			$this->db->insert('pms_appraisal_group', $data);
		}


	public function get_appraisal_form($company_id){
			$this->db->select('*');
			$this->db->from('pms_appraisal_form');
			$this->db->join('pms_grading_default', 'pms_appraisal_form.grading_type = pms_grading_default.grading_type');
			
			$this->db->where('pms_appraisal_form.company_id',$company_id);




		$query = $this->db->get();
		return $query->result();
	}
	public function get_criteria($id){
		$this->db->select('*');
		$this->db->where('fid',$id);



		$query = $this->db->get('pms_criteria_form');//admin_emp_masterlist_view
		return $query->result();
	}
	public function get_total_weight($id){
		$this->db->select_sum('weight');
		$this->db->from('pms_appraisal_form');
		$this->db->where('company_id',$id);
		$query = $this->db->get();
		return $query->row()->weight;
	}	


			public function get_weights($cid,$areaid){
				     $this->db->select('*');
					$this->db->from('pms_criteria_job');
				
					$this->db->where('cid',$cid);
					$this->db->where('area_weight_id',$areaid);

					$query = $this->db->get();
					return  $query->result();

	}

	public function get_multi(){

		$this->db->select('*');
		$this->db->from('employee_info a'); 
		$this->db->join('pms_form_evaluators b', 'a.employee_id = b.evaluator_id');
			if($this->input->post('csection') != 'all'){
		$this->db->join('section c', 'b.section_id = c.section_id');
	}
			if($this->input->post('cclassification') != 'all'){
		 $this->db->join('classification d', 'b.classification_id = d.classification_id','left');	
		 }	
		 
		if($this->input->post('clocation') != 'all'){
		 $this->db->join('location e', 'b.location_id = e.location_id');
		}
		if($this->input->post('cdepartment') != 'all'){
		$this->db->join('department f', 'b.department_id = f.department_id');
	}

		 $this->db->where('evaluator_id',$this->input->post('q'));
	
	 // $this->db->join('classification b', 'a.classification = b.classification_id');		
		// $this->db->join('section d', 'a.section = d.section_id');
		// $this->db->join('location e', 'a.location = e.location_id');
		// $this->db->where('a.classification',$this->input->post('cclassification'));

		$query = $this->db->get();//admin_emp_masterlist_view
		return $query;
	}

	public function load_approver($dept,$section,$company){
		
		$this->db->where(array(
			'a.department'			=>		$dept,
			
			'a.section'				=>	$section,
			'a.company'				=>	$company
		));
		$this->db->join('employee_info b', 'a.approver = b.employee_id');	
		$this->db->join('location c', 'a.location = c.location_id','left');
		$this->db->join('section d', 'a.section = d.section_id','left');
		$this->db->join('department e', 'a.department = e.department_id','left');
		$this->db->join('classification f', 'a.classification = f.classification_id');	
		$this->db->group_by(array("approval_level", "approver"));
		$query = $this->db->get("transaction_approvers a");
		return $query->result();
	}
		public function get_weight($id){
		$this->db->select('*');
		$this->db->where('fid',$id);
		$query = $this->db->get('pms_job');
		return $query->result();
	}


	public function get_payroll_period_group(){


		$this->db->select('*');
		$this->db->from('pay_type');




		$query = $this->db->get();//admin_emp_masterlist_view
		return $query->result();
	}
	

	public function qwe($id){

		$this->db->select('*');
		$this->db->from('pms_criteria_form');
		$this->db->where('fid',$id);
		$query = $this->db->get();//admin_emp_masterlist_view
		return $query->num_rows();
	}


	public function update_criteria_form(){
		$id = $this->input->post('id');
		$data1 = array(
			'area' =>  $this->input->post('area'),
			'level' =>  $this->input->post('level'),
			'target' =>  $this->input->post('target'),
			'measurement' =>  $this->input->post('measurement'),
			'position' => $this->input->post('cover')




		);
		$this->db->where('criteria_id',$id);
		$this->db->update('pms_criteria_form',$data1);


		$weight = $this->input->post('weight');
		$description = $this->input->post('description');
					$idd = $this->input->post('idd'); //array of id

					$data2 = array();
					for($x = 0; $x < sizeof($idd); $x++){


						$data2[] = array(
							'id'=>$idd[$x],
							'weight'=>$weight[$x],
							'description' =>$description[$x]
						);
					}  




					$this->db->update_batch('pms_area_weight',$data2,'id');
				}

	public function get_department($company){
		$this->db->where('company_id',$company);
					$query = $this->db->get('department');
					return $query->result();

				}
	public function load_section($dept){
		
		$this->db->where(array(
			'department_id'			=>		$dept,
			'InActive'				=>		0
		));	
		$query = $this->db->get("section");
		return $query->result();
	}
	public function get_classification($company){
			$this->db->where('company_id',$company);
					$query = $this->db->get('classification');
					return $query->result();

				}

	public function get_multi_apro(){

	

		$this->db->select('*');
		$this->db->from('employee_info a'); 
		$this->db->join('pms_form_approvers b', 'a.employee_id = b.approver_id');
			if($this->input->post('csection') != 'all'){
		$this->db->join('section c', 'b.section_id = c.section_id');
	}
			if($this->input->post('cclassification') != 'all'){
		 $this->db->join('classification d', 'b.classification_id = d.classification_id','left');	
		 }	
		 
		if($this->input->post('clocation') != 'all'){
		 $this->db->join('location e', 'b.location_id = e.location_id');
		}
		if($this->input->post('cdepartment') != 'all'){
		$this->db->join('department f', 'b.department_id = f.department_id');
	}

		 $this->db->where('approver_id',$this->input->post('q'));
	
	 // $this->db->join('classification b', 'a.classification = b.classification_id');		
		// $this->db->join('section d', 'a.section = d.section_id');
		// $this->db->join('location e', 'a.location = e.location_id');
		// $this->db->where('a.classification',$this->input->post('cclassification'));

		$query = $this->db->get();//admin_emp_masterlist_view
		return $query;
	

	}

	public function get_member($department){
					$this->db->where('group_id',$department);
					$this->db->group_by("name");
					$query = $this->db->get('pms_appraisal_members');
					return $query->result();
				}

	public function update_position_department($data){
		$d = $this->input->post('val');
		$this->db->where('criteria', $d);
		$this->db->where('company_id', $this->input->post('company_'));
		$this->db->update('pms_manage_employees_development_plan', $data);

	}
	public function get_set_seperate_setup_approvers($co){
					$this->db->select('*');
					$this->db->from('pms_form_approvers a');
			
					$this->db->join('employee_info e', 'a.employee_id = e.employee_id','left');

					$this->db->where('a.company_id',$co);


					$query = $this->db->get();
					return $query->result();

				}
	public function get_set_seperate_setup($co){
					$this->db->select('*');
					$this->db->from('pms_form_evaluators a');
			
					$this->db->join('employee_info e', 'a.employee_id = e.employee_id','left');

					$this->db->where('a.company_id',$co);


					$query = $this->db->get();
					return $query->result();

				}
					public function with_subsection($val)
	{
		$this->db->where(array(
			'section_id'			=>		$val,
			'wSubsection'				=> 		1
		));	
		$query = $this->db->get("section");
		return $query->num_rows();
	}
	public function get_location(){
				
					$query = $this->db->get('location');
					return $query->result();
				}
	public function get_section($id){
					
					 $this->db->where('department_id',$id);
					$query = $this->db->get('section');
					
					return $query->result();
				}
	public function update_employee_objectives(){
					$id = $this->input->post('id');
					$data = array(
						'name' => $this->input->post('name'),

						'objectives' => $this->input->post('objectives'),

						'company_id' =>$this->input->post('company_')
					);
					$this->db->where('id',$id);
					$this->db->update('pms_employee_objectives',$data);
					
				}

	public function update_appraisal_schedule(){
					$id = $this->input->post('id');
					if(!empty($this->input->post('payroll_period_group_id'))){
						$column_field = 'payroll_period_group_id';
						$value = $this->input->post('payroll_period_group_id');
					}elseif( !empty($this->input->post('appraisal_type_group_id'))){
						$column_field = 'appraisal_group_id';
						$value = $this->input->post('appraisal_type_group_id');
					}elseif(!empty($this->input->post('appraisal_company'))){
							$column_field = 'appraisal_company_id';
						$value = $this->input->post('appraisal_company');
					}
					$data = array(
						'cover_year' => $this->input->post('cover_year'),
						$column_field => $value,
						'appraisal_period_type_id' => $this->input->post('appraisal_period_type_id'),
						'number_days' => $this->input->post('number_of_days')
						


					);
					$this->db->where('mid',$id);
					$this->db->update('pms_manage_appraisal_schedule',$data);
					


				}
					public function position_department($id){
					$this->db->select('*');
					$this->db->from('pms_manage_employees_development_plan a');
					 $this->db->join('department b', 'a.department = b.department_id');
					 	 $this->db->join('position d', 'a.position = d.position_id');
					 	 	$this->db->where('a.company_id',$id);




					$query = $this->db->get();
					return $query->row();
				}

public function save_position_department($data){
		$this->db->insert('pms_manage_employees_development_plan', $data);

	}

	public function update_general_objectives(){
					$id = $this->input->post('id');
					$data = array(
						'position' => $this->input->post('position'),

						'objective_topics' => $this->input->post('objective_topics'),
						'objective_details' => $this->input->post('objective_details'),
						'company_id' =>$this->input->post('company_')
					);
					$this->db->where('id',$id);
					$this->db->update('pms_general_objectives',$data);
					
				}
				public function save_lock_un($id){

						$this->db->select('*');
					$this->db->from('pms_settings_lock');
	
					$this->db->where('company_id',$id);

					$query = $this->db->get();
					$q=  $query->num_rows();

						if($q > 0){
										$data4 = array(
						
						'lock' => $this->input->post('w'),
					
						'company_id' => $id,

						


					);
					$this->db->where('company_id',$id);
					$this->db->update('pms_settings_lock',$data4);	
						}else{
											$data4 = array(
						
						'lock' => 1,
					
						'company_id' => $id,

						


					);
					$this->db->where('company_id',$id);
					$this->db->insert('pms_settings_lock',$data4);	

						}


				
				}
	public function update_pms_appraisal_group(){
		
					$id = $this->input->post('id');
					$data = array(
						'appraisal_group_name' => $this->input->post('group_name'),

						'appraisal_group_details' =>$count
					);
					$this->db->where('appraisal_group_id',$id);
					$this->db->update('pms_appraisal_group',$data);
					
		
				
				}
				public function get_eval_appro_score($id){
					$this->db->select('*');
					$this->db->from('pms_aprov_eval_creator');
	
					$this->db->where('company_id',$id);

					$query = $this->db->get();
					return $query->row();
				}
					public function lock($id){
					$this->db->select('*');
					$this->db->from('pms_settings_lock');
	
					$this->db->where('company_id',$id);

					$query = $this->db->get();
					return $query->row();
				}
public function evacuate($id){
	$this->db->select('*');
					$this->db->from('pms_settings_evalself');
	
					$this->db->where('company_id',$id);

					$query = $this->db->get();
						$datas = array(
					'self_eval' => $this->input->post('radio_self',true),
					
						'company_id' => $id
						


					);

					if($query->num_rows() == ""){                                                             
					
						$this->db->insert('pms_settings_evalself', $datas);
					}else{
							
		$datas = array(
						'self_eval' => $this->input->post('radio_self',true),
					
						'company_id' => $id
						


					);
					$this->db->where('company_id',$id);
					$this->db->update('pms_settings_evalself',$datas);	
					}
	
}
				public function get_eval_appro_score_max($id){
					$this->db->select('*');
					$this->db->from('pms_aprov_eval_creator');
	
					$this->db->where('company_id',$id);

					$query = $this->db->get();
					return $query->row();
				}
				public function save_eval_appro_score($id){
								$this->db->select('*');
					$this->db->from('pms_aprov_eval_creator');
	
					$this->db->where('company_id',$id);

					$query = $this->db->get();
						$data = array(
						'approver' => $this->input->post('approver',true),
						'evaluator' => $this->input->post('evaluator',true),
						'creator' =>$this->input->post('creator',true),
						'company_id' => $id
						


					);

					if($query->num_rows() == ""){
					
						$this->db->insert('pms_aprov_eval_creator', $data);
					}else{
						$this->db->where('company_id',$id);
						$this->db->update('pms_aprov_eval_creator',$data);
					}
					$this->evacuate($id);
					$this->computation($id);
					
				}
				public function computation($id){


									$this->db->select('*');
					$this->db->from('pms_settings_computation');
	
					$this->db->where('company_id',$id);

					$query = $this->db->get();
						$datas = array(
						'computation_type' => $this->input->post('radio1',true),
					
						'company_id' => $id
						


					);

					if($query->num_rows() == ""){
					
						$this->db->insert('pms_settings_computation', $datas);
					}else{
								$datas = array(
						'computation_type' => $this->input->post('radio1',true),
					
						'company_id' => $id
						


					);
									$this->db->where('company_id',$id);
					$this->db->update('pms_settings_computation',$datas);
					}



							
				
				}

	public function update_grading_table(){
					$id = $this->input->post('hidden');
					$data = array(
						'scoring_guide' => $this->input->post('update_scoring_guide',true),

						'score_equivalent' => $this->input->post('update_score_equivalent',true),
						'score' =>$this->input->post('update_score',true),
						'ranking' => $this->input->post('update_ranking',true)


					);



					$this->db->where('gid',$id);
					$this->db->update('pms_grading_table',$data);
				}


	public function update_general_form(){
					$id = $this->input->post('hidden');
					$data = array(
						'form_title' => $this->input->post('update_form_title',true),
						'form_description' => $this->input->post('update_form_description',true),
						'form_instruction' => $this->input->post('update_form_instruction',true),
						'grading_type' =>$this->input->post('update_grading_type',true),
						'weight' => $this->input->post('update_weight',true),

					);



					$this->db->where('fid',$id);
					$this->db->update('pms_appraisal_form',$data);
				}

	public function get_grading_scale($fid,$company_){

					$this->db->select('*');
					$this->db->from('pms_appraisal_form');
					$this->db->join('pms_grading_table', 'pms_appraisal_form.fid = pms_grading_table.fid');
					$this->db->where('pms_grading_table.fid !=',$fid);	
					$this->db->where('pms_grading_table.company_id',$company_);
					$this->db->group_by("form_title");

					// $this->db->where('pms_grading_table.fid',$fid);


					$query = $this->db->get();
					return $query->result();
				}
	public function get_calee($fid){

					$this->db->select('*');
					$this->db->from('pms_grading_table');
					$this->db->where('pms_grading_table.fid',$fid);
					// $this->db->where('pms_grading_table.fid',$fid);


					$query = $this->db->get();
					return $query->result();
				}
					public function eposition($id){
					$this->db->select('*');
					$this->db->from('pms_manage_employees_development_plan a');
					 $this->db->join('department b', 'a.department = b.department_id');
				
					 	 $this->db->join('position d', 'a.position = d.position_id');
					 	 	$this->db->where('a.company_id',$id);




					$query = $this->db->get();
					return $query->row();
				}
					public function position_department_section($id){
					$this->db->select('*');
					$this->db->from('pms_manage_employees_development_plan a');
					 $this->db->join('department b', 'a.department = b.department_id');
					 $this->db->join('section c', 'a.section = c.section_id');
					 	 $this->db->join('position d', 'a.position = d.position_id');
					 	 	$this->db->where('a.company_id',$id);




					$query = $this->db->get();
					return $query->row();
				}

	public function get_grading_table($fid){

					$this->db->select('*');
					$this->db->from('pms_grading_table');
					// $this->db->join('pms_grading_default', 'pms_grading_table.grading_type = pms_grading_default.grading_type');
					$this->db->where('pms_grading_table.fid',$fid);

					$query = $this->db->get();
					return $query->result();
				}
public function get_location_arr($q){
					$this->db->select('*');
					$this->db->from('location a');
					$this->db->where('location_id',$q);
					


					$query = $this->db->get();
					return $query->row();
	}			
		public function get_classification_arr($q){
					$this->db->select('*');
					$this->db->from('classification a');
					$this->db->where('classification_id',$q);


					$query = $this->db->get();
					return $query->row();
	}		
		public function get_department_arr($q){
					$this->db->select('*');
					$this->db->from('department a');
					$this->db->where('department_id',$q);
					


					$query = $this->db->get();
					return $query->row();
	}		

	public function get_section_arr($q){
					$this->db->select('*');
					$this->db->from('section a');
					$this->db->where('section_id',$q);
					


					$query = $this->db->get();
					return $query->row();
	}		
	public function get_scorecard_creator_option2($id){
					$res = $this->get_scorecard_($id);
					if($res->creators_type ==2){
					$this->db->select('*,d.classification as classification');
					$this->db->from('pms_creators_option2 a');
	
					$this->db->join('employee_info e', 'a.creator = e.employee_id','left');
					$this->db->join('location b', 'a.location_name = b.location_id','left');
					$this->db->join('department c', 'a.department_id = c.department_id','left');
					$this->db->join('classification d', 'a.classification_name = d.classification_id','left');
					$this->db->join('section f', 'a.section_id = f.section_id','left');
					$this->db->group_by('a.creator');
					}elseif($res->creators_type ==4){
					$this->db->select('*,d.classification as classification');
					$this->db->from('pms_creators_approvers_setup a');
	
					$this->db->join('employee_info e', 'a.creator = e.employee_id','left');
					$this->db->join('location b', 'a.location_name = b.location_id','left');
					$this->db->join('department c', 'a.department_id = c.department_id','left');
					$this->db->join('classification d', 'a.classification_name = d.classification_id','left');
					$this->db->join('section f', 'a.section_id = f.section_id','left');
					$this->db->group_by('a.creator');	

					}
			
					
					$this->db->where('a.company_id',$id);


					$query = $this->db->get();
					return $query->result();
				}
	public function get_employee_info($q){
					$this->db->select('*');
					$this->db->from('employee_info a');
					$this->db->where('employee_id',$q);
					


					$query = $this->db->get();
					return $query->row();
	}			






	public function get_apprauisal_appro_def(){

					$this->db->select('*');
					$this->db->from('pms_approver_default');
					// $this->db->join('pms_grading_default', 'pms_grading_table.grading_type = pms_grading_default.grading_type');


					$query = $this->db->get();
					return $query->result();
				}


	public function get_scorecard_creator_default(){

					$this->db->select('*');
					$this->db->from('pms_scorecard_creators_default');
					// $this->db->join('pms_grading_default', 'pms_grading_table.grading_type = pms_grading_default.grading_type');


					$query = $this->db->get();
					return $query->result();
				}
				public function get_selected_plan_type($id){

					$this->db->select('*');
					$this->db->from('pms_manage_employees_development_plan_type');
					$this->db->where('company_id', $id);
					
					// $this->db->join('pms_grading_default', 'pms_grading_table.grading_type = pms_grading_default.grading_type');


					$query = $this->db->get();
					return $query->row();
				}
public function get_count_classification_approver($id,$approver){
					$this->db->distinct();
					$this->db->select('a.classification_id');
					$this->db->from('pms_form_approvers a');
					$this->db->join('employee_info e', 'a.approver_id = e.employee_id','left');
					$this->db->join('classification b', 'a.classification_id = b.classification_id');
					$this->db->where('a.company_id',$id);
					$this->db->where('a.approver_id',$approver);
					
						
					$result = $this->db->get();
					return $result->num_rows();

}

	public function get_scorecard_evaluator_option2($id){
			$this->db->select('*,d.classification as classification,a.location_id as loca,a.classification_id as class,a.department_id as dep,a.section_id as secc');
					$this->db->from('pms_form_evaluators a');
	

					$this->db->join('employee_info e', 'a.evaluator_id = e.employee_id','left');
					$this->db->join('location b', 'a.location_id = b.location_id','left');
					$this->db->join('department c', 'a.department_id = c.department_id','left');
					$this->db->join('classification d', 'a.classification_id = d.classification_id','left');
					$this->db->join('section f', 'a.section_id = f.section_id','left');
			
					$this->db->group_by('a.evaluator_id');
					$this->db->order_by('a.eid','asc');

					$this->db->where('a.company_id',$id);


					$query = $this->db->get();
					return $query->result();
				}		public function get_count_section_approver($id,$approver,$ref){
					$this->db->distinct();
					$this->db->select('a.section_id');
					$this->db->from('pms_form_approvers a');
					$this->db->join('employee_info e', 'a.approver_id = e.employee_id','left');
					$this->db->join('section b', 'a.section_id = b.section_id');
					$this->db->where('a.company_id',$id);
					$this->db->where('a.approver_id',$approver);
					
						
					$result = $this->db->get();
					return $result->num_rows();

}

	public function get_selected_form_approv($id){

					$this->db->select('*');
					$this->db->from('pms_manage_form_approver_type');
					$this->db->where('company_id', $id);
					
					// $this->db->join('pms_grading_default', 'pms_grading_table.grading_type = pms_grading_default.grading_type');


					$query = $this->db->get();
					return $query->row();
				}
			public function get_approvers($id){

					$this->db->select('b.creators_type , b.id , a.aid');
					$this->db->from('pms_manage_form_approver_type a');
					$this->db->join('pms_approver_default b', 'a.creators_type = b.id');
					$this->db->where('a.company_id',$id);

					// $this->db->join('pms_grading_default', 'pms_grading_table.grading_type = pms_grading_default.grading_type');


					$query = $this->db->get();
					return $query->row();
				}				
	public function get_selected_form_good($id){

					$this->db->select('*');
					$this->db->from('pms_manage_form_evaluators_type');
					$this->db->where('company_id', $id);
					
					// $this->db->join('pms_grading_default', 'pms_grading_table.grading_type = pms_grading_default.grading_type');


					$query = $this->db->get();
					return $query->row();
				}

		public function get_selected_form_default($id){

					$this->db->select('*');
					$this->db->from('pms_manage_form_score_type');
					$this->db->where('company_id', $id);
					
					// $this->db->join('pms_grading_default', 'pms_grading_table.grading_type = pms_grading_default.grading_type');


					$query = $this->db->get();
					return $query->row();
				}
				public function remove_approver($employee_id){
					$this->db->select('*');
					$this->db->from('pms_form_evaluators');
					$this->db->where('employee_id',$employee_id);


					$query = $this->db->get();
					return $query->num_rows();
					
				}
					public function get_scorecard_approver_option2($id){
					$this->db->select('*,d.classification as classification,a.location_id as loca,a.classification_id as class,a.department_id as dep,a.section_id as secc');
					$this->db->from('pms_form_approvers a');
					

			    	$this->db->join('employee_info e', 'a.approver_id = e.employee_id','left');
					$this->db->join('location b', 'a.location_id = b.location_id','left');
					$this->db->join('department c', 'a.department_id = c.department_id','left');
					$this->db->join('classification d', 'a.classification_id = d.classification_id','left');
					$this->db->join('section f', 'a.section_id = f.section_id','left');
					$this->db->group_by('a.approver_id',$id);
					$this->db->order_by('a.aid','asc');
					$this->db->where('a.company_id',$id);


					$query = $this->db->get();
					return $query->result();
				}	
public function get_score($id){

					$this->db->select('b.creators_type , b.id , a.eid');
					$this->db->from('pms_manage_form_score_type a');
					$this->db->join('pms_scorecard_creators_default b', 'a.creators_type = b.id');
					$this->db->where('a.company_id',$id);

					// $this->db->join('pms_grading_default', 'pms_grading_table.grading_type = pms_grading_default.grading_type');


					$query = $this->db->get();
					return $query->row();
				}	
		
	public function get_evaluators($id){

					$this->db->select('b.creators_type , b.id , a.eid');
					$this->db->from('pms_manage_form_evaluators_type a');
					$this->db->join('pms_evaluators_default b', 'a.creators_type = b.id');
					$this->db->where('a.company_id',$id);

					// $this->db->join('pms_grading_default', 'pms_grading_table.grading_type = pms_grading_default.grading_type');


					$query = $this->db->get();
					return $query->row();
				}	


	public function get_form_def(){

					$this->db->select('*');
					$this->db->from('pms_evaluators_default');

					// $this->db->join('pms_grading_default', 'pms_grading_table.grading_type = pms_grading_default.grading_type');


					$query = $this->db->get();
					return $query->result();
				}

		public function get_form_scorecard(){

					$this->db->select('*');
					$this->db->from('pms_evaluators_default');

					// $this->db->join('pms_grading_default', 'pms_grading_table.grading_type = pms_grading_default.grading_type');


					$query = $this->db->get();
					return $query->result();
				}			

	public function get_scorecard_creator_option3($id){
					$this->db->select('*');
					$this->db->from('pms_creators_approvers_setup a');
					$this->db->join('employee_info b', 'a.employee_id = b.employee_id');
					$this->db->join('position c', 'a.position_id = c.position_id');
					$this->db->where('a.company_id',$id);

					$query = $this->db->get();
					return $query->result();
				}





	public function get_update_criteria_form($fid,$c){


					$this->db->where('fid', $fid);
					$this->db->where('criteria_id',$c);
		$query = $this->db->get('pms_criteria_form');//admin_emp_masterlist_view

		return $query->result();
	}
	public function appraisal_type(){
		$query = $this->db->get('pms_appraisal_type');//admin_emp_masterlist_view

		return $query->result();
	}

	public function appraisal_period_type(){
		$query = $this->db->get('pms_appraisal_period_type');//admin_emp_masterlist_view

		return $query->result();
	}



	public function get_update_general_form($id){

		$this->db->where('fid', $id);
		$query = $this->db->get('pms_appraisal_form');//admin_emp_masterlist_view

		return $query->result();
	}
	public function get_update_general_objectives($id){

		$this->db->where('id', $id);
		$query = $this->db->get('pms_general_objectives');//admin_emp_masterlist_view

		return $query->result();
	}
	
	public function get_update_appraisal_schedule($id){


		$this->db->SELECT('*');
		$this->db->from('pms_manage_appraisal_schedule');
		$this->db->join('pms_appraisal_period_type', 'pms_manage_appraisal_schedule.appraisal_period_type_id = pms_appraisal_period_type.id','left');
		$this->db->join('pms_appraisal_group', 'pms_manage_appraisal_schedule.appraisal_group_id = pms_appraisal_group.appraisal_group_id','left');

		$this->db->join('pay_type', 'pms_manage_appraisal_schedule.payroll_period_group_id = pay_type.pay_type_id','left');
			$this->db->join('company_info', 'pms_manage_appraisal_schedule.appraisal_company_id = company_info.company_id','left');
		$this->db->where('pms_manage_appraisal_schedule.mid', $id);
		$query = $this->db->get();
		return $query->result();
	}


	public function position()
	{

		$query = $this->db->get('position');
		return $query->result();
	}
	public function get_update_employee_objectives($id){

		$this->db->where('id', $id);
		$query = $this->db->get('pms_employee_objectives');//admin_emp_masterlist_view

		return $query->result();
	}
	public function save_position($data){
		$this->db->insert('pms_manage_employees_development_plan', $data);

	}
		public function update_position($data){
		$d = $this->input->post('val');
		$this->db->where('criteria', $d);
		$this->db->where('company_id', $this->input->post('company_'));
		$this->db->update('pms_manage_employees_development_plan', $data);

	}

	public function get_update_grading_table($id){
		$this->db->SELECT('*');
		$this->db->from('pms_grading_table a');
		$this->db->join('pms_appraisal_form b', 'a.fid = b.fid');
		$this->db->where('a.gid', $id);
		$query = $this->db->get();//admin_emp_masterlist_view

		return $query->result();
	}

	public function add_grading_table($data){


		$this->db->insert('pms_grading_table', $data);


	}

		public function update_position_department_section_development($data){
$d = $this->input->post('val');
		$this->db->where('criteria', $d);
		$this->db->where('company_id', $this->input->post('company_'));
		$this->db->update('pms_manage_employees_development_plan', $data);

	}
		public function save_position_department_section_development($data){
		$this->db->insert('pms_manage_employees_development_plan', $data);

	}
	public function add_pms_general($data){
		$this->db->insert('pms_general_objectives', $data);

	}
	public function add_pms_empoyee($data){
		$this->db->insert('pms_employee_objectives', $data);

	}
	public function get_max_form($id){
		$this->db->SELECT('form_part');
		$this->db->from('pms_appraisal_form');
			$this->db->where('company_id', $id);





		$query = $this->db->get();
		return $query->result();
	}
	public function add_general_form(){
		$data = array(
			'form_title' => $this->input->post('form_title',true),
			'grading_type' => $this->input->post('radio',true),
			'form_instruction' => $this->input->post('instruction',true),
			'date_added' =>  date('Y-m-d H:i:s'),
			'form_description' => $this->input->post('form_description',true),                   
			// 'weight' => $this->input->post('weight',true),
			'company_id' => $this->input->post('company_'),
			'form_part' => $this->input->post('form_part',true)                                                                                                                                                                                                                 
		);
		
		$this->db->insert('pms_appraisal_form', $data);
				$pjesma_id = $this->db->insert_id();



		$weight=$this->input->post('weight[]');
		$job=$this->input->post('job[]');
		$insertArray = array();
		$array_combine =  array_combine($job, $weight);
		foreach($array_combine as $job => $weight) {
			$new_add = array(
				'weight'=>$weight,
				'job_level'=>$job,
				'fid' => $pjesma_id
			);
			array_push($insertArray,$new_add);
		}

		
		$this->db->insert_batch('pms_job', $insertArray);


	}
	public function get_update_appraisal_group($id){

		$company_ = $this->input->post('company_');
		$this->db->SELECT('*');
		$this->db->from('pms_appraisal_group');

		$this->db->where('appraisal_group_id', $id);



		$query = $this->db->get();
		return $query->result();
	}
	public function add_manage_appraisal_schedule($data){



		$this->db->insert('pms_manage_appraisal_schedule', $data);


	}

	public function delete_member($id){


		$this->db->where('id', $id);
		$this->db->delete('pms_appraisal_members');

	}
	public	function delete_group($id){
		$this->db->where('appraisal_group_id', $id);

		$this->db->delete('pms_appraisal_group');

		$this->db->where('group_id', $id);

		$this->db->delete('pms_appraisal_members');

	}
	public function delete_scorecard_option2($id){


		$this->db->where('ref', $id);
		$this->db->delete('pms_creators_option2');
	}
	public function delete_type_schedule($id,$id4){

		$this->db->where('ref', $id4);
		$this->db->delete('pms_appraisal_schedule_member');
	
		$this->db->where('ref', $id4);
		$this->db->delete('pms_manage_appraisal_schedule');
	}
	public function delete_general_objectives($id){


		$this->db->where('id', $id);
		$this->db->delete('pms_general_objectives');
	}

	public function delete_employee_objectives($id){


		$this->db->where('id', $id);
		$this->db->delete('pms_employee_objectives');
	}
	public function delete_scorecard_option3($id){


		$this->db->where('cid', $id);
		$this->db->delete('pms_creators_approvers_setup');
	}
	
	public function add_criteria_form(){



		$data1 = array(
			'area' => $this->input->post('area_name',true),
			'fid' => $this->input->post('idcriteria',true),
			'measurement' => $this->input->post('measurement',true),
			'level' => $this->input->post('level',true),
			'target' => $this->input->post('target',true),
			'position'=>$this->input->post('cover'),
			'company_id' => $this->input->post('company_',true),
			
			
			
		);


		$this->db->insert('pms_criteria_form', $data1);
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
			$this->db->insert('pms_area_weight', $new_add);
			$area = $this->db->insert_id();
			  $criteria = array('executive','manager','supervisor','specialist','skilled/unskilled');
	

		foreach($criteria as $critera) {
			$takte = array(
				'cid'=>$pjesma_id,
				'job_level'=> $critera,
				'area_weight_id' =>$area,
				'weight'=> $weight,
				'fid' => $this->input->post('idcriteria',true)
			
			);
			$this->db->insert('pms_criteria_job', $takte);
		}
		}

		
		


	

		
		
	}


	public function getgradingtype($fid){
		$this->db->where('fid',$fid);
		$query = $this->db->get('pms_appraisal_form');
		return $query->row();
	}
	public function get_general_instruction($company)
	{
		$this->db->select('*');
		$this->db->join('company_info B','A.company_id = B.company_id');
		$this->db->where('A.company_id',$company);
		$query = $this->db->get('pms_general_instruction A');
		return $query->row();

	}public function delete_all_from_approvers($id){
		$this->db->where('approver_id', $id);

		$this->db->delete('pms_form_approvers');
	}

	public function userUpdateFunction($data, $userId){
		$data = array('instruction' => $data);
		$this->db->where('id', $userId);
		$this->db->update('pms_general_instruction', $data);
		return true;

	}


	public function delete_form_evaluators($id){
		$this->db->where('evaluator_id', $id);

		$this->db->delete('pms_form_evaluators');
	}
	public function deleting_grade($id,$comp){
		$this->db->where('gid', $id);
		$this->db->where('company_id', $comp);
		$this->db->delete('pms_grading_table');
	}


	public function delete_criteria($id,$comp){
		$tables = array('pms_criteria_form', 'pms_area_weight');
		$this->db->where('criteria_id',$id);


		$this->db->delete($tables);
	}
	public function delete_form($id,$comp){

		$this->db->query("DELETE 
			FROM pms_appraisal_form 
			WHERE pms_appraisal_form.fid = '$id' AND pms_appraisal_form.company_id = '$comp'");
		$this->db->query("DELETE 
			FROM pms_criteria_form 
			WHERE pms_criteria_form.fid = '$id' and pms_criteria_form.company_id = '$comp'");
		$this->db->query("DELETE 
			FROM pms_grading_table 
			WHERE pms_grading_table.fid = '$id' and pms_grading_table.company_id = '$comp'");
		$this->db->query("DELETE 
			FROM pms_area_weight 
			WHERE pms_area_weight.fid = '$id'");
	}

	public function manage_criteria_form($id){
		$this->db->select('*');
		$this->db->from('pms_criteria_form');
		$this->db->where('pms_criteria_form.fid',$id);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_weight_and_description($id){
		$this->db->select('*');
		$this->db->from('pms_area_weight');
		$this->db->where('pms_area_weight.criteria_id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	public function manage_area_weight_form($id){
		$this->db->select('*');
		$this->db->from('pms_area_weight');
		$this->db->where('pms_area_weight.criteria_id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	public function self_eval($id){
		$this->db->select('*');
		$this->db->from('pms_settings_evalself');
		$this->db->where('company_id',$id);
		$query = $this->db->get();
		return $query->row();
	}
	public function computations($id){
		$this->db->select('*');
		$this->db->from('pms_settings_computation');
		$this->db->where('company_id',$id);
		$query = $this->db->get();
		return $query->row();
	}
	public function eval_appro_score($id){
		$this->db->select('*');
		$this->db->from('pms_aprov_eval_creator');
		$this->db->where('company_id',$id);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function pms_evaluators_exists($cname,$q)
	{	
			$c = $this->input->post('company_');
		$this->db->select('*'); 
		$this->db->from('pms_form_evaluators');
		$this->db->where('ref', $cname);
		$this->db->where('evaluator_id',$q);


		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
 
	public function manage_appraisal_group($company_id){
		$this->db->select('*');
		$this->db->from('pms_appraisal_group');
		$this->db->where('pms_appraisal_group.company_id',$company_id);
		$query = $this->db->get();
		return $query->result();
		
	}
	public function save_general_instruction(){
		$data1 = array(
			'company_id' =>  $this->input->post('c'),
			'instruction' => $this->input->post('instruction')

		);
		$this->db->insert('pms_general_instruction' ,$data1);
	}
	public function general_instruction_insert($new_value,$id){

		$column=$_POST['name'];
		$new_value=$_POST['value'];
		$id=$_POST['pk'];
		$company_id= 	$_GET['c'];
		$data1 = array(
			'company_id' =>  $company_id,
			'instruction' => $new_value

		);
		$this->db->insert('pms_general_instruction' ,$data1);

	}

	public function general_instruction_update($new_value,$id,$company_id){
		$this->db->set('instruction', $new_value);
		$this->db->where('id', $id);
		$this->db->update('pms_general_instruction');

	}
public function manage_appraisal_appraisa_data($company_id){
		$this->db->select('appraisal_period_type_dates,mid,cover_year,appraisal_group_name, appraisal_period_type, pay_type_name , number_days, company_name,ref');

		$this->db->from('pms_manage_appraisal_schedule a');
		$this->db->join('pms_appraisal_period_type b', 'a.appraisal_period_type_id = b.id','left');
		$this->db->join('pms_appraisal_group c', 'a.appraisal_group_id = c.appraisal_group_id','left');
		$this->db->join('pay_type d', 'a.payroll_period_group_id = d.pay_type_id','left');
				$this->db->join('company_info e', 'a.appraisal_company_id = e.company_id','left');
		$this->db->where('a.company_id',$company_id);
		
		// $this->db->where('pms_manage_sniappraisal_schedule.company_id',$company_id);
		$query = $this->db->get();
		return $query->result();
		
	}
	public function manage_appraisal_schedule($company_id){
		$this->db->select('appraisal_period_type_dates,mid,cover_year,appraisal_group_name, appraisal_period_type, pay_type_name , number_days, company_name,ref');

		$this->db->from('pms_manage_appraisal_schedule a');
		$this->db->join('pms_appraisal_period_type b', 'a.appraisal_period_type_id = b.id','left');
		$this->db->join('pms_appraisal_group c', 'a.appraisal_group_id = c.appraisal_group_id','left');
		$this->db->join('pay_type d', 'a.payroll_period_group_id = d.pay_type_id','left');
				$this->db->join('company_info e', 'a.appraisal_company_id = e.company_id','left');
		$this->db->where('a.company_id',$company_id);
		$this->db->group_by('a.ref');
		// $this->db->where('pms_manage_sniappraisal_schedule.company_id',$company_id);
		$query = $this->db->get();
		return $query->result();
		
	}

	public function pms_evaluators_exist($cname,$table , $field)
	{	
			$c = $this->input->post('company_');
		$this->db->select('*'); 
		$this->db->from($table);
		$this->db->where($cname, $field);
		$this->db->where('company_id',$c);

		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public	function mem_exists($cname,$table , $field ,$g ,$f)
	{
		$this->db->select('*'); 
		$this->db->from($table);
		$this->db->where($cname, $field);
		$this->db->where($g, $f);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	public	function g($cname,$table , $field,$gid , $cgroup)
	{
		$this->db->select('*'); 
		$this->db->from($table);
		$this->db->where($cname, $field);
		// $this->db->where($gid, $cgroup);

		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public	function groupname_exists($cname,$table , $field)
	{
		$count = $this->input->post('company_');
		$this->db->select('*'); 
		$this->db->from($table);
		$this->db->where($cname, $field);
		$this->db->where('company_id',$count);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public	function employee_exists($cname,$table ,$cname1,$cname2, $field,$field1,$field2)
	{
		$c = $this->input->post('company_');
		$this->db->select('*'); 
		$this->db->from($table);
		$this->db->where($cname, $field);
		$this->db->where($cname1, $field1);
		$this->db->where($cname2, $field2);
		$this->db->where('company_id',$c );
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public	function general_exists($cname,$cname1,$cname2,$table , $field,$field1,$field2)
	{
		$c = $this->input->post('company_');
		$this->db->select('*'); 
		$this->db->from($table);
		$this->db->where($cname, $field);
		$this->db->where($cname1, $field1);
		$this->db->where($cname2, $field2);
		$this->db->where('company_id',$c );

		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
		public	function filename_exists_grading($cname,$table , $field,$fid)
	{
		$this->db->select('*'); 
		$this->db->from($table);
		$this->db->where($cname, $field);
		$this->db->where('fid', $fid);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public	function filename_exists($cname,$table , $field,$company)
	{
		$this->db->select('*'); 
		$this->db->from($table);
		$this->db->where($cname, $field);
		$this->db->where('company_id',$company);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	public	function custom_exist_appraisal_schedule($table,$cname , $cover_year ,$c_appraisal_period_type , $appraisal_period_type,$c_appraisal_type_group_id,$appraisal_type_group_id,$c_payroll_period_group_id,$payroll_period_group_id,$c_company,$appraisal_company)
	{	
		$company_id = $this->input->post('company_');
		$this->db->select('*'); 
		$this->db->from($table);
		$this->db->where($cname, $cover_year);
		$this->db->where($c_appraisal_period_type, $appraisal_period_type);
		$this->db->or_where($c_appraisal_type_group_id, $appraisal_type_group_id);
		$this->db->or_where($c_payroll_period_group_id, $payroll_period_group_id);
		$this->db->or_where('appraisal_company_id', $appraisal_company);
		$this->db->where('company_id', $company_id);

		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	public function custom_exist_criteria_form ($area_name,$company_,$f){
		$this->db->select('*'); 
		$this->db->from('pms_criteria_form ');

		$this->db->where('area',$area_name);

		$this->db->where('company_id',$company_);
		$this->db->where('fid',$f);

		$query = $this->db->get();
		$result = $query->result_array();
		return $result;


	}
	public function manage_general_objectives($company_id){
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('pms_general_objectives');
		return $query->result();
		
	}

	public function manage_employee_objectives($company_id){
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('pms_employee_objectives');
		return $query->result();
		
	}
	public function radio1($id){
		$id = $this->input->post('text1');
		$data = array(
			'inactive' =>  $this->input->post('text2'),

		);
		$this->db->where('cid',$id);
		$this->db->update('pms_creators_approvers_setup',$data);
	}
	public function qwee($id){
		$this->db->select('*');
		$this->db->from('company_info');
		$this->db->where('company_id',$id);
		$query = $this->db->get();
		return $query->row();
	}


}