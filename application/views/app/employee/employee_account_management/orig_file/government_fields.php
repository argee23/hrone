<div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>  GOVERNMENT FIELDS</strong><a onclick="government_field_edit()" type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="Edit"><i class="fa fa-pencil-square-o fa-2x text-success pull-right"></i></a></div>

    <div class="box-body">
    <div class="panel panel-success">
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
            <td><?php echo $option; ?></td>
            <td><?php echo $fields->field_max_length; ?></td>
            <td><?php echo $fields->field_format; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>

     <br>
     </div>
    </div><!-- /.box-body -->
</div>
</div>

</div>  
</div>


