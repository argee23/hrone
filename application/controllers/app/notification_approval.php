<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Notification_approval extends General{

	private $limit = 10;

	public function __construct(){
		parent::__construct();
		$this->load->model("app/form_approval_model");
		$this->load->model("app/notification_approval_model");
		$this->load->model("general_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();	
		
	}
	
	public function index(){	
		$this->start_here();
	}
	public function start_here(){	
		
		$this->load->view('app/notification_approval/index',$this->data);
	}	

	public function add_no_approver()
	{
		$this->data['action_']='';
		$this->data['flash_id']='';
		$this->data['setting_no_approver'] = $this->notification_approval_model->setting_no_approver();
		$this->load->view('app/notification_approval/add_no_approver',$this->data);
	}

	public function save_add_no_approver($setting_company,$setting_approver)
	{
		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Disc Act Memos Approval','logfile_admin_notif_approval','Add Maximum Disc Act Memos Approvers'.$setting_company.'|'.$setting_approver,'INSERT',$setting_approver);

		$insert = $this->notification_approval_model->save_add_no_approver($setting_company,$setting_approver);
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
		$this->data['setting_no_approver'] = $this->notification_approval_model->setting_no_approver();
		$this->load->view('app/notification_approval/add_no_approver',$this->data);
	}

	public function delete_setting_no_approver($id)
	{
		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Disc Act Memos Approval','logfile_admin_notif_approval','Delete Maximum Disc Act Memos Approvers'.$id,'DELETE',$id);

		$delete = $this->notification_approval_model->delete_setting_no_approver($id);
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
		$this->data['setting_no_approver'] = $this->notification_approval_model->setting_no_approver();
		$this->load->view('app/notification_approval/add_no_approver',$this->data);
	}
	public function edit_setting_no_approver($id,$company)
	{
		$this->data['company_id']= $company;
		 $this->data['no_approver'] = $this->notification_approval_model->no_approver($id);
		$this->load->view('app/notification_approval/edit_setting_no_approver_form',$this->data);
	}
	public function saveupdate_no_approver_setting($company_id,$setting_approver)
	{
		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Disc Act Memos Approval','logfile_admin_notif_approval','Update Maximum Disc Act Memos Approvers'.$company_id.'|'.$setting_approver,'UPDATE',$setting_approver);

		$update = $this->notification_approval_model->saveupdate_no_approver_setting($company_id,$setting_approver);
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
		$this->data['setting_no_approver'] = $this->notification_approval_model->setting_no_approver();
		$this->load->view('app/notification_approval/add_no_approver',$this->data);
	}

	public function add_approver_choices()
	{
		$this->data['flash_id']='';
		$this->data['action_']='';
		$this->data['approver_list'] = $this->notification_approval_model->approver_list();
		$this->load->view('app/notification_approval/approver_choices',$this->data);
	}
	public function showSearchEmployeelist($val = NULL){
		$this->data['showEmployeeList'] = $this->notification_approval_model->getSearch_EmployeeList($val); //getEmp //getSearch_Employee
		$this->load->view("app/notification_approval/showEmployeeList",$this->data);	
	}
	public function add_new_approver_choices($employee_id)
	{
		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Disc Act Memos Approval','logfile_admin_notif_approval','Add Disc Act Memos Approver Choices'.$employee_id,'INSERT',$employee_id);

		$insert = $this->notification_approval_model->add_new_approver_choices($employee_id);
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
		$this->data['approver_list'] = $this->notification_approval_model->approver_list();
		$this->load->view('app/notification_approval/approver_choices',$this->data);
	}

	public function delete_approver($id)
	{

		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Disc Act Memos Approval','logfile_admin_notif_approval','Delete Disc Act Memos Approver Choices'.$id,'DELETE',$id);

		$delete = $this->notification_approval_model->delete_approver($id);
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
		 $this->data['approver_list'] = $this->notification_approval_model->approver_list();
		$this->load->view('app/notification_approval/approver_choices',$this->data);
	}

	public function automatic_update_status()
	{
		$this->data['action_']='';
		$this->data['flash_id']='';
		$this->data['company_id']='';
		$this->data['details'] = $this->notification_approval_model->automatic_update_status(); 
 		$this->load->view('app/notification_approval/automatic_update_status',$this->data);
	}
	public function save_automatic_update_status($company,$action,$days)
	{

		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Disc Act Memos Approval','logfile_admin_notif_approval','Add Auto Approve/Cancel/reject Disc Act Memos(company|action|days'.$company.'|'.$action.'|'.$days,'INSERT',$company);

		$this->data['action_']='add';
		$this->data['flash_id']=$company;
		$this->data['company_id']=$company;
		$insert = $this->notification_approval_model->save_automatic_update_status($company,$action,$days);
		$this->data['details'] = $this->notification_approval_model->automatic_update_status(); 
		$this->session->set_flashdata($insert,"Success");
 		$this->load->view('app/notification_approval/automatic_update_status',$this->data);
	}
	public function settings_automatic_update_status($action,$company)
	{
		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Disc Act Memos Approval','logfile_admin_notif_approval',$action.' Auto Approve/Cancel/reject Disc Act Memo(company|action|days'.$company,$action,$company);

		$this->data['action_']=$action;
		$this->data['flash_id']=$company;
		$this->data['company_id']=$company;
		$actionn  = $this->notification_approval_model->settings_automatic_update_status($action,$company);
		$this->data['details'] = $this->notification_approval_model->automatic_update_status(); 
		$this->session->set_flashdata($actionn,$actionn);
 		$this->load->view('app/notification_approval/automatic_update_status',$this->data);
	}

	public function settings_update_automatic_update_status($company)
	{
		$this->data['details_one'] = $this->notification_approval_model->get_automatic_details_one($company); 
		$this->load->view('app/notification_approval/automatic_update_status_update',$this->data);
	}
	public function saveupdate_automatic_update_status($company,$action,$days)
	{
		/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Disc Act Memos Approval','logfile_admin_notif_approval','Update Auto Approve/Cancel/reject Disc Act Memos(company|action|days'.$company.'|'.$action.'|'.$days,'UPDATE',$company);	

		$this->data['action_']='update';
		$this->data['flash_id']=$company;
		$this->data['company_id']=$company;
		$update = $this->notification_approval_model->saveupdate_automatic_update_status($company,$action,$days);
		$this->data['details'] = $this->notification_approval_model->automatic_update_status(); 
		$this->session->set_flashdata($update,"Success");
 		$this->load->view('app/notification_approval/automatic_update_status',$this->data);
	}

	public function manage_notification_approvers($company)
	{
		$check_with_division = $this->form_approval_model->with_division($company);
		$this->data['with_division']=$check_with_division;
		$this->data['classification']='All';
		$this->data['location']= 'All';
		$this->data['notification']='All';
		$this->data['action_']="";
		if($check_with_division > 0)
		{
			$this->data['get_division'] = $this->form_approval_model->load_division($company);
		}
		else
		{
			$this->data['get_department'] = $this->form_approval_model->with_department_viewing($company,'All');
		}

		$this->data['classificationList'] = $this->form_approval_model->classificationList($company);
		$this->data['locationList'] = $this->form_approval_model->locationList($company);
		$this->data['notificationList'] = $this->form_approval_model->loadNotification($company);
		$this->data['company']=$company;
		$this->data['company_name'] = $this->notification_approval_model->get_company_name($company);
		$this->load->view('app/notification_approval/manage_notification',$this->data);
	}

	public function add_approver($company)
	{
		$this->data['with_division']=$this->form_approval_model->with_division($company);
		$this->data['division']=$this->form_approval_model->load_division($company);
		$this->data['classificationList'] = $this->form_approval_model->classificationList($company);
		$this->data['locationList'] = $this->form_approval_model->locationList($company);
		$this->data['notification'] = $this->form_approval_model->loadNotification($company);
		$this->data['no_approver'] = $this->notification_approval_model->load_number_approver($company);
		$this->data['company']=$company;
		$this->load->view('app/notification_approval/manage_notification_add',$this->data);
	}
	public function addnew_showSearchResult($val = NULL,$company = NULL )
	{
		$this->data['addnew_showSearchResult'] = $this->notification_approval_model->addnew_showSearchResult($val,$company); 
		$this->load->view("app/notification_approval/approver_showEmployeeList",$this->data);
	}

	public function get_companynotification_viewing($company,$notif,$classification,$location)
	{
		$this->data['classification']=$classification;
		$this->data['location']= $location;
		$this->data['notification']=$notif;
		$this->data['company']=$company;

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
		$this->load->view('app/notification_approval/companynotification_filter',$this->data);
	}

	public function approver_filtering($company)
	{
		$this->data['company']=$company;
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
		$this->data['classificationList'] = $this->form_approval_model->classificationList($company);
		$this->data['locationList'] = $this->form_approval_model->locationList($company);
		$this->data['notificationList'] = $this->form_approval_model->loadNotification($company);
		$this->data['details'] = $this->notification_approval_model->get_approver_filtering('all',$company);
		$this->load->view('app/notification_approval/approver_filtering',$this->data);
	}

	public function get_filtering_result($notif,$company)
	{
		$this->data['company']=$company;
		$this->data['notification']=$notif;
		$this->data['flash_id']=$company;
		$this->data['action_']='';
		$this->data['details'] = $this->notification_approval_model->get_approver_filtering($notif,$company);
		$this->load->view('app/notification_approval/approver_by_notification',$this->data);
	}
	public function delete_notif_oneapprover($company,$id,$notif,$division,$department,$section,$subsection,$location,$classification)
	{
		$this->data['flash_id']=$company;
		$this->data['action_']='deleted';
		$this->session->set_flashdata('success_deleted',"deleted");
		$this->data['company']=$company;
		$this->data['notification']=$notif;
		$delete = $this->notification_approval_model->delete_notification_approver($id);
		$this->data['details'] = $this->notification_approval_model->get_approver_filtering_result($notif,$company,$division,$department,$section,$subsection,$location,$classification);
		$this->load->view('app/notification_approval/approver_by_notification',$this->data);
	}

	public function delete_all_approvers_by_company($company)
	{

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

			General::system_audit_trail('Administrator','Disc Act Memos Approval','logfile_admin_notif_approval','Delete Disc Act Memos Approvers of company : '.$company,'DELETE',$company);

		$action = $this->notification_approval_model->delete_all_approvers_by_company($company);
		$check_with_division = $this->form_approval_model->with_division($company);
		$this->data['with_division']=$check_with_division;
		$this->data['classification']='All';
		$this->data['location']= 'All';
		$this->data['notification']='All';
		if($check_with_division > 0)
		{
			$this->data['get_division'] = $this->form_approval_model->load_division($company);
		}
		else
		{
			$this->data['get_department'] = $this->form_approval_model->with_department_viewing($company,'All');
		}
		$this->data['flash_id']=$company;
		$this->data['action_']='deleted';
		$this->session->set_flashdata('success_deleted',"deleted");
		$this->data['classificationList'] = $this->form_approval_model->classificationList($company);
		$this->data['locationList'] = $this->form_approval_model->locationList($company);
		$this->data['notificationList'] = $this->form_approval_model->loadNotification($company);
		$this->data['company']=$company;
		$this->data['company_name'] = $this->notification_approval_model->get_company_name($company);
		$this->load->view('app/notification_approval/manage_notification',$this->data);
	}

	public function get_department($id,$company)
	{
		$departmentList = $this->form_approval_model->load_dept($id,$company);
			
			if(empty($departmentList)) { echo " <option value='not_included'>No department added in this company.Please add department to continue filtering. </option>"; } else{ 
			echo ' <option value="not_included"  selected="selected" disabled="">-Select Department-</option>'; 	
			foreach($departmentList as $dpt){
	        echo "<option value='".$dpt->department_id."' >".$dpt->dept_name."</option>";
	        }
	    }
	}

	public function get_section($id,$div,$dept)
	{
		$sectionList = $this->form_approval_model->load_section($id,$div,$dept);
		if(empty($sectionList)) { echo " <option value='not_included'>No section added in this company.Please add section to continue filtering. </option>"; } 
		else
		{
			echo '<option value="not_included"  selected="selected" disabled="">-Select Section-</option>';
	        foreach($sectionList as $sec){
	        echo "<option value='".$sec->section_id."' >".$sec->section_name."</option>";
	        }	
		}	

		
	}

	public function get_subsection($val)
	{
		$with_subsection = $this->form_approval_model->with_subsection($val);	
		$subsectionList = $this->form_approval_model->load_subsections($val);

  
       	if($with_subsection==1){ 
       		if(empty($subsectionList)) { echo " <option value='not_included'>No subsection added in this company.Please add subsection to continue filtering. </option>"; } 
       		else{ 
      		echo '<option value="not_included">-Select Subsection-</option>';  
      		foreach($subsectionList as $sub){
       				 echo "<option value='".$sub->subsection_id."' >".$sub->subsection_name."</option>";
        				}
    		}  } 

    	else{ echo "<option value='not_included'>Subsection is not required</option>";}
      
	}

	public function get_filtering_result_company($notif,$company,$division,$department,$section,$subsection,$location,$classification)
	{
		$this->data['flash_id']=$company;
		$this->data['action_']='';
		$this->session->set_flashdata('success',"success");
		$this->data['company']=$company;
		$this->data['details'] = $this->notification_approval_model->get_approver_filtering_result($notif,$company,$division,$department,$section,$subsection,$location,$classification);
		$this->load->view('app/notification_approval/approver_by_notification',$this->data);

	}

}//end controller



