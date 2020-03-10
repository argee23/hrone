<?php 
$check = false;
if(count($positionList) > 0){?>

<div class="col-md-12">
<div class="form-group">

<div class="col-md-12">

  	<form method="post" action="<?php echo base_url()?>app/employee_account_management/disable_position_save/" >

      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Disable</th>
            <th>Position name</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($positionList as $position){?>

          <tr>
            <td>
            <input type="checkbox" name="positionselected[]" class="case" name="case" value="<?php echo $position->position_id; ?>" <?php if($position->isDisable == 1){ ?> checked <?php } ?> ></td>
            <td><?php echo $position->position_name; ?></td>
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
   <p class='text-center'><strong>No Position(s) yet.</strong></p>
<?php } ?>