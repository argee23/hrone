<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Employee_notifications extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("app/transaction_employees_model");
		$this->load->model("employee_portal/notification_approver_model");
		$this->load->model("employee_portal/employee_notifications_model");
		$this->load->model("app/issue_notifications_model");
		General::variable();
	}

	public function index()
	{
		
		$this->data["notifications"] = $this->employee_notifications_model->get_notif_details($this->session->userdata('company_id'));
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/employee_notifications/index', $this->data);
		$this->load->view('employee_portal/footer');
		
	}
	// public function get_notifications($id)
	// {
	// 	if($id=='all')
	// 	{
	// 		$this->data["notifications"] = $this->employee_notifications_model->get_notif_details($this->session->userdata('company_id'));
	// 		$this->load->view('employee_portal/employee_notifications/all_notifications', $this->data);
	// 	}	
	// 	else
	// 	{
	// 		$this->data['notif_details']=$this->issue_notifications_model->get_form_details($id);
	// 		$this->data['details'] = $this->employee_notifications_model->get_all_notif_by_employee($this->data['notif_details']->t_table_name,$this->session->userdata('employee_id'));
	// 		$this->load->view('employee_portal/employee_notifications/notifications', $this->data);
	// 	}
		
	// }
	public function aswer_to_notification($doc_no,$company_id,$employee_id,$table)
	{
		$array =  explode('_', $doc_no);
		$this->data['identification']=$array[0];
		$this->data['doc_no']=$doc_no;
		$this->data['employee_id']=$employee_id;
		$this->data['file']=$this->issue_notifications_model->get_employee_details($employee_id);
		$this->data['form_details']=$this->issue_notifications_model->get_notification_details($array[0]);
		$this->data['field_list']=$this->issue_notifications_model->get_notif_fields($this->data['form_details']->id);
		$this->data['doc_details']=$this->issue_notifications_model->get_doc_details($doc_no,$this->data['form_details']->t_table_name);
		$this->data['assign']=$this->issue_notifications_model->get_assign_to_fillup($doc_no,$this->data['form_details']->t_table_name."_assign");
		$this->data['approval_level']=$this->notification_approver_model->get_assign_to_fillup($doc_no,$this->session->userdata('employee_id'),$this->data['form_details']->t_table_name."_approval");
		$this->load->view('employee_portal/employee_notifications/aswer_to_notification_modal',$this->data);
	}
	
	public function answer_notification()
	{
		$doc_no			 	= 	$this->input->post('doc_no');
		$table 				= 	$this->input->post('table');
		$employee_id 		= 	$this->input->post('filer_id');
		$identification		=	$this->input->post('identification');
		$form_details=$this->issue_notifications_model->get_notification_details($identification);
		$field_list=$this->issue_notifications_model->get_notif_fields($form_details->id);
		$assign=$this->issue_notifications_model->get_assign_to_fillup($doc_no,$form_details->t_table_name."_assign");
		
		$insert = $this->employee_notifications_model->answer_notification($doc_no,$table,$employee_id,$identification,$form_details,$field_list,$assign);
		redirect(base_url().'employee_portal/employee_notifications/index',$this->data);
	}
	public function filter_notifications($table,$id,$identification,$status,$from,$to)
	{
		$this->data['notif_details']=$this->issue_notifications_model->get_form_details($id);
		$this->data['details'] = $this->employee_notifications_model->filter_notifications_filtering_notif($table,$this->session->userdata('employee_id'),$status,$from,$to);
		$this->load->view('employee_portal/employee_notifications/filter_notifications', $this->data);
	}
	public function filter_notifications_all($notif,$status,$from,$to)
	{
		$this->data['status']=$status;
		$this->data['from']=$from;
		$this->data['to']=$to;
		$this->data['notif']=$notif;
		if($notif=='All')
		{
			$this->data["notifications"] = $this->employee_notifications_model->get_notif_details_filter($this->session->userdata('company_id'),$status,$from,$to,'all');
		}
		else
		{
			$this->data["notifications"] = $this->employee_notifications_model->get_notif_details_filter($this->session->userdata('company_id'),$status,$from,$to,$notif);
		}
		
		$this->load->view('employee_portal/employee_notifications/filter_notifications_by_all', $this->data);
	}

	public function search_notif($val)
	{
		$notifications = $this->employee_notifications_model->search_notif($val,$this->session->userdata('company_id'));
		?>
		  <ul class="nav nav-pills nav-stacked" >
                <?php if(empty($notifications)){?>
                 <li class="my_hover">
                    <a data-toggle="tab" href="#filter_all_forms" >No Notification/s found.</a>
                </li>
                <?php } else { ?>                 

                <li class="my_hover">
                    <a data-toggle="tab" style="cursor: pointer;" onclick="get_notifications('all');">All Notifications</a>
                </li>
                <?php foreach($notifications as $notif){?>
                <li class="my_hover">
                    <a data-toggle="tab" style="cursor: pointer;" onclick="get_notifications('<?php echo $notif->id;?>');"><?php echo $notif->form_name; if($notif->count==0){} else{?><span class="badge badge-warning"><?php echo $notif->count;?></span><?php }?></a>
                </li>
                <?php } } ?>
                <style type="text/css">
                  .badge-warning {
                    background-color: #f89406;
                  }
                  .badge-warning:hover {
                    background-color: #c67605;
                  }
                </style>
          </ul>
       <?php
	}

	public function view_by_notifications($id)
	{
		$this->load->view('employee_portal/header');

		$this->data["notifications"] = $this->employee_notifications_model->get_notif_details($this->session->userdata('company_id'));
		if($id=='all')
		{
			$this->data["notifications"] = $this->employee_notifications_model->get_notif_details($this->session->userdata('company_id'));
			$this->load->view('employee_portal/employee_notifications/all_notifications', $this->data);
		}	
		else
		{
			$this->data['notif_details']=$this->issue_notifications_model->get_form_details($id);
			$this->data['details'] = $this->employee_notifications_model->get_all_notif_by_employee($this->data['notif_details']->t_table_name,$this->session->userdata('employee_id'));
			$this->load->view('employee_portal/employee_notifications/notifications_answer', $this->data);
		}
		
		$this->load->view('employee_portal/footer');
	}
}