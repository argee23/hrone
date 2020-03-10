<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment/modify_mc_pre_que/<?php echo $this->uri->segment("4");?>" >
    <div class="box-body">
      <div class="form-group">
        <label for="question" class="col-sm-2 control-label">Question</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="question" id="question" placeholder="Question" value="<?php echo $mc_que->question?>" required>
        </div>
      </div>
          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>