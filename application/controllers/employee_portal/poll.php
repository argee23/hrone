 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class poll extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/poll_model");
		$this->load->model("general_model");
	
		
	}

	public	function index(){
		$data['poll'] = $this->poll_model->get_poll();
		$data['participant'] = $this->poll_model->is_participant();

		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/poll/index',$data);
		$this->load->view('employee_portal/footer');

	}

	public function create(){
        
 
		if($this->input->post('submit')){
		
        $this->poll_model->create();
		$msg = '<div class="alert alert-success">Poll Saved!</div>';

       
        	

		}
		if(!empty($msg)){
		$data['msg'] = $msg;
		}else{
		$data['msg'] = '';
		}
		$data['v'] = 'create';
		$this->load->view('employee_portal/poll/template',$data);
	}

	public function recieve(){


		$arr = array();
		$this->db->select('*,d.fullname as receiver,c.fullname as sender ,a.sender_id as employee_id');
		$this->db->from('chat a');

		$this->db->join('group_user_x b', 'a.group_id = b.group_id');
		$this->db->join('employee_info c', 'a.sender_id = c.employee_id');
		$this->db->join('employee_info d', 'b.employee_id = d.employee_id');
		$this->db->where('b.employee_id',$this->input->post('emps'));

		
		
		$s  = $this->db->get();
		$qs = $s->result();
		foreach($qs as $qs ){

			$arr[] = array('msg'=>$qs->message,'sender'=>$qs->sender,'receiver'=> $qs->receiver,'employee_id'=>$qs->employee_id,'group_id'=>$qs->group_id);

		}

		echo json_encode($arr);
	}

	public function send(){


				$qw = rand();


		$data = array(
					   array(
					     
									'employee_id'   => $this->input->post('receiver'),

									'group_id' =>  $qw
					   ),
					   array(
					      
									'employee_id'   => $this->input->post('sender_id'),

									'group_id' =>  $qw
					  )
			);

$this->db->insert_batch('group_user_x', $data); 
			

			$this->data = array(
			'message'		=> $this->input->post('msg'),
			'sender_id'     => $this->input->post('sender_id'),
			'timestamp'     => date("Y-m-d H:i:s"),
			'group_id' =>   $qw

		

			);
		$this->db->insert('chat', $this->data);


		echo 'success';
	}
	public function get_online_employee(){
		
		$this->db->select('*');
		$this->db->from('employee_info');
		
		$s  = $this->db->get();
		$qs = $s->result();
		$arr = array();
		 foreach($qs as $qc){

		 $arr[] = array('fullname'=>$qc->fullname,'employee_id'=>$qc->employee_id);		

		 }
		 echo json_encode($arr);

	}

	public function delete(){
		$data['v'] = 'send';
		$this->load->view('employee_portal/poll/template',$data);
	}
		public function _create(){
		
		$this->poll_model->create();
		$this->create();
	}
		public function message(){
		$data['message'] = $this->db->select('*')->from('message')->order_by('id','desc')->get();
		$data['v'] = 'message';
		$this->load->view('employee_portal/poll/template',$data);
	}
	public function auth(){
		$array = array();
		$que = array();
		$poll = $this->input->post('val');
		$type = $this->input->post('type');
		$polling = $this->poll_model->get_polling_live($poll,$type);
		foreach($polling as $polling){
		$poll_count_num = $this->poll_model->get_opt($polling->id);
		

						
				

				foreach($poll_count_num as $poll_count_num){	
					  $array []=array(
						        'ranking' => $poll_count_num->count,
						        'score' =>$poll_count_num->id 
						        
						  
						    );
	
				}
		}


		echo json_encode($array) ;
				

		
	
		
}	public function activate_deactivate(){
			$this->poll_model->activate_deactivate();
			$emp = $this->poll_model->notification();
			
			 $arr = array();
			 $arr['success'] = true;

			foreach($emp as $s){
				$count = $this->poll_model->get_unread_notification($s);
				$arr[] = array('notification_type'=>'POLL','notification'=>'You have a new polling','emp_id' => $s,'new_count_message'=> $count ,'destination'=>'http://localhost/hrone/employee_portal/poll/');
			
			}
			
						echo json_encode($arr);
}
	public function polling_live($poll,$type){
		if($type == 'multiple_choice'){
			$data['polling'] = $this->poll_model->get_polling_live($poll,$type);
   			$data['message'] = $this->db->select('*')->from('poll_opts')->order_by('id','desc')->get();
   			$data['v'] = 'poll_type/multiple_choice_live';
		}elseif($type == 'open'){
			$data['pollingg'] = $this->poll_model->get_polling_live_open_live($poll);
   			$data['get_result'] =$this->poll_model->get_opens($poll);
			$data['v'] = 'poll_type/open_live';
		}
   		
   		$this->load->view('employee_portal/poll/template',$data);
   	}

   public function get_filter(){
   		$this->input->post('c');
   			$this->db->select('*');
		$this->db->from('employee_info');
		$this->db->where('company_id',$this->input->post('c'));
		$s  = $this->db->get();
	    $a = $s->result();
	    foreach($a as $a){
	    	echo '<tr><td><input type="checkbox" value="'.$a->employee_id.'" name=""></td><td>'.$a->employee_id.'</td><td>'.$a->fullname.'</td></tr>';
	    }
   }
   public function saved_participants(){
   		$this->poll_model->saved_participants();
   }
   public function saved_polling($type){
   		 if($type == 'multiple_choice'){
		 $this->poll_model->saved_polling();
		 $arr = array();
		
		
		$a = $this->db->select('*')->from('poll_opts')->get()->result();
		$c = 0;
		foreach($a as $a){
			
					  $arr[]=array(
					  				'id' =>$a->id.$a->multiple_choice ,
						        'count' => $a->count,
						        'opt' => $a->opts,
						        'wc' =>$a->multiple_choice,

						        'questionid' => $c
						        
						        
						  
						    );
					  $c++;

		}
		$arr['success']= true;
		}elseif($type == 'open'){
		$qwe = $this->db->select('*')->from('poll_open_results')->where(array('employee_id'=>$this->session->userdata('employee_id')))->get()->num_rows();
		if($qwe < 1){
		$this->poll_model->saved_polling_open();
		$arr['success']= true;
		}else{
		$arr['exist'] = true;	
		}
		
		}
		echo json_encode($arr);
	}



   public function participants($poll){
   		$data['get_participant'] = $this->poll_model->get_participant($poll);
   		$data['v'] = 'participants';
   		$data['poll'] = $poll;
  		$data['c'] = $this->poll_model->get_company();
  		$data['departmentList'] = $this->general_model->departmentList();
  		$data['classificationList'] = $this->general_model->classificationList();

   		$this->load->view('employee_portal/poll/template',$data);
   }

   public function polling($poll,$type){
   		if($type=='multiple_choice'){
   		$data['polling'] = $this->poll_model->get_polling_question($poll);
   		$data['pollingg'] = $this->poll_model->get_polling_live_from_client($poll);
   		$data['v'] = 'poll_type/multiple_choice';
   		}elseif($type == 'open'){
   		$data['pollingg'] = $this->poll_model->get_polling_live_open_from_client($poll);
   		$data['get_result'] =$this->poll_model->get_opens($poll);
   		$data['v'] = 'poll_type/open';
   		}
   	
   	
   		$this->load->view('employee_portal/poll/template',$data);
   }
   	public function save_upvote(){
   		$arr = [];
   		if($this->input->post('qwe') == 'down'){
   	     	  $asc = $this->poll_model->save_downvote();
   		}elseif($this->input->post('qwe') == 'up'){
   			  $asc = $this->poll_model->save_upvote();	
   		}
   		
   		$ass = $this->db->select('*')->from('poll_up_down_vote')->where(array('id'=>$asc))->get()->row();
   		if($ass){
   			$upvote = $this->db->select_sum('upvote')->from('poll_up_down_vote')->where(array('open_id'=>$ass->open_id))->get()->row();
   			$downvote = $this->db->select_sum('downvote')->from('poll_up_down_vote')->where(array('open_id'=>$ass->open_id))->get()->row();
   		$arr['id'] = $ass->open_id;
   		$arr['emp'] = $ass->employee_id;
   		$arr['qwe'] = $this->input->post('qwe');
   		$arr['up'] = $upvote->upvote;
   		$arr['down'] = $downvote->downvote;
   		$arr['success'] = 'true';
   		
   		echo json_encode($arr);
   	}
   }
	public function submit(){

		$this->form_validation->set_rules('name', '<b>Name</b>', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('email', '<b>Email</b>', 'trim|required|valid_email|max_length[100]');
		$this->form_validation->set_rules('subject', '<b>Subject</b>', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('message', '<b>message</b>', 'trim|required');

		$arr['name'] = $this->input->post('name');
		$arr['email'] = $this->input->post('email');
		$arr['subject'] = $this->input->post('subject');
		$arr['message'] = $this->input->post('message');

		if ($this->form_validation->run() == FALSE) {

			$arr['success'] = false;
			$arr['notif'] = '<div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . validation_errors() . '</div>';

		} else {

			$this->db->insert('message',$arr);
			$detail = $this->db->select('*')->from('message')->where('id',$this->db->insert_id())->get()->row();
			$arr['name'] = $detail->name;
			$arr['email'] = $detail->email;
			$arr['subject'] = $detail->subject;
			$arr['created_at'] = $detail->created_at;
			$arr['id'] = $detail->id;
			$arr['new_count_message'] = $this->db->where('read_status',0)->count_all_results('message');
			$arr['success'] = true;
			$arr['notif'] = '<div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 alert alert-success" role="alert"> <i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Message sent ...</div>';

		}
		
		echo json_encode($arr);
	}

	public function detail(){

		$detail = $this->db->select('*')->from('message')->where('id',$this->input->post('id'))->get()->row();

		if($detail){

			$this->db->where('id',$this->input->post('id'))->update('message',array('read_status'=>1));

			$arr['name'] = $detail->name;
			$arr['email'] = $detail->email;
			$arr['subject'] = $detail->subject;
			$arr['message'] = $detail->message;
			$arr['created_at'] = $detail->created_at;
			$arr['update_count_message'] = $this->db->where('read_status',0)->count_all_results('message');
			$arr['success'] = true;

		} else {

			$arr['success'] = false;
		}

		
		
		echo json_encode($arr);

	}

}