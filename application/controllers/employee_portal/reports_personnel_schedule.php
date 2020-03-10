<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Reports_personnel_schedule extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/reports_personnel_schedule_model");
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}

	public function index()
	{
		$this->load->view('employee_portal/header');
		$this->data['department'] = $this->reports_personnel_schedule_model->get_section_mngr_details('department');
		$this->data['departmentList'] = $this->reports_personnel_schedule_model->departmentList($this->data['department']);
		$this->data['sectionGroup'] = $this->reports_personnel_schedule_model->sectionGroup($this->data['department']);
		$this->load->view('employee_portal/report_personnel/schedule/index',$this->data);	
		$this->load->view('employee_portal/footer');
	}

	public function schedules_result($val,$option,$show_opt)
	{
		$this->data['option'] = $option;
		$this->data['val'] = $val;
		$this->data['show_opt'] = $show_opt;
		$this->data['option'] = $option;
		$this->load->view('employee_portal/report_personnel/schedule/schedules_calendar_result',$this->data);	
	}

	public function schedules_result_calendar($val,$option,$show_opt)
	{
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$data = $this->reports_personnel_schedule_model->schedules_result_calendar($val, $start, $end,$option,$show_opt);
		echo json_encode($data);
	}

	public function schedule_calendar_modal($date,$val,$option,$show_opt)
	{
		$tmonth= substr($date, 5,2);
        $year =  date("Y", strtotime($date));
        $this->data['date'] = $date;
        $this->data['get_schedules'] = $this->reports_personnel_schedule_model->get_employee_schedules($val,$date,$tmonth,$year,$option,$show_opt);
		$this->load->view('employee_portal/report_personnel/schedule/schedules_calendar_modal',$this->data);	
	}

	public function show_calendar_employment_details()
	{
		$this->data['department'] = $this->reports_personnel_schedule_model->get_section_mngr_details('department');
		$this->data['departmentList'] = $this->reports_personnel_schedule_model->departmentList($this->data['department']);
		$this->data['company'] = $this->reports_personnel_schedule_model->get_company_list();
		$this->load->view('employee_portal/report_personnel/schedule/schedule_calendar_employment',$this->data);
	}

	public function calendar_department($company)
	{
		
		$deptList = $this->reports_personnel_schedule_model->calendar_department($company);
		echo "<option value='All'>All</option>";
		foreach($deptList as  $d)
		{
				echo "<option value='".$d->department_id."'>".$d->dept_name."</option>";
		}
		
	}

	public function calendar_section($company,$department)
	{
		$sectionList = $this->reports_personnel_schedule_model->calendar_section($company,$department);
		echo "<option value='All'>All</option>";
		foreach($sectionList as $s)
		{
			echo "<option value='".$s->section_id."'>".$s->section_name."</option>";
		}
	}
	
	public function calendar_individual_employees($option)
	{
		$this->data['individual_option'] = $option;
		$this->data['employees']  = $this->reports_personnel_schedule_model->calendar_individual_employees();
 		$this->load->view('employee_portal/report_personnel/schedule/schedule_calendar_emp_list',$this->data);

	}

	public function schedules_individual_result($employee)
	{?>
		
        <div class="col-md-12" id="calendar_option_employee">
        </div>
           
	<?php }

	public function calendar_individual_sched($employee)
	{
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$data = $this->reports_personnel_schedule_model->calendar_individual_sched($employee, $start, $end);
		echo json_encode($data);
	}

	
	public function schedule_individual_calendar_modal($date,$employee)
	{
		$this->data['employee_id'] = $employee;
		$this->data['date'] = $date;
		$tmonth= substr($date, 5,2);
        $year =  date("Y", strtotime($date));
        $this->data['attendance'] = $this->reports_personnel_schedule_model->get_employee_attendance($employee,$date);
        $this->data['change_sched'] = $this->reports_personnel_schedule_model->filed_change_sched($employee,$date);
        $this->data['change_restday'] = $this->reports_personnel_schedule_model->filed_change_restday($employee,$date,'orig_rest_day');
        $this->data['change_restday_requested'] = $this->reports_personnel_schedule_model->filed_change_restday($employee,$date,'request_rest_day');
        $this->data['leave'] = $this->reports_personnel_schedule_model->filed_leave($employee,$date);
        $this->data['ob'] = $this->reports_personnel_schedule_model->filed_ob($employee,$date);
        $this->data['ot'] = $this->reports_personnel_schedule_model->filed_ot($employee,$date);
        $this->data['tk'] = $this->reports_personnel_schedule_model->filed_tk($employee,$date);
        $this->data['undertime'] = $this->reports_personnel_schedule_model->filed_undertime($employee,$date);
		$this->load->view('employee_portal/report_personnel/schedule/schedule_individual_calendar_modal',$this->data);
	}

	//excel report
	public function excel_report_payroll_period()
	{ 
		$employee_id = $this->session->userdata('employee_id');
		$this->data['report'] = 'By Payroll Period Group';
		$this->data['fields'] = $this->reports_personnel_schedule_model->crystal_report_working_schedule_attendance();
		$this->data['company'] = $this->reports_personnel_schedule_model->get_company_list($employee_id);
		$this->load->view('employee_portal/report_personnel/schedule/schedule_excel_payroll_period_group',$this->data);	
	}

	
	public function excel_group($paytype,$company)
	{
		$paytype_group = $this->reports_personnel_schedule_model->get_paytype_group($paytype,$company);
		if(!empty($paytype_group))
		{
			echo "<option value=''>Select Group</option>";
			foreach($paytype_group as $pg)
			{
				echo "<option value='".$pg->payroll_period_group_id."'>".$pg->group_name."</option>";
			}
		}
		else
		{
			echo "<option value=''>No group found. Add first to continue.</option>";
		}
	}
	public function excel_payroll_period($paytype,$company,$group)
	{
		$payroll_group = $this->reports_personnel_schedule_model->get_payroll_group($paytype,$company,$group);
		if(!empty($payroll_group))
		{
			echo "<option value=''>Select Payroll Period</option>";
			foreach($payroll_group as $per)
			{
				$from = $per->year_from .'-'. $per->month_from.'-'.$per->day_from;
                $to = $per->year_to .'-'. $per->month_to.'-'.$per->day_to;
                $formatted =  date("F d, Y", strtotime($from)) . " to " .  date("F d, Y", strtotime($to));
				echo "<option value='".$per->id."'>".$formatted."</option>";
			}
		}
		else
		{
			echo "<option value=''>No payroll period found. Add first to continue.</option>";
		}
	}

	public function excel_payroll_period_report()
	{
		$this->data['option'] = $this->input->post('option');
		$this->data['fields'] = $this->input->post('final_report');
		$company_id = $this->input->post('company');
		$payroll_period = $this->input->post('payroll_period');
		$group = $this->input->post('group');
		$payroll_period_date = $this->reports_personnel_schedule_model->get_payroll_period_date($payroll_period);
		$this->data['from'] = $payroll_period_date->complete_from;
		$this->data['to'] = $payroll_period_date->complete_to;
		$this->data['payroll_period'] = $payroll_period;
		$this->data['group'] = $group;
		//$this->data['company'] = $this->reports_working_schedule_model->get_section_mngr_details('company_id');
		$this->data['location'] = $this->reports_personnel_schedule_model->get_section_mngr_details('location');
		$this->data['department'] = $this->reports_personnel_schedule_model->get_section_mngr_details('department');
		$this->data['section'] = $this->reports_personnel_schedule_model->get_section_mngr_details('section');
		$this->data['subsection'] = $this->reports_personnel_schedule_model->get_section_mngr_details('subsection');
		$this->data['employee_info'] = $this->reports_personnel_schedule_model->get_employee_info($payroll_period,$group,$this->data['location'],$this->data['department'],$this->data['section'],$this->data['subsection']);
		$this->data['departmentList'] = $this->reports_personnel_schedule_model->departmentList($this->data['department']);
		$this->data['locationList'] = $this->reports_personnel_schedule_model->locationList($this->data['location']);
		$this->data['classificationList'] = $this->reports_personnel_schedule_model->classificationList();
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/report_personnel/schedule/excel_payroll_period_report_result',$this->data);
		$this->load->view('employee_portal/footer');
	}

	public function filter_department($department)
	{
		$section = $this->reports_personnel_schedule_model->get_sectionList($department);
		if(empty($section))
		{
			echo "<option value=''>No section found.</option>";
		}
		else
		{
			echo "<option value='' selected disabled>Select Section</option>";
			// echo "<option value='All'>All</option>";
			foreach($section as $s)
			{
				echo "<option value='".$s->section_id."'>".$s->section_name."</option>";
			}

		}

	}

	public function filter_subsection($section,$department)
	{
		$subsection = $this->reports_personnel_schedule_model->get_subsectionList($section,$department);
		if(empty($subsection))
		{
			echo "<option value='not_included'>No Subsection found (not required)</option>";
		}
		else
		{
			echo "<option value='' selected disabled>Select Subsection</option>";
			foreach($subsection as $s)
			{
				echo "<option value='".$s->subsection_id."'>1".$s->subsection_name."</option>";
			}
		}
	}

	public function get_filter_payroll_period_result($department,$section,$subsection,$location,$classification,$fields,$from,$to,$payroll_period,$group)
	{
		
		$this->data['fields'] = $fields;
		$payroll_period_date = $this->reports_personnel_schedule_model->get_payroll_period_date($payroll_period);
		$this->data['from'] = $from;
		$this->data['to'] = $to;
		$this->data['employee_info'] = $this->reports_personnel_schedule_model->get_employee_info_filter($payroll_period,$group,$location,$department,$section,$subsection,$classification,$location);
		$this->load->view('employee_portal/report_personnel/schedule/excel_payroll_period_report_result_filter',$this->data);
	}


	//start of crystal report excel

	public function crystal_report_view()
	{
		$this->data['crystal_report']=$this->reports_personnel_schedule_model->crystal_report_view();
		$this->load->view('employee_portal/report_personnel/schedule/crystal_report',$this->data);
	}

	public function crystal_report_add()
	{
		$this->data['crystal_report_list']=$this->reports_personnel_schedule_model->crystal_report_list();
		$this->load->view('employee_portal/report_personnel/schedule/crystal_report_add',$this->data);
	}

	public function crystal_reports_saveadd($name,$desc,$data,$action,$id)
	{
	
		$actionn = $this->reports_personnel_schedule_model->crystal_reports_saveadd($name,$desc,$data,$action,$id);
		$this->data['crystal_report']=$this->reports_personnel_schedule_model->crystal_report_view();
		$this->load->view('employee_portal/report_personnel/schedule/crystal_report',$this->data);
	}

	public function crystal_report_del_stat($option,$id)
	{
		
		$action = $this->reports_personnel_schedule_model->crystal_report_del_stat($option,$id);
		$this->data['crystal_report']=$this->reports_personnel_schedule_model->crystal_report_view();
		$this->load->view('employee_portal/report_personnel/schedule/crystal_report',$this->data);
	}

	public function crystal_report_fields($id,$action)
	{
		$this->data['id']=$id;
		$this->data['crystal_report_details']=$this->reports_personnel_schedule_model->crystal_report_details($id);
		$this->data['crystal_report_list']=$this->reports_personnel_schedule_model->get_crystal_report_list();
		if($action=='edit')
		{
			$this->load->view('employee_portal/report_personnel/schedule/crystal_report_editdetails',$this->data);
		}
		else
		{
			$this->load->view('employee_portal/report_personnel/schedule/crystal_report_viewdetails',$this->data);	
		}
	}


	public function crystal_report_generate_reports()
	{

		$company_id = $this->session->userdata('company_id');
		$employee_id  = $this->session->userdata('employee_id');
		$this->data['classifications']=$this->reports_personnel_schedule_model->classification_list($company_id);
		$this->data['sections']=$this->reports_personnel_schedule_model->section_list($company_id,$employee_id);
		$this->data['locations']=$this->reports_personnel_schedule_model->location_list($company_id,$employee_id);
		$this->data['crystal_report_list']=$this->reports_personnel_schedule_model->crystal_report_view();
		$this->data['groups']=$this->reports_personnel_schedule_model->get_groups_sm($employee_id);
		$this->load->view('employee_portal/report_personnel/schedule/crystal_report_generate_reports',$this->data);
	}

	function get_crystal_report_fields($id)
	{
		$this->data['id']=$id;
		$get_dd = $this->reports_personnel_schedule_model->get_crystal_fields($id); 
		echo "<a  data-toggle='collapse'  data-target='#fields' style='cursor:pointer;' aria-hidden='true' title='Click to view members' >Click here to view crystal report fields.</a> ";
 		
 		echo ' <div class="collapse" style="height: 100px;padding-top:5px; overflow:scroll;" id="fields">
		      <div class="box box-success">
		        <div class="panel panel-info">
		              <div class="col-md-12" id="main_res" style="height: auto;">
		                    <div style="height: 100px;"><br>';
		                    $i=1; foreach ($get_dd as $dd) {
		                    	echo "<div class='col-md-6'>".$i.".".$dd->title."</div>";
		                    $i++; }
		                    
		                    '</div>
		              </div>
		              <div class="btn-group-vertical btn-block"> </div>   
		        </div>             
		      </div> 
		    </div> 
		</div>';

	}


	public function search_employee_list($search = NULL)
	{

		$company_id = $this->session->userdata('company_id');
		$this->data['query'] = $this->reports_personnel_schedule_model->employeelist_model($search,$company_id);
		$this->load->view('employee_portal/report_personnel/schedule/crystal_report_generate_reports_individual',$this->data);

	}

	public function get_subsection($section)
	{
		$company_id = $this->session->userdata('company_id');
		$employee_id  = $this->session->userdata('employee_id');
		if($section=='All'){ $checker = 1; }
		else{
			$checker =   $this->reports_personnel_schedule_model->checker_subsection($section);
		}
		
			if(!empty($checker) AND $checker==1)
			{

				$subsection= $this->reports_personnel_schedule_model->get_subsection($section,$company_id,$employee_id);
				if(empty($subsection)){ 
					if($section=='All')
					{	
						echo "<option value='not_included'>No need to fill up. Subsection is not required</option>";
					}
					else
					{
						echo "<option value=''>No subsection found.</option>"; 
					}
				}
				else{ 
					echo "<option value=''>Select</option>";
					echo "<option value='All'>All</option>"; 
				}
				foreach($subsection as $sb){
					echo "<option value='".$sb->subsection_id."'>".$sb->subsection_name."</option>";
				}
			}
			else{ echo "<option value='not_included'>No need to fill up. Subsection is not required in this section.</option>"; }
		
		
	}

	public function crystal_report_generate_report_result($employees,$crystal_report,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id,$group,$option)
	{
		
		$company_id = $this->session->userdata('company_id');
		$employee_id  = $this->session->userdata('employee_id');
		$this->data['forms_filter'] = array($employees,$crystal_report,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id,$group,$option);
		$this->data['employees']=$employees;
		$this->data['date_from']=$date_from;
		$this->data['date_to']=$date_to;
		$this->data['details']=$this->reports_personnel_schedule_model->generate_report_schedule_details($employees,$crystal_report,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id,$company_id,$group,$option);
		$this->data['report_fields']=$this->reports_personnel_schedule_model->get_report_fields_filter($crystal_report);
		$this->data['groups_details']=$this->reports_personnel_schedule_model->get_group_details_sm($group,'sm');
		$this->load->view('employee_portal/report_personnel/schedule/crystal_report_generate_report_result',$this->data);

		
	}
	//end of crystal report excel


	//start of excel report section mngr

	public function excel_report_sectionmngr($grp)
	{
		$this->data['fields'] = $this->reports_personnel_schedule_model->crystal_report_working_schedule_attendance();
		$this->data['grp'] = $grp;
		$this->load->view('employee_portal/report_personnel/schedule/excel_report_sectionmngr',$this->data);		
	}

	public function excel_report_section_mngr_result()
	{
		$this->data['fields'] = $this->input->post('final_report');
		$res_dateto = $this->input->post('res_dateto');
		$res_datefrom = $this->input->post('res_datefrom');
		$option = $this->input->post('option');
		$grp = $this->input->post('grp');
		$this->data['from']  = $res_datefrom;
		$this->data['title']  = $this->input->post('title');
		$this->data['to'] 	 = $res_dateto;
		$this->data['option'] 	 = $option;

		$this->data['employee_info'] = $this->reports_personnel_schedule_model->get_excel_report_section_mngr($grp);
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/report_personnel/schedule/excel_report_section_mngr_result',$this->data);
		$this->load->view('employee_portal/footer');
	}


	public function excel_report_department($department_id)
	{
		$this->data['fields'] = $this->reports_personnel_schedule_model->crystal_report_working_schedule_attendance();
		$this->data['department_id'] = $department_id;
		$this->load->view('employee_portal/report_personnel/schedule/excel_report_department',$this->data);
	}

	public function excel_report_department_result()
	{
		$this->data['fields'] = $this->input->post('final_report');
		$res_dateto = $this->input->post('res_dateto');
		$res_datefrom = $this->input->post('res_datefrom');
		$option = $this->input->post('option');
		$department_id = $this->input->post('department_id');
		$this->data['from']  = $res_datefrom;
		$this->data['title']  = $this->input->post('title');
		$this->data['to'] 	 = $res_dateto;
		$this->data['option'] 	 = $option;
		$this->data['employee_info'] = $this->reports_personnel_schedule_model->get_excel_report_department($department_id);
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/report_personnel/schedule/excel_report_department_result',$this->data);
		$this->load->view('employee_portal/footer');
	}
	//end of excel report section mngr report

	public function date_range_report()
	{
		$this->data['crystal_report']=$this->reports_personnel_schedule_model->crystal_report_view();
		$this->data['company_list'] = $this->reports_personnel_schedule_model->company_list();
		$this->load->view('employee_portal/report_personnel/schedule/date_range_report',$this->data);
	}


	public function generate_report_result_date_range()
	{
		$from = $this->input->post('date_from');
		$to =  $this->input->post('date_to');
		$this->data['title'] = 'Schedulel Report: '.$from.' to '.$to;
		$report =$this->input->post('report');
		$this->data['results'] = $this->reports_personnel_schedule_model->generate_report_result_date_range();
		$this->data['report'] = $report;
		if($report!='default')
		{
			$this->data['crystal_report']=$this->reports_personnel_schedule_model->get_report_fields_filter($report);

		}
		
		$this->data['report_fields']=$this->reports_personnel_schedule_model->get_report_fields_filter($report);
		$this->load->view('employee_portal/report_personnel/schedule/generate_report_result',$this->data);

	}

	public function crystal_report_generate_payroll_period()
	{
		$this->data['crystal_report']=$this->reports_personnel_schedule_model->crystal_report_view();
		$this->data['company_list'] = $this->reports_personnel_schedule_model->company_list();
		$this->load->view('employee_portal/report_personnel/schedule/payroll_period_report',$this->data);
	}

	public function pp_get_paytype_group($company,$paytype)
	{
		$paytype_group = $this->reports_personnel_schedule_model->get_paytype_group($paytype,$company);
		if(!empty($paytype_group))
		{
			echo "<option value='' selected disabled>Select Group</option>";
			foreach($paytype_group as $pg)
			{
				echo "<option value='".$pg->payroll_period_group_id."'>".$pg->group_name."</option>";
			}
		}
		else
		{
			echo "<option value=''>No group found. Add first to continue.</option>";
		}
	}


	public function pp_get_payroll_period($company,$pay_ype,$group)
	{
		$payroll_group = $this->reports_personnel_schedule_model->get_payroll_group($paytype,$company,$group);
		if(!empty($payroll_group))
		{
			echo "<option value='' disabled selected>Select Payroll Period</option>";
			foreach($payroll_group as $per)
			{
				$from = $per->year_from .'-'. $per->month_from.'-'.$per->day_from;
                $to = $per->year_to .'-'. $per->month_to.'-'.$per->day_to;
                $formatted =  date("F d, Y", strtotime($from)) . " to " .  date("F d, Y", strtotime($to));
				echo "<option value='".$per->id."'>".$formatted."</option>";
			}
		}
		else
		{
			echo "<option value=''>No payroll period found. Add first to continue.</option>";
		}
	}

	public function generate_report_result_payroll_period()
	{
		$report =$this->input->post('report');
		$payroll_period_id =$this->input->post('payrollperiod');
		$payroll_period = $this->reports_personnel_schedule_model->payroll_period_dates($payroll_period_id);
		$from = $payroll_period->complete_from;
		$to = $payroll_period->complete_to;


		$this->data['title'] = 'Schedulel Report: '.$from.' to '.$to;
		$report =$this->input->post('report');
		$this->data['results'] = $this->reports_personnel_schedule_model->generate_report_result_payroll_period($from,$to);
		$this->data['report'] = $report;
		if($report!='default')
		{
			$this->data['crystal_report']=$this->reports_personnel_schedule_model->get_report_fields_filter($report);

		}
		
		$this->data['report_fields']=$this->reports_personnel_schedule_model->get_report_fields_filter($report);
		$this->load->view('employee_portal/report_personnel/schedule/generate_report_result',$this->data);

	}

	public function employment_report()
	{
		$this->data['crystal_report']=$this->reports_personnel_schedule_model->crystal_report_view();
		$this->data['company_list'] = $this->reports_personnel_schedule_model->company_list();
		$this->load->view('employee_portal/report_personnel/schedule/employment_report',$this->data);
	}

	public function get_classification($company)
	{
		$classificationList = $this->reports_personnel_schedule_model->classificationList($company);
		if(!empty($classificationList))
		{
			echo "<option value='All'>All Classification</option>";
			foreach($classificationList as $c)
			{
				
				echo "<option value='".$c->classification_id."'>".$c->classification."</option>";
			}
		}
		else
		{
			echo "<option value=''>No classification found</option>";
		}	
	}

	public function get_location($company)
	{
		$locationList = $this->reports_personnel_schedule_model->get_location($company);
		if(!empty($locationList))
		{
			echo "<option value='All'>All Location</option>";
			foreach($locationList as $c)
			{
				
				echo "<option value='".$c->location_id."'>".$c->location_name."</option>";
			}
		}
		else
		{
			echo "<option value=''>No Location found</option>";
		}	
	}	


	public function get_department($company)
	{	
		$departmentList = $this->reports_personnel_schedule_model->get_department($company);
		if(!empty($departmentList))
		{
			echo "<option value='All'>All Department</option>";
			foreach($departmentList as $c)
			{
				
				echo "<option value='".$c->department_id."'>".$c->dept_name."</option>";
			}
		}
		else
		{
			echo "<option value=''>No Department found</option>";
		}
	}

	public function emp_get_section($company,$department)
	{
		$sectionList = $this->reports_personnel_schedule_model->get_section($company,$department);
		if(!empty($sectionList))
		{
			echo "<option value='All'>All Section</option>";
			foreach($sectionList as $c)
			{
				
				echo "<option value='".$c->section_id."'>".$c->section_name."</option>";
			}
		}
		else
		{
			echo "<option value=''>No Section found</option>";
		}
	}

	public function generate_report_result_employment()
	{
		$report =$this->input->post('report');
		$from =$this->input->post('from');
		$to =$this->input->post('to');

		$this->data['title'] = 'Schedule Report: '.$from.' to '.$to;
		$report =$this->input->post('report');
		$this->data['results'] = $this->reports_personnel_schedule_model->generate_report_result_employment($from,$to);
		$this->data['report'] = $report;
		if($report!='default')
		{
			$this->data['crystal_report']=$this->reports_personnel_schedule_model->get_report_fields_filter($report);
		}
		
		$this->data['report_fields']=$this->reports_personnel_schedule_model->get_report_fields_filter($report);
		$this->load->view('employee_portal/report_personnel/schedule/generate_report_result',$this->data);
	}

}