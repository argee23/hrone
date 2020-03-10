<!-- by: blusquall -->
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Timecard_table_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function add_description(){

		$data = array(
			"timecard_desc_name"		=>	ucwords($this->input->post("timecard_desc_name")),
			"timecard_description"		=>	ucwords($this->input->post("timecard_description"))
			);

		$data = $this->security->xss_clean($data);
		$this->db->insert("timecard_description",$data);
	}

	public function timecard_description(){

		$this->db->where("InActive",0);
		$query = $this->db->get("timecard_description");
		return $query->result();
	}

	public function timecard_description_info($id){

		$this->db->where("timecard_id",$id);
		$query = $this->db->get("timecard_description");
		return $query->row();
	}

	public function modify_timecard(){

		$data = array(
			"timecard_desc_name"		=>	ucwords($this->input->post("timecard_desc_name")),
			"timecard_description"		=>	ucwords($this->input->post("timecard_description"))
			);

		$this->db->where("timecard_id",$this->input->post("timecard_id"));
		$data = $this->security->xss_clean($data);
		$this->db->update("timecard_description",$data);
	}

	public function timecard_check($employment,$pay_type,$timecard_id){

		$this->db->where("employment",$employment);
		$this->db->where("pay_type",$pay_type);
		$this->db->where("timecard_id",$timecard_id);
		$this->db->where("InActive",0);
		$query = $this->db->get("timecard_table");
		return $query->row();
	}

	public function get_company_info($id){

		$this->db->where("company_id",$id);
		$query = $this->db->get("company_info");
		return $query->row();
	}

	public function get_salary_rate($sr){

		$this->db->where("salary_rate_id",$sr);
		$query = $this->db->get("salary_rates");
		return $query->row();
	}

	public function get_pay_type($pt){

		$this->db->where("pay_type_id",$pt);
		$query = $this->db->get("pay_type");
		return $query->row();
	}

	public function get_employment($e){

		$this->db->where("employment_id",$e);
		$query = $this->db->get("employment");
		return $query->row();
	}

	public function standard_timecard_tables(){

		$this->db->where("A.InActive",0);
		$this->db->join("pay_type B","B.pay_type_id = A.pay_type","left outer");
		$this->db->group_by("A.pay_type");
		$query = $this->db->get("timecard_table A");
		return $query->result();
	}

	public function get_table_employment($pay_type){

		$this->db->where("A.pay_type",$pay_type);
		$this->db->join("employment B","B.employment_id = A.employment","left outer");
		$this->db->group_by("A.employment");
		$query = $this->db->get("timecard_table A");
		return $query->result();
	}

	public function get_timecard($ti){

		$this->db->where("timecard_id",$ti);
		$query = $this->db->get("timecard_description");
		return $query->row();
	}

	public function insert_to_standard($data){

		$this->db->insert("timecard_table",$data);
	}

	public function get_timecard_data($id){

		$this->db->select("
			A.id,
			B.prefix,
			A.employment,
			A.pay_type,
			B.timecard_id,
			A.reg_nd,
			A.reg_wnd,
			A.ot_nd,
			A.ot_wnd,
			B.timecard_desc_name,
			C.employment_name,
			D.pay_type_name
			",false);

		$this->db->join("pay_type D","D.pay_type_id = A.pay_type","left outer");
		$this->db->join("employment C","C.employment_id = A.employment","left outer");
		$this->db->join("timecard_description B","B.timecard_id = A.timecard_id","left outer");
		$this->db->where("A.id",$id);
		$query = $this->db->get("timecard_table A");
		return $query->row();
	}

	public function get_timecard_data_c($id,$company){

		$this->db->select("
			A.timecard_table_id,
			A.tc_table_id,
			B.prefix,
			A.employment,
			A.pay_type,
			A.salary_rate,
			B.timecard_id,
			A.reg_nd,
			A.reg_wnd,
			A.ot_nd,
			A.ot_wnd,
			B.timecard_desc_name,
			C.employment_name,
			D.pay_type_name,
			E.salary_rate_name
			",false);

		$this->db->join("salary_rates E","E.salary_rate_id = A.salary_rate","left outer");
		$this->db->join("pay_type D","D.pay_type_id = A.pay_type","left outer");
		$this->db->join("employment C","C.employment_id = A.employment","left outer");
		$this->db->join("timecard_description B","B.timecard_id = A.timecard_id","left outer");
		$this->db->where("A.tc_table_id",$id);
		$query = $this->db->get("timecard_table_".$company." A");
		return $query->row();
	}

	public function modify_to_standard($data){

		$this->db->where("id",$this->input->post("id"));
		$this->db->update("timecard_table",$data);
	}

	public function modify_to_company($data){

		$this->db->where("tc_table_id",$this->input->post("id"));
		$this->db->update("timecard_table_".$this->input->post("company"),$data);
	}

	public function add_timecard_table(){

		$this->load->dbforge();

		$table = "timecard_table_".$this->input->post("company_id");

		$fields = array(
        'tc_table_id' => array(
                'type' => 'INT',
                'constraint' => 9,
                'auto_increment' => true
        ),
        'timecard_table_id' => array(
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
        'employment' => array(
                'type' => 'INT',
                'constraint' => 9,
                'null' => TRUE,
        ),
        'timecard_id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'null' => TRUE,
        ),
        'reg_nd' => array(
                'type' => 'FLOAT',
                'constraint' => '12,4',
                'decimals' => 4,
                'null' => TRUE,
        ),
        'reg_wnd' => array(
                'type' => 'FLOAT',
                'constraint' => '12,4',
                'decimals' => 4,
                'null' => TRUE,
        ),
        'ot_nd' => array(
                'type' => 'FLOAT',
                'constraint' => '12,4',
                'decimals' => 4,
                'null' => TRUE,
        ),
        'ot_wnd' => array(
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

		$this->dbforge->add_key('tc_table_id', TRUE);

		$this->dbforge->add_field($fields);
		$this->dbforge->create_table($table, TRUE);

	}

	public function check_pay_type($employment,$salary_rate,$pay_type){

		$table = "timecard_table_".$this->input->post("company_id");

		$this->db->where("pay_type",$pay_type);
		$this->db->where("salary_rate",$salary_rate);
		$this->db->where("employment",$employment);
		$query = $this->db->get($table);
		return $query->num_rows();
	}

	public function get_pay_type_table($pay_type,$employment){

		$this->db->where("pay_type",$pay_type);
		$this->db->where("employment",$employment);
		$this->db->where("InActive",0);
		$this->db->order_by("timecard_id","asc");
		$query = $this->db->get("timecard_table");
		return $query->result();
	}

	public function insert_timecard_tables($data){

		$table = "timecard_table_".$this->input->post("company_id");

		$this->db->insert($table,$data);
	}

	public function get_salary_rate_per_company($company){

		$this->db->select("B.salary_rate_name,B.salary_rate_id");
		$this->db->where("A.InActive",0);
		$this->db->join("salary_rates B","B.salary_rate_id = A.salary_rate","left outer");
		$this->db->group_by("A.salary_rate");
		$query = $this->db->get("timecard_table_".$company." A");
		return $query->result();
	}

	public function get_per_pay_type_c($salary_rate,$company){

		$this->db->select("B.pay_type_name,B.pay_type_id");
		$this->db->where("A.InActive",0);
		$this->db->where("A.salary_rate",$salary_rate);
		$this->db->join("pay_type B","B.pay_type_id = A.pay_type","left outer");
		$this->db->order_by("A.pay_type");
		$this->db->group_by("A.pay_type");
		$query = $this->db->get("timecard_table_".$company." A");
		return $query->result();
	}

	public function get_per_employment_c($salary_rate,$pay_type,$company){

		$this->db->select("B.employment_name,B.employment_id");
		$this->db->where("A.InActive",0);
		$this->db->where("A.salary_rate",$salary_rate);
		$this->db->where("A.pay_type",$pay_type);
		$this->db->join("employment B","B.employment_id = A.employment","left outer");
		$this->db->order_by("A.timecard_id");
		$this->db->group_by("A.employment");
		$query = $this->db->get("timecard_table_".$company." A");
		return $query->result();
	}


	public function get_timecard_per_c($salary_rate,$pay_type,$employment,$company){

		$this->db->select("
			A.timecard_table_id,
			B.prefix,
			A.employment,
			A.pay_type,
			B.timecard_id,
			A.timecard_id as 't_id',
			A.reg_nd,
			A.reg_wnd,
			A.ot_nd,
			A.ot_wnd,
			B.timecard_desc_name
			",false);
		$this->db->where("A.InActive",0);
		$this->db->where("A.salary_rate",$salary_rate);
		$this->db->where("A.pay_type",$pay_type);
		$this->db->where("A.employment",$employment);
		$this->db->join("timecard_description B","B.timecard_id = A.timecard_id","left outer");
		$this->db->order_by("A.timecard_id");
		$query = $this->db->get("timecard_table_".$company." A");
		return $query->result();
	}

	public function timecard_check_c($salary_rate,$employment,$pay_type,$timecard_id,$company){

		$this->db->where("employment",$employment);
		$this->db->where("salary_rate",$salary_rate);
		$this->db->where("pay_type",$pay_type);
		$this->db->where("timecard_id",$timecard_id);
		$this->db->where("InActive",0);
		$query = $this->db->get("timecard_table_".$company);
		return $query->row();
	}

	public function get_pay_type_per_company($company){

		$this->db->select("B.pay_type_name,B.pay_type_id");
		$this->db->where("A.InActive",0);
		$this->db->join("pay_type B","B.pay_type_id = A.pay_type","left outer");
		$this->db->order_by("A.timecard_id");
		$this->db->group_by("A.pay_type");
		$query = $this->db->get("timecard_table_".$company." A");
		return $query->result();
	}

	public function get_employment_per_company($company){

		// $this->db->select("B.pay_type_name,B.pay_type_id");
		// $this->db->where("A.InActive",0);
		// $this->db->join("pay_type B","B.pay_type_id = A.pay_type","left outer");
		// $this->db->order_by("B.order_list");
		// $this->db->group_by("A.pay_type");
		// $query = $this->db->get("tax_table_".$company." A");
		// return $query->result();
	}
}