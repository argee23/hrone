<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 
	
class Other_deduction_manual_upload extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/other_deduction_manual_upload_model");
		$this->load->model("general_model");
		$this->load->dbforge();
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}

	public function single_upload()
	{
		$action_result = $this->input->post('action_result');
    	$company =  $this->input->post('company_id');
    	$option =  $this->input->post('option');
    	$group =  $this->input->post('pay_type_group');
    	$payroll_period =  $this->input->post('pay_period');
    	$other_deduction_id =  $this->input->post('other_deduction_id');

    	if($option=='reset')
    	{
    		$delete_deduction = $this->other_deduction_manual_upload_model->delete_single_deduction($group,$company,$payroll_period,$other_deduction_id);
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
		       		
			       	$payroll_period_dates = $this->other_deduction_manual_upload_model->get_payroll_period_dates($payroll_period);
			        $from_date=$payroll_period_dates->complete_from;
				    $f_month= substr($from_date, 5,2);
				    $f_day=substr($from_date, 8,2);
				    $f_year=substr($from_date, 0,4);

				    $to_date=$payroll_period_dates->complete_to;
				    $t_month= substr($to_date, 5,2);
				    $t_day=substr($to_date, 8,2);
				    $t_year=substr($to_date, 0,4);

		    		$ppdate= date("F", mktime(0, 0, 0, $f_month, 10))." ". $f_day.", ". $f_year . " To ". date("F", mktime(0, 0, 0, $t_month, 10))." ". $t_day.", ". $t_year;

		    		$group_name = $this->other_deduction_manual_upload_model->get_group_name($group);
		    		$other_deduction = $this->other_deduction_manual_upload_model->other_deduction($other_deduction_id);

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
				<center><h2>'.$action_result.' Other Deduction Employee Enrollment</h2></center>
				<table style="width:100%;margin-top:20px;margin-bottom:20px;" border="1">
				<thead>
					<tr>
						<th colspan="4" style="color:black;">
						<center>
						Payroll Period: '.$ppdate.' | 
						Group: '.$group_name.' |
						Other deduction: '.$other_deduction.'
						</center>
						</th>
					</tr>
					<tr>
						<th>Cell No.</th>
						<th>Employee ID</th>
						<th>Amount</th>
						<th>Remarks</th>
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
								$amount=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							
							else {
							}

						    $colLetter++;
						}// col array


					$action_type=$this->input->post('action_type');
					$no = $row;
					?>
						<tr>
							<td>
								<?php echo $no;?>
							</td>
							<td>
								<?php
										echo $employee_id;
										$resultemployee_companylist = $this->other_deduction_manual_upload_model->check_employee_exist_in_company($employee_id,$company);
										if($resultemployee_companylist === false){
											echo "<br><n style='color:red';>Invalid Employee ID</n>";	
											$error = true;						
										} 
										else
										{
											$resultemployee_group = $this->other_deduction_manual_upload_model->check_employee_exist_in_group($employee_id,$company,$group);
											if($resultemployee_group===false)
												{
													echo "<br><n style='color:red';>Employee ID not exist in <br>selected payroll period group</n>";				
													$error = true;	
												}
										}
								?>
							</td>
							<td>
								<?php 
									echo $amount; 
									$check_amount = $this->containsDecimal($amount);
									if($check_amount === false)
									{
										echo "<br><n style='color:red';>Invalid Amount Format</n>";
										$error = true;		
									}
								?>
							</td>
							
							<td>
								<?php 
							
									if($action_result=='Review')
									{
										if($error==false){ echo "<n style='color:green';><i>no error</i></n>"; }
										else{ echo "<n style='color:red';><i>error</i></n>"; }	
									}
									else
									{
										if($option=='add')
										{
											$insert_data = $this->other_deduction_manual_upload_model->insertSinglededuction($employee_id,$company,$group,$payroll_period,$other_deduction_id,$amount);
											if($error==false)
											{
												if($insert_data=='saved')
												{
													echo "<n style='color:green';><i>Saved</i></n>";
												}else{}
											}
											else
											{
												echo "<n style='color:red';><i>correct first the error</i></n>";
											}
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

	public function mass_upload()
	{
		$action_result = $this->input->post('action_result');
    	$company =  $this->input->post('company_id');
    	$option =  $this->input->post('option');
    	$group =  $this->input->post('pay_type_group');
    	$payroll_period =  $this->input->post('pay_period');

    	if($option=='reset')
    	{
    		$delete_deduction = $this->other_deduction_manual_upload_model->delete_mass_deduction($group,$company,$payroll_period);
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
		       		
			       	$payroll_period_dates = $this->other_deduction_manual_upload_model->get_payroll_period_dates($payroll_period);
			        $from_date=$payroll_period_dates->complete_from;
				    $f_month= substr($from_date, 5,2);
				    $f_day=substr($from_date, 8,2);
				    $f_year=substr($from_date, 0,4);

				    $to_date=$payroll_period_dates->complete_to;
				    $t_month= substr($to_date, 5,2);
				    $t_day=substr($to_date, 8,2);
				    $t_year=substr($to_date, 0,4);

		    		$ppdate= date("F", mktime(0, 0, 0, $f_month, 10))." ". $f_day.", ". $f_year . " To ". date("F", mktime(0, 0, 0, $t_month, 10))." ". $t_day.", ". $t_year;

		    		$group_name = $this->other_deduction_manual_upload_model->get_group_name($group);

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
				<center><h2>'.$action_result.' Other deduction Employee Enrollment</h2></center>
				<table style="width:90%;margin-top:20px;margin-left:5%;margin-bottom:20px;" border="1">
				<thead>
					<tr>
						<th colspan="5" style="color:black;">
						<center>
						Payroll Period: '.$ppdate.' | 
						Group: '.$group_name.' 
						</center>
						</th>
					</tr>
					<tr>
						<th>Cell No.</th>
						<th>Employee ID</th>
						<th>Other deduction ID</th>
						<th>Amount</th>
						<th>Remarks</th>
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
								$other_deduction=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="2")
							{
								$amount=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							else {
							}

						    $colLetter++;
						}// col array


					$action_type=$this->input->post('action_type');
					$no = $row;
					?>
						<tr>
							<td>
								<?php echo $no;?>
							</td>
							<td>
								<?php
										echo $employee_id;
										$resultemployee_companylist = $this->other_deduction_manual_upload_model->check_employee_exist_in_company($employee_id,$company);
										if($resultemployee_companylist === false){
											echo "<br><n style='color:red';>Invalid Employee ID</n>";	
											$error = true;						
										} 
										else
										{
											$resultemployee_group = $this->other_deduction_manual_upload_model->check_employee_exist_in_group($employee_id,$company,$group);
											if($resultemployee_group===false)
												{
													echo "<br><n style='color:red';>Employee ID not exist in <br>selected payroll period group</n>";				
													$error = true;	
												}
										}
								?>
							</td>
							<td>
								<?php 
									echo $other_deduction;
									$checker_deduction = $this->other_deduction_manual_upload_model->checker_deduction($other_deduction,$company);
									if($checker_deduction===false)
									{
										echo "<br><n style='color:red';>Invalid Other deduction Type</n>";
										$error = true;
									}
									else
									{
										echo "<br>[".$checker_deduction."]";
									}
								?>
								
							</td>
							<td>
								<?php 
									echo $amount; 
									$check_amount = $this->containsDecimal($amount);
									if($check_amount === false)
									{
										echo "<br><n style='color:red';>Invalid Amount Format</n>";
										$error = true;		
									}
								?>
							</td>
							<td>
								<?php 
									if($action_result=='Review')
									{
										if($error==false){ echo "<n style='color:green';><i>no error</i></n>"; }
										else{ echo "<n style='color:red';><i>error</i></n>"; }	
									}
									else
									{
										if($option=='add')
										{
											if($error==false)
											{
												$insert_data = $this->other_deduction_manual_upload_model->insertMassdeduction($employee_id,$company,$group,$payroll_period,$amount,$other_deduction);
												if($insert_data=='saved')
												{
													echo "<n style='color:green';><i>Saved</i></n>";
												}else{}
											}
											else
											{
												echo "<n style='color:red';><i>correct first the error</i></n>";
											}
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


	function containsDecimal( $value ) {

	if ( strpos( $value, "." ) !== false ||  is_numeric($value) !==false) {
	        return true;
	    }
	    return false;
	}

}
