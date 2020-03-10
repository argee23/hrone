<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Payroll_other_addition_automatic extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/payroll_other_addition_automatic_model");
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

public function automatic_addition(){	 

		$company_id=$this->uri->segment('4');
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->data['additiontype_list'] = $this->payroll_other_addition_automatic_model->addition_type_list($company_id);
		$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/automatic_addition_view',$this->data);		
	}


//SELCT CUTOFF=====================================================================================================

public function select_cutoff($company_id){

		$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/select_cutoff',$this->data);		

}

//SELECT CUTOFF EDIT===============================================================================================

public function select_cutoff_edit($company_id){

		$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/select_cutoff_edit',$this->data);		

}



//START OF ADDING NEW AUTOMATIC ADDITION===========================================================================
public function add_new_automatic_addition(){
        $company_id =$this->uri->segment('4');

        $this->data['paytypeList_addition'] = $this->payroll_other_addition_automatic_model->paytypeList_addition();		
		$this->data['addition_type'] = $this->payroll_other_addition_automatic_model->get_addition_result_add($company_id);
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->data['pay_type_option'] = $this->payroll_other_addition_automatic_model->pay_type_option();
		$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/add_new_automatic_addition',$this->data);
	}

//ADD SET AUTOMATIC==========================================================================================

public function save_new_automatic_additions($cutoff,$company_id,$id,$effectivity_date,$pay_type,$is_automatic){	 
		

		$already_exist = $this->payroll_other_addition_automatic_model->check_exist_auto($cutoff,$company_id,$id,$effectivity_date,$pay_type,$is_automatic);
		if($already_exist == 1){

				$other_addition_code = $this->payroll_other_addition_automatic_model->flash_add_update($id);
					$value = $other_addition_code->other_addition_code." (".$other_addition_code->id.")";

				General::logfile('Other Additions Automatic','ADDED',$value);

				$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The Addition, <strong>".$value."</strong>is Already Exist!</div>");

		}else{

				$other_addition_code = $this->payroll_other_addition_automatic_model->flash_add_update($id);

				$this->payroll_other_addition_automatic_model->automatic_addition_saves($cutoff,$company_id,$id,$effectivity_date,$pay_type,$is_automatic);

				$value = $other_addition_code->other_addition_code." (".$other_addition_code->id.")";

				General::logfile('Other Additions Automatic','ADDED',$value);

				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The Addition, <strong>".$value."</strong>is Successfully Added!</div>");
		}
		
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->data['additiontype_list'] = $this->payroll_other_addition_automatic_model->addition_type_list($company_id);
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/save_new_automatic_additions',$this->data);		
		
	}

//EDIT SET AUTOMATIC ADDITION WITH EMPLOYEE/WITHOUT ENROLL===================================================================================

	public function edit_set_automatic_addition($cutoff,$pay_type,$date_effective,$oa_id,$company_id,$id){
		
	
		$this->data['addition_type'] = $this->payroll_other_addition_automatic_model->get_addition_result_edit($oa_id,$company_id);
	    $this->data['paytypeList_addition'] = $this->payroll_other_addition_automatic_model->paytypeList_addition();
	    $this->data['paytypeList_selected'] = $this->payroll_other_addition_automatic_model->paytypeList_addition_selected($pay_type);		
		$this->data['query'] = $this->payroll_other_addition_automatic_model->viewDetails_model($cutoff,$pay_type,$date_effective,$oa_id,$company_id,$id);
		$this->data['pay_type_option'] = $this->payroll_other_addition_automatic_model->pay_type_option();

		$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/edit_set_automatic_addition',$this->data);


	}

//EDIT SET AUTOMATIC ADDITION WITHOUT EMPLOYEE ENROLL===================================================================================

	public function edit_set_automatic_addition_ne($cutoff,$pay_type,$date_effective,$oa_id,$company_id){

	
		$this->data['addition_type'] = $this->payroll_other_addition_automatic_model->get_addition_result($oa_id,$company_id);
	    $this->data['paytypeList_addition'] = $this->payroll_other_addition_automatic_model->paytypeList_addition();
	      $this->data['paytypeList_selected'] = $this->payroll_other_addition_automatic_model->paytypeList_addition_selected($pay_type);		
		$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/edit_set_automatic_addition',$this->data);


	}

//UPDATE SET AUTOMATIC WITH ENROLL EMPLOYEE==========================================================================================

public function save_edit_e_automatic_additions($cutoff,$company_id,$id,$oa_id,$effectivity_date,$pay_type,$is_automatic){	 

		$other_addition_code = $this->payroll_other_addition_automatic_model->flash_add_updates($oa_id);


		$this->payroll_other_addition_automatic_model->automatic_addition_saves_e($cutoff,$company_id,$id,$oa_id,$effectivity_date,$pay_type,$is_automatic);

		$value = $other_addition_code->other_addition_code." (".$other_addition_code->id.")";

		General::logfile('Other Additions Automatic','UPDATED',$value);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The Date Effectiivity of Addition, <strong>".$value."</strong> is Successfully Updated!</div>");
		
		
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->data['additiontype_list'] = $this->payroll_other_addition_automatic_model->addition_type_list($company_id);
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/save_new_automatic_additions',$this->data);		
		
	}


//UPDATE SET AUTOMATIC WITHOUT ENROLL EMPLOYEE==========================================================================================

public function save_edit_ne_automatic_additions($cutoff,$company_id,$id,$oa_id,$effectivity_date,$pay_type,$is_automatic){	 

$other_addition_code = $this->payroll_other_addition_automatic_model->flash_add_updates($oa_id);

	
		$this->payroll_other_addition_automatic_model->automatic_addition_saves_ne($cutoff,$company_id,$id,$oa_id,$effectivity_date,$pay_type,$is_automatic);

		$value = $other_addition_code->other_addition_code." (".$other_addition_code->id.")";

		General::logfile('Other Additions Automatic','UPDATED',$value);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The Addition, <strong>".$value."</strong> is Successfully Updated!</div>");
		
		
		
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->data['additiontype_list'] = $this->payroll_other_addition_automatic_model->addition_type_list($company_id);
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/save_new_automatic_additions',$this->data);		
		
	}

//SET AUTOMATIC ADDITION IS _AUTOMATIC TO ZERO=================================================================

 public function is_automatic_to_zero($company_id,$id,$oa_id){

 		$other_addition_code = $this->payroll_other_addition_automatic_model->delete_auto($oa_id);

		//$this->payroll_other_addition_automatic_model->is_automatic_to_zero($company_id,$id);
		$this->db->query("delete from other_addition_type_automatic where id = ".$id);
		// logfile
		$value = $other_addition_code->other_addition_code." (".$other_addition_code->id.")";

		General::logfile('Other Additions Automatic','DELETED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Deleted!</div>");
		
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->data['additiontype_list'] = $this->payroll_other_addition_automatic_model->addition_type_list($company_id);
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/save_new_automatic_additions',$this->data);		
 }

//BY GROUP=====================================================================================================

public function by_group($company_id,$pay_type_id){

			$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/by_group',$this->data);	
		
	}	


//GET PAYROLL PERIOD BY GROUP PAYTYPE=================================================================================
	public function by_employee_filtering(){	
		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");
		$pay_type_group=$this->uri->segment("6");
		$this->data['pay_per_addition'] = $this->payroll_other_addition_automatic_model->payroll_per_per_company_pay_type($company_id,$pay_type,$pay_type_group);//$company_id
			$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/employee_filtering',$this->data);	
		
	}

public function show_div_dept(){
		$company_id=$this->uri->segment("4");
		$division_id=$this->uri->segment("5");
		$this->data['get_div_dept'] = $this->general_model->get_company_division_departments($company_id,$division_id);

		$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/show_div_dept',$this->data);
	}	

public function show_section(){
		$dept_id=$this->uri->segment("4");
		$this->data['get_section'] = $this->general_model->getSec($dept_id);

		$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/show_section',$this->data);
	}	
	
public function clear_fetched_sub_sec(){

		$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/show_clear_fetched_sub_sec',$this->data);
	}

public function show_sub_section(){
		$section_id=$this->uri->segment("4");
		$section=$this->uri->segment("4");

		$this->data['check_section'] = $this->general_model->get_the_section($section);
		$this->data['get_sub_section'] = $this->general_model->get_sec_subsection($section_id);
		$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/show_sub_section',$this->data);
	}	

//GENERATE EMPLOYEE============================================================================================

public function generate_employee_automatic_add(){

		

		$company_id=$this->input->post('company_id');

		$this->data['company_info'] = $this->general_model->get_company_info($company_id);
		$comp_info = $this->general_model->get_company_info($company_id);
		$comp_division_setting=$comp_info->wDivision;
		
		//$id=$this->input->post('pay_period'); // payroll period id

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
		$this->data['employee'] = $this->payroll_other_addition_automatic_model->get_addition_employeeList($company_id,$comp_division_setting,$sub_sec_setting,$pay_type_group);
		$this->data['automatic_enrollment'] = $this->payroll_other_addition_automatic_model->getAdditionEnrollments();
		$this->data['addition_type'] = $this->payroll_other_addition_automatic_model->getAdditionTypes($company_id);	
		$this->data['payroll_formula_list'] = $this->payroll_other_addition_automatic_model->all_formula_by_tier();	
		$this->data['formula_list'] = $this->payroll_other_addition_automatic_model->formula_by_tier();	
		$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/generate_employee_automatic',$this->data);
	}

//SAVING ADDITION EMPLOYEE ENROLLMENT=======================================================================================

function save_addition_enroll_automatic(){
		$employee_id = $this->input->post('employee_id');
		$company_id= $this->input->post('company_id');
		$cutoff = $this->input->post('cutoff');
		$effective_date = $this->input->post('effective_date');		

		// save data
		$this->payroll_other_addition_automatic_model->save_addition_enroll_automatic();
		

		//echo "<script type='text/javascript'>alert('Successfully Added!')/'/'</script>";
		echo "<script>";
		echo "window.close();";
		echo "window.opener.location.reload();";
		echo "</script>";

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> This, <strong>Other Addition Enrollment</strong>, is Successfully Added!</div>");
		
		$this->session->set_flashdata('onload',"view(".$company_id.")");

		

}


//DEACTIVATEandACTIVATE OTHER ADDITIONS AUTOMATIC==============================================================
	public function deactivate_addition_auto(){

		$id = $this->uri->segment("4");
		$other_addition_code = $this->payroll_other_addition_automatic_model->delete_lists($id);

		$this->payroll_other_addition_automatic_model->deactivate_list($id);

		// logfile
		$value = $other_addition_code->other_addition_code." (".$other_addition_code->id.")";

		General::logfile('Other Additions Automatic','DISABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> This Automatic Addition <strong>".$value."</strong> is Successfully Deactivated!</div>");

		redirect(base_url().'app/payroll_other_addition_emp_enrollment/index',$this->data);
	}

	public function activate_addition_auto(){

		$id = $this->uri->segment("4");
		$other_addition_code = $this->payroll_other_addition_automatic_model->delete_lists($id);

		$this->payroll_other_addition_automatic_model->activate_list($id);

		// logfile
		$value = $additionlist->other_addition_code." (".$additionlist->id.")";

		General::logfile('Other Additions Automatic','ENABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Activated!</div>");

		redirect(base_url().'app/payroll_other_addition_emp_enrollment/index',$this->data);
	}


// ========== gel

public function manual_upload_automatic_allowance(){//gel

    $action=$this->input->post('action');
    $pay_type=$this->input->post('pay_type_id');
    $cutoff=$this->input->post('cutoff');
    $date_effectivity=$this->input->post('date_effectivity');

    $other_addition_id=$this->input->post('other_addition_id');
    $company_id=$this->input->post('company_id');


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
                $config['upload_path']    = './public/import_template/'; 
                $config['file_name']    = $fileName;
                $config['allowed_types']  = 'xlsx|xls';
                $config['max_size']     = 10000;

                $this->load->library('upload');
                $this->upload->initialize($config);

                if(! $this->upload->do_upload('file') )
                  $this->upload->display_errors();

                $media = $this->upload->data('file');
                $inputFileName = './public/import_template/'.$fileName;

                  try {

                        $inputFileType  = IOFactory::identify($inputFileName);
                        $objReader    = IOFactory::createReader($inputFileType);
                        $objPHPExcel  = $objReader->load($inputFileName);
                   
                    } catch(Exception $e) {
                      unlink($inputFileName);
                        $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Error file type/file name. Allowed file type: .xlsx/.xls </div>");
                redirect('app/transaction_employees');
                    }

                    $objPHPExcel->setActiveSheetIndex(0);
              $sheet      = $objPHPExcel->getSheet(0);
                    $highestRow   = $sheet->getHighestRow();
                    $highestColumn  = $sheet->getHighestColumn();
                    $colNumber    = PHPExcel_Cell::columnIndexFromString($highestColumn);

                    $row_error_message  ='';

              echo '
              <table style="width:100%;" border="1">
              <thead>
                <tr>
                  <th colspan="11" style="color:#ff0000;">Note: This template is for manual uploading of automatic other addition only.</th>
                </tr>
                <tr>
                  <th>Employee ID</th>
                  <th>Other Addition ID</th>
                  <th>Main Amount( Open Entry )</th>
                  <th>Another Amount( Open Entry )</th>
                  <th>Formula ID</th>
                  <th>Remarks</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              ';    

                 for ($row = 2; $row <= $highestRow; $row++){
                  $colLetter      = 'A';

						$employee_id    = '';

						$main_open_entry= '';
						$optional_open_entry='';
						$formula_id='';
						$formula_description='';
						$other_addition_type="";
						$row_error_message      = '';

                  for($col = 0; $col < $colNumber; $col++){
                        $colrow = $colLetter.(string)$row;    
                    $getCellvalue = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();    

        if($col=="0"){
          $employee_id=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
        }elseif($col=="1"){
          $main_open_entry=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
        }elseif($col=="2"){
          $optional_open_entry=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
        }elseif($col=="3"){
          $formula_id=$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row)->getValue();
        }else{
        }
                    $colLetter++;
                }// col array



        // ======= verify employee id
        $checkEmp=$this->payroll_other_addition_automatic_model->checkEmp($employee_id,$company_id);
        if(!empty($checkEmp)){
          $company_id=$checkEmp->company_id;

          $check_oa=$this->payroll_other_addition_automatic_model->check_other_addition($other_addition_id);
          if(!empty($check_oa)){
          	$other_addition_type=$check_oa->other_addition_type;
          	 if($formula_id==""){
          	 	
          	 }else{
          	 	$check_formula=$this->payroll_other_addition_automatic_model->check_oa_formula($formula_id,$company_id);
          	 	if(!empty($check_formula)){
          	 		$formula_description=$check_formula->formula_description;
          	 	}else{
          	 		$row_error_message="Formula ID not exist";
          	 	}
          	 }
          	 

          }else{
          	$row_error_message="Other Addition ID not exist";
          }


        }else{
         
          $row_error_message="Employee does not exist";
        }


        if($row_error_message==""){
        	if($main_open_entry>0){

        	}else{
        		$row_error_message="Incorrect Content of Main Open Entry";
        	}

        }else{

        }
        if($row_error_message==""){

        	if($optional_open_entry>0 OR $optional_open_entry<0 OR $optional_open_entry==""){

        	}else{
        		$row_error_message="Incorrect Content of Optional Open Entry";
        	}

        }else{

        }


      if($action=="Save"){

        if($row_error_message==""){
                $query = $this->db->query("DELETE FROM other_addition_automatic WHERE employee_id='".$employee_id."' AND other_addition_id='".$other_addition_id."' AND company_id='".$company_id."' ");

                $auto_addition_template = array(
                 'company_id' =>  $company_id,
                 'employee_id'  => $employee_id,
                 'other_addition_id' => $other_addition_id,
                 'open_entry' => $main_open_entry,
                 'optional_open_entry' => $optional_open_entry,
                 'pay_type' => $pay_type,
                 'cutoff'  => $cutoff,
                 'payroll_formulas_id'  => $formula_id,
               
                 'entry_type'  => 'manual upload excel',
                 'date_effective'  => $date_effectivity,
                 'date_added' => date('Y-m-d H:i:s'),
                 'comment' => ''
                );


                $insert = $this->payroll_other_addition_automatic_model->insert_auto_addition_template($auto_addition_template);
        
                
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
        <td>'.$other_addition_type.'['.$other_addition_id.']</td>
        <td>'.$main_open_entry.'</td>
        <td>'.$optional_open_entry.'</td>';

        if($formula_id==""){
        		echo '<td>'.$formula_description.'</td>';
        }else{
        	echo '<td>'.$formula_description.' ['.$formula_id.']</td>';
        }
        

        echo '
        <td '.$warning_hylight.'>'.$row_error_message.'</td>
        <td '.$warning_hylight.'>'.$action_result.'</td>
        </tr>
      ';


              }//row array
      echo '
      </tbody>
      </table>

      ';


      }//if import end



  }

// ========== gel






//MANUAL EXCEL UPLOAD FOR AUTOMATIC ADDITION=====================================================================

public function manual_excel_upload_auto($company_id,$oa_id,$date_effective,$pay_type,$cutoff){
	
		$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/manual_excel_upload_auto',$this->data);


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
											             $result_pf_id_checker = $this->payroll_other_addition_automatic_model->pfidnotexist($pf_id_checker);
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
											             $result_emp_id_checker = $this->payroll_other_addition_automatic_model->empidnotexist($emp_id_checker,$company,$pt_id);
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
				$insert="s";
		         if($foundError==False){ // insert to employee_info table
		        	for ($row = 2; $row <= $highestRow; $row++){
								            	$numOfEmp++;                                  
								                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
		                                            NULL,
		                                            TRUE,
		                                           	FALSE);

								                  $employee_id = $rowData[0][0]; 
									              $pay_type  = $this->input->post('pay_type_id');  
									              $oa_id = $this->input->post('other_addition_id');
									              $company_id = $this->input->post('company_id');
									              $cut_off = $this->input->post('cutoff');
								           
								             $dataexist = $this->payroll_other_addition_automatic_model->check_exist($employee_id,$pay_type,$oa_id,$company_id,$cut_off);
							                if($dataexist ==1){
							                	//ECHO "ALREADY EXIST IN THE DATABASE";
							                	$this->db->delete("other_addition_automatic", array('other_addition_id' => $oa_id, 'employee_id'=>$employee_id,'pay_type' => $pay_type, 'cutoff' => $cut_off));

								                $data = array('employee_id'  			=> $employee_id,
								                				'company_id'  			=> $company_id,
								                				'other_addition_id' 	=> $oa_id,
								                				'open_entry'  			=> $rowData[0][1],
								                				'pay_type'  			=> $pay_type,
								                				'cutoff'  				=> $cut_off,
								                				'payroll_formulas_id'   => $rowData[0][2],
								                				'entry_type'  			=> $this->input->post('entry_type'),
								                				'date_effective'  		=> $this->input->post('date_effectivity'),
								                				'date_added'  			=> date('Y-m-d H:i:s')
								                				
								                			  );
	                							$insert = $this->payroll_other_addition_automatic_model->insertImport($data);
	                						}

	            	}//end of insert
			            if($insert){ //file name for successfully imported
				            	$this->data['action']='save';
								$this->data['count_data']=$highestRow - 1;
								$this->data['company']=$company;
								$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/review_upload/template_header',$this->data);
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
									$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/review_upload/template_content',$this->data);
								}
								$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/review_upload/template_footer',$this->data);
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
					header('Content-Disposition: attachment;filename="' ."set_auto_addition_template_error". '""' .date('Y-m-d')."_".date('H:i:s').".xlsx".'"');
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
					$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/review_upload/template_header',$this->data);
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
							$resultemployee_companylist = $this->payroll_other_addition_automatic_model->employee_company_checker_model($employee_companylist,$company,$pt_id);
								if($resultemployee_companylist === false){
									$foundError = True;
									$emp_comp='Employee doesnt exist in company Id '.$company.' or employee is not belong to this Paytype Id '.$pt_id.'<br>';
								} else{  $emp_comp=''; }
							
							/*$getpf = $col_2;
							$result_pf_id = $this->payroll_other_addition_automatic_model->pf_id_checker_model($getpf);
							if($result_pf_id === false){
									$foundError = True;
									$pf_id='Payroll Formulas not Exist';
								} else{  $pf_id=''; }
*/
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
								
								$this->data['errors']= $null.'<br>'.$emp_comp.'<br>'.$decim.'<br>'.$exist_excel.'<br>'.$pf_error.'<br>'.$pf_id;
							}
							else{
								$this->data['remarks']= 'Ok';
							}
							$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/review_upload/template_content',$this->data);
				}
					$this->load->view('app/payroll/other_addition_emp_enrollment/automatic_addition/review_upload/template_footer',$this->data);
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











