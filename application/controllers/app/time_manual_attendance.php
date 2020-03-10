<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Time_manual_attendance extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/time_manual_attendance_model");
		$this->load->model("app/time_biometrics_setup_model");
		//$this->load->model("auto_sync_logs/auto_sync_logs_model");
		$this->load->model("general_model");
		$this->load->dbforge();
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){	
		$this->time_manual_attendance();	
	}


	public function time_manual_attendance(){
		$this->data['message'] = $this->session->flashdata('message');		 
		$this->load->view('app/time/manual_attendance/time_manual_attendance',$this->data);		
	}
	
	public function template_withBreak(){		 
		$this->load->view('app/time/manual_attendance/template_with_Break',$this->data);		
	}

	public function template_withoutBreak(){	 
		$this->load->view('app/time/manual_attendance/template_without_Break',$this->data);		
	}
	public function template_dtr_summary(){	 

		$total_companies=$this->general_model->countCompanies();
		$total_comp=$total_companies->total_company;
		$this->data['total_comp']=$total_comp;
		if($total_comp=="1"){
			$total_comp_group=$this->time_manual_attendance_model->countCompanyGroup();
				if($total_comp_group->total_company_group>1){
					//forced must input payroll period id to the excel template.
					$this->data['total_comp']=2;
				}else{

					$this->data['compPayPer']=$this->time_manual_attendance_model->getcomp_pp();


				}
		}else{

		}



		$this->load->view('app/time/manual_attendance/manual_dtr_summary',$this->data);		
	}

		public function update_dtr_summary(){	 

		$total_companies=$this->general_model->countCompanies();
		$total_comp=$total_companies->total_company;
		$this->data['total_comp']=$total_comp;
		if($total_comp=="1"){
			$total_comp_group=$this->time_manual_attendance_model->countCompanyGroup();
				if($total_comp_group->total_company_group>1){
					//forced must input payroll period id to the excel template.
					$this->data['total_comp']=2;
				}else{

					$this->data['compPayPer']=$this->time_manual_attendance_model->getcomp_pp();


				}
		}else{

		}



		$this->load->view('app/time/manual_attendance/update_manual_dtr_summary',$this->data);		
	}


   public function save_update_manual_dtr_summary()
    {

    	$total_comp=$this->input->post('total_comp');

		// $total_companies=$this->general_model->countCompanies();
		// $total_comp=$total_companies->total_company;

		if($total_comp=="1"){
			$total_comp_group=$this->time_manual_attendance_model->countCompanyGroup();
				if($total_comp_group->total_company_group>1){
					$total_comp=2;//forced must input payroll period id to the excel template.
				}else{
					$payroll_period_id=$this->input->post('payroll_period_id');
				}
		}else{

		}

		$action_type=$this->input->post('action_type');

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
					redirect('app/time_manual_attendance');
	            }

	            $objPHPExcel->setActiveSheetIndex(0);
				$sheet 			= $objPHPExcel->getSheet(0);
	            $highestRow 	= $sheet->getHighestRow();
	            $highestColumn 	= $sheet->getHighestColumn();
	            $colNumber 		= PHPExcel_Cell::columnIndexFromString($highestColumn);


	            $row_error_message	='';
	            $month_cover='';
	            $payperiod='';
	            $action_result='';
	            $action_result_des='';
	echo '

	<table style="width:100%;font-size:12px;" border="1">
	<thead>
		<tr>
			<th>Company ID</th>
			<th>Employee ID</th>
			<th>Name</th>
			<th >No Of Days</th>
			<th >Payroll Period</th>

			<th style="background-color:#BCFFF5;">Remarks</th>
			<th style="background-color:#BCFFF5;">Action</th>
			<th style="background-color:#BCFFF5;">Action Result</th>
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


			     	for($col = 0; $col < $colNumber; $col++){
		            	$colrow = $colLetter.(string)$row;    
					    $getCellvalue = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();



if($col=="0"){
	$employee_id=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="1"){
	$total_regular_days=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="2"){
	if($total_comp=="1"){
	}else{
		$payroll_period_id=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
	}	
}else{
}
					    $colLetter++;
					}// col array
// ======= verify employee id
$checkEmp=$this->time_manual_attendance_model->checkEmp($employee_id);
if(!empty($checkEmp)){
	$company_id=$checkEmp->company_id;
	$emp_name=$checkEmp->name;

}else{
	$company_id="Not Found";
	$emp_name="Not Found";
	$row_error_message="Employee ID Not Exist";
}

//validate payroll period
//pp_status : payroll period status

				if($payroll_period_id!=""){
					$pp_status=$this->time_manual_attendance_model->valPayPeriod($employee_id,$payroll_period_id);
					if(!empty($pp_status)){
						$payperiod=$pp_status->complete_from." TO ".$pp_status->complete_to;
						$month_cover=$pp_status->month_cover;
						$row_error_message="";
					}else{			
						$row_error_message="Incorrect Payroll Period";
					}
				}else{
					$row_error_message="Incorrect Payroll Period";
				}

	//echo "hey | $payroll_period_id<br>";

	if($row_error_message=="Incorrect Payroll Period"){
		$payroll_period_name="Not Found";
	}else{
		$payroll_period_name=$payperiod;
	}


		// ================start validate
		if($total_regular_days!=""){
			if($total_regular_days>0){}else{
				$row_error_message="Invalid Column No Of Days";
			}
		}else{
			$row_error_message="Required Column No Of Days";
		}

// ================end validate
$sess_uid=$this->session->userdata('user_id');

if($action_type=="save"){
	if($row_error_message==""){//walang error message proceed saving

		$month_cover = sprintf("%02d", $month_cover);
		$time_summary_table="time_summary_".$month_cover;
		$payslip_table="payslip_".$month_cover;
		
		//validate if payslip is already posted
		$payslip_stat=$this->time_manual_attendance_model->validatePayslip($payslip_table,$employee_id,$payroll_period_id);
		if(!empty($payslip_stat)){// posted na , di na pwede ioverwrite dtr summary
			$row_error_message='Not Allowed , Payroll is already Posted';

		$action_result_des='style="background-color:#DD1613;color:#fff;text-transform:uppercase;"';
		$action_result="Not Saved. Check Remarks";

		}else{
			
			$this->db->query("UPDATE`$time_summary_table` set complete_logs_present_occ='".$total_regular_days."' where employee_id='".$employee_id."' and payroll_period_id='".$payroll_period_id."'");	
		
		$action_result="Saved";
		$action_result_des='style="background-color:#04610F;color:#fff;text-transform:uppercase;"';
		}

	
	}else{
		$action_result_des='style="background-color:#DD1613;color:#fff;text-transform:uppercase;"';
		$action_result="Not Saved. Check Remarks";

	}

}else{
	$action_result_des='';
	$action_result="review mode";

}


echo '
	<tr>

			<td>'.$company_id.'</td>
			<td>'.$employee_id.'</td>
			<td>'.$emp_name.'</td>
			<td >'.$total_regular_days.'</td>
			<td >'.$payroll_period_name.'</td>
			<td '.$action_result_des.'>'.$row_error_message.'</td>
			<td '.$action_result_des.'>'.$action_type.' mode</td>
			<td '.$action_result_des.'>'.$action_result.'</td>

';


echo '

	</tr>
';



				}//row array
echo '
</tbody>
</table>

';
			}

    }



	
	public function download_template_update_dtr_summary() {
		
        $this->load->helper('download');            
		$path    =   file_get_contents(base_url()."public/downloadable_templates/update_manual_dtr_summary.xls");
		$name    =   "update_manual_dtr_summary_no_of_days.xls";
		force_download($name, $path); 

		$value = $name;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Manual DTR Summary','logfile_time_manual_upload_attendance','download update manual dtr summary : '.$value.'','DOWNLOAD',$value);
                             
    }

	public function download_template_dtr_summary() {
		
        $this->load->helper('download');            
		$path    =   file_get_contents(base_url()."public/downloadable_templates/manual_dtr_summary.xls");
		$name    =   "manual_dtr_summary.xls";
		force_download($name, $path); 

		$value = $name;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Manual DTR Summary','logfile_time_manual_upload_attendance','download manual dtr summary : '.$value.'','DOWNLOAD',$value);
                             
    }


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

	public function validateTime($time, $format = 'H:i')
	{
	    $d = DateTime::createFromFormat($format, $time);
	    if($d && $d->format($format) == $time){
	    	return true;
	    }
	    else{
	    	return false;
	    }
	}

	// ========================================Template without Break===================================================
	
	public function download_template_withoutBreak() {
		
        $this->load->helper('download');            
		$path    =   file_get_contents(base_url()."public/downloadable_templates/attendance_template_withoutBreak.xls");
		$name    =   "attendance_template_withoutBreak.xls";
		force_download($name, $path); 

		$value = $name;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Manual Upload Attendance','logfile_time_manual_upload_attendance','download without break template : '.$value.'','DOWNLOAD',$value);
                             
    }

    public function upload_manual_dtr_summary()
    {

    	$total_comp=$this->input->post('total_comp');

		// $total_companies=$this->general_model->countCompanies();
		// $total_comp=$total_companies->total_company;

		if($total_comp=="1"){
			$total_comp_group=$this->time_manual_attendance_model->countCompanyGroup();
				if($total_comp_group->total_company_group>1){
					$total_comp=2;//forced must input payroll period id to the excel template.
				}else{
					$payroll_period_id=$this->input->post('payroll_period_id');
				}
		}else{

		}



		

		$action_type=$this->input->post('action_type');

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
					redirect('app/time_manual_attendance');
	            }

	            $objPHPExcel->setActiveSheetIndex(0);
				$sheet 			= $objPHPExcel->getSheet(0);
	            $highestRow 	= $sheet->getHighestRow();
	            $highestColumn 	= $sheet->getHighestColumn();
	            $colNumber 		= PHPExcel_Cell::columnIndexFromString($highestColumn);


	            $row_error_message	='';
	            $month_cover='';
	            $payperiod='';
	            $action_result='';
	            $action_result_des='';
	echo '

	<table style="width:400%;font-size:12px;" border="1">
	<thead>
		<tr>
			<th colspan="3" >Employee Info</th>
			<th colspan="7" style="background-color:#FFC7BC;">Regular ( 1ST 8 HOURS )</th>
			<th colspan="6" style="background-color:#FFEDBC;">Regular-ND ( 1ST 8 HOURS )</th>
			<th colspan="6" style="background-color:#FFC7BC;">OVERTIME ( IN EXCESS OF FIRST 8 HOURS )</th>
			<th colspan="6" style="background-color:#FFEDBC;">OVERTIME-ND ( IN EXCESS OF FIRST 8 HOURS )</th>
			<th colspan="4" style="background-color:#FFC7BC;">TOTAL</th>
			<th colspan="4" style="background-color:#FFEDBC;">OCCURENCE</th>
			<th colspan="4" style="background-color:#BCFFF5;">Upload Status</th>
		</tr>
		<tr>
			<th>Company ID</th>
			<th>Employee ID</th>
			<th>Name</th>

			<th style="background-color:#FFC7BC;">Regular</th>
			<th style="background-color:#FFC7BC;">Restday</th>
			<th style="background-color:#FFC7BC;">Regular Holiday</th>
			<th style="background-color:#FFC7BC;">Regular Holiday/Restday(Type 1)</th>
			<th style="background-color:#FFC7BC;">Regular Holiday/Restday(Type 2)</th>
			<th style="background-color:#FFC7BC;">Special Holiday</th>
			<th style="background-color:#FFC7BC;">Special Holiday/Restday</th>

			<th style="background-color:#FFEDBC;">Regular</th>
			<th style="background-color:#FFEDBC;">Restday</th>
			<th style="background-color:#FFEDBC;">Regular Holiday</th>
			<th style="background-color:#FFEDBC;">Regular Holiday/Restday(Type 1)</th>
			<th style="background-color:#FFEDBC;">Special Holiday</th>
			<th style="background-color:#FFEDBC;">Special Holiday/Restday</th>

			<th style="background-color:#FFC7BC;">Regular</th>
			<th style="background-color:#FFC7BC;">Restday</th>
			<th style="background-color:#FFC7BC;">Regular Holiday</th>
			<th style="background-color:#FFC7BC;">Regular Holiday/Restday(Type 1)</th>
			<th style="background-color:#FFC7BC;">Special Holiday</th>
			<th style="background-color:#FFC7BC;">Special Holiday/Restday</th>

			<th style="background-color:#FFEDBC;">Regular</th>
			<th style="background-color:#FFEDBC;">Restday</th>
			<th style="background-color:#FFEDBC;">Regular Holiday</th>
			<th style="background-color:#FFEDBC;">Regular Holiday/Restday(Type 1)</th>
			<th style="background-color:#FFEDBC;">Special Holiday</th>
			<th style="background-color:#FFEDBC;">Special Holiday/Restday</th>

			<th style="background-color:#FFC7BC;">Absences</th>
			<th style="background-color:#FFC7BC;">Undertime</th>
			<th style="background-color:#FFC7BC;">Tardiness</th>
			<th style="background-color:#FFC7BC;">Overbreak</th>

			<th style="background-color:#FFEDBC;">Absences</th>
			<th style="background-color:#FFEDBC;">Undertime</th>
			<th style="background-color:#FFEDBC;">Tardiness</th>
			<th style="background-color:#FFEDBC;">Overbreak</th>
			<th style="background-color:#BCFFF5;">Payroll Period</th>

			<th style="background-color:#BCFFF5;">Remarks</th>
			<th style="background-color:#BCFFF5;">Action</th>
			<th style="background-color:#BCFFF5;">Action Result</th>
		</tr>
	</thead>
	<tbody>
	';	  

	            $styleArray = array(
			    'font'  => array(
			        'bold'  => true,
			        'color' => array('rgb' => 'FF0000')
			    ));

			     for ($row = 3; $row <= $highestRow; $row++){
			     	$colLetter 			= 'A';
			     	$check_time_out		= false;
			     	$check_date_out		= false;
			     	$time_hour_in 		= 0;
					$time_in 			= 0;
					$time_hour_out		= 0;
					$time_out 			= 0;
					$date_in 			= 0;
					$date_out 			= 0;
					$check_night_shift  = false;

			     	for($col = 0; $col < $colNumber; $col++){
		            	$colrow = $colLetter.(string)$row;    
					    $getCellvalue = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();



if($col=="0"){
	$employee_id=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="1"){
	$total_regular_hours=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="2"){
	$total_regular_hrs_restday=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="3"){
	$total_regular_hrs_reg_holiday=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="4"){
	$total_regular_hrs_reg_holiday_t1=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="5"){
	$total_regular_hrs_reg_holiday_t2=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="6"){
	$total_regular_hrs_spec_holiday=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="7"){
	$total_restday_regular_hrs_spec_holiday=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}

elseif($col=="8"){
	$total_regular_nd=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="9"){
	$total_restday_nd=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="10"){
	$total_reg_holiday_nd=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="11"){
	$total_restday_reg_holiday_nd=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="12"){
	$total_spec_holiday_nd=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="13"){
	$total_restday_spec_holiday_nd=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}

elseif($col=="14"){
	$total_regular_overtime=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="15"){
	$total_restday_overtime=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="16"){
	$total_reg_holiday_overtime=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="17"){
	$total_restday_reg_holiday_overtime=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="18"){
	$total_spec_holiday_overtime=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="19"){
	$total_restday_spec_holiday_overtime=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}

elseif($col=="20"){
	$total_regular_overtime_nd=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="21"){
	$total_restday_overtime_nd=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="22"){
	$total_reg_holiday_overtime_nd=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="23"){
	$total_restday_reg_holiday_overtime_nd=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="24"){
	$total_spec_holiday_overtime_nd=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="25"){
	$total_restday_spec_holiday_overtime_nd=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}

elseif($col=="26"){
	$absences_total=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="27"){
	$undertime_total=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="28"){
	$tardiness_total=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="29"){
	$overbreak_total=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}

elseif($col=="30"){
	$absences_occurence=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="31"){
	$undertime_occurence=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="32"){
	$tardiness_occurence=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="33"){
	$overbreak_occurence=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="34"){

	if($total_comp=="1"){

	}else{
		$payroll_period_id=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
	}
	
}else{
}
					    $colLetter++;
					}// col array
// ======= verify employee id
$checkEmp=$this->time_manual_attendance_model->checkEmp($employee_id);
if(!empty($checkEmp)){
	$company_id=$checkEmp->company_id;
	$emp_name=$checkEmp->name;
}else{
	$company_id="Not Found";
	$emp_name="Not Found";
	$row_error_message="Employee ID Not Exist";
}

//validate payroll period
//pp_status : payroll period status


				if($payroll_period_id!=""){
					$pp_status=$this->time_manual_attendance_model->valPayPeriod($employee_id,$payroll_period_id);
					if(!empty($pp_status)){
						$payperiod=$pp_status->complete_from." TO ".$pp_status->complete_to;
						$month_cover=$pp_status->month_cover;
					}else{			
						$row_error_message="Incorrect Payroll Period";
					}
				}else{
					$row_error_message="Incorrect Payroll Period";

				}

	//echo "hey | $payroll_period_id<br>";

	if($row_error_message=="Incorrect Payroll Period"){
		$payroll_period_name="Not Found";
	}else{
		$payroll_period_name=$payperiod;
	}


// ================start validate
if($total_regular_hours!=""){
	if($total_regular_hours>0){}else{
		$row_error_message="Invalid Column /Regular/ of Regular ( 1ST 8 HOURS )";
	}
}else{
	$row_error_message="Required Column /Regular/ of Regular ( 1ST 8 HOURS )";
}
if($total_regular_hrs_restday!=""){
	if($total_regular_hrs_restday>0){}else{
		$row_error_message="Invalid Column /Restday/ of Regular ( 1ST 8 HOURS )";
	}
}else{
	
}
if($total_regular_hrs_reg_holiday!=""){
	if($total_regular_hrs_reg_holiday>0){}else{
		$row_error_message="Invalid Column /Regular Holiday/ of Regular ( 1ST 8 HOURS )";
	}
}else{
	
}
if($total_regular_hrs_reg_holiday_t1!=""){
	if($total_regular_hrs_reg_holiday_t1>0){}else{
		$row_error_message="Invalid Column /Regular Holiday/Restday(Type 1)/ of Regular ( 1ST 8 HOURS )";
	}
}else{
	
}
if($total_regular_hrs_reg_holiday_t2!=""){
	if($total_regular_hrs_reg_holiday_t2>0){}else{
		$row_error_message="Invalid Column /Regular Holiday/Restday(Type 2)/ of Regular ( 1ST 8 HOURS )";
	}
}else{
	
}
if($total_regular_hrs_spec_holiday!=""){
	if($total_regular_hrs_spec_holiday>0){}else{
		$row_error_message="Invalid Column /Special Holiday/ of Regular ( 1ST 8 HOURS )";
	}
}else{
	
}
if($total_restday_regular_hrs_spec_holiday!=""){
	if($total_restday_regular_hrs_spec_holiday>0){}else{
		$row_error_message="Invalid Column /Special Holiday/Restday/ of Regular ( 1ST 8 HOURS )";
	}
}else{
	
}
if($total_regular_nd!=""){
	if($total_regular_nd>0){}else{
		$row_error_message="Invalid Column /Regular/ of Regular-ND ( 1ST 8 HOURS )";
	}
}else{
	
}
if($total_restday_nd!=""){
	if($total_restday_nd>0){}else{
		$row_error_message="Invalid Column /Restday/ of Regular-ND ( 1ST 8 HOURS )";
	}
}else{
	
}
if($total_reg_holiday_nd!=""){
	if($total_reg_holiday_nd>0){}else{
		$row_error_message="Invalid Column /Regular Holiday/ of Regular-ND ( 1ST 8 HOURS )";
	}
}else{
	
}
if($total_restday_reg_holiday_nd!=""){
	if($total_restday_reg_holiday_nd>0){}else{
		$row_error_message="Invalid Column /Regular Holiday/Restday(Type 1)/ of Regular-ND ( 1ST 8 HOURS )";
	}
}else{
	
}
if($total_spec_holiday_nd!=""){
	if($total_spec_holiday_nd>0){}else{
		$row_error_message="Invalid Column /Special Holiday/ of Regular-ND ( 1ST 8 HOURS )";
	}
}else{
	
}
if($total_restday_spec_holiday_nd!=""){
	if($total_restday_spec_holiday_nd>0){}else{
		$row_error_message="Invalid Column /Special Holiday/Restday/ of Regular-ND ( 1ST 8 HOURS )";
	}
}else{
	
}
if($total_regular_overtime!=""){
	if($total_regular_overtime>0){}else{
		$row_error_message="Invalid Column /Regular/ OVERTIME ( IN EXCESS OF FIRST 8 HOURS )";
	}
}else{
	
}
if($total_restday_overtime!=""){
	if($total_restday_overtime>0){}else{
		$row_error_message="Invalid Column /Restday/ OVERTIME ( IN EXCESS OF FIRST 8 HOURS )";
	}
}else{
	
}
if($total_reg_holiday_overtime!=""){
	if($total_reg_holiday_overtime>0){}else{
		$row_error_message="Invalid Column /Regular Holiday/ OVERTIME ( IN EXCESS OF FIRST 8 HOURS )";
	}
}else{
	
}
if($total_restday_reg_holiday_overtime!=""){
	if($total_restday_reg_holiday_overtime>0){}else{
		$row_error_message="Invalid Column /Regular Holiday/Restday(Type 1)/ OVERTIME ( IN EXCESS OF FIRST 8 HOURS )";
	}
}else{
	
}
if($total_spec_holiday_overtime!=""){
	if($total_spec_holiday_overtime>0){}else{
		$row_error_message="Invalid Column /Special Holiday/ OVERTIME ( IN EXCESS OF FIRST 8 HOURS )";
	}
}else{
	
}
if($total_restday_spec_holiday_overtime!=""){
	if($total_restday_spec_holiday_overtime>0){}else{
		$row_error_message="Invalid Column /Special Holiday/Restday/ OVERTIME ( IN EXCESS OF FIRST 8 HOURS )";
	}
}else{
	
}
if($total_regular_overtime_nd!=""){
	if($total_regular_overtime_nd>0){}else{
		$row_error_message="Invalid Column /Regular/ OVERTIME-ND ( IN EXCESS OF FIRST 8 HOURS )";
	}
}else{
	
}
if($total_restday_overtime_nd!=""){
	if($total_restday_overtime_nd>0){}else{
		$row_error_message="Invalid Column /Restday/ OVERTIME-ND ( IN EXCESS OF FIRST 8 HOURS )";
	}
}else{
	
}
if($total_reg_holiday_overtime_nd!=""){
	if($total_reg_holiday_overtime_nd>0){}else{
		$row_error_message="Invalid Column /Regular Holiday/ OVERTIME-ND ( IN EXCESS OF FIRST 8 HOURS )";
	}
}else{
	
}
if($total_restday_reg_holiday_overtime_nd!=""){
	if($total_restday_reg_holiday_overtime_nd>0){}else{
		$row_error_message="Invalid Column /Regular Holiday/Restday(Type 1)/ OVERTIME-ND ( IN EXCESS OF FIRST 8 HOURS )";
	}
}else{
	
}
if($total_spec_holiday_overtime_nd!=""){
	if($total_spec_holiday_overtime_nd>0){}else{
		$row_error_message="Invalid Column /Special Holiday/ OVERTIME-ND ( IN EXCESS OF FIRST 8 HOURS )";
	}
}else{
	
}
if($total_restday_spec_holiday_overtime_nd!=""){
	if($total_restday_spec_holiday_overtime_nd>0){}else{
		$row_error_message="Invalid Column /Special Holiday/Restday/ OVERTIME-ND ( IN EXCESS OF FIRST 8 HOURS )";
	}
}else{
	
}

if($absences_total!=""){
	if($absences_total>0){}else{
		$row_error_message="Invalid Column Absences Total";
	}
}else{
	
}
if($undertime_total!=""){
	if($undertime_total>0){}else{
		$row_error_message="Invalid Column Undertime Total";
	}
}else{
	
}
if($tardiness_total!=""){
	if($tardiness_total>0){}else{
		$row_error_message="Invalid Column Tardiness Total";
	}
}else{
	
}
if($absences_occurence!=""){
	if($absences_occurence>0){}else{
		$row_error_message="Invalid Column Absences Occurence";
	}
}else{
	
}
if($undertime_occurence!=""){
	if($undertime_occurence>0){}else{
		$row_error_message="Invalid Column Undertime Occurence";
	}
}else{
	
}
if($tardiness_occurence!=""){
	if($tardiness_occurence>0){}else{
		$row_error_message="Invalid Column Tardiness Occurence";
	}
}else{
	
}
if($overbreak_occurence!=""){
	if($overbreak_occurence>0){}else{
		$row_error_message="Invalid Column Overbreak Occurence";
	}
}else{
	
}
// ================end validate
$sess_uid=$this->session->userdata('user_id');

if($action_type=="save"){


	if($row_error_message==""){//walang error message proceed saving

		$month_cover = sprintf("%02d", $month_cover);
		$time_summary_table="time_summary_".$month_cover;
		$payslip_table="payslip_".$month_cover;
		
		//validate if payslip is already posted
		$payslip_stat=$this->time_manual_attendance_model->validatePayslip($payslip_table,$employee_id,$payroll_period_id);
		if(!empty($payslip_stat)){// posted na , di na pwede ioverwrite dtr summary
			$row_error_message='Not Allowed , Payroll is already Posted';

		$action_result_des='style="background-color:#DD1613;color:#fff;text-transform:uppercase;"';
		$action_result="Not Saved. Check Remarks";

		}else{
		$this->db->query("delete from `$time_summary_table` where employee_id='".$employee_id."' and payroll_period_id='".$payroll_period_id."'");	

		$manual_dtr_summary_data = array(
			'company_id'	=> $company_id,
			'payroll_period_id'	=> $payroll_period_id,
			'employee_id'	=> $employee_id,
			'total_regular_hours'	=> $total_regular_hours,
			'leave_reg_hrs'	=> '0',
			'total_regular_nd'	=> $total_regular_nd,
			'total_regular_overtime'	=> $total_regular_overtime,
			'total_regular_overtime_nd'	=> $total_regular_overtime_nd,
			'total_regular_hrs_restday'	=> $total_regular_hrs_restday,
			'total_restday_nd'	=> $total_restday_nd,
			'total_restday_overtime'	=> $total_restday_overtime,
			'total_restday_overtime_nd'	=> $total_restday_overtime_nd,
			'total_regular_hrs_reg_holiday'	=> $total_regular_hrs_reg_holiday,
			'total_reg_holiday_nd'	=> $total_reg_holiday_nd,
			'total_reg_holiday_overtime'	=> $total_reg_holiday_overtime,
			'total_reg_holiday_overtime_nd'	=> $total_reg_holiday_overtime_nd,
			'total_regular_hrs_reg_holiday_t1'	=> $total_regular_hrs_reg_holiday_t1,
			'total_regular_hrs_reg_holiday_t2'	=> $total_regular_hrs_reg_holiday_t2,
			'total_restday_reg_holiday_nd'	=> $total_restday_reg_holiday_nd,
			'total_restday_reg_holiday_overtime'	=> $total_restday_reg_holiday_overtime,
			'total_restday_reg_holiday_overtime_nd'	=> $total_restday_reg_holiday_overtime_nd,
			'total_regular_hrs_spec_holiday'	=> $total_regular_hrs_spec_holiday,
			'total_spec_holiday_nd'	=> $total_spec_holiday_nd,
			'total_spec_holiday_overtime'	=> $total_spec_holiday_overtime,
			'total_spec_holiday_overtime_nd'	=> $total_spec_holiday_overtime_nd,
			'total_restday_regular_hrs_spec_holiday'	=> $total_restday_regular_hrs_spec_holiday,
			'total_restday_spec_holiday_nd'	=> $total_restday_spec_holiday_nd,
			'total_restday_spec_holiday_overtime'	=> $total_restday_spec_holiday_overtime,
			'total_restday_spec_holiday_overtime_nd'	=> $total_restday_spec_holiday_overtime_nd,
			'absences_total'	=> $absences_total,
			'undertime_total'	=> $undertime_total,
			'tardiness_total'	=> $tardiness_total,
			'overbreak_total'	=> $overbreak_total,
			'absences_occurence'	=> $absences_occurence,
			'undertime_occurence'	=> $undertime_occurence,
			'tardiness_occurence'	=> $tardiness_occurence,
			'overbreak_occurence'	=> $overbreak_occurence,
			'date_process'	=> date('Y-m-d H:i:s'),
			'system_user_id'	=> $sess_uid,
			'complete_logs_present_occ'	=> '11',
			'with_tk_logs_present_occ'	=> '',
			'with_ob_logs_present_occ'	=> '',
			'with_leave_present_occ'	=> '',
			'restday_w_logs'	=> '',
			'restday_wo_logs'	=> '',
			'reg_holiday_w_logs'	=> '',
			'reg_holiday_wo_logs'	=> '',
			'snw_holiday_w_logs'	=> '',
			'snw_holiday_wo_logs'	=> '',
			'rd_reg_holiday_w_logs'	=> '',
			'rd_reg_holiday_wo_logs'	=> '',
			'rd_snw_holiday_w_logs'	=> '',
			'rd_snw_holiday_wo_logs'	=> '',
			'complete_logs_present_occ_ref'	=> '',
			'with_tk_logs_present_occ_ref'	=> '',
			'with_ob_logs_present_occ_ref'	=> '',
			'with_leave_present_occ_ref'	=> '',
			'restday_w_logs_ref'	=> '',
			'restday_wo_logs_ref'	=> '',
			'reg_holiday_w_logs_ref'	=> '',
			'reg_holiday_wo_logs_ref'	=> '',
			'snw_holiday_w_logs_ref'	=> '',
			'snw_holiday_wo_logs_ref'	=> '',
			'rd_reg_holiday_w_logs_ref'	=>'',
			'rd_reg_holiday_wo_logs_ref'	=> '',
			'rd_snw_holiday_w_logs_ref'	=>'',
			'rd_snw_holiday_wo_logs_ref'	=> '',
			'with_manual_dtr_only'	=> '',
			'is_manual_dtr'	=> '1',
			'approve_leave_wopay_count'	=> '',
			'approve_leave_wpay_count'	=> ''

		);

		$this->time_manual_attendance_model->save_manual_dtr_sumary($manual_dtr_summary_data,$time_summary_table);
		$action_result="Saved";
		$action_result_des='style="background-color:#04610F;color:#fff;text-transform:uppercase;"';
		}


	
	}else{
		$action_result_des='style="background-color:#DD1613;color:#fff;text-transform:uppercase;"';
		$action_result="Not Saved. Check Remarks";

	}

}else{
	$action_result_des='';
	$action_result="review mode";

}


echo '
	<tr>

			<td>'.$company_id.'</td>
			<td>'.$employee_id.'</td>
			<td>'.$emp_name.'</td>

			<td style="background-color:#FFC7BC;">'.$total_regular_hours.'</td>
			<td style="background-color:#FFC7BC;">'.$total_regular_hrs_restday.'</td>
			<td style="background-color:#FFC7BC;">'.$total_regular_hrs_reg_holiday.'</td>
			<td style="background-color:#FFC7BC;">'.$total_regular_hrs_reg_holiday_t1.'</td>
			<td style="background-color:#FFC7BC;">'.$total_regular_hrs_reg_holiday_t2.'</td>
			<td style="background-color:#FFC7BC;">'.$total_regular_hrs_spec_holiday.'</td>
			<td style="background-color:#FFC7BC;">'.$total_restday_regular_hrs_spec_holiday.'</td>

			<td style="background-color:#FFEDBC;">'.$total_regular_nd.'</td>
			<td style="background-color:#FFEDBC;">'.$total_restday_nd.'</td>
			<td style="background-color:#FFEDBC;">'.$total_reg_holiday_nd.'</td>
			<td style="background-color:#FFEDBC;">'.$total_restday_reg_holiday_nd.'</td>
			<td style="background-color:#FFEDBC;">'.$total_spec_holiday_nd.'</td>
			<td style="background-color:#FFEDBC;">'.$total_restday_spec_holiday_nd.'</td>

			<td style="background-color:#FFC7BC;">'.$total_regular_overtime.'</td>
			<td style="background-color:#FFC7BC;">'.$total_restday_overtime.'</td>
			<td style="background-color:#FFC7BC;">'.$total_reg_holiday_overtime.'</td>
			<td style="background-color:#FFC7BC;">'.$total_restday_reg_holiday_overtime.'</td>
			<td style="background-color:#FFC7BC;">'.$total_spec_holiday_overtime.'</td>
			<td style="background-color:#FFC7BC;">'.$total_restday_spec_holiday_overtime.'</td>

			<td style="background-color:#FFEDBC;">'.$total_regular_overtime_nd.'</td>
			<td style="background-color:#FFEDBC;">'.$total_restday_overtime_nd.'</td>
			<td style="background-color:#FFEDBC;">'.$total_reg_holiday_overtime_nd.'</td>
			<td style="background-color:#FFEDBC;">'.$total_restday_reg_holiday_overtime_nd.'</td>
			<td style="background-color:#FFEDBC;">'.$total_spec_holiday_overtime_nd.'</td>
			<td style="background-color:#FFEDBC;">'.$total_restday_spec_holiday_overtime_nd.'</td>

			<td style="background-color:#FFC7BC;">'.$absences_total.'</td>
			<td style="background-color:#FFC7BC;">'.$undertime_total.'</td>
			<td style="background-color:#FFC7BC;">'.$tardiness_total.'</td>
			<td style="background-color:#FFC7BC;">'.$overbreak_total.'</td>

			<td style="background-color:#FFEDBC;">'.$absences_occurence.'</td>
			<td style="background-color:#FFEDBC;">'.$undertime_occurence.'</td>
			<td style="background-color:#FFEDBC;">'.$tardiness_occurence.'</td>
			<td style="background-color:#FFEDBC;">'.$overbreak_occurence.'</td>

			<td style="background-color:#BCFFF5;">'.$payroll_period_name.'</td>
			<td '.$action_result_des.'>'.$row_error_message.'</td>
			<td '.$action_result_des.'>'.$action_type.' mode</td>
			<td '.$action_result_des.'>'.$action_result.'</td>

';


echo '

	</tr>
';



				}//row array
echo '
</tbody>
</table>

';
			}

    }



    public function upload_wo_break_attendance()
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
					redirect('app/time_manual_attendance');
	            }

	            $objPHPExcel->setActiveSheetIndex(0);
				$sheet 			= $objPHPExcel->getSheet(0);
	            $highestRow 	= $sheet->getHighestRow();
	            $highestColumn 	= $sheet->getHighestColumn();
	            $colNumber 		= PHPExcel_Cell::columnIndexFromString($highestColumn);

	            $forNull 		= 'Value cannot be Null';
	            $existExcel	 	= 'Duplicate data entry';
	            $forTime		= 'Format:hh:mm';
	            $forDate 		= 'Format:yyyy-mm-dd';
	            $forEmployee_id	= 'Employee id does not exist';
	            $invalidDate 	= 'Date does not coincide with other date';
	            $invalidTime 	= 'Time does not coincide with other time';
	            $nextDate		= 'Date out should be next day of date in.';
	            $sameDate		= 'Date out should be the same with date in.';
	            $row_error_message	='';
	            $upload_logs_type ='no';

	echo '
	<table style="width:100%;" border="1">
	<thead>
		<tr>
			<th>Employee ID</th>
			<th>Covered Date</th>
			<th>Date In</th>
			<th>Time IN</th>
			<th>Time OUT</th>
			<th>Date Out</th>
			<th>Attendance Type</th>
			<th>Remarks</th>
			<th>Action</th>
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
			     	$check_time_out		= false;
			     	$check_date_out		= false;
			     	$time_hour_in 		= 0;
					$time_in 			= 0;
					$time_hour_out		= 0;
					$time_out 			= 0;
					$date_in 			= 0;
					$date_out 			= 0;
					$covered_date='';
					$check_night_shift  = false;

			     	for($col = 0; $col < $colNumber; $col++){
		            	$colrow = $colLetter.(string)$row;    
					    $getCellvalue = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();					    
if($col=="0"){
	$employee_id=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="1"){
	$covered_date=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="2"){
	$date_in=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="3"){
	$time_in=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="4"){
	$time_out=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="5"){
	$date_out=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}elseif($col=="6"){
	$upload_logs_type=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
}else{
}
					    $colLetter++;
					}// col array
// ======= verify employee id
$checkEmp=$this->time_manual_attendance_model->checkEmp($employee_id);
if(!empty($checkEmp)){
	$company_id=$checkEmp->company_id;
}else{
	$row_error_message=$forEmployee_id;
}

//verify if only time out ang iuupload .
$a=substr($time_out, 0,2);

		// ======= verify date in & date out
		if($time_in=="00:00"){
			//1.check date if correct
			if($date_in==$date_out){
				$row_error_message=$nextDate;
			}else{

			}
		}elseif($time_in<$time_out){// in a same day yung time in at time out
			// 1.check date if correct
if($a=="00"){
}else{
			if($date_in!=$date_out){										
						$row_error_message=$sameDate;								
			}else{		
				if($row_error_message=="Employee id does not exist"){

				}else{
						$row_error_message="";		
				}											
			}
}


		}elseif($time_in>$time_out){		
			//1.check date if correct
			if($date_in==$date_out){
				$row_error_message=$nextDate;

			}else{
				if($row_error_message=="Employee id does not exist"){

				}else{
						$row_error_message="";		
				}
			}
		}else{

		}


if($upload_logs_type=="yes"){
	$row_error_message='';//clear 
	if($date_in=="" OR $time_out=="" OR $date_out==""){
		$row_error_message='kindly check field date in,time out , date out are required.';
	}else{
		if($date_in>$date_out){
			$row_error_message='date in column seems incorrect';
		}else{

		}
	}

}else{

	if(preg_match('/^(?:[01][0-9]|2[0-3]):[0-5][0-9]$/',$time_in)) {
	        // $input is valid HH:MM format.
	}else{
		$row_error_message="Invalid time in format:use military time";
	}	

}

if(preg_match('/^(?:[01][0-9]|2[0-3]):[0-5][0-9]$/',$time_out)) {
        // $input is valid HH:MM format.
}else{
	$row_error_message="Invalid time out format:use military time";
}

	$the_month=substr($date_in, 5, 2);
	$the_day=substr($date_in, 8, 2);
	$the_year=substr($date_in, 0, -6);

	$attendance_table="attendance_".$the_month;
if($upload_logs_type=="yes"){
	$upload_logs_type_meaning="out only";
}else{
	$upload_logs_type_meaning="in & out";
}
$action_type=$this->input->post('action_type');
echo '
	<tr>
		<td>'.$employee_id.'</td>
		<td>'.$covered_date.'</td>
		<td>'.$date_in.'</td>
		<td>'.$time_in.'</td>
		<td>'.$time_out.'</td>
		<td>'.$date_out.'</td>
		<td>'.$upload_logs_type_meaning.'</td>
		<td>'.$row_error_message.'</td>

';

if($action_type=="review"){
	$action_result="review mode";
}elseif($action_type=="save"){
	if($row_error_message==""){			
if($upload_logs_type=="yes"){// upload time out only	
			$cd=date('Y-m-d H:i:s');
			$sess_uid=$this->session->userdata('user_id');

			$update_att= $this->db->query("UPDATE `$attendance_table` 
				SET 
				`time_out`='".$time_out."',
				`time_out_date`='".$date_out."',
				`entry_type`='manual upload out',
				`entry_date`='".$cd."',
				`user_id`='".$sess_uid."'
				where employee_id='".$employee_id."' and covered_date='".$date_in."'");
			
if ($update_att === FALSE) {
} else if ($update_att == 0) {
    $row_error_message = 'No error, but no rows were updated.';
} else {
    $action_result="saved";
}


}else{
		$this->db->query("delete from `$attendance_table` where employee_id='".$employee_id."' and covered_date='".$date_in."'");	
			$manual_atteddance = array(
				'company_id'		=>	$company_id,
				'employee_id'		=>	$employee_id,
				'time_in'			=>	$time_in,
				'break_1_out'		=>	'',
				'break_1_in'		=>	'',
				'lunch_break_out'	=>	'',
				'lunch_break_in'	=>	'',
				'break_2_out'		=>	'',
				'break_2_in'		=>	'',
				'time_out'			=>	$time_out,
				'logs_month'		=>	$the_month,
				'logs_day'			=>	$the_day,
				'logs_year'			=>	$the_year,
				'covered_year'		=>	$the_year,
				'covered_date'		=>	$date_in,
				'time_in_date'		=>	$date_in,
				'time_out_date'		=>	$date_out,
				'entry_type'		=>	'manual upload',
				'entry_date'		=>	date('Y-m-d H:i:s'),
				'user_id'			=>	$this->session->userdata('user_id')
			);
		$this->time_manual_attendance_model->save_manual_attendance($manual_atteddance,$attendance_table);
		$action_result="saved";
}

	}else{

		$action_result="not save. check remarks.";
	}

}else{

}
echo '
	<td>'.$action_result.'</td>
	</tr>
';
//echo "$employee_id | $date_in | $time_in | $time_out | $date_out ($row_error_message) | $upload_logs_type<br>";



				}//row array
echo '
</tbody>
</table>

';
			}

    }
    public function import_attendance_template_withoutBreak()
    {
    	$foundError 	= False;

    	if(isset($_POST["import"]))
	    {
			$fileName = $_FILES['file']['name'];

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
					redirect('app/time_manual_attendance');
	            }

	            $objPHPExcel->setActiveSheetIndex(0);
				$sheet 			= $objPHPExcel->getSheet(0);
	            $highestRow 	= $sheet->getHighestRow();
	            $highestColumn 	= $sheet->getHighestColumn();
	            $colNumber 		= PHPExcel_Cell::columnIndexFromString($highestColumn);

	            $forNull 		= 'Value cannot be Null';
	            $existExcel	 	= 'Duplicate data entry';
	            $forTime		= 'Format:hh:mm';
	            $forDate 		= 'Format:yyyy-mm-dd';
	            $forEmployee_id	= 'Employee id does not exist';
	            $invalidDate 	= 'Date does not coincide with other date';
	            $invalidTime 	= 'Time does not coincide with other time';
	            $nextDate		= 'Date out should be next day of date in.';
	            $sameDate		= 'Date out should be the same with date in.';


	            $styleArray = array(
			    'font'  => array(
			        'bold'  => true,
			        'color' => array('rgb' => 'FF0000')
			    ));

			     for ($row = 2; $row <= $highestRow; $row++){
			     	$colLetter 			= 'A';
			     	$check_time_out		= false;
			     	$check_date_out		= false;
			     	$time_hour_in 		= 0;
					$time_in 			= 0;
					$time_hour_out		= 0;
					$time_out 			= 0;
					$date_in 			= 0;
					$date_out 			= 0;

					$check_night_shift  = false;

			     	for($col = 0; $col < $colNumber; $col++){
		            	$colrow = $colLetter.(string)$row;    
					    $getCellvalue = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
					    
					    
				    	if($col == 0 || $col == 1 || $col == 2){ // for null
				    		if(empty($getCellvalue)){//If null
								$objPHPExcel->getActiveSheet()->
								setCellValueByColumnAndRow($col, $row,  $forNull);
								$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
								$foundError = True;
							}
							else{
								if($col == 2){
								$time =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
								$check = $this->validateTime($time);
									if($check === false){
									$objPHPExcel->getActiveSheet()->
										setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$forTime);//doesn't exist
										$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
											$foundError = True;
									}
									else{
										$time_in 	  = (date('H', strtotime($time))*60) + date('i', strtotime($time));
										$time_hour_in = date('H', strtotime($time));
										if($time_hour_in <= 3 || $time_hour_in >= 15){//15:00	03:00
											$check_night_shift = true;
										}
									}
								}

							}
			            }

			            if($col == 0){
							$employee_id =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							$check = $this->time_manual_attendance_model->validate_employeeID($employee_id);
							if($check === false){
								$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$forEmployee_id);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
							}
						}
			            if($col == 1){
							$date =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							$check = $this->validateDate($date);
							if($check === false){
								$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$forDate);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
							}
							else{
								$date_in 	= $date;
								//echo '<br>Date_in:'.date('Y-m-d', strtotime($date_in));
							}
						}

						if($col == 3){
							if(!empty($getCellvalue)){
								$check_time_out = true;
								$time =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
								$check = $this->validateTime($time);
								if($check === false){
									$objPHPExcel->getActiveSheet()->
										setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$forTime);//doesn't exist
										$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
											$foundError = True;
								}
								else{
									$time_hour_out 	  	  = date('H', strtotime($time));
									$time_out 			  = (date('H', strtotime($time))*60) + date('i', strtotime($time));
									if($time_in == $time_out){
										$objPHPExcel->getActiveSheet()->
										setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$forTime);//doesn't exist
										$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
											$foundError = True;
									}
								}
							}
						}
						
						if($col == 4){
							$date =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							if($check_night_shift == true){
								//echo '<br>1==';
								if(!empty($getCellvalue)){
									//echo '1.1';
									$check = $this->validateDate($date);
									if($check === false){
										$objPHPExcel->getActiveSheet()->
											setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$forDate);//doesn't exist
											$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
									}
									else{
										$date_out 	= date('Y-m-d', strtotime($date));
										if($time_in <= 1439 && $time_in >= 900){
											//echo '<br>less than 23:59';
											if($time_in > $time_out){
												$comp_date =  date('Y-m-d',strtotime("+1 day", strtotime($date_in)));
												if($date_out != $comp_date){
													$objPHPExcel->getActiveSheet()->
													setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$nextDate);//doesn't exist
													$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
														$foundError = True;
												}
											}
											else if($time_in < $time_out){
												$comp_date 	= date('Y-m-d', strtotime($date_in));
												if($date_out != $comp_date){
													$objPHPExcel->getActiveSheet()->
													setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$sameDate);//doesn't exist
													$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
														$foundError = True;
												}
											}
											if($time_out == 0){
												//echo '$time == 0';
												$comp_date =  date('Y-m-d',strtotime("+1 day", strtotime($date_in)));
												if($date_out != $comp_date){
													$objPHPExcel->getActiveSheet()->
													setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$nextDate);//doesn't exist
													$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
														$foundError = True;
												}
											}
										}
										else if($time_in >= 0 || $time_in <= 180){//24 - 3
											//echo '<br>greater or equal to zero';
											if($time_in < $time_out){
												//echo '::less timeout';
												$comp_date 	= date('Y-m-d', strtotime($date_in));
												if($date_out != $comp_date){
													$objPHPExcel->getActiveSheet()->
													setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$sameDate);
													$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
														$foundError = True;
												}
											}
											else if($time_in > $time_out){
												//echo '::greater timeout';
												$comp_date =  date('Y-m-d',strtotime("+1 day", strtotime($date_in)));
												if($date_out != $comp_date){
													$objPHPExcel->getActiveSheet()->
													setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$sameDate);//doesn't exist
													$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
														$foundError = True;
												}

											}
											if($time_out == 0){
												$comp_date =  date('Y-m-d',strtotime("+1 day", strtotime($date_in)));
												if($date_out != $comp_date){
													$objPHPExcel->getActiveSheet()->
													setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$nextDate);//doesn't exist
													$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
														$foundError = True;
												}
											}
										}
									}
								}
							}
							else{
								$check = $this->validateDate($date);
								if($check === false){
									$objPHPExcel->getActiveSheet()->
										setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$forDate);
										$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
											$foundError = True;
								}
								else{
									$date_out 	= date('Y-m-d', strtotime($date));
									if($time_in < $time_out){
										$comp_date 	= date('Y-m-d', strtotime($date_in));
										if($date_out != $comp_date){
											$objPHPExcel->getActiveSheet()->
										setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$sameDate);
										$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
											$foundError = True;
										}

									}
									else if($time_in > $time_out){
										$comp_date = date('Y-m-d',strtotime("+1 day", strtotime($date_in)));
										if($date_out != $comp_date){
											$objPHPExcel->getActiveSheet()->
										setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$nextDate);//doesn't exist
										$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
											$foundError = True;
										}
									}
								}
							}

						}


					$colLetter++;// increment A
					} //end of for loop col
			     } //end of for loop row

			     if($foundError==False){
			     	for ($row = 2; $row <= $highestRow; $row++){                                  
	                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
	                                                NULL,
	                                                TRUE,
	                                                FALSE);

	                //Monitor shift
					
					$check_night_shift		= false;
					$time_hour_in 			= date('H', strtotime($rowData[0][2]));
					$date_in 				= date('Y-m-d', strtotime($rowData[0][1]));
					$time_out 				= $rowData[0][3];
					$date_out 				= $rowData[0][4];


					if($time_hour_in <= 3 || $time_hour_in >= 15){//15:00	02:00
						$check_night_shift = true;
					}

					if($check_night_shift == true){
						$time_out_minutes = (date('H', strtotime($rowData[0][3]))*60) + date('i', strtotime($rowData[0][3]));
						$time_in_minutes  = (date('H', strtotime($rowData[0][2]))*60) + date('i', strtotime($rowData[0][2]));
						//echo '<br>time_in:'.$time_in_minutes.'::';
						if($time_in_minutes <= 1439 && $time_in_minutes >= 900){//3 - 23:59
							$date_in = date('Y-m-d', strtotime($rowData[0][1]));
							if(!empty($time_out)){
								if($time_out_minutes <= 1439 && $time_out_minutes > $time_in_minutes){
									//$date_out = date('Y-m-d',strtotime("+1 day", strtotime($rowData[0][4])));
									$date_out = date('Y-m-d', strtotime($rowData[0][4]));
								}
								else if($time_out_minutes >= 0  && $time_out_minutes < $time_in_minutes ){//>24 and >time_in
									$date_out = date('Y-m-d', strtotime($rowData[0][4]));
								}
							}
						}
						else if($time_in_minutes >= 0 && $time_in_minutes <= 180){//24 - 3
							//$date_in = date('Y-m-d',strtotime("-1 day", strtotime($rowData[0][1])));
							$date_in = date('Y-m-d', strtotime($rowData[0][1]));
							if(!empty($time_out)){
								if($time_out_minutes <= 1439 && $time_out_minutes > $time_in_minutes){
									$date_out = date('Y-m-d', strtotime($rowData[0][4]));
								}
								else if($time_out_minutes === 0  && $time_out_minutes < $time_in_minutes ){//>24 and >time_in
									//$date_out = date('Y-m-d',strtotime("+1 day", strtotime($date_in)));
									$date_out = date('Y-m-d', strtotime($rowData[0][4]));
								}
								else if($time_out_minutes > 0  && $time_out_minutes > $time_in_minutes ){//>24 and >time_in
									$date_out = date('Y-m-d', strtotime($rowData[0][4]));
								}
							}
						}
						//echo '<br>time_out:'.$time_out_minutes.'::';
					}
					else{
						if(!empty($time_out)){
							$date_out = date('Y-m-d', strtotime($rowData[0][4]));
							//echo 'regular';
						}
					}

					//END of Monitor shift
					
					
	                $employee_id  		  	= $rowData[0][0];                                                            
					$attendance_table 	  	= 'attendance_'.date('m', strtotime($date_in));
					$entry_type			  	= 'Manual upload Template without break';
					$company			  	=  $this->time_manual_attendance_model->get_employee_company($employee_id);
					$company_id			  	=  $company[0]->company_id;

					$logs_entry    			= 'insert';

					$set_logs_entry = $this->time_manual_attendance_model->check_existAttendance_withoutBreak($employee_id , $company_id, $date_in, $attendance_table);

					if($set_logs_entry === true){
						$logs_entry    = 'delete and insert';
					}
					

					//for attendance logs

					$data = array(

							'employee_id'  		=> $rowData[0][0],
							'company_id'  		=> $company_id,
							'logs_entry'		=> $logs_entry,

							'covered_year'  	=> date('Y', strtotime($date_in)),
							'time_in_date'  	=> $date_in,
							'time_out_date'  	=> $date_out,

							'entry_type'  		=> $entry_type,
							'entry_date' 	 	=> date("Y-m-d h:i:s a"),
							'user_id'	  		=> $this->session->userdata('employee_id')

	                        );

	                $this->time_manual_attendance_model->insert_attendance_logs($data);

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Manual Upload Attendance','logfile_time_manual_upload_attendance',''.$entry_type.' for employee '.$rowData[0][0].' timein: '.date('H:i', strtotime($rowData[0][2])).' '.$date_in.' timeout: '.$time_out.' '.$date_out.'','UPLOAD',$rowData[0][0]);


					//end of for attendance logs
				
	                $data = array(

							'employee_id'  		=> $rowData[0][0],
							'company_id'  		=> $company_id,

							'time_in' 			=> date('H:i', strtotime($rowData[0][2])),
							'time_out'			=> $time_out,

							'logs_month'		=> date('m', strtotime($date_in)),
							'logs_day'			=> date('d', strtotime($date_in)),
							'logs_year' 		=> date('Y', strtotime($date_in)),
							'covered_year'  	=> date('Y', strtotime($date_in)),
							'time_in_date'  	=> $date_in,
							'covered_date'  	=> $date_in,
							'time_out_date'  	=> $date_out,

							'entry_type'  		=> $entry_type,
							'entry_date' 	 	=> date("Y-m-d h:i:s a"),
							'user_id'	  		=> $this->session->userdata('employee_id')
	                        );
	               
	                $insert = $this->time_manual_attendance_model->insert_import_attendance_withoutBreak($data,$attendance_table);
					
	            	}//end of insert
		            if($insert === true){ //file name for successfully imported
					    $dt = $date_array = getdate();
					       $formated_date  = "attendance_template_withoutBreak_";
					       $formated_date .= $date_array['mon'];
					       $formated_date .= $date_array['mday'];
						   $formated_date .= $date_array['year'] . "_";
						   $formated_date .= $date_array['hours'];
					       $formated_date .= $date_array['minutes'];
						   $formated_date .= $date_array['seconds'];
					    rename( $inputFileName, './public/import_template/'.$formated_date.'.xls' );
						$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> " ."Manual Attendance Template without Break Successfully Added!</div>");
						redirect('app/time_manual_attendance');
					} //end of file name for successfully imported
			     }
			     else{
			     	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
					header('Content-Disposition: attachment;filename="' . $fileName. '"');
				    header('Cache-Control: max-age=0');
					unlink($inputFileName);
					$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$objWriter->save('php://output');
					exit; 
			     }

	    }
	    else{
			unlink($inputFileName);
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Something is wrong with your data!</div>");
				redirect('app/time_manual_attendance');
		}
    }

    //===================================End of Template without Break=================================================

// public function testMultipleSheet(){
// 	$companyList = $this->general_model->companyList(); 
// 			  //    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// 					// header('Content-Disposition: attachment;filename="hey.xls"');
// 				 //    header('Cache-Control: max-age=0');	
// $sheetsstitle=array("Group","Subgroup","Brand","UQC","Products");
// $this->load->library('PHPExcel');
//  //$this->load->library('PHPExcel/iofactory');
// $objPHPExcel = new PHPExcel();
// $i=0;
//         $columnarray = array(
//                 'A',
//                 'B',
//                 'C',
//                 'D',
//                 'E',
//                 'F',
//                 'G',
//                 'H',
//                 'I',
//                 'J',
//                 'K');
//         while ($i < 5) {
//             // Add new sheet
//             $objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating
//             ////Write cells
//             if($i==0){
//                 //group data
//                 $objWorkSheet->setCellValue('A1', 'Group ID');
//                 $objWorkSheet->setCellValue('B1', 'Group Name');
//                 $row=2;
//                 foreach($companyList as $idata){
//                     $col=0;
//                     $objWorkSheet->setCellValue($columnarray[$col].$row, $idata->company_id);
//                     $col++;
//                     $objWorkSheet->setCellValue($columnarray[$col].$row, $idata->company_name);
//                     $row++;
//                 }
//             }
//             elseif($i==1){
//                 //subgroup data
//                 $objWorkSheet->setCellValue('A1', 'Subgroup ID');
//                 $objWorkSheet->setCellValue('B1', 'Group Name');
//                 $objWorkSheet->setCellValue('C1', 'Subgroup Name');
//                 $row=2;
//                 foreach($companyList as $idata){
//                     $col=0;
//                     $objWorkSheet->setCellValue($columnarray[$col].$row, $idata->company_id);
//                     $col++;
//                     $objWorkSheet->setCellValue($columnarray[$col].$row, $idata->company_id);
//                     $col++;
//                     $objWorkSheet->setCellValue($columnarray[$col].$row, $idata->company_id);
//                     $row++;
//                 }
//             }
//             elseif($i==2){
//                 //brand data
//                 $objWorkSheet->setCellValue('A1', 'Brand ID');
//                 $objWorkSheet->setCellValue('B1', 'Brand Name');
//                 $row=2;
//                 foreach($companyList as $idata){
//                     $col=0;
//                     $objWorkSheet->setCellValue($columnarray[$col].$row, $idata->company_id);
//                     $col++;
//                     $objWorkSheet->setCellValue($columnarray[$col].$row, $idata->company_id);
//                     $row++;
//                 }
//             }
//             elseif($i==3){
//                 //UQC data
//                 $objWorkSheet->setCellValue('A1', 'UQC ID');
//                 $objWorkSheet->setCellValue('B1', 'UQC Name');
//                 $objWorkSheet->setCellValue('C1', 'Description');
//                 $row=2;
//                 foreach($companyList as $idata){
//                     $col=0;
//                     $objWorkSheet->setCellValue($columnarray[$col].$row, $idata->company_id);
//                     $col++;
//                     $objWorkSheet->setCellValue($columnarray[$col].$row, $idata->company_id);
//                     $col++;
//                     $objWorkSheet->setCellValue($columnarray[$col].$row, $idata->company_id);
//                     $row++;
//                 }
//             }
//             else{
//                 $objWorkSheet->setCellValue('A1', 'Product Code');
//                 $objWorkSheet->setCellValue('B1', 'Product Name');
//                 $objWorkSheet->setCellValue('C1', 'Group ID/Name');
//                 $objWorkSheet->setCellValue('D1', 'Subgroup ID/Name');
//                 $objWorkSheet->setCellValue('E1', 'Brand ID/Name');
//                 $objWorkSheet->setCellValue('F1', 'UQC ID/Name');
//                 $objWorkSheet->setCellValue('G1', 'Size');
//                 $objWorkSheet->setCellValue('H1', 'Alert Quantity');
//                 $objWorkSheet->setCellValue('I1', 'Product Detail');
//             }
//           // Rename sheet
//           $objWorkSheet->setTitle($sheetsstitle[$i]);
//           $i++;
//         }
//         $objPHPExcel->setActiveSheetIndex($i-1);
//         //Freeze pane
//         //$objPHPExcel->getActiveSheet()->freezePane('A2');
//         //Save as an Excel BIFF (xls) file
//         header('Content-Type: application/vnd.ms-excel'); //mime type
//         header('Content-Disposition: attachment;filename="filename.xls"'); //tell browser what's the file name
//         header('Cache-Control: max-age=0'); //no cache

//         //save it to Excel2007 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//         //if you want to save it as .XLSX Excel 2007 format
//         // //force user to download the Excel file without writing it to server's HD
					
// 		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
// 		$objWriter->save('php://output');
// 		exit; 
      
// }
	// =========================================Template with Break===================================================
	
	public function download_attendance_template_withBreak() {
		
        $this->load->helper('download');            
		$path    =   file_get_contents(base_url()."public/downloadable_templates/attendance_template_withBreak.xls");
		$name    =   "attendance_template_withBreak.xls";
		force_download($name, $path); 

		$value = $name;
 
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Manual Upload Attendance','logfile_time_manual_upload_attendance','download with break template : '.$value.'','DOWNLOAD',$value);                            
    }
    public function import_attendance_template_withBreak()
    {
    	$foundError 	= False;

    	if(isset($_POST["import"]))
	    {
			$fileName = $_FILES['file']['name'];

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
					redirect('app/time_manual_attendance');
	            }

	            $objPHPExcel->setActiveSheetIndex(0);
				$sheet 			= $objPHPExcel->getSheet(0);
	            $highestRow 	= $sheet->getHighestRow();
	            $highestColumn 	= $sheet->getHighestColumn();
	            $colNumber 		= PHPExcel_Cell::columnIndexFromString($highestColumn);

	            $forNull 		= 'Value cannot be Null';
	            $existExcel	 	= 'Duplicate data entry';
	            $forTime		= 'Format:hh:mm';
	            $forDate 		= 'Format:yyyy-mm-dd';
	            $forEmployee_id	= 'Employee id does not exist';
	            $invalidDate 	= 'Date does not coincide with other date';
	            $invalidTime 	= 'Time does not coincide with other time';
	            $nextDate		= 'Date out should be next day of date in.';
	            $sameDate		= 'Date out should be the same with date in.';


	            $styleArray = array(
			    'font'  => array(
			        'bold'  => true,
			        'color' => array('rgb' => 'FF0000')
			    ));

			     for ($row = 2; $row <= $highestRow; $row++){
			     	$colLetter 			= 'A';
			     	$check_time_out		= false;
			     	$check_date_out		= false;
			     	$time_in 			= 0;
			     	$time_hour_in 		= 0;
			     	$date_in 			= 0;
			     	$time_out 			= 0;
			     	$time_hour_out 		= 0;
			     	$date_out 			= 0;

			     	$break1_in 			= 0;
			     	$break1_out 		= 0;
			     	$check_break_out	= false;

			     	$lunch_break_in 	= 0;
			     	$lunch_break_out 	= 0;
			     	$break2_in 			= 0;
			     	$break2_out 		= 0;

			     	//Monitor midnight
			     	$check_time_in_break_out  	= false;
					$check_break_out_break_in   = false;
					$check_break_in_lunch_out  	= false;
					$check_lunch_out_lunch_in	= false;
					$check_lunch_in_break2_out	= false;
					$check_break2_out_break2_in	= false;
					$check_break2_in_time_out	= false;
					$check_monitor				= 0;
					//End of monitor midnight

					//Monitor shift
					$check_night_shift			= false;
					//END of Monitor shift

			     	for($col = 0; $col < $colNumber; $col++){
		            	$colrow = $colLetter.(string)$row;    
					    $getCellvalue = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
					    
					    
				    	if($col == 0 || $col == 1 || $col == 2 || $col == 3 || $col == 4 || $col == 5 || $col == 6 || $col == 7 || $col == 8){ // for null
				    		if(empty($getCellvalue)){//If null
								$objPHPExcel->getActiveSheet()->
								setCellValueByColumnAndRow($col, $row,  $forNull);
								$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
								$foundError = True;
							}
							else{
								if($col == 2 || $col == 3 || $col == 4 || $col == 5 || $col == 6 || $col == 7 || $col == 8 ){
									$time =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
									$check = $this->validateTime($time);
									if($check === false){
										$objPHPExcel->getActiveSheet()->
											setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$forTime);//doesn't exist
											$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
									}
									else{
										if($col == 2){
											//$time_hour_in = date('H', strtotime($time));
											$time_in 	  = (date('H', strtotime($time))*60) + date('i', strtotime($time));
											//echo '<br>timein:'.date('H:i', strtotime($time)).'='.$time_in;
											//$time_in 	  = date('H:i', strtotime($time));
											$time_hour_in = date('H', strtotime($time));
											if($time_hour_in <= 3 || $time_hour_in >= 15){//15:00	02:00
												$check_night_shift = true;
											}
										}
										if($col == 3){
											$break1_out 	  = (date('H', strtotime($time))*60) + date('i', strtotime($time));

											$in_break_out_diff	  = $break1_out - $time_in;
											if($in_break_out_diff <= 0){
												$check_time_in_break_out  = true;
												$check_monitor++;
											}

											if($time_in == $break1_out){
												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
											}
											else{
												$in_break_out_diff	  = $break1_out - $time_in;
												if($in_break_out_diff <= 0){
													$check_break_out = true;
												}
											}
										}
										if($col == 4){
											$break1_in 	  = (date('H', strtotime($time))*60) + date('i', strtotime($time));
											

											$in_break_in_diff  = $break1_in - $break1_out;
											if($in_break_in_diff <= 0){
												$check_break_out_break_in = true;
												//echo '<br>true2';
												$check_monitor++;
											}

											if($check_monitor == 1){
												if($check_time_in_break_out === true){
													//echo '<br>Night:'.$time_in.':'.$break1_out.':'.$break1_in.':'.$lunch_break_out.'=';
													if($break1_in >= $time_in||$break1_in <= $break1_out){
														//echo 'found error1';
														$objPHPExcel->getActiveSheet()->
														setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
														$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
															$foundError = True;
													}
												}
												if($check_break_out_break_in === true){
													//echo '<br>Night:'.$time_in.':'.$break1_out.':'.$break1_in.':'.$lunch_break_out.'=';
													if($break1_in >= $time_in||$break1_in >= $break1_out){
													//	echo 'found error2';
														$objPHPExcel->getActiveSheet()->
														setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
														$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
														$foundError = True;
													}
												}
											}
											else if($check_monitor === 0){
												//echo '<br>Normal';
												if($break1_in <= $break1_out || $break1_in <= $time_in){
													$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);//doesn't exist
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
												}
											}
											else{
												//echo '<br>multiple night error';
												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
											}
										}
										if($col == 5){
											$lunch_break_out = (date('H', strtotime($time))*60) + date('i', strtotime($time));

											
											$in_lunch_out_diff	  = $lunch_break_out - $break1_in;
											if($in_lunch_out_diff <= 0){
												$check_break_in_lunch_out  = true;
												//echo '<br>true3';
												$check_monitor++;
											}

											if($check_monitor == 1){
						
												if($check_break_out_break_in === true){
													if($lunch_break_out >= $time_in||$lunch_break_out >= $break1_out||$lunch_break_out <= $break1_in){
														$objPHPExcel->getActiveSheet()->
														setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
														$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
														$foundError = True;
													}
												}
												if($check_break_in_lunch_out === true){
													if($lunch_break_out >= $time_in||$lunch_break_out >= $break1_out||$lunch_break_out >= $break1_in){
														$objPHPExcel->getActiveSheet()->
														setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
														$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
															$foundError = True;
													}
												}
											}
											else if($check_monitor === 0){
												if($lunch_break_out <= $break1_out || $lunch_break_out <= $time_in || $lunch_break_out <= $break1_in){
													$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
												}
											}
											else{
												//echo '<br>multiple night error';
												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
											}

										}
										if($col === 6){
											$lunch_break_in = (date('H', strtotime($time))*60) + date('i', strtotime($time));

											$lunch_in_out_diff	  = $lunch_break_in - $lunch_break_out;
											if($lunch_in_out_diff <= 0){
												$check_lunch_out_lunch_in  = true;
												$check_monitor++;
											}
											if($check_monitor == 1){
												if($check_time_in_break_out === true){
													if($lunch_break_in >= $time_in||$lunch_break_in <= $break1_out||$lunch_break_in <= $break1_in || $lunch_break_in <= $lunch_break_out){
														//echo 'found error1';
														$objPHPExcel->getActiveSheet()->
														setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
														$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
															$foundError = True;
													}
												}
												if($check_break_out_break_in === true){
													if($lunch_break_in >= $time_in||$lunch_break_in >= $break1_out||$lunch_break_in <= $break1_in || $lunch_break_in <= $lunch_break_out){
														$objPHPExcel->getActiveSheet()->
														setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
														$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
														$foundError = True;
													}
												}
												if($check_break_in_lunch_out === true){
													if($lunch_break_in >= $time_in||$lunch_break_in >= $break1_out||$lunch_break_in >= $break1_in || $lunch_break_in <= $lunch_break_out){
														$objPHPExcel->getActiveSheet()->
														setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
														$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
															$foundError = True;
													}
												}
												if($check_lunch_out_lunch_in === true){
													if($lunch_break_in >= $time_in||$lunch_break_in >= $break1_out||$lunch_break_in >= $break1_in || $lunch_break_in >= $lunch_break_out){
														$objPHPExcel->getActiveSheet()->
														setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
														$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
															$foundError = True;
													}
												}
											}
											else if($check_monitor === 0){
												if($lunch_break_in <= $break1_out || $lunch_break_in <= $time_in || $lunch_break_in <= $break1_in || $lunch_break_in <= $lunch_break_out){
													$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
												}
											}
											else{
												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
											}

										}
										if($col === 7){
											$break2_out = (date('H', strtotime($time))*60) + date('i', strtotime($time));

											$in_break2_out_diff	  = $break2_out - $lunch_break_in;
											if($in_break2_out_diff <= 0){
												$check_lunch_in_break2_out  = true;
												$check_monitor++;
											}
											if($check_monitor == 1){
												if($check_time_in_break_out === true){
													if($break2_out >= $time_in||$break2_out <= $break1_out||$break2_out <= $break1_in || $break2_out <= $lunch_break_out || $break2_out <= $lunch_break_in){

														$objPHPExcel->getActiveSheet()->
														setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
														$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
															$foundError = True;
													}
												}
												if($check_break_out_break_in === true){
													if($break2_out >= $time_in||$break2_out >= $break1_out||$break2_out <= $break1_in || $break2_out <= $lunch_break_out || $break2_out <= $lunch_break_in){
														$objPHPExcel->getActiveSheet()->
														setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
														$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
														$foundError = True;
													}
												}
												if($check_break_in_lunch_out === true){
													if($break2_out >= $time_in||$break2_out >= $break1_out||$break2_out >= $break1_in || $break2_out <= $lunch_break_out || $break2_out <= $lunch_break_in){
														$objPHPExcel->getActiveSheet()->
														setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
														$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
															$foundError = True;
													}
												}
												if($check_lunch_out_lunch_in === true){
													if($break2_out >= $time_in||$break2_out >= $break1_out||$break2_out >= $break1_in || $break2_out >= $lunch_break_out || $break2_out <= $lunch_break_in){
														$objPHPExcel->getActiveSheet()->
														setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
														$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
															$foundError = True;
													}
												}
												if($check_lunch_in_break2_out === true){
													if($break2_out >= $time_in||$break2_out >= $break1_out||$break2_out >= $break1_in || $break2_out >= $lunch_break_out || $break2_out >= $lunch_break_in){
														$objPHPExcel->getActiveSheet()->
														setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
														$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
															$foundError = True;
													}
												}
											}
											else if($check_monitor === 0){
												if($break2_out <= $time_in||$break2_out <= $break1_out||$break2_out <= $break1_in || $break2_out <= $lunch_break_out || $break2_out <= $lunch_break_in){
													$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
												}
											}
											else{
												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
											}

										}
										if($col === 8){
											$break2_in = (date('H', strtotime($time))*60) + date('i', strtotime($time));

											$in_break2_in_out_diff	  = $break2_in - $break2_out;
											if($in_break2_in_out_diff <= 0){
												$check_break2_out_break2_in  = true;
												$check_monitor++;
											}
											if($check_monitor == 1){
												if($check_time_in_break_out === true){
													if($break2_in >= $time_in||$break2_in <= $break1_out||$break2_in <= $break1_in || $break2_in <= $lunch_break_out || $break2_in <= $lunch_break_in || $break2_in <= $break2_out){

														$objPHPExcel->getActiveSheet()->
														setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
														$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
															$foundError = True;
													}
												}
												if($check_break_out_break_in === true){
													if($break2_in >= $time_in||$break2_in >= $break1_out||$break2_in <= $break1_in || $break2_in <= $lunch_break_out || $break2_in <= $lunch_break_in || $break2_in <= $break2_out){
														$objPHPExcel->getActiveSheet()->
														setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
														$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
														$foundError = True;
													}
												}
												if($check_break_in_lunch_out === true){
													if($break2_in >= $time_in||$break2_in >= $break1_out||$break2_in >= $break1_in || $break2_in <= $lunch_break_out || $break2_in <= $lunch_break_in || $break2_in <= $break2_out){
														$objPHPExcel->getActiveSheet()->
														setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
														$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
															$foundError = True;
													}
												}
												if($check_lunch_out_lunch_in === true){
													if($break2_in >= $time_in||$break2_in >= $break1_out||$break2_in >= $break1_in || $break2_in >= $lunch_break_out || $break2_in <= $lunch_break_in || $break2_in <= $break2_out){
														$objPHPExcel->getActiveSheet()->
														setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
														$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
															$foundError = True;
													}
												}
												if($check_lunch_in_break2_out === true){
													if($break2_in >= $time_in||$break2_in >= $break1_out||$break2_in >= $break1_in || $break2_in >= $lunch_break_out || $break2_in >= $lunch_break_in || $break2_in <= $break2_out){
														$objPHPExcel->getActiveSheet()->
														setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
														$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
															$foundError = True;
													}
												}
												if($check_break2_out_break2_in === true){
													if($break2_in >= $time_in||$break2_in >= $break1_out||$break2_in >= $break1_in || $break2_in >= $lunch_break_out || $break2_in >= $lunch_break_in || $break2_in >= $break2_out){
														$objPHPExcel->getActiveSheet()->
														setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
														$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
															$foundError = True;
													}
												}
											}
											else if($check_monitor === 0){
												if($break2_in <= $time_in||$break2_in <= $break1_out||$break2_in <= $break1_in || $break2_in <= $lunch_break_out || $break2_in <= $lunch_break_in || $break2_in <= $break2_out){
													$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
												}
											}
											else{
												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
											}

										}
									}
								}
							}
			            }
			            if($col == 0){
							$employee_id =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							$check = $this->time_manual_attendance_model->validate_employeeID($employee_id);
							if($check === false){
								$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$forEmployee_id);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
							}
						}
			            if($col == 1){
							$date =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
							$check = $this->validateDate($date);
							if($check === false){
								$objPHPExcel->getActiveSheet()->
									setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$forDate);//doesn't exist
									$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
										$foundError = True;
							}
							else{
								$date_in 	= $date;
							}
						}
						if($col == 9){
							if(!empty($getCellvalue)){
								$check_time_out = true;
								$time =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
								$check = $this->validateTime($time);
								if($check === false){
									$objPHPExcel->getActiveSheet()->
										setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$forTime);//doesn't exist
										$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
											$foundError = True;
								}
								else{
									$time_hour_out 	  	  = date('H', strtotime($time));
									$time_out = (date('H', strtotime($time))*60) + date('i', strtotime($time));

									$in_time_out_diff	  = $time_out - $break2_in;
									if($in_time_out_diff <= 0){
										$check_break2_in_time_out  = true;
										$check_monitor++;
									}
									if($check_monitor == 1){
										if($check_time_in_break_out === true){
											if($time_out >= $time_in||$time_out <= $break1_out||$time_out <= $break1_in || $time_out <= $lunch_break_out || $time_out <= $lunch_break_in || $time_out <= $break2_out || $time_out <= $break2_in){

												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
											}
										}
										if($check_break_out_break_in === true){
											if($time_out >= $time_in||$time_out >= $break1_out||$time_out <= $break1_in || $time_out <= $lunch_break_out || $time_out <= $lunch_break_in || $time_out <= $break2_out || $time_out <= $break2_in){
												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
											}
										}
										if($check_break_in_lunch_out === true){
											if($time_out >= $time_in||$time_out >= $break1_out||$time_out >= $break1_in || $time_out <= $lunch_break_out || $time_out <= $lunch_break_in || $time_out <= $break2_out || $time_out <= $break2_in){
												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
											}
										}
										if($check_lunch_out_lunch_in === true){
											if($time_out >= $time_in||$time_out >= $break1_out||$time_out >= $break1_in || $time_out >= $lunch_break_out || $time_out <= $lunch_break_in || $time_out <= $break2_out || $time_out <= $break2_in){
												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
											}
										}
										if($check_lunch_in_break2_out === true){
											if($time_out >= $time_in||$time_out >= $break1_out||$time_out >= $break1_in || $time_out >= $lunch_break_out || $time_out >= $lunch_break_in || $time_out <= $break2_out || $time_out <= $break2_in){
												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
											}
										}
										if($check_break2_out_break2_in === true){
											if($time_out >= $time_in||$time_out >= $break1_out||$time_out >= $break1_in || $time_out >= $lunch_break_out || $time_out >= $lunch_break_in || $time_out >= $break2_out || $time_out <= $break2_in){
												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
											}
										}
										if($check_break2_in_time_out === true){
											if($time_out >= $time_in||$time_out >= $break1_out||$time_out >= $break1_in || $time_out >= $lunch_break_out || $time_out >= $lunch_break_in || $time_out >= $break2_out || $time_out >= $break2_in){
												$objPHPExcel->getActiveSheet()->
												setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidTime);
												$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
													$foundError = True;
											}
										}
									}
								}
							}
							
						}
						if($col == 10){
							$date =$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();

							if($check_night_shift == true){
								//echo '<br>1==';
								if(!empty($getCellvalue)){
									//echo '1.1';
									$check = $this->validateDate($date);
									if($check === false){
										$objPHPExcel->getActiveSheet()->
											setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$forDate);//doesn't exist
											$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
												$foundError = True;
									}
									else{
										
										$date_out 	= date('Y-m-d', strtotime($date));
										if($time_in <= 1439 && $time_in >= 900){
											//echo '<br>less than 23:59';
											if($time_in > $time_out){
												$comp_date =  date('Y-m-d',strtotime("+1 day", strtotime($date_in)));
												if($date_out != $comp_date){
													$objPHPExcel->getActiveSheet()->
													setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$nextDate);//doesn't exist
													$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
														$foundError = True;
												}
											}
											else if($time_in < $time_out){
												$comp_date 	= date('Y-m-d', strtotime($date_in));
												if($date_out != $comp_date){
													$objPHPExcel->getActiveSheet()->
													setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$sameDate);//doesn't exist
													$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
														$foundError = True;
												}
											}
											if($time_out == 0){
												//echo '$time == 0';
												$comp_date =  date('Y-m-d',strtotime("+1 day", strtotime($date_in)));
												if($date_out != $comp_date){
													$objPHPExcel->getActiveSheet()->
													setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$nextDate);//doesn't exist
													$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
														$foundError = True;
												}
											}
										}
										else if($time_in >= 0 || $time_in <= 180){//24 - 3
											//echo '<br>greater or equal to zero';
											if($time_in < $time_out){
												//echo '::less timeout';
												$comp_date 	= date('Y-m-d', strtotime($date_in));
												if($date_out != $comp_date){
													$objPHPExcel->getActiveSheet()->
													setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$sameDate);
													$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
														$foundError = True;
												}
											}
											else if($time_in > $time_out){
												//echo '::greater timeout';
												$comp_date =  date('Y-m-d',strtotime("+1 day", strtotime($date_in)));
												if($date_out != $comp_date){
													$objPHPExcel->getActiveSheet()->
													setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$sameDate);//doesn't exist
													$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
														$foundError = True;
												}

											}
											if($time_out == 0){
												$comp_date =  date('Y-m-d',strtotime("+1 day", strtotime($date_in)));
												if($date_out != $comp_date){
													$objPHPExcel->getActiveSheet()->
													setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$nextDate);//doesn't exist
													$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
														$foundError = True;
												}
											}
										}
										/*$comp_date  = date('Y-m-d',strtotime("+1 day", strtotime($date_in)));
										//echo '<br>Night:';
										//echo '<br>'.$date_out.'!='.$comp_date;
										if($date_out != $comp_date){
											$objPHPExcel->getActiveSheet()->
										setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$invalidDate);//doesn't exist
										$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
											$foundError = True;
										}*/

									}
								}
							}
							else{
								$check = $this->validateDate($date);
								if($check === false){
									$objPHPExcel->getActiveSheet()->
										setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$forDate);//doesn't exist
										$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
											$foundError = True;
								}
								else{
									$date_out 	= date('Y-m-d', strtotime($date));
									if($time_in < $time_out){
										$comp_date 	= date('Y-m-d', strtotime($date_in));
										if($date_out != $comp_date){
											$objPHPExcel->getActiveSheet()->
										setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$sameDate);//doesn't exist
										$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
											$foundError = True;
										}

									}
									else if($time_in > $time_out){
										$comp_date = date('Y-m-d',strtotime("+1 day", strtotime($date_in)));
										if($date_out != $comp_date){
											$objPHPExcel->getActiveSheet()->
										setCellValueByColumnAndRow($col, $row,  $getCellvalue.' -> '.$nextDate);//doesn't exist
										$objPHPExcel->getActiveSheet()->getStyle($colrow)->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
											$foundError = True;
										}
									}
								}
							}

						}
						
						
						

					$colLetter++;// increment A
					} //end of for loop col
			     } //end of for loop row

			     if($foundError==False){
			     	for ($row = 2; $row <= $highestRow; $row++){                                  
	                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
	                                                NULL,
	                                                TRUE,
	                                                FALSE);

	                //Monitor shift
					
					$check_night_shift		= false;
					$time_hour_in 			= date('H', strtotime($rowData[0][2]));
					$date_in 				= date('Y-m-d', strtotime($rowData[0][1]));
					$time_out 				= $rowData[0][9];
					$date_out 				= $rowData[0][10];


					if($time_hour_in <= 3 || $time_hour_in >= 15){//15:00	02:00
						$check_night_shift = true;
					}

					if($check_night_shift == true){
						$time_out_minutes = (date('H', strtotime($rowData[0][9]))*60) + date('i', strtotime($rowData[0][9]));
						$time_in_minutes  = (date('H', strtotime($rowData[0][2]))*60) + date('i', strtotime($rowData[0][2]));
						//echo '<br>time_in:'.$time_in_minutes.'::';
						if($time_in_minutes <= 1439 && $time_in_minutes >= 900){//3 - 23:59
							$date_in = date('Y-m-d', strtotime($rowData[0][1]));
							if(!empty($time_out)){
								if($time_out_minutes <= 1439 && $time_out_minutes > $time_in_minutes){
									//$date_out = date('Y-m-d',strtotime("+1 day", strtotime($rowData[0][10])));
									$date_out = date('Y-m-d', strtotime($rowData[0][10]));
								}
								else if($time_out_minutes >= 0  && $time_out_minutes < $time_in_minutes ){//>24 and >time_in
									$date_out = date('Y-m-d', strtotime($rowData[0][10]));
								}
							}
						}
						else if($time_in_minutes >= 0 && $time_in_minutes <= 180){//24 - 3
							//$date_in = date('Y-m-d',strtotime("-1 day", strtotime($rowData[0][1])));
							$date_in = date('Y-m-d', strtotime($rowData[0][1]));
							if(!empty($time_out)){
								if($time_out_minutes <= 1439 && $time_out_minutes > $time_in_minutes){
									$date_out = date('Y-m-d', strtotime($rowData[0][10]));
								}
								else if($time_out_minutes === 0  && $time_out_minutes < $time_in_minutes ){//>24 and >time_in
									//$date_out = date('Y-m-d',strtotime("+1 day", strtotime($date_in)));
									$date_out = date('Y-m-d', strtotime($rowData[0][10]));
								}
								else if($time_out_minutes > 0  && $time_out_minutes > $time_in_minutes ){//>24 and >time_in
									$date_out = date('Y-m-d', strtotime($rowData[0][10]));
								}
							}
						}
						//echo '<br>time_out:'.$time_out_minutes.'::';
					}
					else{
						if(!empty($time_out)){
							$date_out = date('Y-m-d', strtotime($rowData[0][10]));
							//echo 'regular';
						}
					}

					//END of Monitor shift
					

	                $employee_id  		  	= $rowData[0][0];                                                            
					$attendance_table 	  	= 'attendance_'.date('m', strtotime($rowData[0][1]));
					$entry_type			  	= 'Manual upload Template with break';
					$company			  	=  $this->time_manual_attendance_model->get_employee_company($employee_id);
					$company_id			  	=  $company[0]->company_id;
					//$time_in_date			=  date('Y-m-d', strtotime($rowData[0][1]));
					//$time_out_date			=  $rowData[0][10];
					//if(!empty($time_out_date)){
					//	$time_out_date		=  date('Y-m-d', strtotime($rowData[0][10]));
					//}
					$logs_entry    			= 'insert';

					$set_logs_entry = $this->time_manual_attendance_model->check_existAttendance_withBreak($employee_id , $company_id, $date_in, $date_out, $attendance_table);

					if($set_logs_entry === true){
						$logs_entry    = 'delete and insert';
					}

					//for attendance logs
					
					$data = array(

							'employee_id'  		=> $rowData[0][0],
							'company_id'  		=> $company_id,
							'logs_entry'		=> $logs_entry,

							'covered_year'  	=> date('Y', strtotime($rowData[0][1])),
							'time_in_date'  	=> $date_in,
							'time_out_date'  	=> $date_out,

							'entry_type'  		=> $entry_type,
							'entry_date' 	 	=> date("Y-m-d h:i:s a"),
							'user_id'	  		=> $this->session->userdata('employee_id')

	                        );

	                $this->time_manual_attendance_model->insert_attendance_logs($data);



			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Manual Upload Attendance','logfile_time_manual_upload_attendance',''.$entry_type.' for employee '.$rowData[0][0].' timein: '.date('H:i', strtotime($rowData[0][2])).' '.$date_in.' timeout: '.$time_out.' '.$date_out.'','UPLOAD',$rowData[0][0]);


					//end of for attendance logs	              

	                $data = array(

							'employee_id'  		=> $rowData[0][0],
							'company_id'  		=> $company_id,

							'time_in' 			=> date('H:i', strtotime($rowData[0][2])),
							'break_1_out'  		=> date('H:i', strtotime($rowData[0][3])),
							'break_1_in'  		=> date('H:i', strtotime($rowData[0][4])),
							'lunch_break_out'	=> date('H:i', strtotime($rowData[0][5])),
							'lunch_break_in'	=> date('H:i', strtotime($rowData[0][6])),
							'break_2_out'		=> date('H:i', strtotime($rowData[0][7])),
							'break_2_in'		=> date('H:i', strtotime($rowData[0][8])),
							'time_out'			=> $time_out,

							'logs_month'		=> date('m', strtotime($date_in)),
							'logs_day'			=> date('d', strtotime($date_in)),
							'logs_year' 		=> date('Y', strtotime($date_in)),
							'covered_year'  	=> date('Y', strtotime($date_in)),
							'time_in_date'  	=> $date_in,
							'time_out_date'  	=> $date_out,

							'entry_type'  		=> $entry_type,
							'entry_date' 	 	=> date("Y-m-d h:i:s a"),
							'user_id'	  		=> $this->session->userdata('employee_id')

	                        );

	                $insert 	= $this->time_manual_attendance_model->insert_import_attendance_withBreak($data,$attendance_table);

	            	}//end of insert
		            if($insert){ //file name for successfully imported
					    $dt = $date_array = getdate();
					       $formated_date  = "attendance_template_withBreak_";
					       $formated_date .= $date_array['mon'];
					       $formated_date .= $date_array['mday'];
						   $formated_date .= $date_array['year'] . "_";
						   $formated_date .= $date_array['hours'];
					       $formated_date .= $date_array['minutes'];
						   $formated_date .= $date_array['seconds'];
					    rename( $inputFileName, './public/import_template/'.$formated_date.'.xls' );
						$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> " ."Manual Attendance Template with Break Successfully Added!</div>");
						redirect('app/time_manual_attendance'); 
					} //end of file name for successfully imported
					//unlink($inputFileName);
			     }
			     else{
			     	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
					header('Content-Disposition: attachment;filename="' . $fileName. '"');
				    header('Cache-Control: max-age=0');
					unlink($inputFileName);
					$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$objWriter->save('php://output');
					exit; 
			     }
	    }
	    else{
			unlink($inputFileName);
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Something is wrong with your data!</div>");
				redirect('app/time_manual_attendance');
		}
    }
    

    // ======================================End of Template with Break==================================================


 	public function chosen_bio_index(){		
 		$id=$this->uri->segment("4");
 		$m_selected_bio=$this->time_biometrics_setup_model->selected_bio_type($id); 
 		if(!empty($m_selected_bio)){
 			$this->data['bio_name']=$m_selected_bio->bio_name;
 			$this->data['brand_name']=$m_selected_bio->brand_name;

 			$this->data['m_file_loc_name']=$m_selected_bio->file_loc_name;
			$this->data['m_ip_address']=$m_selected_bio->ip_address;
			$this->data['file_table_name']=$m_selected_bio->file_table_name;
			$this->data['employee_id_field_name']=$m_selected_bio->employee_id_field_name;
			$this->data['logs_field_name']=$m_selected_bio->logs_field_name;
			$this->data['logs_type_field_name']=$m_selected_bio->logs_type_field_name;

			$this->data['code_in']=$m_selected_bio->code_in;
			$this->data['code_out']=$m_selected_bio->code_out;
			$this->data['code_break_in1']=$m_selected_bio->code_break_in1;
			$this->data['code_break_out1']=$m_selected_bio->code_break_out1;
			$this->data['code_lunch_in']=$m_selected_bio->code_lunch_in;
			$this->data['code_lunch_out']=$m_selected_bio->code_lunch_out;
			$this->data['code_break_in2']=$m_selected_bio->code_break_in2;
			$this->data['code_break_out2']=$m_selected_bio->code_break_out2;

			$this->data['sync_action_text']=$m_selected_bio->sync_action_text;
			$this->data['sync_action']=$m_selected_bio->sync_action;

			if($this->data['sync_action']=="125"){
				

				if($this->data['code_break_in1']=="" OR $this->data['code_break_out1']=="" 
					OR $this->data['code_lunch_in']=="" OR $this->data['code_lunch_out']==""
					OR $this->data['code_break_in2']=="" OR $this->data['code_break_out2']==""
					){
					
				$this->data['bio_setup_status']="<span class='text-danger'>Notice: Uploading is not allowed. Kindly setup first the biometrics.</span>";

				}else{
					$this->data['bio_setup_status']="";
				}

			}else{
				$this->data['bio_setup_status']="";
				//echo "get in & out only";
			}

			

 		}else{

 			$this->data['bio_setup_status']="<span class='text-danger'>Notice: Uploading is not allowed. Kindly setup first the biometrics.</span>";

 			$this->data['bio_name']="";
 			$this->data['brand_name']="";

			$this->data['m_file_loc_name']="";
			$this->data['m_ip_address']="";
			$this->data['file_table_name']="";
			$this->data['employee_id_field_name']="";
			$this->data['logs_field_name']="";
			$this->data['logs_type_field_name']="";

			$this->data['code_in']="";
			$this->data['code_out']="";
			$this->data['code_break_in1']="";
			$this->data['code_break_out1']="";

			$this->data['code_lunch_in']="";
			$this->data['code_lunch_out']="";
			$this->data['code_break_in2']="";
			$this->data['code_break_out2']="";
			$this->data['sync_action']="";
			$this->data['sync_action_text']="";
 		}




		$this->load->view('app/time/manual_attendance/chosen_bio_index',$this->data);		
	}   

	public function import_biometrics_db(){
		$sms_gateway_status="";//default sms attendance sync notifcation is on automatic uploading only.
		$this->data['message'] = $this->session->flashdata('message');	

		$id=$this->uri->segment("4");
		$bio_detail=$this->time_biometrics_setup_model->selected_bio_type($id);

		if(!empty($bio_detail)){
			$bio_container_type=$bio_detail->bio_container_type;
			$date_container=$bio_detail->date_container;
			$time_container=$bio_detail->time_container;
			
			$data_source_name_driver=$bio_detail->data_source_name_driver;
			$bio_db_type=$bio_detail->bio_db_type;
			$sync_action=$bio_detail->sync_action;
			$bio_db_username=$bio_detail->bio_db_username;
			$bio_db_password=$bio_detail->bio_db_password;
			$code_in=$bio_detail->code_in;
			$code_out=$bio_detail->code_out;
			$code_break_in1=$bio_detail->code_break_in1;
			$code_break_out1=$bio_detail->code_break_out1;
			$code_lunch_in=$bio_detail->code_lunch_in;
			$code_lunch_out=$bio_detail->code_lunch_out;
			$code_break_in2=$bio_detail->code_break_in2;
			$code_break_out2=$bio_detail->code_break_out2;

			$file_table_name=$bio_detail->file_table_name;
			$employee_id_field_name=$bio_detail->employee_id_field_name;
			$logs_field_name=$bio_detail->logs_field_name;
			$logs_type_field_name=$bio_detail->logs_type_field_name;

			if($data_source_name_driver==""){
				$data_source_name_driver="*.mdb, *.accdb";
			}else{

			}
		}else{

			$bio_container_type="";
			$date_container="";
			$time_container="";

			$data_source_name_driver="";
			$bio_db_type="";
			$sync_action="";
			$bio_db_username="";
			$bio_db_password="";
			$code_in="";
			$code_out="";
			$code_break_in1="";
			$code_break_out1="";
			$code_lunch_in="";
			$code_lunch_out="";
			$code_break_in2="";
			$code_break_out2="";

			$file_table_name="";
			$employee_id_field_name="";
			$logs_field_name="";
			$logs_type_field_name="";
		}
		/*
		----------------------------------------------------------
		start upload the file to public/import_biodb foder.
		the read its contents.
		----------------------------------------------------------
		*/
		$fileName = $_FILES['file']['name'];

				$file_pointer = './public/import_template/'.$fileName; 
				  
				if (file_exists($file_pointer))  
				{ 
				  	unlink( './public/import_template/'.$fileName);//overwrite if file name already exist. 
				} 
				else 
				{ 

				}

		$config['upload_path'] = './public/import_biodb/'; 
		$config['overwrite'] = TRUE;
        $config['allowed_types'] = '*'; 
        $config['max_size'] = 10000;
        $config['max_width'] = 1024; 
        $config['max_height'] = 900;
        $config['file_name'] = $fileName;
        $this->load->library('upload', $config);

        $this->upload->do_upload('file');
        if(!$this->upload->do_upload()){
            $error = array('error' => $this->upload->display_errors());
           	// echo '<div class="alert alert-danger">'.$error['error'].'</div>';
        }else{
        	//echo "uploaded";
        }

	    $database_path = './public/import_biodb/'.$fileName;

		$database_path = realpath("$database_path");

		if($bio_db_type=="119"){
		/*
		----------------------------------------------------------
		table: system_parameters default param_id 119 is for Ms Access database type.
		----------------------------------------------------------
		*/
			//$bio_database_type= new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb, *.accdb)}; DBQ=$database_path; Uid=$bio_db_username; Pwd=$bio_db_password;");
			$bio_database_type= new PDO("odbc:DRIVER={Microsoft Access Driver ($data_source_name_driver)}; DBQ=$database_path; Uid=$bio_db_username; Pwd=$bio_db_password;");
		}else{
		/*
		----------------------------------------------------------
		table: system_parameters default param_id 120 is for Microsoft SQL Server database type.
		----------------------------------------------------------
		*/
		}

		if (file_exists($database_path)) {

			$company_connection="";
			$chosen_company=$this->input->post('chosen_company');
			$upload_date_from=$this->input->post('date_from');
			$upload_date_to=$this->input->post('date_to');

					$upload_date_to = new DateTime($upload_date_to);
					$upload_date_to->modify('+1 day');
					$upload_date_to=$upload_date_to->format('Y-m-d');

			$upload_action=$this->input->post('upload_action');
		/*
		----------------------------------------------------------
		table: system_parameters default param_id 124 is for : Get TIME IN & TIME OUT LOGS.
		----------------------------------------------------------
		*/
			if($sync_action=="124"){				
				$for_action="AND ($logs_type_field_name='".$code_in."' OR $logs_type_field_name='".$code_out."')";
				$for_action_out="AND $logs_type_field_name='".$code_out."' ";
			}else{
				$for_action=""; //
			}

			if($upload_action=="upload_and_review"){
				$upload_action_text="Upload and Review";
				$upload_action_text_rmrks="System will not save the data.";
				$logs_rmrks="Review Mode";
			}else{
				$upload_action_text="Upload and Save";
				$upload_action_text_rmrks="System saved the data if validation(s) column is empty.";
				$logs_rmrks="Save Mode";
			}
			$upload_header='<div class="container">
				  <h2>Action taken : '.$upload_action_text.'</h2>
				<table border=1 class="table">  <p class="text-danger">'.$upload_action_text_rmrks.'</p>
				<thead>
				<tr>
					<th class="danger">Employee ID</th>
					<th>Date</th>
					<th>Logs</th>
					<th>Logs Type</th>
					<th>Validation(s)</th>
					<th>Action</th>
				</tr>
				</thead><tbody>';

			if($chosen_company==""){// no chosen company

				$selected_individual_employee_id=$this->input->post('selected_individual_employee_id');
				$company_id=$this->input->post('e_company_id');
				if($selected_individual_employee_id==""){	// and no selected individual employee .

				$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Notice: </strong> No Selected Company Via Group Upload OR No Selected Employee Via Individual Upload, Kindly Choose First.</div>");
					$for_individual="";
					
					$nothing_selected="yes";//no selected individual, no selected company.
				}else{ // individual upload
					$for_individual="AND $employee_id_field_name='".$selected_individual_employee_id."' ";
					$nothing_selected="";

				}

			}else{// with selected company

				$selected_individual_employee_id="";	// force no value individual upload action
				$nothing_selected="";
				foreach ($chosen_company as $key => $chosen_comp_id)
				{
					$company_connection.="a.company_id='".$chosen_comp_id."' OR ";
			
				}

		
				$check_company=$this->time_manual_attendance_model->company_employees($company_connection);
				if(!empty($check_company)){
				echo $upload_header;

					foreach ($check_company as $comp_employee){
						$comp_employee_employee_id=$comp_employee->employee_id;
						$company_id=$comp_employee->company_id;
						$comp_employee_name=$comp_employee->name;


		$my_machine_policy=$this->general_model->get_dtr_setting($company_id,18);
		$machine_attendance_option=$my_machine_policy->single_field_setting;
		if($machine_attendance_option=="FILO"){

			$time_in_order="DESC";
			$time_out_order="ASC";

		}else{

			$time_in_order="DESC";
			$time_out_order="ASC";
		}


		/*
		----------------------------------------------------------
		start : multiple company search from database.
		----------------------------------------------------------
		*/
if($bio_container_type=="separate_column_date_time"){
						$group_upload_in=$bio_database_type->query("SELECT $date_container,$time_container,$employee_id_field_name,$logs_field_name,$logs_type_field_name from `$file_table_name`   WHERE $date_container BETWEEN #$upload_date_from# AND #$upload_date_to# "." AND $employee_id_field_name='".$comp_employee_employee_id."' $for_action order by $logs_field_name $time_in_order");

						$group_upload_out=$bio_database_type->query("SELECT $date_container,$time_container,$employee_id_field_name,$logs_field_name,$logs_type_field_name from `$file_table_name`   WHERE $date_container BETWEEN #$upload_date_from# AND #$upload_date_to# "." AND $employee_id_field_name='".$comp_employee_employee_id."' $for_action_out order by $logs_field_name $time_out_order");

}else{
						$group_upload_in=$bio_database_type->query("SELECT $employee_id_field_name,$logs_field_name,$logs_type_field_name from `$file_table_name`   WHERE $logs_field_name BETWEEN #$upload_date_from# AND #$upload_date_to# "." AND $employee_id_field_name='".$comp_employee_employee_id."' $for_action order by $logs_field_name $time_in_order");

						$group_upload_out=$bio_database_type->query("SELECT $employee_id_field_name,$logs_field_name,$logs_type_field_name from `$file_table_name`   WHERE $logs_field_name BETWEEN #$upload_date_from# AND #$upload_date_to# "." AND $employee_id_field_name='".$comp_employee_employee_id."' $for_action_out order by $logs_field_name $time_out_order");

}



							if(!empty($group_upload_in)){
											$with_data=0;//echo "$comp_employee_employee_id<br>";
									 while ($row=$group_upload_in->fetch()) { 
										  	$with_data=1;

		/*
		----------------------------------------------------------
		validate :start dont allow overwriting of logs if dtr is locked OR payroll is locked OR payroll is already posted.
		----------------------------------------------------------
		*/
require(APPPATH.'controllers/app/time_manual_attendance_upload_validation.php');
		/*
		----------------------------------------------------------
		validate :end dont allow overwriting of logs if dtr is locked OR payroll is locked OR payroll is already posted.
		----------------------------------------------------------
		*/


if($bio_container_type=="separate_column_date_time"){

										  	$logs_date=$row["$date_container"];
										  	$logs_date=substr($logs_date, 0,10);
										  	$logs_time=$row["$time_container"];
										  	$logs_time=substr($logs_time, -8);
										  	$logs_time=substr($logs_time, 0,5);
}else{

										  	$logs_date=$row["$logs_field_name"];
										  	$logs_date=substr($logs_date,0,-9);
										  	$logs_time=$row["$logs_field_name"];
										  	$logs_time=substr($logs_time,11,5);	
}

										  	
										  	$logs_type=$row["$logs_type_field_name"];
										  	if($code_in==$logs_type){
										  		$logs_type_text="IN";
										  	}elseif($code_out==$logs_type){
										  		$logs_type_text="OUT";
										  	}else{
										  		$logs_type_text="INVALID";
										  	}

						$logs_date_month=substr($logs_date, 5,2);
						$logs_year=substr($logs_date, 0,4);
						$logs_month=$logs_date_month;
						$logs_day=substr($logs_date, 8,2);
					  	$attendance_table_name="attendance_".$logs_date_month;				  	

		/*
		----------------------------------------------------------
		start : multiple company. insert time in
		----------------------------------------------------------
		*/
			
			if($upload_action=="upload_and_review"){
						// dont save data.
			}elseif($upload_action=="upload_and_save"){
						//overwrite existing data.

				if($payperiod_dtr_lock=="yes"){// if dtr or payroll is alerady locked.

				}else{


					  	if($logs_type_text=="IN"){
						  	$this->db->query("delete from `$attendance_table_name` where employee_id='".$comp_employee_employee_id."' and time_in_date='".$logs_date."'");	
						  	$this->db->query("insert into `$attendance_table_name` set employee_id='".$comp_employee_employee_id."',company_id='".$company_id."',logs_month='".$logs_month."',logs_day='".$logs_day."',logs_year='".$logs_year."',covered_year='".$logs_year."',time_in='".$logs_time."',entry_type='Manual Upload',entry_date=NOW(),covered_date='".$logs_date."',time_in_date='".$logs_date."'");	

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Manual Upload Attendance','logfile_time_manual_upload_attendance','DB TYPE: MS Access, Biotype ID:'.$id.' for timein of employee: '.$comp_employee_employee_id.',covered date:'.$logs_date.',timeindate:'.$logs_date.', timein:'.$logs_time.'','UPLOAD',$logs_time);


					  	}else{

					  	}
				}
			}else{

			}

										  	echo '
										  		<tr>
										  		<td class="danger">'.$row["$employee_id_field_name"].'</td>
										  		<td>'.$logs_date.'</td>
										  		<td>'.$logs_time.'</td>
										  		<td>'.$logs_type_text.'</td>
										  		<td>'.$upl_warning.'</td>
										  		<td>'.$logs_rmrks.'</td>
										  		</tr>
										  	';
									 }


							}else{
									$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Notice: </strong> No Data Found.</div>");
							}


		/*
		----------------------------------------------------------
		start : multiple company. update time in set time out
		----------------------------------------------------------
		*/

			if($upload_action=="upload_and_review"){
						// dont save data.
			}elseif($upload_action=="upload_and_save"){
						//overwrite existing data.

							if(!empty($group_upload_out)){

									 while ($row=$group_upload_out->fetch()) { 


if($bio_container_type=="separate_column_date_time"){

										  	$logs_date=$row["$date_container"];
										  	$logs_date=substr($logs_date, 0,10);
										  	$logs_time=$row["$time_container"];
										  	$logs_time=substr($logs_time, -8);
										  	$logs_time=substr($logs_time, 0,5);
}else{

										  	$logs_date=$row["$logs_field_name"];
										  	$logs_date=substr($logs_date,0,-9);
										  	$logs_time=$row["$logs_field_name"];
										  	$logs_time=substr($logs_time,11,5);


}										  	
										  	
										  	$logs_type=$row["$logs_type_field_name"];
										  	if($code_in==$logs_type){
										  		$logs_type_text="IN";
										  	}elseif($code_out==$logs_type){
										  		$logs_type_text="OUT";
										  	}else{
										  		$logs_type_text="INVALID";
										  	}

								if($logs_type_text=="OUT"){

				if($payperiod_dtr_lock=="yes"){// if dtr or payroll is alerady locked.
					
				}else{

					$sync_type="manual";
					$out_desig=$this->time_manual_attendance_model->check_out_designation($selected_individual_employee_id,$logs_date,$logs_year,$logs_month,$logs_day,$logs_time,$comp_employee_employee_id,$sync_type,$comp_employee_name,$sms_gateway_status);

				}

		/*
		----------------------------------------------------------
		start : validate covered date of logs.
		a) can validate through shift or 
		b) via actual logs comparison
		----------------------------------------------------------
		*/

require(APPPATH.'controllers/app/time_manual_attendance_logs_validation_grp.php');

		/*
		----------------------------------------------------------
		end : validate covered date of logs.
		a) can validate through shift or 
		b) via actual logs comparison
		----------------------------------------------------------
		*/




							  	}else{

							  	}

									}// end of while loop.
							}else{

							}
			}else{

			}



					}
				}else{
				
				$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Notice: </strong> No Employee Found On the chosen company.</div>");
				}
			
				$for_individual="";
			}
		
			// ===== 
			if(($nothing_selected=="")AND($for_individual)){
			
			$comp_employee_employee_id=""; // set multiple upload employee id holder to null.
			$my_machine_policy=$this->general_model->get_dtr_setting($company_id,18);
			$machine_attendance_option=$my_machine_policy->single_field_setting;
			if($machine_attendance_option=="FILO"){

				$time_in_order="DESC";
				$time_out_order="ASC";

			}else{

				$time_in_order="DESC";
				$time_out_order="ASC";
			}

		/*
		----------------------------------------------------------
		start : individual employee upload.
		----------------------------------------------------------
		*/
				$individual_upload=$bio_database_type->query("SELECT $employee_id_field_name,$logs_field_name,$logs_type_field_name from `$file_table_name`   WHERE $logs_field_name BETWEEN #$upload_date_from# AND #$upload_date_to# "." $for_individual $for_action order by $logs_field_name $time_in_order");

				$individual_upload_out=$bio_database_type->query("SELECT $employee_id_field_name,$logs_field_name,$logs_type_field_name from `$file_table_name`   WHERE $logs_field_name BETWEEN #$upload_date_from# AND #$upload_date_to# "." $for_individual $for_action order by $logs_field_name $time_out_order");

					if(!empty($individual_upload)){

							$with_data=0;
							echo $upload_header;

						  while ($row=$individual_upload->fetch()) { 

						  	$with_data=1;
		/*
		----------------------------------------------------------
		validate :start dont allow overwriting of logs if dtr is locked OR payroll is locked OR payroll is already posted.
		----------------------------------------------------------
		*/
require(APPPATH.'controllers/app/time_manual_attendance_upload_validation.php');
		/*
		----------------------------------------------------------
		validate :end dont allow overwriting of logs if dtr is locked OR payroll is locked OR payroll is already posted.
		----------------------------------------------------------
		*/
						  	$logs_date=$row["$logs_field_name"];
						  	$logs_date=substr($logs_date,0,-9);
						  	$logs_time=$row["$logs_field_name"];
						  	$logs_time=substr($logs_time,11,5);
						  	
						  	$logs_type=$row["$logs_type_field_name"];
						  	if($code_in==$logs_type){
						  		$logs_type_text="IN";
						  	}elseif($code_out==$logs_type){
						  		$logs_type_text="OUT";
						  	}else{
						  		$logs_type_text="INVALID";
						  	}
						  	
						$logs_date_month=substr($logs_date, 5,2);
						$logs_year=substr($logs_date, 0,4);
						$logs_month=$logs_date_month;
						$logs_day=substr($logs_date, 8,2);

					  	$attendance_table_name="attendance_".$logs_date_month;				  	

			if($upload_action=="upload_and_review"){
						// dont save data.
			}elseif($upload_action=="upload_and_save"){

					  	if($logs_type_text=="IN"){
				if($payperiod_dtr_lock=="yes"){// if dtr or payroll is alerady locked.

					//echo "$logs_date  $payroll_mm_tbl_payroll_period_id<br>";
				}else{

					if($payperiod_dtr_lock=="yes"){// if dtr or payroll is alerady locked.

					}else{

						  	$this->db->query("delete from `$attendance_table_name` where employee_id='".$selected_individual_employee_id."' and time_in_date='".$logs_date."'");	

						  	$this->db->query("insert into `$attendance_table_name` set employee_id='".$selected_individual_employee_id."',company_id='".$company_id."',logs_month='".$logs_month."',logs_day='".$logs_day."',logs_year='".$logs_year."',covered_year='".$logs_year."',time_in='".$logs_time."',time_in_date='".$logs_date."',entry_type='Manual Upload',entry_date=NOW(),covered_date='".$logs_date."'");	

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Manual Upload Attendance','logfile_time_manual_upload_attendance','DB TYPE: MS Access, Biotype ID:'.$id.' for timein of employee: '.$selected_individual_employee_id.',covered date:'.$logs_date.',timeindate:'.$logs_date.', timein:'.$logs_time.'','UPLOAD',$logs_time);


					}
				}

					  	}else{

					  	}
			}else{

			}
						  	echo '
						  		<tr>
						  		<td class="danger">'.$row["$employee_id_field_name"].'</td>
						  		<td>'.$logs_date.'</td>
						  		<td>'.$logs_time.'</td>
						  		<td>'.$logs_type_text.'</td>
						  		<td>'.$upl_warning.'</td>
						  		<td>'.$logs_rmrks.'</td>
						  		</tr>

						  	';
						  
						  }

						  if($with_data==0){

						  	echo '<tr><td colspan="5">'.
							"<div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Notice: </strong>Employee: '".$selected_individual_employee_id."' No Logs Found for '".$upload_date_from."' to  '".$upload_date_to."' </div>".
						  	' </td></tr>';

						  }else{

						  }
					  	echo '</tbody></table></div>';

					  
					}else{

						$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Notice: </strong> No Data Found.</div>");
					}

		/*
		----------------------------------------------------------
		start : individual employee upload : update time out
		----------------------------------------------------------
		*/

		if($upload_action=="upload_and_review"){
						// dont save data.
		}elseif($upload_action=="upload_and_save"){


							if(!empty($individual_upload_out)){

									 while ($row=$individual_upload_out->fetch()) { 
										  	

										  	$logs_date=$row["$logs_field_name"];
										  	$logs_date=substr($logs_date,0,-9);
										  	$logs_time=$row["$logs_field_name"];
										  	$logs_time=substr($logs_time,11,5);
										  	
										  	$logs_type=$row["$logs_type_field_name"];
										  	if($code_in==$logs_type){
										  		$logs_type_text="IN";
										  	}elseif($code_out==$logs_type){
										  		$logs_type_text="OUT";
										  	}else{
										  		$logs_type_text="INVALID";
										  	}

										if($logs_type_text=="OUT"){
										$comp_employee_employee_id="";
										$comp_employee_name="";
				if($payperiod_dtr_lock=="yes"){// if dtr or payroll is alerady locked.
					
				}else{
				$sync_type="manual";
				$out_desig=$this->time_manual_attendance_model->check_out_designation($selected_individual_employee_id,$logs_date,$logs_year,$logs_month,$logs_day,$logs_time,$comp_employee_employee_id,$sync_type,$comp_employee_name,$sms_gateway_status);

				}		
		/*
		----------------------------------------------------------
		start : validate covered date of logs.
		a) can validate through shift or 
		b) via actual logs comparison
		----------------------------------------------------------
		*/

require(APPPATH.'controllers/app/time_manual_attendance_logs_validation_ind.php');
		


		/*
		----------------------------------------------------------
		end : validate covered date of logs.
		a) can validate through shift or 
		b) via actual logs comparison
		----------------------------------------------------------
		*/



									  	}else{

									  	}
									}
							}else{

							}
		}else{

		}

			}else{// end of if individual upload.

			}






		}else{ // file is not uploaded.

				$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>Notice: </strong> File Not Uploaded.</div>");

		}

		$this->load->view("app/time/manual_attendance/chosen_bio_index_result",$this->data);


	}// function end.


	public function showSearchEmployee($val = NULL){

		// $info = $this->uri->segment("5");
		$this->data['showEmployeeList'] = $this->time_manual_attendance_model->getSearch_Employee($val); //getEmp //getSearch_Employee
		$this->load->view("app/time/manual_attendance/showEmployeeList",$this->data);	
	}

	public function select_emp($val = NULL){	
		$selected_emp=$this->uri->segment('4');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->data['emp'] = $this->time_manual_attendance_model->get_selected_emp($selected_emp);
		
		$this->load->view('app/time/manual_attendance/show_employee',$this->data);
	}
}