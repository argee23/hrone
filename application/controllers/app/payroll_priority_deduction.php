<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Payroll_priority_deduction extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/payroll_priority_deduction_model");
		$this->load->model("general_model");
		$this->load->database();
		$this->load->dbforge();
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){

		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('app/payroll/priority_deduction/index',$this->data);

	}

	public function view_deduction_list($val){
		$company_id=$val;
		$this->data["company_id"]=$company_id;
		$this->data["loanList"]=$this->payroll_priority_deduction_model->get_comp_loan($company_id);
		$this->data["od_List"]=$this->payroll_priority_deduction_model->get_comp_od($company_id);
		$this->load->view('app/payroll/priority_deduction/view_deduction_list',$this->data);

	}

	public function save_loan_priority($company_id){
		$loanList=$this->payroll_priority_deduction_model->get_comp_loan($company_id);

		if(!empty($loanList)){
			foreach($loanList as $l){
					$hierarchy=$this->input->post("loan_".$l->loan_type_id);
					//if($hierarchy=="on"){
						$this->payroll_priority_deduction_model->save_loan_priority($l->loan_type_id,$hierarchy);
					//}else{

					//}
			}
		}else{

		}


			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/payroll_priority_deduction/index',$this->data);

	}
	public function save_od_priority($company_id){
		$od_List=$this->payroll_priority_deduction_model->get_comp_od($company_id);

		if(!empty($od_List)){
			foreach($od_List as $o){
					$hierarchy=$this->input->post("od_".$o->id);
					//if($hierarchy=="on"){
						$this->payroll_priority_deduction_model->save_od_priority($o->id,$hierarchy);
					//}else{

					//}
			}
		}else{

		}


			$this->session->set_flashdata('onload',"view(".$company_id.")");
			redirect(base_url().'app/payroll_priority_deduction/index',$this->data);

	}


}//end controller