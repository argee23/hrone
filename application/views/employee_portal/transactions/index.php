<br><br><br>
<div id="app" ng-app="myApp" ng-controller="appCtrl" ng-init='getTransactionList()' ngcloak>
<div class="col-sm-4">
      <div class="box box-solid box-success">
        <div class="box-header">
        <h4 class="box-title">Transactions</h4>
        <span class="pull-right"><div class="box-tools"><input class="form-control input-sm" placeholder="Search a Transaction Here" ng-model="query" type="text"></div></span></div>
        <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark"">
          <ul class="nav nav-pills nav-stacked">
                <li class="my_hover" ng-repeat="tr in transactionList | filter: query"><a data-toggle="tab" href="#{{tr.t_table_name}}">
                {{tr.form_name}}</a>
                </li>
          </ul>
        </div>
      </div>
</div>  

<div class="col-sm-7">
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

<div ng-view>
</div>
</div>


</div>

<script>
var app = angular.module('myApp', ['ngRoute']);

app.config(function($routeProvider) {
    $routeProvider
    .when("/:name*", {
        templateUrl : function (urlattr)
        {
            return 'redirect_to/' + urlattr.name;
        }
    })
    
});


app.controller('appCtrl', ['$scope', '$http', '$location', '$window', function($scope, $http, $location, $window) {

$scope.schedules = [];
$scope.leave_days = [];
$scope.date_info = "";

  $scope.getTransactionList = function()
  {
  $http.post('<?php echo base_url();?>employee_portal/employee_transactions/get_active_transactions' ).success(function(data)
  {
    $scope.transactionList = data;
  });
  }

 

  $scope.getRestDays = function(pp)
  {
      $http.post('<?php echo base_url();?>employee_portal/employee_transactions/getRestDays/' + pp).success(function(data)
      {
        $scope.restDays = data;
      });
  }

  $scope.get_schedules = function(start, end,leave , id)
  {
      $http.post('<?php echo base_url();?>employee_portal/employee_transactions/get_schedules/' + start + '/' + end + '/' + leave + '/' + id).success(function(data)
      {
        $scope.schedules = data;
      });
  }

  $scope.get_attendance = function(date)
  {
      $http.post('<?php echo base_url();?>employee_portal/employee_transactions/get_day_details/' + date).success(function(data)
      {
        $scope.date_info = data;


      });
  }

  $scope.get_late_filing = function(start,end,id)
  {
      $http.post('<?php echo base_url();?>employee_portal/employee_transactions/check_late_filing/' + start +'/'+ end +'/'+ id).success(function(data)
      {
        $scope.date_infos = data;


      });
  }

  $scope.check_whole_day_leave = function(date)
  {
      $http.post('<?php echo base_url();?>employee_portal/employee_transactions/checker_wholeday_leave/' + date).success(function(data)
      {
        $scope.date_infos = data;

      });
  }

  $scope.get_day_details = function($date)
  {
      $http.post('<?php echo base_url();?>employee_portal/employee_transactions/get_day_details/' + date).success(function(data)
      {
        $scope.details = data;
      });
  }

  $scope.detect = function()
  {
    $scope.f = "";
    $http.post('<?php echo base_url();?>employee_portal/employee_transactions/check_numeric/' + $scope.hours + "/" + $scope.date_info.excess).success(function(data)
    {
      $scope.f = data;
    });
  }



  $scope.clear = function()
  {
    $scope.schedules = [];
  }
}]);
</script>