<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/modify_department/<?php echo $this->uri->segment("4");?>">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-12"><?php echo $company_name->company_name; ?></label>
        <input type="hidden" name="company_id" value="<?php echo $company_name->company_id ?>">
      </div>

      <?php if($info == true){ ?>

      <div class="form-group">
        <div class="col-sm-12">
          <label>Select Division:</label>
          <select class="form-control select2" name="mod_division" id="mod_division">
          <option value="0"> Main </option>
          <?php 
            foreach($divisionList as $division){
          ?>
        <option value="<?php echo $division->division_id;?>" <?php if($department->division_id == $division->division_id) { echo 'selected="selected"';} ?> ><?php echo $division->division_name;?></option>
          <?php }?>
        </select>
        </div>
      </div>

      <?php } ?>

      <div class="form-group">
        <label for="dept_code" class="col-sm-8 ">Department Code</label>
        <div class="col-sm-12">
          <input type="text" class="form-control" name="dept_code" id="dept_code" placeholder="Department Code" value="<?php echo $department->dept_code;?>" required>
        </div>
      </div>
      <div class="form-group">
        <label for="dept_name" class="col-sm-8 ">Department Name</label>
        <div class="col-sm-12">
          <input type="text" class="form-control" name="dept_name" id="dept_name" placeholder="Department Name" value="<?php echo $department->dept_name;?>" required>
        </div>
      </div>
          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>