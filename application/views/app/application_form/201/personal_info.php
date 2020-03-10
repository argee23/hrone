<script type="text/javascript" src="<?php echo base_url()?>public/plugins/daterangepicker/moment.min.js"></script>
<title>Personal Information</title>
  <div class="box-header with-border">
    <h3 class="box-title">Personal Information</h3>
    <div class="box-tools pull-right">
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
<div ng-init="getPersonalInfo()">
	<form name="personalinfo" method="post" action="update_personal_info">
	    <div class="col-lg-12">
	     <div class="col-lg-6">
	         <div class="form-group has-feedback" ng-class="{'has-error' : personalinfo.first_name.$invalid}">
	            <label>First Name: </label>
	            <input type="text" class="form-control" id="first_name" name="first_name" ng-model="personal_info.first_name" required>
	            <span ng-show="personalinfo.first_name.$invalid" class="fa fa-times form-control-feedback"></span>
	         </div>
	         <div class="form-group has-feedback" ng-class="{'has-error' : personalinfo.middle_name.$invalid}">
	          <label>Middle Name: </label>
	            <input type="text" class="form-control" id="middle_name" name="middle_name" ng-model="personal_info.middle_name" required>
	            <span ng-show="personalinfo.middle_name.$invalid" class="fa fa-times form-control-feedback"></span>
	          </div>
	          <div class="form-group has-feedback" ng-class="{'has-error' : personalinfo.last_name.$invalid}">
	          <label>Last name: </label>
	            <input type="text" class="form-control" id="last_name" name="last_name" ng-model="personal_info.last_name" required >
	            <span ng-show="personalinfo.last_name.$invalid" class="fa fa-times form-control-feedback"></span>
	          </div>
	          <div class="form-group">
	            <label>Nickname: </label>
	            <input type="text" class="form-control"  id="nickname" name="nickname" ng-model="personal_info.nickname">
	          </div>
	         <div class="form-group">
	         <label></label>
	          <button type="submit" class="btn btn-block btn-success" ng-disabled="personalinfo.$invalid"><i class="fa fa-save"></i> Save Changes</button>
	          </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group" ng-class="{'has-error' : personalinfo.birthday.$invalid}">
	          <label>Birthday:</label><br>
	            <input type="text" style="width: 100%" id="birthday" name="birthday" ng-model="personal_info.birthday">
	          </div>
	          <div class="form-group" ng-class="{'has-error' : personalinfo.gender.$invalid}">
	          <label>Gender:</label>
	            <select class="form-control" ng-model="personal_info.gender" name="gender" id="gender" ng-selected="personal_info.gender"s>
	              <option ng-repeat="gender in dataList.genders" value="{{gender.gender_id}}">{{gender.gender_name}}</option>
	            </select>
	          </div>
	         <div class="form-group" ng-class="{'has-error' : personalinfo.civilstatus.$invalid}">
	          <label>Civil Status:</label>
	            <select class="form-control"  ng-model="personal_info.civil_status" name="civilstatus" id="civilstatus" ng-selected="personal_info.civil_status">
	              <option ng-repeat="civilstatus in dataList.civilstatuses" value="{{civilstatus.civil_status_id}}">{{civilstatus.civil_status}}</option>
	            </select>
	          </div>
	     </div>
	     <br><br>
	</div>
	</form>
</div>
</div> <!-- NGCLOAK -->

<script>
 var startdate = moment();
 startdate = startdate.subtract(15, "year").format('YYYY-MM-DD'); //do not allow applicant under 15

 var enddate = moment();
 enddate = enddate.subtract(70, "year").format('YYYY-MM-DD'); //do not allow applicant greater than 70.

$('#birthday').Zebra_DatePicker({
 direction: [enddate, startdate] 
});
</script>