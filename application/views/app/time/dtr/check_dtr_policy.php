<?php
$dtr_pol=$this->time_dtr_model->get_all_dtr_setting($company_id);
if(!empty($dtr_pol)){

foreach($dtr_pol as $d){
	$ts_id=$d->time_setting_id;
	$single_field_setting=$d->single_field_setting;

	if($ts_id=="24"){//== Filing of leave on half day regular schedule treatment
		$halfday_sched_absent_deduction=$single_field_setting;
	}elseif($ts_id=="18"){//== Machine attendance option (e.g FILO)
		$machine_attendance_option=$single_field_setting;
	}elseif($ts_id=="16"){//== Number of hours to count tardiness as half day absent
		$late_as_half_day_policy=$single_field_setting;
	}elseif($ts_id=="41"){//== Late deduction minutes (include the grace period?) : setting
		$late_grace_deduction_policy=$single_field_setting;
	}elseif($ts_id=="45"){//== Undertime deduction (include the grace period to undertime (minutes computation)?)
		$ut_grace_deduction_policy=$single_field_setting;
	}elseif($ts_id=="17"){//== Number of hours to count undertime as half day absent
		$ut_as_half_day_policy=$single_field_setting;
	}elseif($ts_id=="46"){//== Case treated as halfday by the system due to count undertime as halfday absent policy 
		$forced_halfday_ut_display_to_dtr=$d->ut_display_to_dtr;
		$forced_halfday_ut_include_to_occurence=$d->ut_include_to_occurence;
	}elseif($ts_id=="47"){//== Case treated as halfday by the system due to count late as halfday absent policy 
		$forced_halfday_late_display_to_dtr=$d->late_display_to_dtr;
		$forced_halfday_late_include_to_occurence=$d->late_include_to_occurence;
	}elseif($ts_id=="36"){//== show actual hours on DTR
		$show_actual_hour=$single_field_setting;
	}elseif($ts_id=="48"){//== Allow per hour leave application?
		$hourly_leave_setup=$single_field_setting;
	}elseif($ts_id=="20"){//== Days that is not yet hired :  no plotted work shedule treatment
		$days_not_yet_hired_treatment=$single_field_setting;
	}elseif($ts_id=="8"){//== Check Regular Night Differential Time
		$reg_nd_time_from=$d->reg_night_diff_time_from;
		$reg_nd_time_to=$d->reg_night_diff_time_to;
	}elseif($ts_id=="3"){//== Check Night Differential (0.13%)
		$none_reg_nd_time_from=$d->night_diff_time_from;
		$none_reg_nd_time_to=$d->night_diff_time_to;
	}elseif($ts_id=="42"){//== Check Rest day auto match schedule
		$restday_auto_schedule_setting=$d->rd_auto_match_sched_allow;
		$restday_auto_schedule_table_setting=$d->rd_auto_match_sched_match_at;
	}elseif($ts_id=="56"){//== Check DTR decimal place
		$decimal_place_no_setting=$single_field_setting;
	}elseif($ts_id=="57"){//== Check DTR decimal place (round it off?)
		$decimal_place_rounding_setting=$single_field_setting;
	}elseif($ts_id=="13"){//== Check day(s) allowance  for late approved leave transaction
		$late_approved_leave_daysno_setting=$single_field_setting;
	}elseif($ts_id=="69"){//== Check day(s) allowance  for late approved overtime transaction
		$late_approved_overtime_daysno_setting=$single_field_setting;
	}elseif($ts_id=="58"){//== Check day(s) allowance  for late approved leave transaction (from date reference)
		$late_approved_leave_datecounting_setting=$single_field_setting;
	}elseif($ts_id=="25"){//== Check Absent before the Holiday
		$absent_bef_reg_hol_setting=$d->regular_holiday_multi_policy;
		$absent_bef_spec_hol_setting=$d->snw_holiday_multi_policy;
	}elseif($ts_id=="60"){//== Check Absent After the Holiday
		$absent_aft_reg_hol_setting=$d->regular_holiday_multi_policy;
		$absent_aft_spec_hol_setting=$d->snw_holiday_multi_policy;
	}elseif($ts_id=="61"){//== Check Case with pay whole day leave before the holiday
		$onwholeleave_bef_reg_hol_setting=$d->regular_holiday_multi_policy;
		$onwholeleave_bef_spec_hol_setting=$d->snw_holiday_multi_policy;

	}elseif($ts_id=="62"){//== Check Case with pay whole day leave after the holiday
		$onwholeleave_aft_reg_hol_setting=$d->regular_holiday_multi_policy;
		$onwholeleave_aft_spec_hol_setting=$d->snw_holiday_multi_policy;

	}elseif($ts_id=="63"){//== Check Case with pay half day leave before the holiday
		$onhalfleave_bef_reg_hol_setting=$d->regular_holiday_multi_policy;
		$onhalfleave_bef_spec_hol_setting=$d->snw_holiday_multi_policy;

	}elseif($ts_id=="64"){//== Check Case with pay half day leave after the holiday
		$onhalfleave_aft_reg_hol_setting=$d->regular_holiday_multi_policy;
		$onhalfleave_aft_spec_hol_setting=$d->snw_holiday_multi_policy;
	}elseif($ts_id=="65"){//== Check treatment for merging regular day- regular holiday coverage of in & out
		/*working day : regular holiday
		next day : regular day*/
		$reghol_regday_log=$d->regular_holiday_multi_policy;

		/*working day : regular day
		next day : regular holiday*/
		$regday_reghol_log=$d->snw_holiday_multi_policy;
	}elseif($ts_id=="66"){//== Check treatment for merging regular day- special non-working holiday coverage of in & out
		/*working day : snw holiday
		next day : regular day*/
		$spechol_regday_log=$d->regular_holiday_multi_policy;

		/*working day : regular day
		next day : snw holiday*/
		$regday_spechol_log=$d->snw_holiday_multi_policy;
	}elseif($ts_id=="67"){//== Check treatment for merging snw holiday- regular holiday coverage of in & out
		/*working day : snw holiday
		next day : regular holiday*/
		$spechol_reghol_log=$d->regular_holiday_multi_policy;

		/*working day : regular holiday
		next day : snw holiday*/
		$reghol_spechol_log=$d->snw_holiday_multi_policy;
	}elseif($ts_id=="27"){//== Process employee with date hired on current period
		$datehired_on_cur_period_sts=$d->datehired_on_cur_period_sts; // same time summary
		$datehired_on_cur_period_action=$d->datehired_on_cur_period_dwa; // what is the action to be taken
	}elseif($ts_id=="68"){//== DTR Absences occurence composition
		$dtr_absent_occurence_basis=$single_field_setting;
	}elseif($ts_id=="31"){//== DTR Required Actual Hrs rendered of halfday employees
		$dtr_required_halfday_hrs=$single_field_setting;
	}elseif($ts_id=="32"){//== DTR Required actual hrs rendered to pay the employee
		$dtr_required_hrs_to_pay=$single_field_setting;
	}elseif($ts_id=="9"){//== Overtime ND time
			$the_ot_nd_time_raw=$single_field_setting; // same time summary
			$the_ot_nd_time_from=substr($the_ot_nd_time_raw, 0,5);
			$the_ot_nd_time_to=substr($the_ot_nd_time_raw, -5,5);
	}else{

	}
}

}else{




}

?>