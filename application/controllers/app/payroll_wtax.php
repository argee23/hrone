<!-- by: blusquall -->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Payroll_wtax extends General{

	function __construct(){
		parent::__construct();	
		date_default_timezone_set("Asia/Manila");
		$this->load->model("app/payroll_wtax_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){		

		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view("app/payroll/wtax/index",$this->data);
	}

	public function get_tax_tier_info($pay_type,$order){

		$this->data["tax_tier_info"] = $this->payroll_wtax_model->get_tax_tier_info($pay_type,$order);
		$this->load->view("app/payroll/wtax/edit_tier_info",$this->data);
	}

	public function modify_tier_info(){

		$this->payroll_wtax_model->modify_tier_info();

		redirect(base_url().'app/payroll_wtax',$this->data);
	}

	public function add_tax_tier(){

		$max_no = $this->payroll_wtax_model->get_max_order_no($this->input->post("pay_type_id"));
		if($max_no){
			$order_no = $max_no->order_no;
		}else{
			$order_no = 0;
		}

		$this->payroll_wtax_model->add_tax_tier($order_no);
				
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Tax Bracket is Successfully Added!</div>");

		redirect(base_url().'app/payroll_wtax',$this->data);
	}

	public function company_tax($company){

		$this->data["company"] = $this->payroll_wtax_model->get_company_info($company);
		$this->data["locations"] = $this->payroll_wtax_model->get_company_location($company);
		if ($this->db->table_exists("tax_table_".$company)){
			$this->data["payType"] = $this->payroll_wtax_model->get_pay_type_per_company($company);
			$this->data["salaryRate"] = $this->payroll_wtax_model->get_salary_rate_per_company($company);
		}
		$this->load->view("app/payroll/wtax/company_tax",$this->data);
	}

	public function get_pay_types($company){
		
		$this->data["company"] = $this->payroll_wtax_model->get_company_info($company);
		$this->load->view("app/payroll/wtax/pay_types_selection",$this->data);
	}

	public function add_tax_table(){

		$this->payroll_wtax_model->add_tax_table();

		foreach ($this->input->post("salary_rate") as $key => $salary_rate) {

			foreach ($this->input->post("pay_type") as $key => $value) {

				$check_pay_type = $this->payroll_wtax_model->check_pay_type($value,$salary_rate);

				if($check_pay_type == 0){

					$get_pay_type_table = $this->payroll_wtax_model->get_pay_type_table($value);

					foreach ($get_pay_type_table as $pay_type_table) {
						
						$data = array(
							"salary_rate"			=>		$salary_rate,
							"tax_table_id"			=>		$pay_type_table->tax_table_id,
							"pay_type"				=>		$pay_type_table->pay_type,
							"order_no"				=>		$pay_type_table->order_no,
							"exempt_percentage"		=>		$pay_type_table->exempt_percentage,
							"exempt_value"			=>		$pay_type_table->exempt_value,
							"tax_code_1"			=>		$pay_type_table->tax_code_1,
							"tax_code_2"			=>		$pay_type_table->tax_code_2,
							"tax_code_3"			=>		$pay_type_table->tax_code_3,
							"tax_code_4"			=>		$pay_type_table->tax_code_4,
							"tax_code_5"			=>		$pay_type_table->tax_code_5,
							"tax_code_6"			=>		$pay_type_table->tax_code_6
							);
						$data = $this->security->xss_clean($data);
						$this->payroll_wtax_model->insert_tax_tables($data);
					}
				}
			}
		}
				
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Tax Tables Are Successfully Added!</div>");

		$this->session->set_flashdata('onload',"loadCompanyView(".$this->input->post('company_id').")");

		redirect(base_url().'app/payroll_wtax',$this->data);
	}

	public function add_tax_tier_c(){

		$max_no = $this->payroll_wtax_model->get_max_order_no_c($this->input->post("pay_type_id"));
		if($max_no){
			$order_no = $max_no->order_no;
		}else{
			$order_no = 0;
		}

		$this->payroll_wtax_model->add_tax_tier_c($order_no);
				
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Tax Bracket is Successfully Added!</div>");

		$this->session->set_flashdata('onload',"loadCompanyView(".$this->input->post('company_id').")");

		redirect(base_url().'app/payroll_wtax',$this->data);
	}

	public function get_tax_tier_info_c($pay_type,$order,$company,$salary){

		$this->data["company"] = $this->payroll_wtax_model->get_company_info($company);
		$this->data["tax_tier_info"] = $this->payroll_wtax_model->get_tax_tier_info_c($pay_type,$order,$company,$salary);
		$this->load->view("app/payroll/wtax/edit_tier_info_c",$this->data);
	}

	public function modify_tier_info_c(){

		$this->payroll_wtax_model->modify_tier_info_c();
				
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Tax Info is Successfully Modified!</div>");

		$this->session->set_flashdata('onload',"loadCompanyView(".$this->input->post('company_id').")");

		redirect(base_url().'app/payroll_wtax',$this->data);
	}

	public function edit_minimum($company,$location){

		$this->data["minimum"] = $this->payroll_wtax_model->get_location_minimum($company,$location);
		$this->data["location"] = $this->payroll_wtax_model->get_location_name($location);
		$this->data["location_id"] = $location;
		$this->data["company_id"] = $company;

		$this->load->view("app/payroll/wtax/edit_minimum",$this->data);
	}

	public function add_minimum(){

		$this->payroll_wtax_model->add_minimum();
				
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Daily Minimum Wage is Successfully Added!</div>");

		$this->session->set_flashdata('onload',"loadCompanyView(".$this->input->post('company_id').")");

		redirect(base_url().'app/payroll_wtax',$this->data);

	}

	public function modify_minimum(){

		$this->payroll_wtax_model->modify_minimum();
				
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Daily Minimum Wage is Successfully Modified!</div>");

		$this->session->set_flashdata('onload',"loadCompanyView(".$this->input->post('company_id').")");

		redirect(base_url().'app/payroll_wtax',$this->data);

	}




}//end controller