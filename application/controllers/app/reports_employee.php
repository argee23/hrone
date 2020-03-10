<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php';

class Reports_employee extends General
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("app/reports_employee_model" , "reports");
		$this->load->model("general_model");
		$this->load->dbforge();
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}

	public function index()
	{
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['employee_fields'] = $this->reports->getEmployeeFields();
		$this->load->view('app/reports/employee/employee',$this->data);
	}

	//get employee report from employee_report table
	public function report_list()
	{
		$this->data['record'] = $this->reports->getReports();
		if($this->data['record'])
		{
			$this->load->view('app/reports/employee/employee_report_list',$this->data);
		}
		else
		{
			$this->session->set_flashdata('error_message', 'Please add report to get data');
			$this->load->view('app/reports/employee/employee_report_list',$this->data);
		}
		
	}

	//populate dropdown list
	public function generate_report()
	{
		$this->data['reports'] = $this->reports->getReports();
		$this->data['date_employed'] = $this->reports->getDateEmployed();
		$this->load->view('app/reports/employee/employee_generate_report' , $this->data);
	}

	//save report
	public function insert_report($report_name,$report_desc,$report_fields)
	{
		$insert = $this->reports->insert_report($report_name,$report_desc,$report_fields);
		if ($insert) 
		{
			$this->session->set_flashdata('success_msg', 'Record Added Successfully');
			$this->data['record'] = $this->reports->getReports();
			$this->load->view('app/reports/employee/employee_report_list',$this->data);
		}
		else
		{
			$this->session->set_flashdata('error_msg', 'Failed to Add Record');
			$this->data['record'] = $this->reports->getReports();
			$this->load->view('app/reports/employee/employee_report_list',$this->data);
		}
	}

	//filter employee report data
	public function filter_employee($report,$company,$division,$department,$section,$subsection,$classification,$location,$civil_status,$employment,$gender,$religion,$date_employed,$taxcode,$paytype,$status,$age,$age_comparator,$years,$years_comparator)
	{
		$this->data['report_fields'] = $this->reports->report_fields($report);
		$this->data['filter'] = $this->reports->filter_employee($report,$company,$division,$department,$section,$subsection,$classification,$location,$civil_status,$employment,$gender,$religion,$date_employed,$taxcode,$paytype,$status,$age,$age_comparator,$years,$years_comparator);
		if ($this->data['filter']) 
		{
			$this->load->view('app/reports/employee/view_employee_report',$this->data);
		}
		else
		{
			$this->session->set_flashdata('message', 'No Available Record');
			$this->load->view('app/reports/employee/view_employee_report',$this->data);
		}
	}

	//get employee report data based from report id
	public function edit_report($id)
	{
		$data['report_details'] = $this->reports->report_details($id);
		$data['report_fields'] = $this->reports->report_fields($id);
		echo json_encode($data);
	}

	//update report
	public function update_report($report_name,$report_desc,$report_fields,$report_id)
	{
		$update = $this->reports->update_report($report_name,$report_desc,$report_fields,$report_id);
		if ($update) 
		{
			$this->session->set_flashdata('success_msg', 'Record Updated Successfully');
			$this->data['record'] = $this->reports->getReports();
			$this->load->view('app/reports/employee/employee_report_list',$this->data);
		}
		else
		{
			$this->session->set_flashdata('error_msg', 'Failed to Update Record');
			$this->data['record'] = $this->reports->getReports();
			$this->load->view('app/reports/employee/employee_report_list',$this->data);
		}
	}

	//delete report
	public function delete_report($id)
	{
		$delete = $this->reports->delete_report($id);
		if ($delete) 
		{
			$this->session->set_flashdata('success_msg', 'Record Deleted Successfully');
			$this->data['record'] = $this->reports->getReports();
			$this->load->view('app/reports/employee/employee_report_list',$this->data);
		}
		else
		{
			$this->session->set_flashdata('error_msg', 'Failed to Delete Record');
			$this->data['record'] = $this->reports->getReports();
			$this->load->view('app/reports/employee/employee_report_list',$this->data);
		}
	}

	//check if company has division
	public function check_div()
	{
		$company_id = $this->input->post('company_id');
		if($this->reports->check_div($company_id))
		{
			$data['div'] = $this->reports->getDivision($company_id);
			$data['class'] = $this->reports->getClassification($company_id);
			echo json_encode($data);
		}
		else
		{
			$data['dept'] = $this->reports->getDepartment($company_id);
			$data['class'] = $this->reports->getClassification($company_id);
			echo json_encode($data);
		}
	}

	//get department details from department table filter by division id
	public function get_dept()
	{
		$division_id = $this->input->post('division_id');
		$department['dept'] = $this->reports->get_dept($division_id);
		echo json_encode($department);
	}

	//get section details from subsection table filter by department id
	public function get_sec()
	{
		$department_id = $this->input->post('department_id');
		$section['sec'] = $this->reports->get_sec($department_id);
		echo json_encode($section);
	}

	//get subsection details from subsection table filter by section id
	public function get_subsec()
	{
		$section_id = $this->input->post('section_id');
		$subsection['subsec'] = $this->reports->get_subsec($section_id);
		echo json_encode($subsection);
	}
}
 
?>