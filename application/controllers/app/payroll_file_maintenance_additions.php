<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Payroll_file_maintenance_additions extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/payroll_file_maintenance_additions_model");
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
public function other_additions_view(){	 
		$this->load->view('app/payroll/file_maintenance/other_additions/other_addition_company_settings',$this->data);		
	}

public function other_addition_select_option(){	 
		$this->load->view('app/payroll/file_maintenance/other_additions/other_addition_select_option',$this->data);		
	}

//OTHER ADDITION CATEGORY VIEW========================================================================================
public function other_addition_category_view(){	 
	//	$company_id=$this->uri->segment('4');
	//	$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->data['category'] = $this->payroll_file_maintenance_additions_model->get_category_result();
		$this->load->view('app/payroll/file_maintenance/other_additions/other_addition_category_view',$this->data);		
	}

//ADD NEW CATEGORY=======================================================================================
public function add_new_addition_category(){
        $company_id =$this->uri->segment('4');		
		$this->data['category'] = $this->payroll_file_maintenance_additions_model->get_category_result();
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->load->view('app/payroll/file_maintenance/other_additions/add_new_addition_category',$this->data);
	}
 public function save_add_new_addition_category()
    {	
    	$category = $this->input->post('category');
		$company_id= $this->input->post('company_id');
	
    	$this->form_validation->set_rules("category","Other Additions Category","trim|required|callback_validate_addition_category");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->payroll_file_maintenance_additions_model->AddNewAdditionCategory();
			// logfile
			$value = $this->input->post('category');
			General::logfile('This','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> This, <strong>".$value."</strong>, is Successfully Added!</div>");
		
		$this->session->set_flashdata('onload',"view(".$company_id.")");
		redirect(base_url().'app/payroll_file_maintenance_additions/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		

     }

    public function validate_addition_category(){
		$value = $this->input->post('category');
		 $company_id =$this->input->post('company_id');		
		
		if($this->payroll_file_maintenance_additions_model->validate_addition_category()){
			$this->form_validation->set_message("validate_addition_category"," Other Additions Category, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
			
	}


//=============================================EDIT CATEGORY==================================================

public function addition_category_table_edit(){

        $company_id =$this->uri->segment('4');
		$id	= $this->uri->segment("4");	
		$this->data['table_category'] 			= $this->payroll_file_maintenance_additions_model->get_table_category($id);
		$company 							= $this->payroll_file_maintenance_additions_model->get_category_company($company_id);
		//$table_loan 							= $this->payroll_file_maintenance_additions_model->get_table_category($id);
		//	$company_id							= $company[0]->company_id;
		$this->load->view('app/payroll/file_maintenance/other_additions/addition_category_table_edit',$this->data);			
	}

public function addition_category_edit_save(){	 
		$category = $this->input->post('category');
		$company_id= $this->input->post('company_id');
		$this->form_validation->set_rules("category","Other Additions Category","trim|required|callback_validate_edit_addition_category");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		
		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$this->payroll_file_maintenance_additions_model->category_table_addition_edit($id);

			// logfile
			$company_id=$company_id;
			$value = $category;
			General::logfile('This','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The row, <strong>".$value."</strong>, is Successfully Modified!</div>");

			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/payroll_file_maintenance_additions/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		

	}

	public function validate_edit_addition_category(){
		$id = $this->uri->segment("4");
		$value = $this->input->post('category');
		 $company_id =$this->input->post('company_id');
		if($this->payroll_file_maintenance_additions_model->validate_edit_addition_category($id)){
			$this->form_validation->set_message("validate_edit_addition_category"," Other Additions Category, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}

//DEACTIVATEandACTIVATE OTHER ADDITIONS CATEGORY==============================================================
	public function deactivate_other_addition(){

		$id = $this->uri->segment("4");
		$category = $this->payroll_file_maintenance_additions_model->delete($id);

		$this->payroll_file_maintenance_additions_model->deactivate($id);

		// logfile
		$value = $categories->category." (".$categories->id.")";

		General::logfile('Other Additions Category','DISABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Deactivated!</div>");

		redirect(base_url().'app/payroll_file_maintenance_additions/index',$this->data);
	}

	public function activate_other_addition(){

		$id = $this->uri->segment("4");
		$category = $this->payroll_file_maintenance_additions_model->delete($id);

		$this->payroll_file_maintenance_additions_model->activate($id);

		// logfile
		$value = $categories->category." (".$categories->id.")";

		General::logfile('Other Additions Category','ENABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Activated!</div>");

		redirect(base_url().'app/payroll_file_maintenance_additions/index',$this->data);
	}


//=====================================DELETE OTHER ADDITIONS CATEGORY====================================
 public function delete_category(){

		$id = $this->uri->segment("4");
		

					$this->db->query("delete from other_additions_category where id = ".$id);
				
					
					$value = $id;
				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  The Other Additions Category row ID <strong>".$value."</strong> has successfully deleted.</div>");

		redirect(base_url().'app/payroll_file_maintenance_additions/index',$this->data);
	}
//++++++++++++++++++++++++++++++++++++++++++END OF CATEGORY OTHER ADDITION=========================================

//+++++++++++++++++++++++++++++++++++++++++++START OF LIST OTHER ADDITION+++++++++++++++++++++++++++++++++++++++++++

public function other_addition_list(){	 
		$company_id=$this->uri->segment('4');

		$this->data['addition_list'] = $this->payroll_file_maintenance_additions_model->get_list_result();
		$this->load->view('app/payroll/file_maintenance/other_additions/other_addition_list',$this->data);		
	}


//ADD NEW CATEGORY=======================================================================================
public function add_new_addition_list(){
        $company_id =$this->uri->segment('4');	
		$this->data['category'] = $this->payroll_file_maintenance_additions_model->get_category_result();	
		$this->data['other_add_list'] = $this->payroll_file_maintenance_additions_model->get_addition_list_result();
		$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
		$this->load->view('app/payroll/file_maintenance/other_additions/add_new_addition_list',$this->data);
	}
 public function save_add_new_list()
    {	
    	$other_addition_code = $this->input->post('other_addition_code');
    	$other_addition_type = $this->input->post('other_addition_type');
		$company_id= $this->input->post('company_id');
	
    	$this->form_validation->set_rules("other_addition_code","Other Additions","trim|required|callback_validate_list");
    	$this->form_validation->set_rules("other_addition_type","Other Additions","trim|required|callback_validate_list_type");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			// save data
			$this->payroll_file_maintenance_additions_model->AddNewList();
			// logfile
			$value = $this->input->post('other_addition_code');
			General::logfile('This','INSERT',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> This, <strong>".$value."</strong>, is Successfully Added!</div>");
		
		$this->session->set_flashdata('onload',"view(".$company_id.")");
		redirect(base_url().'app/payroll_file_maintenance_additions/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		

     }

    public function validate_list(){
		$value = $this->input->post('other_addition_code');
		 $company_id =$this->input->post('company_id');		
		
		if($this->payroll_file_maintenance_additions_model->validate_list()){
			$this->form_validation->set_message("validate_list"," Other Addition, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
			
	}
 	public function validate_list_type(){
		$value = $this->input->post('other_addition_type');
		 $company_id =$this->input->post('company_id');		
		
		if($this->payroll_file_maintenance_additions_model->validate_list_type()){
			$this->form_validation->set_message("validate_list_type"," Other Addition, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
			
	}

//===================================OTHER ADDITION EDIT LIST============================================

public function addition_list_table_edit(){
		$id	= $this->uri->segment("4");	
		
		$this->data['table_list'] 			= $this->payroll_file_maintenance_additions_model->get_table_list($id);
		$table_list 			= $this->payroll_file_maintenance_additions_model->get_table_list($id);		 
		$company_id							= $table_list[0]->company_id;
		$this->data['category'] = $this->payroll_file_maintenance_additions_model->get_edit_category_result($company_id);
		$this->load->view('app/payroll/file_maintenance/other_additions/addition_list_table_edit',$this->data);			
	}

public function list_edit_save(){	 
		$other_addition_code = $this->input->post('other_addition_code');
		$other_addition_type = $this->input->post('other_addition_type');
		$company_id= $this->input->post('company_id');
		$this->form_validation->set_rules("other_addition_code","Other Additions","trim|required|callback_validate_edit_list");
		$this->form_validation->set_rules("other_addition_type","Other Additions","trim|required|callback_validate_edit_list_type");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		
		if($this->form_validation->run()){

			$id = $this->uri->segment("4");

			// modify data
			$this->payroll_file_maintenance_additions_model->list_table_edit($id);

			// logfile
			$company_id=$company_id;
			$value = $other_addition_code;
			General::logfile('This','UPDATE',$value);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The row, <strong>".$value."</strong>, is Successfully Modified!</div>");

			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/payroll_file_maintenance_additions/index',$this->data);
		}else{
			$this->session->set_flashdata('onload',"view(".$company_id.")");
			$this->index();
		}		

	}

	public function validate_edit_list(){
		$id = $this->uri->segment("4");
		$value = $this->input->post('other_addition_code');
		 $company_id =$this->input->post('company_id');
		if($this->payroll_file_maintenance_additions_model->validate_edit_list($id)){
			$this->form_validation->set_message("validate_edit_list"," Other Additions List, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}
	public function validate_edit_list_type(){
		$id = $this->uri->segment("4");
		$value = $this->input->post('other_addition_type');
		 $company_id =$this->input->post('company_id');
		if($this->payroll_file_maintenance_additions_model->validate_edit_list_type($id)){
			$this->form_validation->set_message("validate_edit_list_type"," Other Additions List, <strong>".$value."</strong>, Already Exists.");
			return false;
		}else{
			return true;
		}
	}
//====================================OTHER ADDITION DELETE LIST=============================================
 public function delete_list(){

		$id = $this->uri->segment("4");
		$other_addition_code = $addlist->other_addition_code;

					$this->db->query("delete from other_addition_type where id = ".$id);
				
					
					$value = $other_addition_code;
				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  The Other Additions List selected has successfully deleted.</div>");

		redirect(base_url().'app/payroll_file_maintenance_additions/index',$this->data);
	}

//DEACTIVATEandACTIVATE OTHER ADDITIONS LIST==============================================================
	public function deactivate_other_addition_list(){

		$id = $this->uri->segment("4");
		$other_addition_code = $this->payroll_file_maintenance_additions_model->delete_lists($id);

		$this->payroll_file_maintenance_additions_model->deactivate_list($id);

		// logfile
		$value = $addlist->other_addition_code." (".$addlist->id.")";

		General::logfile('Other Additions List','DISABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Deactivated!</div>");

		redirect(base_url().'app/payroll_file_maintenance_additions/index',$this->data);
	}

	public function activate_other_addition_list(){

		$id = $this->uri->segment("4");
		$other_addition_code = $this->payroll_file_maintenance_additions_model->delete_lists($id);

		$this->payroll_file_maintenance_additions_model->activate_list($id);

		// logfile
		$value = $addlist->other_addition_code." (".$addlist->id.")";

		General::logfile('Other Additions List','ENABLED',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Activated!</div>");

		redirect(base_url().'app/payroll_file_maintenance_additions/index',$this->data);
	}

//++++++++++++++++++++++++++++++++++++++++++++END OF LIST OTHER ADDITION++++++++++++++++++++++++++++++++++++++++++++

}//controller