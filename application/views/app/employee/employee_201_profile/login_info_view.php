<?php include('header.php');?>
        
        <div id="col_2">
                
                <div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>LOGIN INFORMATION</strong></div>
  <div class="box-body">
  <div class="panel panel-success">
    <br>

         <div class="box-body">
         <?php $md5_val = md5($employee->password); ?> 
                
            <?php if($checker_inactive==0){?>
                  
                <div class="col-md-12">
                <div class="form-group">
                <div class="btn-toolbar">
                  <a href="<?php echo base_url(); ?>app/employee_201_profile/reset_password_default/<?php echo $employee->employee_id; ?>" type="button" class="btn btn-danger btn-xs pull-right" title="Set to default password" onClick="return confirm('Are you sure you want to Reset the password to its default form?')" ><i class="fa fa-wrench"></i> Reset password</a>

                  <?php }
                  if($employee->isEnable == 1){
                      $status = 'Active'; ?>
                     <?php if($checker_inactive==0){?>   <a href="<?php echo base_url(); ?>app/employee_201_profile/disable_account/<?php echo $employee->employee_id; ?>" type="button" class="btn btn-warning btn-xs pull-right" title="Disable account" onClick="return confirm('Are you sure you want to Disable account?')" ><i class="fa fa-power-off" style="color:red;"></i> Disable account</a> <?php } ?>
                  <?php }
                  if($employee->isEnable == 0){
                      $status = 'Inactive'; ?>
                      <?php if($checker_inactive==0){?>  <a href="<?php echo base_url(); ?>app/employee_201_profile/enable_account/<?php echo $employee->employee_id; ?>" type="button" class="btn btn-warning btn-xs pull-right" title="Enable account" onClick="return confirm('Are you sure you want to Enable account?')" ><i class="fa fa-power-off" style="color:green;"></i> Enable account</a> <?php } ?>
                  <?php }  ?>

                </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                  <div class="col-sm-4">
                  <p>Username</p>
                  </div>
                  <div class="col-sm-7">
                    <label for="username"><?php echo $employee->username; ?></label>
                  </div>
                </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <div class="col-sm-4">
                    <p>Password</p>
                    </div>
                    <div class="col-sm-7">
                      <a type="text" data-toggle="tooltip" data-placement="right" title="<?php if($this->session->userdata('serttech_account')=="1"){ 
                        if($employee->encrypt_password==1){ echo $this->encrypt->decode($employee->password); }  else { echo $employee->password; } } else { echo $employee->password; }?>"><?php echo $md5_val; ?></a>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <div class="col-sm-4">
                    <p>Status</p>
                    </div>
                    <div class="col-sm-7">
                      <label><?php echo $status; ?></label>
                    </div>
                  </div>
                </div>

                    <p style="color:#ff0000; text-align: center;"><strong>NOTE:  </strong>Hover mouse to the value of password to view the correct Password.</p>


         </div><!-- /.box-body --> 
         <br>
   </div> 
</div>
</div>

</div>
</div>  
</div>


        </div>  
</div>

<script>
  
  
</script>

        </div>

        </div>
 <?php include('footer.php');?>


