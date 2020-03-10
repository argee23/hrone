<div class="row">
<div class="col-md-12">

<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong>Web Bundy Enrollment</strong></div>
  <div class="box-body">
  <div class="panel panel-success">
         <div class="box-body">
         <div class="row">

         	<div class="col-md-12">
			<div class="form-group">
			<label for="company">Select a Company</label>
				<select class="form-control" name="company" id="company" onchange="get_company_employee(this.value)" required>
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


			<div id = "company_employee">
			</div>

		 </div> 
         </div><!-- /.box-body --> 
   </div>
   </div>
</div>
</div>  
</div>
</div>