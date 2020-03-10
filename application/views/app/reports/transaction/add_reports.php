
<br> <ol class="breadcrumb">
                <h4 class="text-default" style="font-weight: bold;"><i class="fa fa-bars"></i>Add <?php echo $trans->form_name?> Reports</h4>
            </ol>
            <h3 class="text-success" style="font-weight: bold;text-align: center;">Report Information</h3>
            <div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px;" >
              <input type="hidden" name="transaction_name" id="transaction_name" value="<?php echo $trans->form_name;?>">
                <div class="col-md-5" >
                  <div class="col-md-5"><n>Report Name : </n></div>
                  <div class="col-md-7">
                      <input type="text" name="report_name" id="report_name" class="form-control">
                      <input type="hidden" name="report_name" id="reportname" class="form-control">
                  </div>
                </div>

                <div class="col-md-7">
                  <div class="col-md-5"><n>Report Description : </n></div>
                  <div class="col-md-7">
                      <input type="text" name="report_desc" id="report_desc" class="form-control">
                      <input type="hidden" name="report_desc" id="reportdesc" class="form-control">
                  </div>
                </div>
                <br><input type="hidden" name="transaction_id" id="transaction_id" value="<?php echo $trans->id;?>">
                <div class="col-md-12" style="padding-top: 20px;">
                <div class="box box-default"></div>
          

                 <h4><center><n class="text-danger">Check the fields you want to view in printing reports</n></center></h4>
              <?php  $i=0; foreach($transaction_field as $row) { ?>
               <div class="col-md-4">
                      <div class="col-md-9"><?php echo $row->udf_label?></div>
                      <div class="col-md-1"><input type="checkbox" class="option" name="<?php echo $row->crystal_report_transaction_id?>" id="<?php echo $row->crystal_report_transaction_id?>" value="<?php echo $row->crystal_report_transaction_id?>"></div>
                  </div>
              <?php  $i = $i + 1; } echo "<input type='hidden' id='crystal_fields' value='".$i."'>";?>
              


                <div class="col-md-12" style="padding-top: 20px;padding-bottom: 20px;">
                 <div class="box box-default"></div>
                  <button class="btn btn-info pull-right" onclick="get_crystal_reports_list()">BACK</button>
                  <button class="btn btn-success pull-right" style="margin-left: 4px;margin-right: 4px;" onclick="save_report('<?php echo $company;?>','<?php echo $transaction;?>','<?php echo $type;?>');">SAVE</button>
                  <button class="btn btn-danger pull-right" style="margin-left: 4px;margin-right: 4px;"  onclick="reset();">UNCHECK ALL</button>
                   <button class="btn btn-default pull-right" style="margin-left: 4px;margin-right: 4px;"  onclick="checkAll();">CHECK ALL</button>
                </div>
            </div>


           