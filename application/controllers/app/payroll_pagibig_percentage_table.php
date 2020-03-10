<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Payroll_pagibig_percentage_table extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/payroll_pagibig_percentage_table_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->payroll_file_maintenance();	
	
	}

	public function payroll_file_maintenance(){
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');		 
		$this->load->view('app/payroll/file_maintenance/file_maintenance',$this->data);		
	}

	public function payroll_file_maintenance_setting(){
		$this->data['message'] = $this->session->flashdata('message');		 
		$this->load->view('app/payroll/loan/file_maintenance',$this->data);		
	}
//+++++++++++++++++++++++++++++++++++++++++++START CATEGORY OTHER ADDITIONS++++++++++++++++++++++++++++++++++++++++++
public function company_view(){	 
		$this->load->view('app/payroll/file_maintenance/pagibig_percentage_table/index',$this->data);		
	}

public function pagibig_percentage_table_list(){
		$company_id=$this->uri->segment('4');
		$this->data['pagibig_per_list'] = $this->payroll_pagibig_percentage_table_model->get_list_result();
		$this->data['pagibig_date'] 	=  $this->payroll_pagibig_percentage_table_model->get_pagibig_date($company_id);
		$this->load->view('app/payroll/file_maintenance/pagibig_percentage_table/pagibig_percentage_table_list',$this->data);		
	}

public function pagibig_percentage_table_result(){	
		
		$company_id = $this->uri->segment('4');
		$date = $this->uri->segment('5');
			
		$this->data['pagibiglist_result'] = $this->payroll_pagibig_percentage_table_model->load_pagibig_result($date,$company_id);
		$this->load->view('app/payroll/file_maintenance/pagibig_percentage_table/pagibig_percentage_table_result',$this->data);		
	}

//ADDING NEW LIST FOR PAGIBIG PERCENTAGE===============================================================================

public function add_new_pagibig_per_list(){

		$this->load->view('app/payroll/file_maintenance/pagibig_percentage_table/add_new_pagibig_per_list',$this->data);		

	}

 public function save_add_new_pagibig_per_list()
    {	
    	
    	$amount_from = $this->input->post('amount_from');
    	$amount_to = $this->input->post('amount_to');
		$company_id= $this->input->post('company_id');
	
    	$this->form_validation->set_rules("amount_from","Pagibig Percentage Amount From","trim|required|callback_validate_amount_from");
    	$this->form_validation->set_rules("amount_to","Pagibig Percentage Amount From","trim|required|callback_validate_amount_to");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->payroll_pagibig_percentage_table_model->AddNewPagibigPercentage();
			// logfile
			$value = 'amount'.$amount_from.'&nbsp;&nbsp;to&nbsp;&nbsp;'.$amount_to;
			General::logfile('This','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> This Pagibig Percentage, <strong>".$value."</strong>, is Successfully Added!</div>");
		
		$this->session->set_flashdata('onload',"view(".$company_id.")");
		redirect(base_url().'app/payroll_pagibig_percentage_table/payroll_file_maintenance',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		

     }

    public function validate_amount_from(){
		$value = $this->input->post('amount_from');
		 $company_id =$this->input->post('company_id');	
		  $c_year =$this->input->post('covered_year');		
		
		if($this->payroll_pagibig_percentage_table_model->validate_amount_from()){
			$this->form_validation->set_message("validate_amount_from"," Pagibig Percentage Amount From, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
			
	}
 	public function validate_amount_to(){
		$value = $this->input->post('amount_to');
		 $company_id =$this->input->post('company_id');		
		  $c_year =$this->input->post('covered_year');	
		if($this->payroll_pagibig_percentage_table_model->validate_amount_to()){
			$this->form_validation->set_message("validate_amount_to"," Pagibig Percentage Amount From, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
			
	}

//===================================OTHER ADDITION EDIT LIST============================================

public function pagibig_percentage_edit($company_id,$pi_percentage_id,$amount_from,$amount_to,$employee_share,$employer_share){
		
		$this->load->view('app/payroll/file_maintenance/pagibig_percentage_table/edit_pagibig_percentage_list',$this->data);			
	}

public function save_edit_new_pagibig_per_list(){	 
		$amount_from = $this->input->post('amount_from');
		$amount_to = $this->input->post('amount_to');
		$company_id= $this->input->post('company_id');
		
	
		$this->form_validation->set_rules("amount_from","Pagibig Percentage Amount From","trim|required|callback_validate_edit_amount_from");
    	$this->form_validation->set_rules("amount_to","Pagibig Percentage Amount From","trim|required|callback_validate_edit_amount_to");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		
		if($this->form_validation->run()){

			$id = $this->input->post('pi_percentage_id');

			// modify data
			$this->payroll_pagibig_percentage_table_model->list_table_edit($id);

			// logfile
			$company_id=$company_id;
			$value = 'amount'.$amount_from.'&nbsp;&nbsp;to&nbsp;&nbsp;'.$amount_to;
			General::logfile('This','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The row, <strong>".$value."</strong>, is Successfully Modified!</div>");

			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/payroll_pagibig_percentage_table/payroll_file_maintenance',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		

	}

	public function validate_edit_amount_from(){
		$id =$this->input->post('pi_percentage_id');
		$value = $this->input->post('amount_from');
		 $company_id =$this->input->post('company_id');
		  $c_year =$this->input->post('covered_year');
		   $amt_to =$this->input->post('amount_to');
		    $empe_share =$this->input->post('employee_share');
		     $empr_share =$this->input->post('employer_share');
		if($this->payroll_pagibig_percentage_table_model->validate_edit_amount_from($id)){
			$this->form_validation->set_message("validate_edit_amount_from","Pagibig Percentage amount_from, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}
	public function validate_edit_amount_to(){
		$id = $this->input->post('pi_percentage_id');
		$value = $this->input->post('amount_to');
		 $company_id =$this->input->post('company_id');
		 $c_year =$this->input->post('covered_year');
		   $amt_fr =$this->input->post('amount_from');
		    $empe_share =$this->input->post('employee_share');
		     $empr_share =$this->input->post('employer_share');
		if($this->payroll_pagibig_percentage_table_model->validate_edit_amount_to($id)){
			$this->form_validation->set_message("validate_edit_amount_to","Pagibig Percentage amount_to, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}
//====================================OTHER ADDITION DELETE LIST=============================================
 public function delete_list(){

		$id = $this->uri->segment("4");


					$this->db->query("delete from payroll_pagibig_percentage_table where pi_percentage_id = ".$id);
				
					
					$value = $id;
				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  The Pagibig Percentage row ID <strong>".$value."</strong> has successfully deleted.</div>");

		redirect(base_url().'app/payroll_pagibig_percentage_table/payroll_file_maintenance',$this->data);
	}

//DEACTIVATEandACTIVATE OTHER ADDITIONS LIST==============================================================
	public function deactivate_pagibig_list(){

		$id = $this->uri->segment("4");
		$amount = $this->payroll_pagibig_percentage_table_model->delete_lists($id);

		$this->payroll_pagibig_percentage_table_model->deactivate_list($id);

		// logfile
		$value = $amount->amount_from.'&nbspto&nbsp'.$amount->aamount_to." (".$amount->pi_percentage_id.")";

		General::logfile('Pagibig Percentage','DISABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Deactivated!</div>");

		redirect(base_url().'app/payroll_pagibig_percentage_table/payroll_file_maintenance',$this->data);
	}

	public function activate_pagibig_list(){

		$id = $this->uri->segment("4");
		$amount = $this->payroll_pagibig_percentage_table_model->delete_lists($id);

		$this->payroll_pagibig_percentage_table_model->activate_list($id);

		// logfile
		$value = $amount->amount_from.'&nbspto&nbsp'.$amount->aamount_to." (".$amount->pi_percentage_id.")";

		General::logfile('Pagibig Percentage','ENABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Activated!</div>");

		redirect(base_url().'app/payroll_pagibig_percentage_table/payroll_file_maintenance',$this->data);
	}

//++++++++++++++++++++++++++++++++++++++++++++END OF LIST OTHER ADDITION++++++++++++++++++++++++++++++++++++++++++++


}