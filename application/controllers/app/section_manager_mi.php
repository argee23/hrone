<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Section_manager extends General{

	public function __construct(){
		parent::__construct();	
		$this->load->model("app/section_manager_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index(){	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->load->view('app/administrator/section_manager/index',$this->data);
	}	

	public function  add_section_manager()
	{

		$this->load->view('app/administrator/section_manager/add_section_manager',$this->data);
	}
	public function load_division($id){	
		$this->data['with_division'] = $this->section_manager_model->with_division($id);	
		$this->data['divisionList'] = $this->section_manager_model->load_division($id);
		$this->load->view('app/administrator/section_manager/division_list',$this->data);
	}
	public function load_dept($id,$company){	

		$this->data['departmentList'] = $this->section_manager_model->load_dept($id,$company);
		$this->load->view('app/administrator/section_manager/department_list',$this->data);
	}
	public function load_section($id,$div,$dept){	
		
		$this->data['sectionList'] = $this->section_manager_model->load_section($id,$div,$dept);
		$this->load->view('app/administrator/section_manager/section_list',$this->data);
	}

	public function load_subsection($val,$div,$dept,$company)
	{ 
		$this->data['with_subsection'] = $this->section_manager_model->with_subsection($val);	
		$this->data['locationList'] = $this->section_manager_model->load_locations($company);
		$this->data['subsectionList'] = $this->section_manager_model->load_subsections($val);
		$this->load->view('app/administrator/section_manager/subsection_location_list',$this->data);
	}

	public function  view_section_manager()
	{
		$this->data['sectionmgrsList'] = $this->section_manager_model->load_sectionmgrsList();
		$this->load->view('app/administrator/section_manager/view_section_manager',$this->data);
	}
	public function setup_setting_class_level()
	{
		$this->data['classlevelList'] = $this->section_manager_model->classlevelList();
		$this->load->view('app/administrator/section_manager/setup_setting_class_level',$this->data);
	}
	public function class_level_result($company)
	{
		$this->data['classificationList'] = $this->section_manager_model->classificationList($company);
		$this->load->view('app/administrator/section_manager/class_level_result',$this->data);
	}	
	public function save_level_classification_setting($action,$company,$option)
	{  
		$this->data['result'] = $this->section_manager_model->save_level_classification_settings($action,$company,$option);
		$this->data['classlevelList'] = $this->section_manager_model->classlevelList(); 
		$this->load->view('app/administrator/section_manager/setup_setting_class_level',$this->data);
	}

	public function delete_level_classification_setting($id)
	{
		$this->data['delete'] = $this->section_manager_model->delete_level_classification_settings($id);
		$this->data['classlevelList'] = $this->section_manager_model->classlevelList(); 
		$this->load->view('app/administrator/section_manager/setup_setting_class_level',$this->data);
	}
	public function editform_level_classification_setting($id,$company)
	{
		$this->data['classlevelList_one'] = $this->section_manager_model->classlevelList_one($id);
		$this->data['classificationList'] = $this->section_manager_model->classificationList($company);
		foreach ($this->data['classlevelList_one'] as $row) {
		 	$this->data['class_level_result'] = $row->if_by_classification;
		 } 
		$this->load->view('app/administrator/section_manager/edit_classlevel_details',$this->data);
	}

	public function setup_allow_access($option,$action)
	{
		$this->data['accessList'] = $this->section_manager_model->accessList(); 
		$this->load->view('app/administrator/section_manager/setup_allow_access',$this->data);
	}

	public function save_allowaccess_setting($action,$company,$option)
	{ 
		$this->data['result'] = $this->section_manager_model->save_allowaccess_setting($action,$company,$option);
		$this->data['accessList'] = $this->section_manager_model->accessList(); 
		$this->load->view('app/administrator/section_manager/setup_allow_access',$this->data);
	}
	public function delete_allow_access_setting	($id)
	{ 
		$this->data['delete'] = $this->section_manager_model->delete_allow_access_setting($id);
		$this->data['accessList'] = $this->section_manager_model->accessList(); 
		$this->load->view('app/administrator/section_manager/setup_allow_access',$this->data);
	}

	public function editform_allow_access_setting($id)
	{
		$this->data['allowaccessList_one'] = $this->section_manager_model->allowaccessList_one($id); 
		$this->load->view('app/administrator/section_manager/edit_allow_access_details',$this->data);
	}

	public function delete_section_manager($option,$action)
	{
		$this->data['sectionmgrsList'] = $this->section_manager_model->load_sectionmgrsList();
		$this->load->view('app/administrator/section_manager/delete_section_managers',$this->data);
	}

	public function search_employee_list($search = NULL,$company_id = NULL)
	{
		$this->data['query'] = $this->section_manager_model->employeelist_model($search,$company_id);
		$this->load->view('app/administrator/section_manager/search_employee_list',$this->data);
	}

	public function save_section_managers($company,$division,$department,$section,$subsection,$location,$section_mgr)
	{
		$this->data['insert'] = $this->section_manager_model->save_section_managers($company,$division,$department,$section,$subsection,$location,$section_mgr);
		$this->data['sectionmgrsList'] = $this->section_manager_model->load_sectionmgrsList();
		$this->load->view('app/administrator/section_manager/view_section_manager',$this->data);
	}

	public function delete_section_mngrs($id)
	{ 
		$this->data['id']=$id;
		$this->data['sectionmgrsDel'] = $this->section_manager_model->sectionmgrsDel($id);
		$this->load->view('app/administrator/section_manager/delete_section_managers_list',$this->data);
	}
	
	public function delete_selected_company($id)
	{  
		$this->data['id']=$id;
		$this->data['delete'] = $this->section_manager_model->delete_managers($id);
		$this->data['sectionmgrsDel'] = $this->section_manager_model->sectionmgrsDel($id);
		$this->load->view('app/administrator/section_manager/delete_section_managers_list',$this->data);
	}

	
	public function delete_one_sectionmanagers($id,$company)
	{	
		$this->data['company'] = $company;
		$division = '0';
		$department ='0';
		$section='0';
		$subsection='0';
		$location='0';
		$this->data['delete'] = $this->section_manager_model->sectionmanagerDeOne($id,$company);
		$this->data['sectionmanagerList'] = $this->section_manager_model->sectionmanagerList($company,$division,$department,$section,$subsection,$location);
		$this->load->view('app/administrator/section_manager/section_managers',$this->data);
	}

	public function status_one_sectionmanagers($company,$id,$value)
	{ 
		$this->data['company'] = $company;
		$division = '0';
		$department ='0';
		$section='0';
		$subsection='0';
		$location='0';
		$this->data['status_update'] = $this->section_manager_model->status_update($id,$value);
		$this->data['sectionmanagerList'] = $this->section_manager_model->sectionmanagerList($company,$division,$department,$section,$subsection,$location);
		$this->load->view('app/administrator/section_manager/section_managers',$this->data);
	}
	public function section_managers($company)
	{
		$this->data['company'] = $company;
		$division = '0';
		$department ='0';
		$section='0';
		$subsection='0';
		$location='0';
		$this->data['sectionmanagerList'] = $this->section_manager_model->sectionmanagerList($company,$division,$department,$section,$subsection,$location);
		$this->load->view('app/administrator/section_manager/section_managers',$this->data);
	}
	public function division_filtering($company)
	{
		$with_division = $this->section_manager_model->with_division($company);	
		$divisionList = $this->section_manager_model->load_division($company);
		 echo "<option value=''  selected='selected' disabled=''>Select</option> ";                        
       	if($with_division==1){  } else{ echo "<option value='no_div'>Division is not required</option>";}
      	foreach($divisionList as $div){
        echo "<option value='".$div->division_id."' >".$div->division_name."</option>";
        }
     
	}

	public function section_managers_withdivision($company,$division)
	{
		$this->data['company'] = $company;
		$department ='0';
		$section='0';
		$subsection ='0';
		$location ='0';
		$this->data['sectionmanagerList'] = $this->section_manager_model->sectionmanagerList($company,$division,$department,$section,$subsection,$location);
		$this->load->view('app/administrator/section_manager/section_managers',$this->data);
	}
	public function section_managers_withdepartment($company,$division,$department)
	{
		$this->data['company'] = $company;
		$section='0';
		$subsection='0';
		$location='0';
		$this->data['sectionmanagerList'] = $this->section_manager_model->sectionmanagerList($company,$division,$department,$section,$subsection,$location);
		$this->load->view('app/administrator/section_manager/section_managers',$this->data);
	}
	public function departments_filtering($company,$division)
	{
		$departmentList = $this->section_manager_model->load_dept($division,$company); 
		 echo '<option value=""  selected="selected" disabled="">-Select Department-</option>';
      
        foreach($departmentList as $dpt){
        echo "<option value='".$dpt->department_id."' >".$dpt->dept_name."</option>";
        }
        
	}
	public function sections_filtering($company,$division,$department)
	{
		$sectionList = $this->section_manager_model->load_section($company,$division,$department);
		
		 echo '<option value=""  selected="selected" disabled="">-Select Section-</option>';
        foreach($sectionList as $sec){
        echo "<option value='".$sec->section_id."' >".$sec->section_name."</option>";
       
        }
        
	}
	public function section_managers_withsection($company,$division,$department,$section)
	{
		$this->data['company'] = $company;
		$location='0';
		$subsection='0';
		$this->data['sectionmanagerList'] = $this->section_manager_model->sectionmanagerList($company,$division,$department,$section,$subsection,$location);
		$this->load->view('app/administrator/section_manager/section_managers',$this->data);
	}

	public function subsections_filtering($company,$division,$department,$section)
	{
		$with_subsection = $this->section_manager_model->with_subsection($section);
		$subsectionList = $this->section_manager_model->load_subsections($section);
		echo '<option value=""  selected="selected" disabled="">-Select Subsection-</option>';                      
       
         if($with_division==1){ } else{ echo "<option value='no_div'>Subsection is not required</option>";}
        foreach($subsectionList as $sub){
        echo "<option value='".$sub->subsection_id."' >".$sub->subsection_name."</option>";
        }
	}

	public function section_managers_withsubsection($company,$division,$department,$section,$subsection)
	{
		$this->data['company'] = $company;
		$location='0';
		$this->data['sectionmanagerList'] = $this->section_manager_model->sectionmanagerList($company,$division,$department,$section,$subsection,$location);
		$this->load->view('app/administrator/section_manager/section_managers',$this->data);
	}

	public function locations_filtering($company)
	{
		$locationList = $this->section_manager_model->load_locations($company);
		echo '<option value=""  selected="selected" disabled="">-Select Location-</option> <option value="All" >All</option> ';
      
        foreach($locationList as $loc){
        echo "<option value='".$loc->location_id."' >".$loc->location_name."</option>";
        }
      
	}

	public function section_managers_withlocation($company,$division,$department,$section,$subsection,$location)
	{
		$this->data['company'] = $company;
		$locationList = $this->section_manager_model->load_locations($company);
		$this->data['sectionmanagerList'] = $this->section_manager_model->sectionmanagerList($company,$division,$department,$section,$subsection,$location);
		$this->load->view('app/administrator/section_manager/section_managers',$this->data);
	}


}



