<?php
           if($pi_amount_type){
             //============Employer Fixed Amount Share Setting

            // cutoff param_id see on table system_parameters
            
            if($pi_will_deduct_on=="97"){ 
                $pi_will_deduct="1";// 1st cutoff equivalent
            }elseif($pi_will_deduct_on=="98"){
                $pi_will_deduct="2";
            }elseif($pi_will_deduct_on=="99"){
                $pi_will_deduct="3";
            }elseif($pi_will_deduct_on=="100"){
                $pi_will_deduct="4";
            }elseif($pi_will_deduct_on=="101"){
                $pi_will_deduct="5";
            }else{
                $pi_will_deduct="";
            }

                if(($cut_off!=$pi_will_deduct)AND($pi_will_deduct_on!="102")){//102 means per payday
                    $pagibig_contribution_employee=0;
                    $pagibig_contribution_employer=0;
                    $pagibig_contribution_text="deduction setup is ".$pi_will_deduct_on_name." cutoff";
                }else{
                    $pagibig_contribution_type=$pi_amount_type;
                   
                    if($pagibig_contribution_type=="103"){ // 100 from system_parameters table is "Fix" amount

                        $pagibig_contribution_employer=$fixed_employer_share; // hey set a setting for default contribution of employer
                        if($pi_will_deduct_on=="102"){//meaning per payday ang pagibig nya
                            $pagibig_contribution_employer=$fixed_employer_share/2;
                        }else{
                        }
                                           
                        $pagibig_contribution_employee=$pi_amount;
                        $pagibig_contribution_text="Employee Share (Variable) <br> Employer Share (FIX : $pagibig_contribution_employer)";
                    }else if($pagibig_contribution_type=="104"){ // 101 from system_parameters table is Employee as Percentage & Employer as Fix
                        if($pi_formula){
                                // if($payslip_state=="posted"){

                                // }else{

                                    $pagibig_formula_text=str_replace("[","{",$pi_formula);
                                    $pagibig_formula_text=str_replace("]","}",$pagibig_formula_text);
                                    $pagibig_formula_text = $pagibig_formula_text;
                                    $for_translation=$pagibig_formula_text;
                                    require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
                                    $pagibig_formula_1st=str_replace("[","",$pi_formula);
                                    $pagibig_formula_2nd=str_replace("]","",$pagibig_formula_1st);    
                                    $pagibig_formula_3=$pagibig_formula_2nd;
                                /**/$pagibig_formula_value = eval('return '.$pagibig_formula_3.';');
                                /**/$pagibig_formula_text=$pi_formula_desc."<br> $for_translation";

                                    //echo $pagibig_formula_value." :: ". $for_translation;
                                    $pagibig_contribution_employer=$fixed_employer_share;
                                    if($pi_will_deduct_on=="102"){//meaning per payday ang pagibig nya
                                        $pagibig_contribution_employer=$fixed_employer_share/2;
                                    }else{
                                    }


                                    $pagibig_contribution_employee=$pagibig_formula_value;
                                    $pagibig_contribution_text=$pi_formula_desc."<br>".$for_translation."<br> Employer Share (FIX : $pagibig_contribution_employer)";
                                //}
                        }else{
                                $pagibig_contribution_employer=0;
                                $pagibig_contribution_employee=0;
                                $pagibig_contribution_text="notice: no percentage pagibig formula reference.";

                        }
                        

                    }else if($pagibig_contribution_type=="107"){ // 104 from system_parameters table is For All Employee Percentage & Employer Percentage on table
                        
                        //============get for all pagibig table
                        $my_percentage_pagibig_setup=$this->payroll_generate_payslip_model->get_forall_pagibig_table($company_id,$employee_id,$year_cover,$net_basic_value);
                        if(!empty($my_percentage_pagibig_setup)){
                            // employEE share
                            $pi_amount=$my_percentage_pagibig_setup->employee_share;
                                   
                                    $pagibig_formula_text=str_replace("[","{",$pi_formula);
                                    $pagibig_formula_text=str_replace("]","}",$pagibig_formula_text);
                                    $pagibig_formula_text = $pagibig_formula_text;
                                    $for_translation=$pagibig_formula_text;
                                    require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
                                    $pagibig_formula_1st=str_replace("[","",$pi_formula);
                                    $pagibig_formula_2nd=str_replace("]","",$pagibig_formula_1st);    
                                    $pagibig_formula_3=$pagibig_formula_2nd;
                                /**/$pagibig_formula_value = eval('return '.$pagibig_formula_3.';');
                                /**/$pagibig_formula_text=$pi_formula_desc."<br> $for_translation";

                                    //echo $pagibig_formula_value." :: ". $for_translation;
                                    
                                    $pagibig_contribution_employee=$pagibig_formula_value;
                                    $pagibig_contribution_text_employee=$pi_formula_desc."<br>".$for_translation;

                            // employER share
                            $pi_amount=$my_percentage_pagibig_setup->employer_share;

                                    $pagibig_formula_text_er=str_replace("[","{",$pi_formula);
                                    $pagibig_formula_text_er=str_replace("]","}",$pagibig_formula_text_er);
                                    $pagibig_formula_text_er = $pagibig_formula_text_er;
                                    $for_translation=$pagibig_formula_text_er;
                                    require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
                                    $pagibig_formula_1st_er=str_replace("[","",$pi_formula);
                                    $pagibig_formula_2nd_er=str_replace("]","",$pagibig_formula_1st_er);    
                                    $pagibig_formula_3_er=$pagibig_formula_2nd_er;
                                /**/$pagibig_formula_value_er = eval('return '.$pagibig_formula_3_er.';');
                                /**/$pagibig_formula_text_er=$pi_formula_desc."<br> $for_translation";

                                    //echo $pagibig_formula_value_er." :: ". $for_translation_er;
                                    
                                    $pagibig_contribution_employer=$pagibig_formula_value_er;
                                    $pagibig_contribution_text_employer=" (Employer Share : ".$for_translation. " = $pagibig_contribution_employer )";

//====================== START TAKE EFFECT CONTRIBUTION LIMIT
                                    //====================== EMPLOYEE
                            if($minimum_employee_share=="none"){
                                $minimum_limit=0;// false
                            }else{
                                if($pagibig_contribution_employee<$minimum_employee_share){
                                    $minimum_limit=1;//true
                                    $pi_contri_nolimit=$pagibig_contribution_employee;
                                    $pagibig_contribution_employee=$minimum_employee_share;
                                }else{
                                    $minimum_limit=0;
                                }                                
                            }
                            if($maximum_employee_share=="none"){
                                $maximum_limit=0;
                            }else{
                                if($pagibig_contribution_employee>$maximum_employee_share){
                                    $maximum_limit=1;
                                    $pi_contri_nolimit=$pagibig_contribution_employee;
                                    $pagibig_contribution_employee=$maximum_employee_share;                                    
                                }else{
                                    $maximum_limit=0;
                                }
                                
                            }
                            if($maximum_limit==1){
                                $max_limit_effect=" ( before maximum limit($maximum_employee_share) take effect the value is $pi_contri_nolimit )";
                            }else{
                                $max_limit_effect="";
                            }
                            if($minimum_limit==1){
                                $min_limit_effect=" ( before minimum limit($minimum_employee_share) take effect the value is $pi_contri_nolimit )";
                            }else{
                                $min_limit_effect="";
                            }
                                    //====================== EMPLOYER
                            if($minimum_employer_share=="none"){
                                $minimum_limit_er=0;
                            }else{
                                if($pagibig_contribution_employer<$minimum_employer_share){
                                    $minimum_limit_er=1;
                                    $pi_contri_nolimit_er=$pagibig_contribution_employer;
                                    $pagibig_contribution_employer=$minimum_employer_share;
                                }else{
                                    $minimum_limit_er=0;
                                }                                
                            }
                            if($maximum_employer_share=="none"){
                                $maximum_limit_er=0;
                            }else{
                                if($pagibig_contribution_employer>$maximum_employer_share){
                                    $maximum_limit_er=1;
                                    $pi_contri_nolimit_er=$pagibig_contribution_employer;
                                    $pagibig_contribution_employer=$maximum_employer_share;                                    
                                }else{
                                    $maximum_limit_er=0;
                                }
                                if($maximum_limit_er==1){
                                    $max_limit_effect_er=" ( before maximum limit($maximum_employer_share) take effect the value is $pi_contri_nolimit_er )";
                                }else{
                                    $max_limit_effect_er="";
                                }
                                if($minimum_limit_er==1){
                                    $min_limit_effect_er=" ( before minimum limit($minimum_employer_share) take effect the value is $pi_contri_nolimit_er )";
                                }else{
                                    $min_limit_effect_er="";
                                }                                
                            }                                                                
//====================== END START TAKE EFFECT CONTRIBUTION LIMIT
                            $pagibig_contribution_text_employer=" (Employer Share : ".$for_translation. " = $pagibig_contribution_employer ) : $max_limit_effect_er $min_limit_effect_er ";
                            //echo $pagibig_contribution_employer;
                            $pagibig_contribution_text=$pagibig_contribution_text_employee." <i>$max_limit_effect $min_limit_effect</i> <br>".$pagibig_contribution_text_employer;

                        }else{

                            $pagibig_contribution_employee=0;
                            $pagibig_contribution_employer=0;
                            $pagibig_contribution_text="notice: no match on pagibig percentage table from the value of basic salary.";
                        }


                    }elseif($pagibig_contribution_type=="108"){ //Individual Employee Percentage & Employer Percentage on table




                        //============get for all pagibig table
                        $my_percentage_pagibig_setup=$this->payroll_generate_payslip_model->get_forall_pagibig_table($company_id,$employee_id,$year_cover,$net_basic_value);
                        if(!empty($my_percentage_pagibig_setup)){
                            // employEE share
                           // $pi_amount=$my_percentage_pagibig_setup->employee_share;
                                   
                                    $pagibig_formula_text=str_replace("[","{",$pi_formula);
                                    $pagibig_formula_text=str_replace("]","}",$pagibig_formula_text);
                                    $pagibig_formula_text = $pagibig_formula_text;
                                    $for_translation=$pagibig_formula_text;
                                    require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
                                    $pagibig_formula_1st=str_replace("[","",$pi_formula);
                                    $pagibig_formula_2nd=str_replace("]","",$pagibig_formula_1st);    
                                    $pagibig_formula_3=$pagibig_formula_2nd;
                                /**/$pagibig_formula_value = eval('return '.$pagibig_formula_3.';');
                                /**/$pagibig_formula_text=$pi_formula_desc."<br> $for_translation";

                                    //echo $pagibig_formula_value." :: ". $for_translation;
                                    
                                    $pagibig_contribution_employee=$pagibig_formula_value;
                                    $pagibig_contribution_text_employee=$pi_formula_desc."<br>".$for_translation;

                            // employER share
                            $pi_amount=$my_percentage_pagibig_setup->employer_share;

                                    $pagibig_formula_text_er=str_replace("[","{",$pi_formula);
                                    $pagibig_formula_text_er=str_replace("]","}",$pagibig_formula_text_er);
                                    $pagibig_formula_text_er = $pagibig_formula_text_er;
                                    $for_translation=$pagibig_formula_text_er;
                                    require(APPPATH.'views/app/payroll/payslip/transverse_variable.php');
                                    $pagibig_formula_1st_er=str_replace("[","",$pi_formula);
                                    $pagibig_formula_2nd_er=str_replace("]","",$pagibig_formula_1st_er);    
                                    $pagibig_formula_3_er=$pagibig_formula_2nd_er;
                                /**/$pagibig_formula_value_er = eval('return '.$pagibig_formula_3_er.';');
                                /**/$pagibig_formula_text_er=$pi_formula_desc."<br> $for_translation";

                                    //echo $pagibig_formula_value_er." :: ". $for_translation_er;
                                    
                                    $pagibig_contribution_employer=$pagibig_formula_value_er;
                                    $pagibig_contribution_text_employer=" (Employer Share : ".$for_translation. " = $pagibig_contribution_employer )";


                            $pagibig_contribution_text=$pagibig_contribution_text_employee."<br>".$pagibig_contribution_text_employer;

                        }else{

                            $pagibig_contribution_employee=0;
                            $pagibig_contribution_employer=0;
                            $pagibig_contribution_text="notice: no match on pagibig percentage table from the value of basic salary.";
                        }

                    }else{
                            $pagibig_contribution_employee=0;
                            $pagibig_contribution_employer=0;
                            $pagibig_contribution_text="notice: no pagibig type reference yet.";                        
                    }

                }                
      

                
           }else{
                $pagibig_contribution_employee=0;
                $pagibig_contribution_employer=0;
                $pagibig_contribution_text="";
           }


        //==============pagibig deduction at salary information setup if turned off.


                    if($round_off_payslip=="yes"){// round off
                        $pagibig_contribution_employee=round($pagibig_contribution_employee, $payslip_decimal_place);
                    }else{
                        $pagibig_contribution_employee=bcdiv($pagibig_contribution_employee, 1, $payslip_decimal_place); 
                    }   


if($salary_deduct_pagibig==0){
    
    $pagibig_contribution_employee=0;
    $pagibig_contribution_employer=0;
    $pagibig_formula_text="Pagibig Deduction is turned off.";
    $pagibig_contribution_text="";

}else{

}

        //==============no attendance.no basic income.
        if($is_salary_fixed=="1"){

        }else{


            if($no_attendance=="yes"){
                $pagibig_contribution_employee=0;
                $pagibig_contribution_employer=0;
                $pagibig_formula_text="";
                $pagibig_contribution_text="";
            }else{



            }



        }





?>