<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 
	
class Reports_time_geoweb extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/report_time_geoweb_model");
		$this->load->model("general_model");
		$this->load->dbforge();
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}

		
	public function generate_report_geoweb()
	{
		$this->data['crystal_report'] = $this->report_time_geoweb_model->get_geoweb_crystal_report();
		$this->load->view('app/reports/time/geoweb/generate_geoweb',$this->data);
	}

	public function quick_generate_geoweb()
	{	
		$company = $this->input->post('company');
		$from = $this->input->post('date_from');
		$to = $this->input->post('date_to');
		$option = $this->input->post('option');
		$result_type = $this->input->post('report_result_type');

		$crystal_report = $this->input->post('report');
		$this->data['report'] = $crystal_report;
		$this->data['report_result_type'] = $result_type;
		$this->data['option'] = $option;
		$this->data['report_area']="geoweb_attendance_report".date('Y-m-d');
		if($crystal_report == 'default'){}
		else
		{
			$this->data['report_fields'] =$report_fields= $this->report_time_geoweb_model->crystal_report_fields($crystal_report);
		}
		$this->data['results'] =$report_fields= $this->report_time_geoweb_model->generate_geo_results($company,$from,$to,$option);
		$this->load->view('app/reports/time/geoweb/geoweb_report',$this->data);
	}

	public function view_map($covered_date ,$lat,$employee_id,$map,$mb)
	{
		$this->data['mapid'] = $map;
		$this->data['mb'] = $mb;
		$get_lat_long =$this->report_time_geoweb_model->get_geo_details($employee_id,$covered_date);
		$this->data['locations'] = $get_lat_long;
		$i=1;
		$data ="";
		foreach($get_lat_long as $c)
		{
			if($i==1)
			{
				$this->data['lat'] = $c->latitude;
				$this->data['long'] = $c->longitude;
			}
			if(count($get_lat_long)==$i)
			{
				$value = '['.$c->latitude.','.$c->longitude.']';
			}
			else 
			{
				$value = '['.$c->latitude.','.$c->longitude.'],';
			}
			$data.=$value;
			$i++;
		 }

		$this->data['data'] = $data;
		$this->load->view('app/reports/time/geoweb/geoweb_multiple_marker',$this->data);	
	}
}	
