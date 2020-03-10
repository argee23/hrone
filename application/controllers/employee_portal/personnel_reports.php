<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class Personnel_reports extends General {

	function __construct() {
		parent::__construct();	
		$this->load->model("employee_portal/personnel_reports_model");
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$this->load->model("employee_portal/overtime_management_model");
		$this->load->model("app/transaction_employees_model");
		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}

	//personnel leave calendar (plc)
	public function index_leave_calendar()
	{
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/personnel_reports/plc_index');
		$this->load->view('employee_portal/footer');
	}

	public function view_leave_calendar()
	{
		$company_id = $this->session->userdata('company_id');
		$this->load->view('employee_portal/personnel_reports/view_leave_calendar');
	}

	public function get_leave_for_calendar()
	{
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$company_id = $this->session->userdata('company_id');
		$data = $this->personnel_reports_model->get_leave_for_calendar($company_id, $start, $end);
		echo json_encode($data);
	}


	//personnel pre approved overtime (pao)
	public function index_preapproved_ot()
	{
		$this->load->view('employee_portal/header');
		$this->data['overtime_filing_type']= $this->personnel_reports_model->atro_policy_main();	
		$this->load->view('employee_portal/personnel_reports/pao_index',$this->data);
		$this->load->view('employee_portal/footer');
	}
	public function index_approved_ot()
	{
		$this->load->view('employee_portal/header');
		$this->data['overtime_filing_type']= $this->personnel_reports_model->atro_policy_main();	
		$this->load->view('employee_portal/personnel_reports/allowed_ot_index',$this->data);
		$this->load->view('employee_portal/footer');
	}
	
	public function view_crystal_report($type,$option)
	{
		$this->data['type']=$type;
		$this->data['crystal_report']=$this->personnel_reports_model->get_crystal_report_view($type,$option);
		$this->load->view('employee_portal/personnel_reports/crystal_report',$this->data);
	}

	public function addform_crystal_report($type)
	{
		$this->data['type']=$type;
		$this->data['crystal_report_list']=$this->personnel_reports_model->get_crystal_report_list($type);
		$this->load->view('employee_portal/personnel_reports/addform_crystal_report',$this->data);
	}
	public function save_crystal_reports($type,$name,$desc,$data,$action,$id)
	{
		$this->data['type']=$type;
		$actionn = $this->personnel_reports_model->save_crystal_reports($type,$name,$desc,$data,$action,$id);
		$this->data['crystal_report']=$this->personnel_reports_model->get_crystal_report($type);
		$this->load->view('employee_portal/personnel_reports/crystal_report',$this->data);
	}

	public function del_stat_crystal_report($option,$id,$type)
	{
		$this->data['type']=$type;
		$action = $this->personnel_reports_model->del_stat_crystal_report($option,$id);
		$this->data['crystal_report']=$this->personnel_reports_model->get_crystal_report($type);
		$this->load->view('employee_portal/personnel_reports/crystal_report',$this->data);
	}

	public function editform_crystal_report($id,$type,$action)
	{
		$this->data['id']=$id;
		$this->data['type']=$type;
		$this->data['crystal_report_details']=$this->personnel_reports_model->crystal_report_details($id);
		$this->data['crystal_report_list']=$this->personnel_reports_model->get_crystal_report_list($type);
		if($action=='edit'){ $this->load->view('employee_portal/personnel_reports/editform_crystal_report',$this->data); }
		else{ $this->load->view('employee_portal/personnel_reports/viewdetails_crystal_report',$this->data); }
		
	}
	public function view_generate_reports_group($type)
	{
		$company_id = $this->session->userdata('company_id');
		$employee_id  = $this->session->userdata('employee_id');

		$this->data['type']=$type;
		$this->data['group']= $this->personnel_reports_model->get_pre_approved_groups();
		$this->data['classifications']=$this->personnel_reports_model->classification_list($company_id);
		$this->data['sections']=$this->personnel_reports_model->section_list($company_id,$employee_id);
		$this->data['locations']=$this->personnel_reports_model->location_list($company_id,$employee_id);
		$this->data['crystal_report_list']=$this->personnel_reports_model->get_crystal_report($type);
		$this->load->view('employee_portal/personnel_reports/pao_generate_reports_group',$this->data);
	}
	public function view_generate_reports_general($type)
	{
		$this->data['type']=$type;
		$company_id = $this->session->userdata('company_id');
		$employee_id  = $this->session->userdata('employee_id');
		$this->data['classifications']=$this->personnel_reports_model->classification_list($company_id);
		$this->data['sections']=$this->personnel_reports_model->section_list($company_id,$employee_id);
		$this->data['locations']=$this->personnel_reports_model->location_list($company_id,$employee_id);
		$this->data['crystal_report_list']=$this->personnel_reports_model->get_crystal_report($type);
		$this->data['date']= $this->personnel_reports_model->get_date_preapproved('Year','general','-','-',$type);
		$this->load->view('employee_portal/personnel_reports/generate_reports_general',$this->data);
	}
	public function get_dates($option,$value1,$value2,$value3,$type_option)
	{
		$date= $this->personnel_reports_model->get_date_preapproved($option,$value1,$value2,$value3,$type_option);
		
		if($option=='Year')
		{	
			
			echo "<option>Select Year</option>";
			foreach ($date as $y)
			{
				echo "<option value='".date("Y", strtotime($y->date))."'>".date("Y", strtotime($y->date))."</option>";
			}
		}
		elseif($option=='Month')
		{
			echo "<option>Select Month</option>";
			foreach ($date as $m)
			{
				echo "<option value=".date("m", strtotime($m->date)).">".date("M", strtotime($m->date))."</option>";
			}
		}
		elseif($option=='Day')
		{
			echo "<option>Select Day</option>";
			foreach ($date as $m)
			{
				echo "<option>".date("d", strtotime($m->date))."</option>";
			}
		}
	}

	public function view_generate_report_single_field($type,$filter,$year,$month,$day,$report,$group,$option,$overtime_filing_type,$employees,$employeeid,$section,$subsection,$location,$classification,$employment)
	{
		$this->data['date']=$year."-".$month."-".$day;
		$this->data['group']=$group;
		$this->data['year']=$year;
		$this->data['month']=$month;
		$this->data['day']=$day;
		$this->data['type']=$type;
		$this->data['filter']=$filter;
		$this->data['report_fields']=$this->personnel_reports_model->get_report_fields_filter($report,$type);
		$this->data['details']= $this->personnel_reports_model->get_employees_with_preapproved_single_field($type,$filter,$group,$year,$month,$day,$option,$overtime_filing_type,$employees,$employeeid,$section,$subsection,$location,$classification,$employment);
		
		$this->load->view('employee_portal/personnel_reports/overtime_filtered_get_employees', $this->data);
	}
	public function view_generate_report_date_range($type,$filter,$from,$to,$report,$group,$option,$overtime_filing_type,$employees,$employeeid,$section,$subsection,$location,$classification,$employment)
	{ 
		
	 	$this->data['from']=$from;
		$this->data['to']=$to;
		$this->data['type']=$type;
		$this->data['filter']=$filter;
		$this->data['report_fields']=$this->personnel_reports_model->get_report_fields_filter($report,$type);
		$this->data['details']= $this->personnel_reports_model->get_employees_with_preapproved_date_range($type,$filter,$group,$from,$to,$option,$overtime_filing_type,$employees,$employeeid,$section,$subsection,$location,$classification,$employment);
		//$this->data['checker']= $this->personnel_reports_model->checker_plotted($this->data['date'],$group);
		
		$this->load->view('employee_portal/personnel_reports/overtime_filtered_get_employees', $this->data);
	}

	//personnel form reports

	public function index_forms_report()
	{
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/personnel_reports/forms_report_index',$this->data);
		$this->load->view('employee_portal/footer');
	}

	//forms report

	public function view_fr_generate_reports($type)
	{
		$company_id = $this->session->userdata('company_id');
		$employee_id  = $this->session->userdata('employee_id');
		$this->data['type']=$type;
		$this->data['transactions']=$this->personnel_reports_model->transaction_list($company_id);
		$this->data['classifications']=$this->personnel_reports_model->classification_list($company_id);
		$this->data['sections']=$this->personnel_reports_model->section_list($company_id,$employee_id);
		$this->data['locations']=$this->personnel_reports_model->location_list($company_id,$employee_id);
		$this->data['crystal_report_list']=$this->personnel_reports_model->get_crystal_report_filtering($type);
		$this->load->view('employee_portal/personnel_reports/fr_generate_reports',$this->data);
	}

	public function search_employee_list($search = NULL)
	{
		$company_id = $this->session->userdata('company_id');
		$this->data['query'] = $this->personnel_reports_model->employeelist_model($search,$company_id);
		$this->load->view('employee_portal/personnel_reports/search_employee_list',$this->data);
	}
	public function get_subsection($section)
	{
		$company_id = $this->session->userdata('company_id');
		$employee_id  = $this->session->userdata('employee_id');
		if($section=='All'){ $checker = 1; }
		else{
			$checker =   $this->personnel_reports_model->checker_subsection($section);
		}
		
			if(!empty($checker) AND $checker==1)
			{

				$subsection= $this->personnel_reports_model->get_subsection($section,$company_id,$employee_id);
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
	public function generate_report_forms($employees,$crystal_report,$transactions,$status,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id)
	{
		$company_id = $this->session->userdata('company_id');
		$this->data['transaction']=$transactions;
		$this->data['transactions']=$this->personnel_reports_model->transaction_list($company_id);
		$this->data['trans_title']=$this->personnel_reports_model->get_trans_title($transactions);
		
		$this->data['transs']=$this->personnel_reports_model->transaction_details($transactions);
		
		$this->data['details']=$this->personnel_reports_model->generate_report_forms_details($employees,$crystal_report,$transactions,$status,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id);
		$this->data['forms_filter'] = array($employees,$crystal_report,$transactions,$status,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id);
		$this->data['report_fields']=$this->personnel_reports_model->get_report_fields_filter($crystal_report,'forms_report');
		$this->load->view('employee_portal/personnel_reports/forms_report_result',$this->data);
	}
	public function fr_filter_view_by_transaction($employees,$crystal_report,$transactions,$status,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id)
	{
		$this->load->view('employee_portal/header');	
		$company_id = $this->session->userdata('company_id');
		$this->data['transactions']=$this->personnel_reports_model->transaction_list($company_id);
		$this->data['details']=$this->personnel_reports_model->generate_report_forms_details($employees,$crystal_report,$transactions,$status,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id);
		$this->data['forms_filter'] = array($employees,$crystal_report,$transactions,$status,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id);
		$this->data['report_fields']=$this->personnel_reports_model->get_report_fields_filter($crystal_report,'forms_report');
		$this->load->view('employee_portal/personnel_reports/fr_filter_view_by_transaction',$this->data);
		$this->load->view('employee_portal/footer');
	}



	// for schedule report
	public function index_schedule_report()
	{
		$this->load->view('employee_portal/header');	
		$this->load->view('employee_portal/personnel_reports/schedule_index');
		$this->load->view('employee_portal/footer');
	}

	public function view_schedule_generate_reports($type)
	{
		$this->data['type']=$type;
		$company_id = $this->session->userdata('company_id');
		$employee_id  = $this->session->userdata('employee_id');
		$this->data['classifications']=$this->personnel_reports_model->classification_list($company_id);
		$this->data['sections']=$this->personnel_reports_model->section_list($company_id,$employee_id);
		$this->data['locations']=$this->personnel_reports_model->location_list($company_id,$employee_id);
		$this->data['crystal_report_list']=$this->personnel_reports_model->get_crystal_report_filtering($type);
		$this->data['groups']=$this->personnel_reports_model->get_groups_sm($employee_id);
		$this->load->view('employee_portal/personnel_reports/schedule_generate_reports',$this->data);
	}

	public function working_schedule_generate_report($employees,$crystal_report,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id,$group,$option)
	{
		
		$company_id = $this->session->userdata('company_id');
		$employee_id  = $this->session->userdata('employee_id');
		$this->data['forms_filter'] = array($employees,$crystal_report,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id,$group,$option);
		$this->data['employees']=$employees;
		$this->data['date_from']=$date_from;
		$this->data['date_to']=$date_to;
		$this->data['details']=$this->personnel_reports_model->generate_report_schedule_details($employees,$crystal_report,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id,$company_id,$group,$option);
		$this->data['report_fields']=$this->personnel_reports_model->get_report_fields_filter($crystal_report,'schedule');
		$this->data['groups_details']=$this->personnel_reports_model->get_group_details_sm($group,'sm');
		$this->load->view('employee_portal/personnel_reports/working_schedule_generate_report',$this->data);
		
	}

	public function working_schedule_filter_view_others($employees,$crystal_report,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id,$group,$option,$mm)
	{
	
		$this->load->view('employee_portal/header');
		$this->data['forms_filter'] = array($employees,$crystal_report,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id,$group,$option);
		$this->data['report_fields']=$this->personnel_reports_model->get_report_fields_filter($crystal_report,'schedule');
		$company_id = $this->session->userdata('company_id');
		if($mm=='by_date')
		{
			$this->data['type']='date';
			$this->data['details']=$this->personnel_reports_model->ws_for_all_individual_by_date_emp($employees,$crystal_report,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id,$group,$option,'date');
			$this->load->view('employee_portal/personnel_reports/working_schedule_generate_report_by_date_emp',$this->data);
		}
		elseif($mm=='by_emp')
		{

			$this->data['type']='employee_id';
			$this->data['details']=$this->personnel_reports_model->ws_for_all_individual_by_date_emp($employees,$crystal_report,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id,$group,$option,'employee_id');
			$this->load->view('employee_portal/personnel_reports/working_schedule_generate_report_by_date_emp',$this->data);
		}
		else if($mm=='by_group' || $mm=='by_group_emp')
		{

			$this->data['groups_details']=$this->personnel_reports_model->get_group_details_sm($group,'plotted_sm');

			if($mm=='by_group')
			{
				$this->data['type']='plotted_sm';
			}
			else{

				$this->data['type']='official_ws';

			}
			
			$this->data['details']=$this->personnel_reports_model->generate_report_schedule_by_grp($employees,$crystal_report,$date_from,$date_to,$section,$subsection,$loc,$classs,$empp,$employees_id,$company_id,$group,$option);
			
			$this->load->view('employee_portal/personnel_reports/working_schedule_generate_report_by_group',$this->data);
		}
		else
		{
			
		}
		$this->load->view('employee_portal/footer');
	}

	




























	//for all
	function get_crystal_report_fields($id,$type)
	{
		$this->data['id']=$id;
		$this->data['t_type']=$type;
		$get_dd = $this->personnel_reports_model->get_crystal_fields($id,$type); 
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

}