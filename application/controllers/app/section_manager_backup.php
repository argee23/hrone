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

	public function load_locations(){
		$id = $this->uri->segment('4');
		$this->data['comp_id'] = $this->section_manager_model->load_locations($id);
		$this->load->view('app/administrator/section_manager/location_list',$this->data);
	}	

	public function show_dept_sect(){	
		
		$id = $this->uri->segment('5');
		$this->data['departmentList'] = $this->section_manager_model->load_dept($id);
		$this->load->view('app/administrator/section_manager/view',$this->data);
	}

	public function load_dept(){	
		
		$id = $this->uri->segment('4');
		$this->data['departmentList'] = $this->section_manager_model->load_dept($id);
		//$this->data['locationList']	  = $this->section_manager_model->load_locations($id);
		$this->load->view('app/administrator/section_manager/department_list',$this->data);
	}

	public function load_add_locations(){
		$id = $this->uri->segment('4');
		$this->data['locationList'] = $this->section_manager_model->load_locations($id);
		$this->load->view('app/administrator/section_manager/location_list',$this->data);
	}

	public function remove_section_managers(){

		$place 			= $this->uri->segment("4");
		$company  		= $this->uri->segment('5');

		if($place == 'all'){
			$get_all_loc = $this->section_manager_model->load_locations($company);

			foreach ($get_all_loc as $locate){

				$place 			= $locate->location_id;

				$location 		= $this->section_manager_model->get_location($place);
				$location_id	= $location->location_id;
				$company_n		= $this->section_manager_model->name_company($company);	
				$company_name 	= $company_n->company_name;

				$inquire = $this->section_manager_model->get_mgr_on_loc($company,$location_id);

				foreach ($inquire as $check){
					$emp_id = $check->manager;
					$get = $this->section_manager_model->check_working_schedule_group($emp_id);

					if($get > 0){
						//do nothing
					}
					else{
						$this->db->query("DELETE FROM section_manager WHERE location = '".$place."' AND InActive = '0' AND manager = '".$emp_id."' ");		 //permanently deleted
					}
				}
			}

			$log = "All Managers = ".$company_name." : All Locations";

			General::logfile('Section Managers','DELETE',$log);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Section Managers of , <strong>".$company_name."</strong> for <em> All Locations </em>, were Successfully Deleted!</div>");

			$this->session->set_flashdata('onload',"show_managers(".$place.")");
			redirect(base_url().'app/section_manager/index',$this->data);

		}

		else {

			$location 		= $this->section_manager_model->get_location($place);
			$location_name 	= $location->location_name;
			$location_id	= $location->location_id;
			$company_n		= $this->section_manager_model->name_company($company);	
			$company_name 	= $company_n->company_name;

			$inquire = $this->section_manager_model->get_mgr_on_loc($company,$location_id);

			foreach ($inquire as $check){
				$emp_id = $check->manager;
				$get = $this->section_manager_model->check_working_schedule_group($emp_id);

				if($get > 0){
					//do nothing
				}
				else{
					$this->db->query("DELETE FROM section_manager WHERE location = '".$place."' AND InActive = '0' AND manager = '".$emp_id."' ");		 //permanently deleted
				}
			}
		
		// $this->db->query("DELETE FROM section_manager WHERE location = '".$place."' AND InActive = '0' ");		 //permanently deleted
		//$location_id= $section_manager->location_id;
		//$location_name= $section_manager->location_name;
		// logfile

			$value = $location_name;
			$log = "All Managers = ".$company_name." : ".$location_name;

			General::logfile('Section Managers','DELETE',$log);
			
			$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Section Managers of , <strong>".$company_name."</strong> in <em>". $value."</em>, is Successfully Deleted!</div>");

			$this->session->set_flashdata('onload',"show_managers(".$place.")");
			redirect(base_url().'app/section_manager/index',$this->data);

		}

		// $place = $this->uri->segment("4"); //location

		// $section_manager = $this->section_manager_model->get_location($place);
		
		// $this->db->query("delete from section_manager where location = ".$place);		 //permanently deleted
		// $location_id= $section_manager->location_id;
		// $location_name= $section_manager->location_name;
		// // logfile
		// $value = "$location_name";
		// General::logfile('Section Managers','DELETE',$value);
			
		// $this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Section Managers of , <strong>".$value."</strong>, is Successfully Deleted!</div>");

		//$this->session->set_flashdata('onload',"gotoPage(".$location_id.")");
		//$this->session->set_flashdata('onload',"show_managers(".$location_id.")");
		//redirect(base_url().'app/file_maintenance/index',$this->data);
	}
	public function delete_manager(){

		$id = $this->uri->segment("4");

		$section_manager 	= $this->section_manager_model->get_manager($id);
		$emp_id				= $section_manager->manager;
		$value 				= $section_manager->name;

		$check 				= $this->section_manager_model->check_working_schedule_group($emp_id);

		if ($check > 0){
			$this->session->set_flashdata('message',"<div class='alert alert-warning alert-dismissable'><i class='fa fa-times'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Section Manager, <strong>".$value."</strong>, is existing on a work group and cannot be deleted! Can make inactive for an alternative.</div>");

			$this->session->set_flashdata('onload',"show_managers(".$location.")");
			redirect(base_url().'app/section_manager/index',$this->data);
		}

		else{
		
		$this->db->query("DELETE FROM section_manager WHERE id = ".$id);		
		$location= $section_manager->section_manager_location;
		// logfile
		General::logfile('Section Manager','DELETE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Section Manager, <strong>".$value."</strong>, is Successfully Deleted!</div>");

		$this->session->set_flashdata('onload',"show_managers(".$location.")");
		redirect(base_url().'app/section_manager/index',$this->data);
		}
	}

	public function deactivate_manager(){

		$id = $this->uri->segment("4");

		$section_manager = $this->section_manager_model->get_manager($id);
		
		$this->db->query("UPDATE section_manager SET InActive = 1 WHERE id = ".$id);		
		$location= $section_manager->section_manager_location;
		// logfile
		$value = $section_manager->name;
		General::logfile('Section Manager','DEACTIVATE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Section Manager, <strong>".$value."</strong>, is Successfully Deactivated!</div>");

		$this->session->set_flashdata('onload',"show_managers(".$location.")");
		redirect(base_url().'app/section_manager/index',$this->data);
	}

	public function activate_manager(){

		$id = $this->uri->segment("4");

		$section_manager = $this->section_manager_model->get_manager($id);
		
		$this->db->query("UPDATE section_manager SET InActive = 0 WHERE id = ".$id);		
		$location= $section_manager->section_manager_location;
		// logfile
		$value = $section_manager->name;
		General::logfile('Section Manager','ACTIVATE',$value);
			
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Section Manager, <strong>".$value."</strong>, is Successfully Activated!</div>");

		$this->session->set_flashdata('onload',"show_managers(".$location.")");
		redirect(base_url().'app/section_manager/index',$this->data);
	}

	public function manager_settings(){
		$this->load->view('app/administrator/section_manager/company_list',$this->data);
	}

	public function settings(){
		$company_id = $this->uri->segment("4");
		$this->data['class_level_access']=$this->section_manager_model->class_level_access($company_id);
		$this->load->view('app/administrator/section_manager/settings',$this->data);
	}

	public function position(){
		$this->load->view('app/administrator/section_manager/position_list',$this->data);
	}

	public function classification(){
		$company_id = $this->uri->segment('4');
		$this->data['classification_list'] = $this->section_manager_model->check_classification($company_id);
		$this->load->view('app/administrator/section_manager/classification_list',$this->data);
	}
	
	public function get_section(){	
		// $dept_id=$this->uri->segment('4');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	
		
		$this->load->view('app/administrator/section_manager/show_section',$this->data);
	}
	public function select_emp($val = NULL){	
		$selected_emp=$this->uri->segment('4');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->data['emp'] = $this->section_manager_model->get_selected_emp($selected_emp);
		
		$this->load->view('app/administrator/section_manager/show_employee',$this->data);
	}
	public function showSearchEmployee($val = NULL){

		$info = $this->uri->segment("5");
		$this->data['showEmployeeList'] = $this->section_manager_model->getSearch_Employee($val,$info); //getEmp //getSearch_Employee
		$this->load->view("app/administrator/section_manager/showEmployeeList",$this->data);	
	}
	//========================================
	public function save_settings(){

		$this->form_validation->set_rules("company_setting", "Company", "trim|required");
		$this->form_validation->set_rules("classification_level_access","Classification Level Access","trim|required");
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		if($this->form_validation->run()){
			$cla=	$this->input->post('classification_level_access');
			$company_id = $this->input->post('company_setting');

			$check = $this->section_manager_model->class_level_access($company_id);

			if ($check > 0){
				$this->db->where(array(
					'company_id'	=> $company_id
					));
				$this->data = array(
					'classification_level_access'=> $cla);
				$this->db->update("general",$this->data);
			}
			//	$this->db->query("update general set(classification_level_access) values(".$cla.") where id = 1".);	

			else{
				$this->data = array(
				'classification_level_access'	=> $cla,
				'company_id'					=> $company_id);
				$this->db->insert("general",$this->data);
			}

			// $this->db->where('id','1');
			// $this->data = array(
			// 	'classification_level_access'=> $cla);
			// $this->db->update("general",$this->data);

			// if ($cla == "by_position"){
			// 	$this->db->where(array(
			// 			'company_id' => $company_id
			// 		));
			// 	$this->data = array('InActive' => 1);
			// 	$this->db->update('section_manager',$this->data);

			// 	$data['company_id'] =	$company_id;
			// 	$data['position']	= 	$this->input->post('position');

			// 	$this->auto_allot($data); 
			// }

			if ($cla == "by_classification"){
				$this->db->where(array(
						'company_id' => $company_id,

					));
				$this->data = array('InActive' => 1);
				$this->db->update('section_manager',$this->data);

				$data['company_id'] =	$company_id;
				$data['classification']	= 	$this->input->post('classification');

				$this->auto_allot($data); 
			}

			$value = $cla;

			General::logfile('Section Manager Classification Level Access','MODIFY',$value);
			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Section Manager Classification Level Access : Setting , is Successfully Modified!</div>");		


				$this->session->set_flashdata('onload',"manager_settings()");
				redirect(base_url().'app/section_manager/index',$this->data);
		}else{
			$this->index();
		}		
	}

	public function auto_allot($data){

		$employee_info = $this->section_manager_model->check_employee($data);

		foreach ($employee_info as $count) {
			$dept 	= $count->department;
			$data['id'] 	= $count->employee_id;
			$data['department']	= $dept;
			$data['company_id']	= $count->company_id;
			$data['section']	= $count->section;
			$data['location']	= $count->location;

			$check_if_mgr = $this->section_manager_model->check_section_manager($data);

			if ($check_if_mgr == null) {

				$this->data = array(
					'company_id'	=>		$data['company_id'],
					'department'	=>		$dept,
					'section'		=>		$count->section,
					'manager'		=>		$count->employee_id,
					'location'		=>		$count->location,
					'InActive'		=>		0
					);
				$this->db->insert("section_manager",$this->data);
			}

			else {
				$this->db->where(array(
					'manager'		=> 		$count->employee_id
					));
				$this->data = array(
					'InActive'		=>		0,
					);
				$this->db->update('section_manager', $this->data);
			}
		}
	}

	public function save_manager(){
		
		$this->form_validation->set_rules("company_add_mgr", "Company", "trim|required");
		$this->form_validation->set_rules("department","Department","trim|required");
		$this->form_validation->set_rules("section","Section","trim|required");
		//$this->form_validation->set_rules("classification","Classification","trim|required");
		$this->form_validation->set_rules('manager','Manager','trim|required');
		$this->form_validation->set_error_delimiters("<div class='alert alert-warning alert-dismissable'><i class='fa fa-warning'></i> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>","</div>");
		if($this->form_validation->run()){
			// save data	

		$comp=	$this->input->post('company_add_mgr');
		$dept=	$this->input->post('department');		
		$sect=	$this->input->post('section');		
		$selected_emp=	$this->input->post('manager');	

		$emp=$this->section_manager_model->get_emp($selected_emp);

		if ($dept == "all"){
			$departmentList = $this->section_manager_model->load_dept($comp);
			
			foreach ($departmentList as $key => $depList) {

				if ($sect == "all"){
					$dept_id 	 = $depList->department_id;
					$sectionList = $this->section_manager_model->getSec($dept_id);
					foreach ($sectionList as $secList){
						$sec_id = $secList->section_id;
						$this->db->query("DELETE FROM section_manager WHERE company_id = ".$comp." and department = ".$dept_id." and section = ".$sec_id." and manager = ".$selected_emp );
							
							foreach ($this->input->post('loc_id') as $key => $value){
							//save access level
							$this->data = array(
							'company_id'	=>		$comp,
							'department'	=>		$dept_id,
							'section'		=>		$sec_id,
							'manager'		=>		$selected_emp,
							'location'		=>		$value,
							'InActive'		=>		0
							);
							$this->db->insert("section_manager",$this->data);
							}
					// logfile
					$value = $emp->name;

					General::logfile('Section Manager','INSERT',$value);
			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Section Manager  <strong>".$value."</strong>, is Successfully Added!</div>");				
					}//sectionList
				}
				// else {
				// 	$this->db->query("DELETE FROM section_manager WHERE company_id = ".$comp." and department = ".$depList." and section = ".$sect." and manager = ".$selected_emp );			
				// 	foreach ($this->input->post('loc_id') as $key => $value)
				// 	{
				// 	//save access level
				// 		$this->data = array(
				// 			'company_id'	=>		$comp,
				// 			'department'	=>		$dept,
				// 			'section'		=>		$sect,
				// 			'manager'		=>		$selected_emp,
				// 			'location'		=>		$value,
				// 			'InActive'		=>		0
				// 			);
				// 		$this->db->insert("section_manager",$this->data);
				// 	}
				// 	// logfile
				// 	$value = $emp->name;

				// 	General::logfile('Section Manager','INSERT',$value);
			
				// 				$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Section Manager  <strong>".$value."</strong>, is Successfully Added!</div>");		


				// 		//$this->session->set_flashdata('onload',"show_managers(".$location.")");
				// 	redirect(base_url().'app/section_manager/index',$this->data);
				// }		
			}
		}

		else{
			if ($sect == "all"){
					$dept_id 	 = $dept;
					$sectionList = $this->section_manager_model->getSec($dept_id);
					foreach ($sectionList as $secList){
						$sec_id = $secList->section_id;
						$this->db->query("DELETE FROM section_manager WHERE company_id = ".$comp." and department = ".$dept_id." and section = ".$sec_id." and manager = ".$selected_emp );
							
							foreach ($this->input->post('loc_id') as $key => $value){
							//save access level
							$this->data = array(
							'company_id'	=>		$comp,
							'department'	=>		$dept_id,
							'section'		=>		$sec_id,
							'manager'		=>		$selected_emp,
							'location'		=>		$value,
							'InActive'		=>		0
							);
							$this->db->insert("section_manager",$this->data);
							}
					// logfile
					$value = $emp->name;

					General::logfile('Section Manager','INSERT',$value);
			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Section Manager  <strong>".$value."</strong>, is Successfully Added!</div>");				
					}//sectionList
				}
			else {
				$this->db->query("DELETE FROM section_manager WHERE company_id = ".$comp." and department = ".$dept." and section = ".$sect." and manager = ".$selected_emp );			
				foreach ($this->input->post('loc_id') as $key => $value)
				{
					//save access level
					$this->data = array(
						'company_id'	=>		$comp,
						'department'	=>		$dept,
						'section'		=>		$sect,
						'manager'		=>		$selected_emp,
						'location'		=>		$value,
						'InActive'		=>		0
					);
					$this->db->insert("section_manager",$this->data);
				}
			}
			$value = $emp->name;

			General::logfile('Section Manager','INSERT',$value);
			
								$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Section Manager  <strong>".$value."</strong>, is Successfully Added!</div>");
		}


		// $this->db->query("DELETE FROM section_manager WHERE company_id = ".$comp." and department = ".$dept." and section = ".$sect." and manager = ".$selected_emp );			
		// foreach ($this->input->post('loc_id') as $key => $value)
		// {
		// 	//save access level
		// 	$this->data = array(
		// 		'company_id'	=>		$comp,
		// 		'department'	=>		$dept,
		// 		'section'		=>		$sect,
		// 		'manager'		=>		$selected_emp,
		// 		'location'		=>		$value,
		// 		'InActive'		=>		0
		// 	);
		// 	$this->db->insert("section_manager",$this->data);
		// }
		// logfile
		// $value = $emp->name;

		// 	General::logfile('Section Manager','INSERT',$value);
			
		// 						$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Section Manager  <strong>".$value."</strong>, is Successfully Added!</div>");		


				//$this->session->set_flashdata('onload',"show_managers(".$location.")");
				redirect(base_url().'app/section_manager/index',$this->data);
		}
		else{
			$this->index();
		}		
	}
}//end controller



