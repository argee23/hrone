<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 
	
class Upload_working_schedules extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/employee_model");
		$this->load->model("app/upload_working_schedules_model");
		$this->load->model("app/time_manual_attendance_model");
		$this->load->model("app/time_biometrics_setup_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}

	public function download_ws()
	{
		$this->load->helper('download');            
		$path    =   file_get_contents(base_url()."public/downloadable_templates/working_schedules.xlsx");
		$name    =   "working_schedules.xlsx";
		force_download($name, $path);
		$value = $name;
		General::logfile('Download Working Schedules Template','DOWNLOAD',$value); 
	}


	public function get_group($paytype,$company)
	{
		$paytype_group = $this->upload_working_schedules_model->get_paytype_group($paytype,$company);
		if(!empty($paytype_group))
		{
			echo "<option value=''>Select Group</option>";
			foreach($paytype_group as $pg)
			{
				echo "<option value='".$pg->payroll_period_group_id."'>".$pg->group_name."</option>";
			}
		}
		else
		{
			echo "<option value=''>No group found. Add first to continue.</option>";
		}
	}
		
	public function get_payroll_period($paytype,$company,$group)
	{
		$payroll_group = $this->upload_working_schedules_model->get_payroll_group($paytype,$company,$group);
		if(!empty($payroll_group))
		{
			echo "<option value=''>Select Payroll Period</option>";
			foreach($payroll_group as $per)
			{
				$from = $per->year_from .'-'. $per->month_from.'-'.$per->day_from;
                $to = $per->year_to .'-'. $per->month_to.'-'.$per->day_to;
                $formatted =  date("F d, Y", strtotime($from)) . " to " .  date("F d, Y", strtotime($to));
				echo "<option value='".$per->id."'>".$formatted."</option>";
			}
		}
		else
		{
			echo "<option value=''>No payroll period found. Add first to continue.</option>";
		}
	}




























    public function upload()
    {
    	$action_result = $this->input->post('action');
    	$company =  $this->input->post('company');
    	$group =  $this->input->post('group');
    	$payroll_period =  $this->input->post('payroll_period');
    	$option =  $this->input->post('option');
    	if($option=='reset_add')
    	{
    		$delete_payroll_period = $this->upload_working_schedules_model->delete_payroll_period($group,$company,$payroll_period);
    	
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

		            
		        $payroll_period_dates = $this->upload_working_schedules_model->get_payroll_period_dates($payroll_period);
		        $from_date=$payroll_period_dates->complete_from;
			    $f_month= substr($from_date, 5,2);
			    $f_day=substr($from_date, 8,2);
			    $f_year=substr($from_date, 0,4);

			    $to_date=$payroll_period_dates->complete_to;
			    $t_month= substr($to_date, 5,2);
			    $t_day=substr($to_date, 8,2);
			    $t_year=substr($to_date, 0,4);

	    		$ppdate= date("F", mktime(0, 0, 0, $f_month, 10))." ". $f_day.", ". $f_year . " To ". date("F", mktime(0, 0, 0, $t_month, 10))." ". $t_day.", ". $t_year;
				
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
				<center><h2>'.$action_result.' Working Schedule: '.$ppdate.'</h2></center>
				<table style="width:90%;margin-left:5%;margin-top:20px;margin-bottom:20px;" border="1">
				<thead>
					<tr>
						<th>Cell No.</th>
						<th>Employee ID</th>
						<th>Date<br>[yyyy-mm-dd]</th>
						<th>Restday<br>[yes or no]</th>
						<th>Shift IN <br>[hh:mm]</th>
						<th>Shift OUT <br>[hh:mm]</th>
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
								$date=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="2")
							{
								$restday=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="3")
							{
								$shift_in=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							}
							elseif($col=="4")
							{
								$shift_out=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
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
								<?php echo $employee_id;
								$resultemployee_companylist = $this->upload_working_schedules_model->check_employee_exist_in_company($employee_id,$company);
								if($resultemployee_companylist === false){
									echo "<br><n style='color:red';>Invalid Employee ID</n>";	
									$error = true;						
								}
								else
								{
									$resultemployee_group = $this->upload_working_schedules_model->check_employee_exist_in_group($employee_id,$company,$group);
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
									echo $date;
									$check = $this->validateDate($date);
									if($check === false)
									{
										echo "<br><n style='color:red';>Invalid Date Format</n>";
										$error = true;		
									}
									else
									{
										
										$date_payroll_period = $this->upload_working_schedules_model->check_exist_date_payroll_period($date,$payroll_period);
									    if($date_payroll_period === false)
									    {
									    	echo "<br><n style='color:red';>Date does not match the <br>payroll period range</n>";	
									    	$error = true;	
										}
									}
								?>
							</td>
							<td>
								<?php
									echo $restday;
									if ($restday!='yes' AND $restday!='no')
									{
										echo "<br><n style='color:red';>Invalid restday option</n>";
										$error = true;	
									}
								?>
							</td>
							<td>
								<?php
									echo $shift_in;
									if($restday=='yes')
									{
									 	if(!empty($shift_in))
										{
											echo "<br><n style='color:red';>Leave the shift in empty <br>if plotted schedule is restday</n>";
											$error = true;	
										}
									}
									else
									{
									 	$shift_in_checker = $this->validate_time($shift_in);
									 	if($shift_in_checker === false){
									 		echo "<br><n style='color:red';>Invalid Shift IN Format</n>";
									 		$error = true;	
										}
									}
								?>
							</td>
							<td>
								<?php
									echo $shift_out;
									if($restday=='yes')
									{
									 	if(!empty($shift_out))
										{
											echo "<br><n style='color:red';>Leave the shift out empty <br>if plotted schedule is restday</n>";
											$error = true;	
										}
									}
									else
									{
									 	$shift_out_checker = $this->validate_time($shift_out);
									 	if($shift_out_checker === false){
									 		echo "<br><n style='color:red';>Invalid Shift OUT Format</n>";
									 		$error = true;	
										}
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
										
										if($error==false)
										{
											$insert_data = $this->upload_working_schedules_model->insertWorkingSchedules($employee_id,$company,$date,$shift_in,$shift_out,$restday);
											
											if($insert_data=='saved')
											{

        General::logfile_time_ws($this->session->userdata('employee_id'),'UPLOAD WORKING SCHED','UPLOAD WORKING SCHED',$company.$date.$shift_in.$shift_out.$restday,$employee_id);  


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


	public function validate_time($shift_in)
	{
		if(strtotime($shift_in)) {
			$length =  strlen($shift_in);
			if($length==5)
			{
           		return true;
			}
			else
			{
				return false;
			}
        } else {
           return false;
        }
	}

}
