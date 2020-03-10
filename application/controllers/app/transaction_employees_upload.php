<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class transaction_employees_upload extends General{

	function __construct(){
		parent::__construct();	
		
		$this->load->model("app/payroll_emp_loan_enrolment_model");
		$this->load->model("app/transaction_employees_model");
		$this->load->model("general_model");
		$this->load->model("app/employee_model");
		$this->load->library("excel");
		$this->load->dbforge();

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	public function upload_atro(){
		//echo "test gel";
		$numOfEmp 		= 0;
    	$foundError 	= False;
    	$excelEmpID 	= array();
    	$result 		= 0;

    	$fileName = $_FILES['file']['name'];
		$action = $_POST['action'];
		$add_edit = $_POST['add_edit'];

		$config['upload_path'] 		= './public/import_template/'; 
	    $config['file_name'] 		= $fileName;
	    $config['allowed_types'] 	= 'xlsx|xls';
	    $config['max_size'] 		= 10000;
	    $config['overwrite'] 		= TRUE;

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

					$this->load->view('app/transaction/review_upload/template_header',$this->data);
					for ($roww = 2; $roww <= $highestRow; $roww++)
						{
								$this->data['emp_id'] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $roww)->getValue();
								$this->data['ot_date'] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $roww)->getValue();
								$this->data['ot_hrs'] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $roww)->getValue();
								$emp_id = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $roww)->getValue();
								$ot_date = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $roww)->getValue();
								$ot_hrs = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $roww)->getValue();

								if($ot_hrs>0){
									if($action=="Save"){
										

										$query = $this->db->query("DELETE FROM emp_atro WHERE employee_id='".$emp_id."' AND atro_date='".$ot_date."' ");
										$saveOT = array(
											'doc_no'		=> 'HR008-'.$emp_id.$ot_date.date('YmdHis'),
											'employee_id'	=> $emp_id,
											'atro_date'		=>	$ot_date,
											'no_of_hours'	=> $ot_hrs,
											'date_created'	=>	date('Y-m-d'),
											'status'		=>	'approved',
											'filed_by'		=>	$this->session->userdata('username'),
											'atro_conversion'		=>	'with_pay',
											'InActive'		=>	'0',
											'entry_type'	=>	'manual_upload'
											);

										$this->transaction_employees_model->saveManualOt($saveOT);
										
										$this->data['remarks']="save mode";
									}else{
										$this->data['remarks']="review mode";
									}
									
																
									$this->load->view('app/transaction/review_upload/template_content',$this->data);
								}else{

								}
								
						}


	    	}
	   		catch(Exception $e) {
	   		 	echo "<script>alert('Invalid file format.Please use the template')</script>";
				echo " <script type='text/javascript'>
					    open(location, '_self').close();
					</script>";  
	   		}



	
	}

	public function manual_upload_forms(){//gel
		$template=$this->input->post('template');
		$action=$this->input->post('action');

		if($template == 'per_hour_leave_template')
		{
			$this->per_hour_leave_filing_upload($template,$action);
		}
		else
		{
							if(isset($_POST["import"]))
						    {
								$fileName = $_FILES['file']['name'];
								//unlink( './public/import_template/'.$fileName);//overwrite if file name already exist.
									$file_pointer = './public/import_template/'.$fileName; 
									  
									if (file_exists($file_pointer))  
									{ 
									  	unlink( './public/import_template/'.$fileName);//overwrite if file name already exist. 
									} 
									else 
									{ 

									}
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

						        	try {

						                $inputFileType 	= IOFactory::identify($inputFileName);
						                $objReader 		= IOFactory::createReader($inputFileType);
						                $objPHPExcel 	= $objReader->load($inputFileName);
						           
						            } catch(Exception $e) {
						            	unlink($inputFileName);
						                $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Error file type/file name. Allowed file type: .xlsx/.xls </div>");
										redirect('app/transaction_employees');
						            }

						            $objPHPExcel->setActiveSheetIndex(0);
									$sheet 			= $objPHPExcel->getSheet(0);
						            $highestRow 	= $sheet->getHighestRow();
						            $highestColumn 	= $sheet->getHighestColumn();
						            $colNumber 		= PHPExcel_Cell::columnIndexFromString($highestColumn);

						            $row_error_message	='';
					if($template=="employee_leave_form_template"){
									echo '
									<table style="width:100%;" border="1">
									<thead>
										<tr>
											<th colspan="11" style="color:#ff0000;">Note: This template is for manual uploading of automatic approved and with pay leave used only.</th>
										</tr>
										<tr>
											<th>Employee ID</th>
											<th>Leave Date From</th>
											<th>Leave Date To</th>
											<th>No of Days Leave</th>
											<th>Leave Type</th>
											<th>Address While on Leave</th>
											<th>Is Halfday Leave?</th>
											<th>Reason</th>
											<th>Remarks</th>
											<th>Action</th>
											<th>Action Result</th>
										</tr>
									</thead>
									<tbody>
									';	  

								     for ($row = 2; $row <= $highestRow; $row++){
								     	$colLetter 			= 'A';

								     	$employee_id 		= '';
										$date_from 			='';
										$date_to		= '';
										$leave_type_id 			= '';
										$address 			= '';
										$is_halfday 			= '';
										$reason 			= '';
										$row_error_message 			= '';

								     	for($col = 0; $col < $colNumber; $col++){
							            	$colrow = $colLetter.(string)$row;    
										    $getCellvalue = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();					    
						if($col=="0"){
							$employee_id=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
						}elseif($col=="1"){
							$date_from=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
						}elseif($col=="2"){
							$date_to=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
						}elseif($col=="3"){
							$leave_type_id=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
						}elseif($col=="4"){
							$address=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
						}elseif($col=="5"){
							$is_halfday=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
						}elseif($col=="6"){
							$reason=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
						}else{
						}
										    $colLetter++;
										}// col array



						// ======= verify employee id
						$checkEmp=$this->transaction_employees_model->checkEmp($employee_id);
						if(!empty($checkEmp)){
							$company_id=$checkEmp->company_id;
						}else{
							$company_id=0;
							$row_error_message="Employee does not exist";
						}

						$checkLeave=$this->transaction_employees_model->check_emp_leave($company_id,$leave_type_id);
						if(!empty($checkLeave)){
							$leave_type_name=$checkLeave->leave_type;
						}else{
							$checkDefLeave=$this->transaction_employees_model->check_DefLeave($company_id,$leave_type_id);
							if(!empty($checkDefLeave)){	
									$leave_type_name=$checkDefLeave->leave_type;
							}else{
								$row_error_message="Leave Type does not exit: <br>Check it at Administrator>Leave Type";
								$leave_type_name="Leave Type Not Exist";
							}	

						}



					if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date_to)) {// tama yung format ng date to
								if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date_from)) {//tama format ng date to
								} else {//mali format ng date from
									$row_error_message="Invalid Date From OR Date To";
								}
					} else {//mali format ng date to
					    $row_error_message="Invalid Date From OR Date To";

					}

					if($row_error_message=="Invalid Date From OR Date To"){
					}else{
						if($date_from>$date_to){
							$row_error_message="Invalid Date From OR Date To";
						}else{

						}   

					}

					if($is_halfday==""){
						$row_error_message="You seem uploading an OT template, check the template type you choose Or you did not input leave day type";
					}else{

					}

					if($is_halfday=="no"){
						$credit_ded_type=1;
					}elseif($is_halfday=="yes"){
						$credit_ded_type=0.5;
					}else{
						$credit_ded_type=1;
					}

					$earlier = new DateTime($date_from);
					$later = new DateTime($date_to);

					$diff = $later->diff($earlier)->format("%a");
					if($diff>=0){
					$diff=$diff+1;
					}else{

					}

					$doc_no="HR002_".$employee_id."_manual".$date_from.$date_to.'_'.$leave_type_id;

					if($action=="Save"){

						if($row_error_message==""){
										$query = $this->db->query("DELETE FROM employee_leave WHERE employee_id='".$employee_id."' AND from_date='".$date_from."' AND to_date='".$date_to ."' AND leave_type_id='".$leave_type_id."' AND entry_type='manual upload' ");

										$leaveTemplate = array(
											'employee_id'	=>	$employee_id,
											'doc_no'	=> $doc_no,
											'leave_type_id'	=> $leave_type_id,
											'address'	=> $address,
											'from_date'	=> $date_from,
											'to_date'	=> $date_to,
											'no_of_days'	=> $credit_ded_type,
											'days'	=> $diff,
											'status'	=> 'approved',
											'reason'	=> $reason,
											'date_created'	=> date('Y-m-d'),
											'IsDeleted'	=> '0',
											'remarks'	=> '',
											'InActive'	=> '0',
											'with_pay'	=> '1',// in manual uploading of excel admin account : all leave is with pay so they must upload leave with pay only.
											'status_update_date'	=> date('Y-m-d H:i:s'),
											'entry_type'	=> 'manual upload',
											'company_id'	=> $company_id,
											'file_attached'	=> '',
											'late_filing'	=> '',
											'late_filing_type'	=> ''
										);


										$insert = $this->transaction_employees_model->insert_leavetype_manualupload($leaveTemplate);
										if($insert=='inserted')
										{
											$success=$insert;
										}

										$df_del=$date_from;
										$dt_del=$date_to;

										$df=$date_from;
										$dt=$date_to;


										while (strtotime($df_del) <= strtotime($dt_del)) {
											$tm=substr($df_del, 5, 2);
											$td=substr($df_del, 8, 2);
											$ty=substr($df_del, 0, -6);
											$query = $this->db->query("DELETE FROM employee_leave_days WHERE employee_id='".$employee_id."' AND the_date='".$df_del."' AND doc_no='".$doc_no."'");

											$df_del = date ("Y-m-d", strtotime("+1 day", strtotime($df_del)));
										}

										
										while (strtotime($df) <= strtotime($dt)) {
											$tm=substr($df, 5, 2);
											$td=substr($df, 8, 2);
											$ty=substr($df, 0, -6);

											$leave_date = array(
												'doc_no'		=>	$doc_no,//'HR002_'.$employee_id.date('H:i'),
												'the_date'		=>	$df,
												'employee_id'	=>	$employee_id,
												'the_month'		=>	$tm,
												'the_day'		=>	$td,
												'the_year'		=>	$ty
												);
											//echo "$df <br>";
											$this->transaction_employees_model->insert_leave_date($leave_date);

									 		$df = date ("Y-m-d", strtotime("+1 day", strtotime($df)));
									 		
										}
										$action_result="Saved";
						}else{// dont insert if may error message
							$action_result="Not Saved Check Remarks";
						}




					}else{
						$action_result="Review Mode";
					}

					if($row_error_message!=""){
						$warning_hylight='style="background-color:#ff0000;color:#fff;font-weight:bold;"';
					}else{
						$warning_hylight='';
					}

					echo '
						<td>'.$employee_id.'</td>
						<td>'.$date_from.'</td>
						<td>'.$date_to.'</td>
						<td>'.$diff.'</td>
						<td>'.$leave_type_name.'</td>
						<td>'.$address.'</td>
						<td>'.$is_halfday.'</td>
						<td>'.$reason.'</td>
						<td>'.$row_error_message.'</td>
						<td>'.$action.' Mode </td>
						<td>'.$credit_ded_type.'</td>
						</tr>
					';


									}//row array
					echo '
					</tbody>
					</table>

					';

					}elseif($template=="employee_atro_form_template"){

									echo '
									<table style="width:100%;" border="1">
									<thead>
										<tr>
											<th colspan="11" style="color:#ff0000;">Note: This template is for manual uploading of automatic approved and cash entitled overtime.</th>
										</tr>
										<tr>
											<th>Employee ID</th>
											<th>Name</th>
											<th>Overtime Date</th>
											<th>No Of Hours</th>
											<th>Work to be accomplish/accomplished</th>
											<th>Remarks</th>
											<th>Action</th>
											<th>Action Result</th>
										</tr>
									</thead>
									<tbody>
									';	  


								     for ($row = 2; $row <= $highestRow; $row++){
								     	$colLetter 			= 'A';

								     	$name ='';
										$row_error_message 			= '';
										$leave_spec1='';
										$leave_spec2='';

								     	for($col = 0; $col < $colNumber; $col++){
							            	$colrow = $colLetter.(string)$row;    
										    $getCellvalue = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();					    
						if($col=="0"){
							$employee_id=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
						}elseif($col=="1"){
							//$date_from=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
						}elseif($col=="2"){
							$atro_date=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
						}elseif($col=="3"){
							$no_of_hours=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
						}elseif($col=="4"){
							$reason=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
						}elseif($col=="5"){
							$leave_spec1=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
						}elseif($col=="6"){
							$leave_spec2=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
						}else{
						}
										    $colLetter++;
										}// col array


										// ======= start echo rows
						// ======= verify employee id
						$checkEmp=$this->transaction_employees_model->checkEmp($employee_id);
						if(!empty($checkEmp)){
							$company_id=$checkEmp->company_id;
							$name=$checkEmp->name_lname_first;
						}else{
							$row_error_message="Employee does not exist";
						}

						if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$atro_date)) {// tama yung format ng atro date
						} else {//mali format ng atro date
						    $row_error_message="Invalid OT Date";

						}

						if($no_of_hours>0){
							$no_of_hours=round($no_of_hours, 2);
						}else{
							$row_error_message="Invalid OT Hours";
						}

						if($leave_spec1!=""){
							$row_error_message="You seem uploading a Leave template, check the template type you choose";
						}else{

						}

						if($action=="Save"){
							if($row_error_message==""){

						$doc_no="HR008_".$employee_id."_manual".$atro_date.$no_of_hours;
						$query = $this->db->query("DELETE FROM emp_atro WHERE employee_id='".$employee_id."' AND atro_date='".$atro_date."' AND entry_type='manual upload' ");

								$atro_array = array(
									'employee_id'	=>	$employee_id,
									'company_id'	=>	$company_id,
									'doc_no'	=>	$doc_no,
									'atro_conversion'	=>	'with_pay',
									'atro_date'	=>	$atro_date,
									'filed_by'	=>	$this->session->userdata('username'),
									'no_of_hours'	=>	$no_of_hours,
									'reason'	=>	$reason,
									'date_created'	=>	date('Y-m-d'),
									'status'	=>	'approved',
									'InActive'	=>	'0',
									'entry_type'	=>	'manual upload',
									'IsDeleted'	=>	'0'
								);
								$this->transaction_employees_model->saveManualOt($atro_array);
								$action_result="Saved";
							}else{
								$action_result="Not Save check remarks.";

							}
						}else{
							$action_result="$action";
						}

					if($row_error_message!=""){
						$warning_hylight='style="background-color:#ff0000;color:#fff;font-weight:bold;"';
					}else{
						$warning_hylight='';
					}



						echo '
							<tr>
								<td>'.$employee_id.'</td>
								<td>'.$name.'</td>
								<td>'.$atro_date.'</td>
								<td>'.$no_of_hours.'</td>
								<td>'.$reason.'</td>
								<td '.$warning_hylight.'>'.$row_error_message.'</td>
								<td>'.$action.' Mode</td>
								<td>'.$action_result.'</td>
							</tr>
							';



									}// row array



					}else{

					}


			}//if import end

		}

	}





	public function upload_leavetype()
	{
		$chosen_template=$this->input->post('template');

		if($chosen_template=="employee_atro_form_template"){
			$this->upload_atro();

		}else{

		$numOfEmp 		= 0;
    	$foundError 	= False;
    	$excelEmpID 	= array();
    	$result 		= 0;

    	$fileName = $_FILES['file']['name'];
		$action = $_POST['action'];
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
								    		if($col == 0 || $col == 1 || $col == 2 || $col == 3 || $col == 4 || $col == 5 || $col == 6){ // for null
											$objPHPExcel->getActiveSheet()->
											setCellValueByColumnAndRow($col, $row,  'Value cannot be Null');
											$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
											}
						            	}
			            				else{//If not Null

						            		if($col==0){
						            			$excelEmpID[] = $getCellvalue; // pass the value to array $excelEmpID[]
						            			if ($getCellvalue{0}=="0") { // empID that start with zero
													$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '. 'Employee should not start with 0');//start zero
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignmdent()->setWrapText(true);
													$foundError = True;
												}
						            		}
						            		if($col==0){
						            			if(!is_numeric($getCellvalue)){
													$objPHPExcel->getActiveSheet()->
													setCellValueByColumnAndRow($col, $row, $getCellvalue.' -> '.'Must be Number.');//Number
													$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
												}
						            		}

						            		
											 if($col==2 )
								            		{
														$datefrom =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
										            	$dateto =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();	
															if($datefrom < $dateto || $datefrom == $dateto){}
															else{
																$objPHPExcel->getActiveSheet()->
																setCellValueByColumnAndRow($col, $row,  $dateto.' -> '.'Date to here must be greater than the from date');
																$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																$foundError = True;
															}
								            		}
											if($col==5)
									        {
									            	$yes_no_value =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
													$checker_value = $this->validateyes_no($yes_no_value);
													//echo '<br>'.$new_date;
													//echo '<br>'.date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($new_date));
													if($checker_value === false){
													$objPHPExcel->getActiveSheet()->
													setCellValueByColumnAndRow($col, $row,  $yes_no_value.' -> '.'Invalid value. Yes or No only');//doesn't exist
													$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
												}
									        }
									        if($col==3)
									        	{
											            $employee_id =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
														$check_employee = $this->transaction_employees_model->checker_employee_exist($employee_id);
														$leave_type = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
														$check_leavetype = $this->transaction_employees_model->checker_leavetype_exist($leave_type,$check_employee);
															
															if($check_leavetype === 'false')
																	 	{
																	 		 
																	 		$objPHPExcel->getActiveSheet()->
																			setCellValueByColumnAndRow($col, $row,$leave_type.' -> '.'Invalid Leave Type');//doesn't exist
																			$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																			$foundError = True;
																	 	}
									        	}
											if($add_edit=='new')
											{
												if($col==1)
								            		{
								            			$employee =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
								            			$emp_last_leavedate = $this->transaction_employees_model->employee_last_leavedate($employee);
								            			$from_date =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
								            			if($emp_last_leavedate === 'no_data'){}
								            			else{
															if($emp_last_leavedate === $from_date)
																	{
																		
																		$objPHPExcel->getActiveSheet()->
																		setCellValueByColumnAndRow($col, $row,  $from_date.' -> '.'Employee Leave date already exists');
																		$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																		$foundError = True;
																	}
															}
								            			}

												if($col==1 )
										        {
										        	$date =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
										        	$current_date = date('Y-m-d');
													if($date < $current_date)
														{
															$objPHPExcel->getActiveSheet()->
															setCellValueByColumnAndRow(1, $row,  $date.' -> '.'Date from here must be greater than the current date');
															$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
															$foundError = True;
														}
										        }
										       	if($col==0){
								            		$employee_id =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
													$check_employee = $this->transaction_employees_model->checker_employee_exist($employee_id);
																if($check_employee === null || $check_employee === ''){
																	$objPHPExcel->getActiveSheet()->
																		setCellValueByColumnAndRow($col, $row,  $employee_id.' -> '.'Employee ID doesnt exist in employee list');//doesn't exist
																			$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																			$foundError = True;	
																}
													}
											}
											else{
												 if($col==3)
									        	{
											            $employee_id =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
														$check_employee = $this->transaction_employees_model->checker_employee_exist($employee_id);
														$leave_type = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
														$check_leavetype = $this->transaction_employees_model->checker_leavetype_exist($leave_type,$check_employee);
															
															if($check_leavetype === 'false')
																	 	{
																	 		 
																	 		$objPHPExcel->getActiveSheet()->
																			setCellValueByColumnAndRow($col, $row,$leave_type.' -> '.'Invalid Leave Type');//doesn't exist
																			$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																			$foundError = True;
																	 	}
									        	}
												if($col==0){
														
									            		$employee_leavetype =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
									            		$from =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
									            		$to =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
														$resultemployee_max = $this->transaction_employees_model->employee_max_leavetype($employee_leavetype,$from,$to);
														if($resultemployee_max === 0){
															$objPHPExcel->getActiveSheet()->
																setCellValueByColumnAndRow($col, $row,  $employee_leavetype.' -> '.'No existing data for Employee '.$employee_leavetype." dated " .$from ." to "." ".$to);//doesn't exist
																$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																	$foundError = True;

																}
															}
												
											}
						           		}
		         						$colLetter++;// increment A
									}//end of col for loop
			         		}//end of row for loop
			        		
		         			 
					        if($foundError==False)
					        { // insert to employee_info table
					        	for ($row = 2; $row <= $highestRow; $row++)
					        	{	
					        		$numOfEmp++;                                  
								    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL,TRUE,FALSE);
		                			$date_created 	= date('Y-m-d H:i:s');

								               
								               if($rowData[0][5] == 'Yes' || $rowData[0][5] == 'yes')
								               {
								               		$days = '0.5';
								               }
								               else{
								               		$days = '1';
								               }
								                $employee_id= $rowData[0][0];
								                $from= $rowData[0][1];
								                $to= $rowData[0][2];
$earlier = new DateTime($from);
$later = new DateTime($to);

$daysno = $later->diff($earlier)->format("%a");								               
$daysno=$daysno+1;
$docno='HR002_'.$employee_id.date('H:i');

								                $company_id = $this->transaction_employees_model->checker_employee_exist($employee_id);
								                $data = array(
								                				'employee_id'  	=> $rowData[0][0],
								                				'doc_no'  	=> $docno,
								                				'from_date'  	=> $rowData[0][1],
								                				'to_date'  		=> $rowData[0][2],
								                				'leave_type_id' => $rowData[0][3],
								                				'address'  		=> $rowData[0][4],
								                				'no_of_days'	=> $days,
								                				'days'	=> $daysno,
								                				'reason' 		=> $rowData[0][6],
								                				'status' 		=> 'approved',
								                				'date_created' 	=> date('Y-m-d H:i:s'),
								                				'IsDeleted' 	=> 0,
								                				'remarks' 	=> 'this is manual upload',
								                				'InActive' 	=> 0,
								                				'with_pay' 	=> 1,
								                				'entry_type' =>'manual upload',
								                				'company_id' 	=> $company_id
								                			);


			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			$log_value=$docno."/".$rowData[0][0].$rowData[0][1].$rowData[0][2]."/".$rowData[0][3]."/".$days."entry_type";
			General::system_audit_trail('Transaction','Transaction Management','logfile_transaction','manual upload leave ,','INSERT',$log_value);

			

// ==========
							                
	while (strtotime($from) <= strtotime($to)) {
		$tm=substr($from, 5, 2);
		$td=substr($from, 8, 2);
		$ty=substr($from, 0, -6);

		$leave_date = array(
			'doc_no'		=>	$docno,//'HR002_'.$employee_id.date('H:i'),
			'the_date'		=>	$from,
			'employee_id'	=>	$rowData[0][0],
			'the_month'		=>	$tm,
			'the_day'		=>	$td,
			'the_year'		=>	$ty
			);
		//echo "$from <br>";
		$this->transaction_employees_model->insert_leave_date($leave_date);

 		$from = date ("Y-m-d", strtotime("+1 day", strtotime($from)));
 		
	}

// ==========





								                if($add_edit=='edit')
								                {
													$update = $this->transaction_employees_model->update_leavetype_manualupload($data,$employee_id,$from,$to);
													if($update=='updated')
													{
														$success=$update;
													}
								                }
								                else{
	                								$insert = $this->transaction_employees_model->insert_leavetype_manualupload($data);
	                								if($insert=='inserted')
													{
														$success=$insert;
													}

													//


													//

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
										$this->load->view('app/transaction/review_upload/template_header',$this->data);
										for ($row = 2; $row <= $highestRow; $row++){
											$this->data['col_0']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
											$this->data['col_1']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
											$this->data['col_2']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
											$this->data['col_3']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
											$this->data['col_4']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
											$this->data['col_5']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
											$this->data['col_6']= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $row)->getValue();
											$this->load->view('app/transaction/review_upload/template_content',$this->data);
										}
										$this->load->view('app/transaction/review_upload/template_footer',$this->data);
									     $dt = $date_array = getdate();
									     $formated_date  = "payroll_compensation_salary_information";
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
									header('Content-Disposition: attachment;filename="' ."employee_leave_error". '""' .date('Y-m-d')."_".date('H:i:s').".xlsx".'"');
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
					$this->load->view('app/transaction/review_upload/template_header',$this->data);
					for ($row = 2; $row <= $highestRow; $row++)
						{
								$col_0 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
								$col_1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
								$col_2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
								$col_3 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
								$col_4 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
								$col_5 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
								$col_6 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $row)->getValue();

								if(empty($col_0) || empty($col_1) || empty($col_2) || empty($col_3) || empty($col_4) || empty($col_5) || empty($col_6) ){
								$foundError=True; $null='Check empty fileds<br>';
								}
								else{ $foundError=False; $null=''; }
								
								$check = $this->validateDate($col_1);
								$check1 = $this->validateDate($col_2);
								if($check === false || $check1 === false){
									$foundError = True;
									$date_res ='Invalid Date<br>';
								} else{ $foundError = False; $date_res ='';}

								$datefrom =$col_1;
								$dateto =$col_2;
								if($datefrom < $dateto || $datefrom == $dateto){ $foundError = False; $dateres_to=''; }
								else{ $foundError = True; $dateres_to='Date to must be greater than the date from<br>'; }

								$yes_no_value =$col_5;
								$checker_value = $this->validateyes_no($yes_no_value);
								if($checker_value === false){
									$foundError = True;
									$yesno='Invalid Yes or No.<br>';
								} else{ $foundError = False; $yesno='';}

									$employee_id =$col_0;
									$check_employee = $this->transaction_employees_model->checker_employee_exist($employee_id);
									$leave_type = $col_3;
									$check_leavetype = $this->transaction_employees_model->checker_leavetype_exist($leave_type,$check_employee);
										if($check_leavetype == 'false')
											{
												$foundError = True;
												$paytype_res=$leave_type.'Invalid Pay type ID<br>';
											} else { $foundError = False;
												$paytype_res=''; }

								if($add_edit=='new')
									{
										$employee =$col_0;
								        $emp_last_leavedate = $this->transaction_employees_model->employee_last_leavedate($employee);
								        $from_date =$col_1;
								            if($emp_last_leavedate === 'no_data'){ $empleave_exist='';}
								            	else{ 
								            		if($emp_last_leavedate === $from_date)
														{ $foundError = True; $empleave_exist='Employee leave Exist';} else{ $empleave_exist=''; }
													}

											$date =$col_1;
										    $current_date = date('Y-m-d');
											if($date < $current_date)
												{ $foundError = True; $date_currentdate='Date from must be greater than the current date<br>'; }
											else{ $date_currentdate=""; }

											$employee_id =$col_0;
											$check_employee = $this->transaction_employees_model->checker_employee_exist($employee_id);
												if($check_employee === null || $check_employee === ''){ $foundError = True; $compemp='Employee ID doesnt exist in employee list<br>'.$check_employee;	}
												else{ $compemp="";}
								    }
								else{
									
										$employee_leavetype =$col_0;
									    $from =$col_1;
									    $to =$col_2;
										$resultemployee_max = $this->transaction_employees_model->employee_max_leavetype($employee_leavetype,$from,$to);
										if($resultemployee_max === 0){
												$foundError = True; $empexist_res='No existing data for employee id '.$col_0."<br>";
											}	else{ $empexist_res=''; }
									}
								//for compare excel employee_id
									if($add_edit=='new'){
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
									$exist_Ex='Duplicate Employee ID in excel<br>'; } else{ $exist_Ex=""; }
									}
									$exist_excel=$exist_Ex;
								}
								}

								$this->data['col_0']= $col_0;
								$this->data['col_1']= $col_1;
								$this->data['col_2']= $col_2;
								$this->data['col_3']= $col_3;
								$this->data['col_4']= $col_4;
								$this->data['col_5']= $col_5;
								$this->data['col_6']= $col_6;
								
								if($foundError==True)
								{
									$this->data['remarks']= 'Error';
									if($add_edit=='new')
										{ $this->data['errors'] = $null.$date_res.$dateres_to.$yesno.$paytype_res.$empleave_exist.$date_currentdate.$compemp.$exist_excel;  }
									else
										{ $this->data['errors'] = $null.$date_res.$dateres_to.$yesno.$paytype_res.$empexist_res;   }
								}
								else{
									$this->data['remarks']= 'Ok';
								}
								$this->load->view('app/transaction/review_upload/template_content',$this->data);
						}
						$this->load->view('app/transaction/review_upload/template_footer',$this->data);
						unlink($inputFileName);	
				}
				//end preview or insert
		}
		//if submit name !=import
		else
		{
			echo "Please contact the technical support for errors!.";
		}
		} 
	   	catch(Exception $e) {
	   		 echo "<script>alert('Invalid file format.Please use the template')</script>";
			echo " <script type='text/javascript'>
					    open(location, '_self').close();
					</script>";  
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

	public function validateyes_no($yes_no_value)
	{
		if($yes_no_value == 'Yes' || $yes_no_value == 'yes' || $yes_no_value == 'YES')
		{
			return true;
		}
		elseif($yes_no_value == 'No' || $yes_no_value == 'no' || $yes_no_value == 'NO')
		{
			return true;
		}
		else{
			return false;
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
		
	//per hour leave uploading

	public function per_hour_leave_filing_upload($template,$action)
	{
			$fileName = $_FILES['file']['name'];
			//unlink( './public/import_template/'.$fileName);//overwrite if file name already exist.
			$file_pointer = './public/import_template/'.$fileName; 
							  
			if (file_exists($file_pointer))  
			{ 
				unlink( './public/import_template/'.$fileName);//overwrite if file name already exist. 
			} 
			else { }
			
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

			try {

				$inputFileType 	= IOFactory::identify($inputFileName);
				$objReader 		= IOFactory::createReader($inputFileType);
				$objPHPExcel 	= $objReader->load($inputFileName);
				           
			} catch(Exception $e) {

				unlink($inputFileName);
				$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Error file type/file name. Allowed file type: .xlsx/.xls </div>");
				redirect('app/transaction_employees');
			}

			$objPHPExcel->setActiveSheetIndex(0);
			$sheet 			= $objPHPExcel->getSheet(0);
			$highestRow 	= $sheet->getHighestRow();
			$highestColumn 	= $sheet->getHighestColumn();
			$colNumber 		= PHPExcel_Cell::columnIndexFromString($highestColumn);

			$row_error_message	='';

				echo '
					<table style="width:100%;" border="1">
						<thead>
							<tr>
								<th colspan="11" style="color:#ff0000;">Note: This template is for manual uploading of automatic approved and with pay leave used only.</th>
							</tr>
							<tr style="text-align:center;">
								<th>EmployeeID</th>
								<th>Leave Date</th>
								<th>Leave Type</th>
								<th>Hours</th>
								<th>Minutes</th>
								<th>Computed Leave <br>[system generated]</th>
								<th>Total Deduction <br>[system generated]</th>
								<th>Address <br> [While on Leave]</th>
								<th>Reason</th>
								<th>Remarks</th>
								<th>Action</th>
								<th>Action Result</th>
							</tr>
						</thead>
						<tbody>';	  

							for ($row = 2; $row <= $highestRow; $row++){
								$colLetter 			= 'A';
								$employee_id 		= '';
								$date 				='';
								$hours 				='';
								$minutes 			='';
								$leave_type_id 		= '';
								$address 			= '';
								$reason 			= '';

							for($col = 0; $col < $colNumber; $col++){
								$colrow = $colLetter.(string)$row;    
								$getCellvalue = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();					    
							
								if($col=="0"){
									$employee_id=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
								}elseif($col=="1"){
									$date=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
								}elseif($col=="2"){
									$leave_type_id=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
								}elseif($col=="3"){
									$hours=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
								}elseif($col=="4"){
									$minutes=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
								}elseif($col=="5"){
									$address=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
								}elseif($col=="6"){
									$reason=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
								}else{
								}
								$colLetter++;
							} 
								$employee_checker=$this->transaction_employees_model->checkEmp($employee_id);
								if(!empty($employee_checker)){
										$company_id=$employee_checker->company_id;
									}else{
										$company_id=0;
									}
								$date_checker = $this->validateDate($date);
								$leavetype_checker = $this->transaction_employees_model->check_emp_leave($leave_type_id,$company_id);
							?>
							
						
						<tr style="text-align: center;">
							<td><?php echo $employee_id;?></td>
							<td><?php echo $date;?></td>
							<td>
								<?php 
										echo '<center>'.$leave_type_id.'</center>'; 
										$leave_type_name = $this->transaction_employees_model->check_DefLeave($company_id,$leave_type_id);
										if(!empty($leave_type_name)){ echo '<br><center>[ '.$leave_type_name->leave_type.' ]</center>'; }
								?>
							</td>
							<td><?php echo $hours;?></td>
							<td><?php echo $minutes;?></td>
							<td>
								<?php 

									$hrs= $hours * 60;
									$computed = $hrs + $minutes;
									$final_compted = $computed / 60;
									echo $final_compted;

								?>
							</td>
							<td>
								<?php 

									echo $total_per_hour_deduction = $final_compted / 8;
								?>

							</td>
							<td><?php echo $address;?></td>
							<td><?php echo $reason;?></td>
							<td>
								<?php 
									
									if(!empty($employee_checker)){
										$company_id=$employee_checker->company_id;
										$error_employee="";
									}else{
										$company_id=0;
										$error_employee="Employee does not exist<br>";
									}

									
									if($date_checker === false){
										$error_date ='Invalid Date<br>';
									} else{ $error_date ='';}

									
									if($leavetype_checker === false){
										$error_leavetype ='Invalid Leave Type<br>';
									} else{ $error_leavetype ='';}

									if(empty($hours) && empty($minutes))
									{
										$empty_checker="Filed Per hour is required<br>";
									}
									else { $empty_checker=""; }

									if(!empty($hours))
									{
										if (floor($hours) == $hours  AND is_numeric($hours))
										{ $hours_checker =""; }
										else
										{
											$hours_checker='Invalid hours Format<br>';
										}
									} else{ $hours_checker =""; }

									if(!empty($minutes))
									{
										if (floor($minutes) == $minutes AND is_numeric($minutes))
										{ $minutes_checker ="";  }
										else
										{
											$minutes_checker='Invalid minutes Format<br>';
										}
									} else{ $minutes_checker=""; }


									$filedLeave_checker = $this->transaction_employees_model->employee_leave_per_hour_checker($employee_id,$date);
									if(!empty($filedLeave_checker) || count($filedLeave_checker)>0)
									{
										foreach($filedLeave_checker as $sc)
										{
											echo $error_filedLeave ='<a href="'.base_url().'app/transaction_employees/form_view/'.$sc->doc_no.'/employee_leave/HR002" target="_blank">'.$sc->doc_no.'</a>'.'<br>';
										}	
									}
									
									if(!empty($error_employee) || !empty($error_date) || !empty($error_leavetype) || !empty($empty_checker) || !empty($hours_checker) || !empty($minutes_checker))
									{
										echo '<n style="color:red;">'.$error_employee.$error_date.$error_leavetype.$empty_checker.$hours_checker.$minutes_checker.'</n>';
									}
									else {}
									
							    ?>

							</td>
							<td><?php echo $action;?></td>
							<td>
								<?php 
									if($action=='Review')
									{
										echo $action;
									}
									else
									{
										if(empty($error_employee) AND empty($error_date) AND empty($error_leavetype) AND empty($empty_checker) AND empty($hours_checker) AND empty($minutes_checker))
										{
											
											$save_per_hour_leave = $this->transaction_employees_model->save_per_hour_leave_filing($employee_id,$company_id,$date,$leave_type_id,$hours,$minutes,$reason,$address);
											if(!empty($save_per_hour_leave) AND $save_per_hour_leave=='saved')
											{ 
												echo '<n style="color:green;">saved</n>'; 
											}
											else
											{
												echo '<n style="color:red;">Error</n>'; 
											}
										}
										else 
										{ 
											echo '<n style="color:red;">Error</n>';
										}
									}
								?>
							</td>
						</tr> 

						<?php } 

					echo '</tbody>
				</table>';
		}										
}