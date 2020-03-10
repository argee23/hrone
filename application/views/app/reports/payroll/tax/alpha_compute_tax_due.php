<?php
			
$wtax_formula_desc="( ( TOTAL TAXABLE AMT - Tax CODE Rate ) * Tax percentage ) + Tax exemption";
			$tax_table_name="tax_table_".$e->company_id;
			$validate_tax_table=$this->payroll_generate_payslip_model->check_tax_table($tax_table_name);
			if(!empty($validate_tax_table)){
						//3 : semi monthly // 4 monthly rate  
						$taxcode_id=1; // 1 : s/me single married
						$wtax_table_setup=$this->payroll_generate_payslip_model->get_wtax_table($e->company_id,3,4,$covered_year,$taxcode_id,$total_taxable);

						if(!empty($wtax_table_setup)){
								$tax_code_field="tax_code_".$taxcode_id;
								$exempt_percentage=$wtax_table_setup->exempt_percentage;
								$exempt_value=$wtax_table_setup->exempt_value;
								$tax_code_field=$wtax_table_setup->taxcodefield;

								//option 1
								foreach($taxcodeList as $tc_list){
									$tcid=$tc_list->taxcode_id;
									$transpose_var='tax_code_'.$tcid;
									$$transpose_var=$tax_code_field; // yes this is double dollar sign.
								}
								//option 2
								
								// start compute tax

								$wtax_formula='( ( [$total_taxable] - [$tax_code] ) * [$exempt_percentage] ) + [$exempt_value]';

							        $wtax_formula_text=str_replace("[","{",$wtax_formula);
							        $wtax_formula_text=str_replace("]","}",$wtax_formula_text);
							        $wtax_formula_text = $wtax_formula_text;

									$string = "$wtax_formula_text";
									$newword='tax_code_'.$taxcode_id; // get the taxcode id
									$newstring = str_replace("tax_code", $newword, $string);
									$wtax_formula_text=$newstring;

								        $for_translation=$wtax_formula_text;
								        require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
								        $wtax_formula_1st=str_replace("[","",$wtax_formula);
								        $wtax_formula_2nd=str_replace("]","",$wtax_formula_1st);    

									$string_2 = "$wtax_formula_2nd";
									$newword_2='tax_code_1';
									$newstring_2 = str_replace("tax_code", $newword_2, $string_2);
									$wtax_formula_3=$newstring_2;
										        		     
								    	
								    	$witheld_tax = eval('return '.$wtax_formula_3.';');
								    	$wtax_formula_text=$wtax_formula_desc."&#10; $for_translation = $witheld_tax";

					}else{

					}
			}else{
				$witheld_tax=0;
			}


			$witheld_tax_nf=number_format($witheld_tax,$payslip_decimal_place);

?>