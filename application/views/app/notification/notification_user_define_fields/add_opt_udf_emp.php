<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>Add</strong><small> (Option) </small></div>

  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/notification_user_define_fields/save_udf_opt/<?php echo $this->uri->segment("4");?>" >
    <div class="box-body">
      <?php for($num = 1; $num <= $user_define_edit->udf_max_length;$num++){
        $label = 'option_'.$num;
        ?>
      <div class="form-group">        
        <label for="optlabel" class="col-sm-2 control-label">Option <?php echo $num; ?></label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="<?php echo $label; ?>" id="<?php echo $label; ?>" placeholder="Option <?php echo $num; ?>" value="" required>
        </div>
      </div>
      <?php } ?>
          <button type="submit" class="btn btn-success btn pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
</div>
</div>
</div



