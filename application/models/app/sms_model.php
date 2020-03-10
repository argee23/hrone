<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Sms_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function filter_employees($company_id,$division_condition,$department_condition,$section_condition,$sub_section_condition,$location_condition,$classification_condition,$employment_condition){

	$query = $this->db->query("SELECT employee_id,name_lname_first as name FROM masterlist
	WHERE InActive='0' AND company_id='".$company_id."' 
	$division_condition $department_condition $section_condition $sub_section_condition $location_condition $classification_condition $employment_condition
	AND employee_id NOT IN (SELECT employee_id FROM sms_registered_emp) order by name ASC");	

	return $query->result();	

	}	

	public function verify_emp_phone($employee_id,$mobile_phone_id){

	$query = $this->db->query("SELECT id FROM sms_registered_emp_phone_designation where employee_id='".$employee_id."' AND mobile_phone_id='".$mobile_phone_id."' ");	

	return $query->row();	

	}

	public function get_synch_setttings(){
		$this->db->where("id",1);//system default
		$query = $this->db->get('sms_synchronizer_settings');
		return $query->row();// important : this must be array		
	}

	public function check_if_phone_exist($company_id){

		$this->db->where("company_id",$company_id);
		$query = $this->db->get('sms_registered_mobile_phone');
		return $query->result();// important : this must be array

	}

	public function sms_notif_setting($company_id){

	//	$this->db->where("company_id",$company_id);
		$query = $this->db->get('sms_notification');
		return $query->result();

	}	
	public function sms_notif_value($company_id,$id){

		$this->db->where(array(
			'sms_notif_id'			=>		$id,
			'company_id'			=>		$company_id
		));
		$query = $this->db->get('sms_notification_settings');
		return $query->row();

	}

	public function verify_employee_network($id){

		$this->db->where("mobile_1_sms_network",$id)->or_where("mobile_2_sms_network",$id)->or_where("mobile_3_sms_network",$id)->or_where("mobile_4_sms_network",$id);
		$query = $this->db->get('sms_mobile_no_networks');
		return $query->result();	
	}

	public function check_enrolled_emp($company_id){
		$this->db->select("a. *,b.first_name,b.last_name");
		$this->db->where("b.company_id",$company_id);

		$this->db->join('employee_info b','b.employee_id=a.employee_id');
		$query = $this->db->get('sms_registered_emp a');
		return $query->result();
	}
	public function get_table_content(){

		$this->db->select("*",false);
		$query = $this->db->get('sms_network');
		return $query->result();
	}

	public function get_registeredPhone(){

		$this->db->select('a.*,b.company_name');
		$this->db->order_by('b.company_name','ASC');
		$this->db->join('company_info b','b.company_id=a.company_id');
		$query = $this->db->get('sms_registered_mobile_phone a');
		return $query->result();
	}


	public function phone_locationList($id){

		$this->db->select("a.*,b.location_name");
		$this->db->where(array(
			'a.phone_id'			=>		$id
		));	
		$this->db->join('location b','b.location_id=a.location_id');
		$query = $this->db->get('sms_phone_location a');
		return $query->result();
	}	

	public function check_phone_location($location_id,$id){

		$this->db->select("*",false);
		$this->db->where(array(
			'location_id'		=>		$location_id,
			'phone_id'			=>		$id
		));	

		$query = $this->db->get('sms_phone_location');
		return $query->row();
	}	
	public function check_sec_subsect($section_id){

		$this->db->select("wSubsection",false);
		$this->db->where(array(
			'section_id'		=>		$section_id
		));	

		$query = $this->db->get('section');
		return $query->row();
	}	
	public function checkCompDivSettting($company_id){

		$this->db->select("wDivision",false);
		$this->db->where(array(
			'company_id'		=>		$company_id
		));	

		$query = $this->db->get('company_info');
		return $query->row();
	}	

	public function get_masterlist_mobile($val){

		$this->db->select("*",false);
		$this->db->where(array(
			'company_id'		=>		$val
		));	

		$query = $this->db->get('sms_masterlist');
		return $query->result();
	}
	public function verify_employee_num($id){

		$this->db->select("*",false);
		$query = $this->db->get('sms_network');
		return $query->result();
	}
	public function get_specific_network($val){

		$this->db->select("*",false);
		$this->db->where(array(
			'id'		=>		$val
		));	

		$query = $this->db->get('sms_network');
		return $query->row();
	}

	public function save_network($value){
		$this->data = array(
			'network'		=> $value,
			'InActive'			=> 0
			);
		$this->db->insert('sms_network',$this->data);
	}

	public function save_sync_setting($data_sync_setting){
		$this->db->where(array(
			'id'		=>		1//system default
		));	
		$this->db->update('sms_synchronizer_settings',$data_sync_setting);
	}
	public function save_sms_notif_setting($notif_setting_values){

		$this->db->insert('sms_notification_settings',$notif_setting_values);
	}

	
	public function enroll_emp_phone($emp_phones){

		$this->db->insert('sms_registered_emp_phone_designation',$emp_phones);
	}	
	public function save_selected_emp($save_values){

		$this->db->insert('sms_registered_emp',$save_values);
	}	

	public function save_reg_phone($data_reg_phones){

		$this->db->insert('sms_registered_mobile_phone',$data_reg_phones);
	}	
	public function update_loc_reg_phones($update_loc_reg_phones){

		$this->db->insert('sms_phone_location',$update_loc_reg_phones);
	}
	public function get_specific_regphone($val){

		$this->db->select("a.*,b.company_name");
		$this->db->where(array(
			'a.id'		=>		$val
		));	
		$this->db->join('company_info b','b.company_id=a.company_id');
		$query = $this->db->get('sms_registered_mobile_phone a');
		return $query->row();
	}

	public function update_reg_phone($id,$value,$mobile_type){
		$id=$this->input->post('id');
		$this->data = array(
			'app_mobile_no'		=> $value,
			'mobile_type'		=> $mobile_type
			);
		$this->db->where(array(
			'id'		=>		$id
		));

		$this->db->update('sms_registered_mobile_phone',$this->data);
	}


	public function update_network($value){
		$id=$this->input->post('id');
		$this->data = array(
			'network'		=> $value
			);
		$this->db->where(array(
			'id'		=>		$id
		));

		$this->db->update('sms_network',$this->data);
	}

	public function enable_disable_regphone($id,$content){
		
		$this->data = array(
			'InActive'		=> $content
			);
		$this->db->where(array(
			'id'		=>		$id
		));

		$this->db->update('sms_registered_mobile_phone',$this->data);
	}

	public function validate_add_reg_phone($cid){
		$this->db->select("*");
		$this->db->where(array(
			'app_mobile_no'		=>		$this->input->post('app_mobile_no'),
			'company_id'		=>		$cid
		));	

		$query = $this->db->get("sms_registered_mobile_phone");
		return $query->row();
	}
	public function validate_add_network($value){
		$this->db->select("*");
		$this->db->where(array(
			'network'		=>		$value
		));	
		$query = $this->db->get("sms_network");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}

	public function validate_edit_network($value){
		$id=$this->input->post('id');
		$this->db->where(array(
			'id!='					=>		$id,
			'network'			=>		$value
		));
		$query = $this->db->get("sms_network");
		return $query->row();
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	public function validate_edit_reg_phone($value){
		$id=$this->input->post('id');
		$this->db->where(array(
			'id!='					=>		$id,
			'app_mobile_no'			=>		$value
		));
		$query = $this->db->get("sms_registered_mobile_phone");
		return $query->row();
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	public function get_comp_employee($company_id){
		$query=$this->db->query("SELECT employee_id,name_lname_first as name FROM masterlist WHERE company_id='".$company_id."' ");
		return $query->result();		
	}

	public function get_filtered_masterlist($company_id,$location_condition,$employment_condition,$classification_condition,$division_condition,$department_condition,$section_condition,$sub_section_condition){

$query=$this->db->query("SELECT b.mobile_1_sms_network,b.mobile_2_sms_network,b.mobile_3_sms_network,b.mobile_4_sms_network,a.employee_id,a.mobile_1,a.mobile_2,a.mobile_3,a.mobile_4,a.last_name,a.first_name FROM sms_masterlist a inner join sms_mobile_no_networks b on (a.employee_id=b.employee_id) WHERE a.company_id='".$company_id."' 
	$location_condition $employment_condition $classification_condition $division_condition $department_condition $section_condition $sub_section_condition ");
return $query->result();			
	}


	public function getGroupedContacts($company_id){
	$query=$this->db->query("SELECT * FROM sms_grouped_contact WHERE company_id='".$company_id."' ");
	return $query->result();	

	}
	public function getActiveGroupedContacts($company_id){
	$query=$this->db->query("SELECT * FROM sms_grouped_contact WHERE company_id='".$company_id."' AND InActive='0' ");
	return $query->result();	

	}
	public function save_add_grouped_contact($data_save_add_grouped_contact){

		$this->db->insert('sms_grouped_contact',$data_save_add_grouped_contact);
	}

	public function validate_add_grouped_contact($group_name,$company_id){
		$this->db->select("*");
		$this->db->where(array(
			'company_id'		=>		$company_id,
			'group_name'		=>		$group_name
		));	
		$query = $this->db->get("sms_grouped_contact");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}
	public function validate_update_grouped_contact($group_name,$company_id,$id){
		$this->db->select("*");
		$this->db->where(array(
			'id !='		=>		$id,
			'company_id'		=>		$company_id,
			'group_name'		=>		$group_name
		));	
		$query = $this->db->get("sms_grouped_contact");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}

	public function GroupContInfo($val,$company_id){
		$query=$this->db->query("SELECT * FROM sms_grouped_contact WHERE company_id='".$company_id."' AND id='".$val."' ");
		return $query->row();			
	}

	public function save_update_grouped_contact($data_save_update_grouped_contact,$id){
		$this->db->where(array(
			'id'		=>		$id
		));	
		$this->db->update('sms_grouped_contact',$data_save_update_grouped_contact);
	}


	public function en_dis_grouped_contact($id,$content){
		
		$this->data = array(
			'InActive'		=> $content
			);
		$this->db->where(array(
			'id'		=>		$id
		));

		$this->db->update('sms_grouped_contact',$this->data);
	}
	public function filter_for_grouped_employees($company_id,$division_condition,$department_condition,$section_condition,$sub_section_condition,$location_condition,$classification_condition,$employment_condition,$group_id){

	$query = $this->db->query("SELECT employee_id,name_lname_first as name FROM masterlist
	WHERE InActive='0' AND company_id='".$company_id."' 
	$division_condition $department_condition $section_condition $sub_section_condition $location_condition $classification_condition $employment_condition
	AND employee_id NOT IN (SELECT employee_id FROM sms_grouped_contact_members WHERE sgc_id='".$group_id."' ) order by name ASC");	

	return $query->result();	

	}	

	public function check_enrolled_emp_for_grouped_contact($company_id,$group_id){

		$query=$this->db->query("SELECT a.*,b.first_name,b.last_name FROM sms_grouped_contact_members a INNER JOIN employee_info b ON (a.employee_id=b.employee_id) WHERE b.company_id='".$company_id."' AND a.sgc_id='".$group_id."' ");

		return $query->result();
	}
	public function get_group_member($grouped_contact){

// echo "SELECT c.mobile_1_sms_network,c.mobile_2_sms_network,c.mobile_3_sms_network,c.mobile_4_sms_network,a.employee_id,b.first_name,b.last_name,b.mobile_1,b.mobile_2,b.mobile_3,b.mobile_4 FROM sms_grouped_contact_members a INNER JOIN sms_masterlist b ON (a.employee_id=b.employee_id) inner join sms_mobile_no_networks c on (a.employee_id=c.employee_id)  WHERE a.sgc_id='".$grouped_contact."' ";

		$query=$this->db->query("SELECT c.mobile_1_sms_network,c.mobile_2_sms_network,c.mobile_3_sms_network,c.mobile_4_sms_network,a.employee_id,b.first_name,b.last_name,b.mobile_1,b.mobile_2,b.mobile_3,b.mobile_4 FROM sms_grouped_contact_members a INNER JOIN sms_masterlist b ON (a.employee_id=b.employee_id) inner join sms_mobile_no_networks c on (a.employee_id=c.employee_id)  WHERE a.sgc_id='".$grouped_contact."' ");

		return $query->result();		
	}


	public function check_other_grouped_enrolled($company_id,$group_id){


		$query=$this->db->query("SELECT a.*,b.first_name,b.last_name,c.group_name FROM sms_grouped_contact_members a INNER JOIN employee_info b ON (a.employee_id=b.employee_id) INNER JOIN sms_grouped_contact c on(a.sgc_id=c.id) WHERE b.company_id='".$company_id."' AND a.sgc_id!='".$group_id."' ");

		return $query->result();
	}



	public function save_selected_gc_emp($save_values){

		$this->db->insert('sms_grouped_contact_members',$save_values);
	}	


	public function save_sent_message($save_sent_message_data){

		$this->db->insert('sms_message_sent',$save_sent_message_data);
	}	
	public function save_outbox_message($save_outbox_message_data){

		$this->db->insert('sms_message_outbox',$save_outbox_message_data);
	}	


	// ========= start sent box
	public function getSentBox($company_id){
		$query=$this->db->query("SELECT max(a.send_to) as send_to,max(a.message) as message,max(a.employee_id) as employee_id,b.first_name,b.last_name FROM sms_message_sent a inner join employee_info b on(a.employee_id=b.employee_id) WHERE b.company_id='".$company_id."' GROUP BY a.employee_id");
		return $query->result();		
	}


	public function getSentToEmployees($employee_id){
		$query=$this->db->query("SELECT * FROM sms_message_sent WHERE employee_id='".$employee_id."' order by date_sent DESC");
		return $query->result();
	}

	// ========= end sent box



	// ========= start out box
	public function getOutBox($company_id){
		$query=$this->db->query("SELECT max(a.message_err_cause) as message_err_cause,max(a.send_to) as send_to,max(a.message) as message,max(a.employee_id) as employee_id,b.first_name,b.last_name FROM sms_message_outbox a inner join employee_info b on(a.employee_id=b.employee_id) WHERE b.company_id='".$company_id."' GROUP BY a.employee_id");
		return $query->result();		
	}

	public function getUnSentToEmployees($employee_id){
		$query=$this->db->query("SELECT * FROM sms_message_outbox WHERE employee_id='".$employee_id."' order by date_sent_tried DESC");
		return $query->result();
	}

	// ========= end out box
	// ========= start message templates

	public function getMessTemp($company_id){
		$query=$this->db->query("SELECT * FROM sms_message_templates WHERE company_id='".$company_id."' ");
		return $query->result();		
	}
	public function save_add_mess_template($data_save_add_mess_template){

		$this->db->insert('sms_message_templates',$data_save_add_mess_template);
	}

	public function messTemplateCont($val){
		$query=$this->db->query("SELECT * FROM sms_message_templates WHERE id='".$val."' ");
		return $query->row();			
	}

	public function save_edit_mess_template($data_save_edit_mess_template,$id){
		$this->db->where(array(
			'id'		=>		$id
		));	
		$this->db->update('sms_message_templates',$data_save_edit_mess_template);
	}


	public function en_dis_mess_temp($id,$content){
		
		$this->data = array(
			'InActive'		=> $content
			);
		$this->db->where(array(
			'id'		=>		$id
		));

		$this->db->update('sms_message_templates',$this->data);
	}
	// ========= end message templates




}