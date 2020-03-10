<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Payroll_lock_period extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/payroll_lock_period_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){	
		//$this->payroll_loan();
		//$this->data['message'] = $this->session->flashdata('message');	
		$this->load->view('include/header',$this->data); //header	
		$this->load->view('include/sidebar',$this->data); //sidebar	
		//$this->data['loan_category'] = $this->payroll_loan_category_model->get_category_result();
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		 
		 $this->load->view('app/payroll/lock_period/index',$this->data);

       
	}


//LOCK PERIOD GROUP VIEW========================================================================================
public function lock_period_group_view(){	 
	$company_id=$this->uri->segment('4');
	$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
	$this->data['lock_period_group'] = $this->payroll_lock_period_model->get_lock_period_group_result();
	$this->data['paytypeList_addition'] = $this->payroll_lock_period_model->paytypeList_addition();
	$this->load->view('app/payroll/lock_period/view',$this->data);		
	}


//LOCK PERIOD TABLE
public function lock_period_table(){	

		$company_id=$this->uri->segment("4");
		$pay_type=$this->uri->segment("5");
		$payroll_period_group_id = $this->uri->segment("6");
		
		$this->data['lock_period_table'] = $this->payroll_lock_period_model->get_lock_period_table_result($company_id,$pay_type,$payroll_period_group_id);
		$lock_period_table = $this->payroll_lock_period_model->get_lock_period_table_result($company_id,$pay_type,$payroll_period_group_id);
		$id = $this->uri->segment('4');
		$this->data['LOCKPERIOD'] = $this->payroll_lock_period_model->getLockPeriod($id);
		$LOCKPERIOD = $this->payroll_lock_period_model->getLockPeriod($id);
		

		$this->load->view('app/payroll/lock_period/lock_period_table',$this->data);		
	}



//LOCK PERIOD TABLE RESULT====================================================================================
public function lock_period_result(){
		$year_from = $this->uri->segment('4');
		$this->data['lock_period'] 	= $this->payroll_lock_period_model->get_lock_period_result($year_from);
		$id = $this->uri->segment('4');
		$this->data['LOCKPERIOD'] = $this->payroll_lock_period_model->getLockPeriod($id);
		$LOCKPERIOD = $this->payroll_lock_period_model->getLockPeriod($id);
		
		$this->load->view('app/payroll/lock_period/lock_period_result',$this->data);		
	}


//LOCK PERIOD ADD LOCKING============================================================================================

public function lock_period_table_add(){
        $group_id =$this->uri->segment('7');
		$pay_type	= $this->uri->segment('6');	
        $company_id =$this->uri->segment('5');
		$id	= $this->uri->segment('4');	
		$this->data['table_lock_period'] 			= $this->payroll_lock_period_model->get_table_lock_period($id);
		$table_lock_period 							= $this->payroll_lock_period_model->get_table_lock_period($id);
		$company_id 								= $this->payroll_lock_period_model->get_lock_period_company($company_id);
		//$company_id							= $table_lock_period[0]->company_id;
		$this->load->view('app/payroll/lock_period/lock_period_table_add',$this->data);			
	}

public function save_add_lock_period()
    {	
    	$pay_code = $this->input->post('pay_code');
		$company_id= $this->input->post('company_id');
		$id= $this->input->post('id');
	
    	$this->form_validation->set_rules("pay_code","Lock Payroll Period","trim|required|callback_validate_lock_period");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->payroll_lock_period_model->AddNewLockPeriod();
			// logfile
			$value = $this->input->post('pay_code');
			General::logfile('This','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> This, <strong>".$value."</strong>, is Successfully Added!</div>");
		
		$this->session->set_flashdata('onload',"view(".$company_id.")");
		redirect(base_url().'app/payroll_lock_period/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		

     }

    public function validate_lock_period(){
		$value = $this->input->post('pay_code');
		 $company_id =$this->input->post('company_id');	
		if($this->payroll_lock_period_model->validate_lock_period()){
			$this->form_validation->set_message("validate_lock_period"," Lock Payroll Period, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}




//PAYROLL PERIOD EDIT===================================================================================

public function lock_period_table_edit(){
	$company_id =$this->uri->segment('4');	
	$id								= $this->uri->segment('4');	
	$this->data['table_period'] 			= $this->payroll_lock_period_model->get_table_payroll_period($id);
	$table_period 							= $this->payroll_lock_period_model->get_table_payroll_period($id);
	$company 							= $this->payroll_lock_period_model->get_payroll_period_company($company_id);
	//$company_id							= $company_id[0]->company_id;
	$this->load->view('app/payroll/lock_period/lock_period_table_edit',$this->data);			
	}

public function lock_period_edit_save(){
		$pay_code = $this->input->post('pay_code');
		$company_id= $this->input->post('company_id');
		$id= $this->input->post('id');
		$this->form_validation->set_rules("pay_code","Company Pay code","trim|required|callback_validate_edit_payroll_period");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		
		if($this->form_validation->run()){

			$pay_code = $this->input->post('pay_code');

			// modify data
			$this->payroll_lock_period_model->lock_period_table_edit($pay_code);

			// logfile
			$company_id = $company_id;
			$value = $pay_code;
			General::logfile('This','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The row, <strong>".$value."</strong>, is Successfully Modified!</div>");

			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/payroll_lock_period/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		

	}

	public function validate_edit_payroll_period(){
		$value = $this->input->post('pay_code');
		 $company_id =$this->input->post('company_id');	
		  $pay_code_id =$this->input->post('pay_code_id');	
		  $id = $this->input->post('id');	
		if($this->payroll_lock_period_model->validate_edit_payroll_period($pay_code_id)){
			$this->form_validation->set_message("validate_edit_payroll_period"," Company Paycode, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

//DEACTIVATEandACTIVATE LOCK PERIOD==================================================================
	public function deactivate_pay_code(){

		$id = $this->uri->segment("4");
		$pay_code = $this->payroll_lock_period_model->delete($id);

		$this->payroll_lock_period_model->deactivate($id);

		// logfile
		$value = $pay_code->pay_code." (".$pay_code->id.")";

		General::logfile('Pay Code','DISABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Deactivated!</div>");

		redirect(base_url().'app/payroll_lock_period/index',$this->data);
	}

	public function activate_pay_code(){

		$id = $this->uri->segment("4");
		$pay_code = $this->payroll_lock_period_model->delete($id);

		$this->payroll_lock_period_model->activate($id);

		// logfile
		$value = $pay_code->pay_code." (".$pay_code->id.")";

		General::logfile('Pay Code','ENABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Activated!</div>");

		redirect(base_url().'app/payroll_lock_period/index',$this->data);
	}
//GET PAYTYPE GROUP==========================================================================================================================
		public function by_group(){	
			$company_id=$this->uri->segment("4");
			$pay_type=$this->uri->segment("4");

			$this->load->view('app/payroll/lock_period/by_group',$this->data);	
		
	}


}//controller