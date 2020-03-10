<br>
<title>Job Applications</title>

<style>
.item:hover {
	/*background-color: #D7EFF7;*/
	background-color: #D7E0F5;
}
</style>

<?php require_once(APPPATH.'views/app/application_form/insert_datetime_picker.php');?>

<body ng-app="jobApp" ng-controller="appCtrl" ng-init="getApplications()" class="content-body">
<!-- STATUS FILTERS -->
<div class="page-header">
 <center>
	<div class="btn-group">
		<button type="button" class="btn btn-default btn-lg" ng-click="selected_status = ''">All</button>
           <?php foreach ($statusList as $stat) { ?>
               <button type="button" class="btn btn-default btn-lg" ng-click="selected_status = '<?php echo $stat->app_stat_id; ?>'" style="color: <?php echo $stat->color_code; ?>"><?php echo ucwords($stat->status_title); ?>
               </button>
           <?php
            } ?>
    </div>
 </center>
</div>
<!-- END FILTERS -->
<hr>

<!-- APPLICATIONS VIEW -->
<div ng-repeat="app in applications">
<span class="col-sm-4" ng-show="selected_status == '' || selected_status == app.application_status">
	<div class="box box-widget widget-user-2 item" >
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
              <a href="#" ng-if="app.application_status == 1" data-target="#interview-modal" data-toggle="modal"  ng-click="changeApplication(app)">Status <span class="pull-right">{{app.status_title}}</span></a>
            	<a href="#" ng-if="app.application_status == 4" data-target="#blocked-modal" data-toggle="modal"  ng-click="changeApplication(app)">Status <span class="pull-right">{{app.status_title}}</span></a>
            	<a ng-if="app.application_status != 1 && app.application_status != 4">Status <span class="pull-right">{{app.status_title}}</span></a>
            </li>
            <li><a href="#">Resume Status <span class="pull-right label bg-olive"  ng-show="app.is_read == 1">Viewed</span></a></li>
          </ul>
        </div>
      </div>
</span>
</div>
<!-- END APPLICATIONS VIEW -->

</body>


<!-- Interview Modal -->
<div id="interview-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Interview Invitation</h4>
      </div>
      <div class="modal-body">

        <div class="panel panel-default" style="background-color:  #D7EFF7">
          <br>
  		  <dl class="dl-horizontal">
            <dt>Company Name</dt>
            <dd>{{selectedApplication.company_name}}</dd>
            <dt>Interview Date</dt>
            <dd>{{selectedApplication.interview_date | date: "longDate"}}</dd>
            <dt>Interview Time</dt>
            <dd>{{selectedApplication.interview_time}}</dd>
            <dd><small><i>*time is in 24-hour format.</i></small></dd>
          </dl>

            <blockquote ng-show="selectedApplication.invite_message != null">
                <p>{{selectedApplication.invite_message}}</p>
                <small>A message from <cite title="{{selectedApplication.company_name}}">{{selectedApplication.company_name}}</cite></small>
              </blockquote>
         </div>
         <div ng-show="selectedApplication.interview_response == null">
      	 <strong>Respond to this Invitation:</strong><br><br>
      	 <center>
      	   <form name="respond" method="post" action="respond_interview" class="form-horizontal">

      	   <input type="hidden" name="aj_application_id" value="{{selectedApplication.application_id}}">
      	   <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Response</label>
                     <div class="col-sm-9">
                  <select ng-model="response" name="response" class="form-control" required>
                    <option value="accept">Accept</option>
                    <option value="decline">Decline</option>
                    <option value="reschedule">Reschedule</option>
                  </select>
                  </div>
                  </div>

	      	 <div ng-show="response =='reschedule'">
 				     <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">New Date</label>
                  <div class="col-sm-9">
                    <input type="text" id="resched_date" name="resched_date" class="form-control floating-label" placeholder="New Date" required>
                  </div>
                </div>

              	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">New Time</label>
                  <div class="col-sm-9">
                    <input type="text" id="resched_time" name="resched_time" class="form-control floating-label" placeholder="New Time">
                  </div>
                </div>

               	<div class="form-group">
				          <label class="control-label col-sm-3" for="email">Reason</label>
            				<div class="col-sm-9">
            				<textarea class="form-control" rows="2" name="resched_reason" id="comment" required></textarea>
            				</div>
				        </div>
	      	 </div>

	      	 <br>
			 <center><button type="submit" class="btn btn-success btn-block" ng-disabled="respond.response.$invalid">Submit Response</button></center>
	       </form>
      	 </center>
         </div>

         <div ng-if="selectedApplication.interview_response == 'accept'">
         <center><h3>You have accepted this invitation.</h3></center>
         </div>

         <div ng-if="selectedApplication.interview_response == 'decline'">
         <center><h3>You have declined this invitation</h3></center>
         </div>


         <div ng-if="selectedApplication.interview_response == 'reschedule'">
         <h3><center>You have requested to move this invitation to:<br>{{selectedApplication.resched_date | date: "longDate"}} at {{selectedApplication.resched_time}}.</center></h3>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div> <!-- Interview Modal -->

<!-- Blocked Modal -->
<div id="blocked-modal" class="modal fade" role="dialog">
<div class="modal-danger">
  <div class="modal-dialog">

<div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Blocked</h4>
              </div>
              <div class="modal-body">
                <p>You have been blocked by {{selectedApplication.company_name}} <span ng-show="selectedApplication.blocked_reason != null">due to {{selectedApplication.blocked_reason}}</span></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
              </div>
            </div>
            </div>
            </div>
            </div>

<!-- End Blocked Modal -->
<script>


</script>
<script type="text/javascript">
    $(document).ready(function()
    {
      
      $('#resched_time').bootstrapMaterialDatePicker
      ({
        date: false,
        shortTime: true,
        format: 'HH:mm'
      });


      $('#resched_date').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', minDate : new Date(), time: false });

      $.material.init()
    });
    </script>


<!-- Angular Js Script -->
<script>
var app = angular.module('jobApp', []);

app.controller('appCtrl', ['$scope', '$http', '$location', '$window', function($scope, $http, $location, $window) {

	$scope.selected_status = '';
	$scope.selectedApplication = '';
	$scope.getApplications = function()
	{
	     $http.post('get_applications').success(function(data)
	     {
	      $scope.applications = data;
	     });
	}

	$scope.changeApplication = function(app)
	{
		$scope.selectedApplication = app;
	}
}]);

</script>