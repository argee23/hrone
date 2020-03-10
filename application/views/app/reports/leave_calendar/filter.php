

  <div class="box box-success">
      <div class="col-md-12" style="padding-top: 30px;" id="all_action">
            
          <div id="calendarss" style="height:auto;" class="col-md-12">
          </div>
          <div class="col-md-12" style="margin-top: 10px;">
         <label><i><n class="text-danger">Note: Click employee name to view details.</n><br>
             <?php 
                    $get_leavetype = $this->reports_leave_calendar_model->get_leave_type($company_id);?>
                    <table class="col-md-6 table table-hover">
                        <thead>
                        </thead>
                        <tbody>
                            <tr>
                                <td><n class="text-danger"><b>Leave Type</b></n></td>
                                <?php foreach ($get_leavetype as $k) {?>
                                  <td><?php echo $k->leave_type;?></td>
                                <?php } ?>
                            </tr>
                             <tr>
                                <td><n class="text-danger"><b>Color Code</b></n></td>
                                <?php foreach ($get_leavetype as $k) {?>
                                  <td><input type="color" value="<?php if($k->is_system_default==1) { echo '#00BFFF'; } else{ echo $k->color_code; }?>" style='width:100%;'></td>
                                <?php } ?>
                            </tr>
                        </tbody>
                    </table>
                 
                
        </n></i></label>
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

