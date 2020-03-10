<div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>ACCOUNT SECURITY</strong></div>
  <div class="box-body">
  <div class="panel panel-success">

         <div class="box-body">
         <div class="row">

         		    <div class="col-md-12">
                <div class="form-group">
                <div class="btn-toolbar">
                  
                  	<a href="<?php echo base_url(); ?>app/employee_account_management/reset_all_password_default/" type="button" class="btn btn-danger btn-xs pull-right" title="Reset all password to default" onClick="return confirm('Are you sure you want to RESET ALL PASSWORD to its default form?')" ><i class="fa fa-wrench"></i> RESET ALL PASSWORD</a>

                  	<a href="<?php echo base_url(); ?>app/employee_account_management/download_employee_all_account/" type="button" class="btn btn-primary btn-xs pull-right" title="Download all account list"><i class="fa fa-download"></i> ACCOUNT LIST</a>

                </div>
                </div>
                </div>
                <br>

                <div class="col-md-12">
                <div class="form-group">
                  <div class="col-sm-4">
                  <p>Default Password:</p>
                  </div>
                  <div class="col-sm-7">
                    <label><?php echo $default_password->field_desc; ?>  <a onclick="reset_default_password()" type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="Change default password"><i class="fa fa-pencil-square-o fa-lg text-warning pull-right"></i></a></label>
                    <div id="reset_password">
                    </div>
                  </div>
                </div>
                </div>

                <p style="color:#ff0000; text-align: center;"><strong>NOTE:  </strong>Default password is the "<strong><?php echo $default_password->field_desc; ?></strong>" of Employee.</p>

         </div><!-- /.box-body --> 
         <br>
   </div> 
</div>
</div>

</div>
</div>  
</div>
