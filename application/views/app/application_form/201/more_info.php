<title>More Information</title>
<div ng-init="getMoreInfo()">
  <div class="box-header with-border">
    <h3 class="box-title">More Information</h3>
    <div class="box-tools pull-right">
    <span class="label label-danger" ng-show="moreinfo.$invalid">Some of the information you provided are not valid.</span>
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
	<div class="col-lg-12">
	    <form name="moreinfo" role="form" method="post" action="update_more_info">

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Blood Type:</label>
	            <select class="form-control" id="bloodtype" name="bloodtype" ng-model="more_info.blood_type" ng-selected="more_info.blood_type">
	                <option ng-repeat="bloodtype in dataList.bloodtypes" value="{{bloodtype.param_id}}">{{bloodtype.cValue}}</option>
	             </select>
	        </div>

	        <div class="form-group">
	          <label>Religion:</label>
	            <select class="form-control" id="religion" name="religion" ng-model="more_info.religion" ng-selected="more_info.religion">
	          <option ng-repeat="religion in dataList.religions" value="{{religion.param_id}}">{{religion.cValue}}</option>
	            </select>
	        </div>

	        <div class="form-group">
	          <label>Citizenship:</label>
	            <select class="form-control" id="citizenship" name="citizenship" ng-model="more_info.citizenship">
	              <option ng-repeat="citizenship in dataList.citizenships" value="{{citizenship.param_id}}">{{citizenship.cValue}}</option>
	            </select>
	        </div>

	        <div class="form-group has-feedback" ng-class="{'has-warning' : moreinfo.tin.$invalid}">
	          <label>TIN No. <small ng-show="moreinfo.tin.$error.pattern"><i>A <b><u>valid</u></b> TIN number consists of 9 numbers.</i></small></label>
	            <input type="text" class="form-control" id="tin" name="tin" ng-model="more_info.tin" ng-value="more_info.tin" maxlength="9" ng-pattern="/^[0-9]{9,9}$/">
	            <span ng-show="moreinfo.tin.$dirty && moreinfo.tin.$valid && more_info.tin.length > 0" class="fa fa-check form-control-feedback has-success"></span>
	        </div>

	        <div class="form-group">
	        <label></label>
	          <button type="submit" ng-disabled="moreinfo.$invalid" class="btn btn-block btn-success"><i class="fa fa-save"></i>  Save Changes</button>
	        </div>

	    </div>
	    <div class="col-lg-6">

	    <div class="form-group  has-feedback" ng-class="{'has-warning' : moreinfo.philhealth.$invalid}">
	      <label>PhilHealth No. <small ng-show="moreinfo.philhealth.$error.pattern"><i>A <b><u>valid</u></b> PhilHealth number consists of 12 nos.</i></small></label>
	        <input type="text" class="form-control" id="philhealth" name="philhealth" ng-model="more_info.philhealth" ng-value="more_info.philhealth" maxlength="12" ng-pattern="/^[0-9]{12,12}$/">
	        <span ng-show="moreinfo.philhealth.$dirty && moreinfo.philhealth.$valid && more_info.philhealth.length > 0" class="fa fa-check form-control-feedback has-success"></span>
	    </div>
	      <div class="form-group has-feedback" ng-class="{'has-warning' : moreinfo.sss.$invalid}">
	      <label>SSS No. <small ng-show="moreinfo.sss.$error.pattern"><i>A <b><u>valid</u></b> SSS number consists of 10 numbers.</i></small></label>
	        <input type="text" class="form-control" id="sss" name="sss" maxlength="10" ng-model="more_info.sss" ng-value="more_info.sss" ng-pattern="/^[0-9]{10,10}$/">
	        <span ng-show="moreinfo.sss.$dirty && moreinfo.sss.$valid && more_info.sss.length > 0" class="fa fa-check form-control-feedback has-success"></span>
	      </div>

	    <div class="form-group has-feedback" ng-class="{'has-warning' : moreinfo.pagibig.$invalid}">
	      <label>Pagibig No. <small ng-show="moreinfo.pagibig.$error.pattern"><i>A <b><u>valid</u></b> PAGIBIG number consists of 12 numbers.</i></small></label>
	        <input type="text" class="form-control" id="pagibig" name="pagibig" ng-model="more_info.pagibig" ng-value="more_info.pagibig" maxlength="12" ng-pattern="/^[0-9]{12,12}$/">
	         <span ng-show="moreinfo.pagibig.$dirty && moreinfo.pagibig.$valid && more_info.pagibig.length > 0" class="fa fa-check form-control-feedback has-success"></span>
	    </div>
	    </form>
	</div>
	</div> <!-- ngcloak -->
</div>