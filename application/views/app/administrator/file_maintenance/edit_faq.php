<div class="well">
<!-- form start -->
  <h4 class="text-success"><?php echo "Edit Question"//$faq->id ?></h4>
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/file_maintenance/modify_faq/<?php echo $this->uri->segment("4")?>" >
    <div class="box-body">
      <div class="form-group">
        <label for="section_name" class="col-sm-2 control-label">Question</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="question" id="question" placeholder="Question" value="<?php echo $faq->question; ?>" required>
          <input type="hidden" name="company_id" id="company_id" value="<?php echo $faq->company_id; ?>">
        </div>
      </div>
      <div class="form-group">
        <label for="section_name" class="col-sm-2 control-label">Answer</label>
        <div class="col-sm-10">
           <textarea rows="10" class="form-control" name="answer" id="answer" placeholder="Answer" required><?php echo $faq->answer ?></textarea>
        </div>
      </div>
          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  <?php echo $this->uri->segment("5")?>
  </div>