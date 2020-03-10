<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class My_staff_approved_ot extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/my_staff_approved_ot_model");
		$this->load->model("general_model");

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		
		General::variable();
	}
	
	public function index()
	{
		$this->data['plotted'] = $this->my_staff_approved_ot_model->plotted_details();
		$this->data['group_members'] = $this->my_staff_approved_ot_model->group_members_checker();
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/my_staff/approved_ot/approved_overtime', $this->data);
		$this->load->view('employee_portal/footer');		
	}	


	public function add_new_group()
	{

		$this->load->view('employee_portal/my_staff/approved_ot/add_new_group', $this->data); 
	}

	//add new group

	public function save_approved_ot_group()
	{
		$insert = $this->my_staff_approved_ot_model->save_approved_ot_group();
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Approved OT Group is Successfully Added!</div>");

		redirect(base_url().'employee_portal/my_staff_approved_ot/index',$this->data);
	}


	//update group name

	public function edit_group_approved_ot($id,$date)
	{
		$this->data['id'] = $id;
		$this->data['details'] = $this->my_staff_approved_ot_model->edit_group_approved_ot($id);
		$this->load->view('employee_portal/my_staff/approved_ot/edit_group_approved_ot', $this->data); 
	}

	//save updaye group name

	public function save_update_approved_ot_group()
	{
		$insert = $this->c->save_update_approved_ot_group();
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Approved OT Group is Successfully Updated!</div>");

		redirect(base_url().'employee_portal/my_staff_approved_ot/index',$this->data);
	}

	//view approved ot members
	public function view_approved_ot($id,$date)
	{
		$this->data['id'] = $id;
		$this->data['plotted'] = $this->my_staff_approved_ot_model->view_approved_ot($id,$date);
		$this->load->view('employee_portal/my_staff/approved_ot/approved_overtime_employee', $this->data);
	}

	//delete group 
	public function delete_approved_ot($id,$date)
	{
		$delete = $this->my_staff_approved_ot_model->delete_approved_ot($id);
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Approved OT Group ID ".$id." is Successfully Deleted!</div>");
	}














	

	public function get_employees($date)
	{
		$this->data['date']=$date;
		$this->data['group_members'] = $this->my_staff_approved_ot_model->group_members();
		$this->load->view('employee_portal/my_staff/approved_ot/general_allowed_overtime_members', $this->data); 
	}

	

	public function save_approved_ot($emp,$hrs,$reason,$count,$date)
	{
		$insert = $this->my_staff_approved_ot_model->save_approved_ot($emp,$hrs,$reason,$count,$date);
	}


	public function add_member_approved_ot($id,$date)
	{
		$this->data['id']=$id;
		$this->data['date']=$date;
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['check'] = $this->session->flashdata('check');
		$this->data['reason']=$this->my_staff_approved_ot_model->get_ot_reason($id);
		$this->data['group_members'] = $this->my_staff_approved_ot_model->group_members();
		$this->data['selected_group_member'] = $this->my_staff_approved_ot_model->selected_group_member($id);
		$this->load->view('employee_portal/my_staff/approved_ot/add_member_approved_ot', $this->data); 

	}

	public function add_member_save_pre_approved($id,$date,$hours,$employee,$count,$reason)
	{
		$insert = $this->my_staff_approved_ot_model->add_member_save_pre_approved($id,$date,$hours,$employee,$count,$reason);
	}

	//delete
	public function delete_approved_ot_member($id,$idd,$date)
	{
		$delete = $this->my_staff_approved_ot_model->delete_approved_ot_member($id);
		$this->session->set_flashdata('onload',"view_approved_ot('".$idd."','".$date."')");
	}

	//upload 
	public function upload_approved_ot_group($id,$date)
	{
		$this->data['id'] = $id;
		$this->data['date'] = $date;
		$this->load->view('employee_portal/my_staff/approved_ot/upload_approved_ot_group', $this->data);
	}



	public function download_ot_approved()
	{
		 $this->load->helper('download');            
		$path    =   file_get_contents(base_url()."public/downloadable_templates/approved_ot_template.xlsx");
		$name    =   "approved_ot_template.xlsx";
		force_download($name, $path); 
		$value = $name;
		General::logfile('Approved Overtime Template','DOWNLOAD',$value);
	}
	
	function containsDecimal( $value ) {

	if ( strpos( $value, "." ) !== false ||  is_numeric($value) !==false) {
	        return true;
	    }
	    return false;
	}

	public function save_upload_approved_ot_group()
    {
    	
    		$action = $_POST['action'];
			$id = $_POST['id'];
			$date = $_POST['date'];

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
						'; if($action=='Save'){ echo '<h2><center>Save Approved OT hours</center></h2>'; } else echo '<h2><center>Review Approved OT hours</center></h2>';
						echo '<table style="width:90%;margin-left:5%;margin-top:20px;margin-bottom:20px;" border="1">
						<thead>
							</tr>
							<tr>	
								  <th>No</th>
								  <th>Employee ID</th>
								  <th>Shift</th>
								  <th>Attendance</th>
				                  <th>OT hours</h4></th>
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
										$ot_hour=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
									}
									else
									{

									}

								    $colLetter++;
								}// col array


							
							$no = $row;
							$error =false;
							?>
								<tr>
									<td><?php echo $no;?></td>
									<td>

										<?php 
												$name = $this->my_staff_approved_ot_model->employee_name($employee_id);
												echo $employee_id.' ('.$name.')';
												$check_employee = $this->my_staff_approved_ot_model->check_employee_under_sm($employee_id);

												if($check_employee == false) 
												{
													echo "<br><n style='color:red';>[You're not allowed to file approved ot]</n>";	
													$error = true;	
												}
												else
												{
													$check_employee_existing_ot_hr = $this->my_staff_approved_ot_model->check_employee_with_existing_ot_hr($employee_id,$date,$id);
													if(empty($check_employee_existing_ot_hr))
													{
															$check_employee_existing = $this->my_staff_approved_ot_model->check_employee_with_existing($employee_id,$date,$id);
															if(!empty($check_employee_existing))
															{
																echo "<br><n style='color:green';>["; foreach($check_employee_existing as $o){ echo 'With <b>'.$o->hours.' hr/s</b> approved ot. System will overwrite the existing OT';  } echo "]</n>";	
															}
													}
													else
													{
														echo "<br><n style='color:red';>[Employee has existing approved OT already. Filed by "; foreach($check_employee_existing_ot_hr as $o){ echo '<b>'.$o->plotted_by.' ['.$o->group_name.']</b> with <b>'.$o->hours.'</b> approved ot';  } echo "]</n>";	
														$error = true;	
													}
												}
										?>
											
									</td>
									<td>
										<?php
					                        $datef = $date;
					                        $m =  date("m", strtotime($datef));
					                        $yy =  date("Y", strtotime($datef));
					                        			$attendance = $this->my_staff_approved_ot_model->get_employee_attendance($employee_id,$date);
					                                    $individual_schedules = $this->my_staff_approved_ot_model->get_individual_schedules($employee_id,$datef,$m,$yy);
					                                    if(!empty($individual_schedules))
					                                    {
					                                      $schedule_result=$individual_schedules;
					                                      $schedule_type="individual";
					                                    }
					                                    else
					                                    {
					                                      $fixed_schedules = $this->my_staff_approved_ot_model->checker_if_fixed_sched($employee_id,$datef);
					                                      if(!empty($fixed_schedules))
					                                      {
					                                        $schedule_result=$fixed_schedules;
					                                         $schedule_type="fixed";
					                                      }
					                                      else
					                                      {
					                                          $group_schedules = $this->my_staff_approved_ot_model->checker_if_group_sched($employee_id,$datef);
					                                          if(!empty($group_schedules))
					                                          {
					                                            $schedule_result=$group_schedules;
					                                             $schedule_type="group";
					                                          }
					                                          else
					                                          {
					                                            $schedule_result="";
					                                             $schedule_type="no_schedule";
					                                          }
					                                      }
					                                    }

					                                    if(!empty($schedule_result))
					                                            {
					                                              $schedule="";
					                                              foreach($schedule_result as $sched)
					                                              {
					                                               
					                                                if($schedule_type=='fixed')
					                                                {  
					                                                  $day  =  date("D", strtotime($datef)); 
					                                                  $day_ =  strtolower($day);
					                                                  if($day_=='restday'){  $schedule = 'restday'; } else {  $schedule = $sched->$day_; }
					                                                }
					                                                else
					                                                {   
					                                                   if($sched->restday==1)
					                                                    { $schedule = "restday"; } else{  $schedule=$sched->shift_in.' to '.$sched->shift_out; }
					                                                }
					                                              } 
					                                            }
					                                            else
					                                            {
					                                              $schedule =" No Plotted Schedule";
					                                            }
					                                    echo $schedule;

					                   ?>  
									</td>
									<td>
											 <?php if(!empty($attendance)){ foreach($attendance as $a){ if(!empty($a->time_in)){ echo "<b>&nbsp;IN &nbsp;&nbsp;&nbsp;&nbsp;: </b> ".$a->time_in; } echo "<br>"; if(!empty($a->time_out)){ echo "<b>&nbsp;OUT :</b> ".$a->time_out; } } } else { } ?>

									</td>
									<td>
										<?php 
												echo $ot_hour;
												$checker_ot_hour = $this->containsDecimal($ot_hour);
												if($checker_ot_hour === false){
													echo "<br><n style='color:red';>Number and Decimal Only/Characters are not allowed</n>";	
													$error = true;	
												}

										?>
											
									</td>
									<td>
										<?php if($action=='Save')
										{

											if($error==false)
											{

												$insert_data = $this->my_staff_approved_ot_model->insert_approved_ot($id,$date,$employee_id,$ot_hour);
												if($insert_data=='inserted')
													 {
														echo "<n style='color:green';><i>Saved</i></n>";
													 } 
												else { echo "<n style='color:red';><i>Error</i></n>"; }
											}
											else
											{
												echo "<n style='color:red';><i>Error</i></n>";
											}
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

	public function save_ot_approved_ot($id,$date)
	{

		$insert = $this->my_staff_approved_ot_model->saveapproved_ot($id,$date);
		$this->session->set_flashdata('check',"1");
		$this->session->set_flashdata('onload',"checker()");
		redirect(base_url().'employee_portal/my_staff_approved_ot/add_member_approved_ot/'.$id.'/'.$date,$this->data);
	}

	public function get_filtered_approved_ot($from,$to)
	{
		$this->data['plotted'] = $this->my_staff_approved_ot_model->get_filtered_approved_ot($from,$to);
		$this->load->view('employee_portal/my_staff/approved_ot/filtered_approved_ot', $this->data);
	}

	public function employee_approved_ot($employee_id,$date)
	{
		$this->data['plotted'] = $this->my_staff_approved_ot_model->employee_approved_ot($employee_id,$date);
		$this->load->view('employee_portal/my_staff/approved_ot/employee_approved_ot', $this->data);
	}

}