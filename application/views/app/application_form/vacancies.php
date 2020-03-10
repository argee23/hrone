<br>
<title>Search for a Job - Job Vacancies</title>
<body class="content-body" ng-app="jobApp" ng-controller="appCtrl" ng-init="getVacancies(); getInterviewRequests()" ng-cloak>
<!-- Search for a Job -->
<div class="col-sm-9">

<div class="s header_text" style="padding: 5px 5px 5px 5px">
           Job Vacancies  <span class="text-success">Apply Now</span>
           <div class="pull-right">
              <form class="form-inline">
                  <div class="form-group" class="form-horizontal">
                    <div class="col-sm-12">
                     <input type="text" class="form-control" ng-model="key" id="search" name="search" placeholder="Search a job..." required>
                     
                <?php $provinceList= $this->general_model->provinceList();?>
                    <select class="form-control" name="province" ng-model="province" id="province" required>
                       <option value="All" selected>All Location</option>
                          <?php foreach($provinceList as $province){?>
                         <option value="<?php echo $province->id;?>"><?php echo $province->name;?></option>
                        <?php } ?>
                    </select>

                      <select ng-model="field" class="form-control" id="category" name="category" required>
                        <option selected disabled>Select a Category</option>
                        <option value="job_title">Job Title</option>
                        <option value="company_name">Company Name</option>
                        <option value="specialization">Specialization</option>
                      </select>
                    </div>
                  </div>
                <button type="button" class="btn btn-default" ng-disabled="field==''" ng-click="searchJob()"><i class="fa fa-search"></i></button>
              </form>
            </div>
</div>


<div ng-repeat="jobDetails in vacancies">
        <div id="job-details">
        <div class="panel panel-default">


          <div class="panel-body">
            <div class="panel-header">
              <h3 class="text-info">{{jobDetails.job_title}}</h3></div>
                <p>Date Posted: <strong>{{jobDetails.date_posted | date: "longDate"}}</strong></p>
                <dl>  
                  <dt><h4><strong>Job Description</strong></h4></dt>
                  <dd>{{jobDetails.job_description}}</dd>
                  <dt><h4><strong>Qualification</strong></h4></dt>
                  <dd class="multi_lines_text">{{jobDetails.job_qualification}}</dd>
                  <dt><h4><strong>Number of Vacancies</strong></h4></dt>
                  <dd class="multi_lines_text">{{jobDetails.job_vacancy}}</dd>
                  <dt><h4><strong>Salary</strong></h4></dt>
                  <dd>{{jobDetails.salary}}</dd>
                </dl>

              <dt><h4><strong>About the Company</strong></h4></dt>
                <div class="media">
                  <div class="media-left media-top">
                    <img src="<?php echo base_url();?>public/company_logo/{{jobDetails.logo}}" class="media-object" style="width:80px">
                  </div>
                  <div class="media-body">
                    <h4 class="media-heading">{{jobDetails.company_name}} </h4>
                    <p>{{jobDetails.company_address}}</p>
                  </div>
                </div>
                <center>
                  <p class="text-muted"><i>Hiring will start on <strong>{{jobDetails.hiring_start | date: "longDate"}}</strong> and will end on <strong>{{jobDetails.hiring_end | date: "longDate"}}</strong></i></p>
                </center>
              <button type="button" name="app_button" id="app_button" class="btn btn-info btn-flat btn-block" ng-click="evaluateVacancy(jobDetails)" data-toggle="modal" data-target="#myModal"><b>APPLY NOW</b></button>
          </div>  
        </div>
      </div>
</div>
</div>
<!-- End search -->
<div  style="margin-top: 20px;">
  <div class="col-sm-3 col-sm-offset-9" style="position:fixed;">
        <div class="box box-primary">
               <div class="box-header with-border">
                    <h4 class="box-title" style="font-family: serif;"><a style="cursor: pointer;text-decoration: none;color:black;" onclick="collapse('advanced_searching');">Click here for advanced searching</a> <br></h4>
                     <span class="pull-right"><i class="fa fa-search"></i></span>
                </div>
              <div class="box-body" id="advanced_searching">
               
                <table class="table table-user-information">
                  <tbody>
                    <tr>
                      <td><n class="text-info"><a  style="cursor:pointer;" style='cursor:pointer;' onclick="collapse('search_criteria');" aria-hidden='true' data-toggle='tooltip'>Search Criteria
                        <span class="pull-right"><i class="glyphicon glyphicon-chevron-right"></i></span></a></n>

                      <form class="form-inline">
                        <div id="search_criteria">
                          <input type="text" class="form-control"  ng-model="criteria" id="searchcriteria" name="searchcriteria" placeholder="Search Criteria" style="margin-top: 10px;width: 100%;" required>
                          <select class="form-control"  ng-model="category" style="margin-top: 5px;width: 100%;" id="searchcriteria_category" name="searchcriteria_category" required>
                            <option value="" selected disabled>Select Category</option>
                            <option value="job_title">Job Title</option>
                            <option value="company_name">Company</option>
                          </select>

                          <select class="form-control" style="margin-top: 5px;width: 100%;"  ng-model="province" id="searchcriteria_province" name="searchcriteria_province" onchange="get_city_list(this.value,'searchcriteria_city');" required>
                            <option value="" selected disabled>Select Province</option>
                            <option value="All">All</option>
                            <?php foreach($provinceList as $p)
                            {
                              echo "<option value='".$p->id."'>".$p->name."</option>";
                            }?>
                          </select>

                          <select class="form-control" style="margin-top: 5px;width: 100%;"  ng-model="city" id="searchcriteria_city" name="searchcriteria_city" required>
                            <option value="" selected disabled>Select City</option>
                            <option value="All">All</option>
                          </select>

                          <select class="form-control" style="margin-top: 5px;width: 100%;"  ng-model="specialization" id="searchcriteria_specialization" name="searchcriteria_specialization" required>
                            <option value="" selected disabled>Select Specialization</option>
                            <option value="All">All</option>
                           <?php
                                  $job_specList = $this->general_model->job_specializationList();
                                    foreach ($job_specList as $job_specs){
                                    echo "<option value='".$job_specs->param_id."'>".$job_specs->cValue."</option><br>";
                                    }
                                  ?>
                          </select>

                          <input type="text" class="form-control" ng-model="rangefrom" placeholder="Expected Salary Range From" style="margin-top: 10px;width: 100%;" id="searchcriteria_salaryfrom" name="searchcriteria_salaryfrom" onkeypress="return isNumberKey(this, event);" required >

                          <input type="text" class="form-control"  ng-model="rangeto" placeholder="Expected Salary Range To" style="margin-top: 10px;width: 100%;" id="searchcriteria_salaryto" name="searchcriteria_salaryto" onkeypress="return isNumberKey(this, event);" required>

                          <button  style="width:100%;margin-top: 5px;"  ng-click="searchJob_main()">Search</button>
                        </div>
                    </form>


                      </td>
                    </tr>

                    <tr>
                      <td><n class="text-info"><a style="cursor:pointer;" onclick="collapse('search_location');">Search By Location 
                        <span class="pull-right"><i class="glyphicon glyphicon-chevron-right"></i></span></a></n>

                        <form class="form-inline">

                        <div id="search_location" style="display: none;">
                          <input type="text" class="form-control" placeholder="Search Criteria" id="searchlocation" name="searchlocation" style="margin-top: 10px;width: 100%;"  ng-model="criteria" required>
                          <select class="form-control" style="margin-top: 5px;width: 100%;" id="searchlocation_category" name="searchlocation_category" ng-model="category" required>
                            <option value="" selected disabled>Select Category</option>
                            <option value="job_title">Job Title</option>
                            <option value="company_name">Company</option>
                            <option value="specialization">Specialization</option>
                          </select>

                          <select class="form-control" style="margin-top: 5px;width: 100%;" id="searchlocation_province" name="searchlocation_province"onchange="get_city_list(this.value,'searchlocation_city');" ng-model="province" required>
                            <option value="" selected disabled>Select Province</option>
                            <option value="All">All</option>
                            <?php foreach($provinceList as $p)
                            {
                              echo "<option value='".$p->id."'>".$p->name."</option>";
                            }?>
                          </select>
                          <select class="form-control" style="margin-top: 5px;width: 100%;" id="searchlocation_city" name="searchlocation_city" ng-model="city" required>
                            <option value="" selected disabled>Select City</option>
                            <option>All</option>
                          </select>

                         <button  style="width:100%;margin-top: 5px;"  ng-click="searchJob_location()">Search</button>
                        </div>
                      </form>

                      </td>
                    </tr>
                    <tr>
                      <td>
                        <n class="text-info"><a style="cursor:pointer;" onclick="collapse('search_specialization');">Search By Specialization
                        <span class="pull-right"><i class="glyphicon glyphicon-chevron-right"></i></span></a></n>
                        <form class="form-inline">
                        <div id="search_specialization" style="display: none;">
                            <select class="form-control" style="margin-top: 5px;width: 100%;" name="searchspecialization" id="searchspecialization" ng-model="specialization" required>
                            <option value="" selected disabled>Select Specialization</option>
                            <option>All</option>
                            <?php
                                    foreach ($job_specList as $job_specs){
                                    echo "<option value='".$job_specs->param_id."'>".$job_specs->cValue."</option><br>";
                                    }
                                  ?>
                          </select>

                          <button  style="width:100%;margin-top: 5px;"  ng-click="searchJob_specialization()">Search</button>
                        </div>
                      </form>

                      </td>
                    </tr>
                    <tr>
                      <td>
                        <n class="text-info"><a style="cursor:pointer;" onclick="collapse('search_salary');">Search By Salary Range
                        <span class="pull-right"><i class="glyphicon glyphicon-chevron-right"></i></span></a></n>
                        <form class="form-inline">
                        <div id="search_salary" style="display: none;">
                          <input type="text" class="form-control" placeholder="Search Criteria" id="searchsalary" name="searchsalary" style="margin-top: 10px;width: 100%;" ng-model="criteria" required>
                          <select class="form-control" style="margin-top: 5px;width: 100%;" id="searchsalary_category" name="searchsalary_category"  ng-model="category" required>
                              <option selected disabled>Select Category</option>
                              <option value="job_title">Job Title</option>
                              <option value="company_name">Company</option>
                              <option value="specialization">Specialization</option>
                          </select>
                          <input type="text" class="form-control" placeholder="Salary Range From" style="margin-top: 10px;width: 100%;" id="searchsalary_from" name="searchsalary_from"  ng-model="salaryfrom" required>
                          <input type="text" class="form-control" placeholder="Salary Range To" style="margin-top: 10px;width: 100%;" id="searchsalary_to" name="searchsalary_to" ng-model="salaryto">
                         <button  style="width:100%;margin-top: 5px;"  ng-click="searchJob_salary()">Search</button>
                        </div>
                      </form>
                      </td>
                    </tr>
                   
                 
                  </tbody>
                </table>
              </div>
             </div>

	</div>
</div>
</div>
</div>

<!-- This modal gives prompt messages to the applicant. Triggered when evaluate button is clicked. -->
<!-- Evaluate Modal -->
<div id="message-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Message</h4>
      </div>
      <div class="modal-body">

        <!-- Shown when the applicant did not answer all the question. -->
        <p ng-if="!complete && !accepted">You did not answer all the qualifying questions. Please review and then click the <b class="text-danger">evaluate</b> button.</p> 


        <!--  Shown when the form is complete but the applicant did not qualify -->
        <p ng-if="complete && !accepted">We appreciate your interest in <strong>{{jobDetails.company_name}}</strong> and the position for which you applied.<br>However, after evaluating your application, you did not qualify to be shortlisted for the position. <br><br>Please do apply again in the future should you see a job posting for which you qualify.</p>
        

        <p ng-if="complete && accepted"> <!-- Shown when the form is complete and the applicant is qualified. -->
        We appreciate your interest in <strong>{{jobDetails.company_name}}</strong> and the position for which you applied.<br>
        <strong>To proceed with the application,</strong> please click <b>"Apply"</b>. <h4>Thank you.</h4> 

        <!-- Apply Button -->
        <form name="apply_to_job" method="post" action="apply_to_job">

        <input type="hidden" name="job_id" value="{{selected_job.job_id}}">
        <input type="hidden" name="company_id" value="{{selected_job.company_id}}">
        <!-- <input type="hidden" name="jobs_per_company_id" value=""> -->
        <button type="submit" ng-show="complete && accepted" class="btn btn-success btn-block btn-md"> <i class="fa fa-arrow-circle-right "></i> Apply </button>
        </form>
        </p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal" ng-click="validate()">Okay</button>
      </div>
    </div>

  </div>
</div>
<!-- End. Evaluate Modal -->


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
<!-- ALREADY APPLIED PANEL -->
<div ng-if="results != 0 && results != -1" >
<h3>Application Details</h3>
<div class="panel panel-default">
<div class="box box-widget widget-user-2 item bg-yellow" >
        <div class="widget-user-header">
          <div class="widget-user-image">
            <img class="img-circle" src="<?php echo base_url() . 'public/company_logo/' ?>{{app.logo}}" alt="company">
          </div>
          <h3 class="widget-user-username">{{app.job_title}}</h3>
          <h5 class="widget-user-desc">{{app.company_name}}</h5>
        </div>
        <div class="box-footer no-padding">
          <ul class="nav nav-stacked">
            <li><a href="#">Date Applied <span class="pull-right">{{app.date_applied | date: "mediumDate"}}</span></a></li>
            <li>
              <a href="#" ng-if="app.application_status == 1" data-target="#interview-modal" data-toggle="modal" ng-click="changeApplication(app)">Status <span class="pull-right">{{app.status_title}}</span></a>
              <a href="#" ng-if="app.application_status == 4" data-target="#blocked-modal" data-toggle="modal"  ng-click="changeApplication(app)">Status <span class="pull-right">{{app.status_title}}</span></a>
              <a ng-if="app.application_status != 1 && app.application_status != 4">Status <span class="pull-right">{{app.status_title}}</span></a>
            </li>
            <li><a href="#">Resume Status <span class="pull-right label bg-olive"  ng-show="app.is_read == 1">Viewed</span></a></li>
          </ul>
        </div>
      </div>
</div>
</div>
<!-- End ALREADY APPLIED PANEL -->

<div ng-if="results == 0">
<h3>Qualifying Questions</h3>
  <div class="panel panel-default">
  <div class="panel-body">
      <div> <!-- //Qualifying Question Div. -->
        <div class="callout callout-success" ng-show="loaded && questionList.length == 0">
         <h4><i class="icon fa fa-hand-o-right"></i> No qualifying questions set.</h4>
         <p>To proceed with the application, click the <strong>apply</strong> button.</p>

      <!-- Apply Button -->
        <form name="apply_to_job" method="post" action="apply_to_job">

        <input type="hidden" name="job_id" value="{{selected_job.job_id}}">
        <input type="hidden" name="company_id" value="{{selected_job.company_id}}">
        <!-- <input type="hidden" name="jobs_per_company_id" value=""> -->
        <button type="submit" ng-show="questionList.length == 0" class="btn btn-success btn-block btn-md"> <i class="fa fa-arrow-circle-right "></i> Apply </button>
        </form>
        </div>

        <table class="table table-responsive table-hover" ng-show="loaded && questionList.length > 0">
            <thead>
                <tr>
                    <th></th>
                    <th>Question</th>
                    <th><center>Answer</center></th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="question in questionList">
                    <td>{{$index + 1}}.</td>
                    <td>{{question.question}}</td>
                    <td> <label class="radio-inline"><input type="radio" ng-click="evaluate()" ng-model="result[question.id]" name="question-{{question.id}}" value="1">Yes</label></td>
                    <td> <label class="radio-inline"><input ng-click="evaluate()" type="radio" ng-model="result[question.id]"  name="question-{{question.id}}" value="0">No</label></td>
                </tr>
            </tbody>
        </table>
        <!-- Evaluate Button -->
        <button ng-hide="show_apply || questionList.length == 0" class="btn btn-default btn-block btn-md" ng-click="evaluate()" data-target="#message-modal" data-toggle="modal"  data-dismiss="modal"> <i class="fa fa-arrow-circle-right "></i> Evaluate</button>

       </div> <!-- End. Qualifying Question Div -->
  </div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
</body>

<!-- Angular Js Script -->
<script>
function get_city_list(val,cityid)
{
  if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
            document.getElementById(cityid).innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>login/get_city_list/"+val,false);
      xmlhttp2.send();
}

function isNumberKey(txt, evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode == 46) {
            //Check if the text already contains the . character
  if (txt.value.indexOf('.') === -1) {
      return true;
    } else {
      return false;
    }
  } else {
  if (charCode > 31
      && (charCode < 48 || charCode > 57))
      return false;
  }
   return true;
}

function collapse(id)
{
  var x = document.getElementById(id);
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    } 
}
  

var appl = angular.module('jobApp', []);

appl.controller('appCtrl', ['$scope', '$http', '$location', '$window', function($scope, $http, $location, $window) {

	$scope.selected_status = '';
	$scope.results = -1;
  $scope.field = '';
	$scope.selectedApplication = '';

	$scope.loaded = false;
	$scope.accepted = false;
	$scope.message = {};
	$scope.result = {};
	$scope.complete = true;
  $scope.selected_job = '';
	$scope.getVacancies = function()
	{
	     $http.post('get_vacancies').success(function(data)
	     {
	      $scope.vacancies = data;
	     });
	}

$scope.searchJob = function($key, $field,$province)
{
  $http.post('search_job/' + $scope.key + '/' + $scope.field + '/' + $scope.province).success(function(data)
   {
    $scope.vacancies = data;
   });
}

$scope.searchJob_location = function($criteria, $category,$province,$city)
{
  $http.post('search_job_location/' + $scope.criteria + '/' + $scope.category + '/' + $scope.province+ '/' + $scope.city).success(function(data)
   {
    $scope.vacancies = data;
   });
}

$scope.searchJob_specialization = function($specialization)
{
  $http.post('search_job_specialization/' + $scope.specialization).success(function(data)
   {
    $scope.vacancies = data;
   });
}

$scope.searchJob_salary = function($criteria, $category,$salaryfrom,$salaryto)
{
  $http.post('search_job_salary/' + $scope.criteria + '/' + $scope.category + '/' + $scope.salaryfrom+ '/' + $scope.salaryto).success(function(data)
   {
    $scope.vacancies = data;
   });
}

$scope.searchJob_main = function($criteria, $category,$province,$city,$specialization,$rangefrom,$rangeto)
{
  $http.post('search_job/' + $scope.criteria + '/' + $scope.category + '/' + $scope.province+ '/' + $scope.city+ '/' + $scope.specialization+ '/' + $scope.rangefrom+ '/' + $scope.rangeto).success(function(data)
   {
    $scope.vacancies = data;
   });
}

$scope.getInterviewRequests = function()
{
   $http.post('get_interview_requests').success(function(data)
   {
    $scope.requestList = data;
   });
}

	$scope.evaluateVacancy = function(vacancy)
	{

    $scope.selected_job = vacancy;
		$http.get('getApplication/' + vacancy.id).then(function(data)
     	{
        	$scope.results = data.data;
     	})
    	 .finally(function() {
	      if ($scope.results == 0){
	      	 $scope.getQualifyingQuestions(vacancy.job_id);
	      }
	      else
	      {
	       	 $scope.getApplication($scope.results.id);
	      }
    	});
	}

	$scope.getQualifyingQuestions = function(job_id)
    {
    	$http.post('get_qualifying_questions/'+job_id).success(function(data){
        $scope.questionList = data;
        });

        $scope.loaded = true;
    }

    $scope.getApplication = function(record_id)
    {
    	$http.post('get_app_details/'+record_id).success(function(data){
        $scope.app = data;
        });
    }

    $scope.evaluate = function()
    {
    	$scope.complete = true;
    	$scope.show_apply = false
    	var array = [];

		angular.forEach($scope.result, function(element) {
  			array.push(element);
		});

    	if (array.length != $scope.questionList.length)
    	{
            $scope.complete = false;
    	}

    	else
    	{

            for (var i = 0; i < $scope.questionList.length; i++)
            {
                if (array[i] != $scope.questionList[i].correct_ans)
                {
                	$scope.accepted = false;
                    break;
                }
                else 
                {
                    $scope.accepted = true;
                }
            }
    	}
    }

    $scope.validate = function()
    {
    	if ($scope.complete && $scope.accepted) //If the form is complete and the applicant is qualified
    	{
			$scope.show_apply = true;
    	}

        if ($scope.complete && !$scope.accepted) //If the form is complete and the applicant is not qualified, redirect to LOGIN. Hahaa
        {

        }
    }
}]);

$("#app_button").on("click", function() {
    $("body").scrollTop(0);
});

</script>