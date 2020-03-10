<?php 
$check = false;
if(count($employmentList) > 0){?>

<div class="col-md-12">
<div class="form-group">

<div class="col-md-12">

  	<form method="post" action="<?php echo base_url()?>app/employee_account_management/disable_employment_save/" >

      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Disable</th>
            <th>Employment name</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($employmentList as $employment){?>

          <tr>
            <td>
            <input type="checkbox" name="employmentselected[]" class="case" name="case" value="<?php echo $employment->employment_id; ?>" <?php if($employment->isDisable == 1){ ?> checked <?php } ?> ></td>
            <td><?php echo $employment->employment_name; ?></td>
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
   <p class='text-center'><strong>No Employment(s) yet.</strong></p>
<?php } ?>