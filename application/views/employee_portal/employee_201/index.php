<br><br>
<div ng-app="myApp" ng-controller="appCtrl" >
    <!-- Start of Side View -->
    <div class="col-md-3">
      
      <div class="panel box box-success">
     
        <div class="panel-heading"><h4>Employee 201 Profile  <span class="pull-right"><i class="fa fa-folder-open"></i></span></h4></div>
        <div class="panel-body  fixed-panel-side mCustomScrollbar" data-mcs-theme="dark"">
          <ul class="nav nav-pills nav-stacked">
              <li><a href="#profile_information"><i class='fa fa-circle-o'></i> <span>PROFILE INFORMATION</span></a></li>
              <li><a href="#editable_topics"><i class='fa fa-circle-o'></i> <span> Editable 201 Topics </span></a></li>
              <li><a href="#full_information"><i class='fa fa-circle-o'></i> <span> View Full 201 Information </span></a></li>
              <li><a href="#send_request"><i class='fa fa-circle-o'></i> <span> Send Request</span></a></li>
              <?php
              foreach ($titles as $title)
              { ?>
                  <li><a href="#<?php echo $title->topic_id; ?>" ><i class='fa fa-circle-o'></i> <span> <?php echo $title->topic_title; ?> </span></a></li>
              <?php
              }
             ?>
              <li><a href="#resigned_history"><i class='fa fa-circle-o'></i> <span>Resigned Date History </span></a></li>
              <li><a href="#employment_history"><i class='fa fa-circle-o'></i> <span>Employment Date History</span></a></li>
              <li><a href="#long_service"><i class='fa fa-circle-o'></i> <span>Long Service Leave History</span></a></li>
              
             <?php if ($this->session->userdata('from_applicant')) { ?> 
                  <li><a href="#questions" ><i class='fa fa-circle-o'></i> <span> Interview Questions</span></a></li>
             <?php } ?>
          </ul>
        </div>
      </div>
    </div>
    <!-- End of Side View -->

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
    <div ng-view >
    
    </div>
</div>


