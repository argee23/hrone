<div class="row">
<div class="col-md-7">

<div class="box box-danger">
<div class="panel panel-danger">
     <div class="panel-heading"><strong>Edit</strong><small> (User Define Fields) </small></div>

<!-- form start -->
  <form method="post" action="<?php echo base_url()?>app/employee_user_define_fields/modify_udf_col/<?php echo $this->uri->segment("4");?>" >

    <div class="box-body">
    <div class="row">
    <div class="col-md-12">

      <div class="form-group">
        <label>Field name</label>
          <input type="text" class="form-control" name="label" id="label" placeholder="Label" value="<?php echo $user_define_edit->udf_label ?>" required>
          <p style="color:#ff0000;">Field name is required</p>
      </div>

      <div class="form-group">
          <br>
          <?php 
            $cb =  $user_define_edit->udf_not_null;
            if($cb=='no'){
              echo "<input type='hidden' value='no' name='not_null'>";
              echo "<input type='checkbox' name='not_null' value='yes'>";
            }
            else{
              echo "<input type='hidden' value='no' name='not_null'>";
              echo "<input type='checkbox' name='not_null' value='yes' checked>";
            }
          ?>
          <label> Not null</label>
      </div>

      <div class="form-group">
          <button type="submit" class="form-control btn btn-danger"><i class="fa fa-pencil"></i> SAVE </button>
      </div>

      </div>
    
    </div>
    </div>
    </div><!-- /.box-body -->

  </form>
  </div>
  </div>

    <div class="col-md-6" id="col_3"></div>
  </div>
  </div>
