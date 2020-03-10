<div class="row">
<div class="col-md-6">
<div class="box box-success">
<!-- form start -->
 <?php 

        $company_id = $this->uri->segment('4');
 		//echo $company_id."UDN ni NEMZ";
        $current_comp=$this->notification_user_define_fields_model->get_company($company_id);
         if(!empty($current_comp)){
             $company_name = $current_comp->company_name;
         }else{
             $company_name="company not exist";
         }
         $this->uri->segment("4");
       ?>
    


	<div class="panel panel-success">

	<div class="panel-heading"><strong>Create New Notification (<?php echo $company_name; ?>)</strong>
 	</div>

 	<input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id; ?>">

<div class="box-body">
		<div class="form-group"   >
			<label for="no_of_fields" class="col-sm-2 control-label">No of fields</label>
				<div class="col-sm-10" >
					<select name="no_of_field" id="no_of_field" class="form-control"  required="">
					<option value="1" selected="" >Select</option>
					<?php
					for($M =1;$M<=99;$M++){
					echo "<option value='".$M."'>". $M."</option>";
					}
					?>
					</select> 
				</div>
		</div>
		<div class="form-group"   >
			<label for="next" class="col-sm-2 control-label">&nbsp;</label>
				<div class="col-sm-10" >

				<a onclick="next_new()"  type="button"  class="btn btn-danger btn-xs pull-left"><i class="fa fa-arrow-down"></i> Next</a>
				</div>
		</div>


</div>
</div>
</div>
</div>  
</div>


