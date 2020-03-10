<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_notifications_model extends CI_Model{

	public function __construct(){

		parent::__construct();	
	}
	public function get_notif_details($company_id)
	{ 
		$forms = $this->issue_notifications_model->get_notification_list($company_id);
		$sum=0;
		foreach ($forms as $f) {
					$form_info 	= $this->get_notif_notyet_acknowledge($f->t_table_name,$this->session->userdata('employee_id'));
					$f->count = $form_info;

					$sum=$form_info + $sum;
				}

		return $forms; 
	}
	public function get_notif_notyet_acknowledge($table,$employee_id)
	{
		$array = array('time_acknowledge=' => null);
		$this->db->where($array);	
		$this->db->where('employee_id',$employee_id);
		$this->db->where('status','approved');
		$query = $this->db->get($table);
		return $query->num_rows();
	}
	public function get_all_notif_by_employee($table,$employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$array = array('time_acknowledge=' => null);
		$this->db->where($array);
		$query = $this->db->get($table);
		return $query->result();
	}

	public function get_approvers_by_doc($doc,$table)
	{
		$this->db->select('a.approval_level,b.first_name,b.last_name,b.employee_id');
		$this->db->join('employee_info b','b.employee_id=a.approver_id');
		$this->db->where('a.doc_no',$doc);
		$query = $this->db->get($table." a");
		return $query->result();
	}
	public function answer_notification($doc_no,$table,$employee_id,$identification,$form_details,$field_list,$assign)
	{
		$update_main = $this->update_viewed($doc_no,$table);
		$i=1; foreach($field_list as $fl)
		                {
		                  $title = $fl->TextFieldName;
		                  $assign_employee_id = $assign->$title;

		                  if(empty($assign_employee_id)){}
		                  else
		                  { 
		                  	if($assign_employee_id==$this->session->userdata('employee_id'))
		                  	{
		                  		
		                  		 $field_name = $this->input->post('field'.$fl->TextFieldName.$doc_no);
		                  		 $this->notification_approver_model->update_main_fields($doc_no,$fl->TextFieldName,$field_name,$table);	
		                  	}
		                  }
		        $i++;  }

		$this->db->where(array('doc_no'=>$doc_no,'employee_id'=>$employee_id));
		$this->db->update($table,array('time_acknowledge'=>date('Y-m-d H:i:s')));
	}
	public function update_viewed($doc,$table)
	{
		$this->db->where('doc_no',$doc_no);
		$query = $this->db->get($table);
		$viewed = $query->row('time_viewed');

		if(empty($viewed))
		{}
		else
		{
			$this->db->where('doc_no',$doc_no);
			$this->db->update($table,array('time_viewed'=>date('Y-m-d H:i:s')));
		}
	}
	public function filter_notifications_filtering_notif($table,$employee_id,$status,$from,$to)
	{
		
      	$where = "date(status_update_date) between '" .$from. "' and '" .$to. "'";
		$this->db->where($where);
		if($status=='all'){}
		else if($status=='v'){ $this->db->where('time_viewed!=',null); }
		else if($status=='a'){ $this->db->where('time_acknowledge!=',null); }

		else if($status=='nv'){ $this->db->where('time_viewed',null); }
		else if($status=='na'){ $this->db->where('time_acknowledge',null); }

		
      	$this->db->where('employee_id',$employee_id);
		$query = $this->db->get($table);
		return $query->result();

	}

	public function get_notif_details_filter($company_id,$status,$from,$to,$notif)
	{ 
		$forms = $this->employee_notifications_model->get_notification_list($company_id,$notif);
	
		foreach ($forms as $f) {
					$form_info 	= $this->get_notif_notyet_acknowledge_filter($f->t_table_name,$this->session->userdata('employee_id'),$status,$from,$to,'num_rows');
					$f->count = $form_info;
				}

		return $forms; 
	}
	public function get_notification_list($company,$notif)
	{
		if($notif=='all'){}
		else
		{
			$this->db->where('id',$notif);
		}
		$this->db->where(array('company_id'=>$company,'IsActive'=>1));
		$query = $this->db->get('notification_file_maintenance');
		return $query->result();
	}

	public function get_notif_notyet_acknowledge_filter($table,$employee_id,$status,$from,$to,$type)
	{
		
      	$where = "date(status_update_date) between '" .$from. "' and '" .$to. "'";
		$this->db->where($where);
		if($status=='all'){}
		else if($status=='v'){ $this->db->where('time_viewed!=',null); }
		else if($status=='a'){ $this->db->where('time_acknowledge!=',null); }

		else if($status=='nv'){ $this->db->where('time_viewed',null); }
		else if($status=='na'){ $this->db->where('time_acknowledge',null); }

      	$this->db->where('employee_id',$employee_id);
		$query = $this->db->get($table);
		if($type=='num_rows')
		{
			return $query->num_rows();	
		}
		else
		{
			return $query->result();	
		}
		
	}

	public function search_notif($value,$company_id)
	{
		
		$search = substr_replace($value, "", -1);
		$val = $this->convert_char($search);

		$this->db->select('*');
		$this->db->from('notification_file_maintenance');
		if($value=='' || $value=='-'){}
		else{ $this->db->where("(`form_name` LIKE '%$val%')"); }
		$query = $this->db->get();
		$forms = $query->result();

		foreach ($forms as $f) {
					$form_info 	= $this->get_notif_notyet_acknowledge($f->t_table_name,$this->session->userdata('employee_id'));
					$f->count = $form_info;

				}
		return $forms;	
	}

	public function get_employee_fields_tofill($id,$doc,$table)
	{
		$employee_id = $this->session->userdata('employee_id');
		$this->db->where('id',$id);
		$query = $this->db->get('notification_udf_column');
		$res = $query->result();
		$i=0;
		foreach($res as $rows)
		{
			$this->db->where('doc_no',$doc);
			$q = $this->db->get($table."_assign");
			$qq = $q->row($rows->TextFieldName);
			if($qq!='admin' AND $qq!='approver')
			{
				$i = $i+1;
				break;
			}
			else{ $i = $i+0; }
			
		}	
		return $i;		
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
