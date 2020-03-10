<div class="well">
<!-- form start -->
  <h4> Edit Section </h4>
  <h5 class="text-success"><?php echo $section->company_name." - ".$section->dept_name?></h5>
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/modify_section/<?php echo $this->uri->segment("4")?>" >
  <input type="hidden" name="department_id" value="<?php echo $section->department_id ?>" >
    <div class="box-body">
      <div class="form-group">
        <label for="section_name" class="control-label">Section Name</label>
        <input type="text" class="form-control" name="section_name" id="section_name" placeholder="Section Name" value="<?php echo $section->section_name?>" required>
      </div>
      <div class="form-group">
          <label for="wSubsection" class="pull-left"> Has Subsections? </label>
          <div class="col-sm-8">
          <input type="radio" name="subsection" value="0" <?php if ($section->wSubsection == 0) { echo "checked";}?> required> No
                    </div>
                    <div class="col-sm-8">
                    <input type="radio" name="subsection" value="1" <?php if ($section->wSubsection == 1) { echo "checked";}?>> Yes
          </div>
      </div>
          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  <?php echo $this->uri->segment("5")?>
  </div>