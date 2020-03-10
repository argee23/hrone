<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Payroll_other_deduction_automatic extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/payroll_other_deduction_automatic_model");
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
		 
		 $this->load->view('app/payroll/other_addition_emp_enrollment/index',$this->data);

       
	}


//AUTOMATIC ADDITION VIEW========================================================================================

public function automatic_deduction(){	 

		$company_id=$this->uri->segment('4');
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->data['deductiontype_list'] = $this->payroll_other_deduction_automatic_model->deduction_type_list($company_id);
		$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/automatic_deduction_view',$this->data);		
	}


//START OF ADDING NEW AUTOMATIC ADDITION===========================================================================
public function add_new_automatic_deduction(){
        $company_id =$this->uri->segment('4');
        $this->data['paytypeList_deduction'] = $this->payroll_other_deduction_automatic_model->paytypeList_deduction();		
		$this->data['deduction_type'] = $this->payroll_other_deduction_automatic_model->get_deduction_result_add($company_id);
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->data['pay_type_option'] = $this->payroll_other_deduction_automatic_model->pay_type_option();
		$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/add_new_automatic_deduction',$this->data);
	}



public function save_new_automatic_deductions($cutoff,$company_id,$id,$effectivity_date,$pay_type,$is_automatic){	 
		
	$already_exist = $this->payroll_other_deduction_automatic_model->check_exist_auto($cutoff,$company_id,$id,$effectivity_date,$pay_type,$is_automatic);
		if($already_exist == 1){

				$other_deduction_code = $this->payroll_other_deduction_automatic_model->flash_deduct_update($id);
					$value = $other_deduction_code->other_deduction_code." (".$other_deduction_code->id.")";

				General::logfile('Other Deduction Automatic','ADDED',$value);

				$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The Deduction, <strong>".$value."</strong>is Already Exist!</div>");

		}else{

				$other_deduction_code = $this->payroll_other_deduction_automatic_model->flash_deduct_update($id);

				$this->payroll_other_deduction_automatic_model->automatic_deduction_saves($cutoff,$company_id,$id,$effectivity_date,$pay_type,$is_automatic);
		
				$value = $other_deduction_code->other_deduction_code." (".$other_deduction_code->id.")";

				General::logfile('Other Deduction Automatic','ADDED',$value);

				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The Deduction, <strong>".$value."</strong>is Successfully Added!</div>");
		}

		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->data['deductiontype_list'] = $this->payroll_other_deduction_automatic_model->deduction_type_list($company_id);
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/save_new_automatic_deductions',$this->data);		
		
	}

//EDIT SET AUTOMATIC ADDITION WITH EMPLOYEE/WITHOUT ENROLL===================================================================================

	public function edit_set_automatic_deduction($cutoff,$pay_type,$date_effective,$od_id,$company_id,$id){
		
	
		$this->data['addition_type'] = $this->payroll_other_deduction_automatic_model->get_deduction_result_edit($od_id,$company_id);
	    $this->data['paytypeList_deduction'] = $this->payroll_other_deduction_automatic_model->paytypeList_deduction();
	    $this->data['paytypeList_selected'] = $this->payroll_other_deduction_automatic_model->paytypeList_deduction_selected($pay_type);		
		$this->data['query'] = $this->payroll_other_deduction_automatic_model->viewDetails_model($cutoff,$pay_type,$date_effective,$od_id,$company_id,$id);
		$this->data['pay_type_option'] = $this->payroll_other_deduction_automatic_model->pay_type_option();

		$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/edit_set_automatic_deduction',$this->data);


	}

//UPDATE SET AUTOMATIC WITH ENROLL EMPLOYEE==========================================================================================

public function save_edit_e_automatic_deductions($cutoff,$company_id,$id,$od_id,$effectivity_date,$pay_type,$is_automatic){	 

		$other_deduction_code = $this->payroll_other_deduction_automatic_model->flash_deduct_updates($od_id);


		$this->payroll_other_deduction_automatic_model->automatic_deduction_saves_e($cutoff,$company_id,$id,$od_id,$effectivity_date,$pay_type,$is_automatic);

		$value = $other_deduction_code->other_deduction_code." (".$other_deduction_code->id.")";

		General::logfile('Other Additions Automatic','UPDATED',$value);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The Date Effectiivity of Deduction, <strong>".$value."</strong> is Successfully Updated!</div>");
		
		
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->data['deductiontype_list'] = $this->payroll_other_deduction_automatic_model->deduction_type_list($company_id);
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/save_new_automatic_deductions',$this->data);		
		
	}


//UPDATE SET AUTOMATIC WITHOUT ENROLL EMPLOYEE==========================================================================================

public function save_edit_ne_automatic_deductions($cutoff,$company_id,$id,$od_id,$effectivity_date,$pay_type,$is_automatic){	 

		$other_deduction_code = $this->payroll_other_deduction_automatic_model->flash_deduct_updates($od_id);

	
		$this->payroll_other_deduction_automatic_model->automatic_deduction_saves_ne($cutoff,$company_id,$id,$od_id,$effectivity_date,$pay_type,$is_automatic);

		$value = $other_deduction_code->other_deduction_code." (".$other_deduction_code->id.")";

		General::logfile('Other Additions Automatic','UPDATED',$value);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The Deduction, <strong>".$value."</strong> is Successfully Updated!</div>");
		
		
		
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->data['deductiontype_list'] = $this->payroll_other_deduction_automatic_model->deduction_type_list($company_id);
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/save_new_automatic_deductions',$this->data);		
		
	}



//SET AUTOMATIC ADDITION IS _AUTOMATIC TO ZERO=================================================================

 public function is_automatic_to_zero_deduct($company_id,$id,$od_id){

 		$other_deduction_code = $this->payroll_other_deduction_automatic_model->delete_auto($od_id);

		//$this->payroll_other_deduction_automatic_model->is_automatic_to_zero($company_id,$id);
 		$this->db->query("delete from other_deduction_type_automatic where id = ".$id);
		// logfile
		$value = $other_deduction_code->other_deduction_code." (".$other_deduction_code->id.")";

		General::logfile('Other Additions Automatic','DELETED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Deleted!</div>");
		
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->data['deductiontype_list'] = $this->payroll_other_deduction_automatic_model->deduction_type_list($company_id);
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/save_new_automatic_deductions',$this->data);		
 }


//DEACTIVATEandACTIVATE OTHER DEDUCTIONS AUTOMATIC==============================================================
	public function deactivate_deduction_auto(){

		$id = $this->uri->segment("4");
		$other_deduction_code = $this->payroll_other_deduction_automatic_model->delete_lists($id);

		$this->payroll_other_deduction_automatic_model->deactivate_list($id);

		// logfile
		$value = $other_deduction_code->other_deduction_code." (".$other_deduction_code->id.")";

		General::logfile('Other Additions Automatic','DISABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> This Automatic Addition <strong>".$value."</strong> is Successfully Deactivated!</div>");

		redirect(base_url().'app/payroll_other_deduction_emp_enrollment/index',$this->data);
	}

	public function activate_deduction_auto(){

		$id = $this->uri->segment("4");
		$other_deduction_code = $this->payroll_other_deduction_automatic_model->delete_lists($id);

		$this->payroll_other_deduction_automatic_model->activate_list($id);

		// logfile
		$value = $other_deduction_code->other_deduction_code." (".$other_deduction_code->id.")";

		General::logfile('Other Additions Automatic','ENABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Activated!</div>");

		redirect(base_url().'app/payroll_other_deduction_emp_enrollment/index',$this->data);
	}


//SELECT GROUP=======================================================================================================

public function by_group($company_id,$pay_type_id){

			$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/by_group',$this->data);	
		
	}	


//GET PAYROLL PERIOD BY GROUP PAYTYPE=================================================================================
	public function by_employee_filtering_deduct(){	
		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");
		$pay_type_group=$this->uri->segment("6");
		$this->data['pay_per_deduction'] = $this->payroll_other_deduction_automatic_model->payroll_per_per_company_pay_type($company_id,$pay_type,$pay_type_group);
		$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/employee_filtering',$this->data);	
		
	}

public function show_div_dept_deduct(){
		$company_id=$this->uri->segment("4");
		$division_id=$this->uri->segment("5");
		$this->data['get_div_dept'] = $this->general_model->get_company_division_departments($company_id,$division_id);

		$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/show_div_dept',$this->data);
	}	

public function show_section_deduct(){
		$dept_id=$this->uri->segment("4");
		$this->data['get_section'] = $this->general_model->getSec($dept_id);

		$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/show_section',$this->data);
	}	
	
public function clear_fetched_sub_sec_deduct(){

		$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/show_clear_fetched_sub_sec',$this->data);
	}

public function show_sub_section_deduct(){
		$section_id=$this->uri->segment("4");
		$section=$this->uri->segment("4");

		$this->data['check_section'] = $this->general_model->get_the_section($section);
		$this->data['get_sub_section'] = $this->general_model->get_sec_subsection($section_id);
		$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/show_sub_section',$this->data);
	}	



public function generate_employee_automatic_deduct(){

		

		$company_id=$this->input->post('company_id');

		$this->data['company_info'] = $this->general_model->get_company_info($company_id);
		$comp_info = $this->general_model->get_company_info($company_id);
		$comp_division_setting=$comp_info->wDivision;
		
		$id=$this->input->post('pay_period'); // payroll period id

		$pay_type=$this->input->post('pay_type');
		$pay_type_group=$this->input->post('pay_type_group');
	
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
       
		//$this->data['pay_period_info'] = $this->general_model->get_payroll_period($id);
		$this->data['employee'] = $this->payroll_other_deduction_automatic_model->get_deduction_employeeList($company_id,$comp_division_setting,$sub_sec_setting,$pay_type_group);
		$this->data['automatic_enrollment'] = $this->payroll_other_deduction_automatic_model->getDeductionEnrollments();
		$this->data['deduction_type'] = $this->payroll_other_deduction_automatic_model->getDeductionTypes($company_id);
		$this->data['payroll_formula_list'] = $this->payroll_other_deduction_automatic_model->all_formula_by_tier();
		$this->data['formula_list'] = $this->payroll_other_deduction_automatic_model->formula_by_tier();	
		$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/generate_employee_automatic',$this->data);
	}

//SAVING ADDITION EMPLOYEE ENROLLMENT=======================================================================================

function save_deduction_enroll_automatic(){
		$employee_id = $this->input->post('employee_id');
		$company_id= $this->input->post('company_id');
		$pay_period = $this->input->post('pay_period');
		$effective_date = $this->input->post('effective_date');		

		// save data
		$this->payroll_other_deduction_automatic_model->save_deduction_enroll_automatic();
		

		//echo "<script type='text/javascript'>alert('Successfully Added!')/'/'</script>";
		echo "<script>";
		echo "window.close();";
		echo "window.opener.location.reload();";
		echo "</script>";

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> This, <strong>Other Deduction Enrollment</strong>, is Successfully Added!</div>");
		
		$this->session->set_flashdata('onload',"view(".$company_id.")");

		

}

//MANUAL EXCEL UPLOAD FOR AUTOMATIC ADDITION=====================================================================

public function manual_excel_upload_auto($company_id,$od_id,$date_effective,$pay_type,$cutoff){
	
		$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/manual_excel_upload_auto',$this->data);


	}
 public function upload()
    {
    	$numOfEmp 		= 0;
    	$foundError 	= False;
    	
    	$excelEmpName 	= array();
    	$result 		= 0;

    	$fileName = $_FILES['file']['name'];
		$action = $_POST['action'];
		$company = $_POST['company_id'];
		$pt_id = $_POST['pay_type_id'];	

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
	            $forIntformula 	= 'Must be Number. only number is required';
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

				            		if($col==2){
				            			if(!is_numeric($getCellvalue)){
												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.$forIntformula);//Number
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
															setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.'Number and Decimal Only/Characters are not allowed');//doesn't exist
															$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																$foundError = True;
													}
							            		}
							            		
							            		/*if($col == 2){
             
						                     			 $pf_id_checker =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
											             $result_pf_id_checker = $this->payroll_other_deduction_automatic_model->pfidnotexist($pf_id_checker);
											             	if($result_pf_id_checker === false){
											              	$objPHPExcel->getActiveSheet()->
											                setCellValueByColumnAndRow($col, $row,  $pf_id_checker.' -> '.$for_pf);//doesn't exist
											               	$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
											                $foundError = True;
												              }
												           }*/


												//check if employee id exist in database/based on the company id
							            		 if($col == 0 ){
             
						                     			 $emp_id_checker =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
											             $result_emp_id_checker = $this->payroll_other_deduction_automatic_model->empidnotexist($emp_id_checker,$company,$pt_id);
											             	if($result_emp_id_checker === false){
											              	$objPHPExcel->getActiveSheet()->
											                setCellValueByColumnAndRow($col, $row,  $emp_id_checker.' -> '.$company_error.' or employee is not belong to this Paytype Id '.$pt_id);//doesn't exist
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
									              $pay_type  = $this->input->post('pay_type_id');  
									              $od_id = $this->input->post('other_deduction_id');
									              $company_id = $this->input->post('company_id');
									              $cut_off = $this->input->post('cutoff');
								           
								             $dataexist = $this->payroll_other_deduction_automatic_model->check_exist($employee_id,$pay_type,$od_id,$company_id,$cut_off);
							                if($dataexist ==1){
							                	//ECHO "ALREADY EXIST IN THE DATABASE";
							                	$this->db->delete("other_deduction_automatic", array('other_deduction_id' => $od_id, 'employee_id'=>$employee_id,'pay_type' => $pay_type, 'cutoff' => $cut_off));

								                $data = array('employee_id'  			=> $employee_id,
								                				'company_id'  			=> $company_id,
								                				'other_deduction_id' 	=> $od_id,
								                				'open_entry'  			=> $rowData[0][1],
								                				'pay_type'  			=> $pay_type,
								                				'cutoff'  				=> $cut_off,
								                				'payroll_formulas_id'   => $rowData[0][2],
								                				'entry_type'  			=> $this->input->post('entry_type'),
								                				'date_effective'  		=> $this->input->post('date_effectivity'),
								                				'date_added'  			=> date('Y-m-d H:i:s')
								                				
								                			  );
	                							$insert = $this->payroll_other_deduction_automatic_model->insertImport($data);
	            								
	            								}

	            	}//end of insert
			            if($insert){ //file name for successfully imported
				            	$this->data['action']='save';
								$this->data['count_data']=$highestRow - 1;
								$this->data['company']=$company;
								$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/review_upload/template_header',$this->data);
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
									$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/review_upload/template_content',$this->data);
								}
								$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/review_upload/template_footer',$this->data);
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
					header('Content-Disposition: attachment;filename="' ."set_auto_deduction_template_error". '""' .date('Y-m-d')."_".date('H:i:s').".xlsx".'"');
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
					$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/review_upload/template_header',$this->data);
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

							/*if(!is_numeric($col_2)){
								$foundError=True;
								$pf_error='Must be Number. only number is required for Payroll Formula.<br>';
							}
							else{ 
								
								$pf_error='';}*/
						
							$checkvalue = $this->containsDecimal($col_1);
							if($checkvalue === false){
								$foundError = True;
								$decim='Invalid Number/Decimal format<br>';
							} else{ 
								$decim=''; }
							$getemp = $col_0;		
							$employee_companylist =$col_0;
							$resultemployee_companylist = $this->payroll_other_deduction_automatic_model->employee_company_checker_model($employee_companylist,$company,$pt_id);
								if($resultemployee_companylist === false){
									$foundError = True;
									$emp_comp='Employee doesnt exist in company Id '.$company.' or employee is not belong to this Paytype Id '.$pt_id.'<br>';
								} else{  $emp_comp=''; }
							
						/*	$getpf = $col_2;
							$result_pf_id = $this->payroll_other_deduction_automatic_model->pf_id_checker_model($getpf);
							if($result_pf_id === false){
									$foundError = True;
									$pf_id='Payroll Formulas not Exist';
								} else{  $pf_id=''; }*/

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
								
								$this->data['errors']= $null.'<br>'.$emp_comp.'<br>'.$decim.'<br>'.$exist_excel.'<br>'.$pf_error;
							}
							else{
								$this->data['remarks']= 'Ok';
							}
							$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/review_upload/template_content',$this->data);
				}
					$this->load->view('app/payroll/other_deduction_emp_enrollment/automatic_deduction/review_upload/template_footer',$this->data);
					unlink($inputFileName);		
			}//end of upload has imported a file
		}
		else{
			echo "<script>alert('Error report to technical support')</script>";
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

	}

function containsDecimal( $value ) {

	if ( strpos( $value, "." ) !== false ||  is_numeric($value) !==false) {
	        return true;
	    }
	    return false;
	}


}//controller



































/*public function save_add_new_addition_automatic()
   {
   		$addition_id = $this->input->post('addition_id');
		$company_id= $this->input->post('company_id');
		$this->form_validation->set_rules("addition_id","Set Automatic Addition","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		
		if($this->form_validation->run()){

			$id = $this->input->post('additon_id');

			// modify data
			$this->payroll_other_addition_automatic_model->automatic_additon_save($id);

			// logfile
			$company_id=$company_id;
			$value = $addition_id;
			General::logfile('This','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The row, <strong>".$value."</strong>, is Successfully Added!</div>");

			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/Payroll_other_addition_automatic/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		

	}

	public function validate_save_addition_automatic(){
		 $id = $this->input->post('addition_id');
		 $value = $this->input->post('additon_id');
		 $company_id =$this->input->post('company_id');	
		if($this->payroll_other_addition_automatic_model->validate_save_addition_automatic($id)){
			$this->form_validation->set_message("validate_save_addition_automatic"," Other Addiition Automatic, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}*/
