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


    <div class=""  id="show_ref_emp">
      <label for="next" class="col-sm-3 control-label"><a type="button" class=" data-toggle="modal" data-target="#showEmployeeList"><i class="fa fa-user"></i></a> Selected Employee</label>
        <div class="col-sm-6" >
              <a data-toggle="modal" data-target="#showEmployeeList">
              <input type="text" class="form-control" placeholder="Select Employee" onclick="individ_emp()" value="<?php echo $name; ?>">
              </a>


        </div>
    </div>  


<input type="hidden" id="selected_individual_emp" class="form-control" value="<?php echo $emp_id; ?>">