<div class="row">
<div class="col-md-6">

<div class="box box-danger">
<div class="panel panel-danger">
     <div class="panel-heading"><strong>Edit</strong><small> (Notification User Define Fields) </small></div>

<!-- form start -->
  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/notification_user_define_fields/modify_udn_col_new/<?php echo $this->uri->segment("4");?>" >
    <div class="box-body">
        <input type="hidden" class="form-control" name="company_id" id="company_id" placeholder="Company_Id" value="<?php echo $user_define_edit->company_id ?>" required>
      <div class="form-group">
        <label for="label" class="col-sm-2 control-label">Label</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="label" id="label" placeholder="Label" onchange="return trim(this)" value="<?php echo $user_define_edit->udf_label ?>" required>
        </div>
      </div>
      
      <div class="form-group">
        <label for="type" class="col-sm-2 control-label">Type</label>
        <div class="col-sm-10">
          <select class="form-control" name="type" id="type" onclick="edit_forTextfield(this.value);" required>
              <option selected="selected" value="Null"  >~ <?php echo $user_define_edit->udf_type ?> ~</option>
              <option value="Datepicker">Date picker</option>
              <option value="Selectbox">Select box</option>
              <option value="Textarea">Text area</option>
              <option value="Textfield">Text field</option>
          </select>
        </div>
      </div>

      <div id="editforTextfield">
                                
      </div>      

      <div class="form-group">
        <label for="not_null" class="col-sm-2 control-label">Not null</label>
        <div class="col-sm-10">
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
        </div>
      </div>


          <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-pencil"></i> Modify</button>
    </div><!-- /.box-body -->
  </form>
  </div>
  </div>

    <div class="col-md-6" id="col_3"></div>
  </div>
  </div>
