    <?php

    if($years>=1){
            /* Check Yealy Increment Setup , Else , Check yearly fixed credit if ANY*/
          if(!empty($year_inc)){

                $maximum_credit=$year_inc->max;
                $inc_value= $year_inc->add_leave_bal;
                $month_will_inc= $year_inc->increment;

             
              if($month_will_inc==1){ /*If will increment every month*/
                  //y_month_inc means -> the day that increment will take effect
                  //t_day means -> current day

                  /* Check if the current month is already included in the counting of (month/s) increment */
                  if($y_month_inc<=$t_day){
                    $this_month=$this_month;
                  }else{
                    $this_month=$this_month-1;
                  }
                  
                  $final_as_of_inc=($inc_value*$this_month)+$emp_lyc;

                  $how=" + (".$inc_value." X ".$this_month.")";
                  $test_value="(location: yearly increment every 1st month)";

                  /* Check if the credit is greater than the maximum credit set. */
                  if($final_as_of_inc>$maximum_credit){
                      $final_as_of_inc=$maximum_credit;
                      $maximum_credit_allowed=$maximum_credit;
                  }else{
                      $final_as_of_inc=$final_as_of_inc;
                      $maximum_credit_allowed="";
                  }

                  $cre_bal_this_year="";

              }else if($month_will_inc>1){

                /* Check if the current month is already included in the counting of (month/s) increment */
                if($y_month_inc<=$t_day){
                  $this_month=$this_month;
                }else{
                  $this_month=$this_month-1;
                }

                  $check_m=$this_month/$month_will_inc;
                  $check_m2=floor($check_m); // get the integer only
                  $as_of_inc=$inc_value*$check_m2;
                  $final_as_of_inc=$as_of_inc+$emp_lyc;
                  
                  $cre_bal_this_year=$final_as_of_inc;
                  $how=" + (".$inc_value." * integer of ".$this_month."/".$month_will_inc.")";
                  $test_value="(location: yearly increment every more than (1) month)";
                  $final_as_of_inc=$final_as_of_inc;


                  if($month_will_inc=="12"){
                    $final_as_of_inc=$inc_value;

                    $how=" $inc_value : this year credit setup";
                    $test_value="(location: every anniversary credit";


                  }else{

                  }

                  /* Check if the credit is greater than the maximum credit set. */
                  if($final_as_of_inc>$maximum_credit){
                      $final_as_of_inc=$maximum_credit;
                      $maximum_credit_allowed=$maximum_credit;
                  }else{
                      $final_as_of_inc=$final_as_of_inc;
                      $maximum_credit_allowed="";
                  }

              }else{

                      /* start check first if fixed credit yealy is set. */
                 $isyearly_credit_fixed=$leave->isyearly_credit_fixed;
                 $fcv=$leave->fixed_credit_value;
                 $yfc_m=$leave->yearly_fixed_credit_month;
                 $yfc_d=$leave->yearly_fixed_credit_day;
                 $yfc_effect=$yfc_m."-".$yfc_d;
                 if($isyearly_credit_fixed=="yes"){
                    if($yfc_effect<=$check_current_month_day){
                        $how="";
                        $test_value="(location: fixed credit yearly)<br>";
                        $final_as_of_inc=$fcv;
                        $cre_bal_this_year=$fcv;    
                        $maximum_credit_allowed="";
                    }else{             
                        $how=0;
                        $test_value="(location: you left here)<br>";
                        $final_as_of_inc=0;
                        $cre_bal_this_year=0;                      
                    }
             
                 }else{

                      $how=0;
                      $test_value="(location: Notice: You have No setup for after a year credit.)<br>";
                      $final_as_of_inc=0;
                      $cre_bal_this_year=0;   
                      $maximum_credit_allowed="";         
                 }
                      /* end check first if fixed credit yealy is set. */
              }

              //}
          }else{
                  /* start check first if fixed credit yealy is set. */
             $isyearly_credit_fixed=$leave->isyearly_credit_fixed;
             $fcv=$leave->fixed_credit_value;
             $yfc_m=$leave->yearly_fixed_credit_month;
             $yfc_d=$leave->yearly_fixed_credit_day;
             $yfc_effect=$yfc_m."-".$yfc_d;
             if($isyearly_credit_fixed=="yes"){
                if($yfc_effect<=$check_current_month_day){
                    $how="";
                    $test_value="(location: fixed credit yearly)<br>";
                    $final_as_of_inc=$fcv+$emp_lyc;
                    $cre_bal_this_year=$fcv;    
                    $maximum_credit_allowed="";
                }else{             
                    $how=0;
                    $test_value="(location: you left here)<br>";
                    $final_as_of_inc=0;
                    $cre_bal_this_year=0;                      
                }
         
             }else{

                  $how="";
                  $test_value="(location: Notice: You have No setup for after a year credit.)<br>";
                  $final_as_of_inc=0;
                  $cre_bal_this_year=0;     
                  $maximum_credit_allowed="";       
             }
                  /* end check first if fixed credit yealy is set. */

          }
          $starting_credit="no";
        }else{// if($years<1    

              /* CHECK IF BILANG NG MONTHS OF STAY NYA IS GREATER THAN OR EQUAL TO EFFECTIVITY
              IF TRUE : YUNG START VALUE ANG CREDITS NYA
              ELSE : WALA PA SYANG CREDITS
              */
            if($months>=$leave->effectivity){
                      

                  
                  if($reset_date<=$current_date){
                    // last year credits already ends.

                    if($years<1){//wala pang 1 year & naabutan ng end of fiscal year.
                         $maximum_credit_allowed="";
                        $final_as_of_inc=0;
                        $test_value=" (location: 1st year of employment credit: fiscal year already ends)";
                        $how="above is earned from start value. (fiscal year already ends).";
                    }else{

                    }

                  }else{
                      
                      $maximum_credit_allowed="";
                      $test_value=" (location: 1st year of employment credit)";
                      $final_as_of_inc=$start_value;
                      $how="above is earned from start value setup.";
                      $cre_bal_this_year=$start_value;                    

                  }
                  

            }else{
              /*starting credit is not yet applicable*/
                  $how=0;
                  $test_value="(location: starting credit is not applicable yet.)<br>";
                  $final_as_of_inc=0;
                  $cre_bal_this_year=0;

            }
            $starting_credit="yes";
        }


        ?>