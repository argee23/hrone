<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment/modify_mc_pre_que_choice/<?php echo $this->uri->segment("4");?>" >
    <div class="box-body">
      <div class="form-group">
        <label for="mc_choice" class="col-sm-2 control-label">Question Choice</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="mc_choice" id="mc_choice" placeholder="Question" value="<?php echo $mc_choice->mc_choice?>" required>
          <input type="hidden" class="form-control" name="mc_que_id" id="mc_que_id" value="<?php echo $mc_choice->mc_que_id;?>">
          <input type="hidden" class="form-control" name="mc_id" id="mc_id" value="<?php echo $mc_choice->mc_id;?>">
        </div>
      </div>
          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>