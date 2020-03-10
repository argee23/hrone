<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Time_settings extends General{

	public function __construct(){
		parent::__construct();
		$this->load->model("app/time_settings_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();		
	}
	public function index(){	
		// user restriction function
		// $this->session->set_userdata('page_name','time_settings_li');
		// $page_id = $this->general_model->getPageID();
		// $userRole = $this->general_model->getUserLoggedIn($this->session->userdata('username'));
		// if(General::has_rights_to_access($page_id->page_id,$userRole->user_role) == FALSE){
		
		// $value = "Time Settings";
		// General::logfile('Time Settings','TRY TO ACCESS',$value);	
		// redirect(base_url().'access_denied'); // app/dashboard
		// 	}
		// end of user restriction function		
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		//ts_topic: time settings
		//$this->data['ts_topic'] = $this->time_settings_model->getAll();		
		//$this->data['late_deduction_ref'] = $this->time_settings_model->late_deduction_reference();		
		$this->load->view('app/time/time_settings/index',$this->data);
	}	
	public function show_time_settings(){
		$company_id=$this->uri->segment('4');

		$this->data['myclassificationList'] = $this->general_model->get_company_classifications($company_id);		
		$this->data['ts_topic'] = $this->time_settings_model->getAll2($company_id);		
		$this->data['late_deduction_ref'] = $this->time_settings_model->late_deduction_reference2($company_id);		
		$this->load->view("app/time/time_settings/show_time_settings",$this->data);	
	}


	public function edit(){	
		$time_setting_id=$this->uri->segment('4');
		$company_id=$this->uri->segment('5');
		$this->data['myclassificationList'] = $this->general_model->get_company_classifications($company_id);			
		$this->data['ts_topic'] = $this->time_settings_model->get_time_setting_topic2($time_setting_id,$company_id);		
		$this->load->view('app/time/time_settings/edit',$this->data);
	}
	//single field setting updating
	public function modify(){
		$time_setting_id=$this->uri->segment('4');
		$company_id=$this->uri->segment('5');
		$topic=$this->time_settings_model->get_time_setting_topic2($time_setting_id,$company_id);

		$this->form_validation->set_rules("setting","Setting","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->time_settings_model->save_update($time_setting_id,$company_id);

	
			$value = $topic->time_setting_topic;

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Settings','logfile_time_settings',''.$value.$this->input->post('setting').'','UPDATE',$time_setting_id);

			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Settings of <strong>".$value."</strong> is Successfully Updated!</div>");


			//$this->session->set_flashdata('onload',"get_time_settings(".$company_id.")");
			redirect(base_url().'app/time_settings/index/70/'.$company_id,$this->data);
		}else{
			$this->session->set_flashdata('onload',"edit(".$time_setting_id.")");
			$this->index();
		}		
	}
	//COUNTING OF NO. OF DAYS/ REGULAR DAYS PRESENT(AUTO ADDITION/DEDUCTION FORMULA REFERENCE) updating
	public function modify_days_counting(){
		$time_setting_id=$this->uri->segment('4');
		$company_id=$this->uri->segment('5');
		$topic=$this->time_settings_model->get_time_setting_topic2($time_setting_id,$company_id);

		$this->form_validation->set_rules("countdays_present_option","Counting Option","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->time_settings_model->save_modify_days_counting($time_setting_id,$company_id);

			// logfile
			$value = $topic->time_setting_topic;
			General::logfile('Time Setting_'.$company_id,'MODIFY',$value);
			


			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Settings of <strong>".$value."</strong> is Successfully Updated!</div>");

			// redirect
			//$this->session->set_flashdata('onload',"edit(".$time_setting_id.")");
			redirect(base_url().'app/time_settings/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"edit(".$time_setting_id.")");
			$this->index();
		}		
	}
	//absent before the holiday updating
	public function modify_absent_bef_holiday(){
		$time_setting_id=$this->uri->segment('4');
		$company_id=$this->uri->segment('5');
		$topic=$this->time_settings_model->get_time_setting_topic2($time_setting_id,$company_id);

		$this->form_validation->set_rules("regular_holiday_multi_policy","Regular Holiday Absent Before the Holiday","trim|required");
		$this->form_validation->set_rules("snw_holiday_multi_policy","Special Holiday Absent Before the Holiday","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->time_settings_model->save_modify_absent_bef_holiday($time_setting_id,$company_id);


			$value = $topic->time_setting_topic;
			
            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Settings','logfile_time_settings',''.$value.$this->input->post('regular_holiday_multi_policy').'|'.$this->input->post('snw_holiday_multi_policy').'','UPDATE',$time_setting_id);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Settings of <strong>".$value."</strong> is Successfully Updated!</div>");
	
			$this->session->set_flashdata('onload',"edit(".$time_setting_id.")");
			redirect(base_url().'app/time_settings/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"edit(".$time_setting_id.")");
			$this->index();
		}		
	}
	//process employee with date hired on current period 
	public function modify_process_emp_with_datehired_on_cur_period(){
		$time_setting_id=$this->uri->segment('4');
		$company_id=$this->uri->segment('5');
		$topic=$this->time_settings_model->get_time_setting_topic2($time_setting_id,$company_id);

		$this->form_validation->set_rules("datehired_on_cur_period_sts","Save time summary","trim|required");
		$this->form_validation->set_rules("datehired_on_cur_period_dwa","Mark days without attendance as","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->time_settings_model->save_modify_process_emp_with_datehired_on_cur_period($time_setting_id,$company_id);

			$value = $topic->time_setting_topic;
			
            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Settings','logfile_time_settings',''.$value.$this->input->post('datehired_on_cur_period_sts').'|'.$this->input->post('datehired_on_cur_period_dwa').'','UPDATE',$time_setting_id);


			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Settings of <strong>".$value."</strong> is Successfully Updated!</div>");

			// redirect
			//$this->session->set_flashdata('onload',"edit(".$time_setting_id.")");
			redirect(base_url().'app/time_settings/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"edit(".$time_setting_id.")");
			$this->index();
		}		
	}
	//Case treated as halfday by the system due to count undertime as halfday absent policy 
	public function modify_case_ut_treated_as_halfday(){
		$time_setting_id=$this->uri->segment('4');
		$company_id=$this->uri->segment('5');
		$topic=$this->time_settings_model->get_time_setting_topic2($time_setting_id,$company_id);

		$this->form_validation->set_rules("ut_display_to_dtr","display undertime on dtr for representation purpose","trim|required");
		$this->form_validation->set_rules("ut_include_to_occurence","add to counting of undertime occurrence","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->time_settings_model->save_modify_case_ut_treated_as_halfday($time_setting_id,$company_id);

			$value = $topic->time_setting_topic;
			
            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Settings','logfile_time_settings',''.$value.$this->input->post('ut_display_to_dtr').'','UPDATE',$time_setting_id);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Settings of <strong>".$value."</strong> is Successfully Updated!</div>");

			// redirect
			//$this->session->set_flashdata('onload',"edit(".$time_setting_id.")");
			redirect(base_url().'app/time_settings/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"edit(".$time_setting_id.")");
			$this->index();
		}		
	}
	//Case treated as halfday by the system due to count late as halfday absent policy 
	public function modify_case_late_treated_as_halfday(){
		$time_setting_id=$this->uri->segment('4');
		$company_id=$this->uri->segment('5');
		$topic=$this->time_settings_model->get_time_setting_topic2($time_setting_id,$company_id);

		$this->form_validation->set_rules("late_display_to_dtr","display late on dtr for representation purpose","trim|required");
		$this->form_validation->set_rules("late_include_to_occurence","add to counting of late occurrence","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->time_settings_model->save_modify_case_late_treated_as_halfday($time_setting_id,$company_id);


			$value = $topic->time_setting_topic;
            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Settings','logfile_time_settings',''.$value.$this->input->post('late_display_to_dtr').'','UPDATE',$time_setting_id);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Settings of <strong>".$value."</strong> is Successfully Updated!</div>");

			// redirect
			//$this->session->set_flashdata('onload',"edit(".$time_setting_id.")");
			redirect(base_url().'app/time_settings/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"edit(".$time_setting_id.")");
			$this->index();
		}		
	}
	//Rest day auto match schedule
	public function modify_rd_auto_match_sched(){
		$time_setting_id=$this->uri->segment('4');
		$company_id=$this->uri->segment('5');
		$topic=$this->time_settings_model->get_time_setting_topic2($time_setting_id,$company_id);

		$this->form_validation->set_rules("rd_auto_match_sched_allow","Allow scheudle matching","trim|required");
		$this->form_validation->set_rules("rd_auto_match_sched_base_sched_at","Base schedule at","trim|required");
		$this->form_validation->set_rules("rd_auto_match_sched_match_at","Match schedule at","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->time_settings_model->save_modify_rd_auto_match_sched($time_setting_id,$company_id);

			$value = $topic->time_setting_topic;
			
            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Settings','logfile_time_settings',''.$value.$this->input->post('rd_auto_match_sched_allow').'|'.$this->input->post('rd_auto_match_sched_base_sched_at').'|'.$this->input->post('rd_auto_match_sched_match_at').'','UPDATE',$time_setting_id);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Settings of <strong>".$value."</strong> is Successfully Updated!</div>");

			// redirect
			//$this->session->set_flashdata('onload',"edit(".$time_setting_id.")");
			redirect(base_url().'app/time_settings/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"edit(".$time_setting_id.")");
			$this->index();
		}		
	}
	//
	public function modify_by_classification_and_employment(){
		$time_setting_id=$this->uri->segment('4');
		$company_id=$this->uri->segment('5');
		$topic=$this->time_settings_model->get_time_setting_topic2($time_setting_id,$company_id);
		$value = $topic->time_setting_topic;
		$this->db->query("delete from time_settings_value_".$company_id." where time_setting_id='".$time_setting_id."' ");	

			// save data
			$ccc = $this->general_model->get_company_classifications($company_id);
			$eee = $this->general_model->employmentList();
			//$array_edit="";
			foreach($ccc as $cl){
				foreach($eee as $empl){
				//$array_edit.=$tran_form->doc_no;
				$class_id=$cl->classification_id;
				$employment_id=$empl->employment_id;
				$input_name=$class_id.$employment_id;
				$input_value=$this->input->post($input_name);

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Settings','logfile_time_settings',''.$value.$employment_id.'|'.$input_name.'|'.$input_value.'','UPDATE',$time_setting_id);


				$this->data = array(
					'time_setting_id'				=>		$time_setting_id,
					'setting_value'					=>		$input_value,
					'classification'			    =>		$class_id,
					'employment'			    	=>		$employment_id
				);	
				$this->db->insert('time_settings_value_'.$company_id,$this->data);	
			}
			}	
			//===========night differential 0.13%
			if($time_setting_id=="3"){

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Settings','logfile_time_settings',''.$value.$this->input->post('night_diff_time_from').'|'.$this->input->post('night_diff_time_to').'','UPDATE',$time_setting_id);

				$this->data = array(
					'night_diff_time_from'			=> $this->input->post('night_diff_time_from'),
					'night_diff_time_to'			=> $this->input->post('night_diff_time_to')
			);	
				$this->db->where('time_setting_id',$time_setting_id);
				$this->db->update('time_settings_'.$company_id,$this->data);
			}else{ }			
			//===========regular night differential 
			if($time_setting_id=="8"){

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Settings','logfile_time_settings',''.$value.$this->input->post('reg_night_diff_time_from').'|'.$this->input->post('reg_night_diff_time_to').'','UPDATE',$time_setting_id);

				$this->data = array(
					'reg_night_diff_time_from'			=> $this->input->post('reg_night_diff_time_from'),
					'reg_night_diff_time_to'			=> $this->input->post('reg_night_diff_time_to')
			);	
				$this->db->where('time_setting_id',$time_setting_id);
				$this->db->update('time_settings_'.$company_id,$this->data);
			}else{ }			
			

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Settings of <strong>".$value."</strong> is Successfully Updated!</div>");

			// redirect
			//$this->session->set_flashdata('onload',"get_time_settings(".$company_id.")");
			//$this->session->set_flashdata('onload',"edit(".$time_setting_id.")");
			redirect(base_url().'app/time_settings/index',$this->data);			
	}
	public function add_late_deduction_reference(){
		$this->load->view('app/time/time_settings/add_late_deduction_reference',$this->data);
	}
	public function save_add_late_deduction_reference(){
		$company_id=$this->uri->segment('4');
		$location_name=$this->time_settings_model->get_location($company_id);
		$loc_name=$location_name->company_name;

		$this->form_validation->set_rules("from_minute","From Minute","trim|callback_validate_from_minute");
		$this->form_validation->set_rules("to_minute","To Minute","trim|callback_validate_add_reference");
		$this->form_validation->set_rules("deduction","Equivalent Deduction","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->time_settings_model->save_add_late_deduction_reference($company_id);
			
			$value = $loc_name." : Late Deduction Reference";
			
            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Settings','logfile_time_settings',''.$value.$this->input->post('from_minute').'|'.$this->input->post('to_minute').'|'.$this->input->post('deduction').'','INSERT',$company_id);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  <strong>".$value."</strong> is Successfully Added!</div>");

			// redirect
			redirect(base_url().'app/time_settings/index',$this->data);
		}else{			
			$this->index();
		}		

	}
	public function validate_from_minute(){
		$value = "Late Deduction Reference";
		$from_minute=$this->input->post('from_minute');
		$to_minute=$this->input->post('to_minute');

		if($from_minute>$to_minute){
			$this->form_validation->set_message("validate_from_minute"," From Minute Field of <strong>".$value."</strong>, must be lesser than To Minute Field");
			return false;
		}else{
			return true;
		}
	}
	public function validate_add_reference(){
		$company_id=$this->input->post('company_id');

		$location_name=$this->time_settings_model->get_location($company_id);
		$loc_name=$location_name->company_name;

		$value = $loc_name." : Late Deduction Reference";
		$from_minute=$this->input->post('from_minute');
		$to_minute=$this->input->post('to_minute');

		if($this->time_settings_model->validate_add_reference($company_id)){
			$this->form_validation->set_message("validate_add_reference","<strong>".$value. " From Minute: ".$from_minute."   To Minute: ".$to_minute."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}
	public function validate_edit_reference(){
		$company_id= $this->input->post('company_id');

		$location_name=$this->time_settings_model->get_location($company_id);
		$loc_name=$location_name->company_name;

		$value = $loc_name." : Late Deduction Reference";
		$from_minute=$this->input->post('from_minute');
		$to_minute=$this->input->post('to_minute');

		if($this->time_settings_model->validate_edit_reference($company_id)){
			$this->form_validation->set_message("validate_edit_reference","<strong>".$value. " From Minute: ".$from_minute."   To Minute: ".$to_minute."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}
	public function edit_late_deduction_reference(){
		//late_ded_id: late deduction id
		$late_ded_id=$this->uri->segment('4');
		$company_id=$this->uri->segment('5');

		$this->data['late_deduction_ref'] = $this->time_settings_model->get_late_deduction_reference($late_ded_id,$company_id);
		$this->load->view('app/time/time_settings/edit_late_deduction_reference',$this->data);
	}

	public function save_edit_late_deduction_reference(){

		$late_ded_id= $this->input->post('late_ded_id');
		$company_id= $this->input->post('company_id');

		$location_name=$this->time_settings_model->get_location($company_id);
		$loc_name=$location_name->company_name;

		$this->form_validation->set_rules("from_minute","From Minute","trim|callback_validate_from_minute");
		$this->form_validation->set_rules("to_minute","To Minute","trim|callback_validate_edit_reference");
		$this->form_validation->set_rules("deduction","Equivalent Deduction","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->time_settings_model->save_edit_late_deduction_reference($late_ded_id,$company_id);

			$value = $loc_name." : Late Deduction Reference";
			
            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Settings','logfile_time_settings',''.$value.$this->input->post('from_minute').'|'.$this->input->post('to_minute').'|'.$this->input->post('deduction').'','UPDATE',$late_ded_id);


			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  <strong>".$value."</strong> is Successfully Updated!</div>");

			// redirect
			//$this->session->set_flashdata('onload',"edit_late_deduction_reference(".$late_ded_id.")");
			redirect(base_url().'app/time_settings/index',$this->data);
		}else{			
			$this->index();
		}		
	}
	public function delete_late_deduction_reference(){

		$late_ded_id = $this->uri->segment('4');
		$company_id = $this->uri->segment('5');

		$location_name=$this->time_settings_model->get_location($company_id);
		$loc_name=$location_name->company_name;

		$late_ded_reference = $this->time_settings_model->get_late_deduction_reference($late_ded_id,$company_id);
		
		$this->db->query("delete from late_deduction_reference_".$company_id." where id = ".$late_ded_id);
		$value = "From Minute: ".$late_ded_reference->from_minute. " To Minute: ". $late_ded_reference->to_minute;
			
            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            General::system_audit_trail('Time','Time Settings','logfile_time_settings',''.$value.'','DELETE',$late_ded_id);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$loc_name." : Late Deduction Reference, <strong>".$value."</strong>, is  Successfully Deleted!</div>");

		redirect(base_url().'app/time_settings/index',$this->data);
	}

	public function validate_add_flexi_employee(){
		$company_id=$this->uri->segment('4');
		$location_name=$this->time_settings_model->get_location($company_id);
		$loc_name=$location_name->company_name;

		$value = $loc_name. " : Flexi Schedule";
		$employee_id=$this->input->post('employee');
		$employee_string=$this->input->post('employee_string');

		if($this->time_settings_model->validate_add_flexi_employee($employee_id,$company_id)){
			$this->form_validation->set_message("validate_add_flexi_employee","<strong>[ ".$loc_name. " ] ".$employee_string. "</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}
	public function individual_flexi_add(){

		$time_setting_id=$this->uri->segment('4');
		$company_id=$this->uri->segment('5');
		$this->load->view('app/time/time_settings/flexi_employee_add',$this->data);
	}
	public function save_flexi_employee_add(){
		$employee=$this->input->post('employee_string');

		$company_id=$this->uri->segment('4');
		$location_name=$this->time_settings_model->get_location($company_id);
		$loc_name=$location_name->company_name;

		$this->form_validation->set_rules("monday","Monday","trim|required");
		$this->form_validation->set_rules("tuesday","Tuesday","trim|required");
		$this->form_validation->set_rules("wednesday","Wednesday","trim|required");
		$this->form_validation->set_rules("thursday","Thursday","trim|required");
		$this->form_validation->set_rules("friday","Friday","trim|required");
		$this->form_validation->set_rules("saturday","Saturday","trim|required");
		$this->form_validation->set_rules("sunday","Sunday","trim|required");
		$this->form_validation->set_rules("base_on_actual_time_in","Actual Time IN Basis","trim|required");
		$this->form_validation->set_rules("shift_hours","Shift Hours","trim|required");
		$this->form_validation->set_rules("employee","Employee","trim|callback_validate_add_flexi_employee");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->time_settings_model->save_flexi_employee_add($company_id);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  <strong>Flexi Schedule of ".$value."</strong> [ ".$loc_name. " ] is Successfully Added!</div>");

			// redirect
			redirect(base_url().'app/time_settings/index',$this->data);
		}else{			
			$this->index();
		}		

	}
	public function showSearchEmployee(){

		$val=$this->uri->segment('4');
		$company_id=$this->uri->segment('5');

		$this->data['showEmployeeList'] = $this->time_settings_model->getSearch_Employee($val,$company_id); //getEmp //getSearch_Employee
		$this->load->view("app/time/time_settings/showEmployeeList",$this->data);	
	}
	public function select_emp(){	
		$selected_emp=$this->uri->segment('4');	
		$company_id=$this->uri->segment('5');

		$this->data['emp'] = $this->time_settings_model->get_selected_emp($selected_emp,$company_id);
		
		$this->load->view('app/time/time_settings/show_employee',$this->data);
	}

	public function individual_flexi_edit(){
		//late_ded_id: late deduction id
		$flexi_id=$this->uri->segment('4');
		$company_id = $this->uri->segment('5');

		$this->data['flexi_emp'] = $this->time_settings_model->get_individual_flexi($flexi_id,$company_id);
		$this->load->view('app/time/time_settings/flexi_employee_edit',$this->data);
	}

	public function save_flexi_employee_edit(){
		$employee=$this->input->post('employee_string');
		$flexi_id=$this->input->post('flexi_id');
		$company_id=$this->input->post('company_id');

		$location_name=$this->time_settings_model->get_location($company_id);
		$loc_name=$location_name->company_name;

		$this->form_validation->set_rules("monday","Monday","trim|required");
		$this->form_validation->set_rules("tuesday","Tuesday","trim|required");
		$this->form_validation->set_rules("wednesday","Wednesday","trim|required");
		$this->form_validation->set_rules("thursday","Thursday","trim|required");
		$this->form_validation->set_rules("friday","Friday","trim|required");
		$this->form_validation->set_rules("saturday","Saturday","trim|required");
		$this->form_validation->set_rules("sunday","Sunday","trim|required");
		$this->form_validation->set_rules("base_on_actual_time_in","Actual Time IN Basis","trim|required");
		$this->form_validation->set_rules("shift_hours","Shift Hours","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->time_settings_model->save_flexi_employee_edit($flexi_id,$company_id);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  <strong>[ ".$loc_name." ] : Flexi Schedule of ".$value."</strong> is Successfully Updated!</div>");

			// redirect
			//$this->session->set_flashdata('onload',"individual_flexi_edit(".$flexi_id.")");
			redirect(base_url().'app/time_settings/index',$this->data);
		}else{	
			$this->session->set_flashdata('onload',"individual_flexi_edit(".$flexi_id.")");		
			$this->index();
		}		
	}

	public function individual_flexi_delete(){

		$flexi_id = $this->uri->segment('4');
		$company_id = $this->uri->segment('5');

		$location_name=$this->time_settings_model->get_location($company_id);
		$loc_name=$location_name->company_name;

		$flexi_sched_emp = $this->time_settings_model->get_individual_flexi($flexi_id,$company_id);
		
		$this->db->query("delete from time_flexi_".$company_id." where id = ".$flexi_id);

			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$loc_name." : Flexi Schedule of  <strong>".$value."</strong>, is  Successfully Deleted!</div>");

		redirect(base_url().'app/time_settings/index',$this->data);
	}

	//minimum minutes/hour per leave filing

	public function add_minimum_hour_mins_perhour_leave($company_id,$table)
	{
		$this->data['table'] = $table;
		$this->load->view('app/time/time_settings/add_hour_mins_perhour_leave',$this->data);
	}

	public function save_hour_mins_perhour_leave($company_id)
	{
		$table = $this->input->post('table');
		$insert = $this->time_settings_model->save_hour_mins_perhour_leave($company_id,$table);
		if($insert=='inserted')
		{
			if($table=='time_settings_minimum_hours_mins'){ $val = " : Minimum hours/minutes for per hour leave"; } else{ $val=" : Allowed per hour leave filing"; }
			$value = $this->input->post('computed_hours_mins').$val;
	            /*
	            --------------audit trail composition--------------
	            (module,module dropdown,logfiletable,detailed action,action type,key value)
	            --------------audit trail composition--------------
	            */
	        General::system_audit_trail('Time','Time Settings','logfile_time_settings',''.$value,'INSERT',$company_id);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Minimum Hours/minutes to filed per hour '".$this->input->post('computed_hours_mins')."' is  Successfully Added!</div>");
		}
		else
		{
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error.</div>");
		}
		redirect(base_url().'app/time_settings/index',$this->data);
	}

	public function delete_hours_minutes($table,$id,$company_id){

		$data = $this->time_settings_model->get_minimum_hours_minutes_details($id,$table);
		$delete = $this->time_settings_model->delete_minimum_hours_minutes($id,$table);
		if($delete=='deleted')
		{
			if($table=='time_settings_minimum_hours_mins'){ $val = ": Minimum hours/minutes for per hour leave"; } else{ $val=": Allowed per hour leave filing"; }
			$value = $data.$val;
	            /*
	            --------------audit trail composition--------------
	            (module,module dropdown,logfiletable,detailed action,action type,key value)
	            --------------audit trail composition--------------
	            */
	        General::system_audit_trail('Time','Time Settings','logfile_time_settings',''.$value,'DELETE',$company_id);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Minimum Hours/minutes to filed per hour setting '".$data."' is  Successfully deleted!</div>");
		}
		else
		{
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error.</div>");
		}
		redirect(base_url().'app/time_settings/index',$this->data);
	}


	public function status_hours_minutes($table,$id,$company_id,$option)
	{
		$data = $this->time_settings_model->get_minimum_hours_minutes_details($id,$table);
		$status = $this->time_settings_model->status_minimum_hours_minutes($id,$option,$table);
		if($option==1){ $stat= 'Enabled'; } else { $stat='Disabled'; }
		if($status=='updated')
		{
			if($table=='time_settings_minimum_hours_mins'){ $val = " : Minimum hours/minutes for per hour leave"; } else{ $val=" : Allowed per hour leave filing"; }

			$value = "".$stat." ID ".$id.$val;
	            /*
	            --------------audit trail composition--------------
	            (module,module dropdown,logfiletable,detailed action,action type,key value)
	            --------------audit trail composition--------------
	            */
	        General::system_audit_trail('Time','Time Settings','logfile_time_settings',''.$value,strtoupper($stat),$company_id);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Setting ID ".$id." is Successfully ".$stat."!</div>");
		}
		else
		{
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error.</div>");
		}
		redirect(base_url().'app/time_settings/index',$this->data);
	}
}//controller