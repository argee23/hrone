<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Training_seminar_request_reports_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function get_crystal_report()
	{
		$this->db->select('a.*,b.first_name,b.last_name,b.middle_name,b.fullname');
		$this->db->join('employee_info b','b.employee_id=a.added_by');
		$query = $this->db->get('crystal_report_training_seminars_request a');
		return $query->result();
	}

	public function training_seminar_field_list($option)
	{

		if($option=='training_seminar')
		{
			$c = 'c1';
		}
		else
		{
			$c = 'c2';
		}
		$this->db->where(array('InActive'=>0,'type'=>'all'));
		$query = $this->db->get('crystal_report_training_seminars_request_list');
		$q1 = $query->result();

		$this->db->where(array('InActive'=>0,'type'=>$c));
		$query2 = $this->db->get('crystal_report_training_seminars_request_list');
		$q2 = $query2->result();

		return array_merge($q1,$q2);
		
	}

	public function save_crystal_report($action,$name,$desc,$datass,$action_id,$crystal_type)
	{
		$rname = $this->convert_char($name);
		$rdesc = $this->convert_char($desc);
		if($action=='save_update')
		{
			$this->db->where('id',$action_id);
			$this->db->update('crystal_report_training_seminars_request',array('title'=>$rname,'description'=>str_replace("mimi","",$rdesc)));

			$this->db->where('crystal_id',$action_id);
			$this->db->delete('crystal_report_training_seminars_request_fields');

			$a 	= substr_replace($datass, "", -1);
			$array =  explode('-', $a);

					foreach($array as $aa)
					{
						$dataa = array(
										'crystal_id'	=>	$action_id,
										'field_id'		=> $aa,
										'date_created'	=>date('Y-m-d H:i:s')
									);

						$this->db->insert('crystal_report_training_seminars_request_fields',$dataa);
						
					}
		}
		else
		{
					$data = array(
						'title'			   =>		$rname,
						'description'	   =>		str_replace("mimi","",$rdesc),
						'date_created'	   =>		date('Y-m-d H:i:s'),
						'added_by'		   =>		$this->session->userdata('employee_id'),
						'InActive'		   =>		0,
						'crystal_type'	   =>		$crystal_type
								 );
					$this->db->insert('crystal_report_training_seminars_request',$data);
					$this->db->select_max('id');
					$query = $this->db->get('crystal_report_training_seminars_request');
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
						$this->db->insert('crystal_report_training_seminars_request_fields',$dataa);
					}
		}
		
	}

	public function training_seminar_details($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('crystal_report_training_seminars_request');
		return $query->row();
	}

	public function crystal_report_details_fields($id,$idd)
	{
		$this->db->where(array('crystal_id'=>$id,'field_id'=>$idd));
		$query = $this->db->get('crystal_report_training_seminars_request_fields');
		return $query->num_rows();
	}

	public function action_crystal_report($notif,$company,$action,$id)
	{
		if($action=='disable')
		{
			$this->db->where('id',$id);
			$this->db->update('crystal_report_training_seminars_request',array('InActive'=>1));
		}
		else if($action=='enable')
		{
			$this->db->where('id',$id);
			$this->db->update('crystal_report_training_seminars_request',array('InActive'=>0));
		}
		else if($action=='delete')
		{
			
			$this->db->where('id',$id);
			$this->db->delete('crystal_report_training_seminars_request');
			$this->db->where('crystal_id',$id);
			$this->db->delete('crystal_report_training_seminars_request_fields');
		}
	}

	public function f_get_crystal_report($company,$type)
	{
		$this->db->where('crystal_type',$type);
		$query = $this->db->get('crystal_report_training_seminars_request');
		return $query->result();
	}

	public function get_all_training($from,$to,$company)
	{
		if($from=='All'){}
		else
		{
			$this->db->where('datefrom >=',$from);
        	$this->db->where('dateto <=',$to);
		}
		$this->db->where('company_id',$company);
		$query = $this->db->get('emp_trainings_seminars_incoming');
		return $query->result();
	}

	public function generate_training_seminar_reports($report_option,$company,$crystal_report,$training_date,$datefrom,$dateto,$training_title,$training_type,$sub_type,$conducted_by_type,$fee_type)
	{	
		
		if($training_date=='All'){}
		else
		{
			$this->db->where('datefrom >=',$datefrom);
        	$this->db->where('dateto <=',$dateto);
		}
		if($training_title=='All'){} else {  $this->db->where('a.training_seminar_id',$training_title); }

		if($training_type=='All' || $training_type=='not_included'){} else { $this->db->where('a.training_type',$training_type); }

		if($sub_type=='All' || $sub_type=='not_included'){} else { $this->db->where('a.sub_type',$sub_type); }

		if($conducted_by_type=='All' || $conducted_by_type=='not_included' ){} else { $this->db->where('a.conducted_by_type',$conducted_by_type); }

		if($fee_type=='All' || $fee_type=='not_included' ){} else { $this->db->where('a.fee_type',$fee_type); }

		$this->db->where('a.company_id',$company);
		$query  = $this->db->get('emp_trainings_seminars_incoming a');
		return $query->result();
	}

	public function get_crystal_report_selected($crystal_report)
	{	
		$this->db->join('crystal_report_training_seminars_request_list b','b.idd=a.field_id');
		$this->db->where('a.crystal_id',$crystal_report);
		$query = $this->db->get('crystal_report_training_seminars_request_fields a');
		return $query->result();
	}

	public function get_date_details($id)
	{
		$this->db->where('seminar_training_id',$id);
		$query = $this->db->get('emp_trainings_seminars_dates_incoming');
		return $query->result();
	}

	public function generate_training_seminar_reports_attendees($report_option,$company,$crystal_report,$training_date,$datefrom,$dateto,$training_title,$respond)
	{
		$this->db->select('a.*,b.*,c.*,d.classification as classification_name,e.position_name,f.division_name,g.dept_name,h.section_name,i.location_name,b.status as stat');
		$this->db->join('emp_trainings_seminar_incoming_employees b','b.training_id=a.training_seminar_id');
		$this->db->join('employee_info c','c.employee_id=b.employee_id');
		$this->db->join('classification d','d.classification_id=c.classification');
		$this->db->join('position e','e.position_id=c.position');
		$this->db->join('division f','f.division_id=c.division_id','left');
		$this->db->join('department g','g.department_id=c.department');
		$this->db->join('section h','h.section_id=c.section');
		$this->db->join('location i','i.location_id=c.location');
		if($training_date=='All'){}
		else
		{
			$this->db->where('datefrom >=',$datefrom);
        	$this->db->where('dateto <=',$dateto);
		}
		if($training_title=='All'){} else {  $this->db->where('a.training_seminar_id',$training_title); }

		if($respond=='All'){}
		else if($respond==1)
		{
			$this->db->where(array('b.status'=>1,'b.date_respond!='=>Null));
		} 
		else if($respond==0){ $this->db->where(array('b.status'=>0,'b.date_respond'=>Null)); }
		else { $this->db->where(array('b.status'=>0,'b.date_respond'=>Null)); }
		$this->db->where('a.company_id',$company);
		$query  = $this->db->get('emp_trainings_seminars_incoming a');
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