<br>
<title>Job Requirements</title>

<body class="content-body" ng-app="jobApp" ng-controller="appCtrl" ng-init="getCompanyRequirements()">
<!-- Search for a Job -->
<div class="container-fluid">
<h3 data-toggle="tooltip" title="Companies that require you to submit requirements for the job you applied.">Job Requirements</h3>
<hr>
<div class="col-sm-3">
  <div class="list-group" >
    <a href="#" class="list-group-item" ng-repeat="cr in compReqList" ng-click="getRequirementList(cr); updateToViewed(cr.application_id)">
	<div class="media">
	  <div class="media-left">
	    <img src="<?php echo base_url() . 'public/company_logo/' ?>{{cr.logo}}" class="media-object" style="width:60px">
	  </div>
	  <div class="media-body">
	    <h4 class="media-heading">{{cr.job_title}}</h4>
	    <p>{{cr.company_name}}</p>
	  </div>
	</div>
    </a>
  </div>
</div>

<div class="col-sm-9">
 			<!-- Success Feedback -->
        <?php if ($this->session->flashdata('feedback')) { ?>
             <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Success!</strong> <?php echo $this->session->flashdata('feedback'); ?>
            </div>
        <?php } ?>

        <!-- Failed Feedback -->
        <?php if ($this->session->flashdata('error')) { ?>
         <div class="alert alert-danger">
          <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Error:</strong> <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php } ?>

        <?php echo validation_errors(); ?> 

 <div class="panel panel-default panel-success" ng-hide="selectedJob == ''">
    <div class="panel-heading">Requirements List</div>
    <div class="panel-body">
        <h3>{{selectedJob.job_title}}</h3>
    	<h4>{{selectedJob.company_name}}</h4>
		<div ng-hide="reqList.length == 0"><br>

		<form name="submit_requirements" id="submit_requirements" method="post" enctype="multipart/form-data" action="submit_requirements">
		<input type="hidden" name="job_id" id="job_id" value="{{selectedJob.job_id}}">
		<input type="hidden" name="company_id" id="company_id" value="{{selectedJob.company_id}}">
		<table class="table table-bordered table-responsive table-hover" role="grid">
		<thead>
			<tr>
				<td>Item Name</td>
				<td>Upload</td>
				<td>Status</td>
			</tr>
		</thead>
		<tbody>
			<tr role="row" class="odd" ng-repeat="r in reqList" ng-class="{'success': r.submitted == 1}">
				<td>{{r.item_name}}</td>
				<td ng-show="r.IsUploadable == 1"><input id="req_{{r.req_id}}" name="req_{{r.req_id}}" type="file"></td>
				<td ng-show="r.IsUploadable == 0"><strong>Softcopy not allowed</strong></td>
				<td ng-show="r.IsUploadable == 1"><center><span ng-if="r.submitted == 1" class="label label-success"> Submitted <i class="fa fa-check-square"></i></span></center></td>
			</tr>
		</tbody>
		</table>
		<div class="callout callout-warning">
	    <h4>WARNING</h4>

	    <p>Allowed File Types: <strong> JPG, PNG, GIF, PDF </strong> | File Size should <strong>not Exceed 800 KB</strong></p>
	  </div>
		<button type="submit" class="btn btn-success pull-right">Submit Requirements</button>
		<!-- {{sub_reqs}} -->
		</form>
		</div>

    </div>
  </div>
</div>
</div>
</body>

<script>
var appl = angular.module('jobApp', []);

appl.controller('appCtrl', ['$scope', '$http', '$location', '$window', function($scope, $http, $location, $window) {

	$scope.selectedJob = '';

    $scope.getCompanyRequirements = function()
    {
    	$http.post('get_company_requirements').success(function(data){
        	$scope.compReqList = data;
        });
    }

    $scope.getRequirementList = function(cr)
    {
    	$scope.selectedJob = cr;
    	$http.post('get_requirements/' + cr.job_id + "/" + cr.company_id).success(function(data){
        	$scope.reqList = data;

        });
    }

    $scope.updateToViewed = function(app_id)
    {
    	$http.post('update_to_viewed/' + app_id + '/req').success(function(data){
        	$scope.response = data;
        });
    }
}]);

</script>
