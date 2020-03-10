<div class="well">
<!-- form start -->
<form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/" >


<div class="box-header"><strong>Create New Transaction</strong> 

	<div class="box box-info">
	Document No. Identification : HR027 
	</div>

 </div>
<div class="box-body">
		<div class="form-group"   >
			<label for="no_of_fields" class="col-sm-2 control-label">Form Title</label>
				<div class="col-sm-10" >
					<input type="text" name="" class="form-control"  placeholder="Form Title">
				</div>
		</div>
		<div class="form-group"   >
			<label for="no_of_fields" class="col-sm-2 control-label">Form Description</label>
				<div class="col-sm-10" >
					<textarea type="text" name="" class="form-control"  placeholder="Form Description"></textarea>
				</div>
		</div>


		<?php 
	if($this->uri->segment("4")!=""){
		$count=$this->uri->segment("4");
		$nof = "0"; 
	while($nof!=$count){
	$nof++;
	echo '
	<div class="box box-default">
		<div class="form-group">
			<label for="no_of_fields" class="col-sm-2 control-label">Label</label>
				<div class="col-sm-10" >
					<input type="text" name="" class="form-control"  placeholder="label">
				</div>
		</div>
		<div class="form-group">
			<label for="no_of_fields" class="col-sm-2 control-label">Input Type</label>
				<div class="col-sm-10" >
					<select  name="" class="form-control"  >
						<option selected disabled> Select</option>
						<option value="" > text field</option>
						<option value="" > text area</option>
						<option value="" > date picker</option>
					</select>
				</div>
		</div>
		<div class="form-group">
			<label for="no_of_fields" class="col-sm-2 control-label">Accept Value</label>
				<div class="col-sm-10" >
					<select  name="" class="form-control"  >
						<option selected disabled> Select</option>
						<option value="" > Alpha Numeric</option>
						<option value="" > Numbers Only</option>
						<option value="" > Letters Only</option>
					</select>
				</div>
		</div>
		<div class="form-group">
			<label for="no_of_fields" class="col-sm-2 control-label">Max Lenght</label>
				<div class="col-sm-10" >
					<input type="text" name="" class="form-control"  placeholder="Maximum Lenght">
				</div>
		</div>
		<div class="form-group">
			<label for="no_of_fields" class="col-sm-2 control-label">Not Null</label>
				<div class="col-sm-10" >
					<input type="checkbox" name="" >
				</div>
		</div>
	</div>

	';
}
	}else{
			echo "";
	}

	
	?>

 <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button>





</form>

	</div>

</div>


