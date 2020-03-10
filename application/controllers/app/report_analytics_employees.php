<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Report_analytics_employees extends General{

	public function __construct(){
		parent::__construct();
		$this->load->model("app/report_analytics_employees_model");
		$this->load->model("general_model");
		if($this->session->userdata('recruitment_employer_is_logged_in')){

		}
		else if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index(){	
			
		$this->data['analytics'] = $this->report_analytics_employees_model->get_analytics();
		$this->load->view("app/report_analytics/employee_analytics/index",$this->data);
	}

	public function get_employee_analytics($code)
	{
		$this->data['code'] = $code;
		$this->data['code_details'] = $this->report_analytics_employees_model->get_code_details($code);
		$this->load->view("app/report_analytics/employee_analytics/employee_filtering",$this->data);
	}

	public function result($code)
	{

		$color_final = $this->input->post('color');
		$title = $this->input->post('title');
		$graph = $this->input->post('graph');
		$this->data['title'] = $title;
	   	$this->data['graph'] = $graph;
	   	$this->data['color'] = json_encode($color_final);

	   	if($code=='E1')
	   	{
	   		$data = $this->report_analytics_employees_model->companyList($code);

			$this->data['data'] = json_encode($data);
			$this->data['label'] = '[Employee Count | Company';
			$this->data['x'] = 'company_name';
			$this->data['y'] = 'employee_count';
	   	}
	   	else if($code=='E2')
	   	{

	   		$data = $this->report_analytics_employees_model->divisionList($code);

			$this->data['data'] = json_encode($data);
			$this->data['label'] = '[Employee Count | Division';
			$this->data['x'] = 'division_name';
			$this->data['y'] = 'employee_count';
	   	}

	   	else if($code=='E3')
	   	{
	   		$data = $this->report_analytics_employees_model->departmentList($code);

			$this->data['data'] = json_encode($data);
			$this->data['label'] = '[Employee Count | Department';
			$this->data['x'] = 'dept_name';
			$this->data['y'] = 'employee_count';	
	   	}

	   	else if($code=='E4')
	   	{
	   		$data = $this->report_analytics_employees_model->sectionList($code);

			$this->data['data'] = json_encode($data);
			$this->data['label'] = '[Employee Count | Section';
			$this->data['x'] = 'section_name';
			$this->data['y'] = 'employee_count';	
	   	}

	   	else if($code=='E5')
	   	{
	   		$data = $this->report_analytics_employees_model->subsectionList($code);

			$this->data['data'] = json_encode($data);
			$this->data['label'] = '[Employee Count | Subsection';
			$this->data['x'] = 'subsection_name';
			$this->data['y'] = 'employee_count';
	   	}

	   	else if($code=='E6')
	   	{
	   		$data = $this->report_analytics_employees_model->locationList($code);

			$this->data['data'] = json_encode($data);
			$this->data['label'] = '[Employee Count | Location';
			$this->data['x'] = 'location_name';
			$this->data['y'] = 'employee_count';
	   	}

	   	else if($code=='E7')
	   	{
	   		$data = $this->report_analytics_employees_model->classificationList($code);

			$this->data['data'] = json_encode($data);
			$this->data['label'] = '[Employee Count | Location';
			$this->data['x'] = 'classification';
			$this->data['y'] = 'employee_count';
	   	}

	   	else if($code=='E8')
	   	{
	   		$data = $this->report_analytics_employees_model->employmentList($code);
			$this->data['data'] = json_encode($data);
			$this->data['label'] = '[Employee Count | Employment';
			$this->data['x'] = 'employment_name';
			$this->data['y'] = 'employee_count';
	   	}
	   	else if($code=='E9')
	   	{
	   		$data = $this->report_analytics_employees_model->taxcodeList($code);
			$this->data['data'] = json_encode($data);
			$this->data['label'] = '[Employee Count | Taxcode';
			$this->data['x'] = 'taxcode';
			$this->data['y'] = 'employee_count';	
	   	}
	   	else if($code=='E13')
	   	{
	   		$data = $this->report_analytics_employees_model->civilstatusList($code);
			$this->data['data'] = json_encode($data);
			$this->data['label'] = '[Employee Count | Civil Status';
			$this->data['x'] = 'civil_status';
			$this->data['y'] = 'employee_count';
	   	}
	   	else if($code=='E14')
	   	{
	   		$data = $this->report_analytics_employees_model->genderList($code);
			$this->data['data'] = json_encode($data);
			$this->data['label'] = '[Employee Count | Gender';
			$this->data['x'] = 'gender_name';
			$this->data['y'] = 'employee_count';
	   	}
	   	else if($code=='E15')
	   	{
	   		$data = $this->report_analytics_employees_model->positionList($code);
			$this->data['data'] = json_encode($data);
			$this->data['label'] = '[Employee Count | Position';
			$this->data['x'] = 'position_name';
			$this->data['y'] = 'employee_count';
	   	}
	   	else if($code=='E17')
	   	{
	   		$data = $this->report_analytics_employees_model->paytypeList($code);
			$this->data['data'] = json_encode($data);
			$this->data['label'] = '[Employee Count | Pay Type';
			$this->data['x'] = 'pay_type_name';
			$this->data['y'] = 'employee_count';
	   	}

	   	else if($code=='E18')
	   	{
	   		$data = $this->report_analytics_employees_model->religionList($code);
			$this->data['data'] = json_encode($data);
			$this->data['label'] = '[Employee Count | Religion';
			$this->data['x'] = 'cValue';
			$this->data['y'] = 'employee_count';
	   	}


		$this->load->view("app/report_analytics/employee_analytics/analytics_results",$this->data);
	}

	public function get_classification($company,$code)
	{
		$classification = $this->report_analytics_employees_model->get_classification_list($company);
		if(empty($classification)){ echo "<option value=''>No Classification Found.</option>";}
		else
		{	
			echo "  <option value='' disabled selected>Select Location</option>
					<option value='All' style='color:red;'>All</option>";
			if($code=='E7')
					{ echo "

								
								<option value='Multiple' style='color:red;'>Multiple</option>";
					} 

			foreach($classification as $c)
			{
				echo "<option value='".$c->classification_id."'>".$c->classification."</option>";
			}
		}
	}



















	public function get_division($company,$code)
	{
			$checker = $this->report_analytics_employees_model->with_division($company);
			if(empty($checker) || $checker==0)
			{
				echo "<option value=''>No division or not applicable</option>";
			}
			else
			{
				$division = $this->report_analytics_employees_model->get_division_list($company,$id);
				if(empty($division)) { echo "<option value=''>No Division Found.</option>"; }
				else
				{	
					echo "  <option value=''>Select Division</option> ";
					if($code=='E2')
							{ echo "
								<option value='All' style='color:red;'>All</option>
								<option value='Multiple' style='color:red;'>Multiple</option>";
							} 
					foreach($division as $f)
					{
						echo "<option value='".$f->division_id."'>".$f->division_name."</option>";
					}
				}
			}
	}

	public function multipledivision($division,$code,$company)
	{
		if($division=='Multiple')
		{
			$division = $this->report_analytics_employees_model->get_division_list($company);
			$i=0;
			foreach($division as $f)
			{?>
				
				<div class="col-md-12">
                    <input type="checkbox" id="multiple<?php echo $f->division_id;?>" class="multiple" value="<?php echo $f->division_id;?>" onclick="get_multiple('<?php echo $code;?>','');">&nbsp;<?php echo $f->division_name;?>
                </div>

			<?php $i++; } echo "<input type='hidden' id='count".$code."' value='".$i."'>";
		}
	}

	

	public function get_department($division,$code,$company)
	{
			$department = $this->report_analytics_employees_model->get_department_list($company,$division);
			if(empty($department)) { echo "<option value=''>No Department Found.</option>"; }
			else
			{	
				echo "<option value='' disabled selected>Select Department</option>";
				if($code=='E3')
					{ echo "

								<option value='All' style='color:red;'>All</option>
								<option value='Multiple' style='color:red;'>Multiple</option>";
					} 
				foreach($department as $d)
				{
					echo "<option value='".$d->department_id."'>".$d->dept_name."</option>";
				}
			}
	}

	public function multipledepartment($department,$code,$company,$division)
	{
		if($department=='Multiple')
		{
			$department = $this->report_analytics_employees_model->get_department_list($company,$division);
			$i=0;
			foreach($department as $f)
			{?>
				
				<div class="col-md-12">
                    <input type="checkbox" id="multiple<?php echo $f->department_id;?>" class="multiple" value="<?php echo $f->department_id;?>" onclick="get_multiple('<?php echo $code;?>','');">&nbsp;<?php echo $f->dept_name;?>
                </div>

			<?php $i++; } echo "<input type='hidden' id='count".$code."' value='".$i."'>";
		}
	}

	public function multiplesection($department,$section,$company,$code)
	{
		if($section=='Multiple')
		{
			$section = $this->report_analytics_employees_model->get_section_list($department);
			$i=0;
			foreach($section as $f)
			{?>
				
				<div class="col-md-12">
                    <input type="checkbox" id="multiple<?php echo $f->section_id;?>" class="multiple" value="<?php echo $f->section_id;?>" onclick="get_multiple('<?php echo $code;?>','');">&nbsp;<?php echo $f->section_name;?>
                </div>

			<?php $i++; } echo "<input type='hidden' id='count".$code."' value='".$i."'>";
		}
	}
	public function get_section($code,$department)
	{
			$section = $this->report_analytics_employees_model->get_section_list($department);
			if(empty($section)) { echo "<option value=''>No Section Found.</option>"; }
			else
			{	
				echo "<option value=''>Select Section</option>";
				if($code=='E4'){
					echo "<option value='All' style='color:red;'>All</option>
					<option value='Multiple' style='color:red;'>Multiple</option>";
				}
				foreach($section as $d)
				{
					echo "<option value='".$d->section_id."'>".$d->section_name."</option>";
				}
			}
	}


	public function get_subsection($section,$code)
	{
		$checker = $this->report_analytics_employees_model->checker_with_subsection($section);
		if($checker==1 || $section=='All')
		{	
				$subsection = $this->report_analytics_employees_model->get_subsection_list($section);
				if(empty($subsection)){ echo "<option value=''>No Subsection Found.</option>"; }
				else{
					echo "<option value=''>Select Section</option>";
					if($code=='E5'){ echo "

						  <option value='All' style='color:red;'>All</option>
						  <option value='Multiple' style='color:red;'>Multiple</option>";
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

	public function multiplesubsection($section,$code,$company,$subsection)
	{
		if($subsection=='Multiple')
		{
			$subsection = $this->report_analytics_employees_model->get_subsection_list($section);
			$i=0;
			foreach($subsection as $f)
			{?>
				
				<div class="col-md-12">
                    <input type="checkbox" id="multiple<?php echo $f->subsection_id;?>" class="multiple" value="<?php echo $f->subsection_id;?>" onclick="get_multiple('<?php echo $code;?>','');">&nbsp;<?php echo $f->subsection_name;?>
                </div>

			<?php $i++; } echo "<input type='hidden' id='count".$code."' value='".$i."'>";
		}
	}
	

	public function multiplelocation($company,$code,$location)
	{
		if($location=='Multiple')
		{
			$location = $this->report_analytics_employees_model->get_location_list($company);
			$i=0;
			foreach($location as $f)
			{?>
				
				<div class="col-md-12">
                    <input type="checkbox" id="multiple<?php echo $f->location_id;?>" class="multiple" value="<?php echo $f->location_id;?>" onclick="get_multiple('<?php echo $code;?>','');">&nbsp;<?php echo $f->location_name;?>
                </div>

			<?php $i++; } echo "<input type='hidden' id='count".$code."' value='".$i."'>";
		}

	}

	public function multipleclassification($company,$code,$classification)
	{
		if($classification=='Multiple')
		{
			$classification = $this->report_analytics_employees_model->get_classification_list($company);
			$i=0;
			foreach($classification as $f)
			{?>
				
				<div class="col-md-12">
                    <input type="checkbox" id="multiple<?php echo $f->classification_id;?>" class="multiple" value="<?php echo $f->classification_id;?>" onclick="get_multiple('<?php echo $code;?>','');">&nbsp;<?php echo $f->classification;?>
                </div>

			<?php $i++; } echo "<input type='hidden' id='count".$code."' value='".$i."'>";
		}
	}

	public function get_location($company,$code)
	{
		$location = $this->report_analytics_employees_model->get_location_list($company);
		if(empty($location)){ echo "<option value=''>No Location Found.</option>";}
		else
		{	
			echo "<option value='' disabled selected>Select Location</option>
			<option value='All' style='color:red;'>All</option>";
			if($code=='E6')
				{
					echo "
					
					<option value='Multiple' style='color:red;'>Multiple</option>";
				}
			
			foreach($location as $loc)
			{
				echo "<option value='".$loc->location_id."'>".$loc->location_name."</option>";
			}
		}
	}




}//end controller



