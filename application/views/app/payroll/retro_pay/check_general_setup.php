<?php
$gen_pay_theme=$this->Payroll_generate_13th_month_model->get_payroll_theme($company_id,1);
if(!empty($gen_pay_theme)){
	$bg_color_genpay=$gen_pay_theme->bg_color;
	$font_color_genpay=$gen_pay_theme->font_color;
	$overlay_genpay=$gen_pay_theme->bg_overlay;
	$bg_color_viewcomp_act_cutoff=$gen_pay_theme->view_comp_chosen_cutoff_bg;
	$actual_payslip_design=$gen_pay_theme->payslip_design;
}else{
	$bg_color_genpay="#006699";
	$font_color_genpay="#FFF";
	$overlay_genpay="#000";
	$bg_color_viewcomp_act_cutoff="#D9E6FC";
	$actual_payslip_design="117"; // default Type 1
}

    
?>