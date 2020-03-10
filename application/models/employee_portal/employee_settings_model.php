<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class employee_settings_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}

	public function employee_details($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info');
		return $query->row();
	}

	public function save_account_settings($employee_id,$email,$account_display,$transaction_status,$notification_status,$request_approval,$request_update)
	{
		$l_email = $this->convert_char($email);
			$data = array('company_id'		=>$this->session->userdata('company_id'),
					   'employee_id'		=>$employee_id,
					   'email'				=>$l_email,
					   'account_display' 	=> $account_display,
					   'transaction_status' => $transaction_status,
					   'notification_status'=> $notification_status,
					   'request_approval' 	=>$request_approval,
					   'request_update' 	=> $request_update,
					   'date_created' 		=> date('Y-m-d'));
		$this->db->where('employee_id',$employee_id);
		$q = $this->db->get('employee_settings');
		if($q->num_rows() > 0)
		{
			$this->db->where('employee_id',$employee_id);	
			$update =  $this->db->update('employee_settings',$data);
		}
		else
		{
			
			$insert =  $this->db->insert('employee_settings',$data);
		}
		
	}

	public function emp_settings($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_settings');
		return $query->row();
	}
	public function get_password($employee_id)
	{
		$this->db->where('employee_id',$employee_id);
		$query = $this->db->get('employee_info');
		$setting = $query->row('encrypt_password');
		$password = $query->row('password');

		if($setting==1)
		{	
			$pass = $this->encrypt->decode($password);
			return $pass;
		}
		else
		{
			return $password;
		}
	}
	public function check_old_password()
	{
		$id = $this->session->userdata('employee_id');
		$current_password = $this->input->post('current_password');

		$this->db->where(array('employee_id'=> $id));
		$query = $this->db->get("employee_info",1);
		$password = $query->row('password');
		$setting = $query->row('encrypt_password');
		if($setting==1){ $pass = $this->encrypt->decode($password); }
		else { $pass = $query->row('password'); }

		if ($current_password==$pass)
		{
			return true;
		}
		else {
			return false;
		}
	}

	public function change_password()
	{
		$id = $this->session->userdata('employee_id');
		$get_setting = $this->encryption_setting();
		$password = $this->input->post('new_password');

		if(!empty($get_setting) AND $get_setting=='yes')
		{
			$pass = $this->encrypt->encode($password);
			$setting = 1;
			
		}
		else
		{
			$pass = $password;
			$setting = 0;
		}


		$this->data 	=array(
			'password'			=> $pass,
			'encrypt_password'	=> $setting
			);

		$this->db->set('passChangeDate', 'now()', FALSE);
		$this->db->where("employee_id", $id);
		$this->db->update('employee_info', $this->data);
	}

	


	public function if_approver($employee_id)
	{
		$this->db->where('approver',$employee_id);
		$query = $this->db->get('transaction_approvers');
		if($query->num_rows() > 0){ return 1; } else{ return 0; }
	}


	//change password / check the password encryption setting

	public function encryption_setting()
	{
		$this->db->join('account_management_others_setup b','a.account_management_policy_id=a.account_management_policy_id');
		$this->db->join('account_management_others_data c','c.account_management_others_setup_id=b.account_management_others_setup_id');
		$query = $this->db->get('account_management_policy_settings a');
		$setting = $query->row('datas');
		return $setting;
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