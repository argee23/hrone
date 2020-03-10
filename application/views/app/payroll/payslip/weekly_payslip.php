<style type="text/css">
	.weekly_2nd_col{
    width: 45%;
	}
	.weekly_2nd_col_cont{
    width: 9%;
	}
	.weekly_3rd_col{
    width: 45%;
	}
</style>

<?php
if($cut_off=="1"){
            $three_1st='style="background-color:'.$bg_color_viewcomp_act_cutoff.';font-weight:bold;"';
            $three_2nd="";
            $three_3rd="";
            $three_4th="";
            $three_5th="";
}elseif($cut_off=="2"){
            $three_1st="";
            $three_2nd='style="background-color:'.$bg_color_viewcomp_act_cutoff.';font-weight:bold;"';
            $three_3rd="";
            $three_4th="";
            $three_5th="";
}elseif($cut_off=="3"){
            $three_1st="";
            $three_2nd="";
            $three_3rd='style="background-color:'.$bg_color_viewcomp_act_cutoff.';font-weight:bold;"';
            $three_4th="";
            $three_5th="";
}elseif($cut_off=="4"){
            $three_1st="";
            $three_2nd="";
            $three_3rd="";
            $three_4th='style="background-color:'.$bg_color_viewcomp_act_cutoff.';font-weight:bold;"';
            $three_5th="";
}elseif($cut_off=="5"){
            $three_1st="";
            $three_2nd="";
            $three_3rd="";
            $three_4th="";
            $three_5th='style="background-color:'.$bg_color_viewcomp_act_cutoff.';font-weight:bold;"';           
}else{

}
require(APPPATH.'views/app/payroll/payslip/weekly/compute_weekly_basic.php');  
require(APPPATH.'views/app/payroll/payslip/weekly/compute_weekly_ot.php');  

        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: ginagamit din ito sa semi-monthly
            require(APPPATH.'views/app/payroll/payslip/compute_other_addition.php');  
            require(APPPATH.'views/app/payroll/payslip/compute_cola.php');  
            require(APPPATH.'views/app/payroll/payslip/compute_other_deduction.php');  
            require(APPPATH.'views/app/payroll/payslip/compute_gross_formula.php');  
            require(APPPATH.'views/app/payroll/payslip/compute_loan.php');  
           
            require(APPPATH.'views/app/payroll/payslip/weekly/compute_sss.php');   // configure me
            require(APPPATH.'views/app/payroll/payslip/weekly/compute_philhealth.php');  
            require(APPPATH.'views/app/payroll/payslip/compute_pagibig.php');  
            require(APPPATH.'views/app/payroll/payslip/compute_overbreak.php');    
            require(APPPATH.'views/app/payroll/payslip/compute_absent.php');   
            require(APPPATH.'views/app/payroll/payslip/compute_late.php');  
            require(APPPATH.'views/app/payroll/payslip/compute_undertime.php');
            require(APPPATH.'views/app/payroll/payslip/compute_taxable_income.php'); 
            require(APPPATH.'views/app/payroll/payslip/compute_tax.php');  
            require(APPPATH.'views/app/payroll/payslip/compute_income_summary.php'); 
            require(APPPATH.'views/app/payroll/payslip/compute_deduction_summary.php'); 
            require(APPPATH.'views/app/payroll/payslip/compute_netpay.php');  
if($selected_payroll_option=="view"){


?>
<!--//=========================================================== START BASIC DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">BASIC</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_basic;}else{echo $net_basic_value;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_basic;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_basic;}else{echo $net_basic_value;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_basic;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_basic;}else{echo $net_basic_value;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_basic;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_basic;}else{echo $net_basic_value;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_basic;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_basic;}else{echo $net_basic_value;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_basic;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($fifth_cutoff_payslip_state=="posted"){
			echo nl2br($first_posted_net_basic_formula);
	}else{
			if($net_basic_formula){
				echo $basic_formula_text;
			}else{
				echo 'Notice: no net basic formula yet.';
			}
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
			echo nl2br($second_posted_net_basic_formula);
	}else{
			if($net_basic_formula){
				echo $basic_formula_text;
			}else{
				echo 'Notice: no net basic formula yet.';
			}
	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
			echo nl2br($third_posted_net_basic_formula);
	}else{
			if($net_basic_formula){
				echo $basic_formula_text;
			}else{
				echo 'Notice: no net basic formula yet.';
			}
	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
			echo nl2br($fourth_posted_net_basic_formula);
	}else{
			if($net_basic_formula){
				echo $basic_formula_text;
			}else{
				echo 'Notice: no net basic formula yet.';
			}
	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
			echo nl2br($fifth_posted_net_basic_formula);
	}else{
			if($net_basic_formula){
				echo $basic_formula_text;
			}else{
				echo 'Notice: no net basic formula yet.';
			}
	}
}


			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END BASIC  -->
<!--//=========================================================== START OVERTIME DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">OVERTIME</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_overtime;}else{echo $total_overtime_amount;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_overtime;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_overtime;}else{echo $total_overtime_amount;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_overtime;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_overtime;}else{echo $total_overtime_amount;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_overtime;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_overtime;}else{echo $total_overtime_amount;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_overtime;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_overtime;}else{echo $total_overtime_amount;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_overtime;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_ot_formula);
	}else{
			if($ot_formula){
		echo ''.$ot_formula_desc.'<br>
                    '.$regot_formula_text.'<br>
                    '.$regotnd_formula_text.'<br><br>

                    '.$rdot_with_out_nd_formula_text.'<br>
                    '.$rdot_withnd_formula_text.'<br>
                    '.$rdot_ot_with_out_nd_formula_text.'<br>
                    '.$rdot_ot_withnd_formula_text.'<br><br>

                    '.$rhot_with_out_nd_formula_text.'<br>
                    '.$rhot_withnd_formula_text.'<br>
                    '.$rhot_ot_with_out_nd_formula_text.'<br>
                    '.$rhot_ot_withnd_formula_text.'<br><br>

                    '.$rh_rdt2_formula_text.'<br><br>

                    '.$rh_rdt1_ot_with_out_nd_formula_text.'<br>
                    '.$rh_rdt1_ot_withnd_formula_text.'<br>
                    '.$rh_rdt1_ot_ot_with_out_nd_formula_text.'<br>
                    '.$rh_rdt1_ot_ot_withnd_formula_text.'<br><br>  

                    '.$snwot_with_out_nd_formula_text.'<br>
                    '.$snwot_withnd_formula_text.'<br>
                    '.$snwot_ot_with_out_nd_formula_text.'<br>
                    '.$snwot_ot_withnd_formula_text.'<br><br>   

                    '.$snw_rd_ot_with_out_nd_formula_text.'<br>
                    '.$snw_rd_ot_withnd_formula_text.'<br>
                    '.$snw_rd_ot_ot_with_out_nd_formula_text.'<br>
                    '.$snw_rd_ot_ot_withnd_formula_text.'<br><br> ';
			}else{
				echo 'Notice: no overtime formula yet.';
			}
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($second_posted_ot_formula);
	}else{
			if($ot_formula){
		echo ''.$ot_formula_desc.'<br>
                    '.$regot_formula_text.'<br>
                    '.$regotnd_formula_text.'<br><br>

                    '.$rdot_with_out_nd_formula_text.'<br>
                    '.$rdot_withnd_formula_text.'<br>
                    '.$rdot_ot_with_out_nd_formula_text.'<br>
                    '.$rdot_ot_withnd_formula_text.'<br><br>

                    '.$rhot_with_out_nd_formula_text.'<br>
                    '.$rhot_withnd_formula_text.'<br>
                    '.$rhot_ot_with_out_nd_formula_text.'<br>
                    '.$rhot_ot_withnd_formula_text.'<br><br>

                    '.$rh_rdt2_formula_text.'<br><br>

                    '.$rh_rdt1_ot_with_out_nd_formula_text.'<br>
                    '.$rh_rdt1_ot_withnd_formula_text.'<br>
                    '.$rh_rdt1_ot_ot_with_out_nd_formula_text.'<br>
                    '.$rh_rdt1_ot_ot_withnd_formula_text.'<br><br>  

                    '.$snwot_with_out_nd_formula_text.'<br>
                    '.$snwot_withnd_formula_text.'<br>
                    '.$snwot_ot_with_out_nd_formula_text.'<br>
                    '.$snwot_ot_withnd_formula_text.'<br><br>   

                    '.$snw_rd_ot_with_out_nd_formula_text.'<br>
                    '.$snw_rd_ot_withnd_formula_text.'<br>
                    '.$snw_rd_ot_ot_with_out_nd_formula_text.'<br>
                    '.$snw_rd_ot_ot_withnd_formula_text.'<br><br> ';
			}else{
				echo 'Notice: no overtime formula yet.';
			}
	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($third_posted_ot_formula);
	}else{
			if($ot_formula){
		echo ''.$ot_formula_desc.'<br>
                    '.$regot_formula_text.'<br>
                    '.$regotnd_formula_text.'<br><br>

                    '.$rdot_with_out_nd_formula_text.'<br>
                    '.$rdot_withnd_formula_text.'<br>
                    '.$rdot_ot_with_out_nd_formula_text.'<br>
                    '.$rdot_ot_withnd_formula_text.'<br><br>

                    '.$rhot_with_out_nd_formula_text.'<br>
                    '.$rhot_withnd_formula_text.'<br>
                    '.$rhot_ot_with_out_nd_formula_text.'<br>
                    '.$rhot_ot_withnd_formula_text.'<br><br>

                    '.$rh_rdt2_formula_text.'<br><br>

                    '.$rh_rdt1_ot_with_out_nd_formula_text.'<br>
                    '.$rh_rdt1_ot_withnd_formula_text.'<br>
                    '.$rh_rdt1_ot_ot_with_out_nd_formula_text.'<br>
                    '.$rh_rdt1_ot_ot_withnd_formula_text.'<br><br>  

                    '.$snwot_with_out_nd_formula_text.'<br>
                    '.$snwot_withnd_formula_text.'<br>
                    '.$snwot_ot_with_out_nd_formula_text.'<br>
                    '.$snwot_ot_withnd_formula_text.'<br><br>   

                    '.$snw_rd_ot_with_out_nd_formula_text.'<br>
                    '.$snw_rd_ot_withnd_formula_text.'<br>
                    '.$snw_rd_ot_ot_with_out_nd_formula_text.'<br>
                    '.$snw_rd_ot_ot_withnd_formula_text.'<br><br> ';
			}else{
				echo 'Notice: no overtime formula yet.';
			}
	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($fourth_posted_ot_formula);
	}else{
			if($ot_formula){
		echo ''.$ot_formula_desc.'<br>
                    '.$regot_formula_text.'<br>
                    '.$regotnd_formula_text.'<br><br>

                    '.$rdot_with_out_nd_formula_text.'<br>
                    '.$rdot_withnd_formula_text.'<br>
                    '.$rdot_ot_with_out_nd_formula_text.'<br>
                    '.$rdot_ot_withnd_formula_text.'<br><br>

                    '.$rhot_with_out_nd_formula_text.'<br>
                    '.$rhot_withnd_formula_text.'<br>
                    '.$rhot_ot_with_out_nd_formula_text.'<br>
                    '.$rhot_ot_withnd_formula_text.'<br><br>

                    '.$rh_rdt2_formula_text.'<br><br>

                    '.$rh_rdt1_ot_with_out_nd_formula_text.'<br>
                    '.$rh_rdt1_ot_withnd_formula_text.'<br>
                    '.$rh_rdt1_ot_ot_with_out_nd_formula_text.'<br>
                    '.$rh_rdt1_ot_ot_withnd_formula_text.'<br><br>  

                    '.$snwot_with_out_nd_formula_text.'<br>
                    '.$snwot_withnd_formula_text.'<br>
                    '.$snwot_ot_with_out_nd_formula_text.'<br>
                    '.$snwot_ot_withnd_formula_text.'<br><br>   

                    '.$snw_rd_ot_with_out_nd_formula_text.'<br>
                    '.$snw_rd_ot_withnd_formula_text.'<br>
                    '.$snw_rd_ot_ot_with_out_nd_formula_text.'<br>
                    '.$snw_rd_ot_ot_withnd_formula_text.'<br><br> ';
			}else{
				echo 'Notice: no overtime formula yet.';
			}
	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($fifth_posted_ot_formula);
	}else{
			if($ot_formula){
		echo ''.$ot_formula_desc.'<br>
                    '.$regot_formula_text.'<br>
                    '.$regotnd_formula_text.'<br><br>

                    '.$rdot_with_out_nd_formula_text.'<br>
                    '.$rdot_withnd_formula_text.'<br>
                    '.$rdot_ot_with_out_nd_formula_text.'<br>
                    '.$rdot_ot_withnd_formula_text.'<br><br>

                    '.$rhot_with_out_nd_formula_text.'<br>
                    '.$rhot_withnd_formula_text.'<br>
                    '.$rhot_ot_with_out_nd_formula_text.'<br>
                    '.$rhot_ot_withnd_formula_text.'<br><br>

                    '.$rh_rdt2_formula_text.'<br><br>

                    '.$rh_rdt1_ot_with_out_nd_formula_text.'<br>
                    '.$rh_rdt1_ot_withnd_formula_text.'<br>
                    '.$rh_rdt1_ot_ot_with_out_nd_formula_text.'<br>
                    '.$rh_rdt1_ot_ot_withnd_formula_text.'<br><br>  

                    '.$snwot_with_out_nd_formula_text.'<br>
                    '.$snwot_withnd_formula_text.'<br>
                    '.$snwot_ot_with_out_nd_formula_text.'<br>
                    '.$snwot_ot_withnd_formula_text.'<br><br>   

                    '.$snw_rd_ot_with_out_nd_formula_text.'<br>
                    '.$snw_rd_ot_withnd_formula_text.'<br>
                    '.$snw_rd_ot_ot_with_out_nd_formula_text.'<br>
                    '.$snw_rd_ot_ot_withnd_formula_text.'<br><br> ';
			}else{
				echo 'Notice: no overtime formula yet.';
			}
	}
}




			echo '</td>

	    </tr>  
	';
?>      
<!--//=========================================================== END OVERTIME  -->

<!--//=========================================================== START WORKING SCHEDULE NIGHT DIFFERENTIAL DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">WORKING SCHEDULE NIGHT DIFFERENTIAL</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_shift_night_diff;}else{echo $ws_nd_value;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_shift_night_diff;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_shift_night_diff;}else{echo $ws_nd_value;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_shift_night_diff;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_shift_night_diff;}else{echo $ws_nd_value;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_shift_night_diff;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_shift_night_diff;}else{echo $ws_nd_value;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_shift_night_diff;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_shift_night_diff;}else{echo $ws_nd_value;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_shift_night_diff;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_shift_night_diff_formula);
	}else{
			if($ot_formula){
				echo $ws_nd_formula_text;
			}else{
				echo 'Notice: no overtime formula yet.';
			}
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($second_posted_shift_night_diff_formula);
	}else{
			if($ot_formula){
				echo $ws_nd_formula_text;
			}else{
				echo 'Notice: no overtime formula yet.';
			}
	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($third_posted_shift_night_diff_formula);
	}else{
			if($ot_formula){
				echo $ws_nd_formula_text;
			}else{
				echo 'Notice: no overtime formula yet.';
			}
	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($fourth_posted_shift_night_diff_formula);
	}else{
			if($ot_formula){
				echo $ws_nd_formula_text;
			}else{
				echo 'Notice: no overtime formula yet.';
			}
	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($fifth_posted_shift_night_diff_formula);
	}else{
			if($ot_formula){
				echo $ws_nd_formula_text;
			}else{
				echo 'Notice: no overtime formula yet.';
			}
	}
}


			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END WORKING SCHEDULE NIGHT DIFFERENTIAL  -->
<!--//=========================================================== START OTHER ADDITION TAXABLE DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">OTHER ADDITIONS TAXABLE</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_other_addition_taxable;}else{echo $total_taxable_oa;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_other_addition_taxable;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_other_addition_taxable;}else{echo $total_taxable_oa;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_other_addition_taxable;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_other_addition_taxable;}else{echo $total_taxable_oa;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_other_addition_taxable;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_other_addition_taxable;}else{echo $total_taxable_oa;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_other_addition_taxable;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_other_addition_taxable;}else{echo $total_taxable_oa;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_other_addition_taxable;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_oa_taxable_how_to);
	}else{
		echo     $oae_taxable_list.'<br>
                 '.$auto_oae_taxable_list.'<br>
                 '.$auto_ot_meal_allowance_how_to_taxable.'<br>
                 '.$taxable_payroll_leave_adjustment_how_to;
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($second_posted_oa_taxable_how_to);
	}else{
		echo     $oae_taxable_list.'<br>
                 '.$auto_oae_taxable_list.'<br>
                 '.$auto_ot_meal_allowance_how_to_taxable.'<br>
                 '.$taxable_payroll_leave_adjustment_how_to;

	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($third_posted_oa_taxable_how_to);
	}else{
		echo     $oae_taxable_list.'<br>
                 '.$auto_oae_taxable_list.'<br>
                 '.$auto_ot_meal_allowance_how_to_taxable.'<br>
                 '.$taxable_payroll_leave_adjustment_how_to;

	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($fourth_posted_oa_taxable_how_to);
	}else{
		echo     $oae_taxable_list.'<br>
                 '.$auto_oae_taxable_list.'<br>
                 '.$auto_ot_meal_allowance_how_to_taxable.'<br>
                 '.$taxable_payroll_leave_adjustment_how_to;

	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($fifth_posted_oa_taxable_how_to);
	}else{
		echo     $oae_taxable_list.'<br>
                 '.$auto_oae_taxable_list.'<br>
                 '.$auto_ot_meal_allowance_how_to_taxable.'<br>
                 '.$taxable_payroll_leave_adjustment_how_to;

	}
}
			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END OF OTHER ADDITION TAXABLE  -->


<!--//=========================================================== START OTHER ADDITION NON-TAXABLE DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">OTHER ADDITIONS NON-TAXABLE</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_other_addition_non_tax;}else{echo $total_nontaxable_oa;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_other_addition_non_tax;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_other_addition_non_tax;}else{echo $total_nontaxable_oa;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_other_addition_non_tax;;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_other_addition_non_tax;;}else{echo $total_nontaxable_oa;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_other_addition_non_tax;;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_other_addition_non_tax;;}else{echo $total_nontaxable_oa;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_other_addition_non_tax;;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_other_addition_non_tax;;}else{echo $total_nontaxable_oa;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_other_addition_non_tax;;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_oa_nontax_how_to);
	}else{
		echo     $oae_nontaxable_list.'<br>
                 '.$auto_oae_nontaxable_list.'<br>
                 '.$auto_ot_meal_allowance_how_to_nontaxable.'<br>
                 '.$nontax_payroll_leave_adjustment_how_to;
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($second_posted_oa_nontax_how_to);
	}else{
		echo     $oae_nontaxable_list.'<br>
                 '.$auto_oae_nontaxable_list.'<br>
                 '.$auto_ot_meal_allowance_how_to_nontaxable.'<br>
                 '.$nontax_payroll_leave_adjustment_how_to;

	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($third_posted_oa_nontax_how_to);
	}else{
		echo     $oae_nontaxable_list.'<br>
                 '.$auto_oae_nontaxable_list.'<br>
                 '.$auto_ot_meal_allowance_how_to_nontaxable.'<br>
                 '.$nontax_payroll_leave_adjustment_how_to;

	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($fourth_posted_oa_nontax_how_to);
	}else{
		echo     $oae_nontaxable_list.'<br>
                 '.$auto_oae_nontaxable_list.'<br>
                 '.$auto_ot_meal_allowance_how_to_nontaxable.'<br>
                 '.$nontax_payroll_leave_adjustment_how_to;

	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($fifth_posted_oa_nontax_how_to);
	}else{
		echo     $oae_nontaxable_list.'<br>
                 '.$auto_oae_nontaxable_list.'<br>
                 '.$auto_ot_meal_allowance_how_to_nontaxable.'<br>
                 '.$nontax_payroll_leave_adjustment_how_to;

	}
}
			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END OF OTHER ADDITION NON-TAXABLE  -->

<!--//=========================================================== START COLA DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">COLA</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_cola;}else{echo $total_cola_amount;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_cola;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_cola;}else{echo $total_cola_amount;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_cola;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_cola;}else{echo $total_cola_amount;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_cola;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_cola;}else{echo $total_cola_amount;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_cola;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_cola;}else{echo $total_cola_amount;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_cola;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($first_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_cola_how_to);
	}else{
			if($cola_formula){
				echo $cola_formula_text;
			}else{
				echo 'Notice: no cola formula yet.';
			}
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_cola_how_to);
	}else{
			if($cola_formula){
				echo $cola_formula_text;
			}else{
				echo 'Notice: no cola formula yet.';
			}
	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_cola_how_to);
	}else{
			if($cola_formula){
				echo $cola_formula_text;
			}else{
				echo 'Notice: no cola formula yet.';
			}
	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_cola_how_to);
	}else{
			if($cola_formula){
				echo $cola_formula_text;
			}else{
				echo 'Notice: no cola formula yet.';
			}
	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_cola_how_to);
	}else{
			if($cola_formula){
				echo $cola_formula_text;
			}else{
				echo 'Notice: no cola formula yet.';
			}
	}
}


			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END COLA  -->

<!--//=========================================================== START OTHER DEDUCTION TAXABLE DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">OTHER DEDUCTION TAXABLE</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_other_deduction_taxable;}else{echo $total_taxable_od;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_other_deduction_taxable;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_other_deduction_taxable;}else{echo $total_taxable_od;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_other_deduction_taxable;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_other_deduction_taxable;}else{echo $total_taxable_od;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_other_deduction_taxable;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_other_deduction_taxable;}else{echo $total_taxable_od;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_other_deduction_taxable;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_other_deduction_taxable;}else{echo $total_taxable_od;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_other_deduction_taxable;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_od_taxable_how_to);
	}else{
		echo     $ode_taxable_list.'<br>
                 '.$auto_ode_taxable_list.'<br>';
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($second_posted_od_taxable_how_to);
	}else{
		echo     $ode_taxable_list.'<br>
                 '.$auto_ode_taxable_list.'<br>';

	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($third_posted_oa_taxable_how_to);
	}else{
		echo     $ode_taxable_list.'<br>
                 '.$auto_ode_taxable_list.'<br>';

	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($fourth_posted_oa_taxable_how_to);
	}else{
		echo     $ode_taxable_list.'<br>
                 '.$auto_ode_taxable_list.'<br>';

	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($fifth_posted_oa_taxable_how_to);
	}else{
		echo     $ode_taxable_list.'<br>
                 '.$auto_ode_taxable_list.'<br>';

	}
}
			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END OF OTHER DEDUCTION TAXABLE  -->



<!--//=========================================================== START OTHER DEDUCTION NON-TAXABLE DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">OTHER DEDUCTION NON-TAXABLE</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_other_deduction_nontax;}else{echo $total_nontaxable_od;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_other_deduction_nontax;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_other_deduction_nontax;}else{echo $total_nontaxable_od;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_other_deduction_nontax;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_other_deduction_nontax;}else{echo $total_nontaxable_od;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_other_deduction_nontax;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_other_deduction_nontax;}else{echo $total_nontaxable_od;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_other_deduction_nontax;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_other_deduction_nontax;}else{echo $total_nontaxable_od;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_other_deduction_nontax;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_od_nontax_how_to);
	}else{
		echo     $ode_nontaxable_list.'<br>
                 '.$auto_ode_nontaxable_list.'<br>';
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($second_posted_od_nontax_how_to);
	}else{
		echo     $ode_nontaxable_list.'<br>
                 '.$auto_ode_nontaxable_list.'<br>';

	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($third_posted_od_nontax_how_to);
	}else{
		echo     $ode_nontaxable_list.'<br>
                 '.$auto_ode_nontaxable_list.'<br>';

	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($fourth_posted_od_nontax_how_to);
	}else{
		echo     $ode_nontaxable_list.'<br>
                 '.$auto_ode_nontaxable_list.'<br>';

	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($fifth_posted_od_nontax_how_to);
	}else{
		echo     $ode_nontaxable_list.'<br>
                 '.$auto_ode_nontaxable_list.'<br>';

	}
}
			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END OF OTHER DEDUCTION NON-TAXABLE  -->


<!--//=========================================================== START GROSS DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">GROSS</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_gross;}else{echo $gross_formula_value;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_gross;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_gross;}else{echo $gross_formula_value;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_gross;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_gross;}else{echo $gross_formula_value;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_gross;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_gross;}else{echo $gross_formula_value;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_gross;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_gross;}else{echo $gross_formula_value;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_gross;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($first_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_gross_formula);
	}else{
			if($gross_formula){
				echo $gross_formula_text;
			}else{
				echo 'Notice: no gross formula yet.';
			}
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($second_posted_gross_formula);
	}else{
			if($gross_formula){
				echo $gross_formula_text;
			}else{
				echo 'Notice: no gross formula yet.';
			}
	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($third_posted_gross_formula);
	}else{
			if($gross_formula){
				echo $gross_formula_text;
			}else{
				echo 'Notice: no gross formula yet.';
			}
	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($fourth_posted_gross_formula);
	}else{
			if($gross_formula){
				echo $gross_formula_text;
			}else{
				echo 'Notice: no gross formula yet.';
			}
	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($fifth_posted_gross_formula);
	}else{
			if($gross_formula){
				echo $gross_formula_text;
			}else{
				echo 'Notice: no gross formula yet.';
			}
	}
}


			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END GROSS  -->

<!--//=========================================================== START LOAN DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">LOAN</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_loan;}else{echo $total_loan;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_loan;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_loan;}else{echo $total_loan;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_loan;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_loan;}else{echo $total_loan;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_loan;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_loan;}else{echo $total_loan;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_loan;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_loan;}else{echo $total_loan;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_loan;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($first_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_loan_how_to);
	}else{
		echo '      '.$loan_text.'<br>
                    '.$pause_loan_text.'<br>
                    '.$nonpriority_loan_text.'<br>';
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($second_posted_loan_how_to);
	}else{
		echo '      '.$loan_text.'<br>
                    '.$pause_loan_text.'<br>
                    '.$nonpriority_loan_text.'<br>';
	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($third_posted_loan_how_to);
	}else{
		echo '      '.$loan_text.'<br>
                    '.$pause_loan_text.'<br>
                    '.$nonpriority_loan_text.'<br>';
	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($fourth_posted_loan_how_to);
	}else{
		echo '      '.$loan_text.'<br>
                    '.$pause_loan_text.'<br>
                    '.$nonpriority_loan_text.'<br>';
	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($fifth_posted_loan_how_to);
	}else{
		echo '      '.$loan_text.'<br>
                    '.$pause_loan_text.'<br>
                    '.$nonpriority_loan_text.'<br>';
	}
}


			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END LOAN  -->


<!--//=========================================================== START SSS DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">SSS</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_sss_employee;}else{echo $sss_employee_share;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_sss_employee;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_sss_employee;}else{echo $sss_employee_share;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_sss_employee;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_sss_employee;}else{echo $sss_employee_share;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_sss_employee;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_sss_employee;}else{echo $sss_employee_share;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_sss_employee;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_sss_employee;}else{echo $sss_employee_share;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_sss_employee;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($first_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_sss_formula);
	}else{
			if($sss_formula){
				echo $sss_formula_text.'<br><br>
                    '.$sss_employer_share_text;
			}else{
				echo 'Notice: no sss formula yet.';
			}
	
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($second_posted_sss_formula);
	}else{
			if($sss_formula){
				echo $sss_formula_text.'<br><br>
                    '.$sss_employer_share_text;
			}else{
				echo 'Notice: no sss formula yet.';
			}
	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($third_posted_sss_formula);
	}else{
			if($sss_formula){
				echo $sss_formula_text.'<br><br>
                    '.$sss_employer_share_text;
			}else{
				echo 'Notice: no sss formula yet.';
			}
	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($fourth_posted_sss_formula);
	}else{
			if($sss_formula){
				echo $sss_formula_text.'<br><br>
                    '.$sss_employer_share_text;
			}else{
				echo 'Notice: no sss formula yet.';
			}
	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($fifth_posted_sss_formula);
	}else{
			if($sss_formula){
				echo $sss_formula_text.'<br><br>
                    '.$sss_employer_share_text;
			}else{
				echo 'Notice: no sss formula yet.';
			}
	}
}


			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END SSS  -->

<!--//=========================================================== START PHILHEALTH DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">PHILHEALTH</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_philhealth_employee;}else{echo $philhealth_employee_share;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_philhealth_employee;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_philhealth_employee;}else{echo $philhealth_employee_share;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_philhealth_employee;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_philhealth_employee;}else{echo $philhealth_employee_share;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_philhealth_employee;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_philhealth_employee;}else{echo $philhealth_employee_share;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_philhealth_employee;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_philhealth_employee;}else{echo $philhealth_employee_share;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_philhealth_employee;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($first_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_ph_formula);
	}else{
			if($philhealth_formula){
				echo $philhealth_formula_text.'<br><br>
                    '.$philhealth_employer_share_text;
			}else{
				echo 'Notice: no philhealth formula yet.';
			}
	
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($second_posted_ph_formula);
	}else{
			if($philhealth_formula){
				echo $philhealth_formula_text.'<br><br>
                    '.$philhealth_employer_share_text;
			}else{
				echo 'Notice: no philhealth formula yet.';
			}
	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($third_posted_ph_formula);
	}else{
			if($philhealth_formula){
				echo $philhealth_formula_text.'<br><br>
                    '.$philhealth_employer_share_text;
			}else{
				echo 'Notice: no philhealth formula yet.';
			}
	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($fourth_posted_ph_formula);
	}else{
			if($philhealth_formula){
				echo $philhealth_formula_text.'<br><br>
                    '.$philhealth_employer_share_text;
			}else{
				echo 'Notice: no philhealth formula yet.';
			}
	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($fifth_posted_ph_formula);
	}else{
			if($philhealth_formula){
				echo $philhealth_formula_text.'<br><br>
                    '.$philhealth_employer_share_text;
			}else{
				echo 'Notice: no philhealth formula yet.';
			}
	}
}


			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END PHILHEALTH  -->

<!--//=========================================================== START PAGIBIG DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">PAGIBIG</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_pagibig;}else{echo $pagibig_contribution_employee;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_pagibig;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_pagibig;}else{echo $pagibig_contribution_employee;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_pagibig;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_pagibig;}else{echo $pagibig_contribution_employee;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_pagibig;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_pagibig;}else{echo $pagibig_contribution_employee;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_pagibig;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_pagibig;}else{echo $pagibig_contribution_employee;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_pagibig;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($first_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_pi_formula);
	}else{
			 if(($pi_amount)AND($pi_amount_type)){
				echo $pagibig_contribution_text.'<br>';
			}else{
				echo 'Notice: no pagibig enrollment reference yet.';
			}
	
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($second_posted_pi_formula);
	}else{
			 if(($pi_amount)AND($pi_amount_type)){
				echo $pagibig_contribution_text.'<br>';
			}else{
				echo 'Notice: no pagibig enrollment reference yet.';
			}
	
	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($third_posted_pi_formula);
	}else{
			 if(($pi_amount)AND($pi_amount_type)){
				echo $pagibig_contribution_text.'<br>';
			}else{
				echo 'Notice: no pagibig enrollment reference yet.';
			}
	
	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($fourth_posted_pi_formula);
	}else{
			 if(($pi_amount)AND($pi_amount_type)){
				echo $pagibig_contribution_text.'<br>';
			}else{
				echo 'Notice: no pagibig enrollment reference yet.';
			}
	
	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($fifth_posted_pi_formula);
	}else{
			 if(($pi_amount)AND($pi_amount_type)){
				echo $pagibig_contribution_text.'<br>';
			}else{
				echo 'Notice: no pagibig enrollment reference yet.';
			}
	
	}
}
			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END PAGIBIG  -->


<!--//=========================================================== START ABSENT DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">ABSENT</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_absent;}else{echo $absent_formula_value;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_absent;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_absent;}else{echo $absent_formula_value;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_absent;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_absent;}else{echo $absent_formula_value;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_absent;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_absent;}else{echo $absent_formula_value;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_absent;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_absent;}else{echo $absent_formula_value;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_absent;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($first_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_absent_formula);
	}else{
			 if($absent_formula){
				echo $absent_formula_text.'<br>';
			}else{
				echo 'Notice: no absent formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($second_posted_absent_formula);
	}else{
			 if($absent_formula){
				echo $absent_formula_text.'<br>';
			}else{
				echo 'Notice: no absent formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($third_posted_absent_formula);
	}else{
			 if($absent_formula){
				echo $absent_formula_text.'<br>';
			}else{
				echo 'Notice: no absent formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($fourth_posted_absent_formula);
	}else{
			 if($absent_formula){
				echo $absent_formula_text.'<br>';
			}else{
				echo 'Notice: no absent formula reference setup yet.';
			}
	
	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($fifth_posted_absent_formula);
	}else{
			 if($absent_formula){
				echo $absent_formula_text.'<br>';
			}else{
				echo 'Notice: no absent formula reference setup yet.';
			}
	
	}
}
			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END ABSENT  -->

<!--//=========================================================== START LATE DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">LATE</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_late;}else{echo $late_formula_value;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_late;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_late;}else{echo $late_formula_value;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_late;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_late;}else{echo $late_formula_value;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_late;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_late;}else{echo $late_formula_value;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_late;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_late;}else{echo $late_formula_value;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_late;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($first_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_late_formula);
	}else{
			 if($late_formula){
				echo $late_formula_text.'<br>';
			}else{
				echo 'Notice: no late formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($second_posted_late_formula);
	}else{
			 if($late_formula){
				echo $late_formula_text.'<br>';
			}else{
				echo 'Notice: no late formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($third_posted_late_formula);
	}else{
			 if($late_formula){
				echo $late_formula_text.'<br>';
			}else{
				echo 'Notice: no late formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($fourth_posted_late_formula);
	}else{
			 if($late_formula){
				echo $late_formula_text.'<br>';
			}else{
				echo 'Notice: no late formula reference setup yet.';
			}
	
	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($fifth_posted_late_formula);
	}else{
			 if($late_formula){
				echo $late_formula_text.'<br>';
			}else{
				echo 'Notice: no late formula reference setup yet.';
			}
	
	}
}
			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END LATE  -->


<!--//=========================================================== START UNDERTIME DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">UNDERTIME</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_undertime;}else{echo $undertime_formula_value;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_undertime;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_undertime;}else{echo $undertime_formula_value;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_undertime;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_undertime;}else{echo $undertime_formula_value;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_undertime;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_undertime;}else{echo $undertime_formula_value;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_undertime;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_undertime;}else{echo $undertime_formula_value;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_undertime;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($first_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_ut_formula);
	}else{
			 if($ut_formula){
				echo $undertime_formula_text.'<br>';
			}else{
				echo 'Notice: no undertime formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($second_posted_ut_formula);
	}else{
			 if($ut_formula){
				echo $undertime_formula_text.'<br>';
			}else{
				echo 'Notice: no undertime formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($third_posted_ut_formula);
	}else{
			 if($ut_formula){
				echo $undertime_formula_text.'<br>';
			}else{
				echo 'Notice: no undertime formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($fourth_posted_ut_formula);
	}else{
			 if($ut_formula){
				echo $undertime_formula_text.'<br>';
			}else{
				echo 'Notice: no undertime formula reference setup yet.';
			}
	
	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($fifth_posted_ut_formula);
	}else{
			 if($ut_formula){
				echo $undertime_formula_text.'<br>';
			}else{
				echo 'Notice: no undertime formula reference setup yet.';
			}
	
	}
}
			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END UNDERTIME  -->

<!--//=========================================================== START OVERBREAK DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">OVERBREAK</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_overbreak;}else{echo $overbreak_formula_value;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_overbreak;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_overbreak;}else{echo $overbreak_formula_value;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_overbreak;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_overbreak;}else{echo $overbreak_formula_value;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_overbreak;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_overbreak;}else{echo $overbreak_formula_value;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_overbreak;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_overbreak;}else{echo $overbreak_formula_value;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_overbreak;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($first_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_overbreak_formula);
	}else{
			 if($overbreak_formula){
				echo $overbreak_formula_text.'<br>';
			}else{
				echo 'Notice: no overbreak formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($second_posted_overbreak_formula);
	}else{
			 if($overbreak_formula){
				echo $overbreak_formula_text.'<br>';
			}else{
				echo 'Notice: no overbreak formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($third_posted_overbreak_formula);
	}else{
			 if($overbreak_formula){
				echo $overbreak_formula_text.'<br>';
			}else{
				echo 'Notice: no overbreak formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($fourth_posted_overbreak_formula);
	}else{
			 if($overbreak_formula){
				echo $overbreak_formula_text.'<br>';
			}else{
				echo 'Notice: no overbreak formula reference setup yet.';
			}
	
	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($fifth_posted_overbreak_formula);
	}else{
			 if($overbreak_formula){
				echo $overbreak_formula_text.'<br>';
			}else{
				echo 'Notice: no overbreak formula reference setup yet.';
			}
	
	}
}
			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END OVERBREAK  -->

<!--//=========================================================== START TAXABLE DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">TAXABLE</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_taxable;}else{echo $actual_taxable_formula_value;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_taxable;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_taxable;}else{echo $actual_taxable_formula_value;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_taxable;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_taxable;}else{echo $actual_taxable_formula_value;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_taxable;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_taxable;}else{echo $actual_taxable_formula_value;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_taxable;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_taxable;}else{echo $actual_taxable_formula_value;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_taxable;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($first_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_taxable_formula);
	}else{
			 if($taxable_formula){
				echo $taxable_formula_text.'<br>';
			}else{
				echo 'Notice: no taxable formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($second_posted_taxable_formula);
	}else{
			 if($taxable_formula){
				echo $taxable_formula_text.'<br>';
			}else{
				echo 'Notice: no taxable formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($third_posted_taxable_formula);
	}else{
			 if($taxable_formula){
				echo $taxable_formula_text.'<br>';
			}else{
				echo 'Notice: no taxable formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($fourth_posted_taxable_formula);
	}else{
			 if($taxable_formula){
				echo $taxable_formula_text.'<br>';
			}else{
				echo 'Notice: no taxable formula reference setup yet.';
			}
	
	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($fifth_posted_taxable_formula);
	}else{
			 if($taxable_formula){
				echo $taxable_formula_text.'<br>';
			}else{
				echo 'Notice: no taxable formula reference setup yet.';
			}
	
	}
}
			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END TAXABLE  -->


<!--//=========================================================== START WTAX DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">WTAX ( '.$taxcode_name.' ) </td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_wtax;}else{echo $witheld_tax;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_wtax;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_wtax;}else{echo $witheld_tax;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_wtax;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_wtax;}else{echo $witheld_tax;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_wtax;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_wtax;}else{echo $witheld_tax;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_wtax;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_wtax;}else{echo $witheld_tax;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_wtax;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($first_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_wtax_formula);
	}else{
			 if($wtax_formula){
				echo $wtax_formula_text.'<br>';
			}else{
				echo 'Notice: no wtax formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($second_posted_wtax_formula);
	}else{
			 if($wtax_formula){
				echo $wtax_formula_text.'<br>';
			}else{
				echo 'Notice: no wtax formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($third_posted_wtax_formula);
	}else{
			 if($wtax_formula){
				echo $wtax_formula_text.'<br>';
			}else{
				echo 'Notice: no wtax formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($fourth_posted_wtax_formula);
	}else{
			 if($wtax_formula){
				echo $wtax_formula_text.'<br>';
			}else{
				echo 'Notice: no wtax formula reference setup yet.';
			}
	
	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($fifth_posted_wtax_formula);
	}else{
			 if($wtax_formula){
				echo $wtax_formula_text.'<br>';
			}else{
				echo 'Notice: no wtax formula reference setup yet.';
			}
	
	}
}
			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END WTAX  -->


<!--//=========================================================== START INCOME SUMMARY DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">INCOME SUMMARY</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_income_total;}else{echo $income_sum_formula_value;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_income_total;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_income_total;}else{echo $income_sum_formula_value;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_income_total;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_income_total;}else{echo $income_sum_formula_value;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_income_total;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_income_total;}else{echo $income_sum_formula_value;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_income_total;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_income_total;}else{echo $income_sum_formula_value;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_income_total;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($first_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_income_total_how_to);
	}else{
			 if($income_sum_formula){
				echo $income_sum_formula_text.'<br>';
			}else{
				echo 'Notice: no income summary formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($second_posted_income_total_how_to);
	}else{
			 if($income_sum_formula){
				echo $income_sum_formula_text.'<br>';
			}else{
				echo 'Notice: no income summary formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($third_posted_income_total_how_to);
	}else{
			 if($income_sum_formula){
				echo $income_sum_formula_text.'<br>';
			}else{
				echo 'Notice: no income summary formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($fourth_posted_income_total_how_to);
	}else{
			 if($income_sum_formula){
				echo $income_sum_formula_text.'<br>';
			}else{
				echo 'Notice: no income summary formula reference setup yet.';
			}
	
	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($fifth_posted_income_total_how_to);
	}else{
			 if($income_sum_formula){
				echo $income_sum_formula_text.'<br>';
			}else{
				echo 'Notice: no income summary formula reference setup yet.';
			}
	
	}
}
			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END INCOME SUMMARY  -->


<!--//=========================================================== START DEDUCTION SUMMARY DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">DEDUCTION SUMMARY</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_deduction_total;}else{echo $deduction_sum_formula_value;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_deduction_total;}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_deduction_total;}else{echo $deduction_sum_formula_value;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_deduction_total;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_deduction_total;}else{echo $deduction_sum_formula_value;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_deduction_total;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_deduction_total;}else{echo $deduction_sum_formula_value;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_deduction_total;}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_deduction_total;}else{echo $deduction_sum_formula_value;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_deduction_total;}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($first_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_deduction_total_how_to);
	}else{
			 if($deduction_sum_formula){
				echo $deduction_sum_formula_text.'<br>';
			}else{
				echo 'Notice: no deduction summary formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($second_posted_deduction_total_how_to);
	}else{
			 if($deduction_sum_formula){
				echo $deduction_sum_formula_text.'<br>';
			}else{
				echo 'Notice: no deduction summary formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($third_posted_deduction_total_how_to);
	}else{
			 if($deduction_sum_formula){
				echo $deduction_sum_formula_text.'<br>';
			}else{
				echo 'Notice: no deduction summary formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($fourth_posted_deduction_total_how_to);
	}else{
			 if($deduction_sum_formula){
				echo $deduction_sum_formula_text.'<br>';
			}else{
				echo 'Notice: no deduction summary formula reference setup yet.';
			}
	
	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($fifth_posted_deduction_total_how_to);
	}else{
			 if($deduction_sum_formula){
				echo $deduction_sum_formula_text.'<br>';
			}else{
				echo 'Notice: no deduction summary formula reference setup yet.';
			}
	
	}
}
			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END DEDUCTION SUMMARY  -->


<!--//=========================================================== START NETPAY DISPLAY -->
<?php
	echo '
	    <tr>
	        <td class="topic_class">NETPAY</td>
		    <td colspan="2" class="weekly_2nd_col">
		    		<table>
		    			<tr>
		    				<td class="weekly_2nd_col_cont" '.$three_1st.'>';
if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_netpay; echo "<br><br><b>POSTED</b>";}else{echo $net_pay_formula_value;}
}else{
		if($first_cutoff_payslip_state=="posted"){echo $first_posted_netpay; echo "<br><br><b>POSTED</b>";}else{echo "0.00";}
}

echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_2nd.'>';
if($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_netpay; echo "<br><br><b>POSTED</b>";}else{echo $net_pay_formula_value;}
}else{
		if($second_cutoff_payslip_state=="posted"){echo $second_posted_netpay; echo "<br><br><b>POSTED</b>";}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_3rd.'>';
if($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_netpay; echo "<br><br><b>POSTED</b>";}else{echo $net_pay_formula_value;}
}else{
		if($third_cutoff_payslip_state=="posted"){echo $third_posted_netpay; echo "<br><br><b>POSTED</b>";}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_4th.'>';
if($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_netpay; echo "<br><br><b>POSTED</b>";}else{echo $net_pay_formula_value;}
}else{
		if($fourth_cutoff_payslip_state=="posted"){echo $fourth_posted_netpay; echo "<br><br><b>POSTED</b>";}else{echo "0.00";}
}
echo '		    				</td>
		    				<td class="weekly_2nd_col_cont" '.$three_5th.'>';
if($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_netpay; echo "<br><br><b>POSTED</b>";}else{echo $net_pay_formula_value;}
}else{
		if($fifth_cutoff_payslip_state=="posted"){echo $fifth_posted_netpay; echo "<br><br><b>POSTED</b>";}else{echo "0.00";}
}
echo '		    				</td>


		    			</tr>
		    		</table>
		    </td>
			<td class="weekly_3rd_col">';
if($cut_off=="1"){
	if($first_cutoff_payslip_state=="posted"){
		echo nl2br($first_posted_net_pay_formula);
	}else{
			 if($net_pay_formula){
				echo $net_pay_formula_text.'<br>';
			}else{
				echo 'Notice: no  net pay formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="2"){
	if($second_cutoff_payslip_state=="posted"){
		echo nl2br($second_posted_net_pay_formula);
	}else{
			 if($net_pay_formula){
				echo $net_pay_formula_text.'<br>';
			}else{
				echo 'Notice: no  net pay formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="3"){
	if($third_cutoff_payslip_state=="posted"){
		echo nl2br($third_posted_net_pay_formula);
	}else{
			 if($net_pay_formula){
				echo $net_pay_formula_text.'<br>';
			}else{
				echo 'Notice: no  net pay formula reference setup yet.';
			}
	
	}
}elseif($cut_off=="4"){
	if($fourth_cutoff_payslip_state=="posted"){
		echo nl2br($fourth_posted_net_pay_formula);
	}else{
			 if($net_pay_formula){
				echo $net_pay_formula_text.'<br>';
			}else{
				echo 'Notice: no  net pay formula reference setup yet.';
			}
	
	}
}else{
	if($fifth_cutoff_payslip_state=="posted"){
		echo nl2br($fifth_posted_net_pay_formula);
	}else{
			 if($net_pay_formula){
				echo $net_pay_formula_text.'<br>';
			}else{
				echo 'Notice: no  net pay formula reference setup yet.';
			}
	
	}
}
			echo '</td>

	    </tr>  
	';
?>
      
<!--//=========================================================== END DEDUCTION SUMMARY  -->

<?php
}elseif($selected_payroll_option=="post_all"){
	if($cut_off=="1"){
		if($first_cutoff_payslip_state=="posted"){
		    echo "
		    <tr>
		    <td colspan='6'><i class='fa fa-check-square text-info' style='font-size:48px;'></i> 
		    Payroll is already posted previously.
		    <span class='system_auto_guide'> If you would like to repost/recalculate the payroll reset the payslip first . go to payroll > reset payslip</span>
		    <i class='fa fa-quote-right text-info' style='font-size:20px;'></i>
		    </td></tr>";
		}else{
		 	require(APPPATH.'views/app/payroll/payslip/save_payroll.php');	
		}

	}elseif($cut_off=="2"){
		if($second_cutoff_payslip_state=="posted"){
		    echo "
		    <tr>
		    <td colspan='6'><i class='fa fa-check-square text-info' style='font-size:48px;'></i> 
		    Payroll is already posted previously.
		    <span class='system_auto_guide'> If you would like to repost/recalculate the payroll reset the payslip first . go to payroll > reset payslip</span>
		    <i class='fa fa-quote-right text-info' style='font-size:20px;'></i>
		    </td></tr>";
		}else{
		 	require(APPPATH.'views/app/payroll/payslip/save_payroll.php');	
		}
	}elseif($cut_off=="3"){
		if($third_cutoff_payslip_state=="posted"){
		    echo "
		    <tr>
		    <td colspan='6'><i class='fa fa-check-square text-info' style='font-size:48px;'></i> 
		    Payroll is already posted previously.
		    <span class='system_auto_guide'> If you would like to repost/recalculate the payroll reset the payslip first . go to payroll > reset payslip</span>
		    <i class='fa fa-quote-right text-info' style='font-size:20px;'></i>
		    </td></tr>";
		}else{
		 	require(APPPATH.'views/app/payroll/payslip/save_payroll.php');	
		}
	}elseif($cut_off=="4"){
		if($fourth_cutoff_payslip_state=="posted"){
		    echo "
		    <tr>
		    <td colspan='6'><i class='fa fa-check-square text-info' style='font-size:48px;'></i> 
		    Payroll is already posted previously.
		    <span class='system_auto_guide'> If you would like to repost/recalculate the payroll reset the payslip first . go to payroll > reset payslip</span>
		    <i class='fa fa-quote-right text-info' style='font-size:20px;'></i>
		    </td></tr>";
		}else{
		 	require(APPPATH.'views/app/payroll/payslip/save_payroll.php');	
		}
	}elseif($cut_off=="5"){
		if($fifth_cutoff_payslip_state=="posted"){
		    echo "
		    <tr>
		    <td colspan='6'><i class='fa fa-check-square text-info' style='font-size:48px;'></i> 
		    Payroll is already posted previously.
		    <span class='system_auto_guide'> If you would like to repost/recalculate the payroll reset the payslip first . go to payroll > reset payslip</span>
		    <i class='fa fa-quote-right text-info' style='font-size:20px;'></i>
		    </td></tr>";
		}else{
		 	require(APPPATH.'views/app/payroll/payslip/save_payroll.php');	
		}
	}else{//

	}
}else{

}
?>