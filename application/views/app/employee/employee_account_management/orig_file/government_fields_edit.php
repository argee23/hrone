<div class="row">
<div class="col-md-8">

<div class="box box-warning">
<div class="panel panel-warning">
  <div class="panel-heading"><strong>  GOVERNMENT FIELDS EDIT</strong></div>
   <form method="post" action="<?php echo base_url()?>app/employee_account_management/government_field_modify/" >

    <div class="box-body">
    <div class="panel panel-warning">
    <br>
    	<table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Field</th>
            <th>Option</th>
            <th>Max length</th>
            <th>Sample format</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($government_fields as $fields){
          		if($fields->field_option == 1){
          			$option = 'required';
          		}
          		else if($fields->field_option == 0){
          			$option = 'optional';
          		}
          	?>
          <tr>
            <td><?php echo $fields->field_name; ?></td>
            <td>
              <select class="form-control" name="<?php echo $fields->field_name.'_option'; ?>" id="<?php echo $fields->field_name.'_option'; ?>">
              <option selected="selected" value="<?php echo $fields->field_option ?>"><?php echo $option; ?></option>
              <option value="0">optional</option>
              <option value="1">required</option>
              </select>
            </td>

            <td>
              <input type="number" name="<?php echo $fields->field_name.'_length'; ?>" class="form-control" value="<?php echo $fields->field_max_length; ?>" placeholder="max length">
            </td>

            <td>
              <input type="text" name="<?php echo $fields->field_name.'_format'; ?>" class="form-control" placeholder="sample format" value="<?php echo $fields->field_format; ?>">
            </td>

          </tr>
          <?php } ?>
        </tbody>
      </table>

     <br>
     </div>
    <div class="form-group">
     <button type="submit" class="form-control btn btn-warning"><i class="fa fa-floppy-o"></i> SAVE CHANGES</button>
     </div>
     </div><!-- /.box-body -->
    </form>
</div>
</div>

</div>  
</div>


