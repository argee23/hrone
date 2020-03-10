<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Payroll_loan_type extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/payroll_loan_model");
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

//VIEW LOAN TYPE=====================================================================	
	
public function loan_type_view(){	 
		$this->load->view('app/payroll/file_maintenance/loan/loan_type_company_settings',$this->data);		
	}
public function loan_type_select_option(){
		$this->load->view('app/payroll/file_maintenance/loan/loan_type_select_option',$this->data);		
	}

public function loan_company_view(){	 
		$this->data['loan'] 	= $this->payroll_loan_model->get_loan_result();
		$this->load->view('app/payroll/file_maintenance/loan/view',$this->data);		
	}

public function loan_type_list(){	 
		$company_id=$this->uri->segment('4');
		$this->data['loan'] 	= $this->payroll_loan_model->get_loan_result();
		$this->data['category'] = $this->payroll_loan_model->get_category_result();
		$this->load->view('app/payroll/file_maintenance/loan/view',$this->data);		
	}
//END VIEW LOAN======================================================================
//ADD NEW LOAN TYPE=============================================================================
 
 public function add_new_loan(){
        $company_id =$this->uri->segment('4');		
		$this->data['category'] = $this->payroll_loan_model->get_category_result();
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->load->view('app/payroll/file_maintenance/loan/add_new_loan',$this->data);
	}
 public function save_add_new_loan()
    {	
    	$loan_type = $this->input->post('loan_type');
    	$loan_type = $this->input->post('loan_type_code');
		$company_id= $this->input->post('company_id');
	
    	$this->form_validation->set_rules("loan_type","Loan Type","trim|required|callback_validate_loan");
		$this->form_validation->set_rules("loan_type_code","Loan Type Code","trim|required|callback_validate_loan_code");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->payroll_loan_model->AddNewLoan();
			// logfile
			$value = $this->input->post('loan_type');
			General::logfile('This','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> This, <strong>".$value."</strong>, is Successfully Added!</div>");
		
		$this->session->set_flashdata('onload',"view(".$company_id.")");
		redirect(base_url().'app/payroll_loan_type/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		

      }

    public function validate_loan(){
		 $company_id =$this->uri->segment('4');		
		$value = $this->input->post('loan_type');

		if($this->payroll_loan_model->validate_loan()){
			$this->form_validation->set_message("validate_loan"," Loan Type, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}
	  public function validate_loan_code(){
		 $company_id =$this->uri->segment('4');		
		$value = $this->input->post('loan_type_code');
		if($this->payroll_loan_model->validate_loan_code()){
			$this->form_validation->set_message("validate_loan_code"," Loan Type Code, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}


//EDIT LOAN TYPE==============================================================================    
public function loan_table_edit(){
	   $loan_type_id =$this->uri->segment('4');		
 		$this->data['table_loan'] 			= $this->payroll_loan_model->get_table_loan($loan_type_id);
	 	$table_loan 							= $this->payroll_loan_model->get_table_loan($loan_type_id);		 
		$company_id							= $table_loan[0]->company_id;
		$this->data['category'] = $this->payroll_loan_model->get_category_edit($company_id);
		$this->load->view('app/payroll/file_maintenance/loan/loan_table_edit',$this->data);			
	}

public function loan_edit_save(){	 
		$loan_type = $this->input->post('loan_type');
		$loan_type_code = $this->input->post('loan_type_code');
		$company_id= $this->input->post('company_id');
		$this->form_validation->set_rules("loan_type","Loan Type","trim|required|callback_validate_edit_loan");
		$this->form_validation->set_rules("loan_type_code","Loan Type Code","trim|required|callback_validate_edit_loan_code");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		
		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$this->payroll_loan_model->loan_table_edit($id);

			// logfile
			$company_id=$company_id;
			$value = $loan_type;
			General::logfile('This','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The row, <strong>".$value."</strong>, is Successfully Modified!</div>");

			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/payroll_loan_type/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		



	}

	public function validate_edit_loan(){
		$id = $this->uri->segment("4");
		$value = $this->input->post('loan_type');
		 $company_id =$this->uri->segment('4');	
		if($this->payroll_loan_model->validate_edit_loan($id)){
			$this->form_validation->set_message("validate_edit_loan"," Loan Type, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}
public function validate_edit_loan_code(){
		$id = $this->uri->segment("4");
		 $company_id =$this->uri->segment('4');	
		$value = $this->input->post('loan_type_code');
		if($this->payroll_loan_model->validate_edit_loan_code($id)){
			$this->form_validation->set_message("validate_edit_loan_code"," Loan Type Code, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}



	// END OF EDIT LOAN TYPE========================================================================= 
  public function delete_loans(){

		$loan_type_id = $this->uri->segment("4");
		$loan_type = $loans->loan_type;

					$this->db->query("delete from loan_type where loan_type_id = ".$loan_type_id);
				
					
					$value = $loan_type;
				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  The Loan Type selected has successfully deleted.</div>");

		redirect(base_url().'app/payroll_loan_type/index',$this->data);
	}

//END DELETE=================================================================================


//DEACTIVATEandACTIVATE LOAN CATEGORY==================================================================
	public function deactivate_loan_type(){

		$loan_type_id = $this->uri->segment("4");
		$loan_type = $this->payroll_loan_model->delete($loan_type_id);

		$this->payroll_loan_model->deactivate($loan_type_id);

		// logfile
		$value = $loan_type->loan_type." (".$loan_type->loan_type_id.")";

		General::logfile('Loan Type','DISABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Deactivated!</div>");

		redirect(base_url().'app/payroll_loan_type/index',$this->data);
	}

	public function activate_loan_type(){

		$loan_type_id = $this->uri->segment("4");
		$loan_type = $this->payroll_loan_model->delete($loan_type_id);

		$this->payroll_loan_model->activate($loan_type_id);

		// logfile
		$value = $loan_type->loan_type." (".$loan_type->loan_type_id.")";

		General::logfile('Loan Type','ENABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Activated!</div>");

		redirect(base_url().'app/payroll_loan_type/index',$this->data);
	}

	

}//controller