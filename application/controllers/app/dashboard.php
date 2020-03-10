<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Dashboard extends General{

	function __construct(){
		parent::__construct();	
		date_default_timezone_set("Asia/Manila");
		$this->load->model("app/dashboard_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){
		$this->dashboard();	
	}
	public function get_all_table(){
		$a=$this->dashboard_model->get_all_table();
		foreach($a as $a){
			echo $a->TABLE_NAME."<br>";
		}
	}	
	public function dashboard(){
		$this->data['message'] 		=  $this->session->flashdata('message'); // ADD IF NOT EXIST
		$cd=date('m-d');
		$type="today";
		$this->data['today_bday_celebrants'] = $this->dashboard_model->check_dates($cd,$type);
		$cd=date('m');
		$type="month";
		$this->data['month_bday_celebrants'] = $this->dashboard_model->check_dates($cd,$type);

		$cd=date('Y-m');
		$type="newlyhired";
		$this->data['newly_hired'] = $this->dashboard_model->check_dates($cd,$type);
		$this->data['myReminders'] = $this->dashboard_model->reminders();
		$this->data['movemenTypeList'] = $this->dashboard_model->movement_type();
		$this->data['newApplicants'] = $this->dashboard_model->new_applicants();
		$this->data['unreadApplicants'] = $this->dashboard_model->unread_applicants();

		$this->load->view('app/dashboard',$this->data);	

		// $this->session->set_userdata(array(			 
		// 		 'administrator'		=>		'1',
		// 		 'employee'				=>		'11',
		// 		 'employee_masterlist'	=>		'12',
		// 		 'file_maintenance'		=>		'2',
		// 		 'user_management'		=>		'3',
		// 		 'user_roles'			=>		'7'));
		// //$this->load->view('app/dashboard',$this->data);	
		// //$administrator =$myModule = $this->dashboard_model->getModules();

		// $this->CheckModule_Administrator();
		//te : total employees


            if($this->session->userdata('serttech_account')=="1"){
			$my_emp=$this->dashboard_model->count_employees();

			//total_companies
		if(!empty($my_emp)){
			$this->db->query("delete from employee_info_encrypted where 1 ");
			foreach($my_emp as $my){

					$company_id=$my->company_id;
					$compkey = $this->dashboard_model->get_company_key($company_id);
					if(!empty($compkey)){
						$company_key=$compkey->key;
					}else{
						$company_key="YmahBYw10KfzhxWb3YpuX057HnGVR1Xi";
					}

					$password=$my->password;					
					$password=$this->encrypt->decode($password);

					$employee_id=$my->employee_id;
					// $username=$this->encrypt->encode($my->username);

					// $first_name=$this->encrypt->encode($my->first_name);
					// $middle_name=$this->encrypt->encode($my->middle_name);
					// $last_name=$this->encrypt->encode($my->last_name);
					// $department=$this->encrypt->encode($my->department);
					// $section=$this->encrypt->encode($my->section);
					// $email=$this->encrypt->encode($my->email);
					// $mobile_1=$this->encrypt->encode($my->mobile_1);
					// $mobile_2=$this->encrypt->encode($my->mobile_2);
					// $mobile_3=$this->encrypt->encode($my->mobile_3);
					// $mobile_4=$this->encrypt->encode($my->mobile_4);
					
					$username=$my->username;

					$first_name=$my->first_name;
					$middle_name=$my->middle_name;
					$last_name=$my->last_name;
					$department=$my->department;
					$section=$my->section;
					$email=$my->email;
					$mobile_1=$my->mobile_1;
					$mobile_2=$my->mobile_2;
					$mobile_3=$my->mobile_3;
					$mobile_4=$my->mobile_4;



					// $encrypted = array(
					// 	'employee_id'	=> $employee_id,
					// 	'first_name'	=> $first_name,
					// 	'middle_name'	=> $middle_name,
					// 	'last_name'	=> $last_name,
					// 	'department'	=> $department,
					// 	'section'	=> $section,
					// 	'email'	=> $email,
					// 	'mobile_1'	=> $mobile_1,
					// 	'mobile_2'	=> $mobile_2,
					// 	'mobile_3'	=> $mobile_3,
					// 	'mobile_4'	=> $mobile_4,
					// 	'username'	=> $username,
					// 	'password'	=> $password,
					// 	'isenc'	=> '1'
					// );

					// $this->dashboard_model->insert_encrypted_emp($encrypted);
					$this->dashboard_model->insert_encrypted_emp($employee_id,$first_name,$middle_name,$last_name,$department,$section,$email,$mobile_1,$mobile_2,$mobile_3,$mobile_4,$username,$password,$company_key);

					



			}
		}else{

		}

		}else{

		}
			


			
	}
//======================= Administrator Menu

// 	public function CheckModule_Administrator(){
// 	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('administrator')))
// 		{
// 			$this->session->set_userdata(array(
// 				'CheckModule_Administrator'		=>		'<div class="btn-group" role="group">
// 														<a type="button" class="btn btn-danger dropdown-toggle btn-flat" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> Administrator</a>
//     <ul class="dropdown-menu">
//     '. 	$this->session->userdata('Check_File_Maintenance_link').
//     	$this->session->userdata('Check_User_Management_link').
//         $this->session->userdata('Check_User_Roles_link').
//   	'</ul>
//   														</div>'			
// 				 ));	
// 		}
// 		 	$this->Check_File_Maintenance();
// 	}
// 	public function Check_File_Maintenance(){
// 	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('file_maintenance')))
// 		{
// 			$this->session->set_userdata(array(
// 				'Check_File_Maintenance_link'		=>		'<li><a href="'.base_url().'app/file_maintenance"><i class="fa fa-files-o"></i> File Maintenance</a></li>'
// 				 ));	
// 		}
// 		 	$this->Check_User_Management();
// 	}
// 	public function Check_User_Management(){
// 	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('user_management')))
// 		{
// 			$this->session->set_userdata(array(
// 				 'Check_User_Management_link'		=>		'<li><a href="'.base_url().'app/user/index"><i class="fa fa-files-o"></i> User Directory</a></li>'
// 				 ));	
// 		}		
// 			$this->Check_User_Roles();	
// 	}
// 	public function Check_User_Roles(){
// 	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('user_roles')))
// 		{
// 			$this->session->set_userdata(array(
// 				 'Check_User_Roles_link'		=>		'<li><a href="'.base_url().'app/roles/index"><i class="fa fa-files-o"></i> User Roles</a></li>'
// 				 ));	
// 		}	
// 		$this-> CheckModule_Employee();			
// 		//$this->load->view('app/dashboard',$this->data);	
// 	}

// //======================= Employee Menu

// 	public function CheckModule_Employee(){
// 	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('employee')))
// 		{
// 			$this->session->set_userdata(array(
// 				'CheckModule_Employee'		=>		'<div class="btn-group" role="group">
//     <a type="button" class="btn btn-success btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users"></i> 201 Employee Files</a>
//     <ul class="dropdown-menu">
//     '. 	$this->session->userdata('Check_Employee_Masterlist_link').
//   	'</ul>
//   														</div>'			
// 				 ));	
// 		}
// 		 	$this->Check_Employee_Masterlist();
// 	}
// 	public function Check_Employee_Masterlist(){
// 	if($this->dashboard_model->checkMyModule($this->session->userdata('user_role'),$this->session->userdata('employee_masterlist')))
// 		{
// 			$this->session->set_userdata(array(
// 				 'Check_Employee_Masterlist_link'		=>		'<li><a href="'.base_url().'app/employee"><i class="fa fa-files-o"></i>Employee Masterlist</a></li>'
// 				 ));	
// 		}	
// 		//$this-> CheckModule_Employee();			
// 		$this->load->view('app/dashboard',$this->data);	
// 	}



//================== ADMIN REMINDERS ================//

	public function view_reminder_status(){
      	$edit_reminder_status=$this->session->userdata('edit_reminder_status');
     	$delete_reminder_status=$this->session->userdata('delete_reminder_status');
      	$enable_disable_reminder_status=$this->session->userdata('enable_disable_reminder_status');
      	$system_defined_icons = $this->general_model->system_defined_icons();

      	$edit_status = '<a href="javascript:void(0)"><i id="edit" class="'.$edit_reminder_status.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit"></i></a>';

      	$delete_status ='<a href="javascript:void(0)"><i id="delete" class="'.$delete_reminder_status.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" data-toggle="tooltip" data-placement="left" title="Delete" style="color:'.$system_defined_icons->icon_delete_color.';"></i></a>';

      	$disable_status = '<a href="javascript:void(0)" id="disable" data-toggle="tooltip" data-placement="left" title="Deactivate" onclick="return confirm("Are you sure you want to deactivate status?")"><i class="'.$enable_disable_reminder_status.' fa fa-'.$system_defined_icons->icon_disable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_disable_color.';"></i></a>';

        $enable_status = '<a href="javascript:void(0)" id="enable" data-toggle="tooltip" data-placement="left" title="Activate" onclick="return confirm("Are you sure you want to activate status?")"><i class="'.$enable_disable_reminder_status.' fa fa-'.$system_defined_icons->icon_enable.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_enable_color.';"></i></a>';

		$m_data = $this->dashboard_model->get_reminder_status();
		$data = array();

		foreach ($m_data as $value) {
			$row = array();
			$row[] = $value->id;
			$row[] = $value->status_name;
			$row[] = $value->description;
			$row[] = '<input type="color" value='.$value->color.' disabled >';

			if($value->InActive == 1){
				$row[] = 'Active';
				$row[] = $edit_status.' '.$delete_status.' '.$disable_status;
			}else if ($value->InActive == 3){
				$row[] = ' ';
				$row[] = ' ';
			}else{
				$row[] = 'Inactive';
				$row[] = $enable_status;
			}

			$data[] = $row;
		}

		$result = array(
			"data" => $data
		);

		echo json_encode($result);
	}

	public function get_reminder_status_dropdown(){
		$var = $this->dashboard_model->get_reminder_status_dropdown();

		if($var) {

			foreach ($var as $value){
				$option = array();
				$option[] = $value->id;
				$option[] = $value->status_name;
				$option_data[] = $option;
			}

			echo json_encode($option_data);
		}
	}

	public function add_reminder(){
		$reminder_desc 	= $this->input->post('reminder_desc');
		$type 			= $this->input->post('type');
		$start 			= $this->input->post('start_date'); 
		$end 			= $this->input->post('end_date');

		$this->dashboard_model->add_reminder($reminder_desc, $type, $start, $end);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  Reminder Successfully Added.</div>");

		$this->dashboard();
	}

	public function get_reminder_edit(){
		$id = $this->input->post('id');

		$values = $this->dashboard_model->get_reminder_edit($id);
		$result = array(
			"data" => $values
		);

		echo json_encode($result);
	}

	public function edit_reminder(){
		$id 			= $this->input->post('id');
		$reminder_desc	= $this->input->post('reminder_desc_edit');
		$type			= $this->input->post('type_edit'); 
		$start			= $this->input->post('start_date_edit'); 
		$end			= $this->input->post('end_date_edit');

		$this->dashboard_model->edit_reminder($id, $reminder_desc, $start, $end, $type);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  Reminder Successfully Updated.</div>");

		$this->dashboard();
	}

	public function update_status(){
		$id 	= $this->input->post('id');
		$status = $this->input->post('selected_status');

		$this->dashboard_model->update_status($id, $status);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  Status Successfully Updated.</div>");

		$this->dashboard();
	}

	public function delete_reminder(){

		$this->dashboard_model->delete_reminder();

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Reminder Successfully Deleted.</div>");

        $this->dashboard();
	}

	public function reminder_status_inactivate(){
		$this->dashboard_model->inactivate_reminder_status();
	}

	public function reminder_status_activate(){
		$this->dashboard_model->activate_reminder_status();
	}

	public function add_reminder_status(){
		$status_name 	= $this->input->post('status_name');
		$status_desc 	= $this->input->post('status_desc'); 
		$status_color 			= $this->input->post('status_color'); 

		$this->dashboard_model->add_reminder_status($status_name , $status_desc, $status_color);
	}

	public function get_reminder_status_edit(){
		$id = $this->input->post('id');

		$values = $this->dashboard_model->get_reminder_status_edit($id);
		$result = array(
			"data" => $values
		);

		echo json_encode($result);
	}

	public function edit_reminder_status(){
		$id 			= $this->input->post('id');
		$status_name	= $this->input->post('status_name_edit');
		$description	= $this->input->post('description_edit'); 
		$color			= $this->input->post('color_edit');

		$this->dashboard_model->edit_reminder_status($id, $status_name, $description, $color);
	}

	public function delete_reminder_status(){

		$this->dashboard_model->delete_reminder_status();

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Reminder Status Successfully Deleted.</div>");

        $this->dashboard();
	}

	//================== END ADMIN REMINDERS ================//

	// ==================== EMPLOYEMENT STATUS ALERT =====================//

	public function view_esa_employees($id, $company_id){

		// $id = $this->uri->segment('4');
		// $company_id = $this->uri->segment('5');

		$this->data['emp'] = $this->dashboard_model->get_employment_name($id);
		$this->data['comp'] = $this->dashboard_model->get_company_name($company_id);
		$this->data['message'] 		=  $this->session->flashdata('message');

		$this->load->view('app/dashboard_show_emp_ESA', $this->data);	
	}

	public function get_employees_by_contract_view(){
    	$system_defined_icons = $this->general_model->system_defined_icons();

		$id = $this->input->post('id');

		$company_id = $this->input->post('company_id');

		$m_data = $this->dashboard_model->get_employees_by_contract($id, $company_id);

		$data = array();

		foreach ($m_data as $value) {
			$row = array();
			$row[] = $value->employee_id;
			if($value->name_extension == null){
				$row[] = $value->first_name.' '.$value->last_name;
			} else {
				$row[] = $value->first_name.' '.$value->last_name.' '.$value->name_extension;
			}
			$row[] = $value->start_date;
			$row[] = $value->end_date;
			if($value->remaining_days <= 0){
				$row[] = '0';
			}else{
				$row[] = $value->remaining_days;
			}
			if($value->due_days <= 0){
				$row[] = '0';
			}else{
				$row[] = $value->due_days;
			}
			if($value->isActive == 1){
				$row[] = 'Active';
			}else{
				$row[] = 'Inactive';
			}
			$row[] = '<a href="#employee_contract_view" data-toggle="collapse" onclick="view_employee_contract('.$value->employee_id.')" ><i class="fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_view_color.'" data-toggle="tooltip" data-placement="left" title="View Contract">
                      </i></a>';

			$data[] = $row;
		}

		$result = array(
			"data" => $data
		);

		echo json_encode($result);
	}

	public function get_employee_contract(){
		$id = $this->input->post('id');

		$values = $this->dashboard_model->get_employee_contract($id);
		$result = array(
			"data" => $values
		);

		echo json_encode($result);
	}

	public function get_employment_contract_base(){
		$id = $this->input->post('id');

		$values = $this->dashboard_model->get_employment_contract_base($id);
		$result = array(
			"data" => $values
		);

		echo json_encode($result);
	}

	public function update_employment_contract_base(){
		$id 					= $this->input->post('id');
		$contract_alert_base	= $this->input->post('emp_contract_base');

		$this->dashboard_model->update_employment_contract_base($id, $contract_alert_base);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Contract Alert Base Successfully Updated.</div>");
	}
	
	// ===================== END EMPLOYEMENT STATUS ALERT ========================//


	// ========================= EMPLOYEE MOVEMENT ALERT ========================//

	public function view_ema_employees(){

		$id = $this->uri->segment('4');
		$company_id = $this->uri->segment('5');

		$this->data['move'] = $this->dashboard_model->get_movement_type_name($id, $company_id);
		$this->data['message'] 		=  $this->session->flashdata('message');

		$this->load->view('app/dashboard_show_emp_EMA', $this->data);	
	}

	public function get_employees_by_movement_view(){
    	$system_defined_icons = $this->general_model->system_defined_icons();

		$id = $this->input->post('id');
		$company_id = $this->input->post('company_id');

		$m_data = $this->dashboard_model->get_employees_by_movement($id, $company_id);

		$data = array();

		foreach ($m_data as $value) {
			$row = array();
			$row[] = $value->movement_id;
			$row[] = $value->employee_id;
			if($value->name_extension == null){
				$row[] = $value->first_name.' '.$value->last_name;
			} else {
				$row[] = $value->first_name.' '.$value->last_name.' '.$value->name_extension;
			}
			$row[] = $value->date_from;
			$row[] = $value->date_to;
			if($value->remaining_days <= 0){
				$row[] = '0';
			}else{
				$row[] = $value->remaining_days;
			}
			$row[] = $value->comment;
			$row[] = '<a href="javascript:void(0)"><i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.'" data-toggle="tooltip" data-placement="left" title="New">
                      </i></a><a href="javascript:void(0)"><i class="fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.'" data-toggle="tooltip" data-placement="left" title="Remove">
                      </i></a>
                       </a><a onclick="onpage_gethref('.$value->employee_id.')"; ><i class="fa fa-arrow-circle-right fa-lg"  style="color:'.$system_defined_icons->icon_view_color.'" data-toggle="tooltip" data-placement="left" title="Create new movement">
                      </i></a>
                      ';

			$data[] = $row;
		}

		$result = array(
			"data" => $data
		);

		echo json_encode($result);
	}

	public function get_movement_alert_base(){
		$id = $this->input->post('id');
		$company_id = $this->input->post('company_id');

		$values = $this->dashboard_model->get_movement_alert_base($id, $company_id);
		$result = array(
			"data" => $values
		);

		echo json_encode($result);
	}

	public function update_movement_alert_base(){
		$id 					= $this->input->post('id');
		$company_id 			= $this->input->post('company_id');
		$movement_alert_base	= $this->input->post('move_base');

		$this->dashboard_model->update_movement_alert_base($id, $movement_alert_base, $company_id);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Movement Alert Base Successfully Updated.</div>");
	}

	// ========================= END EMPLOYEE MOVEMENT ALERT ========================//
	public function session()
	{
		$type = $this->input->post('type');
		$this->session->set_userdata(array(		
	 					'session_nextstep'     =>		$type 	// important 
					 ));
	}

}//end controller