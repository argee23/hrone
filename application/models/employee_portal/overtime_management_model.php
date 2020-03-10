<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Overtime_management_model extends CI_Model{
	public function __construct(){
		parent::__construct();	
	}

	public function get_pre_approved_groups()
	{
		$company_id=$this->session->userdata('company_id');
		$this->db->where(array('policy_type'=>128,'company_id'=>$company_id));
		$query = $this->db->get('setting_atro_policy');
		return $query->result();
	}
	public function group_members($group)
	{
		if($group=='general')
		{
			$this->db->select('a.*,b.*,c.*');
			$this->db->join('department b','b.department_id=a.department');
			$this->db->join('section c','c.section_id=a.section');
			$this->db->where('a.company_id',$this->session->userdata('company_id'));
			$query = $this->db->get('employee_info a');
		}
		else
		{
			$this->db->where(array('a.id'=>$group,'b.company_id'=>$this->session->userdata('company_id')));
			$this->db->join('employee_info b','b.employee_id=a.employee_id');
			$query = $this->db->get('setting_atro_policy_member a');
		}
		return $query->result();
		
	}
	public function get_sched_grp_date($date,$employee_id)
	{

		$month = date("m", strtotime($date));
		$table = 'working_schedule_'.$month;
		$this->db->where(array('date'=>$date,'employee_id'=>$employee_id));
		$query = $this->db->get($table);
		return $query->row();
	}

	public function checker_member($section,$subsection,$location,$manager)
	{
		$this->db->where(array('section'=>$section,'location'=>$location,'manager'=> $manager,'InActive'=>0));
		if($subsection=='' || $subsection==null || $subsection==0){}
		else{ $this->db->where('subsection',$subsection); }
		$query = $this->db->get('section_manager');
		return $query->num_rows();
	}

	public function save_pre_approved($emp,$hrs,$reason,$count,$group,$date,$atro_option)
	{	
		if($group=='general'){ $type=$group; } else{ $type='group'; }

		if($atro_option=='pre_approved')
			{ 
				$main_table ='atro_pre_approved_main';
				$members_table ='atro_pre_approved_members';
			}
		else{ 
				$main_table ='atro_approved_main'; 
				$members_table ='atro_approved_members';
			}

		$reas = $this->overtime_management_model->convert_char($reason);
		$employees = explode("-",$emp);
		$hours = explode("-",$hrs);
		$data_main = array('plotted_by' => $this->session->userdata('employee_id'),'group_id'=>$group ,'date' => $date, 'reason' => $reas , 'date_created'=> date('Y-m-d'),'type'=>$type,'company_id'=>$this->session->userdata('company_id'));

		$this->db->where(array('group_id'=>$group,'date'=>$date,'type'=>$type,'company_id'=>$this->session->userdata('company_id')));
		$checker = $this->db->get($main_table);
		$checker_id = $checker->row('id');

		if(empty($checker_id))
		{
			$insert = $this->db->insert($main_table,$data_main);
			$this->db->select_max('id');
			$this->db->from($main_table);
			$this->db->where($data_main);
			$q = $this->db->get();
			$id = $q->row('id');
		}
		else
		{
			$upd_reason = array('reason'=>$reason);
			$this->db->where('id',$checker_id);
			$update_main = $this->db->update($main_table,$upd_reason);

			$id = $checker_id;
		}
		
		
		for($i=0;$i< $count; $i++)
		{
			
			$empp = $employees[$i];
			$hrss = $hours[$i];
			$data_members = array('id'=> $id,'employee_id'=> $empp,'hours' => $hrss, 'plotted_by' => $this->session->userdata('employee_id'),'date'=>$date,'date_inserted' => date('Y-m-d') , 'type'=>$type,'company_id'=>$this->session->userdata('company_id'));	
			$this->db->where(array('employee_id'=>$empp,'date'=>$date,'type'=>$type,'company_id'=>$this->session->userdata('company_id')));
			$ee = $this->db->get($members_table);
			
			if($ee->num_rows() > 0){
				$rr = $ee->row('plotted_by');
				if($rr==$this->session->userdata('employee_id'))
				{  
					$this->db->where(array('employee_id'=>$empp,'date'=>$date,'type'=>$type,'company_id'=>$this->session->userdata('company_id')));
				  	$update = $this->db->update($members_table,$data_members);
				}
				else
				{
				}
			}
			else{ $insert = $this->db->insert($members_table,$data_members); }
			
		}
	}

	public function plotted_details($option,$atro_option)
	{
		if($atro_option=='pre_approved')
			{ 
				$main_table ='atro_pre_approved_main';
				
			}
		else{ 
				$main_table ='atro_approved_main'; 
			}

		if($option=='general')
		{
			$this->db->select('a.*,c.*');
			$this->db->join('employee_info c','c.employee_id=a.plotted_by');
			$this->db->where(array('type'=>$option,'a.company_id'=>$this->session->userdata('company_id')));
			$query = $this->db->get($main_table.' a');
			return $query->result();
		}
		else
		{
			$this->db->select('a.*,b.*,c.*');
			$this->db->join('setting_atro_policy b','a.group_id=b.id');
			$this->db->join('employee_info c','c.employee_id=a.plotted_by');
			$this->db->where(array('type'=>$option,'a.company_id'=>$this->session->userdata('company_id')));
			$query = $this->db->get($main_table.' a');
			return $query->result();
		}
		
	}
	public function group_exist_checker($group,$date,$atro_option)
	{
		 if($atro_option=='pre_approved')
			{ 
				$main_table ='atro_pre_approved_main';
				
			}
		else{ 
				$main_table ='atro_approved_main'; 
			}
		$this->db->where(array('group_id'=>$group,'date'=> $date,'type'=>'group','company_id'=>$this->session->userdata('company_id')));
		$query = $this->db->get($main_table);
		return $query->row();
	}

	public function check_selected($employee_id,$date,$option,$atro_option)
	{
		if($atro_option=='pre_approved')
			{ 
				$members_table ='atro_pre_approved_members';
				
			}
		else{ 
				$members_table ='atro_approved_members'; 
			}

		if($option=='general'){ $type = 'general'; } else{ $type='group'; }
		$this->db->where(array('employee_id'=>$employee_id,'date'=>$date,'type'=>$type,'company_id'=>$this->session->userdata('company_id')));
		$query = $this->db->get($members_table);
		return $query->row();
	}

	public function get_date_preapproved($option,$value1,$value2,$value3,$atro_option)
	{

		if($atro_option=='pre_approved')
			{ 
				$main_table ='atro_pre_approved_main';
				
			}
		else{ 
				$main_table ='atro_approved_main'; 
			}

		if($value1=='general'){ $type= 'general'; } else { $type= 'group';  }
		$d = $value2."-".$value3;
		if($option=='Year')
		{
			if($value1=='All' || $value1=='general'){} else{ $this->db->where('group_id',$value1); }
			$this->db->where(array('type'=>$type,'company_id'=>$this->session->userdata('company_id')));
			$this->db->order_by('YEAR(date)','asc');
			$this->db->group_by('YEAR(date)');
			
		}
		elseif($option=='Month')
		{
			if($value1=='All' || $value1=='general'){} else{ $this->db->where('group_id',$value1); }
			$this->db->where('YEAR(date)',$value2);
			$this->db->where(array('type'=>$type,'company_id'=>$this->session->userdata('company_id')));
			$this->db->order_by('MONTH(date)','asc');
			$this->db->group_by('MONTH(date)');
		}
		elseif($option=='Day')
		{
			if($value1=='All' || $value1=='general'){} else{ $this->db->where('group_id',$value1); }
			$this->db->where("DATE_FORMAT(date,'%Y-%m')", $d);
			$this->db->where(array('type'=>$type,'company_id'=>$this->session->userdata('company_id')));
			$this->db->order_by('DAY(date)','asc');
			$this->db->group_by('DAY(date)');
				
		}
		$query = $this->db->get($main_table);
		return $query->result();
	}

	public function get_employees_with_preapproved($group,$year,$month,$day,$atro_option)
	{
		if($atro_option=='pre_approved')
			{ 
				
				$members_table ='atro_pre_approved_members';
			}
		else{ 
				
				$members_table ='atro_approved_members';
			}

		if($group=='general'){ $type='general'; } else{ $type='group';}
		$date = $year."-".$month."-".$day;
		$this->db->select('a.*,b.*');
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->where(array('date'=>$date,'type'=>$type,'a.company_id'=>$this->session->userdata('company_id')));
		$query = $this->db->get($members_table.' a');
		return $query->result();

	}
	public function checker_plotted($date,$group,$atro_option)
	{
		if($atro_option=='pre_approved')
			{ 
				
				$members_table ='atro_pre_approved_members';
			}
		else{ 
				
				$members_table ='atro_approved_members';
			}

		if($group=='general'){ $type='general'; } else{ $type='group';}
		$this->db->select('a.*,b.*');
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->where(array('date'=>$date,'a.employee_id!='=>$this->session->userdata('employee_id'),'type'=>$type));
		$query = $this->db->get($members_table.' a');
		return $query->num_rows();
	}
	public function get_employees_with_preapproved_($group,$date,$atro_option)
	{
		if($group=='general'){ $type='general'; } else{ $type='group';}
		if($atro_option=='pre_approved')
			{ 
				
				$members_table ='atro_pre_approved_members';
			}
		else{ 
				
				$members_table ='atro_approved_members';
			}
		$this->db->select('a.*,b.*');
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->where(array('date'=>$date,'a.company_id'=>$this->session->userdata('company_id'),'type'=>$type));
	
		$query = $this->db->get($members_table.' a');
		return $query->result();

	}

	public function save_pre_approved_update($date,$group,$count,$hours_result,$employee,$atro_option)
	{
		if($group=='general'){ $type='general'; } else{ $type='group'; }
		 if($atro_option=='pre_approved')
			{ 
				$main_table ='atro_pre_approved_main';
				$members_table ='atro_pre_approved_members';
			}
		else{ 
				$main_table ='atro_approved_main'; 
				$members_table ='atro_approved_members';
			}

		$hours = substr_replace($hours_result, "", -1);
		$employee = substr_replace($employee, "", -1);

		$hr = explode("-",$hours);
		$emp = explode("-",$employee);
		$c = $count -1 ;
		for($i=0;$i < $c; $i++)
		{
			$upd_hr = $hr[$i];
			$upd_emp = $emp[$i];
			$dataa = array('hours'=>$upd_hr);

			$this->db->where(array('employee_id'=>$upd_emp,'date'=>$date ,'type'=>$type,'company_id'=>$this->session->userdata('company_id')));
			$ee = $this->db->get($members_table);
			$rr = $ee->row('plotted_by');
			if($rr==$this->session->userdata('employee_id')) 
			{
						
					if($upd_hr==0 || $upd_hr=='')
					{
						$this->db->where(array('employee_id'=>$upd_emp,'date'=>$date,'type'=>$type,'company_id'=>$this->session->userdata('company_id')));
						$this->db->delete($members_table);
							
					}
					else
					{
						$this->db->where(array('employee_id'=>$upd_emp,'date'=>$date,'type'=>$type,'company_id'=>$this->session->userdata('company_id')));
						$this->db->update($members_table,$dataa);
					}
			} else{}
		}

	}

	//checking
	public function  get_attendance_by_date($date, $employee_id,$month)
	{
		
		$this->db->where(array('covered_date'=>$date,'employee_id'=>$employee_id));
		$query = $this->db->get($month);
		return $query->row();
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

	//for general 
	public function general_members()
	{

		$this->db->where('company_id',$this->session->userdata('company_id'));
		$query = $this->db->get('employee_info');
		return $query->result();	

		
	}
	public function atro_policy_main()
	{
		$this->db->where(array(
			'single_field_setting'			=>		'pre_approve',
			'overtime_filing'				=> 		'general'
		));	
		$query = $this->db->get("time_settings_".$this->session->userdata('company_id'));
		return $query->num_rows();
	}

	public function general_exist_checker($date,$atro_option)
	{	if($atro_option=='pre_approved'){ $main_table ='atro_pre_approved_main'; }
		else{  $main_table ='atro_approved_main'; }
		$this->db->where(array('date'=> $date,'type'=>'general','company_id'=>$this->session->userdata('company_id')));
		$query = $this->db->get($main_table);
		return $query->row();
	}
	//

	
}
