<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Payroll_other_addition_emp_enrollment extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/payroll_other_addition_emp_enrollment_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$this->load->library('form_validation');
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){	
		$this->load->view('include/header',$this->data); //header	
		$this->load->view('include/sidebar',$this->data); //sidebar	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message'); 
		$this->load->view('app/payroll/other_addition_emp_enrollment/index',$this->data);

	}


//OPTION VIEW========================================================================================

public function other_addition_emp_enrollment_option(){	 

		$company_id=$this->uri->segment('4');
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->data['paytypeList_addition'] = $this->payroll_other_addition_emp_enrollment_model->paytypeList_addition();
		$this->load->view('app/payroll/other_addition_emp_enrollment/other_addition_select_option',$this->data);		
	}
public function other_addition_manual_encoding(){	 

		$company_id=$this->uri->segment('4');
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->data['paytypeList_addition'] = $this->payroll_other_addition_emp_enrollment_model->paytypeList_addition();
		$this->load->view('app/payroll/other_addition_emp_enrollment/view',$this->data);		
	}


//GET GROUP BY PAYTYPE=================================================================================
	public function by_group(){	
			$company_id=$this->uri->segment("4");
			$pay_type=$this->uri->segment("4");

			$this->load->view('app/payroll/other_addition_emp_enrollment/by_group',$this->data);	
		
	}
//GET PAYROLL PERIOD BY GROUP PAYTYPE=================================================================================
	public function by_payroll_period(){	
		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");
		$pay_type_group=$this->uri->segment("6");
		$this->data['addition_type'] = $this->payroll_other_addition_emp_enrollment_model->getAdditionTypes($company_id);	
		
		$this->data['pay_per_addition'] = $this->payroll_other_addition_emp_enrollment_model->payroll_per_per_company_pay_type($company_id,$pay_type,$pay_type_group);//$company_id
			$this->load->view('app/payroll/other_addition_emp_enrollment/by_payroll_period',$this->data);	
		
	}

public function show_div_dept(){
		$company_id=$this->uri->segment("4");
		$division_id=$this->uri->segment("5");
		$this->data['get_div_dept'] = $this->general_model->get_company_division_departments($company_id,$division_id);

		$this->load->view('app/payroll/other_addition_emp_enrollment/show_div_dept',$this->data);
	}	

public function show_section(){
		$dept_id=$this->uri->segment("4");
		$this->data['get_section'] = $this->general_model->getSec($dept_id);

		$this->load->view('app/payroll/other_addition_emp_enrollment/show_section',$this->data);
	}	
	
public function clear_fetched_sub_sec(){

		$this->load->view('app/payroll/other_addition_emp_enrollment/show_clear_fetched_sub_sec',$this->data);
	}

public function show_sub_section(){
		$section_id=$this->uri->segment("4");
		$section=$this->uri->segment("4");

		$this->data['check_section'] = $this->general_model->get_the_section($section);
		$this->data['get_sub_section'] = $this->general_model->get_sec_subsection($section_id);
		$this->load->view('app/payroll/other_addition_emp_enrollment/show_sub_section',$this->data);
	}
public function generate_addition(){


		$company_id=$this->input->post('company_id');
		$this->data['company_info'] = $this->general_model->get_company_info($company_id);
		$comp_info = $this->general_model->get_company_info($company_id);
		$comp_division_setting=$comp_info->wDivision;
		
		$id=$this->input->post('pay_period'); // payroll period id

		$pay_type=$this->input->post('pay_type');
		$pay_type_group=$this->input->post('pay_type_group');
	
		$division=$this->input->post('division');
		$department=$this->input->post('department');
		$section=$this->input->post('section');

		if($section=="All"){
			$sub_sec_setting="";			
			$sub_section=""; // matic no matter what sub sections at query

		}else{
			$check_sub_section=$this->general_model->get_the_section($section);
			$sub_sec_setting=$check_sub_section->wSubsection;

		}
		
        $this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');

		$this->data['pay_period_info'] = $this->general_model->get_payroll_period($id);
		$this->data['employee'] = $this->payroll_other_addition_emp_enrollment_model->get_addition_employeeList($company_id,$comp_division_setting,$sub_sec_setting,$pay_type_group);
		$this->data['addition_enrollment'] = $this->payroll_other_addition_emp_enrollment_model->getAdditionEnrollments();
		$this->data['addition_type'] = $this->payroll_other_addition_emp_enrollment_model->getAdditionTypes($company_id);	
		$this->load->view('app/payroll/other_addition_emp_enrollment/generate_addition',$this->data);
	}

//SAVING ADDITION EMPLOYEE ENROLLMENT=======================================================================================

function save_addition_enrollment(){
		$employee_id = $this->input->post('employee_id');
		$company_id= $this->input->post('company_id');
		$pay_period = $this->input->post('pay_period');
		
			// save data
		$this->payroll_other_addition_emp_enrollment_model->save_addition_enrollment();
		
		//echo "<script type='text/javascript'>alert('Successfully Added!')/'/'</script>";
		echo "<script>";
		echo "window.close();";
		echo "window.opener.location.reload();";
		echo "</script>";

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> This, <strong>Other Addition Enrollment</strong>, is Successfully Added!</div>");
		
		$this->session->set_flashdata('onload',"view(".$company_id.")");
				
}




}//controller



