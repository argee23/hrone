<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Employee extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/employee_model");
		$this->load->model("app/employee_201_profile_model");
		$this->load->model("general_model");
		//m11
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$this->load->library('form_validation');
		//m11
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){
		$this->data['message'] = $this->session->flashdata('message');	
		$this->load->view('app/employee/index_employees',$this->data);		
	}
	
	public function employee_list($val){

		$this->data['add_employee']=$this->session->userdata('add_employee');
		$this->data['deactivate_employee']=$this->session->userdata('deactivate_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$company_id=$val;
		$this->data['company'] = $company_id;
		$this->data['employee'] = $this->employee_model->get_employee($company_id);
		$this->data['message'] = $this->session->flashdata('message');		 
		$this->load->view('app/employee/employees',$this->data);	
	}
	
	public function search(){
		$this->data['employee'] = $this->employee_model->search_employee();
		$this->data['message'] = $this->session->flashdata('message');		 
		$this->load->view('app/employee/demography/search',$this->data);	
	}

	public function add_employee(){
		//M11:check license
		$license 				= $this->employee_model->get_employeee_license(1);
		$numLicense 			= $license[0]->myhris;
		$numisEmployee 			= $this->employee_model->get_employee_isEmployee(1);
		$allowedEmployee 		= $numLicense - $numisEmployee;
		//M11:end check of license

		if($numisEmployee < $numLicense){
			//Government fields
			$format;
			$index = 0;
			$government_fields 	= $this->employee_model->get_government_fields();
			foreach($government_fields as $government){
				$sample_format 		= $government->field_format;
				if(!empty($sample_format)){
						$format[$index] 	= $this->get_sample_format($sample_format);
				}
				else{
						$format[$index] 	= '^\d{}$';
				}
				$index++;
			}
			$data = array(
				$format[0] 	= $format[0],
				$format[1] 	= $format[1],
				$format[2] 	= $format[2],
				$format[3] 	= $format[3],
				$format[4] 	= $format[4]
			);
			//End of government fields

			// $this->session->set_userdata('page_name','add_employee');
			// $page_id 	  = $this->general_model->getPageID();
			// $userRole 	  = $this->general_model->getUserLoggedIn($this->session->userdata('username'));

			// if(General::has_rights_to_access($page_id->page_id,$userRole->user_role) == FALSE){
			
			// 	$value 	= "add employee";
			// 	General::logfile('Employee','TRY TO ACCESS',$value);	
			// 	redirect(base_url().'access_denied'); // app/employee

			// }
				// end of user restriction function
			//$this->data['']						= $format;
			$this->data['government_format'] 	= $data;
			$this->data['government_fields'] 	= $this->employee_model->get_government_fields();
			$this->data['message'] 				= $this->session->flashdata('message');		

			$this->data['pp_group']=$this->employee_model->getPayrollPeriodGroup();

			$this->load->view('app/employee/add_employee/add_employee',$this->data);	
		}
		else{
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  You're not allowed to add employee. Please check your employee license.</div>");
			redirect('app/employee');

		}	
	}

	public function validate_employee(){

		$value = $this->input->post('last_name').', '.$this->input->post('first_name').' '.$this->input->post('middle_name');

		if($this->employee_model->validate_employee()){
			$this->form_validation->set_message("validate_employee","Employee, <strong>".$value."</strong> already exist in your Employee Directory!");
			return false;
		}else{
			return true;
		}
	}

	public function save_employee(){

		$this->form_validation->set_rules("first_name","First Name","trim|required|callback_validate_employee");
		$this->form_validation->set_rules("middle_name","Middle Name","trim|callback_validate_employee");
		$this->form_validation->set_rules("last_name","Last Name","trim|required|callback_validate_employee");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");


		$employee_id 				= $this->input->post('employee_id');
		$isEmpIDExistDBActive 		= $this->employee_model->check_employeeID_existActive($employee_id);
		$isEmpIDExistDBInactive 	= $this->employee_model->check_employeeID_existInactive($employee_id);

		if($isEmpIDExistDBActive === true && $isEmpIDExistDBInactive === true){
			$picture = '';
			if(!empty($_FILES['file']['name'])){
					

		            $config['upload_path'] = './public/employee_files/profile_picture/';
		            $config['allowed_types'] = 'jpg|jpeg|png|gif';
				    $currentDateTime = date('Ymd_His');
				    $config['file_name'] = $employee_id.'_'.$currentDateTime;//$_FILES['file']['name'];
		            $fileName = $config['file_name'];//$_FILES['file']['name'];
		            
		            $this->load->library('upload',$config);
		            $this->upload->initialize($config);
		            
		            if($this->upload->do_upload('file')){
		                $uploadData = $this->upload->data();
		                $picture = $uploadData['file_name'];
		            }
		    }

			if($this->form_validation->run()){
				
				$this->employee_model->save_employee($picture);

				$default_password 	= $this->employee_model->get_default_password();
				$field_default		= $default_password[0]->field_name;
				$employee 			= $this->employee_model->get_active_employee($employee_id);
				$set_default 		= $employee[0]->$field_default;
				$this->employee_model->set_default_password($set_default, $employee_id);

				
				//M11: Add for for user define fields
				$value 			= $this->input->post('employee_id');
				$company 		= $this->input->post('company');
				
				$countColumn 	= $this->employee_model->get_column_number($company);//loop to add

				$udfLabel 		= $this->employee_model->user_define_fields_company($company);//-----

				$countEmp 		= $this->employee_model->get_latest_insert_emp();//last emp
		    	$Lastempid 		= $countEmp[0]->id;

				$data = array(
			  		'employee_info_id' 	=> $Lastempid,
					'employee_id'		=>	$value,
					'company_id'		=> $company	
				);
				$this->employee_model->insert_udf($data);

		    	$checkUDF = $this->employee_model->check_company_exist($company);//check if exist
		    	if($checkUDF === true){
		    		$num = 0;
				    for($num=0;$num<$countColumn;$num++){
				    $dataFinal 	= $udfLabel[$num]->udf_label;
				    $labeltemp 	= str_replace(' ', '_', $dataFinal);
				    $label 		= $labeltemp.'_'.$company;	
				         
			         	$data = array(
			         		
			 		 		$label => $this->input->post($labeltemp)        	
						);
					  	$update = $this->employee_model->update_data($data);
				    }
				}
			    //M11:end of Add user define fields

				//Payroll_pagibig_table
				$pagibig_setting 	= $this->employee_model->get_pagibig_employee_setting($company);
				$checkpagibig 		= false;
				$current_year 		= date('Y', strtotime(date("Y-m-d")));
				foreach($pagibig_setting as $pagibig){
					$data_pagibig = array(
						'employee_id'		=> $value,
						'company_id'		=> $company,
						'amount'			=> $pagibig->amount,
						'cut_off_id'		=> $pagibig->cut_off_id,
						'pagibig_type_id'	=> $pagibig->pagibig_type_id,
						'year'				=> $current_year
					);
					$this->employee_model->insert_pagibig_employee_setting($data_pagibig);
					$checkpagibig = true;
				}
				if($checkpagibig === false){
					$data_pagibig = array(
						'employee_id'		=> $value,
						'company_id'		=> $company,
						'year'				=> $current_year
					);
					$this->employee_model->insert_pagibig_employee_setting($data_pagibig);
				}
			    //End of Payroll_pagibig_table 


				//start payroll period group
				$payroll_group=$this->input->post('payroll_group');
				$NewEmpGroup = array(
					'payroll_period_group_id'	=>	$payroll_group,
					'employee_id'				=>	$value,
					'InActive'					=>	'0',
					'date_enrolled'				=> date('Y-m-d H:i:s')
					);
				
				$this->employee_model->newEmployeePayrollGroup($NewEmpGroup);
				//end payroll period group


				$withBlock = $this->input->post('withblockemployee');
				$value2 = $this->input->post('last_name').', '.$this->input->post('first_name').' '.$this->input->post('middle_name');
				$insert_logtrail = $this->employee_model->insert_logtrail('ADD',$value."/".$value2,$company,$value,$withBlock,date('Y-m-d H:i:s'));
				
	

		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','add : '.$value.'','INSERT',$value2);

				
				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee, <strong>".$value2."</strong>, is Successfully Added!</div>");
				redirect(base_url().'app/employee/index',$this->data);
			}else{
				$this->index();
			}

		}
		else{
			$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee id already exist in the database</div>");
				// redirect
				redirect(base_url().'app/employee/index',$this->data);
		}
	}

	public function get_company(){
		$location_id = $this->uri->segment("4");

		$this->data['get_company'] = $this->employee_model->get_company($location_id);
		$this->load->view('app/employee/add_employee/company_list',$this->data);
	}
	public function get_company_locations(){
		$company_id = $this->uri->segment("4");
		$this->data['company_locations'] = $this->general_model->get_company_locations($company_id);
		$this->load->view('app/employee/add_employee/company_locations_list',$this->data);
	}

	public function get_cities(){
		$province_id = $this->uri->segment("4");
    	$this->data['province_cities'] = $this->employee_model->get_province_cities($province_id);
		$this->load->view('app/employee/add_employee/cities_list',$this->data);
	}
	public function get_cities2(){
		$province_id = $this->uri->segment("4");
		$this->data['province_cities'] = $this->employee_model->get_province_cities($province_id);
		$this->load->view('app/employee/add_employee/cities_list2',$this->data);
	}

	public function get_section2(){
		$dept_id = $this->uri->segment("4");

		$this->data['get_section'] = $this->employee_model->get_section($dept_id);
		$this->load->view('app/employee/add_employee/section_list2',$this->data);
	}

	public function employee_profile(){

		$employee_id 						= $this->uri->segment("4");	
		$this->data['message'] 				= $this->session->flashdata('message');	
		$checker_inactive = $this->employee_model->checking_for_inactive($employee_id);
		if($checker_inactive==0)
		{
			$this->data['employee_profile'] 	= $this->employee_model->get_active_profile($employee_id);
		}
		else
		{
			$this->data['employee_profile'] 	= $this->employee_201_profile_model->get_active_employeeinactive($employee_id);	
		}


		
		$this->session->set_userdata('employee_id_201', $this->uri->segment("4"));
		$this->load->view('app/employee/employee_201_profile/employee_201_profile',$this->data);
	}
	public function employee_profile_inactive(){

		$employee_id 								= $this->uri->segment("4");
		$employee 									= $this->employee_201_profile_model->get_active_employee_inactive($employee_id);
		$company_id 								= $employee->company_id;

		$this->data['personal_info_view'] 			= $this->employee_201_profile_model->get_personal_info_view_inactive($employee_id);
		$this->data['employment_info_view'] 		= $this->employee_201_profile_model->get_employment_info_view_inactive($employee_id);
		$this->data['account_info_view'] 			= $this->employee_201_profile_model->get_account_info_view_inactive($employee_id);
		$this->data['address_info_view'] 			= $this->employee_201_profile_model->get_address_info_view_inactive($employee_id);
		$this->data['contact_info_view'] 			= $this->employee_201_profile_model->get_contact_info_view_inactive($employee_id);
		$this->data['employee_udf'] 				= $this->employee_201_profile_model->get_udf_employee($company_id);
		$this->data['employee_udf_store'] 			= $this->employee_201_profile_model->get_udf_store_employee($employee_id,$company_id);
		$this->data['employee_udf_option'] 			= $this->employee_201_profile_model->get_udf_option();
		$this->data['family_info_view'] 			= $this->employee_201_profile_model->get_family_info_view($employee_id);
		$this->data['dependent_info_view'] 			= $this->employee_201_profile_model->get_dependent_info_view($employee_id);
		$this->data['education_attain_view'] 		= $this->employee_201_profile_model->get_education_attain_view($employee_id);
		$this->data['employee_training_seminar'] 	= $this->employee_201_profile_model->get_training_seminars_employee($employee_id);
		$this->data['employee_employment_exp'] 		= $this->employee_201_profile_model->get_employment_exp_employee($employee_id);
		$this->data['employee_character_ref'] 		= $this->employee_201_profile_model->get_character_ref_employee($employee_id);
		$this->data['employee_skill'] 				= $this->employee_201_profile_model->get_skill_employee($employee_id);
		$this->data['contract_view'] 				= $this->employee_201_profile_model->get_contract_view($employee_id);
		$this->data['employee_inventory'] 			= $this->employee_201_profile_model->get_inventory_employee($employee_id);
		$this->data['employee_active'] 				= $this->employee_201_profile_model->get_active_employee_inactive($employee_id); 
		$this->data['movement_history_view'] 		= $this->employee_201_profile_model->get_movement_history_view($employee_id);
		$this->data['employee_log_history'] 		= $this->employee_201_profile_model->get_log_history_employee($employee_id);
		$this->data['employee_status_history'] 		= $this->employee_201_profile_model->get_status_history_employee($employee_id);
		$this->load->view('app/employee/employee_201_profile/all_profile_view_inactive',$this->data);
	}
	//==========================================Mass upload==========================================//	
	//M11: Download template
	public function download_employee_info_template () {
		
        $this->load->helper('download');            
		$path    =   file_get_contents(base_url()."public/downloadable_templates/employee_info.xls");
		$name    =   "employee_info.xls";
		force_download($name, $path); 

		$value = $name;

		General::logfile('Employee Personal Info Template','DOWNLOAD',$value);
                             
    }
    // M11: end download template
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

    //M11: Import Controller import_employee_info_template
    public function import_employee_info_template()
    {
    	$numOfEmp 		= 0;
    	$foundError 	= False;
    	$excelEmpID 	= array();
    	$excelEmpName 	= array();
    	$result 		= 0;

	    if(isset($_POST["import"]))
	    {
			$fileName = $_FILES['file']['name'];

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

	        	try {

	                $inputFileType 	= IOFactory::identify($inputFileName);
	                $objReader 		= IOFactory::createReader($inputFileType);
	                $objPHPExcel 	= $objReader->load($inputFileName);
	           
	            } catch(Exception $e) {
	            	unlink($inputFileName);
	                $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Error file type/file name. Allowed file type: .xlsx/.xls </div>");
					redirect('app/employee');
	            }

				$objPHPExcel->setActiveSheetIndex(0);
				$sheet 			= $objPHPExcel->getSheet(0);
	            $highestRow 	= $sheet->getHighestRow();
	            $highestColumn 	= $sheet->getHighestColumn();
	            $colNumber 		= PHPExcel_Cell::columnIndexFromString($highestColumn);

	            //get the number of license
	            	$data 		= $this->employee_model->get_employeee_license(1);
	            	$numLicense = $data[0]->myhris;
	            //end of get the number of license

	            //count the number of isEmployee
	            	$numisEmployee = $this->employee_model->get_employee_isEmployee(1);
	            
	            //number of import data
	            	$numImportexcel		= $highestRow - 1;
	            //$numisEmployee + $numImportexcel
	            	$totalEmployee		= $numImportexcel + $numisEmployee;
	            //Allowed
	            	$allowedEmployee 	= $numLicense - $numisEmployee;

            //For license purpose
	        if($totalEmployee  <= 	$numLicense){
	        	$forNull 		= 'Value cannot be Null';
	            $forInt 		= 'Must be Number. ID number is required';
	            $existDB 		= '*Please check the Employee_id. Employee ID Already exist in the Database*';
	            $existExcel	 	= 'Duplicate employeeID';
	            $existNameDB 	= '*Please check the Employee name. Employee name Already exist in the Database*';
	            $existNameExcel	= 'Duplicate employee name';
	            $forDate 		= 'Format:yyyy-mm-dd';
	            $forZero 		= 'Emp ID Must not start with zero';
	            $forRef 		= 'ID does not exist please check the reference';


		            $styleArray = array(
				    'font'  => array(
				        'bold'  => true,
				        'color' => array('rgb' => 'FF0000')
				    ));

		         $nameIndex		= 0;
				 

				 //check and rewrite the error of imported excel
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
					    		if($col == 0 || $col == 1 || $col == 3 || $col == 4 || $col == 5 || $col == 6 || $col == 7 || $col == 8 || $col == 10 || $col == 11 || $col == 13 || $col == 14 || $col == 15 || $col == 16 || $col == 17 || $col == 18   ){ // for null
								$objPHPExcel->getActiveSheet()->
								setCellValueByColumnAndRow($col, $row,  $forNull);
								$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
									$foundError = True;
								}
			            	}
			            	else{//If not null
			            		if($col==0){
			            			$excelEmpID[] = $getCellvalue; // pass the value to array $excelEmpID[]
			            			if ($getCellvalue{0}=="0") { // empID that start with zero
										$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '. $forZero);//start zero
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignmdent()->setWrapText(true);
										$foundError = True;
									}
			            		}
			            		if($col == 4 || $col == 18){
									$date =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
									$check = $this->validateDate($date);
									
									//echo '<br>'.$new_date;
									//echo '<br>'.date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($new_date));
									if($check === false){
										$objPHPExcel->getActiveSheet()->
											setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$forDate);//doesn't exist
											$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
									}
								}
			            		if($col == 5 || $col == 6 || $col == 7 || $col == 8 || $col == 9 || $col == 10 || $col == 11 || $col == 12 || $col == 13 || $col == 14 || $col == 15 ||  $col == 16 || $col == 17 ){
									if(!is_numeric($getCellvalue)){
												$objPHPExcel->getActiveSheet()->
											setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forInt);//Number
											$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
											$foundError = True;
									}
									if($col == 5){
										$gender =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
				            			$isGenderExist = $this->employee_model->check_isGenderExist($gender);
				            			if($isGenderExist === false){
				            				$objPHPExcel->getActiveSheet()->
											setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$forRef);//doesn't exist
											$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
				            			}
									}
									else if($col == 6){
										$civil_status =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
				            			$isCivilStatusExist = $this->employee_model->check_isCivilStatusExist($civil_status);
				            			if($isCivilStatusExist  === false){
				            				$objPHPExcel->getActiveSheet()->
											setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
											$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
				            			}
									}
									
									else if($col == 7){
										$company =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
										$isDivision = $this->employee_model->check_isDivision($company);
				            			$isCompanyExist = $this->employee_model->check_isCompanyExist($company);
				            			if($isCompanyExist  === false){
				            				$objPHPExcel->getActiveSheet()->
											setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
											$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
				            			}
				            			else{
				            				$companyTemp = $company;
				            			}
									}
									
									else if($col == 8){
										$location =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
				            			$isLocationExist = $this->employee_model->check_isLocationExist($companyTemp,$location);
				            			if($isLocationExist  === false){
				            				$objPHPExcel->getActiveSheet()->
											setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
											$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
				            			}
									}

									else if($col == 9){
										if ($isDivision === true){
											$division =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
					            			$isDivisionExist = $this->employee_model->check_isDivisionExist($companyTemp,$division);
					            			if($isDivisionExist  === false){
					            				$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
					            			}
					            			else{
					            				$divisionTemp = $division;
					            			}
				            			}
									}
									
									else if($col == 10){
										$department =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
										if ($isDivision === true){
				            				$isDepartmentExist = $this->employee_model->check_isDepartmentDivisionExist($divisionTemp, $department);
				            			}
				            			else{
				            				$isDepartmentExist = $this->employee_model->check_isDepartmentCompanyExist($companyTemp, $department);
				            			}

				            			if($isDepartmentExist  === false){
				            				$objPHPExcel->getActiveSheet()->
											setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
											$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
				            			}
				            			else{
				            				$departmentTemp = $department;
				            			}
									}
									
									else if($col == 11){
										$section =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
										$isSubsection = $this->employee_model->check_isSubsection($section);
				            			$isSectionExist = $this->employee_model->check_isSectionExist($departmentTemp,$section);
				            			if($isSectionExist  === false){
				            				$objPHPExcel->getActiveSheet()->
											setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
											$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
				            			}
				            			else{
				            				$sectionTemp = $section;
				            			}
									}
									
									else if($col == 12){
										if ($isSubsection === true ){
											$subsection =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
					            			$isSubsectionExist = $this->employee_model->check_isSubsectionExist($sectionTemp,$subsection);
					            			if($isSubsectionExist  === false){
					            				$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
					            			}
				            			}
									}
									
									else if($col == 13){
										$employment =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
				            			$isEmploymentExist = $this->employee_model->check_isEmploymentExist($employment);
				            			if($isEmploymentExist  === false){
				            				$objPHPExcel->getActiveSheet()->
											setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
											$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
				            			}
									}
									
									
									else if($col == 14){ // classification
										$classification =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
				            			$isClassificationExist = $this->employee_model->check_isClassificationExist($companyTemp, $classification);
				            			if($isClassificationExist  === false){
				            				$objPHPExcel->getActiveSheet()->
											setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
											$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
				            			}
									}
									
									else if($col == 15){
										$position =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
				            			$isPositionExist = $this->employee_model->check_isPositionExist($position);
				            			if($isPositionExist  === false){
				            				$objPHPExcel->getActiveSheet()->
											setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
											$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
				            			}
									}
									else if($col == 16){
										$taxcode =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
				            			$isTaxcodeExist = $this->employee_model->check_isTaxcodeExist($taxcode);
				            			if($isTaxcodeExist  === false){
				            				$objPHPExcel->getActiveSheet()->
											setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
											$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
				            			}
									}
									else if($col == 17){
										$paytype =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
				            			$isPaytypeExist = $this->employee_model->check_isPaytypeExist($paytype);
				            			if($isPaytypeExist  === false){
				            				$objPHPExcel->getActiveSheet()->
											setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forRef);//doesn't exist
											$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
				            			}
									}
								}
								if($col==1 || $col==2 || $col==3 ){
			            			if($col == 1){
			            				$excelEmpName[$nameIndex] = $getCellvalue;
			            			}
			            			else{
			            				$excelEmpName[$nameIndex] = $excelEmpName[$nameIndex].'-'.$getCellvalue;
			            				if($col==3){
			            					$nameIndex++;
			            				}
			            			}
			            		}
			            		
			            	}

			            	 // For Division and subsection
				            if($col == 9){
				            	if($isDivision === true){
					            	if(empty($getCellvalue)){
										$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row,  $forNull);//null
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
					            	}
				            	}
				            }
				            if($col == 12){
				            	if($isSubsection===true){
				            		if(empty($getCellvalue)){
										$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row,  $forNull);//null
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
					            	}
				            	}
				            }
				        	//End of for Division and subsection

		         	$colLetter++;// increment A
					}//end of col for loop
		         }//end of row for loop


		        //check employee_id
				//for compare excel employee_id
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
						setCellValueByColumnAndRow(0, $exRow,$getCellvalue.' -> '.$existExcel);//Exist in database
						$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
						$foundError 	= True;
					}
				}//compare excel employee_id
				//DB
				$colLetter2 	= 'Q';
				$getDBEmpID 	= $this->employee_model->get_all_employeeID_DB();
				$resultdb 		= $result+2;
				$colrowdb 		= $colLetter.(string)$resultdb;
				$colrowdb2 		= $colLetter2.(string)$resultdb;
				for($value = 0; $value < $numisEmployee; $value++){//for compare db employee_id
					$tempvalue 	=$getDBEmpID[$value]->employee_id; // this is the cause
					$compExcelDBEmpID 	= $this->compare_empID_excel_DB($excelEmpID,$tempvalue);
					if($compExcelDBEmpID){
						$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow(0, $resultdb,$existDB);//Exist in database
						$objPHPExcel->getActiveSheet()->getStyle($colrowdb)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->mergeCells($colrowdb.':'.$colrowdb2);
						$foundError 	= True;
					}
				}	
				//END OF DB
				//Check employee name
				//Excel
				$colLetter 	= 'B';
				$resultName 	= count($excelEmpName);
				for($value = 0 ;$value < $resultName; $value++){
					$exRow 				= $value + 2;
					$tempvalue 			= $excelEmpName[$value]; 
					$compVal 			= $value + 1;
					$colrow 			= $colLetter.(string)$exRow;
					$compExcelEmpName 	= $this->compare_empName_excel($compVal,$excelEmpName,$tempvalue);
					if($compExcelEmpName){
						$getCellvalue 	= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $exRow)->getValue();
						$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow(1, $exRow,$getCellvalue.' -> '.$existNameExcel);//Exist in database
						$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
						$foundError 	= True;
					}
				}//compare excel employee_id
				//DB
				$colLetter2 	= 'Q';
				$colLetterName	= 'A';
				$getDBEmpID 	= $this->employee_model->get_all_employeeName_DB();
				$resultdb 		= $result+3;
				$colrowdb 		= $colLetterName.(string)$resultdb;
				$colrowdb2 		= $colLetter2.(string)$resultdb;
				for($value = 0; $value < $numisEmployee; $value++){//for compare db employee_id
					$tempvalue 	= $getDBEmpID[$value]->first_name.'-'.$getDBEmpID[$value]->middle_name.'-'.$getDBEmpID[$value]->last_name.'-'.$getDBEmpID[$value]->birthday;
					$compExcelDBEmpName 	= $this->compare_empName_excel_DB($excelEmpName,$tempvalue);
					if($compExcelDBEmpName){
						$objPHPExcel->getActiveSheet()->
						setCellValueByColumnAndRow(0, $resultdb,$existNameDB);//Exist in database
						$objPHPExcel->getActiveSheet()->getStyle($colrowdb)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->mergeCells($colrowdb.':'.$colrowdb2);
						$foundError 	= True;
					}
				}	

				//END OF DB



		         //End of check and rewrite the error of imported excel
		         if($foundError==False){ // insert to employee_info table
		        	for ($row = 2; $row <= $highestRow; $row++){
	            	$numOfEmp++;                                  
	                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
	                                                NULL,
	                                                TRUE,
	                                                FALSE);
	                                                                             
	                 $fullname = ucfirst($rowData[0][1])." ".ucfirst($rowData[0][2])." ".ucfirst($rowData[0][3]);

					 $dob = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($rowData[0][4]));
					 $age = floor((time() - strtotime($dob))/31556926);
					 $employee_id 	  =	$rowData[0][0];
					 $company_id  	  =	$rowData[0][7];
					 $birth_date 	  = date('Y-m-d', strtotime($rowData[0][4]));
					 $employed_date   = date('Y-m-d', strtotime($rowData[0][18]));
	                 $data = array(
							'employee_id'  		=> $rowData[0][0],
							
							'first_name'  		=> ucfirst($rowData[0][1]),
							'middle_name' 		=> ucfirst($rowData[0][2]),
							'last_name'  		=> ucfirst($rowData[0][3]),
							'fullname'  		=> $fullname,

							'birthday'  		=> $birth_date,
							'age'  				=> $age,

							'gender'  			=> $rowData[0][5],
							'civil_status'  	=> $rowData[0][6],

							'company_id'  		=> $rowData[0][7],
							'location'  		=> $rowData[0][8],
							'division_id'	  	=> $rowData[0][9],
							'department'  		=> $rowData[0][10],
							'section'  			=> $rowData[0][11],
							'subsection'	  	=> $rowData[0][12],
							'employment'  		=> $rowData[0][13],
							'classification'  	=> $rowData[0][14],
							'position'  		=> $rowData[0][15],
							'taxcode'  			=> $rowData[0][16],
							'pay_type'	  		=> $rowData[0][17],
							'date_employed'  	=> $employed_date,
							'picture'  			=>  $imagepath,	

							'password'			=>	$rowData[0][0],
							'username'			=>	$rowData[0][0],
							'isApproverChoice'  => 0,	
							'isUser'  			=> 0,
							'isApplicant'  		=> 0,
							'InActive'			=> 0,
							'isEnable'			=> 1,
							'isEmployee'  		=> 1

	                        );

	         //        $data_2  = array(	'employee_id'  		=> 	$rowData[0][0],
	         //         					'company_id'  		=> 	$rowData[0][7],
										// 'location'  		=> 	$rowData[0][8],
										// 'division_id'	  	=> 	$rowData[0][9],
										// 'department'  		=> 	$rowData[0][10],
										// 'section'  			=> 	$rowData[0][11],
										// 'subsection'	  	=> 	$rowData[0][12],
										// 'employment'  		=> 	$rowData[0][13],
										// 'classification'  	=> 	$rowData[0][14],
										// 'position'  		=> 	$rowData[0][15],
										// 'date_employed'  	=> 	$employed_date,
										// 'details'			=>	'New added employee',
										// 'added_by'			=>	$this->session->userdata('employee_id'),
										// 'date_added'        =>	date('Y-m-d H:i:s'));


		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','mass upload : '.$employee_id.'','INSERT',$employee_id);

				


	                $insert 			= $this->employee_model->insertImport($data);
	                $default_password 	= $this->employee_model->get_default_password();
					$field_default		= $default_password[0]->field_name;
					$employee 			= $this->employee_model->get_active_employee($employee_id);
					$set_default 		= $employee[0]->$field_default;
					$this->employee_model->set_default_password($set_default, $employee_id);

	                $data = array(
						'employee_id'		=>	$rowData[0][0],
						'company_id'		=>  $rowData[0][12]
					);
					$this->employee_model->insert_udf($data);

					//Payroll_pagibig_table
					$pagibig_setting 	= $this->employee_model->get_pagibig_employee_setting($company_id);
					$checkpagibig 		= false;
					$current_year 		= date('Y', strtotime(date("Y-m-d")));
					foreach($pagibig_setting as $pagibig){
						$data_pagibig = array(
							'employee_id'		=> $employee_id,
							'company_id'		=> $company_id,
							'amount'			=> $pagibig->amount,
							'cut_off_id'		=> $pagibig->cut_off_id,
							'pagibig_type_id'	=> $pagibig->pagibig_type_id,
							'year'				=> $current_year
						);
						$this->employee_model->insert_pagibig_employee_setting($data_pagibig);
						$checkpagibig = true;
					}
					if($checkpagibig === false){
						$data_pagibig = array(
							'employee_id'		=> $employee_id,
							'company_id'		=> $company_id,
							'year'				=> $current_year
						);
						$this->employee_model->insert_pagibig_employee_setting($data_pagibig);
					}
				    //End of Payroll_pagibig_table

	            	}//end of insert
		            if($insert){ //file name for successfully imported
					    $dt = $date_array = getdate();
					       $formated_date  = "employee_info_";
					       $formated_date .= $date_array['mon'];
					       $formated_date .= $date_array['mday'];
						   $formated_date .= $date_array['year'] . "_";
						   $formated_date .= $date_array['hours'];
					       $formated_date .= $date_array['minutes'];
						   $formated_date .= $date_array['seconds'];
					    rename( $inputFileName, './public/import_template/'.$formated_date.'.xls' );
						$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> " .$numOfEmp." Employee(s) Successfully Added!</div>");
						redirect('app/employee');
					} //end of file name for successfully imported

				}//end of else find error
				else{//download if found an error
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
					header('Content-Disposition: attachment;filename="' . $fileName. '"');
					header('Cache-Control: max-age=0');
					unlink($inputFileName);
					$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$objWriter->save('php://output');
					exit; 
				}//end of download if found an error


			}//end of For license purpose
			
			else{//else of license purchase
				unlink($inputFileName);
				$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> " .$allowedEmployee." Employee(s) only allowed to import. Please check the license you have purchased.</div>");
				redirect('app/employee');
			}// end of else license purchase
			
		}//end of upload has imported a file
		else{
			unlink($inputFileName);
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Something is wrong with your data!</div>");
				redirect('app/employee');
		}
				
	}
	
	//M11: End of Import Controller import_employee_info_template
		public function compare_empName_excel($compVal,$excelEmpName,$tempvalue){
		$result = count($excelEmpName);
		for($value = $compVal; $value < $result; $value++){
			if($excelEmpName[$value]==$tempvalue){
				return true;
			}
		}
	}

	public function compare_empName_excel_DB($excelEmpName,$tempvalue){

		$result = count($excelEmpName);
		for($value = 0; $value < $result; $value++){
			if($excelEmpName[$value]==$tempvalue){
				return true;
			}
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

	public function compare_empID_excel_DB($excelEmpID,$tempvalue){//M11: compare excel to DB

		$result = count($excelEmpID);
		for($value = 0; $value < $result; $value++){
			if($excelEmpID[$value]==$tempvalue){
				return true;
			}
		}

	}//M11: end of compare excel to DB

	//==========================================End Mass upload==========================================//	

	//M11:====================UDF============================
	public function get_option(){//get the list of option
		$id = $this->uri->segment("4");
		$this->data['get_option'] = $this->employee_model->get_option($id);
	}

	public function get_company_udf(){//Get list of UDF
		$company_id = $this->uri->segment("4");
		$this->data['company_udf'] = $this->employee_model->display_udf_company($company_id);
		$this->load->view('app/employee/add_employee/udf_company',$this->data);
	}
	
	//M1====================End of UDF========================

	//M11:====================Company============================
	public function get_company_division(){//Get list of UDF
		$company_id = $this->uri->segment("4");
		$this->data['company_isDiv'] = $this->employee_model->get_company_isDivision($company_id);
		$this->data['company_division'] = $this->employee_model->get_company_division($company_id);
		$this->data['company_department'] = $this->employee_model->get_company_department($company_id);
		$this->load->view('app/employee/add_employee/company_division',$this->data);
	}

	public function get_company_reportTo(){//Get list of UDF
		$company_id = $this->uri->segment("4");
		$this->data['company_reportTo'] = $this->employee_model->get_company_reportTo($company_id);
		$this->load->view('app/employee/add_employee/company_reportTo',$this->data);
	}
	public function get_division_department(){
		$division_id = $this->uri->segment("4");
		$this->data['company_division'] = $this->employee_model->get_division_department($division_id);
		$this->load->view('app/employee/add_employee/division_department',$this->data);
	}
	public function get_department_section(){
		$department_id = $this->uri->segment("4");
		$this->data['department_sections'] = $this->employee_model->get_department_section($department_id);
		$this->load->view('app/employee/add_employee/department_section',$this->data);
	}
	public function get_section_subsection(){
		$section_id = $this->uri->segment("4");
		$this->data['section_isSub'] = $this->employee_model->get_section_isSubsection($section_id);
		$this->data['section_subsection'] = $this->employee_model->get_section_subsection($section_id);
		$this->load->view('app/employee/add_employee/section_subsection',$this->data);
	}

	function get_company_classification(){
		$company_id = $this->uri->segment("4");
		$this->data['company_classifications'] = $this->employee_model->get_company_classification($company_id);
		$this->load->view('app/employee/add_employee/company_classification',$this->data);
	}


	
	//M1====================End of Company========================

	//M11:==================Demography========================

	public function get_company_locations_demography(){
		$company_id = $this->uri->segment("4");
		$this->data['company_locations'] = $this->employee_model->get_company_location($company_id);
		$this->load->view('app/employee/demography/company_location_list',$this->data);
	}

	public function get_company_divisions_demography(){
		$company_id = $this->uri->segment("4");
		$this->data['company_isDiv'] = $this->employee_model->get_company_isDivision($company_id);
		$this->data['company_division'] = $this->employee_model->get_company_division($company_id);
		$this->data['company_department'] = $this->employee_model->get_company_department($company_id);
		$this->load->view('app/employee/demography/company_division_list',$this->data);
	}

	public function get_company_classifications_demography(){
		$company_id = $this->uri->segment("4");
		$this->data['company_classifications'] = $this->employee_model->get_company_classification($company_id);
		$this->load->view('app/employee/demography/company_classification_list',$this->data);
	}

	public function get_department_sections_demography(){
		$department_id = $this->uri->segment("4");
		$this->data['department_sections'] = $this->employee_model->get_department_section($department_id);
		$this->load->view('app/employee/demography/department_section_list',$this->data);
	}
	public function get_division_department_demography(){
		$division_id = $this->uri->segment("4");
		$this->data['company_division'] = $this->employee_model->get_division_department($division_id);
		$this->load->view('app/employee/demography/division_department_list',$this->data);
	}

	public function get_section_subsection_demography(){
		$section_id = $this->uri->segment("4");
		$this->data['section_isSub'] = $this->employee_model->get_section_isSubsection($section_id);
		$this->data['section_subsection'] = $this->employee_model->get_section_subsection($section_id);
		$this->load->view('app/employee/demography/section_subsection_list',$this->data);
	}

	//M11===================End of Demography=================

	//M11:==================Inactive Employee=================
	public function view_inactive_employee(){

		$this->data['deactivate_employee']=$this->session->userdata('deactivate_employee');
		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

		$this->data['employee'] 	= $this->employee_model->get_employee_inactive();
		$this->data['message'] 		= $this->session->flashdata('message');		 
		$this->load->view('app/employee/inactive_employees',$this->data);	
	}
	
	public function activate_employee(){
		$employee_id 		= $this->input->post('employeeID');
		$date_event 		= $this->input->post('date_event');
		$reason 			= $this->input->post('reason');
		$inactive_employee 	= $this->employee_model->get_inactive_employee($employee_id);
			$this->data = array(

			'employee_id'						=>		$inactive_employee[0]->employee_id,
			'title'								=>		$inactive_employee[0]->title,
			'last_name'							=>		$inactive_employee[0]->last_name,
			'first_name'						=>		$inactive_employee[0]->first_name,
			'middle_name'						=>		$inactive_employee[0]->middle_name,
			'name_extension'					=>		$inactive_employee[0]->name_extension,
			'fullname'							=>		$inactive_employee[0]->fullname,
			'birthday'							=>		$inactive_employee[0]->birthday,
			'age'								=>		$inactive_employee[0]->age,
			'gender'							=>		$inactive_employee[0]->gender,
			'civil_status'						=>		$inactive_employee[0]->civil_status,
			'birth_place'						=>		$inactive_employee[0]->birth_place,
			'blood_type'						=>		$inactive_employee[0]->blood_type,
			'citizenship'						=>		$inactive_employee[0]->citizenship,
			'religion'							=>		$inactive_employee[0]->religion,

			'company_id'						=>		$inactive_employee[0]->company_id,
			'location'							=>		$inactive_employee[0]->location,
			'employment'						=>		$inactive_employee[0]->employment,
			'classification'					=>		$inactive_employee[0]->classification,
			'department'						=>		$inactive_employee[0]->department,
			'section'							=>		$inactive_employee[0]->section,
			'position'							=>		$inactive_employee[0]->position,

			'division_id'						=>		$inactive_employee[0]->division_id,
			'subsection'						=>		$inactive_employee[0]->subsection,
			
			'bank'								=>		$inactive_employee[0]->bank,	
			'account_no'						=>		$inactive_employee[0]->account_no,	
			'tin'								=>		$inactive_employee[0]->tin,	
			'pagibig'							=>		$inactive_employee[0]->pagibig,	
			'philhealth'						=>		$inactive_employee[0]->philhealth,	

			'date_employed'						=>		$inactive_employee[0]->date_employed,
			'taxcode'							=>		$inactive_employee[0]->taxcode,
			'pay_type'							=>		$inactive_employee[0]->pay_type,
			'report_to'							=>		$inactive_employee[0]->report_to,		
			
			'picture'							=> 		$inactive_employee[0]->picture,
			'email'								=>		$inactive_employee[0]->email,
			'InActive'							=>		0,
			'isUser'							=>		0,
			'isEnable'							=>		1,

			'nickname'							=> 		$inactive_employee[0]->nickname,				
			'sss'								=> 		$inactive_employee[0]->sss,
			'bank'								=> 		$inactive_employee[0]->bank,
			'permanent_address'					=> 		$inactive_employee[0]->permanent_address,
			'permanent_province'				=> 		$inactive_employee[0]->permanent_province,	
			'permanent_city'					=> 		$inactive_employee[0]->permanent_city,
			'permanent_address_years_of_stay'	=> 		$inactive_employee[0]->permanent_address_years_of_stay,
			'present_address'					=> 		$inactive_employee[0]->present_address,
			'present_province'					=> 		$inactive_employee[0]->present_province,
			'present_city'						=> 		$inactive_employee[0]->present_city,
			'present_address_years_of_stay'		=> 		$inactive_employee[0]->present_address_years_of_stay,
			'mobile_1'							=> 		$inactive_employee[0]->mobile_1,
			'mobile_2'							=> 		$inactive_employee[0]->mobile_2,
			'tel_1'								=> 		$inactive_employee[0]->tel_1,
			'tel_2'								=> 		$inactive_employee[0]->tel_2,
			'facebook'							=> 		$inactive_employee[0]->facebook,
			'twitter'							=> 		$inactive_employee[0]->twitter,
			'instagram'							=> 		$inactive_employee[0]->instagram,
			'username'							=> 		$inactive_employee[0]->username,
			'password'							=> 		$inactive_employee[0]->password,
			'isApplicant'						=> 		$inactive_employee[0]->isApplicant,
			'isEmployee'						=> 		$inactive_employee[0]->isEmployee,
			'isApproverChoice'					=> 		$inactive_employee[0]->isApproverChoice,
			'resume_file'						=> 		$inactive_employee[0]->resume_file,
			'residence_map'						=> 		$inactive_employee[0]->residence_map


		);	
		$reason = $this->input->post('reason');
		$insert = $this->employee_model->insertToactiveEmployee($this->data,$inactive_employee[0]->employee_id,$inactive_employee[0]->company_id,$date_event,$reason);
		if($insert){

			General::logfile('Employee','Activate employee','Employee_id:' .$inactive_employee[0]->employee_id);
		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Set to Active : '.$inactive_employee[0]->employee_id.'','ACTIVE',$inactive_employee[0]->employee_id);


			$this->employee_model->employee_logfile($inactive_employee[0]->employee_id,'Activate employee',$date_event, $reason);
			$this->employee_model->deleteInactiveEmployee($employee_id);
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> " .$inactive_employee[0]->fullname." Successfully Activated!</div>");
			redirect('app/employee/view_inactive_employee');
		}
		else{

			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee cannot be Activated!</div>");
			redirect('app/employee/view_inactive_employee');
		}
	}

	public function inactive_employee(){
		$employee_id 		= $this->input->post('employeeID');
		$date_event 		= $this->input->post('date_event');
		$reason 			= $this->input->post('reason');
		$inactive_type		= $this->input->post('inactive_type');
		if($inactive_type=='resigned'){ $o = 'reason'; } else{ $o='details'; }
		$others = $this->input->post($o);
		$active_employee 	= $this->employee_model->get_active_employee($employee_id);

		if($inactive_type=='resigned')
		{
			$log_ins = 'InActive Employee (resigned)';
			$date_resigned = $this->input->post('date_event');
			$this->data = array(

				'employee_id'						=>		$active_employee[0]->employee_id,
				'title'								=>		$active_employee[0]->title,
				'last_name'							=>		$active_employee[0]->last_name,
				'first_name'						=>		$active_employee[0]->first_name,
				'middle_name'						=>		$active_employee[0]->middle_name,
				'name_extension'					=>		$active_employee[0]->name_extension,
				'fullname'							=>		$active_employee[0]->fullname,
				'birthday'							=>		$active_employee[0]->birthday,
				'age'								=>		$active_employee[0]->age,
				'gender'							=>		$active_employee[0]->gender,
				'civil_status'						=>		$active_employee[0]->civil_status,
				'birth_place'						=>		$active_employee[0]->birth_place,
				'blood_type'						=>		$active_employee[0]->blood_type,
				'citizenship'						=>		$active_employee[0]->citizenship,
				'religion'							=>		$active_employee[0]->religion,

				'company_id'						=>		$active_employee[0]->company_id,
				'location'							=>		$active_employee[0]->location,
				'employment'						=>		$active_employee[0]->employment,
				'classification'					=>		$active_employee[0]->classification,
				'department'						=>		$active_employee[0]->department,
				'section'							=>		$active_employee[0]->section,
				'position'							=>		$active_employee[0]->position,

				'division_id'						=>		$active_employee[0]->division_id,
				'subsection'						=>		$active_employee[0]->subsection,
				
				'bank'								=>		$active_employee[0]->bank,	
				'account_no'						=>		$active_employee[0]->account_no,	
				'tin'								=>		$active_employee[0]->tin,	
				'pagibig'							=>		$active_employee[0]->pagibig,	
				'philhealth'						=>		$active_employee[0]->philhealth,	

				'date_employed'						=>		$active_employee[0]->date_employed,
				'taxcode'							=>		$active_employee[0]->taxcode,
				'pay_type'							=>		$active_employee[0]->pay_type,
				'report_to'							=>		$active_employee[0]->report_to,		
				
				'picture'							=> 		$active_employee[0]->picture,
				'email'								=>		$active_employee[0]->email,
				'InActive'							=>		1,
				'isUser'							=>		0,
				'isEnable'							=>		0,

				'nickname'							=> 		$active_employee[0]->nickname,				
				'sss'								=> 		$active_employee[0]->sss,
				'bank'								=> 		$active_employee[0]->bank,
				'permanent_address'					=> 		$active_employee[0]->permanent_address,
				'permanent_province'				=> 		$active_employee[0]->permanent_province,	
				'permanent_city'					=> 		$active_employee[0]->permanent_city,
				'permanent_address_years_of_stay'	=> 		$active_employee[0]->permanent_address_years_of_stay,
				'present_address'					=> 		$active_employee[0]->present_address,
				'present_province'					=> 		$active_employee[0]->present_province,
				'present_city'						=> 		$active_employee[0]->present_city,
				'present_address_years_of_stay'		=> 		$active_employee[0]->present_address_years_of_stay,
				'mobile_1'							=> 		$active_employee[0]->mobile_1,
				'mobile_2'							=> 		$active_employee[0]->mobile_2,
				'tel_1'								=> 		$active_employee[0]->tel_1,
				'tel_2'								=> 		$active_employee[0]->tel_2,
				'facebook'							=> 		$active_employee[0]->facebook,
				'twitter'							=> 		$active_employee[0]->twitter,
				'instagram'							=> 		$active_employee[0]->instagram,
				'username'							=> 		$active_employee[0]->username,
				'password'							=> 		$active_employee[0]->password,
				'isApplicant'						=> 		$active_employee[0]->isApplicant,
				'isEmployee'						=> 		$active_employee[0]->isEmployee,
				'isApproverChoice'					=> 		$active_employee[0]->isApproverChoice,
				'resume_file'						=> 		$active_employee[0]->resume_file,
				'residence_map'						=> 		$active_employee[0]->residence_map

			);	
			$insert = $this->employee_model->insertToinactiveEmployee($this->data,$inactive_type,$active_employee[0]->employee_id,$others,$date_resigned);
		}
		else
		{
			$date_from= $this->input->post('date_from');
			$date_to= $this->input->post('date_to');
			$log_ins = 'InActive Employee (longleave)';
			$insert = $this->employee_model->insert_to_long_leave_employee($active_employee[0]->employee_id,$others,$date_from,$date_to);
		}
	   if($insert){


		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('201 Employee','Employee Masterlist','logfile_employee_masterlist','Set to Inactive : '.$active_employee[0]->employee_id.'','INACTIVE',$active_employee[0]->employee_id);



			$this->employee_model->employee_logfile($active_employee[0]->employee_id,$log_ins,$date_event,$reason);
			if($inactive_type=='resigned')
			{ $this->employee_model->deleteactiveEmployee($employee_id); }
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> " .$active_employee[0]->fullname." successfully inactive!</div>");
			redirect('app/employee');
		}
		else{
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee cannot be deactivated!</div>");
				redirect('app/employee');
		}
	}
	//M11:==================Active Employee===================
	//Government fields
    public function get_sample_format($sample_format){                      
      //$sample_format    = $government_fields[0]->field_format;
      $forLength        = strlen( $sample_format );
      $numAlpha         = 0;
      $pattern          = '^';
      for( $char = 0; $char <= $forLength; $char++ ) {
          $format_char = substr( $sample_format, $char, 1 );
          if(ctype_alnum($format_char)){
              $numAlpha++;
          }
          else{
            if($numAlpha!=0){
              $pattern = $pattern.'\d{'.$numAlpha.'}';
              $numAlpha = 0;
            }
              $pattern = $pattern.''.$format_char;
          }
          if($char == $forLength){
              $pattern = $pattern.'$';
          }
      }
      return $pattern;
  }
  //END OF GOVERNMENT FIELDS

 public function view_longleave_employee()
 {
 	$this->data['employee'] 	= $this->employee_model->get_employee_longleave();
	$this->data['message'] 		= $this->session->flashdata('message');		 
	$this->load->view('app/employee/longleave_employees',$this->data);
 }

 public function endedleave_employee()
 {
 	$employee_id = $this->input->post('employeeIDD');
 	$return = $this->input->post('date_return');
 	$details = $this->input->post('details');
 	$update = $this->employee_model->endedleave_employee($employee_id,$return,$details);
 	$this->data['employee'] 	= $this->employee_model->get_employee_longleave();
	$this->data['message'] 		= $this->session->flashdata('message');		 
	$this->load->view('app/employee/longleave_employees',$this->data);
 }

 public function check_blocked_employees($f,$m,$l)
 {

 	$employee = $this->employee_model->check_blocked_employees($f,$m,$l);
 	if(count($employee)==0){ echo "<input type='hidden' name='withblockemployee' id='with_blockemployee' value='0'>"; } else{ 
 		
 	?>
 		
 		<div class="col-md-12 container">
		  <div class="panel panel-danger">
		    <div class="panel-heading">List of Blocked Employees</div>
		    <div class="panel-body">
		    	
		    	<table id="example1" class="table table-bordered table-striped" style="margin-top: 20px;">
                    <thead>
                      <tr class="default">
                        <th>Emp. ID</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Company</th>
                        <th>Location</th>
                        <th>Options</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $string = ""; foreach($employee as $employee){
							$string .= $employee->employee_id."-";
				 ?>

                      <tr>
                        <td><?php echo $employee->employee_id?></td>
                        <td><?php echo $employee->first_name; ?></td>
                        <td><?php echo $employee->middle_name; ?></td>
                        <td><?php echo $employee->last_name; ?></td>
                        <td><?php echo $employee->company_name;?></td>
                        <td><?php echo $employee->location_name;?></td>
                        <td>  
                        <center>
                            <a href="<?php echo base_url(); ?>app/employee/employee_profile/<?php echo $employee->employee_id?>" target="_blank"><i class="fa fa-file-text fa-lg" style="color:blue;" class="hidden"  data-toggle="tooltip" data-placement="left" title="View <?php echo $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name.' '.$employee->name_extension; ?>'s 201 Record" ></i>
                            </a>
                        </center>   
                        </td>
                      </tr>
                      <?php } echo "<input type='hidden' name='withblockemployee' id='with_blockemployee' value='".$string."'>"; ?>
                    </tbody>
                  </table>

		    </div>
		  </div>
		</div>

 		
    
 	<?php }
 }

 //new added file



}
