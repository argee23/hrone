<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Time_web_bundy extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/time_web_bundy_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	//=========================== WEB BUNDY SETTINGS ================================//
	public function get_web_bundy_settings($val){
		        $this->data['time_wb_update_settings']=$this->session->userdata('time_wb_update_settings');
		$this->data['my_web_bundy']=$this->time_web_bundy_model->get_comp_web_bundy_setting($val);
		$this->load->view('app/time/web_bundy/web_bundy_comp_setting/index',$this->data);	

	}	
	public function get_allowed_ip($val){

		$this->data['my_allowed_ip']=$this->time_web_bundy_model->get_allowed_ip($val);
		$this->load->view('app/time/web_bundy/web_bundy_comp_setting/my_allowed_ip',$this->data);	

	}
	public function save_comp_setting($val){
		$company_id=$val;
		$web_bundy_setting=$this->input->post('web_bundy_setting');

		$delete_existing_policy=$this->db->query("DELETE FROM web_bundy_company_setting where company_id='".$company_id."' ");

        /*
        --------------audit trail composition--------------
        (module,module dropdown,logfiletable,detailed action,action type,key value)
        --------------audit trail composition--------------
        */
        General::system_audit_trail('Time','Web Bundy','logfile_time_web_bundy',''.$web_bundy_setting.'','UPDATE',$company_id);


        $data_comp_setting = array(
            'company_id'          			=> $company_id,
            'web_bundy_setting'           	=> $web_bundy_setting,
            'logged_date'					=> date('Y-m-d H:i:s')
        );

		$this->time_web_bundy_model->save_comp_setting($data_comp_setting);

		$this->session->set_flashdata('onload',"get_web_bundy_settings('".$company_id."')");
    	redirect('app/time_web_bundy/web_bundy');

	}

	//=========================== WEB BUNDY ENROLLMENT ================================//

	public function web_bundy(){
		$this->web_bundy_enrollment();	
	}

	public function web_bundy_enrollment(){
		$this->data['onload']     = $this->session->flashdata('onload');
		$this->data['message']    = $this->session->flashdata('message');	


		$system_setting_id=3;//see system settings : Web Bundy Functions Type
		$this->data['wb_function_management']=$this->time_web_bundy_model->get_system_settings($system_setting_id);

		$system_setting_id=4;//see system settings : Restrict IP Address Allowed in Web Bundy?
		$this->data['wb_allowed_ip_management']=$this->time_web_bundy_model->get_system_settings($system_setting_id);




		$this->load->view('app/time/web_bundy/web_bundy_enrollment',$this->data);		
	}

	public function web_bundy_enrollment_view(){
		$this->load->view('app/time/web_bundy/employee_company',$this->data);
	}

	public function get_division_department(){
		$division_id 						= $this->uri->segment("4");
		$this->data['division_department'] 	= $this->time_web_bundy_model->get_division_department($division_id);

		$this->load->view('app/time/web_bundy/division_department',$this->data);
	}

	public function get_department_section(){
		$department_id						= $this->uri->segment("4");
		$this->data['department_section'] 	= $this->time_web_bundy_model->get_department_section($department_id);

		$this->load->view('app/time/web_bundy/department_section',$this->data);
	}

	public function get_section_subsection(){
		$section_id 					  		= $this->uri->segment("4");
		if($section_id != 0){
			$this->data['section_info'] 	  	= $this->time_web_bundy_model->get_section_info($section_id);
			$this->data['section_subsection'] 	= $this->time_web_bundy_model->get_section_subsection($section_id);

			$this->load->view('app/time/web_bundy/section_subsection',$this->data);
		}
	}

	public function search(){
		$this->data['available_employee'] = $this->time_web_bundy_model->search_employee();

		$this->load->view('app/time/web_bundy/search',$this->data);	
	}

	public function company_employee_view(){
		$company_id 							= $this->uri->segment("4");
		$this->data['company_info']				= $this->time_web_bundy_model->get_company_info($company_id);
		$this->data['web_bundy_employee'] 		= $this->time_web_bundy_model->get_web_bundy_employee($company_id);

        $this->data['time_wb_mng_emp']=$this->session->userdata('time_wb_mng_emp');

		$this->load->view('app/time/web_bundy/company_employee',$this->data);
	}

	public function web_bundy_employee_add_view(){

		$company_id 							= $this->uri->segment("4");
		$this->data['company_info']				= $this->time_web_bundy_model->get_company_info($company_id);
		$this->data['company_locations'] 		= $this->time_web_bundy_model->get_company_location($company_id);
		$this->data['company_division'] 		= $this->time_web_bundy_model->get_company_division($company_id);
		$this->data['company_department'] 		= $this->time_web_bundy_model->get_company_department($company_id);
		$this->data['company_classification'] 	= $this->time_web_bundy_model->get_company_by_classification($company_id);
		$this->data['web_bundy_employee'] 		= $this->time_web_bundy_model->get_web_bundy_employee($company_id);
		$this->data['available_employee'] 		= $this->time_web_bundy_model->get_available_employee($company_id);

		$this->load->view('app/time/web_bundy/add',$this->data);	
	}

	public function register_employee_web_bundy(){
        $company_id                 = $this->uri->segment("4");
        $employee_selected          = $this->input->post('employeeselected');   
        $num_selected               = count($employee_selected);
        $select_value 				= $this->input->post('selectvalue');
      
        if($num_selected > 0){
	        for($num = 0; $num < $num_selected; $num++){
	        	$employee_info = $this->time_web_bundy_model->get_employee_info($employee_selected[$num]);
	            $data_employee = array(
	                'employee_id'          			=> $employee_selected[$num],
	                'company_id'           			=> $employee_info->company_id,
	                'date_added'					=> date('Y-m-d H:i:s'),
	                'code'             				=> $employee_selected[$num].''.substr(uniqid(), 4, 4)
	            );
	            $this->time_web_bundy_model->register_employee_web_bundy($data_employee);

				General::system_audit_trail('Administrator','Time-Web Bundy Enrollment','logfile_time_web_bundy','add : '.$employee_selected[$num].' ,','INSERT',$employee_selected[$num]);

		        }
		    $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> " .$num_selected." Employee(s) Successfully Enrolled to Web Bundy!</div>");
    	}else{
    		$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> No Employee(s) enrolled to Web Bundy.</div>");
    	}
    	
    	redirect('app/time_web_bundy/web_bundy');
    }

	public function remove_employee(){
		$id = $this->uri->segment("4");
		$employee_id = $this->uri->segment("5");

        $this->time_web_bundy_model->delete_employee($id);

		General::system_audit_trail('Administrator','Time-Web Bundy Enrollment','logfile_time_web_bundy','delete : '.$employee_id.' ,','DELETE',$id);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee Successfully Removed.</div>");

      	redirect('app/time_web_bundy/web_bundy');
	}

	//====================================== END ========================================//
}