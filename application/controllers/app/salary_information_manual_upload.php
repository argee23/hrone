<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 
	
class Salary_information_manual_upload extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/salary_information_manual_upload_model");
		$this->load->model("general_model");
		$this->load->dbforge();
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}

	public function salary_information_manualupload_template()
	{

        $this->load->helper('download');            
		$path    =   file_get_contents(base_url()."public/downloadable_templates/salary_information_manual_upload.xlsx");
		$name    =   "salary_information_manual_upload.xlsx";
		force_download($name, $path); 
		$value = $name;
		General::logfile('Employee Personal Info Template','DOWNLOAD',$value);
	}

	
    public function upload()
    {
    	$action_result = $this->input->post('action');
    	$company =  $this->input->post('company');
    	$option =  $this->input->post('option');

    	if($option=='reset')
    	{
    		$delete_salary = $this->salary_information_manual_upload_model->delete_salary($company);
    	
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
				<center><h2>'.$action_result.' Company Salary Information</h2></center>
				<table style="width:100%;margin-top:20px;margin-bottom:20px;" border="1">
				<thead>
					<tr>
						<th>Cell No.</th>
						<th>Employee ID</th>
						<th>Salary Date Effective</th>
						<th>Salary Rate</th>
						<th>Salary Amount</th>
						<th>No. of Hours a day</th>
						<th>No. of days a month</th>
						<th>No. of days a year</th>
						<th>Reason</th>
						<th>Is salary fixed?</th>
						<th>Will deduct withholding tax? </th>
						<th>Will deduct Pagibig</th>
						<th>Will deduct SSS</th>
						<th>Will deduct Philhealth</th>
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
								$date_effective=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="2")
							{
								$salary_rate=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="3")
							{
								$salary_amount=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="4")
							{
								$hours_day=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="5")
							{
								$days_month=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="6")
							{
								$days_year=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="7")
							{
								$reason=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="8")
							{
								$fixed=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							
							elseif($col=="9")
							{
								$withholding=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="10")
							{
								$pagibig=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="11")
							{
								$sss=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="12")
							{
								$philhealth=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
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
										$resultemployee_companylist = $this->salary_information_manual_upload_model->check_employee_exist_in_company($employee_id,$company);
										if($resultemployee_companylist === false){
											echo "<br><n style='color:red';>Invalid Employee ID</n>";	
											$error = true;						
										} 
								?>
							</td>
							<td>
								<?php 
									echo $date_effective; 
									$check_date = $this->validateDate($date_effective);
									if($check_date === false)
									{
										echo "<br><n style='color:red';>Invalid Date Format</n>";
										$error = true;		
									}
								?>
							</td>
							<td>
								<?php 
									echo $salary_rate; 
									$check_salary_rate = $this->salary_information_manual_upload_model->check_salary_rate($salary_rate);
									if($check_salary_rate===false)
									{
										echo "<br><n style='color:red';>Invalid Salary Rate</n>";
									 	$error = true;	
									}
								?>
							</td>
							<td>
								<?php 
									echo $salary_amount; 
									$checker_salary_amount = $this->containsDecimal($salary_amount);
									if($checker_salary_amount===false)
									{
										echo "<br><n style='color:red';>Invalid Format</n>";
									 	$error = true;
									}
								?>
							</td>
							<td>
								<?php 
									echo $hours_day; 
									$checker_hours_day = $this->containsDecimal($hours_day);
									if($checker_hours_day===false)
									{
										echo "<br><n style='color:red';>Invalid Format</n>";
									 	$error = true;
									}
								?>
							</td>
							<td>
								<?php 
									echo $days_month; 
									$checker_days_month = $this->containsDecimal($days_month);
									if($checker_days_month===false)
									{
										echo "<br><n style='color:red';>Invalid Format</n>";
									 	$error = true;
									}
								?>
							</td>
							<td>
								<?php 
									echo $days_year; 
									$checker_days_year= $this->containsDecimal($days_year);
									if($checker_days_year===false)
									{
										echo "<br><n style='color:red';>Invalid Format</n>";
									 	$error = true;
									}
								?>
							</td>
							<td>
								<?php 
									  echo $reason; 
									  $reason_checker = $this->salary_information_manual_upload_model->check_reason_mngt($reason,$company);
									  if($reason_checker===false)
									  	{
									  		echo "<br><n style='color:red';>Invalid Reason</n>";
									 		$error = true;
									  	}
								?>
							</td>
							<td>
								<?php echo $fixed;
									if($fixed!='yes' AND $fixed!='no')
									{
										echo "<br><n style='color:red';>Invalid <br>[yes or no only]</n>";
									 	$error = true;
									}
								?>
							</td>
							<td>
								<?php 
										echo $withholding; 
										if($withholding!='yes' AND $withholding!='no')
										{
											echo "<br><n style='color:red';>Invalid <br>[yes or no only]</n>";
										 	$error = true;
										}
								?>
							</td>
							<td>
								<?php 
										echo $pagibig;
										if($pagibig!='yes' AND $pagibig!='no')
										{
											echo "<br><n style='color:red';>Invalid<br> [yes or no only]</n>";
										 	$error = true;
										} 
								?>
							</td>
							<td>
								<?php 
										echo $sss; 
										if($sss!='yes' AND $sss!='no')
										{
											echo "<br><n style='color:red';>Invalid<br> [yes or no only]</n>";
										 	$error = true;
										} 
								?>
							</td>
							<td>
								<?php 
										echo $philhealth; 
										if($philhealth!='yes' AND $philhealth!='no')
										{
											echo "<br><n style='color:red';>Invalid<br> [yes or no only]</n>";
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
									if($option=='overwrite_add')
									{
										$insert_data = $this->upload_working_schedules_model->insertWorkingSchedules($employee_id,$company,$date,$shift_in,$shift_out,$restday);
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
									else
									{
										
										if($error==false)
										{
											$insert_data = $this->salary_information_manual_upload_model->insertSalaryInfo($employee_id,$company,$date_effective,$salary_rate,$salary_amount,$hours_day,$days_month,$days_year,$reason,$fixed,$withholding,$pagibig,$sss,$philhealth,$option);
											
											if($insert_data=='saved')
											{
												echo "<n style='color:green';><i>Saved</i></n>";

											} else{}
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
