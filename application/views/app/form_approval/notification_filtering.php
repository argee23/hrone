 <div class="col-md-12"><br>
      <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
        <div style="height:40px;">
          <div class="col-md-12">

                 <div class='col-md-6'>
                    <div class="col-md-4"><label>Company:</label></div>
                    <div class="col-md-8">
                    <input type="hidden" id="identification" value="<?php echo $type;?>">
                        <select class="form-control" id='Company_result' onchange="loadNotification(this.value)">
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
                        <select class="form-control" id='notification_list' onchange="view_approver_notif(this.value);">
                      
                        </select>
                    </div>
                </div>
               <!-- 
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
                </div> -->

        </div>
      </div>
        <div class="box box-danger" class='col-md-12'></div>
        <div class='col-md-12' style="overflow: auto;" id="filtering_notif">
            <table id="notif_approver" class="col-md-12 table table-hover table-striped">
                <thead>
                  <tr  class="success">
                    <th style="width:15%;">Name</th>
                    <th style="width:15%;">Classification</th>
                    <th style="width:15%;">Location</th>
                    <th style="width:15%;">Section</th>
                    <th style="width:15%;">Subsection</th>
                    <th style="width:10%;">Approval Level</th>
                  </tr>
                </thead>
                <tbody>
               
                </tbody>
       </table>  
       </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div>


     

