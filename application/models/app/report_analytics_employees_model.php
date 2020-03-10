<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Report_analytics_employees_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
		$this->load->model("general_model");
	}
	
	public function get_analytics()
	{
		$this->db->where('InActive',0);
		$query = $this->db->get('employee_analytics');
		return $query->result();
	}

	public function get_code_details($code)
	{
		$this->db->where('code',$code);
		$query = $this->db->get('employee_analytics');
		return $query->row('title');
	}

	public function company_count($company_id)
	{
		$this->db->join('company_info b','b.company_id=a.company_id');
		$this->db->where('a.company_id',$company_id);
		$query = $this->db->get('employee_info a');
		return $query->num_rows();
	}

	public function companyList_multiple($cc)
	{
		$where = $this->get_condition_($cc,'company_id');
		$this->db->where($where);
		$query = $this->db->get('company_info');
		return $query->result();
	}

	public function multiple($cc,$row,$table)
	{
		$where = $this->get_condition_($cc,$row);
		$this->db->where($where);
		$query = $this->db->get($table);
		return $query->result();
	}


	public function get_condition_($option,$val)
	{
		
		$location =  explode('-', $option);
		$string_l="";
		foreach($location as $a)
            { 	 
            	$dd = $val.'="'.$a.'" or ';
                $string_l .= $dd;
            }
        $res_l = substr($string_l, 0, -4);
        $where_l = "(".$res_l.")";
        return $where_l;

	}


	public function get_department_list($company,$division)
	{
		$this->db->where('company_id',$company);
		if($division!='All'){ $this->db->where('division_id',$division); }
		$query = $this->db->get('department');
		return $query->result();
	}

	public function get_section_list($department)
	{
		$this->db->where('a.department_id',$department);
		$query = $this->db->get('section a');
		return $query->result();
	}

	public function checker_with_subsection($section)
	{
		$this->db->where('section_id',$section);
		$query = $this->db->get('section');
		return $query->row('wSubsection');
	}

	public function get_subsection_list($section)
	{
		$this->db->where('a.section_id',$section);
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






















	public function companyList($code)
	{
		$companyy = $this->input->post('company'.$code);
		 if($companyy=='All')
		 {
		 		$company = $this->general_model->companyList();

				foreach($company as $c)
				{
				 	$count = $this->company_count($c->company_id);
				 	$c->employee_count = $count + 0;

				}
		 }
		 else if($companyy=='Multiple')
		 {
		 	
		 	 	$company_ = $this->input->post('final_result');
		 	 	$cc = substr_replace($company_, "", -1);

		 		$company = $this->companyList_multiple($cc);	
				foreach($company as $c)
				{
					$count = $this->company_count($c->company_id);
				 	$c->employee_count = $count + 0;
				}
		 }
		 else
		 {	

		 		$company = $this->companyList_multiple($companyy);	
				foreach($company as $c)
				{
					$count = $this->company_count($c->company_id);
				 	$c->employee_count = $count + 0;
				}
		 }
		 
		 return $company;
		

	}

	
	public function divisionList($code)
	{
		 $division = $this->input->post('division'.$code);
		 $company = $this->input->post('company'.$code);

		 if($division!='Multiple')
		 {
		 		$division = $this->get_division_list_e2($company,$division);

				foreach($division as $c)
				{
				 	$count = $this->division_count($c->division_id);
				 	$c->employee_count = $count + 0;

				}
		 }
		 else 
		 {
		 	
		 	 	$division_ = $this->input->post('final_result');
		 	 	$cc = substr_replace($division_, "", -1);

		 		$division = $this->multiple($cc,'division_id','division');	
		 		

				foreach($division as $c)
				{
					$count = $this->division_count($c->division_id);
				 	$c->employee_count = $count + 0;
				}
		 }
		
		 
		 return $division;
		
	}

	public function departmentList($code)
	{
		 $department = $this->input->post('department'.$code);
		 $division = $this->input->post('division'.$code);
		 $company = $this->input->post('company'.$code);

		 if($department!='Multiple')
		 {
		 		$department = $this->get_department_list_e2($company,$division,$department);
				foreach($department as $c)
				{
				 	$count = $this->department_count($c->department_id);
				 	$c->employee_count = $count + 0;
				}
		 }
		 else
		 {
		 	
		 	 	$department_ = $this->input->post('final_result');
		 	 	$cc = substr_replace($department_, "", -1);

		 		$department = $this->multiple($cc,'department_id','department');	
		 		

				foreach($department as $c)
				{
					$count = $this->department_count($c->department_id);
				 	$c->employee_count = $count + 0;
				}
		 }
		
		 
		 return $department;
	}


	public function sectionList($code)
	{
		 $section = $this->input->post('section'.$code);
		 $department = $this->input->post('department'.$code);
		 $division = $this->input->post('division'.$code);
		 $company = $this->input->post('company'.$code);

		 if($section!='Multiple')
		 {
		 		$section = $this->get_section_list_e2($department,$section);
				foreach($section as $c)
				{
				 	$count = $this->section_count($c->section_id);
				 	$c->employee_count = $count + 0;
				}
		 }
		 else
		 {
		 	
		 	 	$section_ = $this->input->post('final_result');
		 	 	$cc = substr_replace($section_, "", -1);

		 		$section = $this->multiple($cc,'section_id','section');	
		 		

				foreach($section as $c)
				{
					$count = $this->section_count($c->section_id);
				 	$c->employee_count = $count + 0;
				}
		 }
		 
		 
		 return $section;
	}

	public function subsectionList($code)
	{
		 $section = $this->input->post('section'.$code);
		 $subsection = $this->input->post('subsection'.$code);

		 if($subsection!='Multiple')
		 {
		 		$subsection = $this->get_subsection_list_e2($section,$subsection);
				foreach($subsection as $c)
				{
				 	$count = $this->subsection_count($c->subsection_id);
				 	$c->employee_count = $count + 0;
				}
		 }
		 else
		 {
		 	 	$subsection_ = $this->input->post('final_result');
		 	 	$cc = substr_replace($subsection_, "", -1);
		 		$subsection = $this->multiple($cc,'subsection_id','subsection');	
		 		
				foreach($subsection as $c)
				{
					$count = $this->subsection_count($c->subsection_id);
				 	$c->employee_count = $count + 0;
				}
		 }
		
		 
		 return $subsection;
	}


	public function locationList($code)
	{
		 $location = $this->input->post('location'.$code);
		 $company = $this->input->post('company'.$code);
		 $division = $this->input->post('division'.$code);
		 $department = $this->input->post('department'.$code);
		 $section = $this->input->post('section'.$code);
		 $subsection = $this->input->post('subsection'.$code);


		 if($location!='Multiple')
		 {
		 		$location = $this->get_location_list_e2($company,'All');
				foreach($location as $c)
				{
				 	$count = $this->location_count($c->location_id,$company,$division,$department,$section,$subsection);
				 	$c->employee_count = $count + 0;
				}
		 }
		 else
		 {
		 	
		 	 	$location_ = $this->input->post('final_result');
		 	 	$cc = substr_replace($location_, "", -1);
		 		$location = $this->multiple($cc,'location_id','location');	
		 		
				foreach($location as $c)
				{
					$count = $this->location_count($c->location_id,$company,$division,$department,$section,$subsection);
				 	$c->employee_count = $count + 0;
				}
		 }
		
		 
		 return $location;	
	}

	public function classificationList($code)
	{
		 $classification = $this->input->post('classification'.$code);

		 $company = $this->input->post('company'.$code);
		 $division = $this->input->post('division'.$code);
		 $department = $this->input->post('department'.$code);
		 $section = $this->input->post('section'.$code);
		 $subsection = $this->input->post('subsection'.$code);
		 $location = $this->input->post('location'.$code);


		 if($classification!='Multiple')
		 {
		 		$classification = $this->get_classification_list_e2($company,$classification);
				foreach($classification as $c)
				{
				 	$count = $this->classification_count($c->classification_id,$company,$division,$department,$section,$subsection,$location);
				 	$c->employee_count = $count + 0;
				}
		 }
		 else
		 {
		 	
		 	 	$classification_ = $this->input->post('final_result');
		 	 	$cc = substr_replace($classification_, "", -1);
		 		$classification = $this->multiple($cc,'classification_id','classification');	
		 		
				foreach($classification as $c)
				{
					$count = $this->classification_count($c->classification_id,$company,$division,$department,$section,$subsection,$location);
				 	$c->employee_count = $count + 0;
				}
		 }
		 
		 return $classification;	
	}


	public function employmentList($code)
	{
		 $employment = $this->input->post('employment'.$code);

		 $company = $this->input->post('company'.$code);
		 $division = $this->input->post('division'.$code);
		 $department = $this->input->post('department'.$code);
		 $section = $this->input->post('section'.$code);
		 $subsection = $this->input->post('subsection'.$code);
		 $location = $this->input->post('location'.$code);
		 $classification = $this->input->post('classification'.$code);


		 if($employment!='Multiple')
		 {
		 		$employment = $this->get_employment_list_e2($company,$employment);
				foreach($employment as $c)
				{
				 	$count = $this->employment_count($c->employment_id,$company,$division,$department,$section,$subsection,$location,$classification);
				 	$c->employee_count = $count + 0;
				}
		 }
		 else 
		 {
		 	
		 	 	$employment_ = $this->input->post('final_result');
		 	 	$cc = substr_replace($employment_, "", -1);
		 		$employment = $this->multiple($cc,'employment_id','employment');	
		 		
				foreach($employment as $c)
				{
					$count = $this->employment_count($c->employment_id,$company,$division,$department,$section,$subsection,$location,$classification);
				 	$c->employee_count = $count + 0;
				}
		 }
		
		 
		 return $employment;
	}


	public function taxcodeList($code)
	{
		 $taxcode = $this->input->post('taxcode'.$code);
		 $company = $this->input->post('company'.$code);

		 $division = $this->input->post('division'.$code);
		 $department = $this->input->post('department'.$code);
		 $section = $this->input->post('section'.$code);
		 $subsection = $this->input->post('subsection'.$code);
		 $location = $this->input->post('location'.$code);
		 $classification = $this->input->post('classification'.$code);
		 $employment = $this->input->post('employment'.$code);

		 if($taxcode!='Multiple')
		 {
		 		$taxcode = $this->get_taxcode_list_e2($company,$taxcode);
				foreach($taxcode as $c)
				{
				 	$count = $this->other_count($c->taxcode_id,$company,$division,$department,$section,$subsection,$location,$classification,$employment,'taxcode');
				 	$c->employee_count = $count + 0;
				}
		 }
		 else
		 {
		 	
		 	 	$taxcode_ = $this->input->post('final_result');
		 	 	$cc = substr_replace($taxcode_, "", -1);
		 		$taxcode = $this->multiple($cc,'taxcode_id','taxcode');	
		 		
				foreach($taxcode as $c)
				{
					$count = $this->other_count($c->taxcode_id,$company,$division,$department,$section,$subsection,$location,$classification,$employment,'taxcode');
				 	$c->employee_count = $count + 0;
				}
		 }
		 
		 return $taxcode;
	}

	public function civilstatusList($code)
	{
		 $civilstatus = $this->input->post('civilstatus'.$code);
		 
		 $company = $this->input->post('company'.$code);
		 $division = $this->input->post('division'.$code);
		 $department = $this->input->post('department'.$code);
		 $section = $this->input->post('section'.$code);
		 $subsection = $this->input->post('subsection'.$code);
		 $location = $this->input->post('location'.$code);
		 $classification = $this->input->post('classification'.$code);
		 $employment = $this->input->post('employment'.$code);

		 if($civilstatus!='Multiple')
		 {
		 		$civilstatus = $this->get_civilstatus_list_e2($company,$civilstatus);
				foreach($civilstatus as $c)
				{
				 	$count = $this->other_count($c->civil_status_id,$company,$division,$department,$section,$subsection,$location,$classification,$employment,'civil_status');
				 	$c->employee_count = $count + 0;
				}
		 }
		 else
		 {
		 	
		 	 	$civilstatus_ = $this->input->post('final_result');
		 	 	$cc = substr_replace($civilstatus_, "", -1);
		 		$civilstatus = $this->multiple($cc,'civil_status_id','civil_status');	
		 		
				foreach($civilstatus as $c)
				{
					$count = $this->other_count($c->civil_status_id,$company,$division,$department,$section,$subsection,$location,$classification,$employment,'civil_status');
				 	$c->employee_count = $count + 0;
				}
		 }
		 
		 return $civilstatus;
	}

	public function genderList($code)
	{
		 $gender = $this->input->post('gender'.$code);
		 
		 $company = $this->input->post('company'.$code);
		 $division = $this->input->post('division'.$code);
		 $department = $this->input->post('department'.$code);
		 $section = $this->input->post('section'.$code);
		 $subsection = $this->input->post('subsection'.$code);
		 $location = $this->input->post('location'.$code);
		 $classification = $this->input->post('classification'.$code);
		 $employment = $this->input->post('employment'.$code);

		 if($gender!='Multiple')
		 {
		 		$gender = $this->get_gender_list_e2($company,$gender);
				foreach($gender as $c)
				{
				 	$count = $this->other_count($c->gender_id,$company,$division,$department,$section,$subsection,$location,$classification,$employment,'gender');
				 	$c->employee_count = $count + 0;
				}
		 }
		 else
		 {
		 	
		 	 	$gender_ = $this->input->post('final_result');
		 	 	$cc = substr_replace($gender_, "", -1);
		 		$gender = $this->multiple($cc,'gender_id','gender');	
		 		
				foreach($gender as $c)
				{
					$count = $this->other_count($c->gender_id,$company,$division,$department,$section,$subsection,$location,$classification,$employment,'gender');
				 	$c->employee_count = $count + 0;
				}
		 }
		 
		 return $gender;
	}

	 public function positionList($code)
	 {
	 	$position = $this->input->post('position'.$code);
		 
		 $company = $this->input->post('company'.$code);
		 $division = $this->input->post('division'.$code);
		 $department = $this->input->post('department'.$code);
		 $section = $this->input->post('section'.$code);
		 $subsection = $this->input->post('subsection'.$code);
		 $location = $this->input->post('location'.$code);
		 $classification = $this->input->post('classification'.$code);
		 $employment = $this->input->post('employment'.$code);

		 if($position!='Multiple')
		 {
		 		$position = $this->get_position_list_e2($company,$position);
				foreach($position as $c)
				{
				 	$count = $this->other_count($c->position_id,$company,$division,$department,$section,$subsection,$location,$classification,$employment,'position');
				 	$c->employee_count = $count + 0;
				}
		 }
		 else
		 {
		 	
		 	 	$position_ = $this->input->post('final_result');
		 	 	$cc = substr_replace($position_, "", -1);
		 		$position = $this->multiple($cc,'position_id','position');	
		 		
				foreach($position as $c)
				{
					$count = $this->other_count($c->position_id,$company,$division,$department,$section,$subsection,$location,$classification,$employment,'position');
				 	$c->employee_count = $count + 0;
				}
		 }
		 
		 return $position;
	 }

	 public function paytypeList($code)
	 {
	 	 $paytype = $this->input->post('paytype'.$code);
		 
		 $company = $this->input->post('company'.$code);
		 $division = $this->input->post('division'.$code);
		 $department = $this->input->post('department'.$code);
		 $section = $this->input->post('section'.$code);
		 $subsection = $this->input->post('subsection'.$code);
		 $location = $this->input->post('location'.$code);
		 $classification = $this->input->post('classification'.$code);
		 $employment = $this->input->post('employment'.$code);

		 if($paytype!='Multiple')
		 {
		 		$paytype = $this->get_paytype_list_e2($company,$paytype);
				foreach($paytype as $c)
				{
				 	$count = $this->other_count($c->pay_type_id,$company,$division,$department,$section,$subsection,$location,$classification,$employment,'pay_type');
				 	$c->employee_count = $count + 0;
				}
		 }
		 else
		 {
		 	
		 	 	$paytype_ = $this->input->post('final_result');
		 	 	$cc = substr_replace($paytype_, "", -1);
		 		$paytype = $this->multiple($cc,'pay_type_id','pay_type');	
		 		
				foreach($paytype as $c)
				{
					$count = $this->other_count($c->pay_type_id,$company,$division,$department,$section,$subsection,$location,$classification,$employment,'pay_type');
				 	$c->employee_count = $count + 0;
				}
		 }
		 
		 return $paytype;
	 }	

	 public function religionList($code)
	 {
	 	 $religion = $this->input->post('religion'.$code);
		 
		 $company = $this->input->post('company'.$code);
		 $division = $this->input->post('division'.$code);
		 $department = $this->input->post('department'.$code);
		 $section = $this->input->post('section'.$code);
		 $subsection = $this->input->post('subsection'.$code);
		 $location = $this->input->post('location'.$code);
		 $classification = $this->input->post('classification'.$code);
		 $employment = $this->input->post('employment'.$code);

		 if($religion!='Multiple')
		 {
		 		$religion = $this->get_religion_list_e2($company,$religion);
				foreach($religion as $c)
				{
				 	$count = $this->other_count($c->param_id,$company,$division,$department,$section,$subsection,$location,$classification,$employment,'religion');
				 	$c->employee_count = $count + 0;
				}
		 }
		 else
		 {
		 	
		 	 	$religion_ = $this->input->post('final_result');
		 	 	$cc = substr_replace($religion_, "", -1);
		 		$religion = $this->multiple($cc,'param_id','system_parameters');	
		 		
				foreach($religion as $c)
				{
					$count = $this->other_count($c->param_id,$company,$division,$department,$section,$subsection,$location,$classification,$employment,'religion');
				 	$c->employee_count = $count + 0;
				}
		 }
		 
		 return $religion;
	 }







































	public function with_division($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('company_info');
		return $query->row('wDivision');
	}
	public function get_division_list_e2($company,$division)
	{
		if($division!='All'){ $this->db->where('division_id',$division); }
		$this->db->where(array('company_id'=>$company,'InActive'=>0));
		$query = $this->db->get('division');
		return $query->result();
	}
	public function get_division_list($company)
	{
		$this->db->where(array('company_id'=>$company,'InActive'=>0));
		$query = $this->db->get('division');
		return $query->result();
	}

	public function division_count($division_id)
	{
		$this->db->join('division b','b.division_id=a.division_id');
		$this->db->where('a.division_id',$division_id);
		$query = $this->db->get('employee_info a');
		return $query->num_rows();
	}

	public function get_department_list_e2($company,$division,$department)
	{
		if($department=='All')
		{ 
			if($division=='not_included'){ $this->db->where('company_id',$company); }
			else{ $this->db->where('division_id',$division); }
		}
		else
		{
			$this->db->where('department_id',$department);
		}
		$query = $this->db->get('department');
		return $query->result();
	}

	public function department_count($department_id)
	{
		$this->db->join('department b','b.department_id=a.department');
		$this->db->where('a.department',$department_id);
		$query = $this->db->get('employee_info a');
		return $query->num_rows();
	}

	public function get_section_list_e2($department,$section)
	{
		if($section=='All'){ $this->db->where('department_id',$department); } 
		else
		{
			$this->db->where('section_id',$section);
		}
		$query = $this->db->get('section');
		return $query->result();
	}

	public function section_count($section_id)
	{
		
		$this->db->where('section',$section_id);
		$query = $this->db->get('employee_info');
		return $query->num_rows();
	}

	public function get_subsection_list_e2($section,$subsection)
	{
		if($subsection=='All'){ $this->db->where('section_id',$section); } else{ $this->db->where('subsection_id',$subsection); }
		$query = $this->db->get('subsection');
		return $query->result();
	}

	public function subsection_count($subsection)
	{
		$this->db->where('subsection',$subsection);
		$query = $this->db->get('employee_info');
		return $query->num_rows();
	}

	public function get_location_list_e2($company,$location)
	{	
		if($location!='All'){ $this->db->where('a.location_id',$location); }
		$this->db->where('b.company_id',$company);
		$this->db->join('company_location b','b.location_id=a.location_id');
		$query = $this->db->get('location a');
		return $query->result();
	}

	public function location_count($location_id,$company_id,$division,$department,$section,$subsection)
	{

		if($division=='not_included' || $division=='All') {} else { $this->db->where('division_id',$division); } 
		if($department=='not_included' || $department=='All'){} else { $this->db->where('department',$department); }
		if($section=='not_included' || $section=='All'){} else { $this->db->where('section',$section); }
		if($subsection=='not_included' || $subsection=='All'){} else { $this->db->where('subsection',$subsection); }

		$this->db->where(array('location'=>$location_id,'company_id'=>$company_id));
		$query = $this->db->get('employee_info');
		return $query->num_rows();
	}

	public function get_classification_list_e2($company,$classification)
	{
		
		$this->db->where('company_id',$company);
		if($classification!='All'){ $this->db->where('classification_id',$classification); }
		$query = $this->db->get('classification');
		return $query->result();
	}

	public function classification_count($classification_id,$company,$division,$department,$section,$subsection,$location)
	{
		if($division=='not_included' || $division=='All') {} else { $this->db->where('division_id',$division); } 
		if($department=='not_included' || $department=='All'){} else { $this->db->where('department',$department); }
		if($section=='not_included' || $section=='All'){} else { $this->db->where('section',$section); }
		if($subsection=='not_included' || $subsection=='All'){} else { $this->db->where('subsection',$subsection); }
		if($location!='All') { $this->db->where('location',$location); }
		$this->db->where('classification',$classification_id);
		$query = $this->db->get('employee_info');
		return $query->num_rows();
	}

	public function get_employment_list_e2($company,$employment)
	{
		if($employment!='All'){ $this->db->where('employment_id',$employment); }
		$query = $this->db->get('employment');
		return $query->result();
	}

	public function employment_count($employment_id,$company,$division,$department,$section,$subsection,$location,$classification)
	{
		if($division=='not_included' || $division=='All') {} else { $this->db->where('division_id',$division); } 
		if($department=='not_included' || $department=='All'){} else { $this->db->where('department',$department); }
		if($section=='not_included' || $section=='All'){} else { $this->db->where('section',$section); }
		if($subsection=='not_included' || $subsection=='All'){} else { $this->db->where('subsection',$subsection); }
		if($classification=='not_included' || $classification=='All'){} else{ $this->db->where('classification',$classification); }

		$this->db->where(array('employment'=>$employment_id,'company_id'=>$company));
		$query = $this->db->get('employee_info');
		return $query->num_rows();
	}


	public function get_taxcode_list_e2($company,$taxcode)
	{
		if($taxcode!='All'){ $this->db->where('taxcode_id',$taxcode); }
		$query = $this->db->get('taxcode');
		return $query->result();
	}


	public function get_civilstatus_list_e2($company,$civil_status)
	{
		if($civil_status!='All'){ $this->db->where('civil_status_id',$civil_status); }
		$query = $this->db->get('civil_status');
		return $query->result();
	}	

	public function other_count($other,$company,$division,$department,$section,$subsection,$location,$classification,$employment,$other_field)
	{
		if($division=='not_included' || $division=='All') {} else { $this->db->where('division_id',$division); } 
		if($department=='not_included' || $department=='All'){} else { $this->db->where('department',$department); }
		if($section=='not_included' || $section=='All'){} else { $this->db->where('section',$section); }
		if($subsection=='not_included' || $subsection=='All'){} else { $this->db->where('subsection',$subsection); }
		if($classification=='not_included' || $classification=='All'){} else{ $this->db->where('classification',$classification); }
		if($employment=='not_included' || $employment=='All'){} else{ $this->db->where('employment',$employment); }

		$this->db->where(array($other_field=>$other,'company_id'=>$company));
		$query = $this->db->get('employee_info');
		return $query->num_rows();
	}

	public function get_gender_list_e2($company,$gender)
	{
		if($gender!='All'){ $this->db->where('gender_id',$gender); }
		$query = $this->db->get('gender');
		return $query->result();
	}

	public function get_position_list_e2($company,$position)
	{
		if($position!='All'){ $this->db->where('position_id',$position); }
		else { $this->db->where('isEmployer',0); }
		$query = $this->db->get('position');
		return $query->result();
	}

	public function get_paytype_list_e2($company,$paytype)
	{
		if($paytype!='All'){ $this->db->where('pay_type_id',$paytype); }
		$query = $this->db->get('pay_type');
		return $query->result();
	}

	public function get_religion_list_e2($company,$religion)
	{
		if($religion=='All')
		{
			$this->db->where('cCode','religion');
		}
		else
		{
			$this->db->where('param_id',$religion);
		}
		$query = $this->db->get('system_parameters');
		return $query->result();
	}

}