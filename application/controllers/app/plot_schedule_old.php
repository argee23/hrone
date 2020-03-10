<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Plot_schedule extends General{


	public function __construct(){
		parent::__construct();
		$this->load->dbforge();
		$this->load->model('app/plot_schedule_model');
		$this->load->model('app/transaction_employees_model');
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index(){	//$year=null,$month=null
		
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->load->view('app/time/plot_schedule/index',$this->data);	
		// $this->display();    	
	}	
	// public function display($year=null,$month=null){
	// 		$this->data['calendar']=$this->plot_schedule_model->aa($year,$month);
	// 		$this->load->view('app/time/plot_schedule/samp',$this->data);	
	// }
	public function remove_schedule(){
		$date_id=$this->uri->segment('4'); 
		$employee_id=$this->uri->segment('5');
		
		$month=substr($date_id, 5,2);
	    $day=substr($date_id, 8,2);
	    $year=substr($date_id, 0,4);

		$this->db->query("delete from working_schedule_".$month." where `date` ='".$date_id."' AND `employee_id` ='".$employee_id."' ");
		redirect(base_url().'app/plot_schedule/next_prev_month/'.$year.'/'.$month.'/'.$employee_id,$this->data);		
		// $this->next_prev_month();
	}
	public function showSearchEmployee($val = NULL){

		$this->data['showEmployeeList'] = $this->plot_schedule_model->getSearch_Employee($val); //getEmp //getSearch_Employee
		$this->load->view("app/time/plot_schedule/showEmployeeList",$this->data);	
	}
	public function show_employees(){

		$this->data['showEmployeeList'] = $this->plot_schedule_model->show_employees(); //getEmp //getSearch_Employee
		$this->load->view("app/time/plot_schedule/showEmployeeList",$this->data);	
	}

	public function select_emp($year=null,$month=null){	
		$selected_emp=$this->uri->segment('4');	

		$this->data['emp'] = $this->plot_schedule_model->get_selected_emp($selected_emp);

		$emp_info = $this->plot_schedule_model->get_employee($selected_emp);
		$company_id=$emp_info->company_id;//"1";

	
		$year=date('Y'); //current year
		$month=date('m');

		$this->data['calendar']=$this->plot_schedule_model->generate($year,$month,$selected_emp,$company_id);
	
		$this->load->view('app/time/plot_schedule/show_employee',$this->data);
	}
	public function select_emp_add_ws($year=null,$month=null){	
		$selected_emp=$this->uri->segment('4');	
		//$selected_emp=substr($val, 6,5);

		$this->data['emp'] = $this->plot_schedule_model->get_selected_emp($selected_emp);

		$emp_info = $this->plot_schedule_model->get_employee($selected_emp);
		$company_id=$emp_info->company_id;//"1";


		$this->db->where(array(
			'employee_id'	=>		$selected_emp
			));
		
		$query = $this->db->get('employee_info');
			if($query->num_rows() > 0){
				$year=date('Y'); //current year
				$month=date('m');
			}else{
				$year="2017";
				$month="12";	
			}

		$this->data['calendar']=$this->plot_schedule_model->generate($year,$month,$selected_emp,$company_id);

		$this->load->view('app/time/plot_schedule/show_employee',$this->data);
	}
	public function next_prev_month($year,$month){	

		$selected_emp= $this->uri->segment('6');	//"10001";

		$this->data['emp'] = $this->plot_schedule_model->get_selected_emp($selected_emp);
		$emp_info = $this->plot_schedule_model->get_employee($selected_emp);
		$company_id=$emp_info->company_id;//"1";

		$this->data['calendar']=$this->plot_schedule_model->generate($year,$month,$selected_emp,$company_id);
		$this->load->view('app/time/plot_schedule/calendar',$this->data);
	}
	//add_ws : add working schedule
	public function add_ws(){

	  	$add_date=$this->uri->segment('4');
		$month=substr($add_date, 4,2);

		$day_length=substr($add_date, 6,3);
		$dl= strlen($day_length);

		if($dl=="1"){
			$day= "0".$day_length;
		}else{
			$day= $day_length;
		}
   		$year=substr($add_date, 0,4);

		$the_date=$year.'-'.$month.'-'.$day;
	  	//ws: working schedule
		$ws=urldecode($this->uri->segment('5'));
	
		  	$working_schedule=substr($ws, 4,40); // working sched
		  	$working_schedule_type=substr($ws, 0,4); // working sched type (regular/wholeday, halfday, restday-holiday)

	if($working_schedule_type=="reg_"){
		$ws_type="regular";
	}else if($working_schedule_type=="haf_"){
		$ws_type="halfday";
	}else if($working_schedule_type=="rdh_"){
		$ws_type="restday-holiday";
	}else{
		$ws_type="code unknown";
	}
			$shift_in= substr($ws, 4,5);
			$shift_out= substr($ws, 13,5);
			//employee id
			$selected_emp= $this->uri->segment('6');
			$company_id= $this->uri->segment('7');

			$current_date=date('Y-m-d');

			if (($working_schedule_type=="reg_")OR($working_schedule_type=="haf_")OR($working_schedule_type=="rdh_")) { //detect if may selected na shift sched

				$this->data = array(
					'date'				=> 	$the_date,
					'company_id'		=>	$company_id, //location
					'employee_id'		=> 	$selected_emp,
					'mm'				=> 	$month,
					'dd'				=> 	$day,
					'yy'				=> 	$year,
					'shift_category'		=> 	$ws_type,
					'shift_in'			=> 	$shift_in,
					'shift_out'			=> 	$shift_out,
					'plotter'			=> 	$this->session->userdata('employee_id'),
					'date_plotted'		=> 	$current_date
				);	
				$this->db->insert('working_schedule_'.$month,$this->data);

		// $this->data['emp'] = $this->plot_schedule_model->get_selected_emp($selected_emp);
		// $emp_info = $this->plot_schedule_model->get_employee($selected_emp);
		// $company_id=$emp_info->company_id;//"1";

		//  $this->data['calendar']=$this->plot_schedule_model->generate($year,$month,$selected_emp,$company_id);
		//  $this->load->view('app/time/plot_schedule/samp',$this->data);		
		
		}else{
				 $this->load->view('app/time/plot_schedule/show_employee',$this->data);
		}	
	
	}

	public function unlock_pay_period(){

		$id = $this->uri->segment("4");
		//pp : payroll period
		$pp = $this->plot_schedule_model->lock_unlock_get_pay_period($id);
		
		$this->db->query("update payroll_period set IsLock = 0 where id = ".$id);

		// logfile
		$value = $pp->month_from."-".$pp->day_from."-".$pp->year_from. " to ".$pp->month_to."-".$pp->day_to."-".$pp->year_to;
		General::logfile('Payroll Period','UNLOCK',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Payroll Period <strong>".$value."</strong>, is  Successfully UNLOCK!</div>");

		redirect(base_url().'app/plot_schedule/index',$this->data);
		
	}
	public function lock_pay_period(){
		$id = $this->uri->segment("4");
		//pp : payroll period
		$pp = $this->plot_schedule_model->lock_unlock_get_pay_period($id);
		
		$this->db->query("update payroll_period set IsLock = 1 where id = ".$id);

		// logfile
		$value = $pp->month_from."-".$pp->day_from."-".$pp->year_from. " to ".$pp->month_to."-".$pp->day_to."-".$pp->year_to;
		General::logfile('Payroll Period','LOCK',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Payroll Period <strong>".$value."</strong>, is  Successfully LOCKED!</div>");

		redirect(base_url().'app/plot_schedule/index',$this->data);

	}

	public function lock_plotting_of_schedule(){

		$this->load->view('app/time/plot_schedule/lock_plotting_of_schedule',$this->data);
	}
	// show section managers with group created
	public function show_managers(){
		$company_id=$this->uri->segment('4');

		$this->data['company_id']=$company_id;
		$this->data['managers'] = $this->plot_schedule_model->get_sec_man_with_emp_group($company_id); //getEmp //getSearch_Employee
		$this->load->view("app/time/plot_schedule/show_managers",$this->data);	
	}
	public function show_groups_by_admin(){
		$company_id=$this->uri->segment('4');

		 $this->data['company_id']=$company_id;
		 $this->data['groups'] = $this->plot_schedule_model->get_groups_by_admin($company_id); //getEmp //getSearch_Employee
		$this->load->view("app/time/plot_schedule/show_groups_by_admin",$this->data);	
	}
	// show all groups under selected location
	public function show_all_groups(){
		$company_id=$this->uri->segment('4');

		$this->data['company_id']=$company_id;
		$this->data['groups'] = $this->plot_schedule_model->get_all_groups($company_id); 
		//$this->data['members'] = $this->plot_schedule_model->get_members($key_location,$group_id);
		$this->load->view("app/time/plot_schedule/show_all_groups",$this->data);	
	}
	// show groups created by selected section manager  
	public function show_group(){
		$manager=$this->uri->segment('4');
		$company_id=$this->uri->segment('5');

		$this->data['company_id']=$company_id;
		$this->data['groups'] = $this->plot_schedule_model->get_groups($company_id,$manager); //getEmp //getSearch_Employee
		$this->load->view("app/time/plot_schedule/show_groups",$this->data);	
	}
	// show members of selected groups created by selected section manager    	
	public function show_members(){
		$group_id=$this->uri->segment('4');
		
		$key_location=$this->uri->segment('5');

		$this->data['key_location']=$key_location;
		$this->data['members'] = $this->plot_schedule_model->get_members($key_location,$group_id); //getEmp //getSearch_Employee
		$this->load->view("app/time/plot_schedule/show_group_members",$this->data);	
	}


	public function delete_group(){
		$group_id=$this->uri->segment('4');

		$group=$this->plot_schedule_model->delete($group_id);
		$company_id=$group->company_id;

		$this->db->query("update working_schedule_group_by_administrator set InActive='1' where id = ".$group_id);	

		$this->db->query("delete from working_schedule_group_by_administrator_members where group_id = ".$group_id);	

		$value = $group->group_name;

		General::logfile('Working Schedule Group by Administrator','DELETE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> : Working Schedule Group created by administrator is Successfully Deleted!</div>");

		$this->session->set_flashdata('onload',"view_location_ws_group_by_admin(".$company_id.")");
		redirect(base_url().'app/plot_schedule/index/',$this->data);

		//$this->load->view("app/time/plot_schedule/admin_group_plot_sched",$this->data);	
	}	
	// public function add_group(){
	// 	$this->data['onload']	=	$this->session->flashdata('onload');
	// 	$this->data['message']	=	$this->session->flashdata('message');
	// }

	public function add_group(){
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		$this->load->view("app/time/plot_schedule/add_group",$this->data);	
		
	}
	public function save_add_group(){
		$company_id=	$this->uri->segment('4');
		$location=	$this->uri->segment('5');
		$classification=	$this->uri->segment('6');
		$department=	$this->uri->segment('7');
		$section=	$this->uri->segment('8');
		$group_name=$this->input->post('group_name');
		$cd=date('Y-m-d');//current date

		$this->data = array(
			'company_id'					=>		$company_id,
			'location'						=>		$location,
			'classification'				=>		$classification,
			'department'					=>		$department,
			'section'						=>		$section,
			'manager_in_charge'				=>		$this->session->userdata('employee_id'),
			'group_name'					=>		$group_name,
			'date_created'					=>		$cd,
			'InActive'						=>		0
		);	
		$this->db->insert("working_schedule_group_by_administrator",$this->data);
		$insert_id = $this->db->insert_id();

		//delete if already exist
		foreach ($this->input->post('selected_employee') as $key => $key_value)
		{
			$this->db->query("delete from working_schedule_group_by_administrator_members where company_id='".$company_id."' and  employee_id = ".$key_value);

			$value = $key_value;
			General::logfile('Working Schedule Group By Administrator Members','DELETE',$value);
		}
		
		// then insert
		foreach ($this->input->post('selected_employee') as $key => $key_value)
		{
			$this->data = array(
				'employee_id'	=>		$key_value,
				'company_id'	=>		$company_id,
				'date_register'	=>		$cd,
				'group_id'		=>		$insert_id
			);
			$this->db->insert("working_schedule_group_by_administrator_members",$this->data);

			$value = $key_value;
			General::logfile('Working Schedule Group By Administrator Members','INSERT',$value);
		}

$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong> Plotting Schedule Group Name and members : ".$group_name." is Successfully Added!</strong> </div>");	



redirect(base_url().'app/plot_schedule/index',$this->data);		


	}
	public function admin_group_plot_sched(){

		$this->load->view("app/time/plot_schedule/admin_group_plot_sched",$this->data);	
		
	}
	public function admin_group_plot_sched_2(){

		$this->data['selected_payroll_period']=$this->uri->segment('4');
		$this->data['company_id']=$this->uri->segment('5');
		$this->data['group_id']=$this->uri->segment('6');
		$this->load->view("app/time/plot_schedule/admin_group_plot_sched_2",$this->data);	

	}
	public function save_admin_group_plot_sched(){

	$current_date=date('Y-m-d');

	$group_id=	$this->uri->segment('4');

	$group_detail=$this->plot_schedule_model->get_group_detail($group_id);
	$group_name=$group_detail->group_name;

	$company_id=	$this->uri->segment('5');
	$id=	$this->uri->segment('6');

	$payroll_period=$this->plot_schedule_model->get_payroll_period($id);

	if(!empty($payroll_period)){
	$yy_from= $payroll_period->year_from;
	$mm_from= $payroll_period->month_from;
	$dd_from= $payroll_period->day_from;

	$yy_to= $payroll_period->year_to;
	$mm_to= $payroll_period->month_to;
	$dd_to= $payroll_period->day_to;

	$from = $mm_from."/".$dd_from."/".$yy_from;
	$to = $mm_to."/".$dd_to."/".$yy_to;
	$to = date("m/d/Y",strtotime(date("m/d/Y", strtotime($to)) . " +1 days"));

	$ws_table='working_schedule_'.$mm_from;

	while($from!=$to){

		$mon = date('M', strtotime($from));
		list($month, $day, $year) = explode("/", $from);
		$dauto = "$year-$month-$day";
	

		//if(strlen($month)==1){$month="0".$month;}$working_schedule_sql="working_schedule_$month";
	
		$group_members=$this->plot_schedule_model->get_group_members($group_id); //
		foreach($group_members as $member){
			$member_employee_id= $member->employee_id;

			$data = $this->input->post($dauto.'_'.$member_employee_id);

	if($data=="restday"){
		$shift_in="00:00";
		$shift_out="00:00";
		$restday="1";
	}else{
			$working_schedule_type=substr($data, 0,4);

			if($working_schedule_type=="reg_"){
			$ws_type="regular";
			}else if($working_schedule_type=="haf_"){
			$ws_type="halfday";
			}else if($working_schedule_type=="rdh_"){
			$ws_type="restday-holiday";
			}else{
			$ws_type="code unknown";
			}

			$shift_in= substr($data, 4,5);
			$shift_out= substr($data, 13,5);
			$restday="0";
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
		$value = $yy_from."-".$mm_from."-".$dd_from. " to ".$yy_to."-".$mm_to."-".$dd_to;
		General::logfile('Group Working Schedule','INSERT',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$group_name." : Group Working Schedule for the Payroll Period <strong>".$value."</strong>, is  Successfully Added!</div>");

}else{
		// if walang payroll period
		// logfile
		$value = 'notice: no found payroll period';
		General::logfile('Group Working Schedule','INSERT',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>No found payroll period</div>");

}
		redirect(base_url().'app/plot_schedule/index',$this->data);


		//$this->load->view("app/time/plot_schedule/admin_group_plot_sched",$this->data);	
	}


}//end controller



