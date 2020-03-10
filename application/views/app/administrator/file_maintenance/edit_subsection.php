<div class="well">
<!-- form start -->
  <h4> Edit Subsection </h4>
  <h5 class="text-success"><?php echo " Company : ".$subsection->company_name; ?></h5>
  <h5><?php echo "Department : ".$subsection->dept_name; ?></h5>
  <h5><?php echo "Section : ".$subsection->section_name; ?></h5>
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/modify_subsection/<?php echo $this->uri->segment("4")?>" >
    <input type="hidden" name="section_id" value="<?php echo $subsection->section_id; ?>">
    <div class="box-body">
      <div class="form-group">
        <label for="subsection_name" class="control-label">Subsection Name</label>
          <input type="text" class="form-control" name="subsection_name" id="subsection_name" placeholder="Subsection Name" value="<?php echo $subsection->subsection_name?>" required>
      </div>
          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  <!-- <?php echo $this->uri->segment("5")?> -->
  </div>