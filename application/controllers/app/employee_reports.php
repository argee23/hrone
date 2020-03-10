<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Employee_reports extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/employee_reports_model");
		$this->load->model("app/report_analytics_employees_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	public function extract_coe(){
		$company_id=$this->input->post('company_id');
		$resigned_date=$this->input->post('resigned_date');
		$employee_status=$this->input->post('employee_status');
		$signed_date=$this->input->post('signed_date');
		$coe_reason=$this->input->post('coe_reason');
		
		$inc_salary=$this->input->post('inc_salary');
		

		$this->data['inc_salary']=$inc_salary;
		$this->data['signed_date']=$signed_date;
		$this->data['coe_reason']=$coe_reason;
		$s_emp=$this->employee_reports_model->getSignatory($company_id);
		if(!empty($s_emp)){
			$signatory_emp_id=$s_emp->employee_id;
		}else{
			$signatory_emp_id="";
		}
		$this->data['signatory_emp_id']=$signatory_emp_id;

		$this->data['sig_info']=$this->employee_reports_model->get_emp_info($signatory_emp_id);

		$this->data['cinfo']=$this->general_model->get_company_info($company_id);
		$this->data['emp_coe']=$this->employee_reports_model->extract_coe($company_id,$resigned_date,$employee_status);
		$this->data['esig']=$this->employee_reports_model->getCoeESigSetup();
		//echo "$company_id | $resigned_date |$employee_status<br>";
		$this->load->view('app/reports/employees/coe/certificate_of_employment',$this->data);
	}
	public function generate_coe(){
		
		$this->load->view('app/reports/employees/coe/index',$this->data);
	}
	
	public function coe_esig(){//electronic signature
		
		$coe_esig=$this->input->post('coe_esig');
		$this->db->query("delete from random_settings WHERE topic='coe_electronic_signature'");
		$this->employee_reports_model->update_coe_elec_signature($coe_esig);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Successfully Saved</div>");

		//$this->session->set_flashdata('onload',"generate_coe()");
		redirect(base_url().'app/employee_reports/index',$this->data);
	}
	
	public function coe_settings(){
		$selected_individual_employee_id=$this->input->post('selected_individual_employee_id');
		$company_id=$this->input->post('company_id');
		//note : coe_signatory identification for coe signatory settings
		$this->db->query("delete from random_settings WHERE topic='coe_signatory' AND company_id = ".$company_id);

		$this->employee_reports_model->update_coe_settings($selected_individual_employee_id,$company_id);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Successfully Saved</div>");

		//$this->session->set_flashdata('onload',"generate_coe()");
		redirect(base_url().'app/employee_reports/index',$this->data);

	}

	public function crystal_report_add_udffield(){

		$emp_udf_col=$this->employee_reports_model->get_employee_udf_column();
		if(!empty($emp_udf_col)){
			foreach($emp_udf_col as $u){
				 $emp_udf_col_id=$u->emp_udf_col_id;
				 $udf_label=$u->udf_label;
				 $udf_type=$u->udf_type;
				 $udf_accept_value=$u->udf_accept_value;
				 $udf_max_length=$u->udf_max_length;
				 $udf_not_null=$u->udf_not_null;
				 $company_id=$u->company_id;
				 $isDisabled=$u->isDisabled;

				 //======================201 crystal report
				 $udf_emp_exist=$this->employee_reports_model->verify_crystal_report_employee_list_udf($emp_udf_col_id);
				 if(!empty($udf_emp_exist)){
				 	// exist na dont add it anymore
				 	echo "field: <b>$udf_label</b> already exist | you no longer need to add it at crystal report of 201 <br>";
				 }else{
				 	$insert_emp_udf = array(
				 		'udf_label'				=>	$udf_label,
				 		'TextFieldName'			=>	$emp_udf_col_id,
				 		'InActive'				=>	'0',
				 		'is_udf'				=>	'1'
				 	);
				 	$this->employee_reports_model->insert_emp_udf($insert_emp_udf);
				 	echo "field: <b>$udf_label</b> success added to crystal report of 201<br>";
				 }
				 //======================timekeeping crystal report
				 $udf_tk_exist=$this->employee_reports_model->verify_crystal_report_time_udf($emp_udf_col_id);
				 if(!empty($udf_tk_exist)){
				 	// exist na dont add it anymore
				 	echo "field: <b>$udf_label</b> already exist | you no longer need to add it at crystal report of timekeeping <br>";
				 }else{
				 	$insert_tk_udf = array(
				 		'modules'				=>	'time',
				 		'topic'					=>	'general_field_201',
				 		'field_name'			=>	$emp_udf_col_id,
				 		'title'					=>	$udf_label,
				 		'date_created'			=>	date('Y-m-d H:i:s'),
				 		'sum_me'				=>	null,
				 		'prog_comment'			=>	'added via serttech account',
				 		'is_udf'				=>	'1'
				 	);
				 	$this->employee_reports_model->insert_tk_udf($insert_tk_udf);
				 	echo "field: <b>$udf_label</b> success added to crystal report of timekeeping<br>";
				 }
				 //======================payroll crystal report

				 $udf_payroll_exist=$this->employee_reports_model->verify_crystal_report_payroll_udf($emp_udf_col_id);
				 if(!empty($udf_payroll_exist)){
				 	// exist na dont add it anymore
				 	echo "field: <b>$udf_label</b> already exist | you no longer need to add it at crystal report of payroll <br>";
				 }else{
				 	$insert_payroll_udf = array(
				 		'modules'				=>	'payroll',
				 		'topic'					=>	'general_field_201',
				 		'field_name'			=>	$emp_udf_col_id,
				 		'title'					=>	$udf_label,
				 		'display_order'			=>	null,
				 		'date_created'			=>	date('Y-m-d H:i:s'),
				 		'sum_me'				=>	null,
				 		'from_time_summary'		=>	null,
				 		'isbreakdown'			=>	null,
				 		'prog_comment'			=>	'added via serttech account',
				 		'is_udf'				=>	'1'
				 	);
				 	$this->employee_reports_model->insert_payroll_udf($insert_payroll_udf);
				 	echo "field: <b>$udf_label</b> success added to crystal report of payroll<br>";
				 }


				 
			}
		}else{

		}
		

	}


	public function index()
	{
		$this->data['reports'] = $this->employee_reports_model->get_employee_analytics();
		$this->data['crystal'] =$this->employee_reports_model->get_crystal_report();
		$this->load->view('app/reports/employees/index',$this->data);
	}

	public function add_crystal_report()
	{		
		$this->data['fields_default'] = $this->employee_reports_model->employee_fields();
		$this->load->view('app/reports/employees/add_crystal_report',$this->data);
	}

	public function save_crystal_report($action,$name,$desc,$data,$action_id)
	{
		$action = $this->employee_reports_model->save_crystal_report($action,$name,$desc,$data,$action_id);
	}

	public function stat_crystal_report($action,$id)
	{	

		if($action=='edit' || $action=='view')
		{
			$this->data['id']=$id;
			$this->data['fields_default'] = $this->employee_reports_model->employee_fields();
			$this->data['details'] = $this->employee_reports_model->employee_report_details($id);
			if($action=='edit')
			{
				$this->load->view('app/reports/employees/edit_crystal_report',$this->data);
			}
			else
			{
				$this->load->view('app/reports/employees/view_crystal_report',$this->data);	
			}
			
		}
			
		else
		{
			$action = $this->employee_reports_model->action_crystal_report($notif,$company,$action,$id);
		}

	}


	public function generate($id)
	{
		$this->data['code_details'] = $this->employee_reports_model->get_code_details($id);
		$this->data['crystal_report'] = $this->employee_reports_model->crystal_report();
		$this->data['additional'] = $this->employee_reports_model->get_additional_filtering();
		$this->load->view('app/reports/employees/generate_report',$this->data);	
	}



	public function company_division($company,$code)
	{
			$checker = $this->employee_reports_model->with_division($company);
			if(empty($checker) || $checker==0)
			{
				echo "<option value=''>Select Division</option><option value='not_included'>No division or not applicable</option>";
			}
			else
			{
				$division = $this->employee_reports_model->get_division_list($company,$id);
				if(empty($division)) { echo "<option value=''>No Division Found.</option>"; }
				else
				{	
					echo "<option value=''>Select Division</option><option value='All' style='color:red;'>All</option>";
					if($code=='E2')
					{
						echo "<option value='Multiple' style='color:red;'>Multiple</option>";
					}
					foreach($division as $f)
					{
						echo "<option value='".$f->division_id."'>".$f->division_name."</option>";
					}
				}
			}
	}

	

	public function get_department($company,$division,$code)
	{
			$department = $this->employee_reports_model->get_department_list($company,$division);
			if(empty($department)) { echo "<option value='not_included'>No Department Found.</option>"; }
			else
			{	
				echo "<option value=''>Select Department</option><option value='All' style='color:red;'>All</option>";
				if($code=='E3')
				{
					echo "<option value='Multiple' style='color:red;'>Multiple</option>";
				}
				foreach($department as $d)
				{
					echo "<option value='".$d->department_id."'>".$d->dept_name."</option>";
				}
			}
	}

	public function get_section($company,$division,$department,$code)
	{
			$section = $this->employee_reports_model->get_section_list($company,$division,$department);
			if(empty($section)) { echo "<option value='not_included'>No Section Found.</option>"; }
			else
			{	
				echo "<option value=''>Select Section</option><option value='All' style='color:red;'>All</option>";
				if($code=='E4')
				{
					echo "<option value='Multiple' style='color:red;'>Multiple</option>";
				}
				foreach($section as $d)
				{
					echo "<option value='".$d->section_id."'>".$d->section_name."</option>";
				}
			}
	}


	public function get_subsection($company,$division,$department,$section,$code)
	{
		$checker = $this->employee_reports_model->checker_with_subsection($section);
		if($checker==1 || $section=='All')
		{	
				$subsection = $this->employee_reports_model->get_subsection_list($company,$division,$department,$section);
				if(empty($subsection)){ 
					if($section=='All'){ echo "<option value='not_included'>No subsection or not applicable</option>"; }
					else{ echo "<option value=''>No Subsection Found.</option>";  }
				}
				else{
					echo "<option value='not_included'>Select Section</option><option value='All'>All</option>";
					if($code=='E5')
					{
						echo "<option value='Multiple' style='color:red;'>Multiple</option>"; 
					}
					foreach($subsection as $d)
					{
						echo "<option value='".$d->subsection_id."'>".$d->subsection_name."</option>";
					}	
				}
				
		}
		else
		{
			echo "<option value='not_included'>No subsection or not applicable</option>";	
		}
	}


	public function get_location($company,$code)
	{
		$location = $this->employee_reports_model->get_location_list($company);
		if(empty($location)){ echo "<option value='All'>No Location Found.</option>";}
		else
		{	
			echo "<option value=''>Select Location</option>
				  <option value='All' style='color:red;'>All</option>";
			if($code=='E6')
			{
				echo "<option value='Multiple' style='color:red;'>Multiple</option>";
			}
			foreach($location as $loc)
			{
				echo "<option value='".$loc->location_id."'>".$loc->location_name."</option>";
			}
		}
	}

	public function get_classification($company,$code)
	{
		$classification = $this->employee_reports_model->get_classification_list($company);
		if(empty($classification)){ echo "<option value='All'>No Classification Found.</option>";}
		else
		{	
			echo "
				  <option value='All'>All</option>";
			if($code=='E7'){ echo "<option value='Multiple' style='color:red;'>Multiple</option>"; }
			foreach($classification as $c)
			{
				echo "<option value='".$c->classification_id."'>".$c->classification."</option>";
			}
		}
	}







	public function E1_result($company,$companylist,$code,$c,$viewing_option)
	{
		 $this->data['viewing_option'] = $viewing_option;
		 $this->data['code'] = $code;
		 if($viewing_option=='detailed')
		 {
		 	$this->data['result'] = $this->employee_reports_model->E1_result($company,$companylist);
		 	$this->data['crystal_report'] = $this->employee_reports_model->get_crystal_report_selected($c);
		 }
		 else
		 {
		 	$this->data['result'] = $this->employee_reports_model->E1_result_count($company,$companylist);
		 }
		 
		$this->load->view('app/reports/employees/generate_report_result',$this->data);	
		
	}

	public function E2_result($code,$company,$c,$division,$divisionList,$viewing_option)
	{
		 $this->data['code'] = $code;
		 $this->data['viewing_option'] = $viewing_option;
		 if($viewing_option=='detailed')
		 {
		 	$this->data['result'] = $this->employee_reports_model->E2_result($company,$division,$divisionList);
			$this->data['crystal_report'] = $this->employee_reports_model->get_crystal_report_selected($c);
		 }
		 else
		 {

		 	$this->data['result'] = $this->employee_reports_model->E2_result_count($company,$division,$divisionList);
		 }
		
		 $this->load->view('app/reports/employees/generate_report_result',$this->data);	
	}

	public function E3_result($code,$company,$c,$division,$department,$departmentList,$viewing_option)
	{	
		 $this->data['viewing_option'] = $viewing_option;
		 $this->data['code'] = $code;
		 if($viewing_option=='detailed')
		 {
		 	$this->data['result'] = $this->employee_reports_model->E3_result($company,$division,$department,$departmentList);
		 	$this->data['crystal_report'] = $this->employee_reports_model->get_crystal_report_selected($c);
		 }
		 else
		 {
		 	$this->data['result'] = $this->employee_reports_model->E3_result_count($company,$division,$department,$departmentList);
		 }
		 
		 $this->load->view('app/reports/employees/generate_report_result',$this->data);
	}

	public function E4_result($code,$company,$c,$division,$department,$section,$sectionList,$viewing_option)
	{
		 $this->data['viewing_option'] = $viewing_option;
		 $this->data['code'] = $code;
		 if($viewing_option=='detailed')
		 {
		 	$this->data['result'] = $this->employee_reports_model->E4_result($company,$division,$department,$section,$sectionList);
		 	$this->data['crystal_report'] = $this->employee_reports_model->get_crystal_report_selected($c);
		 }
		 else
		 {
		 	$this->data['result'] = $this->employee_reports_model->E4_result_count($company,$division,$department,$section,$sectionList);
		 }	

		
		 $this->load->view('app/reports/employees/generate_report_result',$this->data);
	}

	public function E5_result($code,$company,$c,$division,$department,$section,$subsection,$subsectionList,$viewing_option)
	{

		 $this->data['viewing_option'] = $viewing_option;
		 $this->data['code'] = $code;

		 if($viewing_option=='detailed')
		 {
		 	$this->data['result'] = $this->employee_reports_model->E5_result($company,$division,$department,$section,$subsection,$subsectionList);
		 	$this->data['crystal_report'] = $this->employee_reports_model->get_crystal_report_selected($c);
		 }
		 else
		 {
		 	$this->data['result'] = $this->employee_reports_model->E5_result_count($company,$division,$department,$section,$subsection,$subsectionList);
		 }	

		 
		 $this->load->view('app/reports/employees/generate_report_result',$this->data);
	}

	public function E6_result($code,$company,$c,$division,$department,$section,$subsection,$location,$locationList,$viewing_option)
	{

		 $this->data['viewing_option'] = $viewing_option;
		 $this->data['code'] = $code;

		 if($viewing_option=='detailed')
		 {
		 	$this->data['result'] = $this->employee_reports_model->E6_result($company,$division,$department,$section,$subsection,$location,$locationList);
		 	$this->data['crystal_report'] = $this->employee_reports_model->get_crystal_report_selected($c);
		 }
		 else
		 {
		 	$this->data['result'] = $this->employee_reports_model->E6_result_count($company,$division,$department,$section,$subsection,$location,$locationList);
		 }	

		
		$this->load->view('app/reports/employees/generate_report_result',$this->data);
	}

	public function E7_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$classificationList,$viewing_option)
	{
		$this->data['viewing_option'] = $viewing_option;
		$this->data['code'] = $code;

		 if($viewing_option=='detailed')
		 {
		 	$this->data['result'] = $this->employee_reports_model->E7_result($company,$division,$department,$section,$subsection,$location,$classification,$classificationList);
		    $this->data['crystal_report'] = $this->employee_reports_model->get_crystal_report_selected($c);
		 }
		 else
		 {
		 	$this->data['result'] = $this->employee_reports_model->E7_result_count($company,$division,$department,$section,$subsection,$location,$classification,$classificationList);
		 }	

		
		 $this->load->view('app/reports/employees/generate_report_result',$this->data);
	}

	public function E8_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$employmentList,$viewing_option)
	{
		 $this->data['viewing_option'] = $viewing_option;
		 $this->data['code'] = $code;
		 if($viewing_option=='detailed')
		 {
		 	$this->data['result'] = $this->employee_reports_model->E8_result($company,$division,$department,$section,$subsection,$location,$classification,$employment,$employmentList);
			$this->data['crystal_report'] = $this->employee_reports_model->get_crystal_report_selected($c);
		 }
		 else
		 {
		 	$this->data['result'] = $this->employee_reports_model->E8_result_count($company,$division,$department,$section,$subsection,$location,$classification,$employment,$employmentList);
		 }
		 
		 $this->load->view('app/reports/employees/generate_report_result',$this->data);
	}

	function other_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$other,$from,$to)
	{
		
		 $this->data['viewing_option'] = 'detailed';
		 $this->data['code'] = $code;
		 $this->data['from'] = $from;
		 $this->data['to'] = $to;
		 $this->data['result'] = $this->employee_reports_model->other_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$other,$from,$to);
		 $this->data['crystal_report'] = $this->employee_reports_model->get_crystal_report_selected($c);
		 $this->load->view('app/reports/employees/generate_report_result',$this->data);
	}


	public function all_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$taxcode,$status,$gender,$civil_status,$position,$paytype,$religion,$age_from,$age_to,$dateemp_from,$dateemp_to,$yremp_from,$yremp_to,$viewing_option,$viewing_type,$viewing_data)
	{
		 $this->data['viewing_option'] = $viewing_option;
		 $this->data['viewing_type'] = $viewing_type;

		 $this->data['code'] = $code;
		 $this->data['age_from'] = $age_from;
		 $this->data['age_to'] = $age_to;
		 $this->data['yremp_from'] = $yremp_from;
		 $this->data['yremp_to'] = $yremp_to;

		 if($viewing_option=='detailed')
		 {
		 	$this->data['result'] = $this->employee_reports_model->all_result_detailed($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$taxcode,$status,$gender,$civil_status,$position,$paytype,$religion,$age_from,$age_to,$dateemp_from,$dateemp_to,$yremp_from,$yremp_to);
		 	$this->data['crystal_report'] = $this->employee_reports_model->get_crystal_report_selected($c);
		 }
		 else
		 {
		 	$this->data['result'] = $this->employee_reports_model->all_result_count($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$taxcode,$status,$gender,$civil_status,$position,$paytype,$religion,$age_from,$age_to,$dateemp_from,$dateemp_to,$yremp_from,$yremp_to,$viewing_option,$viewing_type,$viewing_data);
		 }
		 
		 $this->load->view('app/reports/employees/generate_report_result',$this->data);


		
	}


	public function other_option_result($code,$company,$crystal_report,$division,$department,$section,$subsection,$location,$classification,$employment,$other,$otherList,$viewing_option)
	{
		 $this->data['viewing_option'] = $viewing_option;
		 $this->data['code'] = $code;
		 if($viewing_option=='detailed')
		 {
		 	$this->data['result'] = $this->employee_reports_model->other_option_result($code,$company,$crystal_report,$division,$department,$section,$subsection,$location,$classification,$employment,$other,$otherList,$viewing_option);
			$this->data['crystal_report'] = $this->employee_reports_model->get_crystal_report_selected($crystal_report);
		 }
		 else
		 {
		 	$this->data['result'] = $this->employee_reports_model->other_option_result_count($code,$company,$crystal_report,$division,$department,$section,$subsection,$location,$classification,$employment,$other,$otherList,$viewing_option);
		 }
		 
		 $this->load->view('app/reports/employees/generate_report_result',$this->data);
	}

	public function E2_division_multiple($div,$code,$company)
	{
		$division = $this->employee_reports_model->get_division_list($company,$div);
	?>
		<label>Select Multiple Division</label>
        <?php $i=0; foreach($division as $d){?>
                <div class="col-md-12"><input type="checkbox" class="divisionclass<?php echo $code;?>" value="<?php echo $d->division_id;?>">&nbsp;<?php echo $d->division_name;?></div>
        <?php $i++; } echo "<input type='hidden' value='".$i."' id='countmultiple".$code."'>"; ?>
	<?php }



	public function E2_department_multiple($dept,$code,$company,$division)
	{
		$department = $this->employee_reports_model->get_department_list($company,$division);
	?>
		<label>Select Multiple Department</label>
        <?php $i=0; foreach($department as $d){?>
                <div class="col-md-12"><input type="checkbox" class="departmentclass<?php echo $code;?>" value="<?php echo $d->department_id;?>">&nbsp;<?php echo $d->dept_name;?></div>
        <?php $i++; } echo "<input type='hidden' value='".$i."' id='countmultiple".$code."'>"; ?>
	<?php }



	public function E4_section_multiple($section,$code,$company,$division,$department)
	{
		$section = $this->employee_reports_model->get_section_list($company,$division,$department);
	?>	
		<label>Select Multiple Section</label>
        <?php $i=0; foreach($section as $d){?>
                <div class="col-md-12"><input type="checkbox" class="sectionclass<?php echo $code;?>" value="<?php echo $d->section_id;?>">&nbsp;<?php echo $d->section_name;?></div>
        <?php $i++; } echo "<input type='hidden' value='".$i."' id='countmultiple".$code."'>"; ?>

	<?php } 


	public function E5_subsection_multiple($subsection,$code,$company,$division,$department,$section)
	{
		$subsection = $this->employee_reports_model->get_subsection_list($company,$division,$department,$section);
	?>
		<label>Select Multiple Subsection</label>
        <?php $i=0; foreach($subsection as $d){?>
                <div class="col-md-12"><input type="checkbox" class="subsectionclass<?php echo $code;?>" value="<?php echo $d->subsection_id;?>">&nbsp;<?php echo $d->subsection_name;?></div>
        <?php $i++; } echo "<input type='hidden' value='".$i."' id='countmultiple".$code."'>"; ?>

	<?php }


	public function E6_location_multiple($code,$company)
	{
		$location = $this->employee_reports_model->get_location_list($company);
	?>
		<label>Select Multiple Location</label>
        <?php $i=0; foreach($location as $d){?>
                <div class="col-md-12"><input type="checkbox" class="locationclass<?php echo $code;?>" value="<?php echo $d->location_id;?>">&nbsp;<?php echo $d->location_name;?></div>
        <?php $i++; } echo "<input type='hidden' value='".$i."' id='countmultiple".$code."'>"; ?>

	<?php }


	public function E7_classification_multiple($code,$company)
	{
		$classification = $this->employee_reports_model->get_classification_list($company);
	?>
		<label>Select Multiple Classification</label>
        <?php $i=0; foreach($classification as $d){?>
                <div class="col-md-12"><input type="checkbox" class="classificationclass<?php echo $code;?>" value="<?php echo $d->classification_id;?>">&nbsp;<?php echo $d->classification;?></div>
        <?php $i++; } echo "<input type='hidden' value='".$i."' id='countmultiple".$code."'>"; ?>

	<?php }	


	public function viewing_optionaction($val,$code,$company,$division,$department,$section,$subsection)
	{
		$this->data['data'] = array($val,$code,$company,$division,$department,$section,$subsection);
		$this->load->view('app/reports/employees/viewing_option_data',$this->data);   
	}


	public function e11_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$yremp_from,$yremp_to,$viewing_option,$viewing_type,$viewing_data,$yearoption)

	{
		 $this->data['yearoption'] = $yearoption;
		 $this->data['viewing_option'] = $viewing_option;
		 $this->data['viewing_type'] = $viewing_type;

		
		 $this->data['from'] = $yremp_from;
		 $this->data['to'] = $yremp_to;

		 if($viewing_option=='detailed')
		 {
		 	 $this->data['code'] = $code;
		 	$this->data['result'] = $this->employee_reports_model->e11_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$yremp_from,$yremp_to,$viewing_option,$viewing_type,$viewing_data,$yearoption);
		 	$this->data['crystal_report'] = $this->employee_reports_model->get_crystal_report_selected($c);
		 }
		 else
		 {
		 	 $this->data['code'] = 'E19';
		 	$this->data['result'] = $this->employee_reports_model->e11_result_count($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$yremp_from,$yremp_to,$viewing_option,$viewing_type,$viewing_data,$yearoption);
		 }
		 
		 $this->load->view('app/reports/employees/generate_report_result',$this->data);
	}	

	public function e12_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data)
	{

		 $this->data['viewing_option'] = $viewing_option;
		 $this->data['viewing_type'] = $viewing_type;

		
		 $this->data['from'] = $from;
		 $this->data['to'] = $to;

		 if($viewing_option=='detailed')
		 {
		 	 $this->data['code'] = $code;
		 	$this->data['result'] = $this->employee_reports_model->e12_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data);
		 	$this->data['crystal_report'] = $this->employee_reports_model->get_crystal_report_selected($c);
		 }
		 else
		 {
		 	 $this->data['code'] = 'E19';
		 	$this->data['result'] = $this->employee_reports_model->e12_result_count($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data);
		 }
		 
		 $this->load->view('app/reports/employees/generate_report_result',$this->data);
	}

	public function e16_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data)
	{

		 $this->data['viewing_option'] = $viewing_option;
		 $this->data['viewing_type'] = $viewing_type;

		
		 $this->data['from'] = $from;
		 $this->data['to'] = $to;

		 if($viewing_option=='detailed')
		 {
		 	 $this->data['code'] = $code;
		 	$this->data['result'] = $this->employee_reports_model->e16_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data);
		 	$this->data['crystal_report'] = $this->employee_reports_model->get_crystal_report_selected($c);
		 }
		 else
		 {
		 	 $this->data['code'] = 'E19';
		 	$this->data['result'] = $this->employee_reports_model->e16_result_count($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data);
		 }
		 
		 $this->load->view('app/reports/employees/generate_report_result',$this->data);

	}

	public function e10_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$viewing_option,$viewing_type,$viewing_data)
	{


		 $this->data['viewing_option'] = $viewing_option;
		 $this->data['viewing_type'] = $viewing_type;

		 if($viewing_option=='detailed')
		 {
		 	$this->data['code'] = $code;
		 	$this->data['result'] = $this->employee_reports_model->e10_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$viewing_option,$viewing_type,$viewing_data);
		 	$this->data['crystal_report'] = $this->employee_reports_model->get_crystal_report_selected($c);
		 }
		 else
		 {
		 	 $this->data['code'] = 'E19';
		 	$this->data['result'] = $this->employee_reports_model->e10_result_count($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$viewing_option,$viewing_type,$viewing_data);
		 }
		 
		 $this->load->view('app/reports/employees/generate_report_result',$this->data);
		 
	}

	public function e20_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$viewing_option,$viewing_type,$viewing_data,$month,$day)
	{

		 $this->data['viewing_option'] = $viewing_option;
		 $this->data['viewing_type'] = $viewing_type;

		 if($viewing_option=='detailed')
		 {
		 	$this->data['code'] = $code;
		 	$this->data['result'] = $this->employee_reports_model->e20_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$viewing_option,$viewing_type,$viewing_data,$month,$day);
		 	$this->data['crystal_report'] = $this->employee_reports_model->get_crystal_report_selected($c);
		 }
		 else
		 {
		 	 $this->data['code'] = 'E20';
		 	 $this->data['result'] = $this->employee_reports_model->e20_result_count($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$viewing_option,$viewing_type,$viewing_data,$month,$day);
		 }
		 
		 $this->load->view('app/reports/employees/generate_report_result',$this->data);
		 
	}


	//format 2 coe

	public function generate_coe_format_2(){
		
		$this->load->view('app/reports/employees/coe/format_2/index',$this->data);
	}

	//coe format 2

	public function extract_coe_format2(){
		$company_id=$this->input->post('company_id');
		$employee_status=$this->input->post('employee_status');
		$coe_reason=$this->input->post('coe_reason');
		$date_issued=$this->input->post('date_issued');
		$employment=$this->input->post('employment_type');
		$company_name=$this->input->post('company_name');
		$company_address=$this->input->post('company_address');

		if($employment=='employment_type_01')
		{
			$employment_type="default";
		}
		else
		{
			$employment_type=$this->input->post('employment_type_02');
		}

		if($company_name=='company_name_01')
		{
			$companyname=$this->employee_reports_model->get_company_name($company_id);
		}
		else
		{
			$companyname=$this->input->post('company_name_02');
		}
		
		if($company_address=='company_address_01')
		{
			$company_address=$this->employee_reports_model->company_address($company_id);
		}
		else
		{
			$company_address=$this->input->post('company_address_02');
		}
		$this->data['namee'] = $this->input->post('namee');
		$this->data['emp_address']=$this->input->post('emp_address');
		$this->data['other_01']=$this->input->post('other_01');
		$this->data['other_02']=$this->input->post('other_02');
		$this->data['company_address']=$company_address;
		$this->data['employment_type']=$employment_type;
		$this->data['companyname']=$companyname;
		$this->data['coe_reason']=$coe_reason;
		$this->data['date_issued']=$date_issued;
		$this->data['cinfo']=$this->general_model->get_company_info($company_id);
		$this->data['emp_coe']=$this->employee_reports_model->extract_coe($company_id,'-',$employee_status);
		$this->load->view('app/reports/employees/coe/format_2/certificate_of_employment_format2',$this->data);
	}

		public function generate_coe_format_3(){
		
		$this->load->view('app/reports/employees/coe/format_3/index',$this->data);
	}

}

//end controller



