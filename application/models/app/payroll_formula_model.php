<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); // blusquall

class Payroll_formula_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}


	public function search_company_onkeyup($val){

		$this->db->select('
			company_id,
			company_name
			');

		if(!$val){
			$where = "InActive = 0 and is_this_recruitment_employer = 0";
		}else{
			$where = "InActive = 0 and is_this_recruitment_employer = 0 and 
				(
					company_name like '%".$val."%'
				)
				";}
		$this->db->where($where);
		$query = $this->db->get("company_info");
		return $query->result();

	}

	public function get_company($id){

		$this->db->where("company_id",$id);
		$query = $this->db->get("company_info");
		return $query->row();
	}

	public function get_locations($id){

		$this->db->where("A.company_id",$id);
		$this->db->where("A.isDisable",0);

		$this->db->join("location B","B.location_id = A.location_id","left outer");
		$query = $this->db->get("company_location A");
		return $query->result();
	}

	public function get_classifications($id){

		$this->db->where("company_id",$id);

		$query = $this->db->get("classification");
		return $query->result();
	}

	public function get_variables(){

		$this->db->where("isDisable",0);
		$this->db->where("InActive",0);
		$this->db->order_by('display_order','asc');
		$query = $this->db->get("payroll_formula_variables");
		return $query->result();

	}

	public function validate_formula_variable(){

		$this->db->where(array(
			'variable_name'	=>		$this->input->post('variable_name')
			));
		
		$query = $this->db->get('payroll_formula_variables');
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
	}

	public function insert_variable(){

		$data = array(
			"variable_name"		=>		ucwords($this->input->post("variable_name")),
			"variable_abbrv"	=>		strtoupper($this->input->post("variable_abbrv")),
			"variable"			=>		strtolower($this->input->post("variable"))
			);

		$data = $this->security->xss_clean($data);
		$this->db->insert("payroll_formula_variables",$data);
	}

	public function get_variable($id){

		$this->db->where("variable_id",$id);
		$query = $this->db->get("payroll_formula_variables");
		return $query->row();
	}

	public function validate_formula_variable_update(){

		$this->db->where(array(
			'variable_name'	=>	$this->input->post('variable_name'),
			'variable_id !='	=>	$this->input->post('variable_id')
			));
		
		$query = $this->db->get('payroll_formula_variables');
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
	}

	public function update_variable(){

		$data = array(
			"variable_name"		=>		ucwords($this->input->post("variable_name")),
			"variable_abbrv"	=>		strtoupper($this->input->post("variable_abbrv")),
			"variable"			=>		strtolower($this->input->post("variable"))
			);
		$this->db->where("variable_id",$this->input->post("variable_id"));
		$data = $this->security->xss_clean($data);
		$this->db->update("payroll_formula_variables",$data);
	}

	public function insert_formula(){

		//$formula = $this->input->post("formula_for")." = ".$this->input->post("formula");
		$formula =$this->input->post("formula");
		$formula_description = $this->input->post("var_for")." = ".$this->input->post("formula_description");

		$data = array(
			"formula_tier"			=>		$this->input->post("formula_tier"),	
			"formula_description"	=>		$formula_description,
			"formula"				=>		$formula
			);

		$data = $this->security->xss_clean($data);
		$this->db->insert("payroll_formulas",$data);
	}

	public function get_formula_tier(){

		$this->db->select('A.formula_tier,B.formula_tier_name');

		$this->db->where("A.InActive",0);
		$this->db->where("A.isDisable",0);

		$this->db->join("formula_tier B","B.formula_tier_id = A.formula_tier","left outer");

		$this->db->group_by("A.formula_tier");
		$this->db->order_by("B.hierarchy","asc");
		$query = $this->db->get("payroll_formulas A");
		return $query->result();
	}

	public function get_formula_by_tier($tier){

		$this->db->select('formula_description,formula_id');

		$this->db->where("formula_tier",$tier);
		$this->db->where("InActive",0);
		$this->db->where("isDisable",0);
		$query = $this->db->get("payroll_formulas");
		return $query->result();
	}

	public function formula_setup($where){

		$this->db->select('
			B.formula_description as "sss_formula_desc",
			C.formula_description as "ph_formula_desc",
			D.formula_description as "pi_formula_desc",
			E.formula_description as "gross_formula_desc",
			F.formula_description as "taxable_formula_desc",
			G.formula_description as "wtax_formula_desc",
			H.formula_description as "ot_formula_desc",
			I.formula_description as "absent_formula_desc",
			J.formula_description as "late_formula_desc",
			K.formula_description as "ut_formula_desc",
			L.formula_description as "overbreak_formula_desc",
			M.formula_description as "net_pay_formula_desc",
			N.formula_description as "thirteenth_month_formula_desc",
			O.formula_description as "net_basic_formula_desc",
			P.formula_description as "cola_formula_desc",
			Q.formula_description as "income_sum_formula_desc",
			R.formula_description as "deduction_sum_formula_desc",
			A.setup_id,
			A.thirteenth_month_taxable,
			A.sss_formula,
			A.ph_formula,
			A.pi_formula,
			A.gross_formula,
			A.taxable_formula,
			A.wtax_formula,
			A.ot_formula,
			A.absent_formula,
			A.late_formula,
			A.ut_formula,
			A.overbreak_formula,
			A.net_pay_formula,
			A.thirteenth_month_formula,
			A.net_basic_formula,
			A.cola_formula,
			A.income_sum_formula,
			A.deduction_sum_formula
			');

		$this->db->where($where);
		$this->db->join("payroll_formulas R","R.formula_id = A.deduction_sum_formula","left outer");
		$this->db->join("payroll_formulas Q","Q.formula_id = A.income_sum_formula","left outer");
		$this->db->join("payroll_formulas P","P.formula_id = A.cola_formula","left outer");
		$this->db->join("payroll_formulas O","O.formula_id = A.net_basic_formula","left outer");
		$this->db->join("payroll_formulas N","N.formula_id = A.thirteenth_month_formula","left outer");
		$this->db->join("payroll_formulas M","M.formula_id = A.net_pay_formula","left outer");
		$this->db->join("payroll_formulas L","L.formula_id = A.overbreak_formula","left outer");
		$this->db->join("payroll_formulas K","K.formula_id = A.ut_formula","left outer");
		$this->db->join("payroll_formulas J","J.formula_id = A.late_formula","left outer");
		$this->db->join("payroll_formulas I","I.formula_id = A.absent_formula","left outer");
		$this->db->join("payroll_formulas H","H.formula_id = A.ot_formula","left outer");
		$this->db->join("payroll_formulas G","G.formula_id = A.wtax_formula","left outer");
		$this->db->join("payroll_formulas F","F.formula_id = A.taxable_formula","left outer");
		$this->db->join("payroll_formulas E","E.formula_id = A.gross_formula","left outer");
		$this->db->join("payroll_formulas D","D.formula_id = A.pi_formula","left outer");
		$this->db->join("payroll_formulas C","C.formula_id = A.ph_formula","left outer");
		$this->db->join("payroll_formulas B","B.formula_id = A.sss_formula","left outer");
		$query = $this->db->get("payroll_formula_setup A");
		return $query->row();
	}

	public function company($id){
		$this->db->select('
			company_id,
			company_name
			');

		$this->db->where("company_id",$id);
		$query = $this->db->get("company_info");
		return $query->row();

	}

	public function location($id){
		$this->db->select('
			location_id,
			location_name
			');
		$this->db->where("location_id",$id);

		$query = $this->db->get("location");
		return $query->row();
	}

	public function classification($id){
		$this->db->select('
			classification_id,
			classification
			');
		$this->db->where("classification_id",$id);

		$query = $this->db->get("classification");
		return $query->row();
	}

	public function employment($id){
		$this->db->select('
			employment_id,
			employment_name
			');
		$this->db->where("employment_id",$id);

		$query = $this->db->get("employment");
		return $query->row();
	}

	public function pay_type($id){
		$this->db->select('
			pay_type_id,
			pay_type_name
			');
		$this->db->where("pay_type_id",$id);

		$query = $this->db->get("pay_type");
		return $query->row();
	}

	public function salary_rate($id){
		$this->db->select('
			salary_rate_id,
			salary_rate_name
			');
		$this->db->where("salary_rate_id",$id);

		$query = $this->db->get("salary_rates");
		return $query->row();
	}

	public function formula_tier(){

		//$this->db->where("InActive",0);
		$this->db->where(array(
			'InActive'	=>		0,
			'is_multiple_formula'	=>		0
			));
		$this->db->order_by("hierarchy","asc");
		$query = $this->db->get("formula_tier");
		return $query->result();
	}
	public function formula_tier_2(){

		//$this->db->where("InActive",0);
		$this->db->where(array(
			'InActive'	=>		0
			));
		$this->db->order_by("hierarchy","asc");
		$query = $this->db->get("formula_tier");
		return $query->result();
	}

	public function tier_name($tier){

		$this->db->where("formula_tier_id",$tier);
		$query = $this->db->get("formula_tier");
		return $query->row();
	}

	public function save_formula_setup(){

		$data = array(
			"company"					=>	$this->input->post("company_id"),
			// "location"					=>	$this->input->post("location_id"),
			// "classification"			=>	$this->input->post("classification_id"),
			"employment"				=>	$this->input->post("employment_id"),
			"pay_type"					=>	$this->input->post("pay_type_id"),
			"salary_rate"				=>	$this->input->post("salary_rate_id"),
			"sss_formula"				=>	$this->input->post("sss_formula"),
			"ph_formula"				=>	$this->input->post("ph_formula"),
			"pi_formula"				=>	$this->input->post("pi_formula"),
			"gross_formula"				=>	$this->input->post("gross_formula"),
			"taxable_formula"			=>	$this->input->post("taxable_formula"),
			"wtax_formula"				=>	$this->input->post("wtax_formula"),
			"ot_formula"				=>	$this->input->post("ot_formula"),
			"absent_formula"			=>	$this->input->post("absent_formula"),
			"late_formula"				=>	$this->input->post("late_formula"),
			"ut_formula"				=>	$this->input->post("ut_formula"),
			"overbreak_formula"			=>	$this->input->post("overbreak_formula"),
			"net_pay_formula"			=>	$this->input->post("net_pay_formula"),
			"thirteenth_month_formula"	=>	$this->input->post("thirteenth_month_formula"),
			"thirteenth_month_taxable"	=>	$this->input->post("thirteenth_month_taxable"),
			"net_basic_formula"			=>	$this->input->post("net_basic_formula"),
			"income_sum_formula"		=>	$this->input->post("income_sum_formula"),
			"deduction_sum_formula"		=>	$this->input->post("deduction_sum_formula"),
			"cola_formula"			=>	$this->input->post("cola_formula")
			);

		$data = $this->security->xss_clean($data);
		$this->db->insert("payroll_formula_setup",$data);
	}

	public function update_setup_formula(){

			$setup_name = $this->input->post("setup_formula");

		$data = array(
			$setup_name		=>	$this->input->post($setup_name)
			);
		$data = $this->security->xss_clean($data);
		$this->db->where("setup_id",$this->input->post("setup_id"));
		$this->db->update("payroll_formula_setup",$data);
	}
}