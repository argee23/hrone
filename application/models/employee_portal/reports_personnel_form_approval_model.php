<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Reports_personnel_form_approval_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}


	public function get_transaction_list()
	{
		$employee_id = $this->session->userdata('employee_id');

		$this->db->select('distinct(form_identification) as form_identification');
		$this->db->where(array('approver'=>$employee_id,'InActive'=>0));
		$query = $this->db->get('transaction_approvers');
		$result = $query->result();
		
		foreach($result as $r)
		{
			$form_name = $this->get_transaction_form_name($r->form_identification);
			foreach($form_name as $f)
			{
				$r->form_name = $f->form_name;
				$r->form_id = $f->id;
				$r->form_table = $f->t_table_name;
			}
		}

		return $result;

		
	}

	public function get_transaction_form_name($iden)
	{
		$this->db->where('identification',$iden);
		$q =  $this->db->get('transaction_file_maintenance',1);
		return $q->result();
	}

	public function crystal_report()
	{
		$this->db->join('transaction_file_maintenance b','b.id=a.transaction_id');
		$this->db->where(array('a.type'=>'approver','a.added_by'=>$this->session->userdata('employee_id'),'option'=>'form_approval'));
		$query = $this->db->get('crystal_report_form_transaction a');

		return $query->result();
	}

	public function crystal_report_transaction($id)
	{
		$this->db->select('a.*, b. form_name,b.t_table_name');
		$this->db->join('transaction_file_maintenance b','b.id=a.transaction_id');
		$this->db->where(array('a.type'=>'approver','a.added_by'=>$this->session->userdata('employee_id'),'a.transaction_id'=>$id,'a.option'=>'form_approval','a.InActive'=>0));
		$query = $this->db->get('crystal_report_form_transaction a');
		return $query->result();
	}

	public function crystal_report_list($id)
	{
		$this->db->where('id',$id);
		$trans = $this->db->get('transaction_file_maintenance',1);
		$trans_result = $trans->result();

		foreach($trans_result as $rr)
		{
				if($rr->IsUserDefine==0)
				{
						$this->db->where(array('a.InActive'=>0,'IsDefault'=>1));
						$query = $this->db->get('crystal_report_form_transaction_fields a');
						$result = $query->result();

						$this->db->where(array('a.transaction_id'=>$id,'IsDefault'=>0,'a.InActive'=>0));
						$query2 = $this->db->get('crystal_report_form_transaction_fields a');
						$result2 = $query2->result();

						return array_merge($result,$result2);
				}
				else
				{	

						$this->db->where(array('a.InActive'=>0,'IsDefault'=>1));
						$query = $this->db->get('crystal_report_form_transaction_fields a');
						$result = $query->result();

						$this->db->select('a.tran_udf_col_id,a.udf_label as title, a.udf_accept_value as field_name');
						$this->db->where(array('a.id'=>$id));
						$query2 = $this->db->get('transaction_udf_column a');
						$result2 = $query2->result();

						$this->db->where(array('IsDefault'=>2,'a.InActive'=>0));
						$query3 = $this->db->get('crystal_report_form_transaction_fields a');
						$result3 = $query3->result();


						foreach($result2 as $rr)
						{
							$rr->id = 'a'.$rr->tran_udf_col_id;
						}

						return array_merge($result,$result2,$result3);
				}
		}

		
	}

	public function save_crystal_report()
	{
		$id = $this->input->post('id');
		$identification =$this->input->post('identification');
		$title =$this->input->post('report_name');
		$desc =$this->input->post('report_desc');
		$sm =$this->session->userdata('employee_id');

		$main = array(		'company_id'	=>$this->session->userdata('company_id'),
							'added_by'		=>$sm,
							'title'			=>$title,
							'description'	=>$desc,
							'InActive' 		=>0,
							'type'			=>'approver',
							'transaction_id'=>	$id,
							'option'		=> 'form_approval',
							'date_created'=>date('Y-m-d H:i:s'));
		$insert_main = $this->db->insert('crystal_report_form_transaction',$main);
		if($this->db->affected_rows() > 0)
		{
			$this->db->select_max('id');
			$this->db->where(array('added_by'=>$sm,'title'=>$title,'description'=>$desc,'type'=>'approver','option'=>'form_approval'));
			$idd = $this->db->get('crystal_report_form_transaction');
			$p_id = $idd->row('id');

			$crystal_report_list = $this->reports_personnel_form_approval_model->crystal_report_list($id);
			foreach($crystal_report_list as $c)
			{
					
					$d = $this->input->post('checkvalue'.$c->id);
					if($this->input->post('checkselected'.$c->id)==true)
					{
						$datas = array(
										
										'crystal_id'	=>	$p_id,
										'field_id'		=>	$d,
										'date_created'	=>	date('Y-m-d')
									  );
						$this->db->insert('crystal_report_form_transaction_list',$datas);
					}
					else
					{}	
			}
		}
	}

	public function action_crystal_report($action,$id,$identification,$crystal_id)
	{
		if($action=='delete')
		{
			$this->db->where('id',$crystal_id);
			$this->db->delete('crystal_report_form_transaction');

			$this->db->where('crystal_id',$crystal_id);
			$this->db->delete('crystal_report_form_transaction_list');
		}
		else if($action=='enable')
		{
			$this->db->where('id',$crystal_id);
			$this->db->update('crystal_report_form_transaction',array('InActive'=>0));
		}
		else
		{
			$this->db->where('id',$crystal_id);
			$this->db->update('crystal_report_form_transaction',array('InActive'=>1));
		}
	}

	public function crystal_report_details_fields($crystal_id,$id)
	{
		$this->db->where(array('field_id'=>$id,'crystal_id'=>$crystal_id));
		$query = $this->db->get('crystal_report_form_transaction_list');
		return $query->result();
	}


	public function crystal_report_details($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('crystal_report_form_transaction');
		return $query->result();
	}	

	public function saveupdate_crystal_report()
	{
		$id = $this->input->post('id');
		$identification =$this->input->post('identification');
		$title =$this->input->post('report_name');
		$desc =$this->input->post('report_desc');
		$crystal_id = $this->input->post('crystal_id');
		$main = array(	
							'title'			=>$title,
							'description'	=>$desc);
		$this->db->where('id',$crystal_id);
		$this->db->update('crystal_report_form_transaction',$main);

		
		$this->db->where('crystal_id',$crystal_id);
		$this->db->delete('crystal_report_form_transaction_list');


			$crystal_report_list = $this->reports_personnel_form_approval_model->crystal_report_list($id);
			foreach($crystal_report_list as $c)
			{
					
					$d = $this->input->post('checkselected'.$c->id);
					if($this->input->post('checkselected'.$c->id)==true)
					{
						$datas = array(
										
										'crystal_id'	=>	$crystal_id,
										'field_id'		=>	$d,
										'date_created'	=>	date('Y-m-d')
									  );
						$this->db->insert('crystal_report_form_transaction_list',$datas);
					}
					else
					{}	
			}
		
	}

	public function company_list($identification)
	{
		$employee_id = $this->session->userdata('employee_id');

		$this->db->select('distinct(company) as company');
		$this->db->where(array('approver'=>$employee_id,'InActive'=>0,'form_identification'=>$identification));
		$query = $this->db->get('transaction_approvers');
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

	public function crystal_report_fields_generate($report,$identification,$id)
	{
		$this->db->where('crystal_id',$report);
		$query = $this->db->get('crystal_report_form_transaction_list');
		$result = $query->result();

		$this->db->where(array('id'=>$id,'identification'=>$identification));
		$trans = $this->db->get('transaction_file_maintenance',1);
		$trans_result = $trans->row();

		if($trans_result->IsUserDefine==1)
		{

			$this->db->where('a.crystal_id',$report);
			$this->db->order_by('id','ASC');
			$result = $this->db->get('crystal_report_form_transaction_list a');
			$res =  $result->result();
			foreach($res as $rr)
			{
				$idd = $rr->field_id;
				if (strpos($idd, 'a') !== false) {
    				$aidd = str_replace("a","",$idd);
					$this->db->where('tran_udf_col_id',$aidd);
					$q =  $this->db->get('transaction_udf_column');
					foreach($q->result() as $qq)
					{
						$rr->title = $qq->udf_label;
						$rr->field_name = $qq->TextFieldName;
					}

				}
				else
				{
					$this->db->where('id',$idd);
					$q =  $this->db->get('crystal_report_form_transaction_fields');
					foreach($q->result() as $qq)
					{
						$rr->title = $qq->title;
						$rr->field_name = $qq->field_name;
					}
				}

			}
			return $res;
		}
 
		else
		{
			$this->db->where('a.crystal_id',$report);
			$this->db->join('crystal_report_form_transaction_fields b','b.id=a.field_id');
			$result = $this->db->get('crystal_report_form_transaction_list a');
			return $result->result();
		}
		
	}

	public function generate_report_result($table_name)
	{
		$company 	= $this->input->post('company');
		$from 		= $this->input->post('date_from');
		$to 		= $this->input->post('date_to');
		$status 	= $this->input->post('status');
		$where = "date(a.date_time) between '" .$from. "' and '" .$to. "'";
		$this->db->select('a.date_time as approval_date,a.status as approval_status ,b.status as form_status,a.*,b.*,c.*,d.company_name,e.division_name,f.dept_name,g.section_name,h.subsection_name,i.classification as classification_name,j.location_name,k.employment_name');
		$this->db->join($table_name.' b','b.doc_no=a.doc_no');
		$this->db->join('employee_info c','c.employee_id=b.employee_id');
		$this->db->join('company_info d','d.company_id=c.company_id');
		$this->db->join('division e','e.division_id=c.division_id','left');
		$this->db->join('department f','f.department_id=c.department');
		$this->db->join('section g','g.section_id=c.section');
		$this->db->join('subsection h','h.subsection_id=c.subsection','left');
		$this->db->join('classification i','i.classification_id=c.classification');
		$this->db->join('location j','j.location_id=c.location');
		$this->db->join('employment k','k.employment_id=c.employment');

		if($company!='All'){ $this->db->where('c.company_id',$company); }
		if($status=='All'){ $this->db->where('a.status!=','pending'); }  else { $this->db->where('a.status',$status); }
		$this->db->where('a.approver_id',$this->session->userdata('employee_id'));
		$this->db->where($where);
		
		$this->db->group_by(array("a.doc_no", "a.approval_level")); 
		$query = $this->db->get($table_name.'_approval a');

		return $query->result();
	
	}


	public function leave_type($id)
	{
		$this->db->where('id',$id);
		$qe =$this->db->get('leave_type',1);
		return $qe->row('leave_type');
	}

	public function leave_dates($doc_no)
	{
		$this->db->where('doc_no',$doc_no);
		$query = $this->db->get('employee_leave_days');
		return $query->result();
	}
	public function ob_dates($doc_no)
	{
		$this->db->where('doc_no',$doc_no);
		$query = $this->db->get('emp_official_business_days');
		return $query->result();
	}

	public function schedule_dates($doc_no)
	{
		$this->db->where('doc_no',$doc_no);
		$query = $this->db->get('emp_change_sched_days');
		return $query->result();
	}

	public function request_list($id)
	{
		$array =  explode('-', $id);
		$data="";
		$i=1;
		foreach($array as $c)
		{
			$this->db->where('id',$c);
			$query = $this->db->get('emp_request_form_list');
			$row = $query->row('title');
			$data.=$i.')'.$row.'<br>';
			$i++;
		}
		return $data;
	}



	public function get_employee_attendance($employee_id,$date)
	{
		  $tmonth= substr($date, 5,2);

		  $this->db->where(array('employee_id'=>$employee_id,'covered_date'=>$date));
		  $query = $this->db->get('attendance_'.$tmonth);
		  return $query->result();
	}

	public function payroll_period($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('payroll_period',1);
		$from  = $query->row('complete_from');
		$to = $query->row('complete_to');

		return $from.' to '.$to;
	}

	public function leave_details($cancelled_doc_no)
	{
		  $this->db->where(array('doc_no'=>$cancelled_doc_no));
		  $query = $this->db->get('employee_leave',1);
		  return $query->result();
	}

	public function loan_type($id)
	{
		$this->db->where('loan_type_id',$id);
		$query = $this->db->get('loan_type',1);
		return $query->row('loan_type');
	}

	public function complaint_type($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('setting_type_complaints',1);
		return $query->row('complaint');
	}

	public function type_of_advance($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('advance_type',1);
		return $query->row('advance_type');
	}

	public function deduction_type($id)
	{
		$this->db->where(array('cCode'=>'cut_off','cDesc'=>$id));
		$query = $this->db->get('system_parameters',1);
		return $query->row('cValue');
	}

	public function system_param($id)
	{
		$this->db->where(array('param_id'=>$id));
		$query = $this->db->get('system_parameters',1);
		return $query->row('cValue');
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
		$this->db->where('b.company_id',$company);
		$this->db->group_by('a.location_id');
		$query = $this->db->get('location a');
		return $query->result();
	}

	public function get_department($company)
	{
		$this->db->where('a.company_id',$company);
		$this->db->group_by('a.department_id');
		$query = $this->db->get('department a');
		return $query->result();
	}

	public function get_section($company,$department)
	{
		$this->db->join('department cc','cc.department_id=a.department_id');
		$this->db->where('cc.company_id',$company);
		if($department==''){} else{ $this->db->where('cc.department_id',$department); }
		$this->db->group_by('a.section_id');
		$query = $this->db->get('section a');
		return $query->result();
	}

	public function generate_report_employment_result($table_name)
	{

		$company =$this->input->post('company');
		$department =$this->input->post('department');
		$section =$this->input->post('section');
		$location =$this->input->post('location');
		$classification =$this->input->post('classification');
		$employment =$this->input->post('employment');
		$from =$this->input->post('date_from');
		$to =$this->input->post('date_to');
		$status 	= $this->input->post('status');

		$where = "date(a.date_time) between '" .$from. "' and '" .$to. "'";
		$this->db->select('a.date_time as approval_date,a.status as approval_status ,b.status as form_status,a.*,b.*,c.*,d.company_name,e.division_name,f.dept_name,g.section_name,h.subsection_name,i.classification as classification_name,j.location_name,k.employment_name');
		$this->db->join($table_name.' b','b.doc_no=a.doc_no');
		$this->db->join('employee_info c','c.employee_id=b.employee_id');
		$this->db->join('company_info d','d.company_id=c.company_id');
		$this->db->join('division e','e.division_id=c.division_id','left');
		$this->db->join('department f','f.department_id=c.department');
		$this->db->join('section g','g.section_id=c.section');
		$this->db->join('subsection h','h.subsection_id=c.subsection','left');
		$this->db->join('classification i','i.classification_id=c.classification');
		$this->db->join('location j','j.location_id=c.location');
		$this->db->join('employment k','k.employment_id=c.employment');
		if($company!='All' AND !empty($company)){ $this->db->where('c.company_id',$company); }
		if($department!='All' AND !empty($department)){ $this->db->where('c.department',$department);  }
		if($section!='All' AND !empty($section)){  $this->db->where('c.section',$section); }
		if($location!='All' AND !empty($location)){  $this->db->where('c.location',$location); }
		if($classification!='All' AND !empty($classification)){  $this->db->where('c.classification',$classification); }
		if($employment!='All'){  $this->db->where('c.employment',$employment); }

		if($company!='All'){ $this->db->where('c.company_id',$company); }
		if($status=='All'){ $this->db->where('a.status!=','pending'); }  else { $this->db->where('a.status',$status); }
		$this->db->where('a.approver_id',$this->session->userdata('employee_id'));
		$this->db->where($where);
		
		$this->db->group_by(array("a.doc_no", "a.approval_level")); 
		$query = $this->db->get($table_name.'_approval a');

		return $query->result();
	}
}

