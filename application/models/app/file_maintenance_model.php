<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class File_maintenance_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	public function count_current_comp(){		
		$query = $this->db->query("SELECT count(company_id) as total_c FROM company_info");
		return $query->row();
	}

	public function validateCompLicense(){		
		$query = $this->db->get('employee_license');
		return $query->row();
	}

// SUBSECTION 			==========================================================================================================

	public function sect_on_dept($department_id){
		$this->db->where(array(
			'department_id' 	=> $department_id,
			'wSubsection'		=> 1,
			'InActive'			=> 0
			));
		$query = $this->db->get('section');
		return $query->result();
	}

	public function validate_subsection($section_id){
		$this->db->where(array(
			'section_id'		=> $section_id,
			'subsection_name'	=> $this->input->post('subsection_name'),
			'InActive'			=> 0
			));
		$query = $this->db->get('subsection');
		if($query->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

	public function save_subsection(){
		$this->data = array(
			'subsection_name'	=> ucwords($this->input->post('subsection_name')),
			'section_id'		=> $this->input->post('section_add'),
			'InActive'			=> 0
			);
		$this->db->insert('subsection',$this->data);
	}

	public function fetch_subsection($section_id){
		$this->db->where(array(
			'section_id'	=> $section_id,
			'InActive'		=> 0
			));
		$query = $this->db->get('subsection');
		return $query->result();
	}

	public function get_subsection($subsection_id){
		$this->db->where(array(
			'a.subsection_id' => $subsection_id,
			'a.InActive'		=> 0
			));
		$this->db->join('section b', 'b.section_id = a.section_id', 'left');
		$this->db->join('department c', 'c.department_id = b.department_id', 'left');
		$this->db->join('company_info d', 'd.company_id = c.company_id', 'left');
		$query = $this->db->get('subsection a');
		return $query->row();
	}

	public function validate_edit_subsection($id){
		$this->db->where(array(
			'section_id !=' 	=> $id,
			'subsection_name'	=> $this->input->post('subsection_name'),
			'section_id'		=> $this->input->post('section_id'),
			'InActive'			=> 0
			));
		$query = $this->db->get('subsection');
		if ($query->num_rows() > 0){
			return true;
		}
		else {
			return false;
		}
	}

	public function modify_subsection($id){
		$this->data = array(
			'subsection_name' => ucwords($this->input->post('subsection_name')), 
			);
		$this->db->where('subsection_id', $id);
		$this->db->update('subsection', $this->data);
	}

// END SUBSECTION		==========================================================================================================

// DIVISION			=============================================================================

	public function fetch_division($company_id){
		$this->db->where(array(
			'company_id'	=> $company_id,
			'InActive'		=> 0
			));
		$query = $this->db->get('division');
		return $query->result();
	}

	public function validate_division(){
		$this->db->where(array(
			'company_id'		=>		$this->input->post('company'),
			'division_name'		=>		$this->input->post('division'),
			// 'location_id'		=>		$id,
			'InActive'			=>		0
		));
		$query = $this->db->get("division");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function save_division($data){
		$this->data = array(
			'company_id'		=> $data['company_id'],
			// 'location_id'		=> $data['location_id'],
			'division_name'		=> ucwords($this->input->post('division')),
			'InActive'			=> 0
		);	
		$this->db->insert('division',$this->data);
	}

	public function get_division($data){
		$this->db->where(array(
			'division_id'		=> $data['id'],
			'InActive'			=> 0
			));	
		$query = $this->db->get('division');
		return $query->row();
	}

	public function validate_edit_division($id, $division_name){
		$this->db->where(array(
			'division_id !='	=>		$id,
			'company_id'		=>		$this->input->post('company_id'),
			'division_name'		=>		$this->input->post('division'),
			// 'location_id'		=>		$location_id,
			'InActive'			=>		0
		));
		$query = $this->db->get("division");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function modify_division($id){
		$this->db->where(array(
			'division_id' => $id,
			'InActive'	  => 0
			));
		$this->data = array(
			'division_name'	=> $this->input->post('division')
			);
		$this->db->update('division', $this->data);
	}

	public function check_departments($data){
		$this->db->where(array(
			'division_id' 	=> $data['id'],
			'Inactive'		=> 0
			));
		$query = $this->db->get('department');
		if ($query->num_rows() > 0){
			return true;
		}
		else {
			return false;
		}
	}
	public function div_name($div_id){
		$this->db->where(array(
			'division_id'	=>	$div_id,
			'InActive'		=>	0
			));
		$query = $this->db->get('division');
		return $query->row();
	}

// END DIVISION		=============================================================================

// NEWS AND EVENTS =========================================================================


	public function validate_news_and_events($company_id){

		$this->db->where(array(
			'event_title'			=>		$this->input->post('event_title'),
			'company_id'			=>		$company_id,
			'Status'				=>		1
			));
		$query = $this->db->get("news_and_events");
		return $query->row();
		if($query->num_rows() > 0 ){
			return true;
		}
		else{
			return false;
		}
	}

	public function validate_edit_news_and_events($data){
		$this->db->where(array(
			'id !='					=>		$data['id'],
			'event_title'			=>		$this->input->post('event_title'),
			'company_id'			=>		$this->input->post('company_id'),
			'status'				=>		1
		));
		$query = $this->db->get("news_and_events");
		return $query->row();
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	public function get_news_and_events($data){
		$this->db->join('company_info b', 'b.company_id=a.company_id', 'left');	
		$this->db->where(array(
			'id'				=>	$data['id'],
			'status'	=>	1	
		));		
		$query = $this->db->get('news_and_events a');
		return $query->row();
	}

	public function generate_comp_event($data){

		$this->db->join('company_info b', 'b.company_id = a.company_id', 'left');
		$this->db->where(array(
				'a.company_id'	=> $data['company_id'],
				'status'		=>	1
			));
		$this->db->order_by('a.company_id');
		$query = $this->db->get('news_and_events a');
		return $query->result();
	}

	public function filter_news_and_events($data){

		$status = $data['status'];
		$company_id	=	$data['company'];

		if ($company_id == 0){
			if($status == 1){		
				$this->db->where(array(
					'status' => 1
					));
				}

			if($status == 2){
				$this->db->where(array(
					'event_end <'	=> date('Y-m-d H:i:s'),	
					'status' 		=> 1
				));
			}

			if($status == 3){
				$this->db->where(array(
					'event_end >'	=> date('Y-m-d H:i:s'),
					'event_start <'	=> date('Y-m-d H:i:s'),
					'status' 		=> 1
				));
			}

			if($status == 4){
				$this->db->where(array(
					'event_start >'	=> date('Y-m-d H:i:s'),
					'status' 		=> 1
				));
			}
		}

		else {
			if($status == 1){		
				$this->db->where(array(
					'a.company_id'	=>	$company_id,
					'status' => 1
					));
				}

			if($status == 2){
				$this->db->where(array(
					'a.company_id'	=> $company_id,
					'event_end <'	=> date('Y-m-d H:i:s'),	
					'status' 		=> 1
				));
			}

			if($status == 3){
				$this->db->where(array(
					'a.company_id'	=> $company_id,
					'event_end >'	=> date('Y-m-d H:i:s'),
					'event_start <'	=> date('Y-m-d H:i:s'),
					'status' 		=> 1
				));
			}

			if($status == 4){
				$this->db->where(array(
					'a.company_id'	=> $company_id,
					'event_start >'	=> date('Y-m-d H:i:s'),
					'status' 		=> 1
				));
			}
		}

		$this->db->select('*') ;
		$this->db->from('news_and_events a');
		$this->db->join('company_info b', 'b.company_id=a.company_id', 'left');
		$this->db->order_by('b.company_id', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function filtered_news_and_events($data){
		$company_id = $data['company_id'];
		$start 	= date("H:i:s", strtotime('00:00:00'));
		$end 	= date("H:i:s", strtotime('23:59:59'));	
		$start_date = $data['startDate']." ".$start;
		$end_date	= $data['endDate']." ".$end;

		if ($company_id == 0){
			$this->db->where(array(
					'event_start >='	=> $start_date,
					'event_end <='		=> $end_date,
					'status'			=> 1
				));
		}

		else if($company_id != 0){
			$this->db->where(array(
					'a.company_id'		=> $company_id,
					'event_start >='	=> $start_date,
					'event_end <='		=> $end_date,
					'status'			=> 1
				));
		}

		$this->db->select('*') ;
		$this->db->from('news_and_events a');
		$this->db->join('company_info b', 'b.company_id=a.company_id', 'left');
		$this->db->order_by('b.company_id', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function save_news_and_events($company_id){

		$event_start 	= 	$this->input->post('start_date')." ".$this->input->post('start_time');
		$event_end		=	$this->input->post('end_date')." ".$this->input->post('end_time');

		$this->data = array(
			'event_title'			=>	ucwords($this->input->post('event_title')),
			'event_description'		=>	ucfirst($this->input->post('event_description')),
			'event_start'			=>	$event_start,
			'event_end'				=>	$event_end,
			'status'				=> 	1,
			'company_id'			=>	$company_id
		);	
		$this->db->insert('news_and_events',$this->data);
	}

	public function modify_news_and_events($id){

		$event_start 	= 	$this->input->post('start_date')." ".$this->input->post('start_time');
		$event_end		=	$this->input->post('end_date')." ".$this->input->post('end_time');

		$this->data = array(
			'event_title'			=>	ucwords($this->input->post('event_title')),
			'event_description'		=>	ucfirst($this->input->post('event_description')),
			'event_start'			=>	$event_start,
			'event_end'				=>	$event_end,
			'status'				=> 	1,
			'company_id'			=>	$this->input->post('company_id')
		);	
		$this->db->where('id',$id);
		$this->db->update('news_and_events',$this->data);
	}
	
	public function news_and_events_list($comp_id){
		$this->db->where(array(
			'company_id'	=>	$comp_id,
			'InActive'		=>	0	
		));		
		$query = $this->db->get("news_and_events");
		return $query->result();
	}

	public function newsAndEventsList(){
		$this->db->select('*') ;
		$this->db->from('news_and_events a');
		$this->db->join('company_info b', 'b.company_id=a.company_id', 'left');
		$this->db->where(array(
				'event_end >'	=> date('Y-m-d H:i:s'),	
				'status' 		=> 1
			));
		$this->db->order_by('b.company_id', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

// END NEWS AND EVENTS =====================================================================

// FREQUENTLY ASKED QUESTIONS =========================================================================


	public function validate_faq($value){
		$this->db->where(array(
			'company_id'			=>		$value,
			'question'				=>		$this->input->post('question'),
			'InActive'				=>		0
		));
		$query = $this->db->get("frequently_asked_questions");
		return $query->row();
		if($query->num_rows() > 0 ){
			return true;
		}else{
			return false;
		}
	}

	public function validate_edit_faq($id){
		$this->db->where(array(
			'id !='					=>		$id,
			'company_id'			=>		$this->input->post('company_id'),
			'question'				=>		$this->input->post('question'),
			'InActive'				=>		0
		));
		$query = $this->db->get("frequently_asked_questions");
		return $query->row();
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	public function get_faq($id){	
		$this->db->where(array(
			'id'			=>	$id,
			'InActive'		=>	0	
		));		
		$query = $this->db->get("frequently_asked_questions");
		return $query->row();
	}

	public function get_comp_name($company_id){	
		$this->db->where(array(
			'company_id'	=>	$company_id,
			'InActive'		=>	0	
		));		
		$query = $this->db->get("company_info");
		return $query->row();
	}

	public function save_faq($data){
			$this->data = array(
			'company_id'		=>	$data['company_id'],
			'question'			=>	ucfirst($this->input->post('question')),
			'answer'			=>	$this->input->post('answer'),
			'InActive'			=> 	0
		);	
		$this->db->insert('frequently_asked_questions',$this->data);
	}

	public function modify_faq($id){
		$this->data = array(
			'question'		=> ucfirst($this->input->post('question')),
			'answer'		=> $this->input->post('answer'),
		);	
		$this->db->where('id',$id);
		$this->db->update('frequently_asked_questions',$this->data);
	}
	public function faq_list($comp_id){
		$this->db->where(array(
			'company_id'	=>	$comp_id,
			'InActive'		=>	0	
		));		
		$query = $this->db->get("frequently_asked_questions");
		return $query->result();
	}

// END FREQUENTLY ASKED QUESTIONS =====================================================================

// RESOURCES =========================================================================

	public function validate_resources(){
		$this->db->where(array(
			'resources'	=>		$this->input->post('resources'),
			'InActive'			=>		0
		));
		$query = $this->db->get("resources");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function save_resources(){
		$this->data = array(
			'resources'		=> $this->input->post('resources'),
			'InActive'			=> 0
		);	
		$this->db->insert('resources',$this->data);
	}
	public function get_resources($id){
		$this->db->where(array(
			'resources_id'	=>	$id,
			'InActive'			=>	0	
		));		
		$query = $this->db->get("resources");
		return $query->row();
	}
	public function modify_resources($id){
		$this->data = array(
			'resources'		=> $this->input->post('resources'),
			'InActive'			=> 0
		);	
		$this->db->where('resources_id',$id);
		$this->db->update('resources',$this->data);
	}
	public function validate_edit_resources($id){
		$this->db->where(array(
			'resources_id !=' 		=>		$id,
			'resources'				=>		$this->input->post('resources'),
			'InActive'				=>		0
		));
		$query = $this->db->get("resources");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

// END RESOURCES =====================================================================


	// Pay Type =========================================================================

	public function validate_paytype(){
		$this->db->where(array(
			'pay_type_name'	=>		$this->input->post('paytype'),
			'InActive'			=>		0
		));
		$query = $this->db->get("pay_type");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function save_paytype(){
		$this->data = array(
			'pay_type_name'		=> ucwords($this->input->post('paytype')),
			'InActive'			=> 0
		);	
		$this->db->insert('pay_type',$this->data);
	}
	public function get_pay_type($id){
		$this->db->where(array(
			'pay_type_id'	=>	$id,
			'InActive'			=>	0	
		));		
		$query = $this->db->get("pay_type");
		return $query->row();
	}
	public function validate_edit_paytype($id){
		$this->db->where(array(
			'pay_type_id !=' 		=>		$id,
			'pay_type_name'			=>		$this->input->post('paytype'),
			'InActive'				=>		0
		));
		$query = $this->db->get("pay_type");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function modify_paytype($id){
		$this->data = array(
			'pay_type_name'		=> ucwords($this->input->post('paytype')),
			'InActive'			=> 0
		);	
		$this->db->where('pay_type_id',$id);
		$this->db->update('pay_type',$this->data);
	}

	// LOCATION =========================================================================

	public function validate_location(){
		$this->db->where(array(
			'location_name'	=>		$this->input->post('location'),
			'InActive'			=>		0
		));
		$query = $this->db->get("location");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function validate_edit_location($id){
		$this->db->where(array(
			'location_id !=' 		=>		$id,
			'location_name'			=>		$this->input->post('location'),
			'InActive'				=>		0
		));
		$query = $this->db->get("location");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function get_location($id){
		$this->db->where(array(
			'location_id'	=>	$id,
			'InActive'			=>	0	
		));		
		$query = $this->db->get("location");
		return $query->row();
	}

	public function save_location(){
		$this->data = array(
			'location_name'		=> ucwords($this->input->post('location')),
			'description'		=> ucfirst($this->input->post('description')),
			'InActive'			=> 0
		);	
		$this->db->insert('location',$this->data);
	}

	public function modify_location($id){
		$this->data = array(
			'location_name'		=> ucwords($this->input->post('location')),
			'description'		=> ucfirst($this->input->post('description')),
			'InActive'			=> 0
		);	
		$this->db->where('location_id',$id);
		$this->db->update('location',$this->data);
	}

// END LOCATION =====================================================================

// TAXCODE =========================================================================

	public function validate_taxcode(){
		$this->db->where(array(
			'taxcode'	=>		$this->input->post('taxcode'),
			'InActive'			=>		0
		));
		$query = $this->db->get("taxcode");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function save_taxcode(){
		$this->data = array(
			'taxcode'		=> $this->input->post('taxcode'),
			'description'		=> $this->input->post('description'),
			'InActive'			=> 0
		);	
		$this->db->insert('taxcode',$this->data);
	}
	public function get_taxcode($id){
		$this->db->where(array(
			'taxcode_id'	=>	$id,
			'InActive'			=>	0	
		));		
		$query = $this->db->get("taxcode");
		return $query->row();
	}
	public function modify_taxcode($id){
		$this->data = array(
			'taxcode'		=> $this->input->post('taxcode'),
			'description'		=> $this->input->post('description'),
			'InActive'			=> 0
		);	
		$this->db->where('taxcode_id',$id);
		$this->db->update('taxcode',$this->data);
	}
	public function validate_edit_taxcode($id){
		$this->db->where(array(
			'taxcode_id !=' 		=>		$id,
			'taxcode'				=>		$this->input->post('taxcode'),
			'InActive'				=>		0
		));
		$query = $this->db->get("taxcode");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

// END TAXCODE =====================================================================

// POSITION =========================================================================

	public function validate_position(){
		$this->db->where(array(
			'position_name'	=>		$this->input->post('position'),
			'InActive'			=>		0
		));
		$query = $this->db->get("position");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function validate_edit_position($id){
		$this->db->where(array(
			'position_id !=' 		=>		$id,
			'position_name'			=>		$this->input->post('position'),
			'InActive'					=>		0
		));
		$query = $this->db->get("position");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function get_position($id){
		$this->db->where(array(
			'position_id'	=>	$id,
			'InActive'			=>	0	
		));		
		$query = $this->db->get("position");
		return $query->row();
	}

	public function save_position(){
		$this->data = array(
			'position_name'		=> ucwords($this->input->post('position')),
			'description'		=> ucfirst($this->input->post('description')),
			'InActive'			=> 0
		);	
		$this->db->insert('position',$this->data);
	}

	public function modify_position($id){
		$this->data = array(
			'position_name'		=> ucwords($this->input->post('position')),
			'description'		=> ucfirst($this->input->post('description')),
			'InActive'			=> 0
		);	
		$this->db->where('position_id',$id);
		$this->db->update('position',$this->data);
	}
// END POSITION =====================================================================

// Company =============================================================================================================	
	public function company(){

		$query=$this->db->query("select * from company_info where is_this_recruitment_employer='0' order by company_id asc ");
		return $query->result();

	}
	public function verify_company_emp($id){		
		$query=$this->db->query("select company_id from masterlist where company_id='".$id."' ");
		return $query->result();
	}	
	public function verify_company_loc($id){		
		$query=$this->db->query("select company_id from company_location where company_id='".$id."' ");
		return $query->result();
	}	
	public function verify_company_div($id){		
		$query=$this->db->query("select company_id from division where company_id='".$id."' ");
		return $query->result();
	}	
	public function verify_company_dept($id){		
		$query=$this->db->query("select company_id from department where company_id='".$id."' ");
		return $query->result();
	}	
	public function verify_company_class($id){		
		$query=$this->db->query("select company_id from classification where company_id='".$id."' ");
		return $query->result();
	}	
	public function verify_company_ppg($id){// ppg : payroll period group		
		$query=$this->db->query("select company_id from payroll_period_group where company_id='".$id."' ");
		return $query->result();
	}	
	public function verify_company_pp($id){// ppg : payroll period 		
		$query=$this->db->query("select company_id from payroll_period where company_id='".$id."' ");
		return $query->result();
	}	
	public function verify_position_emp($id){//		
		$query=$this->db->query("select position from masterlist where position='".$id."' ");
		return $query->result();
	}
	public function verify_taxcode_emp($id){//		
		$query=$this->db->query("select taxcode from masterlist where taxcode='".$id."' ");
		return $query->result();
	}
	public function verify_subsection_emp($id){//		
		$query=$this->db->query("select subsection from masterlist where subsection='".$id."' ");
		return $query->result();
	}	
	public function verify_bank_emp($id,$field_to_check){//		
		$query=$this->db->query("select bank,civil_status,section,employment,gender,location,pay_type from employee_info where $field_to_check='".$id."' ");
		return $query->result();
	}	
	public function verify_education_type_emp($id){//		
		$query=$this->db->query("select education_type_id from emp_education where education_type_id='".$id."' ");
		return $query->result();
	}	
	public function verify_education_type_app($id){//		
		$query=$this->db->query("select education_type_id from emp_education_applicant where education_type_id='".$id."' ");
		return $query->result();
	}	

	public function comp_w_subsection(){//		
		$query=$this->db->query("select a.wSubsection,a.section_id,a.section_name,b.department_id,b.dept_name,b.company_id from section a
inner join department b on(a.department_id=b.department_id)
where a.wSubsection='1' group by b.company_id");
		return $query->result();
	}	
	public function dept_w_subsection(){//
	
		$query=$this->db->query("select a.wSubsection,a.section_id,a.section_name,b.department_id,b.dept_name,b.company_id from section a
inner join department b on(a.department_id=b.department_id)
where a.wSubsection='1' group by b.department_id");
		return $query->result();
	}	
	public function div_w_subsection(){//
	
		$query=$this->db->query("select a.wSubsection,a.section_id,a.section_name,b.division_id,c.division_name,b.department_id,b.dept_name,b.company_id from section a inner join department b on(a.department_id=b.department_id)
inner join division c on(b.division_id=c.division_id)
where a.wSubsection='1' group by b.division_id");
		return $query->result();
	}	

	public function edit_company($id){
		$this->db->where(array(
			'company_id'		=>	$id,
			//'InActive'		=>	0	
		));		
		$query = $this->db->get("company_info");
		return $query->row();
	}
	public function validate_edit_company($id){
		$this->db->where(array(
			'company_id !='		=>		$id,
			'TIN'				=>		$this->input->post('tin'),
			'InActive'			=>		0
		));
		$query = $this->db->get("company_info");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function modify_company($id){
		$this->data = array(
			'company_name'				=> ucwords($this->input->post('company_name')),
			'company_contact_no'		=> $this->input->post('company_contact_no'),
			'company_address'			=> ucwords($this->input->post('company_address')),
			'TIN'						=> ucwords($this->input->post('tin')),
			'zip_code'					=>  $this->input->post('zip_code'),
			'area_code'					=>  $this->input->post('area_code'),
			'postal_code'				=>  $this->input->post('postal_code'),
			'pagibig_id_number'			=>  $this->input->post('pagibig_id_number'),
			'philhealth_number'				=> 	$this->input->post('philhealth_number'),
			'sss_number'				=>  $this->input->post('sss_number'),
			'main_tel_no'				=>  $this->input->post('main_tel_no'),	
			'logo_width'					=>  $this->input->post('logo_width'),
			'logo_height'					=>  $this->input->post('logo_height'),
			'wDivision'					=>  $this->input->post('division'),
			'company_code'					=>  $this->input->post('company_code'),
			'InActive'					=> 0
		);	
		$this->db->where('company_id',$id);
		$this->db->update('company_info',$this->data);
		
		$this->db->query("delete from company_location where company_id = ".$id);

		foreach ($this->input->post('location') as $key => $location) {
			
			$this->data = array(
					'company_id'		=> $id,
					'location_id'		=> $location
					);
			$this->db->insert('company_location',$this->data);
		}

	}


	public function save_company(){
		$this->data = array(
			'company_name'				=> ucwords($this->input->post('company_name')),
			'company_contact_no'		=> $this->input->post('company_contact_no'),
			'company_address'			=> ucwords($this->input->post('company_address')),
			'TIN'						=> $this->input->post('tin'),
			'zip_code'					=>  $this->input->post('zip_code'),
			'area_code'					=>  $this->input->post('area_code'),
			'postal_code'				=>  $this->input->post('postal_code'),
			'pagibig_id_number'			=>  $this->input->post('pagibig_id_number'),
			'sss_number'				=>  $this->input->post('sss_number'),
			'main_tel_no'				=>  $this->input->post('main_tel_no'),
			'wDivision'					=>  $this->input->post('division'),
			'is_this_recruitment_employer'					=>  0,
			'InActive'					=> 0
		);	
		$this->db->insert('company_info',$this->data);
	}

	public function validate_company(){
		$this->db->where(array(
			'company_name'	=>		$this->input->post('company_name'),
			'InActive'		=>		0
		));
		$query = $this->db->get("company_info");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function validate_tin(){
		$this->db->where(array(
			'TIN'			=>		$this->input->post('tin'),
			'InActive'		=>		0
		));
		$query = $this->db->get("company_info");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function get_company_location($company_id,$location_id){
		$this->db->where(array(
			'company_id'	=>	$company_id,
			'location_id'	=>	$location_id
			));
		$query = $this->db->get("company_location");
		return $query->row();
	}

	public function fetch_location($company_id){
		$this->db->where(array(
			'company_id' => $company_id
			));
		$this->db->join('location B','B.location_id=A.location_id','left');
		$query = $this->db->get('company_location A');
		return $query->result();
	}

	public function validate_comp_div($id){
		$this->db->where(array(
			'company_id'		=>		$id,
			// 'TIN'				=>		$this->input->post('tin'),
			'InActive'			=>		0
		));
		$query = $this->db->get("division");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
// ADVANCE TYPE =============================================================================================================	
	public function validate_advance_type(){
		$this->db->where(array(
			'advance_type'		=>		$this->input->post('advance_type'),
			'InActive'			=>		0
		));
		$query = $this->db->get("advance_type");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
public function validate_edit_advance_type($id){
		$this->db->where(array(
			'id !='				=>		$id,
			'advance_type'		=>		$this->input->post('advance_type'),
			'InActive'			=>		0
		));
		$query = $this->db->get("advance_type");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function advance_type(){
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->order_by('id','asc');
		$query = $this->db->get("advance_type");
		return $query->result();
	}

	public function edit_advance_type($id){
		$this->db->where(array(
			'id'		=>	$id,
			'InActive'	=>	0	
		));		
		$query = $this->db->get("advance_type");
		return $query->row();
	}

	public function save_advance_type(){
		$this->data = array(
			'advance_type'		=> ucwords($this->input->post('advance_type')),
			'description'		=> ucfirst($this->input->post('adv_description')),
			'InActive'			=> 0
		);	
		$this->db->insert('advance_type',$this->data);
	}

	public function modify_advance_type($id){
		$this->data = array(
			'advance_type'		=> ucwords($this->input->post('advance_type')),
			'description'		=> ucfirst($this->input->post('adv_description')),
			'InActive'			=> 0
		);	
		$this->db->where('id',$id);
		$this->db->update('advance_type',$this->data);
	}
// END ADVANCE TYPE =================================================================================================
// DEPARTMENT =======================================================================================================

	public function company_list_arranged(){
		$this->db->where(array(
			'InActive' 		=>		0
		));	
		$this->db->order_by('wDivision,company_name', 'asc');
		$query = $this->db->get('company_info');
		return $query->result();
	}

	public function validate_dept_code($company){
		$this->db->where(array(
			'company_id'	=>		$company,
			'dept_code'		=>		$this->input->post('dept_code'),
			'InActive'		=>		0
		));
		$query = $this->db->get("department");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function validate_dept_name($company){
		$this->db->where(array(
			'company_id'	=>		$company,
			'dept_name'		=>		$this->input->post('dept_name'),
			'InActive'		=>		0
		));
		$query = $this->db->get("department");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function validate_dept_code2($division){
		$this->db->where(array(
			'company_id'	=>		$this->input->post('dept_company'),
			'dept_code'		=>		$this->input->post('dept_code'),
			'division_id'	=>		$division,
			'InActive'		=>		0
		));
		$query = $this->db->get("department");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function validate_dept_name2($division){
		$this->db->where(array(
			'company_id'	=>		$this->input->post('dept_company'),
			'dept_name'		=>		$this->input->post('dept_name'),
			'division_id'	=>		$division,
			'InActive'		=>		0
		));
		$query = $this->db->get("department");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function validate_edit_dept_code($id){
		$this->db->where(array(
			'company_id'		=>		$this->input->post('company_id'),
			'department_id !=' 	=>		$id,
			'dept_code'			=>		$this->input->post('dept_code'),
			'division_id'		=>		$this->input->post('mod_division'),
			'InActive'			=>		0
		));
		$query = $this->db->get("department");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function validate_edit_dept_name($id){
		$this->db->where(array(
			'department_id !=' 	=>		$id,
			'dept_name'			=>		$this->input->post('dept_name'),
			'division_id'		=>		$this->input->post('mod_division'),
			'InActive'			=>		0
		));
		$query = $this->db->get("department");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function get_department($id){
		$this->db->where(array(
			'department_id'		=>	$id,
			// 'InActive'	=>	0	
		));		
		$query = $this->db->get("department");
		return $query->row();
	}

	public function fetch_departments($company_id){
		$this->db->where(array(
			'company_id' => $company_id,
			// 'Inactive'	=> 0
			));
		$this->db->order_by('department_id', 'asc');
		$query = $this->db->get("department");
		return $query->result();
	}

	public function fetch_dept($company_id,$division_id){
		$this->db->where(array(
			'company_id' 	=> $company_id,
			'division_id'	=> $division_id,
			// 'Inactive'		=> 0
			));
		$this->db->order_by('department_id', 'asc');
		$query = $this->db->get("department");
		return $query->result();
	}

	public function save_department($data){
		$this->data = array(
			'company_id'		=> $data['company_id'],
			'division_id'		=> $data['division_id'],
			'dept_code'			=> $this->input->post('dept_code'),
			'dept_name'			=> ucwords($this->input->post('dept_name')),
			'InActive'			=> 0
		);	
		$this->db->insert('department',$this->data);
	}

	// public function save_department2($data){
	// 	$this->data = array(
	// 		'company_id'		=> 2,
	// 		'division_id'		=> 1,
	// 		'dept_code'			=> 'kamote',
	// 		'dept_name'			=> ucwords($this->input->post('dept_name')),
	// 		'InActive'			=> 0
	// 	);	
	// 	$this->db->insert('department',$this->data);
	// }

	public function modify_department($id){
		$this->data = array(
			'dept_code'		=> $this->input->post('dept_code'),
			'dept_name'		=> ucwords($this->input->post('dept_name')),
			'division_id'	=> $this->input->post('mod_division'),
			'InActive'		=> 0
		);	
		$this->db->where('department_id',$id);
		$this->db->update('department',$this->data);
	}

	public function check_employees($id){
		$this->db->where(array(
			'department'	=> $id,
			'InActive'		=> 0,
		));
		$query = $this->db->get('employee_info');
		return $query->num_rows();
	}
	public function check_employees_div($data){
		$this->db->where(array(
			'division_id'	=> $data['id'],
			'InActive'		=> 0,
		));
		$query = $this->db->get('employee_info');
		if ($query->num_rows() > 0 ) {
			return true;
		}
		else {
			return false;
		}
	}
	public function get_comp_wo_div(){
		$this->db->where(array(
			'wDivision' 	=> 0,
			'InActive'		=> 0,
			));
		$query = $this->db->get('company_info');
		return $query->result();

	}
	public function get_comp_w_div(){
		$this->db->where(array(
			'wDivision' 	=> 1,
			'InActive'		=> 0,
			));
		$query = $this->db->get('company_info');
		return $query->result();

	}
	public function chck_comp_if_div($company_id){
		$this->db->select('company_id');
		$this->db->where(array(
			'company_id'	=>	$company_id,
			'wDivision'		=> 	1,
			'Inactive'		=>	0
			));
		$query = $this->db->get('company_info');
		if ($query->num_rows() > 0 ){
			return true;
		}
		else{
			return false;
		}
	}
	public function chck_comp_if_div_exists($company_id){
		$this->db->select('company_id');
		$this->db->where(array(
			'company_id'	=>	$company_id,
			'Inactive'		=>	0
			));
		$query = $this->db->get('division');
		if ($query->num_rows() > 0 ){
			return true;
		}
		else{
			return false;
		}
	}
	public function div_on_loc($company_id,$location_id){
		// $this->db->select('company_id');
		$this->db->where(array(
			'company_id'	=>	$company_id,
			'location_id'	=>	$location_id,
			'Inactive'		=>	0
			));
		$query = $this->db->get('division');
		return $query->result();
	}

// END DEPARTMENT ======================================================================
// SECTION =============================================================================

	public function section($id){
		$this->db->select("
			A.section_id,
			A.section_name,
			A.department_id,
			B.dept_name
			");
		$this->db->where(array(
			'A.department_id'		=>	$id,
			'A.InActive'			=>	0
			));
		$this->db->join("department B","B.department_id = A.department_id","left outer");
		$query = $this->db->get('section A');

		return $query->result();
	}

	public function validate_section($id){
		$this->db->where(array(
			'section_name'			=>		$this->input->post('section_name'),
			'department_id'			=>		$id,
			'InActive'				=>		0
		));
		$query = $this->db->get("section");
		return $query->row();
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function validate_edit_section($id){
		$this->db->where(array(
			'section_id !='			=>		$id,
			'section_name'			=>		$this->input->post('section_name'),
			'department_id'			=>		$this->input->post('department_id'),
			'InActive'				=>		0
		));
		$query = $this->db->get("section");
		return $query->row();
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function check_edit_subsection($id){
		$this->db->where(array(
			'section_id'			=>		$id,
			'InActive'				=>		0
		));
		$query = $this->db->get("subsection");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function get_section($id){
		$this->db->select("A.section_id,A.section_name,A.department_id,B.dept_name,C.company_name,A.wSubsection");
		$this->db->where(array(
			'A.section_id'	=>	$id,
			'A.InActive'		=>	0	
		));
		$this->db->join("department B","B.department_id = A.department_id","left outer");
		$this->db->join("company_info C", "C.company_id = B.company_id", "left outer");		
		$query = $this->db->get("section A");
		return $query->row();
	}

	public function save_section(){
		$this->data = array(
			'department_id'		=>	$this->input->post('department_add'),
			'section_name'		=> 	ucwords($this->input->post('section_name')),
			'wSubsection'		=>	$this->input->post('subsection'),
			'InActive'			=> 	0
		);	
		$this->db->insert('section',$this->data);
	}

	public function modify_section($id){
		$this->data = array(
			'section_name'	=> ucwords($this->input->post('section_name')),
			'wSubsection'	=> $this->input->post('subsection')
		);	
		$this->db->where('section_id',$id);
		$this->db->update('section',$this->data);
	}
	public function section_list($dept_id){
		$this->db->where(array(
			'department_id'	=>	$dept_id,
			'InActive'		=>	0	
		));		
		$query = $this->db->get("section");
		return $query->result();
	}
	public function department_list($company_id){
		$this->db->where(array(
			'company_id'	=> $company_id,
			'InActive'		=> 0
		));
		$query = $this->db->get('department');
		return $query->result();
	}
	public function get_division_for_dept($company_id,$location_id){
		$this->db->where(array(
			'company_id'	=> $company_id,
			'location_id'	=> $location_id,
			'InActive'		=> 0
			));
		$query = $this->db->get('division');
		return $query->row();
	}
	public function dept_on_div($division_id){
		$this->db->where(array(
			'division_id' 	=> $division_id,
			'InActive'		=> 0
			));
		$query = $this->db->get('department');
		return $query->result();
	}
// END SECTION =========================================================================

// BANK ================================================================================

	public function validate_bank(){
		$this->db->where(array(
			'bank_code'		=>		$this->input->post('bank_code'),
			'bank_name'		=>		$this->input->post('bank_name'),
			'account_no'	=>		$this->input->post('account_no'),
			'InActive'		=>		0
		));
		$query = $this->db->get("bank");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function validate_edit_bank($id){
		$this->db->where(array(
			'bank_id !=' 		=>		$id,
			'bank_code'			=>		$this->input->post('bank_code'),
			'bank_name'			=>		$this->input->post('bank_name'),
			'account_no'		=>		$this->input->post('account_no'),
			'InActive'			=>		0
		));
		$query = $this->db->get("bank");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function get_bank($id){
		// $this->db->where(array(
		// 	'bank_id'		=>	$id,
		// 	'InActive'		=>	0	
		// ));		


		$query = $this->db->query("SELECT a.*,b.id as bankdat_id,b.bank_name as bankdat_name,b.bank_file_version FROM bank a LEFT JOIN bank_file b on(a.bank_id=b.bank_table_bank_id) WHERE a.bank_id='".$id."' AND a.Inactive='0' ");
		
		//$query = $this->db->get("bank");
		return $query->row();
	}

	public function save_bank(){
		$this->data = array(
			'bank_code'			=> $this->input->post('bank_code'),
			'bank_name'			=> ucwords($this->input->post('bank_name')),
			'account_no'		=> $this->input->post('account_no'),
			'bank_company_code'		=> $this->input->post('bank_company_code'),
			'bank_batch_number'		=> $this->input->post('bank_batch_number'),
			'InActive'			=> 0
		);	
		$this->db->insert('bank',$this->data);
	}

	public function modify_bank($id){
		$this->data = array(
			'bank_code'			=> $this->input->post('bank_code'),
			'bank_name'			=> ucwords($this->input->post('bank_name')),
			'account_no'		=> $this->input->post('account_no'),
			'bank_company_code'		=> $this->input->post('bank_company_code'),
			'bank_batch_number'		=> $this->input->post('bank_batch_number'),
			'InActive'			=> 0
		);	
		$this->db->where('bank_id',$id);
		$this->db->update('bank',$this->data);
	}
	public function modify_bank_dat($id){
		$bankfile=$this->input->post('bankfile');
		$this->data = array(
			'bank_table_bank_id'			=> $id
		);	
		$this->db->where('id',$bankfile);
		$this->db->update('bank_file',$this->data);
	}
// END BANK ===========================================================================
// CIVIL STATUS =======================================================================

	public function validate_civil_status(){
		$this->db->where(array(
			'civil_status'		=>		$this->input->post('civil_status'),
			'InActive'			=>		0
		));
		$query = $this->db->get("civil_status");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function validate_edit_civil_status($id){
		$this->db->where(array(
			'civil_status_id !=' 	=>		$id,
			'civil_status'			=>		$this->input->post('civil_status'),
			'InActive'				=>		0
		));
		$query = $this->db->get("civil_status");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function get_civil_status($id){
		$this->db->where(array(
			'civil_status_id'	=>	$id,
			'InActive'			=>	0	
		));		
		$query = $this->db->get("civil_status");
		return $query->row();
	}

	public function save_civil_status(){
		$this->data = array(
			'civil_status'		=> ucwords($this->input->post('civil_status')),
			'InActive'			=> 0
		);	
		$this->db->insert('civil_status',$this->data);
	}

	public function modify_civil_status($id){
		$this->data = array(
			'civil_status'		=> ucwords($this->input->post('civil_status')),
			'InActive'			=> 0
		);	
		$this->db->where('civil_status_id',$id);
		$this->db->update('civil_status',$this->data);
	}
// END CIVIL STATUS =======================================================================
// CLASSIFICATION =========================================================================

	public function validate_classification($id){
		$this->db->where(array(
			'company_id'		=>		$id,
			'classification'	=>		$this->input->post('classification'),
			'InActive'			=>		0
		));
		$query = $this->db->get("classification");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function validate_edit_classification($id){
		$this->db->where(array(
			'classification_id !=' 		=>		$id,
			'company_id'				=>		$this->input->post('company_id'),
			'classification'			=>		$this->input->post('classification'),
			'InActive'					=>		0
		));
		$query = $this->db->get("classification");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function get_classification($id){
		$this->db->where(array(
			'classification_id'	=>	$id,
			'InActive'			=>	0	
		));		
		$query = $this->db->get("classification");
		return $query->row();
	}

	public function save_classification($data){
		$this->data = array(
			'company_id'		=> $data['company_id'],
			'ranking'			=> $this->input->post('ranking'),
			'classification'	=> ucwords($this->input->post('classification')),
			'description'		=> ucfirst($this->input->post('description')),
			'InActive'			=> 0
		);	
		$this->db->insert('classification',$this->data);
	}

	public function modify_classification($id){
		$this->data = array(
			'classification'	=> ucwords($this->input->post('classification')),
			'description'		=> ucfirst($this->input->post('description')),
			'ranking'			=> $this->input->post('ranking'),
			'InActive'			=> 0
		);	
		$this->db->where('classification_id',$id);
		$this->db->update('classification',$this->data);
	}

	public function fetch_classification($company_id){
		$this->db->where(array(
				'company_id'	=> $company_id,
				'InActive'		=> 0
			));
		//$this->db->order_by('ranking');
		$this->db->order_by('ranking', 'asc');
		$query = $this->db->get('classification');
		return $query->result();

	}

	public function check_employees_classification($id){
		$this->db->where(array(
			'classification'	=>	$id,
			'Inactive'			=>	0
		));
		$query = $this->db->get('employee_info');
		return $query->num_rows();
	}
// END CLASSIFICATION =====================================================================
// EDUCATION ==============================================================================

	public function validate_education(){
		$this->db->where(array(
			'education_name'	=>		$this->input->post('education_name'),
			'InActive'			=>		0
		));
		$query = $this->db->get("education");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function validate_edit_education($id){
		$this->db->where(array(
			'education_id !=' 			=>		$id,
			'education_name'			=>		$this->input->post('education_name'),
			'InActive'					=>		0
		));
		$query = $this->db->get("education");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function get_education($id){
		$this->db->where(array(
			'education_id'		=>	$id,
			'InActive'			=>	0	
		));		
		$query = $this->db->get("education");
		return $query->row();
	}

	public function save_education(){
		$this->data = array(
			'education_name'	=> ucwords($this->input->post('education_name')),
			'InActive'			=> 0
		);	
		$this->db->insert('education',$this->data);
	}

	public function modify_education($id){
		$this->data = array(
			'education_name'	=> ucwords($this->input->post('education_name')),
			'InActive'			=> 0
		);	
		$this->db->where('education_id',$id);
		$this->db->update('education',$this->data);
	}
// END EDUCATION ==========================================================================
// EMPLOYMENT ==============================================================================

	public function validate_employment(){
		$this->db->where(array(
			'employment_name'	=>		$this->input->post('employment_name'),
			'InActive'			=>		0
		));
		$query = $this->db->get("employment");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function validate_edit_employment($id){
		$this->db->where(array(
			'employment_id !=' 			=>		$id,
			'employment_name'			=>		$this->input->post('employment_name'),
			'InActive'					=>		0
		));
		$query = $this->db->get("employment");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function get_employment($id){
		$this->db->where(array(
			'employment_id'		=>	$id,
			'InActive'			=>	0	
		));		
		$query = $this->db->get("employment");
		return $query->row();
	}

	public function save_employment(){
		$this->data = array(
			'employment_name'	=> ucwords($this->input->post('employment_name')),
			'InActive'			=> 0
		);	
		$this->db->insert('employment',$this->data);
	}

	public function modify_employment($id){
		$this->data = array(
			'employment_name'	=> ucwords($this->input->post('employment_name')),
			'InActive'			=> 0
		);	
		$this->db->where('employment_id',$id);
		$this->db->update('employment',$this->data);
	}
// END EMPLOYMENT ==========================================================================
// GENDER ==================================================================================

	public function validate_gender(){
		$this->db->where(array(
			'gender_name'		=>		$this->input->post('gender_name'),
			'InActive'			=>		0
		));
		$query = $this->db->get("gender");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function validate_edit_gender($id){
		$this->db->where(array(
			'gender_id !=' 			=>		$id,
			'gender_name'			=>		$this->input->post('gender_name'),
			'InActive'				=>		0
		));
		$query = $this->db->get("gender");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function get_gender($id){
		$this->db->where(array(
			'gender_id'			=>	$id,
			'InActive'			=>	0	
		));		
		$query = $this->db->get("gender");
		return $query->row();
	}

	public function save_gender(){
		$this->data = array(
			'gender_name'		=> ucwords($this->input->post('gender_name')),
			'InActive'			=> 0
		);	
		$this->db->insert('gender',$this->data);
	}

	public function modify_gender($id){
		$this->data = array(
			'gender_name'		=> ucwords($this->input->post('gender_name')),
			'InActive'			=> 0
		);	
		$this->db->where('gender_id',$id);
		$this->db->update('gender',$this->data);
	}
// END GENDER ==============================================================================
//ANNOUNCEMENT ======================================================================
	public function check_div_data($company_id)
	{
		$company = substr_replace($company_id, "", -1);
		$var = explode("-", $company);
		$this->db->select('*');
		$this->db->from('company_info');
		$this->db->where(array(
			'wDivision'	=>	1	
		));
		foreach ($var as $row) 
		{
			$this->db->or_where('company_id', $row);
		}
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			//return $query->result();
			return true;
		}
		else
		{
			return false;
		}
	}

	//populate department checkbox
	public function deptList($company_id)
	{
		$company = substr_replace($company_id, "", -1);
		$var = explode("-", $company);
		$this->db->select('department_id, dept_code, dept_name');
		$this->db->from('department');
		foreach ($var as $row) 
		{
			$this->db->or_where('company_id', $row);
		}
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
			//return true;
		}
		else
		{
			return false;
		}
	}

	public function check_department_value($company_id)
	{
		$company = substr_replace($company_id, "", -1);
		$var = explode("-", $company);
		$this->db->select('department_id,dept_code,dept_name');
		$this->db->from('department');
		foreach ($var as $row) 
		{
			$this->db->or_where('company_id', $row);
		}
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			//return $query->result();
			return true;
		}
		else
		{
			return false;
		}
	}

	public function check_division_value($company_id)
	{
		$company = substr_replace($company_id, "", -1);
		$var = explode("-", $company);
		$this->db->select('division_id, division_name');
		$this->db->from('division');
		/*$this->db->where();*/
		foreach ($var as $row) 
		{
			$this->db->or_where('company_id', $row);
		}
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			//return $query->result();
			return true;
		}
		else
		{
			return false;
		}
	}

	//populate division checkbox
	public function divisionList($company_id)
	{
		$company = substr_replace($company_id, "", -1);
		$var = explode("-", $company);
		$this->db->select('division_id, division_name');
		$this->db->from('division');
		/*$this->db->where();*/
		foreach ($var as $row) 
		{
			$this->db->or_where('company_id', $row);
		}
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
			//return true;
		}
		else
		{
			return false;
		}
	}

	//populate department checkbox
	public function departmentList($division_id)
	{
			$division = substr_replace($division_id, "", -1);
			$div = explode("-",$division);
			$this->db->select('department_id,dept_name,dept_code');
			$this->db->from('department');
			//$this->db->where('department.company_id',$company_id);
			foreach ($div as $divis) { 
				$this->db->or_where('division_id',$divis);
			}
			$query = $this->db->get();
			return $query->result();
	}

	//populate section checkbox
	public function sectionList($department_id)
	{
		$department = substr_replace($department_id, "", -1);
		$var = explode("-", $department);
		$this->db->select('section_id, section_name');
		$this->db->from('section');
		/*$this->db->where();*/
		foreach ($var as $row) 
		{
			$this->db->or_where('department_id', $row);
		}
		$query = $this->db->get();
		return $query->result();
	}

	//populate subsection checkbox
	public function subSectionList($section_id)
	{
		$section = substr_replace($section_id, "", -1);
		$var = explode("-", $section);
		$this->db->select('subsection_id, subsection_name');
		$this->db->from('subsection');
		/*$this->db->where();*/
		foreach ($var as $row) 
		{
			$this->db->or_where('section_id', $row);
		}
		$query = $this->db->get();
		return $query->result();
	}

	//get announcement by current date
	public function announcement($company_id)
	{
		$name = 'company';
		$this->db->select('an.announcement_id, an.announcement_title, an.announcement_details, an.date_from, an.date_to, an.file_name,
			 com.company_id, com.company_name');
		$this->db->from('announcement_fields af');
		$this->db->join('company_info com', 'af.id = com.company_id', 'left');
		$this->db->join('announcement an', 'af.announcement_id = an.announcement_id', 'left');
		$this->db->where('af.table_name', $name);
		$this->db->where('af.id', $company_id);
		$this->db->where('an.date_from <= CURDATE()');
		$this->db->where('an.date_to >= CURDATE()');
		$query = $this->db->get();

		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	//get company details by id
	public function getCompany($company_id)
	{
		$this->db->where('company_id', $company_id);
		$query = $this->db->get('company_info');
		if ($query->num_rows() > 0) 
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}

	//get announcement by date from and date to
	public function view_filter_date($company_id,$date_from,$date_to)
	{
		$name = 'company';
		$this->db->select('an.announcement_id, an.announcement_title, an.announcement_details, an.date_from, an.date_to, an.file_name,
			 com.company_id, com.company_name');
		$this->db->from('announcement_fields af');
		$this->db->join('company_info com', 'af.id = com.company_id', 'left');
		$this->db->join('announcement an', 'af.announcement_id = an.announcement_id', 'left');
		$this->db->where('af.table_name', $name);
		$this->db->where('af.id', $company_id);
		$this->db->where('an.date_from <=', $date_from);
		$this->db->where('an.date_to >=', $date_to);
		$query = $this->db->get();

		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	//filter announcement
	public function view_filter_announcement($company,$division,$department,$section,$subsection)
	{
		$this->db->select('an.announcement_id, af.table_name, an.announcement_title, an.announcement_details, an.date_from, an.date_to, an.file_name,
			 com.company_id, com.company_name, di.division_id, di.division_name, dep.department_id, dep.dept_name,
			 sec.section_id, sec.section_name, sub.subsection_id, sub.subsection_name');
		$this->db->from('announcement_fields af');
		$this->db->join('announcement an', 'af.announcement_id = an.announcement_id', 'left');
		$this->db->join('company_info com', 'af.id = com.company_id', 'left');
		$this->db->join('department dep', 'af.id = dep.department_id', 'left');
		$this->db->join('section sec', 'af.id = sec.section_id', 'left');
		$this->db->join('subsection sub', 'af.id = sub.subsection_id', 'left');
		$this->db->join('division di', 'af.id = di.division_id', 'left');
		if($company == 'All')
		{
			$this->db->where('af.table_name', 'company');
		}
		else
		{
			$this->db->where('af.table_name', 'company');
			$this->db->where('af.id', $company);
		}
		if($division == 'All')
		{
			$this->db->or_where('af.table_name', 'division');
		}
		elseif ($division == 0) 
		{}
		else
		{
			$this->db->or_where('af.table_name', 'division');
			$this->db->where('af.id', $division);
		}
		if ($department == 'All')
		{
			$this->db->or_where('af.table_name', 'department');
		}
		elseif ($department == 0) 
		{}
		else
		{
			$this->db->or_where('af.table_name', 'department');
			$this->db->where('af.id', $department);
		}
		if ($section == 'All')
		{
			$this->db->or_where('af.table_name', 'section');
		}
		elseif ($section == 0) 
		{}
		else
		{
			$this->db->or_where('af.table_name', 'section');
			$this->db->where('af.id', $section);
		}
		if ($subsection == 'All')
		{
			$this->db->or_where('af.table_name', 'subsection');
		}
		elseif ($subsection == 0) 
		{}
		else
		{
			$this->db->or_where('af.table_name', 'subsection');
			$this->db->where('af.id', $subsection);
		}
		$query = $this->db->get();

		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	//save announcement
	public function save_announcement($title,$date_from,$date_to,$details,$file_name,$company,$section,$division,$subsection,$department)
	{
		$data = array(
			'announcement_title' => $title,
			'announcement_details' => $details,
			'date_from' => $date_from,
			'date_to' => $date_to,
			'date_created' => date('Y-m-d H:i:s'),
			'file_name' => $file_name
		);

			$this->db->insert('announcement', $data);
			if($this->db->affected_rows() > 0)
			{
				$this->db->select('announcement_id');
				$this->db->from('announcement');
				$this->db->where(array(
					'announcement_title' => $title,
					'announcement_details' => $details,
					'date_from' => $date_from,
					'date_to' => $date_to,
					'file_name' => $file_name
				));
				$query = $this->db->get();
				$id =  $query->row("announcement_id");
				foreach ($company as $value) 
				{
					$table_name = 'company';
					$company_values = array(
						'announcement_id' => $id,
						'table_name' => $table_name,
						'id' => $value
					);
					$this->db->insert('announcement_fields', $company_values);
				}
				if ($division == 0) 
				{
					$table_name = 'division';
					$division_values = array(
						'announcement_id' => $id,
						'table_name' => $table_name,
						'id' => $division
					);
					$this->db->insert('announcement_fields', $division_values);
				}
				else
				{
					foreach ($division as $value) 
					{
						$table_name = 'division';
						$division_values = array(
							'announcement_id' => $id,
							'table_name' => $table_name,
							'id' => $value
						);
						$this->db->insert('announcement_fields', $division_values);
					}
				}
				if ($department == 0) 
				{
					$table_name = 'department';
					$department_values = array(
						'announcement_id' => $id,
						'table_name' => $table_name,
						'id' => $department
					);
					$this->db->insert('announcement_fields', $department_values);
				}
				else
				{
					foreach ($department as $value) 
					{
						$table_name = 'department';
						$department_values = array(
							'announcement_id' => $id,
							'table_name' => $table_name,
							'id' => $value
						);
						$this->db->insert('announcement_fields', $department_values);
					}
				}
				if ($section == 0) 
				{
					$table_name = 'section';
					$section_values = array(
						'announcement_id' => $id,
						'table_name' => $table_name,
						'id' => $section
					);
					$this->db->insert('announcement_fields', $section_values);
				}
				else
				{
					foreach ($section as $value) 
					{
						$table_name = 'section';
						$section_values = array(
							'announcement_id' => $id,
							'table_name' => $table_name,
							'id' => $value
						);
						$this->db->insert('announcement_fields', $section_values);
					}
				}
				if ($subsection == 0) 
				{
					$table_name = 'subsection';
					$subsection_values = array(
						'announcement_id' => $id,
						'table_name' => $table_name,
						'id' => $subsection
					);
					$this->db->insert('announcement_fields', $subsection_values);
				}
				else
				{
					foreach ($subsection as $value) 
					{
						$table_name = 'subsection';
						$subsection_values = array(
							'announcement_id' => $id,
							'table_name' => $table_name,
							'id' => $value
						);
						$this->db->insert('announcement_fields', $subsection_values);
					}
				}
				return true;
			}
			else
			{
				return false;
			}
	}

	//get announcement details in announcement table
	public function edit_announcement($id)
	{
		$this->db->where('announcement_id', $id);
		$result = $this->db->get('announcement');
		if ($result->num_rows() > 0) 
		{
			return $result->row();
		}
		else
		{
			return false;
		}
	}

	//get announcement details in announcement_fields table
	public function get_announcement($id)
	{
		$this->db->select('af.table_name, af.id,
			 di.division_id, di.division_name, dep.department_id, dep.dept_name,
			 sec.section_id, sec.section_name, sub.subsection_id, sub.subsection_name');
		$this->db->from('announcement_fields af');
		$this->db->join('department dep', 'af.id = dep.department_id', 'left');
		$this->db->join('section sec', 'af.id = sec.section_id', 'left');
		$this->db->join('subsection sub', 'af.id = sub.subsection_id', 'left');
		$this->db->join('division di', 'af.id = di.division_id', 'left');
		$this->db->where('af.announcement_id', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	//update announcement
	public function update_announcement($announcement_id,$edit_title,$edit_date_from,$edit_date_to,$edit_details,$edit_company,$edit_section,$edit_division,$edit_subsection,$edit_department)
	{
		$data = array(
			'announcement_title' => $edit_title,
			'announcement_details' => $edit_details,
			'date_from' => $edit_date_from,
			'date_to' => $edit_date_to,
			'date_created' => date('Y-m-d H:i:s')
		);

			$this->db->where('announcement_id', $announcement_id);
			$this->db->update('announcement', $data);
			if($this->db->affected_rows() > 0)
			{
				$this->db->where('announcement_id', $announcement_id);
				$this->db->delete('announcement_fields');

				foreach ($edit_company as $value) 
				{
					$table_name = 'company';
					$company_values = array(
						'announcement_id' => $announcement_id,
						'table_name' => $table_name,
						'id' => $value
					);
					$this->db->insert('announcement_fields', $company_values);
				}
				if ($edit_division == 0) 
				{
					$table_name = 'division';
					$division_values = array(
						'announcement_id' => $announcement_id,
						'table_name' => $table_name,
						'id' => $edit_division
					);
					$this->db->insert('announcement_fields', $division_values);
				}
				else
				{
					foreach ($edit_division as $value) 
					{
						$table_name = 'division';
						$division_values = array(
							'announcement_id' => $announcement_id,
							'table_name' => $table_name,
							'id' => $value
						);
						$this->db->insert('announcement_fields', $division_values);
					}
				}
				if ($edit_department == 0) 
				{
					$table_name = 'department';
					$department_values = array(
						'announcement_id' => $announcement_id,
						'table_name' => $table_name,
						'id' => $edit_department
					);
					$this->db->insert('announcement_fields', $department_values);
				}
				else
				{
					foreach ($edit_department as $value) 
					{
						$table_name = 'department';
						$department_values = array(
							'announcement_id' => $announcement_id,
							'table_name' => $table_name,
							'id' => $value
						);
						$this->db->insert('announcement_fields', $department_values);
					}
				}
				if ($edit_section == 0) 
				{
					$table_name = 'section';
					$section_values = array(
						'announcement_id' => $announcement_id,
						'table_name' => $table_name,
						'id' => $edit_section
					);
					$this->db->insert('announcement_fields', $section_values);
				}
				else
				{
					foreach ($edit_section as $value) 
					{
						$table_name = 'section';
						$section_values = array(
							'announcement_id' => $announcement_id,
							'table_name' => $table_name,
							'id' => $value
						);
						$this->db->insert('announcement_fields', $section_values);
					}
				}
				if ($edit_subsection == 0) 
				{
					$table_name = 'subsection';
					$subsection_values = array(
						'announcement_id' => $announcement_id,
						'table_name' => $table_name,
						'id' => $edit_subsection
					);
					$this->db->insert('announcement_fields', $subsection_values);
				}
				else
				{
					foreach ($edit_subsection as $value) 
					{
						$table_name = 'subsection';
						$subsection_values = array(
							'announcement_id' => $announcement_id,
							'table_name' => $table_name,
							'id' => $value
						);
						$this->db->insert('announcement_fields', $subsection_values);
					}
				}
				return true;
			}
			else
			{
				return false;
			}
	}

	//delete announcement
	public function delete_announcement($announcement_id,$company_id)
	{
		$this->db->where('announcement_id', $announcement_id);
		$this->db->where('table_name', 'Company');
		$query = $this->db->get('announcement_fields');
		if ($query->num_rows() == 1) 
		{
			$this->db->where('announcement_id', $announcement_id);
			$this->db->delete('announcement');
			if($this->db->affected_rows() > 0)
			{
				$this->db->where('announcement_id', $announcement_id);
				$this->db->delete('announcement_fields');
				return true;
			}
			else
			{
				return false;
			}
		}
		elseif ($query->num_rows() > 1)
		{
			$this->db->where('announcement_id', $announcement_id);
			$this->db->where('table_name', 'Company');
			$this->db->where('id', $company_id);
			$this->db->delete('announcement_fields');
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else{}
	}

	//check if company has division
	public function check_div($company_id)
	{
		$data = array(
			'company_id' => $company_id,
			'wDivision' => 1
		);

		$this->db->select('company_id');
		$this->db->from('company_info');
		$this->db->where($data);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			//return $query->result();
			return true;
		}
		else
		{
			return false;
		}
	}

	//check if division table has company
	public function check_div_value($company_id)
	{
		$this->db->where('company_id', $company_id);
		$query = $this->db->get('division');
		if($query->num_rows() > 0)
		{
			//return $query->result();
			return true;
		}
		else
		{
			return false;
		}
	}

	//check if department table has company
	public function check_dept_value($company_id)
	{
		$this->db->where('company_id', $company_id);
		$query = $this->db->get('department');
		if($query->num_rows() > 0)
		{
			//return $query->result();
			return true;
		}
		else
		{
			return false;
		}
	}

	//get division details from division table
	public function getDivision($company_id)
	{
		$this->db->select('division_id, division_name');
		$this->db->from('division');
		//$this->db->where('company_id', $company_id);
		if ($company_id == 'All') {}
		else{
			$this->db->where('company_id', $company_id);
		}
		$query = $this->db->get();
		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	//get department details from department table
	public function getDepartment($company_id)
	{
		$this->db->select('department_id, dept_name');
		$this->db->from('department');
		//$this->db->where('company_id', $company_id);
		if ($company_id == 'All') {}
		else{
			$this->db->where('company_id', $company_id);
		}
		$query = $this->db->get();
		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	//get department details from department table filter by division id
	public function get_dept($division_id)
	{
		$this->db->select('department_id, dept_name');
		$this->db->from('department');
		if ($division_id == 'All') {}
		else{
			$this->db->where('division_id', $division_id);
		}
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	//get section details from section table filter by department id
	public function get_sec($department_id)
	{
		$this->db->select('section_id, section_name');
		$this->db->from('section');
		if($department_id == 'All'){}
		else{
			$this->db->where('department_id', $department_id);
		}
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	//get subsection details from subsection table filter by section id
	public function get_subsec($section_id)
	{
		$this->db->select('subsection_id, subsection_name');
		$this->db->from('subsection');
		if($section_id == 'All'){}
		else{
			$this->db->where('section_id', $section_id);
		}
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	public function divList()
	{
		$this->db->select('division_id, division_name');
		$this->db->from('division');
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	public function secList()
	{
		$this->db->select('section_id, section_name');
		$this->db->from('section');
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	public function subSecList()
	{
		$this->db->select('subsection_id, subsection_name');
		$this->db->from('subsection');
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	//End ANNOUNCEMENT ===================================================================
	
	//specialization

	public function get_specialization()
	{
		$this->db->where('cCode','job_specialization');
		$query = $this->db->get('system_parameters');
		return $query->result();
	}

	public function delete_specialization($id)
	{
		$this->db->where('param_id',$id);
		$this->db->delete('system_parameters');

		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function edit_specialization($id)
	{
		$this->db->where('param_id',$id);
		$query = $this->db->get('system_parameters');
		return $query->row();
	}

	public function update_specialization($id,$specialization,$details)
	{
		$this->db->where('param_id',$id);
		$this->db->update('system_parameters',array('cValue'=>$specialization,'cDesc'=>$details));
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function add_specialization($specialization,$details)
	{
		$data = array('cCode'=>'job_specialization','cValue'=>$specialization,'cDesc'=>$details,'InActive'=>0);
		$this->db->insert('system_parameters',$data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}

	//
	public function get_province()
	{
		$query = $this->db->get('provinces');
		return $query->result();
	}

	public function add_province($province)
	{
		$data = array('name'=>$province);
		$this->db->insert('provinces',$data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}


	public function verify_province_emp($id)
	{
		$this->db->where('permanent_province',$id);
		$query = $this->db->get('employee_info');
		$q = $query->result();

		$this->db->where('present_province',$id);
		$query1 = $this->db->get('employee_info');
		$q1 = $query1->result();


		return array_merge($q,$q1);
	}

	public function get_province_details($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('provinces');
		return $query->row();
	}

	public function modify_province($id,$value)
	{
		$this->db->where('id',$id);
		$update = $this->db->update('provinces',array('name'=>$value));
	}

	public function get_city()
	{
		$this->db->select('a.*,b.name');
		$this->db->join('provinces b','b.id=a.province_id');
		$query = $this->db->get('cities a');
		return $query->result();
	}

	public function add_city($province,$city)
	{
		$data = array('province_id'=>$province,'city_name'=>$city);
		$this->db->insert('cities',$data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}

	public function verify_city_emp($id)
	{
		$this->db->where('permanent_city',$id);
		$query = $this->db->get('employee_info');
		$q = $query->result();

		$this->db->where('present_city',$id);
		$query1 = $this->db->get('employee_info');
		$q1 = $query1->result();


		return array_merge($q,$q1);
	}

	public function get_city_details($id)
	{
		$this->db->select('a.*,b.name');
		$this->db->join('provinces b','b.id=a.province_id');
		$this->db->where('a.id',$id);
		$query = $this->db->get('cities a');
		return $query->row();
	}

	public function modify_city($id,$value)
	{
		$this->db->where('id',$id);
		$this->db->update('cities',array('city_name'=>$value));
	}

}