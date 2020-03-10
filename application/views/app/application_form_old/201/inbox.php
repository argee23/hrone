<div class="container-fluid">

<!-- DIRECT CHAT PRIMARY -->
<title>My Inbox</title>
<div class="direct-chat direct-chat-primary fixed-panel">
  <div class="box-header with-border">
    <h3 class="box-title">My Inbox</h3>

    <div class="box-tools pull-right">
      <span><small>Send a message to the employer</small></span>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <!-- Conversations are loaded here -->
    <div class="direct-chat-messages">
      <!-- Message. Default to the left -->
      <div  class="direct-chat-msg" ng-repeat="msg in messages" ng-class="{'right' : msg.company_sender == null}">
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name" ng-class="{'pull-right' : msg.company_sender == null}"><span ng-show="msg.company_sender == null"><?php echo $this->session->userdata('name_of_user'); ?></span><span ng-show="msg.company_sender > 0">{{msg.company_name}}</span></span>
          <span class="direct-chat-timestamp" ng-class="{'pull-left': msg.company_sender == null}">{{msg.message_sent}}</span>
        </div>
        <!-- /.direct-chat-info -->
        <span ng-show="msg.company_sender == null">
          <img class="direct-chat-img" src="<?php echo base_url()?>public/applicant_files/employee_picture/<?php echo $this->session->userdata('picture'); ?>" alt="sender"><!-- /.direct-chat-img -->
        </span>
        <span ng-show="msg.company_sender > 0">
            <img class="direct-chat-img" src="<?php echo base_url()?>public/company_logo/{{msg.logo}} ?>" alt="sender">
            <!-- /.direct-chat-img -->
        </span>
        <div class="direct-chat-text">
         {{msg.message}}
        </div>
        <!-- /.direct-chat-text -->
      </div>
     
      <!-- /.direct-chat-msg -->
    </div>
      <!-- /.direct-chat-msg -->
    <!--/.direct-chat-messages-->


  </div>
  <!-- /.box-body -->
  <div class="box-footer">
    <form name="reply" action="send_message" method="post">
      <div class="input-group">
        <input type="text" name="reply_content" id="reply_content" placeholder="Type Message ..." class="form-control" ng-model="reply_content" required>
            <span class="input-group-btn">
              <button ng-disabled="reply.$invalid" type="submit" class="btn btn-primary btn-flat">Send</button>
            </span>
      </div>
    </form>
  </div>
  <!-- /.box-footer-->
</div>
<!--/.direct-chat -->