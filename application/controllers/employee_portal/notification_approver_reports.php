<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 
	
class Notification_approver_reports extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("employee_portal/notification_approver_reports_model");
		$this->load->model("app/issue_notifications_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}

	public function index()
	{
		$approver = $this->session->userdata('employee_id');
		$this->data['notifications']=$this->notification_approver_reports_model->get_approver_notifications($approver);
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/reports/notification/index',$this->data);
		$this->load->view('employee_portal/footer');
	}
	public function manage_crystal_report()
	{
		$this->load->view('employee_portal/reports/notification/manage_crystal_report',$this->data);
	}
	public function get_notifications($company)
	{
		$notifications = $this->notifications_approver_reports_model->get_notifications($company);
		if(empty($notifications))
		{
			echo "<option value=''>No notification/s found.</option>";
		}
		else
		{	echo "<option value=''>Select</option>";
			foreach ($notifications as $notif) {
				echo "<option value='".$notif->id."'>".$notif->form_name."</option>";
			}
		}
		
	}
	public function manage_crystal_report_notification($type,$notif,$action)
	{
		$company = $this->session->userdata('company_id');
		$this->data['notification']=$notif;
		$this->data['company']=$company;
		if($action=='view')
		{
			$this->data['notif_details'] 	= $this->issue_notifications_model->get_form_details($notif);
			$this->data['crystal_details']	= $this->notification_approver_reports_model->get_crystal_report_notif($type,$notif);
		}
		else
		{

		}
		$this->load->view('employee_portal/reports/notification/manage_crystal_report_notification',$this->data);

	}
	public function stat_crystal_report($notif,$company,$action,$id)
	{ 
		$this->data['notification']=$notif;
		$this->data['company']=$company;
		if($action=='edit')
		{
			$this->data['id']=$id;
			$this->data['fields_default'] 	= $this->notification_approver_reports_model->get_crystal_report_default_fields($notif);
			$this->data['notif_details'] 	= $this->issue_notifications_model->get_form_details($notif);
			$this->data['details'] 	= $this->notification_approver_reports_model->get_crystal_details($id);
			$this->load->view('employee_portal/reports/notification/edit_crystal_report',$this->data);
		}
		else
		{
			$action = $this->notification_approver_reports_model->action_crystal_report($notif,$company,$action,$id);
			$this->data['notif_details'] 	= $this->issue_notifications_model->get_form_details($notif);
			$this->data['crystal_details']	= $this->notification_approver_reports_model->get_crystal_report_notif($company,$notif);
			$this->load->view('employee_portal/reports/notification/manage_crystal_report_notification',$this->data);
		}

		
	}
	public function add_crystal_report($company,$notif,$action)
	{
		$this->data['notification']=$notif;
		$this->data['company']=$company;
		$this->data['fields_default'] 	= $this->notifications_approver_reports_model->get_crystal_report_default_fields($notif);
		$this->data['notif_details'] 	= $this->issue_notifications_model->get_form_details($notif);
		$this->load->view('employee_portal/reports/notification/add_crystal_report',$this->data);
	}
	public function save_crystal_report($company,$notif,$action,$name,$desc,$data,$action_id)
	{
		$action = $this->notification_approver_reports_model->save_crystal_report($company,$notif,$action,$name,$desc,$data,$action_id);
		$this->data['notification']=$notif;
		$this->data['company']=$company;
		$this->data['notif_details'] 	= $this->issue_notifications_model->get_form_details($notif);
		$this->data['crystal_details']	= $this->notification_approver_reports_model->get_crystal_report_notif($company,$notif);
		$this->load->view('employee_portal/reports/notification/manage_crystal_report_notification',$this->data);
	}	
	public function generate_report()
	{
		$approver = $this->session->userdata('employee_id');
		$company_id = $this->session->userdata('company_id');
		$this->data['departments']=$this->notification_approver_reports_model->department_list($company_id,$approver);
		$this->data['classifications']=$this->notification_approver_reports_model->classification_list($company_id);
		$this->data['locations']=$this->notification_approver_reports_model->location_list($company_id,$approver);
		$this->data['notifications']=$this->notification_approver_reports_model->get_approver_notifications($approver);
		$this->load->view('employee_portal/reports/notification/generate_report',$this->data);
	}
	public function get_generate_crystal_reports($notif)
	{
		$approver = $this->session->userdata('employee_id');
		$company_id = $this->session->userdata('company_id');

		$crystal_report = $this->notification_approver_reports_model->get_generate_crystal_reports($notif,$approver,$company_id);
		if(count($crystal_report)>0)
		{
			echo "<option value='' disabled selected>Select crystal report</option>";
			foreach($crystal_report as $cs)
			{
				echo "<option value='".$cs->id."'>".$cs->title."</option>";
			}
		}
		else
		{
			echo "<option value=''>No crystal report found. Please add to continue.</option>";
		}
	}

	public function employee_list($search)
	{
		$company_id =  $this->session->userdata('company_id');
		$this->data['query'] = $this->notification_approver_reports_model->employeelist_model($search,$company_id);
		$this->load->view('employee_portal/reports/notification/search_employee_list',$this->data);
	}

	public function get_section($dept)
	{
		$company_id = $this->session->userdata('company_id');
		$approver = $this->session->userdata('employee_id');

		$section = $this->notification_approver_reports_model->get_section($dept,$company_id,$approver);
		if(count($section) > 0)
		{
			echo "<option value='' disabled selected>Select Section</option>";
			foreach($section as $s)
			{
				echo "<option value='".$s->section."'>".$s->section_name."</option>";
			}
		}
		else
		{
			echo "<option value=''>No section found.</option>";
		}
	}

	public function get_subsection($section)
	{
		$company_id = $this->session->userdata('company_id');
		$approver = $this->session->userdata('employee_id');

		$subsection = $this->notification_approver_reports_model->get_subsection($section,$company_id,$approver);
		if(count($subsection) > 0)
		{
			echo "<option value='' disabled selected>Select Subsection</option>";
			foreach($subsection as $s)
			{
				echo "<option value='".$s->sub_section."'>".$s->subsection_name."</option>";
			}
		}
		else
		{
			echo "<option value=''>No subsection found.</option>";
		}
	}

	public function get_filter_report_result($notification,$crystal_report,$status,$status_view,$date_to,$date_from,$employee,$employee_id,$department,$section,$subsection,$loc,$classs,$empp)
	{
		$company_id = $this->session->userdata('company_id');
		$this->data['fields'] = $this->notification_approver_reports_model->get_fields_reports($company_id,$notification,$crystal_report);
		$this->data['results'] = $this->notification_approver_reports_model->get_filter_report_result($notification,$crystal_report,$status,$status_view,$date_to,$date_from,$employee,$employee_id,$department,$section,$subsection,$loc,$classs,$empp,$company_id);
		
		$this->load->view('employee_portal/reports/notification/filter_report_result',$this->data);
	}



}	
