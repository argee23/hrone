<title>Address</title>
<div ng-init="getAddress()">
  <div class="box-header with-border">
    <h3 class="box-title">Address</h3>
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
	<div class="col-lg-12">
	    <form name="add_info" method="post" action="update_address_info">
	        <div class="splash col-lg-12" ng-cloak="">
			    <div class="spinner">
			      <div class="double-bounce1"></div>
			      <div class="double-bounce2"></div>
			    </div>
			    <center><h3 class="text-primary">Please wait while data loads..</h3></center>
			</div>
	        <div ng-cloak>
	        <div class="col-lg-6">
	            <div class="panel panel-info">
	                <div class="panel-heading">Permanent Address</div>

	                <div class="panel-body">
	                  <div class="form-group" >
	                    <label>Province: </label>
	                      <select class="form-control" id="per_province" name="per_province" ng-model="address_info.permanent_province" ng-selected="address_info.permanent_province">
	                        <option ng-repeat="province in dataList.provinces" value="{{province.id}}">{{province.name}}</option>
	                      </select>

	                  </div>
	                  <div class="form-group">
	                    <label>City: </label>
	                      <select ng-disabled="address_info.permanent_province == undefined" class="form-control" id="per_city" name="per_city" ng-model="address_info.permanent_city" ng-selected="address_info.permanent_city">
	                        <option ng-repeat="city in dataList.cities" ng-if="city.province_id == address_info.permanent_province" value="{{city.id}}">{{city.city_name}}</option>
	                      </select>
	                  </div>
	                  <div class="form-group">
	                    <label>Address: </label>
	                    <input type="text" class="form-control" id="per_address" name="per_address" ng-model="address_info.permanent_address" ng-value="address_info.permanent_address">
	                  </div>
	                  <div class="form-group has-feedback" ng-class="{'has-error' : add_info.per_yrsofstay.$error.pattern}">
	                    <label>Years of Stay: <small ng-show="add_info.per_yrsofstay.$error.pattern"><i>Not <b><u>valid</u></b> number.</i></small></label>
	                    <input  class="form-control" id="per_yrsofstay" name="per_yrsofstay" ng-model="address_info.permanent_address_years_of_stay" ng-value="address_info.permanent_address_years_of_stay" ng-pattern="/^[0-9]{1,9}$/">
	                  </div>
	                </div>
	            </div>

	            <div class="form-group">
	                <label></label>
	                  <button type="submit" class="btn btn-block btn-success"  ng-disabled="add_info.$invalid"> <i class="fa fa-save"></i> Save Changes</button>
	            </div>
	        </div>

	        <div class="col-lg-6">
	            <div class="panel panel-warning">
	                <div class="panel-heading">Present Address</div>
	                <div class="panel-body">
	                  <div class="form-group">
	                    <label>Province: </label>
	                      <select class="form-control" id="pre_province" name="pre_province" ng-model="address_info.present_province">
	                        <option ng-repeat="province in dataList.provinces" value="{{province.id}}">{{province.name}}</option>
	                      </select>
	                  </div>
	                  <div class="form-group">
	                    <label>City: </label>
	                      <select ng-disabled="address_info.present_province == undefined" class="form-control" id="pre_city" name="pre_city" ng-model="address_info.present_city">
	                        <option ng-repeat="city in dataList.cities" ng-if="city.province_id == address_info.present_province" value="{{city.id}}">{{city.city_name}}</option>
	                      </select>
	                  </div>
	                  <div class="form-group">
	                    <label>Address: </label>
	                    <input type="text" class="form-control" id="pre_address" name="pre_address" ng-model="address_info.present_address" ng-value="address_info.present_address" >
	                  </div>
	                  <div class="form-group has-feedback" ng-class="{'has-error' : add_info.pre_yrsofstay.$error.pattern}">
	                    <label>Years of Stay: <small ng-show="add_info.pre_yrsofstay.$error.pattern"><i>Not <b><u>valid</u></b> number.</i></small></label>
	                    <input class="form-control" id="pre_yrsofstay" name="pre_yrsofstay" ng-model="address_info.present_address_years_of_stay" ng-value="address_info.present_address_years_of_stay" ng-pattern="/^[0-9]{1,9}$/">
	                  </div>
	                  <div class="checkbox">
  							<label><input type="checkbox" ng-change="copyPermanentAddress()" ng-model="copy_per_add">Same with permanent address</label>
						</div>
	                </div>
	            </div>
	        </div>
	        </div>
	    </form>
	</div>
	</div><!--  ng cloak -->
</div>