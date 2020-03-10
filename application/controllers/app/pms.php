
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class pms extends General{

	public function __construct(){
		parent::__construct();
	
		$this->load->model("app/pms_model");
		$this->load->model("general_model");
		$this->load->library('form_validation');
		if(General::is_logged_in() == FALSE){
			redirect(base_url().'login');    
		}
		General::variable();


	}
	


	public function index(){

		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');

		$this->load->view('app/pms/index',$this->data);
		
	}

public function lock_un($id){
		$lock = $this->pms_model->lock($id);
		echo $lock->lock;
	}
	public function settings($id){
		$data['settings'] = $this->pms_model->eval_appro_score($id);
		$data['computations'] = $this->pms_model->computations($id);
		$data['self_eval'] = $this->pms_model->self_eval($id);

		
		$this->load->view('app/pms/eval_appro_score.php',$data);
	}

	public function manage_form_evaluators($id){
		$this->data['get_selected_evaluators'] =  $this->pms_model->get_selected_form_good($id);
		$this->data['get_form_def'] = $this->pms_model->get_form_def($id);
		$this->data['row'] = $this->pms_model->get_evaluators($id);	
		$this->load->view('app/pms/manage_form_evaluators',$this->data);
	}
	public function manage_form_approver($id){
			$this->data['get_selected_approv'] =  $this->pms_model->get_selected_form_approv($id);
			$this->data['row'] = $this->pms_model->get_approvers($id);
		$this->data['get_form_def'] = $this->pms_model->get_apprauisal_appro_def($id);		
		$this->load->view('app/pms/manage_form_approver',$this->data);
	}


	public function update_weight(){
		

		for ($i=0; $i < count($this->input->post('joblevel')) ; $i++) { 
		$data['weight']= $this->input->post('weight')[$i];	
		$this->db->where('cid',$this->input->post('ca'));
		$this->db->where('job_level',$this->input->post('joblevel')[$i]);
		$this->db->where('area_weight_id',$this->input->post('areaid'));
		$this->db->update('pms_criteria_job',$data);
		}


	}


	public function manage_scorecard_creators($id){
		$this->data['get_selected_scoree'] =  $this->pms_model->get_selected_form_default($id);
		$this->data['row'] = $this->pms_model->get_score($id);	
		$this->data['sdefault'] = $this->pms_model->get_scorecard_creator_default();	 
		$this->load->view('app/pms/manage_scorecard_creators',$this->data);
	}
		public function map($id){

			
		$data['list'] = $this->pms_model->get_scorecard_evaluator_option2($id);
		$data['get_scorecard_approver_option2'] = $this->pms_model->get_scorecard_approver_option2($id);
		$data['get_scorecard_creator_option3'] = $this->pms_model->get_scorecard_creator_option2($id);
		$this->load->view('app/pms/map',$data);
	}
	public function manage_grading_table($id){
		$this->data['grading_table'] = $this->pms_model->get_grading_table($id);	
		$this->load->view('app/pms/grading_table',$this->data);
	}



	public function save_pms_general(){
		$s = $this->input->post('position');
		$o = $this->input->post('topics');
		$tails = $this->input->post('details');
		$company = $this->input->post('company_');
		$q = $this->pms_model->general_exists('position','objective_topics','objective_details','pms_general_objectives',trim($s),trim($o),trim($tails));
		$data = array(
			'position' =>  $this->input->post('position'),
			'objective_topics' =>  $this->input->post('topics'),
			'objective_details' =>  $thisS->input->post('details'),
			'company_id' => $this->input->post('company_')
		);

		if(empty($q)){
				$data['appraisal_form'] = $this->pms_model->add_pms_general($data);
				echo json_encode('true');
			}else{
				echo json_encode($s . 'already exis');
			}
		}

	public function save_pms_employee(){
		$s = $this->input->post('name');
		$o = $this->input->post('objectives');
		$tails =$this->input->post('odetails');
		$company = $this->input->post('company_');
		$q = $this->pms_model->employee_exists('name','pms_employee_objectives','objectives','objective_details',trim($s),trim($o),trim($tails));
		$data = array(
			'name' =>  $this->input->post('name'),
			'objectives' =>  $this->input->post('objectives'),
			'company_id' => $this->input->post('company_'),
			'objective_details' => $this->input->post('odetails')
		);
		if(empty($q)){
			$data['appraisal_form'] = $this->pms_model->add_pms_empoyee($data);
				echo json_encode('true');
			}else{
				echo json_encode($s . 'already exis');
			}
	
		}


	public function save_pms_appraisal_schedule(){

 		
		$this->form_validation->set_rules('cover_year','cover year','required');
		$this->form_validation->set_rules("appraisal_period_type","appraisal period type","required");	

				$cover_year =  $this->input->post('cover_year');
				$appraisal_period_type = $this->input->post('appraisal_period_type');
				$appraisal_type_group_id = $this->input->post('appraisal_type_group_id');
				$payroll_period_group_id = $this->input->post('payroll_period_group_id');
				$appraisal_company = $this->input->post('appraisal_company');
				$company_ = $this->input->post('company_');
				$res = $this->pms_model->custom_exist_appraisal_schedule('pms_manage_appraisal_schedule','cover_year',trim($cover_year) , 'appraisal_period_type_id',trim($appraisal_period_type),'appraisal_group_id',trim($appraisal_type_group_id) ,'payroll_period_group_id',trim($payroll_period_group_id),'appraisal_company_id',trim($appraisal_company));
					 $count = count($res);


		//if(empty($count)){
		if(!empty(array_filter($this->input->post('dp1')))){
			$to = [''];
			$from =[''];
			$val = $this->input->post('dp1');
 
		}elseif(!empty(array_filter($this->input->post('dp2')))){
			$from = $this->input->post('from_dp2');
			$to = $this->input->post('to_dp2');
			$val = $this->input->post('dp2');
		}
		elseif(!empty(array_filter($this->input->post('dp3')))){
			$from = $this->input->post('from_dp3');
			$to = $this->input->post('to_dp3');
			$val = $this->input->post('dp3');
		}
		elseif(!empty(array_filter($this->input->post('dp4')))){

			$to = [date('Y')];
			$from =[date('Y')];
			$val = $this->input->post('dp4');
			
			// $jan = 'january '.$this->input->post('dp4').' '.$this->input->post('cover_year');
			// $feb = 'february '.$this->input->post('dp4').' '.$this->input->post('cover_year');
			// $march = 'march '.$this->input->post('dp4').' '.$this->input->post('cover_year');
			// $april = 'april '.$this->input->post('dp4').' '.$this->input->post('cover_year');
			// $may = 'may '.$this->input->post('dp4').' '.$this->input->post('cover_year');
			// $june = 'june '.$this->input->post('dp4').' '.$this->input->post('cover_year');
			// $dec = 'december '.$this->input->post('dp4').' '.$this->input->post('cover_year');
			// $sep = 'september '.$this->input->post('dp4').' '.$this->input->post('cover_year');
			// $oct = 'october '.$this->input->post('dp4').' '.$this->input->post('cover_year');
			// $nov=	'november '.$this->input->post('dp4').' '.$this->input->post('cover_year');
			// $aug = 'august '.$this->input->post('dp4').' '.$this->input->post('cover_year');
			// $july = 'july '.$this->input->post('dp4').' '.$this->input->post('cover_year');

			// $val = array();
			// $val[] = date("y-m-d", strtotime($jan));
			// $val[] = date("y-m-d", strtotime($feb));
			// $val[] =date("y-m-d", strtotime($march));
			// $val[] = date("y-m-d", strtotime($april));
			// $val[] = date("y-m-d", strtotime($may));
			// $val[] = date("y-m-d", strtotime($june));
			// $val[] =  date("y-m-d", strtotime($july));
			// $val[] = date("y-m-d", strtotime($aug));
			// $val[] =  date("y-m-d", strtotime($sep));
			// $val[] =  date("y-m-d", strtotime($oct));
			// $val[] =  date("y-m-d", strtotime($nov));
			// $val[] =  date("y-m-d", strtotime($dec));
		

		
		}
		elseif($this->input->post('dp5')){
				$from = $this->input->post('from_dp5');
				$to = $this->input->post('to_dp5');
				$val = $this->input->post('dp5');
		}
		
		
		
		if($this->input->post('payroll_period_group_id'))
		{
			$value = $this->input->post('payroll_period_group_id');
			$column_field = 'payroll_period_group_id';
		}
		elseif($this->input->post('appraisal_type_group_id'))
		{
			$value = $this->input->post('appraisal_type_group_id');
			$column_field = 'appraisal_group_id';
		}
		elseif($this->input->post('appraisal_company'))
		{
			$value = $this->input->post('appraisal_company');
			$column_field = 'appraisal_company_id';
		}
		$insertArray = array();
		if($appraisal_company){
		$ref = $appraisal_company;
		$this->db->select('*');
		$this->db->from('employee_info');

		
		
	
		}elseif($appraisal_type_group_id){
		$ref = $appraisal_type_group_id;
		$this->db->select('*');
		$this->db->from('pms_appraisal_members a');
		$this->db->where('group_id',$appraisal_type_group_id);
		$this->db->join('employee_info b', 'a.name = b.fullname');
		}
				$qe = $this->db->get();
		$q =  $qe->result();
		foreach($q as $q){
				$new_add =  array(
			
			'employee_id' =>  $q->employee_id,
			'ref'=>$cover_year.$ref


					);
				array_push($insertArray,$new_add);

		}
	$this->db->insert_batch('pms_appraisal_schedule_member', $insertArray);
	
			$q = 1;

for($i = 0; $i < count($val); $i++)
{
		$date=date_create($val[$i]);
 		$va = date_format($date,"m-d");
		
		$data = array(
				        // 'appraisal_type' =>  $this->input->post('appraisal_type'),
			'cover_year' =>  $this->input->post('cover_year'),
			'number_days' =>  $this->input->post('w'),
			$column_field =>  $value,
			'appraisal_period_type_id'=> $this->input->post('appraisal_period_type'),
			'company_id'=> $this->input->post('company_'),
			'appraisal_period_type_dates'=> $va,
			'ref'=>$this->input->post('cover_year').$value,
			'from' => $from[$i],
			'to' =>  $to[$i],
			'appraisal_order'=>$q


		);	
		$q++;
			$data['appraisal_form'] = $this->pms_model->add_manage_appraisal_schedule($data);

}

		
			echo json_encode('true');
			
		//}else{
			//echo json_encode('Data is already exist');
		//}
		}

	public function save_pms_appraisal_group(){
			$f = $this->input->post('group_name');
			$res = $this->pms_model->groupname_exists('appraisal_group_name','pms_appraisal_group',trim($f));
			$count = count($res);
			if(empty($count)){


				$this->pms_model->save_g();
				echo json_encode('true');
			}else{
				echo json_encode($f.' is already exist');
			}
			
		}
	

	public function save_score_option3(){

				
			
				$this->pms_model->save_score_option3();
				
			
		}

	public function save_score_option2($id,$co){

				
			
				$this->pms_model->save_score_option2($id,$co);
				
			
		}


	public function save_appraisal_member(){

				
			
				$this->pms_model->save_appraisal_member();
				
			
		}
			public function save_approvers($q){

				
			
				$this->pms_model->save_approvers($q);
				
			
		}

	public function save_evaluator_option2($id){

		
		$de = $this->input->post('department1',true);
		$ca = $this->input->post('classification1',true);
		$l = $this->input->post('location1',true);
		$s= $this->input->post('section1',true);

		$insertArray = array();
		
					$mem = $this->input->post('mem');
					$lvl = $this->input->post('elevel');
			foreach($mem as $mem){
					$ref = 	$de.$ca.$s.$l.$this->input->post('company_');
					$res = $this->pms_model->pms_evaluators_exists($ref,$mem);
					$count = count($res);	
					if(empty($count)){	
					$new_add = array(
						'evaluator_id' =>  $mem,
			
						'location_id' =>   $l,
						'company_id' => $this->input->post('company_'),
						'classification_id' =>   $ca,
						'department_id' => $de,
						'section_id' => $s,
						'evaluator' => $this->input->post('elevel'.$mem),
						'ref'=>$de.$ca.$s.$l.$this->input->post('company_').$mem
					

					);
							array_push($insertArray,$new_add);
					
				
			

		}

			}
			$this->pms_model->save_evaluator_option2($insertArray);
		
				
			
		}
	
	public function get_grading_table_vie_ajax(){
			$fid = $this->input->post('id');
					$this->db->select('*');
					$this->db->from('pms_grading_table');
					$this->db->where('fid',$fid);
					
					
					$query = $this->db->get();
					$qwe = $query->result();	
						foreach($qwe as $query){
						

							  $res[]=array(
						        'ranking' => $query->ranking,
						        'score' => $query->score,
						        'score_equivalent' => $query->score_equivalent,
						        'scoring_guide' => $query->scoring_guide,
						        'company_' => $query->company_id
						    );

						}
						echo json_encode($res);	
	}
	


	public function save_grading_table_via_ajax(){
	
			  	$fid= $this->input->post('fid');
				$this->db->where('fid',$fid);
				$this->db->delete('pms_grading_table');

		$scoring_guide= $this->input->post('scoring_guide[]');
		$score_equivalent= $this->input->post('score_equivalent[]');
		$ranking= $this->input->post('ranking[]');
		$score= $this->input->post('score[]');
		$company_= $this->input->post('company_[]');
		$fid= $this->input->post('fid');
		
 		for($x = 0; $x < sizeof($scoring_guide); $x++){

				$data = array(
							'scoring_guide' => $scoring_guide[$x],
							// 'grading_type' => $this->input->post('grading_type',true),
							'score_equivalent' =>  $score_equivalent[$x],
							'score' => $score[$x],
							'ranking' =>$ranking[$x],
							 'company_id' => $company_[$x],
							 'fid' =>$fid
					);
				


	$this->pms_model->add_grading_table($data);
}


	echo json_encode($e);


		
	}
			public function get_approvers(){  	
		
					$this->db->select('*');
					$this->db->from('employee_info a');
							$this->db->join('classification b', 'a.classification = b.classification_id');
					$this->db->join('location c', 'a.location = c.location_id');
					$this->db->join('department d', 'a.department = d.department_id');
					if($this->input->post('department1') !='all'){
						$this->db->where('a.department',$this->input->post('department1'));
					}
					if($this->input->post('classification1') != 'all'){
						$this->db->where('a.classification',$this->input->post('classification1'));
					}if($this->input->post('location1') != 'all'){
						$this->db->where('a.location',$this->input->post('location1'));
					}
					if($this->input->post('section1') != 'all'){
						$this->db->where('a.section',$this->input->post('section1'));
					}
					
					$query = $this->db->get();
					$qwe = $query->result();

					if($query->num_rows()){
						foreach($qwe as $query){
					

							

							$res = $this->pms_model->pms_evaluators_exist('employee_id','pms_form_approvers',$query->employee_id);


							$count = count($res);	
							if(empty($count)){
									echo '<tr><td><input type="checkbox" name="mem[]" class="checkall" value="'.$query->employee_id.'"></td><td>'.$query->employee_id.'</td><input type="hidden" name="departments[]" value="'.$query->dept_name.'"><input type="hidden" name="classification_all[]" value="'.$query->classification.'"><input type="hidden" name="location_all[]" value="'.$query->location_name.'"><td>'.$query->fullname.'</td></tr>';


						}else{
							echo '<tr><td><input disabled type="checkbox" name="mem[]"  value="'.$query->fullname.'"></td><td>'.$query->employee_id.'</td><td>'.$query->fullname.' <span style="color:red">(already in the list)</span></td></tr>';
						}
	}
}							else{
														echo 'no data foumd';
}


		}
	public function save_eval_appro_score($id){
				$qs = $this->pms_model->save_eval_appro_score($id);

				    
	}

	public function save_grading_table(){  	


				$score_equivalent = $this->input->post('equivalent');
				$company = $this->input->post('company_');	
				$res = $this->pms_model->filename_exists_grading('score_equivalent','pms_grading_table',trim($score_equivalent),trim($company),$this->input->post('fid'));
				 $count = count($res);
				if(empty($count)){

					$data = array(
			'scoring_guide' => $this->input->post('scoring_guide'),
			// 'grading_type' => $this->input->post('grading_type',true),
			'score_equivalent' => $this->input->post('equivalent',true),
			'score' => $this->input->post('score_name',true),
			'ranking' => $this->input->post('ranking',true),
			'company_id' => $this->input->post('company_'),
			'fid' => $this->input->post('fid'),
			'color'=>$this->input->post('_color')



		);
					echo json_encode('true');
			$this->pms_model->add_grading_table($data);
				}else{
					echo json_encode('data is already exist');
				}

		
	}
	public function save_lock_un($id){
				$this->pms_model->save_lock_un($id);
	}
	
		public function get_evaluator(){  	
		

		
					$this->db->select('*');
					$this->db->from('employee_info a');
							$this->db->join('classification b', 'a.classification = b.classification_id');
					$this->db->join('location c', 'a.location = c.location_id');
					$this->db->join('department d', 'a.department = d.department_id');
					if($this->input->post('department1') !='all'){
						$this->db->where('a.department',$this->input->post('department1'));
					}
					if($this->input->post('classification1') != 'all'){
						$this->db->where('a.classification',$this->input->post('classification1'));
					}if($this->input->post('location1') != 'all'){
						$this->db->where('a.location',$this->input->post('location1'));
					}
					if($this->input->post('section1') != 'all'){
						$this->db->where('a.section',$this->input->post('section1'));
					}
					
					$query = $this->db->get();
					$qwe = $query->result();

					if($query->num_rows()){
						foreach($qwe as $query){
					

							

							$res = $this->pms_model->pms_evaluators_exist('employee_id','pms_form_evaluators',$query->employee_id);


							$count = count($res);	
							if(empty($count)){
									echo '<tr><td><input type="checkbox" name="mem[]" class="checkall" value="'.$query->employee_id.'"></td><td>'.$query->employee_id.'</td><input type="hidden" name="departments[]" value="'.$query->dept_name.'"><input type="hidden" name="classification_all[]" value="'.$query->classification.'"><input type="hidden" name="location_all[]" value="'.$query->location_name.'"><td>'.$query->fullname.'</td></tr>';


						}else{
							echo '<tr><td><input disabled type="checkbox" name="mem[]"  value="'.$query->fullname.'"></td><td>'.$query->employee.'</td><td>'.$query->fullname.' <span style="color:red">(already in the list)</span></td></tr>';
						}
	}
}							else{
														echo 'no data foumd';
}



		}


	public function save_general_form(){  	
		

		 $f = $this->input->post('form_title');
		 $company = $this->input->post('company_');	
		 $res = $this->pms_model->filename_exists('form_title','pms_appraisal_form',trim($f) ,trim($company));
		 $count = count($res);
				if(empty($count)){
			
			$data['appraisal_form'] = $this->pms_model->add_general_form();
			echo json_encode('true');
		}else{
			echo json_encode($f.' is already exist');
			}


		}
public function show_period_type($val,$company_id){
			$this->data['company_id']=$company_id;

			



		

				$this->data['val'] = $val;
				$this->data['res']=$this->pms_model->yearly($company_id,$val);
				$this->load->view('app/pms/appraisal_period_type/yearly',$this->data);
		

		}

	public function show($val,$company_id){
			$this->data['company_id']=$company_id;

			



			if($val=="group"){

				
				$this->data['res']=$this->pms_model->group($company_id);
				$this->load->view('app/pms/group',$this->data);
			}elseif($val=="company"){
				$this->data['res']=$this->pms_model->company_($company_id);
				$this->load->view('app/pms/company',$this->data);

			}elseif($val=="period"){
				$this->data['payroll_period_group'] = $this->pms_model->get_payroll_period_group();
				$this->load->view('app/pms/period',$this->data);

			}else{
				
			}

		}


	public function save_criteria_form(){  	
			
	 			$area_name = $this->input->post('area_name');
	 			$f =$this->input->post('f');
				$s = $this->input->post('company_');
				 $res = $this->pms_model->custom_exist_criteria_form(trim($area_name),trim($s),trim($f));
				 $count = count($res);
				// if(empty($count)){
					
				$this->session->set_flashdata('qwe',$s);
				$data['appraisal_form'] = $this->pms_model->add_criteria_form();
				
				
			// }else{
			// 	echo json_encode('is already exist');
			// }


		}


	
		public function delete_member(){
			$id = $this->input->post('text1');
			$this->pms_model->delete_member($id);
		}
		
		public function delete_group(){
			$id = $this->input->post('text1');
			$this->pms_model->delete_group($id);
		}
		public function delete_type_schedule(){
			$id = $this->input->post('text1');
				$id4 = $this->input->post('text4');
			$this->pms_model->delete_type_schedule($id,$id4);
		}
		
		public function delete_grade(){
			$id = $this->input->post('text1');
			$company_id = $this->input->post('text');
			$this->pms_model->deleting_grade($id,$company_id);
		}
		 function delete_all_from_approvers()
		 {
		  if($this->input->post('checkbox_value'))
		  {
		   $id = $this->input->post('checkbox_value');
		   for($count = 0; $count < count($id); $count++)
		   {
		    $this->pms_model->delete_all_from_approvers($id[$count]);
		   }
		  }
		 }
		 function delete_all_form_evaluators()
		 {
		  if($this->input->post('checkbox_value'))
		  {
		   $id = $this->input->post('checkbox_value');
		   	$c= $this->input->post('co');
		   for($count = 0; $count < count($id); $count++)
		   {
		    $this->pms_model->delete_form_evaluators($id[$count]);
		   }
		  }
		 }
		 function delete_all_option3()
		 {
		  if($this->input->post('checkbox_value'))
		  {
		   $id = $this->input->post('checkbox_value');
		   for($count = 0; $count < count($id); $count++)
		   {
		    $this->pms_model->delete_scorecard_option3($id[$count]);
		   }
		  }
		 }

		  function delete_all_option2()
		 {
		  if($this->input->post('checkbox_value'))
		  {
		   $id = $this->input->post('checkbox_value');
		   for($count = 0; $count < count($id); $count++)
		   {
		    $this->pms_model->delete_scorecard_option2($id[$count]);
		   }
		  }
		 }

		 public function delete_scorecard_option2(){
			$id = $this->input->post('text1');
			$this->pms_model->delete_scorecard_option2($id);
		
		}
		 public function delete_form_evaluators(){
			$id = $this->input->post('text1');
			$c= $this->input->post('co');
			$this->pms_model->delete_form_evaluators($id);
		
		}
		public function delete_scorecard_option3(){
			$id = $this->input->post('text1');
			$this->pms_model->delete_scorecard_option3($id);
		}
		public function delete_employee_objectives(){
			$id = $this->input->post('text1');
			$company_id = $this->input->post('text');
			$this->pms_model->delete_employee_objectives($id,$company_id);
			
		}
		 public function delete_form_approvers(){
			$id = $this->input->post('text1');
			$c= $this->input->post('co');
			$this->pms_model->delete_all_from_approvers($id);
		
		}
		public function delete_criteria(){
			$id = $_POST['text1'];
			$company_id = $this->input->post('text');
			$this->pms_model->delete_criteria($id,$company_id);
		}
		public function delete_form(){
			$id = $this->input->post('text1');
			$company_id = $this->input->post('text');
			$this->pms_model->delete_form($id,$company_id);
			
		}
public function delete_general_objectives(){
			$id = $this->input->post('text1');
			$this->pms_model->delete_general_objectives($id);
		}

		public function update_criteria_form() {
			
			
			// $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  <strong>".$this->input->post('form_title')."</strong>, is Successfully Added!</div>");
			// $this->session->set_flashdata('onload',"manage_general_form()");

			$data['res'] = $this->pms_model->update_criteria_form();
			// redirect(base_url().'app/pms/index',$this->data);
			

		}
			public function save_update_general_objectives() {
			
			
	
			$data['res'] = $this->pms_model->update_general_objectives();
		
			

		}
		
		

		public function update_appraisal_schedule() {
			
			$cover_year =  $this->input->post('cover_year');
				$appraisal_period_type = $this->input->post('appraisal_period_type');
				$appraisal_type_group_id = $this->input->post('appraisal_type_group_id');
				$payroll_period_group_id = $this->input->post('payroll_period_group_id');
					$appraisal_company = $this->input->post('appraisal_company');
				$company_ = $this->input->post('company_');
				$res = $this->pms_model->custom_exist_appraisal_schedule('pms_manage_appraisal_schedule','cover_year',trim($cover_year) , 'appraisal_period_type_id',trim($appraisal_period_type),'appraisal_group_id',trim($appraisal_type_group_id) ,'payroll_period_group_id',trim($payroll_period_group_id),'appraisal_company_id',trim($appraisal_company));
					 $count = count($res);


		if(empty($count)){

			$data['res'] = $this->pms_model->update_appraisal_schedule();
		} 
	
			

		}	

			public function save_update_employee_objectives() {
			
			
	
			$data['res'] = $this->pms_model->update_employee_objectives();
		
			

		}

		public function view_update_appraisal_schedule($id,$comp){
			$data['grading_row_id'] = $id; 
			$data['onload'] = $this->session->flashdata('onload');
			$data['message'] = $this->session->flashdata('message');
			$data['res'] = $this->pms_model->get_update_appraisal_schedule($id);
			$data['appraisal_period_type'] = $this->pms_model->appraisal_period_type();
			$data['payroll_period_group'] = $this->pms_model->get_payroll_period_group();
			$data['appraisal_group'] = $this->pms_model->group($comp);
			$data['company_'] = $this->pms_model->company_($comp);

			$this->load->view('app/pms/view_update_appraisal_schedule',$data);


		}
			public function view_update_general_objectives($id){
			$data['update_data'] = $this->pms_model->get_update_general_objectives($id);
			$this->load->view('app/pms/view_update_general_objectives',$data);


		}
		public function view_update_criteria_form($fid) {
			
			
			
			
			$data['onload'] = $this->session->flashdata('onload');
			$data['message'] = $this->session->flashdata('message');
			$data['res'] = $this->pms_model->get_update_criteria_form($fid);
			$data['get_grading_scale'] = $this->pms_model->get_grading_scale($fid);

			// $data['grading_table'] = $this->pms_model->get_grading_table($id);	
			$this->load->view('app/pms/view_update_criteria_form',$data);
			
			
			

		}
		public function view_update_employee_objectives($id){
			$data['update_data'] = $this->pms_model->get_update_employee_objectives($id);
			$this->load->view('app/pms/view_update_employee_objectives',$data);


		}
		public function updates_criteria_form($fid,$c) {
			
			
			$data['onload'] = $this->session->flashdata('onload');
			$data['message'] = $this->session->flashdata('message');
			$data['res'] = $this->pms_model->get_update_criteria_form($fid,$c);

		
			$this->load->view('app/pms/update_criteria_form',$data);
			
			
			

		}
		public function view_update_group_member($id) {
			
			
			
			
			$data['onload'] = $this->session->flashdata('onload');
			$data['message'] = $this->session->flashdata('message');
			// $data['res'] = $this->pms_model->get_update_criteria_form($id);
			$this->load->view('app/pms/view_update_group_member',$data);
			
			
			

		}

		public function update_pms_group_appraisal(){

				$f = $this->input->post('group_name');
			$res = $this->pms_model->groupname_exists('appraisal_group_name','pms_appraisal_group',trim($f));
			$count = count($res);

			if(empty($count)){

					$data['res'] = $this->pms_model->update_pms_appraisal_group();
				echo json_encode('good');
			}else{
				echo json_encode($f);
			}
			
		}
		



		public function view_update_general_form($id){
			$data['grading_row_id'] = $id; 
			$data['onload'] = $this->session->flashdata('onload');
			$data['message'] = $this->session->flashdata('message');
			$data['res'] = $this->pms_model->get_update_general_form($id);
			$this->load->view('app/pms/view_update_general_form',$data);


		}


		public function view_update_appraisal_group($id){

			$data['onload'] = $this->session->flashdata('onload');
			$data['message'] = $this->session->flashdata('message');
			$data['pms_appraisal'] = $this->pms_model->get_update_appraisal_group($id);
			$this->load->view('app/pms/view_update_appraisal_group',$data);
		}


		
		public function employee_development_plan($id){
			$data['onload'] = $this->session->flashdata('onload');
			$data['message'] = $this->session->flashdata('message');

			$data['get_selected_plan'] =  $this->pms_model->get_selected_plan_type($id);
			$this->load->view('app/pms/manage_employee_development_plan',$data);



		}


		public function manage_general_form($id){
			$data['onload'] = $this->session->flashdata('onload');
			$data['message'] = $this->session->flashdata('message');
			
			$data['tweight'] = $this->pms_model->get_total_weight($id);
			$data['get_max'] = $this->pms_model->get_max_form($id);
			$data['appraisal_form'] = $this->pms_model->get_appraisal_form($id);
			$this->load->view('app/pms/form_settings',$data);



		}


		public function update_general_form() {
			
			
			// $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  <strong>".$this->input->post('form_title')."</strong>, is Successfully Added!</div>");
	


			$data['res'] = $this->pms_model->update_general_form();
		
			

		}

		public function general_instruction($id){
			$data['onload'] = $this->session->flashdata('onload');
			$data['message'] = $this->session->flashdata('message');
			
			$data['w'] = $id;
			$data['general_instruction'] = $this->pms_model->get_general_instruction($id);
			$this->load->view('app/pms/general_instruction',$data);
		}

		public function save_general_instruction(){
					$this->pms_model->save_general_instruction();
			
		}



		public function general_instruction_update() {

			if(isset($_POST['name'])){


				/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------


			*/	
			$column=$_POST['name'];
			$new_value=$_POST['value'];
			$id=$_POST['pk'];
			$company_id= 	$_GET['c'];
			// $res = $this->pms_model->filename_exists('company_id','pms_general_instruction' ,trim($company_id));
			// 	 $count = count($res);
			// 	if(!empty($count)){
		
				// General::system_audit_trail('PMS','Settings','logfile_pms','update: '.$new_value.'','UPDATE',$new_value);
			
			
			
			$data['general_instruction'] = $this->pms_model->general_instruction_update($new_value, $id ,$company_id);
			// }
		}

	}

	public function update_grading_table() {
		
		
		// $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  <strong>".$this->input->post('form_title')."</strong>, is Successfully Added!</div>");
		// $this->session->set_flashdata('onload',"manage_grading_table()");
	
		$data['res'] = $this->pms_model->update_grading_table();
		// redirect(base_url().'app/pms/index',$this->data);
		

	}

	public function view_update_grading_table($id){
		$data['grading_row_id'] = $id; 
		$data['onload'] = $this->session->flashdata('onload');
		$data['message'] = $this->session->flashdata('message');
		$data['res'] = $this->pms_model->get_update_grading_table($id);
		$this->load->view('app/pms/view_update_grading_table',$data);



	}
		public function save_position_department(){
		$this->db->where('company_id',$this->input->post('company_'));
		$this->db->where('criteria',$this->input->post('val'));
		$query = $this->db->get('pms_manage_employees_development_plan');
			$return =  $query->num_rows();
	if($return <= 0){
		$data = array(
			'position' =>  $this->input->post('position'),
		

		'department' =>  $this->input->post('department'),
			'criteria' =>  $this->input->post('val'),
			'compentency_requirement' =>  $this->input->post('criteria'),
			'company_id' =>$this->input->post('company_'),


	
		);


				$data['appraisal_form'] = $this->pms_model->save_position_department($data);
		}else{

			$data1 = array(
			'position' =>  $this->input->post('position'),
	
		'department' =>  $this->input->post('department'),
			'criteria' =>  $this->input->post('val'),
			'compentency_requirement' =>  $this->input->post('criteria')
		);
		$data['appraisal_form'] = $this->pms_model->update_position_department($data1);

		}


		
		
	}
	public function manage_appraisal_group($company_id){
		
		$data['onload'] = $this->session->flashdata('onload');
		$data['message'] = $this->session->flashdata('message');
		$data['appraisal_group'] = $this->pms_model->manage_appraisal_group($company_id);
		$this->load->view('app/pms/manage_appraisal_group',$data);



	}
	public function manage_appraisal_schedule($company_id){
		
		$data['onload'] = $this->session->flashdata('onload');
		$data['message'] = $this->session->flashdata('message');
		$data['appraisal_period_type'] = $this->pms_model->appraisal_period_type();
		$data['res'] = $this->pms_model->manage_appraisal_schedule($company_id);
		$data['result'] = $this->pms_model->manage_appraisal_appraisa_data($company_id);
		$data['manage_general_objectives'] = $this->pms_model->manage_general_objectives($company_id);
		$data['manage_employee_objectives'] = $this->pms_model->manage_employee_objectives($company_id);
		$this->load->view('app/pms/manage_appraisal_schedule',$data);



	}
	public function manage_appraisal_group_members($company_id){
		
		$data['onload'] = $this->session->flashdata('onload');
		$data['message'] = $this->session->flashdata('message');
		$data['res'] = $this->pms_model->get_update_grading_table($id);
		$this->load->view('app/pms/manage_appraisal_group_members',$data);



	}
	public function manage_member($id ,$company){
		
		$data['onload'] = $this->session->flashdata('onload');
		$data['message'] = $this->session->flashdata('message');
		// $data['res'] = $this->pms_model->get_update_grading_table($id);
		$this->load->view('app/pms/view_update_group_member',$data);



	}
public function manage_criteria($fid,$company){
		

		$data['get_grading_scale'] = $this->pms_model->get_grading_scale($fid , $company);
		$this->load->view('app/pms/view_update_criteria_form',$data);



	}
		public function save_position(){
		$this->db->where('company_id',$this->input->post('company_'));
		$this->db->where('criteria',$this->input->post('val'));
		$query = $this->db->get('pms_manage_employees_development_plan');
			$return =  $query->num_rows();
	if($return <= 0){
		$data = array(
			'position' =>  $this->input->post('position'),
		


			'criteria' =>  $this->input->post('val'),
			'compentency_requirement' =>  $this->input->post('criteria'),
			'company_id' =>$this->input->post('company_'),


	
		);


				$data['appraisal_form'] = $this->pms_model->save_position($data);
		}else{

			$data1 = array(
			'position' =>  $this->input->post('position'),
	
	
			'criteria' =>  $this->input->post('val'),
			'compentency_requirement' =>  $this->input->post('criteria')
		);
		$data['appraisal_form'] = $this->pms_model->update_position($data1);

		}


		
		
	}

	function load_me($company_id){

		$this->data['res'] = $this->pms_model->get_general_instruction($company_id);
		$this->data['company_id'] = $company_id;
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('app/pms/load_me',$this->data);
	}


	function get_employee(){
		$department = $this->input->post('text1');
		$data['res'] = $this->pms_model->filter_get_employee($department);
		$this->load->view('app/pms/view_update_group_member',$this->data);
	}

	public function e(){

		

					$this->db->select('*');
					$this->db->from('employee_info a');
					$this->db->join('classification b', 'a.classification = b.classification_id');
					$this->db->join('location c', 'a.location = c.location_id');
					$this->db->join('department d', 'a.department = d.department_id');
					if($this->input->post('department') != 'all'){
						$this->db->where('a.department',$this->input->post('department'));
					}
					if($this->input->post('classification') != 'all'){
						$this->db->where('a.classification',$this->input->post('classification'));
					}if($this->input->post('location') != 'all'){
						$this->db->where('a.location',$this->input->post('location'));
					}
					if($this->input->post('section') != 'all'){
						$this->db->where('a.section',$this->input->post('section'));
					}
					
					$query = $this->db->get();
					$qwe = $query->result();

					if($query->num_rows()){
						foreach($qwe as $query){
					
// 		filename_exists($cname,$table , $field)
// {
//     $this->db->select('*'); 
//     $this->db->from('pms_appraisal_members');
//     $this->db->where('name', $field);
//     $query = $this->db->get();
//     $result = $query->result_array();
//     return $result;			
// }		


									$group_id = $this->input->post('id');
									$company = 	 $this->input->post('id');

							$res = $this->pms_model->g('name','pms_appraisal_members',$query->fullname ,'group_id',$group_id,$company,'company');

							$count = count($res);	
							if(empty($count)){
							echo '<tr><td><input type="checkbox" name="mem[]" class="checkall" value="'.$query->fullname.'"></td><td>'.$query->employee_id.'</td><input type="hidden" name="departments[]" value="'.$query->dept_name.'"><input type="hidden" name="classification_all[]" value="'.$query->classification.'"><input type="hidden" name="location_all[]" value="'.$query->location_name.'"><td>'.$query->fullname.'</td></tr>';

						}else{
						
								echo '<tr><td><input disabled type="checkbox" name="mem[]"  value="'.$query->fullname.'"></td><td>'.$query->employee_id.'</td><td>'.$query->fullname.' <span style="color:red">(already in the list)</span></td></tr>';



						}


	}}else{
		echo 'no data found';
	}

	}
	public function save_position_department_section(){
		$this->db->where('company_id',$this->input->post('company_'));
		$query = $this->db->get('pms_manage_employees_development_plan');
			$return =  $query->num_rows();
	if($return <= 0){
		$data = array(
			'position' =>  $this->input->post('position'),
			'department' =>  $this->input->post('department'),
			'section' =>  $this->input->post('section'),

			'criteria' =>  $this->input->post('val'),
			'compentency_requirement' =>  $this->input->post('criteria'),
			'company_id' =>$this->input->post('company_'),


	
		);


				$data['appraisal_form'] = $this->pms_model->save_position_department_section_development($data);
		}else{

			$data1 = array(
			'position' =>  $this->input->post('position'),
			'department' =>  $this->input->post('department'),
			'section' =>  $this->input->post('section'),
			'criteria' =>  $this->input->post('val'),
			'compentency_requirement' =>  $this->input->post('criteria')
		);
		$data['appraisal_form'] = $this->pms_model->update_position_department_section_development($data1);

		}


		
		
	}


	
	public function get_opt3(){

		
					$id = $this->input->post('position_name');
					$this->db->select('*');
					$this->db->from('employee_info');
					$this->db->where('position',$id);
					$query = $this->db->get();
					$qwe = $query->result();


						foreach($qwe as $query){




							echo '<tr><td><input type="checkbox" name="mem[]" class="checkall" value="'.$query->employee_id.'"></td><td>'.$query->employee_id.'</td><td>'.$query->fullname.'</td></tr>';

					
	}

	}

		public function copy(){

					
			  $fid = $this->input->post('getfid');
			  	  $c = $this->input->post('company');
				$this->db->where('fid !=',$fid);
				$this->db->delete('pms_grading_table');
					$fid = $this->input->post('getfid');
					$this->db->select('*');
					$this->db->from('pms_grading_table');
					$this->db->where('fid',$fid);
					
					
					$query = $this->db->get();
					$qwe = $query->result();	
					$this->db->where('fid !=' ,$fid);
					$this->db->where('company_id',$c );
					$query1 = $this->db->get('pms_appraisal_form');
$qwe1 = $query1->result();	
foreach($qwe1 as $query1){
							foreach($qwe as $query){


				$data = array(
							'scoring_guide' => $query->scoring_guide,
							
							'score_equivalent' =>  $query->score_equivalent,
							'score' => $query->score,
							'ranking' =>$query->ranking, 
							 'company_id' => $query->company_id,
							'fid' =>$query1->fid
					);
		

	$this->pms_model->add_grading_table($data);

}

					
	}
	
					$this->db->select('*');
					$this->db->from('pms_grading_table');
					$this->db->where('fid',$fid);
					$q = $this->db->get();
					$res = $q->result();
					foreach($res as $query){
						echo '<tr><td>'.$query->ranking.'</td><td>'.$query->score.'</td><td>'.$query->score_equivalent.'</td><td>'.$query->scoring_guide.'</td><td><a class="delete" data-id ="'.$query->gid.'"><i class="fa fa-trash fa-lg" aria-hidden="true"  style="color: red;"></i></a>
           </td></tr>';
					}	


	}

		public function get_existed_grading(){

					
			  	$i= $this->input->post('id');
				$this->db->where('fid',$i);
				$this->db->delete('pms_grading_table');
					$fid = $this->input->post('getfid');
					$this->db->select('*');
					$this->db->from('pms_grading_table');
					$this->db->where('fid',$fid);
					
					
					$query = $this->db->get();
					$qwe = $query->result();	
					
							foreach($qwe as $query){


				$data = array(
							'scoring_guide' => $query->scoring_guide,
							
							'score_equivalent' =>  $query->score_equivalent,
							'score' => $query->score,
							'ranking' =>$query->ranking, 
							 'company_id' => $query->company_id,
							'fid' =>$i,
							'color'=>$query->color
					);
				


	$this->pms_model->add_grading_table($data);



					
	}
	
					$this->db->select('*');
					$this->db->from('pms_grading_table');
					$this->db->where('fid',$i);
					$q = $this->db->get();
					$res = $q->result();
					foreach($res as $query){
						echo '<tr><td>'.$query->ranking.'</td><td>'.$query->score.'</td><td>'.$query->score_equivalent.'</td><td>'.$query->scoring_guide.'</td><td><a class="delete" data-id ="'.$query->gid.'"><i class="fa fa-trash fa-lg" aria-hidden="true"  style="color: red;"></i></a>
           </td></tr>';
					}	


	}
		public function get_selected_approvers($val,$company_id){
		
			

		
					$this->db->select('*');
					$this->db->from('pms_manage_form_approver_type');
					$this->db->where('company_id',$company_id);
		
					$query = $this->db->get();
					$q =  $query->result();

					
				if(!empty($q)){
					$data = array('creators_type' => $val);
					$this->db->where('company_id',$company_id);

					$this->db->update('pms_manage_form_approver_type', $data);
				}else{
					$data1 = array('creators_type' => $val,
									'company_id' => $company_id);

					$this->db->insert('pms_manage_form_approver_type', $data1);
			 
				}

			if($val=="4"){

				
				// $this->data['follow_form_approvers_setup']=$this->pms_model->get_follow_form_approvers_setup($company_id);
		 	    $data['company'] = $company_id;
				$data['get_department'] = $this->pms_model->get_department($company_id);
				$this->load->view('app/pms/follow_form_approvers_setup_approvers',$data);
				}elseif($val=="2"){

						$data['max']=$this->pms_model->get_eval_appro_score_max($company_id);
				$data['number_of_scorecard'] = $this->pms_model->get_eval_appro_score($company_id);
				 $data['opt2'] = $this->pms_model->opt2($company_id);	
				 	$data['out'] = $this->pms_model->get_scorecard_approver_option2($company_id);
				$this->load->view('app/pms/set_seperate_setup_approvers',$data);

			}else{
				
			}

		}

		// public function save_number_of_eval($company_id){
		// 	$this->db->select('evaluator');
		// 	$this->db->from('pms_aprov_eval_creator');
		// 	$this->db->where('company_id',$company_id);
		// 	$query = $this->db->get();
		// 	$q = $query->num_rows();
			
		// 	if($q == ""){
			
		// 		$this->db->insert('pms_aprov_eval_creator',$data);
		// 	}else{
		// 		$this->db->set('instruction', );
		// 		$this->db->where('company_id',$id);
		// 		$this->db->update('pms_aprov_eval_creator',$data);
		// 	}
	
			
		// }
		public function get_department_sec(){
				$i = $this->input->post('text1');
				if($i == 'all'){
					$res[]=array(
						'id'=> 'all',
						'name'=> 'all'
					);
				}else{
					$q = $this->pms_model->get_section($i);
				foreach($q as $e){

		
							  $res[]=array(
						        'id' => $e->section_id,
						        'name' => $e->section_name
								);

						
					

				}
				}
				
					echo json_encode($res);	
		}
	public function radio1(){
			$id = $this->input->post('text1');
			$this->pms_model->radio1($id);
	}

	public function qweq(){

		$this->load->view('app/pms/test',$this->data);
	}

		public function get_selected_plan($val,$company_id){
						
					
					$this->db->select('*');
					$this->db->from('pms_manage_employees_development_plan_type');
					$this->db->where('company_id',$company_id);

					$query = $this->db->get();
					$q =  $query->result();

					
				if(!empty($q)){
					$data = array('criteria_type' => $val);
					$this->db->where('company_id',$company_id);

					$this->db->update('pms_manage_employees_development_plan_type', $data);
				}else{
					$data1 = array('criteria_type' => $val,
									'company_id' => $company_id);
					$this->db->insert('pms_manage_employees_development_plan_type', $data1);
			 
				}

			if($val=="3"){

			
				$this->data['position_department_section']=$this->pms_model->position_department_section($company_id);

				$this->load->view('app/pms/position_department_section',$this->data);

 
				}elseif($val=="2"){


				 $this->data['position_department']=$this->pms_model->position_department_section($company_id);
				$this->load->view('app/pms/position_department',$this->data);

			}elseif($val=="1"){

							$data['position_department_section']=$this->pms_model->eposition($company_id);	 
				$this->load->view('app/pms/position',$data);

			}else{
				
			}

		}
	public function get_selected_evaluators($val,$company_id){
						
					
					$this->db->select('*');
					$this->db->from('pms_manage_form_evaluators_type');
					$this->db->where('company_id',$company_id);
		
					$query = $this->db->get();
					$q =  $query->result();

					
				if(!empty($q)){
					$data = array('creators_type' => $val);
					$this->db->where('company_id',$company_id);

					$this->db->update('pms_manage_form_evaluators_type', $data);
				}else{
					$data1 = array('creators_type' => $val,
									'company_id' => $company_id);
					$this->db->insert('pms_manage_form_evaluators_type', $data1);
			 
				}

			if($val=="4"){

				
				// $this->data['follow_form_approvers_setup']=$this->pms_model->get_follow_form_approvers_setup($company_id);
				$this->data['company'] = $company_id;
				$this->data['get_department'] = $this->pms_model->get_department($company_id);
				$this->load->view('app/pms/follow_form_approvers_setup_evaluators',$this->data);


				}elseif($val=="2"){
				$data['number_of_scorecard'] = $this->pms_model->get_eval_appro_score($company_id);
				$data['max']=$this->pms_model->get_eval_appro_score_max($company_id);
				 $data['opt2'] = $this->pms_model->opt2($company_id);			
				 
				 $data['out'] = $this->pms_model->get_scorecard_evaluator_option2($company_id);
				$this->load->view('app/pms/set_seperate_setup_evaluators',$data);

			}else{
				
			}

		}	


		public function get_multi(){

				$data['out'] = $this->pms_model->get_multi();
				$this->load->view('app/pms/modals/evaluator_modal',$data);
			}

			public function get_multi_apro(){

				$data['out'] = $this->pms_model->get_multi_apro();
				$this->load->view('app/pms/modals/approver_modal',$data);
			}
		public function get_modal_classification_evaluation(){

	
				$data['out'] = $this->pms_model->get_classification_evaluation($c,$creat);
				$this->load->view('app/pms/modals/evaluator_modal',$data);
			}	
		public function get_modal_section_evaluation(){

				$c= $this->input->post('c');
				$creat = $this->input->post('evaluator');
				$data['out'] = $this->pms_model->get_section_evaluation($c,$creat);
				$this->load->view('app/pms/modals/evaluator_modal',$data);
			}
		public function get_modal_department_evaluation(){

				$c= $this->input->post('c');
				$creat = $this->input->post('evaluator');
				$data['out'] = $this->pms_model->get_dept_evaluation($c,$creat);
				$this->load->view('app/pms/modals/evaluator_modal',$data);
			}
			
			public function get_modal_location_evaluation(){

				$c= $this->input->post('c');
				$creat = $this->input->post('evaluator');
				$data['out'] = $this->pms_model->get_location_evaluation($c,$creat);
				$this->load->view('app/pms/modals/evaluator_modal',$data);
			}




			public function get_modal_classification(){

				$c= $this->input->post('c');
				$creat = $this->input->post('creator');
				$data['out'] = $this->pms_model->get_classification_creator($c,$creat);
				$this->load->view('app/pms/modals/department_modal',$data);
			}	
		public function get_modal_section(){

				$c= $this->input->post('c');
				$creat = $this->input->post('creator');
				$data['out'] = $this->pms_model->get_section_creator($c,$creat);
				$this->load->view('app/pms/modals/department_modal',$data);
			}
		public function get_modal_department(){

				$c= $this->input->post('c');
				$creat = $this->input->post('creator');
				$data['out'] = $this->pms_model->get_dept_creator($c,$creat);
				$this->load->view('app/pms/modals/department_modal',$data);
			}
			public function get_modal_location(){

				$c= $this->input->post('c');
				$creat = $this->input->post('creator');
				$data['out'] = $this->pms_model->get_location_creator($c,$creat);
				$this->load->view('app/pms/modals/department_modal',$data);
			}


			public function get_selected_score($val,$company_id){
	
					$this->db->select('*');
					$this->db->from('pms_manage_form_score_type');
					$this->db->where('company_id',$company_id);

					$query = $this->db->get();
					$q =  $query->result();

					
				if(!empty($q)){
					$data = array('creators_type' => $val);
					$this->db->where('company_id',$company_id);

					$this->db->update('pms_manage_form_score_type', $data);
				}else{
					$data1 = array('creators_type' => $val,
									'company_id' => $company_id);
					$this->db->insert('pms_manage_form_score_type', $data1);
			 
				}

			if($val=="4"){

			
				$this->data['company'] = $company_id;
				$this->data['get_department'] = $this->pms_model->get_department($company_id);
				$this->load->view('app/pms/score_choose_position',$this->data);


 
				}elseif($val=="2"){
		
				 $data['number_of_scorecard'] = $this->pms_model->get_eval_appro_score($company_id);	
				 $data['out'] = $this->pms_model->get_scorecard_creator_option2($company_id);	
				 $data['opt2'] = $this->pms_model->opt2($company_id);

			

				 
				$this->load->view('app/pms/scorer_set_seperate_setup_scorers',$data);

			}else{
				
			}

		}
}//controller