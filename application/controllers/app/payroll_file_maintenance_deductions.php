<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Payroll_file_maintenance_deductions extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/payroll_file_maintenance_deductions_model");
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
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
	
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
//+++++++++++++++++++++++++++++++++++++++++++START CATEGORY OTHER DEDUCTIONS++++++++++++++++++++++++++++++++++++++++++
public function other_deductions_view(){	 
		$this->load->view('app/payroll/file_maintenance/other_deductions/other_deduction_company_settings',$this->data);		
	}

public function other_deduction_select_option(){
		$this->load->view('app/payroll/file_maintenance/other_deductions/other_deduction_select_option',$this->data);		
	}

//OTHER DEDUCTIONS CATEGORY VIEW========================================================================================
public function other_deduction_category_view(){	 
	//	$company_id=$this->uri->segment('4');
	//	$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->data['category'] = $this->payroll_file_maintenance_deductions_model->get_category_result();
		$this->load->view('app/payroll/file_maintenance/other_deductions/other_deduction_category_view',$this->data);		
	}

//ADD NEW DEDUCTIONS CATEGORY=======================================================================================
public function add_new_deduction_category(){
        $company_id =$this->uri->segment('4');		
		$this->data['category'] = $this->payroll_file_maintenance_deductions_model->get_category_result();
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->load->view('app/payroll/file_maintenance/other_deductions/add_new_deduction_category',$this->data);
	}
 public function save_add_new_deduction_category()
    {	
    	$category = $this->input->post('category');
		$company_id= $this->input->post('company_id');
	
    	$this->form_validation->set_rules("category","Other Deduction Category","trim|required|callback_validate_deduction_category");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->payroll_file_maintenance_deductions_model->AddNewDeductionCategory();
			// logfile
			$value = $this->input->post('category');
			General::logfile('This','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> This, <strong>".$value."</strong>, is Successfully Added!</div>");
		
		$this->session->set_flashdata('onload',"view(".$company_id.")");
		redirect(base_url().'app/payroll_file_maintenance_deductions/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		

     }

    public function validate_deduction_category(){
		$value = $this->input->post('category');
		 $company_id =$this->input->post('company_id');		
		
		if($this->payroll_file_maintenance_deductions_model->validate_deduction_category()){
			$this->form_validation->set_message("validate_deduction_category"," Other Deductions Category, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
			
	}

//=============================================EDIT DeDUCTIONS CATEGORY==================================================

public function deduction_category_table_edit(){

        $company_id =$this->uri->segment('4');
		$id	= $this->uri->segment("4");	
		$this->data['table_category'] 			= $this->payroll_file_maintenance_deductions_model->get_table_category($id);
		$company 							= $this->payroll_file_maintenance_deductions_model->get_category_company($company_id);
		$this->load->view('app/payroll/file_maintenance/other_deductions/deduction_category_table_edit',$this->data);			
	}

public function deduction_category_edit_save(){	 
		$category = $this->input->post('category');
		$company_id= $this->input->post('company_id');
		$this->form_validation->set_rules("category","Other Deductions Category","trim|required|callback_validate_edit_deduction_category");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		
		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$this->payroll_file_maintenance_deductions_model->category_table_deduction_edit($id);

			// logfile
			$company_id=$company_id;
			$value = $category;
			General::logfile('This','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The row, <strong>".$value."</strong>, is Successfully Modified!</div>");

			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/payroll_file_maintenance_deductions/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		

	}

	public function validate_edit_deduction_category(){
		$id = $this->uri->segment("4");
		$value = $this->input->post('category');
		 $company_id =$this->input->post('company_id');
		if($this->payroll_file_maintenance_deductions_model->validate_edit_deduction_category($id)){
			$this->form_validation->set_message("validate_edit_deduction_category"," Other Deductions Category, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}


//=============================================DELETE OTHER DEDUCTIONS CATEGORY================================================
 public function delete_category(){

		$id = $this->uri->segment("4");
		$category = $categories->category;

					$this->db->query("delete from other_deductions_category where id = ".$id);
				
					
					$value = $category;
				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  The Other Deductions Category selected has successfully deleted.</div>");

		redirect(base_url().'app/payroll_file_maintenance_deductions/index',$this->data);
	}
//++++++++++++++++++++++++++++++++++++++++++END OF CATEGORY OTHER DEDUCTION=========================================

//+++++++++++++++++++++++++++++++++++++++++++START OF LIST OTHER DEDUCTION+++++++++++++++++++++++++++++++++++++++++++

public function other_deduction_list(){	 
		$company_id=$this->uri->segment('4');
		$this->data['category'] = $this->payroll_file_maintenance_deductions_model->get_category_result();
		$this->data['deduction_list'] = $this->payroll_file_maintenance_deductions_model->get_list_result();
		$this->load->view('app/payroll/file_maintenance/other_deductions/other_deduction_list',$this->data);		
	}


//ADD NEW CATEGORY=======================================================================================
public function add_new_deduction_list(){
        $company_id =$this->uri->segment('4');	
		$this->data['category'] = $this->payroll_file_maintenance_deductions_model->get_category_result();	
		$this->data['other_add_list'] = $this->payroll_file_maintenance_deductions_model->get_deduction_list_result();
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->load->view('app/payroll/file_maintenance/other_deductions/add_new_deduction_list',$this->data);
	}
 public function save_deduct_new_list(){	
    $other_deduction_code = $this->input->post('other_deduction_code');
    $other_deduction_type = $this->input->post('other_deduction_type');
	$company_id= $this->input->post('company_id');
	
    $this->form_validation->set_rules("other_deduction_code","Other Deductions","trim|required|callback_validate_deduct_list");
    $this->form_validation->set_rules("other_deduction_type","Other Deductions","trim|required|callback_validate_deduct_list_type");
	$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->payroll_file_maintenance_deductions_model->AddNewDeductList();
			// logfile
			$value = $this->input->post('other_deduction_code');
			General::logfile('This','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> This, <strong>".$value."</strong>, is Successfully Added!</div>");
		
		$this->session->set_flashdata('onload',"view(".$company_id.")");
		redirect(base_url().'app/payroll_file_maintenance_deductions/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		

     }

    public function validate_deduct_list(){
		$value = $this->input->post('other_deduction_code');
		 $company_id =$this->input->post('company_id');		
		
		if($this->payroll_file_maintenance_deductions_model->validate_deduct_list()){
			$this->form_validation->set_message("validate_deduct_list"," Other Deductions, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
			
	}
	public function validate_deduct_list_type(){
		$value = $this->input->post('other_deduction_type');
		 $company_id =$this->input->post('company_id');		
		
		if($this->payroll_file_maintenance_deductions_model->validate_deduct_list_type()){
			$this->form_validation->set_message("validate_deduct_list_type"," Other Deductions, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
			
	}

//=============================================OTHER DEDUCTION EDIT LIST==================================================

public function deduction_list_table_edit(){

	$id	= $this->uri->segment("4");	
	$this->data['table_deduct_list'] 	= $this->payroll_file_maintenance_deductions_model->get_table_list($id);
	$table_deduct_list 			= $this->payroll_file_maintenance_deductions_model->get_table_list($id);		 
	$company_id							= $table_deduct_list[0]->company_id;
	$this->data['category'] = $this->payroll_file_maintenance_deductions_model->get_edit_category_result($company_id);
		$this->load->view('app/payroll/file_maintenance/other_deductions/deduction_list_table_edit',$this->data);			
	}

public function list_edit_deduct_save(){	 
		$other_deduction_code = $this->input->post('other_deduction_code');
		$other_deduction_type = $this->input->post('other_deduction_type');
		$company_id= $this->input->post('company_id');
		$this->form_validation->set_rules("other_deduction_code","Other Deductions","trim|required|callback_validate_edit_deduct_list");
		$this->form_validation->set_rules("other_deduction_type","Other Deductions","trim|required|callback_validate_edit_deduct_list_type");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		
		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$this->payroll_file_maintenance_deductions_model->list_table_deduct_edit($id);

			// logfile
			$company_id=$company_id;
			$value = $other_deduction_code;
			General::logfile('This','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The row, <strong>".$value."</strong>, is Successfully Modified!</div>");

			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/payroll_file_maintenance_deductions/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		

	}

	public function validate_edit_deduct_list(){
		$id = $this->uri->segment("4");
		$value = $this->input->post('other_deduction_code');
		 $company_id =$this->input->post('company_id');
		if($this->payroll_file_maintenance_deductions_model->validate_edit_deduct_list($id)){
			$this->form_validation->set_message("validate_edit_deduct_list"," Other Deductions List, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}
	public function validate_edit_deduct_list_type(){
		$id = $this->uri->segment("4");
		$value = $this->input->post('other_deduction_type');
		 $company_id =$this->input->post('company_id');
		if($this->payroll_file_maintenance_deductions_model->validate_edit_deduct_list_type($id)){
			$this->form_validation->set_message("validate_edit_deduct_list_type"," Other Deductions List, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}
//DEACTIVATEandACTIVATE OTHER DEDUCTIONS CATEGORY==========================================================
	public function deactivate_other_deduction(){

		$id = $this->uri->segment("4");
		$category = $this->payroll_file_maintenance_deductions_model->delete($id);

		$this->payroll_file_maintenance_deductions_model->deactivate($id);

		// logfile
		$value = $categories->category." (".$categories->id.")";

		General::logfile('Other Deductions Category','DISABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Deactivated!</div>");

		redirect(base_url().'app/payroll_file_maintenance_additions/index',$this->data);
	}

	public function activate_other_deduction(){

		$id = $this->uri->segment("4");
		$category = $this->payroll_file_maintenance_deductions_model->delete($id);

		$this->payroll_file_maintenance_deductions_model->activate($id);

		// logfile
		$value = $categories->category." (".$categories->id.")";

		General::logfile('Other Deductions Category','ENABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Activated!</div>");

		redirect(base_url().'app/payroll_file_maintenance_additions/index',$this->data);
	}

//DEACTIVATEandACTIVATE OTHER DEDUCTIONS LIST==========================================================
	public function deactivate_other_deduction_list(){

		$id = $this->uri->segment("4");
		$other_deduction_code = $this->payroll_file_maintenance_deductions_model->delete_lists($id);

		$this->payroll_file_maintenance_deductions_model->deactivate_list($id);

		// logfile
		$value = $deductlist->other_deduction_code." (".$deductlist->id.")";

		General::logfile('Other Deductions List','DISABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Deactivated!</div>");

		redirect(base_url().'app/payroll_file_maintenance_additions/index',$this->data);
	}

	public function activate_other_deduction_list(){

		$id = $this->uri->segment("4");
		$other_deduction_code = $this->payroll_file_maintenance_deductions_model->delete_lists($id);

		$this->payroll_file_maintenance_deductions_model->activate_list($id);

		// logfile
		$value = $deductlist->other_deduction_code." (".$deductlist->id.")";

		General::logfile('Other Deductions List','ENABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Activated!</div>");

		redirect(base_url().'app/payroll_file_maintenance_additions/index',$this->data);
	}



//======================OTHER DEDUCTION DELETE LIST================================================
 public function delete_list(){

		$id = $this->uri->segment("4");
		$other_addition_code = $addlist->other_addition_code;

					$this->db->query("delete from other_addition_type where id = ".$id);
				
					
					$value = $other_addition_code;
				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  The Other Deductions List selected has successfully deleted.</div>");

		redirect(base_url().'app/payroll_file_maintenance_additions/index',$this->data);
	}
//++++++++++++++++++++++++++++++++++++++++++++END OF LIST OTHER DEDUCTION++++++++++++++++++++++++++++++++++++++++++++

}//controller