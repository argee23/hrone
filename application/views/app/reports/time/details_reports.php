
<?php $rep_type=$this->uri->segment('4')?>
<br> <ol class="breadcrumb">
                <h4 class="text-default" style="font-weight: bold;"><i class="fa fa-bars"></i>Add Working Schedule Reports</h4>
            </ol><br>
            <h3 class="text-success" style="font-weight: bold;text-align: center;">Report Information</h3>
            <div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px;" >
                <?php //foreach ($details_report as $row) {?>
                  
                <div class="col-md-5" >
                  <div class="col-md-5"><n>Report Name : </n></div>
                  <div class="col-md-7"><input type="text" name="report_name" id="report_name" class="form-control" value="<?php echo $details_report->report_name?>" readonly></div>
                </div>

                <div class="col-md-7">
                  <div class="col-md-5"><n>Report Description : </n></div>
                  <div class="col-md-7"><input type="text" name="report_desc" id="report_desc" class="form-control" value="<?php echo $details_report->report_desc?>" readonly></div>
                </div>
                <?php //} ?>
                <br>
                <div class="col-md-12" style="padding-top: 20px;">
                <div class="box box-default"></div>
                  <h4><center><n class="text-danger">Check the fields you want to view in printing reports</n></center></h4>

                  <?php foreach ($crystal_report as $rowss) {

                   if($rep_type=="time_summary"){

                      if($rowss->field_name=="date" OR $rowss->field_name=="mm" OR $rowss->field_name=="dd" OR $rowss->field_name=="yy"){
                        //echo "dont show date mm dd yy";
                      }else{
                        ?>
                  <div class="col-md-4">
                      
                      <div class="col-md-1">
                        <input type="checkbox" class="option" name="<?php echo $rowss->report_time_id?>"
                         id="<?php echo $rowss->report_time_id?>" value="<?php echo $rowss->report_time_id?>" 
                         <?php foreach($details_report_fields as $roww) { if($roww->report_time_id == $rowss->report_time_id) { echo "checked";} else{}}?> disabled >
                      </div>
                      <div class="col-md-9"><?php echo $rowss->title?>: </div>
                  </div>


                        <?php

                      }

                  }else{
                    ?>
                
                  <div class="col-md-4">
                      
                      <div class="col-md-1">
                        <input type="checkbox" class="option" name="<?php echo $rowss->report_time_id?>"
                         id="<?php echo $rowss->report_time_id?>" value="<?php echo $rowss->report_time_id?>" 
                         <?php foreach($details_report_fields as $roww) { if($roww->report_time_id == $rowss->report_time_id) { echo "checked";} else{}}?> disabled >
                      </div>
                      <div class="col-md-9"><?php echo $rowss->title?>: </div>
                  </div>




                 <?php 

                   }

                 } ?>
                
                <div class="col-md-12" style="padding-top: 20px;">
                <div class="box box-default"></div>
                  <button class="btn btn-info pull-right" onclick="report_list('<?php echo $this->uri->segment('4')?>')">BACK</button>
                  <button class="btn btn-success pull-right" style="margin-left: 4px;margin-right: 4px;" onclick="updateReport('<?php echo $details_report->report_type.'/'.$details_report->report_id?>')">UPDATE</button>
                </div>
            </div>


           