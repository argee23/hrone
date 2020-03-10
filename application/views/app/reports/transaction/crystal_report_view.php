
<br> <ol class="breadcrumb">
                <h4 class="text-default" style="font-weight: bold;"><i class="fa fa-bars"></i><?php echo $trans->form_name?> Reports</h4>
            </ol>
            <h3 class="text-success" style="font-weight: bold;text-align: center;">Report Information</h3>
            <div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px;" >
              <input type="hidden" name="transaction_name" id="transaction_name" value="<?php echo $trans->form_name;?>">
                <div class="col-md-5" >
                  <div class="col-md-5"><n>Report Name : </n></div>
                  <div class="col-md-7"><n class="text-danger"><u><?php if(!empty($details->title)){ echo $details->title;}?></u></n></div>
                </div>

                <div class="col-md-7">
                  <div class="col-md-5"><n>Report Description : </n></div>
                  <div class="col-md-7"><n class="text-danger"><u><?php if(!empty($details->description)){ echo $details->description;}?></u></n></div>
                </div>
                <br><input type="hidden" name="transaction_id" id="transaction_id" value="<?php echo $trans->id;?>">
                <div class="col-md-12" style="padding-top: 20px;">
                <div class="box box-default"></div>
          

                 <h4><center><n class="text-danger">Check the fields you want to view in printing reports</n></center></h4>
              <?php  $i=0; foreach($transaction_field as $row) { 
                $checked=$this->report_transaction->crystal_report_details_fields($id,$row->crystal_report_transaction_id);
                if(count($checked) > 0){ $ch = 'checked'; } else{ $ch=''; }
                ?>
               <div class="col-md-4">
                      <div class="col-md-9"><?php echo $row->udf_label?></div>
                      <div class="col-md-1"><input type="checkbox" class="option" name="<?php echo $row->crystal_report_transaction_id?>" id="<?php echo $row->crystal_report_transaction_id?>" value="<?php echo $row->crystal_report_transaction_id?>" disabled <?php echo $ch;?>></div>
                  </div>
              <?php  $i = $i + 1; } echo "<input type='hidden' id='crystal_fields' value='".$i."'>";?>
              


                <div class="col-md-12" style="padding-top: 20px;padding-bottom: 20px;">
                 <div class="box box-default"></div>
                  <button class="btn btn-info pull-right" onclick="get_crystal_reports_list()">BACK</button>
                </div>
            </div>


           