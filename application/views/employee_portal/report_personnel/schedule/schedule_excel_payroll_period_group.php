
            <div class="col-md-12" id="crystal_report_action" style="margin-top: 30px;">
              <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>employee_portal/reports_personnel_schedule/excel_payroll_period_report" target="_blank">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="col-md-6">
                          <div class="col-md-12">
                            <select class="form-control" name="company" id="company" required>
                              <option value="" disabled selected >Select Company</option>
                                  <?php foreach($company as $c){?>
                                        <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                                  <?php } ?>
                            </select>
                          </div>
                          <div class="col-md-12" style="margin-top: 5px;">
                              <select class="form-control" name="group" id="group" onchange="get_excel_payroll_period(this.value);" required>
                                <option value="" disabled selected >Select Group</option>
                              </select>
                          </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="col-md-12">
                          <select class="form-control" name="paytype" id="paytype" onchange="get_excel_manual_ws_get_group(this.value);" required>
                              <option value="" disabled selected >Select PayType</option>
                              <?php foreach($paytypeList as $p){?>
                              <option value="<?php echo $p->pay_type_id;?>"><?php echo $p->pay_type_name;?></option>
                                <?php } ?>
                          </select>
                        </div>
                        <div class="col-md-12" style="margin-top: 5px;">
                          <select class="form-control" name="payroll_period" id="payroll_period" required>
                              <option value="" disabled selected >Select Payroll  Period</option>
                          </select>
                        </div>
                    </div>
                    
                    <div class="col-md-12" style="margin-top: 5px;">
                      <div class="col-md-12">
                        <div class="panel panel-default" style="height: 150px;overflow: scroll;">
                          <div class="panel-heading">
                            <n class="text-danger"><b><center>Select fields you want to view in your report</center></b></n>
                          </div>
                          <div class="col-md-12" style="margin-top: 5px;">
                            <?php foreach($fields as $f){ if($f->field=='employee_id'){ $c='checked'; $d='disabled'; } else{ $c=''; $d=''; }?>
                                <div class="col-md-4">
                                 <input class="field_checker" type="checkbox" <?php echo $c.' '.$d;?> value='<?php echo $f->id;?>' onclick="get_field('<?php echo $f->field;?>','<?php echo $f->id;?>');" id='<?php echo $f->id;?>' > <?php echo $f->title;?>
                                </div>
                            <?php } ?>
                            <input type='hidden' name='final_report' id='final_report' value="1-" value="">
                            <input type='hidden' name='count' id='count' value="<?php echo count($fields);?>">
                          </div>
                        </div>
                      </div>
                    </div>
                     <div class="col-md-12" style="margin-top: 5px;">
                      <div class="col-md-12">
                        <select class="col-md-12 form-control" id="option" name="option">
                            <option value="schedule">Schedule</option>
                            <option value="attendance">Attendance</option>
                            <option value="all">Schedule & Attendance</option>
                        </select>
                      </div>
                     </div>
                    <div class="col-md-12">
                      <div class="col-md-12" style="margin-top: 5px;">
                          <button class="col-md-12 btn btn-success" type="submit">FILTER</button> 
                        </div>
                      </div>
                </div>
                <div class="col-md-1"></div>
            </form>


            </div>
      </div>
     


   