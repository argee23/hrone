<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Notification_user_define_fields_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}




//GET COMPANY=============================================================	

	public function get_company_name($company){
		$this->db->select('company_name');
		$this->db->where('company_id',$company);
		$query = $this->db->get("company_info");
		return $query->result();
	}
	public function get_company($company_id){
		$this->db->where(array(
			'company_id'	=>		$company_id,
			'InActive'		=>		0
		));	
		$query = $this->db->get("company_info");
		return $query->row();
	}



	public function get_udn_by_company($company_id){
		$this->db->where(array(
							'company_id'   => $company_id,
							'IsUserDefine' => 1
			));
		$query = $this->db->get('notification_file_maintenance');
		return $query->result();
	}

	public function udnList(){ 
		$this->db->where(array(
			'IsUserDefine'	=>	1	
		));
		$this->db->order_by('form_name','asc');
		$query = $this->db->get("notification_file_maintenance");
		return $query->result();
	}

	public function check_udn_exist($value,$company_id){
		
		$this->db->where('transaction_for_purpose', $value);
		$this->db->where('company_id', $company_id);
		$query = $this->db->get('notification_udf');

        $count = $query->num_rows();
        
        if ($count === 0) {
         	return true;
        }
        else{
        	return false;
        }

	}

	public function create_udn123_new($company_id){

        $this->form_validation->set_rules('fname', 'transaction_for_purpose', 'trim');
		$fname=$this->input->post('fname');
   
		  $data = array(
  				'transaction_for_purpose' => $fname,
  				'identifier' => $fname.'_iden',
  				'company_id' => $company_id
     	);
		
		return $this->db->insert('notification_udf',$data);
		return $query->result();
	}


	public function save_new_table($company_id){
		/*=========== for time settings =========== */
  $CI = &get_instance();
  $CI->load->database();
  $db_hostname=$CI->db->hostname;
  $db_username=$CI->db->username;
  $db_password=$CI->db->password;
  $db_databasename=$CI->db->database;

  $db = new mysqli($db_hostname,$db_username, $db_password, $db_databasename);
        if ($db->connect_errno) die ($db->connect_error);

  //para makuha database schema details

	 	$table=$db->prepare("SHOW TABLE STATUS FROM ".$db_databasename."");
        $table->execute();
        $db_tables = $table->get_result();
            while ($location_table=$db_tables->fetch_assoc()){ // get schema of `location` table
                if ($location_table["Name"]== "company_info"){
                    $ai[$location_table["Name"]]=$location_table["Auto_increment"];
                    //ai: auto increment value
                }
            }
        $auto_increment=$this->db->insert_id();

        	$label =  $this->input->post('label');
            $type = $this->input->post('type');
            $accept_value = $this->input->post('accept_value');
            $max_length = $this->input->post('max_length');
 			$not_null = $this->input->post('not_null');

 			
/*=========== for time settings =========== */
$temp=count($this->input->post('type'));

 for($i=0; $i<$temp; $i++){

 			

 			if($type[$i] == 'Selectbox'){
				$a_value[$i] = $accept_value[$i];	
		    	$m_length[$i] = $max_length[$i];
			}else if($type[$i] == 'Textfield'){
				$a_value[$i] = $accept_value[$i];	
		    	$m_length[$i] = $max_length[$i];
	    	}else if($type[$i] == 'Textarea'){
				$a_value[$i] = $accept_value[$i];	
		    	$m_length[$i] = $max_length[$i];
		    }else{
				$a_value[$i] = 'datetime';
				$m_length[$i] = 0;
	    	
		    }

		      if(($type[$i] == 'Selectbox' && $accept_value[$i] =='varchar')){
                	$m_length[$i] = 255;
                }else if(($type[$i] == 'Selectbox' && $accept_value[$i] =='text')){
                	$m_length[$i] = 0;
                }else if(($type[$i] == 'Selectbox' && $accept_value[$i] =='int')){
                	$m_length[$i] = 99;
                }

              if(($type[$i] == 'Textarea' && $accept_value[$i] =='text')){
                	$m_length[$i] = 0;
                }

              if(($type[$i] == 'Textfield' && $accept_value[$i] =='text')){
                	$m_length[$i] = 0;
                }

 	
  		$sample_final[$i] = str_replace(" ","_",$label[$i]);
 		$final[$i] = strtolower($sample_final[$i]);

  	$this->dbforge->add_field(array(
	    'udf_id' => array(   
                'type' => 'INT',
                'constraint' => 99,
                'unsigned' => TRUE,
                'unique' => TRUE,
                'auto_increment' => TRUE
        ),

        'employee_id' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'not_null' => TRUE,
        ),
  		'company_id' => array(   
                'type' => 'INT',
                'constraint' => 99,
                'not_null' => TRUE,
        ),

        'doc_no' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'not_null' => TRUE,
        ),

         'status' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'not_null' => TRUE,
        ),
          'InActive' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'not_null' => TRUE,
        ),
         'IsDeleted' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'not_null' => TRUE,
        ),

  		'entry_type' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'not_null' => TRUE,
        ),
  		'file_attached' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'not_null' => TRUE,
        ),
        'date_created' => array(   
                'type' => 'date',
                'constraint' => 0,
                'not_null' => TRUE,
        ),
        'status_update_date' => array(   
                'type' => 'datetime',
                'constraint' => 0,
                'not_null' => TRUE,
        ),
        'remarks' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'not_null' => TRUE,
        ),
         'code_of_discipline' => array(   
                'type' => 'INT',
                'constraint' => 99,
                'not_null' => TRUE,
        ),
        'disobedience_section' => array(   
                'type' => 'INT',
                'constraint' =>99,
                'not_null' => TRUE,
        ),
        'disobedience_no' => array(   
                'type' => 'INT',
                'constraint' => 99,
                'not_null' => TRUE,
        ),
         'time_viewed' => array(   
                'type' => 'datetime',
                'constraint' =>0,
                'not_null' => TRUE,
        ),
        'time_acknowledge' => array(   
                'type' => 'datetime',
                'constraint' => 0,
                'not_null' => TRUE,
        ),
		$final[$i] => array(     //etong label parang yung udf_id
                'type' => $a_value[$i],
                'constraint' => $m_length[$i],
                 'not_null' => TRUE             
        ),

      

	    ));

  		
	}
		$this->dbforge->add_key('udf_id', TRUE);
  		$this->dbforge->create_table('udf_notif_'.$auto_increment, TRUE); 

  					$label =  $this->input->post('label');
            $type = $this->input->post('type');
            $accept_value = $this->input->post('accept_value');
            $max_length = $this->input->post('max_length');
 			$not_null = $this->input->post('not_null');

 			
/*=========== for time settings =========== */
$temp=count($this->input->post('type'));
 for($i=0; $i<$temp; $i++){


 			if($type[$i] == 'Selectbox'){
				$a_value[$i] = $accept_value[$i];	
		    	$m_length[$i] = $max_length[$i];
			}else if($type[$i] == 'Textfield'){
				$a_value[$i] = $accept_value[$i];	
		    	$m_length[$i] = $max_length[$i];
	    	}else if($type[$i] == 'Textarea'){
				$a_value[$i] = $accept_value[$i];	
		    	$m_length[$i] = $max_length[$i];
		    }else{
				$a_value[$i] = 'datetime';
				$m_length[$i] = 0;
	    	
		    }

		     if(($type[$i] == 'Selectbox' && $accept_value[$i] =='varchar')){
                	$m_length[$i] = 255;
                }else if(($type[$i] == 'Selectbox' && $accept_value[$i] =='text')){
                	$m_length[$i] = 0;
                }else if(($type[$i] == 'Selectbox' && $accept_value[$i] =='int')){
                	$m_length[$i] = 99;
                }

              if(($type[$i] == 'Textarea' && $accept_value[$i] =='text')){
                	$m_length[$i] = 0;
                }

              if(($type[$i] == 'Textfield' && $accept_value[$i] =='text')){
                	$m_length[$i] = 0;
                }
 	
  		$sample_final[$i] = str_replace(" ","_",$label[$i]);
 		$final[$i] = strtolower($sample_final[$i]);
	$this->dbforge->add_field(array(
	    'id' => array(   
                'type' => 'INT',
                'constraint' => 99,
                'unsigned' => TRUE,
                'unique' => TRUE,
                'auto_increment' => TRUE
        ),

        'doc_no' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'not_null' => TRUE,
        ),
  		'approver_id' => array(   
                'type' => 'INT',
                'constraint' => 99,
                'not_null' => TRUE,
        ),

        'status' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'not_null' => TRUE,
        ),

         'comment' => array(   
                'type' => 'TEXT',
                'constraint' => 0,
                'not_null' => TRUE,
        ),
          'approval_level' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'not_null' => TRUE,
        ),
         'date_time' => array(   
                'type' => 'datetime',
                'constraint' => 0,
                'not_null' => TRUE,
        ),

  		'responder_id' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'not_null' => TRUE,
        ),
  		'approval_type' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'not_null' => TRUE,
        ),

		'submitted_on' => array(   
                'type' => 'datetime',
                'constraint' => 0,
                 'not_null' => TRUE,
        ),
		'status_view' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'not_null' => TRUE,
        ),
        'original_approver' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                 'not_null' => TRUE,
        ),
        'date_transferred' => array(   
                'type' => 'datetime',
                'constraint' => 0,
                 'not_null' => TRUE,
        ),
        $final[$i] => array(     //etong label parang yung udf_id
                'type' => $a_value[$i],
                'constraint' => $m_length[$i], 
                 'not_null' => TRUE             
        ),


	    ));
		
		}

		$this->dbforge->add_key('id', TRUE);
  		$this->dbforge->create_table('udf_notif_'.$auto_increment.'_approval', TRUE);

  				$label =  $this->input->post('label');
/*=========== for time settings =========== */
	$temp=count($this->input->post('type'));
	 for($i=0; $i<$temp; $i++){

  		$sample_final[$i] = str_replace(" ","_",$label[$i]);
 		$final[$i] = strtolower($sample_final[$i]);
	$this->dbforge->add_field(array(
	    'id' => array(   
                'type' => 'INT',
                'constraint' => 99,
                'unsigned' => TRUE,
                'unique' => TRUE,
                'auto_increment' => TRUE,
        ),

        'doc_no' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'not_null' => TRUE,
        ),
  		'notif_id' => array(   
                'type' => 'INT',
                'constraint' => 99,
                 'not_null' => TRUE,
        ),

        'date_created' => array(   
                'type' => 'datetime',
                'constraint' => 0,
                'not_null' => TRUE,
        ),

        $final[$i] => array(     //etong label parang yung udf_id
                'type' => 'varchar',
                'constraint' => 255, 
                'not_null' => TRUE,             
        ),


	    ));

		}
		$this->dbforge->add_key('id', TRUE);
  		$this->dbforge->create_table('udf_notif_'.$auto_increment.'_assign', TRUE);

		$fname=$this->input->post('fname');
        $fdesc = $this->input->post('fdesc');
        $iden = $this->input->post('iden');
        $may_approvers = $this->input->post('issuance_type');


		  $data = array(
  				'IsUserDefine' 		=> 1,
				'company_id' 		=> $company_id,
				'form_name'			=> $fname,
 				'form_desc' 		=> $fdesc,
 				'issuance_type' 		=> $may_approvers,
				'form_type'			=>		'N',
				'identification'	=>		'UDN'.$auto_increment,
				't_table_name'		=>		'udf_notif_'.$auto_increment,
				'template_name' => $fname.'_template',
				'tudf_identifier' => $fname.'_iden',
				'IsActive' => 1
 

     	);
		
		return $this->db->insert('notification_file_maintenance',$data);
		



	}
	
	public function create_udn_new($company_id){
	
		$this->form_validation->set_rules('label[]', 'Label', 'trim');
        $this->form_validation->set_rules('type[]', 'DESCRIPTIONS', 'trim'); 
        $this->form_validation->set_rules('not_null[]', 'DESCRIPTIONS', 'trim'); 
      


			$fname=$this->input->post('fname');
 			$label =  $this->input->post('label');
            $type = $this->input->post('type');
            $accept_value = $this->input->post('accept_value');
            $max_length = $this->input->post('max_length');
 			$not_null = $this->input->post('not_null');
 		
			$id=$this->db->insert_id();
    

			$temp=count($this->input->post('type'));

			for($i=0; $i<$temp;$i++){

					if($type[$i] == 'Datepicker'){
						 $fa_value[$i] = 'datetime';
					}else{

                    if($accept_value[$i] == 'varchar'){
                        $fa_value[$i] = "Alphanumeric";
                    }else if($accept_value[$i] == 'text'){
                        $fa_value[$i] = "Letters";
                    }else if($accept_value[$i] == 'int'){
                        $fa_value[$i] = "Numbers";
                    }
                }

                if(($type[$i] == 'Textarea' && $accept_value[$i] =='text')){
                	$max_length[$i] = 0;
                }

             	if(($type[$i] == 'Textfield' && $accept_value[$i] =='text')){
                	$max_length[$i] = 0;
                }
                
			   	

			       $sample_final[$i] = str_replace(" ","_",$label[$i]);
			 		$final[$i] = strtolower($sample_final[$i]);
			  		 $data = array(
			        	    'udf_label' => $label[$i],
							'udf_type' => $type[$i],
							'udf_accept_value' => $fa_value[$i],
							'udf_max_length' => $max_length[$i],
							'udf_not_null' => $not_null[$i],
							'company_id' => $company_id,
							'form_name'=>$fname,
							'TextFieldName' => $final[$i],
							'isDisabled' => 0,
							'id' =>  $id
						
			            );
    			
			   
			           $this->db->insert('notification_udf_column',$data);
			    
			 } 

	}

	public function colName_udn($id){
		$this->db->where('id', $id);
		$query = $this->db->get('notification_file_maintenance');
		return $query->result();
	}

	public function get_udn($nf_id){
		$this->db->select('*');	
		$this->db->where('id', $nf_id);
		$query = $this->db->get('notification_file_maintenance');
		return $query->result();
	}

	public function del_notif_udf_new($tudf_identifier){

	

			$this->db->where('identifier', $tudf_identifier);
		$this->db->delete('notification_udf');
		
	}

	public function del_udn_new($id){

	
			$this->db->where('id', $id);
		$this->db->delete('notification_file_maintenance');
		
	}

	public function del_notif_new($id){

	
			$this->db->where('id', $id);
		$this->db->delete('notification_udf_column');
		
	}

	public function del_table($t_table_name){

	
	$this->dbforge->drop_table($t_table_name,TRUE);
	$this->dbforge->drop_table($t_table_name.'_approval',TRUE);
	$this->dbforge->drop_table($t_table_name.'_assign',TRUE);
		
	}

	public function get_udn_col1($id){ 
		$query = $this -> db
		->where('id', $id)             
		->get('notification_file_maintenance');           
		return $query->row();
	}

	public function companyName1(){
		$data = $this->uri->segment("4");

			$this->db->select("a.company_name, a.company_id");
		$this->db->join("notification_file_maintenance b", "b.company_id = a.company_id", "inner");
		$this->db->where("b.id", $data);
		$query = $this->db->get("company_info a");
		return $query->row();
	}

	public function check_udn1_exist($value,$company_id,$fdesc){
		
		$this->db->where('form_name', $value);
		$this->db->where('form_desc', $fdesc);
		$this->db->where('company_id', $company_id);
		$query = $this->db->get('notification_file_maintenance');

        $count = $query->num_rows();
        
        if ($count === 0) {
         	return true;
        }
        else{
        	return false;
        }

	}

	public function modify_udn1_new($id){
		
		
		
			$this->data = array(
					'form_name' => $this->input->post('fname'),
					'form_desc' => $this->input->post('fdesc')
					//'company_id' => $this->input->post('company')
					//'identification' => $this->input->post('ident')      //JULY 9 edit	
			);	
			//echo form_textarea($data);
			$this->db->where('id',$id);
			$this->db->update('notification_file_maintenance',$this->data);
		
	
	}

	public function modify_udn_emp_new($id){
		
		
		
			$this->data = array(
					'form_name' => $this->input->post('fname'),
					
			);	
			//echo form_textarea($data);
			$this->db->where('id',$id);
			$this->db->update('notification_udf_column',$this->data);
		
	
	}

	public function modify_notif_udf_new($value,$company_id,$tudf_identifier){
			$this->db->where('company_id',$company_id);
			$this->db->where('identifier',$tudf_identifier);
			$this->data = array(
					'transaction_for_purpose' => $this->input->post('fname'),
					
			);	
			$this->db->update('notification_udf',$this->data);
		
	
	}

	public function get_udn_col_All($id){ 
		$query = $this -> db
		->where('id', $id)     
		->get('notification_udf_column');
		return $query->result();
	}

		public function getOptlabel3_notif($id){               
		$this->db->where('id', $id);
		$query = $this->db->get('notification_udf_column');
		return $query->result();
	}

	public function getttablename_notif($id){                
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('notification_file_maintenance');
		return $query->result();
	}

	public function companyName3(){
		$data = $this->uri->segment("4");

		$this->db->select("form_name, id");
		
		$this->db->where("id", $data);
		$query = $this->db->get("notification_file_maintenance");
		return $query->row();
	}

	public function get_udf_col_none($id){ 
		$query = $this -> db
		->where('id', $id)      // to connect the id to the table of transaction_file_maintenance
		->get('notification_file_maintenance');
		return $query->result();
	}

	public function udfList(){ 
		$this->db->where(array(
			'IsUserDefine'	=>	1	
		));
		$this->db->order_by('form_name','asc');
		$query = $this->db->get("transaction_file_maintenance");
		return $query->result();
	}

	public function check_udn_label1($form){
		$value = $this->input->post('label');
		echo 'form '.$form.' ';
		$this->db->where('id', $form);
		$this->db->where('udf_label', $value);
		$query = $this->db->get('notification_udf_column');

        $count = $query->num_rows();
        echo $count;
        if ($count === 0) {
         	return true;
        }
        else{
        	return false;
        }

	}

	public function create_udf5_new($form){

			$id = $this->uri->segment("4");
			$t_table_name = $this->input->post('t_table_name');
			$company_id = $this->input->post('company_id');
			$fname = $this->input->post('fname');
			$label = $this->input->post('label');
			$sample_final = str_replace(" ","_",$label);
 			$final = strtolower($sample_final);
			$type = $this->input->post('type');
			$accept_value = $this->input->post('accept_value');
			$max_length = $this->input->post('max_length');
			$not_null = $this->input->post('not_null');
		

			if($type == 'Selectbox'){
				$a_value = $accept_value;	
		    	$m_length = $max_length;
			}else if($type == 'Textfield'){
				$a_value = $accept_value;	
		    	$m_length = $max_length;
	    	}else if($type == 'Textarea'){
				$a_value = $accept_value;	
		    	$m_length = $max_length;
		    }else{
				$a_value = 'datetime';
				$m_length = 0;
	    	
		    }

		      if(($type == 'Selectbox' && $accept_value =='varchar')){
                	$m_length = 255;
                }else if(($type == 'Selectbox' && $accept_value =='text')){
                	$m_length = 0;
                }else if(($type == 'Selectbox' && $accept_value =='int')){
                	$m_length = 99;
                }

              if(($type == 'Textarea' && $accept_value =='text')){
                	$m_length = 0;
                }

              if(($type == 'Textfield' && $accept_value =='text')){
                	$m_length = 0;
                }


				$fields = array(
	        		$final => array(
	        					'type' 		 => $a_value,
	                			'constraint' => $m_length,
	                			'not_null'   => TRUE,       
	        			)
				);
		$this->dbforge->add_column($t_table_name, $fields);


			if($type == 'Selectbox'){
				$a_value = $accept_value;	
		    	$m_length = $max_length;
			}else if($type == 'Textfield'){
				$a_value = $accept_value;	
		    	$m_length = $max_length;
	    	}else if($type == 'Textarea'){
				$a_value = $accept_value;	
		    	$m_length = $max_length;
		    }else{
				$a_value = 'datetime';
				$m_length = 0;
	    	
		    }

		      if(($type == 'Selectbox' && $accept_value =='varchar')){
                	$m_length = 255;
                }else if(($type == 'Selectbox' && $accept_value =='text')){
                	$m_length = 0;
                }else if(($type == 'Selectbox' && $accept_value =='int')){
                	$m_length = 99;
                }

              if(($type == 'Textarea' && $accept_value =='text')){
                	$m_length = 0;
                }

              if(($type == 'Textfield' && $accept_value =='text')){
                	$m_length = 0;
                }


				$fields = array(
	        		$final => array(
	        					'type' 		 => $a_value,
	                			'constraint' => $m_length,
	                			'not_null'   => TRUE           
	        			)
				);
		$this->dbforge->add_column($t_table_name.'_approval', $fields);

			

				$fields = array(
	        		$final => array(
	        					'type' 		 => 'varchar',
	                			'constraint' => 255,
	                			'not_null'   => TRUE           
	        			)
				);
		$this->dbforge->add_column($t_table_name.'_assign', $fields);
			
	
	}

	public function create_udf5_col_new($form){
			$id = $this->uri->segment("4");
			$t_table_name = $this->input->post('t_table_name');
			$company_id = $this->input->post('company_id');
			$fname = $this->input->post('fname');
			$label = $this->input->post('label');
			$sample_final = str_replace(" ","_",$label);
 			$final = strtolower($sample_final);
			$type = $this->input->post('type');
			$accept_value = $this->input->post('accept_value');
			$max_length = $this->input->post('max_length');
			$not_null = $this->input->post('not_null');

				if($type == 'Datepicker'){
						 $a_value = 'datetime';
				}else{

                    if($accept_value == 'varchar'){
                        $a_value = "Alphanumeric";
                    }else if($accept_value == 'text'){
                        $a_value = "Letters";
                    }else if($accept_value == 'int'){
                        $a_value = "Numbers";
                    }
                }

                if(($type == 'Textarea' && $accept_value =='text')){
                	$max_length = 0;
                }

             	if(($type == 'Textfield' && $accept_value =='text')){
                	$max_length = 0;
                }

 			 $data = array(
  				
				
				'udf_label' => $label,
				'udf_type' => $type,
				'udf_accept_value' => $a_value,
				'udf_max_length' => $max_length,
				'udf_not_null' => $not_null,
				'company_id' => $company_id,
				'form_name'=>$fname,
				'TextFieldName' => $final,
				'isDisabled' => 0,
				'id' =>  $id

     		);

		 $this->db->insert('notification_udf_column',$data);

	
	}	

	public function colName_udf_store($id){
		$this->db->where('id', $id);
		$query = $this->db->get('notification_file_maintenance');
		return $query->result();
	}

	public function get_old_name($id){
		$this->db->select('*');	
		$this->db->where('tran_udf_col_id', $id);
		$query = $this->db->get('notification_udf_column');
		return $query->result();
	}

	public function get_udf($tf_id){
		$this->db->select('*');	
		$this->db->where('id', $tf_id);
		$query = $this->db->get('notification_file_maintenance');
		return $query->result();
	}

	public function del_field_table($f_name,$t_table_name){
		$sample_final = str_replace(" ","_",$f_name);
 	    $final = strtolower($sample_final);
		$this->dbforge->drop_column($t_table_name, $final);

		$sample_final = str_replace(" ","_",$f_name);
 	    $final = strtolower($sample_final);
		$this->dbforge->drop_column($t_table_name.'_approval', $final);

		$sample_final = str_replace(" ","_",$f_name);
 	    $final = strtolower($sample_final);
		$this->dbforge->drop_column($t_table_name.'_assign', $final);
	}
	public function del_udf_option1_new($id){
		$this->db->where('tran_udf_col_id', $id);
		$this->db->delete('notification_udf_column');
		return true;
	}

	public function get_udf_col5($id){ 
		$query = $this -> db
		->where('tran_udf_col_id', $id)            
		->get('notification_udf_column');           
		return $query->row();
	}

	public function check_udf_exist_tudfcol($value,$type,$accept_value,$max_length,$not_null,$company_id){
		
		$this->db->where('udf_label', $value);
		$this->db->where('udf_type', $type);
		$this->db->where('udf_accept_value', $accept_value);
		$this->db->where('udf_max_length', $max_length);
		$this->db->where('udf_not_null', $not_null);
		$this->db->where('company_id', $company_id);
		$query = $this->db->get('notification_udf_column');

        $count = $query->num_rows();
        
        if ($count === 0) {
         	return true;
        }
        else{
        	return false;
        }

	}

public function check_udf_exist_tudfcol_dp($value,$type,$accept_value,$company_id){
		
		$this->db->where('udf_label', $value);
		$this->db->where('udf_type', $type);
		$this->db->where('udf_accept_value', $accept_value);
		$this->db->where('company_id', $company_id);
		$query = $this->db->get('notification_udf_column');

        $count = $query->num_rows();
        
        if ($count === 0) {
         	return true;
        }
        else{
        	return false;
        }

	}

	public function check_udf_exist_tudfcol_opt(){
		$value = $this->input->post('optlabel');
		$this->db->where('optionLabel', $value);
		$query = $this->db->get('notification_udf_option');

        $count = $query->num_rows();
        
        if ($count === 0) {
         	return true;
        }
        else{
        	return false;
        }

	}

	public function modify_udf_new($id){
		$type = $this->input->post('type');
		$accept_value = $this->input->post('accept_value');
		$label = $this->input->post('label');
		$max_length = $this->input->post('max_length');
		$sample_final = str_replace(" ","_",$label);
 	    $final = strtolower($sample_final);
		if($accept_value == 'varchar'){
            	$a_value = "Alphanumeric";
            }else if($accept_value == 'text'){
            	$a_value = "Letters";
            }else if($accept_value == 'int'){
            	$a_value = "Numbers";
            }

               if(($type == 'Textarea' && $accept_value =='text')){
                	$max_length = 0;
                }

             	if(($type == 'Textfield' && $accept_value =='text')){
                	$max_length = 0;
                }

		if($type === 'Null'){
			$this->data = array(
					'udf_label' => $this->input->post('label'),
					'udf_not_null' => $this->input->post('not_null'),
					'TextFieldName' => $final,
					//'company_id' => $this->input->post('company'),
					'isDisabled' => 0
			);	
			$this->db->where('tran_udf_col_id',$id);
			$this->db->update('notification_udf_column',$this->data);
		}else if($type === 'Datepicker'){
			$this->data = array(
					'udf_label' => $this->input->post('label'),
					'udf_type' => $this->input->post('type'),
					'udf_accept_value' => 'datetime',
					'udf_max_length' => 0,
					'TextFieldName' => $final,
					'udf_not_null' => $this->input->post('not_null'),
					//'company_id' => $this->input->post('company'),
					'isDisabled' => 0
			);	
			$this->db->where('tran_udf_col_id',$id);
			$this->db->update('notification_udf_column',$this->data);
		}else{
			$accept_value = $this->input->post('accept_value');
		
			if($accept_value == 'varchar'){
            	$a_value = "Alphanumeric";
            }else if($accept_value == 'text'){
            	$a_value = "Letters";
            }else if($accept_value == 'int'){
            	$a_value = "Numbers";
            }

               if(($type == 'Textarea' && $accept_value =='text')){
                	$max_length = 0;
                }

             	if(($type == 'Textfield' && $accept_value =='text')){
                	$max_length = 0;
                }
			$this->data = array(
					'udf_label' => $this->input->post('label'),
					'udf_type' => $this->input->post('type'),
					'udf_accept_value' => $a_value,
					'udf_max_length' => $max_length,
					'udf_not_null' => $this->input->post('not_null'),
					'TextFieldName' => $final,
					//'company_id' => $this->input->post('company'),
					'isDisabled' => 0
			);	
			$this->db->where('tran_udf_col_id',$id);
			$this->db->update('notification_udf_column',$this->data);
		}

	}

	public function modify_table_field_new($id,$t_table_name,$old_name,$old_av,$old_length,$old_type){
			$label =  $this->input->post('label');
			$sample_final = str_replace(" ","_",$label);
 	    	$final = strtolower($sample_final);
			$type =  $this->input->post('type');
			$accept_value =  $this->input->post('accept_value');
			$max_length =  $this->input->post('max_length');

			if(($type == 'Textarea' && $accept_value =='text')){
                	$max_length = 0;
                }

            if(($type == 'Textfield' && $accept_value =='text')){
                	$max_length = 0;
                }
            if(($type == 'Selectbox' && $accept_value =='varchar')){
                	$max_length = 255;
            }else if(($type == 'Selectbox' && $accept_value =='text')){
                	$max_length = 0;
            }else if(($type == 'Selectbox' && $accept_value =='int')){
                	$max_length = 99;
                }

            if($old_av == 'Alphanumeric'){
            	$old_fav = 'varchar';
            }else if($old_av == 'Numbers'){
            	$old_fav = 'int';
            }else if($old_av == 'Letters'){
            	$old_fav = 'text';
            }else{
            	$old_fav = 'datetime';
            }

            if(($old_type == 'Selectbox' || $old_length == 'Alphanumeric')){
            	$old_flength = 255;
            }else if(($old_type == 'Selectbox' || $old_length == 'Letters')){
            	$old_flength = 0;
            }else if(($old_type == 'Selectbox' || $old_length == 'Numbers')){
            	$old_flength = 99;
            }else{
            	$old_flength = $old_length;
            }

            if($type == 'Null'){
			$fields = array(
        			$old_name => array(
                		'name' => $final,
                		'type' => $old_fav,
                		'constraint' => $old_flength,
                		'null' => FALSE,
       		 ),
			);
			}else if($type == 'Textfield'){
			$fields = array(
        			$old_name => array(
                		'name' => $final,
               		    'type' => $accept_value,
       					'constraint' => $max_length,
       					 'null' => FALSE,
       		 ),
			);
		}else if($type == 'Datepicker'){
			$fields = array(
        			$old_name => array(
                		'name' => $final,
               		    'type' => 'datetime',
       					'constraint' => 0,
       					 'null' => FALSE,
       		 ),
			);

		}else if($type == 'Textarea'){
			$fields = array(
        			$old_name => array(
                		'name' => $final,
               		    'type' => $accept_value,
       					'constraint' => $max_length,
       					 'null' => FALSE,
       		 ),
			);

		}else{
			$fields = array(
        			$old_name => array(
                		'name' => $final,
               		    'type' => $accept_value,
       					'constraint' => $max_length,
       					 'null' => FALSE,
       		 ),
			);

		}
		$this->dbforge->modify_column($t_table_name, $fields);

			$label =  $this->input->post('label');
			$sample_final = str_replace(" ","_",$label);
 	    	$final = strtolower($sample_final);
			$type =  $this->input->post('type');
			$accept_value =  $this->input->post('accept_value');
			$max_length =  $this->input->post('max_length');

			if($old_type == '')

			if(($type == 'Textarea' && $accept_value =='text')){
                	$max_length = 0;
                }

            if(($type == 'Textfield' && $accept_value =='text')){
                	$max_length = 0;
                }
            if(($type == 'Selectbox' && $accept_value =='varchar')){
                	$max_length = 255;
                }else if(($type == 'Selectbox' && $accept_value =='text')){
                	$max_length = 0;
                }else if(($type == 'Selectbox' && $accept_value =='int')){
                	$max_length = 99;
                }


             if($old_av == 'Alphanumeric'){
            	$old_fav = 'varchar';
            }else if($old_av == 'Numbers'){
            	$old_fav = 'int';
            }else if($old_av == 'Letters'){
            	$old_fav = 'text';
            }else{
            	$old_fav = 'datetime';
            }

            if(($old_type == 'Selectbox' || $old_length == 'Alphanumeric')){
            	$old_flength = 255;
            }else if(($old_type == 'Selectbox' || $old_length == 'Letters')){
            	$old_flength = 0;
            }else if(($old_type == 'Selectbox' || $old_length == 'Numbers')){
            	$old_flength = 99;
            }

            if($type == 'Null'){
			$fields = array(
        			$old_name => array(
                		'name' => $final,
                		'type' => $old_fav,
                		'constraint' => $old_flength,
                		'null' => FALSE,
       		 ),
			);
			}else if($type == 'Textfield'){
			$fields = array(
        			$old_name => array(
                		'name' => $final,
               		    'type' => $accept_value,
       					'constraint' => $max_length,
       					 'null' => FALSE,
       		 ),
			);
		}else if($type == 'Datepicker'){
			$fields = array(
        			$old_name => array(
                		'name' => $final,
               		    'type' => 'datetime',
       					'constraint' => 0,
       					 'null' => FALSE,
       		 ),
			);

		}else if($type == 'Textarea'){
			$fields = array(
        			$old_name => array(
                		'name' => $final,
               		    'type' => $accept_value,
       					'constraint' => $max_length,
       					 'null' => FALSE,
       		 ),
			);

		}else{
			$fields = array(
        			$old_name => array(
                		'name' => $final,
               		    'type' => $accept_value,
       					'constraint' => $max_length,
       					 'null' => FALSE,
       		 ),
			);

		}
		$this->dbforge->modify_column($t_table_name.'_approval', $fields);


			$label =  $this->input->post('label');
			$sample_final = str_replace(" ","_",$label);
 	    	$final = strtolower($sample_final);
			$type =  $this->input->post('type');
			$accept_value =  $this->input->post('accept_value');
			$max_length =  $this->input->post('max_length');

			if(($type == 'Textarea' && $accept_value =='text')){
                	$max_length = 0;
                }

            if(($type == 'Textfield' && $accept_value =='text')){
                	$max_length = 0;
                }
            if(($type == 'Selectbox' && $accept_value =='varchar')){
                	$max_length = 255;
                }else if(($type == 'Selectbox' && $accept_value =='text')){
                	$max_length = 0;
                }else if(($type == 'Selectbox' && $accept_value =='int')){
                	$max_length = 99;
                }

		 if($type == 'Null'){
			$fields = array(
        			$old_name => array(
                		'name' => $final,
                		'type' => 'varchar',
                		'constraint' => 255,
                		'null' => FALSE,

       		 ),
			);
		}else if($type == 'Textfield'){
			$fields = array(
        			$old_name => array(
                		'name' => $final,
               		    'type' => 'varchar',
       					'constraint' => 255,
       					 'null' => FALSE,
       		 ),
			);
		}else if($type == 'Datepicker'){
			$fields = array(
        			$old_name => array(
                		'name' => $final,
               		    'type' => 'varchar',
       					'constraint' => 255,
       					 'null' => FALSE,
       		 ),
			);

		}else if($type == 'Textarea'){
			$fields = array(
        			$old_name => array(
                		'name' => $final,
               		    'type' => 'varchar',
       					'constraint' => 255,
       					 'null' => FALSE,
       		 ),
			);

		}else{
			$fields = array(
        			$old_name => array(
                		'name' => $final,
               		    'type' => 'varchar',
       					'constraint' => 255,
       					 'null' => FALSE,
       		 ),
			);

		}
		$this->dbforge->modify_column($t_table_name.'_assign', $fields);


	}

	public function get_udf_col_All3($id){ 
		$query = $this -> db
		->where('tran_udf_col_id', $id)      // to connect the id to the table of transaction_file_maintenance
		->get('notification_udf_column');
		return $query->result();
	}

	public function get_udf_col_All3_none($id){ 
		$query = $this -> db
		->where('tran_udf_col_id', $id)      // to connect the id to the table of transaction_file_maintenance
		->get('notification_udf_column');
		return $query->result();
	}

	public function getOptlabel($id){
		//$this->db->select('*');
		$this->db->where('udf_tran_col_id', $id);
		$query = $this->db->get('notification_udf_option');
		return $query->result();
	}

	public function colName_udf_store22($id){ //duplicate for the option slectbox july 3
		$this->db->where('tran_udf_col_id', $id);
		$query = $this->db->get('notification_udf_column');
		return $query->result();
	}

	public function create_udf_opt($value){
		$id = $this->uri->segment("4");
		//echo $value.'::';
		$data = array(
				'udf_tran_col_id' => $id,
				'optionLabel' => $value,
				'isDisabled' => 0,


		);
		return $this->db->insert('notification_udf_option',$data);			
	}

	public function del_udf_option($id){
		$this->db->where('tran_udf_opt_id', $id);
		$this->db->delete('notification_udf_option');
		return true;
	}

	public function get_udf_opt($id){ 
		//echo 'ID '.$id;
		$query = $this -> db
		->where('tran_udf_opt_id', $id)
		->get('notification_udf_option');
		return $query->row();
	}

	public function modify_udf_opt($id){
		$this->data = array(
				'optionLabel' => $this->input->post('optlabel'),
				'isDisabled' => 0
		);	
		$this->db->where('tran_udf_opt_id',$id);
		$this->db->update('notification_udf_option',$this->data);
	}

	//== FOR DISABLING AUTOMATIC=======================================================================
	public function get_lists($id){
		$this->db->where(array(
			'id'		=>	$id
		));		
		$query = $this->db->get("notification_file_maintenance");
		return $query->row();
	}
	public function deactivate_notif_list($id){
		$this->db->where('id',$id);
		$this->data = array('IsActive'=>0);
		$this->db->update("notification_file_maintenance",$this->data);	
	}
	public function activate_notif_list($id){
		$this->db->where('id',$id);
		$this->data = array('IsActive'=>1);
		$this->db->update("notification_file_maintenance",$this->data);	
	}

//END OF CODE BY NEMZ==================================================================


}
