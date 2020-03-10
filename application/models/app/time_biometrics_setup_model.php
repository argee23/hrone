<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Time_biometrics_setup_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	//============= brand management
	public function brandmng(){
		$query=$this->db->query("SELECT * from `biometrics_brand` order by brand_name asc");
		return $query->result();

	}
	public function active_brand(){
		$query=$this->db->query("SELECT * from `biometrics_brand` where InActive=0 order by brand_name asc");
		return $query->result();	
	}
	public function edit_brand(){
		$brand_name=$this->input->post("brand_name");
		$bio_categ_id=$this->input->post("bio_categ_id");
		$du=date("Y-m-d h:i:sa");
		$query=$this->db->query("update `biometrics_brand` set brand_name='".$brand_name."',date_updated='".$du."' where bio_categ_id='".$bio_categ_id."'");
		
	}
	public function selected_brand($bio_categ_id){
		$query=$this->db->query("SELECT * from `biometrics_brand` where bio_categ_id='".$bio_categ_id."'");
		return $query->row();	
	}

	public function validate_edit_brand_name($value){
		$bio_categ_id=$this->input->post("bio_categ_id");
		$this->db->where(array(
			'brand_name'		=>		$value,
			'bio_categ_id !=' 	=> $bio_categ_id,
		));
		$query = $this->db->get("biometrics_brand");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function validate_brand_name($value){
		$this->db->where(array(
			'brand_name'		=>		$value
		));
		$query = $this->db->get("biometrics_brand");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function save_brand(){
			$this->data = array(
			'brand_name'		=> $this->input->post('brand_name'),
			'date_added'		=> date("Y-m-d h:i:sa"),
			'InActive'			=> 0
		);	
		$this->db->insert('biometrics_brand',$this->data);
	}

	//====================
	public function biotypemng(){

		$query=$this->db->query("SELECT b.brand_name,b.InActive as brand_InActive,a.*,c.cValue from `biometrics` a  inner join biometrics_brand b on(a.bio_brand_id=b.bio_categ_id) inner join system_parameters c on(a.bio_db_type=c.param_id) order by a.bio_brand_id asc");


		return $query->result();	
	}
	public function save_bio_type(){
			$this->data = array(
			'bio_brand_id'		=> $this->input->post('brand_name'),
			'bio_name'			=> $this->input->post('bio_type'),
			'bio_db_type'		=> $this->input->post('bio_db_type'),
			'bio_details'		=> $this->input->post('bio_details'),
			'real_time_status'	=> '0',
			'date_added'		=> date("Y-m-d h:i:sa"),
			'InActive'			=> 0
		);	
		$this->db->insert('biometrics',$this->data);
	}

	public function validate_bio_type($value){
		$brand=$this->input->post('brand_name');
		$this->db->where(array(
			'bio_brand_id'		=>		$brand,
			'bio_name'		=>		$value
		));
		$query = $this->db->get("biometrics");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function edit_bio_type($id){ // functions is also used in controller: time_manual_attendance 
		
		$query=$this->db->query("SELECT b.brand_name,b.InActive as brand_InActive,a.*,c.cValue from `biometrics` a  inner join biometrics_brand b on(a.bio_brand_id=b.bio_categ_id) inner join system_parameters c on(a.bio_db_type=c.param_id) where a.id='".$id."'");

		return $query->row();	
	}

	public function selected_bio_type($id){ // functions is also used in controller: time_manual_attendance 
		
		$query=$this->db->query("SELECT b.brand_name,b.InActive as brand_InActive,a.*,c.cValue,d.cValue as sync_action_text from `biometrics` a  inner join biometrics_brand b on(a.bio_brand_id=b.bio_categ_id) inner join system_parameters c on(a.bio_db_type=c.param_id) inner join system_parameters d on(a.sync_action=d.param_id) where a.id='".$id."'");

		return $query->row();	
	}
	public function checkbeforedelete($bio_categ_id){ // biometrics type which is either active or inactive
		$query=$this->db->query("SELECT id from biometrics where bio_brand_id='".$bio_categ_id."'");
		return $query->row();	
	}
	public function checkbeforedisable($bio_categ_id){ // biometrics type which is active
		$query=$this->db->query("SELECT id from biometrics where bio_brand_id='".$bio_categ_id."' and InActive=0");
		return $query->row();	
	}

	public function edit_bio(){
		$bio_type=$this->input->post("bio_type");
		$bio_db_username=$this->input->post("bio_db_username");
		$bio_db_password=$this->input->post("bio_db_password");
		$bio_details=$this->input->post("bio_details");
		$id=$this->input->post("id");
		$du=date("Y-m-d h:i:sa");
		$query=$this->db->query("update `biometrics` set bio_name='".$bio_type."',bio_db_username='".$bio_db_username."',bio_db_password='".$bio_db_password."',date_updated='".$du."',bio_details='".$bio_details."' where id='".$id."'");
		
	}

	public function validate_edit_bio_name($value){
		$brand_name=$this->input->post("brand_name");
		$id=$this->input->post("id");

		$this->db->where(array(
			'bio_name'			=>		$value,
			'id !=' 	=> 	$id,
			'bio_brand_id' 	=> 	$brand_name,
		));
		$query = $this->db->get("biometrics");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}


	public function save_manage_setup(){
		$file_loc_name=$this->input->post("file_loc_name");
		$ip_address=$this->input->post("ip_address");
		$file_table_name=$this->input->post("file_table_name");
		$employee_id_field_name=$this->input->post("employee_id_field_name");
		$logs_field_name=$this->input->post("logs_field_name");
		$logs_type_field_name=$this->input->post("logs_type_field_name");

		$code_in=$this->input->post("code_in");
		$code_out=$this->input->post("code_out");

		$code_break_in1=$this->input->post("code_break_in1");
		$code_break_out1=$this->input->post("code_break_out1");
		$code_lunch_in=$this->input->post("code_lunch_in");
		$code_lunch_out=$this->input->post("code_lunch_out");
		$code_break_in2=$this->input->post("code_break_in2");
		$code_break_out2=$this->input->post("code_break_out2");
		$sync_action=$this->input->post("sync_action");
		$real_time_timer=$this->input->post("real_time_timer");
		$data_source_name_driver=$this->input->post("data_source_name_driver");

		$id=$this->input->post("id");
		$du=date("Y-m-d h:i:sa");
		$query=$this->db->query("update `biometrics` set 
			file_loc_name='".$file_loc_name."',
			ip_address='".$ip_address."',
			file_table_name='".$file_table_name."',
			employee_id_field_name='".$employee_id_field_name."',
			logs_field_name='".$logs_field_name."',
			logs_type_field_name='".$logs_type_field_name."',
			code_in='".$code_in."',
			code_out='".$code_out."',
			code_break_in1='".$code_break_in1."',
			code_break_out1='".$code_break_out1."',
			code_lunch_in='".$code_lunch_in."',
			code_lunch_out='".$code_lunch_out."',
			code_break_in2='".$code_break_in2."',
			code_break_out2='".$code_break_out2."',
			sync_action='".$sync_action."',
			real_time_timer='".$real_time_timer."',
			data_source_name_driver='".$data_source_name_driver."',
			date_updated='".$du."' where id='".$id."'");
		
	}

	public function check_real_time_bio(){

		$query=$this->db->query("SELECT real_time_status from biometrics where real_time_status='1'");

		return $query->row();	
	}

	public function ActiveBioType(){

		$query=$this->db->query("SELECT b.brand_name,b.InActive as brand_InActive,a.*,c.cValue from `biometrics` a  inner join biometrics_brand b on(a.bio_brand_id=b.bio_categ_id) inner join system_parameters c on(a.bio_db_type=c.param_id) where a.InActive='0' order by a.bio_brand_id asc");

		return $query->result();	
	}

	public function insertRealTimeComp($chosen_comp_id){
		$id=$this->input->post("id");
		$this->data = array(
			'biometrics_id'				=>		$id,
			'company_id'				=>		$chosen_comp_id,
			'date_added'				=>		date("Y-m-d h:i:s a")
		);		
		$this->db->insert("biometrics_realtime",$this->data);

	}




}