<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Report_recruitments_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
		$this->load->model("recruitment_employer/recruitment_employer_management_model");
	}

	public function get_crystal_reports($code,$employer_type)
	{	
		if($employer_type=='hris'){ $this->db->where('forPublic_company_id',Null); } 
		else 
		{
			$company_id = $this->recruitment_employer_management_model->get_companyinfo($this->session->userdata('employer_username'));
			$this->db->where('forPublic_company_id',$company_id); 
		}
		$this->db->where('type',$code);
		$query = $this->db->get('crystal_report_recruitments');
		return $query->result();
	}

	public function crystal_report_fields($code_type,$code)
	{
		if($code=='A2' || $code=='A7'){ $code='A2'; }
		else { $code= $code; }
		

		$this->db->where(array('type'=>$code_type,'code'=>$code));
		$query = $this->db->get('crystal_report_recruitments_fields');
		$q = $query->result();

		$this->db->where(array('type'=>$code_type,'code'=>'D'));
		$query_ = $this->db->get('crystal_report_recruitments_fields');
		$q_ = $query_->result();

		return array_merge($q_,$q);
	}

	public function save_crystal_report($code,$code_type,$name_final,$description_final,$data,$employer_type)
	{	
		$title = $this->convert_char($name_final);
		$desc = $this->convert_char($description_final);
		
		$datas = array(
						'type'	   		   =>		$code,
						'code'  		   =>		$code_type,
						'title'			   =>		$title,
						'description'	   =>		$desc,
						'date_created'	   =>		date('Y-m-d H:i:s'),
						'added_by'		   =>		$this->session->userdata('employee_id'),
						'InActive'		   =>		0
					);

		$this->db->insert('crystal_report_recruitments',$datas);
		$c_id  = $this->db->insert_id();

		 if($this->session->userdata('is_logged_in')){} 
		 else { 
		 		$company_id = $this->recruitment_employer_management_model->get_companyinfo($this->session->userdata('employer_username')); 
				$this->db->where('id',$c_id);
				$this->db->update('crystal_report_recruitments',array('forPublic_company_id'=>$company_id));
		 } 

		$a 	= substr_replace($data, "", -1);
		$array =  explode('-', $a);


		foreach($array as $aa)
			{
				$dataa = array( 'crystal_id'	=>	$c_id,
								'field_id'		=> $aa,
								'date_created'	=>date('Y-m-d H:i:s')
						);
				$this->db->insert('crystal_report_recruitments_list',$dataa);
			}
		
	}

	public function update_crystal_report($code,$code_type,$name_final,$description_final,$data,$employer_type,$crystal_id)
	{

		$this->db->where('crystal_id',$crystal_id);
		$this->db->delete('crystal_report_recruitments_list');

		$title = $this->convert_char($name_final);
		$desc = $this->convert_char($description_final);
		

		$datas = array(
						'type'	   		   =>		$code,
						'code'  		   =>		$code_type,
						'title'			   =>		$title,
						'description'	   =>		$desc,
						'InActive'		   =>		0
					);
		$this->db->where('id',$crystal_id);
		$this->db->update('crystal_report_recruitments',$datas);
		
		
		$a 	= substr_replace($data, "", -1);
		$array =  explode('-', $a);


		foreach($array as $aa)
			{
				$dataa = array( 'crystal_id'	=>	$crystal_id,
								'field_id'		=> $aa,
								'date_created'	=>date('Y-m-d H:i:s')
						);
				$this->db->insert('crystal_report_recruitments_list',$dataa);
			}
	}	

	public function crystal_report_details($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('crystal_report_recruitments');
		return $query->row();
	}

	public function check_if_selected($crystal_id,$id)
	{
		$this->db->where(array('crystal_id'=>$crystal_id,'field_id'=>$id));
		$query = $this->db->get('crystal_report_recruitments_list');
		return $query->num_rows();
	}

	public function stat_crystal_report($action,$id)
	{

		if($action=='enable')
		{
			$this->db->where('id',$id);
			$query = $this->db->update('crystal_report_recruitments',array('InActive'=>0));
		}
		else if($action=='disable')
		{
			$this->db->where('id',$id);
			$query = $this->db->update('crystal_report_recruitments',array('InActive'=>1));
		}
		else
		{
			$this->db->where('id',$id);
			$this->db->delete('crystal_report_recruitments');

			$this->db->where('crystal_id',$id);
			$this->db->delete('crystal_report_recruitments_list');
		}
	}

	public function get_crystal_report($type,$employer_type)
	{	
		if($employer_type=='public')
		{
			$company_id = $this->recruitment_employer_management_model->get_companyinfo($this->session->userdata('employer_username'));
			$this->db->where('forPublic_company_id',$company_id);
		}
		else
		{
			$this->db->where('forPublic_company_id',Null);
		}
		$this->db->where('code',$type);
		$query = $this->db->get('crystal_report_recruitments');
		return $query->result();

	}

	public function get_crystal_report_fields($crystal_report)
	{	
		$this->db->join('crystal_report_recruitments_fields b','b.id=a.field_id');
		$this->db->where('a.crystal_id',$crystal_report);
		$query = $this->db->get('crystal_report_recruitments_list a');

		return $query->result();
	}

	public function get_generate_reports_results($code,$employer_type,$code_type,$company_id)
	{

		if($code_type=='S1')
		{
			$this->db->join('company_info b','b.company_id=a.company_id');
			$this->db->where('a.type',$employer_type);
			if($company_id=='All'){} else{ $this->db->where('a.company_id',$company_id); } 
			$que = $this->db->get('recruitment_employer_job_requirements a');
			$query = $que->result();
		}
		else if($code_type=='S2')
		{
			
			$this->db->join('company_info b','b.company_id=a.company_id');
			if($company_id=='All'){} else{ $this->db->where('a.company_id',$company_id); }
			$que = $this->db->get('recruitment_applicant_status_option a');
			$query_res = $que->result();

			
			$this->db->join('company_info b','b.company_id=a.company_id','left');
			$this->db->where('a.IsDefault',1);
			$query_ = $this->db->get('recruitment_applicant_status_option a');
			$query_res_ = $query_->result();

			$query = array_merge($query_res_,$query_res);
			
			foreach($query as $res)
			{
				$res->company_id =  $company_id;
				$res->company_name =  $this->get_company_name($company_id);
			}

		}
		else if($code_type=='S3')
		{
			$this->db->select('a.*,b.company_id as company_id, b.company_name as company_name');
			$this->db->join('company_info b','b.company_id=a.company_id');
			if($company_id=='All'){} else{ $this->db->where('a.company_id',$company_id); } 
			$que = $this->db->get('recruitment_status_interview_numbering a');
			$query = $que->result();
		}
		else if($code_type=='S4')
		{
			$this->db->select('a.*,b.company_id as company_id, b.company_name as company_name');
			$this->db->join('company_info b','b.company_id=a.company_id');
			if($company_id=='All'){} else{ $this->db->where('a.company_id',$company_id); } 
			$que = $this->db->get('qualifying_questions a');
			$query = $que->result();
		}
		else if($code_type=='S5')
		{
			$this->db->select('a.*,b.company_id as company_id, b.company_name as company_name');
			$this->db->join('company_info b','b.company_id=a.company_id');
			$this->db->where('a.question_type','hypothetical');
			if($company_id=='All'){} else{ $this->db->where('a.company_id',$company_id); } 
			$que = $this->db->get('preliminary_questions a');
			$query = $que->result();
		}
		else if($code_type=='S6')
		{
			$this->db->select('a.*,b.company_id as company_id, b.company_name as company_name');
			$this->db->join('company_info b','b.company_id=a.company_id');
			$this->db->where('a.question_type','multiple_choice');
			if($company_id=='All'){} else{ $this->db->where('a.company_id',$company_id); } 
			$que = $this->db->get('preliminary_questions a');
			$query = $que->result();
		}
		else if($code_type=='S7')
		{
			$this->db->select('a.*,b.company_id as company_id, b.company_name as company_name');
			$this->db->join('company_info b','b.company_id=a.company_id');
			if($employer_type=='hris'){ $this->db->where('a.for_employer',Null); }
			else{ $this->db->where('a.for_employer!=',''); }
			if($company_id=='All'){} else{ $this->db->where('a.company_id',$company_id); } 
			$que = $this->db->get('recruitment_email_setting a');
			$query = $que->result();
		}
		else if($code_type=='S8')
		{
			$this->db->select('c.data,b.company_id as company_id, b.company_name as company_name');
			$this->db->join('recruitment_employer_default_singlefield_data c','c.default_id=a.id');	
			$this->db->join('company_info b','b.company_id=c.company_id');
			if($company_id=='All'){} else{ $this->db->where('b.company_id',$company_id); } 
			$this->db->where('a.code','ED8');
			$que = $this->db->get('recruitment_employer_default_settings a');
			$query = $que->result();
			
		}
		else if($code_type=='S9')
		{
			$this->db->select('c.data,b.company_id as company_id, b.company_name as company_name');
			$this->db->join('recruitment_employer_default_singlefield_data c','c.default_id=a.id');	
			$this->db->join('company_info b','b.company_id=c.company_id');
			if($company_id=='All'){} else{ $this->db->where('b.company_id',$company_id); } 
			$this->db->where('a.code','ED3');
			$que = $this->db->get('recruitment_employer_default_settings a');
			$query = $que->result();
		}
		else
		{

		}

		return $query;
	}

	public function get_cities($id)
	{
		if($id=='All'){} else{ $this->db->where('province_id',$id); }
		$query = $this->db->get('cities');
		return $query->result();
	}

	public function get_job_vacancy_reports($option,$employer_type)
	{
		if($employer_type=='hris'){ $this->db->where('forPublic_company_id',Null); } 
		else 
		{
			$company_id = $this->recruitment_employer_management_model->get_companyinfo($this->session->userdata('employer_username'));
			$this->db->where('forPublic_company_id',$company_id); 
		}
		if($option=='VR2')
		{
			$this->db->where('code','V2');
		}
		else
		{
			$this->db->where('code','V1');
		}
		$query =  $this->db->get('crystal_report_recruitments');
		return $query->result();
	}

	public function get_positions($employer_type)
	{
		$query = $this->db->get('position');
		return $query->result();
	}

















	//analytics report
	public function analytics_crystal_report($code,$employer_type)
	{ 
		if($employer_type=='hris')
		{
			$this->db->where('forPublic_company_id',Null);
		}
		else
		{
			$company_id = $this->recruitment_employer_management_model->get_companyinfo($this->session->userdata('employer_username'));
			$this->db->where('forPublic_company_id',$company_id);
		}
		$this->db->where(array('type'=>'CRR4','code'=>$code));
		$query_ = $this->db->get('crystal_report_recruitments');
		$q_ = $query_->result();
		return $q_;
	}

	public function analytics_crystal_report_fields($crystal_report)
	{
		$this->db->join('crystal_report_recruitments_fields b','b.id=a.field_id');
		$this->db->where('a.crystal_id',$crystal_report);
		$query = $this->db->get('crystal_report_recruitments_list a');
		return $query->result();
	}

	public function analytics_A1()
	{
		 $companyy = $this->input->post('company');
		 $date_from = $this->input->post('date_from');
		 $date_to = $this->input->post('date_to');
		 $date_range_option = $this->input->post('date_range_option');

		 if($companyy=='All')
		 {
		 		$company = $this->general_model->companyList();

				foreach($company as $c)
				{
				 	$vacancy = $this->get_job_vacancy($c->company_id,$date_from,$date_to,$date_range_option);
				 	$c->total_vacancy =$vacancy[1];
				 	$c->total_include = $vacancy[0] +0;
				 	$c->total_job_vacancy = $vacancy[2];
				}
		 }
		 else if($companyy=='Multiple')
		 {
		 	 	$company_ = $this->input->post('companymultiple_list');
		 	 	$cc = substr_replace($company_, "", -1);

		 		$company = $this->companyList_multiple($cc);	
				foreach($company as $c)
				{
					$vacancy = $this->get_job_vacancy($c->company_id,$date_from,$date_to,$date_range_option);
				 	$c->total_vacancy =$vacancy[1];
				 	$c->total_include = $vacancy[0] +0;
				 	$c->total_job_vacancy = $vacancy[2];
				}
		 }
		 else
		 {
		 		$company = $this->companyList_multiple($companyy);	
				foreach($company as $c)
				{
					$vacancy = $this->get_job_vacancy($c->company_id,$date_from,$date_to,$date_range_option);
				 	$c->total_vacancy =$vacancy[1];
				 	$c->total_include = $vacancy[0] +0;
				 	$c->total_job_vacancy = $vacancy[2];
				}
		 }
		 return $company;	
	}

	public function companyList_multiple($cc)
	{
		$where = $this->get_condition_($cc,'company_id');
		$this->db->where($where);
		$query = $this->db->get('company_info');
		return $query->result();
	}

	public function get_job_vacancy($company,$date_from,$date_to,$date_range_option)
	{

		$where = "date(".$date_range_option.") between '" .$date_from. "' and '" .$date_to. "'";
			
		$this->db->select("*");
		$this->db->where("company_id",$company);
		$this->db->where($where);	
		$query = $this->db->get("jobs");
		$query_res = $query->result();

		$string_l="";
		$count = 0;
		foreach($query_res as $a)
		{
			$aa = $a->job_vacancy;
          	$ddd = "job_id"."=".$a->job_id." or ";
            $string_l .= $ddd;
			$count = $count + $aa;
		}

		$res_l = substr($string_l, 0, -3);
		$where_l = "(".$res_l.")";

		$get_setting = $this->get_include_in_vacancy_computation($company);
	
		if($where_l=='()'){ $final_count = 0; $query_hired_count  ='';} 
		else { 
			$this->db->where($where_l); 
			$this->db->where(array('company_id'=>$company));
			if(empty($get_setting)){} else{ $this->db->where($get_setting); }
			$query_hired = $this->db->get('applicant_job_application');
			$query_hired_count = $query_hired->num_rows();
			$final_count = $count - $query_hired_count;
		}
		
		return array($query_hired_count,$final_count,$count);
	}

	public function get_include_in_vacancy_computation($company)
	{
		$this->db->where(array('company_id'=>$company,'include_in_computation_job_vacancy'=>1));
		$query = $this->db->get('recruitment_status_option_numbering');
		$result = $query->result();
		if(empty($result))
		{
			return '';
		}
		else
		{	
			$string_l='';
			foreach($result as $res)
			{
				$ddd = "ApplicationStatus"."=".$res->status_id." or ";
           		$string_l .= $ddd;
			}

			$res_l = substr($string_l, 0, -3);
			return $res_l;
		}
	}



	//Analytics A2
	public function analytics_A2()
	{
		$company = $this->input->post('company');
		$position = $this->input->post('position');

		$date_from = $this->input->post('date_from');
	    $date_to = $this->input->post('date_to');
	    $date_range_option = $this->input->post('date_range_option');

		$where = "date(".$date_range_option.") between '" .$date_from. "' and '" .$date_to. "'";
		$this->db->where($where);
		if($position=='All')
		{
			
			$this->db->where('a.company_id',$company);
		}
		else if($position=='Multiple')
		{
			$poss = $this->input->post('positionmultiple_list');
			$pos = substr_replace($poss, "", -1);
			$wheree = $this->get_condition_($pos,'a.job_id');
			$this->db->where($wheree);	
		}
		else
		{
			$this->db->where('a.job_id',$position);
		}
		$this->db->join('company_info c','c.company_id=a.company_id');
		$query = $this->db->get('jobs a');
		$res = $query->result();
		
		foreach($res as $r)
		{
			$count = $this->job_vacancy_per_position_count($company,$r->job_id);
			$r->vacancy_count = $count[0];
			$r->tota_job_vacancy = $count[1];
			$r->total_include = $count[2];
			$r->location = 'location';
		}
		return $res;
	}

	public function get_condition_($option,$val)
	{
		$location =  explode('-', $option);
		$string_l="";
		foreach($location as $a)
            { 	 
            	$dd = $val.'="'.$a.'" or ';
                $string_l .= $dd;
            }
        $res_l = substr($string_l, 0, -4);
        $where_l = "(".$res_l.")";
        return $where_l;
	}

	public function job_vacancy_per_position_count($company,$job_id)
	{
		$this->db->select("job_vacancy");
		$this->db->where(array("company_id"=>$company,'job_id'=>$job_id));
		$query = $this->db->get("jobs");
		$query_res = $query->result();

		$count = 0;
		foreach($query_res as $a)
		{
			$a = $a->job_vacancy;
			$count = $count + $a;
		}
		
		$this->db->join('jobs b','b.job_id=a.job_id');
		$this->db->where(array('a.company_id'=>$company,'a.ApplicationStatus'=>3,'a.job_id'=>$job_id));
		$query_hired = $this->db->get('applicant_job_application a');
		$query_hired_count = $query_hired->num_rows();

		$final_count = $count - $query_hired_count;
		return array($final_count,$count,$query_hired_count);
	}

	//analytics 3

	public function analytics_A3()
	{
		$month_from = $this->input->post('month_from');
		$year = $this->input->post('year');
		$month_to = $this->input->post('month_to');
		$company = $this->input->post('company');

		$application_status = $this->input->post('application_status');

		$monthss = '';
		$counts = '';
		$mm = array();

		for($i=$month_from; $i <=$month_to;$i++)
		{
			if($i==2){ $month = 'February'; $mcount='0'.$i; }
			else if($i==3){ $month  = 'March';  $mcount='0'.$i; }
			else if($i==4){ $month  = 'April'; $mcount='0'.$i; }
			else if($i==5){ $month  = 'May'; $mcount='0'.$i; }
			else if($i==6){ $month  = 'June'; $mcount='0'.$i; }
			else if($i==7){ $month  = 'July'; $mcount='0'.$i; }
			else if($i==8){ $month  = 'August'; $mcount='0'.$i; }
			else if($i==9){ $month  = 'September'; $mcount='0'.$i; }
			else if($i==10){ $month = 'October'; $mcount=$i;}
			else if($i==11){ $month = 'November'; $mcount=$i;}
			else if($i==12){ $month = 'December'; $mcount=$i;}
			else{ $month = 'January'; $mcount='0'.$i;}

			$r= $this->count_hired_applicants($mcount,$company,$year,$application_status);
			$counts.= $r."-";
			$monthss .= $month."-";
		}
		$results_month =  substr($monthss, 0, -1);
		$results_count =  substr($counts, 0, -1);
		return array($results_month,$results_count);
	
	}


	public function count_hired_applicants($month,$company,$year,$application_status)
	{
		$get_setting = $this->get_include_in_vacancy_computation($company);
		
		$this->db->where('YEAR(application_date_update)',$year);
		$this->db->where('MONTH(application_date_update)',$month);
		$this->db->where('company_id',$company);
		if($application_status=='hired_status')
		{
			$this->db->where('ApplicationStatus',3);
		}	
		else
		{	
			$this->db->where($get_setting);
		}
		$query = $this->db->get('applicant_job_application');

		return $query->num_rows();
	}

	public function get_company_info($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('company_info');
		return $query->row();
	}


	//analytics 5

	public function analytics_A5()
	{
		$company = $this->input->post('company');
		$position = $this->input->post('position');

		$date_from = $this->input->post('date_from');
	    $date_to = $this->input->post('date_to');
	    $date_range_option = $this->input->post('date_range_option');

		$where = "date(".$date_range_option.") between '" .$date_from. "' and '" .$date_to. "'";
		$this->db->where($where);
		$this->db->where('a.company_id',$company);

		if($position=='All')
		{
		}
		else if($position=='Multiple')
		{
			$poss = $this->input->post('positionmultiple_list');
			$pos = substr_replace($poss, "", -1);
			$where = $this->get_condition_($pos,'a.job_id');
			$this->db->where($where);
		}
		else
		{
			$this->db->where('a.job_id',$position);
		}
		$this->db->join('company_info b','b.company_id=a.company_id');
		$query = $this->db->get('jobs a');
		$res = $query->result();
		
		foreach($res as $r)
		{
			$count = $this->analytics_pooled_applicants_count($company,$r->job_id);
			$r->vacancy_count = $count;
			$r->location = 'location';
		}

		return $res;
	}

	public function analytics_pooled_applicants_count($company,$job_id)
	{
		$this->db->join('jobs b','b.job_id=a.job_id');
		$this->db->where(array('b.company_id'=>$company,'b.job_id'=>$job_id));
		$query = $this->db->get('applicant_job_application a');
		return $query->num_rows();
	}




	//job vacancies filtering

	public function get_positions_by_date_range($company_id,$datefrom,$dateto)
	{
		$where = "date(date_approved) between '" .$datefrom. "' and '" .$dateto. "'";
		$this->db->where($where);
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('jobs');
		return $query->result();
	}

	public function get_results_filtering_VR1($slotfrom,$slotto,$salaryfrom,$salaryto,$startfro,$startto,$endfrom,$endto,$loccity,	$locprovince,$company,$status,$job_id,$date_posted_from,$date_posted_to)
	{	
		$where = "date(a.date_approved) between '" .$date_posted_from. "' and '" .$date_posted_to. "'";
		$where_end = "date(a.hiring_end) between '" .$endfrom. "' and '" .$endto. "'";
		$where_start = "date(a.hiring_start) between '" .$startfro. "' and '" .$startto. "'";

		$where_slot = "a.job_vacancy between " .$slotfrom. " and " .$slotto. "";
		$where_salary = "a.salary between " .$salaryfrom. " and " .$salaryto. "";


		$this->db->join('company_info b','b.company_id=a.company_id');
		$this->db->join('provinces c','c.id=a.loc_province');
		$this->db->join('cities d','d.id=a.loc_city');

		if($slotfrom=='all'){} 
		else {
			
			$this->db->where($where_slot);
		}

		if($salaryfrom=='all'){} 
		else{ 
			$this->db->where($where_salary);
		}

		if($startfro=='all'){} 
		else{
			$this->db->where($where_start);
		}

		if($endfrom=='all'){} 
		else{
			$this->db->where($where_end);
		}

		if($loccity=='all'){} 
		else{
			if($loccity=='All'){ } else { $this->db->where('a.loc_city',$loccity); }
			if($locprovince=='All'){ } else { $this->db->where('a.loc_province',$locprovince); }
		}


		if($status=='all'){} 
		else{
			$this->db->where('a.status',$status);
		}

		if($job_id=='all'){ $this->db->where($where); } 
		else{
			$this->db->where('a.job_id',$job_id);
		}
		$this->db->where('a.company_id',$company);
		$query = $this->db->get('jobs a');
		return $query->result();
	}


	public function get_results_filtering_VR2($company,$job_id,$date_posted_from,$date_posted_to,$crystal_report,$code,$employer_type)
	{
		$where = "date(c.date_approved) between '" .$date_posted_from. "' and '" .$date_posted_to. "'";

		$this->db->join('employee_info_applicant b','b.id=a.employee_info_id');
		$this->db->join('jobs c','c.job_id=a.job_id');
		$this->db->join('recruitment_applicant_status_option d','d.id=a.ApplicationStatus','left');
		$this->db->join('company_info e','e.company_id=a.company_id');
		if($employer_type=='hris')
		{
			$this->db->where('e.is_this_recruitment_employer',0);
		}
		else
		{
			$this->db->where('a.company_id',$company);
		}
		if($job_id=='all'){ $this->db->where($where); } 
		else{
			$this->db->where('a.job_id',$job_id);
		}

		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}

	public function get_results_ids($table,$idd,$id,$val)
	{
		$this->db->where($idd,$id);
		$query =  $this->db->get($table);
		$data = $query->row($val);
		if(empty($data)){ return ''; }
		else{ return $data; }
	}

	public function get_results_filtering_VR3($company,$status,$job_id,$date_posted_from,$date_posted_to,$crystal_report)
	{
		$where = "date(a.date_approved) between '" .$date_posted_from. "' and '" .$date_posted_to. "'";
		
		$this->db->join('company_info b','b.company_id=a.company_id');
		$this->db->join('provinces c','c.id=a.loc_province');
		$this->db->join('cities d','d.id=a.loc_city');
		$this->db->where('a.company_id',$company);
		if($status=='all'){} else{ $this->db->where('a.status',$status); }
		if($job_id=='all'){ $this->db->where($where); } else{ $this->db->where('a.job_id',$job_id); }

		$query = $this->db->get('jobs a');
		return $query->result();	
	}

	public function get_results_filtering_VR4($company,$job_id,$date_posted_from,$date_posted_to)
	{
		$where = "date(a.date_approved) between '" .$date_posted_from. "' and '" .$date_posted_to. "'";
		$date = date('Y-m-d');

		$this->db->join('company_info b','b.company_id=a.company_id');
		$this->db->join('provinces c','c.id=a.loc_province');
		$this->db->join('cities d','d.id=a.loc_city');
		$this->db->where('a.company_id',$company);
		$this->db->where('a.hiring_end >=',$date);
		$this->db->where('a.hiring_start <=',$date);
		if($job_id=='all'){ $this->db->where($where); } else{ $this->db->where('a.job_id',$job_id); }

		$query = $this->db->get('jobs a');
		return $query->result();
	}

	public function get_results_filtering_VR5($company,$job_id,$date_posted_from,$date_posted_to,$crystal_report,$code_type,$employer_type)
	{
		$where = "date(a.date_approved) between '" .$date_posted_from. "' and '" .$date_posted_to. "'";
		$date = date('Y-m-d');

		$this->db->join('company_info b','b.company_id=a.company_id');
		$this->db->join('provinces c','c.id=a.loc_province');
		$this->db->join('cities d','d.id=a.loc_city');
		$this->db->where('a.company_id',$company);
		$this->db->where('with_target_date!=',Null);
		$this->db->where('with_target_applicant!=',Null);
		if($job_id=='all'){ $this->db->where($where); } else{ $this->db->where('a.job_id',$job_id); }

		$query = $this->db->get('jobs a');
		return $query->result();
	}

	public function get_hired_applicants($company,$job_id)
	{
		$get_setting = $this->get_include_in_vacancy_computation($company);
		$date = date('Y-m-d');
		
		$this->db->where('date_applied <=',$date);
		$this->db->where(array('company_id'=>$company,'job_id'=>$job_id));
		if(empty($get_setting)){  $this->db->where('ApplicationStatus',3); } else{ $this->db->where($get_setting); }
		$query_hired = $this->db->get('applicant_job_application');
		$query_hired_count = $query_hired->num_rows();
		
		return $query_hired_count;
		
	}	

	public function get_results_filtering_VR7($company,$option,$job_id,$date_posted_from,$date_posted_to,$crystal_report,$code_type,$employer_type)
	{
		$where = "date(a.date_approved) between '" .$date_posted_from. "' and '" .$date_posted_to. "'";
		$date = date('Y-m-d');

		$this->db->join('company_info b','b.company_id=a.company_id');
		$this->db->join('provinces c','c.id=a.loc_province');
		$this->db->join('cities d','d.id=a.loc_city');
		$this->db->where('with_target_date!=',Null);
		$this->db->where('with_target_applicant!=',Null);
		$this->db->where('a.company_id',$company);
		if($job_id=='all'){ $this->db->where($where); } else{ $this->db->where('a.job_id',$job_id); }

		$query = $this->db->get('jobs a');
		$result =  $query->result();	


		foreach($result as $res)
		{
			if($option=='ongoing')
			{
				if($date <= $res->with_target_date)
				{
					$res->optiontype = true;
				}
				else
				{
					$res->optiontype = false;
				}
			}
			else if($option=='meet')
			{
				
					$count_hired = $this->get_hired_applicants($res->company_id,$res->job_id);
					if($count_hired >= $res->with_target_applicant)
					{
						$res->optiontype = true;
					}
					else
					{
						$res->optiontype = false;	
					}
				
			}
			else
			{
				if($date > $res->with_target_date)
				{ 
					$count_hired = $this->get_hired_applicants($res->company_id,$res->job_id);
					if($count_hired < $res->with_target_applicant)
					{
						$res->optiontype = true;
					}
					else
					{
						$res->optiontype = false;	
					}
				}
				else
				{ 
					$res->optiontype = false;
				}
			}
			
		}

		return $result;
	}

	public function get_results_filtering_VR8($company,$datefrom,$dateto,$crystal_report,$code,$employer_type,$status)
	{
		$where = "date(a.date_posted) between '" .$datefrom. "' and '" .$dateto. "'";
		$this->db->join('company_info b','b.company_id=a.company_id');
		$this->db->join('provinces c','c.id=a.loc_province');
		$this->db->join('cities d','d.id=a.loc_city');
		if($status=='all'){} else{ $this->db->where('a.admin_verified',$status); }
		$this->db->where('a.company_id',$company);
		$query = $this->db->get('jobs a');
		return $query->result();
	}

	//additional settings

	public function get_numbering_application_status($company_id,$id,$val)
	{
		$this->db->where(array('company_id'=>$company_id,'status_id'=>$id));
		$query = $this->db->get('recruitment_status_option_numbering',1);
		return $query->row($val);
	}

	public function get_company_name($company_id)
	{
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('company_info',1);
		return $query->row('company_name');
	}


	//job application filtering

	public function get_job_application_reports($val,$employer_type)
	{
		if($employer_type=='hris'){ $this->db->where('forPublic_company_id',Null); } 
		else 
		{
			$company_id = $this->recruitment_employer_management_model->get_companyinfo($this->session->userdata('employer_username'));
			$this->db->where('forPublic_company_id',$company_id); 
		}
		
		$this->db->where('code',$val);
		
		$query =  $this->db->get('crystal_report_recruitments');
		return $query->result();
	}

	public function get_application_status_list($company_id)
	{
		$this->db->where('IsDefault',1);
		$query = $this->db->get('recruitment_applicant_status_option');
		$queryres =  $query->result();

		$this->db->where(array('IsDefault'=>0,'company_id'=>$company_id));
		$query1 = $this->db->get('recruitment_applicant_status_option');
		$queryres1 =  $query1->result();

		return array_merge($queryres,$queryres1);
	}

	public function get_interview_application_status_list($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('recruitment_status_interview_numbering');
		$queryres =  $query->result();

		return $queryres;
	}

	public function get_application_filtering_results_VR1($code,$employer_type,$crystal_report,$company_id,$from,$to,$position,$application,$interview,$crystal_report,$applied_from,$applied_to)
	{
		$where = "date(c.date_approved) between '" .$from. "' and '" .$to. "'";
		$where_applied = "date(a.date_applied) between '" .$applied_from. "' and '" .$applied_to. "'";

		$this->db->join('employee_info_applicant b','b.id=a.employee_info_id');
		$this->db->join('jobs c','c.job_id=a.job_id');
		$this->db->join('recruitment_applicant_status_option d','d.id=a.ApplicationStatus','left');
		$this->db->join('company_info e','e.company_id=a.company_id');
		$this->db->where('a.company_id',$company_id);
		
		if($position=='all'){ $this->db->where($where); } 
		else{
			$this->db->where('a.job_id',$position);
		}
		if($applied_from=='All'){} else{ $this->db->where($where_applied); }
		if($application=='All'){} else{ $this->db->where('a.ApplicationStatus',$application); }
		if($application==1){ if($interview=='All'){ } else{ $this->db->where('a.interview_process',$interview); } }
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}

	public function get_application_filtering_results_VR2($code,$employer_type,$crystal_report,$company_id,$from,$to,$position,$hiring_option,$crystal_report,$applied_from,$applied_to)
	{
		$where = "date(c.date_approved) between '" .$from. "' and '" .$to. "'";
		$where_applied = "date(a.date_applied) between '" .$applied_from. "' and '" .$applied_to. "'";
		if($hiring_option=='setting')
		{
			$get_setting = $this->get_include_in_vacancy_computation($company_id);
		}
		
		$this->db->join('employee_info_applicant b','b.id=a.employee_info_id');
		$this->db->join('jobs c','c.job_id=a.job_id');
		$this->db->join('recruitment_applicant_status_option d','d.id=a.ApplicationStatus','left');
		$this->db->join('company_info e','e.company_id=a.company_id');
		$this->db->where('a.company_id',$company_id);
		
		if($position=='all'){ $this->db->where($where); } 
		else{
			$this->db->where('a.job_id',$position);
		}
		if($applied_from=='All'){} else{ $this->db->where($where_applied); }
		if($hiring_option=='hired'){ $this->db->where('a.ApplicationStatus',3); }
		else { if(empty($get_setting)){ $this->db->where('a.ApplicationStatus',0); } else { $this->db->where($get_setting); }   }
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}

	public function get_application_filtering_results_VR3($code_type,$employer_type,$company_id,$from,$to,$position,$application_interview,$crystal_report,$date_from,$date_to,$time_from,$time_to)
	{
		$where = "date(c.date_approved) between '" .$from. "' and '" .$to. "'";
		$where_interview = "date(bb.applicant_official_date) between '" .$date_from. "' and '" .$date_to. "'";
		$where_time = "time(bb.applicant_official_time) between '" .$time_from. "' and '" .$time_to. "'";
		
		
		$this->db->join('applicant_interview_response bb','bb.aj_application_id=a.id');
		$this->db->join('employee_info_applicant b','b.id=a.employee_info_id');
		$this->db->join('jobs c','c.job_id=a.job_id');
		$this->db->join('recruitment_applicant_status_option d','d.id=a.ApplicationStatus','left');
		$this->db->join('company_info e','e.company_id=a.company_id');
		$this->db->where('a.company_id',$company_id);
		$this->db->where('bb.applicant_official_response','Accept');
		if($position=='all'){ $this->db->where($where); }
		else{
			$this->db->where('a.job_id',$position);
		}
		if($application_interview=='All'){} else{ $this->db->where('a.interview_process',$application_interview); }
		if($date_from=='All'){} else{ $this->db->where($where_interview); }
		if($time_from=='All'){} else{ $this->db->where($where_time); }
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}

	public function get_employee_name_list($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('employee_info');
		return $query->result();
	}

	public function get_application_filtering_results_VR4($code_type,$employer_type,$company_id,$application_interview,$crystal_report,$date_from,$date_to,$employee_id)
	{
		$where_interview = "date(bb.applicant_official_date) between '" .$date_from. "' and '" .$date_to. "'";
		
		$this->db->join('applicant_interview_response bb','bb.aj_application_id=a.id');
		$this->db->join('employee_info_applicant b','b.id=a.employee_info_id');
		$this->db->join('jobs c','c.job_id=a.job_id');
		$this->db->join('recruitment_applicant_status_option d','d.id=a.ApplicationStatus','left');
		$this->db->join('company_info e','e.company_id=a.company_id');
		$this->db->where('a.company_id',$company_id);
		$this->db->where('bb.applicant_official_response','Accept');
		$this->db->where('bb.interviewer',$employee_id);
		if($application_interview=='All'){} else{ $this->db->where('a.interview_process',$application_interview); }
		if($date_from=='All'){} else{ $this->db->where($where_interview); }

		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}

	public function get_application_filtering_results_VR5($code_type,$employer_type,$company_id,$crystal_report,$position,$posted_from,$posted_to,$applied_from,$applied_to)
	{
		$where = "date(c.date_approved) between '" .$posted_from. "' and '" .$posted_to. "'";
		$where_applied = "date(a.date_applied) between '" .$applied_from. "' and '" .$applied_to. "'";
		
		
		$this->db->join('employee_info_applicant b','b.id=a.employee_info_id');
		$this->db->join('jobs c','c.job_id=a.job_id');
		$this->db->join('recruitment_applicant_status_option d','d.id=a.ApplicationStatus','left');
		$this->db->join('company_info e','e.company_id=a.company_id');
		$this->db->where('a.company_id',$company_id);
		
		if($position=='all'){ $this->db->where($where); } 
		else{
			$this->db->where('a.job_id',$position);
		} 
		if($applied_from=='All'){} else{ $this->db->where($where_applied); }
		$this->db->where('a.ApplicationStatus',Null); 
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}

	public function get_application_filtering_results_VR6($code_type,$employer_type,$company_id,$crystal_report,$position,$posted_from,$posted_to,$blocked_from,$blocked_to)
	{
		$where = "date(c.date_approved) between '" .$posted_from. "' and '" .$posted_to. "'";
		$where_blocked = "date(a.date_blocked) between '" .$blocked_from. "' and '" .$blocked_to. "'";
		
		
		$this->db->join('employee_info_applicant b','b.id=a.employee_info_id');
		$this->db->join('jobs c','c.job_id=a.job_id');
		$this->db->join('recruitment_applicant_status_option d','d.id=a.ApplicationStatus','left');
		$this->db->join('company_info e','e.company_id=a.company_id');
		$this->db->where('a.company_id',$company_id);
		
		if($position=='all'){ $this->db->where($where); } 
		else{
			$this->db->where('a.job_id',$position);
		} 
		if($blocked_from=='All'){} else{ $this->db->where($where_blocked); }
		$this->db->where('a.ApplicationStatus',4); 
		$query = $this->db->get('applicant_job_application a');
		return $query->result();
	}

		public function get_application_filtering_results_VR7($code_type,$employer_type,$company_id,$crystal_report,$position,$posted_from,$posted_to,$hired_from,$hired_to)
	{
		$where = "date(c.date_approved) between '" .$posted_from. "' and '" .$posted_to. "'";
		$where_hired = "date(a.date_hired) between '" .$hired_from. "' and '" .$hired_to. "'";
		
		
		$this->db->join('employee_info_applicant b','b.id=a.employee_info_id');
		$this->db->join('jobs c','c.job_id=a.job_id');
		$this->db->join('recruitment_applicant_status_option d','d.id=a.ApplicationStatus','left');
		$this->db->join('company_info e','e.company_id=a.company_id');
		$this->db->where('a.company_id',$company_id);
		
		if($position=='all'){ $this->db->where($where); } 
		else{
			$this->db->where('a.job_id',$position);
		} 
		if($hired_from=='All'){} else{ $this->db->where($where_hired); }
		$this->db->where('a.ApplicationStatus',3); 
		$query = $this->db->get('applicant_job_application a');
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