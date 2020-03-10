<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Overtime_management extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/overtime_management_model");
		$this->load->model("employee_portal/employee_transactions_model");
	}
	
	public function index($atro_option)
	{
		$this->data['option']=$atro_option;
		$this->data['group']= $this->overtime_management_model->get_pre_approved_groups();
			$this->data['policy_main']= $this->overtime_management_model->atro_policy_main();
			if($this->data['policy_main'] > 0) { $option = 'general'; } else{ $option='group'; }
		$this->data['plotted'] = $this->overtime_management_model->plotted_details($option,$atro_option);
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/overtime_management/allowed_overtime', $this->data);
		$this->load->view('employee_portal/footer');		
	}	

	public function group_members($group,$date,$atro_option)
	{
		$this->data['group']=$group;
		$this->data['date']=$date;
		$this->data['atro_option']=$atro_option;
		$this->data['group_members'] = $this->overtime_management_model->group_members($group);
		$group_exist = $this->overtime_management_model->group_exist_checker($group,$date,$atro_option);
		if(!empty($group_exist)){ 
			$this->data['reason']=$group_exist->reason;
			$this->load->view('employee_portal/overtime_management/group_allowed_overtime_members_exist', $this->data);}
		else{ $this->load->view('employee_portal/overtime_management/group_allowed_overtime_members', $this->data); }
	}


	public function save_pre_approved($emp,$hrs,$reason,$count,$group,$date,$atro_option)
	{
		$this->data['option']=$group;
		$this->data['group']=$group;
		$insert = $this->overtime_management_model->save_pre_approved($emp,$hrs,$reason,$count,$group,$date,$atro_option);
		if($this->data['policy_main']= $this->overtime_management_model->atro_policy_main() > 0) { $option='general'; } else{ $option='group'; }
		$this->data['plotted'] = $this->overtime_management_model->plotted_details($option,$atro_option);
		$this->load->view('employee_portal/overtime_management/plotted_details', $this->data);
		
	}
	public function filter_all_date_preapproved($option,$atro_option)
	{
		$this->data['group']= $this->overtime_management_model->get_pre_approved_groups();

		if($option=='group')
		{ $this->load->view('employee_portal/overtime_management/group_filter_all_date_preapproved', $this->data); }
		else{ 

			$this->data['date']= $this->overtime_management_model->get_date_preapproved('Year','general','-','-',$atro_option);
			$this->load->view('employee_portal/overtime_management/general_filter_all_date_preapproved', $this->data); 
		}
		
	}
	public function get_dates($option,$value1,$value2,$value3,$atro_option)
	{
		$date= $this->overtime_management_model->get_date_preapproved($option,$value1,$value2,$value3,$atro_option);
		
		if($option=='Year')
		{	
			
			echo "<option>Select Year</option>";
			foreach ($date as $y)
			{
				echo "<option value='".date("Y", strtotime($y->date))."'>".date("Y", strtotime($y->date))."</option>";
			}
		}
		elseif($option=='Month')
		{
			echo "<option>Select Month</option>";
			foreach ($date as $m)
			{
				echo "<option value=".date("m", strtotime($m->date)).">".date("M", strtotime($m->date))."</option>";
			}
		}
		elseif($option=='Day')
		{
			echo "<option>Select Day</option>";
			foreach ($date as $m)
			{
				echo "<option>".date("d", strtotime($m->date))."</option>";
			}
		}
	}

	public function get_employees_with_preapproved($group,$year,$month,$day,$atro_option)
	{
		$this->data['date']=$year."-".$month."-".$day;
		$this->data['group']=$group;
		$this->data['atro_option']=$atro_option;
		$this->data['details']= $this->overtime_management_model->get_employees_with_preapproved($group,$year,$month,$day,$atro_option);
		$this->data['checker']= $this->overtime_management_model->checker_plotted($this->data['date'],$group,$atro_option);
		$this->load->view('employee_portal/overtime_management/group_get_employees_with_preapproved', $this->data);
	}
	public function save_pre_approved_update($date,$group,$count,$hours_result,$employee,$atro_option)
	{ 
		$this->data['date']=$date;
		$this->data['group']=$group;
		$this->data['atro_option']=$atro_option;
		$this->data['insert']= $this->overtime_management_model->save_pre_approved_update($date,$group,$count,$hours_result,$employee,$atro_option);
		$this->data['details']= $this->overtime_management_model->get_employees_with_preapproved_($group,$date,$atro_option);
		$this->data['checker']= $this->overtime_management_model->checker_plotted($date,$group,$atro_option);
		$this->load->view('employee_portal/overtime_management/group_get_employees_with_preapproved', $this->data);
	}

	public function group_members_for_general($group,$date,$atro_option)
	{
		$this->data['group']=$group;
		$this->data['date']=$date;
		$this->data['atro_option']=$atro_option;
		$this->data['group_members'] = $this->overtime_management_model->group_members('general');
		$general_exist = $this->overtime_management_model->general_exist_checker($date,$atro_option);
		if(!empty($general_exist)){
			$this->data['reason']=$general_exist->reason;
			$this->load->view('employee_portal/overtime_management/general_allowed_overtime_members_exist', $this->data);}
		else{ $this->load->view('employee_portal/overtime_management/general_allowed_overtime_members', $this->data); }

	}
}