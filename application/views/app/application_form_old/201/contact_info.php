<title>Contact Information</title>
<div ng-init="getContactInfo()">
  <div class="box-header with-border">
    <h3 class="box-title">Contact Information</h3>
    <div class="box-tools pull-right">
    <span class="label label-danger" ng-show="contactinfo.$invalid" ng-cloak>Some of the information you provided are not valid.</span>
    </div>
  </div>
  <br> 
  <div class="splash col-lg-12" ng-cloak="">
    <div class="spinner">
      <div class="double-bounce1"></div>
      <div class="double-bounce2"></div>
    </div>
    <center><h3 class="text-primary">Please wait while data loads..</h3></center>
  </div>  

  <div ng-cloak>
    <form name="contactinfo" method="post" action="update_contact">
        <div class="col-lg-12">
          <div class="col-lg-6">
          <div class="form-group has-feedback" ng-class="{'has-error' : contactinfo.mobile_1.$invalid}">
          <label>Mobile No. (1):
            <small ng-show="contactinfo.mobile_1.$error.pattern">Mobile Number Format: 09xx-xxx-xxxx</small>
            <small ng-show="contactinfo.mobile_1.$error.required"><i>Atleast 1 mobile number is required.</i></small>
          </label>
          
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-mobile-phone"></i></span>
            <input id="mobile_1" type="text" class="form-control" name="mobile_1" ng-model="contact_info.mobile_1" value="{{contact_info.mobile_1}}" maxlength="14" ng-pattern="/^([0-9]{4,4})[-]([0-9]{3,3})[-]([0-9]{4,4})$/" placeholder="Sample: 09xx-xxx-xxx" required>
             <span ng-show="contactinfo.mobile_1.$dirty && contactinfo.mobile_1.$valid && contact_info.mobile_1.length > 0"" class="fa fa-check form-control-feedback has-success"></span>
          </div>
          </div>
          <div class="form-group has-feedback" ng-class="{'has-error' : contactinfo.mobile_2.$invalid}">
          <label>Mobile No.(2): <small ng-show="contactinfo.mobile_2.$error.pattern">Mobile Number Format: 09xx-xxx-xxxx</small></label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-mobile-phone"></i></span>
            <input id="mobile_2" type="text" class="form-control" name="mobile_2" ng-model="contact_info.mobile_2" maxlength="14" ng-pattern="/^([0-9]{4,4})[-]([0-9]{3,3})[-]([0-9]{4,4})$/" placeholder="Sample: 09xx-xxx-xxx">
          </div>
          </div>
          <div class="form-group has-feedback" ng-class="{'has-error' : contactinfo.tel_1.$invalid}">
         <label>Telephone No. (1): <small ng-show="contactinfo.tel_1.$error.pattern"><i>Not a valid tel. number.</i></small></label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
            <input id="tel_1" type="text" class="form-control" placeholder="7 digit telephone number" name="tel_1" ng-model="contact_info.tel_1" maxlength="7" ng-pattern="/^[0-9]{7,7}$/">
          </div>
          </div>
          <div class="form-group  has-feedback" ng-class="{'has-error' : contactinfo.tel_2.$invalid}">
         <label>Telephone No. (2): <small ng-show="contactinfo.tel_2.$error.pattern"><i>Not a valid tel. number.</i></small></label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
            <input id="tel_2" type="text" class="form-control" name="tel_2" placeholder="7 digit telephone number" ng-model="contact_info.tel_2" maxlength="7" ng-pattern="/^[0-9]{7,7}$/">
          </div>
          <div class="form-group"><br>
          <button type="submit" class="btn btn-block btn-success" ng-disabled="contactinfo.$invalid"><i class="fa fa-save"></i> Save Changes
          </button>
          </div>
          </div>
          </div>
          <div class="col-lg-6">
          <div class="form-group" ng-class="{'has-error' : contactinfo.email.$invalid}">
          <label>Email Address: <small ng-show="contactinfo.email.$invalid"><i>Please provide a valid email address.</i></small></label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-at"></i></span>
            <input id="email" placeholder="sample@email.com" type="email" class="form-control" name="email" ng-model="contact_info.email" required>
          </div>
          </div>
          <div class="form-group has-feedback" ng-class="{'has-error' : contactinfo.instagram.$invalid}">
          <label>Instagram Username: <small ng-show="contactinfo.instagram.$invalid"><i>Sample Format: @username</i></small></label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-instagram"></i></span>
            <input id="instagram" type="text" placeholder="@username" class="form-control" name="instagram" ng-model="contact_info.instagram">
          </div>
          </div>
          <div class="form-group">
          <label>Facebook URL:</label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
            <input id="facebook" type="text" placeholder="www.facebook.com/your_url" class="form-control" name="facebook" ng-model="contact_info.facebook">
          </div>
          </div>
         <div class="form-group">
          <label>Twitter Username:</label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
            <input id="twitter" type="text" placeholder="@username" class="form-control" name="twitter" ng-model="contact_info.twitter">
          </div>
          </div>

          </div>
          </div>
  </form>
  </div> <!-- ngcloak -->
</div>