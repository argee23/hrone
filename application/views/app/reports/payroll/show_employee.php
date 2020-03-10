<?php

$name="";
$position="";
//foreach($emp as $empl){
   $name=$emp->first_name." ".$emp->middle_name." ".$emp->last_name;
   $position=$emp->position;
   $emp_id=$emp->employee_id;
   $pay_type=$emp->pay_type;
   $company=$emp->company_id;
//}
?>


    <div class=""  id="show_selected_emp">
      <label for="next" class="col-sm-3 control-label"><a type="button" class=" data-toggle="modal" data-target="#showEmployeeList"><i class="fa fa-user"></i></a> Selected Employee</label>
        <div class="col-sm-6" >
              <a data-toggle="modal" data-target="#showEmployeeList">
              <input type="text" class="form-control" placeholder="Select Employee" onclick="individ_emp()" value="<?php echo $name; ?>">
              </a>


        </div>
    </div>  

<input type="hidden" class="form-control" placeholder="topic_location" name="topic_location" id="topic_location" value="<?php echo $topic_location?>">

<input type="hidden" class="form-control" placeholder="company_id" name="company" id="company" value="<?php echo $company?>">

<input type="hidden" class="form-control" placeholder="Position" name="pay_type_group" id="pay_type_group" value="1">
<input type="hidden" class="form-control" placeholder="pay_type" name="pay_type" id="pay_type" value="<?php echo $pay_type; ?>">
<input type="hidden" class="form-control" placeholder="Select Employee" id="selected_individual_employee_id" name="selected_individual_employee_id" value="<?php echo $emp_id; ?>">



<?php

if($the_type=="by_month"){
         echo ' <br><br>
          <div class="col-md-12">
          <div class="col-md-3">Covered Month From</div>
          <div class="col-md-6">
          <select class="form-control" name="covered_month_from" id="covered_month_from" required>
          <option selected disabled value=""> Select Month From</option>';
          for($m=1; $m<=12; ++$m){
          echo '<option value="'.sprintf("%02d", $m).'">'.date('F', mktime(0, 0, 0, $m, 1)).'</option>';
          }
          echo '</select><br>
          </div>
          </div>';

          echo '
          <div class="col-md-12">
          <div class="col-md-3">Covered Month To</div>
          <div class="col-md-6">
          <select class="form-control" name="covered_month_to" id="covered_month_to" required>
          <option selected disabled value=""> Select Month To</option>';
          for($m=1; $m<=12; ++$m){
          echo '<option value="'.sprintf("%02d", $m).'">'.date('F', mktime(0, 0, 0, $m, 1)).'</option>';
          }
          echo '</select><br>
          </div>
          </div>';

          echo '
          <div class="col-md-12">
          <div class="col-md-3">Covered Year</div>
          <div class="col-md-6">
          <select class="form-control" name="covered_year" id="covered_year" required>
          <option selected disabled value=""> Select Year</option>';  

          if(!empty($payroll_period_year)){
          foreach($payroll_period_year as $pp){    
          echo '<option value="'.$pp->year_cover.'">'.$pp->year_cover.'</option>';
          }
        }else{}
      echo '</select><br>
      </div>
      </div>';

}elseif($the_type=="by_year"){

    echo '
    <div class="col-md-12">
    <div class="col-md-3">Covered Year</div>
    <div class="col-md-6">
    <select class="form-control" name="covered_year" id="covered_year" required>
    <option selected disabled value=""> Select Year</option>';  
        if(!empty($payroll_period_year)){
        foreach($payroll_period_year as $pp){    
        echo '<option value="'.$pp->year_cover.'">'.$pp->year_cover.'</option>';
        }

        }else{
        }
    echo '</select><br>
    </div>
    </div>'; 


}elseif($the_type=="single_pp"){
    echo '
    <div class="col-md-12">
    <div class="col-md-3">Payroll Period</div>
    <div class="col-md-6">
    <select class="form-control" name="payroll_period" id="payroll_period" required>
    <option selected disabled value=""> Select Payroll Period</option>';  
        if(!empty($to_check_pp)){
        foreach($to_check_pp as $pp){    
        echo '<option value="'.$pp->id.'">'.$pp->complete_from.' to '.$pp->complete_to.'</option>';
        }

        }else{
        }
    echo '</select><br>
    </div>
    </div>'; 

}else{

}

if($topic_location=="loan_report"){

  echo '       <div class="col-md-12">
          <div class="col-md-3">Loan Types :</div>
          <div class="col-md-6">
            <select class="form-control" name="payroll_unique" id="payroll_unique" required>';
          if(!empty($loan_lists)){
             ?>

              <option selected value="All">All</option>
               <?php foreach($loan_lists as $loan){
                echo "<option value='".$loan->loan_type_id."'>".$loan->loan_type."</option>";} ?>

<?php            
          }else{}
echo '           <option value="">Notice: Employee Doesnt Have Any Existing Loan</option>
 </select><br>
          </div>
      </div>';

echo '
       <div class="col-md-12">
          <div class="col-md-3">Status :</div>
          <div class="col-md-6">
            <select class="form-control" name="loan_status" id="loan_status" required>
              <option selected value="All">All</option>
              <option value="active">Active</option>
              <option value="automatic_paid_marked">Automatically Marked Paid</option>
              <option value="manually_paid_marked">Manually Marked as Paid</option>
              <option value="pause">Pause</option>
            </select><br>
          </div>
      </div>

';



        }else{

        }
?>



   <div class="col-md-12" style="padding-top: 20px;" >
      <div class="col-md-7 pull-right"><button class="btn btn-success col-md-3"  target="_blank" onclick="generate_individual('<?php echo $topic_location;?>');">VIEW</button></div>
  </div>