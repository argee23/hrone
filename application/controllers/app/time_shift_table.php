<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Time_shift_table extends General{

	public function __construct(){
		parent::__construct();
		$this->load->model("app/time_shift_table_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();		
	}
	public function index(){	
				// user restriction function
		// $this->session->set_userdata('page_name','time_shift_table_li');
		// $page_id = $this->general_model->getPageID();
		// $userRole = $this->general_model->getUserLoggedIn($this->session->userdata('username'));
		// if(General::has_rights_to_access($page_id->page_id,$userRole->user_role) == FALSE){
		
		// $value = "Shift Table";
		// General::logfile('Shift Table','TRY TO ACCESS',$value);	
		// redirect(base_url().'access_denied'); // app/dashboard
		// 	}
				// end of user restriction function		
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		//$this->data['file'] = $this->transaction_file_maintenance_model->getAll();
		
		$this->load->view('app/time/shift_table/index',$this->data);
	}	
	public function view_working_schedule(){

		$company_id=$this->uri->segment('4');
		// wsr_complete : working schedule reference complete
		// $this->data['wsr_complete']= $this->time_shift_table_model->view_working_sched_complete($key_location);
		// wsr_half_day : working schedule reference half day
		// $this->data['wsr_half_day']= $this->time_shift_table_model->view_working_sched_half($key_location);
		// wsr_rd_hol : working schedule reference rest day / holiday
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->load->view('app/time/shift_table/view',$this->data);
	}
	public function add_shift(){
        $company_id =$this->uri->segment('4');		
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->load->view('app/time/shift_table/add_ws_regular');
	}
	//add_wsc: add working schedule complete (wholeday)
	public function add_wsc(){
        $company_id =$this->uri->segment('4');		
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->load->view('app/time/shift_table/add_ws_regular',$this->data);
	}
	//add_ws_cf: add working schedule controlled flexi
	public function add_ws_cf(){
        $company_id =$this->uri->segment('4');		
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->load->view('app/time/shift_table/add_ws_controlled_flexi',$this->data);
	}
	//add_ws_ff: add working schedule full flexi
	// public function add_ws_ff(){

	// 	$this->load->view('app/time/shift_table/add_ws_full_flexi',$this->data);
	// }
	//add_wsc: add working schedule rest day holiday
	public function add_ws_rd_hol(){
        $company_id =$this->uri->segment('4');		
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->load->view('app/time/shift_table/add_ws_rd_hol',$this->data);
	}
	public function validate_shift_full_flexi(){
foreach ($this->input->post('classification_id') as $key => $classification_id) {

		$company_name=$this->input->post('company_name');
		$company_id = $this->input->post('company_id');

		$time_in=$this->input->post('time_in');
		$time_out=$this->input->post('time_out');

		$shift=$time_in.$time_out;

		if($this->time_shift_table_model->validate_add_shift_full_flexi($shift,$company_id,$classification_id)){
			$this->form_validation->set_message("validate_shift_full_flexi","Full Flexi Working Schedule , <strong>".$time_in." to ".$time_out."</strong>, Already Exists to ".$company_name."");
			return false;
		}else{
			return true;
		}
}
	}
	public function validate_shift_controlled_flexi(){
foreach ($this->input->post('classification_id') as $key => $classification_id) {

		$company_name = $this->input->post('company_name');
		$company_id=$this->input->post('company_id');

		$time_in=$this->input->post('time_in');
		$time_out=$this->input->post('time_out');

		$shift=$time_in.$time_out;

		if($this->time_shift_table_model->validate_add_shift_controlled_flexi($shift,$company_id,$classification_id)){
			$this->form_validation->set_message("validate_shift_controlled_flexi","Controlled Flexi Working Schedule , <strong>".$time_in." to ".$time_out."</strong>, Already Exists to ".$company_name."");
			return false;
		}else{
			return true;
		}
}
	}
	public function validate_shift(){
foreach ($this->input->post('classification_id') as $key => $classification_id) {

		$company_name = $this->input->post('company_name');
		$company_id=$this->input->post('company_id');

		$time_in=$this->input->post('time_in_hr').":".$this->input->post('time_in_minute');
		$time_out=$this->input->post('time_out_hr').":".$this->input->post('time_out_minute');

		$shift=$time_in.$time_out;

		if($this->time_shift_table_model->validate_add_shift_regular($shift,$company_id,$classification_id)){
			$this->form_validation->set_message("validate_shift","Regular Working Schedule , <strong>".$time_in." to ".$time_out."</strong>, Already Exists to ".$company_name."");
			return false;
		}else{
			return true;
		}
}
	}

	public function validate_edit_shift(){

		$company_id = $this->input->post('company_id');
		$company_name=$this->input->post('company_name');
		$classification_id=$this->input->post('classification_id');

		$time_in=$this->input->post('time_in_hr').":".$this->input->post('time_in_minute');
		$time_out=$this->input->post('time_out_hr').":".$this->input->post('time_out_minute');

		$id = $this->uri->segment("4");
		$shift=$time_in.$time_out;

		if($this->time_shift_table_model->validate_edit_shift_regular($shift,$company_id,$classification_id,$id)){
			$this->form_validation->set_message("validate_edit_shift","Regular Working Schedule , <strong>".$time_in." to ".$time_out."</strong>, Already Exists to ".$company_name."");
			return false;
		}else{
			return true;
		}
	}
	public function validate_edit_shift_rd_hol(){

		$company_id = $this->input->post('company_id');
		$company_name=$this->input->post('company_name');
		$classification_id=$this->input->post('classification_id');

		$time_in=$this->input->post('time_in_hr').":".$this->input->post('time_in_minute');
		$time_out=$this->input->post('time_out_hr').":".$this->input->post('time_out_minute');

		$id = $this->uri->segment("4");
		$shift=$time_in.$time_out;

		if($this->time_shift_table_model->validate_edit_shift_rd_hol($shift,$company_id,$classification_id,$id)){
			$this->form_validation->set_message("validate_edit_shift_rd_hol","Restday/Holiday Working Schedule/Complete , <strong>".$time_in." to ".$time_out."</strong>, Already Exists to ".$company_name."");
			return false;
		}else{
			return true;
		}
	}
	public function validate_edit_shift_hd(){

		$company_id = $this->input->post('company_id');
		$company_name=$this->input->post('company_name');
		$classification_id=$this->input->post('classification_id');

		$time_in=$this->input->post('time_in_hr').":".$this->input->post('time_in_minute');
		$time_out=$this->input->post('time_out_hr').":".$this->input->post('time_out_minute');

		$id = $this->uri->segment("4");
		$shift=$time_in.$time_out;

		if($this->time_shift_table_model->validate_edit_shift_hd($shift,$company_id,$classification_id,$id)){
			$this->form_validation->set_message("validate_edit_shift_hd","Halfday Working Schedule/Complete , <strong>".$time_in." to ".$time_out."</strong>, Already Exists to ".$company_name."");
			return false;
		}else{
			return true;
		}
	}

	public function validate_shift_wshd(){
foreach ($this->input->post('classification_id') as $key => $classification_id) {

		$company_name = $this->input->post('company_name');
		$company_id=$this->input->post('company_id');

		$time_in=$this->input->post('time_in_hr').":".$this->input->post('time_in_minute');
		$time_out=$this->input->post('time_out_hr').":".$this->input->post('time_out_minute');

		$shift=$time_in.$time_out;

		if($this->time_shift_table_model->validate_add_shift_wshd($shift,$company_id,$classification_id)){
			$this->form_validation->set_message("validate_shift_wshd","Half Day Working Schedule , <strong>".$time_in." to ".$time_out."</strong>, Already Exists to ".$company_name."");
			return false;
		}else{
			return true;
		}

}		
	}

	public function validate_shift_rd_hol(){
		foreach ($this->input->post('classification_id') as $key => $classification_id) {

		$company_id = $this->input->post('company_name');
		$company_name=$this->input->post('company_id');

		$time_in=$this->input->post('time_in_hr').":".$this->input->post('time_in_minute');
		$time_out=$this->input->post('time_out_hr').":".$this->input->post('time_out_minute');

		$shift=$time_in.$time_out;

		if($this->time_shift_table_model->validate_add_shift_rd_hol($shift,$company_id,$classification_id)){
		$this->form_validation->set_message("validate_shift_rd_hol","Rest day / Holiday - Regular Working Schedule , <strong>".$time_in." to ".$time_out."</strong>, Already Exists to ".$company_name."");
		return false;
		}else{
		return true;
		}
		}
	}


	//save_add_wsc: save add working schedule complete (wholeday)
	public function save_add_wsc(){
		$company_name=$this->input->post('company_name');
		$company_id = $this->input->post('company_id');

		$this->form_validation->set_rules("time_in_hr","Time IN","trim|required|callback_validate_shift");
		$this->form_validation->set_rules("time_out_hr","Time OUT","trim|required");
		$this->form_validation->set_rules("no_of_hours","Registered Hours","trim|required");
		//$this->form_validation->set_rules("classification_id","Classification","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// audit trail in the model

			$this->time_shift_table_model->save_add_wsc();
		
			$value = $company_name;

			$fullshift=$this->input->post('time_in_hr').":".$this->input->post('time_in_minute')." to ".$this->input->post('time_out_hr').":".$this->input->post('time_out_minute');

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  <strong>".$fullshift." : Regular Working Schedule Reference </strong>, is Successfully Added!</div>");

			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/time_shift_table/index',$this->data);
		}else{

			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		
	}
	//save_add_wsc: save add working schedule rest day/holiday
	public function save_add_ws_rd_hol(){
		$company_name=$this->input->post('company_name');
		$company_id = $this->input->post('company_id');

		$this->form_validation->set_rules("time_in_hr","Time IN","trim|callback_validate_shift_rd_hol");//
		$this->form_validation->set_rules("time_out_hr","Time OUT","trim|required");
		$this->form_validation->set_rules("no_of_hours","Registered Hours","trim|required");
		//$this->form_validation->set_rules("classification_id","Classification","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save_add_wsc: save add working schedule restday/holiday
			// audit trail in the model
			$this->time_shift_table_model->save_add_ws_rd_hol();

	
			$value = $company_name;
			$fullshift=$this->input->post('time_in_hr').":".$this->input->post('time_in_minute')." to ".$this->input->post('time_out_hr').":".$this->input->post('time_out_minute');
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>".$fullshift." :  Rest day / Holiday - Regular Working Schedule Reference , is Successfully Added! </strong></div>");
			// redirect
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/time_shift_table/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		
	}
	//add_wshd: add working schedule halfday(halfday)
	public function add_wshd(){
        $company_id =$this->uri->segment('4');		
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->load->view('app/time/shift_table/add_ws_half_day',$this->data);
	}
	//save_add_wshd: save add working schedule halfday (halfday)
	public function save_add_wshd(){
		$company_name=$this->input->post('company_name');
		$company_id = $this->input->post('company_id');

		$this->form_validation->set_rules("time_in_hr","Time IN","trim|required|callback_validate_shift_wshd");
		$this->form_validation->set_rules("time_out_hr","Time OUT","trim|required");
		$this->form_validation->set_rules("no_of_hours","Registered Hours","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save_add_wshd: save add working schedule half day (half day)
			// audit trail in the model
			$this->time_shift_table_model->save_add_wshd();

			$value = $company_name;
			$fullshift=$this->input->post('time_in_hr').":".$this->input->post('time_in_minute')." to ".$this->input->post('time_out_hr').":".$this->input->post('time_out_minute');
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>".$fullshift." : Half Day Working Schedule Reference , is Successfully Added! </strong></div>");

			// redirect
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/time_shift_table/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}

	}
	//delete_ws_rd_hol: delete working schedule rest day/holiday
	public function delete_ws_rd_hol(){

		$id = $this->uri->segment("4");
		//ws : working schedule
		$ws = $this->time_shift_table_model->get_work_sched_rd_hol($id);
		
		$this->db->query("update working_schedule_ref_restday_holiday set InActive = 1 where id = ".$id);

		// logfile
		$company_id=$ws->company_id;
		$value = $ws->time_in. " to ".$ws->time_out;

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Shift Table','logfile_time_shift_table','delete rd/holiday shift : '.$value.' , id: '.$id.'','DELETE',$value);


		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Rest day / Holiday - Regular Working Schedule, <strong>".$value."</strong>, is  Successfully Deleted!</div>");

		$this->session->set_flashdata('onload',"view(".$company_id.")");
		redirect(base_url().'app/time_shift_table/index',$this->data);
	}

	//delete_wsc: delete working schedule complete/regular
	public function delete_wsc(){

		$id = $this->uri->segment("4");
		//ws : working schedule
		$ws = $this->time_shift_table_model->get_work_sched_comp($id);
		
		$this->db->query("update working_schedule_ref_complete set InActive = 1 where id = ".$id);

		// logfile
		$company_id=$ws->company_id;
		$value = $ws->time_in. " to ".$ws->time_out;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Shift Table','logfile_time_shift_table','delete regular shift : '.$value.' , id: '.$id.'','DELETE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Regular Working Schedule, <strong>".$value."</strong>, is  Successfully Deleted!</div>");

		$this->session->set_flashdata('onload',"view(".$company_id.")");
		redirect(base_url().'app/time_shift_table/index',$this->data);
	}

	//delete_wshd: delete working schedule half day
	public function delete_wshd(){

		$id = $this->uri->segment("4");
		//ws : working schedule
		$ws = $this->time_shift_table_model->get_work_sched_half($id);
		
		$this->db->query("update working_schedule_ref_half set InActive = 1 where id = ".$id);

		// logfile
		$company_id=$ws->company_id;
		$value = $ws->time_in. " to ".$ws->time_out;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Shift Table','logfile_time_shift_table','delete halfday shift : '.$value.' , id: '.$id.'','DELETE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Half Working Schedule, <strong>".$value."</strong>, is  Successfully Deleted!</div>");

		$this->session->set_flashdata('onload',"view(".$company_id.")");
		redirect(base_url().'app/time_shift_table/index',$this->data);
	}
	 // edit_wsc: edit working schedule rest day holiday
	public function edit_ws_rd_hol($id){
		$id = $this->uri->segment("4");
		//wsc : working schedule complete
		$this->data['ws_rd_hol'] = $this->time_shift_table_model->get_work_sched_rd_hol($id);
		$this->load->view('app/time/shift_table/edit_ws_rd_hol',$this->data);
	}

	// save_edit_ws_rd_hol: save edit working schedule restday holiday
	public function save_edit_ws_rd_hol(){
		$company_name = $this->input->post('company_name');
		$company_id = $this->input->post('company_id');

		$this->form_validation->set_rules("time_in_hr","Time IN","trim|required|callback_validate_edit_shift_rd_hol");
		$this->form_validation->set_rules("time_out_hr","Time OUT","trim|required");
		$this->form_validation->set_rules("no_of_hours","Registered Hours","trim|required");
		//$this->form_validation->set_rules("classification_id","Classification","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");
			// modify data
			$this->time_shift_table_model->save_edit_ws_rd_hol($id);

			$value = $id; // unique id
			
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Shift Table','logfile_time_shift_table','update rd/holiday shift : id: '.$value.'','UPDATE',$value);


			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Rest day / Holiday  Working Schedule Reference for <strong>".$company_name."</strong>, is Successfully Modified!</div>");

			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/time_shift_table/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}	
	}


	 // edit_wsc: edit working schedule complete/regular
	public function edit_wsc($id){
		$id = $this->uri->segment("4");
		//wsc : working schedule complete
		$this->data['wsc'] = $this->time_shift_table_model->get_work_sched_comp($id);
		$this->load->view('app/time/shift_table/edit_ws_regular',$this->data);
	}
	// save_edit_wsc: save edit working schedule regular/complete
	public function save_edit_wsc(){
		$company_name = $this->input->post('company_name');
		$company_id = $this->input->post('company_id');

		$this->form_validation->set_rules("time_in_hr","Time IN","trim|required|callback_validate_edit_shift");
		$this->form_validation->set_rules("time_out_hr","Time OUT","trim|required");
		$this->form_validation->set_rules("no_of_hours","Registered Hours","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");
			// modify data
			$this->time_shift_table_model->save_edit_wsc($id);

		// logfile

			$value = $id; // unique id
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Shift Table','logfile_time_shift_table','update regular shift : id: '.$value.'','UPDATE',$value);

			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Regular Working Schedule Reference for <strong>".$company_name."</strong>, is Successfully Modified!</div>");

			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/time_shift_table/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}	
	}
	// edit_wshd: edit working schedule half day
	public function edit_wshd($id){
		$id = $this->uri->segment("4");
		//wsc : working schedule half day
		$this->data['wshd'] = $this->time_shift_table_model->get_work_sched_half($id);
		$this->load->view('app/time/shift_table/edit_ws_half_day',$this->data);
	}
	// save_edit_wshd: save edit working schedule half day
	public function save_edit_wshd(){
		$company_name = $this->input->post('company_name');
		$company_id = $this->input->post('company_id');

		$this->form_validation->set_rules("time_in_hr","Time IN","trim|required|callback_validate_edit_shift_hd");
		$this->form_validation->set_rules("time_out_hr","Time OUT","trim|required");
		$this->form_validation->set_rules("no_of_hours","Registered Hours","trim|required");
		//$this->form_validation->set_rules("classification_id","Classification","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");
			// modify data
			$this->time_shift_table_model->save_edit_wshd($id);


			$value = $id; // unique id
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Shift Table','logfile_time_shift_table','update halfday shift : id: '.$value.'','UPDATE',$value);

			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Half Day Working Schedule Reference for <strong>".$company_name."</strong>, is Successfully Modified!</div>");

			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/time_shift_table/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}	
	}


	public function add_cf(){
        $company_id =$this->uri->segment('4');		
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->load->view('app/time/shift_table/add_controlled_flexi',$this->data);
	}
	public function save_add_cf(){
		$company_name=$this->input->post('company_name');
		$company_id = $this->input->post('company_id');

		$this->form_validation->set_rules("time_in_hr","Time IN","trim|required|callback_validate_cf_shift");
		$this->form_validation->set_rules("time_out_hr","Time OUT","trim|required");
		$this->form_validation->set_rules("no_of_hours","Registered Hours","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// audit trail in the model

			$this->time_shift_table_model->save_add_cf();
		
			$value = $company_name;

			$fullshift=$this->input->post('time_in_hr').":".$this->input->post('time_in_minute')." to ".$this->input->post('time_out_hr').":".$this->input->post('time_out_minute');

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  <strong>".$fullshift." : Controlled Flexi Working Schedule Reference </strong>, is Successfully Added!</div>");

			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/time_shift_table/index',$this->data);
		}else{

			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		
	}
	public function validate_cf_shift(){
foreach ($this->input->post('classification_id') as $key => $classification_id) {

		$company_name = $this->input->post('company_name');
		$company_id=$this->input->post('company_id');

		$time_in=$this->input->post('time_in_hr').":".$this->input->post('time_in_minute');
		$time_out=$this->input->post('time_out_hr').":".$this->input->post('time_out_minute');

		$shift=$time_in.$time_out;

		if($this->time_shift_table_model->validate_cf_shift($shift,$company_id,$classification_id)){
			$this->form_validation->set_message("validate_cf_shift","Regular Working Schedule , <strong>".$time_in." to ".$time_out."</strong>, Already Exists to ".$company_name."");
			return false;
		}else{
			return true;
		}
}
	}

	public function edit_controlled_flexi($id){
		$id = $this->uri->segment("4");
		//wsc : working schedule complete
		$this->data['ws_controlled'] = $this->time_shift_table_model->get_work_sched_controlled_flexi($id);
		$this->load->view('app/time/shift_table/edit_controlled_flexi',$this->data);
	}

	public function save_edit_controlled(){
		$company_name = $this->input->post('company_name');
		$company_id = $this->input->post('company_id');

		$this->form_validation->set_rules("time_in_hr","Time IN","trim|required|callback_validate_edit_controlled");
		$this->form_validation->set_rules("time_out_hr","Time OUT","trim|required");
		$this->form_validation->set_rules("no_of_hours","Registered Hours","trim|required");
		//$this->form_validation->set_rules("classification_id","Classification","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");
			// modify data
			$this->time_shift_table_model->save_edit_contFlexi($id);

			$value = $id; // unique id
			
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Shift Table','logfile_time_shift_table','update controlled flexi shift : id: '.$value.'','UPDATE',$value);


			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Controlled Flexi  Working Schedule Reference for <strong>".$company_name."</strong>, is Successfully Modified!</div>");

			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/time_shift_table/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}	
	}
	

	public function validate_edit_controlled(){

		$company_id = $this->input->post('company_id');
		$company_name=$this->input->post('company_name');
		$classification_id=$this->input->post('classification_id');

		$time_in=$this->input->post('time_in_hr').":".$this->input->post('time_in_minute');
		$time_out=$this->input->post('time_out_hr').":".$this->input->post('time_out_minute');

		$id = $this->uri->segment("4");
		$shift=$time_in.$time_out;

		if($this->time_shift_table_model->validate_edit_controlled($shift,$company_id,$classification_id,$id)){
			$this->form_validation->set_message("validate_edit_controlled","Restday/Holiday Working Schedule/Complete , <strong>".$time_in." to ".$time_out."</strong>, Already Exists to ".$company_name."");
			return false;
		}else{
			return true;
		}
	}

	public function delete_controlled(){

		$id = $this->uri->segment("4");
		//ws : working schedule
		$ws = $this->time_shift_table_model->get_work_sched_controlled_flexi($id);
		
		$this->db->query("update working_schedule_ref_controlled_flexi set InActive = 1 where id = ".$id);

		// logfile
		$company_id=$ws->company_id;
		$value = $ws->time_in. " to ".$ws->time_out;

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Shift Table','logfile_time_shift_table','delete controlled flexi shift : '.$value.' , id: '.$id.'','DELETE',$value);


		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Controlled Flexi Working Schedule, <strong>".$value."</strong>, is  Successfully Deleted!</div>");

		$this->session->set_flashdata('onload',"view(".$company_id.")");
		redirect(base_url().'app/time_shift_table/index',$this->data);
	}
}//end controller



