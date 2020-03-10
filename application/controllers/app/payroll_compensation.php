<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Payroll_compensation extends General{

	function __construct(){
		parent::__construct();
		$this->load->model("app/payroll_emp_loan_enrolment_model");	
		$this->load->model("app/payroll_compensation_model");
		$this->load->model("app/employee_model");
		$this->load->model("general_model");
		$this->load->model("employee_portal/salary_approver_model");
		$this->load->model("app/transaction_employees_model");
		$this->load->dbforge();

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){	

		$this->payroll_compensation();	
	}

	public function payroll_compensation(){

		$this->data['onload']     = $this->session->flashdata('onload');
		$this->data['message']    = $this->session->flashdata('message');			

		$this->load->view('app/payroll/compensation/compensation',$this->data);		

	}

	//==================================== SALARY REASON MANAGEMENT =============================================
	
	public function salary_reason_management_view(){	 

		$this->load->view('app/payroll/compensation/salary_reason_management/view',$this->data);		
	}

	public function company_reason_view(){	 

		$company_id 						= $this->uri->segment("4");
		$this->data['company_info']			= $this->payroll_compensation_model->get_company_info($company_id);
		$this->data['company_reason'] 		= $this->payroll_compensation_model->get_company_reason($company_id); 
	
		$this->load->view('app/payroll/compensation/salary_reason_management/company_reason',$this->data);
	
	}

	public function salary_reason_inactivate(){

        $reason_id             	= $this->uri->segment("4");

		$this->payroll_compensation_model->inactive_reason($reason_id);
        General::logfile('PAYROLL->salary reason','INACTIVATE',$reason_id);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Salary Reason Successfully Inactivate.</div>");

        redirect('app/payroll_compensation');
	}

	public function salary_reason_activate(){

		$reason_id             	= $this->uri->segment("4");

		$this->payroll_compensation_model->activate_reason($reason_id);
        General::logfile('PAYROLL->salary reason','ACTIVATE',$reason_id);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Salary Reason Successfully Activate.</div>");

        redirect('app/payroll_compensation');
	}

	public function salary_reason_add_view(){

		$company_id 						= $this->uri->segment("4");
		$this->data['company_info']			= $this->payroll_compensation_model->get_company_info($company_id);
		$this->data['company_reason'] 		= $this->payroll_compensation_model->get_company_reason($company_id); 

		$this->load->view('app/payroll/compensation/salary_reason_management/add',$this->data);

	}

	public function add_save(){
		$company_id 		  = $this->uri->segment("4");
		$reason_title		  = $this->input->post("reason_title");
		

		 $alreadyexist = $this->payroll_compensation_model->exist_sr_management($company_id);
        if($alreadyexist == 1){
       	$value = $this->input->post('reason_title');		
		$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> This, <strong>".$value."</strong>,  Salary reason is Already exist!.</div>");	

        redirect('app/payroll_compensation');

        }else{
		$value = $this->input->post('reason_title');
        $this->payroll_compensation_model->add_reason();
		General::logfile('PAYROLL->compensation->salary reason','ADD',$company_id);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> This, <strong>".$value."</strong>,  Salary reason Successfully Added.</div>");	

        redirect('app/payroll_compensation');
 		}

      }

	public function salary_reason_edit_view(){

		$reason_id 							= $this->uri->segment("4");

		$reason 							= $this->payroll_compensation_model->get_reason_info($reason_id);
		$company_id 						= $reason->company_id;

		$this->data['company_info']			= $this->payroll_compensation_model->get_company_info($company_id);
		$this->data['company_reason'] 		= $this->payroll_compensation_model->get_company_reason($company_id); 
		$this->data['reason_info'] 			= $this->payroll_compensation_model->get_reason_info($reason_id);
	
		$this->load->view('app/payroll/compensation/salary_reason_management/edit',$this->data);

	}

	public function edit_save(){
		$reason_id 				  = $this->uri->segment("4");
		$reason_title		  	  = $this->input->post("reason_title");
		$reason_description		  = $this->input->post("reason_description");
		$company_id 			  = $this->input->post('company_id');

		    $this->form_validation->set_rules("reason_title","Flexi Time Groupname","trim|required|callback_validate_reason_title");
            $this->form_validation->set_rules("reason_description","Flexi Time Description","trim|required|callback_validate_reason_des");
            $this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

        if($this->form_validation->run()){

		$value = $this->input->post('reason_title');	
        $this->payroll_compensation_model->edit_reason($reason_id);
		General::logfile('PAYROLL->compensation->salary reason','EDIT',$reason_id);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> This, <strong>".$value."</strong>, Salary reason successfully Modified.</div>");	

        redirect('app/payroll_compensation');
  		
  		}else{

               $this->session->set_flashdata('onload',"view(".$company_id.")");
                $this->index();
               /* $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group is Already Exist to this company ".$company_name->company_name."</div>");
              redirect('app/time_flexi_schedule');
*/
       
      }
    }

    public function validate_reason_title(){
        $company_id =$this->input->post('company_id');     
        $value = $this->input->post('reason_title');
        $reason_id 		= $this->uri->segment("4");
        if($this->payroll_compensation_model->validate_reason_title($reason_id)){
            $this->form_validation->set_message("validate_reason_title"," Group Name, <strong>".$value."</strong>, Already Exists.");
            return false;
        }else{
            return true;
        }
    }
    public function validate_reason_des(){
        $company_id =$this->input->post('company_id');     
        $value = $this->input->post('reason_description');
        $reason_id 		= $this->uri->segment("4");
        if($this->payroll_compensation_model->validate_reason_des($reason_id)){
            $this->form_validation->set_message("validate_reason_des"," Group Description, <strong>".$value."</strong>, Already Exists.");
            return false;
        }else{
            return true;
        }
    }



	public function salary_reason_delete(){
		$reason_id             	= $this->uri->segment("4");

        $this->payroll_compensation_model->delete_reason($reason_id);
        General::logfile('PAYROLL->Compensation->Salary reason','DELETE',$reason_id);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Salary Reason Successfully Deleted.</div>");

        redirect('app/payroll_compensation');
	}

	//================================== END OF SALARY REASON MANAGEMENT =========================================
	
	//======================================== SALARY MANAGEMENT =================================================

	public function salary_management_view(){	 

		$this->load->view('app/payroll/compensation/salary_management/view',$this->data);		

	}



	public function company_employee_view(){

		$company_id             = $this->uri->segment("4");

		$this->data['company_employee'] 			= $this->payroll_compensation_model->get_company_employee($company_id);

		$this->load->view('app/payroll/compensation/salary_management/company_employee',$this->data);		

	}

	public function reapply_employee_subj_contri(){
		$company_id=$this->uri->segment("4");

		if(!empty($this->input->post('gov_subject'))){
			foreach ($this->input->post('gov_subject') as $key => $g){
				$this->payroll_compensation_model->reapply_employee_subj_contri($company_id,$g);

				$details="$company_id|$g";
				General::logfile('PAYROLL->compensation->salary info','Edit Government Subject to Deduction',$details);

			}


		}else{

		}

		 $this->session->set_flashdata('onload',"salary_management()");
		 redirect('app/payroll_compensation');

	}




	public function checked_all_loc_gov($company_id){
		$comploc=$this->payroll_compensation_model->checked_all_loc_gov($company_id);
		if(!empty($comploc)){
			foreach($comploc as $l){

				$query=$this->db->query("DELETE from salary_gov_default_value where company_id='".$company_id."' and location_id='".$l->location_id."' ");

				$insert_gov_loc= array(
					'company_id'	=>	$company_id,
					'location_id'	=>	$l->location_id,
					'withholding_tax'	=> '1',
					'pagibig'	=> '1',
					'sss'	=> '1',
					'philhealth'	=> '1',
					'date_added'	=> date('Y-m-d H:i:s')
				);
				$this->payroll_compensation_model->insert_gov_loc($insert_gov_loc);

			}
		}else{

		}


			
		 // $this->session->set_flashdata('onload',"salary_management_gov_default()");
		 // redirect('app/payroll_compensation');


	}
//NEMZ START CODE================================
	public function salary_management_gov_default_value(){	 

		$this->load->view('app/payroll/compensation/salary_gov_default/default_view',$this->data);		

	}

	public function company_location_view(){

		$company_id             = $this->uri->segment("4");

		$this->data['company_location'] 			= $this->payroll_compensation_model->get_company_location($company_id);
		$com_location = $this->payroll_compensation_model->get_company_location($company_id);
		
		$this->data['gov_default_value'] 			= $this->payroll_compensation_model->get_company_def_value($company_id);

		$this->load->view('app/payroll/compensation/salary_gov_default/company_location_gov_default_value',$this->data);		

	}

	public function gov_default_add(){
			$company_id           = $this->uri->segment("4");	
			$location_id 			= $this->uri->segment("5");
		
		$this->load->view('app/payroll/compensation/salary_gov_default/add_gov_default_value',$this->data);		

	}

public function save_add_def_value(){

		
		$company_id  					= $this->input->post("company_id");
		$location_id  					= $this->input->post("location_id");

		$already_exist 				= $this->payroll_compensation_model->check_gov_def_value($company_id,$location_id);
		

		if($already_exist == 1){
			$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  Gov Subject to Default Value Already Exist.</div>");
		}
		else{
			
			$this->payroll_compensation_model->add_gov_def_value();

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  Gov Subject to Default Value Successfully Added.</div>");	
		}

        redirect('app/payroll_compensation');

	}


public function gov_default_edit(){
			$gov_id           = $this->uri->segment("4");


				$this->data['gov_default_edit'] 			= $this->payroll_compensation_model->get_gov_default($gov_id);	
			
		
		$this->load->view('app/payroll/compensation/salary_gov_default/edit_gov_default_value',$this->data);		

	}

public function save_edit_def_value(){
	

			$gov_id           = $this->input->post("gov_id");

			
			$this->payroll_compensation_model->edit_gov_def_value($gov_id);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  Gov Subject to Default Value Successfully Modified!.</div>");	
	

        redirect('app/payroll_compensation');

	}


//NEMZ END CODE==========================================

	public function employee_salary_view(){

		$employee_id            			= $this->uri->segment("4");
		
		
		$employee_employment 				= $this->payroll_compensation_model->get_employee_employment($employee_id);
		$company_id 						= $employee_employment->company_id;
		

		$this->data['employee_salary'] 		= $this->payroll_compensation_model->get_employee_salary($employee_id,$company_id);
		$this->data['employee_employment'] 	= $this->payroll_compensation_model->get_employee_employment($employee_id);
		$this->data['employee_pagibig'] 	= $this->payroll_compensation_model->get_employee_pagibig($employee_id,$company_id);
		$this->data['employee_philhealth'] 	= $this->payroll_compensation_model->get_employee_philhealth($company_id);
		$this->data['employee_sss'] 	    = $this->payroll_compensation_model->get_employee_sss($company_id);
	
		$employee_salary 					= $this->payroll_compensation_model->get_employee_salary($employee_id,$company_id);
		if(count($employee_salary) > 0){
			$salary_id 							= $employee_salary->salary_id;
			$salary_rate 						= $employee_salary->salary_rate;
		
			if($salary_rate === '1'){

				$this->data['computation'] 	    = $this->payroll_compensation_model->get_computation_daily($salary_id);

			}
			else if($salary_rate === '2'){

				$this->data['computation'] 	    = $this->payroll_compensation_model->get_computation_monthly($salary_id);

			}
			else if($salary_rate === '3'){

				$this->data['computation'] 	    = $this->payroll_compensation_model->get_computation_daily($salary_id);

			}
			else if($salary_rate === '4'){

				$this->data['computation'] 	    = $this->payroll_compensation_model->get_computation_monthly($salary_id);

			}
		}
		

		$this->load->view('app/payroll/compensation/salary_management/employee_salary',$this->data);	

	}

	public function employee_salary_add(){

		$employee_id              		  	= $this->uri->segment("4");
		$employee_info 						= $this->payroll_compensation_model->get_employee_employment($employee_id);
		$company_id  						= $employee_info->company_id;
		$location_id 						= $employee_info->location;
		
		$this->data['get_report_to']		= $this->payroll_compensation_model->get_report_to($employee_id);
		$this->data['get_approvers']		= $this->payroll_compensation_model->get_approvers($employee_id);

		$this->data['no_hours']				= $this->payroll_compensation_model->get_no_hours();
		$this->data['no_days_monthly']		= $this->payroll_compensation_model->get_no_days_monthly();
		$this->data['no_days_yearly']		= $this->payroll_compensation_model->get_no_days_yearly();
		$this->data['salary_rate'] 			= $this->payroll_compensation_model->get_salary_rate();
		$this->data['salary_reason'] 		= $this->payroll_compensation_model->get_salary_reason($company_id);

		$this->data['gov_default']  		= $this->payroll_compensation_model->get_gov_default_sal($company_id,$location_id);  

		$this->load->view('app/payroll/compensation/salary_management/add',$this->data);	
	}



	public function save_employee_salary(){

		$employee_id                	= $this->uri->segment("4");
		$employee_info 					= $this->payroll_compensation_model->get_employee_employment($employee_id);
		$company_id  					= $employee_info->company_id;
		$check_employee 				= $this->payroll_compensation_model->check_employee_salary($employee_id);
		$current_date_effective 		= $this->input->post('date_effective');
		$check_salary_date 				= $this->payroll_compensation_model->check_salary_date($employee_id,$company_id,$current_date_effective);

		if($check_salary_date){
			$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  Salary information effectivity date already exist.</div>");
		}
		else{
			// if($check_employee){

			// 	$this->payroll_compensation_model->inactive_salary_info($employee_id);

			// }

			$this->payroll_compensation_model->add_salary_info($company_id,$employee_id);
			General::logfile('PAYROLL->compensation->salary info','ADD',$employee_id);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  Salary information successfully added.</div>");	
		}

        redirect('app/payroll_compensation');

	}

	public function employee_government_deduction_edit(){

		$salary_id  	         			= $this->uri->segment("4");
		$salary_info 						= $this->payroll_compensation_model->get_salary_info($salary_id);
		$employee_id 						= $salary_info->employee_id;
		$employee_employment 				= $this->payroll_compensation_model->get_employee_employment($employee_id);
		$company_id 						= $employee_employment->company_id;

		$this->data['employee_salary'] 		= $this->payroll_compensation_model->get_employee_salary($employee_id,$company_id);
		$this->data['employee_employment'] 	= $this->payroll_compensation_model->get_employee_employment($employee_id);
		$this->data['employee_pagibig'] 	= $this->payroll_compensation_model->get_employee_pagibig($employee_id,$company_id);
		$this->data['employee_philhealth'] 	= $this->payroll_compensation_model->get_employee_philhealth($company_id);
		$this->data['employee_sss'] 	    = $this->payroll_compensation_model->get_employee_sss($company_id);

		$this->load->view('app/payroll/compensation/salary_management/edit_government',$this->data);	

	}

	public function modify_government_deduction(){

		$salary_id  	         			= $this->uri->segment("4");

		$this->payroll_compensation_model->edit_salary_government($salary_id);
		General::logfile('PAYROLL->compensation->salary info','EDIT',$salary_id);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  Salary Information Government Deduction subject to successfully modified.</div>");	

        redirect('app/payroll_compensation');
		
	}


	public function labas_monthly(){

		$value = $this->uri->segment("4");

		if($value == 1){
				$this->data['salary_rate'] 			= $this->payroll_compensation_model->get_salary_rate_monthly();

				$this->load->view('app/payroll/compensation/salary_management/monthly_only',$this->data);	
		}else{
				$this->data['salary_rate'] 			= $this->payroll_compensation_model->get_salary_rate();

				$this->load->view('app/payroll/compensation/salary_management/salary_rate_def',$this->data);	
	

		}

	}


	public function employee_salary_history(){

		$employee_id  	         			= $this->uri->segment("4");

		$this->data['employee_salary_history'] 		= $this->payroll_compensation_model->get_employee_salary_history($employee_id);

		$this->load->view('app/payroll/compensation/salary_management/history',$this->data);	

	}

	public function employee_salary_computation(){

		$salary_rate  	         			= $this->uri->segment("4");

		$this->load->view('app/payroll/compensation/salary_management/computation',$this->data);	

	}

	//manual upload form
	public function salary_information_manualupload()
	{
		$this->data['userInfo'] = $this->general_model->getUserLoggedIn($this->session->userdata('username'));
		$this->data['query'] = $this->payroll_emp_loan_enrolment_model->payrollCompany();
		$this->load->view('app/payroll/compensation/salary_information_manualupload/manual_upload',$this->data);	
	}

	//START OF SALARY INFORMATION MANUAL UPLOAD
	public function salary_information_manualupload_template()
	{

        $this->load->helper('download');            
		$path    =   file_get_contents(base_url()."public/downloadable_templates/salary_information_manual_upload.xls");
		$name    =   "salary_information_manual_upload.xls";
		force_download($name, $path); 
		$value = $name;
		General::logfile('Employee Personal Info Template','DOWNLOAD',$value);
	}
	//import the salary information
	public function save_salary_info_manualupload()
	{
		$numOfEmp 		= 0;
    	$foundError 	= False;
    	$excelEmpID 	= array();
    	//$excelEmpName 	= array();
    	$result 		= 0;

    	$fileName = $_FILES['file']['name'];
		$action = $_POST['action'];
		$company = $_POST['company'];
		$add_edit = $_POST['add_edit'];

		$config['upload_path'] 		= './public/import_template/'; 
	    $config['file_name'] 		= $fileName;
	    $config['allowed_types'] 	= 'xlsx|xls';
	    $config['max_size'] 		= 10000;
	    
	    $this->load->library('upload');
	    $this->upload->initialize($config);
	    if(! $this->upload->do_upload('file') )
	        $this->upload->display_errors();
	        $media = $this->upload->data('file');
	        $inputFileName = './public/import_template/'.$fileName;
	        $imagepath    =   "user.png";
	        try 
	        {
	            $inputFileType 	= IOFactory::identify($inputFileName);
	            $objReader 		= IOFactory::createReader($inputFileType);
	            $objPHPExcel 	= $objReader->load($inputFileName);
	        
	        $objPHPExcel->setActiveSheetIndex(0);
			$sheet 			= $objPHPExcel->getSheet(0);
	        $highestRow 	= $sheet->getHighestRow();
	        $highestColumn 	= $sheet->getHighestColumn();
	        $colNumber 		= PHPExcel_Cell::columnIndexFromString($highestColumn);
	            //get the number of license
	        $data 		= $this->employee_model->get_employeee_license(1);
	        $numLicense = $data[0]->myhris;
	        $numisEmployee = $this->employee_model->get_employee_isEmployee(1);
	        $numImportexcel		= $highestRow - 1;
	        $totalEmployee		= $numImportexcel + $numisEmployee;
	        $allowedEmployee 	= $numLicense - $numisEmployee;

		if(isset($_POST["import"]))	
		{
			//start of action (if add/modify record)
				//start preview or insert

				if($action=='Save')
				{ 
					 if($totalEmployee  <= 	$numLicense)
					 {
				            $styleArray = array(
						    'font'  => array(
						        'bold'  => true,
						        'color' => array('rgb' => 'FF0000')
						    ));
		         			$nameIndex		= 0;

					       for ($row = 2; $row <= $highestRow; $row++){
					         	$colLetter 		= 'A';
					         	$companyTemp 	= 0;
					         	$divisionTemp 	= 0;
					         	$departmentTemp = 0;
					         	$sectionTemp 	= 0;
					         	$isSubsection 	= false;
							 	$isDivision   	= false;
					            for($col = 0; $col < $colNumber; $col++){
					            	$colrow = $colLetter.(string)$row;    
								    $getCellvalue = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
								    	if(empty($getCellvalue)){//If null
								    		if($col == 0 || $col == 1 || $col == 2 || $col == 3 || $col == 4 || $col == 5 || $col == 6 || $col == 7 || $col == 8 || $col == 9 || $col == 10 || $col == 11 || $col == 12){ // for null
											$objPHPExcel->getActiveSheet()->
											setCellValueByColumnAndRow($col, $row,  'Value cannot be Null');
											$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
											}
						            	}
			            				else{//If not null
						            		if($col==0){
						            			$excelEmpID[] = $getCellvalue; // pass the value to array $excelEmpID[]
						            			if ($getCellvalue{0}=="0") { // empID that start with zero
													$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '. 'Employee should not start with 0');//start zero
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignmdent()->setWrapText(true);
													$foundError = True;
												}
						            		}
						            		if($col==0 || $col==2 || $col==3 || $col==4 || $col==5 || $col==6 || $col==7){
						            			if(!is_numeric($getCellvalue)){
														$objPHPExcel->getActiveSheet()->
														setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.'Must be Number.');//Number
														$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
														$foundError = True;
												}
						            		}
									        if($col==8 || $col==9 || $col==10 || $col==11 || $col==12)
									            		{
									            			$yes_no_value =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
															$checker_value = $this->validateyes_no($yes_no_value);
															
															//echo '<br>'.$new_date;
															//echo '<br>'.date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($new_date));
															if($checker_value === false){
																$objPHPExcel->getActiveSheet()->
																	setCellValueByColumnAndRow($col, $row,  $checker_value.' -> '.'Invalid value. Yes or No only');//doesn't exist
																	$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																		$foundError = True;
															}
									            		}
									         if($col==0){
										            		$employee_companylist =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
															$resultemployee_companylist = $this->payroll_emp_loan_enrolment_model->employee_company_checker_model($employee_companylist,$company);
															if($resultemployee_companylist === false){	
																$objPHPExcel->getActiveSheet()->
																	setCellValueByColumnAndRow($col, $row,  $employee_companylist.' -> '.'Employee ID doesnt exist in employee list under company id '.$company);//doesn't exist
																	$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																		$foundError = True;
																}
															}

									        if($col==7){
										            		$reason =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
															$reason_checker = $this->payroll_compensation_model->checker_reason($reason);
															if($reason_checker === false){	
																$objPHPExcel->getActiveSheet()->
																	setCellValueByColumnAndRow($col, $row,  $reason.' -> '.'Invalid Reason.');//doesn't exist
																	$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																		$foundError = True;
																}
															}
											if($col==2){
										            		$salary_rate =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
															$checker_salaryrate = $this->validate_salaryrate($salary_rate);
															
															//echo '<br>'.$new_date;
															//echo '<br>'.date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($new_date));
															if($checker_salaryrate === false){
																$objPHPExcel->getActiveSheet()->
																	setCellValueByColumnAndRow($col, $row,  $salary_rate.' -> '.'Invalid salary rate');//doesn't exist
																	$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																		$foundError = True;
															}
														}
									        if($col==1 )
									            		{
									            			$date =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
															$check = $this->validateDate($date);
															if($check == false)
															{
																$objPHPExcel->getActiveSheet()->
																	setCellValueByColumnAndRow($col, $row,  $date.' -> '.'Invalid Date');//doesn't exist
																	$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																		$foundError = True;
															}
															else
															{
																$getemp = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();	
																$emp_date_effective = $this->payroll_compensation_model->emp_lastdate_effective($getemp);
																	if($emp_date_effective == true)
																	{
																		$date_effective_data = $this->payroll_compensation_model->emp_lastdate_effective_data($getemp);
																		$check_datedata = $this->validateDate_effective($date_effective_data,$date);
																		if($add_edit=='new'){
																		if($check_datedata == 'false')
																		{
																			$objPHPExcel->getActiveSheet()->
																			setCellValueByColumnAndRow($col, $row,  $date.' -> '.'Date_effective here must be greater than the old salary date_effective');//doesn't exist
																			$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																			$foundError = true;
																		}}
																	}
																	else
																	{}
															}
									            		}

									        	/*if($add_edit=='edit')
									        	{
									        		 if($col==0){
													
									            		$employee_companylist =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
														$resultemployee_companylist_max = $this->payroll_compensation_model->employee_max_company_checker_model($employee_companylist,$company);

														if($resultemployee_companylist_max === 0){
															$objPHPExcel->getActiveSheet()->
																setCellValueByColumnAndRow($col, $row,  $employee_companylist.' -> '.'No existing data for Employee '.$employee_companylist);//doesn't exist
																$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																	$foundError = True;
																}
															}

													 if($col==1){
														$employee_companylist =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
									            		$date_effective =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
														$date_effective_max = $this->payroll_compensation_model->date_effective_second_max($employee_companylist);
														$check_datedata = $this->validateDate_effective($date_effective_max,$date_effective);
														if($check_datedata == 'false')
															{
																$objPHPExcel->getActiveSheet()->
																setCellValueByColumnAndRow($col, $row,  $date_effective.' -> '.'Date_effective here must be greater than the old salary date_effective');//doesn't exist
																$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																$foundError = true;
															}
														}
									        	}*/
						           			}
		         						$colLetter++;// increment A
									}//end of col for loop
			         		}//end of row for loop
			        		if($add_edit=='new'){
			        		$colLetter 		= 'A';
							$result 		= count($excelEmpID);
							for($value = 0 ; $value < $result ; $value++){
								$exRow 		= $value + 2;
								$colrow 	= $colLetter.(string)$exRow;
								$tempvalue 	= $excelEmpID[$value];
								$compVal 	= $value+1;
								//echo 'value:'.$value;
								$compExcelEmpID 	= $this->compare_empID_excel($compVal,$excelEmpID,$tempvalue);
								if($compExcelEmpID){
									$getCellvalue 	= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $exRow)->getValue();
									$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow(0, $exRow,$getCellvalue.' -> '.'Duplicate Employee ID in excel.');//Exist in database
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
									$foundError 	= True;
								}
							} }
		         			 //End of check and rewrite the error of imported excel
					        if($foundError==False)
					        { // insert to employee_info table
					        		
					        	for ($row = 2; $row <= $highestRow; $row++)
					        	{	
					        		$numOfEmp++;                                  
								    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL,TRUE,FALSE);
		                			$date_created 	= date('Y-m-d H:i:s');
		                			$user= $this->payroll_compensation_model->getUserLoggedIn($this->session->userdata('username'));

		                						if($rowData[0][8]=='yes' || $rowData[0][8]=='Yes' || $rowData[0][8]=='YES')
								               {
								               		$fixed = 1;
								               }
								               else{
								               		$fixed = 0;
								               }
								               if($rowData[0][9]=='yes' || $rowData[0][9]=='Yes' || $rowData[0][9]=='YES')
								               {
								               		$withholding_tax = 1;
								               }
								               else{
								               		$withholding_tax = 0;
								               }
								                if($rowData[0][10]=='yes' || $rowData[0][10]=='Yes' || $rowData[0][10]=='YES')
								               {
								               		$pagibig = 1;
								               }
								               else{
								               		$pagibig = 0;
								               }
								                 if($rowData[0][11]=='yes' || $rowData[0][11]=='Yes' || $rowData[0][11]=='YES')
								               {
								               		$sss = 1;
								               }
								               else{
								               		$sss = 0;
								               }
								                 if($rowData[0][12]=='yes' || $rowData[0][12]=='Yes' || $rowData[0][12]=='YES')
								               {
								               		$philhealth = 1;
								               }
								               else{
								               		$philhealth = 0;
								               }
								               $employee_id= $rowData[0][0];

								                $data = array('company_id'  		=> $company,
								                				'employee_id'  		=> $rowData[0][0],
								                				'date_effective'  	=> $rowData[0][1],
								                				'salary_rate'  		=> $rowData[0][2],
								                				'salary_amount'  	=> $rowData[0][3],
								                				'no_of_hours'  		=> $rowData[0][4],
								                				'no_of_days_monthly'=> $rowData[0][5],
								                				'no_of_days_yearly' => $rowData[0][6],
								                				'reason'  			=> $rowData[0][7],
								                				'is_salary_fixed'  	=> $fixed,
								                				'date_added'  		=> date('Y-m-d H:i:s'),
								                				'user_id'  			=> $user,
								                				'InActive'  		=> 0,
								                				'withholding_tax'  	=> $withholding_tax,
								                				'pagibig'  			=> $pagibig,
								                				'sss'  				=> $sss,
								                				'philhealth'  		=> $philhealth,
								                				'salary_option'  		=> 'no_approvers',
								                				'salary_status'  		=> 'approved',
								                				'entry_type'  		=> 'manual upload'
								                			);

								                if($add_edit=='edit')
								                { 
								                	
													$update = $this->payroll_compensation_model->update_salary_info_manualupload($data,$employee_id);
																if($update=='updated')
																{ 
																	$success=$update;
																} 
													
								                }
								                else{
								                	
	                								$insert = $this->payroll_compensation_model->insert_salary_info_manualupload($data);
	                								if($insert=='inserted')
													{
														
														$success=$insert;
													}
	                							}
				            	}//end of insert
						        if($success)
						        { //file name for successfully imported
						        		if($add_edit=='new')
						        		{
						        		$this->data['action']='insert';
						        		}
						        		else{ $this->data['action']='update'; }
						        		$this->data['add_edit']='new';
										$this->data['count_data']=$highestRow - 1;
										$this->data['company']=$company;
										$this->load->view('app/payroll/compensation/salary_information_manualupload/review_upload/template_header',$this->data);
										for ($row = 2; $row <= $highestRow; $row++){
											$this->data['col_0']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
											$this->data['col_1']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
											$this->data['col_2']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
											$this->data['col_3']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
											$this->data['col_4']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
											$this->data['col_5']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
											$this->data['col_6']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $row)->getValue();
											$this->data['col_7']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
											$this->data['col_8']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $row)->getValue();
											$this->data['col_9']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9, $row)->getValue();
											$this->data['col_10']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(10, $row)->getValue();
											$this->data['col_11']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(11, $row)->getValue();
											$this->data['col_12']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(12, $row)->getValue();
											$this->load->view('app/payroll/compensation/salary_information_manualupload/review_upload/template_content',$this->data);
										}
										$this->load->view('app/payroll/compensation/salary_information_manualupload/review_upload/template_footer',$this->data);
									     $dt = $date_array = getdate();
									     if($add_edit=='save'){
									     $formated_date  = "payroll_compensation_salary_information";}
									     else{ $formated_date  = "payroll_compensation_salary_information_overwrite"; }
									     $formated_date .= $date_array['mon'];
									     $formated_date .= $date_array['mday'];
										 $formated_date .= $date_array['year'] . "_";
										 $formated_date .= $date_array['hours'];
									     $formated_date .= $date_array['minutes'];
										 $formated_date .= $date_array['seconds'];
									     rename( $inputFileName, './public/import_template/'.$formated_date.'.xls' );
									    	//redirect('app/payroll_compensation/index');
								} //end of file name for successfully imported
							}//end of else find error
							else{//download if found an error
								header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
								header('Content-Disposition: attachment;filename="' ."salary_information_errr". '""' .date('Y-m-d')."_".date('H:i:s').".xlsx".'"');
								header('Cache-Control: max-age=0');
								unlink($inputFileName);
								$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
								$objWriter->save('php://output');
								exit; 
				}//end of download if found an error
						}//end of For license purpose
					}
				//preview
				else
				{
					$this->data['action']='review';
					$this->data['add_edit']='new';
					$this->load->view('app/payroll/compensation/salary_information_manualupload/review_upload/template_header',$this->data);
					for ($row = 2; $row <= $highestRow; $row++)
						{
								$col_0 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
								$col_1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
								$col_2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
								$col_3 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
								$col_4 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
								$col_5 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
								$col_6 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $row)->getValue();
								$col_7 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
								$col_8 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $row)->getValue();
								$col_9 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9, $row)->getValue();
								$col_10 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(10, $row)->getValue();
								$col_11 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(11, $row)->getValue();
								$col_12 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(12, $row)->getValue();

								if(empty($col_0) || empty($col_1) || empty($col_2) || empty($col_3) || empty($col_4) || empty($col_5) || empty($col_6) || empty($col_7) || empty($col_8) || empty($col_9) || empty($col_10) || empty($col_11) || empty($col_12) ){
									$foundError=True;
									$null='Check empty fileds/ ';
								}
								else{ $foundError=False; $null=''; }

								$checkvalue_col3 = $this->containsDecimal($col_3);
								if($checkvalue_col3 === false){ $foundError = True; $amt_res='Invalid Salary Amount/ '; } else{ $foundError = False; $amt_res=""; }

								 $checker_value8 = $this->validateyes_no($col_8);
								 $checker_value9 = $this->validateyes_no($col_9);
								 $checker_value10 = $this->validateyes_no($col_10);
								 $checker_value11 = $this->validateyes_no($col_11);
								 $checker_value12 = $this->validateyes_no($col_12);

								if($checker_value8 === 'false' || $checker_value9 === 'false' || $checker_value10 === 'false' || $checker_value11 === 'false' || $checker_value12 === 'false'){
									$foundError = True;
									$yesno='Invalid Yes or No/';
								}
								$employee_companylist =$col_0;
								$resultemployee_companylist = $this->payroll_emp_loan_enrolment_model->employee_company_checker_model($employee_companylist,$company);
									if($resultemployee_companylist === false){	
										$foundError = True;
										$compemp = 'Employee ID doesnt exist in company ' .$company."/ ";
									} else{ $compemp =""; } 
							 
								$reason =$col_7;
								$reason_checker = $this->payroll_compensation_model->checker_reason($reason);
								if($reason_checker === false){	
									$foundError = True;
									$emp_reason='Invalid Reason ID/ ';
								} else{ $emp_reason=""; } 

								$salary_rate =$col_2;
								$checker_salaryrate = $this->validate_salaryrate($salary_rate);
								if($checker_salaryrate === false){
									$foundError = True;
									$sal ='Invalid Salary Rate/ ';
								} else{ $sal ="";  }

								
								$date =$col_1;
								$getemp = $col_0;	
								$emp_date_effective = $this->payroll_compensation_model->emp_lastdate_effective($getemp);
									if($emp_date_effective === true)
										{
											$date_effective_data = $this->payroll_compensation_model->emp_lastdate_effective_data($getemp);
											$check_datedata = $this->validateDate_effective($date_effective_data,$date);
												if($add_edit=='new'){
													if($check_datedata === 'false')
														{
															$foundError = True;
															$dateeff = 'Invalid Date Effective/ ';
														}
													else { $dateeff=""; }
											}
									}

								if($add_edit=='edit'){
								$resultemployee_companylist_max = $this->payroll_compensation_model->employee_max_company_checker_model($employee_companylist,$company);
								if($resultemployee_companylist_max === 0){
									$foundError = True;
									}
								else{  }

								$date_effective =$col_1;
								$date_effective_max = $this->payroll_compensation_model->date_effective_second_max($employee_companylist);
								$check_datedata = $this->validateDate_effective($date_effective_max,$date_effective);
								if($check_datedata == 'false')
									{
										$foundError = True;
										$dateeff = 'Invalid Date Effective/ ';
									}
								else { $dateeff=""; }
								}

							$employee_id =$col_0;
								$resultemployee_companylists = $this->payroll_compensation_model->employee_exist_salary($employee_id);
								//start hidden : 01/10/2018
									if($resultemployee_companylists === false){	
										$foundError = True;
										$compemps = 'Employee doesnt have previous salary information data yet. if you want to Save this information you may proceed to "Upload and Save Action"	!';
									} else{ $compemps =""; } 
								//end hidden : 01/10/2018

								//for compare excel employee_id
								$colLetter 		= 'A';
								$getCellvalue = $col_0;
								$excelEmpID[] = $getCellvalue;
								$result 		= count($excelEmpID);
								$exist_Ex="";
								for($value = 0 ; $value < $result ; $value++){
									$exRow 		= $value + 2;
									$colrow 	= $colLetter.(string)$exRow;
									$tempvalue 	= $excelEmpID[$value];
									$compVal 	= $value+1;
									//echo 'value:'.$value;
									$compExcelEmpID 	= $this->compare_empID_excel($compVal,$excelEmpID,$tempvalue);
									if($compExcelEmpID){
										$foundError 	= True;
										if($foundError=='true'){
									$exist_Ex='Duplicate Employee ID in excel'; } else{ $exist_Ex=""; }
									}
									$exist_excel=$exist_Ex;
								}

								$this->data['col_0']= $col_0;
								$this->data['col_1']= $col_1;
								$this->data['col_2']= $col_2;
								$this->data['col_3']= $col_3;
								$this->data['col_4']= $col_4;
								$this->data['col_5']= $col_5;
								$this->data['col_6']= $col_6;
								$this->data['col_7']= $col_7;
								$this->data['col_8']= $col_8;
								$this->data['col_9']= $col_9;
								$this->data['col_10']= $col_10;
								$this->data['col_11']= $col_11;
								$this->data['col_12']= $col_12;


								if($foundError===True)
								{

									$this->data['remarks']= 'Error';
									$this->data['errors'] = $null.$yesno.$compemp.$emp_reason.$dateeff.$sal.$amt_res.$exist_excel.$compemps;
								}
								else{
									$this->data['remarks']= 'Ok';
								}
								$this->data['foundError']=$foundError;
								$this->load->view('app/payroll/compensation/salary_information_manualupload/review_upload/template_content',$this->data);
						}
						$this->load->view('app/payroll/compensation/salary_information_manualupload/review_upload/template_footer',$this->data);
						unlink($inputFileName);	
					  }//end preview or insert
			}//if submit name !=import

		else
		{
			echo "Please contact the technical support for errors!.";
		}
		} 
	     catch(Exception $e) {
			echo "<script>alert('Invalid file format.Please use the template.If you used the downloaded error file please make sure you resave as to save the changes and prevent error.Thanks!')</script>";
			echo " <script type='text/javascript'>
					    open(location, '_self').close();
					</script>";
	  	}
	}
	
	public function validateyes_no($yes_no_value)
	{
		if($yes_no_value == 'Yes' || $yes_no_value == 'yes' || $yes_no_value == 'YES')
		{
			return true;
		}
		elseif($yes_no_value == 'No' || $yes_no_value == 'no' || $yes_no_value == 'NO')
		{
			return 'true';
		}
		else{
			return 'false';
		}
	}
	  //check date format
     public function validateDate($date, $format = 'Y-m-d')
	{
	    $d = DateTime::createFromFormat($format, $date);
	    if($d && $d->format($format) == $date){
	    	return true;
	    }
	    else{
	    	return false;
	    }
	}

	public function validateDate_effective($date_effective_data,$date)
	{
		 
		  if($date_effective_data < $date) {
		       return 'true'; } 
		  else

		  	{ return 'false'; }
	}

	public function validate_salaryrate($salary_rate)
	{
		if($salary_rate == '1' || $salary_rate == '2' || $salary_rate == '3' || $salary_rate == '4')
		{
			return true;
		}
		else{
			return false;
		}
	}
	public function compare_empID_excel($compVal,$excelEmpID,$tempvalue){
		$result = count($excelEmpID);
		for($value = $compVal; $value < $result; $value++){
			if($excelEmpID[$value]==$tempvalue){
				return true;
			}
		}
	}

	//check if decimal
	function containsDecimal( $value ) {

	if ( strpos( $value, "." ) !== false ||  is_numeric($value) !==false) {
	        return true;
	    }
	    return false;
	}
	//==================================== END OF SALARY MANAGEMENT ==============================================



	//list of pending compensation
	public function pending_salary_information_approval()
	{
		$this->data['details']=$this->payroll_compensation_model->pending_salary_approval();
		$this->load->view('app/payroll/compensation/pending_salary_information_approval',$this->data);
	}

	//update salary infos

	public function update_employee_salary($salary_id,$employee_id)
	{
		$this->data['salary_id'] = $salary_id;
		$this->data['employee_id'] = $employee_id;
		$employee_employment 				= $this->payroll_compensation_model->get_employee_employment($employee_id);
		$company_id 						= $employee_employment->company_id;
		$this->data['salary_id'] = $salary_id;
		$this->data['employee_id'] = $employee_id;	
		$this->data['company_id'] = $company_id;	

		$this->data['employee_salary'] 		= $this->payroll_compensation_model->get_employee_salary($employee_id,$company_id);
		$this->data['employee_employment'] 	= $this->payroll_compensation_model->get_employee_employment($employee_id);
		$this->data['employee_pagibig'] 	= $this->payroll_compensation_model->get_employee_pagibig($employee_id,$company_id);
		$this->data['employee_philhealth'] 	= $this->payroll_compensation_model->get_employee_philhealth($company_id);
		$this->data['employee_sss'] 	    = $this->payroll_compensation_model->get_employee_sss($company_id);
		$this->data['salaryRateList']		= $this->general_model->salaryRateList();
		$this->data['company_reason'] 		= $this->payroll_compensation_model->get_company_reason($company_id); 
		$this->load->view('app/payroll/compensation/salary_management/update_employee_salary',$this->data);
	}

	public function save_update_salary_information($salary_id,$company_id,$employee_id,$date,$salary_rate,$amount,$hours,$month,$years,$reason,$fixed,$withholding_tax,$pagibig,$sss,$philhealth)
	{
		$update = $this->payroll_compensation_model->save_update_salary_information($salary_id,$company_id,$employee_id,$date,$salary_rate,$amount,$hours,$month,$years,$reason,$fixed,$withholding_tax,$pagibig,$sss,$philhealth);

		$this->data['employee_salary'] 		= $this->payroll_compensation_model->get_employee_salary($employee_id,$company_id);
		$this->data['employee_employment'] 	= $this->payroll_compensation_model->get_employee_employment($employee_id);
		$this->data['employee_pagibig'] 	= $this->payroll_compensation_model->get_employee_pagibig($employee_id,$company_id);
		$this->data['employee_philhealth'] 	= $this->payroll_compensation_model->get_employee_philhealth($company_id);
		$this->data['employee_sss'] 	    = $this->payroll_compensation_model->get_employee_sss($company_id);
	
		$employee_salary 					= $this->payroll_compensation_model->get_employee_salary($employee_id,$company_id);
		if(count($employee_salary) > 0){
			$salary_id 							= $employee_salary->salary_id;
			$salary_rate 						= $employee_salary->salary_rate;
		
			if($salary_rate === '1'){

				$this->data['computation'] 	    = $this->payroll_compensation_model->get_computation_daily($salary_id);

			}
			else if($salary_rate === '2'){

				$this->data['computation'] 	    = $this->payroll_compensation_model->get_computation_monthly($salary_id);

			}
			else if($salary_rate === '3'){

				$this->data['computation'] 	    = $this->payroll_compensation_model->get_computation_daily($salary_id);

			}
			else if($salary_rate === '4'){

				$this->data['computation'] 	    = $this->payroll_compensation_model->get_computation_monthly($salary_id);

			}
		}
		

		$this->load->view('app/payroll/compensation/salary_management/employee_salary',$this->data);	
	}
	
	
}