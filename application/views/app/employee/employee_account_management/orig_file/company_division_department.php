<?php 
$check = false;

if(count($division_department) > 0){?>

<div class="col-md-12">
<div class="form-group">

<div class="col-md-12">

  	<form method="post" action="<?php echo base_url()?>app/employee_account_management/disable_division_department_save/<?php echo $this->uri->segment("4"); ?>" >
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Disable</th>
            <th>Department name</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($division_department as $department ){?>
          <tr>
            <td>
            <input type="checkbox" name="departmentselected[]" class="case" name="case" value="<?php echo  $department->department_id; ?>" <?php if($department->isDisable == 1){ ?> checked <?php } ?> ></td>
            <td><?php echo $department->dept_name; ?></td>
          </tr>

          <?php } ?>
        </tbody>
      </table>

    <div class="form-group">
     <button type="submit" class="form-control btn btn-danger"><i class="fa fa-floppy-o"></i> SAVE CHANGES</button>
     </div>
    </form>
</div>

</div>
</div>

<?php }
else{ ?>
	 <p class='text-center'><strong>No Department(s) yet.</strong></p>
<?php } ?>
  