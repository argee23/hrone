<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_account_management_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function policy_list()
	{
		$this->db->select('*');
		$this->db->from('account_management_policy_settings');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_table_list()
	{		
		$this->db->select('TABLE_NAME');
		$this->db->from('INFORMATION_SCHEMA.TABLES');
		$this->db->where('TABLE_TYPE','BASE TABLE');
		$this->db->where('TABLE_SCHEMA','hrone');
		$query = $this->db->get();
		return $query->result();
	}

	public function table_fields($table_list)
	{
		$fields = $this->db->list_fields($table_list);
		return $fields;
	}
	public function default_password_selection()
	{
		$query = $this->db->get('employee_mass_update');
		return $query->result();
	}

	//insert account scurity
	public function insert_acct_security($option_results,$additional_data,$note,$title)
	{
		$additional_datas = substr_replace($additional_data, "", -1);
		$title1 = str_replace("%20"," ",$title); 	$note1 = str_replace("%20"," ",$note);
		$title2 = str_replace(" %28","(",$title1);  $note2 = str_replace("%20"," ",$note1);
		$title3 = str_replace(" %29","(",$title2);	$note3 = str_replace("%20"," ",$note2);
		$title4 = str_replace("%2C",",",$title3);	$note4 = str_replace("%20"," ",$note3);
		$title5 = str_replace("%3F","?",$title4);	$note5 = str_replace("%20"," ",$note4);
		if($option_results=='account_sec')
		{ $a ='1'; $b='0'; $c='0'; $d='0'; $e='0';}
		elseif($option_results=='govt_fields')
		{ $a ='0'; $b='1'; $c='0'; $d='0'; $e='0'; }
		elseif($option_results=='dis_acct')
        { $a ='0'; $b='0'; $c='1'; $d='0'; $e='0'; }
        elseif($option_results=='notif')
        { $a ='0'; $b='0'; $c='0'; $d='1'; $e='0'; }
        else 
        { $a ='0'; $b='0'; $c='0'; $d='0'; $e='1'; }
		$data = array('title' 				=> $title5,
					  'account_security'    => $a,
					  'government_fields'   => $b,
					  'disable_account'    	=> $c,
					  'emp_hired_notif'     => $d,
					  'others'    			=> $e,
					  'note'    			=> $note5,
					  'mob_tel_format'		=> 0,
					  'additional_functions'=> $additional_datas,
					  'date_created'    	=> date('Y-m-d H:i:s')
					 );

		$query = $this->db->insert('account_management_policy_settings',$data);
	}
	public function save_mo_tel_format($option,$note,$title)
	{
		$title1 = str_replace("%20"," ",$title); 	$note1 = str_replace("%20"," ",$note);
		$title2 = str_replace(" %28","(",$title1);  $note2 = str_replace("%20"," ",$note1);
		$title3 = str_replace(" %29","(",$title2);	$note3 = str_replace("%20"," ",$note2);
		$title4 = str_replace("%2C",",",$title3);	$note4 = str_replace("%20"," ",$note3);
		$title5 = str_replace("%3F","?",$title4);	$note5 = str_replace("%20"," ",$note4);

		$data = array('title' 				=> $title5,
					  'account_security'    => 0,
					  'government_fields'   => 0,
					  'disable_account'    	=> 0,
					  'emp_hired_notif'     => 0,
					  'others'    			=> 0,
					  'mob_tel_format'		=> 1,
					  'note'    			=> $note5,
					  'additional_functions'=> 'none',
					  'date_created'    	=> date('Y-m-d H:i:s')
					 );

		$query = $this->db->insert('account_management_policy_settings',$data);
	}

	//get the policy details
	public function policy_details($account_management_policy_id)
	{
		$this->db->select('*');
		$this->db->from('account_management_policy_settings');
		$this->db->where('account_management_policy_id', $account_management_policy_id);
		$query = $this->db->get();
		return $query->result();

	}
	public function check_data($value)
	{ 
		$this->db->select('*');
		$this->db->from('employee_mass_update');
		if($value=='data_exist')
		{ $this->db->where('isDefaultPassword', '1'); } else{}
		$query = $this->db->get();
		return $query->result();
	}

	//for reset all employee password
	//ACCOUNT MANAGEMNET
	public function get_default_password(){ 
		$this->db->where(array(
			'isDefaultPassword'		=>	1
		));
		$query = $this->db->get("employee_mass_update");
		return $query->row();
	}
	
	public function get_active_employee(){ 
		$query = $this->db->get("employee_info");
		return $query->result();
	}

	public function reset_password_default_save($set_default,$employee_id){

		$get_setting = $this->encryption_setting();
		if(!empty($get_setting) AND $get_setting=='yes')
		{
			$password = $this->encrypt->encode($set_default);
			$setting = 1;
		}
		else
		{
			$password = $set_default;
			$setting = 0;
		}

		$this->data = array(
			'password'			=>	$password,
			'encrypt_password'	=>	$setting
		);
		$this->db->where('employee_id',$employee_id);
		$this->db->update("employee_info",$this->data);
	}

	//for downloading the employee password
	public function get_employee_account(){ 
		$this->db->select("employee_id, fullname, username, password");	
		$query = $this->db->get("employee_info");
		return $query->result();
	}

	public function reset_default_password($action,$default_password){ 
		if($action=='update')
		{	
			$this->data1 = array(
				'isDefaultPassword'		=>		0
			);
			$this->db->update("employee_mass_update",$this->data1);
		}

		if($action=='insert' || $action=='update')
		{
			$this->data = array(
				'isDefaultPassword'		=>		1
			);
		}
		$this->db->where('id',$default_password);
		$this->db->update("employee_mass_update",$this->data);
	}

	public function table_govt_fields()
	{
		$fields = $this->db->list_fields('emp_government_field');
		return $fields;
	}

	public function get_government_fields(){ 
		$query = $this->db->get("emp_government_field");
		return $query->result();
	}

	//for govt fields
	public function insert_govt_fields($action,$loop,$converted1,$number_fields,$additional_functions)
    {

		$no_of_loop = $loop;
		$array =  explode('qq', $converted1);
		$counter = 0;
		$start = 0;
		$n = $number_fields - 1;
		for ($x = 2; $x <= $no_of_loop; $x++) {
			
			${"tosaveval$counter"} = array_slice($array,$start,$number_fields);

			  	$field_id = ${"tosaveval$counter"}[0];
				
				for ($xx = 1; $xx <= $n; $xx++) {  
					$a = '$'.$xx; 
					 $a = ${"tosaveval$counter"}[$xx];
					$var=explode('-',$additional_functions); 
                	$i = 1; foreach ($var as $additional) { 
						$c = $additional;
                		if($xx==$i){ 

						$logtrailtitle="$c";
						$logtraildata="$a";

						/*
						--------------audit trail composition--------------
						(module,module dropdown,logfiletable,detailed action,action type,key value)
						--------------audit trail composition--------------
						*/
						$this->general_model->system_audit_trail('201 Employee','Employee 201 Settings','logfile_employee_acc_mngt','update government fields format for :'.$field_id.' '.$logtrailtitle,'UPDATE',$logtraildata);

                			$data1 = array($c => $a);
							$this->db->where('field_id',$field_id);
							$this->db->update("emp_government_field",$data1);
                		 }
                	$i= $i+1;
                	} 
				}
			$start = $start + $number_fields;
		}
    }

    //company list

   public function get_companyList(){ 
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$query = $this->db->get("company_info");
		return $query->result();
	}

	//location list by company
	public function get_company_location($onchange_val){ 
		$this->db->where('A.company_id',$onchange_val);
		$this->db->order_by('B.location_name','asc');
		$this->db->join("location B","B.location_id = A.location_id","left outer");
		$query = $this->db->get("company_location A");
		return $query->result();
	}

	//division by company

	public function get_company_division($onchange_val){
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->where('company_id',$onchange_val);
		$query = $this->db->get("division");
		return $query->result();
	}


	//department by company
	public function get_company_department($onchange_val,$company){
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->where('division_id',$onchange_val);
		$this->db->where('company_id',$company);
		$query = $this->db->get("department");
		return $query->result();
	}

	//section
	public function get_department_section($onchange_val){ 
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->where('department_id',$onchange_val);
		$query = $this->db->get("section");
		return $query->result();
	}

	//subsection
	public function get_department_subsection($onchange_val){ 
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->where('section_id',$onchange_val);
		$query = $this->db->get("subsection");
		return $query->result();
	}

	//employment list
	public function get_employmentList(){ 
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$query = $this->db->get("employment");
		return $query->result();
	}

	//classification
	public function get_company_classification($onchange_val){
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->where('company_id',$onchange_val);
		$query = $this->db->get("classification");
		return $query->result();
	}

	public function get_positionList(){ 
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$query = $this->db->get("position");
		return $query->result();
	}

	//update disable
	public function update_disable($option,$data_check,$data_uncheck,$company,$account_management_policy_id,$division,$department,$section)
 	{	  
		 	$data_check1 = substr_replace($data_check, "", -1);
			$var = explode("-",$data_check1);
			$data_uncheck1 = substr_replace($data_uncheck, "", -1);
			$var1 = explode("-",$data_uncheck1);

			if($option=='Company')
			{
				foreach ($var1 as $row1) {
					
					$this->db->where('company_id',$row1);
					$this->db->delete("account_management_disable_account");
				}
			}

			
			if($option=='Company')
			{
				
				foreach ($var as $row) {

					if($row=='non'){}
					else{
					$this->db->select("*");
					$this->db->from("account_management_disable_account");
					$this->db->where('company_id',$row);
					$query = $this->db->get();
					$result = $query->row("company_id");

					if(empty($result))
					{
						$this->data = array('account_management_policy_id' => $account_management_policy_id,
											'company_id' => $row,'all'	=>	1);
						$this->db->insert("account_management_disable_account",$this->data);
					}
					else
					{ 
						$this->data = array('all'	=>	1,'location' => 0, 'division' => 0, 'department' => 0,
											 'section' => 0, 'subsection' => 0, 'employment' => 0,
											  'classification' => 0, 'position' => 0,'date_created'=> date('Y-m-d H:i:s'));
						$this->db->where('company_id',$row);
						$this->db->update("account_management_disable_account",$this->data);
					}
				}

				}
			}	
			elseif($option=='Location')
			{
					
					$this->db->select("*");
					$this->db->from("account_management_disable_account");
					$this->db->where('company_id',$company);
					$query = $this->db->get();
					$result = $query->row("company_id");
					if($data_check1=='non'){ $data_check1 = 0; }

					if(empty($result))
					{ 
						$this->data = array('account_management_policy_id' => $account_management_policy_id,
											'company_id' => $company,'all'	=>	0,'location' => $data_check1, 'division' => 0, 'department' => 0,
											'section' 	=> 0, 'subsection' => 0, 'employment' => 0,
											'classification' => 0, 'position' => 0,'date_created'=> date('Y-m-d H:i:s'));
						$this->db->insert("account_management_disable_account",$this->data);
					}
					else
					{ 
						$this->data = array('all'	=>	0,'location' => $data_check1);
						$this->db->where('company_id',$company);
						$this->db->update("account_management_disable_account",$this->data);
					}
			}
			elseif($option=='Division')
			{
					
					$this->db->select("*");
					$this->db->from("account_management_disable_account");
					$this->db->where('company_id',$company);
					$query = $this->db->get();
					$result = $query->row("company_id");
					if($data_check1=='non'){ $data_check1 = 0; }

					if(empty($result))
					{ 
						$this->data = array('account_management_policy_id' => $account_management_policy_id,
											'company_id' => $company,'all'	=>	0,'location' => 0, 'division' => $data_check1, 'department' => 0,
											'section' 	=> 0, 'subsection' => 0, 'employment' => 0,
											'classification' => 0, 'position' => 0,'date_created'=> date('Y-m-d H:i:s'));
						$this->db->insert("account_management_disable_account",$this->data);
					}
					else
					{ 
						$this->data = array('all'	=>	0,'division' => $data_check1);
						$this->db->where('company_id',$company);
						$this->db->update("account_management_disable_account",$this->data);
					}
			}
			elseif($option=='Department')
			{
					
					$this->db->select("*");
					$this->db->from("account_management_disable_account");
					$this->db->where('company_id',$company);
					$query = $this->db->get();
					$result = $query->row("company_id");
					if($data_check1=='non'){ $data_check1 = 0; }

					if(empty($result))
					{ 
						$this->data = array('account_management_policy_id' => $account_management_policy_id,
											'company_id' => $company,'all'	=>	0,'location' => 0, 'division' => $division, 'department' => $data_check1,
											'section' 	=> 0, 'subsection' => 0, 'employment' => 0,
											'classification' => 0, 'position' => 0,'date_created'=> date('Y-m-d H:i:s'));
						$this->db->insert("account_management_disable_account",$this->data);
					}
					else
					{ 
						$this->data = array('all'	=>	0,'division' => $division,'department' => $data_check1);
						$this->db->where('company_id',$company);
						$this->db->update("account_management_disable_account",$this->data);
					}
			}
			elseif($option=='Section')
			{
					
					$this->db->select("*");
					$this->db->from("account_management_disable_account");
					$this->db->where('company_id',$company);
					$query = $this->db->get();
					$result = $query->row("company_id");
					if($data_check1=='non'){ $data_check1 = 0; }

					if(empty($result))
					{ 
						$this->data = array('account_management_policy_id' => $account_management_policy_id,
											'company_id' => $company,'all'	=>	0,'location' => 0, 'division' => $division, 'department' => $department,
											'section' 	=> $data_check1, 'subsection' => 0, 'employment' => 0,
											'classification' => 0, 'position' => 0,'date_created'=> date('Y-m-d H:i:s'));
						$this->db->insert("account_management_disable_account",$this->data);
					}
					else
					{ 
						$this->data = array('all'	=>	0,'division' => $division,'department' => $department,'section' => $data_check1);
						$this->db->where('company_id',$company);
						$this->db->update("account_management_disable_account",$this->data);
					}
			}
			elseif($option=='SubSection')
			{
					
					$this->db->select("*");
					$this->db->from("account_management_disable_account");
					$this->db->where('company_id',$company);
					$query = $this->db->get();
					$result = $query->row("company_id");
					if($data_check1=='non'){ $data_check1 = 0; }

					if(empty($result))
					{ 
						$this->data = array('account_management_policy_id' => $account_management_policy_id,
											'company_id' => $company,'all'	=>	0,'location' => 0, 'division' => $division, 'department' => $department,
											'section' 	=> $section, 'subsection' => $data_check1, 'employment' => 0,
											'classification' => 0, 'position' => 0,'date_created'=> date('Y-m-d H:i:s'));
						$this->db->insert("account_management_disable_account",$this->data);
					}
					else
					{ 
						$this->data = array('all'	=>	0,'division' => $division,'department' => $department,'section' => $section,'subsection' =>$data_check1);
						$this->db->where('company_id',$company);
						$this->db->update("account_management_disable_account",$this->data);
					}
			}
			elseif($option=='Employment')
			{
					
					$this->db->select("*");
					$this->db->from("account_management_disable_account");
					$this->db->where('company_id',$company);
					$query = $this->db->get();
					$result = $query->row("company_id");
					if($data_check1=='non'){ $data_check1 = 0; }

					if(empty($result))
					{ 
						$this->data = array('account_management_policy_id' => $account_management_policy_id,
											'company_id' => $company,'all'	=>	0,'location' => 0, 'division' => 0, 'department' => 0,
											'section' 	=> 0, 'subsection' => 0, 'employment' => $data_check1,
											'classification' => 0, 'position' => 0,'date_created'=> date('Y-m-d H:i:s'));
						$this->db->insert("account_management_disable_account",$this->data);
					}
					else
					{ 
						$this->data = array('all'	=>	0,'employment' => $data_check1);
						$this->db->where('company_id',$company);
						$this->db->update("account_management_disable_account",$this->data);
					}
			}
			elseif($option=='Classification')
			{
					
					$this->db->select("*");
					$this->db->from("account_management_disable_account");
					$this->db->where('company_id',$company);
					$query = $this->db->get();
					$result = $query->row("company_id");
					if($data_check1=='non'){ $data_check1 = 0; }

					if(empty($result))
					{ 
						$this->data = array('account_management_policy_id' => $account_management_policy_id,
											'company_id' => $company,'all'	=>	0,'location' => 0, 'division' => 0, 'department' => 0,
											'section' 	=> 0, 'subsection' => 0, 'employment' => 0,
											'classification' => $data_check1, 'position' => 0,'date_created'=> date('Y-m-d H:i:s'));
						$this->db->insert("account_management_disable_account",$this->data);
					}
					else
					{ 
						$this->data = array('all'	=>	0,'classification' => $data_check1);
						$this->db->where('company_id',$company);
						$this->db->update("account_management_disable_account",$this->data);
					}
			}
			elseif($option=='Position')
			{
					
					$this->db->select("*");
					$this->db->from("account_management_disable_account");
					$this->db->where('company_id',$company);
					$query = $this->db->get();
					$result = $query->row("company_id");
					if($data_check1=='non'){ $data_check1 = 0; }

					if(empty($result))
					{ 
						$this->data = array('account_management_policy_id' => $account_management_policy_id,
											'company_id' => $company,'all'	=>	0,'location' => 0,'position' => $data_check1, 
											'division' => 0, 'department' => 0,
											'section' 	=> 0, 'subsection' => 0, 'employment' => 0,
											'classification' => 0, 'position' => $data_check1,'date_created'=> date('Y-m-d H:i:s'));
						$this->db->insert("account_management_disable_account",$this->data);
					}
					else
					{ 
						$this->data = array('all'	=>	0,'position' => $data_check1);
						$this->db->where('company_id',$company);
						$this->db->update("account_management_disable_account",$this->data);
					}
			}
	}


//insert others
	public function insert_others_setting($option_results,$converted1,$loop,$note,$title)
	{
			
			$array =  explode('qq', $converted1);
			$counter = 0;
			$start = 0;
			$i=1;
			$title1 = str_replace("%20"," ",$title); 	$note1 = str_replace("%20"," ",$note);
			$title2 = str_replace(" %28","(",$title1);  $note2 = str_replace("%20"," ",$note1);
			$title3 = str_replace(" %29","(",$title2);	$note3 = str_replace("%20"," ",$note2);
			$title4 = str_replace("%2C",",",$title3);	$note4 = str_replace("%20"," ",$note3);
			$title5 = str_replace("%3F","?",$title4);	$note5 = str_replace("%20"," ",$note4);
			
			if($option_results=='account_sec')
			{ $a ='1'; $b='0'; $c='0'; $d='0'; $e='0';}
			elseif($option_results=='govt_fields')
			{ $a ='0'; $b='1'; $c='0'; $d='0'; $e='0'; }
			elseif($option_results=='dis_acct')
	        { $a ='0'; $b='0'; $c='1'; $d='0'; $e='0'; }
	        elseif($option_results=='notif')
	        { $a ='0'; $b='0'; $c='0'; $d='1'; $e='0'; }
	        else 
	        { $a ='0'; $b='0'; $c='0'; $d='0'; $e='1'; }
			$main = array('title' 				=> $title5,
					  'account_security'    => $a,
					  'government_fields'   => $b,
					  'disable_account'    	=> $c,
					  'emp_hired_notif'     => $d,
					  'others'    			=> $e,
					  'note'    			=> $note5,
					  'additional_functions'=> 'none',
					  'date_created'    	=> date('Y-m-d H:i:s')
					 );
			$query_main = $this->db->insert('account_management_policy_settings',$main);

			$this->db->select_max('account_management_policy_id');
			$this->db->from('account_management_policy_settings');
			$this->db->where('others','1');
			$querymain = $this->db->get();
			$policy= $querymain->row('account_management_policy_id');
			
			for ($x = 2; $x <= $loop; $x++) {
				
				${"tosaveval$counter"} = array_slice($array,$start,3);

				  	$f1 = ${"tosaveval$counter"}[0];
					$f2 = ${"tosaveval$counter"}[1];
					$f3 = ${"tosaveval$counter"}[2];

					 $ff = str_replace("%20"," ",$f1); 	
					 $ff2 = str_replace(" %28","(",$ff);  
					 $ff3 = str_replace(" %29","(",$ff2);	
					 $ff4 = str_replace("%2C",",",$ff3);	
				 	 $ff5 = str_replace("%3F","?",$ff4);
				 	 $aa = str_replace("%20"," ",$f3); 	
					 $a1 = str_replace(" %28","(",$aa);  
					 $a2 = str_replace(" %29","(",$a1);	
					 $a3 = str_replace("%2C",",",$a2);	
				 	 $a4 = str_replace("%3F","?",$a3);
			
					$data = array('account_management_policy_id' => $policy,
					  		'fields_no'    => $i,
					  		'title'   => $ff5,
					 		'input_type'    	=> $f2,
					  		'input_format'     => $a4);
				$i=$i+1;
				$query = $this->db->insert('account_management_others_setup',$data);
				$start = $start + 3;
			}
			
	}

	public function get_policy_fields($policy_id)
	{
		$this->db->select("*");
		$this->db->from("account_management_others_setup");
		$this->db->where("account_management_policy_id",$policy_id);
		$query = $this->db->get();
		return $query->result();
	}

	//save others data
	public function insert_others_data($loop,$converted1,$action,$option,$account_management_policy_id)
	{
			$array =  explode('qq', $converted1);
			$counter = 0;
			$start = 0;
			$i=1;
			
			for ($x = 2; $x <= $loop; $x++) {
				
				${"tosaveval$counter"} = array_slice($array,$start,2);

				  	
					$c = ${"tosaveval$counter"}[0];
					$b = ${"tosaveval$counter"}[1];

					 $c1 = str_replace("%20"," ",$c); 	
					 $c2 = str_replace(" %28","(",$c1);  
					 $c3 = str_replace(" %29","(",$c2);	
					 $c4 = str_replace("%2C",",",$c3);	
				 	 $c5 = str_replace("%3F","?",$c4);
				
				if($action=='insert')
				{
					$data = array('account_management_others_setup_id' => $b,
					  		'datas'    => $c5
					  		);
				
					$i=$i+1;
					$query = $this->db->insert('account_management_others_data',$data);
					if($this->db->affected_rows() > 0)
					{
						$update_employee_pass = $this->password_encryption_checker($c5);
					}
				}
				else{
					 $this->data = array(
							'datas'		=>		$c5);
					$this->db->where('account_management_others_setup_id',$b);
					$this->db->update("account_management_others_data",$this->data);
					if($this->db->affected_rows() > 0)
					{
						$update_employee_pass = $this->password_encryption_checker($c5);
					}
					
				}
				
				$start = $start + 2;
			}

	}

	public function others_data($account_management_policy_id)
	{
		$this->db->select("account_management_policy_settings.account_management_policy_id,account_management_others_setup.account_management_others_setup_id,datas,input_type,account_management_others_setup.title,input_format");
		$this->db->from("account_management_policy_settings");
		$this->db->join("account_management_others_setup","account_management_others_setup.account_management_policy_id=account_management_policy_settings.account_management_policy_id");
		$this->db->join("account_management_others_data","account_management_others_data.account_management_others_setup_id=account_management_others_setup.account_management_others_setup_id");
		$this->db->where("account_management_policy_settings.account_management_policy_id",$account_management_policy_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function save_designation_value($company,$division,$department,$section,$subsection,$status,$location,$classification,$employment,$no_to_view,$view_option,$account_management_policy_id)
	{
		$location_f = substr_replace($location, "", -1);
		$classification_f = substr_replace($classification, "", -1);
		$employment_f = substr_replace($employment, "", -1);
		$status_f = substr_replace($status, "", -1);
		$data= array(
							'account_management_policy_id'		=>		$account_management_policy_id,
							'viewed_by'							=>		$view_option,
							'days_to_view'						=>		$no_to_view,
							'date_created'						=>		date('Y-m-d H:i:s')
							);
		$this->db->insert("emp_hired_notification",$data);

		$this->db->select_max('emp_hired_notif_id');
		$this->db->from('emp_hired_notification');
		$this->db->where('account_management_policy_id',$account_management_policy_id);
		$querymain = $this->db->get();
		$emp_hired_notif_id= $querymain->row('emp_hired_notif_id');


		$this->data = array('emp_hired_notif_id' => $emp_hired_notif_id,
							'company'		=>		$company,
							'division'		=>		$division,
							'department'	=>		$department,
							'section'		=>		$section,
							'subsection'	=>		$subsection,
							'classification'=>		$classification_f,
							'employment'	=>		$employment_f,
							'location'      =>		$location_f,
							'status'		=>		$status_f);
			$this->db->insert("emp_hired_notif_designation",$this->data);
	}

	public function save_all_value($no_to_view,$view_option,$account_management_policy_id)
	{
			$this->data = array(
							'account_management_policy_id'		=>		$account_management_policy_id,
							'viewed_by'							=>		$view_option,
							'days_to_view'						=>		$no_to_view,
							'date_created'						=>		date('Y-m-d H:i:s')
							);
			$this->db->insert("emp_hired_notification",$this->data);
	}

	public function check_notif($account_management_policy_id)
	{
		$this->db->select('*');
		$this->db->from('emp_hired_notification');
		$this->db->where('account_management_policy_id',$account_management_policy_id);
		$querymain = $this->db->get();
		return $querymain->result();
	}
	public function company_details()
	{
		$this->db->select('*');
		$this->db->from('company_info');
		$this->db->where('InActive','0');
		$querymain = $this->db->get();
		return $querymain->result();
	}

	//save notification all
	public function save_notifdata_all($company_id,$comp_option,$account_management_policy_id,$notif_days_view)
	{
		$data = array(
				'account_management_policy_id' => $account_management_policy_id,
				'company_id' => $company_id,
				'action_option' =>$comp_option,
				'days_to_view' => $notif_days_view,
				'date_created' =>date('Y-m-d H:i:s'));

		$this->db->insert('emp_hired_notification',$data);

	}

	//check if company id exist
	public function company_notif_exist($option)
	{
		$this->db->select('*');
		$this->db->from('emp_hired_notification');
		$this->db->where('company_id',$option);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{ return 'exist'; }
		else{
			return 'not_exist';
		}
	}

	//company notif details
	public function get_company_notif_details($company_id)
	{
		$this->db->select('*');
		$this->db->from('emp_hired_notification');
		$this->db->where('company_id',$company_id);
		$query = $this->db->get();
		return $query->result();
	}

	//compant info
	public function company_info($company_id)
	{
		$this->db->select('*');
		$this->db->from('company_info');
		$this->db->where('company_id',$company_id);
		$query = $this->db->get();
		return $query->result();
	}

	//save notif with multi company optionk
	public function save_notifdata_multi($company_id,$comp_option,$account_management_policy_id,$notif_days_view,$data_check)
	{
		$data_checks = substr_replace($data_check, "", -1);
		$data = array(
				'account_management_policy_id' => $account_management_policy_id,
				'company_id' => $company_id,
				'action_option' =>$comp_option,
				'days_to_view' => $notif_days_view,
				'option_for_multicompany' =>$data_checks,
				'date_created' =>date('Y-m-d H:i:s'));

		$this->db->insert('emp_hired_notification',$data);
	}


	//for one company per desigantion
	public function divisionList($company_id)
	{
		$this->db->select('*');
		$this->db->from('division');
		$this->db->where('company_id',$company_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_department($options,$value,$company_id)
	{ 
		if($value=='no_data')
			{ 
				$this->db->select('*');
				$this->db->from('department');
				$this->db->where('company_id',$company_id);
				$query = $this->db->get();
				return $query->result();
			}
		else{ 
			if($options=='update')
			{ $division =$value; }
			else{
				$division = substr_replace($value, "", -1);
			}			
			$var = explode("-",$division);
			$this->db->select('*,division.division_id,department.company_id,department.InActive');
			$this->db->from('department');
			$this->db->join('division','division.division_id=department.division_id');
			$this->db->where('department.company_id',$company_id);
			foreach ($var as $row) { 
				$this->db->or_where('department.division_id',$row);
			}
			$query = $this->db->get();
			return $query->result();
		}
	}

	//section data based on department
	public function get_section($options,$value,$company_id,$division)
	{ 
			if($options=='update')
			{ $division =$value; }
			else{
				$division = substr_replace($value, "", -1);
			}
			
			$var = explode("-",$division);
			$this->db->select('section_name,section_id,department.department_id,company_id,section.department_id,section.InActive');
			$this->db->from('section');
			$this->db->join('department','department.department_id=section.department_id');
			$this->db->where('section.InActive','0');
			$this->db->where('company_id',$company_id);
			foreach ($var as $row) {
				$this->db->or_where('section.department_id',$row);
			}
			$query = $this->db->get();
			return $query->result();
		
	}

	//subsection list
	public function get_subsection($options,$value,$company_id,$division,$department)
	{
			if($options=='update')
			{ $section_id =$value; }
			else{
				$section_id = substr_replace($value, "", -1);
			}
			
			$var = explode("-",$section_id);
			$this->db->select('*');
			$this->db->from('subsection');
			foreach ($var as $row) {
				$this->db->or_where('section_id',$row);
						}
				$query = $this->db->get();
				return $query->result();
		
	}

	public function insert_notif_one_emp($company,$division,$department,$section,$subsection,$classification,$employment,$status,$location,$account_management_policy_id,$no_to_view,$view_option,$company_view)
		{	
			if($division=='no_data' || $division=='All'){ $division1 = $division; }
			else{ $division1 = substr_replace($division, "", -1); }
			
			if($department=='no_data' || $department=='All'){ $department1 = $department; }
			else{ $department1 = substr_replace($department, "", -1); }
			
			if($section=='no_data' || $section=='All'){ $section1 = $section; }
			else{ $section1 = substr_replace($section, "", -1); }

			if($subsection=='no_data' || $subsection=='All'){ $subsection1 = $subsection; }
			else{ $subsection1 = substr_replace($subsection, "", -1); }

			if($employment=='no_data' || $employment=='All'){ $employment1 = $employment; }
			else{ $employment1 = substr_replace($employment, "", -1); }

			if($classification=='no_data' || $classification=='All'){ $classification1 = $classification; }
			else{ $classification1 = substr_replace($classification, "", -1); }

			if($location=='no_data' || $location=='All'){ $location1 = $location; }
			else{ $location1 = substr_replace($location, "", -1); }

			if($status=='no_data' || $status=='All'){ $status1 = $status; }
			else{ $status1 = substr_replace($status, "", -1); }

			

			$data= array(	'account_management_policy_id'		=>		$account_management_policy_id,
							'company_id'						=>		$company,
							'action_option'						=>		$view_option,
							'days_to_view'						=>		$no_to_view,
							'date_created'						=>		date('Y-m-d H:i:s')
							);
		$this->db->insert("emp_hired_notification",$data);

		$this->db->select_max('emp_hired_notif_id');
		$this->db->from('emp_hired_notification');
		$this->db->where('account_management_policy_id',$account_management_policy_id);
		$this->db->where('company_id',$company);
		$querymain = $this->db->get();
		$emp_hired_notif_id= $querymain->row('emp_hired_notif_id');

		$data1= array('emp_hired_notif_id'	=>		$emp_hired_notif_id,
							'company'			=>		$company_view,
							'division'			=>		$division1,
							'department'		=>		$department1,
							'section'			=>		$section1,
							'subsection'		=>		$subsection1,
							'classification'	=>		$classification1,
							'employment'		=>		$employment1,
							'location'			=>		$location1,
							'status'			=>		$status1
							);
		$this->db->insert("emp_hired_notif_designation",$data1);

		}

		//notit company set up list
		public function notif_setup()
		{
			$this->db->select('*,company_name');
			$this->db->from('emp_hired_notification');
			$this->db->join('company_info','company_info.company_id=emp_hired_notification.company_id');
			$query = $this->db->get();
			return $query->result();
		}

		public function delete_notif($company_id,$account_management_policy_id)
		{
			$this->db->select('*');
			$this->db->from('emp_hired_notification');
			$this->db->where('company_id',$company_id);
			$this->db->where('account_management_policy_id',$account_management_policy_id);
			$query = $this->db->get();
			$id = $query->row('emp_hired_notif_id');

			$this->db->where('emp_hired_notif_id',$id);
			$this->db->delete("emp_hired_notif_designation");
			$this->db->where('emp_hired_notif_id',$id);
			$this->db->delete("emp_hired_notification");
		}

		public function updatesave_notif_all($options,$datas,$company_id,$account_management_policy_id,$notif_days_view_update)
		{ 
			if($options=='All' || $options=='One_specs')
			{
				$data = array('days_to_view' => $notif_days_view_update);
				$this->db->where('company_id',$company_id);
				$this->db->where('account_management_policy_id',$account_management_policy_id);
				$this->db->update("emp_hired_notification",$data);
			}
			else if($options=='Multi')
			{				$datass = substr_replace($datas, "", -1);
				$d = array('days_to_view' => $notif_days_view_update,
								'option_for_multicompany' => $datass);
				$this->db->where('company_id',$company_id);
				$this->db->where('account_management_policy_id',$account_management_policy_id);
				$this->db->update("emp_hired_notification",$d);
			}
		}

		public function get_emp_hired($company_id)
		{ 
			$this->db->select_max('emp_hired_notif_id');
			$this->db->from('emp_hired_notification');
			$this->db->where('company_id',$company_id);
			$querymain = $this->db->get();
			$emp_hired_notif_id= $querymain->row('emp_hired_notif_id');

			$this->db->select('*');
			$this->db->from('emp_hired_notif_designation');
			$this->db->where('emp_hired_notif_id',$emp_hired_notif_id);
			$query = $this->db->get();
			return $query->result();
		}
		public function update_notif_one_emp($company,$division,$department,$section,$subsection,$classification,$employment,$status,$location,$account_management_policy_id,$no_to_view,$view_option,$company_view)
		{
			$this->db->select('emp_hired_notif_id');
			$this->db->from('emp_hired_notification');
			$this->db->where('company_id',$company);
			$querymain = $this->db->get();
			$emp_hired_notif_id= $querymain->row('emp_hired_notif_id');

			$this->db->where('emp_hired_notif_id',$emp_hired_notif_id);
			$this->db->delete("emp_hired_notif_designation");

			$this->db->where('emp_hired_notif_id',$emp_hired_notif_id);
			$this->db->delete("emp_hired_notification");	
			

			if($division=='no_data' || $division=='All'){ $division1 = $division; }
			else{ $division1 = substr_replace($division, "", -1); }
			
			if($department=='no_data' || $department=='All'){ $department1 = $department; }
			else{ $department1 = substr_replace($department, "", -1); }
			
			if($section=='no_data' || $section=='All'){ $section1 = $section; }
			else{ $section1 = substr_replace($section, "", -1); }

			if($subsection=='no_data' || $subsection=='All'){ $subsection1 = $subsection; }
			else{ $subsection1 = substr_replace($subsection, "", -1); }

			if($employment=='no_data' || $employment=='All'){ $employment1 = $employment; }
			else{ $employment1 = substr_replace($employment, "", -1); }

			if($classification=='no_data' || $classification=='All'){ $classification1 = $classification; }
			else{ $classification1 = substr_replace($classification, "", -1); }

			if($location=='no_data' || $location=='All'){ $location1 = $location; }
			else{ $location1 = substr_replace($location, "", -1); }

			
			$data= array(	'account_management_policy_id'		=>		$account_management_policy_id,
							'company_id'						=>		$company,
							'action_option'						=>		$view_option,
							'days_to_view'						=>		$no_to_view,
							'date_created'						=>		date('Y-m-d H:i:s')
							);
		$this->db->insert("emp_hired_notification",$data);

		$this->db->select_max('emp_hired_notif_id');
		$this->db->from('emp_hired_notification');
		$this->db->where('account_management_policy_id',$account_management_policy_id);
		$this->db->where('company_id',$company);
		$querymain = $this->db->get();
		$emp_hired_notif_id= $querymain->row('emp_hired_notif_id');

		$data1= array('emp_hired_notif_id'	=>		$emp_hired_notif_id,
							'company'			=>		$company_view,
							'division'			=>		$division1,
							'department'		=>		$department1,
							'section'			=>		$section1,
							'subsection'		=>		$subsection1,
							'classification'	=>		$classification1,
							'employment'		=>		$employment1,
							'location'			=>		$location1,
							'status'			=>		$status
							);
		$this->db->insert("emp_hired_notif_designation",$data1);
		}

		public function company_setupdisable($company_id)
		{
			$this->db->select("*");
			$this->db->from("account_management_disable_account");
			if($company_id=='non')
			{}
			else { $this->db->where('company_id',$company_id); }
			$query = $this->db->get();
			return $query->result();

		}

		public function save_mob_tel_data($company_id,$converted1,$loop,$number_fields,$option)
		{ 
			$no_of_loop = $loop;
			$array =  explode('mimi', $converted1);
			$counter = 0;
			$start = 0;
			$n = $number_fields - 1;
			for ($x = 2; $x <= $no_of_loop; $x++) {
				
				${"tosaveval$counter"} = array_slice($array,$start,3);

				  	$loc = ${"tosaveval$counter"}[0];
				  	$tel = ${"tosaveval$counter"}[1];
				  	$mob = ${"tosaveval$counter"}[2];
					
					if($option=='insert')
					{
							$data= array('company_id' => $company_id,'location_id' => $loc);
							$data1 = array('company_id' => $company_id,'location_id' => $loc,'telephone_format' => $tel,'mobile_format' => $mob ,'date_created' => date('Y-m-d'));
							$this->db->where($data);
							$query = $this->db->get('emp_mobile_tel_format');
							$nm =  $query->num_rows();
							if($nm == 0) {
							$this->db->insert("emp_mobile_tel_format",$data1);
							
					} else{}
					}

					else{ 
						$dat = array('location_id'=>$loc,'company_id' =>$company_id);
						$da = array('telephone_format' => $tel,'mobile_format' => $mob);
						$this->db->where($dat);
						$this->db->update("emp_mobile_tel_format",$da);
						
					}
					
				$start = $start + 3;
			}
			
		}

		public function check_if_mob_tel_exist($company_id)
		{
			$this->db->select('a.*,b.*');
			$this->db->join('location b','b.location_id=a.location_id');
			$this->db->where('a.company_id',$company_id);
			$query = $this->db->get('emp_mobile_tel_format a');
			return $query->result();
		}

		public function password_encryption_checker($setting)
		{
			

			if(!empty($setting))
			{
				if($setting=='yes')
				{

						$this->db->where(array('encrypt_password'=>0));
						$emp = $this->db->get('employee_info');
						$emp_res = $emp->result();
						if(!empty($emp_res))
						{

							foreach($emp_res as $e)
							{
								$pass= $this->encrypt->encode($e->password);
								$this->db->where('employee_id',$e->employee_id);
								$this->db->update('employee_info',array('password'=>$pass,'encrypt_password'=>1));
							}
						}
						
				}
				else
				{
						$this->db->where(array('encrypt_password'=>1));
						$emp = $this->db->get('employee_info');
						$emp_res = $emp->result();
						if(!empty($emp_res))
						{
							foreach($emp_res as $e)
							{
								$pass= $this->encrypt->decode($e->password);
								$this->db->where('employee_id',$e->employee_id);
								$this->db->update('employee_info',array('password'=>$pass,'encrypt_password'=>0));
							}
						}
				}
				
			}
			else
			{}
			
		}


		//employee password encryption

		public function encryption_setting()
		{
			$this->db->join('account_management_others_setup b','a.account_management_policy_id=a.account_management_policy_id');
			$this->db->join('account_management_others_data c','c.account_management_others_setup_id=b.account_management_others_setup_id');
			$query = $this->db->get('account_management_policy_settings a');
			$setting = $query->row('datas');
			return $setting;
		}

}
