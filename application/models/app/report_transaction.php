<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class report_transaction extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function get_transaction_list($company,$type)
	{
		if($type=='default')
		{
			$this->db->where(array('IsActive'=>1,'form_type'=>'T','IsUserDefine'=>0));
			
		}
		else
		{
			$this->db->where(array('IsActive'=>1,'form_type'=>'T','IsUserDefine'=>1,'company_id'=>$company));
			
		}
		$q = $this->db->get('transaction_file_maintenance');
		return $q->result();
	}

	public function get_crystal_reports_list_all()
	{
		$this->db->join('company_info b','b.company_id=a.company_id');
		$this->db->join('transaction_file_maintenance c','c.id=a.transaction_id');
		$this->db->where('a.type','admin');
		$q = $this->db->get('crystal_report_transaction_main a');
		return $q->result();
	}

	public function get_crystal_reports_list($company,$transaction,$tyy)
	{
		$this->db->where(array('type'=>$tyy,'company_id'=>$company,'transaction_id'=>$transaction));
		$q = $this->db->get('crystal_report_transaction_main');
		return $q->result();
	}

	public function get_transaction_details($transaction)
	{	
		$this->db->where('id',$transaction);
		$q = $this->db->get('transaction_file_maintenance');
		return $q->row();
	}
	public function get_transaction_fields($company,$transaction,$type)
	{
		$this->db->where('transaction_id','0');
		$q = $this->db->get('crystal_report_transaction');
		$qq =  $q->result();

		$this->db->where('transaction_id',$transaction);
		$s = $this->db->get('crystal_report_transaction');
		$ss =  $s->result();

		$this->db->where('transaction_id',$type);
		$d = $this->db->get('crystal_report_transaction');
		$dd =  $d->result();

		$this->db->select('tran_udf_col_id as crystal_report_transaction_id,udf_label,TextFieldName');
		$this->db->where('id',$transaction);
		$a = $this->db->get('transaction_udf_column');
		$aa =  $a->result();

		

	
		return array_merge($qq,$ss,$aa,$dd);
	}
	public function add_new_report($fields,$report_name,$report_desc,$transaction_id,$company,$tyy)
	{
		$name = $this->convert_char($report_name);
		$desc = $this->convert_char($report_desc);

		$field = substr_replace($fields, "", -1);
		$var=explode('-',$field);
		$data = array(
						'company_id'	=> $company,
						'title'			=> $name,
						'description'	=> $desc,
						'added_by'		=> $this->session->userdata('employee_id'),
						'type'			=> $tyy,
						'transaction_id'=> $transaction_id,
						'InActive'		=> 0,
		                'date_created' 	=> date('Y-m-d H:i:s')
						);	
		$inserted = $this->db->insert('crystal_report_transaction_main',$data);

		if($this->db->affected_rows() > 0)
		{
	    	$this->db->select_max('id');
			$this->db->from('crystal_report_transaction_main');
			$this->db->where(array(
						'title'		=> $name,
						'description'		=> $desc));
			$query = $this->db->get();
			$id_check =  $query->row("id");	

			foreach ($var as $row) {

				$data1 = array(
						'crystal_id'	=> $id_check,
						'field_id'		=> $row,
						'date_created'	=>date('Y-m-d')
						);	
				$inserted1 = $this->db->insert('crystal_report_transaction_fields',$data1);
			}
		}
		else { return 'error'; }
	}
	public function report_list($transaction_id,$company,$tyy)
	{
		$this->db->where(array('type'=>$tyy,'company_id'=>$company,'transaction_id'=>$transaction_id));
		$q = $this->db->get('crystal_report_transaction_main');
		return $q->result();
	}
	public function get_crystal_report_details($id)
	{
		$this->db->where('id',$id);
		$q = $this->db->get('crystal_report_transaction_main');
		return $q->row();
	}
	public function crystal_report_details_fields($id,$idd)
	{
		$this->db->where(array('crystal_id'=>$id,'field_id'=>$idd));
		$q = $this->db->get('crystal_report_transaction_fields');
		return $q->result();
	}
	public function action_crystal_report($id,$action)
	{
		if($action=='delete')
		{
			$this->db->where('id',$id);
			$this->db->delete('crystal_report_transaction_main');

			$this->db->where('crystal_id',$id);
			$this->db->delete('crystal_report_transaction_fields');

		}
		else if($action=='enable')
		{
			$this->db->where('id',$id);
			$this->db->update('crystal_report_transaction_main',array('InActive'=>0));
		}
		else
		{
			$this->db->where('id',$id);
			$this->db->update('crystal_report_transaction_main',array('InActive'=>1));
		}	
	}

	public function saveupdate_new_report($fields,$report_name,$report_desc,$transaction_id,$company,$crystal_id)
	{
	

		$name = $this->convert_char($report_name);
		$desc = $this->convert_char($report_desc);
		$field = substr_replace($fields, "", -1);
		$var=explode('-',$field);
		$data = array(
						'title'			=> $name,
						'description'	=> $desc
						);	
		$this->db->where('id',$crystal_id);
		$update = $this->db->update('crystal_report_transaction_main',$data);

		
	    	$this->db->where('crystal_id',$crystal_id);
	    	$this->db->delete('crystal_report_transaction_fields');

			foreach ($var as $row) {

				$data1 = array(
						'crystal_id'	=> $crystal_id,
						'field_id'		=> $row,
						'date_created'	=>date('Y-m-d')
						);	
				$inserted1 = $this->db->insert('crystal_report_transaction_fields',$data1);
			}
		
	}

	public function get_classification($company)
	{
		$this->db->where(array('company_id'=>$company,'InActive'=>0));	
		$query = $this->db->get('classification');
		return $query->result();
	}
	public function get_location($company)
	{
		$this->db->select('a.*,b.*');
		$this->db->join('location b','b.location_id=a.location_id');
		$this->db->where('a.company_id',$company);
		$query = $this->db->get('company_location a');
		return $query->result();
	}
	public function search_employee_list($company,$val)
	{
		echo $company.$val;
		$search_val = substr_replace($val, "", -1);
		$this->db->select('employee_info.division_id,employee_info.department,employee_info.section,employee_info.subsection,employee_info.location,company_info.company_id as company_id,company_name,first_name,middle_name,last_name,employee_info.employee_id');
		$this->db->from('company_info');
		$this->db->join("employee_info","employee_info.company_id = company_info.company_id");
		$this->db->where('company_info.company_id',$company);
		$this->db->where("(`last_name` LIKE '%$search_val%' OR  `first_name` OR  `employee_id` LIKE '%$search_val%')");
		$this->db->order_by('last_name','asc');
		$query = $this->db->get();
		return $query->result();
	
	}

	public function get_division($company)
	{
		$this->db->where(array('company_id'=>$company,'InActive'=>0));
		$q = $this->db->get('division');
		return $q->result();
	}
	public function get_wdivision($company)
	{
		$this->db->where(array('company_id'=>$company,'wDivision'=>1));
		$q = $this->db->get('company_info');
		return $q->result();
	}
	public function get_department($company,$div)
	{
		if($div=='not_included' || $div=='all'){} else{ $this->db->where('division_id',$div); }
		$this->db->where(array('company_id'=>$company,'InActive'=>0));
		$q = $this->db->get('department');
		return $q->result();
	}
	public function get_section($company,$department,$division)
	{
		if($department=='all')
		{
			$this->db->where('b.company_id',$company);
			if($department=='all' || $department=='not_included')
			{
				if($division=='not_included' || $division=='all'){ }
				else
				{
					$this->db->where('b.division_id',$division);
				} 
			}
			else{ $this->db->where('b.department_id',$department); }
			$this->db->join('department b','b.department_id=a.department_id');
			$q = $this->db->get('section a');
		}
		else
		{
			$this->db->where(array('department_id'=>$department,'InActive'=>0));
			$q = $this->db->get('section');
		}
		
		return $q->result();
	}
	public function get_wsubsection($section)
	{
		$this->db->where(array('section_id'=>$section,'wSubsection'=>1));
		$q = $this->db->get('section');
		return $q->result();
	}
	public function get_subsection($section,$company,$division,$department)
	{
		if($section=='all')
		{
			$this->db->where('c.company_id',$company);
			if($department=='all' || $department=='not_included')
			{
				if($division=='not_included' || $division=='all'){ }
				else
				{
					$this->db->where('c.division_id',$division);
				} 
			}
			else{ $this->db->where('c.department_id',$department); }

			$this->db->join('section b','b.section_id=a.section_id');
			$this->db->join('department c','c.department_id=b.department_id');
			$q = $this->db->get('subsection a');
		}
		else
		{
			$this->db->where(array('section_id'=>$section,'InActive'=>0));
			$q = $this->db->get('subsection');
		}
		
		return $q->result();
	}
	public function get_payroll_period_list($employee_id)
	{
		$this->db->where(array('employee_id'=>$employee_id,'InActive'=>0));
		$query = $this->db->get('payroll_period_employees a',1);
		$group = $query->row('payroll_period_group_id');

		$this->db->where(array('payroll_period_group_id'=>$group,'InActive'=>0));
		$this->db->order_by('complete_from','ASC');
		$query1 = $this->db->get('payroll_period');
		return $query1->result();
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
	public function get_generate_report_result($company,$type,$transaction,$crystalreport,$employees,$status,$filtertype,$employeeid,$division,$department,$section,$subsection,$employment,$classification,$payrollperiod,$datefrom,$dateto,$location)
	{

		$trans_details = $this->get_transaction_details($transaction);
		$table = $trans_details->t_table_name;
		
		$loc = $this->get_condition($location,'location');
		$classs = $this->get_condition($classification,'classification');
		$empp = $this->get_condition($employment,'employment');
		$where_date_filed = "date(date_created) between '" .$datefrom. "' and '" .$dateto. "'";
		$pperiod = $this->report_transaction->get_pp($payrollperiod);
		
		if(empty($pperiod))
		{
			$pp_from = '';
			$pp_to = '';
		}
		else
		{

			$pp_from = $pperiod->year_from . '-' . $pperiod->month_from . '-' . $pperiod->day_from;
			$pp_to = $pperiod->year_to . '-' . $pperiod->month_to . '-' . $pperiod->day_to;
		}
				
				


		if($filtertype=='payrollperiod_datefiled')
		{
			
			if(empty($payrollperiod))
			{
				$where_payrollperiod_datefiled="";
			}
			else
			{
				if(empty($pp_from) || empty($pp_to)){ $where_payrollperiod_datefiled=""; }
				else{ $where_payrollperiod_datefiled = "date(date_created) between '" .$pp_from. "' and '" .$pp_to. "'"; }
				
			}
			
		}
		else if($filtertype=='daterange_transactiondate')
		{
			if(empty($datefrom) || empty($dateto))
			{
				$where_date_transaction="";
			}
			else if($transaction==2 || $transaction==3 || $transaction==15)
			{
				$where_date_transaction = "date(k.the_date) between '" .$datefrom. "' and '" .$dateto. "'";
			}
			else if($transaction==8)
			{
				$where_date_transaction = "date(a.atro_date) between '" .$datefrom. "' and '" .$dateto. "'";
			}
			else if($transaction==23 || $transaction==25)
			{
				$where_date_transaction = "date(a.covered_date) between '" .$datefrom. "' and '" .$dateto. "'";
			}
			else if($transaction==26)
			{
				$where_date_transaction = "date(a.call_out_date) between '" .$datefrom. "' and '" .$dateto. "'";
			}
			else if($transaction==27)
			{
				$where_date_transaction = "date(a.orig_rest_day) between '" .$datefrom. "' and '" .$dateto. "'";
			}
			else
			{
				$where_date_transaction="";
			}
		}
		else if($filtertype=='payrollperiod_transactiondate')
		{
			if(empty($payrollperiod))
			{
				$where_payrollperiod_transaction="";
			}
			else
			{
				if($transaction==2 || $transaction==3 || $transaction==15)
				{
					if(empty($pp_from) || empty($pp_to)){ $where_payrollperiod_transaction=""; }
					else{ $where_payrollperiod_transaction = "date(k.the_date) between '" .$pp_from. "' and '" .$pp_to. "'"; }
				}
				else if($transaction==8)
				{
					if(empty($pp_from) || empty($pp_to)){ $where_payrollperiod_transaction=""; }
					else{ $where_payrollperiod_transaction = "date(a.atro_date) between '" .$pp_from. "' and '" .$pp_to. "'"; }
				}
				else if($transaction==23 || $transaction==25)
				{
					if(empty($pp_from) || empty($pp_to)){ $where_payrollperiod_transaction=""; }
					else{ $where_payrollperiod_transaction = "date(a.covered_date) between '" .$pp_from. "' and '" .$pp_to. "'"; }
				}
				else if($transaction==26)
				{
					if(empty($pp_from) || empty($pp_to)){ $where_payrollperiod_transaction=""; }
					else{ $where_payrollperiod_transaction = "date(a.call_out_date) between '" .$pp_from. "' and '" .$pp_to. "'"; }
				}

				else
				{ $where_payrollperiod_transaction=""; }
				
			}
		}


		$this->db->select(' 	a.*,
								a.id as idd,
								b.employee_id, b.first_name, b.middle_name, b.last_name, b.fullname,b.section,b.subsection,b.location,b.classification,b.employment,
								c.division_name,
								d.dept_name,
								e.section_name,
								f.subsection_name,
								g.location_name,
								h.classification as classification_name,
								i.position_name,
								j.employment_name,
								bb.company_name
								');
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->join('company_info bb','bb.company_id=a.company_id');
		$this->db->join('division c','c.division_id=b.division_id','left');
		$this->db->join('department d','d.department_id=b.department');
		$this->db->join('section e','e.section_id=b.section');
		$this->db->join('subsection f','f.subsection_id=b.subsection','left');
		$this->db->join('location g','g.location_id=b.location');
		$this->db->join('classification h','h.classification_id=b.classification');
		$this->db->join('position i','i.position_id=b.position');
		$this->db->join('employment j','j.employment_id=b.employment');
		
		if($transaction==2) { $this->db->join('employee_leave_days k','k.doc_no=a.doc_no'); }
		else if($transaction==3) { $this->db->join('emp_change_sched_days k','k.doc_no=a.doc_no'); }
		else if($transaction==15) { $this->db->join('emp_official_business_days k','k.doc_no=a.doc_no'); }
		else { }





		if($employees=='one')
		{
			$this->db->where('b.employee_id',$employeeid);
		}
		else
		{	
			if($division=='all' || $division=='not_included'){} else{ $this->db->where('b.division_id',$division); }
			if($department=='all' || $department=='not_included'){} else{ $this->db->where('b.department',$department); }
			if($section=='all' || $section=='not_included'){} else{ $this->db->where('b.section',$section); }
			if($subsection=='all' || $subsection=='not_included'){} else{ $this->db->where('b.subsection',$subsection); }
			if($loc=='none'){} else{ $this->db->where($loc); }
			if($classs=='none'){} else{ $this->db->where($classs); }
			if($empp=='none'){} else{ $this->db->where($empp); }
		}
		
		if($status=='all'){} else{ $this->db->where('a.status',$status); }
		$this->db->where('a.company_id',$company);
		

		if($filtertype=='daterange_datefiled')
		{
			if($datefrom=='all'){}
			else { $this->db->where($where_date_filed); }
		}
		else if($filtertype=='daterange_transactiondate')
		{
			if($datefrom=='all'){}
			else { $this->db->where($where_date_transaction); }
		}
		else if($filtertype=='payrollperiod_transactiondate')
		{
			if($transaction==27)
			{
				$this->db->where('a.payroll_period',$payrollperiod);
			}
			else if(empty($where_payrollperiod_transaction)){} 
			else{ $this->db->where($where_payrollperiod_transaction); }
		}
		else if($filtertype=='payrollperiod_datefiled')
		{
			if(empty($where_payrollperiod_datefiled))
			{} else{ $this->db->where($where_payrollperiod_datefiled); }
			
		}
		else
		{}

		$query = $this->db->get($table.' a');
		return $query->result();

	}
	public function get_crystal_reports($crystalreport)
	{
		$this->db->join('crystal_report_transaction b','b.crystal_report_transaction_id=a.field_id');
		$this->db->where('a.crystal_id',$crystalreport);
		$q = $this->db->get('crystal_report_transaction_fields a');
		$qq= $q->result();

		$this->db->join('transaction_udf_column b','b.tran_udf_col_id=a.field_id');
		$this->db->where('a.crystal_id',$crystalreport);
		$c = $this->db->get('crystal_report_transaction_fields a');
		$cc= $c->result();

		return array_merge($qq,$cc);
	}

	public function get_employee_request_list_data($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('emp_request_form_list');
		return $query->row('title');
	}
	public function get_pp($period_id)
	{
		$this->db->select('month_from, day_from, year_from, month_to, day_to, year_to,complete_from,complete_to');
		$this->db->where('id', $period_id);
		$query = $this->db->get('payroll_period', 1);
		return $query->row();
	}
	public function get_leave_type_name($id)
	{
		$this->db->where('id',$id);
		$q = $this->db->get('leave_type',1);
		return $q->row('leave_type');
	}
	public function transaction_dates($doc,$table)
	{
		$this->db->where('doc_no',$doc);
		$q = $this->db->get($table);
		return $q->result();
	}
	public function get_loan_type_name($id)
	{
		$this->db->where('loan_type_id',$id);
		$q = $this->db->get('loan_type',1);
		return $q->row('loan_type');
	}
	public function get_tran_details($idname,$table,$name,$id)
	{
		$this->db->where($idname,$id);
		$q = $this->db->get($table,1);
		return $q->row($name);
	}
	public function get_tran_details_parameters($code,$desc,$val,$value)
	{
		$this->db->where($desc,$value);
		$this->db->where('cCode',$code);
		$q = $this->db->get('system_parameters',1);
		return $q->row($val);
	}
	public function checker_under_manager($division,$department,$section,$subsection,$location)
	{
		$this->db->where(array('department'=>$department,'section'=>$section,'location'=>$location));
		if(empty($division_id) || $division_id==0){}
		else{ $this->db->where('division_id',$division); }

		if(empty($subsection) || $subsection==0){}
		else{ $this->db->where('sub_section',$subsection); }
		$query = $this->db->get('notifications_approvers');
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
}
