<?php  
$current_leave_id = $this->uri->segment("4");

$leave_details = $this->leave_management_model->get_leave_details($current_leave_id);
foreach($leave_details as $leave){
$current_leave=$leave->leave_type;
}

?>


  <div class="row">
    <div class="box box-success">
      <!-- Default panel contents -->
      <div class="panel-heading"><strong>Employees Under <font color="#ff0000"><?php echo $current_leave; ?></font> Conditions</strong><!-- <a onclick="addNewLeaveType()" <?php //echo $this->session->userdata('check_add_leave_type_icon'); ?> class="hidden" type="button"  title="Add"><i class="fa fa-plus"></i></a> --> </div>

     <table id="emp_table" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Credit Balance Yearly</th>
                    <th>Leave Used</th>
                    <th>Available Leave</th> 
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($emp as $employee){?>

                  <tr >
                    <td><?php echo $employee->employee_id?></td>
                    <td><?php echo $employee->first_name." ".$employee->middle_name." ".$employee->last_name?></td>
                    <td><?php echo "10";?></td>
                    <td><a href="" title="Click to View Reason"><?php echo "0";?></a></td>
                    <td><?php echo "0";?></td>                     
                  </tr>
                  <?php }?>
                </tbody>
              </table>


          </div>