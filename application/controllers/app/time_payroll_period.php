<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Time_payroll_period extends General{

	public function __construct(){
		parent::__construct();
		$this->load->model("app/time_payroll_period_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();		
	}
	public function index(){	
		// user restriction function
		// $this->session->set_userdata('page_name','time_payroll_period_li');
		// $page_id = $this->general_model->getPageID();
		// $userRole = $this->general_model->getUserLoggedIn($this->session->userdata('username'));
		// if(General::has_rights_to_access($page_id->page_id,$userRole->user_role) == FALSE){
		
		// $value = "Payroll Period";
		// General::logfile('Payroll Period','TRY TO ACCESS',$value);	
		// redirect(base_url().'access_denied'); // app/dashboard
		// 	}
		// end of user restriction function		
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->data['pay_per'] = $this->time_payroll_period_model->getAll();		
		$this->load->view('app/time/payroll_period/index',$this->data);
	}	
	public function comp_payroll_period(){
		$company_id=$this->uri->segment("4");
		$year=$this->uri->segment("5");
		$group_filter=$this->uri->segment("6");

		//echo "year: $year / group : $group_filter ";
		if($group_filter==""){
			$check_group="";
		}else{

			$check_group=$group_filter;
		}

		if($year==""){
			$check_year="";
		}else{
			$check_year=$year;
		}


		//echo $check_year;
		$this->data['pay_per_group'] = $this->time_payroll_period_model->get_payroll_period_groups($company_id);
		$this->data['pay_per'] = $this->time_payroll_period_model->payrollperiod_per_company($company_id,$check_year,$check_group);

		//old pay_per_semi
		$this->data['oldestPayPeriod'] = $this->time_payroll_period_model->oldestPayPeriod($company_id);

		//===View employee with no group
		$this->data['employee_company_available'] 	= $this->time_payroll_period_model->get_employee_availabale_company($company_id);	
		$this->data['employee_company_unavailable'] = $this->time_payroll_period_model->get_employee_unavailabale_company($company_id);
		//===End of view employee with no group

		$this->load->view('app/time/payroll_period/comp_payroll_period',$this->data);
	}	
	public function add_pay_per_group(){
		$company_id=$this->uri->segment("4");

		$this->load->view('app/time/payroll_period/add_pay_per_group',$this->data);
	}

	public function save_add_payroll_period_group(){

		$this->form_validation->set_rules("group_name","Group Name","trim|required|callback_validate_period_group");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){
			$company_id = $this->input->post('company_id');
			// save data
			$this->time_payroll_period_model->save_add_payroll_period_group();
			
			$value = $this->input->post('group_name');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			action type choices guide : INSERT,DELETE,UPDATE,DELETE,DEACTIVATE,ACTIVATE
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Payroll Period','logfile_time_payroll_period','add payperiod group: '.$value.' to company id: '.$company_id.'','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group Name, <strong>".$value."</strong>, is Successfully Added!</div>");

			redirect(base_url().'app/time_payroll_period',$this->data);
		}else{
			$this->index();
		}		
	}

	public function validate_period_group(){
		$company_id = $this->input->post('company_id');
		$value = $this->input->post('group_name');
		if($this->time_payroll_period_model->validate_period_group($company_id)){
			$this->form_validation->set_message("validate_period_group"," Group Name, <strong>".$value."</strong>, Already Exists.");
			return false;

		}else{
			return true;
		}
	}

	public function edit_payroll_period_group(){
		$id = $this->uri->segment("4");
		$this->data['pay_per_group'] = $this->time_payroll_period_model->spec_payroll_period_group($id);
		$this->load->view('app/time/payroll_period/edit_pay_per_group',$this->data);
	}	
	public function modify_payroll_period_group(){

		$this->form_validation->set_rules("group_name","Group Name","trim|required|callback_validate_edit_payroll_period_group");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$payroll_period_group_id = $this->input->post('payroll_period_group_id');

			// modify data
			$this->time_payroll_period_model->modify_payroll_period_group($payroll_period_group_id);

			$value = $this->input->post('group_name');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			action type choices guide : INSERT,DELETE,UPDATE,DELETE,DEACTIVATE,ACTIVATE
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Payroll Period','logfile_time_payroll_period','modify payperiod group: '.$value.'','UPDATE',$value);

			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group Name, <strong>".$value."</strong>, is Successfully Modified!</div>");

			redirect(base_url().'app/time_payroll_period',$this->data);
		}else{
			$this->index();
		}		
	}
	public function validate_edit_payroll_period_group(){
		$payroll_period_group_id = $this->input->post('payroll_period_group_id');
		$value = $this->input->post('group_name');
		if($this->time_payroll_period_model->validate_edit_payroll_period_group($payroll_period_group_id)){
			$this->form_validation->set_message("validate_edit_payroll_period_group"," Group Name, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}	
	public function delete_group(){
		
		$id = $this->uri->segment("4");
		$group = $this->time_payroll_period_model->spec_payroll_period_group($id);
		$value=$group->group_name;
		if($this->time_payroll_period_model->check_group_before_delete($id)){
			
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Cannot Delete ".$value."</strong> :  Payroll Period already assigned to it!</div>");
		}else{
			 $this->time_payroll_period_model->delete_group_employee($id);
			 $this->db->query("delete from payroll_period_group where payroll_period_group_id = ".$id);
			 $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Payroll Period Group : ".$value."</strong> is Successfully Deleted!</div>");
		}

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			action type choices guide : INSERT,DELETE,UPDATE,DELETE,DEACTIVATE,ACTIVATE			
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Payroll Period','logfile_time_payroll_period','delete payperiod group: '.$value.' from company id : '.$group->company_id,'DELETE',$value);	

		redirect(base_url().'app/time_payroll_period',$this->data);
	}
	public function deactivate_group(){
		
		$id = $this->uri->segment("4");
		$group = $this->time_payroll_period_model->spec_payroll_period_group($id);

		$this->time_payroll_period_model->deactivate_group($id);
		$this->time_payroll_period_model->deactivate_group_employee($id);

		$value = $group->group_name;

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			action type choices guide : INSERT,DELETE,UPDATE,DELETE,DEACTIVATE,ACTIVATE			
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Payroll Period','logfile_time_payroll_period','deactivate payperiod group: '.$value.' from company id: '.$group->company_id,'DEACTIVATE',$value);			


		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully deactivated!</div>");

		redirect(base_url().'app/time_payroll_period',$this->data);
	}
	public function activate_group(){
		
		$id = $this->uri->segment("4");
		$group = $this->time_payroll_period_model->spec_payroll_period_group($id);

		$this->time_payroll_period_model->activate_group($id);
		$this->time_payroll_period_model->activate_group_employee($id);

		$value = $group->group_name;

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			action type choices guide : INSERT,DELETE,UPDATE,DELETE,DEACTIVATE,ACTIVATE				
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Payroll Period','logfile_time_payroll_period','activate payperiod group: '.$value.' from company id: '.$group->company_id,'ACTIVATE',$value);	

			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully activated!</div>");

		redirect(base_url().'app/time_payroll_period',$this->data);
	}


	public function pay_type_cutoff(){
		$pay_type_id=$this->uri->segment("4");
		//$this->data['pay_per'] = $this->time_payroll_period_model->payroll_per_per_company($company_id);//$company_id
		$this->load->view('app/time/payroll_period/pay_type_cutoff_choices',$this->data);
	}

	public function comp_pay_type_group(){
		$pay_type_id=$this->uri->segment("4");
		//$this->data['pay_per'] = $this->time_payroll_period_model->payroll_per_per_company($company_id);//$company_id

		$this->load->view('app/time/payroll_period/comp_payroll_period_group',$this->data);
	}

	public function add(){
		
		$company_id=$this->uri->segment("4");
		$this->data['oldestPayPeriod'] = $this->time_payroll_period_model->oldestPayPeriod($company_id);
		$this->load->view('app/time/payroll_period/add',$this->data);
	}
	public function save_add(){
		$this->form_validation->set_rules("date_from","Date From","trim|required");
		$this->form_validation->set_rules("date_to","Date To","trim|callback_validate_date");
		$this->form_validation->set_rules("pay_code","Paycode","trim|callback_validate_payroll_period");
		$this->form_validation->set_rules("cut_off","Cut-Off","trim|required");
		$this->form_validation->set_rules("cut_off_day","Cut Off Day","trim|required");
		$this->form_validation->set_rules("month_cover","Cover Month","trim|required");
		$this->form_validation->set_rules("year_cover","Cover Year","trim|required");
		$this->form_validation->set_rules("pay_type_group","Payroll Period group","trim|required");
		$this->form_validation->set_rules("pay_date","Pay Date","trim");//|callback_validate_pay_date
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		if($this->form_validation->run()){

			//$this->time_payroll_period_model->save_add_payroll_period();
			//foreach ($this->input->post('company_id') as $key => $value)
			//{

			$payroll_period_group_id=$this->input->post('pay_type_group');
			$pay_type=$this->input->post('pay_type');
			$date_from=$this->input->post('date_from');
			$date_to=$this->input->post('date_to');

			$year_from=substr($date_from, 0,4);
			$month_from=substr($date_from, 5,2);
			$day_from=substr($date_from, 8,2);

			$year_to=substr($date_to, 0,4);
			$month_to=substr($date_to, 5,2);
			$day_to=substr($date_to, 8,2);

		   $from=$year_from."-".$month_from."-".$day_from;        
           $to=$year_to."-".$month_to."-".$day_to;        
                        
                        $date1=date_create($from);
                        $date2=date_create($to);
                        $diff=date_diff($date1,$date2);
                        // echo $diff->format("%R%a");
                        $raw_no_of_days= $diff->format("%a");
                        $no_of_days=$raw_no_of_days+1;

		$pay_code=$year_from.$month_from.$day_from."_".$year_to.$month_to.$day_to;

		$checkPayrollPeriod=$this->time_payroll_period_model->checkPayrollPeriod();
			$complete_from=$checkPayrollPeriod->complete_from;
			$complete_to=$checkPayrollPeriod->complete_to;
		if(!empty($checkPayrollPeriod)){

				$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Payroll Period  <strong>".$date_from." to ".$date_to."</strong>, is not allowed as its overlapped with the existing payroll period ".$complete_from." to ".$complete_to."! </div>");	


		}else{
			$this->data = array(
				'company_id'		=> $this->input->post('company_id'), // $value
				'payroll_period_group_id'			=> $payroll_period_group_id,
				'pay_type'			=> $pay_type,
				'pay_code'			=> $pay_code,
				'month_from'		=> $month_from,
				'day_from'			=> $day_from,
				'year_from'			=> $year_from,
				'month_to'			=> $month_to,
				'day_to'			=> $day_to,
				'year_to'			=> $year_to,
				'no_of_days'		=> $no_of_days,
				'complete_from'		=> $date_from,
				'complete_to'		=> $date_to,
				'cut_off'			=> $this->input->post('cut_off'),
				'cut_off_day'		=> $this->input->post('cut_off_day'),
				'pay_date'			=> $this->input->post('pay_date'),
				'year_cover'		=> $this->input->post('year_cover'),
				'month_cover'		=> $this->input->post('month_cover'),
				'description'		=> $this->input->post('description'),
				'IsLock'			=> 0,
				'InActive'			=> 0
			);	
			$this->db->insert('payroll_period',$this->data);
			//}


				$value = $this->input->post('date_from')." to ".$this->input->post('date_to');
				General::logfile('Payroll Period','INSERT',$value);
				

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			action type choices guide : INSERT,DELETE,UPDATE,DELETE,DEACTIVATE,ACTIVATE				
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Payroll Period','logfile_time_payroll_period','add payroll period : '.$value.' to employee group id: '.$payroll_period_group_id,'INSERT',$value);


				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Payroll Period  <strong>".$value."</strong>, is Successfully Added!</div>");			
		}



			// redirect
			redirect(base_url().'app/time_payroll_period/index',$this->data);
		}else{
			$this->index();
		}
	}
	public function validate_payroll_period(){

		$company_id=$this->input->post('company_id');
		
		$loc=$this->time_payroll_period_model->get_company($company_id);
		$company_name=$loc->company_name;

		$payroll_period_group_id=$this->input->post('pay_type_group');
		$date_from=$this->input->post('date_from');
		$date_to=$this->input->post('date_to');

		$year_from=substr($date_from, 0,4);
		$month_from=substr($date_from, 5,2);
		$day_from=substr($date_from, 8,2);

		$year_to=substr($date_to, 0,4);
		$month_to=substr($date_to, 5,2);
		$day_to=substr($date_to, 8,2);
		$value=$year_from.$month_from.$day_from."_".$year_to.$month_to.$day_to;

		if($this->time_payroll_period_model->validate_add_payroll_period($value,$company_id,$payroll_period_group_id)){
			$this->form_validation->set_message("validate_payroll_period"," Payroll Period, <strong>".$date_from." to ".$date_to."</strong>, Already Exists to ".$company_name." .Please exclude it from adding.");
			return false;
		}else{
			return true;
		}

	}
	public function validate_date(){

		$date_from=$this->input->post('date_from');
		$date_to=$this->input->post('date_to');  

        $date1=date_create($date_from);
        $date2=date_create($date_to);
        $diff=date_diff($date1,$date2);
                    
        $diff_operator =$diff->format("%R%");

		if($diff_operator=="-"){  // negative value
			$this->form_validation->set_message("validate_date","Payroll Period, <strong>".$date_from." to ".$date_to."</strong> is Invalid. Date From must be ahead than Date To.");
			return false;
		}else{
			return true;
		}
	}
	public function validate_pay_date(){

		$date_to=$this->input->post('date_to');
		$pay_date=$this->input->post('pay_date');  

		if($pay_date<$date_to){
			$this->form_validation->set_message("validate_pay_date","Payroll Date, <strong>".$pay_date."</strong> is Invalid. Pay Date must be after or on Date To.");
			return false;
		}else{
			return true;
		}
	}
	public function delete_payroll_period(){

		$id = $this->uri->segment("4");
		//pp : payroll period
		$pp = $this->time_payroll_period_model->get_payroll_period($id);
		
		$this->db->query("update payroll_period set InActive = 1 where id = ".$id);

		
		$value = $pp->month_from."-".$pp->day_from."-".$pp->year_from. " to ".$pp->month_to."-".$pp->day_to."-".$pp->year_to;

			
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			action type choices guide : INSERT,DELETE,UPDATE,DELETE,DEACTIVATE,ACTIVATE				
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Payroll Period','logfile_time_payroll_period','delete payroll period : '.$value.' where payroll_period id: '.$id,'DELETE',$value);


		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Payroll Period <strong>".$value."</strong>, is  Successfully Deleted!</div>");

		redirect(base_url().'app/time_payroll_period/index',$this->data);
	}
	public function edit_payroll_period($id){
		$id = $this->uri->segment("4");
		//pp : payroll period
		$this->data['pp'] = $this->time_payroll_period_model->get_payroll_period($id);
		$this->load->view('app/time/payroll_period/edit',$this->data);
	}

	public function save_edit(){
		$id = $this->uri->segment("4");
		//pp : payroll period
		$pp = $this->time_payroll_period_model->get_payroll_period($id);

		$this->form_validation->set_rules("cut_off","Cut-Off","trim|required");
		$this->form_validation->set_rules("cut_off_day","Cut Off Day","trim|required");
		$this->form_validation->set_rules("month_cover","Cover Month","trim|required");
		$this->form_validation->set_rules("year_cover","Cover Year","trim|required");
		$this->form_validation->set_rules("pay_date","Pay Date","trim|callback_validate_pay_date");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		if($this->form_validation->run()){

			$auto_early_cutoff=$this->input->post("auto_early_cutoff");
			if($auto_early_cutoff=="on"){
				$auto_early_cutoff_start_date=$this->input->post("auto_early_cutoff_start_date");

					if($auto_early_cutoff_start_date){
						//echo "$auto_early_cutoff_start_date <= ".$pp->complete_from;

						if(date($auto_early_cutoff_start_date>$pp->complete_to)){
								echo "date not acceptable 1";
						}else{
							if(date($auto_early_cutoff_start_date<=$pp->complete_from)){
								echo "date not acceptable 2";
							}else{

				$this->time_payroll_period_model->save_edit_payroll_period($id);
				
				$value = $pp->year_from."-".$pp->month_from."-".$pp->day_from." to ".$pp->year_to."-".$pp->month_to."-".$pp->day_to;

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			action type choices guide : INSERT,DELETE,UPDATE,DELETE,DEACTIVATE,ACTIVATE				
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Payroll Period','logfile_time_payroll_period','modify payroll period: '.$value.' whose payroll_period id is '.$id,'UPDATE',$value);				


				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Payroll Period  <strong>".$value."</strong>, is Successfully Updated!</div>");	

							}
						}						
					}else{

						 $this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> You have chosen to Use System Automatic Early Cutoff  <strong>".$value."</strong>, However you did not choose Early Cutoff Date Start. This is not saved. !</div>");
				
					}
			}else{

				$this->time_payroll_period_model->save_edit_payroll_period($id);

				$value = $pp->year_from."-".$pp->month_from."-".$pp->day_from." to ".$pp->year_to."-".$pp->month_to."-".$pp->day_to;

			General::system_audit_trail('Time','Payroll Period','logfile_time_payroll_period','modify payroll period: '.$value.' whose payroll_period id is '.$id,'UPDATE',$value);	
				
				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Payroll Period  <strong>".$value."</strong>, is Successfully Updated!</div>");				
				
			}



			// // redirect
			 redirect(base_url().'app/time_payroll_period/index',$this->data);
		}else{
			$this->index();
		}
	}

	//=======================================manage_payroll_period_employee_group================================
	
	public function view_employee_period_group(){ 
		$id 								= $this->uri->segment("4");
		$this->data['group_name']			= $this->time_payroll_period_model->get_group_details($id);	
		$this->data['check_employee']		= $this->time_payroll_period_model->check_employee($id);	
		$this->data['employee_group'] 		= $this->time_payroll_period_model->get_employee_group($id);
		$this->data['employee_group_count']	= $this->time_payroll_period_model->get_employee_group_count($id);	

		$group_details						= $this->time_payroll_period_model->get_group_details($id);	
		$company_id 						= $group_details->company_id;
		$pay_type_id 						= $group_details->pay_type;
		$this->data['c_company_id']=$company_id;
		$this->data['c_pay_type_id']=$pay_type_id;
		$this->data['comp_loc']=$this->general_model->get_company_locations($company_id);
		$this->data['available_employee']	= $this->time_payroll_period_model->get_available_employee($company_id,$pay_type_id);

		$this->load->view('app/time/payroll_period/manage_employee_group/view_employee_group',$this->data);
	}

public function master_save_group_mem(){

	if(!empty($this->input->post('loc'))){
		$group_id=$this->uri->segment("4");
		$company_id=$this->input->post('c_company_id');
		$pay_type_id=$this->input->post('c_pay_type_id');
		$dateen=date('Y-m-d H:i:s');

		foreach ($this->input->post('loc') as $key => $value)
		{
			$emp=$this->time_payroll_period_model->getLocEmployees($value,$company_id,$pay_type_id);
			if(!empty($emp)){
				foreach($emp as $e){
					
					$groupmem = array(
						'payroll_period_group_id'	=>	$group_id,
						'employee_id'				=> $e->employee_id,	
						'InActive'				=> 0,	
						'date_enrolled'				=> $dateen
						);

					$this->time_payroll_period_model->master_save_group_mem($groupmem);
				}
			}else{
				//echo "wala";
			}

		}


		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee(s) Successfully Added to group!</div>");
		redirect('app/time_payroll_period/index');

	}else{

	}



}

	public function save_employee_group(){
		$group_id 					= $this->uri->segment("4");
		$employee_selected 			= $this->input->post('employeeselected');	
		$num_selected 				= count($employee_selected);
		for($num = 0; $num < $num_selected; $num++){
			$data_employee = array(
				'payroll_period_group_id'		=> $group_id,
				'employee_id'					=> $employee_selected[$num],
				'InActive'						=> 0,
				'date_enrolled'					=> date("Y-m-d h:i:s a")
			);
			$this->time_payroll_period_model->insert_employee_group($data_employee);

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			action type choices guide : INSERT,DELETE,UPDATE,DELETE,DEACTIVATE,ACTIVATE				
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Payroll Period','logfile_time_payroll_period','add employee:'.$employee_selected[$num].' to payroll period group: '.$group_id.'','INSERT',$employee_selected[$num]);


		}
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> " .$num_selected." Employee(s) Successfully Added to group!</div>");
		redirect('app/time_payroll_period/index');
	}

	public function remove_employee(){
		$employee_id 					= $this->uri->segment("4");
		$this->time_payroll_period_model->delete_employee_group($employee_id);

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			action type choices guide : INSERT,DELETE,UPDATE,DELETE,DEACTIVATE,ACTIVATE				
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Payroll Period','logfile_time_payroll_period','permanently removed employee: '.$employee_id.' from payroll period group','DELETE',$employee_id);



		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> " .$employee_id." Employee Successfully Removed from group!</div>");
		redirect('app/time_payroll_period/index');
	}

	public function inactivate_employee(){
        $employee_id            = $this->uri->segment("4");


        $this->time_payroll_period_model->inactive_employee($employee_id);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			action type choices guide : INSERT,DELETE,UPDATE,DELETE,DEACTIVATE,ACTIVATE				
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Payroll Period','logfile_time_payroll_period','set as inactive member employee: '.$employee_id.' from payroll period group','DEACTIVATE',$employee_id);


        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee ".$employee_id." Successfully Inactivate.</div>");

        redirect('app/time_payroll_period/index');
    }

    public function activate_employee(){
        $employee_id            = $this->uri->segment("4");
        //$group_name             = $this->time_flexi_schedule_model->get_group_name($group_id);

        $this->time_payroll_period_model->active_employee($employee_id);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			action type choices guide : INSERT,DELETE,UPDATE,DELETE,DEACTIVATE,ACTIVATE				
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Payroll Period','logfile_time_payroll_period','set as active member employee: '.$employee_id.' from payroll period group','ACTIVATE',$employee_id);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee ".$employee_id." Successfully Activate.</div>");

        redirect('app/time_payroll_period/index');
    }
	//====================================END OF manage_payroll_period_employee_group============================
}//controller