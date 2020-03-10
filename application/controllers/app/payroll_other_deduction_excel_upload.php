<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Payroll_other_deduction_excel_upload extends General{

		function __construct(){
		parent::__construct();	
		$this->load->model("app/payroll_other_deduction_excel_upload_model");
		//$this->load->model("app/payroll_other_addition_emp_enrollment_model");
		$this->load->model("app/employee_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$this->load->library('form_validation');
		

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){	
		$this->load->view('include/header',$this->data); //header	
		$this->load->view('include/sidebar',$this->data); //sidebar	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		 
		 $this->load->view('app/payroll/other_deduction_emp_enrollment/index',$this->data);

       
	}


//OPTION VIEW========================================================================================


public function other_deduction_excel_upload(){	 

		$company_id=$this->uri->segment('4');
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->data['paytypeList_addition'] = $this->payroll_other_deduction_excel_upload_model->paytypeList_addition();
		$this->load->view('app/payroll/other_deduction_emp_enrollment/manual_excel_upload/view',$this->data);		
	}


public function single_upload(){	 

		$company_id=$this->uri->segment('4');
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->data['paytypeList_addition'] = $this->payroll_other_deduction_excel_upload_model->paytypeList_addition();
		$this->load->view('app/payroll/other_deduction_emp_enrollment/manual_excel_upload/selected_single',$this->data);	
	}

public function mass_upload(){	 

		$company_id=$this->uri->segment('4');
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->data['paytypeList_addition'] = $this->payroll_other_deduction_excel_upload_model->paytypeList_addition();
		$this->load->view('app/payroll/other_deduction_emp_enrollment/manual_excel_upload/selected_mass',$this->data);			
	}


//GET GROUP BY PAYTYPE=================================================================================
	public function by_group(){	
			$company_id=$this->uri->segment("4");
			$pay_type=$this->uri->segment("4");

			$this->load->view('app/payroll/other_deduction_emp_enrollment/manual_excel_upload/by_group',$this->data);	
		
	}

	public function by_group_mass(){	
			$company_id=$this->uri->segment("4");
			$pay_type=$this->uri->segment("4");

			$this->load->view('app/payroll/other_deduction_emp_enrollment/manual_excel_upload/by_group_mass',$this->data);
		
	}


//GET PAYROLL PERIOD BY GROUP PAYTYPE=================================================================================
	public function by_payroll_period(){	
		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");
		$pay_type_group=$this->uri->segment("6");
		$this->data['pay_per_addition'] = $this->payroll_other_deduction_excel_upload_model->payroll_per_per_company_pay_type($company_id,$pay_type,$pay_type_group);//$company_id
		$this->data['deduction_type'] = $this->payroll_other_deduction_excel_upload_model->getDeductionTypes($company_id);
			$this->load->view('app/payroll/other_deduction_emp_enrollment/manual_excel_upload/by_payroll_period',$this->data);	
		
	}

	public function by_payroll_period_mass(){	
		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");
		$pay_type_group=$this->uri->segment("6");
		$this->data['pay_per_addition'] = $this->payroll_other_deduction_excel_upload_model->payroll_per_per_company_pay_type($company_id,$pay_type,$pay_type_group);//$company_id
		$this->data['deduction_type'] = $this->payroll_other_deduction_excel_upload_model->getDeductionTypes($company_id);
			$this->load->view('app/payroll/other_deduction_emp_enrollment/manual_excel_upload/by_payroll_period_mass',$this->data);	
		
	}
	public function download($filename = NULL) {
	    // load download helder
	    $this->load->helper('download');
	    // read file contents
	    $data = file_get_contents(base_url('/downloadable_templates/'.$filename));
	    force_download($filename, $data);
	}


//FORM ACTION UPLOAD EXCEL ===========================================================================================


 public function upload()
    {
    	$numOfEmp 		= 0;
    	$foundError 	= False;
    	
    	$excelEmpName 	= array();
    	$result 		= 0;

    	$fileName = $_FILES['file']['name'];
		$action = $_POST['action'];
		$company = $_POST['company_id'];
		$pt_id = $this->input->post('pay_type');	

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
	        
			if($action == 'Save'){
            //For license purpose
	        if($totalEmployee  <= 	$numLicense){
	        	$forNull 		= 'Value cannot be Null';
	            $forInt 		= 'Must be Number. ID number is required';
	            $forIntam		= 'Number and Decimal Only/Characters are not allowed';
	            $existDB 		= '*Please check the Employee_id. Employee ID Already exist in the Database*';
	            $existExcel	 	= 'Duplicate employeeID in Excel';
	            $existIDDB 	= '*Please check Employee ID. Employee ID Already exist in the Database*';
	            $forDate 		= 'Format:yyyy-mm-dd';
	            $forZero 		= 'Emp ID Must not start with zero';
	            $company_error  = 'Employee ID doesnt exist in employee list under this company';
	            $for_pf 		= 'Payroll Formulas doesnt exist in payroll formula list';
	            $forRef 		= 'ID does not exist please check the reference';
	            $for_no_dec     = 'Number and Decimal Only/Characters are not allowed';
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
					    		if($col == 0 || $col == 1 ){ // for null
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
				            		if($col==0){
				            			if(!is_numeric($getCellvalue)){
												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forInt);//Number
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
										}
				            		}

				            		//check the amount format
							     if($col==1)
							          {
							           $value =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
										$checkvalue = $this->containsDecimal($value);
										if($checkvalue === false){
												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$forIntam);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
													}
							            		}		
				            		
										  if($col == 0 ){
             
		                     			 $emp_id_checker =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							             $result_emp_id_checker = $this->payroll_other_deduction_excel_upload_model->empidnotexist($emp_id_checker);
							             	if($result_emp_id_checker === false){
							              	$objPHPExcel->getActiveSheet()->
							                setCellValueByColumnAndRow($col, $row,  $emp_id_checker.' -> '.$forRef);//doesn't exist
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

								          	$employee_id = $rowData[0][0]; 
	                 						$pay_period  = $this->input->post('pay_period');  
	                 						$od_id = $this->input->post('other_deduction_id');
	                 						$company_id = $this->input->post('company_id');
	               							 $dataexist = $this->payroll_other_deduction_excel_upload_model->check_exist($employee_id,$pay_period,$od_id,$company_id);
	               							 if($dataexist ==1){
	                	//ECHO "ALREADY EXIST IN THE DATABASE";
	                							$this->db->delete("other_deduction_enrollment", array('other_deduction_id' => $oa_id, 'employee_id'=>$employee_id,'payroll_period_id' => $this->input->post('pay_period')));
												}
											$dob = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($rowData[0][4]));
	               							 $data = array(
													'employee_id'  			=> $employee_id,
													'company_id'			=> $company_id,
													'payroll_period_id'		=> $pay_period,
													'other_deduction_id'	=> $od_id,
													'entry_type'			=> $this->input->post('entry_type'),
													'amount'  				=> $rowData[0][1],
													'date_added'			=> date('Y-m-d H:i:s')
							

	                       							 );

	               
	               								 $insert = $this->payroll_other_deduction_excel_upload_model->insertImport($data);
	              							
						

	            	}//end of insert 

			            if($insert){ //file name for successfully imported
				            	$this->data['action']='save';
								$this->data['count_data']=$highestRow - 1;
								$this->data['company']=$company;
								$this->load->view('app/payroll/other_deduction_emp_enrollment/manual_excel_upload/review_upload/template_header',$this->data);
								for ($row = 2; $row <= $highestRow; $row++){
									$this->data['col_0']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
									$this->data['col_1']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
									$this->data['col_2']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
									$this->data['col_3']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
									$this->data['col_4']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
									$this->data['col_5']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
									$this->data['col_6']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $row)->getValue();
									$this->data['col_7']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
									$this->data['col_8']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
									$this->load->view('app/payroll/other_deduction_emp_enrollment/manual_excel_upload/review_upload/template_content',$this->data);
								}
								$this->load->view('app/payroll/other_deduction_emp_enrollment/manual_excel_upload/review_upload/template_footer',$this->data);
							       $dt = $date_array = getdate();
							       $formated_date  = "payroll_emploan_enrolment_";
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
					header('Content-Disposition: attachment;filename="' ."set_auto_addition_template_error". '""' .date('Y-m-d')."_".date('H:i:s').".xlsx".'"');
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
					$this->load->view('app/payroll/other_deduction_emp_enrollment/manual_excel_upload/review_upload/template_header',$this->data);
						for ($row = 2; $row <= $highestRow; $row++){

							$col_0 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
							$col_1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
							$col_2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
							
							if(empty($col_0) || empty($col_1)){
								$foundError=True;
								$null='Check empty fieds.<br>';
							}
							else{ 
								
								$null='';}

							if(!is_numeric($col_1)){
								$foundError=True;
								$pf_error='Must be Number. only number is required for Amount.<br>';
							}
							else{ 
								
								$pf_error='';}

						
							$checkvalue = $this->containsDecimal($col_1);
							if($checkvalue === false){
								$foundError = True;
								$decim='Invalid Number/Decimal format<br>';
							} else{ 
								$decim=''; }
							$getemp = $col_0;		
							$employee_companylist =$col_0;
							$resultemployee_companylist = $this->payroll_other_deduction_excel_upload_model->employee_company_checker_model($employee_companylist,$company,$pt_id);
								if($resultemployee_companylist === false){
									$foundError = True;
									$emp_comp='Employee doesnt exist in company Id '.$company.' or employee is not belong to this Paytype Id '.$pt_id.'<br>';
								} else{  $emp_comp=''; }
							
							/*$getpf = $col_2;
							$result_pf_id = $this->payroll_other_addition_automatic_model->pf_id_checker_model($getpf);
							if($result_pf_id === false){
									$foundError = True;
									$pf_id='Payroll Formulas not Exist';
								} else{  $pf_id=''; }
*/
							$employee_checker =$col_0;
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
							//$this->data['col_2']= $col_2;
						
							
							if($foundError==True)
							{
								$this->data['remarks']= 'Error';
								
								$this->data['errors']= $null.'<br>'.$emp_comp.'<br>'.$decim.'<br>'.$exist_excel.'<br>'.$pf_error;;
							}
							else{
								$this->data['remarks']= 'Ok';
							}
							$this->load->view('app/payroll/other_deduction_emp_enrollment/manual_excel_upload/review_upload/template_content',$this->data);
				}
					$this->load->view('app/payroll/other_deduction_emp_enrollment/manual_excel_upload/review_upload/template_footer',$this->data);
					unlink($inputFileName);		
			}//end of upload has imported a file
		}
		else{
			echo "<script>alert('Error report to technical support')</script>";
		}
	}





//MASS UPLOAD====================================================================
public function for_mass_upload()
    {
    	$numOfEmp 		= 0;
    	$foundError 	= False;
    	
    	$excelEmpName 	= array();
    	$result 		= 0;

    	$fileName = $_FILES['file']['name'];
		$action = $_POST['action'];
		$company = $_POST['company_id'];
		$pt_id = $this->input->post('pay_type');	

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
	        
			if($action == 'Save'){
            //For license purpose
	        if($totalEmployee  <= 	$numLicense){
	        	$forNull 		= 'Value cannot be Null';
	            $forInt 		= 'Must be Number. ID number is required';
	            $forIntpt 		= 'Must be Number. only number is required';
	            $forIntam		= 'Number and Decimal Only/Characters are not allowed';
	            $existDB 		= '*Please check the Employee_id. Employee ID Already exist in the Database*';
	            $existExcel	 	= 'Duplicate employeeID in Excel';
	            $existIDDB 	= '*Please check Employee ID. Employee ID Already exist in the Database*';
	            $forDate 		= 'Format:yyyy-mm-dd';
	            $forZero 		= 'Emp ID Must not start with zero';
	            $company_error  = 'Employee ID doesnt exist in employee list under this company';
	            $for_pf 		= 'Payroll Formulas doesnt exist in payroll formula list';
	            $forRef 		= 'ID does not exist please check the reference';
	            $for_no_dec     = 'Number and Decimal Only/Characters are not allowed';
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
					    		if($col == 0 || $col == 1 || $col == 2){ // for null
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
				            		if($col==0){
				            			if(!is_numeric($getCellvalue)){
												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forInt);//Number
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
										}
				            		}

				            		if($col == 1 ){
									if(!is_numeric($getCellvalue)){
												$objPHPExcel->getActiveSheet()->
											setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forIntpt);//Number
											$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
											$foundError = True;
										}
									}

				            		//check the amount format
							      if($col==2)
							          {
							           $value =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
										$checkvalue = $this->containsDecimal($value);
										if($checkvalue === false){
												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$forIntam);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
													}
							            		}		
				            		
 								if($col == 0 ){
             
		                     			 $emp_id_checker =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							             $result_emp_id_checker = $this->payroll_other_deduction_excel_upload_model->empidnotexist($emp_id_checker);
							             	if($result_emp_id_checker === false){
							              	$objPHPExcel->getActiveSheet()->
							                setCellValueByColumnAndRow($col, $row,  $emp_id_checker.' -> '.$forRef);//doesn't exist
							               	$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
							                $foundError = True;
								              }
								           }	


							   if($col == 1 ){
             
		                     			 $od_id_checker =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							             $result_od_id_checker = $this->payroll_other_deduction_excel_upload_model->odidnotexist($od_id_checker);
							             	if($result_od_id_checker === false){
							              	$objPHPExcel->getActiveSheet()->
							                setCellValueByColumnAndRow($col, $row,  $od_id_checker.' -> '.$forodid);//doesn't exist
							               	$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
							                $foundError = True;
								              }
								           }	
 												
				           				}
		         	$colLetter++;// increment A
					}//end of col for loop
		         }//end of row for loop
		     
				//for compare excel employee_id
				/*$colLetter 		= 'A';
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
*/
		         //End of check and rewrite the error of imported excel
		         if($foundError==False){ // insert to employee_info table
		        	for ($row = 2; $row <= $highestRow; $row++){
								            	$numOfEmp++;                                  
								                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
		                                            NULL,
		                                            TRUE,
		                                           	FALSE);

								    $employee_id = $rowData[0][0]; 
	                 				$pay_period  = $this->input->post('pay_period');  
	                				$od_id = $rowData[0][1];
	                				$company_id = $this->input->post('company_id');
	                
	                					$dataexist = $this->payroll_other_deduction_excel_upload_model->check_exist($employee_id,$pay_period,$od_id,$company_id);
	                				
	                				if($dataexist ==1){
	                	//ECHO "ALREADY EXIST IN THE DATABASE";
	                					$this->db->delete("other_deduction_enrollment", array('other_deduction_id' => $oa_id, 'employee_id'=>$employee_id,'payroll_period_id' => $this->input->post('pay_period')));

	                					}
									
									$dob = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($rowData[0][4]));
	               					 $data = array(
												'employee_id'  			=> $employee_id,
												'company_id'			=> $company_id,
												'payroll_period_id'		=> $pay_period,
												'other_deduction_id'		=> $od_id,
												'entry_type'			=> $this->input->post('entry_type'),
												'amount'  				=> $rowData[0][2],
												'date_added'			=> date('Y-m-d H:i:s')
							

	                       					 );
	                				$insert = $this->payroll_other_deduction_excel_upload_model->insertImport($data);
	              	
	              	

	            	}//end of insert 

			            if($insert){ //file name for successfully imported
				            	$this->data['action']='save';
								$this->data['count_data']=$highestRow - 1;
								$this->data['company']=$company;
								$this->load->view('app/payroll/other_deduction_emp_enrollment/manual_excel_upload/review_mass_upload/template_header',$this->data);
								for ($row = 2; $row <= $highestRow; $row++){
									$this->data['col_0']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
									$this->data['col_1']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
									$this->data['col_2']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
									$this->data['col_3']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
									$this->data['col_4']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
									$this->data['col_5']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
									$this->data['col_6']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $row)->getValue();
									$this->data['col_7']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
									$this->data['col_8']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
									$this->load->view('app/payroll/other_deduction_emp_enrollment/manual_excel_upload/review_mass_upload/template_content',$this->data);
								}
								$this->load->view('app/payroll/other_deduction_emp_enrollment/manual_excel_upload/review_mass_upload/template_footer',$this->data);
							       $dt = $date_array = getdate();
							       $formated_date  = "payroll_emploan_enrolment_";
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
					header('Content-Disposition: attachment;filename="' ."set_auto_addition_template_error". '""' .date('Y-m-d')."_".date('H:i:s').".xlsx".'"');
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
					$this->load->view('app/payroll/other_deduction_emp_enrollment/manual_excel_upload/review_mass_upload/template_header',$this->data);
						for ($row = 2; $row <= $highestRow; $row++){

							$col_0 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
							$col_1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
							$col_2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
							
							if(empty($col_0) || empty($col_1 || empty($col_2))){
								$foundError=True;
								$null='Check empty fieds.<br>';
							}
							else{ 
								
								$null='';}

							if(!is_numeric($col_2)){
								$foundError=True;
								$pf_error='Must be Number. only number is required for Amount.<br>';
							}
							else{ 
								
								$pf_error='';}

						
							$checkvalue = $this->containsDecimal($col_1);
							if($checkvalue === false){
								$foundError = True;
								$decim='Invalid Number/Decimal format<br>';
							} else{ 
								$decim=''; }
							$getemp = $col_0;		
							$employee_companylist =$col_0;
							$resultemployee_companylist = $this->payroll_other_deduction_excel_upload_model->employee_company_checker_model($employee_companylist,$company,$pt_id);
								if($resultemployee_companylist === false){
									$foundError = True;
									$emp_comp='Employee doesnt exist in company Id '.$company.' or employee is not belong to this Paytype Id '.$pt_id.'<br>';
								} else{  $emp_comp=''; }
							
								 $oa_id_checker =$col_1;
							             $result_oa_id_checker = $this->payroll_other_deduction_excel_upload_model->odidnotexist($oa_id_checker);
							
							if($result_oa_id_checker === false){
									$foundError = True;
									$oa_id='Other Addition ID not Exist';
								} else{  $oa_id=''; }

							$employee_checker =$col_0;
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
						
							
							if($foundError==True)
							{
								$this->data['remarks']= 'Error';
								
								$this->data['errors']= $null.'<br>'.$emp_comp.'<br>'.$decim.'<br>'.$oa_id.'<br>'.$pf_error;
							}
							else{
								$this->data['remarks']= 'Ok';
							}
							$this->load->view('app/payroll/other_deduction_emp_enrollment/manual_excel_upload/review_mass_upload/template_content',$this->data);
				}
					$this->load->view('app/payroll/other_deduction_emp_enrollment/manual_excel_upload/review_mass_upload/template_footer',$this->data);
					unlink($inputFileName);		
			}//end of upload has imported a file
		}
		else{
			echo "<script>alert('Error report to technical support')</script>";
		}
	}



   
	/*	public function compare_empName_excel($compVal,$excelEmpName,$tempvalue){

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

	}*/

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


	function containsDecimal($value) {

	if ( strpos( $value, "." ) !== false ||  is_numeric($value) !==false) {
	        return true;
	    }
	    return false;
	}




	//==========================================End Mass upload==========================================//	
	

}//controller





