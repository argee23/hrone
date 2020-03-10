     <?php require_once(APPPATH.'views/include/calendar.php');?>

    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/app.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
    <script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
    <script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script>  
    <!-- Start Content Wrapper. Contains page content -->
    <div class="content-wrapper2">
    <!-- Start Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <br>
          Reports
           <small>Working Schedule Report</small>
        </h1>
       <ol class="breadcrumb">
          <br>
          <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="">Reports</a></li>
          <li class="active">Working Schedule Reports</li>
        </ol>
      </section>
     <div class="col-md-3" style="padding-bottom: 50px;margin-top: 10px;"> 
      <div class="box box-success box-solid">
              
            <div class="box-body" id="quickview">  


                <ul class="nav nav-pills nav-stacked">  
                    <li class="bg-success">CRYSTAL REPORT</li>
                    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="show_hide('calendar_indi');"><i class='fa fa-list'></i> Individual Report <span></span></a></li>
                       
                        <div id="calendar_indi" style="display:none;";>
                           <li class="list-group-item"  id="setting_div">
                            <input type="text" class="form-control" name="employee_name" id="employee_name" placeholder="Select Employee" onclick="calendar_individual_report('calendar');">
                          </li>
                        </div>

                    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="show_hide('calendar_by_dept');"><i class='fa fa-list'></i> By Department <span></span></a></li>
                   
                         <div id="calendar_by_dept" style="display: none";>
                          <?php foreach($departmentList as $dep){?>
                            <li class="list-group-item"  id="setting_div">
                              <a style="cursor: pointer;margin-left: 30px;" onclick="get_schedules_result('<?php echo $dep->department_id;?>','by_department','All');"><?php echo $dep->dept_name;?></a>
                            </li>
                          <?php } ?>
                        </div>

                     <?php if(count($sectionGroup) > 0){?>
                    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="show_hide('calendar_by_sectionmanagergroup');"><i class='fa fa-list'></i> Section Manager Group <span></span></a></li>
                        
                        <div id="calendar_by_sectionmanagergroup" style="display:none;";>
                        <?php foreach($sectionGroup as $grp){?>
                          <li class="list-group-item"  id="setting_div">
                            <a style="cursor: pointer;margin-left: 30px;" onclick="get_schedules_result('<?php echo $grp->id;?>','sectionmngr_grp','All');"><?php echo $grp->group_name;?></a>
                          </li>
                        <?php } ?>
                      </div>

                    <?php } ?>  



                    <li class="bg-success">EXCEL REPORT</li>
                    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="excel_report_payroll_period();"><i class='fa fa-list'></i> By Payroll Period Group<span></span></a></li>
                    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="show_hide('excel_by_sectionmanagergroup');"><i class='fa fa-list'></i> Section Manager Group<span></span></a></li>
                        <div id="excel_by_sectionmanagergroup" style="display:none;";>
                        <?php foreach($sectionGroup as $grp){?>
                          <li class="list-group-item"  id="setting_div">
                            <a style="cursor: pointer;margin-left: 30px;" onclick="excel_report_sectionmngr('<?php echo $grp->id;?>');"> <?php echo $grp->group_name;?></a>
                          </li>
                        <?php } ?>
                      </div>
                    <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="show_hide('excel_by_dept');"><i class='fa fa-list'></i> By Department<span></span></a></li>
                    <div id="excel_by_dept" style="display: none";>
                    <?php foreach($departmentList as $dep){?>
                      <li class="list-group-item"  id="setting_div">
                        <a style="cursor: pointer;margin-left: 30px;" onclick="excel_report_department('<?php echo $dep->department_id;?>');"><?php echo $dep->dept_name;?></a>
                      </li>
                    <?php } ?>
                  </div>


                   <li class="bg-success">EXCEL CRYSTAL REPORT <br><i class="text-danger">(individual plotted schedule only)</i></li>
                   <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="crystal_report_view();"><i class='fa fa-list'></i>Manage Crystal Report<span></span></a></li>
                   <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="crystal_report_generate_date_range();"><i class='fa fa-list'></i>Date Range Report<span></span></a></li>
                   <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="crystal_report_generate_payroll_period();"><i class='fa fa-list'></i>Payroll Period Report<span></span></a></li>
                   <li> <a  style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" onclick="crystal_report_generate_employment();"><i class='fa fa-list'></i>Employment Details Report<span></span></a></li>
                   
                </ul>

            </div>

      </div>
    </div> 

  <div class="col-md-9" style="padding-bottom: 50px;padding-top: 10px;" > 
    <div class="box box-success">
      <div class="col-md-12">
          <ul class="nav nav-tabs">
              <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i>Generate Reports</b></n></a></li>
          </ul>
      </div>
      <div class="col-md-12" style="padding-top: 30px;" id="all_action">
              <div class="col-md-3"></div>
              <div class="col-md-6">
                      <select class="col-md-12 form-control" onchange="get_schedules_filter(this.value);" id="show_opt" style="display: none;"> 
                        <option value="All">All</option>
                        <option value="restday">Restday</option>
                        <option value="with_sched">With Schedule</option>
                      </select>
              </div>
              

            <div class="col-md-12" id="main_action" style="margin-top: 30px;">
            </div>
    </div>

      <div class="panel panel-info">
            <div class="col-md-12" id="fetch_all_result" style="padding-bottom: 10px;"><br>
              <div class="col-md-12">
              </div>
            </div>
            <div class="btn-group-vertical btn-block"> </div> 
      </div>             
    </div> 
  </div> 
  
      <!-- Modal 2 -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-lg">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><n id="details_date"></n></h4>
        <span><h5 id="status_datetime"></h5></span>
        <span id="status_icon"></span>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12" id="schedule_details_modal">  
              
          </div>
        </div>
      </div>
      <div id="status_buttons" class="modal-footer bg-info">
      <button class="btn btn-success" data-dismiss="modal" aria-hidden="true">CLOSE</button>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-primary fade" id="search_employee_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Select Employees</h4>
                  </div>
                 <div class="modal-body">                             
                    <input onKeyUp="employee_list(this.value)" class="form-control input-sm" name="cSearch" id="cSearch" type="text" placeholder="Search here">
                    <span id="Search_Employee_Result"></span>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>                          
            </div>
        </div>
    </div>
    
  
   <?php   require_once(APPPATH.'views/employee_portal/report_personnel/schedule/js_functions.php'); ?>

   <style>

     .modal {
text-align: center;
padding: 0!important;
}

.modal:before {
content: '';
display: inline-block;
height: 100%;
vertical-align: middle;
margin-right: -300px;
}

.modal-dialog {
display: inline-block;
text-align: left;
vertical-align: middle;
}

   </style>