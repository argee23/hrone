<?php
        //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: ABSENT   
        //echo  "$pagibig_contribution";

            if($taxable_formula==""){
            	$taxable_formula_text="Notice: No Absent Formula Setup Yet.";
            	$taxable_formula_value=0;
            }else{

			        $taxable_formula_text=str_replace("[","{",$taxable_formula);
			        $taxable_formula_text=str_replace("]","}",$taxable_formula_text);
			        $taxable_formula_text = $taxable_formula_text;
			        $for_translation=$taxable_formula_text;
			        require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
			        $taxable_formula_1st=str_replace("[","",$taxable_formula);
			        $taxable_formula_2nd=str_replace("]","",$taxable_formula_1st);    
			        $taxable_formula_3=$taxable_formula_2nd;


			    /**/$taxable_formula_value = eval('return '.$taxable_formula_3.';');
if($pagibig_contribution_employee>$pagibig_taxable_contri_ceil){
	//400-100
	$taxable_pagibig=$pagibig_contribution_employee-$pagibig_taxable_contri_ceil;
	
	$taxable_pagibig_how=" = $taxable_formula_value ; recompute: add taxable pagibig: $taxable_pagibig";
	$taxable_formula_value=$taxable_formula_value+$taxable_pagibig;
}else{
	$taxable_pagibig_how="";
}

		            if($round_off_payslip=="yes"){// round off
		                $taxable_formula_value=round($taxable_formula_value, $payslip_decimal_place);
		            }else{
		                $taxable_formula_value=bcdiv($taxable_formula_value, 1, $payslip_decimal_place); 
		            }	

		            $actual_taxable_formula_value=$taxable_formula_value;

			    /**/$taxable_formula_text=$taxable_formula_desc."<br> $for_translation $taxable_pagibig_how= $taxable_formula_value";

			    	//echo $taxable_formula_value." :: ". $taxable_formula_text;
	           

            }

            // $taxable_formula_value="";
            // $taxable_formula_text="";


if($tax_deduction_type=="general by taxtable" OR $tax_deduction_type=="2"){
	$tax_deduction_type_name="base on taxtable";

}elseif($tax_deduction_type=="general annualize"){
	$tax_deduction_type_name="Annualize tax";
 	require(APPPATH.'views/app/payroll/payslip/compute_annualize_taxable.php');

}else{//individual employee setup of tax deduction type
		$my_tax_ded_type=$this->payroll_generate_payslip_model->check_tax_deduction_type($employee_id);
		if(!empty($my_tax_ded_type)){
			$tax_deduction_type=$my_tax_ded_type->tax_type;

			if($tax_deduction_type=="tax_table"){
				$tax_deduction_type_name="base on taxtable";
			}else{//annualize
				$tax_deduction_type_name="Annualize tax";
	 			require(APPPATH.'views/app/payroll/payslip/compute_annualize_taxable.php');
			}
		}else{
			$tax_deduction_type=="tax_table";// default tax reference base on tax table.
			$tax_deduction_type_name="base on taxtable";
		}

}



?>