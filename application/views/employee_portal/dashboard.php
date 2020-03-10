<!-- Apply any bg-* class to to the info-box to color it -->

<br><br>
 <script src='https://kit.fontawesome.com/a076d05399.js'></script>
<script type="text/javascript" src="<?php echo base_url()?>public/dashboard_controller.js"></script>
<div ng-app="myApp" ng-controller="appCtrl">
  <div class="modal fade" id="myModal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content" style="background-color: #5c6bc0;">
                <div class="modal-header"  style="border: none;  ">
                   
                

                </div>
                <div class="modal-body" style="text-align: center;">
                   <div class="text-center" style="color:#e8eaf6; font-family: Comic Sans MS, Comic Sans, cursive;font-size:30px; padding:10px;" >Hi <?php echo $this->session->userdata('name_of_user'); ?>! ,<br>how was your day today? <br><br>
                    <table class="table"><tbody><tr>
                        <td><i class='fas fa-angry emoji' id="angry" ><br><span style="font-size: 15px;">Angry</span><input hidden type="radio" name="mood" value="angry"></i></td><td><input type="radio" value="happy" hidden name="mood"><i class=' fas fa-grin-beam emoji' id="happy"><br><span style="font-size: 15px;">Happy</span></i> </td><td>  <i class='fas fa-meh emoji' id="meh"><br><span style="font-size: 15px;">Meh</span><input value="meh" type="radio" name="mood" hidden></i> </td>
                        <td><i class=' fas fa-tired emoji' id="tired"><input type="radio" hidden name="mood" value="tired"><br><span style="font-size: 15px;">Tired</span></i> </td>

                    </tr></tbody></table>
                        
                 

                    </div>
                        <span style="color:white">Add notes</span>
                       <textarea class="form-control" id="note"></textarea>
                       <br>
                  <button type="button" class="btn btn-default" id="emoji" style="background-color: #5c6bc0; color:white;">rate my day</button>


                </div>
                <div class="modal-footer" style="border: none;">
                   
                </div>
            </div>
        </div>
    </div>
</div>



<div class="content-body" style="background-color: #D7EFF7;">
<?php if ($this->session->flashdata('feedback')) { ?>
  <div class="col-md-12">
     <div class="alert alert-success">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Success!</strong> <?php echo $this->session->flashdata('feedback'); ?>
      </div>
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
</br>
 <!-- ANNOUNCEMENT -->
  <div class="col-lg-3">

  <div>
    <div class="callout callout-warning">
      <h4><i class="fa fa-bullhorn"></i>&nbsp;&nbsp;Announcements</h4>

        <?php 
          if ($announcement){ 
            foreach ($announcement as $announce){?>

              <strong> <?php echo $announce->announcement_title; ?> </strong>
              <p class="pull-right"><?php echo $announce->date_from; ?></p>
              <p><?php echo $announce->announcement_details; ?></p>
                <?php if($announce->file_name){?>
                  <p> <a href="#" type="button" class="pull-left" data-toggle="tooltip" data-placement="right" title="Click to Download"><i class="fa fa-download fa-2x" style="color:#3c8dbc;"></i></a>&nbsp;&nbsp;&nbsp;<?php echo $announce->file_name; ?></p>
                <?php } else{ ?>
                  <p> </p>
            <?php } } }else{ ?>
              <p>No Announcements</p>
        <?php }?> 
    </div>
  </div>



   <!-- TRAININGS AND SEMINARS -->

  <div>
    <div class="callout callout-danger" style="height: auto;">
      <h4><i class="fa fa-bullhorn"></i>&nbsp;&nbsp;Trainings and Seminars</h4>

          <?php 
                  $i =1; foreach($upcoming_seminars_trainings as $st){
                  $date_now =date('Y-m-d');
                  $stfrom = $file_date = date('Y-m-d', strtotime($st->datefrom. ' - '.$settings_st.' days'));
                  
                  if($stfrom==$date_now || $date_now == $st->dateto)
                    { $r='true'; }
                  else if($date_now > $stfrom && $date_now < $st->dateto)
                  { $r = 'true'; } else { $r='false'; }
                 if($r=='true'){ 
            ?>

                <strong><i>Title:</i><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url();?>employee_portal/employee_201/#/7" target="_blank"  class="text-danger" style="cursor:pointer;"><n><?php echo $st->training_title;?></n></a> </strong><br>
                <strong><i>Date:</i><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<n><?php echo $st->datefrom." to ".$st->dateto;?></n> </strong>
              
            <?php } }?>
    </div>
  </div>

  <?php if(count($request_training)==0){}
  else{?>
   <div>
    <div class="callout callout-info" style="height: auto;">
      <h4><i class="fa fa-bullhorn"></i>&nbsp;&nbsp;Trainings / Seminars Request</h4>

        <span class="blink text-danger">
                    <a style="cursor: pointer;color:red;" target="_blank" href="<?php echo base_url();?>employee_portal/training_request/index">Please respond to company training request. Click to view training requests.</a>
         </span>
        
    </div>
  </div>

  <!-- END TRAININGS AND SEMINARS -->
    <?php } ?>
  <?php if(count($for_interview) > 0){?>
  <div>
    <div class="callout callout-success">
      <h4><i class="fa fa-bullhorn"></i>&nbsp;&nbsp;Applicant for Interview</h4>
      <center>
       <span class="blink text-danger">
        <?php echo count($for_interview)." Applicants for Interview";?><br>
          <a style="cursor: pointer;color:red;" target="_blank" href="<?php echo base_url();?>employee_portal/for_interview_applicants">Click for more details. </a>
         </span>
         </center>
    </div>
  </div>
  <?php } ?>
  </div>
  <!-- END ANNOUNCEMENT -->


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
          
            if(empty($celeb->picture))
               {
                  $picture ='User.png';
               }
               else
               {
                  $picture = $celeb->picture;
               }
           if ($this->session->userdata('employee_id') == $celeb->employee_id)
            { ?>
      <tr>
        <td>
          <div class="product-img">
                <img src="<?php echo $url . $picture; ?>" alt="Product Image">
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
                <img src="<?php echo $url . $picture; ?>" alt="Product Image">
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
                    <?php echo $celeb->position_name; ?> <br>  <?php echo date("F d", strtotime($celeb->birthday)); ?>
                  </span>
              </div>
            </td>
            </tr>
      
      <?php }}?>
            </tbody>
        </table>
      
     <!--  for newly hired employee -->

         <table class="table table-bordered table-striped">
            <thead>
            <tr class="success">
              <th>Newly Hired Employees <span class="pull-right"><i class="fa fa-thumbs-o-up col-lg-4"></i> </span></th>
            </tr>
            </thead>
        </table>
        <div class='employee_hired_list' style="height:auto; padding-top: 10px;">
        <table id='new_hired'>
            <thead>
              <tr>
                <th  style="width: 30%;"></th>
                <th style="width: 70%;"></th>
              </tr>
            </thead>
            <?php 
                  $company_id = $this->session->userdata('company_id'); 
                  $emp_id = $this->session->userdata('employee_id');
                  $check_company_set_up = $this->employee_dashboard_model->check_company_set_up($company_id);
                  //if no company set up 
                 if(empty($check_company_set_up)){ echo ""; } 
                    //if has set up 
                     else
                      { 
                          //start foreach
                          foreach ($check_company_set_up as $row){ 
                               $days_to_view = $row->days_to_view;
                              if($row->action_option=='All') {   
                                $emp_list =  $this->employee_dashboard_model->emp_list(); 
                                  //view list of employeess
                                    
                                    foreach ($emp_list as $list) 
                                      { 
                                       

                                          $date_employed = $list->date_employed;
                                          $last_date_of_view = date('Y-m-d', strtotime($date_employed. ' + '.$days_to_view.' days'));

                                          if($last_date_of_view >= date('Y-m-d'))
                                           {   
                                            echo "<tr>";
                                                $filename = 'public/employee_files/employee_picture/'.$list->picture;
                                           
                                                if (file_exists($filename)) {?>
                                                 
                                                     <td><div style="height:130px;"><img class="direct-chat-img" src="<?php echo base_url()?>public/employee_files/employee_picture/<?php echo $list->picture?>" alt="sender" height='100' width='100'> </div></td> 
                                                       <td><div style="height:130px;"><n class='text-danger' style='font-weight:bold;'><?php echo $list->first_name.",".$list->last_name."</n>"."<n style='color:#708090;'>"."<br>".$list->position_name."<br>"; ?></n>
                                                        <n style='color:#BDB76B;'><?php echo $list->date_employed;?> </n><br>
                                                        <n style='color:#00CED1;'><?php echo $list->company_name;?> </n><br>
                                                        <n style='color:#F0E68C;'><?php echo $list->dept_name;?> </n><br>
                                                        </div></td>

                                                     <?php } else  { ?>
                                                     <td><div style="height:130px;"><img class="direct-chat-img" src="<?php echo base_url()?>public/employee_files/employee_picture/User.png" alt="sender" height='100' width='100'> </div></td> 
                                                       <td><div style="height:130px;"><n class='text-danger' style='font-weight:bold;'><?php echo $list->first_name.",".$list->last_name."</n>"."<n style='color:#708090;'>"."<br>".$list->position_name."<br>";?></n>
                                                        <n style='color:#BDB76B;'><?php echo $list->date_employed;?> </n><br>
                                                        <n style='color:#00CED1;'><?php echo $list->company_name;?> </n><br>
                                                        <n style='color:#F0E68C;'><?php echo $list->dept_name;?> </n><br>
                                                        </div></td>

                                                      <?php }
                                            echo "</tr>"; 
                                            }

                                          else {
                                           
                                          } 
                                        
                                      }
                              
                              } elseif($row->action_option=='Multi'){
                                $multicomp = explode("-",$row->option_for_multicompany);
                                foreach ($multicomp as $multi) {
                                
                                $emp_list_multi =  $this->employee_dashboard_model->emp_list_multi($multi); 
                                  // view list of employeess
                                    $i =0; 
                                    foreach ($emp_list_multi as $llist) 
                                      {
                                        if($i == 100){}
                                        else
                                        {
                                          $date_employed = $llist->date_employed;
                                          $last_date_of_view = date('Y-m-d', strtotime($date_employed. ' + '.$days_to_view.' days'));
                                          
                                          if($last_date_of_view >= date('Y-m-d'))
                                           {   
                                            echo "<tr>";
                                                $filename = 'public/employee_files/employee_picture/'.$llist->picture;
                                           
                                                if (file_exists($filename)) {?>
                                                 
                                                     <td><div style="height:130px;"><img class="direct-chat-img" src="<?php echo base_url()?>public/employee_files/employee_picture/<?php echo $llist->picture?>" alt="" height='100' width='100'> </div></td> 
                                                       <td><div style="height:130px;"><n class='text-danger' style='font-weight:bold;'><?php echo $llist->first_name.",".$llist->last_name."</n>"."<n style='color:#708090;'>"."<br>".$llist->position_name."<br>"; ?></n>
                                                        <n style='color:#BDB76B;'><?php echo $llist->date_employed;?> </n><br>
                                                        <n style='color:#00CED1;'><?php echo $llist->company_name;?> </n><br>
                                                        <n style='color:#F0E68C;'><?php echo $llist->dept_name;?> </n><br>
                                                        </div></td>

                                                     <?php } else  { ?>
                                                     <td><div style="height:130px;"><img class="direct-chat-img" src="<?php echo base_url()?>public/employee_files/employee_picture/User.png" alt="" height='100' width='100'> </div></td> 
                                                       <td><div style="height:130px;"><n class='text-danger' style='font-weight:bold;'><?php echo $llist->first_name.",".$llist->last_name."</n>"."<n style='color:#708090;'>"."<br>".$llist->position_name."<br>";?></n>
                                                        <n style='color:#BDB76B;'><?php echo $llist->date_employed;?> </n><br>
                                                        <n style='color:#00CED1;'><?php echo $llist->company_name;?> </n><br>
                                                        <n style='color:#F0E68C;'><?php echo $llist->dept_name;?> </n><br>
                                                        </div></td>

                                                      <?php }
                                            echo "</tr>"; 
                                            }
                                        }
                                      }

                              } } elseif($row->action_option=='One_specs'){ 
                                $emp_details =  $this->employee_dashboard_model->emp_details($emp_id); 
                                foreach ($emp_details as $empp) {
                                  $company_id = $empp->company_id;
                                  $division = $empp->division_id;
                                  $department = $empp->department;
                                  $section = $empp->section;
                                  $subsection = $empp->subsection;    
                                  $classification = $empp->classification;
                                  $employment = $empp->employment;
                                  $location = $empp->location;
                                  $status = $empp->InActive;

                                  $emp_list_all =  $this->employee_dashboard_model->emp_list_all($company_id,$division,$department,$section,$subsection,$classification,$employment,$location,$status);
                                   $i =0; 
                                    foreach ($emp_list_all as $l) 
                                      {
                                        if($i == 100){}
                                        else
                                        {
                                          $date_employed = $l->date_employed;
                                          $last_date_of_view = date('Y-m-d', strtotime($date_employed. ' + '.$days_to_view.' days'));
                                          if($last_date_of_view >= date('Y-m-d'))
                                           {    echo "<h5><label>Date Employed : </label>".$date_employed."</h5>";
                                                echo "<h4 class='text-danger'><b>".$l->company_id."-".$l->first_name.""." " ."".$l->last_name."</b></h4>"; $i = $i + 1; }
                                          else {}
                                        }
                                      }
                                }
                                ?>

                              <?php } elseif($row->action_option=='One_emp'){

                                $emp_hired_notif_id =  $this->employee_dashboard_model->check_designation_data($company_id);
                                $company_details_to_view =  $this->employee_dashboard_model->check_designation_company($emp_hired_notif_id);
                                foreach ($company_details_to_view as $query) {
                                    $company = $query->company;
                                    $department = $query->department;
                                    $division = $query->division;
                                    $section = $query->section;
                                    $subsection = $query->subsection;
                                    $classification = $query->classification;
                                    $employment = $query->employment;
                                    $location = $query->location;
                                    $status = $query->status; 
                                    $emp_list = '';
                                    $get_emp_company = $this->employee_dashboard_model->get_emp_company($company);
                                   foreach ($get_emp_company as $getemployee) {
                                    $getemp=$getemployee->employee_id;
                                   $get_emp_true = $this->employee_dashboard_model->get_emp_true($getemp,$division,$company);
                                    if($get_emp_true=='true')
                                      { $get_emp_department = $this->employee_dashboard_model->get_emp_department($getemp,$department,$company);  
                                        if($get_emp_department=='true')
                                          { $get_emp_section  = $this->employee_dashboard_model->get_emp_section($getemp,$section,$company);  
                                            if($get_emp_section=='true')
                                            {
                                               $get_emp_subsection = $this->employee_dashboard_model->get_emp_subsection($getemp,$subsection,$company); 
                                               if($get_emp_subsection=='true')
                                               {
                                                  $get_emp_classification = $this->employee_dashboard_model->get_emp_classification($getemp,$classification,$company);
                                                if($get_emp_classification=='true')
                                                {
                                                    $get_emp_employment = $this->employee_dashboard_model->get_emp_employment($getemp,$employment,$company);
                                                  if($get_emp_employment=='true'){
                                                   $get_emp_location = $this->employee_dashboard_model->get_emp_location($getemp,$location,$company);
                                                  if($get_emp_employment=='true')
                                                  {
                                                     $get_emp_status = $this->employee_dashboard_model->get_emp_status($getemp,$status,$company);
                                                     if($get_emp_status=='true')
                                                     {
                                                       $date_employed = $getemployee->date_employed;
                                                       $last_date_of_view = date('Y-m-d', strtotime($date_employed. ' + '.$days_to_view.' days'));
                                                       if($last_date_of_view >= date('Y-m-d'))
                                                       {    echo "<h5><label>Date Employed : </label>".$date_employed."</h5>";
                                                            echo "<h4 class='text-danger'><b>".$getemployee->company_id."-".$getemployee->first_name.""." " ."".$getemployee->last_name."</b></h4>";}
                                                      else {
                                                      }
                                                     }
                                                  }
                                                  }
                                                }
                                               }
                                            }
                                          }
                                      }
                                   
                                    else { $res = 'false'; }
                                   }
                                }
                              ?>
                            <?php  } ?>
                          <!-- end of foreach -->
                            </tbody>
                          </table>
                     <?php }?>
            <?php } ?>




        <?php if($checker_company_policy=='true' || $checker_company_policy=='true_updated')
        {?>
        <!--  company policy -->     
        <table class="table table-bordered table-striped">
            <thead>
            <tr class="info">
              <th>Company Policy Notification<span class="pull-right"><i class="fa fa-list col-lg-4"></i><a href="<?php echo base_url();?>/employee_portal/company_policy/" target="_blank" style="cursor: pointer;"><i class="fa fa-arrow-right col-lg-4"></i> </a></span></th>
            </tr>
            </thead>
        </table>

        <div class='company_policy' style="height:auto;">
       <center> <span class="blink text-danger">
         <?php   if($checker_company_policy=='true'){ echo "KINDLY VIEW AND ACKNOWLEDGE THE COMPANY POLICY"; }
        else if($checker_company_policy=='true_updated'){ echo "KINDLY VIEW AND ACKNOWLEDGE THE UPDATED COMPANY POLICY"; } else{ };?>
        </span>
        </center>
        </div>
        <!-- company policy -->  

        <?php } ?>


    

        



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

    
<!-- End Birthday Convo -->

</div>
  


  <style type="text/css">
     .blink{
          
          font-family: cursive;
          animation: blink 2s linear infinite;
        }
   
              
        @keyframes blink{
        0%{opacity: 0;}
        50%{opacity: .5;}
        100%{opacity: 1;}
    } 
 vertical-align: middle;
}
.modal {
  border:none;
}
.table thead tr th, .table tbody tr td {
    border: none;
}

.modal-content {
    /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
    width:inherit;
    height:inherit;
    /* To center horizontally */
    margin: 0 auto;
}
.content-body.modal-open .container-table{
    -webkit-filter: blur(5px);
    -moz-filter: blur(4px);
    -o-filter: blur(4px);
    -ms-filter: blur(4px);
    filter: blur(4px);
}


#angry:hover{
      position: relative;
      top:-4px;
      
}
#happy:hover{
       position: relative;
       top:-4px;
}

#meh:hover{
      position: relative;
      top:-4px;
      
}
#tired:hover{
      position: relative;
      top:-4px;
     
  </style>

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

       $(function () {
        $('#sem_tra').DataTable({
          "pageLength":-1,
          "pagingType" : "simple",
          "paging": true,
         lengthMenu: [[1,5, 10, 15, 20, 25, 30, 35, 40, -1], [1,5, 10, 15, 20, 25, 30, 35, 40, "All"]],
          "searching": false,
          "ordering": false,
          "info": true,
          "autoWidth": false
        });
      });

       $(function () {
        $('#new_hired').DataTable({
          "pageLength":1,
          "pagingType" : "simple",
          "paging": true,
         lengthMenu: [[1,5, 10, 15, 20, 25, 30, 35, 40, -1], [1,5, 10, 15, 20, 25, 30, 35, 40, "All"]],
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

<script>


      $(window).on('load',function(){ 
       
             $.ajax({
       url: "<?php echo base_url();?>employee_portal/employee_dashboard/is_employee_exist/",
       method:"POST",
       dataType:'json',
   
       
   
       success:function(data)
       {
        if(data == true){
        $('#myModal').modal('show');
        }
      }
     })
        
    });
          $('.emoji').click(function(){
      
          $('.emoji').parent('td').css('border-bottom','none');
           if($(this).attr('id') == 'angry'){
            qwe = '4px solid #DC1F23';
          }else if($(this).attr('id') == 'tired'){
            qwe = '4px solid #F27E33';
          }else if($(this).attr('id') == 'happy'){
            qwe = '4px solid #40B34A';
          }else if($(this).attr('id') == 'meh'){
            qwe = '4px solid #F8BB3E';
          }

          $(this).closest('td').find('[type=radio]').prop('checked', true);
          $(this).parent('td').css('border-bottom',qwe);
    })


   $('#emoji').click(function(){
     mood =  $('input[name="mood"]:checked').val();
     note = $('textarea#note').val();
     $.ajax({
       url: "<?php echo base_url();?>employee_portal/employee_dashboard/save_feelings/",
       method:"POST",
       data:{mood:mood,note:note},
       
   
       success:function()
       {
          $('#myModal').modal('toggle');
       }
     })
  })


var myIndex = 0;
carousel();

function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, 4000); // Change image every 4 seconds
}function Refresh() {
    window.parent.location = window.parent.location.href;
}

function view_details(employee_id)
{
      {
        if (window.XMLHttpRequest)
          {
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            { 
            document.getElementById("show_view").innerHTML=xmlhttp.responseText;
            
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_dashboard/new_hired_one/"+employee_id,true);
        xmlhttp.send();
        } 
        alert(employee_id);
}
</script>