<div class="col-md-12">
  <div class="box-body">
    <div class="row">

     
          <div class="col-md-12">
              <div class="form-group">
                <div class="col-sm-4">
                  <p>Employee ID</p>
                </div>
                <div class="col-sm-7">
                  <label>
                      <label><?php echo $employee_employment->employee_id; ?></label>
                  </label>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <div class="col-sm-4">
                  <p>Employee name</p>
                </div>
                <div class="col-sm-7">
                  <label>
                      <label><?php echo $employee_employment->name; ?></label>
                  </label>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <div class="col-sm-4">
                  <p>Company name</p>
                </div>
                <div class="col-sm-7">
                  <label>
                      <label><?php echo $employee_employment->company_name; ?></label>
                  </label>
                </div>
              </div>
            </div>

          </div> 
          </div><!-- /.box-body --> 

            <!-- Salary information -->
          <div id="add_employee_salary">
          <div class="panel panel-info">
              <div class="panel-heading"><strong>SALARY INFORMATION</strong>
                <i class="fa fa-arrow-circle-left fa-2x text-danger pull-right" data-toggle='tooltip' data-placement='right' title='back' onclick="view_employee_salary('<?php echo $employee_employment->employee_id; ?>')"></i>
              </div>
              <div class="box-body">

              <div class="col-md-12">
                  <table class="table table-striped">
                        <tbody>
                          <tr>
                            <td>Effective Date</td>
                            <td>
                                <input type="date" name="effective_date" id="effective_date" class="form-control" style="width:100%;" value="<?php echo $employee_salary->date_effective; ?>">
                            </td>
                            <td>Salary Rate</td>
                            <td>
                                <select class="form-control" name="salary_rate" id="salary_rate">
                                    <?php
                                      foreach($salaryRateList as $rate){
                                      ?>
                                      <option value="<?php echo $rate->salary_rate_id;?>" <?php if($rate->salary_rate_id==$employee_salary->salary_rate){ echo "selected"; }?>><?php echo $rate->salary_rate_name;?></option>
                                    <?php }?>
                                </select>
                            </td>
                          </tr>
                          <tr>
                            
                          </tr>
                          <tr>
                            <td>Salary Amount</td>
                            <td>
                                <input type="number" name="sal_amount" id="sal_amount" class="form-control" style="width:100%;" value="<?php echo $employee_salary->salary_amount; ?>">
                            </td>
                            <td>No. of Hours</td>
                            <td>
                                 <input type="number" name="no_hours" id="no_hours" class="form-control" style="width:100%;" value="<?php echo $employee_salary->no_of_hours; ?>">
                            </td>
                          </tr>
                          <tr>
                           
                          </tr>
                          <tr>
                            <td>No. of Days Monthly</td>
                            <td>
                                <input type="number" name="no_month" id="no_month" class="form-control" style="width:100%;" value="<?php echo $employee_salary->no_of_days_monthly; ?>">
                            </td>
                            <td>No. of Days Yearly</td>
                            <td>
                                <input type="number" name="no_yrs" id="no_yrs" class="form-control" style="width:100%;" value="<?php echo $employee_salary->no_of_days_yearly; ?>">
                            </td>
                          </tr>
                          <tr>
                           
                          </tr>
                          <tr>
                            <td>Reason</td>
                            <td>
                                <select class="form-control" name="reason" id="reason">
                                  <?php
                                      foreach($company_reason as $reason){
                                      ?>
                                      <option value="<?php echo $reason->reason_id;?>" <?php if($reason->reason_id==$employee_salary->reason) { echo "selected"; }?> ><?php echo $reason->reason_title;?></option>
                                  <?php }?>
                                </select>
                            </td>
                            <td>Fixed salary amount</td>
                            <td>
                                <label>Yes <input type="radio" name="fixed" value="1" id="fixed_yes" <?php if($employee_salary->is_salary_fixed == 1){echo 'checked'; }?> > No <input type="radio" name="fixed" id="fixed_no" value="0" <?php if($employee_salary->is_salary_fixed == 0){echo 'checked'; }?>></label>
                            </td>
                          </tr>
                         
                        </tbody>
                        </table>
              </div>
               <div class="col-md-12">
                      <table class="table table-striped">
                        <tbody>
                          <tr>
                            <td style="width:5%" >
                          <?php if($employee_salary->withholding_tax === '1'){?>
                            <input type="checkbox" name="withholding_tax" id="withholding_tax" value="1" checked=""> 
                          <?php } 
                          else{ ?>
                            <input type="checkbox" name="withholding_tax" id="withholding_tax" value="1"> 
                          <?php } ?>
                          </td>
                            <td style="width:20%" ><label>Withholding tax</label></td>
                            <td></td>
                          </tr>

                          <tr>
                            <td style="width:5%" >
                              <?php if($employee_salary->pagibig === '1'){?>
                            <input type="checkbox" name="pagibig" id="pagibig" value="1" checked> 
                          <?php } 
                          else{ ?>
                            <input type="checkbox" name="pagibig" id="pagibig" value="1" >
                          <?php } ?>
                          </td>
                            <td style="width:20%" ><label >Pag-ibig</label></td>
                            <td><p><?php
                            if(!empty($employee_pagibig)){
                                                                    if($employee_pagibig->cut_off_id==1){
                                                                      echo "1st Cutoff Deduction";
                                                                    }elseif($employee_pagibig->cut_off_id==2){
                                                                      echo "2nd Cutoff Deduction";
                                                                    }elseif($employee_pagibig->cut_off_id==6){
                                                                      echo "Per Payday Deduction";
                                                                    }else{

                                                                    }
                            }else{
                              ?>

                              <?php
                              }

                             ?></p></td>
                          </tr>

                          <tr>
                            <td style="width:5%" >
                              <?php 
                              if(!empty($employee_salary)){
                                if($employee_salary->sss === '1'){

                                ?>
                                    <input type="checkbox" name="sss" id="sss" value="1" checked> 
                                <?php
                                }else{
                                ?>
                            <input type="checkbox" name="sss" id="sss" value="1"> 
                                <?php
                                }
                              }else{

                              }

                               ?>
                          </td>
                            <td style="width:20%" ><label >SSS</label></td>
                            <td><p><?php 
                            if(!empty($employee_sss)){
                                                                    if($employee_sss->cut_off_id==1){
                                                                      echo "1st Cutoff Deduction";
                                                                    }elseif($employee_sss->cut_off_id==2){
                                                                      echo "2nd Cutoff Deduction";
                                                                    }elseif($employee_sss->cut_off_id==6){
                                                                      echo "Per Payday Deduction";
                                                                    }else{

                                                                    }
                            }else{

                            }
                            ?></p></td>
                          </tr>
                          
                          <tr>
                            <td style="width:5%" >
                              <?php 

                              if(!empty($employee_salary)){
                                if($employee_salary->philhealth === '1'){
                              ?> 
                                    <input type="checkbox" name="philhealth" id="philhealth" value="1" checked> 
                              <?php
                                }else{
                              ?>
                            <input type="checkbox" name="philhealth" id="philhealth" value="1"> 
                              <?php
                                }
                              }else{
                              ?> 
                            <input type="checkbox" name="philhealth" id="philhealth" value="1"> 
                              <?php
                              }

                              ?>
                          </td>
                            <td style="width:20%" ><label >PhilHealth</label></td>
                            <td><p><?php 
                            if(!empty($employee_philhealth)){
                                                                    if($employee_philhealth->cut_off_id==1){
                                                                      echo "1st Cutoff Deduction";
                                                                    }elseif($employee_philhealth->cut_off_id==2){
                                                                      echo "2nd Cutoff Deduction";
                                                                    }elseif($employee_philhealth->cut_off_id==6){
                                                                      echo "Per Payday Deduction";
                                                                    }else{

                                                                    }
                            }else{

                            }
                            ?></p></td>
                          </tr>

                        </tbody>
                        </table>
                    </div>

             </div>
          </div>
        </div>

        <div class="col-md-12">
            <button class="col-md-12 btn btn-danger btn-sm"  onclick="save_update_salary_information('<?php echo $salary_id;?>','<?php echo $company_id;?>','<?php echo $employee_id;?>');">MODIFY</button>
        </div>

   

    </div>
  </div>
</div>
