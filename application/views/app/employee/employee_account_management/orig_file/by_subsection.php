<?php 
$check = false;
if(count($section_subsection) > 0){?>
<div class="col-md-12">
<div class="form-group">

<div class="col-md-12">

  	<form method="post" action="<?php echo base_url()?>app/employee_account_management/disable_subsection_save/" >

      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Disable</th>
            <th>Subsection name</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($section_subsection as $subsection){?>

          <tr>
            <td>
            <input type="checkbox" name="subsectionselected[]" class="case" name="case" value="<?php echo $subsection->subsection_id; ?>" <?php if($subsection->isDisable == 1){ ?> checked <?php } ?> ></td>
            <td><?php echo $subsection->subsection_name; ?></td>
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
   <p class='text-center'><strong>No Subsection(s) yet.</strong></p>
<?php } ?>