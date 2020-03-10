<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Holiday_list extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/holiday_list_model");
		$this->load->model("app/roles_model");
		$this->load->model("app/user_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index(){	
		
			// user restriction function
		// $this->session->set_userdata('page_name','holiday_list_li');
		// $page_id = $this->general_model->getPageID();
		// $userRole = $this->general_model->getUserLoggedIn($this->session->userdata('username'));
		// if(General::has_rights_to_access($page_id->page_id,$userRole->user_role) == FALSE){
		
		// $value = "Holiday List";
		// General::logfile('Holiday List','TRY TO ACCESS',$value);	
		// redirect(base_url().'access_denied');//app/dashboard
		// 	}
		// // end of user restriction function
		// $this->session->set_userdata(array(
		// 		 'tab'			=>		'administrator',
		// 		 'module'		=>		'user_management',
		// 		 'subtab'		=>		'',
		// 		 'submodule'	=>		''));
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');		
		$this->holiday_list();
	
	}	
	public function CheckedAllLocations(){
		$holiday_list = $this->holiday_list_model->getThisYearAll();
		$locationList=$this->general_model->locationList();

		if(!empty($holiday_list)){
			foreach($holiday_list as $h){

				$this->db->query("delete from holiday_list_location where hol_id ='".$h->hol_id."' ");

				if(!empty($locationList)){
					foreach($locationList as $a){
						$resave_location = array(
							'hol_id'	=>	$h->hol_id,
							'location'	=>	$a->location_id,
							'year'	=>	date('Y'),
							'log_date'	=> date('Y-m-d H:i:s')
						);
						$this->holiday_list_model->CheckedAllLocations($resave_location);

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','Holiday List','logfile_admin_holiday_list','add holiday for location(via checked all location):'.$a->location_id.' ,','INSERT',$h->holiday);

						
					}
				}else{
					//echo "no data";

				}				
			}

		}else{

		}
		//$this->holiday_list();

	}
	public function holiday_list(){
		$company_name=$this->session->userdata('company_id');
		$this->data['holiday_list'] = $this->holiday_list_model->getThisYearAll();
		$this->data['years']		= $this->holiday_list_model->getYears();
		$this->load->view('app/holiday_list/index',$this->data);
	}

	public function get_year(){
		$info['year'] = $this->uri->segment('4');
		$info['month']	= 0;
		$info['status']	= $this->uri->segment('5');
		$this->data['holiday_list'] = $this->holiday_list_model->getHolidayChoice($info);
		$this->load->view('app/holiday_list/table',$this->data);
	}

	public function get_month(){
		$info['year'] 	= $this->uri->segment('5');
		$month			= $this->uri->segment('4');
		$info['status']	= $this->uri->segment('6');
		$info['month']	= sprintf('%02d', $month);
		$this->data['holiday_list'] = $this->holiday_list_model->getHolidayChoice($info);
		$this->load->view('app/holiday_list/table',$this->data);
	}

	public function get_status(){
		$info['year'] = 0;
		$info['month']	= 0;
		$info['status'] = $this->uri->segment('4');
		$this->data['holiday_list'] = $this->holiday_list_model->getHolidayChoice($info);
		$this->load->view('app/holiday_list/table',$this->data);
	}
	
	public function add_new_holiday(){

		$this->data['search_for_highest_id']= $this->holiday_list_model->check_last_id_of_holiday();
		//$this->data['holiday_type'] = $this->general_model->holiday_type();
		// $this->data['branches'] = $this->holiday_list_model->getBranches();
		$this->load->view('app/holiday_list/add',$this->data);
	}
	//========================================
	public function get_date(){
		$holiday_id = $this->uri->segment("4");

		$this->data['get_date'] = $this->holiday_list_model->get_date($holiday_id);
		$this->load->view('app/holiday_list/date',$this->data);
	}

	//========================================
	public function save_add(){
		
		$this->form_validation->set_rules("holiday","holiday","trim|required|callback_validate_add_holiday");
		$this->form_validation->set_rules("true_year","Year","trim|required");
		$this->form_validation->set_rules("true_month","Month","trim|required");
		$this->form_validation->set_rules("date","Date","trim|callback_validate_date");
		$this->form_validation->set_rules('day','Day','trim|required');
		$this->form_validation->set_rules("true_type","Holiday Type","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		if($this->form_validation->run()){

			// save data			
			$value = $this->input->post('holiday');
			$h_value=ucwords($this->input->post('holiday'));
			$year_value=$this->input->post('true_year');
			$month_value=$this->input->post('true_month');
			$day_value=$this->input->post('day');
			$h_type=$this->input->post('true_type');

			$hol_details="$h_value , $year_value, $month_value, $day_value,$h_type ";
				foreach ($this->input->post('branch_id') as $key => $value)
			{
				$maximum_id= $this->input->post('hol_id');
				if($maximum_id==''){
					$maximum_id=1;
				}else{
					$maximum_id= $this->input->post('hol_id');
				}

				$date = date('Y-m-d H:i:s');
				$this->data = array(
					'location'	=>		$value,
					'year'	=>		$this->input->post('true_year'),
					'log_date'		=>		$date,
					'hol_id'	=>		$maximum_id
				);
				$this->db->insert("holiday_list_location",$this->data);

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','Holiday List','logfile_admin_holiday_list','add for location :'.$value.' ,','INSERT',$hol_details);


			}

			$this->holiday_list_model->save();
			// logfile

		
			

			if (is_numeric($value)) {
			
				$get_string_holiday = $this->holiday_list_model->get_holiday_string($value);
                  foreach($get_string_holiday as $string_holiday){ 
                    $string_holiday_val= $string_holiday->cValue;
                  	}
			 
						$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Successfully Added!</div>");

					} else {
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Holiday:  <strong>".$value."</strong>, is Successfully Added!</div>");

					}


			// redirect
			redirect(base_url().'app/holiday_list/index',$this->data);
		}else{

			$this->index();
		}		
	}
  
  public function validate_date(){

		$value = $this->input->post("true_month").$this->input->post("day");
		$toecho_value=  date("F", mktime(0, 0, 0, $this->input->post("true_month"), 10))." ".$this->input->post("day");
		if($this->holiday_list_model->validate_date()){
			$this->form_validation->set_message("validate_date"," Holiday on <strong>".$toecho_value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}
	public function validate_add_holiday(){

		$id = $this->uri->segment("4");
		$value = $this->input->post("holiday");

		if($this->holiday_list_model->validate_add_holiday($id)){
			$this->form_validation->set_message("validate_add_holiday"," Holiday, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

	public function deactivate_holiday(){

		$id = $this->uri->segment("4");
		$holiday_list = $this->holiday_list_model->delete($id);

		$this->holiday_list_model->deactivate($id);

		// logfile
		$value = $holiday_list->holiday." (".$holiday_list->hol_id.")";


			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','Holiday List','logfile_admin_holiday_list','DEACTIVATE:'.$value.' ,','DEACTIVATE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Deactivated!</div>");

		redirect(base_url().'app/holiday_list/index',$this->data);
	}

	public function activate_holiday(){

		$id = $this->uri->segment("4");
		$holiday_list = $this->holiday_list_model->delete($id);

		$this->holiday_list_model->activate($id);

		// logfile
		$value = $holiday_list->holiday." (".$holiday_list->hol_id.")";


			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','Holiday List','logfile_admin_holiday_list','ACTIVATE:'.$value.' ,','ACTIVATE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Activated!</div>");

		redirect(base_url().'app/holiday_list/index',$this->data);
	}

	public function edit_holiday(){
		$id = $this->uri->segment("4");
		$this->data['holiday_list'] = $this->holiday_list_model->getHoliday($id);
		$this->load->view('app/holiday_list/edit',$this->data);
	}

	public function modify_holiday(){

		$this->form_validation->set_rules("holiday","Holiday","trim|required");//callback_validate_edit_holiday
		$this->form_validation->set_rules("date","Date","trim|callback_validate_edit_date");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$h_value=ucwords($this->input->post('holiday'));
			$year_value=$this->input->post('true_year');
			$month_value=$this->input->post('true_month');
			$day_value=$this->input->post('day');
			$h_type=$this->input->post('true_type');

			$hol_details="$h_value , $year_value, $month_value, $day_value,$h_type ";
			
			$post_holiday_id=$this->input->post('holiday_id');
			$this->db->query("delete from holiday_list_location where hol_id ='".$post_holiday_id."' ");

			foreach ($this->input->post('branch_id') as $key => $value)
			{


			$date = date('Y-m-d H:i:s');
			$this->data = array(
			'hol_id'			=>	$this->input->post('holiday_id'),
			'year'			=>		$this->input->post('true_year'),
			'log_date'		=>		$date,
			'location'	=>		$value
			);
			$this->db->insert("holiday_list_location",$this->data);


			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Administrator','Holiday List','logfile_admin_holiday_list','update for location :'.$id.' ,','UPDATE',$hol_details);

			}

			$this->holiday_list_model->modify_holiday($id);

			// logfile
			$value = $this->input->post('holiday');
			General::logfile('Holiday','MODIFY',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Leave Type: <strong>".$value."</strong>, is Successfully Modified!</div>");

			// redirect
			// $this->data['in'] = 1;
			$this->session->set_flashdata('onload',"index()");
			redirect(base_url().'app/holiday_list/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"index()");
			$this->index();
		}		
	}
	public function validate_edit_holiday(){
		$id = $this->uri->segment("4");
		$value = $this->input->post("holiday");
		if($this->holiday_list_model->validate_edit_holiday($id)){
			$this->form_validation->set_message("validate_edit_holiday"," Holiday, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}	
	public function validate_edit_date(){

		$value = $this->input->post("month").$this->input->post("day");
		$toecho_value=  date("F", mktime(0, 0, 0, $this->input->post("month"), 10))." ".$this->input->post("day");
		if($this->holiday_list_model->validate_edit_date()){
			$this->form_validation->set_message("validate_edit_date"," Holiday on <strong>".$toecho_value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

}//end controller



