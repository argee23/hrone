<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong>Edit</strong><small> (Option) </small></div>

  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/notification_user_define_fields/modify_udf_opt/<?php echo $this->uri->segment("4");?>" >
    <div class="box-body">
      <div class="form-group">
        <label for="optlabel" class="col-sm-2 control-label">Label</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="optlabel" id="optlabel" placeholder="Option Label" value="<?php echo $user_define_edit->optionLabel ?>" required>
        </div>
      </div>
           <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
</div>
</div>







