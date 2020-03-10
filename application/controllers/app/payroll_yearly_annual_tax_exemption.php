<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Payroll_yearly_annual_tax_exemption extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/payroll_yearly_annual_tax_exemption_model");
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



//TAX RATES VIEW========================================================================================
public function annual_tax_rates_view(){	
		$company_id = $this->input->post('company_id');
		//$this->data['taxexemption_date'] 	=  $this->payroll_yearly_annual_tax_exemption_model->get_taxexemption_date($company_id); 
		$this->load->view('app/payroll/file_maintenance/yearly_annual_tax_rates/tax_rates_company_settings',$this->data);		
	}


//TAX EXEMPTION VIEW========================================================================================
public function annual_tax_exemption_view(){	
		$company_id = $this->input->post('company_id');
		// $this->data['taxexemption_date'] 	=  $this->payroll_yearly_annual_tax_exemption_model->get_taxexemption_date($company_id); 
		$this->load->view('app/payroll/file_maintenance/yearly_annual_tax_exemption/tax_exemption_company_settings',$this->data);		
	}

public function show_annual_tax_exemption(){	
		
	
		$company_id = $this->uri->segment('4');
		$this->data['company_id']=$company_id;
		$this->data['compInfo']=$this->general_model->get_company_info($company_id);
		$this->load->view('app/payroll/file_maintenance/yearly_annual_tax_exemption/view',$this->data);
	}


public function editExemption($company_id,$val){

		$this->data['company_id']=$company_id;
		$this->data['taxcode_id']=$val;
		$this->data['t']=$this->payroll_yearly_annual_tax_exemption_model->getExemption($val);
		$this->load->view('app/payroll/file_maintenance/yearly_annual_tax_exemption/edit',$this->data);
}

public function saveExemption(){
	$did_exist=$this->input->post('did_exist');
	$company_id=$this->input->post('company_id');
	$taxcode_id=$this->input->post('taxcode_id');
	$total=$this->input->post('total');

	if($did_exist>0){
		$id=$this->input->post('id');
		$this->payroll_yearly_annual_tax_exemption_model->saveExemption($total,$id);
		$value = $id;
	}else{
		$id=$this->input->post('id');
		$this->payroll_yearly_annual_tax_exemption_model->addExemption($total,$taxcode_id,$company_id);
		$value = $company_id."|".$taxcode_id;		
	}


	
	// logfile
	

	$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Successfully Updated!</div>");
	$this->session->set_flashdata('onload',"gotoPages('".$company_id."')");
	redirect(base_url().'app/payroll_yearly_annual_tax_exemption/index',$this->data);

}

// ================================================end official


// public function load_locations(){
// 		$id = $this->uri->segment('4');
// 		$this->data['comp_id'] = $this->payroll_yearly_annual_tax_exemption_model->load_locations($id);
// 		$this->load->view('app/payroll/file_maintenance/yearly_annual_tax_exemption/location_list',$this->data);
// 	}	



// public function taxexemption_table_result(){	
		
// 		$company_id = $this->uri->segment('4');
// 		$location = $this->uri->segment('5');
// 		$date	= $this->uri->segment('6');	
// 		$this->data['taxexemptionLists'] = $this->payroll_yearly_annual_tax_exemption_model->load_annual_tax_exemption_result($date,$location,$company_id);
// 		$this->load->view('app/payroll/file_maintenance/yearly_annual_tax_exemption/taxexemption_table_result',$this->data);		
// 	}
// //DEACTIVATEandACTIVATE =================================================================
// 	public function deactivate_tax_exemption(){

// 		$id = $this->uri->segment("4");
// 		$tax_code = $this->payroll_yearly_annual_tax_exemption_model->delete($id);

// 		$this->payroll_yearly_annual_tax_exemption_model->deactivate($id);

// 		// logfile
// 		$value = $taxexem->tax_code." (".$id.")";

// 		General::logfile('Annual Tax Exemption','DISABLED',$value);
			
// 		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Deactivated!</div>");

// 		redirect(base_url().'app/payroll_yearly_annual_tax_exemption/index',$this->data);
// 	}

// 	public function activate_tax_exemption(){

// 		$id = $this->uri->segment("4");
// 		$tax_code = $this->payroll_yearly_annual_tax_exemption_model->delete($id);

// 		$this->payroll_yearly_annual_tax_exemption_model->activate($id);

// 		// logfile
// 		$value = $taxexem->tax_code." (".$id.")";

// 		General::logfile('Annual Tax Exemption','ENABLED',$value);
			
// 		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> <strong>".$value."</strong> is Successfully Activated!</div>");

// 		redirect(base_url().'app/payroll_yearly_annual_tax_exemption/index',$this->data);
// 	}


// ///DELETE tax exemption======================================================================================	
//  public function delete_tax_exemption(){

// 		$id = $this->uri->segment("4");
// 		$tax_code = $taxexem->tax_code;

// 					$this->db->query("delete from yearly_annual_tax_exemption where id = ".$id);
				
					
// 					$value = $tax_code;
// 				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>  The The tax Exemption  <strong>".$value."</strong> selected has successfully deleted.</div>");

// 		redirect(base_url().'app/payroll_yearly_annual_tax_exemption/index',$this->data);
// 	}

// //ADD NEW Tax Exemption=======================================================================================
//  public function add_new_tax_exemption(){
       
// 		$location = $this->uri->segment('4');
//  		$company_id =$this->uri->segment('5');	
 		
// 		$this->data['tax_codes'] = $this->payroll_yearly_annual_tax_exemption_model->gettaxcodeList();
// 		//$this->data['company_classifications']= $this->general_model->get_company_classifications($company_id);
// 		$this->load->view('app/payroll/file_maintenance/yearly_annual_tax_exemption/add_new_tax_exemption_table',$this->data);
// 	}
	
//  public function save_add_new_tax_exemption()
//     {	
//     	$taxcode_id = $this->input->post('taxcode_id');
//     	$tax_code = $this->input->post('tax_code');
//     	$new_tax = $this->input->post('new_tax');
// 		$company_id= $this->input->post('company_id');
	
//     	$this->form_validation->set_rules("tax_code","Tax Code","trim|required|callback_validate_tax_code");
// 		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

// 		if($this->form_validation->run()){

// 			// save data
// 			$this->payroll_yearly_annual_tax_exemption_model->AddNewTaxCode();
// 			// logfile
// 			$value = $this->input->post('tax_code');
// 			General::logfile('This','INSERT',$value);
			
// 			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> This, <strong>".$value."</strong>, is Successfully Added!</div>");
		
// 		$this->session->set_flashdata('onload',"view(".$company_id.")");
// 		redirect(base_url().'app/payroll_yearly_annual_tax_exemption/index',$this->data);
// 		}else{
// 			$this->session->set_flashdata('onload',"view(".$company_id.")");
// 			$this->index();
// 		}		

//      }

//     public function validate_tax_code(){
// 		$annual_year = (date('Y', strtotime(date("Y-m-d"))));
// 		$company_id =$this->input->post('company_id');		
// 		$company_id =$this->input->post('taxcode_id');		
// 		$location = $this->input->post('location_id');		
// 		$value = $this->input->post('tax_code');
// 		if($this->payroll_yearly_annual_tax_exemption_model->validate_tax_code()){
// 			$this->form_validation->set_message("validate_tax_code"," Tax Exemption, <strong>".$value."</strong>, Already Exists.");
// 			return false;
// 		}else{
// 			return true;
// 		}
			
// 	}


// //CATEGORY EDIT===================================================================================

// public function tax_exemption_table_edit(){

//        	$company_id = $this->uri->segment('6');
// 		$location = $this->uri->segment('5');
// 		$id	= $this->uri->segment("4");	
// 		$this->data['edittaxexemptionList'] = $this->payroll_yearly_annual_tax_exemption_model->get_table_tax_exemption($id);
		
// 		$this->load->view('app/payroll/file_maintenance/yearly_annual_tax_exemption/tax_exemption_table_edit',$this->data);			
// 	}

// public function tax_exemption_edit_save(){	 
// 		$tax_code = $this->input->post('tax_code');
// 		$new_tax = $this->input->post('new_tax');
// 		$company_id= $this->input->post('company_id');
// 		$this->form_validation->set_rules("tax_code","Tax Exemption","trim|required|callback_validate_edit_tax_code");
// 		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		
// 		if($this->form_validation->run()){

// 			$id = $this->uri->segment("4");

// 			// modify data
// 			$this->payroll_yearly_annual_tax_exemption_model->tax_exemption_table_edit($id);

// 			// logfile
// 			$company_id=$company_id;
// 			$value = $tax_code;
// 			General::logfile('This','UPDATE',$value);
			
// 			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> The row, <strong>".$value."</strong>, is Successfully Modified!</div>");

// 			$this->session->set_flashdata('onload',"view(".$company_id.")");
// 			redirect(base_url().'app/payroll_yearly_annual_tax_exemption/index',$this->data);
// 		}else{
// 			$this->session->set_flashdata('onload',"view(".$company_id.")");
// 			$this->index();
// 		}		

// 	}

// 	public function validate_edit_tax_code(){
// 		$id = $this->uri->segment("4");
// 		$value = $this->input->post('tax_code');
// 		$annual_year = $this->input->post('annual_year');
// 		$company_id =$this->input->post('company_id');		
// 		$location = $this->input->post('location');	
// 		if($this->payroll_yearly_annual_tax_exemption_model->validate_edit_tax_code($id)){
// 			$this->form_validation->set_message("validate_edit_tax_code"," Tax Code, <strong>".$value."</strong>, Already Exists.");
// 			return false;
// 		}else{
// 			return true;
// 		}
// 	}


}//controller