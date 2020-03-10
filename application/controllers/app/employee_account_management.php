<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Employee_account_management extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/employee_account_management_model");
		$this->load->model("general_model");
		$this->load->model("app/report_time_model");
		$this->load->dbforge();

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){	
		$this->employee_account_management();	
	}

	public function employee_account_management()
	{
		$this->data['policy'] = $this->employee_account_management_model->policy_list();
		$this->load->view('app/employee/employee_account_management/home',$this->data);		
	}

	//add new policy
	public function add_system_policy()
	{
				
		$this->load->view('app/employee/employee_account_management/add_system_policy');
	}

	//show option results
	public function option_results($option_results)
	{ 
		$this->data['option_results'] = $option_results;
		$this->data['table_fields']= $this->employee_account_management_model->table_govt_fields();
		$this->data['acc_sec_default_pass'] = $this->employee_account_management_model->default_password_selection();
		$this->load->view('app/employee/employee_account_management/option_results',$this->data);	
	}
	
	//save account security

	 public function save($option_results,$additional_data,$note,$title)
	 { 
	 	$this->data['insert'] = $this->employee_account_management_model->insert_acct_security($option_results,$additional_data,$note,$title);
	 	$this->data['policy'] = $this->employee_account_management_model->policy_list();
	 	echo "<ul class='nav nav-pills nav-stacked'>";
	 			if(empty($this->data['policy'])) { echo "<h3 class='text-danger'>No Results Found!.</h3>";} else{ foreach($this->data['policy'] as $rows)
                  { 
                    echo " <li> <a style='width:98%;margin-left:1px;text-align:left;cursor: pointer;' aria-hidden='true' data-toggle='tooltip' title='Click to add the policy' onclick='add_policy_data(".$rows->account_management_policy_id.")'><i class='fa fa-folder-open'></i> <span>".$rows->title."</span></a></li> ";
                   } } 
	 		echo "</ul>";
	 }

	 public function save_mo_tel_format($option,$note,$title)
	 { 
	 		$this->data['insert'] = $this->employee_account_management_model->save_mo_tel_format($option,$note,$title);
	 		$this->data['policy'] = $this->employee_account_management_model->policy_list();
	 		echo "<ul class='nav nav-pills nav-stacked'>";
	 			if(empty($this->data['policy'])) { echo "<h3 class='text-danger'>No Results Found!.</h3>";} else{ foreach($this->data['policy'] as $rows)
                  { 
                    echo " <li> <a style='width:98%;margin-left:1px;text-align:left;cursor: pointer;' aria-hidden='true' data-toggle='tooltip' title='Click to add the policy' onclick='add_policy_data(".$rows->account_management_policy_id.")'><i class='fa fa-folder-open'></i> <span>".$rows->title."</span></a></li> ";
                   } } 
	 		echo "</ul>";
	 }
	 //add policy data
	 public function add_policy_data($account_management_policy_id)
	 { 

		$this->data['edit_201_settings']=$this->session->userdata('edit_201_settings');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

	 	$this->data['account_management_policy_id'] = $account_management_policy_id;
		$this->data['policy_details'] = $this->employee_account_management_model->policy_details($account_management_policy_id);
		//for account security
		$this->data['check_data'] = $this->employee_account_management_model->check_data('data_exist');
		$this->data['selection'] = $this->employee_account_management_model->check_data('selection');
		// //for govt fields
		$this->data['govt_fields'] = $this->employee_account_management_model->get_government_fields();
			$this->data['govt_fields'] = $this->employee_account_management_model->get_government_fields();
		$this->data['notif'] = $this->employee_account_management_model->check_notif($account_management_policy_id);
		$this->data['others_data'] = $this->employee_account_management_model->others_data($account_management_policy_id);	
		$this->data['company_details']= $this->employee_account_management_model->company_details();	
		foreach ($this->data['check_data'] as $data) {
			$this->data['default_password'] = $data->id;
		}
		foreach ($this->data['policy_details']as $row) {
			$this->data['title'] = $row->title;
		} 
		$this->load->view('app/employee/employee_account_management/add_policy_data',$this->data);
	 }

	 public function reset_all_password_default(){
		$default_password 		= $this->employee_account_management_model->get_default_password();
		$field_default			= $default_password->field_name;
		$employee_list			= $this->employee_account_management_model->get_active_employee();

		foreach($employee_list as $employee){
			$set_default 		= $employee->$field_default;
			$employee_id		= $employee->employee_id;
			$this->employee_account_management_model->reset_password_default_save($set_default, $employee_id);

								/*
						--------------audit trail composition--------------
						(module,module dropdown,logfiletable,detailed action,action type,key value)
						--------------audit trail composition--------------
						*/
						General::system_audit_trail('201 Employee','Employee 201 Settings','logfile_employee_acc_mngt','Reset All Password to Default :'.$set_default,'UPDATE',$employee_id);



		}				

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  All employee's password successfully resetted</div>");

		redirect('app/employee_account_management');
	}

	//download employee password
	public function download_employee_all_account() {

		
		$fileName   =   "employee_all_account.xls";
		$inputFileName = './public/downloadable_templates/'.$fileName;
		

        $inputFileType = IOFactory::identify($inputFileName);
        $objReader = IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);
           

        $objPHPExcel->setActiveSheetIndex(0);
		$sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);

        $employee_account = $this->employee_account_management_model->get_employee_account();
        $row=2;
        foreach($employee_account as $account){
           	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $account->employee_id);
           	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $account->fullname);
           	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $account->username);
           	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $account->password);
			$row++;
		}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $fileName. '"');
		header('Cache-Control: max-age=0');

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;       
		      
    }

    public function save_account_security_data($default_password,$account_management_policy_id,$action)
    { 

    	

    	if($action=='insert')
    		{ $insert = $this->employee_account_management_model->reset_default_password('insert',$default_password); }
    	elseif($action=='update')
    		{ $insert = $this->employee_account_management_model->reset_default_password('update',$default_password); }

								/*
						--------------audit trail composition--------------
						(module,module dropdown,logfiletable,detailed action,action type,key value)
						--------------audit trail composition--------------
						*/
						General::system_audit_trail('201 Employee','Employee 201 Settings','logfile_employee_acc_mngt','Update Default Password :','UPDATE',$default_password);


    	$this->data['selection'] = $this->employee_account_management_model->check_data('selection');
    	$this->data['check_data'] = $this->employee_account_management_model->check_data('data_exist');
    	$this->data['account_management_policy_id'] = $account_management_policy_id;
		$this->data['policy_details'] = $this->employee_account_management_model->policy_details($account_management_policy_id);
		$this->data['default_password'] = $default_password;
		foreach ($this->data['policy_details'] as $row) {
			$this->data['title'] = $row->title;
		} 

		$this->data['edit_201_settings']=$this->session->userdata('edit_201_settings');
		$this->load->view('app/employee/employee_account_management/add_policy_data',$this->data);
    }

    public function save_govt_fields($account_management_policy_id,$action,$option_results,$loop,$converted1,$number_fields,$additional_functions)
    {
		$this->data['edit_201_settings']=$this->session->userdata('edit_201_settings');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

    	if($action=='insert')
    	{
    		$insert = $this->employee_account_management_model->insert_govt_fields($action,$loop,$converted1,$number_fields,$additional_functions);
    	}
    	$this->data['account_management_policy_id'] = $account_management_policy_id;
		$this->data['policy_details'] = $this->employee_account_management_model->policy_details($account_management_policy_id);
		//for account security
		$this->data['check_data'] = $this->employee_account_management_model->check_data('data_exist');
		$this->data['selection'] = $this->employee_account_management_model->check_data('selection');
		// //for govt fields
		 $this->data['govt_fields'] = $this->employee_account_management_model->get_government_fields();
		
		foreach ($this->data['check_data'] as $data) {
			$this->data['default_password'] = $data->id;
		}
		foreach ($this->data['policy_details']as $row) {
			$this->data['title'] = $row->title;
		} 
		$this->load->view('app/employee/employee_account_management/add_policy_data',$this->data);
    } 

    public function disable_by_view($option){
    	$this->data['option'] = $option;
    	
    	$this->data['company_setupdisable']	=  	$this->employee_account_management_model->company_setupdisable('non');
		$this->load->view('app/employee/employee_account_management/disable_by_view',$this->data);
	}

	public function onchange($by,$onchange_val,$company)
	{ 
		$this->data['by'] = $by;
		$this->data['company_locations'] 	= 	$this->employee_account_management_model->get_company_location($onchange_val);
		$this->data['company_division'] 	= 	$this->employee_account_management_model->get_company_division($onchange_val);
		$this->data['company_department'] 	= 	$this->employee_account_management_model->get_company_department($onchange_val,$company);
		$this->data['company_section'] 		= 	$this->employee_account_management_model->get_department_section($onchange_val);
		$this->data['company_classification'] 	= $this->employee_account_management_model->get_company_classification($onchange_val);
		$this->data['company_subsection'] 		= 	$this->employee_account_management_model->get_department_subsection($onchange_val);
		$this->data['company_setupdisable']	=  	$this->employee_account_management_model->company_setupdisable($company); 
		$this->data['company_employment']		=  	$this->employee_account_management_model->get_employmentList();
    	$this->data['company_position']	=  	$this->employee_account_management_model->get_positionList();
		$this->load->view('app/employee/employee_account_management/onchange_results',$this->data);	
	}
	
	public function onchange2($by,$onchange_val,$company)
	{ 
		$this->data['by'] = $by;
		$this->data['company_locations'] = $this->employee_account_management_model->get_company_location($onchange_val);
		$this->data['company_division'] 	= $this->employee_account_management_model->get_company_division($onchange_val);
		$this->data['company_department'] 	= $this->employee_account_management_model->get_company_department($onchange_val,$company);
		$this->data['company_section'] 		= 	$this->employee_account_management_model->get_department_section($onchange_val);
		$this->data['company_subsection'] 		= 	$this->employee_account_management_model->get_department_subsection($onchange_val);
		$this->data['company_setupdisable']	=  	$this->employee_account_management_model->company_setupdisable($company); 
		foreach ($this->data['company_setupdisable'] as $dd) {
			$this->data['divisionexp']=explode("-",$dd->division);
			$this->data['departmentexp']=explode("-",$dd->department);

		}
		$this->load->view('app/employee/employee_account_management/onchange_results_2',$this->data);	
	}

	public function save_disable($option,$data_check,$data_uncheck,$company,$account_management_policy_id,$division,$department,$section)
	{ 
		$update = $this->employee_account_management_model->update_disable($option,$data_check,$data_uncheck,$company,$account_management_policy_id,$division,$department,$section);
		$logtrailtitle="$option,$data_check,$data_uncheck,$company,$account_management_policy_id,$division,$department,$section";
		$$logtraildata="";
					/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee 201 Settings','logfile_employee_acc_mngt','Disable Employee Portal :'.$logtrailtitle,'UPDATE',$logtraildata);

	
	}

	//generate fields
	 public function generate_fields($option_results,$no_fields)
	 {
	 	$this->data['no_fields']=$no_fields;
	 	$this->load->view('app/employee/employee_account_management/add_fields',$this->data);
	 }

	 //input type result
	public function input_format($field_no,$input_type)
	 {
	 	$this->data['field_no']=$field_no;
	 	$this->data['input_type']=$input_type;
	 	$this->load->view('app/employee/employee_account_management/input_format',$this->data);
	 }

	public function save_others_setting($option_results,$converted1,$loop,$note,$title)
	{	
		$insert = $this->employee_account_management_model->insert_others_setting($option_results,$converted1,$loop,$note,$title);
		$this->data['policy'] = $this->employee_account_management_model->policy_list();
	 	echo "<ul class='nav nav-pills nav-stacked'>";
	 			if(empty($this->data['policy'])) { echo "<h3 class='text-danger'>No Results Found!.</h3>";} else{ foreach($this->data['policy'] as $rows)
                  { 
                    echo " <li> <a style='width:98%;margin-left:1px;text-align:left;cursor: pointer;' aria-hidden='true' data-toggle='tooltip' title='Click to add the policy' onclick='add_policy_data(".$rows->account_management_policy_id.")'><i class='fa fa-folder-open'></i> <span>".$rows->title."</span></a></li> ";
                   } } 
	 		echo "</ul>";
	}

	//save others data
	public function save_others_data($loop,$converted1,$action,$option,$account_management_policy_id)
	{


		$logtrailtitle="loop|converted1|action|option|account_management_policy_id";
		$logtraildata="$loop|$converted1|$action|$option|$account_management_policy_id";


		if($action=='insert')
			{ $insert = $this->employee_account_management_model->insert_others_data($loop,$converted1,$action,$option,$account_management_policy_id); }
		else{ $update = $this->employee_account_management_model->insert_others_data($loop,$converted1,$action,$option,$account_management_policy_id); }


		$policy_details = $this->employee_account_management_model->policy_details($account_management_policy_id);
		


		/*
		--------------audit trail composition--------------
		(module,module dropdown,logfiletable,detailed action,action type,key value)
		--------------audit trail composition--------------
		*/
		General::system_audit_trail('201 Employee','Employee 201 Settings','logfile_employee_acc_mngt','update employee password encryption :'.$logtrailtitle,'UPDATE',$logtraildata);

		foreach ($policy_details as $row) {
			$this->data['title'] = $row->title;
		} 

		$this->data['edit_201_settings']=$this->session->userdata('edit_201_settings');
		$this->data['policy_details'] = $this->employee_account_management_model->policy_details($account_management_policy_id);
		$this->data['others_data'] = $this->employee_account_management_model->others_data($account_management_policy_id);
		$this->load->view('app/employee/employee_account_management/add_policy_data',$this->data);
	}

	// //designation filter
	// public function designation_filter($action)
	// {
	// 	$this->data['action'] = $action;
	// 	$this->data['company'] = $this->report_time->companyList();
	// 	$this->data['employment'] = $this->general_model->employmentList();
	// 	$this->load->view('app/employee/employee_account_management/designation_filter',$this->data);
	// }


	// //filter result
	// public function result_onchange_val($option,$value)
	// {  
	// 	if($option=='division')
	// 	{ $this->data['results'] = $this->report_time->onchange_value($option,$value); }

	// 	else if($option=='department')
	// 	{ $this->data['results'] = $this->report_time->onchange_value($option,$value); }

	// 	else if($option=='section')
	// 	{ $this->data['results'] = $this->report_time->onchange_value($option,$value); }

	// 	else if($option=='subsection')
	// 	{ $this->data['results'] = $this->report_time->onchange_value($option,$value); }

	// 	else if($option=='classification')
	// 	{ $this->data['results'] = $this->report_time->onchange_value($option,$value); }

	// 	else if($option=='location')
	// 	{ $this->data['results'] = $this->report_time->onchange_value($option,$value); }
		
	// 	$this->data['option']=$option;
	// 	$this->load->view('app/employee/employee_account_management/results',$this->data);
	// }

	// //save the designation
	// public function save_designation_value($company,$division,$department,$section,$subsection,$status,$location,$classification,$employment,$no_to_view,$view_option,$account_management_policy_id)
	// {
	// 	$insert = $this->employee_account_management_model->save_designation_value($company,$division,$department,$section,$subsection,$status,$location,$classification,$employment,$no_to_view,$view_option,$account_management_policy_id); 
	// }

	//save the notif all
	function notif_save_all($no_to_view,$view_option,$account_management_policy_id)
	{ 
			$insert = $this->employee_account_management_model->save_all_value($no_to_view,$view_option,$account_management_policy_id);
	}


	//newly hired notification 
	function notif_action($action,$account_management_policy_id,$option,$company_id)
	{ 
		$this->data['edit_201_settings']=$this->session->userdata('edit_201_settings');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$this->data['company_id'] = $company_id;
		$this->data['notif_option'] = $option;
		$this->data['action'] = $action;
		$this->data['account_management_policy_id'] = $account_management_policy_id;
		$this->data['check_notif_com_exist'] = $this->employee_account_management_model->company_notif_exist($option);
		$this->data['company_details']= $this->employee_account_management_model->company_details();
		$this->data['employment'] = $this->general_model->employmentList();
		$this->data['division'] = $this->employee_account_management_model->divisionList($company_id);
		$this->data['classification'] 	= $this->employee_account_management_model->get_company_classification($company_id);
		$this->data['location'] 	= 	$this->employee_account_management_model->get_company_location($company_id);
		$this->load->view('app/employee/employee_account_management/notif_option_action',$this->data);
	}
	
	function get_division_list($options,$company_id)
	{
		$this->data['options'] = $options;
		$this->data['division'] = $this->employee_account_management_model->divisionList($company_id);
		$this->load->view('app/employee/employee_account_management/results',$this->data);
	}

	

	function save_notifdata_all($company_id,$comp_option,$account_management_policy_id,$notif_days_view)
	{
		$this->data['company_id'] = $company_id;
		$this->data['comp_option']= $comp_option;
		$this->datam['account_management_policy_id'] =$account_management_policy_id;
		$insert = $this->employee_account_management_model->save_notifdata_all($company_id,$comp_option,$account_management_policy_id,$notif_days_view);

						$logtrailtitle="company_id|comp_option|account_management_policy_id|notif_days_view";
						$logtraildata="$company_id|$comp_option|$account_management_policy_id|$notif_days_view";

						/*
						--------------audit trail composition--------------
						(module,module dropdown,logfiletable,detailed action,action type,key value)
						--------------audit trail composition--------------
						*/
						General::system_audit_trail('201 Employee','Employee 201 Settings','logfile_employee_acc_mngt','update Newly hired welcome notification on employees portal :'.$logtrailtitle,'UPDATE',$logtraildata);


		$this->data['notif_setup'] = $this->employee_account_management_model->notif_setup();
		$this->data['policy_details'] = $this->employee_account_management_model->policy_details($account_management_policy_id);
		foreach ($this->data['policy_details'] as $row) {
			$this->data['title'] = $row->title;
		} 
		$this->load->view('app/employee/employee_account_management/company_setup_notification',$this->data);
	}

	//update form 
	function updateform_notif($option,$company_id,$account_management_policy_id)
	{
		$this->data['company_id'] = $company_id;
		$this->data['comp_option']= $option;
		$this->data['account_management_policy_id']= $account_management_policy_id;
		$company_info = $this->employee_account_management_model->company_info($company_id);
		$this->data['company_details']= $this->employee_account_management_model->company_details();
		
		foreach ($company_info as $company) {
			$this->data['company_title'] = $company->company_name;
			$this->data['company_id'] = $company->company_id;
		}
		
		$this->load->view('app/employee/employee_account_management/notif_update_form',$this->data);
	}

	function save_notifdata_multi($company_id,$comp_option,$account_management_policy_id,$notif_days_view,$data_check)
	{
		//$company_id."=".$comp_option."=".$account_management_policy_id."=".$notif_days_view."=".$data_check;
		$this->data['company_id'] = $company_id;
		$this->data['comp_option']= $comp_option;
		$this->datam['account_management_policy_id'] =$account_management_policy_id;
		$insert = $this->employee_account_management_model->save_notifdata_multi($company_id,$comp_option,$account_management_policy_id,$notif_days_view,$data_check);

						$logtrailtitle="company_id|comp_option|account_management_policy_id|notif_days_view|data_check";
						$logtraildata="$company_id|$comp_option|$account_management_policy_id|$notif_days_view|$data_check";

						/*
						--------------audit trail composition--------------
						(module,module dropdown,logfiletable,detailed action,action type,key value)
						--------------audit trail composition--------------
						*/
						General::system_audit_trail('201 Employee','Employee 201 Settings','logfile_employee_acc_mngt','update Newly hired welcome notification on employees portal :'.$logtrailtitle,'UPDATE',$logtraildata);

		$this->data['notif_setup'] = $this->employee_account_management_model->notif_setup();
		$this->data['policy_details'] = $this->employee_account_management_model->policy_details($account_management_policy_id);
		foreach ($this->data['policy_details'] as $row) {
			$this->data['title'] = $row->title;
		} 
		$this->load->view('app/employee/employee_account_management/company_setup_notification',$this->data);
	}

	//get department
	function get_data_department($options,$value,$company_id)
	{
		$this->data['options'] = $options;
		$this->data['company_id'] = $company_id;
		 $this->data['department'] = $this->employee_account_management_model->get_department($options,$value,$company_id); 
		$this->load->view('app/employee/employee_account_management/results',$this->data);
	}

	function get_data_section($options,$value,$company_id,$division)
	{ 
		$this->data['options'] = $options;
		$this->data['company_id'] = $company_id;
		$this->data['division'] = $division;
		$this->data['section'] = $this->employee_account_management_model->get_section($options,$value,$company_id,$division); 
		$this->load->view('app/employee/employee_account_management/results',$this->data);
	}

	//subsection list accdg to section

	function get_data_subsection($options,$value,$company_id,$division,$department)
	{ 
		$this->data['options'] = $options;
		$this->data['company_id'] = $company_id;
		$this->data['division'] = $division;
		$this->data['subsection'] = $this->employee_account_management_model->get_subsection($options,$value,$company_id,$division,$department); 
		$this->data['classification'] 	= $this->employee_account_management_model->get_company_classification($company_id);
		$this->data['employment'] = $this->general_model->employmentList();
		$this->data['location'] 	= 	$this->employee_account_management_model->get_company_location($company_id);
		$this->load->view('app/employee/employee_account_management/results',$this->data);
	}

	function save_notif_one_emp($company,$division,$department,$section,$subsection,$classification,$employment,$status,$location,$account_management_policy_id,$no_to_view,$view_option,$company_view)
	{ 
		$insert = $this->employee_account_management_model->insert_notif_one_emp($company,$division,$department,$section,$subsection,$classification,$employment,$status,$location,$account_management_policy_id,$no_to_view,$view_option,$company_view); 
		$this->data['policy_details'] = $this->employee_account_management_model->policy_details($account_management_policy_id);
		$this->data['notif_setup'] = $this->employee_account_management_model->notif_setup();
		foreach ($this->data['policy_details'] as $row) {
			$this->data['title'] = $row->title;
		} 
		$this->load->view('app/employee/employee_account_management/company_setup_notification',$this->data);
		
	}

	function delete_notif($options,$company_id,$account_management_policy_id)
	{ 
		$this->data['account_management_policy_id'] = $account_management_policy_id;
		$this->data['policy_details'] = $this->employee_account_management_model->policy_details($account_management_policy_id);
		//for account security
		$this->data['check_data'] = $this->employee_account_management_model->check_data('data_exist');
		$this->data['selection'] = $this->employee_account_management_model->check_data('selection');
		// //for govt fields
		$this->data['govt_fields'] = $this->employee_account_management_model->get_government_fields();
			$this->data['govt_fields'] = $this->employee_account_management_model->get_government_fields();
		$this->data['notif'] = $this->employee_account_management_model->check_notif($account_management_policy_id);
		$this->data['others_data'] = $this->employee_account_management_model->others_data($account_management_policy_id);	
		$this->data['company_details']= $this->employee_account_management_model->company_details();	
		$delete = $this->employee_account_management_model->delete_notif($company_id,$account_management_policy_id);
		foreach ($this->data['check_data'] as $data) {
			$this->data['default_password'] = $data->id;
		}
		foreach ($this->data['policy_details']as $row) {
			$this->data['title'] = $row->title;
		} 
		$this->load->view('app/employee/employee_account_management/add_policy_data',$this->data);
	}

	function update_notif_all($options,$datas,$company_id,$account_management_policy_id,$notif_days_view_update)
	{ 	
		$update = $this->employee_account_management_model->updatesave_notif_all($options,$datas,$company_id,$account_management_policy_id,$notif_days_view_update);
		$this->data['policy_details'] = $this->employee_account_management_model->policy_details($account_management_policy_id);
		$this->data['notif_setup'] = $this->employee_account_management_model->notif_setup();
		foreach ($this->data['policy_details'] as $row) {
			$this->data['title'] = $row->title;
		} 
		$this->load->view('app/employee/employee_account_management/company_setup_notification',$this->data);	
	}

	function saveupdate_notif_one_emp($company,$division,$department,$section,$subsection,$classification,$employment,$status,$location,$account_management_policy_id,$no_to_view,$view_option,$company_view)
	{  
		$update = $this->employee_account_management_model->update_notif_one_emp($company,$division,$department,$section,$subsection,$classification,$employment,$status,$location,$account_management_policy_id,$no_to_view,$view_option,$company_view); 

						$logtrailtitle="company|division|department|section|subsection|classification|employment|status|location|account_management_policy_id|no_to_view|view_option|company_view";
						$logtraildata="$company|$division|$department|$section|$subsection|$classification|$employment|$status|$location|$account_management_policy_id|$no_to_view|$view_option|$company_view";

						/*
						--------------audit trail composition--------------
						(module,module dropdown,logfiletable,detailed action,action type,key value)
						--------------audit trail composition--------------
						*/
						General::system_audit_trail('201 Employee','Employee 201 Settings','logfile_employee_acc_mngt','update Newly hired welcome notification on employees portal :'.$logtrailtitle,'UPDATE',$logtraildata);


		$this->data['policy_details'] = $this->employee_account_management_model->policy_details($account_management_policy_id);
		$this->data['notif_setup'] = $this->employee_account_management_model->notif_setup();
		foreach ($this->data['policy_details'] as $row) {
			$this->data['title'] = $row->title;
		} 
		$this->load->view('app/employee/employee_account_management/company_setup_notification',$this->data);
		
	}

	//setting up the mobile and telephone format
	public function view_location_list($company_id)
	{

		$this->data['edit_201_settings']=$this->session->userdata('edit_201_settings');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$this->data['flash_id']=$company_id;
		$this->data['action_']='';
		$this->data['check_exist'] = $this->employee_account_management_model->check_if_mob_tel_exist($company_id);
		$this->data['company_id']=$company_id;
		$this->data['location'] = $this->employee_account_management_model->get_company_location($company_id);
		$this->load->view('app/employee/employee_account_management/set_up_mob_tel_format',$this->data);
	}

	public function save_mob_tel($company_id,$converted,$loop,$number_fields,$option)
	{


		$insert =  $this->employee_account_management_model->save_mob_tel_data($company_id,$converted,$loop,$number_fields,$option);

		$logtrailtitle="company_id|converted|loop|number_fields|option";
		$logtraildata="$company_id|$converted|$loop|$number_fields|$option";

		/*
		--------------audit trail composition--------------
		(module,module dropdown,logfiletable,detailed action,action type,key value)
		--------------audit trail composition--------------
		*/
		General::system_audit_trail('201 Employee','Employee 201 Settings','logfile_employee_acc_mngt','update contact numbers format :'.$logtrailtitle,'UPDATE',$logtraildata);

		$this->data['flash_id']=$company_id;
		$this->data['action_']=$option;
		if($option=='insert')
		{	
			$this->session->set_flashdata('success_inserted',"Success");
		}
		elseif($option=='update')
		{
			$this->session->set_flashdata('success_updated',"Success");
		}
		else
		{
			$this->session->set_flashdata('error',"Error");
		}



		$this->data['check_exist'] = $this->employee_account_management_model->check_if_mob_tel_exist($company_id);
		$this->data['company_id']=$company_id;


		$this->data['edit_201_settings']=$this->session->userdata('edit_201_settings');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$this->data['location'] = $this->employee_account_management_model->get_company_location($company_id);
		$this->load->view('app/employee/employee_account_management/set_up_mob_tel_format',$this->data);
	}
	
}