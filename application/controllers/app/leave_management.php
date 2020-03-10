<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Leave_management extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/leave_management_model");
		$this->load->model("app/leave_type_model");
		$this->load->model("app/transaction_employees_model");
		$this->load->model("app/user_model");
		$this->load->model("general_model");
		$this->load->library('PHPExcel/IOFactory');
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index(){	
		
			// user restriction function
		// $this->session->set_userdata('page_name','leave_management_li');
		// $page_id = $this->general_model->getPageID();
		// $userRole = $this->general_model->getUserLoggedIn($this->session->userdata('username'));
		// if(General::has_rights_to_access($page_id->page_id,$userRole->user_role) == FALSE){
		
		// $value = "leave type";
		// General::logfile('leave type','TRY TO ACCESS',$value);	
		// redirect(base_url().'access_denied');//app/dashboard
		// 	}
		// // end of user restriction function
		// $this->session->set_userdata(array(
		// 		 'tab'			=>		'administrator',
		// 		 'module'		=>		'user_management',
		// 		 'subtab'		=>		'',
		// 		 'submodule'	=>		''));
		//$this->load->view('app/administrator/user/user_management',$this->data);
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');		
		$this->leave_type_list();
	
	}	

	public function leave_type_list(){
		
		$this->data['leave_type'] = $this->leave_management_model->getAll();
		$this->load->view('app/leave_management/index',$this->data);
	}


	public function leave_type_list2(){
		$company_id=$this->uri->segment("4");
		$this->data['leave_type'] = $this->leave_management_model->leave_per_company($company_id);//$company_id
			$this->data['default_leave_type'] = $this->leave_type_model->get_default_leave_type();
		$this->load->view('app/leave_management/company_leave_list',$this->data);
	}

	public function leave_manage_manual_credit(){
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');				
		$id=$this->uri->segment("4");
		$company_id=$this->uri->segment("5");
		$isIL=$this->leave_management_model->checkifDef($id);
		if(!empty($isIL)){
					if($isIL->is_system_default=="1"){
						$this->data['emp_list'] = $this->leave_management_model->getILemployees($company_id);
					}else{
						$this->data['emp_list'] = $this->leave_management_model->get_employees($company_id);
					}
		}else{
					$this->data['emp_list'] = $this->leave_management_model->get_employees($company_id);
		}
	
		
		
		$this->data['leave_type'] = $this->leave_management_model->getLeaveType($id);
		$this->load->view('app/leave_management/manual_credit',$this->data);
	}

	public function save_manual_credit(){

		$year=date('Y');//$this->input->post('cutoff');
		$leave_id=$this->input->post('leave_id');
		$company_id=$this->input->post('company_id');

		if (is_array($this->input->post('employee_id')))
		{
			foreach ($this->input->post('employee_id') as $key => $emp)
			{	
				if(is_numeric($this->input->post('credit_'.$emp))){
					$credit=$this->input->post('credit_'.$emp);
					if($credit>=0){
						//echo "$emp | $credit | $leave_id | $year <br>";

						$data_save = array(
						"leave_type_id"				=>		$leave_id,	
						"employee_id"				=>		$emp,
						"available"					=>		$credit,
						"year"						=>		$year,
						"is_manual_credit"			=>		'1',
						"insert_date"				=>		date('Y-m-d H:i:s')
						);

						$query=$this->db->query("delete from leave_allocation where leave_type_id='".$leave_id."' AND employee_id='".$emp."' and year='".$year."' ");
						$this->leave_management_model->save_manual_credit($data_save);

			// logfile
			$value = "$leave_id|$emp|$credit|$year ";
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Leave','Credit Management','logfile_admin_leave_management','encode manual leave credit','INSERT',$value);




					}else{

					}
					
				}else{
					//dont allow to file.
						$query=$this->db->query("delete from leave_allocation where leave_type_id='".$leave_id."' AND employee_id='".$emp."' and year='".$year."' ");
				}			
			}
		}else{
			//echo "not array";
		}
		
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Credits</strong> is Successfully Encoded!</div>");

				$this->session->set_flashdata('onload',"fetch_comp_leave(".$company_id.")");
		redirect(base_url().'app/leave_management/index/');


	}
	public function leave_manage_condition(){
		$id=$this->uri->segment("4");
		$company_id=$this->uri->segment("5");
		$this->data['leave_type'] = $this->leave_management_model->getLeaveType($id);
		$this->load->view('app/leave_management/manage',$this->data);
	}
	public function dl_upl_leavecredit(){
		$id=$this->uri->segment("4");
		$company_id=$this->uri->segment("5");
		$this->data['leave_type'] = $this->leave_management_model->getLeaveType($id);


		$this->load->view('app/leave_management/download_upload_leave_credit',$this->data);
	}

	public function manual_upload_leave_credit(){//gel

		$action=$this->input->post('action');
		$leave_type=$this->input->post('leave_type');
		$leave_id=$this->input->post('leave_id');
		$cover_year=$this->input->post('cover_year');


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

							echo '
							<table style="width:100%;" border="1">
							<thead>
								<tr>
									<th colspan="11" style="color:#ff0000;">You are Manual Uploading the Manual Credits of '.$leave_type.' for the year '.$cover_year.'</th>
								</tr>
								<tr>
									<th>Employee ID</th>
									<th>Leave Credits</th>
									<th>Remarks</th>
									<th>Action</th>
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
					$leave_credit=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
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

				if($leave_credit>=0){
					
				}else{
					$row_error_message="Leave Credit Seems Incorrect $leave_credit";
				}

			if($action=="Save"){

				if($row_error_message==""){
								$query = $this->db->query("DELETE FROM leave_allocation WHERE employee_id='".$employee_id."' AND year='".$cover_year."'");

									$manual_leave_credits = array(
										'employee_id'	=> $employee_id,
										'leave_type_id'	=> $leave_id,
										'available'	=> $leave_credit,
										'year'	=> $cover_year,
										'insert_date'	=> date('Y-m-d H:i:s'),
										'last_update'	=> date('Y-m-d H:i:s'),
										'is_starting_credit'	=> '',
										'is_manual_credit'	=> '1',
										'programmer_comment'	=> 'manual upload leave credits'
									);
								$insert = $this->leave_management_model->insert_leave_credits($manual_leave_credits);						
								$action_result="Saved";
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Leave','Credit Management','logfile_admin_leave_management','upload manual leave credit for leave('.$leave_type.')|id:'.$leave_id.'|'.$employee_id,'DELETE',$leave_credit);


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
if(empty($employee_id)){

}else{
			echo '
				<td>'.$employee_id.'</td>
				<td>'.$leave_credit.'</td>
				<td '.$warning_hylight.'>'.$row_error_message.'</td>
				<td>'.$action_result.'</td>
				</tr>
			';	
}



							}//row array
			echo '
			</tbody>
			</table>

			';


			}//if import end



	}


	public function details(){	
	
		$current_leave_id = $this->uri->segment("4");
		$current_emp = $this->uri->segment("5");
		// user restriction function
		// $this->session->set_userdata('page_name','user_management_li');
		// $page_id = $this->general_model->getPageID();
		// $userRole = $this->general_model->getUserLoggedIn($this->session->userdata('username'));
		// if(General::has_rights_to_access($page_id->page_id,$userRole->user_role) == FALSE){
		
		// $value = "user management";
		// General::logfile('user management','TRY TO ACCESS',$value);	
		// redirect(base_url().'access_denied');//app/dashboard
		// 	}
		// // end of user restriction function
		// $this->session->set_userdata(array(
		// 		 'tab'			=>		'administrator',
		// 		 'module'		=>		'user_management',
		// 		 'subtab'		=>		'',
		// 		 'submodule'	=>		''));

		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');		

		$ccc="";       //important  classifications  
		$leaveclass = $this->leave_management_model->check_leave_classification($current_leave_id);
		$array_items = count($leaveclass);
			foreach($leaveclass as $leave_class){ 
			if($leave_class->classification==$array_items){
				$operator="OR";
			}else{
				$operator="OR";
			}

		$ccc.="a.classification=".$leave_class->classification." " .$operator." ";
		}         

$classifications = substr($ccc, 0, -4);  // remove or sa dulo

		$eee="";       //important      employement       
		$leaveEmp = $this->leave_management_model->check_leave_employment($current_leave_id);
		$array_items = count($leaveEmp);
			foreach($leaveEmp as $leave_emp){ 
				if($leave_emp->employment==$array_items){
			$operator="OR";
				}else{
			$operator="OR";
			}

		$eee.="a.employment=".$leave_emp->employment." " .$operator." ";
		}   
$employments = substr($eee, 0, -4);  // remove or sa dulo

		$lll = "";       //important   locations       
		$leaveloc = $this->leave_management_model->check_leave_location($current_leave_id);
		$array_items = count($leaveloc);
			foreach($leaveloc as $leave_location){ 
				if($leave_location->location==$array_items){
			$operator="OR";
				}else{
			$operator="OR";
			}

		$lll.="a.location= ".$leave_location->location." " .$operator." ";
$locations = substr($lll, 0, -4);  // remove or sa dulo
		}     

		$this->data['emp'] = $this->leave_management_model->getEmployees($classifications,$employments,$locations);		
		
		$this->load->view('app/leave_management/details',$this->data);
	}
	public function search(){
		$current_leave_id = $this->uri->segment("13");
		//$current_emp = $this->uri->segment("5");
		// user restriction function
		// $this->session->set_userdata('page_name','user_management_li');
		// $page_id = $this->general_model->getPageID();
		// $userRole = $this->general_model->getUserLoggedIn($this->session->userdata('username'));
		// if(General::has_rights_to_access($page_id->page_id,$userRole->user_role) == FALSE){
		
		// $value = "user management";
		// General::logfile('user management','TRY TO ACCESS',$value);	
		// redirect(base_url().'access_denied');//app/dashboard
		// 	}
		// // end of user restriction function
		// $this->session->set_userdata(array(
		// 		 'tab'			=>		'administrator',
		// 		 'module'		=>		'user_management',
		// 		 'subtab'		=>		'',
		// 		 'submodule'	=>		''));

		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');		

		$classifications="";       //important    
		    $leaveclass = $this->leave_management_model->check_leave_classification($current_leave_id);
		    $array_items = count($leaveclass);
		      foreach($leaveclass as $leave_class){ 
		      if($leave_class->classification==$array_items){
		        $operator="";
		      }else{
		        $operator=" OR";
		      }
		$classifications.=" classification=".$leave_class->classification. $operator;
		    }       
		$final_classifications=$classifications;

		$employments="";       //important             
		    $leaveEmp = $this->leave_management_model->check_leave_employment($current_leave_id);
		    $array_items = count($leaveEmp);
		      foreach($leaveEmp as $leave_emp){ 
		        if($leave_emp->employment==$array_items){
		      $operator="";
		        }else{
		      $operator=" OR";
		      }
		   $employments.=" employment=".$leave_emp->employment. $operator;
		    }   

    	$final_employments=$employments;

		$locations = "";       //important          
		$leaveloc = $this->leave_management_model->check_leave_location($current_leave_id);
		$array_items = count($leaveloc);
			foreach($leaveloc as $leave_location){ 
				if($leave_location->location==$array_items){
			$operator="";
				}else{
			$operator=" OR";
			}

		$locations.=" location=".$leave_location->location. $operator;
		}
		$final_locations=$locations;


		$this->data['emp'] = $this->leave_management_model->search_employee($final_classifications,$final_employments,$final_locations); 
		$this->data['message'] = $this->session->flashdata('message');		 
		$this->load->view('app/leave_management/search',$this->data);	
	}
	public function get_section2(){
		$dept_id = $this->uri->segment("4");

		$this->data['get_section'] = $this->leave_management_model->get_section($dept_id);
		$this->load->view('app/leave_management/section_list2',$this->data);
	}
	public function edit_details(){	
	
		$current_leave_id = $this->uri->segment("4");
		$current_emp = $this->uri->segment("5");


		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');		

		$classifications="";       //important    
		$leaveclass = $this->leave_management_model->check_leave_classification($current_leave_id);
		$array_items = count($leaveclass);
			foreach($leaveclass as $leave_class){ 
			if($leave_class->classification==$array_items){
				$operator="";
			}else{
				$operator="OR";
			}

		$classifications.="classification=".$leave_class->classification." " .$operator." ";
		}         

		$employments="";       //important             
		$leaveEmp = $this->leave_management_model->check_leave_employment($current_leave_id);
		$array_items = count($leaveEmp);
			foreach($leaveEmp as $leave_emp){ 
				if($leave_emp->employment==$array_items){
			$operator="";
				}else{
			$operator="OR";
			}

		$employments.="employment=".$leave_emp->employment." " .$operator." ";
		}   

		$locations = "";       //important          
		$leaveloc = $this->leave_management_model->check_leave_location($current_leave_id);
		$array_items = count($leaveloc);
			foreach($leaveloc as $leave_location){ 
				if($leave_location->location==$array_items){
			$operator="";
				}else{
			$operator="OR";
			}

		$locations.="location=".$leave_location->location." " .$operator." ";

		}     

		$this->data['emp'] = $this->leave_management_model->getEmployees($classifications,$employments,$locations);		
		
		$this->load->view('app/leave_management/details',$this->data);
	}
	public function leave_usage(){	
		$current_leave_id = $this->uri->segment("4");
		$current_emp = $this->uri->segment("5");
		$date_employed = $this->uri->segment("7");

		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		$this->data['date_employed'] = $date_employed;		

   		$leave=$this->leave_management_model->getLeaveType($current_leave_id);
		$this->data['emp'] = $this->leave_management_model->get_employee_leave_usage($current_emp,$current_leave_id,$date_employed,$leave->cutoff);	


		$this->load->view('app/leave_management/leave_usage',$this->data);
		//$this->load->view('app/leave_management/employees',$this->data);
	}
	public function applied_condition(){	
		$current_leave_id = $this->uri->segment("4");


		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');		

		$classifications="";       //important    
		$leaveclass = $this->leave_management_model->check_leave_classification($current_leave_id);
		$array_items = count($leaveclass);
			foreach($leaveclass as $leave_class){ 
			if($leave_class->classification==$array_items){
				$operator="";
			}else{
				$operator="OR";
			}

		$classifications.="classification=".$leave_class->classification." " .$operator." ";
		}         

		$employments="";       //important             
		$leaveEmp = $this->leave_management_model->check_leave_employment($current_leave_id);
		$array_items = count($leaveEmp);
			foreach($leaveEmp as $leave_emp){ 
				if($leave_emp->employment==$array_items){
			$operator="";
				}else{
			$operator="OR";
			}

		$employments.="employment=".$leave_emp->employment." " .$operator." ";
		}   

		$locations = "";       //important          
		$leaveloc = $this->leave_management_model->check_leave_location($current_leave_id);
		$array_items = count($leaveloc);
			foreach($leaveloc as $leave_location){ 
				if($leave_location->location==$array_items){
			$operator="";
				}else{
			$operator="OR";
			}

		$locations.="location=".$leave_location->location." " .$operator." ";

		}     

		$this->data['emp'] = $this->leave_management_model->getEmployees($classifications,$employments,$locations);		
		$this->load->view('app/leave_management/applied_condition',$this->data);
		//$this->load->view('app/leave_management/employees',$this->data);
	}
	public function download_leave_template () {
		
        $this->load->helper('download');            
		$path    =   file_get_contents(base_url()."public/downloadable_templates/leave_template.xls");
		$name    =   "leave_template.xls";
		force_download($name, $path); 

		$value = $name;

		General::logfile('Leave Template','DOWNLOAD',$value);
                             
        }
    public function export_to_excel_leave () {
		
		$current_leave_id= $this->uri->segment("4");
		$current_leave_start_value= $this->uri->segment("5");
		$eff=$this->uri->segment("6");
		$current_leave_type=$this->uri->segment("7");

		$trimmed_leave_type = urldecode($current_leave_type);

		 //$leave_details = $this->leave_management_model->get_leave_details($current_leave_id);

		$ccc="";       //important    
		$leaveclass = $this->leave_management_model->check_leave_classification($current_leave_id);
		$array_items = count($leaveclass);
			foreach($leaveclass as $leave_class){ 
			if($leave_class->classification==$array_items){
				$operator="";
			}else{
				$operator="OR";
			}

		$ccc.="a.classification=".$leave_class->classification." " .$operator." ";
		}         
$classifications = substr($ccc, 0, -4);  // remove or sa dulo
		$eee="";       //important             
		$leaveEmp = $this->leave_management_model->check_leave_employment($current_leave_id);
		$array_items = count($leaveEmp);
			foreach($leaveEmp as $leave_emp){ 
				if($leave_emp->employment==$array_items){
			$operator="";
				}else{
			$operator="OR";
			}

		$eee.="a.employment=".$leave_emp->employment." " .$operator." ";
		}   
$employments = substr($eee, 0, -4);  // remove or sa dulo
		$lll = "";       //important          
		$leaveloc = $this->leave_management_model->check_leave_location($current_leave_id);
		$array_items = count($leaveloc);
			foreach($leaveloc as $leave_location){ 
				if($leave_location->location==$array_items){
			$operator="";
				}else{
			$operator="OR";
			}

		$lll.="a.location=".$leave_location->location." " .$operator." ";
		}  
$locations = substr($lll, 0, -4);  // remove or sa dulo
		// $classifications=substr($classifications, 0, -3);
		// $employments=substr($employments, 0, -3);

		$this->load->helper('download');

		$query = $this->leave_management_model->getEmployees($classifications,$employments,$locations);

		$tmpl = array('table_open' => '<table border="2" class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");

		// $this->table->set_heading('Employee ID','Employee Name','Date Hired','Years Of Stay','Classification','Employment','Location','Credit Balance yearly','Leave Used','Available Leave');

		$i = 0 + $offset;

		$cell_data = array(
		'data' => $trimmed_leave_type.' Details',
		'style'	=>	'font-size:20px;font-weight:bold;',
		'align'	=>	'center',
		'colspan' => 10
		);
		$this->table->add_row($cell_data);

		$this->table->add_row('Employee ID','Employee Name','Date Hired','Years Of Stay','Classification','Employment','Location','Credit Balance yearly','Leave Used','Available Leave');

	
		foreach ($query as $employee)
		{

			$classification=$employee->classification;
			$cl = $this->general_model->get_the_classification($classification);

				$emp_=$employee->employment;
		
				$employee->employment_name;
		
			$location=$employee->location;
			$loc = $this->general_model->get_the_location($location);
		
			$loc->location_name;
		


		// years employed
		$date_today_format2= date('Y-m-d');
		$raw_date_hired_format2= $employee->date_employed;

		$diff = abs(strtotime($date_today_format2) - strtotime($raw_date_hired_format2));

		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

		$date_emp= printf("%d years, %d months, %d days\n", $years, $months, $days);

		//creadit balance yearly
		$sum_use_leave = 0;    // important
		$raw_use_leave = $this->leave_management_model->check_use_leave($current_leave_id,$employee->employee_id);
		foreach($raw_use_leave as $use_leave){ 
		$sum_use_leave+=$use_leave->no_of_days; // add all leave for specific employee
		}   
		if($sum_use_leave==0){
		$bal_yearly= "0";
		}else{
		$bal_yearly= $sum_use_leave;
		}
		//available leave

		$cd=date('Y-m-d'); // current date
		$cd_format_2=date('Ymd'); // current date format 2              

		$date_format = 'Y-m-d'; // to check if effectivity is in date format
		$input = $eff;

		$input = trim($input);
		$time = strtotime($input);

		$cd_y=substr($cd, 0, 4); //current date year
		$cd_d=substr($cd, 8, 2); //current date day
		$cd_m=substr($cd, 5, -3); //current date month

		$dh_y=substr($employee->date_employed, 0, 4); // date hired year
		$dh_d=substr($employee->date_employed, 8, 2); // date hired day
		$dh_m=substr($employee->date_employed, 5, -3); // date hired month

		$eff_m = sprintf("%02d", $eff);    // effectivity month                                 

		$effetive_on_raw=$dh_m+$eff_m; //date hired + effectivity condition
		$effective_on_month= sprintf("%02d", $effetive_on_raw); // format

		// check if effectivity date is current year or next year
		if ($effective_on_month>=13){
		$effective_on_year=date('Y')+1;
		}else{
		$effective_on_year=date('Y');
		}
		// End check if effectivity date is current year or next year

		$effective_date=$effective_on_year.$effective_on_month.$dh_d;

		$new_datepicker_format = date("Ymd", strtotime($input));

		if(($cd_format_2>=$new_datepicker_format ) AND (date($date_format, $time) == $input)){ 

		/**/	$available_leave=   $current_leave_start_value-$sum_use_leave;

		}else if (($cd_format_2>=$effective_date) AND (date($date_format, $time) != $input)){

		/**/ 	$available_leave=      $current_leave_start_value-$sum_use_leave;

		}else if(($cd_format_2<$effective_date) AND (date($date_format, $time) != $input)){

		/**/    $available_leave=        "<font color='#ff0000'>0</font> &nbsp;(note:  credit balance yearly will take effect on: ".date("F", mktime(0, 0, 0, $effective_on_month, 10)) ." &nbsp;".$dh_d." &nbsp;".$effective_on_year.")";
		}else{
		"0"; // no more leave left
		}

				$this->table->add_row( 
				$employee->employee_id,
				$employee->first_name." ".$employee->middle_name." ".$employee->last_name,
				$employee->date_employed,
				$years. " years ". $months. " months ".$days. " days ",
				$cl->classification,
				$employee->employment_name,
				$loc->location_name."yea",
				$current_leave_start_value,
				$bal_yearly,
				$available_leave 
				
			);
		}
		$data=$this->data['table'] = $this->table->generate();
		force_download($trimmed_leave_type.'_'.$cd.'.xls', $data);

        }

public function testexcel(){
		$this->load->view('starter',$this->data);
}

    public function modify_leave_credit(){
    	$id = $this->uri->segment("4");
    	$here=$this->leave_management_model->getLeaveType($id);	

    	$this->db->query("delete from leave_allocation where leave_type_id = ".$id);	
    	
    	foreach (array_combine($this->input->post('emp_id'), $this->input->post('credit_bal')) as $emp_id => $credit_bal) 
    	//foreach ($this->input->post('emp_id') as $key => $value)
						{
							$this->data = array(
								'leave_type_id'	=>	$id,
								'employee_id'	=>	$emp_id,
								'available'	=>	$credit_bal,
							);
							$this->db->insert("leave_allocation",$this->data);
						}

		// logfile
		$value = $here->leave_type;

		General::logfile('Leave Management','MODIFY',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> Conditions is Successfully Modified!</div>");

		//$this->session->set_flashdata('onload',"details(".$id.")");
		redirect(base_url().'app/leave_management/details/'.$id.'/view');

    }    
    public function remove_leave_condition(){
    	$id = $this->uri->segment("4");
    	$here=$this->leave_management_model->getLeaveType($id);	
    	$company_id=$here->company_id;

    		$this->db->query("delete from leave_type_classification where leave_type_id = ".$id);	
			$this->db->query("delete from leave_type_employment where leave_type_id = ".$id);	
			$this->db->query("delete from leave_type_location where leave_type_id = ".$id);	

		$this->leave_management_model->remove_leave_condition($id);	
		$this->db->query("delete from leave_type_year where leave_type_id = ".$id."" );	
		// logfile
		$value = $here->leave_type;


			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Leave','Credit Management','logfile_admin_leave_management','remove leave credits policy setup:(id|name) '.$id.'|'.$value,'DELETE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> Conditions is Successfully Remove!</div>");

		//$this->session->set_flashdata('onload',"leave_manage_condition(".$id.")");
		$this->session->set_flashdata('onload',"fetch_comp_leave(".$company_id.")");
		redirect(base_url().'app/leave_management/index',$this->data);

    }  
    public function delete_year_inc_setup(){
    	$id = $this->uri->segment("4");
    	$year = $this->uri->segment("5");
    	      if($year==1){$extension="st";}
              else if($year==2){$extension="nd";}
              else if($year==3){$extension="rd";}
              else{$extension="th";}

    	$here=$this->leave_management_model->getLeaveType($id);	

    		$this->db->query("delete from leave_type_year where leave_type_id = ".$id." AND year ='".$year."'" );	

		// logfile
		$value = $here->leave_type;
		$company_id = $here->company_id;
		General::logfile('Leave Management','REMOVE AUTO INC SETUP',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> ".$year.$extension." Year Auto Increment is Successfully Remove!</div>");

		$this->session->set_flashdata('onload',"fetch_comp_leave(".$company_id.")");
		redirect(base_url().'app/leave_management/index',$this->data);

    }
    public function remove_succeding_years_condition(){
    	$id = $this->uri->segment("4");
    	$here=$this->leave_management_model->getLeaveType($id);	
    	$company_id = $here->company_id;
    		$this->db->query("delete from leave_type_year where leave_type_id = ".$id);	

		// logfile
		$value = $here->leave_type;

		General::logfile('Leave Management','REMOVE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> Succeeding years condition is successfully remove!</div>");

		$this->session->set_flashdata('onload',"fetch_comp_leave(".$company_id.")");
		//$this->session->set_flashdata('onload',"leave_manage_condition(".$id.")");
		redirect(base_url().'app/leave_management/index',$this->data);

    }
	public function save_add(){

		//$this->form_validation->set_rules("start_value","Classification","trim|required|callback_validate_add_leave_type");
		$this->form_validation->set_rules("start_value","Start Value","trim|required");
		$this->form_validation->set_rules("effectivity","Effectivity","trim|required");
		$this->form_validation->set_rules("carry_over","Carry Over","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		if($this->form_validation->run()){


			$this->db->query("delete from leave_type_classification where leave_type_id = ".$this->input->post('leave_id'));	
			$this->db->query("delete from leave_type_employment where leave_type_id = ".$this->input->post('leave_id'));	
			$this->db->query("delete from leave_type_location where leave_type_id = ".$this->input->post('leave_id'));	

			foreach ($this->input->post('classification') as $key => $value)
						{
							$this->data = array(
								'leave_type_id'	=>		$this->input->post('leave_id'),
								'classification'	=>	$value
							);
							$this->db->insert("leave_type_classification",$this->data);

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Leave','Credit Management','logfile_admin_leave_management','update covered class|leave type id :'.$value.'|'.$this->input->post('leave_id'),'UPDATE',$value);

						}
			
			foreach ($this->input->post('employment') as $key => $value)
						{
							$this->data = array(
								'leave_type_id'	=>		$this->input->post('leave_id'),
								'employment'	=>		$value
							);
							$this->db->insert("leave_type_employment",$this->data);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Leave','Credit Management','logfile_admin_leave_management','update covered employment|leave type id :'.$value.'|'.$this->input->post('leave_id'),'UPDATE',$value);

						}
						
			foreach ($this->input->post('location') as $key => $value)
						{
							$this->data = array(
								'leave_type_id'	=>		$this->input->post('leave_id'),
								'location'	=>			$value
							);
							$this->db->insert("leave_type_location",$this->data);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Leave','Credit Management','logfile_admin_leave_management','update covered location|leave type id :'.$value.'|'.$this->input->post('leave_id'),'UPDATE',$value);

						}
			$this->db->query("delete from leave_type_year where leave_type_id = ".$this->input->post('leave_id'));			
			$dc = date("m/d/Y H:i:s");

		$isyearly_credit_fixed=$this->input->post('isyearly_credit_fixed');
		$l_id=$this->input->post('leave_id');


		if($isyearly_credit_fixed=="yes"){
			$this->db->query("delete from leave_type_year where leave_type_id ='".$l_id."' ");	
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Leave','Credit Management','logfile_admin_leave_management','yearly fixed credit is set to yes :'.$l_id,'UPDATE',$l_id);
		}else{

			$loop = $this->input->post('loop_counter');
			$looperz=$loop-1;
			while($looperz > 0){
		
			$inc=$this->input->post('increment'.$looperz);
			$add_lv_bal = $this->input->post('leave_balance'.$looperz);
			$max = $this->input->post('max'.$looperz);
			//$replenish = $this->input->post('replenish'.$looperz);
			
			$this->data = array(
				'leave_type_id'					=>					$this->input->post('leave_id'),
				'increment'						=>					$inc,
				'add_leave_bal'					=>					$add_lv_bal,
				'max'							=>					$max,
				'year'							=>					$looperz,
				'current_date'					=>					$dc		

			);			
			$query = $this->db->insert("leave_type_year",$this->data);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Leave','Credit Management','logfile_admin_leave_management','increment setup increment|add_leave_bal|max|year:'.$inc.'|'.$add_lv_bal.'|'.$max.'|'.$looperz,'UPDATE',$this->input->post('leave_id'));

			$looperz-=1;

			}

		}


			// update data
			$this->leave_management_model->save();



			// logfile
			$value = $this->input->post('leave_type');
			//General::logfile('Leave Management','MODIFY',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Leave Type:  <strong>".$value."</strong>, is Successfully Manage!</div>");
			// redirect

		$cur_id = $this->uri->segment("4");

		$company_id = $this->uri->segment("5");
	
    	//$this->session->set_flashdata('onload',"leave_manage_condition(".$cur_id.",".$company_id.")");
    
		$this->session->set_flashdata('onload',"fetch_comp_leave(".$company_id.")");	
			redirect(base_url().'app/leave_management/index/',$this->data);
		}else{

			$this->index();
		}		
	}	
	
	public function edit_leave_type(){
		$id = $this->uri->segment("4");
		$this->data['leave_type'] = $this->leave_management_model->getLeaveType($id);
		$this->load->view('app/leave_management/edit',$this->data);
	}
	public function edit_year_condition(){
		$id = $this->uri->segment("4");
		$this->data['year_condition'] = $this->leave_management_model->getLeaveTypeYear($id);
		$this->load->view('app/leave_management/year_condition_edit',$this->data);
	}
	public function modify_leave(){
		// $this->form_validation->set_rules("yearly_fixed_credit_on_anniv_eff","Yearly Fixed Value ( Effectivity Date )","trim|required");
		// $this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		//if($this->form_validation->run()){

			$id = $this->uri->segment("4");


		$selectDate=$this->input->post('start_month').$this->input->post('start_day').$this->input->post('end_month').$this->input->post('end_day');
		$yearly=$this->input->post('yearly');

		if($yearly=="yearly"){
			$cut_off_date="yearly";
		}elseif($yearly=="date_hired"){
			$cut_off_date="date_hired";
		}
		if($selectDate !=""){			
			$cut_off_date=$this->input->post('start_month')."/".$this->input->post('start_day')."-".$this->input->post('end_month')."/".$this->input->post('end_day');
		}else{
			//$cut_off_date="yearly";
		}
			// modify data
			$this->leave_management_model->modify_leave_type($id,$cut_off_date);

			// logfile
			$value = $this->input->post('hidden_leave_name');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Leave','Credit Management','logfile_admin_leave_management','update cutoff date|is manual dredit? :'.$cut_off_date.'|'.$this->input->post('is_manual_Credit'),'UPDATE',$id);

			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Leave Type: <strong>".$yearly."</strong>, is Successfully Modified!</div>");

						//$id=$cur_id;
			$here=$this->leave_management_model->getLeaveType($id);	
			$company_id=$here->company_id;

			$this->session->set_flashdata('onload',"fetch_comp_leave(".$company_id.")");

			//$this->session->set_flashdata('onload',"leave_manage_condition(".$id.")");
			redirect(base_url().'app/leave_management/index',$this->data);
		// }else{
		// 	$this->session->set_flashdata('onload',"index()");
		// 	$this->index();
		// }		
	}
	public function modify_leave_year(){

		$this->form_validation->set_rules("leave_balance","Add Leave Balance","trim|required");
		$this->form_validation->set_rules("max","Maximum Leave","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");
			$cur_id = $this->input->post('leave_id');
			// modify data

			$this->db->query("update leave_type_year set isyearly_setup='' where leave_type_id = ".$this->input->post('leave_id'));		
			$this->leave_management_model->modify_leave_type_year($id);

			// logfile
			$value = $this->input->post('hidden_leave_name');
			General::logfile('Leave Management','MODIFY',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Leave Type: <strong>".$value."</strong>, is Successfully Modified!</div>");

						$id=$cur_id;
			$here=$this->leave_management_model->getLeaveType($id);	
			$company_id=$here->company_id;

			$this->session->set_flashdata('onload',"fetch_comp_leave(".$company_id.")");
			//$this->session->set_flashdata('onload',"leave_manage_condition(".$cur_id.")");
			redirect(base_url().'app/leave_management/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"index()");
			$this->index();
		}		
	}
	
	//viewing of earned credits from approved overtime
	public function earned_from_ot($current_leave_id, $employee_id)
	{

   		$leave=$this->leave_management_model->getLeaveType($current_leave_id);
		$this->data['emp'] = $this->leave_management_model->earned_from_ot($current_leave_id,$employee_id);	
		$this->load->view('app/leave_management/earned_from_ot',$this->data);	
	}

}//end controller



