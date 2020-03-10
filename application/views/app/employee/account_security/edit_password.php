<form class="form-horizontal" method="post" action="<?php echo base_url()?>app/account_security/edit_password/<?php echo $this->uri->segment("4") ?>" > <!--on class -> this allows input fields to have spaces between them -->

			<div class="box-body">
				<div class="form-group">
    				<label class="col-sm-3 control-label">Employee ID</label>
        			<div class="col-sm-9">
          	  	<input type="text" class="form-control" name="employee_id" id="employee_id" placeholder="Employee ID" value ="<?php echo $info->employee_id ?>" disabled="disabled">
        			</div>
      			</div>
      			<div class="form-group">
    				<label class="col-sm-3 control-label">Full Name</label>
        			 <div class="col-sm-9">
          	  		<input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name" value ="<?php echo $info->last_name.', '.$info->first_name.' '.$info->middle_name ?>" disabled="disabled">
      			   </div>
            </div>	
            <div class="form-group">
            <label class="col-sm-3 control-label"> Username</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Username" value ="<?php echo $info->username ?>" disabled="disabled">
                <input type="hidden" name="username" value ="<?php echo $info->username ?>">
              </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 control-label"> New Password </label>
              <div class="col-sm-9">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" value ="" required="required">
              </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 control-label"> Confirm Password </label>
              <div class="col-sm-9">
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" value ="" required="required">
              </div>
            </div>
          		<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Save</button> 
    		</div>

</form>
