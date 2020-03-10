<div class="well">
<!-- form start -->
<form class="form-horizontal" name="f1" method="post" action="<?php echo base_url()?>app/" >



<div class="box-header"><strong>Create New Transaction</strong>
 </div>
<div class="box-body">
		<div class="form-group"   >
			<label for="no_of_fields" class="col-sm-2 control-label">No of fields</label>
				<div class="col-sm-10" >
					<select name="no_of_field" id="no_of_field" class="form-control"  required="">
					<option value="1" selected="" >Select</option>
					<?php
					for($M =1;$M<=100;$M++){
					echo "<option value='".$M."'>". $M."</option>";
					}
					?>
					</select> 
				</div>
		</div>
		<div class="form-group"   >
			<label for="next" class="col-sm-2 control-label">&nbsp;</label>
				<div class="col-sm-10" >

				<a onclick="next()"  type="button"  class="btn btn-danger btn-xs pull-left"><i class="fa fa-arrow-down"></i> Next</a>
				</div>
		</div>


</div>

</div>


