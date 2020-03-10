<?php

$name="";
$position="";

   $name=$emp->first_name." ".$emp->middle_name." ".$emp->last_name;
   $position=$emp->position;
   $emp_id=$emp->employee_id;
   $pay_type=$emp->pay_type;
   $company_id=$emp->company_id;
   $pay_type_group=$emp->payroll_period_group_id;

    $pay_per_dtr = $this->payroll_generate_lastpay_model->payroll_per_per_company_pay_type($company_id,$pay_type,$pay_type_group);//

?>

    <div class="form-group"  id="show_selected_emp">
      <label for="next" class="col-sm-5 control-label"><a type="button" class="btn btn-success" data-toggle="modal" data-target="#showEmployeeList"><i class="fa fa-user-plus"></i></a> &nbsp;&nbsp;Selected Employee</label>
        <div class="col-sm-7" >
              <a data-toggle="modal" data-target="#showEmployeeList">
              <input type="text" class="form-control col-sm-12" placeholder="Select Employee"value="<?php echo $name; ?>">  <!-- onclick="fetch_payroll_period()"  -->
              </a>


        </div>
    </div>  

<div class="form-group"   >
    <label for="next" class="col-sm-5 control-label">Payrol Period- (Covered Release of Lastpay).</label>
  <div class="col-sm-7">
    <select name="pay_period" class="form-control" id="pay_period"  required >
    <?php
    if(!empty($pay_per_dtr)){
      foreach($pay_per_dtr as $pay_period){
        $df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from; 
        $dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;

        if($payroll_option=="print_payslip" OR $payroll_option=="reset_payslip"){
          $check_posted_payroll_period=$this->Payroll_generate_13th_month_model->check_posted_payroll_period($pay_period->id);
            if(!empty($check_posted_payroll_period)){
              echo '<option value="'.$pay_period->id.'" >'.$df.' to '.$dt.' </option>';
            }else{

            }                 
        }else{
          echo '<option value="'.$pay_period->id.'">'.$df.' to '.$dt.'</option>';
        }       
      }
    }else{
      echo '<option value="" disabled selected>warning : no payroll period created yet.</option>';    
    }
    ?>
    </select>
  </div>
</div>
<!-- //==============================Coverage From of 13th month -->
<div class="form-group"   >
    <label for="next" class="col-sm-5 control-label">Last Pay Coverage From</label>
  <div class="col-sm-7">
    <select name="from_cov_pay_period" class="form-control" id="from_cov_pay_period"  required >
    <?php
    if(!empty($pay_per_dtr)){
      foreach($pay_per_dtr as $pay_period){
        $df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from; 
        $dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;
        echo '<option value="'.$pay_period->id.'">'.$df.' to '.$dt.'</option>';
      }
    }else{
      echo '<option value="" disabled selected>warning : no payroll period created yet.</option>';    

    }
    ?>
    </select>
  </div>
</div>
<div class="form-group"   >
    <label for="next" class="col-sm-5 control-label">Last Pay Coverage To</label>
  <div class="col-sm-7">
    <select name="to_cov_pay_period" class="form-control" id="to_cov_pay_period"  required >
    <?php
    if(!empty($pay_per_dtr)){
      foreach($pay_per_dtr as $pay_period){
        $df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from; 
        $dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;
        echo '<option value="'.$pay_period->id.'">'.$df.' to '.$dt.'</option>';
      }
    }else{
      echo '<option value="" disabled selected>warning : no payroll period created yet.</option>';    

    }
    ?>
    </select>
  </div>
</div>

<div class="form-group"   >
    <label for="next" class="col-sm-5 control-label">Choose Formula (for 13th Month) </label>
  <div class="col-sm-7">
    <select name="formula" class="form-control" id="formula"  required >
    <option selected disabled>Select</option>
    <?php
    if(!empty($formula_list)){
      foreach($formula_list as $f){
        
        echo '<option value="'.$f->id.'">'.$f->formula_description.'</option>';
      }
    }else{
      echo '<option value="" disabled selected>warning : no formula options created yet.</option>';   

    }
    ?>
    </select>
  </div>
</div>  





<input type="hidden" class="form-control" name="pay_type_group" id="pay_type_group" value="<?php echo $emp->payroll_period_group_id?>">
<input type="hidden" class="form-control" placeholder="Position" name="pay_type" id="pay_type" value="<?php echo $pay_type; ?>">
<input type="hidden" class="form-control" placeholder="Select Employee" name="selected_individual_employee_id" value="<?php echo $emp_id; ?>">

<!-- </a> -->