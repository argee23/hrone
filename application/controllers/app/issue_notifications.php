<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Issue_notifications extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/issue_notifications_model");
		$this->load->model("app/transaction_employees_model");
		$this->load->model("employee_portal/notification_approver_model");
		$this->load->model("general_model");
		$this->load->dbforge();

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$this->load->library('form_validation');
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}
	
	public function index(){	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message'); 
		$this->data["notifications"] = $this->issue_notifications_model->get_notifications();
		$this->load->view('app/issue_notifications/index',$this->data);
	}

	public function get_notification_list($company)
	{
		$notification = $this->issue_notifications_model->get_notification_list($company);
		if(empty($notification))
		{
			echo "<option value=''>No Notification/s found.Please add to continue.</option>";
		}
		else{
			
			echo "<option value=''>Select</option>";
			foreach($notification as $notif)
			{
				echo "<option value='".$notif->id."'>".$notif->form_name."</option>";
			}
		}
		
	}

	public function get_employee_list($company,$val)
	{
		$this->data['query'] = $this->issue_notifications_model->employeelist_model($val,$company);
		$this->load->view('app/issue_notifications/search_employee_list',$this->data);
	}

	public function show_form($company_id,$forms,$employee_id)
	{
		$this->data['company_id']=$company_id;
		$this->data['notif_id']=$forms;
		$form_details=$this->issue_notifications_model->get_form_details($forms);
		$this->data['form_details']=$form_details;
		$this->data['employee_details']=$this->issue_notifications_model->get_employee_details($employee_id);
		$this->data['code_of_discipline']=$this->issue_notifications_model->get_code_of_discipline($company_id);
		$this->data['field_list']=$this->issue_notifications_model->get_notif_fields($forms);
		if($form_details->issuance_type==1)
		{
			$this->data['wApprover']=1;
			$this->data['approvers']=$this->issue_notifications_model->get_notif_approvers($forms,$this->data['employee_details']);
		}
		else
		{
			$this->data['wApprover']=0;
		}
		$this->load->view('app/issue_notifications/show_notification_form',$this->data);
	}

	public function get_disciplinary_data($option,$val,$company_id)
	{
		
		$details = $this->issue_notifications_model->get_disciplinary_data($option,$val,$company_id);
		
		if(empty($details))
		{
			echo "<option value=''>No data found.</option>";
		}
		else
		{
			echo "<option value=''>Select</option>";
			foreach($details as $row)
			{
				if($option=='disobedience')
				{
					echo "<option value='".$row->cod_disob_id."'>".$row->disob_title."</option>";
				}
				else
				{
					echo "<option value='".$row->pun_id."'>".$row->disob."</option>";
				}
				
			}
		}
	}

	public function save_issue_notification()
	{
		$insert = $this->issue_notifications_model->save_issue_notification();
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Issue Notification to <strong>".$this->input->post('employee_id')."</strong> is Successfully Added! <strong></strong>!</div>");
		redirect(base_url().'app/issue_notifications/index',$this->data);
	}

	public function view_notif_form($doc_no,$company_id,$employee_id)
	{	

		$array =  explode('_', $doc_no);
		$this->data['identification']=$array[0];
		$this->data['company_id']=$company_id;
		$this->data['employee_id']=$employee_id;
		$this->data['form_details']=$this->issue_notifications_model->get_notification_details($array[0]);
		$this->data['file']=$this->issue_notifications_model->get_employee_details($employee_id);
		$this->data['doc_details']=$this->issue_notifications_model->get_doc_details($doc_no,$this->data['form_details']->t_table_name);
		$this->data['field_list']=$this->issue_notifications_model->get_notif_fields($this->data['form_details']->id);
		$this->data['assign']=$this->issue_notifications_model->get_assign_to_fillup($doc_no,$this->data['form_details']->t_table_name."_assign");
		if($employee_id==$this->session->userdata('employee_id'))
		{
			$this->issue_notifications_model->update_notif_time_viewed($employee_id,$doc_no,$this->data['form_details']->t_table_name);	
		}
		$this->load->view('app/issue_notifications/view_notification_form',$this->data);
	}

	public function filter_notifications()
	{
		$this->load->view('app/issue_notifications/filter_notifications',$this->data);
	}

	//filtering
	public function get_notifications_filter($company)
	{
		$notification = $this->issue_notifications_model->get_notif_filtering($company);
		if(empty($notification))
		{
			echo "<option value=''>No Notification/s found.Please add to continue.</option>";
		}
		else{
			
			echo "<option value=''>Select</option>";
			foreach($notification as $notif)
			{
				echo "<option value='".$notif->id."'>".$notif->form_name."</option>";
			}
		}
	}

	public function show_filter($company,$notif,$status,$from,$to)
	{
		$form_details = $this->issue_notifications_model->get_form_details($notif);
		$this->data['form_details']=$form_details;
		$this->data["details"] = $this->issue_notifications_model->get_notif_details_filter($company,$status,$from,$to,$notif,$form_details->t_table_name);
		$this->load->view('app/issue_notifications/show_filter_result',$this->data);
	}
	
}//controller

