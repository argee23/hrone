<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Time_fixed_schedule extends General{

	public function __construct(){
		parent::__construct();
		$this->load->model("app/time_fixed_schedule_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();		
	}
	public function index(){	
		// user restriction function
		$this->session->set_userdata('page_name','time_fixed_schedule_li');
		$page_id = $this->general_model->getPageID();
		$userRole = $this->general_model->getUserLoggedIn($this->session->userdata('username'));
		if(General::has_rights_to_access($page_id->page_id,$userRole->user_role) == FALSE){
		
		$value = "Fixed Schedule";
		General::logfile('Fixed Schedule','TRY TO ACCESS',$value);	
		redirect(base_url().'access_denied'); // app/dashboard
			}
		// end of user restriction function		
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
			
		$this->load->view('app/time/fixed_schedule/index',$this->data);
 	}	
 	public function show_fixed_sched_group(){
		$company_id=$this->uri->segment('4');

		$this->data['company_departments'] = $this->general_model->get_company_departments($company_id);	
		$this->data['company_classifications'] = $this->general_model->get_company_classifications($company_id);	
		$this->data['fixed_sched_group'] = $this->time_fixed_schedule_model->getAll($company_id);	

		$this->load->view("app/time/fixed_schedule/show_fixed_sched_group",$this->data);	
	}
	public function add_group(){
		$company_id=$this->input->post('company_id');
		$comp_info = $this->general_model->get_company_info($company_id);
		$comp_division_setting=$comp_info->wDivision;

		$division=$this->input->post('division');
		$department=$this->input->post('department');
		$section=$this->input->post('section');

		if($section=="All"){
			$sub_sec_setting="";			
			$sub_section=""; // matic no matter what sub sections at query

		}else{
			$check_sub_section=$this->general_model->get_the_section($section);
			$sub_sec_setting=$check_sub_section->wSubsection;

		}

		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	


		$this->data['employee'] = $this->general_model->standard_filter_employees($company_id,$comp_division_setting,$sub_sec_setting);

		$this->load->view("app/time/fixed_schedule/add_group",$this->data);	
		
	}
	public function save_edit_group_name(){
		$group_name=$this->input->post('group_name');
		$group_id=$this->input->post('group_id');

			$group=$this->time_fixed_schedule_model->delete($group_id);
			$company_id=$group->company_id;

		$this->form_validation->set_rules("group_name","Group Name","trim|required|callback_validate_edit_group_name");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$this->time_fixed_schedule_model->update_group_name($group_id,$group_name);
			$value = $group_name;
			General::logfile('Fixed Working Schedule Group','UPDATE',$value);
				
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Fixed Working Schedule Group Name is Successfully Updated!</div>");

			$this->session->set_flashdata('onload',"get_fixed_sched_group(".$company_id.")");
			redirect(base_url().'app/time_fixed_schedule/index/',$this->data);

		}else{
			$this->session->set_flashdata('onload',"get_fixed_sched_group(".$company_id.")");
			$this->index();
		}	
	}
	public function validate_edit_group_name(){
		$group_id=$this->input->post('group_id');
		$group_name = $this->input->post("group_name");

			$group=$this->time_fixed_schedule_model->delete($group_id);
			$company_id=$group->company_id;

		if($this->time_fixed_schedule_model->validate_edit_group_name($group_id,$group_name,$company_id)){
			$this->form_validation->set_message("validate_edit_group_name"," Group Name:  <strong>".$group_name."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}
	public function delete_group(){
		$group_id=$this->uri->segment('4');

		$group=$this->time_fixed_schedule_model->delete($group_id);
		$company_id=$group->company_id;

		$this->db->query("delete from fixed_working_schedule_group where company_id='".$company_id."' and id = ".$group_id);	

		$this->db->query("delete from fixed_working_schedule_members where company_id='".$company_id."' and group_id = ".$group_id);	

		$value = $group->group_name;

		General::logfile('Fixed Working Schedule','DELETE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> : Fixed Working Schedule Group is Successfully Deleted!</div>");

		$this->session->set_flashdata('onload',"get_fixed_sched_group(".$company_id.")");
		redirect(base_url().'app/time_fixed_schedule/index/',$this->data);

		//$this->load->view("app/time/plot_schedule/admin_group_plot_sched",$this->data);	
	}
	public function view_fixed_schedule(){
		$this->load->view("app/time/fixed_schedule/view_fixed_sched",$this->data);
	}
	public function plot_fixed_schedule(){
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		$this->load->view("app/time/fixed_schedule/plot_fixed_sched",$this->data);
	}
	public function save_plot_fixed_sched(){
		$current_date=date('Y-m-d');
		$group_id=	$this->uri->segment('4');
		$company_id=	$this->uri->segment('5');

		$group_detail=$this->time_fixed_schedule_model->delete($group_id);
		$group_name=$group_detail->group_name;

		$members=$this->time_fixed_schedule_model->get_members_of_group($company_id,$group_id);  
		$payroll_period=$this->time_fixed_schedule_model->get_payroll_period($company_id);
	
	if(!empty($payroll_period)){
		foreach($payroll_period as $pp){
			$yy_from=$pp->year_from;
			$mm_from=$pp->month_from;
			$dd_from=$pp->day_from;

			$yy_to=	$pp->year_to;
			$mm_to=	$pp->month_to;
			$dd_to=	$pp->day_to;

	$from = $mm_from."/".$dd_from."/".$yy_from;
	$to = $mm_to."/".$dd_to."/".$yy_to;
	$to = date("m/d/Y",strtotime(date("m/d/Y", strtotime($to)) . " +1 days"));

	$ws_table='working_schedule_'.$mm_from;

	while($from!=$to){
		//$mon = date('M', strtotime($from));
		list($month, $day, $year) = explode("/", $from);
		$dauto = "$year-$month-$day";

		$group_members=$this->time_fixed_schedule_model->get_members_of_group($company_id,$group_id); //
		foreach($group_members as $member){
			$member_employee_id= $member->employee_id;

			//$data = $this->input->post($dauto.'_'.$member_employee_id);
			$mon = $this->input->post('mon_'.$member_employee_id);
			$tue = $this->input->post('tue_'.$member_employee_id);
			$wed = $this->input->post('wed_'.$member_employee_id);
			$thu = $this->input->post('thu_'.$member_employee_id);
			$fri = $this->input->post('fri_'.$member_employee_id);
			$sat = $this->input->post('sat_'.$member_employee_id);
			$sun = $this->input->post('sun_'.$member_employee_id);
			$restday="0";

$date = $dauto;

$day_type=date('D', strtotime($date));
if($day_type=="Mon"){
			$shift_in= substr($mon, 0,5);
			$shift_out= substr($mon, 9,5);

			$sched_type= substr($mon, 15,3);
				if($sched_type=="reg"){
					$ws_type="regular";
				}else if($sched_type=="hal"){
					$ws_type="half day";
				}else if($sched_type=="res"){
					$ws_type="restday-holiday";
				}else if($sched_type=="0"){
					$ws_type="";
				}else{
					$ws_type="code unknown"; // may mali sa slicing ng data
				}
				if($shift_in=="restd"){
					$shift_in="";
					$shift_out="";
					$restday="1";
				}else{}

}else if($day_type=="Tue"){
			$shift_in= substr($tue, 0,5);
			$shift_out= substr($tue, 9,5);

			$sched_type= substr($tue, 15,3);
				if($sched_type=="reg"){
					$ws_type="regular";
				}else if($sched_type=="hal"){
					$ws_type="half day";
				}else if($sched_type=="res"){
					$ws_type="restday-holiday";
				}else{
					$ws_type="code unknown"; // may mali sa slicing ng data
				}
				if($shift_in=="restd"){
					$shift_in="";
					$shift_out="";
					$restday="1";
				}else{}

}else if($day_type=="wed"){
			$shift_in= substr($wed, 0,5);
			$shift_out= substr($wed, 9,5);

			$sched_type= substr($wed, 15,3);
				if($sched_type=="reg"){
					$ws_type="regular";
				}else if($sched_type=="hal"){
					$ws_type="half day";
				}else if($sched_type=="res"){
					$ws_type="restday-holiday";
				}else{
					$ws_type="code unknown"; // may mali sa slicing ng data
				}
				if($shift_in=="restd"){
					$shift_in="";
					$shift_out="";
					$restday="1";
				}else{}

}else if($day_type=="Thu"){
			$shift_in= substr($thu, 0,5);
			$shift_out= substr($thu, 9,5);

			$sched_type= substr($thu, 15,3);
				if($sched_type=="reg"){
					$ws_type="regular";
				}else if($sched_type=="hal"){
					$ws_type="half day";
				}else if($sched_type=="res"){
					$ws_type="restday-holiday";
				}else{
					$ws_type="code unknown"; // may mali sa slicing ng data
				}
				if($shift_in=="restd"){
					$shift_in="";
					$shift_out="";
					$restday="1";
				}else{}

}else if($day_type=="Fri"){
			$shift_in= substr($fri, 0,5);
			$shift_out= substr($fri, 9,5);

			$sched_type= substr($fri, 15,3);
				if($sched_type=="reg"){
					$ws_type="regular";
				}else if($sched_type=="hal"){
					$ws_type="half day";
				}else if($sched_type=="res"){
					$ws_type="restday-holiday";
				}else{
					$ws_type="code unknown"; // may mali sa slicing ng data
				}
				if($shift_in=="restd"){
					$shift_in="";
					$shift_out="";
					$restday="1";
				}else{}

}else if($day_type=="Sat"){
			$shift_in= substr($sat, 0,5);
			$shift_out= substr($sat, 9,5);

			$sched_type= substr($sat, 15,3);
				if($sched_type=="reg"){
					$ws_type="regular";
				}else if($sched_type=="hal"){
					$ws_type="half day";
				}else if($sched_type=="res"){
					$ws_type="restday-holiday";
				}else{
					$ws_type="code unknown"; // may mali sa slicing ng data
				}
				if($shift_in=="restd"){
					$shift_in="";
					$shift_out="";
					$restday="1";
				}else{}

}else if($day_type=="Sun"){
			$shift_in= substr($sun, 0,5);
			$shift_out= substr($sun, 9,5);

			$sched_type= substr($sun, 15,3);
				if($sched_type=="reg"){
					$ws_type="regular";
				}else if($sched_type=="hal"){
					$ws_type="half day";
				}else if($sched_type=="res"){
					$ws_type="restday-holiday";
				}else{
					$ws_type="code unknown"; // may mali sa slicing ng data
				}
				if($shift_in=="restd"){
					$shift_in="";
					$shift_out="";
					$restday="1";
				}else{}
}
			$this->db->query("delete from ".$ws_table." where `date`='".$dauto."' and employee_id ='".$member_employee_id."' ");	
			$this->data = array(
					'date'				=> 	$dauto,
					'company_id'		=>	$company_id, //location
					'employee_id'		=> 	$member_employee_id,
					'mm'				=> 	$month,
					'dd'				=> 	$day,
					'yy'				=> 	$year,
					'shift_category'	=> 	$ws_type,
					'shift_in'			=> 	$shift_in,
					'shift_out'			=> 	$shift_out,
					'plotter'			=> 	$this->session->userdata('employee_id'),
					'restday'			=>	$restday,
					'date_plotted'		=> 	$current_date
				);	
			$this->db->insert($ws_table,$this->data);
		}

	$from=strtotime(date("m/d/Y", strtotime($from)) . " +1 days");
	$from = date("m/d/Y",$from);
	}
	// logfile

}
		$value = $yy_from."-".$mm_from."-".$dd_from. " to ".$yy_to."-".$mm_to."-".$dd_to;
		General::logfile('Group Working Schedule','INSERT',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$group_name." : Group Working Schedule for the Payroll Period <strong>".$value."</strong>, is  Successfully Added!</div>");
}
		// start fixed_working_schedule_group_members table 
		foreach($members as $member){
			$member_employee_id= $member->employee_id;
			$date_added= $member->date_added;

			$mon = $this->input->post('mon_'.$member_employee_id);
			$tue = $this->input->post('tue_'.$member_employee_id);
			$wed = $this->input->post('wed_'.$member_employee_id);
			$thu = $this->input->post('thu_'.$member_employee_id);
			$fri = $this->input->post('fri_'.$member_employee_id);
			$sat = $this->input->post('sat_'.$member_employee_id);
			$sun = $this->input->post('sun_'.$member_employee_id);

		$this->db->query("delete from fixed_working_schedule_members where `group_id`='".$group_id."' and employee_id ='".$member_employee_id."' ");	
		$this->data = array(
				'group_id'			=>	$group_id, //company id
				'company_id'		=>	$company_id, //company id
				'employee_id'		=> 	$member_employee_id,
				'system_user'		=> 	$this->session->userdata('employee_id'),
				'mon'				=> 	$mon,
				'tue'				=> 	$tue,
				'wed'				=> 	$wed,
				'thu'				=> 	$thu,
				'fri'				=> 	$fri,
				'sat'				=> 	$sat,
				'sun'				=> 	$sun,
				'date_added'		=> 	$date_added,
				'last_update'		=> 	$current_date
			);	
		$this->db->insert("fixed_working_schedule_members",$this->data);
		}
			// logfile
		$value = $group_id;
		General::logfile('Fixed Working Schedule','INSERT',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Fixed Working Schedule for Group : <strong>".$group_name."</strong>, is  Successfully Added!</div>");

		//$this->session->set_flashdata('onload',"get_fixed_sched_group(".$company_id.")");
		redirect(base_url().'app/time_fixed_schedule/plot_fixed_schedule/'.$group_id.'/'.$company_id,$this->data);
	}

	public function show_section(){
		$dept_id=$this->uri->segment("4");
		$this->data['get_section'] = $this->general_model->getSec($dept_id);

		$this->load->view('app/time/fixed_schedule/show_section',$this->data);
	}

	public function show_sub_section(){
		$section_id=$this->uri->segment("4");
		$section=$this->uri->segment("4");

		$this->data['check_section'] = $this->general_model->get_the_section($section);
		$this->data['get_sub_section'] = $this->general_model->get_sec_subsection($section_id);
		$this->load->view('app/time/fixed_schedule/show_sub_section',$this->data);
	}
	public function show_div_dept(){
		$company_id=$this->uri->segment("4");
		$division_id=$this->uri->segment("5");
		$this->data['get_div_dept'] = $this->general_model->get_company_division_departments($company_id,$division_id);

		$this->load->view('app/time/fixed_schedule/show_div_dept',$this->data);
	}	
}//controller