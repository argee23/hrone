<div class="well">
<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/recruitment/save_mc_pre_que_choice" >
    <div class="box-body">
      <div class="form-group">
        <label for="mc_choice" class="col-sm-2 control-label">Question Choice</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="mc_choice" id="mc_choice" placeholder="Question Choice" required>
          <input type="hidden" class="form-control" name="mc_que_id" id="mc_que_id" value="<?php echo $this->uri->segment('4');?>">
        </div>
      </div>
          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
  </div>
