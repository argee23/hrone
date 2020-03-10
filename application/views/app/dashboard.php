<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->session->userdata('sys_name');?></title><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
            rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
            <link href="<?php echo base_url()?>public/bootstrap/css/developer_added.css" rel="stylesheet">
    </head>
<!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
<!-- SIDEBAR -->
    <?php 

if($this->session->userdata('is_logged_in')){
$current_account_logged_in="admin or employee account";
}else{
$current_account_logged_in="employer_account";
}    
if($current_account_logged_in!="employer_account"){
   require_once(APPPATH.'views/include/sidebar.php');
  }else{
 require_once(APPPATH.'views/include/sidebar_recruitment_employer.php');
  }

    ?>

<body>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper2">

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
    <?php
if($current_account_logged_in!="employer_account"){

}else{
echo ' <small>Employer panel</small>';
}
    ?>
   
  </h1>
<br>
<?php echo $message;?>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>

<section class="content">
<?php 
//====================================================================================================Administrator Account
if($current_account_logged_in!="employer_account"){
?>
  <div class="row">
                 <div class="col-md-6">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
<?php
if(!empty($today_bday_celebrants)){
  $today_active='class="active"';
  $today_bd='active';
  $month_active='';
  $month_bd='';
}else{
  $today_active='';
  $today_bd='';
  $month_active='class="active"';
  $month_bd='active';  
}


?>
                  <li <?php echo $today_active;?>><a href="#activity" data-toggle="tab">Todays Birthday Celebrants <?php $m= date('m'); $d= date('d'); $y= date('Y'); echo date("F", mktime(0, 0, 0, $m, 10)). "&nbsp;". $d.' ';?></a></li>


                  <li <?php echo $month_active;?>><a href="#timeline" data-toggle="tab"><?php $m= date('m'); $d= date('d'); $y= date('Y'); echo date("F", mktime(0, 0, 0, $m, 10));?> Birthday Celebrants</a></li>

                  <li><a href="#newly_hired" data-toggle="tab"><?php $m= date('m'); $d= date('d'); $y= date('Y'); echo date("F", mktime(0, 0, 0, $m, 10))." ".$y;?> Newly Hired Employees</a></li>

                </ul>
                <div class="tab-content">
                  <div class="<?php echo $today_active;?> tab-pane" id="activity">
                  <ul class="products-list product-list-in-box">
<?php
 foreach($today_bday_celebrants as $bday_celeb){
  if(empty($bday_celeb->picture))
  {
    $picture ='User.png';
  }else { $picture = $bday_celeb->picture; }
?>                                   
                    <li style="height:100px;" class="item col-md-4">
                      <div class="product-img">
                        <img src="<?php echo base_url()?>public/employee_files/employee_picture/<?php echo $picture;?>" alt="Employee Photo">
                      </div>
                      <div class="product-info">
                        <a class="product-title"><?php echo $bday_celeb->first_name." ".$bday_celeb->last_name;?> <i class="fa fa-birthday-cake text-danger" aria-hidden="true"></i></a>
                        <span class="product-description">
                          <?php echo $bday_celeb->position_name;?>
                        </span>
                      </div>
                    </li><!-- /.item -->
                  
<?php
}
?>
                  </ul>
                  </div><!-- /.tab-pane -->

                  <div class="<?php echo $month_bd;?> tab-pane" id="timeline">
                     <ul class="products-list product-list-in-box">
<?php
 foreach($month_bday_celebrants as $bday_celeb){
  if(empty($bday_celeb->picture))
  {
    $picture ='User.png';
  }else { $picture = $bday_celeb->picture; }
?>
                    <li style="height:100px;" class="item col-md-4">
                      <div class="product-img">
                        <img src="<?php echo base_url()?>public/employee_files/employee_picture/<?php echo $picture;?>" alt="Employee Photo">
                      </div>
                      <div class="product-info">
                        <a class="product-title"><?php echo $bday_celeb->first_name." ".$bday_celeb->last_name;?> <i class="fa fa-birthday-cake text-danger" aria-hidden="true"></i></a>
                        <span class="product-description">
                          <?php echo $bday_celeb->position_name;?>
                        </span>
                      </div>
                    </li><!-- /.item -->
<?php
}
?>
                  </ul>
                  </div>


                  <div class="tab-pane" id="newly_hired">
                     <ul class="products-list product-list-in-box">
<?php
 foreach($newly_hired as $newly_hired){
  if(empty($newly_hired->picture))
  {
    $picture ='User.png';
  }else { $picture = $newly_hired->picture; }
?>
                    <li class="item col-md-4">
                      <div class="product-img">
                        <img src="<?php echo base_url()?>public/employee_files/employee_picture/<?php echo $picture;?>" alt="Employee Photo">
                      </div>
                      <div class="product-info">
                        <a class="product-title"><?php echo $newly_hired->first_name." ".$newly_hired->last_name;?> </a>
                        <span class="product-description">
                          <?php echo $newly_hired->position_name;?>
                        </span>
                        <span class="product-description">
                          <?php echo $newly_hired->date_employed;?>
                        </span>
                      </div>
                    </li><!-- /.item -->
<?php
}
?>
                  </ul>
                  </div>




                </div>
              </div>
            </div>

<!-- //====================================================================== -->

                 <div class="col-md-6">
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#admin_reminders" data-toggle="tab"><i class="fa fa-bullhorn text-danger"></i> Admin Reminders</a></li>
                      <li><a href="#emp_status_alert" data-toggle="tab"><i class="fa fa-bullhorn text-danger"></i> Employment Status Alert</a></li>
                      <li><a href="#emp_movement" data-toggle="tab"><i class="fa fa-bullhorn text-danger"></i> Employee Movement Monitoring</a></li>
                    </ul>

              <div class="tab-content">

                <!-- ADMIN REMINDERS -->
                <div class="active tab-pane" id="admin_reminders">
                
                  <?php
                    /*
                    -----------------------------------
                    start : user role restriction access checking.
                    get the below variable at table "pages" field page_name
                    -----------------------------------
                    */
                    $add_reminder=$this->session->userdata('add_reminder');
                    $edit_reminder=$this->session->userdata('edit_reminder');
                    $delete_reminder=$this->session->userdata('delete_reminder');

                    $add_reminder_status=$this->session->userdata('add_reminder_status');
                    /*
                    -----------------------------------
                    end : user role restriction access checking.
                    -----------------------------------
                    */

                    $edit_reminder = '<a href="javascript:void(0)"><i id="edit" class="'.$edit_reminder.' fa fa-'.$system_defined_icons->icon_edit.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit"></i></a>';

                    $delete_reminder ='<a href="javascript:void(0)"><i id="delete" class="'.$delete_reminder.' fa fa-'.$system_defined_icons->icon_delete.' fa-'.$system_defined_icons->icon_size.'x" data-toggle="tooltip" data-placement="left" title="Delete" style="color:'.$system_defined_icons->icon_delete_color.';"></i></a>';

                  ?>

                  <ul class="products-list product-list-in-box">
                    <li class="item">

                      <div id="reminder_status" style="display:none;">
                        <table id="reminder_status_table" class="table table-hover">
                          <thead>
                            <tr>
                              <th>Id</th>
                              <th>Reminder Status Name</th>
                              <th>Description</th>
                              <th>Color</th>
                              <th>InActive</th>
                              <th style="width: 40px"><center>
                                <a href="javascript:void(0)" id="add_reminder_status_table" type="button" class="<?php echo $add_reminder_status?>" data-toggle="tooltip" data-placement="left" title="Add"><?php
                                  echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
                                  ?>
                                </a></center>
                              </th>
                            </tr>
                          </thead>
                        </table>
                        <br>
                        <button id="back_reminder_status" class="btn btn-danger pull-right">Back</button>
                      </div>

                      <div id ="reminder_status_add" style="display:none;">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Status Name</label>
                               <input type="text" name="status_name" id="status_name" class="form-control" placeholder="Type here" required />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Color</label>
                            <input type="color" name="status_color" id="status_color" class="form-control" required />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="company">Status Description</label>
                               <textarea name="status_desc" id="status_desc" class="form-control" placeholder="Type here" required /></textarea>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <br><br><br>
                          <button id="back_reminder_status_add" class="btn btn-danger pull-right">Back</button>
                          <button id="add_reminder_status" class="btn btn-primary pull-right">Save</button>
                        </div>
                      </div>

                      <div id ="reminder_status_edit" style="display:none;">
                        <div class="col-md-6">
                          <input type="hidden" name="reminder_status_id_edit" id="reminder_status_id_edit"" class="form-control" placeholder="Type here" required />
                          <div class="form-group">
                            <label>Status Name</label>
                               <input type="text" name="status_name_edit" id="status_name_edit" class="form-control" placeholder="Type here" required />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Color</label>
                            <input type="color" name="status_color_edit" id="status_color_edit" class="form-control" required />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="company">Status Description</label>
                               <textarea name="status_desc_edit" id="status_desc_edit" class="form-control" placeholder="Type here" required /></textarea>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <br><br><br>
                          <button id="back_reminder_status_edit" class="btn btn-danger pull-right">Back</button>
                          <button id="update_reminder_status" class="btn btn-primary pull-right">Update</button>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div id="reminder">
                          <table id="reminder_table" class="table table-hover">
                            <thead>
                              <tr>
                                <th>Id</th>
                                <th>Reminders</th>
                                <th>Status&nbsp;&nbsp;&nbsp;
                                  <a href="javascript:void(0)" id="view_reminder_status"  type="button" data-toggle="tooltip" data-placement="left" title="View Reminder Status"><?php
                                    echo '<i class="fa fa-'.$system_defined_icons->icon_view.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_view_color.';" "></i>';
                                    ?>
                                </th>
                                <th style="width: 40px"><center>
                                  <a href="javascript:void(0)" id="add_reminder_table" type="button" class="<?php echo $add_reminder?>" data-toggle="tooltip" data-placement="left" title="Add Reminder"><?php
                                    echo '<i class="fa fa-'.$system_defined_icons->icon_add.' fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_add_color.';" "></i>';
                                    ?>
                                  </a></center>
                                </th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php foreach($myReminders as $r):?>
                                <tr>
                                  <td><?php echo $r->id?></td>
                                  <td class="bg-success"><strong><?php echo $r->reminder_desc?></strong>
                                    </br>
                                    <small>-- <?php echo $r->fullname?></small>
                                  </td>
                                  <?php if ($r->users_id == $this->session->userdata('user_id')) {
                                    echo '<td><a class="status_badge status_change_'.$r->id.'" href="javascript:void(0)" onclick="update_status('.$r->id.')" ><span data-toggle="tooltip" data-placement="right" title="Change Status" class="badge" style="background-color:'.$r->color.'">'.$r->status_name.'</span></a>
                                        <select onchange="update_status_selected('.$r->id.')" id="change_status_select_'.$r->id.'"  class="form-control css col-md-2" style="display:none;">
                                          <option selected disabled>select status</option
                                        </select></td>';
                                    echo '<td>'.$edit_reminder.' '.$delete_reminder.'</td>';
                                    }else{
                                      echo '<td><a class="status_badge status_change_'.$r->id.'" href="javascript:void(0)" onclick="update_status('.$r->id.')" ><span data-toggle="tooltip" data-placement="right" title="Change Status" class="badge" style="background-color:'.$r->color.'">'.$r->status_name.'</span></a>
                                        <select onchange="update_status_selected('.$r->id.')" id="change_status_select_'.$r->id.'"  class="form-control css col-md-2" style="display:none;">
                                          <option selected disabled>select status</option
                                        </select></td>';
                                      echo '<td> </td>';
                                    }
                                  ?>
                                </tr>
                              <?php endforeach?>
                            </tbody>
                          </table>
                        </div>
                      </div>

                      <div id ="reminder_add" style="display:none;">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Reminder Description</label>
                               <textarea name="reminder_desc" id="reminder_desc" class="form-control" placeholder="Type here" rows="3" required /></textarea>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Date From</label>
                              <div class="input-group input-append date" id="start_date_picker">
                                <input type="text" class="form-control" id="start_date" name="start_date" placeholder="yyyy/mm/dd" required />
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Date To</label>
                              <div class="input-group input-append date" id="end_date_picker">
                                <input type="text" class="form-control" id="end_date" name="end_date" placeholder="yyyy/mm/dd" required />
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Type</label>
                              <select name="type" id="type" class="form-control" required />
                                <option selected disabled>select type</option>
                                <option value="public">Public</option>
                                <option value="private">Private</option>
                              </select>
                          </div>
                          <button id="back_reminder" class="btn btn-danger pull-right">Back</button>
                          <button id="add_reminder" class="btn btn-primary pull-right">Save</button>
                        </div>
                      </div>

                      <div id ="reminder_edit" style="display:none;">
                        <div class="col-md-12">
                          <input type="hidden" name="reminder_id_edit" id="reminder_id_edit" class="form-control" placeholder="Type here" required />
                          <div class="form-group">
                            <label>Reminder Description</label>
                              <input type="text" name="reminder_desc_edit" id="reminder_desc_edit" class="form-control" placeholder="Type here" required />
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Date From</label>
                              <div class="input-group input-append date" id="start_date_picker_edit">
                                <input type="text" class="form-control" id="start_date_edit" name="start_date_edit" placeholder="yyyy/mm/dd" required />
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Date To</label>
                              <div class="input-group input-append date" id="end_date_picker_edit">
                                <input type="text" class="form-control" id="end_date_edit" name="end_date_edit" placeholder="yyyy/mm/dd" required />
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Type</label>
                              <select name="type_edit" id="type_edit" class="form-control" required />
                                <option value="public">Public</option>
                                <option value="private">Private</option>
                              </select>
                          </div>
                        </div>
                        <div class="col-md-3 pull-right">
                          <button id="update_reminder" class="btn btn-primary">Update</button>
                          <button id="cancel_update_reminder" class="btn btn-danger pull-right">Back</button>
                        </div>
                      </div>

                    </li>
                  </ul>
                </div>
                <!-- END ADMIN REMINDERS -->


                <!-- EMPLOYEE STATUS ALERT -->
                <div class="tab-pane" id="emp_status_alert">
                  <ul class="products-list product-list-in-box">
                    <li class="item">

                      <div id ="contract_alert_base_edit" style="display:none;">
                        <div class="box-body">
                          <div class='panel panel-danger'>
                            <div class ='panel-heading'><strong>Default Number of Days to Display on Dashboard</strong></div><br>
                            <div class="form-group">
                              <strong class="emp_label"></strong>
                              <div class="col-sm-4 emp_contract_base"></div>
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <button id="update_emp_contract_base" type="submit" class="btn btn-primary">Update</button>
                              <button id="cancel_emp_contract_base" class="btn btn-danger">Cancel</button>
                            </div>
                          </div>
                        </div>                   
                      </div>

                      <div class="col-md-12 contract_status_table">
                        <div class='panel panel-danger'>
                          <?php foreach($companyList as $company):?>
                          <div class ='panel-heading'><strong><?=$company->company_name;?></strong></div>     
                          <div class='panel-body'>                     
                            <table id="contract_status" class="table table-hover table-alternate">
                              <thead>
                                <tr>
                                  <th>Employment Type</th>
                                  <th>For Review Employee(s)</th>
                                  <th>Option</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                  foreach($employmentList as $e){
                                    $endo = $this->dashboard_model->contract_alert($e->employment_id,$e->contract_alert_base, $company->company_id);
                                    if($endo->total_employee > 0){
                                      $view = '<button onclick="show_employees('.$e->employment_id.','.$company->company_id.')"  class="btn btn-sm btn-success">View Employee(s) ['.$endo->total_employee.'] </button>';
                                    }else{
                                      $view = '0';

                                    }
                                    echo '<tr>
                                            <td class="bg-danger">'. $e->employment_name.'</td>
                                            <td >'.$view.'</td>
                                            <td>
                                              <button class="btn btn-sm btn-danger" onclick="get_contract_base('.$e->employment_id.');">Edit Setting</button>
                                            </td>
                                          </tr>';
                                  }

                                ?>
                              </tbody>
                            </table>
                          </div>
                          <?php endforeach ?>
                        </div>
                      </div>

                    </li>
                  </ul>
                </div>
                <!-- END EMPLOYEE STATUS ALERT -->


                <!-- EMPLOYEE MOVEMENT ALERT -->
                <div class="tab-pane" id="emp_movement">
                  <ul class="products-list product-list-in-box">
                    <li class="item">

                      <div id ="movement_alert_base_edit" style="display:none;">
                        <div class="box-body">
                          <div class='panel panel-info'>
                            <div class ='panel-heading'><strong>Default Number of Days to Display on Dashboard</strong></div><br>&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong class='company_label'></strong>
                            <div class='panel-body'>  
                              <div class="form-group">
                                <strong class="move_label"></strong>
                                <div class="col-sm-4 move_base"></div>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button id="update_movement_base" type="submit" class="btn btn-primary">Update</button>
                                <button id="cancel_movement_base" class="btn btn-danger">Cancel</button>
                              </div>
                            </div>
                          </div>
                        </div>                    
                      </div>

                      <div class="col-md-12 movement_type_table">
                        <div class='panel panel-info'>
                          <?php foreach($companyList as $company):?>
                          <div class ='panel-heading'><strong><?=$company->company_name;?></strong></div> 
                          <div class='panel-body'>  
                            <table id='movement_type' class="table table-hover table-alternate">
                              <thead>
                                <tr>
                                  <th>Movement Type</th>
                                  <th>For Review Employee(s)</th>
                                  <th>Option</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php

                                foreach($movemenTypeList as $m){
                                  $transfer=$this->dashboard_model->movement_alert($m->id,$m->movement_alert_base, $company->company_id);
                                  if($transfer->total_employee > 0){
                                    $view='<button onclick="show_movement_employees('.$m->id.', '.$company->company_id.')" class="btn btn-sm btn-success">View Employee(s) ['.$transfer->total_employee.'] </button>';
                                  }else{
                                    $view='0';
                                  }
                                  if($transfer->title){
                                    echo '
                                        <tr>
                                          <td class="bg-info">'. $transfer->title.'</td>
                                          <td >'.$view.'</td>
                                          <td>
                                            <button onclick="get_movement_base('.$m->id.', '.$company->company_id.');" class="btn btn-sm btn-danger">Edit Setting</button>                            
                                          </td>
                                        </tr>';
                                  } else {
                                    echo '<tr></tr>';
                                  }
                                }

                              ?>
                              </tbody>
                            </table>
                          </div>
                          <?php endforeach ?>
                        </div>
                      </div>

                    </li>
                  </ul>
                </div>
                <!-- END EMPLOYEE MOVEMENT ALERT -->


              </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
          </div><!-- /.col -->


<?php
if(!empty($newApplicants)){
  $newapp_active='class="active"';
  $newapp_bd='active';
  $unreadapp_active='';
  $unreadapp_bd='';
}else{
  $newapp_active='';
  $newapp_bd='';
  $unreadapp_active='class="active"';
  $unreadapp_bd='active';  
}
?>
                 <div class="col-md-6">
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li <?php echo $newapp_active;?>><a href="#rec_new_app" data-toggle="tab"><i class="fa fa-users text-danger"></i> New Applicants</a></li>
                      <li <?php echo $unreadapp_active;?>><a href="#rec_unread" data-toggle="tab"><i class="fa fa-pencil text-danger"></i> Unread Applicants</a></li>
                    </ul>

                <div class="tab-content">

                <div class="<?php echo $newapp_bd;?> tab-pane" id="rec_new_app">
                  <ul class="products-list product-list-in-box">
                    <li class="item">
                      <div class="col-md-12">
                      <?php
                      if(!empty($newApplicants)){
                        foreach($newApplicants as $a){
echo '
<div class="callout callout-success">
<p>'.$a->last_name.' '.$a->first_name.'
</p>                <small class="pull-right">-- '.$a->job_title.'</small>
</div>
';
                        }
                      }                     
                      ?>
                    </div>
                    </li>
                  </ul>
                </div>
                <div class="<?php echo $unreadapp_bd;?> tab-pane" id="rec_unread">
                  <ul class="products-list product-list-in-box">
                    <li class="item">
                      <div class="col-md-12">
                      <?php
                      if(!empty($unreadApplicants)){
                        foreach($unreadApplicants as $a){
echo '
<div class="callout callout-success">
<p>'.$a->last_name.' '.$a->first_name.'
</p>                <small class="pull-right">-- '.$a->job_title.'</small>
</div>
';
                        }
                      }                     
                      ?>
                    </div>
                    </li>
                  </ul>
                </div>



                </div><!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->



<?php 
//====================================================================================================Recruitment Employer
}
else{// dashboard of recruitment employer portal only
?>
          <div class="col-sm-12">


              <div class="panel panel-danger" style="margin:5px;">
              <div class="panel-body bg-danger">  
<?php  

$active_usage_type=$rec_employer_setting->active_usage_type;
if($active_usage_type=="free_trial"){
$reg_date=date("Y-m-d", strtotime($myprofile->registration_date));
$reg_date." TO <br>";
$check_reg_date = strtotime($reg_date);
$exp_date = date("Y-m-d", strtotime("+".$rec_employer_setting->free_trial_months_can_post." month", $check_reg_date));
$current_date=date('Y-m-d');

if($current_date>$exp_date){
  $updateusagestatus=$this->recruitment_employer_model->update_usage_status_expired();
echo "Free Trial Already Expired You may avail our Package Offers shown below <i class='fa fa-arrow-down'></i>";
}else{
    $updateusagestatus=$this->recruitment_employer_model->update_usage_status_on();
echo "Free Trial of your account is inclusive on dates <b>".date('F d Y', strtotime($reg_date))." TO ".date('F d Y', strtotime($exp_date))."</b>";
}
             ?>
              </div>  
            </div>
<?php
if($current_date>=$exp_date){
}else{
?>

            <div class="panel panel-danger" style="margin:5px;">
              <div class="panel-body bg-success">  
              Post <?php 
              if($rec_employer_setting->free_trial_jobs_can_post!="unlimited"){
              echo "<span class='text-danger'><b>Up to ".$rec_employer_setting->free_trial_jobs_can_post."</b></span>";
              }else{
              echo "<span class='text-danger'>Unlimited</span>";
              }
              ?> Job Ads For Free within <span class='text-danger'><b><?php echo $rec_employer_setting->free_trial_months_can_post;?></b></span> month(s)
              </div>  
            </div>
<?php
}
}else{

$myactive_bill=$this->recruitment_employer_model->rec_current_bill($active_usage_type);
$payment_status=$myactive_bill->payment_status;
$customer=$myactive_bill->customer_type;
$num_months=$myactive_bill->no_of_months;
$num_jobs=$myactive_bill->no_of_jobs;
$orig_price=$myactive_bill->orig_price;
$disc_percent=$myactive_bill->discount_percentage;

$vat_per=$myactive_bill->vat_percentage;
$is_vat_included_at_last_price=$myactive_bill->is_vat_included_at_last_price;

$less_amount = ($disc_percent / 100) * $orig_price;
$discounted_amount = $orig_price-$less_amount;
$vat_amount= ($vat_per / 100) * $discounted_amount;

if($is_vat_included_at_last_price=="no"){
  $my_gross=$discounted_amount+$vat_amount;
}else{
  $my_gross=$discounted_amount;//-$vat_amount
}

echo '           <div class="panel panel-danger col-md-12" style="margin:5px;">
              <div class="panel-body bg-success">
<table class="table">
<thead>
  <tr>
    <th class="text-danger">My Active Subscription</th>
    <th>Validity</th>
    <th>Job License</th>
    <th>Orig Price</th>
    <th>Discount %</th>
    <th>Discounted Price</th>
    <th>Vat Included already</th>
    <th>Vat Percentage</th>
    <th>Amount of Vat</th>
    <th>Gross</th>
    <th>Payment Status</th>
  </tr>
</thead>';
$paid_reg_date=date("Y-m-d", strtotime($myactive_bill->date_registered));
$paid_reg_date." TO <br>";
$check_reg_date = strtotime($paid_reg_date);
$exp_date = date("Y-m-d", strtotime("+".$myactive_bill->validity_license." month", $check_reg_date));
$current_date=date('Y-m-d');

if($current_date>$exp_date){
  $updateusagestatus=$this->recruitment_employer_model->update_usage_status_expired();
}else{
    $updateusagestatus=$this->recruitment_employer_model->update_usage_status_on();

}


echo '<tbody><tr>';
echo '<td>'.date('F d Y', strtotime($paid_reg_date))." to ".date('F d Y', strtotime($exp_date)).'</td>';
echo '<td>'.$num_months.' months</td>';
echo '<td>'.$num_jobs.'</td>';
echo '<td>'.$orig_price.'</td>';
echo '<td>'.$disc_percent.'%  ('.number_format($less_amount,2).')</td>';
echo '<td>'.$discounted_amount.'</td>';
echo '<td>'.$is_vat_included_at_last_price.'</td>';
echo '<td>'.$vat_per.'%</td>';
echo '<td>'.number_format($vat_amount,2).'</td>';
echo '<td>'.number_format($my_gross,2).'</td>';
echo '<td>'.$payment_status.'</td>';

echo '</tr>';

echo '</tbody>
</table>



              </div></div>';


}
?>

          </div><!-- end cont -->

          <div class="col-sm-12">
            <div class="panel panel-danger" style="margin:5px;">
              <div class="panel-body">  
            Package Offers
<?php
if(!empty($rec_employer_bill_setting)){
?>
<table class="table">
<thead>
  <tr>
    <th>Customer Type</th>
    <th>Validity</th>
    <th>Jobs License</th>
    <th>Orig Price</th>
    <th>Discount %</th>
    <th>Discounted Price</th>
    <th>Vat Included already</th>
    <th>Vat Percentage</th>
    <th>Amount of Vat</th>
    <th>Gross</th>
    <th>Option</th>
  </tr>
</thead>
<?php
foreach($rec_employer_bill_setting as $bill_offers){

$customer=$bill_offers->customer_type;
$num_months=$bill_offers->no_of_months;
$num_jobs=$bill_offers->no_of_jobs;
$orig_price=$bill_offers->orig_price;
$disc_percent=$bill_offers->discount_percentage;

$vat_per=$bill_offers->vat_percentage;
$is_vat_included_at_last_price=$bill_offers->is_vat_included_at_last_price;

$less_amount = ($disc_percent / 100) * $orig_price;
$discounted_amount = $orig_price-$less_amount;
$vat_amount= ($vat_per / 100) * $discounted_amount;

if($is_vat_included_at_last_price=="no"){
  $gross=$discounted_amount+$vat_amount;
}else{
  $gross=$discounted_amount;//-$vat_amount
}

echo '<tbody><tr>';
echo '<td>'.$customer.' customers</td>';
echo '<td>'.$num_months.' months</td>';
echo '<td>'.$num_jobs.'</td>';
echo '<td>'.$orig_price.'</td>';
echo '<td>'.$disc_percent.'%  ('.number_format($less_amount,2).')</td>';
echo '<td>'.$discounted_amount.'</td>';
echo '<td>'.$is_vat_included_at_last_price.'</td>';
echo '<td>'.$vat_per.'%</td>';
echo '<td>'.number_format($vat_amount,2).'</td>';
echo '<td>'.number_format($gross,2).'</td>';
echo '<td>Subscribe - inquire the process</td>';

echo '</tr></tbody>';
}
?>
</table>
<?php
}else{

}

?>


              </div>  
            </div>
          </div>




<?php
}
//====================================================================================================End Recruitment Employer

  ?>


          <!-- ============================================================= --> 


  </div>
</section>
</div>



 <?php require_once(APPPATH.'views/include/footer.php');?>
    <!-- REQUIRED JS SCRIPTS -->
  <!-- Placed at the end of the document so the pages load faster --> 
<script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script> 
<script src="<?php echo base_url()?>public/app.min.js"></script> 
<!-- ChartJS 1.0.1 -->
<script src="<?php echo base_url()?>public/chartjs/Chart.js"></script>
<script src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>

<!-- ADDED JS SCRIPTS -->
<link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>public/plugins/datepicker/datepicker3.css">
    <script src="<?php echo base_url()?>public/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- ADDED JS SCRIPTS -->

<script type="text/javascript">
  //-----reminders-----//
    $('#reminder_table').DataTable({
      "paging": false,
      "searching": true,
      "bLengthChange": false,
      "columnDefs": [
        { "visible": false, "targets": 0 },
        { "orderable": false, "targets": 3 }
      ]
    });

    $("#add_reminder").click(function(){
      var reminder_desc = $("textarea#reminder_desc").val();
      var type          = $("select#type :selected").val();
      var start_date    = $("input#start_date").val();
      var end_date      = $("input#end_date").val();

      if(reminder_desc == '' || type == 'select type' || start_date == '' ||  end_date == ''){
        alert("Fill-out the missing fields");
      }else{
        $.ajax({
          url: '<?php echo base_url()?>app/dashboard/add_reminder/',
          type: "post",
          data: {reminder_desc:reminder_desc, type:type, start_date:start_date, end_date:end_date},
          success: function(data){
            location.reload();
          }
        });
        
      }
    });

    $("#reminder_table tbody").on('click', '#edit', function(){

      $('#reminder').hide();
      $('#reminder_edit').show();

      var data = $('#reminder_table').DataTable().row($(this).parents('tr')).data();

      $.ajax({
        type: 'post',
        data: {'id':data[0]},
        url: '<?php echo base_url()?>app/dashboard/get_reminder_edit/',
        dataType: 'json',
        success: function(data){
          var info = data.data[0];
          $('#reminder_id_edit').val(info.id);
          $('#reminder_desc_edit').val(info.reminder_desc);
          $('#start_date_edit').val(info.date_from);
          $('#end_date_edit').val(info.date_to);
          $('select#type_edit').val(info.type).trigger('change');

        }
      });
    });

    $("#update_reminder").click(function(){
      var id                  = $("input#reminder_id_edit").val();
      var reminder_desc_edit  = $("input#reminder_desc_edit").val();
      var type_edit           = $("select#type_edit :selected").val();
      var start_date_edit     = $("input#start_date_edit").val();
      var end_date_edit       = $("input#end_date_edit").val();

      if(reminder_desc_edit == '' || type_edit == 'select type' || start_date_edit == '' ||  end_date_edit == ''){
        alert("Fill-out the missing fields");
      }else{
        $.ajax({
          url: '<?php echo base_url()?>app/dashboard/edit_reminder/',
          type: "post",
          data: {id:id, reminder_desc_edit:reminder_desc_edit, type_edit:type_edit, start_date_edit:start_date_edit, end_date_edit:end_date_edit},
          success: function(data){
            location.reload();
          }
        });
      }
    });

    $("#reminder_table tbody").on('click', '#delete', function(){
      
      var data = $('#reminder_table').DataTable().row($(this).parents('tr')).data();

      if(confirm("Are you sure you want to delete reminder?")){

        var delete_data = {
          type: "post",
          url: "<?=site_url()?>app/dashboard/delete_reminder",
          data: {"id": data[0]},
          success: function(data){
            location.reload();
          }
        };

        $.ajax(delete_data);
      }
    });

    $('#reminder_status_table').DataTable({
      "ajax": '<?php echo base_url()?>app/dashboard/view_reminder_status',
      "paging": true,
      "searching": true,
      "ordering": false,
      //"bLengthChange": false,
      "columnDefs": [
        { "visible": false, "targets": 0 },
        { "width": "90%", "targets": 1 },
        { "width": "120%", "targets": 2 },
        { "width": "20%", "targets": 3 },
        { "width": "30%", "targets": 4 },
      ]
    });

    $("#add_reminder_status").click(function(){
      var status_name   = $("input#status_name").val();
      var status_desc   = $("textarea#status_desc").val();
      var status_color  = $("input#status_color").val();

      if(status_name == '' || status_desc == '' || status_color == ''){
        alert("Fill-out the missing fields");
      }else{
        $.ajax({
          url: '<?php echo base_url()?>app/dashboard/add_reminder_status/',
          type: "post",
          data: {status_name:status_name, status_desc:status_desc, status_color:status_color},
          success: function(data){
            alert('New Reminder Status Added');
            $('#reminder_status').show();
            $('#reminder_status_add').hide();
            $("input#status_name, textarea#status_desc, input#status_color").val('');
            $('#reminder_status_table').DataTable().ajax.reload();
          }
        });
      }
    });

    $("#reminder_status_table tbody").on('click', '#edit', function(){
      
      $('#reminder_status').hide();
      $('#reminder_status_edit').show();

      var data = $('#reminder_status_table').DataTable().row($(this).parents('tr')).data();

      $.ajax({
        type: 'post',
        data: {'id':data[0]},
        url: '<?php echo base_url()?>app/dashboard/get_reminder_status_edit/',
        dataType: 'json',
        success: function(data){
          var info = data.data[0];
          $("input#reminder_status_id_edit").val(info.id);
          $("input#status_name_edit").val(info.status_name);
          $("textarea#status_desc_edit").val(info.description);
          $("input#status_color_edit").val(info.color);
        }
      });
    });

    $("#update_reminder_status").click(function(){
      var id                  = $("input#reminder_status_id_edit").val();
      var status_name_edit    = $("input#status_name_edit").val();
      var description_edit    = $("textarea#status_desc_edit").val();
      var color_edit          = $("input#status_color_edit").val();

      if(status_name_edit == '' || description_edit == '' || color_edit == ''){
        alert("Fill-out the missing fields");
      }else{
        $.ajax({
          url: '<?php echo base_url()?>app/dashboard/edit_reminder_status/',
          type: "post",
          data: {id:id, status_name_edit:status_name_edit, description_edit:description_edit, color_edit:color_edit},
          success: function(data){
            alert('Reminder Status Updated');
            $('#reminder_status_edit').hide();
            $('#reminder_status').show();
            $("input#status_name_edit, textarea#status_desc_edit, input#status_color_edit").val('');
            $('#reminder_status_table').DataTable().ajax.reload();
          }
        });
      }
    });

    $("#reminder_status_table tbody").on('click', '#delete', function(){

      var data = $('#reminder_status_table').DataTable().row($(this).parents('tr')).data();

      if(confirm("Are you sure you want to delete status?")){

        var delete_data = {
          type: "post",
          url: "<?=site_url()?>app/dashboard/delete_reminder_status",
          data: {"id": data[0]},
          success: function(data){
            alert('Reminder Status Has Been Deleted');
            $('#reminder_status_table').DataTable().ajax.reload();
          }
        };
        $.ajax(delete_data);
      }
    });

    $("#reminder_status_table tbody").on('click', '#enable', function(){

      var data = $('#reminder_status_table').DataTable().row($(this).parents('tr')).data();

      if(confirm("Are you sure you want to delete reminder?")){
        var enable_status = {
          type: "post",
          url: "<?=site_url()?>app/dashboard/reminder_status_activate",
          data: {"id": data[0]},
          success: function(data){
            alert("Reminder Status has been enabled");
            $('#reminder_status_table').DataTable().ajax.reload();
          }
        };
        $.ajax(enable_status);
      }
    });

    $("#reminder_status_table tbody").on('click', '#disable', function(){

      var data = $('#reminder_status_table').DataTable().row($(this).parents('tr')).data();

      if(confirm("Are you sure you want to delete reminder?")){
        var disable_status = {
          type: "post",
          url: "<?=site_url()?>app/dashboard/reminder_status_inactivate",
          data: {"id": data[0]},
          success: function(data){
            alert("Reminder Status has been disabled");
            $('#reminder_status_table').DataTable().ajax.reload();

          }
        };
        $.ajax(disable_status);
        $("#status option[value="+data[0]+"]").remove();
        $(".css option[value="+data[0]+"]").remove();
      }
    });

    function update_status(id){
      $('.status_change_'+id).hide();
      $('#change_status_select_'+id).show();

      $('#change_status_select_'+id+', back_reminder').on('click', function(){
        $.ajax({
          type: "GET",
          url: "<?=site_url()?>app/dashboard/get_reminder_status_dropdown",
          success: function(data){
            $json = JSON.parse(data);

            $.each($json, function(i, value) {
                $('#change_status_select_'+id).append("<option value="+ value[0] +">"+ value[1] +"</option>");
            });

            var exist = {};
            $('#change_status_select_'+id+' option').each(function (){
              if (exist[this.value]) {
                  $(this).remove();
              }
              exist[this.value] = true;
            });
          }
        });
      });
    }

    function update_status_selected(id){
      
      var selected = [];
      $('#change_status_select_'+id).children('option:selected').each( function() {  
          var $this = $(this);
          selected.push( { text: $this.text(), value: $this.val() });
      });
      
      var selected_status = selected[0].value;

      $.ajax({
        url: '<?php echo base_url()?>app/dashboard/update_status/',
        type: "post",
        data: {id:id, selected_status:selected_status},
      });
      location.reload(true);
    }


    $("#add_reminder_table").click(function(){
      $('#reminder_add').show();
      $('#reminder').hide();
    });
    $('#add_reminder_status_table').click(function(){
      $('#reminder_status').hide();
      $('#reminder_status_add').show();
    });
    $('#view_reminder_status').click(function(){
      $('#reminder').hide();
      $('#reminder_status').show();
    });
    $('#back_reminder_status').click(function(){
      $('#reminder_status').hide();
      $('#reminder').show();
    });
    $('#back_reminder').click(function(){
      $("input#reminder_desc, input#start_date, input#end_date").val('');
      $('#reminder_add').hide();
      $('#reminder').show();
    });
    $('#back_reminder_status_add').click(function(){
      $("input#status_name, textarea#status_desc, input#status_color").val('');
      $('#reminder_status_add').hide();
      $('#reminder_status').show();
    });
    $('#cancel_update_reminder').click(function(){
      $('#reminder_edit').hide();
      $('#reminder').show();
    });
    $('#back_reminder_status_edit').click(function(){
      $('#reminder_status').show();
      $('#reminder_status_edit').hide();
    });
    
    $('#start_date_picker, #start_date_picker_edit').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      calendarWeeks: true,
      endDate: '+3y',         
      }).on('changeDate', function (selected) {
          var minDate = new Date(selected.date.valueOf());
          $('#end_date_picker, #end_date_picker_edit').datepicker('setStartDate', minDate);
          $('#end_date_picker, #end_date_picker_edit').datepicker('setDate', minDate);
    });

    $('#end_date_picker, #end_date_picker_edit').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      calendarWeeks: true,
      endDate: '+3y',               
    });
  //-----end reminders-----//


  //-----employment status-----//

  function show_employees(id, company_id){
    $("html, body").animate({ scrollTop: 0 }, "slow");

    $.ajax({
      url: '<?=base_url()?>app/dashboard/get_employees_by_contract_view/',
      type: "POST",
      data: {id:id, company_id:company_id},
      dataType: 'json',
      success: function(data) {
        window.open('<?=base_url()?>app/dashboard/view_esa_employees/'+id+'/'+company_id, "_blank", "width=900,height=600");
      }
    });
  }

  function get_contract_base(id){
    var data = id;
    $('#contract_alert_base_edit').show();
    $('.contract_status_table').hide();
    $("html, body").animate({ scrollTop: 0 }, "slow");
    $.ajax({
      type: "POST",
      data: {id: data},
      url: '<?=base_url()?>app/dashboard/get_employment_contract_base/',
      dataType: 'json',
      success: function(data){
            var info = data.data;
            if( $('.emp_label, .emp_contract_base').is(':empty') ){
              $("<label class='col-sm-3 control-label'>" +  info.employment_name + ": </label>").appendTo('.emp_label');

              $("<input type='hidden' name='edit_emp_id' id='edit_emp_id' class='form-control' value=" + info.employment_id + ">").appendTo('.emp_contract_base');

              $("<input type='input' name='edit_emp_contract_base' id='edit_emp_contract_base' class='form-control' value=" + info.contract_alert_base + ">").appendTo('.emp_contract_base');

            } else if($('.emp_label, .emp_contract_base').empty()){
              $("<label class='col-sm-3 control-label'>" +  info.employment_name + ": </label>").appendTo('.emp_label');

              $("<input type='hidden' name='edit_emp_id' id='edit_emp_id' class='form-control' value=" + info.employment_id + ">").appendTo('.emp_contract_base');

              $("<input type='input' name='edit_emp_contract_base' id='edit_emp_contract_base' class='form-control' value=" + info.contract_alert_base + ">").appendTo('.emp_contract_base');
            } else {
              $('.emp_label, .emp_contract_base').empty();
            }
        }
    });
  }

  $('#update_emp_contract_base').click(function(){
      var id                  = $("input#edit_emp_id").val();
      var emp_contract_base    = $("input#edit_emp_contract_base").val();

      if(emp_contract_base == ''){
        alert("Fill-out the missing fields");
      }else{
        $.ajax({
          url: '<?php echo base_url()?>app/dashboard/update_employment_contract_base/',
          type: "post",
          data: {id:id, emp_contract_base:emp_contract_base},
          success: function(data){
            location.reload();
          }
        });
      }
  });
  
  $('#cancel_emp_contract_base').click(function(){
    $('#contract_alert_base_edit').hide();
    $('.contract_status_table').show();
  });
  $('.close').click(function(){
    $('#employee_contract_view').removeClass('in');
  });
  //-----end employment status-----//


  //---------- employee movement --------//

  function show_movement_employees(id, company_id){
   $("html, body").animate({ scrollTop: 0 }, "slow");

    $.ajax({
      url: '<?=base_url()?>app/dashboard/get_employees_by_movement_view/',
      type: "POST",
      data: {id:id, company_id:company_id},
      dataType: 'json',
      success: function(data) {
        window.open('<?=base_url()?>app/dashboard/view_ema_employees/'+id+'/'+company_id, "_blank", "width=900,height=600");
      }
    });
  }

  function get_movement_base(id, company_id){
    var data = id;
    var data2 = company_id;
    $('#movement_alert_base_edit').show();
    $('.movement_type_table').hide();
    $("html, body").animate({ scrollTop: 0 }, "slow");
    $.ajax({
      type: "POST",
      data: {id: data, company_id:data2},
      url: '<?=base_url()?>app/dashboard/get_movement_alert_base/',
      dataType: 'json',
      success: function(data){
            var info = data.data;
            if( $('.move_label, .move_base, .company_label').is(':empty') ){
              $("<strong>" +  info.company_name + ": </strong>").appendTo('.company_label');

              $("<label class='col-sm-3 control-label'>" +  info.title + ": </label>").appendTo('.move_label');

              $("<input type='hidden' name='edit_move_id' id='edit_move_id' class='form-control' value=" + info.id + ">").appendTo('.move_base');

              $("<input type='hidden' name='edit_move_company_id' id='edit_move_company_id' class='form-control' value=" + info.company_id + ">").appendTo('.move_base');

              $("<input type='input' name='edit_move_base' id='edit_move_base' class='form-control' value=" + info.movement_alert_base + ">").appendTo('.move_base');

            } else if($('.move_label, .move_base, .company_label').empty()){
              $("<strong>" +  info.company_name + ": </strong>").appendTo('.company_label');

              $("<label class='col-sm-3 control-label'>" +  info.title + ": </label>").appendTo('.move_label');

              $("<input type='hidden' name='edit_move_id' id='edit_move_id' class='form-control' value=" + info.id + ">").appendTo('.move_base');

              $("<input type='hidden' name='edit_move_company_id' id='edit_move_company_id' class='form-control' value=" + info.company_id + ">").appendTo('.move_base');

              $("<input type='input' name='edit_move_base' id='edit_move_base' class='form-control' value=" + info.movement_alert_base + ">").appendTo('.move_base');
            } else {
              $('.move_label, .move_base').empty();
            }
        }
    });
  }

  $('#update_movement_base').click(function(){
      var id           = $("input#edit_move_id").val();
      var company_id   = $("input#edit_move_company_id").val();
      var move_base    = $("input#edit_move_base").val();

      if(move_base == ''){
        alert("Fill-out the missing fields");
      }else{
        $.ajax({
          url: '<?php echo base_url()?>app/dashboard/update_movement_alert_base/',
          type: "post",
          data: {id:id, move_base:move_base, company_id:company_id},
          success: function(data){
            location.reload();
          }
        });
      }
  });

  $('#cancel_movement_base').click(function(){
    $('#movement_alert_base_edit').hide();
    $('.movement_type_table').show();
  });

  //---------- employee movement --------//

</script>

<script>
      $(document).ready(function(){

        var ctx = $("#pieChart").get(0).getContext("2d");

        // pie chart data
        // sum of values = 360
        var data = [
<?php
foreach($companyList as $comp){

$company_id=$comp->company_id;
$count_emp=$this->dashboard_model->count_employee_per_company($company_id);
$array_items = count($count_emp);

echo '{
          value: '.$array_items.',
          color: "cornflowerblue",
          highlight: "lightskyblue",
          label: "'.$comp->company_name.'"

        },';
}

?>
     
        {
          value: <?Php echo $array_items_count_all_emp;?>,
          color: "red",
          highlight: "darkorange",
          label: "MIS"

        }
        ];

        // draw
        var piechart = new Chart(ctx).Pie(data);

        var ctx = $("#pieChart2").get(0).getContext("2d");

        // pie chart data
        // sum of values = 360
        var data = [
        {
          value: 120,
          color: "cornflowerblue",
          highlight: "lightskyblue",
          label: "Manpower"

        },
        {
          value: 63,
          color: "lightgreen",
          highlight: "yellowgreen",
          label: "Engineering"

        },
        {
          value: 52,
          color: "orange",
          highlight: "darkorange",
          label: "MIS"

        }
        ];

        // draw
        var piechart = new Chart(ctx).Pie(data);

      });

      // set the date we're counting down to
      var target_date = new Date('May, 05, 2016').getTime();
       
      // variables for time units
      var days, hours, minutes, seconds;
       
      // get tag element
      var countdown = document.getElementById('countdown');
       
      // update the tag with id "countdown" every 1 second
      setInterval(function () {
       
          // find the amount of "seconds" between now and target
          var current_date = new Date().getTime();
          var seconds_left = (target_date - current_date) / 1000;
       
          // do some time calculations
          days = parseInt(seconds_left / 86400);
          seconds_left = seconds_left % 86400;
           
          hours = parseInt(seconds_left / 3600);
          seconds_left = seconds_left % 3600;
           
          minutes = parseInt(seconds_left / 60);
          seconds = parseInt(seconds_left % 60);
           
          // format countdown string + set tag value
          countdown.innerHTML = '<span class="days">' + days +  ' <b>Days</b></span> <span class="hours">' + hours + ' <b>Hours</b></span> <span class="minutes">'
          + minutes + ' <b>Minutes</b></span> <span class="seconds">' + seconds + ' <b>Seconds</b></span>';  
       
      }, 1000);

    </script>

  </body>

    <style type="text/css">
      .show-calendar{
        width:50%;
      }
    </style>

</html>