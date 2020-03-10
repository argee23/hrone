
<div class="col-md-12">
<div class="col-md-6">
<div class="form-group">
<!-- <input type="hidden" value="<?php echo $this->uri->segment("11");?>" name="selectvalue">
<input type="checkbox" name="selectall" id="selectall" value="yes" onclick="select_all_employee(this.value);"> -->
<input type="checkbox" class="checkall" id="selectall">
<label >Select All Employee</label>
</div>
</div>
</div>

<div class="col-md-12">
<div id = "search_here">
<div class="form-group">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Employee ID</th>
          <th>Employee Name</th>
          <!-- <th>Equivalent Incentive Leave</th> -->
        </tr>
      </thead>
      <tbody>
       <?php 
       $display = 'A';
       foreach($available_employee as $employee){ ?>
        <tr>
          <td>
          <!-- <input type="checkbox" name="employeeselected[]" value="<?php echo $employee->employee_id?>" onclick="incentive_leave_equivalent('<?php echo $display; ?>');" > -->
          <input type="checkbox" name="employeeselected[]" class="case" name="case" value="<?php echo $employee->employee_id?>" >
          <?php echo '   '.$employee->employee_id?> </td>
          <!-- <td><?php echo $employee->first_name.' '.$employee->last_name.' '.$employee->middle_name.' '.$employee->name_extension?></td> -->
          <td><?php echo $employee->name ?></td>
          <!-- <td>
            <div id= "<?php echo $display ?>">
            </div>
          </td> -->
        </tr>
       <?php $display++; } ?>
      </tbody>
    </table>
</div>
</div>

<div class="form-group">
<button type="submit" class="btn btn-success btn pull-right"><i class="fa fa-user-plus"></i> ADD EMPLOYEE(S)</button>
</div>

</div>
