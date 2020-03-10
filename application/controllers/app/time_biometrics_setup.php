<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class time_biometrics_setup extends General{

	public function __construct(){
		parent::__construct();
		//$DB2 = $this->load->database('biometrics', TRUE);

		$this->load->model("app/time_payroll_period_model");
		$this->load->model("app/time_biometrics_setup_model");
		$this->load->model("app/time_manual_attendance_model");
		$this->load->model("auto_sync_logs/auto_sync_logs_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();		
	}
	public function index(){	
	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
			
		$this->load->view('app/time/biometrics_setup/index',$this->data);
 	}	
	public function view_option(){	
			
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
			
		$this->load->view('app/time/biometrics_setup/view_option',$this->data);
 	}	

	public function brandmng(){	


		$this->data['brandmng'] = $this->time_biometrics_setup_model->brandmng();
	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
			
		$this->load->view('app/time/biometrics_setup/brandmng',$this->data);
 	}	
	public function edit_brand(){	
		$bio_categ_id=$this->uri->segment("4");

		$selected_brand= $this->time_biometrics_setup_model->selected_brand($bio_categ_id);
		if(!empty($selected_brand)){
			$this->data['s_brand_name']=$selected_brand->brand_name;
		}else{
			$this->data['s_brand_name']="";
		}
		$this->load->view('app/time/biometrics_setup/edit_brand',$this->data);
 	}	


	public function add_brand(){
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		$this->form_validation->set_rules("brand_name","Brand Name","trim|required|callback_validate_brand_name");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){
	
		
			$this->time_biometrics_setup_model->save_brand();
			// logfile
			$value = $this->input->post('brand_name');

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Biometrics Setup','logfile_time_biosetup','add biometrics brand: '.$value.'','INSERT',$value);

			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Biometrics Brand <strong>".$value."</strong>, is Successfully Added!</div>");

			$this->session->set_flashdata('onload',"brandmng()");
			redirect(base_url().'app/time_biometrics_setup/index',$this->data);
			//$this->load->view('app/time/biometrics_setup/brandmng',$this->data);

		}else{
			$this->session->set_flashdata('onload',"brandmng()");
			$this->index();
		}		
	}
	public function save_brand(){
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		$this->form_validation->set_rules("brand_name","Brand Name","trim|required|callback_validate_edit_brand_name");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){
	
		
			$this->time_biometrics_setup_model->edit_brand();
			// logfile
			$value = $this->input->post('brand_name');
			$bio_categ_id=$this->input->post("bio_categ_id");
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Biometrics Setup','logfile_time_biosetup','update biometrics brand id: '.$bio_categ_id.'','UPDATE',$bio_categ_id);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Biometrics Brand <strong>".$value."</strong>, is Successfully Updated!</div>");

			$this->session->set_flashdata('onload',"brandmng()");
			redirect(base_url().'app/time_biometrics_setup/index',$this->data);

		}else{
			$this->session->set_flashdata('onload',"brandmng()");
			$this->index();
		}		
	}

	public function delete_brand(){
		$bio_categ_id=$this->uri->segment("4");

		$query=$this->db->query("delete from `biometrics_brand` where bio_categ_id='".$bio_categ_id."'");

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Biometrics Setup','logfile_time_biosetup','delete biometrics brand id: '.$bio_categ_id.'','DELETE',$bio_categ_id);


		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Successfully Deleted!</div>");


		$this->session->set_flashdata('onload',"brandmng()");
		redirect(base_url().'app/time_biometrics_setup/index',$this->data);

	}
	public function brand_status_action(){
		$bio_categ_id=$this->uri->segment("4");
		$bio_categ_current_status=$this->uri->segment("5");
		$du=date("Y-m-d h:i:sa");
		if($bio_categ_current_status=="1"){// current status is deactivated
			$to_do="0";
			$allow_disable=1;
			$upd_action="Activated";
			$trail_action="ACTIVATE";
		}else{
			$to_do="1";
			$upd_action="Deactivated";
			$trail_action="DEACTIVATE";
			$checkbeforedisable=$this->time_biometrics_setup_model->checkbeforedisable($bio_categ_id);
			if(!empty($checkbeforedisable)){
				$allow_disable=0;//true
			}else{
				$allow_disable=1;//false
			}
		}

		if($allow_disable==1){

		$query=$this->db->query("update `biometrics_brand` set InActive='".$to_do."',date_updated='".$du."' where bio_categ_id='".$bio_categ_id."'");


			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Biometrics Setup','logfile_time_biosetup',''.$trail_action.' biometrics brand id: '.$bio_categ_id.'',''.$trail_action.'',$bio_categ_id);


			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Successfully $upd_action!</div>");

		}else{

			$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-remove'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Disable Not Allowed since there is an active biometrics type under this biometric brand.</div>");

		}

		$this->session->set_flashdata('onload',"brandmng()");
		$this->index();

	}
	public function validate_edit_brand_name(){
	
		$value = $this->input->post('brand_name');
		if($this->time_biometrics_setup_model->validate_edit_brand_name($value)){
			$this->form_validation->set_message("validate_edit_brand_name"," Biometrics Brand Name, <strong>".$value."</strong>, Already Exists.");
			return false;

		}else{
			return true;
		}
	}
	public function validate_brand_name(){
	
		$value = $this->input->post('brand_name');
		if($this->time_biometrics_setup_model->validate_brand_name($value)){
			$this->form_validation->set_message("validate_brand_name"," Biometrics Brand Name, <strong>".$value."</strong>, Already Exists.");
			return false;

		}else{
			return true;
		}
	}
	//======================================================
	public function biotypemng(){	

		$this->data['active_brand'] = $this->time_biometrics_setup_model->active_brand();
		$this->data['biotypemng'] = $this->time_biometrics_setup_model->biotypemng();
	
		$this->data['check_real_time_bio'] = $this->time_biometrics_setup_model->check_real_time_bio();
	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
			
		$this->load->view('app/time/biometrics_setup/biotypemng',$this->data);
 	}	
	public function add_biotype(){
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		$this->form_validation->set_rules("brand_name","Brand Name","trim|required");
		$this->form_validation->set_rules("bio_type","Biometrics Type","trim|required|callback_validate_bio_type");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){
	
		
			$this->time_biometrics_setup_model->save_bio_type();
			// logfile
			$value = $this->input->post('bio_type');

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Biometrics Setup','logfile_time_biosetup','add bio type : '.$value.'','INSERT',$value);

			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Biometrics Type <strong>".$value."</strong>, is Successfully Added!</div>");

			$this->session->set_flashdata('onload',"biotypemng()");
			redirect(base_url().'app/time_biometrics_setup/index',$this->data);
			//$this->load->view('app/time/biometrics_setup/brandmng',$this->data);

		}else{
			$this->session->set_flashdata('onload',"biotypemng()");
			$this->index();
		}		
	}
	public function validate_bio_type(){
	
		$value = $this->input->post('bio_type');
		
		if($this->time_biometrics_setup_model->validate_bio_type($value)){
			$this->form_validation->set_message("validate_bio_type"," Biometrics Type, <strong>".$value."</strong>, Already Exists.");
			return false;

		}else{
			return true;
		}
	}

	public function biotype_status_action(){
		$id=$this->uri->segment("4");
		$bio_type_current_status=$this->uri->segment("5");
		$du=date("Y-m-d h:i:sa");
		if($bio_type_current_status=="1"){// current status is deactivated
			$to_do="0";
			$trail_action="ACTIVATE";
		}else{
			$to_do="1";
			$trail_action="DEACTIVATE";
		}

		$query=$this->db->query("update `biometrics` set InActive='".$to_do."',date_updated='".$du."' where id='".$id."'");

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Biometrics Setup','logfile_time_biosetup',''.$trail_action.' bio type : '.$id.'',''.$trail_action.'',$id);


		$this->session->set_flashdata('onload',"biotypemng()");
		$this->index();

	}
	public function delete_bio_type(){
		$id=$this->uri->segment("4");

		$query=$this->db->query("delete from `biometrics` where id='".$id."'");

			// logfile
			$value = $id;
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Biometrics Setup','logfile_time_biosetup','delete bio type : '.$id.'','DELETE',$id);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Biometrics ID: <strong>".$value."</strong>, is Successfully Deleted!</div>");


		$this->session->set_flashdata('onload',"biotypemng()");
		$this->index();

	}

	public function edit_biotype(){	
		$id=$this->uri->segment("4");

		$selected_bio= $this->time_biometrics_setup_model->edit_bio_type($id);
		if(!empty($selected_bio)){
			$this->data['s_brand_name']=$selected_bio->brand_name;
			$this->data['s_bio_name']=$selected_bio->bio_name;
			$this->data['s_bio_brand_id']=$selected_bio->bio_brand_id;
			$this->data['s_db_type_name']=$selected_bio->cValue;
			$this->data['bio_db_type']=$selected_bio->bio_db_type;

			$this->data['bio_db_username']=$selected_bio->bio_db_username;
			$this->data['bio_db_password']=$selected_bio->bio_db_password;
			$this->data['bio_details']=$selected_bio->bio_details;
		}else{

			$this->data['s_bio_name']="";
			$this->data['s_bio_brand_id']="";
			$this->data['s_db_type_name']="";
			$this->data['bio_db_type']="";
			$this->data['s_brand_name']="";

			$this->data['bio_db_username']="";
			$this->data['bio_db_password']="";
			$this->data['bio_details']="";
		}
		$this->data['active_brand'] = $this->time_biometrics_setup_model->active_brand();
		$this->load->view('app/time/biometrics_setup/edit_biotype',$this->data);
 	}	
	public function save_edit_biotype(){
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		$this->form_validation->set_rules("bio_type","Biometrics Type","trim|required|callback_validate_edit_bio_name");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){
		
			$this->time_biometrics_setup_model->edit_bio();
			// logfile
			$value = $this->input->post('bio_type');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Biometrics Setup','logfile_time_biosetup','update bio type : '.$value.'','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Biometrics Type <strong>".$value."</strong>, is Successfully Updated!</div>");

			$this->session->set_flashdata('onload',"biotypemng()");
			redirect(base_url().'app/time_biometrics_setup/index',$this->data);

		}else{
			$this->session->set_flashdata('onload',"biotypemng()");
			$this->index();
		}		
	}
	public function validate_edit_bio_name(){
	
		$value = $this->input->post('bio_type');
		if($this->time_biometrics_setup_model->validate_edit_bio_name($value)){
			$this->form_validation->set_message("validate_edit_bio_name"," Biometrics Type/Name, <strong>".$value."</strong>, Already Exists.");
			return false;

		}else{
			return true;
		}
	}

	public function manage_setup(){	
		$id=$this->uri->segment("4");

		$m_selected_bio= $this->time_biometrics_setup_model->selected_bio_type($id);

		if(!empty($m_selected_bio)){

			$this->data['m_data_source_name_driver']=$m_selected_bio->data_source_name_driver;
			$this->data['m_file_loc_name']=$m_selected_bio->file_loc_name;
			$this->data['real_time_status']=$m_selected_bio->real_time_status;
			$this->data['m_ip_address']=$m_selected_bio->ip_address;
			$this->data['m_file_table_name']=$m_selected_bio->file_table_name;
			$this->data['m_employee_id_field_name']=$m_selected_bio->employee_id_field_name;
			$this->data['m_logs_field_name']=$m_selected_bio->logs_field_name;
			$this->data['m_logs_type_field_name']=$m_selected_bio->logs_type_field_name;
			$this->data['real_time_timer']=$m_selected_bio->real_time_timer;

			$this->data['date_container']=$m_selected_bio->date_container;
			$this->data['time_container']=$m_selected_bio->time_container;
			$this->data['bio_container_type']=$m_selected_bio->bio_container_type;

			$this->data['code_in']=$m_selected_bio->code_in;
			$this->data['code_out']=$m_selected_bio->code_out;
			$this->data['code_break_in1']=$m_selected_bio->code_break_in1;
			$this->data['code_break_out1']=$m_selected_bio->code_break_out1;
			$this->data['code_lunch_in']=$m_selected_bio->code_lunch_in;
			$this->data['code_lunch_out']=$m_selected_bio->code_lunch_out;
			$this->data['code_break_in2']=$m_selected_bio->code_break_in2;
			$this->data['code_break_out2']=$m_selected_bio->code_break_out2;
			$this->data['sync_action_text']=$m_selected_bio->sync_action_text;
			$this->data['sync_action']=$m_selected_bio->sync_action;

		}else{

			$this->data['m_data_source_name_driver']="(*.mdb, *.accdb)";
			$this->data['real_time_status']="";
			$this->data['real_time_timer']="";
			$this->data['m_file_loc_name']="";
			$this->data['m_ip_address']="";
			$this->data['m_file_table_name']="";
			$this->data['m_employee_id_field_name']="";
			$this->data['m_logs_field_name']="";
			$this->data['m_logs_type_field_name']="";

			$this->data['date_container']="";
			$this->data['time_container']="";
			$this->data['bio_container_type']="";

			$this->data['code_in']="";
			$this->data['code_out']="";
			$this->data['code_break_in1']="";
			$this->data['code_break_out1']="";

			$this->data['code_lunch_in']="";
			$this->data['code_lunch_out']="";
			$this->data['code_break_in2']="";
			$this->data['code_break_out2']="";
			$this->data['sync_action']="";
			$this->data['sync_action_text']="";
		}



		$this->load->view('app/time/biometrics_setup/manage_setup',$this->data);
 	}



	public function save_manage_setup(){
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		//$this->form_validation->set_rules("file_loc_name","File Location","trim|required");
		$this->form_validation->set_rules("file_table_name","Database Table Name","trim|required");
		$this->form_validation->set_rules("employee_id_field_name","Employee ID Field Name","trim|required");
		$this->form_validation->set_rules("logs_field_name","Logs Field Name","trim|required");
		$this->form_validation->set_rules("logs_type_field_name","Logs Type Field Name","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){
	
		
			$this->time_biometrics_setup_model->save_manage_setup();
			$id=$this->input->post("id");
			$chosen_company=$this->input->post("chosen_company");
			$query=$this->db->query("delete from `biometrics_realtime` where biometrics_id='".$id."'");
			
				foreach ($chosen_company as $key => $chosen_comp_id)
				{

					$this->time_biometrics_setup_model->insertRealTimeComp($chosen_comp_id);

				}


			// logfile
			$value = $this->input->post('id');
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Biometrics Setup','logfile_time_biosetup','update setup of bio type : '.$value.'','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Biometrics Type <strong>".$value."</strong>, is Successfully Managed/Updated!</div>");

			$this->session->set_flashdata('onload',"biotypemng()");

			//$this->session->set_flashdata('onload',"manage_setup(".$value.")");
			redirect(base_url().'app/time_biometrics_setup/index',$this->data);

		}else{
			$this->session->set_flashdata('onload',"biotypemng()");
			$this->session->set_flashdata('onload',"manage_setup(".$value.")");
			$this->index();
		}		
	}

	public function biotype_realtime_used_action(){
		$id=$this->uri->segment("4");
		$bio_type_current_real_time_status=$this->uri->segment("5");
		$du=date("Y-m-d h:i:sa");
		if($bio_type_current_real_time_status=="1"){// current status is deactivated
			$to_do="0";
		}else{
			$to_do="1";
		}

		$query=$this->db->query("update `biometrics` set real_time_status='".$to_do."',date_updated='".$du."' where id='".$id."'");
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Time','Biometrics Setup','logfile_time_biosetup','set as in use in realtime bio id : '.$id.'','UPDATE',$id);

		$this->session->set_flashdata('onload',"biotypemng()");
		$this->index();

	}


}//controller