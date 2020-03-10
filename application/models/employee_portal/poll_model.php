<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class poll_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	
	}

	public function get_poll(){
		$this->db->select('*');
		$this->db->from('poll_name');
		$this->db->where('created_by',$this->session->userdata('employee_id'));
		$s  = $this->db->get();
		return $s->result();
	}
	public function get_company(){
		$this->db->select('*');
		$this->db->from('company_info');
		$s  = $this->db->get();
		return $s->result();
	}

	public function create()
	{
		
		
		
		if($this->input->post('poll_type') == 'multiple_choice'){
		$this->data = array(
			'name'		=> $this->input->post('name'),
			'poll_type' => $this->input->post('poll_type'),
			'created_by'   =>  $this->session->userdata('employee_id'),
		    'status' => 0,
		

		
			);

		

		$this->db->insert('poll_name', $this->data);
		$pollid = $this->db->insert_id();
		$opt = $this->input->post('question');
		for ($i=0; $i <= count($opt); $i++) { 
			$s = $i+1;
			if(!empty($this->input->post('opt'.$s))){
			$correct  = $this->input->post('opt'.$s);
			$c = $this->input->post('question')[$i];
		$this->data = array(
			'poll'		=> $pollid,
			'question'=> $c,
			'number_of_respond' => 1
			
			
		
			);
		$this->db->insert('poll_multiplechoice', $this->data);
		$c = $this->db->insert_id();
			foreach($correct as $sf){
			$this->data = array(
			'multiple_choice'=> $c,
			'opts'=> $sf,
			'count'=> 0,
			
			
			
		
			);
		$this->db->insert('poll_opts', $this->data);
	
		}
		}
		}
		}elseif($this->input->post('poll_type') == 'open'){
			$this->open = array(
			'name'		=> $this->input->post('title_open'),
			'poll_type' => $this->input->post('poll_type'),
			'created_by'   =>  $this->session->userdata('employee_id'),
			'status'=>0
		
		
			);
		$this->db->insert('poll_name', $this->open);
		


			$this->opend = array(
			'id'		=> $this->db->insert_id(),
			'poll_question' => $this->input->post('questionas'),
			
		
		
			);
		$this->db->insert('poll_open', $this->opend);

		}
	}


	public function saved_participants(){
		foreach($this->input->post('val') as $c){
		$this->data = array(
			'employee_id'		=> $c,
			'poll_id' => $this->input->post('poll_name'),
						
		
			);

		

		$this->db->insert('poll_participant', $this->data);

	}
	}

	public function get_participant($c){
		$this->db->select('*');
		$this->db->from('poll_participant a');
		$this->db->join('employee_info b', 'a.employee_id = b.employee_id');

		$this->db->join('department c', 'b.department = c.department_id');


		$this->db->where('poll_id',$c);
		
		$s  = $this->db->get();
		return $s->result();

	}
	public function get_polling_live($polling,$type){
		$this->db->select('*,a.id as qweqwe');
		$this->db->from('poll_name a');
		if($type == 'multiple_choice'){
		$this->db->join('poll_multiplechoice b', 'a.id = b.poll');
		
		}elseif($type =='open'){

		}
		$this->db->where('a.id',$polling);
		
		
		$s  = $this->db->get();
		return $s->result();

	}

	public function get_polling_live_from_client($polling){
		$this->db->select('*,b.id as id');
		$this->db->from('poll_name a');
	
		$this->db->join('poll_multiplechoice b', 'a.id = b.poll');
		$this->db->join('poll_try c', 'b.id = c.question_id');
		$this->db->where('c.employee_id',$this->session->userdata('employee_id'));
		
		$this->db->where('a.id',$polling);
		
		
		$s  = $this->db->get();
		return $s->result();

	}
	public function get_opt($polling){
		$this->db->select('*,a.id as id');
		$this->db->from('poll_opts a');
	
		
	
		$this->db->where('multiple_choice',$polling);

		
		
		$s  = $this->db->get();
		return $s->result();

	}

	public function get_polling_live_open_from_client($polling){
		$this->db->select('*');
		$this->db->from('poll_open a');
	
		$this->db->join('poll_participant b', 'a.id = b.poll_id');
		
		$this->db->where('b.employee_id',$this->session->userdata('employee_id'));
		
		$this->db->where('a.id',$polling);
		
		
		$s  = $this->db->get();
		return $s->result();

	}
	public function is_participant(){
		$this->db->select('*,b.id as id');
		$this->db->from('poll_participant a');
		$this->db->join('poll_name b', 'a.poll_id = b.id');
		$this->db->where('a.employee_id',$this->session->userdata('employee_id'));
		$s  = $this->db->get();
		return $s->result();

	}
	public function voted($ops){
		$this->db->select('*');
		$this->db->from('poll_up_down_vote a');
		$this->db->where('a.open_id',$ops);
		$this->db->where('a.employee_id',$this->session->userdata('employee_id'));
		$s  = $this->db->get();
		return $s->row();
	}
		public function get_polling_results($polling,$questio){
		$this->db->select('*');
		$this->db->from('poll_results');
				
		
		$this->db->where('poll',$polling);
		$this->db->where('question',$questio);
		$this->db->group_by('opts');
		
			
		return $this->db->get();
		

	}


	public function save_downvote(){
	
		$qsa = $this->voted($this->input->post('id'));
		if(empty($qsa->id)){
			$data4 = array(
			'open_id'=>$this->input->post('id'),
			'employee_id'=>$this->session->userdata('employee_id'),
			'downvote'=> 1,
			'upvote'=> 0
		);
		$this->db->insert('poll_up_down_vote',$data4);


		return $this->db->insert_id();	
		}

		
	}
		public function get_polling_live_open_live($polling){
		$this->db->select('*');
		$this->db->from('poll_name a');
	
		$this->db->join('poll_participant b', 'a.id = b.poll_id');
		$this->db->group_by('a.id');
	
		
		$this->db->where('a.id',$polling);
		
		
		$s  = $this->db->get();
		return $s->result();

	}
	public function save_upvote(){
		$qsa = $this->voted($this->input->post('id'));
			if(empty($qsa->id)){
			$data4 = array(
			'open_id'=>$this->input->post('id'),
			'employee_id'=>$this->session->userdata('employee_id'),
			'downvote'=> 0,
			'upvote'=> 1
		);
		$this->db->insert('poll_up_down_vote',$data4);




		return  $this->db->insert_id();	
		}




	}
	public function get_polling_question($polling){
		$this->db->select('*');
		$this->db->from('poll_name a');
		$this->db->join('poll_multiplechoice b', 'a.id = b.poll');
		$this->db->where('a.id',$polling);
		$this->db->group_by(array('b.question'));
		
		$s  = $this->db->get();
		return $s->result();

	}
	public function get_polling_results_count($polling,$questio){
		$this->db->select('*');
		$this->db->from('poll_results');
				
		
		$this->db->where('poll',$polling);
		$this->db->where('question',$questio);
		
		
			
		$a = $this->db->get();
		return $a->num_rows(); 
		

	}
		public function get_unread_notification($employee){
			$this->db->where(array(
				'employee_id'	=> $employee,
				'status' => 1,
				'notification_type'=>'POLL'
			));
		
		$query = $this->db->get("notification");
		return $query->num_rows();
	}
	public function notification(){
		$this->db->where('poll_id',$this->input->post('data'));
		
		$qc = $this->db->get('poll_participant');
		$emp_id = array();
		foreach($qc->result() as $qs){
		$data = array('notification_type'=>'POLL','employee_id'=>$qs->employee_id,'date'=>date("Y-m-d H:i:s"),'status' =>1,'notification_message'=>'You have a new poll');
		$this->db->insert('notification',$data);
		array_push($emp_id,$qs->employee_id);
		}
		return $emp_id;


	}
	public function saved_polling_open(){
		
		$data = array(
			'poll_id'=> $this->input->post('poll_name'),
			'poll_answer'=> $this->input->post('ans'),
			'employee_id' => $this->session->userdata('employee_id'),
			
		);
		$this->db->insert('poll_open_results',$data);
	
	}
	public function get_opens($polli){
		$this->db->select('*');
		$this->db->from('poll_open_results a');
		$this->db->join('employee_info b', 'a.employee_id = b.employee_id');
		$this->db->where('a.poll_id',$polli);
		$a = $this->db->get();
		return $a->result();
	}
	public function ans_res($opts,$employee_id,$question){
		$this->db->select('*');
		$this->db->from('poll_results a');
	
				
		
		$this->db->where('question',$question);
		$this->db->where('opts',$opts);
		$this->db->where('employee_id',$employee_id);
		
		
		$s  = $this->db->get();
		return $s->num_rows();
	}
	function get_poll_type($id){
		$this->db->select('*');
		$this->db->from('poll_name');
		$this->db->where('id',$id);
		$a = $this->db->get();
		return $a->row();
	}
	public function get_polling_opt($polling,$questio){
		$this->db->select('*');
		$this->db->from('poll_multiplechoice a');
		$this->db->join('poll_opts b', 'a.id = b.multiple_choice');
		$this->db->join('poll_try c', 'a.id = c.question_id');
				
		
		$this->db->where('a.poll',$polling);
		$this->db->where('a.question',$questio);
		$this->db->where('c.employee_id',$this->session->userdata('employee_id'));
		
		
		$s  = $this->db->get();
		return $s->result();

	}

	public function activate_deactivate(){
		$this->db->set('status', '1');
		$this->db->where('id',$this->input->post('data'));
	
		$this->db->update('poll_name');
		$id = $this->get_poll_type($this->input->post('data'));
		if($id->poll_type == 'multiple_choice'){
		$this->db->select('*,a.id as id');
		
		$this->db->from('poll_multiplechoice a');
		$this->db->join('poll_participant b','a.poll= b.poll_id');
		$this->db->where('a.poll',$this->input->post('data'));
		$qv = $this->db->get();
		$qs = $qv->result();
		foreach($qs as $qs){
		$data = array(
				'question_id'=>$qs->id,
				'employee_id'=>$qs->employee_id,
				'try'=>$qs->number_of_respond
		);
		$this->db->insert('poll_try', $data);
		}

		}

		
	}

	public function saved_polling(){
		for ($i=0; $i < count($this->input->post('val')) ; $i++) { 
		$this->db->set('count', 'count+1', FALSE);
		
		$this->db->where('opts',$this->input->post('val')[$i]);
		$this->db->where('multiple_choice',$this->input->post('question')[$i]);
	
		

		$this->db->update('poll_opts');

	


			$data = array(
			'opts'=> $this->input->post('val')[$i],
			'poll'=> $this->input->post('poll'),
			'employee_id' => $this->session->userdata('employee_id'),
			'question'  => $this->input->post('question')[$i]
		);
		$this->db->insert('poll_results',$data);

		
	}

		for ($i=0; $i < count($this->input->post('attem')) ; $i++) { 
		$this->db->set('try', $this->input->post('attem')[$i],FALSE);
		
		$this->db->where('employee_id',$this->session->userdata('employee_id'));
		$this->db->where('question_id',$this->input->post('questionid')[$i]);
		$this->db->update('poll_try');
		}
	
	}





}