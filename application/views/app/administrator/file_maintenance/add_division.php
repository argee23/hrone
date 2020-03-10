<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/save_division" >
    <div class="box-body">
      <div class="form-group">
        <label>Add Division</label>
      </div>
      <div class="form-group">
        <div class="col-md-12">
          <label>Select Company:</label>
          <select class="form-control select2" name="company" id="company" style="width: 100%;" required="required" onchange="fetchLocation(this.value)">
          <option value="" selected="selected" disabled="disabled"> ~ Select Company ~ </option>
            <?php 
                foreach($companyList as $company){
                if($_POST['company'] == $company->company_id){
                    $selected = "selected='selected'";
                }
                else{
                    $selected = "";
                }
                if($company->wDivision=="1"){
            ?>
          <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
            <?php
          }else{}

             }?>
          </select>
        </div>
      </div>
      <div class="col-md-12" id="choice"></div>
      
    </div><!-- /.box-body -->
  </form>
  </div>