<?php
	$check_prev_early_cutoff_dates= $this->time_dtr_model->check_prev_early_cutoff_dates($pay_period,$p_from);
	if(!empty($check_prev_early_cutoff_dates)){

		$withearlycutoff_payroll_period_id=$check_prev_early_cutoff_dates->payroll_period_id;

		$prev_early_cutoff_date= $this->time_dtr_model->PrevEarlyCutoffStartDate($withearlycutoff_payroll_period_id);
		$p_from=$prev_early_cutoff_date->date_covered;

	}else{
		$withearlycutoff_payroll_period_id="";

	}

?>