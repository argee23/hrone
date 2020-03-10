<?php 
$check = false;

if(count($company_locations) > 0){?>

<div class="col-md-12">
<div class="form-group">

<div class="col-md-12">

  	<form method="post" action="<?php echo base_url()?>app/employee_account_management/disable_location_save/<?php echo $this->uri->segment("4"); ?>" >
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Disable</th>
            <th>Location name</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($company_locations as $location){?>
          <tr>
            <td>
            <input type="checkbox" name="locationselected[]" class="case" name="case" value="<?php echo $location->location_id; ?>" <?php if($location->isDisable == 1){ ?> checked <?php } ?> ></td>
            <td><?php echo $location->location_name; ?></td>
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
	 <p class='text-center'><strong>No Location(s) yet.</strong></p>
<?php } ?>
  