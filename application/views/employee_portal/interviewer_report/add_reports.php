
<br> <ol class="breadcrumb">
                <h4 class="text-default" style="font-weight: bold;"><center>Add Crystal Reports</center></h4>
            </ol>
            
            <div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px;" >
                <div class="col-md-5" >
                  <div class="col-md-5"><n>Report Name : </n></div>
                  <div class="col-md-7">
                      <input type="text" name="report_name" id="report_name" class="form-control">
                      <input type="hidden" name="rname" id="rname" class="form-control">
                  </div>
                </div>

                <div class="col-md-7">
                  <div class="col-md-5"><n>Report Description : </n></div>
                  <div class="col-md-7">
                      <input type="text" name="report_desc" id="report_desc" class="form-control">
                      <input type="hidden" name="rdesc" id="rdesc" class="form-control">
                  </div>
                </div>
               
                <div class="col-md-12" style="padding-top: 20px;">
                <div class="box box-default"></div>
          

                 <h4><center><n class="text-danger">Check the fields you want to view in printing reports</n></center></h4>
              <?php  $i=0; foreach($transaction_field as $row) { ?>
               <div class="col-md-4">
                      <div class="col-md-9"><?php echo $row->label?></div>
                      <div class="col-md-1"><input type="checkbox" class="option" name="<?php echo $row->field?>" id="<?php echo $row->field?>" value="<?php echo $row->id?>"></div>
                  </div>
              <?php  $i = $i + 1; } echo "<input type='hidden' id='crystal_fields' value='".$i."'>";?>
              


                <div class="col-md-12" style="padding-top: 20px;padding-bottom: 20px;">
                 <div class="box box-default"></div>
                  <button class="btn btn-info pull-right" onclick="location.reload();">BACK</button>
                  <button class="btn btn-success pull-right" style="margin-left: 4px;margin-right: 4px;" onclick="save_report();">SAVE</button>
                  <button class="btn btn-danger pull-right" style="margin-left: 4px;margin-right: 4px;"  onclick="reset();">UNCHECK ALL</button>
                   <button class="btn btn-default pull-right" style="margin-left: 4px;margin-right: 4px;"  onclick="checkAll();">CHECK ALL</button>
                </div>
            </div>


           