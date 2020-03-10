<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Reports_personnel_approved_ot_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}

	public function get_crystal_report_list($type)
	{
		$this->db->where(array('type'=>$type,'InActive!='=>1));
		$query = $this->db->get('crystal_report_personnel_list');
		return $query->result();
	}

	public function get_crystal_report($type)
	{
		$sm= $this->session->userdata('employee_id');
		$where = "(type='".$type."' and section_manager='".$sm."')";

		$this->db->select('*');
		$this->db->where($where);
		$query = $this->db->get('crystal_report_personnel');
		return $query->result();
	}

	public function save_crystal_report()
	{
		$crystal_report_list=$this->get_crystal_report_list('approved_ot');
		$group_name = $this->input->post('report_name');
		$desc = $this->input->post('report_desc');
		$sm =$this->session->userdata('employee_id');

		$main = array(
							'type'=>'approved_ot',
							'section_manager'=>$sm,
							'report_name'=>$group_name,
							'report_desc'=>$desc,
							'InActive' =>0,
							'IsDefault' =>0,
							'date_created'=>date('Y-m-d H:i:s'));
		$insert_main = $this->db->insert('crystal_report_personnel',$main);

		if($this->db->affected_rows() > 0)
		{
			$this->db->select_max('p_id');
			$this->db->where(array('section_manager'=>$sm,'report_name'=>$group_name,'report_desc'=>$desc));
			$idd = $this->db->get('crystal_report_personnel');
			$p_id = $idd->row('p_id');

			foreach($crystal_report_list as $c)
			{
				$checker = $this->input->post('checkselected'.$c->id);
				$d = $this->input->post('checkvalue'.$c->id);
				if($checker==true)
				{
					$datas = array(
									'p_id'=>$p_id,
									'id'=>$d,
									'date_created'=>date('Y-m-d H:i:s')
								  );
					$this->db->insert('crystal_report_personnel_fields',$datas);
				}
				else
				{}
			}
		}


		
	}

	public function delete_crystal_report($id)
	{

		$this->db->where('p_id',$id);
		$this->db->delete('crystal_report_personnel');

		$this->db->where('p_id',$id);
		$this->db->delete('crystal_report_personnel_fields');
	}

	public function crystal_report_details($id)
	{
		$this->db->where('p_id',$id);
		$query = $this->db->get('crystal_report_personnel');
		return $query->result();
	}

	public function crystal_report_details_fields($p_id,$id)
	{
		$this->db->where(array('p_id'=>$p_id,'id'=>$id));
		$query = $this->db->get('crystal_report_personnel_fields');
		return $query->result();
	}

	public function saveupdate_crystal_report($id)
	{
		$group_name = $this->input->post('report_name');
		$desc = $this->input->post('report_desc');

		$main = array(
						'report_name'=>$group_name,
						'report_desc'=>$desc
					);

		$this->db->where('p_id',$id);
		$update_main = $this->db->update('crystal_report_personnel',$main);

		$this->db->where('p_id',$id);
		$this->db->delete('crystal_report_personnel_fields');

		$crystal_report_list=$this->get_crystal_report_list('approved_ot');
		foreach($crystal_report_list as $c)
			{
				$checker = $this->input->post('checkselected'.$c->id);
				$d = $this->input->post('checkvalue'.$c->id);
				if($checker==true)
				{ 
					$datas = array(
									'p_id'=>$id,
									'id'=>$d,
									'date_created'=>date('Y-m-d H:i:s')
								  );
					$this->db->insert('crystal_report_personnel_fields',$datas);
				}
				else
				{}


			}
	}

	public function crystal_report_list($type)
	{
		$this->db->where(array('type'=>$type,'section_manager'=>$this->session->userdata('employee_id')));
		$query = $this->db->get('crystal_report_personnel');
		return $query->result();
	}

	

	public function generate_report_date_range($from,$to)
	{
		$option = $this->input->post('option');

		$department = $this->section_manager_personnel('department');
		$section = $this->section_manager_personnel('section');
		$location = $this->section_manager_personnel('location');
		$subsection = $this->section_manager_personnel('subsection');

		$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.classification as classification_name,i.*');
		$this->db->join('atro_approved_members b','b.id=a.id');
		$this->db->join('employee_info c','c.employee_id=b.employee_id');
		$this->db->join('division d','d.division_id=c.division_id','left');
		$this->db->join('department e','e.department_id=c.department');
		$this->db->join('section f','f.section_id=c.section');
		$this->db->join('location g','g.location_id=c.location');
		$this->db->join('classification h','h.classification_id=c.classification');
		$this->db->join('position i','i.position_id=c.position');
		$where = "date(a.date) between '" .$from. "' and '" .$to. "'";
		$this->db->where($where);	
		$this->db->where($department);
		$this->db->where($section);
		$this->db->where($location);
		if($option=='sm_plotted'){ $this->db->where('b.plotted_by!=',$this->session->userdata('employee_id')); } else if($option=='plotted_only') { $this->db->where('b.plotted_by',$this->session->userdata('employee_id'));}
		$get = $this->db->get('atro_approved_main a');
		return $get->result();

	}

	public function generate_report_result_payroll_period($from,$to,$group)
	{
		
		$option = $this->input->post('option');
		$department = $this->section_manager_personnel('department');
		$section = $this->section_manager_personnel('section');
		$location = $this->section_manager_personnel('location');
		$subsection = $this->section_manager_personnel('subsection');

		$where = "date(a.date) between '" .$from. "' and '" .$to. "'"; 

		$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.classification as classification_name,i.*');
		$this->db->join('atro_approved_members b','b.id=a.id');
		$this->db->join('employee_info c','c.employee_id=b.employee_id');
		$this->db->join('division d','d.division_id=c.division_id','left');
		$this->db->join('department e','e.department_id=c.department');
		$this->db->join('section f','f.section_id=c.section');
		$this->db->join('location g','g.location_id=c.location');
		$this->db->join('classification h','h.classification_id=c.classification');
		$this->db->join('position i','i.position_id=c.position');
		$this->db->join('payroll_period_employees j','j.employee_id=c.employee_id');
		$this->db->where(array('j.InActive'=>0,'j.payroll_period_group_id'=>$group));
		$this->db->where($where);	
		$this->db->where($department);
		$this->db->where($section);
		$this->db->where($location);
		$this->db->where($subsection);
		if($option=='sm_plotted'){ $this->db->where('b.plotted_by!=',$this->session->userdata('employee_id')); } else if($option=='plotted_only') { $this->db->where('b.plotted_by',$this->session->userdata('employee_id'));}
		$get = $this->db->get('atro_approved_main a');
		return $get->result();
	}




	public function get_report_fields_filter($report,$type)
	{
		$this->db->select('a.*,b.*');
		$this->db->join('crystal_report_personnel_list b','b.id=a.id');
		$this->db->where(array('a.p_id'=>$report,'b.type'=>$type));
		$query = $this->db->get('crystal_report_personnel_fields a');
		return $query->result();
	}

	public function get_employee_attendance($employee_id,$date)
	{
		  $tmonth= substr($date, 5,2);

		  $this->db->where(array('employee_id'=>$employee_id,'covered_date'=>$date));
		  $query = $this->db->get('attendance_'.$tmonth);
		  return $query->result();
	}

	//check for individual schedule
	public function get_individual_schedules($employee,$date,$tmonth,$year)
	{
		    $this->db->join('employee_info b','b.employee_id=a.employee_id');
			$this->db->where(array('a.date'=>$date,'b.employee_id'=>$employee));
			$res = $this->db->get('working_schedule_'.$tmonth.' a',1);
			$result = $res->result();
			return $result;	
			
	}
	//check for fixed schedule
	public function checker_if_fixed_sched($employee,$date)
	{
		$this->db->join('fixed_working_schedule_members b','b.group_id=a.id');
		$this->db->where(array('b.InActive'=>0,'a.InActive'=>0,'b.employee_id'=>$employee));
		$query = $this->db->get('fixed_working_schedule_group a',1);
		$result = $query->result();
		return $result;

	}

	//check for group schedule
	public function checker_if_group_sched($employee,$date)
	{
		$this->db->select('a.id as id');
		$this->db->join('working_schedule_group_by_sec_manager_members b','b.group_id=a.id');
		$this->db->where(array('b.InActive'=>0,'a.InActive'=>0,'b.employee_id'=>$employee));
		$query = $this->db->get('working_schedule_group_by_sec_manager a',1);

		if(!empty($query->result()))
		{
			$this->db->where(array('group_id'=>$query->row('id'),'date'=>$date));
			$q = $this->db->get('working_schedules_by_group');
			return $q->result();
		}
		else
		{
			return null;
		}
		

	}

	public function checker_member($section,$subsection,$location,$manager)
	{
		$this->db->where(array('section'=>$section,'location'=>$location,'manager'=> $manager,'InActive'=>0));
		if($subsection=='' || $subsection==null || $subsection==0){}
		else{ $this->db->where('subsection',$subsection); }
		$query = $this->db->get('section_manager');
		return $query->num_rows();
	}

	public function company_list()
	{
		$employee_id = $this->session->userdata('employee_id');

		$this->db->select('distinct(company_id) as company');
		$this->db->where(array('manager'=>$employee_id,'InActive'=>0));
		$query = $this->db->get('section_manager');
		$result = $query->result();

		foreach($result as $r){
			$r->company_name = $this->get_company_name($r->company);
		}

		return $result;
	}

	public function get_company_name($company_id)
	{
		$this->db->where('company_id',$company_id);
		$q = $this->db->get('company_info',1);
		return $q->row('company_name');
	}

	public function get_paytype_group($paytype,$company)
	{
		$this->db->where(array('company_id'=>$company,'pay_type'=>$paytype,'InActive'=>0));
		$query = $this->db->get('payroll_period_group');
		return $query->result();
	}

	public function get_payroll_group($paytype,$company,$group)
	{
		$this->db->where('payroll_period_group_id',$group);
		$this->db->order_by('id','DESC');
		$query = $this->db->get('payroll_period');
		return $query->result();
	}

	public function payroll_period_dates($payroll_period)
	{
		$this->db->where('id',$payroll_period);
		$query =$this->db->get('payroll_period',1);
		return $query->row();
	}

	public function section_manager_personnel($option)
	{
		$employee_id = $this->session->userdata('employee_id');

		$this->db->distinct($option);
		$this->db->where(array('manager'=>$employee_id,'InActive'=>0));
		$query = $this->db->get('section_manager');
		$result = $query->result();

		$res = '';
		foreach($result as $r)
		{
			$dd = $r->$option.'-';
            $res .= $dd;
		}

		$final = substr_replace($res, "", -1);

		$get_condition = $this->get_condition_($final,'c.'.$option);
		return $get_condition;
			
		
	}


	public function get_condition_($option,$val)
	{
		
		$c =  explode('-', $option);
		$string_l="";
		foreach($c as $a)
            { 	
            	if($val=='c.subsection')
            	{
            		if($a==0 || empty($a) || $a=='not_included'|| $a==null)
            		{	
            			
            			$dd = 'c.subsection'.'=0 or '.'c.subsection'.'="not_included" or ';
	                	$string_l .= $dd; 
            		}
            		else
            		{ 
            			$dd = $val.'="'.$a.'" or ';
	                	$string_l .= $dd; 
            		}
            		
            	}
            	else{

	            	$dd = $val.'="'.$a.'" or ';
	                $string_l .= $dd;  
	            }
            }
      	$res_l = substr($string_l, 0, -4);
        $where_l = "(".$res_l.")";
        return $where_l;

	}

	public function classificationList($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('classification');
		return $query->result();
	}


	public function get_location($company)
	{
		$this->db->join('company_location b','b.location_id=a.location_id');
		$this->db->join('section_manager c','c.location=b.location_id');
		$this->db->where('c.company_id',$company);
		$this->db->where('manager',$this->session->userdata('employee_id'));
		$this->db->group_by('a.location_id');
		$query = $this->db->get('location a');
		return $query->result();
	}

	public function get_department($company)
	{
		$this->db->join('section_manager c','c.department=a.department_id');
		$this->db->where('c.manager',$this->session->userdata('employee_id'));
		$this->db->where('c.company_id',$company);
		$this->db->group_by('a.department_id');
		$query = $this->db->get('department a');
		return $query->result();
	}

	public function get_section($company,$department)
	{
		$this->db->join('department cc','cc.department_id=a.department_id');
		$this->db->join('section_manager c','c.section=a.section_id');
		$this->db->where('c.manager',$this->session->userdata('employee_id'));
		$this->db->where('c.company_id',$company);
		if($department==''){} else{ $this->db->where('cc.department_id',$department); }
		$this->db->group_by('a.section_id');
		$query = $this->db->get('section a');
		return $query->result();
	}

	public function generate_report_result_employment($from,$to)
	{
		$option =  $this->input->post('option');
		$loc_val = $this->input->post('location');
		$dept_val = $this->input->post('department');
		$sec_val = $this->input->post('section');
		$class_val = $this->input->post('classification');
		$emp_val = $this->input->post('employment');

		$department = $this->section_manager_personnel('department');
		$section = $this->section_manager_personnel('section');
		$location = $this->section_manager_personnel('location');
		$subsection = $this->section_manager_personnel('subsection');

		$where = "date(a.date) between '" .$from. "' and '" .$to. "'"; 

		$this->db->select('a.*,b.*,c.*,d.*,e.*,f.*,g.*,h.classification as classification_name,i.*');
		$this->db->join('atro_approved_members b','b.id=a.id');
		$this->db->join('employee_info c','c.employee_id=b.employee_id');
		$this->db->join('division d','d.division_id=c.division_id','left');
		$this->db->join('department e','e.department_id=c.department');
		$this->db->join('section f','f.section_id=c.section');
		$this->db->join('location g','g.location_id=c.location');
		$this->db->join('classification h','h.classification_id=c.classification');
		$this->db->join('position i','i.position_id=c.position');
		$this->db->where($where);
		if($option=='sm_plotted'){ $this->db->where('b.plotted_by!=',$this->session->userdata('employee_id')); } else if($option=='plotted_only') { $this->db->where('b.plotted_by',$this->session->userdata('employee_id'));}
		
		if(!empty($class_val) AND $class_val!='All'){ $this->db->where('c.classification',$class_val); } 
		if($emp_val!='All'){ $this->db->where('c.employment',$emp_val); }

		if(empty($dept_val) || $dept_val=='All'){ $this->db->where($department); } else{ $this->db->where('c.department',$dept_val); }
		if(empty($sec_val) || $sec_val=='All'){ $this->db->where($section); } else{ $this->db->where('c.section',$sec_val); }
		if(empty($loc_val) || $loc_val=='All'){ $this->db->where($location); } else{ $this->db->where('c.location',$loc_val); }
		$this->db->where($subsection);

		$get = $this->db->get('atro_approved_main a');
		return $get->result();	
	}
}

