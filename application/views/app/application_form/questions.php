<br>
<title>HR Questions</title>

<body class="content-body" ng-app="jobApp" ng-controller="appCtrl" ng-init="getCompanyRequirements()">
<!-- Search for a Job -->
<div class="container-fluid">
<h3 data-toggle="tooltip" title="Companies that require you to submit requirements for the job you applied.">HR Questions</h3>
<hr>
<div class="col-sm-3">
  <div class="list-group" >
    <a href="#" class="list-group-item" ng-repeat="cr in compReqList" ng-click="getQuestionList(cr); updateToViewed(cr.application_id)">
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
    <div class="panel-heading">Question List</div>
    <div class="panel-body">
        <h3>{{selectedJob.job_title}}</h3>
    	<h4>{{selectedJob.company_name}}</h4>
		<div ng-hide="pqList.length == 0"><br>

         <form name="pre_questions" action="submit_pq_answers" method="post">
                <input type="hidden" name="job_id" id="job_id" value="{{selectedJob.job_id}}">
        <input type="hidden" name="company_id" id="company_id" value="{{selectedJob.company_id}}">
 <span ng-show="pqList.length == 0">
 <center><h3>
 No questions set yet.
 </h3>
 </center>
 </span>
 <div class="box-body fixed-panel">
    <ol>
      <div class="form-group" ng-repeat="q in pqList">
      
      <li><label>{{q.question}}</label></li>

        <div ng-if="q.question_type == 'multiple_choice'">
            <div ng-repeat="aChoice in q.choices">
                  <div class="checkbox">
                    <label>
                      <input ng-checked="aChoice.selected==1" type="checkbox" name="pq_{{q.id}}[]" value="{{aChoice.mc_id}}">{{aChoice.mc_choice}}
                    </label>
                  </div>
            </div>
        </div>
        <div ng-if="q.question_type == 'hypothetical'">
            <input id="pq_{{q.id}}" name="pq_{{q.id}}" class="form-control" placeholder="Place your answer here..." type="text" ng-model="q.answer">
        </div>

      </div>
    </ol>
  </div>
  <div class="panel-footer">
  <center><button type="submit" class="btn btn-success" ng-disabled="pqList.length == 0">Submit Answers</button></center>
  </div>
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
    	$http.post('get_company_questions').success(function(data){
        	$scope.compReqList = data;
        });
    }

    $scope.getQuestionList = function(cr)
    {
    	$scope.selectedJob = cr;
    	$http.post('getQuestions/' + cr.job_id + "/" + cr.company_id).success(function(data){
        	$scope.pqList = data;

        });
    }

    $scope.updateToViewed = function(app_id)
    {
    	$http.post('update_to_viewed/' + app_id + '/que').success(function(data){
        	$scope.response = data;
        });
    }
}]);

</script>
