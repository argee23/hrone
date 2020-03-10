<div class="col-md-12" >
  <div class="tab-content">
    <div class="tab-pane active" id="p_info">
      <div class="panel panel-success">
        <div class="panel-heading">
          <h4 class="text-danger">Change Password</h4>
        </div>
     <div class="panel-body" style="height:440px;">
          <div class="col-md-3"></div>
             <form name="change_pass" action="change_pass" method="post">
                <div class="col-md-6 box-body fixed-panel">
                  <div class="form-group  has-feedback" ng-class="{'has-error' : change_pass.current_password.$invalid}">
                    <label>Current Password:
                    <i><small>
                    
                    </small>
                    </i>
                    </label>
                    <input type="hidden" name="password" id="old_password" value="<?php echo $password?>">
                    <input type="password" class="form-control" id="current_password" name="current_password" onkeyup="correct_password(this.value,'check_oldpass')"; required>
                    <span id="old_password_checker"></span>
                  </div>
                  <legend></legend>
                  <div class="form-group">
                    <label>New Password:</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" ng-model="new_password" minlength="8" required onkeyup="correct_password(this.value,'new_pass')">
                    
                    <span id="new_password_needed"></span>
                   
                  </div>
                  <div class="form-group">
                    <label>Confirm Password:</label>  
                    <input type="password" class="form-control" id="retype_password" name="retype_password" minlength="8" required onkeyup="correct_password(this.value,'confirm_pass')">
                     <span id="confirmpass"></span>
                  </div>
                  <div class="panel-footer">
                    <center><button type="submit" id='save_button' class="btn btn-success" disabled>Change Password</button></center>
                    </div>
             </form>
              <div class="col-md-3"></div>
          </div>
  </div>
</div>
