<!-- Apply any bg-* class to to the info-box to color it -->
<br><br>
<script type="text/javascript" src="<?php echo base_url()?>public/dashboard_controller.js"></script>
<div ng-app="myApp" ng-controller="appCtrl">
<div class="content-body" style="background-color: #D7EFF7;">
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

<?php echo validation_errors();?> 
<div class="col-lg-3">
  <!-- Birthday Celebrants of the week -->

          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">News and Events</h3>

              <div class="box-tools pull-right">
              <i class="fa fa-newspaper-o fa-2x"></i>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table id="news_events" class="table table-bordered table-striped">
              <tbody class="products-list product-list-in-box">

              <?php if (count($events) > 0)
              { ?>


                             <?php foreach($events as $event) 
               { ?>
        <tr>
          <td>
                <a href="javascript:void(0)" class="product-title"><span class="text-info"><?php echo ucfirst($event->event_title); ?></span></a>
  
              <?php if($event->event_start && $event->event_end < date('Y-m-d H:i:s')) { 
                          echo "<span class='label bg-navy pull-right'>Completed</span>";
                        } 
                        else if ($event->event_start < date('Y-m-d H:i:s') && $event->event_end > date('Y-m-d H:i:s')){
                          echo "<span class='label bg-olive pull-right'>Ongoing</span>";
                        }
                        else{
                          echo "<span class='label label-warning pull-right'>Upcoming</span>";
                        } 
                        ?>
                  <!-- or view conversation -->
                    <span class="product-description">
                <small>Event Start: <strong><span class="text-maroon"><?php echo date("F j, Y, g:i a", strtotime($event->event_start)); ?></span></strong></small><br>
                <small>Event End: <strong><span class="text-info"><?php echo date("F j, Y, g:i a", strtotime($event->event_end)); ?></span></strong></small>

                <center><a href="#info_<?php echo $event->id; ?>" data-toggle="collapse"><span class="text-navy"><strong><small>View Description</small></strong></span></a></center>
                <span id="info_<?php echo $event->id; ?>" class="collapse">
                <small>
                <p class="text-black"><b>Description: </b> <?php echo $event->event_description; ?></p>
                </small>
                </span>
                    </span>
              </td>
        </tr>
               <?php
               }

              } else { ?>

                No events to display.

             <?php }   ?>

              </tbody>
            </table>
               </div><!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="javascript:void(0)" ng-click="getAllEvents()" class="btn btn-sm btn-default btn-flat pull-right">View All</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
</div>
<div class="col-lg-6">
<div class="panel panel-body" ng-show="messages.length > 0 " ng-cloak>
<div class="box-header with-border">
    <h3 class="box-title">Birthday Messages</h3>
    <div class="box-tools pull-right">
    <span class="label label-danger"><i class="fa fa-birthday-cake"></i></span>
    </div>
</div><br>
  <div class="col-lg-4">
  <ul class="nav nav-pills nav-stacked">
    <li ng-repeat="msg in messages"><a href="#" ng-click="loadMessage(msg)"><i class="fa fa-envelope"></i> {{msg.first_name + " " + msg.last_name}}</a></li>
  </ul>
  </div>
  <div class="col-lg-8">

    <div class="direct-chat-messages" ng-show="selected_message != null">
      <!-- Message. Default to the left -->
      <div  class="direct-chat-msg">
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name">
            <span ng-show="msg.company_sender == null">{{selected_message.first_name + " " + selected_message.last_name}}</span>
          </span>
          <span class="direct-chat-timestamp pull-right">{{selected_message.time_sent}}</span>
        </div>
        <h4 class="direct-chat-img"> <span class="label label-warning">{{selected_message.first_name.charAt(0)}}</span></h4>
        <div class="direct-chat-text">
         {{selected_message.message_content}}
        </div>
      </div>
       <div  class="direct-chat-msg right" ng-show="selected_message.receiver_reply != null">
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name pull-right">
            <span ng-show="msg.company_sender == null"><?php echo $this->session->userdata('name_of_user'); ?></span>
          </span>
          <span class="direct-chat-timestamp">{{selected_message.reply_sent}}</span>
        </div>
 <h4 class="direct-chat-img"> <span class="label label-success">You</span></h4>
        <div class="direct-chat-text">
         {{selected_message.receiver_reply}}
        </div>
        <!-- /.direct-chat-info -->
      </div>
      <div ng-show="selected_message.receiver_reply == null">
      <form action="send_reply" method="post" name="send_reply">
        <div class="input-group">
      <input type="hidden" name="message_id" id="message_id" value="{{selected_message.message_id}}">
        <input type="text" name="message" placeholder="Type your reply..." class="form-control" ng-model="reply" required>
            <span class="input-group-btn">
              <button type="submit" class="btn btn-warning btn-flat" ng-disabled="send_reply.$invalid">Send</button>
            </span>
      </div>
      </form>
       </div>
     
      <!-- /.direct-chat-msg -->
    </div>

  </div>
</div>

<div class="panel panel-body" ng-show="eventList != null" ng-cloak>
<div class="box-header with-border">
    <h3 class="box-title">News and Events</h3>
    <div class="box-tools pull-right">
    <span class="label label-default"><i class="fa fa-newspaper-o fa-2x"></i></span>
    </div>
</div><br>
<!-- <table id="events" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <tr ng-repeat="event in eventList">
  <td> -->
  <div class="box box-solid" ng-repeat="event in eventList">
    <div class="box-header with-border">
      <i class="fa fa-thumb-tack"></i>
      <h3 class="box-title">{{event.event_title}}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body clearfix">
    <strong>Description: </strong><br>
    {{event.event_description}}<br>
    <strong>From: </strong>{{event.event_start}}<br>
    <strong>To: </strong>{{event.event_end}}<br>
    </div>
    <!-- /.box-body -->
    </div>
<!--    </td>
  </tr>
  </tbody>

</table>
 -->

</div>
</div>
</div>

<div class="col-lg-3">  <!-- Birthday Celebrants of the week -->
  <div class="panel panel-body">
    <table id="employee_data" class="table table-bordered table-striped">
            <thead>
            <tr class="danger">
              <th>Birthday Celebrants of the Week <span class="pull-right"><i class="fa fa-birthday-cake"></i> </span></th>
            </tr>
            </thead>

            <tbody class="products-list product-list-in-box">
            <?php foreach($celebrants as $celeb)
            {
           if ($celeb->isApplicant == 0) 
         {
            $url = base_url() . "public/employee_files/employee_picture/";
         }
         else
         {
            $url = base_url() . "public/applicant_files/employee_picture/";
         } 
            ?>

            <?php if ($this->session->userdata('employee_id') == $celeb->employee_id)
            { ?>
      <tr>
        <td>
          <div class="product-img">
                <img src="<?php echo $url . $celeb->picture; ?>" alt="Product Image">
              </div>
              <div class="product-info">
              <a href="javascript:void(0)" class="product-title"><span class="text text-danger">HAPPY BIRTHDAY, <?php echo $celeb->first_name; ?>!</span></a>

              <button class="btn btn-danger btn-xs pull-right" ng-click="getBDMessages(<?php echo $celeb->employee_id; ?>)" data-toggle="modal" data-target="#view_bd_messages">View Birthday Messages</button>
                <!-- or view conversation -->
                  <span class="product-description">
                    <?php echo date("F d, Y", strtotime($celeb->birthday)); ?>
                  </span>
              </div>
            </td>
      </tr>
              <?php
            } else { ?>
            <tr>
        <td>
          <div class="product-img">
                <img src="<?php echo $url . $celeb->picture; ?>" alt="Product Image">
              </div>
              <div class="product-info">
              <a href="javascript:void(0)" class="product-title"><span class="text text-danger"><?php echo $celeb->first_name . " " . $celeb->last_name; ?></span></a>
                <!-- or view conversation -->

                <?php if ($celeb->message_id == '')
                { ?>
             <button class="btn btn-primary btn-xs pull-right" ng-click="receiver=<?php echo $celeb->employee_id; ?>" data-toggle="modal" data-target="#send-message">Send Message</button>
                <?php
                } else { ?>
             <button class="btn btn-success btn-xs pull-right" ng-click="getConvo(<?php echo $celeb->message_id; ?>)" data-toggle="modal" data-target="#view_convo">View Message</button>
                <?php
                } ?>
                  <span class="product-description">
                    <?php echo $celeb->position_name; ?> |  <?php echo date("F d, Y", strtotime($celeb->birthday)); ?>
                  </span>
              </div>
            </td>
            </tr>
      
      <?php }}?>
            </tbody>
        </table>
    </div>
    <!-- End. Birthday Celebrants -->
</div>

<!-- Birthday Message Modal -->
<div id="send-message" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Your Greetings!</h4>
      </div>
      <div class="modal-body">
      <form name="send_greetings" method="post" action="send_greeting">
      <input type="hidden" value="{{receiver}}" id="receiver" name="receiver">
       <div class="form-group">
      <label for="comment">Message:</label>
      <textarea class="form-control" rows="5" id="message_content" name="message_content"></textarea>
    </div> 
    <button class="btn btn-primary btn-block btn-md" type="submit">Send Greetings</button>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- End Birthday Message -->

<!-- Birthday Convo Modal -->
<div id="view_convo" class="modal fade" role="dialog" ng-cloak>
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Birthday Greeting</h4>
      </div>
      <div class="modal-body">
  <div class="box-body">
    <!-- Conversations are loaded here -->
    <div class="direct-chat-messages">
      <!-- Message. Default to the left -->
      <div  class="direct-chat-msg">
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name">
            <span ng-show="msg.company_sender == null"><?php echo $this->session->userdata('name_of_user'); ?></span>
          </span>
          <span class="direct-chat-timestamp pull-right">{{message.time_sent}}</span>
        </div>
        <span>
         <img class="direct-chat-img" src="<?php echo base_url()?>public/applicant_files/employee_picture/<?php echo $this->session->userdata('picture'); ?>" alt="sender"><!-- /.direct-chat-img -->
        </span>
        <div class="direct-chat-text">
         {{message.message_content}}
        </div>
        <!-- /.direct-chat-info -->
      </div>

      <div ng-show="message.receiver_reply == null">
        <center>The celebrant is yet to reply.</center>
      </div>

       <div  class="direct-chat-msg right" ng-show="message.receiver_reply != null">
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name pull-right">
            <span ng-show="msg.company_sender == null">{{message.first_name + " " + message.last_name}}</span>
          </span>
          <span class="direct-chat-timestamp">{{message.reply_sent}}</span>
        </div>
        <span>
         <img ng-show="message.isApplicant == 1" class="direct-chat-img" src="<?php echo base_url()?>public/applicant_files/employee_picture/{{message.picture}}" alt="sender"><!-- /.direct-chat-img -->
         <img ng-show="message.isApplicant == 0" class="direct-chat-img" src="<?php echo base_url()?>public/employee_files/employee_picture/{{message.picture}}" alt="sender"><!-- /.direct-chat-img -->
        </span>
        <div class="direct-chat-text">
         {{message.receiver_reply}}
        </div>
        <!-- /.direct-chat-info -->
      </div>
     
      <!-- /.direct-chat-msg -->
    </div>
      <!-- /.direct-chat-msg -->
    <!--/.direct-chat-messages-->
  </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- End Birthday Convo -->
</div>

    <script>
      $(function () {
        $('#employee_data').DataTable({
          "pageLength": 6,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": true,
          "autoWidth": false
        });
      });
    </script>
<!-- DataTables -->
<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
