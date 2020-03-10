<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Transaction_User_define_fields_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}


	public function transaction_user_define_fields(){
		$this->db->order_by('udf_label','asc');
		$this->db->select('udf_label');
		$query = $this->db->get('transaction_udf_column');
		return $query->result();
	}

	public function get_udf_col_All($id){ 
		$query = $this -> db
		->where('id', $id)      // to connect the id to the table of transaction_file_maintenance
		->get('transaction_udf_column');
		return $query->result();
	}

	public function get_udf_col_none($id){ 
		$query = $this -> db
		->where('id', $id)      // to connect the id to the table of transaction_file_maintenance
		->get('transaction_file_maintenance');
		return $query->result();
	}

	public function companyName3(){
		$data = $this->uri->segment("4");

			$this->db->select("form_name, id");
		
		$this->db->where("id", $data);
		$query = $this->db->get("transaction_file_maintenance");
		return $query->row();
	}


		public function get_udf_col_All22($id){ 
		$query = $this -> db
		->where('id', $id)      // to connect the id to the table of transaction_file_maintenance
		->get('transaction_file_maintenance');
		return $query->result();
	}


		public function get_udf_col_All3($id){ 
		$query = $this -> db
		->where('tran_udf_col_id', $id)      // to connect the id to the table of transaction_file_maintenance
		->get('transaction_udf_column');
		return $query->result();
	}

		public function get_udf_col_All1($id){ 
		$query = $this -> db
		->where('id', $id)      // to connect the id to the table of transaction_file_maintenance
		->get('transaction_file_maintenance');
		return $query->result();
	}

	public function get_udf_col($id){ 
		$query = $this -> db
		->where('id', $id)             //start here change the tran_udf_col_id to id JUNE 29 work
		->get('transaction_udf_column');           
		return $query->row();
	}

	public function get_udf_col5($id){ 
		$query = $this -> db
		->where('tran_udf_col_id', $id)             //start here change the tran_udf_col_id to id JUNE 29 work
		->get('transaction_udf_column');           
		return $query->row();
	}


		public function get_udf_col1($id){ 
		$query = $this -> db
		->where('id', $id)             //working nemz
		->get('transaction_file_maintenance');           
		return $query->row();
	}


	public function get_udf_col_com($id){ 
		$query = $this -> db
		->where('tran_udf_col_id', $id)
		->get('transaction_udf_column');
		return $query->row();
	}

	public function get_udf_opt($id){ 
		//echo 'ID '.$id;
		$query = $this -> db
		->where('tran_udf_opt_id', $id)
		->get('transaction_udf_option');
		return $query->row();
	}

	public function create_udf($company){
		
		   $this->form_validation->set_rules('label[]', 'Label', 'trim');
        $this->form_validation->set_rules('type[]', 'DESCRIPTIONS', 'trim'); 
        $this->form_validation->set_rules('not_null[]', 'DESCRIPTIONS', 'trim'); 
      


			$fname=$this->input->post('fname');
 			$label =  $this->input->post('label');
            $type = $this->input->post('type');
            $accept_value = $this->input->post('accept_value');
            $max_length = $this->input->post('max_length');
 			$not_null = $this->input->post('not_null');
 		//	 $iden = $this->input->post('iden');
			$id=$this->db->insert_id();
    


	
$temp=count($this->input->post('type'));// count total description

for($i=0; $i<$temp;$i++){
   $data = array(
         'udf_label' => $label[$i],
				'udf_type' => $type[$i],
				'udf_accept_value' => $accept_value[$i],
				'udf_max_length' => $max_length[$i],
				'udf_not_null' => $not_null[$i],
				'company_id' => $company,
				'form_name'=>$fname,
				'isDisabled' => 0,
				'id' =>  $id,
			//	'udf_form_id' => $iden
            );
            $this->db->insert('transaction_udf_column',$data);
  }
			
//$id = $this->db->insert_id(); 

	}
	


//NEW CODE FOR UDF BY NEMZ========================================================

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

//END OF GETTING COMPANY======================================================	
	public function del_field_table($f_name,$t_table_name){
		$sample_final = str_replace(" ","_",$f_name);
 	    $final = strtolower($sample_final);
		$this->dbforge->drop_column($t_table_name, $final);
	}
	public function del_udf_option1_new($id){
		$this->db->where('tran_udf_col_id', $id);
		$this->db->delete('transaction_udf_column');
		return true;
	}
	public function modify_table_field_new($id,$t_table_name,$old_name,$old_av,$old_length,$old_type,$old_not_null){
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

            if($old_not_null == 'yes'){
            	$null = FALSE;
            }else{
            	$null = TRUE;
            }

			 if($type == 'Null'){
			$fields = array(
        			$old_name => array(
                		'name' => $final,
                		'type' => $old_fav,
                		'constraint' => $old_flength,
                		'null' => $null,
       		 ),
			);
			}else if($type == 'Textfield'){
			$fields = array(
        			$old_name => array(
                		'name' => $final,
               		    'type' => $accept_value,
       					'constraint' => $max_length
       		 ),
			);
		}else if($type == 'Datepicker'){
			$fields = array(
        			$old_name => array(
                		'name' => $final,
               		    'type' => 'datetime',
       					'constraint' => 0
       		 ),
			);

		}else if($type == 'Textarea'){
			$fields = array(
        			$old_name => array(
                		'name' => $final,
               		    'type' => $accept_value,
       					'constraint' => $max_length,
       		 ),
			);

		}else{
			$fields = array(
        			$old_name => array(
                		'name' => $final,
               		    'type' => $accept_value,
       					'constraint' => $max_length,
       		 ),
			);

		}
		$this->dbforge->modify_column($t_table_name, $fields);
	}

	public function modify_udf_new($id){
		$type = $this->input->post('type');
		$accept_value = $this->input->post('accept_value');
		$label = $this->input->post('label');
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
			$this->db->update('transaction_udf_column',$this->data);
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
			$this->db->update('transaction_udf_column',$this->data);
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
			$this->db->update('transaction_udf_column',$this->data);
		}

	}

	public function del_tran_udf_new($tudf_identifier){

	//	$this->db->where('tran_udf_col_id', $id);
	//	$this->db->delete('transaction_udf_column');

			$this->db->where('identifier', $tudf_identifier);
		$this->db->delete('transaction_udf');
		
	}

	public function del_udf_new($id){

	//	$this->db->where('tran_udf_col_id', $id);
	//	$this->db->delete('transaction_udf_column');

			$this->db->where('id', $id);
		$this->db->delete('transaction_file_maintenance');
		
	}
	public function del_tran_new($id){

	//	$this->db->where('tran_udf_col_id', $id);
	//	$this->db->delete('transaction_udf_column');

			$this->db->where('id', $id);
		$this->db->delete('transaction_udf_column');
		
	}
	public function del_emp_new($id){

	//	$this->db->where('tran_udf_col_id', $id);
	//	$this->db->delete('transaction_udf_column');

			$this->db->where('id', $id);
		$this->db->delete('employee_udf_column');
		
	}

	public function del_table($t_table_name){

	//	$this->db->where('tran_udf_col_id', $id);
	//	$this->db->delete('transaction_udf_column');
	$this->dbforge->drop_table($t_table_name,TRUE);
	$this->dbforge->drop_table($t_table_name.'_approval',TRUE);
		
	}

	public function get_udf($tf_id){
		$this->db->select('*');	
		$this->db->where('id', $tf_id);
		$query = $this->db->get('transaction_file_maintenance');
		return $query->result();
	}

	public function get_old_name($id){
		$this->db->select('*');	
		$this->db->where('tran_udf_col_id', $id);
		$query = $this->db->get('transaction_udf_column');
		return $query->result();
	}
	public function modify_udf_emp_new($id){
		
		
		
			$this->data = array(
					'form_name' => $this->input->post('fname'),
					
			);	
			//echo form_textarea($data);
			$this->db->where('id',$id);
			$this->db->update('transaction_udf_column',$this->data);
		
	
	}

	public function modify_udf_emp_new2($id){
		
		
		
			$this->data = array(
					'form_name' => $this->input->post('fname'),
					
			);	
			//echo form_textarea($data);
			$this->db->where('id',$id);
			$this->db->update('employee_udf_column',$this->data);
		
	
	}

	public function modify_tran_udf_new($value,$company_id,$tudf_identifier){
			$this->db->where('company_id',$company_id);
			$this->db->where('identifier',$tudf_identifier);
			$this->data = array(
					'transaction_for_purpose' => $this->input->post('fname'),
					
			);	
			$this->db->update('transaction_udf',$this->data);
		
	
	}
	public function modify_udf1_new($id){
		
		
		
			$this->data = array(
					'form_name' => $this->input->post('fname'),
					'form_desc' => $this->input->post('fdesc')
					//'company_id' => $this->input->post('company')
					//'identification' => $this->input->post('ident')      //JULY 9 edit	
			);	
			//echo form_textarea($data);
			$this->db->where('id',$id);
			$this->db->update('transaction_file_maintenance',$this->data);
		
	
	}

public function create_udf123_new($company_id){

        $this->form_validation->set_rules('fname', 'transaction_for_purpose', 'trim');
		$fname=$this->input->post('fname');
   
		  $data = array(
  				'transaction_for_purpose' => $fname,
  				'identifier' => $fname.'_iden',
  				'company_id' => $company_id
     	);
		
		return $this->db->insert('transaction_udf',$data);
		return $query->result();
	}


	public function create_udf1_new($company_id){


	$udf=$this->db->insert_id();


		$fname=$this->input->post('fname');
        $fdesc = $this->input->post('fdesc');
        $iden = $this->input->post('iden');


		  $data = array(
  				'IsUserDefine' 		=> 1,
				'company_id' 		=> $company_id,
				'form_name'			=> $fname,
 				'form_desc' 		=> $fdesc,
				'form_type'			=>		'T',
				'identification'	=>		'UDF'.$udf,
				't_table_name'		=>		'udf_tran_'.$udf,
				'template_name' => $fname.'_template' 
 

     	);
		
		return $this->db->insert('transaction_file_maintenance',$data);
		return $query->result();
		
	}




		public function create_udf_new($company_id){
	
		$this->form_validation->set_rules('label[]', 'Label', 'trim');
        $this->form_validation->set_rules('type[]', 'DESCRIPTIONS', 'trim'); 
        $this->form_validation->set_rules('not_null[]', 'DESCRIPTIONS', 'trim'); 
      


			$fname=$this->input->post('fname');
 			$label =  $this->input->post('label');
            $type = $this->input->post('type');
            $accept_value = $this->input->post('accept_value');
            $max_length = $this->input->post('max_length');
 			$not_null = $this->input->post('not_null');
 		//	 $iden = $this->input->post('iden');
			$id=$this->db->insert_id();
    

		$temp=count($this->input->post('type'));// count total description

		for($i=0; $i<$temp;$i++){
					/*if($type == 'Datepicker'){
			    	$a_value[$i] = 'datetime';
			   		 }else{
			    	$a_value[$i] = $accept_value[$i];
			    }
					if($accept_value[$i] == 'varchar'){
		            	$a_value[$i] = "Alphanumeric";
		            }else if($accept_value[$i] == 'text'){
		            	$a_value[$i] = "Letters";
		            }else if($accept_value[$i] == 'int'){
		            	$a_value[$i] = "Numbers";
		            }*/

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
					//	'udf_form_id' => $iden
		            );
		            $this->db->insert('transaction_udf_column',$data);
		       }


	}
	
	public function getttablename($id){                //pangkuha t_table_name para sa transaction file maintenance
		$this->db->select('*');
		$this->db->where('id', $id);
	//	$this->db->where('tran_udf_col_id', 'Textfield');
		$query = $this->db->get('transaction_file_maintenance');
		return $query->result();
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

		/*if($type == 'Datepicker'){
	    	$a_value = 'datetime';
	    	}else{
	    	$a_value = $accept_value;
	   		 }

	    if($type == 'Datepicker'){
	    	$m_length = 0;
	    } 
	    else if($type == 'Selectbox'){
	    	$m_length = 255;
	    }
	    else{
	    	$m_length = $max_length;
	    }
*/
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
			
			/*if($type == 'Datepicker'){
	    	$a_value = 'datetime';
		    }else{
		    	$a_value = $accept_value;
		    }
			if($accept_value == 'varchar'){
            	$a_value = "Alphanumeric";
            }else if($accept_value == 'text'){
            	$a_value = "Letters";
            }else if($accept_value == 'int'){
            	$a_value = "Numbers";
            }*/
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
				'id' =>  $id,

     		);

		 $this->db->insert('transaction_udf_column',$data);

	
	}	

public function check_udf_exist($value,$company_id,$fdesc){
		
		$this->db->where('form_name', $value);
		$this->db->where('form_desc', $fdesc);
		$this->db->where('company_id', $company_id);
		$query = $this->db->get('transaction_file_maintenance');

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
		$query = $this->db->get('transaction_udf_column');

        $count = $query->num_rows();
        
        if ($count === 0) {
         	return true;
        }
        else{
        	return false;
        }

	}

	public function check_udf_exist_tudfcol($value,$type,$accept_value,$max_length,$not_null,$company_id){
		
		echo $value."VALUE<br>";
		echo $type."VALUE<br>";
		echo $accept_value."VALUE<br>";
		echo $max_length."VALUE<br>";
		echo $not_null."VALUE<br>";
		$this->db->where('udf_label', $value);
		$this->db->where('udf_type', $type);
		$this->db->where('udf_accept_value', $accept_value);
		$this->db->where('udf_max_length', $max_length);
		$this->db->where('udf_not_null', $not_null);
		$this->db->where('company_id', $company_id);

		$query = $this->db->get('transaction_udf_column');

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
		$query = $this->db->get('transaction_udf_option');

        $count = $query->num_rows();
        
        if ($count === 0) {
         	return true;
        }
        else{
        	return false;
        }

	}

public function check_udf_exist_edit($value,$company_id,$tudf_identifier){
		
		$this->db->where('transaction_for_purpose', $value);
		$this->db->where('company_id', $company_id);
		$this->db->where('company_id', $tudf_identifier);
		$query = $this->db->get('transaction_udf');

        $count = $query->num_rows();
        
        if ($count === 0) {
         	return true;
        }
        else{
        	return false;
        }

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


// just in case magkaprob mauna dito dapat pag insert ng company 
			$label =  $this->input->post('label');
            $type = $this->input->post('type');
            $accept_value = $this->input->post('accept_value');
            $max_length = $this->input->post('max_length');
 			$not_null = $this->input->post('not_null');

/*=========== for time settings =========== */
$temp=count($this->input->post('type'));
 for($i=0; $i<$temp; $i++){
 		/*if($type[$i] == 'Datepicker'){
	    	$a_value[$i] = 'datetime';
	    }else{
	    	$a_value[$i] = $accept_value[$i];
	    }

	    if($type[$i] == 'Datepicker'){
	    	$m_length[$i] = 0;
	    } 
	    else if($type[$i] == 'Selectbox'){
	    	$m_length[$i] = 255;
	    }
	    else{
	    	$m_length[$i] = $max_length[$i];
	    }*/

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
				$a_value[$i] = 'date';
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

        'employee_id' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255
        ),
  		'company_id' => array(   
                'type' => 'INT',
                'constraint' => 99
        ),

        'doc_no' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255
        ),

         'status' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255
        ),
          'InActive' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,

        ),
         'IsDeleted' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
        ),

  		'entry_type' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE   
        ),
  		'file_attached' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE   
        ),
        'date_created' => array(   
                'type' => 'date',
                'constraint' => 0,
                'null' => TRUE   
        ),
        'status_update_date' => array(   
                'type' => 'date',
                'constraint' => 0,
                'null' => TRUE   
        ),
        'remarks' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE   
        ),
         'late_filing' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE   
        ),
          'late_filing_type' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE   
        ),

		$final[$i] => array(     //etong label parang yung udf_id
                'type' => $a_value[$i],
                'constraint' => $m_length[$i],   

        ),

      

	    ));

  		
	}
		$this->dbforge->add_key('id', TRUE);
  		$this->dbforge->create_table('udf_tran_'.$auto_increment, TRUE); // eto yung magiging table name


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
                'constraint' => 255
        ),
  		'approver_id' => array(   
                'type' => 'INT',
                'constraint' => 99
        ),

        'status' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255
        ),

         'comment' => array(   
                'type' => 'TEXT',
                'constraint' => 0
        ),
          'approval_level' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255
        ),
         'date_time' => array(   
                'type' => 'datetime',
                'constraint' => 0,
                'null' => TRUE   
        ),

  		'responder_id' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255
        ),
  		'approval_type' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255
        ),

		'submitted_on' => array(   
                'type' => 'date',
                'constraint' => 0
        ),
		'status_view' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255
        ),
        'original_approver' => array(   
                'type' => 'VARCHAR',
                'constraint' => 255
        ),
        'date_transferred' => array(   
                'type' => 'date',
                'constraint' => 0,
                'null' => TRUE
        ),
	    ));
		
		$this->dbforge->add_key('id', TRUE);
  		$this->dbforge->create_table('udf_tran_'.$auto_increment.'_approval', TRUE); // eto yung magiging table name






		$fname=$this->input->post('fname');
        $fdesc = $this->input->post('fdesc');
        $iden = $this->input->post('iden');


		  $data = array(
  				'IsUserDefine' 		=> 1,
				'company_id' 		=> $company_id,
				'form_name'			=> $fname,
 				'form_desc' 		=> $fdesc,
				'form_type'			=>		'T',
				'identification'	=>		'UDF'.$auto_increment,
				't_table_name'		=>		'udf_tran_'.$auto_increment,
				'template_name' => $fname.'_template',
				'tudf_identifier' => $fname.'_iden',
				'IsActive' => 1 
 

     	);
		
		return $this->db->insert('transaction_file_maintenance',$data);
		return $query->result();
		


	}
	/*public function validate_company(){
		$value = $this->input->post("company_name");
		if($this->file_maintenance_model->validate_company()){
			$this->form_validation->set_message("validate_company"," Company Name, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}*/

//END OF CODE BY NEMZ==================================================================



	public function create_udf1($company){


$udf=$this->db->insert_id();


		$fname=$this->input->post('fname');
      $fdesc = $this->input->post('fdesc');
       $iden = $this->input->post('iden');


		  $data = array(
  				'IsUserDefine' => 1,
				'company_id' => $company,
				'form_name'=>$fname,
 	'form_desc' => $fdesc,
				'form_type'			=>		'T',
				'identification'			=>		'UDF'.$udf,
				'template_name' => $fname.'_template' 
 

     	);
		
		return $this->db->insert('transaction_file_maintenance',$data);
		return $query->result();
		
	}

	public function create_udf123($company){
        
		$fname=$this->input->post('fname');
   
		  $data = array(
  				'transaction_for_purpose' => $fname
     	);
		
		return $this->db->insert('transaction_udf',$data);
		return $query->result();
	}



		public function download_employee_info_template () {
		
        $this->load->helper('download');            
		$path    =   file_get_contents(base_url()."public/downloadable_templates/udf_template/employee_info.xls");
		$name    =   "test_info.xls";
		force_download($name, $path); 

	//	$value = $name;

	//	General::logfile('Employee Personal Info Template','DOWNLOAD',$value);
                             
    }




    public function download($table_name)
    {
        $query = $this->db->get('transaction_udf_column');
 
        if(!$query)
            return false;
 
        // Starting the PHPExcel library
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
 
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
 
        $objPHPExcel->setActiveSheetIndex(0);
 
        // Field names in the first row
        $fields = $query->list_fields();
        $col = 0;
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
 
        // Fetching the table data
        $row = 2;
   
        $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 
        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Products_'.date('dMy').'.xls"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
    }



   // public $table = '';
   // public $primary_key = '';



    public function read()
    {

    		$id = $this->uri->segment("4");
    	$this->db->select('*');
    	$this->db->from($this->table);
    	$this->db->where('id', $id);
    	return $this->db->get()->result();
    }






 

	



		public function create_udf5($form){
			$id = $this->uri->segment("4");
 	 $data = array(
  				
				'id' => $id,
				'udf_label' => $this->input->post('label'),
				'udf_type' => $this->input->post('type'),
				'udf_accept_value' => $this->input->post('accept_value'),
				'udf_max_length' => $this->input->post('max_length'),
				'udf_not_null' => $this->input->post('not_null'),


     	);

		return $this->db->insert('transaction_udf_column',$data);		

	}








	public function create_udf_opt($value){
		$id = $this->uri->segment("4");
		//echo $value.'::';
		$data = array(
				'udf_tran_col_id' => $id,
				'optionLabel' => $value,
				'isDisabled' => 0,


		);
		return $this->db->insert('transaction_udf_option',$data);			
	}





// PARA MAKAPAG ADD NG COLUMN SA TRANSACTION_UDF_STORE 
	public function create_udf_store($company){
		$length = $this->input->post('max_length');
		$value = $this->input->post('accept_value');
		$type = $this->input->post('type');

		if($value =='Numbers'){
			$value = 'int';
		}
		else{
			$value = 'varchar';
		}

		$labeltemp = $this->input->post('label');
		$labeltemp2 = str_replace(' ', '_', $labeltemp);
		$label = $labeltemp2.'_'.$company;

		$fields = array(
		    $label => 
		    	array(
		    		'type' => $value,
		    		'constraint' => 225
		    	)

			);
		$check = $this->dbforge->add_column('transaction_udf_store', $fields);
		
	}

// PARA MAKAPAG ADD NG COLUMN SA TRANSACTION_UDF_STORE 






	public function modify_udf($id){
		$type = $this->input->post('type');
		
		if($type === 'Null'){
			$this->data = array(
					'udf_label' => $this->input->post('label'),
					'udf_not_null' => $this->input->post('not_null'),
					'company_id' => $this->input->post('company'),
					'isDisabled' => 0
			);	
			$this->db->where('tran_udf_col_id',$id);
			$this->db->update('transaction_udf_column',$this->data);
		}
		else{
			$this->data = array(
					'udf_label' => $this->input->post('label'),
					'udf_type' => $this->input->post('type'),
					'udf_accept_value' => $this->input->post('accept_value'),
					'udf_max_length' => $this->input->post('max_length'),
					'udf_not_null' => $this->input->post('not_null'),
					'company_id' => $this->input->post('company'),
					'isDisabled' => 0
			);	
			$this->db->where('tran_udf_col_id',$id);
			$this->db->update('transaction_udf_column',$this->data);
		}

	}




	public function modify_udf1($id){
		
		
		
			$this->data = array(
					'form_name' => $this->input->post('fname'),
					'form_desc' => $this->input->post('fdesc'),
					'company_id' => $this->input->post('company')
					//'identification' => $this->input->post('ident')      //JULY 9 edit
					
			);	
			echo form_textarea($data);
			$this->db->where('id',$id);
			$this->db->update('transaction_file_maintenance',$this->data);
		
	
	}


		public function modify_udf33($id){
		
		
		
			$this->data = array(
					'form_name' => $this->input->post('fname'),
					
			);	
			echo form_textarea($data);
			$this->db->where('id',$id);
			$this->db->update('transaction_udf_column',$this->data);
		
	
	}

	public function modify_udf_opt($id){
		$this->data = array(
				'optionLabel' => $this->input->post('optlabel'),
				'isDisabled' => 0
		);	
		$this->db->where('tran_udf_opt_id',$id);
		$this->db->update('transaction_udf_option',$this->data);
	}

	public function modify_udf_store($colName){

		$length = $this->input->post('max_length');
		$value = $this->input->post('accept_value');
		$company = $this->input->post('company');
		$label = str_replace(' ', '_', $colName); //old

		$labeltemp = $this->input->post('label');
		$labeltemp2 = str_replace(' ', '_', $labeltemp);
		$labelold = $labeltemp2.'_'.$company;

		$value = $this->input->post('accept_value');
		if($value =='Numbers'){
			$value = 'int';
		}
		else{
			$value = 'varchar';
		}

		$fields = array(
	    $label => 
	    	array(
	    		'name' => $labelold,
	    		'type' => $value,
	    		'constraint' => 225
	    	)

		);
		$this->dbforge->modify_column('transaction_udf_store', $fields);
	}
	


	public function del_udf($id){

	//	$this->db->where('tran_udf_col_id', $id);
	//	$this->db->delete('transaction_udf_column');

			$this->db->where('id', $id);
		$this->db->delete('transaction_file_maintenance');
		return true;
	}

	public function del_udf_store($colName){

		$this->dbforge->drop_column('transaction_udf_store', $colName);
	}

	public function del_udf_option($id){
		$this->db->where('tran_udf_opt_id', $id);
		$this->db->delete('transaction_udf_option');
		return true;
	}

	public function del_udf_option1($id){
		$this->db->where('tran_udf_col_id', $id);
		$this->db->delete('transaction_udf_column');
		return true;
	}

	public function del_udf_optcol($id){
		$this->db->where('udf_tran_col_id', $id);
		$this->db->delete('transaction_udf_option');
		return true;
	}

	public function colName_udf_store($id){
		$this->db->where('id', $id);
		$query = $this->db->get('transaction_file_maintenance');
		return $query->result();
	}


		public function colName_udf_store22($id){ //duplicate for the option slectbox july 3
		$this->db->where('tran_udf_col_id', $id);
		$query = $this->db->get('transaction_udf_column');
		return $query->result();
	}

		public function colName_udf_store27($id){ //duplicate for the option slectbox july 3
		$this->db->where('id', $id);
		$query = $this->db->get('transaction_file_maintenance');
		return $query->result();
	}

	public function check_udf_label($company){
		$value = $this->input->post('fname');
		echo 'company '.$company.' ';
		$this->db->where('company_id', $company);
		$this->db->where('form_name', $value);                //////// START HERE SA PAG EEDIT JUNE 29
		$query = $this->db->get('transaction_file_maintenance');

        $count = $query->num_rows();
        echo $count;
        if ($count === 0) {
         	return true;
        }
        else{
        	return false;
        }

	}

///////////////////////DINAGDAG/////////////////////
		public function check_udf_label1($form){
		$value = $this->input->post('label');
		echo 'form '.$form.' ';
		$this->db->where('id', $form);
		$this->db->where('udf_label', $value);
		$query = $this->db->get('transaction_udf_column');

        $count = $query->num_rows();
        echo $count;
        if ($count === 0) {
         	return true;
        }
        else{
        	return false;
        }

	}
///////////////////////////////////////////////

	public function check_udf_label_ex($value){ //modify
		 $id = $this->uri->segment("4");

        $this->db->select('udf_label');
		$this->db->where('tran_udf_col_id !=', $id);
		$this->db->where('udf_label', $value);
		$query = $this->db->get('transaction_udf_column');

        $count = $query->num_rows();
        echo $count;
        if ($count === 0) {
         	return true;
        }

	}

	public function getOptlabel($id){
		//$this->db->select('*');
		$this->db->where('udf_tran_col_id', $id);
		$query = $this->db->get('transaction_udf_option');
		return $query->result();
	}


		public function getOptlabel3($id){                //pangkuha para sa transaction file maintenance
		//$this->db->select('*');
		$this->db->where('id', $id);
	//	$this->db->where('tran_udf_col_id', 'Textfield');
		$query = $this->db->get('transaction_udf_column');
		return $query->result();
	}



	public function get_udf_type($id){ 

		$this->db->select('udf_label');
		$this->db->where('tran_udf_col_id', $id);
		$this->db->where('udf_type', 'Textfield');
		$query = $this->db->get('transaction_udf_column');

		$count = $query->num_rows();
        if ($count === 1) {
         	return true;
        }
	}


//pinagbabasihan lang nung column na data yung sa company_id
	public function get_udf_company($value){
		$this->db->where('company_id', $value);
		$query = $this->db->get('transaction_file_maintenance');
		return $query->result();
	}

// changes of the above codes------------^^^

public function get_udf_by_company($company_id){
		$this->db->where(array(
							'company_id'   => $company_id,
							'IsUserDefine' => 1
			));
		$query = $this->db->get('transaction_file_maintenance');
		return $query->result();
	}

//== FOR DISABLING AUTOMATIC=======================================================================
	public function get_lists($id){
		$this->db->where(array(
			'id'		=>	$id
		));		
		$query = $this->db->get("transaction_file_maintenance");
		return $query->row();
	}
	public function deactivate_notif_list($id){
		$this->db->where('id',$id);
		$this->data = array('IsActive'=>0);
		$this->db->update("transaction_file_maintenance",$this->data);	
	}
	public function activate_notif_list($id){
		$this->db->where('id',$id);
		$this->data = array('IsActive'=>1);
		$this->db->update("transaction_file_maintenance",$this->data);	
	}

}
