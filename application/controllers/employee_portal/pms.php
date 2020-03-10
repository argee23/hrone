 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Pms extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/pms_model");
		$this->load->model("general_model");
	
		
	}	

	public function home(){
		$company = $this->input->post('company');
		$this->data['company'] = $this->input->post('company');
		$c =$this->input->post('company');
		$session_id = $this->session->userdata('employee_id');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['appraisal'] = $this->pms_model->get_sched($company);
		$this->data['appraisals'] = $this->pms_model->get_schedqwe($company);
		$this->data['se'] = $this->session->userdata('company_id');
		$this->data['employee_under_creator'] = $this->pms_model->employee_under_creator($company)['query'];
		$this->data['closest_appraisal'] = $this->pms_model->employee_under_creator($company)['q'];
		$this->data['company_'] = $this->input->post('company');
	 	$this->data['general_forms'] = $this->pms_model->get_general_forms($c);
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/pms/scorecard/home', $this->data);	
		$this->load->view('employee_portal/footer');	

	}
	public function index(){
		$data['c'] = $this->pms_model->get_company_all();
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/pms/scorecard/index', $data);	
		$this->load->view('employee_portal/footer');		
	}
	public function delete_criteria(){
			$id = $this->input->post('text1');
			$company_id = $this->input->post('text');
			$this->pms_model->delete_criteria($id,$company_id);
		}

	public function get_criteria_portal(){

		$c = $this->input->post('id');
		$data['employeeid'] =$this->input->post('employeeid');
		$data['form'] = $this->input->post('id');
		$data['doc_no'] = $this->input->post('doc_no');
		$data['elem'] = $this->input->post('elem');
		$data['res1'] = $this->pms_model->get_criteria_portal($c);
		$data['grading'] = $this->pms_model->get_grading_table_employeeportal($c);
		$this->load->view('employee_portal/pms/scorecard/create_criteria',$data);
	}
	public function view_scorecards($employee_id){
		$data['employeeid'] =$employee_id;
			$data['doc_no'] = $this->pms_model->get_doc_no($employee_id);
			$data['company'] = $this->input->post('company');

		$data['ref_eval'] = $this->pms_model->get_ref_no_of_evaluators($employee_id);
		$c = $this->session->userdata('company_id');
		$data['appraisal'] = $this->pms_model->get_sched($c);
		$data['employee_id'] = $employee_id;
		$data['name'] = $this->input->post('checkbox_value');
		// $this->data['ratee'] = $this->pms_model->get_emp_ratee($employee_id);
	 	 $data['general_forms'] = $this->pms_model->get_general_forms_admin($employee_id);
	 	  $data['emple_forms'] = $this->pms_model->get_general_forms_creator($employee_id);
	 	 
		// $this->data['forms'] = $this->pms_model->get_emp_form($employee_id);
		// $this->data['total_weight_form'] = $this->pms_model->get_total_weight_form($employee_id);
		// $this->data['appPeriod'] = $this->pms_model->getAppPeriod($employee_id);
		// $this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		// $this->data['checkFormPartNo']= $this->pms_model->validateFormPartNumber($employee_id);

		$this->load->view('employee_portal/pms/scorecard/scorecards',$data);	
	}

	public function save_grading_table(){  	


			
			$employeeid = $this->input->post('employeeid');
			$this->pms_model->add_grading_table($employeeid);
			$last_id = $this->db->insert_id();
			   $this->db->where('gid',$last_id);
   				$query = $this->db->get('pms_grading_table_employeeportal');
   				$q = $query->row();

			echo json_encode(array("score"=>$q->score,"score_equivalent"=>$q->score_equivalent,"scoring_guide"=>$q->scoring_guide));
			
			

		
	}

		public function save_criteria_form_admin(){  	
			
	 			
				
		
				$q = $this->pms_model->add_criteria_form_admin();
			
			
				
		
			


		}
		  public function submit_agree()
    {

    				$datas = array(
				'agreement'=>$this->input->post('agreed'),
	
		
		
				);

    	$q = $this->pms_model->agreed($datas);
    		if($q){
					$this->session->set_flashdata('result',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>agreement was succesfully submitted</div>");
				}else{
					$this->session->set_flashdata('result',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Submit of agreement failed</div>");
				}
    	header("Location: {$_SERVER["HTTP_REFERER"]}");
        }


		public function save_grading_table_admin(){  	


	
			
			$this->pms_model->add_grading_table_admin();
			$last_id = $this->db->insert_id();
			  	$this->db->where('gid',$last_id);
   				$query = $this->db->get('pms_grading_table_from_admin_employeeportal');
   				$q = $query->row();

			echo json_encode(array("score"=>$q->score,"score_equivalent"=>$q->score_equivalent,"scoring_guide"=>$q->scoring_guide));
			
			

		
	}

	public function get_employee_info_status(){

		$data['employeeid'] =$this->input->post('employeeid');
		$data['doc_no'] = $this->pms_model->get_doc_no($this->input->post('employeeid'));
		$data['ref_eval'] = $this->pms_model->get_ref_no_of_evaluators($this->input->post('employeeid'));


		$data['elem'] = $this->input->post('elem');
		
		$data['grading'] = $this->pms_model->get_grading_table_employeeportal('1');
		$this->load->view('employee_portal/pms/scorecard/get_employee_info_status',$data);
	}
		public function save_criteria_form(){  	
			
	 			
				
		
				$q = $this->pms_model->add_criteria_form();
			
			
				


		}
		
			public function delete_grade(){
			$id = $this->input->post('text1');
			$company_id = $this->input->post('text');
			$this->pms_model->deleting_grade($id,$company_id);
		}
	public function view_general_form($id, $employee_id){
		$this->data['employee'] = $this->pms_model->get_emp_info($employee_id);
		$this->data['gforms'] = $this->pms_model->get_general_form_info($id);
		$this->data['sc'] = $this->pms_model->get_general_score_criteria($id);
		$this->data['position_areas'] = $this->pms_model->get_position_areas($employee_id, $this->data['gforms']->id, $this->data['employee']->position);
		$this->data['sum_weight'] = $this->pms_model->get_total_weight($employee_id, $this->data['gforms']->id, $this->data['employee']->position);

		$this->load->view('employee_portal/pms/scorecard/general_form', $this->data);
		$this->load->view('employee_portal/footer');
	}
public function approver_for(){


		   	$this->pms_model->approver_for($this->input->post('company'));
		 
	
	}
			public function mass_approval()
	{
		$data["employee"] = $this->pms_model->employee_approver();

	
		$this->load->view('employee_portal/header');

	
			$this->load->view('employee_portal/pms/form_approver/mass_approval',$data);
				$this->load->view('employee_portal/footer');
	
		
	}
		public function mass_respond()
	{	

			$doc_no = $this->input->post('doc_no');
			foreach($doc_no as $doc_no){
 	   $name = $this->input->post($doc_no . "_status");


			
					$this->pms_model->mass_res($name,$doc_no);
			}
		

	 	
		
	}
		
	
	 
	public function evaluation_for($c){


		   	$this->pms_model->evaluation_for($c);
		 
	
	}

	public function get_criteria(){
		$data['employeeid'] =$this->input->post('employeeid');
		$c = $this->input->post('id');
		$data['elem'] = $this->input->post('elem');
		$data['doc_no'] = $this->input->post('id');
		$data['form'] = $this->input->post('fid');
		$e = $this->input->post('fid');
		$data['res1'] = $this->pms_model->get_criteria_admin($c,$e);
		$data['grading'] = $this->pms_model->get_grading_table($this->input->post('fid'),$c);
		$this->load->view('employee_portal/pms/scorecard/view_form',$data);
	}

	public function save_general_form(){

		 if($this->input->post('checkbox_value') and $this->input->post('checkbox_value2') and $this->input->post('position'))
		  {
		   $id = $this->input->post('checkbox_value');
		   $id4 = $this->input->post('checkbox_value2');
		   $ran = $this->input->post('ran');
		   	   $position = $this->input->post('position');
		   for($count = 0; $count < count($id); $count++)
		   {
		   		

		   	$this->pms_model->save_general_form($id[$count],$id4,$position[$count],$ran[$count]);
		   }
		  }	
	
	}
		public function delete_form_score(){
		$qwe = $this->input->post('fid');
		$this->pms_model->delete_form_score($qwe);

	}


	public function add_general_form(){
		$employee_id = $this->input->post('emp_id');
		$form_id = $this->input->post('form_id');

		$pos_area1 = stripcslashes($this->input->post('posAreaData'));
		$pos_area = json_decode($pos_area1, TRUE);

		$score_criteria1 = stripcslashes($this->input->post('scoreCriteriaData'));
		$score_criteria = json_decode($score_criteria1, TRUE);

		$emp = $this->pms_model->get_emp_info($employee_id);
		$form_data = $this->pms_model->get_general_form_info($form_id);
		$form_total = $this->pms_model->get_total_weight_form($employee_id);

		$this->pms_model->add_general_form($employee_id, $form_id, $pos_area, $score_criteria);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  PMS Form Successfully Filed for <strong>".$emp->fullname.".</strong></div>");

		$this->session->set_flashdata('onload',"scorecard('".$employee_id."')");
		$this->index();
	}



// =====
	public function myobjectives(){


    	$this->load->view('employee_portal/header');
		echo '
		<br><br><br><br>
			<div class="col-md-12 box box-danger">
			<div class="box box-header">My Objectives</div>
			<div class="box-body">
				<table class="table table">
				<thead>
					<tr>
						<th>Objective Topic</th>
						<th>Details</th>
						<th>Note
						</th>
					</tr>
				</thead>
					<tr class="bg-primary">
						<td>Sales Quota</td>
						<td>10 MILLION</td>
						<td><i class="fa fa-edit"></i></td>
					</tr>
					<tr >
						<td>Hardware Sales</td>
						<td>1 MILLION</td>
						<td><i class="fa fa-edit"></i></td>
					</tr>
					<tr class="bg-primary">
						<td>Software Sales</td>
						<td>9 MILLION</td>
						<td><i class="fa fa-edit"></i></td>
					</tr>
					<tr >
						<td>Sample</td>
						<td>Sample Details</td>
						<td><i class="fa fa-edit"></i></td>
					</tr>					
				</table>
			</div>
			</div>

		';

		$this->load->view('employee_portal/footer');
	}
// =====


	public function view_form($id, $employee_id){
		$this->data['employee'] = $this->pms_model->get_emp_info($employee_id);
		$this->data['forms'] = $this->pms_model->get_form_details($id);
		$this->data['sc'] = $this->pms_model->get_form_score_criteria($id);
		$this->data['position_areas'] = $this->pms_model->get_form_score($id);
		$this->data['sum_weight'] = $this->pms_model->get_total_weight_score($this->data['forms']->form_part_id);
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['onload'] = $this->session->flashdata('onload');

		$this->load->view('employee_portal/pms/scorecard/view_form', $this->data);
		$this->load->view('employee_portal/footer');
	}

	public function add_pos_area(){
		$id = $this->input->post('form_id');
		$pos_area = $this->input->post('pos_area');
		$area_desc = $this->input->post('area_desc');
		$weight = $this->input->post('weight');

		$this->pms_model->add_pos_area($id, $pos_area, $area_desc, $weight);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Position Area Successfully Added!</div>");
	}

	public function view_edit_pos_area($id){
		$this->data['pos_area'] = $this->pms_model->get_pos_area($id);

		$this->load->view('employee_portal/pms/scorecard/edit_pos_area', $this->data);	
	}

	public function update_pos_area(){
		$id = $this->input->post('id');
		$pos_area = $this->input->post('pos_area');
		$area_desc = $this->input->post('desc');
		$weight = $this->input->post('area_weight');

		$this->pms_model->update_pos_area($id, $pos_area, $area_desc, $weight);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Position Area Successfully Updated! </strong></div>");

		$this->view_form();
	}
	public function save_general_form_employee(){  	
		

					$this->db->select('*');
			$this->db->from('pms_scorecard_format_employeeportal');
			$this->db->where("doc_no",$this->input->post('id').'_'.$this->input->post('cover_year') );
			$meron = $this->db->get();
			$dup =  $meron->num_rows();


			if($dup==0){
			$data2 = array(
				'employee_id'=>$this->input->post('id'),
				'doc_no'=>$this->input->post('id').'_'.$this->input->post('cover_year'),
				'cover_year' => $this->input->post('cover_year'),
				'appraisal_period_type' => $this->input->post('appraisal_period_type'),
				'appraisal_type' => $this->input->post('appraisal_type'),
				'appraisal_period_type_dates' => $this->input->post('appraisal_period_type_dates'),
				'company_id'=>$this->session->userdata('company_id')


				);
		$this->db->insert('pms_scorecard_format_employeeportal',$data2);
	}

		$data = array(
			'form_title' => $this->input->post('form_title',true),
			'grading_type' => $this->input->post('radio',true),
			'form_instruction' => $this->input->post('instruction',true),
			'date_added' =>  date('Y-m-d H:i:s'),
			'form_description' => $this->input->post('form_description',true),
			'weight' => $this->input->post('weight',true),
			'company_id' => $this->session->userdata('company_id'),
			'employee_id' => $this->input->post('id',true),
			'doc_no'=>$this->input->post('id').'_'.$this->input->post('cover_year')

		);
			
				$data['appraisal_form'] = $this->pms_model->add_general_form($data);
		

			
				$last_id = $this->db->insert_id();
			   $this->db->where('fid',$last_id);
   				$query = $this->db->get('pms_general_form_employeeportal');
   				$q = $query->row();

			echo json_encode(array("form_title"=>$q->form_title,"fid"=>$q->fid,"doc_no"=>$q->doc_no));
			

		}
	public function delete_pos_area($id, $form_id, $employee_id){
		$this->pms_model->delete_pos_area($id);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Position Area Successfully Deleted!</div>");

		redirect('employee_portal/pms/view_form/'.$form_id.'/'.$employee_id);
	}

		public function form(){
		$this->load->view('employee_portal/pms/scorecard/form');
		$this->load->view('employee_portal/footer');
	}


	public function update_form(){
		$id = $this->input->post('form_id');
		$check = $this->pms_model->check_form_score($id);
		$form_details = $this->pms_model->get_form_details($id);
		if(!$check){
			$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> No Position Areas ! </strong></div>");

		} else {
			$this->pms_model->update_form($id);
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> PMS Form Successfully Updated! </strong></div>");
		}

		$this->session->set_flashdata('onload',"scorecard('".$form_details->employee_id."')");
		$this->index();
	}

	public function create_form(){
		$employee_id = $this->input->post('emp_id');
		$part_num = $this->input->post('part_num');
		$part_name = $this->input->post('part_name');
		$weight = $this->input->post('weight');
		$instructions = $this->input->post('instructions');
		$part_desc = $this->input->post('part_desc');

	 	$emp = $this->pms_model->get_emp_info($employee_id);
	 	$form_total = $this->pms_model->get_total_weight_form($employee_id);

		$this->pms_model->create_form($employee_id, $part_num, $part_name, $weight, $instructions, $part_desc);

		$this->session->set_flashdata('message', "<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  PMS Form Successfully Created for <strong>".$emp->fullname.".</strong></div>");

		$this->session->set_flashdata('onload',"scorecard('".$employee_id."')");

		$this->index();
	}

	public function edit_form_details($id, $employee_id){	
		$this->data['form_details'] = $this->pms_model->get_form_details($id);

		$this->load->view('employee_portal/pms/scorecard/edit_form',$this->data);
	}

	public function save_edit_form_details(){
		$this->form_validation->set_rules("part_name","Form Part Name","trim|required");
		$this->form_validation->set_rules("instructions","Form instructions","trim|required");
		$this->form_validation->set_rules("part_desc","Form Part Description","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		$id = $this->input->post('id');
		$form_details = $this->pms_model->get_form_details($id);

		if($this->form_validation->run()){

			$value = $this->input->post('part_name');
			$weight = $this->input->post("form_weight");
			$form_total = $this->pms_model->get_total_weight_form($form_details->employee_id);

			if (($form_total->total_weight + ($weight - $form_details->form_weight)) > 100){

				$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  PMS Form Exeeds in Total Weight of 100%.</strong></div>");

				$this->session->set_flashdata('onload',"scorecard('".$form_details->employee_id."')");
				redirect(base_url().'employee_portal/pms/index', $this->data);

			} else {
				$this->pms_model->save_edit_form_details();

				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Form Part <strong>".$value."</strong>, is Successfully Updated!</div>");

				$this->session->set_flashdata('onload',"scorecard('".$form_details->employee_id."')");
				redirect(base_url().'employee_portal/pms/index', $this->data);
			}

		}else{
			$this->session->set_flashdata('onload',"scorecard('".$form_details->employee_id."')");
			$this->index();
		}
	}

	public function manage_form_part($id){
		$this->data['form_id'] = $id;
		$this->data['form_part_mng'] = $this->pms_model->get_form_criteria($id);
		$this->data['check'] = $this->pms_model->check_form_criteria($id);
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$this->load->view('employee_portal/pms/scorecard/form_parts_mng', $this->data);
	}

	public function edit_form_score_criteria($id){	
		$this->data['form_score_det']= $this->pms_model->get_form_criteria_details($id);

		$this->load->view('employee_portal/pms/scorecard/edit_form_score_criteria', $this->data);
	}

	public function add_form_score(){
		$fpid=$this->input->post("form_part_id");
		$this->form_validation->set_rules("score_equivalent","Score Equivalent","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		$form_details = $this->pms_model->get_form_details($fpid);

		if($this->form_validation->run()){
			$this->pms_model->save_form_score();

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Form Part Score Criteria is Successfully Added!</div>");
			$this->session->set_flashdata('onload',"scorecard('".$form_details->employee_id."')");

			redirect(base_url().'employee_portal/pms/index', $this->data);
		}else{
			$this->session->set_flashdata('onload',"scorecard('".$form_details->employee_id."')");
			$this->index();
		}		
	}

	public function save_edit_form_score(){
		$fpid=$this->input->post("form_part_id");
		$this->form_validation->set_rules("score_equivalent","Score Equivalent","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		$form_details = $this->pms_model->get_form_details($fpid);

		if($this->form_validation->run()){
			$this->pms_model->save_edit_form_score();

			$value = $this->input->post('score_equivalent');

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Form Score Criteria <strong>".$value."</strong>, is Successfully Updated!</div>");
			$this->session->set_flashdata('onload',"scorecard('".$form_details->employee_id."')");

			redirect(base_url().'employee_portal/pms/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"scorecard('".$form_details->employee_id."')");
			$this->index();
		}
	}


	public function delete_form(){
		$id = $this->input->post('id');
		$employee_id = $this->input->post('employee_id');

		$this->pms_model->delete_form($id);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Form is Successfully Deleted!</div>");
		
		$this->session->set_flashdata('onload',"scorecard('".$employee_id."')");
		$this->index();
	}

	public function updateAppPeriod(){
		$emp_id = $this->input->post('emp_id');
		$from = $this->input->post('from');
		$to = $this->input->post('to');

		$this->pms_model->updateAppPeriod($emp_id, $from, $to);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> PMS Appraisal Period Successfully Updated!</div>");

		$this->session->set_flashdata('onload',"scorecard('".$emp_id."')");
		$this->index(); 
	}



	// EVALUATION
	public function update_recommend(){  	


	
			$this->pms_model->update_recommend();
	

			
			

		
	}

	public function for_recommend(){
			$data['exist'] = $this->pms_model->exist( $this->input->post('doc_no'));
			$data['position'] = $this->pms_model->position();
			$data['transfer_posi'] = $this->pms_model->position();
			$data['position1'] = $this->pms_model->position();
			$data['dept'] = $this->pms_model->get_all_dept();
			$data['recommnd_s'] = $this->pms_model->recommendation_s($this->input->post('doc_no'));
			$data['eval']=  $this->pms_model->evals($this->input->post('doc_no'));
			$data['get_last_eval'] = $this->pms_model->get_last_eval($this->input->post('doc_no'));
			$data['e'] = $this->input->post('e');
			$data['no'] = $this->input->post('doc_no');
			$this->load->view('employee_portal/pms/evaluation/for_recommend',$data);	

	}
		public function for_self(){
				$data = array(
					'status' => 'done',
			
				);

				$q  = $this->db->update('pms_evaluationself_employeeportal', $data);
				if($q){
					$this->session->set_flashdata('result',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Evaluation form was succesfully submitted</div>");
				}else{
					$this->session->set_flashdata('result',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Evaluation form was not submitted </div>");
				}
				return redirect('employee_portal/pms/selfeval');
						

			
	}


	public function criteria_form_admin(){
			
			$data['eval']=  $this->pms_model->evals($this->input->post('doc_no'));
			$data['max'] = $this->pms_model->get_max_eval($this->input->post('doc_no'));
			$c = $this->input->post('fid');
			$fid = $this->input->post('fid');
			$e = $this->input->post('e');
			$data['grading_type'] = $this->input->post('grading_type');
			$data['doc_no'] = $this->input->post('doc_no');
			$data['max_id'] = $this->pms_model->max_id($this->input->post('doc_no'),$this->input->post('max_id'));
		
			$data['employee'] =  $this->input->post('e');
			$data['fid'] = $this->input->post('fid');
			$data['get_date'] = $this->pms_model->get_date($this->input->post('doc_no')); 
			$data['res1'] = $this->pms_model->get_criteria_admin($this->input->post('doc_no'),$fid);
			$data['ref'] = $this->pms_model->get_ref($this->input->post('doc_no'));
			$data['grading'] = $this->pms_model->get_grading_table($c,$this->input->post('doc_no'));
			$data['grading_order'] = $this->pms_model->get_grading_table_order($c,$this->input->post('doc_no'));
			$data['instruction'] = $this->pms_model->get_instruction($c,$this->input->post('doc_no'));

			$this->load->view('employee_portal/pms/evaluation/criteria_form_admin',$data);	

	}
	public function evaluation_home(){
		$data['message'] 	=  $this->session->flashdata('message');	
		$this->data['onload'] = $this->session->flashdata('onload');
		$c  = $this->input->post('company'); 
		$data['company'] = $this->input->post('company');
		$data['employee'] = $this->pms_model->employee_evaluation4($this->input->post('company'));
		$data['employee_id'] = $this->pms_model->get_evaluator_($c);

		$data['er'] = $this->pms_model->qwe();
	 // 	$data['general_forms'] = $this->pms_model->get_general_forms($c);
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/pms/evaluation/evaluation_home',$data);	
		$this->load->view('employee_portal/footer');
	}

	public function evaluation(){	
		// $this->data['eval'] = $this->pms_model->get_emp_eval($this->session->userdata('employee_id'));
		// $this->data['min_eval'] = $this->pms_model->get_min_emp_eval($this->session->userdata('employee_id'));
			$data['c'] = $this->pms_model->get_company_all();

	 // 	$data['general_forms'] = $this->pms_model->get_general_forms($c);
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/pms/evaluation/evaluate',$data);	
		$this->load->view('employee_portal/footer');
	}


	public function save_recommendatin(){  	


	
			$this->pms_model->save_recommendatin();
	

			
			

		
	}

		public function save_evaluation(){  	


	
			$this->pms_model->save_evaluation();
	

			
			

		
	}


    public function evaluate_form($id,$doc_no,$date,$company){
		$data['get_last_eval'] = $this->pms_model->get_last_eval($doc_no);
  		$data['doc_no'] = $doc_no;
    	$data['employee_id'] = $id;
    	$data['eval_c'] = $this->pms_model->ceveal($id);
		$data['max'] = $this->pms_model->get_max_eval($doc_no);
		$data['name'] = $this->input->post('checkbox_value');
		$data['general_forms'] = $this->pms_model->get_general_forms_admin($id);
	 	 $data['emple_forms'] = $this->pms_model->get_general_forms_creator($id);
		$data['eval']=  $this->pms_model->evals($doc_no);
		$data['company'] = $company;

	 	 		$data['ref'] = $this->pms_model->get_ref($doc_no);
    		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/pms/evaluation/evaluate_form',$data);	
		$this->load->view('employee_portal/footer');
	}


	public function update_scores(){
		$this->pms_model->update_scores();
	}	public function criteria_form_employeeportal(){
			$c = $this->input->post('id');
			$data['employee'] =  $this->input->post('e');
				$e = $this->input->post('e');
			$data['res1'] = $this->pms_model->get_criteria_portal($c);
$data['eval']=  $this->pms_model->evals( $this->input->post('doc_no'));
$data['ref'] = $this->pms_model->get_ref($this->input->post('doc_no'));
			$data['grading'] = $this->pms_model->get_grading_table_employeeportal($c);
				$data['doc_no'] = $this->input->post('doc_no');


			$data['max'] = $this->pms_model->get_max_eval($this->input->post('doc_no'));
			$e = $this->input->post('e');
			$data['id'] = $this->input->post('id');
			



			$this->load->view('employee_portal/pms/evaluation/criteria_form_employeeportal',$data);	

	}
	public function evaluation_history(){
		$data['message'] 	=  $this->session->flashdata('message');
		$data['his'] = $this->pms_model->history_eval();	
		
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/pms/evaluation/history',$data);	
		$this->load->view('employee_portal/footer');

	}

	public function update_eval_form(){
		$doc_no = $this->input->post('doc_no');
		$emp_id = $this->input->post('emp_id');
		$form_id = $this->input->post('form_id');

		$this->pms_model->update_eval_form();

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> PMS Form Successfully Filed!</div>");

		$this->session->set_flashdata('onload',"evaluate_form('".$emp_id."', '".$doc_no."', '".$form_id."', 'ON')");
		$this->evaluation();
	}

			public function reject_eval($doc_no){  	


	
			$this->pms_model->reject_eval($doc_no);
	

			
			

		
	}
			public function next_eval(){  	


	
			$i = $this->pms_model->next_eval();
			if($i){
				     $this->session->set_flashdata('result',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Recommendation is Successfully Deleted!</div>");
		

					 redirect(base_url().'employee_portal/pms/evaluation',$this->data);
			}
	

			
			

		
	}


	public function add_recommendation(){
		$emp_id = $this->input->post('emp_id');
		$doc_no = $this->input->post('doc_no');
		$recommendation = $this->input->post('rc');
		$from = $this->input->post('from');
		$to = $this->input->post('to');

		$this->pms_model->add_recommendation($doc_no, $recommendation, $from, $to);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Recommendation Successfully Added!</div>");

		$this->session->set_flashdata('onload',"evaluate_form('".$emp_id."', '".$doc_no."')");
		//$this->evaluation();
	}

	public function delete_recommendation($id, $doc_no ,$emp_id){
		$this->pms_model->delete_recommendation($id);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Recommendation is Successfully Deleted!</div>");
		
		$this->session->set_flashdata('onload',"evaluate_form('".$emp_id."', '".$doc_no."')");
		redirect('employee_portal/pms/evaluation');
	}


	// FORM APPROVAL
		public function next_appro(){  	

			$appro =   $this->pms_model->appro($this->input->post('doc_no'),$this->input->post('company'));
	
			$this->pms_model->next_appro($appro->appro_level);
	
	}

	public function dependents_modal()
	{

		$data['name'] = $this->input->post('name');
		$data['company'] = $this->input->post('company');
		$data['employee_id'] = $this->input->post('employee_id');
		$data['classification'] = $this->input->post('classification');
		$data['position'] = $this->input->post('position');
		$data['department'] = $this->input->post('department');
		$data['get_current_appraisal_schedule'] = $this->pms_model->get_current_appraisal_schedule($this->input->post('doc_no'),$this->input->post('company'));
		$data['forms'] = $this->pms_model->get_general_forms_admin($this->input->post('employee_id'));
		$data['forms_creator'] = $this->pms_model->get_general_forms_creator($this->input->post('employee_id'));
		$data['get_computation'] = $this->pms_model->get_computation();



	$this->load->view('employee_portal/pms/form_approver/approving_modal',$data);
			
	}
	public function form_approval(){
		$this->data['get_forms'] = $this->pms_model->get_forms_pending();
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/pms/form_approval/form_approval', $this->data);
		$this->load->view('employee_portal/footer');		
	}

	// public function get_form_details($doc_no){ 
	// 	$res = $this->pms_model->get_criteria_admin_for_approver($doc_no);
	// 	// $data = $this->pms_model->get_overall_details($doc_no, $form_part_id);
	// 	foreach($res as $res){

	// 						  $q[]=array(
	// 					        'area' => $res->area
	
	// 							);

	// 	}
	// 	echo json_encode($q);
	// }

	public function respond(){
		$this->pms_model->respond();
		$doc_no = $this->input->post('doc_no');
		$status = $this->input->post('status');
		$this->session->set_flashdata('feedback', 'Document ' .  $doc_no . ' is succesfully ' . $status . '.');

		redirect('/employee_portal/pms/form_approval');
	}

	public function view($doc_no){
		$this->data["companyInfo"] = $this->pms_model->get_company_info();
		$this->data['file'] = $this->pms_model->get_doc_info($doc_no);

		$this->load->view('employee_portal/pms/form_approval/form_view',$this->data);
	}




	// FORM EVALUATORS

	public function is_form_ready($id){
		$this->db->select('*');
		$this->db->from('pms_employee_forms_employeeportal');
		$this->db->where('doc_no',$id);
		$this->db->where('status !=','completed');

		$query = $this->db->get();
		$f = $query->num_rows();
		echo $f;
	}	
	public function form_evaluator(){
		$this->data['evaluee']  =  $this->pms_model->get_evaluee_evaluator($this->session->userdata('employee_id'));
		$this->data['message'] 	=  $this->session->flashdata('message');
		$this->data['onload'] = $this->session->flashdata('onload');
		
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/pms/form_evaluator/evaluators', $this->data);	
		$this->load->view('employee_portal/footer');		
	}

	public function view_evaluators($employee_id){
		$this->data['ratee'] = $this->pms_model->get_emp_evaluee($employee_id);
		$this->data['forms'] = $this->pms_model->get_created_form($employee_id);
		$this->data['evals'] = $this->pms_model->get_evaluators($this->data['ratee']->employee_id);
		$this->data['available_employee'] = $this->pms_model->get_available_evaluator($this->data['ratee']->company_id);

		$this->load->view('employee_portal/pms/form_evaluator/view_evaluators', $this->data);	
	}

	// public function save_evaluator($employee_id){
 //        $employee_selected      = $this->input->post('employeeselected');
 //        $result          		= $this->input->post('approval_result');
	// 	$apply_result          	= $this->input->post('applyOption_result');
	// 	$level         			= $this->input->post('level');
 //        $emp 					= $this->pms_model->get_emp_info($employee_id);
	//     $employee_info 			= $this->pms_model->get_emp_info($employee_selected);
	//     $numEvaluator			= $this->pms_model->getNumEval($this->session->userdata('company_id'));
	//     $count_eval 			= $this->pms_model->count_evaluators($employee_id, $level);

	//     if($numEvaluator == $count_eval){
	//     	$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Evaluator's Limit Exceeded.</div>");

	//     } else {

	//     	if($apply_result == null || $apply_result == ''){
	//     		$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Please indicate the form name to evaluate.</div>");

	//     	} else {

	// 			$data_employee = array(
	//             	'evaluee_id'					=> $employee_id,
	//                 'employee_id'          			=> $employee_selected,
	//                 'company_id'           			=> $employee_info->company_id,
	//                 'division'           			=> $employee_info->division_id,
	//                 'department'           			=> $employee_info->department,
	//                 'section'           			=> $employee_info->section,
	//                 'subsection'           			=> $employee_info->subsection,
	//                 'location'           			=> $employee_info->location,
	//                 'position'						=> $employee_info->position,
	//                 'classification'           		=> $employee_info->classification,
	//                 'evaluator_category'			=> $result,
	//                 'evaluator_level'				=> $level,
	//                 'setting'						=> $apply_result,
	//                 'InActive'						=> 0
	//             );

	// 			$this->pms_model->insert_evaluator($data_employee);

	// 			$this->pms_model->insert_score_evaluator($employee_selected, $level, $apply_result);

	//     		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Evaluator Successfully Added.</div>");

	//     	}
	    	
	//     }

 //    	$this->session->set_flashdata('onload',"evaluators(".$employee_id.")");

 //    	redirect('employee_portal/pms/form_evaluator');
 //    }

    public function delete_eval(){
    	$evaluee_id = $this->input->post('evaluee_id');
    	$form_id = $this->input->post('form_part_id');
		$emp_id = $this->input->post('employee_id');

    	$this->pms_model->delete_eval($evaluee_id, $emp_id, $form_id);

    	$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Evaluator Successfully Removed.</div>");

    	$this->session->set_flashdata('onload',"evaluators(".$evaluee_id.")");
    	$this->form_evaluator();
    }




    // FORM APPROVERS

    	public function approvers(){	
		// $this->data['eval'] = $this->pms_model->get_emp_eval($this->session->userdata('employee_id'));
		// $this->data['min_eval'] = $this->pms_model->get_min_emp_eval($this->session->userdata('employee_id'));
			$data['company'] = $this->input->post('company');
		$data['employee_id'] = $this->pms_model->get_approver_($this->input->post('company'));
		$this->data['message'] 	=  $this->session->flashdata('message');	
		$this->data['onload'] = $this->session->flashdata('onload');
		$data['employee'] = $this->pms_model->employee_approver($this->input->post('company'));
	

		
	 // 	$data['general_forms'] = $this->pms_model->get_general_forms($c);
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/pms/form_approver/approver',$data);	
		$this->load->view('employee_portal/footer');
	}
		public function index_approval(){
		$data['c'] = $this->pms_model->get_company_all();
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/pms/form_approver/index', $data);	
		$this->load->view('employee_portal/footer');		
	}



    public function form_approver(){	
		$this->data['evaluee']  =  $this->pms_model->get_evaluee_approver($this->session->userdata('employee_id'));
		$this->data['message'] 	=  $this->session->flashdata('message');
		$this->data['onload'] = $this->session->flashdata('onload');

		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/pms/form_approver/approvers', $this->data);	
		$this->load->view('employee_portal/footer');		
	}

	public function view_approvers($employee_id){
		$this->data['ratee'] = $this->pms_model->get_emp_evaluee($employee_id);
		$this->data['apps'] = $this->pms_model->get_form_approver($this->data['ratee']->employee_id);
		$this->data['available_employee'] = $this->pms_model->get_available_approver($this->data['ratee']->company_id);

		$this->load->view('employee_portal/pms/form_approver/view_approvers', $this->data);	
	}


	public function save_approver($employee_id){
        $employee_selected      = $this->input->post('employeeselected');
        $result          		= $this->input->post('approval_result');
		$apply_result          	= $this->input->post('applyOption_result');
		$level         			= $this->input->post('level');
        $emp 					= $this->pms_model->get_emp_info($employee_id);
	    $employee_info 			= $this->pms_model->get_emp_info($employee_selected);
	    $numApp					= $this->pms_model->getNumApp($this->session->userdata('company_id'));
	    $count_app				= $this->pms_model->count_approver($employee_id, $level);

	    if($numApp == $count_app){
	    	$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Approver's Limit Exceeded.</div>");
	    } else {
	    	 $data_employee = array(
            	'evaluee_id'					=> $employee_id,
                'employee_id'          			=> $employee_selected,
                'company_id'           			=> $employee_info->company_id,
                'division'           			=> $employee_info->division_id,
                'department'           			=> $employee_info->department,
                'section'           			=> $employee_info->section,
                'subsection'           			=> $employee_info->subsection,
                'location'           			=> $employee_info->location,
                'position'						=> $employee_info->position,
                'classification'           		=> $employee_info->classification,
                'approval_category'				=> $result,
                'approval_level'				=> $level,
                'setting'						=> $apply_result,
                'InActive'						=> 0
            );

			$this->pms_model->insert_approver($data_employee);

    		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Approver Successfully Added.</div>");
	    }
    	
    	$this->session->set_flashdata('onload',"approvers(".$employee_id.")");	
    	redirect('employee_portal/pms/form_approver');
    }
    

    public function delete_app(){
    	$evaluee_id = $this->input->post('evaluee_id');
    	$this->pms_model->delete_app();

    	$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Approver Successfully Removed.</div>");

    	$this->session->set_flashdata('onload',"approvers(".$evaluee_id.")");
    	$this->form_approver();
    }



	// MY PMS FORMS

	public function my_forms(){
		$this->load->view('employee_portal/header');
		$this->load->view('employee_portal/pms/my_forms/view_form');		
		$this->load->view('employee_portal/footer');	
	}

    public function view_pms(){
    	$this->data['my_forms'] = $this->pms_model->my_forms();

    	$this->load->view('employee_portal/header');
    	$this->load->view('employee_portal/pms/my_forms/my_forms', $this->data);
    	$this->load->view('employee_portal/footer');
    }
        public function selfeval(){

        $doc_no = $this->pms_model->get_doc_no( $this->session->userdata('employee_id'));
        if(empty($doc_no)){
        	$doc_no = '';	
        }else{
        	$doc_no = $doc_no->doc_no;
        }
		$data['get_last_eval'] = $this->pms_model->get_last_eval($doc_no);
  		$data['doc_no'] = $doc_no;
    	$data['employee_id'] = $this->session->userdata('employee_id');
    	$data['eval_c'] = $this->pms_model->ceveal($this->session->userdata('employee_id'));
		$data['max'] = $this->pms_model->get_max_eval($doc_no);
		$data['name'] = $this->input->post('checkbox_value');

					$this->db->select('*');
			$this->db->from('pms_settings_evalself a');
			$this->db->where('company_id',$this->session->userdata('company_id'));
			$query = $this->db->get();
			$qs = $query->row();

					if(!empty($qs->self_eval)=='1'){		
		$data['general_forms'] = $this->pms_model->get_general_forms_admin($this->session->userdata('employee_id'));
	 	 $data['emple_forms'] = $this->pms_model->get_general_forms_creator($this->session->userdata('employee_id'));

					
									}

	
		$data['eval']=  $this->pms_model->evals($doc_no);

	 	 		$data['ref'] = $this->pms_model->get_ref($doc_no);
    
    	$this->load->view('employee_portal/header');
    	$this->load->view('employee_portal/pms/my_forms/selfeval', $data);
    	$this->load->view('employee_portal/footer');
    }
     public function self_form_admin(){
			$data['eval']=  $this->pms_model->evals($this->input->post('doc_no'));
			$data['max'] = $this->pms_model->get_max_eval($this->input->post('doc_no'));
			$c = $this->input->post('fid');
			$fid = $this->input->post('fid');
			$e = $this->input->post('e');
			$data['grading_type'] = $this->input->post('grading_type');
			$data['doc_no'] = $this->input->post('doc_no');
			$data['max_id'] = $this->pms_model->max_id($this->input->post('doc_no'),$this->input->post('max_id'));
		
			$data['employee'] =  $this->input->post('e');
			$data['fid'] = $this->input->post('fid');
			$data['get_date'] = $this->pms_model->get_date($this->input->post('doc_no')); 
			$data['res1'] = $this->pms_model->get_criteria_admin($this->input->post('doc_no'),$fid);
			$data['ref'] = $this->pms_model->get_ref($this->input->post('doc_no'));
			$data['grading'] = $this->pms_model->get_grading_table($c,$this->input->post('doc_no'));
			$data['grading_order'] = $this->pms_model->get_grading_table_order($c,$this->input->post('doc_no'));
			$data['instruction'] = $this->pms_model->get_instruction($c,$this->input->post('doc_no'));

			$this->load->view('employee_portal/pms/my_forms/self_form_admin',$data);	
    }


    public function view_pms_form($employee_id, $doc_no){
    	$this->data['doc_no'] = $doc_no;
    	 $this->data['file'] = $this->pms_model->get_doc_info($doc_no);
    	 $this->data['recom'] = $this->pms_model->get_recommendation($doc_no);
  	   $this->data['emp_info'] = $this->pms_model->get_employee_details($employee_id);
    	$this->data['emp_info2'] = $this->pms_model->get_emp_info($employee_id);
    	 $this->data['summary'] = $this->pms_model->get_form_det($doc_no);
    	    	 $this->data['eval'] = $this->pms_model->sup($doc_no,$employee_id);
    	    	 	 $this->data['qwse'] = $this->pms_model->s($doc_no,$employee_id);
    	    $this->data['grading_type'] = $this->pms_model->grading_type();
    	 // $this->data['fsummary'] = $this->pms_model->get_form_weight($doc_no);
    	$this->data['gIns'] = $this->pms_model->get_general_instruction();
    	$this->data['get_current_appraisal_schedule_of_employee'] = $this->pms_model->get_current_appraisal_schedule_of_employee($doc_no);
    	// $this->data['evals'] = $this->pms_model->get_evaluators($employee_id);


 
    	$this->load->view('employee_portal/header');
    	$this->load->view('employee_portal/pms/my_forms/view_form', $this->data);
    	$this->load->view('employee_portal/footer');
    }

}