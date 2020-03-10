<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Serttech_login_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function validate_nbd(){
		// $this->db->select("nbd");
		//  $this->db->where(array(
  //               'nbd'      =>      md5($this->input->post('nbd'))
  //       ));
  //       $query = $this->db->get('nbd');

        //if($query->num_rows() == 1){

		$this->db->select("username,password");
		 $this->db->where(array(
                'username'      =>      $this->input->post('username'),
                'password'      =>     md5($this->input->post('password')),
				'InActive'		=>		0
        ));
        $query = $this->db->get('system_management_users');
        if($query->num_rows() == 1){
            return true;
        }else{
	        return false;
	     }


		//}
	}
	public function getUserLoggedIn($username){

		$query = $this->db->get("system_management_users");
		return $query->row();
	}
	public function modify_bill($id){
		$this->db->where('id',$id);
		$this->data = array(
			'customer_type'			=> $this->input->post('customer_type'),
			'no_of_months'			=> $this->input->post('no_of_months'),
			'no_of_jobs'			=> $this->input->post('no_of_jobs'),
			'orig_price'			=> $this->input->post('orig_price'),
			'discount_percentage'			=> $this->input->post('discount_percentage'),
			'vat_percentage'			=> $this->input->post('vat_percentage'),
			'is_vat_included_at_last_price'			=> $this->input->post('is_vat_included_at_last_price')
			);
		$this->db->update("recruitment_employer_billing_setting",$this->data);	
	 }
	public function save_bill(){

		$this->data = array(
			'customer_type'			=> $this->input->post('customer_type'),
			'no_of_months'			=> $this->input->post('no_of_months'),
			'no_of_jobs'			=> $this->input->post('no_of_jobs'),
			'orig_price'			=> $this->input->post('orig_price'),
			'discount_percentage'			=> $this->input->post('discount_percentage'),
			'vat_percentage'			=> $this->input->post('vat_percentage'),
			'is_vat_included_at_last_price'			=> $this->input->post('is_vat_included_at_last_price'),
			'InActive'			=> 0
			);
		$this->db->insert("recruitment_employer_billing_setting",$this->data);	
	 }
	public function save_serttech_account(){
		$this->db->where('id',1);
		$this->data = array(
			'username'			=> $this->input->post('username'),
			'password'			=> md5($this->input->post('password')),
			'myhris'			=> $this->input->post('password')
			);
		$this->db->update("system_management_users",$this->data);	
	 }	
	public function getMyEmployeeLicense(){
		$this->db->where("id",1);
		$query = $this->db->get("employee_license");
		return $query->row();	
	}
	//=========== 				 		 

	public function save_employee_license(){
		$this->db->where('id',1);
		$this->data = array(
			'employee_license'			=> md5($this->input->post('employee_license')),
			'myhris'					=> $this->input->post('employee_license')
			);
		$this->db->update("employee_license",$this->data);	
	 }
	public function save_company_license(){
		$this->db->where('id',1);
		$this->data = array(
			'company_license'			=> md5($this->input->post('company_license')),
			'myhris_c'					=> $this->input->post('company_license')
			);
		$this->db->update("employee_license",$this->data);	
	 }	

	//== for getting the sidebar
	public function getSidebar(){

		$query = $this->db->query("select sidebar,page_module,page_id from pages where InActive = 0  order by sidebar asc");	//GROUP BY sidebar
		return $query->result();
	}
	 public function get_sidebar_link($sidebar){

		$this->db->where(array(
			'sidebar'	=>	$sidebar,
			'sys_mng_dropdown'	=>	'1'
		));	
		$this->db->order_by('page_id','asc');
		
		$query = $this->db->get("pages");
		return $query->result();
	}

	public function disable_feature($page_module){
		$this->db->where('page_module',$page_module);
		$this->data = array('InActive'=>1);
		$this->db->update("pages",$this->data);	
	 }
	public function registered_employers(){ // get all recruitment employers
		$this->db->select("A.*,e.cValue,c.city_name,b.name as province_name");

		$this->db->join('cities c', 'c.id = A.prov_city', 'left');
		$this->db->join('provinces b', 'b.id = A.province', 'left');
		$this->db->join('system_parameters e', 'e.param_id = A.industry', 'left');
		$query = $this->db->get("recruitment_employers A");		
		return $query->result();
	}	
	public function rec_employer_current_setting($username){ //
		
		$this->db->where(array(
				'employer_un'	=>	$username,
				'is_usage_active'	=>	1,
			));			
		$query = $this->db->get("recruitment_employers_setting");		
		return $query->row();
	}
	public function rec_bill($usage_id){ // 
		
		$this->db->where(array(
				'id'	=>	$usage_id
			));			
		$query = $this->db->get("recruitment_employer_billing_setting");		
		return $query->row();
	}
	public function employers_job(){ 
		
		$this->db->select("A.*,b.company_name,b.company_id");
		$this->db->join('company_info b', 'b.employer_username = A.username', 'left');
		$query = $this->db->get("recruitment_employers A");		
		return $query->result();
	}	
	public function company_jobs($company_id){ 
				$this->db->select("A.*,b.*,d.company_name");
		$this->db->where("A.company_id", $company_id);

		$this->db->join('company_info d', 'd.company_id = A.company_id', 'left');
		$this->db->join('jobs b', 'b.job_id = A.job_id', 'left');
		$query = $this->db->get("jobs_per_company A");		
		return $query->result();
	}	

	public function get_country($country){

		$this->db->select("cValue");
		$this->db->where("param_id", $country);
		$query = $this->db->get("system_parameters");
		return $query->row();
	}
	public function update_usage_status_expired($usage_id,$username){
			$this->data = array(
				'is_usage_expired'		=> 	1 // true
			);	
			$this->db->where(array(
				'active_usage_type'	=>	$usage_id,
				'employer_un'	=>	$username,
				'is_usage_active'	=>	1
			));		
			$this->db->update("recruitment_employers_setting",$this->data);
		
	}
	public function update_usage_status_on($usage_id,$username){
			$this->data = array(
				'is_usage_expired'		=> 	0 // true
			);	
			$this->db->where(array(			
				'active_usage_type'	=>	$usage_id,
				'employer_un'	=>	$username,				
				'is_usage_active'	=>	1
			));		
			$this->db->update("recruitment_employers_setting",$this->data);
		
	}
	
}