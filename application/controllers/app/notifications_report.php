<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 
	
class Notifications_report extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/notifications_report_model");
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
		$this->load->view('app/reports/notification/index',$this->data);
	}
	public function manage_crystal_report()
	{
		$this->load->view('app/reports/notification/manage_crystal_report',$this->data);
	}
	public function get_notifications($company)
	{
		$notifications = $this->notifications_report_model->get_notifications($company);
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
	public function manage_crystal_report_notification($company,$notif,$action)
	{
		$this->data['notification']=$notif;
		$this->data['company']=$company;
		if($action=='view')
		{
			$this->data['notif_details'] 	= $this->issue_notifications_model->get_form_details($notif);
			$this->data['crystal_details']	= $this->notifications_report_model->get_crystal_report_notif($company,$notif);
		}
		else
		{

		}
		$this->load->view('app/reports/notification/manage_crystal_report_notification',$this->data);
	}
	public function stat_crystal_report($notif,$company,$action,$id)
	{
		$this->data['notification']=$notif;
		$this->data['company']=$company;
		if($action=='edit')
		{
			$this->data['id']=$id;
			$this->data['fields_default'] 	= $this->notifications_report_model->get_crystal_report_default_fields($notif);
			$this->data['notif_details'] 	= $this->issue_notifications_model->get_form_details($notif);
			$this->data['details'] 	= $this->notifications_report_model->get_crystal_details($id);
			$this->load->view('app/reports/notification/edit_crystal_report',$this->data);
		}
		else
		{
			
			$action = $this->notifications_report_model->action_crystal_report($notif,$company,$action,$id);
			$this->data['notif_details'] 	= $this->issue_notifications_model->get_form_details($notif);
			$this->data['crystal_details']	= $this->notifications_report_model->get_crystal_report_notif($company,$notif);
			$this->load->view('app/reports/notification/manage_crystal_report_notification',$this->data);
		}

		
	}
	public function add_crystal_report($company,$notif,$action)
	{
		$this->data['notification']=$notif;
		$this->data['company']=$company;
		$this->data['fields_default'] 	= $this->notifications_report_model->get_crystal_report_default_fields($notif);
		$this->data['notif_details'] 	= $this->issue_notifications_model->get_form_details($notif);
		$this->load->view('app/reports/notification/add_crystal_report',$this->data);
	}
	public function save_crystal_report($company,$notif,$action,$name,$desc,$data,$action_id)
	{
		$action = $this->notifications_report_model->save_crystal_report($company,$notif,$action,$name,$desc,$data,$action_id);
		$this->data['notification']=$notif;
		$this->data['company']=$company;
		$this->data['notif_details'] 	= $this->issue_notifications_model->get_form_details($notif);
		$this->data['crystal_details']	= $this->notifications_report_model->get_crystal_report_notif($company,$notif);
		$this->load->view('app/reports/notification/manage_crystal_report_notification',$this->data);
	}	
	public function generate_report()
	{
		$this->load->view('app/reports/notification/generate_report',$this->data);
	}
	public function get_crystal_reports($company,$notif)
	{
		$crystal_details = $this->notifications_report_model->get_crystal_report_notif($company,$notif);
		if(empty($crystal_details))
		{
			echo "<option value=''>No crystal report/s found.Please add to continue.</option>";
		}
		else
		{	echo "<option value=''>Select</option>";
			foreach ($crystal_details as $c) {
				echo "<option value='".$c->id."'>".$c->title."</option>";
			}
		}
	}

	public function employee_list($company,$val)
	{
		$this->data['query']=$this->notifications_report_model->search_employee_list($company,$val);
		$this->load->view('app/reports/notification/search_employee_list',$this->data);
	}
	public function get_all($company,$option)
	{
		$this->data['option']=$option;
		$this->data['details']=$this->notifications_report_model->get_datas($company,$option);
		$this->load->view('app/reports/notification/for_all_employee',$this->data);
	}
	public function get_section($company,$dept)
	{
		
		$section=$this->notifications_report_model->get_section($company,$dept);
		if(empty($section))
		{
			echo "<option value=''>No section/s found.Please add to continue.</option>";
		}	
		else
		{
			echo "<option value=''>Select</option>";
			foreach($section as $s)
			{
				echo "<option value='".$s->section_id."'>".$s->section_name."</option>";
			}
		}
	}

	public function get_subsection($company,$section)
	{
		$check_withsub = $this->notifications_report_model->check_with_subsection($section);
		if(!empty($check_withsub))
		{
			$subsection=$this->notifications_report_model->get_subsection($company,$section);
			if(empty($subsection))
			{
				echo "<option value=''>No subsection/s found.Please add to continue.</option>";
			}
			else
			{
				foreach($subsection as $sb)
				{
					echo "<option value='".$sb->subsection_id."'>".$sb->subsection_name."</option>";
				}
			}
		}
		else
		{
				echo "<option value='not_included'>No subsection needed. You can proceed now.</option>";
		}
		
	}
	public function get_crystal_reports_generate($notif,$company)
	{
		$get_crystal_reports = $this->notifications_report_model->get_crystal_report_notif($company,$notif);
		if(empty($get_crystal_reports)){ echo "<option value=''>No Crystal Report/s found</option>"; }
		else
		{
			echo "<option value=''>Select</option>";
			foreach($get_crystal_reports as $gc)
			{
				echo "<option value='".$gc->id."'>".$gc->title."</option>";
			}
		}
	}

	public function get_filtered_report_results($company,$notification,$crystal_report,$status,$status_view,$from,$to,$employee,$department,$section,$subsection,$employee_id,$loc,$emp,$classs)
	{
		
		$this->data['results']=$this->notifications_report_model->get_filtered_report_results($company,$notification,$crystal_report,$status,$status_view,$from,$to,$employee,$department,$section,$subsection,$employee_id,$loc,$emp,$classs);
		$this->data['fields'] = $this->notifications_report_model->get_fields_reports($company,$notification);
		$this->load->view('app/reports/notification/get_filtered_report_results',$this->data);
	}
}	
