<?php 
$check = false;

if(count($company_division) > 0){?>

<div class="col-md-12">
<div class="form-group">

<div class="col-md-12">

  	<form method="post" action="<?php echo base_url()?>app/employee_account_management/disable_division_save/<?php echo $this->uri->segment("4"); ?>" >
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Disable</th>
            <th>Division name</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($company_division as $division ){?>
          <tr>
            <td>
            <input type="checkbox" name="divisionselected[]" class="case" name="case" value="<?php echo  $division->division_id; ?>" <?php if($division->isDisable == 1){ ?> checked <?php } ?> ></td>
            <td><?php echo $division->division_name; ?></td>
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
	 <p class='text-center'><strong>No Division(s) yet.</strong></p>
<?php } ?>
  