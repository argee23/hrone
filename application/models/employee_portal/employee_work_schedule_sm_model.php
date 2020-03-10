<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_work_schedule_sm_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
		$this->load->model("app/time_work_schedule_model");
	}

	public function sectionList($company)
	{
		$employee_id = $this->session->userdata('employee_id');
		$this->db->distinct();
		$this->db->select('a.section,b.section_name');
		$this->db->join('section b','b.section_id=a.section');
		$this->db->where(array('a.company_id'=>$company,'a.manager'=>$employee_id));
		$query =  $this->db->get('section_manager a');
		return $query->result();
	}

	public function load_subsection($section)
	{
		$employee_id = $this->session->userdata('employee_id');
		$this->db->distinct();
		$this->db->select('a.subsection,b.subsection_name');
		$this->db->join('subsection b','b.subsection_id=a.subsection');
		$this->db->where(array('a.manager'=>$employee_id));
		if($section=='all'){} else{ $this->db->where('section',$section); }
		$query =  $this->db->get('section_manager a');
		return $query->result();

	}

	public function get_filtered_result($company,$section,$subsection,$location,$classification)
	{
		if($location=='all')
		{
			$loc = $this->time_work_schedule_model->load_locations($company);
			$string_l="";
			foreach($loc as $a)
            { 	 
            	
            	$dd = $a->location_id."-";
               	$string_l .= $dd;
            }
          	$location_where = $this->get_condition_($string_l,'a.location');
		}
		if($classification=='all')
		{
			$classs  = $this->time_work_schedule_model->classificationList($company);
			$string_c="";
			foreach($classs as $c)
            { 	 
            	
            	$cc = $c->classification_id."-";
               	$string_c .= $cc;
            }
          	$classification_where = $this->get_condition_($string_c,'a.classification');
		}
		
		if($section=='all')
		{
			$sectionn = $this->employee_work_schedule_sm_model->sectionList($company);
			$string_s="";
			foreach($sectionn as $s)
            { 	 
            	
            	$ss = $s->section."-";
               	$string_s .= $ss;
            }
          	$section_where = $this->get_condition_($string_s,'a.section');
		}

		
		$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*');
		$this->db->join('company_info b','b.company_id=a.company_id');
		$this->db->join('location c','c.location_id=a.location');
		$this->db->join('classification d','d.classification_id=a.classification');
		$this->db->join('section e','e.section_id=a.section');
		$this->db->join('subsection f','f.subsection_id=a.subsection','left');
		$this->db->where('a.company_id',$company);
		if($location=='not_included'){}
		else if($location=='all')
		{ $this->db->where($location_where);  }
		else{ $this->db->where('a.location',$location); }

		if($classification=='not_included'){}
		else if($classification=='all')
		{ $this->db->where($classification_where);  }
		else{ $this->db->where('a.classification',$classification); }

		if($section=='not_included'){}
		else if($section=='all')
		{ $this->db->where($section_where); }
		else{ $this->db->where('a.section',$section); }

		if($subsection=='not_included' || $subsection=='all'){}
		else{ $this->db->where('a.subsection',$subsection); }

		$q = $this->db->get('employee_info a');
		return $q->result();
	}
	public function get_condition_($option,$val)
	{
		$locc 	= substr_replace($option, "", -1);
		$location =  explode('-', $locc);
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

}	
