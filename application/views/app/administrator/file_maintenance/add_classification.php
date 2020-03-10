<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/save_classification" >
    <div class="box-body">
      <div class="form-group">
        <div class="col-md-12">
          <label>Select Company:</label>
          <select multiple="multiple" class="form-control select2" name="company[]" id="company" style="width: 100%;" required="required">
            <?php 
                foreach($companyList as $company){
                if($_POST['company'] == $company->company_id){
                    $selected = "selected='selected'";
                }
                else{
                    $selected = "";
                }
            ?>
          <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
            <?php }?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="classification" class="col-sm-2 control-label">Classification</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="classification" id="classification" placeholder="Classification" required>
        </div>
      </div>
      <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="description" id="description" placeholder="Description">
        </div>
      </div>
      </div>
      <div class="form-group">
        <label for="classification" class="col-sm-2 control-label">Ranking</label>
        <div class="col-sm-10">

        <select class="form-control" name="ranking" required>
        <option disabled selected> Select </option>
          <?php
          for ($x = 1; $x <= 20; $x++){
            echo '<option value="'.$x.'">'.$x.'</option>';
          } 
          ?>
        </select>

        </div>
      </div>


          <button type="submit" class="btn btn-warning pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>