<div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>GOVERNMENT SUBJECT TO DEFAULT VIEW </strong></div>
  <div class="box-body">
  <div class="panel panel-success">
         <div class="box-body">
         <div class="row">

         	<div class="col-md-12">
			<div class="form-group">
			<label for="company">Select a Company</label>
				<select class="form-control" name="company" id="company" onchange="get_company_loc_default_value(this.value)" required>
				<option selected="selected" value="" disabled>~select a company~</option>
				<?php
					foreach($companyList as $company){
						if($_POST['company'] == $company->company_id){
							$selected = "selected='selected'";
						}else{
							$selected = "";
						}
					?>
					<option value="<?php echo $company->company_id;?>" <?php echo $selected;?>><?php echo $company->company_name;?></option>
				<?php }?>
				</select>
			</div>
			</div>

			

			<div id = "loc_default_value">
			</div>


		 </div> 
         </div><!-- /.box-body --> 
   </div>
   </div>


   <!-- <div id="philhealth_table_search">
   </div> -->


</div>
</div>  
</div>
</div>
