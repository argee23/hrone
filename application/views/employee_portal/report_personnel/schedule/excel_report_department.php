<?php 
  $date = date('Y-m-d');
  $days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
  $month_from = date('Y').'-'.date('m').'-'.'01';
  $month_to = date('Y').'-'.date('m').'-'.$days;

?>
<form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>employee_portal/reports_personnel_schedule/excel_report_department_result" target="_blank">
<div class="col-md-12">    
<div class="col-md-12" id="filtering_rf_">

         <div class="col-md-12" style="margin-top: 10px;">
          <div class="col-md-3">  
              <label class="pull-right">Report Title</label> 
          </div>
          <div class="col-md-6">
            <input type="text" class="form-control" id="title"   name="title"  value="">
          </div>
        </div>

        <div class="col-md-12" style="margin-top: 10px;">
          <div class="col-md-3">  
              <label class="pull-right">Option</label> 
          </div>
          <div class="col-md-6">
           <select class="form-control" name="option" id="option">
              <option value="schedule">Schedule</option>
              <option value="attendance">Attendance</option>
              <option value="all">Schedule & Attendance</option>
           </select>
          </div>
        </div>

        <div class="col-md-12" style="margin-top: 10px;">
          <div class="col-md-3">  
              <label class="pull-right">Date Range</label> 
          </div>
          <div class="col-md-3">
            <input type="date" class="form-control" id="res_datefrom"   name="res_datefrom"  value="<?php echo $month_from;?>">
          </div>
          <div class="col-md-3">
            <input type="date" class="form-control" id="res_dateto"  name="res_dateto" value="<?php echo $month_to;?>">
          </div>
        </div>

       

         <div class="col-md-12" style="margin-top: 5px;">
         <div class="col-md-3">  
              <label class="pull-right">Select Fields</label> 
          </div>
                      <div class="col-md-6">
                        <div class="panel panel-default" style="height: 150px;overflow: scroll;">
                          <div class="panel-heading">
                            <n class="text-danger"><b><center>Select fields you want to view in your report</center></b></n>
                          </div>
                          <div class="col-md-12" style="margin-top: 5px;">
                            <?php foreach($fields as $f){ if($f->field=='employee_id'){ $c='checked'; $d='disabled'; } else{ $c=''; $d=''; }?>
                                <div class="col-md-6">
                                 <input class="field_checker" type="checkbox" <?php echo $c.' '.$d;?> value='<?php echo $f->id;?>' onclick="get_field('<?php echo $f->field;?>','<?php echo $f->id;?>');" id='<?php echo $f->id;?>' > <?php echo $f->title;?>
                                </div>
                            <?php } ?>

                          </div>
                        </div>
                      </div>
                    </div>
                    <input type='hidden' name='final_report' id='final_report' value="1-" value="">
                    <input type='hidden' name='count' id='count' value="<?php echo count($fields);?>">
                    <input type='hidden' name='department_id' id='department_id' value="<?php echo $department_id;?>">
        
        <div class="col-md-12" style="margin-top: 10px;">
          <div class="col-md-3"></div>
          <div class="col-md-6"><button class="col-md-12 btn btn-success" >GENERATE REPORT</button></div>
        </div>
<div class="col-md-12">
<br><br>
  <div class="box box-danger" class='col-md-12'></div>
</div>
</div>

</div>
</form>



