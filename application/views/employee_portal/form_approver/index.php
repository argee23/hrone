<?php error_reporting(0); ?>
 <link href="<?php echo base_url()?>public/radio.css" rel="stylesheet">
<br><br>

<div ng-app="app" ng-controller="appCtrl">
<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-sm-12">
<h2 class="page-header ng-scope">Form Approval</h2>
<div class="container">
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


  <div class="panel panel-body table-responsive">
   <?php $checker = $this->general_model->check_approver_exist($this->session->userdata('employee_id'));
if($checker=='true'){} else{ echo "No Pending transaction/s."; }?>
    <?php
      if (count($approvals) == 0)
      {
        echo "<center><h3>No pending approval.</h3></center>";
      }
      else { 
      foreach ($approvals as $approval)
      { ?>
      
          <?php if (count($approval->forms) != 0) { 

              if ($approval->IsUserDefine == 1)
              {
                 require_once(APPPATH.'views/employee_portal/form_approver/modals/user_defined.php');
              }
              else
              {
                 require_once(APPPATH.'views/employee_portal/form_approver/modals/' . $approval->t_table_name . '.php');
              }
      if($approval->id==8){

        $atro_with_pay = $this->form_approver_model->get_atro_withpay_incentive('with_pay');
        $atro_incentive_leave = $this->form_approver_model->get_atro_withpay_incentive('IL');
       if(count($atro_with_pay)==0){}else{
      ?>


       <div class="box box-primary">
        <div class="box-header with-border">
        <h3 class="box-title"><?php echo ucwords($approval->form_name);?>s</h3> <i>(with pay)</i>
              <div class="pull-right box-tools">
                <a href="<?php echo base_url();?>employee_portal/form_approver/mass_approval_atro/<?php echo $approval->t_table_name;?>/<?php echo $approval->IsUserDefine;?>/with_pay" class="btn btn-primary btn-xs"  data-toggle="tooltip" title="Mass Approval">
                  Mass Approval</a>
              </div>
        </div>
        <div class="box-body">
          <table class="table table-responsive">
            <thead>
              <tr>
                <th>Document No.</th>
                <th>Filed By</th>
                <th>File Date</th>
                <th><center>Details</center></th>
              </tr>
            </thead>
            <tbody>   
             <?php foreach ($atro_with_pay as $form)
              { 
              
              ?>
              <tr class="my_hover">
                <td><a ng-click="get_form('<?php echo $form->doc_no; ?>', '<?php echo $approval->t_table_name; ?>'); form_name='<?php echo $approval->form_name;?>'; table_name='<?php echo $approval->t_table_name;?>'; identification='<?php echo $approval->identification;?>'" href="#<?php echo $approval->t_table_name; ?>" data-toggle="modal"><strong><?php echo $form->doc_no; ?></strong></a></td>
                <td><?php echo strtoupper($form->filer_info->last_name) . ", " . $form->filer_info->first_name . " " . $form->filer_info->middle_name; ?></td>
                <td><?php echo date("F d, Y", strtotime($form->form_info->date_created)); ?></td>
                <td><center><a href="view/<?php echo $form->doc_no; ?>/<?php echo $approval->t_table_name; ?>/<?php echo $approval->identification; ?>" target="_blank"><span class="badge bg-green">View Details</span></a></center></td>
              </tr>
              <?php  } ?>
          </tbody>
          </table>
          </div>
          </div>
        <?php }  if(count($atro_incentive_leave)==0){}else{?>
        <div class="box box-primary">
        <div class="box-header with-border">
        <h3 class="box-title"><?php echo ucwords($approval->form_name);?>s</h3> <i>(Incentive Leave)</i>
              <div class="pull-right box-tools">
                <a href="<?php echo base_url();?>employee_portal/form_approver/mass_approval_atro/<?php echo $approval->t_table_name;?>/<?php echo $approval->IsUserDefine;?>/IL" class="btn btn-primary btn-xs"  data-toggle="tooltip" title="Mass Approval">
                  Mass Approval</a>
              </div>
        </div>
        <div class="box-body">
          <table class="table table-responsive">
            <thead>
              <tr>
                <th>Document No.</th>
                <th>Filed By</th>
                <th>File Date</th>
                <th><center>Details</center></th>
              </tr>
            </thead>
            <tbody>   
             <?php foreach ($atro_incentive_leave as $form)
              { 
              
              ?>
              <tr class="my_hover">
                <td><a ng-click="get_form('<?php echo $form->doc_no; ?>', '<?php echo $approval->t_table_name; ?>'); form_name='<?php echo $approval->form_name;?>'; table_name='<?php echo $approval->t_table_name;?>'; identification='<?php echo $approval->identification;?>'" href="#<?php echo $approval->t_table_name; ?>" data-toggle="modal"><strong><?php echo $form->doc_no; ?></strong></a></td>
                <td><?php echo strtoupper($form->filer_info->last_name) . ", " . $form->filer_info->first_name . " " . $form->filer_info->middle_name; ?></td>
                <td><?php echo date("F d, Y", strtotime($form->form_info->date_created)); ?></td>
                <td><center><a href="view/<?php echo $form->doc_no; ?>/<?php echo $approval->t_table_name; ?>/<?php echo $approval->identification; ?>" target="_blank"><span class="badge bg-green">View Details</span></a></center></td>
              </tr>
              <?php  } ?>
          </tbody>
          </table>
          </div>
          </div>


      <?php } } else{
      ?>
        <div class="box box-primary">
        <div class="box-header with-border">
        <h3 class="box-title"><?php echo ucwords($approval->form_name);?>s</h3>
              <div class="pull-right box-tools">
                <a href="<?php echo base_url();?>employee_portal/form_approver/mass_approval/<?php echo $approval->t_table_name;?>/<?php echo $approval->IsUserDefine;?>" class="btn btn-primary btn-xs"  data-toggle="tooltip" title="Mass Approval">
                  Mass Approval</a>
              </div>
        </div>
        <div class="box-body">
          <table class="table table-responsive">
            <thead>
              <tr>
                <th>Document No.</th>
                <th>Filed By</th>
                <th>File Date</th>
                <th><center>Details</center></th>
              </tr>
            </thead>
            <tbody>   
             <?php foreach ($approval->forms as $form)
              { 
              
              ?>
              <tr class="my_hover">
                <td><a ng-click="get_form('<?php echo $form->doc_no; ?>', '<?php echo $approval->t_table_name; ?>'); form_name='<?php echo $approval->form_name;?>'; table_name='<?php echo $approval->t_table_name;?>'; identification='<?php echo $approval->identification;?>'" href="#<?php echo $approval->t_table_name; ?>" data-toggle="modal"><strong><?php echo $form->doc_no; ?></strong></a></td>
                <td><?php echo strtoupper($form->filer_info->last_name) . ", " . $form->filer_info->first_name . " " . $form->filer_info->middle_name; ?></td>
                <td><?php echo date("F d, Y", strtotime($form->form_info->date_created)); ?></td>
                <td><center><a href="view/<?php echo $form->doc_no; ?>/<?php echo $approval->t_table_name; ?>/<?php echo $approval->identification; ?>" target="_blank"><span class="badge bg-green">View Details</span></a></center></td>
              </tr>
              <?php  } ?>
          </tbody>
          </table>
          </div>
          </div>
       <?php }  } ?>
    <?php
      } } ?>
  </div>
</div>
</div>
</div>
</div>
<!-- Angular Js Script -->
<script>
var app = angular.module('app', []);

app.controller('appCtrl', ['$scope', '$http', function($scope, $http) {


  $scope.table_name = '';
  $scope.form_name = '';
  $scope.identification = '';

  $scope.get_form = function(doc_no, table_name)
  {
      $http.post('<?php echo base_url();?>employee_portal/form_approver/get_form_details/'+doc_no+'/'+table_name ).success(function(data){
        $scope.form = data.form;
        $scope.filer = data.filer;
        $scope.days = data.days
        });
  }
}]);

</script>
