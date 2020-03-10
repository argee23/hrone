<?php
// this page will be called if netpay result to negative value. and priority deduction settings is turned on
$pd_loan=$this->payroll_generate_payslip_model->get_employee_loan($employee_id,$pay_period,$pay_period_from,$pay_period_to);
if(!empty($pd_loan)){
		$total_loan="";
		$loan_text="";


	foreach($loan as $myloan){
			$loan_type_id=$myloan->loan_type_id;
			$emp_loan_id=$myloan->emp_loan_id;
			$will_deduct_on=$myloan->option;
			$priority_deduction=$myloan->priority_deduction;
			
if($priority_deduction=="on"){
	if($will_deduct_on=="6"){ // per pay_day deduction
		$proceed_deduction="yes";
	}else{

		if (strpos($will_deduct_on, '-') !== false) {
			$explode_numbers=substr_count($will_deduct_on, '-');

			if($explode_numbers=="1"){
				list($ded_one,$ded_two) = explode("-",$will_deduct_on);
				$deduction_location="1";
			}elseif($explode_numbers=="2"){
				list($ded_one,$ded_two,$ded_three) = explode("-",$will_deduct_on);
				$deduction_location="2";
			}elseif($explode_numbers=="3"){
				list($ded_one,$ded_two,$ded_three,$ded_four) = explode("-",$will_deduct_on);
				$deduction_location="3";
			}elseif($explode_numbers=="4"){
				list($ded_one,$ded_two,$ded_three,$ded_four,$ded_five) = explode("-",$will_deduct_on);
				$deduction_location="4";
			}
				if($deduction_location=="1"){
					if($cut_off==$ded_one OR $cut_off==$ded_two){
						$proceed_deduction="yes";
					}else{
						$proceed_deduction="no";
					}
				}elseif($deduction_location=="2"){
					if($cut_off==$ded_one OR $cut_off==$ded_two OR $cut_off==$ded_three){
						$proceed_deduction="yes";
					}else{
						$proceed_deduction="no";
					}

				}elseif($deduction_location=="3"){
					if($cut_off==$ded_one OR $cut_off==$ded_two OR $cut_off==$ded_three OR $cut_off==$ded_four){
						$proceed_deduction="yes";
					}else{
						$proceed_deduction="no";
					}

				}elseif($deduction_location=="4"){
					if($cut_off==$ded_one OR $cut_off==$ded_two OR $cut_off==$ded_three OR $cut_off==$ded_four OR $cut_off==$ded_five){
						$proceed_deduction="yes";
					}else{
						$proceed_deduction="no";
					}

				}else{

				}		
		}else{
				if($will_deduct_on==$cut_off){
					$proceed_deduction="yes";
				}else{
					$proceed_deduction="no";
				}
				
		}


	}


	// ===================== start check history of deduction
	$check_loan_deduction=$this->payroll_generate_payslip_model->get_loan_deduction($employee_id,$pay_period,$pay_period_from,$pay_period_to,$loan_type_id,$emp_loan_id,$month_cover);

	if(!empty($check_loan_deduction)){
			$total_prev_system_deduction="";
		foreach($check_loan_deduction as $deduction_history){
			$prev_system_deduction=$deduction_history->system_deduction;
			$total_prev_system_deduction+=$prev_system_deduction;
		}
	}else{
			$total_prev_system_deduction=0;
	}	
	// ===================== end check history of deduction
				$loan_type_name=$myloan->loan_type_name;
				$amortization=$myloan->amortization;
				
				$loan_status=$myloan->status;

				$orig_loan_amt=$myloan->loan_amt;
				$loan_amt=$myloan->loan_amt;
				$loan_amt=$loan_amt-$total_prev_system_deduction;

	if($loan_status=="Active"){

					if($loan_amt>=$amortization){ 
						$amortization=$amortization;
						$my_current_balance=$orig_loan_amt-($total_prev_system_deduction+$amortization);
						//echo "HEY $my_current_balance $total_prev_system_deduction<BR>";
					}else{
						$amortization=$loan_amt; 
						$my_current_balance=$orig_loan_amt-($total_prev_system_deduction+$amortization);
					}

		if($proceed_deduction=="yes"){  
					if($amortization<=0){
						$total_loan+=0;
						$loan_payment_no=1;
					}else{


						$check_loan_deduction_no=$this->payroll_generate_payslip_model->check_loan_deduction_no($employee_id,$loan_type_id,$emp_loan_id,$month_cover);

						if(!empty($check_loan_deduction_no)){
							$loan_payment_no=$check_loan_deduction_no->payment_no;
							$loan_payment_no=$loan_payment_no+1;
						}else{
							$loan_payment_no=1;
						}



	// if($selected_payroll_option=="post_all"){

	// 	if(($cut_off=="1")AND($first_cutoff_payslip_state=="posted")){

	// 	}elseif(($cut_off=="2")AND($second_cutoff_payslip_state=="posted")){

	// 	}else{

	// 		$save_each_loan_amortization = array(
	// 			'emp_loan_id' => $emp_loan_id,
	// 			'company_id' => $company_id,
	// 			'employee_id' => $employee_id,
	// 			'payroll_period_id' => $pay_period,
	// 			'loan_type_id' => $loan_type_id,
	// 			'original_balance' => $orig_loan_amt,
	// 			'system_deduction' => $amortization,
	// 			'payment_no' => $loan_payment_no,
	// 			'current_balance' => $my_current_balance,
	// 			'date_process' => date('Y-m-d H:i:s'),
	// 			'system_user' => '',

	// 		);
	// 		$save_payroll=$this->payroll_generate_payslip_model->post_loan_amortization($save_each_loan_amortization,$month_cover);

	// if($my_current_balance=="0"){
	// 	$query=$this->db->query("update payroll_emp_loan_enrolment set status='Paid',paid_type='automatic_paid_marked' where emp_loan_id='".$emp_loan_id."' ");	
	// }else{

	// }
	// 	}

		
	// }else{

	// }

						$total_loan+=$amortization;
					}
			
			if($selected_payroll_option=="post_all"){
				$loan_text.=$loan_type_name." (".$amortization.") <i class='fa fa-arrow-right'></i> current balance : $my_current_balance<br>";
			}else{
				$loan_text.=$loan_type_name." (".$amortization.")<br>";
			}
			

		}else{
			//$loan_compress_to_post.="";
			$loan_text.="";
			$total_loan+=0;
		}
				$pause_loan_text="";

	//==============================start LOAN decimal 
	if($follow_loan_decimal_policy=="yes"){

	            if($loan_roundoff=="yes"){// round off
	                $total_loan=round($total_loan, $loan_decimal_place);
	            }else{
	                $total_loan=bcdiv($total_loan, 1, $loan_decimal_place); 
	            }

	}else{
	            if($round_off_payslip=="yes"){// round off
	                $total_loan=round($total_loan, $payslip_decimal_place);
	            }else{
	                $total_loan=bcdiv($total_loan, 1, $payslip_decimal_place); 
	            }	
	}

	//==============================end LOAN decimal 

	}else{//Pause loan
				$pause_loan_text.= "<span class='text-danger'>(".$loan_type_name." : deduction was set to pause.)</span><br>";
	}


}else{

	if($selected_payroll_option=="post_all"){
	$remove_non_priority=$this->payroll_generate_payslip_model->remove_non_priority($employee_id,$month_cover,$pay_period,$loan_type_id);

	}else{

	}
	
	$nonpriority_loan_text.= "<span class='text-danger'>(".$myloan->loan_type_name." : this was not deducted due to negative netpay in accordance to priority deduction setup.)</span><br>";

}




	}// end of foreach





}else{
	$nonpriority_loan_text="";
	$orig_loan_amt=0;
	$loan_type_name="";
	$loan_amt="";
	$amortization="";
	$will_deduct_on="";
	$total_loan=0;
	$loan_text="";
	$pause_loan_text="";
	$my_current_balance="";
	//$loan_compress_to_post="";

}


?>