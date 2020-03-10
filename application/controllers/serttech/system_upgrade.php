<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 

class System_upgrade extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model('serttech/system_upgrade_model');
		$this->load->model('serttech/serttech_login_model');
		$this->load->model('general_model');

		$this->hrwebone_db = $this->load->database('hrwebone_db', TRUE); // TRUE

		General::variable();
	}
	



	public function index(){

		$this->data['message'] = $this->session->flashdata('message');	
		$this->data['serttech_account'] = $this->serttech_login_model->getUserLoggedIn($this->input->post('username'));

		$this->data['active_forms']=$this->system_upgrade_model->v1_get_active_forms();
		$this->data['pay_period']=$this->system_upgrade_model->v1_get_payroll_period();

		$this->load->view('serttech/system_upgrade/index',$this->data);	
	}

	public function get_v1_fm_details($val,$company_id){

		if($val=="holiday"){
			$v1_hol=$this->system_upgrade_model->v1_get_holiday_list();
			$v1_hol_loc=$this->system_upgrade_model->v1_get_holiday_location();
			$query=$this->db->query("DELETE FROM holiday_list");
			$query=$this->db->query("DELETE FROM holiday_list_location");
			if(!empty($v1_hol)){
				foreach($v1_hol as $h){
					if($h->tp=="Regular"){
						$holtype="RH";
					}else{
						$holtype="SNW";
					}

					$holdata= array(
						'hol_id'			=>	$h->h_id,
						'company_id'			=>	$company_id,
						'holiday'				=>	$h->holiday,
						'month'					=>	$h->mm,
						'day'					=>	$h->dd,
						'year'					=>	date('Y'),
						'type'					=>	$holtype,
						'InActive'				=>	'0',
						'log_date'				=>	date('Y-m-d H:i:s')
					);

					$this->system_upgrade_model->insert_holidays($holdata);
				}

				if(!empty($v1_hol_loc)){
					foreach($v1_hol_loc as $l){
						$holocdata = array (
							'hol_id'			=>	$l->h_id,
							'location'			=>	$l->loc,
							'year'				=>	date('Y'),
							'log_date'			=>	date('Y-m-d H:i:s')
						);

						$this->system_upgrade_model->insert_holiday_location($holocdata);
					}
				}else{}



				echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully migrate holiday list details</div>";

			}else{}

		}elseif($val=="bank"){
				$v1_bank=$this->system_upgrade_model->v1_get_bank();
				if(!empty($v1_bank)){
					$query=$this->db->query("DELETE FROM bank");
					foreach($v1_bank as $b){
						$b_id=$b->b_id;
						$bank_code=$b->bank_code;			
						$bank_name=$b->bank_name;
						$bank_account=$b->bank_account;

						$insert_bank_data = array(
							'bank_id'			=> $b_id,
							'bank_code'			=> $bank_code,
							'bank_name'			=> $bank_name,
							'account_no'			=> $bank_account

						);
						$insert_department=$this->system_upgrade_model->insert_bank($insert_bank_data);
					}
				echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred bank details</div>";
				}else{
				echo	"<div class='alert alert-danger'><i class='fa fa-times'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  No data transferred .</div>";	
				}

		}elseif($val=="position"){
				$v1_position=$this->system_upgrade_model->v1_get_position();
				if(!empty($v1_position)){
					$query=$this->db->query("DELETE FROM position");
					foreach($v1_position as $p){
						$pos_id=$p->pos_id;
						$pos=$p->pos;
						$ds=$p->ds;


						$insert_position_data = array(
							'position_id'			=> $pos_id,
							'position_name'			=> $pos,
							'description'			=> $ds,
							'InActive'				=> '0',
							'isdisable'				=> '0',
							'isEmployer'			=> '0'

						);
						$insert_department=$this->system_upgrade_model->insert_position($insert_position_data);
					}
				echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred Position details</div>";
				}else{
				echo	"<div class='alert alert-danger'><i class='fa fa-times'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  No data transferred .</div>";	
				}
		}elseif($val=="department"){
				$v1_department=$this->system_upgrade_model->v1_get_department();
				if(!empty($v1_department)){
					$query=$this->db->query("DELETE FROM department");
					foreach($v1_department as $p){
						$dept_name=$p->dept_name;
						$dept_id=$p->dept_id;
						$dcode=$p->dcode;


						$insert_dept_data = array(
							'department_id'			=> $dept_id,
							'company_id'			=> $company_id,
							'dept_code'				=> $dcode,
							'dept_name'				=> $dept_name,
							'InActive'				=> '0',
							'division_id'			=> '0',
							'isDisable'			=> '0'

						);
						$insert_department=$this->system_upgrade_model->insert_department($insert_dept_data);
					}
				echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred Department details</div>";
				}else{
				echo	"<div class='alert alert-danger'><i class='fa fa-times'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  No data transferred .</div>";	
				}
		}elseif($val=="section"){
				$v1_section=$this->system_upgrade_model->v1_get_section();
				if(!empty($v1_section)){
					$query=$this->db->query("DELETE FROM section");
					foreach($v1_section as $p){
						$sect_id=$p->sect_id;
						$section_name=$p->section_name;
						$dept=$p->dept;


						$insert_sect_data = array(
							'section_id'			=> $sect_id,
							'section_name'			=> $section_name,
							'department_id'				=> $dept,
							'wSubsection'				=> '0',
							'InActive'				=> '0',
							'isDisable'			=> '0'

						);
						$insert_section=$this->system_upgrade_model->insert_section($insert_sect_data);
					}
				echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred Section details</div>";
				}else{
				echo	"<div class='alert alert-danger'><i class='fa fa-times'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  No data transferred .</div>";	
				}
		}elseif($val=="classification"){
				$v1_classification=$this->system_upgrade_model->v1_get_classification();
				if(!empty($v1_classification)){
					$query=$this->db->query("DELETE FROM classification");
					foreach($v1_classification as $p){
						$class_id=$p->class_id;
						$class=$p->class;
						$ds=$p->ds;
						$lv=$p->lv;
						$ot=$p->ot;
						$late=$p->late;
						$ut=$p->ut;
						$late_deduction=$p->late_deduction;
						$acc=$p->acc;


						$insert_class_data = array(
							'classification_id'			=> $class_id,
							'company_id'			=> $company_id,
							'classification'				=> $class,
							'description'				=> $ds,
							'ranking'				=> $class_id,
							'InActive'			=> '0',
							'isDisable'			=> '0'

						);
						$insert_classification=$this->system_upgrade_model->insert_classification($insert_class_data);
					}
				echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred Classification details</div>";
				}else{
				echo	"<div class='alert alert-danger'><i class='fa fa-times'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  No data transferred .</div>";	
				}
		}elseif($val=="employment"){
				$v1_employment=$this->system_upgrade_model->v1_get_employment();
				if(!empty($v1_employment)){
					$query=$this->db->query("DELETE FROM employment");
					foreach($v1_employment as $p){
						$e_id=$p->e_id;
						$emp=$p->emp;
	
						$insert_employment_data = array(
							'employment_id'			=> $e_id,
							'employment_name'			=> $emp,
							'contract_alert_base'				=> '0',
							'InActive'			=> '0',
							'isDisable'			=> '0'

						);
						$insert_employment=$this->system_upgrade_model->insert_employment($insert_employment_data);
					}
				echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred Employment details</div>";
				}else{
				echo	"<div class='alert alert-danger'><i class='fa fa-times'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  No data transferred .</div>";	
				}
		}elseif($val=="company"){
				$v1_company=$this->system_upgrade_model->v1_get_company();
				if(!empty($v1_company)){
					$query=$this->db->query("DELETE FROM company_info");
					foreach($v1_company as $p){
						$company_id=$p->company_id;
						$company_code=$p->company_code;
						$company_name=$p->company_name;
						$address=$p->address;
						$cn1=$p->cn1;
						$cn2=$p->cn2;
						$tin_no=$p->tin_no;
						$sss=$p->sss;
						$pagibig_no=$p->pagibig_no;
						$mission=$p->mission;
						$vision=$p->vision;
						$company_logo=$p->company_logo;
						$company_history=$p->company_history;
						$philhealth=$p->philhealth;
						$zip_code=$p->zip_code;
						if($company_code==""){
							$company_code=$company_name;
						}else{

						}
						$insert_company_data = array(
							'company_id'			=> $company_id,
							'company_name'			=> $company_name,
							'company_address'		=> $address,
							'zip_code'				=> $zip_code,
							'company_contact_no'	=> $cn1,
							'main_tel_no'			=> $cn2,
							'area_code'				=> '',
							'TIN'					=> $tin_no,
							'philhealth_number'		=> $philhealth,
							'pagibig_id_number'		=> $pagibig_no,
							'sss_number'		=> $sss,
							'company_code'		=> $company_code,
							'logo_width'		=> '140',
							'logo_height'			=> '65',
							'InActive'						=> '0',
							'isDisable'						=> '0',
							'is_this_recruitment_employer'			=> '0',
							'wDivision'								=> '0'
						);
						$insert_company_data=$this->system_upgrade_model->insert_company_data($insert_company_data);
					}
				echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred Company details</div>";
				}else{
				echo	"<div class='alert alert-danger'><i class='fa fa-times'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  No data transferred .</div>";	
				}
		}elseif($val=="location"){
				$v1_location=$this->system_upgrade_model->v1_get_location();
				if(!empty($v1_location)){
					$query=$this->db->query("DELETE FROM location");
					$query=$this->db->query("DELETE FROM company_location");
					foreach($v1_location as $p){
						$l_id=$p->l_id;
						$loc=$p->loc;
	
						$insert_location_data = array(
							'location_id'			=> $l_id,
							'location_name'			=> $loc,
							'description'			=> '',
							'InActive'			=> '0'

						);
						$comp_loc = array(
							'location_id'			=> $l_id,
							'company_id'			=> $company_id,
							'isDisable'			=> '0'

						);
						
						$insert_location=$this->system_upgrade_model->insert_location($insert_location_data);
						$insert_comp_location=$this->system_upgrade_model->insert_company_location($comp_loc);
					}
				echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred Location details</div>";
				}else{
				echo	"<div class='alert alert-danger'><i class='fa fa-times'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  No data transferred .</div>";	
				}
		}else{

		}


	}

	public function transfer_sect_mngr($val,$company_id){
		$sect_mngr=$this->system_upgrade_model->v1_section_manager($val);


		if(!empty($sect_mngr)){
			$query=$this->db->query("DELETE FROM section_manager WHERE company_id='".$company_id."' ");		
				$comp_loc=$this->system_upgrade_model->v1_get_location();
				foreach($comp_loc as $p){
							$location_id=$p->l_id;
							foreach($sect_mngr as $s){
								$emp_id=$s->emp_id;
								$sc=$s->sc;
								$dp=$s->dp;
								$sect_mngr = array(
									'company_id'	=>	$company_id,	
									'division'		=>	'0',	
									'department'	=>	$dp,	
									'section'		=>	$sc,		
									'subsection'	=>	'0',	
									'location'		=>	$location_id,	
									'manager'		=>	$emp_id,	
									'InActive'		=>	'0'	
								);
								$insert_sect_mngr=$this->system_upgrade_model->insert_sect_mngr($sect_mngr);

							}
				}
				echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred Section Managers details</div>";
		}else{
				echo	"<div class='alert alert-danger'><i class='fa fa-times'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  No data transferred .</div>";				
		}

	}

	public function transfer_form_approvers($val,$company_id){
		$form_approver=$this->system_upgrade_model->v1_form_approver($val);
				if($val=="2"){
					$form_identification="HR002";//leave
				}elseif($val=="8"){
					$form_identification="HR008";//ot
				}elseif($val=="14"){
					$form_identification="HR014";//Official Business Form
				}elseif($val=="28"){
					$form_identification="HR025";//Timekeeping Complaint
				}else{
					$form_identification=$val;
				}

		$query=$this->db->query("DELETE FROM transaction_approvers WHERE form_identification='".$form_identification."' ");		

		if($form_identification=="HR002"){
				$v1_leave=$this->system_upgrade_model->v1_get_leave_type();
				if(!empty($v1_leave)){
					foreach($v1_leave as $v){

						if($v->act=="1"){//pag active pa yung leave type
								if(!empty($form_approver)){
									foreach($form_approver as $f){
										$dp=$f->dp;
										$sc=$f->sc;
										$pri=$f->pri;
										$emp_class=$f->emp_class;
										$loc=$f->loc;
										$emp_id=$f->emp_id;

										$approvers_data = array(
											'company'				=> $company_id,	
											'location'				=> $loc,	
											'form_identification'	=> $form_identification,	
											'division_id'			=> 'not_included',	
											'department'			=> $dp,	
											'section'				=> $sc,	
											'sub_section'			=> 'not_included',	
											'classification'		=> $emp_class,	
											'approver'				=> $emp_id,	
											'approval_category'		=> 'set',	
											'approval_level'		=> $pri,	
											'leave_type'			=> $v->lv_id,	
											'position'				=> '',	
											'setting'				=> 'all',	
											'InActive'				=> '0',	
											'date_deleted'			=> date('Y-m-d H:i:s'),	
											'admin_deleted'			=> '',	
											'date_created'			=> date('Y-m-d H:i:s')
										);
										$insert_approvers_data=$this->system_upgrade_model->insert_approvers_data($approvers_data);
									}
										echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred Approvers details</div>";
								}else{
										echo	"<div class='alert alert-danger'><i class='fa fa-times'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  No data transferred .</div>";	
								}
						}else{							
						}

						 
					}
				}else{

				}
		}else{
					if(!empty($form_approver)){
						foreach($form_approver as $f){
							$dp=$f->dp;
							$sc=$f->sc;
							$pri=$f->pri;
							$emp_class=$f->emp_class;
							$loc=$f->loc;
							$emp_id=$f->emp_id;

							$approvers_data = array(
								'company'				=> $company_id,	
								'location'				=> $loc,	
								'form_identification'	=> $form_identification,	
								'division_id'			=> 'not_included',	
								'department'			=> $dp,	
								'section'				=> $sc,	
								'sub_section'			=> 'not_included',	
								'classification'		=> $emp_class,	
								'approver'				=> $emp_id,	
								'approval_category'		=> 'set',	
								'approval_level'		=> $pri,	
								'leave_type'			=> 'not_included',	
								'position'				=> '',	
								'setting'				=> 'all',	
								'InActive'				=> '0',	
								'date_deleted'			=> date('Y-m-d H:i:s'),	
								'admin_deleted'			=> '',	
								'date_created'			=> date('Y-m-d H:i:s')
							);
							$insert_approvers_data=$this->system_upgrade_model->insert_approvers_data($approvers_data);
						}
							echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred Approvers details</div>";
					}else{
							echo	"<div class='alert alert-danger'><i class='fa fa-times'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  No data transferred .</div>";	
					}
		}


		

	}	



	public function transfer_attendances($val,$company_id){

		$emp=$this->system_upgrade_model->v2_get_act_inact_masterlist($company_id);
		if(!empty($emp)){
								$mc = sprintf("%02d", $val);
								$tables="attendance_".$mc;

			$query=$this->db->query("DELETE FROM $tables  WHERE company_id='".$company_id."' ");	

				foreach($emp as $e){
				
						$emp_att=$this->system_upgrade_model->v1_get_attendances($val,$company_id,$e->employee_id);
						if(!empty($emp_att)){
							foreach($emp_att as $a){
								$time_in=$a->t_in;
								$time_out=$a->t_out;
								$logs_month=$a->mm;
								$logs_day=$a->dd;
								$logs_year=$a->yy;
								$date_out=$a->d_out;

								$covered_date=$logs_year."-".$logs_month."-".$logs_day;
								$time_in_date=$covered_date;
								$time_out_date=$covered_date;
								if($date_out=="2"){

									$a = new DateTime($covered_date);
									$a->modify('+1 day');
									$time_out_date=$a->format('Y-m-d');

								}else{

								}
								

								$time_in=substr($time_in, 0,5);
								$time_out=substr($time_out, 0,5);

								$attendances_array = array(
									'company_id'		=>	$company_id,
									'employee_id'		=>	$e->employee_id,
									'time_in'			=>	$time_in,
									'time_out'			=>	$time_out,
									'logs_month'		=>	$logs_month,
									'logs_day'			=>	$logs_day,
									'logs_year'			=>	$logs_year,
									'covered_year'		=>	$logs_year,
									'covered_date'		=>	$covered_date,
									'time_in_date'		=>	$time_in_date,
									'time_out_date'		=>	$time_out_date,
									'entry_type'		=>	'migrator of version 1'

								);

								$this->system_upgrade_model->insert_attendances($attendances_array,$tables);

								

							}
						}else{
							//echo "walang data";
						}	
				}
			echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully Saved Attendance of $mc</div>";

		}else{}
	}



	public function get_v1_dtr_summary_2($val,$company_id){


		$emp=$this->system_upgrade_model->v2_get_act_inact_masterlist($company_id);
		$pp_det=$this->system_upgrade_model->v1_get_payroll_period_row($val);
		$payroll_period_id=$pp_det->p_id;
		$month_cover=$pp_det->month_cover;

		$mc = sprintf("%02d", $month_cover);
		$tables="time_summary_".$mc;

		//$query=$this->db->query("DELETE FROM $tables  ");		

		if(!empty($emp)){
			
				foreach($emp as $e){
					//if($e->employee_id=="990495"){

					$emp_dtr=$this->system_upgrade_model->v1_get_dtr_summary($val,$company_id,$e->employee_id);
					if(!empty($emp_dtr)){

									$pay_code=$emp_dtr->pay_code;
									$day_cola=$emp_dtr->day_cola;

									$reg_hrs=$emp_dtr->reg_hrs;
									$assume_days=$reg_hrs/8;
									$reg_rd=$emp_dtr->reg_rd;
									$reg_rh=$emp_dtr->reg_rh;
									$reg_sh=$emp_dtr->reg_sh;
									$reg_rh_rd=$emp_dtr->reg_rh_rd;
									$reg_sh_rd=$emp_dtr->reg_sh_rd;
									$reg_rd_rh_tp2=$emp_dtr->reg_rd_rh_tp2;

									$ab=$emp_dtr->ab;
									$tardi=$emp_dtr->tardi;
									$ob=$emp_dtr->ob;
									$ut=$emp_dtr->ut;
									
									$ut_occ=$emp_dtr->ut_occ;
									$tardi_occ=$emp_dtr->tardi_occ;
									$ovr_brk=$emp_dtr->ovr_brk;

									$leave_days=$emp_dtr->leave_days;
									$present_days=$emp_dtr->present_days;
									$reg_present_days=$emp_dtr->reg_present_days;
									$absent_days=$emp_dtr->absent_days;

									$user_id=$emp_dtr->user_id;
									$encoding=$emp_dtr->encoding;
									$lock_=$emp_dtr->lock_;
									$reg_hol_no_att=$emp_dtr->reg_hol_no_att;
									$holiday=$emp_dtr->holiday;
									$atro=$emp_dtr->atro;
									$leave_=$emp_dtr->leave_;
									$actual_hours=$emp_dtr->actual_hours;
									$emp_dtr->builtin_ot;
									$emp_dtr->training_ot;
									$emp_dtr->meal;
									$emp_dtr->approved_leave_without_pay;
									$emp_dtr->emp_id;
									// $emp_dtr->pay_code1;
									$reg_nd_hrs=$emp_dtr->reg_nd_hrs;
									$reg_nd_rd=$emp_dtr->reg_nd_rd;
									$reg_nd_sh=$emp_dtr->reg_nd_sh;
									$reg_nd_rh=$emp_dtr->reg_nd_rh;
									$reg_nd_rh_rd=$emp_dtr->reg_nd_rh_rd;
									$reg_nd_sh_rd=$emp_dtr->reg_nd_sh_rd;								
									// $emp_dtr->pay_code2;
									$ot_hrs=$emp_dtr->ot_hrs;
									$ot_rd=$emp_dtr->ot_rd;
									$ot_sh=$emp_dtr->ot_sh;
									$ot_rh=$emp_dtr->ot_rh;
									$ot_rh_rd=$emp_dtr->ot_rh_rd;
									$ot_sh_rd=$emp_dtr->ot_sh_rd;					
									// $emp_dtr->pay_code3;
									$ot_nd_hrs=$emp_dtr->ot_nd_hrs;
									$ot_nd_rd=$emp_dtr->ot_nd_rd;
									$ot_nd_sh=$emp_dtr->ot_nd_sh;
									$ot_nd_rh=$emp_dtr->ot_nd_rh;
									$ot_nd_rh_rd=$emp_dtr->ot_nd_rh_rd;
									$ot_nd_sh_rd=$emp_dtr->ot_nd_sh_rd;
			$dtr_summary=array(
				'company_id'								=>		$company_id,
				'payroll_period_id'							=>		$payroll_period_id,
				'employee_id'								=>		$e->employee_id,
				'salary_rate'								=>		null,
				'pay_type'									=>		'3',//semi monthly
				'leave_reg_hrs'								=>		'0',

				'total_regular_hours'						=>		$reg_hrs,
				'total_regular_hrs_restday'					=>		$reg_rd,
				'total_regular_hrs_reg_holiday'				=>		$reg_rh,
				'total_regular_hrs_reg_holiday_t1'			=>		$reg_rh_rd,
				'total_regular_hrs_reg_holiday_t2'			=>		$reg_rd_rh_tp2,
				'total_regular_hrs_spec_holiday'			=>		$reg_sh,
				'total_restday_regular_hrs_spec_holiday'	=>		$reg_sh_rd,

				'total_regular_nd'							=>		$reg_nd_hrs,
				'total_restday_nd'							=>		$reg_nd_rd,
				'total_reg_holiday_nd'						=>		$reg_nd_rh,
				'total_restday_reg_holiday_nd'				=>		$reg_nd_rh_rd,
				'total_spec_holiday_nd'						=>		$reg_nd_sh,
				'total_restday_spec_holiday_nd'				=>		$reg_nd_sh_rd,

				'total_regular_overtime'					=>		$ot_hrs,
				'total_restday_overtime'					=>		$ot_rd,
				'total_reg_holiday_overtime'				=>		$ot_rh,
				'total_restday_reg_holiday_overtime'		=>		$ot_rh_rd,
				'total_spec_holiday_overtime'				=>		$ot_sh,
				'total_restday_spec_holiday_overtime'		=>		$ot_sh_rd,

				'total_regular_overtime_nd'					=>		$ot_nd_hrs,
				'total_restday_overtime_nd'					=>		$ot_nd_rd,
				'total_reg_holiday_overtime_nd'				=>		$ot_nd_rh,
				'total_restday_reg_holiday_overtime_nd'		=>		$ot_nd_rh_rd,
				'total_spec_holiday_overtime_nd'			=>		$ot_nd_sh,
				'total_restday_spec_holiday_overtime_nd'	=>		$ot_nd_sh_rd,

				'absences_total'								=>		$ab,
				'undertime_total'								=>		$ut,
				'tardiness_total'									=>		$tardi,
				'overbreak_total'									=>		$ovr_brk,

				'absences_occurence'									=>		$ab,
				'undertime_occurence'									=>		$ut_occ,
				'tardiness_occurence'									=>		$tardi_occ,
				'overbreak_occurence'									=>		$ob,

				'date_process'											=>		null,
				'system_user_id'										=>		null,
				'complete_logs_present_occ'								=>		$assume_days,
				'with_tk_logs_present_occ'								=>		null,
				'with_ob_logs_present_occ'								=>		null,
				'with_leave_present_occ'								=>		null,
				'restday_w_logs'										=>		null,
				'restday_wo_logs'										=>		null,
				'reg_holiday_w_logs'									=>		null,
				'reg_holiday_wo_logs'									=>		null,
				'snw_holiday_w_logs'									=>		null,
				'snw_holiday_wo_logs'									=>		null,
				'rd_reg_holiday_w_logs'									=>		null,
				'rd_reg_holiday_wo_logs'								=>		null,
				'rd_snw_holiday_w_logs'									=>		null,
				'rd_snw_holiday_wo_logs'								=>		null,
				'complete_logs_present_occ_ref'							=>		null,
				'with_tk_logs_present_occ_ref'							=>		null,
				'with_ob_logs_present_occ_ref'							=>		null,
				'with_leave_present_occ_ref'							=>		null,
				'restday_w_logs_ref'									=>		null,
				'restday_wo_logs_ref'									=>		null,
				'reg_holiday_w_logs_ref'								=>		null,
				'reg_holiday_wo_logs_ref'								=>		null,
				'snw_holiday_w_logs_ref'								=>		null,
				'snw_holiday_wo_logs_ref'								=>		null,
				'rd_reg_holiday_w_logs_ref'								=>		null,
				'rd_reg_holiday_wo_logs_ref'							=>		null,
				'rd_snw_holiday_w_logs_ref'								=>		null,
				'rd_snw_holiday_wo_logs_ref'							=>		null,
				'with_manual_dtr_only'									=>		null,
				'is_manual_dtr'											=>		'1',
				'approve_leave_wopay_count'								=>		null,
				'approve_leave_wpay_count'								=>		null,
				'tracker_absent'										=>		null,
				'tracker_regular_hours'									=>		null
			);


			$insert_dtr_summary=$this->system_upgrade_model->insert_dtr_summary($dtr_summary,$tables);


							}else{}

					//}else{}
				}
								echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully Saved DTR Summary</div>";

		}else{
		}
		
		
	}
	public function get_v1_dtr_summary($val,$company_id){
		$v1_payroll_period=$this->system_upgrade_model->v1_get_payroll_period();

		//create payroll period group
		//enroll employees to that  payroll period group

		if($val=="payroll_period_group"){

			$query=$this->db->query("DELETE FROM payroll_period_group");
			$pp_group=array(
				'payroll_period_group_id'	=>	$company_id,
				'pay_type'					=>	'3',// semi monthly
				'company_id'				=>	$company_id,
				'group_name'				=>	'Payroll Period Team',
				'group_description'			=>	'Payroll Period Team',
				'InActive'					=>	'0',
				'date_added'				=>	date('Y-m-d H:i:s'),
				'last_modify'				=>	null,
				'last_status_movement'		=>	date('Y-m-d H:i:s')
			);

			$insert_pp_group=$this->system_upgrade_model->insert_pp_group($pp_group);

			echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully Created Payroll Period Group</div>";


		}elseif($val=="payroll_period_group_members"){
			$query=$this->db->query("DELETE FROM payroll_period_employees WHERE payroll_period_group_id='".$company_id."' ");

			$all_emp=$this->system_upgrade_model->v2_get_act_inact_masterlist($company_id);
			if(!empty($all_emp)){
				foreach($all_emp as $e){
					if($e->employee_type=="masterlist"){
						$InActive="0";

						$pp_employee = array(
							'payroll_period_group_id'	=>	$company_id,
							'employee_id'				=>	$e->employee_id,
							'InActive'					=>	$InActive,
							'date_enrolled'				=>	date('Y-m-d H:i:s'),
							'last_modify'				=>	null,
							'last_status_movement'		=>	null,
							'remarks'					=>	'initially enrolled from version 1'
						);	


					}else{//masterlist_inactive
						$InActive="1";
					}


					
					$insert_pp_employee=$this->system_upgrade_model->insert_pp_employee($pp_employee);				
				}
						echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully Enrolled Payroll Period Members</div>";

			}else{
						echo	"<div class='alert alert-danger'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>No Employee Found</div>";

			}


			
		}elseif($val=="payroll_period"){

		if(!empty($v1_payroll_period)){
					$query=$this->db->query("DELETE FROM payroll_period");
					foreach($v1_payroll_period as $pp){
						$p_id=$pp->p_id;
						$pay_code=$pp->pay_code;
						$m1=$pp->m1;
						$d1=$pp->d1;
						$y1=$pp->y1;

						$m2=$pp->m2;
						$d2=$pp->d2;
						$y2=$pp->y2;
						$cut_off=$pp->cut_off;
						$p_day=$pp->p_day;

						$year_cover=$pp->year_cover;
						$month_cover=$pp->month_cover;
						$pay_date=$pp->pay_date;
						//09/13/2017
						$pay_date_mm=substr($pay_date, 0,2);
						$pay_date_dd=substr($pay_date, 3,2);
						$pay_date_yy=substr($pay_date, 6,4);
						$pdate=$pay_date_yy."-".$pay_date_mm."-".$pay_date_dd;

						$pp_data = array(
							'id'						=>  $p_id,
							'pay_code'						=>  $pay_code,
							'payroll_period_group_id'		=>  '1',// one payroll period group si version 1
							'pay_type'						=>  '3',
							'month_from'					=>  $m1,
							'day_from'						=>  $d1,
							'year_from'						=>  $y1,
							'complete_from'					=>  $y1.'-'.$m1.'-'.$d1,
							'month_to'						=>  $m2,
							'day_to'						=>  $d2,
							'year_to'						=>  $y2,
							'complete_to'					=>  $y2.'-'.$m2.'-'.$d2,
							'cut_off'						=>  $cut_off,
							'cut_off_day'					=>  $p_day,
							'pay_date'						=>  $pdate,
							'year_cover'					=>  $year_cover,
							'month_cover'					=>  $month_cover,
							'no_of_days'					=>  '',
							'description'					=>  'from version 1',
							'InActive'						=>  '0',
							'company_id'					=>  $company_id,
							'IsLock'						=>  '0',
							'IsDisabled'					=>  '0',
							'will_early_cutoff'					=>  '0',
							'early_cutoff_start_date'				=>  NULL,
							'lock_plotting_of_sched'				=>  '0'
						);				
						$insert_pp_data=$this->system_upgrade_model->insert_pp_data($pp_data);
					}
						echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred Payroll Period details</div>";

				}else{
						echo	"<div class='alert alert-danger'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  No data transferred</div>";
				}
		}elseif($val=="fixed_schedule"){
			$fixed_sg=$this->system_upgrade_model->v1_get_fix_sched_group();

			$query=$this->db->query("DELETE FROM fixed_working_schedule_group");
			$query=$this->db->query("DELETE FROM fixed_working_schedule_members");
					
			if(!empty($fixed_sg)){
				foreach($fixed_sg as $g){
				//insert group name
					$g->g_id;
					$group_name=$g->gname;
					
					$c_mm=substr($g->dc, 0,2);
					$c_dd=substr($g->dc, 3,2);
					$c_yy=substr($g->dc, 6,4);
					$date_created="$c_yy-$c_mm-$c_dd";
					$system_user=$g->user_id;

					$fixed_sched_group_data =array(
						'id'				=>	$g->g_id,
						'group_name'			=>	$group_name,
						'company_id'			=>	$company_id,
						'system_user'			=>	$system_user,
						'date_created'			=>	$date_created,
						'InActive'			=>	'0'
					);
					$this->system_upgrade_model->insert_fixed_sched_group($fixed_sched_group_data);
					//then insert its members
					$fixed_sched_mem=$this->system_upgrade_model->v1_get_fix_sched_members($g->g_id);
					if(!empty($fixed_sched_mem)){
						foreach($fixed_sched_mem as $f){
							$f->emp_id;

							if($f->mon!="Rest day"){
								$mon=substr($f->mon, 0,11);
								$mon=str_replace("-"," to ",$mon);
							}else{$mon="restday";}
							if($f->tue!="Rest day"){
								$tue=substr($f->tue, 0,11);
								$tue=str_replace("-"," to ",$tue);
							}else{$tue="restday";}
							if($f->wed!="Rest day"){
								$wed=substr($f->wed, 0,11);
								$wed=str_replace("-"," to ",$wed);
							}else{$wed="restday";}
							if($f->thu!="Rest day"){
								$thu=substr($f->thu, 0,11);
								$thu=str_replace("-"," to ",$thu);
							}else{$thu="restday";}
							if($f->fri!="Rest day"){
								$fri=substr($f->fri, 0,11);
								$fri=str_replace("-"," to ",$fri);
							}else{$fri="restday";}
							if($f->sat!="Rest day"){
								$sat=substr($f->sat, 0,11);
								$sat=str_replace("-"," to ",$sat);
							}else{$sat="restday";}
							if($f->sun!="Rest day"){
								$sun=substr($f->sun, 0,11);
								$sun=str_replace("-"," to ",$sun);
							}else{$sun="restday";}

							$fixed_sched_group_members = array(
								'group_id'		=>	$g->g_id,
								'company_id'		=>	$company_id,
								'employee_id'		=>	$f->emp_id,
								'mon'		=>	$mon,
								'tue'		=>	$tue,
								'wed'		=>	$wed,
								'thu'		=>	$thu,
								'fri'		=>	$fri,
								'sat'		=>	$sat,
								'sun'		=>	$sun,
								'system_user'		=>	$system_user,
								'date_added'		=>	$date_created,
								'InActive'		=>	'0'
							);

							$this->system_upgrade_model->insert_fixed_sched_members($fixed_sched_group_members);

						}
					}else{

					}
					

				}

						echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred Fixed Schedule Details</div>";

			}else{

			}

			//echo "get all fixed sched";
		}elseif($val=="shift_table"){
			$shift_table=$this->system_upgrade_model->v1_get_shift_table();

			$query=$this->db->query("DELETE FROM working_schedule_ref_complete");
			if(!empty($shift_table)){
				foreach($shift_table as $s){

					$st_data = array(
						'company_id'		=>	$company_id,
						'time_in'		=>	$s->t_in,
						'time_out'		=>	$s->t_out,
						'classification'		=>	$s->class_id,
						'lunch_break'		=>	$s->lb,
						'break_1'		=>	$s->br1,
						'break_2'		=>	$s->br2,
						'no_of_hours'		=>	$s->hrs,
						'description'		=>	$s->ds,
						'InActive'		=>	'0',
						'date_created'		=>	date('Y-m-d H:i:s'),
					);

					$this->system_upgrade_model->insert_shift_table($st_data);
				}
				echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred Shift Table Details</div>";

			}else{

			}
		}else{
		}

		
	}

	public function get_v1_dtr_forms($val,$company_id){
		if($val=="leave_form"){
			/*
			employee_leave
			employee_leave_day
			*/
			$leave=$this->system_upgrade_model->v1_get_leave_form();
			$query=$this->db->query("DELETE FROM employee_leave");
			$query=$this->db->query("DELETE FROM employee_leave_days");

			if(!empty($leave)){
				foreach($leave as $l){
					$employee_id=$l->emp_id;
					$leave_type=$l->leave_type;
					$address=$l->address;
					$date_from=$l->date_from;
					$date_to=$l->date_to;
					$comment=$l->comment;
					$date_created=$l->date_created;
					$doc_no=$doc_no=$l->doc_no;
					$act=$l->act;
					$nd=$l->nd;
					$tp=$l->tp;
					$ul=$l->ul;
					$date_app=$l->date_app;
					$l_year=$l->l_year;
					$m_file=$l->m_file;
					$remarks=$l->remarks;
					$left_leave=$l->left_leave;

					$dc_mm=substr($l->date_created, 0,2);
					$dc_dd=substr($l->date_created, 3,2);
					$dc_yy=substr($l->date_created, 6,4);
					$date_created="$dc_yy-$dc_mm-$dc_dd";

					$c_mm=substr($l->date_from, 0,2);
					$c_dd=substr($l->date_from, 3,2);
					$c_yy=substr($l->date_from, 6,4);
					$date_from="$c_yy-$c_mm-$c_dd";

					$ct_mm=substr($l->date_to, 0,2);
					$ct_dd=substr($l->date_to, 3,2);
					$ct_yy=substr($l->date_to, 6,4);
					$date_to="$ct_yy-$ct_mm-$ct_dd";

					if($ul=="1"){
					$with_pay=1;
					}else{
					$with_pay=0;
					}

					if($nd>1){
						$leave_day_type=1;//whole day leave
					}elseif($nd==1){
						$leave_day_type=1;//whole day leave
					}else{
						$leave_day_type=0.5;//halfday leave
					}

			$leave_data = array(
			'employee_id'			=>	$employee_id,
			'doc_no'				=>	$doc_no,
			'leave_type_id'			=>	$leave_type,
			'address'				=>	$address,
			'from_date'				=>	$date_from,
			'to_date'				=>	$date_to,
			'no_of_days'			=>	$leave_day_type,// if halfday or wholeday//<===================
			'days'					=>	$nd,// ilang araw na nakaleave.//<===================
			'status'				=>	'approved',
			'reason'				=>	$comment,
			'date_created'			=>	$date_created,
			'IsDeleted'				=>	'0',
			'remarks'				=>	$remarks,
			'InActive'				=>	'0',
			'with_pay'				=>	$with_pay,//<===================
			'status_update_date'			=>	$date_created,
			'entry_type'			=>	'migrator of version 1',
			'company_id'			=>	$company_id,
			'file_attached'			=>	'',
			'late_filing'			=>	null,
			'late_filing_type'			=>	null,
			'with_cancellation_of_leave'	=>	null,
			'is_per_hour'			=>	null,
			'total_per_hour_filed'			=>	null,
			'total_per_hour_deduction'			=>	null
			);

			

			$leave_form_days=$this->system_upgrade_model->v1_get_leave_form_days($doc_no,$employee_id);
			if(!empty($leave_form_days)){

				/*pag not empty yung leave form days saka nya lang iinsert.kc pagwalang value meaning error filing from v1
				*/
				$this->system_upgrade_model->insert_leave_form($leave_data);

				foreach($leave_form_days as $d){
					$lfd_data = array(
						'doc_no'		=>	$d->doc_no,
						'the_month'		=>	$d->mm,
						'the_day'		=>	$d->dd,
						'the_year'		=>	$d->yy,
						'the_date'		=>	$d->yy."-".$d->mm."-".$d->dd,
						'employee_id'		=>	$d->emp_id
					);
					$this->system_upgrade_model->insert_leave_form_days($lfd_data);
				}
			}else{

			}
	

				}

				echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred Approved Leave Details</div>";

			}else{

			}
			//echo "get leave forms";
		}elseif($val=="ot_form"){
			//emp_atro
			$ot_form=$this->system_upgrade_model->v1_get_ot_form();

			$query=$this->db->query("DELETE FROM emp_atro");

			if(!empty($ot_form)){
				foreach($ot_form as $o){
					$dc_mm=substr($o->dc, 0,2);
					$dc_dd=substr($o->dc, 3,2);
					$dc_yy=substr($o->dc, 6,4);
					$date_created="$dc_yy-$dc_mm-$dc_dd";

					$noh=$o->noh;
					$last_3=substr($noh, -3);
					if($last_3==".00"){
						$noh=str_replace(".00","",$noh);
					}else{
					}

					$h1=$o->h1;
					$m1=$o->m1;


					$time_in=$h1.":".$m1;
					$time_out=$o->h2.":".$o->m2;

					if($o->hh1=="--:--" OR $o->hh1=="" ){
						$sched="No plotted schedule";
					}else{
						$sched=$o->hh1."-".$o->hh2;
					}
				
					$ot_data = array(
						'employee_id'			=>	$o->emp_id,
						'company_id'			=>	$company_id,
						'doc_no'				=>	$o->doc_no,
						'atro_conversion'		=>	'with_pay',
						'atro_date'				=>	$o->yy."-".$o->mm."-".$o->dd,
						'filed_by'				=>	$o->emp_file,
						'reason'				=>	$o->wtb,
						'working_sched'			=>	$sched,
						'time_in'				=>	$time_in,
						'time_out'				=>	$time_out,
						'no_of_hours'			=>	$noh,
						'status'				=>	'approved',
						'entry_type'			=>	'migrator of version 1',
						'IsDeleted'				=>	'0',
						'InActive'				=>	'0',
						'date_created'			=>	$date_created,
						'status_update_date'	=>	$date_created,
					);
					$this->system_upgrade_model->insert_ot_form($ot_data);


				}
				echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred Approved OT Form Details</div>";


			}else{}

		}elseif($val=="ob_form"){
			//emp_official_business
			//emp_official_business_days
			$ob_form=$this->system_upgrade_model->v1_get_ob_form();
			$query=$this->db->query("DELETE FROM emp_official_business");
			$query=$this->db->query("DELETE FROM emp_official_business_days");

			if(!empty($ob_form)){
				foreach($ob_form as $b){
					$doc_no=$b->doc_no;
					$emp_id=$b->emp_id;
					$dc=$b->dc;
					$comp_name=$b->cn;
					$comp_address=$b->ca;
					$purpose=$b->pr;
					$time=$b->tm;
					$t_fr=$b->t_fr;
					$t_to=$b->t_to;
					$meal=$b->meal;
					$will_return=$b->will_return;

					$raw_mm=substr($dc, 0,2);
					$raw_dd=substr($dc, 3,2);
					$raw_yy=substr($dc, 6,4);
					$date_created="$raw_yy-$raw_mm-$raw_dd";


					$dc_mm=substr($t_fr, 0,2);
					$dc_dd=substr($t_fr, 3,2);
					$dc_yy=substr($t_fr, 6,4);
					$from_date="$dc_yy-$dc_mm-$dc_dd";

					$tc_mm=substr($t_to, 0,2);
					$tc_dd=substr($t_to, 3,2);
					$tc_yy=substr($t_to, 6,4);
					$to_date="$tc_yy-$tc_mm-$tc_dd";

					$from_time=substr($time, 0,5);
					$to_time=substr($time, 9,5);

					$f_date=$from_date;
					$t_date=$to_date;

					$ob_data = array(
						'company_id'		=>	$company_id,
						'employee_id'		=>	$emp_id,
						'doc_no'			=>	$doc_no,
						'company_name'		=>	$comp_name,
						'company_address'		=>	$comp_address,
						'reason'		=>	$purpose,
						'with_meal'		=>	$meal,
						'from_date'		=>	$from_date,
						'to_date'		=>	$to_date,
						'from_time'		=>	$from_time,
						'to_time'		=>	$to_time,
						'will_return'	=>	$will_return,
						'date_created'	=>	$date_created,
						'status_update_date'	=>	$date_created,
						'status'				=>	'approved',
						'remarks'			=>	'',
						'InActive'			=>	'0',
						'IsDeleted'			=>	'0',
						'entry_type'		=>	'migrator of version 1'

					);

					$this->system_upgrade_model->insert_ob_form($ob_data);

					while (strtotime($f_date) <= strtotime($t_date)) {		

						$the_year=substr($f_date,0,4);	
						$the_month=substr($f_date,5,2);		
						$the_day=substr($f_date, 8,2);	

						$ob_days= array(
							'doc_no'		=>	$doc_no,
							'employee_id'		=>	$emp_id,
							'the_month'		=>	$the_month,
							'the_day'		=>	$the_day,
							'the_year'		=>	$the_year,
							'the_date'		=>	$f_date
						);	

						$this->system_upgrade_model->insert_ob_form_days($ob_days);

						$f_date = date ("Y-m-d", strtotime("+1 day", strtotime($f_date)));
					}



				}
				echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred Approved Official Business Form Details</div>";

			}else{}

		}elseif($val=="tk_form"){
			$tkform=$this->system_upgrade_model->v1_get_tk_form();
			$query=$this->db->query("DELETE FROM emp_time_complaint");

			if(!empty($tkform)){
				foreach($tkform as $t){

					$date_out=$t->date_out;
					$tc_date=$t->tc_date;
					$date_created=$t->dc;

					$dc_mm=substr($date_out, 0,2);
					$dc_dd=substr($date_out, 3,2);
					$dc_yy=substr($date_out, 6,4);
					$time_out_date="$dc_yy-$dc_mm-$dc_dd";

					$tc_mm=substr($tc_date, 0,2);
					$tc_dd=substr($tc_date, 3,2);
					$tc_yy=substr($tc_date, 6,4);
					$time_in_date="$tc_yy-$tc_mm-$tc_dd";

					$dtc_mm=substr($date_created, 0,2);
					$dtc_dd=substr($date_created, 3,2);
					$dtc_yy=substr($date_created, 6,4);
					$date_created="$dtc_yy-$dtc_mm-$dtc_dd";


					$check_time_in=substr($t->t_in, 1,1);
					$check_time_out=substr($t->t_out, 1,1);

					if($check_time_in==":"){
						$time_in="0".$t->t_in;
					}else{	
						$time_in=$t->t_in;					
					}

					if($check_time_out==":"){
						$time_out="0".$t->t_out;
					}else{	
						$time_out=$t->t_out;					
					}

					$time_in=substr($time_in, 0,5);
					$time_out=substr($time_out, 0,5);

					$tk_data = array(
					'company_id'		=>	$company_id,
					'employee_id'		=>	$t->emp_id,
					'doc_no'			=>	$t->doc_no,
					'time_in'			=>	$time_in,
					'time_out'			=>	$time_out,
					'time_in_date'		=>	$time_in_date,
					'time_out_date'		=>	$time_out_date,
					'covered_date'		=>	$time_in_date,
					'reason'			=>	$t->rs,
					'my_time'			=>	$t->my_tym,
					'date_created'		=>	$date_created,
					'status_update_date'	=>	$date_created,
					'status'		=>	'approved',
					'remarks'		=>	'',
					'InActive'		=>	'0',
					'IsDeleted'		=>	'0',
					'entry_type'	=>	'migrator of version 1'
					);

					$this->system_upgrade_model->insert_tk_form($tk_data);
				}

				echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred Approved Timekeeping Form Details</div>";

			}else{}

		}else{}

	}


	public function get_v1_leave_type($val,$company_id){
		$v1_leave=$this->system_upgrade_model->v1_get_leave_type();
		if(!empty($v1_leave)){
			if($val=="leave_type"){
				$query=$this->db->query("DELETE FROM leave_type");
			}elseif($val=="leave_type_remaining_credit"){
				$query=$this->db->query("DELETE FROM leave_allocation");
			}else{

			}

			$seqno=0;
			foreach($v1_leave as $v){
				$seqno++;
				$lv_id=$v->lv_id;

				
				if($val=="leave_type_remaining_credit"){
						//if($lv_id=="1"){


					$leave_type_emp_credits=$this->system_upgrade_model->v1_get_leave_credit($lv_id);
					if(!empty($leave_type_emp_credits)){
						foreach($leave_type_emp_credits as $c){
							$id=$c->l_id;
							$employee_id=$c->emp_id;
							$available=$c->available;

							$ver_id=$this->system_upgrade_model->verify_leave_employee($employee_id);
							if(!empty($ver_id)){// exist at masterlist and is an active employee pa.
								$insert_leave_credit_data = array(
									'leave_type_id'			=> $id,
									'employee_id'			=> $employee_id,
									'available'				=> $available,
									'year'					=> date('Y'),
									'is_manual_credit'		=> '1',
									'insert_date'			=> date('Y-m-d H:i:s'),
								);
								$insert_leave_credit=$this->system_upgrade_model->insert_leave_credit($insert_leave_credit_data);
							}else{// not exist
							}
							
						}
					}else{

					}

						// }else{
						// }

				}else{

				}


				$leave_type=$v->lv_type;
				$leave_code=$v->lv_code;
				$color_code=$v->color_coding;
				$gender_male=$v->gender_male;
				$gender_female=$v->gender_female;
				$act=$v->act;

				if($act=="1"){//active
					$isDisabled=0;
				}else{//not active
					$isDisabled=1;
				}
				if($leave_code=="IL"){
					$is_system_default=1;
				}else{
					$is_system_default=0;
				}

				$gender="";// for all gender
				if(($gender_male=="1")AND($gender_female=="0" OR $gender_female=="")){
					$gender="1";
				}elseif(($gender_male=="0" OR $gender_male=="")AND($gender_female=="1")){
					$gender="2";
				}else{
				}
						$insert_leave_type_data = array(
							'id'			=> $seqno,
							'company_id'			=> $company_id,
							'leave_type'			=> $leave_type,
							'leave_code'			=> $leave_code,
							'color_code'			=> $color_code,
							'gender'				=> $gender,
							'is_manual_credit'				=> '1',
							'is_system_default'				=> $is_system_default,
							'taxable_leave_beyond'				=> '0',
							'isDisabled'			=> $isDisabled

						);


						if($val=="leave_type"){
							$insert_leave_type=$this->system_upgrade_model->insert_leave_type($insert_leave_type_data);
						}elseif($val=="leave_type_remaining_credit"){

						}else{

						}


						
			}
				echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred Leave Type details</div>";
		}else{
				echo	"<div class='alert alert-danger'><i class='fa fa-times'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  No data transferred .</div>";	
		}

	}

	public function get_v1_201_details($val,$company_id){

	if($val=="userdefine_data"){

			$emp=$this->system_upgrade_model->v2_get_act_inact_masterlist($company_id);
			if(!empty($emp)){
				foreach($emp as $e){
					$ud=$this->system_upgrade_model->v1_get_udf_data($e->employee_id);
					if(!empty($ud)){
						$user_def_data= array(
							'company_id'		=>	$company_id,
							'emp_udf_col_id'	=>	'1',
							'data'					=>	$ud->udf_data,
							'employee_id'					=>	$e->employee_id

						);
						$this->system_upgrade_model->insert_udf_data($user_def_data);
						
					}else{
					}
					
				}
				echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred UDF Data details</div>";

			}else{

			}
			

	}else{
				$v1_active_emp=$this->system_upgrade_model->v1_get_active_employees($val);

				if(!empty($v1_active_emp)){
				if($val=="active_emp"){
								$query=$this->db->query("DELETE FROM employee_info");
								$query=$this->db->query("DELETE FROM employee_date_employed");		
								$InActive="0";	
								$isEnable="1";
				}elseif($val=="inactive_emp"){
								$query=$this->db->query("DELETE FROM employee_info_inactive");
								$query=$this->db->query("DELETE FROM employee_date_resigned");	
								$InActive="1";
								$isEnable="1";
				}else{
				
				}

					foreach($v1_active_emp as $p){
						$emp_id=$p->emp_id;
						$last_name=$p->last_name;
						$first_name=$p->first_name;
						$middle_name=$p->middle_name;
						$civil_status=$p->civil_status;
						$blood_type=$p->blood_type;
						$height=$p->height;
						$weight=$p->weight;
						$citizenship=$p->citizenship;
						$place_of_birth=$p->place_of_birth;
						$religion=$p->religion;
						$email=$p->email;
						$mobile=$p->mobile;
						$sex=$p->sex;
						$sss_no=$p->sss_no;
						$tin_no=$p->tin_no;
						$passport_no=$p->passport_no;
						$philhealth_no=$p->philhealth_no;
						$pagibig_no=$p->pagibig_no;
						$account_no=$p->account_no;
						$street=$p->street;
						$barangay=$p->barangay;
						$city_province=$p->city_province;
						$postal_code=$p->postal_code;
						$p_street=$p->p_street;
						$p_barangay=$p->p_barangay;
						$p_city_province=$p->p_city_province;
						$p_postal_code=$p->p_postal_code;
						$mm=$p->mm;
						$dd=$p->dd;
						$yy=$p->yy;
						$height2=$p->height2;
						$nick_name=$p->nick_name;
						$name_rent=$p->name_rent;
						$no_rent=$p->no_rent;
						$fb=$p->fb;
						$date_resign=$p->date_resign;
						$remarks=$p->remarks;
						$department=$p->department;
						$emp_class=$p->emp_class;
						$emp_section=$p->emp_section;
						$reports_to=$p->reports_to;
						$datehired_mm=$p->datehired_mm;
						$datehired_dd=$p->datehired_dd;
						$datehired_yy=$p->datehired_yy;
						$pos=$p->pos;
						$employment=$p->employment;
						$date_prob=$p->date_prob;
						$date_reg=$p->date_reg;
						$date_proj=$p->date_proj;
						$date_cont=$p->date_cont;
						$bank_id=$p->bank_id;
						$loc=$p->loc;
						$emp_id_auto=$p->emp_id_auto;

						$insert_emp_date_employed = array(
							'company_id'			=> $company_id,
							'employee_id'			=> $emp_id,
							'date_employed'			=> $datehired_yy.'-'.$datehired_mm.'-'.$datehired_dd,
							'division_id'			=> '',
							'department'			=> $department,
							'section'				=> $emp_section,
							'subsection'			=> '',		
							'classification'		=> $emp_class,
							'employment'			=> $employment,		
							'location'				=> $loc,
							'position'				=> $pos																								
						);
						$insert_emp_date_resig = array(
							'company_id'			=> $company_id,
							'employee_id'			=> $emp_id,
							'date_resigned'			=> $date_resign,
							'date_employed'			=> $datehired_yy.'-'.$datehired_mm.'-'.$datehired_dd,
							'division_id'			=> '',
							'department'			=> $department,
							'section'				=> $emp_section,
							'subsection'			=> '',		
							'classification'		=> $emp_class,
							'employment'			=> $employment,		
							'location'				=> $loc,
							'position'				=> $pos																								
						);

						$insert_emp_data = array(
							'id'			=> $emp_id_auto,
							'employee_id'			=> $emp_id,
							'title'					=> '',
							'first_name'			=> $first_name,
							'middle_name'			=> $middle_name,
							'last_name'				=> $last_name,
							'name_extension'			=> '',
							'fullname'				=> '',
							'nickname'				=> $nick_name,
							'birthday'				=> $yy.'-'.$mm.'-'.$dd,
							'age'					=> '',
							'birth_place'			=> $place_of_birth,
							'gender'				=> $sex,
							'civil_status'			=> $civil_status,
							'blood_type'			=> $blood_type,
							'citizenship'			=> $citizenship,
							'religion'				=> $religion,
							'classification'		=> $emp_class,
							'employment'			=> $employment,
							'department'			=> $department,
							'section'				=> $emp_section,
							'subsection'			=> '',
							'division_id'			=> '',
							'company_id'			=> $company_id,
							'location'				=> $loc,
							'position'				=> $pos,
							'taxcode'				=> '1',
							'pay_type'				=> '3',// semi monthly
							'report_to'				=> $reports_to,
							'email'					=> $email,
							'sss'					=> $sss_no,
							'bank'					=> $bank_id,
							'account_no'			=> $account_no,
							'tin'					=> $tin_no,
							'pagibig'					=> $pagibig_no,
							'philhealth'				=> $philhealth_no,
							'permanent_address'			=> '',
							'permanent_province'			=> '',
							'permanent_city'					=> '',
							'permanent_address_years_of_stay'	=> '',
							'present_address'					=> '',
							'present_province'					=> '',
							'present_city'						=> '',
							'present_address_years_of_stay'		=> '',
							'mobile_1'			=> $mobile,
							'mobile_2'			=> '',
							'mobile_3'			=> '',
							'mobile_4'			=> '',
							'tel_1'				=> '',
							'tel_2'				=> '',
							'facebook'			=> $fb,
							'twitter'			=> '',
							'instagram'			=> '',
							'username'			=> $emp_id,
							'password'			=> $emp_id,
							'isEnable'			=> $isEnable,
							'InActive'			=> $InActive,
							'isUser'			=> '0',
							'picture'			=> '',
							'date_employed'			=> $datehired_yy.'-'.$datehired_mm.'-'.$datehired_dd,
							'isApplicant'			=> '0',
							'isEmployee'			=> '1',
							'isApproverChoice'		=> '0',
							'resume_file'			=> '',
							'residence_map'			=> '',
							'passChangeDate'		=> '',
							'electronic_signature'				=> '',
							'whole_body_pic'					=> '',
							'isSalaryApproverChoices'			=> '',
							'on_leave'							=> '0',
							'isNotificationApproverChoices'			=> '0',
							'IfInterviewer'						=> '0',
							'encrypt_password'				=> '0'
						);
						$insert_emp_inactive_data = array(
							'id'			=> $emp_id_auto,
							'employee_id'			=> $emp_id,
							'title'					=> '',
							'first_name'			=> $first_name,
							'middle_name'			=> $middle_name,
							'last_name'				=> $last_name,
							'name_extension'			=> '',
							'fullname'				=> '',
							'nickname'				=> $nick_name,
							'birthday'				=> $yy.'-'.$mm.'-'.$dd,
							'age'					=> '',
							'birth_place'			=> $place_of_birth,
							'gender'				=> $sex,
							'civil_status'			=> $civil_status,
							'blood_type'			=> $blood_type,
							'citizenship'			=> $citizenship,
							'religion'				=> $religion,
							'classification'		=> $emp_class,
							'employment'			=> $employment,
							'department'			=> $department,
							'section'				=> $emp_section,
							'subsection'			=> '',
							'division_id'			=> '',
							'company_id'			=> $company_id,
							'location'				=> $loc,
							'position'				=> $pos,
							'taxcode'				=> '1',
							'pay_type'				=> '3',// semi monthly
							'report_to'				=> $reports_to,
							'email'					=> $email,
							'sss'					=> $sss_no,
							'bank'					=> $bank_id,
							'account_no'			=> $account_no,
							'tin'					=> $tin_no,
							'pagibig'					=> $pagibig_no,
							'philhealth'				=> $philhealth_no,
							'permanent_address'			=> '',
							'permanent_province'			=> '',
							'permanent_city'					=> '',
							'permanent_address_years_of_stay'	=> '',
							'present_address'					=> '',
							'present_province'					=> '',
							'present_city'						=> '',
							'present_address_years_of_stay'		=> '',
							'mobile_1'			=> $mobile,
							'mobile_2'			=> '',
							'mobile_3'			=> '',
							'mobile_4'			=> '',
							'tel_1'				=> '',
							'tel_2'				=> '',
							'facebook'			=> $fb,
							'twitter'			=> '',
							'instagram'			=> '',
							'username'			=> $emp_id,
							'password'			=> $emp_id,
							'isEnable'			=> $isEnable,
							'InActive'			=> $InActive,
							'isUser'			=> '0',
							'picture'			=> '',
							'date_employed'			=> $datehired_yy.'-'.$datehired_mm.'-'.$datehired_dd,
							'isApplicant'			=> '0',
							'isEmployee'			=> '1',
							'isApproverChoice'		=> '0',
							'resume_file'			=> '',
							'residence_map'			=> '',
							'electronic_signature'				=> '',
							'whole_body_pic'					=> ''
	
			
							
						);
						if($val=="active_emp"){
								$insert_emp_data=$this->system_upgrade_model->insert_emp_data($insert_emp_data);
								$insert_emp_date_employed=$this->system_upgrade_model->insert_emp_date_employed($insert_emp_date_employed);				
						}elseif($val=="inactive_emp"){
						
								$insert_emp_data=$this->system_upgrade_model->insert_emp_inactive($insert_emp_inactive_data);
								$insert_emp_date_resigned=$this->system_upgrade_model->insert_emp_date_resigned($insert_emp_date_resig);	
						}else{
						
						}




					}
				echo	"<div class='alert alert-success'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  Successfully transferred Employee details</div>";
				}else{
				echo	"<div class='alert alert-danger'><i class='fa fa-times'></i><button type='button' class='close' data-dismiss='alert'>&times;</button>  No data transferred .</div>";	
				}



	}



	}
	
}// end of controller













