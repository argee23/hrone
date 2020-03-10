<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Notifications_report_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function get_notifications($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('notification_file_maintenance');
		return $query->result();
	}
	public function get_crystal_report_notif($company,$notif)
	{
		$this->db->where(array('company_id'=>$company,'notification_id'=>$notif,'type'=>'admin'));
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
						'type'			   =>		'admin',
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

	public function search_employee_list($company,$val)
	{
		$search = substr_replace($val, "", -1);
		$this->db->select('company_info.company_id as company_id,company_name,first_name,middle_name,last_name,employee_info.employee_id,employee_info.pay_type,pay_type_name');
		$this->db->from('company_info');
		$this->db->join("employee_info","employee_info.company_id = company_info.company_id");
		$this->db->join("pay_type","pay_type.pay_type_id = employee_info.pay_type");
		$this->db->where('company_info.company_id',$company);
		$this->db->where("(`last_name` LIKE '%$search%' OR  `first_name` OR  `employee_id`  LIKE '%$search%')");
		$this->db->order_by('last_name','asc');
		$query = $this->db->get();
		return $query->result();
	
	}
	public function get_datas($company,$option)
	{
		if($option=='employment')
		{
			$query = $this->db->get($option);
		}
		elseif($option=='classification')
		{
			$this->db->where(array('company_id'=>$company,'InActive'=>0));	
			$query = $this->db->get($option);
		}
		elseif($option=='location')
		{
			$this->db->select('a.*,b.location_name,a.location_id as lid');
			$this->db->join('location b','b.location_id=a.location_id');
			$this->db->where('a.company_id',$company);
			$query = $this->db->get('company_location a');
		}
		elseif($option=='department')
		{
			$this->db->select('*');
			$this->db->where('company_id',$company);
			$this->db->where('InActive',0);
			$query = $this->db->get('department');
		}
		
		return $query->result();
		
	}
	public function get_section($company,$dept)
	{
		$this->db->where(array('department_id'=>$dept,'InActive'=>0));
		$query = $this->db->get('section');
		return $query->result();
	}
	public function check_with_subsection($section)
	{
		$this->db->where('section_id',$section);
		$query = $this->db->get('section');
		return $query->row('wSubsection');
	}
	public function get_subsection($company,$section)
	{
		$this->db->where(array('section_id'=>$section,'InActive'=>0));
		$query = $this->db->get('subsection');
		return $query->result();
	}


	public function get_filtered_report_results($company,$notification,$crystal_report,$status,$status_view,$from,$to,$employee,$department,$section,$subsection,$employee_id,$loc,$emp,$classs)
	{
		$table = $this->get_table($notification);
		$location = $this->get_condition($loc,'location');
		$classification = $this->get_condition($classs,'classification');
		$employment = $this->get_condition($emp,'employment');
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
        		if($emp=='all'){}
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
	public function get_fields_reports($company,$notification)
	{
		$this->db->join('crystal_report_notifications_fields b','a.id=b.crystal_id');
		$this->db->join('crystal_report_notifications_list c','c.id=b.field_id');
		$query = $this->db->get('crystal_report_notifications a');
		$q=$query->result();

		$this->db->join('crystal_report_notifications_fields b','a.id=b.crystal_id');
		$this->db->join('notification_udf_column c','c.tran_udf_col_id=b.field_id');
		$this->db->where('c.id',$notification);
		$query2 = $this->db->get('crystal_report_notifications a');
		$q2=$query2->result();
		return array_merge($q,$q2);
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
	public function get_table($notif)
	{
		$this->db->where('id',$notif);
		$query = $this->db->get('notification_file_maintenance');
		return $query->row('t_table_name');
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