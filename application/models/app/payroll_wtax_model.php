<!-- by: blusquall -->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Payroll_wtax_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function get_order_per_pay_type($id){

		$this->db->select('order_no,exempt_percentage,exempt_value');
		$this->db->where("pay_type",$id);
		$this->db->where("InActive",0);
		$this->db->order_by("order_no","asc");
		$query = $this->db->get("tax_tables");
		return $query->result();

	}

	public function get_exempt_per_tax_code($id,$tax_code){

		$code = "tax_code_".$tax_code;

		$this->db->select('tax_code_'.$tax_code.' as "tax_code_exempt"');
		$this->db->where("pay_type",$id);
		$this->db->where("InActive",0);
		$this->db->order_by("order_no","asc");
		$query = $this->db->get("tax_tables");
		return $query->result();
	}

	public function get_tax_tier_info($pay_type,$order){

		$this->db->where("A.pay_type",$pay_type);
		$this->db->where("A.order_no",$order);
		$this->db->join("pay_type B","B.pay_type_id = A.pay_type","left outer");
		$query = $this->db->get("tax_tables A");
		return $query->row();
	}

	public function modify_tier_info(){

		$data = array(
			"exempt_percentage"		=>		$this->input->post("exempt_percentage"),
			"exempt_value"			=>		$this->input->post("exempt_value"),
			"tax_code_1"			=>		$this->input->post("tax_code_1"),
			"tax_code_2"			=>		$this->input->post("tax_code_2"),
			"tax_code_3"			=>		$this->input->post("tax_code_3"),
			"tax_code_4"			=>		$this->input->post("tax_code_4"),
			"tax_code_5"			=>		$this->input->post("tax_code_5"),
			"tax_code_6"			=>		$this->input->post("tax_code_6")
			);

		$this->db->where("tax_table_id",$this->input->post("tax_table_id"));
		$data = $this->security->xss_clean($data);
		$this->db->update("tax_tables",$data);
	}

	public function get_max_order_no($id){

		$this->db->select_max('order_no');
		$this->db->where("pay_type",$id);
		$this->db->where("InActive",0);
		$query = $this->db->get("tax_tables");
		return $query->row();
	}

	public function add_tax_tier($max_no){

		$order_no = $max_no + 1;

		$data = array(
			"order_no"				=>		$order_no,
			"pay_type"				=>		$this->input->post("pay_type_id"),
			"exempt_percentage"		=>		$this->input->post("exempt_percentage"),
			"exempt_value"			=>		$this->input->post("exempt_value"),
			"tax_code_1"			=>		$this->input->post("tax_code_1"),
			"tax_code_2"			=>		$this->input->post("tax_code_2"),
			"tax_code_3"			=>		$this->input->post("tax_code_3"),
			"tax_code_4"			=>		$this->input->post("tax_code_4"),
			"tax_code_5"			=>		$this->input->post("tax_code_5"),
			"tax_code_6"			=>		$this->input->post("tax_code_6")
			);

		$data = $this->security->xss_clean($data);
		$this->db->insert("tax_tables",$data);
	}

	public function get_company_info($id){

		$this->db->where("company_id",$id);
		$query = $this->db->get("company_info");
		return $query->row();
	}

	public function get_company_location($id){

		$this->db->select('A.location_id,B.location_name');
		$this->db->where("A.company_id",$id);
		$this->db->where("A.isDisable",0);
		$this->db->order_by("B.location_name","asc");
		$this->db->join("location B","B.location_id = A.location_id","left outer");
		$query = $this->db->get("company_location A");
		return $query->result();
	}

	public function add_tax_table(){

		$this->load->dbforge();

		$table = "tax_table_".$this->input->post("company_id");

		$fields = array(
        'table_id' => array(
                'type' => 'INT',
                'constraint' => 9,
                'auto_increment' => true
        ),
        'tax_table_id' => array(
                'type' => 'INT',
                'constraint' => 9,
                'null' => TRUE,
        ),
        'pay_type' => array(
                'type' => 'INT',
                'constraint' => 9,
                'null' => TRUE,
        ),
        'salary_rate' => array(
                'type' => 'INT',
                'constraint' => 9,
                'null' => TRUE,
        ),
        'order_no' => array(
                'type' => 'INT',
                'constraint' => 9,
                'null' => TRUE,
        ),
        'exempt_percentage' => array(
                'type' => 'INT',
                'constraint' => 9,
                'null' => TRUE,
        ),
        'exempt_value' => array(
                'type' => 'FLOAT',
                'constraint' => '12,4',
                'decimals' => 4,
                'null' => TRUE,
        ),
        'tax_code_1' => array(
                'type' => 'FLOAT',
                'constraint' => '12,4',
                'decimals' => 4,
                'null' => TRUE,
        ),
        'tax_code_2' => array(
                'type' => 'FLOAT',
                'constraint' => '12,4',
                'decimals' => 4,
                'null' => TRUE,
        ),
        'tax_code_3' => array(
                'type' => 'FLOAT',
                'constraint' => '12,4',
                'decimals' => 4,
                'null' => TRUE,
        ),
        'tax_code_4' => array(
                'type' => 'FLOAT',
                'constraint' => '12,4',
                'decimals' => 4,
                'null' => TRUE,
        ),
        'tax_code_5' => array(
                'type' => 'FLOAT',
                'constraint' => '12,4',
                'decimals' => 4,
                'null' => TRUE,
        ),
        'tax_code_6' => array(
                'type' => 'FLOAT',
                'constraint' => '12,4',
                'decimals' => 4,
                'null' => TRUE,
        ),
        'InActive' => array(
                'type' => 'INT',
                'constraint' => 1,
                'null' => TRUE,
                'default' => 0,
        ),
		);

		$this->dbforge->add_key('table_id', TRUE);

		$this->dbforge->add_field($fields);
		$this->dbforge->create_table($table, TRUE);

	}

	public function check_pay_type($value,$salary_rate){

		$table = "tax_table_".$this->input->post("company_id");

		$this->db->where("pay_type",$value);
		$this->db->where("salary_rate",$salary_rate);
		$query = $this->db->get($table);
		return $query->num_rows();
	}

	public function get_pay_type_table($pay_type){

		$this->db->where("pay_type",$pay_type);
		$this->db->where("InActive",0);
		$this->db->order_by("order_no","asc");
		$query = $this->db->get("tax_tables");
		return $query->result();
	}

	public function insert_tax_tables($data){

		$table = "tax_table_".$this->input->post("company_id");

		$this->db->insert($table,$data);
	}

	public function get_order_per_pay_type_c($salary,$id,$company_id){
		
		$this->db->select('order_no,exempt_percentage,exempt_value');
		$this->db->where("pay_type",$id);
		$this->db->where("salary_rate",$salary);
		$this->db->where("InActive",0);
		$this->db->order_by("order_no","asc");
		$query = $this->db->get("tax_table_".$company_id);
		return $query->result();

	}

	public function get_exempt_per_tax_code_c($salary,$id,$tax_code,$company_id){

		$code = "tax_code_".$tax_code;

		$this->db->select('tax_code_'.$tax_code.' as "tax_code_exempt"');
		$this->db->where("pay_type",$id);
		$this->db->where("salary_rate",$salary);
		$this->db->where("InActive",0);
		$this->db->order_by("order_no","asc");
		$query = $this->db->get("tax_table_".$company_id);
		return $query->result();
	}

	public function get_pay_type_per_company($company){

		$this->db->select("B.pay_type_name,B.pay_type_id");
		$this->db->where("A.InActive",0);
		$this->db->join("pay_type B","B.pay_type_id = A.pay_type","left outer");
		$this->db->order_by("B.order_list");
		$this->db->group_by("A.pay_type");
		$query = $this->db->get("tax_table_".$company." A");
		return $query->result();
	}

	public function get_salary_rate_per_company($company){

		$this->db->select("B.salary_rate_name,B.salary_rate_id");
		$this->db->where("A.InActive",0);
		$this->db->join("salary_rates B","B.salary_rate_id = A.salary_rate","left outer");
		// $this->db->order_by("B.order_list");
		$this->db->group_by("A.salary_rate");
		$query = $this->db->get("tax_table_".$company." A");
		return $query->result();
	}

	public function get_max_order_no_c($id){

		$table = "tax_table_".$this->input->post("company_id");

		$this->db->select_max('order_no');
		$this->db->where("salary_rate",$this->input->post("salary_rate"));
		$this->db->where("pay_type",$id);
		$this->db->where("InActive",0);
		$query = $this->db->get($table);
		return $query->row();
	}

	public function add_tax_tier_c($max_no){

		$table = "tax_table_".$this->input->post("company_id");
		$order_no = $max_no + 1;

		$data = array(
			"order_no"				=>		$order_no,
			"pay_type"				=>		$this->input->post("pay_type_id"),
			"salary_rate"			=>		$this->input->post("salary_rate"),
			"exempt_percentage"		=>		$this->input->post("exempt_percentage"),
			"exempt_value"			=>		$this->input->post("exempt_value"),
			"tax_code_1"			=>		$this->input->post("tax_code_1"),
			"tax_code_2"			=>		$this->input->post("tax_code_2"),
			"tax_code_3"			=>		$this->input->post("tax_code_3"),
			"tax_code_4"			=>		$this->input->post("tax_code_4"),
			"tax_code_5"			=>		$this->input->post("tax_code_5"),
			"tax_code_6"			=>		$this->input->post("tax_code_6")
			);

		$data = $this->security->xss_clean($data);
		$this->db->insert($table,$data);
	}

	public function get_tax_tier_info_c($pay_type,$order,$company,$salary){
		$table = "tax_table_".$company;

		$this->db->where("A.pay_type",$pay_type);
		$this->db->where("A.salary_rate",$salary);
		$this->db->where("A.order_no",$order);
		$this->db->join("pay_type B","B.pay_type_id = A.pay_type","left outer");
		$query = $this->db->get($table." A");
		return $query->row();
	}

	public function modify_tier_info_c(){

		$table = "tax_table_".$this->input->post("company_id");

		$data = array(
			"exempt_percentage"		=>		$this->input->post("exempt_percentage"),
			"exempt_value"			=>		$this->input->post("exempt_value"),
			"tax_code_1"			=>		$this->input->post("tax_code_1"),
			"tax_code_2"			=>		$this->input->post("tax_code_2"),
			"tax_code_3"			=>		$this->input->post("tax_code_3"),
			"tax_code_4"			=>		$this->input->post("tax_code_4"),
			"tax_code_5"			=>		$this->input->post("tax_code_5"),
			"tax_code_6"			=>		$this->input->post("tax_code_6")
			);

		$this->db->where("tax_table_id",$this->input->post("tax_table_id"));
		$this->db->where("salary_rate",$this->input->post("salary_rate"));
		$data = $this->security->xss_clean($data);
		$this->db->update($table,$data);
	}

	public function get_location_minimum($company,$location){

		$where = array (
			"company_id"	=>	$company,
			"location_id"	=>	$location,
			"InActive"		=>	0
			);

		$this->db->where($where);
		$query = $this->db->get("location_minimum_wage");
		return $query->row();
	}

	public function get_location_name($location){
		$this->db->select('location_id,location_name');
		$this->db->where("location_id",$location);
		$query = $this->db->get("location");
		return $query->row();
	}

	public function add_minimum(){

		$data = array(
			"company_id"		=>	$this->input->post("company_id"),
			"location_id"		=>	$this->input->post("location_id"),
			"minimum_amount"	=>	$this->input->post("minimum_amount"),
			"effectivity_date"	=>	$this->input->post("effectivity_date"),
			"declaration_date"	=>	$this->input->post("declaration_date")
			);

		$data = $this->security->xss_clean($data);
		$this->db->insert("location_minimum_wage",$data);
	}

	public function modify_minimum(){

		$where = array (
			"company_id"		=>	$this->input->post("company_id"),
			"location_id"		=>	$this->input->post("location_id"),
			);

		$this->db->where($where);
		$this->db->set("minimum_amount",$this->input->post("minimum_amount"));
		$this->db->set("effectivity_date",$this->input->post("effectivity_date"));
		$this->db->set("declaration_date",$this->input->post("declaration_date"));
		$this->db->update("location_minimum_wage");
	}

	public function check_salary_paytype($salary,$pay_type,$company){
		$table = "tax_table_".$company;

		$this->db->select("table_id");

		$this->db->where("pay_type",$pay_type);
		$this->db->where("salary_rate",$salary);
		$query = $this->db->get($table);
		return $query->num_rows();
	}
}