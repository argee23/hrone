<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class payroll_settings_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	//list company
	public function payrollCompany()
	{
		$this->db->select('*');
		$this->db->from('company_info');
		$this->db->where('InActive', '0');
		$query = $this->db->get();
		return $query->result();	
	}
	
	public function policy_list($company_id)
	{
		$this->db->select('*,title');
		$this->db->from('payroll_main_setting');
		$this->db->join('payroll_setting_policy','payroll_setting_policy.payroll_main_id=payroll_main_setting.payroll_main_id');
		$this->db->where('company_id', $company_id);
		$this->db->where('InActive', '0');
		$query = $this->db->get();
		return $query->result();
	}

	public function form_type($policy_company_id)
	{
		$this->db->select('*,payroll_setting_policy_id');
		$this->db->from('payroll_main_setting');
		$this->db->join('payroll_setting_policy','payroll_setting_policy.payroll_main_id=payroll_main_setting.payroll_main_id');
		$this->db->where('payroll_setting_policy_id', $policy_company_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function insert_new_data($policy_id,$policy_company_id,$data)
	{

		$data1 = str_replace("%20"," ",$data);
		$i_data1 = $this->payroll_settings_model->convert_char($data1);
		$this->db->select('*');
		$this->db->from('payroll_main_setting');
		$this->db->where('payroll_main_id', $policy_id);
		$query = $this->db->get();
		$single_field = $query->row("single_field");
		$employment_classification = $query->row("employment_classification");
		$payroll_period = $query->row("payroll_period");
		
		$this->db->select('*');
		$this->db->from('payroll_setting');
		$this->db->where('payroll_setting_policy_id', $policy_company_id);
		$query_pol = $this->db->get();
		$query_pol_row = $query_pol->num_rows();
		if($query_pol_row == '0')
		{
		if($single_field=='1')
		{ 
			$data = array('payroll_setting_policy_id' => $policy_company_id,'single_field'  => $i_data1,
		                'classification_employment'	=> 'not_included','payroll_period' 	=> 'not_included',
		                'date_created' 		=> date('Y-m-d H:i:s'));
		}
		elseif($employment_classification=='1')
		{ 
			$data = array('payroll_setting_policy_id' => $policy_company_id,'single_field'  => 'not_included',
		                'classification_employment'	=> '1','payroll_period' 	=> 'not_included',
		                'date_created' 		=> date('Y-m-d H:i:s'));
		}
		elseif($payroll_period=='1')
		{ 
			$data = array('payroll_setting_policy_id' => $policy_company_id,'single_field'  => 'not_included',
		                'classification_employment'	=> 'not_included','payroll_period' 	=> '1',
		                'date_created' 		=> date('Y-m-d H:i:s'));
		}
		else{ return 'no_policy_setup'; }
		$query = $this->db->insert('payroll_setting',$data);
		if($this->db->affected_rows() > 0)
				{
	    			return 'inserted'; 
				}
				else
					{ return 'error'; }

		}
		else{ return 'error'; }
	}

	public function policy_added_data($policy_company_id,$company_id)
	{
		$this->db->select('*,company_id,payroll_setting_policy.payroll_setting_policy_id');
		$this->db->from('payroll_setting');
		$this->db->join('payroll_setting_policy','payroll_setting_policy.payroll_setting_policy_id=payroll_setting.payroll_setting_policy_id');
		$this->db->where('payroll_setting_policy.payroll_setting_policy_id',$policy_company_id);
		$this->db->where('company_id', $company_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function update_data($policy_id,$payroll_setting_id,$data)
	{
		$data1 = str_replace("%20"," ",$data);
		$i_data1 = $this->payroll_settings_model->convert_char($data1);
		$this->db->select('*');
		$this->db->from('payroll_main_setting');
		$this->db->where('payroll_main_id', $policy_id);
		$query = $this->db->get();
		$single_field = $query->row("single_field");
		$employment_classification = $query->row("employment_classification");
		$payroll_period = $query->row("payroll_period");
		
		if($single_field=='1')
		{ 
			$data = array('single_field'  => $i_data1,
		                'classification_employment'	=> 'not_included','payroll_period' 	=> 'not_included',
		                'date_created' 		=> date('Y-m-d H:i:s'));
		}
		elseif($employment_classification=='1')
		{ 
			$data = array('single_field'  => 'not_included',
		                'classification_employment'	=> '1','payroll_period' 	=> 'not_included',
		                'date_created' 		=> date('Y-m-d H:i:s'));
		}
		elseif($payroll_period=='1')
		{ 
			$data = array('single_field'  => 'not_included',
		                'classification_employment'	=> 'not_included','payroll_period' 	=> '1',
		                'date_created' 		=> date('Y-m-d H:i:s'));
		}
		else{ return 'no_policy_setup'; }
		$this->db->where('payroll_settings_id',$payroll_setting_id);
		$this->db->update("payroll_setting",$data);
		if ($this->db->affected_rows() > 0)
		{
			return 'updated'; 
		}
		else{
			return 'error_updated'; 
		}
	}

	//not yet added policy\
	public function notyet_added_policy($company_id)
	{
		$this->db->select('*');
		$this->db->from('payroll_main_setting');
		$this->db->where('IsUserDefine','0');
		$this->db->where('payroll_main_id NOT IN (Select payroll_main_id from payroll_setting_policy where company_id='.$company_id.')');
		$query = $this->db->get();
		return  $query->result();
	}

	//asve new policy
	public function add_new_policy($company_id,$add_policy_id)
	{ 
		$data = array('payroll_main_id'  => $add_policy_id,'company_id' => $company_id,
		                'InActive'	=> '0'
		               );
		$query = $this->db->insert('payroll_setting_policy',$data);
		
	}

	public function company_classification($company_id)
	{
		$this->db->select('*');
		$this->db->from('classification');
		$this->db->where('company_id', $company_id);
	 	$query = $this->db->get();
	 	if($query->num_rows() > 0)
	 	{
	 	return $query->result();
	 	}
	 	else{ return 'no_data'; }
	}

	public function company_employment()
	{
		$this->db->select('*');
		$this->db->from('employment');
	 	$query = $this->db->get();
	 	return $query->result();
	}
	//saving policy with employment and classification
	public function insert_employment_classification($company_id,$policy_id,$policy_company_id,$converted1,$loop,$payroll_setting_id,$action)
	{
		$no_of_loop = $loop;
		$array =  explode('-', $converted1);
		$counter = 0;
		$start = 0;
		
		for ($x = 2; $x <= $no_of_loop; $x++) {
			${"tosaveval$counter"} = array_slice($array,$start,5);
			$class_id = ${"tosaveval$counter"}[0];
			$emp_1 = ${"tosaveval$counter"}[1];
			$emp_2 = ${"tosaveval$counter"}[2];
			$emp_3 = ${"tosaveval$counter"}[3];
			$emp_4 = ${"tosaveval$counter"}[4];

			$this->db->select('*');
			$this->db->from('payroll_setting');
			$this->db->where('payroll_setting_policy_id', $policy_company_id);
			$query3 = $this->db->get();
			if($query3->num_rows() == 0) {
			$data = array('payroll_setting_policy_id'  => $policy_company_id,'single_field'  => 'not_included',
		                  'classification_employment'	=> '1','payroll_period' 	=> 'not_included',
		                  'date_created' 		=> date('Y-m-d H:i:s'));
			$query = $this->db->insert('payroll_setting',$data);
			
			} else {}
			$this->db->select('*');
			$this->db->from('payroll_setting');
			$this->db->where('payroll_setting_policy_id',$policy_company_id);
			$query4 = $this->db->get();
			$payroll_setting_id = $query4->row("payroll_settings_id");

			for($i=1;$i < 5;$i++)
			{if($i==1){ $val_set = $emp_1; }elseif($i==2){ $val_set = $emp_2;  }elseif($i==3){ $val_set = $emp_3;  }else{ $val_set = $emp_4;  }
				if($action=='add')
				{
				$data1 = array(
							'payroll_settings_id' => $payroll_setting_id,
							'classification_id' => $class_id,
							'employment_id' => $i,
							'setting_value' => $val_set
							);
				$query = $this->db->insert('payroll_settings_employment_classification',$data1);
				}
				else{
					$data1 = array(
							'payroll_settings_id' => $payroll_setting_id,'classification_id' => $class_id,'employment_id' => $i,'setting_value' => $val_set);
						$this->db->where('payroll_settings_id',$payroll_setting_id);
						$this->db->where('classification_id',$class_id);
						$this->db->where('employment_id',$i);
						$this->db->update("payroll_settings_employment_classification",$data1); 	
				}	
			}	
			$start = $start + 5;
		}	
	}

	public function get_settings_id($payroll_settings_id,$class_id,$employment_id)
	{
		$this->db->select('*');
		$this->db->from('payroll_settings_employment_classification');
		$this->db->where(array('payroll_settings_id' => $payroll_settings_id,'classification_id'=>$class_id, 'employment_id'=>$employment_id));
		$query = $this->db->get();
		return  $query->row("setting_value");
	}

	//get paytype
	public function payroll_group_result($company_id,$pay_type)
	{
		$this->db->select('*');
		$this->db->from('payroll_period_group');
		$this->db->where(array('company_id'=>$company_id,'pay_type'=>$pay_type));
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else{ return 'no_data'; }
	}

	//group result
	public function payroll_period_result($company_id,$group,$pay_type)
	{
		$this->db->select('*');
		$this->db->from('payroll_period');
		$this->db->where(array('company_id'=>$company_id,'payroll_period_group_id'=>$group,'pay_type'=>$pay_type));
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else{ return 'no_data'; }
	}

	//save with payroll period
	public function add_setting_with_payroll_period($policy_id,$policy_company_id,$value1,$value2,$value3,$value4,$value5)
	{
		$data = array('payroll_setting_policy_id'  => $policy_company_id,'single_field'  => 'not_included',
		                  'classification_employment'	=> 'not_included','payroll_period' 	=> '1',
		                  'date_created' 		=> date('Y-m-d H:i:s'));

		$this->db->select('*');
		$this->db->from('payroll_setting');
		$this->db->where('payroll_setting_policy_id', $policy_company_id);
		$query = $this->db->get();
		$id_check =  $query->row("payroll_settings_id");
		if($query->num_rows()==0)
		{
			//insert in main table 
				$query_insert = $this->db->insert('payroll_setting',$data);
			//insert payroll period data if data inserted in main table
	      		if ($this->db->affected_rows() > 0)
	      		{   
			        $this->db->select('*');
			        $this->db->from('payroll_setting');
			        $this->db->where(array('payroll_setting_policy_id'=>$policy_company_id));
	          		$ress=$this->db->get(); 
	          		$payroll_setting_id =  $ress->row("payroll_settings_id");
	          		if($value1=='No'){ $value2_4='not included';} else{ $value2_4=$value2;}
	            	$datas = array('payroll_settings_id' => $payroll_setting_id,
	                    			'pay_type_id' => $value3,
	                    			'payroll_period_group_id' =>  $value4,
	                    			'payroll_period_id' =>  $value5,
	                    			'allow_view_payroll' =>  $value1,
	                    			'payroll_period_option' =>  $value2_4,
	                          		'date_created' => date('Y-m-d H:i:s'));
	              	$insert4 = $this->db->insert('payroll_setting_payroll_period',$datas);
	              	if ($this->db->affected_rows() > 0)
								{
									return 'inserted'; 
								}
								else{
									return 'error'; 
								}
	          	}
	         //if not inserted in main table
	          	else{ echo "not inserted"; }
		}
		else
		{
				$this->db->select('*');
	         	$this->db->from('payroll_setting_payroll_period');	
	          	$this->db->where(array('payroll_settings_id'=>$id_check,'pay_type_id'=>$value3,'payroll_period_group_id'=>$value4));
	          	$add_new = $this->db->get();
	          	 if($add_new->num_rows() > 0){ return 'exist';  }
	          	 else{
	          	 	if($value3=='no_val' AND $value4=='no_val'){}
	          	 	else{
	          	 		if($value1=='No'){ $value2_4='not included';} else{ $value2_4=$value2;}
	          	 		$add_newdata = array('payroll_settings_id' => $id_check,
	                      'pay_type_id' => $value3,
	                      'payroll_period_group_id' =>  $value4,
	                      'payroll_period_id' =>  $value5,
	                      'allow_view_payroll' =>  $value1,
	                      'payroll_period_option' =>  $value2_4,
	                      'date_created' => date('Y-m-d H:i:s'));
	            		$insert4 = $this->db->insert('payroll_setting_payroll_period',$add_newdata);
	            		if ($this->db->affected_rows() > 0)
								{
									return 'inserted'; 
								}
								else{
									return 'error'; 
								}
	          	 	}
	          	 }
		}
	}

	//get the payroll setting id
	public function get_setting_id($policy_company_id)
	{
		$this->db->select('*');
		$this->db->from('payroll_setting');
		$this->db->where('payroll_setting_policy_id', $policy_company_id);
		$query = $this->db->get();
		return $query->row("payroll_settings_id");
	}

	//payroll period list of data
	public function payrollperiod_data($payroll_setting_id)
	{
		$this->db->select('allow_view_payroll,payroll_period_option,payroll_setting4_id,payroll_setting_payroll_period.pay_type_id,pay_type_name,group_name,payroll_period_id,id,month_from,month_to,day_from,day_to,year_from,year_to,payroll_settings_id,payroll_period_group.payroll_period_group_id');
		$this->db->from('payroll_setting_payroll_period');
		$this->db->join('pay_type','pay_type.pay_type_id = payroll_setting_payroll_period.pay_type_id');
		$this->db->join('payroll_period_group','payroll_period_group.payroll_period_group_id = payroll_setting_payroll_period.payroll_period_group_id');
		$this->db->join('payroll_period','payroll_period.id = payroll_setting_payroll_period.payroll_period_id','left');
		$this->db->where('payroll_settings_id', $payroll_setting_id);
		$query = $this->db->get();
		return $query->result();
	}
	public function delete_setting4($payroll_setting_id,$pay_type,$group)
	{
		$this->db->where(array('payroll_setting4_id'=>$payroll_setting_id,'pay_type_id'=>$pay_type,'payroll_period_group_id'=>$group));
		$this->db->delete("payroll_setting_payroll_period");	
		if ($this->db->affected_rows() > 0)
		{
			return 'deleted'; 
		}
		else{
			return 'error'; 
		}
	}

	//update payroll period data
	public function update_payroll_details($payroll_setting4_id,$pay_type,$group)
	{
		$this->db->select('payroll_setting4_id,pay_type_name,group_name,id,payroll_period_id,allow_view_payroll,payroll_period_option,payroll_setting_payroll_period.payroll_settings_id,payroll_setting_payroll_period.pay_type_id,
							payroll_setting_payroll_period.payroll_period_group_id');
		$this->db->from('payroll_setting_payroll_period');
		$this->db->join('pay_type','pay_type.pay_type_id = payroll_setting_payroll_period.pay_type_id');
		$this->db->join('payroll_period_group','payroll_period_group.payroll_period_group_id = payroll_setting_payroll_period.payroll_period_group_id');
		$this->db->join('payroll_period','payroll_period.id = payroll_setting_payroll_period.payroll_period_id','left');
		$this->db->where('payroll_setting4_id', $payroll_setting4_id);
		$query = $this->db->get();
		return $query->result();
	}

	//save updated payroll data
	public function save_updatesetting_payroll($payroll_setting4_id,$policy_id,$policy_company_id,$payroll,$allow,$option)
	{
		if($payroll == 'not_included' && $allow=='No')
		{
			$option1 = 'not included';
		} else{ $option1 = $option; }


		$data = array(
			'payroll_period_id'	=>	$payroll,
			'allow_view_payroll' => $allow,
			'payroll_period_option' => $option1
		);

		$this->db->where('payroll_setting4_id',$payroll_setting4_id);
		$this->db->update("payroll_setting_payroll_period",$data);
		if ($this->db->affected_rows() > 0)
		{
			return 'updated'; 
		}
		else{
			return 'no_changes'; 
		}
	}

	public function insert_system_policy($title,$field,$input_type,$input_format_data)
	{
	
		$title_final = $this->payroll_settings_model->convert_char($title);
		$i4 = $this->payroll_settings_model->convert_char($title);

		$i1 = str_replace("%20"," ",$input_format_data);
		$i2 = str_replace(" -","-",$i1);
		$i3 = str_replace("- ","-",$i2);
		$i4 = str_replace(" - ","-",$i3);
		$i_final = $this->payroll_settings_model->convert_char($i4);

		if($field=='single_field'){ $a='1'; $b='0'; $c='0';}

		elseif($field=='employment_classification'){ $a='0'; $b='1'; $c='0'; }
		else{ $a='0'; $b='0'; $c='1'; }
		$data = array( 	'title'  => $title_final,
						'IsUserDefine'  => '0',
		                'date_created'  => date('Y-m-d H:i:s'),
		                'single_field'  => $a,
		                'employment_classification'  => $b,
		                'payroll_period'  => $c,
		                'input_type'  => $input_type,
		                'input_format'  => $i_final,
		                  );

		$query = $this->db->insert('payroll_main_setting',$data);
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

	public function system_policy_list()
	{
		$this->db->select('*');
		$this->db->from('payroll_main_setting');
		$query = $this->db->get();
		return $query->result();
	}
	public function delete_policy($payroll_main_id)
	{
		$this->db->where('payroll_main_id',$payroll_main_id);
		$this->db->delete("payroll_main_setting");	
		if ($this->db->affected_rows() > 0)
		{
			return 'deleted'; 
		}
		else{
			return 'error'; 
		}
	}
	public function policy_one($payroll_main_id)
	{
		$this->db->select('*');
		$this->db->from('payroll_main_setting');
		$this->db->where('payroll_main_id',$payroll_main_id);
		$query = $this->db->get();
		return $query->result();

	}

	public function update_system_policy($payroll_main_id,$field,$input_type,$input_format_data,$title)
	{
		$title1 = str_replace("%20"," ",$title);
		$input_format_data1 = str_replace("%20"," ",$input_format_data);
		if($field=='single_field'){ $a='1'; $b='0'; $c='0';}
		elseif($field=='employment_classification'){ $a='0'; $b='1'; $c='0'; }
		else{ $a='0'; $b='0'; $c='1'; }
		$data = array( 	'title'  => $title1,
						'IsUserDefine'  => '0',
		                'date_created'  => date('Y-m-d H:i:s'),
		                'single_field'  => $a,
		                'employment_classification'  => $b,
		                'payroll_period'  => $c,
		                'input_type'  => $input_type,
		                'input_format'  => $input_format_data1,
		                  );
		$this->db->where('payroll_main_id',$payroll_main_id);
		$this->db->update("payroll_main_setting",$data);
		if ($this->db->affected_rows() > 0)
		{
			return 'updated'; 
		}
		else{
			return 'error_updated'; 
		}
	}
}			