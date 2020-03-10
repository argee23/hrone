<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>Add</strong><small> (Option) </small></div>

  <form method="post" action="<?php echo base_url()?>app/employee_user_define_fields/save_udf_opt/<?php echo $this->uri->segment("4");?>" >
    <div class="box-body">

      <div class="form-group">        
        <label>Option name</label>
        <input type="text" class="form-control" name="option" id="option" placeholder="Option name" value="" required>
      </div>

          <button type="submit" class="btn btn-success btn pull-right"><i class="fa fa-floppy-o"></i> Save</button>

    </div><!-- /.box-body -->
  </form>
</div>
</div>
</div



