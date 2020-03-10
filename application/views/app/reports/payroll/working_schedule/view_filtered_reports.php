    <style type="text/css">
      .print{
          page-break-after: always;

      }
      .ac{
        text-align: center;
      }
    </style>
    <ol class="breadcrumb">
                <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Payroll Summary Reports | _____________
            </ol><br>
             <table id="print_table" class="table table-hover table-striped">
                <thead>
<!--                 <tr>
             
<?php 
// if($report_area=="payroll_register"){
//   if(!empty($report_fields)){
//     foreach ($report_fields as $hrow){
//     $name = $hrow->field_name; 

//       if($name=="other_addition_taxable_breakdown"){
//         echo '<th colspan="'.$tax_oa_numbers.'" class="ac">TAXABLE</th>';      
//       }elseif($name=="other_addition_non_tax_breakdown"){
//         echo '<th colspan="'.$ntax_oa_numbers.'" class="ac">NON-TAXABLE</th>';     
//       }else{
//         echo '<th>&nbsp;</th>';
//       }

//     }
//   }
// }else{}
?>
   </tr> -->


                  <tr>
                   <?php 
                   if(!empty($report_fields)){
                    foreach ($report_fields as $row){
$name = $row->field_name; 

if($name=="other_addition_taxable_breakdown"){
    if(!empty($comp_oa_taxable)){
      foreach($comp_oa_taxable as $oa_taxable){
        $oa_id=$oa_taxable->id;
        $oa_breakdown="sum_".$oa_id;
        $oa_breakdown="$oa_breakdown";
        $$oa_breakdown=0;
        echo '<th >'.$oa_taxable->other_addition_type.'[tax]</th>';
      }
    }else{}
}elseif($name=="other_addition_non_tax_breakdown"){
    if(!empty($comp_oa_nontax)){
      foreach($comp_oa_nontax as $oa_nontax){
        $oa_id=$oa_nontax->id;
        $oa_breakdown="sum_nt_".$oa_id;
        $oa_breakdown="$oa_breakdown";
        $$oa_breakdown=0;
        echo '<th >'.$oa_nontax->other_addition_type.'[non-tax]</th>';
      }
    }else{}
}elseif($name=="other_deduction_taxable_breakdown"){
    if(!empty($comp_od_taxable)){
      foreach($comp_od_taxable as $od_taxable){
        $od_id=$od_taxable->id;
        $od_breakdown="od_sum_".$od_id;
        $od_breakdown="$od_breakdown";
        $$od_breakdown=0;
        echo '<th >'.$od_taxable->other_deduction_type.'[tax]</th>';
      }
    }else{}
}elseif($name=="other_deduction_nontax_breakdown"){
    if(!empty($comp_od_nontax)){
      foreach($comp_od_nontax as $od_nontax){
        $od_id=$od_nontax->id;
        $od_breakdown="od_sum_nt_".$od_id;
        $od_breakdown="$od_breakdown";
        $$od_breakdown=0;
        echo '<th >'.$od_nontax->other_deduction_type.'[non-tax]</th>';
      }
    }else{}
}
elseif($name=="loan_breakdown"){
    if(!empty($loan_details)){
      foreach($loan_details as $loan){
        $loan_type_id=$loan->loan_type_id;
        $loan_bd="loan_sum_".$loan_type_id;
        $loan_bd="$loan_bd";
        $$loan_bd=0;
        echo '<th >'.$loan->loan_type.'</th>';
      }
    }else{}
}elseif($name=="leave_breakdown"){
    if(!empty($leave_details)){
      foreach($leave_details as $leave){
        $leave_type_id=$leave->id;

        $leave_bd="leave_sum_".$leave_type_id;
        $leave_bd="$leave_bd";
        $$leave_bd=0;

        $amt_leave_bd="amt_leave_sum_".$leave_type_id;
        $amt_leave_bd="$amt_leave_bd";
        $$amt_leave_bd=0;

        echo '<th >'.$leave->leave_type.'(HRS/DAYS)</th>'.'<th >'.$leave->leave_type.'(AMT)</th>';
      }
    }else{}
}
else{
                      echo '<th>'.$row->title.'</th>';
}
                    }
                   }else{
                    echo 'no result';
                   }

                   ?>
                  </tr>
                </thead>
                <tbody>
                
                <?php 

// ===== For time summary total declare var:

if($report_fs_type=="by_month" OR $report_fs_type=="by_year" OR $report_fs_type=="single_pp"){
foreach ($report_fields as $row){ 
  $name = $row->field_name;
  if($row->sum_me=="1"){
    $sum_var=$name."_sum";
    $sum_var_fin="$sum_var";
    $$sum_var_fin=0;
  }else{

  }
}
}else{}

                foreach($ws_data as $row1){?>
                  <tr>
                    <?php foreach ($report_fields as $row) { 
                      $name = $row->field_name; 
                      $from_dtr = $row->from_time_summary; 

if($name=="other_addition_taxable_breakdown"){
    if(!empty($comp_oa_taxable)){
      foreach($comp_oa_taxable as $oa_taxable){
        $oa_id=$oa_taxable->id;
        $employee_id=$row1->employee_id;
        $payroll_period_id=$row1->payroll_period_id;
        $check_tax="1";

        $tax_oa_var="sum_".$oa_id;
        $tax_oa_var="$tax_oa_var";

        $oa_details=$this->reports_payroll_model->get_posted_oa_taxable($employee_id,$oa_id,$payroll_period_id,$check_tax);
          if(!empty($oa_details)){ $oa_amt=$oa_details->oa_amount;
             echo '<td>'.$oa_details->oa_amount.'</td>';
                        $$tax_oa_var+=$oa_amt;    
          }else{
             echo '<td>0.00</td>';
          }
      }
    }else{}
}elseif($name=="other_addition_non_tax_breakdown"){
    if(!empty($comp_oa_nontax)){
      foreach($comp_oa_nontax as $oa_ntax){
        $oa_id=$oa_ntax->id;
        $employee_id=$row1->employee_id;
        $payroll_period_id=$row1->payroll_period_id;
        $check_tax="0";

        $ntax_oa_var="sum_nt_".$oa_id;
        $ntax_oa_var="$ntax_oa_var";

        $oa_details=$this->reports_payroll_model->get_posted_oa_taxable($employee_id,$oa_id,$payroll_period_id,$check_tax);
          if(!empty($oa_details)){ $oa_amt=$oa_details->oa_amount;
             echo '<td >'.$oa_details->oa_amount.'</td>';
                        $$ntax_oa_var+=$oa_amt;    
          }else{
             echo '<td>0.00</td>';
          }
      }
    }else{}
}elseif($name=="other_deduction_taxable_breakdown"){
    if(!empty($comp_od_taxable)){
      foreach($comp_od_taxable as $od_taxable){
        $od_id=$od_taxable->id;
        $employee_id=$row1->employee_id;
        $payroll_period_id=$row1->payroll_period_id;
        $check_tax="1";

        $tax_od_var="od_sum_".$od_id;
        $tax_od_var="$tax_od_var";

        $od_details=$this->reports_payroll_model->get_posted_od_taxable($employee_id,$od_id,$payroll_period_id,$check_tax);
          if(!empty($od_details)){ $oa_amt=$od_details->oa_amount;
             echo '<td>'.$od_details->oa_amount.'</td>';
                        $$tax_od_var+=$oa_amt;    
          }else{
             echo '<td>0.00</td>';
          }
      }
    }else{}
}elseif($name=="other_deduction_nontax_breakdown"){
    if(!empty($comp_od_nontax)){
      foreach($comp_od_nontax as $od_ntax){
        $od_id=$od_ntax->id;
        $employee_id=$row1->employee_id;
        $payroll_period_id=$row1->payroll_period_id;
        $check_tax="0";

        $ntax_od_var="od_sum_nt_".$od_id;
        $ntax_od_var="$ntax_od_var";

        $od_details=$this->reports_payroll_model->get_posted_od_taxable($employee_id,$od_id,$payroll_period_id,$check_tax);
          if(!empty($od_details)){ $oa_amt=$od_details->oa_amount;
             echo '<td >'.$od_details->oa_amount.'</td>';
                        $$ntax_od_var+=$oa_amt;    
          }else{
             echo '<td>0.00</td>';
          }
      }
    }else{}
}
elseif($name=="loan_breakdown"){
    if(!empty($loan_details)){
      foreach($loan_details as $loan){
        $loan_type_id=$loan->loan_type_id;
        $employee_id=$row1->employee_id;
        $payroll_period_id=$row1->payroll_period_id;

        $loan_var="loan_sum_".$loan_type_id;
        $loan_var="$loan_var";        
        $loan_det=$this->reports_payroll_model->get_posted_loan($employee_id,$loan_type_id,$payroll_period_id);
          if(!empty($loan_det)){ $loan_amt=$loan_det->system_deduction;
             echo '<td >'.$loan_det->system_deduction.'</td>';
                        $$loan_var+=$loan_amt;    
          }else{
             echo '<td>0.00</td>';
          }


      }
    }else{}
}elseif($name=="leave_breakdown"){
    if(!empty($leave_details)){
      foreach($leave_details as $leave){
        $leave_type_id=$leave->id;
        $employee_id=$row1->employee_id;
        $payroll_period_id=$row1->payroll_period_id;

        $leave_var="leave_sum_".$leave_type_id;
        $leave_var="$leave_var"; 

        $amt_leave_var="amt_leave_sum_".$leave_type_id;
        $amt_leave_var="$amt_leave_var";        

        $leave_det=$this->reports_payroll_model->get_posted_leave($employee_id,$leave_type_id,$payroll_period_id);
          if(!empty($leave_det)){ $leave_final=$leave_det->leave_day_type; $leave_amount=$leave_det->leave_amount;
             echo '<td >'.$leave_det->leave_day_type.'</td>';
             echo '<td >'.$leave_det->leave_amount.'</td>';
                        $$leave_var+=$leave_final;    
                        $$amt_leave_var+=$leave_amount;    
          }else{
             echo '<td>0.00</td>';
             echo '<td>0.00</td>';
          }


      }
    }else{}
}
else{

                      ?>
                    <td><?php if($name=='InActive'){ if($row1->$name=='0'){ echo 'Active';} else{ echo "InActive"; }} else { 

if($report_fs_type=="by_month" OR $report_fs_type=="by_year" OR $report_fs_type=="single_pp"){ //

          if($report_area=="pagibig"){

            if($name=="classification"){
                echo $row1->classification_name; 
            }elseif($name=="payroll_period"){
                echo $row1->complete_from." to ".$row1->complete_to; 
            }elseif($name=="month_cover"){
              echo date('F', mktime(0, 0, 0, $row1->month_cover, 10));
            }elseif($name=="share_total"){
              echo $share_total=$row1->pagibig+$row1->pagibig_employer;
            }else{
              echo $row1->$name; 
            } 
          }elseif($report_area=="sss"){

            if($name=="classification"){
                echo $row1->classification_name; 
            }elseif($name=="payroll_period"){
                echo $row1->complete_from." to ".$row1->complete_to; 
            }elseif($name=="month_cover"){
              echo date('F', mktime(0, 0, 0, $row1->month_cover, 10));
            }elseif($name=="share_total"){
              echo $share_total=$row1->sss_employee+$row1->sss_employer+$row1->sss_ec_er;
            }elseif($name=="sss_ee_er_total"){
              echo $share_total=$row1->sss_employee+$row1->sss_employer;
            }else{
              echo $row1->$name; 
            } 
          }elseif($report_area=="philhealth"){

            if($name=="classification"){
                echo $row1->classification_name; 
            }elseif($name=="payroll_period"){
                echo $row1->complete_from." to ".$row1->complete_to; 
            }elseif($name=="month_cover"){
              echo date('F', mktime(0, 0, 0, $row1->month_cover, 10));
            }elseif($name=="share_total"){
              echo $share_total=$row1->philhealth_employee+$row1->philhealth_employer;
            }else{
              echo $row1->$name; 
            } 
          }elseif($report_area=="payroll_register"){

            if($from_dtr=="1"){
              $month_cover=$row1->month_cover;
              $year_cover=$row1->year_cover;
              $employee_id=$row1->employee_id;
              $payroll_period_id=$row1->payroll_period_id;
             // $$name."_sum"=0;
              
              $my_dtr_sum_hrs=$this->reports_payroll_model->check_dtr_summary_hrs($month_cover,$year_cover,$employee_id,$payroll_period_id,$name);
              if(!empty($my_dtr_sum_hrs)){
                echo $my_dtr_sum_hrs->$name;
              
                                $add_me=$name."_sum";
                                $am="$add_me";
                                $$am+=$my_dtr_sum_hrs->$name;    

              }else{
                echo "0.00";
              }

            }else{
                        if($name=="classification"){
                            echo $row1->classification_name; 
                        }elseif($name=="payroll_period"){
                            echo $row1->complete_from." to ".$row1->complete_to; 
                        }elseif($name=="month_cover"){
                          echo date('F', mktime(0, 0, 0, $row1->month_cover, 10));
                        }elseif($name=="total_overtime_hrs"){
                          $month_cover=$row1->month_cover;
                          $year_cover=$row1->year_cover;
                          $employee_id=$row1->employee_id;
                          $payroll_period_id=$row1->payroll_period_id;

                          $ot_fields="*";
                          $hrs_dtr=$this->reports_payroll_model->check_dtr_summary_hrs($month_cover,$year_cover,$employee_id,$payroll_period_id,$ot_fields);
                          if(!empty($hrs_dtr)){
                                        $total_overtime_hrs=
                                        $hrs_dtr->total_regular_overtime+$hrs_dtr->total_regular_overtime_nd+$hrs_dtr->total_regular_hrs_restday+$hrs_dtr->total_restday_nd+
                                        $hrs_dtr->total_restday_overtime+$hrs_dtr->total_restday_overtime_nd+$hrs_dtr->total_regular_hrs_reg_holiday+$hrs_dtr->total_reg_holiday_nd+$hrs_dtr->total_reg_holiday_overtime+$hrs_dtr->total_reg_holiday_overtime_nd+$hrs_dtr->total_regular_hrs_reg_holiday_t1+$hrs_dtr->total_restday_reg_holiday_nd+$hrs_dtr->total_restday_reg_holiday_overtime+$hrs_dtr->total_restday_reg_holiday_overtime_nd+$hrs_dtr->total_regular_hrs_reg_holiday_t2+$hrs_dtr->total_regular_hrs_spec_holiday+$hrs_dtr->total_spec_holiday_nd+$hrs_dtr->total_spec_holiday_overtime+$hrs_dtr->total_spec_holiday_overtime_nd+$hrs_dtr->total_restday_regular_hrs_spec_holiday+$hrs_dtr->total_restday_spec_holiday_nd+$hrs_dtr->total_restday_spec_holiday_overtime+$hrs_dtr->total_restday_spec_holiday_overtime_nd;
                          }else{
                                      $total_overtime_hrs="0.00";
                          }
                          echo $total_overtime_hrs;
                        }else{
                          echo $row1->$name; 
                        }                
            }



          }else{

            if($name=="classification"){
                echo $row1->classification_name; 
            }elseif($name=="payroll_period"){
                echo $row1->complete_from." to ".$row1->complete_to; 
            }elseif($name=="month_cover"){
              echo date('F', mktime(0, 0, 0, $row1->month_cover, 10));
            }else{
              echo $row1->$name; 
            }            
          }



//======================  Sum Values 
                        if($row->sum_me=="1"){

                          if($row->from_time_summary=="1"){

                          }else{
                              if($name=="share_total" OR $name=="sss_ee_er_total"){
                                // no need to sum up.
                              }elseif($name=="total_overtime_hrs"){
                                $total_overtime_hrs_sum+=$total_overtime_hrs;
                              }else{
                                $add_me_var=$name."_sum";
                                $add_me_var_fin="$add_me_var";
                                $$add_me_var_fin+=$row1->$name;                            
                              }                            
                          }
                        }else{

                        }
//======================  Sum Values 

}elseif($report_area=="pagibig_group_rep"){

      if($name=="coverage"){
          
            echo $group_duration;
          
      }else{
          echo $row1->$name; 
      }
      
}else{

}

                      }?></td>
                   <?php 
}//end show fields

                   } // end foreach fields



                   ?>
                  </tr>
                <?php 

              } 




// FOr the SUM TOTAL
              if(!empty($ws_data)){
if($report_fs_type=="by_month" OR $report_fs_type=="by_year" OR $report_fs_type=="single_pp" ){

                    echo '
                    <tr>';
                    foreach ($report_fields as $row){ 
 $name = $row->field_name;
if($name=="other_addition_taxable_breakdown"){
      if(!empty($comp_oa_taxable)){
        foreach($comp_oa_taxable as $oa_taxable){
          $oa_id=$oa_taxable->id;
          $employee_id=$row1->employee_id;
          $payroll_period_id=$row1->payroll_period_id;

          $oa_breakdown_sum="sum_".$oa_id;
          $oa_breakdown_sum="$oa_breakdown_sum";
                          
         echo '<td>'.$$oa_breakdown_sum.'</td>';
        }
      }else{}
}elseif($name=="other_addition_non_tax_breakdown"){
      if(!empty($comp_oa_nontax)){
        foreach($comp_oa_nontax as $oa_ntax){
          $oa_id=$oa_ntax->id;
          $employee_id=$row1->employee_id;
          $payroll_period_id=$row1->payroll_period_id;

          $oa_breakdown_sum="sum_nt_".$oa_id;
          $oa_breakdown_sum="$oa_breakdown_sum";
                          
         echo '<td>'.$$oa_breakdown_sum.'</td>';
        }
      }else{}
}elseif($name=="other_deduction_taxable_breakdown"){
      if(!empty($comp_od_taxable)){
        foreach($comp_od_taxable as $od_taxable){
          $od_id=$od_taxable->id;
          $employee_id=$row1->employee_id;
          $payroll_period_id=$row1->payroll_period_id;

          $od_breakdown_sum="od_sum_".$od_id;
          $od_breakdown_sum="$od_breakdown_sum";
                          
         echo '<td>'.$$od_breakdown_sum.'</td>';
        }
      }else{}
}elseif($name=="other_deduction_nontax_breakdown"){
      if(!empty($comp_od_nontax)){
        foreach($comp_od_nontax as $od_ntax){
          $od_id=$od_ntax->id;
          $employee_id=$row1->employee_id;
          $payroll_period_id=$row1->payroll_period_id;

          $od_breakdown_sum="od_sum_nt_".$od_id;
          $od_breakdown_sum="$od_breakdown_sum";
                          
         echo '<td>'.$$od_breakdown_sum.'</td>';
        }
      }else{}
}
elseif($name=="loan_breakdown"){
    if(!empty($loan_details)){
      foreach($loan_details as $loan){
          $loan_type_id=$loan->loan_type_id;
          $employee_id=$row1->employee_id;
          $payroll_period_id=$row1->payroll_period_id;

          $per_loan_sum="loan_sum_".$loan_type_id;
          $per_loan_sum="$per_loan_sum";
                          
         echo '<td>'.$$per_loan_sum.'</td>';        

      }
    }
}elseif($name=="leave_breakdown"){
    if(!empty($leave_details)){
      foreach($leave_details as $leave){
          $leave_type_id=$leave->id;
          $employee_id=$row1->employee_id;
          $payroll_period_id=$row1->payroll_period_id;

          $per_leave_sum="leave_sum_".$leave_type_id;
          $per_leave_sum="$per_leave_sum";
                          
          $amt_per_leave_sum="amt_leave_sum_".$leave_type_id;
          $amt_per_leave_sum="$amt_per_leave_sum";
                          
         echo '<td>'.$$per_leave_sum.'</td>';    
         echo '<td>'.$$amt_per_leave_sum.'</td>';        

      }
    }
}
else{

                     
                      echo '<th>';
                        if($row->sum_me=="1"){
                              if(($name=="share_total")AND($report_area=="pagibig")){
                                echo $pagibig_sum+$pagibig_employer_sum;
                              }elseif(($name=="share_total")AND($report_area=="sss")){
                                echo $sss_employee_sum+$sss_employer_sum+$sss_ec_er_sum;
                              }elseif(($name=="share_total")AND($report_area=="philhealth")){
                                echo $philhealth_employee_sum+$philhealth_employer_sum;
                              }else{
                                $c=$name."_sum";
                                echo $$c;                            
                              }
                        }else{
                          echo "z:n/a";
                        }                  
                    echo '</th>';

}// end show for fields

                    }//end foreach fields


}


                   echo '</tr>'; 
}else{}                  

                ?>



                </tbody>
              </table>