<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Section_manager extends General{

	public function __construct(){
		parent::__construct();	
		$this->load->model("app/section_manager_model");
		$this->load->model("app/form_approval_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index(){	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

  	/*
    -----------------------------------
    start : user role restriction access checking.
    -----------------------------------
    */

    $this->data['manage_sect_mngr_settings']=$this->session->userdata('manage_sect_mngr_settings');
    $this->data['system_defined_icons'] = $this->general_model->system_defined_icons();

    /*
    -----------------------------------
    end : user role restriction access checking.
    -----------------------------------
    */


		$this->load->view('app/administrator/section_manager/index',$this->data);
	}	

	public function  add_section_manager()
	{

		$this->load->view('app/administrator/section_manager/add_section_manager',$this->data);
	}
	
	public function  view_section_manager()
	{
		$this->data['sectionmgrsList'] = $this->section_manager_model->load_sectionmgrsList();
		$this->load->view('app/administrator/section_manager/view_section_manager',$this->data);
	}
	public function setup_setting_class_level()
	{
		$this->data['action_']='';
		$this->data['flash_id']='';
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

	/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/
	General::system_audit_trail('Administrator','Section Manager','logfile_admin_section_manager','Update By Classification/Level Setup action|company|option'.$action.'|'.$company.''.$option,'UPDATE',$company);


		$insert= $this->section_manager_model->save_level_classification_settings($action,$company,$option);
		$this->data['flash_id']=$company;
		$this->data['action_']=$action;
		if($insert=='inserted')
		{	
			$this->session->set_flashdata('success_inserted',"Success");
		}
		elseif($insert=='updated')
		{	
			$this->session->set_flashdata('success_updated',"Success");
		}
		elseif($insert=='no_changes')
		{
			$this->session->set_flashdata('updated_nochanges',"Nochanges");
		}
		else
		{
			$this->session->set_flashdata('insert_error',"Error");
		}
		$this->data['classlevelList'] = $this->section_manager_model->classlevelList(); 
		$this->load->view('app/administrator/section_manager/setup_setting_class_level',$this->data);
	}

	public function delete_level_classification_setting($id)
	{
	/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/
	General::system_audit_trail('Administrator','Section Manager','logfile_admin_section_manager','Delete By Classification/Level'.$id,'DELETE',$id);


		$delete= $this->section_manager_model->delete_level_classification_settings($id);
		$this->data['flash_id']=$id;
		$this->data['action_']='delete';
		if($delete=='deleted')
		{	
			$this->session->set_flashdata('success_deleted',"Success");
		}
		else
		{
			$this->session->set_flashdata('delete_error',"Error");
		}
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
		$this->data['flash_id']='';
		$this->data['action_']='';
		$this->data['accessList'] = $this->section_manager_model->accessList(); 
		$this->load->view('app/administrator/section_manager/setup_allow_access',$this->data);
	}

	public function save_allowaccess_setting($action,$company,$option)
	{ 

	/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/
	General::system_audit_trail('Administrator','Section Manager','logfile_admin_section_manager','Allow to access personnel working schedule action|company|option'.$action.'|'.$company.'|'.$option,'INSERT',$option);

		$result= $this->section_manager_model->save_allowaccess_setting($action,$company,$option);
		$this->data['flash_id']=$company;
		$this->data['action_']=$action;
		if($result=='inserted')
		{	
			$this->session->set_flashdata('success_inserted',"Success");
		}
		elseif($result=='updated')
		{	
			$this->session->set_flashdata('success_updated',"Success");
		}
		elseif($result=='no_changes')
		{
			$this->session->set_flashdata('updated_nochanges',"Nochanges");
		}
		else
		{
			$this->session->set_flashdata('insert_error',"Error");
		}
		$this->data['accessList'] = $this->section_manager_model->accessList(); 
		$this->load->view('app/administrator/section_manager/setup_allow_access',$this->data);
	}
	public function delete_allow_access_setting	($id)
	{ 
	/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/
	General::system_audit_trail('Administrator','Section Manager','logfile_admin_section_manager','Allow to access personnel working schedule id'.$id,'DELETE',$id);


		$delete= $this->section_manager_model->delete_allow_access_setting($id);
		$this->data['flash_id']=$id;
		$this->data['action_']='delete';
		if($delete=='deleted')
		{	
			$this->session->set_flashdata('success_deleted',"Success");
		}
		elseif($delete=='error')
		{	
			$this->session->set_flashdata('error_deleted',"Error");
		}
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

	// public function save_section_managers($company,$division,$department,$section,$subsection,$location,$section_mgr)
	// {
	// 	$this->data['insert'] = $this->section_manager_model->save_section_managers($company,$division,$department,$section,$subsection,$location,$section_mgr);
	// 	$this->data['sectionmgrsList'] = $this->section_manager_model->load_sectionmgrsList();
	// 	$this->load->view('app/administrator/section_manager/view_section_manager',$this->data);
	// }

	public function delete_section_mngrs($id)
	{ 
		$this->data['id']=$id;
		$this->data['sectionmgrsDel'] = $this->section_manager_model->sectionmgrsDel($id);
		$this->load->view('app/administrator/section_manager/delete_section_managers_list',$this->data);
	}
	
	public function delete_selected_company($id)
	{  


	/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/
	General::system_audit_trail('Administrator','Section Manager','logfile_admin_section_manager','Delete All Section Managers of company: '.$id,'INSERT',$id);
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

	/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/
	General::system_audit_trail('Administrator','Section Manager','logfile_admin_section_manager','Delete Section Manager company|id '.$company.'|'.$id,'INSERT',$id);

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


	/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/
	General::system_audit_trail('Administrator','Section Manager','logfile_admin_section_manager',$value.' Section Manager company|id '.$company.'|'.$id,'ENABLE/DISABLE',$id);

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
       
         if($with_subsection==1){ } else{ echo "<option value='no_div'>Subsection is not required</option>";}
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


	//for adding section manager
	public function load_division($id){	
		$with_division = $this->section_manager_model->with_division($id);	
		$divisionList = $this->section_manager_model->load_division($id);
		echo " <option value='0'  selected='selected' disabled=''>Select</option> ";                        
       
       if($with_division==1){  } else{ echo " <option value='not_included'>Division is not required</option>";}
       if(empty($divisionList) AND $with_division==1){
       	echo " <option value='0'>No division added in this company.Please add division first to continue. </option>";
       }else{
       	echo " <option value='All'>All</option> ";  
        foreach($divisionList as $div){
        echo "<option value='".$div->division_id."' >".$div->division_name."</option>";
        } }
	}
	public function loadLocation($val)
	{
		$locationList = $this->section_manager_model->load_locations($val);
		if(empty($locationList)){ echo " <option value='0'>No location added in this company. Please add location first to cotinue.</option> "; }
		else{
		echo '<option value="0"  selected="selected" disabled="">-Select Location-</option>'; 
			echo " <option value='All'>All</option> ";  
		foreach ($locationList as $loc) {
			echo "<option value='".$loc->location_id."'>".$loc->location_name."</option>";
		} }
	}
	public function load_dept($id,$company){	

		$departmentList = $this->section_manager_model->load_dept($id,$company);
		echo ' <option value="0"  selected="selected" disabled="">-Select Department-</option>'; 
			if(empty($departmentList)) { echo " <option value='0'>No department added in this company.Please add department first to continue. </option>"; } else{ echo "<option value='All'>All</option>"; } 	
		foreach($departmentList as $dpt){
        echo "<option value='".$dpt->department_id."' >".$dpt->dept_name."</option>";
        }
	}
	public function load_section($id,$div,$dept){	
		
		$sectionList = $this->section_manager_model->load_section($id,$div,$dept);
		echo '<option value="0"  selected="selected" disabled="">-Select Section-</option>';
			if(empty($sectionList)) { echo " <option value='0'>No section added in this company.Please add section first to continue. </option>"; } else{ echo "<option value='All'>All</option>"; } 	
        foreach($sectionList as $sec){
        echo "<option value='".$sec->section_id."' >".$sec->section_name."</option>";
        }
	}
	public function load_subsection($val,$div,$dept,$company)
	{ 
		$with_subsection = $this->section_manager_model->with_subsection($val);	
		$subsectionList = $this->section_manager_model->load_subsections($val);


		echo '<option value="0"  selected="selected" disabled="">-Select Subsection-</option>';                     
       	if($with_subsection==1){ if(empty($subsectionList)) { echo " <option value='0'>No subsection added in this company.Please add subsection first to continue. 
       		</option>"; } else{ echo "<option value='All'>All</option>"; }  } else{ echo "<option value='not_included'>Subsection is not required</option>";}?>
        <?php 
        foreach($subsectionList as $sub){
        echo "<option value='".$sub->subsection_id."' >".$sub->subsection_name."</option>";
        }
	}
	public function save_section_mngr($company,$division,$department,$section,$subsection,$employee_id,$location)
		{
		if($location=='All')
		{
		$locationList = $this->form_approval_model->locationList($company);
		foreach ($locationList as $loc) 
			{
			
				$insert = $this->section_manager_model->save_section_mngr($company,$division,$department,$section,$subsection,$employee_id,$loc->location_id);
			
			}
		}	
		else{
					$insert = $this->section_manager_model->save_section_mngr($company,$division,$department,$section,$subsection,$employee_id,$location);
			}


	/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/
	General::system_audit_trail('Administrator','Section Manager','logfile_admin_section_manager','Add Section Manager company|division|department|section|subsection|employee_id '.$company.'|'.$division.'|'.$department.'|'.$section.'|'.$subsection.'|'.$employee_id.'|'.$location,'INSERT',$employee_id);

	
 		$this->data['sectionmgrsList'] = $this->section_manager_model->load_sectionmgrsList();
		$this->load->view('app/administrator/section_manager/view_section_manager',$this->data);
		}

	public function setup_plot_own_sched()
	{
		$this->data['flash_id']='';
		$this->data['action_']='';

		 $this->data['details'] = $this->section_manager_model->section_manager_plot_own_schedule(); 
		 $this->load->view('app/administrator/section_manager/section_manager_plot_own_schedule',$this->data);
	}

	public function save_plot_own_schedule($action,$company,$option)
	{ 


	/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/
	General::system_audit_trail('Administrator','Section Manager','logfile_admin_section_manager','Allow Managers to plot their own schedule '.$action.'|'.$company.'|'.$option,'INSERT',$option);

		$result= $this->section_manager_model->save_plot_own_schedule($action,$company,$option);
		$this->data['flash_id']=$company;
		$this->data['action_']=$action;
		if($result=='inserted')
		{	
			$this->session->set_flashdata('success_inserted',"Success");
		}
		elseif($result=='updated')
		{	
			$this->session->set_flashdata('success_updated',"Success");
		}
		elseif($result=='no_changes')
		{
			$this->session->set_flashdata('updated_nochanges',"Nochanges");
		}
		else
		{
			$this->session->set_flashdata('insert_error',"Error");
		}
		$this->data['details'] = $this->section_manager_model->section_manager_plot_own_schedule(); 
		$this->load->view('app/administrator/section_manager/section_manager_plot_own_schedule',$this->data);
	}

	public function deleteDetails_plotschedule($id)
	{  

	/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/
	General::system_audit_trail('Administrator','Section Manager','logfile_admin_section_manager','Allow Managers to plot their own schedule '.$id,'DELETE',$id);

		$delete= $this->section_manager_model->deleteDetails_plotschedule($id);
		$this->data['flash_id']=$id;
		$this->data['action_']='delete';
		if($delete=='deleted')
		{	
			$this->session->set_flashdata('success_deleted',"Success");
		}
		elseif($delete=='error')
		{	
			$this->session->set_flashdata('error_deleted',"Error");
		}
		$this->data['details'] = $this->section_manager_model->section_manager_plot_own_schedule();
		$this->load->view('app/administrator/section_manager/section_manager_plot_own_schedule',$this->data);
	}

	public function editform_plotschedule($id)
	{
		$this->data['access'] = $this->section_manager_model->allow_plot_own_schedule_one($id); 
		$this->load->view('app/administrator/section_manager/edit_section_manager_plot_own_schedule',$this->data);
	}


}



