 <div class="col-md-12"><br>
      <div id="refresh_flashdata" style="padding-bottom: 20px;"></div>
        <div style="height:auto;">
        <div style="height:50px;">
          <div class="col-md-12">
                <div class='col-md-4'>
                  <div class="col-md-4"><label>Company:</label></div>
                    <div class="col-md-8">
                    <input type='hidden' value='<?php echo $identification?>' id="transfer_identification">
                   <select class="form-control" id='Company_transfer' onchange="loadPending_trans(this.value)">
                             <option selected disabled value='0'>Select Company</option>
                            <?php foreach($companyList as $company){ ?>
                            <option value="<?php echo $company->company_id?>"><?php echo $company->company_name?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class='col-md-6' style="padding-top: 5px;">
                  <div class="col-md-3"><label>Approver:</label></div>
                    <div class="col-md-4">
                        <select class="form-control" id='pending_trans_id'>
                          <option value='0'>Select</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                   <a data-toggle="modal" data-target="#transfer_approverr">
                      <input type='hidden' id='transfer_approver_id' value="0"> 
                      <input type='text' class='form-control' placeholder="Select Employee" id='transfer_approver_name'></a>
                  </div>
                </div>
                <div class='col-md-2' style="padding-top: 5px;">
                    <div class="col-md-12">
                     <button class='btn btn-success' onclick="transfer_pending_approver();">TRANSFER</button>
                  </div>
                </div>
               
        </div>
      </div>
        <div class="box box-danger" class='col-md-12'></div>
        
          <div class="col-md-12" id="for_pending_approval">
            <table id="transfer_approver" class="col-md-12 table table-hover table-striped">
                <thead>
                  <tr  class="success">
                    <th style="width:10%;">Date Filed</th>
                    <th style="width:30%;">Doc No</th>
                    <th style="width:30%;">Employee ID</th>
                    <th style="width:10%;">Employee Name</th>
                    <th style="width:20%;">Approver</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
       </table>  
        </div>
      </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div>
    </div>
    </div> 