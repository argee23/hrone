<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Payroll_yearly_annual_tax_exemption_model extends CI_Model{

	public function __construct(){
		parent::__construct();	
	}
	
	public function CheckExemption($taxcode_id,$company_id){
		$this->db->where(array(
			'company_id'	=>		$company_id,
			'covered_year'	=>		date('Y'),
			'taxcode_id'	=>		$taxcode_id
		));	
		$query = $this->db->get("yearly_annual_tax_exemption");
		return $query->row();
	}
	public function getExemption($taxcode_id){
		$this->db->where(array(
			'taxcode_id'	=>		$taxcode_id
		));	
		$query = $this->db->get("yearly_annual_tax_exemption");
		return $query->row();
	}

	public function saveExemption($total,$id){ 
		$this->data = array(
				'total' 			=> $this->input->post('total'),
                'date_updated' 			=> date('Y-m-d H:i:s')

					);	
		$this->db->where('id',$id);
		$this->db->update("yearly_annual_tax_exemption",$this->data);
	}
	public function addExemption($total,$taxcode_id,$company_id){ 
		$this->data = array(
				'total' 			=> $total,
				'taxcode_id' 		=> $taxcode_id,
				'company_id' 		=> $company_id,
				'covered_year' 		=> date('Y'),
                'date_added' 		=> date('Y-m-d H:i:s')
					);	
		
		$this->db->insert("yearly_annual_tax_exemption",$this->data);
	}

//GET COMPANY=============================================================	

// 	public function get_company_name($company){
// 		$this->db->select('company_name');
// 		$this->db->where('company_id',$company);
// 		$query = $this->db->get("company_info");
// 		return $query->result();
// 	}
// 	public function get_company($company_id){
// 		$this->db->where(array(
// 			'company_id'	=>		$company_id,
// 			'InActive'		=>		0
// 		));	
// 		$query = $this->db->get("company_info");
// 		return $query->row();
// 	}
	
// //GET ALL LOAN CATEGORY================================================================	


// public function load_locations($id){
// 		$this->db->join('location b', 'b.location_id = a.location_id', 'left'); 
// 		$this->db->where(array(
// 			'company_id'			=>		$id,
// 			'InActive'				=>		0
// 		));
// 		$this->db->order_by('b.location_id');	
// 		$query = $this->db->get("company_location  a");
// 		return $query->result();
// 	}
// public function get_exemption_list($company_id,$location_id){
// 	$this->db->where(array(
// 			'company_id'		=>	$company_id,
// 			'location_id'       =>  $location_id
// 		));		
// 		$query = $this->db->get("yearly_annual_tax_exemption");
// 		return $query->row();


// }
// public function curLoc($place){//get current location 
// 		$this->db->where(array(
// 			'location_id'			=>		$place,
// 			'InActive'				=>		0
// 		));	
// 		$query = $this->db->get("location");
// 		return $query->result();
// 	}

// public function get_exemption_date($company_id){
// 		$this->db->distinct();
// 		$this->db->select('date');
// 		$this->db->order_by('date','desc');
// 		$this->db->where('company_id',$company_id);
// 		$query = $this->db->get("admin_payroll_philhealth_table_view");
// 		return $query->result();
// 	}

// public function load_annual_tax_exemptions($location,$company_id){
// 		$this->db->where(array(
// 			'company_id'			=>		$company_id,
// 			'location_id'			=>		$location

			
// 		));
// 		$this->db->order_by('id','asc');
// 		$query = $this->db->get("yearly_annual_tax_exemption_view");
// 		return $query->result();
// 	}

// public function load_annual_tax_exemption_result($date,$location,$company_id){
// 		$this->db->where(array(
// 			'company_id'			=>		$company_id,
// 			'date'					=>		$date,
// 			'location_id'			=>		$location

			
// 		));
// 		$this->db->order_by('id','asc');
// 		$query = $this->db->get("yearly_annual_tax_exemption_view");
// 		return $query->result();
// 	}


// public function load_annual_tax_exemption($location,$company_id){
// 		$this->db->where(array(
// 			'company_id'			=>		$company_id,
// 			'location_id'			=>		$location

			
// 		));
// 		$this->db->order_by('id');	
// 		$query = $this->db->get("yearly_annual_tax_exemption");
// 		return $query->result();
// 	}

// //Adding new tax exemption============================================================
// public function validate_tax_code(){
// 		$company_id =$this->input->post('company_id');		
// 		$location = $this->input->post('location_id');
// 		$annual_year = (date('Y', strtotime(date("Y-m-d"))));
// 		$this->db->select("tax_code");
// 		$this->db->where(array(

// 			'taxcode_id'    =>		$this->input->post('taxcode_id'),
// 			'date'			=>		$annual_year,
// 			'location_id'	=>		$location,
// 			'company_id'	=>		$company_id 
			
// 		));
// 		$query = $this->db->get("yearly_annual_tax_exemption");
// 		if($query->num_rows() > 0){
// 			return true;
// 		}else{
// 			return false;
// 		}
// 	}
//    public function AddNewTaxCode($post)
//         {
//         	$current_year = (date('Y', strtotime(date("Y-m-d"))));

//         		$this->data = array(
//         		'company_id' 			=> $this->input->post('company_id'),
//         		'location_id' 			=> $this->input->post('location_id'),
//                 'tax_code' 				=> $this->input->post('tax_code'),
//                 'taxcode_id' 			=> $this->input->post('taxcode_id'),
//                 'new_tax'				=> $this->input->post('new_tax'),
//                 'total'					=> $this->input->post('new_tax'),	
//                 'date' 					=> $current_year,
//                 'date_added' 			=> date('Y-m-d H:i:s')
                
			
// 		);	
// 		$this->db->insert('yearly_annual_tax_exemption',$this->data);
// 		}
	
// 	public function get_table_tax_exemption($id){
// 		$this->db->where('id',$id);
// 		$query = $this->db->get("yearly_annual_tax_exemption");
// 		return $query->result();
// 	}

// //TAX EXEMPTION EDIT MODEL==========================================================================
// 	public function validate_edit_tax_code($id){
// 		$company_id =$this->input->post('company_id');	
// 		$this->db->select("tax_code");
// 		$this->db->where(array(
// 			'id !=' 			=>		$id,
// 			'tax_code'			=>		$this->input->post('tax_code'),
// 			'date'				=>		$annual_year,
// 			'location_id'		=>		$location,
// 			'company_id'		=>		$company_id 
			
// 		));
// 		$query = $this->db->get("yearly_annual_tax_exemption");
// 		if($query->num_rows() > 0){
// 			return true;
// 		}else{
// 			return false;
// 		}
// 	}

// 	public function tax_exemption_table_edit($id){ 
		
// 		$current_year = (date('Y', strtotime(date("Y-m-d"))));
// 		$this->data = array(
// 				'company_id' 			=> $this->input->post('company_id'),
//         		'location_id' 			=> $this->input->post('location_id'),
//                 'tax_code' 				=> $this->input->post('tax_code'),
//                 'taxcode_id' 			=> $this->input->post('taxcode_id'),
//                 'new_tax'				=> $this->input->post('new_tax'),
//                 'total'					=> $this->input->post('new_tax'),	
//                 'date' 					=> $current_year,
//                 'date_updated' 			=> date('Y-m-d H:i:s')

// 					);	
// 		$this->db->where('id',$id);
// 		$this->db->update("yearly_annual_tax_exemption",$this->data);
// 	}




// 	public function delete($id){
// 		$this->db->where(array(
// 			'id'		=>	$id
// 		));		
// 		$query = $this->db->get("yearly_annual_tax_exemption");
// 		return $query->row();
// 	}
// 	public function deactivate($id){
// 		$this->db->where('id',$id);
// 		$this->data = array('IsDisabled'=>1);
// 		$this->db->update("yearly_annual_tax_exemption",$this->data);	
// 	}
// 	public function activate($id){
// 		$this->db->where('id',$id);
// 		$this->data = array('IsDisabled'=>0);
// 		$this->db->update("yearly_annual_tax_exemption",$this->data);	
// 	}

// public function get_taxexemption_date($company_id){
// 		$this->db->distinct();
// 		$this->db->order_by('date','desc');
// 		$this->db->select('date');
// 		$this->db->where('company_id',$company_id);
// 		$query = $this->db->get("yearly_annual_tax_exemption_view");
// 		return $query->result();
// 	}

// public function gettaxcodeList(){
		
// 		$this->db->select('*');
// 		$query = $this->db->get("taxcode");
// 		return $query->result();
// 	}


	}