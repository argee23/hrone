<div class="well">
<!-- form start -->
  <h4 class="text-success">Add Section</h4>
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/save_section/" >
    <div class="box-body">

      <div class="form-group">
        <label>Select Company:</label>
          <select class="form-control select2" name="company_add" id="company_add" required onchange="examineComp(this.value)">
            <option selected="selected" disabled="disabled" value=""> - Choose Company - </option>
            <?php 
              foreach($companyList as $company){
              ?>
              <option value="<?php echo $company->company_id;?>"> <?php echo $company->company_name;?> </option>
            <?php }?>
          </select>
      </div>
      <div id="sectionOrLoc"></div>
      
    </div><!-- /.box-body -->
  </form>
  </div>