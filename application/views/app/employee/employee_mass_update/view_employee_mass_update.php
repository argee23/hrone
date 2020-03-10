<div class="row">
<div class="col-md-6">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>Mass Update</strong> <?php echo $this->uri->segment("4");?></div>
  <?php
    $fieldselectedval = implode(".", $fieldselectedvalue);
  ?>
    <div class="box-body">
    <div class="panel panel-success">
    <br>

    <form action="<?php echo base_url(); ?>app/employee_mass_update/update_employee_mass_update/<?php echo $fieldselectedval;?>" method="post" name="upload_excel" enctype="multipart/form-data">

      <div class="form-group">
      <label for="type" class="col-sm-1 control-label"></label>
        <a href="<?php echo base_url(); ?>app/employee_mass_update/download_employee_mass_update_template/<?php echo $fieldselectedval; ?>"
         type="button" class="btn btn-success btn-xs" title="Download Template" ><i class="fa fa-download"></i> Download Template</a>      
      </div>

      <div class="form-group">
        <label for="type" class="col-sm-1 control-label"></label>
        <div class="form-group" ng-class="{'has-error': userForm.file.$invalid}">
          <div class="btn btn-info">
          <input type="file" name="file" id="file" ng-model="first_name" accept=".xls,.xlsx" required>
          </div>
        </div>
      </div>
      <br>
      <div class="form-group">
      <label for="type" class="col-sm-9 control-label"></label>
      <button onclick="myFunction()" type="submit" id="submit" name="import" class="btn btn-success"><i class="fa fa-upload"></i> Import</button>
      </div>
    </form>

    </div>
    </div><!-- /.box-body -->

</div>
</div>


<div class="col-md-6" id="col_3"></div>
</div>  
</div>

