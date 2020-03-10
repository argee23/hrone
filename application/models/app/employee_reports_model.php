<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_reports_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_employee_udf_column(){
		$query=$this->db->query("SELECT * FROM employee_udf_column WHERE isDisabled='0' ");		
		return $query->result();		
	}

	public function verify_crystal_report_employee_list_udf($emp_udf_col_id){
		$query=$this->db->query("SELECT * FROM crystal_report_employee_list WHERE is_udf='1' AND TextFieldName='".$emp_udf_col_id."' ");		
		return $query->row();		
	}
	public function insert_emp_udf($insert_emp_udf){
		$this->db->insert('crystal_report_employee_list', $insert_emp_udf);		
	}

	public function verify_crystal_report_time_udf($emp_udf_col_id){
		$query=$this->db->query("SELECT * FROM crystal_report_time WHERE is_udf='1' AND field_name='".$emp_udf_col_id."' ");		
		return $query->row();		
	}
	public function insert_tk_udf($insert_tk_udf){
		$this->db->insert('crystal_report_time', $insert_tk_udf);		
	}


	public function verify_crystal_report_payroll_udf($emp_udf_col_id){
		$query=$this->db->query("SELECT * FROM crystal_report_payroll WHERE is_udf='1' AND field_name='".$emp_udf_col_id."' ");		
		return $query->row();		
	}
	public function insert_payroll_udf($insert_payroll_udf){
		$this->db->insert('crystal_report_payroll', $insert_payroll_udf);		
	}


	public function check_udf_content($employee_id,$emp_udf_col_id){
	$query=$this->db->query("SELECT * FROM employee_udf_data WHERE employee_id='".$employee_id."' AND emp_udf_col_id='".$emp_udf_col_id."' ");	
	return $query->row();	

	}
	public function getCurrentSalary($employee_id){
	$query=$this->db->query("SELECT * FROM salary_information WHERE employee_id='".$employee_id."'  ");	
	return $query->row();	

	}
	public function extract_coe($company_id,$resigned_date,$employee_status){
		//admin_emp_masterlist_inactive_view
		//masterlist

		if($employee_status=="active"){
	$query=$this->db->query("SELECT present_address,permanent_address,title,last_name,first_name,middle_name,employment_name,date_employed,position_name,dept_name,section_name,employee_id FROM masterlist WHERE company_id='".$company_id."' AND InActive='0' ");
		
		}else{

	$query=$this->db->query("SELECT a.last_name,a.first_name,a.middle_name,a.employee_id FROM admin_emp_masterlist_inactive_view a INNER JOIN employee_date_resigned b ON (a.employee_id=b.employee_id) WHERE a.company_id='".$company_id."' AND a.InActive='0' ");	

		}
			
		return $query->result();	
	}

	public function getCoeESigSetup(){
			$query=$this->db->query("SELECT * FROM random_settings WHERE topic='coe_electronic_signature'  ");	
			return $query->row();		

	}
	public function update_coe_elec_signature($coe_esig){

		$field = array(
					'topic' 			=> 'coe_electronic_signature',
					'topic_setting' 	=> $coe_esig,
					'last_update' 		=> date('Y-m-d H:i:s')
				);

		$this->db->insert('random_settings', $field);		
	}
	public function update_coe_settings($selected_individual_employee_id,$company_id){

		$field = array(
					'topic' 			=> 'coe_signatory',
					'topic_setting' 	=> $selected_individual_employee_id,
					'company_id' 		=> $company_id,
					'last_update' 		=> date('Y-m-d H:i:s')
				);

		$this->db->insert('random_settings', $field);		
	}
	public function get_emp_info($signatory_emp_id){
			$query=$this->db->query("SELECT a.electronic_signature,a.last_name,a.first_name,a.middle_name,a.position_name FROM masterlist a WHERE a.employee_id='".$signatory_emp_id."' ");	
			return $query->row();		

	}
	public function getSignatory($company_id){
			$query=$this->db->query("SELECT b.name_lname_first,b.employee_id FROM random_settings a INNER JOIN masterlist b ON(a.topic_setting=b.employee_id) WHERE a.company_id='".$company_id."' AND a.topic='coe_signatory' ");	
			return $query->row();		

	}
	public function get_crystal_report()
	{
		$this->db->select('a.*,b.fullname');
		$this->db->join('employee_info b','b.employee_id=a.added_by','left');
		$q = $this->db->get('crystal_report_employee a');
		return $q->result();


	}
	public function employee_fields()
	{
		$this->db->where('InActive',0);
		$query = $this->db->get('crystal_report_employee_list');
		return $query->result();
	}

	public function save_crystal_report($action,$name,$desc,$datass,$action_id)
	{
		$rname = $this->convert_char($name);
		$rdesc = $this->convert_char($desc);
		if($action=='save_update')
		{
			$this->db->where('id',$action_id);
			$this->db->update('crystal_report_employee',array('report_name'=>$rname,'report_description'=>str_replace("mimi","",$rdesc)));

			$this->db->where('id',$action_id);
			$this->db->delete('crystal_report_employee_fields');

			$a 	= substr_replace($datass, "", -1);
			$array =  explode('-', $a);

					foreach($array as $aa)
					{
						$dataa = array(
										'crystal_id'	=>	$action_id,
										'field_id'		=> $aa,
										'date_created'	=>date('Y-m-d H:i:s')
									);

						$this->db->insert('crystal_report_employee_fields',$dataa);
						
					}
		}
		else
		{
					$data = array(
						'report_name'			    =>		$rname,
						'report_description'	    =>		str_replace("mimi","",$rdesc),
						'date_created'	   			=>		date('Y-m-d H:i:s'),
						'added_by'		   			=>		$this->session->userdata('employee_id'),
						'InActive'		   			=>		0
								 );
					$this->db->insert('crystal_report_employee',$data);
					$this->db->select_max('id');
					$query = $this->db->get('crystal_report_employee');
					$c_id  = $query->row('id');

					$a 	= substr_replace($datass, "", -1);
					$array =  explode('-', $a);

					foreach($array as $aa)
					{
						echo $aa."=".$c_id;
						$dataa = array(
										'crystal_id'	=>	$c_id,
										'field_id'		=> $aa,
										'date_created'	=>date('Y-m-d H:i:s')
									);
						$this->db->insert('crystal_report_employee_fields',$dataa);
					}
		}
		
	}

	public function action_crystal_report($notif,$company,$action,$id)
	{
		if($action=='disable')
		{
			$this->db->where('id',$id);
			$this->db->update('crystal_report_employee',array('InActive'=>1));
		}
		else if($action=='enable')
		{
			$this->db->where('id',$id);
			$this->db->update('crystal_report_employee',array('InActive'=>0));
		}
		else if($action=='delete')
		{
			
			$this->db->where('id',$id);
			$this->db->delete('crystal_report_employee');
			$this->db->where('crystal_id',$id);
			$this->db->delete('crystal_report_employee_fields');
		}
	}

	public function employee_report_details($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('crystal_report_employee');
		return $query->row();
	}

	public function crystal_report_details_fields($id,$idd)
	{
		$this->db->where(array('crystal_id'=>$id,'field_id'=>$idd));
		$query = $this->db->get('crystal_report_employee_fields');
		return $query->num_rows();
	}	

	public function get_additional_filtering()
	{
		$this->db->where('InActive',0);
		$query = $this->db->get('employee_report_additional_filtering');
		return $query->result();
	}

	public function with_division($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('company_info');
		return $query->row('wDivision');
	}

	public function get_division_list($company)
	{
		$this->db->where(array('company_id'=>$company,'InActive'=>0));
		$query = $this->db->get('division');
		return $query->result();
	}

	public function get_department_list($company,$division)
	{
		$this->db->where('company_id',$company);
		if($division!='All'){ $this->db->where('division_id',$division); }
		$query = $this->db->get('department');
		return $query->result();
	}

	public function get_section_list($company,$division,$department)
	{
		
		$this->db->join('department b','b.department_id=a.department_id');
		if($department=='All')
		{ 
			if($division=='All' || $division=='not_included')
			{
				$this->db->where('b.company_id',$company);
			} 
			else
			{ 
				$this->db->where('b.division_id',$division); 
			}
		} 
		else { $this->db->where('a.department_id',$department); }
		$query = $this->db->get('section a');
		return $query->result();
	}

	public function checker_with_subsection($section)
	{
		$this->db->where('section_id',$section);
		$query = $this->db->get('section');
		return $query->row('wSubsection');
	}

	public function get_subsection_list($company,$division,$department,$section)
	{
		$this->db->join('section b','b.section_id=a.section_id');
		$this->db->join('department c','c.department_id=b.department_id');
		$this->db->join('division d','d.division_id=c.division_id','left');
		if($section=='All')
			{
					if($department=='All'){ 
						if($division=='All'){ $this->db->where('c.company_id',$company);  } else{ $this->db->where('d.division_id',$division); }
					} 
					else { $this->db->where('c.department_id',$department); }
			} 
		else{ $this->db->where('a.section_id',$section); }
		$query = $this->db->get('subsection a');
		return $query->result();
	}

	public function get_location_list($company)
	{
		$this->db->join('company_location b','b.location_id=a.location_id');
		$this->db->where('b.company_id',$company);
		$query = $this->db->get('location a');
		return $query->result();

	}

	public function get_classification_list($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('classification');
		return $query->result();
	}

	public function filter_employees()
	{
		$crystal_report = $this->input->post('crystal_report');
		$company = $this->input->post('c_1');
		$division = $this->input->post('c_2');
		$department = $this->input->post('c_3');
		$section = $this->input->post('c_4');
		$subsection = $this->input->post('c_5');
		$classification = $this->input->post('c_6');

		$location = $this->input->post('c_7');
		$employment = $this->input->post('c_8');
		$religion = $this->input->post('c_9');
		$taxcode = $this->input->post('c_10');
		$civil_status = $this->input->post('c_11');
		$gender = $this->input->post('c_12');
		$paytype = $this->input->post('c_13');
		$status = $this->input->post('c_14');
		$position = $this->input->post('c_15');
		$citizenship = $this->input->post('c_16');
		$birth_month = $this->input->post('c_17');

		$date_employed = $this->input->post('c_18');
		$year_employment = $this->input->post('c_19');
		$age = $this->input->post('c_20');
		
		// echo $company."<br>".$division."<br>".$department."<br>".$section."<br>".$subsection."<br>".$classification."<br>".$location."<br>".$employment."<br>".$religion."<br>".$taxcode."<br>".$civil_status."<br>".$gender."<br>".$paytype."<br>".$status."<br>".$position."<br>".$citizenship."<br>".$birth_month."<br>".$date_employed."<br>".$year_employment."<br>".$age;

		if($company!='All' AND $company!='not_included'){ $this->db->where('a.company_id',$company); }
		if($division!='All' AND $division!='not_included'){ $this->db->where('a.division_id',$division); }
		if($department!='All' AND $department!='not_included'){ $this->db->where('a.department',$department); }
		if($section!='All' AND $section!='not_included'){ $this->db->where('a.section',$section); }
		if($subsection!='All' AND $subsection!='not_included'){ $this->db->where('a.subsection',$subsection); }
		if($classification!='All' AND $classification!='not_included'){ $this->db->where('a.classification',$classification); }

		
		$this->db->join('company_info b','b.company_id=a.company_id');	
		$this->db->join('division c','c.division_id=a.division_id','left');
		$this->db->join('department d','d.department_id=a.department');
		$this->db->join('section e','e.section_id=a.section');
		$this->db->join('subsection f','f.subsection_id=a.subsection','left');
		$this->db->join('location g','g.location_id=a.location');
		$this->db->join('employment h','h.employment_id=a.employment');
		$this->db->join('taxcode i','i.taxcode_id=a.taxcode');
		$this->db->join('pay_type j','j.pay_type_id=a.pay_type');
		$query = $this->db->get('employee_info a');
		return $query->result();
		

	}
	
	public function crystal_report()
	{
		$this->db->where('InActive',0);
		$query = $this->db->get('crystal_report_employee');
		return $query->result();
	}

	public function get_crystal_report_selected($id)
	{
		$this->db->join('crystal_report_employee_list b','b.idd=a.field_id');
		$this->db->where('a.crystal_id',$id);
		$query = $this->db->get('crystal_report_employee_fields a');
		return $query->result();
	}		

	public function get_employee_analytics()
	{
		$this->db->where('InActive',0);
		$query = $this->db->get('employee_analytics');
		return $query->result();
	}

	public function get_code_details($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('employee_analytics');
		return $query->row();
	}

	public function E1_result($company,$companylist)
	{		

			$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*,k.*,l.*,m.classification as classification_name,a.company_id as company_id');
			$this->db->join('company_info b','b.company_id=a.company_id');	
			$this->db->join('division c','c.division_id=a.division_id','left');
			$this->db->join('department d','d.department_id=a.department');
			$this->db->join('section e','e.section_id=a.section');
			$this->db->join('subsection f','f.subsection_id=a.subsection','left');
			$this->db->join('location g','g.location_id=a.location');
			$this->db->join('employment h','h.employment_id=a.employment');
			$this->db->join('classification m','m.classification_id=a.classification','left');
			$this->db->join('taxcode i','i.taxcode_id=a.taxcode','left');
			$this->db->join('pay_type j','j.pay_type_id=a.pay_type','left');
			$this->db->join('position k','k.position_id=a.position','left');
			$this->db->join('gender l','l.gender_id=a.gender','left');

			if($company=='All'){}
			else if($company=='Multiple')
			{
				$cc = substr_replace($companylist, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.company_id');
	 			$this->db->where($wheree);
			}
			else
			{
				$this->db->where('a.company_id',$company);
			}
			$query = $this->db->get('employee_info a');
			return $query->result();
	}

	public function E1_result_count($company,$companylist)
	{		

			if($company=='All'){
				$companylist = $this->general_model->companyList();
				foreach($companylist as $c)
				{
					$c->count = $this->e1_count($c->company_id);
				}

			}
			else if($company=='Multiple')
			{
				$cc = substr_replace($companylist, "", -1);
	 			$wheree = $this->get_condition_($cc,'company_id');
	 			$companylist = $this->e1_companyList('Multiple',$wheree);
				foreach($companylist as $c)
				{
					$c->count = $this->e1_count($c->company_id);
				}
			}
			else
			{
				$companylist = $this->e1_companyList('One',$company);
				foreach($companylist as $c)
				{
					$c->count = $this->e1_count($c->company_id);
				}
			}
		
			return $companylist;
	}	

	public function e1_companyList($option,$company)
	{
		if($option=='Multiple')
		{
			$this->db->where($company);
		}
		else
		{
			$this->db->where('company_id',$company);
		}
		
		$query = $this->db->get('company_info');
		return $query->result();
	}

	public function e1_count($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('employee_info');
		return $query->num_rows();	
	}

	public function E2_result($company,$division,$divisionList)
	{
			$cc = substr_replace($divisionList, "", -1);
	 		$wheree = $this->get_condition_($cc,'a.division_id');

			$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*,k.*,l.*,m.classification as classification_name,a.company_id as company_id');
			$this->db->join('company_info b','b.company_id=a.company_id');	
			$this->db->join('division c','c.division_id=a.division_id','left');
			$this->db->join('department d','d.department_id=a.department');
			$this->db->join('section e','e.section_id=a.section');
			$this->db->join('subsection f','f.subsection_id=a.subsection','left');
			$this->db->join('location g','g.location_id=a.location');
			$this->db->join('employment h','h.employment_id=a.employment');
			$this->db->join('classification m','m.classification_id=a.classification','left');
			$this->db->join('taxcode i','i.taxcode_id=a.taxcode','left');
			$this->db->join('pay_type j','j.pay_type_id=a.pay_type','left');
			$this->db->join('position k','k.position_id=a.position','left');
			$this->db->join('gender l','l.gender_id=a.gender','left');
			
			if($division=='All' || $division=='not_included'){} 
			else if($division=='Multiple')
			{	
				$this->db->where($wheree);
			}
			else { $this->db->where('a.division_id',$division); }

			$this->db->where('a.company_id',$company);
			
			$query = $this->db->get('employee_info a');
			return $query->result();
	}



	public function E2_result_count($company,$division,$divisionList)
	{
			if($division!='Multiple'){

				$divlist = $this->E2_multipledivision($division,$company,$division);
				foreach($divlist as $c)
				{
					$c->count = $this->e2_count($company,$c->division_id);
				}

			}
			else
			{
				$cc = substr_replace($divisionList, "", -1);
	 			$wheree = $this->get_condition_($cc,'division_id');
	 			$divlist = $this->E2_multipledivision($division,$company,$wheree);
				foreach($divlist as $c)
				{
					$c->count = $this->e2_count($company,$c->division_id);
				}
			}
			
			return $divlist;
	}

	public function E2_multipledivision($div,$company,$division)
	{
		if($div=='All'){ $this->db->where('company_id',$company); }
		else if($div=='Multiple'){ $this->db->where($division); }
		else { $this->db->where('division_id',$division); }
		$query= $this->db->get('division');
		return $query->result();
	}

	public function e2_count($company,$division_id)
	{
		$this->db->where('division_id',$division_id);
		$query = $this->db->get('employee_info');
		return $query->num_rows();	
	}


	public function E3_result($company,$division,$department,$departmentList)
	{
			$cc = substr_replace($departmentList, "", -1);
	 		$wheree = $this->get_condition_($cc,'a.department');

			$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*,k.*,l.*,m.classification as classification_name,a.company_id as company_id');
			$this->db->join('company_info b','b.company_id=a.company_id');	
			$this->db->join('division c','c.division_id=a.division_id','left');
			$this->db->join('department d','d.department_id=a.department');
			$this->db->join('section e','e.section_id=a.section');
			$this->db->join('subsection f','f.subsection_id=a.subsection','left');
			$this->db->join('location g','g.location_id=a.location');
			$this->db->join('employment h','h.employment_id=a.employment');
			$this->db->join('classification m','m.classification_id=a.classification','left');
			$this->db->join('taxcode i','i.taxcode_id=a.taxcode','left');
			$this->db->join('pay_type j','j.pay_type_id=a.pay_type','left');
			$this->db->join('position k','k.position_id=a.position','left');
			$this->db->join('gender l','l.gender_id=a.gender','left');
			
			if($division=='All' || $division=='not_included'){} 
			else
			{	
				$this->db->where('a.division_id',$division);
			}

			if($department=='All'){}
			else if($department=='Multiple')
			{
				$this->db->where($wheree);
			}
			else { $this->db->where('a.department',$department); }
			$this->db->where('a.company_id',$company);

			
			$query = $this->db->get('employee_info a');
			return $query->result();
	}

	public function E3_result_count($company,$division,$department,$departmentList)
	{
		if($department!='Multiple'){

				$deptlist = $this->E2_multipledepartment($department,$division,$company,$departmentList);
				foreach($deptlist as $c)
				{
					$c->count = $this->e3_count($company,$division,$c->department_id);
				}

			}
			else
			{
				$cc = substr_replace($departmentList, "", -1);
	 			$wheree = $this->get_condition_($cc,'department_id');
	 			$deptlist = $this->E2_multipledepartment($department,$division,$company,$wheree);
				foreach($deptlist as $c)
				{
					$c->count = $this->e3_count($company,$division,$c->department_id);
				}
			}
			
			return $deptlist;
	}

	public function E2_multipledepartment($department,$division,$company,$departmentList)
	{
		if($department=='All'){ if($division=='All'){ $this->db->where('company_id',$company); } else{ $this->db->where('division_id',$division); } }
		else if($department=='Multiple')
			{
				$this->db->where($departmentList);
			}
		else{ $this->db->where('department_id',$department); } 
		$query = $this->db->get('department');
		return $query->result();
	}

	public function e3_count($company,$division,$cdepartment_id)
	{
		$this->db->where('department',$cdepartment_id);
		$query = $this->db->get('employee_info');
		return $query->num_rows();			
	}

	public function E4_result($company,$division,$department,$section,$sectionList)
	{
			$cc = substr_replace($sectionList, "", -1);
	 		$wheree = $this->get_condition_($cc,'a.section');

			$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*,k.*,l.*,m.classification as classification_name,a.company_id as company_id');
			$this->db->join('company_info b','b.company_id=a.company_id');	
			$this->db->join('division c','c.division_id=a.division_id','left');
			$this->db->join('department d','d.department_id=a.department');
			$this->db->join('section e','e.section_id=a.section');
			$this->db->join('subsection f','f.subsection_id=a.subsection','left');
			$this->db->join('location g','g.location_id=a.location');
			$this->db->join('employment h','h.employment_id=a.employment');
			$this->db->join('classification m','m.classification_id=a.classification','left');
			$this->db->join('taxcode i','i.taxcode_id=a.taxcode','left');
			$this->db->join('pay_type j','j.pay_type_id=a.pay_type','left');
			$this->db->join('position k','k.position_id=a.position','left');
			$this->db->join('gender l','l.gender_id=a.gender','left');
			
			if($division=='All' || $division=='not_included'){} 
			else {	 $this->db->where('a.division_id',$division); }

			if($department=='All'){}
			else { $this->db->where('a.department',$department); }

			if($section=='All'){}
			else if($section=='Multiple')
			{
				$this->db->where($wheree);
			}
			else { $this->db->where('a.section',$section); }

			$this->db->where('a.company_id',$company);

			$query = $this->db->get('employee_info a');
			return $query->result();
	}

	public function E4_result_count($company,$division,$department,$section,$sectionList)
	{
			if($section!='Multiple'){

				$sectionlist = $this->E4_multiplesection($company,$division,$department,$section,$sectionList);
				foreach($sectionlist as $c)
				{
					$c->count = $this->e4_count($c->section_id);
				}

			}
			else
			{
				$cc = substr_replace($sectionList, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.section_id');

	 			$sectionlist = $this->E4_multiplesection($company,$division,$department,$section,$wheree);
				foreach($sectionlist as $c)
				{
					$c->count = $this->e4_count($c->section_id);
				}
			}
			
			return $sectionlist;
	}

	public function E4_multiplesection($company,$division,$department,$section,$sectionList)
	{
		if($section=='All')
		{
			if($department=='All')
			{
				if($division=='All' || $division=='not_included'){}
				else{ $this->db->where('b.division_id',$division); }
			}	
			else
			{
				$this->db->where('b.department_id',$department);
			}
		}
		else if($section=='Multiple')
		{
			$this->db->where($sectionList);
		}
		else
		{
			$this->db->where('a.section_id',$section);
		}
		$this->db->where('b.company_id',$company);
		$this->db->join('department b','b.department_id=a.department_id');
		$query = $this->db->get('section a');
		return $query->result();
	}

	public function e4_count($section_id)
	{
		$this->db->where('section',$section_id);
		$query = $this->db->get('employee_info');
		return $query->num_rows();		
	}

	public function E5_result($company,$division,$department,$section,$subsection,$subsectionList)
	{
			$cc = substr_replace($subsectionList, "", -1);
	 		$wheree = $this->get_condition_($cc,'a.subsection');

			$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*,k.*,l.*,m.classification as classification_name,a.company_id as company_id');
			$this->db->join('company_info b','b.company_id=a.company_id');	
			$this->db->join('division c','c.division_id=a.division_id','left');
			$this->db->join('department d','d.department_id=a.department');
			$this->db->join('section e','e.section_id=a.section');
			$this->db->join('subsection f','f.subsection_id=a.subsection','left');
			$this->db->join('location g','g.location_id=a.location');
			$this->db->join('employment h','h.employment_id=a.employment');
			$this->db->join('classification m','m.classification_id=a.classification','left');
			$this->db->join('taxcode i','i.taxcode_id=a.taxcode','left');
			$this->db->join('pay_type j','j.pay_type_id=a.pay_type','left');
			$this->db->join('position k','k.position_id=a.position','left');
			$this->db->join('gender l','l.gender_id=a.gender','left');
			
			if($division=='All' || $division=='not_included'){} 
			else {	 $this->db->where('a.division_id',$division); }

			if($department=='All'){}
			else { $this->db->where('a.department',$department); }

			if($section=='All'){}
			else { $this->db->where('a.section',$section); }

			if($subsection=='All'){}
			else if($subsection=='Multiple')
			{
				$this->db->where($wheree);
			}
			else { $this->db->where('a.subsection',$subsection); }

			$this->db->where('a.company_id',$company);

			$query = $this->db->get('employee_info a');
			return $query->result();
	}

	public function E5_result_count($company,$division,$department,$section,$subsection,$subsectionList)
	{
			if($subsection!='Multiple'){

				$subsectionlist = $this->E5_multiplesubsection($company,$division,$department,$section,$subsection,$subsectionList);
				foreach($subsectionlist as $c)
				{
					$c->count = $this->e5_count($c->subsection_id);
				}

			}
			else
			{
				$cc = substr_replace($subsectionList, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.subsection_id');

	 			$subsectionlist = $this->E5_multiplesubsection($company,$division,$department,$section,$subsection,$wheree);
				foreach($subsectionlist as $c)
				{
					$c->count = $this->e5_count($c->subsection_id);
				}
			}
			
			return $subsectionlist;
	}

	public function E5_multiplesubsection($company,$division,$department,$section,$subsection,$subsectionList)
	{
		$this->db->where('c.company_id',$company);
		if($subsection=='All')
		{
			if($section=='All')
			{
				if($department=='All')
				{
					if($division=='not_included' || $division=='All'){}
					else{ $this->db->where('d.division_id',$division); }
				}
				else
				{
					$this->db->where('c.department_id',$department);
				}
			}
			else
			{
				$this->db->where('b.section_id',$section);
			}
		}	
		else if($subsection=='Multiple')
		{
			$this->db->where($subsectionList);
		}
		else
		{
			$this->db->where('a.subsection_id',$subsection);
		}
		$this->db->join('section b','b.section_id=a.section_id');
		$this->db->join('department c','c.department_id=b.department_id');
		$this->db->join('division d','d.division_id=c.division_id','left');
		$query = $this->db->get('subsection a');
		return $query->result();
	}

	public function e5_count($subsection_id)
	{
		$this->db->where('subsection',$subsection_id);
		$query = $this->db->get('employee_info');
		return $query->num_rows();	
	}

	public function E6_result($company,$division,$department,$section,$subsection,$location,$locationList)
	{
			$cc = substr_replace($locationList, "", -1);
	 		$wheree = $this->get_condition_($cc,'a.location');

			$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*,k.*,l.*,m.classification as classification_name,a.company_id as company_id');
			$this->db->join('company_info b','b.company_id=a.company_id');	
			$this->db->join('division c','c.division_id=a.division_id','left');
			$this->db->join('department d','d.department_id=a.department');
			$this->db->join('section e','e.section_id=a.section');
			$this->db->join('subsection f','f.subsection_id=a.subsection','left');
			$this->db->join('location g','g.location_id=a.location');
			$this->db->join('employment h','h.employment_id=a.employment');
			$this->db->join('classification m','m.classification_id=a.classification','left');
			$this->db->join('taxcode i','i.taxcode_id=a.taxcode','left');
			$this->db->join('pay_type j','j.pay_type_id=a.pay_type','left');
			$this->db->join('position k','k.position_id=a.position','left');
			$this->db->join('gender l','l.gender_id=a.gender','left');
			
			if($division=='All' || $division=='not_included'){} 
			else {	 $this->db->where('a.division_id',$division); }

			if($department=='All'){}
			else { $this->db->where('a.department',$department); }

			if($section=='All'){}
			else { $this->db->where('a.section',$section); }


			if($subsection=='All' || $subsection=='not_included'){}
			else { $this->db->where('a.subsection',$subsection); }

			if($location=='All'){}
			else if($location=='Multiple')
			{
				$this->db->where($wheree);
			}
			else { $this->db->where('a.location',$location); }

			$this->db->where('a.company_id',$company);

			$query = $this->db->get('employee_info a');
			return $query->result();
	}

	public function E6_result_count($company,$division,$department,$section,$subsection,$location,$locationList)
	{
			if($location!='Multiple'){

				$locationlist = $this->E6_multiplelocation($company,$location,$locationList);
				foreach($locationlist as $c)
				{
					$c->count = $this->e6_count($c->location_id,$company,$division,$department,$section,$subsection);
				}

			}
			else
			{
				$cc = substr_replace($locationlist, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.location_id');

	 			$locationlist = $this->E6_multiplelocation($company,$location,$wheree);
				foreach($locationlist as $c)
				{
					$c->count = $this->e6_count($c->location_id,$company,$division,$department,$section,$subsection);
				}
			}
			
			return $locationlist;
	}

	public function E6_multiplelocation($company,$location,$locationList)
	{	
		$this->db->where('b.company_id',$company);
		if($location=='All'){}
		else if($location=='Multiple'){ $this->db->where($locationList); }
		else{ $this->db->where('a.location_id',$location); }
		$this->db->join('company_location b','b.location_id=a.location_id');
		$query = $this->db->get('location a');
		return $query->result();	
	}

	public function e6_count($location,$company,$division,$department,$section,$subsection)
	{
		if($division=='All' || $division=='not_included'){} else{ $this->db->where('division_id',$division); }
		if($department=='All' || $department=='not_included'){} else{ $this->db->where('department',$department);  }
		if($section=='All' || $section=='not_included'){} else{ $this->db->where('section',$section);  }
		if($subsection=='All' || $subsection=='not_included'){} else{  $this->db->where('subsection',$subsection);  }
		$this->db->where('company_id',$company);
		$this->db->where('location',$location);
		$query = $this->db->get('employee_info');
		return $query->num_rows();
	}

	public function E7_result($company,$division,$department,$section,$subsection,$location,$classification,$classificationList)
	{
		    $cc = substr_replace($classificationList, "", -1);
	 		$wheree = $this->get_condition_($cc,'a.classification');

			$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*,k.*,l.*,m.classification as classification_name,a.company_id as company_id');
			$this->db->join('company_info b','b.company_id=a.company_id');	
			$this->db->join('division c','c.division_id=a.division_id','left');
			$this->db->join('department d','d.department_id=a.department');
			$this->db->join('section e','e.section_id=a.section');
			$this->db->join('subsection f','f.subsection_id=a.subsection','left');
			$this->db->join('location g','g.location_id=a.location');
			$this->db->join('employment h','h.employment_id=a.employment');
			$this->db->join('classification m','m.classification_id=a.classification','left');
			$this->db->join('taxcode i','i.taxcode_id=a.taxcode','left');
			$this->db->join('pay_type j','j.pay_type_id=a.pay_type','left');
			$this->db->join('position k','k.position_id=a.position','left');
			$this->db->join('gender l','l.gender_id=a.gender','left');
			
			if($division=='All' || $division=='not_included'){} 
			else {	 $this->db->where('a.division_id',$division); }

			if($department=='All'){}
			else { $this->db->where('a.department',$department); }

			if($section=='All'){}
			else { $this->db->where('a.section',$section); }


			if($subsection=='All' || $subsection=='not_included'){}
			else { $this->db->where('a.subsection',$subsection); }

			if($location=='All' || $location=='not_included'){}
			else { $this->db->where('a.location',$location); }


			if($classification=='All'){}
			else if($classification=='Multiple')
			{
				$this->db->where($wheree);
			}
			else { $this->db->where('a.classification',$classification); }

			$this->db->where('a.company_id',$company);

			$query = $this->db->get('employee_info a');
			return $query->result();
	}


	public function E7_result_count($company,$division,$department,$section,$subsection,$location,$classification,$classificationList)
	{
			if($classification!='Multiple'){

				$classificationlist = $this->E7_multipleclassification($company,$classification,$classificationList);
				foreach($classificationlist as $c)
				{
					$c->count = $this->e7_count($company,$division,$department,$section,$subsection,$location,$c->classification_id,$classificationList);
				}

			}
			else
			{
				$cc = substr_replace($classificationList, "", -1);
	 			$wheree = $this->get_condition_($cc,'classification_id');

	 			$classificationlist = $this->E7_multipleclassification($company,$classification,$wheree);
	 					
	 			foreach($classificationlist as $c)
				{
					$c->count = $this->e7_count($company,$division,$department,$section,$subsection,$location,$c->classification_id,$classificationList);
				}
			}
			
			return $classificationlist;
	}

	public function E7_multipleclassification($company,$classification,$classificationList)
	{
		$this->db->select('*,classification as classification_name');
		if($classification=='All'){ $this->db->where('company_id',$company); }
		else if($classification=='Multiple'){ $this->db->where($classificationList); }
		else{ $this->db->where('classification_id',$classification); }
		$query = $this->db->get('classification');
		return $query->result();
	}

	public function e7_count($company,$division,$department,$section,$subsection,$location,$classification,$classificationList)
	{
		if($division=='All' || $division=='not_included'){} else{ $this->db->where('division_id',$division); }
		if($department=='All' || $department=='not_included'){} else{ $this->db->where('department',$department);  }
		if($section=='All' || $section=='not_included'){} else{ $this->db->where('section',$section);  }
		if($subsection=='All' || $subsection=='not_included'){} else{  $this->db->where('subsection',$subsection);  }
		$this->db->where('company_id',$company);
		if($location!='All') { $this->db->where('location',$location); }
		$this->db->where('classification',$classification);
		$query = $this->db->get('employee_info');
		return $query->num_rows();	
	}

	public function E8_result($company,$division,$department,$section,$subsection,$location,$classification,$employment,$employmentList)
	{
		    $cc = substr_replace($employmentList, "", -1);
	 		$wheree = $this->get_condition_($cc,'a.employment');

			$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*,k.*,l.*,m.classification as classification_name,a.company_id as company_id');
			$this->db->join('company_info b','b.company_id=a.company_id');	
			$this->db->join('division c','c.division_id=a.division_id','left');
			$this->db->join('department d','d.department_id=a.department');
			$this->db->join('section e','e.section_id=a.section');
			$this->db->join('subsection f','f.subsection_id=a.subsection','left');
			$this->db->join('location g','g.location_id=a.location');
			$this->db->join('employment h','h.employment_id=a.employment');
			$this->db->join('classification m','m.classification_id=a.classification','left');
			$this->db->join('taxcode i','i.taxcode_id=a.taxcode','left');
			$this->db->join('pay_type j','j.pay_type_id=a.pay_type','left');
			$this->db->join('position k','k.position_id=a.position','left');
			$this->db->join('gender l','l.gender_id=a.gender','left');
			
			if($division=='All' || $division=='not_included'){} 
			else {	 $this->db->where('a.division_id',$division); }

			if($department=='All'){}
			else { $this->db->where('a.department',$department); }

			if($section=='All'){}
			else { $this->db->where('a.section',$section); }


			if($subsection=='All' || $subsection=='not_included'){}
			else { $this->db->where('a.subsection',$subsection); }

			if($location=='All' || $location=='not_included'){}
			else { $this->db->where('a.location',$location); }

			if($classification=='All' || $classification=='not_included'){}
			else { $this->db->where('a.classification',$classification); }


			if($employment=='All'){}
			else if($employment=='Multiple')
			{
				$this->db->where($wheree);
			}
			else { $this->db->where('a.employment',$employment); }

			$this->db->where('a.company_id',$company);

			$query = $this->db->get('employee_info a');
			return $query->result();
	}

	public function E8_result_count($company,$division,$department,$section,$subsection,$location,$classification,$employment,$employmentList)
	{
			if($employment!='Multiple'){

				$employmentlist = $this->E8_multipleemployment($company,$employment,$employmentList);
				foreach($employmentlist as $c)
				{
					$c->count = $this->e8_count($company,$division,$department,$section,$subsection,$location,$classification,$c->employment_id,$employmentList);
				}

			}
			else
			{
				$cc = substr_replace($employmentList, "", -1);
	 			$wheree = $this->get_condition_($cc,'employment_id');

	 			$employmentlist = $this->E8_multipleemployment($company,$employment,$wheree);
	 					
	 			foreach($employmentlist as $c)
				{
					$c->count = $this->e8_count($company,$division,$department,$section,$subsection,$location,$classification,$c->employment_id,$employmentList);
				}
			}
			
			return $employmentlist;
	}

	public function E8_multipleemployment($company,$employment,$employmentList)
	{
		if($employment=='All') {}
		else if($employment=='Multiple'){ $this->db->where($employmentList);  }
		else { $this->db->where('employment_id',$employment); }
		$query = $this->db->get('employment');
		return $query->result();
	}

	public function e8_count($company,$division,$department,$section,$subsection,$location,$classification,$employment_id,$employmentList)
	{
		if($division=='All' || $division=='not_included'){} else{ $this->db->where('division_id',$division); }
		if($department=='All' || $department=='not_included'){} else{ $this->db->where('department',$department);  }
		if($section=='All' || $section=='not_included'){} else{ $this->db->where('section',$section);  }
		if($subsection=='All' || $subsection=='not_included'){} else{  $this->db->where('subsection',$subsection);  }
		$this->db->where('company_id',$company);
		if($location!='All') { $this->db->where('location',$location); }
		if($classification!='All') { $this->db->where('classification',$classification); }
		$this->db->where('employment',$employment_id);
		$query = $this->db->get('employee_info');
		return $query->num_rows();
	}

	public function other_option_result($code,$company,$crystal_report,$division,$department,$section,$subsection,$location,$classification,$employment,$other,$otherList,$viewing_option)
	{

			$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*,k.*,l.*,m.classification as classification_name,a.company_id as company_id');
			$this->db->join('company_info b','b.company_id=a.company_id');	
			$this->db->join('division c','c.division_id=a.division_id','left');
			$this->db->join('department d','d.department_id=a.department');
			$this->db->join('section e','e.section_id=a.section');
			$this->db->join('subsection f','f.subsection_id=a.subsection','left');
			$this->db->join('location g','g.location_id=a.location');
			$this->db->join('employment h','h.employment_id=a.employment');
			$this->db->join('classification m','m.classification_id=a.classification');
			$this->db->join('taxcode i','i.taxcode_id=a.taxcode','left');
			$this->db->join('pay_type j','j.pay_type_id=a.pay_type','left');
			$this->db->join('position k','k.position_id=a.position','left');
			$this->db->join('gender l','l.gender_id=a.gender','left');
			
			if($division=='All' || $division=='not_included'){} else { $this->db->where('a.division_id',$division); }

			if($department=='All' || $department=='not_included'){} else { $this->db->where('a.department',$department); }
			if($section=='All' || $section=='not_included'){} else { $this->db->where('a.section',$section); }
			if($subsection=='All' || $subsection=='not_included'){} else { $this->db->where('a.subsection',$subsection); }

			if($location=='All' || $location=='not_included'){} else { $this->db->where('a.location',$location); }
			if($employment=='All' || $employment=='not_included'){} else { $this->db->where('a.employment',$employment); }
			if($classification=='All' || $classification=='not_included'){} else { $this->db->where('a.classification',$classification); }

			if($code=='E9')
			{
				if($other=='All' || $other=='not_included'){} 
				else if($other=='Multiple')
				{
					$cc = substr_replace($otherList, "", -1);
					$wheree = $this->get_condition_($cc,'taxcode');
					$this->db->where($wheree);
				}
				else { $this->db->where('a.taxcode',$other); }
			}
			
			else if($code=='E13')
			{
				if($other=='All' || $other=='not_included'){} 
				else if($other=='Multiple')
				{
					$cc = substr_replace($otherList, "", -1);
					$wheree = $this->get_condition_($cc,'civil_status');
					$this->db->where($wheree);
				}
				else { $this->db->where('a.civil_status',$other); }
			}
			else if($code=='E14')
			{
				if($other=='All' || $other=='not_included'){} 
				else if($other=='Multiple')
				{
					$cc = substr_replace($otherList, "", -1);
					$wheree = $this->get_condition_($cc,'gender');
					$this->db->where($wheree);
				}
				else { $this->db->where('a.gender',$other); }
			}
			else if($code=='E15')
			{
				if($other=='All' || $other=='not_included'){} 
				else if($other=='Multiple')
				{
					$cc = substr_replace($otherList, "", -1);
					$wheree = $this->get_condition_($cc,'position');
					$this->db->where($wheree);
				}
				else { $this->db->where('a.position',$other); }
			}
			
			else if($code=='E17')
			{
				if($other=='All' || $other=='not_included'){} 
				else if($other=='Multiple')
				{
					$cc = substr_replace($otherList, "", -1);
					$wheree = $this->get_condition_($cc,'pay_type');
					$this->db->where($wheree);
				}
				else { $this->db->where('a.pay_type',$other); }
			}
			else if($code=='E18')
			{
				if($other=='All' || $other=='not_included'){} 
				else if($other=='Multiple')
				{
					$cc = substr_replace($otherList, "", -1);
					$wheree = $this->get_condition_($cc,'religion');
					$this->db->where($wheree);
				}
				else { $this->db->where('a.religion',$other); }
			} else{}
			$this->db->where('a.company_id',$company);
			
			$query = $this->db->get('employee_info a');
			return $query->result();	
	}

	public function other_option_result_count($code,$company,$crystal_report,$division,$department,$section,$subsection,$location,$classification,$employment,$other,$otherList,$viewing_option)
	{	
		
			if($other!='Multiple')
			{

						if($code=='E9')
						{
							$otherlistt = $this->other_option_multiple($other,$otherList,'taxcode','taxcode_id');
							foreach($otherlistt as $c)
							{
								$c->count = $this->other_option_count($code,$company,$crystal_report,$division,$department,$section,$subsection,$location,$classification,$employment,$c->taxcode_id,$otherList,'taxcode');
							}
						}
						else if($code=='E13')
						{
							$otherlistt = $this->other_option_multiple($other,$otherList,'civil_status','civil_status_id');
							foreach($otherlistt as $c)
							{
								$c->count = $this->other_option_count($code,$company,$crystal_report,$division,$department,$section,$subsection,$location,$classification,$employment,$c->civil_status_id,$otherList,'civil_status');
							}
						}
						else if($code=='E14')
						{
							$otherlistt = $this->other_option_multiple($other,$otherList,'gender','gender_id');
							foreach($otherlistt as $c)
							{
								$c->count = $this->other_option_count($code,$company,$crystal_report,$division,$department,$section,$subsection,$location,$classification,$employment,$c->gender_id,$otherList,'gender');
							}
						}
						else if($code=='E15')
						{
							$otherlistt = $this->other_option_multiple($other,$otherList,'position','position_id');
							foreach($otherlistt as $c)
							{
								$c->count = $this->other_option_count($code,$company,$crystal_report,$division,$department,$section,$subsection,$location,$classification,$employment,$c->position_id,$otherList,'position');
							}
						}
						else if($code=='E17')
						{
							$otherlistt = $this->other_option_multiple($other,$otherList,'pay_type','pay_type_id');
							foreach($otherlistt as $c)
							{
								$c->count = $this->other_option_count($code,$company,$crystal_report,$division,$department,$section,$subsection,$location,$classification,$employment,$c->pay_type_id,$otherList,'pay_type');
							}
						}
						else if($code=='E18')
						{
							$otherlistt = $this->other_option_multiplereligion($other,$otherList);
							foreach($otherlistt as $c)
							{
								$c->count = $this->other_option_count($code,$company,$crystal_report,$division,$department,$section,$subsection,$location,$classification,$employment,$c->param_id,$otherList,'religion');
							}
						}
			}
			else
			{
						$cc = substr_replace($otherList, "", -1);

						if($code=='E9')
						{
							$wheree = $this->get_condition_($cc,'taxcode_id');
				 			$otherlistt = $this->other_option_multiple($other,$wheree,'taxcode','taxcode_id');
				 			foreach($otherlistt as $c)
							{
								$c->count = $this->other_option_count($code,$company,$crystal_report,$division,$department,$section,$subsection,$location,$classification,$employment,$c->taxcode_id,$otherList,'taxcode');
							}
						}
						else if($code=='E13')
						{
							$wheree = $this->get_condition_($cc,'civil_status_id');
				 			$otherlistt = $this->other_option_multiple($other,$wheree,'civil_status','civil_status_id');
				 			foreach($otherlistt as $c)
							{
								$c->count = $this->other_option_count($code,$company,$crystal_report,$division,$department,$section,$subsection,$location,$classification,$employment,$c->civil_status_id,$otherList,'civil_status');
							}
						}
						else if($code=='E14')
						{
							$wheree = $this->get_condition_($cc,'gender_id');
				 			$otherlistt = $this->other_option_multiple($other,$wheree,'gender','gender_id');
				 			foreach($otherlistt as $c)
							{
								$c->count = $this->other_option_count($code,$company,$crystal_report,$division,$department,$section,$subsection,$location,$classification,$employment,$c->gender_id,$otherList,'gender');
							}
						}	

						else if($code=='E15')
						{
							$wheree = $this->get_condition_($cc,'position_id');
				 			$otherlistt = $this->other_option_multiple($other,$wheree,'position','position_id');
				 			foreach($otherlistt as $c)
							{
								$c->count = $this->other_option_count($code,$company,$crystal_report,$division,$department,$section,$subsection,$location,$classification,$employment,$c->position_id,$otherList,'position');
							}
						}
						else if($code=='E17')
						{
							$wheree = $this->get_condition_($cc,'pay_type_id');
				 			$otherlistt = $this->other_option_multiple($other,$wheree,'pay_type','pay_type_id');
				 			foreach($otherlistt as $c)
							{
								$c->count = $this->other_option_count($code,$company,$crystal_report,$division,$department,$section,$subsection,$location,$classification,$employment,$c->pay_type_id,$otherList,'pay_type');
							}
						}
						else if($code=='E18')
						{
							$wheree = $this->get_condition_($cc,'param_id');
				 			$otherlistt = $this->other_option_multiplereligion($other,$wheree);
				 			foreach($otherlistt as $c)
							{
								$c->count = $this->other_option_count($code,$company,$crystal_report,$division,$department,$section,$subsection,$location,$classification,$employment,$c->param_id,$otherList,'religion');
							}
						}
			}
			
			return $otherlistt;
	}

	public function other_option_multiplereligion($other,$otherList)
	{
		if($other=='All'){}
		else if($other=='Multiple')
		{
			$this->db->where($otherList);
		}
		else
		{
			$this->db->where('param_id',$other);
		}
		$this->db->where('cCode','religion');
		$query = $this->db->get('system_parameters');
		return $query->result();
	}

	public function other_option_multiple($other,$otherlist,$table,$table_id)
	{
		if($other=='All') {
			if($table=='position'){ $this->db->where('isEmployer',0); }
		}
		else if($other=='Multiple'){ $this->db->where($otherlist);  }
		else { $this->db->where($table_id,$other); }
		$query = $this->db->get($table);
		return $query->result();
	}

	public function other_option_count($code,$company,$crystal_report,$division,$department,$section,$subsection,$location,$classification,$employment,$other_id,$otherList,$table_name)
	{
		if($division=='All' || $division=='not_included'){} else{ $this->db->where('division_id',$division); }
		if($department=='All' || $department=='not_included'){} else{ $this->db->where('department',$department);  }
		if($section=='All' || $section=='not_included'){} else{ $this->db->where('section',$section);  }
		if($subsection=='All' || $subsection=='not_included'){} else{  $this->db->where('subsection',$subsection);  }
		$this->db->where('company_id',$company);
		if($location!='All') { $this->db->where('location',$location); }
		if($classification!='All') { $this->db->where('classification',$classification); }
		if($employment!='All') { $this->db->where('employment',$employment); }
		$this->db->where($table_name,$other_id);
		
		$query = $this->db->get('employee_info');
		return $query->num_rows();
	}

	public function other_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$other,$from,$to)
	{
			$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*,k.*,l.*,m.classification as classification_name,a.company_id as company_id');
			$this->db->join('company_info b','b.company_id=a.company_id');	
			$this->db->join('division c','c.division_id=a.division_id','left');
			$this->db->join('department d','d.department_id=a.department');
			$this->db->join('section e','e.section_id=a.section');
			$this->db->join('subsection f','f.subsection_id=a.subsection','left');
			$this->db->join('location g','g.location_id=a.location');
			$this->db->join('employment h','h.employment_id=a.employment');
			$this->db->join('classification m','m.classification_id=a.classification','left');
			$this->db->join('taxcode i','i.taxcode_id=a.taxcode','left');
			$this->db->join('pay_type j','j.pay_type_id=a.pay_type','left');
			$this->db->join('position k','k.position_id=a.position','left');
			$this->db->join('gender l','l.gender_id=a.gender','left');
			
			if($division=='All' || $division=='not_included'){} else { $this->db->where('a.division_id',$division); }

			if($department=='All' || $department=='not_included'){} else { $this->db->where('a.department',$department); }
			if($section=='All' || $section=='not_included'){} else { $this->db->where('a.section',$section); }
			if($subsection=='All' || $subsection=='not_included'){} else { $this->db->where('a.subsection',$subsection); }
			if($employment=='All' || $employment=='not_included'){} else { $this->db->where('a.employment',$employment); }
			if($classification=='All' || $classification=='not_included'){} else { $this->db->where('a.classification',$classification); }

			if($code=='E10')
			{
				if($other=='All' || $other=='not_included'){} else { $this->db->where('a.InActive',$other); }
			}
			
			else if($code=='E12')
			{
				if($from!='All'){ $where = "date(a.date_employed) between '" .$from. "' and '" .$to. "'"; $this->db->where($where); }
			}
			else{}
			$this->db->where('a.company_id',$company);
			
			$query = $this->db->get('employee_info a');
			return $query->result();
	}

	public function get_condition_($option,$val)
	{
		
		$c =  explode('-', $option);
		$string_l="";
		foreach($c as $a)
            { 	 
            	$dd = $val.'="'.$a.'" or ';
                $string_l .= $dd;
            }
        $res_l = substr($string_l, 0, -4);
        $where_l = "(".$res_l.")";
        return $where_l;

	}

	public function get_datas($id)
	{
		$this->db->where('param_id',$id);
		$query = $this->db->get('system_parameters',1);
		$data = $query->row('cValue');

		if(empty($data)) { return 'no data'; }
		else{ return $data; }
	}

	public function address($table,$id,$val)
	{
		$this->db->where('id',$id);
		$query = $this->db->get($table);
		
		$data = $query->row($val);

		if(empty($data)) { return 'no data'; }
		else{ return $data; }
	}



	public function all_result($code,$company,$crystal_report,$division,$department,$section,$subsection,$location,$classification,$employment,$taxcode,$status,$gender,$civil_status,$position,$paytype,$religion,$age_from,$age_to,$dateemp_from,$dateemp_to,$yremp_from,$yremp_to)
	{

			$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*,k.*,l.*,m.classification as classification_name,a.company_id as company_id');
			$this->db->join('company_info b','b.company_id=a.company_id');	
			$this->db->join('division c','c.division_id=a.division_id','left');
			$this->db->join('department d','d.department_id=a.department');
			$this->db->join('section e','e.section_id=a.section');
			$this->db->join('subsection f','f.subsection_id=a.subsection','left');
			$this->db->join('location g','g.location_id=a.location');
			$this->db->join('employment h','h.employment_id=a.employment');
			$this->db->join('classification m','m.classification_id=a.classification','left');
			$this->db->join('taxcode i','i.taxcode_id=a.taxcode','left');
			$this->db->join('pay_type j','j.pay_type_id=a.pay_type','left');
			$this->db->join('position k','k.position_id=a.position','left');
			$this->db->join('gender l','l.gender_id=a.gender','left');
			
			if($division=='All' || $division=='not_included'){} else { $this->db->where('a.division_id',$division); }

			if($department=='All' || $department=='not_included'){} else { $this->db->where('a.department',$department); }
			if($section=='All' || $section=='not_included'){} else { $this->db->where('a.section',$section); }
			if($subsection=='All' || $subsection=='not_included'){} else { $this->db->where('a.subsection',$subsection); }
			if($employment=='All' || $employment=='not_included'){} else { $this->db->where('a.employment',$employment); }
			if($classification=='All' || $classification=='not_included'){} else { $this->db->where('a.classification',$classification); }
			if($location=='All' || $location=='not_included'){} else { $this->db->where('a.location',$location); }

			
			if($taxcode=='All' || $taxcode=='not_included'){} else { $this->db->where('a.taxcode',$taxcode); }
			
			if($status=='All' || $status=='not_included'){} else { $this->db->where('a.InActive',$status); }
			
			if($dateemp_from!='All'){ $where = "date(a.date_employed) between '" .$dateemp_from. "' and '" .$dateemp_to. "'"; $this->db->where($where); }
			
			if($civil_status=='All' || $civil_status=='not_included'){} else { $this->db->where('a.civil_status',$civil_status); }
			
			if($gender=='All' || $gender=='not_included'){} else { $this->db->where('a.gender',$gender); }
			
			if($position=='All' || $position=='not_included'){} else { $this->db->where('a.position',$position); }
			
			if($paytype=='All' || $paytype=='not_included'){} else { $this->db->where('a.pay_type',$paytype); }
			
			if($religion=='All' || $religion=='not_included'){} else { $this->db->where('a.religion',$religion); }

			$this->db->where('a.company_id',$company);
			
			$query = $this->db->get('employee_info a');
			$result =  $query->result();

			$i = $query->num_rows();
			foreach($result as $key => $q)
			{
				  $age = $q->age;
				  $date1 = $q->date_employed;
	              $date2 = date('Y-m-d');
	              $ts1 = strtotime($date1);
	              $ts2 = strtotime($date2);
	              $year1 = date('Y', $ts1);
	              $year2 = date('Y', $ts2);
	              $month1 = date('m', $ts1);
	              $month2 = date('m', $ts2);
	              $months_employed = $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
	              $value1 = $months_employed /12;

				if($age_from!='All')
                {
                    if($age <=$age_to AND $age >= $age_from)
                    {
                      $ageresult=true;
                    }
                    else
                    {
                      $ageresult=false;
                    }
                }
                else{ $ageresult=true; }

                if($yremp_from!='All')
                  {
                    if($value1 <=$yremp_to AND $value1 >= $yremp_from)
                    {
                      $yearresult=true;
                    }
                    else
                    {
                      $yearresult=false;
                    }
                  }
                 else{  $yearresult=true; }

      				
                 if($yearresult==true AND $ageresult==true)
                 {
                 	$i = $i;
                 }
                 else
                 {
                 	$i = $i-1;
                 }

			}

			return $i;
	}
	public function all_result_detailed($code,$company,$crystal_report,$division,$department,$section,$subsection,$location,$classification,$employment,$taxcode,$status,$gender,$civil_status,$position,$paytype,$religion,$age_from,$age_to,$dateemp_from,$dateemp_to,$yremp_from,$yremp_to)
	{
			$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*,k.*,l.*,m.classification as classification_name,a.company_id as company_id');
			$this->db->join('company_info b','b.company_id=a.company_id');	
			$this->db->join('division c','c.division_id=a.division_id','left');
			$this->db->join('department d','d.department_id=a.department');
			$this->db->join('section e','e.section_id=a.section');
			$this->db->join('subsection f','f.subsection_id=a.subsection','left');
			$this->db->join('location g','g.location_id=a.location');
			$this->db->join('employment h','h.employment_id=a.employment');
			$this->db->join('classification m','m.classification_id=a.classification','left');
			$this->db->join('taxcode i','i.taxcode_id=a.taxcode','left');
			$this->db->join('pay_type j','j.pay_type_id=a.pay_type','left');
			$this->db->join('position k','k.position_id=a.position','left');
			$this->db->join('gender l','l.gender_id=a.gender','left');
			
			if($division=='All' || $division=='not_included'){} else { $this->db->where('a.division_id',$division); }

			if($department=='All' || $department=='not_included'){} else { $this->db->where('a.department',$department); }
			if($section=='All' || $section=='not_included'){} else { $this->db->where('a.section',$section); }
			if($subsection=='All' || $subsection=='not_included'){} else { $this->db->where('a.subsection',$subsection); }
			if($employment=='All' || $employment=='not_included'){} else { $this->db->where('a.employment',$employment); }
			if($classification=='All' || $classification=='not_included'){} else { $this->db->where('a.classification',$classification); }
			if($location=='All' || $location=='not_included'){} else { $this->db->where('a.location',$location); }

			
			if($taxcode=='All' || $taxcode=='not_included'){} else { $this->db->where('a.taxcode',$taxcode); }
			
			if($status=='All' || $status=='not_included'){} else { $this->db->where('a.InActive',$status); }
			
			if($dateemp_from!='All'){ $where = "date(a.date_employed) between '" .$dateemp_from. "' and '" .$dateemp_to. "'"; $this->db->where($where); }
			
			if($civil_status=='All' || $civil_status=='not_included'){} else { $this->db->where('a.civil_status',$civil_status); }
			
			if($gender=='All' || $gender=='not_included'){} else { $this->db->where('a.gender',$gender); }
			
			if($position=='All' || $position=='not_included'){} else { $this->db->where('a.position',$position); }
			
			if($paytype=='All' || $paytype=='not_included'){} else { $this->db->where('a.pay_type',$paytype); }
			
			if($religion=='All' || $religion=='not_included'){} else { $this->db->where('a.religion',$religion); }

			$this->db->where('a.company_id',$company);
			
			$query = $this->db->get('employee_info a');
			$result =  $query->result();
			return $result;
	}

	public function all_result_count($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$taxcode,$status,$gender,$civil_status,$position,$paytype,$religion,$age_from,$age_to,$dateemp_from,$dateemp_to,$yremp_from,$yremp_to,$viewing_option,$viewing_type,$viewing_data)
	{
		$result ='';
		if($viewing_type=='company')
		{
	 			$wheree = $this->get_condition_($company,'company_id');
	 			$companylist = $this->e1_companyList('Multiple',$wheree);
				foreach($companylist as $c)
				{
					$count = $this->all_result($code,$c->company_id,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$taxcode,$status,$gender,$civil_status,$position,$paytype,$religion,$age_from,$age_to,$dateemp_from,$dateemp_to,$yremp_from,$yremp_to);
					$c->count = $count;

				}

				$result = $companylist;
		}
		else if($viewing_type=='division')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'division_id');
	 			$divlist = $this->E2_multipledivision('Multiple',$company,$wheree);
				foreach($divlist as $c)
				{
					$count = $this->all_result($code,$company,$c,$c->division_id,$department,$section,$subsection,$location,$classification,$employment,$taxcode,$status,$gender,$civil_status,$position,$paytype,$religion,$age_from,$age_to,$dateemp_from,$dateemp_to,$yremp_from,$yremp_to);
					$c->count = $count;

				}

				$result = $divlist;
		}

		else if($viewing_type=='department')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'department_id');
	 			$deptlist = $this->E2_multipledepartment('Multiple',$division,$company,$wheree);
				foreach($deptlist as $c)
				{
					$count = $this->all_result($code,$company,$c,$division,$c->department_id,$section,$subsection,$location,$classification,$employment,$taxcode,$status,$gender,$civil_status,$position,$paytype,$religion,$age_from,$age_to,$dateemp_from,$dateemp_to,$yremp_from,$yremp_to);
					$c->count = $count;

				}

				$result = $deptlist;
		}
		else if($viewing_type=='section')
		{		
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.section_id');

	 			$sectionlist = $this->E4_multiplesection($company,$division,$department,'Multiple',$wheree);
				foreach($sectionlist as $c)
				{
					$count = $this->all_result($code,$company,$c,$division,$department,$c->section_id,$subsection,$location,$classification,$employment,$taxcode,$status,$gender,$civil_status,$position,$paytype,$religion,$age_from,$age_to,$dateemp_from,$dateemp_to,$yremp_from,$yremp_to);
					$c->count = $count;

				}

				$result = $sectionlist;
				
		}

		else if($viewing_type=='subsection')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.subsection_id');
	 			$subsectionlist = $this->E5_multiplesubsection($company,$division,$department,$section,'Multiple',$wheree);
				foreach($subsectionlist as $c)
				{
					$count = $this->all_result($code,$company,$c,$division,$department,$section,$c->subsection_id,$location,$classification,$employment,$taxcode,$status,$gender,$civil_status,$position,$paytype,$religion,$age_from,$age_to,$dateemp_from,$dateemp_to,$yremp_from,$yremp_to);
					$c->count = $count;

				}

				$result = $subsectionlist;
		}
		else if($viewing_type=='location')
		{
			
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.location_id');
	 			$locationlist = $this->E6_multiplelocation($company,'Multiple',$wheree);

				foreach($locationlist as $c)
				{

					$count = $this->all_result($code,$company,$c,$division,$department,$section,$subsection,$c->location_id,$classification,$employment,$taxcode,$status,$gender,$civil_status,$position,$paytype,$religion,$age_from,$age_to,$dateemp_from,$dateemp_to,$yremp_from,$yremp_to);
					$c->count = $count;

				}

				$result = $locationlist;
		}
		else if($viewing_type=='classification')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'classification_id');

	 			$classificationlist = $this->E7_multipleclassification($company,'Multiple',$wheree);
	 					
	 			foreach($classificationlist as $c)
				{
					$count = $this->all_result($code,$company,$c,$division,$department,$section,$subsection,$location,$c->classification_id,$employment,$taxcode,$status,$gender,$civil_status,$position,$paytype,$religion,$age_from,$age_to,$dateemp_from,$dateemp_to,$yremp_from,$yremp_to);
					$c->count = $count;

				}

				$result = $classificationlist;
		}
		else if($viewing_type=='employment')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'employment_id');

	 			$employmentlist = $this->E8_multipleemployment($company,'Multiple',$wheree);
	 					
	 			foreach($employmentlist as $c)
				{
					$count = $this->all_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$c->employment_id,$taxcode,$status,$gender,$civil_status,$position,$paytype,$religion,$age_from,$age_to,$dateemp_from,$dateemp_to,$yremp_from,$yremp_to);
					$c->count = $count;

				}

				$result = $employmentlist;
		}

		else if($viewing_type=='taxcode')
		{		
				$cc = substr_replace($viewing_data, "", -1);
				$wheree = $this->get_condition_($cc,'taxcode_id');
				$otherlistt = $this->other_option_multiple('Multiple',$wheree,'taxcode','taxcode_id');
				foreach($otherlistt as $c)
					{
						$count = $this->all_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$c->taxcode_id,$status,$gender,$civil_status,$position,$paytype,$religion,$age_from,$age_to,$dateemp_from,$dateemp_to,$yremp_from,$yremp_to);
						$c->count = $count;

					}
				$result = $otherlistt;
		}
		else if($viewing_type=='civil_status')
		{
				$cc = substr_replace($viewing_data, "", -1);
				$wheree = $this->get_condition_($cc,'civil_status_id');
				$otherlistt = $this->other_option_multiple('Multiple',$wheree,'civil_status','civil_status_id');
				foreach($otherlistt as $c)
					{
						$count = $this->all_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$taxcode,$status,$gender,$c->civil_status_id,$position,$paytype,$religion,$age_from,$age_to,$dateemp_from,$dateemp_to,$yremp_from,$yremp_to);
						$c->count = $count;

					}
				$result = $otherlistt;
		}
		else if($viewing_type=='gender')
		{
				$cc = substr_replace($viewing_data, "", -1);
				$wheree = $this->get_condition_($cc,'gender_id');
				$otherlistt = $this->other_option_multiple('Multiple',$wheree,'gender','gender_id');
				foreach($otherlistt as $c)
				{
					$count = $this->all_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$taxcode,$status,$c->gender_id,$civil_status,$position,$paytype,$religion,$age_from,$age_to,$dateemp_from,$dateemp_to,$yremp_from,$yremp_to);
						$c->count = $count;

				}

				$result = $otherlistt;
		}	
		else if($viewing_type=='position')
		{
				$cc = substr_replace($viewing_data, "", -1);
				$wheree = $this->get_condition_($cc,'position_id');
				$otherlistt = $this->other_option_multiple('Multiple',$wheree,'position','position_id');
				foreach($otherlistt as $c)
				{
					$count = $this->all_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$taxcode,$status,$gender,$civil_status,$c->position_id,$paytype,$religion,$age_from,$age_to,$dateemp_from,$dateemp_to,$yremp_from,$yremp_to);
					$c->count = $count;

				}
				$result = $otherlistt;
		}
		else if($viewing_type=='paytype')
		{
				$cc = substr_replace($viewing_data, "", -1);
				$wheree = $this->get_condition_($cc,'pay_type_id');
				$otherlistt = $this->other_option_multiple('Multiple',$wheree,'pay_type','pay_type_id');
				foreach($otherlistt as $c)
				{
					$count = $this->all_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$taxcode,$status,$gender,$civil_status,$position,$c->pay_type_id,$religion,$age_from,$age_to,$dateemp_from,$dateemp_to,$yremp_from,$yremp_to);
					$c->count = $count;

			    }
			    $result = $otherlistt;
		}
		else if($viewing_type=='religion')
		{
				$cc = substr_replace($viewing_data, "", -1);
				$wheree = $this->get_condition_($cc,'param_id');
				$otherlistt = $this->other_option_multiplereligion('Multiple',$wheree);
				foreach($otherlistt as $c)
				{
					$count = $this->all_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$taxcode,$status,$gender,$civil_status,$position,$paytype,$c->param_id,$age_from,$age_to,$dateemp_from,$dateemp_to,$yremp_from,$yremp_to);
					$c->count = $count;

				}
				 $result = $otherlistt;
		}


		return $result;
	}



	public function get_date_of_employment($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_date_employed');
		return $query->result();
	}

	public function get_date_resigned($date_employed,$employee_id)
	{
		$this->db->where(array('date_employed'=>$date_employed,'employee_id'=>$employee_id));
		$query = $this->db->get('employee_date_resigned');
		return $query->row('date_resigned');
	}

	public function e11_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$yremp_from,$yremp_to,$viewing_option,$viewing_type,$viewing_data,$yearoption)
	{
			$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*,k.*,l.*,m.classification as classification_name,a.company_id as company_id');
			$this->db->join('company_info b','b.company_id=a.company_id');	
			$this->db->join('division c','c.division_id=a.division_id','left');
			$this->db->join('department d','d.department_id=a.department');
			$this->db->join('section e','e.section_id=a.section');
			$this->db->join('subsection f','f.subsection_id=a.subsection','left');
			$this->db->join('location g','g.location_id=a.location');
			$this->db->join('employment h','h.employment_id=a.employment');
			$this->db->join('classification m','m.classification_id=a.classification','left');
			$this->db->join('taxcode i','i.taxcode_id=a.taxcode','left');
			$this->db->join('pay_type j','j.pay_type_id=a.pay_type','left');
			$this->db->join('position k','k.position_id=a.position','left');
			$this->db->join('gender l','l.gender_id=a.gender','left');
			
			if($division=='All' || $division=='not_included'){} else { $this->db->where('a.division_id',$division); }

			if($department=='All' || $department=='not_included'){} else { $this->db->where('a.department',$department); }
			if($section=='All' || $section=='not_included'){} else { $this->db->where('a.section',$section); }
			if($subsection=='All' || $subsection=='not_included'){} else { $this->db->where('a.subsection',$subsection); }
			if($employment=='All' || $employment=='not_included'){} else { $this->db->where('a.employment',$employment); }
			if($classification=='All' || $classification=='not_included'){} else { $this->db->where('a.classification',$classification); }
			if($location=='All' || $location=='not_included'){} else { $this->db->where('a.location',$location); }

			$this->db->where('a.company_id',$company);
			
			$query = $this->db->get('employee_info a');
			$result =  $query->result();
			return $result;
	}
	

	public function e11_result_count($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$yremp_from,$yremp_to,$viewing_option,$viewing_type,$viewing_data,$yearoption)
	{
		$result ='';
		if($viewing_type=='company')
		{
	 			$wheree = $this->get_condition_($company,'company_id');
	 			$companylist = $this->e1_companyList('Multiple',$wheree);
				foreach($companylist as $c)
				{
					$count = $this->e11_resultcount($code,$c->company_id,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$yremp_from,$yremp_to,$viewing_option,$viewing_type,$viewing_data,$yearoption);
					$c->count = $count;

				}

				$result = $companylist;
		}
		else if($viewing_type=='division')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'division_id');
	 			$divlist = $this->E2_multipledivision('Multiple',$company,$wheree);
				foreach($divlist as $c)
				{
					$count = $this->e11_resultcount($code,$company,$c,$c->division_id,$department,$section,$subsection,$location,$classification,$employment,$yremp_from,$yremp_to,$viewing_option,$viewing_type,$viewing_data,$yearoption);
					$c->count = $count;

				}

				$result = $divlist;
		}

		else if($viewing_type=='department')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'department_id');
	 			$deptlist = $this->E2_multipledepartment('Multiple',$division,$company,$wheree);
				foreach($deptlist as $c)
				{
					$count = $this->e11_resultcount($code,$company,$c,$division,$c->department_id,$section,$subsection,$location,$classification,$employment,$yremp_from,$yremp_to,$viewing_option,$viewing_type,$viewing_data,$yearoption);
					$c->count = $count;

				}

				$result = $deptlist;
		}
		else if($viewing_type=='section')
		{		
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.section_id');

	 			$sectionlist = $this->E4_multiplesection($company,$division,$department,'Multiple',$wheree);
				foreach($sectionlist as $c)
				{
					$count = $this->e11_resultcount($code,$company,$c,$division,$department,$c->section_id,$subsection,$location,$classification,$employment,$yremp_from,$yremp_to,$viewing_option,$viewing_type,$viewing_data,$yearoption);
					$c->count = $count;

				}

				$result = $sectionlist;
				
		}

		else if($viewing_type=='subsection')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.subsection_id');
	 			$subsectionlist = $this->E5_multiplesubsection($company,$division,$department,$section,'Multiple',$wheree);
				foreach($subsectionlist as $c)
				{
					$count = $this->e11_resultcount($code,$company,$c,$division,$department,$section,$c->subsection_id,$location,$classification,$employment,$yremp_from,$yremp_to,$viewing_option,$viewing_type,$viewing_data,$yearoption);
					$c->count = $count;

				}

				$result = $subsectionlist;
		}
		else if($viewing_type=='location')
		{
			
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.location_id');
	 			$locationlist = $this->E6_multiplelocation($company,'Multiple',$wheree);

				foreach($locationlist as $c)
				{

					$count = $this->e11_resultcount($code,$company,$c,$division,$department,$section,$subsection,$c->location_id,$classification,$employment,$yremp_from,$yremp_to,$viewing_option,$viewing_type,$viewing_data,$yearoption);
					$c->count = $count;

				}

				$result = $locationlist;
		}
		else if($viewing_type=='classification')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'classification_id');

	 			$classificationlist = $this->E7_multipleclassification($company,'Multiple',$wheree);
	 					
	 			foreach($classificationlist as $c)
				{
					$count = $this->e11_resultcount($code,$company,$c,$division,$department,$section,$subsection,$location,$c->classification_id,$employment,$yremp_from,$yremp_to,$viewing_option,$viewing_type,$viewing_data,$yearoption);
					$c->count = $count;

				}

				$result = $classificationlist;
		}
		else if($viewing_type=='employment')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'employment_id');

	 			$employmentlist = $this->E8_multipleemployment($company,'Multiple',$wheree);
	 					
	 			foreach($employmentlist as $c)
				{
					$count = $this->e11_resultcount($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$c->employment_id,$yremp_from,$yremp_to,$viewing_option,$viewing_type,$viewing_data,$yearoption);
					$c->count = $count;

				}

				$result = $employmentlist;
		}

		
		return $result;
	}



	public function e11_resultcount($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$yremp_from,$yremp_to,$viewing_option,$viewing_type,$viewing_data,$yearoption)
	{
			$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*,k.*,l.*,m.classification as classification_name,a.company_id as company_id');
			$this->db->join('company_info b','b.company_id=a.company_id');	
			$this->db->join('division c','c.division_id=a.division_id','left');
			$this->db->join('department d','d.department_id=a.department');
			$this->db->join('section e','e.section_id=a.section');
			$this->db->join('subsection f','f.subsection_id=a.subsection','left');
			$this->db->join('location g','g.location_id=a.location');
			$this->db->join('employment h','h.employment_id=a.employment');
			$this->db->join('classification m','m.classification_id=a.classification','left');
			$this->db->join('taxcode i','i.taxcode_id=a.taxcode','left');
			$this->db->join('pay_type j','j.pay_type_id=a.pay_type','left');
			$this->db->join('position k','k.position_id=a.position','left');
			$this->db->join('gender l','l.gender_id=a.gender','left');
			
			if($division=='All' || $division=='not_included'){} else { $this->db->where('a.division_id',$division); }

			if($department=='All' || $department=='not_included'){} else { $this->db->where('a.department',$department); }
			if($section=='All' || $section=='not_included'){} else { $this->db->where('a.section',$section); }
			if($subsection=='All' || $subsection=='not_included'){} else { $this->db->where('a.subsection',$subsection); }
			if($employment=='All' || $employment=='not_included'){} else { $this->db->where('a.employment',$employment); }
			if($classification=='All' || $classification=='not_included'){} else { $this->db->where('a.classification',$classification); }
			if($location=='All' || $location=='not_included'){} else { $this->db->where('a.location',$location); }

			$this->db->where('a.company_id',$company);
			
			$query = $this->db->get('employee_info a');
			$result =  $query->result();
			
			$i =  count($result);
			foreach($result as $r)
			{
				if($yearoption=='active')
                {
                	  $date1 = $r->date_employed;
		              $date2 = date('Y-m-d');
		              $ts1 = strtotime($date1);
		              $ts2 = strtotime($date2);
		              $year1 = date('Y', $ts1);
		              $year2 = date('Y', $ts2);
		              $month1 = date('m', $ts1);
		              $month2 = date('m', $ts2);
		              $months_employed = $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
		              $value1 = $months_employed /12;

                    if($yremp_from!='All')
                    {
                      if($value1 <=$yremp_to AND $value1 >= $yremp_from)
                      {
                        $res=true;
                      }
                      else
                      {
                        $res=false;
                      }
                    }
                    else{  $res=true; }
                }
                else
                {
	                  if($yremp_from!='All')
	                  {
	                    $date_employment = $this->get_date_of_employment($r->employee_id);
	                    $date_employed_count = "";
	                      foreach($date_employment as $d)
	                      {
	                          $get_date_resigned = $this->get_date_resigned($d->date_employed,$d->employee_id);
	                          $date1 = $d->date_employed;
	                          if(empty($get_date_resigned))
	                            {
	                              $date2 = date('Y-m-d');
	                            }
	                          else
	                            {
	                              $date2 = $get_date_resigned;
	                            }

	                            $ts1 = strtotime($date1);
	                            $ts2 = strtotime($date2);
	                            $year1 = date('Y', $ts1);
	                            $year2 = date('Y', $ts2);
	                            $month1 = date('m', $ts1);
	                            $month2 = date('m', $ts2);
	                            $months = $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
	                            $year = $months /12;

	                            $date_employed_count+=$months;
	                      }
	                      $year_count= $date_employed_count /12;
	                      $months_count = $date_employed_count + 0;
	                      $value = number_format($year_count,1)." Year/s<br>"."(".$months_count." Month/s)";

	                    
	                        if($value <=$yremp_to AND $value >= $yremp_from)
	                        {
	                          $res=true;
	                        }
	                        else
	                        {
	                          $res=false;
	                        }
	                   
	                  }   
	                  else { $res= true; } 
                }
				
				if($res==true)
				{
					$i = $i;
				}	
				else
				{
					$i = $i -1;
				}

			}
			return $i;
	}
	

	public function e12_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data)
	{
			$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*,k.*,l.*,m.classification as classification_name,a.company_id as company_id');
			$this->db->join('company_info b','b.company_id=a.company_id');	
			$this->db->join('division c','c.division_id=a.division_id','left');
			$this->db->join('department d','d.department_id=a.department');
			$this->db->join('section e','e.section_id=a.section');
			$this->db->join('subsection f','f.subsection_id=a.subsection','left');
			$this->db->join('location g','g.location_id=a.location');
			$this->db->join('employment h','h.employment_id=a.employment');
			$this->db->join('classification m','m.classification_id=a.classification','left');
			$this->db->join('taxcode i','i.taxcode_id=a.taxcode','left');
			$this->db->join('pay_type j','j.pay_type_id=a.pay_type','left');
			$this->db->join('position k','k.position_id=a.position','left');
			$this->db->join('gender l','l.gender_id=a.gender','left');
			
			if($division=='All' || $division=='not_included'){} else { $this->db->where('a.division_id',$division); }

			if($department=='All' || $department=='not_included'){} else { $this->db->where('a.department',$department); }
			if($section=='All' || $section=='not_included'){} else { $this->db->where('a.section',$section); }
			if($subsection=='All' || $subsection=='not_included'){} else { $this->db->where('a.subsection',$subsection); }
			if($employment=='All' || $employment=='not_included'){} else { $this->db->where('a.employment',$employment); }
			if($classification=='All' || $classification=='not_included'){} else { $this->db->where('a.classification',$classification); }
			if($location=='All' || $location=='not_included'){} else { $this->db->where('a.location',$location); }

			if($from!='All'){ $where = "date(a.date_employed) between '" .$from. "' and '" .$to. "'"; $this->db->where($where); }

			$this->db->where('a.company_id',$company);
			
			$query = $this->db->get('employee_info a');
			$result =  $query->result();
			return $result;
	}

	public function e12_result_count($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data)
	{
		$result ='';
		if($viewing_type=='company')
		{
	 			$wheree = $this->get_condition_($company,'company_id');
	 			$companylist = $this->e1_companyList('Multiple',$wheree);
				foreach($companylist as $c)
				{
					$count = $this->e12_result($code,$c->company_id,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data);
					$c->count = count($count);

				}

				$result = $companylist;
		}
		else if($viewing_type=='division')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'division_id');
	 			$divlist = $this->E2_multipledivision('Multiple',$company,$wheree);
				foreach($divlist as $c)
				{
					$count = $this->e11_resultcount($code,$company,$c,$c->division_id,$department,$section,$subsection,$location,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data);
					$c->count = count($count);

				}

				$result = $divlist;
		}

		else if($viewing_type=='department')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'department_id');
	 			$deptlist = $this->E2_multipledepartment('Multiple',$division,$company,$wheree);
				foreach($deptlist as $c)
				{
					$count = $this->e11_resultcount($code,$company,$c,$division,$c->department_id,$section,$subsection,$location,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data);
					$c->count = count($count);

				}

				$result = $deptlist;
		}
		else if($viewing_type=='section')
		{		
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.section_id');

	 			$sectionlist = $this->E4_multiplesection($company,$division,$department,'Multiple',$wheree);
				foreach($sectionlist as $c)
				{
					$count = $this->e11_resultcount($code,$company,$c,$division,$department,$c->section_id,$subsection,$location,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data,$yearoption);
					$c->count = count($count);

				}

				$result = $sectionlist;
				
		}

		else if($viewing_type=='subsection')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.subsection_id');
	 			$subsectionlist = $this->E5_multiplesubsection($company,$division,$department,$section,'Multiple',$wheree);
				foreach($subsectionlist as $c)
				{
					$count = $this->e11_resultcount($code,$company,$c,$division,$department,$section,$c->subsection_id,$location,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data,$yearoption);
					$c->count = count($count);

				}

				$result = $subsectionlist;
		}
		else if($viewing_type=='location')
		{
			
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.location_id');
	 			$locationlist = $this->E6_multiplelocation($company,'Multiple',$wheree);

				foreach($locationlist as $c)
				{

					$count = $this->e11_resultcount($code,$company,$c,$division,$department,$section,$subsection,$c->location_id,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data,$yearoption);
					$c->count = count($count);

				}

				$result = $locationlist;
		}
		else if($viewing_type=='classification')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'classification_id');

	 			$classificationlist = $this->E7_multipleclassification($company,'Multiple',$wheree);
	 					
	 			foreach($classificationlist as $c)
				{
					$count = $this->e11_resultcount($code,$company,$c,$division,$department,$section,$subsection,$location,$c->classification_id,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data,$yearoption);
					$c->count = count($count);

				}

				$result = $classificationlist;
		}
		else if($viewing_type=='employment')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'employment_id');

	 			$employmentlist = $this->E8_multipleemployment($company,'Multiple',$wheree);
	 					
	 			foreach($employmentlist as $c)
				{
					$count = $this->e12_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$c->employment_id,$from,$to,$viewing_option,$viewing_type,$viewing_data,$yearoption);
					$c->count = count($count);
				}

				$result = $employmentlist;
		}

		
		return $result;
	}


	public function e16_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data)
	{
			$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*,k.*,l.*,m.classification as classification_name,a.company_id as company_id');
			$this->db->join('company_info b','b.company_id=a.company_id');	
			$this->db->join('division c','c.division_id=a.division_id','left');
			$this->db->join('department d','d.department_id=a.department');
			$this->db->join('section e','e.section_id=a.section');
			$this->db->join('subsection f','f.subsection_id=a.subsection','left');
			$this->db->join('location g','g.location_id=a.location');
			$this->db->join('employment h','h.employment_id=a.employment');
			$this->db->join('classification m','m.classification_id=a.classification','left');
			$this->db->join('taxcode i','i.taxcode_id=a.taxcode','left');
			$this->db->join('pay_type j','j.pay_type_id=a.pay_type','left');
			$this->db->join('position k','k.position_id=a.position','left');
			$this->db->join('gender l','l.gender_id=a.gender','left');
			
			if($division=='All' || $division=='not_included'){} else { $this->db->where('a.division_id',$division); }

			if($department=='All' || $department=='not_included'){} else { $this->db->where('a.department',$department); }
			if($section=='All' || $section=='not_included'){} else { $this->db->where('a.section',$section); }
			if($subsection=='All' || $subsection=='not_included'){} else { $this->db->where('a.subsection',$subsection); }
			if($employment=='All' || $employment=='not_included'){} else { $this->db->where('a.employment',$employment); }
			if($classification=='All' || $classification=='not_included'){} else { $this->db->where('a.classification',$classification); }
			if($location=='All' || $location=='not_included'){} else { $this->db->where('a.location',$location); }
			if($from!='All'){ $where = "age between " .$from. " and " .$to. ""; $this->db->where($where); }
			$this->db->where('a.company_id',$company);
			
			$query = $this->db->get('employee_info a');
			$result =  $query->result();
			return $result;
	}

	public function e16_result_count($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data)
	{
		$result ='';
		if($viewing_type=='company')
		{
	 			$wheree = $this->get_condition_($company,'company_id');
	 			$companylist = $this->e1_companyList('Multiple',$wheree);
				foreach($companylist as $c)
				{
					$count = $this->e16_result($code,$c->company_id,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data);
					$c->count = count($count);

				}

				$result = $companylist;
		}
		else if($viewing_type=='division')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'division_id');
	 			$divlist = $this->E2_multipledivision('Multiple',$company,$wheree);
				foreach($divlist as $c)
				{
					$count = $this->e16_result($code,$company,$c,$c->division_id,$department,$section,$subsection,$location,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data);
					$c->count = count($count);

				}

				$result = $divlist;
		}

		else if($viewing_type=='department')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'department_id');
	 			$deptlist = $this->E2_multipledepartment('Multiple',$division,$company,$wheree);
				foreach($deptlist as $c)
				{
					$count = $this->e16_result($code,$company,$c,$division,$c->department_id,$section,$subsection,$location,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data);
					$c->count = count($count);

				}

				$result = $deptlist;
		}
		else if($viewing_type=='section')
		{		
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.section_id');

	 			$sectionlist = $this->E4_multiplesection($company,$division,$department,'Multiple',$wheree);
				foreach($sectionlist as $c)
				{
					$count = $this->e16_result($code,$company,$c,$division,$department,$c->section_id,$subsection,$location,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data,$yearoption);
					$c->count = count($count);

				}

				$result = $sectionlist;
				
		}

		else if($viewing_type=='subsection')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.subsection_id');
	 			$subsectionlist = $this->E5_multiplesubsection($company,$division,$department,$section,'Multiple',$wheree);
				foreach($subsectionlist as $c)
				{
					$count = $this->e11_resultcount($code,$company,$c,$division,$department,$section,$c->subsection_id,$location,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data,$yearoption);
					$c->count = count($count);

				}

				$result = $subsectionlist;
		}
		else if($viewing_type=='location')
		{
			
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.location_id');
	 			$locationlist = $this->E6_multiplelocation($company,'Multiple',$wheree);

				foreach($locationlist as $c)
				{

					$count = $this->e11_resultcount($code,$company,$c,$division,$department,$section,$subsection,$c->location_id,$classification,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data,$yearoption);
					$c->count = count($count);

				}

				$result = $locationlist;
		}
		else if($viewing_type=='classification')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'classification_id');

	 			$classificationlist = $this->E7_multipleclassification($company,'Multiple',$wheree);
	 					
	 			foreach($classificationlist as $c)
				{
					$count = $this->e11_resultcount($code,$company,$c,$division,$department,$section,$subsection,$location,$c->classification_id,$employment,$from,$to,$viewing_option,$viewing_type,$viewing_data,$yearoption);
					$c->count = count($count);

				}

				$result = $classificationlist;
		}
		else if($viewing_type=='employment')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'employment_id');

	 			$employmentlist = $this->E8_multipleemployment($company,'Multiple',$wheree);
	 					
	 			foreach($employmentlist as $c)
				{
					$count = $this->e12_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$c->employment_id,$from,$to,$viewing_option,$viewing_type,$viewing_data,$yearoption);
					$c->count = count($count);
				}

				$result = $employmentlist;
		}

		
		return $result;
	}
	

	public function e10_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$viewing_option,$viewing_type,$viewing_data)
	{
			$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*,k.*,l.*,m.classification as classification_name,a.company_id as company_id');
			$this->db->join('company_info b','b.company_id=a.company_id');	
			$this->db->join('division c','c.division_id=a.division_id','left');
			$this->db->join('department d','d.department_id=a.department');
			$this->db->join('section e','e.section_id=a.section');
			$this->db->join('subsection f','f.subsection_id=a.subsection','left');
			$this->db->join('location g','g.location_id=a.location');
			$this->db->join('employment h','h.employment_id=a.employment');
			$this->db->join('classification m','m.classification_id=a.classification','left');
			$this->db->join('taxcode i','i.taxcode_id=a.taxcode','left');
			$this->db->join('pay_type j','j.pay_type_id=a.pay_type','left');
			$this->db->join('position k','k.position_id=a.position','left');
			$this->db->join('gender l','l.gender_id=a.gender','left');
			
			if($division=='All' || $division=='not_included'){} else { $this->db->where('a.division_id',$division); }

			if($department=='All' || $department=='not_included'){} else { $this->db->where('a.department',$department); }
			if($section=='All' || $section=='not_included'){} else { $this->db->where('a.section',$section); }
			if($subsection=='All' || $subsection=='not_included'){} else { $this->db->where('a.subsection',$subsection); }
			if($employment=='All' || $employment=='not_included'){} else { $this->db->where('a.employment',$employment); }
			if($classification=='All' || $classification=='not_included'){} else { $this->db->where('a.classification',$classification); }
			if($location=='All' || $location=='not_included'){} else { $this->db->where('a.location',$location); }
			if($status=='All' || $status=='not_included'){} else { $this->db->where('a.InActive',$status); }

			$this->db->where('a.company_id',$company);
			
			$query = $this->db->get('employee_info a');
			$result =  $query->result();
			return $result;
	}

	public function e10_result_count($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$viewing_option,$viewing_type,$viewing_data)
	{
		$result ='';
		if($viewing_type=='company')
		{
	 			$wheree = $this->get_condition_($company,'company_id');
	 			$companylist = $this->e1_companyList('Multiple',$wheree);
				foreach($companylist as $c)
				{
					$count = $this->e10_result($code,$c->company_id,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$viewing_option,$viewing_type,$viewing_data);
					$c->count = count($count);

				}

				$result = $companylist;
		}
		else if($viewing_type=='division')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'division_id');
	 			$divlist = $this->E2_multipledivision('Multiple',$company,$wheree);
				foreach($divlist as $c)
				{
					$count = $this->e10_result($code,$company,$c,$c->division_id,$department,$section,$subsection,$location,$classification,$employment,$status,$viewing_option,$viewing_type,$viewing_data);
					$c->count = count($count);

				}

				$result = $divlist;
		}

		else if($viewing_type=='department')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'department_id');
	 			$deptlist = $this->E2_multipledepartment('Multiple',$division,$company,$wheree);
				foreach($deptlist as $c)
				{
					$count = $this->e10_result($code,$company,$c,$division,$c->department_id,$section,$subsection,$location,$classification,$employment,$status,$viewing_option,$viewing_type,$viewing_data);
					$c->count = count($count);

				}

				$result = $deptlist;
		}
		else if($viewing_type=='section')
		{		
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.section_id');

	 			$sectionlist = $this->E4_multiplesection($company,$division,$department,'Multiple',$wheree);
				foreach($sectionlist as $c)
				{
					$count = $this->e10_result($code,$company,$c,$division,$department,$c->section_id,$subsection,$location,$classification,$employment,$status,$viewing_option,$viewing_type,$viewing_data);
					$c->count = count($count);

				}

				$result = $sectionlist;
				
		}

		else if($viewing_type=='subsection')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.subsection_id');
	 			$subsectionlist = $this->E5_multiplesubsection($company,$division,$department,$section,'Multiple',$wheree);
				foreach($subsectionlist as $c)
				{
					$count = $this->e10_result($code,$company,$c,$division,$department,$section,$c->subsection_id,$location,$classification,$employment,$status,$viewing_option,$viewing_type,$viewing_data);
					$c->count = count($count);

				}

				$result = $subsectionlist;
		}
		else if($viewing_type=='location')
		{
			
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.location_id');
	 			$locationlist = $this->E6_multiplelocation($company,'Multiple',$wheree);

				foreach($locationlist as $c)
				{

					$count = $this->e10_result($code,$company,$c,$division,$department,$section,$subsection,$c->location_id,$classification,$employment,$status,$viewing_option,$viewing_type,$viewing_data);
					$c->count = count($count);

				}

				$result = $locationlist;
		}
		else if($viewing_type=='classification')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'classification_id');

	 			$classificationlist = $this->E7_multipleclassification($company,'Multiple',$wheree);
	 					
	 			foreach($classificationlist as $c)
				{
					$count = $this->e10_result($code,$company,$c,$division,$department,$section,$subsection,$location,$c->classification_id,$employment,$status,$viewing_option,$viewing_type,$viewing_data);
					$c->count = count($count);

				}

				$result = $classificationlist;
		}
		else if($viewing_type=='employment')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'employment_id');

	 			$employmentlist = $this->E8_multipleemployment($company,'Multiple',$wheree);
	 					
	 			foreach($employmentlist as $c)
				{
					$count = $this->e10_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$c->employment_id,$status,$viewing_option,$viewing_type,$viewing_data);
					$c->count = count($count);
				}

				$result = $employmentlist;
		}

		
		return $result;
	}
	

	public function e20_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$viewing_option,$viewing_type,$viewing_data,$month,$day)
	{
			$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*,k.*,l.*,m.classification as classification_name,a.company_id as company_id');
			$this->db->join('company_info b','b.company_id=a.company_id');	
			$this->db->join('division c','c.division_id=a.division_id','left');
			$this->db->join('department d','d.department_id=a.department');
			$this->db->join('section e','e.section_id=a.section');
			$this->db->join('subsection f','f.subsection_id=a.subsection','left');
			$this->db->join('location g','g.location_id=a.location');
			$this->db->join('employment h','h.employment_id=a.employment');
			$this->db->join('classification m','m.classification_id=a.classification','left');
			$this->db->join('taxcode i','i.taxcode_id=a.taxcode','left');
			$this->db->join('pay_type j','j.pay_type_id=a.pay_type','left');
			$this->db->join('position k','k.position_id=a.position','left');
			$this->db->join('gender l','l.gender_id=a.gender','left');
			
			if($division=='All' || $division=='not_included'){} else { $this->db->where('a.division_id',$division); }

			if($department=='All' || $department=='not_included'){} else { $this->db->where('a.department',$department); }
			if($section=='All' || $section=='not_included'){} else { $this->db->where('a.section',$section); }
			if($subsection=='All' || $subsection=='not_included'){} else { $this->db->where('a.subsection',$subsection); }
			if($employment=='All' || $employment=='not_included'){} else { $this->db->where('a.employment',$employment); }
			if($classification=='All' || $classification=='not_included'){} else { $this->db->where('a.classification',$classification); }
			if($location=='All' || $location=='not_included'){} else { $this->db->where('a.location',$location); }
			if($day!='All')
			{
				$this->db->where('DAY(a.birthday)',$day);
			}
			
		    $this->db->where('MONTH(a.birthday)',$month);

			$this->db->where('a.company_id',$company);
			
			$query = $this->db->get('employee_info a');
			$result =  $query->result();
			return $result;
	}


	public function e20_result_count($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$viewing_option,$viewing_type,$viewing_data,$month,$day)
	{
		$result ='';
		if($viewing_type=='company')
		{
	 			$wheree = $this->get_condition_($company,'company_id');
	 			$companylist = $this->e1_companyList('Multiple',$wheree);
				foreach($companylist as $c)
				{
					$count = $this->e20_result($code,$c->company_id,$c,$division,$department,$section,$subsection,$location,$classification,$employment,$viewing_option,$viewing_type,$viewing_data,$month,$day);
					$c->count = count($count);

				}

				$result = $companylist;
		}
		else if($viewing_type=='division')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'division_id');
	 			$divlist = $this->E2_multipledivision('Multiple',$company,$wheree);
				foreach($divlist as $c)
				{
					$count = $this->e20_result($code,$company,$c,$c->division_id,$department,$section,$subsection,$location,$classification,$employment,$viewing_option,$viewing_type,$viewing_data,$month,$day);
					$c->count = count($count);

				}

				$result = $divlist;
		}

		else if($viewing_type=='department')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'department_id');
	 			$deptlist = $this->E2_multipledepartment('Multiple',$division,$company,$wheree);
				foreach($deptlist as $c)
				{
					$count = $this->e20_result($code,$company,$c,$division,$c->department_id,$section,$subsection,$location,$classification,$employment,$viewing_option,$viewing_type,$viewing_data,$month,$day);
					$c->count = count($count);

				}

				$result = $deptlist;
		}
		else if($viewing_type=='section')
		{		
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.section_id');

	 			$sectionlist = $this->E4_multiplesection($company,$division,$department,'Multiple',$wheree);
				foreach($sectionlist as $c)
				{
					$count = $this->e20_result($code,$company,$c,$division,$department,$c->section_id,$subsection,$location,$classification,$employment,$viewing_option,$viewing_type,$viewing_data,$month,$day);
					$c->count = count($count);

				}

				$result = $sectionlist;
				
		}

		else if($viewing_type=='subsection')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.subsection_id');
	 			$subsectionlist = $this->E5_multiplesubsection($company,$division,$department,$section,'Multiple',$wheree);
				foreach($subsectionlist as $c)
				{
					$count = $this->e20_result($code,$company,$c,$division,$department,$section,$c->subsection_id,$location,$classification,$employment,$viewing_option,$viewing_type,$viewing_data,$month,$day);
					$c->count = count($count);

				}

				$result = $subsectionlist;
		}
		else if($viewing_type=='location')
		{
			
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'a.location_id');
	 			$locationlist = $this->E6_multiplelocation($company,'Multiple',$wheree);

				foreach($locationlist as $c)
				{

					$count = $this->e20_result($code,$company,$c,$division,$department,$section,$subsection,$c->location_id,$classification,$employment,$viewing_option,$viewing_type,$viewing_data,$month,$day);
					$c->count = count($count);

				}

				$result = $locationlist;
		}
		else if($viewing_type=='classification')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'classification_id');

	 			$classificationlist = $this->E7_multipleclassification($company,'Multiple',$wheree);
	 					
	 			foreach($classificationlist as $c)
				{
					$count = $this->e20_result($code,$company,$c,$division,$department,$section,$subsection,$location,$c->classification_id,$employment,$viewing_option,$viewing_type,$viewing_data,$month,$day);
					$c->count = count($count);

				}

				$result = $classificationlist;
		}
		else if($viewing_type=='employment')
		{
				$cc = substr_replace($viewing_data, "", -1);
	 			$wheree = $this->get_condition_($cc,'employment_id');

	 			$employmentlist = $this->E8_multipleemployment($company,'Multiple',$wheree);
	 					
	 			foreach($employmentlist as $c)
				{
					$count = $this->e20_result($code,$company,$c,$division,$department,$section,$subsection,$location,$classification,$c->employment_id,$viewing_option,$viewing_type,$viewing_data,$month,$day);
					$c->count = count($count);
				}

				$result = $employmentlist;
		}

		
		return $result;
	}

	public function get_company_name($company)
	{
		$this->db->where('company_id',$company);
		$q = $this->db->get('company_info');
		return $q->row('company_name');
	}
	public function company_address($company)
	{
		$this->db->where('company_id',$company);
		$q = $this->db->get('company_info');
		if(!empty($q->row('company_address')))
		{
			return $q->row('company_address');
		}
		else
		{
			return "NO SETUP YET";
		}
	}





















	public function convert_char($title)
	{
		$a = str_replace("-a-","?",$title);
		$b = str_replace("-b-","!",$a);
		$c = str_replace("-c-","/",$b);
		$d = str_replace("-d-","|",$c);
		$e = str_replace("-e-","[",$d);
		$f = str_replace("-f-","]",$e);
		$g = str_replace("-g-","(",$f);
		$h = str_replace("-h-",")",$g);
		$i = str_replace("-i-","{",$h);
		$j = str_replace("-j-","}",$i);

		$k = str_replace("-k-","'",$j);
		$l = str_replace("-l-",",",$k);
		$m = str_replace("-m-","'",$l);
		$n = str_replace("-n-","_",$m);

		$o = str_replace("-o-","@",$n);
		$p = str_replace("-p-","#",$o);
		$q = str_replace("-q-","%",$p);
		$r = str_replace("-r-","$",$q);

		$s = str_replace("-s-","^",$r);
		$t = str_replace("-t-","&",$s);
		$u = str_replace("-u-","*",$t);
		$v = str_replace("-v-","+",$u);

		$w = str_replace("-w-","=",$v);
		$x = str_replace("-x-",":",$w);
		$y = str_replace("-y-",";",$x);
		$z = str_replace("-z-"," ",$y);
		
		$aa = str_replace("-zz-",".",$z);
		$bb = str_replace("-aa-","<",$aa);
		$cc = str_replace("-bb-",">",$bb);
		$dd = str_replace("%20"," ",$cc);
		return $dd;
	}
}

?>