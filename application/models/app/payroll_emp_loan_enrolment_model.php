<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class payroll_emp_loan_enrolment_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	//list company
	public function payrollCompany()
	{
		$query = $this->db->get('company_info');
		return $query->result();
	}
	
	 public function pay_type_option()
	 {
	 	$this->db->select('*');
		$this->db->from('system_parameters');
		$this->db->where('cCode','cut_off');
	 	$pay_type_option = $this->db->get();
		return $pay_type_option->result();
	 }
	//employee list applied in loan 
	public function listAll($company,$loan,$status)
	{
		$this->db->select('company_name,department.dept_name,emp_loan_id,
							classification.classification,
							section.section_name,
							payroll_emp_loan_enrolment.pay_type_id,
							status,first_name,middle_name,last_name,employee_info.employee_id,
							payroll_emp_loan_enrolment.employee_id,loan_type,payroll_emp_loan_enrolment.company_id,payroll_emp_loan_enrolment.loan_type_id
							');
		$this->db->from('payroll_emp_loan_enrolment');
		$this->db->join("pay_type","pay_type.pay_type_id = payroll_emp_loan_enrolment.pay_type_id");
		$this->db->join("loan_type","loan_type.loan_type_id = payroll_emp_loan_enrolment.loan_type_id");
		$this->db->join("employee_info","employee_info.employee_id = payroll_emp_loan_enrolment.employee_id");
		$this->db->join("company_info","company_info.company_id = employee_info.company_id");
		$this->db->join("department","department.department_id = employee_info.department");
		$this->db->join("section","section.section_id = employee_info.section");
		$this->db->join("classification","classification.classification_id = employee_info.classification");
		if($company=='all'){} else{ $this->db->where('company_info.company_id',$company); }
		if($loan=='all'){} else{ $this->db->where('payroll_emp_loan_enrolment.loan_type_id',$loan); }
		if($status=='all'){} else{ $this->db->where('payroll_emp_loan_enrolment.status',$status); }
		$query_all = $this->db->get();
		return $query_all->result();
	}

	//company loan result 
	public function companyLoans_model($id)
	{
		$this->db->select('company_info.company_id,company_name,loan_type,loan_type.company_id,loan_type.loan_type_id');
		$this->db->from('company_info');
		$this->db->join("loan_type","loan_type.company_id = company_info.company_id");
		$this->db->where('company_info.company_id',$id);
		$query = $this->db->get();
        return $query->result();
	}
	//list of employees applied in loan/per company and loan
	public function result_allemp_model($company,$loan)
	{
		$this->db->select('date_effective,
							date_granted,
							loan_amt,
							amortization,
							principal_amt,
							ref_no,
							emp_loan_id,
							status,first_name,middle_name,last_name,employee_info.employee_id,
							payroll_emp_loan_enrolment.employee_id,loan_type,payroll_emp_loan_enrolment.company_id,payroll_emp_loan_enrolment.loan_type_id
							');
		$this->db->from('payroll_emp_loan_enrolment');
		$this->db->join("employee_info","employee_info.employee_id = payroll_emp_loan_enrolment.employee_id");
		$this->db->join("loan_type","loan_type.loan_type_id = payroll_emp_loan_enrolment.loan_type_id");
		$this->db->where("payroll_emp_loan_enrolment.status",'Active');
		$this->db->where("payroll_emp_loan_enrolment.company_id",$company);
		$this->db->where("payroll_emp_loan_enrolment.loan_type_id",$loan);
		
		$query_empall = $this->db->get();
		return $query_empall->result();
	}
	
	//loan name
	public function resultLoan_model($company,$loan)
	{
		$this->db->select('company_info.company_id as company_id,company_name,loan_type,loan_type.company_id,loan_type.loan_type_id');
		$this->db->from('company_info');
		$this->db->join("loan_type","loan_type.company_id = company_info.company_id");
		$this->db->where('company_info.company_id',$company);
		$this->db->where('loan_type.loan_type_id',$loan);
		$loanquery = $this->db->get();
		return $loanquery->result();
		
	}
	//check loan f existb
	public function check_loan_company($id)
	{
		$this->db->select('company_info.company_id,company_name,loan_type,loan_type.company_id,loan_type.loan_type_id');
		$this->db->from('company_info');
		$this->db->join("loan_type","loan_type.company_id = company_info.company_id");
		$this->db->where('company_info.company_id',$id);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			{
	    		return true; 
			}
			else{ return false; }

	}

	//pay type list
	public function paytypeList()
	{
		$query1 = $this->db->get('pay_type');
		return $query1->result();
	}

	//insert new employee
	public function insert_emp_loan($employee,$loan,$company,$d_eff,$d_granted,$l_amt,$amort,$principal_amt,$p_type,$option,$ref,$doc_no)
	{
		//$doc_number = $this->get_doc_number($doc_no);

		if(empty($doc_number)){ $doc = ""; } else{ $doc = $doc_number;  }
		$this->db->select('*');
		$this->db->from('payroll_emp_loan_enrolment');
		$this->db->where("payroll_emp_loan_enrolment.company_id",$company);
		$this->db->where("payroll_emp_loan_enrolment.loan_type_id",$loan);
		$this->db->where("payroll_emp_loan_enrolment.employee_id",$employee);
		$this->db->where("status != ",'Paid');
		$query = $this->db->get();
		$count_row = $query->num_rows();
		$option_result = substr_replace($option, "", -1);
		if($option_result=='1-2-3-4-5' AND $p_type=='1')
		{
			$option1 = '6';
		}
		else if($option_result=='1-2' AND $p_type=='2' || $p_type=='3')
		{
			$option1 = '6';
		}
		else{
			$option1=$option_result;
		}

		if($count_row == 0)
		{
			if($ref==null)
			{
				$ref='N/A';
			}
				$this->data = array(
						'loan_type_id'		=> $loan,
						'employee_id'		=> $employee,
						'company_id'		=> $company,
		                'option' 			=> $option1,
		                'date_effective'	=> $d_eff,
		                'date_granted' 		=> $d_granted,
		                'loan_amt' 			=> $l_amt,
		                'amortization' 		=> $amort,
		                'principal_amt' 			=> $principal_amt,
		                'ref_no' 			=> $ref,
		                'pay_type_id' 		=> $p_type,
		                'status'	 		=> 'Active',
		                'date_created' 		=> date('Y-m-d H:i:s'),
		                'approved_docno'	=> $doc_no
						);	
				$query = $this->db->insert('payroll_emp_loan_enrolment',$this->data);
				if($this->db->affected_rows() > 0)
				{
	    			return 'inserted'; 
				}
				else
					{ return 'error'; }
		}
		else{
			return "exist";
		}
	}

	//search employee result
	public function employeelist_model($search,$company_id)
	{
		
		$this->db->select('company_info.company_id as company_id,company_name,first_name,middle_name,last_name,employee_info.employee_id,employee_info.pay_type,pay_type_name');
		$this->db->from('company_info');
		$this->db->join("employee_info","employee_info.company_id = company_info.company_id");
		$this->db->join("pay_type","pay_type.pay_type_id = employee_info.pay_type");
		$this->db->where('company_info.company_id',$company_id);
		$this->db->where("(`last_name` LIKE '%$search%' OR  `first_name` LIKE '%$search%' OR  `employee_id`  LIKE '%$search%')");
		$this->db->order_by('last_name','asc');
		$query = $this->db->get();
		return $query->result();
	}

	///view employee loan record
	public function viewDetails_model($emp_loan_id,$loan,$company)
	{
		$this->db->select('date_effective,date_created,date_granted,loan_amt,amortization,principal_amt,ref_no,option,pay_type_name,emp_loan_id,department.dept_name,
							classification.classification,section.section_name,payroll_emp_loan_enrolment.pay_type_id,emp_loan_id,
							status,first_name,middle_name,last_name,employee_info.employee_id,payroll_emp_loan_enrolment.employee_id,loan_type,payroll_emp_loan_enrolment.company_id,
							payroll_emp_loan_enrolment.loan_type_id,fullname		
							');
		$this->db->from('payroll_emp_loan_enrolment');
		$this->db->join("pay_type","pay_type.pay_type_id = payroll_emp_loan_enrolment.pay_type_id");
		$this->db->join("loan_type","loan_type.loan_type_id = payroll_emp_loan_enrolment.loan_type_id");
		$this->db->join("employee_info","employee_info.employee_id = payroll_emp_loan_enrolment.employee_id");

		$this->db->join("department","department.department_id = employee_info.department");
		$this->db->join("section","section.section_id = employee_info.section");
		$this->db->join("classification","classification.classification_id = employee_info.classification");

		$this->db->where("payroll_emp_loan_enrolment.company_id",$company);
		$this->db->where("payroll_emp_loan_enrolment.loan_type_id",$loan);
		$this->db->where("payroll_emp_loan_enrolment.emp_loan_id",$emp_loan_id);
		$query = $this->db->get();
		return $query->result();
	}

	//update employee loan status
	public function updateStatus($status,$emp_loan_id,$loan,$company)
	{

		$this->data = array(
			'Status'				=>	$status
		);
		$this->db->where('emp_loan_id',$emp_loan_id);
		$this->db->where('company_id',$company);
		$this->db->where('loan_type_id',$loan);
		$this->db->update("payroll_emp_loan_enrolment",$this->data);
		if ($this->db->affected_rows() > 0)
		{
			return 'status_updated'; 
		}
		else{
			return 'status_error'; 
		}
	
	}

	//delete employee loan record

	public function deleteDetails($emp_loan_id,$loan,$company)
	{
		
		$this->db->where('emp_loan_id',$emp_loan_id);
		$this->db->where('company_id',$company);
		$this->db->where('loan_type_id',$loan);
		$this->db->delete("payroll_emp_loan_enrolment");

		if ($this->db->affected_rows() > 0)
		{
			$this->db->where('emp_loan_id',$emp_loan_id);
			$this->db->delete("payroll_emp_loan_enrolment_additional");

			return true; 
		}
		else{
			return false; 
		}
	}

	public function deleteDetails_additional($emp_loan_id,$loan,$company,$id)
	{
		$this->db->where('id',$id);
		$this->db->delete("payroll_emp_loan_enrolment_additional");

		if ($this->db->affected_rows() > 0)
		{
			return true; 
		}
		else{
			return false; 
		}
	}

	//filter status
	public function filter_result_model($status,$loan,$company)
	{
		$this->db->select('date_effective,
							date_granted,
							loan_amt,
							amortization,
							principal_amt,
							ref_no,
							status,first_name,middle_name,last_name,employee_info.employee_id,
							emp_loan_id,
							payroll_emp_loan_enrolment.employee_id,loan_type,payroll_emp_loan_enrolment.company_id,payroll_emp_loan_enrolment.loan_type_id
							');
		$this->db->from('payroll_emp_loan_enrolment');
		$this->db->join("employee_info","employee_info.employee_id = payroll_emp_loan_enrolment.employee_id");
		$this->db->join("loan_type","loan_type.loan_type_id = payroll_emp_loan_enrolment.loan_type_id");
		$this->db->where("payroll_emp_loan_enrolment.company_id",$company);
		$this->db->where("payroll_emp_loan_enrolment.loan_type_id",$loan);
		if($status=='All')
		{}
		else{
		$this->db->where("status",$status);
		}
		$query_empall = $this->db->get();
		return $query_empall->result();
	}

	//update employee record
	public function saveUpdate_model($emp_loan_id,$loan,$company,$loan_amt,$principal_amt,$date_effective,$pay_type,$pay_type_option,$amortization,$ref_no)
	{
		$option_result = substr_replace($pay_type_option, "", -1);
		if($option_result=='1-2-3-4-5' AND $pay_type=='1')
		{
			$option1 = '6';
		}
		else if($option_result=='1-2' AND $pay_type=='2' || $pay_type=='3')
		{
			$option1 = '6';
		}
		else{
			$option1=$option_result;
		}
		$this->data = array(
			'loan_amt'				=>	$loan_amt,
			'principal_amt'					=>	$principal_amt,
			'date_effective'		=>	$date_effective,
			'pay_type_id'			=>	$pay_type,
			'option'				=>	$option1,
			'amortization'			=>	$amortization,
			'ref_no'				=>	$ref_no

		);


		$this->db->where('emp_loan_id',$emp_loan_id);
		$this->db->where('company_id',$company);
		$this->db->where('loan_type_id',$loan);
		$this->db->update("payroll_emp_loan_enrolment",$this->data);

		if($this->db->affected_rows() > 0)
				{
	    			return 'updated'; 
				}
				else
					{ return 'error'; }
	}

	public function insertImport($data)
	{	

		$query = $this->db->insert('payroll_emp_loan_enrolment',$data);
				if($this->db->affected_rows() > 0)
				{
	    			return 'inserted'; 
				}
				else
					{ return 'error'; }
	}

	
	public function employee_checker_model($employee_checker,$company,$loan)
	{
		$this->db->select('employee_id,company_id,loan_type_id,status');
		$this->db->from('payroll_emp_loan_enrolment');
		$this->db->where('employee_id',$employee_checker);
		$this->db->where('company_id',$company);
		$this->db->where('loan_type_id',$loan);
		$this->db->where("status != ",'Paid');
		$query = $this->db->get();
		if($query->num_rows() > 0)
			{
	    		return true; 
			}
		else{ return false; }
	}

	
	public function employee_company_checker_model($employee_companylist,$company)
	{
		$this->db->select('employee_id,company_id');
		$this->db->from('employee_info');
		$this->db->where('employee_id',$employee_companylist);
		$this->db->where('company_id',$company);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			{
	    		return true; 
			}
			else{ return false; }
	}
	//f company exist
	public function company_checker_model($company)
	{

		$this->db->select('company_id');
		$this->db->from('company_info');
		$this->db->where('company_id',$company);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			{
	    		return true; 
			}
			else{ return false; }
	}


	//check employee pay type
	public function check_emp_paytype_model($emp)
	{
		$this->db->select('pay_type,employee_id');
		$this->db->from('employee_info');
		$this->db->where('employee_id',$emp);
		$query = $this->db->get();
		return  $query->row("pay_type");
	}

	public function employee_company_checke_ws_model($employee_companylist)
	{
		$this->db->select('employee_id,company_id');
		$this->db->from('employee_info');
		$this->db->where('employee_id',$employee_companylist);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			{
	    		return true; 
			}
			else{ return false; }
	}
	public function check_cutoff($val)
	{
		$this->db->where(array("cCode"=>'cut_off','cDesc'=>$val));
		$q = $this->db->get('system_parameters',1);
		return $q->row('cValue');
	}

	public function get_employeee_loans_request($loan,$company)
	{
		$where = '(a.status="approved")';
		$this->db->select('a.*,b.fullname,c.added_doc_no,c.emp_loan_id');
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->join('payroll_emp_loan_enrolment_additional c','c.added_doc_no=a.doc_no','left');
		$this->db->where(array('a.company_id'=>$company,'a.loan_type'=>$loan));
		$this->db->where($where);
		$query = $this->db->get('emp_loans a');

		return $query->result();
	}

	public function filter_forms($company,$loan,$status,$for_approved)
	{
		$this->db->select('a.*,b.fullname,d.loan_type_id,d.emp_loan_id');
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		if($status=='approved' AND $for_approved=='added')
		{
			$this->db->join('payroll_emp_loan_enrolment_additional c','c.added_doc_no=a.doc_no');
		}
		else if($status=='approved' AND $for_approved=='not_yet_added')
		{
			$this->db->where('a.doc_no NOT IN (select added_doc_no from payroll_emp_loan_enrolment_additional)',NULL,FALSE);

		}else{}
		$this->db->join('payroll_emp_loan_enrolment d','d.approved_docno=a.id','left');
		if($company=='all'){} else{ $this->db->where('a.company_id',$company); }
		if($loan=='all'){} else{ $this->db->where('a.loan_type',$loan); }
		if($status=='all'){} else{ $this->db->where('a.status',$status); }
		$query = $this->db->get('emp_loans a');

		return $query->result();
	}

	public function loan_details($id)
	{
		$this->db->join('loan_type b','b.loan_type_id=a.loan_type_id');
		$this->db->where('a.emp_loan_id',$id);
		$query = $this->db->get('payroll_emp_loan_enrolment a',1);
		return $query->result();
	}
	
	public function get_all_approved_forms($loan,$company)
	{
		$where = '(a.status="approved")';
		$this->db->select('a.*,b.fullname,c.added_doc_no');
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->join('payroll_emp_loan_enrolment_additional c','c.added_doc_no=a.doc_no','left');
		$this->db->where(array('a.company_id'=>$company,'a.loan_type'=>$loan,'a.loan_option'=>'additional'));
		$this->db->where($where);
		$query = $this->db->get('emp_loans a');
		return $query->result();
	}

	public function check_if_added_additional($doc_no)
	{
		$this->db->where('added_doc_no',$doc_no);
		$query = $this->db->get('payroll_emp_loan_enrolment_additional');
		return $query->result();
	}

	public function get_docno_details($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('emp_loans',1);
		return $query->row();
	}

	public function save_additional_loan($option,$doc,$amount,$desc,$reference,$loan_app,$loan_id,$loan_type,$company,$date_effective)
	{

		if($doc!='not_included')
		{
			$doc_number = $this->get_doc_number($doc);
		} else{ $doc_number ='not_included';}

	
		if($option=='forms'){ $d = 1; } else{ $d=0; }
		if($desc=='not_included'){$de = ''; } else{ $de=$this->convert_char($desc); }
		if($reference=='not_included'){$re = ''; } else{ $re=$reference; }
		if($loan_app=='not_included'){$lo = ''; } else{ $lo=$loan_app; }
		$data = array('emp_loan_id'=>$loan_id,
					  'loan_amount' =>$amount,
					  'app_num' =>$lo,
					  'description' =>$de,
					  'reference_no' =>$re,
					  'if_approved_forms' =>$d,
					  'added_doc_no' =>$doc_number,
					  'added_by' =>$this->session->userdata('employee_id'),
					  'date_added' => date('Y-m-d H:i:s'),
					  'date_effective'	=>	$date_effective,
					  'pstatus'	=>	'Active'
					  );
		$this->db->insert('payroll_emp_loan_enrolment_additional',$data);

		if($this->db->affected_rows() > 0)
				{
	    			return 'inserted'; 
				}
				else
				{ return 'error'; }

	}

	public function get_doc_number($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('emp_loans',1);
		return $query->row('doc_no');
	}

	public function get_all_additional_loans($id)
	{
		$this->db->where('emp_loan_id',$id);
		$this->db->order_by('date_added','ASC');
		$query = $this->db->get('payroll_emp_loan_enrolment_additional');
		return $query->result();
	}
	public function total_employee_loan($id)
	{
		$this->db->where('emp_loan_id',$id);
		$query = $this->db->get('payroll_emp_loan_enrolment');
		if(empty($query->row('loan_amt')))
		{
			$query_one="0";
		}else{ $query_one = $query->row('loan_amt');  }
		

		$this->db->select('SUM(loan_amount) AS total');
		$this->db->where('emp_loan_id',$id);
		$queryt = $this->db->get('payroll_emp_loan_enrolment_additional');
		if(empty($queryt->row('total')))
		{
			$query_t="0";
		}else{ $query_t = $queryt->row('total');  }

		$total = $query_one + $query_t;
		return $total;
	}

	public function get_approved_form_details($id)
	{
		$this->db->select('a.*,b.fullname,b.pay_type');
		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$this->db->where('a.id',$id);
		$query = $this->db->get('emp_loans a');

		return $query->result();

	}

	public function details_additional($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('payroll_emp_loan_enrolment_additional',1);
		return $query->result();
	}

	public function saveUpdate_additional($amount,$desc,$loan_app,$reference,$emp_loan_id,$loan,$company,$addloan_id)
	{
		if($desc=='not_included') { $description =""; } else{ $description = $this->convert_char($desc); }
		if($loan_app=='not_included'){ $loanapp=""; } else{ $loanapp=$loan_app; }
		if($reference=='not_included'){ $ref=""; } else{ $ref=$reference; }

		$this->db->where('id',$addloan_id);
		$query = $this->db->update('payroll_emp_loan_enrolment_additional',array('loan_amount'=>$amount,'app_num'=>$loan_app,'description'=>$description,'reference_no'=>$ref));

		if($this->db->affected_rows() > 0)
		{
	    	return 'updated'; 
		}
		else
		{ return 'error'; }
	}

	public function check_id_added($doc)
	{
		$this->db->where('added_doc_no',$doc);
		$query = $this->db->get('payroll_emp_loan_enrolment_additional');

		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			$this->db->where('approved_docno',$doc);
			$query1 = $this->db->get('payroll_emp_loan_enrolment');
			return $query1->row();
		}
		
	}

	public function enable_disable($emp_loan_id,$loan,$company,$action,$option,$idd)
	{
		if($option=='Main')
		{
			$this->db->where('emp_loan_id',$emp_loan_id);
			$update = $this->db->update('payroll_emp_loan_enrolment',array('status'=>$action));
		}
		else
		{
			$this->db->where('id',$idd);
			$update = $this->db->update('payroll_emp_loan_enrolment_additional',array('pstatus'=>$action));
		}

		if($this->db->affected_rows() > 0)
		{
	    	return 'updated_'.$action; 
		}
		else
		{ return 'error'; }
		
	}

	public function get_company_loantype($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('loan_type');
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

// ============= start loan ledger
	public function GetMotherLoan($emp_loan_id){
		$query=$this->db->query("SELECT a.*,b.loan_type as loan_type_name,c.last_name,c.first_name FROM payroll_emp_loan_enrolment a INNER JOIN loan_type b on(a.loan_type_id=b.loan_type_id) INNER JOIN masterlist c on(a.employee_id=c.employee_id) WHERE a.emp_loan_id='".$emp_loan_id."' ");	
			return $query->row();	
	}

	public function GetAdditionalLoan($emp_loan_id){
		$query=$this->db->query("SELECT * FROM payroll_emp_loan_enrolment_additional WHERE emp_loan_id='".$emp_loan_id."' ");
		return $query->result();	
	}

	public function GetPaymentHistory($loan_id){
			$query=$this->db->query("select a.*,b.complete_from,b.complete_to from union_payslip_loan_mm_tables a 
				inner join payroll_period b on(a.payroll_period_id=b.id)
				where a.emp_loan_id='".$loan_id."' order by b.complete_from,year_cover ASC");
			return $query->result();	
	}

	public function VerifyBeforeEdit($emp_loan_id){// verify if merun ng posted.
		
			$query=$this->db->query("select system_deduction FROM union_payslip_loan_mm_tables WHERE emp_loan_id='".$emp_loan_id."' limit 1");
			return $query->row();			
	}

// ============= end loan ledger

	
	public function insert_loan($loan,$company,$employee_id,$loan_amount,$amortization,$date_effective,$date_granted,$cutoff,$reference_no,$result,$principal_amt)
	{
		$status ='Active';
		$date_created = date('Y-m-d H:i:s');

		

		 $data = array('employee_id'  => $employee_id,
						'company_id'  		=> $company,
						'loan_type_id'  	=> $loan,
						'pay_type_id'  		=> $result,
						'date_effective'  	=> $date_effective,
						'date_granted'  	=> $date_granted,
						'loan_amt'  		=> $loan_amount,
						'amortization'  	=> $amortization,
						'principal_amt'  	=> $principal_amt,
						'ref_no'  			=> $reference_no,
						'status'  			=> $status,
						'option'			=> $cutoff,
						'date_created'		=> $date_created
		);

		$this->db->where(array('employee_id'=>$employee_id,'status'=>$status,'loan_type_id'=>$loan));
		$query = $this->db->get('payroll_emp_loan_enrolment');
		if($query->num_rows() > 0)
		{
			$this->db->where(array('employee_id'=>$employee_id,'status'=>$status,'loan_type_id'=>$loan));
			$query = $this->db->delete('payroll_emp_loan_enrolment');
			if($this->db->affected_rows() > 0)
				{
					$query = $this->db->insert('payroll_emp_loan_enrolment',$data);
					if($this->db->affected_rows() > 0)
					{
		    			return 'inserted'; 
					}
					else
					{ return 'error'; }
				}
		}
		else
		{
				$query = $this->db->insert('payroll_emp_loan_enrolment',$data);
				if($this->db->affected_rows() > 0)
				{
	    			return 'inserted'; 
				}
				else
				{ return 'error'; }
		}

	}



	//checker mass uploading

	public function mass_check_company($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('company_info',1);
		if($query->num_rows() > 0)
			{
	    		return '<br>('.$query->row('company_name').')'; 
			}
			else{ return false; }
	}

	public function mass_check_employee($employee_id,$company_id)
	{
		$this->db->where(array('employee_id'=>$employee_id,'company_id'=>$company_id));
		$query = $this->db->get('employee_info',1);
		if($query->num_rows() > 0)
			{
				$name = $query->row('first_name').' '.$query->row('last_name');
	    		return '<br>('.$name.')'; 
			}
			else{ return false; }
	}

	public function mass_check_loan_type($company_id,$loan_type)
	{
		$this->db->where(array('company_id'=>$company_id,'loan_type_id'=>$loan_type));
		$query = $this->db->get('loan_type',1);
		if($query->num_rows() > 0)
			{
				$loan = $query->row('loan_type');
	    		return '<br>('.$loan.')'; 
			}
			else{ return false; }
	}

	public function get_loan_cutof($cutoff)
	{
		$this->db->where(array('cCode'=>'cut_off','cDesc'=>$cutoff));
		$query = $this->db->get('system_parameters',1);
		return '<br>('.$query->row('cValue').')';
	}

	public function insert_loan_mass_upload($loan,$company,$employee_id,$loan_amount,$amortization,$date_effective,$date_granted,$cutoff,$reference_no,$result,$principal_amount)
	{
		$status ='Active';
		$date_created = date('Y-m-d H:i:s');

		

		 $data = array('employee_id'  => $employee_id,
						'company_id'  		=> $company,
						'loan_type_id'  	=> $loan,
						'pay_type_id'  		=> $result,
						'date_effective'  	=> $date_effective,
						'date_granted'  	=> $date_granted,
						'loan_amt'  		=> $loan_amount,
						'amortization'  	=> $amortization,
						'principal_amt'  	=> $principal_amount,
						'ref_no'  			=> $reference_no,
						'status'  			=> $status,
						'option'			=> $cutoff,
						'date_created'		=> $date_created
		);

		$this->db->where(array('employee_id'=>$employee_id,'status'=>$status,'loan_type_id'=>$loan));
		$query = $this->db->get('payroll_emp_loan_enrolment');
		if($query->num_rows() > 0)
		{
			$this->db->where(array('employee_id'=>$employee_id,'status'=>$status,'loan_type_id'=>$loan));
			$query = $this->db->delete('payroll_emp_loan_enrolment');
			if($this->db->affected_rows() > 0)
				{
					$query = $this->db->insert('payroll_emp_loan_enrolment',$data);
					if($this->db->affected_rows() > 0)
					{
		    			return 'inserted'; 
					}
					else
					{ return 'error'; }
				}
		}
		else
		{
				$query = $this->db->insert('payroll_emp_loan_enrolment',$data);
				if($this->db->affected_rows() > 0)
				{
	    			return 'inserted'; 
				}
				else
				{ return 'error'; }
		}
	}
}		