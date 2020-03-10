<?php
$name="";
$position="";
//foreach($emp as $empl){
   $name=$emp->first_name." ".$emp->middle_name." ".$emp->last_name;
   $position=$emp->position;
   $emp_id=$emp->employee_id;
   $pay_type=$emp->pay_type;
   $e_company_id=$emp->company_id;
//}
?>

    <div class="form-group"  id="show_selected_emp">
      <label for="next" class="col-sm-5 control-label"><a type="button" class=" data-toggle="modal" data-target="#showEmployeeList"><i class="fa fa-user"></i></a> &nbsp;&nbsp;Selected Employee</label>
        <div class="col-sm-7" >
              <a data-toggle="modal" data-target="#showEmployeeList">
              <input type="text" class="form-control col-sm-12" placeholder="Select Employee" onclick="fetch_payroll_period()" value="<?php echo $name; ?>">
              </a>


        </div>
    </div>  
<!-- 
<label for="select_approver"><a type="button" class="btn btn-success btn-xs pull-left" data-toggle="modal" data-target="#showEmployeeList"><i class="fa fa-user-plus"></i></a> &nbsp;&nbsp;Selected Employee</label>
<a data-toggle="modal" data-target="#showEmployeeList"> -->

<input type="hidden" class="form-control" placeholder="Position" name="pay_type_group" id="pay_type_group" value="1">
<input type="hidden" class="form-control" placeholder="Company ID" name="e_company_id" id="e_company_id" value="<?php echo $e_company_id; ?>">
<input type="hidden" class="form-control" placeholder="Select Employee" name="selected_individual_employee_id" value="<?php echo $emp_id; ?>">

<!-- </a> -->