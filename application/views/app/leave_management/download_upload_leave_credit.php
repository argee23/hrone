 <?php
 $company_id=$this->uri->segment("5");

 ?>
<div class="row">
<div class="col-md-12">
<div class="well">


  	<div class="box box-header">
  		     <i class="fa fa-info fa-lg text-danger pull-left"  data-toggle="tooltip" data-placement="left" ></i>
         Manual Upload Leave Credits
  	</div>
    <div class="box-body">
   

		 <form target="_blank" action="<?php echo base_url();?>app/leave_management/manual_upload_leave_credit/" method="post" name="upload_excel" enctype="multipart/form-data">


          <input type="hidden" name="leave_id" value="<?php echo $this->uri->segment("4");?>">
          <input type="hidden" name="leave_type" value="<?php echo $leave_type->leave_type?>">   

         
		 	
		<div class="box box-success">
			<div class="box-header">
			<strong>Upload <i class="fa fa-upload text-success pull-left"></i> </strong> 
			</div>
			<div class="box-body">

				<div class="form-group" >
					<div class="col-sm-12">	Cover Year
						 <input type="number" class="form-control" name="cover_year" value="<?php echo date('Y');?>" maxlength="4" >   		 
					</div>
				</div>
				<div class="form-group" >
					<div class="col-sm-12">	Action
						<select name="action" value="" class="form-control">
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
						 <button onclick="myFunction()" type="submit" id="submit" name="import" class="btn btn-primary btn-md"><i class="fa fa-upload"></i> Import</button>
					</div>
				</div>
				</form>






     </div> <!-- body -->


</div>
</div>
</div>