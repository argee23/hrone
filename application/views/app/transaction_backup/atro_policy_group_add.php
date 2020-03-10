
    
                  <div class="col-md-4">
                       <div class="col-md-12"> <n class="text-danger" style="font-weight: bold;">Company :</n> </div><br>
                        <div class="col-md-12">
                          <select class="form-control" onchange="getEmployees('Company',this.value,'-','-','-','-');" id="company">
                         
                          <?php foreach($companyList as $company){?>
                                <option value="<?php echo $company->company_id?>"><?php echo $company->company_name?></option>
                          <?php } ?>
                          </select>
                        </div>
                  </div>
                   <div class="col-md-4">
                       <div class="col-md-12"> <n class="text-danger" style="font-weight: bold;">Policy Type : </n></div><br>
                       <div class="col-md-12">
                          <select class="form-control" id="type" >
                          <option>Select</option>
                            <?php foreach($policy_type as $policy){ 
                              if($policy_main==0){ $d=''; } else{ if($policy->param_id==126 || $policy->param_id==127) {  $d='disabled style="display:none;"';} else{ $d=''; } }?>
                                <option value="<?php echo $policy->param_id?>" <?php echo $d?>><?php echo $policy->cValue?></option>
                            <?php }?>
                          </select></div>
                  </div>
                  
                  <div class="col-md-4">
                       <div class="col-md-12"> <n class="text-danger" style="font-weight: bold;">Group Name : </n></div><br>
                       <div class="col-md-12"><input type="text" class="form-control" id="group_name"><input type="hidden" id="group"></div>
                  </div>

                   <div class="col-md-4">
                       <div class="col-md-12"> <n class="text-danger" style="font-weight: bold;">Division :</n> </div><br>
                        <div class="col-md-12">
                          <select class="form-control" id="division" onchange="getEmployees('Division','-',this.value,'-','-','-');">
                          </select>
                        </div>
                  </div>

                   <div class="col-md-4">
                       <div class="col-md-12"> <n class="text-danger" style="font-weight: bold;">Department :</n> </div><br>
                        <div class="col-md-12">
                          <select class="form-control" id="department" onchange="getEmployees('Department','-','-',this.value,'-','-');">
                          </select>
                        </div>
                  </div>

                   <div class="col-md-4">
                       <div class="col-md-12"> <n class="text-danger" style="font-weight: bold;">Section :</n> </div><br>
                        <div class="col-md-12">
                          <select class="form-control" id="section" onchange="getEmployees('Section','-','-','-',this.value,'-');">
                          </select>
                        </div>
                  </div>

                  <div class="col-md-4">
                       <div class="col-md-12"> <n class="text-danger" style="font-weight: bold;">SubSection :</n> </div><br>
                        <div class="col-md-12">
                          <select class="form-control" id="subsection" onchange="getEmployees('Subsection','-','-','-','-',this.value);">
                          </select>
                        </div>
                  </div>

                 

                 



                 <br><br><br> <br><br><br><br><br><br>
                 <div class="box box-danger" class='col-md-12'></div>
                 <div id="members">
                  <table class="table table-bordered" id="blocked_leave"  style="margin-top:20px;">
                      <thead>
                        <tr class="success">
                          <th></th>
                          <th>Name</th>
                          <th>Company </th>
                          <th>Department</th>
                          <th>Section</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                    </div>
                    <br><br>
                    <button class="btn btn-success pull-right" onclick="save_atro_members();">SAVE GROUP</button>
            </div>
            <div class="btn-group-vertical btn-block"> </div> 
      </div> 
    