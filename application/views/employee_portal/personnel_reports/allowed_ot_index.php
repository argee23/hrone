<br><br><br>
<div>
    <!-- Start of Side View -->
    <div class="col-md-3">
      <div class="panel box box-default" style="height:400px;">
        <div class="panel-heading"><h4>Personnel Approved Overtime<span class="pull-right"><i class="fa fa-gear"></i></span></h4></div>
        <div class="panel-body  fixed-panel-side mCustomScrollbar" data-mcs-theme="dark"">
          <ul class="nav nav-pills nav-stacked">
               <li><a style="cursor:pointer;" onclick="view_crystal_report('approved_ot','default');"><i class='fa fa-circle-o'></i> <span>Default Crystal Reports</span></a></li>
              <li><a style="cursor:pointer;" onclick="view_crystal_report('approved_ot','sys');"><i class='fa fa-circle-o'></i> <span>Manage Crystal Reports</span></a></li>
              <li><a style="cursor:pointer;" onclick="view_pao_generate_reports('approved_ot');"><i class='fa fa-circle-o'></i> <span>Generate Reports</span></a></li>
             
          </ul>
          <input type="hidden" id="overtime_filing_type" value="<?php echo $overtime_filing_type; ?>">
        </div>
      </div>
     
    </div>

  <div class="col-md-9" style="padding-bottom: 50px;height: auto;">
      <div class="box box-success">
        <div class="panel panel-info">
              <div class="col-md-12" id="main_res" style="height: auto;">
                  <div style="height: 490px;"></div>
              </div>
              <div class="btn-group-vertical btn-block"> </div>   
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
    
<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
<script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>public/plugins/buttons/css/buttons.dataTables.min.css">
<script src="<?php echo base_url()?>public/plugins/buttons/js/dataTables.buttons.min.js"></script>    
<script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.flash.min.js"></script>    
<script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.html5.js"></script>    
<script src="<?php echo base_url()?>public/plugins/buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url()?>public/plugins/jszip/jszip.min.js"></script> 
    
<?php require_once(APPPATH.'views/employee_portal/personnel_reports/js_functions.php');?>

