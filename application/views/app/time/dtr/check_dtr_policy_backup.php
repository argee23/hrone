<?php
//============================================GET COMPANY TIME/DTR SETTINGS POLICY============================================

//== Machine attendance option (e.g FILO)

$my_machine_policy=$this->general_model->get_dtr_setting($company_id,18);
$machine_attendance_option=$my_machine_policy->single_field_setting;

//== Number of hours to count tardiness as half day absent

$my_late_no_of_hour_policy=$this->general_model->get_dtr_setting($company_id,16);
$late_as_half_day_policy=$my_late_no_of_hour_policy->single_field_setting;


//== Late deduction minutes (include the grace period?) : setting

$my_late_deduction_policy=$this->general_model->get_dtr_setting($company_id,41);
$late_grace_deduction_policy=$my_late_deduction_policy->single_field_setting;

//== Undertime deduction (include the grace period to undertime (minutes computation)?)

$my_ut_grace_deduction_policy=$this->general_model->get_dtr_setting($company_id,45);
$ut_grace_deduction_policy=$my_ut_grace_deduction_policy->single_field_setting;


//== Number of hours to count undertime as half day absent

$my_ut_no_of_hour_policy=$this->general_model->get_dtr_setting($company_id,17);
$ut_as_half_day_policy=$my_ut_no_of_hour_policy->single_field_setting;

//== Case treated as halfday by the system due to count undertime as halfday absent policy 

$my_ut_treated_as_halfday_dtr_show_policy=$this->general_model->get_dtr_setting($company_id,46);
$forced_halfday_ut_display_to_dtr=$my_ut_treated_as_halfday_dtr_show_policy->ut_display_to_dtr;
$forced_halfday_ut_include_to_occurence=$my_ut_treated_as_halfday_dtr_show_policy->ut_include_to_occurence;

//== Case treated as halfday by the system due to count late as halfday absent policy 

$my_late_treated_as_halfday_dtr_show_policy=$this->general_model->get_dtr_setting($company_id,47);
$forced_halfday_late_display_to_dtr=$my_late_treated_as_halfday_dtr_show_policy->late_display_to_dtr;
$forced_halfday_late_include_to_occurence=$my_late_treated_as_halfday_dtr_show_policy->late_include_to_occurence;

//== show actual hours on DTR

$show_ah=$this->general_model->get_dtr_setting($company_id,36);
$show_actual_hour=$show_ah->single_field_setting;

//== Allow per hour leave application?

$check_allow_hourly_leave=$this->general_model->get_dtr_setting($company_id,48);
$hourly_leave_setup=$check_allow_hourly_leave->single_field_setting;

//== Days that is not yet hired :  no plotted work shedule treatment

$check_days_not_yet_hired=$this->general_model->get_dtr_setting($company_id,20);
$days_not_yet_hired_treatment=$check_days_not_yet_hired->single_field_setting;

//== Check Regular Night Differential Time

$check_reg_nd=$this->general_model->get_dtr_setting($company_id,8);
$reg_nd_time_from=$check_reg_nd->reg_night_diff_time_from;
$reg_nd_time_to=$check_reg_nd->reg_night_diff_time_to;

// Check Night Differential (0.13%)

$check_nd_none_reg=$this->general_model->get_dtr_setting($company_id,3);
$none_reg_nd_time_from=$check_nd_none_reg->night_diff_time_from;
$none_reg_nd_time_to=$check_nd_none_reg->night_diff_time_to;

// Check Rest day auto match schedule

$check_restday_auto_schedule=$this->general_model->get_dtr_setting($company_id,42);
$restday_auto_schedule_setting=$check_restday_auto_schedule->rd_auto_match_sched_allow;
$restday_auto_schedule_table_setting=$check_restday_auto_schedule->rd_auto_match_sched_match_at;

// Check DTR decimal place
$check_dec_place=$this->general_model->get_dtr_setting($company_id,56);
$decimal_place_no_setting=$check_dec_place->single_field_setting;

// Check DTR decimal place (round it off?)
$check_dec_place=$this->general_model->get_dtr_setting($company_id,57);
$decimal_place_rounding_setting=$check_dec_place->single_field_setting;

// Check day(s) allowance  for late approved leave transaction
$check_days_late_approved_leave=$this->general_model->get_dtr_setting($company_id,13);
$late_approved_leave_daysno_setting=$check_days_late_approved_leave->single_field_setting;

// Check day(s) allowance  for late approved overtime transaction
$check_days_late_approved_overtime=$this->general_model->get_dtr_setting($company_id,69);
$late_approved_overtime_daysno_setting=$check_days_late_approved_overtime->single_field_setting;

// Check day(s) allowance  for late approved leave transaction (from date reference)
$check_days_late_approved_leave_from_ref=$this->general_model->get_dtr_setting($company_id,58);
$late_approved_leave_datecounting_setting=$check_days_late_approved_leave_from_ref->single_field_setting;

//============================================START HOLIDAY ABSENT CONDTIONS ============================================
// Check Absent before the Holiday
$check_abs_before_hol=$this->general_model->get_dtr_setting($company_id,25);
$absent_bef_reg_hol_setting=$check_abs_before_hol->regular_holiday_multi_policy;
$absent_bef_spec_hol_setting=$check_abs_before_hol->snw_holiday_multi_policy;

// Check Absent After the Holiday
$check_abs_after_hol=$this->general_model->get_dtr_setting($company_id,60);
$absent_aft_reg_hol_setting=$check_abs_after_hol->regular_holiday_multi_policy;
$absent_aft_spec_hol_setting=$check_abs_after_hol->snw_holiday_multi_policy;

// Check Case with pay whole day leave before the holiday
$check_abs_before_hol_onwholedayleave=$this->general_model->get_dtr_setting($company_id,61);
$onwholeleave_bef_reg_hol_setting=$check_abs_before_hol_onwholedayleave->regular_holiday_multi_policy;
$onwholeleave_bef_spec_hol_setting=$check_abs_before_hol_onwholedayleave->snw_holiday_multi_policy;


// Check Case with pay whole day leave after the holiday
$check_abs_after_hol_onwholedayleave=$this->general_model->get_dtr_setting($company_id,62);
$onwholeleave_aft_reg_hol_setting=$check_abs_after_hol_onwholedayleave->regular_holiday_multi_policy;
$onwholeleave_aft_spec_hol_setting=$check_abs_after_hol_onwholedayleave->snw_holiday_multi_policy;

// Check Case with pay half day leave before the holiday
$check_abs_bef_hol_onhalfdayleave=$this->general_model->get_dtr_setting($company_id,63);
$onhalfleave_bef_reg_hol_setting=$check_abs_bef_hol_onhalfdayleave->regular_holiday_multi_policy;
$onhalfleave_bef_spec_hol_setting=$check_abs_bef_hol_onhalfdayleave->snw_holiday_multi_policy;

// Check Case with pay half day leave after the holiday
$check_abs_after_hol_onhalfdayleave=$this->general_model->get_dtr_setting($company_id,64);
$onhalfleave_aft_reg_hol_setting=$check_abs_after_hol_onhalfdayleave->regular_holiday_multi_policy;
$onhalfleave_aft_spec_hol_setting=$check_abs_after_hol_onhalfdayleave->snw_holiday_multi_policy;

//============================================END HOLIDAY ABSENT CONDTIONS ============================================

// Check treatment for merging regular day- regular holiday coverage of in & out
$check_regday_reg_hol_logs=$this->general_model->get_dtr_setting($company_id,65);

/*working day : regular holiday
next day : regular day*/
$reghol_regday_log=$check_regday_reg_hol_logs->regular_holiday_multi_policy;

/*working day : regular day
next day : regular holiday*/
$regday_reghol_log=$check_regday_reg_hol_logs->snw_holiday_multi_policy;


// Check treatment for merging regular day- special non-working holiday coverage of in & out
$check_regday_spec_hol_logs=$this->general_model->get_dtr_setting($company_id,66);

/*working day : snw holiday
next day : regular day*/
$spechol_regday_log=$check_regday_spec_hol_logs->regular_holiday_multi_policy;

/*working day : regular day
next day : snw holiday*/
$regday_spechol_log=$check_regday_spec_hol_logs->snw_holiday_multi_policy;

// Check treatment for merging snw holiday- regular holiday coverage of in & out
$check_reghol_spec_hol_logs=$this->general_model->get_dtr_setting($company_id,67);

/*working day : snw holiday
next day : regular holiday*/
$spechol_reghol_log=$check_reghol_spec_hol_logs->regular_holiday_multi_policy;

/*working day : regular holiday
next day : snw holiday*/
$reghol_spechol_log=$check_reghol_spec_hol_logs->snw_holiday_multi_policy;

//== Process employee with date hired on current period

$date_employed_within_cutoff=$this->general_model->get_dtr_setting($company_id,27);
$datehired_on_cur_period_sts=$date_employed_within_cutoff->datehired_on_cur_period_sts; // same time summary
$datehired_on_cur_period_action=$date_employed_within_cutoff->datehired_on_cur_period_dwa; // what is the action to be taken

//== DTR Absences occurence composition

$dtr_absent_occurence=$this->general_model->get_dtr_setting($company_id,68);
$dtr_absent_occurence_basis=$dtr_absent_occurence->single_field_setting; // same time summary

//== DTR Required Actual Hrs rendered of halfday employees

$the_required_halfday_hrs=$this->general_model->get_dtr_setting($company_id,31);
$dtr_required_halfday_hrs=$the_required_halfday_hrs->single_field_setting; // same time summary do not include break time here

//== DTR Required actual hrs rendered to pay the employee

$the_required_hrs_to_pay=$this->general_model->get_dtr_setting($company_id,32);
$dtr_required_hrs_to_pay=$the_required_hrs_to_pay->single_field_setting; // same time summary


//== Overtime ND time

$the_ot_nd_time=$this->general_model->get_dtr_setting($company_id,9);
$the_ot_nd_time_raw=$the_ot_nd_time->single_field_setting; // same time summary

$the_ot_nd_time_from=substr($the_ot_nd_time_raw, 0,5);
$the_ot_nd_time_to=substr($the_ot_nd_time_raw, -5,5);


?>