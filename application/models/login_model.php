<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Login_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	public function getcompLogo($employee_id){
        $query = $this->db->query("SELECT a.company_id,b.logo,b.logo_width,b.logo_height FROM masterlist a INNER JOIN company_info b ON (a.company_id=b.company_id) WHERE a.employee_id='".$employee_id."' ");		
			return $query->row();
	}

	public function validate_nbd(){
		$this->db->select("nbd");
		$this->db->where(array(
                'nbd2'      =>      md5($this->input->post('nbd'))
        ));
        $query = $this->db->get('nbd');
        if($query->num_rows() == 1)
        {

			$this->db->select("username,password");
		 	$this->db->where(array(
               	'username'      =>      $this->input->post('username'),
                'password'      =>      md5($this->input->post('password')),
				'InActive'		=>		0
        		));

        	$query = $this->db->get('users');

        	if($query->num_rows() == 1)
        	{
            	return true;
        	}
        	else
        	{
		        if ($this->check_applicant($this->input->post('username'), $this->input->post('password'))) //Check if applicant
		        {
		        	return true;
		        }
		        else if ($this->check_employee($this->input->post('username'), $this->input->post('password'))) //check if employee
		        {
		        	$employee_info =  $this->general_model->getEmployeeLoggedIn($this->input->post('username'));
					$empid=$employee_info->employee_id;
					$empcompany = $employee_info->company_id;
					$empdiv=$employee_info->division_id;
					if($empdiv=='' || $empdiv==null)
						{ $empdivision= '0'; }
					else{  $empdivision=$empdiv; }
					$empdepartment=$employee_info->department;
					$empsection=$employee_info->section;
					$empsubsec=$employee_info->subsection;
					if($empsubsec=='' || $empdiv==null)
						{ $empsubsection= '0'; }
					else{  $empsubsection=$empsubsec; }
					$empclassification=$employee_info->classification;
					$empemployment=$employee_info->employment;
					$empposition=$employee_info->position;
					$emplocation=$employee_info->location;
					$isEnable=$employee_info->isEnable;
					
		        	if($isEnable==1)
		        	{  
		        		$ccompany = $this->login_model->check_if_company($empcompany);
						$clocation = $this->login_model->check_if_location($empcompany,$emplocation);
						$cdivision = $this->login_model->check_if_division($empcompany,$empdivision);
						$cdepartment = $this->login_model->check_if_department($empcompany,$empdepartment);
						$csection = $this->login_model->check_if_section($empcompany,$empsection);
						$csubsection = $this->login_model->check_if_subsection($empcompany,$empsubsection);
						$cclassification = $this->login_model->check_if_classification($empcompany,$empclassification);
						$cemployment = $this->login_model->check_if_employment($empcompany,$empemployment);
						$cposition = $this->login_model->check_if_position($empcompany,$empposition);
						if($ccompany=='true' AND $cdivision=='true' AND $cdepartment=='true' AND $csection=='true' AND $csubsection=='true' AND $cclassification=='true' AND $cemployment=='true' AND $cposition=='true')
						{  return false; } else{ return true; }

					} 
						 
		        	else{ return false; }
		        }
		        else {
		        	return false;
		        }
        	}

            return true;
        }
        else{ //If NBD is invalid

	        if ($this->check_applicant($this->input->post('username'), $this->input->post('password')))
	        {
	        	return true;
	        }
	        else {
	        	return false;
	        }
        }

	}
	
	public function check_applicant($username, $password)
	{
		$this->db->select("aa.applicant_id, aa.applicant_password");
		$this->db->where(array(
                'aa.applicant_id'      		=>     $username,
                'aa.applicant_password'  	=>     md5($password),
				'ei.isApplicant'	  	 	=>	   1,
				'ei.isEmployee'		   		=>	   0
        ));
        $this->db->join("employee_info_applicant ei", "aa.employee_info_id = ei.id", "inner");
        $query = $this->db->get("applicant_account aa");

         if ($query->num_rows() == 1) {
         	return true;
         }
         else {
         	return false;
         }
	}

	public function check_employee($username, $password)
	{

		$this->db->where('username',$username);
		$query = $this->db->get('employee_info',1); 
		$query_res = $query->row();

		if(!empty($query_res))
		{
			if(empty($query_res->encrypt_password) || $query_res->encrypt_password==0)
			{
				if($query_res->password==$password)
				{	
					$res = true;
				} else { $res = false; }
			}
			else
			{
				$pass  = $this->encrypt->decode($query_res->password);
				if($pass==$password)
				{	
					$res = true;
				} else { $res = false; }
			}
		
		}
		else
		{
			$res = false;	
		}
		
		return $res;
	}
	
	public function getMyModule($user_id){
		$this->db->select("B.module");
		$this->db->where("employee_id",$user_id);
		$this->db->join("user_roles B","B.role_id = A.user_role","left outer");
		$query = $this->db->get("users A");
		return $query->row();	
	}
	
	public function loadJobVacancies()
	{
		$this->db->select("job_title, job_description, salary, date_posted, company_name, id, company_id, logo");
		$this->db->order_by("hiring_start", "desc");
		$query = $this->db->get("job_vacancy_view");

		return $query->result();
	}

	function getRows($params = array()){
		$this->db->select("a.job_title, a.job_description, a.salary, a.date_posted, a.company_name, a.id, a.company_id, a.logo,a.job_id as job_id,a.hiring_start,a.hiring_end,a.specialization_id,b.cValue");
		$this->db->join('system_parameters b','b.param_id=a.specialization_id');
		$this->db->order_by("hiring_start", "desc");
        $this->db->from('job_vacancy_view_search a');
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }


	public function employee_log_history($employee_id,$event,$user){
		$this->data = array(
			'employee_id'				=>		$employee_id,
			'date'						=>		date("Y-m-d h:i:s a"),
			'event'						=>		$event,
			'time'						=>		date("H:i:s"),
			'ip_address'				=>		$this->input->ip_address(),
			'computer_name'				=>		gethostname(),
			'user_type'					=>		$user
		);	
		$this->db->insert("emp_log_history",$this->data);
	}


	
	public function check_if_company($companyid)
	{ 
		$this->db->select("*");
		$this->db->from('account_management_disable_account');
		$this->db->where('company_id',$companyid);
		$query = $this->db->get();
		if($query->num_rows() > 0 )
		{ return 'true'; } else{  return 'false'; } 
		
	}
	//check if id is enable
	public function check_if_location($companyid,$emplocation)
	{ 
		$this->db->select("*");
		$this->db->from('account_management_disable_account');
		$this->db->where('company_id',$companyid);
		$query = $this->db->get();
		$location = $query->row("location");
		if($location==0){ return 'true'; }
		else{
			$l = explode("-",$location);
			$i=0;
			foreach ($l as $row) {
				if($row==$emplocation)
					{ $i = $i + 1; }
				else{ $i = $i + 0; } 
			if($i>0) { return 'true'; }
			else{ }	
			}	
		}
	}

	
	public function check_if_division($companyid,$empdivision)
	{ 
		$this->db->select("*");
		$this->db->from('account_management_disable_account');
		$this->db->where('company_id',$companyid);
		$query = $this->db->get();
		$division = $query->row("division");
		if($division==0){ return 'true'; }
		else{
			if($empdivision==0)
				{ return 'true'; }
			else{

			$locc = explode("-",$division);
			$i=0;
			foreach ($locc as $row) { 
				if($row==$empdivision)
					{ $i = $i + 1; }
				else{ $i = $i + 0; }  
					if($i > 0){ return 'true'; }
					else {  }
			}	
		}}
	}

	public function check_if_department($companyid,$empdepartment)
	{
		$this->db->select("*");
		$this->db->from('account_management_disable_account');
		$this->db->where('company_id',$companyid);
		$query = $this->db->get();
		$department = $query->row("department");
		if($department==0){ return 'true'; }
		else{
			if($empdepartment==0)
				{ return true; }
			else{
			$locc = explode("-",$department);
			$i=0;
			foreach ($locc as $roww) {
				if($roww==$empdepartment)
					{ $i = $i + 1; }
				else{ $i = $i + 0;  } 
					if($i > 0){ return 'true'; }
					else { }
			}	
		}}
	}
	public function check_if_section($companyid,$empsection)
	{
		$this->db->select("*");
		$this->db->from('account_management_disable_account');
		$this->db->where('company_id',$companyid);
		$query = $this->db->get();
		$section = $query->row("section");
		if($section==0){ return 'true'; }
		else{
			if($empsection==0)
				{ return true; }
			else{
			$locc = explode("-",$section);
			$i=0;
			foreach ($locc as $roww) {
				if($roww==$empsection)
					{ $i = $i + 1;  }
				else{ $i = $i + 0;  } 
					if($i > 0){ return 'true'; }
					else {  }
			}	
		}}
	}
	public function check_if_subsection($companyid,$empsubsection)
	{
		$this->db->select("*");
		$this->db->from('account_management_disable_account');
		$this->db->where('company_id',$companyid);
		$query = $this->db->get();
		$subsection = $query->row("subsection");
		if($subsection==0){ return 'true'; }
		else{
			if($empsubsection==0)
				{ return true; }
			else{
			$locc = explode("-",$subsection);
			$i=0;
			foreach ($locc as $roww) {
				if($roww==$empsubsection)
					{ $i = $i + 1;  }
				else{ $i = $i + 0; } 
					if($i > 0){ return 'true'; }
					else {  }
			}	
		}}
	}
	public function check_if_classification($companyid,$empclassification)
	{
		$this->db->select("*");
		$this->db->from('account_management_disable_account');
		$this->db->where('company_id',$companyid);
		$query = $this->db->get();
		$classification = $query->row("classification");
		if($classification==0){ return 'true'; }
		else{
			if($empclassification==0)
				{ return true; }
			else{
			$locc = explode("-",$classification);
			$i=0;
			foreach ($locc as $roww) {
				if($roww==$empclassification)
					{ $i = $i + 1;  }
				else{ $i = $i + 0;  } 
					if($i > 0){ return 'true'; }
					else {  }
			}	
		}}
	}
	public function check_if_employment($companyid,$empemployment)
	{
		$this->db->select("*");
		$this->db->from('account_management_disable_account');
		$this->db->where('company_id',$companyid);
		$query = $this->db->get();
		$employment = $query->row("employment");
		if($employment==0){ return 'true'; }
		else{
			if($empemployment==0)
				{ return true; }
			else{
			$locc = explode("-",$employment);
			$i=0;
			foreach ($locc as $roww) {
				if($roww==$empemployment)
					{ $i = $i + 1;  }
				else{ $i = $i + 0;  } 
					if($i > 0){ return 'true'; }
					else {  }
			}	
		}}
	}
	public function check_if_position($companyid,$empposition)
	{
		$this->db->select("*");
		$this->db->from('account_management_disable_account');
		$this->db->where('company_id',$companyid);
		$query = $this->db->get();
		$position = $query->row("position");
		if($position==0){ return 'true'; }
		else{
			if($empposition==0)
				{ return true; }
			else{
			$locc = explode("-",$position);
			$i=0;
			foreach ($locc as $roww) {
				if($roww==$empposition)
					{ $i = $i + 1; }
				else{ $i = $i + 0;  } 
					if($i > 0){ return 'true'; }
					else {  }
			}	
		}}
	}


	public function get_company_jobs($company_id)
	{
		$this->db->select("a.job_title, a.job_description, a.salary, a.date_posted, a.company_name, a.id, a.company_id, a.logo,a.job_id as job_id,a.hiring_start,a.hiring_end,a.specialization_id,b.cValue");
		$this->db->join('system_parameters b','b.param_id=a.specialization_id');
		$this->db->where('a.company_id',$company_id);
		$this->db->order_by("a.hiring_start", "desc");
		$query = $this->db->get("job_vacancy_view a");
		return $query->result();

	}

// web bundy functions

	public function check_wb_ip($my_ip_address,$company_id){
		$this->db->where('allowed_ip_address',$my_ip_address);
		$this->db->where('company_id',$company_id);

		$query = $this->db->get("web_bundy_allowed_ip_address");
		return $query->row();		
	}
	public function check_web_bundy_company_setting($company_id){
		$this->db->where('company_id',$company_id);

		$query = $this->db->get("web_bundy_company_setting");
		return $query->row();		
	}
	public function get_system_settings($system_setting_id){
		$this->db->where('id',$system_setting_id);
		$query = $this->db->get("system_settings");
		return $query->row();		
	}

	public function my_wb_allowed_ip(){
		// get all no matter what company.

		$query = $this->db->get("web_bundy_allowed_ip_address");
		return $query->result();		
	}

	public function validate_webbundy_account(){
		    	$webbundy_employee_id=$this->input->post('webbundy_employee_id');
		    	$webbundy_employee_code=$this->input->post('webbundy_employee_code');

		$this->db->select("A.*");
		$this->db->where(array(
                'A.employee_id'      =>       $webbundy_employee_id,
                'A.code'     	 		=>      $webbundy_employee_code
        ));
        $this->db->join("employee_info B","B.employee_id = A.employee_id","left outer");
        $query = $this->db->get('web_bundy_employee A');

        if($query->num_rows() == 1)
        {

            	return true;
        }else{
        		return false;
       }
	}

	public function check_att_ifexist($covered_date,$logs_month,$webbundy_employee_id){
		$attendance_table_name="attendance_".$logs_month;
		$this->db->select("id,time_in");
		$this->db->where(array(
                'time_in !='      		=>      '',
                'covered_date'      	=>      $covered_date,
                'employee_id'     	 	=>      $webbundy_employee_id
        ));

		$query = $this->db->get($attendance_table_name);
		return $query->row();		
	}
	public function insert_bundy_time_in($web_bundy_start_values,$logs_month){
				$attendance_table_name="attendance_".$logs_month;
				$this->db->insert($attendance_table_name, $web_bundy_start_values); 

				//$this->db->insert('web_bundy_clock_raw', $web_bundy_values); 
	}
	public function get_emp_company($webbundy_employee_id){
		$this->db->select("company_id");
		$this->db->where('employee_id',$webbundy_employee_id);
		$this->db->where('InActive',0);
		$query = $this->db->get('employee_info');
		return $query->row();		
	}

	public function update_bundy_attendance($update_datas,$logs_month,$covered_date,$webbundy_employee_id){

		$attendance_table_name="attendance_".$logs_month;

		$this->db->where(array(
                'covered_date'      	=>      $covered_date,
                'employee_id'     	 	=>      $webbundy_employee_id
        ));
		$this->db->update($attendance_table_name, $update_datas);
	}

	public function check_lunch_out_ifexist($covered_date,$logs_month,$webbundy_employee_id){
		$attendance_table_name="attendance_".$logs_month;
		$this->db->select("id,time_in");
		$this->db->where(array(
                'lunch_break_out !='      		=>      '',
                'covered_date'      	=>      $covered_date,
                'employee_id'     	 	=>      $webbundy_employee_id
        ));

		$query = $this->db->get($attendance_table_name);
		return $query->row();		
	}
	public function check_lunch_in_ifexist($covered_date,$logs_month,$webbundy_employee_id){
		$attendance_table_name="attendance_".$logs_month;
		$this->db->select("id,time_in");
		$this->db->where(array(
                'lunch_break_in !='      		=>      '',
                'covered_date'      	=>      $covered_date,
                'employee_id'     	 	=>      $webbundy_employee_id
        ));

		$query = $this->db->get($attendance_table_name);
		return $query->row();		
	}



	public function check_break_1_in_ifexist($covered_date,$logs_month,$webbundy_employee_id){
		$attendance_table_name="attendance_".$logs_month;
		$this->db->select("id,time_in");
		$this->db->where(array(
                'break_1_in !='      		=>      '',
                'covered_date'      	=>      $covered_date,
                'employee_id'     	 	=>      $webbundy_employee_id
        ));

		$query = $this->db->get($attendance_table_name);
		return $query->row();		
	}



	public function check_break_1_out_ifexist($covered_date,$logs_month,$webbundy_employee_id){
		$attendance_table_name="attendance_".$logs_month;
		$this->db->select("id,time_in");
		$this->db->where(array(
                'break_1_out !='      		=>      '',
                'covered_date'      	=>      $covered_date,
                'employee_id'     	 	=>      $webbundy_employee_id
        ));

		$query = $this->db->get($attendance_table_name);
		return $query->row();		
	}


	public function check_forward_logs_ifexist($covered_date,$logs_month,$webbundy_employee_id){
		$attendance_table_name="attendance_".$logs_month;

		$query=$this->db->query("SELECT lunch_break_out,lunch_break_in,break_2_out,break_2_in,time_out FROM $attendance_table_name WHERE covered_date='".$covered_date."' AND employee_id='".$webbundy_employee_id."' AND (lunch_break_out!='' OR lunch_break_in!='' OR break_2_out!='' OR break_2_in!='' OR time_out!='') ");

		return $query->row();		
	}
	//

		public function check_break_2_in_ifexist($covered_date,$logs_month,$webbundy_employee_id){
		$attendance_table_name="attendance_".$logs_month;
		$this->db->select("id,time_in");
		$this->db->where(array(
                'break_2_in !='      		=>      '',
                'covered_date'      	=>      $covered_date,
                'employee_id'     	 	=>      $webbundy_employee_id
        ));

		$query = $this->db->get($attendance_table_name);
		return $query->row();		
	}

	public function check_break_2_out_ifexist($covered_date,$logs_month,$webbundy_employee_id){
		$attendance_table_name="attendance_".$logs_month;
		$this->db->select("id,time_in");
		$this->db->where(array(
                'break_2_out !='      		=>      '',
                'covered_date'      	=>      $covered_date,
                'employee_id'     	 	=>      $webbundy_employee_id
        ));

		$query = $this->db->get($attendance_table_name);
		return $query->row();		
	}
	public function check_time_out_ifexist($covered_date,$logs_month,$webbundy_employee_id){
		$attendance_table_name="attendance_".$logs_month;

		$query=$this->db->query("SELECT time_out FROM $attendance_table_name WHERE covered_date='".$covered_date."' AND employee_id='".$webbundy_employee_id."' AND time_out!='' ");

		return $query->row();		
	}

	public function check_lunch_forward_logs_ifexist($covered_date,$logs_month,$webbundy_employee_id){
		$attendance_table_name="attendance_".$logs_month;

		$query=$this->db->query("SELECT time_out,break_2_out,break_2_in FROM $attendance_table_name WHERE covered_date='".$covered_date."' AND employee_id='".$webbundy_employee_id."' AND (time_out!='' OR break_2_out!='' OR break_2_in!='')");

		return $query->row();		
	}

	public function get_job_location($id)
	{
		$this->db->where('job_id',$id);
		$query = $this->db->get('jobs');
		$province = $query->row('loc_province');
		$city = $query->row('loc_city');

		if(empty($province))
		{
			$p_prov="";
		} 
		else
		{
			$this->db->where('id',$province);
			$prov = $this->db->get('provinces');
			$p_prov = $prov->row('name');
		}

		if(empty($city))
		{
			$p_city="";
		} 
		else
		{
			$this->db->where('id',$city);
			$prov = $this->db->get('cities');
			$p_city = " - ".$prov->row('city_name');
		}

		return $p_prov.$p_city;
	}
	public function get_all_cities($province)
	{	
		if($province=='All'){} else{ $this->db->where('province_id',$province); }
		$query = $this->db->get('cities');
		return $query->result();
	}
	public function get_search_now($search,$category,$province,$city,$specialization,$salary_from,$salary_to,$type)
	{
		$search_ = $this->convert_char($search);
		$where = "a.salary between " .$salary_from. " and " .$salary_to. "";

		$this->db->select("a.job_title, a.job_description, a.salary, a.date_posted, a.company_name, a.id, a.company_id, a.logo, a.job_id, a.salary,a.hiring_start,a.hiring_end,b.cValue,a.specialization_id");
		$this->db->join('system_parameters b','b.param_id=a.specialization_id');
			

		if($search_=='not_included'){}
		else
		{
			if($category=='company_name') {  $this->db->where("(`a.company_name` LIKE '%$search_%')"); }
			else if($category=='job_title') { $this->db->where("(`a.job_title` LIKE '%$search_%')"); }
			else { $this->db->where("(`b.cValue` LIKE '%$search_%')"); }
		}
		
		if($specialization=='All' || $specialization=='not_included'){} else { $this->db->where('a.specialization_id',$specialization); }
		if($province=='All' || $province=='not_included'){} else{ $this->db->where('a.loc_province',$province); }
		if($city=='All' || $city=='not_included'){} else{ $this->db->where('a.loc_city',$city); }

		if($salary_from=='not_included' AND $salary_to=='not_included'){} else{ $this->db->where($where); }
		
		$this->db->order_by("a.hiring_start", "desc");
		$query = $this->db->get("job_vacancy_view_search a");
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


//===========
	public function checkMainpageTemplate(){
		$query=$this->db->query("SELECT  single_value FROM system_settings WHERE single_value_type='mainpage_theme' ");
		return $query->row();			
	}
	public function IsPublicRec(){//Is Public Recruitment?
		$query=$this->db->query("SELECT  single_value FROM system_settings WHERE id='6' ");
		return $query->row();			
	}



}

