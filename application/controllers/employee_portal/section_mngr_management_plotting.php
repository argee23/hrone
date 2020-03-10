<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Section_mngr_management_plotting extends General {

	function __construct() {
		parent::__construct();	
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$this->load->model("employee_portal/section_mngr_management_plotting_model");
		$this->load->model("app/plot_schedules_model");
		$this->load->model("general_model");
			General::variable();	
	}

	//updated plotting of scehdule

	public function plot_schedule_dropdown($group_id)
    {
    	$this->data["group_id"] = $group_id;
		$this->data['emp']= $this->section_mngr_management_plotting_model->empselected($group_id);	
		$this->load->view('employee_portal/section_mngr_management/plot_schedule_dropdown' , $this->data);
    }

	public function previous_next($option,$month,$year,$group_id)
	{	
		if($option=='previous')
		{
			if($month=='01')
			{
				$m = '12';
			}
			else
			{
				$m = $month - 1;
			}
			if($month=='01')
			{
				$yy = $year - 1;
				$y = $yy;
			}
			else
			{
				$y = $year;
			}
		}
		else
		{
			if($month=='12')
			{
				$m = '1';
			}
			else
			{
				$m = $month + 1;
			}

			if($month=='12')
			{
				$yy = $year + 1;
				$y = $yy;
			}
			else
			{
				$y = $year;
			}
		}

	

		$this->data['fyear'] = $y;
		$this->data['fmonth'] = $m;
		$this->data['group_id'] = $group_id;
		$this->data['emp']= $this->section_mngr_management_plotting_model->empselected($group_id);
		$this->load->view('employee_portal/section_mngr_management/previous_next',$this->data);
	}


	public function save_employee_schedule($option)	
	{
		$group_id = $this->input->post('group');
		$emp= $this->section_mngr_management_plotting_model->empselected($group_id);
		$month = $this->input->post('month');
		$year = $this->input->post('year');
      
        $d=cal_days_in_month(CAL_GREGORIAN,$month,$year);
                      
        $date_from = $year.'-'.$month.'-01';
        $date_to = $year.'-'.$month.'-'.$d;

      
        $begin = new DateTime($date_from);
        $end = new DateTime($date_to);
        $end = $end->modify( '+1 day' );

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval ,$end);
        
        foreach($emp as $ee)
        {
	        foreach($daterange as $date)
	        {

	                $datef = $date->format('Y-m-d');
	                $day = $date->format('d');
	               	
	               	
	               		$employee_id  = $ee->employee_id;
	               		$data = $this->input->post($employee_id.'_'.$day);
	               		
	               		// if(!empty($data))
	               		// {
	               		// 	$insert = $this->section_mngr_management_plotting_model->insert_working_schedules($employee_id,$data,$datef,$month);
	               		// }

	               		if($ee->employee_id=='571000')
	               		{
	               			echo $data.'='.$ee->employee_id.'='.$datef.'<br>';
	               		}
	               		
	               		
	              
       		}
    	}
        if($option=='current_month')
        {
        	redirect(base_url().'employee_portal/section_mngr_management_plotting/plot_schedule_dropdown/'.$group_id,$this->data);
        }
        else
        {
        	$option = $this->input->post('option');
        	redirect(base_url().'employee_portal/section_mngr_management_plotting/plot_schedule_dropdown_after_save/'.$group_id.'/'.$month.'/'.$year.'/'.$option,$this->data);	
        }

		 	    
	}

	public function plot_schedule_dropdown_after_save($group_id,$month,$year,$option)
	{
		
		$month;
        $year = $year;
        $d=cal_days_in_month(CAL_GREGORIAN,$month,$year);

        $date_from = $year.'-'.$month.'-01';
        $date_to = $year.'-'.$month.'-'.$d;

        $this->data['date_from'] = $date_from;
        $this->data['date_to'] = $date_to;
        $this->data['year'] = $year;
		$this->data['month'] = $month;
		$this->data['group_id'] = $group_id;
		$this->data['option'] = $option;
		$this->data['emp']= $this->section_mngr_management_plotting_model->empselected($group_id);	
		$this->load->view('employee_portal/section_mngr_management/plot_schedule_dropdown_prev_next' , $this->data);

	}


	public function plot_schedule_dropdown_prev_next($group_id,$month,$year,$option)
	{
		if($option=='previous')
		{
			if($month=='01')
			{
				$m = '12';
			}
			else
			{
				$m = $month - 1;
			}
			if($month=='01')
			{
				$yy = $year - 1;
				$y = $yy;
			}
			else
			{
				$y = $year;
			}
		}
		else
		{
			if($month=='12')
			{
				$m = '1';
			}
			else
			{
				$m = $month + 1;
			}

			if($month=='12')
			{
				$yy = $year + 1;
				$y = $yy;
			}
			else
			{
				$y = $year;
			}
		}

	

		

		$month_ = $m;
        if($month_=='10' || $month_=='11' || $month_=='12'){ $month = $month_; } else{ $month = '0'.$month_; }
        $year = $y;
        $d=cal_days_in_month(CAL_GREGORIAN,$month,$year);

        $date_from = $year.'-'.$month.'-01';
        $date_to = $year.'-'.$month.'-'.$d;

        $this->data['date_from'] = $date_from;
        $this->data['date_to'] = $date_to;
        $this->data['year'] = $y;
		$this->data['month'] = $month;
		$this->data['group_id'] = $group_id;
		$this->data['option'] = $option;
		$this->data['emp']= $this->section_mngr_management_plotting_model->empselected($group_id);	
		$this->load->view('employee_portal/section_mngr_management/plot_schedule_dropdown_prev_next' , $this->data);

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

	public function excel_upload_schedule()
    {
    	$action_result = $this->input->post('action');
    	$group =  $this->input->post('group_id_modal');
    	
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
				<center><h2>Manual Excel Upload of Schedule</h2></center>
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


					
					
					$no = $row;
					?>
						<tr>
							<td>
								<?php echo $no;?>
							</td>
							<td>
								<?php echo $employee_id;
									$checker_employee_group = $this->section_mngr_management_plotting_model->checker_employee_group($group,$employee_id);

									if($checker_employee_group === false){
									 		echo "<br><n style='color:red';>Employee not found on this group.</n>";
									 		$error = true;	
									}
								?>
							</td>
							<td>
								<?php 
									echo $date;
									$check = $this->validateDate($date);
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
									
										
										if($error==false)
										{
												$insert_data = $this->section_mngr_management_plotting_model->insertWorkingSchedules($employee_id,$date,$shift_in,$shift_out,$restday);
											
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
								?>
							</td>
							
						</tr>
				
					<?php }

				echo '
				</tbody>
				</table>';
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