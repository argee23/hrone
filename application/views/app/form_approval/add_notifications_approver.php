 <div class="col-md-12"><br>
      <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
        <div style="height:280px;">
          <div class="col-md-12">

                <div class='col-md-6'>
                    <div class="col-md-4"><label>Company:</label></div>
                    <div class="col-md-8">
                    <input type="hidden" id="identification" value="<?php echo $type;?>">
                        <select class="form-control" id='Company_result' onchange="loadDivision(this.value)">
                        <option value="" disabled selected>Select</option>
                            <?php foreach($companyList as $company){?>
                              <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
               
                 <div class='col-md-6'>
                    <div class="col-md-4"><label>Notification:</label></div>
                    <div class="col-md-8">
                    <input type="hidden" id="identification">
                        <select class="form-control" id='notification_list'>
                      
                        </select>
                    </div>
                </div>
               
               <div class='col-md-6' style="padding-top: 2px;">
                  <div class="col-md-4"><label>Classification:</label></div>
                    <div class="col-md-8">
                      <select class="form-control" id="Classification_result">
                        <option value='0'>Select Classification</option>
                      </select>
                  </div>
                </div>

                <div class='col-md-6'  style="padding-top: 2px;">
                  <div class="col-md-4"><label>Location:</label></div>
                    <div class="col-md-8">
                      <select class="form-control" id="Location_result">
                        <option value='0'>Select Location</option>
                      </select>
                  </div>
                </div>

                <div class='col-md-6'  style="padding-top: 3px;">
                  <div class="col-md-4"><label>Division:</label></div>
                    <div class="col-md-8">
                    <select class="form-control" id="Division_result"  onchange="loadDept(this.value)">
                        <option value='0'>Select Division</option>
                        <option value='All'>All</option>
                    </select>
                    </div>
                </div>

                <div class='col-md-6' style="padding-top: 5px;">
                  <div class="col-md-4"><label>Department:</label></div>
                    <div class="col-md-8">
                      <select class="form-control" id="Department_result"  onchange="get_section(this.value)">
                        <option value='0'>Select Department</option>
                        <option value='All'>All</option>
                      </select>
                  </div>
                </div>

                <div class='col-md-6' style="padding-top: 5px;">
                  <div class="col-md-4"><label>Section:</label></div>
                    <div class="col-md-8">
                      <select class="form-control" id="Section_result" onchange="get_subsection(this.value)">
                        <option value='0'>Select Section</option>
                        <option value='All'>All</option>
                      </select>
                  </div>
                </div>

                <div class='col-md-6' style="padding-top: 5px;">
                  <div class="col-md-4"><label>Subsection:</label></div>
                    <div class="col-md-8">
                        <select class="form-control" id="Subsection_result">
                          <option value='0'>Select Subsection</option>
                        <option value='All'>All</option>
                        </select>
                    </div>
                </div>

               <div class='col-md-6' style="padding-top: 5px;">
                  <div class="col-md-4"><label>Select Approver:</label></div>
                    <div class="col-md-8">
                      <a data-toggle="modal" data-target="#add_approver_trans">
                      <input type='hidden' id='addnew_approver_id' value="0"> 
                      <input type='hidden' id='addnew_approver_position' value="0"> 
                      <input type='text' class='form-control' placeholder="Select Employee" id='addnew_approver_name'></a>
                  </div>
                </div>


                <div class='col-md-6' style="padding-top: 5px;">
                  <div class="col-md-4"><label>Approval Level:</label></div>
                    <div class="col-md-3">
                    <select class="form-control" id="Approval_result">
                         <option value="set">Set As</option>
                        <option value="align">Align On</option>
                    </select>
                  </div>
                  <div class="col-md-5">
                     <select class="form-control" id="Approvernum_result"> 
                        <option value="0">Select</option>
                      </select>
                  </div>
                </div>

                  <div class='col-md-6' style="padding-top: 5px;">
                  <div class="col-md-4"><label>Option:</label></div>
                    <div class="col-md-8">
                      <select class="form-control" id="ApplyOption_result">
                            <option value='this_form'>Apply to this form only</option>
                            <option value='all'>Apply to all form</option>
                      </select>
                  </div>
                </div>
                
                <div class='col-md-12' style="padding-top: 15px;">
                  <div class="col-md-8"></div>
                    <div class="col-md-4">
                      <button class="col-md-5 btn btn-success" style="margin-right:10px;" onclick="save_notification('<?php echo $type;?>');">SAVE</button>
                      <button class="col-md-6 btn btn-danger">BACK</button>
                  </div>
                </div>
        </div>
      </div>
        <div class="box box-danger" class='col-md-12'></div>
        <div class='col-md-12' style="height:230px;overflow: auto;">
       </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div>


     

