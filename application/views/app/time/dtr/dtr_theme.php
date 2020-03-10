<?php

$mydtr_theme=$this->time_dtr_model->check_dtr_theme($company_id);
if(!empty($mydtr_theme)){

	$bg_color_genpay=$mydtr_theme->bg_color;
	$font_color_genpay=$mydtr_theme->font_color;
	$overlay_genpay=$mydtr_theme->bg_overlay;

	$show_dtr_summary_button_bg=$mydtr_theme->show_dtr_summary_button_bg;
	$show_dtr_summary_button_font_color=$mydtr_theme->show_dtr_summary_button_font_color;

	$show_logs_root_button_bg=$mydtr_theme->show_logs_root_button_bg;
	$show_logs_root_button_font_color=$mydtr_theme->show_logs_root_button_font_color;

	$hl_sunday=$mydtr_theme->sunday_hl;
	$hl_shift='style="background-color:'.$mydtr_theme->shift_time_hl.';"';
	$hl_logs='style="background-color:'.$mydtr_theme->actual_time_hl.';"';
	$hl_late='style="background-color:'.$mydtr_theme->late.';"';
	$hl_overbrk='style="background-color:'.$mydtr_theme->overbreak.';"';
	$hl_undrtme='style="background-color:'.$mydtr_theme->undertime.';"';

	$hl_hw_head='style="background-color:'.$mydtr_theme->hours_worked_header.';"';
	$hl_hw_reg='style="background-color:'.$mydtr_theme->hw_reg.';"';
	$hl_hw_nd='style="background-color:'.$mydtr_theme->hw_nd.';"';
	$hl_hw_actual='style="background-color:'.$mydtr_theme->hw_actual.';"';
	$regot_hl='style="background-color:'.$mydtr_theme->regot_hl.';"';
	$rdot_hl='style="background-color:'.$mydtr_theme->rdot_hl.';"';
	$snw_hl='style="background-color:'.$mydtr_theme->snw_hl.';"';
	$reghol_hl='style="background-color:'.$mydtr_theme->reghol_hl.';"';
	$rd_snw_hl='style="background-color:'.$mydtr_theme->rd_snw_hl.';"';
	$rd_reghol_hl='style="background-color:'.$mydtr_theme->rd_reghol_hl.';"';
	$ot_nd='style="background-color:'.$mydtr_theme->ot_nd.';"';
	$atro_hl='style="background-color:'.$mydtr_theme->atro_hl.';"';
	$form_change_rdshift_hl='style="background-color:'.$mydtr_theme->form_change_rdshift_hl.';"';
	$form_leave_hl='style="background-color:'.$mydtr_theme->form_leave_hl.';"';
	$form_ob_hl='style="background-color:'.$mydtr_theme->form_ob_hl.';"';
	$form_tk_hl='style="background-color:'.$mydtr_theme->form_tk_hl.';"';
	$form_ut_hl='style="background-color:'.$mydtr_theme->form_ut_hl.';"';

	$early_cutoff_marked_bg=$mydtr_theme->early_cutoff_dates_hl;
	$early_cutoff_marked_color=$mydtr_theme->early_cutoff_dates_color;

}else{ // default dtr theme

	$early_cutoff_marked_bg='#FF0000';
	$early_cutoff_marked_color='#fff';

	$bg_color_genpay="#006699";
	$font_color_genpay="#fff";
	$overlay_genpay="#000";
	$show_dtr_summary_button_bg="#006699";
	$show_dtr_summary_button_font_color="#fff";

	$show_logs_root_button_bg="#006699";
	$show_logs_root_button_font_color="#fff";

	$hl_sunday="#ffccff";
	$hl_shift='style="background-color:#ff99cc;"';
	$hl_logs='style="background-color:#66ff99;"';
	$hl_late='style="background-color:#fff;"';
	$hl_overbrk='style="background-color:#fff;"';
	$hl_undrtme='style="background-color:#fff;"';

	$hl_hw_head='style="background-color:#fff;"';
	$hl_hw_reg='style="background-color:#fff;"';
	$hl_hw_nd='style="background-color:#fff;"';
	$hl_hw_actual='style="background-color:#fff;"';

	$regot_hl='style="background-color:#fff;"';
	$rdot_hl='style="background-color:#fff;"';
	$snw_hl='style="background-color:#fff;"';
	$reghol_hl='style="background-color:#fff;"';
	$rd_snw_hl='style="background-color:#fff;"';
	$rd_reghol_hl='style="background-color:#fff;"';
	$ot_nd='style="background-color:#fff;"';
	$atro_hl='style="background-color:#fff;"';
	$form_change_rdshift_hl='style="background-color:#fff;"';
	$form_leave_hl='style="background-color:#fff;"';
	$form_ob_hl='style="background-color:#fff;"';
	$form_tk_hl='style="background-color:#fff;"';
	$form_ut_hl='style="background-color:#fff;"';

}

?>