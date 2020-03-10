<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Payroll_incentive_leave extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/payroll_incentive_leave_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){	

		$this->payroll_incentive_leave();	
	}

	public function payroll_incentive_leave(){
		$this->data['onload']     = $this->session->flashdata('onload');
		$this->data['message']    = $this->session->flashdata('message');			 
		$this->load->view('app/payroll/incentive_leave/incentive_leave',$this->data);		
	}

	//======================================= INCENTIVE LEAVE TABLE ================================================
	
	public function incentive_leave_table_view(){	 
		$this->load->view('app/payroll/incentive_leave/table/table_company',$this->data);		
	}

	public function company_table_view(){	 
		$company_id 						= $this->uri->segment("4");
		$this->data['company_info']			= $this->payroll_incentive_leave_model->get_company_info($company_id);
		$this->data['company_table'] 		= $this->payroll_incentive_leave_model->get_company_table($company_id); 
		$this->load->view('app/payroll/incentive_leave/table/company_table',$this->data);
	}

	public function incentive_table_add_view(){
		$company_id 						= $this->uri->segment("4");
		$this->data['company_info']			= $this->payroll_incentive_leave_model->get_company_info($company_id);
		$this->data['company_table'] 		= $this->payroll_incentive_leave_model->get_company_table($company_id); 

		$this->load->view('app/payroll/incentive_leave/table/add',$this->data);	
	}

	public function add_save(){
			$company_id 		= $this->uri->segment("4");
		    $checkexist = $this->payroll_incentive_leave_model->checkifexist($company_id);
		    $value=$this->input->post('start_ot_hour')." to ".$this->input->post('end_ot_hour')." = ".$this->input->post('equivalent_incentive_credit');
		    if($checkexist == 1){
		      
		    	$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  Range between START OT HOUR and END OT HOUR already exist.</div>");

				redirect('app/payroll_incentive_leave');

		    }

		    else{

		    	  $this->payroll_incentive_leave_model->add_incentive($company_id);
		    	  //logfile
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Payroll','Incentive Leave-Table','logfile_payroll_incentive_leave','add : company id: '.$company_id.': value: '.$value.' ,','INSERT',$value);


				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  Incentive leave credit successfully added.</div>");

				redirect('app/payroll_incentive_leave');
		    }

	}

	public function incentive_table_edit_view(){
		$incentive_leave_id 				= $this->uri->segment("4");
		$company_info 						= $this->payroll_incentive_leave_model->get_incentive_leave_table($incentive_leave_id);
		$company_id 						= $company_info->company_id;
		$this->data['incentive'] = $this->payroll_incentive_leave_model->get_incentive_leave_table($incentive_leave_id);
		$this->data['company_info']			= $this->payroll_incentive_leave_model->get_company_info($company_id);
		$this->data['company_table'] 		= $this->payroll_incentive_leave_model->get_company_table($company_id); 
		$this->data['company_table_edit'] 	= $this->payroll_incentive_leave_model->get_company_table_edit($company_id,$incentive_leave_id );
		$this->load->view('app/payroll/incentive_leave/table/edit',$this->data);	
	}

	public function edit_save(){
		$incentive_leave_id 	= $this->uri->segment("4");
		$company_info 			= $this->payroll_incentive_leave_model->get_incentive_leave_table($incentive_leave_id);
		$company_id 			= $company_info->company_id;

		$value=$this->input->post('start_ot_hour')." to ".$this->input->post('end_ot_hour')." = ".$this->input->post('equivalent_incentive_credit');
 			$checkexist = $this->payroll_incentive_leave_model->checkifexist($company_id);

		    if($checkexist == 1){
		      	$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  Range between START OT HOUR and END OT HOUR already exist.</div>");	

				redirect('app/payroll_incentive_leave');
		      
		    }

		    else{

		    	 $this->payroll_incentive_leave_model->edit_incentive($incentive_leave_id);
		    	  //logfile
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Payroll','Incentive Leave-Table','logfile_payroll_incentive_leave','update company id: '.$company_id.' : column : '.$id.':'.$value.' ,','UPDATE',$value);

				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  Incentive leave credit successfully modified.</div>");		

				redirect('app/payroll_incentive_leave');

		    	
		    }

	}

	public function incentive_leave_delete(){
		$incentive_leave_id             	= $this->uri->segment("4");
		$value=$incentive_leave_id;
        $this->payroll_incentive_leave_model->delete_incentive($incentive_leave_id);
		    	  //logfile
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Payroll','Incentive Leave-Table','logfile_payroll_incentive_leave','delete : '.$incentive_leave_id.' ,','UPDATE',$value);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Incentive leave credit Successfully Deleted.</div>");

        redirect('app/payroll_incentive_leave');
	}

	public function incentive_leave_inactivate(){
		$incentive_leave_id             	= $this->uri->segment("4");
		$value=$incentive_leave_id;
		 $this->payroll_incentive_leave_model->inactive_incentive($incentive_leave_id);
		    	  //logfile
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Payroll','Incentive Leave-Table','logfile_payroll_incentive_leave','DEACTIVATE : '.$incentive_leave_id.' ,','DEACTIVATE',$value);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Incentive leave credit Successfully Deactivated.</div>");

        redirect('app/payroll_incentive_leave');
	}

	public function incentive_leave_activate(){
		$incentive_leave_id             	= $this->uri->segment("4");
		$value=$incentive_leave_id;
		 $this->payroll_incentive_leave_model->activate_incentive($incentive_leave_id);
		    	  //logfile
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Payroll','Incentive Leave-Table','logfile_payroll_incentive_leave','ACTIVATE : '.$incentive_leave_id.' ,','ACTIVATE',$value);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Incentive leave credit Successfully Activated.</div>");
        redirect('app/payroll_incentive_leave');
	}

	//===================================== END OF INCENTIVE LEAVE TABLE ===========================================

	//==================================== EMPLOYEE INCENTIVE LEAVE ENROLLMENT =====================================
	public function incentive_leave_enrollment_view(){	 

		$this->load->view('app/payroll/incentive_leave/enrollment/employee_company',$this->data);

	}

	public function company_employee_view(){	

		$company_id 							= $this->uri->segment("4");

		$this->data['company_info']				= $this->payroll_incentive_leave_model->get_company_info($company_id);
		$this->data['company_locations'] 		= $this->payroll_incentive_leave_model->get_company_location($company_id);
		$this->data['company_division'] 		= $this->payroll_incentive_leave_model->get_company_division($company_id);
		$this->data['company_department'] 		= $this->payroll_incentive_leave_model->get_company_department($company_id);
		$this->data['company_classification'] 	= $this->payroll_incentive_leave_model->get_company_classification($company_id);
		$this->data['incentive_employee'] 		= $this->payroll_incentive_leave_model->get_incentive_employee($company_id);

		$this->load->view('app/payroll/incentive_leave/enrollment/company_employee',$this->data);

	}

	public function get_division_department(){

		$division_id 						= $this->uri->segment("4");
		$this->data['division_department'] 	= $this->payroll_incentive_leave_model->get_division_department($division_id);
		$this->load->view('app/payroll/incentive_leave/enrollment/division_department',$this->data);

	}

	public function get_department_section(){

		$department_id						= $this->uri->segment("4");
		$this->data['department_section'] 	= $this->payroll_incentive_leave_model->get_department_section($department_id);
		$this->load->view('app/payroll/incentive_leave/enrollment/department_section',$this->data);

	}

	public function get_section_subsection(){

		$section_id 					  = $this->uri->segment("4");
		if($section_id != 0){
			$this->data['section_info'] 	  = $this->payroll_incentive_leave_model->get_section_info($section_id);
			$this->data['section_subsection'] = $this->payroll_incentive_leave_model->get_section_subsection($section_id);
			$this->load->view('app/payroll/incentive_leave/enrollment/section_subsection',$this->data);
		}
	
	}

	public function search(){
		//echo 'jdnksjfnjs';
		$this->data['available_employee'] = $this->payroll_incentive_leave_model->search_employee();		
		//$this->data['message'] 			= $this->session->flashdata('message');		 
		$this->load->view('app/payroll/incentive_leave/enrollment/search',$this->data);	
	}

	public function incentive_employee_add_view(){

		$company_id 							= $this->uri->segment("4");

		$this->data['company_info']				= $this->payroll_incentive_leave_model->get_company_info($company_id);
		$this->data['company_locations'] 		= $this->payroll_incentive_leave_model->get_company_location($company_id);
		$this->data['company_division'] 		= $this->payroll_incentive_leave_model->get_company_division($company_id);
		$this->data['company_department'] 		= $this->payroll_incentive_leave_model->get_company_department($company_id);
		$this->data['company_classification'] 	= $this->payroll_incentive_leave_model->get_company_classification($company_id);
		$this->data['incentive_employee'] 		= $this->payroll_incentive_leave_model->get_incentive_employee($company_id);
		$this->data['available_employee'] 		= $this->payroll_incentive_leave_model->get_available_employee($company_id);

		$this->load->view('app/payroll/incentive_leave/enrollment/add',$this->data);	

	}

	public function save_employee_incentive(){
        $company_id                 = $this->uri->segment("4");
        $employee_selected          = $this->input->post('employeeselected');   
        $num_selected               = count($employee_selected);
        $select_value 				= $this->input->post('selectvalue');
      
        if($num_selected > 0){
		        for($num = 0; $num < $num_selected; $num++){
		    		//echo '<br>'.$employee_selected[$num];
		        	$employee_info      = $this->payroll_incentive_leave_model->get_employee_info($employee_selected[$num]);
		            $data_employee = array(

		                'employee_id'          			=> $employee_selected[$num],
		                'company_id'           			=> $employee_info->company_id,
		                'location'  	       			=> $employee_info->location,
		                'division_id'  	       			=> $employee_info->division_id,
		                'department_id'  	   			=> $employee_info->department,
		                'section'  	   		   			=> $employee_info->section,
		                'subsection'  	   	   			=> $employee_info->subsection,
		                'classification'  	   			=> $employee_info->classification,
		                'equivalent_incentive_leave'	=> $this->input->post('equivalent_incentive_leave'),
		                'date_created'					=> date("Y-m-d"),
		                'InActive'             			=> 0

		            );
		            $this->payroll_incentive_leave_model->insert_employee_incentive($data_employee);

		  	//logfile
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Payroll','Incentive Leave-Employee','logfile_payroll_incentive_leave','add : '.$employee_selected[$num].' ,','INSERT',$employee_selected[$num]);

		        }
		       $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> " .$num_selected." Employee(s) Successfully Enrolled to Incentive Leave!</div>");
		    
		   	//}
    	}
    	else{
    		 $this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> No Employee(s) enrolled to Incentive Leave.</div>");
    	}
    	 redirect('app/payroll_incentive_leave');
    }

    public function incentive_leave_equivalent_view(){
    	$this->load->view('app/payroll/incentive_leave/enrollment/equivalent_incentive_leave',$this->data);	
    }

    public function incentive_employee_edit_view(){

		$employee_incentive_leave_id 			= $this->uri->segment("4");

		//echo $employee_incentive_leave_id;

		$company 								= $this->payroll_incentive_leave_model->get_company_info_employee($employee_incentive_leave_id);

		$company_id 							= $company->company_id;

		//echo $company_id;

		$this->data['company_info']				= $this->payroll_incentive_leave_model->get_company_info($company_id);
		$this->data['company_locations'] 		= $this->payroll_incentive_leave_model->get_company_location($company_id);
		$this->data['company_division'] 		= $this->payroll_incentive_leave_model->get_company_division($company_id);
		$this->data['company_department'] 		= $this->payroll_incentive_leave_model->get_company_department($company_id);
		$this->data['company_classification'] 	= $this->payroll_incentive_leave_model->get_company_classification($company_id);
		$this->data['incentive_employee_edit'] 	= $this->payroll_incentive_leave_model->get_incentive_employee_edit($employee_incentive_leave_id);

		$this->data['incentive_company_employee_edit'] 		= $this->payroll_incentive_leave_model->get_incentive_company_employee_edit($company_id, $employee_incentive_leave_id);


		$this->load->view('app/payroll/incentive_leave/enrollment/edit',$this->data);	

	}

	public function edit_enrollment_save(){

		$employee_incentive_leave_id 			= $this->uri->segment("4");

		$this->payroll_incentive_leave_model->edit_incentive_employee($employee_incentive_leave_id);

		  	//logfile
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Payroll','Incentive Leave-Employee','logfile_payroll_incentive_leave','update : '.$employee_incentive_leave_id.' ,','UPDATE',$employee_incentive_leave_id);



		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  Employee  credit successfully modified.</div>");		

		redirect('app/payroll_incentive_leave');

	}

	public function inactivate_employee(){
		$employee_incentive_leave_id            	= $this->uri->segment("4");

		 $this->payroll_incentive_leave_model->inactivate_employee($employee_incentive_leave_id);
		  	//logfile
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Payroll','Incentive Leave-Employee','logfile_payroll_incentive_leave','DEACTIVATE : '.$employee_incentive_leave_id.' ,','DEACTIVATE',$employee_incentive_leave_id);


        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee Successfully Inactivate.</div>");

        redirect('app/payroll_incentive_leave');
	}

	public function activate_employee(){
		$employee_incentive_leave_id            	= $this->uri->segment("4");

		 $this->payroll_incentive_leave_model->activate_employee($employee_incentive_leave_id);
		  	//logfile
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Payroll','Incentive Leave-Employee','logfile_payroll_incentive_leave','ACTIVATE : '.$employee_incentive_leave_id.' ,','ACTIVATE',$employee_incentive_leave_id);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee Successfully Activate.</div>");

        redirect('app/payroll_incentive_leave');
	}

	public function remove_employee(){
		$employee_incentive_leave_id             	= $this->uri->segment("4");

        $this->payroll_incentive_leave_model->remove_employee($employee_incentive_leave_id);
		  	//logfile
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Payroll','Incentive Leave-Employee','logfile_payroll_incentive_leave','delete : '.$employee_incentive_leave_id.' ,','DELETE',$employee_incentive_leave_id);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Enrolled employee to incentive leave Successfully Removed.</div>");

        redirect('app/payroll_incentive_leave');
	}

	/*public function select_all_employee_view(){

		$this->data['available_employee'] = $this->payroll_incentive_leave_model->search_employee();	

		$this->load->view('app/payroll/incentive_leave/enrollment/select_all_employeee',$this->data);	
	}*/


	/*public function unselect_all_employee_view(){

		$this->data['available_employee'] = $this->payroll_incentive_leave_model->search_employee();	

		$this->load->view('app/payroll/incentive_leave/enrollment/unselect_all_employeee',$this->data);
	}*/

	//=============================== END OF EMPLOYEE INCENTIVE LEAVE ENROLLMENT ===================================
}