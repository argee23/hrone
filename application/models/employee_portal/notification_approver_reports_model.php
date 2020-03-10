<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Notification_approver_reports_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function get_notifications($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('notification_file_maintenance');
		return $query->result();
	}
	public function get_crystal_report_notif($type,$notif)
	{
		$this->db->where(array('added_by'=>$this->session->userdata('employee_id'),'notification_id'=>$notif,'type'=>'approver'));
		$query = $this->db->get('crystal_report_notifications');
		return $query->result();
	}
	public function action_crystal_report($notif,$company,$action,$id)
	{
		
		if($action=='disable')
		{
			$this->db->where('id',$id);
			$this->db->update('crystal_report_notifications',array('InActive'=>1));
		}
		else if($action=='enable')
		{
			$this->db->where('id',$id);
			$this->db->update('crystal_report_notifications',array('InActive'=>0));
		}
		else if($action=='delete')
		{
			
			$this->db->where('id',$id);
			$this->db->delete('crystal_report_notifications');
			$this->db->where('crystal_id',$id);
			$this->db->delete('crystal_report_notifications_fields');
		}
	}
	public function get_crystal_report_default_fields($notif)
	{
		$this->db->select('udf_label,TextFieldName, tran_udf_col_id as idd');
		$this->db->where('id',$notif);
		$query = $this->db->get('notification_udf_column');
		$q2 = $query->result();

		$this->db->select('udf_label,TextFieldName,id as idd');
		$this->db->where('InActive',0);
		$query = $this->db->get('crystal_report_notifications_list');
		$q1 = $query->result();

		return array_merge($q1,$q2);
	}
	public function save_crystal_report($company,$notif,$action,$name,$desc,$datass,$action_id)
	{
		$rname = $this->convert_char($name);
		$rdesc = $this->convert_char($desc);
		if($action=='save_update')
		{
			$this->db->where('id',$action_id);
			$this->db->update('crystal_report_notifications',array('title'=>$rname,'description'=>str_replace("mimi","",$rdesc)));

			$this->db->where('crystal_id',$action_id);
			$this->db->delete('crystal_report_notifications_fields');

			$a 	= substr_replace($datass, "", -1);
			$array =  explode('-', $a);

					foreach($array as $aa)
					{
						$dataa = array(
										'crystal_id'	=>	$action_id,
										'field_id'		=> $aa,
										'date_created'	=>date('Y-m-d H:i:s')
									);

						$this->db->insert('crystal_report_notifications_fields',$dataa);
						
					}
		}
		else
		{
					$data = array(
						'company_id'	   =>		$company,
						'notification_id'  =>		$notif,
						'title'			   =>		$rname,
						'description'	   =>		str_replace("mimi","",$rdesc),
						'date_created'	   =>		date('Y-m-d H:i:s'),
						'added_by'		   =>		$this->session->userdata('employee_id'),
						'type'			   =>		'approver',
						'InActive'		   =>		0
								 );
					$this->db->insert('crystal_report_notifications',$data);
					$this->db->select_max('id');
					$this->db->where(array('company_id'=>$company,'notification_id'=>$notif));
					$query = $this->db->get('crystal_report_notifications');
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
						$this->db->insert('crystal_report_notifications_fields',$dataa);
					}
		}
		
	}
	public function get_crystal_details($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('crystal_report_notifications');
		return $query->row();
	}

	public function crystal_report_details_fields($id,$idd)
	{
		$this->db->where(array('crystal_id'=>$id,'field_id'=>$idd));
		$query = $this->db->get('crystal_report_notifications_fields');
		return $query->num_rows();
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






	//starts here

	public function get_approver_notifications($approver)
	{
		$this->db->where('a.approver',$approver);
		$this->db->join('notification_file_maintenance b','b.id=a.notification');
		$query = $this->db->get('notifications_approvers a');
		return $query->result();
	}

	public function get_generate_crystal_reports($notif,$approver,$company_id)
	{
		$this->db->where(array('company_id'=>$company_id,'notification_id'=>$notif,'added_by'=>$approver,'type'=>'approver'));
		$query = $this->db->get('crystal_report_notifications');
		return $query->result();
	}

	public function employeelist_model($search,$company_id)
	{
		$search_val = substr_replace($search, "", -1);
		$this->db->select('employee_info.division_id,employee_info.department,employee_info.section,employee_info.subsection,employee_info.location,company_info.company_id as company_id,company_name,first_name,middle_name,last_name,employee_info.employee_id');
		$this->db->from('company_info');
		$this->db->join("employee_info","employee_info.company_id = company_info.company_id");
		$this->db->where('company_info.company_id',$company_id);
		$this->db->where("(`last_name` LIKE '%$search_val%' OR  `first_name` OR  `employee_id` LIKE '%$search_val%')");
		$this->db->order_by('last_name','asc');
		$query = $this->db->get();
		return $query->result();
	}
	public function checker_under_manager($division,$department,$section,$subsection,$location)
	{
		$this->db->where(array('department'=>$department,'section'=>$section,'sub_section'=>$subsection,'location'=>$location));
		if(empty($division_id) || $division_id==0){}
		else{ $this->db->where('division_id',$division); }

		if(empty($subsection) || $subsection==0){}
		else{ $this->db->where('sub_section',$subsection); }
		$query = $this->db->get('notifications_approvers');
		return $query->num_rows();
	}
	public function location_list($company_id,$employee_id)
	{
		$this->db->select('a.location,b.location_name');
		$this->db->join('location b','b.location_id=a.location');
		$this->db->where(array('a.company'=>$company_id,'a.approver'=>$employee_id));
		$this->db->group_by('a.location');
		$query =  $this->db->get('notifications_approvers a');
		return $query->result();
	}
	public function classification_list($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('classification');
		return $query->result();
	}
	public function department_list($company_id,$approver)
	{
		$this->db->select('a.department,b.dept_name');
		$this->db->join('department b','b.department_id=a.department');
		$this->db->where(array('a.company'=>$company_id,'a.approver'=>$approver));
		$this->db->group_by('a.department');
		$query =  $this->db->get('notifications_approvers a');
		return $query->result();
	}
	public function get_section($dept,$company_id,$approver)
	{
		$this->db->select('a.section,b.section_name');
		$this->db->join('section b','b.section_id=a.section');
		$this->db->where(array('a.company'=>$company_id,'a.approver'=>$approver,'department'=>$dept));
		$this->db->group_by('a.section');
		$query =  $this->db->get('notifications_approvers a');
		return $query->result();
	}
	public function get_subsection($section,$company_id,$approver)
	{
		$this->db->select('a.sub_section,b.subsection_name');
		$this->db->join('subsection b','b.subsection_id=a.sub_section');
		$this->db->where(array('a.company'=>$company_id,'a.approver'=>$approver,'a.section'=>$section));
		$this->db->group_by('a.sub_section');
		$query =  $this->db->get('notifications_approvers a');
		return $query->result();
	}

	public function get_filter_report_result($notification,$crystal_report,$status,$status_view,$to,$from,$employee,$employee_id,$department,$section,$subsection,$loc,$classs,$empp,$company)
	{
		$table = $this->get_table($notification);
		$location = $this->get_condition($loc,'location');
		$classification = $this->get_condition($classs,'classification');
		$employment = $this->get_condition($empp,'employment');
		$where = "date(date_created) between '" .$from. "' and '" .$to. "'";
		
		$this->db->select(' 	a.*,
								b.employee_id, b.first_name, b.middle_name, b.last_name, b.fullname,b.section,b.subsection,b.location,b.classification,b.employment,
								c.division_name,
								d.dept_name,
								e.section_name,
								f.subsection_name,
								g.location_name,
								h.classification as classification_name,
								i.position_name,
								j.employment_name
								');
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->join('division c','c.division_id=b.division_id','left');
		$this->db->join('department d','d.department_id=b.department');
		$this->db->join('section e','e.section_id=b.section');
		$this->db->join('subsection f','f.subsection_id=b.subsection');
		$this->db->join('location g','g.location_id=b.location');
		$this->db->join('classification h','h.classification_id=b.classification');
		$this->db->join('position i','i.position_id=b.position');
		$this->db->join('employment j','j.employment_id=b.employment');
		$this->db->where('a.company_id',$company);
		if($from=='all'){}
		else
		{
			$this->db->where($where);
		}
		if($status=='all'){} else { $this->db->where('a.status',$status); }
		if($status!='approved' AND $status!='all'){} 
		else 
		{ 
			if($status_view=='all'){}
			elseif($status_view=='a')
			{
				$this->db->where('a.time_acknowledge!=',Null);
			}
			elseif($status_view=='v')
			{
				$this->db->where('a.time_viewed!=',Null);
			}
			elseif($status_view=='na')
			{
				$this->db->where('a.time_acknowledge',Null);
			}
			elseif($status_view=='nv')
			{
				$this->db->where('a.time_viewed',Null);
			}
		}
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
        		if($empp=='all'){}
        		else
        		{
        			$this->db->where($employment);
        		}
		}
		else
		{
			$this->db->where('a.employee_id',$employee_id);
		}
		$query = $this->db->get($table.' a');
		return $query->result();
	}
	public function get_table($notif)
	{
		$this->db->where('id',$notif);
		$query = $this->db->get('notification_file_maintenance');
		return $query->row('t_table_name');
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
	public function get_fields_reports($company,$notification,$crystal_report)
	{
		$this->db->join('crystal_report_notifications_fields b','a.id=b.crystal_id');
		$this->db->join('crystal_report_notifications_list c','c.id=b.field_id');
		$this->db->where('b.crystal_id',$crystal_report);
		$query = $this->db->get('crystal_report_notifications a');
		$q=$query->result();

		$this->db->join('crystal_report_notifications_fields b','a.id=b.crystal_id');
		$this->db->join('notification_udf_column c','c.tran_udf_col_id=b.field_id');
		$this->db->where('b.crystal_id',$crystal_report);
		$this->db->where('c.id',$notification);

		$query2 = $this->db->get('crystal_report_notifications a');
		$q2=$query2->result();
		return array_merge($q,$q2);
	}
	
} 