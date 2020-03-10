<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Mass_upload_employee extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/employee_model");
		$this->load->model("app/employee_201_profile_model");
		$this->load->model("general_model");
		$this->load->model("app/mass_upload_employee_model");
		//m11
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$this->load->library('form_validation');
		//m11
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	

 public function import_mass_upload_template()
 {
 	
 		$numOfEmp 		= 0;
    	$foundError 	= False;
    	
    	$excelEmpName 	= array();
    	$result 		= 0;

    	$fileName = $_FILES['file']['name'];
		$action = $_POST['action'];
		$company = $_POST['company'];

			$config['upload_path'] 		= './public/import_template/'; 
	        $config['file_name'] 		= $fileName;
	        $config['allowed_types'] 	= 'xlsx|xls';
	        $config['max_size'] 		= 10000;

	        $this->load->library('upload');
	        $this->upload->initialize($config);
	         if(! $this->upload->do_upload('file'))
	        	$this->upload->display_errors();

	        $media = $this->upload->data('file');
	        $inputFileName = './public/import_template/'.$fileName;
	        $imagepath    =   "user.png";
	          try {
	            $inputFileType 	= IOFactory::identify($inputFileName);
	            $objReader 		= IOFactory::createReader($inputFileType);
	            $objPHPExcel 	= $objReader->load($inputFileName);
	           } catch(Exception $e) {
			       echo "<script>alert('Invalid file format.Please use the template')</script>";
					echo " <script type='text/javascript'>
							    open(location, '_self').close();
							</script>";     	
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
		if(isset($_POST["import"]))
	    {
	        
			if($action == 'Save')
			{
            

				 //For license purpose
	        if($totalEmployee  <= 	$numLicense){
	        	$forNull 		= 'Value cannot be Null';
	            $forInt 		= 'Must be Number. ID number is required';
	            $existDB 		= '*Please check the Employee_id. Employee ID Already exist in the Database*';
	            $existExcel	 	= 'Duplicate employeeID in Excel';
	            $existIDDB 		= '*Please check Employee ID. Employee ID Already exist in the Database*';
	            $forDate 		= 'Format:yyyy-mm-dd';
	            $forZero 		= 'Emp ID Must not start with zero';
	            $company_error = 'Employee ID doesnt exist in employee list under company id';

	            $employeeexit = 'Employee ID already exist';
	            $empgender   = 'Invalid Gender ID';
	            $empcivilstatus = 'Invalid Civil Status ID';
	            $empcompany = 'Invalid Company ID';
	            $emplocation = 'Invalid Location ID';
	            $empdivision = 'Invalid Division ID';
	            $empdivision1 = 'Leave the division field empty,company id has no division.';
	            $empdepartment = 'Invalid Department ID';
				$empsection = 'Invalid Section ID';
				$empsubsection = 'Invalid Subsection ID';
				$empsubsection1 = 'Leave the subsection field empty,section has no subsection.';

				$empemployment = 'Invalid Employment ID';
				$empclassification = 'Invalid Classification ID';
				$empposition = 'Invalid Position ID';
				$emptaxcode = 'Invalid Tax Code ID';
				$emppaytype = 'Invalid Pay Type ID';


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
					    		if($col == 0 || $col == 1 || $col == 2 || $col == 3 || $col == 4 || $col == 5 || $col == 6 || $col == 7 || $col == 8 || $col == 10 || $col == 11 || $col == 13 || $col == 14|| $col == 15 || $col == 16 || $col == 17 || $col == 18){ // for null
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
										setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forZero);//start zero
										$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignmdent()->setWrapText(true);
											$foundError = True;
										}
				            		}

				            		if($col==0)
				            		{
				            			$col0 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
										$check_if_emp_exist = $this->mass_upload_employee_model->check_if_employee_exist($col0);
													
										if(!empty($check_if_emp_exist)){
											$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $col0.' -> '.$employeeexit);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
										}
				            		}


				            		if($col==4 || $col==18){
				            			
				            			$date =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
										$check = $this->validateDate($date);
													
										if($check === false){
											$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $date.' -> '.$forDate);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
										}

				            		}


				            		if($col==5)
				            		{
				            			$col5 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
										$check_emp_gender = $this->mass_upload_employee_model->check_emp_gender($col5);
													
										if(empty($check_emp_gender)){
											$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $col5.' -> '.$empgender);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
										}
				            		}
				            		

				            		if($col==6)
				            		{
				            			$col6 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
										$check_emp_civilstatus = $this->mass_upload_employee_model->check_emp_civilstatus($col6);
													
										if(empty($check_emp_civilstatus)){
											$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $col6.' -> '.$empcivilstatus);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
										}
				            		}
				            	

				            		if($col==7)
				            		{
				            			$col7 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
										$check_emp_companyid = $this->mass_upload_employee_model->check_emp_companyid($col7);
													
										if(empty($check_emp_companyid)){
											$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $col7.' -> '.$empcompany);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
										}
				            		}

				            		if($col==8)
				            		{
				            			$col7 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
				            			$col8 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $row)->getValue();

										$check_emp_location = $this->mass_upload_employee_model->check_emp_location($col7,$col8);
													
										if(empty($check_emp_location)){
											$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $col8.' -> '.$emplocation);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
										}
				            		}


				            		if($col==9)
				            		{
				            			$col7 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
				            			$col9 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();

										$check_emp_division = $this->mass_upload_employee_model->check_emp_division($col7,$col9);
													
										if(empty($check_emp_division)){
											$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $col9.' -> '.$empdivision);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
										}
										else
										{
											if($check_emp_division=='empty'){
												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $col9.' -> '.$empdivision1);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
											}
										}
				            		}

				            		if($col==10)
				            		{
				            			$col7 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
				            			$col9 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9, $row)->getValue();
				            			$col10 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();

										$check_emp_department = $this->mass_upload_employee_model->check_emp_department($col7,$col10,$col9);
													
										if(empty($check_emp_department)){
											$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $col10.' -> '.$empdepartment);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
										}
				            		}

				            		if($col==11)
				            		{
				            			$col7 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
				            			$col11=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();

										$check_emp_section = $this->mass_upload_employee_model->check_emp_section($col7,$col11);
													
										if(empty($check_emp_section)){
											$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $col11.' -> '.$empsection);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
										}
				            		}

				            		if($col==12)
				            		{
				            			$col7 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
				            			$col11 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(11, $row)->getValue();
				            			$col12 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();

										$check_emp_subsection = $this->mass_upload_employee_model->check_emp_subsection($col7,$col11,$col12);
													
										if(empty($check_emp_subsection)){
											$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $col12.' -> '.$empsubsection);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
										}
										else
										{
											if($check_emp_subsection=='empty'){
												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $col12.' -> '.$empsubsection1);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
											}
										}
				            		}



				            		if($col==13)
				            		{
				            			$col7 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
				            			$col13 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
										$check_emp_employment = $this->mass_upload_employee_model->check_emp_employment($col7,$col13);
													
										if(empty($check_emp_employment)){
											$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $col13.' -> '.$empemployment);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
										}
				            		}


				            		if($col==14)
				            		{
				            			$col7 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
				            			$col14 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
										$check_emp_classification = $this->mass_upload_employee_model->check_emp_classification($col7,$col14);
													
										if(empty($check_emp_classification)){
											$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $col14.' -> '.$empclassification);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
										}
				            		}

				            		if($col==15)
				            		{
				            			$col7 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
				            			$col15 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
										$check_emp_position = $this->mass_upload_employee_model->check_emp_position($col7,$col15);
													
										if(empty($check_emp_position)){
											$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $col15.' -> '.$empposition);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
										}
				            		}

				            		if($col==16)
				            		{
				            			$col7 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
				            			$col16 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
										$check_emp_taxcode = $this->mass_upload_employee_model->check_emp_taxcode($col7,$col16);
													
										if(empty($check_emp_taxcode)){
											$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $col16.' -> '.$emptaxcode);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
										}
				            		}

				            		if($col==17)
				            		{
				            			$col7 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
				            			$col17 =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
										$check_emp_paytype = $this->mass_upload_employee_model->check_emp_paytype($col7,$col17);
													
										if(empty($check_emp_paytype)){
											$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $col17.' -> '.$emppaytype);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
										}
				            		}


							         		
 												
				           	}
		         	$colLetter++;// increment A
					}//end of col for loop
		         }//end of row for loop
		     
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
				}

		         //End of check and rewrite the error of imported excel
		         if($foundError==False){ // insert to employee_info table
		        	for ($row = 2; $row <= $highestRow; $row++){
							$numOfEmp++;                                  
							$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
		                                            NULL,
		                                            TRUE,
		                                           	FALSE);
								                    $dt = $date_array = getdate();
								                   $formated_date  = "employee_mass_upload_";
											       $formated_date .= $date_array['mon'];
											       $formated_date .= $date_array['mday'];
												   $formated_date .= $date_array['year'] . "_";
												   $formated_date .= $date_array['hours'];
											       $formated_date .= $date_array['minutes'];
												   $formated_date .= $date_array['seconds'];
								                   $ref 	  =	$rowData[0][6];
								                   $emp 	  =	$rowData[0][0];
		                						   $date_created 	= date('Y-m-d H:i:s');
								          
							
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

			                $data_2  = array(	
			                		'employee_id'  		=> 	$rowData[0][0],
	                 				'company_id'  		=> 	$rowData[0][7],
									'location'  		=> 	$rowData[0][8],
									'division_id'	  	=> 	$rowData[0][9],
									'department'  		=> 	$rowData[0][10],
									'section'  			=> 	$rowData[0][11],
									'subsection'	  	=> 	$rowData[0][12],
									'employment'  		=> 	$rowData[0][13],
									'classification'  	=> 	$rowData[0][14],
									'position'  		=> 	$rowData[0][15],
									'date_employed'  	=> 	$employed_date,
									'details'			=>	'New added employee',
									'added_by'			=>	$this->session->userdata('employee_id'),
									'date_added'        =>	date('Y-m-d H:i:s'));


	                		$insert 			= $this->mass_upload_employee_model->insertImport($data,$data_2);
	              			$default_password 	= $this->mass_upload_employee_model->get_default_password();
	              			$field_default		= $default_password[0]->field_name;
							$employee 			= $this->mass_upload_employee_model->get_active_employee($employee_id);
							$set_default 		= $employee[0]->$field_default;
							$this->mass_upload_employee_model->set_default_password($set_default, $employee_id);
			                $data = array(
								'employee_id'		=>	$rowData[0][0],
								'company_id'		=>  $rowData[0][12]
							);
							$this->mass_upload_employee_model->insert_udf($data);
							//Payroll_pagibig_table
							$pagibig_setting 	= $this->mass_upload_employee_model->get_pagibig_employee_setting($company_id);
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
								$this->mass_upload_employee_model->insert_pagibig_employee_setting($data_pagibig);
								$checkpagibig = true;
							}
							if($checkpagibig === false){
								$data_pagibig = array(
									'employee_id'		=> $employee_id,
									'company_id'		=> $company_id,
									'year'				=> $current_year
								);
								$this->mass_upload_employee_model->insert_pagibig_employee_setting($data_pagibig);
							}



	            	}//end of insert
			            if($insert){ //file name for successfully imported
				            	$this->data['action']='save';
								$this->data['count_data']=$highestRow - 1;
								$this->data['company']=$company;
								$this->load->view('app/employee/review_upload/template_header',$this->data);
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
									$this->data['col_13']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(13, $row)->getValue();
									$this->data['col_14']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(14, $row)->getValue();
									$this->data['col_15']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(15, $row)->getValue();
									$this->data['col_16']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(16, $row)->getValue();
									$this->data['col_17']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(17, $row)->getValue();
									$this->data['col_18']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(18, $row)->getValue();

									$this->load->view('app/employee/review_upload/template_content',$this->data);
								}
								$this->load->view('app/employee/review_upload/template_footer',$this->data);
							       $dt = $date_array = getdate();
							       $formated_date  = "employee_mass_upload_";
							       $formated_date .= $date_array['mon'];
							       $formated_date .= $date_array['mday'];
								   $formated_date .= $date_array['year'] . "_";
								   $formated_date .= $date_array['hours'];
							       $formated_date .= $date_array['minutes'];
								   $formated_date .= $date_array['seconds'];
							    	rename( $inputFileName, './public/import_template/'.$formated_date.'.xls' );
						} //end of file name for successfully imported
				}//end of else find error
				else{//download if found an error
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
					header('Content-Disposition: attachment;filename="' ."employee_mass_upload_errr". '""' .date('Y-m-d')."_".date('H:i:s').".xlsx".'"');
					header('Cache-Control: max-age=0');
					unlink($inputFileName);
					$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$objWriter->save('php://output');
					exit; 
				}//end of download if found an error
			}//end of For license purpose
			// end of else license purchase









				 
			}

			else{
					$this->data['action']='review'; 
					$this->load->view('app/employee/review_upload/template_header',$this->data);

						for ($row = 2; $row <= $highestRow; $row++){

							$col_0 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
							$col_1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
							$col_2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
							$col_3 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
							$col_4 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
							$col_5 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
							$col_6 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $row)->getValue();
							$col_7 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();

							$col_8  = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $row)->getValue();
							$col_9  = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9, $row)->getValue();
							$col_10 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(10, $row)->getValue();
							$col_11 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(11, $row)->getValue();
							$col_12 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(12, $row)->getValue();
							$col_13 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(13, $row)->getValue();
							$col_14 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(14, $row)->getValue();
							$col_15 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(15, $row)->getValue();
							$col_16 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(16, $row)->getValue();
							$col_17 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(17, $row)->getValue();
							$col_18 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(18, $row)->getValue();

							if(empty($col_0) || empty($col_1) || empty($col_2) || empty($col_3) || empty($col_4) || empty($col_5) || empty($col_6) || empty($col_7) 
								|| empty($col_8) || empty($col_10) || empty($col_11) || empty($col_13) || empty($col_14) || empty($col_15)
									|| empty($col_16) || empty($col_17) || empty($col_18) ){
								$foundError=True;
								$null='Check empty fieds/<br>';
							}
							else{ $null=''; }

							$check = $this->validateDate($col_4);
							$check1 = $this->validateDate($col_18);
							if($check === false || $check1 === false){
									$foundError = True;
									$date='Invalid Date/<br>';
							} else {  $date=''; }


							$check_if_emp_exist = $this->mass_upload_employee_model->check_if_employee_exist($col_0);
							if(!empty($check_if_emp_exist))
							{
								$foundError = True;
								$emp_exist='Employee ID already exist/<br>';
							} else { $emp_exist=''; }

							$check_emp_gender = $this->mass_upload_employee_model->check_emp_gender($col_5);
							if(empty($check_emp_gender))
							{
								$foundError = True;
								$emp_gender='Invalid gender id/<br>';
							} else { $emp_gender=''; }

							$check_emp_civilstatus = $this->mass_upload_employee_model->check_emp_civilstatus($col_6);
							if(empty($check_emp_civilstatus))
							{
								$foundError = True;
								$emp_civilstatus='Invalid civil status id/<br>';
							} else { $emp_civilstatus=''; }

							$check_emp_civilstatus = $this->mass_upload_employee_model->check_emp_civilstatus($col_6);
							if(empty($check_emp_civilstatus))
							{
								$foundError = True;
								$emp_civilstatus='Invalid civil status id/<br>';
							} else { $emp_civilstatus=''; }

							$check_emp_companyid = $this->mass_upload_employee_model->check_emp_companyid($col_7);
							if(empty($check_emp_companyid))
							{
								$foundError = True;
								$emp_companyid='Invalid company id/<br>';
							} else { $emp_companyid=''; }
							
							$check_emp_location = $this->mass_upload_employee_model->check_emp_location($col_7,$col_8);
							if(empty($check_emp_location))
							{
								$foundError = True;
								$emp_locationid='Invalid location id/<br>';
							} else { $emp_locationid=''; }





							$check_emp_division = $this->mass_upload_employee_model->check_emp_division($col_7,$col_9);
							if(empty($check_emp_division))
							{
								$foundError = True;
								$emp_division='Invalid division id/<br>';
								
								
							} 
							else 
							{ 
								if($check_emp_division=='empty' AND !empty($col_9))
								{
									$foundError = True;
									$emp_division='Leave the division field empty,company id has no division/<br>';
								}
								else
								{
									$emp_division=''; 	
								}
							}

							$check_emp_department = $this->mass_upload_employee_model->check_emp_department($col_7,$col_10,$col_9);
							if(empty($check_emp_department))
							{
								$foundError = True;
								$emp_department='Invalid department id/<br>';
							} else { $emp_department=''; }


							$check_emp_section = $this->mass_upload_employee_model->check_emp_section($col_7,$col_11);
							if(empty($check_emp_section))
							{
								$foundError = True;
								$emp_section='Invalid section id/<br>';
							} else { $emp_section=''; }


							$check_emp_subsection = $this->mass_upload_employee_model->check_emp_subsection($col_7,$col_11,$col_12);
							if(empty($check_emp_subsection))
							{
								$foundError = True;
								$emp_subsection='Invalid subsection id/<br>';
								
							} 
							else 
							{ 
								if($check_emp_subsection=='empty' AND !empty($col_12))
								{
									$foundError = True;
									$emp_subsection='Leave the subsection field empty,Section has no subsection/<br>';
								}
								else
								{
									$emp_subsection=''; 	
								}
							}

							
							$check_emp_employment = $this->mass_upload_employee_model->check_emp_employment($col_7,$col_13);
							if(empty($check_emp_employment))
							{
								$foundError = True;
								$emp_employment='Invalid employment id/<br>';
							} else { $emp_employment=''; }

							$check_emp_classification = $this->mass_upload_employee_model->check_emp_classification($col_7,$col_14);
							if(empty($check_emp_classification))
							{
								$foundError = True;
								$emp_classification='Invalid classification id/<br>';

							} else { $emp_classification=''; }

							
							$check_emp_position = $this->mass_upload_employee_model->check_emp_position($col_7,$col_15);
							if(empty($check_emp_position))
							{
								$foundError = True;
								$emp_position='Invalid position id /<br>';

							} else { $emp_position=''; }


							$check_emp_taxcode = $this->mass_upload_employee_model->check_emp_taxcode($col_7,$col_16);
							if(empty($check_emp_taxcode))
							{
								$foundError = True;
								$emp_taxcode='Invalid taxcode id/<br>';

							} else { $emp_taxcode=''; }


							$check_emp_paytype = $this->mass_upload_employee_model->check_emp_paytype($col_7,$col_17);
							if(empty($check_emp_paytype))
							{
								$foundError = True;
								$emp_paytype='Invalid paytype id/<br>';

							} else { $emp_paytype=''; }





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
									$exist_Ex='Duplicate Employee ID in excel.'; } else{ $exist_Ex=""; }
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
							$this->data['col_13']= $col_13;
							$this->data['col_14']= $col_14;
							$this->data['col_15']= $col_15;
							$this->data['col_16']= $col_16;
							$this->data['col_17']= $col_17;
							$this->data['col_18']= $col_18;
							
							if($foundError==True)
							{
								$this->data['remarks']= 'Error';
								
								$this->data['errors']= $null.$date.$exist_excel.$emp_exist.$emp_gender.$emp_civilstatus.$emp_companyid.$emp_locationid.$emp_employment.$emp_classification.$emp_position.$emp_taxcode.$emp_paytype.$emp_division.$emp_department.$emp_section.$emp_subsection;
							}
							else{
								$this->data['remarks']= 'Ok';
							}

							$this->load->view('app/employee/review_upload/template_content',$this->data);

				}
					$this->load->view('app/employee/review_upload/template_footer',$this->data);
					unlink($inputFileName);		
			}//end of upload has imported a file
		}
		else{
			echo "<script>alert('Error report to technical support')</script>";
		}

 }


 		//validations

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
	public function compare_empID_excel_DB($excelEmpID,$tempvalue){//M11: compare excel to DB

			$result = count($excelEmpID);
			for($value = 0; $value < $result; $value++){
				if($excelEmpID[$value]==$tempvalue){
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





}
