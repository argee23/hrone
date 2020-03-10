<?php 
$check = false;
if(count($companyList) > 0){?>

<div class="col-md-12">
<div class="form-group">

<div class="col-md-12">

  	<form method="post" action="<?php echo base_url()?>app/employee_account_management/disable_company_save/" >

      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Disable</th>
            <th>Company name</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($companyList as $company){?>

          <tr>
            <td>
            <input type="checkbox" name="companyselected[]" class="case" name="case" value="<?php echo $company->company_id; ?>" <?php if($company->isDisable == 1){ ?> checked <?php } ?> ></td>
            <td><?php echo $company->company_name; ?></td>
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
   <p class='text-center'><strong>No Company(ies) yet.</strong></p>
<?php } ?>