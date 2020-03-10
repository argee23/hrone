<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Reports extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/reports_model");
		$this->load->model("employee_portal/overtime_management_model");
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
	}

	public function index()
	{
		// $this->data['faqs'] = $this->employee_faq_model->getFAQs();
		// $this->load->view('employee_portal/header');	
		// $this->load->view('employee_portal/faq', $this->data);
		// $this->load->view('employee_portal/footer');		
	}	

	public function download_atro_summary($classification, $division="", $department, $section, $subsection="", $location, $date_from, $date_to)
	{
		error_log("hahaa");
		  $object = new PHPExcel();

		  $object->setActiveSheetIndex(0);

		  $table_columns = array("Name", "Address", "Gender", "Designation", "Age");

		  $column = 0;

		  foreach($table_columns as $field)
		  {
		   $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
		   $column++;
		  }

		  // $employee_data = $this->excel_export_model->fetch_data();

		  $excel_row = 2;

		  // foreach($employee_data as $row)
		  // {
		  //  $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->name);
		  //  $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->address);
		  //  $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->gender);
		  //  $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->designation);
		  //  $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->age);
		  //  $excel_row++;
		  // }

		  for ($excel_row = 1; $excel_row < 10; $excel_row++)
		  {
		  	   $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, '$row->name');
		   $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, '$row->address');
		   $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, '$row->gender');
		   $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, '$row->designation');
		   $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, '$row->age');
		  }

		 
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header("Content-Disposition: attachment; filename=\"results.xls\"");
		header("Cache-Control: max-age=0");
		   $object_writer = IOFactory::createWriter($object, 'Excel5');
		  $object_writer->save('php://output');
		  ob_clean();

		  // 		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				// header('Content-Disposition: attachment;filename="' . $fileName. '"');
				// header('Cache-Control: max-age=0');
				// unlink($inputFileName);
				// $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
				// $objWriter->save('php://output');
	}

	public function test()
	{
		// echo var_dump($this->reports_model->get_filed_atro('2017-08-11', '2017-08-29', '5097'));
		// //echo var_dump($this->reports_model->get_employees('all',10, 82, 32, 11, 1));
		 // echo var_dump($this->reports_model->get_atro_summary('all',10, 82, 32, 11, 1, '2017-09-01', '2017-09-30'));
		 //echo var_dump ($this->reports_model->convert_to_array($this->overtime_management_model->get_departments(10), 'department'));

		//$this->get_atro_summary('all',10, 82, 32, 11, 1, '2017-09-01', '2017-09-30');
		//$this->get_locations(0, 48, 2, 0);
		$this->get_sections(48);
	}

	public function get_atro_summary($classification, $division="", $department, $section, $subsection="", $location, $date_from, $date_to)
	{
		error_log("what went wrong?");
		error_log("div" . $division);
		error_log("class" . $classification);
		error_log("dpt" . $department);
		error_log("sec" . $section);
		error_log("sub" . $subsection);
		error_log("loc" . $location);
		error_log("date_from" . $date_from);
		error_log("date_to" . $date_to);
		$data = $this->reports_model->get_atro_summary($classification, $division, $department, $section, $subsection, $location, $date_from, $date_to);

		echo json_encode($data);
	}
	public function personnel_atro()
	{
		$this->data['has_division'] = $this->overtime_management_model->has_division($this->session->userdata('company_id'));
		$this->data['divisions'] = $this->overtime_management_model->get_divisions($this->session->userdata('company_id'), $this->session->userdata('employee_id'));
		$this->data['classifications'] = $this->reports_model->get_classifications();
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/reports/personnel_atro', $this->data);
		$this->load->view('employee_portal/footer');		
	}

		public function get_divisions()
	{
		$data = $this->overtime_management_model->get_divisions();
		echo json_encode($data);
	}

	public function get_departments($division_id="")
	{
		$data = $this->overtime_management_model->get_departments($division_id);
		echo json_encode($data);
	}

	public function get_sections($department_id)
	{
		$data = $this->overtime_management_model->get_sections($department_id);
		echo json_encode($data);
	}

	public function get_subsections($department_id)
	{
		$data = $this->overtime_management_model->get_subsections($department_id);
		echo json_encode($data);
	}

	public function get_locations($division_id, $dept_id, $section_id, $subsection_id)
	{
		$data = $this->overtime_management_model->get_locations($division_id, $dept_id, $section_id, $subsection_id);
		echo json_encode($data);
	}

	public function get_people($division_id, $dept_id, $section_id, $subsection_id, $location_id, $date)
	{
		$data = $this->overtime_management_model->get_people($division_id, $dept_id, $section_id, $subsection_id, $location_id, $date);
		echo json_encode($data);
	}
}