<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 
	
class reports_payroll extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/employee_model");
		$this->load->model("app/reports_payroll_model");
		$this->load->model("app/report_time_model");
		$this->load->model("app/time_dtr_model");
		$this->load->model("app/payroll_generate_payslip_model");
		$this->load->model("general_model");
		$this->load->dbforge();
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}

	//index
	public function index(){	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['crystal_report'] = $this->reports_payroll_model->crystal_report_payroll();
		$this->data['bankFileList']=$this->reports_payroll_model->getBankFile();
		$this->load->view('app/reports/payroll/working_schedule/home',$this->data);
		//$this->reports_time_index();	
	}

	//list of report list
	public function reports_time_index()
	{
		$this->data['bankFileList']=$this->reports_payroll_model->getBankFile();
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['crystal_report'] = $this->reports_payroll_model->crystal_report_payroll();
		$this->load->view('app/reports/payroll/working_schedule/home',$this->data);
	}

	//add report
	public function add_reports()
	{
		$this->data['crystal_report'] = $this->reports_payroll_model->crystal_report_payroll();
		$this->load->view('app/reports/payroll/add_reports',$this->data);
	}

	//save new reort
	public function save_new_report($report_type,$report_name,$report_desc,$fields)
	{
		$report_name=urldecode($report_name);
		$check_report_name=$this->reports_payroll_model->validate_report_name($report_name,$report_type);
		if(!empty($check_report_name)){	// already exist

			$this->data['message']="<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Report Name <strong>".$report_name."</strong> Already Exist!</div>";

		}else{	// allow add

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Reports','Time>Crystal Report','logfile_reports_time','add report name : '.$report_name.'','INSERT',$report_name);			
			$insert = $this->reports_payroll_model->add_new_report($fields,$report_name,$report_desc,$report_type);


			$this->data['message']="<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Report Name <strong>".$report_name."</strong> Successfully Added!</div>";
		}

		$this->data['system_defined_icons'] = $this->general_model->system_defined_icons();
		$this->data['report'] = $this->reports_payroll_model->report_list();
		$this->load->view('app/reports/payroll/working_schedule/reports_list',$this->data);
	}
	public function comp_group($val = 0){
		$this->data['company_id']=$val;
		$this->data['compGroup']= $this->reports_payroll_model->comp_group($val);
		$this->load->view('app/reports/payroll/bankfile/group_list',$this->data);
	}
	public function comp_group_pp($val = 0,$selected_company){
		if($val=="All"){
			$this->data['compGroupPayPeriod']= $this->reports_payroll_model->all_comp_payperiod($selected_company);
			$this->load->view('app/reports/payroll/bankfile/payperiod_by_month',$this->data);			
		}else{
			$this->data['compGroupPayPeriod']= $this->reports_payroll_model->compGroupPayPeriod($val);
			$this->load->view('app/reports/payroll/bankfile/payperiod_list',$this->data);
		}

	}
	public function cf_1604(){
		$this->load->view('app/reports/payroll/tax/cf_1604',$this->data);
	}
	public function getCompanyDetails($company_id,$year,
		$jan_remit_date,$feb_remit_date,$mar_remit_date,$apr_remit_date,$may_remit_date,$jun_remit_date,
		$jul_remit_date,$aug_remit_date,$sep_remit_date,$oct_remit_date,$nov_remit_date,$dec_remit_date,
		$jan_adj_enrty,$feb_adj_enrty,$mar_adj_enrty,$apr_adj_enrty,$may_adj_enrty,$jun_adj_enrty,
		$jul_adj_enrty,$aug_adj_enrty,$sep_adj_enrty,$oct_adj_enrty,$nov_adj_enrty,$dec_adj_enrty,
		$jan_pen_enrty,$feb_pen_enrty,$mar_pen_enrty,$apr_pen_enrty,$may_pen_enrty,$jun_pen_enrty,
		$jul_pen_enrty,$aug_pen_enrty,$sep_pen_enrty,$oct_pen_enrty,$nov_pen_enrty,$dec_pen_enrty){
		
		$this->data['jan_adj']=$jan_adj_enrty;	
		$this->data['feb_adj']=$feb_adj_enrty;	
		$this->data['mar_adj']=$mar_adj_enrty;	
		$this->data['apr_adj']=$apr_adj_enrty;	
		$this->data['may_adj']=$may_adj_enrty;	
		$this->data['jun_adj']=$jun_adj_enrty;	
		$this->data['jul_adj']=$jul_adj_enrty;	
		$this->data['aug_adj']=$aug_adj_enrty;	
		$this->data['sep_adj']=$sep_adj_enrty;	
		$this->data['oct_adj']=$oct_adj_enrty;	
		$this->data['nov_adj']=$nov_adj_enrty;	
		$this->data['dec_adj']=$dec_adj_enrty;	

		$this->data['jan_penalty']=$jan_pen_enrty;	
		$this->data['feb_penalty']=$feb_pen_enrty;	
		$this->data['mar_penalty']=$mar_pen_enrty;	
		$this->data['apr_penalty']=$apr_pen_enrty;	
		$this->data['may_penalty']=$may_pen_enrty;	
		$this->data['jun_penalty']=$jun_pen_enrty;	
		$this->data['jul_penalty']=$jul_pen_enrty;	
		$this->data['aug_penalty']=$aug_pen_enrty;	
		$this->data['sep_penalty']=$sep_pen_enrty;	
		$this->data['oct_penalty']=$oct_pen_enrty;	
		$this->data['nov_penalty']=$nov_pen_enrty;	
		$this->data['dec_penalty']=$dec_pen_enrty;	

		if($jan_remit_date=="0"){$jan_remit_date="";}else{}
		if($feb_remit_date=="0"){$feb_remit_date="";}else{}
		if($mar_remit_date=="0"){$mar_remit_date="";}else{}
		if($apr_remit_date=="0"){$apr_remit_date="";}else{}
		if($may_remit_date=="0"){$may_remit_date="";}else{}
		if($jun_remit_date=="0"){$jun_remit_date="";}else{}
		if($jul_remit_date=="0"){$jul_remit_date="";}else{}
		if($aug_remit_date=="0"){$aug_remit_date="";}else{}
		if($sep_remit_date=="0"){$sep_remit_date="";}else{}
		if($oct_remit_date=="0"){$oct_remit_date="";}else{}
		if($nov_remit_date=="0"){$nov_remit_date="";}else{}
		if($dec_remit_date=="0"){$dec_remit_date="";}else{}

		$this->data['jan_remit_date']=$jan_remit_date;
		$this->data['feb_remit_date']=$feb_remit_date;
		$this->data['mar_remit_date']=$mar_remit_date;
		$this->data['apr_remit_date']=$apr_remit_date;
		$this->data['may_remit_date']=$may_remit_date;
		$this->data['jun_remit_date']=$jun_remit_date;
		$this->data['jul_remit_date']=$jul_remit_date;
		$this->data['aug_remit_date']=$aug_remit_date;
		$this->data['sep_remit_date']=$sep_remit_date;
		$this->data['oct_remit_date']=$oct_remit_date;
		$this->data['nov_remit_date']=$nov_remit_date;
		$this->data['dec_remit_date']=$dec_remit_date;

	
		$this->data["cinfo"]=$this->general_model->get_company_info($company_id);


		$this->data["jan_tax"]=$this->reports_payroll_model->get_monthly_tax($company_id,$year,1);
		$this->data["feb_tax"]=$this->reports_payroll_model->get_monthly_tax($company_id,$year,2);
		$this->data["mar_tax"]=$this->reports_payroll_model->get_monthly_tax($company_id,$year,3);
		$this->data["apr_tax"]=$this->reports_payroll_model->get_monthly_tax($company_id,$year,4);
		$this->data["may_tax"]=$this->reports_payroll_model->get_monthly_tax($company_id,$year,5);
		$this->data["jun_tax"]=$this->reports_payroll_model->get_monthly_tax($company_id,$year,6);
		$this->data["jul_tax"]=$this->reports_payroll_model->get_monthly_tax($company_id,$year,7);
		$this->data["aug_tax"]=$this->reports_payroll_model->get_monthly_tax($company_id,$year,8);
		$this->data["sep_tax"]=$this->reports_payroll_model->get_monthly_tax($company_id,$year,9);
		$this->data["oct_tax"]=$this->reports_payroll_model->get_monthly_tax($company_id,$year,10);
		$this->data["nov_tax"]=$this->reports_payroll_model->get_monthly_tax($company_id,$year,11);
		$this->data["dec_tax"]=$this->reports_payroll_model->get_monthly_tax($company_id,$year,12);

		$this->data["company_id"]=$company_id;
		$this->data["year"]=$year;

		//$this->load->view('app/reports/payroll/tax/scratch',$this->data);
		$this->load->view('app/reports/payroll/tax/cf_1604_content',$this->data);

	}
	public function verify_tax_value($month,$company_id,$year){
		$this->data['emp_wtax']=$this->reports_payroll_model->get_monthly_tax_verification($month,$company_id,$year);
		$this->data['month']=$month;

		$this->load->view('app/reports/payroll/tax/cf_1604_content_how',$this->data);
	}
	public function c_1601(){

		$this->load->view('app/reports/payroll/tax/c_1601',$this->data);
	}
	public function show_1601c($company_id,$year,$month,$surcharge,$interest,$compromise){
		$this->data['month']=$month;	
		$this->data['year']=$year;	
		$this->data['company_id']=$company_id;

		$this->data['surcharge']=$surcharge;
		$this->data['interest']=$interest;
		$this->data['compromise']=$compromise;
		
		$this->data['comp_info']=$this->general_model->get_company_info($company_id);	

		$monthly_1601c=$this->reports_payroll_model->get_month_payperiod($month,$company_id,$year);

		$regpayslip_payroll_period="";
		$tertinpayslip_payroll_period="";

		if(!empty($monthly_1601c)){
			foreach($monthly_1601c as $p){
				$regpayslip_payroll_period.="a.payroll_period_id='".$p->id."' OR ";		
				$tertinpayslip_payroll_period.="a.release_payroll_period='".$p->id."' OR ";				
			}
			$regpayslip_payroll_period=substr($regpayslip_payroll_period, 0,-3);
			$regpayslip_payroll_period="AND ($regpayslip_payroll_period)";

			$tertinpayslip_payroll_period=substr($tertinpayslip_payroll_period, 0,-3);
			$tertinpayslip_payroll_period="AND ($tertinpayslip_payroll_period)";

		}else{

		}

		//check regular payslip
		$this->data['mp']=$this->reports_payroll_model->get_monthly_payslip($month,$company_id,$year,$regpayslip_payroll_period);

		//check regular payslip - other additions category.
		$this->data['oa']=$this->reports_payroll_model->get_monthly_payslip_oa($month,$company_id,$year,$regpayslip_payroll_period);

		//check separate 13th month payslip
		$this->data['tertin_pay']=$this->reports_payroll_model->get_monthly_tertin_month($month,$company_id,$year,$tertinpayslip_payroll_period);






		$this->load->view('app/reports/payroll/tax/c_1601_content',$this->data);
	}


	public function tr_2316(){//tr : tax report
		$this->load->view('app/reports/payroll/tax/tr_2316',$this->data);
	}
	public function alphalist(){//tr : tax report
		$this->load->view('app/reports/payroll/tax/alphalist_index',$this->data);
	}

	public function generate_2316($posted_id){

			// $covered_year=$this->input->post('covered_year');
			// $company_id=$this->input->post('company_id');
			// $alphalist_type=$this->input->post('alphalist_type');

			$this->data['e']=$this->reports_payroll_model->generate_2316($posted_id);
			//$this->data['posted_alpha']=$this->reports_payroll_model->generate_2316($covered_year,$company_id,$alphalist_type);
			$this->load->view('app/reports/payroll/tax/emp_2316',$this->data);
	}
	public function generate_alphalist(){//tr : tax report
		$this->load->view('app/reports/payroll/tax/alphalist_index',$this->data);
	}

	public function correct_sss_employer_share(){
		echo '
		<table border=1>
			<thead>
					<tr>
						<th>Employee ID</th>
						<th>Year Cover</th>
						<th>Month Cover</th>
						<th>CutOff</th>
						<th>SSS Gross</th>
						<th>Employer Share</th>
						<th>Must Be Employer Share in a month</th>
					</tr>
			</thead>
		<tbody>
		';	

		$gc=$this->reports_payroll_model->recheck_sss_employER();
		if(!empty($gc)){
			$sss_employer_whole_month=0;
			$er_tobe_adj=0;
			$current_sss_employer=0;
			$new_sss_employer=0;
			foreach($gc as $g){				
				$year_cover=$g->year_cover;
				$month_cover=$g->month_cover;
if(($month_cover>3)AND($year_cover=="2019")){// iba na table effective april sss

				$employee_id=$g->employee_id;
				$payroll_period_id=$g->payroll_period_id;
				$company_id=$g->company_id;		
				$sss_gross=$g->sss_gross;		
				$cut_off=$g->cut_off;	
				$pay_type=$g->pay_type;	
				$sss_employer=$g->sss_employer;	

if($cut_off=="2"){
	$hylight="style='background-color:#000;color:#fff;'";
}else{
	$hylight="";
}
				if($cut_off=="2"){
					$er_share=$this->reports_payroll_model->get_sss_table($company_id,$pay_type,$year_cover,$sss_gross);
					if(!empty($er_share)){
						$must_sss_employer_share=$er_share->ss_er; // employER
						$vses=$this->reports_payroll_model->validate_sss_er_share($year_cover,$month_cover,$employee_id);
						if(!empty($vses)){
							 $sss_employer_whole_month=$vses->sss_employer_whole_month;

if($must_sss_employer_share!=$sss_employer_whole_month){// if not equal yung nasave na employer share sa supposed to be na employer share.
							if($sss_employer_whole_month>0){
								$er_tobe_adj=$sss_employer_whole_month-$must_sss_employer_share;
								$er_saved=$this->reports_payroll_model->get_sss_employer_2nd($year_cover,$month_cover,$employee_id);
								if(!empty($er_saved)){
									$current_sss_employer=$er_saved->sss_employer;
									$payslip_id=$er_saved->payslip_id;
									$new_sss_employer=$current_sss_employer-$er_tobe_adj;
									$this->reports_payroll_model->UpdateSSSEmployer($month_cover,$payslip_id,$new_sss_employer,$employee_id);
								}else{
								}
							}else{
							}
}else{

}





						}else{
						}
					}else{
						$must_sss_employer_share="";					
					}
				}else{
					$must_sss_employer_share="";	
				}





			echo 
			"<tr >
			<td>$employee_id</td>
			<td>$year_cover</td>
			<td>$month_cover</td>
			<td>$cut_off</td>
			<td ".$hylight.">$sss_gross</td>
			<td >$sss_employer</td>
			<td>$must_sss_employer_share VS $sss_employer_whole_month THEN to be adjusted from 2nd cutoff is : $er_tobe_adj | SO 
			$current_sss_employer-$er_tobe_adj | in that case new sss employer will be $new_sss_employer;
			</td>
			</tr>";

}else{

}


			}//end of foreach employees
		}else{			
		}
		echo '
		</tbody></table>';


	}










	//===========EC
	public function correct_sss_employer_ec(){
		echo '
		<table border=1>
			<thead>
					<tr>
						<th>Employee ID</th>
						<th>Year Cover</th>
						<th>Month Cover</th>
						<th>Recomputed SSS EC</th>
					</tr>
			</thead>
		<tbody>
		';	


		$gc=$this->reports_payroll_model->get_payslip_gov_contri();
		if(!empty($gc)){
			foreach($gc as $g){
				$sss_ec_er=$g->sss_ec_er;
				$year_cover=$g->year_cover;
				$month_cover=$g->month_cover;
				$employee_id=$g->employee_id;
				$payroll_period_id=$g->payroll_period_id;
				$company_id=$g->company_id;	

				

				if($sss_ec_er=="20"){								
					$mpp=$this->reports_payroll_model->get_posted_month_pp($employee_id,$month_cover,$year_cover,$payroll_period_id);

					if(!empty($mpp)){
						foreach($mpp as $p){

							//echo "$employee_id | $year_cover | $month_cover <br>";
							$this->reports_payroll_model->correct_sss_ec($employee_id,$month_cover,$year_cover,$p->id,$p->cut_off);

							 $this->reports_payroll_model->correct_sss_ec_formula($employee_id,$month_cover,$year_cover,$p->id,$p->cut_off);
						}
					}else{

					}
					// 
				}else{

				}

			echo 
			"<tr>
			<td>$employee_id</td>
			<td>$year_cover</td>
			<td>$month_cover</td>
			<td>$sss_ec_er</td>
			</tr>";
	


			}
		}else{
		}
		echo '
		</tbody></table>';






	}

	public function correct_pi_employer_contribution(){
		echo '
		<table border=1>
			<thead>
					<tr>
						<th>Employee ID</th>
						<th>Year Cover</th>
						<th>Month Cover</th>
						<th>Recomputed Pagibig EmployER Share</th>
					</tr>
			</thead>
		<tbody>
		';


		$gc=$this->reports_payroll_model->get_payslip_gov_contri();
		if(!empty($gc)){
			foreach($gc as $g){
				$pagibig_employer=$g->pagibig_employer;
				$year_cover=$g->year_cover;
				$month_cover=$g->month_cover;
				$employee_id=$g->employee_id;
				$payroll_period_id=$g->payroll_period_id;
				$company_id=$g->company_id;	

				if($pagibig_employer=="200" OR $pagibig_employer=="150"){								
					$mpp=$this->reports_payroll_model->get_posted_month_pp($employee_id,$month_cover,$year_cover,$payroll_period_id);

					if(!empty($mpp)){
						foreach($mpp as $p){
							//echo "$employee_id | $year_cover | $month_cover <br>";
							$this->reports_payroll_model->correct_employer_contribution($employee_id,$month_cover,$year_cover,$p->id);
							$this->reports_payroll_model->correct_employer_contribution_formula($employee_id,$month_cover,$year_cover,$p->id);
						}
					}else{

					}
					// 
				}else{

				}

			echo 
			"<tr>
			<td>$employee_id</td>
			<td>$year_cover</td>
			<td>$month_cover</td>
			<td>$pagibig_employer</td>
			</tr>";
	


			}
		}else{
		}
		echo '
		</tbody></table>';

	}

	public function generated_alphalist(){//tr : tax report

		$this->data['report_result_type']=$report_result_type=$this->input->post('report_result_type');
		$this->data['generate_action']=$generate_action=$this->input->post('generate_action');
		$this->data['alphalist_type']=$alphalist_type=$this->input->post('alphalist_type');
		$this->data['company_id']=$company_id=$this->input->post('company_id');
		$this->data['covered_year']=$covered_year=$this->input->post('covered_year');

		$this->data['taxable_tertin_ceiling']=$this->reports_payroll_model->check_payroll_policy($company_id,20);

		$payslip_decimal=$this->reports_payroll_model->check_payslip_decimal($company_id);
		if(!empty($payslip_decimal)){
			$this->data['payslip_decimal_place']=$payslip_decimal->single_field;
		}else{
			$this->data['payslip_decimal_place']=2;// default decimal place
		}


		$yearly_pp=$this->reports_payroll_model->get_year_payperiod($company_id,$covered_year);
		$year_regpayslip_payroll_period="";
		$year_tertinpayslip_payroll_period="";
		

		if(!empty($yearly_pp)){
			foreach($yearly_pp as $p){
				$year_regpayslip_payroll_period.="a.payroll_period_id='".$p->id."' OR ";		
				$year_tertinpayslip_payroll_period.="a.release_payroll_period='".$p->id."' OR ";					
			}
			$year_regpayslip_payroll_period=substr($year_regpayslip_payroll_period, 0,-3);
			$year_tertinpayslip_payroll_period=substr($year_tertinpayslip_payroll_period, 0,-3);
			$year_regpayslip_payroll_period="AND ($year_regpayslip_payroll_period)";
			$year_tertinpayslip_payroll_period="AND ($year_tertinpayslip_payroll_period)";
		}else{

		}

		$this->data['year_regpayslip_payroll_period']=$year_regpayslip_payroll_period;
		$this->data['year_tertinpayslip_payroll_period']=$year_tertinpayslip_payroll_period;




		if($company_id=="All"){
			$check_company="";
		}else{
			$check_company="WHERE a.company_id='".$company_id."' ";
		}

		if($check_company==""){
			$check_cover_year="WHERE substr(a.date_resigned,1,4)='".$covered_year."' ";
		}else{
			$check_cover_year="AND substr(a.date_resigned,1,4)='".$covered_year."' ";
		}

		if($alphalist_type=="7_1"){//Alphalist of employees terminated before December 31
			$this->data['alpha']=$this->reports_payroll_model->get_alpha_1($alphalist_type,$check_company,$check_cover_year);
		}elseif($alphalist_type=="7_2"){
			$this->data['alpha']=$this->reports_payroll_model->get_alpha_2($alphalist_type,$company_id,$covered_year);
		}elseif($alphalist_type=="7_3"){//
			$this->data['alpha']=$this->reports_payroll_model->get_alpha_3($alphalist_type,$check_company,$covered_year);
		}elseif($alphalist_type=="7_4"){//
			$this->data['alpha']=$this->reports_payroll_model->get_alpha_4($alphalist_type,$check_company,$covered_year);
		}elseif($alphalist_type=="7_5"){//
			$this->data['alpha']=$this->reports_payroll_model->get_alpha_5($alphalist_type,$check_company,$covered_year);
		}else{
			
		}

		$this->data['covered_year']=$this->input->post('covered_year');


		$this->load->view('app/reports/payroll/tax/generated_alphalist',$this->data);
	}

	public function prev_employer_filter_employees($company_id,$covered_year){
		
		if($company_id=="All"){
			$check_company="";
			$check_date_employed="WHERE substr(date_employed,1,4)='".$covered_year."'";
		}else{
			$check_company="WHERE company_id='".$company_id."' ";
			$check_date_employed="AND substr(date_employed,1,4)='".$covered_year."'";
		}

		$this->data['check_company']=$check_company;
		$this->data['check_date_employed']=$check_date_employed;
		$this->data['covered_year']=$covered_year;
		$this->data['emp']=$this->reports_payroll_model->checkAllEmployees($check_company,$check_date_employed);
		$this->load->view('app/reports/payroll/tax/encode_previous_employer',$this->data);
	}



	public function save_previous_employer(){

echo '
<table class="table table" border=1>
	<thead>
		<tr>
			<th colspan="5" class="aligncenter bg-success">Employee Details</th>
			<th colspan="6" class="aligncenter bg-info">For 7.5</th>
			<th colspan="5" class="aligncenter bg-danger">Non-Taxable</th>
			<th colspan="5" class="aligncenter bg-warning">Taxable</th>
		</tr>
		<tr>
			
			<th class="bg-success">Employee ID</th>
			<th class="bg-success">Name</th>	
			<th class="bg-danger">Previous Employer Covered Year</th>	

			<th class="bg-info">Basic SMW</th>
			<th class="bg-info">Gross Compensation Income</th>
			<th class="bg-info">Holiday Pay</th>
			<th class="bg-info">Overtime Pay</th>
			<th class="bg-info">Shift Night Differential</th>
			<th class="bg-info">Hazard Pay</th>

			<th class="bg-danger">13th Month Pay & Other Benefits</th>
			<th class="bg-danger">De Minimis Benefits</th>
			<th class="bg-danger">SSS,GSIS,PHIC, & Pag - ibig Contributions, and Union Dues</th>
			<th class="bg-danger">Salaries & Other Forms of Compensation</th>
			<th class="bg-danger">Total Non-Taxable/Exempt Compensation Income</th>

			<th class="bg-warning">Basic Salary</th>
			<th class="bg-warning">13th Month Pay & Other Benefits</th>
			<th class="bg-warning">Salaries & Other Forms of Compensation</th>
			<th class="bg-warning">Total Taxable (Previous Employer)</th>
			<th class="bg-warning">Tax Withheld</th>
			<th class="bg-warning">Remarks</th>
		</tr>
	</thead>
	<tbody>
';

		foreach ($this->input->post('employee_id') as $key => $employee_id)			
		{
			$basic_smw=$this->input->post('basic_smw_'.$employee_id);
			$gross_compen_inc=$this->input->post('gross_compen_inc_'.$employee_id);
			$holiday_pay=$this->input->post('holiday_pay_'.$employee_id);
			$overtime_pay=$this->input->post('overtime_pay_'.$employee_id);
			$shift_differential=$this->input->post('shift_differential_'.$employee_id);
			$hazard_pay=$this->input->post('hazard_pay_'.$employee_id);


			$prev_employer_covered_year=$this->input->post('prev_employer_cy_'.$employee_id);
			$employee_name=$this->input->post('employee_name_'.$employee_id);
			$save_me=$this->input->post('save_me_'.$employee_id);	
			$nontax_tertinmonth=$this->input->post('nontax_tertinmonth_'.$employee_id);	
			$nontax_deminimis=$this->input->post('nontax_deminimis_'.$employee_id);	
			$gov_contri=$this->input->post('gov_contri_'.$employee_id);	
			$nontax_other_salaries=$this->input->post('nontax_other_salaries_'.$employee_id);


			$total_non_taxable=$nontax_tertinmonth+$nontax_deminimis+$gov_contri+$nontax_other_salaries+$basic_smw+$holiday_pay+$overtime_pay+$shift_differential+$hazard_pay;

			$basic_salary=$this->input->post('basic_salary_'.$employee_id);	
			$taxable_tertinmonth=$this->input->post('taxable_tertinmonth_'.$employee_id);	
			$taxable_other_salaries=$this->input->post('taxable_other_salaries_'.$employee_id);	
			$tax_withheld=$this->input->post('tax_withheld_'.$employee_id);	
			$total_taxable=$basic_salary+$taxable_tertinmonth+$taxable_other_salaries;

		if($save_me=="on"){

			$this->db->query("DELETE FROM alphalist_previous_employer WHERE employee_id='".$employee_id."' AND covered_year='".$prev_employer_covered_year."' ");

			if(($taxable_other_salaries<1)AND($total_taxable<1)){
				$remark="Deleted <small>(due to zero values)</small>";
			}else{
				$prev_emp_data = array(
					'employee_id'				=>	$employee_id,
					'nontax_tertinmonth'		=>	$nontax_tertinmonth,
					'nontax_deminimis'			=>	$nontax_deminimis,
					'gov_contri'				=>	$gov_contri,
					'nontax_other_salaries'		=>	$nontax_other_salaries,
					'total_non_taxable'			=>	$total_non_taxable,
					'basic_salary'				=>	$basic_salary,
					'taxable_tertinmonth'		=>	$taxable_tertinmonth,
					'taxable_other_salaries'	=>	$taxable_other_salaries,
					'total_taxable'				=>	$total_taxable,
					'tax_withheld'				=>	$tax_withheld,
					'gross_compen_inc'					=>	$gross_compen_inc,
					'holiday_pay'						=>	$holiday_pay,
					'overtime_pay'						=>	$overtime_pay,
					'shift_differential'				=>	$shift_differential,
					'hazard_pay'						=>	$hazard_pay,
					'basic_smw'						=>	$basic_smw,
					'covered_year'				=>	$prev_employer_covered_year
				);

				$this->reports_payroll_model->save_previous_employer($prev_emp_data);
				$remark="Saved";
			}




echo '
		<tr>			
			<td class="bg-success">'.$employee_id.'</td>
			<td class="bg-success">'.$employee_name.'</td>		
			<td class="bg-success">'.$prev_employer_covered_year.'</td>		

			<td class="bg-success">'.$basic_smw.'</td>		
			<td class="bg-success">'.$gross_compen_inc.'</td>		
			<td class="bg-success">'.$holiday_pay.'</td>		
			<td class="bg-success">'.$overtime_pay.'</td>		
			<td class="bg-success">'.$shift_differential.'</td>		
			<td class="bg-success">'.$hazard_pay.'</td>		

			<td class="bg-danger">'.$nontax_tertinmonth.'</td>
			<td class="bg-danger">'.$nontax_deminimis.'</td>
			<td class="bg-danger">'.$gov_contri.'</td>
			<td class="bg-danger">'.$nontax_other_salaries.'</td>
			<td class="bg-danger">'.$total_non_taxable.'</td>
			<td class="bg-warning">'.$basic_salary.'</td>
			<td class="bg-warning">'.$taxable_tertinmonth.'</td>
			<td class="bg-warning">'.$taxable_other_salaries.'</td>
			<td class="bg-warning">'.$total_taxable.'</td>
			<td class="bg-warning">'.$tax_withheld.'</td>
			<td class="bg-warning">'.$remark.'</td>
		</tr>
';
		}else{

		}


			// if(is_numeric($this->input->post('nontax_tertinmonth_'.$employee_id))){
			// 	echo "$nontax_tertinmonth $save_me<br>";
			// }else{

			// }
		}
		echo '

</tbody>
</table>
		';
	}

	public function working_schedule_filter()
	{
		$loc=$this->uri->segment('4');
		
		$this->data['payroll_period_year'] = $this->reports_payroll_model->payroll_period_year();

		$this->data['report'] = $this->reports_payroll_model->report_list();
		//$this->data['company'] = $this->reports_payroll_model->companyList();
		$this->data['employment'] = $this->general_model->employmentList();
		$this->data['location'] = $this->general_model->locationList();
		$this->data['year'] = $this->reports_payroll_model->year_date();
		$this->data['pay_type'] = $this->general_model->paytypeList();

		if($loc=="bank_file_bdo"){
			$this->data['bank_details']=$this->reports_payroll_model->getbankdetails($loc);
			$this->load->view('app/reports/payroll/bankfile/bank_file_bdo_index',$this->data);
		}elseif($loc=="bank_file_metrobank4"){
			$this->data['bank_details']=$this->reports_payroll_model->getbankdetails($loc);
			$this->load->view('app/reports/payroll/bankfile/bank_file_metrobank4_index',$this->data);
		}elseif($loc=="salary_information"){			
			$this->load->view('app/reports/payroll/salary_info_report/salaryinfo_index',$this->data);
		}elseif($loc=="sss_dat_file"){			
			$this->load->view('app/reports/payroll/sss_dat_file',$this->data);
		}else{
			$this->load->view('app/reports/payroll/working_schedule/working_schedule_filter',$this->data);
		}	


	}

	public function report_list()
	{
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['report'] = $this->reports_payroll_model->report_list();
		$this->load->view('app/reports/payroll/working_schedule/reports_list',$this->data);
	}

	public function company_onchange(){

		$this->load->view('app/reports/payroll/working_schedule/company_onchange',$this->data);
	}

	//view filtered report


	public function default_tax_monthly($company,$yy,$mm){

		$this->data['yy']=$yy;
		$this->data['mm']=$mm;
		$this->data['company']=$company;

		if($company=="All"){
			$this->data['round_off_payslip']="yes"; //default round it offs
			$this->data['payslip_decimal_place']=2;// default decimal place
		}else{
			$payslip_round=$this->reports_payroll_model->check_rounding_off($company);
			if(!empty($payslip_round)){
					$this->data['round_off_payslip']=$payslip_round->single_field;
			}else{
					$this->data['round_off_payslip']="yes"; //default round it offs
			}	

			$payslip_decimal=$this->reports_payroll_model->check_payslip_decimal($company);
			if(!empty($payslip_decimal)){
				$this->data['payslip_decimal_place']=$payslip_decimal->single_field;
			}else{
				$this->data['payslip_decimal_place']=2;// default decimal place
			}					
		}

		$this->data['default_tax_monthly']=$this->reports_payroll_model->gov_monthly_report($company,$yy,$mm);
		$this->load->view('app/reports/payroll/tax/tax_deduction',$this->data);

	}		
	public function default_pi_monthly($company,$yy,$mm){
		$this->data['yy']=$yy;
		$this->data['mm']=$mm;
		$this->data['company']=$company;

		if($company=="All"){
			$this->data['round_off_payslip']="yes"; //default round it offs
			$this->data['payslip_decimal_place']=2;// default decimal place
		}else{
			$payslip_round=$this->reports_payroll_model->check_rounding_off($company);
			if(!empty($payslip_round)){
					$this->data['round_off_payslip']=$payslip_round->single_field;
			}else{
					$this->data['round_off_payslip']="yes"; //default round it offs
			}	

			$payslip_decimal=$this->reports_payroll_model->check_payslip_decimal($company);
			if(!empty($payslip_decimal)){
				$this->data['payslip_decimal_place']=$payslip_decimal->single_field;
			}else{
				$this->data['payslip_decimal_place']=2;// default decimal place
			}
					
		}

		$this->data['default_pi_monthly']=$this->reports_payroll_model->gov_monthly_report($company,$yy,$mm);
		$this->load->view('app/reports/payroll/monthly_pagibig',$this->data);

	}	
	public function default_ph_monthly($company,$yy,$mm){
		$this->data['yy']=$yy;
		$this->data['mm']=$mm;
		$this->data['company']=$company;

		if($company=="All"){
			$this->data['round_off_payslip']="yes"; //default round it offs
			$this->data['payslip_decimal_place']=2;// default decimal place
		}else{
			$payslip_round=$this->reports_payroll_model->check_rounding_off($company);
			if(!empty($payslip_round)){
					$this->data['round_off_payslip']=$payslip_round->single_field;
			}else{
					$this->data['round_off_payslip']="yes"; //default round it offs
			}	

			$payslip_decimal=$this->reports_payroll_model->check_payslip_decimal($company);
			if(!empty($payslip_decimal)){
				$this->data['payslip_decimal_place']=$payslip_decimal->single_field;
			}else{
				$this->data['payslip_decimal_place']=2;// default decimal place
			}
					
		}

		$this->data['default_ph_monthly']=$this->reports_payroll_model->gov_monthly_report($company,$yy,$mm);
		$this->load->view('app/reports/payroll/monthly_philhealth',$this->data);

	}	
	public function default_sss_monthly($company,$yy,$mm){
		$this->data['yy']=$yy;
		$this->data['mm']=$mm;
		$this->data['company']=$company;
		if($company=="All"){
			$this->data['round_off_payslip']="yes"; //default round it offs
			$this->data['payslip_decimal_place']=2;// default decimal place
		}else{
			$payslip_round=$this->reports_payroll_model->check_rounding_off($company);
			if(!empty($payslip_round)){
					$this->data['round_off_payslip']=$payslip_round->single_field;
			}else{
					$this->data['round_off_payslip']="yes"; //default round it offs
			}	

			$payslip_decimal=$this->reports_payroll_model->check_payslip_decimal($company);
			if(!empty($payslip_decimal)){
				$this->data['payslip_decimal_place']=$payslip_decimal->single_field;
			}else{
				$this->data['payslip_decimal_place']=2;// default decimal place
			}
					
		}

		$this->data['default_sss_monthly']=$this->reports_payroll_model->gov_monthly_report($company,$yy,$mm);
		$this->load->view('app/reports/payroll/monthly_sss',$this->data);

	}


	public function working_schedule_view($report,$company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row,$bank_company_code,$bank_company_depository_code,$bank_effectivity_date,$bank_company_code_two,$loan_status)
	{

		// echo "i left coding here: <br>
		// report name: $report <br>
		// company : $company<br>
		// division: $division<br>
		// department: $department<br>
		// sect: $section<br>
		// sub sec: $subsection<br>
		// loc: $location<br>
		// class: $classification<br>
		// employment: $employment<br>
		// status: $status<br>
		// year: $yy<br>
		// month: $mm<br>
		// day: $dd<br>
		// report type: $type<br>
		// date from : $date_from<br>
		// date to: $date_to<br>
		// pay period: $payroll_period <br>
		// report area : $report_area<br>
		// covered month : $covered_month_from<br>
		// covered to : $covered_month_to <br>
		// covered year : $covered_year <br> <br>
		// payroll unique where : $payroll_unique <br> <br>

		// individual emp_id : $selected_individual_employee_id <br> <br>

		// for grouping report fiedls only <br>
		// groupings type : $groupings_type
		
		// <br>
		// for sss only
		// quarter : $quarter <br>
		// row per page : $page_row <br>

		// <br>
		// for bank file only <br>
		// bank_company_code : $bank_company_code <br>
		// bank_company_code TWO : $bank_company_code_two <br>
		// bank_company_depository_code : $bank_company_depository_code <br>
		// bank_effectivity_date : $bank_effectivity_date <br>
		// for loan only <br>
		// loan status : $loan_status <br>

		// <br>";

				if($report_area=="bank_file_metrobank1" OR $report_area=="bank_file_metrobank2" OR $report_area=="bank_file_metrobank3"){
					
				

					$this->data['ws_data'] = $this->reports_payroll_model->ws_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row,$bank_company_code,$bank_company_depository_code,$bank_effectivity_date,$bank_company_code_two,$loan_status);

		
					$this->data['report']= $report;
					$this->data['company']= $company;
					$this->data['division']= $division;
					$this->data['department']= $department;
					$this->data['section']= $section;
					$this->data['subsection']= $subsection;
					$this->data['location']= $location;
					$this->data['classification']= $classification;
					$this->data['employment']= $employment;
					$this->data['status']= $status;
					$this->data['yy']= $yy;
					$this->data['mm']= $mm;
					$this->data['dd']= $dd;
					$this->data['type']= $type;
					$this->data['date_from']= $date_from;
					$this->data['date_to']= $date_to;
					$this->data['payroll_period']= $payroll_period;
					$this->data['report_area']= $report_area;
					$this->data['covered_month_from']= $covered_month_from;
					$this->data['covered_month_to']= $covered_month_to;
					$this->data['covered_year']= $covered_year;
					$this->data['groupings_type']= $groupings_type;
					$this->data['payroll_unique']= $payroll_unique;
					$this->data['selected_individual_employee_id']= $selected_individual_employee_id;
					$this->data['quarter']= $quarter;
					$this->data['page_row']= $page_row;

					$this->data['bank_company_code']= $bank_company_code;
					$this->data['bank_company_code_two']= $bank_company_code_two;
					$this->data['bank_company_depository_code']= $bank_company_depository_code;
					$this->data['bank_effectivity_date']= $bank_effectivity_date;
					$this->data['loan_status']= $loan_status;


				}elseif($report_area=="pagibig_group_rep" OR $report_area=="sss_group_rep" OR $report_area=="ph_group_rep" OR $report_area=="tax_deduction"){ // default form
						$this->data['groupings_type']=$groupings_type;
						$this->data['division']=$division;
						$this->data['department']=$department;
						$this->data['section']=$section;
						$this->data['subsection']=$subsection;
						$this->data['location']="0";
						$this->data['classification']="0";
						$this->data['employment']="0";
						$this->data['status']=$status;
						$this->data['yy']=$yy;
						$this->data['mm']=$mm;
						$this->data['dd']=$dd;
						$this->data['type']=$type;
						$this->data['date_from']=$date_from;
						$this->data['date_to']=$date_to;
						$this->data['payroll_period']=$payroll_period;
						$this->data['report_area']=$report_area;
						$this->data['covered_month_from']=$covered_month_from;
						$this->data['covered_month_to']=$covered_month_to;
						$this->data['covered_year']=$covered_year;
						$this->data['payroll_unique']=$payroll_unique;
						$this->data['selected_individual_employee_id']=$selected_individual_employee_id;	
						$this->data['quarter']=$quarter;	
						$this->data['page_row']=$page_row;	
						
						$this->data['bank_company_code']=$bank_company_code;	
						$this->data['bank_company_depository_code']=$bank_company_depository_code;	
						$this->data['bank_effectivity_date']=$bank_effectivity_date;	
						$this->data['bank_company_code_two']=$bank_company_code_two;	
						$this->data['loan_status']=$loan_status;	


				}elseif($report_area=="pagibig_certificate" OR $report_area=="sss_certificate" OR $report_area=="ph_certificate"){// default form

					$this->data['selected_individual_employee_id']=$selected_individual_employee_id;

					if($selected_individual_employee_id=="0"){

						$this->data['group_cert']=1;
						$this->data['company']=$company;
						$this->data['groupings_type']=$groupings_type;
						$this->data['division']=$division;
						$this->data['department']=$department;
						$this->data['section']=$section;
						$this->data['subsection']=$subsection;
						$this->data['location']="0";
						$this->data['classification']="0";
						$this->data['employment']="0";
						$this->data['status']=$status;
						$this->data['yy']=$yy;
						$this->data['mm']=$mm;
						$this->data['dd']=$dd;
						$this->data['type']=$type;
						$this->data['date_from']=$date_from;
						$this->data['date_to']=$date_to;
						$this->data['payroll_period']=$payroll_period;
						$this->data['report_area']=$report_area;
						$this->data['covered_month_from']=$covered_month_from;
						$this->data['covered_month_to']=$covered_month_to;
						$this->data['covered_year']=$covered_year;
						$this->data['payroll_unique']=$payroll_unique;

						$this->data['bank_company_code']=$bank_company_code;
						$this->data['bank_company_code_two']=$bank_company_code_two;
						$this->data['bank_company_depository_code']=$bank_company_depository_code;
						$this->data['bank_effectivity_date']=$bank_effectivity_date;
						$this->data['loan_status']=$loan_status;

						$this->data['emp_list'] = $this->reports_payroll_model->check_emp_list($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row);

					}else{

						$this->data['group_cert']=0;
						$this->data["emp"]=$this->reports_payroll_model->check_emp_201($selected_individual_employee_id);

						$this->data['ws_data'] = $this->reports_payroll_model->ws_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row,$bank_company_code,$bank_company_depository_code,$bank_effectivity_date,$bank_company_code_two,$loan_status);

					}

				
				}elseif($report_area=="pagibig_mcrf"){// default form
					$company_id=$company;
					$this->data['cInfo']=$this->general_model->get_company_info($company_id);
					$payslip_decimal=$this->reports_payroll_model->check_payslip_decimal($company);
					if(!empty($payslip_decimal)){
						$this->data['payslip_decimal_place']=$payslip_decimal->single_field;
					}else{
						$this->data['payslip_decimal_place']=2;// default decimal place
					}
					$payslip_round=$this->reports_payroll_model->check_rounding_off($company);
					if(!empty($payslip_round)){
						$this->data['round_off_payslip']=$payslip_round->single_field;
					}else{
						$this->data['round_off_payslip']="yes"; //default round it offs
					}

					$this->data['ws_data'] = $this->reports_payroll_model->ws_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row,$bank_company_code,$bank_company_depository_code,$bank_effectivity_date,$bank_company_code_two,$loan_status);


				}elseif($report_area=="pagibig_mrrf"){// default form
					$company_id=$company;
					$this->data['the_covered_year']=$covered_year;
					$this->data['the_covered_months']=date('F', mktime(0, 0, 0, $covered_month_from, 10))." TO ".date('F', mktime(0, 0, 0, $covered_month_to, 10));
					$this->data['cInfo']=$this->general_model->get_company_info($company_id);
					$this->data['ws_data'] = $this->reports_payroll_model->ws_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row,$bank_company_code,$bank_company_depository_code,$bank_effectivity_date,$bank_company_code_two,$loan_status);


				}elseif($report_area=="sss_transmittal"){
					$company_id=$company;
					$this->data['cInfo']=$this->general_model->get_company_info($company_id);
					$payslip_decimal=$this->reports_payroll_model->check_payslip_decimal($company);
					if(!empty($payslip_decimal)){
						$this->data['payslip_decimal_place']=$payslip_decimal->single_field;
					}else{
						$this->data['payslip_decimal_place']=2;// default decimal place
					}
					$payslip_round=$this->reports_payroll_model->check_rounding_off($company);
					if(!empty($payslip_round)){
						$this->data['round_off_payslip']=$payslip_round->single_field;
					}else{
						$this->data['round_off_payslip']="yes"; //default round it offs
					}					

					if($covered_month_from==$covered_month_to){
						$this->data['the_covered_months']=date('F', mktime(0, 0, 0, $covered_month_from, 10));
					}else{
						$this->data['the_covered_months']=date('F', mktime(0, 0, 0, $covered_month_from, 10))." to ".date('F', mktime(0, 0, 0, $covered_month_to, 10));
					}
					
					$this->data['the_covered_year']=$covered_year;
					$this->data['cInfo']=$this->general_model->get_company_info($company_id);	

					$this->data['ws_data'] = $this->reports_payroll_model->ws_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row,$bank_company_code,$bank_company_depository_code,$bank_effectivity_date,$bank_company_code_two,$loan_status);

				}elseif($report_area=="sss_r3"){
					$company_id=$company;
					$this->data['cInfo']=$this->general_model->get_company_info($company_id);
					$payslip_decimal=$this->reports_payroll_model->check_payslip_decimal($company);
					if(!empty($payslip_decimal)){
						$this->data['payslip_decimal_place']=$payslip_decimal->single_field;
					}else{
						$this->data['payslip_decimal_place']=2;// default decimal place
					}
					$payslip_round=$this->reports_payroll_model->check_rounding_off($company);
					if(!empty($payslip_round)){
						$this->data['round_off_payslip']=$payslip_round->single_field;
					}else{
						$this->data['round_off_payslip']="yes"; //default round it offs
					}					


						$this->data['groupings_type']=$groupings_type;
						$this->data['division']=$division;
						$this->data['department']=$department;
						$this->data['section']=$section;
						$this->data['subsection']=$subsection;
						$this->data['location']="0";
						$this->data['classification']="0";
						$this->data['employment']="0";
						$this->data['status']=$status;
						$this->data['yy']=$yy;
						$this->data['mm']=$mm;
						$this->data['dd']=$dd;
						$this->data['type']=$type;
						$this->data['date_from']=$date_from;
						$this->data['date_to']=$date_to;
						$this->data['payroll_period']=$payroll_period;
						$this->data['report_area']=$report_area;
						$this->data['covered_month_from']=$covered_month_from;
						$this->data['covered_month_to']=$covered_month_to;
						$this->data['covered_year']=$covered_year;
						$this->data['payroll_unique']=$payroll_unique;
						$this->data['selected_individual_employee_id']=$selected_individual_employee_id;	

						$this->data['company']=$company;
						$this->data['page_row']=$page_row;
						$this->data['quarter']=$quarter;
						$this->data['emp_list'] = $this->reports_payroll_model->check_emp_list($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row);
				}elseif($report_area=="loan_report"){ 

				$this->data['ws_data'] = $this->reports_payroll_model->ws_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row,$bank_company_code,$bank_company_depository_code,$bank_effectivity_date,$bank_company_code_two,$loan_status);

				}elseif($report_area=="payslip_viewed"){
										
						$this->data['status']=$status;
						$this->data['yy']=$yy;
						$this->data['mm']=$mm;
						$this->data['dd']=$dd;
						$this->data['type']=$type;
						$this->data['date_from']=$date_from;
						$this->data['date_to']=$date_to;
						$this->data['payroll_period']=$payroll_period;
						$this->data['report_area']=$report_area;
						$this->data['covered_month_from']=$covered_month_from;
						$this->data['covered_month_to']=$covered_month_to;
						$this->data['covered_year']=$covered_year;
			

				$this->data['ws_data'] = $this->reports_payroll_model->ws_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row,$bank_company_code,$bank_company_depository_code,$bank_effectivity_date,$bank_company_code_two,$loan_status);					

				}else{ // crystal reports

				$this->data['report_fields'] = $this->reports_payroll_model->working_schedule_fields($report);
				$this->data['general_fields'] = $this->reports_payroll_model->working_schedule_general_fields($report,$report_area);
			
				$this->data['ws_data'] = $this->reports_payroll_model->ws_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row,$bank_company_code,$bank_company_depository_code,$bank_effectivity_date,$bank_company_code_two,$loan_status);

				}


		$this->data['report_fs_type']=$type;
		$this->data['report_area']=$report_area;

		if($report_area=="payroll_register"){

				if($type=="by_month" OR $type=="by_year" OR $type=="group_by_year" OR $type=="group_by_month"){
					
					$check_mc=$this->reports_payroll_model->payroll_period_myc($covered_month_from,$covered_month_to,$company,$covered_year,$type,$quarter);
					if(!empty($check_mc)){
							$check_pp_id=""; // check payroll period ID
						foreach($check_mc as $pp){
							$check_pp_id.="b.payroll_period_id='".$pp->id."' OR ";
						}
							$check_pp_id=substr($check_pp_id, 0, -3);  
					}else{
						$check_pp_id="b.payroll_period_id='0'"; // force no result value.
					}

				}elseif($type=="single_pp"){
						$check_pp_id="b.payroll_period_id='".$payroll_period."'";
				}else{
						$check_pp_id="";
				}

				$this->data['the_payrol_period']=$check_pp_id;
			/*
				---------------------------
				loans breakdown
				---------------------------
			*/			
				$this->data['loan_details']=$this->reports_payroll_model->loans_breakdown($company);
			/*
				---------------------------
				leave type(s) breakdown
				---------------------------
			*/
				$this->data['leave_details']=$this->reports_payroll_model->leave_breakdown($company);
			/*
				---------------------------
				other additions/deductions breakdown
				---------------------------
			*/
			$check_tax="1";
			$this->data['comp_oa_taxable']=$this->reports_payroll_model->comp_oa($company,$check_tax);
			$this->data['comp_od_taxable']=$this->reports_payroll_model->comp_od($company,$check_tax);
			// == ready.
			$comp_oa_taxable_count=$this->reports_payroll_model->comp_oa_count($company,$check_tax);
			if(!empty($comp_oa_taxable_count)){
				$this->data['tax_oa_numbers']=$comp_oa_taxable_count->oa_numbers;
			}else{
				$this->data['tax_oa_numbers']=0;
			}

			$check_tax="0";
			$this->data['comp_oa_nontax']=$this->reports_payroll_model->comp_oa($company,$check_tax);
			$this->data['comp_od_nontax']=$this->reports_payroll_model->comp_od($company,$check_tax);
			// == ready.
			$comp_oa_nontax_count=$this->reports_payroll_model->comp_oa_count($company,$check_tax);
			if(!empty($comp_oa_nontax_count)){
				$this->data['ntax_oa_numbers']=$comp_oa_nontax_count->oa_numbers;
			}else{
				$this->data['ntax_oa_numbers']=0;
			}

		}else{}


		if($report_area=="pagibig_group_rep"){
			$this->data["companyList"]=$this->general_model->companyList();
			$this->data["heyList"]=$this->general_model->companyList();
			$this->data["forGroupSec"]=$this->general_model->companyList();
			$this->data["div_companyList"]=$this->reports_payroll_model->div_base_company();
		 	$this->load->view('app/reports/payroll/working_schedule/pagbig_group_report_result',$this->data);
		}elseif($report_area=="sss_group_rep"){
		
			$this->data["companyList"]=$this->general_model->companyList();
			$this->data["heyList"]=$this->general_model->companyList();
			$this->data["forGroupSec"]=$this->general_model->companyList();
			$this->data["div_companyList"]=$this->reports_payroll_model->div_base_company();
		 	$this->load->view('app/reports/payroll/working_schedule/sss_group_report_result',$this->data);

		}elseif($report_area=="ph_group_rep"){
			$this->data["companyList"]=$this->general_model->companyList();
			$this->data["heyList"]=$this->general_model->companyList();
			$this->data["forGroupSec"]=$this->general_model->companyList();
			$this->data["div_companyList"]=$this->reports_payroll_model->div_base_company();
		 	$this->load->view('app/reports/payroll/working_schedule/philhealth_group_report_result',$this->data);

		}elseif($report_area=="tax_deduction"){
			$this->data["companyList"]=$this->general_model->companyList();
			$this->data["heyList"]=$this->general_model->companyList();
			$this->data["forGroupSec"]=$this->general_model->companyList();
			$this->data["div_companyList"]=$this->reports_payroll_model->div_base_company();
		 	$this->load->view('app/reports/payroll/working_schedule/tax_group_report_result',$this->data);

		}elseif($report_area=="pagibig_certificate" OR $report_area=="sss_certificate" OR $report_area=="ph_certificate"){

		 	$this->load->view('app/reports/payroll/gov_certificate',$this->data);

		}elseif($report_area=="pagibig_mcrf"){

		 	$this->load->view('app/reports/payroll/mcrf',$this->data);

		}elseif($report_area=="pagibig_mrrf"){

		 	$this->load->view('app/reports/payroll/mrrf',$this->data);
		 	
		}elseif($report_area=="sss_transmittal"){

		 	$this->load->view('app/reports/payroll/sss_transmittal',$this->data);

		}elseif($report_area=="sss_r3"){

		 	$this->load->view('app/reports/payroll/sss_r3',$this->data);

		}elseif($report_area=="bank_file_metrobank1" OR $report_area=="bank_file_metrobank2" OR $report_area=="bank_file_metrobank3"){

		 	$this->load->view('app/reports/payroll/bank_file',$this->data);

		}elseif($report_area=="loan_report"){

		 	$this->load->view('app/reports/payroll/sysdef_loan_report',$this->data);

		}elseif($report_area=="payslip_viewed"){

		 	
		 	$this->load->view('app/reports/payroll/payslip_viewed',$this->data);

		}else{
		 	$this->load->view('app/reports/payroll/working_schedule/view_filtered_reports',$this->data);	
		}
	}


	public function generate_sssDatFile(){
		$report_result_type=$this->input->post('report_result_type');
		$file_name="sss_contribution";

		header("Content-type: plain/text");
		header("Content-Disposition: attachment; filename=$file_name.$report_result_type");
		// header("Pragma: no-cache"); 	
		// header("Expires: 0");		

		$payroll_period_group_id=$this->input->post('payroll_period_group_id');
		$company_name=$this->input->post('company_name');
		$company_sss_number=$this->input->post('company_sss_number');
		$covered_year=$this->input->post('covered_year');
		$covered_month=$this->input->post('covered_month');
		$company_id=$this->input->post('company_id');

		$emp_data=$this->reports_payroll_model->generate_sssDatFile($payroll_period_group_id,$covered_year,$covered_month);

		$payslip_decimal=$this->reports_payroll_model->check_payslip_decimal($company_id);
		if(!empty($payslip_decimal)){
			$payslip_decimal_place=$payslip_decimal->single_field;
		}else{
			$payslip_decimal_place=2;// default decimal place
		}


$count_cn=strlen((string) $company_name);
$space_to_cn=31;
if($count_cn==31){$raw_add_space_to_cn="";}else{$raw_add_space_to_cn=31-$count_cn;}
$space_to_cn=str_repeat(' ', $raw_add_space_to_cn);


$cd=date('d');		
$cy=date('Y');		
$cm=date('Y');	
$cm = date('F', mktime(0, 0, 0, $cm, 10)); // March	
echo $company_name.$space_to_cn."[".$company_sss_number."]
Date: $cm $cd, $cy

FAMILY NAME     GIVEN NAME            MI  SS NUMBER       S.S    E.C   RMRK  DTHRD

";
		if(!empty($emp_data)){			
			foreach($emp_data as $e){
				$middle_name=substr($e->middle_name,0,1);
				$first_name=$e->first_name;
				$last_name=$e->last_name;
				$sss_number=$e->sss_number;
				$sss_ec_er=$e->sss_ec_er;
				$sss_contri=$e->sss_employee+$e->sss_employer;

				if($sss_contri>0){$sss_contri=number_format($sss_contri,$payslip_decimal_place);}else{}
				if($sss_ec_er>0){$sss_ec_er=number_format($sss_ec_er,$payslip_decimal_place);}else{}

				$sss_contri=str_replace(",","",$sss_contri);
				$sss_ec_er=str_replace(",","",$sss_ec_er);

				$count_ln=strlen((string) $last_name);
				if($count_ln==16){$raw_add_space_to_ln="";}else{$raw_add_space_to_ln=16-$count_ln;}
				$space_to_ln=str_repeat(' ', $raw_add_space_to_ln);

				$count_fn=strlen((string) $first_name);
				if($count_fn==22){$raw_add_space_to_fn="";}else{$raw_add_space_to_fn=22-$count_fn;} //16

				$count_scontri=strlen((string) $sss_contri);
				if($count_scontri==9){$raw_add_space_to_scontri="";}else{$raw_add_space_to_scontri=9-$count_scontri;} 

				$count_sss_ec_er=strlen((string) $sss_ec_er);
				if($count_sss_ec_er==8){$raw_add_space_to_ecer="";}else{$raw_add_space_to_ecer=8-$count_sss_ec_er;} 

				$count_sssno=strlen((string) $sss_number);
				if($count_sssno==15){$raw_add_space_to_sssno="";}else{$raw_add_space_to_sssno=15-$count_sssno;}

				if($raw_add_space_to_sssno>0){
				$space_to_sss_no=str_repeat(' ', $raw_add_space_to_sssno);
				}else{
				$space_to_sss_no="";
				}


				if($raw_add_space_to_fn>0){
				$space_to_fn=str_repeat(' ', $raw_add_space_to_fn);
				}else{
				$space_to_fn="";
				}

				if($raw_add_space_to_scontri>0){
				$space_to_scontri=str_repeat(' ', $raw_add_space_to_scontri);
				}else{
				$space_to_scontri="";
				}

				if($raw_add_space_to_ecer>0){
				$space_to_ecer=str_repeat(' ', $raw_add_space_to_ecer);
				}else{
				$space_to_ecer="";
				}


echo $last_name."".$space_to_ln."".$first_name."".$space_to_fn.$middle_name."   ".$sss_number.$space_to_sss_no.$sss_contri.$space_to_scontri.$space_to_ecer.$sss_ec_er."   N   0
";
			}
		}else{
		}




		

	}


	public function quick_click_generate($topic_location){
		$payroll_period_group_id=$this->input->post('payroll_period_group_id');
		$report=$this->input->post('report');
		$report_result_type=$this->input->post('report_result_type');
		$pay_period_raw=$this->input->post('pay_period');
		$this->data['report_fs_type']="single_pp";

		list($pay_period,$month_cover) = explode("*",$pay_period_raw);	
		$month_cover = sprintf("%02d", $month_cover);
		$this->data['report_area']=$topic_location;
		$this->data['report_result_type']=$report_result_type;

		if($topic_location=="payroll_register"){
			$dbtable="payslip_".$month_cover;
			$this->data['report_title']="Payroll Register";
		$this->data['report_fields'] = $this->reports_payroll_model->working_schedule_fields($report);
		$this->data['general_fields'] = $this->reports_payroll_model->working_schedule_general_fields($report,$topic_location);
				
			$this->data['ws_data']=$this->reports_payroll_model->quick_click_generate($dbtable,$pay_period);
			$company=1;
			/*
				---------------------------
				loans breakdown
				---------------------------
			*/			
				$this->data['loan_details']=$this->reports_payroll_model->loans_breakdown($company);
			/*
				---------------------------
				leave type(s) breakdown
				---------------------------
			*/
				$this->data['leave_details']=$this->reports_payroll_model->leave_breakdown($company);
			/*
				---------------------------
				other additions/deductions breakdown
				---------------------------
			*/
			$check_tax="1";
			$this->data['comp_oa_taxable']=$this->reports_payroll_model->comp_oa($company,$check_tax);
			$this->data['comp_od_taxable']=$this->reports_payroll_model->comp_od($company,$check_tax);
			// == ready.
			$comp_oa_taxable_count=$this->reports_payroll_model->comp_oa_count($company,$check_tax);
			if(!empty($comp_oa_taxable_count)){
				$this->data['tax_oa_numbers']=$comp_oa_taxable_count->oa_numbers;
			}else{
				$this->data['tax_oa_numbers']=0;
			}

			$check_tax="0";
			$this->data['comp_oa_nontax']=$this->reports_payroll_model->comp_oa($company,$check_tax);
			$this->data['comp_od_nontax']=$this->reports_payroll_model->comp_od($company,$check_tax);
			// == ready.
			$comp_oa_nontax_count=$this->reports_payroll_model->comp_oa_count($company,$check_tax);
			if(!empty($comp_oa_nontax_count)){
				$this->data['ntax_oa_numbers']=$comp_oa_nontax_count->oa_numbers;
			}else{
				$this->data['ntax_oa_numbers']=0;
			}









		}else{

		}

		//$this->load->view('app/reports/payroll/working_schedule/view_filtered_reports',$this->data);	
		$this->load->view('app/reports/payroll/quick_generate/quick_click_generate_payroll',$this->data);	

	}


	public function generate_sss_r1($report,$company){
		$company_id=$company;
		$this->data['cInfo']=$this->general_model->get_company_info($company_id);
		$this->data['for_r1']=$this->reports_payroll_model->get_for_r1_emp($company);
		$this->load->view('app/reports/payroll/sss_r1',$this->data);
	}

	public function extract_salary_info($company_id,$sal_type,$effectivity_date){
		//
		if($company_id=="All"){
			if($sal_type=="with_salary"){//all company with salary setup
				$sal_rep_typ="1";
			}else{// all company without salary
				$sal_rep_typ="2";
			}			
		}else{
			if($sal_type=="with_salary"){//specific company with salary setup
				$sal_rep_typ="3";
			}else{// specific company without salary
				$sal_rep_typ="4";
			}			
		}

	$this->data['sal_rep_typ']=$sal_rep_typ;
	$this->data['emp_sal']=$this->reports_payroll_model->extract_salary_info($company_id,$sal_type,$effectivity_date,$sal_rep_typ);
	$this->load->view('app/reports/payroll/salary_info_report/generate_salary',$this->data);
	}

	public function easy_extract_bank_file_metrobank4(){//bank_file_metrobank4
		$bank_table_bank_id=$this->input->post('bank_table_bank_id');
		$datfile_location=$this->input->post('datfile_location');//if bdo etc..
		
		$file_type=$this->input->post('file_type');
		$company_id=$this->input->post('company_id');
		$fixed_value_1=$this->input->post('fixed_value_1');
		$depository_branch_code=$this->input->post('depository_branch_code');
		$bank_code=$this->input->post('bank_code');
		$currency_code=$this->input->post('currency_code');
		$payroll_accounts_branch_code=$this->input->post('payroll_accounts_branch_code');
		$fixed_value_zeros=$this->input->post('fixed_value_zeros');
		//company name will base on the company selected.
		$fixed_value_2=$this->input->post('fixed_value_2');
		$company_code=$this->input->post('company_code');
		$company_name_ref=$this->input->post('company_name_ref');
		$effectivity_date=$this->input->post('effectivity_date');
		$space_after_comp_name=$this->input->post('space_after_comp_name');

		$metrobank_4_data= array(
			'fixed_value_1'		=>	$fixed_value_1,
			'depository_branch_code'		=>		$depository_branch_code,
			'currency_code'		=>		$currency_code,
			'payroll_accounts_branch_code'		=>		$payroll_accounts_branch_code,
			'fixed_value_zeros'		=>		$fixed_value_zeros,
			'fixed_value_2'		=>		$fixed_value_2,
			'company_name_ref'		=>		$company_name_ref,
			'space_after_comp_name'		=>		$space_after_comp_name,
			'bank_code'		=>		$bank_code,
			'bank_company_code'		=>		$company_code
		);
		$bank_id=$bank_table_bank_id;
		$this->reports_payroll_model->save_metrobank_4_data($metrobank_4_data,$bank_id);

		$payroll_period_group_id=$this->input->post('payroll_period_group_id');
		$cut_off=$this->input->post('cut_off');
		$raw_pp=$this->input->post('payperiod_id');

		if($payroll_period_group_id=="All"){
			$all_company_group_pp="";
			list($year_cover,$month_cover) = explode("*",$raw_pp);	
			$allpp=$this->reports_payroll_model->get_year_month_pp($company_id,$year_cover,$month_cover,$cut_off);	
			if(!empty($allpp)){
				foreach($allpp as $p){
					$all_company_group_pp.="b.payroll_period_id='".$p->id."' OR ";				
				}
		
				$all_company_group_pp=substr($all_company_group_pp, 0,-3);
				$all_company_group_pp="AND ($all_company_group_pp)";		

			}else{
			}
		}else{
			$all_company_group_pp="";
			list($payperiod_id,$month_cover) = explode("*",$raw_pp);			
		}



		if($company_name_ref=="company_name"){//get company name
			$comp_info=$this->general_model->get_company_info($company_id);
			if(!empty($comp_info)){
				$company_name=$comp_info->company_name;
			}else{
				$company_name="Company Name Not Found";
			}
		}elseif($company_name_ref=="pp_group_name"){
			$comp_info=$this->reports_payroll_model->get_pp_group_details($payroll_period_group_id);
			if(!empty($comp_info)){
				$company_name=$comp_info->group_name;
			}else{
				if($payroll_period_group_id=="All"){
					$company_name="check_individual";
				}else{
					$company_name="Group Name Not Found";
				}
				
			}			
		}else{

		}

		$company_name=strtoupper($company_name);
		$space=str_repeat(' ', $space_after_comp_name);
		
		// echo "
		// company_id : $company_id<br>
		// fixed_value_1 : $fixed_value_1<br>
		// depository_branch_code : $depository_branch_code<br>
		// bank_code : $bank_code<br>
		// currency_code : $currency_code<br>
		// payroll_accounts_branch_code : $payroll_accounts_branch_code<br>
		// fixed_value_zeros : $fixed_value_zeros<br>
		// fixed_value_2 : $fixed_value_2<br>
		// company_code : $company_code<br>
		// effectivity_date : $effectivity_date<br>
		// ";
		$c_month=substr($effectivity_date, 5, 2);
		$c_day=substr($effectivity_date, 8, 2);
		$c_year=substr($effectivity_date, 0, -6);
		//$c_year=substr($c_year, 2, 2);	// last 2 digit of year only	

		
		if($file_type=="text_file"){
			$extension="text";
		}elseif($file_type=="excel"){
			$extension="xls";
		}else{
			$extension="dat";//dat
		}


		if($payroll_period_group_id=="All"){
		$emp=$this->reports_payroll_model->extract_all_group_netpay($company_id,$bank_table_bank_id,$payroll_period_group_id,$all_company_group_pp,$month_cover);	
		$details="File Type:$file_type|company_id:$company_id|fixed_value_1 : $fixed_value_1|depository_branch_code : $depository_branch_code|bank_code : $bank_code|currency_code : $currency_code|payroll_accounts_branch_code : $payroll_accounts_branch_code|fixed_value_zeros : $fixed_value_zeros|fixed_value_2 : $fixed_value_2|company_code : $company_code|effectivity_date : $effectivity_date|payroll_period_group_id:$payroll_period_group_id|year_cover:$year_cover|month_cover:$month_cover|cut_off:$cut_off|base from selected year&month:$all_company_group_pp";
		}else{
		$emp=$this->reports_payroll_model->easy_extract_bank_file($company_id,$bank_table_bank_id,$payroll_period_group_id,$payperiod_id,$month_cover);			
		$details="File Type:$file_type|company_id:$company_id|fixed_value_1 : $fixed_value_1|depository_branch_code : $depository_branch_code|bank_code : $bank_code|currency_code : $currency_code|payroll_accounts_branch_code : $payroll_accounts_branch_code|fixed_value_zeros : $fixed_value_zeros|fixed_value_2 : $fixed_value_2|company_code : $company_code|effectivity_date : $effectivity_date|payroll_period_group_id:$payroll_period_group_id|payperiod_id:$payperiod_id";

		}

		General::logfile('Payroll Bank File','DOWNLOAD',$details);

		$file_name = "PAYROLL";	

		if($file_type=="excel"){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file_name.$extension");
		header("Pragma: no-cache"); 	
		header("Expires: 0");

echo '
<table>
<thead>
	<tr>
		<th>Fixed Value 1</th>
		<th>Depositiory Branch Code</th>
		<th>Bank Code</th>
		<th>Currency Code</th>
		<th>Payroll Accounts Code</th>
		<th>Fixed Value Zeros</th>
		<th>Company Name Reference</th>
		<th>Space Count</th>
		<th>Account Number</th>
		<th>Zeros Before Netpay</th>
		<th>Net Pay</th>
		<th>Fixed Value 2</th>
		<th>Company Code</th>
		<th>Effectivity Month</th>
		<th>Effectivity Day</th>
		<th>Effectivity Year</th>
	</tr>
</thead>
<tbody>
';		
		if(!empty($emp)){
			$count_employees=0;
			$total_netpay=0;
			foreach($emp as $e){
				$count_employees++;
				$net_pay=$e->net_pay;
				$total_netpay+=$net_pay;
				$net_pay=str_replace(".","",$net_pay);
if(($company_name_ref=="pp_group_name")AND($payroll_period_group_id=="All")){
	$grup_name=$this->reports_payroll_model->get_pp_group_name($e->payroll_period_id);
	if(!empty($grup_name)){
		$company_name=$grup_name->group_name;
	}else{
		$company_name="Group Name Not Found";
	}
}else{

}

$count=strlen((string) $net_pay);
if($count==15){
	$raw_add_zero_to_netpay="";
}else{
	$raw_add_zero_to_netpay=15-$count;
}
$zero_to_netpay=str_repeat('0', $raw_add_zero_to_netpay);

echo '
<tr>
	<td>'.$fixed_value_1.'</td>
	<td>'.$depository_branch_code.'</td>
	<td>'.$bank_code.'</td>
	<td>'.$currency_code.'</td>
	<td>'.$payroll_accounts_branch_code.'</td>
	<td>'.$fixed_value_zeros.'</td>
	<td>'.$company_name.'</td>
	<td>'.$space_after_comp_name.'</td>
	<td>'.$e->account_no.'</td>
	<td>'.$zero_to_netpay.'</td>
	<td>'.$e->net_pay.'</td>
	<td>'.$fixed_value_2.'</td>
	<td>'.$company_code.'</td>
	<td>'.$c_month.'</td>
	<td>'.$c_day.'</td>
	<td>'.$c_year.'</td>
</tr>
';
// echo $fixed_value_1.$depository_branch_code.$bank_code.$currency_code.$payroll_accounts_branch_code.$fixed_value_zeros.$company_name.$space.$e->account_no.$zero_to_netpay.$net_pay.$fixed_value_2.$company_code.$c_month.$c_day.$c_year."
// ";


			}
			//========start total at the bottom
			$total_netpay=str_replace(".", "", $total_netpay);//remove 'dot'
			$total_netpay_digit=strlen((string) $total_netpay);
			if($total_netpay_digit==15){
				$raw_add_zero_to_total_netpay="";
			}else{
				$raw_add_zero_to_total_netpay=15-$total_netpay_digit;
			}
			$zero_to_total_netpay=str_repeat('0', $raw_add_zero_to_total_netpay);
			echo '<tr><td>'.$count_employees.$zero_to_total_netpay.$total_netpay.'</td></tr>';
			//end total at the bottom

		}else{//empty employees
		}

echo '
</tbody>
</table>
';


		}else{
		header("Content-type: plain/text");
		header("Content-Disposition: attachment; filename=$file_name.$extension");
		header("Pragma: no-cache"); 	
		header("Expires: 0");			
	
		if(!empty($emp)){
			$count_employees=0;
			$total_netpay=0;			
			foreach($emp as $e){
				$count_employees++;
				$net_pay=$e->net_pay;
				$total_netpay+=$net_pay;
				$net_pay=str_replace(".","",$net_pay);
if(($company_name_ref=="pp_group_name")AND($payroll_period_group_id=="All")){
	$grup_name=$this->reports_payroll_model->get_pp_group_name($e->payroll_period_id);
	if(!empty($grup_name)){
		$company_name=$grup_name->group_name;
	}else{
		$company_name="Group Name Not Found";
	}
	
}else{
}

$count=strlen((string) $net_pay);
if($count==15){
	$raw_add_zero_to_netpay="";
}else{
	$raw_add_zero_to_netpay=15-$count;
}
$zero_to_netpay=str_repeat('0', $raw_add_zero_to_netpay);


echo $fixed_value_1.$depository_branch_code.$bank_code.$currency_code.$payroll_accounts_branch_code.$fixed_value_zeros.$company_name.$space.$e->account_no.$zero_to_netpay.$net_pay.$fixed_value_2.$company_code.$c_month.$c_day.$c_year."
";


			}

			//========start total at the bottom
			$total_netpay=str_replace(".", "", $total_netpay);//remove 'dot'
			$total_netpay_digit=strlen((string) $total_netpay);
			if($total_netpay_digit==15){
				$raw_add_zero_to_total_netpay="";
			}else{
				$raw_add_zero_to_total_netpay=15-$total_netpay_digit;
			}
			$zero_to_total_netpay=str_repeat('0', $raw_add_zero_to_total_netpay);

			$total_emp_digit=strlen((string) $count_employees);
			if($total_emp_digit==6){
				$raw_add_zero_to_total_emp="";
			}else{
				$raw_add_zero_to_total_emp=6-$total_emp_digit;
			}
			$zero_to_count_employees=str_repeat('0', $raw_add_zero_to_total_emp);

			echo $zero_to_count_employees.$count_employees.$zero_to_total_netpay.$total_netpay;
			//end total at the bottom

		}else{//empty employees
		}


	}//end if text/file or dat file



	}

	public function easy_extract_bank_file(){//bank_file_bdo
		$bank_table_bank_id=$this->input->post('bank_table_bank_id');
		$datfile_location=$this->input->post('datfile_location');//if bdo etc..
		
		$file_type=$this->input->post('file_type');
		$company_id=$this->input->post('company_id');
		$payroll_period_group_id=$this->input->post('payroll_period_group_id');
		$raw_pp=$this->input->post('payperiod_id');
		list($payperiod_id,$month_cover) = explode("*",$raw_pp);

		$bank_company_code=$this->input->post('bank_company_code');
		$bank_batch_number=$this->input->post('bank_batch_number');
		$credit_date=$this->input->post('credit_date');

		$c_month=substr($credit_date, 5, 2);
		$c_day=substr($credit_date, 8, 2);
		$c_year=substr($credit_date, 0, -6);
		$c_year=substr($c_year, 2, 2);	// last 2 digit of year only	


		if($file_type=="text_file"){
			$extension="text";
		}else{
			$extension="dat";
		}

		$emp=$this->reports_payroll_model->easy_extract_bank_file($company_id,$bank_table_bank_id,$payroll_period_group_id,$payperiod_id,$month_cover);
		if(!empty($emp)){
			foreach($emp as $e){
				$net_pay=$e->net_pay;
				echo $e->account_no."    $net_pay
";
			}
		}else{

		}

		$file_name = $bank_company_code.$c_month.$c_day.$c_year.$bank_batch_number;	
		header("Content-type: plain/text");
		header("Content-Disposition: attachment; filename=$file_name.$extension");
		header("Pragma: no-cache"); 	
		header("Expires: 0");

		if($datfile_location=="bank_file_bdo"){
			/*reference: ibarra */
		}else{
		}



	}

	public function extract_bank_file($report,$company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row,$bank_company_code,$bank_company_depository_code,$bank_effectivity_date,$bank_company_code_two){


		if($report=="metrobank_text"){
			$extension="text";
		}else{
			$extension="dat";
		}

		$file_name = "Payroll";	
		header("Content-type: plain/text");
		header("Content-Disposition: attachment; filename=$file_name.$extension");
		header("Pragma: no-cache"); 	
		header("Expires: 0");

					$ya= $this->reports_payroll_model->ws_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row,$bank_company_code,$bank_company_depository_code,$bank_effectivity_date,$bank_company_code_two,$loan_status);
					$total_net_pay=0;
					$employee_count=0;
		foreach($ya as $a){
			$total_net_pay+=$a->net_pay;
			$employee_count++;
			$clean_netpay=str_replace(".","",$a->net_pay);
			$clean_company_name=strtoupper($a->company_name);
			$account_no=$a->account_no;
			$an_first_four=substr($account_no, 0,4);//an : account number ( account number first four digit)
			if($an_first_four=="3020"){
				$spec_cc=$bank_company_code; // specific company code
			}else{//3168
				$spec_cc=$bank_company_code_two; // specific company code
			}
$yy=substr($bank_effectivity_date, 0,4);
$mm=substr($bank_effectivity_date, 5,2);
$dd=substr($bank_effectivity_date, 8,2);

if($report_area=="bank_file_metrobank3"){	
echo $spec_cc.$clean_company_name.'                        '.$account_no.'000000000'.$clean_netpay.'
';		
}elseif($report_area=="bank_file_metrobank1" OR $report_area=="bank_file_metrobank2"){
echo $bank_company_code.$clean_company_name.'                        '.$account_no.'000000000'.$clean_netpay.$bank_company_depository_code.$mm.$dd.$yy.'
';		
}else{}			
		
		}
		$clean_total_net_pay=str_replace(".","",$total_net_pay);
if($report_area=="bank_file_metrobank1"){
echo '000'.$employee_count.'0000000'.$clean_total_net_pay;
}elseif($report_area=="bank_file_metrobank2"){	
}else{
}






	}

	//delete report
	public function deleteReport($report_id,$report_type)
	{

		$delete = $this->reports_payroll_model->delete_report($report_id);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Reports','Time>Crystal Report','logfile_reports_time','delete report id : '.$report_id.'','DELETE',$report_type);	

		$this->session->set_flashdata('onload',"report_list('".$report_type."')");
		redirect(base_url().'app/reports_payroll/index',$this->data);

	}

	//view details
	public function updateReport($report_type,$val)
	{
		$this->data['report_id']=$val;
		
		$this->data['crystal_report'] = $this->reports_payroll_model->crystal_report_payroll();
		$this->data['details_report_fields'] = $this->reports_payroll_model->details_report_fields($val);
		$this->data['details_report'] = $this->reports_payroll_model->details_report($val);
		$this->load->view('app/reports/payroll/update_reports',$this->data);
	}
	//update report

	public function update_report_save() // new update function 
	{
		$report_type=$this->uri->segment('4');
		$report_name=$this->input->post('report_name');
		$report_desc=$this->input->post('report_desc');
		$report_id=$this->input->post('report_id');

		$report_name=urldecode($report_name);
		$check_report_name=$this->reports_payroll_model->validate_edit_report_name($report_name,$report_type,$report_id);
		if(!empty($check_report_name)){	// already exist
			// dont rename report.
			//$this->data['message']="<div class='alert alert-danger alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Report Name <strong>".$report_name."</strong> Already Exist!</div>";
		}else{
			$this->db->query("update reports set report_name='".$report_name."',report_desc='".$report_desc."' where report_id = ".$report_id);

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Reports','Time>Crystal Report','logfile_reports_time','update report name(via update fields) : '.$report_name.'','UPDATE',$report_type);

		}

		$this->db->query("delete from report_fields where report_id = ".$report_id);

		foreach ($this->input->post('rpt_fields') as $key => $value)
		{
			$this->data = array(
				'report_id'	=>		$report_id,
				'report_time_id'	=>		$value
			);
			$this->db->insert("report_fields",$this->data);

			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/
			General::system_audit_trail('Reports','Time>Crystal Report','logfile_reports_time','update fields of report id : '.$report_id.' with field('.$value.')'.'','UPDATE',$report_type);

		}

		$this->session->set_flashdata('onload',"report_list('".$report_type."')");
		redirect(base_url().'app/reports_payroll/index',$this->data);
	}

	public function save_update_report($fields,$report_name,$report_desc,$report_id)
	{
		$update = $this->reports_payroll_model->save_update_report($fields,$report_name,$report_desc,$report_id);
		$this->data['report'] = $this->reports_payroll_model->report_list();
		$this->load->view('app/reports/payroll/working_schedule/reports_list',$this->data);
	}

	//view report

	//view details
	public function viewReport($report_type,$val)
	{
		$this->data['report_id']=$val;
		$this->data['crystal_report'] = $this->reports_payroll_model->crystal_report_payroll();
		$this->data['details_report_fields'] = $this->reports_payroll_model->details_report_fields($val);
		$this->data['details_report'] = $this->reports_payroll_model->details_report($val);
		$this->load->view('app/reports/payroll/details_reports',$this->data);
	}

	//department list based on company id
	public function result_onchange($option,$value,$third_val,$type,$topic_location)
	{  
		$this->data['pay_type'] = $this->general_model->paytypeList();
		$this->data['payroll_period_year'] = $this->reports_payroll_model->payroll_period_year();

		if($option=='division')
		{ 


		$this->data["comp_class"]=$this->general_model->get_company_classifications($value);
		$this->data["comp_loc"]=$this->general_model->get_company_locations($value);			
		$this->data['results'] = $this->reports_payroll_model->onchange_value($option,$value); }

		else if($option=='department')
		{ 
			if($third_val=="All"){
			// department is dependent to company
				$this->data['results'] = $this->reports_payroll_model->onchange_value($option,$value);
			}else{
				$check_div=$this->general_model->get_company_info($value);
				// department is dependent to division
				if($check_div->wDivision=="1"){ 
					$this->data['results'] = $this->reports_payroll_model->check_dept($third_val);
				}else{ 
				// department is dependent to company
					$this->data['results'] = $this->reports_payroll_model->onchange_value($option,$value);
				}

			}


		}

		else if($option=='section')
		{ 
			if($value=="All"){
				$this->data["show_all_only_section"]="yes";
			}else{
				$this->data["show_all_only_section"]="no";
			}
			$this->data['results'] = $this->reports_payroll_model->onchange_value($option,$value); }

		else if($option=='subsection')
		{ 

			if($value=="All"){
				$this->data["show_all_only_subsection"]="yes";
			}else{
				$this->data["show_all_only_subsection"]="no";
			}
			
			$this->data['results'] = $this->reports_payroll_model->onchange_value($option,$value); }

		else if($option=='classification')
		{ $this->data['results'] = $this->reports_payroll_model->onchange_value($option,$value); }

		else if($option=='location')
		{ $this->data['results'] = $this->reports_payroll_model->onchange_value($option,$value); }
		
		$this->data['topic_location']=$topic_location;
		$this->data['option']=$option;


		$this->data['oa_lists']=$this->reports_payroll_model->get_oa($value);

		$this->data['od_lists']=$this->reports_payroll_model->get_od($value);

		if($topic_location=="loan_report"){
			$this->data['loan_lists']=$this->reports_payroll_model->get_loans($value);
		}else{}
		


		
		$this->load->view('app/reports/payroll/results',$this->data);
	}




	public function showSearchEmployee($val = NULL){

		
		$topic_location = $this->uri->segment("5");
		$this->data['showEmployeeList'] = $this->reports_payroll_model->getSearch_Employee($val); //getEmp //getSearch_Employee
		$this->data['topic_location'] =$topic_location;
		$this->load->view("app/reports/payroll/showEmployeeList",$this->data);	
	}

	public function select_emp($val = NULL){	
		$selected_emp=$this->uri->segment('4');
		$the_type=$this->uri->segment('5');
		$topic_location=$this->uri->segment('6');
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');	

		$this->data['emp'] = $this->reports_payroll_model->get_selected_emp($selected_emp);
		$emp = $this->reports_payroll_model->get_selected_emp($selected_emp);

		if($topic_location=="loan_report"){
			$this->data['loan_lists']=$this->reports_payroll_model->get_loans_spec_employee($emp->company_id,$emp->employee_id);
		}else{}
		

		$this->data['to_check_pp']= $this->reports_payroll_model->comp_emp_pp($selected_emp,$emp->payroll_period_group_id);
		
		$this->data['topic_location'] =$topic_location;
		$this->data['the_type'] =$the_type;
		$this->data['payroll_period_year'] = $this->reports_payroll_model->payroll_period_year();	

		$this->load->view('app/reports/payroll/show_employee',$this->data);
	}

	public function show_class_loc($val){

		$this->data["comp_class"]=$this->general_model->get_company_classifications($val);
		$this->data["comp_loc"]=$this->general_model->get_company_locations($val);
		$this->load->view('app/reports/payroll/show_class_loc',$this->data);
	}

	public function result_onchange_2($option,$value,$company_id)
	{
		if($option=='group')
		{ $this->data['results'] = $this->reports_payroll_model->onchange_value_2($option,$value,$company_id); 
		  $this->data['option']=$option;
		  $this->load->view('app/reports/payroll/results',$this->data);
		}
		else{
			$payroll_period_result= $this->reports_payroll_model->onchange_value_2($option,$value,$company_id); 
			if(empty($payroll_period_result))
				{ echo "<option value='no_value'>No Payroll Period</option>
						<option value='not_included'>Not included</option>"; }
			else{
				echo "<option value='no_value'  selected>Select Payroll Period</option> 
						<option value='not_included'>Not included</option>"; 

				foreach ($payroll_period_result as $row) {
					$payroll_period_from = $row->month_from."-".$row->day_from."-".$row->year_from;
					$payroll_period_to = $row->month_to."-".$row->day_to."-".$row->year_to;
					$date_payroll = $payroll_period_from." to ".$payroll_period_to;

					echo "<option value='".$row->id."'>".$date_payroll."</option>";
				}
			}

		}
	}

	public function working_schedule_filter_pp()
	{
		$this->data['report'] = $this->reports_payroll_model->report_list();
		$this->data['company'] = $this->reports_payroll_model->companyList();
		$this->data['employment'] = $this->general_model->employmentList();
		$this->data['location'] = $this->general_model->locationList();
		$this->data['year'] = $this->reports_payroll_model->year_date();
		$this->data['pay_type'] = $this->general_model->paytypeList();
		$this->load->view('app/reports/payroll/working_schedule/working_schedule_filter_pp',$this->data);
	}

	//view filtered report
	//view filtered report
	// public function working_schedule_view_pp($report,$company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$payroll_period)
	// {




	// 	$this->data['report_fields'] = $this->reports_payroll_model->working_schedule_fields($report);
	// 	$this->data['ws_data'] = $this->reports_payroll_model->ws_filter_data_pp($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$payroll_period);
	// 	$this->data['distinct'] = $this->reports_payroll_model->ws_filter_data_distinct($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$payroll_period);
	// 	$this->data['payroll_period']=$payroll_period;
	// 	$payroll= $this->reports_payroll_model->payroll_data($payroll_period);
 //           	foreach ($payroll as $row) {
 //                      $this->data['from_date'] = $row->month_from."/".$row->day_from."/".$row->year_from;
 //                      $this->data['to_date'] = $row->month_to."/".$row->day_to."/".$row->year_to;
 //                      $this->data['payroll_period_group'] = $row->payroll_period_group_id;
 //                  }
	// 	$this->load->view('app/reports/payroll/working_schedule/view_filtered_reports_pp',$this->data);
	// }
}	
