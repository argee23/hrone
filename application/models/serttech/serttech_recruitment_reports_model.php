<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Serttech_recruitment_reports_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
		$this->load->model('serttech/serttech_login_model');
		$this->load->model('recruitment_employer/recruitment_employer_model');
		$this->load->model('app/recruitment_model');
		$this->load->model('app/recruitments_model');
	}
	
	public function get_serttech_settings()
	{
		$this->db->where(array('IsDefault'=>1,'single_fields'=>0));
		$query = $this->db->get('recruitment_settings');
		return $query->result();
	}

	public function get_serttech_settings_all()
	{
		$query = $this->db->get('recruitment_settings');
		return $query->result();
	}

	
	public function add_crystal_report($code_type,$code)
	{
		$this->db->where(array('type'=>$code_type,'code'=>$code));
		$query = $this->db->get('crystal_report_serttech_fields');
		return $query->result();
	}
	public function get_crystal_report($code)
	{
		$this->db->select('a.*,b.policy_title,a.title as crtitle');
		$this->db->join('recruitment_settings b','b.code=a.code','left');
		$this->db->where('a.type',$code);
		$query = $this->db->get('crystal_report_serttech a');
		return $query->result();
	}

	public function save_crystal_report($code,$code_type,$name_final,$description_final,$data,$employer_type)
	{	
		$title = $this->convert_char($name_final);
		$desc = $this->convert_char($description_final);
		
		$datas = array(
						'type'	   		   =>		$code_type,
						'code'  		   =>		$code,
						'title'			   =>		$title,
						'description'	   =>		$desc,
						'date_created'	   =>		date('Y-m-d H:i:s'),
						'added_by'		   =>		$this->session->userdata('employee_id'),
						'InActive'		   =>		0
					);

		$this->db->insert('crystal_report_serttech',$datas);
		$c_id  = $this->db->insert_id();

		
		$a 	= substr_replace($data, "", -1);
		$array =  explode('-', $a);


		foreach($array as $aa)
			{
				$dataa = array( 'crystal_id'	=>	$c_id,
								'field_id'		=> $aa,
								'date_created'	=>date('Y-m-d H:i:s')
						);
				$this->db->insert('crystal_report_serttech_list',$dataa);
			}
		
	}

	public function crystal_report_details($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('crystal_report_serttech');
		return $query->row();
	}

	public function crystal_report_fields($code_type,$code)
	{
		
		$this->db->where(array('type'=>$code_type,'code'=>$code));
		$query_ = $this->db->get('crystal_report_serttech_fields');
		$q_ = $query_->result();

		return $q_;
	}

	public function check_if_selected($crystal_id,$id)
	{
		$this->db->where(array('crystal_id'=>$crystal_id,'field_id'=>$id));
		$query = $this->db->get('crystal_report_serttech_list');
		return $query->num_rows();
	}

	public function stat_crystal_report($action,$id)
	{

		if($action=='enable')
		{
			$this->db->where('id',$id);
			$query = $this->db->update('crystal_report_serttech',array('InActive'=>0));
		}
		else if($action=='disable')
		{
			$this->db->where('id',$id);
			$query = $this->db->update('crystal_report_serttech',array('InActive'=>1));
		}
		else
		{
			$this->db->where('id',$id);
			$this->db->delete('crystal_report_serttech');

			$this->db->where('crystal_id',$id);
			$this->db->delete('crystal_report_serttech_list');
		}
	}

	

	public function update_crystal_report($code,$code_type,$name_final,$description_final,$data,$crystal_id)
	{

		$this->db->where('crystal_id',$crystal_id);
		$this->db->delete('crystal_report_serttech_list');

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
		$this->db->update('crystal_report_serttech',$datas);
		
		
		$a 	= substr_replace($data, "", -1);
		$array =  explode('-', $a);


		foreach($array as $aa)
			{
				$dataa = array( 'crystal_id'	=>	$crystal_id,
								'field_id'		=> $aa,
								'date_created'	=>date('Y-m-d H:i:s')
						);
				$this->db->insert('crystal_report_serttech_list',$dataa);
			}
	}	

	public function get_code_crystal_report($code_type,$code)
	{
		$this->db->where(array('code'=>$code,'single_fields'=>1));
		$q =  $this->db->get('recruitment_settings',1);

		if($code=='setting_list' || $code=='default_setting' || $code=='not_default_setting')
		{
			$code = 'setting_list';
		}
		else if($code=='SD1' || $code=='SD2' || $code=='SD3' || $code=='SD6' || $code=='SD1')
			{ $code = $code; }  
		else { $code = 'single_field'; }

		$this->db->where(array('type'=>$code_type,'code'=>$code));
		$query = $this->db->get('crystal_report_serttech');
		return $query->result();
	}

	public function get_crystal_report_fields($crystal_report)
	{	
		$this->db->join('crystal_report_serttech_fields b','b.id=a.field_id');
		$this->db->where('a.crystal_id',$crystal_report);
		$query = $this->db->get('crystal_report_serttech_list a');

		return $query->result();
	}

	public function generate_report_settings_results($code_type,$code)
	{
		if($code=='SD1')
		{
			$query = $this->db->get('recruitment_employer_billing_setting');
			return $query->result();
		}
		else if($code=='SD2')
		{
			$query = $this->db->get('recruitment_employers_setting_main');
			return $query->result();
			
		}
		else if($code=='SD12' || $code=='SD3')
		{
			$this->db->where('type',$code);
			$query = $this->db->get('recruitment_requirement_list');
			return $query->result();	
		}
		else if($code=='SD6')
		{
			$this->db->where('type','serttech_host');
			$query = $this->db->get('recruitment_email_setting');
			return $query->result();
		}
		else if($code=='single_field')
		{
			$this->db->join('recruitment_settings_data b','b.setting_id=a.id');
			$query = $this->db->get('recruitment_settings a');
			return $query->result();
		}
		else if($code=='setting_list')
		{
			$query = $this->db->get('recruitment_settings a');
			return $query->result();
		}
		else if($code=='default_setting')
		{
			$this->db->where('a.IsDefault',1);
			$query = $this->db->get('recruitment_settings a');
			return $query->result();
		}
		else if($code=='not_default_setting')
		{
			$this->db->where('a.IsDefault!=',1);
			$query = $this->db->get('recruitment_settings a');
			return $query->result();
		}
		else
		{
			
			$this->db->join('recruitment_settings_data b','b.setting_id=a.id');
			$this->db->where('a.code',$code);
			$query = $this->db->get('recruitment_settings a');
			return $query->result();
		}
	}


	public function get_employers_registered_results($type,$employer,$accounttype,$status,$r_from,$r_to,$e_to,$e_from)
	{
		$r = "date(date_registered) between '" .$r_from. "' and '" .$r_to. "'";
		$e = "date(date_end) between '" .$e_from. "' and '" .$e_to. "'";
		

		$this->db->select('a.*,b.*,c.*');
		$this->db->join('recruitment_employers b','b.employer_id=a.employer_id');
		$this->db->join('recruitment_employer_billing_setting c','c.id=a.package_id','left');
		if($employer=='all'){} else{ $this->db->where('a.company_id',$employer); }
		
		if($accounttype=='free_trial'){ $this->db->where('a.active_usage_type',$accounttype); }
		else if($accounttype=='all'){}
		else{ if($accounttype=='all'){ $this->db->where('a.active_usage_type','subscription'); } else{ $this->db->where('a.package_id',$accounttype); } }
		
		if($status=='all'){ }
		else{  $this->db->where('a.is_usage_active',$status);  }
		
		if($r_from=='all'){}
		else{ $this->db->where($r); }

		if($e_from=='all'){}
		else{ $this->db->where($e); }

		$query = $this->db->get('recruitment_employers_setting a');
		return $query->result();
	}

	public function get_crystalreport($code_type,$code)
	{
		$this->db->where(array('type'=>$code_type,'code'=>$code));
		$query = $this->db->get('crystal_report_serttech');
		return $query->result();
	}

	public function get_industry_data($id)
	{
		$this->db->where('param_id',$id);
		$query = $this->db->get('system_parameters');
		$val = $query->row('cValue');
		if($val==''){ return 'No Industry Found'; } else{ return $val; }
	}

	public function get_job_management_results($type,$employer,$status,$r_from,$r_to,$u_to,$u_from)
	{	
		$r = "date(date_posted) between '" .$r_from. "' and '" .$r_to. "'";
		$u = "date(date_approved) between '" .$u_from. "' and '" .$u_to. "'";
		
		if($employer=='all'){} else{ $this->db->where('b.company_id',$employer); }
		if($status=='all'){} else{ $this->db->where('a.admin_verified',$status); }
		if($r_from=='all'){}
		else
		{
			$this->db->where($r);
		}
		if($u_from=='all')
		{}
		else
		{
			$this->db->where($u);
		}
		$this->db->where('a.iSEmployer',1);
		$this->db->join('company_info b','b.company_id=a.company_id');
		$this->db->join('recruitment_employers c','c.username=b.employer_username');
		$query = $this->db->get('jobs a');
		return $query->result();
	}

	function get_requirement_status_results($code,$employer,$datefinal,$datefrom,$dateto,$account,$status)
	{

			$e = "date(a.date_registered) between '" .$datefrom. "' and '" .$dateto. "'";
			$this->db->select('a.*,b.*,c.*,d.*,c.status as reqstat,a.type as typee,c.date_approved as da,a.status as statt,dd.*');
			$this->db->join('recruitment_employers b','b.employer_id=a.employer_id');
			$this->db->join('recruitment_employers_req_list c','c.id=a.id');
			$this->db->join('recruitment_employers_requirements dd','dd.id=c.id','left');
			$this->db->join('recruitment_requirement_list d','d.id=c.requirement_id');
			$this->db->join('recruitment_employer_billing_setting e','e.id=a.package_id','left');
			if($datefrom=='all'){} else { $this->db->where($e); }
			if($employer=='all'){} else{  $this->db->where('a.company_id',$employer); }
			if($status=='all'){} else{ $this->db->where('c.status',$status); }
			if($account=='free_trial' || $account=='subscription'){ $this->db->where('a.type',$account); }
			else{}
		
			$query = $this->db->get('recruitment_employers_requirements a');
			return $query->result();
	}

	public function get_payment_status_results($employer,$employer,$payment,$license,$accounttype,$datefinal,$crystal_report,$datefrom,$dateto)
	{
			$e = "date(a.date_registered) between '" .$datefrom. "' and '" .$dateto. "'";
			$this->db->select('a.*,b.*,c.*,a.type as typee,a.status as statt');
			$this->db->join('recruitment_employers b','b.employer_id=a.employer_id');
			$this->db->join('recruitment_employer_billing_setting c','c.id=a.package_id','left');
			if($datefrom=='all'){} else{ $this->db->where($e); }
			if($payment=='all'){ } else{ if($payment=='paid'){ $this->db->where('a.payment_status','paid'); } else{ $this->db->where('a.payment_status','0'); } }
			if($license=='all'){ } else{ if($license=='active'){ $this->db->where('a.activation','active'); } else{ $this->db->where('a.activation','0'); } }  
			
			if($accounttype=='free_trial' || $accounttype=='subscription'){ $this->db->where('a.type',$accounttype); }
			else{}
			
			$query = $this->db->get('recruitment_employers_requirements a');
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