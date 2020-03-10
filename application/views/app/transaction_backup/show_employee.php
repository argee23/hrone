<?php

$name="";
$position="";
foreach($emp as $empl){
   $name=$empl->first_name." ".$empl->middle_name." ".$empl->last_name;
   $position=$empl->position;
}

?>

<label for="select_approver"><a type="button" class="btn btn-success btn-xs pull-left" data-toggle="modal" data-target="#showEmployeeList"><i class="fa fa-user-plus"></i></a> &nbsp;&nbsp;[Select Employee]</label>

<a data-toggle="modal" data-target="#showEmployeeList">
<input type="hidden" class="form-control" placeholder="Position" name="position" value="<?php echo $position; ?>">
<input type="hidden" class="form-control" placeholder="Select Employee" name="assigned_employee" value="<?php echo $this->uri->segment('4'); ?>">
<input type="text" class="form-control" placeholder="Select Employee" value="<?php echo $name; ?>">
</a>