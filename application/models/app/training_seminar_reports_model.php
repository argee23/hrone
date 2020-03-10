<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Training_seminar_reports_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function get_crystal_report()
	{
		$this->db->select('a.*,b.first_name,b.last_name,b.middle_name,b.fullname');
		$this->db->join('employee_info b','b.employee_id=a.added_by');
		$query = $this->db->get('crystal_report_training_seminars a');
		return $query->result();
	}
	public function action_crystal_report($notif,$company,$action,$id)
	{
		if($action=='disable')
		{
			$this->db->where('id',$id);
			$this->db->update('crystal_report_training_seminars',array('InActive'=>1));
		}
		else if($action=='enable')
		{
			$this->db->where('id',$id);
			$this->db->update('crystal_report_training_seminars',array('InActive'=>0));
		}
		else if($action=='delete')
		{
			
			$this->db->where('id',$id);
			$this->db->delete('crystal_report_training_seminars');
			$this->db->where('crystal_id',$id);
			$this->db->delete('crystal_report_training_seminars_fields');
		}
	}

	public function training_seminar_field_list()
	{
		$this->db->where('InActive',0);
		$query = $this->db->get('crystal_report_training_seminars_list');
		return $query->result();
	}
	public function save_crystal_report($action,$name,$desc,$datass,$action_id)
	{
		$rname = $this->convert_char($name);
		$rdesc = $this->convert_char($desc);
		if($action=='save_update')
		{
			$this->db->where('id',$action_id);
			$this->db->update('crystal_report_training_seminars',array('title'=>$rname,'description'=>str_replace("mimi","",$rdesc)));

			$this->db->where('crystal_id',$action_id);
			$this->db->delete('crystal_report_training_seminars_fields');

			$a 	= substr_replace($datass, "", -1);
			$array =  explode('-', $a);

					foreach($array as $aa)
					{
						$dataa = array(
										'crystal_id'	=>	$action_id,
										'field_id'		=> $aa,
										'date_created'	=>date('Y-m-d H:i:s')
									);

						$this->db->insert('crystal_report_training_seminars_fields',$dataa);
						
					}
		}
		else
		{
					$data = array(
						'title'			   =>		$rname,
						'description'	   =>		str_replace("mimi","",$rdesc),
						'date_created'	   =>		date('Y-m-d H:i:s'),
						'added_by'		   =>		$this->session->userdata('employee_id'),
						'InActive'		   =>		0
								 );
					$this->db->insert('crystal_report_training_seminars',$data);
					$this->db->select_max('id');
					$query = $this->db->get('crystal_report_training_seminars');
					$c_id  = $query->row('id');

					$a 	= substr_replace($datass, "", -1);
					$array =  explode('-', $a);

					foreach($array as $aa)
					{
						$dataa = array(
										'crystal_id'	=>	$c_id,
										'field_id'		=> $aa,
										'date_created'	=>date('Y-m-d H:i:s')
									);
						$this->db->insert('crystal_report_training_seminars_fields',$dataa);
					}
		}
		
	}

	public function get_crystal_details($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('crystal_report_training_seminars');
		return $query->row();
	}
	public function crystal_report_details_fields($id,$idd)
	{
		$this->db->where(array('crystal_id'=>$id,'field_id'=>$idd));
		$query = $this->db->get('crystal_report_training_seminars_fields');
		return $query->num_rows();
	}

	public function training_seminar_details($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('crystal_report_training_seminars');
		return $query->row();
	}

	public function get_all_crystal_report()
	{
		$employee_id = $this->session->userdata('employee_id');
		$this->db->where('added_by',$employee_id);
		$query = $this->db->get('crystal_report_training_seminars');
		return $query->result();
	}

	public function filter_report_results($company,$crystal_report,$employee,$employee_id,$department,$section,$subsection,$loc,$emp,$classs,$training_type,$sub_type,$conducted_by_type,$fee_type,$payment_status,$others,$date_final,$from,$to,$company_shouldered_fee,$with_required_service_length)
	{
		$location = $this->get_condition($loc,'location');
		$classification = $this->get_condition($classs,'classification');
		$employment = $this->get_condition($emp,'employment');
		$datenow = date('Y-m-d');
		$whereupcoming ='(a.datefrom >="'.$datenow.'" or dateto >="'.$datenow.'")';
	 	$without = '(a.monthsRequired="" or a.monthsRequired="0")';
	 	$with = '(a.monthsRequired!="" AND a.monthsRequired!="0")';

		$this->db->select('		a.*,
								b.employee_id, b.first_name, b.middle_name, b.last_name, b.fullname,b.section,b.subsection,b.location,b.classification,b.employment,b.date_employed,
								c.division_name,
								d.dept_name,
								e.section_name,
								f.subsection_name,
								g.location_name,
								h.classification as classification_name,
								i.position_name,
								j.employment_name');
		$this->db->join('employee_info b','b.employee_id=a.employee_info_id');
		$this->db->join('division c','c.division_id=b.division_id','left');
		$this->db->join('department d','d.department_id=b.department');
		$this->db->join('section e','e.section_id=b.section');
		$this->db->join('subsection f','f.subsection_id=b.subsection','left');
		$this->db->join('location g','g.location_id=b.location');
		$this->db->join('classification h','h.classification_id=b.classification');
		$this->db->join('position i','i.position_id=b.position');
		$this->db->join('employment j','j.employment_id=b.employment');
		$this->db->where('b.company_id',$company);

		if($company_shouldered_fee=='with'){ $this->db->where($with); } else if($company_shouldered_fee=='without'){ $this->db->where($without); } else{}

		if($sub_type!='all'){ $this->db->where('a.sub_type',$sub_type); }

		if($training_type!='all'){ $this->db->where('a.training_type',$training_type); }

		if($conducted_by_type!='all'){ $this->db->where('a.conducted_by_type',$conducted_by_type); }

		if($fee_type!='all'){ $this->db->where('a.fee_type',$fee_type); }

		if($payment_status!='all'){ $this->db->where('a.payment_status',$payment_status); }

		if($others=='all')
		{
			if($from=='all'){}
			else
			{
				$this->db->where('a.datefrom >=',$from);
        	    $this->db->where('a.dateto <=',$to);
			}
		}
		else if($others=='upcoming')
		{
			$this->db->where($whereupcoming);
        	
		}
		else
		{}

		if($employee=='all')
		{
				if($section=='all'){}
        		else{ $this->db->where('b.section',$section); }

        		if($subsection=='not_included'){}
        		else
        		{
        			if($subsection!='all'){ $this->db->where('b.subsection',$subsection); }
        			else { }
        		}

        		if($loc=='all'){}
        		else
        		{ 
        			
 					$this->db->where($location);

        		}
        		if($classs=='all'){}
        		else
        		{
        			$this->db->where($classification);
        		}
        		if($emp=='all'){}
        		else
        		{
        			$this->db->where($employment);
        		}
		}
		else
		{
			$this->db->where('a.employee_info_id',$employee_id);
		}
		$query = $this->db->get('emp_trainings_seminars a');
		$results =  $query->result();
		return $results;

		
	}

	public function get_condition($option,$val)
	{
		$locc 	= substr_replace($option, "", -1);
		$location =  explode('-', $locc);
		$string_l="";
		foreach($location as $a)
            { 	 
            	$dd = 'b.'.$val.'="'.$a.'" or ';
                $string_l .= $dd;
            }
        $res_l = substr($string_l, 0, -4);
        $where_l = "(".$res_l.")";
        return $where_l;

	}

	public function crystal_report_fields($crystal)
	{
		$this->db->join('crystal_report_training_seminars_list b','b.idd=a.field_id');
		$this->db->where('a.crystal_id',$crystal);
		$query = $this->db->get('crystal_report_training_seminars_fields a');
		return $query->result();
	}

	public function get_date_details($id)
	{
		$this->db->where('seminar_training_id',$id);
		$query = $this->db->get('emp_trainings_seminars_dates');
		return $query->result();
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