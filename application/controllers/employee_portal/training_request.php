<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Training_request extends General {

	function __construct() {
		parent::__construct();	
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$this->load->model("employee_portal/training_request_model");
		$this->load->model("general_model");
		General::variable();	
	}

	public function index()
	{
		$this->data['message'] = $this->session->flashdata('onload');
		$this->data['onload'] = $this->session->flashdata('message');
		$this->data['details'] = $this->training_request_model->training_request_list();
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/training_request/index',$this->data);
		$this->load->view('employee_portal/footer');
	}	

	public function respond_training_request($id)
	{
		$this->data['details'] =  $this->training_request_model->get_training_request($id);
		$this->load->view('employee_portal/training_request/respond_request_training',$this->data);
	}

	public function respond_employee_training_request()
	{	
		$title = $this->input->post('training_title');
		$respond = $this->input->post('finalans');

		$respond = $this->training_request_model->respond_employee_training_request();
		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>You have successfully respond to the ".$title." training request.</div>");

		redirect('employee_portal/training_request/index/',$this->data);
	}

	public function get_joined_unjoined_incoming($val)
	{
		$this->data['val']=$val;
		$this->data['details'] = $this->training_request_model->training_request_list_incoming($val);
		$this->load->view('employee_portal/training_request/incoming_trainings_seminars',$this->data);
	}

	public function update_reponse($val,$id)
	{
		$update = $this->training_request_model->update_reponse($val,$id);
		$this->session->set_flashdata('onload',"get_joined_unjoined_incoming('".$id."')");

		$this->session->set_flashdata('message',"<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>You have successfully updated the training and seminar request id ".$id.".</div>");
		redirect('employee_portal/training_request/index/',$this->data);
	}

	public function incoming_history()
	{
		$this->load->view('employee_portal/training_request/incoming_history');
	}

	public function filter_history_result($response_status,$training_status,$date_from,$date_to,$option,$training_type)
	{
		$this->data['details'] = $this->training_request_model->filter_history_result($response_status,$training_status,$date_from,$date_to,$option,$training_type);
		$this->load->view('employee_portal/training_request/filter_history_result',$this->data);
	}

	public function view_trainingsseminars($id)
	{
		$this->data['details'] = $this->training_request_model->get_training_details($id);
		$this->data['dates'] = $this->training_request_model->get_training_dates($id);
		$this->load->view('employee_portal/training_request/view_trainingsseminars',$this->data);
	}
}