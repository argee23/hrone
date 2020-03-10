<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 
	
class payroll_emp_loan_enrolment extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/payroll_emp_loan_enrolment_model");
		$this->load->model("app/employee_model");
		$this->load->model("app/plot_schedules_model");
		$this->load->model("app/payroll_yearly_annual_tax_exemption_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}

	//index
	public function index(){	
		$this->payroll_emploan_enrolment_home();	
	}

	//home/company list/all employees applied in loans
	public function payroll_emploan_enrolment_home()
	{
		
		$this->load->view('app/payroll/employee_loans_enrolment/home',$this->data);
	}

	//company loan result
	public function companyLoans($id){
		$this->data['message'] = $this->payroll_emp_loan_enrolment_model->check_loan_company($id);
		$this->data['query'] = $this->payroll_emp_loan_enrolment_model->companyLoans_model($id);
		$this->load->view('app/payroll/employee_loans_enrolment/list_company_loans_view',$this->data);
	}
	
	
	//list of employees/based on company and loan type
	public function resultLoan($company,$loan)
	{
		$this->data['company'] = $company;
		$this->data['loan'] = $loan;
		$this->data['flash_id'] = '';
		//loan employee description
		$this->data['query_empall'] = $this->payroll_emp_loan_enrolment_model->result_allemp_model($company,$loan);
		//loan name/per company/per loan
		$this->data['loanquery'] = $this->payroll_emp_loan_enrolment_model->resultLoan_model($company,$loan);
		$this->load->view('app/payroll/employee_loans_enrolment/per_loan_details',$this->data);	
	}

	//addempployee loan controller
	public function loanAdd($loan,$company)
	{		
			$this->data['company'] = $company;
			$this->data['loan'] = $loan;
			$this->data['query'] = $this->general_model->paytypeList();
			$this->data['pay_type_option'] = $this->payroll_emp_loan_enrolment_model->pay_type_option();
			$this->load->view('app/payroll/employee_loans_enrolment/emp_loan_add',$this->data);
	}

	//search empployee list

	public function search_employee_list($search = NULL,$company_id = NULL)
	{
		$this->data['query'] = $this->payroll_emp_loan_enrolment_model->employeelist_model($search,$company_id);
		$this->load->view('app/payroll/employee_loans_enrolment/search_employee_list',$this->data);
	}

	//save added employe loan 
	public function save_emp_loan($employee,$loan,$company,$d_eff,$d_granted,$l_amt,$amort,$principal_amt,$p_type,$option,$ref=NULL,$doc_no)
	{

		$this->data['company'] = $company;
		$this->data['loan'] = $loan;
		$this->data['loanquery'] = $this->payroll_emp_loan_enrolment_model->resultLoan_model($company,$loan);
		$result = $this->payroll_emp_loan_enrolment_model->insert_emp_loan($employee,$loan,$company,$d_eff,$d_granted,$l_amt,$amort,$principal_amt,$p_type,$option,$ref,$doc_no);
		$this->data['flash_id']=$employee;
		if($result=='exist')
		{	
			$this->session->set_flashdata('duplicate_insert',"Duplicate");
			$this->data['query_empall'] = $this->payroll_emp_loan_enrolment_model->result_allemp_model($company,$loan);
			
		}
		elseif ($result=='inserted') {
			
			$this->session->set_flashdata('success_inserted',"Success");
			$this->data['query_empall'] = $this->payroll_emp_loan_enrolment_model->result_allemp_model($company,$loan);
		}
		else{
			$this->session->set_flashdata('error_inserted',"Error");
			$this->data['query_empall'] = $this->payroll_emp_loan_enrolment_model->result_allemp_model($company,$loan);
			
		}
	  	$this->load->view('app/payroll/employee_loans_enrolment/per_loan_details',$this->data);
	}

	//upload and download/mass uplaod
	public function loanUpload($loan,$company)
	{
		$this->data['loan'] = $loan;
		$this->data['company'] = $company;
		
		$this->load->view('app/payroll/employee_loans_enrolment/loan_mass_upload',$this->data);	
	}

	//edit details
	public function editDetails($option,$emp_loan_id,$loan,$company)
	{
		$this->data['option']  = $option;
		$this->data['query1'] = $this->payroll_emp_loan_enrolment_model->paytypeList();
		$this->data['query'] = $this->payroll_emp_loan_enrolment_model->viewDetails_model($emp_loan_id,$loan,$company);
		if($option!='main')
		{
			$this->data['query_additional'] = $this->payroll_emp_loan_enrolment_model->details_additional($option);
		}
		$this->data['pay_type_option'] = $this->payroll_emp_loan_enrolment_model->pay_type_option();
		$this->load->view('app/payroll/employee_loans_enrolment/editDetails',$this->data);	
	}

	//update employee loann status
	public function updateStatus($status,$emp_loan_id,$loan,$company)
	{
		$this->data['company'] = $company;
		$this->data['loan'] = $loan;
		$this->data['flash_id'] = $emp_loan_id;
		$result = $this->payroll_emp_loan_enrolment_model->updateStatus($status,$emp_loan_id,$loan,$company);
		if($result == 'status_updated')
			{ 
				$this->session->set_flashdata('success_updatestatus',"Update_Record");
			}
		else{
				$this->session->set_flashdata('no_changes_updatestatus',"Update_Record"); 
			}
		$this->data['query_empall'] = $this->payroll_emp_loan_enrolment_model->result_allemp_model($company,$loan);
		$this->data['loanquery'] = $this->payroll_emp_loan_enrolment_model->resultLoan_model($company,$loan);
		$this->load->view('app/payroll/employee_loans_enrolment/per_loan_details',$this->data);
	}

	

	//delete details
	public function deleteDetails($emp_loan_id,$loan,$company)
	{
		$this->data['company'] = $company;
		$this->data['loan'] = $loan;
		$result = $this->payroll_emp_loan_enrolment_model->deleteDetails($emp_loan_id,$loan,$company);
		if($result==1)
		{
			$this->data['flash_id']= $emp_loan_id;
			$this->data['loanquery'] = $this->payroll_emp_loan_enrolment_model->resultLoan_model($company,$loan);
			$this->data['query_empall'] = $this->payroll_emp_loan_enrolment_model->result_allemp_model($company,$loan);
			$this->session->set_flashdata('success_delete',"Delete_Record");
			$this->load->view('app/payroll/employee_loans_enrolment/per_loan_details',$this->data);	
		}
		else{
		}
	}

	public function deleteDetails_additional($emp_loan_id,$loan,$company,$id)
	{
		$this->data['company'] = $company;
		$this->data['loan'] = $loan;
		$result = $this->payroll_emp_loan_enrolment_model->deleteDetails_additional($emp_loan_id,$loan,$company,$id);
		if($result==1)
		{
			$this->data['flash_id']= $id;
			$this->data['loanquery'] = $this->payroll_emp_loan_enrolment_model->resultLoan_model($company,$loan);
			$this->data['query_empall'] = $this->payroll_emp_loan_enrolment_model->result_allemp_model($company,$loan);
			$this->session->set_flashdata('success_delete',"Delete_Record_additional");
			$this->load->view('app/payroll/employee_loans_enrolment/per_loan_details',$this->data);	
		}
		else{
		}
	}

	//filter status
	public function filter_status($status,$loan,$company)
	{	
		$this->data['company'] = $company;
		$this->data['loan'] = $loan;
		$this->data['loanquery'] = $this->payroll_emp_loan_enrolment_model->resultLoan_model($company,$loan);
		$this->data['query_empall'] = $this->payroll_emp_loan_enrolment_model->filter_result_model($status,$loan,$company);
		$this->load->view('app/payroll/employee_loans_enrolment/filter_loan_details',$this->data);	
	}

	//save updated employee loan record
	public function saveUpdate($emp_loan_id,$loan,$company,$loan_amt,$principal_amt,$date_effective,$pay_type,$pay_type_option,
								$amortization,$ref_no)
	{
		$this->data['company'] = $company;
		$this->data['loan'] = $loan;
		$result = $this->payroll_emp_loan_enrolment_model->saveUpdate_model($emp_loan_id,$loan,$company,$loan_amt,$principal_amt,$date_effective,$pay_type,$pay_type_option,$amortization,$ref_no);
		$this->data['flash_id']= $emp_loan_id;
		if($result == 'updated')
			{ 
				$this->session->set_flashdata('success_update',"Update_Record");
			}
		else{
				$this->session->set_flashdata('no_changes',"Update_Record"); 
			}
		$this->data['query_empall'] = $this->payroll_emp_loan_enrolment_model->result_allemp_model($company,$loan);
		$this->data['loanquery'] = $this->payroll_emp_loan_enrolment_model->resultLoan_model($company,$loan);
		$this->load->view('app/payroll/employee_loans_enrolment/per_loan_details',$this->data);


	} 

	public function saveUpdate_additional($amount,$desc,$loan_app,$reference,$emp_loan_id,$loan,$company,$addloan_id)
	{
		$this->data['company'] = $company;
		$this->data['loan'] = $loan;
		$result = $this->payroll_emp_loan_enrolment_model->saveUpdate_additional($amount,$desc,$loan_app,$reference,$emp_loan_id,$loan,$company,$addloan_id);
		$this->data['flash_id']= $emp_loan_id;
		if($result == 'updated')
			{ 
				$this->session->set_flashdata('success_update',"Update_Record");
			}
		else{
				$this->session->set_flashdata('no_changes',"Update_Record"); 
			}
		$this->data['query_empall'] = $this->payroll_emp_loan_enrolment_model->result_allemp_model($company,$loan);
		$this->data['loanquery'] = $this->payroll_emp_loan_enrolment_model->resultLoan_model($company,$loan);
		$this->load->view('app/payroll/employee_loans_enrolment/per_loan_details',$this->data);

	}

	//M11: Download template
	public function download_emp_loan_enrolment () {
        $this->load->helper('download');            
		$path    =   file_get_contents(base_url()."public/downloadable_templates/download_emp_loan_enrolment_per_loan.xls");
		$name    =   "download_emp_loan_enrolment_per_loan.xls";
		force_download($name, $path);
		$value = $name;
		General::logfile('Employee Personal Info Template','DOWNLOAD',$value);      
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


	//check if decimal
	function containsDecimal( $value ) {

	if ( strpos( $value, "." ) !== false ||  is_numeric($value) !==false) {
	        return true;
	    }
	    return false;
	}
	 //M11: Import Controller import_employee_info_template
      public function upload()
    {
    	
    		$action = $_POST['action'];
			$company = $_POST['company'];
			$loan = $_POST['loan'];	

	    	if(isset($_POST["import"]))
		    {
				$fileName = $_FILES['file']['name'];
				//unlink( './public/import_template/'.$fileName);//overwrite if file name already exist.
					$file_pointer = './public/import_template/'.$fileName; 
					  
					if (file_exists($file_pointer))  
					{ 
					  	unlink( './public/import_template/'.$fileName);//overwrite if file name already exist. 
					}else { }
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

		            
		        
				
				echo '
				<br><br>
				<style>
				table {
				  border-collapse: collapse;
				  width: 100%;
				}

				th, td {
				  text-align: left;
				  padding: 8px;
				}

				tr:nth-child(even){background-color: #f2f2f2}

				th {
				  background-color: #4CAF50;
				  color: white;
				}
				</style>
				
				<table style="width:90%;margin-left:5%;margin-top:20px;margin-bottom:20px;" border="1">
				<thead>
					</tr>
					<tr>	
						  <th>No</th>
						  <th>Employee ID</th>
		                  <th>Loan Amt</h4></th>
		                  <th>Amortization</h4></th>
		                  <th>Principal Amt</h4></th>
		                  <th>Date Effective</h4></th>
		                  <th>Date Granted</h4></th>
		                  <th>Reference Number</h4></th>
		                  <th>Option</h4></th>
		                  <th>Remarks</h4></th>
		                  </tr>
					</tr>
				</thead>
				<tbody>
				';	  

		            $styleArray = array(
				    'font'  => array(
				        'bold'  => true,
				        'color' => array('rgb' => 'FF0000')
				    ));

				     for ($row = 2; $row <= $highestRow; $row++){
				     	$colLetter 			= 'A';
				     	$error = false;
				     	for($col = 0; $col < $colNumber; $col++){
			            	$colrow = $colLetter.(string)$row;    
						    $getCellvalue = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
						    
						    if($col=="0")
						    {
								$employee_id=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="1")
							{
								$loan_amount=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="2")
							{
								$amortization=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="3")
							{
								$principal_amount=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="4")
							{
								$date_effective=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="5")
							{
								$date_granted=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="6")
							{
								$reference_no=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}	
							elseif($col=="7")
							{
								$cutoff=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							else
							{

							}

						    $colLetter++;
						}// col array


					
					$no = $row;
					?>
						<tr>
							<td> <?php echo $no;?> </td>
							<td>
								<?php 
									
									echo $employee_id;
									$check_employee = $this->payroll_emp_loan_enrolment_model->mass_check_employee($employee_id,$company);
									if($check_employee === false){
										echo "<br><n style='color:red';>Employee does not exist in company id ".$company."</n>";	
										$error = true;						
									}
									else
									{
										echo $check_employee;
									}
								?>
								
							</td>
							<td>
								<?php echo $loan_amount;
									$check_loan_amount = $this->containsDecimal($loan_amount);
									if($check_loan_amount === false){
										echo "<br><n style='color:red';>Number and Decimal Only/Characters are not allowed</n>";	
										$error = true;	
									}
								?>
								
							</td>
							<td>
								<?php 
									echo $amortization;
									$check_amortization = $this->containsDecimal($amortization);
									if($check_amortization === false){
										echo "<br><n style='color:red';>Number and Decimal Only/Characters are not allowed</n>";	
										$error = true;	
									}
								?>
								
									
							</td>
							<td>
								<?php 
										echo $principal_amount;
										$check_principal_amount = $this->containsDecimal($principal_amount);
										if($check_principal_amount === false){
											echo "<br><n style='color:red';>Number and Decimal Only/Characters are not allowed</n>";	
											$error = true;	
										}

								?></td>
							<td>
								<?php 
										echo $date_effective;
										$check_date_effective = $this->validateDate($date_effective);
										if($check_date_effective === false){
											echo "<br><n style='color:red';>Invalid date format</n>";	
											$error = true;	
										}
										
								?>
							</td>
							<td>
								<?php 
									echo $date_granted;
									$check_date_granted = $this->validateDate($date_granted);
										if($check_date_granted === false){
											echo "<br><n style='color:red';>Invalid date format</n>";	
											$error = true;	
										}
								?>
							</td>
							<td><?php echo $reference_no;?></td>
							<td><?php 

									echo $cutoff;
									$result = $this->payroll_emp_loan_enrolment_model->check_emp_paytype_model($employee_id);
								    $pay_type =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
									$pay_type_option = $this->validate_PayOption($cutoff,$result);
									if($pay_type_option != 0 AND $pay_type_option != '' )
									{
										echo "<br><n style='color:red';>Invalid Cutoff Option</n>";	
										$error = true;	
									}
									elseif($pay_type_option =='no_pay_type' ){
										echo "<br><n style='color:red';>Invalid Option/Please check the pay type id</n>";	
										$error = true;
									}
									else
									{
										$cutoff_desc = $this->payroll_emp_loan_enrolment_model->get_loan_cutof($cutoff);
										if(!empty($cutoff_desc)){ echo $cutoff_desc; }
									}
								?>
							</td>
							<td>
								<?php
									if($action=='Save')
									{
										$insert_data = $this->payroll_emp_loan_enrolment_model->insert_loan($loan,$company,$employee_id,$loan_amount,$amortization,$date_effective,$date_granted,$cutoff,$reference_no,$result,$principal_amount);
										if($insert_data=='inserted')
											{
												echo "<n style='color:green';><i>Saved</i></n>";
											} else{ echo "<n style='color:red';><i>Error</i></n>"; }
									}
									else
									{
										if($error==false)
										{
											echo "<n style='color:green';><i>no error</i></n>";
										}
										else
										{
											echo "<n style='color:red';><i>correct first the error</i></n>";
										}
									}
										
								?>
							</td>
						</tr>
					<?php }
				echo '
				</tbody>
				</table>';

			}
		
	}
	public function validate_PayOption($pay_type,$result)
	{
	    $variable = $pay_type;
        $var=explode('-',$variable);

	    if($result==1)
	    {
			foreach($var as $row) 
			  {
				$ii=0;
            		
			            if($row=='1' || $row=='2' || $row=='3' || $row=='4' || $row=='5')
				            { }
				        elseif($row='6' AND $variable==$row){}
			            else{
			               $ii=$ii+1;
			               return $ii;
			            	}
        	  }
    	}

    	elseif($result==2 || $result==3)
	    {
			foreach($var as $row)  
			  {
				$ii=0;
            		
			            if($row=='1' || $row=='2')
				            { }
				        elseif($row='6' AND $variable==$row){}
			            else{
			               $ii=$ii+1;
			               return $ii;
			            	}
        	  }
    	}

    	elseif($result==4)
	    {
			foreach($var as $row)  
			  {
				$ii=0;
            		
			            if($row=='6' || $row=='-' || $row=='')
				            { }
			            else{
			               $ii=$ii+1;
			               return $ii;
			            	}
        	  }
    	}
    	else{
    		return 'no_pay_type';
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
	 //download the mass upload for all
	public function download_emp_loan_enrolment_all()
	{
		 $this->load->helper('download');            
		$path    =   file_get_contents(base_url()."public/downloadable_templates/download_emp_loan_enrolment_per_loan_all.xls");
		$name    =   "download_emp_loan_enrolment_per_loan_all.xls";
		force_download($name, $path); 
		$value = $name;
		General::logfile('Employee Personal Info Template','DOWNLOAD',$value);
	}
	//mass upload all form
	public function massupload_all()
	{
		$this->load->view('app/payroll/employee_loans_enrolment/massupload_all');
	}
	//end of mass upload


	public function plot_schedules_upload()
	{
		$numOfEmp 		= 0;
    	$foundError 	= False;
    	
    	$excelEmpName 	= array();
    	$result 		= 0;

    	$fileName = $_FILES['file']['name'];
		$action = $_POST['action'];
		

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
	            $forDate 		= 'Invalid Date';
	            $forDate 		= 'Format:yyyy-mm-dd';
	            $forShift 		= 'Invalid Shift Category';
	            $forTime 		= 'Invalid Time Format please use the hh:mm';
	            $forRestday 	= 'Invalid Rest day option. Please use only the yes or no options';
	            $company_error = 'Employee ID doesnt exist in employee ';
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
					    		if($col == 0 || $col == 2 || $col == 3 || $col == 4 || $col == 5 || $col == 6){ // for null
								$objPHPExcel->getActiveSheet()->
								setCellValueByColumnAndRow($col, $row,  $forNull);
								$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
									$foundError = True;
								}
			            	}
			            	else{
			            			if($col==2)
							           {
							            	$date =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
											$check = $this->validateDate($date);
													
											if($check === false){
												$objPHPExcel->getActiveSheet()->
													setCellValueByColumnAndRow($col, $row,  $date.' -> '.$forDate);
													$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
											}
							            }
							         if($col==0)
							         {
							         	$col_0 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
							         	$employee_companylist =$col_0;
							         	$resultemployee_companylist = $this->payroll_emp_loan_enrolment_model->employee_company_checke_ws_model($employee_companylist);
													if($resultemployee_companylist === false){
														$objPHPExcel->getActiveSheet()->
															setCellValueByColumnAndRow($col, $row,  $employee_companylist.' -> '.$company_error);//doesn't exist
															$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																$foundError = True;
														}
							         }
							         if($col==3)
							         {
							         	$col_3 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
							         	if($col_3 != 'regular' AND $col_3 != 'restday' AND $col_3 != 'halfday' 
							         		AND $col_3 != 'regular-holiday'){
														$objPHPExcel->getActiveSheet()->
															setCellValueByColumnAndRow($col, $row,  $col_3.' -> '.$forShift);//doesn't exist
															$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																$foundError = True;
														}
							         }
							         if($col==5)
							         {
							         	$col_5 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
							         	$time_checker =  preg_match("/^(?:2[0-3]|[01][0-9]|[0-9]):[0-5][0-9]$/", $col_5);
							         	if($time_checker==0){
														$objPHPExcel->getActiveSheet()->
															setCellValueByColumnAndRow($col, $row,  $col_5.' -> '.$forTime);//doesn't exist
															$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																$foundError = True;
														}
							         }
							         if($col==6)
							         {
							         	$col_6 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $row)->getValue();
							         	$time_checker =  preg_match("/^(?:2[0-3]|[01][0-9]|[0-9]):[0-5][0-9]$/", $col_6);
							         	if($time_checker==0){
														$objPHPExcel->getActiveSheet()->
															setCellValueByColumnAndRow($col, $row,  $col_6.' -> '.$forTime);//doesn't exist
															$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																$foundError = True;
														}
							         }
							         if($col==4)
							         {
							         	$col_4 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
							         	$col_3 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
							         	if($col_4 != 'yes' AND $col_4 != 'no'){
														$objPHPExcel->getActiveSheet()->
															setCellValueByColumnAndRow($col, $row,  $col_4.' -> '.$forRestday);//doesn't exist
															$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																$foundError = True;
														}
										else{ 
											if($col_3!='restday' AND $col_4=='yes'){
														$objPHPExcel->getActiveSheet()->
															setCellValueByColumnAndRow($col, $row,  $col_4.' -> '.'Please check the shift category. You can only use the option yes if the shift category is restday');//doesn't exist
															$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
																$foundError = True;
														}
										}
							         }



			            	}
			            		
		         	$colLetter++;// increment A
					}//end of col for loop
		         }//end of row for loop
		     		
				
		         //End of check and rewrite the error of imported excel
		         if($foundError==False){ // insert to employee_info table
		        
						for ($row = 2; $row <= $highestRow; $row++){
							$numOfEmp++;                                  
							$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
		                                NULL,TRUE,FALSE);
								        
								        $dt = $date_array = getdate();
								        $formated_date  = "ws";
										$formated_date .= $date_array['mon'];
										$formated_date .= $date_array['mday'];
										$formated_date .= $date_array['year'] . "_";
										$formated_date .= $date_array['hours'];
										$formated_date .= $date_array['minutes'];
										$formated_date .= $date_array['seconds'];
		                				$date_created 	= date('Y-m-d H:i:s');
								        $date_o = $rowData[0][2];
								        $month = date('m', strtotime($date_o));
								        $day = date('d', strtotime($date_o));
								        $year = date('Y', strtotime($date_o));
								        $tablename = 'working_schedule_'.$month;
								        $company_id = $this->plot_schedules_model->get_company($rowData[0][0]);
								        if($rowData[0][4]=='no'){ $restday =0; } else{ $restday =1;}
								       	$data = array(
												'date'					=>				$rowData[0][2],
												'company_id'			=>				$company_id,
												'employee_id'			=>				$rowData[0][0],
												'mm'					=>				$month,
												'dd'					=>				$day,
												'yy'					=>				$year,
												'shift_in'				=>				$rowData[0][5],
												'shift_out'				=>				$rowData[0][6],
												'plotter'				=>				$this->session->userdata('employee_id'),
												'group_id'				=>				0,
												'shift_category'		=>				$rowData[0][3],
												'restday'				=>				$restday,
												'date_plotted'			=> 				date('Y-m-d')
												);
								       	$where = array('employee_id'=>$rowData[0][0],'company_id'=>$company_id,'date'=>$date_o,'group_id'=>0);
								       	$this->db->where($where);
								       	$querye = $this->db->get($tablename);
								       	if($querye->num_rows() > 0)
								       	{
								       		$this->db->where($where);
								       		$query = $this->db->update($tablename,$data);
								       	}
								       	else{ $query = $this->db->insert($tablename,$data); }
	                					
	                					$insert = 'inserted';			                
	                 
				}//end of else find error
				 if($insert){ //file name for successfully imported
				            	$this->data['action']='save';
								$this->data['count_data']=$highestRow - 1;
								$this->load->view('app/time/plot_schedules/review_upload/template_header',$this->data);
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
									$this->load->view('app/time/plot_schedules/review_upload/template_content',$this->data);
								}
								$this->load->view('app/time/plot_schedules/review_upload/template_footer',$this->data);
							       $dt = $date_array = getdate();
							       $formated_date  = "ws_";
							       $formated_date .= $date_array['mon'];
							       $formated_date .= $date_array['mday'];
								   $formated_date .= $date_array['year'] . "_";
								   $formated_date .= $date_array['hours'];
							       $formated_date .= $date_array['minutes'];
								   $formated_date .= $date_array['seconds'];
							    	rename( $inputFileName, './public/import_template/'.$formated_date.'.xls' );
						} 
						}//end of file name for successfully imported
				else{//download if found an error
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
					header('Content-Disposition: attachment;filename="' ."ws_errr". '""' .date('Y-m-d')."_".date('H:i:s').".xlsx".'"');
					header('Cache-Control: max-age=0');
					unlink($inputFileName);
					$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$objWriter->save('php://output');
					exit; 
				}//end of download if found an error
			}//end of For license purpose
			
		}
		//start of review
		else
			{  
					$this->data['action']='review'; 
					$this->load->view('app/time/plot_schedules/review_upload/template_header',$this->data);
					for ($row = 2; $row <= $highestRow; $row++)
						{

							$col_0 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
							$col_1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
							$col_2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
							$col_3 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
							$col_4 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
							$col_5 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
							$col_6 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $row)->getValue();
							
			
						if(empty($col_0) || empty($col_2) || empty($col_3) || empty($col_4) || empty($col_5) || empty($col_6) ){
								$foundError=True;
								$null='Check empty fieds.<br>';
							} else{  $null='';}
						$check = $this->validateDate($col_2);
						if($check === false || $check === false){
							$foundError = True;
							$date='Invalid Date<br>';
						} else{  $date=''; }
						$c_emp = $this->payroll_emp_loan_enrolment_model->employee_company_checke_ws_model($col_0);
						if($c_emp === false) 
						{ $foundError = True;
						  $ec='Employee ID does not exist in database.<br>'; }
						else{  $ec=""; }

						if($col_3 !='restday' AND $col_3 !='regular' AND $col_3 !='halfday'  AND $col_3 !='regular-holiday' ) 
						{ $foundError = True;
						  $sc='Invalid Shift Category.<br>'; }
						else{  $sc=""; }

						if($col_4 !='yes' AND $col_4 !='no') 
						{ $foundError = True;
						  $rd='Invalid Restday Option.<br>'; }
						else{  

							if($col_3!='restday' AND $col_4 =='yes')
							{
								$foundError = True;
								$rd='You can only use the yes option when the shift category is restday.<br>';
							}
							else{ $rd=''; }
						}

						$time_checker5 =  preg_match("/^(?:2[0-3]|[01][0-9]|[0-9]):[0-5][0-9]$/", $col_5);
						if($time_checker5==0){
							$foundError = True;
						 	$t5='Invalid Time Format.<br>';
						}
						else{ $t5=''; }

						$time_checker6 =  preg_match("/^(?:2[0-3]|[01][0-9]|[0-9]):[0-5][0-9]$/", $col_6);
						if($time_checker6==0){
							$foundError = True;
						 	$t6='Invalid Time Format.<br>';
						}
						else{ $t6=''; }

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
								
								$this->data['errors']= $null.$date.$ec.$sc.$rd.$t5.$t6;
							}
							else{
								$this->data['remarks']= 'Ok';
							}
							$this->load->view('app/time/plot_schedules/review_upload/template_content',$this->data);
						}

						$this->load->view('app/time/plot_schedules/review_upload/template_footer',$this->data);
						unlink($inputFileName);		
			}

		//end of review
		}
		else{
			echo "<script>alert('Error report to technical support')</script>";
		}
	}

	public function get_employee_loan_request($id,$company)
	{
		$this->data['loan_id'] = $id;
		$this->data['company_id'] = $company;
		$this->data['forms'] = $this->payroll_emp_loan_enrolment_model->get_employeee_loans_request($id,$company);
		$this->load->view('app/payroll/employee_loans_enrolment/employee_loan_request_list',$this->data);	
	}

	public function emp_loan_request_forms()
	{
		$this->load->view('app/payroll/employee_loans_enrolment/emp_loan_request_forms',$this->data);
	}

	public function get_company_loan_type($company)
	{
		$loan_type = $this->payroll_emp_loan_enrolment_model->companyLoans_model($company);

		if(empty($loan_type))
		{
			echo "<option value='all'>No Loan type Found</option>";	
		}
		else
		{
			echo "<option value='all'>Select Loan Type</option>";
			foreach($loan_type as $l)
			{
				echo "<option value='".$l->loan_type_id."'>".$l->loan_type."</option>";
			}
		}
		
	}

	public function filter_forms($company,$loan,$status,$for_approved)
	{
		$this->data['forms'] = $this->payroll_emp_loan_enrolment_model->filter_forms($company,$loan,$status,$for_approved);
		$this->load->view('app/payroll/employee_loans_enrolment/employee_loan_request_list',$this->data);	
	}
	public function add_additional_loan($loan_id,$loan_type,$company)
	{
		$this->data['loan_type']=$loan_type;
		$this->data['company'] = $company;
		$this->data['loan_id'] = $loan_id;
		$this->data['pay_type_option'] = $this->payroll_emp_loan_enrolment_model->pay_type_option();
		$this->data['loandetails'] = $this->payroll_emp_loan_enrolment_model->viewDetails_model($loan_id,$loan_type,$company);
		$this->data['additionalloan'] = $this->payroll_emp_loan_enrolment_model->get_all_additional_loans($loan_id);
		$this->data['total_loan'] =  $this->payroll_emp_loan_enrolment_model->total_employee_loan($loan_id);
		$this->load->view('app/payroll/employee_loans_enrolment/add_additional_loan',$this->data);
	}
	//view details
	public function viewDetails($loan_id,$loan_type,$company)
	{


		$this->data['loan_type']=$loan_type;
		$this->data['company'] = $company;
		$this->data['loan_id'] = $loan_id;
		$this->data['pay_type_option'] = $this->payroll_emp_loan_enrolment_model->pay_type_option();
		$this->data['loandetails'] = $this->payroll_emp_loan_enrolment_model->viewDetails_model($loan_id,$loan_type,$company);
		$this->data['additionalloan'] = $this->payroll_emp_loan_enrolment_model->get_all_additional_loans($loan_id);
		$this->data['total_loan'] =  $this->payroll_emp_loan_enrolment_model->total_employee_loan($loan_id);
		$this->load->view('app/payroll/employee_loans_enrolment/viewDetails',$this->data);
	}

	public function viewDetailss($loan_id,$loan_type,$company)
	{

		$this->data['loan_type']=$loan_type;
		$this->data['company'] = $company;
		$this->data['loan_id'] = $loan_id;
		$this->data['pay_type_option'] = $this->payroll_emp_loan_enrolment_model->pay_type_option();
		$this->data['loandetails'] = $this->payroll_emp_loan_enrolment_model->viewDetails_model($loan_id,$loan_type,$company);
		$this->data['additionalloan'] = $this->payroll_emp_loan_enrolment_model->get_all_additional_loans($loan_id);
		$this->data['total_loan'] =  $this->payroll_emp_loan_enrolment_model->total_employee_loan($loan_id);
		$this->load->view('app/payroll/employee_loans_enrolment/viewDetails_home',$this->data);
	}

	public function get_all_approved_forms($loan,$company)
	{
		$approvedforms = $this->payroll_emp_loan_enrolment_model->get_all_approved_forms($loan,$company);
		if(empty($approvedforms))
		{
			echo "<option value=''>No approved forms found.</option>";
		}
		else
		{
			echo "<option value=''>Select</option>";
			$i=0;
			foreach($approvedforms as $ap)
			{
				$doc = $this->payroll_emp_loan_enrolment_model->check_if_added_additional($ap->doc_no);
				if(empty($doc)){
				echo "<option value='".$ap->id."'>".$ap->doc_no."</option>";
				$i++;
				} else{}

			}
			if($i==0){ echo "<option value=''>No approved forms found.</option>"; }
		}
		
	}

	public function get_docno_details(){
		$id = $this->input->post('id');

		$values = $this->payroll_emp_loan_enrolment_model->get_docno_details($id);
		$result = array(
			"data" => $values
		);

		echo json_encode($result);
	}

	public function save_additional_loan($option,$doc,$amount,$desc,$reference,$loan_app,$loan_id,$loan_type,$company,$date_effective)
	{
		
		$this->data['company'] = $company;
		$this->data['loan'] = $loan_type;
		$result = $this->payroll_emp_loan_enrolment_model->save_additional_loan($option,$doc,$amount,$desc,$reference,$loan_app,$loan_id,$loan_type,$company,$date_effective);
		$this->data['flash_id']= $loan_id;
		if($result == 'inserted')
			{ 

				if($option=='manual'){ $opp='manual';  } else{ $opp='additional'; }
				$this->session->set_flashdata('success_inserted_'.$opp,"Inserted_Record");
			}
		else{
			
				$this->session->set_flashdata('no_changes',"Inserted_Record"); 
			}
		$this->data['query_empall'] = $this->payroll_emp_loan_enrolment_model->result_allemp_model($company,$loan_type);
		$this->data['loanquery'] = $this->payroll_emp_loan_enrolment_model->resultLoan_model($company,$loan_type);
		$this->load->view('app/payroll/employee_loans_enrolment/per_loan_details',$this->data);

	}

	public function add_new_approved_loan($loan_type,$company,$id)
	{
		$this->data['loan']=$loan_type;
		$this->data['company']=$company;
		$this->data['query'] = $this->general_model->paytypeList();
		$this->data['pay_type_option'] = $this->payroll_emp_loan_enrolment_model->pay_type_option();
		$this->data['details'] = $this->payroll_emp_loan_enrolment_model->get_approved_form_details($id);
		foreach($this->data['details'] as $d)
		{

			$this->data['loandetails'] = $this->payroll_emp_loan_enrolment_model->viewDetails_model($d->loan_id,$loan_type,$company);
			$this->data['additionalloan'] = $this->payroll_emp_loan_enrolment_model->get_all_additional_loans($d->loan_id);
			$this->data['total_loan'] =  $this->payroll_emp_loan_enrolment_model->total_employee_loan($d->loan_id);
		
		}

		$this->load->view('app/payroll/employee_loans_enrolment/add_new_approved_loan',$this->data);
	}

	public function enable_disable($emp_loan_id,$loan,$company,$action,$option,$idd)
	{
		$this->data['company'] = $company;
		$this->data['loan'] = $loan;
		$action = $this->payroll_emp_loan_enrolment_model->enable_disable($emp_loan_id,$loan,$company,$action,$option,$idd);
		$this->data['flash_id']= $emp_loan_id;
		if($action=='updated_Active')
		{ $this->session->set_flashdata('success_active',"Active_Record"); }
		else if ($action=='updated_Paid')
		{ $this->session->set_flashdata('success_paid',"Paid_Record"); }
		else{  $this->session->set_flashdata('success_pause',"Pause_Record"); }
		$this->data['loanquery'] = $this->payroll_emp_loan_enrolment_model->resultLoan_model($company,$loan);
		$this->data['query_empall'] = $this->payroll_emp_loan_enrolment_model->result_allemp_model($company,$loan);
		$this->load->view('app/payroll/employee_loans_enrolment/per_loan_details',$this->data);	
	}

// ============ start loan ledger
	public function view_loan_ledger($emp_loan_id){
		$this->data['motherLoan']=$this->payroll_emp_loan_enrolment_model->GetMotherLoan($emp_loan_id);

		$this->data['MyAddLoan']=$this->payroll_emp_loan_enrolment_model->GetAdditionalLoan($emp_loan_id);
		$this->data['payment_history']=$this->payroll_emp_loan_enrolment_model->GetPaymentHistory($emp_loan_id);
		$this->load->view('app/payroll/employee_loans_enrolment/loan_ledger',$this->data);	
		//same with views of emp: excluding display of name.
		//$this->load->view('employee_portal/payroll/payslip/my_loan_ledger',$this->data);	

	}
// ============ end loan ledger



	public function get_company_loantype($company)
	{
		$details = $this->payroll_emp_loan_enrolment_model->get_company_loantype($company);
		if(empty($details))
		{
			echo "<option value='all' selected disabled>No loan type found.</option>";
		}
		else
		{
			echo "<option value='all' selected disabled>Select Loan Type</option>	
					<option value='all'>All</option>";
			foreach($details as $d)
			{
				echo "<option value='".$d->loan_type_id."'>".$d->loan_type."</option>";
			}
		}
	}

	public function get_filtered_loan($company,$loan,$status)
	{
		$query_all = $this->payroll_emp_loan_enrolment_model->listAll($company,$loan,$status);
		?>

		<div id="loan_ledger">
  
		</div>
		<table id="table_home" class="table table-hover table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Loan Type</th>
                    <th>Employee ID</th>
                    <th>Full Name</th>  
                    <th>Company</th> 
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($query_all as $row1) {
                  $fullname= $row1->first_name." ".$row1->last_name;
                  $status = $row1->status;
                  ?>
                  <tr>
                    <td><a class='btn'  aria-hidden='true' data-toggle='tooltip' title='Click to View Details' onclick="viewDetailss(<?php echo $row1->emp_loan_id.",".$row1->loan_type_id.",".$row1->company_id?>);" ><n style="font-weight: bold;" class="<?php if($status=='Active'){ echo "text-success"; } elseif($status=='Paid'){ echo "text-danger";} else{ echo "text-default";}?>">
                    <?php echo $row1->emp_loan_id;?></n></a>
                    </td>
                    <td><?php echo $row1->loan_type?></td>
                    <td><a target="_blank" style="color:black;" href="<?php echo base_url()?>app/employee/employee_profile/<?php echo $row1->employee_id?>" aria-hidden='true' data-toggle='tooltip' title='Click to view Employee ID details'><?php echo $row1->employee_id?></a></td>
                    <td><a target="_blank" style="color:black;" href="<?php echo base_url()?>app/employee/employee_profile/<?php echo $row1->employee_id?>" aria-hidden='true' data-toggle='tooltip' title='Click to view Name details'><?php echo $fullname?></a></td>
                    <td><?php echo $row1->company_name?></td>
                    <td><?php echo '  
<button onclick="view_loan_ledger2('.$row1->emp_loan_id.');" class="btn btn-danger">
      Loan Ledger
      </button>'; ?></td>
                    
                  </tr>
                <?php }?>
                </tbody>
        </table>

	<?php
	}

	//employee loan mass uploading

	public function emp_loan_mass_upload()
	{
		$this->load->view('app/payroll/employee_loans_enrolment/company_loan_mass_upload',$this->data);	
	}

	//masss uploading

	public function download_emp_loan_enrolment_mass_upload () {
        $this->load->helper('download');            
		$path    =   file_get_contents(base_url()."public/downloadable_templates/download_emp_loan_enrolment_mass_upload.xls");
		$name    =   "download_emp_loan_enrolment_mass_upload.xls";
		force_download($name, $path);
		$value = $name;
		General::logfile('Employee Personal Info Template','DOWNLOAD',$value);      
    }


   	public function loan_mass_upload()
   	{
   		    $action = $_POST['action'];
			

	    	if(isset($_POST["import"]))
		    {
				$fileName = $_FILES['file']['name'];
				//unlink( './public/import_template/'.$fileName);//overwrite if file name already exist.
					$file_pointer = './public/import_template/'.$fileName; 
					  
					if (file_exists($file_pointer))  
					{ 
					  	unlink( './public/import_template/'.$fileName);//overwrite if file name already exist. 
					}else { }
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

		            
		        
				
				echo '
				<br><br>
				<style>
				table {
				  border-collapse: collapse;
				  width: 100%;
				}

				th, td {
				  text-align: left;
				  padding: 8px;
				}

				tr:nth-child(even){background-color: #f2f2f2}

				th {
				  background-color: #4CAF50;
				  color: white;
				}
				</style>
				<center><h2 style="color:red;">Employee Loan Enrollment Mass Uploading</h2></center>
				<table style="width:90%;margin-left:5%;margin-top:20px;margin-bottom:20px;" border="1">
				<thead>
					<tr>	
						  <th>No</th>
						  <th>Company ID</th>
						  <th>Employee ID</th>
						  <th>Loan Type</th>
		                  <th>Loan Amt</h4></th>
		                  <th>Amortization</h4></th>
		                  <th>Principal Amt</h4></th>
		                  <th>Date Effective</h4></th>
		                  <th>Date Granted</h4></th>
		                  <th>Reference Number</h4></th>
		                  <th>Cutoff Deduction</h4></th>
		                  <th>Remarks</h4></th>
		                  </tr> 
					</tr>
				</thead>
				<tbody>
				';	  

		            $styleArray = array(
				    'font'  => array(
				        'bold'  => true,
				        'color' => array('rgb' => 'FF0000')
				    ));

				     for ($row = 2; $row <= $highestRow; $row++){
				     	$colLetter 			= 'A';
				     	$error = false;
				     	for($col = 0; $col < $colNumber; $col++){
			            	$colrow = $colLetter.(string)$row;    
						    $getCellvalue = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
						    
						    if($col=="0")
						    {
								$company_id=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();	
							}
							else if($col=="1")
							{
								$employee_id=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							else if($col=="2")
							{
								$loan_type=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="3")
							{
								$loan_amount=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="4")
							{
								$amortization=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="5")
							{
								$principal_amount=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="6")
							{
								$date_effective=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="7")
							{
								$date_granted=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="8")
							{
								$reference_no=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}	
							elseif($col=="9")
							{
								$cutoff=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							else
							{}

						    $colLetter++;
						}// col array


					
					$no = $row;
					?>
						<tr>
							<td> <?php echo $no;?> </td>
							<td> 
								<?php echo $company_id;
									$check_company = $this->payroll_emp_loan_enrolment_model->mass_check_company($company_id);
									if($check_company === false){
										echo "<br><n style='color:red';>Invalid Company ID</n>";	
										$error = true;						
									}
									else
									{
										echo $check_company;
									}
								?>
									
							</td>
							<td> 
								<?php echo $employee_id;
									$check_employee = $this->payroll_emp_loan_enrolment_model->mass_check_employee($employee_id,$company_id);
									if($check_employee === false){
										echo "<br><n style='color:red';>Employee does not exist in company id ".$company_id."</n>";	
										$error = true;						
									}
									else
									{
										echo $check_employee;
									}
								?> 
							</td>
							<td>
								<?php echo $loan_type;
									$check_employee = $this->payroll_emp_loan_enrolment_model->mass_check_loan_type($company_id,$loan_type);
									if($check_employee === false){
										echo "<br><n style='color:red';>Loan type does not exist in company id ".$company_id."</n>";	
										$error = true;						
									}
									else
									{
										echo $check_employee;
									}
								?> 
							</td>
							<td>
								<?php echo $loan_amount;
									$check_loan_amount = $this->containsDecimal($loan_amount);
									if($check_loan_amount === false){
										echo "<br><n style='color:red';>Number and Decimal Only/Characters are not allowed</n>";	
										$error = true;	
									}
								?>
								
							</td>
							<td>
								<?php 
									echo $amortization;
									$check_amortization = $this->containsDecimal($amortization);
									if($check_amortization === false){
										echo "<br><n style='color:red';>Number and Decimal Only/Characters are not allowed</n>";	
										$error = true;	
									}
								?>
								
									
							</td>
							<td>
								<?php 
										echo $principal_amount;
										$check_principal_amount = $this->containsDecimal($principal_amount);
										if($check_principal_amount === false){
											echo "<br><n style='color:red';>Number and Decimal Only/Characters are not allowed</n>";	
											$error = true;	
										}

								?></td>
							<td>
								<?php 
										echo $date_effective;
										$check_date_effective = $this->validateDate($date_effective);
										if($check_date_effective === false){
											echo "<br><n style='color:red';>Invalid date format</n>";	
											$error = true;	
										}
										
								?>
							</td>
							<td>
								<?php 
									echo $date_granted;
									$check_date_granted = $this->validateDate($date_granted);
										if($check_date_granted === false){
											echo "<br><n style='color:red';>Invalid date format</n>";	
											$error = true;	
										}
								?>
							</td>
							<td><?php echo $reference_no;?></td>
							<td><?php 

									echo $cutoff;
									$result = $this->payroll_emp_loan_enrolment_model->check_emp_paytype_model($employee_id);
								    $pay_type =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
									$pay_type_option = $this->validate_PayOption($cutoff,$result);
									if($pay_type_option != 0 AND $pay_type_option != '' )
									{
										echo "<br><n style='color:red';>Invalid Cutoff Option</n>";	
										$error = true;	
									}
									elseif($pay_type_option =='no_pay_type' ){
										echo "<br><n style='color:red';>Invalid Option/Please check the pay type id</n>";	
										$error = true;
									}
									else
									{
										$cutoff_desc = $this->payroll_emp_loan_enrolment_model->get_loan_cutof($cutoff);
										if(!empty($cutoff_desc)){ echo $cutoff_desc; }
									}
								?>
							</td>
							<td>
								<?php
									if($action=='Save')
									{
										$insert_data = $this->payroll_emp_loan_enrolment_model->insert_loan_mass_upload($loan_type,$company_id,$employee_id,$loan_amount,$amortization,$date_effective,$date_granted,$cutoff,$reference_no,$result,$principal_amount);
										if($insert_data=='inserted')
											{
												echo "<n style='color:green';><i>Saved</i></n>";
											} else{ echo "<n style='color:red';><i>Error</i></n>"; }
									}
									else
									{
										if($error==false)
										{
											echo "<n style='color:green';><i>no error</i></n>";
										}
										else
										{
											echo "<n style='color:red';><i>correct first the error</i></n>";
										}
									}
										
								?>
							</td>
						</tr>
					<?php }
				echo '
				</tbody>
				</table>';

			}
   	}
   	
}
