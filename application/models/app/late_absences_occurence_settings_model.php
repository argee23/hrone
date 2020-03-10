<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Late_absences_occurence_settings_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function get_classification($company)
	{
		$this->db->where('company_id',$company);
		$query = $this->db->get('classification');
		return $query->result();
	}

	public function get_settings_value($val,$company,$classification,$employment,$option)
	{
		$this->db->where(array('company'=>$company,'setting_type'=>$val,'classification'=>$classification,'employment'=>$employment,'type'=>$option));
		$query = $this->db->get('time_late_absences_occurence_settings',1);
		return $query->row('setting_value');
	}

	public function save_settings($company,$val)
	{
		$classification = $this->get_classification($company);
		$employment= $this->general_model->employmentList();
		echo $option = $this->input->post('type');

		foreach($classification as $c)
		{
			foreach($employment as $e)
			{
				$cc = $this->input->post('value_'.$c->classification_id.$e->employment_id);

            /*
            --------------audit trail composition--------------
            (module,module dropdown,logfiletable,detailed action,action type,key value)
            --------------audit trail composition--------------
            */
            $this->general_model->system_audit_trail('Time','Time Late and Absences Monitoring','logfile_time_late_abs_monitor','option|value|class|employment: '.$option.'|'.$cc.'|'.$c->classification_id.'|'.$e->employment_id.'','UPDATE',$company);



				$data =  array('company'=>$company,'classification'=>$c->classification_id,'employment'=>$e->employment_id,'setting_type'=>$val);
				$data_add =  array('company'=>$company,'classification'=>$c->classification_id,'employment'=>$e->employment_id,'setting_type'=>$val,'date_added'=>date('Y-m-d H:i:s'),'setting_value'=>$cc,'type'=>$option);

				$this->db->where($data);
				$q  = $this->db->get('time_late_absences_occurence_settings');

				if(!empty($q->result()))
				{
					$this->db->where($data);
					$update = $this->db->update('time_late_absences_occurence_settings',array('setting_value'=>$cc));
				}
				else
				{
					
					$insert = $this->db->insert('time_late_absences_occurence_settings',$data_add);
				}
			}
		}
	}


	public function settings()
	{
	
		$query = $this->db->get('time_late_absence_settings');
		return $query->result();
	}

	public function save_setting($val)
	{
		$setting = $this->convert_char($val);
		$this->db->insert('time_late_absence_settings',array('setting'=>$setting,'date_added'=>date('Y-m-d H:i:s'),'InActive'=>0));
	}

	public function action_setting($action,$id)
	{

		$this->db->where('id',$id);
		if($action=='delete')
		{
			$this->db->delete('time_late_absence_settings');
		}
		else if($action=='enable')
		{
			$this->db->update('time_late_absence_settings',array('InActive'=>0));
		}
		else
		{
			$this->db->update('time_late_absence_settings',array('InActive'=>1));
		}
	}

	public function save_update_setting($setting_name,$id)
	{
		$setting = $this->convert_char($setting_name);
		$this->db->where('id',$id);
		$this->db->update('time_late_absence_settings',array('setting'=>$setting));
	}

	public function get_basis_settings()
	{
		$this->db->where('InActive',0);
		$query = $this->db->get('time_late_absence_settings');	
		return $query->result();
	}

	public function save_basis_company($company)
	{
		$occurence_late = $this->input->post('occurance_late');
		$occurence_absence = $this->input->post('occurance_absence');

		$total_late = $this->input->post('total_late');
		$total_absence = $this->input->post('total_absence');

		$this->db->where('company',$company);
		$query = $this->db->get('time_late_absence_basis');
		if(empty($query->result()))
		{
			$data1 = array('company'=>$company,'occurence_late'=>$occurence_late,'occurence_absence'=>$occurence_absence,'total_late'=>$total_late,'total_absence'=>$total_absence,'date_added'=>date('Y-m-d H:i:s'));
			$this->db->insert('time_late_absence_basis',$data1);
		}
		else
		{
			$data = array('occurence_late'=>$occurence_late,'occurence_absence'=>$occurence_absence,'total_late'=>$total_late,'total_absence'=>$total_absence,'date_added'=>date('Y-m-d H:i:s'));
			$this->db->where('company',$company);
			$this->db->update('time_late_absence_basis',$data);
		}


		
	}

	public function get_basis_settings_value($company)
	{
		$this->db->where('company',$company);
		$query = $this->db->get('time_late_absence_basis');
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


}
