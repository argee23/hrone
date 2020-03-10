<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Job Vacancies</title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/spinner.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/zebra_dp/theme.css" />

    <!-- Inseparable -->
    <script type="text/javascript" src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/daterangepicker/moment.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url()?>public/angular.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/angular-route.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/signup_controller.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/zebra_dp/zebra_datepicker.js"></script>

    <style>
    .info-box:hover {
        background-color: #D7EFF7;
    }
    </style>

    <!-- Header File -->
    <?php require_once(APPPATH.'views/include/header_application.php');?>
  </head>
  <br>
    <body class="signup-bg fixed sidebar-mini" ng-app="myApp" ng-controller="appCtrl" ng-cloak>
      <div class="col-sm-3"> <!-- Job Vacancy/Positions List: Start -->

      <?php if (count($jobList) == 0)
      { ?>
        <h2>Search found 0 results.</h2>
       <?php } else { 
        ?>
        <span ng-init="selected_job = '<?php echo $jobList[0]->id; ?>'"></span>
        <table id="employee_data" class="table table-condensed" style="background-color: #fff">
            <thead>
              <tr class="bg-gray">
                <th>Search Results</th>
              </tr>
            </thead>
            <tbody>
        <?php foreach($jobList as $job) { ?>
        <tr class="info-box">
          <td>
            <span class="info-box-icon"><center><img src="<?php echo base_url() . 'public/company_logo/' . $job->logo;?>" class="media-object" style="width: 100%"></center></span>
              <div class="info-box-content">
                <span class="info-box-text"><?php echo $job->company_name; ?></span>
                <span class="info-box-number text-info"><small><a href="#" ng-click="selected_job = '<?php echo $job->id; ?>
              '; getJobDetails()"><?php echo $job->job_title; ?></a></small></span>
               <span class="progress-description">
                  <small><i class="fa fa-usd"> <?php echo $job->salary; ?></i></small><br>
                  <small>Posted on: <i><?php echo date("F d, Y", strtotime($job->date_posted)); ?></i></small>
              </span>
              </div>
          </td>
        </tr>
        <?php
        } }?>
          </tbody>
        </table>
      </div> <!-- Job Vacancy/Positions List: End -->

      <!-- Job Details -->
      <div class="col-sm-5" ng-hide="apply">
       <!-- Shown when there is no selected job. -->
        <div class="callout callout-warning" ng-show="selected_job == 0">
          <h4><i class="icon fa fa-warning"></i> No Job Selected</h4>
          <p>Select a job to view its details.</p>
        </div>

        <!-- Hidden when there is no selected Job -->
        <div id="job-details" ng-hide="selected_job == 0" ng-init="getJobDetails()">
        <div class="panel panel-default">
         <div class="panel-body">
          <h2 class="text-center">{{jobDetails.job_title}}</h2>
          <h4 class="text-center text-info"><strong>{{jobDetails.company_name}}</strong></h4>
          <center><p><small><i class="fa fa-tag"></i> {{jobDetails.specialization}}</small></p></center>
          <div class="col-lg-6">
            <span class="text-right">
              <h3>About the Company</h3><br>
                <h4></h4>
                <div class="media">
                  <div class="media-left media-top">
                    <img src="<?php echo base_url() . 'public/company_logo/'?>{{jobDetails.logo}}" class="media-object" style="width:80px">
                  </div>
                  <div class="media-body">
                    <h4 class="media-heading">{{jobDetails.company_name}} </h4>
                    <p>{{jobDetails.company_address}}</p>
                  </div>
                </div>
            </span>
          </div>

          <div class="col-lg-6">
          <h3>Job Details</h3>
            <h4>Job Description <span class="pull-right"><i class="fa fa-2x fa-list"></i></span></h4>
            <p>{{jobDetails.job_description}}</p>
            <br>
            <h4>Job Qualification <span class="pull-right"><i class="fa fa-2x fa-check-square-o"></i></span></h4>
            <p>{{jobDetails.job_qualification}}</p>
            <br>
            <h4>Salary <span class="pull-right"><i class="fa fa-2x fa-rub"></i></span></h4>
            <p>{{jobDetails.salary}}</p>
            <br>
            <h4>Hiring <span class="pull-right"><i class="fa fa-2x fa-calendar"></i></span></h4>
            <p>Hiring will start on <strong>{{jobDetails.hiring_start | date: "longDate"}}</strong> and will end on <strong>{{jobDetails.hiring_end | date: "longDate"}}</strong></p>
          </div>
          <br /><br />

          <button type="button" class="btn btn-info btn-flat btn-block" ng-click="getQualifyingQuestions()"><b>APPLY NOW</b></button>

        </div>
        </div>
        </div>
    </div> <!-- End Job Details View -->

    <div class="col-sm-4" ng-cloak ng-show="loaded && !apply">
      <div class="box box-primary" style="min-height: 500px">
        <div class="box-header"><h3 class="box-title">Job Qualifying Questions</h3></div>
          <div class="panel-body">
              <div> <!-- //Qualifying Question Div. -->
                <div class="callout callout-success" ng-show="loaded && questionList.length == 0">
                 <h4><i class="icon fa fa-hand-o-right"></i> No qualifying questions set.</h4>
                 <p>To proceed with the application, click the <strong>apply</strong> button.</p>
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
                <button ng-hide="show_apply || questionList.length == 0" class="btn btn-default btn-block btn-md" ng-click="evaluate()" data-target="#message-modal" data-toggle="modal"> <i class="fa fa-arrow-circle-right "></i> Evaluate</button>

                <!-- Apply Button -->
                <button ng-show="show_apply || questionList.length == 0" type="button" data-toggle="modal" data-target="#confirm-modal" class="btn btn-success btn-block btn-md"> <i class="fa fa-arrow-circle-right "></i> Apply </button>
               </div> <!-- End. Qualifying Question Div -->
          </div> 
      </div>
    </div>

      <!-- This div contains the Basic Details form of an employee.
        Only shown when apply button is clicked and an applicant is qualified for the job. -->
        <div ng-show="apply" class="col-sm-9">
        <div class="panel box box-success"  ng-show="choose == 0">
          <div class="panel-heading"><h4>Sign In</h4></div>
            <div class="panel-body">
              <center>
                <div class="register-box">
                  <div class="register-logo">
                    <a href="#"><b>Sign-in</b> Options</a>
                  </div>
                    <div class="register-box-body">
                      <div class="social-auth-links text-center">
                        <a ng-click="choose = 1" href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-edit"></i><strong>Create an account</strong></a>
                      </div>
                      <a ng-click="choose=2" href="#" class="btn btn-block btn-social btn-primary btn-flat"><i class="fa fa-sign-in"></i><i>I already have an account</i></a>
                    </div>
                    <!-- /.form-box -->
                  </div>
                  <!-- /.register-box -->
              </center>
            </div>
        </div>

        <div class="panel box box-success" ng-show="choose == 1">
              <div class="panel-heading" ><h4>Basic Details</h4></div>
              <div class="panel-body">
                   <!-- Show this form only when the applicant has passed the qualifying question stage -->
                      <form name="apply_form" method="post" action="add_applicant" onsubmit="return validateForm()">
                         <input type="hidden" name="company_id" id="company_id" value="{{jobDetails.company_id}}">
                         <input type="hidden" name="job_id" id="job_id" value="{{jobDetails.job_id}}">
                                <label>Please fill up the required information to continue.</label>
                                <small>Fields with <span class="text-danger">red markup</span> are required fields.</small>
                                <div class="col-lg-12">                
                                  <div class="col-lg-6">
                                  <div class="form-group" >
                                  <label>Title: </label>
                                  <select class="form-control" id="title" name="title" ng-model="title">
                                    <option selected="selected" disabled="disabled" value="0" >Select a a title</option>
                                    <option ng-repeat="title in dataList.titles" value="{{title.param_id}}">{{title.cValue}}</option>
                                  </select>
                                 </div> 
                                   <div class="form-group has-feedback" ng-class="{'has-error' : apply_form.first_name.$invalid}">
                                      <label>First Name: <small ng-show="apply_form.first_name.$invalid"><i>Required</i></small></label>
                                      <input type="text" class="form-control" id="first_name" name="first_name" ng-model="first_name" ng-value="first_name"  required >
                                   </div>
                                   <div class="form-group">
                                    <label>Middle Name: </label>
                                    <input type="text" class="form-control" id="middle_name" name="middle_name" ng-model="middle_name" ng-value="middle_name">
                                    </div>
                                    <div class="form-group has-feedback" ng-class="{'has-error' : apply_form.last_name.$invalid}">
                                    <label>Last name: <small ng-show="apply_form.last_name.$invalid"><i>Required</i></small></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" ng-model="last_name" ng-value="last_name"  required >
                                    </div>
                                    <div class="form-group">
                                    <label>Nickname: </label>
                                    <input type="text" class="form-control" id="nickname" name="nickname" ng-model="nickname" ng-value="nickname">
                                    </div>

                                    <div class="form-group"><br>
                                      <button type="submit" ng-disabled="apply_form.$invalid" class="btn btn-success btn-block">Apply</button>
                                    </div>
                                  </div>
                                   <div class="col-lg-6">
                                    <div class="form-group has-feedback" ng-class="{'has-error' : apply_form.gender.$invalid}">
                                    <label>Gender: <small ng-show="apply_form.gender.$invalid"><i>Required</i></small></label>
                                      <select class="form-control" id="gender" name="gender" ng-model="gender" required>
                                        <option ng-repeat="gend in dataList.genders" value="{{gend.gender_id}}">{{gend.gender_name}}</option>
                                      </select>
                                    </div>
                                   <div class="form-group has-feedback" ng-class="{'has-error' : apply_form.civil_status.$invalid}">
                                    <label>Civil Status: <small ng-show="apply_form.civil_status.$invalid"><i>Required</i></small></label>
                                      <select class="form-control" id="civil_status" name="civil_status" ng-model="civil_status" required>
                                        <option ng-repeat="civilstatus in dataList.civilstatuses" value="{{civilstatus.civil_status_id}}">{{civilstatus.civil_status}}</option>
                                      </select>
                                    </div>

                                    <div class="form-group has-feedback" ng-class="{'has-error' : apply_form.email_add.$invalid}">
                                    <label>Email Address: <small ng-show="apply_form.email_add.$invalid"><i>Please provide a valid email address.</i></small></label>
                                      <input id="email_add" placeholder="sample@email.com" type="email" class="form-control" name="email_add" ng-model="email_add">
                                    </div>
                                  <div class="form-group has-feedback" ng-class="{'has-error' : apply_form.password.$invalid}">
                                    <label>Desired Password: <small ng-show="apply_form.password.$invalid"><i>Minimum of 8 Characters</i></small></label>
                                      <input type="text" class="form-control" id="password" name="password" ng-model="password" ng-value="password" required minlength="8">
                                    </div>

                                    <div class="form-group has-feedback">
                                    <label class="text-danger">Birthday <small ng-show="apply_form.birthday.$invalid" ng-class="{'has-error' : apply_form.birthday.$invalid}"><i>Required</i></small></label><br>
                                      <input type="text" id="birthday" name="birthday" ng-model="birthday" ng-value="birthday">
                                    </div>
                                   </div>

                                </div>

                      </form>
                   </div>
                   </div>

                    <div class="panel box box-success" ng-show="choose == 2">
                      <div class="panel-heading" ><h4>Sign in</h4></div>
                          <div class="panel-body">
                          <p>Please sign-in into your account.</p>
                          <a href="<?php echo base_url()?>/login">Click here to login.</a>
                          </div>
                      </div>
                    </div>
                    </div>
        <!-- End. Basic info div -->
    </body>


<!-- This modal gives prompt messages to the applicant. Triggered when evaluate button is clicked. -->
<!-- Evaluate Modal -->
<div id="message-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{jobDetails.company_name}}</h4>
      </div>
      <div class="modal-body">

        <!-- Shown when the applicant did not answer all the question. -->
        <p ng-if="!complete && !accepted">You did not answer all the qualifying questions. Please review and then click the <b class="text-danger">evaluate</b> button.</p> 


        <!--  Shown when the form is complete but the applicant did not qualify -->
        <p ng-if="complete && !accepted">We appreciate your interest in <strong>{{jobDetails.company_name}}</strong> and the position for which you applied.<br>However, after evaluating your application, you did not qualify to be shortlisted for the position. <br><br>Please do apply again in the future should you see a job posting for which you qualify.</p>
        

        <p ng-if="complete && accepted"> <!-- Shown when the form is complete and the applicant is qualified. -->
        We appreciate your interest in <strong>{{jobDetails.company_name}}</strong> and the position for which you applied.<br>
        <strong>To proceed with the application,</strong> please click <b>"Apply"</b> button and fill in your personal details. <h4>Thank you.</h4> 
        </p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal" ng-click="validate()">Okay</button>
      </div>
    </div>

  </div>
</div>
<!-- End. Evaluate Modal -->


<!--  Modal that confirms if the applicant really wishes to apply for the job.
Only shown when the applicant is qualified for the job.
When yes button is clicked, the job list panel is disabled.
Triggered when apply button is clicked -->
<!-- Apply Modal -->
<div id="confirm-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Apply for a Job</h4>
      </div>
      <div class="modal-body"><center>
        <h4>Are you sure you want to apply for this job?</h4>
        <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="apply=true; loadInitialData()">Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- End Apply Modal -->

<script>
 var startdate = moment();
 startdate = startdate.subtract(15, "year").format('YYYY-MM-DD'); //do not allow applicant under 15

 var enddate = moment();
 enddate = enddate.subtract(80, "year").format('YYYY-MM-DD'); //do not allow applicant greater than 80.

$('#birthday').Zebra_DatePicker({
direction: [enddate, startdate],
view: 'years'
});

// Function that checks if the birthday field is specified.
function validateForm() {
    var x = document.forms["apply_form"]["birthday"].value;
    if (x == "") {
        alert("Please specify your birthday!");
        return false;
    }
}
</script>

    <script>
      $(function () {
        $('#employee_data').DataTable({
          "pageLength": 5,
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": false,
          // "pagingType":"simple",
          "info": false,
          "autoWidth": false,
          "bProcessing": true,
          "dom": 'lrtip'
        });
            $('#employee_data').on( 'page.dt', function () {
      $('html, body').animate({
          scrollTop: 0
      }, 300);
        } );
      });
    </script>



<!-- DataTables -->
<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>