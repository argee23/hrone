<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Payroll_file_maintenance extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/payroll_file_maintenance_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){	
		$this->payroll_file_maintenance();	
	}

	public function payroll_file_maintenance(){
		$this->data['message'] = '';		 
		$this->load->view('app/payroll/file_maintenance/file_maintenance',$this->data);		
	}

	public function payroll_file_maintenance_setting(){
		$this->data['message'] = $this->session->flashdata('message');		 
		$this->load->view('app/payroll/file_maintenance/file_maintenance',$this->data);		
	}
	//===============================================SSS==============================================================
	public function sss_company_view(){	 

		$this->load->view('app/payroll/file_maintenance/sss/sss_company',$this->data);		
	}

	public function save_sched_by_loc_sss(){
		$company_id=$this->uri->segment('4');
		$deduction_schedule=$this->input->post('cutoff');
		$loc=$this->input->post('loc');
		if(!empty($loc)){
			foreach ($this->input->post('loc') as $key => $value)
			{

				$emp=$this->payroll_file_maintenance_model->check_emp_loc($company_id,$value);
				if(!empty($emp)){
					foreach($emp as $e){

						$query=$this->db->query("delete from per_employee_sss_deduction_schedule where employee_id='".$e->employee_id."'" );

						$set_sss_sched= array(
							'employee_id'	=>	$e->employee_id,
							'deduction_schedule'	=>	$deduction_schedule,
							'date_added'	=>	date('Y-m-d H:i:s'),
							'InActive'	=>	0
						);
							
							$this->payroll_file_maintenance_model->set_sss_sched($set_sss_sched);
					}
				}else{

				}				
			}
		}else{

		}

		redirect('app/payroll_file_maintenance/', $this->data);
		
	}

	public function save_sched_by_loc_ph(){
		$company_id=$this->uri->segment('4');
		$deduction_schedule=$this->input->post('cutoff');
		$loc=$this->input->post('loc');
		if(!empty($loc)){
			foreach ($this->input->post('loc') as $key => $value)
			{

				$emp=$this->payroll_file_maintenance_model->check_emp_loc($company_id,$value);
				if(!empty($emp)){
					foreach($emp as $e){

				$query=$this->db->query("delete from per_employee_philhealth_deduction_schedule where employee_id='".$e->employee_id."'" );

						$set_ph_sched= array(
							'employee_id'	=>	$e->employee_id,
							'deduction_schedule'	=>	$deduction_schedule,
							'date_added'	=>	date('Y-m-d H:i:s'),
							'InActive'	=>	0
						);
							
						$this->payroll_file_maintenance_model->set_ph_sched($set_ph_sched);
					}
				}else{

				}				
			}
		}else{

		}

		redirect('app/payroll_file_maintenance/', $this->data);
		
	}

	public function sss_company_table(){
		$this->data['company'] 			=  $this->input->post('company');
		$company_id						=  $this->input->post('company');

		$this->data['compLoc']=$this->general_model->get_company_locations($company_id);
		$this->data['per_emp_sched'] = $this->payroll_file_maintenance_model->get_sss_ded_sched($company_id);
  		$this->data['sss_ded_sched']=$this->payroll_file_maintenance_model->checkGeneralTaxTypeSetup($company_id,25);

		$this->data['sss_company'] 		=  $this->payroll_file_maintenance_model->get_company_name($company_id); 
		//$this->data['sss_cutoff'] 		=  $this->payroll_file_maintenance_model->get_sss_cutoff_current_new($company_id);
		$this->data['sss_date'] 		=  $this->payroll_file_maintenance_model->get_sss_date($company_id);
		$this->data['paytype_sss'] 		= $this->payroll_file_maintenance_model->paytypeList_sss($company_id);
		$this->data['payroll_sss'] 		=  $this->payroll_file_maintenance_model->get_payroll_sss_display($company_id);
		$this->data['message'] 			=  $this->session->flashdata('message');		 
		$this->load->view('app/payroll/file_maintenance/sss/sss_company_table',$this->data);		
	}

	public function sss_table_result(){	 
		$this->data['payroll_sss'] 	= $this->payroll_file_maintenance_model->get_sss_result();
		$this->load->view('app/payroll/file_maintenance/sss/sss_table_result',$this->data);		
	}
	public function sss_table_result_paytype(){	 
		$this->data['payroll_sss'] 	= $this->payroll_file_maintenance_model->get_sss_result_new();
		$this->load->view('app/payroll/file_maintenance/sss/sss_table_result',$this->data);		
	}

	public function display_sss_cutoff_by_paytype(){	 
		$this->data['display_cutoff'] 	= $this->payroll_file_maintenance_model->get_sss_cutoff();
		$this->load->view('app/payroll/file_maintenance/sss/sss_cutoff_result',$this->data);		
	}

	public function getsssTable_add(){	
		$company_id 						= $this->uri->segment("4");
		$this->data['sss_company'] 			= $this->payroll_file_maintenance_model->get_company_name($company_id); 
		$this->data['sss_pay_type'] 		=  $this->payroll_file_maintenance_model->get_sss_cutoff_current_new($company_id);
		$this->data['sss_date'] 			=  $this->payroll_file_maintenance_model->get_sss_date($company_id);
		$this->load->view('app/payroll/file_maintenance/sss/sss_table_add',$this->data);		
	}

	public function sss_add_save(){	 
		$company_id = $this->uri->segment("4");


		$check_if_exist	= $this->payroll_file_maintenance_model->check_sss_exist($company_id); 
		if($check_if_exist == 0){
		$this->payroll_file_maintenance_model->sss_table_add($company_id);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  SSS TABLE Successfully Added.</div>");
		}else{
			
			$this->session->set_flashdata('message',"<div class='alert alert-info alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  SSS TABLE is Already Refresh.</div>");

		}
		$this->sss_table_result_save();
		//redirect(base_url().'app/payroll_file_maintenance/sss_table_result_save');
	}

	public function sss_table_result_save(){
		$this->data['company'] 				=  $this->uri->segment("4");
		$company_id							=  $this->uri->segment("4");
		$this->data['sss_company'] 			=  $this->payroll_file_maintenance_model->get_company_name($company_id); 
		$this->data['sss_date'] 			=  $this->payroll_file_maintenance_model->get_sss_date($company_id);
		$this->data['sss_cutoff'] 		    =  $this->payroll_file_maintenance_model->get_sss_cutoff_current_new($company_id);
		$this->data['paytype_sss'] 			= $this->payroll_file_maintenance_model->paytypeList_sss($company_id);
		$this->data['payroll_sss'] 			=  $this->payroll_file_maintenance_model->get_payroll_sss_display($company_id);
		$this->data['message']				=  $this->session->flashdata('message');		 
		$this->load->view('app/payroll/file_maintenance/sss/sss_company_table',$this->data);		
	}

	public function getsssTable_edit(){
		$sss_id								= $this->uri->segment("4");
		$this->data['sss']       			= $this->payroll_file_maintenance_model->get_table_sss($sss_id);
		$sss    							= $this->payroll_file_maintenance_model->get_table_sss($sss_id);
		$company 							= $this->payroll_file_maintenance_model->get_sss_company($sss_id);
		$company_id							= $company->company_id;
		$this->data['sss_date'] 			= $this->payroll_file_maintenance_model->get_sss_date($company_id);
		$this->load->view('app/payroll/file_maintenance/sss/sss_table_edit',$this->data);			
	}

	public function sss_edit_save(){	 
		
		$this->payroll_file_maintenance_model->sss_table_edit();

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  SSS TABLE successfully modified.</div>");	

		$this->sss_table_result_edit();		
	}

	public function sss_table_result_edit(){
		$sss_id 							= $this->uri->segment("4");	
		$company 							= $this->payroll_file_maintenance_model->get_sss_company($sss_id);
		$company_id							= $company->company_id;
		$this->data['company']				= $company->company_id;
		$this->data['sss_company'] 			= $this->payroll_file_maintenance_model->get_company_name($company_id); 
		$this->data['sss_date'] 			= $this->payroll_file_maintenance_model->get_sss_date($company_id);
		$this->data['sss_cutoff'] 		    =  $this->payroll_file_maintenance_model->get_sss_cutoff_current_new($company_id);
		$this->data['paytype_sss'] 			= $this->payroll_file_maintenance_model->paytypeList_sss($company_id);
		$this->data['payroll_sss'] 			=  $this->payroll_file_maintenance_model->get_payroll_sss_display($company_id);
		$this->data['message'] 				= $this->session->flashdata('message');
		$this->load->view('app/payroll/file_maintenance/sss/sss_company_table',$this->data);		
	}

	public function sss_table_delete(){	 
		$sss_id 							= $this->uri->segment("4");
		$company 							= $this->payroll_file_maintenance_model->get_sss_company($sss_id);
		$company_id							= $company->company_id;
		$this->data['company']				= $company->company_id;
		$this->data['sss_company'] 			= $this->payroll_file_maintenance_model->get_company_name($company_id); 
		$this->data['sss_cutoff'] 			= $this->payroll_file_maintenance_model->get_sss_cutoff_current_new($company_id);
		$this->data['sss_date'] 			= $this->payroll_file_maintenance_model->get_sss_date($company_id);
		$this->data['payroll_sss'] 			= $this->payroll_file_maintenance_model->get_payroll_sss($company_id);

		$this->payroll_file_maintenance_model->sss_table_delete($sss_id);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  SSS TABLE successfully deleted.</div>");

			$this->sss_table_result_delete($company_id);
	}

	public function sss_table_result_delete($company_id){
		$this->data['company'] 				=  $company_id;
		$company_id							=  $company_id;
		$this->data['sss_company'] 			=  $this->payroll_file_maintenance_model->get_company_name($company_id); 
		$this->data['sss_date'] 			=  $this->payroll_file_maintenance_model->get_sss_date($company_id);
		$this->data['sss_cutoff'] 		    =  $this->payroll_file_maintenance_model->get_sss_cutoff_current_new($company_id);
		$this->data['paytype_sss'] 			= $this->payroll_file_maintenance_model->paytypeList_sss($company_id);
		$this->data['payroll_sss'] 			=  $this->payroll_file_maintenance_model->get_payroll_sss_display($company_id);
		$this->data['message'] = $this->session->flashdata('message');		 
		$this->load->view('app/payroll/file_maintenance/sss/sss_company_table',$this->data);	
	}

	public function sss_copy_standard(){
		$company 		 	= $this->uri->segment("4");
		$current_year  		= date('Y', strtotime(date("Y-m-d")));
		$sss_copy 			= $this->payroll_file_maintenance_model->get_table_sss_standard();
		$this->payroll_file_maintenance_model->sss_delete_oldinsert();
		$paytypeList= $this->general_model->paytypeList();

	$query=$this->db->query("delete from payroll_sss where company_id='".$company."' and date='".$current_year."' " );

		foreach($paytypeList as $p){
			$pay_type_id=$p->pay_type_id;

			foreach ($sss_copy as $standard){
				$this->data = array(
					'company_id'						=>	$company,
					'pay_type_id'						=>	$pay_type_id,
					'range_of_compensation_from'		=>	$standard->range_of_compensation_from,
					'range_of_compensation_to'			=>	$standard->range_of_compensation_to,
					'monthly_salary_credit'				=>	$standard->monthly_salary_credit,
					'ss_er'								=>	$standard->ss_er,
					'ss_ee'								=>	$standard->ss_ee,
					'ec_er'								=>	$standard->ec_er,
					'tc_er'								=>	$standard->tc_er,
					'tc_ee'								=>	$standard->tc_ee,
					'total_contribution'				=>	$standard->total_contribution,
					'date'								=>	$current_year
				);	
				$this->payroll_file_maintenance_model->sss_copy_insert($this->data);
			}

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  SSS TABLE STANDARD successfully copied to current year</div>");

			$this->sss_table_result_save();

		}


	}

	public function sss_print_view(){
		$company 							= $this->uri->segment("4");
		$date 								= $this->uri->segment("5");
		$this->data['sss_company'] 			= $this->payroll_file_maintenance_model->get_company_name($company); 
		$this->data['payroll_sss'] 			= $this->payroll_file_maintenance_model->get_sss_result();
		$this->load->view('app/payroll/file_maintenance/sss/sss_print_result',$this->data);	
	}

	public function sss_cutoff_edit(){
		$current_year 					= date('Y', strtotime(date("Y-m-d")));
		$this->data['paytypeList_addition'] = $this->payroll_file_maintenance_model->paytypeList_addition();		
		$this->data['sss_cutoff'] 		=  $this->payroll_file_maintenance_model->get_cutoff();
		$this->load->view('app/payroll/file_maintenance/sss/sss_cutoff_edit',$this->data);	
	}


	public function sss_cutoff_edit_save($cutoff,$company_id,$pay_type_id){
		
	


		$check_if_exist	= $this->payroll_file_maintenance_model->check_sss_cutoff_exist($cutoff,$company_id,$pay_type_id); 
		if($check_if_exist == 1){
			
		
			$this->payroll_file_maintenance_model->sss_cutoff_edit_save($cutoff,$company_id,$pay_type_id);
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  SSS TABLE Deduction Successfully Updated.</div>");
		}
		else{
			
			$this->payroll_file_maintenance_model->sss_cutoff_add_save($cutoff,$company_id,$pay_type_id);
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  SSS TABLE Deduction Successfully Modified.</div>");
		}
		//redirect('app/payroll_file_maintenance/sss_company_table');
		//$this->sss_table_result_save();
		//$this->sss_cutoff_edit();
		
	}



	//=============================================END OF SSS=========================================================

	//=============================================PHILHEALTH==========================================================
	public function philhealth_company_view(){	 
		$this->load->view('app/payroll/file_maintenance/philhealth/philhealth_company',$this->data);		
	}

	public function philhealth_company_table(){
		$this->data['company'] 				=  $this->input->post('company');
		$company_id							=  $this->input->post('company');

		$this->data['compLoc']=$this->general_model->get_company_locations($company_id);
		$this->data['per_emp_sched'] = $this->payroll_file_maintenance_model->get_ph_ded_sched($company_id);
		//see payroll_main_setting for 26 id
  		$this->data['ph_ded_sched']=$this->payroll_file_maintenance_model->checkGeneralTaxTypeSetup($company_id,26);

		$this->data['philhealth_company'] 	=  $this->payroll_file_maintenance_model->get_company_name($company_id); 
		//$this->data['philhealth_cutoff'] 	=  $this->payroll_file_maintenance_model->get_philhealth_cutoff_current_new($company_id);
		$this->data['philhealth_date'] 		=  $this->payroll_file_maintenance_model->get_philhealth_date($company_id);
		$this->data['payroll_philhealth'] 	=  $this->payroll_file_maintenance_model->get_payroll_philhealth_display($company_id);
		$this->data['paytype_philhealth'] 	= $this->payroll_file_maintenance_model->paytypeList_sss($company_id);
		$this->data['message'] 	=  $this->session->flashdata('message');		 
		$this->load->view('app/payroll/file_maintenance/philhealth/philhealth_company_table',$this->data);		
	}

	public function philhealth_table_result(){	 
		$this->data['payroll_philhealth'] 	= $this->payroll_file_maintenance_model->get_philhealth_result();
		$this->load->view('app/payroll/file_maintenance/philhealth/philhealth_table_result',$this->data);		
	}

	public function philhealth_table_result_paytype(){	

		$pay_type 						= $this->uri->segment("4");
		$company 						= $this->uri->segment("5");
		$date 							= $this->uri->segment("6");
		
		$this->data['payroll_philhealth'] 	= $this->payroll_file_maintenance_model->get_philhealth_result_ptype();
		$this->load->view('app/payroll/file_maintenance/philhealth/philhealth_table_result',$this->data);		
	}

	public function display_philhealth_cutoff_by_paytype(){	 
		$this->data['display_cutoff'] 	= $this->payroll_file_maintenance_model->get_philhealth_cutoff();
		$this->load->view('app/payroll/file_maintenance/philhealth/philhealth_cutoff_result',$this->data);		
	}

	public function getPhilhealthTable_add(){	
		$company_id 						= $this->uri->segment("4");
		$this->data['philhealth_company'] 	= $this->payroll_file_maintenance_model->get_company_name($company_id); 
		$this->data['philhealth_date'] 		=  $this->payroll_file_maintenance_model->get_philhealth_date($company_id);
		$this->load->view('app/payroll/file_maintenance/philhealth/philhealth_table_add',$this->data);		
	}

	public function philhealth_edit_save(){	 
		$monthly_salary_bracket		= $this->uri->segment("4");
		
		$this->payroll_file_maintenance_model->philhealth_table_edit($monthly_salary_bracket);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  PHILHEALTH TABLE successfully modified.</div>");	

		$this->philhealth_table_result_edit();		
	}

	public function philhealth_add_save(){	 

		$company_id = $this->uri->segment("4");
		

		$check_if_exist	= $this->payroll_file_maintenance_model->check_philhealth_exist($company_id); 
		if($check_if_exist == 0){

			$this->payroll_file_maintenance_model->philhealth_table_add($company_id);
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  PHILHEALTH TABLE Successfully Added.</div>");

		}else{
			$this->session->set_flashdata('message',"<div class='alert alert-info alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  PHILHEALTH TABLE is Already Refresh!.</div>");	
	
		}
		//$nn	=  $this->philhealth_company_table();
		//redirect(base_url().'app/payroll_file_maintenance/philhealth_table_result_save'.$nn);
		
		$this->philhealth_table_result_save($company_id);

	}

	public function philhealth_table_result_save(){

		$this->data['company'] 				=  $this->uri->segment("4");
		$company_id							=  $this->uri->segment("4");
		$this->data['philhealth_company'] 	=  $this->payroll_file_maintenance_model->get_company_name($company_id); 
		$this->data['philhealth_cutoff'] 	=  $this->payroll_file_maintenance_model->get_philhealth_cutoff_current_new($company_id);
		$this->data['philhealth_date'] 		=  $this->payroll_file_maintenance_model->get_philhealth_date($company_id);
		$this->data['payroll_philhealth'] 	=  $this->payroll_file_maintenance_model->get_payroll_philhealth_display($company_id);
		$this->data['paytype_philhealth'] 	= $this->payroll_file_maintenance_model->paytypeList_sss($company_id);
		$this->data['message'] = $this->session->flashdata('message');		 	
		$this->load->view('app/payroll/file_maintenance/philhealth/philhealth_company_table',$this->data);		

	}

	public function philhealth_table_result_edit(){
		$monthly_salary_bracket				= $this->uri->segment("4");	
		$company 							= $this->payroll_file_maintenance_model->get_philhealth_company($monthly_salary_bracket);
		$company_id							= $company->company_id;
		$this->data['company']				= $company->company_id;
		$this->data['philhealth_cutoff'] 	=  $this->payroll_file_maintenance_model->get_philhealth_cutoff_current_new($company_id);
		$this->data['philhealth_company'] 	= $this->payroll_file_maintenance_model->get_company_name($company_id); 
		$this->data['philhealth_date'] 		= $this->payroll_file_maintenance_model->get_philhealth_date($company_id);
		$this->data['payroll_philhealth'] 	=  $this->payroll_file_maintenance_model->get_payroll_philhealth_display($company_id);
		$this->data['paytype_philhealth'] 	= $this->payroll_file_maintenance_model->paytypeList_sss($company_id);
		$this->data['message'] 				= $this->session->flashdata('message');
		$this->load->view('app/payroll/file_maintenance/philhealth/philhealth_company_table',$this->data);		
	}



	public function philhealth_table_delete(){	 
		$monthly_salary_bracket			    = $this->uri->segment("4");
		$company 							= $this->payroll_file_maintenance_model->get_philhealth_company($monthly_salary_bracket);
		$company_id							= $company->company_id;
		$this->data['company']				= $company->company_id;
		$this->data['philhealth_company'] 	= $this->payroll_file_maintenance_model->get_company_name($company_id); 
		$this->data['philhealth_cutoff'] 	=  $this->payroll_file_maintenance_model->get_philhealth_cutoff_current_new($company_id);
		$this->data['philhealth_date'] 		= $this->payroll_file_maintenance_model->get_philhealth_date($company_id);
		$this->data['payroll_philhealth'] 	=  $this->payroll_file_maintenance_model->get_payroll_philhealth_display($company_id);
		$this->data['paytype_philhealth'] 	= $this->payroll_file_maintenance_model->paytypeList_sss($company_id);

		$this->payroll_file_maintenance_model->philhealth_table_delete($monthly_salary_bracket);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  PHILHEALTH TABLE successfully deleted.</div>");

		$this->philhealth_table_result_delete($company_id);
	}

	public function philhealth_table_result_delete($company_id){
		$this->data['company'] 				=  $company_id;
		$company_id							=  $company_id;
		$this->data['philhealth_company'] 	=  $this->payroll_file_maintenance_model->get_company_name($company_id); 
		$this->data['philhealth_cutoff'] 	=  $this->payroll_file_maintenance_model->get_philhealth_cutoff_current_new($company_id);
		$this->data['philhealth_date'] 		=  $this->payroll_file_maintenance_model->get_philhealth_date($company_id);
		$this->data['payroll_philhealth'] 	=  $this->payroll_file_maintenance_model->get_payroll_philhealth_display($company_id);
		$this->data['paytype_philhealth'] 	= $this->payroll_file_maintenance_model->paytypeList_sss($company_id);
		$this->data['message'] = $this->session->flashdata('message');		 	
		$this->load->view('app/payroll/file_maintenance/philhealth/philhealth_company_table',$this->data);	
	}

	public function getPhilhealthTable_edit(){
		$monthly_salary_bracket				= $this->uri->segment("4");
		$this->data['philhealth'] 	= $this->payroll_file_maintenance_model->get_table_philhealth($monthly_salary_bracket);
		$table_philhealth 					= $this->payroll_file_maintenance_model->get_table_philhealth($monthly_salary_bracket);
		$company 							= $this->payroll_file_maintenance_model->get_philhealth_company($monthly_salary_bracket);
		$company_id							= $company->company_id;

		$this->data['philhealth_date'] 		=  $this->payroll_file_maintenance_model->get_philhealth_date($company_id);
		$this->load->view('app/payroll/file_maintenance/philhealth/philhealth_table_edit',$this->data);			
	}

	public function philhealth_copy_standard(){
		$company 		 	= $this->uri->segment("4");
		$current_year  		= date('Y', strtotime(date("Y-m-d")));
		$philhealth_copy 	= $this->payroll_file_maintenance_model->get_table_philhealth_standard();
		$this->payroll_file_maintenance_model->philhealth_delete_oldinsert();

		$paytypeList= $this->general_model->paytypeList();

	$query=$this->db->query("delete from payroll_philhealth where company_id='".$company."' and date='".$current_year."' " );

		foreach($paytypeList as $p){
			$pay_type_id=$p->pay_type_id;

			foreach ($philhealth_copy as $standard){
				$this->data = array(
					'company_id'					=> 		$company,
					'pay_type_id'					=> 		$pay_type_id,
					'monthly_salary_range_from' 	=>		$standard->monthly_salary_range_from,
					'monthly_salary_range_to'		=>		$standard->monthly_salary_range_to,
					'percent_value' 				=>		$standard->rate_value,
					'date'							=>		$current_year,
					'philhealth_type'				=>		$standard->system_parameters_param_id,
					'employee_share'				=>		$standard->employee_share,
					'employer_share'				=>		$standard->employer_share,
				);	
				$this->payroll_file_maintenance_model->philhealth_copy_insert($this->data);
			}

		}

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  PHILHEALTH TABLE STANDARD successfully copied to current year</div>");

		$this->philhealth_table_result_save();

	}

	public function philhealth_print_view(){
		$company 							= $this->uri->segment("4");
		$date 								= $this->uri->segment("5");
		$this->data['philhealth_cutoff'] 	=  $this->payroll_file_maintenance_model->get_philhealth_cutoff_current($company);
		$philhealth_cutoff 				 	=  $this->payroll_file_maintenance_model->get_philhealth_cutoff_current($company);
		$this->data['philhealth_company'] 	= $this->payroll_file_maintenance_model->get_company_name($company); 
		$this->data['payroll_philhealth'] 	= $this->payroll_file_maintenance_model->get_philhealth_result();

		$this->load->view('app/payroll/file_maintenance/philhealth/philhealth_print_result',$this->data);	


	}
	public function philhealth_cutoff_edit(){
		$current_year 							= date('Y', strtotime(date("Y-m-d")));
		$this->data['paytypeList_addition'] = $this->payroll_file_maintenance_model->paytypeList_addition();		
		$this->data['philhealth_cutoff'] 		=  $this->payroll_file_maintenance_model->get_cutoff();
		$this->load->view('app/payroll/file_maintenance/philhealth/philhealth_cutoff_edit',$this->data);	
	}

	public function philhealth_cutoff_edit_save($cutoff,$company_id,$pay_type_id){

		$check_if_exist	= $this->payroll_file_maintenance_model->check_philhealth_cutoff_exist($cutoff,$company_id,$pay_type_id); 
		if($check_if_exist == 1){
			$this->payroll_file_maintenance_model->philhealth_cutoff_edit_saving($cutoff,$company_id,$pay_type_id);
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  PHILHEALTH TABLE Deduction Successfully Updated!.</div>");
		}
		else{
			$this->payroll_file_maintenance_model->philhealth_cutoff_add_saving($cutoff,$company_id,$pay_type_id);
	
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  PHILHEALTH TABLE Deduction Successfully Added!.</div>");
			}

		//$this->philhealth_table_result_save();
		
	}

	public function pagibig_table_result(){	 
		$this->data['payroll_pagibig'] 	= $this->payroll_file_maintenance_model->get_pagibig_result();
		$this->load->view('app/payroll/file_maintenance/pagibig/pagibig_table_result',$this->data);		
	}

	

	//=========================================END OF PHILHEALTH=====================================================

	//=============================================PAGIBIG==========================================================
	public function show_cutoff_option(){
		
		$this->load->view('app/payroll/file_maintenance/employee_pagibig_setting/show_cutoff_option',$this->data);
	}
	public function pagibig_company_view(){	 
		$this->load->view('app/payroll/file_maintenance/pagibig/pagibig_company',$this->data);		
	}

	public function pagibig_company_table(){
		$this->data['company'] 				=  $this->input->post('company');
		$company_id							=  $this->input->post('company');
		$this->data['pagibig_company'] 	    =  $this->payroll_file_maintenance_model->get_company_name($company_id); 
		$this->data['pagibig_date'] 		=  $this->payroll_file_maintenance_model->get_pagibig_date($company_id);
		$this->data['payroll_pagibig'] 		=  $this->payroll_file_maintenance_model->get_payroll_pagibig_display($company_id);
		$this->data['pagibig_current_date'] =  $this->payroll_file_maintenance_model->check_pagibig_date($company_id);


		$this->data['message'] 				=  $this->session->flashdata('message');		 
		$this->load->view('app/payroll/file_maintenance/pagibig/pagibig_company_table',$this->data);		
	}

	public function getPagibigTable_edit(){
		$pagibig_table_id	 				= $this->uri->segment("4");
		$this->data['cut_off_typeList'] = $this->general_model->cut_off_typeList();
		
		$this->data['pagibig'] 				= $this->payroll_file_maintenance_model->get_table_pagibig($pagibig_table_id);
		$company 							= $this->payroll_file_maintenance_model->get_pagibig_company($pagibig_table_id);
		$this->data['pagibig_cutoff'] 		=  $this->payroll_file_maintenance_model->get_cutoff();
		$this->data['pagibig_type'] 		=  $this->payroll_file_maintenance_model->get_pagibig_type();
		$company_id							=  $company->company_id;
		$this->data['pagibig_date'] 		=  $this->payroll_file_maintenance_model->get_pagibig_date($company_id);
		$this->load->view('app/payroll/file_maintenance/pagibig/pagibig_table_edit',$this->data);			
	}

	public function pagibig_edit_save(){	 
		$pagibig_table_id		= $this->uri->segment("4");
		
		$this->payroll_file_maintenance_model->pagibig_table_edit($pagibig_table_id);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  PAGIBIG TABLE successfully modified.</div>");	

		$this->pagibig_table_result_edit();		
	}

	public function pagibig_table_result_edit(){

		$pagibig_table_id					= $this->uri->segment("4");	
		$company 							= $this->payroll_file_maintenance_model->get_pagibig_company($pagibig_table_id);
		$company_id							= $company->company_id;
		$this->data['company']				= $company->company_id;
		$this->data['pagibig_company'] 	    = $this->payroll_file_maintenance_model->get_company_name($company_id); 
		$this->data['pagibig_date'] 		= $this->payroll_file_maintenance_model->get_pagibig_date($company_id);
		$this->data['payroll_pagibig'] 		= $this->payroll_file_maintenance_model->get_payroll_pagibig_display($company_id);
		$this->data['pagibig_current_date'] = $this->payroll_file_maintenance_model->check_pagibig_date($company_id);

		$this->data['message'] 				= $this->session->flashdata('message');
		$this->load->view('app/payroll/file_maintenance/pagibig/pagibig_company_table',$this->data);		
	
	}

	public function pagibig_copy_setting(){
		$company 		 					= $this->uri->segment("4");
		$current_year  						= date('Y', strtotime(date("Y-m-d")));

		$check_setting						= $this->payroll_file_maintenance_model->check_table_pagibig_setting();
		$this->data['pagibig_current_date'] =  $this->payroll_file_maintenance_model->check_pagibig_date($company);

		if($check_setting === true){

			$this->payroll_file_maintenance_model->pagibig_setting_insert();

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  PAGIBIG EMPLOYEE SETTING successfully copied to EMPLOYEE PAGIBIG TABLE </div>");

		}

		else{
			$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  PAGIBIG EMPLOYEE SETTING is not yet settled.</div>");
		}

		

		$this->pagibig_table_result_save();

	}

	public function pagibig_table_result_save(){

		$this->data['company'] 				=  $this->uri->segment("4");
		$company_id							=  $this->uri->segment("4");
		$this->data['pagibig_company'] 		=  $this->payroll_file_maintenance_model->get_company_name($company_id); 
		$this->data['pagibig_date'] 		=  $this->payroll_file_maintenance_model->get_pagibig_date($company_id);
		$this->data['payroll_pagibig'] 		=  $this->payroll_file_maintenance_model->get_payroll_pagibig_display($company_id);
		$this->data['pagibig_current_date'] =  $this->payroll_file_maintenance_model->check_pagibig_date($company_id);

		$this->data['message'] = $this->session->flashdata('message');		 
		$this->load->view('app/payroll/file_maintenance/pagibig/pagibig_company_table',$this->data);		

	}

	public function pagibig_copy_employee(){
		$company 		 	= $this->uri->segment("4");
		$current_year  		= date('Y', strtotime(date("Y-m-d")));

		$check_employee		= $this->payroll_file_maintenance_model->check_employee_company();

		if($check_employee === true){

			$this->payroll_file_maintenance_model->pagibig_employee_insert();

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  EMPLOYEE(s) successfully copied to EMPLOYEE PAGIBIG TABLE current year </div>");

		}

		else{
			$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-exclamation'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  There's no employee exist to the company.</div>");
		}

		$this->pagibig_table_result_save();

	}

	//=========================================END OF PAGIBIG=====================================================


	//===============================++======EMPLOYEE PAGIBIG SETIINGS===============================================

	public function employee_pagibig_setting_company_view(){	 
		$this->load->view('app/payroll/file_maintenance/employee_pagibig_setting/employee_pagibig_setting_company',$this->data);		
	}
	
	public function getCompany_employeeSetting_view(){	 
		$this->data['payroll_employee_pagibig']		=  $this->payroll_file_maintenance_model->get_payroll_employee_pagibig();
		$this->data['pagibig_setting_cutoff'] 		=  $this->payroll_file_maintenance_model->get_cutoff();
		$this->data['pagibig_setting_type'] 		=  $this->payroll_file_maintenance_model->get_pagibig_type();
		

		$this->load->view('app/payroll/file_maintenance/employee_pagibig_setting/employee_pagibig_setting_company_form',$this->data);
	}

	public function employee_pagibig_setting_edit_save(){	 

		$this->payroll_file_maintenance_model->employee_pagibig_setting_edit_save();

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  EMPLOYEE PAGIBIG SETTING successfully modified.</div>");

		$this->payroll_file_maintenance_setting();
				
	}

	public function employee_pagibig_setting_add_save(){	

		$this->payroll_file_maintenance_model->employee_pagibig_setting_add_save();

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  EMPLOYEE PAGIBIG SETTING successfully added.</div>");

		$this->payroll_file_maintenance_setting();
				
	}
	//===========================+++++======END OF EMPLOYEE PAGIBIG SETIINGS==================+++====================



	
	// ====================== REPLACE 


	//============================ GOVERNMENT REMITTANCE MANAGEMENT =========================//

	public function company_view(){	 
		$this->load->view('app/payroll/file_maintenance/govt_remittance_mngt/company_list',$this->data);
	}

	public function company_table(){
		$this->data['company'] 			=  $this->input->post('company');
		$company_id						=  $this->input->post('company');
		$this->data['remitt_company'] 	=  $this->payroll_file_maintenance_model->get_company_name($company_id);
		$this->data['company_contri'] 	=  $this->payroll_file_maintenance_model->get_govt_contri_remittance($company_id);
		$this->data['gov_type']			= $this->payroll_file_maintenance_model->get_gov_type($company_id);
		$this->data['month']			= $this->payroll_file_maintenance_model->get_month($company_id);
		$this->data['payroll_period']	= $this->payroll_file_maintenance_model->get_payroll_period($company_id);
		$this->data['message'] 			=  $this->session->flashdata('message');		 
		$this->load->view('app/payroll/file_maintenance/govt_remittance_mngt/company_table',$this->data);
	}

	public function gov_contri_add_save(){	
		$month 				= $this->input->post('month_cover');
		$year 				= $this->input->post('year_cover'); 
		$gov 				= $this->input->post('gov'); 
		$sss_diskette 		= $this->input->post('sss_diskette'); 
		$sbr 				= $this->input->post('sbr_number');
		$remittance_date 	= $this->input->post('remittance_date');
		$company_id 		= $this->uri->segment("4");
		$check_if_exist		= $this->payroll_file_maintenance_model->check_contri_exist($company_id, $month, $year, $gov);
		$value 				= $month.", ".$year.", ".$gov.", ".$sss_diskette.", ".$sbr.", ".$remittance_date;

		if($check_if_exist == 0){

			$this->payroll_file_maintenance_model->govt_contri_remittance_add($company_id);

			General::system_audit_trail('Payroll','Government Contribution Remittance Management-Table','logfile_payroll_file_maintenance','add : company id: '.$company_id.': value: '.$value.' ,','INSERT',$value);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  GOVERNMENT REMITTANCES CONTRIBUTION Successfully Added.</div>");
		}else{

			$this->session->set_flashdata('message',"<div class='alert alert-info alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  GOVERNMENT REMITTANCES CONTRIBUTION is Already Exist.</div>");
		}

		redirect('app/payroll_file_maintenance/', $this->data);
	}

	public function get_company_edit(){
		$id	= $this->uri->segment("4");
		$this->data['contri_table_edit']	= $this->payroll_file_maintenance_model->get_govt_contri_remittance_edit($id);
		$this->data['gov_type']				= $this->payroll_file_maintenance_model->get_gov_type($id);
		$this->data['month']				= $this->payroll_file_maintenance_model->get_month($id);
		$this->data['payroll_period']		= $this->payroll_file_maintenance_model->get_payroll_period($id);
		$contri_table_edit = $this->payroll_file_maintenance_model->get_govt_contri_remittance_edit($id);

		$this->load->view('app/payroll/file_maintenance/govt_remittance_mngt/company_table_edit',$this->data);
	}

	public function contri_save_update(){
		$data 				= $this->input->post();
		$month 				= $this->input->post('month_cover_edit');
		$year 				= $this->input->post('year_cover_edit'); 
		$gov 				= $this->input->post('gov_edit'); 
		$sss_diskette 		= $this->input->post('sss_diskette_edit'); 
		$sbr 				= $this->input->post('sbr_number_edit');
		$remittance_date 	= $this->input->post('remittance_date_edit');
		$id 				= $this->uri->segment("4");
		$company_info 		= $this->payroll_file_maintenance_model->get_contri_company($id);
		$company_id 		= $company_info->company_id;
		$check_if_exist		= $this->payroll_file_maintenance_model->check_contri_exist($company_id, $month, $year, $gov);
		$value 				= $month.", ".$year.", ".$gov.", ".$sss_diskette.", ".$sbr.", ".$remittance_date;

		if($check_if_exist == 0){

			$this->payroll_file_maintenance_model->govt_contri_remittance_update($id);

			General::system_audit_trail('Payroll','Government Contribution Remittance Management-Table','logfile_payroll_file_maintenance','update : company id: '.$company_id.': value: '.$value.' ,','UPDATE',$value);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  GOVERNMENT REMITTANCES MANAGEMENT TABLE successfully modified.</div>");
		}else{

			$this->session->set_flashdata('message',"<div class='alert alert-info alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  GOVERNMENT REMITTANCES CONTRIBUTION is Already Exist.</div>");
		}
	}

	public function gov_contri_delete(){	 
		$id 	= $this->uri->segment("4");
		$value 	= $id;

		$this->payroll_file_maintenance_model->govt_contri_remittance_delete($id);

		General::system_audit_trail('Payroll','Government Contribution Remittance Management-Table','logfile_payroll_file_maintenance','delete : '.$id.' ,','DELETE',$value);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  GOVERNMENT REMITTANCES MANAGEMENT successfully deleted.</div>");

		redirect('app/payroll_file_maintenance/', $this->data);
	}

	public function contri_table_result($company_id){
		$this->data['company'] 				=  $company_id;
		$company_id							=  $company_id;
		$this->data['remitt_company'] 		=  $this->payroll_file_maintenance_model->get_company_name($company_id);
		$this->data['company_contri'] 		=  $this->payroll_file_maintenance_model->get_govt_contri_remittance($company_id);
		$this->data['message'] = $this->session->flashdata('message');

		$this->load->view('app/payroll/file_maintenance/govt_remittance_mngt/company_table',$this->data);
	}
	//===================================== END =========================================//



	//=============================SSS FORM MANAGEMENT==================================//

	public function sss_form_mngt_company_view(){	 
		$this->load->view('app/payroll/file_maintenance/sss_r1-A_form_mngt/company_list',$this->data);
	}

	public function sss_form_mngt_company_table(){
		$this->data['company'] 				=  $this->input->post('company');
		$company_id							=  $this->input->post('company');
		$this->data['sss_form_company'] 	=  $this->payroll_file_maintenance_model->get_company_name($company_id);
		$this->data['sss_form'] 			=  $this->payroll_file_maintenance_model->get_sss_r1a_form($company_id);
		$this->data['message'] 				=  $this->session->flashdata('message');		 
		$this->load->view('app/payroll/file_maintenance/sss_r1-A_form_mngt/company_table',$this->data);
	}

	public function get_employee_list(){
		$company_id	 =  $this->input->post('company_id');

		$m_data	=  $this->payroll_file_maintenance_model->get_employee_list($company_id);

		$data = array();

		foreach ($m_data as $value) {
			$row = array();
			$row[] = '<input type="checkbox" name="employeeselected[]" value="'.$value->employee_id.'" >';
			$row[] = $value->employee_id;
			$row[] = $value->fullname;

			$data[] = $row;
		}

		$result = array(
			"data" => $data
		);

		echo json_encode($result);

	}

	public function filter_employee_list(){
		$company_id	 =  $this->input->post('company_id');
		$date_from	 =  $this->input->post('date_from');
		$date_to	 =  $this->input->post('date_to');

		$m_data = $this->payroll_file_maintenance_model->filter_employee_list($company_id, $date_from, $date_to);
		$data = array();

		foreach ($m_data as $value) {
			$row = array();
			$row[] = '<input type="checkbox" name="employeeselected[]" value="'.$value->employee_id.'" >';
			$row[] = $value->employee_id;
			$row[] = $value->fullname;

			$data[] = $row;
		}

		$result = array(
			"data" => $data
		);

		echo json_encode($result);
	}

	public function add_employee(){
		$company_id 		= $this->uri->segment("4");
		$current_year 		= date('Y-m-d H:i:s');
		$employee_selected 	= $this->input->post('employeeselected');
		$num_selected		= count($employee_selected);

		if($num_selected > 0){
			for($num = 0; $num < $num_selected; $num++){
				$employee_info = $this->payroll_file_maintenance_model->get_employee_info($employee_selected[$num]);
				$data_employee = array(
					'company_id'  => $employee_info->company_id,
					'employee_id' => $employee_selected[$num],
					'InActive'    => 0,
					'date_added'  => $current_year,
				);

				$this->payroll_file_maintenance_model->insert_emp($data_employee);

				General::system_audit_trail('Payroll','SSS R1A Form Employee Management-Table','logfile_payroll_file_maintenance','add : company id: '.$company_id.': value: '.$employee_selected[$num].' ,','INSERT',$employee_selected[$num]);
			}

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$num_selected." Employee(s) Successfully Added</div>");
		}else{

			$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> No Employee Added</div>");
		}

		redirect('app/payroll_file_maintenance/', $this->data);
	}

	public function set_status(){
		$company_id		=  $this->uri->segment("4");
		$InActive		= $this->input->post('InActive');
		$employee_id 	= $this->input->post("employee_id");
		$value 			= $employee_id.", ".$InActive;

		$this->payroll_file_maintenance_model->set_status();

		if($InActive = $this->input->post('InActive') == 1){
			General::system_audit_trail('Payroll','SSS R1A Form Employee Management-Table','logfile_payroll_file_maintenance','ACTIVATE : company id: '.$company_id.': value: '.$value.' ,','ACTIVATE',$value);
		} else {
			General::system_audit_trail('Payroll','SSS R1A Form Employee Management-Table','logfile_payroll_file_maintenance','DEACTIVATE : company id: '.$company_id.': value: '.$value.' ,','DEACTIVATE',$value);
		}

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee Status Successfully Changed.</div>");

        $this->sss_form_mngt_company_table();
	}

	public function delete_employee(){
		$company_id		=  $this->uri->segment("4");
		$employee_id 	= $this->input->post('employee_id');
		$value 			= $employee_id;

		$this->payroll_file_maintenance_model->delete_emp();

		General::system_audit_trail('Payroll','SSS R1A Form Employee Management-Table','logfile_payroll_file_maintenance','delete : company id: '.$company_id.': value: '.$value.' ,','DELETE',$value);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Employee Successfully Deleted.</div>");

        $this->sss_form_mngt_company_table();
	}

	//========================================END========================================//



// ==================== employee tax type

	public function employee_tax_type(){
		
		$this->load->view("app/payroll/file_maintenance/employee_tax_type/index",$this->data);
	}

	public function taxType_filter($val){
		$this->data['company_id']=$val;
		$this->load->view("app/payroll/file_maintenance/employee_tax_type/filter",$this->data);
	}

	public function taxtypeFilter2($company_id,$val){
		$this->data['taxtype_chosen']=$val;
		$this->data['company_id']=$company_id;
		$comp_Info=$this->general_model->get_company_info($company_id);
		$this->data['wDivision']=$comp_Info->wDivision;
		$this->data['compLoc']=$this->general_model->get_company_locations($company_id);
        $this->data['compClass']=$this->general_model->get_company_classifications($company_id);
		$this->load->view("app/payroll/file_maintenance/employee_tax_type/filter2",$this->data);
	}

    public function enrolLtaxTableBase(){
     	$this->data['onload'] = $this->session->flashdata('onload');
        $company_id=$this->input->post('company_id');
        $taxt_type_for_save=$this->input->post('taxt_type_for_save');
        foreach ($this->input->post('employee_id') as $key => $employee_id)
        {   
            $date_reg=date('Y-m-d H:i:s');

        $save_values = array(
            'employee_id'           => $employee_id,
            'tax_type'           	=> $taxt_type_for_save,
            'date_time_enrolled'    => $date_reg
        );              

        $this->payroll_file_maintenance_model->enrolLtaxTableBase($save_values);

        $value="$employee_id|$taxt_type_for_save";
        /*
        --------------audit trail composition--------------
        (module,module dropdown,logfiletable,detailed action,action type,key value)
        --------------audit trail composition--------------
        */
        General::system_audit_trail('Payroll','Employee Tax Type','logfile_payroll_file_maintenance','INSERT '.$value.': value: '.$value.' ,','INSERT',$value);

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Successfully Saved</div>");

        }

        $this->session->set_flashdata('onload',"employee_tax_type()");
        redirect(base_url().'app/payroll_file_maintenance/index',$this->data);  
    
}

	public function un_enrol_employee(){
		$company_id=$this->input->post('company_id');
		foreach ($this->input->post('un_employee_id') as $key => $employee_id)
		{   
			$date_reg=date('Y-m-d H:i:s');
			$value="$employee_id remove from taxt type.";
			$query=$this->db->query("delete from tax_type where employee_id='".$employee_id."' ");

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Payroll','Employee Tax Type','logfile_payroll_file_maintenance','DELETE '.$value.': value: '.$value.' ,','INSERT',$value);
		}

        $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Successfully Un Enroll Selected Employee(s)</div>");

		$this->session->set_flashdata('onload',"employee_tax_type('".$company_id."')");
		redirect(base_url().'app/payroll_file_maintenance/index',$this->data); 
	}



public function employeeFilter(){
	$this->data['onload'] = $this->session->flashdata('onload');
	$this->data['message'] = $this->session->flashdata('message');	
    $company_id=$this->input->post('company_id');
    $this->data['company_id']=$company_id;
    $division=$this->input->post('division');
    $department=$this->input->post('department');
    $section=$this->input->post('section');
    $sub_section=$this->input->post('sub_section');
    $taxtype_chosen=$this->input->post('taxtype_chosen');
    $this->data['taxtype_chosen']=$taxtype_chosen;
    // echo below for checking.

    // echo 
    // "
    // division: $division <br>
    // department: $department <br>
    // section: $section <br>
    // sub-section $sub_section <br>
    // ";


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

$this->data['employeeList']=$this->payroll_file_maintenance_model->EmployeeFilter($company_id,$division_condition,$department_condition,$section_condition,$sub_section_condition,$location_condition,$classification_condition,$employment_condition);

$this->data['tax_table_base']=$this->payroll_file_maintenance_model->tax_table_base($company_id,$division_condition,$department_condition,$section_condition,$sub_section_condition,$location_condition,$classification_condition,$employment_condition);

$this->data['annualize_base']=$this->payroll_file_maintenance_model->annualize_base($company_id,$division_condition,$department_condition,$section_condition,$sub_section_condition,$location_condition,$classification_condition,$employment_condition);

$this->load->view('app/payroll/file_maintenance/employee_tax_type/emp_choices',$this->data);

}

// ================= Annual Tax Rates
public function annual_tax_rates_view(){	
	$company_id = $this->input->post('company_id'); 
	$this->load->view('app/payroll/file_maintenance/yearly_annual_tax_rates/tax_rates_company_settings',$this->data);		
}


public function show_annual_tax_rates(){	
		$company_id = $this->uri->segment('4');
		$this->data['company_id']=$company_id;
		$this->data['compInfo']=$this->general_model->get_company_info($company_id);
		$this->data['taxRates']=$this->payroll_file_maintenance_model->getTaxRates($company_id);
		$this->load->view('app/payroll/file_maintenance/yearly_annual_tax_rates/view',$this->data);
	}

public function editTaxRates($company_id,$val){

		$this->data['company_id']=$company_id;
		$this->data['id']=$val;
		$this->data['t']=$this->payroll_file_maintenance_model->editTaxRates($val);
		$this->load->view('app/payroll/file_maintenance/yearly_annual_tax_rates/edit',$this->data);
}

 public function saveEditTaxRates(){	
    
    	$id = $this->input->post('id');
		$company_id= $this->input->post('company_id');
		$additional_rate= $this->input->post('additional_rate');
		$percentage= $this->input->post('percentage');
		$excess_over= $this->input->post('excess_over');
		$not_over= $this->input->post('not_over');
	
    	$this->form_validation->set_rules("additional_rate","Annual Tax Rates","trim|required|numeric|callback_validate_tax_rates");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$this->payroll_file_maintenance_model->saveEditTaxRates($id);

	        $value="$company_id|$additional_rate|$percentage|$excess_over|$not_over";
	        /*
	        --------------audit trail composition--------------
	        (module,module dropdown,logfiletable,detailed action,action type,key value)
	        --------------audit trail composition--------------
	        */
	        General::system_audit_trail('Payroll','Employee Tax Rates','logfile_payroll_file_maintenance','UPDATE '.$additional_rate.': value: '.$additional_rate.' ,','UPDATE',$value);

			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Successfully Updated!</div>");
		
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/payroll_yearly_annual_tax_rates/index',$this->data);


		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		

}
    public function validate_tax_rates(){
    	$id = $this->input->post('id');
		$company_id= $this->input->post('company_id');
		$additional_rate= $this->input->post('additional_rate');
		$percentage= $this->input->post('percentage');
		$excess_over= $this->input->post('excess_over');
		$not_over= $this->input->post('not_over');

		$value="additional rate: $additional_rate | percentage: $percentage| of excess over: $excess_over| but not over: $not_over";

		if($this->payroll_file_maintenance_model->validate_tax_rates($id,$company_id,$additional_rate,$percentage,$excess_over,$not_over)){
			$this->form_validation->set_message("validate_tax_rates"," Annual Tax Rates <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}


	public function deleteTaxRates($id){

		$this->db->query("delete from yearly_annual_tax_rates where id = ".$id);	

	        $value="$id";
	        /*
	        --------------audit trail composition--------------
	        (module,module dropdown,logfiletable,detailed action,action type,key value)
	        --------------audit trail composition--------------
	        */
	        General::system_audit_trail('Payroll','Employee Tax Rates','logfile_payroll_file_maintenance','DELETE '.$value.': value: '.$value.' ,','DELETE',$value);

			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Successfully Deleted!</div>");
		
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/payroll_yearly_annual_tax_rates/index',$this->data);


	}

public function addTaxRates($val){

		$this->data['company_id']=$val;
		$this->load->view('app/payroll/file_maintenance/yearly_annual_tax_rates/add',$this->data);
}
    public function validate_tax_rates_add(){
    
		$company_id= $this->input->post('company_id');
		$additional_rate= $this->input->post('additional_rate');
		$percentage= $this->input->post('percentage');
		$excess_over= $this->input->post('excess_over');
		$not_over= $this->input->post('not_over');
		$value="additional rate: $additional_rate | percentage: $percentage| of excess over: $excess_over| but not over: $not_over";
		if($this->payroll_file_maintenance_model->validate_tax_rates_add($company_id,$additional_rate,$percentage,$excess_over,$not_over)){
			$this->form_validation->set_message("validate_tax_rates_add"," Annual Tax Rates <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

 public function saveAddTaxRates(){	
    
		$company_id= $this->input->post('company_id');
		$additional_rate= $this->input->post('additional_rate');
		$percentage= $this->input->post('percentage');
		$excess_over= $this->input->post('excess_over');
		$not_over= $this->input->post('not_over');
	
    	$this->form_validation->set_rules("additional_rate","Annual Tax Rates","trim|required|numeric|callback_validate_tax_rates_add");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$this->payroll_file_maintenance_model->saveAddTaxRates();

	        $value="$company_id|$additional_rate|$percentage|$excess_over|$not_over";
	        /*
	        --------------audit trail composition--------------
	        (module,module dropdown,logfiletable,detailed action,action type,key value)
	        --------------audit trail composition--------------
	        */
	        General::system_audit_trail('Payroll','Employee Tax Rates','logfile_payroll_file_maintenance','INSERT '.$additional_rate.': value: '.$additional_rate.' ,','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Successfully Added!</div>");
		
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/payroll_file_maintenance/index',$this->data);


		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		

}

	
}