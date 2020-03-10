<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class reports_payroll_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}

	public function comp_group($val){

		$query = $this->db->query("SELECT * FROM payroll_period_group WHERE company_id='".$val."' ");
		return $query->result();
	}

	public function compGroupPayPeriod($val){

		$query = $this->db->query("SELECT * FROM payroll_period WHERE payroll_period_group_id='".$val."' ORDER BY complete_to DESC");
		return $query->result();
	}

	public function gov_monthly_report($company,$yy,$mm){
		if($company=="All"){
			$where_clause="";
		}else{
			$where_clause="WHERE company_id='".$company."'";
		}
		//echo "SELECT employee_id,last_name,first_name,sss,philhealth as sss_number FROM employee_info $where_clause ";

		$query = $this->db->query("SELECT tin as tina,pagibig as pagibig_number,company_id,employee_id,last_name,first_name,sss as sss_number,philhealth as philhealth_number FROM employee_info $where_clause ");
		return $query->result();
	}
	public function gov_monthly_report_data($employee_id,$yy,$mm){
		$table="payslip_".$mm;
		$str = ltrim($mm, '0');

		$query = $this->db->query("SELECT sum(c.wtax) as wtax,sum(c.pagibig_employer) as pagibig_employer,sum(c.pagibig) as pagibig,sum(c.philhealth_employer) as philhealth_employer,sum(c.philhealth_employee) as philhealth_employee,sum(c.sss_employee) as sss_employee,sum(c.sss_employer) as sss_employer,sum(c.sss_ec_er) as sss_ec_er FROM payroll_period b inner join $table c on(b.id=c.payroll_period_id) where b.month_cover='".$str."' AND employee_id='".$employee_id."'; ");

		return $query->row();
	}

	public function getbankdetails($loc){
		$query = $this->db->query("SELECT a.bank_table_bank_id,b.bank_company_code,b.bank_batch_number FROM bank_file a LEFT JOIN bank b on(a.bank_table_bank_id=b.bank_id) WHERE a.default_value='".$loc."' ");
		return $query->row();		
	}
	public function easy_extract_bank_file($company_id,$bank_table_bank_id,$payroll_period_group_id,$payperiod_id,$month_cover){

		$month_cover = sprintf("%02d", $month_cover);
		$payslip_table="payslip_".$month_cover;

			$query = $this->db->query("SELECT a.name_lname_first,a.account_no,b.net_pay FROM masterlist a 
				INNER JOIN $payslip_table b on(a.employee_id=b.employee_id)
				WHERE a.company_id='".$company_id."' and a.bank_id='".$bank_table_bank_id."' AND a.account_no!='' AND b.payroll_period_id='".$payperiod_id."' ");
		return $query->result();		

	}

	public function getBankFile(){
		$this->db->select('*');

		$this->db->from('bank_file');
		$query = $this->db->get();
		return $query->result();		
	}

	public function crystal_report_payroll()
	{
		$report_type=$this->uri->segment("4");
		$this->db->select('*');
		$this->db->from('crystal_report_payroll');
		$this->db->where(array(
			'modules'=>'payroll'
			));

		if($report_type=="by_group_time_summary"){
			$this->db->where("(topic='by_group_time_summary_general' OR topic='".$report_type."')", NULL, FALSE);
		}else{
			$this->db->where("(topic='general_field' OR topic='general_field_201' OR topic='".$report_type."')", NULL, FALSE);
		}


		$this->db->order_by("display_order","ASC");
		$query = $this->db->get();
		return $query->result();
	}
	//report list

	public function validate_report_name($report_name,$report_type) // ADD report validation
	{		
		$this->db->select('*');
		$this->db->where(array(
			'report_type'=>$report_type,
			'report_name'=>$report_name
		));

		$this->db->from('reports');
		$query = $this->db->get();
		return $query->row();
	}
	public function validate_edit_report_name($report_name,$report_type,$report_id) // edit report name validation
	{
		
		$this->db->select('*');
		$this->db->where(array(
			'report_type'=>$report_type,
			'report_name'=>$report_name,
			'report_id !='=> $report_id
		));

		$this->db->from('reports');
		$query = $this->db->get();
		return $query->row();
	}
	public function report_list()
	{
		$report_type=$this->uri->segment("4");
		$this->db->select('*');

		$this->db->where(array(
			'report_type'=>$report_type
		));

		$this->db->from('reports');
		$query = $this->db->get();
		return $query->result();
	}


	//save new report
	public function add_new_report($fields,$report_name,$report_desc,$report_type)
	{
		
		$name = str_replace("%20"," ",$report_name);
		$desc = str_replace("%20"," ",$report_desc);

		$field = substr_replace($fields, "", -1);
		$var=explode('-',$field);
		$data = array(
						'report_name'		=> $name,
						'report_desc'		=> $desc,
						'report_type'		=> $report_type,
		                'date_created' 		=> date('Y-m-d H:i:s')
						);	
		$inserted = $this->db->insert('reports',$data);
		if($this->db->affected_rows() > 0)
		{
	    	$this->db->select_max('report_id');
			$this->db->from('reports');
			$this->db->where(array(
						'report_name'		=> $name,
						'report_desc'		=> $desc));
			$query = $this->db->get();
			$id_check =  $query->row("report_id");	
			foreach ($var as $row) {

				$data1 = array(
						'report_id'		=> $id_check,
						'report_time_id'=> $row
						);	
				$inserted1 = $this->db->insert('report_fields',$data1);
			/*
			--------------audit trail composition--------------
			(module,module dropdown,logfiletable,detailed action,action type,key value)
			--------------audit trail composition--------------
			*/

				$this->general_model->system_audit_trail('Reports','Time>Crystal Report','logfile_reports_time','add field: '.$row.' for report id  : '.$id_check.'','INSERT',$report_type);

			}
		}
		else { return 'error'; }
	}


	public function working_schedule_fields($report){
		$this->db->select('*');
		$this->db->from('report_fields');
		$this->db->join('crystal_report_payroll','crystal_report_payroll.report_time_id=report_fields.report_time_id');
		$this->db->where('report_id',$report);
		$query = $this->db->get();
		return $query->result();
	}
	public function working_schedule_general_fields($report,$report_area){
		$this->db->select('*');
		$this->db->from('report_fields');
		$this->db->join('crystal_report_payroll','crystal_report_payroll.report_time_id=report_fields.report_time_id');


		$this->db->where(array(
                'report_id'      		=>     $report
        ));


			$this->db->where("(topic='general_field_201' OR topic='".$report_area."' OR topic='general_field')", NULL, FALSE);
		

		$query = $this->db->get();
		return $query->result();
	}
	public function year_date()
	{
		$this->db->select('yy');
		$this->db->from('year_date');
		$query = $this->db->get();
		return $query->result();
	}
	public function check_payslip_view_log($employee_id,$type,$covered_month_from,$covered_month_to,$covered_year,$payroll_period){
		$checkmonthcover="";
		$covered_month_from = (int)($covered_month_from);
		$covered_month_to = (int)($covered_month_to);
		$x=$covered_month_from;
		if($type=="by_month"){
			while($x <= $covered_month_to) {
			$checkmonthcover.="b.month_cover='".$x."' OR ";
			$x++;
			} 
			$checkmonthcover=substr($checkmonthcover, 0, -3);  

			$query=$this->db->query("SELECT a.*,b.complete_from,b.complete_to FROM payslip_viewed_logs a INNER JOIN payroll_period b on(a.payroll_period_id=b.id) where a.employee_id='".$employee_id."' AND ($checkmonthcover) AND b.year_cover='".$covered_year."' ");
		}elseif($type=="single_pp"){
				
			$query=$this->db->query("SELECT a.*,b.complete_from,b.complete_to FROM payslip_viewed_logs a INNER JOIN payroll_period b on(a.payroll_period_id=b.id) where a.employee_id='".$employee_id."' AND a.payroll_period_id='".$payroll_period."' ");
		}else{
			$query=$this->db->query("SELECT * FROM payslip_viewed_logs where employee_id='".$employee_id."'  ");
		}
		
		
		return $query->result();

	}

	public function extract_salary_info($company_id,$sal_type,$effectivity_date,$sal_rep_typ){

		if($sal_rep_typ=="1"){
		//all company with salary setup
			$query=$this->db->query("SELECT b.*,a.employee_id,a.name_lname_first  FROM masterlist a INNER JOIN salary_information b on(a.employee_id=b.employee_id) WHERE b.date_effective<='".$effectivity_date."' and b.salary_status='approved' ");

		}elseif($sal_rep_typ=="2"){
		//all company without salary
			$query=$this->db->query("SELECT a.employee_id,a.name_lname_first  FROM masterlist a WHERE a.employee_id not in (select employee_id from salary_information) ");
		}elseif($sal_rep_typ=="3"){
		//specific company with salary setup
			$query=$this->db->query("SELECT b.*,a.employee_id,a.name_lname_first  FROM masterlist a INNER JOIN salary_information b on(a.employee_id=b.employee_id) WHERE b.date_effective<='".$effectivity_date."' and b.salary_status='approved' AND a.company_id='".$company_id."'  ");
		}else{
		//4// specific company without salary
			$query=$this->db->query("SELECT a.employee_id,a.name_lname_first  FROM masterlist a WHERE a.employee_id not in (select employee_id from salary_information) AND a.company_id='".$company_id."'  ");
		}


		
		return $query->result();

	}

	public function ws_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row,$bank_company_code,$bank_company_depository_code,$bank_effectivity_date,$bank_company_code_two,$loan_status)
	{

		// left coding here

				if($type=="by_month" OR $type=="by_year" OR $type=="group_by_year" OR $type=="group_by_month"){
					
					$check_mc=$this->payroll_period_myc($covered_month_from,$covered_month_to,$company,$covered_year,$type,$quarter);
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
		
				if($report_area=="other_addition" OR $report_area=="other_deduction" OR $report_area=="late" OR $report_area=="undertime" OR $report_area=="overbreak" OR $report_area=="absent" OR $report_area=="overtime" OR $report_area=="regular_nd" OR $report_area=="pagibig" OR $report_area=="pagibig_certificate" OR $report_area=="ph_certificate" OR $report_area=="pagibig_mcrf" OR $report_area=="pagibig_mrrf" OR $report_area=="sss" OR $report_area=="sss_certificate" OR $report_area=="sss_transmittal" OR $report_area=="philhealth" OR $report_area=="payroll_register" OR $report_area=="bank_file_metrobank1" OR $report_area=="bank_file_metrobank2" OR $report_area=="bank_file_metrobank3" OR $report_area=="loan_report" OR $report_area=="payslip_viewed"){

					if($selected_individual_employee_id=="0"){ //== 
							$location_1 = substr_replace($location, "", -3 , 3);
							$location_2 = str_replace("-"," ",$location_1);					
							$classification_1 = substr_replace($classification, "", -3 , 3);
							$classification_2 = str_replace("-"," ",$classification_1);
							$employment_1 = substr_replace($employment, "", -3 , 3);
							$employment_2 = str_replace("-"," ",$employment_1);		


							$location_final = str_replace("ll","a.location=",$location_2);
							$classification_final = str_replace("cc","a.classification=",$classification_2);
							$employment_final = str_replace("ee","a.employment=",$employment_2);
					}else{

					}

				if($payroll_unique=="All"){ //
					$check_oa="";
				}else{
					if($report_area=="other_addition"){
						$check_oa="AND b.oa_id='".$payroll_unique."' ";
					}elseif($report_area=="other_deduction"){
						$check_oa="AND b.od_id='".$payroll_unique."' ";
					}elseif($report_area=="loan_report"){
						$check_oa="AND a.loan_type_id='".$payroll_unique."' ";
					}else{
						$check_oa="";
					}	
					
				}
				
				if($report_area=="other_addition"){
					$table_subject="union_payslip_oa_mm_tables";
					$unique_order_by="order by a.employee_id,b.payroll_period_id asc";
				}elseif($report_area=="other_deduction"){
					$table_subject="union_payslip_od_mm_tables";
					$unique_order_by="order by a.employee_id,b.payroll_period_id asc";
				}elseif($report_area=="late" OR $report_area=="undertime" OR $report_area=="overbreak" OR $report_area=="absent" OR $report_area=="overtime" OR $report_area=="regular_nd" OR $report_area=="payroll_register" OR $report_area=="payslip_viewed"){ 
					$table_subject="union_payslip_mm_tables";
					$unique_order_by="order by a.employee_id,b.payroll_period_id asc";

				}elseif($report_area=="pagibig" OR $report_area=="sss" OR $report_area=="philhealth"){

							$table_subject="union_payslip_mm_tables";
							$unique_order_by="order by a.employee_id,b.payroll_period_id asc";				
				}elseif($report_area=="pagibig_certificate" OR $report_area=="sss_certificate" OR $report_area=="ph_certificate"){
							$table_subject="union_payslip_mm_tables";
							$unique_order_by="order by c.month_cover,c.id asc";				
				}elseif($report_area=="pagibig_mcrf"){
							$table_subject="union_payslip_mm_tables";
							$unique_order_by="order by c.month_cover,c.id asc";				
				}elseif($report_area=="pagibig_mrrf"){
							$table_subject="union_payslip_mm_tables";
							$unique_order_by="order by c.month_cover,c.id asc";				
				}elseif($report_area=="sss_transmittal"){
							$table_subject="union_payslip_mm_tables";
							$unique_order_by="order by c.month_cover,c.id asc";				
				}else{

				}
				

				if($selected_individual_employee_id=="0"){  // filter group query

					if($report_area=="pagibig_certificate" OR $report_area=="sss_certificate" OR $report_area=="ph_certificate"){

							$query=$this->db->query("SELECT c.month_cover,c.year_cover,a.company_name,a.company_id,a.employee_id,a.name_lname_first,a.philhealth_number,a.pagibig_number,b.pagibig,b.pagibig_employer,a.sss_number,b.sss_employee,b.sss_employer,b.sss_ec_er,b.philhealth_employee,b.philhealth_employer from masterlist a inner join $table_subject b on(a.employee_id=b.employee_id) inner join payroll_period c on(b.payroll_period_id=c.id) where  a.company_id='".$company."' and a.InActive='".$status."' AND ($location_final) AND ($classification_final) AND ($employment_final) AND $check_pp_id group by c.month_cover,a.employee_id order by a.employee_id,c.month_cover,c.id asc ");	

					}elseif($report_area=="pagibig_mcrf"){

							$query=$this->db->query("SELECT sum(b.pagibig) as pagibig,sum(b.pagibig_employer) as pagibig_employer,b.salary_ratename,sum(b.basic) as basic,b.salary_amount,c.month_cover,c.year_cover,a.company_name,a.company_id,a.employee_id,a.name_lname_first,a.pagibig_number from masterlist a inner join $table_subject b on(a.employee_id=b.employee_id) inner join payroll_period c on(b.payroll_period_id=c.id) where  a.company_id='".$company."' and a.InActive='".$status."' AND ($location_final) AND ($classification_final) AND ($employment_final) AND ($check_pp_id) group by employee_id,month_cover order by a.employee_id,c.month_cover,c.id asc ");	

					}elseif($report_area=="pagibig_mrrf"){

							$query=$this->db->query("SELECT sum(b.pagibig) as pagibig,sum(b.pagibig_employer) as pagibig_employer,b.salary_amount,c.month_cover,c.year_cover,a.company_name,a.company_id,a.employee_id,a.first_name,a.middle_name,a.last_name,a.pagibig_number,a.tin,a.birthday from masterlist a inner join $table_subject b on(a.employee_id=b.employee_id) inner join payroll_period c on(b.payroll_period_id=c.id) where  a.company_id='".$company."' and a.InActive='".$status."' AND ($location_final) AND ($classification_final) AND ($employment_final) AND ($check_pp_id) group by employee_id,month_cover order by a.employee_id,c.month_cover,c.id asc ");	

					}elseif($report_area=="sss_transmittal"){
						
							$query=$this->db->query("SELECT count(a.employee_id) as no_of_employees,c.month_cover,c.year_cover,a.company_name,a.company_id,sum(b.sss_employee)+sum(b.sss_employer) as ee_er_total,sum(b.sss_employee) as sss_employee_total,sum(b.sss_employer) as sss_employer_total,sum(b.sss_ec_er) as sss_ec_er_total from masterlist a inner join $table_subject b on(a.employee_id=b.employee_id) inner join payroll_period c on(b.payroll_period_id=c.id) where  a.company_id='".$company."' and a.InActive='".$status."' AND ($location_final) AND ($classification_final) AND ($employment_final) AND $check_pp_id group by b.month_cover order by b.month_cover asc");	

					}elseif($report_area=="payroll_register"){

					$query=$this->db->query("SELECT b.payroll_period_id,b.*,a.*
 from masterlist a inner join $table_subject b on(a.employee_id=b.employee_id) where a.company_id='".$company."' and a.InActive='".$status."' AND ($location_final) AND ($classification_final) AND ($employment_final) AND ($check_pp_id) $check_oa $unique_order_by ");	

					}elseif($report_area=="bank_file_metrobank1" OR $report_area=="bank_file_metrobank2" OR $report_area=="bank_file_metrobank3"){

						$pp_data=$this->payroll_data($payroll_period);
						$mc=$pp_data->month_cover;
						$mc = sprintf("%02d", $mc);
						$tbl="payslip_".$mc;
					
					$query=$this->db->query("select a.net_pay,a.employee_id,b.account_no,b.bank_name,b.company_name,b.name_lname_first as fullname  from $tbl a inner join masterlist b
on(a.employee_id=b.employee_id) where a.payroll_period_id='".$payroll_period."' and b.account_no!='' ");	

					}elseif($report_area=="loan_report"){
						if($covered_month_from!='0'){
							$date_eff_ref="and a.date_effective>='".$covered_year."-".$covered_month_from."-01' AND a.date_effective<='".$covered_year."-".$covered_month_to."-31'";
						}else{
							$date_eff_ref="and a.date_effective>='".$covered_year."-01-01' AND a.date_effective<='".$covered_year."-12-31'";
						}

					$query=$this->db->query("SELECT a.*,b.loan_type,c.employee_id,c.name_lname_first from payroll_emp_loan_enrolment a inner join loan_type b on(a.loan_type_id=b.loan_type_id) inner join masterlist c on(a.employee_id=c.employee_id) where a.company_id='".$company."' $date_eff_ref $check_oa order by loan_type_id asc");	

					}elseif($report_area=="payslip_viewed"){

					$query=$this->db->query("SELECT a.employee_id,a.name from masterlist a where a.company_id='".$company."' and a.InActive='".$status."' AND ($location_final) AND ($classification_final) AND ($employment_final)  ");

					}else{

					$query=$this->db->query("SELECT b.payroll_period_id,b.*,a.* from masterlist a inner join $table_subject b on(a.employee_id=b.employee_id) where a.company_id='".$company."' and a.InActive='".$status."' AND ($location_final) AND ($classification_final) AND ($employment_final) AND ($check_pp_id) $check_oa $unique_order_by ");	
					}

				}else{//individual report

					if($report_area=="pagibig_certificate" OR $report_area=="sss_certificate" OR $report_area=="ph_certificate"){
							$query=$this->db->query("SELECT c.month_cover,c.year_cover,a.company_name,a.name_lname_first,a.philhealth_number,a.pagibig_number,b.pagibig,b.pagibig_employer,a.sss_number,b.sss_employee,b.sss_employer,b.sss_ec_er,b.philhealth_employee,b.philhealth_employer from masterlist a inner join $table_subject b on(a.employee_id=b.employee_id) inner join payroll_period c on(b.payroll_period_id=c.id) where a.employee_id='".$selected_individual_employee_id."' AND ($check_pp_id) GROUP by c.month_cover $unique_order_by ");	

					}elseif($report_area=="payroll_register"){

					$query=$this->db->query("SELECT b.payroll_period_id,b.*,a.*
 from masterlist a inner join $table_subject b on(a.employee_id=b.employee_id) where a.employee_id='".$selected_individual_employee_id."' AND ($check_pp_id) $check_oa $unique_order_by ");	


					}elseif($report_area=="loan_report"){
						//echo "show $loan_status gel ";
						if($covered_month_from!='0'){
							$date_eff_ref="and a.date_effective>='".$covered_year."-".$covered_month_from."-01' AND a.date_effective<='".$covered_year."-".$covered_month_to."-31'";
						}else{
							$date_eff_ref="and a.date_effective>='".$covered_year."-01-01' AND a.date_effective<='".$covered_year."-12-31'";
						}

					$query=$this->db->query("SELECT a.*,b.loan_type,c.employee_id,c.name_lname_first from payroll_emp_loan_enrolment a inner join loan_type b on(a.loan_type_id=b.loan_type_id) inner join masterlist c on(a.employee_id=c.employee_id) where a.company_id='".$company."' and a.employee_id='".$selected_individual_employee_id."' $date_eff_ref $check_oa order by loan_type_id asc");	

					}else{
							$query=$this->db->query("SELECT b.payroll_period_id,b.*,a.* from masterlist a inner join $table_subject b on(a.employee_id=b.employee_id)  where a.employee_id='".$selected_individual_employee_id."' AND ($check_pp_id) $check_oa $unique_order_by ");	
					}

									
				}



			}elseif($report_area=="pagibig_group_rep" OR $report_area=="sss_group_rep" OR $report_area=="ph_group_rep"){

				$table_subject="union_payslip_mm_tables";
				if($type=="group_by_month" OR $type=="group_by_year"){

						// $check_mc=$this->payroll_period_myc($covered_month_from,$covered_month_to,$company,$covered_year,$type,$quarter);
						// if(!empty($check_mc)){
						// 	//echo "merung data";
						// 		$check_pp_id=""; // check payroll period ID
						// 	foreach($check_mc as $pp){
						// 		$check_pp_id.="b.payroll_period_id='".$pp->id."' OR ";
						// 	}
						// 		$check_pp_id=substr($check_pp_id, 0, -3);  
						// }else{
						// 	$check_pp_id="b.payroll_period_id='0'"; // force no result value.
						// }

				
						$for_sum_fields=$this->check_by_group_time_summary($report_area);
						$fields_to_sum_and_select="";

						foreach($for_sum_fields as $sf){
							$fields_to_sum_and_select.="b.".$sf->field_name." as ".$sf->field_name.", ";
						}
							$fields_to_sum_and_select=substr($fields_to_sum_and_select, 0, -2); 


					if($groupings_type=="g_company"){

					$query=$this->db->query("SELECT b.payroll_period_id,b.*,a.* $fields_to_sum_and_select from masterlist a inner join $table_subject b on(a.employee_id=b.employee_id)  where a.company_id='".$company."' AND a.InActive='".$status."' AND ($check_pp_id)");						
					}elseif($groupings_type=="g_location"){

					$query=$this->db->query("SELECT b.payroll_period_id,b.*,a.* $fields_to_sum_and_select from masterlist a inner join $table_subject b on(a.employee_id=b.employee_id)  where a.company_id='".$company."' AND a.location='".$location."' AND a.InActive='".$status."' AND ($check_pp_id)");	

					}elseif($groupings_type=="g_div"){

					$query=$this->db->query("SELECT b.payroll_period_id,b.*,a.* $fields_to_sum_and_select from masterlist a inner join $table_subject b on(a.employee_id=b.employee_id)  where a.company_id='".$company."' AND a.division_id='".$division."' AND a.InActive='".$status."' AND ($check_pp_id)");	

					}elseif($groupings_type=="g_dept"){

					$query=$this->db->query("SELECT b.payroll_period_id,b.*,a.* $fields_to_sum_and_select from masterlist a inner join $table_subject b on(a.employee_id=b.employee_id)  where a.company_id='".$company."' AND a.department='".$department."' AND a.InActive='".$status."' AND ($check_pp_id)");	

					}elseif($groupings_type=="g_sect"){

					$query=$this->db->query("SELECT b.payroll_period_id,b.*,a.* $fields_to_sum_and_select from masterlist a inner join $table_subject b on(a.employee_id=b.employee_id)  where a.company_id='".$company."' AND a.department='".$department."' AND a.section='".$section."' AND a.InActive='".$status."' AND ($check_pp_id)");	

					}elseif($groupings_type=="g_subsect"){

					$query=$this->db->query("SELECT b.payroll_period_id,b.*,a.* $fields_to_sum_and_select from masterlist a inner join $table_subject b on(a.employee_id=b.employee_id)  where a.company_id='".$company."' AND a.department='".$department."' AND a.section='".$section."' AND subsection='".$subsection."' AND a.InActive='".$status."' AND ($check_pp_id)");	

					}else{

					}
	
	


				}else{

				}
				
			}else{

			}


		


		return $query->result();
	}


public function check_loan_bal($emp_loan_id){

	$query=$this->db->query("select sum(system_deduction) as total_deduction from union_payslip_loan_mm_tables where emp_loan_id='".$emp_loan_id."'");
	return $query->row();
}


public function check_dtr_summary_hrs($month_cover,$year_cover,$employee_id,$payroll_period_id,$name){

				$mc = sprintf("%02d", $month_cover);
				$table="time_summary_".$mc;
				//echo "SELECT $name from $table where employee_id='".$employee_id."' and payroll_period_id='".$payroll_period_id."' <br>";
		$query=$this->db->query("SELECT $name from $table where employee_id='".$employee_id."' and payroll_period_id='".$payroll_period_id."'");

	return $query->row();
}

public function loans_breakdown($company){
		$query=$this->db->query("SELECT a.loan_type,a.loan_type_id,b.category from loan_type a inner join loan_category b on(a.loan_category=b.id) where a.company_id='".$company."' ");
	return $query->result();
}

public function leave_breakdown($company){
		$query=$this->db->query("SELECT id,leave_type from leave_type where company_id='".$company."' ");
	return $query->result();
}

public function get_posted_leave($employee_id,$leave_type_id,$payroll_period_id){

		$query=$this->db->query("SELECT sum(a.leave_day_type) as leave_day_type,a.leave_type_id,b.daily_rate,sum((a.leave_day_type*b.daily_rate)) as leave_amount from dtr_leave a inner join payslip_03 b on(a.payroll_period_id=b.payroll_period_id AND a.employee_id=b.employee_id) where a.payroll_period_id='".$payroll_period_id."' AND a.employee_id='".$employee_id."' AND a.leave_type_id='".$leave_type_id."' GROUP BY a.leave_type_id " );
	return $query->row();
}

public function get_posted_loan($employee_id,$loan_type_id,$payroll_period_id){
		$query=$this->db->query("SELECT sum(system_deduction) as system_deduction,loan_type_id from union_payslip_loan_mm_tables where payroll_period_id='".$payroll_period_id."' AND employee_id='".$employee_id."' AND loan_type_id='".$loan_type_id."' GROUP BY loan_type_id" );
	return $query->row();
}




public function comp_oa($company,$check_tax){
		$query=$this->db->query("SELECT a.*,b.category as category_name from other_addition_type a inner join other_additions_category b on(a.category=b.id) where a.company_id='".$company."' AND a.taxable='".$check_tax."'");
	return $query->result();
}
public function comp_od($company,$check_tax){
		$query=$this->db->query("SELECT a.*,b.category as category_name from other_deduction_type a inner join other_deductions_category b on(a.category=b.id) where a.company_id='".$company."' AND a.taxable='".$check_tax."'");
	return $query->result();
}
public function comp_oa_count($company,$check_tax){
		$query=$this->db->query("SELECT count(a.id) as oa_numbers  from other_addition_type a inner join other_additions_category b on(a.category=b.id) where a.company_id='".$company."' AND a.taxable='".$check_tax."'");
	return $query->row();
}

public function get_posted_od_taxable($employee_id,$od_id,$payroll_period_id,$check_tax){
		$query=$this->db->query("SELECT sum(oa_amount) as oa_amount,od_id from union_payslip_od_mm_tables where payroll_period_id='".$payroll_period_id."' AND employee_id='".$employee_id."' AND od_id='".$od_id."' GROUP BY od_id" );
	return $query->row();
}

public function get_posted_oa_taxable($employee_id,$oa_id,$payroll_period_id,$check_tax){
		$query=$this->db->query("SELECT sum(oa_amount) as oa_amount,oa_id from union_payslip_oa_mm_tables where payroll_period_id='".$payroll_period_id."' AND employee_id='".$employee_id."' AND oa_id='".$oa_id."' GROUP BY oa_id" );
	return $query->row();
}

public function get_posted_oa_taxable_total($oa_id,$payroll_period_id,$check_tax){

		$query=$this->db->query("SELECT sum(oa_amount) as oa_amount,oa_id from union_payslip_oa_mm_tables where payroll_period_id='".$payroll_period_id."' AND oa_id='".$oa_id."' GROUP BY oa_id" );
	return $query->row();
}





public function get_for_r1_emp($company){
	$query=$this->db->query("SELECT a.*,b.last_name,b.first_name,b.middle_name,b.birthday,b.date_employed,b.position_name,b.sss_number from sss_r1a_form a inner join masterlist b on(a.employee_id=b.employee_id) where a.company_id='".$company."' ");
	return $query->result();
}

public function sss_r3($type,$company,$report_area,$covered_month_from,$covered_month_to,$covered_year,$selected_individual_employee_id,$quarter,$page_row,$level){

			$check_mc=$this->check_quarter_pp($covered_month_from,$covered_month_to,$company,$covered_year,$type,$quarter,$level);

				if(!empty($check_mc)){
					//echo "merung data";
					$check_pp_id=""; // check payroll period ID
				foreach($check_mc as $pp){
					$check_pp_id.="payroll_period_id='".$pp->id."' OR ";
				}
					$check_pp_id=substr($check_pp_id, 0, -3);  
				}else{
					$check_pp_id="payroll_period_id='0'"; // force no result value.
				}
				//echo "SELECT sum(sss_employee) as sss_employee,sum(sss_employer) as sss_employer from union_payslip_mm_tables where employee_id='".$selected_individual_employee_id."' AND ($check_pp_id) and year_cover='".$covered_year."' "."<br><br>";

				$query=$this->db->query("SELECT sum(sss_employee) as sss_employee,sum(sss_employer) as sss_employer from union_payslip_mm_tables where employee_id='".$selected_individual_employee_id."' AND ($check_pp_id) and year_cover='".$covered_year."' ");	


		return $query->row();

}

	public function check_quarter_pp($covered_month_from,$covered_month_to,$company,$covered_year,$type,$quarter,$level) //check_quarter_pp : chech quarter payroll period
	{
		$cm_from=intval($covered_month_from);
		$cm_to=intval($covered_month_to);

		$mc="";
		for ($x = $cm_from; $x <= $cm_to; $x++) {
		   $mc.="month_cover='".$x."' OR ";
		} 

		$mc=substr($mc, 0, -3);  // 

		if($level=="1"){
					if($quarter=="1"){
						$mc="AND month_cover='1'";
					}elseif($quarter=="2"){
						$mc="AND month_cover='4'";
					}elseif($quarter=="3"){
						$mc="AND month_cover='7'";
					}elseif($quarter=="4"){
						$mc="AND month_cover='10'";
					}else{

					}			
		}elseif($level=="2"){
					if($quarter=="1"){
						$mc="AND month_cover='2'";
					}elseif($quarter=="2"){
						$mc="AND month_cover='5'";
					}elseif($quarter=="3"){
						$mc="AND month_cover='8'";
					}elseif($quarter=="4"){
						$mc="AND month_cover='11'";
					}else{

					}		
		}elseif($level=="3"){
					if($quarter=="1"){
						$mc="AND month_cover='3'";
					}elseif($quarter=="2"){
						$mc="AND month_cover='6'";
					}elseif($quarter=="3"){
						$mc="AND month_cover='9'";
					}elseif($quarter=="4"){
						$mc="AND month_cover='12'";
					}else{

					}		
		}



			//echo "SELECT id from payroll_period where InActive='0' $mc AND year_cover='".$covered_year."' order by month_cover ASC";

			$query=$this->db->query("SELECT id from payroll_period where InActive='0' $mc AND year_cover='".$covered_year."' order by month_cover ASC");
		

		return $query->result();

	}
	public function check_payslip_decimal($company){
		$query=$this->db->query("select 
			b.title,
			c.single_field,
			b.employment_classification,
			a.company_id,
			a.payroll_main_id from payroll_setting_policy a inner join payroll_main_setting b on(a.payroll_main_id=b.payroll_main_id) inner join payroll_setting c on(a.payroll_setting_policy_id=c.payroll_setting_policy_id) where a.company_id='".$company."' and b.single_field='1' and a.payroll_main_id='1'   " );
		return $query->row();
	}
	public function check_rounding_off($company){
		$query=$this->db->query("select 
			b.title,
			c.single_field,
			b.employment_classification,
			a.company_id,
			a.payroll_main_id from payroll_setting_policy a inner join payroll_main_setting b on(a.payroll_main_id=b.payroll_main_id) inner join payroll_setting c on(a.payroll_setting_policy_id=c.payroll_setting_policy_id) where a.company_id='".$company."' and b.single_field='1' and a.payroll_main_id='5'   " );
		return $query->row();
	}



	public function test_me(){
		$query=$this->db->query("select * from company_info " );
		return $query->result();
	}


	public function check_emp_list($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type,$payroll_unique,$selected_individual_employee_id,$quarter,$page_row){

							$location_1 = substr_replace($location, "", -3 , 3);
							$location_2 = str_replace("-"," ",$location_1);					
							$classification_1 = substr_replace($classification, "", -3 , 3);
							$classification_2 = str_replace("-"," ",$classification_1);
							$employment_1 = substr_replace($employment, "", -3 , 3);
							$employment_2 = str_replace("-"," ",$employment_1);		


							$location_final = str_replace("ll","a.location=",$location_2);
							$classification_final = str_replace("cc","a.classification=",$classification_2);
							$employment_final = str_replace("ee","a.employment=",$employment_2);

						$check_mc=$this->payroll_period_myc($covered_month_from,$covered_month_to,$company,$covered_year,$type,$quarter);
						if(!empty($check_mc)){
							//echo "merung data";
								$check_pp_id=""; // check payroll period ID
							foreach($check_mc as $pp){
								$check_pp_id.="b.payroll_period_id='".$pp->id."' OR ";
							}
								$check_pp_id=substr($check_pp_id, 0, -3);  
						}else{
							$check_pp_id="b.payroll_period_id='0'"; // force no result value.
						}

		$query=$this->db->query("SELECT c.month_cover,c.year_cover,a.company_name,a.company_id,a.employee_id,a.name_lname_first,a.pagibig_number,a.sss_number,a.philhealth_number,a.last_name,a.middle_name,a.first_name from masterlist a inner join union_payslip_mm_tables b on(a.employee_id=b.employee_id) inner join payroll_period c on(b.payroll_period_id=c.id) where  a.company_id='".$company."' and a.InActive='".$status."' AND ($location_final) AND ($classification_final) AND ($employment_final) AND $check_pp_id group by a.employee_id order by a.employee_id,c.month_cover,c.id asc ");	

		return $query->result();

	}



	public function check_sbr($month_cover,$year_cover,$gov_type,$company_id){
		//echo "SELECT * from gov_contri_remittance where month_cover='".$month_cover."' AND year_cover='".$year_cover."' and gov='".$gov_type."' AND company_id='".$company_id."' <br>";
		$query=$this->db->query("SELECT * from gov_contri_remittance where month_cover='".$month_cover."' AND year_cover='".$year_cover."' and gov='".$gov_type."' AND company_id='".$company_id."'");
		return $query->row();
	}


	public function check_emp_201($selected_individual_employee_id){
		$query=$this->db->query("SELECT * from masterlist where employee_id='".$selected_individual_employee_id."' ");
		return $query->row();
	}
	public function get_oa($value){
		$query=$this->db->query("SELECT * from other_addition_type where company_id='".$value."' order by other_addition_type asc");
		return $query->result();
	}
	public function get_od($value){
		$query=$this->db->query("SELECT * from other_deduction_type where company_id='".$value."' order by other_deduction_type asc");
		return $query->result();
	}

	public function get_loans($value){
		$query=$this->db->query("SELECT a.loan_type_id,b.loan_type from payroll_emp_loan_enrolment a inner join loan_type b on(a.loan_type_id=b.loan_type_id) where a.company_id='".$value."' group by a.loan_type_id order by loan_type_id asc");
		return $query->result();
	}
	public function get_loans_spec_employee($company_id,$employee_id){
		$query=$this->db->query("SELECT a.loan_type_id,b.loan_type from payroll_emp_loan_enrolment a inner join loan_type b on(a.loan_type_id=b.loan_type_id) where a.company_id='".$company_id."' and a.employee_id='".$employee_id."' group by a.loan_type_id order by loan_type_id asc");
		return $query->result();
	}

	public function check_by_group_time_summary($report_area){
		$query=$this->db->query("SELECT * from crystal_report_payroll where topic='".$report_area."' and sum_me='1'");
		return $query->result();
	}


	public function payroll_period_myc($covered_month_from,$covered_month_to,$company,$covered_year,$type,$quarter) // myc= month & year cover
	{
		$cm_from=intval($covered_month_from);
		$cm_to=intval($covered_month_to);

		$mc="";
		for ($x = $cm_from; $x <= $cm_to; $x++) {
		   $mc.="month_cover='".$x."' OR ";
		} 

		$mc=substr($mc, 0, -3);  // 


		if($type=="by_month"){
			$mc="AND ($mc)";
		}elseif($type=="by_year"){
			$mc="";
		}


		if($type=="group_by_month"){
			$check_comp="";
			$mc="AND ($mc)";
		}elseif($type=="group_by_year"){
			$check_comp="";
			$mc="";
		}else{
			$check_comp="AND company_id='".$company."' ";
		}

		if($quarter==0){
			$query=$this->db->query("SELECT id from payroll_period where InActive='0' $mc $check_comp AND year_cover='".$covered_year."' order by month_cover ASC");
		}else{
			
					if($quarter=="1"){
						$mc="AND (month_cover='1' OR month_cover='2' OR month_cover='3')";
					}elseif($quarter=="2"){
						$mc="AND (month_cover='4' OR month_cover='5' OR month_cover='6')";
					}elseif($quarter=="3"){
						$mc="AND (month_cover='7' OR month_cover='8' OR month_cover='9')";
					}elseif($quarter=="4"){
						$mc="AND (month_cover='10' OR month_cover='11' OR month_cover='12')";
					}else{

					}
	

			//echo "SELECT id from payroll_period where InActive='0' $mc $check_comp AND year_cover='".$covered_year."' order by month_cover ASC";
			$query=$this->db->query("SELECT id from payroll_period where InActive='0' $mc $check_comp AND year_cover='".$covered_year."' order by month_cover ASC");
		}

		return $query->result();

	}





	public function getSearch_Employee($val){
		$this->db->select("
			A.employee_id,
			A.department,
			A.pay_type,
			A.company_id,
			B.dept_name,
			C.payroll_period_group_id,
			A.id,
			concat(A.first_name,' ',A.middle_name,' ',A.last_name) as name
			",false);

		$where = "C.InActive=0 and A.InActive = 0 and 
			(
				A.employee_id like '%".$val."%' or 
				A.first_name like '%".$val."%' or 
				A.middle_name like '%".$val."%' or 
				A.last_name like '%".$val."%'
			)
			";
		$this->db->where($where);
		$this->db->order_by("A.id","ASC");
		$this->db->join("payroll_period_employees C","C.employee_id = A.employee_id","left outer");
		$this->db->join("department B","B.department_id = A.department","left outer");
		$query = $this->db->get("employee_info A");
		return $query->result();
	}
	public function get_selected_emp($selected_emp){ 

		$query=$this->db->query("select b.payroll_period_group_id,a.first_name,a.middle_name,a.last_name,a.employee_id,a.company_id,a.position,a.pay_type from employee_info a inner join payroll_period_employees b on(a.employee_id=b.employee_id) where a.employee_id='".$selected_emp."' and a.InActive='0' and b.InActive='0'");

		return $query->row();
	}

	// == Fixed Schedules start
	public function fs_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period)
	{

		$location_1 = substr_replace($location, "", -3 , 3);
		$location_2 = str_replace("-"," ",$location_1);
		$location_final = str_replace("ll","v.location=",$location_2);
		
		$classification_1 = substr_replace($classification, "", -3 , 3);
		$classification_2 = str_replace("-"," ",$classification_1);
		$classification_final = str_replace("cc","v.classification=",$classification_2);
		
		$employment_1 = substr_replace($employment, "", -3 , 3);
		$employment_2 = str_replace("-"," ",$employment_1);
		$employment_final = str_replace("ee","v.employment=",$employment_2);

		if($company=='All'){} else { $this->db->where('v.company_id',$company); }
		if($division=='All'){} else { $this->db->where('v.division_id',$division); }
		if($department=='All'){} else { $this->db->where('v.department',$department); }
		if($section=='All'){} else { $this->db->where('v.section',$section); }
		if($subsection=='All'){} else { $this->db->where('v.subsection',$subsection); }
		//if($status=='All'){} else { $this->db->where('InActive',$status); }

		if($type=='single')
		{ //$yy $mm $dd
			$full_date=$yy."-".$mm."-".$dd;
			$dayOfWeek = date("l", strtotime($full_date));

			$get_this_data="a.system_user,a.date_added,a.last_update,
					v.employee_id,
					v.name,
					v.first_name,
					v.middle_name,
					v.last_name,
					v.name_extension,
					v.company_id,
					v.company_name,
					v.wDivision,
					v.location_name,
					v.division_name,
					v.dept_name,
					v.section_name,
					v.subsection_name,
					v.classification_name as classification,
					v.taxcode_name,
					v.civil_status_name,
					v.employment_name,
					v.pay_type_name,
					v.gender_name";

			if($dayOfWeek=="Monday"){
				$this->db->select('a.mon as the_day,'.$get_this_data.'');
				$where = "a.thu is  NOT NULL";
				$this->db->where($where);

			}elseif($dayOfWeek=="Tuesday"){
				$this->db->select('a.tue as the_day,'.$get_this_data.'');
				$where = "a.thu is  NOT NULL";
				$this->db->where($where);

			}elseif($dayOfWeek=="Wednesday"){
				$this->db->select('a.wed as the_day,'.$get_this_data.'');
				$where = "a.thu is  NOT NULL";
				$this->db->where($where);

			}elseif($dayOfWeek=="Thursday"){
				$this->db->select('a.thu as the_day,'.$get_this_data.'');
				$where = "a.thu is  NOT NULL";
				$this->db->where($where);

			}elseif($dayOfWeek=="Friday"){
				$this->db->select('a.fri as the_day,v.*');
				$where = "a.thu is  NOT NULL";
				$this->db->where($where);

			}elseif($dayOfWeek=="Saturday"){
				$this->db->select('a.sat as the_day,v.*');
				$where = "a.thu is  NOT NULL";
				$this->db->where($where);

			}elseif($dayOfWeek=="Sunday"){
				$this->db->select('a.sun as the_day,v.*');
				$where = "a.thu is  NOT NULL";
				$this->db->where($where);

			}else{
				//
			}

			$this->db->where('a.InActive','0');
			$this->db->join("admin_emp_masterlist_view v", "a.employee_id = v.employee_id", "inner");
			$this->db->from('fixed_working_schedule_members a'); 

		}
		else if($type=='double')
		{ 
			$full_date=$yy."-".$mm."-".$dd;
			$dayOfWeek = date("l", strtotime($full_date));

			$get_this_data="
					a.system_user,a.date_added,a.last_update,a.mon,a.tue,a.wed,a.thu,a.fri,a.sat.a.sun,
					v.employee_id,
					v.name,
					v.first_name,
					v.middle_name,
					v.last_name,
					v.name_extension,
					v.company_id,
					v.company_name,
					v.wDivision,
					v.location_name,
					v.division_name,
					v.dept_name,
					v.section_name,
					v.subsection_name,
					v.classification_name as classification,
					v.taxcode_name,
					v.civil_status_name,
					v.employment_name,
					v.pay_type_name,
					v.gender_name";	

			$this->db->where('a.InActive','0');
			$this->db->join("admin_emp_masterlist_view v", "a.employee_id = v.employee_id", "inner");
			$this->db->from('fixed_working_schedule_members a'); 
			
		}
		else if($type=='single_pp')
		{ //$payroll_period
		
		}
		$this->db->where("(".$location_final." AND ".$classification_final." AND ".$employment_final." )");
		//$this->db->order_by('date','asc');
		$query = $this->db->get();
		return $query->result();
	}

	// == fixed schedule end



	//delete report
	public function delete_report($report_id)
	{
		$this->db->where('report_id',$report_id);
		$this->db->delete("reports");
		$this->db->where('report_id',$report_id);
		$this->db->delete("report_fields");

		if ($this->db->affected_rows() > 0)
		{
			return 'deleted'; 
		}
		else{
			return 'error'; 
		}
	}

	//view details report fields
	public function details_report_fields($val)
	{
		$this->db->select('*');
		$this->db->from('report_fields');
		$this->db->join('crystal_report_payroll','crystal_report_payroll.report_time_id=report_fields.report_time_id');
		$this->db->where('report_id',$val);
		$query = $this->db->get();
		return $query->result();
	}


	public function check_payroll_period($payroll_period)
	{
		$this->db->select('complete_from,complete_to');
		$this->db->from('payroll_period');
		$this->db->where('id',$payroll_period);
		$query = $this->db->get();
		return $query->row();	
	}
	public function payroll_period_year()
	{

		$query=$this->db->query("SELECT distinct year_cover from payroll_period where InActive='0' order by year_cover DESC");
		return $query->result();	
	}
	public function comp_emp_pp($selected_emp,$payroll_period_group_id) // company / employee payrol period
	{

		$query=$this->db->query("SELECT complete_from,complete_to,id from payroll_period where InActive='0' AND payroll_period_group_id='".$payroll_period_group_id."' order by year_cover,complete_to DESC");
		return $query->result();	
	}

	//view report
	public function details_report($val)
	{
		$this->db->select('*');
		$this->db->from('reports');
		$this->db->where('report_id',$val);
		$query = $this->db->get();
		return $query->row();	
	}

	//update report
	public function save_update_report($fields,$report_name,$report_desc,$report_id)
	{
		$name = str_replace("%20"," ",$report_name);
		$desc = str_replace("%20"," ",$report_desc);

		$field = substr_replace($fields, "", -1);
		$var=explode('-',$field);
		$data = array(
						'report_name'		=> $name,
						'report_desc'		=> $desc,
		                'date_created' 		=> date('Y-m-d H:i:s')
						);	

		$this->db->where('report_id',$report_id);
		$updated = $this->db->update('reports',$data);

		if($this->db->affected_rows() > 0)
		{	

			$this->db->where('report_id',$report_id);
			$this->db->delete("report_fields");

			foreach ($var as $row) {
				

				$data1 = array(
						'report_id'		=> $report_id,
						'report_time_id'		=> $row
						);	
				$inserted1 = $this->db->insert('report_fields',$data1);
			}
		}
		else { return 'error'; }
	}

	public function companyList(){ 
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->order_by('company_name','asc');
		$query = $this->db->get("company_info");
		return $query->result();
	}
	

	public function div_base_company(){ 
			$role_id=$this->session->userdata('user_role');	

			$query=$this->db->query("select a.* from company_info a inner join user_role_company_access b on(a.company_id=b.company_id) where a.InActive=0 AND wDivision='1' AND a.is_this_recruitment_employer='0' AND b.role_id='".$role_id."' group by b.company_id order by a.company_name asc" );
		return $query->result();
	}	
	public function subsec_base_section($dept_id){ 
			$query=$this->db->query("select * from section where wSubsection='1' and department_id='".$dept_id."' " );
		return $query->result();
	}	

	//emmployment list
	public function employmentList()
	{
		$this->db->where(array(
			'InActive'	=>	0	
		));
		$this->db->order_by('dept_name','asc');
		$query = $this->db->get("department_name");
		return $query->result();
	}
	public function check_dept($value)
	{
			$this->db->select('*');
			$this->db->from('department');
			$this->db->where('division_id',$value); 
			$query = $this->db->get();
			return $query->result();
	}
	//onchange results
	public function onchange_value($option,$value)
	{
		if($option=='division')
		{
			$this->db->select('*');
			$this->db->from('division');
			$this->db->where('company_id',$value); 
			$query = $this->db->get();
			return $query->result();
		}
		else if($option=='department')
		{
			$this->db->select('*');
			$this->db->from('department');
			$this->db->where('company_id',$value); 
			$query = $this->db->get();
			return $query->result();
		}
		else if($option=='section')
		{
			$this->db->select('*');
			$this->db->from('section');
			if($value == 'All') {
				$this->db->where('section_id',$value); // force no result	
			}
			else { $this->db->where('department_id',$value); }
			$query = $this->db->get();
			return $query->result();
		}
		else if($option=='subsection')
		{
			$this->db->select('*');
			$this->db->from('subsection');
			if($value=='All') {
				$this->db->where('section_id',$value); // force no result			
			}
			else { $this->db->where('section_id',$value); }
			$query = $this->db->get();
			return $query->result();
		}
		else if($option=='classification')
		{
			$this->db->select('*');
			$this->db->from('classification');
			$this->db->where('company_id',$value); 
			$query = $this->db->get();
			return $query->result();
		}
		else if($option=='location')
		{
			$this->db->select('location_name,location.location_id,company_id,company_location.company_id');
			$this->db->from('company_location');
			$this->db->join('location','location.location_id=company_location.location_id');
			$this->db->where('company_id',$value); 
			$query = $this->db->get();
			return $query->result();
		}
	 }
	 public function onchange_value_2($option,$value,$company_id)
	 {
	 	if($option=='group')
	 	{
	 		$this->db->select('*');
			$this->db->from('payroll_period_group');
			$this->db->where(array('company_id'=>$company_id,'pay_type'=>$value));
			$query = $this->db->get();
			return $query->result();
		}
		else{
			$this->db->select('*');
			$this->db->from('payroll_period');
			$this->db->where(array('company_id'=>$company_id,'payroll_period_group_id'=>$value,'pay_type'=>$option));

			$this->db->order_by("complete_to","DESC");
			$query = $this->db->get();
			return $query->result();
		}
	 }

	 public function ws_filter_data_pp($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$payroll_period)
	{

		$location_1 = substr_replace($location, "", -3 , 3);
		$location_2 = str_replace("-"," ",$location_1);
		$location_final = str_replace("ll","location_id=",$location_2);
		
		$classification_1 = substr_replace($classification, "", -3 , 3);
		$classification_2 = str_replace("-"," ",$classification_1);
		$classification_final = str_replace("cc","classification_id=",$classification_2);
		
		$employment_1 = substr_replace($employment, "", -3 , 3);
		$employment_2 = str_replace("-"," ",$employment_1);
		$employment_final = str_replace("ee","employment_id=",$employment_2);


		$this->db->select('*');
		 $this->db->from('working_schedule_filter_payroll');
		if($company=='All'){} else { $this->db->where('company_id',$company); }
		if($division=='All'){} else { $this->db->where('division_id',$division); }
		if($department=='All'){} else { $this->db->where('department_id',$department); }
		if($section=='All'){} else { $this->db->where('section_id',$section); }
		if($subsection=='All'){} else { $this->db->where('subsection_id',$subsection); }
		if($status=='All'){} else { $this->db->where('InActive',$status); }
		$this->db->where('id',$payroll_period);
		$this->db->where("(".$location_final." AND ".$classification_final." AND ".$employment_final." )");
		$query = $this->db->get();
		return $query->result();
	}

	 public function ws_filter_data_distinct($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$payroll_period)
	{

		$location_1 = substr_replace($location, "", -3 , 3);
		$location_2 = str_replace("-"," ",$location_1);
		$location_final = str_replace("ll","location_id=",$location_2);
		
		$classification_1 = substr_replace($classification, "", -3 , 3);
		$classification_2 = str_replace("-"," ",$classification_1);
		$classification_final = str_replace("cc","classification_id=",$classification_2);
		
		$employment_1 = substr_replace($employment, "", -3 , 3);
		$employment_2 = str_replace("-"," ",$employment_1);
		$employment_final = str_replace("ee","employment_id=",$employment_2);


		$this->db->select('*');
		 $this->db->from('working_schedule_filter_payroll_distinct');
		if($company=='All'){} else { $this->db->where('company_id',$company); }
		if($division=='All'){} else { $this->db->where('division_id',$division); }
		if($department=='All'){} else { $this->db->where('department_id',$department); }
		if($section=='All'){} else { $this->db->where('section_id',$section); }
		if($subsection=='All'){} else { $this->db->where('subsection_id',$subsection); }
		if($status=='All'){} else { $this->db->where('InActive',$status); }
		$this->db->where('id',$payroll_period);
		$this->db->where("(".$location_final." AND ".$classification_final." AND ".$employment_final." )");
		$query = $this->db->get();
		return $query->result();
	}

	public function payroll_data($payroll_period)
	{
		$this->db->select('*');
		$this->db->from('payroll_period');
		$this->db->where('id',$payroll_period);
		$query = $this->db->get();
		return $query->row();
	}

	public function shift_data($emp,$to1)
	{
		$this->db->select('*');
		$this->db->from('working_schedules_payroll_period');
		$this->db->where(array('employee_id' => $emp,'date' => $to1));
		$query = $this->db->get();
		return $query->row("date");
	}
	public function shift_data1($emp,$to1)
	{
		$this->db->select('*');
		$this->db->from('working_schedules_payroll_period');
		$this->db->where(array('employee_id' => $emp,'date' => $to1));
		$query = $this->db->get();
		return $query->result();
	}
	public function emp_list_payroll($payroll_period_group)
	{

		$this->db->select('payroll_period_group.payroll_period_group_id,payroll_period_employees.employee_id,employee_info.InActive,first_name,last_name,middle_name,
							employment.employment_name,employment.employment_id,employee_info.employment,
							company_info.company_id,employee_info.company_id,company_name,
							employee_info.division_id, division.division_id,division_name,
							department.department_id,employee_info.department,dept_name,
							section.section_id,employee_info.section,section_name,
							employee_info.subsection ,subsection.subsection_id,subsection_name,
							classification.classification_id,employee_info.classification,classification.classification,
							location.location_id,employee_info.location,location_name');

		$this->db->from('payroll_period_group');
		$this->db->join('payroll_period_employees','payroll_period_employees.payroll_period_group_id=payroll_period_group.payroll_period_group_id','inner');
		$this->db->join('employee_info','employee_info.employee_id=payroll_period_employees.employee_id','inner');
		$this->db->join('employment','employment.employment_id=employee_info.employment','inner');
		$this->db->join('company_info','company_info.company_id=employee_info.company_id','inner');
		$this->db->join('division','employee_info.division_id = division.division_id','left');
		$this->db->join('department','department.department_id=employee_info.department','inner');
		$this->db->join('section','section.section_id=employee_info.section','inner');
		$this->db->join('subsection','employee_info.subsection = subsection.subsection_id','left');
		$this->db->join('classification','classification.classification_id=employee_info.classification','inner');
		$this->db->join('location','location.location_id=employee_info.location','inner');
		$this->db->where('payroll_period_group.payroll_period_group_id',$payroll_period_group);
		$query = $this->db->get();
		return $query->result();
	}
}
