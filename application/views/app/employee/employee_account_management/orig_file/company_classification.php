<?php 
$check = false;
if(count($classificationList) > 0){?>

<div class="col-md-12">
<div class="form-group">

<div class="col-md-12">

  	<form method="post" action="<?php echo base_url()?>app/employee_account_management/disable_classification_save/" >

      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Disable</th>
            <th>Classification name</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($company_classification as $classification){?>

          <tr>
            <td>
            <input type="checkbox" name="classificationselected[]" class="case" name="case" value="<?php echo $classification->classification_id; ?>" <?php if($classification->isDisable == 1){ ?> checked <?php } ?> ></td>
            <td><?php echo $classification->classification; ?></td>
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
   <p class='text-center'><strong>No Classification(s) yet.</strong></p>
<?php } ?>