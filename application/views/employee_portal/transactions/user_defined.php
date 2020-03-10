<?php require_once(APPPATH.'views/app/application_form/insert_datetime_picker.php');?>
<div class="panel panel-default">

  <div class="panel-body">
  <h4 class="panel-header"><?php echo $name;?></h4>
  <hr>
  <?php  if (count($approvers) == 0)
  { ?>
      <div class="callout callout-danger">
                <h4><i class="icon fa fa-warning"></i> No Assigned Approvers</h4>

                <p>You are not allowed to file this transaction until an approver is set by your <strong>HR Manager</strong>.</p>
             </div>

  <?php } else { ?>
  <form class="form-horizontal" name="add_med_re" method="post" action="add_user_defined">
  <input type="hidden" name="form_name" value="<?php echo $form_name; ?>">  <input type="hidden" name="id" value="<?php echo $id; ?>">
  <input type="hidden" name="name" value="<?php echo $name; ?>">
   <input type="hidden" name="tablename" value="<?php echo $table_name; ?>">
    <?php foreach ($fields as $field)
    { 

      $required = '';

      if ($field->udf_not_null == 'yes')
      {
        $required = 'required';
      }

      ?>

        <?php if ($field->udf_type == 'Textarea')
        { ?>

        <!-- TEXTAREA -->

        <div class="form-group">
        <label class="control-label col-sm-4" for="email"><?php echo $field->udf_label; ?></label>
        <div class="col-sm-8">
        <textarea class="form-control" rows="2" name="<?php echo $field->TextFieldName; ?>" id="comment" <?php echo $required; ?>></textarea>
        </div>
        </div>

        <?php } ?>


        <?php if ($field->udf_type == 'Textfield')
        { ?>
        <!-- TEXT FIELD -->

        <div class="form-group">
        <label class="control-label col-sm-4" for="email"><?php echo $field->udf_label; ?></label>
        <div class="col-sm-8">
        <input type="text" class="form-control" name="<?php echo $field->TextFieldName; ?>" id="email" <?php echo $required; ?>>
        </div>
        </div>


        <?php } ?>

        <?php if ($field->udf_type == 'Selectbox')
        { ?>
      
        <!-- SELECT BOX -->

        <div class="form-group">
        <label class="control-label col-sm-4" for="email"><?php echo $field->udf_label; ?></label>
        <div class="col-sm-8">
        <select class="form-control"  name="<?php echo $field->TextFieldName; ?>" id="sel1" <?php echo $required; ?>>
           <?php foreach ($field->options as $option) { ?>
            <option value="<?php echo $option->optionLabel; ?>"><?php echo $option->optionLabel;?></option>
           <?php } ?>
            </select>
        </div>
        </div>


        <?php } ?>

        <?php if ($field->udf_type == 'Datepicker')
        { ?>
        

        <!-- DATE PICKER -->

        <div class="form-group">
        <label class="control-label col-sm-4" for="email"><?php echo $field->udf_label; ?></label>
        <div class="col-sm-8">
        <input type="text" class="form-control" name="<?php echo $field->TextFieldName; ?>" id="<?php echo $field->TextFieldName; ?>" <?php echo $required; ?>>
        </div>
        </div>


        <script>
          $('#<?php echo $field->TextFieldName; ?>').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false });
        </script>
   
        <?php } ?>

    <?php } ?>


   <div class="form-group">
    <label class="control-label col-sm-4" for="email"></label>
    <div class="col-sm-8">
    <button type="submit" id="submit" class="btn btn-success btn-md">Submit</button>
    </div>
  </div>


  </form>


  <?php } ?>
  </div>
</div>



