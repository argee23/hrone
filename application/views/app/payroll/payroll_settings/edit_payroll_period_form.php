 <div class="col-md-6">
                       <div class="col-md-12" style="padding-top: 2px;"> 
                         <div class="col-md-5"><label>Pay Type</label></div>
                          <div class="col-md-7">
                            <n class="text-danger"><?php foreach($payroll_details as $row){  echo $paytype=$row->pay_type_name;  }?></n>
                          </div>
                        </div>

                         <div class="col-md-12" style="padding-top: 2px;" > 
                            <div class="col-md-5"><label>Employee Group</label></div>
                            <div class="col-md-7">
                              <n class="text-danger"><?php foreach($payroll_details as $row){  echo $group_name=$row->group_name; }?></n>
                            </div>
                          </div>

                          <div class="col-md-12" style="padding-top: 2px;" id="edit_payroll_period"> 
                            <div class="col-md-5"><label>Payroll Period</label></div>
                            <div class="col-md-7">
                              <select class="form-control" id="edit_s4_val" > 
                                    <?php echo "<option value='not_included'>Not included</option>"; 
                                              foreach ($payroll_period_result as $row) {
                                                $payroll_period_from = $row->month_from."-".$row->day_from."-".$row->year_from;
                                                $payroll_period_to = $row->month_to."-".$row->day_to."-".$row->year_to;
                                                $date_payroll = $payroll_period_from." to ".$payroll_period_to;
                                                if($payroll_period_date == $row->id){ $select ='selected'; } else{ $select=''; }
                                                echo "<option value='".$row->id."' $select >".$date_payroll."</option>";
                                      }
                                    ?>
                             </select>
                            </div>
                          </div>
                      </div>

                      <div class="col-md-6">

                         <div class="col-md-12">  
                          <div class="col-md-5"><label>Allow Employee to view payslip</label></div>
                          <div class="col-md-7">
                            <select class="form-control" onchange="edit_allow(this.value);" id="edit_allow_payroll">
                              <option <?php if($view_payroll=='Yes'){ echo "selected"; } else{}?>>Yes</option>
                              <option <?php if($view_payroll=='No'){ echo "selected"; } else{}?> >No</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-12" style="padding-top: 2px;"> 
                         <div class="col-md-5"><label>Payroll Period Option</label></div>
                          <div class="col-md-7">
                            <select class="form-control" id="edit_payroll_option" >
                              <option value="All" <?php if($payroll_option=='All'){ echo "selected"; } else{}?>>All Payroll Period</option>
                              <option <?php if($payroll_option=='Before'){ echo "selected"; } else{}?>>Before</option>
                              <option <?php if($payroll_option=='After'){ echo "selected"; } else{}?>>After</option>
                            </select>
                          </div>
                        </div>
                        
                          <div class="col-md-12" style="padding-top: 10px;">
                          <div class="col-md-6"></div>
                          <div class="col-md-3" ><button class="btn btn-success" onclick="save_editsetting_payrollperiod('<?php echo $payroll_setting4_id?>','<?php echo $payroll_main_id?>');">UPDATE</button></div>
                           <div class="col-md-3"> <button class="btn btn-danger" onclick="refresh();">BACK</button></div>
                          </div>               
                        </div>