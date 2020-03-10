<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Payroll_automatic_ot_meal extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/payroll_automatic_ot_meal_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){	
		$this->automatic_ot_meal();	
	}

	//================================ OT Meal Allowance Table =================================//

	public function automatic_ot_meal(){
		$this->data['onload']     = $this->session->flashdata('onload');
		$this->data['message']    = $this->session->flashdata('message');			 
		$this->load->view('app/payroll/automatic_ot_meal/automatic_ot_meal',$this->data);		
	}

	public function ot_meal_table_view(){ 
		$this->load->view('app/payroll/automatic_ot_meal/table/table_company',$this->data);	
	}

	public function company_table_view(){	 
		$company_id 						= $this->uri->segment("4");
		$this->data['company_info']			= $this->payroll_automatic_ot_meal_model->get_company_info($company_id);
		$this->data['company_table'] 		= $this->payroll_automatic_ot_meal_model->get_company_table($company_id);

		$this->load->view('app/payroll/automatic_ot_meal/table/company_table',$this->data);
	}

	public function ot_meal_table_add_view(){
		$company_id 						= $this->uri->segment("4");
		$this->data['company_info']			= $this->payroll_automatic_ot_meal_model->get_company_info($company_id);
		$this->data['company_table'] 		= $this->payroll_automatic_ot_meal_model->get_company_table($company_id); 
		$this->data['classificationList'] 	= $this->payroll_automatic_ot_meal_model->get_company_by_classification($company_id);
		$this->data['otTypeList'] 			= $this->payroll_automatic_ot_meal_model->get_ot_type();
		$this->data['location_company'] 		= $this->payroll_automatic_ot_meal_model->get_company_location($company_id);
		$this->data['employmentList']		= $this->general_model->employmentList();


		$this->load->view('app/payroll/automatic_ot_meal/table/add',$this->data);	
	}

	public function add_save(){
		$ot_type 			= $this->input->post('ot_type');
		$classification 	= $this->input->post('classification');
		$emp_type 			= $this->input->post('emp_type');
		$eh 				= $this->input->post('every_hour');
		$fh 				= $this->input->post('from_hour');
		$th 				= $this->input->post('to_hour');
		$amount 			= $this->input->post('amount');
		$company_id 		= $this->uri->segment("4");
		$location 			= $this->input->post('locationselected');   
        $num_selected       = count($location);
        $arr = $location;
		$loc = implode("-", $arr);

		$check_if_exist		= $this->payroll_automatic_ot_meal_model->check_if_exist($company_id, $ot_type, $location, $classification, $emp_type);
		$value = $ot_type.", ".$loc.", ".$classification.", ".$emp_type.", ".$eh.", ".$fh." to ".$th." = ".$amount;

		if($check_if_exist == 0){
			 if($num_selected > 0){
	        	for($num = 0; $num < $num_selected; $num++){

	        		$add_ot_meal = array(
						'company_id'		=>	$company_id,
						'param_id'			=>	$ot_type,
						'location_id'		=>	$location[$num],
						'classification'	=>	$classification,
						'employment'		=>	$emp_type ,
						'every_hour'		=>	$eh ,
						'from_hour'			=>	$fh ,
						'to_hour'			=>	$th,
						'amount'			=>	$amount ,
						'InActive'			=>  0,
						'date_added'		=> date('Y-m-d H:i:s')
						);

				    $this->payroll_automatic_ot_meal_model->add_ot_meal($add_ot_meal);

				}
				General::system_audit_trail('Payroll','Automatic OT Meal Allowance-Table','logfile_payroll_automatic_ot_meal','add : company id: '.$company_id.': value: '.$value.' ,','INSERT',$value);
			}

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> New OT Meal Allowance Successfully Added.</div>");
		}else{

			$this->session->set_flashdata('message',"<div class='alert alert-info alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> OT Meal Allowance is Already Exist.</div>");
			}

		redirect('app/payroll_automatic_ot_meal');
	}

	public function ot_meal_table_edit_view(){
		$id 								= $this->uri->segment("4");
		$company_info 						= $this->payroll_automatic_ot_meal_model->get_ot_meal_table($id);
		$company_id 						= $company_info->company_id;
		$this->data['ot_meal'] 				= $this->payroll_automatic_ot_meal_model->get_ot_meal_table($id);
		$this->data['company_info']			= $this->payroll_automatic_ot_meal_model->get_company_info($company_id);
		$this->data['company_table'] 		= $this->payroll_automatic_ot_meal_model->get_company_table($company_id); 
		$this->data['company_table_edit'] 	= $this->payroll_automatic_ot_meal_model->get_company_table_edit($company_id,$id );
		$this->data['classificationList'] 	= $this->payroll_automatic_ot_meal_model->get_company_by_classification($company_id);
		$this->data['otTypeList'] 			= $this->payroll_automatic_ot_meal_model->get_ot_type();
		$this->data['location_company'] 		= $this->payroll_automatic_ot_meal_model->get_company_location($company_id);
		$this->data['employmentList'] 		= $this->general_model->employmentList();

		$this->load->view('app/payroll/automatic_ot_meal/table/edit',$this->data);	
	}

	public function edit_save(){
		$id 				= $this->uri->segment("4");
		$ot_type 			= $this->input->post('ot_type_edit');
		$location 			= $this->input->post('location_edit');
		$classification 	= $this->input->post('classification_edit');
		$emp_type 			= $this->input->post('emp_type_edit');
		$eh 				= $this->input->post('every_hour_edit');
		$fh 				= $this->input->post('from_hour_edit');
		$th 				= $this->input->post('to_hour_edit');
		$amount 			= $this->input->post('amount_edit');
		$company_info 		= $this->payroll_automatic_ot_meal_model->get_ot_meal_table($id);
		$company_id 		= $company_info->company_id;
		$check_if_exist		= $this->payroll_automatic_ot_meal_model->check_if_exist_edit($company_id, $ot_type, $location, $classification, $emp_type);
		$value 				= $ot_type.", ".$location.", ".$classification.", ".$emp_type.", ".$eh.", ".$fh." to ".$th." = ".$amount;
 		
 		if($check_if_exist == 0){
 			
			$this->payroll_automatic_ot_meal_model->edit_ot_meal($id);

			General::system_audit_trail('Payroll','Automatic OT Meal Allowance-Table','logfile_payroll_automatic_ot_meal','update company id: '.$company_id.' : column : '.$id.':'.$value.' ,','UPDATE',$value);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> OT Meal Allowance Successfully Modified.</div>");		
		}else{

			$this->session->set_flashdata('message',"<div class='alert alert-info alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> OT Meal Allowance is Already Exist.</div>");
		}

	}

	public function ot_meal_delete(){
		$id 	= $this->uri->segment("4");
		$value 	= $id;

        $this->payroll_automatic_ot_meal_model->delete_ot_meal($id);

		General::system_audit_trail('Payroll','Automatic OT Meal Allowance-Table','logfile_payroll_automatic_ot_meal','delete : '.$id.' ,','DELETE',$value);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> OT Meal Allowance Successfully Deleted.</div>");

        redirect('app/payroll_automatic_ot_meal');
	}

	public function ot_meal_inactivate(){
		$id 	= $this->uri->segment("4");
		$value 	= $id;

		$this->payroll_automatic_ot_meal_model->inactivate_ot_meal($id);

		General::system_audit_trail('Payroll','Automatic OT Meal Allowance-Table','logfile_payroll_automatic_ot_meal','DEACTIVATE : '.$id.' ,','DEACTIVATE',$value);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> OT Meal Allowance Successfully Deactivated.</div>");

        redirect('app/payroll_automatic_ot_meal');
	}

	public function ot_meal_activate(){
		$id 	= $this->uri->segment("4");
		$value 	= $id;

		$this->payroll_automatic_ot_meal_model->activate_ot_meal($id);

		General::system_audit_trail('Payroll','Automatic OT Meal Allowance-Table','logfile_payroll_automatic_ot_meal','ACTIVATE : '.$id.' ,','ACTIVATE',$value);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> OT Meal Allowance Successfully Activated.</div>");

        redirect('app/payroll_automatic_ot_meal');
	}

	//====================================== END ============================================//


	//================================ Enrollment Table ================================//

	public function ot_meal_enrollment_view(){	 
		$this->load->view('app/payroll/automatic_ot_meal/enrollment/employee_company',$this->data);
	}

	public function get_division_department(){
		$division_id 						= $this->uri->segment("4");
		$this->data['division_department'] 	= $this->payroll_automatic_ot_meal_model->get_division_department($division_id);

		$this->load->view('app/payroll/automatic_ot_meal/enrollment/division_department',$this->data);
	}

	public function get_department_section(){
		$department_id						= $this->uri->segment("4");
		$this->data['department_section'] 	= $this->payroll_automatic_ot_meal_model->get_department_section($department_id);

		$this->load->view('app/payroll/automatic_ot_meal/enrollment/department_section',$this->data);
	}

	public function get_section_subsection(){
		$section_id 					  		= $this->uri->segment("4");
		if($section_id != 0){
			$this->data['section_info'] 	  	= $this->payroll_automatic_ot_meal_model->get_section_info($section_id);
			$this->data['section_subsection'] 	= $this->payroll_automatic_ot_meal_model->get_section_subsection($section_id);

			$this->load->view('app/payroll/automatic_ot_meal/enrollment/section_subsection',$this->data);
		}
	}

	public function search(){
		$this->data['available_employee'] = $this->payroll_automatic_ot_meal_model->search_employee();

		$this->load->view('app/payroll/automatic_ot_meal/enrollment/search',$this->data);	
	}

	public function company_employee_view(){
		$company_id 							= $this->uri->segment("4");
		$this->data['company_info']				= $this->payroll_automatic_ot_meal_model->get_company_info($company_id);
		$this->data['company_locations'] 		= $this->payroll_automatic_ot_meal_model->get_company_location($company_id);
		$this->data['company_division'] 		= $this->payroll_automatic_ot_meal_model->get_company_division($company_id);
		$this->data['company_department'] 		= $this->payroll_automatic_ot_meal_model->get_company_department($company_id);
		$this->data['company_classification'] 	= $this->payroll_automatic_ot_meal_model->get_company_by_classification($company_id);
		$this->data['ot_meal_employee'] 		= $this->payroll_automatic_ot_meal_model->get_ot_meal_employee($company_id);

		$this->load->view('app/payroll/automatic_ot_meal/enrollment/company_employee',$this->data);
	}

	public function ot_meal_employee_add_view(){

		$company_id 							= $this->uri->segment("4");
		$this->data['company_info']				= $this->payroll_automatic_ot_meal_model->get_company_info($company_id);
		$this->data['company_locations'] 		= $this->payroll_automatic_ot_meal_model->get_company_location($company_id);
		$this->data['company_division'] 		= $this->payroll_automatic_ot_meal_model->get_company_division($company_id);
		$this->data['company_department'] 		= $this->payroll_automatic_ot_meal_model->get_company_department($company_id);
		$this->data['company_classification'] 	= $this->payroll_automatic_ot_meal_model->get_company_by_classification($company_id);
		$this->data['ot_meal_employee'] 		= $this->payroll_automatic_ot_meal_model->get_ot_meal_employee($company_id);
		$this->data['available_employee'] 		= $this->payroll_automatic_ot_meal_model->get_available_employee($company_id);

		$this->load->view('app/payroll/automatic_ot_meal/enrollment/add',$this->data);	
	}

	public function save_employee_ot_meal(){
        $company_id                 = $this->uri->segment("4");
        $employee_selected          = $this->input->post('employeeselected');   
        $num_selected               = count($employee_selected);
        $select_value 				= $this->input->post('selectvalue');
      
        if($num_selected > 0){
	        for($num = 0; $num < $num_selected; $num++){
	        	$employee_info = $this->payroll_automatic_ot_meal_model->get_employee_info($employee_selected[$num]);
	            $data_employee = array(

	                'employee_id'          			=> $employee_selected[$num],
	                'company_id'           			=> $employee_info->company_id,
	                'date_added'					=> date('Y-m-d H:i:s'),
	                'InActive'             			=> 0

	            );
	            $this->payroll_automatic_ot_meal_model->insert_employee_ot_meal($data_employee);

				General::system_audit_trail('Payroll','Automatic OT Meal-Employee','logfile_payroll_automatic_ot_meal','add : '.$employee_selected[$num].' ,','INSERT',$employee_selected[$num]);

		        }
		    $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> " .$num_selected." Employee(s) Successfully Enrolled to Automatic OT Meal!</div>");
    	}else{
    		$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> No Employee(s) enrolled to Automatic OT Meal.</div>");
    	}
    	
    	redirect('app/payroll_automatic_ot_meal');
    }

    public function inactivate_employee(){
		$id  = $this->uri->segment("4");

		$this->payroll_automatic_ot_meal_model->inactivate_employee($id);

		General::system_audit_trail('Payroll','Automatic OT Meal-Employee','logfile_payroll_automatic_ot_meal','DEACTIVATE : '.$id.' ,','DEACTIVATE',$id);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee Successfully Inactivate.</div>");

        redirect('app/payroll_automatic_ot_meal');
	}

	public function activate_employee(){
		$id = $this->uri->segment("4");

		$this->payroll_automatic_ot_meal_model->activate_employee($id);

		General::system_audit_trail('Payroll','Automatic OT Meal-Employee','logfile_payroll_automatic_ot_meal','ACTIVATE : '.$id.' ,','ACTIVATE',$id);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee Successfully Activate.</div>");

        redirect('app/payroll_automatic_ot_meal');
	}


	public function remove_employee(){
		$id = $this->uri->segment("4");

        $this->payroll_automatic_ot_meal_model->delete_employee($id);

		General::system_audit_trail('Payroll','Automatic OT Meal-Employee','logfile_payroll_automatic_ot_meal','delete : '.$id.' ,','DELETE',$id);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee Successfully Removed.</div>");

      	redirect('app/payroll_automatic_ot_meal');
	}

	//====================================== END ==============================================//
}