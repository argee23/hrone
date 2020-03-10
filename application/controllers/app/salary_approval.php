<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Salary_approval extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/form_approval_model");
		$this->load->model("app/salary_approval_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index()
	{
		$this->load->view('app/salary_approval/index',$this->data);
	}

	public function add_no_approver()
	{
		$this->data['action_']='';
		$this->data['flash_id']='';
		$this->data['setting_no_approver'] = $this->salary_approval_model->setting_no_approver();
		$this->load->view('app/salary_approval/add_no_approver',$this->data);
	}
	public function save_add_no_approver($setting_company,$setting_approver)
	{

		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Salary Approval','logfile_admin_salary_approval','Add Maximum Salary Approvers'.$setting_company.'|'.$setting_approver,'INSERT',$setting_approver);

		$insert = $this->salary_approval_model->save_add_no_approver($setting_company,$setting_approver);
		$this->data['flash_id']=$setting_company;
		$this->data['action_']='add';
		if($insert=='inserted')
		{	
			$this->session->set_flashdata('success_inserted',"Success");
		}
		else
		{
			$this->session->set_flashdata('insert_error',"Error");
		}
		$this->data["companyList"]=$this->general_model->companyList();
		$this->data['setting_no_approver'] = $this->salary_approval_model->setting_no_approver();
		$this->load->view('app/salary_approval/add_no_approver',$this->data);
	}
	public function delete_setting_no_approver($id)
	{
		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Salary Approval','logfile_admin_salary_approval','Delete Maximum Salary Approvers'.$id,'DELETE',$id);

		$delete = $this->salary_approval_model->delete_setting_no_approver($id);
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
		$this->data['setting_no_approver'] = $this->salary_approval_model->setting_no_approver();
		$this->load->view('app/salary_approval/add_no_approver',$this->data);
	}
	public function edit_setting_no_approver($id,$company)
	{
		$this->data['company_id']= $company;
		$this->data['no_approver'] = $this->salary_approval_model->no_approver($id);
		$this->load->view('app/salary_approval/edit_setting_no_approver_form',$this->data);
	}
	public function saveupdate_no_approver_setting($company_id,$setting_approver)
	{
		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Salary Approval','logfile_admin_salary_approval','Update Maximum Salary Approvers'.$company_id.'|'.$setting_approver,'UPDATE',$setting_approver);

		$update = $this->salary_approval_model->saveupdate_no_approver_setting($company_id,$setting_approver);
		$this->data['flash_id']=$company_id;
		$this->data['action_']='update';
		if($update=='updated')
		{	
			$this->session->set_flashdata('success_updated',"Success");
		}
		else
		{
			$this->session->set_flashdata('update_error',"Error");
		}
		$this->data['setting_no_approver'] = $this->salary_approval_model->setting_no_approver();
		$this->load->view('app/salary_approval/add_no_approver',$this->data);
	}
	public function add_approver_choices()
	{
		$this->data['flash_id']='';
		$this->data['action_']='';
		$this->data['approver_list'] = $this->salary_approval_model->approver_list();
		$this->load->view('app/salary_approval/approver_choices',$this->data);
	}
	public function showSearchEmployeelist($val = NULL){
		$this->data['showEmployeeList'] = $this->salary_approval_model->getSearch_EmployeeList($val); //getEmp //getSearch_Employee
		$this->load->view("app/salary_approval/showEmployeeList",$this->data);	
	}
	public function add_new_approver_choices($employee_id)
	{
		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Salary Approval','logfile_admin_salary_approval','Add Salary Approver Choices'.$employee_id,'INSERT',$employee_id);


		$insert = $this->salary_approval_model->add_new_approver_choices($employee_id);
		$this->data['flash_id']=$employee_id;
		$this->data['action_']='add';
		if($insert=='inserted')
		{	
			$this->session->set_flashdata('success_inserted',"Success");
		}
		else
		{
			$this->session->set_flashdata('insert_error',"Error");
		}
		$this->data['approver_list'] = $this->salary_approval_model->approver_list();
		$this->load->view('app/salary_approval/approver_choices',$this->data);
	}
	public function delete_approver($id)
	{
		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Salary Approval','logfile_admin_salary_approval','Delete Salary Approver Choices'.$id,'DELETE',$id);

		$delete = $this->salary_approval_model->delete_approver($id);
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
		 $this->data['approver_list'] = $this->salary_approval_model->approver_list();
		$this->load->view('app/salary_approval/approver_choices',$this->data);
	}

	//salary approvers by company

	public function get_salary_approvers($company)
	{
		$this->data['action_']="";
		$this->data['flash_id']="";
		$this->data['classification']='All';
		$this->data['location'] = 'All';


		$this->data['company']=$company;
		$this->data['with_division'] = $this->form_approval_model->with_division($company);
		$this->data['division'] = $this->form_approval_model->load_division($company);

		$this->data['locationList'] = $this->form_approval_model->locationList($company);
		$this->data['classificationList'] = $this->form_approval_model->classificationList($company);
		$this->data['company_name'] = $this->salary_approval_model->get_company_name($company); 
 		$this->data['approver_details'] = $this->salary_approval_model->salary_approvers($company); 

 		$check_with_division = $this->form_approval_model->with_division($company);
		$this->data['with_division']=$check_with_division;
		if($check_with_division > 0)
		{
			$this->data['get_division'] = $this->form_approval_model->load_division($company);
		}
		else
		{
			$this->data['get_department'] = $this->form_approval_model->with_department_viewing($company,'All');
		}

		$this->load->view('app/salary_approval/manage_salary',$this->data);
	}
	public function manage_salary_add($company)
	{
		$this->data['with_division'] = $this->form_approval_model->with_division($company);
		$this->data['division'] = $this->form_approval_model->load_division($company);
		$this->data['approver_setting'] = $this->salary_approval_model->approver_setting($company);
		$this->data['classification'] = $this->form_approval_model->classificationList($company);
		$this->data['location'] = $this->form_approval_model->locationList($company);
		$this->data['company']=$company;
		$this->load->view('app/salary_approval/manage_salary_add',$this->data);
	}
	public function addnew_showSearchResult($val = NULL,$company = NULL )
	{
		$this->data['addnew_showSearchResult'] = $this->salary_approval_model->addnew_showSearchResult($val,$company); 
		$this->load->view("app/salary_approval/approver_showEmployeeList",$this->data);
	}
	public function savenew_approver_trans($company,$division,$department,$section,$subsection,$employee_id,$position,$classification,$approval_number,$approvallevel,$location)
	{
		
		
		if($location=='All')
		{
			$locationList = $this->form_approval_model->locationList($company);
			foreach ($locationList as $loc) {
				if($classification=='All')
				{
					$classificationList = $this->form_approval_model->classificationList($company);
					foreach ($classificationList as $class) {
						$insert = $this->salary_approval_model->savenew_approver_trans($company,$division,$department,$section,$subsection,$employee_id,$position,$class->classification_id,$approval_number,$approvallevel,$loc->location_id); 

							/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/
							General::system_audit_trail('Administrator','Salary Approval','logfile_admin_salary_approval','Add Approvers company|division|department|section|subsection|employee_id|position|classification_id|approval_number|approvallevel|location_id'.$company.'|'.$division.'|'.$department.'|'.$section.'|'.$subsection.'|'.$employee_id.'|'.$position.'|'.$class->classification_id.'|'.$approval_number.'|'.$approvallevel.'|'.$loc->location_id,'INSERT',$employee_id);

					}
				}
				else
				{
					$insert = $this->salary_approval_model->savenew_approver_trans($company,$division,$department,$section,$subsection,$employee_id,$position,$classification,$approval_number,$approvallevel,$loc->location_id);
							/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/
							General::system_audit_trail('Administrator','Salary Approval','logfile_admin_salary_approval','Add Approvers company|division|department|section|subsection|employee_id|position|classification_id|approval_number|approvallevel|location_id'.$company.'|'.$division.'|'.$department.'|'.$section.'|'.$subsection.'|'.$employee_id.'|'.$position.'|'.$classification.'|'.$approval_number.'|'.$approvallevel.'|'.$loc->location_id,'INSERT',$employee_id);

				}
			}
		}	
		else
		{
			if($classification=='All')
				{
					$classificationList = $this->form_approval_model->classificationList($company);
						foreach ($classificationList as $class) {
						$insert = $this->salary_approval_model->savenew_approver_trans($company,$division,$department,$section,$subsection,$employee_id,$position,$class->classification_id,$approval_number,$approvallevel,$location);
							/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/
							General::system_audit_trail('Administrator','Salary Approval','logfile_admin_salary_approval','Add Approvers company|division|department|section|subsection|employee_id|position|classification_id|approval_number|approvallevel|location_id'.$company.'|'.$division.'|'.$department.'|'.$section.'|'.$subsection.'|'.$employee_id.'|'.$position.'|'.$class->classification_id.'|'.$approval_number.'|'.$approvallevel.'|'.$location,'INSERT',$employee_id);



						}
				}
				else
				{ 
						$insert = $this->salary_approval_model->savenew_approver_trans($company,$division,$department,$section,$subsection,$employee_id,$position,$classification,$approval_number,$approvallevel,$location);
							/*
							--------------audit trail composition--------------
							(module,module dropdown,logfiletable,detailed action,action type,key value)
							--------------audit trail composition--------------
							*/
							General::system_audit_trail('Administrator','Salary Approval','logfile_admin_salary_approval','Add Approvers company|division|department|section|subsection|employee_id|position|classification_id|approval_number|approvallevel|location_id'.$company.'|'.$division.'|'.$department.'|'.$section.'|'.$subsection.'|'.$employee_id.'|'.$position.'|'.$classification.'|'.$approval_number.'|'.$approvallevel.'|'.$location,'INSERT',$employee_id);

				}
		}	



		$this->data['with_division'] = $this->form_approval_model->with_division($company);
		$this->data['division'] = $this->form_approval_model->load_division($company);
		$this->data['classification']='All';
		$this->data['location'] = 'All';
		$this->data['locationList'] = $this->form_approval_model->locationList($company);
		$this->data['classificationList'] = $this->form_approval_model->classificationList($company);
		$check_with_division = $this->form_approval_model->with_division($company);
		$this->data['with_division']=$check_with_division;
		if($check_with_division > 0)
		{
			$this->data['get_division'] = $this->form_approval_model->load_division($company);
		}
		else
		{
			$this->data['get_department'] = $this->form_approval_model->with_department_viewing($company,'All');
		}

		$this->data['approver_details'] = $this->salary_approval_model->salary_approvers($company); 
		$this->data['company_name'] = $this->salary_approval_model->get_company_name($company); 
		$this->data['company']=$company;
		$this->data['flash_id']=$company;
		$this->data['action_']='add';
		$this->session->set_flashdata('success_inserted',"Success");
 		$this->load->view('app/salary_approval/manage_salary',$this->data);
	}
	public function delete_all_approver($company)
	{
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Salary Approval','logfile_admin_salary_approval','Delete Salary Approvers of company : '.$company,'DELETE',$company);

		$action = $this->salary_approval_model->delete_all_approver($company);

		$this->data['with_division'] = $this->form_approval_model->with_division($company);
		$this->data['division'] = $this->form_approval_model->load_division($company);
		$this->data['classification']='All';
		$this->data['location'] = 'All';
		$this->data['locationList'] = $this->form_approval_model->locationList($company);
		$this->data['classificationList'] = $this->form_approval_model->classificationList($company);
		$check_with_division = $this->form_approval_model->with_division($company);
		$this->data['with_division']=$check_with_division;
		if($check_with_division > 0)
		{
			$this->data['get_division'] = $this->form_approval_model->load_division($company);
		}
		else
		{
			$this->data['get_department'] = $this->form_approval_model->with_department_viewing($company,'All');
		}

		$this->data['approver_details'] = $this->salary_approval_model->salary_approvers($company); 
		$this->data['company_name'] = $this->salary_approval_model->get_company_name($company);
		$this->data['company']=$company;
		$this->data['flash_id']=$company;
		$this->data['action_']='delete';
		$this->session->set_flashdata('success_delete_all',"delete_all");
 		$this->load->view('app/salary_approval/manage_salary',$this->data);
	}

	public function view_filtered_salary_results($company,$department,$section,$subsection,$location,$classification)
	{
		$this->data['approver_details'] = $this->salary_approval_model->salary_approvers_filter($company,$department,$section,$subsection,$location,$classification); 
		$this->load->view('app/salary_approval/filter_list',$this->data);
	}
	public function get_department($department,$company)
	{

	}

	//automatic update of approval status

	public function automatic_update_status()
	{
		$this->data['action_']='';
		$this->data['flash_id']='';
		$this->data['company_id']='';
		$this->data['details'] = $this->salary_approval_model->automatic_update_status(); 
 		$this->load->view('app/salary_approval/automatic_update_status',$this->data);
	}

	public function save_automatic_update_status($company,$action,$days)
	{
		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Salary Approval','logfile_admin_salary_approval','Add Auto Approve/Cancel/reject Salary(company|action|days'.$company.'|'.$action.'|'.$days,'INSERT',$company);


		$this->data['action_']='add';
		$this->data['flash_id']=$company;
		$this->data['company_id']=$company;
		$insert = $this->salary_approval_model->save_automatic_update_status($company,$action,$days);
		$this->data['details'] = $this->salary_approval_model->automatic_update_status(); 
		$this->session->set_flashdata($insert,"Success");
 		$this->load->view('app/salary_approval/automatic_update_status',$this->data);
	}
	public function settings_automatic_update_status($action,$company)
	{

		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Salary Approval','logfile_admin_salary_approval',$action.' Auto Approve/Cancel/reject Salary(company|action|days'.$company,$action,$company);		

		$this->data['action_']=$action;
		$this->data['flash_id']=$company;
		$this->data['company_id']=$company;
		$actionn  = $this->salary_approval_model->settings_automatic_update_status($action,$company);
		$this->data['details'] = $this->salary_approval_model->automatic_update_status(); 
		$this->session->set_flashdata($actionn,$actionn);
 		$this->load->view('app/salary_approval/automatic_update_status',$this->data);
	}
	public function settings_update_automatic_update_status($company)
	{
		$this->data['details_one'] = $this->salary_approval_model->get_automatic_details_one($company); 
		$this->load->view('app/salary_approval/automatic_update_status_update',$this->data);
	}
	public function saveupdate_automatic_update_status($company,$action,$days)
	{

		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Salary Approval','logfile_admin_salary_approval','Update Auto Approve/Cancel/reject Salary(company|action|days'.$company.'|'.$action.'|'.$days,'UPDATE',$company);		
		$this->data['action_']='update';
		$this->data['flash_id']=$company;
		$this->data['company_id']=$company;
		$update = $this->salary_approval_model->saveupdate_automatic_update_status($company,$action,$days);
		$this->data['details'] = $this->salary_approval_model->automatic_update_status(); 
		$this->session->set_flashdata($update,"Success");
 		$this->load->view('app/salary_approval/automatic_update_status',$this->data);
	}


	//filtering

	public function filter_get_department($division,$company)
	{
		$dept= $this->salary_approval_model->filter_get_department($division,$company);
		
		if(empty($dept))
		{
			echo "<option value='not_included' disabled selected>Select</option>";
			echo "<option value='not_included'>No department/s found.</option>";
		}
		else
		{
			echo "<option value='not_included' disabled selected>Select</option>";
			// echo "<option value='all'>All</option>";
			foreach($dept as $d)
			{
				echo "<option value='".$d->department_id."'>".$d->dept_name."</option>";
			}
		}
	}

	public function filter_get_section($department,$company,$division)
	{
		$section= $this->salary_approval_model->filter_get_section($department,$company,$division);
		
		if(empty($section))
		{
			echo "<option value='not_included'>No section/s found.</option>";
		}
		else
		{
			echo "<option value='not_included' disabled selected>Select</option>";
			// echo "<option value='all'>All</option>";
			foreach($section as $d)
			{
				echo "<option value='".$d->section_id."'>".$d->section_name."</option>";
			}
		}
	}
	public function filter_get_subsection($department,$company,$division,$section)
	{
		$subsection= $this->salary_approval_model->filter_get_subsection($department,$company,$division,$section);
		
		if(empty($subsection))
		{
			echo "<option value='not_included'>No subsection/s found.</option>";
		}
		else
		{
			echo "<option value='not_included' disabled selected>Select</option>";
			// echo "<option value='all'>All</option>";
			foreach($subsection as $d)
			{
				echo "<option value='".$d->subsection_id."'>".$d->subsection_name."</option>";
			}
		}
	}

	public function get_filtering_result($company,$division,$department,$section,$subsection,$classification,$location)
	{
		$this->data['company']=$company;
		$this->data['approver_details'] = $this->salary_approval_model->salary_approvers_filter_result($company,$division,$department,$section,$subsection,$classification,$location); 
		$this->load->view('app/salary_approval/manage_salary_filter',$this->data);
	}
	public function get_all_salaryapprovers($company,$classification,$location)
	{	
		$this->data['classification']=$classification;
		$this->data['location'] = $location;


		$this->data['company']=$company;
		$this->data['with_division'] = $this->form_approval_model->with_division($company);
		$this->data['division'] = $this->form_approval_model->load_division($company);

		$this->data['company_name'] = $this->salary_approval_model->get_company_name($company); 
 		$this->data['approver_details'] = $this->salary_approval_model->salary_approvers($company); 

 		$check_with_division = $this->form_approval_model->with_division($company);
		$this->data['with_division']=$check_with_division;
		if($check_with_division > 0)
		{
			$this->data['get_division'] = $this->form_approval_model->load_division($company);
		}
		else
		{
			$this->data['get_department'] = $this->form_approval_model->with_department_viewing($company,'All');
		}

		$this->load->view('app/salary_approval/manage_salary_filtered',$this->data);
	}

	function get_filter_approvers($company)
	{

		$this->data['action_']="";
		$this->data['flash_id']="";
		$this->data['company']=$company;
		$this->data['with_division'] = $this->form_approval_model->with_division($company);
		if($this->data['with_division'] > 0)
		{
			$this->data['division'] = $this->form_approval_model->load_division($company);
		}
		else
		{
			$this->data['department'] = $this->form_approval_model->with_department_viewing($company,'All');
		}
	

		$this->data['location'] = $this->form_approval_model->locationList($company);
		$this->data['classification'] = $this->form_approval_model->classificationList($company);
		$this->data['company_name'] = $this->salary_approval_model->get_company_name($company); 
 		$this->data['approver_details'] = $this->salary_approval_model->salary_approvers($company); 
		$this->load->view('app/salary_approval/manage_salary_filtering',$this->data);
	}
	
	public function delete_one_approver($company,$division,$department,$section,$subsection,$classification,$location,$id)
	{
		$delete = $this->salary_approval_model->delete_one_approver($id);
		$this->data['company']=$company;
		$this->data['flash_id']=$company;
		$this->data['action_']='deleted';
		$this->data['id']=$id;
		$this->session->set_flashdata('success_deleted',"Success");
		$this->data['approver_details'] = $this->salary_approval_model->salary_approvers_filter_result($company,$division,$department,$section,$subsection,$classification,$location); 
		$this->load->view('app/salary_approval/manage_salary_filter',$this->data);
	}
}//end controller



