<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); // blusquall

require APPPATH.'controllers/general.php'; 

class Payroll_formula extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/payroll_formula_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}

	public function index(){

		$this->data['variables'] = $this->payroll_formula_model->get_variables();
		$this->data['formulas'] = $this->payroll_formula_model->get_formula_tier();
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view("app/payroll/payroll_formula/index",$this->data);

	}

	public function search_company_onkeyup(){

		$val = $this->uri->segment("4");
		$this->data['company_info'] = $this->payroll_formula_model->search_company_onkeyup($val);
		$this->load->view("app/payroll/payroll_formula/search_company",$this->data);
	}

	public function get_company($id){

		$this->data['company'] = $this->payroll_formula_model->get_company($id);
		$this->data['locations'] = $this->payroll_formula_model->get_locations($id);
		$this->data['classifications'] = $this->payroll_formula_model->get_classifications($id);
		$this->load->view("app/payroll/payroll_formula/show_company",$this->data);
	}

	public function validate_formula_variable(){

		$value = $this->input->post('variable_name');
		if($this->payroll_formula_model->validate_formula_variable()){
			$this->form_validation->set_message("validate_formula_variable"," Payroll formula variable for, <strong>".$value."</strong> already exist!");
			return false;
		}else{
			return true;
		}
	}

	public function add_variable(){
		$this->form_validation->set_rules("variable_name","Variable Name","trim|required|callback_validate_formula_variable");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$this->payroll_formula_model->insert_variable();

			$value = $this->input->post('variable_name');
			General::logfile('Payroll Formula Variable','INSERT',$value);
				
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Payroll Formula Variable <strong>".$value."</strong>, is Successfully Added!</div>");

			redirect(base_url().'app/payroll_formula',$this->data);
		}else{

			$this->index();
		}
	}

	public function get_var_edit($id){

		$this->data["var"] = $this->payroll_formula_model->get_variable($id);
		$this->load->view("app/payroll/payroll_formula/edit_variable",$this->data);
	}

	public function validate_formula_variable_update(){

		$value = $this->input->post('variable_name');
		if($this->payroll_formula_model->validate_formula_variable_update()){
			$this->form_validation->set_message("validate_formula_variable_update"," Payroll formula variable for, <strong>".$value."</strong> already exist!");
			return false;
		}else{
			return true;
		}
	}

	public function update_variable(){
		$this->form_validation->set_rules("variable_name","Variable Name","trim|required|callback_validate_formula_variable_update");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");

		if($this->form_validation->run()){

			$this->payroll_formula_model->update_variable();

			$value = $this->input->post('variable_name');
			General::logfile('Payroll Formula Variable','MODIFY',$value);
				
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Payroll Formula Variable <strong>".$value."</strong>, is Successfully Modified!</div>");

			redirect(base_url().'app/payroll_formula',$this->data);
		}else{

			$this->index();
		}
	}

	public function add_formula(){
		//echo $this->input->post("formula");
		$this->payroll_formula_model->insert_formula();
				
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Payroll Formula is Successfully Added!</div>");

		redirect(base_url().'app/payroll_formula',$this->data);
	}

	public function view_formula_setup($where){

		$where = array(
			"company"				=>	$this->uri->segment("4"),
			// "location"				=>	$this->uri->segment("5"),
			// "classification"		=>	$this->uri->segment("6"),
			"employment"			=>	$this->uri->segment("5"),//dating 7
			"pay_type"				=>	$this->uri->segment("6"),//dating 8
			"salary_rate"			=>	$this->uri->segment("7"),//dating 9
			);
		//echo $this->uri->segment("5")." | ".$this->uri->segment("6")." | ".$this->uri->segment("7");
		$where  = $this->security->xss_clean($where);
		$this->data["formula_setup"] = $this->payroll_formula_model->formula_setup($where);
		$this->data["company"] = $this->payroll_formula_model->company($this->uri->segment("4"));
		//$this->data["location"] = $this->payroll_formula_model->location($this->uri->segment("5"));
		//$this->data["classification"] = $this->payroll_formula_model->classification($this->uri->segment("6"));
		$this->data["employment"] = $this->payroll_formula_model->employment($this->uri->segment("5"));
		$this->data["pay_type"] = $this->payroll_formula_model->pay_type($this->uri->segment("6"));
		$this->data["salary_rate"] = $this->payroll_formula_model->salary_rate($this->uri->segment("7"));
		$this->data["formula_tier"] = $this->payroll_formula_model->formula_tier();
		$this->data["formula_tier_2"] = $this->payroll_formula_model->formula_tier_2();
		$this->data['variables'] = $this->payroll_formula_model->get_variables();
		$this->data['formulas'] = $this->payroll_formula_model->get_formula_tier();
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view("app/payroll/payroll_formula/formula_setup",$this->data);
	}

	public function delete_formula($id){

		$this->db->where("formula_id",$id);
		$this->db->set("InActive",1);
		$this->db->update("payroll_formulas");
				
		$this->session->set_flashdata('message',"<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Payroll Formula is Successfully Deleted!</div>");

		redirect(base_url().'app/payroll_formula',$this->data);

	}

	public function save_formula_setup(){

		$this->payroll_formula_model->save_formula_setup();

		// $setup_view = $this->input->post("company_id")."/".$this->input->post("location_id")."/".$this->input->post("classification_id")."/".$this->input->post("employment_id")."/".$this->input->post("pay_type_id")."/".$this->input->post("salary_rate_id");
				
		$setup_view = $this->input->post("company_id")."/".$this->input->post("employment_id")."/".$this->input->post("pay_type_id")."/".$this->input->post("salary_rate_id");
				
		$this->session->set_flashdata('message',"<div class='alert alert-info alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Payroll Formula Setup is Successfully Saved!</div>");

		redirect(base_url().'app/payroll_formula/view_formula_setup/'.$setup_view,$this->data);

	}

	public function change_formula($links){

		$setup = $this->uri->segment("4");
		$name = $this->uri->segment("5");

		// if($name=="deduction_sum_formula"){
		// 	$id = $this->uri->segment("6");//7
		// 	$tier = $this->uri->segment("7");//6
		// }else{// below standard.
			$id = $this->uri->segment("6");
			$tier = $this->uri->segment("7");			
		//}

		$company = $this->uri->segment("8");
		// 15 | income_sum_formula | 18 | 18 | 1 |
		// 
		//echo "$setup | $name | $tier | $id | $company |";
		// $location = $this->uri->segment("9");
		// $classification = $this->uri->segment("10");
		$employment = $this->uri->segment("9");// 11
		$pay_type = $this->uri->segment("10");//12
		$salary_rate = $this->uri->segment("11");//13
		//echo "$setup | $name | $id | $tier | $company | $location | $classification | $employment | $pay_type | $salary_rate";
		$this->data["tier_formulas"] = $this->payroll_formula_model->get_formula_by_tier($tier);
		$this->data["tier_name"] = $this->payroll_formula_model->tier_name($tier);
		$this->data["company"] = $this->payroll_formula_model->company($company);
		$this->data["tier_formula_id"] = $id;
		$this->data["setup_formula"] = $name;
		$this->data["id"] = $id;
		$this->data["setup"] = $setup;
		$this->data["company_id"] = $company;
		// $this->data["location_id"] = $location;
		// $this->data["classification_id"] = $classification;
		$this->data["employment_id"] = $employment;
		$this->data["pay_type_id"] = $pay_type;
		$this->data["salary_rate_id"] = $salary_rate;

		$this->load->view("app/payroll/payroll_formula/modify_formula",$this->data);
	}

	public function update_setup_formula(){
// echo $this->input->post("setup_formula");

		// $where = $this->input->post("company_id")."/".$this->input->post("location_id")."/".$this->input->post("classification_id")."/".$this->input->post("employment_id")."/".$this->input->post("pay_type_id")."/".$this->input->post("salary_rate_id");

		$where = $this->input->post("company_id")."/".$this->input->post("employment_id")."/".$this->input->post("pay_type_id")."/".$this->input->post("salary_rate_id");

		$this->payroll_formula_model->update_setup_formula();
				
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Payroll Formula Setup is Successfully Modified!</div>");

		redirect(base_url().'app/payroll_formula/view_formula_setup/'.$where,$this->data);


	}
}