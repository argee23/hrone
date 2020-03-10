<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Payroll_loan_category extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/payroll_loan_category_model");
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


//CATEGORY VIEW========================================================================================

public function loan_type_category_view(){	 
		$company_id=$this->uri->segment('4');
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->data['category'] = $this->payroll_loan_category_model->get_category_result();
		$this->load->view('app/payroll/file_maintenance/loan/loan_type_category_view',$this->data);		
	}

//DEACTIVATEandACTIVATE LOAN CATEGORY==================================================================
	public function deactivate_loan_category(){

		$id = $this->uri->segment("4");
		$category = $this->payroll_loan_category_model->delete($id);

		$this->payroll_loan_category_model->deactivate($id);

		// logfile
		$value = $category->category." (".$category->id.")";

		General::logfile('Loan Category','DISABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Deactivated!</div>");

		redirect(base_url().'app/payroll_loan_category/index',$this->data);
	}

	public function activate_loan_category(){

		$id = $this->uri->segment("4");
		$category = $this->payroll_loan_category_model->delete($id);

		$this->payroll_loan_category_model->activate($id);

		// logfile
		$value = $category->category." (".$category->id.")";

		General::logfile('Loan Category','ENABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Activated!</div>");

		redirect(base_url().'app/payroll_loan_category/index',$this->data);
	}


///DELETE CATEGORY======================================================================================	
 public function delete_category(){

		$id = $this->uri->segment("4");
		$category = $categories->category;

					$this->db->query("delete from loan_category where id = ".$id);
				
					
					$value = $category;
				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  The Loan Type Category selected has successfully deleted.</div>");

		redirect(base_url().'app/payroll_loan_category/index',$this->data);
	}

//ADD NEW CATEGORY=======================================================================================
public function add_new_category(){
        $company_id =$this->uri->segment('4');		
		$this->data['category'] = $this->payroll_loan_category_model->get_category_result();
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->load->view('app/payroll/file_maintenance/loan_category/add_new_category',$this->data);
	}
 public function save_add_new_category()
    {	
    	$category = $this->input->post('category');
		$company_id= $this->input->post('company_id');
	
    	$this->form_validation->set_rules("category","Loan Category","trim|required|callback_validate_category");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->payroll_loan_category_model->AddNewCategory();
			// logfile
			$value = $this->input->post('category');
			General::logfile('This','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> This, <strong>".$value."</strong>, is Successfully Added!</div>");
		
		$this->session->set_flashdata('onload',"view(".$company_id.")");
		redirect(base_url().'app/payroll_loan_category/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		

     }

    public function validate_category(){
		$value = $this->input->post('category');
		 $company_id =$this->uri->segment('4');		
		
		if($this->payroll_loan_category_model->validate_category()){
			$this->form_validation->set_message("validate_category"," Loan Category, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
			
	}


//CATEGORY EDIT===================================================================================

public function category_table_edit(){

        $company_id =$this->uri->segment('4');
		$id								= $this->uri->segment("4");	
		$this->data['table_category'] 			= $this->payroll_loan_category_model->get_table_category($id);
		$table_loan 							= $this->payroll_loan_category_model->get_table_category($id);
		$company 							= $this->payroll_loan_category_model->get_category_company($company_id);
	//	$company_id							= $company[0]->company_id;
		$this->load->view('app/payroll/file_maintenance/loan_category/category_table_edit',$this->data);			
	}

public function category_edit_save(){	 
		$category = $this->input->post('category');
		$company_id= $this->input->post('company_id');
		$this->form_validation->set_rules("category","Loan Category","trim|required|callback_validate_edit_category");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		
		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$this->payroll_loan_category_model->category_table_edit($id);

			// logfile
			$company_id=$company_id;
			$value = $category;
			General::logfile('This','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The row, <strong>".$value."</strong>, is Successfully Modified!</div>");

			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/payroll_loan_category/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		

	}

	public function validate_edit_category(){
		$id = $this->uri->segment("4");
		$value = $this->input->post('category');
		 $company_id =$this->uri->segment('4');	
		if($this->payroll_loan_category_model->validate_edit_category($id)){
			$this->form_validation->set_message("validate_edit_category"," Loan Category, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}


}//controller