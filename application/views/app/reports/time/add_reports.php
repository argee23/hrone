
<?php $rep_type=$this->uri->segment('4')?>
<input type="hidden" name="report_type" id="report_type" class="form-control" value="<?php echo $rep_type?>">
<br> <ol class="breadcrumb">
                <h4 class="text-default" style="font-weight: bold;"><i class="fa fa-bars"></i>Add Working Schedule Reports</h4>
            </ol>
            <h3 class="text-success" style="font-weight: bold;text-align: center;">Report Information</h3>
            <div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px;" >
                <div class="col-md-5" >
                  <div class="col-md-5"><n>Report Name : </n></div>
                  <div class="col-md-7"><input type="text" name="report_name" id="report_name" class="form-control"></div>
                </div>

                <div class="col-md-7">
                  <div class="col-md-5"><n>Report Description : </n></div>
                  <div class="col-md-7"><input type="text" name="report_desc" id="report_desc" class="form-control"></div>
                </div>
                <br>
                <div class="col-md-12" style="padding-top: 20px;">
                <div class="box box-default"></div>
                <h4><center><n class="text-danger">Check the fields you want to view in printing reports</n></center></h4>
                <?php
                  $i=0;  foreach ($crystal_report as $row) { 

                    if($rep_type=="time_summary"){

                      if($row->field_name=="date" OR $row->field_name=="mm" OR $row->field_name=="dd" OR $row->field_name=="yy"){
                        //echo "dont show date mm dd yy";
                      }else{

                ?>    
                  <div class="col-md-4">
                      <div class="col-md-1"><input type="checkbox" class="option" name="<?php echo $row->field_name?>" id="<?php echo $row->field_name?>" value="<?php echo $row->report_time_id?>"></div>

                      <div class="col-md-9"><?php echo $row->title?> : </div>
                  </div>
                <?php
                $i = $i + 1; 
                    }

                    }else{


                    ?>

                  <div class="col-md-4">
                      <div class="col-md-1"><input type="checkbox" class="option" name="<?php echo $row->field_name?>" id="<?php echo $row->field_name?>" value="<?php echo $row->report_time_id?>"></div>

                      <div class="col-md-9"><?php echo $row->title?> : </div>
                  </div>
                <?php $i = $i + 1; 
                    }

                } echo "<input type='hidden' id='crystal_fields' value='".$i."'>";?>

                <?php 


                ?>



                <div class="col-md-12" style="padding-top: 20px;padding-bottom: 20px;">
                 <div class="box box-default"></div>
                  <button class="btn btn-info pull-right" onclick="report_list('<?php echo $rep_type?>')">BACK</button>
                  <button class="btn btn-success pull-right" style="margin-left: 4px;margin-right: 4px;" onclick="save_report();">SAVE</button>
                  <button class="btn btn-danger pull-right" style="margin-left: 4px;margin-right: 4px;"  onclick="reset();">UNCHECK ALL</button>
                   <button class="btn btn-default pull-right" style="margin-left: 4px;margin-right: 4px;"  onclick="checkAll();">CHECK ALL</button>
                </div>
            </div>


           