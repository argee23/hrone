<div class="col-md-12">
      <div class="box box-danger">
    <div class="box-header">
<strong>Download/Upload Employee Transactions</strong> 
    </div>
  <div class="box-body">


	<div class="col-md-6">
		<div class="box box-warning">
			<div class="box-header">
			<strong>Download<i class="fa fa-download text-warning pull-left"></i> </strong> 
			</div>
			<div class="box-body">
				<div class="form-group" >
					<div class="col-sm-12">
						<select class="form-control" name="template" id="template" onchange="download_template()">
							<option value="">Select Template</option>
							<?php 
							$get_temp = $this->transaction_employees_model->get_temp();
							foreach($get_temp as $template){
								echo '<option value="'.$template->template_name.'">'.$template->form_name.'</option>';
							}			
							?>
						</select>
					</div>
				</div>
				<div class="form-group" >
					<label for="" class="col-sm-2 control-label"></label>
					<div class="col-sm-10">						 
					</div>
				</div>
			</div>
			<div id="download_button"></div>
		</div>
		</div> 


		<div class="col-md-6">
		 <form target="_blank" action="<?php echo base_url();?>app/transaction_employees_upload/upload_leavetype/" method="post" name="upload_excel" enctype="multipart/form-data">
		<div class="box box-success">
			<div class="box-header">
			<strong>Upload <i class="fa fa-upload text-success pull-left"></i> </strong> 
			</div>
			<div class="box-body">
				<div class="form-group" >
					<div class="col-sm-12">
						<select class="form-control" name="template" id="template" >
							<option value="">Select Template</option>
							<?php 
							$get_temp = $this->transaction_employees_model->get_temp();
							foreach($get_temp as $template){
								echo '<option value="'.$template->template_name.'">'.$template->form_name.'</option>';
							}
							?>
						</select>
					</div>
				</div>
				<div class="form-group" >
					<div class="col-sm-12">	
						<select name="add_edit" value="" class="form-control">
							<option selected="" disabled="" value="">Select Type</option>
							<option value="new">Create new record</option>
							<option value="edit">Overwrite existing record</option>
						</select>				 
					</div>
				</div>
				<div class="form-group" >
					<div class="col-sm-12">	
						<select name="action" value="" class="form-control">
							<option  selected="" disabled="" value="">Select Action</option>
							<option value="Review">Upload and review</option>
							<option value="Save">Upload and save</option>

						</select>				 
					</div>
				</div>
				<div class="form-group" >
					<div class="col-sm-12">	
						  <input type="file" name="file" id="file" class="form-control" accept=".xls,.xlsx" required>		 
					</div>
				</div>
				<div class="form-group" >					
					<div class="col-sm-12">
						 <button onclick="myFunction()" type="submit" id="submit" name="import" class="btn btn-primary btn-xs"><i class="fa fa-upload"></i> Import</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
  </div>
</div>
</div>