<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Sms extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/sms_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }

        		$this->db_sms = $this->load->database('sms_db', TRUE); // TRUE
		General::variable();	
		
	}
	
	public function index(){	
		
			// user restriction function
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');		
		//$this->load->view('starter',$this->data);
		$this->load->view('app/sms/index',$this->data);
	
	}	
	public function add_network(){	
	
		$this->load->view('app/sms/settings/add_network',$this->data);
	}	
	public function edit_network($val){	

		$this->data['network_info']=$this->sms_model->get_specific_network($val);
		$this->load->view('app/sms/settings/edit_network',$this->data);
	}


	public function update_network(){

		$this->form_validation->set_rules("network","Network","trim|required|callback_validate_edit_network");

		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){
			
			$value = $this->input->post('network');
			$id = $this->input->post('id');

			$this->sms_model->update_network($value);

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('SMS','Network Management','logfile_sms','update '.$id.' to value: '.$value.' ,','UPDATE',$value);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Network:  <strong>".$value."</strong>, is Successfully Updated!</div>");
			// redirect
			$this->session->set_flashdata('onload',"start_action('manage_network')");
			redirect(base_url().'app/sms/index',$this->data);


		}else{

			$this->index();
		}		
	}	
	public function save_network(){

		$this->form_validation->set_rules("network","Network","trim|required|callback_validate_add_network");

		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){
			
			$value = $this->input->post('network');

			$this->sms_model->save_network($value);

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('SMS','Network Management','logfile_sms','add '.$value.': value: '.$value.' ,','INSERT',$value);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Network:  <strong>".$value."</strong>, is Successfully Added!</div>");
			// redirect

			$this->session->set_flashdata('onload',"start_action('manage_network')");
			redirect(base_url().'app/sms/index',$this->data);

		}else{

			$this->index();
		}		
	}	

	public function validate_edit_network(){

		$value = $this->input->post('network');
		$affected = 0;

			if($this->sms_model->validate_edit_network($value)){
		
				$this->form_validation->set_message("validate_edit_network"," Network, <strong>".$value."</strong>, Already Exists.");
				$affected++;
			}
		
		if($affected > 0){
			return false;
		}
		else{
			return true;
		}

	}
	public function validate_add_network(){

		$value = $this->input->post('network');
		$affected = 0;

			if($this->sms_model->validate_add_network($value)){
		
				$this->form_validation->set_message("validate_add_network"," Network, <strong>".$value."</strong>, Already Exists");
				$affected++;
			}
		
		if($affected > 0){
			return false;
		}
		else{
			return true;
		}

	}


	public function start_action($val){

		/*
		-----------------------------------
		start : user role restriction access checking.
		-----------------------------------
		*/
		$editNetwork=$this->session->userdata('editNetwork');
		$delete_network=$this->session->userdata('delete_network');

		$edit_reg_phone=$this->session->userdata('edit_reg_phone');
		$del_reg_phone=$this->session->userdata('del_reg_phone');
		$en_dis_reg_phone=$this->session->userdata('en_dis_reg_phone');

		$system_defined_icons = $this->general_model->system_defined_icons();

		/*
		-----------------------------------
		end : user role restriction access checking.
		-----------------------------------
		*/ 	

	if($val=="manage_network"){
		
		$network_mng = $this->sms_model->get_table_content();

		$tmpl = array('table_open' => '<table class="table table-hover table-striped">');
        $this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('ID','Network','Status','');

		foreach($network_mng as $network_mng){

		$edit = '<i class="'.$editNetwork.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="edit_network('.$network_mng->id.')"></i>';

		$delete = anchor('app/sms/delete_network/'.$network_mng->id,'<i class="'.$delete_network.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete ".$network_mng->network."?')"));

		$this->table->add_row(
			$network_mng->id,
			$network_mng->network,
			$edit.' '.$delete
			);
		}

		$this->data['network_display'] = $this->table->generate();
		$this->load->view('app/sms/settings/manage_network',$this->data);

	}elseif($val=="manage_emp_mob_network"){


		$companyList = $this->general_model->companyList(); 

	      foreach($companyList as $loc){
	          echo "<a onclick='view_company_emp_mob(".$loc->company_id.")' type='button' class='btn btn-default btn-flat col-md-12'><p class='text-left'><strong>".$loc->company_name."</strong></p></a>";
	      }

	}elseif($val=="manage_reg_mob_phone"){
		
		$this->data['RegPhones'] = $this->sms_model->get_registeredPhone();
		$this->load->view('app/sms/settings/registered_phone/regphone_list',$this->data);

	}elseif($val=="manage_reg_employee"){

		$this->load->view('app/sms/settings/registered_employees/comp_list',$this->data);
	}elseif($val=="manage_notif_settings"){

		$this->load->view('app/sms/settings/sms_notification/index',$this->data);
	}elseif($val=="manage_synchronizer_settings"){

		$this->data['sync_setting'] = $this->sms_model->get_synch_setttings();
		$this->load->view('app/sms/settings/synchronizer_settings/index',$this->data);
	}elseif($val=="create_message"){

		$this->load->view('app/sms/web_sms/create_message',$this->data);
	}elseif($val=="manage_contact"){
		
		$this->load->view('app/sms/manage_contacts/index',$this->data);

	}elseif($val=="view_sentbox"){
		
		$this->load->view('app/sms/view_sentbox/index',$this->data);

	}elseif($val=="view_outbox"){
		
		$this->load->view('app/sms/view_outbox/index',$this->data);

	}elseif($val=="message_templates"){

		$this->load->view('app/sms/message_templates/index',$this->data);
	}else{

	}
		

	}


	public function GetMessageTemplate($company_id){

	$this->data['myMessTemp']=$this->sms_model->getMessTemp($company_id);
	$this->load->view('app/sms/web_sms/get_message_templates',$this->data);

	}

	public function en_dis_mess_temp(){
		$id = $this->uri->segment('4');
		$current_stat = $this->uri->segment('5');
		
		if($current_stat=="1"){
			$content="0";
		}else{
			$content="1";
		}
		
		$this->sms_model->en_dis_mess_temp($id,$content);
		if($content=="0"){
			$act="ENABLE";
			$act_name="Enabled";
		}else{
			$act="DISABLE";
			$act_name="Disabled";
		}
		// logfile
		$value = $id;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
		General::system_audit_trail('SMS','SMS Message Templates','logfile_sms',' '.$act.' '.$value.': value:'.$value.' '.$value.' ,',''.$act.'',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Message Template, is Successfully $act_name!</div>");

			$this->session->set_flashdata('onload',"start_action('message_templates')");
			redirect(base_url().'app/sms/index',$this->data);
	}


	public function del_mess_temp(){
			$id = $this->uri->segment("4");
			$value = $this->uri->segment("5");

			$this->db->query("delete from sms_message_templates WHERE id = ".$id);
			// logfile
			
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('SMS','SMS Message Templates','logfile_sms','delete '.$value.': value: '.$value.$id.' ,','DELETE',$value);
				
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Message Templates <strong>".$value."</strong>, is Successfully Deleted!</div>");
		   //}
		
			$this->session->set_flashdata('onload',"start_action('message_templates')");
			redirect(base_url().'app/sms/index',$this->data);
	}



	public function save_edit_mess_template(){
		//$this->load->helper('security');
		$this->form_validation->set_rules("message_key_topic","Message Topic","required|trim|xss_clean");
		$this->form_validation->set_rules("message_template","Message Template","required|trim|xss_clean");

		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){
			$message_key_topic=$this->input->post('message_key_topic');
			$message_template=$this->input->post('message_template');
			$company_id=$this->input->post('company_id');
			$id=$this->input->post('id');

			$value = "$message_key_topic|$message_template|$company_id|$id";

					$date_added=date('Y-m-d H:i:s');
					$data_save_edit_mess_template = array(
					'message_key_topic'			=> $message_key_topic,
					'message_template'			=> $message_template
					);

			$this->sms_model->save_edit_mess_template($data_save_edit_mess_template,$id);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('SMS','SMS Message Templates','logfile_sms','update '.$message_key_topic.' ,','UPDATE',$value);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Message Template is Successfully Updated</div>");
			// redirect

			$this->session->set_flashdata('onload',"start_action('message_templates')");
			redirect(base_url().'app/sms/index',$this->data);

		}else{

			$this->index();
		}		
	}

	public function edit_mess_temp($val,$company_id){
		$this->data['company_id']=$company_id;
		$this->data['mtInfo']=$this->sms_model->messTemplateCont($val);
		$this->load->view('app/sms/message_templates/edit',$this->data);

	}

	public function save_add_mess_template(){
		//$this->load->helper('security');
		$this->form_validation->set_rules("message_key_topic","Message Key Topic","required|trim|xss_clean");
		$this->form_validation->set_rules("message_template","Message Template Content","required|trim|xss_clean");

		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){
			$message_key_topic=$this->input->post('message_key_topic');
			$message_template=$this->input->post('message_template');
			$company_id=$this->input->post('company_id');

			$value = "$message_key_topic|$message_template|$company_id";

					$date_added=date('Y-m-d H:i:s');
					$data_save_add_mess_template = array(
					'message_key_topic'			=> $message_key_topic,
					'message_template'			=> $message_template,
					'company_id'			=> $company_id,
					'date_added'			=> $date_added,
					'InActive'			=> 0
					);

					$this->sms_model->save_add_mess_template($data_save_add_mess_template);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('SMS','SMS Message Templates','logfile_sms','add '.$message_key_topic.' ,','INSERT',$value);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Message Template is Successfully Saved</div>");
			// redirect

			$this->session->set_flashdata('onload',"start_action('message_templates')");
			redirect(base_url().'app/sms/index',$this->data);

		}else{

			$this->index();
		}		
	}


	public function add_mess_temp($company_id){
		$this->data['company_id']=$company_id;
		$this->load->view('app/sms/message_templates/add',$this->data);
	}

	public function getMessTemp($val){
		$this->data['myComp']=$this->general_model->get_company_info($val);
		$this->data['messTemp']=$this->sms_model->getMessTemp($val);
		$this->load->view('app/sms/message_templates/my_message_templates',$this->data);
	}



	public function getOutBox($val){
		$this->data['CompMessages']=$this->sms_model->getOutBox($val);
		$this->data['myComp']=$this->general_model->get_company_info($val);
		$this->load->view('app/sms/view_outbox/outbox_content',$this->data);		
	}



	public function getSentBox($val){
		$this->data['CompMessages']=$this->sms_model->getSentBox($val);
		$this->data['myComp']=$this->general_model->get_company_info($val);
		$this->load->view('app/sms/view_sentbox/sent_content',$this->data);
	}

	public function validate_add_grouped_contact(){

		$group_name = $this->input->post('group_name');
		$company_id = $this->input->post('company_id');
		$affected = 0;

		if($this->sms_model->validate_add_grouped_contact($group_name,$company_id)){
	
			$this->form_validation->set_message("validate_add_grouped_contact"," Group Name, <strong>".$group_name."</strong>, Already Exists");
			$affected++;
		}
		
		if($affected > 0){
			return false;
		}
		else{
			return true;
		}

	}
	public function validate_update_grouped_contact(){

		$group_name = $this->input->post('group_name');
		$company_id = $this->input->post('company_id');
		$id = $this->input->post('id');
		$affected = 0;

		if($this->sms_model->validate_update_grouped_contact($group_name,$company_id,$id)){
	
			$this->form_validation->set_message("validate_update_grouped_contact"," Group Name, <strong>".$group_name."</strong>, Already Exists");
			$affected++;
		}
		
		if($affected > 0){
			return false;
		}
		else{
			return true;
		}

	}


	public function save_update_grouped_contact(){
		//$this->load->helper('security');
		$this->form_validation->set_rules("group_name","Group Name","required|trim|xss_clean|callback_validate_update_grouped_contact");
		$this->form_validation->set_rules("group_desc","Group Description","required|trim|xss_clean");

		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){
			$group_name=$this->input->post('group_name');
			$group_desc=$this->input->post('group_desc');
			$company_id=$this->input->post('company_id');
			$id=$this->input->post('id');

			$value = "$group_name|$group_desc|$company_id|$id";

					$date_added=date('Y-m-d H:i:s');
					$data_save_update_grouped_contact = array(
					'group_name'			=> $group_name,
					'group_desc'			=> $group_desc
					);

			$this->sms_model->save_update_grouped_contact($data_save_update_grouped_contact,$id);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('SMS','SMS Contact Management','logfile_sms','update '.$group_name.' ,','UPDATE',$value);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Grouped Contact Name is Successfully Updated</div>");
			// redirect

			$this->session->set_flashdata('onload',"start_action('manage_contact')");
			redirect(base_url().'app/sms/index',$this->data);

		}else{

			$this->index();
		}		
	}
	public function save_add_grouped_contact(){
		//$this->load->helper('security');
		$this->form_validation->set_rules("group_name","Group Name","required|trim|xss_clean|callback_validate_add_grouped_contact");
		$this->form_validation->set_rules("group_desc","Group Description","required|trim|xss_clean");

		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){
			$group_name=$this->input->post('group_name');
			$group_desc=$this->input->post('group_desc');
			$company_id=$this->input->post('company_id');

			$value = "$group_name|$group_desc|$company_id";

					$date_added=date('Y-m-d H:i:s');
					$data_save_add_grouped_contact = array(
					'group_name'			=> $group_name,
					'group_desc'			=> $group_desc,
					'company_id'			=> $company_id,
					'date_added'			=> $date_added,
					'InActive'			=> 0
					);

					$this->sms_model->save_add_grouped_contact($data_save_add_grouped_contact);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('SMS','SMS Contact Management','logfile_sms','add '.$group_name.' ,','INSERT',$value);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Grouped Contact Name is Successfully Saved</div>");
			// redirect

			$this->session->set_flashdata('onload',"start_action('manage_contact')");
			redirect(base_url().'app/sms/index',$this->data);

		}else{

			$this->index();
		}		
	}

	public function edit_grouped_contact($val,$company_id){
		$this->data['company_id']=$company_id;
		$this->data['gcInfo']=$this->sms_model->GroupContInfo($val,$company_id);
		$this->load->view('app/sms/manage_contacts/edit_grouped_contact',$this->data);

	}

	public function add_grouped_contact($company_id){
		$this->data['company_id']=$company_id;
		$this->load->view('app/sms/manage_contacts/add_grouped_contact',$this->data);
	}
	public function get_comp_grouped_cont($val){
		$this->data['MyGroupeCont']=$this->sms_model->getGroupedContacts($val);
		$this->data['myComp']=$this->general_model->get_company_info($val);
		$this->load->view('app/sms/manage_contacts/view_group',$this->data);
	}


	public function en_dis_grouped_contact(){
		$id = $this->uri->segment('4');
		$current_stat = $this->uri->segment('5');
		$group_name = $this->uri->segment('6');
		if($current_stat=="1"){
			$content="0";
		}else{
			$content="1";
		}
		
		$this->sms_model->en_dis_grouped_contact($id,$content);
		if($content=="0"){
			$act="ENABLE";
			$act_name="Enabled";
		}else{
			$act="DISABLE";
			$act_name="Disabled";
		}
		// logfile
		$value = $id;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
		General::system_audit_trail('SMS','SMS Contact Management','logfile_sms',' '.$act.' '.$value.': value:'.$value.' '.$value.' ,',''.$act.'',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Group Name <strong>".$group_name."</strong>, is Successfully $act_name!</div>");

			$this->session->set_flashdata('onload',"start_action('manage_contact')");
			redirect(base_url().'app/sms/index',$this->data);
	}

	public function enroll_emp_grouped_contact($val){
		
		$group_id=$this->uri->segment('5');
		$company_id=$this->uri->segment('4');
		$comp_div_set=$this->sms_model->checkCompDivSettting($company_id);
		$wDivision=$comp_div_set->wDivision;
		$this->data['wDivision']=$wDivision;
		if($wDivision=="1"){
			$this->data['comp_div']=$this->general_model->get_company_divisions($company_id);
		}else{
			$this->data['comp_div']="";
		}
		$this->data['compLoc']=$this->general_model->get_company_locations($company_id);
		$this->data['compClass']=$this->general_model->get_company_classifications($company_id);
			//echo "HEY";

		$this->data['gcInfo']=$this->sms_model->GroupContInfo($group_id,$company_id);
		$this->load->view('app/sms/manage_contacts/add_emp',$this->data);

	}


	public function del_grouped_contact(){
			$id = $this->uri->segment("4");
			$value = $this->uri->segment("5");

			$this->db->query("delete from sms_grouped_contact WHERE id = ".$id);
			// logfile
			
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('SMS','SMS Contact Management','logfile_sms','delete '.$value.': value: '.$value.$id.' ,','DELETE',$value);
				
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Grouped Contacts, <strong>".$value."</strong>, is Successfully Deleted!</div>");
		   //}
		
			$this->session->set_flashdata('onload',"start_action('manage_contact')");
			redirect(base_url().'app/sms/index',$this->data);
	}



	public function show_contact($val,$company_id){
		$this->data['company_id']=$company_id;

		$comp_details=$this->general_model->get_company_info($company_id);
		$this->data['division_setting']=$comp_details->wDivision;


		if($val=="masterlist"){

			$this->load->view('app/sms/web_sms/show_masterlist_filtering',$this->data);
		}elseif($val=="group"){
			$this->data['ActiveGc']=$this->sms_model->getActiveGroupedContacts($company_id);
			$this->load->view('app/sms/web_sms/group_choices',$this->data);

		}else{

		}

	}

public function send_message(){
	
	$grouped_contact=$this->input->post('grouped_contact');
	$company_id=$this->input->post('company_id');
	$contact_type=$this->input->post('contact_type');
	$division=$this->input->post('division');
	$department=$this->input->post('department');
	$section=$this->input->post('section');
	$sub_section=$this->input->post('sub_section');
	$compose_message=$this->input->post('compose_message');
	$mobile_no=$this->input->post('mobile_no');

	$location=$this->input->post('location');
	$employment=$this->input->post('employment');
	$classification=$this->input->post('classification');
	$location_condition="";
	$employment_condition="";
	$classification_condition="";

	$compose_message=$this->security->xss_clean($compose_message);

if($contact_type=="masterlist"){
	if(!empty($location)){
			foreach ($this->input->post('location') as $key => $location){
					$location_condition.="a.location='".$location."' OR ";
			}
			$location_condition=substr($location_condition, 0,-4);
		}else{
			
		}

		if($location_condition==""){
			$location_condition="a.location='no_data_yet' ";//force 0 result.
		}else{
			$location_condition="AND ($location_condition)";
		}

		if(!empty($employment)){
			foreach ($this->input->post('employment') as $key => $employment){
				$employment_condition.="a.employment='".$employment."' OR ";		
			}
			$employment_condition=substr($employment_condition, 0,-4);
		}else{
			
		}
		if($employment_condition==""){
			$employment_condition="a.employment='no_data_yet' ";//force 0 result.
		}else{
			$employment_condition="AND ($employment_condition)";
		}

		if(!empty($classification)){
			foreach ($this->input->post('classification') as $key => $classification){
				$classification_condition.="a.classification='".$classification."' OR ";
			}
			$classification_condition=substr($classification_condition, 0,-4);
		}else{
			
		}
		if($classification_condition==""){
			$classification_condition="a.classification='no_data_yet' ";//force 0 result.
		}else{
			$classification_condition="AND ($classification_condition)";
		}

		if($division=="ignore_me" OR $division=="All"){
			$division_condition="";
		}else{
			if($division=="no_data_yet"){
				$division_condition="AND a.division_id='no_data_yet' ";//no setup for division list yet. force a 0 (zero) RESULT on query.
			}else{
				$division_condition="AND a.division_id='".$division."' ";		
			}
		}

		if($department=="ignore_me" OR $department=="All"){
			$department_condition="";
		}else{
			if($department=="no_data_yet"){
				$department_condition="AND a.department='no_data_yet' ";//no setup for department list yet. force a 0 (zero) RESULT on query.
			}else{
				$department_condition="AND a.department='".$department."' ";		
			}
		}

		if($section=="ignore_me" OR $section=="All"){
			$section_condition="";
		}else{
			if($section=="no_data_yet"){
				$section_condition="AND a.section='no_data_yet' ";//no setup for section list yet. force a 0 (zero) RESULT on query.
			}else{
				$section_condition="AND a.section='".$section."' ";		
			}
		}

		if($sub_section=="ignore_me" OR $sub_section=="All"){
			$sub_section_condition="";
		}else{
			if($sub_section=="no_data_yet"){
				$sub_section_condition="AND a.subsection='no_data_yet' ";//no setup for sub_section list yet. force a 0 (zero) RESULT on query.
			}else{
				$sub_section_condition="AND a.subsection='".$sub_section."' ";		
			}
		}


		$employees=$this->sms_model->get_filtered_masterlist($company_id,$location_condition,$employment_condition,$classification_condition,$division_condition,$department_condition,$section_condition,$sub_section_condition);

}else{

		$employees=$this->sms_model->get_group_member($grouped_contact);

}
	



$count_success_sent=0;
$count_failed_sent=0;
$value="";
$success_value_alert="";
$failed_value_alert="";
		if(!empty($employees)){
			foreach($employees as $e){
$naming="mobile_no_err_".$e->employee_id;
$$naming="";
			$mobile_1=$e->mobile_1;
			$mobile_2=$e->mobile_2;
			$mobile_3=$e->mobile_3;
			$mobile_4=$e->mobile_4;

			$mobile_1_sms_network=$e->mobile_1_sms_network;
			$mobile_2_sms_network=$e->mobile_2_sms_network;
			$mobile_3_sms_network=$e->mobile_3_sms_network;
			$mobile_4_sms_network=$e->mobile_4_sms_network;

		if($mobile_no=="mobile_1"){
			$send_to=$mobile_1;
			$modem_id=$mobile_1_sms_network;
		}elseif($mobile_no=="mobile_2"){
			$send_to=$mobile_2;
			$modem_id=$mobile_2_sms_network;	
		}elseif($mobile_no=="mobile_3"){
			$send_to=$mobile_3;
			$modem_id=$mobile_3_sms_network;
		}elseif($mobile_no=="mobile_4"){
			$send_to=$mobile_4;
			$modem_id=$mobile_4_sms_network;	
		}else{

		}

		$fisrt_2_digit=substr($send_to, 0,2);
		$send_to="+".$send_to;	

		if($fisrt_2_digit!="63"){
			
			$$naming="incorrect mobile no format";
		}else{
			$check_mob_length=strlen($send_to);
			if($check_mob_length=="13"){

			}else{
				
				$$naming="incorrect mobile no format";
			}
		}
										
	// ========= start insert to sms gateway

	if($compose_message>0){// from messages templates
		$MessTemplate=$this->sms_model->messTemplateCont($compose_message);
			if(!empty($MessTemplate)){
				$compose_message=$MessTemplate->message_template;
			}else{

			}
	}else{

	}

	$compose_message=str_replace("<br/>","\n",$compose_message);//replace html breakline to text breakline
	$message=$compose_message."\n-HRWeb ";
	$date_sent=date('Y-m-d H:i:s');


		if(($modem_id)AND($send_to)AND($$naming=="")){
			$count_success_sent++;
			$value.=$e->last_name.' '.$e->first_name.'/'.$send_to.'/'.$message;
			$success_value_alert.=$e->last_name.' '.$e->first_name."/";
			$this->data = array(
					'message'				=>		$message,
					'destination'			=>		$send_to,//'+639359114151'
					'sent_status'			=>		'P',
					'modem_id'				=>		$modem_id,
					'msg_type'				=>		'T',
					'target_modem'			=>		$modem_id
			);
			$this->db_sms->insert('outbox',$this->data);
			

			$save_sent_message_data = array(
				'employee_id'	=>	$e->employee_id,
				'send_to'	=>	$send_to,
				'message'	=>	$message,
				'date_sent'		=>	$date_sent
				);

			$this->sms_model->save_sent_message($save_sent_message_data);


		}else{//failed to meet requirements to send the message.
			$count_failed_sent++;
			$failed_value_alert.=$e->last_name.' '.$e->first_name."/";
			$save_outbox_message_data = array(
				'employee_id'	=>	$e->employee_id,
				'send_to'	=>	$send_to,
				'message'	=>	$message,
				'message_err_cause'	=>	$$naming,
				'date_sent_tried'		=>	$date_sent
				);

			$this->sms_model->save_outbox_message($save_outbox_message_data);


		}

	}//end foreach employee


	}else{

	}


			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('SMS','SMS Create Message','logfile_sms','create_message '.$value.' ,','INSERT',$value);
			
if($count_success_sent>0){
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Message To <strong>".$success_value_alert."</strong>, is Successfully Send!</div>");
}else{
	if($count_failed_sent>0){//failed to meet requirement to send a message.
			$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Message To <strong>".$failed_value_alert."</strong>, Failed to Send!</div>");


	}else{// no employee found.
			$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> No Employee Found</div>");
	}
}


		   
		
			$this->session->set_flashdata('onload',"start_action('create_message')");
			redirect(base_url().'app/sms/index',$this->data);



// echo "
// company id : $company_id <br>
// contact type: $contact_type <br>
// div : $division <br>
// dep $department <br>
// sec $section <br>
// sub sec : $sub_section <br>
// location : 
// employment :
// classification :

// ";


}


	public function show_div_dept(){
		$company_id=$this->uri->segment("4");
		$division_id=$this->uri->segment("5");
		$this->data['get_div_dept'] = $this->general_model->get_company_division_departments($company_id,$division_id);

		$this->load->view('app/sms/web_sms/show_div_dept',$this->data);
	}	
	public function show_section(){
		$dept_id=$this->uri->segment("4");
		$this->data['get_section'] = $this->general_model->getSec($dept_id);

		$this->load->view('app/sms/web_sms/show_section',$this->data);
	}

	public function show_sub_section(){
		$section_id=$this->uri->segment("4");
		$section=$this->uri->segment("4");

		$this->data['check_section'] = $this->general_model->get_the_section($section);
		$this->data['get_sub_section'] = $this->general_model->get_sec_subsection($section_id);
		$this->load->view('app/sms/web_sms/show_sub_section',$this->data);
	}

	public function save_sms_notif_setting(){

			// 
		$company_id=$this->input->post('company_id');
		$my_setting=$this->sms_model->sms_notif_setting($company_id);

		$query=$this->db->query("delete from sms_notification_settings where company_id='".$company_id."' ");	
		$date_registered=date('Y-m-d H:i:s');
		foreach($my_setting as $sms_set){
				$sms_notif_setting=$this->input->post('sms_notif_value_'.$sms_set->id);

	
				$value=$sms_notif_setting;

				$notif_setting_values = array(
				'company_id'				=> $company_id,
				'sms_notif_id'				=> $sms_set->id,
				'setting'					=> $sms_notif_setting,
				'date_registered'			=> $date_registered
				);				

				$this->sms_model->save_sms_notif_setting($notif_setting_values);			
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
		General::system_audit_trail('SMS','SMS Notification Settings','logfile_sms',' '.$company_id.' '.$sms_set->id.': value:'.$sms_notif_setting.'',''.$company_id.'',$value);
				
		}

$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Successfully Updated!</div>");


			$this->session->set_flashdata('onload',"start_action('manage_notif_settings')");
			redirect(base_url().'app/sms/index',$this->data);	

	}

	public function check_sms_notif_setting(){
		$company_id=$this->uri->segment('4');
		$this->data['myCinFo']=$this->general_model->get_company_info($company_id);
		$this->data['my_setting']=$this->sms_model->sms_notif_setting($company_id);
		$this->load->view('app/sms/settings/sms_notification/notif_setting',$this->data);
	}


	public function check_enrolled_emp(){
		$company_id=$this->uri->segment('4');
		$this->data['RegPhonechoices']=$this->sms_model->check_if_phone_exist($company_id);
		$this->data['EnrolledEmp']=$this->sms_model->check_enrolled_emp($company_id);
		$this->load->view('app/sms/settings/registered_employees/comp_enrolled_emp',$this->data);
	}

	public function save_emp_reg_phone(){
		$mass_enroll=$this->input->post('mass_enroll');
		$company_id=$this->input->post('company_id');
		$RegPhonechoices=$this->sms_model->check_if_phone_exist($company_id);
		$EnrolledEmp=$this->sms_model->check_enrolled_emp($company_id);

		$date_registered=date('Y-m-d H:i:s');
if($mass_enroll!=""){

	if($mass_enroll=="enroll_all_emp_to_all_phone"){
						foreach($EnrolledEmp as $emp){
							$employee_id=$emp->employee_id;
							foreach($RegPhonechoices as $p){

							$query=$this->db->query("delete from sms_registered_emp_phone_designation where employee_id='".$employee_id."' and mobile_phone_id='".$p->id."'  ");		

								$emp_phones = array(
									'employee_id'				=> $employee_id,
									'mobile_phone_id'			=> $p->id,
									'date_registered'			=> $date_registered
								);				

								$this->sms_model->enroll_emp_phone($emp_phones);

							}
						}


	}elseif($mass_enroll=="enroll_all_emp_to_spec_phone"){
			foreach($EnrolledEmp as $emp){
				$employee_id=$emp->employee_id;

				foreach($RegPhonechoices as $rpc){
					$query=$this->db->query("delete from sms_registered_emp_phone_designation where employee_id='".$employee_id."' and mobile_phone_id='".$rpc->id."'  ");	
				}
				foreach($this->input->post('rp') as $p){
					
					$emp_phones = array(
						'employee_id'				=> $employee_id,
						'mobile_phone_id'			=> $p,
						'date_registered'			=> $date_registered
					);				


					$this->sms_model->enroll_emp_phone($emp_phones);


				}
			}		

	}else{// do nothing

	}

}else{
			foreach($EnrolledEmp as $emp){
				$employee_id=$emp->employee_id;


				foreach($RegPhonechoices as $p){

				$phone_stat=$this->input->post('phone_choice_'. $employee_id.'_'.$p->id);
				$query=$this->db->query("delete from sms_registered_emp_phone_designation where employee_id='".$employee_id."' and mobile_phone_id='".$p->id."'  ");				

				if($phone_stat!=""){
					//echo $eemployee_id." | $phone_stat <br>";
					$emp_phones = array(
						'employee_id'				=> $employee_id,
						'mobile_phone_id'			=> $p->id,
						'date_registered'			=> $date_registered
					);				


					$this->sms_model->enroll_emp_phone($emp_phones);

				}else{

				}


				}
			}
}



			$this->session->set_flashdata('onload',"start_action('manage_reg_employee')");
			redirect(base_url().'app/sms/index',$this->data);	


	}


	public function enable_disable_reg_phone(){
		$id = $this->uri->segment('4');
		$current_stat = $this->uri->segment('5');
		if($current_stat=="1"){
			$content="0";
		}else{
			$content="1";
		}
		
		$this->sms_model->enable_disable_regphone($id,$content);
		if($content=="0"){
			$act="ENABLE";
			$act_name="Enabled";
		}else{
			$act="DISABLE";
			$act_name="Disabled";
		}
		// logfile
		$value = $id;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
		General::system_audit_trail('SMS','SMS Registered Mobile Phones Management','logfile_sms',' '.$act.' '.$value.': value:'.$value.' '.$value.' ,',''.$act.'',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Company, <strong>".$value."</strong>, is Successfully $act_name!</div>");

			$this->session->set_flashdata('onload',"start_action('manage_reg_mob_phone')");
			redirect(base_url().'app/sms/index',$this->data);
	}

public function filter_employees(){
	$company_id=$this->input->post('company_id');
	$division=$this->input->post('division');
	$department=$this->input->post('department');
	$section=$this->input->post('section');
	$sub_section=$this->input->post('sub_section');
	// echo below for checking.

	// echo 
	// "
	// division: $division <br>
	// department: $department <br>
	// section: $section <br>
	// sub-section $sub_section <br>
	// ";
	//no_data_yet


if($division=="ignore_me" OR $division=="All"){
	$division_condition="";
}else{
	if($division=="no_data_yet"){
		$division_condition="AND division_id='no_data_yet' ";//no setup for division list yet. force a 0 (zero) RESULT on query.
	}else{
		$division_condition="AND division_id='".$division."' ";		
	}
}

if($department=="ignore_me" OR $department=="All"){
	$department_condition="";
}else{
	if($department=="no_data_yet"){
		$department_condition="AND department='no_data_yet' ";//no setup for department list yet. force a 0 (zero) RESULT on query.
	}else{
		$department_condition="AND department='".$department."' ";		
	}
}

if($section=="ignore_me" OR $section=="All"){
	$section_condition="";
}else{
	if($section=="no_data_yet"){
		$section_condition="AND section='no_data_yet' ";//no setup for section list yet. force a 0 (zero) RESULT on query.
	}else{
		$section_condition="AND section='".$section."' ";		
	}
}

if($sub_section=="ignore_me" OR $sub_section=="All"){
	$sub_section_condition="";
}else{
	if($sub_section=="no_data_yet"){
		$sub_section_condition="AND subsection='no_data_yet' ";//no setup for sub_section list yet. force a 0 (zero) RESULT on query.
	}else{
		$sub_section_condition="AND subsection='".$sub_section."' ";		
	}
}

//== start location checking
$location_condition="";

if($this->input->post('location')){
	foreach ($this->input->post('location') as $key => $location){
		$location_condition.="location='".$location."'  OR ";
		
	}
$location_condition=substr($location_condition, 0,-4);	

}else{

}

if($location_condition!=""){
	$location_condition="AND ($location_condition)";
}else{
	$location_condition="AND location='no_data_yet' ";//no selected locations: force no result on query
}

//== end location checking


//== start classification checking
$classification_condition="";

if($this->input->post('classification')){
	foreach ($this->input->post('classification') as $key => $classification){
		$classification_condition.="classification='".$classification."'  OR ";
		
	}
$classification_condition=substr($classification_condition, 0,-4);	

}else{

}

if($classification_condition!=""){
	$classification_condition="AND ($classification_condition)";
}else{
	$classification_condition="AND classification='no_data_yet' ";//no selected classification: force no result on query
}

//== end classification checking

//== start employment checking
$employment_condition="";

if($this->input->post('employment')){
	foreach ($this->input->post('employment') as $key => $employment){
		$employment_condition.="employment='".$employment."'  OR ";
		
	}
$employment_condition=substr($employment_condition, 0,-4);	

}else{

}

if($employment_condition!=""){
	$employment_condition="AND ($employment_condition)";
}else{
	$employment_condition="AND employment='no_data_yet' ";//no selected classification: force no result on query
}

//== end employment checking



$this->data['employeeList']=$this->sms_model->filter_employees($company_id,$division_condition,$department_condition,$section_condition,$sub_section_condition,$location_condition,$classification_condition,$employment_condition);
$this->data['already_enrolled_list']=$this->sms_model->check_enrolled_emp($company_id);

	$this->data['onload'] = $this->session->flashdata('onload');
	$this->data['message'] = $this->session->flashdata('message');	

	$this->load->view('app/sms/settings/registered_employees/emp_choices',$this->data);
}
	

	public function un_enrol_employee(){

			foreach ($this->input->post('un_employee_id') as $key => $employee_id)
			{	
				$date_reg=date('Y-m-d H:i:s');
				$query=$this->db->query("delete from sms_registered_emp where employee_id='".$employee_id."' ");
	
			}

			$this->session->set_flashdata('onload',"start_action('manage_reg_employee')");
			redirect(base_url().'app/sms/index',$this->data);	


	}
	public function enrol_employee(){

		foreach ($this->input->post('employee_id') as $key => $employee_id)
		{	
			$date_reg=date('Y-m-d H:i:s');

			$save_values = array(
				'employee_id'		=> $employee_id,
				'date_registered'			=> $date_reg
			);				

			$this->sms_model->save_selected_emp($save_values);
		}


		$this->session->set_flashdata('onload',"start_action('manage_reg_employee')");
		redirect(base_url().'app/sms/index',$this->data);

	}

	public function add_reg_emp(){
		$company_id=$this->uri->segment('4');
		$comp_div_set=$this->sms_model->checkCompDivSettting($company_id);
		$wDivision=$comp_div_set->wDivision;
		$this->data['wDivision']=$wDivision;
		if($wDivision=="1"){
			$this->data['comp_div']=$this->general_model->get_company_divisions($company_id);
		}else{
			$this->data['comp_div']="";
		}
		$this->data['compLoc']=$this->general_model->get_company_locations($company_id);
		$this->data['compClass']=$this->general_model->get_company_classifications($company_id);
		$this->load->view('app/sms/settings/registered_employees/add_emp',$this->data);
	}

	public function fetch_div_dep(){
		$company_id=$this->uri->segment('5');
		$division_id=$this->uri->segment('4');

		$this->data['comp_div_dept']=$this->general_model->get_company_division_departments($company_id,$division_id);
		$this->load->view('app/sms/settings/registered_employees/div_depList',$this->data);
	}

	public function fetch_dep_sect(){
		$company_id=$this->uri->segment('5');
		$dept_id=$this->uri->segment('4');

		$this->data['comp_dept_sect']=$this->general_model->getSec($dept_id);
		$this->load->view('app/sms/settings/registered_employees/dep_secList',$this->data);
	}
	public function fetch_subsection(){
		$company_id=$this->uri->segment('5');
		$section_id=$this->uri->segment('4');

		$verify_mysubsec=$this->sms_model->check_sec_subsect($section_id);
		if(!empty($verify_mysubsec)){

				if($verify_mysubsec->wSubsection=="1"){

					$this->data['comp_subsection']=$this->general_model->get_sec_subsection($section_id);
				}else{
					$this->data['comp_subsection']="";
				}
				
				$this->data['wSubsection']=$verify_mysubsec->wSubsection;

		}else{
					$this->data['comp_subsection']="";
					$this->data['wSubsection']="";
		}


		$this->load->view('app/sms/settings/registered_employees/subsection_list',$this->data);
	}


	public function add_reg_phone(){
		$this->load->view('app/sms/settings/registered_phone/add_phone',$this->data);
	}

	public function save_reg_phone(){
		//$this->load->helper('security');
		$this->form_validation->set_rules("app_mobile_no","Mobile No","required|trim|xss_clean");
		$this->form_validation->set_rules("mobile_type","Mobile Type","required|trim|xss_clean");

		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){
			
			$value = $this->input->post('app_mobile_no');

			foreach ($this->input->post('company') as $key => $cid){

				$check_reg_mob=$this->sms_model->validate_add_reg_phone($cid);
				if(!empty($check_reg_mob)){

			$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Phone:  <strong>".$value."</strong>,Already Exist to Company ID: $cid!</div>");
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('SMS','SMS Registered Mobile Phones Management','logfile_sms','add FAILED as ALREADY EXIST'.$value.': value: '.$value.$cid.' ,','INSERT',$value);

				}else{

					$date_registered=date('Y-m-d H:i:s');
					$data_reg_phones = array(
					'company_id'			=> $cid,
					'app_mobile_no'			=> $this->input->post('app_mobile_no'),
					'mobile_type'			=> $this->input->post('mobile_type'),
					'date_registered'		=> $date_registered,
					'InActive'		=> 0
					);

					$this->sms_model->save_reg_phone($data_reg_phones);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('SMS','SMS Registered Mobile Phones Management','logfile_sms','add '.$value.': value: '.$value.$cid.' ,','INSERT',$value);

				}

			}

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Phone:  <strong>".$value."</strong>, is Successfully Registered!</div>");
			// redirect

			$this->session->set_flashdata('onload',"start_action('manage_reg_mob_phone')");
			redirect(base_url().'app/sms/index',$this->data);

		}else{

			$this->index();
		}		
	}	
	public function edit_reg_phone($val){	

		$regphone_info=$this->sms_model->get_specific_regphone($val);
		
		$this->data['compLoc']=$this->general_model->get_company_locations($regphone_info->company_id);
		$this->data['regphone_info']=$this->sms_model->get_specific_regphone($val);
		$this->load->view('app/sms/settings/registered_phone/edit_regphone',$this->data);
	}	

	public function update_reg_phone(){
		$this->form_validation->set_rules("app_mobile_no","Mobile No","required|trim|xss_clean|callback_validate_edit_reg_phone");
		$this->form_validation->set_rules("mobile_type","Mobile Type","required|trim|xss_clean");

		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){
			
			$value = $this->input->post('app_mobile_no');
			$id = $this->input->post('id');
			$mobile_type = $this->input->post('mobile_type');


			//phone_location
			$this->db->query("delete from sms_phone_location WHERE phone_id = ".$id);

			foreach ($this->input->post('phone_location') as $key => $loc_id){

					$date_registered=date('Y-m-d H:i:s');

					$update_loc_reg_phones = array(
					'location_id'			=> $loc_id,
					'phone_id'				=> $id,
					'date_registered'		=> $date_registered
					);

					$this->sms_model->update_loc_reg_phones($update_loc_reg_phones);

			}

			$this->sms_model->update_reg_phone($id,$value,$mobile_type);

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('SMS','SMS Registered Mobile Phones Management','logfile_sms','update '.$value.': value: '.$value.$id.' ,','UPDATE',$value);


			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Mobile Phone Details:  <strong>".$value."</strong>, is Successfully Updated!</div>");
			// redirect
			$this->session->set_flashdata('onload',"start_action('manage_reg_mob_phone')");
			redirect(base_url().'app/sms/index',$this->data);


		}else{
			$this->session->set_flashdata('onload',"start_action('manage_reg_mob_phone')");
			$this->index();
		}		
	}
	public function validate_edit_reg_phone(){

		$value = $this->input->post('app_mobile_no');
		$affected = 0;

			if($this->sms_model->validate_edit_reg_phone($value)){
		
				$this->form_validation->set_message("validate_edit_reg_phone"," Mobile No, <strong>".$value."</strong>, Already Exists.");
				$affected++;
			}
		
		if($affected > 0){
			return false;
		}
		else{
			return true;
		}

	}



	public function view_company_emp_mob($val){
		//$emp_mob = $this->sms_model->get_masterlist_mobile($val);
		$this->data['emp_mob'] = $this->sms_model->get_masterlist_mobile($val);
		$this->load->view('app/sms/settings/manage_emp_mobile',$this->data);
	}


	public function update_emp_mobile(){

		// foreach ($this->input->post('employee_id') as $key => $employee_id)
		// {				

		// 	$mmm=$this->input->post('aaa_'.$employee_id);
		// 	$aaa=$this->input->post('aaa_201613');
	

		// 	echo "$employee_id | aaa_$employee_id <br>";

		// 	// $query=$this->db->query("update employee_info set mobile_1='".$mobile_1."',mobile_2='".$mobile_2."',mobile_3='".$mobile_3."',mobile_4='".$mobile_4."',  where employee_id='".$employee_id."' ");
		// }

	}



	public function delete_network(){

		$id = $this->uri->segment("4");
		$val = $this->uri->segment("4");

		$isemployee_exist = $this->sms_model->verify_employee_network($id);
		$network_info = $this->sms_model->get_specific_network($val);
		$value = $network_info->network;

		if(!empty($isemployee_exist)){
			$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Network, <strong>".$value."</strong>, is not allowed to be deleted as there is an existing employee assigned on it!</div>");
			
		}else{
			$this->db->query("delete from sms_network WHERE id = ".$id);
			// logfile
			
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('SMS','Network Management','logfile_sms','delete '.$id.': value: '.$value.' ,','DELETE',$value);
				
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Subsection, <strong>".$value."</strong>, is Successfully Deleted!</div>");
		}
		
		$this->session->set_flashdata('onload',"start_action('manage_network')");
		redirect(base_url().'app/sms/index',$this->data);
	}


	public function delete_reg_phone(){

		$id = $this->uri->segment("4");
		$value = $this->uri->segment("5");

		//validate once sample sms is already setup.


			$this->db->query("delete from sms_registered_mobile_phone WHERE id = ".$id);
			// logfile
			
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('SMS','SMS Registered Mobile Phones Management','logfile_sms','delete '.$value.': value: '.$value.$id.' ,','DELETE',$value);
				
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Mobile Phone, <strong>".$value."</strong>, is Successfully Deleted!</div>");
		   //}
		

			$this->session->set_flashdata('onload',"start_action('manage_reg_mob_phone')");
			redirect(base_url().'app/sms/index',$this->data);
	}


	public function save_sync_setting(){
		//$this->load->helper('security');
		$this->form_validation->set_rules("table_name","Table Name","required|trim|xss_clean");
		$this->form_validation->set_rules("in_code","IN Code","required|trim|xss_clean");
		$this->form_validation->set_rules("out_code","Out Code","required|trim|xss_clean");

		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){
			$table_name=$this->input->post('table_name');
			$timer=$this->input->post('timer');
			$var_meaning_1st=$this->input->post('var_meaning_1st');
			$var_meaning_2nd=$this->input->post('var_meaning_2nd');
			$var_meaning_3rd=$this->input->post('var_meaning_3rd');
			$var_meaning_4th=$this->input->post('var_meaning_4th');
			$var_meaning_5th=$this->input->post('var_meaning_5th');
			$in_code=$this->input->post('in_code');
			$out_code=$this->input->post('out_code');
			$value = "$table_name|$timer|$var_meaning_1st|$var_meaning_2nd|$var_meaning_3rd|$var_meaning_4th|$var_meaning_5th|$in_code|$out_code";

					$date_registered=date('Y-m-d H:i:s');
					$data_sync_setting = array(
					'table_name'			=> $table_name,
					'timer'					=> $timer,
					'var_meaning_1st'		=> $var_meaning_1st,
					'var_meaning_2nd'		=> $var_meaning_2nd,
					'var_meaning_3rd'		=> $var_meaning_3rd,
					'var_meaning_4th'		=> $var_meaning_4th,
					'var_meaning_5th'		=> $var_meaning_5th,
					'in_code'				=> $in_code,
					'out_code'				=> $out_code
					);

					$this->sms_model->save_sync_setting($data_sync_setting);
	
				
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('SMS','SMS Synchronizer Settings','logfile_sms','update '.$value.': value: '.$value.' ,','UPDATE',$value);


			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Synchroniser Settings is Successfully Saved</div>");
			// redirect

			$this->session->set_flashdata('onload',"start_action('manage_synchronizer_settings')");
			redirect(base_url().'app/sms/index',$this->data);

		}else{

			$this->index();
		}		
	}	



public function filter_for_grouped_employees(){
	$group_id=$this->input->post('group_id');
	$company_id=$this->input->post('company_id');
	$division=$this->input->post('division');
	$department=$this->input->post('department');
	$section=$this->input->post('section');
	$sub_section=$this->input->post('sub_section');
	// echo below for checking.

	// echo 
	// "
	// division: $division <br>
	// department: $department <br>
	// section: $section <br>
	// sub-section $sub_section <br>
	// ";
	//no_data_yet
$this->data['gcInfo']=$this->sms_model->GroupContInfo($group_id,$company_id);

if($division=="ignore_me" OR $division=="All"){
	$division_condition="";
}else{
	if($division=="no_data_yet"){
		$division_condition="AND division_id='no_data_yet' ";//no setup for division list yet. force a 0 (zero) RESULT on query.
	}else{
		$division_condition="AND division_id='".$division."' ";		
	}
}

if($department=="ignore_me" OR $department=="All"){
	$department_condition="";
}else{
	if($department=="no_data_yet"){
		$department_condition="AND department='no_data_yet' ";//no setup for department list yet. force a 0 (zero) RESULT on query.
	}else{
		$department_condition="AND department='".$department."' ";		
	}
}

if($section=="ignore_me" OR $section=="All"){
	$section_condition="";
}else{
	if($section=="no_data_yet"){
		$section_condition="AND section='no_data_yet' ";//no setup for section list yet. force a 0 (zero) RESULT on query.
	}else{
		$section_condition="AND section='".$section."' ";		
	}
}

if($sub_section=="ignore_me" OR $sub_section=="All"){
	$sub_section_condition="";
}else{
	if($sub_section=="no_data_yet"){
		$sub_section_condition="AND subsection='no_data_yet' ";//no setup for sub_section list yet. force a 0 (zero) RESULT on query.
	}else{
		$sub_section_condition="AND subsection='".$sub_section."' ";		
	}
}

//== start location checking
		$location_condition="";

		if($this->input->post('location')){
			foreach ($this->input->post('location') as $key => $location){
				$location_condition.="location='".$location."'  OR ";
				
			}
		$location_condition=substr($location_condition, 0,-4);	

		}else{

		}

		if($location_condition!=""){
			$location_condition="AND ($location_condition)";
		}else{
			$location_condition="AND location='no_data_yet' ";//no selected locations: force no result on query
		}

//== end location checking


//== start classification checking
		$classification_condition="";

		if($this->input->post('classification')){
			foreach ($this->input->post('classification') as $key => $classification){
				$classification_condition.="classification='".$classification."'  OR ";
				
			}
		$classification_condition=substr($classification_condition, 0,-4);	

		}else{

		}

		if($classification_condition!=""){
			$classification_condition="AND ($classification_condition)";
		}else{
			$classification_condition="AND classification='no_data_yet' ";//no selected classification: force no result on query
		}

//== end classification checking

//== start employment checking
		$employment_condition="";

		if($this->input->post('employment')){
			foreach ($this->input->post('employment') as $key => $employment){
				$employment_condition.="employment='".$employment."'  OR ";
				
			}
		$employment_condition=substr($employment_condition, 0,-4);	

		}else{

		}

		if($employment_condition!=""){
			$employment_condition="AND ($employment_condition)";
		}else{
			$employment_condition="AND employment='no_data_yet' ";//no selected classification: force no result on query
		}

//== end employment checking

		$this->data['employeeList']=$this->sms_model->filter_for_grouped_employees($company_id,$division_condition,$department_condition,$section_condition,$sub_section_condition,$location_condition,$classification_condition,$employment_condition,$group_id);

		$this->data['already_enrolled_list']=$this->sms_model->check_enrolled_emp_for_grouped_contact($company_id,$group_id);
		$this->data['all_grouped_enrolled']=$this->sms_model->check_other_grouped_enrolled($company_id,$group_id);

		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		$this->data['group_id']=$group_id;


		$this->load->view('app/sms/manage_contacts/emp_choices',$this->data);
}


	public function enrol_employee_grouped_contact(){
		$sgc_id=$this->input->post('group_id');
		foreach ($this->input->post('employee_id') as $key => $employee_id)
		{	
			$date_reg=date('Y-m-d H:i:s');

		$save_values = array(
			'sgc_id'				=> $sgc_id,
			'employee_id'			=> $employee_id,
			'date_added'			=> $date_reg
		);				

		$this->sms_model->save_selected_gc_emp($save_values);

		$value="$sgc_id|$employee_id";
		/*
		--------------audit trail composition--------------
		(module,module dropdown,logfiletable,detailed action,action type,key value)
		--------------audit trail composition--------------
		*/
		General::system_audit_trail('SMS','SMS Contact Management','logfile_sms','INSERT '.$value.': value: '.$value.' ,','INSERT',$value);


		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Successfully Saved</div>");

		}


		$this->session->set_flashdata('onload',"start_action('manage_contacts')");
		redirect(base_url().'app/sms/index',$this->data);
	}


	public function un_enrol_employee_grouped_contact(){

			foreach ($this->input->post('un_employee_id') as $key => $employee_id)
			{	
				$date_reg=date('Y-m-d H:i:s');
				$query=$this->db->query("delete from sms_grouped_contact_members where employee_id='".$employee_id."' ");
	
			}

			$this->session->set_flashdata('onload',"start_action('manage_contacts')");
			redirect(base_url().'app/sms/index',$this->data);	


	}


}//end controller



