<title>Change Password</title>
  <div class="box-header with-border">
    <h3 class="box-title">Change Password</h3>
    <div class="box-tools pull-right">
    </div>
  </div>
  <!-- /.box-header -->
 <form name="change_pass" action="change_pass" method="post">
  <div class="box-body fixed-panel">


<div class="form-group  has-feedback" ng-class="{'has-error' : change_pass.current_password.$invalid}">
  <label>Current Password:
  <i><small>
  <span ng-show="change_pass.current_password.$error.required"  >Please provide your current password.</span>
  </small>
  </i>
  </label>
  <input type="password" class="form-control" id="current_password" name="current_password" ng-model="current_password" required>
</div>
<legend></legend>
<div class="form-group  has-feedback" ng-class="{'has-error' : change_pass.new_password.$invalid}">
  <label>Desired New Password:
  <i><small>
  <span ng-show="change_pass.new_password.$error.required"   >New password is required.</span>
  <span ng-show="change_pass.new_password.$error.minlength"  >A valid password contains atleast 8 characters.</span>
  </small>
  </i>
  </label>
  <input type="password" class="form-control" id="new_password" name="new_password" ng-model="new_password" minlength="8" required>

</div>
<div class="form-group  has-feedback" ng-class="{'has-error' : change_pass.retype_password.$invalid}">
  <label>Retype Password:
    <i><small>
  <span ng-show="change_pass.retype_password.$error.required"  >Retype password is required.</span>
  <span ng-show="change_pass.retype_password.$error.minlength" >A valid password contains atleast 8 characters.</span>
  </small>
  </i></label>
  <input type="password" class="form-control" id="retype_password" name="retype_password" ng-model="retype_password" minlength="8" required>
</div>
  <div class="panel-footer">
  <center><button type="submit" ng-disabled="change_pass.$invalid" class="btn btn-success">Change Password</button></center>
  </div>
 </form>
<!--/.direct-chat -->