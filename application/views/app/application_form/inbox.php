<br>
<title>Company Messages</title>
<body class="content-body" ng-app="jobApp" ng-controller="appCtrl" ng-init="getCompanyMessages()">

<div class="container-fluid">

<h3 data-toggle="tooltip" title="Companies who sent you messages">Inbox</h3>
<hr>
<div class="col-sm-7">
<div class="box box-primary">
<div class="box-header with-border">
              <h3 class="box-title">Inbox</h3>

              <div class="box-tools pull-right">
                <div class="has-feedback">
                  <input class="form-control input-sm" placeholder="Search Mail" type="text">
                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <!-- /.btn-group -->
                <button type="button" ng-click="getCompanyMessages();" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Refresh</button>
                <div class="pull-right">
                  <span class="badge label-success">{{mcList.length}}</span>
                </div>
                <!-- /.pull-right -->
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                  <tr ng-repeat="mc in mcList">
                    <td></td>
                    <td class="mailbox-star"><i class="fa fa-envelope"></i></td>
                    <td class="mailbox-subject"><b><a href="#" ng-click="getMessageList(mc); updateToViewed(mc.company_id);">{{mc.company_name}}</a></b>
                    </td>
                    <td>{{mc.company_address}}</td>
                    <td class="mailbox-date">{{mc.message_sent}}</td>
                  </tr>
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            </div>
</div>
<div class="col-sm-5">
<div class="box box-solid box-primary direct-chat direct-chat-primary" ng-show="selected_company != ''">
  <div class="box-header with-border">
    <h3 class="box-title">{{selected_company.company_name}}</h3>
    <div class="box-tools pull-right">
      <span data-toggle="tooltip" title="{{msgList.length}} New Messages" class="badge bg-red">{{msgList.length}}</span>
      <button class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <!-- Conversations are loaded here -->
    <div class="direct-chat-messages"  style="min-height: : 1000px">
      <!-- Message. Default to the left -->
      <span ng-repeat="m in msgList">
      <div class="direct-chat-msg" ng-if="m.specific_sender == 1">
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name pull-left">{{m.company_name}}</span>
          <span class="direct-chat-timestamp pull-right">{{m.message_sent}}</span>
        </div>
        <!-- /.direct-chat-info -->
        <img class="direct-chat-img" src="<?php echo base_url() . 'public/company_logo/' ?>{{m.logo}}" alt="message user image">
        <!-- /.direct-chat-img -->
        <div class="direct-chat-text">
          {{m.message}}
        </div>
        <!-- /.direct-chat-text -->
      </div>

    <!-- Message to the right -->
      <div class="direct-chat-msg right" ng-if="m.specific_sender != 1">
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name pull-right"><?php echo $this->session->userdata('name_of_user'); ?></span>
          <span class="direct-chat-timestamp pull-left">{{m.message_sent}}</span>
        </div>
        <!-- /.direct-chat-info -->
        <img class="direct-chat-img" src="<?php echo base_url()?>public/applicant_files/employee_picture/<?php echo $this->session->userdata('picture'); ?>" alt="message user image">
        <!-- /.direct-chat-img -->
        <div class="direct-chat-text">
        {{m.message}}
        </div>
        <!-- /.direct-chat-text -->
      </div>
      </span>
      <!-- /.direct-chat-msg -->
      <!-- /.direct-chat-msg -->
    </div>
    <!--/.direct-chat-messages-->
  </div>
  <!-- /.box-body -->
  <div class="box-footer">
    <form name="reply" action="send_message" method="post">
      <div class="input-group">
        <input type="text" name="reply_content" id="reply_content" placeholder="Type Message ..." class="form-control" ng-model="reply_content" required>
        <input type="hidden" name="company_id" id="company_id" value="{{selected_company.company_id}}">
            <span class="input-group-btn">
              <button ng-disabled="reply.$invalid" type="submit" class="btn btn-primary btn-flat">Send</button>
            </span>
      </div>
    </form>
    </div>
  </div>
  <!-- /.box-footer-->
</div>
<!--/.direct-chat -->
</div>
</div>
</body>
            
<script>
var appl = angular.module('jobApp', []);

appl.controller('appCtrl', ['$scope', '$http', '$location', '$window', function($scope, $http, $location, $window) {

  $scope.selected_company = '';

    $scope.getCompanyMessages = function()
    {
      $http.post('get_company_messages').success(function(data){
          $scope.mcList = data;
        });
    }

    $scope.getMessageList = function(cr)
    {
      $scope.selected_company = cr;
      $http.post('get_messages/' + cr.company_id).success(function(data){
          $scope.msgList = data;
        });
    }

    $scope.updateToViewed = function(company_id)
    {
      $http.post('update_to_viewed/' + company_id + '/msg').success(function(data){
          $scope.response = data;
        });
    }
}]);

</script>
