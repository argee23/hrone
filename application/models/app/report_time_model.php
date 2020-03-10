<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class report_time_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	public function check_udf_content($employee_id,$emp_udf_col_id){
	$query=$this->db->query("SELECT * FROM employee_udf_data WHERE employee_id='".$employee_id."' AND emp_udf_col_id='".$emp_udf_col_id."' ");	
	return $query->row();	

	}
	public function crystal_report_time()
	{
		$report_type=$this->uri->segment("4");
		$this->db->select('*');
		$this->db->from('crystal_report_time');
		$this->db->where(array(
			'modules'=>'time'
			));

		if($report_type=="by_group_time_summary"){
			$this->db->where("(topic='by_group_time_summary_general' OR topic='".$report_type."')", NULL, FALSE);
		}else{
			$this->db->where("(topic='general_field' OR topic='general_field_201' OR topic='".$report_type."')", NULL, FALSE);
		}


		//$this->db->where("(topic='general_field' OR topic='general_field_201' OR topic='".$report_type."')", NULL, FALSE);
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
		// $this->db->select('*');
		// $this->db->from('report_fields');
		// $this->db->join('crystal_report_time','crystal_report_time.report_time_id=report_fields.report_time_id');
		// $this->db->where('report_id',$report);
		// $query = $this->db->get();

		$query = $this->db->query("SELECT a.*,b.* FROM report_fields a INNER JOIN crystal_report_time b ON(a.report_time_id=b.report_time_id) WHERE a.report_id='".$report."' ");
		return $query->result();
	}
	public function working_schedule_general_fields($report,$report_area){
		$this->db->select('*');
		$this->db->from('report_fields');
		$this->db->join('crystal_report_time','crystal_report_time.report_time_id=report_fields.report_time_id');

		// $this->db->where('topic','general_field');
		// $this->db->where('report_id',$report);

		$this->db->where(array(
                'report_id'      		=>     $report
        ));

		if($report_area=="by_group_time_summary"){
			$this->db->where("(topic='by_group_time_summary_general')", NULL, FALSE);
		}else{
			$this->db->where("(topic='general_field_201' OR topic='working_schedules' OR topic='general_field')", NULL, FALSE);
		}

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

	public function quick_generate_timesummary_report($payroll_period_group_id,$pay_period){
		$query = $this->db->query("SELECT a.*,b.*,c.complete_from,c.complete_to FROM union_time_summary_mm_tables a INNER JOIN masterlist_active_inactive_union b ON(a.employee_id=b.employee_id) INNER JOIN payroll_period c ON(a.payroll_period_id=c.id) WHERE a.payroll_period_id='".$pay_period."'");
		return $query->result();
	}



	public function quick_generate_time_report($company,$date_from,$date_to,$report_area){

		if($report_area=="attendances"){
			$time_dtr_table="union_attendance_mm_tables";
			$checkdate='AND a.covered_date BETWEEN "'. date('Y-m-d', strtotime($date_from)). '" and "'. date('Y-m-d', strtotime($date_to)).'"';
			$special_condition="";
			$order_by='order by a.employee_id,covered_date ASC';
		}elseif($report_area=="late"){
			$time_dtr_table="union_dtr_mm_tables";			
			$checkdate='AND a.logs_whole_date BETWEEN "'. date('Y-m-d', strtotime($date_from)). '" and "'. date('Y-m-d', strtotime($date_to)).'"';
			$special_condition="AND a.late>'0'";
			$order_by="";
		}elseif($report_area=="undertime"){
			$time_dtr_table="union_dtr_mm_tables";			
			$checkdate='AND a.logs_whole_date BETWEEN "'. date('Y-m-d', strtotime($date_from)). '" and "'. date('Y-m-d', strtotime($date_to)).'"';
			$special_condition="AND a.undertime>'0'";
			$order_by="";
		}elseif($report_area=="overbreak"){
			$time_dtr_table="union_dtr_mm_tables";			
			$checkdate='AND a.logs_whole_date BETWEEN "'. date('Y-m-d', strtotime($date_from)). '" and "'. date('Y-m-d', strtotime($date_to)).'"';
			$special_condition="AND a.overbreak>'0'";
			$order_by="";
		}elseif($report_area=="absent"){
			$time_dtr_table="union_dtr_mm_tables";			
			$checkdate='AND a.logs_whole_date BETWEEN "'. date('Y-m-d', strtotime($date_from)). '" and "'. date('Y-m-d', strtotime($date_to)).'"';
			$special_condition="AND a.regular_hour='absent'";
			$order_by="";
		}elseif($report_area=="regular_nd"){
			$time_dtr_table="union_dtr_mm_tables";			
			$checkdate='AND a.logs_whole_date BETWEEN "'. date('Y-m-d', strtotime($date_from)). '" and "'. date('Y-m-d', strtotime($date_to)).'"';
			$special_condition="AND a.regular_nd>'0'";
			$order_by="";
		}elseif($report_area=="overtime"){
			$time_dtr_table="union_dtr_mm_tables";			
			$checkdate='AND a.logs_whole_date BETWEEN "'. date('Y-m-d', strtotime($date_from)). '" and "'. date('Y-m-d', strtotime($date_to)).'"';
			$special_condition="AND (a.regular_ot>'0' OR a.restday_ot>'0' OR a.reg_hol_ot>'0' OR a.spec_hol_ot>'0' OR a.rd_reg_hol_ot>'0' OR 
			a.rd_spec_hol_ot>'0' OR a.regular_ot_nd>'0' OR a.restday_ot_nd>'0' OR a.regular_hol_ot_nd>'0' OR a.spec_hol_ot_nd>'0' OR a.rd_reg_hol_ot_nd>'0' OR a.rd_spec_hol_ot_nd>'0')";
			$order_by="";
		}else{
			$time_dtr_table="";
			$special_condition="";
			$order_by="";
		}

		

		$query = $this->db->query("SELECT a.*,b.* FROM $time_dtr_table a  INNER JOIN masterlist b ON(a.employee_id=b.employee_id) WHERE a.company_id='".$company."' $special_condition $checkdate $order_by");



		return $query->result();
	}

	public function checkCompPayPer($company_id){
		$query = $this->db->query("SELECT payroll_period_group_id,group_name,pay_type FROM payroll_period_group WHERE company_id='".$company_id."' ");
		return $query->result();
	}
	public function ws_filter_data($company,$division,$department,$section,$subsection,$location,$classification,$employment,$status,$yy,$mm,$dd,$type,$date_from,$date_to,$payroll_period,$report_area,$covered_month_from,$covered_month_to,$covered_year,$groupings_type)
	{

		if($type=='single_pp'){ // check processed DTR.

			$location_1 = substr_replace($location, "", -3 , 3);
			$location_2 = str_replace("-"," ",$location_1);
			$location_final = str_replace("ll","a.location=",$location_2);

			$classification_1 = substr_replace($classification, "", -3 , 3);
			$classification_2 = str_replace("-"," ",$classification_1);
			$classification_final = str_replace("cc","a.classification=",$classification_2);

			$employment_1 = substr_replace($employment, "", -3 , 3);
			$employment_2 = str_replace("-"," ",$employment_1);
			$employment_final = str_replace("ee","a.employment=",$employment_2);

			if($report_area=="late"){
				$spec_condition="AND b.late>'0'";
			}elseif($report_area=="undertime"){
				$spec_condition="AND b.undertime>'0'";
			}elseif($report_area=="overbreak"){
				$spec_condition="AND b.overbreak>'0'";
			}elseif($report_area=="absent"){
				$spec_condition="AND b.regular_hour='absent'";
			}elseif($report_area=="regular_nd"){
				$spec_condition="AND b.regular_nd>'0'";
			}elseif($report_area=="overtime"){
				$spec_condition="AND (b.regular_ot>'0' OR b.restday_ot>'0' OR  b.reg_hol_ot>'0' OR  b.spec_hol_ot>'0' OR  b.rd_reg_hol_ot>'0' OR  b.rd_spec_hol_ot>'0' OR  b.regular_ot_nd>'0' OR  b.restday_ot_nd>'0' OR  b.regular_hol_ot_nd>'0' OR  b.spec_hol_ot_nd>'0' OR  b.rd_reg_hol_ot_nd>'0' OR  b.rd_spec_hol_ot_nd>'0')";
			}else{
				$spec_condition="";
			}

					if($report_area=="time_summary"){
								$table_subject="union_time_summary_mm_tables";
								$unique_order_by="order by a.employee_id asc";
					}else{
								$table_subject="union_dtr_mm_tables";
								$unique_order_by="order by b.logs_whole_date asc";
					}

			$query=$this->db->query("SELECT b.*,a.* from masterlist a inner join $table_subject b on(a.employee_id=b.employee_id) where a.company_id='".$company."' and a.InActive='".$status."' AND b.payroll_period_id='".$payroll_period."' AND ($location_final) AND ($classification_final) AND ($employment_final) $spec_condition $unique_order_by ");


		}else{	


					$location_1 = substr_replace($location, "", -3 , 3);
					$location_2 = str_replace("-"," ",$location_1);
						
					$classification_1 = substr_replace($classification, "", -3 , 3);
					$classification_2 = str_replace("-"," ",$classification_1);

					$employment_1 = substr_replace($employment, "", -3 , 3);
					$employment_2 = str_replace("-"," ",$employment_1);

			if($report_area=="working_schedules"){
						$location_final = str_replace("ll","location_id=",$location_2);
						$classification_final = str_replace("cc","classification_id=",$classification_2);
						$employment_final = str_replace("ee","employment_id=",$employment_2);

						$this->db->select('*');				
						$this->db->from('working_schedule_filter'); 
			
						if($company=='All'){} else { $this->db->where('company_id',$company); }
						if($division=='All'){} else { $this->db->where('division_id',$division); }
						if($department=='All'){} else { $this->db->where('department_id',$department); }
						if($section=='All'){} else { $this->db->where('section_id',$section); }
						if($subsection=='All'){} else { $this->db->where('subsection_id',$subsection); }
						if($status=='All'){} else { $this->db->where('InActive',$status); }

						if($type=='single'){ 
							if($yy=='All'){} else { $this->db->where('yy',$yy); }
							if($mm=='All'){} else { $this->db->where('mm',$mm); }
							if($dd=='All'){} else { $this->db->where('dd',$dd); }
						}else if($type=='double')
						{
							$this->db->where('date BETWEEN "'. date('Y-m-d', strtotime($date_from)). '" and "'. date('Y-m-d', strtotime($date_to)).'"');
						}
			
					$this->db->where("(".$location_final." AND ".$classification_final." AND ".$employment_final." )");
					$this->db->order_by('date','asc');
					$query = $this->db->get();

			}elseif($report_area=="attendances"){

						$location_final = str_replace("ll","location=",$location_2);
						$classification_final = str_replace("cc","classification=",$classification_2);
						$employment_final = str_replace("ee","employment=",$employment_2);

				if($type=='single'){ 
					$date_clause="AND b.covered_date='".$yy."-$mm-".$dd."'";
					$attendance_table="attendance_".$mm; //
					$order_by="order by a.employee_id asc";
				}else if($type=='double'){
					$attendance_table="union_attendance_mm_tables"; //
					$date_clause='AND b.covered_date BETWEEN "'. date('Y-m-d', strtotime($date_from)). '" and "'. date('Y-m-d', strtotime($date_to)).'"';
					$order_by="order by a.employee_id,b.covered_date asc";
				}else{
					$date_clause="";
					$order_by="";
				}

				$query=$this->db->query("SELECT b.covered_date,b.time_in as actual_in,b.time_out as actual_out,b.break_1_out,b.break_1_in,b.lunch_break_out,b.lunch_break_in,b.break_2_out,b.break_2_in, a.* from masterlist a inner join $attendance_table b on(a.employee_id=b.employee_id) where a.company_id='".$company."' and a.InActive='".$status."' AND ($location_final) AND ($classification_final) AND ($employment_final)  $date_clause $order_by ");

			}elseif($report_area=="late" OR $report_area=="undertime" OR $report_area=="overbreak" OR $report_area=="absent" OR $report_area=="regular_nd" OR $report_area=="overtime"){

						$location_final = str_replace("ll","a.location=",$location_2);
						$classification_final = str_replace("cc","a.classification=",$classification_2);
						$employment_final = str_replace("ee","a.employment=",$employment_2);

						if($report_area=="late"){
							$special_cond="AND b.late>0";
						}elseif($report_area=="undertime"){
							$special_cond="AND b.undertime>0";
						}elseif($report_area=="overbreak"){
							$special_cond="AND b.overbreak>0";
						}elseif($report_area=="absent"){
							$special_cond="AND b.regular_hour='absent'";
						}elseif($report_area=="regular_nd"){
							$special_cond="AND b.regular_nd>0";
						}elseif($report_area=="overtime"){
							$special_cond="AND (b.regular_ot>'0' OR b.restday_ot>'0' OR  b.reg_hol_ot>'0' OR  b.spec_hol_ot>'0' OR  b.rd_reg_hol_ot>'0' OR  b.rd_spec_hol_ot>'0' OR  b.regular_ot_nd>'0' OR  b.restday_ot_nd>'0' OR  b.regular_hol_ot_nd>'0' OR  b.spec_hol_ot_nd>'0' OR  b.rd_reg_hol_ot_nd>'0' OR  b.rd_spec_hol_ot_nd>'0')";
						}else{
							$special_cond="";
						}

				if($type=='single'){ 
					$date_clause="AND b.logs_whole_date='".$yy."-$mm-".$dd."' $special_cond";
					$attendance_table="attendance_".$mm; //
					$order_by="order by a.employee_id asc";
				}else if($type=='double'){
					$attendance_table="union_attendance_mm_tables"; //
					$date_clause=''.$special_cond.' AND b.logs_whole_date BETWEEN "'. date('Y-m-d', strtotime($date_from)). '" and "'. date('Y-m-d', strtotime($date_to)).'"';
					$order_by="order by a.employee_id,b.logs_whole_date asc";
				}else{
					$date_clause="";
					$order_by="";
				}


		$query=$this->db->query("SELECT b.*,a.* from masterlist a inner join union_dtr_mm_tables b on(a.employee_id=b.employee_id) where a.company_id='".$company."' and a.InActive='".$status."' AND ($location_final) AND ($classification_final) AND ($employment_final) $date_clause $order_by ");

			}elseif($report_area=="time_summary"){

						$location_final = str_replace("ll","a.location=",$location_2);
						$classification_final = str_replace("cc","a.classification=",$classification_2);
						$employment_final = str_replace("ee","a.employment=",$employment_2);

				if($type=="by_month" OR $type=="by_year"){
					
					$check_mc=$this->payroll_period_myc($covered_month_from,$covered_month_to,$company,$covered_year,$type);
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
				}else{
						$check_pp_id="yc here";
				}

					$table_subject="union_time_summary_mm_tables";
					$unique_order_by="order by a.employee_id,b.payroll_period_id asc";


			$query=$this->db->query("SELECT b.payroll_period_id,c.month_cover,c.complete_from,c.complete_to,c.month_cover,b.*,a.* from masterlist a inner join $table_subject b on(a.employee_id=b.employee_id) inner join payroll_period c on(b.payroll_period_id=c.id) where a.company_id='".$company."' and a.InActive='".$status."' AND ($location_final) AND ($classification_final) AND ($employment_final) AND ($check_pp_id) $unique_order_by ");


			}elseif($report_area=="by_group_time_summary"){

				if($type=="group_by_month" OR $type=="group_by_year"){

						$check_mc=$this->payroll_period_myc($covered_month_from,$covered_month_to,$company,$covered_year,$type);
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


						$for_sum_fields=$this->check_by_group_time_summary($report_area);
						$fields_to_sum_and_select="";

						foreach($for_sum_fields as $sf){
							$fields_to_sum_and_select.="sum(b.".$sf->field_name.") as ".$sf->field_name.", ";
						}
							$fields_to_sum_and_select=substr($fields_to_sum_and_select, 0, -2); 

					if($groupings_type=="g_company"){ // group by company.
				
						$query=$this->db->query("SELECT a.company_name, $fields_to_sum_and_select from union_time_summary_mm_tables b inner join company_info a on(a.company_id=b.company_id) where ($check_pp_id) group by b.company_id");

					}elseif($groupings_type=="g_location"){ // group by location

						$query=$this->db->query("SELECT a.company_name,a.location_name,a.division_name,a.dept_name,a.section_name as section,a.subsection_name,a.employment_name as employment,a.classification_name as classification, $fields_to_sum_and_select from union_time_summary_mm_tables b inner join masterlist a on(a.employee_id=b.employee_id) where ($check_pp_id) group by a.company_id,a.location order by a.company_name");


					}elseif($groupings_type=="g_div"){ // group by division

						$query=$this->db->query("SELECT a.company_name,a.location_name,a.division_name,a.dept_name,a.section_name as section,a.subsection_name,a.employment_name as employment,a.classification_name as classification, $fields_to_sum_and_select from union_time_summary_mm_tables b inner join masterlist a on(a.employee_id=b.employee_id) where ($check_pp_id) group by a.company_id,a.division_id order by a.company_name");

					}elseif($groupings_type=="g_dept"){ // group by department

						$query=$this->db->query("SELECT a.company_name,a.location_name,a.division_name,a.dept_name,a.section_name as section,a.subsection_name,a.employment_name as employment,a.classification_name as classification, $fields_to_sum_and_select from union_time_summary_mm_tables b inner join masterlist a on(a.employee_id=b.employee_id) where ($check_pp_id) group by a.company_id,a.department order by a.company_name");

					}elseif($groupings_type=="g_sect"){ // group by section

						$query=$this->db->query("SELECT a.company_name,a.location_name,a.division_name,a.dept_name,a.section_name as section,a.subsection_name,a.employment_name as employment,a.classification_name as classification, $fields_to_sum_and_select from union_time_summary_mm_tables b inner join masterlist a on(a.employee_id=b.employee_id) where ($check_pp_id) group by a.company_id,a.section order by a.company_name");

					}elseif($groupings_type=="g_subsect"){ // group by sub section

						$query=$this->db->query("SELECT a.company_name,a.location_name,a.division_name,a.dept_name,a.section_name as section,a.subsection_name,a.employment_name as employment,a.classification_name as classification, $fields_to_sum_and_select from union_time_summary_mm_tables b inner join masterlist a on(a.employee_id=b.employee_id) where ($check_pp_id) group by a.company_id,a.subsection order by a.company_name");

					}elseif($groupings_type=="g_employ"){ // group by employment

						$query=$this->db->query("SELECT a.company_name,a.location_name,a.division_name,a.dept_name,a.section_name as section,a.subsection_name,a.employment_name as employment,a.classification_name as classification, $fields_to_sum_and_select from union_time_summary_mm_tables b inner join masterlist a on(a.employee_id=b.employee_id) where ($check_pp_id) group by a.company_id,a.employment order by a.company_name");

					}elseif($groupings_type=="g_class"){ // group by classification

						$query=$this->db->query("SELECT a.company_name,a.location_name,a.division_name,a.dept_name,a.section_name as section,a.subsection_name,a.employment_name as employment,a.classification_name as classification, $fields_to_sum_and_select from union_time_summary_mm_tables b inner join masterlist a on(a.employee_id=b.employee_id) where ($check_pp_id) group by a.company_id,a.classification order by a.company_name");

					}else{}




				}else{

				}
				
			}else{

			}


		}


		return $query->result();
	}

	public function check_by_group_time_summary($report_area){
		$query=$this->db->query("SELECT * from crystal_report_time where topic='".$report_area."' and sum_me='1'");
		return $query->result();
	}


	public function payroll_period_myc($covered_month_from,$covered_month_to,$company,$covered_year,$type) // myc= month & year cover
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

		//echo "SELECT id from payroll_period where InActive='0' $mc $check_comp AND year_cover='".$covered_year."' order by month_cover ASC";

		$query=$this->db->query("SELECT id from payroll_period where InActive='0' $mc $check_comp AND year_cover='".$covered_year."' order by month_cover ASC");

		return $query->result();

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
		$this->db->join('crystal_report_time','crystal_report_time.report_time_id=report_fields.report_time_id');
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
		return $query->result();
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
