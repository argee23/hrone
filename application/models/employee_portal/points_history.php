<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Points_history extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/points_history_model");
		General::variable();
	}


	public function index()
	{

		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/points_history/index', $this->data);
		$this->load->view('employee_portal/footer');
	}

	public function get_points_history($code)
	{
		$this->data['details'] = $this->points_history_model->get_setting_details($code);
		$this->data['get_details'] = $this->points_history_model->get_reward_points_details($code);
 		$this->load->view('employee_portal/points_history/points_history', $this->data);
	}
}	