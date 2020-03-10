<div id="printProfile">

<div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>SSS CONTRIBUTION</strong></div>
  <div class="box-body">
  <div class="panel panel-success">
         <div class="box-body">
         <div class="row">

         <form method="post" action="<?php echo base_url()?>app/payroll_file_maintenance/sss_company_table/<?php echo $this->uri->segment("4");?>" >

         	<div class="col-md-12">
			<div class="form-group">
			<label for="company">Select a Company</label>
				<select class="form-control" name="company" id="company" required>
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

			<div class="col-md-12">
			<div class="form-group">
			<button type="submit" class="btn btn-success pull-right" ><i data-toggle="tooltip" data-placement="right" title="View" ></i>SSS Contribution </button>
			</div>
			</div>

		 </form>


		 </div> 
         </div><!-- /.box-body --> 
   </div>
   </div>


   <!-- <div id="philhealth_table_search">
   </div> -->


</div>
</div>  
</div>
