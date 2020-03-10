<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Roles_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function verify_class_access($role_id){
		$query = $this->db->query("SELECT count(class_access_id) as class_access_id FROM user_role_classification_access WHERE role_id='".$role_id."' ");
		return $query->row();
	}

	public function verify_loc($role_id){
		$query = $this->db->query("SELECT count(comp_access_id) as comp_access_id FROM user_role_company_access WHERE role_id='".$role_id."' ");
		return $query->row();
	}


	//== for listing
	public function getAll($limit = 10, $offset = 0){ 
		$this->db->order_by('role_name','asc');
		$where = "(role_name like '%".$this->input->post('search')."%' or role_description like '%".$this->input->post('search')."%') 
				and InActive = 0";
		$this->db->where($where);
		$query = $this->db->get("user_roles", $limit, $offset);
		return $query->result();
	}
	public function get_latest_insert(){// get number of isEmployee

		$this->db->select_max('role_id');
    	$query  = $this->db->get('user_roles');
    	return $query->row();

	}//end of get number of isEmployee
	//== for adding

	public function get_system_pages(){
		$query = $this->db->query("SELECT page_id FROM pages WHERE InActive='0'");
		return $query->result();
	}
	public function insert_access_data($accessData){
		$this->db->insert('user_roles_pages',$accessData);

	}
	public function save(){ 
		$this->data = array(

			'role_name'				=>		ucwords($this->input->post('role_name')),
			'role_description'		=>		ucfirst($this->input->post('role_description')),
			'InActive'				=>		0
		);			
		$query = $this->db->insert("user_roles",$this->data);
		if($this->db->affected_rows() == 1){
	
		  $countStore = $this->get_latest_insert();
		  $Lastid = $countStore->role_id;
// ===========

// ===========		  

// ===========
  		  $tp=$this->get_system_pages();
  		  if(!empty($tp)){
  		  	foreach($tp as $p){
  		  		$accessData = array(
  		  			'role_id'	=> $Lastid,
  		  			'page_id'	=> $p->page_id
  		  			);

  		  		$this->insert_access_data($accessData);
  		  	}
  		  }else{

  		  }
// ===========
			return true;




		}else{
			return false;
		}
	}	

	//== for editing //== for getting user role pages
	public function getRole($id){ 

		$this->db->where('role_id',$id);
		$query = $this->db->get('user_roles');
		return $query->row();		
	}	
	
	//== for saving update
	public function modify_user_role($id){

		$this->data = array(
			'role_name'				=> ucfirst($this->input->post('role_name')),
			'role_description'		=> ucfirst($this->input->post('role_description')),
			'InActive'				=> 0
		);	
		$this->db->where('role_id',$id);
		$this->db->update('user_roles',$this->data);
	}

	public function update(){

		$this->data = array(
			'module'				=>		$this->input->post('module'),
			'role_name'				=>		$this->input->post('role_name'),
			'role_description'		=>		$this->input->post('role_description')
		);	
		
		$this->db->where('role_id',$this->input->post('id'));
		$query = $this->db->update("user_roles",$this->data);
		if($this->db->affected_rows() == 1){
			return true;
		}else{
			return false;
		}
	}	

	//== for getting the sidebar
	public function getSidebar(){

		// $query = $this->db->query("select min(sidebar) as sidebar,min(page_module) as page_module,min(page_id) as page_id from pages where InActive = 0 GROUP BY sidebar order by sidebar asc");	
		$query = $this->db->query("select sidebar,page_module,page_id from pages where page_module='sidebar' and page_module='sidebar' and InActive='0'");	
		return $query->result();
	}

	public function getPageModule(){

		$query = $this->db->query("select distinct page_module as page_module from pages where InActive = 0 and page_module != 'sidebar'  order by page_module asc");	
		return $query->result();
	}	

	public function getPageByPageModule($pageModule){
		//$this->db->where('page_module', $pageModule);	
		$this->db->where(array(
			'page_module'	=>	$pageModule,
			'IsModule !='	=> 1
		));	
		$this->db->order_by('page_id','asc');
		$query = $this->db->get("pages");
		return $query->result();
	}

	public function getPageBySidebarModule($sidebar){
		//$this->db->where('sidebar', $sidebar);	

		// $this->db->where(array(
		// 	'sidebar'	=>	$sidebar,
		// 	'page_module !='	=> 'sidebar'
		// ));

		// $this->db->group_by('page_module'); 
		// $query = $this->db->get("pages");

		$query=$this->db->query("SELECT MIN(page_id) as page_id,MIN(page_module) as page_module from pages where sidebar='".$sidebar."'  AND page_module!='sidebar' AND InActive='0' GROUP BY page_module " );

		return $query->result();
	}
	
	public function getRole_AccessLevel($page_id,$role_id){
		$this->db->where(array(
			'role_id'	=>		$role_id,
			'page_id'	=>		$page_id
		));
		$query = $this->db->get("user_roles_pages");
		return $query->row();
	}

	public function get_company_access($company_id,$location_id,$role_id){
		$this->db->where(array(
			'role_id'	=>		$role_id,
			'company_id'	=>		$company_id,
			'location_id'	=>		$location_id
		));
		$query = $this->db->get("user_role_company_access");
		return $query->row();
	}

	public function get_classification_access($company_id,$classification_id,$role_id){
		$this->db->where(array(
			'role_id'	=>		$role_id,
			'company_id'	=>		$company_id,
			'classification_id'	=>		$classification_id
		));
		$query = $this->db->get("user_role_classification_access");
		return $query->row();
	}

	
	public function validate_edit_user_role(){
		$this->db->select("module,role_name,role_id");
		$this->db->where(array(
			'role_id !='	=>		$this->input->post('role_id'),
			'role_name'		=>		$this->input->post('role_name'),
			'InActive'		=>		0
		));	
		$query = $this->db->get("user_roles");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}

	public function validate_add_user_role(){
		$this->db->select("module,role_name,role_id");
		$this->db->where(array(
			'role_name'		=>		$this->input->post('role_name'),
			'InActive'		=>		0
		));	
		$query = $this->db->get("user_roles");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}
	
	public function delete_user_role($id){
		$this->db->where(array(
			'role_id'		=>	$id,
			'InActive'	=>	0	
		));		
		$query = $this->db->get("user_roles");
		return $query->row();
	}
	
	public function delete($id){
		$this->data = array('InActive' =>  1);
		$this->db->where('role_id',$id);
		$query =  $this->db->update("user_roles",$this->data);	
		if($this->db->affected_rows() == 1){
			return true;
		}else{
			return false;
		}
	}

	//=========================================================================================================================

	public function count_all(){
		$this->db->order_by('role_name','asc');
		$where = "(role_name like '%".$this->input->post('search')."%' or role_description like '%".$this->input->post('search')."%') 
				and InActive = 0";
		$this->db->where($where);
		$query = $this->db->get("user_roles");
		return $query->num_rows();
	}


	public function verify_user_role_bef_del($user_role){
		$query=$this->db->query("SELECT * FROM users WHERE user_role='".$user_role."' " );
		return $query->row();

	}
}