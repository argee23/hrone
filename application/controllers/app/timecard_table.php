<!-- by: blusquall -->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Timecard_table extends General{

	function __construct(){
		parent::__construct();	
		date_default_timezone_set("Asia/Manila");
		$this->load->model("app/timecard_table_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){		

		$this->data["timecard_description"] = $this->timecard_table_model->timecard_description();
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view("app/payroll/timecard/index",$this->data);
	}

	public function add_description(){

		$this->timecard_table_model->add_description();

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Timecard/Overtime Description is Successfully Added!</div>");

		$this->session->set_flashdata('onload',"showCollapse()");

		redirect(base_url().'app/timecard_table',$this->data);
	}

	public function edit_timecard($id){

		$this->data["time_card"] = $this->timecard_table_model->timecard_description_info($id);
		$this->load->view("app/payroll/timecard/edit_timecard",$this->data);
	}

	public function modify_timecard(){

		$this->timecard_table_model->modify_timecard();

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Timecard/Overtime Description is Successfully Modified!</div>");

		$this->session->set_flashdata('onload',"showCollapse()");

		redirect(base_url().'app/timecard_table',$this->data);
	}


	public function company_timecard($company){

		$this->data["timecard_description"] = $this->timecard_table_model->timecard_description();
		$this->data["company"] = $this->timecard_table_model->get_company_info($company);
		if ($this->db->table_exists("timecard_table_".$company)){
			$this->data["payType"] = $this->timecard_table_model->get_pay_type_per_company($company);
			$this->data["salaryRate"] = $this->timecard_table_model->get_salary_rate_per_company($company);
			$this->data["employment"] = $this->timecard_table_model->get_employment_per_company($company);
		}
		$this->load->view("app/payroll/timecard/company_timecard",$this->data);
	}

	public function get_pay_types($company){
		
		$this->data["company"] = $this->timecard_table_model->get_company_info($company);
		$this->data["timecard_table"] = $this->timecard_table_model->standard_timecard_tables();
		$this->load->view("app/payroll/timecard/pay_types_selection",$this->data);
	}

	public function add_to_table($pt,$e,$ti){

		$this->data["pt"] = $this->timecard_table_model->get_pay_type($pt);
		$this->data["e"] = $this->timecard_table_model->get_employment($e);
		$this->data["ti"] = $this->timecard_table_model->get_timecard($ti);

		$this->load->view("app/payroll/timecard/add_to_table",$this->data);
	}

	public function add_to_table_c($pt,$e,$ti,$sr){

		$this->data["pt"] = $this->timecard_table_model->get_pay_type($pt);
		$this->data["e"] = $this->timecard_table_model->get_employment($e);
		$this->data["ti"] = $this->timecard_table_model->get_timecard($ti);
		$this->data["st"] = $this->timecard_table_model->get_salary_rate($sr);

		$this->load->view("app/payroll/timecard/add_to_table_c",$this->data);
	}

	public function add_to_timecard_table(){

		$data = array(
			"employment"		=>	$this->input->post("employment"),
			"pay_type"			=>	$this->input->post("pay_type"),
			"timecard_id"		=>	$this->input->post("timecard_id"),
			"reg_nd"			=>	$this->input->post("reg_nd"),
			"reg_wnd"			=>	$this->input->post("reg_wnd"),
			"ot_nd"				=>	$this->input->post("ot_nd"),
			"ot_wnd"			=>	$this->input->post("ot_wnd")
			);

		$data = $this->security->xss_clean($data);
		$this->timecard_table_model->insert_to_standard($data);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Timecard/Overtime Value is Successfully Modified!</div>");

		$this->session->set_flashdata('onload',"showCollapse2()");

		redirect(base_url().'app/timecard_table',$this->data);
	}

	// public function add_to_timecard_table_c(){

	// 	$data = array(
	// 		"employment"		=>	$this->input->post("employment"),
	// 		"pay_type"			=>	$this->input->post("pay_type"),
	// 		"timecard_id"		=>	$this->input->post("timecard_id"),
	// 		"reg_nd"			=>	$this->input->post("reg_nd"),
	// 		"reg_wnd"			=>	$this->input->post("reg_wnd"),
	// 		"ot_nd"				=>	$this->input->post("ot_nd"),
	// 		"ot_wnd"			=>	$this->input->post("ot_wnd")
	// 		);

	// 	$data = $this->security->xss_clean($data);
	// 	$this->timecard_table_model->insert_to_company($data);

	// 	$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Timecard/Overtime Value is Successfully Modified!</div>");

	// 	$this->session->set_flashdata('onload',"showCollapse2()");

	// 	redirect(base_url().'app/timecard_table',$this->data);
	// }

	public function edit_to_table($id){

		$this->data["timecard_data"] = $this->timecard_table_model->get_timecard_data($id);

		$this->load->view("app/payroll/timecard/edit_to_table",$this->data);
	}

	public function edit_to_table_c($id,$company){

		$this->data["timecard_data"] = $this->timecard_table_model->get_timecard_data_c($id,$company);
		$this->data["company"] = $company;

		$this->load->view("app/payroll/timecard/edit_to_table_c",$this->data);
	}

	public function edit_to_timecard_table(){

		$data = array(
			"reg_nd"			=>	$this->input->post("reg_nd"),
			"reg_wnd"			=>	$this->input->post("reg_wnd"),
			"ot_nd"				=>	$this->input->post("ot_nd"),
			"ot_wnd"			=>	$this->input->post("ot_wnd")
			);

		$data = $this->security->xss_clean($data);
		$this->timecard_table_model->modify_to_standard($data);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Timecard/Overtime Value is Successfully Modified!</div>");

		$this->session->set_flashdata('onload',"showCollapse2()");

		redirect(base_url().'app/timecard_table',$this->data);
	}

	public function edit_to_timecard_table_c(){

		$data = array(
			"reg_nd"			=>	$this->input->post("reg_nd"),
			"reg_wnd"			=>	$this->input->post("reg_wnd"),
			"ot_nd"				=>	$this->input->post("ot_nd"),
			"ot_wnd"			=>	$this->input->post("ot_wnd")
			);

		$data = $this->security->xss_clean($data);
		$this->timecard_table_model->modify_to_company($data);

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Company Timecard/Overtime Value is Successfully Modified!</div>");

		$this->session->set_flashdata('onload',"loadCompanyView(".$this->input->post('company').")");

		redirect(base_url().'app/timecard_table',$this->data);
	}

	public function add_timecard_table(){

		$this->timecard_table_model->add_timecard_table();

		// foreach ($this->input->post("salary_rate") as $key => $salary_rate){

		// 	foreach($this->input->post("pay_type") as $key => $pay_type){

		// 		foreach ($this->input->post("employment") as $key => $employment) {

		// 			$check_pay_type = $this->timecard_table_model->check_pay_type($employment,$salary_rate,$pay_type);

		// 			if($check_pay_type == 0){

		// 				$get_pay_type_table = $this->timecard_table_model->get_pay_type_table($pay_type,$employment);

		// 				if($get_pay_type_table){
		// 					foreach ($get_pay_type_table as $pay_type_table) {
						
		// 					$data = array(
		// 						"salary_rate"			=>		$salary_rate,
		// 						"timecard_table_id"		=>		$pay_type_table->id,
		// 						"pay_type"				=>		$pay_type_table->pay_type,
		// 						"employment"			=>		$pay_type_table->employment,
		// 						"timecard_id"			=>		$pay_type_table->timecard_id,
		// 						"reg_nd"				=>		$pay_type_table->reg_nd,
		// 						"reg_wnd"				=>		$pay_type_table->reg_wnd,
		// 						"ot_nd"					=>		$pay_type_table->ot_nd,
		// 						"ot_wnd"				=>		$pay_type_table->ot_wnd,
		// 						);
		// 					$data = $this->security->xss_clean($data);
		// 					$this->timecard_table_model->insert_timecard_tables($data);

		// 					}
		// 				}
		// 			}
		// 		}
		// 	}
		// }

		foreach ($this->input->post("salary_rate") as $key => $salary_rate){
			
			foreach($this->input->post("timecard_table") as $key => $pay_employ){

				list($pay_type,$employment) = explode("|",$pay_employ);

				$check_pay_type = $this->timecard_table_model->check_pay_type($employment,$salary_rate,$pay_type);

				if($check_pay_type == 0){

				$get_pay_type_table = $this->timecard_table_model->get_pay_type_table($pay_type,$employment);

					foreach ($get_pay_type_table as $pay_type_table) {
					
						$data = array(
							"salary_rate"			=>		$salary_rate,
							"timecard_table_id"		=>		$pay_type_table->id,
							"pay_type"				=>		$pay_type_table->pay_type,
							"employment"			=>		$pay_type_table->employment,
							"timecard_id"			=>		$pay_type_table->timecard_id,
							"reg_nd"				=>		$pay_type_table->reg_nd,
							"reg_wnd"				=>		$pay_type_table->reg_wnd,
							"ot_nd"					=>		$pay_type_table->ot_nd,
							"ot_wnd"				=>		$pay_type_table->ot_wnd,
							);
						$data = $this->security->xss_clean($data);
						$this->timecard_table_model->insert_timecard_tables($data);

					}
				}
			}
		}
				
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Overtime/Timecard Tables Are Successfully Added!</div>");

		$this->session->set_flashdata('onload',"loadCompanyView(".$this->input->post('company_id').")");

		redirect(base_url().'app/timecard_table',$this->data);
	}

}//end controller