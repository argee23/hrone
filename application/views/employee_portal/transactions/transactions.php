<br><br><br>
<div ng-app="myApp" ng-controller="appCtrl" ng-init='getTransactionList()' ngcloak>
<div class="col-sm-3">
      <div class="box box-solid box-success">
        <div class="box-header">
        <h5 class="box-title">Transactions</h5>
        <span class="pull-right"><div class="box-tools"><input class="form-control input-sm" placeholder="Search a Transaction Here" ng-model="query" type="text"></div></span></div>
        <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark"">
          <ul class="nav nav-pills nav-stacked" >
                
                 <li class="my_hover">
                    <a data-toggle="tab" href="#filter_all_forms">All Forms</a>
                </li>
                <li class="my_hover" ng-repeat="tr in transactionList | filter: query">
                    <a data-toggle="tab" href="#{{tr.t_table_name}}">
                {{tr.form_name}}</a>
                </li>
          </ul>
        </div>
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
        </div>
<div ng-view>
</div>

</div>

<script>

var app = angular.module('myApp', ['ngRoute']);

app.config(function($routeProvider) {
    $routeProvider
    .when("/:name*", {
        templateUrl : function (urlattr)
        {
            return '<?php echo base_url();?>employee_portal/employee_transactions/fetch/' + urlattr.name;
        }
    })
});


app.controller('appCtrl', ['$scope', '$http', '$location', '$window', function($scope, $http, $location, $window) {

    $scope.getTransactionList = function()
    {
    $http.post('<?php echo base_url();?>employee_portal/employee_transactions/get_active_transactions' ).success(function(data)
    {
      $scope.transactionList = data;
    });
    }
}]);

</script>