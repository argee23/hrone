<?php

            echo '
            <table class="table">
            <thead>
              <tr>
                <th>Leave Types</th>
                <th>Action</th>
                <th>&nbsp;</th>
              </tr>
            </thead><tbody>
            ';
            if(!empty($comp_leave_typ)){
              foreach($comp_leave_typ as $c){
                $IsDisabled=$c->IsDisabled;

                if($IsDisabled=="0"){//
                  $des="";
                }else{
                  $des='class="bg-danger"';
                }


                  // $view_emp = '<i class="fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_view_color.';" data-toggle="tooltip" data-placement="left" title="Click to view employee credits & convert it to cash" onclick="view_emp('.$c->id.')"></i>';

                    echo '
                    <tr>
                      <td '.$des.'>'.$c->leave_type.'</td> <td>';


                $pp_group=$this->leave_conversion_model->getPayrollPeriodGroup($company_id);
                if(!empty($pp_group)){
                  foreach($pp_group as $p){
                   $leaveid_and_payperiod_group_id=$c->id."M".$p->payroll_period_group_id;
                   ?>

                    <a onclick="view_emp('<?php echo $leaveid_and_payperiod_group_id;?>');"><?php echo '<i class="fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_view_color.';" data-toggle="tooltip" data-placement="left" title="Click to view employee credits & convert it to cash" ></i>Payroll Period Group: '.$p->group_name.'<br>';  ?></a>
                   <?php

                  }
                  
                }else{
                  echo 'notice: you must create a payroll period group first.';
                }

                      echo '
                     </td> <td id="col_2"></td>
                    </tr>
                ';
              }
            }else{
              //echo 'no leave convertible to cash yet';
            }
        echo ' </tbody>
        </table>';

?>