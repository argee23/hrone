<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Employee_user_define_fields_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}



	public function user_define_fields(){
		$this->db->order_by('udf_label','asc');
		$this->db->select('udf_label','company_id');
		$query = $this->db->get('employee_udf_column');
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

	public function get_udf_col_All($id){ 
		$query = $this -> db
		->where('emp_udf_col_id', $id)
		->get('employee_udf_column');
		return $query->row();
	}

	public function get_udf_col($id){ 
		$query = $this -> db
		->where('emp_udf_col_id', $id)
		->get('employee_udf_column');
		return $query->row();
	}

	public function get_udf_col_com($id){ 
		$query = $this -> db
		->where('emp_udf_col_id', $id)
		->get('employee_udf_column');
		return $query->row();
	}

	public function get_udf_opt($id){ 
		//echo 'ID '.$id;
		$query = $this -> db
		->where('emp_udf_opt_id', $id)
		->get('employee_udf_option');
		return $query->row();
	}

	public function create_udf($company){
		$data = array(
				'udf_label' => $this->input->post('label'),
				'udf_type' => $this->input->post('type'),
				'udf_accept_value' => $this->input->post('accept_value'),
				'udf_max_length' => $this->input->post('max_length'),
				'udf_not_null' => $this->input->post('not_null'),
				'company_id' => $company,
				'isDisabled' => 0
		);
		return $this->db->insert('employee_udf_column',$data);			
	}



	public function create_udf_opt($Lastudf,$field){
		echo '<br>2 value';
		$data = array(
				'udf_emp_col_id' => $Lastudf,
				'optionLabel' 	 => $field,
				'isDisabled' 	 => 0
		);

		return $this->db->insert('employee_udf_option',$data);			
	}

	public function create_udf_option($id){
		echo '<br>1 value';
		$data = array(
				'udf_emp_col_id' => $id,
				'optionLabel' 	 => $this->input->post('option'),
				'isDisabled' 	 => 0
		);
		return $this->db->insert('employee_udf_option',$data);			
	}

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
		$check = $this->dbforge->add_column('employee_udf_store', $fields);
		
	}



	public function modify_udf($id){
		$type = $this->input->post('type');
		
		if($type === 'Null'){
			$this->data = array(
					'udf_label' => $this->input->post('label'),
					'udf_not_null' => $this->input->post('not_null'),
					//'company_id' => $this->input->post('company'),
					'isDisabled' => 0
			);	
			$this->db->where('emp_udf_col_id',$id);
			$this->db->update('employee_udf_column',$this->data);
		}
		else{
			$this->data = array(
					'udf_label' => $this->input->post('label'),
					//'udf_type' => $this->input->post('type'),
					//'udf_accept_value' => $this->input->post('accept_value'),
					//'udf_max_length' => $this->input->post('max_length'),
					'udf_not_null' => $this->input->post('not_null'),
					//'company_id' => $this->input->post('company'),
					'isDisabled' => 0
			);	
			$this->db->where('emp_udf_col_id',$id);
			$this->db->update('employee_udf_column',$this->data);
		}
	}

	public function modify_udf_opt($id){
		$this->data = array(
				'optionLabel' => $this->input->post('optlabel'),
				'isDisabled' => 0
		);	
		$this->db->where('emp_udf_opt_id',$id);
		$this->db->update('employee_udf_option',$this->data);
	}

	public function modify_udf_store($colName,$company){

		//$length = $this->input->post('max_length');
		$value = $this->input->post('accept_value');
		//$company = $this->input->post('company');
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
		$this->dbforge->modify_column('employee_udf_store', $fields);
	}
	


	public function del_udf($id){

		$this->db->where('emp_udf_col_id', $id);
		$this->db->delete('employee_udf_column');
		return true;
	}

	public function del_udf_store($colName){

		$this->dbforge->drop_column('employee_udf_store', $colName);
	}

	public function del_udf_option($id){
		$this->db->where('emp_udf_opt_id', $id);
		$this->db->delete('employee_udf_option');
		return true;
	}

	public function del_udf_optcol($id){
		$this->db->where('udf_emp_col_id', $id);
		$this->db->delete('employee_udf_option');
		return true;
	}

	public function colName_udf_store($id){
		$this->db->where('emp_udf_col_id', $id);
		$query = $this->db->get('employee_udf_column');
		return $query->row();
	}

	public function check_udf_label($company){
		$value = $this->input->post('label');
		echo 'company '.$company.' ';
		$this->db->where('company_id', $company);
		$this->db->where('udf_label', $value);
		$query = $this->db->get('employee_udf_column');

        $count = $query->num_rows();
        echo $count;
        if ($count === 0) {
         	return true;
        }
        else{
        	return false;
        }

	}


	public function check_udf_label_ex($value){ //modify
		 $id = $this->uri->segment("4");

        $this->db->select('udf_label');
		$this->db->where('emp_udf_col_id !=', $id);
		$this->db->where('udf_label', $value);
		$query = $this->db->get('employee_udf_column');

        $count = $query->num_rows();
        echo $count;
        if ($count === 0) {
         	return true;
        }

	}

	public function getOptlabel($id){
		//$this->db->select('*');
		$this->db->where('udf_emp_col_id', $id);
		$query = $this->db->get('employee_udf_option');
		return $query->result();
	}

	public function get_udf_type($id){ 

		$this->db->select('udf_label');
		$this->db->where('emp_udf_col_id', $id);
		$this->db->where('udf_type', 'Textfield');
		$query = $this->db->get('employee_udf_column');

		$count = $query->num_rows();
        if ($count === 1) {
         	return true;
        }
	}

	public function get_udf_company($value){
		$this->db->where('company_id', $value);
		$query = $this->db->get('employee_udf_column');
		return $query->result();
	}

	public function get_latest_insert_udf(){
		$this->db->select_max('emp_udf_col_id');
    	$query  = $this->db->get('employee_udf_column');
    	return $query->row();
	}
}
