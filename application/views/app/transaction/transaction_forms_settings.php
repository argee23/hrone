
  
  <div class="col-md-12" style="padding-bottom: 50px;"  id="fetch_all_result">
      <div class="panel panel-info">

          <div class="col-md-4" style="padding-top: 30px;">
          
            <br>
                  <div class="col-md-12">
                  <label>Company</label>
                  </div>
                  <div class="col-md-12">
                    <select class="form-control" id="settings_company" onchange="get_setting_action(this.value);">
                      <?php if(count($companyList)==0){?>
                        <option value="">No company found.</option>
                      <?php } else{?>
                        <option value="">Select Company</option>
                        <option value="all">All</option>
                      <?php foreach($companyList as $comp) { ?>

                        <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>

                        <?php }} ?>
                    </select>
                  </div>
                    <div class="col-md-12" style="padding-top: 10px;">
                  <label>Options</label>
                  </div>
                  <div class="col-md-12" style="padding-top: 10px;">
                    <select class="form-control" id="settings_options" onchange="get_transactions_setting(this.value);">
                      <option value="" selected>Select Setting Option</option>
                      <?php foreach($settings as $sett){?>
                      <option value="<?php echo $sett->code;?>"><?php echo $sett->settings;?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="col-md-12" style="padding-top: 10px;">
                  <label>Transactions</label>
                  </div>
                  <div class="col-md-12" style="padding-top: 10px;">
                    <select class="form-control" id="settings_transactions" onchange="updatesettings(this.value);">
                     
                    </select>
                  </div>

                  <div class="col-md-12" style="padding-top: 10px;" id="settings_leavem" >
                  <label>Leave Type</label>
                  </div>
                  <div class="col-md-12" style="padding-top: 10px;">
                    <select class="form-control" id="settings_leave" onchange="update_settings_leave(this.value);">
                     
                    </select>
                  </div>

            
                  <div class="col-md-12" style="padding-top: 30px;">
                    <i class="text-danger">You can apply the selected options to all company transactions by checking the checkbox.</i>
                  </div>
          </div>

          <div class="col-md-8" id="settings_action"><br><br>
                  <table class="table table-bordered" id="blocked_leave"  style="margin-top:20px;">
                      <thead>
                        <tr class="danger">
                          <th> No.</th>
                          <th>Company Name</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
            </div>


           <div class="btn-group-vertical btn-block"> </div>
      </div> 
    </div>
</div>
</div>